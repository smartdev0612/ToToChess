<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7">
<meta name="author" content="" />
<meta name="copyright" content="" />
<title> 파트너 쪽지 쓰기</title>
<link href="../css/common.css" rel="stylesheet" type="text/css" />
<link href="../css/article.css" rel="stylesheet" type="text/css" />
<script>
function len(s)
{ 
	var l = 0; 
	var a = s.split(""); 
	for (var i=0;i<a.length;i++) 
	{ 
		if(a[i].charCodeAt(0)<299)
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
function Form_ok() 
{
		FormData = document.FormData;
		if (FormData.title.value == "") {
		   alert("제목 입력!!!");
		   document.FormData.title.focus();
		   return;
		}
		if(FormData.time.value ==""){
			alert("시간 선택!!!");
		    document.FormData.time.focus();
		    return;
		}
		if(len(FormData.time.value) !=19){
			alert("시간 격식이 틀립니다. 확인하십시오!!!");
		    document.FormData.time.focus();
		    return;
		}
		if (FormData.content.value == "") {
		   alert("내용 입력!!!");
		   document.FormData.content.focus();
		   return;
		}
		if (confirm("입력하신 내용을 등록 하시겠습니까 ?")) {
		
			document.FormData.submit();
		} else {
			return;
		}
}

</script>
</head>

<body>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>파트너에게 메모 쓰기</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>
	<form action="?act=add" method="post"  name="FormData" id="FormData" >
	<table cellspacing="1" class="tableStyle_membersWrite" summary="쪽지 쓰기">
	<legend class="blind">쪽지 쓰기</legend>
		<tr>
			<th>제목</th>
			<td><input name="title" type="text" class="inputStyle2" maxlength="45"/></td>
		</tr>
		<tr>
			<th>받는이</th>
			<td><input type="text" value="<?php echo $TPL_VAR["send"]?>" name="toid" readonly size="10"  class="inputStyle2"></td>
		</tr>
		<tr>
			<th>날짜</th>
			<td><input type="text" name="time" value="<?php echo date("Y-m-d H:i:s")?>" /></td>
		</tr>
		<tr>
			<th>내용</th>
			<td><textarea cols="70" name="content" rows="10" ></textarea></td>
		</tr>
	</table>
	<div id="wrap_btn">
		<input type="button" name="Submit" value="발  송" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'" onclick="Form_ok();"/>
        <input type="reset" name="Submit2" value="초기화" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'"/>		
	</div>
   
  </form>
</div>
<?php 
//include "../main_foot.php";
?>
</body>
</html>