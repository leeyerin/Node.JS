var oracledb = require('oracledb');
const express = require('express');
var querystring = require('querystring')

var dbConfig = require('./config/dbConfig.js');
var result_data;
var context;

var cheerio = require('cheerio');
var request = require('request');
var urlType = require('url');
var async = require('async');
var formidable = require("formidable");
var fs = require('fs-extra');
var static = require('serve-static');
var path = require('path');

var app = express();
var con = 0;

//session미들웨어
var expressSession = require('express-session');
app.use(expressSession({
    secret: 'my key',
    resave: true,
    saveUninitialized: true
}));
app.use(static(path.join(__dirname,'public')));
oracledb.autoCommit = true;
let resultArr = [];

app.post('/signup', function(req,res) {
    console.log('sign up');
    req.on('data', function (data) {
    var inputData = JSON.parse(data);
        oracledb.getConnection(
        {
          user          : dbConfig.user,
          password      : dbConfig.password,
          connectString : dbConfig.connectString
        },
        function(err, connection)
        {
          if (err) {
            console.error(err.message);
            return;
          }

            console.log('==> PRODUCTS 테이블 insert query');

            var query = "INSERT INTO android_member(usermail, password, password_confirm) " +
                "VALUES ('"+inputData.user_sign_id+"','"+inputData.user_sign_password+"', '"+inputData.user_sign_password_confirm+"')";


            connection.execute(query, function(err, result) {
                if(err) {
                    console.error(err.message);
                    doRelease(connection);
                    return;
                }
                console.log('Rows Insert: ' + result.rowsAffected);
                doRelease(connection, result.rowsAffected);
            });
          });
        });
          function doRelease(connection, result) {
            connection.close(function (err) {
                if (err) {
                    console.error(err.message);
                    return;
                }
                console.log('추가 성공');
            });
        };
        res.send("ok");

        });




app.post('/login', function (req, res) {
    console.log("who get in here/users");
    var inputData;
    var big = new Object();
    var testlist = new Array();
    req.on('data', function (data) {
        inputData = JSON.parse(data);
        console.log(inputData);
        oracledb.getConnection(
            {
                user: dbConfig.user,
                password: dbConfig.password,
                connectString: dbConfig.connectString
            },
            function (err, connection) {
                if (err) {
                    console.error(err.message);
                    return;
                }

                console.log('==> android_member 테이블 select query');

                var query = "select usermail from android_member where usermail='" + inputData.user_id + "' and password='" + inputData.user_password+"'";


                console.log(query);

                connection.execute(query, function (err, result) {
                    if (err) {
                        console.log(err.message);
                        doRelease(connection);
                        return;
                    }
                    if (result.rows.length == 0) {
                        return;
                    }
                    doRelease(connection, result.rows);
                });


            });
    });
    function doRelease(connection, result) {
        connection.close(function (err) {
            if (err) {
                console.log(err.message);
            }
        });

        console.log(result);
        var data = new Object();
        data.id = result[0][0];
        testlist.push(data);

        big.data = testlist;
        console.log(big);
        res.json(big);
        
    };

});

//자유게시판 - 취준생 insert
app.post('/process/freeboardPriv',function(req,res){ 

    console.log("Request upload!");
    var today = new Date();
    var month = today.getMonth()+1;
    var day = today.getDate();
    var year = today.getFullYear();
    var inputDate = year+"/"+month+"/"+day; 

    console.log(today);
    var name = "";
    var title ="";
    var content = "";
    var filePath = "";
    var form = new formidable.IncomingForm();
    
    form.parse(req, function(err, fields, files) {
        title = fields.key_title;
        content = fields.key_content;
        console.log(fields);
        console.log(fields.key_title);
        console.log(fields.key_content);
        console.log(name);
    });

    console.log(name+"DFdfd");
    console.log(title+"SGSGS")
    
    form.on('end', function(fields, files) {
      for (var i = 0; i < this.openedFiles.length; i++) {
        var temp_path = this.openedFiles[i].path;
        var file_name = this.openedFiles[i].name;
        var index = file_name.indexOf('/'); 
        var new_file_name = file_name.substring(index + 1);
         
        var new_location = 'public/uploads/';
        var db_new_location = 'uploads/';
    
        console.log(temp_path);
        file_path = db_new_location+file_name;
        fs.copy(temp_path, new_location + file_name, function(err) { // 이미지 파일 저장하는 부분임
          if (err) {
            console.error(err);
    
            console.log("upload error!");
          }
          else{      
            res.setHeader('Content-Type', 'application/json');
            res.send(JSON.stringify({ result : "success", url : new_location+file_name }, null, 3));
    
            console.log("upload success!");
          }
        });
      }

      //디비에 경로에 맞게 저장해주는 코드 작성하기
      oracledb.getConnection({
        user: dbConfig.user,
        password: dbConfig.password,
        connectString: dbConfig.connectString
      },
      function(err, connection) {
        if (err) {
            console.error(err.message);
            return;
        }

        console.log('==> freeboard 테이블 insert query');

        var query = "insert into freeboard_priv (title,detail,img, cal, nickname) values ('" + title + "','" + content + "','" + file_path + "','"+inputDate+"', 'yerin')";
        console.log(query);



        connection.execute(query, function (err, result) {
            if (err) {
                console.error(err.message);
                return;

            }
            doRelease(connection, result.rowsAffected);
        });

      });
      function doRelease(connection, result) {
        connection.close(function (err) {
            if (err) {
                console.error(err.message);
                return;
            }
            console.log('추가 성공');
        });
    };
    
    });
    });

    //자유게시판 - 공시생 insert
    app.post('/process/freeboardPub',function(req,res){ 

        console.log("Request upload!");
        var today = new Date();
        var month = today.getMonth()+1;
        var day = today.getDate();
        var year = today.getFullYear();
        var inputDate = year+"/"+month+"/"+day; 
    
        console.log(today);
        var name = "";
        var title ="";
        var content = "";
        var filePath = "";
        var form = new formidable.IncomingForm();
        
        form.parse(req, function(err, fields, files) {
            title = fields.key_title;
            content = fields.key_content;
            console.log(fields);
            console.log(fields.key_title);
            console.log(fields.key_content);
            console.log(name);
        });
    
   
        form.on('end', function(fields, files) {
          for (var i = 0; i < this.openedFiles.length; i++) {
            var temp_path = this.openedFiles[i].path;
            var file_name = this.openedFiles[i].name;
            var index = file_name.indexOf('/'); 
            var new_file_name = file_name.substring(index + 1);
             
            var new_location = 'public/uploads/';
            var db_new_location = 'uploads/';
        
            console.log(temp_path);
            file_path = db_new_location+file_name;
            fs.copy(temp_path, new_location + file_name, function(err) { // 이미지 파일 저장하는 부분임
              if (err) {
                console.error(err);
        
                console.log("upload error!");
              }
              else{      
                res.setHeader('Content-Type', 'application/json');
                res.send(JSON.stringify({ result : "success", url : new_location+file_name }, null, 3));
        
                console.log("upload success!");
              }
            });
          }
    
          //디비에 경로에 맞게 저장해주는 코드 작성하기
          oracledb.getConnection({
            user: dbConfig.user,
            password: dbConfig.password,
            connectString: dbConfig.connectString
          },
          function(err, connection) {
            if (err) {
                console.error(err.message);
                return;
            }
    
            console.log('==> freeboardPub 테이블 insert query');
    
            var query = "insert into freeboardPub (title,detail,img, cal, nickname) values ('" + title + "','" + content + "','" + file_path + "','"+inputDate+"', 'yerin')";

            console.log(query);
    
    
    
            connection.execute(query, function (err, result) {
                if (err) {
                    console.error(err.message);
                    return;
    
                }
                doRelease(connection, result.rowsAffected);
            });
    
          });
          function doRelease(connection, result) {
            connection.close(function (err) {
                if (err) {
                    console.error(err.message);
                    return;
                }
                console.log('추가 성공');
            });
        };
        
        });
        });

    //후기 공유 게시판 insert
    app.post('/process/infoshare',function(req,res){ 

        console.log("Request upload!");
        var today = new Date();
        var month = today.getMonth()+1;
        var day = today.getDate();
        var year = today.getFullYear();
        var inputDate = year+"/"+month+"/"+day; 
    
        console.log(today);
        var name = "";
        var title ="";
        var content = "";
        var filePath = "";
        var form = new formidable.IncomingForm();
        
        form.parse(req, function(err, fields, files) {
            title = fields.key_title;
            content = fields.key_content;
            console.log(fields);
            console.log(fields.key_title);
            console.log(fields.key_content);
            console.log(name);
        });
    
        
        form.on('end', function(fields, files) {
          for (var i = 0; i < this.openedFiles.length; i++) {
            var temp_path = this.openedFiles[i].path;
            var file_name = this.openedFiles[i].name;
            var index = file_name.indexOf('/'); 
            var new_file_name = file_name.substring(index + 1);
             
            var new_location = 'public/uploads/';
            var db_new_location = 'uploads/';
        
            console.log(temp_path);
            file_path = db_new_location+file_name;
            fs.copy(temp_path, new_location + file_name, function(err) { // 이미지 파일 저장하는 부분임
              if (err) {
                console.error(err);
        
                console.log("upload error!");
              }
              else{      
                res.setHeader('Content-Type', 'application/json');
                res.send(JSON.stringify({ result : "success", url : new_location+file_name }, null, 3));
        
                console.log("upload success!");
              }
            });
          }
    
          //디비에 경로에 맞게 저장해주는 코드 작성하기
          oracledb.getConnection({
            user: dbConfig.user,
            password: dbConfig.password,
            connectString: dbConfig.connectString
          },
          function(err, connection) {
            if (err) {
                console.error(err.message);
                return;
            }
    
            console.log('==> infoshare 테이블 insert query');
    
            var query = "insert into infoshare (title,detail,img, cal, nickname) values ('" + title + "','" + content + "','" + file_path + "','"+inputDate+"', 'yerin')";

            console.log(query);
    
    
    
            connection.execute(query, function (err, result) {
                if (err) {
                    console.error(err.message);
                    return;
    
                }
                doRelease(connection, result.rowsAffected);
    
            });
    
          });
          function doRelease(connection, result) {
            connection.close(function (err) {
                if (err) {
                    console.error(err.message);
                    return;
                }
                console.log('추가 성공');
            });
        };
        
        });
        });
        

        app.post('/process/testCalendar',function(req,res){ 

            console.log("Request upload!");
            var today = new Date();
            var month = today.getMonth()+1;
            var day = today.getDate();
            var year = today.getFullYear();
            var inputDate = year+"/"+month+"/"+day; 
        
            console.log(today);
            var name = "";
            var title ="";
            var content = "";
            var filePath = "";
            var form = new formidable.IncomingForm();
            
            form.parse(req, function(err, fields, files) {
                title = fields.key_title;
                content = fields.key_content;
                console.log(fields);
                console.log(fields.key_title);
                console.log(fields.key_content);
                console.log(name);
            });
        
            
            form.on('end', function(fields, files) {
              for (var i = 0; i < this.openedFiles.length; i++) {
                var temp_path = this.openedFiles[i].path;
                var file_name = this.openedFiles[i].name;
                var index = file_name.indexOf('/'); 
                var new_file_name = file_name.substring(index + 1);
                 
                var new_location = 'public/uploads/';
                var db_new_location = 'uploads/';
            
                console.log(temp_path);
                file_path = db_new_location+file_name;
                fs.copy(temp_path, new_location + file_name, function(err) { // 이미지 파일 저장하는 부분임
                  if (err) {
                    console.error(err);
            
                    console.log("upload error!");
                  }
                  else{      
                    res.setHeader('Content-Type', 'application/json');
                    res.send(JSON.stringify({ result : "success", url : new_location+file_name }, null, 3));
            
                    console.log("upload success!");
                  }
                });
              }
        
              //디비에 경로에 맞게 저장해주는 코드 작성하기
              oracledb.getConnection({
                user: dbConfig.user,
                password: dbConfig.password,
                connectString: dbConfig.connectString
              },
              function(err, connection) {
                if (err) {
                    console.error(err.message);
                    return;
                }
        
                console.log('==> testCalendar 테이블 insert query');
        
                var query = "insert into testCalendar (title,detail,img, cal, nickname) values ('" + title + "','" + content + "','" + file_path + "','"+inputDate+"', 'yerin')";
      
                console.log(query);
        
        
        
                connection.execute(query, function (err, result) {
                    if (err) {
                        console.error(err.message);
                        return;
        
                    }
                    doRelease(connection, result.rowsAffected);
        
                });
        
              });
              function doRelease(connection, result) {
                connection.close(function (err) {
                    if (err) {
                        console.error(err.message);
                        return;
                    }
                    console.log('추가 성공');
                });
            };
            
            });
            });
    
app.post('/diary_insert', function (req, res) {
    console.log("다이어리 항목 추가");
    var inputData;
    req.on('data', function (data) {
        inputData = JSON.parse(data);
        oracledb.getConnection(
            {
                user: dbConfig.user,
                password: dbConfig.password,
                connectString: dbConfig.connectString
            },
            function (err, connection) {
                if (err) {
                    console.error(err.message);
                    return;
                }

                console.log('==> diary 테이블 insert query');

                var query = "insert into diary (title,content,today) values ('" + inputData.diary_title + "','" + inputData.diary_content + "','" + inputData.diary_date + "')";
   
                console.log(query);



                connection.execute(query, function (err, result) {
                    if (err) {
                        console.error(err.message);
                        //doRelease(connection);
                        return;

                    }
                    doRelease(connection, result.rowsAffected);
                });


            });
    });
    function doRelease(connection, result) {
        connection.close(function (err) {
            if (err) {
                console.error(err.message);
                return;
            }
            console.log('추가 성공');
        });
    };

});

app.post('/insert/freeboard_pub', function (req, res) {
    console.log('사기업 insert');
    var inputData;

    req.on('data', function (data) {
        inputData = JSON.parse(data);
        oracledb.getConnection(
            {
                user: dbConfig.user,
                password: dbConfig.password,
                connectString: dbConfig.connectString
            },
            function (err, connection) {
                if (err) {
                    console.log(err.message);
                    return;
                }

                console.log('freeboard_pub 테이블 insert query');

                var query = "insert into freeboard_pub (id,title,detail,write_date) values ('" + inputData.id + "','" + inputData.title + "'," + inputData.detail + "'," + inputData.date + "')"
                connection.execute(query, function (err, result) {
                    if (err) {
                        console.log(err.message);
                        doRelease(connection);
                        return;
                    }
                    doRelease(connection, result.rowsAffected);
                });
            });
    });

    req.on('end')
    function doRelease(connection, result) {
        connection.close(function (err) {
            if (err) {
                console.error(err.message);
                return;
            }
            console.log('추가 성공 ')
        });
    };
})

app.post('/select/freeboardPub', function(req,res) {
    console.log('공시생 자유게시판');

    /*
    DB : freeboard_priv
    */

    var big = new Object();
    var testlist = new Array();

       // 디비 연결 객체를 가져오는 것
       oracledb.getConnection(
        {
            user: dbConfig.user,
            password: dbConfig.password,
            connectString: dbConfig.connectString
        },
        function (err, connection) {
            if (err) {
                console.error(err.message);
                return;
            }

            var query = "select title,detail,img,cal,nickname from freeboardPub";
            console.log(query);

            connection.execute(query, function (err, result) {
                if (err) {
                    console.error(err.message);
                    doRelease(connection);
                    return;
                }
                // 결과 쿼리가 존재하지 않을 때
                if (result.rows.length == 0) {
                    writeNoExisted();
                    return;
                }


                doRelease(connection, result.rows);
            });
        });

        function doRelease(connection, result) {
            connection.close(function (err) {
                if (err) {
                    console.error(err.message);
                }
    
            });
            console.log(result.length);
            for (var i = 0; i < result.length; i++) {
                var data = new Object();
                data.title = result[i][0];
                data.detail = result[i][1]
                data.img = result[i][2];
                data.date = result[i][3];
                data.nickname = result[i][4];
                testlist.push(data);
    
            }
            big.data = testlist;
            console.log(big);
            res.json(big);
        };

})

app.post('/select/testCalendar', function(req,res) {
    console.log('시험일정 게시판')
    /*
    DB : testCalendar
    */
    var big = new Object();
    var testlist = new Array();

       // 디비 연결 객체를 가져오는 것
       oracledb.getConnection(
        {
            user: dbConfig.user,
            password: dbConfig.password,
            connectString: dbConfig.connectString
        },
        function (err, connection) {
            if (err) {
                console.error(err.message);
                return;
            }

            var query = "select title,detail,img,cal,nickname from testCalendar";
            console.log(query);

            connection.execute(query, function (err, result) {
                if (err) {
                    console.error(err.message);
                    doRelease(connection);
                    return;
                }
                // 결과 쿼리가 존재하지 않을 때
                if (result.rows.length == 0) {
                    writeNoExisted();
                    return;
                }


                doRelease(connection, result.rows);
            });
        });

        function doRelease(connection, result) {
            connection.close(function (err) {
                if (err) {
                    console.error(err.message);
                }
    
            });
            console.log(result.length);
            for (var i = 0; i < result.length; i++) {
                var data = new Object();
                data.title = result[i][0];
                data.detail = result[i][1]
                data.img = result[i][2];
                data.date = result[i][3];
                data.nickname = result[i][4];
                testlist.push(data);
    
            }
            big.data = testlist;
            console.log(big);
            res.json(big);
        };

})


app.post('/select/freeboardPriv', function(req,res) {
    console.log('취준생 자유게시판')
    /*
    DB : freeboard_priv
    */
    var big = new Object();
    var testlist = new Array();

       // 디비 연결 객체를 가져오는 것
       oracledb.getConnection(
        {
            user: dbConfig.user,
            password: dbConfig.password,
            connectString: dbConfig.connectString
        },
        function (err, connection) {
            if (err) {
                console.error(err.message);
                return;
            }

            var query = "select title,detail,img,cal,nickname from freeboard_priv";
            console.log(query);

            connection.execute(query, function (err, result) {
                if (err) {
                    console.error(err.message);
                    doRelease(connection);
                    return;
                }
                // 결과 쿼리가 존재하지 않을 때
                if (result.rows.length == 0) {
                    writeNoExisted();
                    return;
                }

                doRelease(connection, result.rows);
            });
        });

        function doRelease(connection, result) {
            connection.close(function (err) {
                if (err) {
                    console.error(err.message);
                }
    
            });
            console.log(result.length);
            for (var i = 0; i < result.length; i++) {
                var data = new Object();
                data.title = result[i][0];
                data.detail = result[i][1]
                data.img = result[i][2];
                data.date = result[i][3];
                data.nickname = result[i][4];
                testlist.push(data);
    
            }
            big.data = testlist;
            console.log(big);
            res.json(big);
        };

})

app.post('/select/infoshare', function(req,res) {
    console.log('후기 공유 게시판')
    /*
    DB : freeboard_priv
    */
    var big = new Object();
    var testlist = new Array();

       // 디비 연결 객체를 가져오는 것
       oracledb.getConnection(
        {
            user: dbConfig.user,
            password: dbConfig.password,
            connectString: dbConfig.connectString
        },
        function (err, connection) {
            if (err) {
                console.error(err.message);
                return;
            }

            var query = "select title,detail,img,cal,nickname from infoshare";
            console.log(query);

            connection.execute(query, function (err, result) {
                if (err) {
                    console.error(err.message);
                    doRelease(connection);
                    return;
                }
                // 결과 쿼리가 존재하지 않을 때
                if (result.rows.length == 0) {
                    writeNoExisted();
                    return;
                }

                doRelease(connection, result.rows);
            });
        });

        function doRelease(connection, result) {
            connection.close(function (err) {
                if (err) {
                    console.error(err.message);
                }
    
            });
            console.log(result.length);
            for (var i = 0; i < result.length; i++) {
                var data = new Object();
                data.title = result[i][0];
                data.detail = result[i][1]
                data.img = result[i][2];
                data.date = result[i][3];
                data.nickname = result[i][4];
                testlist.push(data);
    
            }
    
            big.data = testlist;
            console.log(big);
            res.json(big);
        };

})


app.post('/select/diary', function (req, res) {
    console.log('다이어리 select');
    var big = new Object();
    var testlist = new Array();
    var nickname = 'yerin';
    oracledb.getConnection(
        {
            user: dbConfig.user,
            password: dbConfig.password,
            connectString: dbConfig.connectString
        }, function (err, connection) {
            if (err) {
                console.log(err.message);
                return;
            }
            var query = "select title,content,today from diary";
            console.log(query);

            connection.execute(query, function (err, result) {
                if (err) {
                    console.error(err.message);
                    doRelease(connnection);
                    return;
                }

                if (result.rows.length == 0) {
                    return;
                }

                doRelease(connection, result.rows);
            });
        });
    function doRelease(connection, result) {
        connection.close(function (err) {
            if (err) {
                console.log(err.message);
            }
        });

        for (var i = 0; i < result.length; i++) {
            var data = new Object();
            data.title = result[i][0];
            data.detail = result[i][1];
            data.date = result[i][2];
            testlist.push(data);
        }

        big.data = testlist;
        console.log(big);
        res.json(big);
    }
})

//데이터 크롤
app.post('/select/crawl/manager', function (req, res) {
    console.log('사기업 채용정보게시판 들어옴')
    async.waterfall([
        function (cb) {
            var url = 'http://www.jobkorea.co.kr/Starter/?JoinPossible_Stat=0&schOrderBy=0&LinkGubun=0&LinkNo=0&schType=0&schGid=0&Page=2';
           
            request(url, function (error, response, html) {
                console.log(url);
                if (error) { throw error };


                /*
                request 모듈만 사용했을 때는 해당 페이지의 html 문서 전체를 불러올 수 있다.
                그런데 cheerio 모듈을 이용하면 그 중에서도 필요한 정보들만 가져올 수 있다. 
                cheerio 모듈을 사용하면 서버단에서 jQuery 셀렉터를 사용할 수 있는데
                jQuery 기호인 $변수에 cheerio.load() 메소드를 호출한 값을 할당해야 한다.
                또한 cheerio.load()메소드의 인자로 실행결과 데이터를 넘겨준다. 
                */

                var $ = cheerio.load(html);

                let colArr = $(".filterListArea .filterList >li .info .tit >a");

                console.log(colArr.length);
                colArr.each(function () {
                    con++;
                    var src = $(this).attr("href");
                    var title = $(this).text();
                    src = urlType.resolve(url, src);
                    console.log(con + ": " + title);
                    resultArr.push({ title: title, url: src });

                })
                cb(null, resultArr);
            });
        }, function (cb) {
            console.log("resultArr길이 :" + resultArr.length);
            oracledb.getConnection(
                {
                    user: dbConfig.user,
                    password: dbConfig.password,
                    connectString: dbConfig.connectString
                },
                function (err, connection) {
                    if (err) {
                        console.log(err.message);
                        return;
                    }
                    console.log("array 출력")

                    for (var j = 0; j < resultArr.length; j++) {
                        var ts = resultArr[j].title;
                        var sr = resultArr[j].url;
                        console.log(ts.length);
                        var minus = ts.substring(33);
                        console.log(minus);
                        var query = "merge into crawldata using dual on (reference='" + minus + "') " +
                            "when matched then " +
                            "update set " +
                            "TITLE ='" + minus + "', " +
                            "URL ='" + sr + "' " +
                            "when not matched then " +
                            "insert (reference,title,url) values ('" + minus + "', '" + minus + "','" + sr + "')";

                        connection.execute(query, function (err, result) {
                            if (err) {
                                doRelease(connection);
                                return;
                            }
                          
                            
                        });
                       
                    }
                    
                    doRelease(connection);
                });


            function doRelease(connection, result) {

                connection.close(function (err) {
                    if (err) {
                        console.log(err.message);
                        return;
                    }

                    console.log("추가 성공");
                })
            };
            
        }
      
    ])
})

app.post('/select/crawl', function (req, res) {
    var big = new Object();
    var testlist = new Array();
    oracledb.getConnection(
        {
            user: dbConfig.user,
            password: dbConfig.password,
            connectString: dbConfig.connectString
        },
        function (err, connection) {
            if (err) {
                console.log(err.message);
                return;
            }

            var query = "select title , url from crawldata";
            console.log(query);
            connection.execute(query, function (err, result) {
                if (err) {
                    console.log(err.message)
                    doRelease(connection);
                    return;
                }

                doRelease(connection, result.rows);

            });
        });
    function doRelease(connection, result) {
        connection.close(function (err) {
            if (err) {
                console.error(err.message);
            }

        });
        console.log(result.length);
        for (var i = 0; i < result.length; i++) {
            var data = new Object();
            data.title = result[i][0];
            data.url = result[i][1];
            testlist.push(data);
        }

        big.data = testlist;
        console.log(big);
        res.json(big);
    };
})

app.listen(3000, function () {
    console.log("Example app listening on port 3000!");
})
