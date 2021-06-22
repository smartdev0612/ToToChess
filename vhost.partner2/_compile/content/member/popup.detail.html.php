<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="/css/style.css" rel="stylesheet" type="text/css" />
	<script language="javascript" src="/js/js.js"></script>
	<title>회원 상세 정보</title>
	<script>
	var recTexRate = "<?php echo $TPL_VAR["parentInfo"]["rec_rate_sport"];?>";
	var recTexRateMini = "<?php echo $TPL_VAR["parentInfo"]["rec_rate_minigame"];?>";
	function check()
	{
		var fm=document.frm;
		if(fm.pwd.value !=""){
			if(fm.pwd.value.length<6){
				alert("비밀번호는 6자리 이상입니다");
				fm.pwd.focus();
				return;
			}
		}
		if(fm.rec_name.value=="")
		{
			alert("이름은 필수 입력 항입니다.");
			fm.rec_name.focus();
			return;
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
		fm.submit();
	}

	function go(url)
	{
		var result = confirm('정말로 전환 하시겠습니까?');
		if(result){
			location.href=url;
		}
  }
</script>
</head>

<body>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>총판 상세정보</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<form id="frm" name="frm" method="post" action="?act=add">		
		<input type="hidden" name="urlidx" value="<?php echo $TPL_VAR["list"]["Idx"]?>">	
		<input type="hidden" name="topRecId" value="<?php echo $TPL_VAR["parentInfo"]["rec_id"];?>">
		<table cellspacing="1" class="tableStyle_membersWrite" summary="회원 정보">
		<legend class="blind">쪽지 쓰기</legend>
			<tr>
			  <th>소속본사</th>
			  <td colspan="3"><?php echo $TPL_VAR["parentInfo"]["rec_id"];?></td>
			</tr>
			<tr>
			  <th>아이디</th>
			  <td><?php echo $TPL_VAR["list"]["rec_id"]?></td>
			  <th>비밀번호</th>
			  <td><input type="password" name="pwd" value="default" class="inputStyle1"></td>
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
					<select id="rec_one_folder_flag" name="rec_one_folder_flag">
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
			  <th>정산비율</th>
			  <td colspan="3">
					기본 <input type="text" name="tex_rate_sport" id="tex_rate_sport" value="<?php echo $TPL_VAR["list"]["rec_rate_sport"];?>" class="inputStyle1" style="width:30px;text-align:right;">%
					미니롤링 <input type="text" name="tex_rate_minigame" id="tex_rate_minigame" value="<?php echo $TPL_VAR["list"]["rec_rate_minigame"];?>" class="inputStyle1" style="width:30px;text-align:right;">%
				</td>
			</tr>
			<tr>
			  <th>닉네임</th>
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