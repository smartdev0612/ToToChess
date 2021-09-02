<?
/*
* Index Controller
*/
class ApiController extends WebServiceController 
{
	var $commentListNum = 10;
	
	function layoutDefine($type='')
	{
		//-> 중복로그인 체크 전체 페이지 적용
		// if ( $this->auth->getSn() > 0 ) {
		// 	$mModel = $this->getModel("MemberModel");
		// 	$dbSessionId = $mModel->getMemberField($this->auth->getSn(), 'sessionid');
		// 	if($dbSessionId!=session_id()) {
		// 		if($this->auth->isLogin()) {
		// 			session_destroy();
		// 		}
		// 		throw new Lemon_ScriptException("중복접속 되었습니다. 다시 로그인 해 주세요.", "", "go", "/");
		// 		exit;
		// 	}
		// }

		// if($type=='type')
		// {
		// 	$this->view->define("index","layout/layout.type.index.html");
		// 	$this->view->define(array("header"=>"header/header.html", "footer" => "footer/bottom.html", "top" => "header/top.html", "right" => "right/right.html"));
		// }
		// else 
		if($type=='maintain')
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
		// if($dbSessionId!=session_id())
		// {
		// 	if($this->auth->isLogin())
		// 	{
		// 		session_destroy();
		// 	}
		// 	throw new Lemon_ScriptException("중복접속 되었습니다. 다시 로그인 해 주세요.", "", "go", "/");
		// 	exit;
		// }

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
	
	
	//▶ 승무패,핸디캡,스페셜 배팅
	public function game_listAction() {		
		$gameListModel = $this->getModel("GameListModel");
		$loginModel = $this->getModel("LoginModel");
		$leagueModel = $this->getModel("LeagueModel");
		$etcModel = $this->getModel("EtcModel");
		$configModel = $this->getModel("ConfigModel");
		
		$game = $this->request('game');
		$sport = $this->request('sport');
		$user_id = empty($this->request('userid')) ? "" : $this->request('userid');
		$league_sn = empty($this->request('league_sn')) ? 0 : $this->request('league_sn');
		$today = empty($this->request('today')) ? 0 : $this->request('today');
		$perpage = empty($this->request('perpage')) ? 100 : $this->request('perpage');
		$page_index = empty($this->request('page_index')) ? 0 : $this->request('page_index');
        $title = "";
		$crossLimitCnt = 0;

		if ( !$this->auth->isLogin() ) {
			$loginModel->api_loginMember($user_id);
			
			$this->auth = Lemon_Instance::getObject("Lemon_Auth");
			$this->auth->rSession = $_SESSION;
		}
		
		if ( $game == "multi" ) {
			$specialType = "1";
            $title = "<span class=\"board_mini_title\">국내형</span>";
			$crossLimitCnt = $configModel->getCrossLimitCount(1);
			$this->commonDefine('winlose');
			$this->view->define(array("content"=>"content/game_list.html"));
			$this->displayRight("multi");
		} else if ( $game == "handi" ) {
			$specialType = "0";
            $title = "";
			$this->commonDefine('winlose');
			$this->view->define(array("content"=>"content/game_list.html"));
			$this->displayRight("multi");
		} else if ( $game == "special" ) {
			$specialType = "1";
            $title = "Special<span class=\"board_mini_title\">스페셜</span>";
			$this->commonDefine('special');
			$this->view->define(array("content"=>"content/game_list.html"));
			$this->displayRight("special");
		} else if ( $game == "abroad" ) {
			$specialType = "2";
            $title = "Abroad<span class=\"board_mini_title\">해외형</span>";
			$crossLimitCnt = $configModel->getCrossLimitCount(2);
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
			$crossLimitCnt = $configModel->getCrossLimitCount(3);
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
		
		
		$filterLeagues = $this->request('league_keyword_panel');

		//-> 스포츠일 경우. (미니게임은 패스) + 가상축구
		if ( $specialType < 5 || $specialType == "22" || $specialType == "50") {
			
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
			// $named_security_flag = $etcModel->namedSecurityState();
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
		// $this->view->assign("named_security_flag", $named_security_flag);
		$this->view->assign("betting_list", $betting_list);
		//$this->view->assign("power_result_list", $power_result_list);
		//$this->view->assign('sadari_result', $sadari_result);
		$this->view->assign('popup_list', $popupList);
		//$this->view->assign("game_list", $gameList);
		$this->view->assign("bonus_list", $bonus_list);
		$this->view->assign("crossLimitCnt", $crossLimitCnt);
		//$this->view->assign("title_image", $titleImage);
		$this->view->assign("special_type", $specialType);
		$this->view->assign("game_type", $game);
		$this->view->assign("sport_type", $sport);							//축구, 농구, 배구 등등
		$this->view->assign("mini_odds", $miniodds_info);
		$this->view->assign("mini_config", $miniconfig_info);
		$this->view->assign("sport_setting", $sport_setting);
		$this->view->assign("league_sn", $league_sn);
		$this->view->assign("today", $today);
        $this->view->assign("api", "true");
		$this->view->assign("uid", $user_id);

		$this->display();
	}

	public function betting_listAction()
	{
		$user_id = empty($this->request('userid')) ? "" : $this->request('userid');

		$loginModel = $this->getModel("LoginModel");

		if ( !$this->auth->isLogin() ) {
			$loginModel->api_loginMember($user_id);
			
			$this->auth = Lemon_Instance::getObject("Lemon_Auth");
			$this->auth->rSession = $_SESSION;
		}
		
		$this->commonDefine('type');
		
		if($this->isMobile() == "pc") {
			$this->view->define(array("content"=>"content/betting_list.html"));
		} else {
			$this->view->define(array("content"=>"content/betting_list_m.html"));
		}

		$specialCode = trim($this->req->request("special_code"));
		$game = trim($this->req->request("game"));
		$beginDate = trim($this->req->request("begin_date"));
		$endDate = trim($this->req->request("end_date"));
		$sortType = $this->req->request("sort_type");
		$type = empty($this->req->request("type")) ? 1 : $this->req->request("type");
		
		if ( !$beginDate ) $beginDate = date("Y-m-d",time());
		if ( !$endDate ) $endDate = date("Y-m-d",time());
	
		$mModel = Lemon_Instance::getObject("MemberModel",true);
		$gameListModel = Lemon_Instance::getObject("GameListModel",true);
		$cModel = Lemon_Instance::getObject("CartModel",true);
		$sn = $this->auth->getSn();

		// 유저의 배팅취소개수 초기화
		$mModel->clearBetCancelCnt($sn);

		if ( !$specialCode ) $specialCode = "all";
		//if($s_type != 0) $specialCode = $s_type;
		//if ( $game == "sadari" ) $specialCode = 3;
		//else if ( $game == "race" ) $specialCode = 4;
		//else if ( $game == "powerball" ) $specialCode = 5;

		switch( $sortType ) {
			case 0: 	$total= $gameListModel->getBettingListTotal($sn, -1,  0, $queryBeginDate, $queryEndDate, $specialCode); $state = -1; 	break; // 전체 배팅내역
			case 1: 	$total= $gameListModel->getBettingListTotal($sn,  0,  0, $queryBeginDate, $queryEndDate, $specialCode); $state = 0;		break; // 게임진행중 배팅내역
			case 2: 	$total= $gameListModel->getBettingListTotal($sn,  1,  0, $queryBeginDate, $queryEndDate, $specialCode); $state = 1; 	break; // 게임완료 배팅내역	
			case 10:	$total= $gameListModel->getBettingListTotal($sn,  10, 0, $queryBeginDate, $queryEndDate, $specialCode); $state = 10; 	break; // 당첨 배팅내역
			case 11:	$total= $gameListModel->getBettingListTotal($sn,  11, 0, $queryBeginDate, $queryEndDate, $specialCode); $state = 11; 	break; // 낙첨 배팅내역
		}

		$page_act = "game=".$game."&begin_date=".$beginDate."&end_date=".$endDate."&sort_type=".$sortType;
		
		$pageMaker = $this->displayPage($total, 20, $page_act);

		//$list = $gameListModel->getBettingList($sn, $pageMaker->first, $pageMaker->listNum, $chk_folder, $state, $queryBeginDate, $queryEndDate, $specialCode, 1);
		$list = $gameListModel->getUserBettingList($sn, $type, 0, 20);
		$listTotal = $gameListModel->getUserBettingListTotal($sn, $type);
		
		$this->view->assign("game", $game);
		$this->view->assign("begin_date", $beginDate);
		$this->view->assign("end_date", $endDate);
		$this->view->assign("sort_type", $sortType);
		$this->view->assign("specialCode", $specialCode);
		$this->view->assign("type", $type);
		$this->view->assign("list", $list);
		$this->view->assign("listTotal", $listTotal);
		$this->view->assign("api", "true");
		$this->view->assign("uid", $user_id);
		
		$this->display();
	}

	public function betCancelProcessAction() {
		$user_id = empty($this->request('userid')) ? "" : $this->request('userid');

		$loginModel = $this->getModel("LoginModel");

		if ( !$this->auth->isLogin() ) {
			$loginModel->api_loginMember($user_id);
			
			$this->auth = Lemon_Instance::getObject("Lemon_Auth");
			$this->auth->rSession = $_SESSION;
		}

		$bettingNo 	= empty($this->request('betting_no')) ? 0 : $this->request('betting_no');
		$res = $this->checkbettingCancel($bettingNo);
		if($res["status"] > 0) {
			echo $res["msg"];
		} else {
			$uid = $this->auth->getId();
			$pModel  = $this->getModel("ProcessModel");
			$pModel->bettingCancelProcess($bettingNo, $uid);
			echo "배팅이 취소되였습니다.";
		}
		
	}

	
	public function checkbettingCancel($bettingNo) 
	{
		$configModel = $this->getModel("ConfigModel");
		$gameModel = $this->getModel("GameModel");

		$config = $configModel->getAdminConfig();
		$cancelAfterTime = $config["bettingcanceltime"];
		$cancelBeforeTime = $config["bettingcancelbeforetime"];
		$cancelCnt = $config["bettingcancelcnt"];

		$game_info = $gameModel->getGameByBettingNo($bettingNo);
		$gameStartTime = strtotime($game_info[0]["gameDate"] . " " . $game_info[0]["gameHour"] . ":" . $game_info[0]["gameTime"] . ":00");
		$bettingTime = strtotime($game_info[0]["regdate"]);
		$nowTime = time();
		$special = $game_info[0]["last_special_code"];
		$live = $game_info[0]["live"];

		$sn = $this->auth->getSn();
		$todayCancelCnt = $gameModel->getTodayBettingCancelCnt($sn);

		$existResult = $gameModel->existBettingResult($bettingNo);
		
		$res["status"] = 0;
		$res["msg"] = "";

		if($live == 1) {
			$res["status"] = 4; 
			$res["msg"] = "라이브배팅은 취소가 불가능합니다.";
			return $res;
		}
		
		if($todayCancelCnt >= $cancelCnt) {
			$res["status"] = 3; 
			$res["msg"] = "배팅취소는 하루 {$cancelCnt}번만 가능합니다.";
			//$res["msg"] = "미안하지만 하루 배팅취소회수를 초과하였습니다.";
			return $res;
		}
		
		if($special < 5) {
			if(($nowTime - $bettingTime) > $cancelAfterTime * 60) {
				$res["status"] = 1; 
				$res["msg"] = "배팅후 {$cancelAfterTime}분이내에만 취소가 가능합니다.";
				return $res;
			} 
			
			if (($gameStartTime - $nowTime) < $cancelBeforeTime * 60) {
				$res["status"] = 2; 
				$res["msg"] = "경기시작 {$cancelBeforeTime}분전까지만 취소가 가능합니다.";
				return $res;
			}
		}

		if($existResult > 0) {
			$res["status"] = 5; 
			$res["msg"] = "결과처리된 배팅은 취소가 불가능합니다.";
			return $res;
		}

		return $res;

	}

	//▶ 내역삭제
	public function betlisthideProcessAction()
	{
		$user_id = empty($this->request('userid')) ? "" : $this->request('userid');

		$loginModel = $this->getModel("LoginModel");
		
		if ( !$this->auth->isLogin() ) {
			$loginModel->api_loginMember($user_id);
			
			$this->auth = Lemon_Instance::getObject("Lemon_Auth");
			$this->auth->rSession = $_SESSION;
		}
		
		$sn = $this->auth->getSn();
		$bettingNo 	= Trim($this->request('betting_no'));
		
		if(empty($bettingNo) || $bettingNo=='' || !$this->req->isNumberParameter($bettingNo))
		{
			echo "잘못된 인자입니다";
			exit;
		}
		
		$cartModel 	= $this->getModel("CartModel");
		$rs = $cartModel->modifyViewState($sn, $bettingNo);
		if($rs > 0)
			echo "배팅내역이 삭제되었습니다.";
		else {
			$rs = $cartModel->modifyCancelViewState($sn, $bettingNo);
			if($rs > 0)
				echo "배팅내역이 삭제되었습니다.";
			else 
				echo "배팅내역 삭제에 실패하였습니다.";
		}
			
	}

	public function getBettingListAction() {

		$user_id = empty($this->request('userid')) ? "" : $this->request('userid');

		$loginModel = $this->getModel("LoginModel");
		
		if ( !$this->auth->isLogin() ) {
			$loginModel->api_loginMember($user_id);
			
			$this->auth = Lemon_Instance::getObject("Lemon_Auth");
			$this->auth->rSession = $_SESSION;
		}

		$type = empty($this->req->request("type")) ? 0 : $this->req->request("type");
		$pc = empty($this->req->request("pc")) ? 0 : $this->req->request("pc");
		$page_index = empty($this->req->request("page_index")) ? 0 : $this->req->request("page_index");
		$sn = $this->auth->getSn();
		$gameListModel = Lemon_Instance::getObject("GameListModel",true);
		$list = $gameListModel->getUserBettingList($sn, $type, $page_index, 20);
		$listTotal = $gameListModel->getUserBettingListTotal($sn, $type);

		$table = "";
		if($pc > 0) {
			if(count((array)$list) > 0) {
				foreach($list as $TPL_K1 => $TPL_V1) {
					$table .= '<table class="st10">
								<colgroup>
									<col style="width: 12%;">
									<col style="width: 22%;">
									<col style="width: 19%;">
									<col style="width: 11%;">
									<col style="width: 17%;">
									<col style="width: 6%;">
									<col style="width: 6%;">
									<col>
								</colgroup>
								<thead>
									<tr>
										<th scope="col">경기시간</th>
										<th scope="col">리그명</th>
										<th scope="col">홈팀 VS 원정팀</th>
										<th scope="col">타입</th>
										<th scope="col">베팅팀</th>
										<th scope="col">스코어</th>
										<th scope="col">배당</th>
										<th class="last" scope="col">상태</th>
									</tr>
								</thead>
								<tbody>';
					$enableBettingCancel = 0;  		
					if(count((array)$TPL_V1["item"]) > 0) {
						$battingJT = "0";
						foreach ( $TPL_V1["item"] as $TPL_V2 ) {
							if ( $TPL_V2["home_rate"] < 1.01 and $TPL_V2["draw_rate"] < 1.1 and $TPL_V2["away_rate"] < 1.1  ) {
								$TPL_V2["home_rate"] = $TPL_V2["game_home_rate"];
								$TPL_V2["draw_rate"] = $TPL_V2["game_draw_rate"];
								$TPL_V2["away_rate"] = $TPL_V2["game_away_rate"];
								$battingJT = "1";
							}
							$table .= '<tr data-game_id="1731940" data-fid="6967104" data-mid="1" data-gb_id="25322682" data-betid="20609690316967104">';
							$table .= '<td>' . $TPL_V2["gameDate"] . ' ' . $TPL_V2["gameHour"] . ' : ' . $TPL_V2["gameTime"] . '</td>';
							$table .= '<td class="txt_left st_padl5">';
							$table .= '<img src="/BET38/_icon/sport/S' . $TPL_V2["sport_id"] . '.png" width="23">&nbsp;';
							if($TPL_V2["league_image"] == "")
								$table .= '<img src="/BET38/_icon/etc.svg" width="23">&nbsp;';
							else 
								$table .= '<img src="' . $TPL_V2["league_image"] . '" width="23" >&nbsp;&nbsp;';
							$table .= '<span>' . $TPL_V2["league_name"] . '</span>'; 
							$table .= '</td>';
							$table .= '<td class="txt_left st_padl5">';
							$table .= '<div>';
							$table .= '<span class="txt_co6">홈팀</span> : ' . $TPL_V2["home_team"];
							$table .= '</div>';
							$table .= '<div class="padding-top-5"><span class="txt_co71">원팀</span> : ' . $TPL_V2["away_team"]  . '</td></div>';
							$pieces = explode("|", $TPL_V2["mname_ko"]);
							switch($TPL_V2["sport_id"]) {
								case 6046: // 축구
									$table .= '<td>' . $pieces[0] . '</td>';
									break;
								case 48242: // 농구
									$table .= '<td>' . $pieces[1] . '</td>';
									break;
								case 154914: // 야구
									$table .= '<td>' . $pieces[2] . '</td>';
									break;
								case 154830: // 배구
									$table .= '<td>' . $pieces[3] . '</td>';
									break;
								case 35232: // 아이스 하키
									$table .= '<td>' . $pieces[4] . '</td>';
									break;
								case 687890: // E스포츠
									$table .= '<td>' . $pieces[5] . '</td>';
									break;
								default:
									$table .= '<td>' . $pieces[0] . '</td>';
									break;
							}
							$table .= '<td class="txt_ac st_padl5">';
							switch($TPL_V2["mfamily"]) {
								case "1":
								case "2":
									if($TPL_V2["select_no"] == "1")
										$table .= '<span class="txt_co6">(홈)</span>  ' . $TPL_V2["home_team"];
									else if($TPL_V2["select_no"] == "2") 
										$table .= '<span class="txt_co6">(원)</span>  ' . $TPL_V2["away_team"];                       
									else if($TPL_V2["select_no"] == "3")                        
										$table .= '(무) 무승부'; 
									break;
								case "7":
									if($TPL_V2["select_no"] == "1") {
										$table .= '언더 <span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
									} else if($TPL_V2["select_no"] == "2") {
										$table .= '오버 <span class="txt_co6">(' . $TPL_V2["away_line"] . ')</span>'; 
									}
									break;
								case "8":
									if($TPL_V2["select_no"] == "1") {
										$home_line = explode(" ", $TPL_V2["home_line"]);
										$table .= $TPL_V2["home_team"] . '<span class="txt_co6">(' . $home_line[0] . ')</span>';
									} else if($TPL_V2["select_no"] == "2") {
										$away_line = explode(" ", $TPL_V2["away_line"]);
										$table .= $TPL_V2["away_team"] . '<span class="txt_co6">(' . $away_line[0] . ')</span>'; 
									}
									break;
								case "10":
									if($TPL_V2["select_no"] == "1")
										$table .= '홀수';
									else if($TPL_V2["select_no"] == "2") 
										$table .= '짝수'; 
									break;
								case "11":
									$table .= $TPL_V2["home_name"];
									break;
								case "12":
									if($TPL_V2["select_no"] == "1")
										$table .= '승무';
									else if($TPL_V2["select_no"] == "3") 
										$table .= '무패';                       
									else if($TPL_V2["select_no"] == "2")                        
										$table .= '승패'; 
									break;
								case "47":
									if($TPL_V2["home_name"] == "1 And Under")
										$table .= '홈승 & 언더' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
									else if($TPL_V2["home_name"] == "1 And Over") 
										$table .= '홈승 & 오버' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';                       
									else if($TPL_V2["home_name"] == "2 And Under")                        
										$table .= '원정승 & 언더' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>'; 
									else if($TPL_V2["home_name"] == "2 And Over")
										$table .= '원정승 & 오버' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
									else if($TPL_V2["home_name"] == "X And Under")
										$table .= '무 & 언더' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
									else if($TPL_V2["home_name"] == "X And Over")
										$table .= '무 & 오버' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
									break;
							}
										
							$table .= '</td>';
							if($type == 2) 
								$table .= '<td><span class="txt_co6">' . $TPL_V2["score"] . '</span></td>';
							else 
								$table .= '<td><span class="txt_co6">' . $TPL_V2["home_score"] . ':' . $TPL_V2["away_score"] . '</span></td>';
							$table .= '<td>' . $TPL_V2["select_rate"] . ' 배</td>';
							if($battingJT)
								$table .= '<td rowspan="1"><span class="bt_none5 bt_45_none">적특</span></td>';
							else if($TPL_V2["result"] == "1")
								$table .= '<td rowspan="1"><span class="bt_none6 bt_45_none">당첨</span></td>';
							else if($TPL_V2["result"] == "2")
								$table .= '<td rowspan="1"><span class="bt_none3 bt_45_none">낙첨</span></td>';
							else if($TPL_V2["result"] == "4")
								$table .= '<td rowspan="1"><span class="bt_none5 bt_45_none" style="color:#e44e4e !important;">취소</span></td>';
							else 
								$table .= '<td rowspan="1"><span class="bt_none1 bt_45_none">진행</span></td>';
							$table .= '</tr>';
							$table .= '<tr id="Fid2996007" class="st_hide_list"></tr>'; 
							
							if($TPL_V2["result"] > 0) 
								$enableBettingCancel = 1;
						} 
					}
					
					$table .= '</tbody>
							</table>
							<div class="st_b_result" data-oid="1605133">';
					$table .= '베팅접수시간 : <span class="txt_co3 st_padr10">' . $TPL_V1["bet_date"] . '</span>';
					$table .= '예상당첨금액 : <span class="txt_co3 st_padr10">(베팅 ' . $TPL_V1["betting_money"] . ' x 배당 ' . $TPL_V1["result_rate"] .') = ' . $TPL_V1["win_money"] . '</span>';
					$table .= '결과당첨금액 : <span class="txt_co3 st_padr10">' . $TPL_V1["result_money"] . '</span>';
					if($TPL_V1["result"] == "1") {
						$table .= "<span class='bt_100 bt_gray f_right txt_size st_mart5 st_marl5 pointer' onclick=hide_bet('" . $TPL_K1 . "')>베팅내역삭제</span>";
						$table .= '<span class="bt_45_none bt_none6 f_right st_mart5">당첨</span>';
					} else if($TPL_V1["result"] == "2") {
						$table .= "<span class='bt_100 bt_gray f_right txt_size st_mart5 st_marl5 pointer' onclick=hide_bet('" . $TPL_K1 . "')>베팅내역삭제</span>";
						$table .= '<span class="bt_45_none bt_none3 f_right st_mart5">낙첨</span>';
					} else if($TPL_V1["result"] == "4") {
						$table .= "<span class='bt_100 bt_gray f_right txt_size st_mart5 st_marl5 pointer' onclick=hide_bet('" . $TPL_K1 . "')>베팅내역삭제</span>";
						$table .= '<span class="bt_45_none bt_none5 f_right st_mart5" style="color:#e44e4e !important;">취소</span>';
					} else {
						if($type < 2 && $enableBettingCancel == 0)
							$table .= "<span class='bt_100 bt_gray f_right txt_size st_mart5 st_marl5 pointer' onclick=cancel_bet('" . $TPL_K1 . "')>베팅취소</span>";
						$table .= '<span class="bt_45_none bt_none1 f_right st_mart5">진행</span>';
					}
					$table .= '</td></div>';
				}
			}
		} else {
			foreach($list as $TPL_K1 => $TPL_V1) { 
				$table .= '<table class="st10">
								<colgroup>
									<col style="width:30%">
									<col style="width:30%">
									<col style="width:30%">
									<col style="width:10%">
								</colgroup>
								<thead>
									<tr>
										<th scope="col">리그/시간</th>
										<th scope="col">팀명/베팅항목</th>
										<th scope="col">타입/상태</th>
										<th scope="col" class="last">결과</th>
									</tr>
								</thead>
								<tbody>';

				$enableBettingCancel = 0; 
				if(count((array)$TPL_V1["item"]) > 0) {
					$battingJT = "0";
					foreach ( $TPL_V1["item"] as $TPL_V2 ) {
						if ( $TPL_V2["home_rate"] < 1.01 and $TPL_V2["draw_rate"] < 1.1 and $TPL_V2["away_rate"] < 1.1  ) {
							$TPL_V2["home_rate"] = $TPL_V2["game_home_rate"];
							$TPL_V2["draw_rate"] = $TPL_V2["game_draw_rate"];
							$TPL_V2["away_rate"] = $TPL_V2["game_away_rate"];
							$battingJT = "1";
						}
						$table .= '<tr><td>';
						$table .= '<img src="/BET38/_icon/sport/S' . $TPL_V2["sport_id"] . '.png" width="20">&nbsp;';
						if($TPL_V2["league_image"] == "")
							$table .= '<img src="/BET38/_icon/etc.svg" width="20">&nbsp;';
						else 
							$table .= '<img src="' . $TPL_V2["league_image"] . '" width="20">&nbsp;';
						$table .= $TPL_V2["league_name"];
						$table .= '</td>';
						$table .= '<td class="_left">';
						$table .= '<span class="txt_co6">홈팀</span> : ' . $TPL_V2["home_team"] . '<br>';
						$table .= '<span class="txt_co71">원팀</span> : ' . $TPL_V2["away_team"] . '</td>';			
						$pieces = explode("|", $TPL_V2["mname_ko"]);
						switch($TPL_V2["sport_id"]) {
							case 6046: // 축구
								$table .= '<td>' . $pieces[0] . '</td>';
								break;
							case 48242: // 농구
								$table .= '<td>' . $pieces[1] . '</td>';
								break;
							case 154914: // 야구
								$table .= '<td>' . $pieces[2] . '</td>';
								break;
							case 154830: // 배구
								$table .= '<td>' . $pieces[3] . '</td>';
								break;
							case 35232: // 아이스 하키
								$table .= '<td>' . $pieces[4] . '</td>';
								break;
							case 687890: // E스포츠
								$table .= '<td>' . $pieces[5] . '</td>';
								break;
							default:
								$table .= '<td>' . $pieces[0] . '</td>';
								break;
						}
						$table .= '<td class="td_de" rowspan="2">';
						if($battingJT)
							$table .= '<span class="bt_none5 bt_45_none txt_co23">적특</span>';
						else if($TPL_V2["result"] == "1")
							$table .= '<span class="bt_none6 bt_45_none txt_co23">당첨</span>';
						else if($TPL_V2["result"] == "2")
							$table .= '<span class="bt_none3 bt_45_none txt_co23">낙첨</span>';
						else if($TPL_V2["result"] == "4")
							$table .= '<span class="bt_none5 bt_45_none txt_co23" style="color:#e44e4e !important;">취소</span>';
						else 
							$table .= '<span class="bt_none1 bt_45_none txt_co23">진행</span>';
						$table .= '</td></tr>';
						
						$table .= '<tr>';
						$table .= '<td>' . $TPL_V2["gameDate"] . ' ' . $TPL_V2["gameHour"] . ' : ' . $TPL_V2["gameTime"] . '</td>';
						$table .= '<td class="_left">';		 
						switch($TPL_V2["mfamily"]) {
							case "1":
							case "2":
								if($TPL_V2["select_no"] == "1")
									$table .= '<span class="txt_co6">(홈)</span>  ' . $TPL_V2["home_team"];
								else if($TPL_V2["select_no"] == "2") 
									$table .= '<span class="txt_co6">(원)</span>  ' . $TPL_V2["away_team"];                       
								else if($TPL_V2["select_no"] == "3")                        
									$table .= '(무) 무승부'; 
								break;
							case "7":
								if($TPL_V2["select_no"] == "1") {
									$table .= '언더 <span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
								} else if($TPL_V2["select_no"] == "2") {
									$table .= '오버 <span class="txt_co6">(' . $TPL_V2["away_line"] . ')</span>'; 
								}
								break;
							case "8":
								if($TPL_V2["select_no"] == "1") {
									$home_line = explode(" ", $TPL_V2["home_line"]);
									$table .= $TPL_V2["home_team"] . '<span class="txt_co6">(' . $home_line[0] . ')</span>';
								} else if($TPL_V2["select_no"] == "2") {
									$away_line = explode(" ", $TPL_V2["away_line"]);
									$table .= $TPL_V2["away_team"] . '<span class="txt_co6">(' . $away_line[0] . ')</span>'; 
								}
								break;
							case "10":
								if($TPL_V2["select_no"] == "1")
									$table .= '홀수';
								else if($TPL_V2["select_no"] == "2") 
									$table .= '짝수'; 
								break;
							case "11":
								$table .= $TPL_V2["home_name"];
								break;
							case "12":
								if($TPL_V2["select_no"] == "1")
									$table .= '승무';
								else if($TPL_V2["select_no"] == "3") 
									$table .= '무패';                       
								else if($TPL_V2["select_no"] == "2")                        
									$table .= '승패'; 
								break;
							case "47":
								if($TPL_V2["home_name"] == "1 And Under")
									$table .= '홈승 & 언더' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
								else if($TPL_V2["home_name"] == "1 And Over") 
									$table .= '홈승 & 오버' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';                       
								else if($TPL_V2["home_name"] == "2 And Under")                        
									$table .= '원정승 & 언더' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>'; 
								else if($TPL_V2["home_name"] == "2 And Over")
									$table .= '원정승 & 오버' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
								else if($TPL_V2["home_name"] == "X And Under")
									$table .= '무 & 언더' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
								else if($TPL_V2["home_name"] == "X And Over")
									$table .= '무 & 오버' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
								break;
						}
						$table .= '</td>';
						if($type == 2) 
							$table .= '<td><span class="txt_co6">' . $TPL_V2["score"] . '</span></td>';
						else 
							$table .= '<td><span class="txt_co6">' . $TPL_V2["home_score"] . ':' . $TPL_V2["away_score"] . '</span></td>';
						$table .= '</tr>';
						$table .= '<tr id="Fid3628815" class="st_hide_list"></tr>';

						if($TPL_V2["result"] > 0) 
							$enableBettingCancel = 1;
					}
				}
				$table .= '</tbody>
						</table>
						<div class="betting_cart_btn4 clearfix"><ul>';
				$table .= '<li class="betting_cart_40 betting_cart_bgno">베팅시간 : <span class="txt_co6">' . substr($TPL_V1["bet_date"], 5) . '</span></li>';
				$table .= '<li class="betting_cart_40 betting_cart_bgno">베팅금 : <span class="txt_co6 st_marr15">' . $TPL_V1["betting_money"] . ' 원</span></li>';
				$table .= '<li class="betting_cart_40 betting_cart_bgno">배당률 : <span class="txt_co6">' . $TPL_V1["result_rate"] .'</span></li>';
				$table .= '<li class="betting_cart_40 betting_cart_bgno">예상당첨금 : <span class="txt_co3  st_marr15">' . $TPL_V1["win_money"] . ' 원</span></li>';
				$table .= '<li class="betting_cart_40 betting_cart_bgno">당첨금 : <span class="txt_co3">' . $TPL_V1["result_money"] . ' 원</span></li>';
				$table .= '<li class="betting_cart_40 betting_cart_bgno">상태 : ';

				if($TPL_V1["result"] == "1")
					$table .= '<span class="st_marl5 bt_none6 bt_45_none txt_none3">당첨</span>';
				else if($TPL_V1["result"] == "2")
					$table .= '<span class="st_marl5 bt_none3 bt_45_none txt_none3">낙첨</span>';
				else if($TPL_V1["result"] == "4")
					$table .= '<span class="st_marl5 bt_none5 bt_45_none txt_none3" style="color:#e44e4e !important;">취소</span>';
				else
					$table .= '<span class="st_marl5 bt_none1 bt_45_none txt_none3">진행</span>';
				
				$table .= '</li>';
				$table .= '<li class="betting_cart_20 betting_cart_bgno">';
				if($TPL_V1["result"] > 0)
					$table .= "<span class='st_marl5 bt_none5 bt_45_none txt_none3' onclick=hide_bet('" . $TPL_K1 . "')>내역삭제</span>";
				else {
					if($type < 2 && $enableBettingCancel == 0)
						$table .= "<span class='st_marl5 bt_none5 bt_45_none txt_none3' onclick=cancel_bet('" . $TPL_K1 . "')>배팅취소</span>";
				}
				$table .= '</li></ul>
						</div>';
			}
		}
		echo $table;
	}

	public function getRecentBettingListAction() {
		$user_id = empty($this->request('userid')) ? "" : $this->request('userid');

		$loginModel = $this->getModel("LoginModel");
		
		if ( !$this->auth->isLogin() ) {
			$loginModel->api_loginMember($user_id);
			
			$this->auth = Lemon_Instance::getObject("Lemon_Auth");
			$this->auth->rSession = $_SESSION;
		}

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
							if ( $TPL_V2["select_no"] == 1 ) $select_val = "언더";
							else $select_val = "오버";
						} else if ( $gameCode == "p_p-oe" ) {
							$gameName = "파워볼홀짝";
							if ( $TPL_V2["select_no"] == 1 ) $select_val = "홀";
							else $select_val = "짝";
						} else if ( $gameCode == "p_p-uo" ) {
							$gameName = "파워볼언오";
							if ( $TPL_V2["select_no"] == 1 ) $select_val = "언더";
							else $select_val = "오버";
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
								<td class='th-mini' style=\"font-weight:bold;\">{$gameTh}</td>
								<td class='th-mini' style=\"font-weight:bold;\">{$gameName}</td>
								<td class='th-mini'>{$select_val}</td>
								<td class='th-mini'>{$bettingRate}</td>
								<td class='th-mini'>".number_format($bettingMoney)."</td>
								<td class=\"new_betting_no th-mini\" id='resultMoney_{$bettingNo}'>{$resultMoney}</td>
								<td class='th-mini' id='result_{$bettingNo}'>{$bettingResult}</td>
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
								<td class='th-mini' style=\"font-weight:bold;\">{$gameTh}</td>
								<td class='th-mini' style=\"font-weight:bold;\">{$gameName}</td>
								<td class='th-mini'>{$select_val}</td>
								<td class='th-mini'>{$bettingRate}</td>
								<td class='th-mini'>".number_format($bettingMoney)."</td>
								<td class=\"new_betting_no th-mini\" id='resultMoney_{$bettingNo}'>{$resultMoney}</td>
								<td class='th-mini' id='result_{$bettingNo}'>{$bettingResult}</td>
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

	function getMiniGameResultAction() {
		$user_id = empty($this->request('userid')) ? "" : $this->request('userid');

		$loginModel = $this->getModel("LoginModel");
		
		if ( !$this->auth->isLogin() ) {
			$loginModel->api_loginMember($user_id);
			
			$this->auth = Lemon_Instance::getObject("Lemon_Auth");
			$this->auth->rSession = $_SESSION;
		}

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
