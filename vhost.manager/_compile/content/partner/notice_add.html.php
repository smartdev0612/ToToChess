<?php /* Template_ 2.2.3 2012/12/20 18:48:52 D:\www\vhost.manager\_template\content\partner\notice_add.html */?>
<script>
	
function len(s)
{ 
	var l = 0; 
	var a = s.split(""); 
	for (var i=0;i<a.length;i++)
	{ 
		if (a[i].charCodeAt(0)<299) 
		{ 
			l++; 
		} 
		else 
		{ 
			l+=2; 
		} 
	} 
	return l; 
} 

function Form_ok() {
		if (Form1.title.value == "") {
		   alert("작성자 입력!!!");
		   document.Form1.title.focus();
		   return;
		}
		
		if(Form1.name.value ==""){
			alert("작성자 선택!!!");
		    document.Form1.name.focus();
		    return;
		}
		if(Form1.time.value ==""){
			alert("시간 선택!!!");
		    document.Form1.time.focus();
		    return;
		}
		if(len(Form1.time.value) !=19){
			alert("시간 격식이 틀립니다. 확인하십시오!!!");
		    document.Form1.time.focus();
		    return;
		}
		if (confirm("입력하신 내용을 등록 하시겠습니까 ?")) {
			document.Form1.submit();
		} else {
			return;
		}
}
</script>

<div class="wrap" id="partner_notice_add">

	<div id="route">
		<h5>관리자 시스템 > 파트너 관리 > <b>공지 쓰기</b></h5>
	</div>

	<h3>공지 쓰기</h3>

	<ul id="tab">
		<li><a href="/partner/noticelist" id="partner_notice">파트너 공지</a></li>
		<li><a href="/partner/noticeadd" id="partner_notice_add">공지 쓰기</a></li>
	</ul>

	<div id="search">
		<div class="wrap">
			<form action="?" method="get" name="form2" id="form2">
			<span>아이디</span>
            <input name="username" type="text" id="key" class="name" value="<?php echo $TPL_VAR["nname"]?>" maxlength="20"/>
            <input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
			</form>
		</div>
	</div>

	<form action="?act=add" method="post"  name="Form1">
	<table cellspacing="1" class="tableStyle_membersWrite" summary="파트너 공지 쓰기">
	<legend class="blind">공지 쓰기</legend>
		<tr>
			<th>제목</th>
			<td><input name="title" type="text"  class="w600" maxlength="45"/></td>
		</tr>
		<tr>
			<th>작성자</th>
			<td><select name="name"><option value="관리자">관리자</option></select></td>
		</tr>
		<tr>
			<th>시간</th>
			<td><input name="time" type="text" class="w120" value="<?php echo date("Y-m-d H:i:s")?>"/>&nbsp;&nbsp;&nbsp;<font color="red">날자는 꼭 지정된 형식대로 적어주십시오.</font></td>
		</tr>
		<tr>
			<th>내용</th>
			<td><textarea cols="78" name="content" rows="8" ></textarea></td>
		</tr>
	</table>

	<div id="wrap_btn">
		<input type="button" name="ok" value="등  록" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="Form_ok()"/>
        <input type="reset" name="Submit2" value="초기화" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'"/>
     </div>
	</form>


</div>