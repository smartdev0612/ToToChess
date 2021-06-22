<?php /* Template_ 2.2.3 2012/11/30 16:47:14 D:\www\vhost.manager\_template\content\member\popup.note_write.html */?>
<script>
	function checknull()
	{	
		var fm=document.form1;
		
		val=CheckStr(fm.content.value," ",'');
		if(val==0)
		{
			alert("내용을 입력하십시오.");
			fm.content.focus();
			return;
		}
		
		fm.submit();
	}
	</script>
</head>

<body>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>메모쓰기</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<form method="post" name="form1" action="?">	
	<input type="hidden" id="act" name="act" value="send">
	<input type="hidden" name="idx" value="<?php echo $TPL_VAR["mem_idx"]?>">
	<input type="hidden" name="context_idx" value="<?php echo $TPL_VAR["context_idx"]?>">
	<input type="hidden" name="regdate" value="<?php echo $TPL_VAR["regdate"]?>">
	
	<table cellspacing="1" class="tableStyle_membersWrite" summary="메모쓰기">
	<legend class="blind">쪽지 쓰기</legend>
		<tr>
	
		  <th>내용</th>
		  <td>
			
			<textarea rows="2" name="content" maxlength="200"><?php echo $TPL_VAR["content"]?></textarea>
		   </td>
		</tr>
	</table>
	<div id="wrap_btn">
	  <input type="button" value="저장" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="checknull();" >
	  &nbsp;
	  <input type="button" value="취 소" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="window.close();">
	</div>
	</form>
</div>

</body>
</html>