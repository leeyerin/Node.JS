<?
session_start();
$table="market";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HT,; 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta charset="euc-kr">
<link href="../css/common.css"rel="stylesheet" type="text/css" media="all">
<link href="../css/market2.css"rel="stylesheet" type="text/css" media="all">
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

$scale=6;
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

$sql="select * from $table where $find like '$search%' order by num desc";
}
else{
$sql="select * from $table order by num desc";
}

$result= mysql_query($sql,$connect);
$total_record= mysql_num_rows($result);
if($total_record % $scale==0)

$total_page=floor($total_record/$scale);
else
$total_page=floor($total_record/$scale) +1;

if(!$page)
$page=1;

$start=($page - 1) * $scale;
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
<div id="list_search1"> ▶ 사진, 업로드의 크기는 500KB를 지켜주세요!
<div id="title">
 프리마켓 &nbsp;&nbsp;
</div></div>
</div>

<form name="board_form" method="post" action="list.php?table=<=$table?>&mode=search">

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



<div id="list_content">
<?

for($i=$start; $i<$start+$scale && $i<$total_record; $i++)
{
mysql_data_seek($result, $i);
$row=mysql_fetch_array($result);

$item_num=$row[num];
$item_id=$row[id];
$item_name=$row[name];
$item_hit=$row[hit];
$item_date=$row[regist_day];
$item_date=substr($item_date,0,10);
$item_subject=str_replace(" ","&nbsp;", $row[subject]);
$item_content=$row[content];
$image_name[0]=$row[file_name_0];
$image_copied[0]=$row[file_copied_0];

if($image_copied[0]){
$imageinfo=GetImageSize("./data/".$image_copied[0]);
$image_width[0]=$imageinfo[0];
$image_height[0]=$imageinfo[1];
$image_type[0]=$imageinfo[2];

if($image_width[0]>250 &&$image_height[0]>250){
$image_width[0]=150;
$image_height[0]=150;
}
else{
$image_width[0]=150;
$image_height[0]=150;
$image_type[0]="";
}
$img_name=$image_copied[0];
$img_name="./data/".$img_name;
$img_width=$image_width[0];
$img_height=$image_height[0];
}

?>
<div id="list_item">
<div id="list_item1">
<?
echo "<img src='$img_name' width='$img_width' height='$img_height'>";
?></div>
<div id="list_item2">

작성자명: <?=$item_name ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


<a href="view.php?table=<?=$table?>&num=<?=$item_num?>&page=<?=$page?>">
제목: <?=$item_subject ?></a> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


조회수: <?=$item_hit ?></div></div>

<?
$number--;
}
?>
<div id="page_button">
<div id="page_num">◀ 이전 &nbsp;&nbsp;&nbsp;&nbsp;
<?
for($i=1; $i<=$total_page; $i++)
{
if($page == $i)
{
echo "<b> $i </b>";
}
else
{
echo "<a href='list.php?table=$table&page=$i'> $i </a>";
}
}
?>
&nbsp;&nbsp;&nbsp;&nbsp;다음▶
</div>
<div id="button">
<a href="list.php?table=<?=$table?>&page=<?=$page?>">
<img src="../img/list.gif"></a>&nbsp;
<?
if($userid)
{
?>
<a href="write_form3.php?table=<?=$table?>"><img src="../img/write.gif"></a>
<?
}
?>
</div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>