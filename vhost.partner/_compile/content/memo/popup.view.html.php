<?php /* Template_ 2.2.3 2012/11/30 16:56:52 D:\www\vhost.partner\_template\content\memo\popup.view.html */?>
<title>쪽지함 -  [쪽지 내용]</title>
<script>
function comfire_ok(url)
	{
		falg=window.confirm("정말 삭제 하렵니까?"); 
		if(falg)
		{
				location.href=url;
		}
	}
</script>
</head>
<body >
<table width="98%" align="center" border="0" cellpadding="4" cellspacing="1" bgcolor="#CBD8AC" style="margin-bottom:8px;font-size:12px;">
  <tr bgcolor="#EEF4EA">
    <td colspan="5" background="skin/images/frame/wbg.gif" class='title'><span>쪽지함 - 쪽지 내용</span></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td width="10%" bgcolor="#FFFFFF"><div align="center">보낸이</div></td>
    <td colspan="4" bgcolor="#FFFFFF"><?php echo $TPL_VAR["list"]["fromid"]?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td width="10%" bgcolor="#FFFFFF"><div align="center">제목</div></td>
    <td colspan="4" bgcolor="#FFFFFF"><?php echo $TPL_VAR["list"]["title"]?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td width="10%" bgcolor="#FFFFFF"><div align="center">시간</div></td>
    <td colspan="4" bgcolor="#FFFFFF"><?php echo $TPL_VAR["list"]["writeday"]?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td width="10%" bgcolor="#FFFFFF"><div align="center">내용</div></td>
    <td colspan="4" bgcolor="#FFFFFF" height="300" valign="top"><?php echo $TPL_VAR["list"]["content"]?></td>
  </tr>
  
  <tr bgcolor="#FFFFFF">
    <td align="center" colspan="5"><input type="button" value="[회답]" style="border:solid 1px #b1b1b1;background:#ffffff" onclick="location.href='/memo/popup_write'">&nbsp;&nbsp;&nbsp;<input type="button" value="[목록]" style="border:solid 1px #b1b1b1;background:#ffffff" onclick="location.href='/memo/popup_list'">&nbsp;&nbsp;&nbsp;<input type="button" value="[삭제]" style="border:solid 1px #b1b1b1;background:#ffffff" onclick="comfire_ok('?act=del&id=<?php echo $TPL_VAR["id"]?>')"></td>

  </tr>

</table>
</body>
</html>