<script charset="utf-8" src="/web_editor_cocopa/kindeditor.js"></script>

<script>

function onEdit() 
{
	if (confirm("입력하신 내용을 등록 하시겠습니까 ?"))
	{
		document.frm.imgsrc.value=KE.util.getpic('on');
		document.frm.submit();
	}
	else {return;}
}

</script>



<!-- content begin -->

<div class="wrap" id="rule_<?php echo $TPL_VAR["type"]?>">

	<div id="route">
		<h5>관리자 시스템 > 게시판 관리 > <b><?php echo $TPL_VAR["page_title"]?></b></h5>
	</div>

	<h3>게시글 쓰기</h3>

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
		<li><a href="/board/list?province=8" id="betting_rule">배팅규정 수정</a></li>
<?php
	}
?>
	</ul>

	<form name="frm" action="?" method="post">
		<input type="hidden" name="imgsrc"  value="">
		<input type="hidden" name="act"  value="modify">
		<input type="hidden" name="rule_sn"  value="<?php echo $TPL_VAR["item"]["sn"]?>">
		<input type="hidden" name="type"  value="<?php echo $TPL_VAR["type"]?>">
		<table cellspacing="1" class="tableStyle_membersWrite">
		<legend class="blind"><?php echo $TPL_VAR["page_title"]?> 쓰기</legend>
			<tr>		
				<th>내용</th>
				<td>
					<textarea id="on" name="content" cols="80" rows="4" onmouseover="this.focus()">
						<?php echo str_replace("/upload/images/",$TPL_VAR["UPLOAD_URL"],$TPL_VAR["item"]["content"])?>

					</textarea>
					<script>       
						KE.show({ id : "on", 
											width : "650px",
											height : "350px",
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
	      <input type="button" name="ok" value="등  록" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="onEdit()"/>
	  </div>
	</form>
</div>