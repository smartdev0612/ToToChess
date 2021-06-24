$j().ready(function(){
            
    $j("#confirmBetCancel").on("click", function(){
        betCancel_popup_close();
        location.href = "/race/betting_list";
    });

    var userMoney = setInterval(getUserInfo, 5000);

    $j("#confirm-yes").on("click", function(){
        confirm_popup_close();
        confirmBet();
    });

    $j("#confirm-no").on("click", function(){
        bettingSubmitFlag = 0;
        confirm_popup_close();
    });
    
    $j(".icon-close").on("click", function(){
        $j(".mask_layer").click();
    });
});

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

function warning_popup(text) {
    $j("#warning_popup .pop_message").text(text);
    $j("#warning_popup").fadeIn();
    $j("#coverBG").fadeIn();
    setTimeout(warning_popup_close, 1000);
}

function warning_popup_close() {
    $j("#warning_popup").fadeOut();
    $j("#coverBG").fadeOut();
}

function confirm_popup(text) {
    console.log(text);
    $j("#confirm_popup .pop_message").text(text);
    $j("#confirm_popup").slideDown('fast');
    $j("#coverBG").fadeIn('fast');
}

function confirm_popup_close() {
    $j("#confirm_popup").slideUp('fast');
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

function memo_popup(memoCnt) {
    var text = "읽지 못한 쪽지가 " + memoCnt + "개 있습니다.";
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

function loginEnter(e) {
    if ( e.keyCode == 13 ) {
        loginCheck();
    }
}

function check_pincode() {
    var pincode = $j('#pincode').val();
    if ( pincode.length < 1 ) {
        alert('가입인증코드를 입력하세요');
        $j('#pincode').focus();
        return false;
    } else {
        $j.ajaxSetup({async:false});
        var param={pin:pincode};

        $j.post("/member/pincodePopup", param, function(result) {
            if( $.trim(result) == "false" ) {
                $j("#pincode").focus();
                alert("존재하지 않거나, 제한된 가입인증코드 입니다.");
                return false;
            } else {
                document.next.submit();
            }
        });
    }
    return false;
}

function eng(obj) {
    var pattern = /[^(a-zA-Z0-9)]/; //영문만 허용
    if (pattern.test(obj.value)) {
        alert("영문과 숫자만 허용합니다!");
        obj.value = '';
        obj.focus();
        return false;
    }
}

function getUserInfo() {
    $j.ajaxSetup({async:true});

    $j.get("/member/getUserInfo", function(result) {
        var json = JSON.parse(result);
        if(json.length == 0) 
            return;
            
        $j(".member_inmoney").html(addCommas(json.member.g_money));

        if(json.memo > 0) {
            var url = window.location.href;
            if(url.indexOf('/member/memolist') == -1) {
                try { jBeep('/public/snd/msg_recv_alarm.mp3'); } catch(e) {};
                $j(".count01").text(json.memo);
                $j(".count02").text(json.memo);
                $j(".mask_layer").show();
                $j(".popup_message").show();
            }
        }
            

        if(json.member.bet_cancel_cnt > 0)
            betCancel_popup();
        // console.log(addCommas(result));
    });
}

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

/******************************************* Web Socket *******************************************/
const PACKET_SPORT_LIST = 0x01;
const PACKET_SPORT_BET = 0x02;
const PACKET_SPORT_AJAX = 0x03;
//Powerball
const PACKET_POWERBALL_TIME = 0x11;
const PACKET_POWERBALL_BET = 0x12;

//파워사다리
const PACKET_POWERLADDER_BET = 0x22;

//키노사다리
const PACKET_KENOLADDER_BET = 0x32;

var showJson;
var packet = {
    "m_strSports"   :   "",
    "m_nLeague"     :   0,
    "m_nLive"       :   0,
    "m_nPageIndex"  :   0,
    "m_nPageSize"   :   30
};

var ws = new WebSocket("ws://211.115.107.17:3002");

ws.onopen = function (event) {
    console.log("WebSocket Opened");
};

ws.onmessage = function (event) {
    try {
        var objPacket = JSON.parse(event.data);
        
        if(objPacket.m_nPacketCode == PACKET_SPORT_LIST) {
            console.log(objPacket);
            onRevGameList(objPacket.m_strPacket);
        }
        else if(objPacket.m_nPacketCode == PACKET_SPORT_BET) {
            onRecvBetting(objPacket);
        }
        else if(objPacket.m_nPacketCode == PACKET_SPORT_AJAX) {
            onRecvAjaxList(objPacket.m_strPacket);
        }
        else if(objPacket.m_nPacketCode == PACKET_POWERBALL_BET) {
            onRecvBetting(objPacket);
        }
        else if(objPacket.m_nPacketCode == PACKET_POWERLADDER_BET) {
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

function sendPacket(nPacketCode, strPacket) {
    var packet = {
        "m_nPacketCode"     :   nPacketCode,
        "m_strPacket"       :   strPacket
    };

    ws.send(JSON.stringify(packet));
}

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


function onSendReqListPacket(param) {
	console.log("Send initial packet");
	if(ws.readyState === WebSocket.OPEN) {
		onLoadingScreen();
		sendPacket(PACKET_SPORT_LIST, JSON.stringify(param));
	}
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
    }
    var findResult = details.filter(value => value.m_nMarket == findID);
   
    if(findResult.length > 0) {
        isExist12 = true;
    }

    return isExist12;
}

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
            marketArray = [52, 866, 1558, 2, 28, 202, 203, 204, 205, 206, 64, 65, 66, 67, 68, 21, 45, 46, 47, 101, 102, 5, 72, 73, 74, 75, 76, 6, 9, 100, 153, 154, 155, 156];
            break;
        case "야구":
            marketArray = [226, 342, 28, 220, 221, 235, 41, 42, 43, 44, 524, 281, 526, 21, 45, 46, 47, 48, 236, 525];
            break;
        case "아이스 하키":
            marketArray = [1, 226, 3, 342, 28, 7, 202, 41, 42, 43, 44, 64, 65, 66, 221, 220, 21, 45, 46, 51];
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
}

function appendCntInfo(sports, json, isOther = false) {
    //console.log(isOther);
    var div_id = `id_${sports}-${json.m_nCountry}`;
    var div_obj = document.getElementById(div_id);
    if(div_obj != null && div_obj != undefined) {
        document.getElementById(`id_${sports}-${json.m_nCountry}_value`).innerHTML = json.m_nCount;
        for(var j = 0; j < json.m_lstLeagueCnt.length; j++){
            var obj = document.getElementById(`id_${sports}-${json.m_nCountry}-${json.m_lstLeagueCnt[j].m_nLeague}_value`);
            if(obj == null || obj == undefined) {
                var div = "";
                if(isOther) {
                    div += `<li class="ss_bl1 li-bg" onClick="location.href='/game_list?game=abroad&league_sn=${json.m_lstLeagueCnt[j].m_nLeague}'">`;
                } else {
                    div += `<li class="ss_bl1 li-bg" onClick="onClickLeague('${json.m_lstLeagueCnt[j].m_nLeague}')">`;
                }
                div += '<a href="javascript:void(0)">';
                div += '<p class="txt_line1 _limit _w180 p-badge">' + json.m_lstLeagueCnt[j].m_strName + '</p>';
                div += `<span class="badge badge-info f_right _center w35 span-badge" id="id_${sports}-${json.m_nCountry}-${json.m_lstLeagueCnt[j].m_nLeague}">` + json.m_lstLeagueCnt[j].m_nCount + `</span>`;
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
                div += `<li class="ss_bl1 li-bg" onClick="location.href='/game_list?game=abroad&league_sn=${json.m_lstLeagueCnt[j].m_nLeague}'">`;
            } else {
                div += `<li class="ss_bl1 li-bg" onClick="onClickLeague('${json.m_lstLeagueCnt[j].m_nLeague}')">`;
            }
            div += '<a href="javascript:void(0)">';
            div += '<p class="txt_line1 _limit _w180 p-badge">' + json.m_lstLeagueCnt[j].m_strName + '</p>';
            div += `<span class="badge badge-info f_right _center w35 span-badge" id="id_${sports}-${json.m_nCountry}-${json.m_lstLeagueCnt[j].m_nLeague}_value">` + json.m_lstLeagueCnt[j].m_nCount + `</span>`;
            div += '</a>';
            div += '</li>';
        }
        div += '</ul>';
        div += `</div>`
        $j(`.div_${sports}`).append(div);
    }
}