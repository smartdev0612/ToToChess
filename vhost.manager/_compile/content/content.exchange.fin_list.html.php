<?php /* Template_ 2.2.3 2012/10/06 15:31:14 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\content.exchange.fin_list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<div class="wrap" id="Withdrawal_over">
	<div id="route">
		<h5>관리자 시스템 > 입출금 관리 > <b>출금완료</b></h5>
	</div>

	<h3>출금완료</h3>

	<ul id="tab">
		<li><a href="/charge/list" id="Richer">입금신청</a></li>
		<li><a href="/charge/finlist" id="Richer_over">입금완료</a></li>
		<li><a href="/exchange/list" id="Withdrawal">출금신청</a></li>
		<li><a href="/exchange/readylist" id="Withdrawal_wait">출금대기</a></li>
		<li><a href="/exchange/finlist" id="Withdrawal_over">출금완료</a></li>
	</ul>
	<div id="search">
		<div>
			<form action="?" method="GET" name="form2" id="form2">
				<select name="seldate">
					<option value="regdate"  <?php if($TPL_VAR["seldate"]=="regdate"){?>  selected <?php }?>>신청시간</option>
					<option value="operdate" <?php if($TPL_VAR["seldate"]=="operdate"){?> selected <?php }?>>처리시간 </option>
				</select>	
				<span class="icon">날짜</span><input name="date_id" type="text" id="date_id" class="date" value="<?php echo $TPL_VAR["date_id"]?>" maxlength="20" onclick="new Calendar().show(this);"/>&nbsp;~
				<input name="date_id1" type="text" id="date_id1" class="date" value="<?php echo $TPL_VAR["date_id1"]?>" maxlength="20" onclick="new Calendar().show(this);" />
				<select name="field">
					<option value="mem_id" <?php if($TPL_VAR["field"]=="mem_id"){?> 	selected <?php }?>>아이디</option>
					<option value="nick"   <?php if($TPL_VAR["field"]=="nick"){?> 	selected <?php }?>>닉네임</option>
					<option value="rec_id" <?php if($TPL_VAR["field"]=="rec_id"){?> 	selected <?php }?>>파트너</option>
					<option value="a_name" <?php if($TPL_VAR["field"]=="a_name"){?> 	selected <?php }?>>입금자명</option>
				</select>
				<input name="mem_id" type="text" id="key" class="name" value="<?php echo $TPL_VAR["id"]?>" maxlength="20" onmouseover="this.focus()"/>
				<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
			</form>
		</div>
	</div>

	<div id="table_sort">
		<form action="?" method="GET" name="form3" id="form3">
		<span class="icon">출력</span><input name="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()"><input type="image" name="Submitok" src="/img/btn_s_sort.gif" class="imgType" title="정렬"/>
		</form>
	</div>

	<form id="form1" name="form1" method="post" action="?act=del">
	<table cellspacing="1" class="tableStyle_normal" summary="출금완료 목록">
	<legend class="blind">출금완료 목록</legend>
	<thead>
		<tr>
			<th scope="col">신청시간</th>
			<th scope="col">처리시간</th>
			<th scope="col" class="id">아이디</th>
			<th scope="col">닉네임</th>
			<th scope="col">당시금액</th>
			<th scope="col">보유금액</th>
			<th scope="col">출금금액</th>
			<th scope="col">보너스</th>
			<th scope="col">은행명</th>
			<th scope="col">계좌번호</th>
			<th scope="col">예금주</th>
			<th scope="col">파트너</th>
			<th scope="col">상태</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
		<tr class="link_lan" style="padding-left:1px;"  onMouseOver="this.style.backgroundColor='#e0eafe';" onMouseOut="this.style.backgroundColor=''" >
			<td><?php echo $TPL_V1["regdate"]?></td>        
			<td><?php echo $TPL_V1["operdate"]?></td>
			<td><a href="javascript:open_window('../user/user_details.php?idx=<?php echo $TPL_V1["idx"]?>',610,530)"><?php echo $TPL_V1["mem_id"]?></td>
			<td><?php echo $TPL_V1["nick"]?></td>
			<td><?php echo number_format($TPL_V1["beforemoney"],0)?></td>
			<td><?php echo number_format($TPL_V1["g_money"],0)?></td>
			<td><?php echo number_format($TPL_V1["amount"],0)?></td>
			<td><?php echo number_format($TPL_V1["bonus"],0)?></td>
			<td><?php echo $TPL_V1["bank"]?></td>
			<td><?php echo $TPL_V1["account"]?></td>
			<td><?php echo $TPL_V1["a_name"]?></td>
			<td><?php echo $TPL_V1["rec_id"]?></td>
			<td><?php if($TPL_V1["result"]==0){?><font color='red'>신청</font><?php }elseif($TPL_V1["result"]==1){?><font color='blue'>완료</font><?php }else{?><img src="/img/btn_s_cancel.gif" title="취소"><?php }?></td>
		</tr>
<?php }}?>
	</tbody>
	</table>
	</form>

	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>
</div>