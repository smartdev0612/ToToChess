<?php /* Template_ 2.2.3 2012/10/10 23:58:15 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\content.board.config.html */?>
<div class="wrap" id="bbs">

	<div id="route">
		<h5>관리자 시스템 > 게시판 관리 > <b>게시판</b></h5>
	</div>

	<h3>게시판</h3>

	<ul id="tab">
		<li><a href="/board/type" id="type">분류 관리</a></li>
		<li><a href="/board/list" id="article">게시물 관리</a></li>
		<li><a href="/board/bbs" id="bbs">게시판</a></li>
		<li><a href="/board/questionlist" id="question_list">고객센터</a></li>
		<li><a href="/board/write" id="write">게시물 쓰기</a></li>
	</ul>

	<div id="search">
		<div>
			<form action="?" method="get" name="form2" id="form2">
			<input type="hidden" name="perpage" value="<?php echo $TPL_VAR["perpage"]?>">
			<span>제목</span>
            <input name="username" type="text" id="key" class="name" value="<?php echo $TPL_VAR["title"]?>" maxlength="20" onmouseover="this.focus()"/>
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
	<table cellspacing="1" class="tableStyle_members" summary="게시판 목록">
	<legend class="blind">게시판</legend>
	<thead>
	<tr>
	  <th scope="col" class="check"><input type="checkbox" name="chkAll" title="전부선택" onClick="selectAll()"/></th>
	  <th scope="col">번호</th>
	  <th scope="col">이름</th>
	  <th scope="col">날짜</th>
	  <th scope="col">조회</th>
	  <th scope="col">처리</th>
	</tr>
	</thead>
	<tbody>
<?php if($TPL_VAR["total"]<=0){?>		
		<tr bgcolor='#FFFFFF' height=30> <td colspan=10 align=center>데이터가 없습니다.</td></tr>
<?php }else{?>
		<tr>
			<td><input name="y_id[]" type="checkbox" id="y_id" value="<?php echo $TPL_VAR["list"]["num"]?>"  onclick="javascript:chkRow(this);"/></td>
			<td><?php echo $TPL_VAR["list"]["num"]?></td>
			<td onmousemove="showpup('<?php echo $TPL_VAR["list"]["title"]?>')" onmouseout="hidepup()"><a href="bbs_view.php?idx=<?php echo $TPL_VAR["list"]["num"]?>" ><?php echo mb_strimwidth($TPL_VAR["list"]["title"],0,30,"..","utf-8")?></a></td>
			<td><?php echo $TPL_VAR["list"]["name"]?></td>
			<td><?php echo $TPL_VAR["list"]["regdate"]?></td>
			<td><?php echo $TPL_VAR["list"]["hit"]?></td>
			<td><a href="javascript:goDel(<?php echo $TPL_VAR["list"]["num"]?>);void(0);"><img src="/img/btn_s_del.gif" title="삭제"></a></td>
		</tr>
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