<?php /* Template_ 2.2.3 2013/01/02 14:58:16 D:\www\vhost.partner\_template\content\member\popup.rolling_detail.html */?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="/css/style.css" rel="stylesheet" type="text/css" />
	<script language="javascript" src="/js/js.js"></script>
	<title>회원 상세 정보</title>
	<script>
		
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
		<h1>롤링 상세정보</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<form id="frm" name="frm" method="post" action="?act=modify">
		<input type="hidden" name="urlidx" value="<?php echo $TPL_VAR["list"]["Idx"]?>">	
		<table cellspacing="1" class="tableStyle_membersWrite" summary="회원 정보">
		<legend class="blind">쪽지 쓰기</legend>
			<tr>
			  <th>아이디</th>
			  <td><?php echo $TPL_VAR["list"]["rec_id"]?></td>
			  <th>비밀번호</th>
			  <td><input type="password" name="pwd" value="default" class="inputStyle1"></td>
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