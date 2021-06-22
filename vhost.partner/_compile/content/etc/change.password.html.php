<?php /* Template_ 2.2.3 2012/10/23 21:08:40 C:\APM_Setup\htdocs\www\vhost.partner\_template\content\etc\change.password.html */?>
<title>파트너 비밀번호 변경</title>

<script>
function Form_ok() {
		if (Form1.nowpass.value == "") {
		   alert("현재 비밀번호를 입력하세요!");
		   document.Form1.nowpass.focus();
		   return;
		}
		
		if(Form1.newpass.value ==""){
			alert("새 비밀번호를 입력하세요!");
		    document.Form1.newpass.focus();
		    return;
		}
		if(Form1.newpass.value.length<5 || Form1.newpass.value.length>15)
		{
			alert("비밀번호 5-15 자리 입니다!");
		    document.Form1.newpass.focus();
		    return;
		}
		if(Form1.newpass2.value ==""){
			alert("비밀번호 확인을 입력하세요!");
		    document.Form1.newpass2.focus();
		    return;
		}
		if(Form1.newpass.value!=Form1.newpass2.value)
		{
			alert("두번의 비밀번호가 일치하지 않습니다.확인하여 주십시오");
			document.Form1.newpass2.focus();
		    return;
		}
		if (confirm("비밀번호를 변경합니다.기억하여 주십시오.")) {
			document.Form1.submit();
		} else {
			return;
		}
}

</script>
</head>

<body>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>계좌번호 변경</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>
	
	<form name="Form1" action="?act=change" method="post">
		<table cellspacing="1" class="tableStyle_membersWrite thBig" summary="계좌번호 변경">
		<legend class="blind">계좌번호 변경</legend>
		<tr>
			<th width="50%" nowrap>현재 비밀번호</th>
			<td><input type="password" name="nowpass" onmouseover="this.focus()"></td>
			</tr>
		<tr>
			<th>새 비밀번호</th>
			<td><input type="password" name="newpass" onmouseover="this.focus()"></td>
			</tr>
	
		<tr>
			<th>비밀번호 확인</th>
			<td><input type="password" name="newpass2" onmouseover="this.focus()"></td>
		</tr>
		</table>
	
		<div id="wrap_btn">
			<input type="button" value="변경" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'" onclick="Form_ok();">
			<input type="button" value="취소" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'" onclick="window.close();">
		</div>
	</form>

</div>
</body>
</html>