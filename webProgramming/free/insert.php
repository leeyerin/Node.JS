<?
session_start();
?>
<meta charset="euc-kr">
<?
if(!$userid)
{
echo ("
<script>
 window.alert('�α��� �� �̿����ּ���.')
 history.go(-1)
</script>
");
exit;
}

if(!$subject)
{
echo ("
<script>
window.alert('������ �Է��ϼ���.')
history.go(-1) 
</script>
");
exit;
}
if(!$content)
{
echo ("
<script>
window.alert('������ �Է����ּ���.')
history.go(-1)
</script>
");
exit;
}

$regist_day=date("Y-m-d (H:i)");
include "../lib/dbconn.php";

if($mode=="modify")
{
$sql="update free set subject='$subject', content='$content' where num=$num";
}
else
{
if($html_ok=="y")
{
$is_html="y";
}
else
{
$is_html=" ";
$content=htmlspecialchars($content);
}

$sql="insert into free (id,name,subject,content,regist_day,hit,good,is_html)";
$sql.="values ('$userid','$username','$subject','$content','$regist_day',0,0,'$is_html')";
}
mysql_query($sql,$connect);
mysql_close();

echo("
<script>
location.href='list.php?page=$page';
</script>
");
?>