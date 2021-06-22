<?php /* Template_ 2.2.3 2012/10/10 00:23:48 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\content.charge.agree.html */?>
<script language="JavaScript">
		function This_Check()
		{
			if (document.frm.g_money.value =="")
			{
				alert(" 금액을 입력하세요      "); 
				document.frm.g_money.focus();
				return;
	
			}
			else
			{
				frm.action = "/charge/agree";
				frm.submit();
			}
		}
	</script>

</head>

<body>
	<table width=350 cellspacing=1 cellpadding=5 border=0 align=center>
		<form name=frm method="GET">
			<input type=hidden name=mode value='add'>
			<input type=hidden name=idx value=<?php echo $TPL_VAR["idx"]?>>
			<input type=hidden name=money_idx value='<?php echo $TPL_VAR["money_idx"]?>'>
			
			<tr height=30><td class=title> 충전 신청 처리</td></tr>
			<tr><td height=1 bgcolor=D0E2F7></td></tr>
			<tr><td height=10></td></tr>
			<tr><td>
			<table width=350 cellspacing=1 cellpadding=5 border=0 align=center bgcolor=#D0E2F7>
			<tr bgcolor=#f6f6f6><td width=30%>아이디</td><td bgcolor=#ffffff><b><?php echo $TPL_VAR["mem_id"]?></b></td></tr>
			
	
			<tr bgcolor=#f6f6f6><td>신청금액</td>
				<td bgcolor=#ffffff><input type=text name=rmoney size=15 readonly  style="text-align:right;"  class=input value='<?php echo number_format($TPL_VAR["rmoney"],0)?>'></td>
			</tr>
	
			<tr bgcolor=#f6f6f6><td>처리금액</td>
				<td bgcolor=#ffffff>
					<input type=text name=g_money size=15 onkeyUp="javascript:this.value=FormatNumber(this.value);" style="text-align:right;"  class=input value='<?php echo number_format($TPL_VAR["rmoney"],0)?>'>
				</td>
			</tr>
	
			<tr bgcolor=#f6f6f6><td>마일리지</td><td bgcolor=#ffffff><input type=text name=point size=15 onkeyUp="javascript:this.value=FormatNumber(this.value);" style="text-align:right;"  class=input value=''></td></tr>
			</table>
	
			</td></tr>
			 <tr height=50 align=center>
			  <td><input type="button" class=input value="충 전" onclick="This_Check()";>&nbsp;&nbsp; <input type="button" class=input value="닫 기" onclick="self.close()"></td>
			</tr>
		</form>
	</table>
</body>
</html>