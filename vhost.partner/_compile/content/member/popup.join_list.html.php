<?php /* Template_ 2.2.3 2013/01/01 16:38:06 D:\www\vhost.partner\_template\content\member\popup.join_list.html */?>
<script>
	
function ajax_uid_check()
{
	var uid = $('#uid').val();
	if(uid.length <= 0)
	{
		$("#ajax_message").html("아이디 입력");
		return false;
	}
	else
	{
		$.ajaxSetup({async:false});
		var param={uid:uid};
		
		$.post("/partner/addCheckAjax", param, on_uid_check);
	}
}

function on_uid_check(result)
{
	if(result==1)
	{
		$("#ajax_message").html("<font color='red'>사용 불가</font>");
	}
	else
	{
		$("#ajax_message").html("<font color='blue'>사용 가능</font>");
	}
}

function doSubmit()
{
	if($("#uid").val().length <=0)
	{
		alert("아이디를 입력하세요");
		$("#uid").focus();
		return false;
	}
	if($("#name").val().length <=0)
	{
		alert("이름을 입력하세요");
		$("#name").focus();
		return false;
	}
	if($("#phone").val().length <=0)
	{
		alert("연락처를 입력하세요");
		$("#phone").focus();
		return false;
	}
	if($("#passwd").val().length <=0)
	{
		alert("비밀번호를 입력하세요");
		$("#passwd").focus();
		return false;
	}
	
	document.form1.submit();
}
</script>

<div class="wrap">
	<h3>롤링 등록</h3>
	<form id="form1" name="form1" method="post" action="?act=add">
		<table cellspacing="1" class="tableStyle_pop">
		<legend class="blind">롤링 등록</legend>
			<tr>
				<th>아이디</th>
				<td><input name="uid" type="text" id="uid" onblur="ajax_uid_check();" /></td>
				<th>비밀번호</th>
				<td><input name="passwd" type="text" id="passwd"/></td>
		 </tr>
		 <tr>
				<th>이름</th>
				<td><input name="name" type="text" id="name"/></td>
				<th>전화번호</th>
				<td><input name="phone" type="text" id="phone"/></td>
		 </tr>
		 <tr>
				<th>메모</th>
				<td><input name="memo" type="text" id="memo"/></td>
				<th></th>
				<td><span id="ajax_message"></span></td>
		 </tr>
		</table>
	
		<div id="wrap_btn">
			<input type="button" name="open" value="등록" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="doSubmit();"/>
		</div>
	</form>
</div>