<?php
	$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, target-densitydpi=medium-dpi">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no, address=no, email=no" />
	<title>배팅내역 첨부하기</title>
	<link rel="stylesheet" type="text/css" href="/css/layout.css?v04" />
	<link rel="stylesheet" type="text/css" href="/css/game.css?v04" />
	<link rel="stylesheet" type="text/css" href="/css/slide_menu.css?v04" />
	<link rel="stylesheet" type="text/css" href="/css/jquery.jscrollpane.css?v04">
	<script src="/js/jquery.min.js" type="text/javascript"></script>
	<script src="/js/jquery-ui-min.js" type="text/javascript"></script>
	<script src="/js/contact.js" type="text/javascript"></script>
	<script src="/js/custom.js" type="text/javascript"></script>
	<script src="/js/comma.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="/css/default.css?v04">
	<script language="javascript" src="/scripts/bet_m.js"></script>
	<script language="javascript" src="/scripts/javascript.js"></script>
	<script language="javascript" src="/scripts/jquery.js"></script>
	<script language="javascript" src="/scripts/jquery.mousewheel.js"></script>
	<script language="javascript" src="/scripts/jquery.jscrollpane.min.js"></script>
	<script language="javascript" src="/scripts/jquery.slides.js"></script>
	<script language="javascript" src="/scripts/script.js"></script>
	<script language="javascript" src="/scripts/member.js"></script>
	<script language="javascript" src="/scripts/live.js"></script>
	<script language="javascript" src="/scripts/live_betting.js"></script>
	<script>
		function on_upload()
		{
			var bettings = document.getElementsByName('check_upload');
			var param = '';
			for( i=0; i<bettings.length; ++i)
			{
				if( bettings[i].checked==true)
				{
					param +=bettings[ i].value;
					param +=';';
				}
			}
			window.opener.location.href = '/board/write?bettings='+param;
			self.close();
		}
	</script>

<body>
<?php
	if($TPL_list_1){
		foreach($TPL_VAR["list"] as $TPL_K1=>$TPL_V1){
			$TPL_item_2=empty($TPL_V1["item"])||!is_array($TPL_V1["item"])?0:count($TPL_V1["item"]);
?>
            <div class="my_bet_league" style="padding-top:3px;">
                <ul>
                    <li class="my_bet_league_day" style="width:75%;"><span style="color:#EDD200;">배팅시간</span> <?php echo $TPL_V1["bet_date"]?></li>
                    <li class="my_bet_league_name" style="width:5%;">&nbsp;</li>
                </ul>
            </div>
<?php
	if($TPL_item_2){
		foreach($TPL_V1["item"] as $TPL_V2){
?>
            <div class="my_bet_game_data">
<?php
	if ( $TPL_V2["select_no"] == 1 ) {
?>
                <div class="my_bet_home_over_box">
					<span class="my_bet_home_over">
						<span class="my_bet_home_o"><?php echo $TPL_V2["home_team"]?> <?php if($TPL_V2["game_type"]==4){?>▲<?php }?></span><span class="my_bet_home_odd_o"><?php echo $TPL_V2["home_rate"]+0?></span>
					</span>
                </div>
<?php
	} else {
?>
                <div class="my_bet_home_box">
					<span class="my_bet_home">
						<span class="my_bet_home_n"><?php echo $TPL_V2["home_team"]?> <?php if($TPL_V2["game_type"]==4){?>▲<?php }?></span><span class="my_bet_home_odd_n"><?php echo $TPL_V2["home_rate"]+0?></span>
					</span>
                </div>
<?php
	}
?>

                <div <?php if($TPL_V2["select_no"]==3){?>class="my_bet_odd_over_box"<?php }else{?>class="my_bet_odd_box"<?php }?>>
					<span <?php if($TPL_V2["select_no"]==3){?>class="my_bet_odd"<?php }else{?>class="my_bet_odd"<?php }?> style="text-align:center;">

<?php
	if(($TPL_V2["game_type"]==1&&($TPL_V2["draw_rate"]=="1.00"||$TPL_V2["draw_rate"]=="1"))||($TPL_V2["game_type"]==2&&$TPL_V2["draw_rate"]=="0")){
		echo "<span class=\"my_bet_odd_n\"><b>VS</b></span>";
	}else{
		echo "<span class=\"my_bet_odd_n\">";
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
					<span class="my_bet_away_over">
						<span class="my_bet_away_o"><?php if($TPL_V2["game_type"]==4){?>▼<?php }?> <?php echo $TPL_V2["away_team"]?></span><span class="my_bet_away_odd_o"><?php echo $TPL_V2["away_rate"]+0?></span>
					</span>
                </div>
<?php
	} else {
?>
				<div class="my_bet_away_box">
					<span class="my_bet_away">
						<span class="my_bet_away_n"><?php if($TPL_V2["game_type"]==4){?>▼<?php }?> <?php echo $TPL_V2["away_team"]?></span><span class="my_bet_away_odd_n"><?php echo $TPL_V2["away_rate"]+0?></span>
					</span>
                </div>
<?php
	}
?>
                <div class="my_bet_score"><?php if($TPL_V2["home_score"]==""){?>-<?php }else{?><?php echo $TPL_V2["home_score"]?>:<?php echo $TPL_V2["away_score"]?><?php }?></div>
            </div>
<?php
		}
	}
?>
            <div class="my_bet_game_result_head">
                <ul>
                    <li class="my_bet_game_result_head_box">베팅금액: <span style="color:#EDD200;"><?php echo number_format($TPL_V1["betting_money"])?>원</span></li>
                    <li class="my_bet_game_result_head_box">배당: <span style="color:#EDD200;"><?php echo $TPL_V1["result_rate"]+0?></span></li>
                    <li class="my_bet_game_result_head_box">당첨예상금: <span style="color:#EDD200;"><?php echo number_format(abs($TPL_V1["betting_money"]*$TPL_V1["result_rate"]))?>원</span></li>
                    <li class="my_bet_game_result_head_box"><?php if($TPL_V1["result"]==1){?>당첨금: <span style="color:#0BC904;"><?php echo number_format($TPL_V1["win_money"])?>원</span><?php }?></li>
										<li style="float:right; width:18%; text-align:right; margin-top:-7px; padding-right:10px;">
<?php 
	if($TPL_V1["result"]==0){
		echo "<span class=\"my_bet_league_result_text\">진행중</span>";
	}elseif($TPL_V1["result"]==2){
		echo "<span class=\"my_bet_league_result_text_x\">미적중</span>";
	}elseif($TPL_V1["result"]==4){
		echo "<span class=\"my_bet_league_result_text_c\">취소</span>";
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
											<input type="checkbox" name="check_upload" value="<?php echo $TPL_K1?>">&nbsp;
											<a href="javascript:void();" onClick="on_upload()" class="bt_my_bet_del" style="background-color:#1266FF;border:#5AAEFF 1px solid;"><span style="color:#fff">게시판업로드</span></a>
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
