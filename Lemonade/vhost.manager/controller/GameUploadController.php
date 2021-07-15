<?php
	ini_set('memory_limit','-1');
/*
* Index Controller
*/
class GameUploadController extends WebServiceController 
{

	var $commentListNum = 10;
	
	//▶ 인덱스
	public function indexAction()
	{
		$this->gamelistAction();
	}
	
	//▶ 게임목록
	public function gamelistAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/gameUpload/game_list.html");
		
		$gameModel		= $this->getModel("GameModel");
		$cartModel 		= $this->getModel("CartModel");
		$leagueModel 	= $this->getModel("LeagueModel");
		
		$act  				= $this->request("act");
		$state  			= $this->request("state");
		$perpage			= $this->request("perpage");
		$specialType	= $this->request("special_type");
		$categoryName = $this->request("categoryName");
		$gameType 		= $this->request("game_type");
		$moneyOption = $this->request("money_option");
		$beginDate  		= $this->request('begin_date');
		$endDate 				= $this->request('end_date');
		$filterTeam			= $this->request('filter_team');
		$filterTeamType	= $this->request('filter_team_type');
		$parsingType = $this->request("parsing_type");
		$modifyFlag = $this->request("modifyFlag");
		$leagueSn = $this->request("league_sn");

		//-> 경기수정 경기보기
		if ( $modifyFlag == "on" ) $modifyFlag = 0;
		else $modifyFlag = "";
		
		//-> 상단 파싱정보 초기화.
		$etcModel = $this->getModel("EtcModel");
		$etcModel->updateParsingStatus("new_rate");
		$etcModel->updateParsingStatus("new_game");
		
		if($act=="modify_state")
		{
			$childSn = $this->request('child_sn'); //경기인텍스
			$newState= $this->request('new_state');
			if ( $newState != "rateUpdate" ) {
				if($newState == 2)
				{
					$gameModel->blockGame($childSn);
					$newState=-1;  // 블록된 경기를 대기상태로 함.
				}
				$gameModel->modifyChildStaus($childSn,$newState);
			} else {
				$gameModel->modifyChildNewRate($childSn);
			}
		}
		else if($act=="delete_game")
		{
			$childSn = $this->request('child_sn');
			$gameModel->delChild($childSn);
		}
		else if($act=="delete_game_db")
		{
			$childSn = $this->request('child_sn');
			$gameModel->delChildDB($childSn);
		}
		else if($act=='deadline_game')
		{
			$childSn = $this->request('child_sn');
			$gameModel->modifyGameTime($childSn);
		}

		if($parsingType=='') $parsingType = "ALL";
		if($perpage=='') $perpage = 20;	
		if($moneyOption=='') $moneyOption=0;
		
		$minBettingMoney='';
		if($moneyOption==0)		$minBettingMoney='';
		if($moneyOption==1)		$minBettingMoney=1;
		
		if($filterTeam!='')
		{
			if($filterTeamType=='league')
			{
				$rs = $leagueModel->getListByLikeName($filterTeam);
				
				for($i=0; $i<count((array)$rs); ++$i)
				{
					$leagueSn[] = $rs[$i]['sn'];
				}
			}
			else if($filterTeamType=='home_team')
			{
				$homeTeam = Trim($filterTeam);
			}
			else if($filterTeamType=='away_team')
			{
				$awayTeam = Trim($filterTeam);
			}
		}
		if($beginDate=="" || $endDate=="")
		{
			$beginDate 	= date("Y-m-d");
			$endDate		= date("Y-m-d",strtotime ("+1 days"));
		}
		
		$page_act= "parsing_type=".$parsingType."&state=".$state."&game_type=".$gameType."&categoryName=".$categoryName."&special_type=".$specialType."&perpage=".$perpage."&begin_date=".$beginDate."&end_date=".$endDate."&filter_team_type=".$filterTeamType."&filter_team=".$filterTeam."&filter_betting_total=".$filterBettingTotal."&money_option=".$moneyOption."&modifyFlag=".$modifyFlag;
		
		$bettingEnable = "";
		if($state=="20")
		{
			$filterState 		= "2";
			$bettingEnable 	= "1";
		}
		else if($state=="21")
		{
			$filterState = "2";
			$bettingEnable 	= "-1";
		}
		else
		{
			$filterState = $state;
		}

		//-> 시간지난 경기 숨김 처리.
		$gameModel->hideTimeOverGame();
		
		$total_info = $gameModel->getListTotal($filterState, $categoryName, $gameType, $specialType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, $modifyFlag, $leagueSn);
		$total = $total_info["cnt"];
		$leagueList = $total_info["league_list"];
		
		$pageMaker = $this->displayPage($total, $perpage, $page_act);
		$list = $gameModel->getList($pageMaker->first, $pageMaker->listNum, $filterState, $categoryName, $gameType, $specialType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, $modifyFlag, $leagueSn);

		for($i=0; $i<count((array)$list); ++$i)
		{
			$item = $cartModel->getTeamTotalBetMoney($list[$i]['child_sn']);
			
			$list[$i]['home_total_betting'] = $item['home_total_betting'];
			$list[$i]['active_home_total_betting'] = $item['active_home_total_betting'];
			$list[$i]['home_count'] = $item['home_count'];

            $list[$i]['home_team'] = strip_tags(html_entity_decode($list[$i]['home_team']));
            $list[$i]['away_team'] = strip_tags(html_entity_decode($list[$i]['away_team']));
			
			$list[$i]['draw_total_betting'] = $item['draw_total_betting'];
			$list[$i]['active_draw_total_betting'] = $item['active_draw_total_betting'];
			$list[$i]['draw_count'] = $item['draw_count'];
			
			$list[$i]['away_total_betting'] = $item['away_total_betting'];
			$list[$i]['active_away_total_betting'] = $item['active_away_total_betting'];
			$list[$i]['away_count'] = $item['away_count'];
			
			$list[$i]['total_betting'] = $item['home_total_betting']+$item['draw_total_betting']+$item['away_total_betting'];
			$list[$i]['active_total_betting'] = $item['active_home_total_betting']+$item['active_draw_total_betting']+$item['active_away_total_betting'];
			$list[$i]['betting_count'] = $item['home_count']+$item['draw_count']+$item['away_count'];
		}

		$categoryList = $leagueModel->getCategoryList();
		$this->view->assign("league_sn",$leagueSn);
		$this->view->assign("modifyFlag",$modifyFlag);
		$this->view->assign("parsing_type",$parsingType);		
		$this->view->assign("special_type",$specialType);
		$this->view->assign("money_option",$moneyOption);
		$this->view->assign("gameType",$gameType);
		$this->view->assign("categoryName",$categoryName);
		$this->view->assign("categoryList",$categoryList);
		$this->view->assign("search",$search);
		$this->view->assign("state",$state);
		$this->view->assign("list",$list);
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('filter_team', $filterTeam);
		$this->view->assign('filter_team_type', $filterTeamType);
		$this->view->assign("league_list",$leagueList);		
		$this->display();
	}

	//▶ 게임목록
	public function gameMultiListAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/gameUpload/game_list_multi.html");
		
		$gameModel		= $this->getModel("GameModel");
		$cartModel 		= $this->getModel("CartModel");
		$leagueModel 	= $this->getModel("LeagueModel");
		
		$act  				= $this->request("act");
		$state  			= $this->request("state");
		$perpage			= $this->request("perpage");
		$categoryName = $this->request("categoryName");
		$gameType 		= $this->request("game_type");
		$moneyOption = $this->request("money_option");
		$beginDate  		= $this->request('begin_date');
		$endDate 				= $this->request('end_date');
		$filterTeam			= $this->request('filter_team');
		$filterTeamType	= $this->request('filter_team_type');
		$parsingType = $this->request("parsing_type");
		$modifyFlag = $this->request("modifyFlag");
		$leagueSn = $this->request("league_sn");
		
		//-> 경기수정 경기보기
		if ( $modifyFlag == "on" ) $modifyFlag = 0;
		else $modifyFlag = "";

		//-> 상단 파싱정보 초기화.
		$etcModel = $this->getModel("EtcModel");
		$etcModel->updateParsingStatus("new_rate");
		$etcModel->updateParsingStatus("new_game");
		
		if($act=="modify_state")
		{
			$subchildSn = $this->request('sn'); //경기인텍스
			$newState= $this->request('new_state');
			if ( $newState != "rateUpdate" ) {
				if($newState == 2)
				{
					$gameModel->blockGameMulti($subchildSn);
					$newState=-1;  // 블록된 경기를 대기상태로 함.
				}
				$gameModel->modifyChildStausMulti($subchildSn,$newState);
			} else {
				$gameModel->modifyChildNewRateMulti($subchildSn);
			}
		}
		else if($act=="delete_game")
		{
			$subchildSn = $this->request('sn');
			$gameModel->delSubChildMulti($subchildSn);
		}
		else if($act=="delete_game_db")
		{
			$subchildSn = $this->request('sn');
			$gameModel->delSubChildDB($subchildSn);
		}
		else if($act=='deadline_game')
		{
			$subchildSn = $this->request('sn');
			$gameModel->modifyGameTimeMulti($subchildSn);
		}

		if($parsingType=='') $parsingType = "ALL";
		if($perpage=='') $perpage = 300;	
		if($moneyOption=='') $moneyOption=0;
		
		$minBettingMoney='';
		if($moneyOption==0)		$minBettingMoney='';
		if($moneyOption==1)		$minBettingMoney=1;
		
		if($filterTeam!='')
		{
			if($filterTeamType=='league')
			{
				$rs = $leagueModel->getListByLikeName($filterTeam);
				
				for($i=0; $i<count((array)$rs); ++$i)
				{
					$leagueSn[] = $rs[$i]['sn'];
				}
			}
			else if($filterTeamType=='home_team')
			{
				$homeTeam = Trim($filterTeam);
			}
			else if($filterTeamType=='away_team')
			{
				$awayTeam = Trim($filterTeam);
			}
		}
		if($beginDate=="" || $endDate=="")
		{
			$beginDate 	= date("Y-m-d");
			$endDate		= date("Y-m-d",strtotime ("+1 days"));
		}
		
		$page_act= "parsing_type=".$parsingType."&state=".$state."&game_type=".$gameType."&categoryName=".$categoryName."&perpage=".$perpage."&begin_date=".$beginDate."&end_date=".$endDate."&filter_team_type=".$filterTeamType."&filter_team=".$filterTeam."&filter_betting_total=".$filterBettingTotal."&money_option=".$moneyOption."&modifyFlag=".$modifyFlag;
		
		$bettingEnable = "";
		if($state=="20")
		{
			$filterState 		= "2";
			$bettingEnable 	= "1";
		}
		else if($state=="21")
		{
			$filterState = "2";
			$bettingEnable 	= "-1";
		}
		else
		{
			$filterState = $state;
		}

		//-> 시간지난 경기 숨김 처리.
		$gameModel->hideTimeOverGame(2);
		
		$total_info = $gameModel->getMultiListTotal($filterState, $categoryName, $gameType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, $modifyFlag, $leagueSn);
		$total = $total_info["cnt"];
		
		$leagueList = $total_info["league_list"];
		
		$pageMaker = $this->displayPage($total, $perpage, $page_act);
		$list = $gameModel->getMultiList($pageMaker->first, $pageMaker->listNum, $filterState, $categoryName, $gameType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, $modifyFlag, $leagueSn);

		for($i=0; $i<count((array)$list); ++$i)
		{
			$item = $cartModel->getTeamTotalBetMoney($list[$i]['child_sn'], 2);
			
			$list[$i]['home_total_betting'] = $item['home_total_betting'];
			$list[$i]['active_home_total_betting'] = $item['active_home_total_betting'];
			$list[$i]['home_count'] = $item['home_count'];

            $list[$i]['home_team'] = strip_tags(html_entity_decode($list[$i]['home_team']));
            $list[$i]['away_team'] = strip_tags(html_entity_decode($list[$i]['away_team']));
			
			$list[$i]['draw_total_betting'] = $item['draw_total_betting'];
			$list[$i]['active_draw_total_betting'] = $item['active_draw_total_betting'];
			$list[$i]['draw_count'] = $item['draw_count'];
			
			$list[$i]['away_total_betting'] = $item['away_total_betting'];
			$list[$i]['active_away_total_betting'] = $item['active_away_total_betting'];
			$list[$i]['away_count'] = $item['away_count'];
			
			$list[$i]['total_betting'] = $item['home_total_betting']+$item['draw_total_betting']+$item['away_total_betting'];
			$list[$i]['active_total_betting'] = $item['active_home_total_betting']+$item['active_draw_total_betting']+$item['active_away_total_betting'];
			$list[$i]['betting_count'] = $item['home_count']+$item['draw_count']+$item['away_count'];
		}

		$categoryList = $leagueModel->getCategoryList();
		$this->view->assign("league_sn",$leagueSn);
		$this->view->assign("modifyFlag",$modifyFlag);
		$this->view->assign("parsing_type",$parsingType);		
		$this->view->assign("money_option",$moneyOption);
		$this->view->assign("gameType",$gameType);
		$this->view->assign("categoryName",$categoryName);
		$this->view->assign("categoryList",$categoryList);
		$this->view->assign("search",$search);
		$this->view->assign("state",$state);
		$this->view->assign("list",$list);
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('filter_team', $filterTeam);
		$this->view->assign('filter_team_type', $filterTeamType);
		$this->view->assign("league_list",$leagueList);		
		$this->display();
	}

	//▶ 게임목록
	public function liveListAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/gameUpload/live_list.html");
		
		$gameModel		= $this->getModel("GameModel");
		$cartModel 		= $this->getModel("CartModel");
		$leagueModel 	= $this->getModel("LeagueModel");
		
		$act  				= $this->request("act");
		$state  			= 20;
		$perpage			= $this->request("perpage");
		$categoryName = $this->request("categoryName");
		$beginDate  		= $this->request('begin_date');
		$endDate 				= $this->request('end_date');
		$filterTeam			= $this->request('filter_team');
		$filterTeamType	= $this->request('filter_team_type');
		$parsingType = empty($this->request("parsing_type")) ? "ALL" : $this->request("parsing_type");
		$leagueSn = $this->request("league_sn");

		//-> 상단 파싱정보 초기화.
		$etcModel = $this->getModel("EtcModel");
		$etcModel->updateParsingStatus("new_rate");
		$etcModel->updateParsingStatus("new_game");
		
		if($perpage=='') $perpage = 40;	
		
		if($filterTeam!='')
		{
			if($filterTeamType=='league')
			{
				$rs = $leagueModel->getListByLikeName($filterTeam);
				
				for($i=0; $i<count((array)$rs); ++$i)
				{
					$leagueSn[] = $rs[$i]['sn'];
				}
			}
			else if($filterTeamType=='home_team')
			{
				$homeTeam = Trim($filterTeam);
			}
			else if($filterTeamType=='away_team')
			{
				$awayTeam = Trim($filterTeam);
			}
		}
		if($beginDate=="" || $endDate=="")
		{
			$beginDate 	= date("Y-m-d");
			$endDate		= date("Y-m-d",strtotime ("+1 days"));
		}
		
		$page_act= "parsing_type=".$parsingType."&state=".$state."&categoryName=".$categoryName."&perpage=".$perpage."&begin_date=".$beginDate."&end_date=".$endDate."&filter_team_type=".$filterTeamType."&filter_team=".$filterTeam;
		
		$bettingEnable = "";
		if($state=="20")
		{
			$filterState 		= "2";
			$bettingEnable 	= "1";
		}
		else if($state=="21")
		{
			$filterState = "2";
			$bettingEnable 	= "-1";
		}
		else
		{
			$filterState = $state;
		}

		//-> 시간지난 경기 숨김 처리.
		$gameModel->hideTimeOverGame();
		
		$total_info = $gameModel->getFixtureListTotal($filterState, $categoryName, $beginDate, $endDate, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType);
		$total = $total_info["cnt"];
		$leagueList = $total_info["league_list"];
		
		$pageMaker = $this->displayPage($total, $perpage, $page_act);
		$list = $gameModel->getFixtureList($pageMaker->first, $pageMaker->listNum, $filterState, $categoryName, $beginDate, $endDate, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType);

		for($i=0; $i<count((array)$list); ++$i)
		{
			$item = $cartModel->getTeamTotalBetMoney($list[$i]['child_sn']);
			
			$list[$i]['home_total_betting'] = $item['home_total_betting'];
			$list[$i]['active_home_total_betting'] = $item['active_home_total_betting'];
			$list[$i]['home_count'] = $item['home_count'];

            $list[$i]['home_team'] = strip_tags(html_entity_decode($list[$i]['home_team']));
            $list[$i]['away_team'] = strip_tags(html_entity_decode($list[$i]['away_team']));
			
			$list[$i]['draw_total_betting'] = $item['draw_total_betting'];
			$list[$i]['active_draw_total_betting'] = $item['active_draw_total_betting'];
			$list[$i]['draw_count'] = $item['draw_count'];
			
			$list[$i]['away_total_betting'] = $item['away_total_betting'];
			$list[$i]['active_away_total_betting'] = $item['active_away_total_betting'];
			$list[$i]['away_count'] = $item['away_count'];
			
			$list[$i]['total_betting'] = $item['home_total_betting']+$item['draw_total_betting']+$item['away_total_betting'];
			$list[$i]['active_total_betting'] = $item['active_home_total_betting']+$item['active_draw_total_betting']+$item['active_away_total_betting'];
			$list[$i]['betting_count'] = $item['home_count']+$item['draw_count']+$item['away_count'];
		}
		$orderCnt = $gameModel->getLiveOrderCnt();
		$categoryList = $leagueModel->getCategoryList();
		$this->view->assign("league_sn",$leagueSn);
		$this->view->assign("categoryName",$categoryName);
		$this->view->assign("categoryList",$categoryList);
		$this->view->assign("state",$state);
		$this->view->assign("list",$list);
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('filter_team', $filterTeam);
		$this->view->assign('filter_team_type', $filterTeamType);
		$this->view->assign("league_list",$leagueList);		
		$this->view->assign("orderCnt",$orderCnt);		
		$this->display();
	}

	public function refreshBetListAction()
	{
		$page			= $this->request("page");
		$perpage			= $this->request("perpage");
		$state  			= $this->request("state");
		$specialType	= $this->request("search_special_type");
		$categoryName = $this->request("search_categoryName");
		$gameType 		= $this->request("search_game_type");
		$beginDate  		= $this->request('begin_date');
		$endDate 				= $this->request('end_date');
		$filterTeam			= $this->request('filter_team');
		$filterTeamType	= $this->request('filter_team_type');
		$parsingType = $this->request("search_parsing_type");
		$leagueSn = $this->request("search_league_sn");
		$sort = $this->request("sort");

		$gameModel		= $this->getModel("GameModel");
		$cartModel 		= $this->getModel("CartModel");
		$leagueModel 	= $this->getModel("LeagueModel");

		if($parsingType=='') $parsingType = "ALL";
		if($perpage=='') $perpage = 300;

		if($filterTeam!='')
		{
			if($filterTeamType=='league')
			{
				$rs = $leagueModel->getListByLikeName($filterTeam);

				for($i=0; $i<count((array)$rs); ++$i)
				{
					$leagueSn[] = $rs[$i]['sn'];
				}
			}
			else if($filterTeamType=='home_team')
			{
				$homeTeam = Trim($filterTeam);
			}
			else if($filterTeamType=='away_team')
			{
				$awayTeam = Trim($filterTeam);
			}
		}
		if($beginDate=="" || $endDate=="")
		{
			$beginDate 	= date("Y-m-d");
			$endDate		= date("Y-m-d",strtotime ("+1 days"));
		}

		$page_act= "parsing_type=".$parsingType."&state=".$state."&game_type=".$gameType."&categoryName=".$categoryName."&special_type=".$specialType."&perpage=".$perpage."&begin_date=".$beginDate."&end_date=".$endDate."&filter_team_type=".$filterTeamType."&filter_team=".$filterTeam."&filter_betting_total=".$filterBettingTotal."&money_option=".$moneyOption."&modifyFlag=".$modifyFlag."&sort=".$sort;

		$bettingEnable = "";
		if($state=="20")
		{
			$filterState 		= "2";
			$bettingEnable 	= "1";
		}
		else if($state=="21")
		{
			$filterState = "2";
			$bettingEnable 	= "-1";
		}
		else
		{
			$filterState = $state;
		}

		$minBettingMoney='';
		$modifyFlag = '';

		$total_info = $gameModel->getListTotalofLive($filterState, $categoryName, $gameType, $specialType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, $modifyFlag);
		$total = $total_info["cnt"];
		$leagueList = $total_info["league_list"];

		$pageMaker = $this->displayPage($total, $perpage, $page_act);
		$list = $gameModel->getListofLive($pageMaker->first, $pageMaker->listNum, $filterState, $categoryName, $gameType, $specialType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, $modifyFlag, $sort);

		$result_list = array();
		for($i=0; $i<count((array)$list); ++$i)
		{
			$item = $cartModel->getTeamTotalBetMoney($list[$i]['child_sn']);
			$total_betting = $item['home_total_betting']+$item['draw_total_betting']+$item['away_total_betting'];
			if($total_betting > 0)
			{
				$result_list[$list[$i]['child_sn']] = $item;
			}
		}

		if(!isset($result_list))
			$result_list = array();

		$result = array(
			'bet_list'=>$result_list
		);

		echo json_encode($result);
	}

	//▶ 경기결과 입력후 당첨자 현황
	public function popup_win_member_listAction()
	{		
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/gameUpload/popup_win_member_list.html");
		
		$gameListModel 	= $this->getModel("GameListModel");
		$processModel 	= $this->getModel("ProcessModel");
		
		$accountParam		 = $this->request("account_param");
		$gameSnListParam = $this->request("game_sn_list");
	
		if($accountParam!="")
			$accountList = unserialize(urldecode($accountParam));
		if($gameSnListParam!="")
			$gameSnList = unserialize(urldecode($gameSnListParam));
		
		$act			 			= $this->request("act");
		$selectKeyword	= $this->request("select_keyword");
		$keyword				= $this->request("keyword");
		$showDetail 		= $this->request("show_detail");
		$paramPage_act	= $this->request("param_page_act");
		
		if($showDetail=="") $showDetail = 0;
		
		if($keyword!="")
		{
			if($selectKeyword=="uid")							$where.=" and c.uid like('%".$keyword."%') ";
			else if($selectKeyword=="nick")				$where.=" and c.nick like('%".$keyword."%') ";
			else if($selectKeyword=="betting_no")	$where.=" and a.betting_no like('%".$keyword."%') ";
		}
	
		if($act=="account")
		{
			for($i=0; $i<count((array)$gameSnList); ++$i)
			{
				$subchildSn = $gameSnList[$i]["subchild_sn"];
				$game_result = $gameSnList[$i]["game_result"];
				if($subchildSn!="")
				{
					$processModel->resultGameProcess($subchildSn, $game_result);
				}
			}
			
			$script	= "alert('정산되었습니다.');opener.document.location='/gameUpload/result_list".$paramPage_act."'";
			throw new Lemon_ScriptException("","","script",$script.";self.close();");
			exit();
		}

		$this->view->assign("game_sn_list", $gameSnListParam);
		$this->view->assign("account_param", $accountParam);
		$this->view->assign("account_list", $accountList);
		$this->view->assign("keyword", $keyword);
		$this->view->assign("show_detail", $showDetail);
		$this->view->assign("select_keyword", $selectKeyword);
		$this->view->assign("param_page_act", $paramPage_act);
		$this->display();
	}	
	
	//▶ 베팅 목록
	public function betlistAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/gameUpload/bet_list.html");
		
		$model 	= $this->getModel("GameModel");
		$cartModel = $this->getModel("CartModel");
		$memberModel = $this->getModel("MemberModel");
		
		$bettingNo		= $this->request("betting_no");
		$sel_result 	= $this->request("sel_result");
		$mode 			= $this->request("mode");
		$activeBet		= $this->request("active_bet");
		$perpage		= $this->request("perpage");
		$selectKeyword	= $this->request("select_keyword");
		$keyword		= $this->request("keyword");
		$showDetail = $this->request("show_detail");
		
		if($activeBet=='') 	{$activeBet = 0;}
		if($perpage=='') 		{$perpage = 30;}
		if($showDetail=='') {$showDetail = 0;}
		
		$where="";
		if($mode=="search")
		{
			switch($sel_result)
			{
				case 0: $where = " and result='0'"; break;
				case 1: $where = " and result='1'"; break;
				case 2: $where = " and result='2'"; break;
				case 9: $where=""; break;
			}
			if($selectKeyword=='uid' && $keyword!='')
			{
				$memberSn = $memberModel->getSn($keyword);
				if($memberSn!='')
					$where.=" and member_sn=".$memberSn." ";
			}
			else if($selectKeyword=='nick' && $keyword!='')
			{
				$member = $memberModel->getByName($keyword);
				if(count((array)$member)>0)
					$where.=" and member_sn=".$member['sn']." ";
			}
		}
		if(!is_null($bettingNo) && $bettingNo!="")
		{
			$where.= " and betting_no='".$bettingNo."'";
		}
		
		$page_act = "mode=".$mode."&sel_result=".$sel_result."&show_detail=".$showDetail."&active_bet=".$activeBet."&perpage=".$perpage;
		$total 		= $cartModel->getBettingListTotal($where);
		$pageMaker 	= $this->displayPage($total, $perpage, $page_act);
		$list 		= $cartModel->getBettingList($where, $pageMaker->first, $pageMaker->listNum, $activeBet);
		$sumList = $cartModel->getTotalBetMoney();
		
		$this->view->assign("show_detail",$showDetail);
		$this->view->assign("select_keyword",$selectKeyword);
		$this->view->assign("keyword",$keyword);
		$this->view->assign("sel_result",$sel_result);
		$this->view->assign("active_bet",$activeBet);
		$this->view->assign("perpage",$perpage);
		$this->view->assign("betting_no",$bettingNo);
		$this->view->assign("list",$list);
		$this->view->assign("sumList",$sumList);

		$this->display();
	}
	
	//▶ 게임마감
	public function result_listAction()
	{		
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/gameUpload/result_list.html");
		
		$model 				= $this->getModel("GameModel");
		$cartModel 		= $this->getModel("CartModel");
		$processModel = $this->getModel("ProcessModel");
		$leagueModel 	= $this->getModel("LeagueModel");
		
		$act  				= $this->request("act");
		$perpage			= $this->request("perpage");
		$specialType	= $this->request("special_type");
		$categoryName	= $this->request("categoryName");
		$beginDate  	= $this->request('begin_date');
		$endDate 			= $this->request('end_date');
		$filterTeam		= $this->request('filter_team');
		$filterTeamType	= $this->request('filter_team_type');
		$state				= $this->request('state');
		$currentPage	= !($this->request('page'))?'1':intval($this->request('page'));
		$parsingType = $this->request("parsing_type");
		$leagueSn = $this->request("league_sn");

		//-> 상단 파싱정보 초기화.
		$etcModel = $this->getModel("EtcModel");		
		$etcModel->updateParsingStatus("new_result");

		if($parsingType=='') $parsingType = "ALL";
		if($state=="") $state=22;
		
		if($state==21)
		{
			$bettingEnable=1;
			$filterState=2;
		}
		else if($state==22)
		{
			$bettingEnable=-1;
			$filterState=2;
		}
		else if($state==3)
		{
			$bettingEnable=1;
			$filterState=4;
		}

		if($perpage=='') $perpage = 20;
		
		$minBettingMoney='';
		
		if($filterTeam!='')
		{
			if($filterTeamType=='league')
			{
				$rs = $leagueModel->getListByLikeName($filterTeam);
				for($i=0; $i<count((array)$rs); ++$i)
				{
					$leagueSn[] = $rs[$i]['sn'];
				}
			}
			else if($filterTeamType=='home_team')
				$homeTeam = Trim($filterTeam);

			else if($filterTeamType=='away_team')
				$awayTeam = Trim($filterTeam);
		}
		if($beginDate=="" || $endDate=="")
		{
			$beginDate 	= date("Y-m-d",strtotime ("-1 days"));
			$endDate		= date("Y-m-d",strtotime ("+1 days"));
		}
		$page_act= "parsing_type=".$parsingType."&filter_team=".$filterTeam."&state=".$state."&categoryName=".$categoryName."&special_type=".$specialType."&perpage=".$perpage."&begin_date=".$beginDate."&end_date=".$endDate."&filter_team_type=".$filterTeamType."&filter_betting_total=".$filterBettingTotal;

		if($act=="modify")
		{
			$arraySubChildSn 	= $this->request("y_id");
			$arrayHomeRate 	= $this->request("home_rate");
			$arrayDrawRate 	= $this->request("draw_rate");
			$arrayAwayRate 	= $this->request("away_rate");
			$arrayCancel	= $this->request("check_cancel");
			$arrayHomeScore	= $this->request("home_score");
			$arrayAwayScore	= $this->request("away_score");
			
			for($i=0;$i<count((array)$arraySubChildSn);++$i)
			{
				$isCancel	 = $arrayCancel[$i];
				$subchildSn 	 = $arraySubChildSn[$i];
				$childSn = $model->getChildSn($subchildSn);
				$homeRate	 = $arrayHomeRate[$i];
				$drawRate	 = $arrayDrawRate[$i];
				$awayRate	 = $arrayAwayRate[$i];
				$homeScore = $arrayHomeScore[$i];
				$awayScore = $arrayAwayScore[$i];
				
				if($homeScore!="" && $awayScore!="")
				{
					$set =	"sub_home_score='".$homeScore."',";  
					$set.=	"sub_away_score='".$awayScore."'";
				
					$where = " sn=".$subchildSn;
					$model->modifySubChild($set, $where);
				}
				
				if($homeRate!="" && $awayRate!="")
				{
					$set="";
					$where="";
					$set = "home_rate = '".$homeRate."',";  
					$set.= "draw_rate = '".$drawRate."',";
					$set.= "away_rate = '".$awayRate."',";
					$set.= "update_enable = '0'";
					
					$where = " sn=".$subchildSn;
					$model->modifySubChild($set, $where);
				}
			}

			throw new Lemon_ScriptException("","","script","alert('처리가 완료 되었습니다.');top.location.href='/gameUpload/result_list?page={$currentPage}&{$page_act}';");
			exit;
		}
		
		//게임정산
		else if($act=="modify_result")
		{
			$arraySubChildSn 	= $this->request("y_id");
			$arrayGameResult	= $this->request("game_result");
			$arrayDrawRate 	= $this->request("draw_rate");

			$data = array();
			$betData = array();

			for ( $i = 0 ; $i < count((array)$arraySubChildSn) ; ++$i ) {
				$subchildSn 	 = $arraySubChildSn[$i];
				$game_result = $arrayGameResult[$i];
				$childSn = $model->getChildSn($subchildSn);
				$childRs = $model->getChildRow($childSn, '*');
				if ( $childRs['kubun'] == 1 ) {
					throw new Lemon_ScriptException("이미 처리된 게임이 포함되어 있습니다.");
					exit;
				}

				$dataArray = $processModel->resultPreviewProcess($subchildSn, $game_result);
			
				$list_temp = $dataArray["list"];
				$betData_temp = $dataArray["betData"];
			
				if ( count((array)$list_temp) > 0 ) {
					if ( count((array)$data) <= 0 ) {
						$data = $list_temp;
					} else {
						$data = array_merge($data, $list_temp);
					}
				}
				
				if ( count((array)$betData) <= 0 ) {
					$betData = $betData_temp;
				} else {
					$betData = array_merge($betData, $betData_temp);
				}

				$gameSnList[] = array("subchild_sn" => $subchildSn, "game_result" => $game_result);
			}// end of for
		}
		
		$categoryName = $this->request("categoryName");

		$total_info = $model->getListTotal($filterState, $categoryName, "", $specialType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, '');
		$total = $total_info["cnt"];
		$leagueList = $total_info["league_list"];

		$pageMaker = $this->displayPage($total, $perpage, $page_act);
		$list = $model->getList($pageMaker->first, $pageMaker->listNum, $filterState, $categoryName, "", $specialType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, '');

		for($i=0; $i<count((array)$list); ++$i)
		{
			$item = $cartModel->getTeamTotalBetMoney($list[$i]['child_sn']);

            $list[$i]['home_team'] = strip_tags(html_entity_decode($list[$i]['home_team']));
            $list[$i]['away_team'] = strip_tags(html_entity_decode($list[$i]['away_team']));

			$list[$i]['home_total_betting'] = $item['home_total_betting'];
			$list[$i]['active_home_total_betting'] = $item['active_home_total_betting'];
			$list[$i]['home_count'] = $item['home_count'];
			
			$list[$i]['draw_total_betting'] = $item['draw_total_betting'];
			$list[$i]['active_draw_total_betting'] = $item['active_draw_total_betting'];
			$list[$i]['draw_count'] = $item['draw_count'];
			
			$list[$i]['away_total_betting'] = $item['away_total_betting'];
			$list[$i]['active_away_total_betting'] = $item['active_away_total_betting'];
			$list[$i]['away_count'] = $item['away_count'];
			
			$list[$i]['total_betting'] = $item['home_total_betting']+$item['draw_total_betting']+$item['away_total_betting'];
			$list[$i]['active_total_betting'] = $item['active_home_total_betting']+$item['active_draw_total_betting']+$item['active_away_total_betting'];
			$list[$i]['betting_count'] = $item['home_count']+$item['draw_count']+$item['away_count'];
		}

		$categoryList = $leagueModel->getCategoryList();		
		$paramPage_act = "?page=".$currentPage."&".$page_act;

		$this->view->assign("league_sn",$leagueSn);
		$this->view->assign("parsing_type",$parsingType);			
		$this->view->assign("special_type", $specialType);
		$this->view->assign("categoryName", $categoryName);
		$this->view->assign("categoryList", $categoryList);
		$this->view->assign("state", $state);
		$this->view->assign("list", $list);
		$this->view->assign("league_list",$leagueList);
		$this->view->assign("param_page_act", $paramPage_act);

		/*if(sizeof($data)>0)
		{
			$this->view->assign("account_param", urlencode(serialize($data)));
			$this->view->assign("game_sn_list", urlencode(serialize($gameSnList)));
		}*/

		if($act=="modify_result"){
			$this->view->assign("account_param", urlencode(serialize($data)));
			$this->view->assign("game_sn_list", urlencode(serialize($gameSnList)));
		}
		
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('filter_team', $filterTeam);
		$this->view->assign('filter_team_type', $filterTeamType);
		
		$this->display();
	}

	//▶ 게임마감 (다기준)
	public function result_multi_listAction()
	{		
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/gameUpload/result_multi_list.html");
		
		$model 				= $this->getModel("GameModel");
		$cartModel 		= $this->getModel("CartModel");
		$processModel = $this->getModel("ProcessModel");
		$leagueModel 	= $this->getModel("LeagueModel");
		
		$act  				= $this->request("act");
		$perpage			= $this->request("perpage");
		$specialType	= $this->request("special_type");
		$gameType			= $this->request("game_type");
		$categoryName	= $this->request("categoryName");
		$beginDate  	= $this->request('begin_date');
		$endDate 			= $this->request('end_date');
		$filterTeam		= $this->request('filter_team');
		$filterTeamType	= $this->request('filter_team_type');
		$state				= $this->request('state');
		$currentPage	= !($this->request('page'))?'1':intval($this->request('page'));
		$parsingType = $this->request("parsing_type");
		$leagueSn = $this->request("league_sn");

		//-> 상단 파싱정보 초기화.
		$etcModel = $this->getModel("EtcModel");		
		$etcModel->updateParsingStatus("new_result");

		if($parsingType=='') $parsingType = "ALL";
		if($state=="") $state=22;
		
		if($state==21)
		{
			$bettingEnable=1;
			$filterState=2;
		}
		else if($state==22)
		{
			$bettingEnable=-1;
			$filterState=2;
		}
		else if($state==3)
		{
			$bettingEnable=1;
			$filterState=4;
		}

		if($perpage=='') $perpage = 300;
		
		$minBettingMoney='';
		
		if($filterTeam!='')
		{
			if($filterTeamType=='league')
			{
				$rs = $leagueModel->getListByLikeName($filterTeam);
				for($i=0; $i<count((array)$rs); ++$i)
				{
					$leagueSn[] = $rs[$i]['sn'];
				}
			}
			else if($filterTeamType=='home_team')
				$homeTeam = Trim($filterTeam);

			else if($filterTeamType=='away_team')
				$awayTeam = Trim($filterTeam);
		}
		if($beginDate=="" || $endDate=="")
		{
			$beginDate 	= date("Y-m-d",strtotime ("-1 days"));
			$endDate		= date("Y-m-d",strtotime ("+1 days"));
		}
		$page_act= "parsing_type=".$parsingType."&filter_team=".$filterTeam."&state=".$state."&game_type=".$gameType."&categoryName=".$categoryName."&special_type=".$specialType."&perpage=".$perpage."&begin_date=".$beginDate."&end_date=".$endDate."&filter_team_type=".$filterTeamType."&filter_betting_total=".$filterBettingTotal;

		if($act=="modify")
		{
			$arraySubChildSn 	= $this->request("y_id");
			$arrayHomeRate 	= $this->request("home_rate");
			$arrayDrawRate 	= $this->request("draw_rate");
			$arrayAwayRate 	= $this->request("away_rate");
			$arrayHomeScore	= $this->request("home_score");
			$arrayAwayScore	= $this->request("away_score");
			
			for($i=0;$i<count((array)$arraySubChildSn);++$i)
			{
				$isCancel	 = $arrayCancel[$i];
				$subchildSn 	 = $arraySubChildSn[$i];
				$homeRate	 = $arrayHomeRate[$subchildSn];
				$drawRate	 = $arrayDrawRate[$subchildSn];
				$awayRate	 = $arrayAwayRate[$subchildSn];
				$homeScore = $arrayHomeScore[$subchildSn];
				$awayScore = $arrayAwayScore[$subchildSn];
				
				if($homeScore!="" && $awayScore!="")
				{
					$set =	" a.home_score='".$homeScore."',";  
					$set.=	" a.away_score='".$awayScore."'";
				
					$where = " b.sn=".$subchildSn;
					$model->modifyChildMulti($set, $where);
				}
				
				if($homeRate!="" && $awayRate!="")
				{
					$set="";
					$where="";
					$set = "home_rate = '".$homeRate."',";  
					$set.= "draw_rate = '".$drawRate."',";
					$set.= "away_rate = '".$awayRate."',";
					$set.= "update_enable = '0'";
					
					$where = " sn=".$subchildSn;
					$model->modifySubChildMulti($set, $where);
				}
			}

			throw new Lemon_ScriptException("","","script","alert('처리가 완료 되었습니다.');top.location.href='/gameUpload/result_list?page={$currentPage}&{$page_act}';");
			exit;
		}
		
		//게임정산
		else if($act=="modify_result")
		{
			$arraySubChildSn 	= $this->request("y_id");
			$arrayHomeScore	= $this->request("home_score");
			$arrayAwayScore	= $this->request("away_score");
			$arrayCancel		= $this->request("check_cancel");
			$arrayType			= $this->request("game_types");
			$arrayDrawRate 	= $this->request("draw_rate");

			$data = array();
			$betData = array();

			for ( $i = 0 ; $i < count((array)$arraySubChildSn) ; ++$i ) {
				$isCancel	 = $arrayCancel[$i];
				$subchildSn 	 = $arraySubChildSn[$i];
				$homeScore = $arrayHomeScore[$subchildSn];
				$awayScore = $arrayAwayScore[$subchildSn];

				if ( (strlen(trim($homeScore)) > 0 and strlen(trim($awayScore)) > 0) or $isCancel ) {
					$childRs = $model->getChildRowMulti($subchildSn, '*');
					if ( $childRs['kubun'] == 1 ) {
						throw new Lemon_ScriptException("이미 처리된 게임이 포함되어 있습니다.");
						exit;
					}

					$dataArray = $processModel->resultPreviewProcessMulti($subchildSn, $homeScore, $awayScore, $isCancel, $betData);
				
					$list_temp = $dataArray["list"];
					$betData_temp = $dataArray["betData"];
				
					if ( count((array)$list_temp) > 0 ) {
						if ( count((array)$data) <= 0 ) {
							$data = $list_temp;
						} else {
							$data = array_merge($data, $list_temp);
						}
					}
					
					if ( count((array)$betData) <= 0 ) {
						$betData = $betData_temp;
					} else {
						$betData = array_merge($betData, $betData_temp);
					}

					$gameSnList[] = array("child_sn" => $childSn, "home_score" => $homeScore, "away_score" => $awayScore, "is_cancel" => $isCancel);
				}
			}// end of for
		}
		
		$categoryName = $this->request("categoryName");
		$gameType = $this->request("game_type");

		$total_info = $model->getMultiListTotal($filterState, $categoryName, $gameType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, '', $leagueSn);
		$total = $total_info["cnt"];
		$leagueList = $total_info["league_list"];

		$pageMaker = $this->displayPage($total, $perpage, $page_act);
		$list = $model->getMultiList($pageMaker->first, $pageMaker->listNum, $filterState, $categoryName, $gameType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, '', $leagueSn);

		for($i=0; $i<count((array)$list); ++$i)
		{
			$item = $cartModel->getTeamTotalBetMoney($list[$i]['child_sn']);

            $list[$i]['home_team'] = strip_tags(html_entity_decode($list[$i]['home_team']));
            $list[$i]['away_team'] = strip_tags(html_entity_decode($list[$i]['away_team']));

			$list[$i]['home_total_betting'] = $item['home_total_betting'];
			$list[$i]['active_home_total_betting'] = $item['active_home_total_betting'];
			$list[$i]['home_count'] = $item['home_count'];
			
			$list[$i]['draw_total_betting'] = $item['draw_total_betting'];
			$list[$i]['active_draw_total_betting'] = $item['active_draw_total_betting'];
			$list[$i]['draw_count'] = $item['draw_count'];
			
			$list[$i]['away_total_betting'] = $item['away_total_betting'];
			$list[$i]['active_away_total_betting'] = $item['active_away_total_betting'];
			$list[$i]['away_count'] = $item['away_count'];
			
			$list[$i]['total_betting'] = $item['home_total_betting']+$item['draw_total_betting']+$item['away_total_betting'];
			$list[$i]['active_total_betting'] = $item['active_home_total_betting']+$item['active_draw_total_betting']+$item['active_away_total_betting'];
			$list[$i]['betting_count'] = $item['home_count']+$item['draw_count']+$item['away_count'];
		}

		$categoryList = $leagueModel->getCategoryList();		
		$paramPage_act = "?page=".$currentPage."&".$page_act;

		$this->view->assign("league_sn",$leagueSn);
		$this->view->assign("parsing_type",$parsingType);			
		$this->view->assign("special_type", $specialType);
		$this->view->assign("gameType", $gameType);
		$this->view->assign("categoryName", $categoryName);
		$this->view->assign("categoryList", $categoryList);
		$this->view->assign("state", $state);
		$this->view->assign("list", $list);
		$this->view->assign("league_list",$leagueList);
		$this->view->assign("param_page_act", $paramPage_act);

		/*if(sizeof($data)>0)
		{
			$this->view->assign("account_param", urlencode(serialize($data)));
			$this->view->assign("game_sn_list", urlencode(serialize($gameSnList)));
		}*/

		if($act=="modify_result"){
			$this->view->assign("account_param", urlencode(serialize($data)));
			$this->view->assign("game_sn_list", urlencode(serialize($gameSnList)));
		}
		
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('filter_team', $filterTeam);
		$this->view->assign('filter_team_type', $filterTeamType);
		
		$this->display();
	}

	//게임재정산
    public function result_list_resettleAction()
    {
        $this->commonDefine();

        if(!$this->auth->isLogin())
        {
            $this->loginAction();
            exit;
        }
        $this->view->define("content","content/gameUpload/result_list_resettle.html");

        $model 				= $this->getModel("GameModel");
        $cartModel 		= $this->getModel("CartModel");
        $processModel = $this->getModel("ProcessModel");
        $leagueModel 	= $this->getModel("LeagueModel");

        $act  				= $this->request("act");
        $perpage			= $this->request("perpage");
        $specialType	= $this->request("special_type");
        $gameType			= $this->request("game_type");
        $categoryName	= $this->request("categoryName");
        $beginDate  	= $this->request('begin_date');
        $endDate 			= $this->request('end_date');
        $filterTeam		= $this->request('filter_team');
        $filterTeamType	= $this->request('filter_team_type');
        $state				= $this->request('state');
        $currentPage	= !($this->request('page'))?'1':intval($this->request('page'));
        $parsingType = $this->request("parsing_type");
        $leagueSn = $this->request("league_sn");

        //-> 상단 파싱정보 초기화.
        $etcModel = $this->getModel("EtcModel");
        $etcModel->updateParsingStatus("new_result");

        if($parsingType=='') $parsingType = "ALL";
        /*if($state=="") $state=22;

        if($state==21)
        {
            $bettingEnable=1;
            $filterState=2;
        }
        else if($state==22)
        {
            $bettingEnable=-1;
            $filterState=2;
        }
        else if($state==3)
        {
            $bettingEnable=1;
            $filterState=4;
        }*/

        // 종료된 게임만
        $filterState=1;

        if($perpage=='') $perpage = 300;

        $minBettingMoney='';

        if($filterTeam!='')
        {
            if($filterTeamType=='league')
            {
                $rs = $leagueModel->getListByLikeName($filterTeam);
                for($i=0; $i<count((array)$rs); ++$i)
                {
                    $leagueSn[] = $rs[$i]['sn'];
                }
            }
            else if($filterTeamType=='home_team')
                $homeTeam = Trim($filterTeam);

            else if($filterTeamType=='away_team')
                $awayTeam = Trim($filterTeam);
        }
        if($beginDate=="" || $endDate=="")
        {
            $beginDate 	= date("Y-m-d",strtotime ("-1 days"));
            $endDate		= date("Y-m-d",strtotime ("+1 days"));
        }
        $page_act= "parsing_type=".$parsingType."&filter_team=".$filterTeam."&state=".$state."&game_type=".$gameType."&categoryName=".$categoryName."&special_type=".$specialType."&perpage=".$perpage."&begin_date=".$beginDate."&end_date=".$endDate."&filter_team_type=".$filterTeamType."&filter_betting_total=".$filterBettingTotal;

        /*if($act=="modify")
        {
            $arrayChildSn 	= $this->request("y_id");
            $arrayHomeRate 	= $this->request("home_rate");
            $arrayDrawRate 	= $this->request("draw_rate");
            $arrayAwayRate 	= $this->request("away_rate");
            $arrayHomeScore	= $this->request("home_score");
            $arrayAwayScore	= $this->request("away_score");

            for($i=0;$i<sizeof($arrayChildSn);++$i)
            {
                $isCancel	 = $arrayCancel[$i];
                $childSn 	 = $arrayChildSn[$i];
                $homeRate	 = $arrayHomeRate[$childSn];
                $drawRate	 = $arrayDrawRate[$childSn];
                $awayRate	 = $arrayAwayRate[$childSn];
                $homeScore = $arrayHomeScore[$childSn];
                $awayScore = $arrayAwayScore[$childSn];

                if($homeScore!="" && $awayScore!="")
                {
                    $set =	"home_score='".$homeScore."',";
                    $set.=	"away_score='".$awayScore."'";

                    $where = " sn=".$childSn;
                    $model->modifyChild($set, $where);
                }

                if($homeRate!="" && $awayRate!="")
                {
                    $set="";
                    $where="";
                    $set = "home_rate = '".$homeRate."',";
                    $set.= "draw_rate = '".$drawRate."',";
                    $set.= "away_rate = '".$awayRate."',";
                    $set.= "update_enable = '0'";

                    $where = " child_sn=".$childSn;
                    $model->modifySubChild($set, $where);
                }
            }

            throw new Lemon_ScriptException("","","script","alert('처리가 완료 되었습니다.');top.location.href='/gameUpload/result_list_resettle?page={$currentPage}&{$page_act}';");
            exit;
        }*/

        //게임정산
        //else if($act=="modify_result")
        if($act=="modify_result")
        {
            $arrayChildSn 	= $this->request("y_id");
            $arrayHomeScore	= $this->request("home_score");
            $arrayAwayScore	= $this->request("away_score");
            $arrayCancel		= $this->request("check_cancel");
            $arrayType			= $this->request("game_types");
            $arrayDrawRate 	= $this->request("draw_rate");

            $data = array();
            $betData = array();

            for ( $i = 0 ; $i < count((array)$arrayChildSn) ; ++$i ) {
                $isCancel	 = $arrayCancel[$i];
                $childSn 	 = $arrayChildSn[$i];
                $homeScore = $arrayHomeScore[$childSn];
                $awayScore = $arrayAwayScore[$childSn];

                if ( (strlen(trim($homeScore)) > 0 and strlen(trim($awayScore)) > 0) or $isCancel ) {
                    $childRs = $model->getChildRow($childSn, '*');
                    if ( $childRs['kubun'] == 1 ) {
                    	// 정산취소모듈 추가
                        $processModel->cancel_resultGameProcess($childSn, $homeScore, $awayScore);
                    }

                    $dataArray = $processModel->resultPreviewProcess($childSn, $homeScore, $awayScore, $isCancel, $betData);

                    $list_temp = $dataArray["list"];
                    $betData_temp = $dataArray["betData"];

                    if ( count((array)$list_temp) > 0 ) {
                        if ( count((array)$data) <= 0 ) {
                            $data = $list_temp;
                        } else {
                            $data = array_merge($data, $list_temp);
                        }
                    }

                    if ( count((array)$betData) <= 0 ) {
                        $betData = $betData_temp;
                    } else {
                        $betData = array_merge($betData, $betData_temp);
                    }

                    $gameSnList[] = array("child_sn" => $childSn, "home_score" => $homeScore, "away_score" => $awayScore, "is_cancel" => $isCancel);
                }
            }// end of for
        }

        $categoryName = $this->request("categoryName");
        $gameType = $this->request("game_type");

        $total_info = $model->getListTotal($filterState, $categoryName, $gameType, $specialType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, '', $leagueSn);
        $total = $total_info["cnt"];
        $leagueList = $total_info["league_list"];

        $pageMaker = $this->displayPage($total, $perpage, $page_act);
        $list = $model->getList($pageMaker->first, $pageMaker->listNum, $filterState, $categoryName, $gameType, $specialType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, '', $leagueSn);

        for($i=0; $i<count((array)$list); ++$i)
        {
            $item = $cartModel->getTeamTotalBetMoney($list[$i]['child_sn']);

            $list[$i]['home_team'] = strip_tags(html_entity_decode($list[$i]['home_team']));
            $list[$i]['away_team'] = strip_tags(html_entity_decode($list[$i]['away_team']));

            $list[$i]['home_total_betting'] = $item['home_total_betting'];
            $list[$i]['active_home_total_betting'] = $item['active_home_total_betting'];
            $list[$i]['home_count'] = $item['home_count'];

            $list[$i]['draw_total_betting'] = $item['draw_total_betting'];
            $list[$i]['active_draw_total_betting'] = $item['active_draw_total_betting'];
            $list[$i]['draw_count'] = $item['draw_count'];

            $list[$i]['away_total_betting'] = $item['away_total_betting'];
            $list[$i]['active_away_total_betting'] = $item['active_away_total_betting'];
            $list[$i]['away_count'] = $item['away_count'];

            $list[$i]['total_betting'] = $item['home_total_betting']+$item['draw_total_betting']+$item['away_total_betting'];
            $list[$i]['active_total_betting'] = $item['active_home_total_betting']+$item['active_draw_total_betting']+$item['active_away_total_betting'];
            $list[$i]['betting_count'] = $item['home_count']+$item['draw_count']+$item['away_count'];
        }

        $categoryList = $leagueModel->getCategoryList();
        $paramPage_act = "?page=".$currentPage."&".$page_act;

        $this->view->assign("league_sn",$leagueSn);
        $this->view->assign("parsing_type",$parsingType);
        $this->view->assign("special_type", $specialType);
        $this->view->assign("gameType", $gameType);
        $this->view->assign("categoryName", $categoryName);
        $this->view->assign("categoryList", $categoryList);
        //$this->view->assign("state", $state);
        $this->view->assign("list", $list);
        $this->view->assign("league_list",$leagueList);
        $this->view->assign("param_page_act", $paramPage_act);
        /*
        if(sizeof($data)>0)
        {
            $this->view->assign("account_param", urlencode(serialize($data)));
            $this->view->assign("game_sn_list", urlencode(serialize($gameSnList)));
        }
        */
        if($act=="modify_result"){
            $this->view->assign("account_param", urlencode(serialize($data)));
            $this->view->assign("game_sn_list", urlencode(serialize($gameSnList)));
        }

        $this->view->assign('begin_date', $beginDate);
        $this->view->assign('end_date', $endDate);
        $this->view->assign('filter_team', $filterTeam);
        $this->view->assign('filter_team_type', $filterTeamType);

        $this->display();
    }
 
	//게임재정산 (다기준)
    public function result_list_resettle_multiAction()
    {
        $this->commonDefine();

        if(!$this->auth->isLogin())
        {
            $this->loginAction();
            exit;
        }
        $this->view->define("content","content/gameUpload/result_list_resettle_multi.html");

        $model 				= $this->getModel("GameModel");
        $cartModel 		= $this->getModel("CartModel");
        $processModel = $this->getModel("ProcessModel");
        $leagueModel 	= $this->getModel("LeagueModel");

        $act  				= $this->request("act");
        $perpage			= $this->request("perpage");
        $specialType	= $this->request("special_type");
        $gameType			= $this->request("game_type");
        $categoryName	= $this->request("categoryName");
        $beginDate  	= $this->request('begin_date');
        $endDate 			= $this->request('end_date');
        $filterTeam		= $this->request('filter_team');
        $filterTeamType	= $this->request('filter_team_type');
        $state				= $this->request('state');
        $currentPage	= !($this->request('page'))?'1':intval($this->request('page'));
        $parsingType = $this->request("parsing_type");
        $leagueSn = $this->request("league_sn");

        //-> 상단 파싱정보 초기화.
        $etcModel = $this->getModel("EtcModel");
        $etcModel->updateParsingStatus("new_result");

        if($parsingType=='') $parsingType = "ALL";
       
        // 종료된 게임만
        $filterState=1;

        if($perpage=='') $perpage = 300;

        $minBettingMoney='';

        if($filterTeam!='')
        {
            if($filterTeamType=='league')
            {
                $rs = $leagueModel->getListByLikeName($filterTeam);
                for($i=0; $i<count((array)$rs); ++$i)
                {
                    $leagueSn[] = $rs[$i]['sn'];
                }
            }
            else if($filterTeamType=='home_team')
                $homeTeam = Trim($filterTeam);

            else if($filterTeamType=='away_team')
                $awayTeam = Trim($filterTeam);
        }
        if($beginDate=="" || $endDate=="")
        {
            $beginDate 	= date("Y-m-d",strtotime ("-1 days"));
            $endDate		= date("Y-m-d",strtotime ("+1 days"));
        }
        $page_act= "parsing_type=".$parsingType."&filter_team=".$filterTeam."&state=".$state."&game_type=".$gameType."&categoryName=".$categoryName."&special_type=".$specialType."&perpage=".$perpage."&begin_date=".$beginDate."&end_date=".$endDate."&filter_team_type=".$filterTeamType."&filter_betting_total=".$filterBettingTotal;

        //게임정산
        //else if($act=="modify_result")
        if($act=="modify_result")
        {
            $arraySubChildSn 	= $this->request("y_id");
            $arrayHomeScore	= $this->request("home_score");
            $arrayAwayScore	= $this->request("away_score");
            $arrayCancel		= $this->request("check_cancel");
            $arrayType			= $this->request("game_types");
            $arrayDrawRate 	= $this->request("draw_rate");

            $data = array();
            $betData = array();

            for ( $i = 0 ; $i < count((array)$arraySubChildSn) ; ++$i ) {
                $isCancel	 = $arrayCancel[$i];
                $subchildSn 	 = $arraySubChildSn[$i];
                $homeScore = $arrayHomeScore[$subchildSn];
                $awayScore = $arrayAwayScore[$subchildSn];

                if ( (strlen(trim($homeScore)) > 0 and strlen(trim($awayScore)) > 0) or $isCancel ) {
                    $childRs = $model->getChildRowMulti($subchildSn, '*');
                    if ( $childRs['kubun'] == 1 ) {
                    	// 정산취소모듈 추가
                        $processModel->cancel_resultGameProcessMulti($subchildSn, $homeScore, $awayScore);
                    }

                    $dataArray = $processModel->resultPreviewProcessMulti($subchildSn, $homeScore, $awayScore, $isCancel, $betData);

                    $list_temp = $dataArray["list"];
                    $betData_temp = $dataArray["betData"];

                    if ( count((array)$list_temp) > 0 ) {
                        if ( count((array)$data) <= 0 ) {
                            $data = $list_temp;
                        } else {
                            $data = array_merge($data, $list_temp);
                        }
                    }

                    if ( count((array)$betData) <= 0 ) {
                        $betData = $betData_temp;
                    } else {
                        $betData = array_merge($betData, $betData_temp);
                    }

                    $gameSnList[] = array("sn" => $subchildSn, "home_score" => $homeScore, "away_score" => $awayScore, "is_cancel" => $isCancel);
                }
            }// end of for
        }

        $categoryName = $this->request("categoryName");
        $gameType = $this->request("game_type");

        $total_info = $model->getMultiListTotal($filterState, $categoryName, $gameType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, '');
        $total = $total_info["cnt"];
        $leagueList = $total_info["league_list"];
		
        $pageMaker = $this->displayPage($total, $perpage, $page_act);
        $list = $model->getMultiList($pageMaker->first, $pageMaker->listNum, $filterState, $categoryName, $gameType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, '');

        for($i=0; $i<count((array)$list); ++$i)
        {
            $item = $cartModel->getTeamTotalBetMoney($list[$i]['child_sn']);

            $list[$i]['home_team'] = strip_tags(html_entity_decode($list[$i]['home_team']));
            $list[$i]['away_team'] = strip_tags(html_entity_decode($list[$i]['away_team']));

            $list[$i]['home_total_betting'] = $item['home_total_betting'];
            $list[$i]['active_home_total_betting'] = $item['active_home_total_betting'];
            $list[$i]['home_count'] = $item['home_count'];

            $list[$i]['draw_total_betting'] = $item['draw_total_betting'];
            $list[$i]['active_draw_total_betting'] = $item['active_draw_total_betting'];
            $list[$i]['draw_count'] = $item['draw_count'];

            $list[$i]['away_total_betting'] = $item['away_total_betting'];
            $list[$i]['active_away_total_betting'] = $item['active_away_total_betting'];
            $list[$i]['away_count'] = $item['away_count'];

            $list[$i]['total_betting'] = $item['home_total_betting']+$item['draw_total_betting']+$item['away_total_betting'];
            $list[$i]['active_total_betting'] = $item['active_home_total_betting']+$item['active_draw_total_betting']+$item['active_away_total_betting'];
            $list[$i]['betting_count'] = $item['home_count']+$item['draw_count']+$item['away_count'];
        }

        $categoryList = $leagueModel->getCategoryList();
        $paramPage_act = "?page=".$currentPage."&".$page_act;

        $this->view->assign("league_sn",$leagueSn);
        $this->view->assign("parsing_type",$parsingType);
        $this->view->assign("special_type", $specialType);
        $this->view->assign("gameType", $gameType);
        $this->view->assign("categoryName", $categoryName);
        $this->view->assign("categoryList", $categoryList);
        //$this->view->assign("state", $state);
        $this->view->assign("list", $list);
        $this->view->assign("league_list",$leagueList);
        $this->view->assign("param_page_act", $paramPage_act);
        /*
        if(sizeof($data)>0)
        {
            $this->view->assign("account_param", urlencode(serialize($data)));
            $this->view->assign("game_sn_list", urlencode(serialize($gameSnList)));
        }
        */
        if($act=="modify_result"){
            $this->view->assign("account_param", urlencode(serialize($data)));
            $this->view->assign("game_sn_list", urlencode(serialize($gameSnList)));
        }

        $this->view->assign('begin_date', $beginDate);
        $this->view->assign('end_date', $endDate);
        $this->view->assign('filter_team', $filterTeam);
        $this->view->assign('filter_team_type', $filterTeamType);

        $this->display();
    }

	//▶ 배당수정
	public function modify_rateAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/gameUpload/modify_rate.html");
		
		$model 				= $this->getModel("GameModel");
		$cartModel 		= $this->getModel("CartModel");
		$processModel = $this->getModel("ProcessModel");
		$leagueModel 	= $this->getModel("LeagueModel");
		
		$act  				= $this->request("act");
		$perpage			= $this->request("perpage");
		$specialType	= $this->request("special_type");
		$gameType			= $this->request("game_type");
		$categoryName	= $this->request("categoryName");
		$beginDate  	= $this->request('begin_date');
		$endDate 			= $this->request('end_date');
		$filterTeam		= $this->request('filter_team');
		$filterTeamType	= $this->request('filter_team_type');
		$state				= $this->request('state');
		$currentPage	= !($this->request('page'))?'1':intval($this->request('page'));
		$parsingType = $this->request("parsing_type");
		$leagueSn = $this->request("league_sn");
		$filterState = $this->request("filterState");

		//-> 상단 파싱정보 초기화.
		$etcModel = $this->getModel("EtcModel");		
		$etcModel->updateParsingStatus("new_result");

		if($parsingType=='') $parsingType = "ALL";
		
		$state = 3;
		$bettingEnable = 1;

		if($perpage=='') $perpage = 20;
		
		$minBettingMoney='';
		
		if($filterTeam!='')
		{
			if($filterTeamType=='league')
			{
				$rs = $leagueModel->getListByLikeName($filterTeam);
				for($i=0; $i<count((array)$rs); ++$i)
				{
					$leagueSn[] = $rs[$i]['sn'];
				}
			}
			else if($filterTeamType=='home_team')
				$homeTeam = Trim($filterTeam);

			else if($filterTeamType=='away_team')
				$awayTeam = Trim($filterTeam);
		}
		if($beginDate=="" || $endDate=="")
		{
			$beginDate 	= date("Y-m-d",strtotime ("-1 days"));
			$endDate		= date("Y-m-d",strtotime ("+1 days"));
		}

		$page_act = "perpage=".$perpage."&filterState=".$filterState."&parsing_type=".$parsingType."&special_type=".$specialType."&game_type=".$gameType.
								"&categoryName=".$categoryName."&league_sn=".$leagueSn."&begin_date=".$beginDate."&end_date=".$endDate."&filter_team_type=".$filterTeamType."&filter_team=".$filterTeam;

		if($act=="modify")
		{
			$arrayChildSn 	= $this->request("y_id");
			$arrayHomeRate 	= $this->request("home_rate");
			$arrayDrawRate 	= $this->request("draw_rate");
			$arrayAwayRate 	= $this->request("away_rate");
			$arrayHomeScore	= $this->request("home_score");
			$arrayAwayScore	= $this->request("away_score");
			
			for($i=0;$i<count((array)$arrayChildSn);++$i)
			{
				$isCancel	 = $arrayCancel[$i];
				$childSn 	 = $arrayChildSn[$i];
				$homeRate	 = $arrayHomeRate[$childSn];
				$drawRate	 = $arrayDrawRate[$childSn];
				$awayRate	 = $arrayAwayRate[$childSn];
				$homeScore = $arrayHomeScore[$childSn];
				$awayScore = $arrayAwayScore[$childSn];
				
				if($homeScore!="" && $awayScore!="")
				{
					$set =	"home_score='".$homeScore."',";  
					$set.=	"away_score='".$awayScore."'";
				
					$where = " sn=".$childSn;
					$model->modifyChild($set, $where);
				}
				
				if($homeRate!="" && $awayRate!="")
				{
					$set="";
					$where="";
					$set = "home_rate = '".$homeRate."',";  
					$set.= "draw_rate = '".$drawRate."',";
					$set.= "away_rate = '".$awayRate."',";
					$set.= "update_enable = '0'";
					
					$where = " child_sn=".$childSn;
					$model->modifySubChild($set, $where);
				}
			}

			throw new Lemon_ScriptException("","","script","alert('처리가 완료 되었습니다.');top.location.href='/gameUpload/modify_rate?page={$currentPage}&{$page_act}';");
			exit;
		}
		
		$categoryName = $this->request("categoryName");
		$gameType 		= $this->request("game_type");

		$total_info = $model->getListTotal($filterState, $categoryName, $gameType, $specialType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, '', $leagueSn, $kubun);
		$total = $total_info["cnt"];
		$leagueList = $total_info["league_list"];

		$pageMaker = $this->displayPage($total, $perpage, $page_act);
		$list = $model->getList($pageMaker->first, $pageMaker->listNum, $filterState, $categoryName, $gameType, $specialType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, '', $leagueSn, $kubun);

		for($i=0; $i<count((array)$list); ++$i)
		{
			$item = $cartModel->getTeamTotalBetMoney($list[$i]['child_sn']);
			
			$list[$i]['home_total_betting'] = $item['home_total_betting'];
			$list[$i]['active_home_total_betting'] = $item['active_home_total_betting'];
			$list[$i]['home_count'] = $item['home_count'];
			
			$list[$i]['draw_total_betting'] = $item['draw_total_betting'];
			$list[$i]['active_draw_total_betting'] = $item['active_draw_total_betting'];
			$list[$i]['draw_count'] = $item['draw_count'];
			
			$list[$i]['away_total_betting'] = $item['away_total_betting'];
			$list[$i]['active_away_total_betting'] = $item['active_away_total_betting'];
			$list[$i]['away_count'] = $item['away_count'];
			
			$list[$i]['total_betting'] = $item['home_total_betting']+$item['draw_total_betting']+$item['away_total_betting'];
			$list[$i]['active_total_betting'] = $item['active_home_total_betting']+$item['active_draw_total_betting']+$item['active_away_total_betting'];
			$list[$i]['betting_count'] = $item['home_count']+$item['draw_count']+$item['away_count'];
		}

		$categoryList = $leagueModel->getCategoryList();		
		$paramPage_act = "?page=".$currentPage."&".$page_act;

		$this->view->assign("filterState",$filterState);
		$this->view->assign("league_sn",$leagueSn);
		$this->view->assign("parsing_type",$parsingType);			
		$this->view->assign("special_type", $specialType);
		$this->view->assign("gameType", $gameType);
		$this->view->assign("categoryName", $categoryName);
		$this->view->assign("categoryList", $categoryList);
		$this->view->assign("state", $state);
		$this->view->assign("list", $list);
		$this->view->assign("league_list",$leagueList);
		$this->view->assign("param_page_act", $paramPage_act);

		if($act=="modify_result"){
			$this->view->assign("account_param", urlencode(serialize($data)));
			$this->view->assign("game_sn_list", urlencode(serialize($gameSnList)));
		}
		
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('filter_team', $filterTeam);
		$this->view->assign('filter_team_type', $filterTeamType);
		
		$this->display();
	}

	//▶ 배당수정
	public function modify_multi_rateAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/gameUpload/modify_rate_multi.html");
		
		$model 				= $this->getModel("GameModel");
		$cartModel 		= $this->getModel("CartModel");
		$processModel = $this->getModel("ProcessModel");
		$leagueModel 	= $this->getModel("LeagueModel");
		
		$act  				= $this->request("act");
		$perpage			= $this->request("perpage");
		$specialType	= $this->request("special_type");
		$gameType			= $this->request("game_type");
		$categoryName	= $this->request("categoryName");
		$beginDate  	= $this->request('begin_date');
		$endDate 			= $this->request('end_date');
		$filterTeam		= $this->request('filter_team');
		$filterTeamType	= $this->request('filter_team_type');
		$state				= $this->request('state');
		$currentPage	= !($this->request('page'))?'1':intval($this->request('page'));
		$parsingType = $this->request("parsing_type");
		$leagueSn = $this->request("league_sn");
		$filterState = $this->request("filterState");

		//-> 상단 파싱정보 초기화.
		$etcModel = $this->getModel("EtcModel");		
		$etcModel->updateParsingStatus("new_result");

		if($parsingType=='') $parsingType = "ALL";
		
		$state = 3;
		$bettingEnable = 1;

		if($perpage=='') $perpage = 100;
		
		$minBettingMoney='';
		
		if($filterTeam!='')
		{
			if($filterTeamType=='league')
			{
				$rs = $leagueModel->getListByLikeName($filterTeam);
				for($i=0; $i<count((array)$rs); ++$i)
				{
					$leagueSn[] = $rs[$i]['sn'];
				}
			}
			else if($filterTeamType=='home_team')
				$homeTeam = Trim($filterTeam);

			else if($filterTeamType=='away_team')
				$awayTeam = Trim($filterTeam);
		}
		if($beginDate=="" || $endDate=="")
		{
			$beginDate 	= date("Y-m-d",strtotime ("-1 days"));
			$endDate		= date("Y-m-d",strtotime ("+1 days"));
		}

		$page_act = "perpage=".$perpage."&filterState=".$filterState."&parsing_type=".$parsingType."&special_type=".$specialType."&game_type=".$gameType.
								"&categoryName=".$categoryName."&league_sn=".$leagueSn."&begin_date=".$beginDate."&end_date=".$endDate."&filter_team_type=".$filterTeamType."&filter_team=".$filterTeam;

		if($act=="modify")
		{
			$arraySubChildSn 	= $this->request("y_id");
			$arrayHomeRate 	= $this->request("home_rate");
			$arrayDrawRate 	= $this->request("draw_rate");
			$arrayAwayRate 	= $this->request("away_rate");
			$arrayHomeScore	= $this->request("home_score");
			$arrayAwayScore	= $this->request("away_score");
			
			for($i=0;$i<count((array)$arraySubChildSn);++$i)
			{
				$isCancel	 = $arrayCancel[$i];
				$subchildSn 	 = $arraySubChildSn[$i];
				$homeRate	 = $arrayHomeRate[$subchildSn];
				$drawRate	 = $arrayDrawRate[$subchildSn];
				$awayRate	 = $arrayAwayRate[$subchildSn];
				$homeScore = $arrayHomeScore[$subchildSn];
				$awayScore = $arrayAwayScore[$subchildSn];
				
				if($homeScore!="" && $awayScore!="")
				{
					$set =	"a.home_score='".$homeScore."',";  
					$set.=	"a.away_score='".$awayScore."'";
				
					$where = " b.sn=".$subchildSn;
					$model->modifyChildMulti($set, $where);
				}
				
				if($homeRate!="" && $awayRate!="")
				{
					$set="";
					$where="";
					$set = "home_rate = '".$homeRate."',";  
					$set.= "draw_rate = '".$drawRate."',";
					$set.= "away_rate = '".$awayRate."',";
					$set.= "update_enable = '0'";
					
					$where = " sn=".$subchildSn;
					$model->modifySubChildMulti($set, $where);
				}
			}

			throw new Lemon_ScriptException("","","script","alert('처리가 완료 되었습니다.');top.location.href='/gameUpload/modify_multi_rate?page={$currentPage}&{$page_act}';");
			exit;
		}
		
		$categoryName = $this->request("categoryName");
		$gameType 		= $this->request("game_type");

		$total_info = $model->getMultiListTotal($filterState, $categoryName, $gameType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, '');
		$total = $total_info["cnt"];
		$leagueList = $total_info["league_list"];
		
		$pageMaker = $this->displayPage($total, $perpage, $page_act);
		$list = $model->getMultiList($pageMaker->first, $pageMaker->listNum, $filterState, $categoryName, $gameType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, '');

		for($i=0; $i<count((array)$list); ++$i)
		{
			$item = $cartModel->getTeamTotalBetMoney($list[$i]['child_sn']);
			
			$list[$i]['home_total_betting'] = $item['home_total_betting'];
			$list[$i]['active_home_total_betting'] = $item['active_home_total_betting'];
			$list[$i]['home_count'] = $item['home_count'];
			
			$list[$i]['draw_total_betting'] = $item['draw_total_betting'];
			$list[$i]['active_draw_total_betting'] = $item['active_draw_total_betting'];
			$list[$i]['draw_count'] = $item['draw_count'];
			
			$list[$i]['away_total_betting'] = $item['away_total_betting'];
			$list[$i]['active_away_total_betting'] = $item['active_away_total_betting'];
			$list[$i]['away_count'] = $item['away_count'];
			
			$list[$i]['total_betting'] = $item['home_total_betting']+$item['draw_total_betting']+$item['away_total_betting'];
			$list[$i]['active_total_betting'] = $item['active_home_total_betting']+$item['active_draw_total_betting']+$item['active_away_total_betting'];
			$list[$i]['betting_count'] = $item['home_count']+$item['draw_count']+$item['away_count'];
		}

		$categoryList = $leagueModel->getCategoryList();		
		$paramPage_act = "?page=".$currentPage."&".$page_act;

		$this->view->assign("filterState",$filterState);
		$this->view->assign("league_sn",$leagueSn);
		$this->view->assign("parsing_type",$parsingType);			
		$this->view->assign("special_type", $specialType);
		$this->view->assign("gameType", $gameType);
		$this->view->assign("categoryName", $categoryName);
		$this->view->assign("categoryList", $categoryList);
		$this->view->assign("state", $state);
		$this->view->assign("list", $list);
		$this->view->assign("league_list",$leagueList);
		$this->view->assign("param_page_act", $paramPage_act);

		if($act=="modify_result"){
			$this->view->assign("account_param", urlencode(serialize($data)));
			$this->view->assign("game_sn_list", urlencode(serialize($gameSnList)));
		}
		
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('filter_team', $filterTeam);
		$this->view->assign('filter_team_type', $filterTeamType);
		
		$this->display();
	}

	//▶ 게임복사
	public function game_copy_listAction()
	{
		$this->popupDefine();
		//$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/gameUpload/game_copy_list.html");
		
		$mode								= $this->request("mode");
		$keyword						= $this->request("keyword");
		$selector						= $this->request("selector");
		$keywordCategory		= $this->request("keyword_category");
		$checkboxes					= $this->request("checkboxes");
		$beginDate					= $this->request("begin_date");
		$endDate					= $this->request("end_date");
		
		if($beginDate=="") $beginDate=date("Y-m-d");
		if($endDate=="") 	$endDate	= date("Y-m-d",strtotime ("+1 days"));
		
		$handicapAwayRate  = $handicapHomeRate = $this->request("handicap_rate");
		$underoverAwayRate = $underoverHomeRate = $this->request("underover_rate");
		
		$specialHandicapAwayRate = $specialHandicapHomeRate = $this->request("special_handicap_rate");
		$specialUnderoverAwayRate = $specialUnderoverHomeRate = $this->request("special_underover_rate");
		
		$gameListModel 				= $this->getModel("GameListModel");
		$gameModel 				= $this->getModel("GameModel");
		$leagueModel 				= $this->getModel("LeagueModel");
	
		if($mode=="copy")
		{
			$arrayChildSn 	= $this->request("child_sn");
			$arrayGameDate 	= $this->request("game_date");
			$arrayCategory 	= $this->request("category");
			$arrayLeagueSn 	= $this->request("league_sn");
			$arrayHomeTeam	= $this->request("home_team");
			$arrayAwayTeam	= $this->request("away_team");
			$arrayHomeRate	= $this->request("home_rate");
			$arrayDrawRate	= $this->request("draw_rate");
			$arrayAwayRate	= $this->request("away_rate");
			
			for($i=0;$i<count((array)$arrayChildSn);++$i)
			{
				$childSn 	  = $arrayChildSn[$i];
				$date	 	  = $arrayGameDate[$childSn];
				$category	  = $arrayCategory[$childSn];
				$leagueSn	  = $arrayLeagueSn[$childSn];
				$homeTeam	  = $arrayHomeTeam[$childSn];
				$awayTeam 	= $arrayAwayTeam[$childSn];
				$homeRate  = $arrayHomeRate[$childSn];
				$drawRate 	= $arrayDrawRate[$childSn];
				$awayRate 	= $arrayAwayRate[$childSn];
				
				$gameDate = substr($date, 0, 10);
				$gameHour = substr($date, 11, 2);
				$gameTime = substr($date, 14, 2);

				//일반,스페셜,멀티,이벤트(4가지) 확인
				//0=일반, 1=스페셜, 2=멀티
				
				//핸디캡
				if($checkboxes[0]==1)
				{
					$gameModel->addChild('',$category,$leagueSn,$homeTeam,$awayTeam,$gameDate,$gameHour,$gameTime,'','null',2,0,$handicapHomeRate,'',$handicapAwayRate);
				}
				//언더오버
				if($checkboxes[1]==1)
				{				
					$gameModel->addChild('',$category,$leagueSn,$homeTeam,$awayTeam,$gameDate,$gameHour,$gameTime,'','null',4,0,$underoverHomeRate,'',$underoverAwayRate);
				}
				//핸디캡(스패셜)
				if($checkboxes[2]==1)
				{
					$gameModel->addChild('',$category,$leagueSn,$homeTeam,$awayTeam,$gameDate,$gameHour,$gameTime,'','null',2,1,$specialHandicapHomeRate,'',$specialHandicapAwayRate);
				}
				//언더오버(스패셜)
				if($checkboxes[3]==1)
				{
					$gameModel->addChild('',$category,$leagueSn,$homeTeam,$awayTeam,$gameDate,$gameHour,$gameTime,'','null',4,1,$specialUnderoverHomeRate,'',$specialUnderoverAwayRate);
				}
			}
			throw new Lemon_ScriptException("","","script","alert('복사되었습니다.');opener.document.location.reload(); self.close();");
		} // end of if($mode=="copy")
	
		if($selector=='league') {$keywordLeage = $keyword;}
		else if($selector=='home_team') {$keywordHomeTeam = $keyword;}
		else if($selector=='away_team') {$keywordAwayTeam = $keyword;}
		$list = $gameListModel->getCopyGameList($keywordCategory, $keywordLeage,  $keywordHomeTeam, $keywordAwayTeam, $beginDate, $endDate);
		$categoryList = $leagueModel->getCategoryList();
		
		$this->view->assign("begin_date",$beginDate);
		$this->view->assign("end_date",$endDate);
		$this->view->assign("keyword",$keyword);
		$this->view->assign("selector",$selector);
		$this->view->assign("keyword_category",$keywordCategory);
		$this->view->assign("category_list",$categoryList);
		$this->view->assign("list",$list);
		
		$this->display();
	}
	
	//▶ 유저의 배팅내역
	public function popup_betdetailAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/gameUpload/popup.bet_detail.html");
		
		$model 	= Lemon_Instance::getObject("GameModel", true);
		$cartModel = Lemon_Instance::getObject("CartModel", true);
		
		$betting_no = $this->request("betting_no");
		$member_sn = $this->request("member_sn");
		
		$list = $cartModel->getMemberBetDetailList($betting_no, $member_sn);
		
		$this->view->assign("list",$list);
		
	
		$this->display();
	}	
	
	//▶ 게임 디테일 항목
	public function popup_gamedetailAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/gameUpload/popup.game_detail.html");
		
		$model 	= Lemon_Instance::getObject("GameModel", true);
		$cartModel 	= Lemon_Instance::getObject("CartModel", true);
		
		
		$child_sn = $this->request("child_sn");
		
		$rs = $cartModel->getBetByChildSn($child_sn);
		
		$home_team = $rs[0]["home_team"];
		$away_team = $rs[0]["away_team"];		
	
		for( $i = 0; $i< count((array)$rs); ++$i )
		{
			$gameselect = $rs[$i]["select_no"];
			$game_type = $rs[$i]["game_type"];
			$money = $rs[$i]["bet_money"];
				
			if($game_type==1)
			{
				if($gameselect==1)
				{
					$home_bet_1=$home_bet_1+$money;
				}
				elseif($gameselect==2)
				{
					$away_bet_1=$away_bet_1+$money;
				}
				elseif($gameselect==3)
				{
					$draw_bet=$draw_bet_1+$money;
				}
			}
			else if($game_type==2)
			{
				if($gameselect==1) 			{$home_bet_2=$home_bet_2+$money;}
				elseif($gameselect==2)	{$away_bet_2=$away_bet_2+$money;}
			}
			elseif($game_type==4)
			{
				if($gameselect==1)
				{
					$home_bet_4=$home_bet_4+$money;
				}
				elseif($gameselect==2)
				{
					$away_bet_4=$away_bet_4+$money;
				}
			}
		}
		
		$line_1 = $home_bet_1 + $draw_bet + $away_bet_1;
		$line_2 = $home_bet_2 + $away_bet_2;
		$line_3 = $home_bet_3 + $away_bet_3;
		$line_4 = $home_bet_4 + $away_bet_4;

		$t_bet_1 = $home_bet_1 + $home_bet_2 + $home_bet_3 + $home_bet_4;
		$t_bet_2 = $away_bet_1 + $away_bet_2 + $away_bet_3 + $away_bet_4;

		$total = $line_1 + $line_2 + $line_3 + $line_4;
		
		$this->view->assign("home_team",$home_team);
		$this->view->assign("away_team",$away_team);
	
		$this->view->assign("home_bet_1",$home_bet_1);
		$this->view->assign("draw_bet",$draw_bet);
		$this->view->assign("away_bet_1",$away_bet_1);
		$this->view->assign("line_1",$line_1);
		
		$this->view->assign("home_bet_2",$home_bet_2);		
		$this->view->assign("away_bet_2",$away_bet_2);
		$this->view->assign("line_2",$line_2);
		
		$this->view->assign("home_bet_4",$home_bet_4);		
		$this->view->assign("away_bet_4",$away_bet_4);
		$this->view->assign("line_4",$line_2);
		
		
		$this->view->assign("t_bet_1",$t_bet_1);
		$this->view->assign("draw_bet",$draw_bet);
		$this->view->assign("t_bet_2",$t_bet_2);
		$this->view->assign("total",$total);
	
		$this->display();
	}

	//▶ 게임 디테일 항목 (다기준)
	public function popup_gamedetail_multiAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/gameUpload/popup.game_detail_multi.html");
		
		$model 	= Lemon_Instance::getObject("GameModel", true);
		$cartModel 	= Lemon_Instance::getObject("CartModel", true);
		
		
		$child_sn = $this->request("child_sn");
		
		$rs = $cartModel->getBetByChildSn($child_sn);
		
		$home_team = $rs[0]["home_team"];
		$away_team = $rs[0]["away_team"];		
	
		for( $i = 0; $i< count((array)$rs); ++$i )
		{
			$gameselect = $rs[$i]["select_no"];
			$game_type = $rs[$i]["game_type"];
			$money = $rs[$i]["bet_money"];
				
			if($game_type==1)
			{
				if($gameselect==1)
				{
					$home_bet_1=$home_bet_1+$money;
				}
				elseif($gameselect==2)
				{
					$away_bet_1=$away_bet_1+$money;
				}
				elseif($gameselect==3)
				{
					$draw_bet=$draw_bet_1+$money;
				}
			}
			else if($game_type==2)
			{
				if($gameselect==1) 			{$home_bet_2=$home_bet_2+$money;}
				elseif($gameselect==2)	{$away_bet_2=$away_bet_2+$money;}
			}
			elseif($game_type==4)
			{
				if($gameselect==1)
				{
					$home_bet_4=$home_bet_4+$money;
				}
				elseif($gameselect==2)
				{
					$away_bet_4=$away_bet_4+$money;
				}
			}
		}
		
		$line_1 = $home_bet_1 + $draw_bet + $away_bet_1;
		$line_2 = $home_bet_2 + $away_bet_2;
		$line_3 = $home_bet_3 + $away_bet_3;
		$line_4 = $home_bet_4 + $away_bet_4;

		$t_bet_1 = $home_bet_1 + $home_bet_2 + $home_bet_3 + $home_bet_4;
		$t_bet_2 = $away_bet_1 + $away_bet_2 + $away_bet_3 + $away_bet_4;

		$total = $line_1 + $line_2 + $line_3 + $line_4;
		
		$this->view->assign("home_team",$home_team);
		$this->view->assign("away_team",$away_team);
	
		$this->view->assign("home_bet_1",$home_bet_1);
		$this->view->assign("draw_bet",$draw_bet);
		$this->view->assign("away_bet_1",$away_bet_1);
		$this->view->assign("line_1",$line_1);
		
		$this->view->assign("home_bet_2",$home_bet_2);		
		$this->view->assign("away_bet_2",$away_bet_2);
		$this->view->assign("line_2",$line_2);
		
		$this->view->assign("home_bet_4",$home_bet_4);		
		$this->view->assign("away_bet_4",$away_bet_4);
		$this->view->assign("line_4",$line_2);
		
		
		$this->view->assign("t_bet_1",$t_bet_1);
		$this->view->assign("draw_bet",$draw_bet);
		$this->view->assign("t_bet_2",$t_bet_2);
		$this->view->assign("total",$total);
	
		$this->display();
	}
	
	//▶ 새회차 등록
	public function popup_addparentAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/gameUpload/popup.add_parent.html");
		
		$model  = $this->getModel("GameModel");
		
		$parentIdx 	= $this->request("intParentIdx");
		$gameType 	= $this->request("strGameType");
		$mode 		= $this->request("mode");
		
		if($parentIdx!="")
		{
			$item = $model->getParentRow($parentIdx);
			
			$minBetPrice = $item['intMinBetPrice'];
			$maxBetPrice = $item['intMaxBetPrice'];
			$maxBetPrice = 3000000; 
			$gameEndTime = $item['strGameEndTime'];
			$gameDate	 = substr($gameEndTime,0,10);
			$temp		 = explode(":",(substr($gameEndTime,11)));
			$gameHour	 = Trim($temp[0]);
			$gameMin	 = Trim($temp[1]);
		}
		else
		{
			$lastIdx 	 = $model->getLastParentIdx();
			$parentIdx 	 = $lastIdx+1;
			$minBetPrice = 5000;
			$maxBetPrice = 3000000; 
		}
		
		$hours = array();
		for($i=0; $i<24; ++$i)
		{
			if($i<10) 	{$hour = '0'.$i;}
			else		{$hour = $i;}
			$hours[] = $hour;
		}
		
		$mins = array();
		for($i=0; $i<60; ++$i)
		{
			if($i<10) 	$min = '0'.$i;
			else		$min = $i;
			
			$mins[] = $min;
		}
		
		$this->view->assign("minBetPrice",$minBetPrice);
		$this->view->assign("maxBetPrice",$maxBetPrice);
		$this->view->assign("gameDate",$gameDate);
		$this->view->assign("gameHour",$gameHour);
		$this->view->assign("gameMin",$gameMin);
		$this->view->assign("hours",$hours);
		$this->view->assign("mins" ,$mins);
		$this->view->assign("mode",$mode);
		$this->view->assign("gameType",$gameType);
		$this->view->assign("parentIdx",$parentIdx);
		
		$this->display();
	}
	
	//▶ 새회차 등록
	public function addparentProcessAction()
	{
		$model  = $this->getModel("GameModel");
		
		$parentIdx 			= $this->request("intParentIdx");
		$gameEndTime 		= $this->request("strGameEndTime1") . " " . $this->request("strGameEndTime2") . ":" . $this->request("strGameEndTime3");
		$strGameType 		= $this->request("strGameType");
		$intMinBetPrice 	= $this->request("intMinBetPrice");
		$intMinBetPrice		= str_replace(",","",$intMinBetPrice);
		$intMaxBetPrice 	= $this->request("intMaxBetPrice");
		$intMaxBetPrice 	= str_replace(",","",$intMaxBetPrice);
		$intOverPrice 		= $this->request("intOverPrice");
		$backUrl 			= $this->request("backUrl");
		
		if(!preg_match('/^\d*$/',$intMaxBetPrice))
		{
			throw new Lemon_ScriptException("최소 배팅금액에 문제가 있습니다.");
			exit;
		}
		if(!preg_match('/^\d*$/',$intMinBetPrice))
		{
			throw new Lemon_ScriptException("최대 배당금액에 문제가 있습니다.");			
			exit;
		}
		
		if(is_null($intOverPrice) or $intOverPrice=="") 	{$intOverPrice = 0;}
		if(is_null($intMaxBetPrice) or $intMaxBetPrice=="")	{$intMaxBetPrice = 0;}
		$mode = Trim($this->request("mode"));
	
		if($mode == "add")
		{
			$rs = $model->addParent($gameEndTime, $intMinBetPrice, $intMaxBetPrice, $intOverPrice);
			
			if($rs>0) 	{throw new Lemon_ScriptException("","","script","alert('새 회차가 등록 되었습니다');opener.document.location.reload(); self.close();");}
			else		{throw new Lemon_ScriptException("","","script","alert('추가 실패 하였습니다!');opener.document.location.reload(); self.close();");}		
		}
		else
		{
			$rs = $model->modifyParent($parentIdx, $gameEndTime, $intMinBetPrice, $intMaxBetPrice, $intOverPrice);
			if($rs>0)	{throw new Lemon_ScriptException("","","script","alert('수정되었습니다.');opener.document.location.reload(); self.close();");}
			else		{throw new Lemon_ScriptException("","","script","alert('수정 실패 하였습니다!');opener.document.location.reload(); self.close();");}
		}
	}

	// story188 데이터수집
    public function collectStory188Action()
    {
        $this->popupDefine();

        if(!$this->auth->isLogin())
        {
            $this->loginAction();
            exit;
        }
        $this->view->define("content","content/gameUpload/collect_story188.html");

        $model 	= $this->getModel("GameModel");
        $cartModel = $this->getModel("CollectModel");
        $leagueModel = $this->getModel("LeagueModel");

        $bianliang1 = $this->request("bianliang1");
        if($bianliang1=="")	{$bianliang1="0.00";}

        $bianliang2 = $this->request("bianliang2");
        if($bianliang2=="")	{$bianliang2="0.00";}

        $bianliang3 = $this->request("bianliang3");
        if($bianliang3=="")	{$bianliang3="0.00";}


        $strTime1 	= $this->request("strtime1");
        if($strTime1=="") $strTime1=date('Y-m-d');
        $mode 		= $this->request("mode");

        //$category = $this->getCategoryName("AFC CL-[축구]");
        // story188로 부터 경기자료 스크래핑
        $gameList = $this->crawlingStory188();


        $lastCollectTime="";
        $rs = $cartModel->getLastDate("collect_date");
        $total = count((array)$rs);
        if($total>0) {$lastCollectTime = $rs[0]["collect_date"];}

        $list = $cartModel->getList("", "game_date");

        /*$this->view->assign("mode",$mode);
        $this->view->assign("bianliang1",$bianliang1);
        $this->view->assign("bianliang2",$bianliang2);
        $this->view->assign("bianliang3",$bianliang3);
        $this->view->assign("total",$total);
        $this->view->assign("strTime1",$strTime1);
        $this->view->assign("lastCollectTime",$lastCollectTime);*/
        $this->view->assign("searchList",$gameList);
        $this->display();
    }

    public function crawlingStory188()
	{
		require("snoopy.php");
        require("simple_html_dom.php");

        $cartModel = $this->getModel("CollectModel");

        $loginActionUrl = "http://www.story188.com/login/Login_Proc.asp";
        $loginInfo = array("IU_ID" => "qq38", "IU_PW" => "qq1234", "url" => "main.asp", "connect" => "connect1");

        $snoopy = new snoopy;
        $snoopy->httpmethod = "POST";
        $snoopy->referer = "http://www.story188.com/";
        $snoopy->agent = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36";
        $snoopy->headers[] = "Accept-Language:ko-KR,ko;q=0.8,en-US;q=0.6,en;q=0.4";
        $snoopy->submit($loginActionUrl,$loginInfo);
        $snoopy->setcookies();

        $parsingUrl = array(
            "smp"=>"http://www.story188.com/game/BetGame.asp?game_type=SMP",
            "handicap"=>"http://www.story188.com/game/BetGame.asp?game_type=Handicap"
        );

        $gameList = array();
        $idx = 1;
        foreach ( $parsingUrl as $key => $url ) {
            $snoopy->fetch($url);

            if(strlen($snoopy->results) < 500)
            {
                if(strpos($snoopy->results, 'location.href = "/login/Logout_Proc.asp"', 0) > 0)
                {
                    $snoopy = login();
                    $snoopy->submit($url);
                }
            }

			$html = $this->del_script($snoopy->results);

            $dataTemp = explode('id="tblGameList" >',$html);
            if(count($dataTemp) > 1)
            {
                $dataTemp = explode("</table>
                        </td>
	                </tr>
	                </table>
                </td>
                
                <td width=\"246\" background=\"/img/fire/images/s_b_bg.jpg\">",$dataTemp[1]);
            }

            $html = "<table id='tblGameList'><tbody>".$dataTemp[0]."</tbody></table>";
			$html = str_replace('&nbsp;', '', $html);
            $html = str_get_html($html);

			$trList = $html->find('table[id=tblGameList] table table', 1)->find('tr');

            $game = array();
            $league = array();

			foreach ($trList as $tr)
			{
				$tdList = $tr->find('td');
				$td_count = count($tdList);
				
				if($td_count == 1) // League 정보
				{
					$leagueNm = $tdList[0]->find('span', 0)->innertext;
                    $leagueNm = iconv("euc-kr","utf-8", trim(strip_tags($leagueNm)));

                    $league = array();
                    $league['league_name'] = $leagueNm;
                    $league['lg_img'] = $tdList[0]->find('span img', 0)->src;
				}
				else if($td_count == 10) // 상세게임정보
				{
					$game_status = $tdList[8]->find('img', 0)->src;
					if($game_status == "/img/sub/icon_end.gif")
						continue;


					$game['idx'] = $idx;
                    $game['category'] = $this->getCategoryName($league['league_name']);
                    $game['league_name'] = $this->getLeagueName($league['league_name']);

                    if(strpos($game['league_name'], '이벤트', 0) > 0)
                    	continue;

                    $game['lg_img'] = $league['lg_img'];
                    $gameTime = trim(strip_tags($tdList[0]->innertext));
                   /* $game["game_date"] = date("Y") . '-' . substr($gameTime, 0, 5);
                    $game["game_hours"] = substr($gameTime, 10, 2);
                    $game["game_minute"] = substr($gameTime, 13, 2);*/

                    $gameStartDateTemp = date("Y",time())."-".trim(str_replace("/","-",strip_tags(str_replace("&nbsp;&nbsp;"," ",$gameTime))));
                    $gameStartDateTemp = explode(" ",$gameStartDateTemp);
                    $gameStartTimeTemp = explode(":",$gameStartDateTemp[1]);
                    $game["game_hours"] = $gameStartTimeTemp[0];
                    $game["game_minute"] = $gameStartTimeTemp[1];
                    $gameStartDateTemp = explode("(",$gameStartDateTemp[0]);
                    $game["game_date"] = $gameStartDateTemp[0];

                    $game['team1_name'] = iconv("euc-kr","utf-8", trim(strip_tags($tdList[2]->innertext)));
                    $game['a_rate1'] = trim(strip_tags($tdList[3]->innertext));
                    $game['a_rate2'] = trim(strip_tags($tdList[4]->innertext));
                    if( $game['a_rate2'] == 'VS')
					{
						if($key == 'smp')
							$game['a_rate2'] = "1";
						else
                            $game['a_rate2'] = "0";
					}

                    $game['a_rate3'] = trim(strip_tags($tdList[6]->innertext));
                    $game['b_rate1'] = 0;
                    $game['b_rate2'] = 0;
                    $game['b_rate3'] = 0;
                    $game["rate_flag"]=$game["b_rate1"]*$game["b_rate1"]*$game["b_rate1"];
                    $game['team2_name'] = iconv("euc-kr","utf-8", trim(strip_tags($tdList[7]->innertext)));

                    if($key == 'smp') // 일반
					{
                        $game['gametype'] = 0;
                        $game['gametype_name'] = '일반';
					}
                    else
                    {
						$m_rate2 = (int)$game['a_rate2'];
						$str_rate1 = $tdList[3]->innertext;
						if(strpos($tdList[3]->innertext, '/image/up.gif', 0) > 0) // 오버언더
						{
                            $game['gametype'] = 4;
                            $game['gametype_name'] = '오버언더';
						}
						else   // 핸디캡
						{
                            $game['gametype'] = 2;
                            $game['gametype_name'] = '핸디캡';
						}
                    }

                    if($this->IsNewGame($game))
                    {
                        $gameList[] = $game;
                        $game = array();
                        $idx++;
                    }
				}
			}
        }

		return $gameList;
	}

	public function IsNewGame($newGame)
	{
		$result = true;
        $leagueModel = $this->getModel("LeagueModel");
        $gameModel = $this->getModel("GameModel");

        if ( !$newGame['league_name'] or $newGame['a_rate1'] == 0 or $newGame['a_rate3'] == 0 ) return false;

        $leagueData = $leagueModel->getLeagueDataByName($newGame['league_name']);

        if ( !is_array($leagueData) ) {
            /*$kind = "미분류";
            $param = array('kind' => $kind, 'name' => $newGame['league_name'], 'nation_sn' => 0);
            $leagueUid = $db->insert("tb_league", $param);*/

        } else {
            $kind = $leagueData['kind'];
            $leagueUid = $leagueData['sn'];
        }

        if ( strcmp($newGame['team1_name'],"") and strcmp($newGame['team2_name'],"") and strcmp($newGame['gametype'],"") ) {
            $hDate = date("Y-m-d H:i:s",(time()-18000));

            if($newGame['gametype'] == 0)
                $newGame['gametype'] = 1;

            $checkRowData = $gameModel->getGameInfo($leagueUid, $newGame['team1_name'], $newGame['team2_name'],
                $newGame['gametype'], 0);

            if ( !is_array($checkRowData) ) {
                return true;
            }
            else
                return false;
        }
        return $result;
	}

    public function uploadStory188Action()
    {
        $this->popupDefine();

        if(!$this->auth->isLogin())
        {
            $this->loginAction();
            exit;
        }
        $this->view->define("content","content/gameUpload/upload7m.html");
        $model 	= $this->getModel("GameModel");
        $leagueModel = $this->getModel("LeagueModel");

        $gameType    = $this->request("gametype");
        $idx         = $this->request("idx");
        $lg_img    = $this->request("lg_img");
        $game_num    = $this->request("game_num");
        $kubun       = $this->request("kubun");
        $category    = $this->request("category");
        $league_num  = $this->request("league_num");
        $league_name = $this->request("league_name");
        $game_date   = $this->request("game_date");
        $game_hours  = $this->request("game_hours");
        $game_minute = $this->request("game_minute");
        $game_second = $this->request("game_second");
        $team1_name  = $this->request("team1_name");
        $a_rate1     = $this->request("a_rate1");
        $a_rate2     = $this->request("a_rate2");
        $a_rate3     = $this->request("a_rate3");
        $b_rate1     = $this->request("b_rate1");
        $b_rate2     = $this->request("b_rate2");
        $b_rate3     = $this->request("b_rate3");
        $c_rate1     = $this->request("c_rate1");
        $c_rate2     = $this->request("c_rate2");
        $c_rate3     = $this->request("c_rate3");
        $team2_name  = $this->request("team2_name");
        $chk_idx     = $this->request("chk_idx");

		$arr_select_rate=array();
        $isrep=true;
        /*
        switch($gameType)
        {
            case 1: $type=1; $special=0; break;
            case 2: $type=2; $special=0; break;
            case 4: $type=4; $special=0; break;
            case 6: $type=1; $special=1; break;
            case 7: $type=2; $special=1; break;
            case 8: $type=4; $special=1; break;
        }
        */


        /*for($i=0;$i<count($idx);$i++)
        {
            $arr_select_rate[$i] = $this->request("radio_".trim($idx[$i]));
        }*/

        for($i=0;$i<count($idx);$i++)
        {
            $idx_temp         = Trim($idx[$i]);
            $game_num_temp    = Trim($game_num[$i]);
            $league_num_temp  = Trim($league_num[$i]);

            $game_type_temp = Trim($gameType[$i]);
            $league_name_temp = Trim($league_name[$i]);
            $game_date_temp   = Trim($game_date[$i]);
            $game_hours_temp  = Trim($game_hours[$i]);
            $game_minute_temp = Trim($game_minute[$i]);
            $lg_img_temp = Trim($lg_img[$i]);

            $category_temp = Trim($category[$i]);
            $league_name_temp = Trim($league_name[$i]);

            $team1_name_temp  = Trim($team1_name[$i]);
            $team1_name_temp  = str_replace("'","",$team1_name_temp);
            $a_rate1_temp     = Trim($a_rate1[$i]);
            $a_rate2_temp     = Trim($a_rate2[$i]);
            $a_rate3_temp     = Trim($a_rate3[$i]);
            /*$b_rate1_temp     = Trim($b_rate1[$i]);
            $b_rate2_temp     = Trim($b_rate2[$i]);
            $b_rate3_temp     = Trim($b_rate3[$i]);
            $c_rate1_temp     = Trim($c_rate1[$i]);
            $c_rate2_temp     = Trim($c_rate2[$i]);
            $c_rate3_temp     = Trim($c_rate3[$i]);*/
            $team2_name_temp  = Trim($team2_name[$i]);
            $team2_name_temp  = str_replace("'","",$team2_name_temp);

            $select_rate_temp = Trim($arr_select_rate[$i]);

            $rate1_temp = $a_rate1_temp;
            $rate2_temp = $a_rate2_temp;
            $rate3_temp = $a_rate3_temp;

            $leagueSn = "";
            if($category_temp == null || $category_temp == '')
                $category_temp = '미분류';

            if($this->find_array_str($chk_idx, $idx_temp))
            {
                $where = "kind='".$category_temp ."'";
                $where .= " AND name='".$league_name_temp ."'";
                $rs = $leagueModel->getListAll($where);

                if(count((array)$rs) > 0)
                {
                    $leagueName 	= $rs[0]["name"];
                    $leagueSn 		= $rs[0]["sn"];
                }
                else
                {
                    //등록된 리그가 없다면, 별칭을 검색한다.
                    $where = "kind='".$category_temp ."'";
                    $where .= " AND alias_name='".$league_name_temp ."'";
                    $rs = $leagueModel->getListAll($where);
                    if(count((array)$rs) > 0)
                    {
                        $leagueName 	= $rs[0]["name"];
                        $leagueSn 		= $rs[0]["sn"];
                    }
                    else
                    {
                        //$message .= "\\n".$league_name_temp;
                        $leagueSn = $leagueModel->add2($category_temp, $league_name_temp, $lg_img_temp, '');
                    }
                }

                $parentIdx = 0;
                if($kubun=="") {$kubun='null';}
                if($leagueSn!="")
                    if($game_type_temp == '0')
                    {
                        $model->addChild_with_parsing_type($parentIdx, $category_temp,$leagueSn,$team1_name_temp,$team2_name_temp,$game_date_temp,$game_hours_temp,$game_minute_temp,'',$kubun,1,0,$rate1_temp,$rate2_temp,$rate3_temp, 'S');
                        //$model->addChild($parentIdx,"축구",$leagueSn,$team1_name_temp,$team2_name_temp,$game_date_temp,$game_hours_temp,$game_minute_temp,'',$kubun,2,0,'1.85','','1.85');
                        //$model->addChild($parentIdx,"축구",$leagueSn,$team1_name_temp,$team2_name_temp,$game_date_temp,$game_hours_temp,$game_minute_temp,'',$kubun,4,0,'1.85','','1.85');
                    }
					if($game_type_temp == '2')
					{
						$model->addChild_with_parsing_type($parentIdx, $category_temp,$leagueSn,$team1_name_temp,$team2_name_temp,$game_date_temp,$game_hours_temp,$game_minute_temp,'',$kubun,2,0,$rate1_temp,$rate2_temp,$rate3_temp, 'S');
						//$model->addChild($parentIdx,"축구",$leagueSn,$team1_name_temp,$team2_name_temp,$game_date_temp,$game_hours_temp,$game_minute_temp,'',$kubun,1,2,$rate1_temp,$rate2_temp,$rate3_temp);
						//$model->addChild($parentIdx,"축구",$leagueSn,$team1_name_temp,$team2_name_temp,$game_date_temp,$game_hours_temp,$game_minute_temp,'',$kubun,2,2,'1.85','','1.85');
						//$model->addChild($parentIdx,"축구",$leagueSn,$team1_name_temp,$team2_name_temp,$game_date_temp,$game_hours_temp,$game_minute_temp,'',$kubun,4,2,'1.85','','1.85');
					}
					if($game_type_temp == '4')
					{
						$model->addChild_with_parsing_type($parentIdx, $category_temp, $leagueSn,$team1_name_temp,$team2_name_temp,$game_date_temp,$game_hours_temp,$game_minute_temp,'',$kubun,4,0,$rate1_temp,$rate2_temp,$rate3_temp, 'S');
						//$model->addChild($parentIdx,"축구",$leagueSn,$team1_name_temp,$team2_name_temp,$game_date_temp,$game_hours_temp,$game_minute_temp,'',$kubun,1,1,$rate1_temp,$rate2_temp,$rate3_temp);
						//$model->addChild($parentIdx,"축구",$leagueSn,$team1_name_temp,$team2_name_temp,$game_date_temp,$game_hours_temp,$game_minute_temp,'',$kubun,2,1,'1.85','','1.85');
						//$model->addChild($parentIdx,"축구",$leagueSn,$team1_name_temp,$team2_name_temp,$game_date_temp,$game_hours_temp,$game_minute_temp,'',$kubun,4,1,'1.85','','1.85');
					}
            }
        }

        /*if($message!="")
        {
            throw new Lemon_ScriptException("","","script","alert('등록되지 않은 리그".$message."');opener.document.location.reload();");
        }*/

        $this->display();
    }

    public function getCategoryName($league_full_name)
	{
		$first_pos = strpos($league_full_name, '-[');
		$len = strlen($league_full_name);
		$categoryNm = substr($league_full_name, $first_pos + 2, $len - $first_pos - 3);
		return $categoryNm; //iconv("euc-kr","utf-8", trim(strip_tags($categoryNm)));
	}

	public function getLeagueName($league_full_name)
	{
        $first_pos = strpos($league_full_name, '-[');
        $leagureNam = substr($league_full_name, 0, $first_pos);
        return $leagureNam; //iconv("euc-kr","utf-8", trim(strip_tags($leagureNam)));
	}

    public function del_script($html) {
        $html = explode("<script",$html);
        $addHtml[] = $html[0];
        for ( $i = 0 ; $i < count($html) ; $i++ ) {
            $temp = explode("</script>",$html[$i]);
            if ( count($temp) == 2 ) {
                if ( strlen(trim($temp[1])) > 0 ) {
                    $addHtml[] = $temp[1];
                }
            }
        }
        return implode(" ",$addHtml);
    }

	//▶ 데이터 수집
	public function collect7mAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/gameUpload/collect7m.html");
		
		$model 	= $this->getModel("GameModel");
		$cartModel = $this->getModel("CollectModel");
		$leagueModel = $this->getModel("LeagueModel");

		$bianliang1 = $this->request("bianliang1");
		if($bianliang1=="")	{$bianliang1="0.00";}
		
		$bianliang2 = $this->request("bianliang2");
		if($bianliang2=="")	{$bianliang2="0.00";}
		
		$bianliang3 = $this->request("bianliang3");
		if($bianliang3=="")	{$bianliang3="0.00";}
	
		
		$strTime1 	= $this->request("strtime1");
		if($strTime1=="") $strTime1=date('Y-m-d');
		$mode 		= $this->request("mode");
	
		if($mode=="collect")
		{
			//$url="http://1x2.7m.cn/data/index_kr.js";
			$url="http://1x2.7m.cn/data/company/kr/66.js";
			$domain = "1x2.7m.cn";
			//$strst		= $this->get_fsock_data($domain,"/data/index_kr.js");
			$strst		= $this->get_fsock_data($domain,"/data/company/kr/66.js");

			$var1		= strpos($strst,"[")."<br>";
			$var2		= strrpos($strst,"]")."<br>";
			$var		= $var2-$var1."<br>";
			$content	= substr($strst,$var1+1,$var-1);
			$arrContent	= explode('"',$content);
			$cartModel->del();
			$rs = $leagueModel->getListAll();

			$leagueList="";

			for($i=0; $i<count((array)$rs); ++$i)
			{
				$leagueList.= $rs[$i]["name"];
			}

			for($i=1;$i<count((array)$arrContent);$i=$i+2)
			{
				$arrSubContent = explode("|",$arrContent[$i]);

				$arrTempDate = explode("," ,$arrSubContent[1]);
				$gameDate=date("Y-m-d H:i:s",mktime(trim($arrTempDate[3])+1,trim($arrTempDate[4]),trim($arrTempDate[5]),trim($arrTempDate[1]),trim($arrTempDate[2]),$arrTempDate[0]));

				$b_rate1=0;
				$b_rate2=0;
				$b_rate3=0;
				$strHomeName="";
				if(Trim($arrSubContent[11])!="")	{$b_rate1=Trim($arrSubContent[11]);}
				if(Trim($arrSubContent[12])!="")	{$b_rate2=Trim($arrSubContent[12]);}
				if(Trim($arrSubContent[13])!="")	{$b_rate3=Trim($arrSubContent[13]);}
				if(Trim($arrSubContent[14])==1)		{$strHomeName="(N)";}

				$cartModel->add($gameDate, $arrSubContent, $b_rate1, $b_rate2, $b_rate3);
			}
		}
		else if($mode=="search")
		{
			$searchList = $cartModel->getList("game_date='".$strTime1."'");

			$strDay=date('w',strtotime($strTime1));
			switch($strDay)
			{
				case 0: $week = "(일)";break;
				case 1: $week = "(월)";break;
				case 2: $week = "(화)";break;
				case 3: $week = "(수)";break;
				case 4: $week = "(목)";break;
				case 5: $week = "(금)";break;
				case 6: $week = "(토)";break;
			}
			$this->view->assign("searchList",$searchList);
			$this->view->assign("week",$week);
		}
		
		$lastCollectTime="";
		$rs = $cartModel->getLastDate("collect_date"); 
		$total = count((array)$rs);
		if($total>0) {$lastCollectTime = $rs[0]["collect_date"];}
		
		$list = $cartModel->getList("", "game_date");
	
		$this->view->assign("mode",$mode);
		$this->view->assign("bianliang1",$bianliang1);		
		$this->view->assign("bianliang2",$bianliang2);		
		$this->view->assign("bianliang3",$bianliang3);		
		$this->view->assign("total",$total);
		$this->view->assign("strTime1",$strTime1);
		$this->view->assign("lastCollectTime",$lastCollectTime);
		$this->view->assign("list",$list);
		$this->display();
	}

	//▶ 데이터 수집
	public function upload7mAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/gameUpload/upload7m.html");
		$model 	= $this->getModel("GameModel");
		$leagueModel = $this->getModel("LeagueModel");
		
		$gameType    = $this->request("gametype");
		$idx         = $this->request("idx");
		$game_num    = $this->request("game_num");
		$kubun       = $this->request("kubun");
		$league_num  = $this->request("league_num");
		$league_name = $this->request("league_name");
		$game_date   = $this->request("game_date");
		$game_hours  = $this->request("game_hours");
		$game_minute = $this->request("game_minute");
		$game_second = $this->request("game_second");
		$team1_name  = $this->request("team1_name");
		$a_rate1     = $this->request("a_rate1");
		$a_rate2     = $this->request("a_rate2");
		$a_rate3     = $this->request("a_rate3");
		$b_rate1     = $this->request("b_rate1");
		$b_rate2     = $this->request("b_rate2");
		$b_rate3     = $this->request("b_rate3");
		$c_rate1     = $this->request("c_rate1");
		$c_rate2     = $this->request("c_rate2");
		$c_rate3     = $this->request("c_rate3");
		$team2_name  = $this->request("team2_name");
		$chk_idx     = $this->request("chk_idx");
		
		$arr_select_rate=array();
		$isrep=true;
		/*
		switch($gameType)
		{
			case 1: $type=1; $special=0; break;
			case 2: $type=2; $special=0; break;
			case 4: $type=4; $special=0; break;
			case 6: $type=1; $special=1; break;
			case 7: $type=2; $special=1; break;
			case 8: $type=4; $special=1; break;
		}
		*/

		
		for($i=0;$i<count($idx);$i++)
		{
			$arr_select_rate[$i] = $this->request("radio_".trim($idx[$i]));
		}
		
		for($i=0;$i<count($idx);$i++)
		{
			$idx_temp         = Trim($idx[$i]);
			$game_num_temp    = Trim($game_num[$i]);
			$league_num_temp  = Trim($league_num[$i]);
			$league_name_temp = Trim($league_name[$i]);
			$game_date_temp   = Trim($game_date[$i]);
			$game_hours_temp  = Trim($game_hours[$i]);
			$game_minute_temp = Trim($game_minute[$i]);
	
			$team1_name_temp  = Trim($team1_name[$i]);
			$team1_name_temp  = str_replace("'","",$team1_name_temp);
			$a_rate1_temp     = Trim($a_rate1[$i]);
			$a_rate2_temp     = Trim($a_rate2[$i]);
			$a_rate3_temp     = Trim($a_rate3[$i]);
			$b_rate1_temp     = Trim($b_rate1[$i]);
			$b_rate2_temp     = Trim($b_rate2[$i]);
			$b_rate3_temp     = Trim($b_rate3[$i]);
			$c_rate1_temp     = Trim($c_rate1[$i]);
			$c_rate2_temp     = Trim($c_rate2[$i]);
			$c_rate3_temp     = Trim($c_rate3[$i]);
			$team2_name_temp  = Trim($team2_name[$i]);
			$team2_name_temp  = str_replace("'","",$team2_name_temp);
	
			$select_rate_temp = Trim($arr_select_rate[$i]);
			
			if($select_rate_temp==1)
			{
				$rate1_temp = $a_rate1_temp;
				$rate2_temp = $a_rate2_temp;
				$rate3_temp = $a_rate3_temp;
			}
			else if($select_rate_temp==2)
			{
				$rate1_temp = $b_rate1_temp;
				$rate2_temp = $b_rate2_temp;
				$rate3_temp = $b_rate3_temp;
			}
			else if($select_rate_temp==3)
			{
				$rate1_temp = $c_rate1_temp;
				$rate2_temp = $c_rate2_temp;
				$rate3_temp = $c_rate3_temp;
			}

			$leagueSn = "";
			if($this->find_array_str($chk_idx, $idx_temp))
			{
				$where = "name='".$league_name_temp ."'";
				$rs = $leagueModel->getListAll($where);
				
				if(count((array)$rs) > 0)
				{
					$leagueName 	= $rs[0]["name"];
					$leagueSn 		= $rs[0]["sn"];
				}
				else
				{
					//등록된 리그가 없다면, 별칭을 검색한다.
					$where = "alias_name='".$league_name_temp ."'";
					$rs = $leagueModel->getListAll($where);
					if(count((array)$rs) > 0)
					{
						$leagueName 	= $rs[0]["name"];
						$leagueSn 		= $rs[0]["sn"];
					}
					else
					{
						$message .= "\\n".$league_name_temp;
					}
				}
				
				if($kubun=="") {$kubun='null';}
				if($leagueSn!="")
					if(in_array('0', $gameType))
					{
						$model->addChild($parentIdx,"축구",$leagueSn,$team1_name_temp,$team2_name_temp,$game_date_temp,$game_hours_temp,$game_minute_temp,'',$kubun,1,0,$rate1_temp,$rate2_temp,$rate3_temp);
						//$model->addChild($parentIdx,"축구",$leagueSn,$team1_name_temp,$team2_name_temp,$game_date_temp,$game_hours_temp,$game_minute_temp,'',$kubun,2,0,'1.85','','1.85');
						//$model->addChild($parentIdx,"축구",$leagueSn,$team1_name_temp,$team2_name_temp,$game_date_temp,$game_hours_temp,$game_minute_temp,'',$kubun,4,0,'1.85','','1.85');
					}
					if(in_array('2', $gameType))
					{
						$model->addChild($parentIdx,"축구",$leagueSn,$team1_name_temp,$team2_name_temp,$game_date_temp,$game_hours_temp,$game_minute_temp,'',$kubun,2,0,'1.86','','1.86');
						//$model->addChild($parentIdx,"축구",$leagueSn,$team1_name_temp,$team2_name_temp,$game_date_temp,$game_hours_temp,$game_minute_temp,'',$kubun,1,2,$rate1_temp,$rate2_temp,$rate3_temp);
						//$model->addChild($parentIdx,"축구",$leagueSn,$team1_name_temp,$team2_name_temp,$game_date_temp,$game_hours_temp,$game_minute_temp,'',$kubun,2,2,'1.85','','1.85');
						//$model->addChild($parentIdx,"축구",$leagueSn,$team1_name_temp,$team2_name_temp,$game_date_temp,$game_hours_temp,$game_minute_temp,'',$kubun,4,2,'1.85','','1.85');
					}
					if(in_array('4', $gameType))
					{
						$model->addChild($parentIdx,"축구",$leagueSn,$team1_name_temp,$team2_name_temp,$game_date_temp,$game_hours_temp,$game_minute_temp,'',$kubun,4,0,'1.86','','1.86');
						//$model->addChild($parentIdx,"축구",$leagueSn,$team1_name_temp,$team2_name_temp,$game_date_temp,$game_hours_temp,$game_minute_temp,'',$kubun,1,1,$rate1_temp,$rate2_temp,$rate3_temp);
						//$model->addChild($parentIdx,"축구",$leagueSn,$team1_name_temp,$team2_name_temp,$game_date_temp,$game_hours_temp,$game_minute_temp,'',$kubun,2,1,'1.85','','1.85');
						//$model->addChild($parentIdx,"축구",$leagueSn,$team1_name_temp,$team2_name_temp,$game_date_temp,$game_hours_temp,$game_minute_temp,'',$kubun,4,1,'1.85','','1.85');
					}
				}
			}
		
		if($message!="")
		{
			throw new Lemon_ScriptException("","","script","alert('등록되지 않은 리그".$message."');opener.document.location.reload();");		
		}
		
		$this->display();
	}
	
	//▶ 배당 수정
	function modifyrateAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/gameUpload/popup.modify_rate.html");
		$model = $this->getModel("GameModel");
		
		$idx 	= $this->request("idx");		
		$gametype 	= $this->request("gametype");
		$mode 	= $this->request("mode");
		
		if($mode == "") {$mode = "add";}
			
		$item = $model->getChildRow($idx);
		$leagueName = $model->getRow('name', $model->db_qz.'league', 'sn='.$item["league_sn"]);
		$item['league_name']=$leagueName['name'];	
		
		$rs = $model->getSubChildRows($idx);
		if(count((array)$rs) > 0)
		{
			$home_rate = $rs[0]['home_rate'];
			$draw_rate = $rs[0]['draw_rate'];
			$away_rate = $rs[0]['away_rate'];
		}
	
		$strMode	= "";
		$html 		= "";
		//$add		= "onkeyup='this.value=this.value.replace(/[^0-9.]/gi,\"\")'";
		$add		= "'";
		if($gametype==1)
		{
			if($mode=="update") {$strMode="disabled";}
			$html="<td bgcolor='#ffffff' align='left'>";
			$html=$html."&nbsp;&nbsp;승<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
			$html=$html."&nbsp;무<input type='text' name='draw_rate' size='4' value='".$draw_rate."' ".$add.">";
			$html=$html."&nbsp;패<input type='text' name='away_rate' size='4' value='".$away_rate."' ".$add.">";
			$html=$html."&nbsp;&nbsp;<FONT color=#006699>&#8226; 승/패경기일때는 무승부에 1.00 을 넣으세요 </font></td>" ;
		}
		elseif($gametype==2)
		{
			if($mode=="edit") {$strMode="disabled";}
			$html="<td bgcolor='#ffffff' align='left'>";
			$html=$html."&nbsp;&nbsp;홈배당<input type='text' name='home_rate' size='4' value='".$home_rate ."' ".$add.">";
			$html=$html."&nbsp;홈핸디<input type='text' name='draw_rate' size='4' value='".$draw_rate ."' >";
			$html=$html."&nbsp;원정팀배당<input type='text' name='away_rate' size='4' value='".$away_rate ."' ".$add.">";
			$html=$html."&nbsp;&nbsp;</td>";
		}
		elseif($gametype==4)
		{
			if($mode=="edit") {$strMode="disabled";}
			$html="<td bgcolor='#ffffff' align='left'>";
			$html=$html."&nbsp;&nbsp;오버<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
			$html=$html."&nbsp;기준점수<input type='text' name='draw_rate' size='4' value='".$draw_rate."' >";
			$html=$html."&nbsp;언더<input type='text' name='away_rate' size='4' value='".$away_rate."' ".$add.">";
			$html=$html."&nbsp;&nbsp;</td>";
		}
		
		$this->view->assign("idx",$idx);		
		$this->view->assign("mode",$mode);
		$this->view->assign("gametype",$gametype);
		$this->view->assign("item",$item);
		$this->view->assign("html",$html);
		
		$this->view->assign("strMode",$strMode);
	
		
		
		$this->display();
	}

	//▶ 배당 수정
	function modifyrateMultiAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/gameUpload/popup.modify_rate_multi.html");
		$model = $this->getModel("GameModel");
		
		$idx 	= $this->request("idx");		
		$gametype 	= $this->request("gametype");
		$sport_name = $this->request("sport_name");
		$mode 	= $this->request("mode");
		
		if($mode == "") {$mode = "add";}
			
		$item = $model->getChildRowMulti($idx);
		$leagueName = $model->getRow('name', $model->db_qz.'league', 'sn='.$item["league_sn"]);
		$item['league_name']=$leagueName['name'];	
		
		$rs = $model->getSubChildRowsMulti($idx);
		if(count((array)$rs) > 0)
		{
			$home_rate = $rs[0]['home_rate'];
			$draw_rate = $rs[0]['draw_rate'];
			$away_rate = $rs[0]['away_rate'];
			$point = $rs[0]['point'];
		}
	
		$strMode	= "";
		$html 		= "";
		//$add		= "onkeyup='this.value=this.value.replace(/[^0-9.]/gi,\"\")'";
		$add		= "'";

		switch ($sport_name) {
			case "축구":
				switch ($gametype) {
					case "1":
						if($mode=="update") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;승<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
						$html=$html."&nbsp;무<input type='text' name='draw_rate' size='4' value='".$draw_rate."' ".$add.">";
						$html=$html."&nbsp;패<input type='text' name='away_rate' size='4' value='".$away_rate."' ".$add.">";
						$html=$html."&nbsp;&nbsp;<FONT color=#006699>&#8226; 승/패경기일때는 무승부에 1.00 을 넣으세요 </font></td>" ;
						break;
					case "2":
					case "11":
						if($mode=="edit") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;홈배당<input type='text' name='home_rate' size='4' value='".$home_rate ."' ".$add.">";
						$html=$html."&nbsp;홈핸디<input type='text' name='draw_rate' size='4' value='".$draw_rate ."' >";
						$html=$html."&nbsp;원정팀배당<input type='text' name='away_rate' size='4' value='".$away_rate ."' ".$add.">";
						$html=$html."&nbsp;&nbsp;</td>";
						break;
					case "3":
					case "12":
						if($mode=="edit") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;오버<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
						$html=$html."&nbsp;기준점수<input type='text' name='draw_rate' size='4' value='".$draw_rate."' >";
						$html=$html."&nbsp;언더<input type='text' name='away_rate' size='4' value='".$away_rate."' ".$add.">";
						$html=$html."&nbsp;&nbsp;</td>";
						break;
					case "4":
					case "5":
					case "6":
						if($mode=="update") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;승<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
						$html=$html."&nbsp;무<input type='text' name='draw_rate' size='4' value='".$draw_rate."' ".$add.">";
						$html=$html."&nbsp;패<input type='text' name='away_rate' size='4' value='".$away_rate."' ".$add.">";
						$html=$html."&nbsp;&nbsp;<FONT color=#006699>&#8226; 승/패경기일때는 무승부에 1.00 을 넣으세요 </font></td>" ;
						break;
					case "7":
					case "8":
						if($mode=="edit") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;오버<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
						$html=$html."&nbsp;기준점수<input type='text' name='draw_rate' size='4' value='".$draw_rate."' >";
						$html=$html."&nbsp;언더<input type='text' name='away_rate' size='4' value='".$away_rate."' ".$add.">";
						$html=$html."&nbsp;&nbsp;</td>";
						break;
					case "9":
					case "10":
						if($mode=="edit") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;홀<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
						$html=$html."&nbsp;득점수<input type='text' name='draw_rate' size='4' value='".$draw_rate."' >";
						$html=$html."&nbsp;짝<input type='text' name='away_rate' size='4' value='".$away_rate."' ".$add.">";
						$html=$html."&nbsp;&nbsp;</td>";
						break;
					case "13":
						if($mode=="edit") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
						$html=$html."&nbsp;&nbsp;</td>";
						break;
				}
				break;
			case "농구":
				switch ($gametype) {
					case "1":
						if($mode=="update") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;승<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
						$html=$html."&nbsp;무<input type='text' name='draw_rate' size='4' value='".$draw_rate."' ".$add.">";
						$html=$html."&nbsp;패<input type='text' name='away_rate' size='4' value='".$away_rate."' ".$add.">";
						$html=$html."&nbsp;&nbsp;<FONT color=#006699>&#8226; 승/패경기일때는 무승부에 1.00 을 넣으세요 </font></td>" ;
						break;
					case "2":
					case "16":
						if($mode=="edit") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;홈배당<input type='text' name='home_rate' size='4' value='".$home_rate ."' ".$add.">";
						$html=$html."&nbsp;홈핸디<input type='text' name='draw_rate' size='4' value='".$draw_rate ."' >";
						$html=$html."&nbsp;원정팀배당<input type='text' name='away_rate' size='4' value='".$away_rate ."' ".$add.">";
						$html=$html."&nbsp;&nbsp;</td>";
						break;
					case "3":
					case "17":
						if($mode=="edit") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;오버<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
						$html=$html."&nbsp;기준점수<input type='text' name='draw_rate' size='4' value='".$draw_rate."' >";
						$html=$html."&nbsp;언더<input type='text' name='away_rate' size='4' value='".$away_rate."' ".$add.">";
						$html=$html."&nbsp;&nbsp;</td>";
						break;
					case "4":
					case "5":
					case "6":
					case "7":
						if($mode=="update") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;승<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
						$html=$html."&nbsp;무<input type='text' name='draw_rate' size='4' value='".$draw_rate."' ".$add.">";
						$html=$html."&nbsp;패<input type='text' name='away_rate' size='4' value='".$away_rate."' ".$add.">";
						$html=$html."&nbsp;&nbsp;<FONT color=#006699>&#8226; 승/패경기일때는 무승부에 1.00 을 넣으세요 </font></td>" ;
						break;
					case "8":
					case "9":
					case "10":
					case "11":
						if($mode=="edit") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;홈배당<input type='text' name='home_rate' size='4' value='".$home_rate ."' ".$add.">";
						$html=$html."&nbsp;홈핸디<input type='text' name='draw_rate' size='4' value='".$draw_rate ."' >";
						$html=$html."&nbsp;원정팀배당<input type='text' name='away_rate' size='4' value='".$away_rate ."' ".$add.">";
						$html=$html."&nbsp;&nbsp;</td>";
						break;
					case "12":
					case "13":
					case "14":
					case "15":
						if($mode=="edit") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;오버<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
						$html=$html."&nbsp;기준점수<input type='text' name='draw_rate' size='4' value='".$draw_rate."' >";
						$html=$html."&nbsp;언더<input type='text' name='away_rate' size='4' value='".$away_rate."' ".$add.">";
						$html=$html."&nbsp;&nbsp;</td>";
						break;
				}
				break;
			case "배구":
				switch ($gametype) {
					case "1":
						if($mode=="update") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;승<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
						$html=$html."&nbsp;무<input type='text' name='draw_rate' size='4' value='".$draw_rate."' ".$add.">";
						$html=$html."&nbsp;패<input type='text' name='away_rate' size='4' value='".$away_rate."' ".$add.">";
						$html=$html."&nbsp;&nbsp;<FONT color=#006699>&#8226; 승/패경기일때는 무승부에 1.00 을 넣으세요 </font></td>" ;
						break;
					case "2":
						if($mode=="edit") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;홈배당<input type='text' name='home_rate' size='4' value='".$home_rate ."' ".$add.">";
						$html=$html."&nbsp;홈핸디<input type='text' name='draw_rate' size='4' value='".$draw_rate ."' >";
						$html=$html."&nbsp;원정팀배당<input type='text' name='away_rate' size='4' value='".$away_rate ."' ".$add.">";
						$html=$html."&nbsp;&nbsp;</td>";
						break;
					case "3":
						if($mode=="edit") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;오버<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
						$html=$html."&nbsp;기준점수<input type='text' name='draw_rate' size='4' value='".$draw_rate."' >";
						$html=$html."&nbsp;언더<input type='text' name='away_rate' size='4' value='".$away_rate."' ".$add.">";
						$html=$html."&nbsp;&nbsp;</td>";
						break;
					case "4":
					case "5":
						if($mode=="edit") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;홀<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
						$html=$html."&nbsp;득점수<input type='text' name='draw_rate' size='4' value='".$draw_rate."' >";
						$html=$html."&nbsp;짝<input type='text' name='away_rate' size='4' value='".$away_rate."' ".$add.">";
						$html=$html."&nbsp;&nbsp;</td>";
						break;
					case "6":
						if($mode=="edit") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
						$html=$html."&nbsp;&nbsp;</td>";
						break;
				}
				break;
			case "야구":
				switch ($gametype) {
					case "1":
						if($mode=="update") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;승<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
						$html=$html."&nbsp;무<input type='text' name='draw_rate' size='4' value='".$draw_rate."' ".$add.">";
						$html=$html."&nbsp;패<input type='text' name='away_rate' size='4' value='".$away_rate."' ".$add.">";
						$html=$html."&nbsp;&nbsp;<FONT color=#006699>&#8226; 승/패경기일때는 무승부에 1.00 을 넣으세요 </font></td>" ;
						break;
					case "2":
					case "11":
						if($mode=="edit") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;홈배당<input type='text' name='home_rate' size='4' value='".$home_rate ."' ".$add.">";
						$html=$html."&nbsp;홈핸디<input type='text' name='draw_rate' size='4' value='".$draw_rate ."' >";
						$html=$html."&nbsp;원정팀배당<input type='text' name='away_rate' size='4' value='".$away_rate ."' ".$add.">";
						$html=$html."&nbsp;&nbsp;</td>";
						break;
					case "3":
					case "12":
						if($mode=="edit") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;오버<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
						$html=$html."&nbsp;기준점수<input type='text' name='draw_rate' size='4' value='".$draw_rate."' >";
						$html=$html."&nbsp;언더<input type='text' name='away_rate' size='4' value='".$away_rate."' ".$add.">";
						$html=$html."&nbsp;&nbsp;</td>";
						break;
					case "4":
						if($mode=="update") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;승<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
						$html=$html."&nbsp;무<input type='text' name='draw_rate' size='4' value='".$draw_rate."' ".$add.">";
						$html=$html."&nbsp;패<input type='text' name='away_rate' size='4' value='".$away_rate."' ".$add.">";
						$html=$html."&nbsp;&nbsp;<FONT color=#006699>&#8226; 승/패경기일때는 무승부에 1.00 을 넣으세요 </font></td>" ;
						break;
					case "5":
					case "6":
					case "7":
						if($mode=="edit") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;홈배당<input type='text' name='home_rate' size='4' value='".$home_rate ."' ".$add.">";
						$html=$html."&nbsp;홈핸디<input type='text' name='draw_rate' size='4' value='".$draw_rate ."' >";
						$html=$html."&nbsp;원정팀배당<input type='text' name='away_rate' size='4' value='".$away_rate ."' ".$add.">";
						$html=$html."&nbsp;&nbsp;</td>";
						break;
					case "8":
					case "9":
					case "10":
						if($mode=="edit") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;오버<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
						$html=$html."&nbsp;기준점수<input type='text' name='draw_rate' size='4' value='".$draw_rate."' >";
						$html=$html."&nbsp;언더<input type='text' name='away_rate' size='4' value='".$away_rate."' ".$add.">";
						$html=$html."&nbsp;&nbsp;</td>";
						break;
				}
				break;
			case "하키":
				switch ($gametype) {
					case "1":
						if($mode=="update") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;승<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
						$html=$html."&nbsp;무<input type='text' name='draw_rate' size='4' value='".$draw_rate."' ".$add.">";
						$html=$html."&nbsp;패<input type='text' name='away_rate' size='4' value='".$away_rate."' ".$add.">";
						$html=$html."&nbsp;&nbsp;<FONT color=#006699>&#8226; 승/패경기일때는 무승부에 1.00 을 넣으세요 </font></td>" ;
						break;
					case "2":
						if($mode=="edit") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;홈배당<input type='text' name='home_rate' size='4' value='".$home_rate ."' ".$add.">";
						$html=$html."&nbsp;홈핸디<input type='text' name='draw_rate' size='4' value='".$draw_rate ."' >";
						$html=$html."&nbsp;원정팀배당<input type='text' name='away_rate' size='4' value='".$away_rate ."' ".$add.">";
						$html=$html."&nbsp;&nbsp;</td>";
						break;
					case "3":
						if($mode=="edit") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;오버<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
						$html=$html."&nbsp;기준점수<input type='text' name='draw_rate' size='4' value='".$draw_rate."' >";
						$html=$html."&nbsp;언더<input type='text' name='away_rate' size='4' value='".$away_rate."' ".$add.">";
						$html=$html."&nbsp;&nbsp;</td>";
						break;
					case "4":
					case "5":
					case "6":
						if($mode=="update") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;승<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
						$html=$html."&nbsp;무<input type='text' name='draw_rate' size='4' value='".$draw_rate."' ".$add.">";
						$html=$html."&nbsp;패<input type='text' name='away_rate' size='4' value='".$away_rate."' ".$add.">";
						$html=$html."&nbsp;&nbsp;<FONT color=#006699>&#8226; 승/패경기일때는 무승부에 1.00 을 넣으세요 </font></td>" ;
						break;
					case "7":
						if($mode=="edit") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;홈배당<input type='text' name='home_rate' size='4' value='".$home_rate ."' ".$add.">";
						$html=$html."&nbsp;홈핸디<input type='text' name='draw_rate' size='4' value='".$draw_rate ."' >";
						$html=$html."&nbsp;원정팀배당<input type='text' name='away_rate' size='4' value='".$away_rate ."' ".$add.">";
						$html=$html."&nbsp;&nbsp;</td>";
						break;
					case "8":
						if($mode=="edit") {$strMode="disabled";}
						$html="<td bgcolor='#ffffff' align='left'>";
						$html=$html."&nbsp;&nbsp;오버<input type='text' name='home_rate' size='4' value='".$home_rate."' ".$add.">";
						$html=$html."&nbsp;기준점수<input type='text' name='draw_rate' size='4' value='".$draw_rate."' >";
						$html=$html."&nbsp;언더<input type='text' name='away_rate' size='4' value='".$away_rate."' ".$add.">";
						$html=$html."&nbsp;&nbsp;</td>";
						break;
				}
				break;
		}
		
		$this->view->assign("idx",$idx);		
		$this->view->assign("mode",$mode);
		$this->view->assign("gametype",$gametype);
		$this->view->assign("sport_name",$sport_name);
		$this->view->assign("item",$item);
		$this->view->assign("html",$html);
		$this->view->assign("point",$point);
		$this->view->assign("strMode",$strMode);
		
		$this->display();
	}
	
	//▶ 경기 배당수정 처리 
	function rateProcessAction()	
	{
		$model 		= $this->getModel("GameModel");
		$child_sn = $this->request("idx");				
		$gametype	= $this->request("gametype");	
		$home_rate 		= $this->request("home_rate");
		$draw_rate 		= $this->request("draw_rate");
		$away_rate 		= $this->request("away_rate");		
		$gameDate 		= $this->request("gameDate");		
		$gameHour 		= $this->request("gameHour");		
		$gameTime 		= $this->request("gameTime");

		//-> 경기가 시작되었으면 업데이트 불가능.
		$db_item = $model->getChildRow($child_sn);		
		$db_gameStartTime = strtotime($db_item['gameDate']." ".$db_item['gameHour'].":".$db_item['gameTime'].":00");
		if ( $db_gameStartTime < time() ) {
			$url = $_SERVER['HTTP_REFERER'];
			throw new Lemon_ScriptException("경기가 시작되면 수정이 불가능합니다.", "", "go", $url);
			exit;
		}

		$model->modifyChildRate($child_sn,$gametype,$home_rate,$draw_rate,$away_rate);		
		$model->modifyChildRate_Date($child_sn,$gameDate,$gameHour,$gameTime);
		
		throw new Lemon_ScriptException("","","script","alert('수정되었습니다.');opener.document.location.reload(); self.close();");		
	}

	//▶ 경기 배당수정 처리 (다기준)
	function rateProcessMultiAction()	
	{
		$model 		= $this->getModel("GameModel");
		$subchild_sn = $this->request("idx");				
		$gametype	= $this->request("gametype");	
		$home_rate 		= $this->request("home_rate");
		$draw_rate 		= $this->request("draw_rate");
		$away_rate 		= $this->request("away_rate");		
		$gameDate 		= $this->request("gameDate");		
		$gameHour 		= $this->request("gameHour");		
		$gameTime 		= $this->request("gameTime");

		//-> 경기가 시작되었으면 업데이트 불가능.
		$db_item = $model->getChildRowMulti($subchild_sn);		
		$db_gameStartTime = strtotime($db_item['gameDate']." ".$db_item['gameHour'].":".$db_item['gameTime'].":00");
		if ( $db_gameStartTime < time() ) {
			$url = $_SERVER['HTTP_REFERER'];
			throw new Lemon_ScriptException("경기가 시작되면 수정이 불가능합니다.", "", "go", $url);
			exit;
		}

		$model->modifySubChildRate($db_item['child_sn'], $subchild_sn, $db_item['sub_idx'], $gametype,$home_rate,$draw_rate,$away_rate);		
		$model->modifyChildRateMulti_Date($subchild_sn,$gameDate,$gameHour,$gameTime);
		
		throw new Lemon_ScriptException("","","script","alert('수정되었습니다.');opener.document.location.reload(); self.close();");		
	}
	
	
	//▶ 게임결과 입력 및 수정
	function popup_modifyresultAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/gameUpload/popup.modify_result.html");
		$model 	= $this->getModel("GameModel");
		$leagueModel = $this->getModel("LeagueModel");
		
		$childSn 	= $this->request("idx");
		$pidx 	 	= $this->request("pidx");
		$mode 	 	= $this->request("mode");
		$category = $this->request("category");
		$result = $this->request("result");
		
		$categoryList = $leagueModel->getCategoryList();
	
		if ($mode=="edit")
		{
			$item = $model->getChildJoinSubChild($childSn);
			$leagueList = $leagueModel->getListAll();
		}
		
		$hours = array();
		for($i=0; $i<24; ++$i)
		{
			if($i<10) 	{$hour = '0'.$i;}
			else				{$hour = $i;}
			$hours[] = $hour;
		}
		
		$mins = array();
		for($i=0; $i<60; ++$i)
		{
			if($i<10) $min='0'.$i;
			else	$min=$i;
			
			$mins[] = $min;
		}
		
		$this->view->assign("hours",$hours);
		$this->view->assign("mins",$mins);
		$this->view->assign("idx",$childSn);
		$this->view->assign("pidx",$pidx);
		$this->view->assign("mode",$mode);
		$this->view->assign("item",$item[0]);
		$this->view->assign("league_list",$leagueList);
		$this->view->assign("category_list",$categoryList);
		$this->view->assign("result",$result);
		$this->display();
	}

	//▶ 게임결과 입력 및 수정 (다기준)
	function popup_modifyresultMultiAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/gameUpload/popup.modify_result_multi.html");
		$model 	= $this->getModel("GameModel");
		$leagueModel = $this->getModel("LeagueModel");
		
		$subchildSn 	= $this->request("idx");
		$pidx 	 	= $this->request("pidx");
		$mode 	 	= $this->request("mode");
		$category = $this->request("category");
		$result = $this->request("result");
		
		$categoryList = $leagueModel->getCategoryList();
	
		if ($mode=="edit")
		{
			$item = $model->getChildJoinSubChildMulti($subchildSn);
			$leagueList = $leagueModel->getListAll();
		}
		
		$hours = array();
		for($i=0; $i<24; ++$i)
		{
			if($i<10) 	{$hour = '0'.$i;}
			else		{$hour = $i;}
			$hours[] = $hour;
		}
		
		$mins = array();
		for($i=0; $i<60; ++$i)
		{
			if($i<10) $min='0'.$i;
			else	$min=$i;
			
			$mins[] = $min;
		}
		
		$this->view->assign("hours",$hours);
		$this->view->assign("mins",$mins);
		$this->view->assign("idx",$subchildSn);
		$this->view->assign("pidx",$pidx);
		$this->view->assign("mode",$mode);
		$this->view->assign("item",$item[0]);
		$this->view->assign("league_list",$leagueList);
		$this->view->assign("category_list",$categoryList);
		$this->view->assign("result",$result);
		$this->display();
	}
	
	//▶ 엑셀 업로드
	function popup_exceluploadAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/gameUpload/popup.excel_upload.html");
		
		header("Content-Type:text/html;charset=UTF-8");
		
		$model = $this->getModel("GameModel");
		$leagueModel = $this->getModel("LeagueModel");
		
		//참고 http://shonm.tistory.com/category/PHP/PHP%20%EC%97%91%EC%85%80%20%ED%8C%8C%EC%9D%BC%20%EC%9D%BD%EA%B8%B0
		
		$mode = $this->request("mode");		
		
		
		
		if($mode == "execl_collect")
		{
			include_once("include/excel_reader.php");			
			
			$conf = Lemon_Configure::readConfig('config');
			if($conf['site']!='')
			{
				$upload_dir	 = $conf['site']['local_upload_url']."/upload/excel/";
			}
		
			$tmp_name = $_FILES["fileUpload"]["tmp_name"]; // 임시파일명
		 	$name = $_FILES["fileUpload"]["name"];  // 파일명
		 	
		 	$upload_file = $upload_dir.$name;
		 	
		// 	echo "upload_file: ".$upload_file."<br/>";
		 	
 			if( move_uploaded_file($tmp_name, $upload_file) )
 			{
 				echo "파일업로드 성공"."<br/>";
 			}
 			else
 			{
 				throw new Lemon_ScriptException("파일업로드가 실패하였습니다.");			
 				exit;
 			}
  
			
			$handle = new Spreadsheet_Excel_Reader();		
			$handle->setOutputEncoding('utf-8');
			
			$handle->read($upload_file);
		
			$gamearray = array();
	
			for( $k=0; $k < count((array)$handle->sheets); ++$k )
			{ 
				for($i=0; $i <= $handle->sheets[0]['numRows']; $i++)
				{
					//엑셀 첫 열이 데이터가 아니라 구분 이므로 0번째 index 를 건너뛰고 읽음
			//		if($i==1) continue;
					
					$kind=''; $game_type=''; $game_date=''; $gameHour=''; $gameTime=''; $league_name=''; $home_team=''; $away_team=''; $home_rate=''; $draw_rate=''; $away_rate='';
					
					for ($j=1; $j<=$handle->sheets[$k]['numCols']; $j++)
					{
						switch( $j )
						{
						case 1: $kind = $handle->sheets[$k]['cells'][$i][$j]; break; // 게임옵션												
						case 2: $game_type = $handle->sheets[$k]['cells'][$i][$j]; break; // 게임방식												
						case 3: $game_date = $handle->sheets[$k]['cells'][$i][$j]; break; // 일자												
						case 4: $gameHour = $handle->sheets[$k]['cells'][$i][$j]; break; // 시간												
						case 5: $gameTime = $handle->sheets[$k]['cells'][$i][$j]; break; // 분
						case 6: $league_name = $handle->sheets[$k]['cells'][$i][$j]; break; // 리그명
						case 7: $home_team = $handle->sheets[$k]['cells'][$i][$j]; break; // 홈팀			
						case 8: $away_team = $handle->sheets[$k]['cells'][$i][$j]; break; // 원정팀																																
						case 9: $home_rate = $handle->sheets[$k]['cells'][$i][$j]; break; //  홈팀 승률																																
						case 10: $draw_rate = $handle->sheets[$k]['cells'][$i][$j]; break; //  무승부 승률
						case 11: $away_rate = $handle->sheets[$k]['cells'][$i][$j]; break; //  원정팀 승률																																			
						}
					}		
					
					if( $game_type == '' || $game_date == '' || $game_date == 0 || $gameHour == '' || $gameTime == '' )
					{
						continue;
					}

                    $game_date = DateTime::createFromFormat('d/m/Y', $game_date);
                    $game_date = $game_date->format('Y-m-d');

					$kind 				= trim($kind);					
					$game_type 		= trim($game_type);
					$game_date		= trim($game_date);
					$gameHour 		= trim($gameHour);
					$gameTime 		= trim($gameTime);
					$league_name 	= trim($league_name); 
					$home_team 		= trim($home_team); 
					$away_team 		= trim($away_team); 
					$home_rate 		= trim($home_rate); 
					$draw_rate 		= trim($draw_rate); 
					$away_rate 		= trim($away_rate);
					
					
					if( !is_null($league_name) && $league_name != '')
					{
						$rs = $leagueModel->getListByName($league_name);
						if($rs == null)
						{
                            throw new Lemon_ScriptException($league_name."  는 등록되지 않은 리그입니다.");
                            exit;
						}
						$cate_name = $rs[0]['kind'];
					} else {
                        throw new Lemon_ScriptException("리그를 입력하세요.");
                        exit;
					}
					
					$count = count((array)$gamearray);
					
					$gamearray[$count]['cate_name'] 	= $cate_name;
					$gamearray[$count]['kind'] 				= $kind;
					$gamearray[$count]['game_type'] 	= $game_type;
					$gamearray[$count]['game_date'] 	= $game_date;
					$gamearray[$count]['gameHour'] 		= $gameHour;
					$gamearray[$count]['gameTime'] 		= $gameTime;
					$gamearray[$count]['league_name']	= $league_name;
					$gamearray[$count]['home_team']		= $home_team;
					$gamearray[$count]['away_team']		= $away_team;
					$gamearray[$count]['home_rate']		= $home_rate;
					$gamearray[$count]['draw_rate']		= $draw_rate;
					$gamearray[$count]['away_rate']		= $away_rate;
					
					$rs = $leagueModel->getLeagueSnByName( $league_name );
					$leagueSn = $rs['sn'];
					
					$type = 0;
					$is_specified_special=0;
												
					if($game_type == "승무패" || $game_type == "승패"){$type = 1;}
					else if($game_type == "핸디캡"){$type = 2;}
					else if($game_type == "홀 짝" || $game_type == "홀짝" ){$type = 3;}
					else if($game_type == "언더오버" || $game_type == "하이로우" || $game_type == "언오버" ){$type = 4;}  
					else if($game_type == "승스페")
					{
						$type = 1; 
						$is_specified_special=1;

						if( false!=strstr($league_name, "득점/무득점"))
						{
							$home_team =$home_team."[득점]";
							$Context = "[무득점]";
							$away_team = $Context.$away_team;
						}
						
					}  
					
					if($kind == '일반')					{ $special = 0;}
					else if( $kind == '스페셜')	{ $special = 1;}
                    else if( $kind == '실시간')	{ $special = 2;}
					//else if( $kind == '멀티')		{ $special = 2;}
					else if( $kind == '사다리')	{ $special = 5;}
					else if( $kind == '달팽이')	{ $special = 6;}
					else if( $kind == '파워볼')	{ $special = 7;}
					else if( $kind == '다리다리')	{ $special = 8;}
                    else if( $kind == '가상축구')	{ $special = 22;}
                    else if( $kind == '로하이')	{ $special = 28;}
                    else if( $kind == '알라디')	{ $special = 29;}
                    else if( $kind == 'MGM홀짝')	{ $special = 26;}
                    else if( $kind == 'MGM바카라')	{ $special = 27;}
					
					$kubun = 'null';
				
					$rs = $model->addChild(0,$cate_name,$leagueSn,$home_team,$away_team,$game_date,$gameHour,$gameTime,'',$kubun,$type,$special,$home_rate,$draw_rate,$away_rate,$is_specified_special);
					if($rs <=0)
					{
						throw new Lemon_ScriptException("","","script","alert('입력실패.');opener.document.location.reload(); self.close();");			
					}
				}
			}
			
			throw new Lemon_ScriptException("","","script","alert('입력되었습니다.');opener.document.location.reload(); self.close();");			
		}		
	
		
		$this->view->assign("gamearray", $gamearray);

		$this->display();
	}
	
	//▶ 게임 수정
	function modifyProcessAction()
	{
		$view			= $this->request("view");
		$childSn	= $this->request("idx");
		$pidx			= $this->request("pidx");
		$auto			= $this->request("auto");
		$bet_type	= $this->request("bet_type");
		$mode 		= Trim($this->request("mode"));
		$result_state 		= Trim($this->request("result_state"));
		
		$leagueModel 	= $this->getModel("LeagueModel");
		$gModel 	= $this->getModel("GameModel");
		$cartModel 	= $this->getModel("CartModel");
		$pModel		= $this->getModel("ProcessModel");
		
		//결과입력이 없을 경우
		if($view == "")
		{
			$currentGame = $gModel->getChildRow($childSn);
			
			$type 	 = $this->request("game_type");
			$special = $this->request("special_type");
			
			$gameDate = $this->request("GameDate");
			$gameHour = $this->request("gameHour");
			$gameTime = $this->request("gameTime");
			$leagueSn = Trim($this->request("strLeagueName"));
			$homeTeam = $this->request("HomeTeam");
			$awayTeam = $this->request("AwayTeam");

            //$homeTeam = htmlentities($homeTeam, ENT_QUOTES);
            //$awayTeam = htmlentities($awayTeam, ENT_QUOTES);

            //$homeTeam = mb_convert_encoding($homeTeam, 'UTF-8', 'EUC-KR');
            //$awayTeam = mb_convert_encoding($awayTeam, 'UTF-8', 'EUC-KR');

			$notice 	= "";//str_replace("<br>",chr(13),$this->request("notice"));
			$play 		= $this->request("play");
			$league_kind = $leagueModel->getLeagueField($leagueSn, 'kind');
			$category	= Trim($this->request("category"));
			$userViewFlag = $this->request("user_view_flag");

			//-> 경기가 시작되었는데 경기시간 변경을 했으면 업데이트 불가능
			$db_item = $gModel->getChildRow($childSn);
			$db_gameStartTime = strtotime($db_item['gameDate']." ".$db_item['gameHour'].":".$db_item['gameTime'].":00");
			if ( $db_gameStartTime < time() and ($db_item['gameDate'] != $gameDate or $db_item['gameHour'] != $gameHour or $db_item['gameTime'] != $gameTime)) {
				$url = $_SERVER['HTTP_REFERER'];
				throw new Lemon_ScriptException("경기가 시작되면 수정이 불가능합니다.", "", "go", $url);
				exit;
			}

			if($result_state==1)
			{
				$homeScore = $this->request("winPoint");
				$awayScore = $this->request("winPoint2");
			}
	
			$set .= "league_sn = '" . $leagueSn . "',";
			$set .=	"home_team = '" . $homeTeam . "',";  
			$set .=	"away_team = '" . $awayTeam . "',";
			$set .=	"gameDate = '" . $gameDate . "',";
			$set .=	"gameHour = '" . $gameHour . "',";
			$set .= "gameTime = '" . $gameTime . "',";
			$set .= "sport_name = '" . $category . "',";
			if($result_state==1)
			{
				$set .= "home_score = '" . $homeScore . "',";
				$set .= "away_score = '" . $awayScore . "',";
			}
			$set .= "user_view_flag = '" . $userViewFlag . "',";
			$set .= "notice = '" .$notice . "' ";
			
			//대분류, 종류 수정시에는 해당되는 게임만 수정해야 한다.
			if($currentGame['type'] != $type || $currentGame['special'] != $special)
			{
				if($gModel->isGameExist($type, 
																$special, 
																$currentGame['home_team'],
																$currentGame['away_team'],
																$currentGame['gameDate'],
																$currentGame['gameHour'],
																$currentGame['gameTime']) > 0)
				{
					throw new Lemon_ScriptException("","","script","alert('게임이 이미 존재합니다.');opener.document.location.reload(); self.close();");
					exit;
				}
				
				$gModel->modifyGameType($childSn, $special, $type);
			}
			
			$where = " sn=".$childSn;
			$gModel->modifyChild($set,$where);

			$set="";
			$where="";

			//$set.= "update_enable = '0'";
			//$where = " child_sn=".$childSn;
			//$gModel->modifySubChild($set, $where);

			/*
			$item = $gModel->getSameChild($currentGame['gameDate'], $currentGame['gameHour'], $currentGame['gameTime'], $currentGame['league_sn'], $currentGame['home_team'], $currentGame['away_team']);
			
			for($i=0; $i<sizeof($item); ++$i)
			{
				$where = " sn=".$item[$i]['sn'];
				$gModel->modifyChild($set,$where);
			}
			*/
		}
		//결과입력시
		else
		{
			/*
			if($auto=="0") 	{$winTeam = Trim($this->request("winTeamauto"));}
			else 						{$winTeam = Trim($this->request("winTeam"));}
			
			$gameCancel="";
			if($winTeam=="Cancel")
			{
				$homeScore 	= 0;
				$awayScore	= 0;
				$gameCancel = "Cancel";
			}
			else
			{
				$homeScore = $this->request("winPoint");
				$awayScore = $this->request("winPoint2");
			}
			
			$set.= "home_score=".$homeScore."," ;
			$set.= "away_score=".$awayScore.",";
			
			if($bet_type==1 or $bet_type==4) 	$set .= "win_team='".$winTeam."'";
			else if($bet_type==2)							$set .= "handi_winner = '".$winTeam."'";
				
			$where = " sn=".$childSn;
			
			$gModel->modifyChild($set, $where);
			$pModel->resultGameProcess($childSn, $homeScore, $awayScore, $winTeam, $gameCancel);
			*/
			if($auto=="0") 	{$winTeam = Trim($this->request("winTeamauto"));}
			else 						{$winTeam = Trim($this->request("winTeam"));}
			
			$gameCancel="";
			if($winTeam=="Cancel")
			{
				$gameCancel="1";
			}
			else
			{
				$homeScore = $this->request("winPoint");
				$awayScore = $this->request("winPoint2");
			}

			$pModel->resultGameProcess($childSn, $homeScore, $awayScore, $gameCancel);
		}
			
		throw new Lemon_ScriptException("","","script","alert('수정되었습니다.');opener.document.location.reload(); self.close();");							
		
	}

	//▶ 게임 수정 (다기준)
	function modifyProcessMultiAction()
	{
		$view			= $this->request("view");
		$subchildSn	= $this->request("idx");
		$pidx			= $this->request("pidx");
		$auto			= $this->request("auto");
		$bet_type	= $this->request("bet_type");
		$mode 		= Trim($this->request("mode"));
		$result_state 		= Trim($this->request("result_state"));
		
		$leagueModel 	= $this->getModel("LeagueModel");
		$gModel 	= $this->getModel("GameModel");
		$cartModel 	= $this->getModel("CartModel");
		$pModel		= $this->getModel("ProcessModel");
		
		//결과입력이 없을 경우
		if($view == "")
		{
			$currentGame = $gModel->getChildRowMulti($subchildSn);
			
			$type 	 = $this->request("game_type");
			$special = $this->request("special_type");
			
			$gameDate = $this->request("GameDate");
			$gameHour = $this->request("gameHour");
			$gameTime = $this->request("gameTime");
			$leagueSn = Trim($this->request("strLeagueName"));
			$homeTeam = $this->request("HomeTeam");
			$awayTeam = $this->request("AwayTeam");

            //$homeTeam = htmlentities($homeTeam, ENT_QUOTES);
            //$awayTeam = htmlentities($awayTeam, ENT_QUOTES);

            //$homeTeam = mb_convert_encoding($homeTeam, 'UTF-8', 'EUC-KR');
            //$awayTeam = mb_convert_encoding($awayTeam, 'UTF-8', 'EUC-KR');

			$notice 	= "";//str_replace("<br>",chr(13),$this->request("notice"));
			$play 		= $this->request("play");
			$league_kind = $leagueModel->getLeagueField($leagueSn, 'kind');
			$category	= Trim($this->request("category"));
			$userViewFlag = $this->request("user_view_flag");

			//-> 경기가 시작되었는데 경기시간 변경을 했으면 업데이트 불가능
			$db_item = $gModel->getChildRowMulti($subchildSn);
			$db_gameStartTime = strtotime($db_item['gameDate']." ".$db_item['gameHour'].":".$db_item['gameTime'].":00");
			if ( $db_gameStartTime < time() and ($db_item['gameDate'] != $gameDate or $db_item['gameHour'] != $gameHour or $db_item['gameTime'] != $gameTime)) {
				$url = $_SERVER['HTTP_REFERER'];
				throw new Lemon_ScriptException("경기가 시작되면 수정이 불가능합니다.", "", "go", $url);
				exit;
			}

			if($result_state==1)
			{
				$homeScore = $this->request("winPoint");
				$awayScore = $this->request("winPoint2");
			}
	
			$set .= "a.league_sn = '" . $leagueSn . "',";
			$set .=	"a.home_team = '" . $homeTeam . "',";  
			$set .=	"a.away_team = '" . $awayTeam . "',";
			$set .=	"a.gameDate = '" . $gameDate . "',";
			$set .=	"a.gameHour = '" . $gameHour . "',";
			$set .= "a.gameTime = '" . $gameTime . "',";
			$set .= "a.sport_name = '" . $category . "',";
			if($result_state==1)
			{
				$set .= "a.home_score = '" . $homeScore . "',";
				$set .= "a.away_score = '" . $awayScore . "',";
			}
			$set .= "b.user_view_flag = '" . $userViewFlag . "',";
			$set .= "a.notice = '" .$notice . "' ";
			
			//대분류, 종류 수정시에는 해당되는 게임만 수정해야 한다.
			if($currentGame['betting_type'] != $type || $currentGame['special'] != $special)
			{
				if($gModel->isGameExistMulti($type, 
											$special, 
											$currentGame['home_team'],
											$currentGame['away_team'],
											$currentGame['gameDate'],
											$currentGame['gameHour'],
											$currentGame['gameTime']) > 0)
				{
					throw new Lemon_ScriptException("","","script","alert('게임이 이미 존재합니다.');opener.document.location.reload(); self.close();");
					exit;
				}
				
				$gModel->modifyGameTypeMulti($currentGame['child_sn'], $subchild_sn, $special, $type);
			}
			
			$where = " b.sn=".$subchildSn;
			$gModel->modifyChildMulti($set, $where);

			$set="";
			$where="";

		}
		//결과입력시
		else
		{
			if($auto=="0") 	{$winTeam = Trim($this->request("winTeamauto"));}
			else 			{$winTeam = Trim($this->request("winTeam"));}
			
			$gameCancel="";
			if($winTeam=="Cancel")
			{
				$gameCancel="1";
			}
			else
			{
				$homeScore = $this->request("winPoint");
				$awayScore = $this->request("winPoint2");
			}

			$pModel->resultGameProcessMulti($subchildSn, $homeScore, $awayScore, $gameCancel);
		}
			
		throw new Lemon_ScriptException("","","script","alert('수정되었습니다.');opener.document.location.reload(); self.close();");							
		
	}
	
	//▶ 게임 결과 처리
	function resultmoneyProcessAction()
	{
		$childSn	= $this->request("idx");    //'경기인텍스
		$type		= $this->request("type");
		
		$pModel 	= $this->getModel("ProcessModel");
		$commonModel 	= $this->getModel("CommonModel");

		
		$rs = $pModel->resultMoneyProcess($childSn);
		
		if($rs==-1)	{$msg = "[수정]에서 게임결과를 입력후 누르세요";}
		else		{$msg = "배당지급이 완료되었습니다.";}

		$url = "/gameUpload/gamelist?type=".$type;	
		
		$commonModel->alertGo($msg, $url);		
		
	}
	
	//▶ 경기 결과 취소 
	public function cancel_resultProcessAction()
	{
		$childIdx 	= $this->request("idx"); 	//경기인텍스
		$type 	= $this->request("type");
		
		$state						=$this->request("state");
		$gameType					=$this->request("game_type");
		$categoryName			=$this->request("categoryName");
		$special_type			=$this->request("special_type");
		$perpage					=$this->request("perpage");
		$begin_date				=$this->request("begin_date");
		$end_date					=$this->request("end_date");
		$filter_team_type	=$this->request("filter_team_type");
		$filter_team			=$this->request("filter_team");
		$money_option			=$this->request("money_option");
		$page							=$this->request("page");
		
		$param="&state=".$state."&game_type=".$gameType."&categoryName=".$categoryName."&special_type=".$special_type."&perpage=".$perpage."&begin_date=".$begin_date."&end_date=".$end_date."&filter_team_type=".$filter_team_type."&filter_team=".$filter_team."&money_option=".$money_option."&page=".$page;
		
		$model = $this->getModel("GameModel");
		$commonModel 	= $this->getModel("CommonModel");
		
		$rs = $model->cancelResultChild($childIdx);
		if($rs==-1)
		{
			$msg = "게임결과가 입력되지 않았습니다.  게임결과 등록후 배당지급하세요.";
			$url = "/gameUpload/gamelist?&bet=0";	
			$commonModel->alertGo($msg, $url.$param);
		}
		else
		{
			$msg = "배당지급이 취소 되었습니다.";
			$url = "/gameUpload/gamelist?search=search&bet=1";
			$commonModel->alertGo($msg, $url.$param);
		}
	}

	public function popup_cancel_resultProcessAction()
	{
		$childIdx 	= $this->request("idx"); 	//경기인텍스
		$type 	= $this->request("type");

		$state						=$this->request("state");
		$gameType					=$this->request("game_type");
		$categoryName			=$this->request("categoryName");
		$special_type			=$this->request("special_type");
		$perpage					=$this->request("perpage");
		$begin_date				=$this->request("begin_date");
		$end_date					=$this->request("end_date");
		$filter_team_type	=$this->request("filter_team_type");
		$filter_team			=$this->request("filter_team");
		$money_option			=$this->request("money_option");
		$page							=$this->request("page");

		$param="&state=".$state."&game_type=".$gameType."&categoryName=".$categoryName."&special_type=".$special_type."&perpage=".$perpage."&begin_date=".$begin_date."&end_date=".$end_date."&filter_team_type=".$filter_team_type."&filter_team=".$filter_team."&money_option=".$money_option."&page=".$page;

		$model = $this->getModel("GameModel");
		$commonModel 	= $this->getModel("CommonModel");

		$rs = $model->cancelResultChild($childIdx);
		if($rs==-1)
		{
			$msg = "게임결과가 입력되지 않았습니다.  게임결과 등록후 배당지급하세요.";
			$url = "/gameUpload/popup_gameupload?&bet=0";
			$commonModel->alertGo($msg, $url.$param);
		}
		else
		{
			$msg = "배당지급이 취소 되었습니다.";
			$url = "/gameUpload/popup_gameupload?search=search&bet=1";
			$commonModel->alertGo($msg, $url.$param);
		}
	}

	public function popup_multi_cancel_resultProcessAction()
	{
		$childIdx 	= $this->request("idx"); 	//경기인텍스
		$type 	= $this->request("type");

		$state						=$this->request("state");
		$gameType					=$this->request("game_type");
		$categoryName			=$this->request("categoryName");
		$special_type			=$this->request("special_type");
		$perpage					=$this->request("perpage");
		$begin_date				=$this->request("begin_date");
		$end_date					=$this->request("end_date");
		$filter_team_type	=$this->request("filter_team_type");
		$filter_team			=$this->request("filter_team");
		$money_option			=$this->request("money_option");
		$page							=$this->request("page");

		$param="&state=".$state."&game_type=".$gameType."&categoryName=".$categoryName."&special_type=".$special_type."&perpage=".$perpage."&begin_date=".$begin_date."&end_date=".$end_date."&filter_team_type=".$filter_team_type."&filter_team=".$filter_team."&money_option=".$money_option."&page=".$page;

		$model = $this->getModel("GameModel");
		$commonModel 	= $this->getModel("CommonModel");

		$rs = $model->cancelResultChild($childIdx, 2);
		if($rs==-1)
		{
			$msg = "게임결과가 입력되지 않았습니다.  게임결과 등록후 배당지급하세요.";
			$url = "/gameUpload/popup_gameMultiUpload?&bet=0";
			$commonModel->alertGo($msg, $url.$param);
		}
		else
		{
			$msg = "배당지급이 취소 되었습니다.";
			$url = "/gameUpload/popup_gameMultiUpload?search=search&bet=1";
			$commonModel->alertGo($msg, $url.$param);
		}
	}
	
	//▶  경기업로드 
	function popup_gameuploadAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/gameUpload/popup.game_upload.html");
		$gameModel = $this->getModel("GameModel");
		$cartModel 		= $this->getModel("CartModel");
		$leagueModel = $this->getModel("LeagueModel");
		
		// 경기종류
		$pidx = $this->request("pidx");
		
		$categoryList = $leagueModel->getCategoryList();
		
		$gameHour = "<select name='gameHour[]' id='game_hour'>";
		for($i=0;$i<24;$i++)
		{
			$j=$i;
			if($j<10) {$j="0".$j;}
			$gameHour=$gameHour."<option value='".$j."'>".$j."</option>";
		}
		$gameHour = $gameHour . "</select>";		
		
		$gameTime = "<select name='gameTime[]' id='game_time'>";
		for($i=0;$i<60;$i++)
		{
			$j=$i;
			if($j<10)	{$j="0".$j;}
			$gameTime=$gameTime."<option value='".$j."'>".$j."</option>";
		}
		$gameTime = $gameTime . "</select>";

		$leagueList = $leagueModel->getListAll($where);

		//// game_list part
		$act  				= $this->request("act");
		$state  			= $this->request("state");
		$perpage			= $this->request("perpage");
		$specialType	= $this->request("search_special_type");
		$categoryName = $this->request("search_categoryName");
		$gameType 		= $this->request("search_game_type");
		$moneyOption = $this->request("money_option");
		$beginDate  		= $this->request('begin_date');
		$endDate 				= $this->request('end_date');
		$filterTeam			= $this->request('filter_team');
		$filterTeamType	= $this->request('filter_team_type');
		$parsingType = $this->request("search_parsing_type");
		$modifyFlag = $this->request("modifyFlag");
		$leagueSn = $this->request("search_league_sn");
		$sort = $this->request("sort");

//-> 경기수정 경기보기
		if ( $modifyFlag == "on" ) $modifyFlag = 0;
		else $modifyFlag = "";

		if($sort == null) $sort = '';

		//-> 상단 파싱정보 초기화.
		$etcModel = $this->getModel("EtcModel");
		$etcModel->updateParsingStatus("new_rate");
		$etcModel->updateParsingStatus("new_game");

		if($act=="modify_state")
		{
			$childSn = $this->request('child_sn'); //경기인텍스
			$newState= $this->request('new_state');
			if ( $newState != "rateUpdate" ) {
				if($newState == 2)
				{
					$gameModel->blockGame($childSn);
					$newState=-1;  // 블록된 경기를 대기상태로 함.
				}
				$gameModel->modifyChildStaus($childSn,$newState);
			} else {
				$gameModel->modifyChildNewRate($childSn);
			}
		}
		else if($act=="delete_game")
		{
			$childSn = $this->request('child_sn');
			$gameModel->delChild($childSn);
		}
		else if($act=="delete_game_db")
		{
			$childSn = $this->request('child_sn');
			$gameModel->delChildDB($childSn);
		}
		else if($act=='deadline_game')
		{
			$childSn = $this->request('child_sn');
			$gameModel->modifyGameTime($childSn);
		}
		else if($act=='apply')
		{
			/*$childSn = $this->request('child_sn');
			$gameDate = $this->request('gameDate');
			$gameHour = $this->request('gameHour');
			$gameTime = $this->request('gameTime');
			$homeRate = $this->request('homeRate');
			$drawRate = $this->request('drawRate');
			$awayRate = $this->request('awayRate');
			$homeScore = $this->request('homeScore');
			$awayScore = $this->request('awayScore');

			$db_item = $gameModel->getChildRow($childSn);

			if($gameDate != $db_item['gameDate'] || $gameHour != $db_item['gameHour'] || $gameTime != $db_item['gameTime'])
			{
				$db_gameStartTime = strtotime($db_item['gameDate']." ".$db_item['gameHour'].":".$db_item['gameTime'].":00");
				if ( $db_gameStartTime < time() ) {
					$url = $_SERVER['HTTP_REFERER'];
					throw new Lemon_ScriptException("경기가 시작되면 수정이 불가능합니다.", "", "go", $url);
					exit;
				}
				$gameModel->modifyChildRate_Date($childSn,$gameDate,$gameHour,$gameTime);
			}

			if($homeRate != '' && $drawRate != '' && $awayRate != '')
			{
				$gameModel->modifyChildRate($childSn,$db_item['type'],$homeRate,$drawRate,$awayRate);
			}

			if($homeScore != '' && $awayScore != '')
			{
				$pModel		= $this->getModel("ProcessModel");
				$pModel->resultGameProcess($childSn, $homeScore, $awayScore, "");
			}*/
		}

		if($parsingType=='') $parsingType = "ALL";
		if($perpage=='') $perpage = 300;
		if($moneyOption=='') $moneyOption=0;

		$minBettingMoney='';
		if($moneyOption==0)		$minBettingMoney='';
		if($moneyOption==1)		$minBettingMoney=1;

		if($filterTeam!='')
		{
			if($filterTeamType=='league')
			{
				$rs = $leagueModel->getListByLikeName($filterTeam);

				for($i=0; $i<count((array)$rs); ++$i)
				{
					$leagueSn[] = $rs[$i]['sn'];
				}
			}
			else if($filterTeamType=='home_team')
			{
				$homeTeam = Trim($filterTeam);
			}
			else if($filterTeamType=='away_team')
			{
				$awayTeam = Trim($filterTeam);
			}
		}
		if($beginDate=="" || $endDate=="")
		{
			$beginDate 	= date("Y-m-d");
			$endDate		= date("Y-m-d",strtotime ("+1 days"));
		}

		$page_act= "parsing_type=".$parsingType."&state=".$state."&game_type=".$gameType."&categoryName=".$categoryName."&special_type=".$specialType."&perpage=".$perpage."&begin_date=".$beginDate."&end_date=".$endDate."&filter_team_type=".$filterTeamType."&filter_team=".$filterTeam."&filter_betting_total=".$filterBettingTotal."&money_option=".$moneyOption."&modifyFlag=".$modifyFlag."&sort=".$sort;

		$bettingEnable = "";
		if($state=="20")
		{
			$filterState 		= "2";
			$bettingEnable 	= "1";
		}
		else if($state=="21")
		{
			$filterState = "2";
			$bettingEnable 	= "-1";
		}
		else
		{
			$filterState = $state;
		}

		//-> 시간지난 경기 숨김 처리.
		$gameModel->hideTimeOverGame();

		$total_info = $gameModel->getListTotalofLive($filterState, $categoryName, $gameType, $specialType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, $modifyFlag);
		$total = $total_info["cnt"];
		$leagueList = $total_info["league_list"];

		$pageMaker = $this->displayPage($total, $perpage, $page_act);
		$list = $gameModel->getListofLive($pageMaker->first, $pageMaker->listNum, $filterState, $categoryName, $gameType, $specialType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, $modifyFlag, $sort);

		for($i=0; $i<count((array)$list); ++$i)
		{
			$item = $cartModel->getTeamTotalBetMoney($list[$i]['child_sn']);

			$list[$i]['home_total_betting'] = $item['home_total_betting'];
			$list[$i]['active_home_total_betting'] = $item['active_home_total_betting'];
			$list[$i]['home_count'] = $item['home_count'];

			$list[$i]['home_team'] = strip_tags(html_entity_decode($list[$i]['home_team']));
			$list[$i]['away_team'] = strip_tags(html_entity_decode($list[$i]['away_team']));

			$list[$i]['draw_total_betting'] = $item['draw_total_betting'];
			$list[$i]['active_draw_total_betting'] = $item['active_draw_total_betting'];
			$list[$i]['draw_count'] = $item['draw_count'];

			$list[$i]['away_total_betting'] = $item['away_total_betting'];
			$list[$i]['active_away_total_betting'] = $item['active_away_total_betting'];
			$list[$i]['away_count'] = $item['away_count'];

			$list[$i]['total_betting'] = $item['home_total_betting']+$item['draw_total_betting']+$item['away_total_betting'];
			$list[$i]['active_total_betting'] = $item['active_home_total_betting']+$item['active_draw_total_betting']+$item['active_away_total_betting'];
			$list[$i]['betting_count'] = $item['home_count']+$item['draw_count']+$item['away_count'];
		}

		$this->view->assign("pidx", $pidx);
		$this->view->assign("kind", $kind);
		$this->view->assign("category_list", $categoryList);
		$this->view->assign("league_list", $leagueList);
		$this->view->assign("gameType", $gameType);
		$this->view->assign("gameHour", $gameHour);
		$this->view->assign("gameTime", $gameTime);
		$this->view->assign("league", $league);

		$this->view->assign("league_sn",$leagueSn);
		$this->view->assign("modifyFlag",$modifyFlag);
		$this->view->assign("parsing_type",$parsingType);
		$this->view->assign("special_type",$specialType);
		$this->view->assign("money_option",$moneyOption);
		$this->view->assign("gameType",$gameType);
		$this->view->assign("categoryName",$categoryName);
		$this->view->assign("search",$search);
		$this->view->assign("state",$state);
		$this->view->assign("list",$list);
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('filter_team', $filterTeam);
		$this->view->assign('filter_team_type', $filterTeamType);
		$this->view->assign("league_list",$leagueList);
		$this->view->assign("sort",$sort);

		$this->display();
	}

	//▶  경기업로드 (다기준) 
	function popup_gameMultiUploadAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/gameUpload/popup.game_multi_upload.html");
		$gameModel = $this->getModel("GameModel");
		$cartModel 		= $this->getModel("CartModel");
		$leagueModel = $this->getModel("LeagueModel");
		
		// 경기종류
		$pidx = $this->request("pidx");
		
		$categoryList = $leagueModel->getCategoryList();
		
		$gameHour = "<select name='gameHour[]' id='game_hour'>";
		for($i=0;$i<24;$i++)
		{
			$j=$i;
			if($j<10) {$j="0".$j;}
			$gameHour=$gameHour."<option value='".$j."'>".$j."</option>";
		}
		$gameHour = $gameHour . "</select>";		
		
		$gameTime = "<select name='gameTime[]' id='game_time'>";
		for($i=0;$i<60;$i++)
		{
			$j=$i;
			if($j<10)	{$j="0".$j;}
			$gameTime=$gameTime."<option value='".$j."'>".$j."</option>";
		}
		$gameTime = $gameTime . "</select>";

		$leagueList = $leagueModel->getListAll($where);

		//// game_list part
		$act  				= $this->request("act");
		$state  			= $this->request("state");
		$perpage			= $this->request("perpage");
		$specialType	= $this->request("search_special_type");
		$categoryName = $this->request("search_categoryName");
		$gameType 		= $this->request("search_game_type");
		$moneyOption = $this->request("money_option");
		$beginDate  		= $this->request('begin_date');
		$endDate 				= $this->request('end_date');
		$filterTeam			= $this->request('filter_team');
		$filterTeamType	= $this->request('filter_team_type');
		$parsingType = $this->request("search_parsing_type");
		$modifyFlag = $this->request("modifyFlag");
		$leagueSn = $this->request("search_league_sn");
		$sort = $this->request("sort");

//-> 경기수정 경기보기
		if ( $modifyFlag == "on" ) $modifyFlag = 0;
		else $modifyFlag = "";

		if($sort == null) $sort = '';

		//-> 상단 파싱정보 초기화.
		$etcModel = $this->getModel("EtcModel");
		$etcModel->updateParsingStatus("new_rate");
		$etcModel->updateParsingStatus("new_game");

		if($act=="modify_state")
		{
			$subchildSn = $this->request('subchild_sn'); //경기인텍스
			$newState= $this->request('new_state');
			if ( $newState != "rateUpdate" ) {
				if($newState == 2)
				{
					$gameModel->blockGameMulti($subchildSn);
					$newState=-1;  // 블록된 경기를 대기상태로 함.
				}
				$gameModel->modifyChildStausMulti($subchildSn,$newState);
			} else {
				$gameModel->modifyChildNewRateMulti($subchildSn);
			}
		}
		else if($act=="delete_game")
		{
			$subchildSn = $this->request('subchild_sn');
			$gameModel->delSubChildMulti($subchildSn);
		}
		else if($act=="delete_game_db")
		{
			$subchildSn = $this->request('subchild_sn');
			$gameModel->delSubChildDB($subchildSn);
		}
		else if($act=='deadline_game')
		{
			$subchildSn = $this->request('subchild_sn');
			$gameModel->modifyGameTimeMulti($subchildSn);
		}
		else if($act=='apply')
		{
			/*$childSn = $this->request('child_sn');
			$gameDate = $this->request('gameDate');
			$gameHour = $this->request('gameHour');
			$gameTime = $this->request('gameTime');
			$homeRate = $this->request('homeRate');
			$drawRate = $this->request('drawRate');
			$awayRate = $this->request('awayRate');
			$homeScore = $this->request('homeScore');
			$awayScore = $this->request('awayScore');

			$db_item = $gameModel->getChildRow($childSn);

			if($gameDate != $db_item['gameDate'] || $gameHour != $db_item['gameHour'] || $gameTime != $db_item['gameTime'])
			{
				$db_gameStartTime = strtotime($db_item['gameDate']." ".$db_item['gameHour'].":".$db_item['gameTime'].":00");
				if ( $db_gameStartTime < time() ) {
					$url = $_SERVER['HTTP_REFERER'];
					throw new Lemon_ScriptException("경기가 시작되면 수정이 불가능합니다.", "", "go", $url);
					exit;
				}
				$gameModel->modifyChildRate_Date($childSn,$gameDate,$gameHour,$gameTime);
			}

			if($homeRate != '' && $drawRate != '' && $awayRate != '')
			{
				$gameModel->modifyChildRate($childSn,$db_item['type'],$homeRate,$drawRate,$awayRate);
			}

			if($homeScore != '' && $awayScore != '')
			{
				$pModel		= $this->getModel("ProcessModel");
				$pModel->resultGameProcess($childSn, $homeScore, $awayScore, "");
			}*/
		}

		if($parsingType=='') $parsingType = "ALL";
		if($perpage=='') $perpage = 300;
		if($moneyOption=='') $moneyOption=0;

		$minBettingMoney='';
		if($moneyOption==0)		$minBettingMoney='';
		if($moneyOption==1)		$minBettingMoney=1;

		if($filterTeam!='')
		{
			if($filterTeamType=='league')
			{
				$rs = $leagueModel->getListByLikeName($filterTeam);

				for($i=0; $i<count((array)$rs); ++$i)
				{
					$leagueSn[] = $rs[$i]['sn'];
				}
			}
			else if($filterTeamType=='home_team')
			{
				$homeTeam = Trim($filterTeam);
			}
			else if($filterTeamType=='away_team')
			{
				$awayTeam = Trim($filterTeam);
			}
		}
		if($beginDate=="" || $endDate=="")
		{
			$beginDate 	= date("Y-m-d");
			$endDate		= date("Y-m-d",strtotime ("+1 days"));
		}

		$page_act= "parsing_type=".$parsingType."&state=".$state."&game_type=".$gameType."&categoryName=".$categoryName."&special_type=".$specialType."&perpage=".$perpage."&begin_date=".$beginDate."&end_date=".$endDate."&filter_team_type=".$filterTeamType."&filter_team=".$filterTeam."&filter_betting_total=".$filterBettingTotal."&money_option=".$moneyOption."&modifyFlag=".$modifyFlag."&sort=".$sort;

		$bettingEnable = "";
		if($state=="20")
		{
			$filterState 		= "2";
			$bettingEnable 	= "1";
		}
		else if($state=="21")
		{
			$filterState = "2";
			$bettingEnable 	= "-1";
		}
		else
		{
			$filterState = $state;
		}

		//-> 시간지난 경기 숨김 처리.
		$gameModel->hideTimeOverGame(2);

		$total_info = $gameModel->getMultiListTotalofLive($filterState, $categoryName, $gameType, $specialType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, $modifyFlag);
		$total = $total_info["cnt"];
		$leagueList = $total_info["league_list"];

		$pageMaker = $this->displayPage($total, $perpage, $page_act);
		$list = $gameModel->getMultiListofLive($pageMaker->first, $pageMaker->listNum, $filterState, $categoryName, $gameType, $specialType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, $modifyFlag, $sort);

		for($i=0; $i<count((array)$list); ++$i)
		{
			$item = $cartModel->getTeamTotalBetMoney($list[$i]['child_sn'], 2);

			$list[$i]['home_total_betting'] = $item['home_total_betting'];
			$list[$i]['active_home_total_betting'] = $item['active_home_total_betting'];
			$list[$i]['home_count'] = $item['home_count'];

			$list[$i]['home_team'] = strip_tags(html_entity_decode($list[$i]['home_team']));
			$list[$i]['away_team'] = strip_tags(html_entity_decode($list[$i]['away_team']));

			$list[$i]['draw_total_betting'] = $item['draw_total_betting'];
			$list[$i]['active_draw_total_betting'] = $item['active_draw_total_betting'];
			$list[$i]['draw_count'] = $item['draw_count'];

			$list[$i]['away_total_betting'] = $item['away_total_betting'];
			$list[$i]['active_away_total_betting'] = $item['active_away_total_betting'];
			$list[$i]['away_count'] = $item['away_count'];

			$list[$i]['total_betting'] = $item['home_total_betting']+$item['draw_total_betting']+$item['away_total_betting'];
			$list[$i]['active_total_betting'] = $item['active_home_total_betting']+$item['active_draw_total_betting']+$item['active_away_total_betting'];
			$list[$i]['betting_count'] = $item['home_count']+$item['draw_count']+$item['away_count'];
		}

		$this->view->assign("pidx", $pidx);
		$this->view->assign("kind", $kind);
		$this->view->assign("category_list", $categoryList);
		$this->view->assign("league_list", $leagueList);
		$this->view->assign("gameType", $gameType);
		$this->view->assign("gameHour", $gameHour);
		$this->view->assign("gameTime", $gameTime);
		$this->view->assign("league", $league);

		$this->view->assign("league_sn",$leagueSn);
		$this->view->assign("modifyFlag",$modifyFlag);
		$this->view->assign("parsing_type",$parsingType);
		$this->view->assign("special_type",$specialType);
		$this->view->assign("money_option",$moneyOption);
		$this->view->assign("gameType",$gameType);
		$this->view->assign("categoryName",$categoryName);
		$this->view->assign("search",$search);
		$this->view->assign("state",$state);
		$this->view->assign("list",$list);
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('filter_team', $filterTeam);
		$this->view->assign('filter_team_type', $filterTeamType);
		$this->view->assign("league_list",$leagueList);
		$this->view->assign("sort",$sort);

		$this->display();
	}

	function gameUpdateProcessAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}

		$gameModel = $this->getModel("GameModel");

		$childSn = $this->request('child_sn');
		$gameDate = $this->request('gameDate');
		$gameHour = $this->request('gameHour');
		$gameTime = $this->request('gameTime');
		$homeRate = $this->request('homeRate');
		$drawRate = $this->request('drawRate');
		$awayRate = $this->request('awayRate');
		$homeScore = $this->request('homeScore');
		$awayScore = $this->request('awayScore');

		$db_item_array = $gameModel->getChildJoinSubChild($childSn);
		$url = $_SERVER['HTTP_REFERER'];

		$db_item = $db_item_array[0];

		if($gameDate != $db_item['gameDate'] || $gameHour != $db_item['gameHour'] || $gameTime != $db_item['gameTime'])
		{
			/*$db_gameStartTime = strtotime($db_item['gameDate']." ".$db_item['gameHour'].":".$db_item['gameTime'].":00");
			if ( $db_gameStartTime < time() ) {

				throw new Lemon_ScriptException("경기가 시작되면 수정이 불가능합니다.", "", "go", $url);
				exit;
			}*/
			$gameModel->modifyChildRate_Date($childSn,$gameDate,$gameHour,$gameTime);
		}

		if($homeRate != '' && $drawRate != '' && $awayRate != '')
		{
			if($homeRate != $db_item['home_rate'] || $drawRate != $db_item['draw_rate'] || $awayRate != $db_item['away_rate'])
			{
				$gameModel->modifyChildRate($childSn,$db_item['type'],$homeRate,$drawRate,$awayRate);
			}
		}

		if($homeScore != '' && $awayScore != '')
		{
			if($homeScore != $db_item['home_score'] || $awayScore != $db_item['away_score'])
			{
				$pModel		= $this->getModel("ProcessModel");
				$pModel->resultGameProcess($childSn, $homeScore, $awayScore, "");
			}
		}

		throw new Lemon_ScriptException("수정되었습니다.", "", "go", $url);
	}

	
	//▶ 게임 업로드 처리
	function gameuploadProcessAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/gameUpload/popup.game_upload.html");
		
		$leagueModel = $this->getModel("LeagueModel");
		$gmodel = $this->getModel("GameModel");
		
		$intParentIdx		= empty($this->request("pidx")) ? 0 : $this->request("pidx");
		$kind_arr			= $this->request("kind");
		$kubun				= $this->request("kubun");
		$gameType_arr		= $this->request("gametype");
		$league_arr			= $this->request("league");
		$gameDate_arr		= $this->request("gameDate");
		$gameHour_arr		= $this->request("gameHour");
		$gameTime_arr		= $this->request("gameTime");
		$HomeTeam_arr		= $this->request("HomeTeam");
		$AwayTeam_arr		= $this->request("AwayTeam");
		$type_a_arr			= $this->request("type_a");
		$type_b_arr			= $this->request("type_b");
		$type_c_arr			= $this->request("type_c");
		$isEvents			= $this->request("is_event");
		$specialTypeArray	= $this->request("special_type");
		
		$strrep	=	true;

		$reg_game_count = 0;
		for($i=0;$i<count($kind_arr);$i++)
		{
			$kind 		 	 = $kind_arr[$i];
			$gameType 	 = trim($gameType_arr[$i]);
			$leagueSn 	 = empty(trim($league_arr[$i])) ? 0 : trim($league_arr[$i]);
			$gameDate 	 = trim($gameDate_arr[$i]);
			$gameHour 	 = trim($gameHour_arr[$i]);
			$gameTime 	 = trim($gameTime_arr[$i]);
			$HomeTeam 	 = trim($HomeTeam_arr[$i]);
			$HomeTeam	  = str_replace("'","&#039;",$HomeTeam);
			$AwayTeam 	 = trim($AwayTeam_arr[$i]);
			$AwayTeam 	 = str_replace("'","&#039;",$AwayTeam);
			$homeRate 	 = trim($type_a_arr[$i]);
			$drawRate 	 = trim($type_b_arr[$i]);
			$awayRate	 	 = trim($type_c_arr[$i]);
			$specialType = trim($specialTypeArray[$i]);
			$is_specified_special = 0;

			$param_all = $kind.$gameType.$leagueSn.$gameDate.$gameHour.$gameTime.$HomeTeam.$AwayTeam.$homeRate.$drawRate.$awayRate.$specialType;
			if($param_all == '')
				continue;

			if($gameType==5)
			{
				$gameType = 1;
				$is_specified_special = 1;
			}
			
			if($gameType==1 && ($drawRate=="1.00" || $drawRate=="1.0" || $drawRate=="1"))
				$drawRate="1.00";
	
			$LeagueName	 = '';
			$LeagueImg	 = '';
			$type		 = '';
			
			$rs = $leagueModel->getListBySn( $leagueSn );
			if( count((array)$rs) <= 0 )
			{
				echo "인덱스번호[" .$leagueSn. "] 에 해당되는 리그정보가 디비에 없습니다";
				exit;				
			}
			else
			{
				$LeagueName = $rs["name"];
				$LeagueImg = $rs["lg_img"];
				if( $is_specified_special == 1)
				{
					if( false!=strstr($LeagueName, "득점/무득점"))
					{
						$HomeTeam =$HomeTeam."[득점]";
						$Context = "[무득점]";
						$AwayTeam = $Context.$AwayTeam;
					}
				}
			}			
			
			//if($kubun=="") $kubun = 'null';
			if($kubun=="") $kubun = 0;
		
			$gmodel->addChild($intParentIdx,$kind,$rs["lsports_league_sn"],$HomeTeam,$AwayTeam,$gameDate,$gameHour,$gameTime,$LeagueName,$kubun,$gameType,$specialType,$homeRate,$drawRate,$awayRate, $is_specified_special, $LeagueImg);
			$reg_game_count++;
		}

		if($reg_game_count == 0)
		{
			throw new Lemon_ScriptException("","","script","alert('등록된 경기가 없습니다.');location.href='/gameUpload/popup_gameupload';");
		} else {
			throw new Lemon_ScriptException("","","script","alert('경기등록이 완료되었습니다.');location.href='/gameUpload/popup_gameupload';");
		}

		//$this->display();
	}

	//▶ 게임 업로드 처리
	function gameMultiUploadProcessAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/gameUpload/popup.game_multi_upload.html");
		
		$leagueModel = $this->getModel("LeagueModel");
		$gmodel = $this->getModel("GameModel");
		
		$intParentIdx		= $this->request("pidx");
		$kind_arr			= $this->request("kind");
		$kubun				= $this->request("kubun");
		$gameType_arr		= $this->request("gametype");
		$league_arr			= $this->request("league");
		$gameDate_arr		= $this->request("gameDate");
		$gameHour_arr		= $this->request("gameHour");
		$gameTime_arr		= $this->request("gameTime");
		$HomeTeam_arr		= $this->request("HomeTeam");
		$AwayTeam_arr		= $this->request("AwayTeam");
		$type_a_arr			= $this->request("type_a");
		$type_b_arr			= $this->request("type_b");
		$type_c_arr			= $this->request("type_c");
		$isEvents			= $this->request("is_event");
		$specialTypeArray	= $this->request("special_type");
		
		$strrep	=	true;

		$reg_game_count = 0;
		for($i=0;$i<count($kind_arr);$i++)
		{
			$kind 		 	 = $kind_arr[$i];
			$gameType 	 = trim($gameType_arr[$i]);
			$leagueSn 	 = trim($league_arr[$i]);
			$gameDate 	 = trim($gameDate_arr[$i]);
			$gameHour 	 = trim($gameHour_arr[$i]);
			$gameTime 	 = trim($gameTime_arr[$i]);
			$HomeTeam 	 = trim($HomeTeam_arr[$i]);
			$HomeTeam	  = str_replace("'","&#039;",$HomeTeam);
			$AwayTeam 	 = trim($AwayTeam_arr[$i]);
			$AwayTeam 	 = str_replace("'","&#039;",$AwayTeam);
			$homeRate 	 = trim($type_a_arr[$i]);
			$drawRate 	 = trim($type_b_arr[$i]);
			$awayRate	 	 = trim($type_c_arr[$i]);
			$specialType = trim($specialTypeArray[$i]);
			$is_specified_special = 0;

			$param_all = $kind.$gameType.$leagueSn.$gameDate.$gameHour.$gameTime.$HomeTeam.$AwayTeam.$homeRate.$drawRate.$awayRate.$specialType;
			if($param_all == '')
				continue;

			if($gameType==5)
			{
				$gameType = 1;
				$is_specified_special = 1;
			}
			
			if($gameType==1 && ($drawRate=="1.00" || $drawRate=="1.0" || $drawRate=="1"))
				$drawRate="1.00";
	
			$LeagueName	 = '';
			$type		 = '';
			
			$rs = $leagueModel->getListBySn( $leagueSn );
			if( count((array)$rs) <= 0 )
			{
				echo "인덱스번호[" .$leagueSn. "] 에 해당되는 리그정보가 디비에 없습니다";
				exit;				
			}
			else
			{
				$LeagueName = $rs["name"];
				if( $is_specified_special == 1)
				{
					if( false!=strstr($LeagueName, "득점/무득점"))
					{
						$HomeTeam =$HomeTeam."[득점]";
						$Context = "[무득점]";
						$AwayTeam = $Context.$AwayTeam;
					}
				}
			}			
			
			if($kubun=="") $kubun = 'null';
		
			$gmodel->addChildMulti($intParentIdx,$kind,$leagueSn,$HomeTeam,$AwayTeam,$gameDate,$gameHour,$gameTime,'',$kubun,$gameType,$specialType,$homeRate,$drawRate,$awayRate, $is_specified_special);
			$reg_game_count++;
		}

		if($reg_game_count == 0)
		{
			throw new Lemon_ScriptException("","","script","alert('등록된 경기가 없습니다.');location.href='/gameUpload/popup_gameMultiUpload';");
		} else {
			throw new Lemon_ScriptException("","","script","alert('경기등록이 완료되었습니다.');location.href='/gameUpload/popup_gameMultiUpload';");
		}

		//$this->display();
	}
	
	//▶ 게임 발매 수정 
	function modifyStausProcessAction()
	{
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$childSn 			= $this->request('child_sn');    //경기인텍스				
		$state 				= $this->request('state');
		$state  			= $this->request("state");
		$perpage			= $this->request("perpage");
		$specialType	= $this->request("special_type");
		$categoryName = $this->request("categoryName");
		$gameType 		= $this->request("game_type");
		
		$moneyOption 	= $this->request("money_option");
		$beginDate  	= $this->request('begin_date');
		$endDate 			= $this->request('end_date');
		$filterTeam			= $this->request('filter_team');
		$filterTeamType	= $this->request('filter_team_type');

		$model = $this->getModel("GameModel");
		$model->modifyChildStaus($childSn,$state);
		
		$param="state=".$state."&game_type=".$gameType."&categoryName=".$categoryName."&special_type=".$specialType."&perpage=".$perpage."&begin_date=".$beginDate."&end_date=".$endDate."&filter_team_type=".$filterTeamType."&filter_team=".$filterTeam."&money_option=".$moneyOption;
		
		$url = "/gameUpload/gamelist?".$param;
		throw new Lemon_ScriptException("변경되었습니다.","","go","/gameUpload/");
	}
	
	
	function get_fsock_data($domain,$url,$port=80,$timeout=30)
	{
		$fp = fsockopen($domain,$port,$errstr,$timeout) or die($errstr);
		if($fp)
		{
			echo "#### 포트 연결 성공 ####";
		 	echo "<br>";
		 
			$out = "GET $url HTTP/1.1\r\n";
			$out .= "Host: $domain\r\n";
			$out .= "Connection: Close\r\n\r\n";
			fwrite($fp,$out);
			$res = '';
			while(!feof($fp)){
				$res .= fgets($fp,128);
			}			
			fclose($fp);
			$pattern = '/HTTP\/1\.\d\s(\d+)/';
			if( preg_match($pattern,$res,$matches)&& $matches[1] == 200){
				$data_arr = explode("\r\n\r\n", $res);				
				
				$data = $data_arr[1];
				$enc = mb_detect_encoding($data,array('EUC-KR','UTF-8','shift_jis','CN-GB'));
				
				if( $enc != 'UTF-8') {
					$data = iconv($enc,'UTF-8',$data);
				}
				return $data;				
			}
		}
		else
		{
			echo "#### 포트 연결 실패 ####";
		 	echo "<br>";
		}
		
		return false;
	}
	
	
	function readFile($filename, $count = 2000, $tag = "\r\n") 
	{
		$content = "";
		$_current = "";
		$step= 1;
		$tagLen = strlen($tag);
		$start = 0;
		$i = 0;
		$handle = fopen($filename,'r');

		$content = stream_get_contents($handle);
		
		fclose($handle);
		
		return $content;
	}
	
	function find_array_str($arr,$str)
	{
		$flag=false;
		for($i=0;$i<count($arr);$i++)
		{
			if($arr[$i]==$str)
			{
				$flag=true;
				break;
			}
		}
		return $flag;
	}
}
?>
