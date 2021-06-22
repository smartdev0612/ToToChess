<?php /* Template_ 2.2.3 2014/09/18 19:58:18 D:\www_one-23.com\m.vhost.user\_template\content\member.html */?>
<script> 
function LayerToggle(layer)
{
	if(layer.style.display =='none') layer.style.display = 'block';
	else layer.style.display = 'none'
}
function dosubmit()
{
	if(form1.pass.value=="")
	{
		alert('현재 비밀번호를 입력하십시오.');
		form1.pass.focus();
		return false;
	}
	if(form1.newpass.value!="")
	{
		if(form1.newpass.value==""){
			alert("비밀번호 재확인을 입력하여 주세요.");
			form1.newpass.focus();
			return false;
		}
		if(form1.newpass.value.length<6 ||form1.newpass.value.length>20)
		{
			alert("6 ~ 20 자리 비밀번호를 입력하여 주십시오.");
			form1.newpass2.focus();
			return false;
		}
		if(form1.pass.value!=form1.newpass.value)
		{
			alert("두번의 비밀번호가 일치하지 않습니다.");
			form1.newpass.focus();
			return false;
		}
	}
	/*
	if(form1.newpass2.value!="")
	{
		if(form1.newpass.value==""){
			alert("새 비밀번호를 입력하여 주세요.");
			form1.newpass.focus();
			return false;
		}
		if(form1.newpass.value.length<6 ||form1.newpass.value.length>20)
		{
			alert("6 ~ 20 자리 비밀번호를 입력하여 주십시오.");
			form1.newpass.focus();
			return false;
		}
		if(form1.newpass.value!=form1.newpass2.value)
		{
			alert("두번의 비밀번호가 일치하지 않습니다.");
			form1.newpass.focus();
			return false;
		}
	}
	*/
	form1.submit();
	
//	return true;
}
</script>

			<form action="?mode=modify" method="post" name="form1" id="form1" />
            <div class="member_in">
				<div class="member_in_in">
                        <span class="member_in_text_1">아이디</span>
                        <span class="member_in_text_2"><?php echo $TPL_VAR["sess_member_id"]?></span>
				</div>
				<div class="member_in_in">
                        <span class="member_in_text_1">닉네임</span>
                        <span class="member_in_text_2"><?php echo $TPL_VAR["sess_member_name"]?></span>
				</div>
				<div class="member_in_in">
                        <span class="member_in_text_1">PW변경</span>
                        <span class="member_in_text_2">※1:1고객센터에 문의하시기 바랍니다.<!--<input type="password" name="pass" size="20" maxlength="20" style="IME-MODE:inactive;" id='pwd' placeholder="개인정보보호를 위해 자주 변경해주세요.">--></span>
				</div>
<!--
                    <li>
                        <span class="member_in_text_1">재확인</span>
                        <span class="member_in_text_2"><input type="password" name="newpass"  size="20" maxlength="20" style="IME-MODE:inactive;" id="password_check" placeholder="다시 한 번 입력해주세요."></span>
                    </li>
-->
				<div class="member_in_in">
                        <span class="member_in_text_1">핸드폰</span>
                        <span class="member_in_text_2">※1:1고객센터에 문의하시기 바랍니다.</span>
				</div>
				<div class="member_in_in">
                        <span class="member_in_text_1">계좌정보</span>
                        <span class="member_in_text_2">※1:1고객센터에 문의하시기 바랍니다..</span>
				</div>
<!--
                    <li>
						<p class="member_writh_bt_box">
							<a href="#none" class="bt_writh_3" onclick="dosubmit();">확인</a>
						</p>
                    </li>
-->
            </div>
			</form>
