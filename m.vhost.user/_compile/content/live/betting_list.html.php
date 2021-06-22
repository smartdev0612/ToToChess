<?php /* Template_ 2.2.3 2014/10/22 20:27:46 D:\www_one-23.com\m.vhost.user\_template\content\live\betting_list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script language="javascript" src="/scripts/Calendar.js"></script>
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

	<div id="sub_menu">
		<ul>
			<li class="sub_menu_1"><a href="/race/betting_list" class="sub_menu_1_text">배팅내역</a></li>
			<li class="sub_menu_1_o"><a href="/LiveGame/betting_list" class="sub_menu_1_o_text">라이브베팅내역</a></li>
		</ul>
	</div>


	<div id="subtab">
		<form name="frm_hide_all" method="post" action="/race/hide_all_betting">
			<input type="hidden" name="sort_type" value="<?php echo $TPL_VAR["sort_type"]?>">
			<input type="hidden" name="betting_list" value="<?php echo $TPL_VAR["hide_list"]?>">
		</form>
<?php if(count((array)$TPL_VAR["list"])>0){?>
		<p class="wrap_btn"><a href="javascript:void()" onClick="hide_all_betting();"><img src="/img/btn_delete_history.gif"></a></p>
<?php }?>
	</div>

		<div class="gamesort">
			<label>정렬설정</label>
			<form name="frm_filter" method="post" act=?>
				<input type="hidden" name="act">
				<input type="hidden" name="betting_sn">
				<p>
					<input type="radio" name="filter" <?php if($TPL_VAR["filter"]=='-1'){?>  checked<?php }?> value="-1" class="radio" onClick="document.frm_filter.submit();">전체
					<input type="radio" name="filter" <?php if($TPL_VAR["filter"]=='PLAY'){?>  checked<?php }?> value="PLAY" class="radio" onClick="document.frm_filter.submit();">경기중
					<input type="radio" name="filter" <?php if($TPL_VAR["filter"]=='WIN'){?> checked<?php }?> value="WIN" class="radio" onClick="document.frm_filter.submit();">당첨
					<input type="radio" name="filter" <?php if($TPL_VAR["filter"]=='LOS'){?> checked<?php }?> value="LOS" class="radio" onClick="document.frm_filter.submit();">낙첨
				</p>
				<p>
				<input type="text" id="begin_date" name="begin_date" class="inputstyle_date" readonly onclick="new Calendar().show(this);" value="<?php echo $TPL_VAR["begin_date"]?>">&nbsp;~&nbsp;
				<input type="text" id="end_date" name="end_date" readonly class="inputstyle_date" style="width:80px;" onclick="new Calendar().show(this);" value="<?php echo $TPL_VAR["end_date"]?>">
				<a href="javascript:void()" onClick="submit();"><img src="/img/btn_search.gif" class="btnmargin"></a>
			  </p>
			</form>
		</div>
		
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_K1=>$TPL_V1){?>
		<table width="100%" cellspacing="1" class="tablestyle_gamelist" id="bethistory_live">
			<thead>
				<tr>
					<td colspan="7" class="league"><img src='<?php echo $TPL_V1["league_image"]?>'><span><?php echo $TPL_V1["league_name"]?></span></td>
				</tr>
				<tr>
					<td colspan="7" class="game"><span><?php echo $TPL_V1["start_time"]?></span><?php echo $TPL_V1["home_team"]?> VS <?php echo $TPL_V1["away_team"]?></td>
				</tr>						
				<tr>
					<th>타입</th>
					<th class="livelist">선택베팅</th>
					<th>베팅금</th>
					<th>예상당첨금</th>
					<th>스코어</th>	
					<th>결과</th>						
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
					<td class="score"><?php echo $TPL_V1["score"]?></td>
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
							<span>당첨구좌 :<b><?php if($TPL_V1["win_position"]=='1'){?><?php echo $TPL_V1["home_team"]?><?php }elseif($TPL_V1["win_position"]=='2'){?><?php echo $TPL_V1["away_team"]?><?php }elseif($TPL_V1["win_position"]=='X'){?>무승부<?php }else{?><?php echo $TPL_V1["win_position"]?><?php }?></b></span>
						</p>
						<p class="btn">
							<!--<a href="/board/write?betting_no=<?php echo $TPL_K1?>"><img src="/img/game/btn_upbbs.gif"></a>-->
							<a href="javascript:void()" onClick="hide_betting(<?php echo $TPL_V1["sn"]?>)"><img src="/img/btn_bethistory_delete.gif"></a>
							<!--<a href="#" onClick="cancel_bet('/race/cancelProcess?betting_no=<?php echo $TPL_K1?>&betting_time=<?php echo $TPL_V1["regdate"]?>')"><img src="/img/game/btn_cancel_bet.gif"></a>-->
						</p>
					</td>
				</tr>
			</tfoot>
		</table>	
<?php }}?>			

		<div class="wrap_page">
			<?php echo $TPL_VAR["pagelist"]?>

		</div>