var itemstr = '<style="margin-left: 10px"><table border="0" cellpadding="0" cellspacing="0" width="100%">\n';
itemstr += '  <tr>\n';
itemstr += '    <td><td width="55" align="left">배팅번호:</td>';
itemstr += '    <td width="110" align="left"><font color="#FF9900">game_no</font> </td>';
itemstr += '    <td width="15" align="right"><a href="javascript:del_bet(game_no)"><img src="../images/btn_x.gif"></href></td>\n';
itemstr += '  </tr>\n';
itemstr += '  <tr><td colspan="3" background="../images/line.gif" height="3"></td></tr>\n';
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
	displaymess(false); //默认不需要显示
	var num = src.getAttribute("game_no");
	if (src.checked) {
		var item = new Item(num, '', '', '', '', '', '', '', '', '');
		bet.addItem(item);
		var isdisabled = true;
	} else {
		bet.removeItem(num);
		//将默认信息显示出来开始
		if (bet._items.length < 1) 
		{
			displaymess(true);
		}
		//将默认信息显示出来结束
		var isdisabled = false;
	}


	
		
}
function del_bet(num) {		
	bet.removeItem(num);
	getObject(num).checked="";
	if (bet._items.length < 1) 
	{
		displaymess(true);
	}
	//calc();

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
		re += "||"+this._items[i]._lnum+"#";
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
	this._bet = Floor(this._bet, 2);
	this._totalprice = Math.floor(this._point*this._bet);
}
BetList.prototype.ClearAll = function() {
	this._items = new Array();
	var tb = getObject("tb_list");
	while (tb.rows.length>0) {
		tb.deleteRow(0);
	}
	var arr = document.getElementsByTagName("input");
	this.exec();
}
function add_bet_list(item) {
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
	re = re.replace(/game_no/g, item._betid);
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
	getObject("sp_total").innerHTML =MoneyFormat(bet._totalprice);
	betForm.result_rate.value = betstr;
	betlist=bet.getList();

}
function betting(type) {
	if(bet.getList()=="")
	{
		alert("등록하실 폴더를 체크 해 주십시오");
		return ;
	}
	tobbsForm.betcontent.value = bet.getList();
	tobbsForm.action="racetobbs.php";
	tobbsForm.submit();
	
}



function init() {
	return;
}

function print_arr(arr)
{
	for(var i=0;i<arr.length;i++)
	{
		alert(arr[i]);
	}
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


