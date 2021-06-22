<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7">
<meta name="author" content="KG SOFT">
<meta name="copyright" content="MONACO 2012"/>
<meta http-equiv="imagetoolbar" content="no">

<link rel="stylesheet" href="/css/default.css" type="text/css">
<script type="text/javascript" src="/js/common.js"></script>
<title>관리자 시스템 로그인</title>

<script language="javascript">
   function chk_input(){
    if(login.login_id.value=="")
    {
     alert('아이디를 입력하세요!');
     login.login_id.focus();
     return false;
     }
     if(login.login_pass.value==""){
     alert('비밀번호를 입력하세요!');
     login.login_pass.focus();
     return false;
     }
    
     return true;
    }

</script>
</head>

<body id="loginpage">

<div id="wrap_body">

	<div class="wrap">
		<form action="/loginProcess" name="login" id="login" method="post" onsubmit="return chk_input();">
		<p class="input id"><label>Admin ID</label><input type="text" name="login_id"></p>
		<p class="input pw"><label>Password</label><input type="password" name="login_pass"></p>
		<p class="btn"><input type="image" src="/img/btn_login.gif" style="margin-left: 6px;"></p>
		</form>
	</div>

</div>
</body>
</html>