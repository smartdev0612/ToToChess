$j().ready(function(){
    // 스포츠 소켓창조
    sportsSocket(); 

    // 미니게임 소켓창조
    miniSocket();

    $j(function(){ 
        var ww2 = window.innerWidth;
        if(ww2 <= 1200) {
            $j("#pc_betting_cart").empty();
        }else {
            $j("#mobile_betting_cart").empty();
        }
    });

    $j(window).resize(function() { 
        var ww2 = window.innerWidth;
        if(ww2 <= 1200) {
            $j("#pc_betting_cart").empty();
        }else {
            $j("#mobile_betting_cart").empty();
        }
    });

    $j("#confirmBetCancel").on("click", function(){
        location.href = "/race/betting_list";
        betCancel_popup_close();
    });

    var userInfo = setInterval(getUserInfo, 5000);

    $j(".confirmBetting").on("click", function(){
        confirm_popup_close();
        confirmBet();
    });

    $j(".confirmNoBetting").on("click", function(){
        bettingSubmitFlag = 0;
        confirm_popup_close();
    });

    $j(".icon-close").on("click", function(){
        $j(".mask_layer").click();
    });

    // 축구
    $j(".soc").on( "click", function() {
        console.log("축구");
        var submenu = $j(".li-soccer");
        var submenu1 = $j(".ul-soccer");


        // submenu 가 화면상에 보일때는 위로 보드랍게 접고 아니면 아래로 보드랍게 펼치기
        if( submenu.is(":visible") ){
            submenu.slideUp("fast");
            submenu1.slideUp("fast");
        }else{
            submenu.slideDown("fast");
        }

    });

    // 농구
    $j(".bask").on( "click", function() {
        
        var submenu = $j(".li-bask");
        var submenu1 = $j(".ul-bask");

        // submenu 가 화면상에 보일때는 위로 보드랍게 접고 아니면 아래로 보드랍게 펼치기
        if( submenu.is(":visible") ){
            submenu.slideUp("fast");
            submenu1.slideUp("fast");
        }else{
            submenu.slideDown("fast");
        }
    });

    // 야구
    $j(".base").on( "click", function() {
        
        var submenu = $j(".li-base");
        var submenu1 = $j(".ul-base");

        // submenu 가 화면상에 보일때는 위로 보드랍게 접고 아니면 아래로 보드랍게 펼치기
        if( submenu.is(":visible") ){
            submenu.slideUp("fast");
            submenu1.slideUp("fast");
        }else{
            submenu.slideDown("fast");
        }
    });

    // 아이스 하키
    $j(".hock").on( "click", function() {
        
        var submenu = $j(".li-hock");
        var submenu1 = $j(".ul-hock");

        // submenu 가 화면상에 보일때는 위로 보드랍게 접고 아니면 아래로 보드랍게 펼치기
        if( submenu.is(":visible") ){
            submenu.slideUp("fast");
            submenu1.slideUp("fast");
        }else{
            submenu.slideDown("fast");
        }
    });

    // 배구
    $j(".val").on( "click", function() {
        
        var submenu = $j(".li-val");
        var submenu1 = $j(".ul-val");

        // submenu 가 화면상에 보일때는 위로 보드랍게 접고 아니면 아래로 보드랍게 펼치기
        if( submenu.is(":visible") ){
            submenu.slideUp("fast");
            submenu1.slideUp("fast");
        }else{
            submenu.slideDown("fast");
        }
    });

    // E스포츠
    $j(".espo").on( "click", function() {
        
        var submenu = $j(".li-espo");
        var submenu1 = $j(".ul-espo");

        // submenu 가 화면상에 보일때는 위로 보드랍게 접고 아니면 아래로 보드랍게 펼치기
        if( submenu.is(":visible") ){
            submenu.slideUp("fast");
            submenu1.slideUp("fast");
        }else{
            submenu.slideDown("fast");
        }
    });

});

/*********************** 왼쪽 오늘의 경기 스포츠 개수 현시 ****************************/

// 리그클릭시 리그목록 현시.
function showLeagues(className) {
    var submenu2 = $j("." + className);
    // submenu 가 화면상에 보일때는 위로 보드랍게 접고 아니면 아래로 보드랍게 펼치기
    if( submenu2.is(":visible") ){
        submenu2.slideUp("fast");
    }else{
        submenu2.slideDown("fast");
    }
}

// 종목별 경기개수 현시
function showSportsTotalCount(json, isOther = false) {
    if(json == null || json.length == 0)
        return;
    var soccer = json.find(value => value.m_strName == "축구");
    if(soccer != null) {
        $j(".total_count_soccer").text(soccer.m_nCount);
        for(var i=0; i<soccer.m_lstCountryCnt.length; i++) {
            appendCntInfo("soccer", soccer.m_lstCountryCnt[i], isOther);
        }
    }

    var basketball = json.find(value => value.m_strName == "농구");
    if(basketball != null) {
        $j(".total_count_basketball").text(basketball.m_nCount);
        for(var i=0; i<basketball.m_lstCountryCnt.length; i++) {
            appendCntInfo("bask", basketball.m_lstCountryCnt[i], isOther);
        }
    }

    var volleyball = json.find(value => value.m_strName == "배구");
    if(volleyball != null) {
        $j(".total_count_volleyball").text(volleyball.m_nCount);
        for(var i=0; i<volleyball.m_lstCountryCnt.length; i++) {
            appendCntInfo("val", volleyball.m_lstCountryCnt[i], isOther);
        }
    }

    var baseball = json.find(value => value.m_strName == "야구");
    if(baseball != null) {
        $j(".total_count_baseball").text(baseball.m_nCount);
        for(var i=0; i<baseball.m_lstCountryCnt.length; i++) {
            appendCntInfo("base", baseball.m_lstCountryCnt[i], isOther);
        }
    }

    var icehocky = json.find(value => value.m_strName == "아이스 하키");
    if(icehocky != null) {
        $j(".total_count_icehocky").text(icehocky.m_nCount);
        for(var i=0; i<icehocky.m_lstCountryCnt.length; i++) {
            appendCntInfo("hock", icehocky.m_lstCountryCnt[i], isOther);
        }
    }

    var esports = json.find(value => value.m_strName == "E스포츠");
    if(esports != null) {
        $j(".total_count_espo").text(esports.m_nCount);
        for(var i = 0; i < esports.m_lstCountryCnt.length; i++) {
            appendCntInfo("espo", esports.m_lstCountryCnt[i], isOther);
        }
    }
}

// 국가별 리그 현시.
function appendCntInfo(sports, json, isOther = false) {
    var div_id = `id_${sports}-${json.m_nCountry}`;
    var div_obj = document.getElementById(div_id);
    if(div_obj != undefined) {
        document.getElementById(`id_${sports}-${json.m_nCountry}_value`).innerHTML = json.m_nCount;
        for(var j = 0; j < json.m_lstLeagueCnt.length; j++){
            var obj = document.getElementById(`id_${sports}-${json.m_nCountry}-${json.m_lstLeagueCnt[j].m_nLeague}_value`);
            if(obj == null || obj == undefined) {
                var div = "";
                if(isOther) {
                    if(api == "true")
                        div += `<li class="ss_bl1 li-bg" onClick="location.href='/api/game_list?game=abroad&league_sn=${json.m_lstLeagueCnt[j].m_nLeague}&userid=${uid}'">`;
                    else 
                        div += `<li class="ss_bl1 li-bg" onClick="location.href='/game_list?game=abroad&league_sn=${json.m_lstLeagueCnt[j].m_nLeague}'">`;
                } else {
                    div += `<li class="ss_bl1 li-bg" onClick="onClickLeague('${json.m_lstLeagueCnt[j].m_nLeague}')">`;
                }
                div += '<a href="javascript:void(0)">';
                div += '<p class="txt_line1 _limit _w180 p-badge">' + json.m_lstLeagueCnt[j].m_strName + '</p>';
                div += `<span class="badge badge-info f_right _center w35 ${style_type > 0 ? 'span-badge-abroad' : 'span-badge'}" id="id_${sports}-${json.m_nCountry}-${json.m_lstLeagueCnt[j].m_nLeague}_value">` + json.m_lstLeagueCnt[j].m_nCount + `</span>`;
                div += '</a>';
                div += '</li>';

                $j(`#id_${sports}-${json.m_nCountry}_ul`).append(div);
            }
            else {
                obj.innerHTML = json.m_lstLeagueCnt[j].m_nCount;
            }
        }
    }
    else {
        var div = `<div id="id_${sports}-${json.m_nCountry}">`;
        div += `<ul class="li-${sports}" onclick=showLeagues("ul-${sports}-${json.m_nCountry}") style="display:none; width:97%; margin-left:7px;">`;
        div += '<li class="menu2">';
        div += '<a href="javascript:void(0)" class="st_marl10 menu2-a">';
        div += '<img src="' + json.m_strImg + '" width="15" class="menu2-img">'; 
        div += json.m_strName;									
        div += `<span class="f_right _center w35 menu2-span" style="margin-right:10px;" id="id_${sports}-${json.m_nCountry}_value">` + json.m_nCount + '</span>';
        div += '</a>';
        div += '</li>';
        div += '</ul>';
        div += `<ul class="ul-${sports} ul-${sports}-${json.m_nCountry} sub-ul" style="display:none;" id="id_${sports}-${json.m_nCountry}_ul">`;
        for(var j = 0; j < json.m_lstLeagueCnt.length; j++){
            if(isOther) {
                if(api == "true")
                    div += `<li class="ss_bl1 li-bg" onClick="location.href='/api/game_list?game=abroad&league_sn=${json.m_lstLeagueCnt[j].m_nLeague}&userid=${uid}'">`;
                else 
                    div += `<li class="ss_bl1 li-bg" onClick="location.href='/game_list?game=abroad&league_sn=${json.m_lstLeagueCnt[j].m_nLeague}'">`;
            } else {
                div += `<li class="ss_bl1 li-bg" onClick="onClickLeague('${json.m_lstLeagueCnt[j].m_nLeague}')">`;
            }
            div += '<a href="javascript:void(0)">';
            div += '<p class="txt_line1 _limit _w180 p-badge">' + json.m_lstLeagueCnt[j].m_strName + '</p>';
            div += `<span class="badge badge-info f_right _center w35 ${style_type > 0 ? 'span-badge-abroad' : 'span-badge'}" id="id_${sports}-${json.m_nCountry}-${json.m_lstLeagueCnt[j].m_nLeague}_value">` + json.m_lstLeagueCnt[j].m_nCount + `</span>`;
            div += '</a>';
            div += '</li>';
        }
        div += '</ul>';
        div += `</div>`
        $j(`.div_${sports}`).append(div);
    }
}

/**************************** 로그인, 회원가입, 배팅, 쪽지, 알람 각종 팝업 **************************************/
function login_open(){
    $j("#popup_login").fadeIn();
    $j("#coverBG").fadeIn();
}

function register_open(){
    $j("#popup_register").fadeIn();
    $j("#coverBG").fadeIn();
    
}

function login_popup_close(){
    $j("#popup_login").fadeOut();
    $j("#popup_register").fadeOut();
    $j("#coverBG").fadeOut();
}

function betting_ready_popup() {
    $j("#betLoading").fadeIn();
    $j("#coverBG").fadeIn();
}

function betting_ready_popup_close() {
    $j("#betLoading").fadeOut("fast");
    $j("#coverBG").fadeOut();
}

function warning_popup(text) {
    $j("#warning_popup .pop_message").html(text);
    $j("#warning_popup").fadeIn();
    $j("#coverBG").fadeIn();
    // setTimeout(warning_popup_close, 1500);
}

function warning_popup_close() {
    $j("#warning_popup").fadeOut();
    $j("#coverBG").fadeOut();
}

function sports_popup(text) {
    $j("#sports_popup .pop_message").html(text);
    $j("#sports_popup").slideDown('fast');
    $j("#coverBG").fadeIn('fast');
}

function confirm_popup(text) {
    console.log(text);
    $j("#confirm_popup .pop_message").html(text);
    $j("#confirm_popup").slideDown('fast');
    $j("#coverBG").fadeIn('fast');
}

function confirm_popup_close() {
    $j("#confirm_popup").slideUp('fast');
    $j("#sports_popup").slideUp('fast');
    $j("#coverBG").fadeOut('fast');
}

function betCancel_popup() {
    $j("#betCancel_popup").slideDown('fast');
    $j("#coverBG").fadeIn('fast');
}

function betCancel_popup_close() {
    $j("#betCancel_popup").slideUp('fast');
    $j("#coverBG").fadeOut('fast');
}

function memo_popup(answerCnt) {
    var text = "고객센터에서 답변이 " + answerCnt + "개 왔습니다.";
    $j("#memo_popup .pop_message").text(text);
    $j("#memo_popup").slideDown('fast');
    $j("#coverBG").fadeIn('fast');
}

function loginCheck() {
    var f = document.login;
    if ( f.uid.value == "" ) {
        warning_popup('아이디를 입력하십시오.');
        //f.uid.focus();
        return false;
    }

    if ( f.upasswd.value == "" ) {
        warning_popup("비밀번호를 입력하십시오.");
        f.upasswd.focus();
        return false;
    }

    f.submit();
    return false;
}


// 회원가입시 엔터건으로 가입단추 클릭
function loginEnter(e) {
    if ( e.keyCode == 13 ) {
        loginCheck();
    }
}

// 회원가입을 위한 추천인코드 검사
function check_pincode() {
    var pincode = $j('#pincode').val();
    if ( pincode.length < 1 ) {
        warning_popup('가입인증코드를 입력하세요');
        $j('#pincode').focus();
        return false;
    } else {
        $j.ajaxSetup({async:false});
        var param={pin:pincode};

        $j.post("/member/pincodePopup", param, function(result) {
            if( $.trim(result) == "false" ) {
                $j("#pincode").focus();
                warning_popup("존재하지 않거나, 제한된 가입인증코드 입니다.");
                return false;
            } else {
                document.next.submit();
            }
        });
    }
    return false;
}

// 회원가입시 영문, 수자 체크
function eng(obj) {
    var pattern = /[^(a-zA-Z0-9)]/; //영문만 허용
    if (pattern.test(obj.value)) {
        warning_popup("영문과 숫자만 허용합니다!");
        obj.value = '';
        obj.focus();
        return false;
    }
}

// 5초에 한번씩 유저머니, 쪽지, 고객센터 답변등록, 배팅취소 등 체크
function getUserInfo() {
    $j.ajaxSetup({async:true});

    $j.get("/member/getUserInfo", function(result) {
        var json = JSON.parse(result);
        if(json.length == 0) 
            return;
        
        VarMoney = json.member.g_money;
        $j(".member_inmoney").html(addCommas(json.member.g_money));
        $j(".member_mileage").html(addCommas(json.member.point));

        var url = window.location.href;
        if(json.memo > 0) {
            if(url.indexOf('/member/memolist') == -1 && api != "true") {
                try { jBeep('/public/snd/msg_recv_alarm.mp3'); } catch(e) {};
                $j(".count01").text(json.memo);
                $j(".count02").text(json.memo);
                $j(".mask_layer").show();
                $j(".popup_message").show();
            }
        }

        if(json.member.bet_cancel_cnt > 0)
            betCancel_popup();

        if(json.member.customer_answer_flag > 0) {
            try { jBeep('/public/snd/Alarm01.mp3'); } catch(e) {};
            memo_popup(json.member.customer_answer_flag);
        }
        // console.log(addCommas(result));
    });
}

// 수자를 반점 구분으로 현시, ex: 10,000
function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

// 페지스크롤을 페지상단으로 유연하게 이동.
function scrollToTop() {
    var position = document.body.scrollTop || document.documentElement.scrollTop;
    var scrollAnimation;
    if (position) {
        window.scrollBy(0, -Math.max(1, Math.floor(position / 10)));
        scrollAnimation = setTimeout("scrollToTop()", 30);
    } else clearTimeout(scrollAnimation);
}

function scrollToTopDiv(div_id) {
    setTimeout(function() { $(div_id).scrollTop(0); }, 500);
}

/******************************************* Web Socket *******************************************/
var showJson;

var ws; // 스포츠 소켓

var wsMini; // 미니게임 소켓

var packet = {
    "m_strSports"   :   "",
    "m_nLeague"     :   0,
    "m_nLive"       :   0,
    "m_nPageIndex"  :   0,
    "m_nPageSize"   :   50
};

function sportsSocket() {
    ws = new WebSocket(WS_SPORTS_ADDRESS);

    ws.onopen = function (event) {
        console.log("WebSocket Opened");
    };
    
    ws.onerror = function (event) {
        console.log("WebSocket Error");
        sportsSocket();
    }

    ws.onclose = function (event) {
        console.log("WebSocket Closed");
        sportsSocket();
    }
    
    ws.onmessage = function (event) {
        try {
            var objPacket = JSON.parse(event.data);
            
            if(objPacket.m_nPacketCode == PACKET_SPORT_LIST) {
                // console.log(objPacket);
                onRevGameList(objPacket.m_strPacket);
            }
            else if(objPacket.m_nPacketCode == PACKET_SPORT_BET) {
                onRecvBetting(objPacket);
            }
            else if(objPacket.m_nPacketCode == PACKET_SPORT_AJAX) {
                onRecvAjaxList(objPacket.m_strPacket);
            }
        }
        catch(err) {
            console.log(err.message);
        }
    }
    
}

function miniSocket() {

    wsMini = new WebSocket(WS_MINI_ADDRESS);

    wsMini.onopen = function (event) {
        console.log("Minigame WebSocket Opened");
    };
    
    wsMini.onerror = function (event) {
        console.log("Minigame WebSocket Error");
        miniSocket();
    }

    wsMini.onclose = function (event) {
        console.log("Minigame WebSocket closed");
        miniSocket();
    }
    
    wsMini.onmessage = function (event) {
        try {
            var objPacket = JSON.parse(event.data);
            if(objPacket.m_nPacketCode == PACKET_SPORT_BET) {
                onRecvBetting(objPacket);
            }
            else if(objPacket.m_nPacketCode == PACKET_POWERBALL_BET) {
                onRecvBetting(objPacket);
            }
            else if(objPacket.m_nPacketCode == PACKET_POWERLADDER_BET) {
                onRecvBetting(objPacket);
            }
            else if(objPacket.m_nPacketCode == PACKET_POWERBALL_TIME) {
                realTime(objPacket.m_strPacket);
            }
        }
        catch(err) {
            console.log(err.message);
        }
    }
}

function sendPacket(nPacketCode, strPacket) {
    var packet = {
        "m_nPacketCode"     :   nPacketCode,
        "m_strPacket"       :   strPacket
    };

    ws.send(JSON.stringify(packet));
}

function onSendReqListPacket(param) {
	console.log("Send initial packet");
	if(ws.readyState === WebSocket.OPEN) {
		onLoadingScreen();
		sendPacket(PACKET_SPORT_LIST, JSON.stringify(param));
	} else {
        setTimeout(() => {
            sendPacket(PACKET_SPORT_LIST, JSON.stringify(param));
        }, 5000);
    }
}

function sendMiniPacket(nPacketCode, strPacket) {
    console.log("Send Mini Packet");
    var packet = {
        "m_nPacketCode"     :   nPacketCode,
        "m_strPacket"       :   strPacket
    };

    wsMini.send(JSON.stringify(packet));
}


// 페지로딩시 로딩아이콘 현시
function onLoadingScreen() {
    $j("#loading").show();
    $j("#loading img").show().css({'transition':'transform 1s ease' , 'transform' : 'rotateY(180deg)'});
    $j("#coverBG2").show();
    setTimeout(function(){
        $j("#loading img").css({'transition':'transform 1s ease' , 'transform' : 'rotateY(0deg)'});
    },1000);
    setTimeout(function(){
        $j("#loading img").css({'transition':'transform 1s ease' , 'transform' : 'rotateY(180deg)'});
    },2000);
    setTimeout(function(){
        $j("#loading img").css({'transition':'transform 1s ease' , 'transform' : 'rotateY(0deg)'});
    },3000);
}

// 해당 경기에 승무패 또는 승패마켓이 존재하는지 검사
function checkExist1x2(item) {
    var details = item.m_lstDetail;
    var isExist12 = false;
    var findID = 0;
    switch(item.m_strSportName) {
        case "축구":
            findID = 1;
            break;
        case "농구":
            findID = 226;
            break;
        case "야구":
            findID = 226;
            break;
        case "배구":
            findID = 52;
            break;
        case "아이스 하키":
            findID = 226;
            break;
        case "E스포츠":
            findID = 52;
            break;
    }
    var findResult = details.filter(value => value.m_nMarket == findID);
   
    if(findResult.length > 0) {
        isExist12 = true;
    }

    return isExist12;
}


// 유럽형, 라이브에서 매 경기별 배팅가능한 마켓개수 얻기.
function getMarketsCnt(sport_name, children, isExist12 = true) {
    var temp_id = 0;
    var cnt = 0;
    var marketArray = [];
    switch(sport_name) {
        case "축구":
            marketArray = [427, 1, 2, 3, 41, 42, 21, 45, 151, 153, 154, 155, 156, 101, 102, 64, 65, 7, 5, 72, 73, 9, 100, 6, 456, 457];
            break;
        case "농구":
            marketArray = [226, 342, 28, 202, 203, 204, 205, 206, 464, 41, 42, 43, 44, 282, 284, 64, 65, 66, 67, 467, 468, 21, 45, 46, 47, 77, 469, 153, 154, 155, 156, 223, 222, 287, 288, 354, 355, 221, 220, 51, 72, 73, 74, 75, 76, 242, 243, 289, 292, 290, 293, 291, 294, 285, 198, 199];
            break;
        case "배구":
            marketArray = [52, 1558, 2, 202, 203, 204, 205, 206, 64, 65, 66, 67, 68, 21, 45, 46, 47, 101, 102, 5, 72, 73, 74, 75, 76, 6, 153, 154, 155, 156];
            break;
        case "야구":
            marketArray = [226, 342, 28, 220, 221, 235, 41, 42, 43, 44, 524, 281, 526, 21, 45, 46, 47, 48, 236, 525, 6, 349];
            break;
        case "아이스 하키":
            marketArray = [226, 3, 342, 28, 7, 202, 41, 42, 43, 44, 64, 65, 66, 221, 220, 21, 45, 46, 51];
            break;
        case "E스포츠":
            marketArray = [52, 3, 2, 6, 202, 203, 204, 205, 206, 64, 65, 66, 67, 68, 1149, 1150, 1151, 1152, 1153, 989, 990, 991, 1165, 1166, 1167, 1168, 1169, 669, 670, 671, 1170, 1171, 1172, 1173, 1174, 1251, 1252, 1253, 1254, 1255, 672, 673, 674, 666, 667, 668, 679, 680, 681 ];
            break;
    }
   
    for(var i = 0; i < children.length; i++) {
        if(temp_id != children[i].m_nMarket) {
            temp_id = children[i].m_nMarket;
            for(var j = 0; j < marketArray.length; j++) {
                if(temp_id == marketArray[j]){
                    cnt++;
                    break;
                }
            }
        }
    }

    if(isExist12) 
        return cnt - 1;

    return cnt;
}

/****************************** 미니게임 ****************************/
function getStrDatetime(date, hour, min) {
    var month = date.getMonth() + 1;
    if(month < 10)
        month = "0" + month;
    
    var day = date.getDate();
    if(day < 10) 
        day = "0" + day;

    if(hour < 10)
        hour = "0" + hour;
        
    if(min < 10)
        min = "0" + min;

    var strDatetime = date.getFullYear() + "-" + month + "-" + day + "T" + hour + ":" + min;
    return strDatetime;
}
