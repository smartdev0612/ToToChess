////////////////////////////링크//////////////////////////////////////
function root()	{ location.href = "/index"; }						
function login()	{ location.href = "/login"; }				
function join()	{ location.href = "/add"; }				
function logout()	{ location.href = "/logout"; }
function pcs()	{
	var domain_array = document.domain.split(".");
	location.href = "http://www."+domain_array[1]+".com?v=pc";	
}		

function menu0110()	{ location.href = "/game_list?special_type=0"; }   // 멀티조합

function menu0120()	{ location.href = "/game_list?special_type=1"; }   // 스페셜

function menu0130()	{ location.href = "/game_list?special_type=2"; }   // 스페셜 II

function menu0140()	{ location.href = "/LiveGame/list"; }   // 축구라이브

function menu0150()	{ location.href = "/game_list?special_type=3"; }   // 사다리

function menu0160()	{ location.href = "/game_list?special_type=4"; }   // 달팽이

function menu0170()	{ location.href = "/game_list?special_type=5"; }   // 파워볼

function menu0180()	{ location.href = "/race/game_result"; }   // 경기결과
function menu0181()	{ location.href = "/race/game_result"; }   // 	승무패
function menu0182()	{ location.href = "/race/game_result?view_type=1"; }   // 	핸디캡
function menu0183()	{ location.href = "/race/game_result?view_type=2"; }   // 	스페셜
function menu0184()	{ location.href = "/race/game_result?view_type=3"; }   // 	축구라이브
function menu0185()	{ location.href = "/race/game_result?view_type=4"; }   // 	사다리
function menu0186()	{ location.href = "/race/game_result?view_type=5"; }   // 	달팽이

function menu0190()	{ location.href = "/race/betting_list"; }   // 배팅내역
function menu0191()	{ location.href = "/race/betting_list"; }   // 	배팅내역
function menu0192()	{ location.href = "/LiveGame/betting_list"; }   // 	라이브배팅내역

function menu0210()	{ location.href = "/member/charge"; }   // 충전신청
function menu0211()	{ location.href = "/member/charge"; }   // 	충전신청
function menu0212()	{ location.href = "/member/chargelist"; }   // 	충전신청내역

function menu0220()	{ location.href = "/member/exchange"; }   // 환전신청
function menu0221()	{ location.href = "/member/exchange"; }   // 	환전신청
function menu0222()	{ location.href = "/member/exchangelist"; }   // 	환전신청내역

function menu0230()	{ location.href = "/event"; }   // 이벤트
function menu0240()	{ location.href = "/board/"; }   // 게시판
function menu0250()	{ location.href = "/cs/cs_list"; }   // 고객센터 
function menu0260()	{ location.href = "/member/memolist"; }   // 쪽지
function menu0270()	{ location.href = "/member/recommend"; }   // 추천인
function menu0280()	{ location.href = "/member/member"; }   //마이페이지
function menu0281()	{ location.href = "/calendar"; }   //출석부

// function menu0110()	{ location.href = "/game_list?special_type=0"; }   // 조합배팅
// function menu0111()	{ location.href = "/game_list?special_type=1"; }   // 스페셜
// function menu0112()	{ location.href = "/LiveGame/list"; }   // 라이브
// function menu0113()	{ location.href = "/game_list?special_type=5"; }   // 사다리
// function menu0122()	{ location.href = "/game_list?special_type=3"; }   // 미사용
// function menu0310()	{ location.href = "/LiveGame/list"; }   // 라이브(축구 실시간)
// function menu0410()	{ location.href = "/PinnacleGame/list"; }   // 피나클 게임

// function menu0312()	{ location.href = "/casino/"; }   // 카지노
// function menu0313()	{ location.href = "/casino/pinnacle"; }   // 카지노
// function menu0314()	{ location.href = "/casino/sbo"; }   // 카지노
// function menu0315()	{ location.href = "/casino/board_game"; }   // 보드게임



// function menu0114()	{ location.href = "/board/?bbsNo=7"; }   // 이벤트
// function menu0115()	{ location.href = "/race/game_result"; }   // 게임결과
// function menu0116()	{ location.href = "/board/"; }   // 게시판
// function menu0117()	{ location.href = "/cs/cs_list"; }   // 고객센터
// function menu0118()	{ location.href = "/cs/rule"; }   // 게임규정


// function menu0211()	{ location.href = "/member/charge"; }   // 머니충전
// function menu0212()	{ location.href = "sub12.html"; }   // 충전내역
// function menu0213()	{ location.href = "sub13.html"; }   // 결재방법
// function menu0214()	{ location.href = "/member/exchange"; }   // 머니환전
// function menu0215()	{ location.href = "/race/betting_list"; }   // 환전내역
// function menu0216()	{ location.href = "sub16.html"; }   // 결재방법
// function menu0217()	{ location.href = "/board/?bbsNo=9"; }   // 잭팟
// function menu0218()	{ location.href = "/member/mileagelist"; }   // 포인트
// function menu0219()	{ location.href = "/member/recommend"; }   // 추천인
// function menu0220()	{ location.href = "/member/member"; }   //마이페이지

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
	amount = parseInt($j('.member_mileage').text().replace(/^\$j|,/g, ""));
	if(amount < 1)
	{
		warning_popup('포인트가 없습니다.');
		return;
	}
	
	if(!confirm('마일리지를 캐쉬로 전환하시겠습니까?'))
	{
		return;
	}
	
	var param={mode:"toCash"};
	$j.post("/member/toCashProcess", param, onMileage2Cash, "json");
}

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

function listupMileageList($jmileageType)
{
	var param={mode:"mileageList", mileageType:$jmileageType, page:page, page_size:page_size};
	$j.post("../ajax/ajax_member.php?", param, onListupMileage, "json");
}

//
// Event Functions
//

function onMileage2Cash(jsonText)
{
	newCash = jsonText['g_money'];
	newMileage = jsonText['point'];
	
	newCash = moneyFormat(newCash);
		
	$j("#member_cash").text(moneyFormat(newCash));
 	$j(".member_mileage").text(moneyFormat(newMileage));

	top.location.reload();	
  return true;
}

function onCash2Mileage(jsonText)
{
	newCash = jsonText['g_money'];
	newMileage = jsonText['point'];
	
	newCash = moneyFormat(newCash);
		
	$j("#member_cash").text(moneyFormat(newCash));
  	$j(".member_mileage").text(moneyFormat(newMileage));
  	
  	$j('#wrap_pop').hide();

	top.location.reload();		
	return true;
}

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

// 배팅슬립
function initMoving() {
 
	var obj = document.getElementById("wrap_betslip");
	obj.initTop = 160;
	obj.topLimit = 180;
	obj.bottomLimit = document.documentElement.scrollHeight - 100;
	 
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
 
	if (document.all.animate.checked){
 
		clearInterval(obj.move);
		return false;
	}else{
 
		obj.move = setInterval(quickdiv, 30); //이동속도
	}
}
 
function quickdiv() {
	var obj = document.getElementById("wrap_betslip");
	if (obj.initTop > 0) {
		pos = obj.getTop() + obj.initTop-140;
	} else {
	pos = obj.getTop() + obj.getHeight() + obj.initTop;
	//pos = obj.getTop() + obj.getHeight() / 2 - 15;
	}
	 
	if (pos > obj.bottomLimit)
	pos = obj.bottomLimit;
	if (pos < obj.topLimit)
	pos = obj.topLimit;
	 
	interval = obj.top - pos;
	obj.top = obj.top - interval / 3;
	obj.style.top = obj.top + "px";
}


function flashDP(s,d,w,h,t){
	document.write("<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width="+w+" height="+h+" id="+d+"><param name=wmode value="+t+" /><param name=movie value="+s+" /><param name=quality value=high /><embed src="+s+" quality=high wmode="+t+" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/shockwave/download/index.cgi?p1_prod_version=shockwaveflash\" width="+w+" height="+h+"></embed></object>");
}