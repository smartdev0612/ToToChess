<?php /* Template_ 2.2.3 2012/11/30 16:46:57 D:\www\vhost.manager\_template\content\etc\clear_jackpot.html */?>
<script>
	function sub_clear()
	{
		var result = confirm('are you suer clear away jackpot_num?');
		if(result)
		{
			document.frm.submit();
		}
  	}
</script>
</head>

<body id="members_smemo">

<div id="wrap_pop">
	<div id="pop_title">
		<h1>잭팟 초기화</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<p id="jackpotInput">
		잭팟을 초기화 합니다.<br><br>
		<input type="button" value="clear" onclick="javascript:sub_clear();" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'">
	</p>
</div>

<body>
	<table width="400" cellspacing=1 cellpadding=5 border=0 align=center height="200">
		<form name="frm" method="POST" action="?mode=clear">
			<tr width="400" height="100" align="center">
				<td align="center">
					<table width="100%" cellspacing=1 cellpadding=5 border=0 align=center bgcolor=#D0E2F7 height="100%" >
						<tr bgcolor=#f6f6f6 height=1>
							<td width="100%" colspan="2" height=1>
								<input type="button" value="clear" onclick="javascript:sub_clear();">
							</td>							
						</tr>		
					</table>
			  </td>
			</tr>
			 
		</form>
	</table>
</body>
</html>