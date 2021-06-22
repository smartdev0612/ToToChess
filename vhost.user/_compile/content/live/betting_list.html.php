<?php
	$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
?>
<div id="contents_left" style="min-height:600px;">
<!--
	<div id="top_title">
		<div class="title_icon"><img src="/images/sub_menu_icon.png" alt=""/></div>
		<div class="title_text"><img src="/images/title_betting_end.png" alt=""/></div>
	</div>
-->
	<div class="game_end_sub_menu">
		<div class="game_end_sub_menu_1">
			<ul>
				<li><a href="/race/betting_list"><img src="/images/sub_betting_menu_over_1.png" alt="배팅내역"/></a></li>
				<li><a href="/LiveGame/betting_list"><img src="/images/sub_betting_menu_3.png" alt="파워볼배팅내역"/></a></li>
			</ul>
		</div>
	</div>


<?php 
	if($TPL_list_1){
		foreach($TPL_VAR["list"] as $TPL_K1=>$TPL_V1){
?>
		<table width="100%" cellspacing="1" class="tablestyle_gamelist" id="bethistory_live">
			<thead>
				<tr>
					<td colspan="7" class="league" style="height:20px; padding: 4px 0 4px 0;"><span style="height: 15px; padding:9px  10px 9px 13px;"><img src='<?php echo $TPL_V1["league_image"]?>' style="vertical-align:middle"></span><span style="width: 830px; padding: 8px 0 10px 0; font-weight: bold; color: #dfdfdf;"><?php echo $TPL_V1["league_name"]?></span></td>
				</tr>
				<tr>
					<td colspan="7" class="game" style="height: 15px; padding:3px  10px 3px 13px;"><span><?php echo $TPL_V1["start_time"]?></span><?php echo $TPL_V1["home_team"]?> VS <?php echo $TPL_V1["away_team"]?></td>
				</tr>						
				<tr id="live_result_table2">
					<td>타입</td>
					<td class="livelist">선택베팅</td>
					<td>베팅금</td>
					<td>예상당첨금</td>
					<td>스코어</td>	
					<td>결과</td>						
				</tr>
			</thead>					
			
			<tbody>
				<tr>
					<td class="type"><?php echo $TPL_V1["template_alias"]?></td>
					<td class="pick">
						<div><span class="name"><?php if($TPL_V1["betting_position"]=='1'){?><?php echo $TPL_V1["home_team"]?><?php }elseif($TPL_V1["betting_position"]=='2'){?><?php echo $TPL_V1["away_team"]?><?php }elseif($TPL_V1["betting_position"]=='X'){?>무승부<?php }else{?><?php echo $TPL_V1["betting_position"]?><?php }?></span><span class="rate"><?php echo $TPL_V1["odd"]?></span></div>
					</td>
					<td class="betmoney"><?php echo number_format($TPL_V1["betting_money"])?>원</td>
					<td class="winmoney"><?php echo number_format(bcmul($TPL_V1["betting_money"],$TPL_V1["odd"],0),0)?>원</td>
					<td class="score"><?php if ( $TPL_V1["score"] == -1 ) { echo ":"; } else { echo $TPL_V1["score"]; }?></td>
					<td class="result">
<?php if($TPL_V1["betting_result"]=='-1'){?>진행중
<?php }elseif($TPL_V1["betting_result"]=='WIN'){?><span class="win">적중</span>
<?php }elseif($TPL_V1["betting_result"]=='LOS'){?><span class="lose">미적중</span>
<?php }elseif($TPL_V1["betting_result"]=='CANCEL'){?><span class="cancel">취소</span>
<?php }else{?>베팅중
<?php }?>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="6" class="info">
						<p>
							<span>당첨금 :<b><?php echo number_format($TPL_V1["prize"])?>원</b></span>
							<span>당첨구좌 :<b><?php if($TPL_V1["win_position"]=='1'){?><?php echo $TPL_V1["home_team"]?><?php }elseif($TPL_V1["win_position"]=='2'){?><?php echo $TPL_V1["away_team"]?><?php }elseif($TPL_V1["win_position"]=='X'){?>무승부<?php }elseif($TPL_V1["win_position"]==-1){echo "진행중";}else{?><?php echo $TPL_V1["win_position"]?><?php }?></b></span>
							<span>배팅시간 :<b><?php echo $TPL_V1["reg_time"];?></b></span>
						</p>
						<p class="btn">
							<!--<a href="/board/write?betting_no=<?php echo $TPL_K1?>"><img src="/img/game/btn_upbbs.gif"></a>-->
<?php	if ( $TPL_V1["betting_result"] != -1 ) { ?>
							<a href="javascript:void()" onClick="hide_betting(<?php echo $TPL_V1["sn"]?>)"><img src="/img/btn_bethistory_delete.gif"></a>
<?php } ?>
							<!--<a href="#" onClick="cancel_bet('/race/cancelProcess?betting_no=<?php echo $TPL_K1?>&betting_time=<?php echo $TPL_V1["regdate"]?>')"><img src="/img/game/btn_cancel_bet.gif"></a>-->
						</p>
					</td>
				</tr>
				<tr><td colspan="6" style="height:13px; padding:0; background:#000;"></td></tr>		
			</tfoot>
		</table>	
<?php }}?>



	<div class="bbs_move_icon">
		<?php echo $TPL_VAR["pagelist"]?>
	</div>

</div> <!-- contents_left -->

<form name="frm_filter" method="post" act=?>
	<input type="hidden" name="act">
	<input type="hidden" name="betting_sn">
</form>

<script>
	function cancel_bet(url)
	{
		if(confirm("정말 취소하시겠습니까?")) {document.location = url;}
		else{return;}
	}
	
	function hide_betting(betting_sn)
	{
		if(confirm("정말 안보이게 하시겠습니까?  ")) {
			document.frm_filter.act.value = "hide_betting";
			document.frm_filter.betting_sn.value = betting_sn;
			document.frm_filter.submit();
		}
		else {
			return;
		}
	}
	
	function hide_all_betting()
	{
		if(confirm("정말 삭제하시겠습니까?"))
		{
			document.frm_hide_all.submit();
		}
	}
</script>