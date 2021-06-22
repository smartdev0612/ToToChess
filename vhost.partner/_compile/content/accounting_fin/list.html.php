<?php /* Template_ 2.2.3 2012/11/19 16:25:42 D:\www\vhost.partner\_template\content\accounting_fin\list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<div id="wrap">
	<h1>정산내역</h1>

	
	<form id="form1" name="form1" method="post" action="?act=delete_user">
	<table cellspacing="1" class="tableStyle_normal" summary="정산 완료 목록">
	<legend class="blind">정산 완료</legend>
	<thead>
		<tr>
			<th scope="col">파트너</th>
			<th scope="col">정산내역</th>
			<th scope="col">정산금액</th>
			<th scope="col">은행명</th>
			<th scope="col">계좌번호</th>
			<th scope="col">예금주</th>
			<th scope="col">정산시작</th>
			<th scope="col">정산완료</th>
			<th scope="col">상태</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
		  <tr>
				<td><?php echo $TPL_V1["rec_id"]?>(<font color="red"><?php echo $TPL_V1["rate"]?></font>%)</td>
				<td>입금(<?php echo number_format($TPL_V1["charge_money"],0)?>)-출금(<?php echo number_format($TPL_V1["exchange_money"],0)?>)=<?php echo number_format($TPL_V1["charge_money"]-$TPL_V1["exchange_money"],0)?></td>
				<td class="accont"><span><?php echo number_format($TPL_V1["opt_money"],0)?></span></td>
				<td><span><?php echo $TPL_V1["bank_name"]?></span></td>
				<td><?php echo $TPL_V1["bank_num"]?></td>
				<td><?php echo $TPL_V1["bank_username"]?></td>
				<td><?php echo $TPL_V1["start_date"]?></td>
				<td><?php echo $TPL_V1["end_date"]?></td>
				<td><?php if($TPL_V1["status"]==0){?>처리중<?php }else{?>완료<?php }?></td>
		  </tr>
<?php }}?> 
	</tbody>
	</table>
	</form>

	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>
</div>