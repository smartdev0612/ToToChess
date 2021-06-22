<?php /* Template_ 2.2.3 2014/04/28 19:00:26 D:\www\m.vhost.user\_template\content\live\live_game_detail.html */?>
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


<style type="text/css">
	<!-- 
	#tmenu .soccer a
	{background-position:0px -29px}
	-->
</style>

	<div id="wrap_body">
		<h2 class="blind">³»¿ë</h2>

		<div id="livegame_bg">
		
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
				
				<ul id="wrap_livegamelist"  style="overflow-y:auto">
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
	</div>

<script language=javascript>
	initialize(<?php echo $TPL_VAR["minBetCount"]?>,
							<?php echo $TPL_VAR["folderBonus"]["bonus3"]?>,
							<?php echo $TPL_VAR["folderBonus"]["bonus4"]?>,
							<?php echo $TPL_VAR["folderBonus"]["bonus5"]?>,
							<?php echo $TPL_VAR["folderBonus"]["bonus6"]?>,
							<?php echo $TPL_VAR["folderBonus"]["bonus7"]?>,
							<?php echo $TPL_VAR["folderBonus"]["bonus8"]?>,
							<?php echo $TPL_VAR["folderBonus"]["bonus9"]?>,
							<?php echo $TPL_VAR["folderBonus"]["bonus10"]?>,
							<?php echo $TPL_VAR["singleMaxBetMoney"]?>

						);
				
	var VarMoney 		= '<?php echo $TPL_VAR["cash"]?>';
	var VarMinBet 		= '<?php echo $TPL_VAR["betMinMoney"]?>';
	var VarMaxBet 		= '<?php echo $TPL_VAR["betMaxMoney"]?>';
	var VarMaxAmount 	= '<?php echo $TPL_VAR["maxBonus"]?>';
	
  var bettingendtime =<?php echo $TPL_VAR["betEndTime"]?>;
  var bettingcanceltime =<?php echo $TPL_VAR["betCancelTime"]?>;
  var bettingcancelbeforetime =<?php echo $TPL_VAR["betCancelBeforeTime"]?>;
  /*
	var betlist='<?=$_SESSION["betlist"]?>';
	if(betlist!="") {addSessionList(betlist, '<?php echo $TPL_VAR["mode"]?>');}
	*/
</script>

	<div class="wrap_fixedmenu">
<?php $this->print_("right",$TPL_SCP,1);?>

	</div>