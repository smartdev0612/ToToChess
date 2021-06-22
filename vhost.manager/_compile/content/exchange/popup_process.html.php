<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>출금 신청 처리</title>
<script language="JavaScript">
		
function This_Check()
{
	if(document.frm.amount.value =="")
	{
		alert(" 금액을 입력하세요      "); 
		Document.frm.amount.focus();
		return;
	}
	else
	{
		frm.action = "?";
		frm.submit();
	}
}
		
</script>
<script language="javascript" src="/js/js.js"></script>
</head>
<body>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>출금 신청 처리</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()"></p>
	</div>
		
	<table cellspacing="1" class="tableStyle_membersWrite">
	<legend class="blind">출금승인</legend>
	
	<form name=frm method="GET">			
	<input type=hidden name='mode' value='agree'>
	<input type=hidden name=sn value=<?php echo $TPL_VAR["sn"]?>>
	<input type=hidden name=memberSn value='<?php echo $TPL_VAR["memberSn"]?>'>
		<tr>
		  <th>아이디</th>
		  <td><?php echo $TPL_VAR["mem_id"]?></td>
		</tr>
		<tr>
		  <th nowrap width="50%">처리금액</th>
		  <td><input type=text name="amount" size=15 readonly class="inputStyle2" value='<?php echo number_format($TPL_VAR["amount"],0)?>'></td>
		</tr>
		<!--<tr><th>처리금액</th><td><input type=text name="agree_amount" size=15 onkeyUp="javascript:this.value=FormatNumber(this.value);" value='<?php echo number_format($TPL_VAR["amount"],0)?>' readonly></td></tr>-->
	</form>
	</table>
	<div id="wrap_btn">
		<input type="button"  value="처 리" onclick="This_Check()" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'">
		<input type="button" value="닫 기" onclick="self.close()" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'">
	</div>
</div>
</body>
</html>