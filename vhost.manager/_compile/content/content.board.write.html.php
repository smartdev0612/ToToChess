<?php /* Template_ 2.2.3 2012/10/08 01:55:20 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\content.board.write.html */
$TPL_muneList_1=empty($TPL_VAR["muneList"])||!is_array($TPL_VAR["muneList"])?0:count($TPL_VAR["muneList"]);
$TPL_nickList_1=empty($TPL_VAR["nickList"])||!is_array($TPL_VAR["nickList"])?0:count($TPL_VAR["nickList"]);
$TPL_replyList_1=empty($TPL_VAR["replyList"])||!is_array($TPL_VAR["replyList"])?0:count($TPL_VAR["replyList"]);?>
<script charset="utf-8" src="/web_editor_cocopa/kindeditor.js"></script>

<script>
function len(s) 
{ 
	var l = 0; 
	var a = s.split(""); 
	for (var i=0;i<a.length;i++) 
	{
		if (a[i].charCodeAt(0)<299) {l++;} 
		else {l+=2;} 
	} 
	return l; 
}

function Form_ok() 
{
	if (Form1.title.value == "") 
	{
		alert("제목 입력!!!");
		document.Form1.title.focus();
		return;
	}
	if(Form1.province.value == "")
	{
		alert("분류 선택!!!");
		document.Form1.province.focus();
		return;
	}
	if(Form1.author.value =="")
	{
		alert("작성자 선택!!!");
		document.Form1.author.focus();
		return;
	}
	if(Form1.time.value =="")
	{
		alert("시간 선택!!!");
		document.Form1.time.focus();
		return;
	}
	if(len(Form1.time.value) !=19)
	{
		alert("시간 격식이 틀립니다. 확인하십시오!!!");
		document.Form1.time.focus();
		return;
	}
	
	if (confirm("입력하신 내용을 등록 하시겠습니까 ?"))
	{
		document.Form1.imgsrc.value=KE.util.getpic('on');
		document.Form1.submit();
	}
	else {return;}
}

function check_reply()
{
	if(document.reply.comment.value=="")
	{
		alert("리플 내용을 입력하십시오.!");
		document.reply.comment.focus();
		return;
	}
	reply.submit();
}

function goDel(delidx,idx)
{
	var result = confirm('삭제 하시겠습니까?');
	if(result) {location.href="?act=delcomment&delid="+delidx+"&urlid="+idx;}	
}

function checkNumber(e)
{
	var key = window.event ? e.keyCode : e.which;
	var keychar = String.fromCharCode(key);
	//var el = document.getElementById('test');
	var msg = document.getElementById('msg');
	reg = /\d/;
	var result = reg.test(keychar);
	if(!result)
	{
		msg.innerHTML="<font color='red'>숫자만 입력 가능합니다.</font>";
		return false;
	}
	else
	{
		msg.innerHTML="";
		return true;
	}
}
</script>



<!-- content begin -->

<div class="wrap" id="write">

	<div id="route">
		<h5>관리자 시스템 > 게시판 관리 > <b>게시글 쓰기</b></h5>
	</div>

	<h3>게시글 쓰기</h3>

	<ul id="tab">
		<li><a href="type.php" id="type">분류 관리</a></li>
		<li><a href="Article.php" id="article">게시물 관리</a></li>
		<li><a href="bbs.php" id="bbs">게시판</a></li>
		<li><a href="question_list.php" id="question_list">고객센터</a></li>
		<li><a href="write.php" id="write">게시물 쓰기</a></li>
	</ul>

	<form action="write_ok.php?id=<?php echo $TPL_VAR["id"]?>" method="post" name="Form1">
		<input type="hidden" name="imgsrc"  value="">
		<table cellspacing="1" class="tableStyle_membersWrite" summary="게시글 쓰기">
		<legend class="blind">게시글 쓰기</legend>
		<tr>
			<th>제목</th>
			<td><input name="title" type="text" class="wWhole"  value='<?php echo str_replace("'","\'",$TPL_VAR["list"]["title"])?>' onmouseover="this.focus()"></td>
		  </tr>
		  <tr>
			<th>분류</th>
			<td>
				<select name="province"><option value="">분류 선택</option>
<?php if($TPL_muneList_1){foreach($TPL_VAR["muneList"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1["id"]?>" <?php if($TPL_V1["id"]==$TPL_VAR["list"]["province"]){?> selected <?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
				</select>
			</td>
		  </tr>
		  <tr>
			<th>작성자</th>
			<td>
				<select name="author"><option value="관리자">관리자</option>
<?php if($TPL_nickList_1){foreach($TPL_VAR["nickList"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1["nick"]?>" <?php if($TPL_V1["nick"]==$TPL_VAR["list"]["author"]){?> selected <?php }?>><?php echo $TPL_V1["nick"]?></option>
<?php }}?>
				</select>
			</td>
		  </tr>
		  <tr>
			<th>시간</th>
			<td><input name="time" type="text"  class="w250" value="<?php if(!empty($TPL_VAR["id"])){?> <?php echo $TPL_VAR["list"]["time"]?> <?php }else{?> <?php echo $TPL_VAR["nowTime"]?> <?php }?>"/>&nbsp;<font color="red">날자는 꼭 지정된 형식대로 적어주십시오.</font>
			</td>
		  </tr>
		  <tr>
			<th>조회</th>
			<td><input name="hit" type="text"  value="<?php echo $TPL_VAR["list"]["hit"]?>" class="w60" onkeypress="return checkNumber(event);" onmouseover="this.focus()" onmouseover="this.focus()"/><span id="msg"></span></td>
		  </tr>
		  <tr>
			<th>추천</th>
			<td>
				<input name="top" type="radio"  value="1" <?php if($TPL_VAR["list"]["top"]==1){?> checked="checked" <?php }else{?> checked="checked <?php }?> class="recomInput"/> 추천안함
				<input name="top" type="radio"  value="2" <?php if($TPL_VAR["list"]["top"]==2){?> checked="checked" <?php }?> class="recomInput"/> 추천
				<span style="padding-left:30px;"><font color="red">↓이미지 업로드 경우 이미지 넓이를 무조건 720 이하로 설정하여 주십시오.</font></span
			</td>
		  </tr>
		  <tr>
			<th>내용</th>
			<td>
			<textarea id="on" name="content" cols="80" rows="4" onmouseover="this.focus()">
				<?php echo str_replace("/upload/images/",$TPL_VAR["UPLOAD_URL"],$TPL_VAR["list"]["content"])?>

			</textarea>
			<script>       
				KE.show({   id 			: "on", 
							width 		: "650px",
							height 		: "350px",
							filterMode 	: true,
							resizeMode 	: 1 ,
							items 		: [
											'source','|','fontname', 'fontsize', '|', 'textcolor', 'bgcolor', 'bold', 'italic', 'underline',
											'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
											'insertunorderedlist', '|',  'image', 'link','advtable']
			   			});
			</script>
			</td>
		  </tr>
		</table>
		<div id="wrap_btn">
	      <input type="button" name="ok" value="등  록" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="Form_ok()"/>
	      <input type="reset" name="Submit2" value="초기화" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'"/></td>
	    </div>
	</form>
	
<?php if(isset($TPL_VAR["id"])){?>
<?php if($TPL_replyList_1){foreach($TPL_VAR["replyList"] as $TPL_V1){?>
			<table cellspacing="1" class="tableStyle_comment" summary="댓글 목록">
				<legend class="blind">댓글 목록</legend>
				<tr>
					<th>
<?php if($TPL_V1["mem_id"]=="관리자 리플"){?>
							<font color='red'><?php echo $TPL_V1["mem_nick"]?></font>
<?php }else{?>
							<?php echo $TPL_V1["mem_nick"]?>

<?php }?>
						
					</th>
					<td><textarea cols="60" rows="2" class="replyContents" readonly><?php echo $TPL_V1["content"]?></textarea></td>
					<td><?php echo $TPL_V1["regdate"]?></td>
					<td><a href="javascript:goDel(<?php echo $TPL_V1["idx"]?>,<?php echo $TPL_VAR["id"]?>);void(0);">[삭제]</a></td>
				</tr>
			</table>
<?php }}?>
<?php }?>
	
	<form name="reply" action="?mode=reply" method="post">
	<input type="hidden" name="replyid" value="<?php echo $TPL_VAR["id"]?>">
	<table cellspacing="1" class="tableStyle_comment" summary="댓글 쓰기">
	<legend class="blind">댓글 쓰기</legend>
	<tr>
	<th>
	<select name="name">
		<option value="관리자">관리자</option>
<?php if($TPL_nickList_1){foreach($TPL_VAR["nickList"] as $TPL_V1){?>
			<option value="<?php echo $TPL_V1["nick"]?>"><?php echo $TPL_V1["nick"]?></option>
<?php }}?>
	</select>
	</th>
	<td><textarea  name="comment" class="replyContents"></textarea></td>
	<td><input type="button" name="ok" value="답변" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="check_reply()"></td>
	</tr>
	</table>
	</form>
</div>