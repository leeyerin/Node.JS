<?
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HT; Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta charset="euc-kr">
<link href="../css/common.css "rel="stylesheet" type="text/css" media="all">
<link href="../css/calendar.css" rel="stylesheet" type="text/css" media="all">
<style>
{margin : 0 ; padding: 0;}
#list_search11{
margin :  0 auto;
width : 960px;}


#list_content{
margin : 0 auto;
width : 960px;
}

</style>
</head>



<? 
include "../lib/dbconn.php";

// 1. ���ϼ� ���ϱ� 
$last_day = date("t", time());  
$sys_year=date("Y");
$sys_month=date("n");
$sys_day=date("j");

// 2. ���ۿ��� ���ϱ� 
$start_week = date("w", strtotime(date("Y-m")."-01")); 

// 3. �� �� ������ ���ϱ� 
$total_week = ceil(($last_day + $start_week) / 7); 

// 4. ������ ���� ���ϱ� 
$last_week = date("w", strtotime(date("Y-m")."-".$last_day)); 




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
<div id="list_search1"> �� �����ϸ� ũ��������~~~
<div id="title">
 ���� &nbsp;&nbsp;
</div>
</div></div>


<div class="clear"></div>
<div id="list_content">
<table width='1000' cellpadding='0' cellspacing='1' bgcolor="#999999"> 
  <tr> 
    <td height="50" align="center" bgcolor="#FFFFFF" colspan="7"><?= $sys_year?>�� <?=$sys_month ?> ��  </td> 
  </tr> 
  <tr> 
    <td height="30" align="center" bgcolor="#D9E5FF">��</td> 
    <td align="center" bgcolor="#D9E5FF">��</td> 
    <td align="center" bgcolor="#D9E5FF">ȭ</td> 
    <td align="center" bgcolor="#D9E5FF">��</td> 
    <td align="center" bgcolor="#D9E5FF">��</td> 
    <td align="center" bgcolor="#D9E5FF">��</td> 
    <td align="center" bgcolor="#D9E5FF">��</td> 
  </tr> 
        
  <? 
    // 5. ȭ�鿡 ǥ���� ȭ���� �ʱⰪ�� 1�� ���� 
    $cal_day=1; 

    // 6. �� �� ���� ���缭 ������ ����� 
    for($i=1; $i <= $total_week; $i++){
?> 
  <tr> 
    <? 
        // 7. �� ����ĭ ����� 
        for ($j=0; $j<7; $j++){ 
    ?> 
    <td height="100" width="100" align="center" bgcolor="#FFFFFF"> 
      <? 
        // 8. ù��° ���̰� ���ۿ��Ϻ��� $j�� �۰ų� ���������̰� $j�� ������ ���Ϻ��� ũ�� ǥ������ �ʾƾ��ϹǷ� 
        //    �� �ݴ��� ��� -  ! ���� ǥ�� - ���� ���ڸ� ǥ���Ѵ�. 
        if (!(($i == 1 && $j < $start_week) || ($i == $total_week && $j > $last_week))){ 

            if($j == 0){ 
                // 9. $j�� 0�̸� �Ͽ����̹Ƿ� ������ 
                echo "<font color='#FF0000'>"; 
            }else if($j == 6){ 
                // 10. $j�� 0�̸� �Ͽ����̹Ƿ� �Ķ��� 
                echo "<font color='#0000FF'>"; 
            }else{ 
                // 11. �׿ܴ� �����̹Ƿ� ������ 
                echo "<font color='#000000'>"; 
            } 

            // 12. ���� ���ڸ� ���� �۾� 
            if($cal_day == date("j")){ 
                echo "<b>"; 
            } 
            
            // 13. ���� ��� 
            echo $cal_day;
			?>
			<br>
			<?
			$sql="select schedule from calendar where year=$sys_year && month=$sys_month && date=$cal_day";
			$result=mysql_query($sql,$connect);
			$row=mysql_fetch_array($result);
			$item_schedule=$row[schedule];
			if($item_schedule)
			{
			echo "$item_schedule";
			}
			
			
			
            if($cal_day == date("j")){ 
                echo "</b>"; 
            } 

            echo "</font>"; 

            // 14. ��¥ ���� 
            $cal_day++; 
        } 
        ?> 
    </td> 
    <?}?> 
  </tr> 
  <?}?> 
</table>
<?
if($userid=="yerin8888"){
?>

<div id="write_button"><a href="schedule_write.php"><img src="../img/schedule_write.gif"></a></div> 
<?
}
?>
</div>
</div>
</div>
</div>
</body>
</html>