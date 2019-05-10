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

// 1. 총일수 구하기 
$last_day = date("t", time());  
$sys_year=date("Y");
$sys_month=date("n");
$sys_day=date("j");

// 2. 시작요일 구하기 
$start_week = date("w", strtotime(date("Y-m")."-01")); 

// 3. 총 몇 주인지 구하기 
$total_week = ceil(($last_day + $start_week) / 7); 

// 4. 마지막 요일 구하기 
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
<div id="list_search1"> ▶ 종강하면 크리스마스~~~
<div id="title">
 일정 &nbsp;&nbsp;
</div>
</div></div>


<div class="clear"></div>
<div id="list_content">
<table width='1000' cellpadding='0' cellspacing='1' bgcolor="#999999"> 
  <tr> 
    <td height="50" align="center" bgcolor="#FFFFFF" colspan="7"><?= $sys_year?>년 <?=$sys_month ?> 월  </td> 
  </tr> 
  <tr> 
    <td height="30" align="center" bgcolor="#D9E5FF">일</td> 
    <td align="center" bgcolor="#D9E5FF">월</td> 
    <td align="center" bgcolor="#D9E5FF">화</td> 
    <td align="center" bgcolor="#D9E5FF">수</td> 
    <td align="center" bgcolor="#D9E5FF">목</td> 
    <td align="center" bgcolor="#D9E5FF">금</td> 
    <td align="center" bgcolor="#D9E5FF">토</td> 
  </tr> 
        
  <? 
    // 5. 화면에 표시할 화면의 초기값을 1로 설정 
    $cal_day=1; 

    // 6. 총 주 수에 맞춰서 세로줄 만들기 
    for($i=1; $i <= $total_week; $i++){
?> 
  <tr> 
    <? 
        // 7. 총 가로칸 만들기 
        for ($j=0; $j<7; $j++){ 
    ?> 
    <td height="100" width="100" align="center" bgcolor="#FFFFFF"> 
      <? 
        // 8. 첫번째 주이고 시작요일보다 $j가 작거나 마지막주이고 $j가 마지막 요일보다 크면 표시하지 않아야하므로 
        //    그 반대의 경우 -  ! 으로 표현 - 에만 날자를 표시한다. 
        if (!(($i == 1 && $j < $start_week) || ($i == $total_week && $j > $last_week))){ 

            if($j == 0){ 
                // 9. $j가 0이면 일요일이므로 빨간색 
                echo "<font color='#FF0000'>"; 
            }else if($j == 6){ 
                // 10. $j가 0이면 일요일이므로 파란색 
                echo "<font color='#0000FF'>"; 
            }else{ 
                // 11. 그외는 평일이므로 검정색 
                echo "<font color='#000000'>"; 
            } 

            // 12. 오늘 날자면 굵은 글씨 
            if($cal_day == date("j")){ 
                echo "<b>"; 
            } 
            
            // 13. 날자 출력 
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

            // 14. 날짜 증가 
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