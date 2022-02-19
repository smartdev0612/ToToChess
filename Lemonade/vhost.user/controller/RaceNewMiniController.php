<?php
class RaceNewMiniController extends WebServiceController 
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

        $btGameName = $_POST["btGameName"];			//-> 배팅게임종류
		$btGameTh = $_POST["btGameTh"];					//-> 배팅게임회차
		$btMoney = $_POST["btMoney"];						//-> 배팅금액
		$btGameTypeList = $_POST["btGameType"];	//-> 배팅게임타입 (array)

        $this->gameCheckProcessAction();

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

        $btInterval = 0;
        if ( $btGameName == "fx") {
            $btInterval = $_POST["btInterval"];
        }

		if ( !$btGameName or !$btGameTh or !$btMoney or !count((array)$btGameTypeList) ) {
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
		$lastGameInfo = $this->getLastGameInfo($btGameName, $btInterval);
		if ( !count((array)$lastGameInfo) or !$lastGameInfo["gameTh"] ) {
			echo json_encode(array("error_msg"=>"최근 경기정보를 찾을 수 없습니다."));
			exit;
		}

		if ( $lastGameInfo["gameTh"] != $btGameTh ) {
			echo json_encode(array("error_msg"=>"배팅한 회차와 현재 회차 정보가 틀립니다."));
			exit;
		}

		//-> 싱글값이 Array로 들어오지 않으면 Array에 배치.
		if ( gettype($btGameTypeList) != "array" and strlen($btGameTypeList) > 0 ) {
			$btGameTypeList = array($btGameTypeList);
		}

		//-> 게임타입 및 코드를 확인하고 최종 배당을 계산한다.
		$btRateTotal = 1;
		for ( $i = 0 ; $i < count((array)$btGameTypeList) ; $i++ ) {
			$btType = $btGameTypeList[$i];
			$btGameCode = $this->getGameInfo($btGameName, $btType, "code");
			if ( !$btGameCode ) {
				echo json_encode(array("error_msg"=>"배팅 게임코드를 찾을 수 없습니다. [{$btType}]"));
				exit;
			}

			$btRate = $this->getGameInfo($btGameName, $btType, "rate");
			$btRateTotal = $btRateTotal * $btRate;
		}
		$btRateTotal = sprintf("%2.2f",$btRateTotal);

		//-> 배팅금액 제한체크.
		$user_level = $memberModel->getMemberField($user_sn,'mem_lev')+0;
		$betConfigInfoArr = $configModel->getMiniGameLevelConfigRows("*","user_level='{$user_level}' ");
        if ( $btGameName == "sadari" ) $specialCode = 5;
        else if ( $btGameName == "race" ) $specialCode = 6;
        else if ( $btGameName == "powerball" ) $specialCode = 7;
        else if ( $btGameName == "dari" ) $specialCode = 8;
        else if ( $btGameName == "powersadari" ) $specialCode = 25;
        else if ( $btGameName == "kenosadari" ) $specialCode = 24;
        else if ( $btGameName == "aladin" ) $specialCode = 29;
        else if ( $btGameName == "lowhi" ) $specialCode = 28;
        else if ( $btGameName == "2dari" ) $specialCode = 30;
        else if ( $btGameName == "3dari" ) $specialCode = 31;
        else if ( $btGameName == "choice" ) $specialCode = 32;
        else if ( $btGameName == "roulette" ) $specialCode = 33;
        else if ( $btGameName == "pharaoh" ) $specialCode = 34;
        else if ( $btGameName == "mgmoddeven" ) $specialCode = 26;
        else if ( $btGameName == "mgmbacara" ) $specialCode = 27;
        else if ( $btGameName == "nine" ) $specialCode = 21;
        else if ( $btGameName == "fx")
        {
            if($btInterval == 1) $specialCode = 35;
            if($btInterval == 2) $specialCode = 39;
            if($btInterval == 3) $specialCode = 40;
            if($btInterval == 4) $specialCode = 41;
            if($btInterval == 5) $specialCode = 42;
        }
        else exit;

        $alarmFlagName = "betting_".$btGameName;
        $minBetMoney = $betConfigInfoArr[0][$btGameName."_min_bet"];
        $maxBetMoney = $betConfigInfoArr[0][$btGameName."_max_bet"];
        $maxBnsMoney = $betConfigInfoArr[0][$btGameName."_max_bns"];

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

		//-> 경기가 존재 하는지 + 배팅시간 체크
		for ( $i = 0 ; $i < count((array)$btGameTypeList) ; $i++ ) {
			$btType = $btGameTypeList[$i];
			$btGameCode = $this->getGameInfo($btGameName, $btType, "code");

			//-> 해당경기가 DB에 있는지 확인. (게임날짜+게임코드+회차로 확인)
			$btGameDate = $lastGameInfo["gameYmd"];
			$gameInfo = $gameModel->getMinigameInfo($btGameDate, $btGameCode, $btGameTh, $specialCode);
			if ( !$gameInfo ) {
				echo json_encode(array("error_msg"=>"게임을 찾을 수 없습니다. 관리자에게 문의해주세요. [{$btGameCode}]"));
				exit;
			}

			$child_sn = $gameInfo[0]["child_sn"];
			$gameDate = $gameInfo[0]["gameDate"];
			$gameHour = $gameInfo[0]["gameHour"];
			$gameTime = $gameInfo[0]["gameTime"];

			$nowTime = date("Y-m-d H:i:s",time());
			$gameStartTime = trim($gameDate) ." ". trim($gameHour) .":". trim($gameTime).":00";
			$limitTime = strtotime($gameStartTime) - strtotime($nowTime);

			$betTimeCheckFlag = $this->getBetTime($btGameName, $limitTime, $btInterval);
			if ( !$betTimeCheckFlag ) {
				echo json_encode(array("error_msg"=>"배팅시간이 마감되었습니다.[{$limitTime}]"));
				exit();
			}

            $selectTeam = $this->getGameInfo($btGameName, $btType, "selectNo");
            // $uniqueSelectGame = $cartModel->getCartFolder_withSelectNo($child_sn, $user_sn, $selectTeam, $specialCode);
            // if($uniqueSelectGame > 0)
            // {
            //     echo json_encode(array("error_msg"=>"동일회차 중복배팅은 불가능합니다."));
            //     exit;
            // }

			//-> 동일회차 배팅 제한.
			$uniqueBettingFolder = $cartModel->getCartFolder($child_sn, $user_sn, $specialCode);
			if ( $btGameName == "race" ) {
				if ( $uniqueBettingFolder >= 1 ) {
					echo json_encode(array("error_msg"=>"동일회차 배팅은 최대 1회 가능합니다."));
					exit;
				}
			} else {
				if ( $uniqueBettingFolder >= 5 ) {
					echo json_encode(array("error_msg"=>"동일회차 배팅은 최대 5회 가능합니다."));
					exit;
				}
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
			$btGameCode = $this->getGameInfo($btGameName, $btType, "code");
			$btRate = $this->getGameInfo($btGameName, $btType, "rate");
			$btGameDate = $lastGameInfo["gameYmd"];
			$selectTeam = $this->getGameInfo($btGameName, $btType, "selectNo");

			//-> 배팅 게임 정보
			$gameInfo = $gameModel->getMinigameInfo($btGameDate, $btGameCode, $btGameTh, $specialCode);
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
			$cartModel->addBet($user_sn, $child_sn, $subchild_sn, $protoId, $selectTeam, $home_rate, $draw_rate, $away_rate, $btRate, 1, "Y", $btMoney, 1);
		}

		//-> 배팅개수.
		$betting_cnt = count((array)$btGameTypeList);
		$cartModel->addCart($user_sn, 0, $protoId, "Y", $betting_cnt, $user_g_money, $btMoney, $btRateTotal, $user_recommend_sn, $user_rolling_sn, $user_account_enable, '', $specialCode);

		//-> 보유머니 차감 및 로그.
		$processModel->bettingProcess($user_sn, $btMoney);

		//-> 배팅 알람 업데이트.
		if ( $btMoney >= 300000 ) {
			$configModel->modifyAlramFlag($alarmFlagName."_big",1);
		} else {
			$configModel->modifyAlramFlag($alarmFlagName,1);
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
		$gameModel = $this->getModel('GameModel');

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

		$btGameName = $_POST["btGameName"];			//-> 배팅게임종류
		$btGameTh = $_POST["btGameTh"];					//-> 배팅게임회차
		$btMoney = $_POST["btMoney"];						//-> 배팅금액
		$btGameTypeList = $_POST["btGameType"];	//-> 배팅게임타입 (array)
        $btInterval = 0;
        if ( $btGameName == "fx") {
            $btInterval = $_POST["btInterval"];
        }

		if ( !$btGameName or !$btGameTh or !count((array)$btGameTypeList) ) {
			echo json_encode(array("error_msg"=>"처리에 필요한 데이터가 부족합니다."));
			exit;
		}

		$lastGameInfo = $this->getLastGameInfo($btGameName, $btInterval);
		if ( !count((array)$lastGameInfo) or !$lastGameInfo["gameTh"] ) {
			echo json_encode(array("error_msg"=>"최근 경기정보를 찾을 수 없습니다."));
			exit;
		}

		if ( $lastGameInfo["gameTh"] != $btGameTh ) {
			echo json_encode(array("error_msg"=>"현재 회차 정보가 틀립니다. [".$btGameTh."]"));
			exit;
		}

		//-> 싱글값이 Array로 들어오지 않으면 Array에 배치.
		if ( gettype($btGameTypeList) != "array" and strlen($btGameTypeList) > 0 ) {
			$btGameTypeList = array($btGameTypeList);
		}

		//-> 미니게임 리그번호
        if($btGameName == "fx")
        {
            $leagueSn = $gameModel->getLeagueSn($btGameName.$btInterval);
        } else {
            $leagueSn = $gameModel->getLeagueSn($btGameName);
        }

		if ( !$leagueSn ) {
			echo json_encode(array("error_msg"=>"리그정보를 찾을 수 없습니다."));
			exit;
		}

		if ( $btGameName == "sadari" ) $specialCode = 5;
		else if ( $btGameName == "dari" ) $specialCode = 8;
		else if ( $btGameName == "race" ) $specialCode = 6;
		else if ( $btGameName == "powerball" ) $specialCode = 7;
		else if ( $btGameName == "lowhi" ) $specialCode = 28;
        else if ( $btGameName == "aladin" ) $specialCode = 29;
        else if ( $btGameName == "mgmoddeven" ) $specialCode = 26;
        else if ( $btGameName == "mgmbacara" ) $specialCode = 27;
        else if ( $btGameName == "powersadari" ) $specialCode = 25;
        else if ( $btGameName == "kenosadari" ) $specialCode = 24;
        else if ( $btGameName == "2dari" ) $specialCode = 30;
        else if ( $btGameName == "3dari" ) $specialCode = 31;
        else if ( $btGameName == "choice" ) $specialCode = 32;
        else if ( $btGameName == "roulette" ) $specialCode = 33;
        else if ( $btGameName == "nine" ) $specialCode = 21;
        else if ( $btGameName == "pharaoh" ) $specialCode = 34;
        else if ( $btGameName == "fx")
        {
            if($btInterval == 1) $specialCode = 35;
            if($btInterval == 2) $specialCode = 39;
            if($btInterval == 3) $specialCode = 40;
            if($btInterval == 4) $specialCode = 41;
            if($btInterval == 5) $specialCode = 42;

            $day = date("w");
            $hour = date("H",time());
            $min = date("i",time());
            $errMsg = "FX게임 데이터제공 시간 안내
                FX게임에서 제공하는 FX Margin 거래 데이터는 국내 증권사인 하나금융투자 API데이터를 기반으로 제공되고 있습니다.
                FX Margin 거래는 한국표준시간을 기준으로 주5일 24시간 거래가 이루어지지만 원활한 데이터제공을 위해서 FX게임에서는 아래같은 기준으로 데이터가 제공됩니다.
                데이터 제공시간 : 07:20 ~ 06:20 (토요일 05:00 까지)
                주말(토,일) : 휴장.";

            if($day == 0 || ($day==6 && $hour >=5))
            {
                echo json_encode(array("error_msg"=>$errMsg));
                exit;
            } else {
                $now_time = sprintf("%02d", $hour).sprintf("%02d", $min);
                if($now_time >= '0620' && $now_time <='0720')
                {
                    echo json_encode(array("error_msg"=>$errMsg));
                    exit;
                }
            }
        }

        $insertCnt = 0;
		//-> 배팅 들어온 게임이 DB에 존재하는지 확인하고 없으면 Insert 한다.
		for ( $i = 0 ; $i < count((array)$btGameTypeList) ; $i++ ) {
			$gameType = $btGameTypeList[$i];
			$gameCode = $this->getGameInfo($btGameName, $gameType, "code");

			$is_game = $gameModel->getInCheck($btGameName, $lastGameInfo["gameYmd"], $gameCode, $lastGameInfo["gameTh"]);
			if ( !$is_game ) {
				$gameInsertInfo = $this->getGameInfo($btGameName, $gameType, "infoList");
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
				$insertRes = $gameModel->insertMiniGame($leagueSn,$homeTeam,$awayTeam,$gameDate,$gameHour,$gameTime,$homeRate,$drawRate,$awayRate,$gameCode,$gameTh,$specialCode);
				$insertCnt++;
			} else {
				$insertCnt++;
			}
		}
		
		if ( $insertCnt == count((array)$btGameTypeList) ) {
			return;	
		} else {
			echo json_encode(array("error_msg"=>"일부 게임이 생성되지 않았습니다."));
            exit;
		}
	}

	//-> 현재 진행중인 회차/날짜/배팅가능시간 정보를 가져옴.
	public function getLastGameInfo($btGameName, $btInterval=0) {
		$yyyy = date("Y");
		$mm = date("m");
		$dd = date("d");
		$hour = date("H");
		$min = date("i");
		$sec = date("s");

        if ( $btGameName == "sadari" ) {
            $secTemp = (($hour * 60) * 60) + ($min * 60) + $sec;
            $gameTh = floor($secTemp / 300) + 1;
            $limitSec = ($gameTh * 300) - $secTemp;
        } else if ( $btGameName == "dari" ) {
            $secTemp = (($hour * 60) * 60) + ($min * 60) + $sec;
            $gameTh = floor($secTemp / 180) + 1;
            $limitSec = ($gameTh * 180) - $secTemp;
        } else if ( $btGameName == "race" ) {
            $secTemp = (($hour * 60) * 60) + ($min * 60) + $sec;
			$gameTh = floor($secTemp / 180) + 1;
			$limitSec = ($gameTh * 180) - $secTemp;
        } else if ( $btGameName == "powerball" ) {
            $powerStartTime = "1293883470";
            $gameTh = floor((time() - $powerStartTime) / 300);
            $limitSec = $powerStartTime + (($gameTh+1) * 300) - time();
        } else if ( $btGameName == "powersadari" ) {
            $secTemp = ((($hour * 60) * 60) + ($min * 60) + $sec) + 180;
            $gameTh = floor($secTemp / 300) + 1;
            $limitSec = ($gameTh * 300) - $secTemp + 45;
        } else if ( $btGameName == "kenosadari" ) {
            $secTemp = ((($hour * 60) * 60) + ($min * 60) + $sec) + 15;
            $gameTh = floor($secTemp / 300) + 1;
            $limitSec = ($gameTh * 300) - $secTemp;
        } else if ( $btGameName == "aladin" ) {
            $secTemp = (($hour * 60) * 60) + ($min * 60) + $sec;
            $gameTh = floor($secTemp / 180) + 1;
            $limitSec = ($gameTh * 180) - $secTemp;
        } else if ( $btGameName == "lowhi" ) {
            $secTemp = (($hour * 60) * 60) + ($min * 60) + $sec;
            $gameTh = floor($secTemp / 180) + 1;
            $limitSec = ($gameTh * 180) - $secTemp;
        } else if ( $btGameName == "mgmoddeven" ) {
            $secTemp = (($hour * 60) * 60) + ($min * 60) + $sec;
            $gameTh = floor($secTemp / 60) + 1;
            $limitSec = ($gameTh * 60) - $secTemp;
        } else if ( $btGameName == "mgmbacara" ) {
            $secTemp = (($hour * 60) * 60) + ($min * 60) + $sec;
            $gameTh = floor($secTemp / 60) + 1;
            $limitSec = ($gameTh * 60) - $secTemp;
        } else if ( $btGameName == "2dari" ) {
            $secTemp = (($hour * 60) * 60) + ($min * 60) + $sec;
            $gameTh = floor($secTemp / 120) + 1;
            $limitSec = ($gameTh * 120) - $secTemp;
        } else if ( $btGameName == "3dari" ) {
            $secTemp = (($hour * 60) * 60) + ($min * 60) + $sec;
            $gameTh = floor($secTemp / 180) + 1;
            $limitSec = ($gameTh * 180) - $secTemp;
        } else if ( $btGameName == "choice" or $btGameName == "roulette" or $btGameName == "pharaoh" ) {
            $secTemp = (($hour * 60) * 60) + ($min * 60) + $sec;
            $gameTh = floor($secTemp / 120) + 1;
            $limitSec = ($gameTh * 120) - $secTemp;
        } else if ($btGameName == "nine") {
            $secTemp = (($hour * 60) * 60) + ($min * 60) + $sec;
            $gameTh = floor($secTemp / 90) + 1;
            $limitSec = ($gameTh * 90) - $secTemp;
        } else if ($btGameName == "fx") {
            $secTemp = (($hour * 60) * 60) + ($min * 60) + $sec;
            $nextHour = $hour+ intval(($min - ($min % $btInterval) + $btInterval) / 60);
            $nextMin = ($min - ($min % $btInterval) + $btInterval) % 60;
            $nextSecTemp = ($nextHour * 60 * 60) + ($nextMin * 60);

            $nextHour = $nextHour + intval(($nextMin + $btInterval)/60);
            $nextMin = ($nextMin + $btInterval)%60;

            $nextHour = ($nextHour==24) ? 0 : $nextHour;
            $gameTh = sprintf("%02d", $nextHour).sprintf("%02d", $nextMin);
            $limitSec = $nextSecTemp - $secTemp;
        }

        if ( $btGameName == "powersadari" or $btGameName == "kenosadari" ) {
            $gameYmd = date("Y-m-d",time()+$limitSec+15);
            $gameH = date("H",time()+$limitSec+15);
            $gameI = date("i",time()+$limitSec+15);
            $gameS = date("s",time()+$limitSec+15);
        } else {
            $gameYmd = date("Y-m-d",time()+$limitSec);
            $gameH = date("H",time()+$limitSec);
            $gameI = date("i",time()+$limitSec);
            $gameS = date("s",time()+$limitSec);
        }

		if ( ($btGameName == "sadari" or $btGameName == "powersadari" or $btGameName == "kenosadari") and $gameTh == "288" ) {
            $gameYmd = date("Y-m-d",time()-300);
            $gameH = "23";
            $gameI = "59";
        } else if ( ($btGameName == "3dari" or $btGameName == "dari" or $btGameName == "race" or $btGameName == "aladin" or $btGameName == "lowhi") and $gameTh == "480" ) {
            $gameYmd = date("Y-m-d",time()-180);
            $gameH = "23";
            $gameI = "59";
        } else if ( ($btGameName == "mgmoddeven" or $btGameName == "mgmbacara") and $gameTh == "1440" ) {
            $gameYmd = date("Y-m-d",time()-60);
            $gameH = "23";
            $gameI = "59";
        } else if ( ($btGameName == "2dari" or $btGameName == "choice" or $btGameName == "roulette" or $btGameName == "pharaoh") and $gameTh == "720" ) {
            $gameYmd = date("Y-m-d",time()-120);
            $gameH = "23";
            $gameI = "59";
        }  else if ( $btGameName == "nine" and $gameTh == "960" ) {
            $gameYmd = date("Y-m-d",time()-90);
            $gameH = "23";
            $gameI = "58";
        }


        if ( $btGameName == "powerball" ) $limitSec = $limitSec - 12;
        if ( $btGameName == "aladin" ) $limitSec = $limitSec - 12;
        if ( $btGameName == "lowhi" ) $limitSec = $limitSec - 12;
        if ( $btGameName == "2dari" ) $limitSec = $limitSec - 7;
        if ( $btGameName == "3dari" ) $limitSec = $limitSec - 7;
        if ( $btGameName == "choice" ) $limitSec = $limitSec - 6;
        if ( $btGameName == "roulette" ) $limitSec = $limitSec - 6;
        if ( $btGameName == "nine" ) $limitSec = $limitSec - 6;
        if ( $btGameName == "pharaoh" ) $limitSec = $limitSec - 6;
		return array("gameTh"=>$gameTh,"gameYmd"=>$gameYmd,"gameH"=>$gameH,"gameI"=>$gameI,"gameS"=>$gameS,"limitSec"=>$limitSec);
	}

	//-> 배팅마감시간 및 배팅총시간 셋팅.
	public function getBetTime($btGameName, $limitTime, $btInterval) {
        $configModel = $this->getModel("ConfigModel");
        $config = $configModel->getMiniConfigRow("*", "", '');

		if ( $btGameName == "sadari" ) {
			$gameTotalTime = 300;
			$betLimit = $config['sadari_limit']; //90;
		} else if ( $btGameName == "dari" ) {
			$gameTotalTime = 180;
			$betLimit = $config['dari_limit']; //68; //60;
		} else if ( $btGameName == "race" ) {
			$gameTotalTime = 180;
			$betLimit = $config['race_limit']; //60;
		} else if ( $btGameName == "powerball" ) {
			$gameTotalTime = 300;
			$betLimit = $config['power_limit']; //65;
		} else if ( $btGameName == "powersadari" ) {
            $gameTotalTime = 300;
            $betLimit = $config['powersadari_limit']; //30;
        } else if ( $btGameName == "kenosadari" ) {
            $gameTotalTime = 300;
            $betLimit = $config['kenosadari_limit']; //30;
        }  else if ( $btGameName == "aladin" ) {
            $gameTotalTime = 180;
            $betLimit = 60;
        } else if ( $btGameName == "lowhi" ) {
            $gameTotalTime = 180;
            $betLimit = 60;
        } else if ( $btGameName == "mgmoddeven" ) {
            $gameTotalTime = 60;
            $betLimit = $config['crownodd_limit']; //20;
        } else if ( $btGameName == "mgmbacara" ) {
            $gameTotalTime = 60;
            $betLimit = $config['crownbaccara_limit']; //20;
        } else if ( $btGameName == "2dari" ) {
            $gameTotalTime = 120;
            $betLimit = $config['dari2_limit']; //20;
        } else if ( $btGameName == "3dari" ) {
            $gameTotalTime = 180;
            $betLimit = $config['dari3_limit']; //25;
        } else if ( $btGameName == "choice") {
            $gameTotalTime = 120;
            $betLimit = $config['choice_limit']; //20;
        }  else if ( $btGameName == "roulette") {
            $gameTotalTime = 120;
            $betLimit = $config['roulette_limit']; //20;
        }  else if ($btGameName == "pharaoh" ) {
            $gameTotalTime = 120;
            $betLimit = $config['pharah_limit']; //20;
        }  else if ( $btGameName == "nine") {
            $gameTotalTime = 90;
            $betLimit = $config['crownnine_limit']; //10;
        }  else if ( $btGameName == "fx") {
            $gameTotalTime = 60 * $btInterval;
            $betLimit = $config['fx_limit']; //10;
        }/*  else if ( $btGameName == "fx2") {
            $gameTotalTime = 120;
            $betLimit = $config['fx_limit']; //10;
        }  else if ( $btGameName == "fx3") {
            $gameTotalTime = 180;
            $betLimit = $config['fx_limit']; //10;
        }  else if ( $btGameName == "fx4") {
            $gameTotalTime = 240;
            $betLimit = $config['fx_limit']; //10;
        }  else if ( $btGameName == "fx5") {
            $gameTotalTime = 300;
            $betLimit = $config['fx_limit']; //10;
        }*/

        if ( $btGameName == "aladin" ) $limitTime = $limitTime - 12;
        if ( $btGameName == "lowhi" ) $limitTime = $limitTime - 12;
        if ( $btGameName == "powerball" ) $limitTime = $limitTime - 12;
        if ( $btGameName == "powersadari" or $btGameName == "kenosadari" ) $limitTime = $limitTime - 12;
        if ( $btGameName == "2dari" ) $limitTime = $limitTime - 7;
        if ( $btGameName == "3dari" ) $limitTime = $limitTime - 7;
        if ( $btGameName == "choice" ) $limitTime = $limitTime - 6;
        if ( $btGameName == "roulette" ) $limitTime = $limitTime - 6;
        if ( $btGameName == "nine" ) $limitTime = $limitTime - 6;
        if ( $btGameName == "pharaoh" ) $limitTime = $limitTime - 6;

		if ( $limitTime < $betLimit or $limitTime > $gameTotalTime ) return 0;
		else return 1;
	}

	//-> 게임타입별 게임코드/배당을/INSERT정보율 가져옴.
	public function getGameInfo($btGameName, $val, $type) {
        $configModel = $this->getModel("ConfigModel");
	    $miniodds_info = $configModel->getMiniOddsRow("*", "", '');

		if ( $btGameName == "sadari" ) {
			$rate_odd = $rate_even = $miniodds_info['sadari_oe']; //"1.95";
			$rate_left = $rate_right = $miniodds_info['sadari_lr']; //"1.93";
			$rate_3line = $rate_4line = $miniodds_info['sadari_lr']; //"1.93";
			$rate_even3line_left = $rate_odd4line_left = $rate_odd3line_right = $rate_even4line_right = $miniodds_info['sadari_oeline_lr']; //;

			if ( $type == "code" ) {
				$gameTypeList = array("odd"=>"s_oe", "even"=>"s_oe", "left"=>"s_lr", "right"=>"s_lr", "3line"=>"s_34", "4line"=>"s_34", 
															"even3line_left"=>"s_e3o4l","odd4line_left"=>"s_e3o4l", "odd3line_right"=>"s_o3e4r", "even4line_right"=>"s_o3e4r");
				return $gameTypeList[$val];
			} else if ( $type == "rate" ) {
				$gameTypeRateList = array("odd"=>$rate_odd, "even"=>$rate_even, "left"=>$rate_left, "right"=>$rate_right, "3line"=>$rate_3line,"4line"=>$rate_4line,
																	"even3line_left"=>$rate_even3line_left,"odd4line_left"=>$rate_odd4line_left,"odd3line_right"=>$rate_odd3line_right,"even4line_right"=>$rate_even4line_right);
				return $gameTypeRateList[$val];
			} else if ( $type == "selectNo" ) {
				$gameTypeSelectNo = array("odd"=>1, "even"=>2, "left"=>1, "right"=>2, "3line"=>1, "4line"=>2, "even3line_left"=>1, "odd4line_left"=>2, "odd3line_right"=>1, "even4line_right"=>2);
				return $gameTypeSelectNo[$val];
			} else if ( $type == "infoList" ) {
				if ( $val == "odd" or $val == "even" ) {
					return array("homeRate"=>$rate_odd,"drawRate"=>"1.0","awayRate"=>$rate_even,"homeTeam"=>"회차 [홀]","awayTeam"=>"회차 [짝]");
				} else if ( $val == "left" or $val == "right" ) {
					return array("homeRate"=>$rate_left,"drawRate"=>"1.0","awayRate"=>$rate_right,"homeTeam"=>"회차 [좌]","awayTeam"=>"회차 [우]");
				} else if ( $val == "3line" or $val == "4line" ) {
					return array("homeRate"=>$rate_3line,"drawRate"=>"1.0","awayRate"=>$rate_4line,"homeTeam"=>"회차 [3줄]","awayTeam"=>"회차 [4줄]");
				} else if ( $val == "even3line_left" or $val == "odd4line_left" ) {
					return array("homeRate"=>$rate_even3line_left,"drawRate"=>"1.0","awayRate"=>$rate_odd4line_left,"homeTeam"=>"회차 [짝3줄좌]","awayTeam"=>"회차 [홀4줄좌]");
				} else if ( $val == "odd3line_right" or $val == "even4line_right" ) {
					return array("homeRate"=>$rate_odd3line_right,"drawRate"=>"1.0","awayRate"=>$rate_even4line_right,"homeTeam"=>"회차 [홀3줄우]","awayTeam"=>"회차 [짝4줄우]");
				}
			}
		} else if ( $btGameName == "dari" ) {
			//-> 1게임 : 홀/짝
			$rate_odd = $rate_even = $miniodds_info['dari_oe']; //"1.95";
			//-> 2게임 : 출발줄/줄갯수
			$rate_left = $rate_right = $miniodds_info['dari_lr']; //"1.93";
			$rate_3line = $rate_4line = $miniodds_info['dari_line']; //"1.93";
			//-> 3게임 : 좌우+출발+3/4줄
			$rate_even3line_left = $rate_odd4line_left = $rate_odd3line_right = $rate_even4line_right = $miniodds_info['dari_oeline_lr']; //"3.60";

			if ( $type == "code" ) {
				$gameTypeList = array("odd"=>"d_oe", "even"=>"d_oe", "left"=>"d_lr", "right"=>"d_lr", "3line"=>"d_34", "4line"=>"d_34", 
															"even3line_left"=>"d_e3o4l","odd4line_left"=>"d_e3o4l", "odd3line_right"=>"d_o3e4r", "even4line_right"=>"d_o3e4r");
				return $gameTypeList[$val];
			} else if ( $type == "rate" ) {
				$gameTypeRateList = array("odd"=>$rate_odd, "even"=>$rate_even, "left"=>$rate_left, "right"=>$rate_right, "3line"=>$rate_3line,"4line"=>$rate_4line,
																	"even3line_left"=>$rate_even3line_left,"odd4line_left"=>$rate_odd4line_left,"odd3line_right"=>$rate_odd3line_right,"even4line_right"=>$rate_even4line_right);
				return $gameTypeRateList[$val];
			} else if ( $type == "selectNo" ) {
				$gameTypeSelectNo = array("odd"=>1,"even"=>2,"left"=>1,"right"=>2,"3line"=>1,"4line"=>2,"even3line_left"=>1,"odd4line_left"=>2,"odd3line_right"=>1,"even4line_right"=>2);
				return $gameTypeSelectNo[$val];
			} else if ( $type == "infoList" ) {
				if ( $val == "odd" or $val == "even" ) {
					return array("homeRate"=>$rate_odd,"drawRate"=>"1.0","awayRate"=>$rate_even,"homeTeam"=>"회차 [홀]","awayTeam"=>"회차 [짝]");
				} else if ( $val == "left" or $val == "right" ) {
					return array("homeRate"=>$rate_left,"drawRate"=>"1.0","awayRate"=>$rate_right,"homeTeam"=>"회차 [좌]","awayTeam"=>"회차 [우]");
				} else if ( $val == "3line" or $val == "4line" ) {
					return array("homeRate"=>$rate_3line,"drawRate"=>"1.0","awayRate"=>$rate_4line,"homeTeam"=>"회차 [3줄]","awayTeam"=>"회차 [4줄]");
				} else if ( $val == "even3line_left" or $val == "odd4line_left" ) {
					return array("homeRate"=>$rate_even3line_left,"drawRate"=>"1.0","awayRate"=>$rate_odd4line_left,"homeTeam"=>"회차 [짝3줄좌]","awayTeam"=>"회차 [홀4줄좌]");
				} else if ( $val == "odd3line_right" or $val == "even4line_right" ) {
					return array("homeRate"=>$rate_odd3line_right,"drawRate"=>"1.0","awayRate"=>$rate_even4line_right,"homeTeam"=>"회차 [홀3줄우]","awayTeam"=>"회차 [짝4줄우]");
				}
			}
		} else if ( $btGameName == "race" ) {
			//-> 1게임 : 1등 달팽이
			$rate_1w_n = $rate_1w_e = $rate_1w_d = $miniodds_info['race_1w']; //"2.80";
			//-> 2게임 : 삼치기
			$rate_1w2d3l_n = $rate_1w2d3l_e = $rate_1w2d3l_d = $miniodds_info['race_1w2d3l']; //"1.90";
			//-> 3게임 : 꼴등피하기
			$rate_1w2w3l_n = $rate_1w2w3l_e = $rate_1w2w3l_d = $miniodds_info['race_1w2w3l']; //"1.27";
			//-> 4게임 : 달팽이 순위
			$rate_ned = $rate_nde = $rate_end = $rate_edn = $rate_dne = $rate_den = $miniodds_info['race_nde']; //"5.55";

			if ( $type == "code" ) {
				$gameTypeList = array("1w-n"=>"r_1w","1w-e"=>"r_1w","1w-d"=>"r_1w","1w2d3l-n"=>"r_1w2d3l","1w2d3l-e"=>"r_1w2d3l","1w2d3l-d"=>"r_1w2d3l",
															"1w2w3l-n"=>"r_1w2w3l","1w2w3l-e"=>"r_1w2w3l","1w2w3l-d"=>"r_1w2w3l","ned"=>"r_ned-nde","nde"=>"r_ned-nde","end"=>"r_end-edn",
															"edn"=>"r_end-edn","dne"=>"r_dne-den","den"=>"r_dne-den");
				return $gameTypeList[$val];
			} else if ( $type == "rate" ) {
				$gameTypeRateList = array("1w-n"=>$rate_1w_n,"1w-e"=>$rate_1w_e,"1w-d"=>$rate_1w_d,"1w2d3l-n"=>$rate_1w2d3l_n,"1w2d3l-e"=>$rate_1w2d3l_e,"1w2d3l-d"=>$rate_1w2d3l_d,
															"1w2w3l-n"=>$rate_1w2w3l_n,"1w2w3l-e"=>$rate_1w2w3l_e,"1w2w3l-d"=>$rate_1w2w3l_d,"ned"=>$rate_ned,"nde"=>$rate_nde,"end"=>$rate_end,
															"edn"=>$rate_edn,"dne"=>$rate_dne,"den"=>$rate_den);
				return $gameTypeRateList[$val];
			} else if ( $type == "selectNo" ) {
				$gameTypeSelectNo = array("1w-n"=>1,"1w-e"=>3,"1w-d"=>2,"1w2d3l-n"=>1,"1w2d3l-e"=>3,"1w2d3l-d"=>2,"1w2w3l-n"=>1,"1w2w3l-e"=>3,"1w2w3l-d"=>2, 
															"ned"=>1,"nde"=>2,"end"=>1,"edn"=>2,"dne"=>1,"den"=>2);
				return $gameTypeSelectNo[$val];
			} else if ( $type == "infoList" ) {
				if ( $val == "1w-n" or $val == "1w-e" or $val == "1w-d" ) {
					return array("homeRate"=>$rate_1w_n,"drawRate"=>$rate_1w_e,"awayRate"=>$rate_1w_d,"homeTeam"=>"회차 [1등]","awayTeam"=>"회차 [1등]");
				} else if ( $val == "1w2d3l-n" or $val == "1w2d3l-e" or $val == "1w2d3l-d" ) {
					return array("homeRate"=>$rate_1w2d3l_n,"drawRate"=>$rate_1w2d3l_e,"awayRate"=>$rate_1w2d3l_d,"homeTeam"=>"회차 [삼치기-네]","awayTeam"=>"회차 [삼치기-드]");
				} else if ( $val == "1w2w3l-n" or $val == "1w2w3l-e" or $val == "1w2w3l-d" ) {
					return array("homeRate"=>$rate_1w2w3l_n,"drawRate"=>$rate_1w2w3l_e,"awayRate"=>$rate_1w2w3l_d,"homeTeam"=>"회차 [꼴등피-네]","awayTeam"=>"회차 [꼴등피-드]");
				} else if ( $val == "ned" or $val == "nde" ) {
					return array("homeRate"=>$rate_ned,"drawRate"=>"1.0","awayRate"=>$rate_nde,"homeTeam"=>"회차 [네임드]","awayTeam"=>"회차 [네드임]");
				} else if ( $val == "end" or $val == "edn" ) {
					return array("homeRate"=>$rate_end,"drawRate"=>"1.0","awayRate"=>$rate_edn,"homeTeam"=>"회차 [임네드]","awayTeam"=>"회차 [임드네]");
				} else if ( $val == "dne" or $val == "den" ) {
					return array("homeRate"=>$rate_dne,"drawRate"=>"1.0","awayRate"=>$rate_den,"homeTeam"=>"회차 [드네임]","awayTeam"=>"회차 [드임네]");
				}
			}
		} else if ( $btGameName == "powerball" ) {
			//-> 1게임 : 일반볼 홀/짝
			$rate_n_oe_o = $rate_n_oe_e = $miniodds_info['pb_n_oe']; //"1.95";
            $rate_n_uo_u = $rate_n_uo_o = $miniodds_info['pb_n_uo']; //"1.95";

            //-> 2게임 : 파워볼 홀/짝
			$rate_p_oe_o = $rate_p_oe_e = $miniodds_info['pb_p_oe']; //"1.95";
            $rate_p_uo_u = $rate_p_uo_o = $miniodds_info['pb_p_uo']; //"1.95";

			//-> 3게임 : 일반볼 구간
			$rate_n_bs_a = $miniodds_info['pb_n_bs_a']; //"2.80";	// 소
			$rate_n_bs_d = $miniodds_info['pb_n_bs_d']; //"2.65";	// 중
			$rate_n_bs_h = $miniodds_info['pb_n_bs_h']; //"2.80";	// 대

			//-> 4게임 : 파워볼 숫자
			$rate_p_0 = $rate_p_1 = $rate_p_2 = $rate_p_3 = $rate_p_4 = $rate_p_5 = $rate_p_6 = $rate_p_7 = $rate_p_8 = $rate_p_9 = $miniodds_info['pb_p_n']; //"8.95";

			//-> 5게임 : 파워볼 구간
			$rate_p_02 = $miniodds_info['pb_p_02']; //"3.10";	// A(0~2)
			$rate_p_34 = $miniodds_info['pb_p_34']; //"4.70";	// B(3~4)
			$rate_p_56 = $miniodds_info['pb_p_56']; //"4.70";	// C(5~6)
			$rate_p_79 = $miniodds_info['pb_p_79']; //"3.10";	// D(7~9)

			//-> 6게임 : 파워볼 조합
			$rate_p_o_un = $miniodds_info['pb_p_o_un']; //"4.00";	// 홀(언더)
			$rate_p_e_un = $miniodds_info['pb_p_e_un']; //"3.00";	// 짝(언더)
			$rate_p_o_over = $miniodds_info['pb_p_o_ov']; //"3.00";	// 홀(오버)
			$rate_p_e_over = $miniodds_info['pb_p_e_ov']; //"4.00";	// 짝(오버)

            //-> 7게임 : 일반볼 조합
            $rate_n_o_un = $miniodds_info['pb_n_o_un']; //"4.00";	// 홀(언더)
			$rate_n_e_un = $miniodds_info['pb_n_e_un']; //"3.00";	// 짝(언더)
			$rate_n_o_over = $miniodds_info['pb_n_o_ov']; //"3.00";	// 홀(오버)
			$rate_n_e_over = $miniodds_info['pb_n_e_ov']; //"4.00";	// 짝(오버)


			if ( $type == "code" ) {
				$gameTypeList = array(
                    "n-oe-o"=>"p_n-oe","n-oe-e"=>"p_n-oe","n-uo-u"=>"p_n-uo","n-uo-o"=>"p_n-uo",
                    "p-oe-o"=>"p_p-oe","p-oe-e"=>"p_p-oe","p-uo-u"=>"p_p-uo","p-uo-o"=>"p_p-uo",
                    "n-bs-h"=>"p_n-bs","n-bs-d"=>"p_n-bs","n-bs-a"=>"p_n-bs",
                    "p_0"=>"p_01","p_1"=>"p_01","p_2"=>"p_23","p_3"=>"p_23","p_4"=>"p_45","p_5"=>"p_45","p_6"=>"p_67","p_7"=>"p_67","p_8"=>"p_89","p_9"=>"p_89","p_02"=>"p_0279","p_79"=>"p_0279","p_34"=>"p_3456","p_56"=>"p_3456",
                    "p_o-un"=>"p_oe-unover","p_e-over"=>"p_oe-unover","p_e-un"=>"p_eo-unover","p_o-over"=>"p_eo-unover",
                    "n_o-un"=>"p_noe-unover","n_e-over"=>"p_noe-unover","n_e-un"=>"p_neo-unover","n_o-over"=>"p_neo-unover"
                );
				return $gameTypeList[$val];
			} else if ( $type == "rate" ) {
				$gameTypeRateList = array(
                    "n-oe-o"=>$rate_n_oe_o,"n-oe-e"=>$rate_n_oe_e,"n-uo-u"=>$rate_n_uo_u,"n-uo-o"=>$rate_n_uo_o,
                    "p-oe-o"=>$rate_p_oe_o,"p-oe-e"=>$rate_p_oe_e,"p-uo-u"=>$rate_p_uo_u,"p-uo-o"=>$rate_p_uo_o,
                    "n-bs-h"=>$rate_n_bs_a,"n-bs-d"=>$rate_n_bs_d,"n-bs-a"=>$rate_n_bs_h,
                    "p_0"=>$rate_p_0,"p_1"=>$rate_p_1,"p_2"=>$rate_p_2,"p_3"=>$rate_p_3,"p_4"=>$rate_p_4,"p_5"=>$rate_p_5,"p_6"=> $rate_p_6,"p_7"=>$rate_p_7,"p_8"=>$rate_p_8,"p_9"=>$rate_p_9,"p_02"=>$rate_p_02,"p_79"=>$rate_p_79,"p_34"=>$rate_p_34,"p_56"=>$rate_p_56,
                    "p_o-un"=>$rate_p_o_un,"p_e-over"=>$rate_p_e_over,"p_e-un"=>$rate_p_e_un,"p_o-over"=>$rate_p_o_over,
                    "n_o-un"=>$rate_n_o_un,"n_e-over"=>$rate_n_e_over,"n_e-un"=>$rate_n_e_un,"n_o-over"=>$rate_n_o_over
                );
				return $gameTypeRateList[$val];
			} else if ( $type == "selectNo" ) {
				$gameTypeSelectNo = array(
                    "n-oe-o"=>1,"n-oe-e"=>2,"n-uo-u"=>1,"n-uo-o"=>2,
                    "p-oe-o"=>1,"p-oe-e"=>2,"p-uo-u"=>1,"p-uo-o"=>2,
                    "n-bs-h"=>1,"n-bs-d"=>3,"n-bs-a"=>2,
                    "p_0"=>1,"p_1"=>2,"p_2"=>1,"p_3"=>2,"p_4"=>1,"p_5"=>2,"p_6"=>1,"p_7"=>2,"p_8"=>1,"p_9"=>2,"p_02"=>1,"p_79"=>2,"p_34"=>1,"p_56"=>2,
                    "p_o-un"=>1,"p_e-over"=>2,"p_e-un"=>1,"p_o-over"=>2,
                    "n_o-un"=>1,"n_e-over"=>2,"n_e-un"=>1,"n_o-over"=>2
                );
				return $gameTypeSelectNo[$val];
			} else if ( $type == "infoList" ) {
				if ( $val == "n-oe-o" or $val == "n-oe-e" )	{
					return array("homeRate"=>$rate_n_oe_o,"drawRate"=>"1.0","awayRate"=>$rate_n_oe_e,"homeTeam"=>"회차 [일반볼 홀]","awayTeam"=>"회차 [일반볼 짝]");
				} else if ( $val == "n-uo-u" or $val == "n-uo-o" )	{
                    return array("homeRate"=>$rate_n_uo_u,"drawRate"=>"1.0","awayRate"=>$rate_n_uo_o,"homeTeam"=>"회차 [일반볼 언더]","awayTeam"=>"회차 [일반볼 오버]");
                } else if ( $val == "p-oe-o" or $val == "p-oe-e" )	{
					return array("homeRate"=>$rate_p_oe_o,"drawRate"=>"1.0","awayRate"=>$rate_p_oe_e,"homeTeam"=>"회차 [파워볼 홀]","awayTeam"=>"회차 [파워볼 짝]");
				} else if ( $val == "p-uo-u" or $val == "p-uo-o" )	{
                    return array("homeRate"=>$rate_p_uo_u,"drawRate"=>"1.0","awayRate"=>$rate_p_oe_e,"homeTeam"=>"회차 [파워볼 언더]","awayTeam"=>"회차 [파워볼 오버]");
                } else if ( $val == "n-bs-h" or $val == "n-bs-d" or $val == "n-bs-a" )	{
					return array("homeRate"=>$rate_n_bs_a,"drawRate"=>$rate_n_bs_d,"awayRate"=>$rate_n_bs_h,"homeTeam"=>"회차 [대 81~130]","awayTeam"=>"회차 [소 15~64]");
				} else if ( $val == "p_0" or $val == "p_1" )	{
					return array("homeRate"=>$rate_p_0,"drawRate"=>"1.0","awayRate"=>$rate_p_1,"homeTeam"=>"회차 [파워볼 0]","awayTeam"=>"회차 [파워볼 1]");
				} else if ( $val == "p_2" or $val == "p_3" )	{
					return array("homeRate"=>$rate_p_2,"drawRate"=>"1.0","awayRate"=>$rate_p_3,"homeTeam"=>"회차 [파워볼 2]","awayTeam"=>"회차 [파워볼 3]");
				} else if ( $val == "p_4" or $val == "p_5" )	{
					return array("homeRate"=>$rate_p_4,"drawRate"=>"1.0","awayRate"=>$rate_p_5,"homeTeam"=>"회차 [파워볼 4]","awayTeam"=>"회차 [파워볼 5]");
				} else if ( $val == "p_6" or $val == "p_7" )	{
					return array("homeRate"=>$rate_p_6,"drawRate"=>"1.0","awayRate"=>$rate_p_7,"homeTeam"=>"회차 [파워볼 6]","awayTeam"=>"회차 [파워볼 7]");
				} else if ( $val == "p_8" or $val == "p_9" )	{
					return array("homeRate"=>$rate_p_8,"drawRate"=>"1.0","awayRate"=>$rate_p_9,"homeTeam"=>"회차 [파워볼 8]","awayTeam"=>"회차 [파워볼 9]");
				} else if ( $val == "p_02" or $val == "p_79" )	{
					return array("homeRate"=>$rate_p_02,"drawRate"=>"1.0","awayRate"=>$rate_p_79,"homeTeam"=>"회차 [파워볼 0~2]","awayTeam"=>"회차 [파워볼 7~9]");
				} else if ( $val == "p_34" or $val == "p_56" )	{
					return array("homeRate"=>$rate_p_34,"drawRate"=>"1.0","awayRate"=>$rate_p_56,"homeTeam"=>"회차 [파워볼 3~4]","awayTeam"=>"회차 [파워볼 5~6]");
				} else if ( $val == "p_o-un" or $val == "p_e-over" )	{
					return array("homeRate"=>$rate_p_o_un,"drawRate"=>"1.0","awayRate"=>$rate_p_e_over,"homeTeam"=>"회차 [파워볼 홀언더]","awayTeam"=>"회차 [파워볼 짝오버]");
				} else if ( $val == "p_e-un" or $val == "p_o-over" )	{
					return array("homeRate"=>$rate_p_e_un,"drawRate"=>"1.0","awayRate"=>$rate_p_o_over,"homeTeam"=>"회차 [파워볼 짝언더]","awayTeam"=>"회차 [파워볼 홀오버]");
				} else if ( $val == "n_o-un" or $val == "n_e-over" )	{
					return array("homeRate"=>$rate_p_o_un,"drawRate"=>"1.0","awayRate"=>$rate_p_e_over,"homeTeam"=>"회차 [일반볼 홀언더]","awayTeam"=>"회차 [일반볼 짝오버]");
				} else if ( $val == "n_e-un" or $val == "n_o-over" )	{
					return array("homeRate"=>$rate_p_e_un,"drawRate"=>"1.0","awayRate"=>$rate_p_o_over,"homeTeam"=>"회차 [일반볼 짝언더]","awayTeam"=>"회차 [일반볼 홀오버]");
				}
			}
		}  else if ( $btGameName == "powersadari" ) {
            $rate_odd = $rate_even = $miniodds_info['ps_oe'];//"1.94";
            $rate_left = $rate_right = $miniodds_info['ps_lr'];//"1.93";
            $rate_3line = $rate_4line = $miniodds_info['ps_line'];//"1.93";
            $rate_even3line_left = $rate_odd4line_left = $miniodds_info['ps_oeline_lr'];//"3.60";
            $rate_odd3line_right = $rate_even4line_right = $miniodds_info['ps_oeline_lr'];//"3.60";

            if ( $type == "code" ) {
                $gameTypeList = array("odd"=>"ps_oe", "even"=>"ps_oe", "left"=>"ps_lr", "right"=>"ps_lr", "3line"=>"ps_34", "4line"=>"ps_34",
                    "even3line_left"=>"ps_e3o4l","odd4line_left"=>"ps_e3o4l", "odd3line_right"=>"ps_o3e4r", "even4line_right"=>"ps_o3e4r");
                return $gameTypeList[$val];
            } else if ( $type == "rate" ) {
                $gameTypeRateList = array("odd"=>$rate_odd, "even"=>$rate_even, "left"=>$rate_left, "right"=>$rate_right, "3line"=>$rate_3line,"4line"=>$rate_4line,
                    "even3line_left"=>$rate_even3line_left,"odd4line_left"=>$rate_odd4line_left,"odd3line_right"=>$rate_odd3line_right,"even4line_right"=>$rate_even4line_right);
                return $gameTypeRateList[$val];
            } else if ( $type == "selectNo" ) {
                $gameTypeSelectNo = array("odd"=>1, "even"=>2, "left"=>1, "right"=>2, "3line"=>1, "4line"=>2, "even3line_left"=>1, "odd4line_left"=>2, "odd3line_right"=>1, "even4line_right"=>2);
                return $gameTypeSelectNo[$val];
            } else if ( $type == "infoList" ) {
                if ( $val == "odd" or $val == "even" ) {
                    return array("homeRate"=>$rate_odd,"drawRate"=>"1.0","awayRate"=>$rate_even,"homeTeam"=>"회차 [홀]","awayTeam"=>"회차 [짝]");
                } else if ( $val == "left" or $val == "right" ) {
                    return array("homeRate"=>$rate_left,"drawRate"=>"1.0","awayRate"=>$rate_right,"homeTeam"=>"회차 [좌]","awayTeam"=>"회차 [우]");
                } else if ( $val == "3line" or $val == "4line" ) {
                    return array("homeRate"=>$rate_3line,"drawRate"=>"1.0","awayRate"=>$rate_4line,"homeTeam"=>"회차 [3줄]","awayTeam"=>"회차 [4줄]");
                } else if ( $val == "even3line_left" or $val == "odd4line_left" ) {
                    return array("homeRate"=>$rate_even3line_left,"drawRate"=>"1.0","awayRate"=>$rate_odd4line_left,"homeTeam"=>"회차 [짝3줄좌]","awayTeam"=>"회차 [홀4줄좌]");
                } else if ( $val == "odd3line_right" or $val == "even4line_right" ) {
                    return array("homeRate"=>$rate_odd3line_right,"drawRate"=>"1.0","awayRate"=>$rate_even4line_right,"homeTeam"=>"회차 [홀3줄우]","awayTeam"=>"회차 [짝4줄우]");
                }
            }
        } else if ( $btGameName == "kenosadari" ) {
            $rate_odd = $rate_even = $miniodds_info['ks_oe'];//"1.94";
            $rate_left = $rate_right = $miniodds_info['ks_lr'];//"1.93";
            $rate_3line = $rate_4line = $miniodds_info['ks_line'];//"1.93";
            $rate_even3line_left = $rate_odd4line_left = $miniodds_info['ks_oeline_lr'];//"3.70";
            $rate_odd3line_right = $rate_even4line_right = $miniodds_info['ks_oeline_lr'];//"3.70";

            if ( $type == "code" ) {
                $gameTypeList = array("odd"=>"ks_oe", "even"=>"ks_oe", "left"=>"ks_lr", "right"=>"ks_lr", "3line"=>"ks_34", "4line"=>"ks_34",
                    "even3line_left"=>"ks_e3o4l","odd4line_left"=>"ks_e3o4l", "odd3line_right"=>"ks_o3e4r", "even4line_right"=>"ks_o3e4r");
                return $gameTypeList[$val];
            } else if ( $type == "rate" ) {
                $gameTypeRateList = array("odd"=>$rate_odd, "even"=>$rate_even, "left"=>$rate_left, "right"=>$rate_right, "3line"=>$rate_3line,"4line"=>$rate_4line,
                    "even3line_left"=>$rate_even3line_left,"odd4line_left"=>$rate_odd4line_left,"odd3line_right"=>$rate_odd3line_right,"even4line_right"=>$rate_even4line_right);
                return $gameTypeRateList[$val];
            } else if ( $type == "selectNo" ) {
                $gameTypeSelectNo = array("odd"=>1, "even"=>2, "left"=>1, "right"=>2, "3line"=>1, "4line"=>2, "even3line_left"=>1, "odd4line_left"=>2, "odd3line_right"=>1, "even4line_right"=>2);
                return $gameTypeSelectNo[$val];
            } else if ( $type == "infoList" ) {
                if ( $val == "odd" or $val == "even" ) {
                    return array("homeRate"=>$rate_odd,"drawRate"=>"1.0","awayRate"=>$rate_even,"homeTeam"=>"회차 [홀]","awayTeam"=>"회차 [짝]");
                } else if ( $val == "left" or $val == "right" ) {
                    return array("homeRate"=>$rate_left,"drawRate"=>"1.0","awayRate"=>$rate_right,"homeTeam"=>"회차 [좌]","awayTeam"=>"회차 [우]");
                } else if ( $val == "3line" or $val == "4line" ) {
                    return array("homeRate"=>$rate_3line,"drawRate"=>"1.0","awayRate"=>$rate_4line,"homeTeam"=>"회차 [3줄]","awayTeam"=>"회차 [4줄]");
                } else if ( $val == "even3line_left" or $val == "odd4line_left" ) {
                    return array("homeRate"=>$rate_even3line_left,"drawRate"=>"1.0","awayRate"=>$rate_odd4line_left,"homeTeam"=>"회차 [짝3줄좌]","awayTeam"=>"회차 [홀4줄좌]");
                } else if ( $val == "odd3line_right" or $val == "even4line_right" ) {
                    return array("homeRate"=>$rate_odd3line_right,"drawRate"=>"1.0","awayRate"=>$rate_even4line_right,"homeTeam"=>"회차 [홀3줄우]","awayTeam"=>"회차 [짝4줄우]");
                }
            }
        } else if ( $btGameName == "aladin" ) {
            //-> 1게임 : 홀/짝
            $rate_odd = $rate_even = "1.95";
            //-> 2게임 : 출발줄/줄갯수
            $rate_left = $rate_right = "1.95";
            $rate_3line = $rate_4line = "1.95";
            //-> 3게임 : 좌우+출발+3/4줄
            $rate_even3line_left = $rate_odd4line_left = "3.70";
            $rate_odd3line_right = $rate_even4line_right = "3.70";

            if ( $type == "code" ) {
                $gameTypeList = array("odd"=>"a_oe", "even"=>"a_oe", "left"=>"a_lr", "right"=>"a_lr", "3line"=>"a_34", "4line"=>"a_34",
                    "even3line_left"=>"a_e3o4l","odd4line_left"=>"a_e3o4l", "odd3line_right"=>"a_o3e4r", "even4line_right"=>"a_o3e4r");
                return $gameTypeList[$val];
            } else if ( $type == "rate" ) {
                $gameTypeRateList = array("odd"=>$rate_odd, "even"=>$rate_even, "left"=>$rate_left, "right"=>$rate_right, "3line"=>$rate_3line,"4line"=>$rate_4line,
                    "even3line_left"=>$rate_even3line_left,"odd4line_left"=>$rate_odd4line_left,"odd3line_right"=>$rate_odd3line_right,"even4line_right"=>$rate_even4line_right);
                return $gameTypeRateList[$val];
            } else if ( $type == "selectNo" ) {
                $gameTypeSelectNo = array("odd"=>1,"even"=>2,"left"=>1,"right"=>2,"3line"=>1,"4line"=>2,"even3line_left"=>1,"odd4line_left"=>2,"odd3line_right"=>1,"even4line_right"=>2);
                return $gameTypeSelectNo[$val];
            } else if ( $type == "infoList" ) {
                if ( $val == "odd" or $val == "even" ) {
                    return array("homeRate"=>$rate_odd,"drawRate"=>"1.0","awayRate"=>$rate_even,"homeTeam"=>"회차 [홀]","awayTeam"=>"회차 [짝]");
                } else if ( $val == "left" or $val == "right" ) {
                    return array("homeRate"=>$rate_left,"drawRate"=>"1.0","awayRate"=>$rate_right,"homeTeam"=>"회차 [좌]","awayTeam"=>"회차 [우]");
                } else if ( $val == "3line" or $val == "4line" ) {
                    return array("homeRate"=>$rate_3line,"drawRate"=>"1.0","awayRate"=>$rate_4line,"homeTeam"=>"회차 [3줄]","awayTeam"=>"회차 [4줄]");
                } else if ( $val == "even3line_left" or $val == "odd4line_left" ) {
                    return array("homeRate"=>$rate_even3line_left,"drawRate"=>"1.0","awayRate"=>$rate_odd4line_left,"homeTeam"=>"회차 [짝3줄좌]","awayTeam"=>"회차 [홀4줄좌]");
                } else if ( $val == "odd3line_right" or $val == "even4line_right" ) {
                    return array("homeRate"=>$rate_odd3line_right,"drawRate"=>"1.0","awayRate"=>$rate_even4line_right,"homeTeam"=>"회차 [홀3줄우]","awayTeam"=>"회차 [짝4줄우]");
                }
            }
        } else if ( $btGameName == "lowhi" ) {
            //-> 1게임 : L/H
            $rate_low = $rate_hi = "1.95";
            //-> 2게임 : 홀/짝
            $rate_odd = $rate_even = "1.95";

            if ( $type == "code" ) {
                $gameTypeList = array("low"=>"lh_lh", "hi"=>"lh_lh", "odd"=>"lh_oe", "even"=>"lh_oe");
                return $gameTypeList[$val];
            } else if ( $type == "rate" ) {
                $gameTypeRateList = array("low"=>$rate_low, "hi"=>$rate_hi, "odd"=>$rate_odd, "even"=>$rate_even);
                return $gameTypeRateList[$val];
            } else if ( $type == "selectNo" ) {
                $gameTypeSelectNo = array("low"=>1,"hi"=>2,"odd"=>1,"even"=>2);
                return $gameTypeSelectNo[$val];
            } else if ( $type == "infoList" ) {
                if ( $val == "low" or $val == "hi" ) {
                    return array("homeRate"=>$rate_low,"drawRate"=>"1.0","awayRate"=>$rate_hi,"homeTeam"=>"회차 [L]","awayTeam"=>"회차 [H]");
                } else if ( $val == "odd" or $val == "even" ) {
                    return array("homeRate"=>$rate_odd,"drawRate"=>"1.0","awayRate"=>$rate_even,"homeTeam"=>"회차 [홀]","awayTeam"=>"회차 [짝]");
                }
            }
        } else if ( $btGameName == "mgmbacara" ) {
            $rate_player = $miniodds_info['mb_player'];//"1.95";
            $rate_banker = $miniodds_info['mb_banker'];//"1.93";
            $rate_player_pair = $rate_banker_pair = $miniodds_info['mb_pp_pb'];//"7.90";
            $rate_tai = $miniodds_info['mb_t'];//"7.00";

            if ( $type == "code" ) {
                $gameTypeList = array("player"=>"mgmbacara_pb", "banker"=>"mgmbacara_pb", "player_pair"=>"mgmbacara_pp", "banker_pair"=>"mgmbacara_bp", "tai"=>"mgmbacara_tai");
                return $gameTypeList[$val];
            } else if ( $type == "rate" ) {
                $gameTypeRateList = array("player"=>$rate_player, "banker"=>$rate_banker, "player_pair"=>$rate_player_pair, "banker_pair"=>$rate_banker_pair, "tai"=>$rate_tai);
                return $gameTypeRateList[$val];
            } else if ( $type == "selectNo" ) {
                $gameTypeSelectNo = array("player"=>1, "banker"=>2, "player_pair"=>1, "banker_pair"=>1, "tai"=>1);
                return $gameTypeSelectNo[$val];
            } else if ( $type == "infoList" ) {
                if ( $val == "player" or $val == "banker" ) {
                    return array("homeRate"=>$rate_player,"drawRate"=>"1.0","awayRate"=>$rate_banker,"homeTeam"=>"회차 [플레이어]","awayTeam"=>"회차 [뱅커]");
                } else if ( $val == "player_pair" ) {
                    return array("homeRate"=>$rate_player_pair,"drawRate"=>"1.0","awayRate"=>"1.0","homeTeam"=>"회차 [플레이어-페어]","awayTeam"=>"회차 [플레이어-노페어]");
                } else if ( $val == "banker_pair" ) {
                    return array("homeRate"=>$rate_banker_pair,"drawRate"=>"1.0","awayRate"=>"1.0","homeTeam"=>"회차 [뱅커-페어]","awayTeam"=>"회차 [뱅커-노페어]");
                } else if ( $val == "tai" ) {
                    return array("homeRate"=>$rate_tai,"drawRate"=>"1.0","awayRate"=>"1.0","homeTeam"=>"회차 [타이]","awayTeam"=>"회차 [노타이]");
                }
            }
        } else if ( $btGameName == "mgmoddeven" ) {
            $rate_odd = $rate_even = $miniodds_info['moe_oe']; //"1.95";
            $rate_under = $rate_over = $miniodds_info['moe_uo']; //"1.93";
            $rate_blue = $rate_red = $miniodds_info['moe_br']; //"1.93";

            if ( $type == "code" ) {
                $gameTypeList = array("odd"=>"mgmoddeven_oe", "even"=>"mgmoddeven_oe", "under"=>"mgmoddeven_uo", "over"=>"mgmoddeven_uo", "blue"=>"mgmoddeven_br", "red"=>"mgmoddeven_br");
                return $gameTypeList[$val];
            } else if ( $type == "rate" ) {
                $gameTypeRateList = array("odd"=>$rate_odd, "even"=>$rate_even, "under"=>$rate_under, "over"=>$rate_over, "blue"=>$rate_blue, "red"=>$rate_red);
                return $gameTypeRateList[$val];
            } else if ( $type == "selectNo" ) {
                $gameTypeSelectNo = array("odd"=>1, "even"=>2, "under"=>1, "over"=>2, "blue"=>1, "red"=>2);
                return $gameTypeSelectNo[$val];
            } else if ( $type == "infoList" ) {
                if ( $val == "odd" or $val == "even" ) {
                    return array("homeRate"=>$rate_odd,"drawRate"=>"1.0","awayRate"=>$rate_even,"homeTeam"=>"회차 [홀]","awayTeam"=>"회차 [짝]");
                } else if ( $val == "under" or $val == "over" ) {
                    return array("homeRate"=>$rate_under,"drawRate"=>"1.0","awayRate"=>$rate_over,"homeTeam"=>"회차 [언더]","awayTeam"=>"회차 [오버]");
                }  else if ( $val == "blue" or $val == "red" ) {
                    return array("homeRate"=>$rate_blue,"drawRate"=>"1.0","awayRate"=>$rate_red,"homeTeam"=>"회차 [히든볼 Blue]","awayTeam"=>"회차 [히든볼 Red]");
                }
            }
        } else if ( $btGameName == "2dari" ) {
            $rate_odd = $rate_even = $miniodds_info['d2_oe']; //"1.94";
            $rate_left = $rate_right = $miniodds_info['d2_lr']; //"1.93";
            $rate_3line = $rate_4line = $miniodds_info['d2_line']; //"1.93";
            $rate_even3line_left = $rate_odd4line_left = $miniodds_info['d2_oeline_lr']; //"3.60";
            $rate_odd3line_right = $rate_even4line_right = $miniodds_info['d2_oeline_lr']; //"3.60";

            if ( $type == "code" ) {
                $gameTypeList = array("odd"=>"2d_oe", "even"=>"2d_oe", "left"=>"2d_lr", "right"=>"2d_lr", "3line"=>"2d_34", "4line"=>"2d_34",
                    "even3line_left"=>"2d_e3o4l","odd4line_left"=>"2d_e3o4l", "odd3line_right"=>"2d_o3e4r", "even4line_right"=>"2d_o3e4r");
                return $gameTypeList[$val];
            } else if ( $type == "rate" ) {
                $gameTypeRateList = array("odd"=>$rate_odd, "even"=>$rate_even, "left"=>$rate_left, "right"=>$rate_right, "3line"=>$rate_3line,"4line"=>$rate_4line,
                    "even3line_left"=>$rate_even3line_left,"odd4line_left"=>$rate_odd4line_left,"odd3line_right"=>$rate_odd3line_right,"even4line_right"=>$rate_even4line_right);
                return $gameTypeRateList[$val];
            } else if ( $type == "selectNo" ) {
                $gameTypeSelectNo = array("odd"=>1, "even"=>2, "left"=>1, "right"=>2, "3line"=>1, "4line"=>2, "even3line_left"=>1, "odd4line_left"=>2, "odd3line_right"=>1, "even4line_right"=>2);
                return $gameTypeSelectNo[$val];
            } else if ( $type == "infoList" ) {
                if ( $val == "odd" or $val == "even" ) {
                    return array("homeRate"=>$rate_odd,"drawRate"=>"1.0","awayRate"=>$rate_even,"homeTeam"=>"회차 [홀]","awayTeam"=>"회차 [짝]");
                } else if ( $val == "left" or $val == "right" ) {
                    return array("homeRate"=>$rate_left,"drawRate"=>"1.0","awayRate"=>$rate_right,"homeTeam"=>"회차 [좌]","awayTeam"=>"회차 [우]");
                } else if ( $val == "3line" or $val == "4line" ) {
                    return array("homeRate"=>$rate_3line,"drawRate"=>"1.0","awayRate"=>$rate_4line,"homeTeam"=>"회차 [3줄]","awayTeam"=>"회차 [4줄]");
                } else if ( $val == "even3line_left" or $val == "odd4line_left" ) {
                    return array("homeRate"=>$rate_even3line_left,"drawRate"=>"1.0","awayRate"=>$rate_odd4line_left,"homeTeam"=>"회차 [짝3줄좌]","awayTeam"=>"회차 [홀4줄좌]");
                } else if ( $val == "odd3line_right" or $val == "even4line_right" ) {
                    return array("homeRate"=>$rate_odd3line_right,"drawRate"=>"1.0","awayRate"=>$rate_even4line_right,"homeTeam"=>"회차 [홀3줄우]","awayTeam"=>"회차 [짝4줄우]");
                }
            }
        } else if ( $btGameName == "3dari" ) {
            $rate_odd = $rate_even = $miniodds_info['d3_oe']; //"1.94";
            $rate_left = $rate_right = $miniodds_info['d3_lr']; //"1.93";
            $rate_3line = $rate_4line = $miniodds_info['d3_line']; //"1.93";
            $rate_even3line_left = $rate_odd4line_left = $miniodds_info['d3_oeline_lr']; //"3.60";
            $rate_odd3line_right = $rate_even4line_right = $miniodds_info['d3_oeline_lr']; //"3.60";

            if ( $type == "code" ) {
                $gameTypeList = array("odd"=>"3d_oe", "even"=>"3d_oe", "left"=>"3d_lr", "right"=>"3d_lr", "3line"=>"3d_34", "4line"=>"3d_34",
                    "even3line_left"=>"3d_e3o4l","odd4line_left"=>"3d_e3o4l", "odd3line_right"=>"3d_o3e4r", "even4line_right"=>"3d_o3e4r");
                return $gameTypeList[$val];
            } else if ( $type == "rate" ) {
                $gameTypeRateList = array("odd"=>$rate_odd, "even"=>$rate_even, "left"=>$rate_left, "right"=>$rate_right, "3line"=>$rate_3line,"4line"=>$rate_4line,
                    "even3line_left"=>$rate_even3line_left,"odd4line_left"=>$rate_odd4line_left,"odd3line_right"=>$rate_odd3line_right,"even4line_right"=>$rate_even4line_right);
                return $gameTypeRateList[$val];
            } else if ( $type == "selectNo" ) {
                $gameTypeSelectNo = array("odd"=>1, "even"=>2, "left"=>1, "right"=>2, "3line"=>1, "4line"=>2, "even3line_left"=>1, "odd4line_left"=>2, "odd3line_right"=>1, "even4line_right"=>2);
                return $gameTypeSelectNo[$val];
            } else if ( $type == "infoList" ) {
                if ( $val == "odd" or $val == "even" ) {
                    return array("homeRate"=>$rate_odd,"drawRate"=>"1.0","awayRate"=>$rate_even,"homeTeam"=>"회차 [홀]","awayTeam"=>"회차 [짝]");
                } else if ( $val == "left" or $val == "right" ) {
                    return array("homeRate"=>$rate_left,"drawRate"=>"1.0","awayRate"=>$rate_right,"homeTeam"=>"회차 [좌]","awayTeam"=>"회차 [우]");
                } else if ( $val == "3line" or $val == "4line" ) {
                    return array("homeRate"=>$rate_3line,"drawRate"=>"1.0","awayRate"=>$rate_4line,"homeTeam"=>"회차 [3줄]","awayTeam"=>"회차 [4줄]");
                } else if ( $val == "even3line_left" or $val == "odd4line_left" ) {
                    return array("homeRate"=>$rate_even3line_left,"drawRate"=>"1.0","awayRate"=>$rate_odd4line_left,"homeTeam"=>"회차 [짝3줄좌]","awayTeam"=>"회차 [홀4줄좌]");
                } else if ( $val == "odd3line_right" or $val == "even4line_right" ) {
                    return array("homeRate"=>$rate_odd3line_right,"drawRate"=>"1.0","awayRate"=>$rate_even4line_right,"homeTeam"=>"회차 [홀3줄우]","awayTeam"=>"회차 [짝4줄우]");
                }
            }
        } else if ( $btGameName == "choice" ) {
            $rate_black = $rate_white = $miniodds_info['choice_bw']; //"1.94";

            if ( $type == "code" ) {
                $gameTypeList = array("black"=>"choice_bw", "white"=>"choice_bw");
                return $gameTypeList[$val];
            } else if ( $type == "rate" ) {
                $gameTypeRateList = array("black"=>$rate_black, "white"=>$rate_white);
                return $gameTypeRateList[$val];
            } else if ( $type == "selectNo" ) {
                $gameTypeSelectNo = array("black"=>1, "white"=>2);
                return $gameTypeSelectNo[$val];
            } else if ( $type == "infoList" ) {
                if ( $val == "black" or $val == "white" ) {
                    return array("homeRate"=>$rate_black,"drawRate"=>"1.0","awayRate"=>$rate_white,"homeTeam"=>"회차 [BLACK]","awayTeam"=>"회차 [WHITE]");
                }
            }
        } else if ( $btGameName == "roulette" ) {
            $rate_red = $rate_black = $miniodds_info['roulette_rb']; //"1.94";

            if ( $type == "code" ) {
                $gameTypeList = array("red"=>"roulette_rb", "black"=>"roulette_rb");
                return $gameTypeList[$val];
            } else if ( $type == "rate" ) {
                $gameTypeRateList = array("red"=>$rate_red, "black"=>$rate_black);
                return $gameTypeRateList[$val];
            } else if ( $type == "selectNo" ) {
                $gameTypeSelectNo = array("red"=>1, "black"=>2);
                return $gameTypeSelectNo[$val];
            } else if ( $type == "infoList" ) {
                if ( $val == "red" or $val == "black" ) {
                    return array("homeRate"=>$rate_red,"drawRate"=>"1.0","awayRate"=>$rate_black,"homeTeam"=>"회차 [RED]","awayTeam"=>"회차 [BLACK]");
                }
            }
        } else if ( $btGameName == "nine" ) {
            $rate_odd = $rate_even =  $miniodds_info['nine_oe']; //"1.95";
            $rate_left = $rate_right = $miniodds_info['nine_lr']; //"1.93";
            $rate_tai = $miniodds_info['nine_t']; //"7.00";

            if ( $type == "code" ) {
                $gameTypeList = array("odd"=>"nine_oe", "even"=>"nine_oe", "left"=>"nine_lr", "right"=>"nine_lr","tai"=>"nine_tai");
                return $gameTypeList[$val];
            } else if ( $type == "rate" ) {
                $gameTypeRateList = array("odd"=>$rate_odd, "even"=>$rate_even, "left"=>$rate_left, "right"=>$rate_right,"tai"=>$rate_tai);
                return $gameTypeRateList[$val];
            } else if ( $type == "selectNo" ) {
                $gameTypeSelectNo = array("odd"=>1, "even"=>2, "left"=>1, "right"=>2,  "tai"=>1);
                return $gameTypeSelectNo[$val];
            } else if ( $type == "infoList" ) {
                if ( $val == "odd" or $val == "even" ) {
                    return array("homeRate"=>$rate_odd,"drawRate"=>"1.0","awayRate"=>$rate_even,"homeTeam"=>"회차 [홀]","awayTeam"=>"회차 [짝]");
                } else if ( $val == "left" or $val == "right" ) {
                    return array("homeRate"=>$rate_left,"drawRate"=>"1.0","awayRate"=>$rate_right,"homeTeam"=>"회차 [좌]","awayTeam"=>"회차 [우]");
                } else if ( $val == "tai" ) {
                    return array("homeRate"=>$rate_tai,"drawRate"=>"1.0","awayRate"=>"1.0","homeTeam"=>"회차 [타이]","awayTeam"=>"회차 [노타이]");
                }
            }
        } else if ( $btGameName == "pharaoh" ) {
            $rate_heart = $rate_spade = $miniodds_info['pharaoh_hs']; //"1.94";

            if ( $type == "code" ) {
                $gameTypeList = array("heart"=>"pharaoh_hs", "spade"=>"pharaoh_hs");
                return $gameTypeList[$val];
            } else if ( $type == "rate" ) {
                $gameTypeRateList = array("heart"=>$rate_heart, "spade"=>$rate_spade);
                return $gameTypeRateList[$val];
            } else if ( $type == "selectNo" ) {
                $gameTypeSelectNo = array("heart"=>1, "spade"=>2);
                return $gameTypeSelectNo[$val];
            } else if ( $type == "infoList" ) {
                if ( $val == "heart" or $val == "spade" ) {
                    return array("homeRate"=>$rate_heart,"drawRate"=>"1.0","awayRate"=>$rate_spade,"homeTeam"=>"회차 [HEART]","awayTeam"=>"회차 [SPADE]");
                }
            }
        }  else if ( $btGameName == "fx") {
            $rate_odd = $rate_even = $miniodds_info['fx_oe'];//"1.94";
            $rate_under = $rate_over = $miniodds_info['fx_uo'];//"1.93";
            $rate_buy = $rate_sell = $miniodds_info['fx_bs'];//"1.93";

            if ( $type == "code" ) {
                $gameTypeList = array("odd"=>"fx_oe", "even"=>"fx_oe", "under"=>"fx_uo", "over"=>"fx_uo", "buy"=>"fx_bs", "sell"=>"fx_bs");
                return $gameTypeList[$val];
            } else if ( $type == "rate" ) {
                $gameTypeRateList = array("odd"=>$rate_odd, "even"=>$rate_even, "under"=>$rate_under, "over"=>$rate_over, "buy"=>$rate_buy,"sell"=>$rate_sell);
                return $gameTypeRateList[$val];
            } else if ( $type == "selectNo" ) {
                $gameTypeSelectNo = array("odd"=>1, "even"=>2, "under"=>1, "over"=>2, "buy"=>1, "sell"=>2);
                return $gameTypeSelectNo[$val];
            } else if ( $type == "infoList" ) {
                if ( $val == "odd" or $val == "even" ) {
                    return array("homeRate"=>$rate_odd,"drawRate"=>"1.0","awayRate"=>$rate_even,"homeTeam"=>"회차 [홀]","awayTeam"=>"회차 [짝]");
                } else if ( $val == "under" or $val == "over" ) {
                    return array("homeRate"=>$rate_under,"drawRate"=>"1.0","awayRate"=>$rate_over,"homeTeam"=>"회차 [언더]","awayTeam"=>"회차 [오버]");
                } else if ( $val == "buy" or $val == "sell" ) {
                    return array("homeRate"=>$rate_buy,"drawRate"=>"1.0","awayRate"=>$rate_sell,"homeTeam"=>"회차 [매수]","awayTeam"=>"회차 [매도]");
                }
            }
        }
	}

}
?>