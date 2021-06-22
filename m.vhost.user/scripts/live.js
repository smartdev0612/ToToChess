var live_timer;
var g_timer;
var main_bets_timer;
var time_timer;
var live_list_timer;
var playing_live_list_timer;
var event_num;

////////////////////////////////////////////////////////////////////
//
// live-detail-list
//
////////////////////////////////////////////////////////////////////
function begin_live_listener($event_id)
{
	event_num=$event_id;
	
	live_event_listener();
	live_event_main_bets_listener();
	
	live_timer = window.setInterval("live_event_listener()",5000);
	main_bets_timer = window.setInterval("live_event_main_bets_listener()",10000);
	time_timer = window.setInterval("event_timer_listener()",1000);
	
	return time_timer;
}

function end_live_listener()
{
	clearInterval(live_timer);
	clearInterval(time_timer);
	clearInterval(main_bets_timer);
}

function event_timer_listener()
{
	var live_time = $('.harf').text();
	
	var live_time = live_time.split(" ");
	var time = live_time[1];
	
	if(time=='' || time==null)
		return true;
	
	times = time.split(":");
	
	var min = parseInt(times[0]);
	var sec = parseInt(times[1])+1;
	
	if( sec>=60) 
	{
		min+=1; 
		sec = sec%60;
	}
	if(sec<=9) 	sec = "0"+sec;
	if(min<=9) min = "0"+min;
	
	$('.harf').text(live_time[0]+" "+min+":"+sec);
}

function live_event_listener()
{
	$.ajax({
		type: "POST",
		url:"/LiveGame/live_game_listener",
		dataType: "json",
		data : {event_id:event_num},
		success : function(json) {
			if(json==null || json.length<=0)
			{
				return true;
			}
				
			var games = json;
			
			var broadcast_html = '';
			
			g_home_team = eval("home_team");
			g_away_team = eval("away_team");
			
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
							if(odd_text=='Even') odd_text='짝';
							if(odd_text=='Odd') odd_text='홀';
							
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
	
	playing_live_games();
}

function live_event_main_bets_listener()
{
	$.ajax({
		type: "POST",
		url:"/LiveGame/live_main_bets_listener",
		dataType: "json",
		data : {event_id:event_num},
		success : function(json) {
			if(json!='')
			{
				if(json==null || json.length<=0)
					return true;
					
				var event = json;
				$('.score > p').html('<span>'+event.score[0][0]+' : '+event.score[1][0]+'</span>');
				$('#time_state').html(event.period+' '+event.elasped);
				//alert($('#time_state').text());
			}
		}
	});
}

function playing_live_games()
{
	$.ajax({
		type: "POST",
		url:"/LiveGame/ajax_playing_live_games",
		dataType: "json",
		data : {event_id:event_num},
		success : function(json) {
			if(json!='')
			{
				if(json==null || json.length<=0)
					return true;

					
				var events = json;
				$('#wrap_livelist').empty();
			
				
				for(var i=0; i<events.length; ++i)
				{
					var start_time = events[i].start_time;
					var elasped = lapseT(start_time);
					var period = events[i].state;
					if(period=='FH') 
					{
						period = '전반전';
					} 
					else if(period=='HT') 
					{
						period = '하프타임';
					} 
					else 
					{
						period = '후반전';
					}
					
					var data = "<li><a href='/LiveGame/detail?event_id="+events[i].event_id+"'><b>"+events[i].home_team+" VS "+events[i].away_team+"<span> ["+period+"]  "+events[i].current_score+"</b></span></a></li>";
					$('#wrap_livelist').prepend(data);
					$('#wrap_livelist').fadeIn();
				}
			}
		}
	});
}

function split_odd($str)
{
	var tokens = $str.split(";");
	var array = new Array();

	for(var i=0; i<tokens.length-1; ++i)
	{
		var token = tokens[i].split(":");
		array[ i] = new Array(2);
		array[ i][0] = token[0];
		array[ i][1] = token[1];
	}
	
	return array;
}

////////////////////////////////////////////////////////////////////
//
// live-list
//
////////////////////////////////////////////////////////////////////
function begin_live_list_listener()
{
	live_list_event_main_bets_listener();
	main_bets_timer = window.setInterval("live_list_event_main_bets_listener()",10000);
	live_list_timer = window.setInterval("live_list_event_timer_listener()",1000);
}

function end_live_list_listener()
{
	clearInterval(main_bets_timer);
	clearInterval(live_list_timer);
}

function live_list_event_main_bets_listener()
{
	$.ajax({
		type: "POST",
		url:"/LiveGame/live_list_main_bets_listener",
		dataType: "json",
		success : function(json) {
			if(json!='')
			{
				if(json==null || json.length<=0)
					return true;
					
				var events = json;
				
				for(var i=0; i<events.length; ++i)
				{
					var event = events[i];
					var event_id = event.event_id;
					var state = event.state;
					
					if( state=='READY')
					{
						/*
						if($('#'+event_id+'_tr_timer .timer').length >0) 
						{
							$('#'+event_id+'_tr_timer .timer').remove();
						}
						*/
					}
					else
					{
						if($('#'+event_id+'_tr_score .score').length>0)
						{
							$('#'+event_id+'_tr_score .score').html('<span>' +event.score+'</span>');
							$('#'+event_id+'_tr_score .gameamount').html("<a href='/LiveGame/detail?event_id="+event_id+"'>+"+event.template_cnt+"</a>");
						}
					}
					/*
					if(state!='READY' && $('#'+event_id+'_tr_timer .timer').length >0) {
						$('#'+event_id+'_tr_timer .timer').remove();
						$('#'+event_id+'_tr_timer').append("<td valign='top' class='score'>-</td>");
						$('#'+event_id+'_tr_timer').append("<td class='gameamount'><a href='/LiveGame/detail?"+event_id+"={item.event_id}'>-</a>");
					}
					if($('#'+event_id+'_tr_score .score').length>0)
					{
						$('#'+event_id+'_tr_score .score').html('<span>' +event.score+'</span>');
						$('#'+event_id+'_tr_score .gameamount').html("<a href='/LiveGame/detail?event_id="+event_id+"'>+"+event.template_cnt+"</a>");
					}
					*/
				}
			}
		}
	});
}

function live_list_event_timer_listener()
{
	$('.remain_timer').each( function(index) {
		var start_time= $(this).parent().prev().text();
		//alert(start_time);
		if( start_time.length > 0)
		{
			var elasped = lapseT(start_time);
			if(elasped!='시작대기')
				$(this).text(elasped);
		}
	});
}

function lapseT(start_time)
{
	var year = parseInt(start_time.substr(0, 4));
	var month = parseInt(start_time.substr(5, 2))-1;
	var day = parseInt(start_time.substr(8, 2));
	var hour = parseInt(start_time.substr(11, 2));
	var min = parseInt(start_time.substr(14, 2));
	var sec = parseInt(start_time.substr(17, 2));
	
	var sTime = new Date(year, month, day, hour, min, sec).getTime();
	var nTime = new Date();    //이 함수를 실행하는 순간의 시간 즉, 매 초마다 갱신되는 시간 
	var ndTime = nTime.getTime();	
	K = sTime-ndTime ;  //현재시간에서 페이지를 로드한 시간을 뺀다. 
	
	if(K<=0)
		return '시작대기';
	
	H = Math.floor(K/(1000*60*60)%24);      //그 값은 밀리초단위이므로 
	M = Math.floor((K/(1000*60))%60);      //초로바꾸려면 1000으로, 분으로 바꾸려면 1000*60으로 
	S = Math.floor((K/(1000))%60);          //시간으로 바꾸려면 1000*60*60으로 나누어 주어야 함. 
	
	H = (H>=10)?H:"0"+H; 
	M = (M>=10)?M:"0"+M; 
	S = (S>=10)?S:"0"+S; 
 
	return H + '시 ' + M + '분 ' + S + '초'; 
} 
