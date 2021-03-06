	//-> 배팅마감시간 (경기시간 30초전)
	var endBettingTime = 30;

	var selectGameType = null;
	var selectGameRate = 0;
	var gameTh = 0;

	var serverTime = null;
	var serverdate = null;
	var yyyy = null;
	var mm = null;
	var dd = null;
	var hour = null;
	var min = null;
	var sec = null;

	var gameTitleList = new Array();
	gameTitleList["1w-n"] = "1게임 1등 맞추기 – 네팽이";
	gameTitleList["1w-e"] = "1게임 1등 맞추기 - 임팽이";
	gameTitleList["1w-d"] = "1게임 1등 맞추기 - 드팽이";
	gameTitleList["1w2d3l-n"] = "2게임 삼치기 - 네팽이";
	gameTitleList["1w2d3l-e"] = "2게임 삼치기 – 임팽이";
	gameTitleList["1w2d3l-d"] = "2게임 삼치기 – 드팽이";
	gameTitleList["1w2w3l-n"] = "3게임 꼴등피하기 - 네팽이";
	gameTitleList["1w2w3l-e"] = "3게임 꼴등피하기 - 임팽이";
	gameTitleList["1w2w3l-d"] = "3게임 꼴등피하기 – 드팽이";
	gameTitleList["ned"] = "4게임 순위 맞추기 - 네임드";
	gameTitleList["nde"] = "4게임 순위 맞추기 - 네드임";
	gameTitleList["end"] = "4게임 순위 맞추기 - 임네드";
	gameTitleList["edn"] = "4게임 순위 맞추기 - 임드네";
	gameTitleList["dne"] = "4게임 순위 맞추기 - 드네임";
	gameTitleList["den"] = "4게임 순위 맞추기 - 드임네";

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
		yyyy = serverdate.getFullYear();
		mm = addZero(serverdate.getMonth() + 1);
		dd = addZero(serverdate.getDate());
		hour = addZero(serverdate.getHours());
		min = addZero(serverdate.getMinutes());
		sec = addZero(serverdate.getSeconds());

		$("#viewSysDate").html(mm+"월 "+dd+"일");
		$("#viewSysTime").html(hour+":"+min+":"+sec);
		
		secTemp = ((Number(hour) * 60) * 60) + (Number(min) * 60) + Number(sec);
		gameTh = Math.floor(secTemp / 180) + 1;
		$("#viewGameTh").html(gameTh);

		secTemp = (gameTh * 180) - secTemp;
		if ( secTemp < 60 ) {
			secTempMin = "00";
			secTempSec = addZero(secTemp);
		} else {
			secTempMin = addZero(Math.floor(secTemp / 60));
			secTempSec = addZero(secTemp - (secTempMin * 60));
		}

		if ( secTemp <= limit_time && secTemp >= 170 ) {
			$("#viewGameTime").html("추첨중");
		} else {
			$("#viewGameTime").html(secTempMin+":"+secTempSec);
		}

		//-> 배팅마감 블라인limit_time
		if ( secTemp <= limit_time || secTemp >= 170) {
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
				$("input[id^='gameSt_']").eq(i).removeClass('race_focus');
			} catch(e){};
		}

		if ( selectGameType != type ) {
			$("input[id=gameSt_"+type+"]").addClass('race_focus');
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

		var postData = {"btGameName":"race", "btGameTh":gameTh, "btMoney":bet_money, "btGameType":selectGameType};
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