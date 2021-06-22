<?php /* Template_ 2.2.3 2012/10/09 21:51:51 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\member\memo_list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<div class="wrap" id="members_rmemo">

	<div id="route">
		<h5>관리자 시스템 > 회원 관리 > 쪽지 관리 > <b>받은 쪽지함</b></h5>
	</div>

	<h3>받은 쪽지함</h3>

	<ul id="tab">
		<li><a href="/member/membermemo" id="members_rmemo">받은쪽지함</a></li>
		<li><a href="memo_sendlist.php" id="members_smemo">보낸쪽지함</a></li>
	</ul>
	<div id="search">
		<div>
			<form action="?" method="GET" name="form2" id="form2">
				<span class="icon">아이디</span>
				<input name="username" type="text" id="key" class="name" value="<?php echo $TPL_VAR["nname"]?>" maxlength="20" onmouseover="this.focus()"/>
				<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
			</form>
		</div>
	</div>
	<div id="table_sort">
		<form action="?" method="GET" name="form3" id="form3">
		<input type="hidden" name="username" value="<?php echo $TPL_VAR["nname"]?>">
		<span class="icon">출력</span><input name="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" value="<?php echo $TPL_VAR["perpage"]?>" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/\D/g,''))" onmouseover="this.focus()"><input type="image" name="Submitok" src="/img/btn_s_sort.gif" class="imgType" title="정렬"/>
		</form>
	</div>

	<form id="form1" name="form1" method="get" action="?">
	<input type="hidden" name="act" value="del">
	<table cellspacing="1" class="tableStyle_normal" summary="받은 쪽지함">
	<legend class="blind">받은 쪽지함 - 제목</legend>
	<thead>
		<tr>
			<th scope="col" class="check"><input type="checkbox" name="chkAll" title="전체선택" onClick="selectAll()"/></th>
			<th width="15%" scope="col">받는이</th>
			<th width="15%" scope="col">보낸이</th>
			<th width="34%" scope="col">제목</th>
			<th width="15%" scope="col">보낸 시간</th>
			<th width="10%" scope="col">상태</th>
			<th width="20%" scope="col">처리</th>
		</tr>
	</thead>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
		<table cellspacing="1" class="tableStyle_normal" summary="받은 쪽지함">
			<legend class="blind">받은 쪽지함 - 내용</legend>
			<tbody>
				<tr onClick="javascript:ShowFLT(<?php echo $TPL_V1["idx"]?>)">
					<td class="check"><input name="y_id[]" type="checkbox" id="y_id" value="<?php echo $TPL_V1["mem_idx"]?>"  onclick="javascript:chkRow(this);"/></td>
					<td width="15%"><?php echo $TPL_V1["toid"]?></td>
					<td width="15%"><?php echo $TPL_V1["fromid"]?></td>
					<td width="34%"><span class="subject"><?php echo mb_strimwidth($TPL_V1["title"],0,36,"..","utf-8")?></span></td>
					<td width="15%"><?php echo $TPL_V1["writeday"]?></td>
					<td width="10%">
<?php if($TPL_V1["newmemo"]==0){?>
							<font color='red'>미답변</font>
<?php }else{?>
							"완료"
<?php }?>
					</td>
					<td width="20%"><a href="javascript:open_window('memo_Reply.php?idx=<?php echo $TPL_V1["mem_idx"]?>&fromid=<?php echo $TPL_V1["fromid"]?>',650,300)"><img src="/img/btn_s_answer.gif" title="답변"></a>&nbsp;
						<a href="javascript:confirm('정말 삭제하시겠습니까?');location.href='/member/sendmemolist?act=onedel&idx=<?php echo $TPL_V1["mem_idx"]?>';">
							<img src="/img/btn_s_del.gif" title="삭제">
						</a>
					</td>
				</tr>
			</tbody>
			</table>
		
			<table id="LM<?php echo $TPL_V1["idx"]?>" style="display:none" class="memo_answer">
				<tr class="line">
					<th valign="top">쪽지 제목 :</th>
					<td><?php echo mb_strimwidth($TPL_V1["title"],0,36,"..","utf-8")?></td>
				</tr>
				<tr>
					<th valign="top">쪽지 내용 :</th>
					<td><?php echo $TPL_V1["content"]?></td>
				</tr>
			</table>
<?php }}?>
	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>
    
	<div id="wrap_btn">
		<p class="left">
			<input type="button" name="open" value="삭  제" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="isChm()"/>
		</p>
	</div>
	
    </form>    
</div>