<?php /* Template_ 2.2.3 2012/10/06 18:24:34 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\content.member.add.html */?>
<script>
	function checknull()
	{
		var fm=document.form1;
		var val=CheckStr(fm.mem_id.value," ",'');
		if(val==0)
		{
			alert("아이디를 입력하세요");
			fm.mem_id.focus();
			return;
		}
		val=CheckStr(fm.nick.value," ",'');
		if(val==0)
		{
			alert("닉네임을 입력하십시오.")
			fm.nick.focus();
			return;
		}
		val=CheckStr(fm.name.value," ",'');
		if(val==0)
		{
			alert("이름을 입력하십시오.");
			fm.name.focus();
			return;
		}
		val=CheckStr(fm.psw.value," ",'');
		if(val==0)
		{
			alert("비밀 번호를 입력하십시오.");
			fm.psw.focus();
			return;
		}
		val=CheckStr(fm.phone.value," ",'');
		if(val==0)
		{
			alert("핸드폰 번호를 입력하십시오.");
			fm.phone.focus();
			return;
		}
		val=CheckStr(fm.mail.value," ",'');
		if(val==0)
		{
			alert("이메일을 입력하십시오.");
			fm.mail.focus();
			return;
		}
		fm.submit();
	}
</script>

<div class="wrap" id="members">

	<div id="route">
		<h5>관리자 시스템 > 회원 관리 > <b>회원등록</b></h5>
	</div>

	<h3>회원등록</h3>

	<form id="form1" name="form1" method="post" action="?">
		<input type="hidden" name="act" value="add">
	
		<table cellspacing="1" class="tableStyle_membersWrite" summary="회원등록">
		<legend class="blind">회원등록</legend>
		<tr>
		  <th>아이디</th>
		  <td><input name="mem_id" type="text" class="w250" id="mem_id" maxlength="25" value=""/></td>
		  <th>닉네임</th>
		  <td><input name="nick" type="text" class="w250" id="nick" maxlength="25" value=""/></td>
		</tr>
		<tr>
		  <th>이름</th>
		  <td><input name="name" type="text" class="w250" id="name" maxlength="25" value=""/></td>
		  <th>비밀번호</th>
		  <td><input name="psw" type="password" class="w250" id="psw" maxlength="25" value=""/></td>
		</tr>
		<tr>
		  <th>핸드폰</th>
		  <td><input name="phone" type="text" class="w250" id="phone" maxlength="25" value=""/></td>
		  <th>이메일</th>
		  <td><input name="mail" type="text" class="w250" id="mail" maxlength="25" value=""/></td>
		</tr>
		</table>
		<input type="hidden" name="member_type"  value="2" />
	
		<div id="wrap_btn">
			<p class="left">
				<input name="submit3" type="button" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" value="등  록" onclick="checknull()"/>
			</p>
		</div>
	</form>
</div>