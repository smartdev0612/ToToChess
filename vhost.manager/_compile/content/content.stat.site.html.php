<?php /* Template_ 2.2.3 2012/10/08 20:21:13 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\content.stat.site.html */?>
<div class="wrap">

	<div id="route">
		<h5>관리자 시스템 > 통계 > <b>사이트 현황</b></h5>
	</div>

	<h3>사이트 현황</h3>

	<form id="form1" name="form1" method="post" action="?act=delete_user">
		<table cellspacing="1" class="tableStyle_normal add" summary="사이트 현황 정보">
			<legend class="blind">사이트 현황</legend>
			<thead>
				<tr>
					<th scope="col">총회원</th>
					<th scope="col">금일가입</th>
					<th scope="col">보유금액</th>
					<th scope="col" colspan="2">게임[총수/마감]</th>
					<th scope="col" colspan="2">배팅[금액/수량]</th>
					<th scope="col" colspan="2">금일입금[금액/건수]</th>
					<th scope="col" colspan="2">금일출금[금액/건수]</th>
					<th scope="col" colspan="2">환전대기[금액/건수]</th>
				</tr>
			</thead>
			<tbody>vhe
				<tr>
					<td><?php echo $TPL_VAR["list"]["member_count"]?></td>
					<td><?php echo $TPL_VAR["list"]["new_member_count"]?></td>
					<td><?php echo number_format($TPL_VAR["list"]["sum_money"],0)?></td>
					<td><?php echo $TPL_VAR["list"]["ing_game"]+$TPL_VAR["list"]["fin_game"]?></td>
					<td><?php echo $TPL_VAR["list"]["fin_game"]?></td>
					<td><?php echo number_format($TPL_VAR["list"]["sum_betting"],0)?></td>
					<td><?php echo $TPL_VAR["list"]["bet_count"]?></td>
					<td><?php echo number_format($TPL_VAR["list"]["sum_exchange"],0)?></td>
					<td><?php echo $TPL_VAR["list"]["exchange_count"]?></td>
					<td><?php echo number_format($TPL_VAR["list"]["sum_charge"],0)?></td>
					<td><?php echo $TPL_VAR["list"]["charge_count"]?></td>
					<td><?php echo number_format($TPL_VAR["list"]["sum_ready"],0)?></td>
					<td><?php echo $TPL_VAR["list"]["ready_count"]?></td>
				</tr>
			</tbody>
		</table>
	</form>
</div>