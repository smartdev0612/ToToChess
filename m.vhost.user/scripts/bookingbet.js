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

var betcon= new Array();
Array.prototype.remove = function(from, to) {
	var rest = this.slice((to || from)+1 || this.length);
	this.length = from<0 ? this.length+from : from;
	return this.push.apply(this, rest);
}
/*  自定义删除一个数组里的元素开始   */
Array.prototype.indexOf = function(v)
{
	 if(v==null)
	 {
		return -1;
	 }else
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
		  //最后一个元素
		  if(v_index==this.length-1)
		  {
				return this.slice(0,v_index);
		  }else if(v_index==0)//第一个元素
		  {
				return this.slice(v_index+1,this.length);
		  }
		  else
		  {
				 //slice方法不包括end元素
				return this.slice(0,v_index).concat(this.slice(v_index+1,this.length));
		  }
	 }else
	 {
	  return this;
	 }
}
//向数组里填加一个类似 “比赛号|选择”的元素，先要检查比赛号是否存在，如果存在，先删除在填加 
Array.prototype.add_element=function(v)
{
	var betcon2=this;
	var arrsrc=v.split("|"); //arrobj[0] ==>比赛号，arrobj[1]===>选择
	for(var i=0;i<this.length;i++)
	{
		var arrobj=this[i].split("|");
		if(arrsrc[0]==arrobj[0])
		{
			//如有此比赛有押注，取消并跳出循环
			betcon2 = betcon2.del_element(this[i]);
			break;
		}
	}
	betcon2.push(v);
	return betcon2;
}
/*  自定义删除一个数组里的元素结束*/
//根据比赛号删除数组里的一个元素 开始
Array.prototype.del_one=function(m)
{
	var betcon2=this;
	var arrsrc=m; //arrobj[0] ==>比赛号，arrobj[1]===>选择
	for(var i=0;i<this.length;i++)
	{
		var arrobj=this[i].split("|");
		if(arrsrc==arrobj[0])
		{
			//如有此比赛有押注，取消并跳出循环
			betcon2 = betcon2.del_element(this[i]);
			break;
		}
	}
	return betcon2;
}
//根据比赛号删除数组里的一个元素 结束
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
	displaymess(false); //默认不需要显示
	var num = src.getAttribute("num");
	var lnum = src.getAttribute("lnum");
	var chk1 = getObject("chk1_"+num);
	// 多于10注不让押开始
	var aler_buy=bet.getList();
	if(aler_buy!="")
	{
		var flag=false;
		var aler_buy_arr=aler_buy.split("#");
		var aler_xxx="";
		var obj_num="";
		
		if(aler_buy_arr.length>=11)
		{
			
			for(var i=0;i<aler_buy_arr.length-1;i++)
			{
				aler_xxx=aler_buy_arr[i].split("||");
				obj_num=aler_xxx[0];
				//alert(aler_xxx);
				//alert("本次选择的为="+parseInt(num)+"以选过的="+parseInt(obj_num));
				if(parseInt(obj_num)==parseInt(num)) //已经选过了，可能重新选
				{
					//alert("是选过的");
					flag=true;
					break;
				}
			}
			if(!flag)
			{
				playSound('../voice/tiyong.wav');//调用声音
				alert("최대 10경기까지 선택하실수 있습니다");
				return false;
			}
			
		}
	}
	//多于10注不让结束*/
	var chk2 = getObject("chk2_"+num);
	var chk3 = getObject("chk3_"+num);

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
		teamb.style.backgroundColor = "030303"	
		teama.style.backgroundColor = ""		
	    teamb.style.color = "#000000"
	    teama.style.color = ""
		chk1.checked = false;
	}

	if (chk2 && src != chk2) {
		/*홈*/
		teama.style.backgroundColor = "030303" 
		teamb.style.backgroundColor = ""	
	    teama.style.color = "#000000"
	    teamb.style.color = ""
		chk2.checked = false;
	}
	if (chk3 != false){
		if (chk3 && src != chk3) {
	}
		else {
		teamc.style.backgroundColor = "030303"
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
		var item = new Item(num, team1, team2, src.value, ratio, bet1, bet2, bet3, gametype, lnum);
		//alert("押注号=="+num+"选择队伍"+src.value);
		bet.addItem(item);
		playSound('../voice/hiek.wav');//调用声音
		betcon=betcon.add_element(num+"|"+src.value+"&"+team1+"  VS "+team2);//向数组里增加一个字符串
		var isdisabled = true;

	} else {
		playSound('../voice/hiek.wav');//调用声音
		bet.removeItem(num);
		//将默认信息显示出来开始
		if (bet._items.length < 1) 
		{
			displaymess(true);
		}
		//将默认信息显示出来结束
		betcon=betcon.del_element(num+"|"+src.value+"&"+team1+"  VS "+team2);
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
	playSound('../voice/hiek.wav');//调用声音
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
	teamc.style.backgroundColor = "";
	teamc.style.color = "";
	
	//--------lbg for cancel bet color
	bet.removeItem(num);
	betcon=betcon.del_one(num);
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
	//将默认信息显示出来开始
	if (bet._items.length < 1) 
	{
		displaymess(true);
	}
	//将默认信息显示出来结束
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
				if(teamc !=false)
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
	if (gametype == '4')
	{
		str1 = '언더';
		str2 = '오버';
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
	var point = getObject("betprice").value;
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
	//betmsg=eval("betmsg");
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
	if (bet._point<min_bet || bet._point>max_bet) {
		playSound('../voice/tiyong.wav');//调用声音
		alert("베팅액은 "+MoneyFormat(min_bet)+"~"+MoneyFormat(max_bet)+"원 사이입니다.");
		return;
	}
	if (bet._totalprice>max_amount) {
		playSound('../voice/tiyong.wav');//调用声音
		alert("최대적중금은 "+MoneyFormat(max_amount)+"를 넘을 수 없습니다.");
		return;
	}
	if (bet._items.length == 0) {
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

	if (bet._point>VarMoney) {
		playSound('../voice/tiyong.wav');//调用声音
		alert("베팅금액이 현재금보다 클 수 없습니다.");
		return;
	}
	/*检查比赛重复开始*/
	if(check_repeat(betmsg,betcon))
	{
		return;
	}
	/*检查比赛重复结束*/
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
	//print_arr(betcon);
	
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
	playSound('../voice/hiek.wav');//调用声音
	displaymess(true);
	bet.ClearAll();
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

/*检查比赛重复开始*/
function check_repeat()
{
	if(betmsg=="")
	{
		return false;
	}
	var betarr=betmsg.split(",");//用户已经购买的押注信息 ///betcon本身是一个数组
	var repeatbet="";
	var xxx=0;
	var falg=false;
	myout:for(var x=0;x<betcon.length;x++)//用户本次购买
	{
		var repeatcount=0;
		betconcrete=betcon[x].split("&");
		var betthis=betconcrete[0].split("|"); //用户本次购买分开，betthis[0]比赛号，betthis[1],所押比率
		var comstr=betthis[1];
		//alert(betarr);
		for(var i=0;i<betarr.length;i++)//betarr   已购买
		{
			var betone =betarr[i].split("$");//betone[0]==>比赛号，betone[1]==>比赛押注情况，betone[2]==>比赛个数
			var betrace=betone[1].split("#");//分割出来每一注的所有比赛和比率

			for(var m=0;m<betrace.length;m++)
			{
				var objcomstr=betrace[m].split("|");//将一场比赛的比赛号与押注分开
				if(betthis[0]==objcomstr[0])
				{
					comstr=comstr+","+objcomstr[1];
					//alert(comstr);
					if(combetrace(comstr))
					{
						repeatbet=betconcrete[1];
						playSound('../voice/tiyong.wav');//调用声音
						alert(repeatbet+"\n[승]  [무] [패] 를 모두 배팅할수 없습니다.");//胜负败全押了
						falg=true;
						//break myout;
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
						playSound('../voice/tiyong.wav');//调用声音
						alert(repeatbet+" 3번이상 배팅할수 없습니다.");  //押注达到3次
						falg=true;
						//break myout;
						return falg;
					}
				}
			}
		}
	}
		//妈B，拼了 1-4,一个重复，5-6两个重复，7个以上，三个重复
		
	orout:for(var i=0;i<betarr.length;i++)//取出已经购买每一个押注的比赛
	{
		//先算出最多押注数
		var betone=betarr[i].split("$");
		var betrace=betone[1].split("#")
		if(betcon.length==1 && betone[2]==1)
		{
			var betxxx=betcon[0].split("&");
			if(betxxx[0]==betone[1])
			{
				playSound('../voice/tiyong.wav');//调用声音
				alert("한개 경기를 중복으로 배팅할수 없습니다.\n"+reprecord);//单注押注重复
				falg=true;
				return falg;
			}
		}
		var betnum=getLimitBet(betcon.length,betone[2]);
		var reprecord="";
		//var betsum=0;//本次押注数
		//alert("betnum"+betnum);
		var repeatcount=0;
		//本次押注与每一注进行比较
		for(var j=0;j<betrace.length;j++)
		{
			for(var x=0;x<betcon.length;x++)
			{
				betconox=betcon[x].split("&");
				if(betrace[j]==betconox[0])
				{
					repeatcount++;
					reprecord=reprecord+betconox[1]+"\n";
					//alert(reprecord);
					//alert("betnum"+betnum);

					if(repeatcount>betnum)
					{
						playSound('../voice/tiyong.wav');//调用声音
						alert("중복 배팅입니다. 확인하여 주십시오.\n"+reprecord);//重复押注
						//alert(betone[0]);
						falg=true;
						//break orout;
						return falg;
					}
				}
			}
		}
	}

	return falg;
	
}
/*检查比赛重复结束*/
/*得到级限压注数开始*/
function getLimitBet(srcbet,objbet)
{
	var c=srcbet>objbet?objbet:srcbet;
	var betrenum;
	if(c>=1 && c<=4)
	{
		betrenum=1;
	}else if(c>=5 && c<=6)
	{
		betrenum=2;
	}else if(c>=7)
	{
		betrenum=3;
	}
	return betrenum;
}
/*得到级限压注数结束*/
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
//传过来一个字符串,检查，1，2，3是否都在字符串当中 
function combetrace(src)
{
		//alert("传过来的参数是"+src)
		var falg=true;
		if(src.indexOf("1")<0 || src.indexOf("2")<0 ||src.indexOf("3")<0)
		{
			falg=false;
		}
		return falg;
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