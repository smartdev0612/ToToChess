<?php /* Template_ 2.2.3 2012/11/30 16:47:21 D:\www\vhost.manager\_template\content\stat\site_accounting.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<div class="wrap" id="stat_siteAccount">

	<div id="route">
		<h5>관리자 시스템 > 관리자 > <b>사이트 정산</b></h5>
	</div>

	<h3>사이트 정산</h3>

	<p class="icon">정산예정 금액</p>
<?php if(count((array)$TPL_VAR["lastList"])>0){?>
		<form action="?" method="POST">
			<input type="hidden" name="act" value="account">
			<input type="hidden" name="exchange_money" value="<?php echo $TPL_VAR["lastList"]["exchange_money"]?>">
			<input type="hidden" name="change_money" value="<?php echo $TPL_VAR["lastList"]["change_money"]?>">
			<input type="hidden" name="acc_bet" value="<?php echo $TPL_VAR["lastList"]["acc_bet"]?>">
			<input type="hidden" name="acc_bonus_money" value="<?php echo $TPL_VAR["lastList"]["acc_bonus_money"]?>">
			<input type="hidden" name="acc_partner" value="<?php echo $TPL_VAR["lastList"]["acc_partner"]?>">
			<input type="hidden" name="account_money" value="<?php echo $TPL_VAR["lastList"]["exchange_money"]-$TPL_VAR["lastList"]["change_money"]?>">
			<input type="hidden" name="reg_date" value="<?php echo $TPL_VAR["lastList"]["reg_date"]?>">
			<input type="hidden" name="objdate" value="<?php echo $TPL_VAR["lastList"]["objdate"]?>">
			<input type="submit" align="left" value="정산하기" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'">
		</form>
		
		<table cellspacing="1" class="tableStyle_normal add" summary="정산 예정 금액">
			<legend class="blind">정산 예정 금액</legend>
			<thead>	
				<tr> 
					<th>입금금액</th>
					<th>출금금액</th>
					<th>배팅금액</th>
					<th>당첨금액</th>
					<th>파트너정산</th>
					<th>정산금액</th>
					<th>정산시작</th>
					<th>정산완료</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php echo number_format($TPL_VAR["lastList"]["exchange_money"],0)?></td>
					<td><?php echo number_format($TPL_VAR["lastList"]["change_money"],0)?></td>
					<td><?php echo number_format($TPL_VAR["lastList"]["acc_bet"],0)?></td>
					<td><?php echo number_format($TPL_VAR["lastList"]["acc_bonus_money"],0)?></td>
					<td><?php echo number_format($TPL_VAR["lastList"]["acc_partner"],0)?></td>
					<td><?php echo number_format($TPL_VAR["lastList"]["exchange_money"]-$TPL_VAR["lastList"]["change_money"]-$TPL_VAR["lastList"]["acc_partner"])?></td>
					<td><?php echo $TPL_VAR["lastList"]["reg_date"]?></td>
					<td><?php echo $TPL_VAR["lastList"]["objdate"]?></td>
				</tr>
			</tbody>
		</table>
<?php }?>
	
	<p class="icon">정산 내역 (단위 : 매주)</p>
	<form id="form1" name="form1" method="post" action="?act=delete_user">
	<table cellspacing="1" class="tableStyle_normal add" summary="정산 내역">
	<legend class="blind">정산 내역</legend>
	<thead>	
		<tr>
			<th>입금금액</th>
			<th>출금금액</th>
			<th>배팅금액</th>
			<th>당첨금액</th>
			<th>파트너정산</th>
			<th>정산금액</th>
			<th>정산시작</th>
			<th>정산완료</th>
			<th>정산마감일</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
			<tr>
				<td><?php echo number_format($TPL_V1["acc_exchange"],0)?></td>
				<td><?php echo number_format($TPL_V1["acc_change"],0)?></td>
				<td><?php echo number_format($TPL_V1["acc_bet"],0)?></td>
				<td><?php echo number_format($TPL_V1["acc_bonus"],0)?></td>
				<td><?php echo number_format($TPL_V1["acc_partner"],0)?></td>
				<td><?php echo number_format($TPL_V1["acc_site"],0)?></td>
				<td><?php echo $TPL_V1["start_date"]?></td>
				<td><?php echo $TPL_V1["over_date"]?></td>
				<td><?php echo $TPL_V1["reg_date"]?></td>
	  		</tr>	
<?php }}?>
	</tbody>
	</table>	
	</form>

	<div id="pages2">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>

</div>

</div>