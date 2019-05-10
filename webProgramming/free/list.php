<?
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HT,; 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta charset="euc-kr">
<link href="../css/common.css"rel="stylesheet" type="text/css" media="all">
<link href="../css/free.css"rel="stylesheet" type="text/css" media="all">
<style>
{margin : 0 ; padding: 0;}
#list_search11{
margin :  0 auto;
width : 960px;}

#list_top_title{
margin : 0 auto;
width : 960px;

}
#list_content{
margin : 0 auto;
width : 960px;
}
#list_search{
margin : 0 auto;
width : 960px;
}
</style>
</head>
<?
 include "../lib/dbconn.php";

$scale=10;
if($mode=="search")
{
if(!$search)
{
echo ("
<script>
window.alert('검색할 단어를 입력해 주세요!');
history.go(-1)
</script>
");
exit;
}

$sql="select * from free where $find like '$search%' order by num desc";
}
else{
$sql="select * from free order by num desc";
}

$result= mysql_query($sql,$connect);
$total_record= mysql_num_rows($result);
if($total_record % $scale==0)

$total_page=floor($total_record/$scale);
else
$total_page=floor($total_record/$scale) +1;

if(!$page)
$page=1;

$start=($page-1) * $scale;
$number=$total_record - $start;
?>
<body>
<div id="wrap">
<div id="header">
 <? include "../lib/top_login3.php";?>
</div>

<div id="menu">
 <? include "../lib/top_menu2.php"; ?>
</div>

<div id="content">
<div id="col1">
<div id="left_menu">
 <? include "../lib/left_menu.php"; ?>
</div>
</div>
<div id="col2">
<div id="list_search11">
<div id="list_search1"> ▶ 욕설 금지! 벌써 12월 >ㅁ<
<div id="title">
 자유게시판 &nbsp;&nbsp;
</div></div>
</div>

<form name="board_form" method="post" action="list.php? mode="search">

<div id="list_search">
<div id="list_search2">
<select name="find">
 <option value='subject'>제목</option>
 <option value='content'>내용</option>
<option value='name'>작성자명</option>
 </select></div>
<div id="list_search3">&nbsp;<input type="text" name="search"></div>
<div id="list_search4">&nbsp;<input type="image" src="../img/list_search_button.gif"></div>
</div>
</form>


<div class="clear"></div>
<div id="list_top_title">
 <ul>
<li id="list_title1">글번호</li>
<li id="list_title2">subject</li>
<li id="list_title5">조회수</li>
<li id="list_title4">날짜</li>
<li id="list_title3">name</li>
</ul>
</div>

<div id="list_content">
<?
for($i=$start ; $i<$start+$scale && $i<$total_record; $i++)
{
mysql_data_seek($result,$i);
$row=mysql_fetch_array($result);

$item_num=$row[num];
$item_id=$row[id];
$item_name=$row[name];
$item_hit=$row[hit];
$item_date=$row[regist_day];
$item_date=substr($item_date,0,10);
$item_subject=str_replace(" ","&nbsp;",$row[subject]);
?>

<div id="list_item">
<div id="list_item1"><?= $number ?></div>
<div id="list_item2"><a href="view.php?num=<?= $item_num ?> &page=<?=$page ?>"><?= $item_subject ?></a></div>
<div id="list_item4"><?= $item_hit ?></div>
<div id="list_item5"><?= $item_date ?></div>
<div id="list_item6"><?= $item_name ?></div>
</div>




<?
echo $subject;
?>
<? $number--;
}
?>
<div id="page_button">
<div id="page_num">
<?
for($i=1 ; $i<=$total_page; $i++){
if($page==$i)
{
echo "<b> $i </b>";
}
else
{
echo "<a href='list.php?page=$i'> $i </a>";
}
}
?>

&nbsp;&nbsp;&nbsp;&nbsp;다음▶
</div>
<div id="button">
<a href="list.php?page=<?=$page?>"><img src="../img/list.gif"></a>
<?
if($userid)
{
?>
<a href="write_form.php"><img src="../img/write.gif"></a>
<?
}
?>
</div>
</div>
</div>
</div>
<div>
</div>

</body>
</html>
