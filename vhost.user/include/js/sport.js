var bettingSubmitFlag = 0;
var matchGameWinOver = 0;
var matchGameLoseOver = 0;
var matchGameFbWinOver = 0;
var matchGameFbLoseUnder = 0;
var matchGameFbLoseOver = 0;
var matchGameFbWinloseUnover = 0;

var matchGameWinUnder = 0;
var matchGameLoseUnder = 0;
var matchGameFbWinUnder = 0;

var matchGameBbFtsFfs = 0;

var page_special_type = 0;
var betcon= new Array();
 
var m_min_count = 1;
var m_bonus3	= 0;
var m_bonus4	= 0;
var m_bonus5	= 0;
var m_bonus6	= 0;
var m_bonus7	= 0;
var m_bonus8	= 0;
var m_bonus9	= 0;
var m_bonus10	= 0;
var m_single_max_bet = 0;

var m_betList 	= new BetList();

var timer;
var waiting = 7;

Array.prototype.remove = function(from, to)
{
	var rest = this.slice((to || from)+1 || this.length);
	this.length = from<0 ? this.length+from : from;
	return this.push.apply(this, rest);
}

Array.prototype.indexOf = function(v)
{
	 if(v==null)
	 {
		return -1;
	 }
	 else
	 {
		  var j= -1;
		  for(var i=0;i<this.length;i++)
		  {
			   if(this[i]==v)
			   {
					j=i;
					break;
			   }
		  }
		  return j;
	 }
}
Array.prototype.del_element = function(v)
{
	var v_index = this.indexOf(v);
	if(v_index>-1)
	{
		if(v_index==this.length-1)
		{
			return this.slice(0,v_index);
		}
		else if(v_index==0)
		{
			return this.slice(v_index+1,this.length);
		}
		else
		{
			return this.slice(0,v_index).concat(this.slice(v_index+1,this.length));
		}
	}
	else
	{
		return this;
	}
}
Array.prototype.add_element=function(v)
{
	var betcon2=this;
	var arrsrc=v.split("|");
	for(var i=0;i<this.length;i++)
	{
		var arrobj=this[i].split("|");
		if(arrsrc[0]==arrobj[0])
		{
			betcon2 = betcon2.del_element(this[i]);
			break;
		}
	}

	betcon2.push(v);
	return betcon2;
}

Array.prototype.del_one=function(m)
{
	var betcon2=this;
	var arrsrc=m;
	for(var i=0;i<this.length;i++)
	{
		var arrobj=this[i].split("|");
		if(arrsrc==arrobj[0])
		{
			betcon2 = betcon2.del_element(this[i]);
			break;
		}
	}
	return betcon2;
}

function initialize($min, $bonus3, $bonus4, $bonus5, $bonus6, $bonus7, $bonus8, $bonus9, $bonus10, $single_max_bet) {
	m_min_count = $min;
	m_bonus3	= $bonus3;
	m_bonus4	= $bonus4;
	m_bonus5	= $bonus5;
	m_bonus6	= $bonus6;
	m_bonus7	= $bonus7;
	m_bonus8	= $bonus8;
	m_bonus9	= $bonus9;
	m_bonus10	= $bonus10;
	m_single_max_bet = $single_max_bet;
}

/* ?????????
 * Update Checkbox Attribute and BackGround Css
 * return : 'inserted' or 'deleted'
 */
function toggle($tr, $index, selectedRate)
{
	var toggle_action = "";
	
	$j('div[name='+$tr+'] input').each( function(index) {
		if(index!=$index)
		{
			this.checked=false;
		}
	});
	
	//toggle checkbox
	$selectedCheckbox = $j('div[name='+$tr+'] input:checkbox:eq('+$index+')');
	if(($selectedCheckbox).is(":checked")==true) 
	{
		$selectedCheckbox.attr("checked", false);
		toggle_action = 'deleted';
	}
	else
	{
		//????????? ??????(10???)
		if(isMaxGameCount()==true)
		{
			warning_popup("?????? 10???????????? ??????????????? ????????????.");
			return false;
		}

		//100?????? ????????? ?????? ?????? ??????		
		else if(m_betList._bet*selectedRate>=100)
		{
			warning_popup("????????? ????????? 100?????? ????????? ????????? ????????? ?????????.");
			return false;
		}

		else
		{
			$selectedCheckbox.prop("checked", true);
			toggle_action = 'inserted';
		}
	}
	// console.log(toggle_action);
	//change css class
	$j('div[name='+$tr+'] input:checkbox').each(function(index)
	{
		if(this.checked==true) 
		{
			$j(this).parent().addClass('on');
		}
		else
		{
			$j(this).parent().removeClass('on');
		}
	});
	
	return toggle_action;
}

/* ?????????
 * Update Checkbox Attribute and BackGround Css
 * return : 'inserted' or 'deleted'
 */
function toggle_multi($tr, $index, selectedRate, crossLimitCnt = 0)
{ 
	var toggle_action = "";
	var pieces = $tr.split("_div");
	var game_index = pieces[0];
	var parts = game_index.split("_");
	var gameSn = parts[0];
	var market_id = parts[1];
	var family_id = parts[2];
	
	if(m_betList._items.length > 0) {
		for(i = 0; i < m_betList._items.length; ++i)
		{
			var temps = m_betList._items[i]._game_index.split("_");
			var temp_game_sn = temps[0];
			var temp_market_id = temps[1];
			var temp_family_id = temps[2];
			var temp_game_index = m_betList._items[i]._game_index;

			if(crossLimitCnt > 0) {
				if(game_index != temp_game_index) {
					if(family_id == 11 && temp_family_id == 11) { // || family_id == 7 || family_id == 8 || family_id == 47
						del_bet(temp_game_index);
					} else if (temp_family_id == 7 || temp_family_id == 8 || temp_family_id == 47) {
						if(gameSn == temp_game_sn && market_id == temp_market_id && family_id == temp_family_id) {
							del_bet(temp_game_index);
						}
					}
				}
			} else {
				if(m_betList._items[i]._game_index != game_index) {
					if(gameSn == temp_game_sn) {
						del_bet(temp_game_index);
					}
				}
			}
		}
	}

	if(crossLimitCnt == 0) {
		var selected_betid = 0;
		if(m_betList._items.length > 0) {
			for(i = 0; i < m_betList._items.length; ++i)
			{
				var temps = m_betList._items[i]._game_index.split("_");
				if(m_betList._items[i]._game_index == game_index) {
					if($index == 0) 
						selected_betid = m_betList._items[i]._home_betid;
					else if($index == 1)
						selected_betid = m_betList._items[i]._draw_betid;
					else if($index == 2)
						selected_betid = m_betList._items[i]._away_betid;
				}
					
			}
		}
		
		if(localStorage.getItem(`selected_${selected_betid}`) !== null) {
			$j('div[name='+$tr+'] input:checkbox:eq('+$index+')').prop("checked", true);
		}
	}
	

	$j('div[name='+$tr+'] input:checkbox').each( function(index) {		
		if(index != $index) { 
			this.checked=false;
		}
	});
	
	//toggle checkbox
	$selectedCheckbox = $j('div[name='+$tr+'] input:checkbox:eq('+$index+')');
	
	if(($selectedCheckbox).is(":checked")==true) 
	{
		console.log("Checked False");

		$selectedCheckbox.prop("checked", false);
		toggle_action = 'deleted';
	}
	else
	{
		//????????? ??????(10???)
		if(isMaxGameCount()==true)
		{
			warning_popup("?????? 10???????????? ??????????????? ????????????.");
			return false;
		}

		//100?????? ????????? ?????? ?????? ??????		
		else if(m_betList._bet*selectedRate>=100)
		{
			warning_popup("????????? ????????? 100?????? ????????? ????????? ????????? ?????????.");
			return false;
		}

		else
		{
			console.log("Checked True");

			$selectedCheckbox.prop("checked", true);
			toggle_action = 'inserted';
		}
	}
	
	//change css class
	$j('div[name='+$tr+'] input:checkbox').each(function(index)
	{  
		if(this.checked==true) 
		{
			$j(this).parent().addClass("on");
			var chk_id = $j(this).attr('id');
			var betid = 0;
			if(chk_id !== undefined) {
				var pieces = chk_id.split("_");
				betid = pieces[0];
			}
			
			if(localStorage.getItem(`selected_${betid}`) === null)
                localStorage.setItem(`selected_${betid}`, betid);
		}
		else
		{ 
			$j(this).parent().removeClass("on");
			var chk_id = $j(this).attr('id');
			var betid = 0;
			if(chk_id !== undefined) {
				var pieces = chk_id.split("_");
				betid = pieces[0];
			}

			if(localStorage.getItem(`selected_${betid}`) !== null)
                localStorage.removeItem(`selected_${betid}`);
		}
	});
	
	return toggle_action;
}

function isMaxGameCount()
{
	return (getBetCount()>=10);
}

function DalPaingYcheckRule($game_date)
{
	for(i=0; i<m_betList._items.length;++i)
	{
		var item = m_betList._items[i];
		if ( item._game_date != $game_date ) {
			return 0;
		}
	}
	return 1;
}

function bonus_in_check() {
	if ( m_betList._items.length >= 3 ) {
		return 1;
	} else {
		return 0;
	}
}

function check_single_only() {
	if ( m_betList._items.length > 1 ) {
		return 0;
	} else {
		return 1;
	}
}

//??????????????????(?????????) ???????????? ?????? ??????
function CheckRule_samegame($game_index, $sport_name, $checkbox_index, $game_type, $home_team, $away_team) {
	for(var i=0; i<m_betList._items.length;++i)
	{
		var item = m_betList._items[i];
		console.log(item);
		switch($sport_name) {
			case "??????":
				if($game_type==1 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && (item._game_type==2 || item._game_type==3 || item._game_type==4 || item._game_type==5 
						|| item._game_type==6 || item._game_type==7 || item._game_type==8 || item._game_type==9 || item._game_type==10) && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
					{
						return 0;
					}
				} else if($game_type==2 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && (item._game_type==1 || item._game_type==3 || item._game_type==4 || item._game_type==5 
						|| item._game_type==6 || item._game_type==7 || item._game_type==8 || item._game_type==9 || item._game_type==10) && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
					{
						return 0;
					}
				} else if($game_type==3 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && (item._game_type==2 || item._game_type==1 || item._game_type==4 || item._game_type==5 
						|| item._game_type==6 || item._game_type==7 || item._game_type==8 || item._game_type==9 || item._game_type==10) && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
					{
						return 0;
					}
				} else if($game_type==4 && ($checkbox_index==0 || item._checkbox_index==1 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && (item._game_type==2 || item._game_type==3 || item._game_type==1 || item._game_type==5 
						|| item._game_type==6 || item._game_type==7 || item._game_type==8 || item._game_type==9 || item._game_type==10) && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
					{
						return 0;
					}
				} else if($game_type==5 && ($checkbox_index==0 || item._checkbox_index==1 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && (item._game_type==2 || item._game_type==3 || item._game_type==4 || item._game_type==1 
						|| item._game_type==6 || item._game_type==7 || item._game_type==8 || item._game_type==9 || item._game_type==10) && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
					{
						return 0;
					}
				} else if($game_type==6 && ($checkbox_index==0 || item._checkbox_index==1 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && (item._game_type==2 || item._game_type==3 || item._game_type==4 || item._game_type==5 
						|| item._game_type==1 || item._game_type==7 || item._game_type==8 || item._game_type==9 || item._game_type==10) && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
					{
						return 0;
					}
				} else if($game_type==7 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && (item._game_type==2 || item._game_type==3 || item._game_type==4 || item._game_type==5 
						|| item._game_type==6 || item._game_type==1 || item._game_type==8 || item._game_type==9 || item._game_type==10) && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
					{
						return 0;
					}
				} else if($game_type==8 && ($checkbox_index==0 || $checkbox_index==2))
				{ 

					if(item._home_team==$home_team && item._away_team==$away_team && (item._game_type==2 || item._game_type==3 || item._game_type==4 || item._game_type==5 
						|| item._game_type==6 || item._game_type==7 || item._game_type==1 || item._game_type==9 || item._game_type==10) && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
					{
						return 0;
					}
				} else if($game_type==9 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && (item._game_type==2 || item._game_type==3 || item._game_type==4 || item._game_type==5 
						|| item._game_type==6 || item._game_type==7 || item._game_type==8 || item._game_type==1 || item._game_type==10) && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
					{
						return 0;
					}
				} else if($game_type==10 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && (item._game_type==2 || item._game_type==3 || item._game_type==4 || item._game_type==5 
						|| item._game_type==6 || item._game_type==7 || item._game_type==8 || item._game_type==9 || item._game_type==1) && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
					{
						return 0;
					}
				}
				break;
			case "??????":
				if($game_type==1 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==9 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==10 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==11 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==12 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==13 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==14 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==15 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==2 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==9 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==10 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==11 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==12 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==13 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==14 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==15 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==3 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==9 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==10 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==11 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==12 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==13 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==14 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==15 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==4 && ($checkbox_index==0 || item._checkbox_index==1 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==9 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==10 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==11 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==12 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==13 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==14 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==15 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==5 && ($checkbox_index==0 || item._checkbox_index==1 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==9 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==10 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==11 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==12 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==13 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==14 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==15 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==6 && ($checkbox_index==0 || item._checkbox_index==1 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==9 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==10 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==11 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==12 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==13 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==14 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==15 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==7 && ($checkbox_index==0 || item._checkbox_index==1 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==9 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==10 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==11 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==12 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==13 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==14 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==15 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==8 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==9 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==10 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==11 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==12 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==13 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==14 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==15 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==9 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==10 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==11 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==12 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==13 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==14 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==15 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==10 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==9 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==11 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==12 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==13 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==14 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==15 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==11 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==9 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==10 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==12 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==13 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==14 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==15 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==12 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==9 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==10 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==11 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==13 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==14 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==15 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==13 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==9 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==10 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==11 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==12 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==14 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==15 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==14 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==9 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==10 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==11 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==12 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==13 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==15 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==15 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==9 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==10 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==11 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==12 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==13 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==14 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				}
				break;
			case "??????":
				if($game_type==1 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==2 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==3 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==4 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==5 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				}
				break;
			case "??????":
				if($game_type==1 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==9 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==10 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==2 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==9 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==10 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==3 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==9 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==10 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==4 && ($checkbox_index==0 || item._checkbox_index==1 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==9 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==10 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==5 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==9 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==10 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==6 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==9 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==10 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==7 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==9 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==10 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==8 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==9 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==10 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==9 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==10 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==10 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==9 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				}
				break;
			case "??????":
				if($game_type==1 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==2 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==3 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==4 && ($checkbox_index==0 || item._checkbox_index==1 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==5 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==6 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==1 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==7 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==8 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				} else if($game_type==8 && ($checkbox_index==0 || $checkbox_index==2))
				{
					if(item._home_team==$home_team && item._away_team==$away_team && ((item._game_type==2 && (item._checkbox_index==0 || item.__checkbox_index==2))
						|| (item._game_type==3 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==4 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==5 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==6 && (item._checkbox_index==0 || item._checkbox_index==1 || item.__checkbox_index==2))
						|| (item._game_type==7 && (item._checkbox_index==0 || item.__checkbox_index==2)) || (item._game_type==1 && (item._checkbox_index==0 || item.__checkbox_index==2))))
					{
						return 0;
					}
				}
				break;
		}
		
		// if(item._home_team==$home_team && item._away_team==$away_team)
		// {
		// 	return 0;
		// }
	}
	return 1;
}

// ??????+??????
function CheckRule_wl_over($game_index, $checkbox_index, $game_type, $home_team, $away_team) {

	for(var i=0; i<m_betList._items.length;++i)
	{
		if($game_type==1 && ($checkbox_index==0 || $checkbox_index==2))
		{
			var item = m_betList._items[i];
			if(item._home_team==$home_team && item._away_team==$away_team && item._game_type==4 && item._checkbox_index==2)
			{
				return 0;
			}
		}
		else if($game_type==4 && $checkbox_index==2)
		{
			item = m_betList._items[i];
			if(item._home_team==$home_team && item._away_team==$away_team && item._game_type==1 &&
				(item._checkbox_index==0 || item._checkbox_index==2))
			{
				return 0;
			}
		}
	}

	return 1;
}

// ??????+??????
function CheckRule_wl_under($game_index, $checkbox_index, $game_type, $home_team, $away_team) {
	for(var i=0; i<m_betList._items.length;++i)
	{
		if($game_type==1 && ($checkbox_index==0 || $checkbox_index==2))
		{
			var item = m_betList._items[i];
			if(item._home_team==$home_team && item._away_team==$away_team && item._game_type==4 && item._checkbox_index==0)
			{
				return 0;
			}
		}
		else if($game_type==4 && $checkbox_index==0)
		{
			item = m_betList._items[i];
			if(item._home_team==$home_team && item._away_team==$away_team && item._game_type==1 &&
				(item._checkbox_index==0 || item._checkbox_index==2))
			{
				return 0;
			}
		}
	}

	return 1;
}

// ???+??????
function CheckRule_d_over($game_index, $checkbox_index, $game_type, $home_team, $away_team) {
	for(var i=0; i<m_betList._items.length;++i)
	{
		if($game_type==1 && $checkbox_index==1)
		{
			var item = m_betList._items[i];
			if(item._home_team==$home_team && item._away_team==$away_team && item._game_type==4 && item._checkbox_index==2)
			{
				return 0;
			}
		}
		else if($game_type==4 && $checkbox_index==2)
		{
			item = m_betList._items[i];
			if(item._home_team==$home_team && item._away_team==$away_team && item._game_type==1 && item._checkbox_index==1)
			{
				return 0;
			}
		}
	}

	return 1;
}

// ???+??????
function CheckRule_d_under($game_index, $checkbox_index, $game_type, $home_team, $away_team) {
	for(var i=0; i<m_betList._items.length;++i)
	{
		if($game_type==1 && $checkbox_index==1)
		{
			var item = m_betList._items[i];
			if(item._home_team==$home_team && item._away_team==$away_team && item._game_type==4 && item._checkbox_index==0)
			{
				return 0;
			}
		}
		else if($game_type==4 && $checkbox_index==0)
		{
			item = m_betList._items[i];
			if(item._home_team==$home_team && item._away_team==$away_team && item._game_type==1 && item._checkbox_index==1)
			{
				return 0;
			}
		}
	}
	return 1;
}

// ??????+??????/??????
function checkRule_handi_unov($game_index, $checkbox_index, $game_type, $home_team, $away_team) {
	for (i = 0; i < m_betList._items.length; ++i) {
		if ($game_type == 2) {
			var item = m_betList._items[i];
			if (item._home_team == $home_team && item._away_team == $away_team && item._game_type == 4) {
				return 0;
			}
		}
		else if ($game_type == 4) {
			item = m_betList._items[i];
			if (item._home_team == $home_team && item._away_team == $away_team && item._game_type == 2) {
				return 0;
			}
		}
	}
	return 1;
}

//-> ?????? -> ???????????? [?????????-???]+[????????????-??????]
function checkRule_win_over() {
	for ( i = 0 ; i < m_betList._items.length ; i++ ) {
		var i_item = m_betList._items[i];
		for ( j = (i+1) ; j < m_betList._items.length ; j++ ) {
			var j_item = m_betList._items[j];
			if ( i_item._game_type == 1 && i_item._checkbox_index == 0 && i_item._sport_name == "??????" ) {
				if ( i_item._home_team == j_item._home_team && i_item._away_team == j_item._away_team && j_item._game_type == 4 && j_item._checkbox_index == 0 && j_item._sport_name == "??????" ) {
					return 0;
				}
			} else if ( i_item._game_type == 4 && i_item._checkbox_index == 0 && i_item._sport_name == "??????" ) {
				if ( i_item._home_team == j_item._home_team && i_item._away_team == j_item._away_team && j_item._game_type == 1 && j_item._checkbox_index == 0 && j_item._sport_name == "??????" ) {
					return 0;
				}
			}
		} //-> end FOR J
	} //-> end FOR I
	return 1;
}

//-> ?????? -> ???????????? [?????????-???]+[????????????-??????]
function checkRule_win_under() {
	for ( i = 0 ; i < m_betList._items.length ; i++ ) {
		var i_item = m_betList._items[i];
		for ( j = (i+1) ; j < m_betList._items.length ; j++ ) {
			var j_item = m_betList._items[j];
			if ( i_item._game_type == 1 && i_item._checkbox_index == 0 && i_item._sport_name == "??????" ) {
				if ( i_item._home_team == j_item._home_team && i_item._away_team == j_item._away_team && j_item._game_type == 4 && j_item._checkbox_index == 2 && j_item._sport_name == "??????" ) {
					return 0;
				}
			} else if ( i_item._game_type == 4 && i_item._checkbox_index == 2 && i_item._sport_name == "??????" ) {
				if ( i_item._home_team == j_item._home_team && i_item._away_team == j_item._away_team && j_item._game_type == 1 && j_item._checkbox_index == 0 && j_item._sport_name == "??????" ) {
					return 0;
				}
			}
		} //-> end FOR J
	} //-> end FOR I
	return 1;
}

//-> ?????? -> ???????????? [?????????-???]+[????????????-??????]
function checkRule_lose_under() {
	for ( i = 0 ; i < m_betList._items.length ; i++ ) {
		var i_item = m_betList._items[i];
		for ( j = (i+1) ; j < m_betList._items.length ; j++ ) {
			var j_item = m_betList._items[j];
			if ( i_item._game_type == 1 && i_item._checkbox_index == 2 && i_item._sport_name == "??????" ) {
				if ( i_item._home_team == j_item._home_team && i_item._away_team == j_item._away_team && j_item._game_type == 4 && j_item._checkbox_index == 2 && j_item._sport_name == "??????" ) {
					return 0;
				}
			} else if ( i_item._game_type == 4 && i_item._checkbox_index == 2 && i_item._sport_name == "??????" ) {
				if ( i_item._home_team == j_item._home_team && i_item._away_team == j_item._away_team && j_item._game_type == 1 && j_item._checkbox_index == 2 && j_item._sport_name == "??????" ) {
					return 0;
				}
			}
		} //-> end FOR J
	} //-> end FOR I
	return 1;
}

//-> ?????? -> ???????????? [?????????-???]+[????????????-??????]
function checkRule_lose_over() {
	for ( i = 0 ; i < m_betList._items.length ; i++ ) {
		var i_item = m_betList._items[i];
		for ( j = (i+1) ; j < m_betList._items.length ; j++ ) {
			var j_item = m_betList._items[j];
			if ( i_item._game_type == 1 && i_item._checkbox_index == 2 && i_item._sport_name == "??????" ) {
				if ( i_item._home_team == j_item._home_team && i_item._away_team == j_item._away_team && j_item._game_type == 4 && j_item._checkbox_index == 0 && j_item._sport_name == "??????" ) {
					return 0;
				}
			} else if ( i_item._game_type == 4 && i_item._checkbox_index == 0 && i_item._sport_name == "??????" ) {
				if ( i_item._home_team == j_item._home_team && i_item._away_team == j_item._away_team && j_item._game_type == 1 && j_item._checkbox_index == 2 && j_item._sport_name == "??????" ) {
					return 0;
				}
			}
		} //-> end FOR J
	} //-> end FOR I
	return 1;
}

function checkRule_fb_win_over() {
	for ( i = 0 ; i < m_betList._items.length ; i++ ) {
		var i_item = m_betList._items[i];
		for ( j = (i+1) ; j < m_betList._items.length ; j++ ) {
			var j_item = m_betList._items[j];
			if ( i_item._game_type == 1 && i_item._checkbox_index == 0 && i_item._home_team.indexOf("1?????? ??????") > -1 ) {
				if ( i_item._home_team.indexOf(j_item._home_team) > -1 && i_item._away_team.indexOf(j_item._away_team) > -1 && j_item._game_type == 4 && j_item._checkbox_index == 0 ) {
					return 0;
				}
			} else if ( i_item._game_type == 4 && i_item._checkbox_index == 0 && j_item._home_team.indexOf(i_item._home_team) > -1 && j_item._away_team.indexOf(i_item._away_team) > -1 ) {
				if ( j_item._home_team.indexOf("1?????? ??????") > -1 && j_item._game_type == 1 && j_item._checkbox_index == 0 ) {
					return 0;
				}
			}
		} //-> end FOR J
	} //-> end FOR I
	return 1;
}

function checkRule_fb_win_under() {
	for ( i = 0 ; i < m_betList._items.length ; i++ ) {
		var i_item = m_betList._items[i];
		for ( j = (i+1) ; j < m_betList._items.length ; j++ ) {
			var j_item = m_betList._items[j];
			if ( i_item._game_type == 1 && i_item._checkbox_index == 0 && i_item._home_team.indexOf("1?????? ??????") > -1 ) {
				if ( i_item._home_team.indexOf(j_item._home_team) > -1 && i_item._away_team.indexOf(j_item._away_team) > -1 && j_item._game_type == 4 && j_item._checkbox_index == 2 ) {
					return 0;
				}
			} else if ( i_item._game_type == 4 && i_item._checkbox_index == 2 && j_item._home_team.indexOf(i_item._home_team) > -1 && j_item._away_team.indexOf(i_item._away_team) > -1 ) {
				if ( j_item._home_team.indexOf("1?????? ??????") > -1 && j_item._game_type == 1 && j_item._checkbox_index == 0 ) {
					return 0;
				}
			}
		} //-> end FOR J
	} //-> end FOR I
	return 1;
}

function checkRule_fb_lose_under() {
	for ( i = 0 ; i < m_betList._items.length ; i++ ) {
		var i_item = m_betList._items[i];
		for ( j = (i+1) ; j < m_betList._items.length ; j++ ) {
			var j_item = m_betList._items[j];
			if ( i_item._game_type == 1 && i_item._checkbox_index == 2 && i_item._away_team.indexOf("1?????? ?????????") > -1 ) {
				if ( i_item._home_team.indexOf(j_item._home_team) > -1 && i_item._away_team.indexOf(j_item._away_team) > -1 && j_item._game_type == 4 && j_item._checkbox_index == 2 ) {
					return 0;
				}
			} else if ( i_item._game_type == 4 && i_item._checkbox_index == 2 && j_item._home_team.indexOf(i_item._home_team) > -1 && j_item._away_team.indexOf(i_item._away_team) > -1 ) {
				if ( j_item._away_team.indexOf("1?????? ?????????") > -1 && j_item._game_type == 1 && j_item._checkbox_index == 2 ) {
					return 0;
				}
			}
		} //-> end FOR J
	} //-> end FOR I
	return 1;
}

function checkRule_fb_lose_over() {
	for ( i = 0 ; i < m_betList._items.length ; i++ ) {
		var i_item = m_betList._items[i];
		for ( j = (i+1) ; j < m_betList._items.length ; j++ ) {
			var j_item = m_betList._items[j];
			if ( i_item._game_type == 1 && i_item._checkbox_index == 2 && i_item._away_team.indexOf("1?????? ?????????") > -1 ) {
				if ( i_item._home_team.indexOf(j_item._home_team) > -1 && i_item._away_team.indexOf(j_item._away_team) > -1 && j_item._game_type == 4 && j_item._checkbox_index == 0 ) {
					return 0;
				}
			} else if ( i_item._game_type == 4 && i_item._checkbox_index == 0 && j_item._home_team.indexOf(i_item._home_team) > -1 && j_item._away_team.indexOf(i_item._away_team) > -1 ) {
				if ( j_item._away_team.indexOf("1?????? ?????????") > -1 && j_item._game_type == 1 && j_item._checkbox_index == 2 ) {
					return 0;
				}
			}
		} //-> end FOR J
	} //-> end FOR I
	return 1;
}

//-> ?????? ???3??????+???????????? ????????? ??????.
function checkRule_basketBall_a() {
	for ( i = 0 ; i < m_betList._items.length ; i++ ) {
		var i_item = m_betList._items[i];
		if ( i_item._away_team.indexOf("???3??????") > -1 ) {			
			for ( j = (i+1) ; j < m_betList._items.length ; j++ ) {
				var j_item = m_betList._items[j];
				if ( j_item._away_team.indexOf("????????????") > -1 && i_item.game_date == j_item.game_date ) {
					return 0;
				}
			}
		}
	}
	return 1;
}

function checkRule($game_index, $checkbox_index, $game_type, $home_team, $away_team)
{
	for(i=0; i<m_betList._items.length;++i)
	{
		if($game_type==1 && $checkbox_index==1)
		{
			var item = m_betList._items[i];
			if(item._home_team==$home_team && item._away_team==$away_team && item._game_type==4 && item._checkbox_index==2)
			{
				return 0;
			}
		}
		else if($game_type==4 && $checkbox_index==2)
		{
			item = m_betList._items[i];
			if(item._home_team==$home_team && item._away_team==$away_team && item._game_type==1 && item._checkbox_index==1)
			{
				return 0;
			}
		}
		 		
	}
	return 1;
}

function checkRule_over($game_index, $checkbox_index, $game_type, $home_team, $away_team)
{
	for(i=0; i<m_betList._items.length;++i)
	{
		if($game_type==1 && $checkbox_index==1)
		{
			var item = m_betList._items[i];
			if(item._home_team==$home_team && item._away_team==$away_team && item._game_type==4 && item._checkbox_index==0)
			{
				return 0;
			}
		}
		else if($game_type==4 && $checkbox_index==0)
		{
			item = m_betList._items[i];
			if(item._home_team==$home_team && item._away_team==$away_team && item._game_type==1 && item._checkbox_index==1)
			{
				return 0;
			}
		}
		 		
	}
	return 1;
}

function checkRule1($game_index, $checkbox_index, $game_type, $home_team, $away_team)
{
	for(i=0; i<m_betList._items.length;++i)
	{
		if($game_type==1)
		{
			var item = m_betList._items[i];
			if(item._home_team==$home_team && item._away_team==$away_team && item._game_type==2)
			{
				return 0;
			}
		}
		else if($game_type==2)
		{
			item = m_betList._items[i];
			if(item._home_team==$home_team && item._away_team==$away_team && item._game_type==1)
			{
				return 0;
			}
		}
		 		
	}
	return 1;
}

//-> ????????? ?????? ?????????????????? ?????????+???????????? ?????? ??????.
function checkRule2($game_index, $checkbox_index, $game_type, $home_team, $away_team)
{
	for(i=0; i<m_betList._items.length;++i)
	{
		if($game_type==1)
		{
			var item = m_betList._items[i];
			if(item._home_team==$home_team && item._away_team==$away_team && item._game_type==4)
			{
				return 0;
			}
		}
		else if($game_type==4)
		{
			item = m_betList._items[i];
			if(item._home_team==$home_team && item._away_team==$away_team && item._game_type==1)
			{
				return 0;
			}
		}
	}
	return 1;
}

//-> ????????? ?????? ?????????????????? ?????????+???????????? ?????? ??????.
function checkRule3($game_index, $checkbox_index, $game_type, $home_team, $away_team)
{
	for(i=0; i<m_betList._items.length;++i)
	{
		if($game_type==2)
		{
			var item = m_betList._items[i];
			if(item._home_team==$home_team && item._away_team==$away_team && item._game_type==4)
			{
				return 0;
			}
		}
		else if($game_type==4)
		{
			item = m_betList._items[i];
			if(item._home_team==$home_team && item._away_team==$away_team && item._game_type==2)
			{
				return 0;
			}
		}
	}
	return 1;
}

//-> ???????????? ?????? + ????????? ?????? ??????.
function checkRule_winlose_unover() {
	for ( i = 0 ; i < m_betList._items.length ; i++ ) {
		var i_item = m_betList._items[i];
		for ( j = (i+1) ; j < m_betList._items.length ; j++ ) {
			var j_item = m_betList._items[j];
			if ( i_item._game_type == 1 && (i_item._checkbox_index == 0 || i_item._checkbox_index == 2) ) {
				if ( i_item._home_team.indexOf(j_item._home_team) > -1 && i_item._away_team.indexOf(j_item._away_team) > -1 && j_item._game_type == 4 && (j_item._checkbox_index == 0 || j_item._checkbox_index == 2) ) {
					return 0;
				}
			} else if ( i_item._game_type == 4 && (i_item._checkbox_index == 0 || i_item._checkbox_index == 2) && j_item._home_team.indexOf(i_item._home_team) > -1 && j_item._away_team.indexOf(i_item._away_team) > -1 ) {
				if ( j_item._game_type == 1 && (j_item._checkbox_index == 0 || j_item._checkbox_index == 2) ) {
					return 0;
				}
			}
		} //-> end FOR J
	} //-> end FOR I
	return 1;
}

function filter_team_name($team, $index/*0=home, 1=away*/)
{
	var filtered="";
	
	if( 0==$index)
	{
		pos = $team.indexOf("[");
		if( pos!=-1)
		{
			filtered = $team.substr(0, pos);
			return filtered;
		}
	}
	else
	{
		pos = $team.indexOf("]");
		if( pos!=-1)
		{
			filtered = $team.substr(pos+1, $team.length-pos);
			return filtered;
		}
	}

	return $team;
}

/*
??????-????????? ??????

??????????????? ????????? ??????.
????????? ?????? ???????????? ????????????.
*/
function check_specified_special_rule($game_index, $is_specified_special, $game_type, $home_team, $away_team)
{
	if($game_type!=1)
	{
		for(i=0; i<m_betList._items.length;++i)
		{
			var item = m_betList._items[i];
			if(item._is_specified_special==1)
			{
					return 0;
			}
		}
	}
	
	else if(1==$game_type && 1==$is_specified_special)
	{
		$home_team = filter_team_name($home_team, 0);
		$away_team = filter_team_name($away_team, 1);
		
		for(i=0; i<m_betList._items.length;++i)
		{
			var item = m_betList._items[i];
			if(item._game_type!=1)
			{
				return 0;
			}
		}
	}
	return 1;
}

function del_bet($game_index, bonusFlag) {
	$j("[name=" + $game_index + "_div] input:checkbox").each(function (index) {
		this.checked = false;
		$div = $j(this).parent();
		$div.removeClass('on');

		var chk_id = $j(this).attr('id');
		var betid = 0;
		if(chk_id !== undefined) {
			var pieces = chk_id.split("_");
			betid = pieces[0];
		}

		if(localStorage.getItem(`selected_${betid}`) !== null)
			localStorage.removeItem(`selected_${betid}`);
	});

	m_betList.removeItem($game_index);
	betcon=betcon.del_one($game_index);

	if ( bonusFlag != 1 )	bonus_del(); //?????? ?????? ??????
	calc();
}

function bet_clear()
{
	var delArray = new Array();
	for(i=0; i<m_betList._items.length;++i)
	{
		delArray[i] = m_betList._items[i]._game_index;
	}
	//console.log(delArray);
	for(i=0; i<delArray.length; ++i)
	{
		del_bet(delArray[i], 1);
	}

	$j("#betMoney").val(MoneyFormat(parseInt(eval("VarMinBet"))));
	m_betList._point = parseInt(eval("VarMinBet"));
}


// ------------------------- item -----------------------------------------------------------------
function Item(game_index, home_team, away_team, chckbox_index, select_rate, home_rate, draw_rate, away_rate, game_type, sub_child_sn, is_specified_special, game_date, league_sn, sport_name, s_type, betid, market_name, home_line, away_line, home_name, home_betid, away_betid, draw_betid) 
{
	this._game_index = game_index;
	this._home_team = home_team;
	this._away_team = away_team;
	this._checkbox_index = chckbox_index;
	this._selct_rate = select_rate;
	this._home_rate = home_rate;
	this._draw_rate = draw_rate;
	this._away_rate = away_rate;
	this._game_type = game_type;
	this._lnum = sub_child_sn;
	this._is_specified_special = is_specified_special;
	this._game_date = game_date;
	this._league_sn = league_sn;
	this._sport_name = sport_name;
	this._s_type = s_type;
	this._betid = betid;
	this._market_name = market_name;
	this._home_line = home_line;
	this._away_line = away_line;
	this._home_name = home_name;
	this._home_betid = home_betid;
	this._away_betid = away_betid;
	this._draw_betid = draw_betid;
}

Item.prototype._game_index;
Item.prototype._home_team;
Item.prototype._away_team;
Item.prototype._checkbox_index;
Item.prototype._selct_rate;
Item.prototype._home_rate;
Item.prototype._draw_rate;
Item.prototype._away_rate;
Item.prototype._game_type;
Item.prototype._lnum;
Item.prototype._is_specified_special;
Item.prototype._game_date;
Item.prototype._league_sn;
Item.prototype._sport_name;
Item.prototype._s_type;
Item.prototype._betid;
Item.prototype._market_name;
Item.prototype._home_line;
Item.prototype._away_line;
Item.prototype._home_name;
Item.prototype._home_betid;
Item.prototype._away_betid;
Item.prototype._draw_betid;

function BetList() 
{
	this._items = new Array();
}

BetList.prototype._totalprice;
BetList.prototype._point;
BetList.prototype._bet;
BetList.prototype._items;

BetList.prototype.addItem = function(item) 
{
	this.removeItem(item._game_index);
	this._items.push(item);
	add_bet_list(item);
}

BetList.prototype.removeItem = function(num) 
{
	var pos = -1;

	for (var i = 0; i<this._items.length; i++) 
	{
		if (this._items[i]._game_index == num) 
		{
			pos = i;
			break;
		}
	}
	if (pos>=0) 
	{
		this._items.remove(pos, pos);
		del_bet_list(num);
	}
}

BetList.prototype.getList = function()
{
	var re = "";
	for (var i = 0; i<this._items.length; i++) 
	{
		re += this._items[i]._game_index
		re += "||"+this._items[i]._checkbox_index
		re += "||"+this._items[i]._home_team
		re += "||"+this._items[i]._away_team
		re += "||"+this._items[i]._home_rate
		re += "||"+this._items[i]._draw_rate
		re += "||"+this._items[i]._away_rate
		re += "||"+this._items[i]._selct_rate
		re += "||"+this._items[i]._game_type
		re += "||"+this._items[i]._lnum
		re += "||"+this._items[i]._game_date
		re += "||"+this._items[i]._league_sn
		re += "||"+this._items[i]._sport_name
		re += "||"+this._items[i]._s_type
		re += "||"+this._items[i]._betid+"#";
	}
	return re;
}

BetList.prototype.setPoint = function(point) 
{
	this._point = point;
}

BetList.prototype.exec = function() 
{
	this._bet = 0;
	for (var i=0; i<this._items.length; ++i) 
	{
		if(i==0) 	{this._bet = 1;}
		this._bet = this._bet*(this._items[i]._selct_rate*100);
		this._bet = this._bet/100;
	}
	this._bet = Floor(this._bet, 2);
	this._totalprice = Math.floor(this._point*this._bet);
}

function del_bet_list(num) 
{
	var tb = document.getElementById("tb_list");
	var row0 = getObject("tb_row_1_"+num);
	tb.deleteRow(row0.rowIndex);
	
	var row1 = getObject("tb_row_2_"+num);
	tb.deleteRow(row1.rowIndex);
	
	//?????????
	folderBonusHTML();
}

function add_bet_list(item)
{
	// console.log(item);
	var table 	= document.getElementById("tb_list");
	var tr0		= table.insertRow(table.rows.length);
	var tr1 	= table.insertRow(table.rows.length);
	
	//tr ??????
	tr0.id = "tb_row_1_"+item._game_index;
	tr1.id = "tb_row_2_"+item._game_index;
	
	//td ??????
	var td00		= tr0.insertCell(0);
	var td10		= tr1.insertCell(0);
	
	//width ?????????	
	td00.style.width = '100%';
	td10.style.width = '100%';

	//align ?????????
	td00.style.textAlign = 'left';
	td10.style.textAlign = 'left';
	
	var selectedTeam = item._checkbox_index;
	var home_line = item._home_line;
	var away_line = item._away_line;
	var home_name = item._home_name;
	var market_name = item._market_name;
	var home_team = item._home_team;
	var away_team = item._away_team;
	var team_name = item._home_team + " VS " + item._away_team;

	var selected_betid = 0;

	if(selectedTeam == "0")
		selected_betid = item._home_betid;
	else if(selectedTeam == "1")
		selected_betid = item._draw_betid;
	else if(selectedTeam == "2")
		selected_betid = item._away_betid;

	if(selected_betid == 0)	
		team_name = item._home_team;

	var pieces = item._game_index.split("_");
	var family_id = pieces[2];

	switch(family_id){
		case "1":
		case "2":
			if(selectedTeam == "0")
				selectedTeam = market_name + ' (???) - ' + home_team;
			else if(selectedTeam == "1") 
				selectedTeam = market_name + ' - ?????????'; 
			else if(selectedTeam == "2")   
				selectedTeam = market_name + ' (???) - ' + away_team;                       
			break;
		case "7":
			if(selectedTeam == "0") {
				selectedTeam = market_name + ' - ?????? (' + home_line + ')';
			} else if(selectedTeam == "2") {
				selectedTeam = market_name + ' - ?????? (' + home_line + ')'; 
			}
			break;
		case "8":
		case "9":
			if(selectedTeam == "0") {
				home_line = home_line.split(" ");
				selectedTeam = market_name + ' (???) - ' + home_team + ' (' + home_line[0] + ')';
			} else if(selectedTeam == "2") {
				away_line = away_line.split(" ");
				selectedTeam = market_name + ' (???) - ' + away_team + ' (' + away_line[0] + ')'; 
			}
			break;
		case "10":
			if(selectedTeam == "0")
				selectedTeam = market_name + ' (???)';
			else if(selectedTeam == "2") 
				selectedTeam = market_name + ' (???)'; 
			break;
		case "11":
			selectedTeam = market_name + ' (' + home_name + ')';
			break;
		case "12":
			if(selectedTeam == "0")
				selectedTeam = market_name + ' (' + '??????' + ')';
			else if(selectedTeam == "1") 
				selectedTeam = market_name + ' (' + '??????' + ')';                       
			else if(selectedTeam == "2")                        
				selectedTeam = market_name + ' (' + '??????' + ')'; 
			break;
		case "47":
			if(home_name == "1 And Under")
				selectedTeam = market_name + ' (?????? & ??????) ' + '(' + home_line + ')';
			else if(home_name == "1 And Over") 
				selectedTeam = market_name + ' (?????? & ??????) ' + '(' + home_line + ')';                       
			else if(home_name == "2 And Under")                        
				selectedTeam = market_name + ' (????????? & ??????) ' + '(' + home_line + ')'; 
			else if(home_name == "2 And Over")
				selectedTeam = market_name + ' (????????? & ??????) ' + '(' + home_line + ')';
			else if(home_name == "X And Under")
				selectedTeam = market_name + ' (??? & ??????) ' + '(' + home_line + ')';
			else if(home_name == "X And Over")
				selectedTeam = market_name + ' (??? & ??????) ' + '(' + home_line + ')';
			break;
		default:
			selectedTeam = "??????";
			break;
	}

	var mkPickRow = `<li>
						<h4>
							<span class="betting-cart-name lis">${team_name}</span>
							<span class="del">
								<img src="/10bet/images/10bet/ico_del_01.png" alt="??????" onclick="del_bet('${item._game_index}','0')">
							</span>
						</h4>
						<div class="result">
							<p class="betting-cart-name lis"><b>${selectedTeam}</b></p> 
							<span id="${selected_betid}_cart">${parseFloat(item._selct_rate).toFixed(2)}</span>
						</div>
					</li>`;

	//?????? ??????
	td00.innerHTML = mkPickRow;

	//?????????
	folderBonusHTML();
}

function updateCart(selected_id, betid, rate) {
	if(m_betList._items.length > 0) {
		for(i=0; i<m_betList._items.length; ++i)
		{
			if(selected_id == 0) {
				if(m_betList._items[i]._home_betid == betid) {
					m_betList._items[i]._home_rate = rate;
					m_betList._items[i]._selct_rate = rate;
				}
			} else if (selected_id == 1) {
				if(m_betList._items[i]._draw_betid == betid) {
					m_betList._items[i]._draw_rate = rate;
					m_betList._items[i]._selct_rate = rate;
				}
			} else if (selected_id == 2) {
				if(m_betList._items[i]._away_betid == betid) {
					m_betList._items[i]._away_rate = rate;
					m_betList._items[i]._selct_rate = rate;
				}
			}
		}
		calc();
	}
}

function folderBonusHTML()
{
	var betMoney = $j('#betMoney').val();
	
	betMoney = betMoney.replace(/,/gi,"");
	betMoney = parseInt(betMoney);
	
	gameCount 	= getBetCount();
	
	$rate = 0;
	if(gameCount==3)		{$rate=m_bonus3}
	else if(gameCount==4)	{$rate=m_bonus4}
	else if(gameCount==5)	{$rate=m_bonus5}
	else if(gameCount==6)	{$rate=m_bonus6}
	else if(gameCount==7)	{$rate=m_bonus7}
	else if(gameCount==8)	{$rate=m_bonus8}
	else if(gameCount==9)	{$rate=m_bonus9}
	else if(gameCount==10)	{$rate=m_bonus10}
		
	amount = betMoney*$rate/100;
	//$j('#type_slip #folder_bonus').text("+"+MoneyFormat(amount));
}

function getBetCount()
{
	return m_betList._items.length;
}

function get_item_html(item) 
{
	var gameType 	 = item._game_type;
	var homeTeamName = item._home_team;
	var awayTeamName = item._away_team;
	var selectedRate = item._selct_rate;
	var selectedTeam = item._checkbox_index;
	
	switch(selectedTeam)
	{
		case '0': selectedTeam=homeTeamName; break;
		case '1': selectedTeam="?????????";break;
		case '2': selectedTeam=awayTeamName; break;
	}
	var $html = "<td><span class='game'>"+homeTeamName+" vs "+awayTeamName+"</span><span class='pick'>"+selectedTeam+"</span><span class='rate'>"+selectedRate+"</span></td>";
	
	return $html;
}

function calc() 
{
	var point = $j('#betMoney').val();
	
	point = point.replace(/,/gi,"");
	point = parseInt(point);
	
	m_betList.setPoint(point);
	m_betList.exec();
	var betstr = m_betList._bet;
	if (betstr.toFixed)
	{
		betstr = betstr.toFixed(2);
	}
	
	document.getElementById("sp_bet").innerHTML = betstr;
	document.getElementById("sp_total").innerHTML =MoneyFormat(m_betList._totalprice);
	
	betForm.result_rate.value = betstr;
	betlist=m_betList.getList();
	
	strParam="betlist="+betlist;
	
	var param={betlist:betlist};
	$j.post("/race/saveProcess", param, onSave);
}

function onSave(strText)
{
	//????????? ????????? ??????.
}

function betting(type)
{
	var min_bet 	= 0;
	var max_bet 	= 0;
	var max_amount 	= 0;
	
	min_bet 	= parseInt(eval("VarMinBet"));
	max_bet 	= parseInt(eval("VarMaxBet"));
	max_amount 	= parseInt(eval("VarMaxAmount"));

	//1,000??? ????????? ??????????????????---
	var iLen = String(m_betList._point).length;
	rlen_money = (String(m_betList._point).substring(iLen,iLen - 3))
	rlen_money = String(rlen_money);

	var sp_bet = m_betList._bet;
	if ( !m_betList._point )
	{
		m_betList._point = parseInt(eval("VarMinBet"));
	}

	if(isNaN(sp_bet))
	{
		warning_popup("????????? ????????? ??????????????????.");
		return;
	}
	if(isNaN(m_betList._point))
	{
		warning_popup("???????????? ????????? ????????? ???????????? ????????????");
		return;
	}

	//if ( m_betList._items.length == 1 ) {
	//	warning_popup("????????? ????????? 2?????? ???????????? ???????????????.");
	//	return;
	//}

	//????????? ??????
	if(m_betList._items.length==1)
	{
		if (m_betList._point < min_bet || m_betList._point > m_single_max_bet) 
		{
			if ( m_single_max_bet == 0 ) warning_popup("?????? ????????? ????????? ???????????? ?????? ????????? ????????? ????????? ??????????????? ?????? ?????????.");
			else warning_popup("???????????? "+MoneyFormat(min_bet)+"~"+MoneyFormat(m_single_max_bet)+"??? ???????????????.");
			if ( m_betList._point < min_bet ) {
				autoCheckBetting(min_bet);
			} else {
				autoCheckBetting(m_single_max_bet);
			}
			return;
		}
	}
	else
	{
		if (m_betList._point<min_bet || m_betList._point>max_bet) 
		{
			warning_popup("???????????? "+MoneyFormat(min_bet)+"~"+MoneyFormat(max_bet)+"??? ???????????????.");
			if (m_betList._point<min_bet) {
				m_betList._point = Math.floor(min_bet/sp_bet);
				betForm.betMoney.value = MoneyFormat(min_bet);
				m_betList._point = min_bet;
			} else {
				m_betList._point = Math.floor(max_bet/sp_bet);
				betForm.betMoney.value = MoneyFormat(max_bet);
				m_betList._point = max_bet;
			}
			m_betList._totalprice = Math.floor(m_betList._point*sp_bet);
			document.getElementById("sp_total").innerHTML = MoneyFormat(m_betList._totalprice);
			return;
		}
	}

	if (m_betList._totalprice>max_amount) 
	{
		warning_popup("?????????????????? "+MoneyFormat(max_amount)+" ??? ?????? ??? ????????????.\n\n??????????????? ????????????????????? ????????????.");
		m_betList._point = Math.floor(max_amount/sp_bet);
		betForm.betMoney.value = MoneyFormat(m_betList._point);
		m_betList._totalprice = Math.floor(m_betList._point*sp_bet);
		document.getElementById("sp_total").innerHTML = MoneyFormat(m_betList._totalprice);
		return;
	}
	if (m_betList._items.length == 0)
	{
		warning_popup("????????? ????????? ??????????????????.");
		return;
	}
	if (m_betList._totalprice == 0)
	{
		warning_popup("??????????????? ??????????????????.");
		return;
	}

	if (m_betList._items.length < m_min_count)
	{
		warning_popup("?????? "+m_min_count+"?????? ?????? ??????????????? ?????????.");
		return;
	}
	if (m_betList._items.length > 10)
	{
		warning_popup("?????? 10???????????? ??????????????? ????????????.");
		return;
	}

/*
	if ( m_betList._items.length == 2 && (matchGameWinOver == 1 || matchGameWinUnder == 1 || matchGameLoseOver == 1 || matchGameLoseUnder == 1) ) {
		warning_popup("????????????(??????) [?????????-???]+[????????????-??????] ????????? 3?????? ???????????? ???????????????.");
		return;
	}

	if ( matchGameWinOver == 1 ) {
		warning_popup("????????????(??????) [?????????-???]+[????????????-??????] ????????? ????????? ??????????????????.");
		return;
	}
	if ( matchGameWinUnder == 1 ) {
		warning_popup("????????????(??????) [?????????-???]+[????????????-??????] ????????? ????????? ??????????????????.");
		return;
	}
	if ( matchGameLoseOver == 1 ) {
		warning_popup("????????????(??????) [?????????-???]+[????????????-??????] ????????? ????????? ??????????????????.");
		return;
	}
	if ( matchGameLoseUnder == 1 ) {
		warning_popup("????????????(??????) [?????????-???]+[????????????-??????] ????????? ????????? ??????????????????.");
		return;
	}

	if ( matchGameFbWinUnder == 1 ) {
		warning_popup("????????????(??????) [?????????-???]+[????????????-??????] ????????? ????????? ??????????????????.");
		return;
	}
	if ( matchGameFbWinOver == 1 ) {
		warning_popup("????????????(??????) [?????????-???]+[????????????-??????] ????????? ????????? ??????????????????.");
		return;
	}
	if ( matchGameFbLoseUnder == 1 ) {
		warning_popup("????????????(??????) [?????????-???]+[????????????-??????] ????????? ????????? ??????????????????.");
		return;
	}
	if ( matchGameFbLoseOver == 1 ) {
		warning_popup("????????????(??????) [?????????-???]+[????????????-??????] ????????? ????????? ??????????????????.");
		return;
	}


	if ( matchGameFbWinloseUnover == 1 ) {
		warning_popup("????????????(??????) [??????]+[?????????] ????????? ????????? ??????????????????.");
		return;
	}

	if ( m_betList._items.length == 2 && matchGameFbWinUnder == 1 ) {
		warning_popup("????????????(??????) [?????????-???]+[????????????-??????] ????????? 3?????? ???????????? ???????????????.");
		return;
	}

	if ( m_betList._items.length == 2 && matchGameFbWinOver == 1 ) {
		warning_popup("????????????(??????) [?????????-???]+[????????????-??????] ????????? 3?????? ???????????? ???????????????.");
		return;
	}

	if ( m_betList._items.length == 2 && matchGameFbLoseUnder == 1 ) {
		warning_popup("????????????(??????) [?????????-???]+[????????????-??????] ????????? 3?????? ???????????? ???????????????.");
		return;
	}

	if ( m_betList._items.length == 2 && matchGameFbLoseOver == 1 ) {
		warning_popup("????????????(??????) [?????????-???]+[????????????-??????] ????????? 3?????? ???????????? ???????????????.");
		return;
	}

	if ( matchGameBbFtsFfs == 1 ) {
		warning_popup("????????????(??????) [???3??????]+[????????????] ?????? ????????? ????????? ?????????..");
		return;
	}
*/
	if (m_betList._point>VarMoney)
	{
		warning_popup("????????? ???????????????.");
		return;
	}

	if ( bettingSubmitFlag == 1 ) {
		warning_popup("?????? ??????????????????. ????????????????????????.\n\n????????? ????????? ????????? F5??? ?????? ???????????? ??? ????????? ??????????????????.");
		return;
	}

	if (type == "cart")
	{
		betForm.mode.value = type;
	}
	else 
	{
		bettingSubmitFlag = 1;
		betForm.betMoney.value = m_betList._point;
		betForm.betcontent.value = m_betList.getList();
		var game_type = betForm.game_type.value;
		var message = `???????????? ${bettingcanceltime}?????????, ???????????? ${bettingcancelbeforetime}???????????? ?????????????????????.`;
		if(game_type == "live") {
			message = `????????? ????????? ?????? ???????????? ??????????????? ????????? ????????? ???????????? ????????? ????????????.`;
		}
		var betMoney = $j("#betMoney").val();
		var totalMoney = $j("#sp_total").text();
		var content = `?????????: ${betMoney} <br>
						??????????????????: ${totalMoney}
						<br><br>
						???????????? ????????? ??????????????????.
						<br><br>
						${message}<br><br>
						??????????????? ?????? ???????????????.`;
		sports_popup(content);
	}
}

function confirmBet() {
	betForm.mode.value = "betting";
	
	//console.log(betForm.betcontent.value);
	var v_packet = {
		"user"			:	betForm.member_sn.value,
		"mode"			: 	betForm.mode.value,
		"betMoney"		:	betForm.betMoney.value,
		"gametype"		:	betForm.gametype.value,
		"game_type"		:	betForm.game_type.value,
		"special_type"	:	betForm.special_type.value,
		"strgametype"	:	betForm.strgametype.value,
		"betcontent"	:	betForm.betcontent.value
	};

	sendPacket(PACKET_SPORT_BET, JSON.stringify(v_packet));

	betting_ready_popup();

	timer = setInterval(bettingTimer, 1000);
}

function bettingTimer() {
	waiting = waiting - 1;
	if(waiting > 0)
		$j("#bettingSecond").text(waiting);
	else 
		$j("#bettingSecond").text(0);
}

function onRecvBetting(objPacket) {
	betting_ready_popup_close();
	clearInterval(timer);
	waiting = 7;
	$j("#bettingSecond").text(waiting);
	bettingSubmitFlag = 0;
	bet_clear(0);
	$j("#betMoney").val(0);
	warning_popup(objPacket.m_strPacket);
	if(objPacket.m_nRetCode > 0)
		onSendReqListPacket(packet);
	else {
		var game_type = betForm.game_type.value;
		if(game_type == "live") {
			if(api == "true")
				location.href = "/api/betting_list?type=2&userid=" + uid;
			else 
				location.href = "/race/betting_list?type=2";
		} else {
			if(api == "true")
				location.href = "/api/betting_list?type=1&userid=" + uid;
			else
				location.href = "/race/betting_list?type=1";
		}
	}
	
	return;
}

String.prototype.str_cut = function(len)
{
	var str = this;
	var s = 0;
	for (var i=0; i<str.length; i++) 
	{
		s += (str.charCodeAt(i) > 128) ? 2 : 1;
		if (s > len) return str.substring(0,i) + "...";
	}        
	return str;
}

///********************???????????????   ?????? ????????????************************************************************/ 
function folder_bonus(val) {
	var foldersum;
	//????????? ?????? ?????? ???????????? ?????? ??????. 
	if(val.indexOf("2??????") > -1){
		foldersum = "2";
	}else if(val.indexOf("3??????") > -1){
		foldersum = "3";	
	}else if(val.indexOf("4??????") > -1){
		foldersum = "4";	
	}else if(val.indexOf("5??????") > -1){
		foldersum = "5";	
	}else if(val.indexOf("6??????") > -1){
		foldersum = "6";	
	}else if(val.indexOf("7??????") > -1){
		foldersum = "7";
	}else{
		foldersum = "0";
	}

	if(foldersum =="0"){
		warning_popup("????????? ????????????. ??????????????? ?????? ?????????");
		return 0;
	} 
	
	//????????? ?????? ??????  ?????????   ???????????????
	if ( m_betList._items.length < foldersum ) {
		warning_popup("[?????????]??? "+foldersum+"?????? ?????? ?????? ??? ??????????????????.");
		return 0;
	} 

	//?????????  ???????????? ?????? ??????????????? ??????.... 
	//???????????? ?????? ??? ??????   ?????? ?????? ?????????  ?????????  ????????? ??????   
	var realcount  = "0";
	for ( i = 0 ; i < m_betList._items.length ; i++ ) {
		var item = m_betList._items[i];
			if ( item._home_team.indexOf("??????") <= -1 ) {
				realcount =eval(realcount)+1;
			}
	}
	//????????? ?????? ??????  ?????????   ???????????????
	if ( realcount < foldersum ) {
		warning_popup("[?????????]??? "+foldersum+"?????? ?????? ?????? ??? ??????????????????.");
		return 0;
	}
	

	//???????????? ????????? ?????? ?????????  ?????? ?????? ????????? 
	for ( i = 0 ; i < m_betList._items.length ; i++ ) {
		var item = m_betList._items[i];
		if ( item._home_team.indexOf("??????") > -1 ) {
			toggle_action = toggle_multi(item._game_index+'_div', item._index, item._selectedRate, crossLimitCnt);
			m_betList.removeItem(item._game_index);
			betcon=betcon.del_element(item._game_index+"|"+item._index+"&"+item._home_team+"  VS "+item._away_team);
		}
	}
	return 1;
}

//-> 2??????(???????????????) ???????????? ?????? ????????? [?????????]??? ????????? ??????
function bonus_del(){
	var truncount = "0";	
	for ( i = 0 ; i < m_betList._items.length ; i++ ) {
		var item = m_betList._items[i];
		if ( item._home_team.indexOf("2??????") > -1 ) {
			truncount= "2";
		} else if ( item._home_team.indexOf("3??????") > -1 ) {
			truncount= "3";
		} else if ( item._home_team.indexOf("4??????") > -1 ) {
			truncount= "4";
		} else if ( item._home_team.indexOf("5??????") > -1 ) {
			truncount= "5";
		} else if ( item._home_team.indexOf("6??????") > -1 ) {
			truncount= "6";
		} else if ( item._home_team.indexOf("7??????") > -1 ) {
			truncount= "7";		
		}
	}

	var realcount = "1";
	for ( i = 0 ; i < m_betList._items.length ; i++ ) {
		var item = m_betList._items[i];
		if ( item._home_team.indexOf("??????") <= -1 ) {
			realcount = eval(realcount)+1;
		}
	}
	
	if ( realcount-1 < truncount ) {
		for ( i = 0 ; i < m_betList._items.length ; i++ ) {
			var item = m_betList._items[i];
			if ( item._home_team.indexOf("??????") > -1 ) {
				toggle_action = toggle_multi(item._game_index+'_div', item._index, item._selectedRate, crossLimitCnt);
				m_betList.removeItem(item._game_index);
				betcon=betcon.del_element(item._game_index+"|"+item._index+"&"+item._home_team+"  VS "+item._away_team);
			}	
		}
	}
}

function check_folder() {
	var truncount = "2";

	var type = 1;
	for (i = 0; i < m_betList._items.length; i++) {
		var item = m_betList._items[i];
		if (type != item._game_type) {
			truncount = "3";
			break;
		}
	}

	var realcount = "1";
	for (i = 0; i < m_betList._items.length; i++) {
		var item = m_betList._items[i];
		if (item._home_team.indexOf("??????") <= -1) {
			realcount = eval(realcount) + 1;
		}
	}

/*	if (realcount - 1 < truncount) {
		alert("?????????????????? 2????????????, ??????????????? 3???????????? ?????????????????????.");
		return false;
	}*/

	return true;
}

function updateGameInfo(djson) {
	if(djson != null && djson != undefined) {
		//????????????????????????
		var sub_idx = `${json.m_nGame}_${djson.m_nMarket}_${djson.m_nFamily}`;
		if(djson.m_fHRate != showJson[i].m_lstDetail[j].m_fHRate) {
			var obj = document.getElementById(`${djson.m_nHBetCode}`);
			if(obj != null && obj != undefined) {
				document.getElementById(`${djson.m_nHBetCode}`).innerHTML = djson.m_fHRate.toFixed(2);
			}
			if(document.getElementById(`${sub_idx}_home_rate`) != null && document.getElementById(`${sub_idx}_home_rate`) != undefined)
				document.getElementById(`${sub_idx}_home_rate`).value = djson.m_fHRate.toFixed(2);
		}
		if(djson.m_fDRate != showJson[i].m_lstDetail[j].m_fDRate) {
			var obj = document.getElementById(`${djson.m_nDBetCode}`);
			if(obj != null && obj != undefined) {
				document.getElementById(`${djson.m_nDBetCode}`).innerHTML = djson.m_fDRate.toFixed(2);
			}
			if(document.getElementById(`${sub_idx}_draw_rate`) != null && document.getElementById(`${sub_idx}_draw_rate`) != undefined)
				document.getElementById(`${sub_idx}_draw_rate`).value = djson.m_fDRate.toFixed(2);
		}
		if(djson.m_fARate != showJson[i].m_lstDetail[j].m_fARate) {
			var obj = document.getElementById(`${djson.m_nABetCode}`);
			if(obj != null && obj != undefined) {
				document.getElementById(`${djson.m_nABetCode}`).innerHTML = djson.m_fARate.toFixed(2);
			}
			if(document.getElementById(`${sub_idx}_away_rate`) != null && document.getElementById(`${sub_idx}_away_rate`) != undefined)
				document.getElementById(`${sub_idx}_away_rate`).value = djson.m_fARate.toFixed(2);
		}

		// ??????????????? ?????? ????????????
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