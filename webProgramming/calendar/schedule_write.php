<?
session_start();
?>
<!DOCTYPE HTML PUBLIC "-W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta charset="euc-kr">
<link href="../css/common.css" rel="stylesheet"type="text/css" media="all">
<link href="../css/calendar.css" rel="stylesheet" type="text/css" media="all">
</head>

<body>
<div id="wrap">
<div id="header">
 <? include "../lib/top_login3.php";?>
</div>

<div id="menu"> 
 <?include "../lib/top_menu2.php"; ?>
</div>

<div id="content">
<div id="col1">
<div id="left_menu">
 <? include "../lib/left_menu.php"; ?>
</div>
</div>
<div id="col2">
<form name="board_form" method="post" action="insert.php">
<div id="write_form">
<br><br>
			<div class="write_line"></div>
			<div id="write_row1">
			<div class="col1">date</div>
			<div class="col2" style="float:left;">
<select name="year">
<option>2016</option>
<option>2017</option>
<option>2015</option>
</select>

<select name="month">
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
<option>8</option>
<option>9</option>
<option>10</option>
<option>11</option>
<option>12</option>
</select>

<select name="date">
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
<option>5</option>
<option>6</option>
<option>7</option>
<option>8</option>
<option>9</option>
<option>10</option>
<option>11</option>
<option>12</option>
<option>13</option>
<option>14</option>
<option>15</option>
<option>16</option>
<option>17</option>
<option>18</option>
<option>19</option>
<option>20</option>
<option>21</option>
<option>22</option>
<option>23</option>
<option>24</option>
<option>25</option>
<option>26</option>
<option>27</option>
<option>28</option>
<option>29</option>
<option>30</option>
<option>31</option>

</select>


</div>
<br><br><br>
</div>
<div id="write_row2">
<div class="col1"> subject   </div>
<div class="col2"><input type="text" name="subject" ></div>
</div>
<div class="write_line"></div>
<div id="write_row3">
<div class="col1"> content   </div>
			                     <div class="col2"><textarea rows="15" cols="79" name="content"></textarea></div>
</div>
<div class="write_line"></div>
</div>

<div id="write_button"><input type="image" src="../img/ok.gif">&nbsp;
<a href="caltest.php"><img src="../img/list.gif"></a>
</div>
</form>

</div>
</div>
</div>
</body>
</html>