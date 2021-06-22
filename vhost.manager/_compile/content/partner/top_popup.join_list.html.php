<script>
	
function ajax_uid_check()
{
	var uid = $('#uid').val();
	if(uid.length <= 0)
	{
		$("#ajax_message").html("아이디 입력");
		return false;
	}
	else
	{
		$.ajaxSetup({async:false});
		var param={uid:uid};
		
		$.post("/partner/addCheckAjax", param, on_uid_check);
	}
}

function on_uid_check(result)
{
	if(result==1)
	{
		$("#ajax_message").html("<font color='red'>사용 불가</font>");
	}
	else
	{
		$("#ajax_message").html("<font color='blue'>사용 가능</font>");
	}
}

function doSubmit()
{
	if($("#uid").val().length <=0)
	{
		alert("아이디를 입력하세요");
		$("#uid").focus();
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
		alert("연락처를 입력하세요");
		$("#phone").focus();
		return false;
	}
	if($("#passwd").val().length <=0)
	{
		alert("비밀번호를 입력하세요");
		$("#passwd").focus();
		return false;
	}
	document.form1.submit();
}
</script>

<div class="wrap">
	<div id="route">
		<h5>★ 관리자시스템 > 부본사 관리 > <b>부본사 등록</b></h5>
	</div>

	<h3>부본사 등록</h3>
	<form id="form1" name="form1" method="post" action="?act=add">
		<table cellspacing="1" class="tableStyle_pop" style="line-height:25px;">
		<legend class="blind">부본사 등록</legend>
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
						<option value="Swin_Mbet">스포낙첨+미니롤링</option>
						<option value="Sbet_Mlose">S배팅+M낙첨</option>
						<option value="in">입금</option>
						<option value="inout">입금-출금</option>
						<option value="betting">배팅금(미니게임제외)</option>
						<option value="betting_m">배팅금(미니게임포함)</option>
						<option value="fail">낙첨금(미니게임제외)</option>
						<option value="fail_m">낙첨금(미니게임포함)</option>
					</select>
				</td>
				<th>단폴더정산</th>
				<td>
					<select name="rec_one_folder_flag">
						<option value="1">포함</option>
						<option value="0">미포함</option>
					</select>				
				</td>
		 </tr>
		 <tr>
				<th>정산비율</th>
				<td colspan="3">
					기본 <input name="tex_rate_sport" type="text" id="tex_rate_sport" style="width:50px;text-align:right;" value="0" />%
					미니롤링 <input name="tex_rate_minigame" type="text" id="tex_rate_minigame" style="width:50px;text-align:right;" value="0" />%
				</td>
		 </tr>
		 <tr>
				<th>메모</th>
				<td><input name="memo" type="text" id="memo"/></td>

				<th>사이트</th>
				<td>
					<select name="logo">
						<option value="gadget">gadget</option>
					</select>
				</td>
				<!--<td><span id="ajax_message"></span></td>-->
		 </tr>
		</table>
	
		<div id="wrap_btn">
			<input type="button" name="open" value="등록" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="doSubmit();"/>
		</div>
	</form>
</div>