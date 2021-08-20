	<div class="mask"></div>
	<div id="container">

<script type="text/javascript" src="/10bet/js/left.js?1610338639"></script>
<!-- 컨텐츠 영역 -->
<div id="contents">
    <marquee scrollamount="3"><span style="line-height:normal; font-size:13px;"><?=$TPL_VAR["ads"]?></span></marquee>
    <!-- 메인 비쥬얼 -->
    <div class="main_visual hidden-xs" style="margin-top:10px;">
        <ul class="swiper-wrapper">
            <li class="swiper-slide bg01">
                <div class="box01">
                    <h3>스포츠
                        <strong>SPORTS</strong>
                    </h3>
                    <p>Maybe you want to make the match with your favorite <br/>
                        team even more exciting with a live bet. Maybe you dream of <br/>
                        the life changing jackpot. Or maybe you just want to have fun <br/>
                        for a couple of minutes. And yes, gambling is both fun and exciting. A
                    </p>
                    <?php 
                    if(count((array)$_SESSION['member']) > 0) { ?>
                    <button onClick="location.href='/game_list?game=multi'">PLAY NOW</button>
                    <?php } else { ?>
                    <button onClick="login_open();">PLAY NOW</button>
                    <?php } ?>
                </div>
            </li>
            <li class="swiper-slide bg02">
                <div class="box01">
                    <h3>카지노
                        <strong>CASINO</strong>
                    </h3>
                    <p>Maybe you want to make the match with your favorite <br/>
                        team even more exciting with a live bet. Maybe you dream of <br/>
                        the life changing jackpot. Or maybe you just want to have fun <br/>
                        for a couple of minutes. And yes, gambling is both fun and exciting. A
                    </p>
                    <?php 
                    if(count((array)$_SESSION['member']) > 0) { ?>
                    <button onClick="warning_popup('준비중입니다.');">PLAY NOW</button>
                    <?php } else { ?>
                    <button onClick="login_open();">PLAY NOW</button>
                    <?php } ?>
                </div>
            </li>
            <li class="swiper-slide bg03">
                <div class="box01">
                    <h3>실시간
                        <strong>REAL TIME</strong>
                    </h3>
                    <p>Maybe you want to make the match with your favorite <br/>
                        team even more exciting with a live bet. Maybe you dream of <br/>
                        the life changing jackpot. Or maybe you just want to have fun <br/>
                        for a couple of minutes. And yes, gambling is both fun and exciting. A
                    </p>
                    <?php 
                    if(count((array)$_SESSION['member']) > 0) { ?>
                    <button onClick="location.href='/game_list?game=live'">PLAY NOW</button>
                    <?php } else { ?>
                    <button onClick="login_open();">PLAY NOW</button>
                    <?php } ?>
                </div>
            </li>
            <li class="swiper-slide bg04">
                <div class="box01">
                    <h3>BET365
                        <strong>BET365</strong>
                    </h3>
                    <p>Maybe you want to make the match with your favorite <br/>
                        team even more exciting with a live bet. Maybe you dream of <br/>
                        the life changing jackpot. Or maybe you just want to have fun <br/>
                        for a couple of minutes. And yes, gambling is both fun and exciting. A
                    </p>
                    <?php 
                    if(count((array)$_SESSION['member']) > 0) { ?>
                    <button onClick="warning_popup('준비중입니다.');">PLAY NOW</button>
                    <?php } else { ?>
                    <button onClick="login_open();">PLAY NOW</button>
                    <?php } ?>
                </div>
            </li>
            <li class="swiper-slide bg05">
                <div class="box01">
                    <h3>미니게임
                        <strong>MINI GAME</strong>
                    </h3>
                    <p>Maybe you want to make the match with your favorite <br/>
                        team even more exciting with a live bet. Maybe you dream of <br/>
                        the life changing jackpot. Or maybe you just want to have fun <br/>
                        for a couple of minutes. And yes, gambling is both fun and exciting. A
                    </p>
                    <?php 
                    if(count((array)$_SESSION['member']) > 0) { ?>
                    <button onClick="location.href='/game_list?game=power'">PLAY NOW</button>
                    <?php } else { ?>
                    <button onClick="login_open();">PLAY NOW</button>
                    <?php } ?>
                </div>
            </li>
            <!-- <li class="swiper-slide bg06">
                <div class="box01">
                    <h3>그래프
                        <strong>GRAPH</strong>
                    </h3>
                    <p>Maybe you want to make the match with your favorite <br/>
                        team even more exciting with a live bet. Maybe you dream of <br/>
                        the life changing jackpot. Or maybe you just want to have fun <br/>
                        for a couple of minutes. And yes, gambling is both fun and exciting. A
                    </p>
                    <button onClick="location.href='/graph'">PLAY NOW</button>
                </div>
            </li> -->
            <li class="swiper-slide bg07">
                <div class="box01">
                    <h3>해외스포츠
                        <strong>SPORTS</strong>
                    </h3>
                    <p>Maybe you want to make the match with your favorite <br/>
                        team even more exciting with a live bet. Maybe you dream of <br/>
                        the life changing jackpot. Or maybe you just want to have fun <br/>
                        for a couple of minutes. And yes, gambling is both fun and exciting. A
                    </p>
                    <?php 
                    if(count((array)$_SESSION['member']) > 0) { ?>
                    <button onClick="location.href='/game_list?game=abroad'">PLAY NOW</button>
                    <?php } else { ?>
                    <button onClick="login_open();">PLAY NOW</button>
                    <?php } ?>
                </div>
            </li>
        </ul>
    <div class="swiper-pagination"></div>
</div>

    <link rel="stylesheet" type="text/css" href="/10bet/css/10bet/swiper.min.css" />
    <script type="text/javascript" src="/10bet/js/10bet/swiper.min.js"></script>
    <script>
        var swiper = new Swiper('.main_visual', {
            
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    </script>
			
    <!-- 스포츠 매치 -->
    <div class="main_sports">
        <section class="hidden-xs">
            <div class="head">
                <h3>스포츠 <span>Prematch</span></h3>
                <!-- <button onClick="location.href='/bbs/board.php?bo_table=a10&b_type=2'">전체보기</button> -->
            </div>
            <div class="box01">
                <?php
                if($TPL_VAR["league_game_list"] != null && count($TPL_VAR["league_game_list"]) > 0) {
                    foreach ( $TPL_VAR["league_game_list"] as $TPL_V1 ) {?>
                        <h4>
                        <?php
                        if( $TPL_V1["sport_name"] == "축구")
                            echo "<img src=\"/images/ibet/sporticons_f.png\" style=\"vertical-align:middle; height:20px;\">&nbsp";
                        else if( $TPL_V1["sport_name"] == "야구")
                            echo "<img src=\"/images/ibet/sporticons_b.png\" style=\"vertical-align:middle; height:20px;\">&nbsp";
                        else if( $TPL_V1["sport_name"] == "농구")
                            echo "<img src=\"/images/ibet/sporticons_bk.png\" style=\"vertical-align:middle; height:20px;\">&nbsp";
                        else if( $TPL_V1["sport_name"] == "배구")
                            echo "<img src=\"/images/ibet/sporticons_vb.png\" style=\"vertical-align:middle; height:20px;\">&nbsp";
                        else if( $TPL_V1["sport_name"] == "아이스 하키")
                            echo "<img src=\"/images/ibet/sporticons_ih.png\" style=\"vertical-align:middle; height:20px;\">&nbsp";
                        else if( $TPL_V1["sport_name"] == "테니스")
                            echo "<img src=\"/images/ibet/spo_2.png\" style=\"vertical-align:middle; height:20px;\">&nbsp";
                        else if( $TPL_V1["sport_name"] == "E스포츠")
                            echo '<img src="/10bet/images/10bet/ico/esport-ico.png" align="absmiddle" border="0" style="width:24px">&nbsp';
                        else
                            echo "<img src=\"/images/ibet/sporticons_e.png\" style=\"vertical-align:middle; height:20px;\">&nbsp";
                        ?>
                            <?php echo $TPL_V1['sport_name'] ."&nbsp;"?>			
                            <img src="/10bet/images/10bet/arrow_01.png" class="arrow" alt="" /> 
                            <img src="<?=$TPL_V1['lg_img']?>" width="20" height="16">&nbsp;&nbsp;
                            <?php echo $TPL_V1['league_name']?>		
                        </h4>
                        <ul>
                            <li>
                                <div class="time_arae"><?=$TPL_V1['gameDate']." ".$TPL_V1['gameHour'].":".$TPL_V1['gameTime']?></div>
                                <div class="bet_area">
                                    <div class="home"><?php echo $TPL_V1['home_team']?></div>
                                    <div class="vs">VS</div>
                                    <div class="away"><?php echo $TPL_V1['away_team']?></div>
                                </div>
                            </li>
                        </ul>
                    <?
                    }
                } ?>
            </div>
        </section>
        <section class="hidden-xs">
            <div class="head">
                <h3>스포츠 <span>Prematch</span></h3>
                <!-- <button onClick="location.href='/bbs/board.php?bo_table=a10&b_type=2'">전체보기</button> -->
            </div>
            <div class="box01">
                <?php
                if($TPL_VAR["league_game_list_multi"] != null && count($TPL_VAR["league_game_list_multi"]) > 0) {
                    foreach ( $TPL_VAR["league_game_list_multi"] as $TPL_V1 ) {?>
                        <h4>
                        <?php
                        if( $TPL_V1["sport_name"] == "축구")
                            echo "<img src=\"/images/ibet/sporticons_f.png\" style=\"vertical-align:middle; height:20px;\">&nbsp";
                        else if( $TPL_V1["sport_name"] == "야구")
                            echo "<img src=\"/images/ibet/sporticons_b.png\" style=\"vertical-align:middle; height:20px;\">&nbsp";
                        else if( $TPL_V1["sport_name"] == "농구")
                            echo "<img src=\"/images/ibet/sporticons_bk.png\" style=\"vertical-align:middle; height:20px;\">&nbsp";
                        else if( $TPL_V1["sport_name"] == "배구")
                            echo "<img src=\"/images/ibet/sporticons_vb.png\" style=\"vertical-align:middle; height:20px;\">&nbsp";
                        else if( $TPL_V1["sport_name"] == "아이스 하키")
                            echo "<img src=\"/images/ibet/sporticons_ih.png\" style=\"vertical-align:middle; height:20px;\">&nbsp";
                        else if( $TPL_V1["sport_name"] == "테니스")
                            echo "<img src=\"/images/ibet/spo_2.png\" style=\"vertical-align:middle; height:20px;\">&nbsp";
                        else if( $TPL_V1["sport_name"] == "E스포츠")
                            echo '<img src="/10bet/images/10bet/ico/esport-ico.png" align="absmiddle" border="0" style="width:24px">&nbsp';
                        else
                            echo "<img src=\"/images/ibet/sporticons_e.png\" style=\"vertical-align:middle; height:20px;\">&nbsp";
                        ?>
                            <?php echo $TPL_V1['sport_name'] ."&nbsp;"?>			
                            <img src="/10bet/images/10bet/arrow_01.png" class="arrow" alt="" /> 
                            <img src="<?=$TPL_V1['lg_img']?>" width="20" height="16">&nbsp;&nbsp;
                            <?php echo $TPL_V1['league_name']?>		
                        </h4>
                        <ul>
                            <li>
                                <div class="time_arae"><?=$TPL_V1['gameDate']." ".$TPL_V1['gameHour'].":".$TPL_V1['gameTime']?></div>
                                <div class="bet_area">
                                    <div class="home"><?php echo $TPL_V1['home_team']?></div>
                                    <div class="vs">VS</div>
                                    <div class="away"><?php echo $TPL_V1['away_team']?></div>
                                </div>
                            </li>
                        </ul>
                    <?
                    }
                } ?>
            </div>
        </section>
    </div>
                
    <!-- 미니게임 -->
    <div class="main_minigame">
        <ul>
            <li>
                <?php 
                if(count((array)$_SESSION['member']) > 0) { ?>
                <div class="box01 bg01" onClick="location.href='/game_list?game=multi'">
                <?php } else { ?>
                <div class="box01 bg01" onClick="login_open();">
                <?php } ?>
                    <h3>체스
                        <strong>국내형스포츠</strong>
                    </h3>
                    <div class="bottom01">국내형스포츠</div>
                </div>
            </li>
            <li>
                <?php 
                if(count((array)$_SESSION['member']) > 0) { ?>
                <div class="box01 bg05" onClick="location.href='/game_list?game=abroad'">
                <?php } else { ?>
                <div class="box01 bg05" onClick="login_open();">
                <?php } ?>
                    <h3>체스
                        <strong>유럽형스포츠</strong>
                    </h3>
                    <div class="bottom01">유럽형스포츠</div>
                </div>
            </li>
            <li>
                <?php 
                if(count((array)$_SESSION['member']) > 0) { ?>
                <div class="box01 bg02" onClick="location.href='/game_list?game=live'">
                <?php } else { ?>
                <div class="box01 bg02" onClick="login_open();">
                <?php } ?>
                    <h3>체스
                        <strong>라이브스포츠</strong>
                    </h3>
                    <div class="bottom01">라이브스포츠</div>
                </div>
            </li>
            <li>
                <?php 
                if(count((array)$_SESSION['member']) > 0) { ?>
                <div class="box01 bg06" onClick="location.href='/game_list?game=power'">
                <?php } else { ?>
                <div class="box01 bg06" onClick="login_open();">
                <?php } ?>
                    <h3>체스
                        <strong>미니게임</strong>
                    </h3>
                    <div class="bottom01">미니게임</div>
                </div>
            </li>
            <li class="hidden-sm">
                <?php 
                if(count((array)$_SESSION['member']) > 0) { ?>
                <div class="box01 bg03" onClick="warning_popup('준비중입니다.');">
                <?php } else { ?>
                <div class="box01 bg03" onClick="login_open();">
                <?php } ?>
                    <h3>체스
                        <strong>카지노</strong>
                    </h3>
                    <div class="bottom01">카지노</div>
                </div>
            </li>
            <li class="hidden-sm">
                <?php 
                if(count((array)$_SESSION['member']) > 0) { ?>
                <div class="box01 bg07" onClick="warning_popup('준비중입니다.');">
                <?php } else { ?>
                <div class="box01 bg07" onClick="login_open();">
                <?php } ?>
                    <h3>체스
                        <strong>슬롯머신</strong>
                    </h3>
                    <div class="bottom01">슬롯머신</div>
                </div>
            </li>
        </ul>
    </div>

</div>
