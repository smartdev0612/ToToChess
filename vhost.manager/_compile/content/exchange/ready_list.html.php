<?php /* Template_ 2.2.3 2012/12/07 10:17:26 D:\www\vhost.manager\_template\content\exchange\ready_list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>document.title = '출금대기';</script>

<div class="wrap" id="Withdrawal_wait">
	<div id="route">
		<h5>관리자 시스템 > 입출금 관리 > <b>출금대기</b></h5>
	</div>

	<h3>출금대기</h3>

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
				<span class="icon">출력</span>
				<input name="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" size="5" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()">
				
				<select name="date_type">
					<option value="regdate"  <?php if($TPL_VAR["date_type"]=="regdate"){?>  selected <?php }?>>신청시간</option>
					<option value="operdate" <?php if($TPL_VAR["date_type"]=="operdate"){?> selected <?php }?>>처리시간 </option>
				</select>	
				<span class="icon">날짜</span><input name="begin_date" type="text" id="begin_date" class="date" value="<?php echo $TPL_VAR["begin_date"]?>" maxlength="20" onclick="new Calendar().show(this);"/>&nbsp;~
				<input name="end_date" type="text" id="end_date" class="date" value="<?php echo $TPL_VAR["end_date"]?>" maxlength="20" onclick="new Calendar().show(this);" />
				<select name="search_type">
					<option value="uid" 				<?php if($TPL_VAR["search_type"]=="uid"){?> 				selected <?php }?>>아이디</option>
					<option value="nick"   			<?php if($TPL_VAR["search_type"]=="nick"){?> 				selected <?php }?>>닉네임</option>
					<option value="partner_id" 	<?php if($TPL_VAR["search_type"]=="partner_id"){?> 	selected <?php }?>>파트너</option>
					<option value="bank_owner" 	<?php if($TPL_VAR["search_type"]=="bank_owner"){?> 	selected <?php }?>>입금자명</option>
				</select>
				<input name="keyword" type="text" id="key" class="name" value="<?php echo $TPL_VAR["keyword"]?>" maxlength="20" onmouseover="this.focus()"/>
				<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
			</form>
		</div>
	</div>

	<table cellspacing="1" class="tableStyle_normal">
	<legend class="blind">출금대기 목록</legend>
	<thead>
		<tr height="30">
			<th>신청시간</th>
			<th>처리시간</th>
			<th>아이디</th>
			<th>닉네임</th>
			<th>당시금액</th>
			<th>보유금액</th>
			<th>출금금액</th>
			<th>은행명</th>
			<th>계좌번호</th>
			<th>예금주</th>
			<th>파트너</th>
			<th>처리</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
		<tr>
	        <td><?php echo $TPL_V1["regdate"]?></td>        
	        <td><?php echo $TPL_V1["operdate"]?></td>
	        <td><a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V1["member_sn"]?>',1024,600)"><?php echo $TPL_V1["uid"]?></a></td>
	        <td><?php echo $TPL_V1["nick"]?></td>
			<td><?php echo number_format($TPL_V1["before_money"],0)?></td>
			<td><?php echo number_format($TPL_V1["g_money"],0)?></td>
			<td><?php echo number_format($TPL_V1["amount"],0)?></td>
			<td><?php echo $TPL_V1["bank"]?></td>
			<td><?php echo $TPL_V1["bank_account"]?></td>
			<td><?php echo $TPL_V1["bank_owner"]?></td>
			<td><?php echo $TPL_V1["recommendId"]?></td>
			<td>
				<a href="javascript:open_window('/exchange/popup_agree?mode=cancel&member_sn=<?php echo $TPL_V1["member_sn"]?>&amount=<?php echo $TPL_V1["amount"]?>&sn=<?php echo $TPL_V1["sn"]?>',450,200)"><font color='red'>[취소]</font></a>
				<a href="javascript:open_window('/exchange/popup_agree?mode=edit&member_sn=<?php echo $TPL_V1["member_sn"]?>&amount=<?php echo $TPL_V1["amount"]?>&sn=<?php echo $TPL_V1["sn"]?>',450,200)">[승인]</a>
			</td>
      	</tr>
<?php }}?>
	</tbody>
	</table>

	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>
</div>