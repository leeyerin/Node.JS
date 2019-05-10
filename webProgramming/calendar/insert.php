<?
session_start();
?>
<meta charset="euc-kr">
<?
if(!$userid)
{
echo ("
<script>
 window.alert('로그인 후 이용해주세요.')
 history.go(-1)
</script>
");
exit;
}

if(!$subject)
{
echo ("
<script>
window.alert('제목을 입력하세요.')
history.go(-1) 
</script>
");
exit;
}
if(!$content)
{
echo ("
<script>
window.alert('내용을 입력해주세요.')
history.go(-1)
</script>
");
exit;
}

$regist_day=date("Y-m-d (H:i)");
include "../lib/dbconn.php";


$sql="insert into calendar (year,month,date,schedule)";
$sql.="values ('$year','$month','$date','$subject')";

mysql_query($sql,$connect);
mysql_close();

echo("
<script>
location.href='caltest.php';
</script>
");
?>