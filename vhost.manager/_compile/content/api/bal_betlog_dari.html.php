<?php
	if ( count($TPL_VAR["logList"]) > 0 ) {
		$data = $TPL_VAR["logList"];
		for ( $i = 0 ; $i < count($data) ; $i++ ) {
			$gameDate = $data[$i]["game_date"];
			$gameTh = $data[$i]["game_th"];
			$id = $data[$i]["id"];

			$odd_money = $data[$i]["odd_money"];
			$odd_betting = $data[$i]["odd_betting"];
			$odd_flag = $data[$i]["odd_flag"];
			$even_money = $data[$i]["even_money"];
			$even_flag = $data[$i]["even_flag"];

			$balData = balance_money($odd_money, $even_money);
			$odd_bal_money = $balData['homeMoney'];
			$even_bal_money = $balData['awayMoney'];
			$hitData = hit_money($odd_money, $even_money);
			$odd_hit_money = $hitData['homeMoney'];
			$even_hit_money = $hitData['awayMoney'];

			$left_money = $data[$i]["left_money"];
			$left_betting = $data[$i]["left_betting"];
			$left_flag = $data[$i]["left_flag"];
			$right_money = $data[$i]["right_money"];
			$right_betting = $data[$i]["right_betting"];
			$right_flag = $data[$i]["right_flag"];

			$balData = balance_money($left_money, $right_money);
			$left_bal_money = $balData['homeMoney'];
			$right_bal_money = $balData['awayMoney'];
			$hitData = hit_money($left_money, $right_money);
			$left_hit_money = $hitData['homeMoney'];
			$right_hit_money = $hitData['awayMoney'];

			$line3_money = $data[$i]["line3_money"];
			$line3_betting = $data[$i]["line3_betting"];
			$line3_flag = $data[$i]["line3_flag"];
			$line4_money = $data[$i]["line4_money"];
			$line4_betting = $data[$i]["line4_betting"];
			$line4_flag = $data[$i]["line4_flag"];

			$balData = balance_money($line3_money, $line4_money);
			$line3_bal_money = $balData['homeMoney'];
			$line4_bal_money = $balData['awayMoney'];
			$hitData = hit_money($line3_money, $line4_money);
			$line3_hit_money = $hitData['homeMoney'];
			$line4_hit_money = $hitData['awayMoney'];

			$before_money = $data[$i]["before_money"];
			$after_money = $data[$i]["after_money"];
			$site_rate = $data[$i]["site_rate"];
			$top_site_rate = $data[$i]["top_site_rate"];
			$top_parent_rate = $data[$i]["top_parent_rate"];

			//-> ????????? ??????
			$odd_win_bal_money = (($odd_bal_money + $even_bal_money) - ($odd_bal_money * $site_rate)) / 2;
			$even_win_bal_money = (($odd_bal_money + $even_bal_money) - ($even_bal_money * $site_rate)) / 2;
			$left_win_bal_money = (($left_bal_money + $right_bal_money) - ($left_bal_money * $site_rate)) / 2;
			$right_win_bal_money = (($left_bal_money + $right_bal_money) - ($right_bal_money * $site_rate)) / 2;
			$line3_win_bal_money = (($line3_bal_money + $line4_bal_money) - ($line3_bal_money * $site_rate)) / 2;
			$line4_win_bal_money = (($line3_bal_money + $line4_bal_money) - ($line4_bal_money * $site_rate)) / 2;

			//-> ???????????? ?????? ??????
			$odd_win_hit_money = ($odd_hit_money * $top_site_rate) - ($odd_hit_money * $site_rate);
			$even_win_hit_money = ($even_hit_money * $top_site_rate) - ($even_hit_money * $site_rate);
			$left_win_hit_money = ($left_hit_money * $top_site_rate) - ($left_hit_money * $site_rate);
			$right_win_hit_money = ($right_hit_money * $top_site_rate) - ($right_hit_money * $site_rate);
			$line3_win_hit_money = ($line3_hit_money * $top_site_rate) - ($line3_hit_money * $site_rate);
			$line4_win_hit_money = ($line4_hit_money * $top_site_rate) - ($line4_hit_money * $site_rate);

			//-> ???????????? ?????? ??????
			$odd_win_roll_money = $odd_hit_money * ($top_site_rate / 100);
			$even_win_roll_money = $even_hit_money * ($top_site_rate / 100);
			$left_win_roll_money = $left_hit_money * ($top_site_rate / 100);
			$right_win_roll_money = $right_hit_money * ($top_site_rate / 100);
			$line3_win_roll_money = $line3_hit_money * ($top_site_rate / 100);
			$line4_win_roll_money = $line4_hit_money * ($top_site_rate / 100);

			//-> ???????????????
			$total_sum_money += $odd_money + $even_money + $left_money + $right_money + $line3_money + $line4_money;
			//-> ??????????????????
			$total_balance_money += $odd_bal_money + $even_bal_money + $left_bal_money + $right_bal_money + $line3_bal_money + $line4_bal_money;
			//-> ??????????????????
			$total_hit_money += $odd_hit_money + $even_hit_money + $left_hit_money + $right_hit_money + $line3_hit_money + $line4_hit_money;
			//-> ?????????????????????
			$total_balance_win_money += $odd_win_bal_money + $even_win_bal_money + $left_win_bal_money + $right_win_bal_money + $line3_win_bal_money + $line4_win_bal_money;
			//-> ???????????????????????????
			$total_hit_rate_money += $odd_win_hit_money + $even_win_hit_money + $left_win_hit_money + $right_win_hit_money + $line3_win_hit_money + $line4_win_hit_money;
			//-> ???????????????????????????
			$total_hit_rolling_money += $odd_win_roll_money + $even_win_roll_money + $left_win_roll_money + $right_win_roll_money + $line3_win_roll_money + $line4_win_roll_money;

			$htmlData .= "<table cellspacing=\"1\" class=\"tableStyle_normal2\" summary=\"?????? ?????? ??????\">
											<legend class=\"blind\">?????? ?????? ??????</legend>
											<tbody>
												<tr>
													<th rowspan='7' style='width:80px;'>????????????<br />".$gameTh."??????<br /></th>
													<td align='center' style='background-color:#D5D5D5;'>??????ID</td>
													<td class='betTd' align='center' style='background-color:#B2EBF4;'>".$id."</td>		
													<td align='center' style='background-color:#D5D5D5;'>????????? ??????</td>
													<td class='betTd' align='center' style='background-color:#B2EBF4;'>".number_format($before_money)."???</td>
													<td align='center' style='background-color:#D5D5D5;'>????????? ??????</td>
													<td class='betTd' align='center' style='background-color:#B2EBF4;'>".number_format($after_money)."???</td>
													<td align='center' style='background-color:#D5D5D5;'>??????????????? ??????</td>
													<td class='betTd' align='center' style='background-color:#B2EBF4;'>".$site_rate."</td>
													<td align='center' style='background-color:#D5D5D5;'>??????????????? ??????</td>
													<td class='betTd' align='center' style='background-color:#B2EBF4;'>".$top_site_rate."</td>	
													<td align='center' style='background-color:#D5D5D5;'>??????????????? ?????? ?????????</td>
													<td class='betTd' align='center' style='background-color:#B2EBF4;'>".$top_parent_rate."%</td>		
												</tr>
												<tr>
													<td style='padding-right: 5px;padding-left: 15px;'>??? ?????? ??????</td>
													<td class='betTd' align='right'>".number_format($odd_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>??? ?????? ??????</td>
													<td class='betTd' align='right'>".number_format($even_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>3??? ?????? ??????</td>
													<td class='betTd' align='right'>".number_format($line3_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>4??? ?????? ??????</td>
													<td class='betTd' align='right'>".number_format($line4_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>??? ?????? ??????</td>
													<td class='betTd' align='right'>".number_format($left_money)."???</td>	
													<td style='padding-right: 5px;padding-left: 15px;'>??? ?????? ??????</td>
													<td class='betTd' align='right'>".number_format($right_money)."???</td>		
												</tr>
												<tr>
													<td style='padding-right: 5px;padding-left: 15px;'>??? ????????? ??????</td>
													<td class='betTd' align='right'>".number_format($odd_hit_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>??? ????????? ??????</td>
													<td class='betTd' align='right'>".number_format($even_hit_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>3??? ????????? ??????</td>
													<td class='betTd' align='right'>".number_format($line3_bal_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>4??? ????????? ??????</td>
													<td class='betTd' align='right'>".number_format($line4_hit_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>??? ????????? ??????</td>
													<td class='betTd' align='right'>".number_format($left_hit_money)."???</td>	
													<td style='padding-right: 5px;padding-left: 15px;'>??? ????????? ??????</td>
													<td class='betTd' align='right'>".number_format($right_hit_money)."???</td>		
												</tr>
												<tr>
													<td style='padding-right: 5px;padding-left: 15px;'>??? ????????? ??????</td>
													<td class='betTd' align='right'>".number_format($odd_hit_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>??? ????????? ??????</td>
													<td class='betTd' align='right'>".number_format($even_hit_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>3??? ????????? ??????</td>
													<td class='betTd' align='right'>".number_format($line3_hit_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>4??? ????????? ??????</td>
													<td class='betTd' align='right'>".number_format($line4_hit_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>??? ????????? ??????</td>
													<td class='betTd' align='right'>".number_format($left_hit_money)."???</td>	
													<td style='padding-right: 5px;padding-left: 15px;'>??? ????????? ??????</td>
													<td class='betTd' align='right'>".number_format($right_hit_money)."???</td>		
												</tr>
												<tr>
													<td style='padding-right: 5px;padding-left: 15px;'>??? ????????? ??????</td>
													<td class='betTd' align='right'>".number_format($odd_win_bal_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>??? ????????? ??????</td>
													<td class='betTd' align='right'>".number_format($even_win_bal_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>3??? ????????? ??????</td>
													<td class='betTd' align='right'>".number_format($line3_win_bal_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>4??? ????????? ??????</td>
													<td class='betTd' align='right'>".number_format($line4_win_bal_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>??? ????????? ??????</td>
													<td class='betTd' align='right'>".number_format($left_win_bal_money)."???</td>	
													<td style='padding-right: 5px;padding-left: 15px;'>??? ????????? ??????</td>
													<td class='betTd' align='right'>".number_format($right_win_bal_money)."???</td>		
												</tr>
												<tr>
													<td style='padding-right: 5px;padding-left: 15px;'>??? ?????? ?????? ??????</td>
													<td class='betTd' align='right'>".number_format($odd_win_hit_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>??? ?????? ?????? ??????</td>
													<td class='betTd' align='right'>".number_format($even_win_hit_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>3??? ?????? ?????? ??????</td>
													<td class='betTd' align='right'>".number_format($line3_win_hit_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>4??? ?????? ?????? ??????</td>
													<td class='betTd' align='right'>".number_format($line4_win_hit_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>??? ?????? ?????? ??????</td>
													<td class='betTd' align='right'>".number_format($left_win_hit_money)."???</td>	
													<td style='padding-right: 5px;padding-left: 15px;'>??? ?????? ?????? ??????</td>
													<td class='betTd' align='right'>".number_format($right_win_hit_money)."???</td>		
												</tr>
												<tr>
													<td style='padding-right: 5px;padding-left: 15px;'>??? ?????? ?????? ??????</td>
													<td class='betTd' align='right'>".number_format($odd_win_roll_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>??? ?????? ?????? ??????</td>
													<td class='betTd' align='right'>".number_format($even_win_roll_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>3??? ?????? ?????? ??????</td>
													<td class='betTd' align='right'>".number_format($line3_win_roll_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>4??? ?????? ?????? ??????</td>
													<td class='betTd' align='right'>".number_format($line4_win_roll_money)."???</td>
													<td style='padding-right: 5px;padding-left: 15px;'>??? ?????? ?????? ??????</td>
													<td class='betTd' align='right'>".number_format($left_win_roll_money)."???</td>	
													<td style='padding-right: 5px;padding-left: 15px;'>??? ?????? ?????? ??????</td>
													<td class='betTd' align='right'>".number_format($right_win_roll_money)."???</td>		
												</tr>
											</tbody>
											</table>
											<br>";
		}
	}
?>
<div class="wrap">
	<div id="route">
		<h5>???????????? ????????? > <b>????????? ?????? ????????????</b></h5>
	</div>

	<h3>???????????? ????????? ?????? ????????????</h3>

	<div id="search">
		<form action="?" method="get" name="searchForm" id="searchForm">
			<div class="wrap">
				<span>??????????????? : <?php echo number_format($total_sum_money);?>???</span> &nbsp;
				<span>?????????????????? : <?php echo number_format($total_balance_money);?>???</span>&nbsp;
				<span>?????????????????? : <?php echo number_format($total_hit_money);?>???</span>&nbsp;
				<span>????????????????????? : <?php echo number_format($total_balance_win_money);?>???</span>&nbsp;
				<span>??????????????????????????? : <?php echo number_format($total_hit_rate_money);?>???</span>&nbsp;
				<span>??????????????????????????? : <?php echo number_format($total_hit_rolling_money);?>???</span> 
			</div>
			<div class="wrap_search">
				<!-- ?????? ?????? -->
				<span class="icon">??????????????????</span>
				<input name="searchDate" type="text" id="searchDate" class="date" value="<?php echo $TPL_VAR["searchDate"]?>" onclick="new Calendar().show(this);">
				<input name="Submit4" class="btnStyle3" type="submit" value="??????">
			</div>
		</form>
	</div>
	<?php echo $htmlData;?>
</div>

<?php
	function balance_money($homeMoney, $awayMoney) {
		$returnVal = array();

		if ( $homeMoney > $awayMoney ) {
			$endHomeMoney = $homeMoney - ($homeMoney - $awayMoney);
			$endAwayMoney = $awayMoney;
		}	else if ( $homeMoney < $awayMoney ) {
			$endHomeMoney = $homeMoney;
			$endAwayMoney = $awayMoney - ($awayMoney - $homeMoney);
		} else {
			$endHomeMoney = $homeMoney;
			$endAwayMoney = $awayMoney;
		}

		$returnVal['homeMoney'] = $endHomeMoney;
		$returnVal['awayMoney'] = $endAwayMoney;
		return $returnVal;
	}

	function hit_money($homeMoney, $awayMoney) {
		$returnVal = array();

		if ( $homeMoney > $awayMoney ) {
			$endHomeMoney = $homeMoney - $awayMoney;
			$endAwayMoney = 0;
		}	else if ( $homeMoney < $awayMoney ) {
			$endHomeMoney = 0;
			$endAwayMoney = $awayMoney - $homeMoney;
		} else {
			$endHomeMoney = 0;
			$endAwayMoney = 0;
		}

		$returnVal['homeMoney'] = $endHomeMoney;
		$returnVal['awayMoney'] = $endAwayMoney;
		return $returnVal;
	}
?>