function EventbetCheck(frm,i) {
	frm.betting.value = i.value;
}
function AlertEvent(str) {
	warning_popup(str);
	return false;
}
function EventbetSubmit(frm,minbet,maxbet) {
	if (frm.betting.value == '') {
		warning_popup('베팅항목을 선택하십시오');
		return false;
	}
	var strprice = frm.eventprice.value;
	strprice = strprice.replace(/,/gi, '');
	intprice = parseInt(strprice);
	if(intprice < minbet || intprice > maxbet) {
		warning_popup("베팅액은 "+minbet+"~"+maxbet+"원 사이입니다.");
		return false;
	}

	if(intprice > 0)
	{
		warning_popup("베팅금액이 보유머니보다 클 수 없습니다.");
		return false;
	}

	var pricecheck = parseInt(intprice / 10000);
	pricecheck = pricecheck * 10000;

	if (pricecheck != parseInt(intprice))
	{
		warning_popup("금액은 만원단위로 입력하십시오.");
		return false;
	}
	return false;
}


var itemstr = '';
/*
itemstr += '<table border="0" cellpadding="0" cellspacing="0" width="233"  style="table-layout:fixed;">\n';
itemstr += '  <tr>\n';
itemstr += '    <td style="font-size:11px;letter-spacing:-1; color;#fff000" width="165">$team1</td>\n';
itemstr += '    <td align="right" style="font-size:11px;color:#ffffff">[$betteam] $ratio  <a href="javascript:del_bet($wr_id)"><img src="/10bet/images/x.gif" align="absmiddle"></a></td>\n';
itemstr += '  </tr>\n';
itemstr += '  <tr><td colspan="2" height="2" style="background-image:url(/images/cat_sl.gif); background-position:bottom; background-repeat:repeat-x"></td></tr>\n';
itemstr += '</table>\n';
*/

/*
itemstr += '<table border="0" cellpadding="0" cellspacing="0" width="100%"  style="table-layout:fixed;border: 1px solid #555;padding:5px;" align="center">\n';
itemstr += '   <tr>\n';
itemstr += '      <td style="padding-left:3px;">\n';
itemstr += '         <table width="100%" border="0" cellspacing="0" cellpadding="0">\n';
itemstr += '            <tr>\n';
itemstr += '               <td style="color:#2afd56"><strong>$team1</strong></td>\n';
itemstr += '            </tr>\n';
itemstr += '            <tr>\n';
itemstr += '               <td style="color:#2afd56">[$betteam]</td>\n';
itemstr += '            </tr>\n';
itemstr += '         </table>\n';
itemstr += '      </td>\n';
itemstr += '      <td width="40" align="right" style="padding-right:3px;">\n';
itemstr += '         <table width="100%" border="0" cellspacing="0" cellpadding="0">\n';
itemstr += '            <tr>\n';
itemstr += '               <td align="right" style="font-size:13px; color:#2afd56"><b>$ratio</b></td>\n';
itemstr += '            </tr>\n';
itemstr += '            <tr>\n';
itemstr += '               <td align="right"><a href="javascript:del_bet($wr_id)"><img src="/10bet/images/x.png?z" border="0"></a></td>\n';
itemstr += '            </tr>\n';
itemstr += '         </table>\n';
itemstr += '      </td>\n';
itemstr += '   </tr>\n';
itemstr += '   <tr>\n';
itemstr += '      <td colspan="2" height="1"></td>\n';
itemstr += '   </tr>\n';
itemstr += '</table>\n';
*/
itemstr += '<li>\n';
itemstr += '<h4>$betteam<span class="del"><img src="/10bet/images/10bet/ico_del_01.png" alt="삭제" onClick="del_bet($wr_id);"></span></h4>\n';
itemstr += '<div class="result">$team1 <span>$ratio</span></div>\n';
itemstr += '</li>\n';


Array.prototype.remove = function(from, to) {
	var rest = this.slice((to || from)+1 || this.length);
	this.length = from<0 ? this.length+from : from;
	return this.push.apply(this, rest);
}
var returntext = "";
function check_bet(obj, id) {
	// obj = tmpObj[VarBoTable][obj]; 
	// var num = obj.wr_id;	 // 경기번호
	// var gametime = obj.wr_6;

	// // 멈춤기능
	// if( obj.wr_reply=="1" ) {
	// 	warning_popup("대기상태여서 배팅하실수 없습니다");
	// 	return;
	// }

	// a_infos = gametime.split(" ");
	// a_date = a_infos[0].split("-");
	// a_time = a_infos[1].split(":");

	// var gamedatetime = new Date(a_date[0],a_date[1]-1,a_date[2],a_time[0],a_time[1],a_time[2]);
	// if( clock.time > gamedatetime && !g4_is_admin ) warning_popup("배팅가능한 시간이 지났습니다!");
	// else{
	// 	add_bet(obj, id);
	// }
	add_bet(obj, id);
}

//==============================================
// 전체 규칙
//==============================================
function is_duplicated(src,id){
	// 승무패, 핸디캡인경우만 중복여부체크
	if( src.bo_table!='a10' ) return false;

	var err_msg = {
		'win_handy':	'승무패,핸디캡 조합불가합니다',
		'win_over':	'승무패,오버언더 조합불가합니다',
		'win_mu_over':	'무,오버언더 조합불가합니다',
		'inning1':		'1이닝 득점/무득점 과 오버언더는 조합불가합니다',
		'bonus':		'보너스폴더끼리 조합불가합니다'
	};

	for(i=0; i<bet._items.length; i++){

		// 첫홈런은 모두묶인다.
		if( src.wr_4.indexOf("첫홈런")!=-1 || bet._items[i].team1.indexOf("첫홈런")!=-1  ) continue;

		// 보너스폴더끼리 묶을수 없다.
		if( src.wr_4.indexOf("폴더")!=-1 && bet._items[i].team1.indexOf("폴더")!=-1 ) return err_msg['bonus'];

		// 같은게임일때
		if(bet._items[i].group_id == src.group_id && bet._items[i].wr_id!=src.wr_id ) {
			var a = src.wr_7;
			var a1 = id;
			var b = bet._items[i].gametype;
			var b1 = bet._items[i].betteam;

			// 1이닝 득/무득 + 오버언더 조합안됨
			if( ( bet._items[i].team1.indexOf("1이닝")!=-1 && bet._items[i].team1.indexOf("득점")!=-1 ) ||
			    ( src.wr_4.indexOf("1이닝")!=-1 && src.wr_4.indexOf("득점")!=-1 ) )
			{
				if(a=="승무패" && b=="오버언더") return err_msg['inning1'];
				if(b=="승무패" && a=="오버언더") return err_msg['inning1'];
			}

			// 승무패-핸디캡 중복X
			if(a=="승무패" && b=="핸디캡") return err_msg['win_handy']; 
			if(b=="승무패" && a=="핸디캡") return err_msg['win_handy'];
			// 승무패(무배팅)-언오버 중복X
			//if(a=="승무패" && b=="오버언더") return err_msg['win_over'];
			//if(b=="승무패" && a=="오버언더") return err_msg['win_over'];
            // 승무패(무배팅)-언오버 중복X 
            if(a=="승무패" && a1==3 && b=="오버언더") return err_msg['win_mu_over'];
            if(b=="승무패" && b1==3 && a=="오버언더") return err_msg['win_mu_over'];
		}
	}

	return;
}

//==============================================
// 사다리 규칙
//==============================================
function is_duplicated_ladder(src,id){
	if( src.bo_table!='a40' ) return false;

	var err_msg = {
		'ladder1':	'다른회차끼리는 조합불가합니다',
		'ladder2': '좌출/우출과 3줄/4줄 과는 조합불가합니다'
	};
	for(i=0; i<bet._items.length; i++){
		var a = src.wr_subject;
		var b = bet._items[i].wr_subject;

		var alist = a.split("-");
		var blist = b.split("-");

		// 다른회차는 조합안됨
		if( alist[1]!=blist[1] ) return err_msg['ladder1'];

		// 줄,출은 조합안됨
		if( (alist[2]=='line' && blist[2]=='start') ||
		    (alist[2]=='start' && blist[2]=='line')
		) 
		return err_msg['ladder2'];
	}

	return;
}


function add_bet(src, id){
	var gametype =  src.wr_7;
	// 언오버,핸디캡에서는 무에 배팅못한다
	if( gametype!="승무패" && id==3 ) return;
	// 승무패 무배당이 없는경우 무에 배팅못한다.
	if( gametype=="승무패" && id==3 && ( isNaN(src.wr_3) || src.wr_3<1 ) ) return; // 무배당
	// 배팅금지 기능
	// if( id==1 && (typeof(src.wr_1)=="undefined" ||src.wr_1==0) ) { warning_popup('해당팀은 배팅이 금지되었습니다'); return; }
	// if( id==2 && (typeof(src.wr_2)=="undefined" ||src.wr_2==0) ) { warning_popup('해당팀은 배팅이 금지되었습니다'); return; }
	// if( id==3 && (typeof(src.wr_3)=="undefined" ||src.wr_3==0) ) { warning_popup('해당팀은 배팅이 금지되었습니다'); return; }

	var num = src.wr_id;	 // 경기번호
	var ongametime = src.wr_6;	 // 게임시작시간
	var sp = src.wr_7;
	var message = src.wr_content;
	var chk = "chk_"+ src.wr_6+"_"+id;

	var ratio;
	var team1 = src.wr_4;
	var team2 = src.wr_5;
	var league =  src.ca_id;
	var bet1 =  src.wr_1;
	var bet2 =  src.wr_2;
	var bet3 =  src.wr_3;
	var handy_option =  src.handy_option;
	var bo_table = src.bo_table;


	var gametime =  src.wr_6;
	var betStr = bet.getList();
	var select_item = ""+ src.wr_id+"||"+id+"||"+team1+"||"+team2+"";
	var is_new = betStr.indexOf(select_item);
	var select_id = ""+ src.wr_id+"||";
	var is_new_id = betStr.indexOf(select_id);
	var group_id =  src.group_id;


	VarBetContent = getCookie('betcontent'+VarBoTable);
	var betArr = VarBetContent.split("}{");

	if( gametype == "핸디캡" ) var bet3 =  src.wr_8.replace(",", "");

	switch(id) {
		case "1":
			ratio =   src.wr_1;
			src.id = id;
			break;
		case "2":
			ratio =   src.wr_2;
			src.id = id;
			break;
		case "3":
			ratio =   src.wr_3;
			src.id = id;
			break;
	}
	//중복된 선택값이 있으면 선택해제
	if( ( betArr.length > VarMaxCount && is_new_id == "-1" ) || is_new != "-1" ){
		if( is_new == "-1" ) warning_popup("조합가능한 폴더수는 "+VarMaxCount+"폴더 입니다.");
		bet.removeItem(num);
		var isdisabled = false;
		var id_str = String(src.id);
		var ecnt = 4;
		for( var i =1; i < ecnt; i++) {
			var obj_id =  "#chk_"+src.wr_id+"_"+i;
			var bet_id =  "#bet_"+src.wr_id+"_"+i;
			/*
			$j(obj_id).css({'backgroundColor':'#000000', "font-weight":"normal", "color":"white"});
			$j(bet_id).css({'backgroundColor':'#000000', "font-weight":"normal", "color":"white"});
			*/
			$j(obj_id).removeClass("on");
			$j(bet_id).removeClass("on");
			$j(obj_id).addClass("menuOff");
			$j(bet_id).addClass("menuOff");
		}
	}else{
		/*
		var err_msg = is_duplicated(src,id);
		if( err_msg ){
			warning_popup(err_msg);
			return;
		}
		*/
		err_msg = is_duplicated_ladder(src,id);
		if( err_msg ){
			warning_popup(err_msg);
			return;
		}
		var item = {
			"wr_id"			: num,
			"team1"			: team1,
			"team2"			: team2,
			"betteam"		: id,
			"ratio"			: ratio,
			"bet1"			: bet1,
			"bet2"			: bet2,
			"bet3"			: bet3,
			"gametype"		: gametype,
			"sp"			: sp,
			"message"		: message,
			"league"		: league,
			"gametime"		: gametime,
			"group_id"		: group_id,
			"handy_option"	: handy_option,
			"bo_table"		: src.bo_table,
			"wr_subject"	: src.wr_subject
		};
		console.log(item);
		bet.addItem(item);
		var isdisabled = true;
		var ecnt = 4;// 모두 무에 배팅할수있다.
		for( var i =1; i < ecnt; i++) {
			var obj_id =  "#chk_"+src.wr_id+"_"+i;
			var bet_id =  "#bet_"+src.wr_id+"_"+i;
			if( "#chk_"+src.wr_id+"_"+id == obj_id ) {
				$j(obj_id).removeClass("menuOff");
				$j(bet_id).removeClass("menuOff");
				$j(obj_id).removeClass("menuOff_hover");
				$j(bet_id).removeClass("menuOff_hover");
				$j(obj_id).addClass("on");
				$j(bet_id).addClass("on");
				/*
				$j(obj_id).css({"backgroundColor":"#FFCC00", "font-weight":"bold", "color":"#000000"});
				$j(bet_id).css({"backgroundColor":"#FFCC00", "font-weight":"bold", "color":"#000000"});
				*/
			}else	{
				$j(obj_id).removeClass("on");
				$j(bet_id).removeClass("on");
				$j(obj_id).removeClass("menuOff_hover");
				$j(bet_id).removeClass("menuOff_hover");
				$j(obj_id).addClass("menuOff");
				$j(bet_id).addClass("menuOff");
				/*
				$j(obj_id).css({'backgroundColor':'#000000', "font-weight":"normal", "color":"white"});
				$j(bet_id).css({'backgroundColor':'#000000', "font-weight":"normal", "color":"white"});
				*/
			}
		}
	}
	calc(VarBoTable);
}

function del_bet(num) {
	var obj_id =  "#chk_"+num+"_3";
	var ecnt = 4;
	for( var i =1; i < ecnt; i++) {
		var obj_id =  "#chk_"+num+"_"+i;
		var bet_id =  "#bet_"+num+"_"+i;
		$j(obj_id).removeClass("on");
		$j(bet_id).removeClass("on");
		$j(obj_id).addClass("menuOff");
		$j(bet_id).addClass("menuOff");
	}
	bet.removeItem(num);
	calc(VarBoTable);
}
var bet = new BetList();

function BetList() {
	this._items = new Array();
}
BetList.prototype._totalprice;
BetList.prototype._price;
BetList.prototype._bet;
BetList.prototype._items;
BetList.prototype.addItem = function(item) {
	this.removeItem(item.wr_id);
	this._items.push(item);
	add_bet_list(item);
	
	betForm.mode.value = 'betting';
	betForm.betcontent.value= bet.getList();
	betForm.sp_bets.value	= bet._bet;
	betForm.sp_totals.value = bet._totalprice;

	if( is_locked_betting ) return;
	is_locked_betting=true;
    $j.ajax({
    	url: "/ajax.betting_prepare.php",
    	type: 'POST',
		data: $j(betForm).serialize(),
    	success: function(errmsg) {
			errmsg = $j.trim(errmsg);	
			// TODO ; 쿠키삭제..
			if( errmsg ) {
				warning_popup(errmsg);
				del_bet(item.wr_id);
			}
			is_locked_betting=false;
		},
		fail: function(){
			is_locked_betting=false;
		}
	});

}
BetList.prototype.removeItem = function(num) {
	var pos = -1;
	for (var i = 0; i<this._items.length; i++) {
		if (this._items[i].wr_id == num) {
			pos = i;
			break;
		}
	}
	if (pos>=0) {
		del_bet_list(num);
		this._items.remove(pos, pos);
	}
}
BetList.prototype.getList = function(table) {
	var re = "";
	for (var i = 0; i<this._items.length; i++) {

		if( typeof(table) !="undefined" ){
			if( typeof(tmpObj[table]) == "undefined"	) continue;
			if( typeof(tmpObj[table][this._items[i].wr_id]) == "undefined"	) continue;
		}
		re += this._items[i].wr_id
		re += "||"+this._items[i].betteam
		re += "||"+this._items[i].team1
		re += "||"+this._items[i].team2
		re += "||"+this._items[i].bet1
		re += "||"+this._items[i].bet2
		re += "||"+this._items[i].bet3
		re += "||"+this._items[i].ratio
		re += "||"+this._items[i].league
		re += "||"+this._items[i].gametype
		re += "||"+this._items[i].gametime
		re += "||"+this._items[i].group_id
		re += "||"+this._items[i].handy_option;
		re += "||"+this._items[i].bo_table;
		re += "\n";
	}
	return re;
}
BetList.prototype.setPrice = function(price) {
	if(isNaN(price)) price=0;
	this._price = price;
}
BetList.prototype.setPoint = function(point) {
	if(isNaN(point)) point=0;
	this._point = point;
}
BetList.prototype.exec = function() {
	this._bet = 0;
	for (var i = 0; i<this._items.length; i++) {
		if (i == 0) {
			this._bet = 1;
		}
		this._bet = this._bet*(this._items[i].ratio*100);
		this._bet = this._bet/100;
	}
	this._bet = roundXL(this._bet, 2);
	this._totalprice = roundXL((this._price+this._point)*this._bet, 0);
}
BetList.prototype.ClearAll = function() {
	for (var i = 0; i<this._items.length; i++) {
		var item_no = "#num_"+this._items[i].wr_id+"";
		$j(item_no+" .home").removeClass("on");
		$j(item_no+" .bet").removeClass("on");
		$j(item_no+" .away").removeClass("on");
		$j(item_no+" .draw").removeClass("on");
		$j(item_no+" .home").addClass("menuOff");
		$j(item_no+" .bet").addClass("menuOff");
		$j(item_no+" .away").addClass("menuOff");
		$j(item_no+" .draw").addClass("menuOff");

	}

	this._items = new Array();
	var tb = getObject("tb_list");
	while (tb.rows.length>0) {
		tb.deleteRow(0);
	}
	var arr = document.getElementsByTagName("input");
	if (arr.length) {
		for (i=0; i<arr.length; i++) {
			if (arr[i].type=='radio') continue;

			if (arr[i].checked) {
				arr[i].checked = false;
			}
			if (arr[i].disabled) {
				var arrBet = arr[i].getAttribute("bet");
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
//	var tb2 = getObject("tb_list2");
	var tr = tb.insertRow(tb.rowIndex);
//	var tr2 = tb2.insertRow(tb2.rowIndex);

	tr.id = "tb_row_"+item.wr_id;
//	tr2.id = "tb_row2_"+item.wr_id;
	var td = tr.insertCell(0);
//	var td2 = tr2.insertCell(0);
	td.innerHTML = get_item_html(item);
//	td2.innerHTML = get_item_html(item);
}
function del_bet_list(num) {
	var tb = getObject("tb_list");
//	var tb2 = getObject("tb_list2");
	var row = getObject("tb_row_"+num);
//	var row2 = getObject("tb_row2_"+num);
	tb.deleteRow(row.rowIndex);
//	tb2.deleteRow(row2.rowIndex);
}
function get_item_html(item) {
	var re = itemstr;
	var gametype = item.gametype;
	var betteam_str = "";
	var str1 = str2 = str3 = "";

	str1 = '승';
	str2 = '패';
	if( gametype=='오버언더' ) {
		str1='오버';
		str2='언더';
	}

	if (item.betteam == "1") {
		betteam_str = "<font color=''>"+str1+"</font>";
		item.team1 = ""+item.team1+"";
	} else if (item.betteam == "2") {
		betteam_str = "<font color=''>"+str2+"</font>";
		item.team2 = ""+item.team2+"";
	} else if (item.betteam == "3") {
		betteam_str = "<font color=''>"+(str3 || "무")+"</font>";
		//item.team1 = ""+item.team1+" VS "+item.team2;
	}
	re = re.replace("$wr_id", item.wr_id);

	if (item.betteam == "2") {
		re = re.replace("$team1", "<b><font style=''>"+item.team2+"</font></b>");
	}else{
		re = re.replace("$team1", "<b><font color=''>"+item.team1+"</font></b>");
	}
	re = re.replace("$betteam", betteam_str);
	re = re.replace("$ratio", item.ratio);
	return re;
}

function stripHTMLtag(string) { 
   var objStrip = new RegExp(); 
   objStrip = /[<][^>]*[>]/gi; 
   return string.replace(objStrip, ""); 
} 

function calc(table) {
	var price = getObject("betprice").value;
	var point = getObject("betpoint").value;
	price = price.replace(/,/gi,"");
	price = parseInt(price);

	if( typeof(point)=="undefined" ) point = '0';
	point = point.replace(/,/gi,"");
	point = parseInt(point);

	bet.setPoint(point);
	bet.setPrice(price);
	bet.exec();
	var betstr = bet._bet;
	if (betstr.toFixed) {
		betstr = betstr.toFixed(2);
	}
	getObject("sp_bet").innerHTML = betstr;
	getObject("sp_total").innerHTML = MoneyFormat(bet._totalprice);

	betcontent = bet.getList(table);
	betcontent = betcontent.replace(/\n/gi,"}{");
	deleteCookie("betcontent"+table);
	setCookie("betcontent"+table, betcontent);
	setCookie("sp_bet"+table, betstr);
	setCookie("sp_BetMoney"+table, MoneyFormat(point) );
	setCookie("sp_total"+table, MoneyFormat(bet._totalprice) );
}

// 연속배팅방지
var is_locked_betting=false;
function betting(type) {

	// LOCK START
	if( is_locked_betting ) return;
	is_locked_betting=true;

	// CHECK
	if( !betting_check(type) ) {
		is_locked_betting=false;
		return;
	}

    $j.ajax({
    	url: "/ajax.betting.php",
    	type: 'POST',
		data: $j(betForm).serialize(),
    	success: function(errmsg) {
			errmsg = $j.trim(errmsg);	
			// TODO ; 쿠키삭제..
			if( errmsg ) {
				warning_popup(errmsg);
				is_locked_betting=false;
			}
			else{
				del_all_cookies();
				document.location.href='/bbs/betting.php?mode=betting';
			}
		},
		fail: function(){
			is_locked_betting=false;
		}
	});
}
function betting_check(type){
	if( bet._items.length < VarMinBettingCount) {
		warning_popup("배팅은 "+VarMinBettingCount+"폴더 이상부터 가능합니다.");
		return;
	}

	var min_bet = 0;
	var max_bet = 0;
	var max_amount = 0;
	var max_betting_count = 0;
	min_bet = parseInt(eval("VarMinBet"));
	max_bet = parseInt(eval("VarMaxBet"));
	max_bet2 = parseInt(eval("VarMaxBet2"));
	max_amount = parseInt(eval("VarMaxAmount"));
	max_amount2 = parseInt(eval("VarMaxAmount2"));
	max_betting_count = parseInt(eval("VarMaxCount"));
	
	if (bet._items.length == 0) {
		warning_popup("베팅할 경기를 선택하십시오.");
		return;
	}
	if (bet._totalprice == 0 ) {
		warning_popup("배팅액을 입력하셔야 합니다");
		return;
	}
	///////////////////////////////////////////////////
	// 배당률체크
	if( VarMaxRatio && VarMaxRatio>0 && (bet._bet - VarMaxRatio)>0 ){
		warning_popup("최대배당률 ("+VarMaxRatio+") 을 초과하였습니다");
		return;
	}

	///////////////////////////////////////////////////
	// 보유금액 체크
	if(bet._price>0){
		if (bet._price > VarMoney) {
			warning_popup("베팅금액이 보유머니보다 클 수 없습니다.");
			return;
		}
	}else{
		if (bet._point > VarPoint) {
			warning_popup("베팅포인트가 보유포인트보다 클 수 없습니다.");
			return;
		}
	}

	///////////////////////////////////////////////////
	// 단폴더인경우
	if( bet._items.length == 1) {
		max_bet = max_bet2;
		max_amount = max_amount2;
	}

	
	// 배팅한도 체크
	bet_price = bet._point + bet._price;	
	if (bet_price<min_bet || bet_price>max_bet) {
		if( bet._items.length == 1) {
			warning_popup("단폴더 베팅액은 "+MoneyFormat(min_bet)+"~"+MoneyFormat(max_bet)+"원 사이입니다.");
			return;
		}
		else {
			warning_popup("베팅액은 "+MoneyFormat(min_bet)+"~"+MoneyFormat(max_bet)+"원 사이입니다.");
			return;
		}
	}
	if (bet._totalprice>max_amount) {
		if( bet._items.length == 1) {
			warning_popup("단폴더 최대적중금은 "+MoneyFormat(max_amount)+"를 넘을 수 없습니다.");
		}else{
			warning_popup("최대적중금은 "+MoneyFormat(max_amount)+"를 넘을 수 없습니다.");
		}
		return;
	}
	///////////////////////////////////////////////////
	// 배팅폴더 체크
	if (bet._items.length > max_betting_count) {
		warning_popup("최대 "+max_betting_count+" 폴더 이하만 베팅이 가능합니다.");
		return;
	}

	betForm.mode.value = type;

	var msg = "";
	// 단폴배당하락 경고 메세지
	if( bet._items.length == 1 && VarBoTable<='a50' && VarDanpolDown>0 ) msg += "단폴배팅시 "+VarDanpolDown+"의 배당하락이 발생합니다\n";
	msg += "베팅내역을 확인 하시고 일치하면 [확인] 버튼을 클릭 해 주세요. \n한번 배팅하면 취소가 불가능합니다";
	if (!confirm(msg)) return;

	betForm.betcontent.value = bet.getList();
	betForm.sp_bets.value = 	bet._bet;
	betForm.sp_totals.value = bet._totalprice;

	return true;

}
function del_all_cookies(){
	var table_list = ['a10','a30','a40','a50','a70','a90','a91','a92','a93','a94','a95','a96','a97','a98'];
	for(i=0; i<table_list.length; i++){
		deleteCookie("betcontent"+table_list[i]);
	}
}
function del_all() {
	bet.ClearAll();
	calc(VarBoTable);
}

function BetContentLoad(table)
{
	var tmpZ = tmpObj[ table ];
	
	VarBetContent = getCookie('betcontent'+table);
	if( VarBetContent ) {
		var betArr = VarBetContent.split("}{");
		for( var y = 0; y < betArr.length-1; y++)
		{
			bettingCart[y] = betArr[y].split("||");
			var wr_id = bettingCart[y][0];

			//화면상에 객체가 있는지 확인한다.
			if( typeof(tmpZ[wr_id]) != "undefined" && tmpZ[wr_id].wr_is_comment == "0" ) {
				var betteam = bettingCart[y][1];
				var src = tmpZ[wr_id];
				var sp = VarSpBet;
				var gametime = src.wr_6;
				var homescore = src.wr_9;
				var awayscore = src.wr_10;
				var message = "";
				var bet3 = src.wr_3;
				if( gametype == "핸디캡" ){
					var bet3 = src.wr_8.replace(",", "");
				}

				switch (betteam) {
				case "1":
					var ratio =  src.wr_1;
					break;
				case "2":
					var ratio =  src.wr_2;
					break;
				case "3":
					var ratio =  src.wr_3;
					break;
				}
				var item = {
					"wr_id"			: src.wr_id,
					"team1"			: src.wr_4,
					"team2"			: src.wr_5,
					"betteam"		: betteam,
					"ratio"			: ratio,
					"bet1"			: src.wr_1,
					"bet2"			: src.wr_2,
					"bet3"			: bet3,
					"gametype"		: src.wr_7,
					"sp"			: sp,
					"message"		: message,
					"league"		: src.ca_id,
					"gametime"		: gametime,
					"group_id"		: src.group_id,
					"handy_option"	: src.handy_option,
					"bo_table"		: table,
					"wr_subject"	: src.wr_subject
				};
				is_endgame = false;

				var to_time = gametime.split(" ");
				var t_date = to_time[0].split("-");
				var t_time = to_time[1].split(":");

				var b_infos = clock.time_str.split(" ");
				var b_date = b_infos[0].split("-");
				var b_time = b_infos[1].split(":");
				
				var end_min = parseInt(VarEndTime/60);
				var end_sec = VarEndTime%60;

				var Ngametime = new Date(t_date[0],t_date[1]-1,t_date[2],t_time[0],t_time[1]-end_min,t_time[2]-end_sec);
				var nowDate = new Date(b_date[0],b_date[1]-1,b_date[2],b_time[0],b_time[1],b_time[2]);
				if( nowDate < Ngametime &&  homescore == "" && awayscore == "" && tmpZ[wr_id].wr_is_comment == "0" ) {
					is_endgame = true;
					bet.addItem(item);

					var ecnt = 4;
					if ( is_endgame == true )
					{
						for( var i =1; i < ecnt; i++) {
							var obj_id =  "#chk_"+wr_id+"_"+i;
							var bet_id =  "#bet_"+wr_id+"_"+i;
							if( betteam == i ) {
								$j(obj_id).removeClass("menuOff");
								$j(bet_id).removeClass("menuOff");
								$j(obj_id).addClass("on");
								$j(bet_id).addClass("on");
								/*
								$j(obj_id).css({"backgroundColor":"#FFCC00", "font-weight":"bold", "color":"#000000"});
								$j(bet_id).css({"backgroundColor":"#FFCC00", "font-weight":"bold", "color":"#000000"});
								*/
							}else	{
								/*
								$j(obj_id).css({'backgroundColor':'#000000', "font-weight":"normal", "color":"white"});
								$j(bet_id).css({'backgroundColor':'#000000', "font-weight":"normal", "color":"white"});
								*/
								$j(obj_id).removeClass("on");
								$j(bet_id).removeClass("on");
								$j(obj_id).addClass("menuOff");
								$j(bet_id).addClass("menuOff");
							}
						}
					}

				}//시간을 비교하고 경기시간이 지나면 쿠키목록을 무시한다.
			}else{
				del_bet(wr_id);
			}// 객체 있을때 
		}//반복종료
		calc(table);
	}
}


// 게임별 서버 설정
function init(path) {
	loading = true;
	var table_list = null;

	del_all_cookies();

	// 서버상의 게임정보목록 json 파일을 읽는다 : gamelistall.php
	$j.getJSON(path, {"sca":VarCaId, "bo_table":VarBoTable},function(data,textStatus){
		bet.ClearAll();
		table = VarBoTable;
		// 게임리스트 그리기 and tmpObj 변수 업데이트
		display_gamelist(data,table);
		
		// 스포츠게임 종목리스트 그리기
		if (table=='a10' || table=='a30' || table=='a50') {
			display_leaguelist(data);
		}
		else if (table=='a25') {
			display_leaguelist2(data);
		}

		// 장바구니 표시
		BetContentLoad(table);
		loading = false;

	});
}
// 게임별 서버 설정
function init2(path) {
	loading = true;
	var table_list = null;

	del_all_cookies();

	// 서버상의 게임정보목록 json 파일을 읽는다 : gamelistall.php
	$j.getJSON(path, {"sca":VarCaId, "bo_table":VarBoTable2},function(data,textStatus){
		//bet.ClearAll();
		table = VarBoTable2;
		// 게임리스트 그리기 and tmpObj 변수 업데이트
		//display_gamelist(data,table);
		
		// 스포츠게임 종목리스트 그리기
		if (table=='a10' || table=='a30' || table=='a50') {
			display_leaguelist(data);
		}
		else if (table=='a25') {
			display_leaguelist2(data);
		}

		// 장바구니 표시
		//BetContentLoad(table);
		loading = false;

	});
}
/**
 * 기능 : tmpObj 변수 업데이트, 게임목록 표시
 * @param data	: 게임 리스트
 * @param table	: a10, a20, ..
 */
function display_gamelist(data,table){
	var i = 0;
	var bonus_cnt_arr = new Array();
	var trackback_num = 0;
	var bg_num = 0;
	ca_names = "";
	var ca_name_str ="";
	var team_width = "190";
	var is_ca_name_b = "";
	var group_id_xx = "";
	var board_view_txt = "";	
	var board_view_txt2 = "";	
	var listbackGround  = "";
	var tmp_group_cnt = 0;
	var is_multi_mode = 0;
	if (VarBoTable == 'a10') {
		is_multi_mode = 0;
	}

	var tmpZ = tmpObj[table] = {};

	if( parseInt(VarColspan) > 9 ){
		ca_name_str = "<td width=\"130\"></td>";
		team_width = "130";
	}

	$j.each(data, function() {
		is_ca_name = 0;
		is_content_chk = "";
		div_content = "";
		state = "";
		is_notice = "";
		list_wr_8 = this.wr_8.split(",");
		is_endgame = false;
		is_handyClick = true;
		background_color = "222222";
		css_over = "";
		css_under = "";

		this.bo_table = table; // 게시판 테이블변수 추가

		bg_num = i % 2;
		if( this.wr_type!='notice' ){
		//=={{ notice 아닐때만 팀명 수정 ===


		switch(this.wr_7){
			case "승무패":
				if(isNaN(this.wr_3) || this.wr_3<1) this.handy = 'VS'; //무배당
				else this.handy = this.wr_3;

				if( VarBoTable=='a90' ){
					if( this.wr_subject.indexOf('-cross')==-1 && this.wr_subject.indexOf('-order')==-1 ){
						this.handy = "<font color='skyblue'>[임]</font> "+this.handy;
						this.wr_4 = this.wr_4.replace("[네]","<font color='red'>[네]</font>");
						this.wr_5 = this.wr_5.replace("[드]","<font color='lime'>[드]</font>");
					}else{
						this.wr_4 = this.wr_4.replace("[네]","<font color='red'>[네]</font>");
						this.wr_4 = this.wr_4.replace("[임]","<font color='skyblue'>[임]</font>");
						this.wr_4 = this.wr_4.replace("[드]","<font color='lime'>[드]</font>");
						this.wr_4 = this.wr_4.replace("복승","<font color='yellow'>복승</font>");

						this.wr_5 = this.wr_5.replace("[네]","<font color='red'>[네]</font>");
						this.wr_5 = this.wr_5.replace("[임]","<font color='skyblue'>[임]</font>");
						this.wr_5 = this.wr_5.replace("[드]","<font color='lime'>[드]</font>");
						this.wr_5 = this.wr_5.replace("복승","<font color='yellow'>복승</font>");

						// 복승일대
						if( this.wr_subject.indexOf('-cross')!=-1 ){
							this.handy = "<font color='skyblue'>[임]</font><font color='lime'>[드]</font> " + this.handy;
						}

					}
				}
				break;
			case "핸디캡":
				this.handy = list_wr_8[0];
				
				css_over = "<font style='color:#ffa604'>[H]</font>";
				css_under = "<font style='color:#ffa604'>[H]</font>";

				switch (this.handy_option)
				{
					case "1":
					this.handy = this.handy+ "<span style=\"font-size:14pt;\">½</span>";
					break;
					case "2":
					this.handy =  this.handy+"<span style=\"font-size:14pt;\">¼</span>";
					break;
					case "3":
					this.handy =  this.handy+"<span style=\"font-size:14pt;\">¾</span>";
					break;
				}

				if(isNaN(this.handy) || this.handy==0) this.handy='VS';
				else this.handy = "<font color=''>"+this.handy+"</font>";

				break;
			case "오버언더":
				css_over = "<img src='/10bet/images/10bet/up.png' align='absmiddle'>";
				css_under = "<img src='/10bet/images/10bet/dw.png' align='absmiddle'>";
				this.handy = "<font color=''>"+this.wr_3+"</font>";
				this.wr_4 = this.wr_4+"";
				this.wr_5 = this.wr_5+"";
				break;
		}

		// 파워볼 처리
		if( VarBoTable=='a60' ){
			var arr = this.wr_subject.split('-');
			switch(arr[2]){
			case "n1":
			case "2": // 일반볼합 홀/짝
				break;

			case "n2":
			case "3": // 일반볼합 대중소
				this.handy = "중(65~80) &nbsp;&nbsp;<font color=red>" + this.handy + "</font>";
				break;

			case "p1": 
			case "1": // 파워볼 홀/짝
				this.wr_4 = '<img src="/10bet/images/powerball_holl.png">';
				this.wr_5 = '<img src="/10bet/images/powerball_jjak.png">';
				break;

			case "p2":
			case "4": // 파워볼 오버언더
				this.wr_4 = '<img src="/10bet/images/powerball_5over.png">';
				this.wr_5 = '<img src="/10bet/images/powerball_4under.png">';
				break;
			}
		}
		// 로하이 처리
		if( VarBoTable=='a70' ){
			var arr = this.wr_subject.split('-');
			switch(arr[2]){
			case "low": // 로/하이
				this.wr_4 = arr[1]+'회 <img src="/10bet/images/lowhigh_low.png" align="middle">';
				this.wr_5 = '<img src="/10bet/images/lowhigh_high.png" align="middle"> '+ arr[1]+'회';
				break;
			case "odd": // 홀/짝
				this.wr_4 = arr[1]+'회 <img src="/10bet/images/lowhigh_odd.png" align="middle">';
				this.wr_5 = '<img src="/10bet/images/lowhigh_even.png" align="middle"> '+ arr[1]+'회';
				break;
			}
		}


		//=={{ notice 아닐때만 팀명 수정 ===
		}



		a_infos = this.wr_6.split(" ");
		a_date = a_infos[0].split("-");
		a_time = a_infos[1].split(":");

		var b_infos = clock.time_str.split(" ");
		var b_date = b_infos[0].split("-");
		var b_time = b_infos[1].split(":");
		
		var end_min = parseInt(VarEndTime/60);
		var end_sec = VarEndTime%60;

		var gametime = new Date(a_date[0],a_date[1]-1,a_date[2],a_time[0],a_time[1]-end_min,a_time[2]-end_sec);
		var nowDate = new Date(b_date[0],b_date[1]-1,b_date[2],b_time[0],b_time[1],b_time[2]);

		background_color = "000000";
		chk1 = "onClick=\"check_bet("+this.wr_id+", '1')\"";
		chk2 = "onClick=\"check_bet("+this.wr_id+", '2')\"";

		//등록된 게임시간이 현재시간보다 클때 무조건 마감처리
		if( gametime  > nowDate ){
			//해당 경기의 결과 스코어가 없을때 표시한다.
			if( this.wr_9 == "" && this.wr_10 == ""  ) {
				//배팅
				state = "<font color='#1cfe3e' style='display:block;width:45px;'>배팅</font>";
				if( this.wr_is_comment == "1" || this.wr_reply=="1" ) { // 멈춤기능
					state = "대기";
					is_endgame = true;
					bg_num = 2;
					background_color = "222222";
					chk1 = "";
					chk2 = "";
				}else if( this.wr_is_comment == "2" )	{
					state = "<font color='red' style='display:block;width:45px;'>마감</font>";
					is_endgame = true;
					bg_num = 2;
					background_color = "222222";
					chk1 = "";
					chk2 = "";
				}
			}else{
				state = "<font color='red' style='display:block;width:45px;'>마감</font>";
				is_endgame = true;
				bg_num = 2;
				background_color = "222222";
				chk1 = "";
				chk2 = "";
			}
		}else{
			state = "<font color='red' style='display:block;width:45px;'>마감</font>";
			is_endgame = true;
			bg_num = 2;
			background_color = "222222";
			chk1 = "";
			chk2 = "";
		}

		// 관리자는 마감 없음 
		if( g4_is_admin ) {
			is_endgame = false;
        	chk1 = "onClick=\"check_bet("+this.wr_id+", '1')\"";
        	chk2 = "onClick=\"check_bet("+this.wr_id+", '2')\"";
		}


		tmpZ[this.wr_id] = this;

		//핸디가 있는 경기이고 종료된 경기가 아닐때
		if( this.handy != "" && this.handy != "-" && this.handy != "X" && this.handy != "x" && is_handyClick == true && is_endgame == false){
			chk3 = "onClick=\"check_bet("+this.wr_id+", '3')\"";
		}
		else{
			chk3 = "";
		}

		//공지가 있으면 별을 표시
		if( this.wr_content ) {
			div_content = "<div style='position:absolute'><div id='is_content_"+this.wr_id+"' style='display:none;position:relative;left:-200px; top:-25px; background-color:#000;color:#fff;width:200px;height:100px;padding:5px;border:2px solid #8B2118' onclick=\"view_layer('"+this.wr_id+"', 'none' )\" class=\"content_layer\">"+this.wr_content+"</div></div>";
			is_content_chk = "<span onclick=\"view_layer('"+this.wr_id+"', 'view')\" style='cursor:pointer'>★</span>";
		}else{
			is_content_chk = "";
			div_content = "";
		}

		//관리자일경우 통합경기수정을 추가한다.
		if( is_admin )
		{
			if( VarBoTable != "a30" )
			{
				s_mod2 = " class=\"gamedate pointer\" title=\""+this.group_id+" 통합경기수정\" onClick=\"window.open('"+g4_path+"/adm/game_all_form.php?w=u&group_id="+this.group_id+"');\" ";
			}else{
				s_mod2 = " class=\"gamedate pointer\" title=\""+this.group_id+" 통합경기수정\" onClick=\"window.open('"+g4_path+"/adm/special_all_form.php?w=u&group_id="+this.group_id+"');\" ";
			}
		}else s_mod2 = " class=\"gamedate\" ";

		var home_name = this.wr_4.split(",");
		var away_name = this.wr_5.split(",");

		if( this.wr_7 == "오버언더" ) {
			//home_name[0] = home_name[0]+"<font color='#ea6e13'>(오버)</font>";
			//away_name[0] = "<font color='#2a83ca'>(언더)</font>"+away_name[0];
		}
	
		
		//리스트 타입이 리그별 묶음 일때는
		if( VarListViewMode == "1" ) {
			
			xxx = this.ca_name;
			if( VarBoTable=='a40' || VarBoTable=='a60' || VarBoTable=='a70' ||  VarBoTable=='a90' || VarBoTable>'a94' ) {
				rrr = this.wr_subject.split('-');
				xxx = rrr[0]+'-'+rrr[1];
				//this.ca_name += ' '+rrr[1]+'회';
			}
			else{
				xxx = this.ca_name+'|'+this.wr_6;
				// 벳365,SKYbet
				if( VarBoTable>='a91' && VarBoTable<='a94' ){
					this.ca_name += " " + this.wr_subject;
				}
			}
			
			if(home_name[0].indexOf("폴더")!=-1){
				this.ca_name = "";
			}

			if(is_ca_name_b!=xxx && this.wr_type!='notice'){
				if(i>0)board_view_txt = board_view_txt + "</div>";

				var bgtag=''; if( this.icon ) bgtag = " background='" + this.icon +"' ";

				//board_view_txt = board_view_txt + "<div class='ko_sports_game j_"+this.bn_id+"_t'>"; 
				if(home_name[0].indexOf("폴더")!=-1){
				//board_view_txt = board_view_txt + "";
				board_view_txt = board_view_txt + "<div class='ko_sports_game bonus_div j_"+this.bn_id+"_t'>"; 
				}else {
				board_view_txt = board_view_txt + "<div class='ko_sports_game j_"+this.bn_id+"_t'>"; 
				board_view_txt = board_view_txt + 
				/*"<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"background:#000;border:1px solid #2a3a2d;margin:5px 0;\" "+bgtag+">"+
				"<tr class='league' > "+
				"<td style='text-align:left'>"+
				"<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"+
				"<tr> "+
				"<td  style='font-size:13px;  text-align:left; letter-spacing:-1px; line-height:27px;padding:5px;color:#fff;'>"+this.ca_name+"</td>"+
				"<td  style='font-size:13px;text-align:right; letter-spacing:-1px; line-height:27px;padding:5px;color:#fff;'>"+this.wr_6+"</td>"+
				"</tr>"+
				"</table>"+
				"</td>"+
				"</tr>"+
				"</table>"+*/
				"<h4><a name='target_"+this.bn_id+"'></a>"+
				"<img src='"+this.icon+"' class='ico01' style='height:;'>&nbsp;"+
				"<img src=\"/10bet/images/10bet/arrow_01.png\" class=\"arrow\" alt=\"\" /><font class='league_name'>"+this.ca_name+"</font>"+
				"<span class='time'>"+this.wr_6.substring(5, 10)+"&nbsp;"+this.wr_6.substring(11, 16)+"</span>"+
				"</h4>";
				}
				if(home_name[0].indexOf("폴더")!=-1){
				//board_view_txt = board_view_txt + "</div>";
				}else {
				//board_view_txt = board_view_txt + "</div>";
				}

				is_ca_name_b = xxx;
			}
		}else{
			ca_name_str = "<h4 width=\"140\" class=\"legue\"><nobr style=\"overflow:hidden;width:210px;\">"+this.ca_name+"</nobr></h4>";
		}
		
		var menuOffCss="menuOff";
		if( is_endgame ) menuOffCss="menuOff_magam";
		
		if(bg_num==0)listbackGround = "";
		else listbackGround = "";

		if( this.wr_type=='notice' ){
		//{{{ 공지사항 =========================================
			/*board_view_txt = board_view_txt + "<table width=\"100%\" border=\"0\" height=\"30\" cellpadding=\"0\" cellspacing=\"0\" style='margin-top:5px;'>	"+
			"<tr bgcolor='"+listbackGround+"' > "+
			"<td width='*' bgcolor=\"#222222\" align=\"center\"  class=\"menu1\" >"+
			"	<table width='100%' border=\"0\"cellspacing=\"0\" cellpadding=\"0\" class=\"pointer homeTeam "+menuOffCss+"\" height=\"27\" >"+
			"		<tr> "+
			"		<td width=\"8\" style='border-right: solid 0px;'>&nbsp;</td>"+
			"		<td style='border-left: solid 0px; border-right: solid 0px; color:#ffffff' align='center'><strong>"+home_name[0]+"</strong></td>"+
			"		<td width=\"6\" align=\"right\" style='border-left: solid 0px;'>&nbsp;</td>"+
			"		</tr>"+
			"	</table>"+
			"</td>"+
			"<td width='0'></td>"+
			"<td align=\"center\" width=\"0\" ></td>"+
			"</tr>"+
		"</table>"+
		"<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"+
		"	<tr> "+
		"	<td height=\"3\"></td>"+
		"	<td ></td>"+
		"	</tr>"+
		"</table>";*/
		//{{{ 공지사항 =========================================
		}
		else if( VarBoTable=='a60' || VarBoTable=='a90' ){
		//{{{ 파워볼 =========================================
			board_view_txt = board_view_txt + "<table width=\"100%\" border=\"0\" height=\"30\" cellpadding=\"0\" cellspacing=\"0\" style='margin-top:5px;'>	"+
			"<tr bgcolor='"+listbackGround+"' id=\"num_"+this.wr_id+"\"> "+
			"<td width=\"12%\" align='center' class=\"num_orange\" style='font-size:13px; '>"+this.wr_6.substring(5, 10)+"<font style='font-size:13px; color:#333;'>&nbsp;&nbsp;"+this.wr_6.substring(11, 16)+"</font></td>"+
			"<td width=\"27%\" align=\"center\"  class=\"menu1\" "+chk1+">"+
			"	<table width=\"100%\" border=\"0\"cellspacing=\"0\" cellpadding=\"0\" onmouseover='highlight(this,true)' onmouseout='highlight(this,false)' class=\"pointer homeTeam "+menuOffCss+"\" height=\"32\" id=\"chk_"+this.wr_id+"_1\">"+
			"		<tr> "+
			"		<td width=\"8\">&nbsp;</td>"+
			"		<td class=\"bet1\"><strong>"+home_name[0]+"</strong></td>"+
			"		<td width=\"50\" align=\"right\"  class=\"bet1 "+css_over+"\"><strong>"+this.wr_1+"</strong></td>"+
			"		<td width=\"6\" align=\"right\">&nbsp;</td>"+
			"		</tr>"+
			"	</table>"+
			"</td>"+
			"<td width=\"3\">&nbsp;</td>"+
			"<td width=\"27%\" align=\"center\" "+chk3+">"+
			"	<TABLE width=\"100%\" height=\"32\" border=\"0\" cellpadding=0 cellspacing=0 onmouseover='highlight(this,true)' onmouseout='highlight(this,false)' class=\"pointer muSelect "+menuOffCss+"\" id=\"chk_"+this.wr_id+"_3\">"+
			"		<TR>"+
			"		<TD class=\"bet1\" align=center><strong>"+this.handy+"</strong></TD>"+
			"		</TR>"+
			"	</TABLE>"+
			"</td>"+
			"<td width=\"3\">&nbsp;</td>				"+
			"<td align=\"center\" width=\"27%\" align=\"right\" "+chk2+">"+
			"	<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"  onmouseover='highlight(this,true)' onmouseout='highlight(this,false)' class=\"pointer awayTeam "+menuOffCss+"\" height=\"32\" id=\"chk_"+this.wr_id+"_2\">"+
			"		<tr> "+
			"		<td width=\"6\">&nbsp;</td>"+
			"		<td width=\"40\" class=\"bet1\"><strong>"+this.wr_2+"</strong></td>"+
			"		<td align=\"right\" class=\"bet1 "+css_under+"\"><strong>"+away_name[0]+"</strong></td>"+
			"		<td width=\"8\">&nbsp;</td>"+
			"		</tr>"+
			"	</table>"+
			"</td>	 "+
			"<td width=\"6%\" align=\"center\" class=\"olive8\">"+state+"</td>"+
			"</tr>"+
		"</table>";
		//}}} 파워볼 =========================================
		}
		//}}} 보너스 폴더 =========================================
		else if(home_name[0].indexOf("폴더")!=-1){
			bonus_cnt_arr[i] = i;

			board_view_txt = board_view_txt + 
			/*"<table class=\"bonus_table\" border=\"0\" height=\"36\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:#222;padding:4px 0;\">	"+
			"<tr bgcolor='"+listbackGround+"' id=\"num_"+this.wr_id+"\"> "+
			"<td width=\"2\">&nbsp;</td>"+
			"<td width=\"100%\" align=\"center\"  class=\"menu1\" "+chk1+">"+
			"	<table width=\"100%\" height=\"40px\"border=\"0\"cellspacing=\"0\" cellpadding=\"0\" onmouseover='highlight(this,true)' onmouseout='highlight(this,false)' class=\"pointer homeTeam "+menuOffCss+"\" height=\"32\" id=\"chk_"+this.wr_id+"_1\">"+
			"		<tr> "+
			"		<td width=\"8\">&nbsp;</td>"+
			"		<td style='text-align:center;font-size:14px;'>"+home_name[0]+"</td>"+
			"		<td width=\"50\" align=\"right\"  class=\"bet1 "+css_over+"\"><strong>"+this.wr_1+"</strong></td>"+
			"		<td width=\"6\" align=\"right\">&nbsp;</td>"+
			"		</tr>"+
			"	</table>"+
			"</td>"+
			"<td width=\"2\">&nbsp;</td>"+
			"</tr>"+
		"</table>";*/
		"<ul class='bonus_ul'>"+
		"<li id=\"num_"+this.wr_id+"\">"+
		"<div class='bet_area bonus_div'>"+
		"<div class='' "+chk1+" style='width:100%;'>"+home_name[0]+" <span class='bed'>"+this.wr_1+"</span></div>"+
		"</li>"+
		"</ul>";
		//}}} 보너스 폴더 =========================================
		
		}
		else {
		//{{{ 그외 =========================================
			var home_img = this.wr_email;
			var away_img = this.wr_subject
			if(home_img){
				if(home_name[0].indexOf("선수득점")!=-1){
					home_img = "<img src='"+this.wr_email+"' height='50'>";
					var td_height = "50";
				}else {
					home_img = "<img src='"+this.wr_email+"' height='45'>";
					var td_height = "45";
				} 
		
			}
			if(away_img){ 
				if(home_name[0].indexOf("선수득점")!=-1){
					away_img = "<img src='"+this.wr_subject+"' height='50'>";
					var td_height2 = "50";
				}else {
					away_img = "<img src='"+this.wr_subject+"' height='45'>";
					var td_height2 = "45";
				} 
			}

			if(this.bo_table == 'a91' || this.bo_table == 'a92') away_img = "";

			var is_start = false;
			var is_ing = false;
			var is_end = false;
			if (!this.group_cnt) this.group_cnt=1;
			if (this.group_cnt > 1) {
				tmp_group_cnt++;
				if (tmp_group_cnt == 1)				is_start = true;
				if (tmp_group_cnt > 1)				is_ing = true;
				if (this.group_cnt == tmp_group_cnt){is_end = true;tmp_group_cnt=0;}
			} else {
				tmp_group_cnt = 0;
				is_start = true;
				is_end = true;
			}
			if (!is_multi_mode) is_start = true;
			if (is_start) {
				if(this.wr_trackback == "1"){
				board_view_txt2 = board_view_txt2 + 
				"<div class='today_sports'>"+
					"<div class='title_area'>"+
						"<h3>오늘의 경기</h3>"+
						"<h4>Today Match</h4>"+
					"</div>"+
					"<div class='more_btn'>"+
						"<a href='#target_"+this.bn_id+"'><button class='more'>더보기</button></a>"+
						"<button class='close'>닫기</button>"+
					"</div>"+
				"<!-- 상단 스포츠 -->"+
				"<div class='head_sports'>"+
					"<div class='team_name'>"+home_name[0]+" - "+away_name[0]+"</div>"+
					"<div class='date'>"+this.wr_6.substring(5, 10)+"&nbsp;"+this.wr_6.substring(11, 16)+" / "+this.bn_url+" / "+this.bn_alt+"</div>"+
					"<div class='bet_area'>"+
						"<div class='home'>"+home_name[0]+"</div>&nbsp;"+
						"<div class='vs'>VS</div>&nbsp;"+
						"<div class='away'>"+away_name[0]+"</div>"+
					"</div>"+
				"</div>";
				trackback_num ++;
				}
				// 홈 원정 타이틀 영역 : A VS B
				board_view_txt = board_view_txt + 
					"<ul>";
					if(this.group_id != group_id_xx){
					board_view_txt = board_view_txt + 
					"<li class='li_border_x'></li>";
					}
					group_id_xx = this.group_id;
					board_view_txt = board_view_txt + 
					"<li id=\"num_"+this.wr_id+"\">"+
					"<div class='type01 "+tmp_group_cnt+"'>"+this.wr_7+"</div>"+
					"<div class='bet_area'>"+
					"<div class='home "+menuOffCss+"' "+chk1+" id=\"chk_"+this.wr_id+"_1\"><font class='team_name'>"+css_over+" "+home_name[0]+"</font> <span class='bed'>"+this.wr_1+"</span></div>&nbsp;"+
					"<div class='draw "+menuOffCss+"' "+chk3+" id=\"chk_"+this.wr_id+"_3\">"+this.handy+"</div>&nbsp;"+
					"<div class='away "+menuOffCss+"' "+chk2+" id=\"chk_"+this.wr_id+"_2\"><font class='team_name'>"+css_under+" "+away_name[0]+"</font> <span class='bed'>"+this.wr_2+"</span></div>"+
					"</div>"+
					"</li>"+
					"</ul>";
					
				if (!is_multi_mode) {
					//board_view_txt = board_view_txt + "<td width=\"8%\" align=\"center\" class=\"olive8\">"+state+"</td>";
				} else {
					if (this.group_cnt == 1) {
						board_view_txt = board_view_txt + "<td width=\"8%\" align=\"center\" class=\"olive8\">"+state+"</td>";
					} else {
						var onclick_str = " onclick=\"showAndHideElemId(this, 'col_"+this.bn_id+"_"+this.group_id+"');\" ";
						var count_str = "+"+(this.group_cnt-1);
						if( this.group_cnt == 1 ) {
							onclick_str='';
							count_str ='0';
						}
						
						var btn_count = "<input type='button' style='width:45px;height:32px;background:#000000;color:#31ed61;font-weight:bold;border:1px solid #31ed61;line-height:30px;cursor:pointer;' value='"+count_str+"'" + onclick_str + "><input type='hidden' id='hidden_col_"+this.bn_id+"_"+this.group_id+"' value='"+count_str+"'>";
						board_view_txt = board_view_txt + "<td width=\"8%\" align=\"center\" class=\"olive8\">"+btn_count+"</td>";
					}
				}
				
				board_view_txt = board_view_txt + 
				"</tr>"+
				"</table>";
				if(this.wr_trackback == '1') {	
					board_view_txt2 = board_view_txt2 + 
					"</div><!-- 오늘의경기END  -->";
				}
			}
			if (is_multi_mode) {
			if (is_start) {
				// show and hide 를 하기 위한 wrap div 
				board_view_txt = board_view_txt + "<div id='col_"+this.bn_id+"_"+this.group_id+"' style='width:100%;margin-left:0%;text-align:center;display:none;'>";
			}
			if (is_ing) {
				board_view_txt = board_view_txt + "<table id='col_"+this.bn_id+"_"+this.group_id+"' width=\"100%\" border=\"0\" height=\"30\" cellpadding=\"0\" cellspacing=\"0\"  style=\"padding:5px 0;table-layout:fixed;\">	"+
				"<tr bgcolor='"+listbackGround+"' id=\"num_"+this.wr_id+"\"> "+
				/*"<td width=\"14%\" align='center' class=\"num_orange\" style='font-size:14px;'>"+this.wr_6.substring(5, 10)+"<font style='font-size:14px; color:#f60000;'>&nbsp;&nbsp;"+this.wr_6.substring(11, 16)+"</font></td>"+*/
				"<td width=\"20%\" align='left' style='font-size:13px; color:#fff;border:1px solid #89e954; '><font style='font-size:13px;color:#fff;'>&nbsp;"+this.wr_7+"</font></td>"+
				"<td width=\"2\">&nbsp;</td>"+
				"<td width=\"34%\" align=\"center\"  class=\"menu1\" "+chk1+">"+
				"	<table width=\"100%\" border=\"0\"cellspacing=\"0\" cellpadding=\"0\" onmouseover='highlight(this,true)' onmouseout='highlight(this,false)' class=\"pointer homeTeam "+menuOffCss+"\" height=\"32\" id=\"chk_"+this.wr_id+"_1\">"+
				"		<tr> "+
				"		<td width=\"8\">&nbsp;</td>"+
				"		<td style='text-align:left'>"+home_name[0]+"</td>"+
				"		<td width=\"50\" align=\"right\"  class=\"bet1 "+css_over+"\">"+this.wr_1+"</td>"+
				"		<td width=\"6\" align=\"right\">&nbsp;</td>"+
				"		</tr>"+
				"	</table>"+
				"</td>"+
				"<td width=\"2\">&nbsp;</td>"+
				"<td width=\"8%\" align=\"center\" "+chk3+">"+
				"	<TABLE width=\"100%\" height=\"32\" border=\"0\" cellpadding=0 cellspacing=0 onmouseover='highlight(this,true)' onmouseout='highlight(this,false)' class=\"pointer muSelect "+menuOffCss+"\" id=\"chk_"+this.wr_id+"_3\">"+
				"		<TR>"+
				"		<TD class=\"bet1\" align=center>"+this.handy+"</TD>"+
				"		</TR>"+
				"	</TABLE>"+
				"</td>"+
				"<td width=\"2\">&nbsp;</td>				"+
				"<td align=\"center\" width=\"34%\" align=\"right\" "+chk2+">"+
				"	<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"  onmouseover='highlight(this,true)' onmouseout='highlight(this,false)' class=\"pointer awayTeam "+menuOffCss+"\" height=\"32\" id=\"chk_"+this.wr_id+"_2\">"+
				"		<tr> "+
				"		<td width=\"6\">&nbsp;</td>"+
				"		<td width=\"40\"  style='text-align:left;'>"+this.wr_2+"</td>"+
				"		<td align=\"right\" class=\"bet1 "+css_under+"\">"+away_name[0]+"</td>"+
				"		<td width=\"8\">&nbsp;</td>"+
				"		</tr>"+
				"	</table>"+
				"</td>	 "+
				"<td width=\"2\">&nbsp;</td>				"+
				"<td width=\"8%\" align=\"center\" class=\"olive8\">"+state+"</td>"+
				"</tr>"+
				"</table>";
			}
			if (is_end) {
				board_view_txt = board_view_txt + "</div>";
				//if(this.wr_trackback == "1"){
			}
			}
		//}}} 그외 =========================================
		}
		i++;
		
	});
	if(trackback_num == 0) {
		board_view_txt2 =
		"<div class='today_sports'>"+
			"<div class='title_area'>"+
				"<h3>오늘의 경기</h3>"+
				"<h4>Today Match</h4>"+
			"</div>"+
		"</div>"+
		"<div class='today_sports'>"+
			"<div class='title_area'>"+
				"<h3>오늘의 경기</h3>"+
				"<h4>Today Match</h4>"+
			"</div>"+
		"</div>";
	}
	bonus_cnt_arr  = bonus_cnt_arr.filter(function(item) {
  		return item !== null && item !== undefined && item !== '';
	});
	var bonus_cnt = bonus_cnt_arr.length;
	var bonus_width = 100/bonus_cnt;
	
	board_view_txt = board_view_txt + "<style>.ko_sports_game .bonus_ul{width:"+bonus_width.toFixed(2)+"%;display:inline-block;margin:0;}.ko_sports_game .bonus_div{width:99%;}</style>";

	// 화면 UI 업데이트 여부 체크 (hong)
	if( VarBoTable != table ){
		return;
	}


	$j("#board_list").empty();
	$j("#board_list2").empty();

	board_view_txt = board_view_txt + "</td></tr><tr> <td></td><td height=\"13\"></td></tr>";

	$j("#board_list").append(board_view_txt);
	$j("#board_list2").append(board_view_txt2);

	if( VarSca != "" ) VarSca = "["+VarSca+"]";

	if( i == 0 ) 
		$j("#board_list").append("<tr id=\"num_"+this.wr_id+"\" height=\"28\" align=\"center\" class=\"list"+bg_num+"\">"+
			"<td colspan=\"10\" height='148'><font color=\"#1cfe3e\"><b>"+VarSca+"</b></font> <font color=\"#fff\">등록된 경기가 없습니다.</font></td>"+
			"</tr><tr><td colspan=\"10\"></td></tr>");


}
/**
 * 기능 : 종목 리스트 표시
 * @param data  : 게임 리스트
 */
function display_leaguelist(list){
	get_jongmok_list(list);
}
function display_leaguelist2(list){
	get_jongmok_list2(list);
}
function get_jongmok_list(list) {
    $j.ajax({
    	url: "/ajax.jongmok_list.php",
    	type: 'POST',
    	dataType: 'json',
    	success: function(jongmoks) {
			draw_jongmok_list(list, jongmoks);
		},
		fail: function(){
			return;
		}
	});
}
function get_jongmok_list2(list) {
    $j.ajax({
    	url: "/ajax.jongmok_list.php",
    	type: 'POST',
    	dataType: 'json',
    	success: function(jongmoks) {
			draw_jongmok_list2(list, jongmoks);
		},
		fail: function(){
			return;
		}
	});
}
function draw_jongmok_list(list, jongmoks) {
	
	var j_arr = {};
	for (var i=0; i<jongmoks.length; i++) {
		j_arr[jongmoks[i]] = {name : jongmoks[i], icon : '', data : []};
	}
	j_arr['etc'] = {name : jongmoks[i], icon : '', data : []};

	var row			= null;
	var item		= null;
	var j_key		= '';
	var icon		= '';
	var bn_id		= '';
	var league		= '';
	var league_img	= '';
	
	for (i=0; i<list.length; i++) {
		row = list[i];
		if (row != null) {
			icon		= row.icon;
			league		= row.league;
			league_img	= row.league_img;
			bn_id		= row.bn_id;
			
			item = { 'league' : league, 'league_img' : league_img, 'bn_id' : bn_id, 'league_cnt' : 1 };
			
			j_key = get_jongmok_key(j_arr, row.bn_url);
			j_arr[j_key].icon = icon;
			j_arr[j_key].data.push(item);
		}
	}
	$j.each(j_arr, function(k, v) {
		j_arr[k].data = filter_league_data(j_arr[k].data);
		add_league_table(k, j_arr[k]);
	});
}
function draw_jongmok_list2(list, jongmoks) {
	
	var j_arr = {};
	for (var i=0; i<jongmoks.length; i++) {
		j_arr[jongmoks[i]] = {name : jongmoks[i], icon : '', data : []};
	}
	j_arr['etc'] = {name : jongmoks[i], icon : '', data : []};

	var row			= null;
	var item		= null;
	var j_key		= '';
	var icon		= '';
	var bn_id		= '';
	var league		= '';
	var league_img	= '';
	
	for (i=0; i<list.length; i++) {
		row = list[i];
		if (row != null) {
			icon		= row.icon;
			league		= row.league;
			league_img	= row.league_img;
			bn_id		= row.bn_id;
			
			item = { 'league' : league, 'league_img' : league_img, 'bn_id' : bn_id, 'league_cnt' : 1 };
			
			j_key = get_jongmok_key(j_arr, row.bn_url);
			j_arr[j_key].icon = icon;
			j_arr[j_key].data.push(item);
		}
	}
	$j.each(j_arr, function(k, v) {
		j_arr[k].data = filter_league_data(j_arr[k].data);
		add_league_table2(k, j_arr[k]);
	});
}
function get_jongmok_key(json_arr, key) {
	if(json_arr.hasOwnProperty(key)){
		return key;
	}
	return 'etc';
}
// jongmok 에서 중복된 값을 뺀 array 를 위한 함수
function filter_league_data(data) {
	var comp_data = data;
	var out_data = [];
	var ielem = '';
	var jelem = '';
	var cnt = 0;
	var i = 0;
	var j = 0;
	
	for (i=0; i<comp_data.length; i++) {
		
		ielem	= comp_data[i];
		cnt		= 1;
		
		if (ielem == null)
			continue;
		
		for (j=i+1; j<comp_data.length; j++) {
			jelem = comp_data[j];
			if (jelem == null)
				continue;
			
			if (ielem.league == jelem.league) {
				cnt++;
				comp_data[i].league_cnt = cnt;
				comp_data[j] = null;
			}
		}
	}
	
	for (i=0; i<comp_data.length; i++) {
		if (comp_data[i] != null) {
			out_data.push(comp_data[i]);
		}
	}
	
	return out_data;
}

// 스포츠게임 좌측 테이블에 종목들 그려주기
function add_league_table(jongmok, league) {
	var icon = league.icon;
	var data = league.data;
	
	var title_style		= 'cursor:pointer;height:30px;color:#34fc67;padding-left:15px;font-size:14px;';
	var list_style		= 'color:#fff;font-size:12px;padding-left:25px;';
	var ellipsis_style	= 'text-overflow:ellipsis; white-space:nowrap; overflow:hidden;';

	if (data.length <= 0) return;
	
	var all_jongmok = [];
	for (var i=0; i<data.length; i++) {
		all_jongmok.push(data[i].bn_id);
	}
	
	var click_title		= "click_league2('" + all_jongmok.toString() + "')";
	
	/*$j('#sports_league_table > tbody:last').append("<tr><td class='click_title' style='"+title_style+"' onclick=\""+click_title+"\"><img src='" + league.icon +"' style='margin-top:5px;'>&nbsp;&nbsp;<span style='display:inline-block;vertical-align:top;line-height:30px;'>" + jongmok + "</span><div class='num_league'>" + data.length + "</div></td></tr>");*/

//	$j('#sports_league_ul').append("<li onclick=\""+click_title+"\"><img src='"+league.icon+"' alt='ico' /> <span class='name'>"+jongmok+"</span><span class='count on'>"+data.length+"</span></li>")

	if(jongmok == "축구") class_name = "soc";
	else if(jongmok == "농구") class_name = "bask";
	else if(jongmok == "야구") class_name = "base";
	else if(jongmok == "아이스하키" || jongmok == "하키") class_name = "hock";
	else if(jongmok == "테니스") class_name = "tenn";
	else if(jongmok == "핸드볼") class_name = "hand";
	else if(jongmok == "모터스포츠") class_name = "motor";
	else if(jongmok == "럭비") class_name = "rub";
	else if(jongmok == "크리켓") class_name = "cri";
	else if(jongmok == "다트") class_name = "dart";
	else if(jongmok == "배구") class_name = "val";
	else if(jongmok == "풋살") class_name = "foot";
	else if(jongmok == "배드민턴") class_name = "ton";
	else if(jongmok == "이스포츠") class_name = "espo";
	else class_name = "etc";

	//$j('#sports_league_ul').append("<li onclick=\""+click_title+"\"><img src='"+league.icon+"' alt='ico' /> <span class='name'>"+jongmok+"</span><span class='count on'>"+data.length+"</span></li>")
	$j('.sports_league_ul span.'+class_name).text(data.length).addClass("on");
	$j('.sports_league_ul>li.'+class_name).attr("onClick",click_title);

	var league = '';
	var click_content = '';
	for (i=0; i<data.length; i++) {

		click_content	= "click_league('" + data[i].bn_id + "')";
		league  =
			"<div style='cursor:pointer;width:250px;margin-bottom:10px;"+ellipsis_style+"' onclick=\""+click_content+"\">" +
				"<img width='27' height='18' src='" + data[i].league_img + "' onerror=\"this.src='/10bet/images/logo.png'\" align=absmiddle>" + 
				"&nbsp;&nbsp;" + data[i].league + " ( " + data[i].league_cnt + " )";
			"</div>";
	$j('#sports_league_table > tbody:last').append("<tr class='left_display_none league_"+data[i].bn_id+"'><td style='"+list_style+"'>" + league + "</td></tr>");
	}
	//$j('#sports_league_table > tbody:last').append("<tr><td style='"+list_style+"'></td></tr>");
}
// 스포츠게임 좌측 테이블에 종목들 그려주기
function add_league_table2(jongmok, league) {
	var icon = league.icon;
	var data = league.data;
	
	var title_style		= 'cursor:pointer;height:30px;color:#34fc67;padding-left:15px;font-size:14px;';
	var list_style		= 'color:#fff;font-size:12px;padding-left:25px;';
	var ellipsis_style	= 'text-overflow:ellipsis; white-space:nowrap; overflow:hidden;';

	if (data.length <= 0) return;
	
	var all_jongmok = [];
	for (var i=0; i<data.length; i++) {
		all_jongmok.push(data[i].bn_id);
	}
	
	var click_title		= "click_league2('" + all_jongmok.toString() + "')";
	
	/*$j('#sports_league_table > tbody:last').append("<tr><td class='click_title' style='"+title_style+"' onclick=\""+click_title+"\"><img src='" + league.icon +"' style='margin-top:5px;'>&nbsp;&nbsp;<span style='display:inline-block;vertical-align:top;line-height:30px;'>" + jongmok + "</span><div class='num_league'>" + data.length + "</div></td></tr>");*/

	if(jongmok == "축구") class_name = "soc";
	else if(jongmok == "농구") class_name = "bask";
	else if(jongmok == "야구") class_name = "base";
	else if(jongmok == "아이스하키" || jongmok == "하키") class_name = "hock";
	else if(jongmok == "테니스") class_name = "tenn";
	else if(jongmok == "핸드볼") class_name = "hand";
	else if(jongmok == "모터스포츠") class_name = "motor";
	else if(jongmok == "럭비") class_name = "rub";
	else if(jongmok == "크리켓") class_name = "cri";
	else if(jongmok == "다트") class_name = "dart";
	else if(jongmok == "배구") class_name = "val";
	else if(jongmok == "풋살") class_name = "foot";
	else if(jongmok == "배드민턴") class_name = "ton";
	else if(jongmok == "이스포츠") class_name = "espo";
	else class_name = "etc";

	//$j('#sports_league_ul').append("<li onclick=\""+click_title+"\"><img src='"+league.icon+"' alt='ico' /> <span class='name'>"+jongmok+"</span><span class='count on'>"+data.length+"</span></li>")
	$j('.inplay_league_ul span.'+class_name).text(data.length).addClass("on");
	$j('.inplay_league_ul>li.'+class_name).attr("onClick",click_title);

	var league = '';
	var click_content = '';
	for (i=0; i<data.length; i++) {

		click_content	= "click_league('" + data[i].bn_id + "')";
		league  =
			"<div style='cursor:pointer;width:250px;margin-bottom:10px;"+ellipsis_style+"' onclick=\""+click_content+"\">" +
				"<img width='27' height='18' src='" + data[i].league_img + "' onerror=\"this.src='/10bet/images/logo.png'\" align=absmiddle>" + 
				"&nbsp;&nbsp;" + data[i].league + " ( " + data[i].league_cnt + " )";
			"</div>";
	$j('#sports_league_table > tbody:last').append("<tr class='left_display_none league_"+data[i].bn_id+"'><td style='"+list_style+"'>" + league + "</td></tr>");
	}
	//$j('#sports_league_table > tbody:last').append("<tr><td style='"+list_style+"'></td></tr>");
}
function click_league(bn_ids) {
	var arr = bn_ids.split(',');
	// j_[NUM]_t CLASS
	
	$j("[class^=j_][class$=_t]").each(function (i, el) {
		$j(this).addClass('display_none');
	});
	/*$j("[class^=league_]").each(function (i, el) {
		$j(this).addClass('left_display_none');
	});*/
	var cls = '';
	for (var i=0; i<arr.length; i++) {
		cls = 'j_' + arr[i] + '_t';
		cls2 = arr[i];
		$j("."+cls).removeClass('display_none');
		$j(".league_"+cls2).removeClass('left_display_none');
	}
}
function click_league2(bn_ids) {
	var arr = bn_ids.split(',');
	// j_[NUM]_t CLASS
	
	/*$j("[class^=j_][class$=_t]").each(function (i, el) {
		$j(this).addClass('display_none');
	});*/
	/*$j("[class^=league_]").each(function (i, el) {
		$j(this).addClass('left_display_none');
	});*/
	$j(".ko_sports_game").each(function (i, el) {
		$j(this).addClass('display_none');
		$j('.bonus_div').removeClass('display_none');
	});
	var cls = '';
	for (var i=0; i<arr.length; i++) {
		cls = 'j_' + arr[i] + '_t';
		$j("."+cls).removeClass('display_none');
		cls2 = arr[i];
		//$j("."+cls).removeClass('display_none');
		$j(".league_"+cls2).removeClass('left_display_none');
	}
}
function show_all_league() {
	$j(".display_none").each(function (i, el) {
		$j(this).removeClass('display_none');
	});
}
// 최대배팅금액
function cart_max_input(){
	// 배당률 체크
    var betstr = bet._bet;
    if (betstr.toFixed) {
        betstr = betstr.toFixed(2);
    }
	if(!betstr) {
		return;
	}

	// 최대당첨금을 받기위한 배팅금액 계산
	max_amount = parseInt(eval("VarMaxAmount"));
	price = parseInt(max_amount / betstr);

	// 최대배팅액체크
	max_bet = parseInt(eval("VarMaxBet"));
	if( price > max_bet ) price=max_bet;

	// 보유금액체크
	if( price > VarMoney ) price=VarMoney;

	$j("#betprice").val(MoneyFormat(price));
	$j("#betprice2").text(MoneyFormat(price));
	calc()
}
//
function cart_money_input(money){
	var cart_money_mode='betprice';
	var price = $j('#'+cart_money_mode).val();
	price = price.replace(/,/g,'');
	$j("#betpoint").val("");
	$j("#betprice").val("");
	$j("#betprice2").text("0");

	$j("#"+cart_money_mode).val(MoneyFormat(price*1+money));
	$j("#"+cart_money_mode+"2").text(MoneyFormat(price*1+money));
	calc()
}
function cart_money_clear(){
	var cart_money_mode='betprice';
	var price = $j('#'+cart_money_mode).val();
	price = price.replace(/,/g,'');
	$j("#betpoint").val("");
	$j("#betprice").val("");
	$j("#betprice2").text("0");

	$j("#"+cart_money_mode).val(0);
	calc()
}

function cart_input_set(id){
	cart_money_mode = id;
}
function cart_del_all() {
	if ($j("#betprice").length > 0) {
		$j("#betprice").val('');
		$j("#betprice2").text('0');
		del_all();
	}
}
// 
function cart_input(el, event) {
	if(event.keyCode>40 || event.keyCode<33){
		if( el.id=='betprice' ) $j("#betpoint").val("");
		else { $j("#betprice").val("");$j("#betprice2").text("0"); }
		el.value=MoneyFormat(el.value);
		calc()
	}
}
// 엑셀 스타일의 반올림 함수 정의
function roundXL(n, digits) {
	return parseFloat(math.round(parseFloat(n), digits));
/*
  if (digits >= 0) return parseFloat(n.toFixed(digits)); // 소수부 반올림

  digits = Math.pow(10, digits); // 정수부 반올림
  var t = Math.round(n * digits) / digits;

  return parseFloat(t.toFixed(0));
*/
}
// onmouseover="highlight(this,true)" onmouseout="highlight(this,false)"
function highlight(obj, isHover)
{
	if(obj.className.indexOf("menuOff_magam")!=-1) return;

	if(obj.className.indexOf("on")!=-1) return;
	if(isHover) {
		$j(obj).addClass("menuOff_hover").removeClass("menuOff");
	}
	else {
		$j(obj).addClass("menuOff").removeClass("menuOff_hover");
	}

}

function showAndHideElemId(e, eid) {
	var d = $j('#'+eid).css('display');
	if (d == 'none'){   d = '';     $j(e).val('접기');	}
	else            {   d = 'none'; $j(e).val($j('#hidden_'+eid).val());}
	$j('#'+eid).css('display', d);
}

// chk_ratios
var i_timeout = null;
var c_list = null;
var c_timeout = null;
var current_time = null;
function chk_ratios() {
	ajax_chk_ratios();
    var itimer = 3000;
	if (VarBoTable=='a25') itimer = 1000;
    if (i_timeout != null) clearTimeout(i_timeout);
    i_timeout = setTimeout(function() {
        chk_ratios();
    }, itimer);
}
function ajax_chk_ratios() {
	if (current_time == null) {
		current_time = clock.time_str;
		return;
	}
	var t = current_time;

	$j.ajax({
		url: "/ajax.chk_ratios.php",
		type: 'POST',
		dataType: 'json',
		data: {bo_table : VarBoTable, t : t},
		success: function(data) {
			current_time = clock.time_str;
			c_list = null;
			c_list = [];
			if (!data) return;
			if (data.length <= 0) return;
			var row	= null;
			var d	= null;
			var ud	= null;
			var img_src = "";
			var selected_items = [];
			for (var i=0; i<data.length; i++) {
				row	= data[i];
				d	= tmpObj[VarBoTable][row.wr_id];
				if (d != null && d != undefined) {
					var is_exists = false;
					for (var j=0; j<c_list.length; j++) {
						if (c_list[j] == row.wr_id) {
							is_exists = true;
							break;
						}
					}
					if (!is_exists) c_list.push(row.wr_id);
					
					var selected_item = null;
					for (var k=1; k<=3; k++) {
						if (row["wr_" + k] != d["wr_" + k]) {
						if (parseFloat(row["wr_" + k]) != parseFloat(d["wr_" + k])) {
							ud = "up";
							if (row["wr_" + k] < d["wr_" + k]) {
								ud = "down";
							}
							img_src = "/10bet/images/arrow_" + ud + "_ani.gif";
							d["wr_"+k] = row["wr_" + k];
							$j("#chk_"+row.wr_id+"_"+k + " .rtext").html(row["wr_"+k]);
							$j("#chk_"+row.wr_id+"_"+k + " .rimg > img").remove();
							$j("#chk_"+row.wr_id+"_"+k + " .rimg").append("<img src='/10bet"+img_src+"' width='10'>");
							
							tmpObj[VarBoTable][row.wr_id]["wr_"+k] = row["wr_"+k];

							for(var l=0; l<bet._items.length; l++) {
								if (bet._items[l].wr_id == row.wr_id && bet._items[l].betteam == k) {
									selected_item = bet._items[l];
									selected_item["bet"+k] = row["wr_"+k];
									selected_item.ratio = row["wr_"+k];
								}
							}
						}
						}
					}
					if (selected_item != null) {
						selected_items.push(selected_item);
					}
				}
			}
			if (selected_items.length > 0) {
				for (var i=0; i<selected_items.length; i++) {
					bet.addItem(selected_items[i]);
				}
				calc(VarBoTable);
			}
			// 2초 후 원복
			chk_restoration();
		},
		error: function() {
		},
		timeout: 3000
	});
}
