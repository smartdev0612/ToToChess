<?php 
	$TPL_league_keyword_list_1=empty($TPL_VAR["league_keyword_list"])||!is_array($TPL_VAR["league_keyword_list"])?0:count($TPL_VAR["league_keyword_list"]);
	$TPL_game_list_1=empty($TPL_VAR["game_list"])||!is_array($TPL_VAR["game_list"])?0:count($TPL_VAR["game_list"]);

    $gameType = $TPL_VAR["game_type"];
    $sportType = $TPL_VAR["sport_type"];
    $sport_setting = $TPL_VAR["sport_setting"];
?>
	<div class="mask"></div>
	<div id="container">
	
<script type="text/javascript" src="/10bet/skin/board/betting/js/script.js"></script>
<!--[if lte ie 8]>-->
<script type="text/javascript" src="/10bet/js/math.ie8.shim.min.js"></script>
<script type="text/javascript" src="/10bet/js/math.ie8.sham.min.js"></script>
<!--<![endif]-->
<script type="text/javascript" src="/10bet/js/math.min.js"></script>
<script>math.config({number: 'BigNumber'});</script>
<script type="text/javascript" src="/10bet/skin/board/betting/js/bet.js?1611805614"></script>
<script type="text/javascript" src="/10bet/skin/board/betting/js/float_layer.js?1611805614"></script>
<!--<link rel="stylesheet" href="../skin/board/betting/style.css" type="text/css">-->
<!-- 게시판 목록 시작 -->
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
<style>
    .ko_sports_game img {vertical-align:middle;}
    .display_none {display:none;}
    .title_area h4 {width:160px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;}
</style>
<div id="contents">
    <!-- 스포츠 컨텐츠 상단 -->
    <div class="sports_head" style="height:215px !important;">
        <div class="menu_list2" style="height:215px !important;">
            <ul class="list01">
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == '' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>'" >ALL</button></li>
            </ul>
            <ul class="list02">
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'soccer' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&sport=soccer'"><img src="/10bet/images/10bet/ico/football-ico.png" alt="축구" /></button></li>
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'basketball' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&sport=basketball'"><img src="/10bet/images/10bet/ico/basketball-ico.png" alt="농구" /></button></li>
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'baseball' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&sport=baseball'"><img src="/10bet/images/10bet/ico/baseball-ico.png" alt="야구" /></button></li>
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'hockey' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&sport=hockey'"><img src="/10bet/images/10bet/ico/hockey-ico.png" alt="아이스하키" /></button></li>
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'tennis' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&sport=tennis'"><img src="/10bet/images/10bet/ico/tennis-ico.png" alt="테니스" /></button></li>
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'handball' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&sport=handball'"><img src="/10bet/images/10bet/ico/handball-ico.png" alt="핸드볼" /></button></li>
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'mortor' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&sport=mortor'"><img src="/10bet/images/10bet/ico/motor-sport-ico.png" alt="모터 스포츠" /></button></li>
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'rugby' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&sport=rugby'"><img src="/10bet/images/10bet/ico/rugby-league-ico.png" alt="럭비" /></button></li>
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'speedway' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&sport=speedway'"><img src="/10bet/images/10bet/ico/speedway-ico.png" alt="크리켓" /></button></li>
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'darts' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&sport=darts'"><img src="/10bet/images/10bet/ico/darts-ico.png" alt="다트" /></button></li>
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'volleyball' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&sport=volleyball'"><img src="/10bet/images/10bet/ico/volleyball-ico.png" alt="배구" /></button></li>
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'futsal' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&sport=futsal'"><img src="/10bet/images/10bet/ico/futsal-ico.png" alt="풋살" /></button></li>
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'tabletennis' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&sport=tabletennis'"><img src="/10bet/images/10bet/ico/tabletennis-ico.png" alt="배드민톤" /></button></li>
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'esports' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&sport=esports'"><img src="/10bet/images/10bet/ico/esport-ico.png" alt="이스포츠" /></button></li>
                <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'etc' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&sport=etc'">기타</button></li>
            </ul>
        </div>
    </div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
        <tr>
            <td valign="top">
                <table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0" align="left" style="position:relative;background-color:rgba(0,0,0,0.8);">
                    <tr>
                        <td valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center" valign="top">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" valign="top" >
                                                <!--<script>(function (d, sid) {if(!document.getElementById(sid)){var s = d.createElement('script');s.id=sid;s.src='https://live.statscore.com/livescorepro/generator';s.async=1;d.body.appendChild(s);}})(document, 'STATSCORE_LMP_GENERATOR_SCRIPT');
                                                </script>
                                                <div id="tracker-1" class="STATSCORE__Tracker" data-event="3172034" data-lang="ko" data-config="687" data-zone="" data-use-mapped-id="0"></div>
                                                <iframe id="game_stat" scrolling="no" frameborder="0" src="/10bet/game_info_iframe.php?game_id=0" width="100%" height="472" style="display:none;"></iframe>-->
                                                </td>
                                            </tr>
                                        </table>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" valign="top" >
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td valign="top" width="100%" height="500">
                                                            <!-- 헤더 -->
                                                                <!-- Body -->
                                                                <!--
                                                                <div id="tracker-1" class="STATSCORE__Tracker" data-event="3172034" data-lang="ko" data-config="687" data-zone="" data-use-mapped-id="0"></div> -->
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="" id="board_list2" " style="padding:18px;float:left;">
                                                                </table>
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="" id="board_list" " style="padding:18px;float:left;">
                                                                    <tr>
                                                                        <td>
                                                                            <div class="ko_sports_game j_5346_t">
                                                                                <h4>
                                                                                    <a name="target_5346"></a>
                                                                                    <img src="/images/10bet/ico/esport-ico.png" class="ico01">&nbsp;
                                                                                    <img src="/images/10bet/arrow_01.png" class="arrow" alt="">
                                                                                    <font class="league_name">
                                                                                        <img height="21" src="/data/banner/5346?1611815608"> 2021 LCK
                                                                                    </font>
                                                                                    <span class="time">01-28&nbsp;17:00</span>
                                                                                </h4>
                                                                                <ul>
                                                                                    <li class="li_border_x"></li>
                                                                                    <li id="num_5091632">
                                                                                        <div class="type01 1">승무패</div>
                                                                                        <div class="bet_area">
                                                                                            <div class="home menuOff" onclick="check_bet(5091632, '1')" id="chk_5091632_1">
                                                                                                <font class="team_name"> DragonX</font> 
                                                                                                <span class="bed">2.00</span>
                                                                                            </div>&nbsp;<div class="draw menuOff" onclick="check_bet(5091632, '3')" id="chk_5091632_3">VS</div>&nbsp;
                                                                                            <div class="away menuOff" onclick="check_bet(5091632, '2')" id="chk_5091632_2">
                                                                                                <font class="team_name"> KT Rolster</font> 
                                                                                                <span class="bed">1.70</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </li>
                                                                                </ul>
                                                                                <ul>
                                                                                    <li id="num_5091633">
                                                                                        <div class="type01 0">핸디캡</div>
                                                                                        <div class="bet_area">
                                                                                            <div class="home menuOff" onclick="check_bet(5091633, '1')" id="chk_5091633_1">
                                                                                                <font class="team_name"><font style="color:#ffa604">[H]</font> DragonX</font> 
                                                                                                <span class="bed">1.25</span>
                                                                                            </div>&nbsp;<div class="draw menuOff" onclick="check_bet(5091633, '3')" id="chk_5091633_3">
                                                                                                <font color="">1.5</font></div>&nbsp;<div class="away menuOff" onclick="check_bet(5091633, '2')" id="chk_5091633_2">
                                                                                                <font class="team_name"><font style="color:#ffa604">[H]</font> KT Rolster</font> 
                                                                                            <span class="bed">2.45</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <div style="text-align:center;"> </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- 게시판 목록 끝 -->
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </td>
            </tr>
        </table>
                                </td>
                                </tr>
                            </table>
                            </form>
                                        
                                        </td>
                                        
                                        </tr>
                                        
                                    </table>
                                        </td>
                                        </td>
                                    </tr>
                                    </table>

<script type="text/javascript" src="/scripts/bet/sport.js?v=<?=time();?>"></script>
<script language=javascript>
	$j(document).ready(function() {
		initialize(<?php echo $TPL_VAR["minBetCount"]?>,
			<?php echo $TPL_VAR["folderBonus"]["bonus3"]?>,
			<?php echo $TPL_VAR["folderBonus"]["bonus4"]?>,
			<?php echo $TPL_VAR["folderBonus"]["bonus5"]?>,
			<?php echo $TPL_VAR["folderBonus"]["bonus6"]?>,
			<?php echo $TPL_VAR["folderBonus"]["bonus7"]?>,
			<?php echo $TPL_VAR["folderBonus"]["bonus8"]?>,
			<?php echo $TPL_VAR["folderBonus"]["bonus9"]?>,
			<?php echo $TPL_VAR["folderBonus"]["bonus10"]?>,
			<?php echo $TPL_VAR["singleMaxBetMoney"]?>);
	});
				
	var VarMoney 		= '<?php echo $TPL_VAR["cash"]?>';
	var VarMinBet 		= '<?php echo $TPL_VAR["betMinMoney"]?>';
	var VarMaxBet 		= '<?php echo $TPL_VAR["betMaxMoney"]?>';
	var VarMaxAmount 	= '<?php echo $TPL_VAR["maxBonus"]?>';
	
      var bettingendtime =<?php echo $TPL_VAR["betEndTime"]?>;
      var bettingcanceltime =<?php echo $TPL_VAR["betCancelTime"]?>;
      var bettingcancelbeforetime =<?php echo $TPL_VAR["betCancelBeforeTime"]?>;
    var game_kind = "<?php echo $gameType?>";

    function inArray(needle, haystack) {
        var length = haystack.length;
        for(var i = 0; i < length; i++) {
            if(haystack[i] == needle) return true;
        }
        return false;
    }

    /*
     * $game_index 	: game identify id
     * $index		: checkbox index-start from 0
    */
    function onTeamSelected($game_index, $index, $special_type)
    {
        //-> 글로벌 페이지 타입 저장.
        page_special_type = $special_type;

        $sport_name = $j("#"+$game_index+"_sport_name").val();
        $game_type 	= $j("#"+$game_index+"_game_type").val();
        $home_team 	= $j("#"+$game_index+"_home_team").val();
        $home_rate 	= $j("#"+$game_index+"_home_rate").val();
        $draw_rate 	= $j("#"+$game_index+"_draw_rate").val();
        $away_team 	= $j("#"+$game_index+"_away_team").val();
        $away_rate 	= $j("#"+$game_index+"_away_rate").val();
        $sub_sn 	= $j("#"+$game_index+"_sub_sn").val();
        $game_date 	= $j("#"+$game_index+"_game_date").val();
        $league_sn = $j("#"+$game_index+"_league_sn").val();
        $is_specified_special = $j("#"+$game_index+"_is_specified_special").val();

        if($index<0 || $index>2)
            return;

        if($index==1 && ($draw_rate=='1' || $draw_rate=='1.0' || $draw_rate=='1.00' || $draw_rate=='VS'))
            return;

        //-> 보너스 선택시 (2폴더 이상시만 가능)
        if ( $home_team.indexOf("보너스") > -1 ) {
            if(folder_bonus($home_team) =="0"){
                return;
            }
        }

        if($game_type!=1 && $game_type!=2 && $game_type!=4)
        {
            warning_popup("올바른 배팅이 아닙니다.");
            return;
        }

        $sport_array = ["축구", "야구", "농구", "배구", "하키"];

        <?php
        $kind = '';
        if($gameType == 'multi')
        {
            $kind = 'cross';
        } else if($gameType == 'handi') {
            $kind = 'handi';
        } else if($gameType == 'special') {
            $kind = 'special';
        } else if($gameType == 'real') {
            $kind = 'real';
        }
        ?>

        if( (<?=$sport_setting[$kind.'_soccer_wl_over']?> == 1 && $sport_name == '축구') ||
            (<?=$sport_setting[$kind.'_baseball_wl_over']?> == 1 && $sport_name == '야구') ||
            (<?=$sport_setting[$kind.'_basketball_wl_over']?> == 1 && $sport_name == '농구') ||
            (<?=$sport_setting[$kind.'_volleyball_wl_over']?> == 1 && $sport_name == '배구') ||
            (<?=$sport_setting[$kind.'_hockey_wl_over']?> == 1 && $sport_name == '하키') ||
            (<?=$sport_setting[$kind.'_etc_wl_over']?> == 1 && inArray($sport_name, $sport_array) == false)
        )
        {
            if(!CheckRule_wl_over($game_index, $index, $game_type, $home_team, $away_team))
            {
                warning_popup("동일경기("+$sport_name+") [승패]+[오버] 조합은 배팅 불가능합니다.");
                return;
            }
        }

        if( (<?=$sport_setting[$kind.'_soccer_wl_under']?> == 1 && $sport_name == '축구') ||
            (<?=$sport_setting[$kind.'_baseball_wl_under']?> == 1 && $sport_name == '야구') ||
            (<?=$sport_setting[$kind.'_basketball_wl_under']?> == 1 && $sport_name == '농구') ||
            (<?=$sport_setting[$kind.'_volleyball_wl_under']?> == 1 && $sport_name == '배구') ||
            (<?=$sport_setting[$kind.'_hockey_wl_under']?> == 1 && $sport_name == '하키') ||
            (<?=$sport_setting[$kind.'_etc_wl_under']?> == 1 && inArray($sport_name, $sport_array) == false)
        )
        {
            if (!CheckRule_wl_under($game_index, $index, $game_type, $home_team, $away_team)) {
                warning_popup("동일경기("+$sport_name+") [승패]+[언더]  조합은 배팅 불가능합니다.");
                return;
            }
        }

        if( (<?=$sport_setting[$kind.'_soccer_d_over']?> == 1 && $sport_name == '축구') ||
            (<?=$sport_setting[$kind.'_baseball_d_over']?> == 1 && $sport_name == '야구') ||
            (<?=$sport_setting[$kind.'_basketball_d_over']?> == 1 && $sport_name == '농구') ||
            (<?=$sport_setting[$kind.'_volleyball_d_over']?> == 1 && $sport_name == '배구') ||
            (<?=$sport_setting[$kind.'_hockey_d_over']?> == 1 && $sport_name == '하키') ||
            (<?=$sport_setting[$kind.'_etc_d_over']?> == 1 && inArray($sport_name, $sport_array) == false)
        )
        {
            if (!CheckRule_d_over($game_index, $index, $game_type, $home_team, $away_team)) {
                warning_popup("동일경기("+$sport_name+") [무]+[오버]  조합은 배팅 불가능합니다.");
                return;
            }
	    }

        if( (<?=$sport_setting[$kind.'_soccer_d_under']?> == 1 && $sport_name == '축구') ||
            (<?=$sport_setting[$kind.'_baseball_d_under']?> == 1 && $sport_name == '야구') ||
            (<?=$sport_setting[$kind.'_basketball_d_under']?> == 1 && $sport_name == '농구') ||
            (<?=$sport_setting[$kind.'_volleyball_d_under']?> == 1 && $sport_name == '배구') ||
            (<?=$sport_setting[$kind.'_hockey_d_under']?> == 1 && $sport_name == '하키') ||
            (<?=$sport_setting[$kind.'_etc_d_under']?> == 1 && inArray($sport_name, $sport_array) == false)
            )
        {
            if (!CheckRule_d_under($game_index, $index, $game_type, $home_team, $away_team)) {
                warning_popup("동일경기("+$sport_name+") [무]+[언더]  조합은 배팅 불가능합니다.");
                return;
            }
        }

        if( (<?=$sport_setting[$kind.'_soccer_h_unov']?> == 1 && $sport_name == '축구') ||
            (<?=$sport_setting[$kind.'_baseball_h_unov']?> == 1 && $sport_name == '야구') ||
            (<?=$sport_setting[$kind.'_basketball_h_unov']?> == 1 && $sport_name == '농구') ||
            (<?=$sport_setting[$kind.'_volleyball_h_unov']?> == 1 && $sport_name == '배구') ||
            (<?=$sport_setting[$kind.'_hockey_h_unov']?> == 1 && $sport_name == '하키') ||
            (<?=$sport_setting[$kind.'_etc_h_unov']?> == 1 && inArray($sport_name, $sport_array) == false)
           )
        {
            if (!checkRule_handi_unov($game_index, $index, $game_type, $home_team, $away_team)) {
                warning_popup("동일경기("+$sport_name+") [핸디]+[언더/오버]  조합은 배팅 불가능합니다.");
                return;
            }
        }

        //승무패 이외에 무승부는 처리하지 않는다.
        if($game_type!=1 && $index==1)
            return;

        //선택한 Checkbox의 배당
        var selectedRate = '0';
        if(0==$index) 		selectedRate=$home_rate;
        else if(1==$index)	selectedRate=$draw_rate;
        else if(2==$index)	selectedRate=$away_rate;

        //토글
        var toggle_action = toggle($game_index+'_div', $index, selectedRate);
        //insert game
        if (toggle_action=='inserted')
        {
            /*
                    //-> 선택 총 배당이 500배를 넘을 수 없음.
                    if ( (Number(selectedRate) * Number(m_betList._bet)) > 500 ) {
                        warning_popup('MAX배당은 500배까지만 가능합니다.');
                        toggle_action = toggle($game_index+'_div', $index, selectedRate);
                        return;
                    }
            */
            var item = new Item($game_index, $home_team, $away_team, $index, selectedRate, $home_rate, $draw_rate, $away_rate, $game_type, $sub_sn, $is_specified_special, $game_date, $league_sn, $sport_name);
            m_betList.addItem(item);

            betcon=betcon.add_element($game_index+"|"+$index+"&"+$home_team+"  VS "+$away_team);
            var isdisabled = true;
        }
        //delete game
        else
        {
            m_betList.removeItem($game_index);
            betcon=betcon.del_element($game_index+"|"+$index+"&"+$home_team+"  VS "+$away_team);
            var isdisabled = false;
        }

        if($game_type=='1' || $game_type=='2')
        {
            $j('#form_'+$game_index+' input:checkbox').each( function(index) {
                if(0==index) { this.disabled = ($home_rate=='0')?true:isdisabled; }
                if(1==index) { this.disabled = ($draw_rate=='0')?true:isdisabled; }
                if(2==index) { this.disabled = ($away_rate=='0')?true:isdisabled; }
            });
        }

        /*
            if ( $special_type == 0 || $special_type == 1 || $special_type == 2 ) {
                if(!check_single_only($game_date))
                {
                    warning_popup("단폴더만 가능합니다.");
                    toggle_action = toggle($game_index+'_div', $index, selectedRate);
                    m_betList.removeItem($game_index);
                    betcon=betcon.del_element($game_index+"|"+$index+"&"+$home_team+"  VS "+$away_team);
                    var isdisabled = false;
                    return;
                }
            }
        */

        //-> 축구 -> 동일경기 [승무패-승]+[언더오버-오버] 조합은 배팅 체크
        /*	if( $sport_name == "축구" ) {
                if ( !checkRule_win_over() ) {
                    matchGameWinOver = 1;
                } else {
                    matchGameWinOver = 0;
                }
            }

            //-> 축구 -> 동일경기 [승무패-승]+[언더오버-언더] 조합은 배팅 체크
            if( $sport_name == "축구" ) {
                if ( !checkRule_win_under() ) {
                    matchGameWinUnder = 1;
                } else {
                    matchGameWinUnder = 0;
                }
            }

            //-> 축구 -> 동일경기 [승무패-패]+[언더오버-언더] 조합은 배팅 체크
            if( $sport_name == "축구" ) {
                if ( !checkRule_lose_under() ) {
                    matchGameLoseUnder = 1;
                } else {
                    matchGameLoseUnder = 0;
                }
            }

            //-> 축구 -> 동일경기 [승무패-패]+[언더오버-오버] 조합은 배팅 체크
            if( $sport_name == "축구" ) {
                if ( !checkRule_lose_over() ) {
                    matchGameLoseOver = 1;
                } else {
                    matchGameLoseOver = 0;
                }
            }
        */
        //-> 야구 -> 동일경기 "1이닝 득점" [승무패-승]+[언더오버-언더] 조합은 배팅 체크
        /*if( $sport_name == "야구" ) {
            if ( !checkRule_fb_win_under() ) {
                matchGameFbWinUnder = 1;
            } else {
                matchGameFbWinUnder = 0;
            }
        }*/

        //-> 야구 -> 동일경기 "1이닝 득점" [승무패-승]+[언더오버-오버] 조합은 배팅 체크
        /*if( $sport_name == "야구" ) {
            if ( !checkRule_fb_win_over() ) {
                matchGameFbWinOver = 1;
            } else {
                matchGameFbWinOver = 0;
            }
        }*/

        //-> 야구 -> 동일경기 "1이닝 무득점" [승무패-패]+[언더오버-언더] 조합은 배팅 체크
        /*if( $sport_name == "야구" ) {
            if ( !checkRule_fb_lose_under() ) {
                matchGameFbLoseUnder = 1;
            } else {
                matchGameFbLoseUnder = 0;
            }
        }*/

        //-> 야구 -> 동일경기 "1이닝 무득점" [승무패-패]+[언더오버-오버] 조합은 배팅 체크
        /*if( $sport_name == "야구" ) {
            if ( !checkRule_fb_lose_over() ) {
                matchGameFbLoseOver = 1;
            } else {
                matchGameFbLoseOver = 0;
            }
        }*/

        //-> 야구 -> 동일경기 [승패]+[언오버] 조합 체크
        /*if( $sport_name == "야구" ) {
            if ( !checkRule_winlose_unover() ) {
                matchGameFbWinloseUnover = 1;
            } else {
                matchGameFbWinloseUnover = 0;
            }
        }*/

        //-> 농구 첫3점슛+첫자유투 묶을수 없다.
        /*if( $sport_name == "농구" ) {
            if ( !checkRule_basketBall_a() ) {
                matchGameBbFtsFfs = 1;
            } else {
                matchGameBbFtsFfs = 0;
            }
        }*/

        bonus_del(); //시점 관련 버그
        calc();
    }
</script>