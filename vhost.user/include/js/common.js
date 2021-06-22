function winLose() { location.href = "/game_list?special_type=0"; }		//-> 승무패
function hendOver() { location.href = "/game_list?special_type=1"; }	//-> 핸디캡
function special() { location.href = "/game_list?special_type=1"; }		//-> 스페셜
function multi() { location.href = "/game_list?special_type=2"; }		//-> 스페셜
function realtime() { location.href = "/game_list?special_type=4"; }	//-> 실시간
function live() { location.href = "/LiveGame/list"; }									//-> 라이브
function sadari() { location.href = "/game_list?special_type=3"; }		//-> 사다리
function powerBall() { return; }				//-> 파워볼
function boardEvent() { return; }			//-> 이벤트
function gameResult() { location.href = "/race/game_result"; }				//-> 경기결과
function gameBettingList() { location.href = "/race/betting_list"; }	//-> 배팅내역
function boardEvent() { location.href = "/board/?bbsNo=7"; }					//-> 이벤트게시판
function boardFree() { location.href = "/board/"; }										//-> 자유게시판
function boardCs() { location.href = "/cs/cs_list"; }									//-> 고객센터
function mCharge() { location.href = "/member/charge"; }							//-> 충전
function mExchange() { location.href = "/member/exchange"; }					//-> 환전
function bettingInfo() { location.href = "/cs/rule?tab_index=0"; }		//-> 배팅규정
function playInfo() { location.href = "/cs/rule?tab_index=2"; }				//-> 이용안내

function a000()	{ warning_popup("페이지 준비중입니다.","back"); }
function menu0315()	{ location.href = "/casino/board_game"; }   // 보드게임

function goUrl (url) {
    location.href =url;
}


function MoneyFormat(str)
{
	var re="";
	str = str + "";
	str=str.replace(/-/gi,"");
	str=str.replace(/ /gi,"");
	
	str2=str.replace(/-/gi,"");
	str2=str2.replace(/,/gi,"");
	str2=str2.replace(/\./gi,"");	
	
	if(isNaN(str2) && str!="-") return "";
	try
	{
		for(var i=0;i<str2.length;i++)
		{
			var c = str2.substring(str2.length-1-i,str2.length-i);
			re = c + re;
			if(i%3==2 && i<str2.length-1) re = "," + re;
		}
		
	}catch(e)
	{
		re="";
	}
	if(str.indexOf("-")==0)
	{
		re = "-" + re;
	}
	return re;
}

function stringSplit(strData, strIndex)
{ 
	var stringList = new Array(); 
 	while(strData.indexOf(strIndex) != -1)
 	{
  		stringList[stringList.length] = strData.substring(0, strData.indexOf(strIndex)); 
  		strData = strData.substring(strData.indexOf(strIndex)+(strIndex.length), strData.length); 
 	} 
 	stringList[stringList.length] = strData; 
 	return stringList; 
}

//
// Call Functions
//

function mileage2Cash()
{
	amount = parseInt($j('#member_mileage').text().replace(/^\$|,/g, ""));
	amount_text = $j('#member_mileage').text();

	if(amount < 1)
	{
		warning_popup('포인트가 없습니다.');
		return;
	}
	
	if(!confirm(amount_text+' 포인트를 보유금으로 전환하시겠습니까?'))
	{
		return;
	}
	
	var param={mode:"toCash"};
	$j.post("/member/toCashProcess", param, onMileage2Cash, "json");
}

/*
function cash2mileage()
{
	var change_amount = parseInt($j('#cash2mileage_amout').val());
	
	if(isNaN(change_amount) || change_amount < 5000)
	{
		warning_popup('5,000원 이상부터 전환이 가능합니다.');
		return;
	}
	
	if(!confirm('캐쉬를 마일리지로 전환하시겠습니까?'))
	{
		return;
	}
	
	var param={amount:change_amount};
	$j.post("/member/toMileageProcess", param, onCash2Mileage, "json");
}

function listupMileageList($mileageType)
{
	var param={mode:"mileageList", mileageType:$mileageType, page:page, page_size:page_size};
	$j.post("../ajax/ajax_member.php?", param, onListupMileage, "json");
}
*/

//
// Event Functions
//

function onMileage2Cash(jsonText)
{
/*
	newCash = jsonText['g_money'];
	newMileage = jsonText['point'];
	
	newCash = moneyFormat(newCash);
		
	$j("#member_cash").text(moneyFormat(newCash));
 	$j("#member_mileage").text(moneyFormat(newMileage));
*/
	warning_popup("전환이 완료 되었습니다.");
	top.location.reload();	
  return true;
}

/*
function onCash2Mileage(jsonText)
{
	newCash = jsonText['g_money'];
	newMileage = jsonText['point'];
	
	newCash = moneyFormat(newCash);
		
	$j("#member_cash").text(moneyFormat(newCash));
  	$j("#member_mileage").text(moneyFormat(newMileage));
  	
  	$j('#wrap_pop').hide();

	top.location.reload();		
	return true;
}
*/

function getCookie(name)
{
	var nameOfCookie = name + "=";
	var x = 0; 
	while(x<=document.cookie.length) {
		var y = (x+nameOfCookie.length);
		if(document.cookie.substring(x,y) == nameOfCookie) {
			if((endOfCookie=document.cookie.indexOf(";",y))==-1)
				endOfCookie = document.cookie.length;
			return unescape(document.cookie.substring(y,endOfCookie));
		}
		x = document.cookie.indexOf("",x)+1;  //날짜지정
		if(x==0) break;
	}
	return "";
}

function setCookie(name, value, expiredays ) {
	var today = new Date();
	today.setDate( today.getDate() + expiredays );
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + 
	today.toGMTString() + ";";
	//return;
}
		
function Popup(sn, title, content, width, height, top, left) {
	//var width = 1024;
	//var height = 600;
	
	//var left = (screen.width/2)-(width/2);
	//var top = (screen.height/2)-(height/2);
			
	if(getCookie("popup_"+sn)!="done") {
		var win = window.open ("", sn, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+width+', height='+height+', top='+top+', left='+left);
		document.popup.action = "/popup";
		document.popup.title.value=title;
		document.popup.content.value=content;
		document.popup.popup_sn.value=sn;
		document.popup.target = sn;
		document.popup.submit();
		win.focus();
	}
}

//-> 배팅 슬립에서 사용하는 function
	function moneyFormat(num) {
		num = new String(num)
		num = num.replace(/,/gi,"")
		return _moneyFormat(num)
	}
		
	function _moneyFormat(num) {
		fl=""
		if ( isNaN(num) ) { 
			warning_popup("문자는 사용할 수 없습니다.");
			return 0;
		}

		if ( num == 0 ) {
			return num
		}
			
		//처음 입력값이 0부터 시작할때 이것을 제거한다.
		if ( num < 0 ) {
			num = num * ( -1 );
			fl = "-";
		} else {
			num = num * 1; 
		}
		num = new String(num)
		temp = "";
		co = 3;
		num_len = num.length;
		while ( num_len > 0 ) {
			num_len = num_len - co;
			if ( num_len < 0 ){
				co = num_len + co;
				num_len = 0;
			}
			temp = "," + num.substr(num_len,co) + temp;
		}
		return fl + temp.substr(1);
	}

	function onMoneyChangeLive(amount) {
		var rs = moneyFormat(amount);
		calculate_money();
		return rs;
	}

	function onMoneyChange(amount) {
		var rs = moneyFormat(amount);
		if ( !rs ) {
			rs = 0;
			autoCheckBetting(rs);
		}
		calc();
		return rs;
	}

	function clearMoney() {
        betForm.betMoney.value = MoneyFormat(0);
        autoCheckBetting(0);
	}
	//-> 선택한 금액만큼 배팅금액 증가
	function bettingMoneyPlus(plusMoney, type) {
		var this_money = betForm.betMoney.value;
		this_money = this_money.replace(/,/g,"");
		if ( plusMoney == 0 ) {
			if ( type ) {
				var end_money = 0;
			} else {
				var end_money = parseInt(eval("VarMinBet"));
			}
		} else {
			var end_money = parseInt(this_money) + parseInt(plusMoney);
		}
		betForm.betMoney.value = MoneyFormat(end_money);
		autoCheckBetting(end_money);
	}

	//-> 선택한 금액을 배팅금액으로 픽스
	function bettingMoneyPick(plusMoney) {
		betForm.betMoney.value = MoneyFormat(plusMoney);
		autoCheckBetting(plusMoney);
	}

	//-> 최대 배팅
	function onAllinClicked() {	
		var sp_bet = 0
		var max_bet = 0;
		var max_amount = 0;
		
		sp_bet = $j("#sp_bet").html();
		if ( sp_bet > 0 ) {
			VarMoney = parseInt(eval("VarMoney"));
			max_bet = parseInt(eval("VarMaxBet"));
			max_amount = parseInt(eval("VarMaxAmount"));

			if ( VarMoney > max_bet ) {
				this_money = max_bet;
			} else {
				this_money = VarMoney;
			}

			m_betList._point = Math.floor(this_money);
			m_betList._totalprice = Math.floor(m_betList._point*sp_bet);
			if ( m_betList._totalprice > max_amount ) {
				m_betList._point = Math.floor(max_amount / sp_bet);
				m_betList._totalprice = Math.floor(m_betList._point*sp_bet);
			}

			betForm.betMoney.value = MoneyFormat(m_betList._point);
			document.getElementById("sp_total").innerHTML = MoneyFormat(m_betList._totalprice);
		}
	}

	function autoCheckBetting(setMoney) {
		sp_bet = $j("#sp_bet").html();									//-> 배당
		VarMoney = parseInt(eval("VarMoney"));				//-> 보유머니
		max_amount = parseInt(eval("VarMaxAmount"));	//-> 최고배당

		m_betList._point = Math.floor(setMoney);
		m_betList._totalprice = Math.floor(m_betList._point*sp_bet);
		if ( m_betList._totalprice > max_amount ) {
			m_betList._point = Math.floor(max_amount / sp_bet);
			m_betList._totalprice = Math.floor(m_betList._point*sp_bet);
		}

		betForm.betMoney.value = MoneyFormat(m_betList._point);
		document.getElementById("sp_total").innerHTML = MoneyFormat(m_betList._totalprice);
	}

	function Floor(s,n) {
		s = s + "";
		if ( s.indexOf(".") >= 0 ) {
			s = s.substring(0,s.indexOf(".") + 3);
		}
		s = parseFloat(s);
		return s;
	}

	function getObject(objectId) {
		if(document.getElementById && document.getElementById[objectId]) { 
			return document.getElementById[objectId]; 
		} else if (document.all && document.all[objectId]) { 
			return document.all[objectId]; 
		} else if (document.layers && document.layers[objectId]) { 
			return document.layers[objectId]; 
		} else if(document.getElementById && document.getElementById(objectId)) { 
			return document.getElementById(objectId); 
		} else { 
			return false; 
		} 
	}

	//-> 배팅슬립 스크롤
	var betslipStopFlag = 0;
	function betSlipStop(obj) {
		if ( betslipStopFlag == 0 ) {
			betslipStopFlag = 1;
			$j(obj).attr('src','/images/cart_head_2o.png');
		} else {
			betslipStopFlag = 0;
			$j(obj).attr('src','/images/cart_head_2.png');
		}

		initMoving();
	}

	/*function initMoving() {
		var obj = document.getElementById("contents_right");
		obj.initTop = 0;
		obj.topLimit = 10;
		var body = document.body;
		var html = document.documentElement;

        var position = $j("#contents_left").position();
		//obj.bottomLimit = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight) - 100;
		obj.bottomLimit = position.top + $j("#contents_left").height() - $j("#betting_cart").height() - $j("#footer-wrap").height() + 100;


		obj.style.position = "absolute";
		obj.top = obj.initTop;
		obj.left = obj.initLeft;
		if (typeof(window.pageYOffset) == "number") {
			obj.getTop = function() {
				return window.pageYOffset;
			}
		} else if (typeof(document.documentElement.scrollTop) == "number") {
			obj.getTop = function() {
				return document.documentElement.scrollTop;
			}
		} else {
			obj.getTop = function() {
				return 0;
			}
		}
		 
		if (self.innerHeight) {
			obj.getHeight = function() {
				return self.innerHeight;
			}
		} else if(document.documentElement.clientHeight) {
			obj.getHeight = function() {
				return document.documentElement.clientHeight;
			}
		} else {
			obj.getHeight = function() {
				return 1000;
			}
		}

		if (betslipStopFlag){
			clearInterval(obj.move);
			return false;
		}else{ 
			obj.move = setInterval(quickdiv, 30); //이동속도
		}
	}

	function quickdiv() {
		var obj = document.getElementById("contents_right");
//		if (obj.initTop > 0) {
//			pos = obj.getTop() + 8;
//		} else {
			//pos = obj.getTop() + obj.getHeight() + obj.initTop;
			pos = obj.getTop() - 110;
//		}

		if (pos > obj.bottomLimit)
		pos = obj.bottomLimit;
		if (pos < obj.topLimit)
		pos = obj.topLimit;
		 
		interval = obj.top - pos;
		obj.top = obj.top - interval / 3;
		obj.style.top = obj.top + "px";
	}*/

	// function getMarketsCnt(children) {
    //     let group = children.reduce((r, a) => {
    //         r[a.betting_type] = [...r[a.betting_type] || [], a];
    //         return r;
    //     }, {});
    //     return Object.keys(group).length - 1;
    // }

	function scrollToTop() {
        var position = document.body.scrollTop || document.documentElement.scrollTop;
		var scrollAnimation;
        if (position) {
            window.scrollBy(0, -Math.max(1, Math.floor(position / 10)));
            scrollAnimation = setTimeout("scrollToTop()", 30);
        } else clearTimeout(scrollAnimation);
    }