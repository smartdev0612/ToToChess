var itemstr = '<style="margin-left: 10px;"><table border="0" cellpadding="0" cellspacing="0"  width="100%">\n';
itemstr += '  <tr>\n';
itemstr += '    <td style="font-size:11px; padding:2px;"><font color="#feac6f"><b>홈</b> $team1</font></td>\n';
itemstr += '    <td align="right" style="font-size:11px; padding:2px;"><font color="ff0000">$betteam </font><a href="javascript:del_bet($betid)"><img src="../images/btn_x.gif" border="0"></a></td>\n';
itemstr += '  </tr>\n';
itemstr += '  <tr>\n';
itemstr += '    <td style="font-size:11px;color:#cccccc; padding:2px;"><b>원</b> $team2</td>\n';
itemstr += '    <td align="right" style="font-size:11px; padding:2px;"><font color="cccccc">$ratio</font></td>\n';
itemstr += '  </tr>\n';
itemstr += '  <tr><td colspan="2"></td></tr>\n';
itemstr += '</table>\n';

var betcon= new Array();

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

function changeBox($checkBox)
{
    checkBox = eval($checkBox);
    if(checkBox==undefined)
    {
        //alert("Undefined CheckBox");
    }
    else
    {
	    add_bet(checkBox);
    }
}

function onTeamSelect($checkBox)
{
    checkBox = eval($checkBox);
    if(checkBox==undefined)
    {
        alert("Undefined CheckBox");
    }
    else
    {
	    add_bet(checkBox);
    }
}

function onPopularTeamSelect($checkBox)
{
    checkBox = eval($checkBox);
    
    if(checkBox==undefined)
    {
        alert("Undefined CheckBox");
    }
    else
    {
	    popular_add_bet(checkBox);
    }
}

function check_bet(e)
{
	if (window.event)
	{
		e = window.event;
	}
	var checkBox = getSrcElement(e);
	add_bet(checkBox);
}

function isMaxGameCount()
{
	var list=bet.getList();
	
	if(list!="")
	{
		var flag=false;
		var aler_buy_arr=list.split("#");
		var aler_xxx="";
		var obj_num="";
			
		if(aler_buy_arr.length>=11)
		{
			for(var i=0;i<aler_buy_arr.length-1;i++)
			{
				aler_xxx=aler_buy_arr[i].split("||");
				obj_num=aler_xxx[0];
				
				if(parseInt(obj_num)==parseInt(num))
				{
					flag=true;
					break;
				}
			}
			if(!flag)
			{
				alert("최대 10경기까지 선택하실수 있습니다");
				return true;
			}	
		}
	}
	return false;
}

function popular_add_bet(selectedCheckBox)
{
	var num 	= selectedCheckBox.getAttribute("num");
	var lnum 	= selectedCheckBox.getAttribute("lnum");
	
	var popularHomeTeamCheckbox = document.getElementById("popular_chk1_"+num);
	var popularAwayTeamCheckbox = document.getElementById("popular_chk2_"+num);
	var popularDrawTeamCheckbox = document.getElementById("popular_chk3_"+num);
	
	var homeTeamCheckbox = document.getElementById("chk1_"+num);
	var awayTeamCheckbox = document.getElementById("chk2_"+num);
	var drawTeamCheckbox = document.getElementById("chk3_"+num);
	
	if(isMaxGameCount()==true)
		return false;
	
	<!-- 토글 -->
	if(selectedCheckBox==popularHomeTeamCheckbox)
	{
		popularHomeTeamCheckbox.checked = !popularHomeTeamCheckbox.checked;
		popularDrawTeamCheckbox.checked = false;
		popularAwayTeamCheckbox.checked = false;
		
		homeTeamCheckbox.checked = !popularHomeTeamCheckbox.checked;
		drawTeamCheckbox.checked = false;
		awayTeamCheckbox.checked = false;
	}
	else if(selectedCheckBox==popularDrawTeamCheckbox)
	{
		popularDrawTeamCheckbox.checked= !popularDrawTeamCheckbox.checked;
		popularHomeTeamCheckbox.checked = false;
		popularAwayTeamCheckbox.checked = false;
		
		drawTeamCheckbox.checked= !popularDrawTeamCheckbox.checked;
		homeTeamCheckbox.checked = false;
		awayTeamCheckbox.checked = false;
	}
	else if(selectedCheckBox==popularAwayTeamCheckbox)
	{
		popularAwayTeamCheckbox.checked = !popularAwayTeamCheckbox.checked;
		popularHomeTeamCheckbox.checked = false;
		popularDrawTeamCheckbox.checked = false;
		
		awayTeamCheckbox.checked = !popularAwayTeamCheckbox.checked;
		homeTeamCheckbox.checked = false;
		drawTeamCheckbox.checked = false;
	}
	
	<!-- 백그라운 변경 -->
	if(popularHomeTeamCheckbox.checked==true) 	
	{
		document.getElementById("popular_home_"+num).setAttribute('class', 'home_on');
		document.getElementById("home_"+num).setAttribute('class', 'home_on');
	}
	else
	{
		document.getElementById("popular_home_"+num).setAttribute('class', 'home');
		document.getElementById("home_"+num).setAttribute('class', 'home');
	}
	
	if(popularDrawTeamCheckbox.checked==true)
	{
		document.getElementById("popular_draw_"+num).setAttribute('class', 'draw_on');
		document.getElementById("draw_"+num).setAttribute('class', 'draw_on');
	}
	else
	{
		document.getElementById("popular_draw_"+num).setAttribute('class', 'draw');
		document.getElementById("draw_"+num).setAttribute('class', 'draw');
	}
	
	if(popularAwayTeamCheckbox.checked==true)
	{
		document.getElementById("popular_away_"+num).setAttribute('class', 'away_on');
		document.getElementById("away_"+num).setAttribute('class', 'away_on');
	}
	else
	{
		document.getElementById("popular_away_"+num).setAttribute('class', 'away');
		document.getElementById("away_"+num).setAttribute('class', 'away');
	}
	
	
	var homeTeamName = document.getElementById("popular_team1_"+num).innerHTML;
	var awayTeamName = document.getElementById("popular_team2_"+num).innerHTML;
	var selectedRate = document.getElementById("popular_bet"+selectedCheckBox.value+"_"+num).innerHTML;
	var bet1  = document.getElementById("popular_bet1_"+num);
	var bet2 = document.getElementById("popular_bet2_"+num);
	var bet3 = document.getElementById("popular_bet3_"+num);

	if(bet1) {bet1 = bet1.innerHTML;}
	if(bet2) {bet2 = bet2.innerHTML;}
	if(bet3) {bet3 = bet3.innerHTML;} 
	else 	 {bet3="0";}
	
	var obj = document.getElementById("popular_num_"+num);
	var gametype = obj.getAttribute("gametype");
	if (!gametype) 
	{
		alert('gametype:n');
	}

	//add game
	if (selectedCheckBox.checked) 
	{
		var item = new Item(num, homeTeamName, awayTeamName, selectedCheckBox.value, selectedRate, bet1, bet2, bet3, gametype, lnum);
		bet.addItem(item);
		betcon=betcon.add_element(num+"|"+selectedCheckBox.value+"&"+homeTeamName+"  VS "+awayTeamName);
		var isdisabled = true;
	}
	//delete game
	else 
	{
		bet.removeItem(num);
		if (bet._items.length < 1) 
		{
			displaymess(true);
		}
		betcon=betcon.del_element(num+"|"+selectedCheckBox.value+"&"+homeTeamName+"  VS "+awayTeamName);
		var isdisabled = false;
	}

	if (gametype == '1' || gametype == '2') 
	{
		var arr = document.getElementsByTagName("input");
		if (arr.length) 
		{
			for (i=0; i<arr.length; i++) 
			{
				if (arr[i].getAttribute("type") == 'selectedCheckBox') 
				{
					var arrLnum = arr[i].getAttribute("lnum");
					var arrNum = arr[i].getAttribute("num");
					var arrBet = arr[i].getAttribute("bet");
					var arrGt = arr[i].getAttribute("gt");
					if (arrGt == '1' || arrGt == '2')
					{
						if (arrLnum == lnum && arrNum != num && arrGt != gametype) 
						{
							if (arrBet != '0')
							{
								arr[i].disabled = isdisabled;
							}
							else 
							{
								arr[i].disabled = true;
							}
						}
					}
				}
			}
		}
	}

	var iGameCount = tb_list.rows.length;
	
	if (iGameCount > 10)
	{
		alert("최대 10경기까지 선택하실수 있습니다.");
		return false;
	}
	else
	{
		calc();
	}	
}

function add_bet(selectedCheckBox)
{
	var num 	= selectedCheckBox.getAttribute("num");
	var lnum 	= selectedCheckBox.getAttribute("lnum");
	
	var homeTeamCheckbox = document.getElementById("chk1_"+num);
	var awayTeamCheckbox = document.getElementById("chk2_"+num);
	var drawTeamCheckbox = document.getElementById("chk3_"+num);
	
	var popularHomeTeamCheckbox = document.getElementById("popular_chk1_"+num);
	var popularAwayTeamCheckbox = document.getElementById("popular_chk2_"+num);
	var popluarDrawTeamCheckbox = document.getElementById("popular_chk3_"+num);
	
	var hasPopularGame = (popularHomeTeamCheckbox!=null && popularAwayTeamCheckbox!=null && popluarDrawTeamCheckbox!=null);
	
	if(isMaxGameCount()==true)
		return false;
	
	<!-- 토글 -->
	if(selectedCheckBox==homeTeamCheckbox)
	{
		homeTeamCheckbox.checked = !homeTeamCheckbox.checked;
		drawTeamCheckbox.checked = false;
		awayTeamCheckbox.checked = false;
		
		if(hasPopularGame)
		{
			popularHomeTeamCheckbox.checked = !popularHomeTeamCheckbox.checked;
			popluarDrawTeamCheckbox.checked = false;
			popularAwayTeamCheckbox.checked = false;
		}
	}
	else if(selectedCheckBox==drawTeamCheckbox)
	{
		drawTeamCheckbox.checked = !drawTeamCheckbox.checked;
		homeTeamCheckbox.checked = false;
		awayTeamCheckbox.checked = false;
		
		if(hasPopularGame)
		{
			popluarDrawTeamCheckbox.checked = !popluarDrawTeamCheckbox.checked;
			popularHomeTeamCheckbox.checked = false;
			popularAwayTeamCheckbox.checked = false;
		}
	}
	else if(selectedCheckBox==awayTeamCheckbox)
	{
		awayTeamCheckbox.checked = !awayTeamCheckbox.checked;
		homeTeamCheckbox.checked = false;
		drawTeamCheckbox.checked = false;
		
		if(hasPopularGame)
		{
			popularAwayTeamCheckbox = !popularAwayTeamCheckbox;
			popularHomeTeamCheckbox.checked = false;
			popluarDrawTeamCheckbox.checked = false;
		}
	}
	
	<!-- 백그라운 변경 -->
	if(homeTeamCheckbox.checked==true) 	{document.getElementById("home_"+num).setAttribute('class', 'home_on');}
	else																{document.getElementById("home_"+num).setAttribute('class', 'home');}
	
	if(drawTeamCheckbox.checked==true)	{document.getElementById("draw_"+num).setAttribute('class', 'draw_on');}
	else																{document.getElementById("draw_"+num).setAttribute('class', 'draw');}
	
	if(awayTeamCheckbox.checked==true)	{document.getElementById("away_"+num).setAttribute('class', 'away_on');}
	else																{document.getElementById("away_"+num).setAttribute('class', 'away');}
	
	if(hasPopularGame)
	{
		if(homeTeamCheckbox.checked==true) 	{document.getElementById("popular_home_"+num).setAttribute('class', 'home_on');}
		else																{document.getElementById("popular_home_"+num).setAttribute('class', 'home');}
	
		if(drawTeamCheckbox.checked==true)	{document.getElementById("popular_draw_"+num).setAttribute('class', 'draw_on');}
		else										{document.getElementById("popular_draw_"+num).setAttribute('class', 'draw');}
	
		if(awayTeamCheckbox.checked==true)	{document.getElementById("popular_away_"+num).setAttribute('class', 'away_on');}
		else										{document.getElementById("popular_away_"+num).setAttribute('class', 'away');}
	}
	
	var homeTeamName = document.getElementById("team1_"+num).innerHTML;
	var awayTeamName = document.getElementById("team2_"+num).innerHTML;
	var selectedRate = document.getElementById("bet"+selectedCheckBox.value+"_"+num).innerHTML;
	var bet1  = document.getElementById("bet1_"+num);
	var bet2 = document.getElementById("bet2_"+num);
	var bet3 = document.getElementById("bet3_"+num);

	if(bet1) {bet1 = bet1.innerHTML;}
	if(bet2) {bet2 = bet2.innerHTML;}
	if(bet3) {bet3 = bet3.innerHTML;} 
	else 	 {bet3="0";}
	
	var obj = document.getElementById("num_"+num);
	var gametype = obj.getAttribute("gametype");
	if (!gametype) 
	{
		alert('gametype:n');
	}

	//add game
	if (selectedCheckBox.checked) 
	{
		var item = new Item(num, homeTeamName, awayTeamName, selectedCheckBox.value, selectedRate, bet1, bet2, bet3, gametype, lnum);
		bet.addItem(item);
		betcon=betcon.add_element(num+"|"+selectedCheckBox.value+"&"+homeTeamName+"  VS "+awayTeamName);
		var isdisabled = true;
	}
	//delete game
	else 
	{
		bet.removeItem(num);
		if (bet._items.length < 1) 
		{
			displaymess(true);
		}
		betcon=betcon.del_element(num+"|"+selectedCheckBox.value+"&"+homeTeamName+"  VS "+awayTeamName);
		var isdisabled = false;
	}

	if (gametype == '1' || gametype == '2') 
	{
		var arr = document.getElementsByTagName("input");
		if (arr.length) 
		{
			for (i=0; i<arr.length; i++) 
			{
				if (arr[i].getAttribute("type") == 'selectedCheckBox') 
				{
					var arrLnum = arr[i].getAttribute("lnum");
					var arrNum = arr[i].getAttribute("num");
					var arrBet = arr[i].getAttribute("bet");
					var arrGt = arr[i].getAttribute("gt");
					if (arrGt == '1' || arrGt == '2')
					{
						if (arrLnum == lnum && arrNum != num && arrGt != gametype) 
						{
							if (arrBet != '0')
							{
								arr[i].disabled = isdisabled;
							}
							else 
							{
								arr[i].disabled = true;
							}
						}
					}
				}
			}
		}
	}

	var iGameCount = tb_list.rows.length;
	
	if (iGameCount > 10)
	{
		alert("최대 10경기까지 선택하실수 있습니다.");
		return false;
	}
	else
	{
		calc();
	}	
}

function del_bet(num)
{
	var homeTeamCheckbox = document.getElementById("chk1_"+num);
	var awayTeamCheckbox = document.getElementById("chk2_"+num);
	var drawTeamCheckbox = document.getElementById("chk3_"+num);
	
	var popularHomeTeamCheckbox = document.getElementById("popular_chk1_"+num);
	var popularAwayTeamCheckbox = document.getElementById("popular_chk2_"+num);
	var popularDrawTeamCheckbox = document.getElementById("popular_chk3_"+num);
	
	var hasPopularGame = (popularHomeTeamCheckbox!=null && popularAwayTeamCheckbox!=null && popularDrawTeamCheckbox!=null);
	
	homeTeamCheckbox.checked=false;
	awayTeamCheckbox.checked=false;
	drawTeamCheckbox.checked=false;
	
	if(hasPopularGame)
	{
		popularHomeTeamCheckbox.checked=false;
		popularAwayTeamCheckbox.checked=false;
		popularDrawTeamCheckbox.checked=false;
		document.getElementById("popular_home_"+num).setAttribute('class', 'home');
		document.getElementById("popular_away_"+num).setAttribute('class', 'away');
		document.getElementById("popular_draw_"+num).setAttribute('class', 'draw');
	}
	
	document.getElementById("home_"+num).setAttribute('class', 'home');
	document.getElementById("away_"+num).setAttribute('class', 'away');
	document.getElementById("draw_"+num).setAttribute('class', 'draw');

	bet.removeItem(num);
	betcon=betcon.del_one(num);
	
	if (bet._items.length < 1) 
	{
		displaymess(true);
	}
	calc();
}

function del_bet_all()
{
	var delArray = new Array();
	for(i=0; i<bet._items.length;++i)
	{
		delArray[i] = bet._items[i]._betid;
	}
	for(i=0; i<delArray.length; ++i)
	{
		del_bet(delArray[i]);
	}
}


// array bet

var bet = new BetList();

function Item(betid, team1, team2, betteam, ratio, bet1, bet2, bet3, gametype, lnum) 
{
	this._betid = betid;
	this._team1 = team1;
	this._team2 = team2;
	this._betteam = betteam;
	this._ratio = ratio;
	this._bet1 = bet1;
	this._bet2 = bet2;
	this._bet3 = bet3;
	this._gametype = gametype;
	this._lnum = lnum;
}
Item.prototype._betid;
Item.prototype._team1;
Item.prototype._team2;
Item.prototype._betteam;
Item.prototype._ratio;
Item.prototype._bet1;
Item.prototype._bet2;
Item.prototype._bet3;
Item.prototype._gametype;
Item.prototype._lnum;

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
	this.removeItem(item._betid);
	this._items.push(item);
	add_bet_list(item);
}

BetList.prototype.removeItem = function(num) 
{
	var pos = -1;

	for (var i = 0; i<this._items.length; i++) 
	{
		if (this._items[i]._betid == num) 
		{
			pos = i;
			break;
		}
	}
	if (pos>=0) 
	{
		del_bet_list(num);
		this._items.remove(pos, pos);
	}
}

BetList.prototype.getList = function() 
{
	var re = "";
	for (var i = 0; i<this._items.length; i++) 
	{
		re += this._items[i]._betid
		re += "||"+this._items[i]._betteam
		re += "||"+this._items[i]._team1
		re += "||"+this._items[i]._team2
		re += "||"+this._items[i]._bet1
		re += "||"+this._items[i]._bet2
		re += "||"+this._items[i]._bet3
		re += "||"+this._items[i]._ratio
		re += "||"+this._items[i]._gametype
		re += "||"+this._items[i]._lnum+"#";
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
		this._bet = this._bet*(this._items[i]._ratio*100);
		this._bet = this._bet/100;
	}
	this._bet = Floor(this._bet, 2);
	this._totalprice = Math.floor(this._point*this._bet);
}

BetList.prototype.ClearAll = function() 
{
	this._items = new Array();
	var tb = getObject("tb_list");
	while (tb.rows.length>0) 
	{
		tb.deleteRow(0);
	}
	var arr = document.getElementsByTagName("input");
	if (arr.length) 
	{
		for (i=0; i<arr.length; i++) 
		{
			if (arr[i].checked) 
			{
				arr[i].checked = false;
				//-------lbg for cancel bet color
				var arrNum = arr[i].getAttribute("num");
				if(arrNum !=null)
				{
				var teama = getObject("teama_"+arrNum);
				var teamb = getObject("teamb_"+arrNum);
				var teamc = getObject("teamc_"+arrNum);
				teama.style.backgroundColor = "";
				teama.style.color = "";
				teamb.style.backgroundColor = "";
				teamb.style.color="";
				if(teamc !=false)
				{
					teamc.style.backgroundColor = "";
					teamc.style.color = "";
				}
			
			}
			//--------lbg for cancel bet color
			}
			if (arr[i].disabled) 
			{
				var arrBet = arr[i].getAttribute("bet");
				//alert(arrBet)
				if (arrBet != '0')
				{
					arr[i].disabled = false;
				}
				else {
					arr[i].disabled = true;
				}
			}
			
		}
	}
	this.exec();
}

function del_bet_list(num) 
{
	var tb = document.getElementById("tb_list");
	var row = getObject("tb_row_"+num);
	tb.deleteRow(row.rowIndex);
}

function add_bet_list(item)
{
	var table 	= document.getElementById("tb_list");
	var tr 		= table.insertRow(table.rows.length);
	tr.id 		= "tb_row_"+item._betid;
	
	var td0		= tr.insertCell(0);
	var td1		= tr.insertCell(1);
	var td2		= tr.insertCell(2);
	
	td0.innerHTML = "<td valign='top'><input type='checkbox' checked></td>";
	td1.innerHTML = get_item_html(item);
	td2.innerHTML = "<td valign='top'><a href=javascript:del_bet("+item._betid+");><img src='img/bet_btn_del.gif' title='삭제'></a></td>";
}

function get_item_html(item) 
{
	var gameType 	 = item._gametype;
	var homeTeamName = item._team1;
	var awayTeamName = item._team2;
	var selectedRate = item._ratio;
	var selectedTeam = item._betteam;
	
	switch(selectedTeam)
	{
		case '1': selectedTeam=homeTeamName; break;
		case '2': selectedTeam=awayTeamName; break;
		case '3': selectedTeam="무승부";break;
	}
	return "<td><span class='game'><label class='blind'>[선택게임]</label>"+homeTeamName+" vs "+awayTeamName+"</span><span class='pick'><label class='blind'>[배팅팀]</label>"+selectedTeam+"</span><span class='rate'><label class='blind'>[배당률]</label>"+selectedRate+"</span></td>";
}

function calc() 
{
	var point = document.getElementById("betMoney").value;
	
	point = point.replace(/,/gi,"");
	point = parseInt(point);
	bet.setPoint(point);
	bet.exec();
	var betstr = bet._bet;
	if (betstr.toFixed)
	{
		betstr = betstr.toFixed(2);
	}
	
	document.getElementById("sp_bet").innerHTML = betstr;
	document.getElementById("sp_total").innerHTML =MoneyFormat(bet._totalprice);
	
	betForm.result_rate.value = betstr;
	betlist=bet.getList();
	strParam="betlist="+betlist;
	
	makePOSTRequest("../race/betsave.php",strParam);
}

function betting(type)
{
	var min_bet = 0;
	var max_bet = 0;
	var max_amount = 0;
	min_bet = parseInt(eval("VarMinBet"));
	max_bet = parseInt(eval("VarMaxBet"));
	max_amount = parseInt(eval("VarMaxAmount"));

	//1,000원 단위로 배팅가능체크---
	var iLen = String(bet._point).length;
	rlen_money = (String(bet._point).substring(iLen,iLen - 3))
	rlen_money = String(rlen_money);

	var sp_bet=bet._bet;
	if(isNaN(sp_bet))
	{
		alert("배팅할 경기를 선택하십시오.");
		return;
	}
	if(isNaN(bet._point))
	{
		alert("배팅하실 금액을 정확히 입력하여 주십시오");
		return;
	}
	if (bet._point<min_bet || bet._point>max_bet) 
	{
		alert("베팅액은 "+MoneyFormat(min_bet)+"~"+MoneyFormat(max_bet)+"원 사이입니다.");
		return;
	}
	if (bet._totalprice>max_amount) 
	{
		alert("최대적중금은 "+MoneyFormat(max_amount)+" 를 넘을 수 없습니다.");
		return;
	}
	if (bet._totalprice == 0 || bet._items.length == 0)
	{
		alert("베팅할 경기를 선택하십시오.");
		return;
	}
	if (bet._items.length < 1) 
	{
		alert("최소 1경기 이상 선택하실수 있습니다.");
		return;
	}
	if (bet._items.length > 10)
	{
		alert("최대 10경기까지 선택하실수 있습니다.");
		return;
	}

	if (bet._point>VarMoney)
	{
		alert("베팅금액이 현재금보다 클 수 없습니다.");
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
	betForm.betMoney.value = bet._point;
	betForm.betcontent.value = bet.getList();
	betForm.submit();
}

function add_cart(type)
{
	var min_bet = 0;
	var max_bet = 0;
	var max_amount = 0;
	min_bet = parseInt(eval("VarMinBet"));
	max_bet = parseInt(eval("VarMaxBet"));
	max_amount = parseInt(eval("VarMaxAmount"));

	//1,000원 단위로 배팅가능체크---
	var iLen = String(bet._point).length;
	rlen_money = (String(bet._point).substring(iLen,iLen - 3))
	rlen_money = String(rlen_money);
	
	if (bet._point<min_bet || bet._point>max_bet)
	{
		alert("베팅액은 "+MoneyFormat(min_bet)+"~"+MoneyFormat(max_bet)+"원 사이입니다.");
		return;
	}
	if (bet._totalprice>max_amount)
	{
		alert("최대적중금은 "+MoneyFormat(max_amount)+"를 넘을 수 없습니다.");
		return;
	}
	if (bet._totalprice == 0 || bet._items.length == 0)
	{
		alert("베팅할 경기를 선택하십시오.");
		return;
	}
	if (bet._items.length < 1)
	{
		alert("최소 1경기 이상 선택하실수 있습니다.");
		return;
	}
	if (bet._items.length > 10)
	{
		alert("최대 10경기까지 선택하실수 있습니다.");
		return;
	}

	if(bet._point>VarMoney)
	{
		alert("베팅금액이 현재금보다 클 수 없습니다.");
		return;
	}
	if(type == "cart") 
	{
		betForm.mode.value = type;
	}
	else 
	{
		betForm.mode.value = "betting";
		if (!confirm("배팅완료 "+bettingcanceltime+"분이내, 경기시작 "+bettingcancelbeforetime+"분전까지만 취소가능합니다.\n확인클릭후 배팅 완료됩니다")) 
		{
			return;
		}
	}
	betForm.betmoney.value = bet._point;
	betForm.betcontent.value = bet.getList();
	betForm.action="add_cart.php";
	betForm.submit();
}

function init() 
{
	return;
}

function del_all() 
{
	bet.ClearAll();
	displaymess(true);
	betcon= new Array();
	calc();
}

function print_arr(arr)
{
	for(var i=0;i<arr.length;i++)
	{
		alert(arr[i]);
	}
}

function check_repeat()
{
	var betstrarr=bet.getList().split("#");
	for(var x=0;x<betstrarr.length-2;x++)
	{
		var srcstr=betstrarr[x].split("||");
		for(var m=x+1;m<betstrarr.length-1;m++)
		{
			var objstr=betstrarr[m].split("||");
			if(trim(srcstr[2])==trim(objstr[2]) && trim(srcstr[3])==trim(objstr[3]))
			{
				if((srcstr[8]==1 && objstr[8]==4 && srcstr[1] ==3 && objstr[1]==2) || (srcstr[8]==4 && objstr[8]==1 && srcstr[1]==2 && objstr[1]==3))
				{
					alert("무+언더 조합배팅이 불가능합니다 .확인하여 주십시오.\n"+srcstr[2] +" VS "+ srcstr[3]);
					return true;
				}
			}
		}
	}

	if(betmsg=="")
	{
		return false;
	}
	var betarr=betmsg.split(",");
	var repeatbet="";
	var xxx=0;
	var falg=false;
	myout:for(var x=0;x<betcon.length;x++)
	{
		var repeatcount=0;
		betconcrete=betcon[x].split("&");
		var betthis=betconcrete[0].split("|");
		var comstr=betthis[1];
		//alert(betarr);
		for(var i=0;i<betarr.length;i++)
		{
			var betone =betarr[i].split("$");
			var betrace=betone[1].split("#");

			for(var m=0;m<betrace.length;m++)
			{
				var objcomstr=betrace[m].split("|");
				if(betthis[0]==objcomstr[0])
				{
					comstr=comstr+","+objcomstr[1];
					//alert(comstr);
					if(combetrace(comstr))
					{
						repeatbet=betconcrete[1];
						
						alert(repeatbet+"\n[승]  [무] [패] 를 모두 배팅할수 없습니다.");
						falg=true;
					
						return falg;
					}
				}
			}

			for(var j=0;j<betrace.length;j++)
			{
				if(betconcrete[0]==betrace[j])
				{
					repeatcount++;
					//alert("aa"+repeatcount);
					if(repeatcount>=3)//这时表示一赛比赛不可以押4次
					{
						repeatbet=betconcrete[1];
						//playSound('../voice/tiyong.wav');//调用声音
						alert(repeatbet+" 3번이상 배팅할수 없습니다.");  //押注达到3次
						falg=true;
						//break myout;
						return falg;
					}
				}
			}
		}
	}

	orout:for(var i=0;i<betarr.length;i++)
	{
		var betone=betarr[i].split("$");
		var betrace=betone[1].split("#")
		if(betcon.length==1 && betone[2]==1)
		{
			var betxxx=betcon[0].split("&");
			if(betxxx[0]==betone[1])
			{
				alert("한개 경기를 중복으로 배팅할수 없습니다.\n"+betxxx[1]);
				falg=true;
				return falg;
			}
		}
		var betnum=getLimitBet(betcon.length,betone[2]);
		var reprecord="";
		var repeatcount=0;
		for(var j=0;j<betrace.length;j++)
		{
			for(var x=0;x<betcon.length;x++)
			{
				betconox=betcon[x].split("&");
				if(betrace[j]==betconox[0])
				{
					repeatcount++;
					reprecord=reprecord+betconox[1]+"\n";

					if(repeatcount>betnum)
					{
						alert("중복 배팅입니다. 확인하여 주십시오.\n"+reprecord);//重复押注
						falg=true;
						return falg;
					}
				}
			}
		}
	}

	return falg;
}

function getLimitBet(srcbet,objbet)
{
	var c=srcbet>objbet?objbet:srcbet;
	var betrenum;
	if(c>=1 && c<=4)
	{
		betrenum=1;
	}
	else if(c>=5 && c<=6)
	{
		betrenum=2;
	}
	else if(c>=7)
	{
		betrenum=3;
	}
	return betrenum;
}

function playSound(src)
{ 
	var _s = document.getElementById('snd'); 
	if(src!='' && typeof src!=undefined)
	{ 
		_s.src = src; 
	} 
} 

function combetrace(src)
{
	var falg=true;
	if(src.indexOf("1")<0 || src.indexOf("2")<0 ||src.indexOf("3")<0)
	{
		falg=false;
	}
	return falg;
}

function displaymess(falg)
{
	/*
	var notice=getObject("notice");
	if(falg)
	{
		notice.style.display="";
	}else
	{
		notice.style.display="none";
	}
	*/
}

var xmlHttp;

function GetXmlHttpObject()
{
	 var xmlHttp=null;
	
	 try
	 {
		  // Firefox, Opera 8.0+, Safari
		  xmlHttp = new XMLHttpRequest();
	 }
	 catch (e)
	 {
	  // Internet Explorer
		  try
		  {
			   // Internet Explorer 6.0+
			   xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		  }
		  catch (e)
		  {
			   // Internet Explorer 5.5+
			   xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
	 }
	 return xmlHttp;
}

xmlHttp = GetXmlHttpObject();

function makePOSTRequest(url, parameters)
{
	http_request = xmlHttp;
	  
  http_request.open('POST', url, true);
	http_request.onreadystatechange = alertContents;
  http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  http_request.setRequestHeader("Content-length", parameters.length);
  http_request.setRequestHeader("Connection", "close");
  http_request.send(parameters);  
}

function alertContents() 
{
	var result ="";
	if (http_request.readyState == 4) 
    {
    	if (http_request.status == 200) 
        {
        	result = http_request.responseText;
        }
        else 
        {
        	alert('There was a problem with the request.');
        }
	}
}

function addSessionList(str)
{
	//alert("vcvc==="+str);
	var mx=str.split("#");
	for(var i=0;i<mx.length-1;i++)
	{
		//alert("mx["+i+"]=="+mx[i]);
		cx=mx[i].split("||");
		//alert(cx[0]+"||"+cx[1]+"||"+cx[2]+"||"+cx[3]+"||"+ cx[4]+"||"+cx[5]+"||"+cx[6]+"||"+cx[7]+"||"+cx[8]+"||"+ cx[9]);
		var teama = getObject("teama_"+cx[9]);
		var teamb = getObject("teamb_"+cx[9]);
		var teamc = getObject("teamc_"+cx[9]);
		var chk1=  getObject("chk1_"+cx[9]);
		var chk2 = getObject("chk2_"+cx[9]);
		var chk3 = getObject("chk3_"+cx[9]);
		//alert(teama);
		if(cx[1]==1 && teama!=false)
		{
			teama.style.backgroundColor = "#000000"	
			//teama.style.backgroundColor = ""		
			teama.style.color = "#FFFFFF"
			//teama.style.color = ""
			chk1.checked = true;
		}
		if(cx[1]==2 && teamb!=false)
		{
			teamb.style.backgroundColor = "#000000"	
			//teama.style.backgroundColor = ""		
			teamb.style.color = "#FFFFFF"
			//teama.style.color = ""
			chk2.checked = true;
		}
		if(cx[1]==3 && teamc!=false)
		{
			teamc.style.backgroundColor = "#000000"	
			//teama.style.backgroundColor = ""		
			teamc.style.color = "#FFFFFF"
			chk3.checked=true;
			//teama.style.color = ""
		}
		var item = new Item(cx[0],  cx[2], cx[3],cx[1], cx[7],cx[4], cx[5], cx[6],  cx[8], cx[9]);
		bet.addItem(item);
		betcon=betcon.add_element(cx[0]+"|"+cx[1]+"&"+cx[2]+"  VS "+cx[3]);
		calc();
	}
}
/**  * string String::cut(int len)  * 字符串截取:한글도 고려하여 길이 리턴  */   
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

