<?php /* Template_ 2.2.3 2012/10/10 23:58:10 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\content.board.list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script Language='Javascript'>
function goDel(idx)
{
	var result = confirm('삭제 하시겠습니까?');
	if(result){
		location.href="?act=del&amp;id="+idx;
	}	
}
</script>

<div class="wrap" id="article">

	<div id="route">
		<h5>관리자 시스템 > 게시판 관리 > <b>게시물 관리</b></h5>
	</div>

	<h3>게시물 관리</h3>

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
		    <input type="hidden" name="type" value="<?php echo $TPL_VAR["type"]?>">
			<span>제목</span>
            <input name="username" type="text" id="key" class="name" value="<?php echo $TPL_VAR["subject"]?>" maxlength="20" onmouseover="this.focus()"/>
            <input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
          </form>
		</div>
	</div>

	<form id="form1" name="form1" method="post" action="?act=alldel">
		<table cellspacing="1" class="tableStyle_members" summary="게시물 목록">
			<legend class="blind">게시물 관리</legend>
			<thead>
				<tr>
					<th scope="col" class="check"><input type="checkbox" name="chkAll" title="전부선택" onClick="selectAll()"/></th>
					<th scope="col">ID</th>
					<th scope="col">분류</th>
					<th scope="col">제목</th>
					<th scope="col">날자</th>
					<th scope="col">상태</th>
					<th scope="col">조회</th>
					<th scope="col">처리</th>
				</tr>
			</thead>
			
			<tbody>
<?php if($TPL_VAR["total"]==0){?>
				<tr bgcolor='#FFFFFF' height=50> <td colspan=10 align=center>데이타가 없습니다.</td></tr>
<?php }else{?>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
					<tr bgcolor='f6f6f6' height="5" onMouseOver="this.style.backgroundColor='#e0eafe';" onMouseOut="this.style.backgroundColor=''" >
						<td><input name="y_id[]" type="checkbox" id="y_id" value="<?php echo $TPL_V1["id"]?>"  onclick="javascript:chkRow(this);"/></td>
						<td><?php echo $TPL_V1["id"]?></td>
						<td><a href="/board/list?subject=<?php echo $TPL_V1["subject"]?>&type=<?php echo $TPL_V1["province"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&page="><?php echo $TPL_V1["typename"]?></a></td>
						<td class="subject" onmousemove='showpup("<?php echo str_replace('"','\"',$TPL_V1["title"])?>")' onmouseout="hidepup()">
							<span><a href="/board/write?id=<?php echo $TPL_V1["id"]?>"><?php if($TPL_V1["imgnum"]!=0){?> <img src='../images/photo.gif' border='0'><?php }?>
								<?php echo mb_strimwidth($TPL_V1["title"],0,50,"..","utf-8")?> <?php if($TPL_V1["reply"]>0){?> <font color="#a27b04">(<?php echo $TPL_V1["reply"]?>)</font><?php }?></a></span>
						</td>
						<td><?php echo $TPL_V1["time"]?></td>
						<td>
<?php if($TPL_V1["top"]==1){?>
								추천안함
<?php }else{?>
								<font color='red'>추천</font>
<?php }?>
						</td>
						<td><a href="javascript:open_window('update_hit.php?id=<?php echo $TPL_V1["id"]?>&hit=<?php echo $TPL_V1["hit"]?>',350,150)"><?php echo $TPL_V1["hit"]?></a></td>
						<td width="20%" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666">
							<a href="/board/write?id=<?php echo $TPL_V1["id"]?>">[수정]</a>&nbsp;&nbsp;&nbsp;
							<a href="javascript:goDel(<?php echo $TPL_V1["id"]?>);void(0);">[삭제]</a>&nbsp;&nbsp;&nbsp;
							<a href="?act=istop&amp;id=<?php echo $TPL_V1["id"]?>&amp;top=<?php echo $TPL_V1["top"]?>"><?php if($TPL_V1["top"]=="2"){?> [추천취소] <?php }else{?>[추천]<?php }?></a>
						</td>
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
			<input type="button" value="조회수 올리기" name="click" onclick="location.href='?act=click&id=<?php echo $TPL_VAR["arrayId"]?>&type=<?php echo $TPL_VAR["type"]?>'" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
		</div>
	</form>  
</div>