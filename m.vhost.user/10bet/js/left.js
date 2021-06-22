function EventbetCheck(frm,i) {
	frm.betting.value = i.value;
}
function AlertEvent(str) {
	alert(str);
	return false;
}
function EventbetSubmit(frm,minbet,maxbet) {
	if (frm.betting.value == '') {
		alert('�����׸��� �����Ͻʽÿ�');
		return false;
	}
	var strprice = frm.eventprice.value;
	strprice = strprice.replace(/,/gi, '');
	intprice = parseInt(strprice);
	if(intprice < minbet || intprice > maxbet) {
		alert("���þ��� "+minbet+"~"+maxbet+"�� �����Դϴ�.");
		return false;
	}

	if(intprice > 0)
	{
		alert("���ñݾ��� �����ӴϺ��� Ŭ �� �����ϴ�.");
		return false;
	}

	var pricecheck = parseInt(intprice / 10000);
	pricecheck = pricecheck * 10000;

	if (pricecheck != parseInt(intprice))
	{
		alert("�ݾ��� ���������� �Է��Ͻʽÿ�.");
		return false;
	}
	return false;
}


var itemstr = '';
/*
itemstr += '<table border="0" cellpadding="0" cellspacing="0" width="233"  style="table-layout:fixed;">\n';
itemstr += '  <tr>\n';
itemstr += '    <td style="font-size:11px;letter-spacing:-1; color;#fff000" width="165">$team1</td>\n';
itemstr += '    <td align="right" style="font-size:11px;color:#ffffff">[$betteam] $ratio  <a href="javascript:del_bet($wr_id)"><img src="/images/x.gif" align="absmiddle"></a></td>\n';
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
itemstr += '               <td align="right"><a href="javascript:del_bet($wr_id)"><img src="/images/x.png?z" border="0"></a></td>\n';
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
itemstr += '<h4>$betteam<span class="del"><img src="/images/10bet/ico_del_01.png" alt="����" onClick="del_bet($wr_id);"></span></h4>\n';
itemstr += '<div class="result">$team1 <span>$ratio</span></div>\n';
itemstr += '</li>\n';


Array.prototype.remove = function(from, to) {
	var rest = this.slice((to || from)+1 || this.length);
	this.length = from<0 ? this.length+from : from;
	return this.push.apply(this, rest);
}
var returntext = "";
function check_bet(obj, id) {
	obj = tmpObj[VarBoTable][obj]; 
	var num = obj.wr_id;	 // ����ȣ
	var gametime = obj.wr_6;

	// ������
	if( obj.wr_reply=="1" ) {
		alert("�����¿��� �����ϽǼ� �����ϴ�");
		return;
	}

	a_infos = gametime.split(" ");
	a_date = a_infos[0].split("-");
	a_time = a_infos[1].split(":");

	var gamedatetime = new Date(a_date[0],a_date[1]-1,a_date[2],a_time[0],a_time[1],a_time[2]);
	if( clock.time > gamedatetime && !g4_is_admin ) alert("���ð����� �ð��� �������ϴ�!");
	else{
		add_bet(obj, id);
	}
}

//==============================================
// ��ü ��Ģ
//==============================================
function is_duplicated(src,id){
	// �¹���, �ڵ�ĸ�ΰ�츸 �ߺ�����üũ
	if( src.bo_table!='a10' ) return false;

	var err_msg = {
		'win_handy':	'�¹���,�ڵ�ĸ ���պҰ��մϴ�',
		'win_over':	'�¹���,������� ���պҰ��մϴ�',
		'win_mu_over':	'��,������� ���պҰ��մϴ�',
		'inning1':		'1�̴� ����/������ �� ��������� ���պҰ��մϴ�',
		'bonus':		'���ʽ��������� ���պҰ��մϴ�'
	};

	for(i=0; i<bet._items.length; i++){

		// ùȨ���� ��ι��δ�.
		if( src.wr_4.indexOf("ùȨ��")!=-1 || bet._items[i].team1.indexOf("ùȨ��")!=-1  ) continue;

		// ���ʽ��������� ������ ����.
		if( src.wr_4.indexOf("����")!=-1 && bet._items[i].team1.indexOf("����")!=-1 ) return err_msg['bonus'];

		// ���������϶�
		if(bet._items[i].group_id == src.group_id && bet._items[i].wr_id!=src.wr_id ) {
			var a = src.wr_7;
			var a1 = id;
			var b = bet._items[i].gametype;
			var b1 = bet._items[i].betteam;

			// 1�̴� ��/���� + ������� ���վȵ�
			if( ( bet._items[i].team1.indexOf("1�̴�")!=-1 && bet._items[i].team1.indexOf("����")!=-1 ) ||
			    ( src.wr_4.indexOf("1�̴�")!=-1 && src.wr_4.indexOf("����")!=-1 ) )
			{
				if(a=="�¹���" && b=="�������") return err_msg['inning1'];
				if(b=="�¹���" && a=="�������") return err_msg['inning1'];
			}

			// �¹���-�ڵ�ĸ �ߺ�X
			if(a=="�¹���" && b=="�ڵ�ĸ") return err_msg['win_handy']; 
			if(b=="�¹���" && a=="�ڵ�ĸ") return err_msg['win_handy'];
			// �¹���(������)-����� �ߺ�X
			//if(a=="�¹���" && b=="�������") return err_msg['win_over'];
			//if(b=="�¹���" && a=="�������") return err_msg['win_over'];
            // �¹���(������)-����� �ߺ�X 
            if(a=="�¹���" && a1==3 && b=="�������") return err_msg['win_mu_over'];
            if(b=="�¹���" && b1==3 && a=="�������") return err_msg['win_mu_over'];
		}
	}

	return;
}

//==============================================
// ��ٸ� ��Ģ
//==============================================
function is_duplicated_ladder(src,id){
	if( src.bo_table!='a40' ) return false;

	var err_msg = {
		'ladder1':	'�ٸ�ȸ�������� ���պҰ��մϴ�',
		'ladder2': '����/����� 3��/4�� ���� ���պҰ��մϴ�'
	};
	for(i=0; i<bet._items.length; i++){
		var a = src.wr_subject;
		var b = bet._items[i].wr_subject;

		var alist = a.split("-");
		var blist = b.split("-");

		// �ٸ�ȸ���� ���վȵ�
		if( alist[1]!=blist[1] ) return err_msg['ladder1'];

		// ��,���� ���վȵ�
		if( (alist[2]=='line' && blist[2]=='start') ||
		    (alist[2]=='start' && blist[2]=='line')
		) 
		return err_msg['ladder2'];
	}

	return;
}


function add_bet(src, id){
	var gametype =  src.wr_7;
	// �����,�ڵ�ĸ������ ���� ���ø��Ѵ�
	if( gametype!="�¹���" && id==3 ) return;
	// �¹��� ������� ���°�� ���� ���ø��Ѵ�.
	if( gametype=="�¹���" && id==3 && ( isNaN(src.wr_3) || src.wr_3<1 ) ) return; // �����
	// ���ñ��� ���
	if( id==1 && (typeof(src.wr_1)=="undefined" ||src.wr_1==0) ) { alert('�ش����� ������ �����Ǿ����ϴ�'); return; }
	if( id==2 && (typeof(src.wr_2)=="undefined" ||src.wr_2==0) ) { alert('�ش����� ������ �����Ǿ����ϴ�'); return; }
	if( id==3 && (typeof(src.wr_3)=="undefined" ||src.wr_3==0) ) { alert('�ش����� ������ �����Ǿ����ϴ�'); return; }

	var num = src.wr_id;	 // ����ȣ
	var ongametime = src.wr_6;	 // ���ӽ��۽ð�
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

	if( gametype == "�ڵ�ĸ" ) var bet3 =  src.wr_8.replace(",", "");

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
	//�ߺ��� ���ð��� ������ ��������
	if( ( betArr.length > VarMaxCount && is_new_id == "-1" ) || is_new != "-1" ){
		if( is_new == "-1" ) alert("���հ����� �������� "+VarMaxCount+"���� �Դϴ�.");
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
			alert(err_msg);
			return;
		}
		*/
		err_msg = is_duplicated_ladder(src,id);
		if( err_msg ){
			alert(err_msg);
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
		bet.addItem(item);
		var isdisabled = true;
		var ecnt = 4;// ��� ���� �����Ҽ��ִ�.
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
			// TODO ; ��Ű����..
			if( errmsg ) {
				alert(errmsg);
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
		$j(item_no+" .homeTeam").removeClass("on");
		$j(item_no+" .bet").removeClass("on");
		$j(item_no+" .awayTeam").removeClass("on");
		$j(item_no+" .muSelect").removeClass("on");
		$j(item_no+" .homeTeam").addClass("menuOff");
		$j(item_no+" .bet").addClass("menuOff");
		$j(item_no+" .awayTeam").addClass("menuOff");
		$j(item_no+" .muSelect").addClass("menuOff");

	}

	this._items = new Array();
	//var tb = getObject("tb_list");
	/*while (tb.rows.length>0) {
		tb.deleteRow(0);
	}*/
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
	var tr = tb.insertRow(tb.rowIndex);
	tr.id = "tb_row_"+item.wr_id;
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
	var gametype = item.gametype;
	var betteam_str = "";
	var str1 = str2 = str3 = "";

	str1 = '��';
	str2 = '��';
	if( gametype=='�������' ) {
		str1='����';
		str2='���';
	}

	if (item.betteam == "1") {
		betteam_str = "<font color=''>"+str1+"</font>";
		item.team1 = ""+item.team1+"";
	} else if (item.betteam == "2") {
		betteam_str = "<font color=''>"+str2+"</font>";
		item.team2 = ""+item.team2+"";
	} else if (item.betteam == "3") {
		betteam_str = "<font color=''>"+(str3 || "��")+"</font>";
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

// ���ӹ��ù���
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
			// TODO ; ��Ű����..
			if( errmsg ) {
				alert(errmsg);
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
		alert("������ "+VarMinBettingCount+"���� �̻���� �����մϴ�.");
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
		alert("������ ��⸦ �����Ͻʽÿ�.");
		return;
	}
	if (bet._totalprice == 0 ) {
		alert("���þ��� �Է��ϼž� �մϴ�");
		return;
	}
	///////////////////////////////////////////////////
	// ����üũ
	if( VarMaxRatio && VarMaxRatio>0 && (bet._bet - VarMaxRatio)>0 ){
		alert("�ִ���� ("+VarMaxRatio+") �� �ʰ��Ͽ����ϴ�");
		return;
	}

	///////////////////////////////////////////////////
	// �����ݾ� üũ
	if(bet._price>0){
		if (bet._price > VarMoney) {
			alert("���ñݾ��� �����ӴϺ��� Ŭ �� �����ϴ�.");
			return;
		}
	}else{
		if (bet._point > VarPoint) {
			alert("��������Ʈ�� ��������Ʈ���� Ŭ �� �����ϴ�.");
			return;
		}
	}

	///////////////////////////////////////////////////
	// �������ΰ��
	if( bet._items.length == 1) {
		max_bet = max_bet2;
		max_amount = max_amount2;
	}

	
	// �����ѵ� üũ
	bet_price = bet._point + bet._price;	
	if (bet_price<min_bet || bet_price>max_bet) {
		if( bet._items.length == 1) {
			alert("������ ���þ��� "+MoneyFormat(min_bet)+"~"+MoneyFormat(max_bet)+"�� �����Դϴ�.");
			return;
		}
		else {
			alert("���þ��� "+MoneyFormat(min_bet)+"~"+MoneyFormat(max_bet)+"�� �����Դϴ�.");
			return;
		}
	}
	if (bet._totalprice>max_amount) {
		if( bet._items.length == 1) {
			alert("������ �ִ����߱��� "+MoneyFormat(max_amount)+"�� ���� �� �����ϴ�.");
		}else{
			alert("�ִ����߱��� "+MoneyFormat(max_amount)+"�� ���� �� �����ϴ�.");
		}
		return;
	}
	///////////////////////////////////////////////////
	// �������� üũ
	if (bet._items.length > max_betting_count) {
		alert("�ִ� "+max_betting_count+" ���� ���ϸ� ������ �����մϴ�.");
		return;
	}

	betForm.mode.value = type;

	var msg = "";
	// ��������϶� ��� �޼���
	if( bet._items.length == 1 && VarBoTable<='a50' && VarDanpolDown>0 ) msg += "�������ý� "+VarDanpolDown+"�� ����϶��� �߻��մϴ�\n";
	msg += "���ó����� Ȯ�� �Ͻð� ��ġ�ϸ� [Ȯ��] ��ư�� Ŭ�� �� �ּ���. \n�ѹ� �����ϸ� ��Ұ� �Ұ����մϴ�";
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

			//ȭ��� ��ü�� �ִ��� Ȯ���Ѵ�.
			if( typeof(tmpZ[wr_id]) != "undefined" && tmpZ[wr_id].wr_is_comment == "0" ) {
				var betteam = bettingCart[y][1];
				var src = tmpZ[wr_id];
				var sp = VarSpBet;
				var gametime = src.wr_6;
				var homescore = src.wr_9;
				var awayscore = src.wr_10;
				var message = "";
				var bet3 = src.wr_3;
				if( gametype == "�ڵ�ĸ" ){
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

				}//�ð��� ���ϰ� ���ð��� ������ ��Ű����� �����Ѵ�.
			}else{
				del_bet(wr_id);
			}// ��ü ������ 
		}//�ݺ�����
		calc(table);
	}
}


// ���Ӻ� ���� ����
function init(path) {
	loading = true;
	var table_list = null;

	del_all_cookies();

	// �������� ����������� json ������ �д´� : gamelistall.php
	$j.getJSON(path, {"sca":VarCaId, "bo_table":VarBoTable},function(data,textStatus){
		//bet.ClearAll();
		table = VarBoTable;
		// ���Ӹ���Ʈ �׸��� and tmpObj ���� ������Ʈ
		//display_gamelist(data,table);
		
		// ���������� ���񸮽�Ʈ �׸���
		if (table=='a10' || table=='a30' || table=='a50') {
			display_leaguelist(data);
		}
		else if (table=='a25') {
			display_leaguelist2(data);
		}

		// ��ٱ��� ǥ��
		//BetContentLoad(table);
		loading = false;

	});
}
// ���Ӻ� ���� ����
function init2(path) {
	loading = true;
	var table_list = null;

	del_all_cookies();

	// �������� ����������� json ������ �д´� : gamelistall.php
	$j.getJSON(path, {"sca":VarCaId, "bo_table":VarBoTable2},function(data,textStatus){
		//bet.ClearAll();
		table = VarBoTable2;
		// ���Ӹ���Ʈ �׸��� and tmpObj ���� ������Ʈ
		//display_gamelist(data,table);
		
		// ���������� ���񸮽�Ʈ �׸���
		if (table=='a10' || table=='a30' || table=='a50') {
			display_leaguelist(data);
		}
		else if (table=='a25') {
			display_leaguelist2(data);
		}

		// ��ٱ��� ǥ��
		//BetContentLoad(table);
		loading = false;

	});
}
/**
 * ��� : tmpObj ���� ������Ʈ, ���Ӹ�� ǥ��
 * @param data	: ���� ����Ʈ
 * @param table	: a10, a20, ..
 */
function display_gamelist(data,table){
	var i = 0;
	var bonus_cnt_arr = new Array();
	var bg_num = 0;
	ca_names = "";
	var ca_name_str ="";
	var team_width = "190";
	var is_ca_name_b = "";
	var board_view_txt = "";	
	var listbackGround  = "";
	var tmp_group_cnt = 0;
	var is_multi_mode = 0;
	if (VarBoTable == 'a10') {
		is_multi_mode = 0;
	}

	//var tmpZ = tmpObj[table] = {};

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

		this.bo_table = table; // �Խ��� ���̺����� �߰�

		bg_num = i % 2;
		if( this.wr_type!='notice' ){
		//=={{ notice �ƴҶ��� ���� ���� ===


		switch(this.wr_7){
			case "�¹���":
				if(isNaN(this.wr_3) || this.wr_3<1) this.handy = 'VS'; //�����
				else this.handy = this.wr_3;

				if( VarBoTable=='a90' ){
					if( this.wr_subject.indexOf('-cross')==-1 && this.wr_subject.indexOf('-order')==-1 ){
						this.handy = "<font color='skyblue'>[��]</font> "+this.handy;
						this.wr_4 = this.wr_4.replace("[��]","<font color='red'>[��]</font>");
						this.wr_5 = this.wr_5.replace("[��]","<font color='lime'>[��]</font>");
					}else{
						this.wr_4 = this.wr_4.replace("[��]","<font color='red'>[��]</font>");
						this.wr_4 = this.wr_4.replace("[��]","<font color='skyblue'>[��]</font>");
						this.wr_4 = this.wr_4.replace("[��]","<font color='lime'>[��]</font>");
						this.wr_4 = this.wr_4.replace("����","<font color='yellow'>����</font>");

						this.wr_5 = this.wr_5.replace("[��]","<font color='red'>[��]</font>");
						this.wr_5 = this.wr_5.replace("[��]","<font color='skyblue'>[��]</font>");
						this.wr_5 = this.wr_5.replace("[��]","<font color='lime'>[��]</font>");
						this.wr_5 = this.wr_5.replace("����","<font color='yellow'>����</font>");

						// �����ϴ�
						if( this.wr_subject.indexOf('-cross')!=-1 ){
							this.handy = "<font color='skyblue'>[��]</font><font color='lime'>[��]</font> " + this.handy;
						}

					}
				}
				break;
			case "�ڵ�ĸ":
				this.handy = list_wr_8[0];

				switch (this.handy_option)
				{
					case "1":
					this.handy = this.handy+ "<span style=\"font-size:14pt;\">��</span>";
					break;
					case "2":
					this.handy =  this.handy+"<span style=\"font-size:14pt;\">��</span>";
					break;
					case "3":
					this.handy =  this.handy+"<span style=\"font-size:14pt;\">��</span>";
					break;
				}

				if(isNaN(this.handy) || this.handy==0) this.handy='VS';
				else this.handy = "<font color=''>"+this.handy+"</font>";

				break;
			case "�������":
				css_over = "bet_over_2";
				css_under = "bet_under_2";
				this.handy = "<font color=''>"+this.wr_3+"</font>";
				this.wr_4 = this.wr_4+"";
				this.wr_5 = this.wr_5+"";
				break;
		}

		// �Ŀ��� ó��
		if( VarBoTable=='a60' ){
			var arr = this.wr_subject.split('-');
			switch(arr[2]){
			case "n1":
			case "2": // �Ϲݺ��� Ȧ/¦
				break;

			case "n2":
			case "3": // �Ϲݺ��� ���߼�
				this.handy = "��(65~80) &nbsp;&nbsp;<font color=red>" + this.handy + "</font>";
				break;

			case "p1": 
			case "1": // �Ŀ��� Ȧ/¦
				this.wr_4 = '<img src="/images/powerball_holl.png">';
				this.wr_5 = '<img src="/images/powerball_jjak.png">';
				break;

			case "p2":
			case "4": // �Ŀ��� �������
				this.wr_4 = '<img src="/images/powerball_5over.png">';
				this.wr_5 = '<img src="/images/powerball_4under.png">';
				break;
			}
		}
		// ������ ó��
		if( VarBoTable=='a70' ){
			var arr = this.wr_subject.split('-');
			switch(arr[2]){
			case "low": // ��/����
				this.wr_4 = arr[1]+'ȸ <img src="/images/lowhigh_low.png" align="middle">';
				this.wr_5 = '<img src="/images/lowhigh_high.png" align="middle"> '+ arr[1]+'ȸ';
				break;
			case "odd": // Ȧ/¦
				this.wr_4 = arr[1]+'ȸ <img src="/images/lowhigh_odd.png" align="middle">';
				this.wr_5 = '<img src="/images/lowhigh_even.png" align="middle"> '+ arr[1]+'ȸ';
				break;
			}
		}


		//=={{ notice �ƴҶ��� ���� ���� ===
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

		//��ϵ� ���ӽð��� ����ð����� Ŭ�� ������ ����ó��
		if( gametime  > nowDate ){
			//�ش� ����� ��� ���ھ ������ ǥ���Ѵ�.
			if( this.wr_9 == "" && this.wr_10 == ""  ) {
				//����
				state = "<font color='#1cfe3e' style='display:block;width:45px;'>����</font>";
				if( this.wr_is_comment == "1" || this.wr_reply=="1" ) { // ������
					state = "���";
					is_endgame = true;
					bg_num = 2;
					background_color = "222222";
					chk1 = "";
					chk2 = "";
				}else if( this.wr_is_comment == "2" )	{
					state = "<font color='red' style='display:block;width:45px;'>����</font>";
					is_endgame = true;
					bg_num = 2;
					background_color = "222222";
					chk1 = "";
					chk2 = "";
				}
			}else{
				state = "<font color='red' style='display:block;width:45px;'>����</font>";
				is_endgame = true;
				bg_num = 2;
				background_color = "222222";
				chk1 = "";
				chk2 = "";
			}
		}else{
			state = "<font color='red' style='display:block;width:45px;'>����</font>";
			is_endgame = true;
			bg_num = 2;
			background_color = "222222";
			chk1 = "";
			chk2 = "";
		}

		// �����ڴ� ���� ���� 
		if( g4_is_admin ) {
			is_endgame = false;
        	chk1 = "onClick=\"check_bet("+this.wr_id+", '1')\"";
        	chk2 = "onClick=\"check_bet("+this.wr_id+", '2')\"";
		}


		tmpZ[this.wr_id] = this;

		//�ڵ� �ִ� ����̰� ����� ��Ⱑ �ƴҶ�
		if( this.handy != "" && this.handy != "-" && this.handy != "X" && this.handy != "x" && is_handyClick == true && is_endgame == false){
			chk3 = "onClick=\"check_bet("+this.wr_id+", '3')\"";
		}
		else{
			chk3 = "";
		}

		//������ ������ ���� ǥ��
		if( this.wr_content ) {
			div_content = "<div style='position:absolute'><div id='is_content_"+this.wr_id+"' style='display:none;position:relative;left:-200px; top:-25px; background-color:#000;color:#fff;width:200px;height:100px;padding:5px;border:2px solid #8B2118' onclick=\"view_layer('"+this.wr_id+"', 'none' )\" class=\"content_layer\">"+this.wr_content+"</div></div>";
			is_content_chk = "<span onclick=\"view_layer('"+this.wr_id+"', 'view')\" style='cursor:pointer'>��</span>";
		}else{
			is_content_chk = "";
			div_content = "";
		}

		//�������ϰ�� ���հ������� �߰��Ѵ�.
		if( is_admin )
		{
			if( VarBoTable != "a30" )
			{
				s_mod2 = " class=\"gamedate pointer\" title=\""+this.group_id+" ���հ�����\" onClick=\"window.open('"+g4_path+"/adm/game_all_form.php?w=u&group_id="+this.group_id+"');\" ";
			}else{
				s_mod2 = " class=\"gamedate pointer\" title=\""+this.group_id+" ���հ�����\" onClick=\"window.open('"+g4_path+"/adm/special_all_form.php?w=u&group_id="+this.group_id+"');\" ";
			}
		}else s_mod2 = " class=\"gamedate\" ";

		var home_name = this.wr_4.split(",");
		var away_name = this.wr_5.split(",");

		if( this.wr_7 == "�������" ) {
			//home_name[0] = home_name[0]+"<font color='#ea6e13'>(����)</font>";
			//away_name[0] = "<font color='#2a83ca'>(���)</font>"+away_name[0];
		}
	
		
		//����Ʈ Ÿ���� ���׺� ���� �϶���
		if( VarListViewMode == "1" ) {
			
			xxx = this.ca_name;
			if( VarBoTable=='a40' || VarBoTable=='a60' || VarBoTable=='a70' ||  VarBoTable=='a90' || VarBoTable>'a94' ) {
				rrr = this.wr_subject.split('-');
				xxx = rrr[0]+'-'+rrr[1];
				//this.ca_name += ' '+rrr[1]+'ȸ';
			}
			else{
				xxx = this.ca_name+'|'+this.wr_6;
				// ��365,SKYbet
				if( VarBoTable>='a91' && VarBoTable<='a94' ){
					this.ca_name += " " + this.wr_subject;
				}
			}
			
			if(home_name[0].indexOf("����")!=-1){
				this.ca_name = "";
			}

			if(is_ca_name_b!=xxx && this.wr_type!='notice'){
				if(i>0)board_view_txt = board_view_txt + "</div>";

				var bgtag=''; if( this.icon ) bgtag = " background='" + this.icon +"' ";

				board_view_txt = board_view_txt + "<div class='ko_sports_game j_"+this.bn_id+"_t'>"; 
				if(home_name[0].indexOf("����")!=-1){
				board_view_txt = board_view_txt + "";
				}else {
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
				"<h4>"+
				"<img src='"+this.icon+"' class='ico01' style='height:;'>&nbsp;"+
				"<img src=\"/images/10bet/arrow_01.png\" class=\"arrow\" alt=\"\" />"+this.ca_name+""+
				"<span class='time'>"+this.wr_6.substring(5, 10)+"&nbsp;"+this.wr_6.substring(11, 16)+"</span>"+
				"</h4>";
				}
				board_view_txt = board_view_txt + ""+
				"<div class='ko_sports_game j_"+this.bn_id+"_t'> ";
				if(home_name[0].indexOf("����")!=-1){
				board_view_txt = board_view_txt + "</div>";
				}else {
				board_view_txt = board_view_txt + "</div>";
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
		//{{{ �������� =========================================
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
		//{{{ �������� =========================================
		}
		else if( VarBoTable=='a60' || VarBoTable=='a90' ){
		//{{{ �Ŀ��� =========================================
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
		//}}} �Ŀ��� =========================================
		}
		//}}} ���ʽ� ���� =========================================
		else if(home_name[0].indexOf("����")!=-1){
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
		//}}} ���ʽ� ���� =========================================
		
		}
		else {
		//{{{ �׿� =========================================
			/*board_view_txt = board_view_txt + "<table width=\"100%\" border=\"0\" height=\"30\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:#222;padding:4px 10px;\">	"+
			"<tr bgcolor='"+listbackGround+"' id=\"num_"+this.wr_id+"\"> "+
			"<td width=\"12%\" align='left' style='font-size:13px; color:#fff; '><img src=\"/images/ico_calendar.png\" style='vertical-align:middle;'>"+this.wr_6.substring(5, 10)+"<font style='font-size:13px;color:#fff;'>&nbsp;"+this.wr_6.substring(11, 16)+"</font></td>"+
			"<td width=\"20%\" align='left' style='font-size:13px; color:#fff;border:1px solid #89e954; '><font style='font-size:13px;color:#fff;'>&nbsp;"+this.wr_7+"</font></td>"+
			"<td width=\"2\">&nbsp;</td>"+
			"<td width=\"27%\" align=\"center\"  class=\"menu1\" "+chk1+">"+
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
			"<td align=\"center\" width=\"27%\" align=\"right\" "+chk2+">"+
			"	<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"  onmouseover='highlight(this,true)' onmouseout='highlight(this,false)' class=\"pointer awayTeam "+menuOffCss+"\" height=\"32\" id=\"chk_"+this.wr_id+"_2\">"+
			"		<tr> "+
			"		<td width=\"6\">&nbsp;</td>"+
			"		<td width=\"40\"  style='text-align:left;'>"+this.wr_2+"</td>"+
			"		<td align=\"right\" class=\"bet1 "+css_under+"\">"+away_name[0]+"</td>"+
			"		<td width=\"8\">&nbsp;</td>"+
			"		</tr>"+
			"	</table>"+
			"</td>	 "+
			"<td width=\"1\">&nbsp;</td>"+
			"<td width=\"6%\" align=\"center\" style=\"border: 1px solid #555;border-radius: 5px;\">"+state+"</td>"+
			"</tr>"+
		"</table>";*/
		//}}} �׿� =========================================
		
		//{{{ �׿� =========================================
			var home_img = this.wr_email;
			var away_img = this.wr_subject
			if(home_img){
				if(home_name[0].indexOf("��������")!=-1){
					home_img = "<img src='"+this.wr_email+"' height='50'>";
					var td_height = "50";
				}else {
					home_img = "<img src='"+this.wr_email+"' height='45'>";
					var td_height = "45";
				} 
		
			}
			if(away_img){ 
				if(home_name[0].indexOf("��������")!=-1){
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
				// Ȩ ���� Ÿ��Ʋ ���� : A VS B
				board_view_txt = board_view_txt + 
				/*"<table class='j_"+this.bn_id+"_t' width=\"100%\" border=\"0\" height=\"30\" cellpadding=\"0\" cellspacing=\"0\" style=\"padding:5px 0;table-layout:fixed;\">	"+
				"<tr bgcolor='"+listbackGround+"' id=\"num_"+this.wr_id+"\"> "+
				"<td width=\"14%\" align='center' class=\"num_orange\" style='font-size:14px;'>"+this.wr_6.substring(5, 10)+"<font style='font-size:14px; color:#f60000;'>&nbsp;&nbsp;"+this.wr_6.substring(11, 16)+"</font></td>"+
					"<td width=\"20%\" align='left' style='font-size:13px; font-weight:bold; color:#000;border:1px solid #29ed52;background-color: rgba(42,253,86,0.8); '>&nbsp;"+this.wr_7+"</td>"+
					"<td width=\"2\">&nbsp;</td>"+
					"<td width=\"34%\" align=\"center\"  class=\"menu1\" "+chk1+">"+
					"	<table width=\"100%\" border=\"0\"cellspacing=\"0\" cellpadding=\"0\" onmouseover='highlight(this,true)' onmouseout='highlight(this,false)' class=\"pointer homeTeam "+menuoffcss+"\" height=\"32\" id=\"chk_"+this.wr_id+"_1\">"+
					"		<tr> "+
					"		<td width=\"8\">&nbsp;</td>"+
					"		<td width=\""+td_height+"\">"+home_img+"</td>"+
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
					"		<TD class=\"bet1\" height=\""+td_height+"\" align=center>"+this.handy+"</TD>"+
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
					"		<td width=\""+td_height2+"\">"+away_img+"</td>"+
					"		<td width=\"8\">&nbsp;</td>"+
					"		</tr>"+
					"	</table>"+
					"</td>	 "+
					"<td width=\"2\">&nbsp;</td>				";*/
					"<ul>"+
					"<li id=\"num_"+this.wr_id+"\">"+
					"<div class='type01'>"+this.wr_7+"</div>"+
					"<div class='bet_area'>"+
					"<div class='home "+menuOffCss+"' "+chk1+" id=\"chk_"+this.wr_id+"_1\">"+home_name[0]+" <span class='bed'>"+this.wr_1+"</span></div>&nbsp;"+
					"<div class='draw "+menuOffCss+"' "+chk3+" id=\"chk_"+this.wr_id+"_3\">"+this.handy+"</div>&nbsp;"+
					"<div class='away "+menuOffCss+"' "+chk2+" id=\"chk_"+this.wr_id+"_2\">"+away_name[0]+" $bet_under <span class='bed'>"+this.wr_2+"</span></div>"+
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
			}
			if (is_multi_mode) {
			if (is_start) {
				// show and hide �� �ϱ� ���� wrap div 
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
			}
			}
		//}}} �׿� =========================================
		}
		i++;
		
	});
	bonus_cnt_arr  = bonus_cnt_arr.filter(function(item) {
  		return item !== null && item !== undefined && item !== '';
	});
	var bonus_cnt = bonus_cnt_arr.length;
	var bonus_width = 100/bonus_cnt;
	
	board_view_txt = board_view_txt + "<style>.ko_sports_game .bonus_ul{width:"+bonus_width.toFixed(2)+"%;display:inline-block;margin:0;}.ko_sports_game .bonus_div{width:99%;}</style>";

	// ȭ�� UI ������Ʈ ���� üũ (hong)
	if( VarBoTable != table ){
		return;
	}


	$j("#board_list").empty();

	board_view_txt = board_view_txt + "</td></tr><tr> <td></td><td height=\"13\"></td></tr>";

	$j("#board_list").append(board_view_txt);

	if( VarSca != "" ) VarSca = "["+VarSca+"]";

	if( i == 0 ) 
		$j("#board_list").append("<tr id=\"num_"+this.wr_id+"\" height=\"28\" align=\"center\" class=\"list"+bg_num+"\">"+
			"<td colspan=\"10\" height='148'><font color=\"#1cfe3e\"><b>"+VarSca+"</b></font> <font color=\"#fff\">��ϵ� ��Ⱑ �����ϴ�.</font></td>"+
			"</tr><tr><td colspan=\"10\"></td></tr>");


}
/**
 * ��� : ���� ����Ʈ ǥ��
 * @param data  : ���� ����Ʈ
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
// jongmok ���� �ߺ��� ���� �� array �� ���� �Լ�
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

// ���������� ���� ���̺��� ����� �׷��ֱ�
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

	if(jongmok == "�౸") class_name = "soc";
	else if(jongmok == "��") class_name = "bask";
	else if(jongmok == "�߱�") class_name = "base";
	else if(jongmok == "���̽���Ű" || jongmok == "��Ű") class_name = "hock";
	else if(jongmok == "�״Ͻ�") class_name = "tenn";
	else if(jongmok == "�ڵ庼") class_name = "hand";
	else if(jongmok == "���ͽ�����") class_name = "motor";
	else if(jongmok == "����") class_name = "rub";
	else if(jongmok == "ũ����") class_name = "cri";
	else if(jongmok == "��Ʈ") class_name = "dart";
	else if(jongmok == "�豸") class_name = "val";
	else if(jongmok == "ǲ��") class_name = "foot";
	else if(jongmok == "������") class_name = "ton";
	else if(jongmok == "�̽�����") class_name = "espo";
	else class_name = "etc";

	//$j('#sports_league_ul').append("<li onclick=\""+click_title+"\"><img src='"+league.icon+"' alt='ico' /> <span class='name'>"+jongmok+"</span><span class='count on'>"+data.length+"</span></li>")
	$j('.sports_league_ul span.'+class_name).text(data.length).addClass("on");
	//$j('#sports_league_ul>li').attr("onClick",click_title);

	var league = '';
	var click_content = '';
	for (i=0; i<data.length; i++) {

		click_content	= "click_league('" + data[i].bn_id + "')";
		league  =
			"<div style='cursor:pointer;width:250px;margin-bottom:10px;"+ellipsis_style+"' onclick=\""+click_content+"\">" +
				"<img width='27' height='18' src='" + data[i].league_img + "' onerror=\"this.src='/images/logo.png'\" align=absmiddle>" + 
				"&nbsp;&nbsp;" + data[i].league + " ( " + data[i].league_cnt + " )";
			"</div>";
	$j('#sports_league_table > tbody:last').append("<tr class='left_display_none league_"+data[i].bn_id+"'><td style='"+list_style+"'>" + league + "</td></tr>");
	}
	//$j('#sports_league_table > tbody:last').append("<tr><td style='"+list_style+"'></td></tr>");
}
// ���������� ���� ���̺��� ����� �׷��ֱ�
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

	if(jongmok == "�౸") class_name = "soc";
	else if(jongmok == "��") class_name = "bask";
	else if(jongmok == "�߱�") class_name = "base";
	else if(jongmok == "���̽���Ű" || jongmok == "��Ű") class_name = "hock";
	else if(jongmok == "�״Ͻ�") class_name = "tenn";
	else if(jongmok == "�ڵ庼") class_name = "hand";
	else if(jongmok == "���ͽ�����") class_name = "motor";
	else if(jongmok == "����") class_name = "rub";
	else if(jongmok == "ũ����") class_name = "cri";
	else if(jongmok == "��Ʈ") class_name = "dart";
	else if(jongmok == "�豸") class_name = "val";
	else if(jongmok == "ǲ��") class_name = "foot";
	else if(jongmok == "������") class_name = "ton";
	else if(jongmok == "�̽�����") class_name = "espo";
	else class_name = "etc";

	//$j('#sports_league_ul').append("<li onclick=\""+click_title+"\"><img src='"+league.icon+"' alt='ico' /> <span class='name'>"+jongmok+"</span><span class='count on'>"+data.length+"</span></li>")
	$j('.inplay_league_ul span.'+class_name).text(data.length).addClass("on");
	//$j('#inplay_league_ul>li').attr("onClick",click_title);

	var league = '';
	var click_content = '';
	for (i=0; i<data.length; i++) {

		click_content	= "click_league('" + data[i].bn_id + "')";
		league  =
			"<div style='cursor:pointer;width:250px;margin-bottom:10px;"+ellipsis_style+"' onclick=\""+click_content+"\">" +
				"<img width='27' height='18' src='" + data[i].league_img + "' onerror=\"this.src='/images/logo.png'\" align=absmiddle>" + 
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
// �ִ���ñݾ�
function cart_max_input(){
	// ���� üũ
    var betstr = bet._bet;
    if (betstr.toFixed) {
        betstr = betstr.toFixed(2);
    }
	if(!betstr) {
		return;
	}

	// �ִ��÷���� �ޱ����� ���ñݾ� ���
	max_amount = parseInt(eval("VarMaxAmount"));
	price = parseInt(max_amount / betstr);

	// �ִ���þ�üũ
	max_bet = parseInt(eval("VarMaxBet"));
	if( price > max_bet ) price=max_bet;

	// �����ݾ�üũ
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
// ���� ��Ÿ���� �ݿø� �Լ� ����
function roundXL(n, digits) {
	//return parseFloat(math.round(parseFloat(n), digits));
/*
  if (digits >= 0) return parseFloat(n.toFixed(digits)); // �Ҽ��� �ݿø�

  digits = Math.pow(10, digits); // ������ �ݿø�
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
	if (d == 'none'){   d = '';     $j(e).val('����');	}
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
							img_src = "/images/arrow_" + ud + "_ani.gif";
							d["wr_"+k] = row["wr_" + k];
							$j("#chk_"+row.wr_id+"_"+k + " .rtext").html(row["wr_"+k]);
							$j("#chk_"+row.wr_id+"_"+k + " .rimg > img").remove();
							$j("#chk_"+row.wr_id+"_"+k + " .rimg").append("<img src='"+img_src+"' width='10'>");
							
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
			// 2�� �� ����
			chk_restoration();
		},
		error: function() {
		},
		timeout: 3000
	});
}
