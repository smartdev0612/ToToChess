<?php 
	$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
?>
<script>document.title = '부본사관리-부본사정산';</script>
<script>
function select_tex() {
}
</script>

<div class="wrap">
	<div id="route">
		<h5>관리자시스템 > 부본사 관리 > <b>부본사 정산</b></h5>
	</div>

	<h3>부본사 정산 목록</h3>

<?php
	if ( strlen($TPL_VAR["startDate"]) > 0 and strlen($TPL_VAR["endDate"]) > 0 ) {
		$hideFlag = 0;
	} else {
		$hideFlag = 1;
	}
?>

	<div id="search">
		<div class="wrap">
			<form action="?" method="GET" name="texForm" id="texForm">
				<span>정산날짜</span>
				<input type="text" id="texDate" name="texDate" onclick='new Calendar().show(this);' value="<?php echo $TPL_VAR["texDate"]?>" class="date">
				<!-- 검색버튼 -->
				<input name="texFormSubmit" type="image" src="/img/btn_search.gif" class="imgType" />
			</form>
		</div>
		<div class="wrap" style="float:right;">
			<form action="?" method="GET" name="searchForm" id="searchForm">
				<span>조회날짜</span>
				<input type="text" id="startDate" name="startDate" onclick='new Calendar().show(this);' value="<?php echo $TPL_VAR["startDate"]?>" class="date"> ~
				<input type="text" id="endDate" name="endDate" onclick='new Calendar().show(this);'  value="<?php echo $TPL_VAR["endDate"]?>" class="date">
				<!-- 검색버튼 -->
				<input name="searchFormSubmit" type="image" src="/img/btn_search.gif" class="imgType" />
			</form>
		</div>
	</div>

	<form id="texListForm" name="texListForm" method="post" action="?act=tex_proc">
	<input type="hidden" name="texDate" value="<?php echo $TPL_VAR["texDate"]?>">
	<input type="hidden" name="startDate" value="<?php echo $TPL_VAR["startDate"]?>">
	<input type="hidden" name="endDate" value="<?php echo $TPL_VAR["endDate"]?>">
	<table cellspacing="1" class="tableStyle_members" summary="부본사 목록">
		<legend class="blind">부본사 목록</legend>
		<thead>
			<tr>
				<th scope="col">아이디</th>
				<th scope="col">보유금액</th>
				<th scope="col">입금금액</th>
				<th scope="col">출금금액</th>
				<th scope="col">입금-출금</th>
				<th scope="col">배팅금</th>
				<th scope="col">당첨금액</th>
				<th scope="col">낙첨금액</th>
				<th scope="col">MG배팅금</th>
				<th scope="col">MG당첨금</th>
				<th scope="col">MG낙첨금</th>
				<th scope="col">단폴더</th>
				<th scope="col">정산기준</th>
				<th scope="col">정산비율</th>
				<th scope="col">예정정산금</th>
				<th scope="col">처리정산금</th>
<?php
	if ( $hideFlag ) echo "<th scope=\"col\">정산날짜</th>";
	else echo "<th scope=\"col\">대기금액</th>";
?>
			</tr>
		</thead>
		<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
<?php 
	if ( !strlen(trim($TPL_V1["rec_id_top"])) ) continue;

	if ( $TPL_V1["save_one_folder_flag"] == 1 ) $TPL_V1["save_one_folder_flag"] = "포함";
	else $TPL_V1["save_one_folder_flag"] = "미포함";

	$sum_rec_money += $TPL_V1["rec_money"]; //->보유금액
	$sum_money_to_charge += $TPL_V1["money_to_charge"]; //->입금금액
	$sum_money_to_exchange += $TPL_V1["money_to_exchange"]; //->출금금액
	$sum_money_to_charge_exchange += ($TPL_V1["money_to_charge"]-$TPL_V1["money_to_exchange"]); //->입금-출금
	$sum_betting_to_win_lose += ($TPL_V1["betting_to_win"]+$TPL_V1["betting_to_lose"]); //->배팅금
	$sum_result_to_win += $TPL_V1["result_to_win"]; //->당첨금
	$sum_result_to_lose += ($TPL_V1["betting_to_win"]+$TPL_V1["betting_to_lose"])-$TPL_V1["result_to_win"]; //->낙첨금
	$sum_betting_to_win_lose_mgame += ($TPL_V1["betting_to_win_mgame"]+$TPL_V1["betting_to_lose_mgame"]); //->미니게임 배팅금
	$sum_betting_to_result_to_win_mgame += $TPL_V1["result_to_win_mgame"]; //->미니게임 당첨금
	$sum_betting_to_lose_mgame += ($TPL_V1["betting_to_win_mgame"]+$TPL_V1["betting_to_lose_mgame"]) - $TPL_V1["result_to_win_mgame"]; //->미니게임 낙첨금

	$sum_tex_money += $TPL_V1["tex_money_top"];
	$sum_get_tex_money += $TPL_V1["get_tex_money_top"];
	$sum_betting_to_ready += $TPL_V1["betting_to_ready"];
?>
			<tr>
				<td><a href="javascript:open_window('/partner/memberDetailsTop?idx=<?php echo $TPL_V1["rec_sn_top"]?>',640,440)"><?php echo $TPL_V1["rec_id_top"]?></a></td>
				<td><?php echo number_format($TPL_V1["rec_money"],0)?></td> <!--보유금액-->
				<td><?php echo number_format($TPL_V1["money_to_charge"],0)?></td> <!--입금금액-->
				<td><?php echo number_format($TPL_V1["money_to_exchange"],0)?></td> <!--출금금액-->
				<td><?php echo number_format(($TPL_V1["money_to_charge"]-$TPL_V1["money_to_exchange"]),0)?></td> <!--입금-출금-->
				<td><?php echo number_format($TPL_V1["betting_to_win"]+$TPL_V1["betting_to_lose"],0)?></td> <!--배팅금-->
				<td><?php echo number_format($TPL_V1["result_to_win"],0)?></td> <!--당첨금-->
				<td><?php echo number_format(($TPL_V1["betting_to_win"]+$TPL_V1["betting_to_lose"])-$TPL_V1["result_to_win"],0)?></td> <!--낙첨금-->
				<td><?php echo number_format($TPL_V1["betting_to_win_mgame"]+$TPL_V1["betting_to_lose_mgame"],0)?></td> <!--미니게임 배팅금-->
				<td><?php echo number_format($TPL_V1["result_to_win_mgame"],0)?></td> <!--미니게임 당첨금-->
				<td><?php echo number_format(($TPL_V1["betting_to_win_mgame"]+$TPL_V1["betting_to_lose_mgame"])-$TPL_V1["result_to_win_mgame"],0)?></td> <!--미니게임 낙첨금-->
				<td><?php echo $TPL_V1["save_one_folder_flag"]?></td>
				<td><?php echo $TPL_V1["save_rate_type"]?></td>
				<td><?php echo $TPL_V1["save_rate_top"]?> %</td>
				<td><?php echo number_format($TPL_V1["tex_money_top"],0)?></td>
				<td><?php echo number_format($TPL_V1["get_tex_money_top"],0)?></td>
				<td>
					<?php 
						if ( $TPL_V1["betting_to_ready"] > 0 ) {
							echo "<font color='red'>정산보류 [결과대기(".number_format($TPL_V1["betting_to_ready"],0).")]</font>";
						} else {
							if ( $hideFlag ) echo $TPL_V1["texdate"];
							else echo "0";
						}
					?>
				</td>
			</tr>
<?php }}?>
			<tr>
				<td><b>합계</b></td>
				<td><b><?php echo number_format($sum_rec_money,0)?></b></td> <!--보유금액-->
				<td><b><?php echo number_format($sum_money_to_charge,0)?></b></td> <!--입금금액-->
				<td><b><?php echo number_format($sum_money_to_exchange,0)?></b></td> <!--출금금액-->
				<td><b><?php echo number_format($sum_money_to_charge_exchange,0)?></b></td> <!--입금-출금-->
				<td><b><?php echo number_format($sum_betting_to_win_lose,0)?></b></td> <!--배팅금-->
				<td><b><?php echo number_format($sum_result_to_win,0)?></b></td> <!--당첨금-->
				<td><b><?php echo number_format($sum_result_to_lose,0)?></b></td> <!--낙첨금-->
				<td><b><?php echo number_format($sum_betting_to_win_lose_mgame,0)?></b></td> <!--미니게임 배팅금-->
				<td><b><?php echo number_format($sum_betting_to_result_to_win_mgame,0)?></b></td> <!--미니게임 당첨금-->
				<td><b><?php echo number_format($sum_betting_to_lose_mgame,0)?></b></td> <!--미니게임 낙첨금-->
				<td>-</td>
				<td>-</td>
				<td>-</td>
				<td><b><?php echo number_format($sum_tex_money,0)?></b></td>
				<td><b><?php echo number_format($sum_get_tex_money,0)?></b></td>
				<td><b>
					<?php 
						if ( $sum_betting_to_ready > 0 ) {
							echo number_format($sum_betting_to_ready,0);
						} else {
							echo "-";
						}
					?></b>
				</td>
			</tr>
		</tbody>
	</table>
	</form>
	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>
	</div>
</div>