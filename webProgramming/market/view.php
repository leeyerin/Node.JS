<?
session_start();
include "../lib/dbconn.php";

$sql="select * from $table where num=$num";
$result=mysql_query($sql,$connect);
$row=mysql_fetch_array($result);

$item_num=$row[num];
$item_id=$row[id];
$item_name=$row[name];
$item_hit=$row[hit];
$item_good=$row[good];

$image_name[0]=$row[file_name_0];
$image_name[1]=$row[file_name_1];
$image_name[2]=$row[filel_name_2];

$image_copied[0]=$row[file_copied_0];
$image_copied[1]=$row[file_copied_1];
$image_copied[2]=$row[file_copied_2];

$item_date=$row[regist_day];
$item_subject=str_replace(" ","&nbsp;", $row[subject]);
$item_content=$row[content];
$is_html=$row[is_html];

if($is_html!="y")
{
$item_content=str_replace(" ","&nbsp;",$item_content);
$item_content=str_replace("\n","<br>",$item_content);
}

for($i=0; $i<3; $i++)
{
if($image_copied[$i])
{
$imageinfo=GetImageSize("./data/".$image_copied[$i]);

$image_width[$i]=$imageinfo[0];
$image_height[$i]=$imageinfo[1];
$image_type[$i]=$imageinfo[2];

if($image_width[$i]>785)
$image_width[$i]=785;
}

else
{
$image_width[$i]=" ";
$image_height[$i]=" ";
$image_type[$i]=" ";
}
}

$new_hit=$item_hit +1;
$sql="update $table set hit=$new_hit where num=$num";
mysql_query($sql,$connect);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" " http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta charset="euc-kr">
<link href="../css/common.css" rel="stylesheet" type="text/css" media="all">
<link href="../css/market2.css" rel="stylesheet" type="text/css" media="all">
<script>
function del(href)
{
if(confirm("삭제하시겠습니까?"))
{
document.location.href=href;
}
}
</script>

<style>
{margin : 0 ; padding: 0;}
#view_content{
margin-left:120px;
width : 960px;}


</style>
</head>

<body>
<div id="wrap">
<div id="header">
<?include "../lib/top_login3.php"; ?>
</div>
<div id="menu">
<? include "../lib/top_menu2.php"; ?>
</div>
<br><br>
<div id="content">
<div id="col2">
<div id="view_comment"> &nbsp;</div>
<div id="view_title">
<div id="view_title1"><?=$item_subject ?></div><div id="view_title2"><?= $item_name ?> | 조회:<?= $item_hit ?> |좋아요: <?=$item_good ?> | <?=$item_date ?></div>


<div id="view_content">
<? for($i=0; $i<3; $i++)
{
if($image_copied[$i])
{
$img_name=$image_copied[$i];
$img_name="./data/".$img_name;
$img_width=$image_width[$i];

echo "<img src='$img_name' width='$img_width'>"."<br><br>";
}
}
?>
<?= $item_content ?>
</div>

<div id="view_button">
<a href="list.php?table=<?=$table ?>&page=<? $page ?>"><img src="../img/list.gif">
</a>&nbsp;
<?
if($userid==$item_id || $userid=="admin")
{
?>
<a href="write_form3.php? table=<?=$table?>&mode=modify&num=<?=$num?>&page=<?=$page?>"><img src="../img/modify.gif"></a>&nbsp;
<a href="javascript:del('delete.php?table=<?=$table?>&num=<?=$num?>')">
<img src="../img/delete.gif"></a>&nbsp;
<?
}
?>
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
</body>
</html> 
<