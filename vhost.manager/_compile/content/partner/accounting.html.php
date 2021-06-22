<?php /* Template_ 2.2.3 2012/11/30 16:47:18 D:\www\vhost.manager\_template\content\partner\accounting.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>
	
function go_del(url)
{
	if(confirm("정말 삭제하시겠습니까?"))
	{
		document.location = url;
	}
	else
	{
		return;
	}
}

</script>

<div class="wrap" id="partner_accounting">

	<div id="route">
		<h5>관리자 시스템 > 파트너 관리 > <b>정산 신청</b></h5>
	</div>

	<h3>정산 신청</h3>

	<ul id="tab">
		<li><a href="/partner/accounting" id="partner_accounting">정산 신청</a></li>
		<li><a href="/partner/accounting_fin" id="partner_accounting_fin">정산 완료</a></li>
	</ul>

	<form id="form1" name="form1" method="post" action="?act=delete_user">
	<table cellspacing="1" class="tableStyle_normal" summary="정산 신청 목록">
	<legend class="blind">정산 신청</legend>
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
			<th scope="col">처리</th>
		</tr>
	</thead>
	<tbody>	
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
			<tr>
				<td><?php echo $TPL_V1["rec_id"]?>(<font color="red"><?php echo $TPL_V1["rate"]?></font>%)</td>
				<td >입금(<?php echo number_format($TPL_V1["charge_money"],0)?>)-출금(<?php echo number_format($TPL_V1["exchange_money"],0)?>)=<?php echo number_format($TPL_V1["charge_money"]-$TPL_V1["exchange_money"],0)?></td>
				<td><?php echo number_format($TPL_V1["opt_money"],0)?></span></td>
				<td><?php echo $TPL_V1["bank_name"]?></span></td>
				<td><?php echo $TPL_V1["bank_num"]?></td>
				<td><?php echo $TPL_V1["bank_username"]?></td>
				<td><?php echo $TPL_V1["start_date"]?></td>
				<td><?php echo $TPL_V1["end_date"]?></td>
				<td><a href="javascript:void(0)" onclick="go_del('?act=cancel&idx=<?php echo $TPL_V1["idx"]?>')"><img src="/img/btn_s_del.gif" title="삭제"></a>&nbsp;<a href="?act=renew&idx=<?php echo $TPL_V1["idx"]?>"><img src="/img/btn_s_account.gif" title="정산"></a></td>
			</tr>
<?php }}?>	
	</tbody>
	</table>
	</form>

	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>

</div>