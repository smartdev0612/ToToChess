<?php /* Template_ 2.2.3 2014/10/25 00:16:16 D:\www_one-23.com\m.vhost.user\_template\content\live\livegame.html */?>
<script language="javascript" src="/scripts/jquery.js"></script>
<script language="javascript" src="/scripts/jquery.mousewheel.js"></script>
<script language="javascript" src="/scripts/jquery.jscrollpane.min.js"></script>
<script>
	$(window).unload(function() {
		end_live_listener();
	});
</script>
<script>begin_live_listener(<?php echo $TPL_VAR["event_id"]?>);</script>
<script>live_betting_initialize(<?php echo $TPL_VAR["games"]['live_sn']?>, '<?php echo $TPL_VAR["games"]['home_team']?>', '<?php echo $TPL_VAR["games"]['away_team']?>', <?php echo $TPL_VAR["min_betting_money"]?>, <?php echo $TPL_VAR["max_betting_money"]?>, <?php echo $TPL_VAR["max_prize_money"]?>);</script>


<script language="javascript" type="text/javascript" src="/scripts/jquery.slides.js"></script>
<script language="javascript" type="text/javascript">
	$(function () {
		$('#slides').slidesjs({
			width: 950,
			height: 144,
			navigation: {
				effect: "fade"
				//active:false
			},
			pagination: {
				active: true,
				effect: "fade"
			},
			effect: {
				fade: {
					speed: 800,
					crossfade: true
				}
			},
			play: {
				active: true,
				effect: "fade",
				interval: 5000,
				auto: true,
				swap: true,
				pauseOnHover: false,
				restartDelay: 2500
			},
			callback: {
//                    complete: function (number) {
//                        
//                        $(".slidesjs-control a").each(function () {
//                            if ($(this).css("display") == "none") {
//                                
//                            }
//                        });
//                    }
			}
		});

	});
</script>


		<div id="subvisual" class="subvisual_livegame">
			<h3><img src="/img/title_live.gif"></h3>
			<div id="slides"><img src="/img/subvisual_live1.jpg"><img src="/img/subvisual_live2.jpg"><img src="/img/subvisual_live3.jpg"><img src="/img/subvisual_live4.jpg"></div>
		</div>
		<ul id="gamelist_tab">
			<!-- 해당 경기 목록 선택시 a에 class="on" 처리 / 이 방식이 여의치 않을 경우 다른 방식으로 html코딩 예정-->
			<li class="soccer"><a href="javascript:void();" class="on"><span>SOCCER</span></a></li>
		</ul>
		
		<div id="body_livegame_sub">
			<!--
			<dl id="wrap_favorite">
				<dt><h4>즐겨찾기</h4></dt>
				<dd class="empty">각 경기의 오른쪽의 별 마크를 클릭하여 즐겨찾기에 추가 가능합니다.</dd>
				<dd>
					<ul>
						<li class="league">프리미어리그<a href="javascript:void();" onclick="#">즐겨찾기</a></li>
						<li class="home"><a href="#">맨체스터</a></li><li class="score"><?php if($TPL_VAR["item"]["state"]=='READY'){?>VS<?php }else{?>-<?php }?></li><li class="away"><a href="#">첼시</a></li>
					</ul>
				</dd>
				<dd>
					<ul>
						<li class="league">프리미어리그<a href="javascript:void();" onclick="#">즐겨찾기</a></li>
						<li class="home"><a href="#">맨체스터</a></li><li class="score"><?php if($TPL_VAR["item"]["state"]=='READY'){?>VS<?php }else{?>-<?php }?></li><li class="away"><a href="#">첼시</a></li>
					</ul>
				</dd>
			</dl>
			-->
<?php $this->print_("template_list",$TPL_SCP,1);?>

		</div>
		<div id="body_livegame">
			
			<div id="wrap_livescore">
				<div class="soccer">
					<p class="league"><?php echo $TPL_VAR["games"]['league_name']?></p>
					<ul>
						<li class="home"><b><?php echo $TPL_VAR["games"]['home_team']?></b></li>
						<li class="score">
							<p><span>- : -</span></p>
							<span id="time_state" class="harf">-</span>
						</li>
						<li class="away"><b><?php echo $TPL_VAR["games"]['away_team']?></b></li>
					</ul>
				</div>
				<ul class="gameinfo_home">
					<li>홈팀 정보</li>
					<li class="goal">골 -</li>
					<li class="red">퇴장 -</li>
					<li class="yell">경고 -</li>
					<li class="crnr">코너킥 -</li>
					<li class="offsd">오프사이드 -</li>
				</ul>
				<ul class="gameinfo_away">
					<li>원정팀 정보</li>
					<li class="goal">골 -</li>
					<li class="red">퇴장 -</li>
					<li class="yell">경고 -</li>
					<li class="crnr">코너킥 -</li>
					<li class="offsd">오프사이드 -</li>
				</ul>
				<div id="wrap_livegameinfo">
					<div id="livegameinfo">
						<p><span class="time"></span><span class="term"></span><span class="info"></span></p>
					</div>
					<p class="btn"><img src="/img/livecenter_btn_down.gif"><img src="/img/livecenter_btn_data.gif"></p>
				</div>
			</div>

			<form name="frm_betting" id="frm_betting">
				<div class="wrap_livegame">
					<!-- /content/live/template_main_bets.html -->
<?php $this->print_("template_main_bets",$TPL_SCP,1);?>

					<!-- /content/live/template_goal_bets.html -->
<?php $this->print_("template_goal_bets",$TPL_SCP,1);?>

				</div>
			</form>
		</div>
		
<script language=javascript>
	var home_team 		= "<?php echo $TPL_VAR["games"]['home_team']?>";
	var away_team 		= "<?php echo $TPL_VAR["games"]['away_team']?>";
</script>