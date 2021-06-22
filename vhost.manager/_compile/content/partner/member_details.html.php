<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="/js/js.js"></script>
<title>회원 상세 정보</title>
<script>
	function check() {
		var fm=document.frm;
		if(fm.pwd.value !="") {
			if(fm.pwd.value.length<6){
				alert("비밀번호는 6자리 이상입니다");
				fm.pwd.focus();
				return;
			}
		}

		if ( $("#topRecId option:selected").val().length > 0 ) {
			var pRate_sport = Number($("#topRecId option:selected").attr('rate_sport'));
			var pRate_minigame = Number($("#topRecId option:selected").attr('rate_minigame'));
			var select_rate_sport = Number($("#tex_rate_sport").val());
			var select_rate_minigame = Number($("#tex_rate_minigame").val());

			if ( select_rate_sport > pRate_sport ) {
				alert("기본비율이 소속본사보다 높을 수 없습니다.\n\n("+pRate_sport+"% 보다 같거나 낮게 설정 하세요.)");
				return false;
			}

			if ( select_rate_minigame > pRate_minigame ) {
				alert("미니롤링비율이 소속본사보다 높을 수 없습니다.\n\n("+pRate_minigame+"% 보다 같거나 낮게 설정 하세요.)");
				return false;
			}
		}

		if(fm.rec_name.value=="") {
			alert("이름은 필수 입력 항입니다.");
			fm.rec_name.focus();
			return;
		}
		fm.submit();
	}

	function go(url) {
		var result = confirm('정말로 전환 하시겠습니까?');
		if(result) {
			location.href=url;
		}
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

	$(document).ready(function() {
		if ( $("#topRecId option:selected").val().length > 0 ) {
			var pRate_tex_type = $("#topRecId option:selected").attr('tex_type');
			var pOne_folder = Number($("#topRecId option:selected").attr('one_folder'));

			$("#tex_type").attr("disabled",true);
			$("#rec_one_folder_flag").attr("disabled",true);

			$("#top_rec_tex_type").val(pRate_tex_type);
			$("#top_rec_one_folder_flag").val(pOne_folder);
		}
	});
</script>
</head>
<body>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>파트너 상세정보</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<form id="frm" name="frm" method="post" action="?act=add">
		<input type="hidden" name="top_rec_tex_type" id="top_rec_tex_type">
		<input type="hidden" name="top_rec_one_folder_flag" id="top_rec_one_folder_flag">
		<input type="hidden" name="urlidx" value="<?php echo $TPL_VAR["list"]["Idx"]?>">	
		<table cellspacing="1" class="tableStyle_membersWrite" summary="회원 정보">
		<legend class="blind">쪽지 쓰기</legend>
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
			  <td><input type="input" name="rec_id" value="<?php echo $TPL_VAR["list"]["rec_id"]?>" class="inputStyle2"></td>
			  <th>비밀번호</th>
			  <td><input type="password" name="pwd" value="default" class="inputStyle1"></td>
			</tr>
			<tr>
			  <th>정산기준</th>
			  <td>
					<select name="tex_type" id="tex_type">
						<option value="Swin_Mbet" <?php if($TPL_VAR["list"]["rec_tex_type"]=="Swin_Mbet"){ echo "selected";}?>>스포낙첨+미니롤링</option>
						<option value="Sbet_Mlose" <?php if($TPL_VAR["list"]["rec_tex_type"]=="Sbet_Mlose"){ echo "selected";}?>>S배팅+M낙첨</option>
						<option value="in" <?php if($TPL_VAR["list"]["rec_tex_type"]=="in"){ echo "selected";}?>>입금</option>
						<option value="inout" <?php if($TPL_VAR["list"]["rec_tex_type"]=="inout"){ echo "selected";}?>>입금-출금</option>
						<option value="betting" <?php if($TPL_VAR["list"]["rec_tex_type"]=="betting"){ echo "selected";}?>>배팅금(미니게임제외)</option>
						<option value="betting_m" <?php if($TPL_VAR["list"]["rec_tex_type"]=="betting_m"){ echo "selected";}?>>배팅금(미니게임포함)</option>
						<option value="fail" <?php if($TPL_VAR["list"]["rec_tex_type"]=="fail"){ echo "selected";}?>>낙첨금(미니게임제외)</option>
						<option value="fail_m" <?php if($TPL_VAR["list"]["rec_tex_type"]=="fail_m"){ echo "selected";}?>>낙첨금(미니게임포함)</option>
					</select>
				</td>
			  <th>단폴더정산</th>
			  <td>
					<select name="rec_one_folder_flag" id="rec_one_folder_flag">
						<option value="1" <?php if($TPL_VAR["list"]["rec_one_folder_flag"]){ echo "selected";}?>>포함</option>
						<option value="0" <?php if(!$TPL_VAR["list"]["rec_one_folder_flag"]){ echo "selected";}?>>미포함</option>
					</select>
				</td>
			</tr>
			<tr>
			  <th>정산비율</th>
			  <td colspan="3">
					기본 <input type="text" name="tex_rate_sport" id="tex_rate_sport" value="<?php echo $TPL_VAR["list"]["rec_rate_sport"];?>" class="inputStyle1" style="width:30px;text-align:right;">%
					미니롤링 <input type="text" name="tex_rate_minigame" id="tex_rate_minigame" value="<?php echo $TPL_VAR["list"]["rec_rate_minigame"];?>" class="inputStyle1" style="width:30px;text-align:right;">%
				</td>
			</tr>
			<tr>
			  <th>이름</th>
			  <td><input type="input" name="rec_name" value="<?php echo $TPL_VAR["list"]["rec_name"]?>" class="inputStyle2"></td>
			  <th>은행명</th>
			  <td><input type="input" name="rec_bankname" value="<?php echo $TPL_VAR["list"]["rec_bankname"]?>" class="inputStyle2"></td>
			</tr>
			<tr>
			  <th>예금주</th>
			  <td colspan="3"><input type="input" name="rec_bankusername" value="<?php echo $TPL_VAR["list"]["rec_bankusername"]?>" class="inputStyle2"></td>
			</tr>
			<tr>
			  <th>총입금액</th>
			  <td><?php echo number_format($TPL_VAR["list"]["charge_sum"],0)?>원</td>
			  <th>총출금액</th>
			  <td><?php echo number_format($TPL_VAR["list"]["exchange_sum"],0)?>원</td>
			</tr>
			<tr>
			  <th>계좌번호</th>
			  <td><input type="input" name="rec_banknum" value="<?php echo $TPL_VAR["list"]["rec_banknum"]?>" class="inputStyle2"></td>
			  <th>가입날짜</th>
			  <td><?php echo $TPL_VAR["list"]["reg_date"]?></td>
			</tr>
			<tr>
			  <th>회원수</th>
			  <td><?php echo $TPL_VAR["list"]["member_count"]?>명</td>
			  <th>입금자수</th>
			  <td><?php echo $TPL_VAR["list"]["charge_count"]?>명</td>
			</tr>
			<!--
			<tr>
			  <th>등급</th>
			  <td colspan="3">
				<select name="rec_lev">
					<option value="1" <?php if($TPL_VAR["list"]["rec_lev"]==1){?> "selected" <?php }?>>1</option>
					<option value="2" <?php if($TPL_VAR["list"]["rec_lev"]==2){?> "selected" <?php }?>>2</option>
					<option value="3" <?php if($TPL_VAR["list"]["rec_lev"]==3){?> "selected" <?php }?>>3</option>
					<option value="4" <?php if($TPL_VAR["list"]["rec_lev"]==4){?> "selected" <?php }?>>4</option>
					<option value="5" <?php if($TPL_VAR["list"]["rec_lev"]==5){?> "selected" <?php }?>>5</option>
					<option value="6" <?php if($TPL_VAR["list"]["rec_lev"]==6){?> "selected" <?php }?>>6</option>
					<option value="7" <?php if($TPL_VAR["list"]["rec_lev"]==7){?> "selected" <?php }?>>7</option>
					<option value="8" <?php if($TPL_VAR["list"]["rec_lev"]==8){?> "selected" <?php }?>>8</option>
					<option value="9" <?php if($TPL_VAR["list"]["rec_lev"]==9){?> "selected" <?php }?>>9</option>
					<option value="10" <?php if($TPL_VAR["list"]["rec_lev"]==10){?> "selected" <?php }?>>10</option>
				</select>
			  </td>
			</tr>
			-->
			<tr>
			  <th>이메일</th>
			  <td><input type="input" name="rec_email" value="<?php echo $TPL_VAR["list"]["rec_email"]?>" class="inputStyle2"></td>
			  <th>핸드폰</th>
			  <td><input type="input" name="rec_phone" value="<?php echo $TPL_VAR["list"]["rec_phone"]?>" class="inputStyle2"></td>
			</tr>
			<tr>
			  <th>메모</th>
			  <td colspan="3">
				<textarea class="input" cols="50" rows="3" name="memo" ><?php echo $TPL_VAR["list"]["memo"]?></textarea>
			  </td>
			</tr>
		</table>
	
		<div id="wrap_btn"><input type="button" value="수정" onClick="check()" class="btnStyle1"></div>
	</form>
</div>
</body>
</html>