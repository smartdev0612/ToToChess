<?php /* Template_ 2.2.3 2012/10/23 19:42:58 C:\APM_Setup\htdocs\www\vhost.partner\_template\content\question\popup.write.html */?>
<title>1:1 문의 하기</title>
<script>
function Form_ok() {
		if (Form1.title.value == "") {
		   alert("제목 입력!!!");
		   document.Form1.title.focus();
		   return;
		}
		
		if(Form1.content.value ==""){
			alert("내용 입력!!!");
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
<body>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>1:1문의 쓰기</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>
	<form action="?act=add" method="post"  name="Form1">
	<table cellspacing="1" class="tableStyle_membersWrite" summary="1:1문의 쓰기">
	<legend class="blind">1:1문의 쓰기</legend>
	<tr>
		<th>제목</th>
		<td><input type="text" name="title" class="w250" ></td>
	</tr>
	<tr>
		<th>내용</th>
		<td><textarea rows='17' cols='69' name="content" ></textarea></td>
	</tr>
	</table>
	<div id="wrap_btn">
		<input type="button" value="발송" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'" onclick="Form_ok()">
		<input type="button" value="취소" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'" onclick="window.close();">
	</div>
	</form>
</div>
</body>
</html>