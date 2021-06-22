	<!--<div class="header_information">
		<marquee scrollamount="5" onMouseOver='this.stop();' onMouseOut='this.start();'><font style="color:#ffcc00;"><?php /*echo $TPL_VAR["ad"]*/?></font></marquee>
	</div>

	<div class="navi_r">
<?php
/*	if ( $_SERVER["PHP_SELF"] == "/index.php" ) {
		echo "<img src=\"/images/top_menu_main2.png\" usemap=\"#Map\" border=\"0\" />";
	} else {
		echo "<img src=\"/images/top_menu_2.png\" usemap=\"#Map\" border=\"0\" />";
	}
*/?>
		<map name="Map" id="Map">
			  <area shape="rect" coords="17,5,83,41" href="/game_list?game=multi" alt="멀티조합" onfocus="blur();" />
				<area shape="rect" coords="96,5,157,41" href="/game_list?game=handi" alt="핸디캡" onfocus="blur();" />
				<area shape="rect" coords="174,5,223,38" href="/game_list?game=special" alt="스페셜" onfocus="blur();" />
				<area shape="rect" coords="234,8,295,39" href="/game_list?game=real" alt="실시간" onfocus="blur();" />
				<area shape="rect" coords="306,9,362,46" href="/game_list?game=sadari" alt="사다리" onfocus="blur();" />
                <area shape="rect" coords="387,8,454,37" href="/game_list?game=dari" alt="다리다리" onfocus="blur();" />
				<area shape="rect" coords="469,5,534,40" href="/game_list?game=race" alt="달팽이" onfocus="blur();"/>
				<area shape="rect" coords="553,2,607,39" href="/game_list?game=power" alt="파워볼" onfocus="blur();" />
				<area shape="rect" coords="621,3,710,42" href="/game_list?game=vfootball" alt="가상축구" onfocus="blur();" />
                <area shape="rect" coords="723,10,837,36" href="javascript:alert('서비스 준비중입니다.');" alt="가상개경주" onfocus="blur();" />
				<area shape="rect" coords="850,1,915,42" href="/race/game_result" alt="경기결과" onfocus="blur();" />
				<area shape="rect" coords="932,3,1001,41" href="/race/betting_list" alt="배팅내역" onfocus="blur();" />
				<area shape="rect" coords="1021,4,1092,41" href="/board/" alt="자유게시판" onfocus="blur();" />
				<area shape="rect" coords="1104,1,1172,40" href="/cs/cs_list" alt="1:1문의" onfocus="blur();" />
		</map>
	</div>
</div>-->

<script>
	function onTopMenu(type) {
		$("#topMenu_"+type).show();
	}
	function onTopMenuClose(type) {
		$("#topMenu_"+type).hide();
	}
</script>

<?php
	$TPL_list_count=empty($TPL_VAR["betting_list"])||!is_array($TPL_VAR["betting_list"])?0:count($TPL_VAR["betting_list"]);
	$betting_money_total = 0;
	if($TPL_list_count){
		foreach ( $TPL_VAR["betting_list"] as $TPL_K1 => $TPL_V1 ) {
			$TPL_item_2=empty($TPL_V1["item"]) || !is_array($TPL_V1["item"]) ? 0 : count($TPL_V1["item"]);
			$firstJT_date = "";
			if ( $TPL_item_2 ) {
				if ( $TPL_V1["result"] == 0 )
					$betting_money_total = $betting_money_total + $TPL_V1["betting_money"];
			}
		}
	}
?>
<style>
	.banbox_mom{
    top: 172px;
    left: 149px;
    right: 153px;
    bottom: 0px;
    margin: auto;
}
</style>
<div class="header_information banbox_mom">
    <marquee scrollamount="5" onMouseOver='this.stop();' onMouseOut='this.start();'><font style="color:#FFFF8F;" size="3px;"><?php echo $TPL_VAR["ad"]?></font></marquee>
</div>
