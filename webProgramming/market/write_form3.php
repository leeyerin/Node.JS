<? 
	session_start(); 
	include "../lib/dbconn.php";

	if ($mode=="modify")
	{
		$sql = "select * from $table where num=$num";
		$result = mysql_query($sql, $connect);

		$row = mysql_fetch_array($result);       
	
		$item_subject     = $row[subject];
		$item_content     = $row[content];

		$item_file_0 = $row[file_name_0];
		$item_file_1 = $row[file_name_1];
		$item_file_2 = $row[file_name_2];

		$copied_file_0 = $row[file_copied_0];
		$copied_file_1 = $row[file_copied_1];
		$copied_file_2 = $row[file_copied_2];
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<meta charset="euc-kr">
<link href="../css/common.css" rel="stylesheet" type="text/css" media="all">
<link href="../css/market2.css" rel="stylesheet" type="text/css" media="all">
<script>
  function check_input()
   {
      if (!document.board_form.subject.value)
      {
          alert("������ �Է��ϼ���!");    
          document.board_form.subject.focus();
          return;
      }

      if (!document.board_form.content.value)
      {
          alert("������ �Է��ϼ���!");    
          document.board_form.content.focus();
          return;
      }
      document.board_form.submit();
   }
</script>
</head>

<body>
<div id="wrap">

  <div id="header">
    <? include "../lib/top_login3.php"; ?>
  </div>  <!-- end of header -->

  <div id="menu">
	<? include "../lib/top_menu2.php"; ?>
  </div>  <!-- end of menu --> 

  <div id="content">
	<div id="col1">
		<div id="left_menu">
<?
			include "../lib/left_menu.php";
?>
		</div>
	</div> <!-- end of col1 -->

	<div id="col2">
        


<?
	if($mode=="modify")
	{

?>
		<form  name="board_form" method="post" action="insert.php?mode=modify&num=<?=$num?>&page=<?=$page?>&table=<?=$table?>" enctype="multipart/form-data"> 
<?
	}
	else
	{
?>
		<form  name="board_form" method="post" action="insert.php?table=<?=$table?>" enctype="multipart/form-data"> 
<?
	}
?> 

		<div id="write_form">
		<br><br>
			<div class="write_line"></div>
			<div id="write_row1"><div class="col1"> �ۼ��ڸ� </div><div class="col2"><?=$username?></div>
<?
	if( $userid && ($mode != "modify") )
	{
?>
				<div class="col3"><input type="checkbox" name="html_ok" value="y"> HTML ����</div>
<?
	}
?>						
			</div>
			<div class="write_line"></div>
			<div id="write_row2"><div class="col1"> subject   </div>
			                     <div class="col2"><input type="text" name="subject" value="<?=$item_subject?>" ></div>
			</div>
			<div class="write_line"></div>
			<div id="write_row3"><div class="col1"> content   </div>
			                     <div class="col2"><textarea rows="15" cols="79" name="content"><?=$item_content?></textarea></div>
			</div>

<div style = "height:100px; background-color:#FFFFFF; margin-left:400px;">
			  imagefile1 &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; <input type="file" name="upfile[]">
<? 	if ($mode=="modify" && $item_file_0)
	{
?>
			<div class="delete_ok"><?=$item_file_0?> ������ ��ϵǾ� �ֽ��ϴ�. <input type="checkbox" name="del_file[]" value="0"> ����</div>
			<div class="clear"></div>
<?
	}
?>
			<br><br>  imagefile2 &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;  <input type="file" name="upfile[]">

<? 	if ($mode=="modify" && $item_file_1)
	{
?>
			<div class="delete_ok"><?=$item_file_1?> ������ ��ϵǾ� �ֽ��ϴ�. <input type="checkbox" name="del_file[]" value="1"> ����</div>
			<div class="clear"></div>
<?
	}
?>

			<br><br>  imagefile3 &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; <input type="file" name="upfile[]">
			</div>

<? 	if ($mode=="modify" && $item_file_2)
	{
?>
			<div class="delete_ok"><?=$item_file_2?> ������ ��ϵǾ� �ֽ��ϴ�. <input type="checkbox" name="del_file[]" value="2"> ����</div>
			<div class="clear"></div>
<?
	}
?>

			<div class="clear"></div>
		</div>

		<div id="write_button"><a href="#"><img src="../img/ok.gif" onclick="check_input()"></a>&nbsp;
								<a href="list.php?table=<?=$table?>&page=<?=$page?>"><img src="../img/list.gif"></a>
		</div>

		</form>

	</div> <!-- end of col2 -->
  </div> <!-- end of content -->
</div> <!-- end of wrap -->

</body>
</html>
