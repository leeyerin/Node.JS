<?
           session_start();
?>
<meta charset="euc-kr">
<?
   // ����ȭ�鿡�� �̸��� �Էµ��� �ʾ����� "�̸��� �Է��ϼ���"
   // �޽��� ���
   if(!$id) {
     echo("
           <script>
             window.alert('���̵� �Է��ϼ���.')
             history.go(-1)
           </script>
         ");
         exit;
   }

   if(!$password) {
     echo("
           <script>
             window.alert('��й�ȣ�� �Է��ϼ���.')
             history.go(-1)
           </script>
         ");
         exit;
   }

   include "../lib/dbconn.php";

  $sql="select * from member where id='$id'";
 $result=mysql_query($sql,$connect);
 $num_match=mysql_num_rows($result);

if(!$num_match)
{
echo ("
<script>
window.alert('��ϵ��� ���� ���̵� �Դϴ�.');
history.go(-1)
</script>
");
}
else
{
$row=mysql_fetch_array($result);
$db_pass=$row[password];

if($password!=$db_pass)
{
echo ("
<script>
window.alert('��й�ȣ�� Ʋ���ϴ�.')
history.go(-1)
</script>
");
exit;
}
else
{
$userid=$row[id];
$username=$row[name];

$_SESSION['userid']=$userid;
$_SESSION['username']=$username;

echo ("
<script>
location.href='../index1.php';
</script>
");
}
}
?>