<?php /* Template_ 2.2.3 2012/10/08 22:15:41 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\content.stat.money.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>
	function on_click()
	{
		data=document.getElementById("date_id").value;
		data1=document.getElementById("date_id1").value;
		if(data=="" || data1=="")
		{
			alert("시간을 선택하여 주십시오.");
			return false;
		}
		else if(data1<data)
		{
			alert("끝나는 날자가 시작하는 날자보다 작을수 없습니다.");
			return false;
		}
		document.getElementById("form2").submit();
	}
</script>

<div class="wrap">

	<div id="route">
		<h5>관리자 시스템 > 통계 > <b>입출금 통계</b></h5>
	</div>

	<h3>입출금 통계</h3>

	<div id="search2">
		<div>
			<form action="?" method="GET" name="form2" id="form2">
				<span class="icon">파트너</span><input type="text" name="partner_id" value="<?php echo $TPL_VAR["partner_id"]?>">
				<span class="icon">날짜</span><input name="date_id" type="text" id="date_id" class="date" value="<?php echo $TPL_VAR["date_id"]?>" maxlength="20" onclick="new Calendar().show(this);" > ~ 
				<input name="date_id1" type="text" id="date_id1" class="date" value="<?php echo $TPL_VAR["date_id1"]?>" maxlength="20"  onclick="new Calendar().show(this);" >
				<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
			</form>
		</div>
	</div>

	<form id="form1" name="form1" method="post" action="?act=delete_user">
	<table cellspacing="1" class="tableStyle_normal add" summary="입/출금 통계">
	<legend class="blind">입/출금</legend>
	<thead>
		<tr>
			<th scope="col">날짜</th>
			<th scope="col">가입수</th>
			<th scope="col">접속수</th>
			<th scope="col">입금총액</th>
			<th scope="col">입금횟수</th>
			<th scope="col">출금총액</th>
			<th scope="col">출금횟수</th>
			<th scope="col">배팅금액</th>
			<th scope="col">당첨금액</th>
			<th scope="col">입금보너스</th>
			<th scope="col">수익</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
			<tr>
				<td><?php echo $TPL_V1["dada"]?></td>
				<td><?php echo $TPL_V1["newMemNum"]?></td>
				<td><?php echo $TPL_V1["countVisit"]?></td>
				<td><?php echo number_format($TPL_V1["sumExchange"],0)?></td>
				<td><?php echo $TPL_V1["countExchange"]?></td>
				<td><?php echo number_format($TPL_V1["sumChange"],0)?></td>
				<td><?php echo $TPL_V1["countChange"]?></td>
				<td><?php echo number_format($TPL_V1["betmoney"],0)?></td>
				<td><?php echo number_format($TPL_V1["resmoney"],0)?></td>
				<td><?php echo number_format($TPL_V1["sumBonus"],0)?></td>
				<td><?php echo number_format($TPL_V1["sumExchange"]-$TPL_V1["sumChange"],0)?></td>
			 </tr>
<?php }}?>
	</tbody>
	<tfoot>
		<tr>
			<td>합계</td>
			<td><?php echo $TPL_VAR["sumList"]["totNewMemNum"]?></td>
			<td><?php echo $TPL_VAR["sumList"]["totCountVisit"]?></td>
			<td><?php echo number_format($TPL_VAR["sumList"]["totSumExchange"],0)?></td>
			<td><?php echo $TPL_VAR["sumList"]["totCountExchange"]?></td>
			<td><?php echo number_format($TPL_VAR["sumList"]["totSumChange"],0)?></td>
			<td><?php echo $TPL_VAR["sumList"]["totCountChange"]?></td>
			<td><?php echo number_format($TPL_VAR["sumList"]["toSumBetMoney"],0)?></td>
			<td><?php echo number_format($TPL_VAR["sumList"]["toResultMoney"],0)?></td>
			<td><?php echo number_format($TPL_VAR["sumList"]["totSumBonus"],0)?></td>
			<td><?php echo number_format($TPL_VAR["sumList"]["totSumExchange"]-$TPL_VAR["list"]["totSumChange"],0)?></td>
		 </tr>
	</tfoot>
	</table>		 
	</form>	

</div>