<?php
	$TPL_category_list_1=empty($TPL_VAR["category_list"])||!is_array($TPL_VAR["category_list"])?0:count($TPL_VAR["category_list"]);
	$TPL_league_list_1=empty($TPL_VAR["league_list"])||!is_array($TPL_VAR["league_list"])?0:count($TPL_VAR["league_list"]);
	$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);

	//-> 현재 진행중인 회차/날짜/배팅가능시간 정보를 가져옴.
	function getLastGameInfo($btGameName) {
		$yyyy = date("Y");
		$mm = date("m");
		$dd = date("d");
		$hour = date("H");
		$min = date("i");
		$sec = date("s");

		if ( $btGameName == "sadari" ) {
			$secTemp = (($hour * 60) * 60) + ($min * 60) + $sec;
			$gameTh = floor($secTemp / 300) + 1;
			$limitSec = ($gameTh * 300) - $secTemp;
		} else if ( $btGameName == "dari" ) {
			$secTemp = (($hour * 60) * 60) + ($min * 60) + $sec;
			$gameTh = floor($secTemp / 180) + 1;
			$limitSec = ($gameTh * 180) - $secTemp;
		} else if ( $btGameName == "race" ) {
			$secTemp = (($hour * 60) * 60) + ($min * 60) + $sec;
			$gameTh = floor($secTemp / 300) + 1;
			$limitSec = ($gameTh * 300) - $secTemp;
		} else if ( $btGameName == "powerball" ) {
            $powerStartTime = "1293883470";
			$gameTh = floor((time() - $powerStartTime) / 300);
			$limitSec = $powerStartTime + (($gameTh+1) * 300) - time();
		}

		$gameYmd = date("Y-m-d",time()+$limitSec);
		$gameH = date("H",time()+$limitSec);
		$gameI = date("i",time()+$limitSec);
		$gameS = date("s",time()+$limitSec);

		if ( ($btGameName == "sadari" or $btGameName == "race") and $gameTh == "288" ) {
			$gameYmd = date("Y-m-d",time()-300);
			$gameH = "23";
			$gameI = "59";
		} else if ( $btGameName == "dari" and $gameTh == "480" ) {
			$gameYmd = date("Y-m-d",time()-180);
			$gameH = "23";
			$gameI = "59";
		}

		if ( $btGameName == "powerball" ) $limitSec = $limitSec - 12;
		return array("gameTh"=>$gameTh,"gameYmd"=>$gameYmd,"gameH"=>$gameH,"gameI"=>$gameI,"gameS"=>$gameS,"limitSec"=>$limitSec);
	}

	if ( $TPL_VAR["view_type"] != "winlose" and $TPL_VAR["view_type"] != "handi" and $TPL_VAR["view_type"] != "special" and $TPL_VAR["view_type"] != "real" ) {
		$widthSize = "width:1160px;";
	}
    $widthSize = "width:1160px;";
?>
	<div class="mask"></div>
	<div id="container">
	
<script type="text/javascript">
    function MM_swapImgRestore() { //v3.0
    var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
    }
    function MM_preloadImages() { //v3.0
    var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
        var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
        if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
    }

    function MM_findObj(n, d) { //v4.01
    var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
        d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
    if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
    for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
    if(!x && d.getElementById) x=d.getElementById(n); return x;
    }

    function MM_swapImage() { //v3.0
    var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
    if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
    }
</script>
<script>
    var VarBoTable = "a10";
    var VarBoTable2 = "a25";
    var VarCaId = "전체";
    var VarColspan = "7";
    $j().ready(function(){
        path = '/ajax.list.php?bo_table=a10&ca=조합배팅&sca=전체&sfl=&stx=&b_type=2';
        init("" + g4_path + path);
        
        path2 = '/ajax.list.php?bo_table=a25&ca=조합배팅&sca=전체&sfl=&stx=';
        init2("" + g4_path + path2);
        //setInterval("init('"+g4_path+ path +"')", 30000);
    });
</script>
<script type="text/javascript" src="/10bet/js/left.js?1610345653"></script>
		
<!-- 컨텐츠 영역 -->
<div id="contents">
    <div class="board_box">
        <h2>경기결과</h2>
        <div class="result_btn">
            <h3>종목선택하기</h3>
            <ul>
                <li  class="<?=(!$TPL_VAR["view_type"] or $TPL_VAR["view_type"] == "winlose") ? 'on' : ''?>" onclick="location.href='/race/game_result?view_type=winlose'"><button>승무패</button></li>
                <li  class="<?=(!$TPL_VAR["view_type"] or $TPL_VAR["view_type"] == "handi") ? "on" : ""?>" onclick="location.href='/race/game_result?view_type=handi'"><button>핸디캡</button></li>
                <li  class="<?=(!$TPL_VAR["view_type"] or $TPL_VAR["view_type"] == "special") ? "on" : ""?>" onclick="location.href='/race/game_result?view_type=special'"><button>스페셜</button></li>
                <li  class="<?=(!$TPL_VAR["view_type"] or $TPL_VAR["view_type"] == "real") ? "on" : ""?>" onclick="location.href='/race/game_result?view_type=real'"><button>실시간</button></li>
                <li  class="<?=(!$TPL_VAR["view_type"] or $TPL_VAR["view_type"] == "live") ? "on" : ""?>" onclick="location.href='/race/game_result?view_type=live'"><button>라이브</button></li>
				<!--
                <li  class="<?=(!$TPL_VAR["view_type"] or $TPL_VAR["view_type"] == "sadari") ? "on" : ""?>" onclick="location.href='/race/game_result?view_type=sadari'"><button>사다리</button></li>
                <li  class="<?=(!$TPL_VAR["view_type"] or $TPL_VAR["view_type"] == "dari") ? "on" : ""?>" onclick="location.href='/race/game_result?view_type=dari'"><button>다리다리</button></li>
                <li  class="<?=(!$TPL_VAR["view_type"] or $TPL_VAR["view_type"] == "race") ? "on" : ""?>" onclick="location.href='/race/game_result?view_type=race'"><button>달팽이</button></li>
				-->
                <li  class="<?=(!$TPL_VAR["view_type"] or $TPL_VAR["view_type"] == "power") ? "on" : ""?>" onclick="location.href='/race/game_result?view_type=power'"><button>파워볼</button></li>
                <li  class="<?=(!$TPL_VAR["view_type"] or $TPL_VAR["view_type"] == "powersadari") ? "on" : ""?>" onclick="location.href='/race/game_result?view_type=powersadari'"><button>파워사다리</button></li>
                <li  class="<?=(!$TPL_VAR["view_type"] or $TPL_VAR["view_type"] == "kenosadari") ? "on" : ""?>" onclick="location.href='/race/game_result?view_type=kenosadari'"><button>키노사다리</button></li>
				<!--
                <li  class="<?=(!$TPL_VAR["view_type"] or $TPL_VAR["view_type"] == "vfootball") ? "on" : ""?>" onclick="location.href='/race/game_result?view_type=vfootball'"><button>가상축구</button></li>
                <li  class="<?=(!$TPL_VAR["view_type"] or $TPL_VAR["view_type"] == "mgmoddeven") ? "on" : ""?>" onclick="location.href='/race/game_result?view_type=mgmoddeven'"><button>MGM홀짝</button></li>
                <li  class="<?=(!$TPL_VAR["view_type"] or $TPL_VAR["view_type"] == "mgmbacara") ? "on" : ""?>" onclick="location.href=('/race/game_result?view_type=mgmbacara'"><button>MGM바카라</button></li>
                <li  class="<?=(!$TPL_VAR["view_type"] or $TPL_VAR["view_type"] == "aladin") ? "on" : ""?>" onclick="location.href='/race/game_result?view_type=aladin'"><button>알라딘</button></li>
                <li  class="<?=(!$TPL_VAR["view_type"] or $TPL_VAR["view_type"] == "lowhi") ? "on" : ""?>" onclick="location.href='/race/game_result?view_type=lowhi'"><button>로하이</button></li>
                <li  class="<?=(!$TPL_VAR["view_type"] or $TPL_VAR["view_type"] == "nine") ? "on" : ""?>" onclick="location.href='/race/game_result?view_type=nine'"><button>나인</button></li>
				-->
                <li  class="<?=(!$TPL_VAR["view_type"] or $TPL_VAR["view_type"] == "choice") ? "on" : ""?>" onclick="location.href='/race/game_result?view_type=choice'"><button>초이스</button></li>
                <li  class="<?=(!$TPL_VAR["view_type"] or $TPL_VAR["view_type"] == "roulette") ? "on" : ""?>" onclick="location.href='/race/game_result?view_type=roulette'"><button>롤렛</button></li>
                <li  class="<?=(!$TPL_VAR["view_type"] or $TPL_VAR["view_type"] == "pharaoh") ? "on" : ""?>" onclick="location.href='/race/game_result?view_type=pharaoh'"><button>파라오</button></li>
                <li  class="<?=(!$TPL_VAR["view_type"] or $TPL_VAR["view_type"] == "2dari") ? "on" : ""?>" onclick="location.href='/race/game_result?view_type=2dari'"><button>2다리</button></li>
                <li  class="<?=(!$TPL_VAR["view_type"] or $TPL_VAR["view_type"] == "3dari") ? "on" : ""?>" onclick="location.href='/race/game_result?view_type=3dari'"><button>3다리</button></li>
            </ul>
        </div>
    </div>
    <?php
    if ( $TPL_list_1 ) {
        foreach ( $TPL_VAR["list"] as $TPL_V1 ) {
            $TPL_item_2 = empty($TPL_V1["item"]) || !is_array($TPL_V1["item"]) ? 0 : count($TPL_V1["item"]);
            ?>
            <div class="result_section">
                <h4>
                    <?php
                        if( $TPL_V1["item"][0]["sport_name"] == "축구")
                            echo "<img src='/10bet/images/10bet/ico/football-ico.png' class='ico01' alt='ico' /> ";
                        else if( $TPL_V1["item"][0]["sport_name"] == "야구")
                            echo "<img src='/10bet/images/10bet/ico/baseball-ico.png' class='ico01' alt='ico' /> ";
                        else if( $TPL_V1["item"][0]["sport_name"] == "농구")
                            echo "<img src='/10bet/images/10bet/ico/basketball-ico.png' class='ico01' alt='ico' /> ";
                        else if( $TPL_V1["item"][0]["sport_name"] == "배구")
                            echo "<img src='/10bet/images/10bet/ico/volleyball-ico.png' class='ico01' alt='ico' /> ";
                        else if( $TPL_V1["item"][0]["sport_name"] == "하키")
                            echo "<img src='/10bet/images/10bet/ico/hockey-ico.png' class='ico01' alt='ico' /> ";
                        else if( $TPL_V1["item"][0]["sport_name"] == "테니스")
                            echo "<img src='/10bet/images/10bet/ico/tennis-ico.png' class='ico01' alt='ico' /> ";
                        else
                            echo "<img src='/images/ibet/sporticons_e.png' class='ico01' alt='ico' /> ";
                        
                        echo $TPL_V1["item"][0]["sport_name"];
                    ?>					
                    <img src="/10bet/images/10bet/arrow_01.png" class="arrow" alt="" /> 
                    <img src="<?php echo $TPL_V1["league_image"]?>" width="20" height="16" style="padding-top:3px;">
                    <?php echo $TPL_V1["item"][0]["alias_name"]?> 					
                </h4>
                <?php
                    if ( $TPL_item_2 ) {
                        foreach ( $TPL_V1["item"] as $TPL_V2 ) {
                            $strDay = date('w',strtotime($TPL_V2["gameDate"]));
                            switch ( $strDay ) {
                                case 0: $gameWeek = "[일]"; break;
                                case 1: $gameWeek = "[월]"; break;
                                case 2: $gameWeek = "[화]"; break;
                                case 3: $gameWeek = "[수]"; break;
                                case 4: $gameWeek = "[목]"; break;
                                case 5: $gameWeek = "[금]"; break;
                                case 6: $gameWeek = "[토]"; break;
                            }

                            //-> 팀명 경기종류 적용
                            if ( $TPL_V2["type"] == 4 ){
                                $homeTeamNameAdd = "&nbsp;<font class=\"gameType\">[오버]</font></font><span class=\"icon_up\">&nbsp;&nbsp;</span>";
                                $awayTeamNameAdd = "<span class=\"icon_down\">&nbsp;&nbsp;</span><font class=\"gameType\">[언더]</font>&nbsp;";
                            } else if ( $TPL_V2["type"] == 2 ) {
                                $homeTeamNameAdd = "&nbsp;<font class=\"gameType\">[H]</font>";
                                $awayTeamNameAdd = "<font class=\"gameType\">[H]</font>&nbsp;";
                            } else if ( $TPL_VAR["special_type"] == 0 && $TPL_V2["type"] == 1 ) {
                                $homeTeamNameAdd = "&nbsp;<font class=\"gameType\">[승무패]</font>";
                                $awayTeamNameAdd = "<font class=\"gameType\">[승무패]</font>&nbsp;";
                            } else {
                                unset($homeTeamNameAdd);
                                unset($awayTeamNameAdd);
                            }

                            $homeTeamName = $TPL_V2["home_team"].$homeTeamNameAdd;
                            $awayTeamName = $awayTeamNameAdd.$TPL_V2["away_team"];

                            $gameCode = $TPL_V2["game_code"];
                            $homeScore = $TPL_V2["home_score"];
                            //-> 달팽이 결과 예외처리 (스코어에 순서대로 1,2,3등이 들어있음)
                            if ( $gameCode == "r_1w2d3l" or $gameCode == "r_1w2w3l" ) {
                                $st1 = $homeScore[0]; //-> 1등
                                $st2 = $homeScore[1]; //-> 2등
                                $st3 = $homeScore[2]; //-> 3등
                                $TPL_V2["win"] = 0;
                            }

                            if ( $TPL_V2["win"] == 4 ) {
                                $TPL_V2["home_rate"] = "1.00";
                                $TPL_V2["away_rate"] = "1.00";
                            }
                ?>
                <ul>
                    <li>
                        <div class="time_arae">
                            <span><?php echo substr($TPL_V2["gameDate"],5,5)?> <?php echo $gameWeek;?></span>&nbsp;
                            <span><?php echo $TPL_V2["gameHour"]?>:<?php echo $TPL_V2["gameTime"]?></span>
                        </div>
                        <div class="bet_area">
                            <?php
                                if ( $TPL_V2["win"] == 1 or ($gameCode == "r_1w2d3l" and $st1 == 1) or ($gameCode == "r_1w2w3l" and ($st1 == 1 or $st2 == 1)) ) $homeClass = "on";
                                else $homeClass = "";
                            ?>
                            <div class="home <?=$homeClass;?>"><?php echo $homeTeamName?></div>
                            <?php
                                if ( $TPL_V2["win"] == 3 or ($gameCode == "r_1w2d3l" and $st1 == 2) or ($gameCode == "r_1w2w3l" and ($st1 == 2 or $st2 == 2)) ) $drawClass = "on";
                                else $drawClass = "";
                            ?>
                            <div class="vs <?=$drawClass;?>">
                            <?php
                                if ( ($TPL_V2["type"] == 1 && $TPL_V2["draw_rate"] == "1.00") || ($TPL_V2["type"] == 2 && $TPL_V2["draw_rate"] == "0") ){
                                    echo "VS";
                                } else {
                                    echo sprintf("%2.2f",$TPL_V2["draw_rate"]);
                                }
                            ?>
                            </div>
                            <?php
                                if ( $TPL_V2["win"] == 2 or ($gameCode == "r_1w2d3l" and $st1 == 3) or ($gameCode == "r_1w2w3l" and ($st1 == 3 or $st2 == 3)) ) $awayClass = "on";
                                else $awayClass = "";
                            ?>
                            <div class="away <?=$awayClass;?>"><?php echo $awayTeamName?></div>
                        </div>
                    </li>
                </ul>
                <?php 
                    }
                } ?>
            </div>
        <?php 
            }
        }
    ?>
    
    <table width=95% cellpadding=0 cellspacing=0>
        <tr class='ht' height='30'>
            <td align=center>
                <div class='page_skip'>&nbsp;
                <?php echo $TPL_VAR["pagelist"]?>
                </div>
            </td>
        </tr>
    </table>
</form>
	