<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<title>글 보기/쓰기</title>

<script Language='Javascript'>
function openNewWindow(msg) 
{ 
	window.open("../memo/memowrite_acc.php?userid="+msg, "쪽지함", "scrollbars=yes,resizable=no,copyhistory=no,width=650,height=300");
} 
 function check_reply() {
	var frm = document.bbs;
	
	if (frm.comment.value == "") {
	   alert("내용을 쓰십시오!!!");
	   frm.comment.focus();
	   return false;
	} 

	frm.submit();
}
function addChar(t) {
	if(t=='qna_1')
	{
		var comment = $('#qna_1').val();
		$('#comment').val(comment);
		return;
	}
	if(t=='qna_2')
	{
		var comment = $('#qna_2').val();
		$('#comment').val(comment);
		return;
	}
	if(t=='qna_3')
	{
		var comment = $('#qna_3').val();
		$('#comment').val(comment);
		return;
	}
	if(t=='qna_4')
	{
		var comment = $('#qna_4').val();
		$('#comment').val(comment);
		return;
	}
	if(t=='qna_5')
	{
		var comment = $('#qna_5').val();
		$('#comment').val(comment);
		return;
	}
	if(t=='qna_6')
	{
		var comment = $('#qna_6').val();
		$('#comment').val(comment);
		return;
	}
	if(t=='qna_7')
	{
		var comment = $('#qna_7').val();
		$('#comment').val(comment);
		return;
	}
	if(t=='qna_8')
	{
		var comment = $('#qna_8').val();
		$('#comment').val(comment);
		return;
	}
	if(t=='qna_9')
	{
		var comment = $('#qna_9').val();
		$('#comment').val(comment);
		return;
	}
	if(t=='qna_10')
	{
		var comment = $('#qna_10').val();
		$('#comment').val(comment);
		return;
	}
    if(t=='qna_main')
    {
        var comment = $('#qna_main').val();
        $('#comment').val(comment);
        return;
    }
}
function goDel(delidx,idx)
{
	var result = confirm('삭제하시겠습니까?');
	if(result){
		location.href="?mode=del&delidx="+delidx+"&urlidx="+idx;
	}	
}
function sms(url){
window.open(url,'','scrollbars=yes,width=200,height=250,left=100,top=100');
}
</script>
</head>

<body>

<div class="wrap" id="question_list">

	<div id="route">
		<h5>관리자 시스템 > 게시판 관리 > <b>글 보기/수정</b></h5>
	</div>

	<h3>글 보기/수정</h3>

	<ul id="tab">
		<li><a href="/board/list?province=5" id="freeboard">자유게시판</a></li>
		<li><a href="/board/list?province=2" id="notice">공지사항</a></li>
		<li><a href="/board/list?province=7" id="event">이벤트</a></li>
		<li><a href="/board/questionlist" id="question_list">고객센터</a></li>
<?php
	//-> 관리자 시퀀스가 1000 이상이면 뷰모드관리자
	if ( $_SESSION['member']['sn'] < 1000 ) {
?>
		<li><a href="/board/write" id="write">게시물 쓰기</a></li>
		<li><a href="/board/site_rule_edit?type=1" id="member_rule">회원약관 수정</a></li>
		<li><a href="/board/site_rule_edit?type=2" id="betting_rule">배팅규정 수정</a></li>
<?php
	}
?>
	</ul>

 	<form name="bbs" action="?mode=add" method="post">
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>	
		<input type="hidden" name="idx" value="<?php echo $TPL_V1["idx"]?>">
		<table cellspacing="1" class="tableStyle_membersWrite" summary="게시글 쓰기">
		<legend class="blind">게시글 쓰기</legend>
		<tr>
	        <th>사이트</th>
	        <td><p class="replyUse2"><?php if($TPL_V1["logo"]=='totobang'){?>모스A<?php }elseif($TPL_V1["logo"]=='orange'){?>모스B<?php }?></p>
			</td>
      </tr>
	      <tr>
	        <th>제목</th>
	        <td><p class="replyUse2"><?php echo $TPL_V1["subject"]?></p>
			</td>
      </tr>
      <tr>
     		<th>아이디/닉네임/이름</th>
     		<td><a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V1["sn"]?>',1024,600)">[<?php echo $TPL_V1["uid"]?>]::[<?php echo $TPL_V1["nick"]?>]::[<?php echo $TPL_V1["bank_member"]?>]</a></td>
      </tr>
      <tr>
        <th>등급</th>
        <td><?php echo $TPL_V1["lev_name"]?></td>
      </tr>
      <tr>
        <th>최종도메인</th>
        <td><?php echo $TPL_V1["login_domain"]?></td>
      </tr>
      <tr>
        <th>은행명</th>
        <td><?php echo $TPL_V1["bank_name"]?></td>
      </tr>
		  <tr>
	        <th>시간</th>
	        <td><?php echo $TPL_V1["question_regdate"]?></td>
	      </tr>
		  <tr>
			<th>내용</th>
	        <td><?php echo $TPL_V1["content"]?></td>
	    </tr>	
<?php }}?> 
<?php if(is_array($TPL_R1=count((array)$TPL_VAR["relist"])>0)&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		  <tr>		
				<input type="hidden" name="upcontent" value="1">
				<input type="hidden" name="qidx" value="<?php echo $TPL_VAR["relist"]["idx"]?>">
				<th>답변</th>
		    <td><textarea rows="20" cols="70" name="comment"><?php echo str_replace("<br>",chr(13),$TPL_VAR["relist"]["content"])?></textarea>
					<input type="button" name="ok"  value="답변" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'" onclick="check_reply()">
				</td>
			</tr>	
<?php }}else{?>
			<th>답변</th>
			<td bgcolor="#FFFFFF"><textarea rows="20" cols="70" name="comment" id='comment'><?php echo str_replace("<br>",chr(13),$TPL_VAR["relist"]["content"])?></textarea><input type="button" name="ok"  value="답변" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'" onclick="check_reply()"></td>

<?php }?>
    </table>
	 <input type=hidden name='qna_1' id='qna_1' value='<?php echo $TPL_VAR["admin"]["qna_1"]?>'/>
	 <input type=hidden name='qna_2' id='qna_2' value='<?php echo $TPL_VAR["admin"]["qna_2"]?>'/>
	 <input type=hidden name='qna_3' id='qna_3' value='<?php echo $TPL_VAR["admin"]["qna_3"]?>'/>
	 <input type=hidden name='qna_4' id='qna_4' value='<?php echo $TPL_VAR["admin"]["qna_4"]?>'/>
	 <input type=hidden name='qna_5' id='qna_5' value='<?php echo $TPL_VAR["admin"]["qna_5"]?>'/>
	 <input type=hidden name='qna_6' id='qna_6' value='<?php echo $TPL_VAR["admin"]["qna_6"]?>'/>
	 <input type=hidden name='qna_7' id='qna_7' value='<?php echo $TPL_VAR["admin"]["qna_7"]?>'/>
	 <input type=hidden name='qna_8' id='qna_8' value='<?php echo $TPL_VAR["admin"]["qna_8"]?>'/>
	 <input type=hidden name='qna_9' id='qna_9' value='<?php echo $TPL_VAR["admin"]["qna_9"]?>'/>
	 <input type=hidden name='qna_10' id='qna_10' value='<?php echo $TPL_VAR["admin"]["qna_10"]?>'/>
     <input type=hidden name='qna_main' id='qna_main' value='<?php echo $TPL_VAR["admin"]["qna_main"]?>'/>

	<div id="wrap_btn">
        <input type="button" value="기본답변" onclick="JavaScript:addChar('qna_main');" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
		<input type="button" value="2등급↓ 계좌" onclick="JavaScript:addChar('qna_1');" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
		<input type="button" value="3등급↑ 계좌" onclick="JavaScript:addChar('qna_2');" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
		<input type="button" value="기본답변설정2" onclick="JavaScript:addChar('qna_3');" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
		<input type="button" value="요청 처리완료" onclick="JavaScript:addChar('qna_4');" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
		<input type="button" value="기본답변설정3" onclick="JavaScript:addChar('qna_5');" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
		<input type="button" value="재로그인(등급↑)" onclick="JavaScript:addChar('qna_6');" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
		<input type="button" value="지인추천" onclick="JavaScript:addChar('qna_7');" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
		<input type="button" value="사다리배팅" onclick="JavaScript:addChar('qna_8');" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
		<input type="button" value="경기오류제보" onclick="JavaScript:addChar('qna_9');" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
		<input type="button" value="재입금안내" onclick="JavaScript:addChar('qna_10');" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
	</div>
  </form>
</div>
! 답변버튼 타이틀을 정해주시면 작업해드리겠습니다.
</body>
</html>