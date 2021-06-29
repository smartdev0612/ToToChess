	//-> 파워볼 초기 게임시작날짜 초단위 (2010-11-22 04:28:00)
	//var powerStartTime = Number("1290562680000");
    //var powerStartTime = Number("1291270089000");
	var powerStartTime = Number("1293883474000");

	//-> 배팅마감시간 (경기시간 30초전)
	var endBettingTime = 60;

	var selectGameType = null;
	var selectGameRate = 0;
	var gameTh = 0;
	var gameDh = 0;

	var serverTime = null;
	var serverdate = null;
	var hour = null;
	var min = null;
	var sec = null;

	var limitMin = null;
	var limitSec = null;

	var postData;

	var bettingSubmitFlag = 0;

	var getResultFlag = 0;

	var gameTitleList = new Array();
	gameTitleList["n-oe-o"] = "일반볼(홀)";
	gameTitleList["n-oe-e"] = "일반볼(짝)";
	gameTitleList["p-oe-o"] = "파워볼(홀)";
	gameTitleList["p-oe-e"] = "파워볼(짝)";
	gameTitleList["n-uo-u"] = "일반볼(언)";
	gameTitleList["n-uo-o"] = "일반볼(오)";
	gameTitleList["p-uo-u"] = "파워볼(언)";
	gameTitleList["p-uo-o"] = "파워볼(오)";
	gameTitleList["n-bs-h"] = "일반볼(대)";
	gameTitleList["n-bs-d"] = "일반볼(중)";
	gameTitleList["n-bs-a"] = "일반볼(소)";
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
		return;
	}

	function addZero(str) {
		if ( String(str).length == 1 ) str = "0" + str;
		return str;
	}

	function realTime(strPacket) {
		strPacket = strPacket + "";
		var arrTime = strPacket.split('|');
		console.log(arrTime);
		yyyy = arrTime[0];
		mm = arrTime[1];
		dd = arrTime[2];
		hour = arrTime[3];
		min = arrTime[4];
		sec = arrTime[5];
		gameTh = arrTime[6];
		secTemp = arrTime[7];
		gameDh = arrTime[8];

		if(secTemp >= limit_time) {
			limitMin = parseInt((secTemp - limit_time) / 60);
			if(limitMin < 10)
				limitMin = "0" + limitMin; 
	
			limitSec = (secTemp - limit_time) % 60;
			if(limitSec < 10)
				limitSec = "0" + limitSec;
	
			$j(".gameDh").html(mm+"월 "+dd+"일 [" + (gameDh - 1) + "]회차");
			$j(".time_area").html(limitMin + ":" + limitSec);
		} else {
			$j(".time_area").html("00:00");
		}
				
		if ( secTemp < 60 ) {
			secTempMin = "00";
			secTempSec = addZero(secTemp);
		} else {
			secTempMin = addZero(Math.floor(secTemp / 60));
			secTempSec = addZero(secTemp - (secTempMin * 60));
		}
		
		if ( secTemp <= limit_time && secTemp >= 285 ) {
			$j("#viewGameTime").html("추첨중");
		} else {
			$j("#viewGameTime").html(secTempMin+":"+secTempSec);
		}
		
		//-> 배팅마감 블라인드
		if ( secTemp <= limit_time || secTemp >= 290) {
			$j("#betting_disable").show();
		} else {
			$j("#betting_disable").hide();
			
		}

		if(secTemp <= 290) {
			if(getResultFlag == 0) {
				getResultFlag = 1;
				getMiniGameResult();
			}
		} else {
			getResultFlag = 0;
		}
	}

	function getMiniGameResult() {
        $j.ajaxSetup({async:true});
        var param = { special_type : 7 };

        $j.get("/getMiniGameResult", param, function(result) {
            console.log(result);
            var json = JSON.parse(result);
            for(var i = 0; i < json.length; i++) {
                if(json[i]["result"] == 1) {
                    $j("#result_" + json[i]["betting_no"]).html("<span style='color:lightgreen;'>적중</span>");
                    $j("#resultMoney_" + json[i]["betting_no"]).html(addCommas(json[i]["bet_money"] * json[i]["select_rate"]));
                } else if(json[i]["result"] == 2) {
                    $j("#result_" + json[i]["betting_no"]).html("<span style='color:red;'>미적중</span>");
                    $j("#resultMoney_" + json[i]["betting_no"]).html("-" + addCommas(json[i]["bet_money"]));
                } else if(json[i]["result"] == 4) {
					$j("#resultMoney_" + json[i]["betting_no"]).html("-");
                    $j("#result_" + json[i]["betting_no"]).html("<font color='#f65555'>적특</font>");
                }
            }
        });
    }

	//-> 배팅금액선택
	function moneyPlus(amount) {
		if ( amount == "reset" ) {
			$j("#betMoney").val(0);
			//$j("#mulMoney").val(0);
		} else if ( amount == "all" ) {
			$j("#betMoney").val(MoneyFormat(VarMoney));
			//$j("#mulMoney").val(0);
		} else if ( amount == "ex" ) {

		} else {
			var this_money = $j("#betMoney").val().replace(/,/g,"");
			$j("#betMoney").val(MoneyFormat(Number(this_money) + Number(amount)));
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
		var this_money = $j("#betMoney").val().replace(/,/g,"");
		if ( parseInt(selectGameRate) > 0 && parseInt(this_money) > 0 ) {
			$j("#sp_total").html(MoneyFormat(Math.round(Number(this_money) * Number(selectGameRate))));
		} else {
			$j("#sp_total").html(0);
		}
	}

	function gameSelect(type, rate) {
		if($j(".btn_" + type).hasClass("on")) {
			$j(".btn_" + type).removeClass("on");
		} else {
			$j(".btnBet").removeClass("on");
			$j(".btn_" + type).addClass("on");
		}

		if ( selectGameType != type ) {
			//$j("img[id=gameSt_"+type+"]").attr('src',$j("img[id=gameSt_"+type+"]").attr("src").replace("_d.","_u."));
			selectGameType = type;
			selectGameRate = rate;
			$j("#sp_bet").html(rate);
			$j("#stGameRate").html(rate);
			$j("#stGameTitle").html(gameTitleList[type]);
		} else {
			selectGameType = null;
			selectGameRate = 0;
			$j("#sp_bet").html(rate);
			$j("#stGameRate").html("0.00");
			$j("#stGameTitle").html("선택하세요");
		}
		calHitMoney();
	}

	//-> 게임선택
	function gameSelect2(type, rate) {
		//-> 선택된 이미지 복원
		for ( i = 0 ; i < $j("img[id^='gameSt_']").length ; i++ ) {
			try {
				$j("img[id^='gameSt_']").eq(i).attr('src',$j("img[id^='gameSt_']").eq(i).attr("src").replace("_u.","_d."));
			} catch(e){};
		}

		if ( selectGameType != type ) {
			$j("img[id=gameSt_"+type+"]").attr('src',$j("img[id=gameSt_"+type+"]").attr("src").replace("_d.","_u."));
			selectGameType = type;
			selectGameRate = rate;
			$j("#stGameRate").html(rate);
			$j("#stGameTitle").html(gameTitleList[type]);
		} else {
			selectGameType = null;
			selectGameRate = 0;
			$j("#stGameRate").html("0.00");
			$j("#stGameTitle").html("선택하세요");
		}
		calHitMoney();
	}

	function gameBetting() {
		if ( Number(VarMaxBet) == 0 ) {
			warning_popup("유출픽 및 내부사정으로 배팅이 일시적 중단되었습니다.");
			return;
		}

		if ( selectGameType == null || selectGameRate == 0 ) {
			warning_popup("배팅하실 게임을 선택해주세요.");
			return;
		}

		var bet_money = $j("#betMoney").val().replace(/,/g,"");
		if ( Number(bet_money) < Number(VarMinBet) ) {
			warning_popup("최소 배팅금액은 "+MoneyFormat(VarMinBet)+"원 입니다.");
			return;
		}

		if ( Number(bet_money) > Number(VarMaxBet) ) {
			warning_popup("최대 배팅금액은 "+MoneyFormat(VarMaxBet)+"원 입니다.");
			return;
		}

		postData = {"btGameName":"powerball", "btGameTh":gameTh, "btMoney":bet_money, "btGameType":selectGameType, "member_sn": member_sn};
		
		if ( bettingSubmitFlag == 0 ) {
			bettingSubmitFlag = 1;
			confirm_popup("정말 배팅하시겠습니까?");
		} else {
			//warning_popup("배팅 처리중입니다. 잠시기다려주세요.\n\n장시간 응답이 없으면 F5를 눌러 새로고침 후 재배팅 부탁드립니다.");
		}
	}

	function confirmBet() {
		if(bettingSubmitFlag == 1) {
			bettingSubmitFlag = 0;
			$j("#stGameTitle").html("");
			$j("#sp_bet").html("");
			$j("#sp_total").html("0");
			$j("#betMoney").val("0");
			$j(".btnBet").removeClass("on");
			selectGameType = null;
			sendPacket(PACKET_POWERBALL_BET, JSON.stringify(postData));
		}
	}

	function onRecvBetting(objPacket) {
		bettingSubmitFlag = 0;
		warning_popup(objPacket.m_strPacket);
		reloadUserInfo();
		return;
	}

	function  reloadUserInfo() {
		$j.ajax({
			url : "/getRecentBettingList",
			type : "get",
			data: {game:game},
			success: function(res) {	
				$j("#tbody").html(res);
			},
			error: function(xhr,status,error) {
				var error = error;
			}
		});
	}

	function getPost(url, data) {
		var returnFlag = "처리중 오류가 발생 되었습니다. 관리자에게 문의해주세요.";

		$j.ajax({
			url : url,
			data : data,
			type : "post", 
			dataType : "json",
			async: false,
			success: function(res) {	
				if ( typeof(res) == "object" ) {
					if ( res.result == "ok" ) {
						returnFlag = res.result;
					} else {
						returnFlag = res.error_msg;
					}
				}
			},
			error: function(xhr,status,error) {
				var error = error;
			}
		});
		return returnFlag;
	}