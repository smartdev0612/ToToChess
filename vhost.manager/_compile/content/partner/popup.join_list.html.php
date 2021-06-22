<div class="wrap">
	<div id="route">
		<h5>관리자 시스템 > 총판 관리 > <b>총판 등록</b></h5>
	</div>

	<h3>총판 등록</h3>
	<form id="form1" name="form1" method="post" action="?act=add">
	<input type="hidden" name="top_rec_tex_type" id="top_rec_tex_type">
	<input type="hidden" name="top_rec_one_folder_flag" id="top_rec_one_folder_flag">
		<table cellspacing="1" class="tableStyle_pop" style="line-height:25px;">
		<legend class="blind">총판 등록</legend>
			<tr>
			  <th>소속본사</th>
			  <td colspan="3">
					<select id="topRecId" name="topRecId" onChange="topRecSetting();">
						<option value="">--본사선택--</option>
<?php
	for ( $i = 0 ; $i < count($TPL_VAR["topTopRecList"]) ; $i++ ) {
		if ( $TPL_VAR["list"]["rec_parent_id"] == $TPL_VAR["topTopRecList"][$i]["rec_id"] ) $selected = "selected";
		else $selected = "";
		echo "<option value='".$TPL_VAR["topTopRecList"][$i]["rec_id"]."'  ".$selected.
						" tex_type='".$TPL_VAR["topTopRecList"][$i]["rec_tex_type"]."'".
						" rate_sport='".$TPL_VAR["topTopRecList"][$i]["rec_rate_sport"]."'".
						" rate_minigame='".$TPL_VAR["topTopRecList"][$i]["rec_rate_minigame"]."'".
						" one_folder='".$TPL_VAR["topTopRecList"][$i]["rec_one_folder_flag"]."'>".$TPL_VAR["topTopRecList"][$i]["rec_id"]."</option>";
	}
?>
					</select>
				</td>
			</tr>
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
					<select name="tex_type" id="tex_type">
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
					<select name="rec_one_folder_flag" id="rec_one_folder_flag">
						<option value="1">포함</option>
						<option value="0">미포함</option>
					</select>				
				</td>
		 </tr>
		 <tr>
				<th>기본정산비율</th>
				<td>
					<input type="text" name="tex_rate_sport" id="tex_rate_sport" style="width:50px;text-align:right;" value="0" /> %
				</td>
				<th>미니롤링비율</th>
				<td>
					<input type="text" name="tex_rate_minigame" id="tex_rate_minigame" style="width:50px;text-align:right;" value="0" /> %
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

<script>
	function ajax_uid_check() {
		var uid = $('#uid').val();
		if(uid.length <= 0) {
			$("#ajax_message").html("아이디 입력");
			return false;
		} else {
			$.ajaxSetup({async:false});
			var param={uid:uid};
			$.post("/partner/addCheckAjax", param, on_uid_check);
		}
	}

	function on_uid_check(result) {
		if(result==1) {
			$("#ajax_message").html("<font color='red'>사용 불가</font>");
		} else {
			$("#ajax_message").html("<font color='blue'>사용 가능</font>");
		}
	}

	function doSubmit() {
		if($("#uid").val().length <=0) {
			alert("아이디를 입력하세요");
			$("#uid").focus();
			return false;
		}
		if($("#name").val().length <=0) {
			alert("이름을 입력하세요");
			$("#name").focus();
			return false;
		}
		if($("#phone").val().length <=0) {
			alert("연락처를 입력하세요");
			$("#phone").focus();
			return false;
		}
		if($("#passwd").val().length <=0) {
			alert("비밀번호를 입력하세요");
			$("#passwd").focus();
			return false;
		}
		if ( $("#topRecId option:selected").val().length > 0 ) {
			var pRate_sport = Number($("#topRecId option:selected").attr('rate_sport'));
			var pRate_minigame = Number($("#topRecId option:selected").attr('rate_minigame'));
			var select_rate_sport = Number($("#tex_rate_sport").val());
			var select_rate_minigame = Number($("#tex_rate_minigame").val());

			if ( select_rate_sport > pRate_sport ) {
				alert("스포츠정산비율이 소속본사보다 높을 수 없습니다.\n\n("+pRate_sport+"% 보다 같거나 낮게 설정 하세요.)");
				return false;
			}

			if ( select_rate_minigame > pRate_minigame ) {
				alert("미니게임정산비율이 소속본사보다 높을 수 없습니다.\n\n("+pRate_minigame+"% 보다 같거나 낮게 설정 하세요.)");
				return false;
			}
		}

		document.form1.submit();
	}

	function topRecSetting() {
		//-> 부본사설정을 총판에 복사.
		if ( $("#topRecId option:selected").val().length > 0 ) {
			//-> 정산기준
			var pRate_tex_type = $("#topRecId option:selected").attr('tex_type');
			var pRate_sport = Number($("#topRecId option:selected").attr('rate_sport'));
			var pRate_minigame = Number($("#topRecId option:selected").attr('rate_minigame'));
			var pOne_folder = Number($("#topRecId option:selected").attr('one_folder'));

			$("#tex_type option[value="+pRate_tex_type+"]").attr("selected",true);
			$("#tex_rate_sport").val(pRate_sport);
			$("#tex_rate_minigame").val(pRate_minigame);
			$("#rec_one_folder_flag option[value="+pOne_folder+"]").attr("selected",true);

			$("#tex_type").attr("disabled",true);
			$("#rec_one_folder_flag").attr("disabled",true);

			$("#top_rec_tex_type").val(pRate_tex_type);
			$("#top_rec_one_folder_flag").val(pOne_folder);
		} else {
			$("#tex_type").attr("disabled",false);
			$("#rec_one_folder_flag").attr("disabled",false);
		}
	}
</script>