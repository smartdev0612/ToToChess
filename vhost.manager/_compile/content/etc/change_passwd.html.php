<script>
function check_psw()
{
	var frm=document.frm;
	if(frm.psw1.value =="")
	{
		alert("현재 비밀번호는 반드시 입력해댜 합니다. 현재 비밀번호를 입력하시기 바랍니다.");
		frm.psw1.focus();
		return;
	}
	if(frm.psw2.value.length<6)
	{
		alert("새 비밀번호는 6글자 이상 이어야 합니다. 새 비밀번호를 다시 입력하시기 바랍니다.");
		frm.psw2.focus();
		return;
	}
	if(frm.psw2.value!=frm.psw3.value)
	{
		alert("새 비밀번호와 새 비밀번호 확인이 일치하지 않습니다. 새비밀번호를 다시 입력하시기 바랍니다.");
		frm.psw2.value="";
		frm.psw3.value="";
		frm.psw2.focus();
		return;
	}
	frm.submit();
}

function go(url)
{
	var result = confirm('정말로 전환 하시겠습니까?');
	if(result)
	{
		location.href=url;
	}
}
</script>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>비밀번호 관리</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>


	<form name="frm" method="POST" action="?mode=upup">
	<table cellspacing="1" class="tableStyle_membersWrite" summary="비밀번호 관리">
	<legend class="blind">비밀번호 관리</legend>
		<tr>
		  <th nowrap width="35%">현재 비밀번호</th>
		  <td><input type="password" name="psw1" id="psw1" class="w250"/></td>
		</tr>
		<tr>
		  <th>새 비밀번호</th>
		  <td><input type="password" name="psw2" id="psw2" class="w250"/></td>
		</tr>
		<tr>
		  <th nowrap>새 비밀번호 확인</th>
		  <td><input type="password" name="psw3" id="psw3" class="w250"/></td>
		</tr>
	</table>

	<div id="wrap_btn">
		<input type="button" value="확인" onclick="javascript:check_psw();" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'">
	</div>

</div>