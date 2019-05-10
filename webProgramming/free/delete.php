<?
session_start();

include "../lib/dbconn.php";

$sql = "delete from free where num=$num";
mysql_query($sql, $connect);

mysql_close();

echo ("
<script>
location.href ='list.php';
</script>
");
?>