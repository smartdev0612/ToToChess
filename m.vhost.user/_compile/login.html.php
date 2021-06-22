<?php /* Template_ 2.2.3 2012/12/13 18:08:54 D:\www\vhost.user\_template\login.html */?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<head>
<title><?php echo $TPL_VAR["site_title"]?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE7">
<meta name="author" content="KG SOFT">
<meta name="copyright" content="OK SPORTS 2012"/>
<meta http-equiv="imagetoolbar" content="no">
<meta name="robots" content="noindex">

<link rel="stylesheet" type="text/css" href="/css/default.css" >

<script> 
	function loginCheck()
	{
		if(login.uid.value=="")
		{
			alert('아이디를 입력하십시오.');
			login.uid.focus();
			return false;
		}
		if(login.upasswd.value=="")
		{
			alert("비밀번호를 입력하십시오.");
			login.upasswd.focus();
			return false;
		}
		return true;
	}
	function open_window(url,width,height)
	{
		window.open(url,'','scrollbars=yes,width='+width+',height='+height+',left=5,top=0');
	}
 
</script>

</head>

<div id="whole">
<h2 class="blind"><a href="#wrap_body">내용 바로보기</a></h2>

	<div id="wrap_header">
		<div id="header">
		</div>
	</div>

	<div id="wrap_body">
		<h2 class="blind">내용</a></h2>
		<div id="bodyWhole" class="subBody_login">

			<div id="wrapLogin">
				<form name="login" method="post" action="/loginProcess" onSubmit="return loginCheck();">
					<input type="hidden" name="returl" value="<?php echo $TPL_VAR["returl"]?>">
					<div id="loginWrap_inner">
						<p class="input"><img src="/img/member/login_tl_id.gif" title="아이디"><input type="text" name="uid" class="loginInput" style="ime-mode:disabled"></p>
						<p class="input"><img src="/img/member/login_tl_pw.gif" title="비밀번호"><input type="password" name="upasswd" class="loginInput" style="ime-mode:disabled"></p>
						<p class="btn"><input type="image" src="/img/member/btn_login.gif" title="로그인"></p>
						<p class="join">
							<a href="#"><img src="/img/member/btn_findId.gif" onclick="open_window('/member/findPopup',650,430)" title="회원정보찾기"></a> 
							<a href="/member/add"><img src="/img/member/btn_join.gif"  title="신규회원가입"></a>
						</p>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="footer">
		<h2 class="blind">하단</a></h2>
		<img src="/img/footer_copyright.gif">
	</div>
</div>

</body>
</html>