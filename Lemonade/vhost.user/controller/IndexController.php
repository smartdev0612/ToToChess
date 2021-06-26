<?
/*
* Index Controller
*/
class IndexController extends WebServiceController 
{
	var $commentListNum = 10;
	
	function layoutDefine($type='')
	{
		//-> 중복로그인 체크 전체 페이지 적용
		if ( $this->auth->getSn() > 0 ) {
			$mModel = $this->getModel("MemberModel");
			$dbSessionId = $mModel->getMemberField($this->auth->getSn(), 'sessionid');
			if($dbSessionId!=session_id()) {
				if($this->auth->isLogin()) {
					session_destroy();
				}
				throw new Lemon_ScriptException("중복접속 되었습니다. 다시 로그인 해 주세요.", "", "go", "/");
				exit;
			}
		}

		if($type=='type')
		{
			$this->view->define("index","layout/layout.type.index.html");
			$this->view->define(array("header"=>"header/header.html", "footer" => "footer/bottom.html", "top" => "header/top.html", "right" => "right/right.html"));
		}
		else if($type=='maintain')
		{
			$this->view->define("index","layout/layout.iframe.html");
			$this->view->define(array("content" => "content/maintain.html", "header"=>"header/header.html"));
		}
	}
	
	function popupAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}

		$this->view->define("content","content/popup.html");		
		$popupSn = $this->request("popup_sn");

		$cModel = $this->getModel("ConfigModel");		
		$popupData = $cModel->getPopupRow("*","idx = ".$popupSn);

		$this->view->assign("title", $popupData["P_SUBJECT"]);
		$this->view->assign("content", $popupData["P_CONTENT"]);
		$this->view->assign("file_url", $popupData["P_FILE"]);
		$this->view->assign("popup_sn", $popupData["IDX"]);
		$this->display();

		$this->view->define("content","content/popup.html");
	}

	function displayRight($type='')
	{
		$sn 			= $this->auth->getSn();
		$uid			= $this->auth->getId();
		$level		= $this->auth->getLevel();
		
		$mModel 		= $this->getModel("MemberModel");
		$memoModel 		= $this->getModel("MemoModel");
		$eModel			= $this->getModel("EtcModel");
		$gModel			= $this->getModel("GameModel");
		$cModel			= $this->getModel("ConfigModel");
		$cartModel 		= $this->getModel("CartModel");
		
		$dbSessionId = $mModel->getMemberField($sn, 'sessionid');				
		if($dbSessionId!=session_id())
		{
			if($this->auth->isLogin())
			{
				session_destroy();
			}
			throw new Lemon_ScriptException("중복접속 되었습니다. 다시 로그인 해 주세요.", "", "go", "/");
			exit;
		}

		if ( $type == "sadari" or $type == "dari" or $type == "race" or $type == "power" or $type == "nine"
            or $type == "mgmoddeven" or $type == "mgmbacara" or $type == "powersadari" or $type == "kenosadari"
		    or $type == "2dari" or $type == "3dari" or $type == "choice" or $type == "roulette" or $type == "pharaoh" or $type == "fx") {
			$rs = $eModel->getMemberLevRowMiniGame($level);
			if ( $type == "sadari" ) {
				$betMinMoney = $rs['sadari_min_bet'];
				$betMaxMoney = $rs['sadari_max_bet'];
				$singleMaxBetMoney = $rs['sadari_max_bet'];
				$maxBonus = $rs['sadari_max_bns'];
			} else if ( $type == "dari" ) {
				$betMinMoney = $rs['dari_min_bet'];
				$betMaxMoney = $rs['dari_max_bet'];
				$singleMaxBetMoney = $rs['dari_max_bet'];
				$maxBonus = $rs['sadari_max_bns'];
			} else if ( $type == "race" ) {
				$betMinMoney = $rs['race_min_bet'];
				$betMaxMoney = $rs['race_max_bet'];
				$singleMaxBetMoney = $rs['race_max_bet'];
				$maxBonus = $rs['race_max_bns'];
			} else if ( $type == "power" ) {
				$betMinMoney = $rs['powerball_min_bet'];
				$betMaxMoney = $rs['powerball_max_bet'];
				$singleMaxBetMoney = $rs['powerball_max_bet'];
				$maxBonus = $rs['powerball_max_bns'];
			}
			/*} else if ( $type == "real20" ) {
				$betMinMoney = $rs['real20_min_bet'];
				$betMaxMoney = $rs['real20_max_bet'];
				$singleMaxBetMoney = $rs['real20_max_bet'];
				$maxBonus = $rs['real20_max_bns'];
			}*/
			else if ( $type == "nine") {
				$betMinMoney = $rs['nine_min_bet'];
				$betMaxMoney = $rs['nine_max_bet'];
				$singleMaxBetMoney = $rs['nine_max_bet'];
				$maxBonus = $rs['nine_max_bns'];
			} else if ( $type == "mgmoddeven") {
                $betMinMoney = $rs['mgmoddeven_min_bet'];
                $betMaxMoney = $rs['mgmoddeven_max_bet'];
                $singleMaxBetMoney = $rs['mgmoddeven_max_bet'];
                $maxBonus = $rs['mgmoddeven_max_bns'];
            } else if ($type == "mgmbacara") {
                $betMinMoney = $rs['mgmbacara_min_bet'];
                $betMaxMoney = $rs['mgmbacara_max_bet'];
                $singleMaxBetMoney = $rs['mgmbacara_max_bet'];
                $maxBonus = $rs['mgmbacara_max_bns'];
            } else if ($type == "lowhi") {
                $betMinMoney = $rs['lowhi_min_bet'];
                $betMaxMoney = $rs['lowhi_max_bet'];
                $singleMaxBetMoney = $rs['lowhi_max_bet'];
                $maxBonus = $rs['lowhi_max_bns'];
            } else if ($type == "aladin") {
                $betMinMoney = $rs['aladin_min_bet'];
                $betMaxMoney = $rs['aladin_max_bet'];
                $singleMaxBetMoney = $rs['aladin_max_bet'];
                $maxBonus = $rs['aladin_max_bns'];
            } else if ($type == "powersadari") {
                $betMinMoney = $rs['powersadari_min_bet'];
                $betMaxMoney = $rs['powersadari_max_bet'];
                $singleMaxBetMoney = $rs['powersadari_max_bet'];
                $maxBonus = $rs['powersadari_max_bns'];
            }  else if ($type == "kenosadari") {
                $betMinMoney = $rs['kenosadari_min_bet'];
                $betMaxMoney = $rs['kenosadari_max_bet'];
                $singleMaxBetMoney = $rs['kenosadari_max_bet'];
                $maxBonus = $rs['kenosadari_max_bns'];
            }  else if ($type == "2dari") {
                $betMinMoney = $rs['2dari_min_bet'];
                $betMaxMoney = $rs['2dari_max_bet'];
                $singleMaxBetMoney = $rs['2dari_max_bet'];
                $maxBonus = $rs['2dari_max_bns'];
            }  else if ($type == "3dari") {
                $betMinMoney = $rs['3dari_min_bet'];
                $betMaxMoney = $rs['3dari_max_bet'];
                $singleMaxBetMoney = $rs['3dari_max_bet'];
                $maxBonus = $rs['3dari_max_bns'];
            }  else if ($type == "choice") {
                $betMinMoney = $rs['choice_min_bet'];
                $betMaxMoney = $rs['choice_max_bet'];
                $singleMaxBetMoney = $rs['choice_max_bet'];
                $maxBonus = $rs['choice_max_bns'];
            }  else if ($type == "roulette") {
                $betMinMoney = $rs['roulette_min_bet'];
                $betMaxMoney = $rs['roulette_max_bet'];
                $singleMaxBetMoney = $rs['roulette_max_bet'];
                $maxBonus = $rs['roulette_max_bns'];
            }  else if ($type == "pharaoh") {
                $betMinMoney = $rs['pharaoh_min_bet'];
                $betMaxMoney = $rs['pharaoh_max_bet'];
                $singleMaxBetMoney = $rs['pharaoh_max_bet'];
                $maxBonus = $rs['pharaoh_max_bns'];
            }  else if ($type == "fx") {
				$betMinMoney = $rs['fx_min_bet'];
				$betMaxMoney = $rs['fx_max_bet'];
				$singleMaxBetMoney = $rs['fx_max_bet'];
				$maxBonus = $rs['fx_max_bns'];
			}

		} else {
			$rs = $eModel->getMemberLevRow($level, '*');
			if ( $type == "special" or $type == "special2" or $type == "live" ) {
				$betMinMoney = $rs['lev_min_money'];
				$betMaxMoney = $rs['lev_max_money_special'];
				$singleMaxBetMoney = $rs['lev_max_money_single_special'];
				$maxBonus = $rs['lev_max_bonus_special'];
			} else {
				$betMinMoney = $rs['lev_min_money'];
				$betMaxMoney = $rs['lev_max_money'];
				$singleMaxBetMoney = $rs['lev_max_money_single'];
				$maxBonus = $rs['lev_max_bonus'];
			}
		}

		$rs	= $cModel->getAdminConfigRow('*');
		$betEndTime = $rs['bettingendtime'];
		$betCancelTime = $rs['bettingcanceltime'];
		$betCancelBeforeTime = $rs['bettingcancelbeforetime'];
		
		$mode = $type;
		
		$rs = $cModel->getSiteConfigRow();
		$rule = $rs['bet_rule'];
		$vh = $rs['bet_rule_vh'];
		$vu = $rs['bet_rule_vu'];
		$hu = $rs['bet_rule_hu'];
		$minBetCount = $rs['min_bet_count'];
		
		$isEvent = ($type=='event')? 1:0;
		
		//다폴더 보너스
		if($type=='event') {
			$folderBonus = $cModel->getEventConfigRow();
		} else {
			$level = $mModel->getMemberField($this->auth->getSn(), 'mem_lev');
			$field = $cModel->getLevelConfigField($level, 'lev_folder_bonus');
			$array = explode(":",$field);
			$folderBonus['bonus1']  = 0;
			$folderBonus['bonus2']  = 0;
			$folderBonus['bonus3']  = $array[0];
			$folderBonus['bonus4']  = $array[1];
			$folderBonus['bonus5']  = $array[2];
			$folderBonus['bonus6']  = $array[3];
			$folderBonus['bonus7']  = $array[4];
			$folderBonus['bonus8']  = $array[5];
			$folderBonus['bonus9']  = $array[6];
			$folderBonus['bonus10'] = $array[7];
		}

		$this->view->assign("rule", $rule);
		$this->view->assign("vh", $vh);
		$this->view->assign("vu", $vu);
		$this->view->assign("hu", $hu);
		$this->view->assign("isEvent", $isEvent);
		$this->view->assign("minBetCount", $minBetCount);
		
		$this->view->assign("folderBonus", $folderBonus);
		$this->view->assign("mode", $mode);
		$this->view->assign("betEndTime", $betEndTime);
		$this->view->assign("betCancelTime", $betCancelTime);
		$this->view->assign("betCancelBeforeTime", $betCancelBeforeTime);
		$this->view->assign("betMinMoney", $betMinMoney);
		$this->view->assign("betMaxMoney", $betMaxMoney);
		$this->view->assign("singleMaxBetMoney", $singleMaxBetMoney);
		$this->view->assign("maxBonus", $maxBonus);
	}
	
	/*
	 * 메인 페이지
	 */
	public function indexAction($id='')
	{
		$this->commonDefine("index");
		//$this->view->define("index","layout/layout.index.html");
		$this->view->define(array("content"=>"content/index.html"));

		// $mode = $this->request('mode');
		// $m_to_pc = $this->request('v');
		// if ( $m_to_pc == "pc" ) {
		// 	setcookie("m_to_pc",$m_to_pc,0,"/");
		// }
		
		// /*접속기기 (PC, mobile) 확인*/		
		// $mobileArray = array("Android", "iPhone", "BlackBerry", "Windows CE", "LG", "SAMSUNG", "MOT", "SonyEricsson");
		// $userAgent = 'pc';

		// foreach ($mobileArray as $key=> $value)
		// {
		// 	if(preg_match("/{$value}/", $_SERVER['HTTP_USER_AGENT']))
		// 	{
		// 		$userAgent = 'mobile';
        //     }
		// }

		/*접속 도메인 확인*/
		$conDomain = $_SERVER['HTTP_HOST'];

		/*if(preg_match("/www./", $_SERVER['HTTP_HOST']))
		{
			$conDomain = str_replace("www.","",$conDomain);
		} else if(preg_match("/m./", $_SERVER['HTTP_HOST'])){
            $conDomain = str_replace("m.", "", $conDomain);
		}*/

        //-> PC버전 고정
		$userAgent = 'pc';

		/*if ( $m_to_pc != "pc" and $_COOKIE["m_to_pc"] != "pc" ) {
			$count = preg_match("/m./", $_SERVER['HTTP_HOST']);
			if($userAgent == 'pc' && preg_match("/m./", $_SERVER['HTTP_HOST']))
			{
				echo "<script>document.location.href='http://".$conDomain."'</script>";
			}
			if($userAgent == 'mobile' && !preg_match("/m./", $_SERVER['HTTP_HOST']))
			{
				echo "<script>document.location.href='http://m.".$conDomain."'</script>";
			}
		}*/

        if(preg_match("/www./", $_SERVER['HTTP_HOST']))
        {
            $conDomain = str_replace("www.","",$conDomain);
        } else if(strpos($_SERVER['HTTP_HOST'], "m.") === 0){
            $conDomain = substr($conDomain, 2, strlen($conDomain) - 2);
        }

        if ( $m_to_pc != "pc" and $_COOKIE["m_to_pc"] != "pc" ) {
            if($userAgent == 'pc' && strpos($_SERVER['HTTP_HOST'], "m.") === 0)
            {
                echo "<script>document.location.href='http://".$conDomain."'</script>";
            }
            if($userAgent == 'mobile' && strpos($_SERVER['HTTP_HOST'], "m.") !== 0)
            {
                echo "<script>document.location.href='http://m.".$conDomain."'</script>";
            }
        }

		$ConfigModel=Lemon_Instance::getObject("ConfigModel", true);
		$rs = $ConfigModel->getAdminConfigRow();

		// if(!$this->auth->isLogin() && $rs['maintain']==2)
		// {
		// 	$this->loginAction();
		// 	exit;
		// }

		$etcModel = $this->getModel("EtcModel");
		$boardModel = $this->getModel("BoardModel");
        $gameListModel = $this->getModel("GameListModel");

		//-> 팝업 공지
		$popupList = $etcModel->getPopup();		

		//-> 공지 게시판
		$noticeList = $boardModel->getNoticeList();

        /*$where = " and b.name <> '*보너스배당*'";
        $where .= " and a.user_view_flag=1";
        $where .= " and a.gameDate >= '".date("Y-m-d",time()-86400)."'";
        $gameList = $gameListModel->getNewGameList($where,'', 2);*/

        $var_date = date("Y-m-d",time()-86400);
        $leagueGameList = $gameListModel->_getLeagueGameList();
		$leagueGameListMulti = $gameListModel->_getLeagueGameListMulti();
        /*$football_game_list = $gameListModel->_getCatagoryGame('축구', $var_date);
        $basketball_game_list = $gameListModel->_getCatagoryGame('농구', $var_date);
        $volleyball_game_list = $gameListModel->_getCatagoryGame('배구', $var_date);*/

        /*$football_game = array('sport_name'=>'축구','home_team'=>'','away_team'=>'',
			'gameDate'=>'','gameHour'=>'', 'gameTime'=>'',
			'league_name'=>'', 'home_rate'=>'', 'draw_rate'=>'', 'away_rate'=>'');

        $basketball_game = array('sport_name'=>'농구','home_team'=>'','away_team'=>'',
            'gameDate'=>'','gameHour'=>'', 'gameTime'=>'',
            'league_name'=>'', 'home_rate'=>'', 'draw_rate'=>'', 'away_rate'=>'');

        $volleyball_game = array('sport_name'=>'배구','home_team'=>'','away_team'=>'',
            'gameDate'=>'','gameHour'=>'', 'gameTime'=>'',
            'league_name'=>'', 'home_rate'=>'', 'draw_rate'=>'', 'away_rate'=>'');*/

        /*if(count($football_game_list) > 0)
            $football_game = $football_game_list[0];

        if(count($basketball_game_list) > 0)
            $basketball_game = $basketball_game_list[0];

        if(count($volleyball_game_list) > 0)
            $volleyball_game = $volleyball_game_list[0];*/

        $game_result_list = $gameListModel->_gameResult();

		$this->view->assign('popup_list', $popupList);
		$this->view->assign('notice_list', $noticeList);
        $this->view->assign('game_result_list', $game_result_list);
        $this->view->assign('league_game_list', $leagueGameList);
		$this->view->assign('league_game_list_multi', $leagueGameListMulti);
        /*$this->view->assign('football_game', $football_game);
        $this->view->assign('basketball_game', $basketball_game);
        $this->view->assign('volleyball_game', $volleyball_game);*/

		//$this->redirect('/game_list?game=multi');
		$this->display();
	}

	public function refreshOddsAction() {
		$this->req->xssClean();

		//$idArray = $this->request('id');
		$sport = $this->request('sport');
		$gameListModel = $this->getModel("GameListModel");

		$childList = array();
		$where ='';
		switch($sport) {
			case "soccer":
				$where.= " and c.sport_name = '축구'";
				break;
			case "baseball":
				$where.= " and c.sport_name = '야구'";
				break;
			case "basketball":
				$where.= " and c.sport_name = '농구'";
				break;
			case "volleyball":
				$where.= " and c.sport_name = '배구'";
				break;
			case "hockey":
				$where.= " and (c.sport_name like '%하키%')";
				break;
			case "tennis":
				$where.= " and c.sport_name = '테니스'";
				break;
			case "esports":
				$where.= " and c.sport_name = 'E스포츠'";
				break;
			case "etc":
				$where.= " and (c.sport_name = '' or c.sport_name = '미분류') ";
				break;
		}

		$childList = $gameListModel->getItemOdds($where);

		echo json_encode(array("result"=>"success", "data"=>$childList));
	}

	// ****************** new Added part ***********************
	public function calendarAction() {
		if ( !$this->auth->isLogin() ) {
			$this->loginAction();
			exit;
		}

		$member_sn = $this->auth->getSn();
		$today= date("Y-m-d",(time()));

		$memberModel = $this->getModel("MemberModel");
		$configModel = $this->getModel("ConfigModel");

		$config = $configModel->getPointConfigRow("*");
		$checkAmt = $config['check_money'];

		$chargeAmt = $memberModel->todayChargeAmount($member_sn, $today);
		$todayPresense = $memberModel->todayPresenseCheck($member_sn, $today);


		$is_enable_check = 1;

		if($chargeAmt < $checkAmt)
		{
			$is_enable_check = 0;
		}

		$is_checked = 0;
		if(is_array($todayPresense) && count($todayPresense) > 0)
		{
			$is_checked = 1;
		}

		$this->commonDefine('join');
		$this->view->define(array("content"=>"content/calendar.html"));
		$this->view->assign('is_enable_check', $is_enable_check);
		$this->view->assign('is_checked', $is_checked);

		$this->display();
	}

	function calendarAjax_procAction()
	{
		$member_sn = $this->auth->getSn();
		$today= date("Y-m-d",(time()));

		$memberModel = Lemon_Instance::getObject("MemberModel",true);


		$todayPresense = $memberModel->todayPresenseCheck($member_sn, $today);

		if ( count((array)$todayPresense) > 0) {
			echo "ReOK";
		} else {
			$rlt = $memberModel->checkPresense($member_sn);
			if($rlt > 0)
			{
				$this->modifyPresenseMileageProcess($member_sn);
				echo "OK";
			} else {
				echo "NoOK";
			}
		}
	}

	function getUserMoneyAction() {
		$sn = $this->auth->getSn();
		$cash = 0;
		if($sn != "") {
			$mModel = $this->getModel("MemberModel");
			$rs = $mModel->getMemberRow($sn);
			$cash = $rs['g_money'];
		}

		echo $cash;
	}

	function modifyPresenseMileageProcess($member_sn)
	{
		$processModel 	= Lemon_Instance::getObject("ProcessModel", true);
		$memberModel 	= Lemon_Instance::getObject("MemberModel", true);

		// day check
		$processModel->modifyPresenseCheckMileageProcess($member_sn, 0);

		$today = date('Y-m-d',time());
		$currMonth= date("m");
		$currYear = date("Y");
		$currDay = date("j");

		// week check
		$day = date("N");
		$startDate = date('Y-m-d', (time()- (3600 * 24 * ($day-1))));
		$endDate = date('Y-m-d', (time()+ (3600 * 24 * (7-$day))));

		if($day == 7)
		{
			$count = $memberModel->presenseCount($member_sn, $startDate, $endDate);
			if($count == 7)
			{
				$processModel->modifyPresenseCheckMileageProcess($member_sn, 1);
			}
		}

		// month check
		$startDate = date('Y-m-d', strtotime($currYear . "-" . $currMonth . "-01 00:00:01"));
		$daysInMonth = cal_days_in_month(CAL_GREGORIAN, date("m", $startDate), date( "Y", $startDate));
		$endDate = date('Y-m-d', strtotime($currYear . "-" . $currMonth . "-" .  $daysInMonth ." 00:00:01"));

		if($endDate == $today)
		{
			$count = $memberModel->presenseCount($member_sn, $startDate, $endDate);
			if($count == $daysInMonth)
			{
				$processModel->modifyPresenseCheckMileageProcess($member_sn, 2);
			}
		}
	}

	public function live_casinoAction() {
		if ( !$this->auth->isLogin() ) {
			$this->loginAction();
			exit;
		}

		$this->commonDefine('livecasino');
		$this->view->define(array("content"=>"content/live_casino.html"));

		$mModel = $this->getModel("MemberModel");
		$dbSessionId = $mModel->getMemberField($this->auth->getSn(), 'sessionid');

		$this->view->assign("sessionid", $dbSessionId);

		$this->display();
	}
	//*************** end Added part ************************************** */
	
	//▶ 승무패,핸디캡,스페셜 배팅
	public function game_listAction() {		
		
		if ( !$this->auth->isLogin() ) {
			$this->loginAction();
			exit;
		}
		
		$game = $this->request('game');
		$sport = $this->request('sport');
		$league_sn = empty($this->request('league_sn')) ? 0 : $this->request('league_sn');
		$today = empty($this->request('today')) ? 0 : $this->request('today');
		$perpage = empty($this->request('perpage')) ? 100 : $this->request('perpage');
		$page_index = empty($this->request('page_index')) ? 0 : $this->request('page_index');
        $title = "";
		
		if ( $game == "multi" ) {
			$specialType = "1";
            $title = "<span class=\"board_mini_title\">국내형</span>";
			$this->commonDefine('winlose');
			$this->view->define(array("content"=>"content/game_list.html"));
			$this->displayRight("multi");
		} else if ( $game == "handi" ) {
			$specialType = "0";
            $title = "Handicap<span class=\"board_mini_title\">핸디캡</span>";
			$this->commonDefine('handi');
			$this->view->define(array("content"=>"content/game_list.html"));
			$this->displayRight("handi");
		} else if ( $game == "special" ) {
			$specialType = "1";
            $title = "Special<span class=\"board_mini_title\">스페셜</span>";
			$this->commonDefine('special');
			$this->view->define(array("content"=>"content/game_list.html"));
			$this->displayRight("special");
		} else if ( $game == "abroad" ) {
			$specialType = "2";
            $title = "Abroad<span class=\"board_mini_title\">해외형</span>";
			$this->commonDefine('abroad');
			
			if($this->isMobile() == "pc") {
				$this->view->define(array("content"=>"content/game_list_multi.html"));
			} else {
				$this->view->define(array("content"=>"content/game_list_multi_m.html"));
			}
			$this->displayRight("multi");
		} else if ( $game == "live" ) {
			$specialType = "4";
			//$title = "Live<span class=\"board_mini_title\">라이브</span>";
			$this->commonDefine('live');
			if($this->isMobile() == "pc") {
				$this->view->define(array("content"=>"content/game_list_live.html"));
			} else {
				$this->view->define(array("content"=>"content/game_list_live_m.html"));
			}
			$this->displayRight("multi");
			
		} else if ( $game == "vfootball" ) {
            $specialType = "22";
            $title = "BET365<span class=\"board_mini_title\">가상축구</span>";
            $this->commonDefine('winlose');
            $this->view->define(array("content"=>"content/v_football.html"));
            $this->displayRight("multi");
        } else if ( $game == "sadari" ) {
			$specialType = "5";
            $title = "NAMED<span class=\"board_mini_title\">사다리</span>";
			$this->commonDefine('ladder');
			$this->view->define(array("content"=>"content/ladder_game_list.html"));
			$this->displayRight("sadari");
			$resultGetCount = 5;
		} else if ( $game == "race" ) {
			$specialType = "6";
            $title = "NAMED<span class=\"board_mini_title\">달팽이</span>";
			$this->commonDefine('ladder');
			$this->view->define(array("content"=>"content/ladder_race_game_list.html"));
			$this->displayRight("race");
			$resultGetCount = 5;
		} else if ( $game == "power" ) {
			$specialType = "7";
            $title = "POWERBALL<span class=\"board_mini_title\">파워볼</span>";
			$this->commonDefine('ladder');
			if($this->isMobile() == "pc") {
				$this->view->define(array("content"=>"content/ladder_ball_game_list.html"));
			} else {
				$this->view->define(array("content"=>"content/ladder_ball_game_list_m.html"));
			}
			$this->displayRight("power");
			$resultGetCount = 10;
			
		} else if ( $game == "dari" ) {
			$specialType = "8";
            $title = "NAMED<span class=\"board_mini_title\">다리다리</span>";
			$this->commonDefine('ladder');
			$this->view->define(array("content"=>"content/ladder_dari_game_list.html"));
			$this->displayRight("dari");
		} else if ( $game == "mgmoddeven" ) {
            $specialType = "26";
            $title = "MGM<span class=\"board_mini_title\">홀짝</span>";
            $this->commonDefine('ladder');
            $this->view->define(array("content"=>"content/ladder_mgmoddeven_list.html"));
            $this->displayRight("mgmoddeven");
            $resultGetCount = 5;
        } else if ( $game == "mgmbacara" ) {
            $specialType = "27";
            $title = "MGM<span class=\"board_mini_title\">바카라</span>";
            $this->commonDefine('ladder');
            $this->view->define(array("content"=>"content/ladder_mgmbacara_list.html"));
            $this->displayRight("mgmbacara");
            $resultGetCount = 5;
        } else if ( $game == "lowhi" ) {
            $specialType = "28";
            $title = "LOWHI<span class=\"board_mini_title\">로하이</span>";
            $this->commonDefine('ladder');
            $this->view->define(array("content"=>"content/ladder_lowhi_game_list.html"));
            $this->displayRight("lowhi");
            $resultGetCount = 5;
        } else if ( $game == "aladin" ) {
            $specialType = "29";
            $title = "ALADIN<span class=\"board_mini_title\">알라딘</span>";
            $this->commonDefine('ladder');
            $this->view->define(array("content"=>"content/ladder_aladin_game_list.html"));
            $this->displayRight("aladin");
            $resultGetCount = 5;
        } else if ( $game == "psadari" ) {
            $specialType = "25";
            $title = "PowerSadari<span class=\"board_mini_title\">파워사다리</span>";
			$this->commonDefine('ladder');
			if($this->isMobile() == "pc") {
				$this->view->define(array("content"=>"content/ladder_powersadari_list.html"));
			} else {
				$this->view->define(array("content"=>"content/ladder_powersadari_list_m.html"));
			}
            $this->displayRight("powersadari");
            $resultGetCount = 5;
        } else if ( $game == "kenosadari" ) {
            $specialType = "24";
            $title = "KenoSadari<span class=\"board_mini_title\">키노사다리</span>";
			$this->commonDefine('ladder');
			if($this->isMobile() == "pc") {
				$this->view->define(array("content"=>"content/ladder_kenosadari_list.html"));
			} else {
				$this->view->define(array("content"=>"content/ladder_kenosadari_list_m.html"));
			}
            $this->displayRight("kenosadari");
            $resultGetCount = 5;
        } else if ( $game == "nine" ) {
            $specialType = "21";
            $title = "Nine <span class=\"board_mini_title\">나인</span>";
            $this->commonDefine('ladder');
            $this->view->define(array("content"=>"content/ladder_nine_list.html"));
            $this->displayRight("nine");
            $resultGetCount = 5;
        } else if ( $game == "2dari" ) {
            $specialType = "30";
            $title = "2Dari<span class=\"board_mini_title\">이다리</span>";
			$this->commonDefine('ladder');
			if($this->isMobile() == "pc") {
				$this->view->define(array("content"=>"content/ladder_2dari_list.html"));
			} else {
				$this->view->define(array("content"=>"content/ladder_2dari_list_m.html"));
			}
            $this->displayRight("2dari");
            $resultGetCount = 5;
        } else if ( $game == "3dari" ) {
            $specialType = "31";
            $title = "3Dari<span class=\"board_mini_title\">삼다리</span>";
			$this->commonDefine('ladder');
			if($this->isMobile() == "pc") {
				$this->view->define(array("content"=>"content/ladder_3dari_list.html"));
			} else {
				$this->view->define(array("content"=>"content/ladder_3dari_list_m.html"));
			}
            $this->displayRight("3dari");
            $resultGetCount = 5;
        } else if ( $game == "choice" ) {
            $specialType = "32";
            $title = "Choice<span class=\"board_mini_title\">초이스</span>";
			$this->commonDefine('ladder');
			if($this->isMobile() == "pc") {
				$this->view->define(array("content"=>"content/ladder_choice_list.html"));
			} else {
				$this->view->define(array("content"=>"content/ladder_choice_list_m.html"));
			}
            $this->displayRight("choice");
            $resultGetCount = 5;
        } else if ( $game == "roulette" ) {
            $specialType = "33";
            $title = "Roulette<span class=\"board_mini_title\">룰렛</span>";
			$this->commonDefine('ladder');
			if($this->isMobile() == "pc") {
				$this->view->define(array("content"=>"content/ladder_roulette_list.html"));
			} else {
				$this->view->define(array("content"=>"content/ladder_roulette_list_m.html"));
			}
            $this->displayRight("roulette");
            $resultGetCount = 5;
        } else if ( $game == "pharaoh" ) {
            $specialType = "34";
            $title = "Paraoh<span class=\"board_mini_title\">파라오</span>";
			$this->commonDefine('ladder');
			if($this->isMobile() == "pc") {
				$this->view->define(array("content"=>"content/ladder_pharaoh_list.html"));
			} else {
				$this->view->define(array("content"=>"content/ladder_pharaoh_list_m.html"));
			}
            $this->displayRight("pharaoh");
            $resultGetCount = 5;
        } else if ( $game == "fx" ) {
			$title = "FX게임";
			$this->commonDefine('ladder');

			$min = $this->request('min');

			if($min == 1) 		$specialType = "35";
			else if($min == 2)  $specialType = "39";
			else if($min == 3)  $specialType = "40";
			else if($min == 4)  $specialType = "41";
			else if($min == 5)  $specialType = "42";

			$day = date("w");
			$t_hour = date("H",time());
			$t_min = date("i",time());
			$is_use=1;
			if($day == 0 || ($day==6 && $t_hour >=5))
			{
				$is_use = 0;
			} else {
				$now_time = sprintf("%02d", $t_hour).sprintf("%02d", $t_min);
				if($now_time >= '0620' && $now_time <='0720')
				{
					$is_use = 0;
				}
			}
			if($this->isMobile() == "pc") {
				$this->view->define(array("content"=>"content/ladder_fx_list.html"));
			} else {
				$this->view->define(array("content"=>"content/ladder_fx_list_m.html"));
			}
			$this->displayRight("fx");
			$resultGetCount = 5;
			$this->view->assign("min", $min);
			$this->view->assign("is_use", $is_use);
		} /*else if ( $game == "fx2" ) {
			$specialType = "39";
			$title = "FX게임";
			$this->commonDefine('ladder');
			$this->view->define(array("content"=>"content/ladder_fx2_list.html"));
			$this->displayRight("fx");
			$resultGetCount = 5;
		} else if ( $game == "fx3" ) {
			$specialType = "40";
			$title = "FX게임";
			$this->commonDefine('ladder');
			$this->view->define(array("content"=>"content/ladder_fx3_list.html"));
			$this->displayRight("fx");
			$resultGetCount = 5;
		} else if ( $game == "fx4" ) {
			$specialType = "41";
			$title = "FX게임";
			$this->commonDefine('ladder');
			$this->view->define(array("content"=>"content/ladder_fx4_list.html"));
			$this->displayRight("fx");
			$resultGetCount = 5;
		} else if ( $game == "fx5" ) {
			$specialType = "42";
			$title = "FX게임";
			$this->commonDefine('ladder');
			$this->view->define(array("content"=>"content/ladder_fx5_list.html"));
			$this->displayRight("fx");
			$resultGetCount = 5;
		} */else {
			exit;
		}
		
		$gameListModel = $this->getModel("GameListModel");
		$leagueModel = $this->getModel("LeagueModel");
		$etcModel = $this->getModel("EtcModel");
		$configModel = $this->getModel("ConfigModel");
		$filterLeagues = $this->request('league_keyword_panel');

		//-> 스포츠일 경우. (미니게임은 패스) + 가상축구
		if ( $specialType < 5 || $specialType == "22" || $specialType == "50") {
			// if ( $specialType == "0" ) $titleImage = "title_mix.gif";
			// else if ( $specialType == "1" ) $titleImage = "title_special.gif";
			// else if ( $specialType == "2" ) $titleImage = "title_live.gif";
			// else if ( $gameType == "1" ) $titleImage = "title_victory.gif";
			// else if ( $gameType == "2" ) $titleImage = "title_handicap.gif";

			$where = "";

			switch($game) {
                case "winlose":
                    $where.= " and a.special = 0 and a.type = 1";
                    break;
				case "multi": 
					$where .= " and (a.special = 1 or a.special = 2) and a.status = 1 and c.status = 1 and c.betting_type in (1,2,3,28,52,226,342,866)"; 
					break;
				case "handi": 
					$where.= " and a.special = 0 and ( a.type = 2 or a.type = 4 )";
					break;
				case "special": 
					$where.= " and a.special = 1";
					break;
				case "abroad": 
					$where.= " and a.special = 2 and a.status = 1 and c.status = 1 ";
					break;
				case "vfootball":
                    $where.= " and a.special = 22";
                    break;
				case "live":
					$where.= " and a.special = 4";
					break;
			}

			switch($sport) {
				case "soccer": 
					$where.= " and a.sport_name = '축구'";
					break;
				case "baseball": 
					$where.= " and a.sport_name = '야구'";
					break;
				case "basketball": 
					$where.= " and a.sport_name = '농구'";
					break;
				case "volleyball": 
					$where.= " and a.sport_name = '배구'";
					break;
				case "hockey": 
					$where.= " and (a.sport_name like '%하키%')";
					break;
                case "tennis":
                    $where.= " and a.sport_name = '테니스'";
                    break;
				case "esports": 
					$where.= " and a.sport_name = 'E스포츠'";
                	break;
                case "handball": 
					$where.= " and a.sport_name = '핸드볼'";
                	break;
                case "mortor": 
					$where.= " and a.sport_name = '모토'";
                	break;
                case "rugby": 
					$where.= " and a.sport_name = '럭비'";
                	break;
                case "criket": 
					$where.= " and a.sport_name = '크리켓'";
                	break;
                case "darts": 
					$where.= " and a.sport_name = '다트'";
                	break;
                case "futsal": 
					$where.= " and a.sport_name = '풋살'";
                	break;
                case "badminton": 
					$where.= " and a.sport_name = '배드민턴'";
                	break;
				case "tabletennis": 
					$where.= " and a.sport_name = '탁구'";
					break;
				case "etc": 
					$where.= " and (a.sport_name = '' or a.sport_name = '미분류') ";
				break;
			}
 
			$where.= " and a.user_view_flag=1";
			
			if( $filterLeagues!="" && is_array($filterLeagues)) {
				$where.=" and b.alias_name in (";
				for ( $i = 0; $i < count((array)$filterLeagues) ; ++$i ) {
					if ( $i == 0 ) {
						$where.="'".$filterLeagues[$i]."'";
					} else {
						$where.=",'".$filterLeagues[$i]."'";
					}
				}
				$where.=")";
			}

			// $where .= " and a.gameDate >= '".date("Y-m-d  H:i:s",time()-86400)."'";
			$where .= " and CONCAT(a.gameDate, ' ', a.gameHour, ':', a.gameTime, ':00') > '".date("Y-m-d H:i:s", time() + 1800)."' and CONCAT(a.gameDate, ' ', a.gameHour, ':', a.gameTime, ':00') < '".date("Y-m-d H:i:s", time() + 86400)."' ";
			
			// 보너스항목들 얻어오기
			$bonus_list = $gameListModel->getMultiBonusList($specialType);

			// if($game != "abroad" || $game != "live") {
			// 	$gameList = $gameListModel->getGameList($where, $specialType);
			// 	//echo json_encode($gameList);
			// 	if(is_array($gameList)) {
			// 		//-> 보너스 배당 고르기.
			// 		foreach ( $gameList as $gameListKey => $gameListVal ) {
			// 			if ( strlen(trim($gameListKey)) != strlen(str_replace("보너스","",trim($gameListKey))) ) {
			// 				$keyName = $gameListKey;
			// 				$bonusList[$keyName] = $gameList[$keyName];
			// 				unset($gameList[$keyName]);
			// 			}
			// 		}
			// 	}
			// 	if ( is_array($bonusList) && count($bonusList) > 0 ) $gameList = array_merge($bonusList, $gameList);
				
			// } 
			//$this->view->define("right", "right/right.html");
		} else {
			//-> 미니게임 배팅내역 리스트
			if(count((array)$_SESSION['member']) > 0) {
				$betting_list = $gameListModel->getBettingList($this->auth->getSn(), 0, $resultGetCount, "", -1, "", "", $specialType);
			} else {
				$betting_list = [];
			}

			$logo = $this->request('logo');

			if($logo=='')
				$logo = $this->logo;

			$model = $this->getModel("ConfigModel");
			$settingList = $model->getMiniConfigRow("*", "", $logo);

			$this->view->assign( "miniSetting", $settingList);
			//$betting_list = [];
			//-> named 보안서버 구동 여부.
			$named_security_flag = $etcModel->namedSecurityState();
		}
		
		if(count((array)$_SESSION['member']) > 0) {
			$level = $_SESSION['member']['level'];
		} else {
			$level = 0;
		}

		$miniodds_info = $configModel->getMiniOddsRow("*", "level=".$level, '');
		$miniconfig_info = $configModel->getMiniConfigRow("*", "", '');

		if(count((array)$_SESSION['member']) > 0) {
			$sport_setting =  $configModel->getSportBettingSettingRow("*", " where level=".$this->auth->getLevel(), '');
		} else {
			$sport_setting = [];
		}
		
		//-> popup
		$popupList = $etcModel->getPopup();

		$nodatetime = date("YmdHis");
        $this->view->assign("title", $title);
		$this->view->assign("named_security_flag", $named_security_flag);
		$this->view->assign("betting_list", $betting_list);
		//$this->view->assign("power_result_list", $power_result_list);
		//$this->view->assign('sadari_result', $sadari_result);
		$this->view->assign('popup_list', $popupList);
		//$this->view->assign("game_list", $gameList);
		$this->view->assign("bonus_list", $bonus_list);
		//$this->view->assign("title_image", $titleImage);
		$this->view->assign("special_type", $specialType);
		$this->view->assign("game_type", $game);
		$this->view->assign("sport_type", $sport);							//축구, 농구, 배구 등등
		$this->view->assign("mini_odds", $miniodds_info);
		$this->view->assign("mini_config", $miniconfig_info);
		$this->view->assign("sport_setting", $sport_setting);
		$this->view->assign("league_sn", $league_sn);
		$this->view->assign("today", $today);

		$this->display();
	}

	public function getRecentBettingListAction() {
		$game = $this->request('game');

		$specialType = 0;
		$resultGetCount = 0;

		if ( $game == "sadari" ) {
			$specialType = "5";
			$resultGetCount = 5;
		} else if ( $game == "race" ) {
			$specialType = "6";
			$resultGetCount = 5;
		} else if ( $game == "power" ) {
			$specialType = "7";
			$resultGetCount = 10;
		} else if ( $game == "dari" ) {
			$specialType = "8";
			$resultGetCount = 5;
		} else if ( $game == "mgmoddeven" ) {
            $specialType = "26";
            $resultGetCount = 5;
        } else if ( $game == "mgmbacara" ) {
            $specialType = "27";
            $this->displayRight("mgmbacara");
            $resultGetCount = 5;
        } else if ( $game == "lowhi" ) {
            $specialType = "28";
            $resultGetCount = 5;
        } else if ( $game == "aladin" ) {
            $specialType = "29";
            $resultGetCount = 5;
        } else if ( $game == "psadari" ) {
            $specialType = "25";
            $resultGetCount = 5;
        } else if ( $game == "kenosadari" ) {
            $specialType = "24";
            $resultGetCount = 5;
        } else if ( $game == "nine" ) {
            $specialType = "21";
            $resultGetCount = 5;
        } else if ( $game == "2dari" ) {
            $specialType = "30";
            $resultGetCount = 5;
        } else if ( $game == "3dari" ) {
            $specialType = "31";
            $resultGetCount = 5;
        } else if ( $game == "choice" ) {
            $specialType = "32";
            $resultGetCount = 5;
        } else if ( $game == "roulette" ) {
            $specialType = "33";
            $resultGetCount = 5;
        } else if ( $game == "pharaoh" ) {
            $specialType = "34";
            $resultGetCount = 5;
        }
		$gameListModel = $this->getModel("GameListModel");
		$betting_list = $gameListModel->getBettingList($this->auth->getSn(), 0, $resultGetCount, "", -1, "", "", $specialType);
		
		$dom = "";
		$forCnt = 0;
		if($specialType == "7") {
			foreach ( $betting_list as $TPL_K1 => $TPL_V1 ) {
				$forCnt++;
				$TPL_item_2=empty($TPL_V1["item"]) || !is_array($TPL_V1["item"]) ? 0 : count($TPL_V1["item"]);
				if ( $TPL_item_2 ) { 

					$bettingNo = $TPL_V1["betting_no"];
					$bettingRate = $TPL_V1["result_rate"];
					$bettingMoney = $TPL_V1["betting_money"];
					$betDay = substr($TPL_V1["bet_date"],5,5);
					$betTime = substr($TPL_V1["bet_date"],11,8);

					foreach ( $TPL_V1["item"] as $TPL_V2 ) {				
						$gameCode = $TPL_V2["game_code"];
						$gameTh = $TPL_V2["game_th"];
						$bettingDate = str_replace("-","월 ",substr($TPL_V2["gameDate"],5,5))."일";

						if ( $TPL_V2["home_rate"] < 1.1 and $TPL_V2["draw_rate"] < 1.1 and $TPL_V2["away_rate"] < 1.1  ) {
							$resultMoney = "-";
							$bettingResult = "<font color='#f65555'>적특</font>";
						} else {
							$resultMoney = "-";
							if ( $TPL_V2["result"] == 1 ) {
								$bettingResult = "<span style='color: lightgreen;'>적중</span>";
								$resultMoney = "<span class=\"new_betting_ok\">".number_format($bettingMoney * $bettingRate)."</span>";
							} else if ( $TPL_V2["result"] == 2 ) {
								$bettingResult = "<span style='color: red;'>미적중</span>";
								$resultMoney = "<span class=\"new_betting_no\">-".number_format($bettingMoney)."</span>";
							} else if ( $TPL_V2["result"] == 4 ) {
								$bettingResult = "<font color='#f65555'>적특</font>";	
							} else {
								$bettingResult = "진행중";
							}
						}

						if ( $gameCode == "p_n-bs" ) {
							$gameName = "일반볼구간";
							if ( $TPL_V2["select_no"] == 1 ) $select_val = "대(81~130)";
							else if ( $TPL_V2["select_no"] == 2 ) $select_val = "소(15~64)";
							else $select_val = "중(65~80)";
						} else if ( $gameCode == "p_n-oe" ) {
							$gameName = "일반볼홀짝";
							if ( $TPL_V2["select_no"] == 1 ) $select_val = "홀";
							else $select_val = "짝";
						} else if ( $gameCode == "p_n-uo" ) {
							$gameName = "일반볼언오";
							if ( $TPL_V2["select_no"] == 1 ) $select_val = "언";
							else $select_val = "오";
						} else if ( $gameCode == "p_p-oe" ) {
							$gameName = "파워볼홀짝";
							if ( $TPL_V2["select_no"] == 1 ) $select_val = "홀";
							else $select_val = "짝";
						} else if ( $gameCode == "p_p-uo" ) {
							$gameName = "파워볼언오";
							if ( $TPL_V2["select_no"] == 1 ) $select_val = "언";
							else $select_val = "오";
						} else if ( $gameCode == "p_01" ) {
							$gameName = "파워볼숫자";
							if ( $TPL_V2["select_no"] == 1 ) $select_val = "0";
							else $select_val = "1";
						} else if ( $gameCode == "p_23" ) {
							$gameName = "파워볼숫자";
							if ( $TPL_V2["select_no"] == 1 ) $select_val = "2";
							else $select_val = "3";
						} else if ( $gameCode == "p_45" ) {
							$gameName = "파워볼숫자";
							if ( $TPL_V2["select_no"] == 1 ) $select_val = "4";
							else $select_val = "5";
						} else if ( $gameCode == "p_67" ) {
							$gameName = "파워볼숫자";
							if ( $TPL_V2["select_no"] == 1 ) $select_val = "6";
							else $select_val = "7";
						} else if ( $gameCode == "p_89" ) {
							$gameName = "파워볼숫자";
							if ( $TPL_V2["select_no"] == 1 ) $select_val = "8";
							else $select_val = "9";
						} else if ( $gameCode == "p_0279" ) {
							$gameName = "파워볼구간";
							if ( $TPL_V2["select_no"] == 1 ) $select_val = "A(0~2)";
							else $select_val = "D(7~9)";
						} else if ( $gameCode == "p_3456" ) {
							$gameName = "파워볼구간";
							if ( $TPL_V2["select_no"] == 1 ) $select_val = "B(3~4)";
							else $select_val = "C(5~6)";
						} else if ( $gameCode == "p_oe-unover" ) {
							$gameName = "파워볼조합";
							if ( $TPL_V2["select_no"] == 1 ) $select_val = "홀-언더";
							else $select_val = "짝-오버";
						} else if ( $gameCode == "p_eo-unover" ) {
							$gameName = "파워볼조합";
							if ( $TPL_V2["select_no"] == 1 ) $select_val = "짝-언더";
							else $select_val = "홀-오버";
						} else if ( $gameCode == "p_noe-unover" ) {
							$gameName = "일반볼조합";
							if ( $TPL_V2["select_no"] == 1 ) $select_val = "홀-언더";
							else $select_val = "짝-오버";
						} else if ( $gameCode == "p_neo-unover" ) {
							$gameName = "일반볼조합";
							if ( $TPL_V2["select_no"] == 1 ) $select_val = "짝-언더";
							else $select_val = "홀-오버";
						}

						$btNo = $forCnt;
						$dom .= "<tr>
								<td>".$btNo."</td>
								<td style=\"font-weight:bold;\">{$bettingDate} <br />[{$gameTh}회차]</td>
								<td>{$betDay}<br />{$betTime}</td>
								<td style=\"font-weight:bold;\">{$gameName}</td>
								<td>{$select_val}</td>
								<td>{$bettingRate}</td>
								<td>".number_format($bettingMoney)."</td>
								<td class=\"new_betting_no\" id='resultMoney_{$bettingNo}'>{$resultMoney}</td>
								<td id='result_{$bettingNo}'>{$bettingResult}</td>
							</tr>";
					}
				} else {
					$dom = "<tr>
								<td colspan='12'>배팅 내역이 없습니다.</td>
							</tr>";
				}
			}
		} else if($specialType == "25") {
			foreach ( $betting_list as $TPL_K1 => $TPL_V1 ) {
				$forCnt++;
				$TPL_item_2=empty($TPL_V1["item"]) || !is_array($TPL_V1["item"]) ? 0 : count($TPL_V1["item"]);
				if ( $TPL_item_2 ) { 
		
					$bettingNo = $TPL_V1["betting_no"];
					$bettingRate = $TPL_V1["result_rate"];
					$bettingMoney = $TPL_V1["betting_money"];
					$betDay = substr($TPL_V1["bet_date"],5,5);
					$betTime = substr($TPL_V1["bet_date"],11,8);
		
					foreach ( $TPL_V1["item"] as $TPL_V2 ) {
						$gameCode = $TPL_V2["game_code"];
						$gameTh = $TPL_V2["game_th"];
						$bettingDate = str_replace("-","월 ",substr($TPL_V2["gameDate"],5,5))."일";
		
						if ( $TPL_V2["home_rate"] < 1.1 and $TPL_V2["draw_rate"] < 1.1 and $TPL_V2["away_rate"] < 1.1  ) {
							$resultMoney = "-";
							$bettingResult = "<font color='#f65555'>적특</font>";
						} else {
							$resultMoney = "-";
							if ( $TPL_V2["result"] == 1 ) {
								$bettingResult = "<span style='color: lightgreen;'>적중</span>";
								$resultMoney = "<span class=\"new_betting_ok\">".number_format($bettingMoney * $bettingRate)."</span>";
							} else if ( $TPL_V2["result"] == 2 ) {
								$bettingResult = "<span style='color: red;'>미적중</span>";
								$resultMoney = "<span class=\"new_betting_no\">-".number_format($bettingMoney)."</span>";
							} else if ( $TPL_V2["result"] == 4 ) {
								$bettingResult = "적특";	
							} else {
								$bettingResult = "진행중";
							}
						}
		
						if ( $gameCode == "ps_oe" ) {
							$gameName = "홀/짝";
							if ( $TPL_V2["select_no"] == 1 ) {
								$select_val = "<img src=\"/images/mybet_odd.png\">";
							} else {
								$select_val = "<img src=\"/images/mybet_even.png\">";
							}
						} else if ( $gameCode == "ps_lr" ) {
							$gameName = "좌/우";
							if ( $TPL_V2["select_no"] == 1 ) {
								$select_val = "<img src=\"/images/mybet_left.png\">";
							} else {
								$select_val = "<img src=\"/images/mybet_right.png\">";
							}
						} else if ( $gameCode == "ps_34" ) {
							$gameName = "3줄/4줄";
							if ( $TPL_V2["select_no"] == 1 ) {
								$select_val = "<img src=\"/images/mybet_3line.png\">";
							} else {
								$select_val = "<img src=\"/images/mybet_4line.png\">";
							}
						} else if ( $gameCode == "ps_e3o4l" ) {
							$gameName = "짝좌3줄/홀좌4줄";
							if ( $TPL_V2["select_no"] == 1 ) {
								$select_val = "<img src=\"/images/mybet_even3line_left.png\">";
							} else {
								$select_val = "<img src=\"/images/mybet_odd4line_left.png\">";
							}
						} else if ( $gameCode == "ps_o3e4r" ) {
							$gameName = "홀우3줄/짝우4줄";
							if ( $TPL_V2["select_no"] == 1 ) {
								$select_val = "<img src=\"/images/mybet_odd3line_right.png\">";
							} else {
								$select_val = "<img src=\"/images/mybet_even4line_right.png\">";
							}
						}
						$btNo = $forCnt;
						$dom .= "<tr>
								<td>".$btNo."</td>
								<td style=\"font-weight:bold;\">{$bettingDate} <br />[{$gameTh}회차]</td>
								<td>{$betDay}<br />{$betTime}</td>
								<td style=\"font-weight:bold;\">{$gameName}</td>
								<td>{$select_val}</td>
								<td>{$bettingRate}</td>
								<td>".number_format($bettingMoney)."</td>
								<td class=\"new_betting_no\" id='resultMoney_{$bettingNo}'>{$resultMoney}</td>
								<td id='result_{$bettingNo}'>{$bettingResult}</td>
							</tr>";
						
					}
				} else {
					$dom = "<tr>
								<td colspan='12'>배팅 내역이 없습니다.</td>
							</tr>";
				}
			}
		}
	
		echo $dom;
	}

	//-> 파워볼 최근경기 결과 5개.
	public function powerball_result_graphAction() {
		$this->commonDefine('ladder_graph');
		
		if ( !$this->auth->isLogin() ) {
			$this->loginAction();
			exit;
		}

		$gameListModel = $this->getModel("GameListModel");
		$power_result_list = $gameListModel->getPowerResultList(5);
		echo json_encode($power_result_list);
	}

	//-> 사다리 그래프
	public function sadari_result_graphAction() {
		$this->commonDefine('ladder_graph');
		
		if ( !$this->auth->isLogin() ) {
			$this->loginAction();
			exit;
		}

		$gameListModel = $this->getModel("GameListModel");
		$sadari_result = json_encode($gameListModel->getSadariResult());
		if ( !$sadari_result ) $sadari_result = "[]";

		$this->view->assign('sadari_result', $sadari_result);
		$this->display();
	}

	//-> 다리다리 그래프
	public function dari_result_graphAction() {
		$this->commonDefine('ladder_graph');
		
		if ( !$this->auth->isLogin() ) {
			$this->loginAction();
			exit;
		}

		$gameListModel = $this->getModel("GameListModel");
		$sadari_result = json_encode($gameListModel->getDariResult());
		if ( !$sadari_result ) $sadari_result = "[]";

		$this->view->assign('sadari_result', $sadari_result);
		$this->display();
	}

    //-> 알라딘 그래프
    public function aladin_result_graphAction() {
        $this->commonDefine('ladder_graph_aladin');

        if ( !$this->auth->isLogin() ) {
            $this->loginAction();
            exit;
        }

        $gameListModel = $this->getModel("GameListModel");
        $result = json_encode($gameListModel->getAladinResult());
        if ( !$result ) $result = "[]";

        $this->view->assign('graphData', $result);
        $this->display();
    }

    //-> 2다리 그래프
    public function dari2_result_graphAction() {
        $this->commonDefine('ladder_graph_2dari');

        if ( !$this->auth->isLogin() ) {
            $this->loginAction();
            exit;
        }

        $gameListModel = $this->getModel("GameListModel");
        $result = json_encode($gameListModel->get2DariResult());
        if ( !$result ) $result = "[]";

        $this->view->assign('graphData', $result);
        $this->display();
    }

    //-> 3다리 그래프
    public function dari3_result_graphAction() {
        $this->commonDefine('ladder_graph_3dari');

        if ( !$this->auth->isLogin() ) {
            $this->loginAction();
            exit;
        }

        $gameListModel = $this->getModel("GameListModel");
        $result = json_encode($gameListModel->get3DariResult());
        if ( !$result ) $result = "[]";

        $this->view->assign('graphData', $result);
        $this->display();
    }

	//▶ 라이브스코어
	public function livescoreAction() {
		$this->commonDefine('ladder');
		
		if ( !$this->auth->isLogin() ) {
			$this->loginAction();
			exit;
		}	

		$this->view->define(array("content"=>"content/livescore.html"));
		$this->displayRight();
		$this->display();
	}

    //-> 파워사다리 그래프
    public function powersadari_result_graphAction() {
        $this->commonDefine('ladder_graph_powersadari');

        if ( !$this->auth->isLogin() ) {
            $this->loginAction();
            exit;
        }

        $gameListModel = $this->getModel("GameListModel");
        $result = json_encode($gameListModel->getPowerSadariResult());
        if ( !$result ) $result = "[]";

        $this->view->assign('graphData', $result);
        $this->display();
    }

	public function fx1_result_graphAction() {
		$this->commonDefine('ladder_graph_fx');

		if ( !$this->auth->isLogin() ) {
			$this->loginAction();
			exit;
		}

		$gameListModel = $this->getModel("GameListModel");
		$result = json_encode($gameListModel->getFxResult("1"));
		if ( !$result ) $result = "[]";

		$this->view->assign('graphData', $result);
		$this->display();
	}

    //-> 키노사다리 그래프
    public function kenosadari_result_graphAction() {
        $this->commonDefine('ladder_graph_kenosadari');

        if ( !$this->auth->isLogin() ) {
            $this->loginAction();
            exit;
        }

        $gameListModel = $this->getModel("GameListModel");
        $result = json_encode($gameListModel->getKenoSadariResult());
        if ( !$result ) $result = "[]";

        $this->view->assign('graphData', $result);
        $this->display();
    }

	//▶ FAQ 페이지
	public function game_faqAction() {
		$this->commonDefine('ladder');
		
		if ( !$this->auth->isLogin() ) {
			$this->loginAction();
			exit;
		}	

		$this->view->define(array("content"=>"content/game_faq.html"));
		$this->displayRight();
		$this->display();
	}

    //▶ 게임가이드 페이지
    public function bet365_soccerAction() {
        $this->popupDefine();

        if ( !$this->auth->isLogin() ) {
            $this->loginAction();
            exit;
        }

        $game = $this->request('src');
        $this->view->assign("src", $game);
        $this->view->define(array("content"=>"content/bet365_soccer.html"));
        $this->display();
    }

	//▶ 게임가이드 페이지
	public function game_guideAction() {
		$this->commonDefine('graph');
		
		if ( !$this->auth->isLogin() ) {
			$this->loginAction();
			exit;
		}	
		
		$boardModel = Lemon_Instance::getObject("BoardModel", true);
		$list = $boardModel->getGuide();
		$this->view->assign("list", $list);
		$this->view->define(array("content"=>"content/game_guide.html"));
		$this->displayRight();
		$this->display();
	}

	//▶ 로그아웃
	function logoutAction()
	{
		if($this->auth->isLogin())
			session_destroy();
		
		$this->redirect('/');
	}

	//▶ 로그인 처리
	public function loginProcessAction()
	{
		$model 		= Lemon_Instance::getObject("LoginModel",true);

		$id = $this->req->post('uid');
		$passwd = $this->req->post('upasswd');

		if(strpos($id, "'")!==false)
		{
			throw new Lemon_ScriptException("잘못된 인자입니다");
			exit;
		}

		$result = $model->loginMember($id, $passwd);

		if ( 1 == $result ) {
			$this->redirect("/");
		} else if ( 0 == $result ) {
			throw new Lemon_ScriptException("계정정보를 확인 바랍니다");
		} else if ( 2 == $result ) {
			throw new Lemon_ScriptException("접근금지 아이피입니다. 관리자에게 문의 하십시요.");
		} else if ( 3 == $result ) {
			throw new Lemon_ScriptException('죄송합니다. 고객님은 신규회원으로서 관리자 검토후 로그인가능합니다. \\n \\n검토중이니 잠시뒤에 다시 로그인 시도를 하여주십시오.');
		} else if ( 4 == $result ) {
			throw new Lemon_ScriptException('죄송합니다. 고객님은 사용 중지 상태입니다. 관리자에게 문의하십시오!');
		} else if ( 5 == $result) {
			throw new Lemon_ScriptException('계정정보를 확인 바랍니다.');
		} else if ( 6 == $result ) {
			throw new Lemon_ScriptException('제한된 도메인 입니다.');
		} else if ( 7 == $result ) {
			throw new Lemon_ScriptException('너무 짧은 시간에 많은 로그인을 하셨습니다.\n\n잠시후에 다시 시도해주세요.');
		}
	}
	
	//▶ 메모 목록
	function memoProcessAction()
	{
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
	
		$memoModel = Lemon_Instance::getObject("MemoModel", true);
		$mode 	= $this->request('mode');
		
		
		if($mode=="delete")
		{
			$sn 	= $this->request('memo_sn');
			$rs = $memoModel->delMemo($sn);	
			if($rs>0)
			{
				throw new Lemon_ScriptException("삭제 되였습니다",'','go','/');
				exit;
			}
			else
			{
				throw new Lemon_ScriptException("오류가 있습니다.");				
				exit;
			}
		}
		elseif($mode=="confirm")
		{
			$sn 	= $this->request('memo_sn');
			$rs = $memoModel->modifyMemoRead($sn);
			if($rs>0)
			{
				throw new Lemon_ScriptException("확인처리 되었습니다",'','go','/');
				exit;
			}
			else
			{
				throw new Lemon_ScriptException("오류가 있습니다.");				
				exit;
			}
		}
		else
			throw new Lemon_ScriptException("잘못된 인자입니다.",'','go','/');
	}

	function maintainAction()
	{
		$this->commonDefine('maintain');
		$this->view->define(array("content"=>"content/maintain.html"));
		
		$this->display();
	}

	public function getServerTimeAction() {
		$result = array();
		$result["result"]	= "error";
		$result["h_time"] = (time()+30)."000";
		$result["result"]	= "ok";
		echo json_encode($result);
	}

	function eventAction()
	{
		$this->commonDefine('event');
		$this->view->define(array("content"=>"content/event.html"));

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->loginAction();
			exit;
		}

		$configModel = Lemon_Instance::getObject("ConfigModel", true);
		$list = $configModel->getEventRows("*", " is_use='Y'");

		$this->view->assign('list', $list);

		$this->display();
	}

	function slotAction()
	{
		$this->commonDefine('slot');
		$this->view->define(array("content"=>"content/slot.html"));

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->loginAction();
			exit;
		}

		$this->display();
	}

	function graphAction()
	{
		$this->commonDefine('graph');
		$this->view->define(array("content"=>"content/graph.html"));

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->loginAction();
			exit;
		}

		$configModel = Lemon_Instance::getObject("ConfigModel", true);
		$list = $configModel->getEventRows("*", " is_use='Y'");

		$this->view->assign('list', $list);

		$this->display();
	}

	
	function pokerAction()
	{
		$this->commonDefine('poker');
		$this->view->define(array("content"=>"content/poker.html"));

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->loginAction();
			exit;
		}

		$this->display();
	}

	function casino_slotAction()
	{
		$this->commonDefine('casino');
		$this->view->define(array("content"=>"content/casino_slot.html"));

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->loginAction();
			exit;
		}

		$this->display();
	}

	function virtualgameAction()
	{
		$this->commonDefine('virtualgame');
		$this->view->define(array("content"=>"content/virtualgame.html"));

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->loginAction();
			exit;
		}

		$this->display();
	}

	function minigameAction()
	{
		$this->commonDefine('login');

		if($this->isMobile() == "pc") {
			$this->view->define(array("content"=>"content/minigame.html"));
		} else {
			$this->view->define(array("content"=>"content/minigame_m.html"));
		}
		

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->loginAction();
			exit;
		}

		$logo = $this->request('logo');

        if($logo=='')
            $logo = $this->logo;

		$model = $this->getModel("ConfigModel");
        $list = $model->getMiniConfigRow("*", "", $logo);

        $this->view->assign( "miniSetting", $list);

		$this->display();
	}

	function bokAction()
	{
		$this->commonDefine('graph');
		$this->view->define(array("content"=>"content/bok.html"));

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->loginAction();
			exit;
		}

		$this->display();
	}

	function couponAction()
	{
		$this->commonDefine('join');
		$this->view->define(array("content"=>"content/coupon.html"));

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->loginAction();
			exit;
		}

		$this->display();
	}

	function xpointAction()
	{
		$this->commonDefine('join');
		$this->view->define(array("content"=>"content/xpoint.html"));

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->loginAction();
			exit;
		}

		$this->display();
	}

	function recommandAction()
	{
		$this->commonDefine('graph');
		$this->view->define(array("content"=>"content/recommand.html"));

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->loginAction();
			exit;
		}

		$this->display();
	}
	
	function recent_resultAction() {
        echo file_get_contents('http://ntry.com/data/json/games/powerball/recent_result.json');
    }

    function nchat_room_listAction() {
        echo file_get_contents('http://ntry.com/data/json/games/nchat_room_list.json');
    }

    function distAction() {
        echo file_get_contents('http://ntry.com/data/json/games/dist.json');
    }

    function sync_clockAction() {
        echo '[]';
    }

    function abc_bannerAction() {
        echo file_get_contents('http://ntry.com/data/json/games/abc_banner.json');
    }

    function cautionAction() {
        echo file_get_contents('http://ntry.com/data/json/games/powerball/caution.json');
    }

    function resultAction() {
        echo file_get_contents('http://ntry.com/data/json/games/powerball/result.json');
    }

	function getClassicGameListAction() {
		/*
		$gameListModel = $this->getModel("GameListModel");

		$page_index = empty($this->request('page_index')) ? 0 : $this->request('page_index');
		$sport_type = empty($this->request('sport_type')) ? "" : $this->request('sport_type');
		$league_sn = empty($this->request('league_sn')) ? 0 : $this->request('league_sn');
		$today = empty($this->request('today')) ? 0 : $this->request('today');

		date_default_timezone_set("Asia/Seoul");

		$where = "";
		switch($sport_type) {
			case "soccer": 
				$where .= " AND tb_child.sport_name = '축구'";
				break;
			case "baseball": 
				$where .= " AND tb_child.sport_name = '야구'";
				break;
			case "basketball": 
				$where .= " AND tb_child.sport_name = '농구'";
				break;
			case "volleyball": 
				$where .= " AND tb_child.sport_name = '배구'";
				break;
			case "hockey": 
				$where .= " AND (tb_child.sport_name like '%하키%')";
				break;
			case "tennis":
				$where .= " AND tb_child.sport_name = '테니스'";
				break;
			case "esports": 
				$where .= " AND tb_child.sport_name = 'E스포츠'";
				break;
			case "handball": 
				$where .= " AND tb_child.sport_name = '핸드볼'";
				break;
			case "mortor": 
				$where .= " AND tb_child.sport_name = '모토'";
				break;
			case "rugby": 
				$where .= " AND tb_child.sport_name = '럭비'";
				break;
			case "criket": 
				$where .= " AND tb_child.sport_name = '크리켓'";
				break;
			case "darts": 
				$where .= " AND tb_child.sport_name = '다트'";
				break;
			case "futsal": 
				$where .= " AND tb_child.sport_name = '풋살'";
				break;
			case "badminton": 
				$where .= " AND tb_child.sport_name = '배드민턴'";
				break;
			case "tabletennis": 
				$where .= " AND tb_child.sport_name = '탁구'";
				break;
			case "etc": 
				$where .= " AND (tb_child.sport_name = '' OR tb_child.sport_name = '미분류') ";
			break;
		}

		if($league_sn != 0) {
			$where .= " AND tb_child.league_sn = " . $league_sn;
		}

		$gameList = $gameListModel->getClassicGameList($where, 300, $page_index);
		*/
		$gameList = '[
			{
				"m_nGame": 979,
				"m_nFixtureID": 7058667,
				"m_nSports": 48242,
				"m_strSportName": "농구",
				"m_nLeague": 617,
				"m_strLeagueName": "Pro B",
				"m_strLeagueImg": "/upload/league/147.png",
				"m_strHomeTeam": "Fos Ouest Basket",
				"m_strAwayTeam": "UJAP Quimper",
				"m_strDate": "2021-06-09",
				"m_strHour": "02",
				"m_strMin": "00",
				"m_nStatus": 1,
				"m_strPeriod": "",
				"m_nHomeScore": 0,
				"m_nAwayScore": 0,
				"m_nGroup": 1,
				"m_lstDetail": [
					{
						"m_nMarket": 1,
						"m_strMarket": "승무패",
						"m_nHBetCode": 2438054087058667,
						"m_nDBetCode": 4790762437058667,
						"m_nABetCode": 18098893497058667,
						"m_fHRate": 1.28,
						"m_fDRate": 22.0,
						"m_fARate": 4.05,
						"m_fHBase": 1.27,
						"m_fDBase": 22.0,
						"m_fABase": 4.15,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1",
						"m_strDName": "X",
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 14962208197058667,
						"m_nDBetCode": 0,
						"m_nABetCode": 19518293377058667,
						"m_fHRate": 1.95,
						"m_fDRate": 0.0,
						"m_fARate": 1.81,
						"m_fHBase": 1.95,
						"m_fDBase": 0.0,
						"m_fABase": 1.81,
						"m_strHLine": "155.5",
						"m_strDLine": null,
						"m_strALine": "155.5",
						"m_strBLine": "155.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 18995053467058667,
						"m_nDBetCode": 0,
						"m_nABetCode": 19518293347058667,
						"m_fHRate": 2.0,
						"m_fDRate": 0.0,
						"m_fARate": 1.76,
						"m_fHBase": 2.0,
						"m_fDBase": 0.0,
						"m_fABase": 1.76,
						"m_strHLine": "155.0",
						"m_strDLine": null,
						"m_strALine": "155.0",
						"m_strBLine": "155.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 10727333167058667,
						"m_nDBetCode": 0,
						"m_nABetCode": 19518293047058667,
						"m_fHRate": 1.9,
						"m_fDRate": 0.0,
						"m_fARate": 1.9,
						"m_fHBase": 1.9,
						"m_fDBase": 0.0,
						"m_fABase": 1.9,
						"m_strHLine": "156.5",
						"m_strDLine": null,
						"m_strALine": "156.5",
						"m_strBLine": "156.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 10984065817058667,
						"m_nDBetCode": 0,
						"m_nABetCode": 19518297617058667,
						"m_fHRate": 1.75,
						"m_fDRate": 0.0,
						"m_fARate": 1.0,
						"m_fHBase": 1.75,
						"m_fDBase": 0.0,
						"m_fABase": 1.0,
						"m_strHLine": "158.0",
						"m_strDLine": null,
						"m_strALine": "158.0",
						"m_strBLine": "158.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 2
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 12138958177058667,
						"m_nDBetCode": 0,
						"m_nABetCode": 19518292717058667,
						"m_fHRate": 1.8,
						"m_fDRate": 0.0,
						"m_fARate": 1.97,
						"m_fHBase": 1.8,
						"m_fDBase": 0.0,
						"m_fABase": 1.97,
						"m_strHLine": "157.5",
						"m_strDLine": null,
						"m_strALine": "157.5",
						"m_strBLine": "157.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 5955434317058667,
						"m_nDBetCode": 0,
						"m_nABetCode": 19518293657058667,
						"m_fHRate": 1.0,
						"m_fDRate": 0.0,
						"m_fARate": 1.68,
						"m_fHBase": 1.0,
						"m_fDBase": 0.0,
						"m_fABase": 1.68,
						"m_strHLine": "154.0",
						"m_strDLine": null,
						"m_strALine": "154.0",
						"m_strBLine": "154.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 16171803447058667,
						"m_nDBetCode": 0,
						"m_nABetCode": 19518292687058667,
						"m_fHRate": 1.85,
						"m_fDRate": 0.0,
						"m_fARate": 1.93,
						"m_fHBase": 1.85,
						"m_fDBase": 0.0,
						"m_fABase": 1.93,
						"m_strHLine": "157.0",
						"m_strDLine": null,
						"m_strALine": "157.0",
						"m_strBLine": "157.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 3132184297058667,
						"m_nDBetCode": 0,
						"m_nABetCode": 19518292997058667,
						"m_fHRate": 1.92,
						"m_fDRate": 0.0,
						"m_fARate": 1.86,
						"m_fHBase": 1.92,
						"m_fDBase": 0.0,
						"m_fABase": 1.86,
						"m_strHLine": "156.0",
						"m_strDLine": null,
						"m_strALine": "156.0",
						"m_strBLine": "156.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 13550583187058667,
						"m_nDBetCode": 0,
						"m_nABetCode": 19518293707058667,
						"m_fHRate": 1.0,
						"m_fDRate": 0.0,
						"m_fARate": 1.72,
						"m_fHBase": 1.0,
						"m_fDBase": 0.0,
						"m_fABase": 1.72,
						"m_strHLine": "154.5",
						"m_strDLine": null,
						"m_strALine": "154.5",
						"m_strBLine": "154.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 2
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 6951220547058667,
						"m_nDBetCode": 0,
						"m_nABetCode": 19518297587058667,
						"m_fHRate": 1.71,
						"m_fDRate": 0.0,
						"m_fARate": 1.0,
						"m_fHBase": 1.71,
						"m_fDBase": 0.0,
						"m_fABase": 1.0,
						"m_strHLine": "158.5",
						"m_strDLine": null,
						"m_strALine": "158.5",
						"m_strBLine": "158.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 226,
						"m_strMarket": "승패 [연장포함]",
						"m_nHBetCode": 5921027987058667,
						"m_nDBetCode": 0,
						"m_nABetCode": 9953873257058667,
						"m_fHRate": 1.27,
						"m_fDRate": 0.0,
						"m_fARate": 3.76,
						"m_fHBase": 1.26,
						"m_fDBase": 0.0,
						"m_fABase": 3.85,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 342,
						"m_strMarket": "핸디캡 [연장포함]",
						"m_nHBetCode": 5180072397058667,
						"m_nDBetCode": 0,
						"m_nABetCode": 13943728657058667,
						"m_fHRate": 1.67,
						"m_fDRate": 0.0,
						"m_fARate": 1.0,
						"m_fHBase": 1.65,
						"m_fDBase": 0.0,
						"m_fABase": 1.0,
						"m_strHLine": "-6.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "6.5 (0-0)",
						"m_strBLine": "-6.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 342,
						"m_strMarket": "핸디캡 [연장포함]",
						"m_nHBetCode": 5145910487058667,
						"m_nDBetCode": 0,
						"m_nABetCode": 9941357827058667,
						"m_fHRate": 1.8,
						"m_fDRate": 0.0,
						"m_fARate": 1.97,
						"m_fHBase": 1.77,
						"m_fDBase": 0.0,
						"m_fABase": 2.01,
						"m_strHLine": "-7.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "7.5 (0-0)",
						"m_strBLine": "-7.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 342,
						"m_strMarket": "핸디캡 [연장포함]",
						"m_nHBetCode": 5343059897058667,
						"m_nDBetCode": 0,
						"m_nABetCode": 574009257058667,
						"m_fHRate": 1.94,
						"m_fDRate": 0.0,
						"m_fARate": 1.86,
						"m_fHBase": 1.9,
						"m_fDBase": 0.0,
						"m_fABase": 1.9,
						"m_strHLine": "-8.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "8.5 (0-0)",
						"m_strBLine": "-8.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 342,
						"m_strMarket": "핸디캡 [연장포함]",
						"m_nHBetCode": 5308897987058667,
						"m_nDBetCode": 0,
						"m_nABetCode": 4576380087058667,
						"m_fHRate": 2.06,
						"m_fDRate": 0.0,
						"m_fARate": 1.73,
						"m_fHBase": 2.02,
						"m_fDBase": 0.0,
						"m_fABase": 1.76,
						"m_strHLine": "-9.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "9.5 (0-0)",
						"m_strBLine": "-9.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 342,
						"m_strMarket": "핸디캡 [연장포함]",
						"m_nHBetCode": 1717747607058667,
						"m_nDBetCode": 0,
						"m_nABetCode": 890607587058667,
						"m_fHRate": 1.0,
						"m_fDRate": 0.0,
						"m_fARate": 1.61,
						"m_fHBase": 1.0,
						"m_fDBase": 0.0,
						"m_fABase": 1.64,
						"m_strHLine": "-10.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "10.5 (0-0)",
						"m_strBLine": "-10.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					}
				],
				"m_lstSportsCnt": [
					{
						"m_nSports": 6046,
						"m_strName": "축구",
						"m_nCount": 0,
						"m_lstCountryCnt": []
					},
					{
						"m_nSports": 35232,
						"m_strName": "아이스 하키",
						"m_nCount": 0,
						"m_lstCountryCnt": []
					},
					{
						"m_nSports": 48242,
						"m_strName": "농구",
						"m_nCount": 3,
						"m_lstCountryCnt": [
							{
								"m_nCountry": 147,
								"m_strName": "프랑스",
								"m_strImg": "/upload/league/147.png",
								"m_nCount": 1,
								"m_lstLeagueCnt": [
									{
										"m_nLeague": 617,
										"m_strName": "Pro B",
										"m_strImg": "/upload/league/147.png",
										"m_nCount": 1
									}
								]
							},
							{
								"m_nCountry": 128,
								"m_strName": "리투아니아",
								"m_strImg": "/upload/league/128.png",
								"m_nCount": 1,
								"m_lstLeagueCnt": [
									{
										"m_nLeague": 1049,
										"m_strName": "리투아니아 농구 리그",
										"m_strImg": "/upload/league/128.png",
										"m_nCount": 1
									}
								]
							},
							{
								"m_nCountry": 158,
								"m_strName": "레바논",
								"m_strImg": "/upload/league/158.png",
								"m_nCount": 1,
								"m_lstLeagueCnt": [
									{
										"m_nLeague": 33934,
										"m_strName": "Championship",
										"m_strImg": "/upload/league/158.png",
										"m_nCount": 1
									}
								]
							}
						]
					},
					{
						"m_nSports": 154830,
						"m_strName": "배구",
						"m_nCount": 0,
						"m_lstCountryCnt": []
					},
					{
						"m_nSports": 154914,
						"m_strName": "야구",
						"m_nCount": 0,
						"m_lstCountryCnt": []
					}
				]
			},
			{
				"m_nGame": 983,
				"m_nFixtureID": 7058608,
				"m_nSports": 48242,
				"m_strSportName": "농구",
				"m_nLeague": 33934,
				"m_strLeagueName": "Championship",
				"m_strLeagueImg": "/upload/league/158.png",
				"m_strHomeTeam": "Homentmen",
				"m_strAwayTeam": "Hoops Club",
				"m_strDate": "2021-06-09",
				"m_strHour": "02",
				"m_strMin": "00",
				"m_nStatus": 1,
				"m_strPeriod": "",
				"m_nHomeScore": 0,
				"m_nAwayScore": 0,
				"m_nGroup": 2,
				"m_lstDetail": [
					{
						"m_nMarket": 1,
						"m_strMarket": "승무패",
						"m_nHBetCode": 10362963077058608,
						"m_nDBetCode": 16186816907058608,
						"m_nABetCode": 6330117807058608,
						"m_fHRate": 7.8,
						"m_fDRate": 28.0,
						"m_fARate": 1.08,
						"m_fHBase": 8.5,
						"m_fDBase": 28.0,
						"m_fABase": 1.06,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1",
						"m_strDName": "X",
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 16893883477058608,
						"m_nDBetCode": 0,
						"m_nABetCode": 10897852477058608,
						"m_fHRate": 1.84,
						"m_fDRate": 0.0,
						"m_fARate": 1.86,
						"m_fHBase": 1.84,
						"m_fDBase": 0.0,
						"m_fABase": 1.86,
						"m_strHLine": "150.5",
						"m_strDLine": null,
						"m_strALine": "150.5",
						"m_strBLine": "150.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 226,
						"m_strMarket": "승패 [연장포함]",
						"m_nHBetCode": 17814108497058608,
						"m_nDBetCode": 0,
						"m_nABetCode": 9474725067058608,
						"m_fHRate": 7.1,
						"m_fDRate": 0.0,
						"m_fARate": 1.08,
						"m_fHBase": 7.7,
						"m_fDBase": 0.0,
						"m_fABase": 1.06,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					}
				],
				"m_lstSportsCnt": null
			},
			{
				"m_nGame": 981,
				"m_nFixtureID": 7058621,
				"m_nSports": 48242,
				"m_strSportName": "농구",
				"m_nLeague": 1049,
				"m_strLeagueName": "리투아니아 농구 리그",
				"m_strLeagueImg": "/upload/league/128.png",
				"m_strHomeTeam": "Juventus",
				"m_strAwayTeam": "Panevezio Lietkabelis",
				"m_strDate": "2021-06-10",
				"m_strHour": "00",
				"m_strMin": "50",
				"m_nStatus": 1,
				"m_strPeriod": "",
				"m_nHomeScore": 0,
				"m_nAwayScore": 0,
				"m_nGroup": 3,
				"m_lstDetail": [
					{
						"m_nMarket": 1,
						"m_strMarket": "승무패",
						"m_nHBetCode": 18747168187058621,
						"m_nDBetCode": 21099876537058621,
						"m_nABetCode": 8541665377058621,
						"m_fHRate": 1.99,
						"m_fDRate": 18.0,
						"m_fARate": 2.0,
						"m_fHBase": 1.99,
						"m_fDBase": 18.0,
						"m_fABase": 2.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1",
						"m_strDName": "X",
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 16027010947058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 15549109027058621,
						"m_fHRate": 1.0,
						"m_fDRate": 0.0,
						"m_fARate": 1.53,
						"m_fHBase": 1.0,
						"m_fDBase": 0.0,
						"m_fABase": 1.53,
						"m_strHLine": "163.5",
						"m_strDLine": null,
						"m_strALine": "163.5",
						"m_strBLine": "163.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 2
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 14615384967058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 2509490207058621,
						"m_fHRate": 1.58,
						"m_fDRate": 0.0,
						"m_fARate": 2.2,
						"m_fHBase": 1.58,
						"m_fDBase": 0.0,
						"m_fABase": 2.2,
						"m_strHLine": "172.5",
						"m_strDLine": null,
						"m_strALine": "172.5",
						"m_strBLine": "172.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 14413356177058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 15549110317058621,
						"m_fHRate": 2.01,
						"m_fDRate": 0.0,
						"m_fARate": 1.77,
						"m_fHBase": 2.01,
						"m_fDBase": 0.0,
						"m_fABase": 1.77,
						"m_strHLine": "167.0",
						"m_strDLine": null,
						"m_strALine": "167.0",
						"m_strBLine": "167.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 1373736057058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 2509491477058621,
						"m_fHRate": 1.41,
						"m_fDRate": 0.0,
						"m_fARate": 1.0,
						"m_fHBase": 1.41,
						"m_fDBase": 0.0,
						"m_fABase": 1.0,
						"m_strHLine": "176.0",
						"m_strDLine": null,
						"m_strALine": "176.0",
						"m_strBLine": "176.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 17236605227058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 2509490507058621,
						"m_fHRate": 1.45,
						"m_fDRate": 0.0,
						"m_fARate": 1.0,
						"m_fHBase": 1.45,
						"m_fDBase": 0.0,
						"m_fABase": 1.0,
						"m_strHLine": "175.0",
						"m_strDLine": null,
						"m_strALine": "175.0",
						"m_strBLine": "175.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 2
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 17438635957058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 15549108697058621,
						"m_fHRate": 1.0,
						"m_fDRate": 0.0,
						"m_fARate": 1.39,
						"m_fHBase": 1.0,
						"m_fDBase": 0.0,
						"m_fABase": 1.39,
						"m_strHLine": "160.5",
						"m_strDLine": null,
						"m_strALine": "160.5",
						"m_strBLine": "160.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 2
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 18850260967058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 15549108367058621,
						"m_fHRate": 1.0,
						"m_fDRate": 0.0,
						"m_fARate": 1.43,
						"m_fHBase": 1.0,
						"m_fDBase": 0.0,
						"m_fABase": 1.43,
						"m_strHLine": "161.5",
						"m_strDLine": null,
						"m_strALine": "161.5",
						"m_strBLine": "161.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 2
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 4196986077058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 2509490817058621,
						"m_fHRate": 1.5,
						"m_fDRate": 0.0,
						"m_fARate": 1.0,
						"m_fHBase": 1.5,
						"m_fDBase": 0.0,
						"m_fABase": 1.0,
						"m_strHLine": "174.0",
						"m_strDLine": null,
						"m_strALine": "174.0",
						"m_strBLine": "174.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 8229831347058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 2509490787058621,
						"m_fHRate": 1.48,
						"m_fDRate": 0.0,
						"m_fARate": 1.0,
						"m_fHBase": 1.48,
						"m_fDBase": 0.0,
						"m_fABase": 1.0,
						"m_strHLine": "174.5",
						"m_strDLine": null,
						"m_strALine": "174.5",
						"m_strBLine": "174.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 2
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 6818207307058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 15549110267058621,
						"m_fHRate": 1.97,
						"m_fDRate": 0.0,
						"m_fARate": 1.82,
						"m_fHBase": 1.97,
						"m_fDBase": 0.0,
						"m_fABase": 1.82,
						"m_strHLine": "167.5",
						"m_strDLine": null,
						"m_strALine": "167.5",
						"m_strBLine": "167.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 6145635877058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 15549111337058621,
						"m_fHRate": 1.91,
						"m_fDRate": 0.0,
						"m_fARate": 1.91,
						"m_fHBase": 1.91,
						"m_fDBase": 0.0,
						"m_fABase": 1.91,
						"m_strHLine": "168.5",
						"m_strDLine": null,
						"m_strALine": "168.5",
						"m_strBLine": "168.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 17438634987058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 2509489547058621,
						"m_fHRate": 1.73,
						"m_fDRate": 0.0,
						"m_fARate": 2.04,
						"m_fHBase": 1.73,
						"m_fDBase": 0.0,
						"m_fABase": 2.04,
						"m_strHLine": "170.5",
						"m_strDLine": null,
						"m_strALine": "170.5",
						"m_strBLine": "170.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 18850259997058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 2509489217058621,
						"m_fHRate": 1.65,
						"m_fDRate": 0.0,
						"m_fARate": 2.11,
						"m_fHBase": 1.65,
						"m_fDBase": 0.0,
						"m_fABase": 2.11,
						"m_strHLine": "171.5",
						"m_strDLine": null,
						"m_strALine": "171.5",
						"m_strBLine": "171.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 20066567707058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 2509489187058621,
						"m_fHRate": 1.68,
						"m_fDRate": 0.0,
						"m_fARate": 2.08,
						"m_fHBase": 1.68,
						"m_fDBase": 0.0,
						"m_fABase": 2.08,
						"m_strHLine": "171.0",
						"m_strDLine": null,
						"m_strALine": "171.0",
						"m_strBLine": "171.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 9641457327058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 15549109607058621,
						"m_fHRate": 2.11,
						"m_fDRate": 0.0,
						"m_fARate": 1.65,
						"m_fHBase": 2.11,
						"m_fDBase": 0.0,
						"m_fABase": 1.65,
						"m_strHLine": "165.5",
						"m_strDLine": null,
						"m_strALine": "165.5",
						"m_strBLine": "165.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 9843486117058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 2509489497058621,
						"m_fHRate": 1.77,
						"m_fDRate": 0.0,
						"m_fARate": 2.01,
						"m_fHBase": 1.77,
						"m_fDBase": 0.0,
						"m_fABase": 2.01,
						"m_strHLine": "170.0",
						"m_strDLine": null,
						"m_strALine": "170.0",
						"m_strBLine": "170.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 1373737027058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 15549110627058621,
						"m_fHRate": 2.08,
						"m_fDRate": 0.0,
						"m_fARate": 1.68,
						"m_fHBase": 2.08,
						"m_fDBase": 0.0,
						"m_fABase": 1.68,
						"m_strHLine": "166.0",
						"m_strDLine": null,
						"m_strALine": "166.0",
						"m_strBLine": "166.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 7020237067058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 15549109307058621,
						"m_fHRate": 1.0,
						"m_fDRate": 0.0,
						"m_fARate": 1.45,
						"m_fHBase": 1.0,
						"m_fDBase": 0.0,
						"m_fABase": 1.45,
						"m_strHLine": "162.0",
						"m_strDLine": null,
						"m_strALine": "162.0",
						"m_strBLine": "162.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 7020236097058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 2509490157058621,
						"m_fHRate": 1.61,
						"m_fDRate": 0.0,
						"m_fARate": 2.15,
						"m_fHBase": 1.61,
						"m_fDBase": 0.0,
						"m_fABase": 2.15,
						"m_strHLine": "172.0",
						"m_strDLine": null,
						"m_strALine": "172.0",
						"m_strBLine": "172.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 4196987047058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 15549109967058621,
						"m_fHRate": 1.0,
						"m_fDRate": 0.0,
						"m_fARate": 1.55,
						"m_fHBase": 1.0,
						"m_fDBase": 0.0,
						"m_fABase": 1.55,
						"m_strHLine": "164.0",
						"m_strDLine": null,
						"m_strALine": "164.0",
						"m_strBLine": "164.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 2
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 7557260887058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 15549111007058621,
						"m_fHRate": 1.81,
						"m_fDRate": 0.0,
						"m_fARate": 1.98,
						"m_fHBase": 1.81,
						"m_fDBase": 0.0,
						"m_fABase": 1.98,
						"m_strHLine": "169.5",
						"m_strDLine": null,
						"m_strALine": "169.5",
						"m_strBLine": "169.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 5406581327058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 2509491447058621,
						"m_fHRate": 1.4,
						"m_fDRate": 0.0,
						"m_fARate": 1.0,
						"m_fHBase": 1.4,
						"m_fDBase": 0.0,
						"m_fABase": 1.0,
						"m_strHLine": "176.5",
						"m_strDLine": null,
						"m_strALine": "176.5",
						"m_strBLine": "176.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 2
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 11590106157058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 15549110977058621,
						"m_fHRate": 1.86,
						"m_fDRate": 0.0,
						"m_fARate": 1.94,
						"m_fHBase": 1.86,
						"m_fDBase": 0.0,
						"m_fABase": 1.94,
						"m_strHLine": "169.0",
						"m_strDLine": null,
						"m_strALine": "169.0",
						"m_strBLine": "169.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 20059855247058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 2509489847058621,
						"m_fHRate": 1.55,
						"m_fDRate": 0.0,
						"m_fARate": 1.0,
						"m_fHBase": 1.55,
						"m_fDBase": 0.0,
						"m_fABase": 1.0,
						"m_strHLine": "173.0",
						"m_strDLine": null,
						"m_strALine": "173.0",
						"m_strBLine": "173.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 2
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 5406582297058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 15549110597058621,
						"m_fHRate": 2.04,
						"m_fDRate": 0.0,
						"m_fARate": 1.73,
						"m_fHBase": 2.04,
						"m_fDBase": 0.0,
						"m_fABase": 1.73,
						"m_strHLine": "166.5",
						"m_strDLine": null,
						"m_strALine": "166.5",
						"m_strBLine": "166.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 1449513007058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 15549111287058621,
						"m_fHRate": 1.93,
						"m_fDRate": 0.0,
						"m_fARate": 1.87,
						"m_fHBase": 1.93,
						"m_fDBase": 0.0,
						"m_fABase": 1.87,
						"m_strHLine": "168.0",
						"m_strDLine": null,
						"m_strALine": "168.0",
						"m_strBLine": "168.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 17236606197058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 15549109657058621,
						"m_fHRate": 2.15,
						"m_fDRate": 0.0,
						"m_fARate": 1.61,
						"m_fHBase": 2.15,
						"m_fDBase": 0.0,
						"m_fABase": 1.61,
						"m_strHLine": "165.0",
						"m_strDLine": null,
						"m_strALine": "165.0",
						"m_strBLine": "165.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 20059856217058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 15549108997058621,
						"m_fHRate": 1.0,
						"m_fDRate": 0.0,
						"m_fARate": 1.5,
						"m_fHBase": 1.0,
						"m_fDBase": 0.0,
						"m_fABase": 1.5,
						"m_strHLine": "163.0",
						"m_strDLine": null,
						"m_strALine": "163.0",
						"m_strBLine": "163.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 8229832317058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 15549109937058621,
						"m_fHRate": 2.2,
						"m_fDRate": 0.0,
						"m_fARate": 1.58,
						"m_fHBase": 2.2,
						"m_fDBase": 0.0,
						"m_fABase": 1.58,
						"m_strHLine": "164.5",
						"m_strDLine": null,
						"m_strALine": "164.5",
						"m_strBLine": "164.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 9641456357058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 2509490457058621,
						"m_fHRate": 1.44,
						"m_fDRate": 0.0,
						"m_fARate": 1.0,
						"m_fHBase": 1.44,
						"m_fDBase": 0.0,
						"m_fABase": 1.0,
						"m_strHLine": "175.5",
						"m_strDLine": null,
						"m_strALine": "175.5",
						"m_strBLine": "175.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 20066566737058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 15549108337058621,
						"m_fHRate": 1.0,
						"m_fDRate": 0.0,
						"m_fARate": 1.41,
						"m_fHBase": 1.0,
						"m_fDBase": 0.0,
						"m_fABase": 1.41,
						"m_strHLine": "161.0",
						"m_strDLine": null,
						"m_strALine": "161.0",
						"m_strBLine": "161.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 14615385937058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 15549109357058621,
						"m_fHRate": 1.0,
						"m_fDRate": 0.0,
						"m_fARate": 1.48,
						"m_fHBase": 1.0,
						"m_fDBase": 0.0,
						"m_fABase": 1.48,
						"m_strHLine": "162.5",
						"m_strDLine": null,
						"m_strALine": "162.5",
						"m_strBLine": "162.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 28,
						"m_strMarket": "언더오버 [연장포함]",
						"m_nHBetCode": 16027009977058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 2509489877058621,
						"m_fHRate": 1.53,
						"m_fDRate": 0.0,
						"m_fARate": 1.0,
						"m_fHBase": 1.53,
						"m_fDBase": 0.0,
						"m_fABase": 1.0,
						"m_strHLine": "173.5",
						"m_strDLine": null,
						"m_strALine": "173.5",
						"m_strBLine": "173.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 2
					},
					{
						"m_nMarket": 226,
						"m_strMarket": "승패 [연장포함]",
						"m_nHBetCode": 13828056607058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 17860901877058621,
						"m_fHRate": 1.93,
						"m_fDRate": 0.0,
						"m_fARate": 1.93,
						"m_fHBase": 1.93,
						"m_fDBase": 0.0,
						"m_fABase": 1.93,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 342,
						"m_strMarket": "핸디캡 [연장포함]",
						"m_nHBetCode": 10433562637058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 10942723917058621,
						"m_fHRate": 1.76,
						"m_fDRate": 0.0,
						"m_fARate": 2.04,
						"m_fHBase": 1.76,
						"m_fDBase": 0.0,
						"m_fABase": 2.04,
						"m_strHLine": "1.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "-1.5 (0-0)",
						"m_strBLine": "1.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 342,
						"m_strMarket": "핸디캡 [연장포함]",
						"m_nHBetCode": 11701553947058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 10884843587058621,
						"m_fHRate": 1.62,
						"m_fDRate": 0.0,
						"m_fARate": 2.21,
						"m_fHBase": 1.62,
						"m_fDBase": 0.0,
						"m_fABase": 2.21,
						"m_strHLine": "2.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "-2.5 (0-0)",
						"m_strBLine": "2.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 342,
						"m_strMarket": "핸디캡 [연장포함]",
						"m_nHBetCode": 9783275607058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 2085303787058621,
						"m_fHRate": 1.0,
						"m_fDRate": 0.0,
						"m_fARate": 1.35,
						"m_fHBase": 1.0,
						"m_fDBase": 0.0,
						"m_fABase": 1.35,
						"m_strHLine": "-5.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "5.5 (0-0)",
						"m_strBLine": "-5.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 2
					},
					{
						"m_nMarket": 342,
						"m_strMarket": "핸디캡 [연장포함]",
						"m_nHBetCode": 9827840127058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 20025115227058621,
						"m_fHRate": 2.04,
						"m_fDRate": 0.0,
						"m_fARate": 1.76,
						"m_fHBase": 2.04,
						"m_fDBase": 0.0,
						"m_fABase": 1.76,
						"m_strHLine": "-1.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "1.5 (0-0)",
						"m_strBLine": "-1.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 342,
						"m_strMarket": "핸디캡 [연장포함]",
						"m_nHBetCode": 9698973657058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 678931417058621,
						"m_fHRate": 1.0,
						"m_fDRate": 0.0,
						"m_fARate": 1.19,
						"m_fHBase": 1.0,
						"m_fDBase": 0.0,
						"m_fABase": 1.19,
						"m_strHLine": "-8.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "8.5 (0-0)",
						"m_strBLine": "-8.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 2
					},
					{
						"m_nMarket": 342,
						"m_strMarket": "핸디캡 [연장포함]",
						"m_nHBetCode": 361436527058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 10813857447058621,
						"m_fHRate": 1.19,
						"m_fDRate": 0.0,
						"m_fARate": 1.0,
						"m_fHBase": 1.19,
						"m_fDBase": 0.0,
						"m_fABase": 1.0,
						"m_strHLine": "8.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "-8.5 (0-0)",
						"m_strBLine": "8.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 342,
						"m_strMarket": "핸디캡 [연장포함]",
						"m_nHBetCode": 1574874597058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 10919005497058621,
						"m_fHRate": 1.51,
						"m_fDRate": 0.0,
						"m_fARate": 2.39,
						"m_fHBase": 1.51,
						"m_fDBase": 0.0,
						"m_fABase": 2.39,
						"m_strHLine": "3.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "-3.5 (0-0)",
						"m_strBLine": "3.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 342,
						"m_strMarket": "핸디캡 [연장포함]",
						"m_nHBetCode": 9725395277058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 13925504277058621,
						"m_fHRate": 1.0,
						"m_fDRate": 0.0,
						"m_fARate": 1.28,
						"m_fHBase": 1.0,
						"m_fDBase": 0.0,
						"m_fABase": 1.28,
						"m_strHLine": "-6.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "6.5 (0-0)",
						"m_strBLine": "-6.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 342,
						"m_strMarket": "핸디캡 [연장포함]",
						"m_nHBetCode": 9759557187058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 9923133447058621,
						"m_fHRate": 1.0,
						"m_fDRate": 0.0,
						"m_fARate": 1.24,
						"m_fHBase": 1.0,
						"m_fDBase": 0.0,
						"m_fABase": 1.24,
						"m_strHLine": "-7.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "7.5 (0-0)",
						"m_strBLine": "-7.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 2
					},
					{
						"m_nMarket": 342,
						"m_strMarket": "핸디캡 [연장포함]",
						"m_nHBetCode": 9804121707058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 10916120527058621,
						"m_fHRate": 2.39,
						"m_fDRate": 0.0,
						"m_fARate": 1.51,
						"m_fHBase": 2.39,
						"m_fDBase": 0.0,
						"m_fABase": 1.51,
						"m_strHLine": "-3.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "3.5 (0-0)",
						"m_strBLine": "-3.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 342,
						"m_strMarket": "핸디캡 [연장포함]",
						"m_nHBetCode": 19264379377058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 10874440977058621,
						"m_fHRate": 1.24,
						"m_fDRate": 0.0,
						"m_fARate": 1.0,
						"m_fHBase": 1.24,
						"m_fDBase": 0.0,
						"m_fABase": 1.0,
						"m_strHLine": "7.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "-7.5 (0-0)",
						"m_strBLine": "7.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 342,
						"m_strMarket": "핸디캡 [연장포함]",
						"m_nHBetCode": 9749113697058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 1917067057058621,
						"m_fHRate": 2.61,
						"m_fDRate": 0.0,
						"m_fARate": 1.42,
						"m_fHBase": 2.61,
						"m_fDBase": 0.0,
						"m_fABase": 1.42,
						"m_strHLine": "-4.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "4.5 (0-0)",
						"m_strBLine": "-4.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 342,
						"m_strMarket": "핸디캡 [연장포함]",
						"m_nHBetCode": 11676856377058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 10898159397058621,
						"m_fHRate": 1.35,
						"m_fDRate": 0.0,
						"m_fARate": 1.0,
						"m_fHBase": 1.35,
						"m_fDBase": 0.0,
						"m_fABase": 1.0,
						"m_strHLine": "5.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "-5.5 (0-0)",
						"m_strBLine": "5.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 2
					},
					{
						"m_nMarket": 342,
						"m_strMarket": "핸디캡 [연장포함]",
						"m_nHBetCode": 10408865067058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 10840279067058621,
						"m_fHRate": 1.28,
						"m_fDRate": 0.0,
						"m_fARate": 1.0,
						"m_fHBase": 1.28,
						"m_fDBase": 0.0,
						"m_fABase": 1.0,
						"m_strHLine": "6.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "-6.5 (0-0)",
						"m_strBLine": "6.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 342,
						"m_strMarket": "핸디캡 [연장포함]",
						"m_nHBetCode": 9769959797058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 6913749697058621,
						"m_fHRate": 2.21,
						"m_fDRate": 0.0,
						"m_fARate": 1.62,
						"m_fHBase": 2.21,
						"m_fDBase": 0.0,
						"m_fABase": 1.62,
						"m_strHLine": "-2.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "2.5 (0-0)",
						"m_strBLine": "-2.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 342,
						"m_strMarket": "핸디캡 [연장포함]",
						"m_nHBetCode": 1599572167058621,
						"m_nDBetCode": 0,
						"m_nABetCode": 10863997487058621,
						"m_fHRate": 1.42,
						"m_fDRate": 0.0,
						"m_fARate": 2.61,
						"m_fHBase": 1.42,
						"m_fDBase": 0.0,
						"m_fABase": 2.61,
						"m_strHLine": "4.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "-4.5 (0-0)",
						"m_strBLine": "4.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					}
				],
				"m_lstSportsCnt": null
			}
		]';
		echo $gameList;
	}

	function getGameListAction() {
		/* $gameListModel = $this->getModel("GameListModel");

		$page_index = empty($this->request('page_index')) ? 0 : $this->request('page_index');
		$sport_type = empty($this->request('sport_type')) ? "" : $this->request('sport_type');
		$league_sn = empty($this->request('league_sn')) ? 0 : $this->request('league_sn');
		$today = empty($this->request('today')) ? 0 : $this->request('today');

		date_default_timezone_set("Asia/Seoul");

		$where = "";
		switch($sport_type) {
			case "soccer": 
				$where .= " AND tb_child.sport_name = '축구'";
				break;
			case "baseball": 
				$where .= " AND tb_child.sport_name = '야구'";
				break;
			case "basketball": 
				$where .= " AND tb_child.sport_name = '농구'";
				break;
			case "volleyball": 
				$where .= " AND tb_child.sport_name = '배구'";
				break;
			case "hockey": 
				$where .= " AND (tb_child.sport_name like '%하키%')";
				break;
			case "tennis":
				$where .= " AND tb_child.sport_name = '테니스'";
				break;
			case "esports": 
				$where .= " AND tb_child.sport_name = 'E스포츠'";
				break;
			case "handball": 
				$where .= " AND tb_child.sport_name = '핸드볼'";
				break;
			case "mortor": 
				$where .= " AND tb_child.sport_name = '모토'";
				break;
			case "rugby": 
				$where .= " AND tb_child.sport_name = '럭비'";
				break;
			case "criket": 
				$where .= " AND tb_child.sport_name = '크리켓'";
				break;
			case "darts": 
				$where .= " AND tb_child.sport_name = '다트'";
				break;
			case "futsal": 
				$where .= " AND tb_child.sport_name = '풋살'";
				break;
			case "badminton": 
				$where .= " AND tb_child.sport_name = '배드민턴'";
				break;
			case "tabletennis": 
				$where .= " AND tb_child.sport_name = '탁구'";
				break;
			case "etc": 
				$where .= " AND (tb_child.sport_name = '' OR tb_child.sport_name = '미분류') ";
			break;
		}

		if($league_sn != 0) {
			$where .= " AND tb_child.league_sn = " . $league_sn;
		}

		$sql = "SELECT
					tb_subchild.*,
					tb_child.`gameDate`,
					tb_child.`gameHour`,
					tb_child.`gameTime`,
					tb_child.`home_team`,
					tb_child.away_team,
					tb_child.`sport_id`,
					tb_child.sport_name,
					tb_child.notice,
					tb_child.`league_sn`,
					tb_child.league_img
				FROM
					tb_subchild
					LEFT JOIN tb_child
					ON tb_subchild.child_sn = tb_child.sn
				WHERE tb_child.sn IN
					(SELECT
						child_sn
					FROM
					(SELECT
						tb_child.sn AS child_sn
					FROM
						tb_child
					WHERE CONCAT(tb_child.gameDate, ' ', tb_child.gameHour, ':', tb_child.gameTime, ':00') > '" . date("Y-m-d H:i:s", time() + 1800) . "' 
						AND (tb_child.special = 1 OR tb_child.special = 2) AND tb_child.status = 1 
						AND tb_child.user_view_flag = 1 AND tb_child.kubun = 0 AND tb_child.sport_name != '이벤트' 
				" . $where . " 
					ORDER BY tb_child.`gameDate`,
						tb_child.`gameHour`,
						tb_child.`gameTime`
					LIMIT 50 OFFSET " . 50 * $page_index . ") tbl)
					AND tb_subchild.status = 1
					AND tb_subchild.live = 0
				ORDER BY tb_child.`gameDate`,
						tb_child.`gameHour`,
						tb_child.`gameTime`,
						tb_child.notice,
						tb_child.home_team,
						tb_subchild.betting_type,
						tb_subchild.home_line,
						tb_subchild.home_name";

		$gameList = $gameListModel->_excuteQuery($sql); */
		$gameList = '[
			{
				"m_nGame": 392,
				"m_nFixtureID": 7059807,
				"m_nSports": 6046,
				"m_strSportName": "축구",
				"m_nLeague": 14493,
				"m_strLeagueName": "클럽 친선 경기",
				"m_strLeagueImg": "/upload/league/248.jpg",
				"m_strHomeTeam": "FC Gleisdorf 09",
				"m_strAwayTeam": "Gnas",
				"m_strDate": "2021-06-09",
				"m_strHour": "02",
				"m_strMin": "00",
				"m_nStatus": 1,
				"m_strPeriod": "",
				"m_nHomeScore": 0,
				"m_nAwayScore": 0,
				"m_nGroup": 1,
				"m_lstDetail": [
					{
						"m_nMarket": 1,
						"m_strMarket": "승무패",
						"m_nHBetCode": 7291039907059807,
						"m_nDBetCode": 7291040637059807,
						"m_nABetCode": 7291039897059807,
						"m_fHRate": 1.12,
						"m_fDRate": 8.0,
						"m_fARate": 11.0,
						"m_fHBase": 1.2,
						"m_fDBase": 6.0,
						"m_fABase": 9.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1",
						"m_strDName": "X",
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 2,
						"m_strMarket": "언더오버",
						"m_nHBetCode": 17965267647059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 1181206487059807,
						"m_fHRate": 5.5,
						"m_fDRate": 0.0,
						"m_fARate": 1.14,
						"m_fHBase": 3.8,
						"m_fDBase": 0.0,
						"m_fABase": 1.25,
						"m_strHLine": "2.5",
						"m_strDLine": null,
						"m_strALine": "2.5",
						"m_strBLine": "2.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 3,
						"m_strMarket": "핸디캡",
						"m_nHBetCode": 8575311957059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 13763906517059807,
						"m_fHRate": 1.9,
						"m_fDRate": 0.0,
						"m_fARate": 1.9,
						"m_fHBase": 1.95,
						"m_fDBase": 0.0,
						"m_fABase": 1.85,
						"m_strHLine": "-2.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "2.5 (0-0)",
						"m_strBLine": "-2.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 5,
						"m_strMarket": "홀짝",
						"m_nHBetCode": 17100687557059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 3681746047059807,
						"m_fHRate": 1.95,
						"m_fDRate": 0.0,
						"m_fARate": 1.9,
						"m_fHBase": 1.95,
						"m_fDBase": 0.0,
						"m_fABase": 1.9,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "Odd",
						"m_strDName": null,
						"m_strAName": "Even",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559026897059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 101.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 101.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "4-4",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559025877059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 41.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 51.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "7-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559026197059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 23.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 29.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "6-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559027227059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 19.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 19.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559026847059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 41.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 51.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "4-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559027547059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 41.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 41.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559026217059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 41.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 51.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "6-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559025897059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 101.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 101.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "7-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559030797059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 81.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 151.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "8-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559027217059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 41.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 41.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559027197059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 11.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 10.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559027167059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 81.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 101.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-4",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559027867059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 21.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 15.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559027477059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 101.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 101.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-4",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559027537059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 21.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 19.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559027207059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 11.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 10.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559026547059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 15.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 19.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "5-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559027517059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 13.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 10.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559028187059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 51.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 41.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559030497059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 101.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 151.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "9-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559026867059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 12.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 13.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "4-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559026857059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 12.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 12.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "4-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559026207059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 23.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 34.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "6-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559030507059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 101.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 151.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "9-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559026587059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 126.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 101.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "5-4",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559026517059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 51.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 51.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "5-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559027527059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 13.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 11.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559025887059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 41.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 51.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "7-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559030817059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 51.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 81.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "8-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559028177059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 34.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 34.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559027837059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 51.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 51.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559030827059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 51.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 81.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "8-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559025907059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 51.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 81.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "7-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559026227059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 67.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 101.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "6-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559026837059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 21.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 23.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "4-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559027847059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 34.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 29.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559026527059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 26.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 34.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "5-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559026537059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 15.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 21.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "5-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559028157059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 67.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 51.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 18559027857059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 21.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 15.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 7,
						"m_strMarket": "더블찬스",
						"m_nHBetCode": 14967438027059807,
						"m_nDBetCode": 8581884407059807,
						"m_nABetCode": 8581860497059807,
						"m_fHRate": 1.02,
						"m_fDRate": 1.05,
						"m_fARate": 5.0,
						"m_fHBase": 1.03,
						"m_fDBase": 1.1,
						"m_fABase": 4.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1X",
						"m_strDName": "12",
						"m_strAName": "X2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 19565614757059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 11.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 13.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 16742364737059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 13.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 11.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 11554034317059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 51.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 67.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 3904775347059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 5.5,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 5.5,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 16944394497059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 4.5,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 4.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 15532769487059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 34.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 41.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 4899968787059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 101.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 126.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "4-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 5316400357059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 29.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 34.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 20358778437059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 41.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 51.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "5-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 11756064077059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 101.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 126.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 10344439067059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 81.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 101.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 1081525327059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 7.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 5.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 10546468827059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 41.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 41.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 5114370597059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 101.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 101.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 1283555087059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 9.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 8.5,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 6930055127059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 67.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 101.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "5-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 4106805107059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 21.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 26.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 19767644517059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 9.5,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 11.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 9551275387059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 81.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 151.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "6-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 20560808197059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 41.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 41.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "4-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 6728025367059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 21.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 26.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "4-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 21,
						"m_strMarket": "언더오버 [1 피리어드]",
						"m_nHBetCode": 5703753267059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 3071112007059807,
						"m_fHRate": 1.31,
						"m_fDRate": 0.0,
						"m_fARate": 3.14,
						"m_fHBase": 1.41,
						"m_fDBase": 0.0,
						"m_fABase": 2.69,
						"m_strHLine": "1.5",
						"m_strDLine": null,
						"m_strALine": "1.5",
						"m_strBLine": "1.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 41,
						"m_strMarket": "승무패 [1 피리어드]",
						"m_nHBetCode": 13077503337059807,
						"m_nDBetCode": 13077504047059807,
						"m_nABetCode": 13077503307059807,
						"m_fHRate": 1.44,
						"m_fDRate": 3.6,
						"m_fARate": 7.5,
						"m_fHBase": 1.53,
						"m_fDBase": 3.1,
						"m_fABase": 7.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1",
						"m_strDName": "X",
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 42,
						"m_strMarket": "승무패 [2 피리어드]",
						"m_nHBetCode": 6276490267059807,
						"m_nDBetCode": 11048389117059807,
						"m_nABetCode": 10309335537059807,
						"m_fHRate": 1.28,
						"m_fDRate": 4.75,
						"m_fARate": 8.8,
						"m_fHBase": 1.39,
						"m_fDBase": 4.2,
						"m_fABase": 6.75,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1",
						"m_strDName": "X",
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 52,
						"m_strMarket": "승패",
						"m_nHBetCode": 19099609007059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 19817218697059807,
						"m_fHRate": 1.05,
						"m_fDRate": 0.0,
						"m_fARate": 8.5,
						"m_fHBase": 1.07,
						"m_fDBase": 0.0,
						"m_fABase": 7.5,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 65,
						"m_strMarket": "핸디캡 [2 피리어드]",
						"m_nHBetCode": 18426553427059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 19533252807059807,
						"m_fHRate": 1.93,
						"m_fDRate": 0.0,
						"m_fARate": 1.78,
						"m_fHBase": 2.19,
						"m_fDBase": 0.0,
						"m_fABase": 1.6,
						"m_strHLine": "-1.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "1.5 (0-0)",
						"m_strBLine": "-1.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 72,
						"m_strMarket": "홀짝 [1 피리어드]",
						"m_nHBetCode": 16984204407059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 6290994137059807,
						"m_fHRate": 1.91,
						"m_fDRate": 0.0,
						"m_fARate": 1.91,
						"m_fHBase": 2.0,
						"m_fDBase": 0.0,
						"m_fABase": 1.8,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "Odd",
						"m_strDName": null,
						"m_strAName": "Even",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 73,
						"m_strMarket": "홀짝 [2 피리어드]",
						"m_nHBetCode": 9189115807059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 8383375577059807,
						"m_fHRate": 1.83,
						"m_fDRate": 0.0,
						"m_fARate": 1.83,
						"m_fHBase": 1.83,
						"m_fDBase": 0.0,
						"m_fABase": 1.83,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "Odd",
						"m_strDName": null,
						"m_strAName": "Even",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 101,
						"m_strMarket": "언더오버 <홈팀>",
						"m_nHBetCode": 7465511097059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 779785137059807,
						"m_fHRate": 1.55,
						"m_fDRate": 0.0,
						"m_fARate": 2.29,
						"m_fHBase": 1.38,
						"m_fDBase": 0.0,
						"m_fABase": 2.8,
						"m_strHLine": "4.0",
						"m_strDLine": null,
						"m_strALine": "4.0",
						"m_strBLine": "4.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 101,
						"m_strMarket": "언더오버 <홈팀>",
						"m_nHBetCode": 7273182947059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 12427226387059807,
						"m_fHRate": 1.47,
						"m_fDRate": 0.0,
						"m_fARate": 2.49,
						"m_fHBase": 1.41,
						"m_fDBase": 0.0,
						"m_fABase": 2.69,
						"m_strHLine": "3.0",
						"m_strDLine": null,
						"m_strALine": "3.0",
						"m_strBLine": "3.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 101,
						"m_strMarket": "언더오버 <홈팀>",
						"m_nHBetCode": 7465513997059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 12205749517059807,
						"m_fHRate": 1.88,
						"m_fDRate": 0.0,
						"m_fARate": 1.82,
						"m_fHBase": 1.68,
						"m_fDBase": 0.0,
						"m_fABase": 2.06,
						"m_strHLine": "3.5",
						"m_strDLine": null,
						"m_strALine": "3.5",
						"m_strBLine": "3.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 102,
						"m_strMarket": "언더오버 <원정팀>",
						"m_nHBetCode": 5703753217059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 4524036877059807,
						"m_fHRate": 1.66,
						"m_fDRate": 0.0,
						"m_fARate": 2.09,
						"m_fHBase": 1.92,
						"m_fDBase": 0.0,
						"m_fABase": 1.79,
						"m_strHLine": "1.0",
						"m_strDLine": null,
						"m_strALine": "1.0",
						"m_strBLine": "1.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 456,
						"m_strMarket": "더블찬스 [1 피리어드]",
						"m_nHBetCode": 10610088017059807,
						"m_nDBetCode": 10610088757059807,
						"m_nABetCode": 17657880567059807,
						"m_fHRate": 1.1,
						"m_fDRate": 1.28,
						"m_fARate": 2.62,
						"m_fHBase": 1.1,
						"m_fDBase": 1.36,
						"m_fABase": 2.38,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1X",
						"m_strDName": "12",
						"m_strAName": "X2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 457,
						"m_strMarket": "더블찬스 [2 피리어드]",
						"m_nHBetCode": 10407249067059807,
						"m_nDBetCode": 19234292847059807,
						"m_nABetCode": 19234273897059807,
						"m_fHRate": 1.01,
						"m_fDRate": 1.12,
						"m_fARate": 3.1,
						"m_fHBase": 1.05,
						"m_fDBase": 1.15,
						"m_fABase": 2.6,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1X",
						"m_strDName": "12",
						"m_strAName": "X2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 835,
						"m_strMarket": "Asian Under/Over",
						"m_nHBetCode": 14270468907059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 21474566547059807,
						"m_fHRate": 1.95,
						"m_fDRate": 0.0,
						"m_fARate": 1.85,
						"m_fHBase": 1.85,
						"m_fDBase": 0.0,
						"m_fABase": 1.95,
						"m_strHLine": "4.5",
						"m_strDLine": null,
						"m_strALine": "4.5",
						"m_strBLine": "4.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 836,
						"m_strMarket": "Asian Under/Over 1st Period",
						"m_nHBetCode": 19392977087059807,
						"m_nDBetCode": 0,
						"m_nABetCode": 11997585347059807,
						"m_fHRate": 1.8,
						"m_fDRate": 0.0,
						"m_fARate": 2.0,
						"m_fHBase": 1.8,
						"m_fDBase": 0.0,
						"m_fABase": 2.0,
						"m_strHLine": "2.0",
						"m_strDLine": null,
						"m_strALine": "2.0",
						"m_strBLine": "2.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					}
				],
				"m_lstSportsCnt": [
					{
						"m_nSports": 6046,
						"m_strName": "축구",
						"m_nCount": 4,
						"m_lstCountryCnt": [
							{
								"m_nCountry": 203,
								"m_strName": "아르헨티나",
								"m_strImg": "/upload/league/203.png",
								"m_nCount": 3,
								"m_lstLeagueCnt": [
									{
										"m_nLeague": 13483,
										"m_strName": "Torneo Federal A",
										"m_strImg": "/upload/league/203.png",
										"m_nCount": 2
									},
									{
										"m_nLeague": 1926,
										"m_strName": "Primera C Metropolitana",
										"m_strImg": "/upload/league/203.png",
										"m_nCount": 1
									}
								]
							},
							{
								"m_nCountry": 248,
								"m_strName": "세계",
								"m_strImg": "/upload/league/248.png",
								"m_nCount": 1,
								"m_lstLeagueCnt": [
									{
										"m_nLeague": 14493,
										"m_strName": "클럽 친선 경기",
										"m_strImg": "/upload/league/248.jpg",
										"m_nCount": 1
									}
								]
							}
						]
					},
					{
						"m_nSports": 35232,
						"m_strName": "아이스 하키",
						"m_nCount": 0,
						"m_lstCountryCnt": []
					},
					{
						"m_nSports": 48242,
						"m_strName": "농구",
						"m_nCount": 0,
						"m_lstCountryCnt": []
					},
					{
						"m_nSports": 154830,
						"m_strName": "배구",
						"m_nCount": 0,
						"m_lstCountryCnt": []
					},
					{
						"m_nSports": 154914,
						"m_strName": "야구",
						"m_nCount": 0,
						"m_lstCountryCnt": []
					}
				]
			},
			{
				"m_nGame": 403,
				"m_nFixtureID": 7059781,
				"m_nSports": 6046,
				"m_strSportName": "축구",
				"m_nLeague": 1926,
				"m_strLeagueName": "Primera C Metropolitana",
				"m_strLeagueImg": "/upload/league/203.png",
				"m_strHomeTeam": "Ituzaingó",
				"m_strAwayTeam": "CA Central Cordoba de Rosario",
				"m_strDate": "2021-06-09",
				"m_strHour": "03",
				"m_strMin": "00",
				"m_nStatus": 1,
				"m_strPeriod": "",
				"m_nHomeScore": 0,
				"m_nAwayScore": 0,
				"m_nGroup": 2,
				"m_lstDetail": [
					{
						"m_nMarket": 1,
						"m_strMarket": "승무패",
						"m_nHBetCode": 18581026067059781,
						"m_nDBetCode": 16228317717059781,
						"m_nABetCode": 2920186657059781,
						"m_fHRate": 2.12,
						"m_fDRate": 2.88,
						"m_fARate": 3.72,
						"m_fHBase": 2.2,
						"m_fDBase": 2.97,
						"m_fABase": 3.38,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1",
						"m_strDName": "X",
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 2,
						"m_strMarket": "언더오버",
						"m_nHBetCode": 10489356677059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 9667290237059781,
						"m_fHRate": 2.19,
						"m_fDRate": 0.0,
						"m_fARate": 1.68,
						"m_fHBase": 2.38,
						"m_fDBase": 0.0,
						"m_fABase": 1.58,
						"m_strHLine": "1.5",
						"m_strDLine": null,
						"m_strALine": "1.5",
						"m_strBLine": "1.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 5,
						"m_strMarket": "홀짝",
						"m_nHBetCode": 11223537467059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 17442173577059781,
						"m_fHRate": 2.0,
						"m_fDRate": 0.0,
						"m_fARate": 1.85,
						"m_fHBase": 2.0,
						"m_fDBase": 0.0,
						"m_fABase": 1.85,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "Odd",
						"m_strDName": null,
						"m_strAName": "Even",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 14870315397059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 81.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 67.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-4",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 14870315687059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 17.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 15.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 14870315667059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 5.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 5.5,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 14870315677059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 8.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 7.5,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 14870316317059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 51.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 51.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 14870316307059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 26.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 23.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 14870316327059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 8.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 8.5,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 14870316017059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 17.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 17.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 14870315997059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 51.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 41.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 14870316007059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 23.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 26.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 14870316997059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 51.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 51.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "4-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 14870315347059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 7.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 7.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 14870316337059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 12.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 12.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 14870316987059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 34.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 41.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "4-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 14870316677059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 67.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 67.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "5-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 14870315707059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 81.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 67.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-4",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 14870315697059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 41.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 34.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 14870315377059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 17.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 15.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 14870315367059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 41.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 34.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 14870315357059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 5.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 5.5,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 7,
						"m_strMarket": "더블찬스",
						"m_nHBetCode": 15248910547059781,
						"m_nDBetCode": 15248911127059781,
						"m_nABetCode": 2283524057059781,
						"m_fHRate": 1.23,
						"m_fDRate": 1.36,
						"m_fARate": 1.63,
						"m_fHBase": 1.27,
						"m_fDBase": 1.34,
						"m_fABase": 1.59,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1X",
						"m_strDName": "12",
						"m_strAName": "X2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 13846308337059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 21.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 19.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 3428185857059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 81.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 81.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "4-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 12232929977059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 81.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 81.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 2218314197059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 2.1,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 2.1,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 2016560847059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 41.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 41.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 13644554987059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 4.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 4.33,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 604935837059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 12.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 12.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 13442525227059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 6.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 5.5,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 16265775247059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 41.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 41.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 1814531087059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 51.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 51.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 16467805007059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 34.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 41.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 806965597059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 81.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 81.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 2016284437059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 13.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 12.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 41,
						"m_strMarket": "승무패 [1 피리어드]",
						"m_nHBetCode": 16989837257059781,
						"m_nDBetCode": 16684549927059781,
						"m_nABetCode": 12956991987059781,
						"m_fHRate": 2.92,
						"m_fDRate": 1.8,
						"m_fARate": 4.85,
						"m_fHBase": 2.95,
						"m_fDBase": 1.86,
						"m_fABase": 4.4,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1",
						"m_strDName": "X",
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 52,
						"m_strMarket": "승패",
						"m_nHBetCode": 16965450297059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 20998295567059781,
						"m_fHRate": 1.44,
						"m_fDRate": 0.0,
						"m_fARate": 2.62,
						"m_fHBase": 1.53,
						"m_fDBase": 0.0,
						"m_fABase": 2.38,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 64,
						"m_strMarket": "핸디캡 [1 피리어드]",
						"m_nHBetCode": 17404438857059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 3982813757059781,
						"m_fHRate": 2.85,
						"m_fDRate": 0.0,
						"m_fARate": 1.4,
						"m_fHBase": 2.85,
						"m_fDBase": 0.0,
						"m_fABase": 1.4,
						"m_strHLine": "-0.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "0.5 (0-0)",
						"m_strBLine": "-0.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 64,
						"m_strMarket": "핸디캡 [1 피리어드]",
						"m_nHBetCode": 4397864327059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 17015220007059781,
						"m_fHRate": 1.19,
						"m_fDRate": 0.0,
						"m_fARate": 4.5,
						"m_fHBase": 1.19,
						"m_fDBase": 0.0,
						"m_fABase": 4.5,
						"m_strHLine": "0.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "-0.5 (0-0)",
						"m_strBLine": "0.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 72,
						"m_strMarket": "홀짝 [1 피리어드]",
						"m_nHBetCode": 469311457059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 13978086207059781,
						"m_fHRate": 2.38,
						"m_fDRate": 0.0,
						"m_fARate": 1.57,
						"m_fHBase": 2.38,
						"m_fDBase": 0.0,
						"m_fABase": 1.57,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "Odd",
						"m_strDName": null,
						"m_strAName": "Even",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 73,
						"m_strMarket": "홀짝 [2 피리어드]",
						"m_nHBetCode": 706936217059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 10838825247059781,
						"m_fHRate": 2.1,
						"m_fDRate": 0.0,
						"m_fARate": 1.67,
						"m_fHBase": 2.1,
						"m_fDBase": 0.0,
						"m_fABase": 1.67,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "Odd",
						"m_strDName": null,
						"m_strAName": "Even",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 456,
						"m_strMarket": "더블찬스 [1 피리어드]",
						"m_nHBetCode": 5796305557059781,
						"m_nDBetCode": 6535359137059781,
						"m_nABetCode": 6535379367059781,
						"m_fHRate": 1.11,
						"m_fDRate": 1.83,
						"m_fARate": 1.32,
						"m_fHBase": 1.14,
						"m_fDBase": 1.77,
						"m_fABase": 1.31,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1X",
						"m_strDName": "12",
						"m_strAName": "X2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 835,
						"m_strMarket": "Asian Under/Over",
						"m_nHBetCode": 19713471427059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 2028158147059781,
						"m_fHRate": 1.42,
						"m_fDRate": 0.0,
						"m_fARate": 2.75,
						"m_fHBase": 1.42,
						"m_fDBase": 0.0,
						"m_fABase": 2.75,
						"m_strHLine": "1.0",
						"m_strDLine": null,
						"m_strALine": "1.0",
						"m_strBLine": "1.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 835,
						"m_strMarket": "Asian Under/Over",
						"m_nHBetCode": 7092546467059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 18626587207059781,
						"m_fHRate": 1.65,
						"m_fDRate": 0.0,
						"m_fARate": 2.2,
						"m_fHBase": 1.65,
						"m_fDBase": 0.0,
						"m_fABase": 2.2,
						"m_strHLine": "2.0",
						"m_strDLine": null,
						"m_strALine": "2.0",
						"m_strBLine": "2.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 835,
						"m_strMarket": "Asian Under/Over",
						"m_nHBetCode": 12803167987059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 18626586927059781,
						"m_fHRate": 1.13,
						"m_fDRate": 0.0,
						"m_fARate": 5.9,
						"m_fHBase": 1.13,
						"m_fDBase": 0.0,
						"m_fABase": 5.9,
						"m_strHLine": "3.5",
						"m_strDLine": null,
						"m_strALine": "3.5",
						"m_strBLine": "3.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 835,
						"m_strMarket": "Asian Under/Over",
						"m_nHBetCode": 14687695337059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 18626587257059781,
						"m_fHRate": 1.4,
						"m_fDRate": 0.0,
						"m_fARate": 2.85,
						"m_fHBase": 1.4,
						"m_fDBase": 0.0,
						"m_fABase": 2.85,
						"m_strHLine": "2.5",
						"m_strDLine": null,
						"m_strALine": "2.5",
						"m_strBLine": "2.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 835,
						"m_strMarket": "Asian Under/Over",
						"m_nHBetCode": 8770322717059781,
						"m_nDBetCode": 0,
						"m_nABetCode": 18626586897059781,
						"m_fHRate": 1.17,
						"m_fDRate": 0.0,
						"m_fARate": 5.0,
						"m_fHBase": 1.17,
						"m_fDBase": 0.0,
						"m_fABase": 5.0,
						"m_strHLine": "3.0",
						"m_strDLine": null,
						"m_strALine": "3.0",
						"m_strBLine": "3.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					}
				],
				"m_lstSportsCnt": null
			},
			{
				"m_nGame": 384,
				"m_nFixtureID": 7059861,
				"m_nSports": 6046,
				"m_strSportName": "축구",
				"m_nLeague": 13483,
				"m_strLeagueName": "Torneo Federal A",
				"m_strLeagueImg": "/upload/league/203.png",
				"m_strHomeTeam": "Club Sportivo Peñarol",
				"m_strAwayTeam": "Sansinena",
				"m_strDate": "2021-06-09",
				"m_strHour": "03",
				"m_strMin": "00",
				"m_nStatus": 1,
				"m_strPeriod": "",
				"m_nHomeScore": 0,
				"m_nAwayScore": 0,
				"m_nGroup": 3,
				"m_lstDetail": [
					{
						"m_nMarket": 1,
						"m_strMarket": "승무패",
						"m_nHBetCode": 19641266437059861,
						"m_nDBetCode": 10365980647059861,
						"m_nABetCode": 19275561267059861,
						"m_fHRate": 2.3,
						"m_fDRate": 3.04,
						"m_fARate": 3.1,
						"m_fHBase": 2.52,
						"m_fDBase": 2.89,
						"m_fABase": 2.9,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1",
						"m_strDName": "X",
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 2,
						"m_strMarket": "언더오버",
						"m_nHBetCode": 3880740947059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 10533616007059861,
						"m_fHRate": 2.59,
						"m_fDRate": 0.0,
						"m_fARate": 1.5,
						"m_fHBase": 2.34,
						"m_fDBase": 0.0,
						"m_fABase": 1.6,
						"m_strHLine": "1.5",
						"m_strDLine": null,
						"m_strALine": "1.5",
						"m_strBLine": "1.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 5,
						"m_strMarket": "홀짝",
						"m_nHBetCode": 19447902057059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 21213325207059861,
						"m_fHRate": 2.0,
						"m_fDRate": 0.0,
						"m_fARate": 1.85,
						"m_fHBase": 2.0,
						"m_fDBase": 0.0,
						"m_fABase": 1.85,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "Odd",
						"m_strDName": null,
						"m_strAName": "Even",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 13845878127059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 15.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 15.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 13845878137059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 34.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 34.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 13845877797059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 51.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 51.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-4",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 13845877837059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 5.5,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 5.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 13845878157059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 6.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 6.5,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 13845877187059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 51.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 51.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 13845877497059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 23.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 29.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 13845877827059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 8.5,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 7.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 13845876507059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 51.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 51.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "4-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 13845876497059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 81.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 67.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "4-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 13845877817059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 15.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 12.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 13845877177059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 10.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 11.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 13845877487059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 21.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 23.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 13845877167059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 12.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 13.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 13845877197059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 19.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 23.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 13845878147059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 6.5,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 6.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 13845877507059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 41.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 51.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 13845876827059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 81.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 67.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "5-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 13845877807059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 29.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 26.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 13845876517059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 41.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 41.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "4-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 13845878107059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 67.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 67.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-4",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 13845877517059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 67.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 81.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 7,
						"m_strMarket": "더블찬스",
						"m_nHBetCode": 6164459077059861,
						"m_nDBetCode": 6164458497059861,
						"m_nABetCode": 1939916707059861,
						"m_fHRate": 1.31,
						"m_fDRate": 1.32,
						"m_fARate": 1.54,
						"m_fHBase": 1.35,
						"m_fDBase": 1.35,
						"m_fABase": 1.45,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1X",
						"m_strDName": "12",
						"m_strAName": "X2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 21286770087059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 81.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 81.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 9658775947059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 13.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 15.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 4792468227059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 17.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 17.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 8825313497059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 5.5,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 5.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 9027343257059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 4.5,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 4.75,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 6204093237059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 41.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 41.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 20453307637059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 51.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 51.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 9456746187059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 81.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 81.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 20655337397059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 41.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 41.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 6633496167059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 11.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 12.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 6835525927059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 2.2,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 2.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 6002063477059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 34.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 41.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 41,
						"m_strMarket": "승무패 [1 피리어드]",
						"m_nHBetCode": 7966761747059861,
						"m_nDBetCode": 8433131257059861,
						"m_nABetCode": 7694077677059861,
						"m_fHRate": 3.02,
						"m_fDRate": 1.92,
						"m_fARate": 3.96,
						"m_fHBase": 3.32,
						"m_fDBase": 1.84,
						"m_fABase": 3.84,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1",
						"m_strDName": "X",
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 52,
						"m_strMarket": "승패",
						"m_nHBetCode": 17815827487059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 2154988077059861,
						"m_fHRate": 1.62,
						"m_fDRate": 0.0,
						"m_fARate": 2.2,
						"m_fHBase": 1.73,
						"m_fDBase": 0.0,
						"m_fABase": 2.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 64,
						"m_strMarket": "핸디캡 [1 피리어드]",
						"m_nHBetCode": 14397982197059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 15956512177059861,
						"m_fHRate": 1.23,
						"m_fDRate": 0.0,
						"m_fARate": 4.0,
						"m_fHBase": 1.23,
						"m_fDBase": 0.0,
						"m_fABase": 4.0,
						"m_strHLine": "0.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "-0.5 (0-0)",
						"m_strBLine": "0.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 64,
						"m_strMarket": "핸디캡 [1 피리어드]",
						"m_nHBetCode": 16345731027059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 13982931627059861,
						"m_fHRate": 3.3,
						"m_fDRate": 0.0,
						"m_fARate": 1.32,
						"m_fHBase": 3.3,
						"m_fDBase": 0.0,
						"m_fABase": 1.32,
						"m_strHLine": "-0.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "0.5 (0-0)",
						"m_strBLine": "-0.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 72,
						"m_strMarket": "홀짝 [1 피리어드]",
						"m_nHBetCode": 5795053567059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 2239473417059861,
						"m_fHRate": 2.38,
						"m_fDRate": 0.0,
						"m_fARate": 1.57,
						"m_fHBase": 2.38,
						"m_fDBase": 0.0,
						"m_fABase": 1.57,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "Odd",
						"m_strDName": null,
						"m_strAName": "Even",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 73,
						"m_strMarket": "홀짝 [2 피리어드]",
						"m_nHBetCode": 16693781327059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 10474759197059861,
						"m_fHRate": 2.1,
						"m_fDRate": 0.0,
						"m_fARate": 1.67,
						"m_fHBase": 2.1,
						"m_fDBase": 0.0,
						"m_fABase": 1.67,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "Odd",
						"m_strDName": null,
						"m_strAName": "Even",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 456,
						"m_strMarket": "더블찬스 [1 피리어드]",
						"m_nHBetCode": 5159656907059861,
						"m_nDBetCode": 18467787967059861,
						"m_nABetCode": 18467770297059861,
						"m_fHRate": 1.17,
						"m_fDRate": 1.72,
						"m_fARate": 1.3,
						"m_fHBase": 1.18,
						"m_fDBase": 1.79,
						"m_fABase": 1.25,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1X",
						"m_strDName": "12",
						"m_strAName": "X2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 835,
						"m_strMarket": "Asian Under/Over",
						"m_nHBetCode": 18413771597059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 9820936597059861,
						"m_fHRate": 1.48,
						"m_fDRate": 0.0,
						"m_fARate": 2.6,
						"m_fHBase": 1.48,
						"m_fDBase": 0.0,
						"m_fABase": 2.6,
						"m_strHLine": "1.0",
						"m_strDLine": null,
						"m_strALine": "1.0",
						"m_strBLine": "1.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 835,
						"m_strMarket": "Asian Under/Over",
						"m_nHBetCode": 17581369837059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 14374640637059861,
						"m_fHRate": 1.82,
						"m_fDRate": 0.0,
						"m_fARate": 1.98,
						"m_fHBase": 1.92,
						"m_fDBase": 0.0,
						"m_fABase": 1.88,
						"m_strHLine": "2.0",
						"m_strDLine": null,
						"m_strALine": "2.0",
						"m_strBLine": "2.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 835,
						"m_strMarket": "Asian Under/Over",
						"m_nHBetCode": 1910285097059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 14374640357059861,
						"m_fHRate": 1.18,
						"m_fDRate": 0.0,
						"m_fARate": 4.8,
						"m_fHBase": 1.18,
						"m_fDBase": 0.0,
						"m_fABase": 4.8,
						"m_strHLine": "3.5",
						"m_strDLine": null,
						"m_strALine": "3.5",
						"m_strBLine": "3.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 835,
						"m_strMarket": "Asian Under/Over",
						"m_nHBetCode": 9505433967059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 14374640327059861,
						"m_fHRate": 1.23,
						"m_fDRate": 0.0,
						"m_fARate": 4.0,
						"m_fHBase": 1.23,
						"m_fDBase": 0.0,
						"m_fABase": 4.0,
						"m_strHLine": "3.0",
						"m_strDLine": null,
						"m_strALine": "3.0",
						"m_strBLine": "3.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 835,
						"m_strMarket": "Asian Under/Over",
						"m_nHBetCode": 13548524567059861,
						"m_nDBetCode": 0,
						"m_nABetCode": 14374640687059861,
						"m_fHRate": 1.48,
						"m_fDRate": 0.0,
						"m_fARate": 2.6,
						"m_fHBase": 1.48,
						"m_fDBase": 0.0,
						"m_fABase": 2.6,
						"m_strHLine": "2.5",
						"m_strDLine": null,
						"m_strALine": "2.5",
						"m_strBLine": "2.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					}
				],
				"m_lstSportsCnt": null
			},
			{
				"m_nGame": 390,
				"m_nFixtureID": 7059811,
				"m_nSports": 6046,
				"m_strSportName": "축구",
				"m_nLeague": 13483,
				"m_strLeagueName": "Torneo Federal A",
				"m_strLeagueImg": "/upload/league/203.png",
				"m_strHomeTeam": "Crucero del Norte",
				"m_strAwayTeam": "Unión de Sunchales",
				"m_strDate": "2021-06-09",
				"m_strHour": "03",
				"m_strMin": "00",
				"m_nStatus": 1,
				"m_strPeriod": "",
				"m_nHomeScore": 0,
				"m_nAwayScore": 0,
				"m_nGroup": 3,
				"m_lstDetail": [
					{
						"m_nMarket": 1,
						"m_strMarket": "승무패",
						"m_nHBetCode": 18799177147059811,
						"m_nDBetCode": 16446468797059811,
						"m_nABetCode": 20117650557059811,
						"m_fHRate": 1.8,
						"m_fDRate": 3.18,
						"m_fARate": 4.6,
						"m_fHBase": 2.51,
						"m_fDBase": 2.93,
						"m_fABase": 2.88,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1",
						"m_strDName": "X",
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 2,
						"m_strMarket": "언더오버",
						"m_nHBetCode": 19048551397059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 18017818277059811,
						"m_fHRate": 2.45,
						"m_fDRate": 0.0,
						"m_fARate": 1.55,
						"m_fHBase": 2.4,
						"m_fDBase": 0.0,
						"m_fABase": 1.57,
						"m_strHLine": "1.5",
						"m_strDLine": null,
						"m_strALine": "1.5",
						"m_strBLine": "1.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 5,
						"m_strMarket": "홀짝",
						"m_nHBetCode": 4500347387059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 16853611377059811,
						"m_fHRate": 2.0,
						"m_fDRate": 0.0,
						"m_fARate": 1.85,
						"m_fHBase": 2.0,
						"m_fDBase": 0.0,
						"m_fABase": 1.85,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "Odd",
						"m_strDName": null,
						"m_strAName": "Even",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 20338941027059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 5.5,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 5.5,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 20338942367059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 81.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 81.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "4-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 20338942347059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 26.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 41.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "4-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 20338942037059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 51.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 81.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "5-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 20338940707059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 7.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 6.5,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 20338940737059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 21.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 15.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 20338941357059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 41.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 41.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 20338941687059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 7.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 10.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 20338941667059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 23.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 23.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 20338941377059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 13.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 21.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 20338941047059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 21.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 12.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 20338942357059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 41.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 51.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "4-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 20338942027059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 81.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 81.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "5-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 20338941037059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 10.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 7.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 20338941347059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 81.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 81.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 20338941057059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 41.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 26.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 20338940727059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 41.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 34.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 20338941367059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 21.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 29.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 20338941677059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 51.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 51.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 20338941697059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 11.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 13.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 6,
						"m_strMarket": "정확한스코어",
						"m_nHBetCode": 20338940717059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 5.5,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 6.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 7,
						"m_strMarket": "더블찬스",
						"m_nHBetCode": 12794945987059811,
						"m_nDBetCode": 12794946567059811,
						"m_nABetCode": 170440517059811,
						"m_fHRate": 1.15,
						"m_fDRate": 1.3,
						"m_fARate": 1.89,
						"m_fHBase": 1.36,
						"m_fDBase": 1.35,
						"m_fABase": 1.46,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1X",
						"m_strDName": "12",
						"m_strAName": "X2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 19948175507059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 3.75,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 4.5,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 1666115837059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 26.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 17.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 17124925487059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 29.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 41.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 5698961107059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 7.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 5.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 12785128337059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 9.5,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 15.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 9961878317059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 2.2,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 2.1,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 17326955247059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 67.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 51.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "0-3",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 1464086077059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 81.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 81.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "3-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 4287336097059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 12.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 12.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 2875711087059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 34.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 41.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-1",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 11373503327059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 41.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 41.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 18536550497059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 81.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 81.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "2-2",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 9,
						"m_strMarket": "정확한스코어 [1 피리어드]",
						"m_nHBetCode": 15608378357059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 0,
						"m_fHRate": 67.0,
						"m_fDRate": 0.0,
						"m_fARate": 0.0,
						"m_fHBase": 81.0,
						"m_fDBase": 0.0,
						"m_fABase": 0.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "4-0",
						"m_strDName": null,
						"m_strAName": null,
						"m_nStatus": 1
					},
					{
						"m_nMarket": 41,
						"m_strMarket": "승무패 [1 피리어드]",
						"m_nHBetCode": 19949686377059811,
						"m_nDBetCode": 13724700807059811,
						"m_nABetCode": 7339147187059811,
						"m_fHRate": 2.49,
						"m_fDRate": 1.91,
						"m_fARate": 5.55,
						"m_fHBase": 3.3,
						"m_fDBase": 1.86,
						"m_fABase": 3.8,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1",
						"m_strDName": "X",
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 52,
						"m_strMarket": "승패",
						"m_nHBetCode": 2502580137059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 13158259287059811,
						"m_fHRate": 1.3,
						"m_fDRate": 0.0,
						"m_fARate": 3.4,
						"m_fHBase": 1.73,
						"m_fDBase": 0.0,
						"m_fABase": 2.0,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 64,
						"m_strMarket": "핸디캡 [1 피리어드]",
						"m_nHBetCode": 4681366327059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 3000080527059811,
						"m_fHRate": 1.15,
						"m_fDRate": 0.0,
						"m_fARate": 5.5,
						"m_fHBase": 1.14,
						"m_fDBase": 0.0,
						"m_fABase": 5.75,
						"m_strHLine": "0.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "-0.5 (0-0)",
						"m_strBLine": "0.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 64,
						"m_strMarket": "핸디캡 [1 피리어드]",
						"m_nHBetCode": 3389299377059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 5096416897059811,
						"m_fHRate": 2.5,
						"m_fDRate": 0.0,
						"m_fARate": 1.5,
						"m_fHBase": 2.5,
						"m_fDBase": 0.0,
						"m_fABase": 1.5,
						"m_strHLine": "-0.5 (0-0)",
						"m_strDLine": null,
						"m_strALine": "0.5 (0-0)",
						"m_strBLine": "-0.5 (0-0)",
						"m_strHName": "1",
						"m_strDName": null,
						"m_strAName": "2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 72,
						"m_strMarket": "홀짝 [1 피리어드]",
						"m_nHBetCode": 244496457059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 20715136607059811,
						"m_fHRate": 2.3,
						"m_fDRate": 0.0,
						"m_fARate": 1.62,
						"m_fHBase": 2.38,
						"m_fDBase": 0.0,
						"m_fABase": 1.57,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "Odd",
						"m_strDName": null,
						"m_strAName": "Even",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 73,
						"m_strMarket": "홀짝 [2 피리어드]",
						"m_nHBetCode": 6172488397059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 11228153727059811,
						"m_fHRate": 2.1,
						"m_fDRate": 0.0,
						"m_fARate": 1.67,
						"m_fHBase": 2.1,
						"m_fDBase": 0.0,
						"m_fABase": 1.67,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "Odd",
						"m_strDName": null,
						"m_strAName": "Even",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 456,
						"m_strMarket": "더블찬스 [1 피리어드]",
						"m_nHBetCode": 20437848297059811,
						"m_nDBetCode": 5110037059811,
						"m_nABetCode": 5092367059811,
						"m_fHRate": 1.08,
						"m_fDRate": 1.73,
						"m_fARate": 1.43,
						"m_fHBase": 1.19,
						"m_fDBase": 1.77,
						"m_fABase": 1.25,
						"m_strHLine": null,
						"m_strDLine": null,
						"m_strALine": null,
						"m_strBLine": null,
						"m_strHName": "1X",
						"m_strDName": "12",
						"m_strAName": "X2",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 835,
						"m_strMarket": "Asian Under/Over",
						"m_nHBetCode": 5707056077059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 19023678677059811,
						"m_fHRate": 1.23,
						"m_fDRate": 0.0,
						"m_fARate": 4.0,
						"m_fHBase": 1.22,
						"m_fDBase": 0.0,
						"m_fABase": 4.15,
						"m_strHLine": "3.0",
						"m_strDLine": null,
						"m_strALine": "3.0",
						"m_strBLine": "3.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 835,
						"m_strMarket": "Asian Under/Over",
						"m_nHBetCode": 13302204947059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 19023678647059811,
						"m_fHRate": 1.18,
						"m_fDRate": 0.0,
						"m_fARate": 4.8,
						"m_fHBase": 1.17,
						"m_fDBase": 0.0,
						"m_fABase": 5.0,
						"m_strHLine": "3.5",
						"m_strDLine": null,
						"m_strALine": "3.5",
						"m_strBLine": "3.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 835,
						"m_strMarket": "Asian Under/Over",
						"m_nHBetCode": 14188658377059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 19023678317059811,
						"m_fHRate": 1.48,
						"m_fDRate": 0.0,
						"m_fARate": 2.6,
						"m_fHBase": 1.45,
						"m_fDBase": 0.0,
						"m_fABase": 2.68,
						"m_strHLine": "2.5",
						"m_strDLine": null,
						"m_strALine": "2.5",
						"m_strBLine": "2.5",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 835,
						"m_strMarket": "Asian Under/Over",
						"m_nHBetCode": 7817627627059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 15619597547059811,
						"m_fHRate": 1.52,
						"m_fDRate": 0.0,
						"m_fARate": 2.42,
						"m_fHBase": 1.48,
						"m_fDBase": 0.0,
						"m_fABase": 2.6,
						"m_strHLine": "1.0",
						"m_strDLine": null,
						"m_strALine": "1.0",
						"m_strBLine": "1.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					},
					{
						"m_nMarket": 835,
						"m_strMarket": "Asian Under/Over",
						"m_nHBetCode": 10155813107059811,
						"m_nDBetCode": 0,
						"m_nABetCode": 19023678367059811,
						"m_fHRate": 1.82,
						"m_fDRate": 0.0,
						"m_fARate": 1.98,
						"m_fHBase": 1.82,
						"m_fDBase": 0.0,
						"m_fABase": 1.98,
						"m_strHLine": "2.0",
						"m_strDLine": null,
						"m_strALine": "2.0",
						"m_strBLine": "2.0",
						"m_strHName": "Under",
						"m_strDName": null,
						"m_strAName": "Over",
						"m_nStatus": 1
					}
				],
				"m_lstSportsCnt": null
			}
		]';
		echo $gameList;
	}

	function getLiveGameListAction() {
		$gameListModel = $this->getModel("GameListModel");

		$page_index = empty($this->request('page_index')) ? 0 : $this->request('page_index');
		$sport_type = empty($this->request('sport_type')) ? "" : $this->request('sport_type');
		$league_sn = empty($this->request('league_sn')) ? 0 : $this->request('league_sn');
		$today = empty($this->request('today')) ? 0 : $this->request('today');

		date_default_timezone_set("Asia/Seoul");
		
		$where = "";
		switch($sport_type) {
			case "soccer": 
				$where .= " AND tb_child.sport_name = '축구'";
				break;
			case "baseball": 
				$where .= " AND tb_child.sport_name = '야구'";
				break;
			case "basketball": 
				$where .= " AND tb_child.sport_name = '농구'";
				break;
			case "volleyball": 
				$where .= " AND tb_child.sport_name = '배구'";
				break;
			case "hockey": 
				$where .= " AND (tb_child.sport_name like '%하키%')";
				break;
			case "tennis":
				$where .= " AND tb_child.sport_name = '테니스'";
				break;
			case "esports": 
				$where .= " AND tb_child.sport_name = 'E스포츠'";
				break;
			case "handball": 
				$where .= " AND tb_child.sport_name = '핸드볼'";
				break;
			case "mortor": 
				$where .= " AND tb_child.sport_name = '모토'";
				break;
			case "rugby": 
				$where .= " AND tb_child.sport_name = '럭비'";
				break;
			case "criket": 
				$where .= " AND tb_child.sport_name = '크리켓'";
				break;
			case "darts": 
				$where .= " AND tb_child.sport_name = '다트'";
				break;
			case "futsal": 
				$where .= " AND tb_child.sport_name = '풋살'";
				break;
			case "badminton": 
				$where .= " AND tb_child.sport_name = '배드민턴'";
				break;
			case "tabletennis": 
				$where .= " AND tb_child.sport_name = '탁구'";
				break;
			case "etc": 
				$where .= " AND (tb_child.sport_name = '' OR tb_child.sport_name = '미분류') ";
			break;
		}

		if($league_sn != 0) {
			$where .= " AND tb_child.league_sn = " . $league_sn;
		}

		$sql = "SELECT
					tb_live.*,
					tb_periods.period_desc_ko AS `period`
				FROM
					(SELECT
						tb_subchild.*,
						tb_child.`gameDate`,
						tb_child.`gameHour`,
						tb_child.`gameTime`,
						tb_child.`home_team`,
						tb_child.away_team,
						tb_child.`sport_id`,
						tb_child.sport_name,
						tb_child.notice,
						tb_child.`league_sn`,
						tb_child.league_img,
						tb_child.game_sn,
						tb_child.game_period,
						IFNULL(tb_child.home_score, 0) AS home_score,
						IFNULL(tb_child.away_score, 0) AS away_score,
						temp_markets.mid,
						temp_markets.mname_ko,
						temp_markets.mfamily
						FROM
						tb_subchild
						LEFT JOIN tb_child
							ON tb_subchild.child_sn = tb_child.sn
						LEFT JOIN
							(SELECT
								`mid`,
								`mname_ko`,
								`muse`,
								`morder`,
								`mfamily`
							FROM
								tb_markets
							WHERE muse = 1
								AND morder > 0) temp_markets
								ON tb_subchild.betting_type = temp_markets.mid
						WHERE tb_child.sn IN
							(SELECT
								child_sn
							FROM
								(SELECT
								tb_child.sn AS child_sn
								FROM
								tb_child
								WHERE tb_child.special < 4
								AND tb_child.status = 2
								AND tb_child.user_view_flag = 1
								AND tb_child.live = 1
								AND tb_child.sport_name != '이벤트'
								ORDER BY tb_child.`gameDate`,
								tb_child.`gameHour`,
								tb_child.`gameTime`) tbl)
							AND tb_subchild.live = 1
						ORDER BY tb_child.`gameDate`,
								tb_child.`gameHour`,
								tb_child.`gameTime`,
								tb_child.notice,
								tb_child.home_team,
								temp_markets.morder,
								tb_subchild.home_line,
								tb_subchild.home_name) AS tb_live
					LEFT JOIN 	tb_periods
							ON tb_live.game_period = tb_periods.period_sn
							AND tb_live.sport_id = tb_periods.sport_sn";
		
		$gameList = $gameListModel->_excuteQuery($sql);
		echo json_encode($gameList);
	}

	//-> 다기준 경기목록 얻어오기
	function getMultiGameListAction() {
		$gameListModel = $this->getModel("GameListModel");

		$page_index = empty($this->request('page_index')) ? 0 : $this->request('page_index');
		$sport_type = empty($this->request('sport_type')) ? "" : $this->request('sport_type');
		$where = "";
		switch($sport_type) {
			case "soccer": 
				$where.= " and a.sport_name = '축구'";
				break;
			case "baseball": 
				$where.= " and a.sport_name = '야구'";
				break;
			case "basketball": 
				$where.= " and a.sport_name = '농구'";
				break;
			case "volleyball": 
				$where.= " and a.sport_name = '배구'";
				break;
			case "hockey": 
				$where.= " and (a.sport_name like '%하키%')";
				break;
			case "tennis":
				$where.= " and a.sport_name = '테니스'";
				break;
			case "esports": 
				$where.= " and a.sport_name = 'E스포츠'";
				break;
			case "handball": 
				$where.= " and a.sport_name = '핸드볼'";
				break;
			case "mortor": 
				$where.= " and a.sport_name = '모토'";
				break;
			case "rugby": 
				$where.= " and a.sport_name = '럭비'";
				break;
			case "criket": 
				$where.= " and a.sport_name = '크리켓'";
				break;
			case "darts": 
				$where.= " and a.sport_name = '다트'";
				break;
			case "futsal": 
				$where.= " and a.sport_name = '풋살'";
				break;
			case "badminton": 
				$where.= " and a.sport_name = '배드민턴'";
				break;
			case "tabletennis": 
				$where.= " and a.sport_name = '탁구'";
				break;
			case "etc": 
				$where.= " and (a.sport_name = '' or a.sport_name = '미분류') ";
			break;
		}

		$where .= " and CONCAT(a.gameDate, ' ', a.gameHour, ':', a.gameTime, ':00') > '".date("Y-m-d H:i:s", time() + 1800)."'";

		$gameMultiList = $gameListModel->getMultiGameList($where, 50, $page_index);

		echo json_encode($gameMultiList);
	}

	//-> 다기준 한경기에 대한 정보 얻어오기
	function getMultiGameItemAction() {
		$gameListModel = $this->getModel("GameListModel");

		$orderby = " a.gameDate ASC, a.gameHour ASC, a.gameTime ASC, a.home_team, c.betting_type, c.home_line ASC ";

		$limit = " LIMIT 1 ";

		$gameMultiItems = $gameListModel->gameMultiItem($orderby);

		echo json_encode($gameMultiItems);
	}


	//-> 매 경기에 있는 다기준 항목들 얻어오기.
	function getMultiGameItemsAction() {
		$gameListModel = $this->getModel("GameListModel");

		$child_sn = $this->request("child_sn");
		$betting_type = $this->request("betting_type");
		$live = empty($this->request("live")) ? 0 : $this->request("live");

		$gameMultiItems = $gameListModel->getMultiGameItem($child_sn, $betting_type, $live);

		echo json_encode($gameMultiItems);
	}

	//-> 매 경기에 있는 다기준 항목의 개수 얻어오기.
	function getChildrenCountAction() {
		$gameListModel = $this->getModel("GameListModel");

		$child_sn = $this->request("child_sn");

		$where = " and a.sn = " . $child_sn;

		$orderby = " a.gameDate asc, a.gameHour asc, a.gameTime asc, a.home_team, c.betting_type, c.point asc ";

		$count = $gameListModel->getChildrenCount($where);

		echo $count;
	}

	//-> 매 경기에 있는 다기준 항목의 Home rate, Draw rate, Away rate 얻어 오기.
	function fillChildInfoAction() {
		$gameListModel = $this->getModel("GameListModel");

		$page_index = empty($this->request('page_index')) ? 0 : $this->request('page_index');

		$where = " and CONCAT(a.gameDate, ' ', a.gameHour, ':', a.gameTime, ':00') > '".date("Y-m-d H:i:s", time() + 1800)."'";

		$gameMultiList = $gameListModel->getMultiGameDetailList($where, 50, $page_index);

		echo json_encode($gameMultiList);
	}

	//-> 매 경기에 있는 home_rate, away_rate, draw_rate, count 얻어 오기.
	function getSubChildInfoAction() {
		$gameListModel = $this->getModel("GameListModel");

		$child_sn = $this->request("child_sn");

		$subchild_info = $gameListModel->getSubChildInfo($child_sn);

		echo json_encode($subchild_info);
	}

	//-> 다기준의 Bonus 항목들 가져 오기 (페이지로딩).
	function getMultiBonusListAction() {
		$gameListModel = $this->getModel("GameListModel");

		$bonus_list = $gameListModel->getMultiBonusList();

		echo json_encode($bonus_list);
	}

	//-> 다기준의 Bonus 항목들 가져 오기 (Ajax).
	function getMultiBonusListAjaxAction() {
		$gameListModel = $this->getModel("GameListModel");

		$bonus_list = $gameListModel->getMultiBonusListAjax();

		echo json_encode($bonus_list);
	}

	function getTodayGameInfoAction() {
		$gameListModel = $this->getModel("GameListModel");
		$nations = $gameListModel->getTodayNations();
		$todayGameInfo = [];
		for($i = 0; $i < count($nations); $i++) {
			$todayGameInfo[$i]['nation_sn'] = html_entity_decode($nations[$i]["sn"]);
			$todayGameInfo[$i]['nation_name'] = html_entity_decode($nations[$i]["name"]);
			$todayGameInfo[$i]['nation_cnt'] = $nations[$i]["cnt"];
			$todayGameInfo[$i]['nation_img'] = html_entity_decode($nations[$i]["lg_img"]);
			$todayGameInfo[$i]['sport_name'] = html_entity_decode($nations[$i]["sport_name"]);
			$todayGameInfo[$i]['items'] = $gameListModel->getTodayLeagues($nations[$i]["sn"], $nations[$i]["sport_name"]);
		}
		echo json_encode($todayGameInfo);
	}

	function getMiniGameResultAction() {
		date_default_timezone_set("Asia/Seoul");

		$sn = $this->auth->getSn();
		$betting_list = [];
		if($sn != "") {
			$gameListModel = $this->getModel("GameListModel");
			$special_type = empty($this->request("special_type")) ? 0 : $this->request("special_type");
			$today = date("Y-m-d");
			$betting_list = $gameListModel->getMinigameResult($this->auth->getSn(), $special_type, $today);
		}
		echo json_encode((array)$betting_list);
	}
}
?>
