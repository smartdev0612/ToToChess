	<?php
class RaceReal20Controller extends WebServiceController 
{
	public function indexAction($id='') {
		exit;
	}

	public function raceBettingProcessAction() {
		$this->req->xssClean();		
		if ( !$this->auth->isLogin() ) {
			$this->loginAction();
			exit;
		}

		$ajaxResult = array();
		$ajaxResult["result"]	= "error";

		$user_sn = $this->auth->getSn();
		$user_id = $this->auth->getId();

		$memberModel = $this->getModel('MemberModel');
		$configModel = $this->getModel('ConfigModel');
		$gameModel = $this->getModel('GameModel');
		$cartModel = $this->getModel('CartModel');
		$processModel = $this->getModel('ProcessModel');

		//-> 유저 정보
		$user_info = $memberModel->getMemberRow($user_sn);
		$user_recommend_sn = $user_info['recommend_sn'];
		$user_rolling_sn = $user_info['rolling_sn'];
		$user_sessionid = $user_info["sessionid"];
		if ( $this->auth->getState() == "G" ) $user_account_enable = 0;
		else $user_account_enable = 1;

		//-> 로그인 체크.
		if ( $user_sessionid != session_id() ) {
			if ( $this->auth->isLogin() ) {
				session_destroy();
			}
			echo json_encode(array("error_msg"=>"다시 로그인 하신후 배팅하여 주십시오."));
			exit;
		}

		$btGameTh = $_POST["btGameTh"];					//-> 배팅게임회차
		$btMoney = $_POST["btMoney"];						//-> 배팅금액
		$btGameTypeList = $_POST["btGameType"];	//-> 배팅게임타입 (array)
		if ( !$btGameTh or !$btMoney or !count((array)$btGameTypeList) ) {
			echo json_encode(array("error_msg"=>"처리에 필요한 데이터가 부족합니다."));
			exit;
		}

		//-> 보유머니 체크.
		$user_g_money = $memberModel->getMemberField($user_sn,'g_money')+0;
		if ( $user_g_money < $btMoney ) {
			echo json_encode(array("error_msg"=>"보유머니가 부족합니다."));
			exit;
		}

		//-> 실시간 게임 정보를 가져와서 확인.
		$lastGameInfo = $this->getLastGameInfo();

		if ( !count($lastGameInfo) or !$lastGameInfo["gameTh"] ) {
			echo json_encode(array("error_msg"=>"최근 경기정보를 찾을 수 없습니다."));
			exit;
		}
		if ( $lastGameInfo["gameTh"] != $btGameTh ) {
			echo json_encode(array("error_msg"=>"현재 회차 정보가 틀립니다."));
			exit;
		}
		if ( $lastGameInfo["gameStatus"] != 1 ) {
			echo json_encode(array("error_msg"=>"현재 배팅이 불가능합니다."));
			exit;
		}

		//-> 게임타입 및 코드를 확인하고 최종 배당을 계산한다.
		$btRateTotal = 1;
		for ( $i = 0 ; $i < count((array)$btGameTypeList) ; $i++ ) {			
			$btType = $btGameTypeList[$i];
			$btGameCode = $this->getGameInfo($btType,"code");
			if ( !$btGameCode ) {
				echo json_encode(array("error_msg"=>"배팅 게임코드를 찾을 수 없습니다. [{$btType}]"));
				exit;
			}

			$btRate = $this->getGameInfo($btType,"rate");
			$btRateTotal = $btRateTotal * $btRate;

			//-> 멀티 배팅이라면 1,2,3게임만 서로 조합이 가능.
			if ( count((array)$btGameTypeList) > 1 ) {
				if ( $btGameCode != "g_oe" and $btGameCode != "g_unover" and $btGameCode != "g_winner" ) {
					echo json_encode(array("error_msg"=>"조합가능한 배팅 정보가 아닙니다."));
					exit;
				}
			}
		}
		$btRateTotal = sprintf("%2.2f",$btRateTotal);

		//-> 배팅금액 제한체크.
		$user_level = $memberModel->getMemberField($user_sn,'mem_lev')+0;
		$betConfigInfoArr = $configModel->getMiniGameLevelConfigRows("*","user_level='{$user_level}' ");
		$minBetMoney = $betConfigInfoArr[0]["real20_min_bet"];
		$maxBetMoney = $betConfigInfoArr[0]["real20_max_bet"];
		$maxBnsMoney = $betConfigInfoArr[0]["real20_max_bns"];

		if ( $btMoney < $minBetMoney ) {
			echo json_encode(array("error_msg"=>"최소배팅금은 ".number_format($minBetMoney)."원 입니다."));
			exit;
		}
		if ( $btMoney > $maxBetMoney ) {
			echo json_encode(array("error_msg"=>"최대배팅금은 ".number_format($maxBetMoney)."원 입니다."));
			exit;
		}
		$bettingBonusMoney = $btMoney * $btRateTotal;
		if ( $bettingBonusMoney > $maxBnsMoney ) {
			echo json_encode(array("error_msg"=>"적중금액은 최대 ".number_format($maxBnsMoney)."원을 넘을 수 없습니다."));
			exit;
		}

		//-> 경기가 존재 하는지 + 배팅시간 체크. (70초)
		for ( $i = 0 ; $i < count((array)$btGameTypeList) ; $i++ ) {
			$btType = $btGameTypeList[$i];
			$btGameCode = $this->getGameInfo($btType,"code");

			//-> 해당경기가 DB에 있는지 확인. (게임날짜+게임코드+회차로 확인)
			$btGameDate = $lastGameInfo["gameYmd"];
			$gameInfo = $gameModel->getMinigameInfo($btGameDate, $btGameCode, $btGameTh);
			if ( !$gameInfo ) {
				echo json_encode(array("error_msg"=>"게임을 찾을 수 없습니다. 관리자에게 문의해주세요. [{$btGameCode}]"));
				exit;
			}

			$child_sn = $gameInfo[0]["child_sn"];
			$gameDate = $gameInfo[0]["gameDate"];
			$gameHour = $gameInfo[0]["gameHour"];
			$gameTime = $gameInfo[0]["gameTime"];
			$gameSecond = $lastGameInfo["gameS"];	//-> 초는 DB에 없기에 API쪽에서 가져옴.
			$addSecond = $lastGameInfo["addTime"]; //-> 게임중지->재시작으로 인한 딜래이 시간.

			$nowTime = date("Y-m-d H:i:s",time());
			$gameStartTime = trim($gameDate) ." ". trim($gameHour) .":". trim($gameTime).":".$gameSecond;
			$limitTime = strtotime($gameStartTime) - strtotime($nowTime);
			$limitTimeCk = strtotime($nowTime) - strtotime($gameStartTime);

			//-> 경기시작전 배팅 불가.
			if ( $limitTime > 10 ) {
				echo json_encode(array("error_msg"=>"배팅시간 오류가 발생되었습니다. 관리자에게 문의해주세요. [".strtotime($gameStartTime)."][".strtotime($nowTime)."]"));
				exit;
			}
			//-> 경기시작후 95초 이상 배팅 불가.
			if ( $limitTimeCk > (95 + $addSecond) ) {
				echo json_encode(array("error_msg"=>"배팅시간이 마감되었습니다."));
				exit;
			}

			//-> 동일회차 배팅 1회만 허용.
			$uniqueBettingFolder = $cartModel->getCartFolder($child_sn, $user_sn, 7);
			if ( $uniqueBettingFolder >= 1 ) {
				echo json_encode(array("error_msg"=>"동일회차 배팅은 최대 1회 가능합니다."));
				exit;
			}
		}

		//-> 구매코드생성
		$lastCartIdx = $cartModel->getLastCartIndex();
		$protoId = time() - strtotime("2000-01-01")+(9*60*60);
		$protoId = $protoId + $lastCartIdx;
		if ( !$protoId ) {
			echo json_encode(array("error_msg"=>"구매번호 생성에 실패 했습니다."));
			exit;
		}
		$protoId = $user_sn.$protoId;

		//-> 배팅정보 Insert
		for ( $i = 0 ; $i < count((array)$btGameTypeList) ; $i++ ) {
			$btType = $btGameTypeList[$i];
			$btGameCode = $this->getGameInfo($btType,"code");
			$btRate = $this->getGameInfo($btType,"rate");
			$btGameDate = $lastGameInfo["gameYmd"];
			$selectTeam = $this->getGameInfo($btType, "selectNo");

			//-> 배팅 게임 정보
			$gameInfo = $gameModel->getMinigameInfo($btGameDate, $btGameCode, $btGameTh);			
			$child_sn = $gameInfo[0]["child_sn"];
			$subchild_sn = $gameInfo[0]["subchild_sn"];
			$kubun = $gameInfo[0]["kubun"];
			$gameDate = $gameInfo[0]["gameDate"];
			$gameHour = $gameInfo[0]["gameHour"];
			$gameTime = $gameInfo[0]["gameTime"];
			$home_rate = $gameInfo[0]["home_rate"];
			$away_rate = $gameInfo[0]["away_rate"];
			$draw_rate = $gameInfo[0]["draw_rate"];

			//-> 배팅정보에 입력 (tb_game_betting)
			$cartModel->addBet($user_sn, $child_sn, $subchild_sn, $protoId, $selectTeam, $home_rate, $draw_rate, $away_rate, $btRate, 1, "Y", $btMoney);
		}

		//-> 배팅개수.
		$betting_cnt = count((array)$btGameTypeList);
		$cartModel->addCart($user_sn, 0, $protoId, "Y", $betting_cnt, $user_g_money, $btMoney, $btRateTotal, $user_recommend_sn, $user_rolling_sn, $user_account_enable, '', 7);

		//-> 보유머니 차감 및 로그.
		$processModel->bettingProcess($user_sn, $btMoney);

		//-> 배팅 알람 업데이트.
		if ( $btMoney >= 300000 ) {
			$configModel->modifyAlramFlag("betting_real20_big",1);
		} else {
			$configModel->modifyAlramFlag("betting_real20",1);
		}

		//-> 배팅완료.
		echo json_encode(array("result"=>"ok"));
		exit;
	}

	//-> 게임 생성.
	public function gameCheckProcessAction() {
		$this->req->xssClean();		
		if ( !$this->auth->isLogin() ) {
			$this->loginAction();
			exit;
		}

		$ajaxResult = array();
		$ajaxResult["result"]	= "error";

		$user_sn = $this->auth->getSn();
		$user_id = $this->auth->getId();

		$memberModel = $this->getModel('MemberModel');
		$configModel = $this->getModel('ConfigModel');
		$gameModel = $this->getModel('GameModel');
		$cartModel = $this->getModel('CartModel');
		$processModel = $this->getModel('ProcessModel');

		//-> 유저 정보
		$user_info = $memberModel->getMemberRow($user_sn);
		$user_recommend_sn = $user_info['recommend_sn'];
		$user_rolling_sn = $user_info['rolling_sn'];
		$user_sessionid = $user_info["sessionid"];
		if ( $this->auth->getState() == "G" ) $user_account_enable = 0;
		else $user_account_enable = 1;

		//-> 로그인 체크.
		if ( $user_sessionid != session_id() ) {
			if ( $this->auth->isLogin() ) {
				session_destroy();
			}
			echo json_encode(array("error_msg"=>"다시 로그인 하신후 배팅하여 주십시오."));
			exit;
		}

		$btGameTh = $_POST["btGameTh"];					//-> 배팅게임회차
		$btMoney = $_POST["btMoney"];						//-> 배팅금액
		$btGameTypeList = $_POST["btGameType"];	//-> 배팅게임타입 (array)
		if ( !$btGameTh or !count((array)$btGameTypeList) ) {
			echo json_encode(array("error_msg"=>"처리에 필요한 데이터가 부족합니다."));
			exit;
		}

		$lastGameInfo = $this->getLastGameInfo();

		if ( !count($lastGameInfo) or !$lastGameInfo["gameTh"] ) {
			echo json_encode(array("error_msg"=>"최근 경기정보를 찾을 수 없습니다."));
			exit;
		}
		if ( $lastGameInfo["gameTh"] != $btGameTh ) {
			echo json_encode(array("error_msg"=>"현재 회차 정보가 틀립니다. [".$btGameTh."]"));
			exit;
		}
		if ( $lastGameInfo["gameStatus"] != 1 ) {
			echo json_encode(array("error_msg"=>"현재 배팅가능 상태가 아닙니다."));
			exit;
		}

		//-> 리얼20장미니게임 리그번호
		$leagueSn = $gameModel->getReal20LeagueSn();
		if ( !$leagueSn ) {
			echo json_encode(array("error_msg"=>"[리얼20장미니게임] 리그정보를 찾을 수 없습니다."));
			exit;
		}

		//-> 배팅 들어온 게임이 DB에 존재하는지 확인하고 없으면 Insert 한다.
		for ( $i = 0 ; $i < count((array)$btGameTypeList) ; $i++ ) {
			$gameType = $btGameTypeList[$i];
			$gameCode = $this->getGameInfo($gameType, "code");

			$is_game = $gameModel->getReal20Check($lastGameInfo["gameYmd"], $gameCode, $lastGameInfo["gameTh"]);
			if ( !$is_game ) {
				$gameInsertInfo = $this->getGameInfo($gameType, "infoList");
				$gameTh = $lastGameInfo["gameTh"];
				$homeTeam = $lastGameInfo["gameTh"].$gameInsertInfo["homeTeam"];
				$awayTeam = $lastGameInfo["gameTh"].$gameInsertInfo["awayTeam"];
				$gameDate = $lastGameInfo["gameYmd"];
				$gameHour = $lastGameInfo["gameH"];
				$gameTime = $lastGameInfo["gameI"];
				$homeRate = $gameInsertInfo["homeRate"];
				$drawRate = $gameInsertInfo["drawRate"];
				$awayRate = $gameInsertInfo["awayRate"];

				//-> 경기등록
				$insertRes = $gameModel->insertReal20($leagueSn,$homeTeam,$awayTeam,$gameDate,$gameHour,$gameTime,$homeRate,$drawRate,$awayRate,$gameCode,$gameTh);
				$insertCnt++;
			} else {
				$insertCnt++;
			}
		}
		
		if ( $insertCnt == count((array)$btGameTypeList) ) {
			echo json_encode(array("result"=>"ok"));	
		} else {
			echo json_encode(array("error_msg"=>"일부 게임이 생성되지 않았습니다."));
		}
	}

	//-> 최근 리얼20장 경기 정보를 가져옴.
	public function getLastGameInfo() {
		$jsonData = json_decode(@file_get_contents("http://real-2020.com/api/ApiRealRsult.php?type=lately"),1);
		$degree = $jsonData["data"][0]["DEGREE"];
		$remainTime = $jsonData["data"][0]["REMAIN_TIME"];

		$gameTh = trim(substr($degree, 8, 3));													//-> 게임회차
		$gameStatus = $jsonData["data"][0]["STATUS"];										//-> 게임상태값
		$gameYmd = trim(substr($jsonData["data"][0]["REG_TIME3"],0,10));	//-> 게임시작 년-월-일
		$gameH = trim(substr($jsonData["data"][0]["REG_TIME3"],11,2));		//-> 게임시작 시간
		$gameI = trim(substr($jsonData["data"][0]["REG_TIME3"],14,2));		//-> 게임시작 분
		$gameS = trim(substr($jsonData["data"][0]["REG_TIME3"],17,2));		//-> 게임시작 초

		return array("gameTh"=>$gameTh,"gameStatus"=>$gameStatus,"gameYmd"=>$gameYmd,"gameH"=>$gameH,"gameI"=>$gameI,"gameS"=>$gameS,"addTime"=>$remainTime);
	}

	//-> 게임타입별 게임코드/배당을/INSERT정보율 가져옴.
	public function getGameInfo($val, $type) {
		$rate_odd = $rate_even = "1.95";
		$rate_under = $rate_over = "1.95";
		$rate_win_ri = "1.95";
		$rate_win_n = "9.00";
		$tate_win_aul = "1.95";
		$rate_t1 = $rate_t2 = $rate_t3 = $rate_t4 = $rate_t5 = $rate_t6 = $rate_t7 = $rate_t8 = $rate_t9 = $rate_t10 = "8.50";

		if ( $type == "code" ) {
			$gameTypeList = array("g_odd"=>"g_oe", "g_even"=>"g_oe", "g_over"=>"g_unover", "g_under"=>"g_unover", "g_win-ri"=>"g_winner", "g_win-n"=>"g_winner", "g_win-aul"=>"g_winner",
														"g_t1"=>"g_t12", "g_t2"=>"g_t12", "g_t3"=>"g_t34", "g_t4"=>"g_t34", "g_t5"=>"g_t56", "g_t6"=>"g_t56", "g_t7"=>"g_t78", "g_t8"=>"g_t78", "g_t9"=>"g_t910", "g_t10"=>"g_t910");
			return $gameTypeList[$val];
		} else if ( $type == "rate" ) {
			$gameTypeRateList = array("g_odd"=>$rate_odd, "g_even"=>$rate_even, "g_over"=>$rate_over, "g_under"=>$rate_under, "g_win-ri"=>$rate_win_ri,"g_win-n"=>$rate_win_n,"g_win-aul"=>$tate_win_aul,
																"g_t1"=>$rate_t1,"g_t2"=>$rate_t2,"g_t3"=>$rate_t3,"g_t4"=>$rate_t4, "g_t5"=>$rate_t5,"g_t6"=>$rate_t6,"g_t7"=>$rate_t7,"g_t8"=>$rate_t8,"g_t9"=>$rate_t9,"g_t10"=>$rate_t10);
			return $gameTypeRateList[$val];
		} else if ( $type == "selectNo" ) {
			$gameTypeSelectNo = array("g_odd"=>1, "g_even"=>2, "g_over"=>1, "g_under"=>2, "g_win-ri"=>1,"g_win-n"=>3,"g_win-aul"=>2, "g_t1"=>1,"g_t2"=>2,"g_t3"=>1,"g_t4"=>2, "g_t5"=>1,"g_t6"=>2,"g_t7"=>1,"g_t8"=>2,"g_t9"=>1,"g_t10"=>2);
			return $gameTypeSelectNo[$val];
		} else if ( $type == "infoList" ) {
			if ( $val == "g_odd" or $val == "g_even" ) {
				return array("homeRate"=>$rate_odd,"drawRate"=>"1.0","awayRate"=>$rate_even,"homeTeam"=>"회차 [홀]","awayTeam"=>"회차 [짝]");
			} else if ( $val == "g_under" or $val == "g_over" ) {
				return array("homeRate"=>$rate_over,"drawRate"=>"1.0","awayRate"=>$rate_under,"homeTeam"=>"회차 [오버]","awayTeam"=>"회차 [언더]");
			} else if ( $val == "g_win-ri" or $val == "g_win-n" or $val == "g_win-aul" ) {
				return array("homeRate"=>$rate_win_ri,"drawRate"=>$rate_win_n,"awayRate"=>$tate_win_aul,"homeTeam"=>"회차 [승(리)]","awayTeam"=>"회차 [승(얼)]");
			} else if ( $val == "g_t1" or $val == "g_t2" ) {
				return array("homeRate"=>$rate_t1,"drawRate"=>"1.0","awayRate"=>$rate_t2,"homeTeam"=>"회차 [숫자1]","awayTeam"=>"회차 [숫자2]");
			} else if ( $val == "g_t3" or $val == "g_t4" ) {
				return array("homeRate"=>$rate_t3,"drawRate"=>"1.0","awayRate"=>$rate_t4,"homeTeam"=>"회차 [숫자3]","awayTeam"=>"회차 [숫자4]");
			} else if ( $val == "g_t5" or $val == "g_t6" ) {
				return array("homeRate"=>$rate_t5,"drawRate"=>"1.0","awayRate"=>$rate_t6,"homeTeam"=>"회차 [숫자5]","awayTeam"=>"회차 [숫자6]");
			} else if ( $val == "g_t7" or $val == "g_t8" ) {
				return array("homeRate"=>$rate_t7,"drawRate"=>"1.0","awayRate"=>$rate_t8,"homeTeam"=>"회차 [숫자7]","awayTeam"=>"회차 [숫자8]");
			} else if ( $val == "g_t9" or $val == "g_t10" ) {
				return array("homeRate"=>$rate_t9,"drawRate"=>"1.0","awayRate"=>$rate_t10,"homeTeam"=>"회차 [숫자9]","awayTeam"=>"회차 [숫자10]");
			}
		}
	}
}
?>