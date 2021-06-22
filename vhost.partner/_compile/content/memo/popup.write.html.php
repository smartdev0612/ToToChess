<?php /* Template_ 2.2.3 2012/11/30 16:56:52 D:\www\vhost.partner\_template\content\memo\popup.write.html */?>
<title>쪽지 쓰기</title>
<script>

function Form_ok() {
		if (Form1.title.value == "") {
		   alert("제목 입력!!!");
		   document.Form1.title.focus();
		   return;
		}
		
		if(Form1.content.value ==""){
			alert("내용 선택!!!");
		    document.Form1.content.focus();
		    return;
		}
		
		if (confirm("입력하신 내용을 발송 하시겠습니까 ?")) {
			document.Form1.submit();
		} else {
			return;
		}
}

</script>
</head>

<body id="memo_write">

<div id="wrap_pop">

	<div id="pop_title">
		<h1>쪽지 쓰기</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<ul id="tab">
		<li><a href="/memo/popup_list" id="memo_list">받은 쪽지함</a></li>
		<li><a href="/memo/popup_sendlist" id="memo_sendlist">보낸 쪽지함</a></li>
		<li><a href="/memo/popup_write" id="memo_write">쪽지 쓰기</a></li>
	</ul>

	<form action="?act=add" method="post"  name="Form1">
		<table cellspacing="1" class="tableStyle_membersWrite" summary="쪽지 쓰기">
		<legend class="blind">쪽지 쓰기</legend>
		<tr>
			<th>제목</th>
			<td><input type="text" name="title" class="w250" onmouseover="this.focus()"></td>
		</tr>
		<tr>
			<th>받는이</th>
			<td><input type="text" name="toid" class="w250" value="운영팀" readonly></td>
		</tr>
		<tr>
			<th>시간</th>
			<td><input type="text" name="time" value="<?php echo date("Y-m-d H:i:s")?>" class="w250" readonly></td>
		</tr>
		<tr>
			<th>내용</th>
			<td><textarea rows='17' cols='69' name="content" onmouseover="this.focus()"></textarea></td>
		</tr>
		</table>
	
		<div id="wrap_btn">
			<input type="button" value="발 송" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'" onclick="Form_ok()">
			<input type="button" value="목록으로" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'" onclick="location.href='/memo/popup_list'">
		</div>
	</form>

</div>
</body>
</html>