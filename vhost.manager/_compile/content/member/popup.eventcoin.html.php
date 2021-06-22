<?php /* Template_ 2.2.3 2012/11/30 16:47:11 D:\www\vhost.manager\_template\content\member\popup.eventcoin.html */?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $TPL_VAR["strshow"]?></title>
<script language="JavaScript">

function This_Check()
{	
  if (document.frm.amount.value ==""  )
  {
    alert(" 금액을 입력하세요."); 
		document.frm.amount.focus();
		return;
  }else{
  	
  	document.frm.action = "?";
		document.frm.submit();
  }
}

</script>
</head>
<body>
	
	<table width=350 cellspacing=1 cellpadding=5 border=0 align=center>
		<form name=frm method="post" >
			<input type="hidden" name="mode" value='modify'>
			<input type="hidden" name="sn" value=<?php echo $TPL_VAR["sn"]?>>
			
			<tr height=30><td class=title>이벤트 코인수정</td></tr>
			<tr><td height=1 bgcolor=D0E2F7></td></tr>
			<tr><td height=10></td></tr>
			<tr><td>
			<table width=350 cellspacing=1 cellpadding=5 border=0 align=center bgcolor=#D0E2F7>
				<tr bgcolor=#f6f6f6><td width=30%>아이디</td><td bgcolor=#ffffff><b><?php echo $TPL_VAR["uid"]?></b></td></tr>
				<tr bgcolor=#f6f6f6><td>거래구분</td><td bgcolor=#ffffff><input type="radio" name="radio" value="0" checked>증가&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="radio" value="1"><font color=red>차감</font></td></tr>			
				<tr bgcolor=#f6f6f6><td>이벤트코인</td><td bgcolor=#ffffff><input type="text" name="coin" size=15 readonly  style="text-align:right;"  class=input value='<?php echo $TPL_VAR["coin"]?>'></td></tr>		
				<tr bgcolor=#f6f6f6>
					<td>증가/차감 금액</td>
					<td bgcolor=#ffffff>
						<input type="text" name="amount" size=15 value="0" class="w250" onkeyUp="javascript:this.value=FormatNumber(this.value);" style="text-align:right;" >
					</td>
				</tr>
			</table>			
			</td></tr>
			<tr height=50 align=center>
			 <td><input type="button" name="queding"  value="실행하기" onclick="This_Check()";>&nbsp;&nbsp; <input type="button"  value="창닫기" onclick="self.close()"></td>
			</tr>
		</form>
	</table>
	
</body>
</html>