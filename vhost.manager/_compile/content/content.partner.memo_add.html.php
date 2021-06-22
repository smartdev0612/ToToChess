<?php /* Template_ 2.2.3 2012/10/10 12:21:03 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\content.partner.memo_add.html */?>
<?php
/*
	include "../include/common.php";
	if(isset($_REQUEST["act"])&&$_REQUEST["act"]=="add")
	{
		$title=trim($_REQUEST["title"]);
		$toid=$_REQUEST["toid"];
		$time=trim($_REQUEST["time"]);
		$content=trim($_REQUEST["content"]);
		$content=htmlspecialchars($content);
		if($toid=="전체파트너")
		{
			$sql="select rec_id from ".$db_qz."recommend where logo='".$logo."' order by Idx desc";
			$db->mysql=$sql;
			$db->getresule();
			while($db->getrow()){
				$toid=$db->row["rec_id"];
				$conn = new createdb; //인스턴스 시작 
				$conn->createconn();
				$sql="insert into ".$db_qz."memoboard (fromid,toid,title,content,writeday,kubun,logo) values('운영팀','".$toid."','".$title."','".$content."','".$time."','1','".$logo."')";
				$conn->mysql=$sql;
				$conn->getresule();
			}
			$conn->dbclose();
		}else{
			$sql="insert into ".$db_qz."memoboard (fromid,toid,title,content,writeday,kubun,logo) values('운영팀','".$toid."','".$title."','".$content."','".$time."','1','".$logo."')";
			$db->mysql=$sql;
			$db->getresule();
		}
		$db->dbclose();
		
		echo "<script>alert('발송되였습니다.');</script>";
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=partner_memo.php'>";
		exit;
	}
	if($_REQUEST["toid"]!="")
	{
		$send=$_REQUEST["toid"];
	}else{
		$send="전체파트너";
	}
	*/
?>

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
		} else
		{ 
			l+=2; 
		}	 
	} 
	return l; 
}
 
function Form_ok() 
{
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
		}
		else 
		{
			return;
		}
}
</script>

<div class="wrap" id="partner_memo_add">

	<div id="route">
		<h5>관리자 시스템 > 파트너 관리 > <b>쪽지 쓰기</b></h5>
	</div>

	<h3>쪽지 쓰기</h3>

	<ul id="tab">
		<li><a href="/partner/memolist" id="partner_memo_box">받은 쪽지함</a></li>
		<li><a href="/partner/memosendlist" id="partner_memo">보낸 쪽지함</a></li>
		<li><a href="/partner/memoadd" id="partner_memo_add">쪽지 쓰기</a></li>
	</ul>

	<form action="?act=add" method="post"  name="FormData" id="FormData" >
	<table cellspacing="1" class="tableStyle_membersWrite" summary="파트너 메모 쓰기">
	<legend class="blind">메모 쓰기</legend>
		<tr>
			<th>제목</th>
			<td><input name="title" type="text"  class="wWhole" maxlength="45"/></td>
			</tr>
		<tr>
			<th>받는이</th>
			<td><input type="text" value="<?php echo $TPL_VAR["send"]?>" name="toid" readonly size="10" class="w120"><font color="red"> *개별적인 파트너한테 쪽지 보내기는 파트너 목록에서 하십시오.</font></td>
		</tr>
		<tr>
			<th>날짜</th>
			<td><input type="text" name="time"  value="<?php echo date("Y-m-d H:i:s");?>" class="w120"/></td>
		</tr>
		<tr>
			<th>내용</th>
			<td><textarea name="content" rows="10" ></textarea></td>
		</tr>
	</table>

	<div id="wrap_btn">
		<input type="button" name="Submit" value="발  송" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="Form_ok();"/>
        <input type="reset" name="Submit2" value="초기화" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'"/></td>
    </div>
	</form>

</div>