<? 
	session_start(); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<meta charset="euc-kr">
<link href="../css/common.css" rel="stylesheet" type="text/css" media="all">
<link href="../css/member.css" rel="stylesheet" type="text/css" media="all">
<style>
{margin : 0 ; padding: 0;}
body {
margin : 0 auto;
width : 960px;}
</style>
<script>
   function check_id()
   {
     window.open("check_id.php?id=" + document.member_form.id.value,
         "IDcheck",
          "left=200,top=200,width=200,height=60,scrollbars=no,resizable=yes");
   }

 

   function check_input()
   {
      if (!document.member_form.id.value)
      {
          alert("���̵� �Է��ϼ���");    
          document.member_form.id.focus();
          return;
      }

      if (!document.member_form.password.value)
      {
          alert("��й�ȣ�� �Է��ϼ���");    
          document.member_form.password.focus();
          return;
      }

      if (!document.member_form.password_confirm.value)
      {
          alert("��й�ȣȮ���� �Է��ϼ���");    
          document.member_form.password_confirm.focus();
          return;
      }
if(!document.member_form.confirm_answer.value)
{
alert("��й�ȣ Ȯ�� ���� ���� �Է��ϼ���.");
document.member_form.confirm_answer.focus();
return;
} 
      if (!document.member_form.name.value)
      {
          alert("�̸��� �Է��ϼ���");    
          document.member_form.name.focus();
          return;
      }

if(!document.member_form.address.value)
{
alert("�ּҸ� �Է��ϼ���.");
document.member_form.address.focus();
return;
}

      if (!document.member_form.hp2.value || !document.member_form.hp3.value )
      {
          alert("�޴��� ��ȣ�� �Է��ϼ���");    
          document.member_form.hp2.focus();
          return;
      }

      if (document.member_form.password.value != 
            document.member_form.password_confirm.value)
      {
          alert("��й�ȣ�� ��ġ���� �ʽ��ϴ�.\n�ٽ� �Է����ּ���.");    
          document.member_form.password.focus();
          document.member_form.password.select();
          return;
      }

      document.member_form.submit();
   }

   function reset_form()
   {
    document.member_form.id.value="";
document.member_form.password.value="";
document.member_form.password_confirm.value="";
document.member_form.password_confirm_query.value="";
document.member_form.confirm_answer.value="";
document.member_form.name.value="";
document.member_form.address.value="";
document.member_form.hp1.value="010";
document.member_form.hp2.value="";
document.member_form.hp3.value="";
document.member_form.email1.value="";
document.member_form.email2.value="";
	  
      document.member_form.id.focus();

      return;
   }
</script>
</head>
<body>
<div id="wrap">
  <div id="header">
<div id="joinlogo">
<a href="../index1.php"><img src="../img/logo1.gif"></a></div>
  </div>  <!-- end of header -->

  <div id="content">

	<div id="col2">
        <form  name="member_form" method="post" action="insert.php"> 
		<div id="title">
			<img src="../img/title_join.gif">
		</div>

		<div id="form_join">
			<div id="join1">
			<ul>
			<li> ���̵�</li>
			<li> ��й�ȣ</li>
			<li> ��й�ȣ Ȯ��</li>
			<li> Ȯ�� ����</li>
			<li> Ȯ�� ���� ��</li>
			<li> �̸�</li>
			<li> �ּ�</li>
			<li> ��ȭ��ȣ</li>
			<li> �̸���</li>
			</ul>
			</div>
			<div id="join2">
			<ul>
			<li><div id="id1"><input type="text" name="id"></div><div id="id2"><a href="#"><img src="../img/check_id.gif" onclick="check_id()"></a></div><div id="id3">7�ڸ� �̻��� ��ȣ�� �Է��ϼ���.</div></li>
			<li><input type="password" name="password"></li>
			<li><input type="password" name="password_confirm"></li>

			<li><select name="password_confirm_query">
				<option name="password_confirm_query" value="element">���� �ٳ�� �ʵ��б� �̸���?</option>
				<option name="password_confirm_query" value="place">��￡ ���� ��Ҵ�?</option>
				<option name="password_confirm_query" value="treasure">���� 1ȣ��?</option>
			</select></li>
 			<li><input type="text" name="confirm_answer"></li>
			<li><input type="text" name="name"></li>
			<li><input type="text" name="address"></li>
			<li><select class="hp" name="hp1"> 
              <option value='010'>010</option>
              <option value='011'>011</option>
              <option value='016'>016</option>
              <option value='017'>017</option>
              <option value='018'>018</option>
              <option value='019'>019</option>
              </select>  - <input type="text" class="hp" name="hp2"> - <input type="text" class="hp" name="hp3"></li>
			<li><input type="text" id="email1" name="email1"> @ <input type="text" name="email2"></li>
			</ul>
			</div>
			<div class="clear"></div>
		</div>

		<div id="button"><a href="#"><img src="../img/button_save.gif"  onclick="check_input()"></a>&nbsp;&nbsp;
		                 <a href="#"><img src="../img/button_reset.gif" onclick="reset_form()"></a>
		</div>
	    </form>
	</div> <!-- end of col2 -->
  </div> <!-- end of content -->
</div> <!-- end of wrap -->

</body>
</html>
