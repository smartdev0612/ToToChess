	//-> 파워볼 초기 게임시작날짜 초단위 (2010-11-22 04:28:00)
	//var powerStartTime = Number("1290562680000");
    var powerStartTime = Number("1293883470000");

	//-> 배팅마감시간 (경기시간 30초전)
	var endBettingTime = 15;

	var selectGameType = null;
	var selectGameRate = 0;
	var gameTh = 0;

	var serverTime = null;
	var serverdate = null;
	var hour = null;
	var min = null;
	var sec = null;

	var gameTitleList = new Array();
	gameTitleList["n-oe-o"] = "일반볼(홀)";
	gameTitleList["n-oe-e"] = "일반볼(짝)";
	gameTitleList["p-oe-o"] = "파워볼(홀)";
	gameTitleList["p-oe-e"] = "파워볼(짝)";
	gameTitleList["n-bs-h"] = "일반볼(대)";
	gameTitleList["n-bs-d"] = "일반볼(중)";
	gameTitleList["n-bs-a"] = "일반볼(소)";
	gameTitleList["n-uo-u"] = "일반볼(언)";
	gameTitleList["n-uo-o"] = "일반볼(오)";
	gameTitleList["p-uo-u"] = "파워볼(언)";
	gameTitleList["p-uo-o"] = "파워볼(오)";
	gameTitleList["p_0"] = "파워볼(0)";
	gameTitleList["p_1"] = "파워볼(1)";
	gameTitleList["p_2"] = "파워볼(2)";
	gameTitleList["p_3"] = "파워볼(3)";
	gameTitleList["p_4"] = "파워볼(4)";
	gameTitleList["p_5"] = "파워볼(5)";
	gameTitleList["p_6"] = "파워볼(6)";
	gameTitleList["p_7"] = "파워볼(7)";
	gameTitleList["p_8"] = "파워볼(8)";
	gameTitleList["p_9"] = "파워볼(9)";
	gameTitleList["p_02"] = "파워볼(A)";
	gameTitleList["p_34"] = "파워볼(B)";
	gameTitleList["p_56"] = "파워볼(C)";
	gameTitleList["p_79"] = "파워볼(D)";
	gameTitleList["p_o-un"] = "파워볼(홀-언더)";
	gameTitleList["p_e-un"] = "파워볼(짝-언더)";
	gameTitleList["p_o-over"] = "파워볼(홀-오버)";
	gameTitleList["p_e-over"] = "파워볼(짝-오버)";
	gameTitleList["n_o-un"] = "일반볼(홀-언더)";
	gameTitleList["n_e-un"] = "일반볼(짝-언더)";
	gameTitleList["n_o-over"] = "일반볼(홀-오버)";
	gameTitleList["n_e-over"] = "일반볼(짝-오버)";

	function getServerTime() {
		$.ajax({
			url : "/getServerTime",
			type : "post",
			cache : false,
			async : false,
			timeout : 5000,
			scriptCharset : "utf-8",
			dataType : "json",
			success: function(res) {
				if ( typeof(res) == "object" ) {
					//-> 게임시간이 마감되면 다음게임을 불러오기 위해 reload 한다.(JS타임은 개인시간이라 사용불가)
					serverTime = res.h_time;
					serverTime = Number(serverTime) + 12000;
					if ( serverdate == null ) realTime();
				}
			},
			error: function(xhr,status,error) {
				alert("처리중 오류가 발생 되었습니다. 관리자에게 문의해주세요.");
			}	
		});

		// 업데이트 주기(5초)
		setTimeout(function(){
			getServerTime();
		},10000);
	}

	function addZero(str) {
		if ( String(str).length == 1 ) str = "0" + str;
		return str;
	}

	function realTime() {
		serverdate = new Date(Number(serverTime)); // Timestamp 값을 가진 
		mm = addZero(serverdate.getMonth() + 1);
		dd = addZero(serverdate.getDate());
		hour = addZero(serverdate.getHours());
		min = addZero(serverdate.getMinutes());
		sec = addZero(serverdate.getSeconds());

		$("#viewSysDate").html(mm+"월 "+dd+"일");
		$("#viewSysTime").html(hour+":"+min+":"+sec);
		
		//-> 회차 - 파워볼 초기시작날짜 - 현재날짜 / 300(5분)
		gameTh = Math.floor(((Number(serverTime) - Number(powerStartTime)) / 1000) / 300);
		$("#viewGameTh").html(gameTh);

		secTemp = (((Number(powerStartTime) + (((Number(gameTh)+1) * 300) * 1000))) - Number(serverTime)) / 1000;
		if ( secTemp < 60 ) {
			secTempMin = "00";
			secTempSec = addZero(secTemp);
		} else {
			secTempMin = addZero(Math.floor(secTemp / 60));
			secTempSec = addZero(secTemp - (secTempMin * 60));
		}

		if ( secTemp <= limit_time && secTemp >= 280 ) {
			$("#viewGameTime").html("추첨중");
		} else {
			$("#viewGameTime").html(secTempMin+":"+secTempSec);
		}

		//-> 배팅마감 블라인드
		if ( secTemp <= limit_time || secTemp >= 280) {
			$("#bettingShadow").show();
		} else {
			$("#bettingShadow").hide();
		}

		// 업데이트 주기(1초)
		setTimeout(function(){
			serverTime = Number(serverTime) + 1000;
			realTime();
		},1000);
	}

	//-> 배팅금액선택
	function moneyPlus(amount) {
		if ( amount == "reset" ) {
			$("#btMoney").val(0);
			$("#mulMoney").val(0);
		} else if ( amount == "all" ) {
			$("#btMoney").val(MoneyFormat(VarMoney));
			$("#mulMoney").val(0);
		} else if ( amount == "ex" ) {

		} else {
			var this_money = $("#btMoney").val().replace(/,/g,"");
			$("#btMoney").val(MoneyFormat(Number(this_money) + Number(amount)));
		}
		calHitMoney();
	}

	//-> 배팅금액수동입력
	function moneyPlusManual(amount) {
		this_money = amount.replace(/,/g,"");
		$("#btMoney").val(MoneyFormat(this_money));
		$("#mulMoney").val(MoneyFormat(this_money));
		calHitMoney();
	}

	//-> 적중금액 계산
	function calHitMoney() {
		var this_money = $("#btMoney").val().replace(/,/g,"");
		if ( parseInt(selectGameRate) > 0 && parseInt(this_money) > 0 ) {
			$("#hitMoney").val(MoneyFormat(Math.round(Number(this_money) * Number(selectGameRate))));
		} else {
			$("#hitMoney").val(0);
		}
	}

	//-> 게임선택
	function gameSelect(type, rate) {
		//-> 선택된 이미지 복원
		for ( i = 0 ; i < $("input[id^='gameSt_']").length ; i++ ) {
			try {
				$("input[id^='gameSt_']").eq(i).removeClass('powerball_focus');
			} catch(e){};
		}

		if ( selectGameType != type ) {
			$("input[id=gameSt_"+type+"]").addClass('powerball_focus');
			selectGameType = type;
			selectGameRate = rate;
			$("#stGameRate").html(rate);
			$("#stGameTitle").html(gameTitleList[type]);
		} else {
			selectGameType = null;
			selectGameRate = 0;
			$("#stGameRate").html("0.00");
			$("#stGameTitle").html("");
		}
		calHitMoney();
	}

	var bettingSubmitFlag = 0;
	function gameBetting() {
		if ( Number(VarMaxBet) == 0 ) {
			alert("유출픽 및 내부사정으로 배팅이 일시적 중단되었습니다.");
			return;
		}

		if ( selectGameType == null || selectGameRate == 0 ) {
			alert("배팅하실 게임을 선택해주세요.");
			return;
		}

		var bet_money = $("#btMoney").val().replace(/,/g,"");
		if ( Number(bet_money) < Number(VarMinBet) ) {
			alert("최소 배팅금액은 "+MoneyFormat(VarMinBet)+"원 입니다.");
			return;
		}

		if ( Number(bet_money) > Number(VarMaxBet) ) {
			alert("최대 배팅금액은 "+MoneyFormat(VarMaxBet)+"원 입니다.");
			return;
		}

		var postData = {"btGameName":"powerball", "btGameTh":gameTh, "btMoney":bet_money, "btGameType":selectGameType};
		if ( bettingSubmitFlag == 0 ) {
			bettingSubmitFlag = 1;
			gameMake = getPost("/RaceNewMini/gameCheckProcess", postData);
			if ( gameMake == "ok" ) {
				if( confirm("정말 배팅하시겠습니까?") ) {
					gameBetting = getPost("/RaceNewMini/raceBettingProcess", postData);
					if ( gameBetting == "ok" ) {
						alert("배팅이 완료되었습니다.");
						top.location.reload();
					} else {
						alert(gameBetting);							
					}
				}
			} else {
				alert(gameMake);							
			}
		} else {
			alert("배팅 처리중입니다. 잠시기다려주세요.\n\n장시간 응답이 없으면 F5를 눌러 새로고침 후 재배팅 부탁드립니다.");
		}
	}

	function getPost(url, data) {
		var returnFlag = "처리중 오류가 발생 되었습니다. 관리자에게 문의해주세요.";

		$.ajax({
			url : url,
			data : data,
			type : "post", cache : false, async	: false, timeout : 10000, scriptCharset : "utf-8", dataType : "json",
			success: function(res) {			
				if ( typeof(res) == "object" ) {
					if ( res.result == "ok" ) {
						returnFlag = res.result;
					} else {
						returnFlag = res.error_msg;
					}
				}
			},
			error: function(xhr,status,error) {}	
		});

		bettingSubmitFlag = 0;
		return returnFlag;
	}