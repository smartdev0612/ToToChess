<?php /* Template_ 2.2.3 2012/10/10 01:27:42 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\content.board.question_list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script Language='Javascript'>
function goDel(idx)
{
	var result = confirm('삭제하시겠습니까?');
	if(result) {location.href="?mode=del&idx="+idx;}	
}
</script>

<div class="wrap" id="question_list">

	<div id="route">
		<h5>관리자 시스템 > 게시판 관리 > <b>게시판</b></h5>
	</div>

	<h3>게시판</h3>

	<ul id="tab">
		<li><a href="type.php" id="type">분류 관리</a></li>
		<li><a href="Article.php" id="article">게시물 관리</a></li>
		<li><a href="bbs.php" id="bbs">게시판</a></li>
		<li><a href="question_list.php" id="question_list">고객센터</a></li>
		<li><a href="write.php" id="write">게시물 쓰기</a></li>
	</ul>

	<div id="search">
		<div>
			<form action="?" method="get" name="form2" id="form2">
			<input type="hidden" name="perpage" value="<?php echo $TPL_VAR["perpage"]?>">
			<span>제목</span>
            <input name="username" type="text" id="key" class="name" value="<?php echo $TPL_VAR["nname"]?>" maxlength="20" onmouseover="this.focus()"/>
            <input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
          </form>
		</div>
	</div>

	<div id="table_sort">
		<form action="?" method="GET" name="form3" id="form3">
		<span class="icon">출력</span><input name="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/\D/g,''))"><input type="image" name="Submitok" src="/img/btn_s_sort.gif" class="imgType" title="정렬"/>
		</form>
	</div>

	<form id="form1" name="form1" method="post" action="?mode=alldel">
	<table cellspacing="1" class="tableStyle_members" summary="고객센터 문의접수 목록">
	<legend class="blind">고객센터</legend>
	<thead>	
	<tr>
	  <th scope="col" class="check"><input type="checkbox" name="chkAll" title="전부선택" onClick="selectAll()"/></th>
	  <th scope="col">번호</th>
	  <th scope="col">제목</th>
	  <th scope="col">이름</th>
	  <th scope="col">날짜</th>
	  <th scope="col">결과</th>
	  <th scope="col">처리</th>
	</tr>
	</thead>
	<tbody>
<?php if($TPL_VAR["total"]<=0){?>
		<tr bgcolor='#FFFFFF' height=30> <td colspan=10 align=center>데이터가 없습니다.</td></tr>
<?php }else{?>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
			<tr>
				<td><input name="y_id[]" type="checkbox" id="y_id" value="<?php echo $TPL_V1["idx"]?>" onclick="javascript:chkRow(this);"/></td>
				<td><?php echo $TPL_V1["idx"]?></td>
				<td class="subject" onmousemove="showpup('<?php echo $TPL_V1["subject"]?>')" onmouseout="hidepup()">
					<a href="question_view.php?idx=<?php echo $TPL_V1["idx"]?>" >
<?php if($TPL_V1["kubun"]=="partner"){?>
							<font color='red'>[파트너 문의]</font><?php echo mb_strimwidth($TPL_V1["subject"],0,50,"..","utf-8")?>

<?php }else{?>
							[<?php echo $TPL_V1["kubun"]?>]<?php echo mb_strimwidth($TPL_V1["subject"],0,50,"..","utf-8")?>

<?php }?>
					</a>
				</td>
				<td><a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V1["mem_idx"]?>',1024,600)"><?php echo $TPL_V1["mem_id"]?></a></td>
				<td><?php echo $TPL_V1["regdate"]?></td>
				<td>
<?php if($TPL_V1["result"]==1){?>
						답변완료
<?php }else{?>
						<font color=red>신규</font>
<?php }?>
				</td>
				<td><a href="javascript:goDel(<?php echo $TPL_V1["idx"]?>);void(0);"><img src="/img/btn_s_del.gif" title="삭제"></a></td>
			</tr>
<?php }}?>
<?php }?>
	
	</tbody>
	</table>
	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>

	<div id="wrap_btn">
          <input type="submit" name="del_Submit" value="선택 삭제" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="isChm()"/>
    </div>
    </form>

</div>