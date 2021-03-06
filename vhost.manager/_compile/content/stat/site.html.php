<?php
$TPL_partner_list_1=empty($TPL_VAR["partner_list"])||!is_array($TPL_VAR["partner_list"])?0:count($TPL_VAR["partner_list"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>document.title = '통계-사이트 현황';</script>
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
		<h5>관리자 시스템 > 통계 > <b>사이트 현황</b></h5>
	</div>
	
	<h3>사이트 현황</h3>
	
	<div id="search2">
		<div>
			<form action="?" method="GET" name="form2" id="form2">
				<span class="icon">사이트</span>
				<select name="filter_logo">
					<option value=""  <?php if($TPL_VAR["filter_logo"]==""){?>  selected <?php }?>>전체</option>
					<option value="gadget" <?php if($TPL_VAR["filter_logo"]=="gadget"){?>  selected <?php }?>>gadget</option>
				</select>
				<!-- 총판 필터 -->
				<select name="filter_partner_sn">
					<option value="" <?php if($TPL_VAR["filter_partner_sn"]==""){?> selected <?php }?>>총판</option>
<?php if($TPL_partner_list_1){foreach($TPL_VAR["partner_list"] as $TPL_V1){?>
						<option value=<?php echo $TPL_V1["Idx"]?> <?php if($TPL_VAR["filter_partner_sn"]==$TPL_V1["Idx"]){?> selected <?php }?>><?php echo $TPL_V1["rec_id"]?></option>
<?php }}?>
				</select>
				
				<!-- 기간 검색 -->
				<span class="icon">날짜</span><input name="begin_date" type="text" id="begin_date" class="date" value="<?php echo $TPL_VAR["begin_date"]?>" maxlength="25" onclick="new Calendar().show(this);" > ~ 
				<input name="end_date" type="text" id="end_date" class="date" value="<?php echo $TPL_VAR["end_date"]?>" maxlength="25"  onclick="new Calendar().show(this);" >
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
			<th scope="col">신규회원</th>
			<th scope="col">접속회원</th>
			<th scope="col">입금회원</th>
			<th scope="col">배팅회원</th>
			<th scope="col" colspan='2'>입금(금액/건수)</th>
			<th scope="col" colspan='2'>출금(금액/건수)</th>
			<th scope="col" colspan='2'>배팅(금액/건수)</th>
			<!--<th scope="col" colspan='2'>게임수</th>-->
		</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
		<tr>
			<td><?php echo $TPL_V1["current_date"]?>(<?php echo $TPL_V1["current_date_name"]?>)</td>
			<td class="moneyTd"><?php echo number_format($TPL_V1["member_count"],0)?>명 </td>
			<td class="moneyTd"><?php echo number_format($TPL_V1["visit_member_count"],0)?>명 </td>
			<td class="moneyTd"><?php echo number_format($TPL_V1["charge_member_count"],0)?>명 </td>
			<td class="moneyTd"><?php echo number_format($TPL_V1["betting_member_count"],0)?>명 </td>
			<td class="betTd" align='right'><?php echo number_format($TPL_V1["sum_charge"],0)?></td>
			<td class="betTd"><font color='#4374D9'><?php echo number_format($TPL_V1["charge_count"],0)?></font></td>
			<td class="betTd" align='right'><?php echo number_format($TPL_V1["sum_exchange"],0)?></td>
			<td class="betTd"><font color='#4374D9'><?php echo number_format($TPL_V1["exchange_count"],0)?></font></td>
			<td class="betTd" align='right'><?php echo number_format($TPL_V1["sum_betting"],0)?></td>
			<td class="betTd"><font color='#4374D9'><?php echo number_format($TPL_V1["bet_count"],0)?></font></td>
			<!--<td class="betTd"><?php echo number_format($TPL_V1["ing_game"],0)?>/<?php echo number_format($TPL_V1["fin_game"],0)?></td>-->
<?php }}?>
	</tbody>
	<tfoot>
		<tr>
			<td>합계</td>
			<td><?php echo number_format($TPL_VAR["sumList"]["total_member_count"],0)?>명 </td>
			<td><?php echo number_format($TPL_VAR["sumList"]["total_visit_member_count"],0)?>명 </td>
			<td><?php echo number_format($TPL_VAR["sumList"]["total_charge_member_count"],0)?>명 </td>
			<td><?php echo number_format($TPL_VAR["sumList"]["total_betting_member_count"],0)?>명 </td>
			<td align='right'><?php echo number_format($TPL_VAR["sumList"]["total_sum_charge"],0)?></td>
			<td><font color='#4374D9'><?php echo number_format($TPL_VAR["sumList"]["total_charge_count"],0)?></font></td>
			<td align='right'><?php echo number_format($TPL_VAR["sumList"]["total_sum_exchange"],0)?></td>
			<td><font color='#4374D9'><?php echo number_format($TPL_VAR["sumList"]["total_exchange_count"],0)?></td>
			<td align='right'><?php echo number_format($TPL_VAR["sumList"]["total_sum_betting"],0)?></td>
			<td><font color='#4374D9'><?php echo number_format($TPL_VAR["sumList"]["total_bet_count"],0)?></td>
			<!--<td class="betTd"><?php echo number_format($TPL_VAR["sumList"]["total_ing_game"],0)?>/<?php echo number_format($TPL_VAR["sumList"]["total_fin_game"],0)?></td>-->
		</tr>
	</tfoot>
	</table>		 
	</form>	
</div>