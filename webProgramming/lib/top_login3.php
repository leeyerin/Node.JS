<?
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style>
li{
 list-style:none;
float:right;
}
#login_button{
float:right;
}
#logining{
float: right;
}
#join_button {
float : right;
}
</style>
<meta charset="euc-kr">
</head>

<body>
 <? 
if(!$userid)
{
?>
<div id="join_button"><a href="../member/member_form.php">
<input type="image" src="../img/join_button1.gif"></div>
<form name="member_form" method="post" action="../login/login.php">
<div id="login_button">
<input type="image" src="../img/login_button.gif"></div>
<div id ="id_pass_input">
 <ul>
<li>&nbsp;&nbsp;비밀번호&nbsp;&nbsp;<input type="text" name="password"></li>
<li>아이디&nbsp;&nbsp;<input type="text" name="id"></li>
</ul>
</div>
<? 
}
else {
?>
<div id="logining">
<?=$username ?>님 |
 <a href="../login/logout.php"><img src="../img/logout_button.gif"></a>  
<a href="../login/member_form_modify.php"><img src="../img/정보수정_button.gif"></a>

</div>

<?
}
?>
</form>
</div>
<div id="logo1" ><a href="../index1.php"><img src="../img/logo.gif" border="0"></a></div>
</body>
</html>


