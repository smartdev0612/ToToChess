<?php
	$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
?>
<script>document.title = '입출금 관리-회원머니내역';</script>

<div class="wrap" id="Withdrawal">

	<div id="route">
		<h5>관리자 시스템 > 입출금 관리 > <b>회원머니내역</b></h5>
	</div>

	<h3>회원머니내역</h3>
	<!--
	<div id="search">
		<div class="wrap">
			<form action="?" method="GET" name="form2" id="form2">
				<input type="hidden" name="uid" value=<?php echo $TPL_VAR["uid"]?>>
				<span class="icon">출력</span>
				<input name="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" size="5" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()">
				
				<span class="icon">날짜</span><input name="begin_date" type="text" id="begin_date" class="date" value="<?php echo $TPL_VAR["begin_date"]?>" maxlength="20" onclick="new Calendar().show(this);"/>&nbsp;~
				<input name="end_date" type="text" id="end_date" class="date" value="<?php echo $TPL_VAR["end_date"]?>" maxlength="20" onclick="new Calendar().show(this);" />


				<select name="filter_state">
					<option value="" 	<?php if($TPL_VAR["filter_state"]==""){?> selected <?php }?>>::머니 발생사유</option>
					<option value="1" <?php if($TPL_VAR["filter_state"]==1){?> selected <?php }?>>+충전</option>
					<option value="2" <?php if($TPL_VAR["filter_state"]==2){?> selected <?php }?>>-환전</option>
					<option value="3" <?php if($TPL_VAR["filter_state"]==3){?> selected <?php }?>>-배팅</option>
					<option value="4" <?php if($TPL_VAR["filter_state"]==4){?> selected <?php }?>>+당첨</option>
					<option value="5" <?php if($TPL_VAR["filter_state"]==5){?> selected <?php }?>>게임취소</option>
					<option value="6" <?php if($TPL_VAR["filter_state"]==6){?> selected <?php }?>>-포인트 전환</option>
					<option value="7" <?php if($TPL_VAR["filter_state"]==7){?> selected <?php }?>>관리자 강제 변환 머니</option>
					<option value="8" <?php if($TPL_VAR["filter_state"]==8){?> selected <?php }?>>정산취소</option>
				</select>
				
				<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" />
			</form>
		</div>
	</div>
	-->

	<form id="form1" name="form1" method="post" action="?act=del">
		<table cellspacing="1" class="tableStyle_normal">
			<legend class="blind">머니 내역</legend>
			<thead>
			<tr>
				  <th scope="col">승인일시</th>
				  <th scope="col" class="id">아이디</th>
				  <th scope="col">닉네임</th>
				  <th scope="col">예금주</th>
				  <th scope="col">총판</th>
				  <th scope="col">당시금액</th>
				  <th scope="col">변동금액</th>
				  <th scope="col">최종금액</th>
				  <th scope="col">사유</th>
			</tr>
			</thead>
			<tbody>
<?php 
	if ( $TPL_list_1 ) {
		foreach ( $TPL_VAR["list"] as $TPL_V1 ) {
		if ( $TPL_VAR["filter_state"] == 1 ) {
			$stateMsg = "충전";
			$beforeMoney = number_format($TPL_V1["before_money"],0);
		} else {
			$stateMsg = "환전";
			$beforeMoney = number_format($TPL_V1["amount"]+$TPL_V1["before_money"],0);
		}
?>
				<tr>
					<td><?php echo $TPL_V1["operdate"]?></td>
					<td><a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V1["member_sn"]?>',1024,600)"><?php echo $TPL_V1["uid"]?></td>
					<td><?php echo $TPL_V1["nick"]?></td>
					<td><?php echo $TPL_V1["bank_member"]?></td>
					<td><?php echo $TPL_V1["rec_id"]?></td>
					<td><?php echo $beforeMoney?></td>
					<td><?php if($TPL_V1["amount"]>0){?><font color="blue"><?php }else{?><font color="red"><?php }?><?php echo number_format($TPL_V1["amount"],0)?></font></td>
					<td><?php echo number_format($TPL_V1["after_money"],0)?></td>
					<td><?php echo $stateMsg?></td>
				</tr>
<?php }}?>
			</tbody>
		</table>
	</form>

	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>
</div>