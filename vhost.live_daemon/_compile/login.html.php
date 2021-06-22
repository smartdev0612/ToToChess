<?php /* Template_ 2.2.3 2012/11/30 16:47:34 D:\www_one-23.com\vhost.live_daemon\_template\login.html */?>
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

<body>

<div id="wrap_login">
	<div id="loginWrap">
		<div id="loginWrap_inner">
			<form action="/loginProcess" name="login" id="login" method="post" onsubmit="return chk_input();">
			<p class="input"><img src="/img/login_tl_id.gif" title="아이디"><input type="text" name="login_id" class="loginInput"></p>
			<p class="input"><img src="/img/login_tl_pw.gif" title="비밀번호"><input type="password" name="login_pass" class="loginInput"></p>
			<p class="btn"><input type="image" src="/img/login_btn.gif" title="로그인"></p>
			</form>
		</div>

	</div>
</div>
</body>
</html>