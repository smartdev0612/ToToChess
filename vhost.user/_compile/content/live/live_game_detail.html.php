<?php /* Template_ 2.2.3 2014/02/26 19:37:58 D:\www_kd_20140905\vhost.user\_template\content\live\live_game_detail.html */?>
<script language="javascript" src="/scripts/live.js"></script>
<script language="javascript" src="/scripts/live_betting.js"></script>
<script src="/scripts/jBeep.min.js" type="text/javascript"></script>
<script>
	$(window).unload(function() {
		end_live_listener();
	});
</script>
<script>begin_live_listener(<?php echo $TPL_VAR["event_id"]?>);</script>
<script>live_betting_initialize(<?php echo $TPL_VAR["games"]['live_sn']?>, '<?php echo $TPL_VAR["games"]['home_team']?>', '<?php echo $TPL_VAR["games"]['away_team']?>', <?php echo $TPL_VAR["min_betting_money"]?>, <?php echo $TPL_VAR["max_betting_money"]?>, <?php echo $TPL_VAR["max_prize_money"]?>);</script>

	<div id="wrap_body">
		<h2 class="blind">내용</h2>
		<div id="subvisual" class="subvisual_betlist">
			<h3><img src="/images/title_soccer.gif"></h3>
		</div>
		
		<div id="body">
			
			<!-- class 설명 : 원하는 종목명을 class에 삽입하면 종목에 맞춰 배경 변경됨. 현재 basketball, tennis 구현됨. 차후 인기 종목 위주로 늘려갈 예정 -->
			<div id="wrap_livescore">
				<div class="soccer">
					<p class="league"><?php echo $TPL_VAR["games"]['league_name']?></p>
					<ul>
						<li class="home"><b><?php echo $TPL_VAR["games"]['home_team']?></b></li>
						<li class="score">
							<p><span>- : -</span></p>
							<span class="harf"></span>
						</li>
						<li class="away"><b><?php echo $TPL_VAR["games"]['away_team']?></b></li>
					</ul>
				</div>
				
				<ul id="wrap_livegamelist">
					<li>
						<span class="league"></span>
						<span class="info"></span>
					</li>
				</ul>
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
<?php $this->print_("right",$TPL_SCP,1);?>

	</div>