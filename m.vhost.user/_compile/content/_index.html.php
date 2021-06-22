<style style="text/css">
body {
  background-image: url("/images/side_bg.jpg?v05");
  background-position: 50% 50%;
  background-repeat: no-repeat;
  background-attachment:fixed;
	background-position:center;
	background-size:cover;
	-moz-background-size:100% 100%;
}

.game_box {
	width:76px;
	padding:0px 0px 0px 0px;
	background: -moz-linear-gradient(top,  rgba(254,254,254,0.3) 0%, rgba(0,0,0,0.0) 100%); /* FF3.6-15 */
	background: -webkit-linear-gradient(top,  rgba(254,254,254,0.3) 0%,rgba(0,0,0,0.0) 100%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom,  rgba(254,254,254,0.3) 0%,rgba(0,0,0,0.0) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cc333333', endColorstr='#cc000000',GradientType=0 ); /* IE6-9 */
	float:left;
	cursor:pointer;
	margin-right:8px;
	margin-top:4px;
	border:0px solid #000;
}

.game_box:hover {
	opacity:0.4;
}
</style>

<div class="main_menu">
                <ul>
                    <li class="game_box">
                        <a href="/game_list?game=multi"><img src="images/menu_22.png?v05"  width=76px; height=76px;>
                        </a>
                    </li>
                    <li class="game_box">
                        <a href="/game_list?game=special"><img src="images/menu_2.png?v05" width=76px; height=76px;>
                        </a>
                    </li>
                    <li class="game_box">
                        <a href="/game_list?game=real"><img src="images/menu_21.png?v05" width=76px; height=76px;>
                        </a>
                    </li>
                    <li class="game_box">
                        <a href="/game_list?game=live"><img src="images/menu_24.png?v06" width=76px; height=76px;>
                        </a>
                    </li>
                    <li class="game_box">
                        <a href="/game_list?game=vfootball"><img src="images/menu_4.png?v05" width=76px; height=76px;>
                        </a>
                    </li>
                    <li class="game_box">
                        <a href="/game_list?game=sadari"><img src="images/menu_5.png?v05" width=76px; height=76px;>
                        </a>
                    </li>
                    <li class="game_box">
                        <a href="/game_list?game=dari"><img src="images/menu_dari.png?v05" width=76px; height=76px;>
                        </a>
                    </li>
                    <li class="game_box">
            <a href="/game_list?game=race"><img src="images/menu_6.png?v05" width=76px; height=76px;>
            </a>
        </li>
        <li class="game_box">
            <a href="/game_list?game=power"><img src="images/menu_7.png?v05" width=76px; height=76px;>
            </a>
        </li>
        <li class="game_box">
            <a href="/game_list?game=fx&min=1"><img src="images/menu_23.png?v06" width=76px; height=76px;>
            </a>
        </li>
		<!--<li class="game_box">
            <a href="/game_list?game=mgmoddeven"><img src="images/menu_mgmoddeven.png?v05" width=76px; height=76px;>
            </a>
        </li>
        <li class="game_box">
            <a href="/game_list?game=mgmbacara"><img src="images/menu_mgmbacara.png?v05" width=76px; height=76px;>
            </a>
        </li>-->
		<li class="game_box">
            <a href="/game_list?game=2dari"><img src="images/menu_2dari.png?v05" width=76px; height=76px;>
            </a>
        </li>
		<li class="game_box">
            <a href="/game_list?game=3dari"><img src="images/menu_3dari.png?v05" width=76px; height=76px;>
            </a>
        </li>
        <!--<li class="game_box">
            <a href="/game_list?game=lowhi"><img src="images/menu_lowhi.png?v05" width=76px; height=76px;>
            </a>
        </li>
        <li class="game_box">
            <a href="/game_list?game=aladin"><img src="images/menu_aladin.png?v05" width=76px; height=76px;>
            </a>
        </li>-->
        <li class="game_box">
            <a href="/game_list?game=kenosadari"><img src="images/menu_kenosadari.png?v05" width=76px; height=76px;>
            </a>
        </li>
        <li class="game_box">
            <a href="/game_list?game=psadari"><img src="images/menu_powersadari.png?v05" width=76px; height=76px;>
            </a>
        </li>
		<!--<li class="game_box">
            <a href="/game_list?game=nine"><img src="images/menu_nine.png?v05" width=76px; height=76px;>
            </a>
        </li>-->
        <li class="game_box">
            <a href="/game_list?game=choice"><img src="images/menu_choice.png?v05" width=76px; height=76px;>
            </a>
        </li>
		<li class="game_box">
            <a href="/game_list?game=roulette"><img src="images/menu_roulette.png?v05" width=76px; height=76px;>
            </a>
        </li>
		<li class="game_box">
            <a href="/game_list?game=pharaoh"><img src="images/menu_pharaoh.png?v05" width=76px; height=76px;>
            </a>
        </li>
    </ul>
</div>
</div>
            <?php
            if ( is_array($TPL_VAR["popup_list"]) && count($TPL_VAR["popup_list"]) > 0 ) {
                foreach ( $TPL_VAR["popup_list"] as $TPL_V1 ) {
                    $checkCookie = "popup_".$TPL_V1["IDX"];
                    if ( !$_COOKIE[$checkCookie] ) {
                        ?>
                        <div id="<?php echo $checkCookie?>" style="position:absolute; top:0px; left:0px; width:100%; z-index:100000; background-color: #000000;">
                            <div style="background-image: url('<?php echo $TPL_V1["P_FILE"];?>'); background-size:100% 100%; background-repeat: no-repeat; background-position: center center; padding:0px 0px 0px 0px;z-index:99999999; background-color: #000000;">
                                <div style="height:<?php echo $TPL_V1["P_WIN_HEIGHT"]-10?>px;">
                                    <?php echo $TPL_V1["P_CONTENT"]?><br>
                                </div>
                            </div>
                            <div style="text-align:center; font-size:12px;padding:0px 0 10px 0; background-color: #000000;">
                                <input type="checkbox" name="popupCookie" onclick="setCookie('popup_'+<?php echo $TPL_V1["IDX"]?>,'done',1); $('#<?php echo $checkCookie?>').hide();">
                                하루 동안 이 팝업을 보이지 않음. &nbsp;&nbsp;
                                <a href="#" onClick="$('#<?php echo $checkCookie?>').hide();"><span>[닫기]</span></a>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
            ?>

            <script>
                $(document).ready(function(){
                    var maxSize = 0;
                    $("div[id^=popup_]").each(function(index){
                        var heightSize = Number($(this).css('height').replace('px',''));
                        if ( heightSize > maxSize ) maxSize = heightSize;
                    });
                    $("div[id^=popup_]").css('height',maxSize+'px');
                });
            </script>