<?
session_start();
?>
<!DOCTYPE HTML PUBLIC "-W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta charset="euc-kr">
<link href="../css/common.css" rel="stylesheet"type="text/css" media="all">
<link href="../css/free.css" rel="stylesheet" type="text/css" media="all">
</head>

<body>
<div id="wrap">
<div id="header">
 <? include "../lib/top_login3.php";?>
</div>

<div id="menu"> 
 <?include "../lib/top_menu2.php"; ?>
</div>

<div id="content">
<div id="col1">
<div id="left_menu">
 <? include "../lib/left_menu.php"; ?>
</div>
</div>
<div id="col2">
<form name="board_form" method="post" action="insert.php">
<div id="write_form">
<br><br>
			<div class="write_line"></div>
			<div id="write_row1"><div class="col1"> 작성자명 </div><div class="col2"><?=$username?></div>
<div class="col3"><input type="checkbox" name="html_ok" value="y"> HTML 쓰기</div></div>

<div id="write_row2">
<div class="col1"> subject   </div>
			                     <div class="col2"><input type="text" name="subject" value="<?=$item_subject?>" ></div>
</div>
<div class="write_line"></div>
<div id="write_row3">
<div class="col1"> content   </div>
			                     <div class="col2"><textarea rows="15" cols="79" name="content"></textarea></div>
</div>
<div class="write_line"></div>
</div>

<div id="write_button"><input type="image" src="../img/ok.gif">&nbsp;
<a href="list.php"><img src="../img/list.gif"></a>
</div>
</form>

</div>
</div>
</div>
</body>
</html>