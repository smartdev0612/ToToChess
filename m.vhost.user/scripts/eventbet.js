var itemstr = '<style="margin-left: 10px"><table border="0" cellpadding="0" cellspacing="0" width="100%">\n';
itemstr += '  <tr>\n';
itemstr += '    <td><font color="#feac6f"><b>홈</b> $team1</font></td>\n';
itemstr += '    <td align="right">$betteam <a href="javascript:del_bet($betid)"><img src="../images/btn_x.gif" border="0"></a></td>\n';
itemstr += '  </tr>\n';
itemstr += '  <tr>\n';
itemstr += '    <td><b>원</b> $team2</td>\n';
itemstr += '    <td align="right">$ratio</td>\n';
itemstr += '  </tr>\n';
itemstr += '  <tr><td colspan="2" background="../images/line.gif" height="3"></td></tr>\n';
itemstr += '</table>\n';


Array.prototype.remove = function(from, to) {
	var rest = this.slice((to || from)+1 || this.length);
	this.length = from<0 ? this.length+from : from;
	return this.push.apply(this, rest);
}
function changeBox(cbox) {
    box = eval(cbox);
    if(box==undefined){
        //alert("경기가 마감되엇습니다");
    }else{
        box.checked = !box.checked;
	    add_bet(box);
    }
}
//-->

function check_bet(e) {  
	if (window.event) {
		e = window.event;
	}
	var src = getSrcElement(e);
	add_bet(src);
}
function add_bet(src) {
	
	var num = src.getAttribute("num");
	var lnum = src.getAttribute("lnum");
	var chk1 = getObject("chk1_"+num);
	var chk2 = getObject("chk2_"+num);
	var chk3 = getObject("chk3_"+num);
	// 清除已选游戏开始
		var aler_buy=bet.getList();
		if(aler_buy!="")
		{
			var aler_buy_arr=aler_buy.split("#");
			for(var i=0;i<aler_buy_arr.length-1;i++)
			{
				var aler_xxx=aler_buy_arr[i].split("||");
				var obj_num=aler_xxx[0];
				if(obj_num!=num)
				{
					del_bet(obj_num);
				}
			}
		}
		//清除已选游戏结束
	//displaymess(false); //默认不需要显示		
/* ---------------------------------------- */
	//alert("num"=num);
	var teama = getObject("teama_"+num);
	var teamb = getObject("teamb_"+num);
	var teamc = getObject("teamc_"+num);
/*	var trbg = getObject("tr_"+num);*/

 //alert("1111111");

/* ------------팀 선택 했을때 백그라운드색깔 폰트색깔 S---------------------------- */
	if (chk1 && src != chk1) {
		/*원*/
		teamb.style.backgroundColor = "FFCC00"	
		teama.style.backgroundColor = ""		
	    teamb.style.color = "#000000"
	    teama.style.color = ""
		chk1.checked = false;
	}

	if (chk2 && src != chk2) {
		/*홈*/
		teama.style.backgroundColor = "FFCC00" 
		teamb.style.backgroundColor = ""	
	    teama.style.color = "#000000"
	    teamb.style.color = ""
		chk2.checked = false;
	}
	if (chk3 != false){
		if (chk3 && src != chk3) {
	}
		else {
		teamc.style.backgroundColor = "FFCC00"
	    teamc.style.color = "#000000"
		}
	}
/* ------------팀 선택 했을때 백그라운드색깔 폰트색깔 E---------------------------- */
	if (chk3 && src != chk3) {
		chk3.checked = false;
	}

	if (chk1.checked == false)	{
		teama.style.backgroundColor = ""
		teama.style.color = ""
	}
	if (chk2.checked == false)	{
		teamb.style.backgroundColor = ""
		teamb.style.color = ""
	}
	if (chk3.checked == false)	{
		teamc.style.backgroundColor = ""
		teamc.style.color = ""
	}
	//alert("22222222");

	var team1 = getObject("team1_"+num).innerHTML;
	var team2 = getObject("team2_"+num).innerHTML;
	var ratio = getObject("bet"+src.value+"_"+num).innerHTML;
	var bet1 = getObject("bet1_"+num);

	if (bet1) {
		bet1 = bet1.innerHTML;
	}
	var bet2 = getObject("bet2_"+num);
	if (bet2) {
		bet2 = bet2.innerHTML;
	}
	var bet3 = getObject("bet3_"+num);
	if (bet3) {
		bet3 = bet3.innerHTML;
	} else {
		bet3 = "0";
	}
	var obj = getObject("num_"+num);
	var gametype = obj.getAttribute("gametype");
	if (!gametype) {
		alert('gametype:n');
	}
	//alert("3333333");
	if (src.checked) {
		
	
		//bet.ClearAll();
		//calc();
		var item = new Item(num, team1, team2, src.value, ratio, bet1, bet2, bet3, gametype, lnum);
		bet.addItem(item);
		var isdisabled = true;

	} else {
		bet.removeItem(num);
		var isdisabled = false;
	}


	//alert("44444444");
	if (gametype == '1' || gametype == '2') {
		var arr = document.getElementsByTagName("input");
		if (arr.length) {
			for (i=0; i<arr.length; i++) {
				if (arr[i].getAttribute("type") == 'checkbox') {
					var arrLnum = arr[i].getAttribute("lnum");
					var arrNum = arr[i].getAttribute("num");
					var arrBet = arr[i].getAttribute("bet");
					var arrGt = arr[i].getAttribute("gt");
					if (arrGt == '1' || arrGt == '2')
					{
						if (arrLnum == lnum && arrNum != num && arrGt != gametype) {
							if (arrBet != '0')
							{
								arr[i].disabled = isdisabled;
							}
							else {
								arr[i].disabled = true;
							}
						}
					}
				}
			}
		}
	}
	//alert("xxxxxx");
		var nCNT = tb_list.rows.length;
		if (nCNT > 10){
			alert("최대 10경기까지 선택하실수 있습니다   " );
			return false;
		}else{
			calc();
		}
	//alert("5555555");
		
}
function del_bet(num) {
	for (var i = 1; i<=3; i++) {
		var chk = getObject("chk"+i+"_"+num);
		chk.checked = false;
	}
	//-------lbg for cancel bet color
	var teama = getObject("teama_"+num);
	var teamb = getObject("teamb_"+num);
	var teamc = getObject("teamc_"+num);
	//alert("teamc==="+teamc);
	teama.style.backgroundColor = "";
	teama.style.color = "";
	teamb.style.backgroundColor = "";
	teamb.style.color = "";
	if(teamc==true)
	{
		teamc.style.backgroundColor = "";
		teamc.style.color = "";
	}
	//--------lbg for cancel bet color
	bet.removeItem(num);
	var obj = getObject("num_"+num);
	var lnum = obj.getAttribute("lnum");

	var arr = document.getElementsByTagName("input");
	if (arr.length) {
		for (i=0; i<arr.length; i++) {
			if (arr[i].getAttribute("type") == 'checkbox') {
				var arrLnum = arr[i].getAttribute("lnum");
				var arrNum = arr[i].getAttribute("num");
				var arrBet = arr[i].getAttribute("bet");
				if (arrLnum == lnum && arrNum != num) {
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
	}
	calc();
}
var bet = new BetList();
function Item(betid, team1, team2, betteam, ratio, bet1, bet2, bet3, gametype, lnum) {
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
function BetList() {
	this._items = new Array();
}
BetList.prototype._totalprice;
BetList.prototype._point;
BetList.prototype._bet;
BetList.prototype._items;
BetList.prototype.addItem = function(item) {
	this.removeItem(item._betid);
	this._items.push(item);
	add_bet_list(item);
}
BetList.prototype.removeItem = function(num) {
	var pos = -1;
	for (var i = 0; i<this._items.length; i++) {
		if (this._items[i]._betid == num) {
			pos = i;
			break;
		}
	}
	if (pos>=0) {
		del_bet_list(num);
		this._items.remove(pos, pos);
	}
}
BetList.prototype.getList = function() {
	var re = "";
	for (var i = 0; i<this._items.length; i++) {
		re += this._items[i]._betid
		re += "||"+this._items[i]._betteam
		re += "||"+this._items[i]._team1
		re += "||"+this._items[i]._team2
		re += "||"+this._items[i]._bet1
		re += "||"+this._items[i]._bet2
		re += "||"+this._items[i]._bet3
		re += "||"+this._items[i]._ratio
		re += "||"+this._items[i]._gametype
		re += "||"+this._items[i]._lnum+"#\n";
	}
	return re;
}
BetList.prototype.setPoint = function(point) {
	this._point = point;
}
BetList.prototype.exec = function() {
	this._bet = 0;
	for (var i = 0; i<this._items.length; i++) {
		if (i == 0) {
			this._bet = 1;
		}
		this._bet = this._bet*(this._items[i]._ratio*100);
		this._bet = this._bet/100;
	}
	//this._bet = Floor(this._bet, 2);//直接截取小数点后两位，改成l四舍五入
	//this._totalprice = Math.floor(this._point*this._bet);

	//alert("beforebet==="+this._bet);
	this._bet = (Math.round(this._bet * 100))/100;
	//alert("afterbet="+this._bet);
	//alert("beforetotalprice==="+this._totalprice);
	this._totalprice = Math.floor((Math.round((this._point) * (this._bet)*100))/100);
	//alert("totalprice="+this._totalprice);

	
}
BetList.prototype.ClearAll = function() {
	this._items = new Array();
	var tb = getObject("tb_list");
	while (tb.rows.length>0) {
		tb.deleteRow(0);
	}
	var arr = document.getElementsByTagName("input");
	if (arr.length) {
		for (i=0; i<arr.length; i++) {
			//alert(i);
			if (arr[i].checked) {
				arr[i].checked = false;
				//-------lbg for cancel bet color
				var arrNum = arr[i].getAttribute("num");
				if(arrNum !=null)
				{
				//alert("arrnum="+arrNum);
				var teama = getObject("teama_"+arrNum);
				var teamb = getObject("teamb_"+arrNum);
				var teamc = getObject("teamc_"+arrNum);
				teama.style.backgroundColor = "";
				teama.style.color = "";
				teamb.style.backgroundColor = "";
				teamb.style.color = "";
				if(teamc != false)
				{
					teamc.style.backgroundColor = "";
					teamc.style.color = "";
				}
			
			}
			//--------lbg for cancel bet color
			}
			if (arr[i].disabled) {
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
function add_bet_list(item) {
	var str = bet.getList();
	var tb = getObject("tb_list");
	var tr = tb.insertRow(tb.rowIndex);
	tr.id = "tb_row_"+item._betid;
	var td = tr.insertCell(0);
	td.innerHTML = get_item_html(item);
}
function del_bet_list(num) {
	var tb = getObject("tb_list");
	var row = getObject("tb_row_"+num);
	tb.deleteRow(row.rowIndex);
}
function get_item_html(item) {
	var re = itemstr;
	var gametype = item._gametype;
	var betteam_str = "";
	if (gametype == '2')
	{
		str1 = '승';
		str2 = '패';
	}
	else if (gametype == '3')
	{
		str1 = '홀';
		str2 = '짝';
	}
	else {
		str1 = '승';
		str2 = '패';
	}
	
	/*카트 승무패 색깔 S */
	if (item._betteam == "1") {
		betteam_str = "<font color='red'>"+str1+"</font>"; 
	} else if (item._betteam == "2") {
		betteam_str = "<font color='green'>"+str2+"</font>";
	} else if (item._betteam == "3") {
		betteam_str = "<font color='yellow'>무</font>";
	}
		/*카트 승무패 색깔 E */
	re = re.replace("$betid", item._betid);
	re = re.replace("$team1", item._team1.str_cut(10));
	re = re.replace("$team2", item._team2.str_cut(10));
	re = re.replace("$betteam", betteam_str);
	re = re.replace("$ratio", item._ratio);
	return re;
}
function calc() {
	var point = getObject("betprice").innerHTML;
	point = point.replace(/,/gi,"");
	point = parseInt(point);
	bet.setPoint(point);
	bet.exec();
	var betstr = bet._bet;
	if (betstr.toFixed) {
		betstr = betstr.toFixed(2);
	}
	
	getObject("sp_bet").innerHTML = betstr;
	//alert("调用后"+MoneyFormat(bet._totalprice));
	getObject("sp_total").innerHTML =MoneyFormat(bet._totalprice);
	//alert("aaaaa");
	betForm.result_rate.value = betstr;

}
function betting(type) {
	var min_bet = 0;
	var max_bet = 0;
	var max_amount = 0;
	min_bet = parseInt(eval("VarMinBet"));
	max_bet = parseInt(eval("VarMaxBet"));
	max_amount = parseInt(eval("VarMaxAmount"));
	//alert("123")
	//1,000원 단위로 배팅가능체크---
	var iLen = String(bet._point).length;
	rlen_money = (String(bet._point).substring(iLen,iLen - 3))
	rlen_money = String(rlen_money);
	//alert (rlen_money)
	//if (rlen_money != "000") {
	//	alert ("1,000원 단위로 배팅이 가능합니다.")
	//	return;
	//}
	//---
	var sp_bet=bet._bet;
	if(isNaN(sp_bet))
	{
		playSound('../voice/tiyong.wav');//调用声音
		alert("배팅할 경기를 선택하십시오.");
		return;
	}
	//alert(bet.)
	/*
	if (bet._point<min_bet || bet._point>max_bet) {
		alert("베팅액은 "+MoneyFormat(min_bet)+"~"+MoneyFormat(max_bet)+"원 사이입니다.");
		return;
	}
	if (bet._totalprice>max_amount) {
		alert("최대적중금은 "+MoneyFormat(max_amount)+"를 넘을 수 없습니다.");
		return;
	}
	*/
	if (bet._totalprice == 0 || bet._items.length == 0) {
		playSound('../voice/tiyong.wav');//调用声音
		alert("베팅할 경기를 선택하십시오.");
		return;
	}
	if (bet._items.length < 1) {
		playSound('../voice/tiyong.wav');//调用声音
		alert("최소 1경기 이상 선택하실수 있습니다.");
		return;
	}
	if (bet._items.length > 10) {
		playSound('../voice/tiyong.wav');//调用声音
		alert("최대 10경기까지 선택하실수 있습니다.");
		return;
	}
	/*
	if (bet._point>VarMoney) {
		playSound('../voice/tiyong.wav');//调用声音
		alert("베팅금액이 현재금보다 클 수 없습니다.");
		return;
	}
	*/
	if (type == "cart") {
		betForm.mode.value = type;
	}
	else {
		playSound('../voice/tadan.wav');//调用声音
		betForm.mode.value = "betting";
		if (!confirm("배팅완료 "+bettingcanceltime+"분이내, 경기시작 "+bettingcancelbeforetime+"분전에만 취소가능합니다.\n확인클릭후 베팅 완료됩니다")) {
			return;
		}
	}
	betForm.betmoney.value = bet._point;
	betForm.betcontent.value = bet.getList();
	betForm.submit();
}

function add_cart(type) {
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
	//alert (rlen_money)
	//if (rlen_money != "000") {
	//	alert ("1,000원 단위로 배팅이 가능합니다.")
	//	return;
	//}
	//---

	if (bet._point<min_bet || bet._point>max_bet) {
		alert("베팅액은 "+MoneyFormat(min_bet)+"~"+MoneyFormat(max_bet)+"원 사이입니다.");
		return;
	}
	if (bet._totalprice>max_amount) {
		alert("최대적중금은 "+MoneyFormat(max_amount)+"를 넘을 수 없습니다.");
		return;
	}
	if (bet._totalprice == 0 || bet._items.length == 0) {
		alert("베팅할 경기를 선택하십시오.");
		return;
	}
	if (bet._items.length < 1) {
		alert("최소 1경기 이상 선택하실수 있습니다.");
		return;
	}
	if (bet._items.length > 10) {
		alert("최대 10경기까지 선택하실수 있습니다.");
		return;
	}

	if (bet._point>VarMoney) {
		alert("베팅금액이 현재금보다 클 수 없습니다.");
		return;
	}
	if (type == "cart") {
		betForm.mode.value = type;
	}
	else {
		betForm.mode.value = "betting";
		if (!confirm("배팅완료 "+bettingcanceltime+"분이내, 경기시작 "+bettingcancelbeforetime+"분전에만 취소가능합니다.\n확인클릭후 베팅 완료됩니다")) {
			return;
		}
	}
	betForm.betmoney.value = bet._point;
	betForm.betcontent.value = bet.getList();
	betForm.action="add_cart.php";
	betForm.submit();
}

function init() {
	return;
}
function del_all() {
	bet.ClearAll();
	calc();
}
/*控制说明信息的显示与不显示*/
function displaymess(falg)
{
	var notice=getObject("notice");
	if(falg)
	{
		notice.style.display="";
	}else
	{
		notice.style.display="none";
	}
}
//用户选钱变化
function sel_money(src)
{
	 getObject("betprice").innerHTML=MoneyFormat(src);
	 calc();
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
  //调用声单文件开始
function playSound(src)
{ 
	var _s = document.getElementById('snd'); 
	if(src!='' && typeof src!=undefined)
	{ 
		_s.src = src; 
	} 
} 
//调用声单文件结束