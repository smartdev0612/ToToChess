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

	var postData;

	var bettingSubmitFlag = 0;

	var getResultFlag = 0;

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
		yyyy = arrTime[0];
		mm = arrTime[1];
		dd = arrTime[2];
		hour = arrTime[3];
		min = arrTime[4];
		sec = arrTime[5];

		$j("#viewSysDate").html(mm+"월 "+dd+"일");
		$j("#viewSysTime").html(hour+":"+min+":"+sec);
		
		secTemp = ((Number(hour) * 60) * 60) + (Number(min) * 60) + Number(sec);
		gameTh = Math.floor(secTemp / 300) + 1;
		$j("#viewGameTh").html(gameTh);

		secTemp = (gameTh * 300) - secTemp + 30;
		if ( secTemp < 60 ) {
			secTempMin = "00";
			secTempSec = addZero(secTemp);
		} else {
			secTempMin = addZero(Math.floor(secTemp / 60));
			secTempSec = addZero(secTemp - (secTempMin * 60));
		}
		
		if ( secTemp <= limit_time && secTemp >= 290 ) {
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
				console.log(secTemp);
				getMiniGameResult();
			}
		} else {
			getResultFlag = 0;
		}
	}

	function getMiniGameResult() {
        $j.ajaxSetup({async:false});
        var param = { special_type : 24 };

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
                    $j("#result_" + json[i]["betting_no"]).html("<font color='#f65555'>적특</font>");
					$j("#resultMoney_" + json[i]["betting_no"]).html("-");
                }
            }
        });
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
	var saveGameType = "odd";
	function gameSelect(type, rate) {
		if($j(".btn_" + type).hasClass("on")) {
			$j(".btn_" + type).removeClass("on");
		} else {
			$j(".btnBet").removeClass("on");
			$j(".btn_" + type).addClass("on");
		}

		if ( selectGameType != type ) {
			$j("#gameSt_"+saveGameType).removeClass('focus_'+saveGameType);
			$j("input[id=gameSt_"+type+"]").addClass('focus_'+type);
			selectGameType = type;
			selectGameRate = rate;
			$j("#stGameRate").html(rate);
			switch(type) {
				case "odd":
					$j("#stGameIcon").html("홀");
					break;
				case "even":
					$j("#stGameIcon").html("짝");
					break;
				case "left":
					$j("#stGameIcon").html("좌");
					break;
				case "right":
					$j("#stGameIcon").html("우");
					break;
				case "3line":
					$j("#stGameIcon").html("3줄");
					break;
				case "4line":
					$j("#stGameIcon").html("4줄");
					break;
				case "even3line_left":
					$j("#stGameIcon").html("짝좌3줄");
					break;
				case "odd4line_left":
					$j("#stGameIcon").html("홀좌4줄");
					break;
				case "odd3line_right":
					$j("#stGameIcon").html("홀우3줄");
					break;
				case "even4line_right":
					$j("#stGameIcon").html("짝우4줄");
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

		postData = {"btGameName":"kenosadari", "btGameTh":gameTh, "btMoney":bet_money, "btGameType":selectGameType, "member_sn": member_sn};
		if ( bettingSubmitFlag == 0 ) {
			bettingSubmitFlag = 1;
			confirm_popup("정말 배팅하시겠습니까?");
		} else {
			warning_popup("배팅 처리중입니다. 잠시기다려주세요.\n\n장시간 응답이 없으면 F5를 눌러 새로고침 후 재배팅 부탁드립니다.");
		}
	}

	function confirmBet() {
		if(bettingSubmitFlag == 1) {
			bettingSubmitFlag = 0;
			$j("#stGameIcon").html("");
			$j("#stGameRate").html("");
			$j("#hitMoney").html("0");
			$j("#btMoney").val("0");
			$j(".btnBet").removeClass("on");
			sendPacket(PACKET_KENOLADDER_BET, JSON.stringify(postData));
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
			dataType : "json",
			data: {game:game},
			success: function(json) {	
				console.log(json);
				var tr = "";
				var forCnt = 0;
				for (const [key, value] of Object.entries(json)) {
					var bettingNo = value.betting_no;
					var bettingRate = value.result_rate;
					var bettingMoney = value.betting_money;
					var betDay = value.bet_date.substring(5,10);
					var betTime = value.bet_date.substring(11,19);
					var items = value.item;
					forCnt++;
					for(const [k, item] of Object.entries(items)) {
						var gameCode = item.game_code;
						var gameTh = item.game_th;
						var tempDate = item.gameDate.substring(5,10);
						var bettingDate = tempDate.replace("-", "월") + "일";
						var bettingResult = "";
						var resultMoney = "";
						var gameName = "";
						var select_val = "";
						if ( item.home_rate < 1.1 && item.draw_rate < 1.1 && item.away_rate < 1.1  ) {
							resultMoney = "-";
							bettingResult = "<font color='#f65555'>적특</font>";
						} else {
							resultMoney = "-";
							if ( item.result == 1 ) {
								bettingResult = "<span style='color: lightgreen;'>적중</span>";
								resultMoney = "<span class=\"new_betting_ok\">" + addCommas(bettingMoney * bettingRate) + "</span>";
							} else if ( item.result == 2 ) {
								bettingResult = "<span style='color: red;'>미적중</span>";
								resultMoney = "<span class=\"new_betting_no\">-" + addCommas(bettingMoney) + "</span>";
							} else if ( item.result == 4 ) {
								bettingResult = "적특";	
							} else {
								bettingResult = "진행중";
							}
						}

						if ( gameCode == "ks_oe" ) {
							gameName = "홀/짝";
							if ( item.select_no == 1 ) {
								select_val = "<img src=\"/images/mybet_odd.png\">";
							} else {
								select_val = "<img src=\"/images/mybet_even.png\">";
							}
						} else if ( gameCode == "ks_lr" ) {
							gameName = "좌/우";
							if ( item.select_no == 1 ) {
								select_val = "<img src=\"/images/mybet_left.png\">";
							} else {
								select_val = "<img src=\"/images/mybet_right.png\">";
							}
						} else if ( gameCode == "ks_34" ) {
							gameName = "3줄/4줄";
							if ( item.select_no == 1 ) {
								select_val = "<img src=\"/images/mybet_3line.png\">";
							} else {
								select_val = "<img src=\"/images/mybet_4line.png\">";
							}
						} else if ( gameCode == "ks_e3o4l" ) {
							gameName = "짝좌3줄/홀좌4줄";
							if ( item.select_no == 1 ) {
								select_val = "<img src=\"/images/mybet_even3line_left.png\">";
							} else {
								select_val = "<img src=\"/images/mybet_odd4line_left.png\">";
							}
						} else if ( gameCode == "ks_o3e4r" ) {
							gameName = "홀우3줄/짝우4줄";
							if ( item.select_no == 1 ) {
								select_val = "<img src=\"/images/mybet_odd3line_right.png\">";
							} else {
								select_val = "<img src=\"/images/mybet_even4line_right.png\">";
							}
						}

						var btNo = forCnt;
						tr += "<tr>";
						tr += "<td>" + btNo + "</td>";
						tr += "<td style=\"font-weight:bold;\">" + bettingDate + "<br />[" + gameTh + "회차]</td>";
						tr += "<td>" + betDay + "<br />" + betTime + "</td>";
						tr += "<td style=\"font-weight:bold;\">" + gameName + "</td>";
						tr += "<td>" + select_val + "</td>";
						tr += "<td>" + bettingRate + "</td>";
						tr += "<td>" + addCommas(bettingMoney) + "</td>";
						tr += "<td class=\"new_betting_no\" id='resultMoney_" + bettingNo + "'>" + resultMoney + "</td>";
						tr += "<td id='result_" + bettingNo + "'>" + bettingResult + "</td>";
						tr += "</tr>";
					}
				}
				$j("#tbody").html(tr);
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
			type : "post", cache : false, async	: false, timeout : 10000, scriptCharset : "utf-8", dataType : "json",
			success: function(res) {	
				$j("#loading").fadeOut();
                $j("#coverBG2").fadeOut();		
				if ( typeof(res) == "object" ) {
					if ( res.result == "ok" ) {
						returnFlag = res.result;
					} else {
						returnFlag = res.error_msg;
					}
				}
			},
			error: function(xhr,status,error) {
				$j("#loading").fadeOut();
                $j("#coverBG2").fadeOut();
				var err = error;
				err = 1;
			}	
		});
		return returnFlag;
	}