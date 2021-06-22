<?php /* Template_ 2.2.3 2014/10/22 20:18:04 D:\www_one-23.com\m.vhost.user\_template\content\betting_list.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script language="javascript" src="/scripts/Calendar.js"></script>
<script>
	function cancel_bet(url)
	{
		if(confirm("정말 취소하시겠습니까?")) {document.location = url;}
		else{return;}
	}
	
	function hide_bet(url)
	{
		if(confirm("정말 안보이게 하시겠습니까?  ")) {document.location = url;}
		else{return;}
	}
	
	function hide_all_betting()
	{
		if(confirm("정말 삭제하시겠습니까?"))
		{
			document.frm_hide_all.submit();
		}
	}
	function on_upload(bettings) {
		if ( !bettings ) {
			var bettings="";
			$("[name=upload_checkbox]").each( function(index) {
				if(this.checked) {
					var betting_no = this.value;
					bettings += betting_no;
					bettings += ";";
				}
			});
		}
		document.location.href="/board/write?bettings="+bettings;
	}
</script>

	<div id="sub_menu" style="margin-bottom:0px;">
		<ul>
			<li class="sub_menu_1_o"><a href="/race/betting_list" class="sub_menu_1_o_text">배팅내역</a></li>
			<li class="sub_menu_1"><a href="javascript:alert('실시간 라이브축구는 PC버전을 이용해주세요.^^');" class="sub_menu_1_text">축구라이브</a></li>
			<li>
		<form name="frm_hide_all" method="post" action="/race/hide_all_betting">
			<input type="hidden" name="sort_type" value="<?php echo $TPL_VAR["sort_type"]?>">
			<input type="hidden" name="betting_list" value="<?php echo $TPL_VAR["hide_list"]?>">
		</form>
				<p class="board_writh_bt_box" style="padding-top:5px; padding-right:7px;">
<?php if(count((array)$TPL_VAR["list"])>0){?>
					<a href="#none" class="bt_writh_1" onClick="hide_all_betting();" style="width: 100px;">전체 내역 삭제</a>
<?php }?>
				</p>
			</li>
		</ul>
	</div>




<?php
	if($TPL_list_1){
		foreach($TPL_VAR["list"] as $TPL_K1=>$TPL_V1){
			$TPL_item_2=empty($TPL_V1["item"])||!is_array($TPL_V1["item"])?0:count($TPL_V1["item"]);
?>
            <div class="my_bet_league" style="padding-top:8px;">
                <ul>
                    <li class="my_bet_league_day" style="width:75%;"><span style="color:#EDD200;">배팅시간</span> <?php echo $TPL_V1["bet_date"]?></li>
                    <li class="my_bet_league_name" style="width:5%;">&nbsp;</li>
                </ul>
            </div>
<?php
	if($TPL_item_2){
		foreach($TPL_V1["item"] as $TPL_V2){
			//if ( $TPL_V2["home_rate"] < 1.1 and $TPL_V2["draw_rate"] < 1.1 and $TPL_V2["away_rate"] < 1.1  ) {
            //modified in 20170517...
            if ( $TPL_V2["home_rate"] < 1.01 and $TPL_V2["draw_rate"] < 1.1 and $TPL_V2["away_rate"] < 1.1  ) {
				$battingJT = "1";
			} else {
				$battingJT = "0";
			}

			if ( $TPL_V2["result"] == 4 ) {
				$TPL_V2["home_rate"] = "1.00";
				$TPL_V2["away_rate"] = "1.00";
			}
?>
            <div class="my_bet_game_data">
                <div style="float:left; width:95%; text-align: left; color:#47C83E;">
                    <?php echo $TPL_V2["league_name"]?>&nbsp;&nbsp;&nbsp;<?php echo substr($TPL_V2["gameDate"],5,5)?> <?php echo $TPL_V2["gameHour"]?>:<?php echo $TPL_V2["gameTime"]?>
                </div>
<?php

    //appended in 20170517
    $homeName = $TPL_V2["home_team"];
    if(strpos($homeName, '★ 3폴더 이상만') === false)
    {
        //appended in 20170516....
        if(strpos($homeName, '★ 5폴더 이상만') === false)
        {

        }
        else
        {
            $homeName = "★5폴더이상가능★";
        }
    }
    else
    {
        $homeName = "★3폴더이상가능★";
    }

	if ( $TPL_V2["select_no"] == 1 ) {
?>
                <div class="my_bet_home_over_box">
					<span class="my_bet_home_over" <?php if($TPL_V2["win"]==1){echo "style=\"border:#CF1855 1px solid;\"";}?>>
						<span class="my_bet_home_o">
							<?php echo $homeName?> <?php if($TPL_V2["game_type"]==4){?>▲<?php }?>
						</span>
						<span class="my_bet_home_odd_o"><?php echo $TPL_V2["home_rate"]+0?></span>
					</span>
                </div>
<?php
	} else {
?>
                <div class="my_bet_home_box">
					<span class="my_bet_home" <?php if($TPL_V2["win"]==1){echo "style=\"border:#CF1855 1px solid;\"";}?>>
						<span class="my_bet_home_n">
							<?php echo $homeName?> <?php if($TPL_V2["game_type"]==4){?>▲<?php }?>
						</span>
						<span class="my_bet_home_odd_n"><?php echo $TPL_V2["home_rate"]+0?></span>
					</span>
                </div>
<?php
	}
?>

                <div <?php if($TPL_V2["select_no"]==3){?>class="my_bet_odd_over_box"<?php }else{?>class="my_bet_odd_box"<?php }?>>
					<span <?php if($TPL_V2["select_no"]==3){?>class="my_bet_odd_over"<?php }else{?>class="my_bet_odd"<?php }?> <?php if($TPL_V2["win"]==3){echo "style=\"border:#CF1855 1px solid;\"";}?>>

<?php
	if(($TPL_V2["game_type"]==1&&($TPL_V2["draw_rate"]=="1.00"||$TPL_V2["draw_rate"]=="1"))||($TPL_V2["game_type"]==2&&$TPL_V2["draw_rate"]=="0")){
		echo "<span class=\"my_bet_odd_n\"><b>VS</b></span>";
	}else{
		if ( $TPL_V2["select_no"] == 3 ) echo "<span class=\"my_bet_odd_o\">";
		else echo "<span class=\"my_bet_odd_n\">";
		if($TPL_V2["game_type"]==1){
			echo number_format($TPL_V2["draw_rate"],2);
		}else{
			echo $TPL_V2["draw_rate"]+0;
		}
		echo "</span>";
	}
?>
					</span>
                </div>
<?php
	if ( $TPL_V2["select_no"] == 2 ) {
?>  
		            <div class="my_bet_away_over_box">
                        <span class="my_bet_away_over" <?php if($TPL_V2["win"]==2){echo "style=\"border:#CF1855 1px solid;\"";}?>>
													<span class="my_bet_away_o"><?php if($TPL_V2["game_type"]==4){?>▼<?php }?> <?php echo $TPL_V2["away_team"]?></span><span class="my_bet_away_odd_o"><?php echo $TPL_V2["away_rate"]+0?></span>
                        </span>
                </div>
<?php
	} else {
?>
		            <div class="my_bet_away_box">
                        <span class="my_bet_away" <?php if($TPL_V2["win"]==2){echo "style=\"border:#CF1855 1px solid;\"";}?>>
							<span class="my_bet_away_n"><?php if($TPL_V2["game_type"]==4){?>▼<?php }?> <?php echo $TPL_V2["away_team"]?></span><span class="my_bet_away_odd_n"><?php echo $TPL_V2["away_rate"]+0?></span>
                        </span>
                </div>
<?php
	}
?>
                <div class="my_bet_score">
					<?php if($TPL_V2["home_score"]==""){?>-<?php }else{?><?php echo $TPL_V2["home_score"]?>:<?php echo $TPL_V2["away_score"]?><?php }?><br>
<?php
	if ( $battingJT ) echo "<font color='#41AF39'>적특</font>";
	else if ( $TPL_V2["result"] == 1 ) echo "<font color='#fff44b'>적중</font>";
	else if ( $TPL_V2["result"] == 2 ) echo "<font color='#fa1313'>낙첨</font>";
	else if ( $TPL_V2["result"] == 4 ) echo "<font color='#41AF39'>적특</font>";	
	else echo "<font color='#ffffff'>대기</font>";
?>
                </div>
            </div>
<?php
		}
	}
?>
            <div class="my_bet_game_result_head">
                <ul>
                    <li class="my_bet_game_result_head_box">베팅금액: <span style="color:#EDD200;"><?php echo number_format($TPL_V1["betting_money"])?>원</span></li>
                    <li class="my_bet_game_result_head_box">배당률: <span style="color:#EDD200;"><?php echo $TPL_V1["result_rate"]+0?></span></li>
										<li class="my_bet_game_result_head_box" style="clear:both;">당첨예상: <span style="color:#EDD200;"><?php echo number_format(abs($TPL_V1["betting_money"]*$TPL_V1["result_rate"]))?>원</span></li>
                    <li class="my_bet_game_result_head_box"><?php if($TPL_V1["result"]==1){?>당첨금: <span style="color:#0BC904;"><?php echo number_format($TPL_V1["win_money"])?>원</span><?php }?></li>
										<li style="float:right; width:18%; text-align:right; margin-top:-15px; padding-right:18px;">
<?php 
	if($TPL_V1["result"]==0){
		echo "<span class=\"my_bet_league_result_text\">진행중</span>";
	}elseif($TPL_V1["result"]==2){
		echo "<span class=\"my_bet_league_result_text_x\">낙첨</span>";
	}elseif($TPL_V1["result"]==4){
		echo "<span class=\"my_bet_league_result_text_c\">적특</span>";
	}else{
		echo "<span class=\"my_bet_league_result_text_o\">적중</span>";
	}
?>
										</li>
                </ul>
            </div>
            <div class="my_bet_game_result_foot">
                <ul>
                    <li class="my_bet_game_result_foot_l">&nbsp;</li>
                    <li class="my_bet_game_result_foot_r">
											<a href="javascript:void();" onClick="on_upload('<?php echo $TPL_K1?>');" class="bt_my_bet_bottom">글쓰기</a>&nbsp;
											<?php	if ( $TPL_V1["result"] != 0 ) { ?>
												<a href="javascript:void();" onClick="hide_bet('/race/betlisthideProcess?betting_no=<?php echo $TPL_K1?>')" class="bt_my_bet_del">삭제</a>
											<?php } if ( $TPL_V1["cancel_enable"] == 1 ) {?>
												<a href="javascript:void();" onClick="cancel_bet('/race/cancelProcess?betting_no=<?php echo $TPL_K1?>&betting_time=<?php echo $TPL_V1["regdate"]?>')" class="bt_my_bet_del">배팅취소</a>
											<?php } ?>
										</li>
                </ul>
            </div>
<?php
		}
	}
?>

		<div class="wrap_page">
			<?php echo $TPL_VAR["pagelist"]?>
		</div>