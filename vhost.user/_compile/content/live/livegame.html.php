<link rel="stylesheet" type="text/css" href="/include/css/live.css?v=<?=time();?>"/>
<script type="text/javascript" src="/include/js/live.js"></script>
<script type="text/javascript" src="/include/js/live_betting.js"></script>
<script language="javascript" src="/include/js/jquery.mousewheel.js"></script>
<script language="javascript" src="/include/js/jquery.jscrollpane.min.js"></script>
<script language="javascript" src="/include/js/jquery.slides.js"></script>
<script>
	$(window).unload(function() {
		end_live_listener();
	});
</script>
<script>
	begin_live_listener(<?php echo $TPL_VAR["event_id"]?>);
	live_betting_initialize(<?php echo $TPL_VAR["games"]['live_sn']+0?>, '<?php echo $TPL_VAR["games"]['home_team']?>', '<?php echo $TPL_VAR["games"]['away_team']?>', <?php echo $TPL_VAR["min_betting_money"]?>, <?php echo $TPL_VAR["max_betting_money"]?>, <?php echo $TPL_VAR["max_prize_money"]?>);
</script>
<!--
		<ul id="gamelist_tab">
			<li class="soccer"><a href="javascript:void();" class="on"><span>SOCCER</span></a></li>
		</ul>
-->
		<div id="body_livegame_sub">
			<?php $this->print_("template_list",$TPL_SCP,1);?>
		</div>

		<div id="body_livegame">			
			<div id="wrap_livescore">
				<ul class="gameinfo_home">
					<li class="goal">-</li>
					<li class="red">-</li>
					<li class="yell">-</li>
					<li>-</li>
					<li>-</li>
				</ul>
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
				<ul class="gameinfo_away">
					<li class="goal">-</li>
					<li class="red">-</li>
					<li class="yell">-</li>
					<li>-</li>
					<li>-</li>
				</ul>
				<div id="wrap_livegameinfo">
					<div id="livegameinfo">
						<p><span class="time"></span><span class="term"></span><span class="info"></span></p>
					</div>
					<p class="btn"><img src="/images/live/livecenter_btn_down.gif"><img src="/images/live/livecenter_btn_data.gif"></p>
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