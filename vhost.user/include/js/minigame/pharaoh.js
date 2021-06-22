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

	function getServerTime() {
		$j.ajax({
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
					//serverTime = Number(serverTime) + 6000;
					if ( serverdate == null ) realTime();
				}
			},
			error: function(xhr,status,error) {
				warning_popup("처리중 오류가 발생 되었습니다. 관리자에게 문의해주세요.");
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
		/*serverdate = new Date(Number(serverTime)); // Timestamp 값을 가진
		yyyy = serverdate.getFullYear();
		mm = addZero(serverdate.getMonth() + 1);
		dd = addZero(serverdate.getDate());
		hour = addZero(serverdate.getHours());
		min = addZero(serverdate.getMinutes());
		sec = addZero(serverdate.getSeconds());*/
		serverdate = new Date(Number(serverTime)); // Timestamp 값을 가진
		serverdate = serverdate.toLocaleString('en-US', { timeZone: 'Asia/Seoul', hour12: false });
		nowTemp = serverdate.split(", ");
		dateTemp = nowTemp[0].split("/");
		timeTemp = nowTemp[1].split(":");
		yyyy = dateTemp[2];
		mm = addZero(dateTemp[0]);
		dd = addZero(dateTemp[1]);
		hour = addZero(timeTemp[0]);
		min = addZero(timeTemp[1]);
		sec = addZero(timeTemp[2]);

		$j("#viewSysDate").html(mm+"월 "+dd+"일");
		$j("#viewSysTime").html(hour+":"+min+":"+sec);
		
		secTemp = ((Number(hour) * 60) * 60) + (Number(min) * 60) + Number(sec);
		gameTh = Math.floor(secTemp / 120) + 1;
		$j("#viewGameTh").html(gameTh);

		secTemp = (gameTh * 120) - secTemp;
		if ( secTemp < 60 ) {
			secTempMin = "00";
			secTempSec = addZero(secTemp);
		} else {
			secTempMin = addZero(Math.floor(secTemp / 60));
			secTempSec = addZero(secTemp - (secTempMin * 60));
		}

		if ( secTemp <= limit_time && secTemp >= 110 ) {
			$j("#viewGameTime").html("추첨중");
		} else {
			$j("#viewGameTime").html(secTempMin+":"+secTempSec);
		}

		//-> 배팅마감 블라인드
		if ( secTemp <= limit_time || secTemp >= 110) {
			$j("#betting_disable").show();
		} else {
			$j("#betting_disable").hide();
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
			$j("#btMoney").val(0);
			$j("#mulMoney").val(0);
		} else if ( amount == "all" ) {
			$j("#btMoney").val(MoneyFormat(VarMoney));
			$j("#mulMoney").val(0);
		} else if ( amount == "ex" ) {

		} else {
			var this_money = $j("#btMoney").val().replace(/,/g,"");
			$j("#btMoney").val(MoneyFormat(Number(this_money) + Number(amount)));
		}
		calHitMoney();
	}

	//-> 배팅금액수동입력
	function moneyPlusManual(amount) {
		this_money = amount.replace(/,/g,"");
		$j("#btMoney").val(MoneyFormat(this_money));
		$j("#mulMoney").val(MoneyFormat(this_money));
		calHitMoney();
	}

	//-> 적중금액 계산
	function calHitMoney() {
		var this_money = $j("#btMoney").val().replace(/,/g,"");
		if ( parseInt(selectGameRate) > 0 && parseInt(this_money) > 0 ) {
			$j("#hitMoney").html(MoneyFormat(Math.round(Number(this_money) * Number(selectGameRate))));
		} else {
			$j("#hitMoney").html(0);
		}
	}

	//-> 게임선택
	var saveGameType = "black";
	function gameSelect(type, rate) {
		if ( selectGameType != type ) {
			$j("#gameSt_"+saveGameType).removeClass('focus_'+saveGameType);
			$j("input[id=gameSt_"+type+"]").addClass('focus_'+type);
			selectGameType = type;
			selectGameRate = rate;
			$j("#stGameRate").html(rate);
			switch(type) {
				case "heart":
					$j("#stGameIcon").html("Heart");
					break;
				case "spade":
					$j("#stGameIcon").html("Spade");
					break;
			}
			saveGameType = type;
		} else {
			selectGameType = null;
			selectGameRate = 0;
			$j("#stGameRate").html("0.00");
			$j("#stGameIcon").html("선택하세요");
			$j("#gameSt_"+type).removeClass('focus_'+saveGameType);
		}
		calHitMoney();
	}

	var bettingSubmitFlag = 0;
	function gameBetting() {
		if ( Number(VarMaxBet) == 0 ) {
			warning_popup("서비스 점검으로 인하여 배팅이 중단되었습니다.");
			return;
		}

		if ( selectGameType == null || selectGameRate == 0 ) {
			warning_popup("배팅하실 게임을 선택해주세요.");
			return;
		}

		var bet_money = $j("#btMoney").val().replace(/,/g,"");
		if ( Number(bet_money) < Number(VarMinBet) ) {
			warning_popup("최소 배팅금액은 "+MoneyFormat(VarMinBet)+"원 입니다.");
			return;
		}

		if ( Number(bet_money) > Number(VarMaxBet) ) {
			warning_popup("최대 배팅금액은 "+MoneyFormat(VarMaxBet)+"원 입니다.");
			return;
		}

		var postData = {"btGameName":"pharaoh", "btGameTh":gameTh, "btMoney":bet_money, "btGameType":selectGameType};
		if ( bettingSubmitFlag == 0 ) {
			bettingSubmitFlag = 1;
			gameMake = getPost("/RaceNewMini/gameCheckProcess", postData);
			if ( gameMake == "ok" ) {
				if( confirm("정말 배팅하시겠습니까?") ) {
					result_gameBetting = getPost("/RaceNewMini/raceBettingProcess", postData);
					if ( result_gameBetting == "ok" ) {
						warning_popup("배팅이 완료되었습니다.");
						top.location.reload();
					} else {
						warning_popup(result_gameBetting);							
					}
				}
			} else {
				warning_popup(gameMake);							
			}
		} else {
			warning_popup("배팅 처리중입니다. 잠시기다려주세요.\n\n장시간 응답이 없으면 F5를 눌러 새로고침 후 재배팅 부탁드립니다.");
		}
	}

	function getPost(url, data) {
		var returnFlag = "처리중 오류가 발생 되었습니다. 관리자에게 문의해주세요.";

		$j.ajax({
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