<?
session_start();
?>
<meta charset="euc-kr">
<?
 $hp=$hp1."-".$hp2."-".$hp3;
 $email=$email1."@".$email2;
 $regist_day=date("Y-m-d (H:i)");

include "../lib/dbconn.php";

$sql="update member set password ='$password', password_confirm ='$password_confirm',";
$sql.="password_confirm_query='$password_confirm_query', confirm_answer='$confirm_answer' , name ='$name', address='$address', hp='$hp', email='$email', regist_day='$regist_day' where id='$userid'";

mysql_query($sql,$connect);

mysql_close();

echo ("
 <script>
location.href='../index1.php';
 </script>
 ");
?>