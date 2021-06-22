<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>document.title = '게시판관리-고객센터';</script>

<script Language='Javascript'>
function goDel(idx)
{
	var result = confirm('삭제하시겠습니까?');
	if(result) {location.href="?mode=del&idx="+idx;}	
}
</script>

<div class="wrap" id="question_list">

	<div id="route">
		<h5>관리자 시스템 > 게시판 관리 > <b>고객센터</b></h5>
	</div>

	<h3>고객센터</h3>

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

	<div id="search">
		<div class="wrap">
			<form action="?" method="get" name="form2" id="form2">
				<select name="filter_logo">
					<option value=""  <?php if($TPL_VAR["filter_logo"]==""){?>  selected <?php }?>>전체</option>
					<option value="mmomm" <?php if($TPL_VAR["filter_logo"]=="mmomm"){?>  selected <?php }?>>mmomm</option>
				</select>
				
				<span class="icon">출력</span>
				<input name="perpage" type="text" id="perpage" class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" size="5" value="<?php echo $TPL_VAR["perpage"]?>">
				<!-- 키워드 검색 -->
				<select name="field">
					<option value="uid" 				<?php if($TPL_VAR["field"]=="member_id"){?> selected <?php }?>>아이디</option>
					<option value="nick" 				<?php if($TPL_VAR["field"]=="nick"){?> selected <?php }?>>닉네임</option>
					<option value="bank_member" <?php if($TPL_VAR["field"]=="bank_member"){?> selected <?php }?>>예금주</option>
				</select>
				<input name="keyword" type="text" id="key" class="name" value="<?php echo $TPL_VAR["keyword"]?>" maxlength="20"/>
				
				<!-- 검색버튼 -->
				<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
      </form>
		</div>
	</div>
<!--
	<div id="table_sort">
		<form action="?" method="GET" name="form3" id="form3">
		<span class="icon">출력</span><input name="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/\D/g,''))"><input type="image" name="Submitok" src="/img/btn_s_sort.gif" class="imgType" title="정렬"/>
		</form>
	</div>
-->
	<form id="form1" name="form1" method="post" action="?mode=alldel">
	<table cellspacing="1" class="tableStyle_members" summary="고객센터 문의접수 목록">
	<legend class="blind">고객센터</legend>
	<thead>	
	<tr>
	  <th scope="col" class="check"><input type="checkbox" name="chkAll" title="전부선택" onClick="selectAll()"/></th>
	  <th scope="col">번호</th>
	  <th scope="col">제목</th>
	  <th scope="col">글쓴이</th>
	  <th scope="col">아이디</th>
	  <th scope="col">등급</th>
	  <th scope="col">가입일</th>
	  <th scope="col">예금주</th>
	  <th scope="col">은행</th>
	  <th scope="col">총판</th>
	  <th scope="col">날짜</th>
	  <th scope="col">결과</th>
	  <th scope="col">상태</th>
	</tr>
	</thead>
	<tbody>
<?php if($TPL_VAR["total"]<=0){?>
		<tr bgcolor='#FFFFFF' height=30> <td colspan=13 align=center>데이터가 없습니다.</td></tr>
<?php }else{?>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
			<tr>
				<td><input name="y_id[]" type="checkbox" id="y_id" value="<?php echo $TPL_V1["idx"]?>" onclick="javascript:chkRow(this);"/></td>
				<td><?php echo $TPL_V1["idx"]?></td>
				<td class="subject" onmousemove="showpup('<?php echo $TPL_V1["subject"]?>')" onmouseout="hidepup()">
					<a href="/board/questionview?idx=<?php echo $TPL_V1["idx"]?>" >
<?php if($TPL_V1["kubun"]=="partner"){?><font color='red'>[파트너 문의]</font><?php echo mb_strimwidth($TPL_V1["content"],0,50,"..","utf-8")?>

<?php }else{?>[<?php echo $TPL_V1["kubun"]?>]<?php echo mb_strimwidth($TPL_V1["content"],0,50,"..","utf-8")?>

<?php }?>
					</a>
				</td>
				<td><a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V1["mem_idx"]?>',1024,600)"><?php echo $TPL_V1["nick"]?></a></td>
				<td><?php echo $TPL_V1["uid"]?></td>
				<td><?php echo $TPL_V1["mem_lev"]?></td>
				<td><?php echo $TPL_V1["joindate"]?></td>
				<td><?php echo $TPL_V1["bank_member"]?></td>
				<td><?php if($TPL_V1["bank_name"]==""){?>일반 <?php }else{?> <font color="blue"><?php echo $TPL_V1["bank_name"]?></font><?php }?></td>
				<td><?php echo $TPL_V1["rec_id"]?></td>
				<td><?php echo $TPL_V1["regdate"]?></td>
				<td>
<?php if($TPL_V1["result"]==1){?>답변완료
<?php }else{?><font color=red>신규</font>
<?php }?>
				</td>
				<td><?php if($TPL_V1["state"]=='N'){?>정상<?php }else{?><font color="red">삭제</font><?php }?></td>
				<!--<td><a href="javascript:goDel(<?php echo $TPL_V1["idx"]?>);void(0);"><img src="/img/btn_s_del.gif" title="삭제"></a></td>-->
			</tr>
<?php }}?>
<?php }?>
	
	</tbody>
	</table>
	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>

	<div id="wrap_btn">
  	<input type="input" name="del_Submit" value="선택 삭제" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="isChm()"/>
  </div>
  </form>

</div>