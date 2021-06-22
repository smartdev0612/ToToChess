<?
class RaceserverController extends WebServiceController 
{
	function layoutDefine($type='') {
	}
	
	public function indexAction($id='') {
	}
	
	//▶ 배팅
	function bettingProcessAction() {
		exit;

		$result = array();
		$result["result"]	= "error";

		$this->req->xssClean();

		$loginModel = $this->getModel('LoginModel');
		$mModel = $this->getModel('MemberModel');
		$cModel = $this->getModel('ConfigModel');
		$gModel = $this->getModel('GameModel');
		$cartModel = $this->getModel('CartModel');
		$pModel = $this->getModel('ProcessModel');

		//-> 기본설정값
		$buy = "Y";
		$mode = "betting";
		$gameType = 1;
		$betting_cnt = 1;
		$specialType = 3;
		$lastSpecialCode = 3;

		$user_id = $this->request("user_id");				//-> 아이디
		$user_pw = $this->request("user_pw");				//-> 패스워드
		$bet_money = $this->request("bet_money");		//-> 배팅금액
		$game_th = $this->request("game_th");				//-> 게임회차
		$bet_local = $this->request("bet_local");		//-> 배팅위치 (odd/even/line3/line4/left/right)

		//->테스트
/*
		$user_id = "dtest";
		$user_pw = "roqkf!";
		$bet_money = 5000;
		$game_th = 35;
		$bet_local = "right";
*/

		//-> 넘어온값 로그 남기기.
		//$logs = $user_id."|".$user_pw."|".$bet_money."|".$game_th."|".$bet_local;
		//$loginModel->auto_betting_log($logs);

		//-> 관라자 : 점검 체크.
		$rs = $cModel->getAdminConfigRow();
		if ( $rs['maintain'] == 2 ) {
			$result["result"] = "Inspection Service";
			echo json_encode($result);
			exit;
		}

		if ( !trim($user_id) ) {
			$result["result"] = "Parameter error [user_id]";
			echo json_encode($result);
			exit;
		}

		if ( !trim($user_pw) ) {
			$result["result"] = "Parameter error [user_pw]";
			echo json_encode($result);
			exit;
		}

		if ( !trim($bet_money) ) {
			$result["result"] = "Parameter error [bet_money]";
			echo json_encode($result);
			exit;
		}

		if ( !trim($game_th) ) {
			$result["result"] = "Parameter error [game_th]";
			echo json_encode($result);
			exit;
		}

		if ( !trim($bet_local) ) {
			$result["result"] = "Parameter error [bet_local]";
			echo json_encode($result);
			exit;
		}

		if ( $bet_local != "odd" and $bet_local != "even" and $bet_local != "line3" and $bet_local != "line4" and$bet_local != "left" and $bet_local != "right" ) {
			$result["result"] = "Parameter error (betting local)";
			echo json_encode($result);
			exit;
		}

		//-> 계정확인
		if ( strpos($user_id, "'") !== false ) {
			$result["result"] = "Invalid value";
			echo json_encode($result);
			exit;
		}
		$memberInfo = $loginModel->loginMemberServer($user_id, $user_pw);
		if ( gettype($memberInfo) != "array" ) {
			$result["result"] = "Account is used to stop";
			echo json_encode($result);
			exit();
		}
		$user_sn = $memberInfo["sn"];	//-> 회원 시퀀스 번호
		$user_money = $memberInfo["g_money"];

		//-> 배팅금 확인
		if ( $bet_money > 2000000 ) {
			$result["result"] = "Exceed the amount bet";
			echo json_encode($result);
			exit();
		}
		if( $bet_money > $user_money ) {
			$result["result"] = "Lack of reserve money";
			echo json_encode($result);
			exit();
		}

		//-> 게임번호생성
		$lastIdx = $cartModel->getLastCartIndex();		
		$nowtime = date("Y-m-d H:i:s");
		$protoId = strtotime($nowtime) - strtotime("2000-01-01")+(9*60*60);
		$protoId = $protoId + $lastIdx;
		if($protoId == "") {
			$result["result"] = "Purchase number generation failed";
			echo json_encode($result);
			exit();
		}
		$protoId = $user_sn.$protoId;

		//-> 경기정보
		$gameInfo = $gModel->getSadariInfo($game_th, $bet_local);		//-> tb_child 정보
		if ( gettype($gameInfo) != "array" ) {
			$result["result"] = "Search for a game failure";
			echo json_encode($result);
			exit();
		}
		$childSn = $gameInfo["sn"];	//-> 게임번호 (tb_child)
		$gameSubInfo = $gModel->getSadariSubChild($childSn);				//-> tb_subchild 정보

		//-> 배팅 중복 체크. (중복되었다면 배팅성공으로 출력)
		$betCheck = $gModel->getSadariBettingInfo($user_sn, $gameSubInfo["sn"]);
		if ( gettype($betCheck) == "array" ) {
			$result["result"] = "ok";
			$result["money"] = $user_money;
			echo json_encode($result);
			exit();
		}
		
		//-> 배팅위치
		if ( $bet_local == "odd" or $bet_local == "left" or $bet_local == "line3" ) {
			//-> 홈 배팅
			$selected = 1;
			$selectedRate = $gameSubInfo["home_rate"];
		} else if ( $bet_local == "even" or $bet_local == "right" or $bet_local == "line4" ) {
			//-> 어웨이 배팅
			$selected = 2;
			$selectedRate = $gameSubInfo["away_rate"];
		}

		//-> 배팅마감시간 체크.
		$gameEndTime = trim($gameInfo["gameDate"]) ." ". trim($gameInfo["gameHour"]) .":". trim($gameInfo["gameTime"]);	//->경기시작시간
		$remainTime = (strtotime($gameEndTime)-strtotime($nowtime))/60;
		$parentIdx = $rs['parent_sn']+0;
		$dbBetEndTime = 2.0;
		if ( $remainTime < $dbBetEndTime ) {
			$result["result"] = "Betting hour deadline";
			echo json_encode($result);
			exit();
		}

		//-> tb_total_betting 등록
		$rate1 = $gameSubInfo["home_rate"];
		$rate2 = $gameSubInfo["draw_rate"];
		$rate3 = $gameSubInfo["away_rate"];
		$subChildSn = $gameSubInfo["sn"];
					
		$leagueInfo = $gModel->getLeagueInfo($childSn);	//-> 종목명과 리그명을 가져온다.
		$kind = $leagueInfo[0]['kind'];
		$leagueName = $leagueInfo[0]['name'];
		$rs = $cartModel->addBet($user_sn, $childSn, $subChildSn, $protoId, $selected, $rate1, $rate2, $rate3, $selectedRate, $gameType, $buy, $bet_money);

		//-> tb_total_cart 등록
		$recommendSn = $memberInfo['recommend_sn'];
		$rollingSn = $memberInfo['rolling_sn'];
		$author = $memberInfo['nick'];
		if ( $memberInfo["mem_status"] == "G" ) $accountEnable = 0;
		else $accountEnable = 1;
		$cartModel->addCart($user_sn, $parentIdx, $protoId, $buy, $betting_cnt, $user_money, $bet_money, $selectedRate, $recommendSn, $rollingSn, $accountEnable, '', $lastSpecialCode);			
		$pModel->bettingProcess($user_sn, $bet_money);

		//-> 배팅후 잔액
		$memberInfo = $loginModel->loginMemberServer($user_id, $user_pw);
		$user_money = $memberInfo["g_money"];

		$result["result"] = "ok";
		$result["money"] = $user_money;
		echo json_encode($result);
		exit();
	}	
}
?>