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

function initialize($jmin, $jbonus3, $jbonus4, $jbonus5, $jbonus6, $jbonus7, $jbonus8, $jbonus9, $jbonus10, $jsingle_max_bet) {
	m_min_count = $jmin;
	m_bonus3	= $jbonus3;
	m_bonus4	= $jbonus4;
	m_bonus5	= $jbonus5;
	m_bonus6	= $jbonus6;
	m_bonus7	= $jbonus7;
	m_bonus8	= $jbonus8;
	m_bonus9	= $jbonus9;
	m_bonus10	= $jbonus10;
	m_single_max_bet = $jsingle_max_bet;
}

/*
 * Update Checkbox Attribute and BackGround Css
 * return : 'inserted' or 'deleted'
 */
function toggle($jtr, $jindex, selectedRate)
{
	var toggle_action = "";
	
	$j('div[name='+$jtr+'] input').each( function(index) {
		if(index!=$jindex)
		{
			this.checked=false;
		}
	});
	
	//toggle checkbox
	$jselectedCheckbox = $j('div[name='+$jtr+'] input:checkbox:eq('+$jindex+')');
	if(($jselectedCheckbox).is(":checked")==true) 
	{
		$jselectedCheckbox.attr("checked", false);
		toggle_action = 'deleted';
	}
	else
	{
		//베팅수 제한(10회)
		if(isMaxGameCount()==true)
		{
			warning_popup("최대 10경기까지 선택하실수 있습니다.");
			return false;
		}
/*
		//150배당 이상의 배당 배팅 금지		
		else if(m_betList._bet*selectedRate>=150)
		{
			warning_popup("150배당 이상은 배팅이 불가능 합니다.");
			return false;
		}
*/
		else
		{
			$jselectedCheckbox.prop("checked", true);
			toggle_action = 'inserted';
		}
	}

	//change css class
	$j('div[name='+$jtr+'] input:checkbox').each(function(index)
	{
		if(this.checked==true) {
			if ( index == 0 ) {
				$j(this).parent().attr('class','home_over');
				$j(this).parent().parent().attr('class','home_over_box');
				$j(this).parent().find("span[rel=teamH]").attr('class','home_o');
				$j(this).parent().find("span[rel=rateH]").attr('class','home_odd_o');
			} else if ( index == 1 ) {
				$j(this).parent().attr('class','odd_over_box');
				$j(this).parent().find("span[rel=rateO]").attr('class','odd_over odd_o');
			} else if ( index == 2 ) {
				$j(this).parent().attr('class','away_over');
				$j(this).parent().parent().attr('class','away_over_box');
				$j(this).parent().find("span[rel=teamA]").attr('class','away_o');
				$j(this).parent().find("span[rel=rateA]").attr('class','away_odd_o');
			}
		} else {
			if ( index == 0 ) {
				$j(this).parent().attr('class','home');
				$j(this).parent().parent().attr('class','home_box');
				$j(this).parent().find("span[rel=teamH]").attr('class','home_n');
				$j(this).parent().find("span[rel=rateH]").attr('class','home_odd_n');
			} else if ( index == 1 ) {
				$j(this).parent().attr('class','odd_box');
				$j(this).parent().find("span[rel=rateO]").attr('class','odd odd_n');
			} else if ( index == 2 ) {
				$j(this).parent().attr('class','away');
				$j(this).parent().parent().attr('class','away_box');
				$j(this).parent().find("span[rel=teamA]").attr('class','away_n');
				$j(this).parent().find("span[rel=rateA]").attr('class','away_odd_n');
			}
		}
	});
	
	return toggle_action;
}

function isMaxGameCount()
{
	return (getBetCount()>=10);
}

function DalPaingYcheckRule($jgame_date)
{
	for(i=0; i<m_betList._items.length;++i)
	{
		var item = m_betList._items[i];
		if ( item._game_date != $jgame_date ) {
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

// 승패+오버
function CheckRule_wl_over($jgame_index, $jcheckbox_index, $jgame_type, $jhome_team, $jaway_team) {

	for(var i=0; i<m_betList._items.length;++i)
	{
		if($jgame_type==1 && ($jcheckbox_index==0 || $jcheckbox_index==2))
		{
			var item = m_betList._items[i];
			if(item._home_team==$jhome_team && item._away_team==$jaway_team && item._game_type==4 && item._checkbox_index==2)
			{
				return 0;
			}
		}
		else if($jgame_type==4 && $jcheckbox_index==2)
		{
			item = m_betList._items[i];
			if(item._home_team==$jhome_team && item._away_team==$jaway_team && item._game_type==1 &&
				(item._checkbox_index==0 || item._checkbox_index==2))
			{
				return 0;
			}
		}
	}

	return 1;
}

// 승패+언더
function CheckRule_wl_under($jgame_index, $jcheckbox_index, $jgame_type, $jhome_team, $jaway_team) {
	for(var i=0; i<m_betList._items.length;++i)
	{
		if($jgame_type==1 && ($jcheckbox_index==0 || $jcheckbox_index==2))
		{
			var item = m_betList._items[i];
			if(item._home_team==$jhome_team && item._away_team==$jaway_team && item._game_type==4 && item._checkbox_index==0)
			{
				return 0;
			}
		}
		else if($jgame_type==4 && $jcheckbox_index==0)
		{
			item = m_betList._items[i];
			if(item._home_team==$jhome_team && item._away_team==$jaway_team && item._game_type==1 &&
				(item._checkbox_index==0 || item._checkbox_index==2))
			{
				return 0;
			}
		}
	}

	return 1;
}

// 무+오버
function CheckRule_d_over($jgame_index, $jcheckbox_index, $jgame_type, $jhome_team, $jaway_team) {
	for(var i=0; i<m_betList._items.length;++i)
	{
		if($jgame_type==1 && $jcheckbox_index==1)
		{
			var item = m_betList._items[i];
			if(item._home_team==$jhome_team && item._away_team==$jaway_team && item._game_type==4 && item._checkbox_index==2)
			{
				return 0;
			}
		}
		else if($jgame_type==4 && $jcheckbox_index==2)
		{
			item = m_betList._items[i];
			if(item._home_team==$jhome_team && item._away_team==$jaway_team && item._game_type==1 && item._checkbox_index==1)
			{
				return 0;
			}
		}
	}

	return 1;
}

// 무+언더
function CheckRule_d_under($jgame_index, $jcheckbox_index, $jgame_type, $jhome_team, $jaway_team) {
	for(var i=0; i<m_betList._items.length;++i)
	{
		if($jgame_type==1 && $jcheckbox_index==1)
		{
			var item = m_betList._items[i];
			if(item._home_team==$jhome_team && item._away_team==$jaway_team && item._game_type==4 && item._checkbox_index==0)
			{
				return 0;
			}
		}
		else if($jgame_type==4 && $jcheckbox_index==0)
		{
			item = m_betList._items[i];
			if(item._home_team==$jhome_team && item._away_team==$jaway_team && item._game_type==1 && item._checkbox_index==1)
			{
				return 0;
			}
		}
	}
	return 1;
}

// 핸디+언더/오버
function checkRule_handi_unov($jgame_index, $jcheckbox_index, $jgame_type, $jhome_team, $jaway_team) {
	for (i = 0; i < m_betList._items.length; ++i) {
		if ($jgame_type == 2) {
			var item = m_betList._items[i];
			if (item._home_team == $jhome_team && item._away_team == $jaway_team && item._game_type == 4) {
				return 0;
			}
		}
		else if ($jgame_type == 4) {
			item = m_betList._items[i];
			if (item._home_team == $jhome_team && item._away_team == $jaway_team && item._game_type == 2) {
				return 0;
			}
		}
	}
	return 1;
}
//-> 축구 -> 동일경기 [승무패-승]+[언더오버-오버]
function checkRule_win_over() {
	for (i = 0; i < m_betList._items.length; i++) {
		var i_item = m_betList._items[i];
		for (j = (i + 1); j < m_betList._items.length; j++) {
			var j_item = m_betList._items[j];
			if (i_item._game_type == 1 && i_item._checkbox_index == 0 && i_item._sport_name == "축구") {
				if (i_item._home_team == j_item._home_team && i_item._away_team == j_item._away_team && j_item._game_type == 4 && j_item._checkbox_index == 0 && j_item._sport_name == "축구") {
					return 0;
				}
			} else if (i_item._game_type == 4 && i_item._checkbox_index == 0 && i_item._sport_name == "축구") {
				if (i_item._home_team == j_item._home_team && i_item._away_team == j_item._away_team && j_item._game_type == 1 && j_item._checkbox_index == 0 && j_item._sport_name == "축구") {
					return 0;
				}
			}
		} //-> end FOR J
	} //-> end FOR I
	return 1;
}

//-> 축구 -> 동일경기 [승무패-승]+[언더오버-언더]
function checkRule_win_under() {
	for (i = 0; i < m_betList._items.length; i++) {
		var i_item = m_betList._items[i];
		for (j = (i + 1); j < m_betList._items.length; j++) {
			var j_item = m_betList._items[j];
			if (i_item._game_type == 1 && i_item._checkbox_index == 0 && i_item._sport_name == "축구") {
				if (i_item._home_team == j_item._home_team && i_item._away_team == j_item._away_team && j_item._game_type == 4 && j_item._checkbox_index == 2 && j_item._sport_name == "축구") {
					return 0;
				}
			} else if (i_item._game_type == 4 && i_item._checkbox_index == 2 && i_item._sport_name == "축구") {
				if (i_item._home_team == j_item._home_team && i_item._away_team == j_item._away_team && j_item._game_type == 1 && j_item._checkbox_index == 0 && j_item._sport_name == "축구") {
					return 0;
				}
			}
		} //-> end FOR J
	} //-> end FOR I
	return 1;
}

//-> 축구 -> 동일경기 [승무패-승]+[언더오버-오버]
function checkRule_win_over() {
	for ( i = 0 ; i < m_betList._items.length ; i++ ) {
		var i_item = m_betList._items[i];
		for ( j = (i+1) ; j < m_betList._items.length ; j++ ) {
			var j_item = m_betList._items[j];
			if ( i_item._game_type == 1 && i_item._checkbox_index == 0 && i_item._sport_name == "축구" ) {
				if ( i_item._home_team == j_item._home_team && i_item._away_team == j_item._away_team && j_item._game_type == 4 && j_item._checkbox_index == 0 && j_item._sport_name == "축구" ) {
					return 0;
				}
			} else if ( i_item._game_type == 4 && i_item._checkbox_index == 0 && i_item._sport_name == "축구" ) {
				if ( i_item._home_team == j_item._home_team && i_item._away_team == j_item._away_team && j_item._game_type == 1 && j_item._checkbox_index == 0 && j_item._sport_name == "축구" ) {
					return 0;
				}
			}
		} //-> end FOR J
	} //-> end FOR I
	return 1;
}

//-> 축구 -> 동일경기 [승무패-승]+[언더오버-언더]
function checkRule_win_under() {
	for ( i = 0 ; i < m_betList._items.length ; i++ ) {
		var i_item = m_betList._items[i];
		for ( j = (i+1) ; j < m_betList._items.length ; j++ ) {
			var j_item = m_betList._items[j];
			if ( i_item._game_type == 1 && i_item._checkbox_index == 0 && i_item._sport_name == "축구" ) {
				if ( i_item._home_team == j_item._home_team && i_item._away_team == j_item._away_team && j_item._game_type == 4 && j_item._checkbox_index == 2 && j_item._sport_name == "축구" ) {
					return 0;
				}
			} else if ( i_item._game_type == 4 && i_item._checkbox_index == 2 && i_item._sport_name == "축구" ) {
				if ( i_item._home_team == j_item._home_team && i_item._away_team == j_item._away_team && j_item._game_type == 1 && j_item._checkbox_index == 0 && j_item._sport_name == "축구" ) {
					return 0;
				}
			}
		} //-> end FOR J
	} //-> end FOR I
	return 1;
}

//-> 축구 -> 동일경기 [승무패-패]+[언더오버-언더]
function checkRule_lose_under() {
	for ( i = 0 ; i < m_betList._items.length ; i++ ) {
		var i_item = m_betList._items[i];
		for ( j = (i+1) ; j < m_betList._items.length ; j++ ) {
			var j_item = m_betList._items[j];
			if ( i_item._game_type == 1 && i_item._checkbox_index == 2 && i_item._sport_name == "축구" ) {
				if ( i_item._home_team == j_item._home_team && i_item._away_team == j_item._away_team && j_item._game_type == 4 && j_item._checkbox_index == 2 && j_item._sport_name == "축구" ) {
					return 0;
				}
			} else if ( i_item._game_type == 4 && i_item._checkbox_index == 2 && i_item._sport_name == "축구" ) {
				if ( i_item._home_team == j_item._home_team && i_item._away_team == j_item._away_team && j_item._game_type == 1 && j_item._checkbox_index == 2 && j_item._sport_name == "축구" ) {
					return 0;
				}
			}
		} //-> end FOR J
	} //-> end FOR I
	return 1;
}

//-> 축구 -> 동일경기 [승무패-패]+[언더오버-오버]
function checkRule_lose_over() {
	for ( i = 0 ; i < m_betList._items.length ; i++ ) {
		var i_item = m_betList._items[i];
		for ( j = (i+1) ; j < m_betList._items.length ; j++ ) {
			var j_item = m_betList._items[j];
			if ( i_item._game_type == 1 && i_item._checkbox_index == 2 && i_item._sport_name == "축구" ) {
				if ( i_item._home_team == j_item._home_team && i_item._away_team == j_item._away_team && j_item._game_type == 4 && j_item._checkbox_index == 0 && j_item._sport_name == "축구" ) {
					return 0;
				}
			} else if ( i_item._game_type == 4 && i_item._checkbox_index == 0 && i_item._sport_name == "축구" ) {
				if ( i_item._home_team == j_item._home_team && i_item._away_team == j_item._away_team && j_item._game_type == 1 && j_item._checkbox_index == 2 && j_item._sport_name == "축구" ) {
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
			if ( i_item._game_type == 1 && i_item._checkbox_index == 0 && i_item._home_team.indexOf("1이닝 득점") > -1 ) {
				if ( i_item._home_team.indexOf(j_item._home_team) > -1 && i_item._away_team.indexOf(j_item._away_team) > -1 && j_item._game_type == 4 && j_item._checkbox_index == 0 ) {
					return 0;
				}
			} else if ( i_item._game_type == 4 && i_item._checkbox_index == 0 && j_item._home_team.indexOf(i_item._home_team) > -1 && j_item._away_team.indexOf(i_item._away_team) > -1 ) {
				if ( j_item._home_team.indexOf("1이닝 득점") > -1 && j_item._game_type == 1 && j_item._checkbox_index == 0 ) {
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
			if ( i_item._game_type == 1 && i_item._checkbox_index == 0 && i_item._home_team.indexOf("1이닝 득점") > -1 ) {
				if ( i_item._home_team.indexOf(j_item._home_team) > -1 && i_item._away_team.indexOf(j_item._away_team) > -1 && j_item._game_type == 4 && j_item._checkbox_index == 2 ) {
					return 0;
				}
			} else if ( i_item._game_type == 4 && i_item._checkbox_index == 2 && j_item._home_team.indexOf(i_item._home_team) > -1 && j_item._away_team.indexOf(i_item._away_team) > -1 ) {
				if ( j_item._home_team.indexOf("1이닝 득점") > -1 && j_item._game_type == 1 && j_item._checkbox_index == 0 ) {
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
			if ( i_item._game_type == 1 && i_item._checkbox_index == 2 && i_item._away_team.indexOf("1이닝 무득점") > -1 ) {
				if ( i_item._home_team.indexOf(j_item._home_team) > -1 && i_item._away_team.indexOf(j_item._away_team) > -1 && j_item._game_type == 4 && j_item._checkbox_index == 2 ) {
					return 0;
				}
			} else if ( i_item._game_type == 4 && i_item._checkbox_index == 2 && j_item._home_team.indexOf(i_item._home_team) > -1 && j_item._away_team.indexOf(i_item._away_team) > -1 ) {
				if ( j_item._away_team.indexOf("1이닝 무득점") > -1 && j_item._game_type == 1 && j_item._checkbox_index == 2 ) {
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
			if ( i_item._game_type == 1 && i_item._checkbox_index == 2 && i_item._home_team.indexOf("1이닝 무득점") > -1 ) {
				if ( i_item._home_team.indexOf(j_item._home_team) > -1 && i_item._away_team.indexOf(j_item._away_team) > -1 && j_item._game_type == 4 && j_item._checkbox_index == 0 ) {
					return 0;
				}
			} else if ( i_item._game_type == 4 && i_item._checkbox_index == 0 && j_item._home_team.indexOf(i_item._home_team) > -1 && j_item._away_team.indexOf(i_item._away_team) > -1 ) {
				if ( j_item._home_team.indexOf("1이닝 무득점") > -1 && j_item._game_type == 1 && j_item._checkbox_index == 2 ) {
					return 0;
				}
			}
		} //-> end FOR J
	} //-> end FOR I
	return 1;
}

//-> 농구 첫3점슛+첫자유투 묶을수 없다.
function checkRule_basketBall_a() {
	for ( i = 0 ; i < m_betList._items.length ; i++ ) {
		var i_item = m_betList._items[i];
		if ( i_item._away_team.indexOf("첫3점슛") > -1 ) {			
			for ( j = (i+1) ; j < m_betList._items.length ; j++ ) {
				var j_item = m_betList._items[j];
				if ( j_item._away_team.indexOf("첫자유투") > -1 && i_item.game_date == j_item.game_date ) {
					return 0;
				}
			}
		}
	}
	return 1;
}

function checkRule($jgame_index, $jcheckbox_index, $jgame_type, $jhome_team, $jaway_team)
{
	for(i=0; i<m_betList._items.length;++i)
	{
		if($jgame_type==1 && $jcheckbox_index==1)
		{
			var item = m_betList._items[i];
			if(item._home_team==$jhome_team && item._away_team==$jaway_team && item._game_type==4 && item._checkbox_index==2)
			{
				return 0;
			}
		}
		else if($jgame_type==4 && $jcheckbox_index==2)
		{
			item = m_betList._items[i];
			if(item._home_team==$jhome_team && item._away_team==$jaway_team && item._game_type==1 && item._checkbox_index==1)
			{
				return 0;
			}
		}
		 		
	}
	return 1;
}

function checkRule_over($jgame_index, $jcheckbox_index, $jgame_type, $jhome_team, $jaway_team)
{
	for(i=0; i<m_betList._items.length;++i)
	{
		if($jgame_type==1 && $jcheckbox_index==1)
		{
			var item = m_betList._items[i];
			if(item._home_team==$jhome_team && item._away_team==$jaway_team && item._game_type==4 && item._checkbox_index==0)
			{
				return 0;
			}
		}
		else if($jgame_type==4 && $jcheckbox_index==0)
		{
			item = m_betList._items[i];
			if(item._home_team==$jhome_team && item._away_team==$jaway_team && item._game_type==1 && item._checkbox_index==1)
			{
				return 0;
			}
		}
		 		
	}
	return 1;
}

function checkRule1($jgame_index, $jcheckbox_index, $jgame_type, $jhome_team, $jaway_team)
{
	for(i=0; i<m_betList._items.length;++i)
	{
		if($jgame_type==1)
		{
			var item = m_betList._items[i];
			if(item._home_team==$jhome_team && item._away_team==$jaway_team && item._game_type==2)
			{
				return 0;
			}
		}
		else if($jgame_type==2)
		{
			item = m_betList._items[i];
			if(item._home_team==$jhome_team && item._away_team==$jaway_team && item._game_type==1)
			{
				return 0;
			}
		}
		 		
	}
	return 1;
}

//-> 축구의 경우 같은경기에서 승무패+언더오버 선택 불가.
function checkRule2($jgame_index, $jcheckbox_index, $jgame_type, $jhome_team, $jaway_team)
{
	for(i=0; i<m_betList._items.length;++i)
	{
		if($jgame_type==1)
		{
			var item = m_betList._items[i];
			if(item._home_team==$jhome_team && item._away_team==$jaway_team && item._game_type==4)
			{
				return 0;
			}
		}
		else if($jgame_type==4)
		{
			item = m_betList._items[i];
			if(item._home_team==$jhome_team && item._away_team==$jaway_team && item._game_type==1)
			{
				return 0;
			}
		}
	}
	return 1;
}

//-> 축구의 경우 같은경기에서 핸디탭+언더오버 선택 불가.
function checkRule3($jgame_index, $jcheckbox_index, $jgame_type, $jhome_team, $jaway_team)
{
	for(i=0; i<m_betList._items.length;++i)
	{
		if($jgame_type==2)
		{
			var item = m_betList._items[i];
			if(item._home_team==$jhome_team && item._away_team==$jaway_team && item._game_type==4)
			{
				return 0;
			}
		}
		else if($jgame_type==4)
		{
			item = m_betList._items[i];
			if(item._home_team==$jhome_team && item._away_team==$jaway_team && item._game_type==2)
			{
				return 0;
			}
		}
	}
	return 1;
}

//-> 동일경기 승패 + 언오버 조합 불가.
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

function filter_team_name($jteam, $jindex/*0=home, 1=away*/)
{
	var filtered="";
	
	if( 0==$jindex)
	{
		pos = $jteam.indexOf("[");
		if( pos!=-1)
		{
			filtered = $jteam.substr(0, pos);
			return filtered;
		}
	}
	else
	{
		pos = $jteam.indexOf("]");
		if( pos!=-1)
		{
			filtered = $jteam.substr(pos+1, $jteam.length-pos);
			return filtered;
		}
	}

	return $jteam;
}

/*
승패-스페셜 조합

승무패와는 조합이 가능.
그외의 게임 타입과는 조합불가.
*/
function check_specified_special_rule($jgame_index, $jis_specified_special, $jgame_type, $jhome_team, $jaway_team)
{
	if($jgame_type!=1)
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
	
	else if(1==$jgame_type && 1==$jis_specified_special)
	{
		$jhome_team = filter_team_name($jhome_team, 0);
		$jaway_team = filter_team_name($jaway_team, 1);
		
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

function del_bet($jgame_index, bonusFlag)
{
	$j("[name="+$jgame_index+"_div] input").each(function(index) {
		this.checked=false;
		index=index+1;
		$jdiv = $j(this).parent();

		if ( index == 1 ) {
			$j(this).parent().attr('class','home');
			$j(this).parent().parent().attr('class','home_box');
			$j(this).parent().find("span[rel=teamH]").attr('class','home_n');
			$j(this).parent().find("span[rel=rateH]").attr('class','home_odd_n');
		} else if ( index == 2 ) {
			$j(this).parent().attr('class','odd_box');
			$j(this).parent().find("span[rel=rateO]").attr('class','odd odd_n');
		} else if ( index == 3 ) {
			$j(this).parent().attr('class','away');
			$j(this).parent().parent().attr('class','away_box');
			$j(this).parent().find("span[rel=teamA]").attr('class','away_n');
			$j(this).parent().find("span[rel=rateA]").attr('class','away_odd_n');
		}
	});

	m_betList.removeItem($jgame_index);
	betcon=betcon.del_one($jgame_index);

	if ( bonusFlag != 1 )	bonus_del(); //시점 관련 버그
	calc();
}

function bet_clear()
{
	var delArray = new Array();
	for(i=0; i<m_betList._items.length;++i)
	{
		delArray[i] = m_betList._items[i]._game_index;
	}
	for(i=0; i<delArray.length; ++i)
	{
		del_bet(delArray[i],1);
	}

	$j("#betMoney").val(MoneyFormat(parseInt(eval("VarMinBet"))));
	m_betList._point = parseInt(eval("VarMinBet"));
}


// ------------------------- item -----------------------------------------------------------------
function Item(game_index, home_team, away_team, chckbox_index, select_rate, home_rate, draw_rate, away_rate, game_type, sub_child_sn, is_specified_special, game_date, league_sn, sport_name) 
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
		re += "||"+this._items[i]._sport_name+"#";
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
	
	//다폴더
	folderBonusHTML();
}

function add_bet_list(item)
{
	var table 	= document.getElementById("tb_list");
	var tr0		= table.insertRow(table.rows.length);
	var tr1 	= table.insertRow(table.rows.length);
	
	//tr 생성
	tr0.id = "tb_row_1_"+item._game_index;
	tr1.id = "tb_row_2_"+item._game_index;
	
	//td 생성
	var td00		= tr0.insertCell(0);
	var td10		= tr1.insertCell(0);
	
	//width 스타일	
	td00.style.width = '100%';
	td10.style.width = '100%';

	//align 스타일
	td00.style.textAlign = 'left';
	td10.style.textAlign = 'left';
	
	var selectedTeam = item._checkbox_index;
	
	var team_name='';
	switch(selectedTeam)
	{
		case '0': selectedTeam="홈"; team_name=item._home_team; break;
		case '1': selectedTeam="무"; team_name=item._home_team; break;
		case '2': selectedTeam="원정"; team_name=item._away_team; break;
	}
	
	var mkPickRow = "<div class=\"sidebar-bet_list\">" +
										"<ul>" +
											"<li class=\"sidebar-bet_list_1\">" + team_name +
												"<p class=\"sidebar-bet_list_2\">"+parseFloat(item._selct_rate).toFixed(2)+" ["+selectedTeam+"]</p>" +
											"</li>" +
											"<a href=\"javascript:del_bet('"+item._game_index+"');\" class=\"sidebar-bet_list_del\"></a>" +
										"</ul>" +
									"</div>";

	//내용 삽입
	td00.innerHTML = mkPickRow;

	//다폴더
	folderBonusHTML();
}

function folderBonusHTML()
{
	var betMoney = $j('#betMoney').val();
	
	betMoney = betMoney.replace(/,/gi,"");
	betMoney = parseInt(betMoney);
	
	gameCount 	= getBetCount();
	
	$jrate = 0;
	if(gameCount==3)		{$jrate=m_bonus3}
	else if(gameCount==4)	{$jrate=m_bonus4}
	else if(gameCount==5)	{$jrate=m_bonus5}
	else if(gameCount==6)	{$jrate=m_bonus6}
	else if(gameCount==7)	{$jrate=m_bonus7}
	else if(gameCount==8)	{$jrate=m_bonus8}
	else if(gameCount==9)	{$jrate=m_bonus9}
	else if(gameCount==10)	{$jrate=m_bonus10}
		
	amount = betMoney*$jrate/100;
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
		case '1': selectedTeam="무승부";break;
		case '2': selectedTeam=awayTeamName; break;
	}
	var $jhtml = "<td><span class='game'>"+homeTeamName+" vs "+awayTeamName+"</span><span class='pick'>"+selectedTeam+"</span><span class='rate'>"+selectedRate+"</span></td>";
	
	return $jhtml;
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
	//처리할 내용이 없음.
}

function betting(type)
{
	var min_bet 	= 0;
	var max_bet 	= 0;
	var max_amount 	= 0;
	
	min_bet 	= parseInt(eval("VarMinBet"));
	max_bet 	= parseInt(eval("VarMaxBet"));
	max_amount 	= parseInt(eval("VarMaxAmount"));

	//1,000원 단위로 배팅가능체크---
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
		warning_popup("배팅할 경기를 선택하십시오.");
		return;
	}
	if(isNaN(m_betList._point))
	{
		warning_popup("배팅하실 금액을 정확히 입력하여 주십시오");
		return;
	}

/*
	if ( page_special_type == 10 || page_special_type == 0 || page_special_type == 1 || page_special_type == 2 ) {
		if ( m_betList._items.length == 1 ) {
			warning_popup("스포츠 배팅은 2폴더 이상부터 가능합니다.");
			return;
		}
	}
*/

	if(game_kind == 'multi')
	{
		if(!check_folder())
			return;
	}

	//단폴더 처리
	if(m_betList._items.length==1)
	{
		if (m_betList._point < min_bet || m_betList._point > m_single_max_bet) 
		{
			if ( m_single_max_bet == 0 ) warning_popup("현재 단폴더 배팅을 허용하지 않고 있으니 자세한 내용은 고객센터로 문의 주세요.");
			else warning_popup("단폴더는 "+MoneyFormat(min_bet)+"~"+MoneyFormat(m_single_max_bet)+"원 사이입니다.");
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
			warning_popup("베팅액은 "+MoneyFormat(min_bet)+"~"+MoneyFormat(max_bet)+"원 사이입니다.");
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
		warning_popup("최대적중금은 "+MoneyFormat(max_amount)+" 를 넘을 수 없습니다.\n\n배팅금액을 배팅최대금액에 맞춥니다.");
		m_betList._point = Math.floor(max_amount/sp_bet);
		betForm.betMoney.value = MoneyFormat(m_betList._point);
		m_betList._totalprice = Math.floor(m_betList._point*sp_bet);
		document.getElementById("sp_total").innerHTML = MoneyFormat(m_betList._totalprice);
		return;
	}
	if (m_betList._items.length == 0)
	{
		warning_popup("베팅할 경기를 선택하십시오.");
		return;
	}
	if (m_betList._totalprice == 0)
	{
		warning_popup("베팅금액을 입력해주세요.");
		return;
	}

	if (m_betList._items.length < m_min_count)
	{
		warning_popup("최소 "+m_min_count+"경기 이상 선택하셔야 합니다.");
		return;
	}
	if (m_betList._items.length > 15)
	{
		warning_popup("최대 15경기까지 선택하실수 있습니다.");
		return;
	}

/*
	if ( m_betList._items.length == 2 && (matchGameWinOver == 1 || matchGameWinUnder == 1 || matchGameLoseOver == 1 || matchGameLoseUnder == 1) ) {
		warning_popup("동일경기(축구) [승무패-승]+[언더오버-언더] 조합은 3폴더 이상부터 가능합니다.");
		return;
	}
*/

	if ( matchGameWinOver == 1 ) {
		warning_popup("동일경기(축구) [승무패-승]+[언더오버-오바] 조합은 배팅이 불가능합니다.");
		return;
	}
	if ( matchGameWinUnder == 1 ) {
		warning_popup("동일경기(축구) [승무패-승]+[언더오버-언더] 조합은 배팅이 불가능합니다.");
		return;
	}
	if ( matchGameLoseOver == 1 ) {
		warning_popup("동일경기(축구) [승무패-패]+[언더오버-오바] 조합은 배팅이 불가능합니다.");
		return;
	}
	if ( matchGameLoseUnder == 1 ) {
		warning_popup("동일경기(축구) [승무패-패]+[언더오버-언더] 조합은 배팅이 불가능합니다.");
		return;
	}

	if ( matchGameFbWinUnder == 1 ) {
		warning_popup("동일경기(야구) [승무패-승]+[언더오버-언더] 조합은 배팅이 불가능합니다.");
		return;
	}
	if ( matchGameFbWinOver == 1 ) {
		warning_popup("동일경기(야구) [승무패-승]+[언더오버-오바] 조합은 배팅이 불가능합니다.");
		return;
	}
	if ( matchGameFbLoseUnder == 1 ) {
		warning_popup("동일경기(야구) [승무패-패]+[언더오버-언더] 조합은 배팅이 불가능합니다.");
		return;
	}
	if ( matchGameFbLoseOver == 1 ) {
		warning_popup("동일경기(야구) [승무패-패]+[언더오버-오버] 조합은 배팅이 불가능합니다.");
		return;
	}

/*
	if ( matchGameFbWinloseUnover == 1 ) {
		warning_popup("동일경기(야구) [승패]+[언오버] 조합은 배팅이 불가능합니다.");
		return;
	}

	if ( m_betList._items.length == 2 && matchGameFbWinUnder == 1 ) {
		warning_popup("동일경기(야구) [승무패-승]+[언더오버-언더] 조합은 3폴더 이상부터 가능합니다.");
		return;
	}

	if ( m_betList._items.length == 2 && matchGameFbWinOver == 1 ) {
		warning_popup("동일경기(야구) [승무패-승]+[언더오버-오바] 조합은 3폴더 이상부터 가능합니다.");
		return;
	}

	if ( m_betList._items.length == 2 && matchGameFbLoseUnder == 1 ) {
		warning_popup("동일경기(야구) [승무패-패]+[언더오버-언더] 조합은 3폴더 이상부터 가능합니다.");
		return;
	}

	if ( m_betList._items.length == 2 && matchGameFbLoseOver == 1 ) {
		warning_popup("동일경기(야구) [승무패-패]+[언더오버-오버] 조합은 3폴더 이상부터 가능합니다.");
		return;
	}

	if ( matchGameBbFtsFfs == 1 ) {
		warning_popup("동일경기(농구) [첫3점슛]+[첫자유투] 조합 배팅은 불가능 합니다..");
		return;
	}
*/
	if (m_betList._point>VarMoney)
	{
		warning_popup("금액이 부족합니다.");
		return;
	}
	if (type == "cart")
	{
		betForm.mode.value = type;
	}
	else 
	{
		betForm.mode.value = "betting";
		if (!confirm("배팅완료 "+bettingcanceltime+"분이내, 경기시작 "+bettingcancelbeforetime+"분전에만 취소가능합니다.\n확인클릭후 배팅 완료됩니다")) 
		{
			return;
		}
	}

	if ( bettingSubmitFlag == 0 ) {
		bettingSubmitFlag = 1;
		betForm.betMoney.value = m_betList._point;
		betForm.betcontent.value = m_betList.getList();
		betForm.submit();
	} else {
		warning_popup("배팅 처리중입니다. 잠시기다려주세요.\n\n장시간 응답이 없으면 F5를 눌러 새로고침 후 재배팅 부탁드립니다.");
	}
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

///********************보너스배당   관련 스크립트************************************************************/ 
function folder_bonus(val) {
	var foldersum;
	//보너스 명에 따른 폴더수를 비교 한다. 
	if(val.indexOf("2폴더") > -1){
		foldersum = "2";
	}else if(val.indexOf("3폴더") > -1){
		foldersum = "3";	
	}else if(val.indexOf("4폴더") > -1){
		foldersum = "4";	
	}else if(val.indexOf("5폴더") > -1){
		foldersum = "5";	
	}else if(val.indexOf("6폴더") > -1){
		foldersum = "6";	
	}else if(val.indexOf("7폴더") > -1){
		foldersum = "7";
	}else{
		foldersum = "0";
	}

	if(foldersum =="0"){
		warning_popup("잘못된 값입니다. 관리자에게 문의 하세요");
		return 0;
	} 
	
	//폴더를 비교 해서  작으면   꺼지샘한다
	if ( m_betList._items.length < foldersum ) {
		warning_popup("[보너스]는 "+foldersum+"폴더 이상 선택 후 이용해주세요.");
		return 0;
	} 

	//기존에  보너스가 포함 되어있는지 본다.... 
	//보너스가 없는 값 수가   지금 폴더 값이랑  맞는가  체크를 위해   
	var realcount  = "0";
	for ( i = 0 ; i < m_betList._items.length ; i++ ) {
		var item = m_betList._items[i];
			if ( item._home_team.indexOf("보너스") <= -1 ) {
				realcount =eval(realcount)+1;
			}
	}
	//폴더를 비교 해서  작으면   꺼지샘한다
	if ( realcount < foldersum ) {
		warning_popup("[보너스]는 "+foldersum+"폴더 이상 선택 후 이용해주세요.");
		return 0;
	}
	

	//보너스가 있으면 그냥 지운다  사정 없이 지운다 
	for ( i = 0 ; i < m_betList._items.length ; i++ ) {
		var item = m_betList._items[i];
		if ( item._home_team.indexOf("보너스") > -1 ) {
			toggle_action = toggle(item._game_index+'_div', item._index, item._selectedRate);
			m_betList.removeItem(item._game_index);
			betcon=betcon.del_element(item._game_index+"|"+item._index+"&"+item._home_team+"  VS "+item._away_team);
		}
	}
	return 1;
}

//-> 2폴더(보너스포함) 이하이고 선택 게임중 [보너스]가 있으면 삭제
function bonus_del(){	
	var truncount = "0";	
	for ( i = 0 ; i < m_betList._items.length ; i++ ) {
		var item = m_betList._items[i];
		if ( item._home_team.indexOf("2폴더") > -1 ) {
			truncount= "2";
		} else if ( item._home_team.indexOf("3폴더") > -1 ) {
			truncount= "3";
		} else if ( item._home_team.indexOf("4폴더") > -1 ) {
			truncount= "4";
		} else if ( item._home_team.indexOf("5폴더") > -1 ) {
			truncount= "5";
		} else if ( item._home_team.indexOf("6폴더") > -1 ) {
			truncount= "6";
		} else if ( item._home_team.indexOf("7폴더") > -1 ) {
			truncount= "7";		
		}
	}

	var realcount = "1";
	for ( i = 0 ; i < m_betList._items.length ; i++ ) {
		var item = m_betList._items[i];
		if ( item._home_team.indexOf("보너스") <= -1 ) {
			realcount = eval(realcount)+1;
		}
	}
	
	if ( realcount-1 < truncount ) {
		for ( i = 0 ; i < m_betList._items.length ; i++ ) {
			var item = m_betList._items[i];
			if ( item._home_team.indexOf("보너스") > -1 ) {
				toggle_action = toggle(item._game_index+'_div', item._index, item._selectedRate);
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
		if (item._home_team.indexOf("보너스") <= -1) {
			realcount = eval(realcount) + 1;
		}
	}

	/*if (realcount - 1 < truncount) {
		warning_popup("승무패배팅시 2폴더부터, 조합배팅시 3폴더부터 배팅가능합니다.");
		return false;
	}*/

	return true;
}