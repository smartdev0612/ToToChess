<?php /* Template_ 2.2.3 2012/10/08 23:12:35 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\content.stat.bet.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<div class="wrap">

	<div id="route">
		<h5>관리자 시스템 > 통계 > <b>배팅 통계</b></h5>
	</div>

	<h3>배팅 통계</h3>

	<div id="search2">
		<div>
			<form action="?" method="GET" name="form2" id="form2">
				<span class="icon">날짜</span><input name="date_id" type="text" id="date_id" class="date" value="<?php echo $TPL_VAR["date_id"]?>" maxlength="20" onclick="new Calendar().show(this);" /> ~ 
				<input name="date_id1" type="text" id="date_id1" class="date" value="<?php echo $TPL_VAR["date_id1"]?>" maxlength="20" onclick="new Calendar().show(this);" />
				<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
			</form>
		</div>
	</div>

	<form id="form1" name="form1" method="post" action="?act=delete_user">
	<table cellspacing="1" class="tableStyle_normal add" summary="배팅 통계">
	<legend class="blind">배팅 통계</legend>
	<thead>
		<tr>
		  <th scope="col">날짜</th>
		  <th scope="col">게임수</th>
		  <th scope="col">승무패</th>
		  <th scope="col">핸디캡</th>>
		  <th scope="col">하이로우</th>
		  <th scope="col">입금총액</th>
		  <th scope="col">출금총액</th>
		  <th scope="col">배팅총액</th>
		  <th scope="col">배팅</th>
		  <th scope="col">당첨총액</th>
		  <th scope="col">당첨</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
			<tr>
				<td><?php echo $TPL_V1["dada"]?></td>
				<td><?php echo $TPL_V1["sfbsum"]+$TPL_V1["handsum"]+$TPL_V1["endsum"]?></td>
				<td><?php echo $TPL_V1["sfbsum"]?></td>
				<td><?php echo $TPL_V1["handsum"]?></td>
				<td><?php echo $TPL_V1["endsum"]?></td>
				<td><?php echo number_format($TPL_V1["sumExchange"],0)?></td>
				<td><?php echo number_format($TPL_V1["sumChange"],0)?></td>
				<td><?php echo number_format($TPL_V1["sumBetMoney"],0)?></td>
				<td><?php echo $TPL_V1["countBet"]?></td>
				<td><?php echo number_format($TPL_V1["sumWinMoney"],0)?></td>
				<td><?php echo $TPL_V1["countWinBet"]?></td>
			 </tr>
<?php }}?>
	</tbody>
	<tfoot>
		<tr>
			<td>합계</td>
			<td><?php echo $TPL_VAR["totalList"]["totSfbSum"]+$TPL_VAR["totalList"]["totHandSum"]+$TPL_VAR["totalList"]["totEndSum"]?></td>
			<td><?php echo $TPL_VAR["totalList"]["totSfbSum"]?></td>
			<td><?php echo $TPL_VAR["totalList"]["totHandSum"]?></td>
			<td><?php echo $TPL_VAR["totalList"]["totEndSum"]?></td>
			<td><?php echo number_format($TPL_VAR["totalList"]["totSumExchange"],0)?></td>
			<td><?php echo number_format($TPL_VAR["totalList"]["totSumChange"],0)?></td>
			<td><?php echo number_format($TPL_VAR["totalList"]["totSumBetMoney"],0)?></td>
			<td><?php echo $TPL_VAR["totalList"]["totCountBet"]?></td>
			<td><?php echo number_format($TPL_VAR["totalList"]["totSumWinMondy"],0)?></td>
			<td><?php echo $TPL_VAR["totalList"]["totCountWinBet"]?></td>
		</tr>
	</tfoot>
	</table>
	</form>

</div>