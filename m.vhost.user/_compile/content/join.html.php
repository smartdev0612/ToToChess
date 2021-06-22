<script type="text/javascript" src="/js/join.js?v=<?php echo time();?>"></script>
<script type="text/javascript">
	var recode = '<?=$_SESSION["recode"]?>';
	var partnerSn = '<?php echo $TPL_VAR["partnerSn"]?>';
	var recommendUid = '<?php echo $TPL_VAR["recommendUid"]?>';
	var parentCodeFlag = 0;
	var submitFlag = 0;
</script>

<div id="wrap_join" style="margin:0;text-align: center;">
	<h1><img src="../images/logo.png" width="200" style="padding:10px;"></h1>
	<form method="post" onsubmit="return joinAction();">
	<table class="tablestyle_view" id="join" cellspacing="0">				
		<tr>
			<th>아이디</th>
			<td><input type="text" id="uid" name="uid" size="20" maxlength="20" class="inputstyle_member"><br><span id="uid_message">※ 4~20자리내 영문,숫자 조합으로 등록 가능합니다. </span></td>
		</tr>
		<tr>
			<th>닉네임</th>
			<td><input type="text" id="nick" name="nick" size="10" maxlength="10" class="inputstyle_member"><br><span id="nick_message">※ 2~12자리, 한글만 등록이 가능합니다.</span></td>
		</tr>
		<tr>
			<th>비밀번호</th>
			<td><input type="password" id="upass" name="upass" size="20" maxlength="20" class="inputstyle_member"><br><span id="upass_message">※ 4~12자의 영문 또는 숫자만(조합사용가능)</span></td>
		</tr>
		<tr>
			<th>비밀번호 확인</th>
			<td><input type="password" id="confirm_upass" name="confirm_upass" size="20" maxlength="20" class="inputstyle_member"><br><span id="confirm_upass_message">※ 4~12자의 영문 또는 숫자만(조합사용가능)</span></td>
		</tr>
		<tr>
			<th>전화번호</th>
			<td>
				<select id="phone1" name="phone1">
					<option value="010">010</option>
					<option value="011">011</option>
					<option value="016">016</option>
					<option value="017">017</option>
					<option value="018">018</option>
					<option value="019">019</option>
				</select>
				&nbsp;-&nbsp;<input type="text" id="phone2" name="phone2" size="4" maxlength="4" class="inputstyle_number">&nbsp;-&nbsp;
				<input type="text" id="phone3" name="phone3" size="4" maxlength="4" class="inputstyle_number"><br>
				<span id="phone_message">※ 정확한 번호를 입력해주셔야만 가입진행 가능합니다.</span>
			</td>
		</tr>
		<tr>
			<th>계좌번호</th>
			<td class="account">
				은행
				<select id="bank_name" name="bank_name">
					<option value="국민은행">국민은행</option>
					<option value="광주은행">광주은행</option>
					<option value="경남은행">경남은행</option>
					<option value="기업은행">기업은행</option>
					<option value="농협">농협</option>
					<option value="대구은행">대구은행</option>
					<option value="도이치은행">도이치은행</option>
					<option value="부산은행">부산은행</option>
					<option value="상호저축은행">상호저축은행</option>
					<option value="새마을금고">새마을금고</option>
					<option value="수협">수협</option>
					<option value="신협">신협</option>
					<option value="신한은행">신한은행</option>
					<option value="외환은행">외환은행</option>
					<option value="우리은행">우리은행</option>
					<option value="우체국">우체국</option>
					<option value="전북은행">전북은행</option>
					<option value="제주은행">제주은행</option>
					<option value="하나은행">하나은행</option>
					<option value="한국씨티은행">한국씨티은행</option>
					<option value="HSBC은행">HSBC은행</option>
					<option value="SC제일은행">SC제일은행</option>
					<option value="SC제일은행">카카오뱅크</option>
					<option value="SC제일은행">K뱅크</option>
				</select>
				&nbsp;예금주&nbsp;<input type="text" id="bank_member" name="bank_member" size="10" maxlength="5" class="inputstyle_number"><br>
				계좌&nbsp;<input type="text" id="bank_account" name="bank_account" size="26" maxlength="30" class="inputstyle_member"><br>
				<span id="bank_message">※입/출금 계좌 정보.</span>
			</td>
		</tr>

		<tr>
			<th>출금 비밀번호</th>
			<td>
				<input type="password" name="exchange_pass" size="10" maxlength="12" id="exchange_pass" onblur="check_Exchange_password()" class="inputstyle_member"><br><span id="exchange_pass_message">※숫자 4자리 </span>
			</td>
		</tr>

<?php
	if ( $TPL_VAR["member_join_chu"] < 3 ){
?>
<!--
		<tr>
			<th>추천인</th>
			<td>
				<input type="text" id="recommendId" name="recommendId" size="20" maxlength="20" onblur="checkRecommendId()" class="inputstyle_member"><br>
				<span id="recommendId_message">※<?php if($TPL_VAR["member_join_chu"]==1){?>추천인 아이디를 기입해주세요.<?php } else if ( $TPL_VAR["member_join_chu"]==2){?><span>추천인 기입 필수사항 아님.</span><?php }?></span>
			</td>
		</tr>
-->
<?php
	}
?>
	</table>
	<div class="wrap_btn"><input type="image" name="button3" id="button3" src="/img/btn_confirm.gif"></div>
	</form>
</div>