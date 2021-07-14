<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>document.title = '게시판관리-게시물관리';</script>

<script Language='Javascript'>
function goDel(idx)
{
	var result = confirm('삭제 하시겠습니까?');
	if(result){
		location.href="?act=del&id="+idx;
	}	
}


function hitChange(action_type)
{	
	$('#act').val(action_type);
	
	var xxx=0;
	for (i=0;i<document.all.length;i++) 
	{
		if (document.all[i].name=="y_id[]")
		{
			if(document.all[i].checked==true)
			{
				xxx++;
			}
		}
	}
	if(xxx==0)
	{
		alert("실행할 내용을 선택하십시오.");
		return false;
	}
	else
	{
		var flag = window.confirm("정말로 실행 하시겠습니까?"); 
		if(flag)
		{
			//location.href="user_loginlist.php?act=deleteone&idx="+idx;
			document.form1.submit();
		}
		else
		{
			return false;
		}
	}
}

</script>

<div class="wrap" id="board_<?php echo $TPL_VAR["province"]?>">

	<div id="route">
		<h5>관리자 시스템 > 게시판 관리 > <b>게시물 관리</b></h5>
	</div>

	<h3>게시물 관리</h3>

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

	<div id="search">
		<div class="wrap">
			<form action="?" method="get" name="form2" id="form2">
				<input type="hidden" name="province" value="<?php echo $TPL_VAR["province"]?>"/>
				
				<!-- 기간 필터 -->
<?php if($TPL_VAR["province"]!=2 and $TPL_VAR["province"]!=7) {?>
				<span class="icon">날짜</span>
				<input name="begin_date" type="text" id="begin_date" class="date" value="<?php echo $TPL_VAR["begin_date"]?>" maxlength="20" onclick="new Calendar().show(this);"/>&nbsp;~
				<input name="end_date" type="text" id="end_date" class="date" value="<?php echo $TPL_VAR["end_date"]?>" maxlength="20" onclick="new Calendar().show(this);" />
				&nbsp;&nbsp;&nbsp;&nbsp;
<?php }?>
				<!-- 키워드 검색 -->
				<select name="field">
<?php if($TPL_VAR["province"]!=2&&$TPL_VAR["province"]!=7){?>
					<option value="author" 				<?php if($TPL_VAR["field"]=="author"){?> selected <?php }?>>글쓴이</option>
<?php }?>
					<option value="title" 			<?php if($TPL_VAR["field"]=="title"){?> selected <?php }?>>제목</option>
					<option value="content" 		<?php if($TPL_VAR["field"]=="content"){?> selected <?php }?>>내용</option>
				</select>
				<input name="keyword" type="text" id="key" class="name" value="<?php echo $TPL_VAR["keyword"]?>" maxlength="20" onmouseover="this.focus()"/>
				
				<!-- 검색버튼 -->
				<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
      </form>
		</div>
	</div>

	<form id="form1" name="form1" method="post" action="?">	
		<input type="hidden" id="act" name="act" value="alldel">
		<input type="hidden" id="province" name="province" value="<?php echo $TPL_VAR["province"]?>">
		<table cellspacing="1" class="tableStyle_members" summary="게시물 목록">
			<legend class="blind">게시물 관리</legend>
			<thead>
				<tr>
					<th scope="col" class="check"><input type="checkbox" name="chkAll" title="전부선택" onClick="selectAll()"/></th>
					<th scope="col">ID</th>
					<th scope="col">사이트</th>
					<th scope="col">분류</th>
					<th scope="col">글쓴이</th>
					<th scope="col">제목</th>					
					<th scope="col">날짜</th>
					<th scope="col">상태</th>
					<th scope="col">조회</th>
					<th scope="col">처리</th>
				</tr>
			</thead>
			
			<tbody>
<?php if($TPL_VAR["total"]==0){?>
				<tr bgcolor='#FFFFFF' height=50> <td colspan=11 align=center>데이타가 없습니다.</td></tr>
<?php }else{?>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
					<tr bgcolor='f6f6f6' height="5" onMouseOver="this.style.backgroundColor='#e0eafe';" onMouseOut="this.style.backgroundColor=''" >
						<td><input name="y_id[]" type="checkbox" id="y_id" value="<?php echo $TPL_V1["id"]?>"  onclick="javascript:chkRow(this);"/></td>
						<td><?php echo $TPL_V1["logo"];?></td>
						<td><?php echo $TPL_V1["id"]?></td>
						<td><a href="/board/list?subject=<?php echo $TPL_V1["subject"]?>&province=<?php echo $TPL_V1["province"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&page="><?php echo $TPL_V1["typename"]?></a></td>
						<td <?php if($TPL_V1["mem_status"]=="N"){echo "style=\"background:#f8f2cb;\"";}?>><?php echo $TPL_V1["author"]?></td>
						<td class="subject" onmousemove='showpup("<?php echo str_replace('"','\"',$TPL_V1["title"])?>")' onmouseout="hidepup()">
							<span><a href="/board/write?id=<?php echo $TPL_V1["id"]?>"><?php if($TPL_V1["betting_no"]>0){?> <img src='/img/icon_betting.gif' border='0'><?php }?>
								<?php echo mb_strimwidth($TPL_V1["title"],0,50,"..","utf-8")?> <?php if($TPL_V1["reply"]>0){?> <font color="#a27b04">(<?php echo $TPL_V1["reply"]?>)</font><?php }?></a></span>
						</td>
						<td><?php echo $TPL_V1["time"]?></td>
						<td>
<?php if($TPL_V1["top"]==1){?>추천안함
<?php }else{?><font color='red'>추천</font>
<?php }?>
						</td>						
						
						<td><a href="javascript:open_window('/board/popup_updatehit?id=<?php echo $TPL_V1["id"]?>&hit=<?php echo $TPL_V1["hit"]?>',350,150)"><?php echo $TPL_V1["hit"]?></a></td>						
						<td width="20%" align="center" style="border-bottom:1px #CCCCCC solid;color: #666666">
							<a href="/board/write?id=<?php echo $TPL_V1["id"]?>">[수정]</a>&nbsp;&nbsp;&nbsp;
							<a href="javascript:goDel(<?php echo $TPL_V1["id"]?>);void(0);">[삭제]</a>&nbsp;&nbsp;&nbsp;
							<a href="?act=istop&id=<?php echo $TPL_V1["id"]?>&top=<?php echo $TPL_V1["top"]?>"><?php if($TPL_V1["top"]=="2"){?> [추천취소] <?php }else{?>[추천]<?php }?></a>
						</td>
					</tr>
<?php }}?>
<?php }?>	
			</tbody>
	    </table>
	
		<div id="pages">
			<?php echo $TPL_VAR["pagelist"]?>

		</div>
	</form>  		
		<div id="wrap_btn">
			<input type="submit" name="del_Submit" value="선택 삭제" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="isChm();"/>
			<input type="submit" name="hit" value="조회수 올리기" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="hitChange('click');"/>
			<!--
			<input type="button" value="조회수 올리기" name="click" onclick="location.href='?act=click&id=<?php echo $TPL_VAR["arrayId"]?>&type=<?php echo $TPL_VAR["type"]?>'" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
			-->
		</div>
	
</div>