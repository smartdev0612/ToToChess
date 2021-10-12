<?php 
   // $TPL_league_keyword_list_1=empty($TPL_VAR["league_keyword_list"]) || !is_array($TPL_VAR["league_keyword_list"]) ? 0 : count($TPL_VAR["league_keyword_list"]);
   // $TPL_game_list_1=empty($TPL_VAR["game_list"]) || !is_array($TPL_VAR["game_list"]) ? 0 : count($TPL_VAR["game_list"]);
   
      $gameType = $TPL_VAR["game_type"];
      $sportType = $TPL_VAR["sport_type"];
      //$s_type = $TPL_VAR["s_type"];
      $sport_setting = $TPL_VAR["sport_setting"];
      
      $bonus_list = $TPL_VAR["bonus_list"];
   ?>
<div id="container">
<style>
    .ko_sports_game img {vertical-align:middle;}
    .ko_sports_game .bonus_ul {width:33%;display:inline-block;margin:0;}
    .ko_sports_game .bonus_div {width:100%; border-radius: 5px;}
    .bonus_item {width:99%;}
    .bonus_item.on {background-color: #ff0000 !important; border: 1px solid #ff0000 !important;} 
    .bonus_item:hover {background-color: #501a1a !important; border: 1px solid #ff0000 !important;} 
    .display_none {display:none;}
    .title_area h4 {width:160px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;}
    .icon_up {
        width: 9px;
        height: 10px;
        padding: 2px;
        margin: 0 2px 0 2px;
        background: url(/images/icon_up.gif) center 50% no-repeat !important;
    }
    .icon_down {
        width: 9px;
        height: 10px;
        padding: 2px;
        margin: 0 2px 0 2px;
        background: url(/images/icon_down.gif) center 50% no-repeat !important;
    }
    .search_main {
        float: left;
        padding-bottom: 15px;
        padding-left: 15px;
        position: relative;
        vertical-align: middle;
        width: 80%;
    }
    .row {
        margin-right: -15px;
        margin-left: -15px;
    }
    .search1 {
        width: 20%;
    }
    .fl {
        float: left;
    }
    .search_dd {
        background-color: #1e2024;
        border: solid 1px #111;
        border-radius: 2px;
        color: #e9e9e9;
        cursor: pointer;
        display: table;
        font-weight: bold;
        height: 42px;
        list-style: none;
        padding-left: 15px;
        position: relative;
        text-align: left;
        vertical-align: middle;
        width: 100%;
    }
    .search_dd_pointer {
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #26262a), color-stop(100%, #111111));
        background: -webkit-linear-gradient(top, #26262a 0%, #111111 100%);
        background: -o-linear-gradient(top, #26262a 0%, #111111 100%);
        background: -ms-linear-gradient(top, #26262a 0%, #111111 100%);
        background: linear-gradient(to bottom, #26262a 0%, #111111 100%);
        border-left: 1px solid #111;
        color: #e9e9e9;
        display: table-cell;
        height: 100%;
        right: -1px;
        text-align: center;
        vertical-align: middle;
        width: 45px;
    }
    .btn-primary-outline {
        background-color: transparent;
        border-color: transparent;
    }
    .sb_item {
        display: table;
        height: 40px;
        width: 100%;
    }
    .sb_item div {
        color: #e9e9e9;
        display: table-cell;
        text-align: left;
        vertical-align: middle;
    }
    .scrollable-menu {
        height: auto;
        max-height: 340px;
        overflow-x: hidden;
    }
    .dropdown-menu {
        padding: 0px;
    }
    .search_box {
        background-color: #1e2024;
        border: 1px solid #111;
        border-radius: 2px;
        margin-left: -1px;
        margin-top: 2px;
        width: 100%;
    }
    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
        display: none;
        float: left;
        min-width: 160px;
        padding: 5px 0;
        margin: 2px 0 0;
        font-size: 14px;
        text-align: left;
        list-style: none;
        background-color: #fff;
        -webkit-background-clip: padding-box;
        background-clip: padding-box;
        border: 1px solid #ccc;
        border: 1px solid rgba(0,0,0,.15);
        border-radius: 4px;
        -webkit-box-shadow: 0 6px 12px rgb(0 0 0 / 18%);
        box-shadow: 0 6px 12px rgb(0 0 0 / 18%);
    }
    .search4 {
        width: 25%;
    }
    .search2 {
        width: 25%;
    }
    .search3 {
        width: 30%;
    }
    .pl5 {
        padding-left: 5px;
    }
    .search_dd_input {
        background-color: #1e2024;
        border: solid 1px #111;
        border-radius: 2px;
        color: #e9e9e9;
        cursor: pointer;
        display: table;
        font-weight: bold;
        height: 42px;
        list-style: none;
        position: relative;
        text-align: left;
        vertical-align: middle;
        width: 100%;
    }
    .search_dd_icon {
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #26262a), color-stop(100%, #111111));
        background: -webkit-linear-gradient(top, #26262a 0%, #111111 100%);
        background: -o-linear-gradient(top, #26262a 0%, #111111 100%);
        background: -ms-linear-gradient(top, #26262a 0%, #111111 100%);
        background: linear-gradient(to bottom, #26262a 0%, #111111 100%);
        border-right: 1px solid #111;
        color: #e9e9e9;
        display: table-cell;
        height: 100%;
        left: -1px;
        text-align: center;
        vertical-align: middle;
        width: 45px;
    }
    .search_dd_input {
        background-color: #1e2024;
        border: solid 1px #111;
        border-radius: 2px;
        color: #e9e9e9;
        cursor: pointer;
        display: table;
        font-weight: bold;
        height: 42px;
        list-style: none;
        position: relative;
        text-align: left;
        vertical-align: middle;
        width: 100%;
    }
    .margin-left-175 {
        margin-left: 235px;
    }
    .toggle-width {
        width: 4% !important;
    }
    .toggle-icon {
        font-size: 32px; 
        cursor: pointer
    }
    .sport_title {
        position: absolute;
        color: #22b486;
        letter-spacing: -1px;
        padding-left: 15px;
        font-size: 1.6rem;
        font-weight: 600;
        line-height: 48px;
    }
    @media screen and (max-width: 900px) { 
        .ko_sports_game .bonus_ul {
            width:32.5%;
            display:inline-block;
            margin:0;
        }
        .search_main {
            display:none;
        } 
        .sports_head {
            height:55px !important;
        }
        .margin-left-175 {
            margin-left: 0px;
        }
        .area-width {
            width: 90% !important;
        }
        .toggle-width {
            width: 9% !important;
            padding-top: 14px;
        }
        .sport_title {
            display: none;
        }
        .sports_head .menu_list2 ul button {
            height: 40px;
        }
        .sports_head .menu_list2 .list02 li {
            width: 40px;
        }
    }
</style>
<div id="contents">
   <!-- 스포츠 컨텐츠 상단 -->
   <div class="sports_head">
      <!-- <div class="menu_list">
         <ul>
             <li><button class="button_type01 <?=($gameType == "multi" && $s_type == '1') ? 'on' : ''?>" onClick="location.href='/game_list?game=multi&s_type=1'">
                     <span>국내스포츠</span>
                 </button>
             </li>
             <li><button class="button_type01 <?=($gameType == "multi" && $s_type == '2') ? 'on' : ''?>" onClick="location.href='/game_list?game=multi&s_type=2'">
                     <span>해외스포츠</span>
                 </button>
             </li>
             <li><button class="button_type01 " onClick="location.href='/bbs/board.php?bo_table=a25'">
                     <span>라이브스포츠</span>
                 </button>
             </li>
             <li><button class="button_type01 " onClick="location.href='/bbs/board.php?bo_table=a10&b_type=3'">
                     <span>스포츠밸런스</span>
                 </button>
             </li>
         </ul>
         </div> -->
      <span class="sport_title">스포츠 (국내형)</span>
      <div class="menu_list2 margin-left-175">
         <ul class="list02">
            <li><button type="button" class="button_type01 btn_all <?=($TPL_VAR['sport_type'] == '' ) ? 'on' : ''; ?>" onClick="getClassicGameList('0')">ALL</button></li>
            <li><button type="button" class="button_type01 btn_soccer <?= $TPL_VAR['sport_type'] == 'soccer' ? 'on' : ''; ?>" onClick="getClassicGameList('0','soccer')"><img src="/10bet/images/10bet/ico/football-ico.png" alt="축구" /></button></li>
            <li><button type="button" class="button_type01 btn_basketball <?= $TPL_VAR['sport_type'] == 'basketball' ? 'on' : ''; ?>" onClick="getClassicGameList('0','basketball')"><img src="/10bet/images/10bet/ico/basketball-ico.png" alt="농구" /></button></li>
            <li><button type="button" class="button_type01 btn_baseball <?= $TPL_VAR['sport_type'] == 'baseball' ? 'on' : ''; ?>" onClick="getClassicGameList('0','baseball')"><img src="/10bet/images/10bet/ico/baseball-ico.png" alt="야구" /></button></li>
            <li><button type="button" class="button_type01 btn_hockey <?= $TPL_VAR['sport_type'] == 'hockey' ? 'on' : ''; ?>" onClick="getClassicGameList('0','hockey')"><img src="/10bet/images/10bet/ico/hockey-ico.png" alt="아이스 하키" /></button></li>
            <li><button type="button" class="button_type01 btn_volleyball <?= $TPL_VAR['sport_type'] == 'volleyball' ? 'on' : ''; ?>" onClick="getClassicGameList('0','volleyball')"><img src="/10bet/images/10bet/ico/volleyball-ico.png" alt="배구" /></button></li>
            <li><button type="button" class="button_type01 btn_esports <?= $TPL_VAR['sport_type'] == 'esports' ? 'on' : ''; ?>" onClick="getClassicGameList('0','esports')"><img src="/10bet/images/10bet/ico/esport-ico.png" alt="E스포츠" /></button></li>
            <!-- <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'tennis' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&s_type=<?=$s_type?>&sport=tennis'"><img src="/10bet/images/10bet/ico/tennis-ico.png" alt="테니스" /></button></li>
               <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'handball' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&s_type=<?=$s_type?>&sport=handball'"><img src="/10bet/images/10bet/ico/handball-ico.png" alt="핸드볼" /></button></li>
               <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'mortor' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&s_type=<?=$s_type?>&sport=mortor'"><img src="/10bet/images/10bet/ico/motor-sport-ico.png" alt="모터 스포츠" /></button></li>
               <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'rugby' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&s_type=<?=$s_type?>&sport=rugby'"><img src="/10bet/images/10bet/ico/rugby-league-ico.png" alt="럭비" /></button></li>
               <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'speedway' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&s_type=<?=$s_type?>&sport=speedway'"><img src="/10bet/images/10bet/ico/speedway-ico.png" alt="크리켓" /></button></li>
               <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'darts' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&s_type=<?=$s_type?>&sport=darts'"><img src="/10bet/images/10bet/ico/darts-ico.png" alt="다트" /></button></li>
               <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'futsal' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&s_type=<?=$s_type?>&sport=futsal'"><img src="/10bet/images/10bet/ico/futsal-ico.png" alt="풋살" /></button></li>
               <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'tabletennis' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&s_type=<?=$s_type?>&sport=tabletennis'"><img src="/10bet/images/10bet/ico/tabletennis-ico.png" alt="배드민톤" /></button></li>
               <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'esports' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&s_type=<?=$s_type?>&sport=esports'"><img src="/10bet/images/10bet/ico/esport-ico.png" alt="이스포츠" /></button></li>
               <li><button class="button_type01 <?= $TPL_VAR['sport_type'] == 'etc' ? 'on' : ''; ?>" onClick="location.href='/game_list?game=<?php echo $gameType;?>&s_type=<?=$s_type?>&sport=etc'">기타</button></li> -->
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
                                          <iframe id="game_stat" scrolling="no" frameborder="0" src="/10bet/10bet/game_info_iframe.php?game_id=0" width="100%" height="472" style="display:none;"></iframe>-->
                                    </td>
                                 </tr>
                              </table>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                 <tr>
                                    <td align="center" valign="top" >
                                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                             <td valign="top" width="100%" height="500">
                                                <div class="ko_sports_game bonus_div j_4099_t">
                                                   <?php
                                                      foreach ($bonus_list as $bonus) { ?>
                                                   <ul class="bonus_ul">
                                                      <li id="num_-3">
                                                         <div class="bet_area bonus_div" name="<?=$bonus["sn"]?>_div">
                                                            <div class="home" style="width:100%;"  onclick="onTeamSelected('<?=$bonus["sn"]?>','0','0','0')">
                                                               <div style="display:none">
                                                                    <input type="hidden" id="<?=$bonus["sn"]?>_sport_name" value="<?=$bonus["sport_name"]?>">
                                                                    <input type="hidden" id="<?=$bonus["sn"]?>_game_type" value="<?=$bonus["betting_type"]?>">
                                                                    <input type="hidden" id="<?=$bonus["sn"]?>_sub_sn" 	value="<?=$bonus["sn"]?>">
                                                                    <input type="hidden" id="<?=$bonus["sn"]?>_home_team" value="<?=trim($bonus["home_team"])?>">
                                                                    <input type="hidden" id="<?=$bonus["sn"]?>_home_rate" value="<?=$bonus["home_rate"]?>">
                                                                    <input type="hidden" id="<?=$bonus["sn"]?>_draw_rate" value="<?=$bonus["draw_rate"]?>">
                                                                    <input type="hidden" id="<?=$bonus["sn"]?>_away_team" value="<?=trim($bonus["away_team"])?>">
                                                                    <input type="hidden" id="<?=$bonus["sn"]?>_away_rate" value="<?=$bonus["away_rate"]?>">
                                                                    <input type="hidden" id="<?=$bonus["sn"]?>_is_specified_special" value="<?=$bonus["is_specified_special"]?>">
                                                                    <input type="hidden" id="<?=$bonus["sn"]?>_game_date" value="<?=$bonus["gameDate"]?>">
                                                                    <input type="hidden" id="<?=$bonus["sn"]?>_league_sn" value="<?=$bonus["league_sn"]?>">
                                                                    <input type="hidden" id="<?=$bonus["sn"]?>_market_name" value="">
                                                                    <input type="hidden" id="<?=$bonus["sn"]?>_home_betid" value="0">
                                                                    <input type="hidden" id="<?=$bonus["sn"]?>_away_betid" value="0">
                                                                    <input type="hidden" id="<?=$bonus["sn"]?>_draw_betid" value="0">
                                                                    <input type="hidden" id="<?=$bonus["sn"]?>_home_line" value="">
                                                                    <input type="hidden" id="<?=$bonus["sn"]?>_away_line" value="">
                                                                    <input type="hidden" id="<?=$bonus["sn"]?>_home_name" value="">
                                                               </div>
                                                               <?=$bonus["home_team"]?> 
                                                               <span class="bed"><?=$bonus["home_rate"]?></span>
                                                               <input type="checkbox" name="ch" value="1" style="display:none;">
                                                            </div>
                                                         </div>
                                                      </li>
                                                   </ul>
                                                   <?php }
                                                      ?>
                                                </div>
                                                
                                                <table class="sports_game" width="100%" border="0" cellspacing="0" cellpadding="0" id="board_list" style="padding:18px;float:left;">
                                                   <tbody id="gamelist">
                                                   </tbody>
                                                </table>
                                                <div class="page_skip">
                                                    <input type="hidden" id="sport_type" value="">
                                                    <span class="num">
                                                    &nbsp;<a class="page page_1 on" href="javascript:void(0)" onclick="getPage('0')">1</a>
                                                    &nbsp;<a class="page page_2" href="javascript:void(0)" onclick="getPage('1')">2</a>
                                                    &nbsp;<a class="page page_3" href="javascript:void(0)" onclick="getPage('2')">3</a>
                                                    &nbsp;<a class="page page_4" href="javascript:void(0)" onclick="getPage('3')">4</a>
                                                    &nbsp;<a class="page page_5" href="javascript:void(0)" onclick="getPage('4')">5</a>
                                                    </span>
                                                </div>
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
   <script>
      function onExpand(id) {
          var strCur = document.getElementById('game_title_' + id).innerText;
          var arrForm = document.getElementsByClassName('game_form_' + id);
          
          if(strCur == "-") {
              document.getElementById('game_title_' + id).innerText = "+";
              for (var i = 0; i < arrForm.length; i++) {
                  arrForm[i].style.display = "none";
              }
          } else {
              document.getElementById('game_title_' + id).innerText = "-";
              for (var i = 0; i < arrForm.length; i++) {
                  arrForm[i].style.display = "block";
              }
          }
      }
   </script>
   <script language="javascript">
        $j(document).ready(function() {
            localStorage.clear();
            var sport_type = '<?php echo $TPL_VAR["sport_type"]?>';
            // getBonusList();
            getClassicGameList(0, 0);
            onLoadingScreen();
        });
        
        initialize(<?php echo $TPL_VAR["minBetCount"]?>,<?php echo $TPL_VAR["folderBonus"]["bonus3"]?>,<?php echo $TPL_VAR["folderBonus"]["bonus4"]?>,
                    <?php echo $TPL_VAR["folderBonus"]["bonus5"]?>,<?php echo $TPL_VAR["folderBonus"]["bonus6"]?>,<?php echo $TPL_VAR["folderBonus"]["bonus7"]?>,
                    <?php echo $TPL_VAR["folderBonus"]["bonus8"]?>,<?php echo $TPL_VAR["folderBonus"]["bonus9"]?>,<?php echo $TPL_VAR["folderBonus"]["bonus10"]?>,
                    <?php echo $TPL_VAR["singleMaxBetMoney"]?>);
        
        var VarMoney = '<?php echo $TPL_VAR["cash"]?>';
        var VarMinBet = '<?php echo $TPL_VAR["betMinMoney"]?>';
        var VarMaxBet = '<?php echo $TPL_VAR["betMaxMoney"]?>';
        var VarMaxAmount = '<?php echo $TPL_VAR["maxBonus"]?>';
        
        var Bet_Rule = '<?php echo $TPL_VAR["rule"]?>';
        var Bet_Rule_vh = '<?php echo $TPL_VAR["vh"]?>';
        var Bet_Rule_vu = '<?php echo $TPL_VAR["vu"]?>';
        var Bet_Rule_hu = '<?php echo $TPL_VAR["hu"]?>';
        
        var bettingendtime = '<?php echo $TPL_VAR["betEndTime"]?>';
        var bettingcanceltime = '<?php echo $TPL_VAR["betCancelTime"]?>';
        var bettingcancelbeforetime = '<?php echo $TPL_VAR["betCancelBeforeTime"]?>';
        var crossLimitCnt = '<?php echo $TPL_VAR["crossLimitCnt"]?>';
        var game_kind = "<?php echo $gameType?>";
        var s_type = "<?=$s_type?>";
        var showJosn = null;
        
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
        function onTeamSelected($game_index, $index, $special_type, $betid = 0) {
            //console.log($index);
            //-> 글로벌 페이지 타입 저장.
            page_special_type = $special_type;
        
            $sport_name = $j("#" + $game_index + "_sport_name").val();
            $game_type = $j("#" + $game_index + "_game_type").val();
            $home_team = $j("#" + $game_index + "_home_team").val();
            $home_rate = $j("#" + $game_index + "_home_rate").val();
            $draw_rate = $j("#" + $game_index + "_draw_rate").val();
            $away_team = $j("#" + $game_index + "_away_team").val();
            $away_rate = $j("#" + $game_index + "_away_rate").val();
            $sub_sn = $j("#" + $game_index + "_sub_sn").val();
            $game_date = $j("#" + $game_index + "_game_date").val();
            $market_name = $j("#" + $game_index + "_market_name").val();
            $home_betid = $j("#" + $game_index + "_home_betid").val();
            $away_betid = $j("#" + $game_index + "_away_betid").val();
            $draw_betid = $j("#" + $game_index + "_draw_betid").val();
            $home_line = $j("#" + $game_index + "_home_line").val();
            $away_line = $j("#" + $game_index + "_away_line").val();
            $home_name = $j("#" + $game_index + "_home_name").val();
            $league_sn = $j("#" + $game_index + "_league_sn").val();
            $is_specified_special = $j("#" + $game_index + "_is_specified_special").val();
        
            if ($index < 0 || $index > 2)
                return;
        
            if ($index == 1 && ($draw_rate == '1' || $draw_rate == '1.0' || $draw_rate == '1.00' || $draw_rate == 'VS'))
                return;
        
            //-> 보너스 선택시 (2폴더 이상시만 가능)
            if ($home_team.indexOf("폴더") > -1) {
                if (folder_bonus($home_team) == "0") {
                    return;
                }
            }
        
            //선택한 Checkbox의 배당
            var selectedRate = '0';
            if (0 == $index) selectedRate = $home_rate;
            else if (1 == $index) selectedRate = $draw_rate;
            else if (2 == $index) selectedRate = $away_rate;
        
            //토글
            var toggle_action = toggle_multi($game_index + '_div', $index, selectedRate, crossLimitCnt);

            //insert game
            if (toggle_action == 'inserted') {
                
                var item = new Item($game_index, $home_team, $away_team, $index, selectedRate, $home_rate, $draw_rate, $away_rate, $game_type, $sub_sn, $is_specified_special, $game_date, $league_sn, $sport_name, 0, $betid, $market_name, $home_line, $away_line, $home_name, $home_betid, $away_betid, $draw_betid);
                m_betList.addItem(item);

                //betcon = betcon.add_element($game_index + "|" + $index + "&" + $home_team + "  VS " + $away_team);
                var isdisabled = true;
            }
            //delete game
            else {
                m_betList.removeItem($game_index);
                //betcon = betcon.del_element($game_index + "|" + $index + "&" + $home_team + "  VS " + $away_team);
                var isdisabled = false;
            }
        
            bonus_del(); //시점 관련 버그
            calc();
        }
        
        function getPage(page_index) {
            $j(".page").removeClass("on");
            $j(".page_" + (parseInt(page_index) + 1)).addClass("on");
            var sport_type = $j("#sport_type").val();
            var league_sn = $j("#league_sn").val();
            var today = $j("#today").val();
            
            getClassicGameList(page_index, sport_type, league_sn, today);
            
        }
        
        function onRevGameList(strPacket) {
            
            showJson = JSON.parse(strPacket);
        
            if(showJson.length == 0) {
                $j("#gamelist").empty();
                warning_popup("현재 진행중인 경기가 없습니다.");
            } else {
                $j("#gamelist").empty();
                $j(".num").empty();
                var jsonCountInfo = showJson[0].m_lstSportsCnt;
                showSportsTotalCount(jsonCountInfo);
                showGameList();
                
                var page_count = parseInt(showJson[0].m_nTotalCnt) / 100;
                var page_item = "";
                for(var i = 0; i < page_count; i++) {
                    page_item += `&nbsp;<a class="page page_${i + 1} ${packet.m_nPageIndex == i ? 'on' : ''}" href="javascript:void(0)" onclick="getPage('${i}')">${i + 1}</a>`;
                }
                $j(".num").append(page_item);
            }
            
            $j("#loading").fadeOut(1000);
            $j("#coverBG2").fadeOut(1000);
        }
        
        function onRecvAjaxList(strPacket) {
            var json = JSON.parse(strPacket);
            if(json.length > 0) {
                var jsonCountInfo = json[0].m_lstSportsCnt;
                showSportsTotalCount(jsonCountInfo);
                showAjaxList(json);
            } 
        }

        function realTime(strPacket) {

        }
        
        function onClickLeague(nLeague) {
            getClassicGameList(0, "", nLeague, 0);
        }
        
        function getClassicGameList(page_index = 0, sport_type = "", league_sn = 0, today = 0) {
            $j("#sport_type").val(sport_type);
            $j("#league_sn").val(league_sn);
            $j("#today").val(today);
            $j(".page").removeClass("on");
            $j(".page_" + (parseInt(page_index) + 1)).addClass("on");
            switch(sport_type) {
                case "":
                    $j(".btn_all").addClass("on");
                    $j(".btn_soccer").removeClass("on");
                    $j(".btn_basketball").removeClass("on");
                    $j(".btn_baseball").removeClass("on");
                    $j(".btn_hockey").removeClass("on");
                    $j(".btn_volleyball").removeClass("on");
                    $j(".btn_esports").removeClass("on");
                    break;
                case "soccer":
                    $j(".btn_soccer").addClass("on");
                    $j(".btn_all").removeClass("on");
                    $j(".btn_basketball").removeClass("on");
                    $j(".btn_baseball").removeClass("on");
                    $j(".btn_hockey").removeClass("on");
                    $j(".btn_volleyball").removeClass("on");
                    $j(".btn_esports").removeClass("on");
                    break;
                case "basketball":
                    $j(".btn_basketball").addClass("on");
                    $j(".btn_soccer").removeClass("on");
                    $j(".btn_all").removeClass("on");
                    $j(".btn_baseball").removeClass("on");
                    $j(".btn_hockey").removeClass("on");
                    $j(".btn_volleyball").removeClass("on");
                    $j(".btn_esports").removeClass("on");
                    break;
                case "baseball":
                    $j(".btn_baseball").addClass("on");
                    $j(".btn_soccer").removeClass("on");
                    $j(".btn_basketball").removeClass("on");
                    $j(".btn_all").removeClass("on");
                    $j(".btn_hockey").removeClass("on");
                    $j(".btn_volleyball").removeClass("on");
                    $j(".btn_esports").removeClass("on");
                    break;
                case "hockey":
                    $j(".btn_hockey").addClass("on");
                    $j(".btn_soccer").removeClass("on");
                    $j(".btn_basketball").removeClass("on");
                    $j(".btn_baseball").removeClass("on");
                    $j(".btn_all").removeClass("on");
                    $j(".btn_volleyball").removeClass("on");
                    $j(".btn_esports").removeClass("on");
                    break;
                case "volleyball":
                    $j(".btn_volleyball").addClass("on");
                    $j(".btn_soccer").removeClass("on");
                    $j(".btn_basketball").removeClass("on");
                    $j(".btn_baseball").removeClass("on");
                    $j(".btn_hockey").removeClass("on");
                    $j(".btn_all").removeClass("on");
                    $j(".btn_esports").removeClass("on");
                    break;
                case "esports":
                    $j(".btn_esports").addClass("on");
                    $j(".btn_volleyball").removeClass("on");
                    $j(".btn_soccer").removeClass("on");
                    $j(".btn_basketball").removeClass("on");
                    $j(".btn_baseball").removeClass("on");
                    $j(".btn_hockey").removeClass("on");
                    $j(".btn_all").removeClass("on");
                    break;
            }
            
            packet = {
                "m_strSports"   :   sport_type,
                "m_nLeague"     :   league_sn,
                "m_nLive"       :   0,
                "m_nPageIndex"  :   page_index,
                "m_nPageSize"   :   100,
                "m_nSendType"   :   nSendType
            };
        
            onSendReqListPacket(packet);

            return;
        }
        
        function showGameList() {
            var group_id = 0;
            for(var i = 0; i < showJson.length; i++) {
                
                if(showJson[i] == undefined || showJson[i].length == 0)
                    continue;
                
                if(group_id != showJson[i].m_nGroup) {
                    group_id = showJson[i].m_nGroup;
                    appendLeagueDiv(showJson[i]);
                    appendGameDiv(showJson[i]);
                } else {
                    appendGameDiv(showJson[i]);
                }
            }
            scrollToTop();
            $j(".mask_layer").click();
        }
        
        function showAjaxList(newJson) {
            console.log("Ajax");
            if(showJson == null) {
                return;
            }
            var sub_idx = "";
            for(var i = 0; i < showJson.length; i++) {
                var json = newJson.find(val => val.m_nGame == showJson[i].m_nGame);
                if(json == null || json == undefined) {
                    //우선 지금 경기가 아직도 존재하는가를 검사하고 존재하지 않는다면 지워야 한다.
                    removeGameDiv(showJson[i]);
                }
                else {
                    for(var j=0; j < showJson[i].m_lstDetail.length; j++) {
                        var djson = json.m_lstDetail.find(val => val.m_nHBetCode == showJson[i].m_lstDetail[j].m_nHBetCode && val.m_nDBetCode == showJson[i].m_lstDetail[j].m_nDBetCode && val.m_nABetCode == showJson[i].m_lstDetail[j].m_nABetCode);
                        if(djson == null || djson == undefined) {
                            //배당자료 존재하지 않음
                            //   removeMarketDiv(showJson[i], showJson[i].m_lstDetail[j]);
                        }
                        else {
                            //배당자료업데이트
                            sub_idx = `${json.m_nGame}_${djson.m_nMarket}_${djson.m_nFamily}`;
                            if(document.getElementById(`${djson.m_nHBetCode}`) != null) {
                                document.getElementById(`${djson.m_nHBetCode}`).innerHTML = djson.m_fHRate.toFixed(2);
                            }
                            
                            if(document.getElementById(`${djson.m_nDBetCode}`) != null) {
                                document.getElementById(`${djson.m_nDBetCode}`).innerHTML = djson.m_fDRate.toFixed(2);
                            }

                            if(document.getElementById(`${djson.m_nABetCode}`) != null) {
                                document.getElementById(`${djson.m_nABetCode}`).innerHTML = djson.m_fARate.toFixed(2);
                            }

                            if(djson.m_nMarket == 1 || djson.m_nMarket == 52 || djson.m_nMarket == 226) {
                                if(document.getElementById(`${sub_idx}_home_rate`) != null)
                                    document.getElementById(`${sub_idx}_home_rate`).value = djson.m_fHRate.toFixed(2); 

                                if(document.getElementById(`${sub_idx}_draw_rate`) != null) 
                                    document.getElementById(`${sub_idx}_draw_rate`).value = djson.m_fDRate.toFixed(2);   
                                    
                                if(document.getElementById(`${sub_idx}_away_rate`) != null) 
                                    document.getElementById(`${sub_idx}_away_rate`).value = djson.m_fARate.toFixed(2); 
                            }

                            // 배팅카트의 배당 업데이트
                            if(document.getElementById(`${djson.m_nHBetCode}_cart`) != null) {
                                document.getElementById(`${djson.m_nHBetCode}_cart`).innerHTML = djson.m_fHRate.toFixed(2);
                                updateCart(0, djson.m_nHBetCode, djson.m_fHRate);
                                if(localStorage.getItem(`selected_${djson.m_nHBetCode}`) !== null) {
                                    $j(`#${djson.m_nHBetCode}_chk`).parent().addClass("on");
                                    $j(`#${djson.m_nHBetCode}_chk`).prop("checked", true);
                                }
                            }

                            if(document.getElementById(`${djson.m_nDBetCode}_cart`) != null) {
                                document.getElementById(`${djson.m_nDBetCode}_cart`).innerHTML = djson.m_fDRate.toFixed(2);
                                updateCart(1, djson.m_nDBetCode, djson.m_fDRate);
                                if(localStorage.getItem(`selected_${djson.m_nDBetCode}`) !== null) {
                                    $j(`#${djson.m_nDBetCode}_chk`).parent().addClass("on");
                                    $j(`#${djson.m_nDBetCode}_chk`).prop("checked", true);
                                }
                            }

                            if(document.getElementById(`${djson.m_nABetCode}_cart`) != null) { 
                                document.getElementById(`${djson.m_nABetCode}_cart`).innerHTML = djson.m_fARate.toFixed(2);
                                updateCart(2, djson.m_nABetCode, djson.m_fARate);
                                if(localStorage.getItem(`selected_${djson.m_nABetCode}`) !== null) {
                                    $j(`#${djson.m_nABetCode}_chk`).parent().addClass("on");
                                    $j(`#${djson.m_nABetCode}_chk`).prop("checked", true);
                                }
                            }
                        }
                    }

                    var subItem = new Array;
                    var detail = json.m_lstDetail;
                    for (var j = 0; j < detail.length; j++) {
                        sub_idx = `${json.m_nGame}_${detail[j].m_nMarket}_${detail[j].m_nFamily}`;
                        switch(json.m_strSportName) {
                            case "축구":
                                if(detail[j].m_nMarket == 2) {
                                    subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 2));
                                } else if (detail[j].m_nMarket == 3) {
                                    subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 3));
                                }
                                break;
                            case "농구":
                                if(detail[j].m_nMarket == 28) {
                                    subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 28));
                                } else if (detail[j].m_nMarket == 3) {
                                    subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 3));
                                }
                                break;
                            case "야구":
                                if(detail[j].m_nMarket == 28) {
                                    subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 28));
                                } else if (detail[j].m_nMarket == 342) {
                                    subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 342));
                                } 
                                break;
                            case "배구":
                                if(detail[j].m_nMarket == 2) {
                                    subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 2));
                                } else if (detail[j].m_nMarket == 1558) {
                                    subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 1558));
                                } 
                                break;
                            case "아이스 하키":
                                if(detail[j].m_nMarket == 28) {
                                    subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 28));
                                } else if (detail[j].m_nMarket == 342) {
                                    subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 342));
                                } 
                                break;
                            case "E스포츠":
                                if(detail[j].m_nMarket == 2) {
                                    subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 2));
                                } else if (detail[j].m_nMarket == 3) {
                                    subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 3));
                                }
                                break;
                            break;
                        }
                        
                        if(detail[j].m_nFamily == 7 || detail[j].m_nFamily == 8 || detail[j].m_nFamily == 9) {
                            if(document.getElementById(`${sub_idx}_home_rate`) != null)
                                document.getElementById(`${sub_idx}_home_rate`).value = subItem.m_fHRate.toFixed(2); 

                            if(document.getElementById(`${sub_idx}_draw_rate`) != null) 
                                document.getElementById(`${sub_idx}_draw_rate`).value = subItem.m_fDRate.toFixed(2);   
                                
                            if(document.getElementById(`${sub_idx}_away_rate`) != null) 
                                document.getElementById(`${sub_idx}_away_rate`).value = subItem.m_fARate.toFixed(2);
                        }
                        
                    }
                     
        
                    for(var j=0; j < json.m_lstDetail.length; j++) {
                        var djson = showJson[i].m_lstDetail.find(val => val.m_nHBetCode == json.m_lstDetail[j].m_nHBetCode && val.m_nDBetCode == json.m_lstDetail[j].m_nDBetCode && val.m_nABetCode == json.m_lstDetail[j].m_nABetCode);
                        if(djson == null || djson == undefined) {
                            //새배당추가
                            //appendMarketDiv(showJson[i], json.m_lstDetail[j]);
                        }
                    }
                }
            }
        
            var group_id = 0;
            for(var i = 0; i < newJson.length; i++) {
                var league_div = document.getElementById(`${newJson[i].m_strDate}_${newJson[i].m_strHour}_${newJson[i].m_strMin}_${newJson[i].m_nLeague}`);
                if(league_div != undefined) {
                    var form = document.getElementById(`game_${newJson[i].m_nFixtureID}`);
                    if(form == null || form == undefined) {
                        appendGameDiv(newJson[i]);
                    }
                } else {
                    appendLeagueDiv(newJson[i]);
                    appendGameDiv(newJson[i]);
                }
            }
        
            showJson = newJson;
        }
      
        function removeMarketDiv(jsonGame, jsonMarket) {
            var id_div = `${jsonGame.m_nFixtureID}_${detail.m_nHBetCode}`;
            $j(`#${id_div}`).remove();
            
            var obj = document.getElementById(`game_${jsonGame.m_nFixtureID}_value`);
            var marketCnt = parseInt(obj.value) - 1;
            if(marketCnt == 0) {
                removeGameDiv(jsonGame);
            }
            else {
                obj.value = marketCnt;
            }
            
        }
        
        function appendMarketDiv(jsonGame, jsonMarket) {
        
        }
        
        function removeGameDiv(json) {
            $j(`#game_${json.m_nFixtureID}`).remove();
            var obj = document.getElementById(`${json.m_strDate}_${json.m_strHour}_${json.m_strMin}_${json.m_nLeague}_value`);
            if(obj != null && obj != undefined) {
                var cnt = parseInt(obj.value) - 1;
                if(cnt == 0) {
                    console.log("******************");
                    console.log("remove Game");
                    console.log("******************");
                    $j(`#${json.m_strDate}_${json.m_strHour}_${json.m_strMin}_${json.m_nLeague}`).remove();
                }
                else {
                    obj.value = cnt;
                }
            }
            
        }

        function appendLeagueDiv(json) {
            var div = "";
            div += '<tr>';
            div += '<td>';
            div += `<div class="ko_sports_game j_1371_t" id="${json.m_strDate}_${json.m_strHour}_${json.m_strMin}_${json.m_nLeague}">`;
            div += `<input type="hidden" id="${json.m_strDate}_${json.m_strHour}_${json.m_strMin}_${json.m_nLeague}_value" value="0">`;
            div += '<h4>';
            div += '<a name="target_1371"></a>';
            switch(json.m_strSportName) {
                case "축구":
                    div += '<img src="/images/ibet/sporticons_f.png" align="absmiddle" border="0">&nbsp;';
                    break;
                case "농구":
                    div += '<img src="/images/ibet/sporticons_bk.png" align="absmiddle" border="0">&nbsp;';
                    break;
                case "배구":
                    div += '<img src="/10bet/images/10bet/ico/volleyball-ico.png" align="absmiddle" border="0" style="width:18px">&nbsp;';
                    break;
                case "야구":
                    div += '<img src="/10bet/images/10bet/ico/baseball-ico.png" align="absmiddle" border="0" style="width:18px">&nbsp;';
                    break;
                case "아이스 하키":
                    div += '<img src="/10bet/images/10bet/ico/hockey-ico.png" align="absmiddle" border="0" style="width:18px">&nbsp;';
                    break;
                case "E스포츠":
                    div += '<img src="/10bet/images/10bet/ico/esport-ico.png" align="absmiddle" border="0" style="width:24px">&nbsp';
                    break;
                default:
                    div += '<img src="/images/ibet/sporticons_e.png" align="absmiddle" border="0">';
                    break;
            }
            div += '<img src="/10bet/images/10bet/arrow_01.png" class="arrow" alt="">';
            div += '<img src="' + json.m_strLeagueImg + '?v=1" width="22" height="16" style="margin-top:-2px;">&nbsp;&nbsp;';
            div += '<font class="league_name" style="color:#22b486; font-weight:900;">' + json.m_strLeagueName + '</font>';
            div += `<span class="time hidden-sm">${json.m_strDate.substring(5,10)}&nbsp;${json.m_strHour}:${json.m_strMin}</span>`;
            div += '</h4>';
            div += `</div></td></tr>`;

            $j("#gamelist").append(div);
        }
        
        function appendGameDiv(json) {
            var div = "";
            if(document.getElementById(`${json.m_strDate}_${json.m_strHour}_${json.m_strMin}_${json.m_nLeague}_value`) != null && document.getElementById(`${json.m_strDate}_${json.m_strHour}_${json.m_strMin}_${json.m_nLeague}_value`) != undefined){
                var cnt = parseInt(document.getElementById(`${json.m_strDate}_${json.m_strHour}_${json.m_strMin}_${json.m_nLeague}_value`).value) + 1;
                document.getElementById(`${json.m_strDate}_${json.m_strHour}_${json.m_strMin}_${json.m_nLeague}_value`).value = cnt;
            }
            
            div += `<form id="game_${json.m_nFixtureID}">`;
            div += `<input type="hidden" id="game_${json.m_nFixtureID}_value" value="0">`;            
            var save_name = "";
            var game_sn_code = 0;
            var child_size = 0;
            var is_child = true;
            var unoverCnt = 0;
            var handiCnt = 0;
            var cnt12 = 0;
            var cnt1x2 = 0;
            var cntUnover = 0;
            var cntHandi = 0;
        
            var subItem = new Array;
            var parent_child_sn = 0;
            var parent_index = 0;
            var unoverDiv = "";
            var handiDiv = "";
        
            var marketCnt = 0;
            var detail = json.m_lstDetail;
            for (var j = 0; j < detail.length; j++) {
                sub_idx = `${json.m_nGame}_${detail[j].m_nMarket}_${detail[j].m_nFamily}`;
                switch(json.m_strSportName) {
                    case "축구":
                        if(detail[j].m_nMarket == 1) {
                            is_child = false;
                            div += div_1x2(json.m_strSportName, json.m_strDate, json.m_strHour, json.m_strMin, json.m_nLeague, detail[j], is_child, json.m_nFixtureID, json.m_strHomeTeam, json.m_strAwayTeam, sub_idx);
                            marketCnt++;
                        } else if(detail[j].m_nMarket == 2) {
                            is_child = true;
                            homeTeamAdd = '&nbsp;<font class="gameType"></font><span class="icon_down">&nbsp;&nbsp;</span>';
                            awayTeamAdd = '<span class="icon_up">&nbsp;&nbsp;</span><font class="gameType"></font>&nbsp;';
                            homeTeamName = json.m_strHomeTeam + homeTeamAdd;
                            awayTeamName = awayTeamAdd + json.m_strAwayTeam;
                            if(cntUnover == 0) {
                                subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 2));
                                unoverDiv = div_unover(json.m_strSportName, json.m_strDate, json.m_strHour, json.m_strMin, json.m_nLeague, subItem, is_child, json.m_nFixtureID, json.m_strHomeTeam, json.m_strAwayTeam, homeTeamName, awayTeamName, sub_idx);
                                marketCnt++;
                            }
                            cntUnover++;
                        } else if (detail[j].m_nMarket == 3) {
                            is_child = true;
                            homeTeamAdd = '&nbsp;<font color="#adff2f">[H]</font>';
                            awayTeamAdd = '<font color="#adff2f">[H]</font>&nbsp;';
                            homeTeamName = json.m_strHomeTeam + homeTeamAdd;
                            awayTeamName = awayTeamAdd + json.m_strAwayTeam;
                            if(cntHandi == 0) {
                                subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 3));
                                if(subItem.m_strHLine !== null && subItem.m_strALine !== null) {
                                    div += div_handi(json.m_strSportName,  json.m_strDate, json.m_strHour, json.m_strMin, json.m_nLeague, subItem, is_child, json.m_nFixtureID, json.m_strHomeTeam, json.m_strAwayTeam, homeTeamName, awayTeamName, sub_idx);
                                    div += unoverDiv;
                                    unoverDiv = "";
                                    marketCnt++;
                                }
                            }
                            cntHandi++;
                        }
                        break;
                    case "농구":
                        if(detail[j].m_nMarket == 28) {
                            is_child = true;
                            homeTeamAdd = '&nbsp;<font class="gameType"></font><span class="icon_down">&nbsp;&nbsp;</span>';
                            awayTeamAdd = '<span class="icon_up">&nbsp;&nbsp;</span><font class="gameType"></font>&nbsp;';
                            homeTeamName = json.m_strHomeTeam + homeTeamAdd;
                            awayTeamName = awayTeamAdd + json.m_strAwayTeam;
                            
                            if(cntUnover == 0) {
                                subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 28));
                                unoverDiv += div_unover(json.m_strSportName, json.m_strDate, json.m_strHour, json.m_strMin, json.m_nLeague, subItem, is_child, json.m_nFixtureID, json.m_strHomeTeam, json.m_strAwayTeam, homeTeamName, awayTeamName, sub_idx);
                                marketCnt++;
                            }
                            cntUnover++;
                        } else if(detail[j].m_nMarket == 226) {
                            is_child = false;
                            div += div_12(json.m_strSportName, json.m_strDate, json.m_strHour, json.m_strMin, json.m_nLeague, detail[j], is_child, json.m_nFixtureID, json.m_strHomeTeam, json.m_strAwayTeam, sub_idx);
                            marketCnt++;
                        } else if (detail[j].m_nMarket == 342) {
                            is_child = true;
                            homeTeamAdd = '&nbsp;<font color="#adff2f">[H]</font>';
                            awayTeamAdd = '<font color="#adff2f">[H]</font>&nbsp;';
                            homeTeamName = json.m_strHomeTeam + homeTeamAdd;
                            awayTeamName = awayTeamAdd + json.m_strAwayTeam;
                            if(cntHandi == 0) {
                                subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 342));
                                if(subItem.m_strHLine !== null && subItem.m_strALine !== null) {
                                    handiDiv += div_handi(json.m_strSportName, json.m_strDate, json.m_strHour, json.m_strMin, json.m_nLeague, subItem, is_child, json.m_nFixtureID, json.m_strHomeTeam, json.m_strAwayTeam, homeTeamName, awayTeamName, sub_idx);
                                    marketCnt++;
                                }
                            }
                            cntHandi++;

                            div += handiDiv + unoverDiv;
                            unoverDiv = "";
                            handiDiv = "";
                        } 
                        break;
                    case "야구":
                        if(detail[j].m_nMarket == 28) {
                            is_child = true;
                            homeTeamAdd = '&nbsp;<font class="gameType"></font><span class="icon_down">&nbsp;&nbsp;</span>';
                            awayTeamAdd = '<span class="icon_up">&nbsp;&nbsp;</span><font class="gameType"></font>&nbsp;';
                            homeTeamName = json.m_strHomeTeam + homeTeamAdd;
                            awayTeamName = awayTeamAdd + json.m_strAwayTeam;
                            
                            if(cntUnover == 0) {
                                subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 28));
                                unoverDiv += div_unover(json.m_strSportName, json.m_strDate, json.m_strHour, json.m_strMin, json.m_nLeague, subItem, is_child, json.m_nFixtureID, json.m_strHomeTeam, json.m_strAwayTeam, homeTeamName, awayTeamName, sub_idx);
                                marketCnt++;
                            }
                            cntUnover++;
                        } else if(detail[j].m_nMarket == 226) {
                            is_child = false;
                            div += div_12(json.m_strSportName, json.m_strDate, json.m_strHour, json.m_strMin, json.m_nLeague, detail[j], is_child, json.m_nFixtureID, json.m_strHomeTeam, json.m_strAwayTeam, sub_idx);
                            marketCnt++;
                        } else if (detail[j].m_nMarket == 342) {
                            is_child = true;
                            homeTeamAdd = '&nbsp;<font color="#adff2f">[H]</font>';
                            awayTeamAdd = '<font color="#adff2f">[H]</font>&nbsp;';
                            homeTeamName = json.m_strHomeTeam + homeTeamAdd;
                            awayTeamName = awayTeamAdd + json.m_strAwayTeam;
                            if(cntHandi == 0) {
                                subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 342));
                                if(subItem.m_strHLine !== null && subItem.m_strALine !== null) {
                                    handiDiv += div_handi(json.m_strSportName, json.m_strDate, json.m_strHour, json.m_strMin, json.m_nLeague, subItem, is_child, json.m_nFixtureID, json.m_strHomeTeam, json.m_strAwayTeam, homeTeamName, awayTeamName, sub_idx);
                                    marketCnt++;
                                }
                            }
                            cntHandi++;
                            div += handiDiv + unoverDiv;
                            unoverDiv = "";
                            handiDiv = "";
                        } 
                        break;
                    case "배구":
                        if(detail[j].m_nMarket == 2) {
                            is_child = true;
                            homeTeamAdd = '&nbsp;<font class="gameType"></font><span class="icon_down">&nbsp;&nbsp;</span>';
                            awayTeamAdd = '<span class="icon_up">&nbsp;&nbsp;</span><font class="gameType"></font>&nbsp;';
                            homeTeamName = json.m_strHomeTeam + homeTeamAdd;
                            awayTeamName = awayTeamAdd + json.m_strAwayTeam;
                            
                            if(cntUnover == 0) {
                                subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 2));
                                unoverDiv += div_unover(json.m_strSportName, json.m_strDate, json.m_strHour, json.m_strMin, json.m_nLeague, subItem, is_child, json.m_nFixtureID, json.m_strHomeTeam, json.m_strAwayTeam, homeTeamName, awayTeamName, sub_idx);
                                marketCnt++;
                            }
                            cntUnover++;
                        } else if(detail[j].m_nMarket == 52) {
                            is_child = false;
                            div += div_12(json.m_strSportName, json.m_strDate, json.m_strHour, json.m_strMin, json.m_nLeague, detail[j], is_child, json.m_nFixtureID, json.m_strHomeTeam, json.m_strAwayTeam, sub_idx);
        
                            marketCnt++;
                        } else if (detail[j].m_nMarket == 1558) {
                            is_child = true;
                            homeTeamAdd = '&nbsp;<font color="#adff2f">[H]</font>';
                            awayTeamAdd = '<font color="#adff2f">[H]</font>&nbsp;';
                            homeTeamName = json.m_strHomeTeam + homeTeamAdd;
                            awayTeamName = awayTeamAdd + json.m_strAwayTeam;
                            if(cntHandi == 0) {
                                subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 1558));
                                if(subItem.m_strHLine !== null && subItem.m_strALine !== null) {
                                    handiDiv += div_handi(json.m_strSportName, json.m_strDate, json.m_strHour, json.m_strMin, json.m_nLeague, subItem, is_child, json.m_nFixtureID, json.m_strHomeTeam, json.m_strAwayTeam, homeTeamName, awayTeamName, sub_idx);
                                    marketCnt++;
                                }
                            }
                            cntHandi++;
                            div += handiDiv + unoverDiv;
                            unoverDiv = "";
                            handiDiv = "";
                        } 
                        break;
                    case "아이스 하키":
                        if(detail[j].m_nMarket == 1) {
                            is_child = false;
                            div += div_1x2(json.m_strSportName, json.m_strDate, json.m_strHour, json.m_strMin, json.m_nLeague, detail[j], is_child, json.m_nFixtureID, json.m_strHomeTeam, json.m_strAwayTeam, sub_idx);
                            marketCnt++;
                        } else if(detail[j].m_nMarket == 28) {
                            is_child = true;
                            homeTeamAdd = '&nbsp;<font class="gameType"></font><span class="icon_down">&nbsp;&nbsp;</span>';
                            awayTeamAdd = '<span class="icon_up">&nbsp;&nbsp;</span><font class="gameType"></font>&nbsp;';
                            homeTeamName = json.m_strHomeTeam + homeTeamAdd;
                            awayTeamName = awayTeamAdd + json.m_strAwayTeam;
                            
                            if(cntUnover == 0) {
                                subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 28));
                                unoverDiv += div_unover(json.m_strSportName, json.m_strDate, json.m_strHour, json.m_strMin, json.m_nLeague, subItem, is_child, json.m_nFixtureID, json.m_strHomeTeam, json.m_strAwayTeam, homeTeamName, awayTeamName, sub_idx);
                                marketCnt++;
                            }
                            cntUnover++;
                        } else if (detail[j].m_nMarket == 342) {
                            is_child = true;
                            homeTeamAdd = '&nbsp;<font color="#adff2f">[H]</font>';
                            awayTeamAdd = '<font color="#adff2f">[H]</font>&nbsp;';
                            homeTeamName = json.m_strHomeTeam + homeTeamAdd;
                            awayTeamName = awayTeamAdd + json.m_strAwayTeam;
                            if(cntHandi == 0) {
                                subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 342));
                                if(subItem.m_strHLine !== null && subItem.m_strALine !== null) {
                                    handiDiv += div_handi(json.m_strSportName, json.m_strDate, json.m_strHour, json.m_strMin, json.m_nLeague, subItem, is_child, json.m_nFixtureID, json.m_strHomeTeam, json.m_strAwayTeam, homeTeamName, awayTeamName, sub_idx);
                                    marketCnt++;
                                }
                            }
                            cntHandi++;
                            div += handiDiv + unoverDiv;
                            unoverDiv = "";
                            handiDiv = "";
                        } 
                        break;
                    case "E스포츠":
                        if(detail[j].m_nMarket == 2) {
                            is_child = true;
                            homeTeamAdd = '&nbsp;<font class="gameType"></font><span class="icon_down">&nbsp;&nbsp;</span>';
                            awayTeamAdd = '<span class="icon_up">&nbsp;&nbsp;</span><font class="gameType"></font>&nbsp;';
                            homeTeamName = json.m_strHomeTeam + homeTeamAdd;
                            awayTeamName = awayTeamAdd + json.m_strAwayTeam;
                            
                            if(cntUnover == 0) {
                                subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 2));
                                unoverDiv += div_unover(json.m_strSportName, json.m_strDate, json.m_strHour, json.m_strMin, json.m_nLeague, subItem, is_child, json.m_nFixtureID, json.m_strHomeTeam, json.m_strAwayTeam, homeTeamName, awayTeamName, sub_idx);
                                marketCnt++;
                            }
                            cntUnover++;
                        } else if (detail[j].m_nMarket == 3) {
                            is_child = true;
                            homeTeamAdd = '&nbsp;<font color="#adff2f">[H]</font>';
                            awayTeamAdd = '<font color="#adff2f">[H]</font>&nbsp;';
                            homeTeamName = json.m_strHomeTeam + homeTeamAdd;
                            awayTeamName = awayTeamAdd + json.m_strAwayTeam;
                            if(cntHandi == 0) {
                                subItem = chooseProperItem(detail.filter(value => value.m_nMarket == 3));
                                if(subItem.m_strHLine !== null && subItem.m_strALine !== null) {
                                    handiDiv += div_handi(json.m_strSportName, json.m_strDate, json.m_strHour, json.m_strMin, json.m_nLeague, subItem, is_child, json.m_nFixtureID, json.m_strHomeTeam, json.m_strAwayTeam, homeTeamName, awayTeamName, sub_idx);
                                    marketCnt++;
                                }
                            }
                            cntHandi++;
                        } else if(detail[j].m_nMarket == 52) {
                            is_child = false;
                            div += div_12(json.m_strSportName, json.m_strDate, json.m_strHour, json.m_strMin, json.m_nLeague, detail[j], is_child, json.m_nFixtureID, json.m_strHomeTeam, json.m_strAwayTeam, sub_idx);
                            div += handiDiv + unoverDiv;
                            unoverDiv = "";
                            handiDiv = "";
        
                            marketCnt++;
                        } 
                        break;
                    break;
                }
            }
            div += '</form>';
            if(document.getElementById(`game_${json.m_nFixtureID}_value`) != null && document.getElementById(`game_${json.m_nFixtureID}_value`) != undefined)
                document.getElementById(`game_${json.m_nFixtureID}_value`).value = marketCnt;
            
            var league_div = $j(`#${json.m_strDate}_${json.m_strHour}_${json.m_strMin}_${json.m_nLeague}`);
            if(league_div != null && league_div != undefined)
                league_div.append(div);
            
        }

        function chooseProperItem(subItems) {
            var diff = 100.0;
            var index = 0;
            for(var i = 0; i < subItems.length; i++) {
                var temp_diff = Math.abs(subItems[i].m_fHRate - subItems[i].m_fARate);
                if(diff > temp_diff) {
                    diff = temp_diff;
                    index = i;
                }
            }
            return subItems[index];
        }
      
        function div_1x2(sport_name, gameDate, gameHour, gameTime, league_sn, detail, is_child, game_sn_code, homeTeamName, awayTeamName, sub_idx){
            var div = '';
            if(is_child === true) {
                div += `<form style="display:none" class="game_form_${game_sn_code}" id="${game_sn_code}_${detail.m_nHBetCode}">`;
            } else {
                div += `<form id="${game_sn_code}_${detail.m_nHBetCode}">`; 
            } 
            div += '<div style="display:none">';
            div += '<input type="hidden" id="' + sub_idx + '_sport_name" value="' + sport_name + '">';
            div += '<input type="hidden" id="' + sub_idx + '_game_type" value="' + detail.m_nMarket + '">';
            div += '<input type="hidden" id="' + sub_idx + '_sub_sn"    value="' + sub_idx + '">';
            div += '<input type="hidden" id="' + sub_idx + '_home_team" value="' + homeTeamName + '">';
            div += '<input type="hidden" id="' + sub_idx + '_home_rate" value="' + detail.m_fHRate + '">';
            div += '<input type="hidden" id="' + sub_idx + '_draw_rate" value="' + detail.m_fDRate + '">';
            div += '<input type="hidden" id="' + sub_idx + '_away_team" value="' + awayTeamName + '">';
            div += '<input type="hidden" id="' + sub_idx + '_away_rate" value="' + detail.m_fARate + '">';
            div += '<input type="hidden" id="' + sub_idx + '_game_date" value="' + gameDate + '">';
            div += '<input type="hidden" id="' + sub_idx + '_league_sn" value="' + league_sn + '">';
            div += '<input type="hidden" id="' + sub_idx + '_market_name" value="승무패">';
            div += '<input type="hidden" id="' + sub_idx + '_home_betid" value="' + detail.m_nHBetCode + '">';
            div += '<input type="hidden" id="' + sub_idx + '_away_betid" value="' + detail.m_nABetCode + '">';
            div += '<input type="hidden" id="' + sub_idx + '_draw_betid" value="' + detail.m_nDBetCode + '">';
            div += '<input type="hidden" id="' + sub_idx + '_home_line" value="' + detail.m_strHLine + '">';
            div += '<input type="hidden" id="' + sub_idx + '_away_line" value="' + detail.m_strALine + '">';
            div += '<input type="hidden" id="' + sub_idx + '_home_name" value="' + detail.m_strHName + '"></div>';
            div += '<div name="' + sub_idx + '">';
            div += '<ul>';
            div += '<li style="margin-bottom:10px;"></li>';
            div += '<li>';
            div += '<div class="type01 1" style="width:8%;">';
            if(!is_child) {
                div += '<span class="time">' + gameDate.substring(5,10) + ' ' + gameHour + ':' + gameTime + '</span>'; 
            }
            div += '</div>';
            div += '<div class="type01 1">';
            div += "승무패";
            div += '</div>';
            div += '<div class="bet_area">';
            div += "<div class='" + (is_child ? "child-home" : "home") + " menuOff home-width' name='" + sub_idx + "_div' onclick=onTeamSelected('" + sub_idx + "','0','" + 0 + "'," + detail.m_nHBetCode + ")>";
            div += '<font class="team_name">' + homeTeamName + '</font>';
            div += '<span class="bed" id="' + detail.m_nHBetCode + '">' + detail.m_fHRate.toFixed(2) + '</span>';
            div += `<input type="checkbox" id="${detail.m_nHBetCode}_chk" name="ch" value="1" style="display:none;">`;
            div += '</div>';
        
            div += "<div class='" + (is_child ? "child-draw" : "draw") + " menuOff draw-width' name='" + sub_idx + "_div' onclick=onTeamSelected('" + sub_idx + "','1','" + 0 + "','" + detail.m_nDBetCode + "')>";
            div += '<span class="bed" id="' + detail.m_nDBetCode + '">' + detail.m_fDRate.toFixed(2) + '</span>';
            div += `<input type="checkbox" id="${detail.m_nDBetCode}_chk" name="ch" value="3" style="display:none;"></div>`;
        
            div += "<div class='" + (is_child ? "child-away" : "away") + " menuOff away-width' name='" + sub_idx + "_div' onclick=onTeamSelected('" + sub_idx + "','2','" + 0 + "','" + detail.m_nABetCode + "')>";
            div += '<font class="team_name">' + awayTeamName + '</font>';
            div += '<span class="bed" id="' + detail.m_nABetCode + '">' + detail.m_fARate.toFixed(2) + '</span>';
            div += `<input type="checkbox" id="${detail.m_nABetCode}_chk" name="ch" value="2" style="display:none;"></div>`;
            
            if(!is_child) {
                div += '<div class="toggle-width"><span class="toggle-icon" id="game_title_' + game_sn_code + '" onclick="onExpand(' + game_sn_code + ')">+</span></div>';
            } else {
                div += '<div class="toggle-width" style="border:none; box-shadow: none; background:#222227;"></div>';
            }
            div += '</div></li></ul></div></form>';
            return div;
        }
        
        function div_12(sport_name, gameDate, gameHour, gameTime, league_sn, detail, is_child, game_sn_code, homeTeamName, awayTeamName, sub_idx) {
            var div = "";

            if(is_child === true) {
                div += `<form style="display:none" class="game_form_${game_sn_code}" id="${game_sn_code}_${detail.m_nHBetCode}">`;
            } else {
                div += `<form id="${game_sn_code}_${detail.m_nHBetCode}">`; 
            }
            div += '<div style="display:none">';
            div += '<input type="hidden" id="' + sub_idx + '_sport_name" value="' + sport_name + '">';
            div += '<input type="hidden" id="' + sub_idx + '_game_type" value="' + detail.m_nMarket + '">';
            div += '<input type="hidden" id="' + sub_idx + '_sub_sn"    value="' + sub_idx + '">';
            div += '<input type="hidden" id="' + sub_idx + '_home_team" value="' + homeTeamName + '">';
            div += '<input type="hidden" id="' + sub_idx + '_home_rate" value="' + detail.m_fHRate + '">';
            div += '<input type="hidden" id="' + sub_idx + '_draw_rate" value="' + detail.m_fDRate + '">';
            div += '<input type="hidden" id="' + sub_idx + '_away_team" value="' + awayTeamName + '">';
            div += '<input type="hidden" id="' + sub_idx + '_away_rate" value="' + detail.m_fARate + '">';
            div += '<input type="hidden" id="' + sub_idx + '_game_date" value="' + gameDate + '">';
            div += '<input type="hidden" id="' + sub_idx + '_league_sn" value="' + league_sn + '">';
            div += '<input type="hidden" id="' + sub_idx + '_market_name" value="승패">';
            div += '<input type="hidden" id="' + sub_idx + '_home_betid" value="' + detail.m_nHBetCode + '">';
            div += '<input type="hidden" id="' + sub_idx + '_away_betid" value="' + detail.m_nABetCode + '">';
            div += '<input type="hidden" id="' + sub_idx + '_draw_betid" value="' + detail.m_nDBetCode + '">';
            div += '<input type="hidden" id="' + sub_idx + '_home_line" value="' + detail.m_strHLine + '">';
            div += '<input type="hidden" id="' + sub_idx + '_away_line" value="' + detail.m_strALine + '">';
            div += '<input type="hidden" id="' + sub_idx + '_home_name" value="' + detail.m_strHName + '"></div>';
            div += '<div name="' + sub_idx + '">';
            div += '<ul>';
            div += '<li style="margin-bottom:10px;"></li>';
            div += '<li>';
            div += '<div class="type01 1" style="width:8%;">';
            if(!is_child) {
                div += '<span class="time">' + gameDate.substring(5,10) + ' ' + gameHour + ':' + gameTime + '</span>'; 
            }
            div += '</div>';
            div += '<div class="type01 1">';
            if(detail.m_nMarket == 226)
                div += '승패 (연장포함)';
            else 
                div += '승패';
            div += '</div>';
            div += '<div class="bet_area">';
            div += "<div class='" + (is_child ? "child-home" : "home") + " menuOff home-width' name='" + sub_idx + "_div' onclick=onTeamSelected('" + sub_idx + "','0','" + 0 + "','" + detail.m_nHBetCode + "')>";
            div += '<font class="team_name">' + homeTeamName + '</font>';
            div += '<span class="bed" id="' + detail.m_nHBetCode + '">' + detail.m_fHRate.toFixed(2) + '</span>';
            div += `<input type="checkbox" id="${detail.m_nHBetCode}_chk" name="ch" value="1" style="display:none;">`;
            div += '</div>';
        
            div += "<div class='" + (is_child ? "child-draw" : "draw") + " menuOff draw-width' name='" + sub_idx + "_div'>";
            div += "VS";
            div += '<input type="checkbox" name="ch" value="3" style="display:none;"></div>';
        
            div += "<div class='" + (is_child ? "child-away" : "away") + " menuOff away-width' name='" + sub_idx + "_div' onclick=onTeamSelected('" + sub_idx + "','2','" + 0 + "','" + detail.m_nABetCode + "')>";
            div += '<font class="team_name">' + awayTeamName + '</font>';
            div += '<span class="bed" id="' + detail.m_nABetCode + '">' + detail.m_fARate.toFixed(2) + '</span>';
            div += `<input type="checkbox" id="${detail.m_nABetCode}_chk"  name="ch" value="2" style="display:none;"></div>`;
            
            if(!is_child) {
                div += '<div class="toggle-width"><span class="toggle-icon" id="game_title_' + game_sn_code + '" onclick="onExpand(' + game_sn_code + ')">+</span></div>';
            } else {
                div += '<div class="toggle-width" style="border:none; box-shadow: none; background:#222227;"></div>';
            }
            div += '</div></li></ul></div></form>';
            return div;
        }
        
        function div_unover(sport_name, gameDate, gameHour, gameTime, league_sn, detail, is_child, game_sn_code, home_team, away_team, homeTeamName, awayTeamName, sub_idx) {
            var div = "";
            if(is_child === true) {
                div += `<form style="display:none" class="game_form_${game_sn_code}" id="${game_sn_code}_${detail.m_nHBetCode}">`;
            } else {
                div += `<form id="${game_sn_code}_${detail.m_nHBetCode}">`; 
            }
            div += '<div style="display:none">';
            div += '<input type="hidden" id="' + sub_idx + '_sport_name" value="' + sport_name + '">';
            div += '<input type="hidden" id="' + sub_idx + '_game_type" value="' + detail.m_nMarket + '">';
            div += '<input type="hidden" id="' + sub_idx + '_sub_sn"    value="' + sub_idx + '">';
            div += '<input type="hidden" id="' + sub_idx + '_home_team" value="' + home_team + '">';
            div += '<input type="hidden" id="' + sub_idx + '_home_rate" value="' + detail.m_fHRate + '">';
            div += '<input type="hidden" id="' + sub_idx + '_draw_rate" value="' + detail.m_fDRate + '">';
            div += '<input type="hidden" id="' + sub_idx + '_away_team" value="' + away_team + '">';
            div += '<input type="hidden" id="' + sub_idx + '_away_rate" value="' + detail.m_fARate + '">';
            div += '<input type="hidden" id="' + sub_idx + '_game_date" value="' + gameDate + '">';
            div += '<input type="hidden" id="' + sub_idx + '_league_sn" value="' + league_sn + '">';
            div += '<input type="hidden" id="' + sub_idx + '_market_name" value="언더오버">';
            div += '<input type="hidden" id="' + sub_idx + '_home_betid" value="' + detail.m_nHBetCode + '">';
            div += '<input type="hidden" id="' + sub_idx + '_away_betid" value="' + detail.m_nABetCode + '">';
            div += '<input type="hidden" id="' + sub_idx + '_draw_betid" value="' + detail.m_nDBetCode + '">';
            div += '<input type="hidden" id="' + sub_idx + '_home_line" value="' + detail.m_strHLine + '">';
            div += '<input type="hidden" id="' + sub_idx + '_away_line" value="' + detail.m_strALine + '">';
            div += '<input type="hidden" id="' + sub_idx + '_home_name" value="' + detail.m_strHName + '"></div>';
            div += '<div name="' + sub_idx + '">';
            div += '<ul>';
            div += '<li style="margin-bottom:10px;"></li>';
            div += '<li>';
            div += '<div class="type01 1" style="width:8%;">';
            if(!is_child) {
                div += '<span class="time">' + gameDate.substring(5,10) + ' ' + gameHour + ':' + gameTime + '</span>'; 
            }
            div += '</div>';
            div += '<div class="type01 1">';
            if(detail.m_nMarket == 28)
                div += '언더오버 (연장포함)';
            else 
                div += '언더오버';
            div += '</div>';
            div += '<div class="bet_area">';
            div += "<div class='" + (is_child ? "child-home" : "home") + " menuOff home-width' name='" + sub_idx + "_div' onclick=onTeamSelected('" + sub_idx + "','0','" + 0 + "','" + detail.m_nHBetCode + "')>";
            div += '<font class="team_name">' + homeTeamName + '</font>';
            div += '<span class="bed" id="' + detail.m_nHBetCode + '">' + detail.m_fHRate.toFixed(2) + '</span>';
            div += `<input type="checkbox" id="${detail.m_nHBetCode}_chk" name="ch" value="1" style="display:none;">`;
            div += '</div>';
        
            div += "<div class='" + (is_child ? "child-draw" : "draw") + " menuOff draw-width' name='" + sub_idx + "_div'>";
            div += detail.m_strHLine;
            div += '<input type="checkbox" name="ch" value="3" style="display:none;"></div>';
        
            div += "<div class='" + (is_child ? "child-away" : "away") + " menuOff away-width' name='" + sub_idx + "_div' onclick=onTeamSelected('" + sub_idx + "','2','" + 0 + "','" + detail.m_nABetCode + "')>";
            div += '<font class="team_name">' + awayTeamName + '</font>';
            div += '<span class="bed" id="' + detail.m_nABetCode + '">' + detail.m_fARate.toFixed(2) + '</span>';
            div += `<input type="checkbox" id="${detail.m_nABetCode}_chk" name="ch" value="2" style="display:none;"></div>`;
            
            if(!is_child) {
                div += '<div class="toggle-width"><span class="toggle-icon" id="game_title_' + game_sn_code + '" onclick="onExpand(' + game_sn_code + ')">+</span></div>';
            } else {
                div += '<div class="toggle-width" style="border:none; box-shadow: none; background:#222227;"></div>';
            }
            div += '</div></li></ul></div></form>';
            return div;
        }
      
        function div_handi(sport_name, gameDate, gameHour, gameTime, league_sn, detail, is_child, game_sn_code, home_team, away_team, homeTeamName, awayTeamName, sub_idx) {
            var div = "";
            if(is_child === true) {
                div += `<form style="display:none" class="game_form_${game_sn_code}" id="${game_sn_code}_${detail.m_nHBetCode}">`;
            } else {
                div += `<form id="${game_sn_code}_${detail.m_nHBetCode}">`; 
            }
            div += '<div style="display:none">';
            div += '<input type="hidden" id="' + sub_idx + '_sport_name" value="' + sport_name + '">';
            div += '<input type="hidden" id="' + sub_idx + '_game_type" value="' + detail.m_nMarket + '">';
            div += '<input type="hidden" id="' + sub_idx + '_sub_sn"    value="' + sub_idx + '">';
            div += '<input type="hidden" id="' + sub_idx + '_home_team" value="' + home_team + '">';
            div += '<input type="hidden" id="' + sub_idx + '_home_rate" value="' + detail.m_fHRate + '">';
            div += '<input type="hidden" id="' + sub_idx + '_draw_rate" value="' + detail.m_fDRate + '">';
            div += '<input type="hidden" id="' + sub_idx + '_away_team" value="' + away_team + '">';
            div += '<input type="hidden" id="' + sub_idx + '_away_rate" value="' + detail.m_fARate + '">';
            div += '<input type="hidden" id="' + sub_idx + '_game_date" value="' + gameDate + '">';
            div += '<input type="hidden" id="' + sub_idx + '_league_sn" value="' + league_sn + '">';
            div += '<input type="hidden" id="' + sub_idx + '_market_name" value="핸디캡">';
            div += '<input type="hidden" id="' + sub_idx + '_home_betid" value="' + detail.m_nHBetCode + '">';
            div += '<input type="hidden" id="' + sub_idx + '_away_betid" value="' + detail.m_nABetCode + '">';
            div += '<input type="hidden" id="' + sub_idx + '_draw_betid" value="' + detail.m_nDBetCode + '">';
            div += '<input type="hidden" id="' + sub_idx + '_home_line" value="' + detail.m_strHLine + '">';
            div += '<input type="hidden" id="' + sub_idx + '_away_line" value="' + detail.m_strALine + '">';
            div += '<input type="hidden" id="' + sub_idx + '_home_name" value="' + detail.m_strHName + '"></div>';
            div += '<div name="' + sub_idx + '">';
            div += '<ul>';
            div += '<li style="margin-bottom:10px;"></li>';
            div += '<li>';
            div += '<div class="type01 1" style="width:8%;">';
            if(!is_child) {
                div += '<span class="time">' + gameDate.substring(5,10) + ' ' + gameHour + ':' + gameTime + '</span>'; 
            }
            div += '</div>';
            div += '<div class="type01 1">';
            if(sport_name == "배구")
                div += '핸디캡[스코어]';
            else {
                if(detail.m_nMarket == 342)
                    div += '핸디캡 (연장포함)';
                else 
                    div += '핸디캡';
            }
            div += '</div>';
            div += '<div class="bet_area">';
            div += "<div class='" + (is_child ? "child-home" : "home") + " menuOff home-width' name='" + sub_idx + "_div' onclick=onTeamSelected('" + sub_idx + "','0','" + 0 + "','" + detail.m_nHBetCode + "')>";
            div += '<font class="team_name">' + homeTeamName + '</font>';
            div += '<span class="bed" id="' + detail.m_nHBetCode + '">' + detail.m_fHRate.toFixed(2) + '</span>';
            div += `<input type="checkbox" id="${detail.m_nHBetCode}_chk" name="ch" value="1" style="display:none;">`;
            div += '</div>';
        
            div += "<div class='" + (is_child ? "child-draw" : "draw") + " menuOff draw-width' name='" + sub_idx + "_div'>";
            var home_line = detail.m_strHLine.split(" ");
            div += home_line[0];
            div += '<input type="checkbox" name="ch" value="3" style="display:none;"></div>';
        
            div += "<div class='" + (is_child ? "child-away" : "away") + " menuOff away-width' name='" + sub_idx + "_div' onclick=onTeamSelected('" + sub_idx + "','2','" + 0 + "','" + detail.m_nABetCode + "')>";
            div += '<font class="team_name">' + awayTeamName + '</font>';
            div += '<span class="bed" id="' + detail.m_nABetCode + '">' + detail.m_fARate.toFixed(2) + '</span>';
            div += `<input type="checkbox" id="${detail.m_nABetCode}_chk" name="ch" value="2" style="display:none;"></div>`;
            
            if(!is_child) {
                div += '<div class="toggle-width"><span class="toggle-icon" id="game_title_' + game_sn_code + '" onclick="onExpand(' + game_sn_code + ')">+</span></div>';
            } else {
                div += '<div class="toggle-width" style="border:none; box-shadow: none; background:#222227;"></div>';
            }
            div += '</div></li></ul></div></form>';
            return div;
        }
   </script>
</div>