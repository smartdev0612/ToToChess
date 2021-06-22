<?php /* Template_ 2.2.3 2012/11/30 16:47:20 D:\www\vhost.manager\_template\content\partner\popup.rate.html */?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>파트너 정산비율 수정</title>
<script language="JavaScript">
<!--
function This_Check()
{

  if (document.frm.rate.value =="")
  {
        alert(" 정산비율을 입력하세요."); 
		document.frm.rate.focus();
		return;

  }else{
		//frm.action = "?act=edit";
		frm.submit();
  }
}
//-->
</script>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../js/js.js"></script>
</head>
<body>
<table width=350 cellspacing=1 cellpadding=5 border=0 align=center>
<form name="frm" method="post" action="?act=edit">
<input type=hidden name="id" value=<?php echo $TPL_VAR["id"]?>>
<tr height=30><td class=title> 정산비율 수정</td></tr>
<tr><td height=1 bgcolor=D0E2F7></td></tr>
<tr><td height=10></td></tr>
<tr><td>
<table width=350 cellspacing=1 cellpadding=5 border=0 align=center bgcolor=#D0E2F7>
<tr bgcolor=#f6f6f6><td width=30%>아이디</td><td bgcolor=#ffffff><b><?php echo $TPL_VAR["id"]?></b></td></tr>
<tr bgcolor=#f6f6f6><td>정산비율</td><td bgcolor=#ffffff><input type="text" name="rate" size="5"  style="text-align:right;"  class="input" value="<?php echo $TPL_VAR["rate"]?>">%</td></tr>
</table>

</td></tr>
 <tr height=50 align=center>
  <td><input type="button" style="border:solid 1px #b1b1b1;background:#ffffff" value="실행하기" onclick="This_Check()";>&nbsp;&nbsp; <input type="button" style="border:solid 1px #b1b1b1;background:#ffffff" value="창닫기" onclick="self.close()"></td>
</tr>
</form>
</table>
</body>
</html>