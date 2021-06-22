<?php /* Template_ 2.2.3 2012/11/30 16:46:48 D:\www\vhost.manager\_template\content\board\popup.update_hit.html */?>
<title>회원 상세 정보</title>
	<script>
	function pressCheck(gubun) {
		if ( event.keyCode >= 48 && event.keyCode <= 57 ){ 	// 숫자만 입력가능.
			event.returnValue = true;
		}else {
			event.returnValue = false;
		}
}

	function go(url){
	var result = confirm('정말로 전환 하시겠습니까?');
	if(result){
		location.href=url;
	}
  }
</script>
</head>
<body>
	<table width="290" cellspacing=1 cellpadding=5 border=0 align=center height="95">
		<form name="frm" method="POST" action="?mode=edit">
	<input type="hidden" name="id" value="<?php echo $TPL_VAR["id"]?>">
			<tr width="290" height="95" align="center">
				<td align="center">
					<table width="100%" cellspacing=1 cellpadding=5 border=0 align=center bgcolor=#D0E2F7 height="100%" >
						<tr bgcolor=#f6f6f6 height=1>
							<td width="20%">조회</td>
							<td width="80%"><input type="text" name="hit" value="<?php echo $TPL_VAR["hit"]?>" onkeypress="javascript:pressCheck()"></td>
						</tr>		
						<tr bgcolor=#f6f6f6 >
							<td width="100%" bgcolor=#ffffff colspan="2" align="center" >							
								<input type="submit" value="저장" ><!--保存-->
							</td>							
						</tr>			
					</table>
			  </td>
			</tr>
		</form>
	</table>
</body>
</html>