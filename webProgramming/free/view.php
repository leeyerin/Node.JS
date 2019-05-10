<? 
	session_start(); 
	include "../lib/dbconn.php";

	$sql = "select * from free where num=$num";
	$result = mysql_query($sql, $connect);
   	 $row = mysql_fetch_array($result);       
	
	$item_num     = $row[num];
	$item_id      = $row[id];
	$item_name    = $row[name];
	$item_hit     = $row[hit];
	$item_good= $row[good];
	$item_date=$row[regist_day];
	$item_subject = str_replace(" ", "&nbsp;", $row[subject]);
	$item_content = $row[content];
	$is_html      = $row[is_html];

	if ($is_html!="y")
	{
		$item_content = str_replace(" ", "&nbsp;", $item_content);
		$item_content = str_replace("\n", "<br>", $item_content);
	}	

	
	$new_hit = $item_hit + 1;
	$sql = "update free set hit=$new_hit where num=$num";   // 글 조회수 증가시킴
	mysql_query($sql, $connect);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<meta charset="euc-kr">
<link href="../css/common.css" rel="stylesheet" type="text/css" media="all">
<link href="../css/free.css" rel="stylesheet" type="text/css" media="all">
<script>
	
    function del(href) 
    {
        if(confirm("정말 삭제?")) {
                document.location.href = href;
        }
    }
</script>
</head>

<body>
<div id="wrap">
  <div id="header">
    <? include "../lib/top_login3.php"; ?>
  </div> 

  <div id="menu">
	<? include "../lib/top_menu2.php"; ?>
  </div>  <!-- end of menu --> 

  <div id="content">
	<div id="col2">        
	
		<div id="view_comment"> &nbsp;</div>
		<div id="view_title">
			<div id="view_title1"><?= $item_subject ?></div>
<div id="view_title2"><?= $item_name ?> | 조회 : <?= $item_hit ?> | 좋아요 : <?=$item_good ?> 
			                      | <?= $item_date ?> </div>	
		</div>

		<div id="view_content">
<?= $item_content ?>
</div>

		<div id="view_button">
				<a href="list.php?page=<?=$page?>"><img src="../img/list.gif"></a>&nbsp;
<? 
	if($userid==$item_id or $userid=="admin")
	{
?>
				<a href="modify_form.php?num=<?=$num?>&page=<?=$page?>"><img src="../img/modify.gif"></a>&nbsp;
				<a href="javascript:del('delete.php?num=<?=$num?>')"><img src="../img/delete.gif"></a>&nbsp;
<?
	}
?>
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

</body>
</html>
