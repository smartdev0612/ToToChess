<?php /* Template_ 2.2.3 2012/10/09 22:50:09 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\popup.member.memo_write.html */?>
<script>
		function checknull()
		{
			var fm=document.form1;
			var val=CheckStr(fm.toid.value," ",'');
			if(val==0)
			{
				alert("받는이를 입력하세요");
				fm.toid.focus();
				return;
			}
			val=CheckStr(fm.subject.value," ",'');
			if(val==0)
			{
				alert("제목을 입력하십시오.")
				fm.subject.focus();
				return;
			}
			val=CheckStr(fm.content.value," ",'');
			if(val==0)
			{
				alert("쪽지 내용을 입력하십시오.");
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
		<h1>쪽지 쓰기</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<form method="post" name="form1" action="?act=send">	
		<table cellspacing="1" class="tableStyle_membersWrite" summary="쪽지 쓰기">
			<legend class="blind">쪽지 쓰기</legend>
				<tr>
				  <th>보내는이</th>
				  <td><input type=text name="fromid" maxlength="17" value="운영팀" class="w250" readonly /></td>
				</tr>
				<tr>
				  <th>받는이</th>
				  <td><input type="text" name="toid" size="20" maxlength="50"  value="<?php echo $TPL_VAR["userid"]?>" class="w250" readonly /></td>
				</tr>
				<tr>
				  <th>제목</th>
				  <td><input type="text" name="subject" maxlength="50" class="wWhole"/></td>
				</tr>
				<tr>
				  <th>내용</th>
				  <td>
					<input type="checkbox" name="onlysms" value="1"> only-sms
					<textarea rows="8" name="content"></textarea>
				   </td>
				</tr>
		</table>
		<div id="wrap_btn">
		  <input type="button" value="보내기" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="checknull()">
		  &nbsp;
		  <input type="button" value="취 소" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="window.close();">
		</div>
	</form>
</div>

</body>
</html>