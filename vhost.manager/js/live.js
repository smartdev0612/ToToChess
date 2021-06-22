var g_live_game_list_timer;

////////////////////////////////////////////////////////////////////
//
// live-game-list
//
////////////////////////////////////////////////////////////////////
function begin_live_game_list()
{
	live_game_list_listener();
	g_live_game_list_timer = window.setInterval("live_game_list_listener()", 30000);
}

function end_live_game_list()
{
	clearInterval(g_live_game_list_timer);
}

function live_game_list_listener()
{
	$.ajax({
		type: "POST",
		url:"/LiveGame/live_game_list_listener",
		dataType: "json",
		data : {event_id:event_num},
		success : function(json) {
			if(json==null || json.length<=0)
			{
				location.href="/LiveGame/list";
				return true;
			}
				
			var games = json;
			
			var broadcast_html = '';
			
			if(games.broadcast!=null)
			{
				for(var i=0; i<games.broadcast.length; ++i)
				{
					broadcast_html += '<b>'+games.broadcast[ i].timer+'</b> '+games.broadcast[ i].content;
					broadcast_html += '<br>';
				}
				$('.info').html(broadcast_html);
			}

			if(games.item!=null && games.item.length>0)
			{	
				var temp='';
				for(var i=0; i<games.item.length; ++i) {
					var game = games.item[i];
					var template = game.template;
					var is_visible = game.is_visible;
					
					if($('#template_'+template).length!==0)
					{
						if(is_visible==1)	$('#template_'+template).show();
						else 		$('#template_'+template).hide();
						
						var odds = game.token_odds;
						
						$('#templateA_'+template).text(game.alias);
						for(var j=0; j<odds.length; ++j)
						{
							var odd_name = odds[j][0];
							var odd = odds[j][1];
							var odd_flag = odds[j][2];
							
							var odd_text = odd_name;
							if(odd_text=='1') odd_text=g_home_team;
							if(odd_text=='2') odd_text=g_away_team;
							if(odd_text=='X') odd_text='무승부';
							
							$('#templateN_'+template+'_'+odd_name).text(odd_text);
							$('#template_'+template+'_'+odd_name).text(odd);
							if(odd_flag==-1)
								$('#templateF_'+template+'_'+odd_name).attr('class', 'down');
							else if(odd_flag==1)
								$('#templateF_'+template+'_'+odd_name).attr('class', 'up');
								
							if(odd=="1.00") 
								$('#templateN_'+template+'_'+odd_name).parent().parent().attr('class', 'score end');
						}
					}
				}
			}
		}
	});
}