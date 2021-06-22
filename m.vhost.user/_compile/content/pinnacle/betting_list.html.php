<?php /* Template_ 2.2.3 2014/10/07 20:43:49 D:\www_mos1\m.vhost.user\_template\content\pinnacle\betting_list.html */
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


<style type="text/css">
	<!--
	#smenu .bethistory a
	{background-color:#126c50;border:1px solid #11644a;}
	#smenu .bethistory a span
	{color:#ffdf1b;text-decoration:underline}
	-->
</style>

	<div id="subvisual" class="subvisual_bethistory">
		<h3><img src="/img/title_bethistory.gif"></h3>
	</div>

	<div id="subtab">
		<ul>
			<li><a href="/race/betting_list"><span>베팅내역</span></a></li>
			<li><a href="/LiveGame/betting_list"><span>라이브베팅내역</span></a></li>
			<li class="on"><a href="/PinnacleGame/betting_list"><span>해외베팅내역</span></a></li>
		</ul>
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
			<input type="text" id="end_date" name="end_date" readonly class="inputstyle_date"  onclick="new Calendar().show(this);" value="<?php echo $TPL_VAR["end_date"]?>">
			<a href="javascript:void();" onClick="submit();"><img src="/img/btn_search.gif" class="btnmargin"></a>
		  </p>
		</form>
	</div>
			
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_K1=>$TPL_V1){?>
		<div <?php if($TPL_V1["betting_result"]=="WIN"){?>class="wrapgame_win"<?php }else{?>class="wrapgame"<?php }?>>
		<h4>
<?php if($TPL_V1["betting_result"]=="-1"){?>진행중<?php }elseif($TPL_V1["betting_result"]=="LOS"){?><span class="lose">미적중</span><?php }elseif($TPL_V1["betting_result"]=="CANCEL"){?><span class="cancel">취소</span><?php }else{?><span class="WIN">☆적중☆</span><?php }?>
		</h4>
		<table width="100%" cellspacing="1" class="tablestyle_gamelist" id="bethistory">
			<thead>
				<tr>
					<th>경기시간</th>
					<th>경기유형</th>
					<th>리그명</th>
					<th class="home">홈(승)</th>
					<th class="draw">VS(무)</th>
					<th class="away">원정(패)</th>
					<th>결과</th>
					<th>상태</th>
				</tr>
			</thead>				
			<tbody>
				<tr>
					<td class="date" nowrap><?php echo $TPL_V1["start_time"]?></td>
					<td class="type">
<?php if($TPL_V1["template"]==1){?><span class="v">승무패<?php }elseif($TPL_V1["template"]==2){?><span class="hd">핸디캡<?php }elseif($TPL_V1["template"]==4){?><span class="uo">언더오버<?php }?></span>
					</td>
					<td class="league">
						<span><?php echo $TPL_V1["league_name"]?></span>
					</td>
				  <td valign="top" <?php if($TPL_V1["win"]=="1"&&$TPL_V1["betting_position"]=="1"){?>class="homewin"<?php }elseif($TPL_V1["win"]=="1"&&$TPL_V1["betting_position"]!="1"){?>class="homewin_nopick"<?php }elseif($TPL_V1["win"]!="1"&&$TPL_V1["betting_position"]==1){?>class="homepick"<?php }elseif($TPL_V1["win"]!=1&&$TPL_V1["betting_position"]!==1){?>class="home"<?php }elseif($TPL_V1["betting_position"]=="1"){?>class="homepick"<?php }?>>
					<span class="name"><?php echo $TPL_V1["home_team"]?><?php if($TPL_V1["template"]==4){?> <b>(u)</b><?php }?></span>
					<span class="rate" id="template_<?php echo $TPL_VAR["item"]["detail_sn"]?>_1"><?php echo $TPL_V1["home_rate"]?></span>
				  </td>
				  <td valign="top" <?php if($TPL_V1["win"]=="X"&&$TPL_V1["betting_position"]=="X"){?>class="drawwin"<?php }elseif($TPL_V1["win"]=="X"&&$TPL_V1["betting_position"]!="X"){?>class="drawwin_nopick"<?php }elseif($TPL_V1["win"]!=3&&$TPL_V1["betting_position"]=="X"){?>class="drawpick"<?php }elseif($TPL_V1["win"]!="X"&&$TPL_V1["betting_position"]!=="X"){?>class="draw"<?php }elseif($TPL_V1["betting_position"]=="X"){?>class="drawpick"<?php }?>>
<?php if(($TPL_VAR["item"]["game_type"]==1&&($TPL_V1["draw_rate"]=="1.00"||$TPL_V1["draw_rate"]=="1"))||($TPL_VAR["item"]["game_type"]==2&&$TPL_V1["draw_rate"]=="0")){?><span class="rate"><b>VS</b></span>
<?php }else{?>						  
						  <span class="rate"><?php if($TPL_VAR["item"]["game_type"]==1){?><?php echo number_format($TPL_V1["draw_rate"],2)?><?php }else{?><?php echo $TPL_V1["draw_rate"]?><?php }?></span>
<?php }?>
				  </td>
				  <td valign="top" <?php if($TPL_V1["win"]=="2"&&$TPL_V1["betting_position"]=="2"){?>class="awaywin"<?php }elseif($TPL_V1["win"]=="2"&&$TPL_V1["betting_position"]!="2"){?>class="awaywin_nopick"<?php }elseif($TPL_V1["win"]!="2"&&$TPL_V1["betting_position"]==2){?>class="awaypick"<?php }elseif($TPL_V1["win"]!=2&&$TPL_V1["betting_position"]!==2){?>class="away"<?php }elseif($TPL_V1["betting_position"]=="2"){?>class="awaypick"<?php }?>}>
					<span class="rate" id="template_<?php echo $TPL_VAR["item"]["detail_sn"]?>_2"><?php echo $TPL_V1["away_rate"]?><?php if($TPL_V1["away_rate_variation"]=="+"){?><span class='up'>&nbsp;</span><?php }elseif($TPL_V1["away_rate_variation"]=="-"){?><span class='down'>&nbsp;</span><?php }?></span>
					<span class="name"><?php if($TPL_V1["template"]==4){?><b>(o) </b><?php }?><?php echo $TPL_V1["away_team"]?></span>
				  </td>
					<td class="score"><?php echo $TPL_V1["home_score"]?>:<?php echo $TPL_V1["away_score"]?></td>
					<td class="result">
<?php if($TPL_V1["betting_result"]=='-1'){?>진행중
<?php }elseif($TPL_V1["betting_result"]=='WIN'){?><span class="win">당첨</span>
<?php }elseif($TPL_V1["betting_result"]=='LOS'){?><span class="lose">낙첨</span>
<?php }elseif($TPL_V1["betting_result"]=='CANCEL'){?><span class="cancel">취소</span>
<?php }else{?>베팅중
<?php }?>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="8" class="info">
						<span>당첨금 :<b><?php echo number_format($TPL_V1["prize"])?>원</b></span>
						<span>당첨구좌 :<b><?php if($TPL_V1["win_position"]=='1'){?><?php echo $TPL_V1["home_team"]?><?php }elseif($TPL_V1["win_position"]=='2'){?><?php echo $TPL_V1["away_team"]?><?php }elseif($TPL_V1["win_position"]=='X'){?>무승부<?php }elseif($TPL_V1["win_position"]=='-1'){?>진행중<?php }else{?><?php echo $TPL_V1["win_position"]?><?php }?></b></span>
						</p>
						<p class="btn">
							<!--<a href="/board/write?betting_no=<?php echo $TPL_K1?>"><img src="/img/game/btn_upbbs.gif"></a>-->
							<a href="#" onClick="hide_betting(<?php echo $TPL_V1["sn"]?>)"><img src="/img/btn_bethistory_delete.gif"></a>
							<!--<a href="#" onClick="cancel_bet('/race/cancelProcess?betting_no=<?php echo $TPL_K1?>&betting_time=<?php echo $TPL_V1["regdate"]?>')"><img src="/img/game/btn_cancel_bet.gif"></a>-->
						</p>
					</td>
				</tr>
			</tfoot>
		</table>
		</div>
<?php }}?>			

		<div class="wrap_page">
				<?php echo $TPL_VAR["pagelist"]?>

		</div>