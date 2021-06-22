<?php
	$TPL_category_list_1=empty($TPL_VAR["category_list"])||!is_array($TPL_VAR["category_list"])?0:count($TPL_VAR["category_list"]);
	$TPL_league_list_1=empty($TPL_VAR["league_list"])||!is_array($TPL_VAR["league_list"])?0:count($TPL_VAR["league_list"]);
	$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
?>
	<div id="sub_menu_game_end" style="height:auto; margin-bottom:0px;">
		<ul>
			<li class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="winlose"){?>_o<?php }?>">
				<a href="/race/game_result?view_type=winlose" class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="winlose"){?>_o<?php }?>_text">멀티조합</a>
			</li>
			<li class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="special"){?>_o<?php }?>">
				<a href="/race/game_result?view_type=special" class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="special"){?>_o<?php }?>_text">스페셜</a>
			</li>
			<li class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="real"){?>_o<?php }?>">
				<a href="/race/game_result?view_type=real" class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="real"){?>_o<?php }?>_text">실시간</a>
			</li>
            <li class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="live"){?>_o<?php }?>">
                <a href="/race/game_result?view_type=live" class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="live"){?>_o<?php }?>_text">라이브</a>
            </li>
            <li class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="vfootball"){?>_o<?php }?>">
                <a href="/race/game_result?view_type=vfootball" class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="vfootball"){?>_o<?php }?>_text">가상축구</a>
            </li>
			<li class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="sadari"){?>_o<?php }?>">
				<a href="/race/game_result?view_type=sadari" class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="sadari"){?>_o<?php }?>_text">사다리</a>
				
			</li>
			<li class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="dari"){?>_o<?php }?>">
				<a href="/race/game_result?view_type=dari" class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="dari"){?>_o<?php }?>_text">다리다리</a>
			</li>
			<li class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="race"){?>_o<?php }?>">
				<a href="/race/game_result?view_type=race" class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="race"){?>_o<?php }?>_text">달팽이</a>
			</li>
			<li class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="power"){?>_o<?php }?>">
				<a href="/race/game_result?view_type=power" class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="power"){?>_o<?php }?>_text">파워볼</a>
			</li>
            <li class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="2dari"){?>_o<?php }?>">
                <a href="/race/game_result?view_type=2dari" class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="2dari"){?>_o<?php }?>_text">2다리</a>
            </li>
            <li class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="3dari"){?>_o<?php }?>">
                <a href="/race/game_result?view_type=3dari" class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="3dari"){?>_o<?php }?>_text">3다리</a>
            </li>
            <li class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="nine"){?>_o<?php }?>">
                <a href="/race/game_result?view_type=nine" class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="nine"){?>_o<?php }?>_text">나인</a>
            </li>
		</ul>
        <ul>
            <li class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="mgmoddeven"){?>_o<?php }?>">
                <a href="/race/game_result?view_type=mgmoddeven" class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="mgmoddeven"){?>_o<?php }?>_text">MGM홀짝</a>
            </li>
            <li class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="mgmbacara"){?>_o<?php }?>">
                <a href="/race/game_result?view_type=mgmbacara" class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="mgmbacara"){?>_o<?php }?>_text">MGM바카라</a>
            </li>
            <li class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="aladin"){?>_o<?php }?>">
                <a href="/race/game_result?view_type=aladin" class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="aladin"){?>_o<?php }?>_text">알라딘사다리</a>
            </li>
            <li class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="lowhi"){?>_o<?php }?>">
                <a href="/race/game_result?view_type=lowhi" class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="lowhi"){?>_o<?php }?>_text">로하이</a>
            </li>
            <li class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="powersadari"){?>_o<?php }?>">
                <a href="/race/game_result?view_type=powersadari" class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="powersadari"){?>_o<?php }?>_text">파워사다리</a>
            </li>
            <li class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="kenosadari"){?>_o<?php }?>">
                <a href="/race/game_result?view_type=kenosadari" class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="kenosadari"){?>_o<?php }?>_text">키노사다리</a>
            </li>
            <li class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="choice"){?>_o<?php }?>">
                <a href="/race/game_result?view_type=choice" class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="choice"){?>_o<?php }?>_text">초이스</a>
            </li>
            <li class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="roulette"){?>_o<?php }?>">
                <a href="/race/game_result?view_type=roulette" class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="roulette"){?>_o<?php }?>_text">룰렛</a>
            </li>
            <li class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="pharaoh"){?>_o<?php }?>">
                <a href="/race/game_result?view_type=pharaoh" class="sub_menu_game_end<?php if($TPL_VAR["view_type"]=="pharaoh"){?>_o<?php }?>_text">파라오</a>
            </li>
        </ul>
	</div>

<?php 
	if ( $TPL_list_1 ) { 
		foreach ( $TPL_VAR["list"] as $TPL_V1 ) {
			$TPL_item_2 = empty($TPL_V1["item"])||!is_array($TPL_V1["item"])?0:count($TPL_V1["item"]);
			if ( $TPL_item_2 ) {
				foreach ( $TPL_V1["item"] as $TPL_V2 ) {
					if ( $TPL_V2["win"] == 4 ) {
						$TPL_V2["home_rate"] = "1.00";
						$TPL_V2["away_rate"] = "1.00";
					}
?>
	<div class="league">
			<p class="league_text_3"><img src="<?php echo $TPL_V1["league_image"]?>" width="24" height="16"> <?php echo $TPL_V1["league_name"]?></p>
	</div>
	<div class="game_data_end">
			<div class="day"><?php echo substr($TPL_V2["gameDate"],5,5)?> <?php echo $TPL_V2["week"]?> <?php echo $TPL_V2["gameHour"]?>:<?php echo $TPL_V2["gameTime"]?></div>
			<div class="home_<?php if($TPL_V2["win"]==1){?>over_<?php }?>box_end">
				<span class="home_<?php if($TPL_V2["win"]==1){?>over_<?php }?>end">
					<span class="home_end_<?php if($TPL_V2["win"]==1){?>o<?php }else{?>n<?php }?>">
                        <?php
                        if(strpos($TPL_V2["home_team"], '★ 3폴더 이상만') === false)
                        {
                            //appended in 20170516....
                            if(strpos($TPL_V2["home_team"], '★ 5폴더 이상만') === false)
                            {
                                echo $TPL_V2["home_team"];
                            }
                            else
                            {
                                echo "★5폴더이상가능★";
                            }
                        }
                        else
                        {
                            echo "★3폴더이상가능★";
                        }

                        ?>
                        <?php if($TPL_V2["type"]==4){?>▲<?php }?></span><span class="home_end_odd_<?php if($TPL_V2["win"]==1){?>o<?php }else{?>n<?php }?>"><?php echo $TPL_V2["home_rate"]?></span>
				</span>
			</div>
			<div class="odd_<?php if($TPL_V2["win"]==3){?>over_<?php }?>box_end">
<?php if(($TPL_V2["type"]==1&&$TPL_V2["draw_rate"]=="1.00")||($TPL_V2["type"]==2&&$TPL_V2["draw_rate"]=="0")){?>
				<span class="odd_end odd_end_n">VS</span>
<?php }else{?>
				<span class="odd_<?php if($TPL_V2["win"]==3){?>over_<?php }?>end odd_end_<?php if($TPL_V2["win"]==3){?>o<?php }else{?>n<?php }?>"><?php echo $TPL_V2["draw_rate"]?></span>
<?php }?>
			</div>
			<div class="away_<?php if($TPL_V2["win"]==2){?>over_<?php }?>box_end">
				<span class="away_<?php if($TPL_V2["win"]==2){?>over_<?php }?>end">
					<span class="away_end_<?php if($TPL_V2["win"]==2){?>o<?php }else{?>n<?php }?>"><?php if($TPL_V2["type"]==4){?>▼<?php }?><?php echo $TPL_V2["away_team"]?></span><span class="away_end_odd_<?php if($TPL_V2["win"]==2){?>o<?php }else{?>n<?php }?>"><?php echo $TPL_V2["away_rate"]?></span>
				</span>
			</div>
			<div class="score">
<?php 
	if ( $TPL_V2["win"] == 1 ) echo "홈승";
	else if ( $TPL_V2["win"] == 2 ) echo "원정승";
	else if ( $TPL_V2["win"] == 3 ) echo "무승부";
	else if ( $TPL_V2["win"] == 4 ) echo "<span class=\"score_1\">적특</span>";
	else echo "진행중";
?>
					<p><?php echo $TPL_V2["home_score"]?>:<?php echo $TPL_V2["away_score"]?></p>
			</div>
	</div>
<?php
				}
			}
		}
	}
?>

	<div class="wrap_page">
		<?php echo $TPL_VAR["pagelist"];?>
	</div>