<script>	
var recTexRate = "<?php echo $TPL_VAR["parentInfo"]["rec_rate_sport"];?>";
var recTexRateMini = "<?php echo $TPL_VAR["parentInfo"]["rec_rate_minigame"];?>";

function ajax_uid_check() {
	var uid = $('#uid').val();
	if(uid.length <= 0) {
		$("#ajax_message").html("아이디 입력");
		return false;
	} else {
		$.ajaxSetup({async:false});
		var param={uid:uid};
		
		$.post("/member/addCheckAjax", param, on_uid_check);
	}
}

function on_uid_check(result) {
	if(result==1) {
		alert('이미 사용중인 아이디 입니다.');
		$("#uid").val("");
	}
}

function doSubmit() {
	if($("#uid").val().length <=0)
	{
		alert("아이디를 입력하세요");
		$("#uid").focus();
		return false;
	}
	if($("#passwd").val().length <=0)
	{
		alert("비밀번호를 입력하세요");
		$("#passwd").focus();
		return false;
	}
	if($("#name").val().length <=0)
	{
		alert("이름을 입력하세요");
		$("#name").focus();
		return false;
	}
	if($("#phone").val().length <=0)
	{
		alert("전화번호를 입력하세요");
		$("#phone").focus();
		return false;
	}
	if($("#tex_rate_sport").val().length < 0)
	{
		alert("기본정산비율을 입력하세요.");
		$("#tex_rate_sport").focus();
		return;
	}
	if ( Number($("#tex_rate_sport").val()) > Number(recTexRate) ) {
		alert("기본정산비율은 "+recTexRate+"% 이하로 설정해주세요.");
		$("#tex_rate").focus();
		return;
	}
	if($("#tex_rate_minigame").val().length < 0)
	{
		alert("미니롤링비율을 입력하세요.");
		$("#tex_rate_minigame").focus();
		return;
	}
	if ( Number($("#tex_rate_minigame").val()) > Number(recTexRateMini) ) {
		alert("미니롤링비율은 "+recTexRateMini+"% 이하로 설정해주세요.");
		$("#tex_rate").focus();
		return;
	}
	document.form1.submit();
}
</script>

<div class="wrap">
	<h3 style="margin:0;">총판 등록</h3>
	<form id="form1" name="form1" method="post" action="?act=add">
		<input type="hidden" name="logo" value="gadget">
		<table cellspacing="1" class="tableStyle_pop" style="line-height:25px;">
		<legend class="blind">총판 등록</legend>
			<tr>
				<th>아이디</th>
				<td><input name="uid" type="text" id="uid" onblur="ajax_uid_check();" /></td>
				<th>비밀번호</th>
				<td><input name="passwd" type="text" id="passwd"/></td>
		 </tr>
		 <tr>
				<th>이름</th>
				<td><input name="name" type="text" id="name"/></td>
				<th>전화번호</th>
				<td><input name="phone" type="text" id="phone"/></td>
		 </tr>
		 <tr>
				<th>정산기준</th>
				<td>
					<select name="tex_type">
<?php
	if ( $TPL_VAR["parentInfo"]["rec_tex_type"] == "Swin_Mbet" ) {
		echo "<option value=\"Swin_Mbet\">스포낙첨+미니롤링</option>";
	} else if ( $TPL_VAR["parentInfo"]["rec_tex_type"] == "Sbet_Mlose" ) {
		echo "<option value=\"Sbet_Mlose\">S배팅+M낙첨</option>";
	} else if ( $TPL_VAR["parentInfo"]["rec_tex_type"] == "in" ) {
		echo "<option value=\"in\">입금</option>";
	} else if ( $TPL_VAR["parentInfo"]["rec_tex_type"] == "inout" ) {
		echo "<option value=\"inout\">입금-출금</option>";
	} else if ( $TPL_VAR["parentInfo"]["rec_tex_type"] == "betting" ) {
		echo "<option value=\"betting\">배팅금(미니게임제외)</option>";
	} else if ( $TPL_VAR["parentInfo"]["rec_tex_type"] == "betting_m" ) {
		echo "<option value=\"betting_m\">배팅금(미니게임포함)</option>";
	} else if ( $TPL_VAR["parentInfo"]["rec_tex_type"] == "fail" ) {
		echo "<option value=\"fail\">낙첨금(미니게임제외)</option>";
	} else if ( $TPL_VAR["parentInfo"]["rec_tex_type"] == "fail_m" ) {
		echo "<option value=\"fail_m\">낙첨금(미니게임포함)</option>";
	}		
?>
					</select>
				</td>
				<th>단폴더정산</th>
				<td>
					<select name="rec_one_folder_flag">
<?php
	if ( $TPL_VAR["parentInfo"]["rec_one_folder_flag"] == 1 ) {
		echo "<option value=\"1\">포함</option>";
	} else if ( $TPL_VAR["parentInfo"]["rec_one_folder_flag"] == 0 ) {
		echo "<option value=\"0\">미포함</option>";
	}
?>
					</select>				
				</td>
		 </tr>
		 <tr>
				<th>기본정산비율</th>
				<td>
					<input type="text" name="tex_rate_sport" id="tex_rate_sport" style="width:50px;text-align:right;" value="<?php echo $TPL_VAR["parentInfo"]["rec_rate_sport"];?>" /> % ▼이하
				</td>
				<th>미니롤링비율</th>
				<td>
					<input type="text" name="tex_rate_minigame" id="tex_rate_minigame" style="width:50px;text-align:right;" value="<?php echo $TPL_VAR["parentInfo"]["rec_rate_minigame"];?>" /> % ▼이하
				</td>
		 </tr>
		</table>
	
		<div id="wrap_btn">
			<input type="button" name="open" value="등록" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="doSubmit();"/>
		</div>
	</form>
</div>