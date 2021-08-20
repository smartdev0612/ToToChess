<?php $TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<title>입출금 통계</title>
<script>
	var rec_tex_money = <?php echo $TPL_VAR["parentInfo"]["rec_money"]+0;?>;
    window.onload = function()
    {
        // beginTimer2();
    }

    function beginTimer2() {
        timer = window.setInterval("on_click()",5000);
    }

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
		document.getElementById("form3").submit();
	}

	function submit_tex_money(form) {
		if ( form.tex_exchange_money.value > rec_tex_money ) {
			alert("보유정산금이 부족합니다.");
			return false;
		}
		var money_str = FormatNumber(form.tex_exchange_money.value);
		if ( !money_str ) return false;
		var result = confirm("[ "+money_str+"원 ] 출금 신청 하시겠습니까?");
		if ( !result ) return false;
	}
</script>

<div id="wrap">
	<h1>입출금 통계</h1>

	<div id="search">	
		<div style="float:left;">
			<form name='form3' id='form3' action='' method='POST' onsubmit="return on_click();">
			<span>날짜</span>
			<input type="text" id="date_id" name="date" onclick='new Calendar().show(this);' value="<?php echo $TPL_VAR["date"]?>" class="date" style="width:80px;"> ~
			<input type="text" id="date_id1" name="date1" onclick='new Calendar().show(this);'  value="<?php echo $TPL_VAR["date1"]?>" class="date" style="width:80px;">
			<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" style="padding:0 0 5px 0;" />
			</form>
		</div>
		<div style="float:right;">
			<form method='post' name='texForm' action='?act=tex_exchange' onSubmit="return submit_tex_money(this);">
			보유정산금 : <font color="red"><?php echo number_format($TPL_VAR["parentInfo"]["rec_money"],0);?></font> 원 | 
			<input type="text" name="tex_exchange_money" value="<?php echo $TPL_VAR["parentInfo"]["rec_money"];?>" style="width:80px;"> <input type="submit" name="tex_submit" value="출금신청" <?=($TPL_VAR["parentInfo"]["rec_money"] < 0) ? "disabled" : ""?>>
			</form>
		</div>
	</div> 
	
	<table cellspacing="1" class="tableStyle_normal" summary="입출금 통계">
	<legend class="blind">입출금 통계</legend>
	<thead>
	<tr>
		<th scope="col">날짜</th>
		<th scope="col">입금총액</th>
		<th scope="col">출금총액</th>
		<th scope="col">배팅금액</th>
		<th scope="col">당첨금액</th>
		<th scope="col">낙첨금액</th>
		<th scope="col">MG배팅금액</th>
		<th scope="col">MG당첨금액</th>
		<th scope="col">MG낙첨금액</th>
		<th scope="col">지급포인트</th>
		<th scope="col">정산타입</th>
		<th scope="col">정산율</th>
		<th scope="col">정산금</th>
	</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
<?php
	$sum_money_to_charge += $TPL_V1["money_to_charge"]; //->입금금액
	$sum_money_to_exchange += $TPL_V1["money_to_exchange"]; //->출금금액

	$sum_betting_money += ($TPL_V1["betting_to_ready"]+$TPL_V1["betting_to_win"]+$TPL_V1["betting_to_lose"]); //->배팅금
	$sum_result_to_win += $TPL_V1["result_to_win"]; //->당첨금
	$sum_betting_to_lose += ($TPL_V1["betting_to_win"]+$TPL_V1["betting_to_lose"])-$TPL_V1["result_to_win"]; //->낙첨금

	$sum_betting_money_mgame += ($TPL_V1["betting_to_win_mgame"]+$TPL_V1["betting_to_lose_mgame"]); //->미니게임 배팅금
	$sum_betting_result_win_mgame += $TPL_V1["result_to_win_mgame"]; //->미니게임 당첨금
	$sum_betting_lose_mgame += ($TPL_V1["betting_to_win_mgame"]+$TPL_V1["betting_to_lose_mgame"])-$TPL_V1["result_to_win_mgame"]; //->미니게임 낙첨금

	$sum_get_tex_money += $TPL_V1["get_tex_money"];
?>
		<tr>
			<td><?php echo substr($TPL_V1["regdate"],0,10)?></td>
			<td><?php echo number_format($TPL_V1["money_to_charge"],0)?></td>
			<td><?php echo number_format($TPL_V1["money_to_exchange"],0)?></td>
			<td><?php echo number_format(($TPL_V1["betting_to_ready"]+$TPL_V1["betting_to_win"]+$TPL_V1["betting_to_lose"]),0)?></td>
			<td><?php echo number_format($TPL_V1["result_to_win"],0)?></td>
			<td><?php echo number_format(($TPL_V1["betting_to_win"]+$TPL_V1["betting_to_lose"])-$TPL_V1["result_to_win"],0)?></td>
			<td><?php echo number_format(($TPL_V1["betting_to_win_mgame"]+$TPL_V1["betting_to_lose_mgame"]),0)?></td>
			<td><?php echo number_format($TPL_V1["result_to_win_mgame"],0)?></td>
			<td><?php echo number_format(($TPL_V1["betting_to_win_mgame"]+$TPL_V1["betting_to_lose_mgame"])-$TPL_V1["result_to_win_mgame"],0)?></td>
			<td>
<?php 
	$point = $TPL_V1["mileage_to_charge"] + $TPL_V1["mileage_to_recomm_lose"] + 
							$TPL_V1["mileage_to_multi_folder"] + $TPL_V1["mileage_to_multi_folder_lose"];
	if ( $TPL_V1["save_one_folder_flag"] > 0 ) {
		$point += $TPL_V1["mileage_to_one_folder_lose"];
	}
	$sum_point += $point;
	echo number_format($point,0);
	$saveRate = str_replace(" | ","% | ",$TPL_V1["save_rate"]);
?>
			</td>
			<td><?php echo $TPL_V1["save_rate_type"]?></td>
			<td><?php echo $saveRate;?>%</td>
			<td><?php echo $TPL_V1["get_tex_money"]?></td>
		</tr>
<?php }}?>
	</tbody>
	<tfoot>
		<tr>
			<td>합계</td>
			<td><?php echo number_format($sum_money_to_charge,0)?></td>
			<td><?php echo number_format($sum_money_to_exchange,0)?></td>
			<td><?php echo number_format($sum_betting_money,0)?></td>
			<td><?php echo number_format($sum_result_to_win,0)?></td>
			<td><?php echo number_format($sum_betting_to_lose,0)?></td>
			<td><?php echo number_format($sum_betting_money_mgame,0)?></td>
			<td><?php echo number_format($sum_betting_result_win_mgame,0)?></td>
			<td><?php echo number_format($sum_betting_lose_mgame,0)?></td>
			<td><?php echo number_format($sum_point,0)?></td>
			<td>-</td>
			<td>-</td>
			<td><?php echo number_format($sum_get_tex_money,0)?></td>
		 </tr>
	</tfoot>
	</table>
</div>