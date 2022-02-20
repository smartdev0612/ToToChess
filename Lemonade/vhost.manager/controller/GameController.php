<?
/*
* Index Controller
*/
class GameController extends WebServiceController 
{

	var $commentListNum = 10;
	
	//▶ 게임설정 
	public function gamelistAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/game/game_list.html");
		
		$model 	= $this->getModel("GameModel");
		$cModel = $this->getModel("CartModel");
		$leagueModel = $this->getModel("LeagueModel");
		
		$act  				= $this->request("act");
		$state  				= $this->request("state");
		$search					= $this->request("search");
		$perpage				= $this->request("perpage");
		$specialType		= $this->request("special_type");
		$categoryName 	= $this->request("categoryName");
		$gameType 			= $this->request("game_type");
		
		$beginDate  		= $this->request('begin_date');
		$endDate 				= $this->request('end_date');
		$filterTeam			= $this->request('filter_team');
		$filterTeamType	= $this->request('filter_team_type');
		$filterBettingTotal	= $this->request('filter_betting_total');
		$parsingType = $this->request("parsing_type");
		$modifyFlag = $this->request("modifyFlag");
		$leagueSn = $this->request("league_sn");


		if($_SESSION["member"]["sn"] =="1001"){
			$membervip ="1";
			if($specialType == ""){
				$specialType = "5";
			}
		}else{
			$membervip ="0";
		}

		//-> 경기수정 경기보기
		if ( $modifyFlag == "on" ) $modifyFlag = 0;
		else $modifyFlag = "";

		//-> 상단 파싱정보 초기화.
		$etcModel = $this->getModel("EtcModel");		
		$etcModel->updateParsingStatus("new_date");
		
		if($act=='deadline_game')
		{
			$childSn = $this->request('child_sn'); //경기인텍스
			$model->modifyGameTime($childSn);
		}

		if($parsingType=='') $parsingType = "ALL";
		//if($perpage=='') 
		$perpage=20;

		$minBettingMoney='';
		if($filterBettingTotal!='')	$minBettingMoney=$filterBettingTotal*10000; /*만원단위*/
		
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
			else if($filterTeamType=='home_team') {$homeTeam = Trim($filterTeam);}
			else if($filterTeamType=='away_team')	{$awayTeam = Trim($filterTeam);}
		}
		if($beginDate == "" || $endDate == "")
		{
			$beginDate 	= date("Y-m-d");
			$endDate	= date("Y-m-d",strtotime ("+1 days"));
		}
		
		$page_act = "parsing_type=".$parsingType."&perpage=".$perpage."&state=".$state."&search=".$search."&special_type=".$specialType."&categoryName=".$categoryName."&game_type=".$gameType."&begin_date=".$beginDate."&end_date=".$endDate."&filter_team_type=".$filterTeamType."&filter_betting_total=".$filterBettingTotal."&modifyFlag=".$modifyFlag."&leagueSn=".$leagueSn;
		
		$bettingEnable = "";
		if($state=="20")
		{
			$filterState 	= "2";
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
		
		$total_info = $model->getManageListTotal($filterState, $categoryName, $gameType, $specialType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, $modifyFlag, $leagueSn);
		$total = $total_info["cnt"];
		$leagueList = $total_info["league_list"];

		$pageMaker = $this->displayPage($total, $perpage, $page_act);
		$list = $model->getManageList($pageMaker->first, $pageMaker->listNum, $filterState, $categoryName, $gameType, $specialType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, $modifyFlag, $leagueSn);
		
		for($i=0; $i<count((array)$list); ++$i)
		{
			//$item = $cModel->getTeamTotalBetMoney($list[$i]['child_sn']);
            $item = $cModel->getTeamTotalBetMoney2($list[$i]['sn']);

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
		$this->view->assign("league_sn",$leagueSn);
		$this->view->assign("membervip",$membervip);
		$this->view->assign("modifyFlag",$modifyFlag);
		$this->view->assign("parsing_type",$parsingType);
		$this->view->assign("special_type",$specialType);
		$this->view->assign("gameType",$gameType);
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('filter_team', $filterTeam);
		$this->view->assign('filter_team_type', $filterTeamType);
		$this->view->assign('filter_betting_total', $filterBettingTotal);
		$this->view->assign("categoryName",$categoryName);
		$this->view->assign("categoryList",$categoryList);
		$this->view->assign("state",$state);
		$this->view->assign("list",$list);
		$this->view->assign("league_list",$leagueList);

		$this->display();
	}

	public function refreshBetListAction()
	{
		$page				= $this->request("page");
		$perpage				= $this->request("perpage");
		$begin_date 			= $this->request("begin_date");
		$end_date 				= $this->request("end_date");
		$last_special_code = $this->request("last_special_code");
		$sel_result				= $this->request("sel_result");
		$selectKeyword		= $this->request("select_keyword");
		$keyword				= $this->request("keyword");

		$gameListModel 	= $this->getModel("GameListModel");

		$where=" ";
		if ( $last_special_code == "fx" ) {
			$where.= " and a.last_special_code in (35, 39, 40, 41, 42)";
		} else if ( $last_special_code == "3" ) {
			$where.= " and a.last_special_code = ".$last_special_code;
		}

		if($sel_result==="0") 			$where.= " and a.result=0";
		elseif(($sel_result==="1"))	$where.= " and a.result=1";
		elseif(($sel_result==="2"))	$where.= " and a.result=2";

		if($keyword!="")
		{
			if($selectKeyword=="uid")							$where.=" and c.uid like('%".$keyword."%') ";
			else if($selectKeyword=="nick")				$where.=" and c.nick like('%".$keyword."%') ";
			else if($selectKeyword=="betting_no")		$where.=" and a.betting_no like('%".$keyword."%') ";
			else if($selectKeyword=="money_up")		$where.=" and a.betting_money > '".$keyword."' ";
			else if($selectKeyword=="money_down")		$where.=" and a.betting_money < '".$keyword."' ";
			else if($selectKeyword=="home")		$where.=" and d.home_team like '%".$keyword."%' ";
			else if($selectKeyword=="away")		$where.=" and d.away_team like '%".$keyword."%' ";
		}

		$where.=" and date(a.regdate) >= '".$begin_date."' and date(a.regdate) <= '".$end_date."' ";
		$orderby = " order by a.sn desc ";
		//$limit = " limit ".(($page-1)*$perpage).", ".$perpage;
		$limit = " ";

		$result_list = $gameListModel->getResultUpdatedBettingList($where, $orderby, $limit);
		//$new_list = $gameListModel->getNewBettingList("", $where, $orderby);

		if(!isset($result_list))
			$result_list = array();

		$result = array(
			'update'=>$result_list,
			//'new'=>$new_list
		);

		echo json_encode($result);
	}

	public function refreshMultiBetListAction()
	{
		$page				= $this->request("page");
		$perpage				= $this->request("perpage");
		$begin_date 			= $this->request("begin_date");
		$end_date 				= $this->request("end_date");
		$sel_result				= $this->request("sel_result");
		$selectKeyword		= $this->request("select_keyword");
		$keyword				= $this->request("keyword");

		$gameListModel 	= $this->getModel("GameListModel");

		$where=" ";

		if($sel_result==="0") 			$where.= " and a.result=0";
		elseif(($sel_result==="1"))	$where.= " and a.result=1";
		elseif(($sel_result==="2"))	$where.= " and a.result=2";

		if($keyword!="")
		{
			if($selectKeyword=="uid")							$where.=" and c.uid like('%".$keyword."%') ";
			else if($selectKeyword=="nick")				$where.=" and c.nick like('%".$keyword."%') ";
			else if($selectKeyword=="betting_no")		$where.=" and a.betting_no like('%".$keyword."%') ";
			else if($selectKeyword=="money_up")		$where.=" and a.betting_money > '".$keyword."' ";
			else if($selectKeyword=="money_down")		$where.=" and a.betting_money < '".$keyword."' ";
			else if($selectKeyword=="home")		$where.=" and d.home_team like '%".$keyword."%' ";
			else if($selectKeyword=="away")		$where.=" and d.away_team like '%".$keyword."%' ";
		}

		$where.=" and date(a.regdate) >= '".$begin_date."' and date(a.regdate) <= '".$end_date."' ";
		$orderby = " order by a.sn desc ";
		//$limit = " limit ".(($page-1)*$perpage).", ".$perpage;
		$limit = " ";

		$result_list = $gameListModel->getResultUpdatedBettingList($where, $orderby, $limit, 2);
		//$new_list = $gameListModel->getNewBettingList("", $where, $orderby);

		if(!isset($result_list))
			$result_list = array();

		$result = array(
			'update'=>$result_list,
			//'new'=>$new_list
		);

		echo json_encode($result);
	}

    public function gamelist_ajaxAction()
    {
        $model 	= $this->getModel("GameModel");
        $cModel = $this->getModel("CartModel");
        $leagueModel = $this->getModel("LeagueModel");

        $act  				= $this->request("act");
        $state  				= $this->request("state");
        $search					= $this->request("search");
        $perpage				= $this->request("perpage");
        $specialType		= $this->request("special_type");
        $categoryName 	= $this->request("categoryName");
        $gameType 			= $this->request("game_type");

        $beginDate  		= $this->request('begin_date');
        $endDate 				= $this->request('end_date');
        $filterTeam			= $this->request('filter_team');
        $filterTeamType	= $this->request('filter_team_type');
        $filterBettingTotal	= $this->request('filter_betting_total');
        $parsingType = $this->request("parsing_type");
        $modifyFlag = $this->request("modifyFlag");
        $leagueSn = $this->request("league_sn");

        if($_SESSION["member"]["sn"] =="1001"){
            $membervip ="1";
            if($special_type ==""){
                $special_type = "5";
            }
        }else{
            $membervip ="0";
        }

        //-> 경기수정 경기보기
        if ( $modifyFlag == "on" ) $modifyFlag = 0;
        else $modifyFlag = "";

        //-> 상단 파싱정보 초기화.
        $etcModel = $this->getModel("EtcModel");
        $etcModel->updateParsingStatus("new_date");

        if($act=='deadline_game')
        {
            $childSn = $this->request('child_sn'); //경기인텍스
            $model->modifyGameTime($childSn);
        }

        if($parsingType=='') $parsingType = "ALL";
        if($perpage=='') $perpage=300;

        $minBettingMoney='';
        if($filterBettingTotal!='')	$minBettingMoney=$filterBettingTotal*10000; /*만원단위*/

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
            else if($filterTeamType=='home_team') {$homeTeam = Trim($filterTeam);}
            else if($filterTeamType=='away_team')	{$awayTeam = Trim($filterTeam);}
        }
        if($beginDate=="" || $endDate=="")
        {
            $beginDate 	= date("Y-m-d");
            $endDate		= date("Y-m-d",strtotime ("+1 days"));
        }

        $page_act = "parsing_type=".$parsingType."&perpage=".$perpage."&state=".$state."&search=".$search."&special_type=".$specialType."&categoryName=".$categoryName."&game_type=".$gameType."&begin_date=".$beginDate."&end_date=".$endDate."&filter_team_type=".$filterTeamType."&filter_betting_total=".$filterBettingTotal."&modifyFlag=".$modifyFlag."&leagueSn=".$leagueSn;

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

        $total_info = $model->getListTotal($filterState, $categoryName, $gameType, $specialType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, $modifyFlag, $leagueSn);
        $total = $total_info["cnt"];

        $pageMaker = $this->displayPage($total, $perpage, $page_act);
        $list = $model->getList_simple($pageMaker->first, $pageMaker->listNum, $filterState, $categoryName, $gameType, $specialType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, $modifyFlag, $leagueSn);

        for($i=0; $i<count((array)$list); ++$i)
        {
            $item = $cModel->getTeamTotalBetMoney2($list[$i]['child_sn']);

            $list[$i]['home_team'] = strip_tags(html_entity_decode($list[$i]['home_team']));
            $list[$i]['away_team'] = strip_tags(html_entity_decode($list[$i]['away_team']));

            $list[$i]['home_total_betting'] = number_format($item['home_total_betting'],0);
            $list[$i]['active_home_total_betting'] = number_format($item['active_home_total_betting'],0);

            $list[$i]['draw_total_betting'] = number_format($item['draw_total_betting'],0);
            $list[$i]['active_draw_total_betting'] = number_format($item['active_draw_total_betting'],0);

            $list[$i]['away_total_betting'] = number_format($item['away_total_betting'],0);
            $list[$i]['active_away_total_betting'] = number_format($item['active_away_total_betting'],0);
        }

        if(isset($list))
		{
            echo json_encode($list);
		} else {
            echo json_encode(array());
		}
    }
	//▶ 게임설정
	public function gamelist_sadariAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/game/game_list_sadari.html");
		
		$model 	= $this->getModel("GameModel");
		$cModel = $this->getModel("CartModel");
		$leagueModel = $this->getModel("LeagueModel");
		
		$act  				= $this->request("act");
		$state  				= $this->request("state");
		$search					= $this->request("search");
		$perpage				= $this->request("perpage");
		$specialType		= $this->request("special_type");	
		$beginDate  		= $this->request('begin_date');
		$endDate 				= $this->request('end_date');

		$specialType = "5"; //-> 사다리
		if($parsingType=='') $parsingType = "A";		
		if($perpage=='') $perpage=9;

		if($beginDate=="" || $endDate=="") {
			$beginDate = date("Y-m-d");
			$endDate = date("Y-m-d",strtotime("+1 days"));
		}
			
		$bettingEnable = "";
		if($state=="20") {
			$filterState 		= "2";
			$bettingEnable 	= "1";
		} else if($state=="21") {
			$filterState = "2";
			$bettingEnable 	= "-1";
		} else {
			$filterState = $state;
		}

		$page_act = "perpage=".$perpage."&state=".$state."&search=".$search."&begin_date=".$beginDate."&end_date=".$endDate;
		
		$total = $model->getListTotal($filterState, $categoryName, $gameType, $specialType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, $modifyFlag);
		$total = $total_info["cnt"];
		$leagueList = $total_info["league_list"];

		$pageMaker = $this->displayPage($total, $perpage, $page_act);
		$list = $model->getList($pageMaker->first, $pageMaker->listNum, $filterState, $categoryName, $gameType, $specialType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, $bettingEnable, $parsingType, $modifyFlag);
		
		if(is_array($list) && count((array)$list) > 0) {
			for($i=0; $i<count((array)$list); ++$i)
			{
				$item = $cModel->getTeamTotalBetMoney($list[$i]['child_sn']);
				
				$list[$i]['home_total_betting'] = $item['home_total_betting'];
				$list[$i]['active_home_total_betting'] = $item['active_home_total_betting'];
				$list[$i]['home_count'] = $item['home_count'];
				
				$list[$i]['away_total_betting'] = $item['away_total_betting'];
				$list[$i]['active_away_total_betting'] = $item['active_away_total_betting'];
				$list[$i]['away_count'] = $item['away_count'];
				
				$list[$i]['total_betting'] = $item['home_total_betting']+$item['draw_total_betting']+$item['away_total_betting'];
				$list[$i]['active_total_betting'] = $item['active_home_total_betting']+$item['active_draw_total_betting']+$item['active_away_total_betting'];
				$list[$i]['betting_count'] = $item['home_count']+$item['draw_count']+$item['away_count'];
			}	
		}	
		$categoryList = $leagueModel->getCategoryList();

		$this->view->assign("membervip",$membervip);
		$this->view->assign("modifyFlag",$modifyFlag);
		$this->view->assign("parsing_type",$parsingType);
		$this->view->assign("special_type",$specialType);
		$this->view->assign("gameType",$gameType);
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('filter_team', $filterTeam);
		$this->view->assign('filter_team_type', $filterTeamType);
		$this->view->assign('filter_betting_total', $filterBettingTotal);
		$this->view->assign("categoryName",$categoryName);
		$this->view->assign("categoryList",$categoryList);
		$this->view->assign("state",$state);
		$this->view->assign("top_list",$topList);
		$this->view->assign("list",$list);

		$this->display();
	}

	//▶ 게임설정
	public function configAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/game/config.html");
		
		$gameModel = $this->getModel("GameModel");
		
		$total = $gameModel->getParentTotal();
		$pageMaker = $this->displayPage($total, 10);
		$list = $gameModel->getParentList($pageMaker->first, $pageMaker->listNum);
		
		$this->view->assign("list",$list);	
		
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
		$this->view->define("content","content/game/bet_list.html");
		
		$model			= $this->getModel("GameModel");
		$loginModel		= $this->getModel("LoginModel");
		$cartModel		= $this->getModel("CartModel");
		$memberModel	= $this->getModel("MemberModel");
		$gameListModel 	= $this->getModel("GameListModel");
		
		$last_special_code 		= $this->request("last_special_code");
		$sel_result				= $this->request("sel_result");
		$mode 					= $this->request("mode");
		$activeBet				= $this->request("active_bet");
		$perpage				= $this->request("perpage");
		$selectKeyword			= $this->request("select_keyword");
		$keyword				= $this->request("keyword");
		$showDetail 			= $this->request("show_detail");
		$begin_date 			= $this->request("begin_date");
		$end_date 				= $this->request("end_date");
		
		if($activeBet=='') 		{$activeBet = 0;}
		if($perpage=='') 		{$perpage = 40;}
		if($showDetail=='')		{$showDetail = 0;}

		$where="";
		if($_SESSION["member"]["sn"] =="1001"){
			$membervip ="1";
			//if($special_type ==""){
				$where.= " and a.last_special_code > 4";
			//}
		}else{
			$membervip ="0";
		}

		if($mode=="search")
		{
			if ( intval($last_special_code) < 3) {
				$alramFlagName = "betting_sport";
				$where.= " AND b.live = 0 AND (b.betid != '' OR b.betid = 'bonus') AND a.last_special_code != 3 ";
			} else if ( $last_special_code == "3" ) {
				$alramFlagName = "betting_realtime";
				$where.= " AND a.last_special_code = 3";
			} else if ( $last_special_code == "4" ) {
				$alramFlagName = "betting_live";
				$where.= " AND b.live = 1 ";
			} else if ( $last_special_code == "5" ) {
				$alramFlagName = "betting_sadari";
				$where.= " and a.last_special_code = 5";
			} else if ( $last_special_code == "6" ) {
				$alramFlagName = "betting_race";
				$where.= " and a.last_special_code = 6";
			} else if ( $last_special_code == "7" ) {
				$alramFlagName = "betting_powerball";
				$where.= " and a.last_special_code = 7";
			} else if ( $last_special_code == "8" ) {
				$alramFlagName = "betting_dari";
				$where.= " and a.last_special_code = 8";
			} else if ( $last_special_code == "21" ) {
				$alramFlagName = "betting_nine";
				$where.= " and a.last_special_code = 21";
			} else if ( $last_special_code == "22" ) {
                $alramFlagName = "betting_vfootball";
                $where.= " and a.last_special_code = 22";
            } else if ( $last_special_code == "24" ) {
                $alramFlagName = "betting_kenosadari";
                $where.= " and a.last_special_code = 24";
            } else if ( $last_special_code == "25" ) {
                $alramFlagName = "betting_powersadari";
                $where.= " and a.last_special_code = 25";
            } else if ( $last_special_code == "26" ) {
                $alramFlagName = "betting_mgmoddeven";
                $where.= " and a.last_special_code = 26";
            } else if ( $last_special_code == "27" ) {
                $alramFlagName = "betting_mgmbacara";
                $where.= " and a.last_special_code = 27";
            } else if ( $last_special_code == "28" ) {
                $alramFlagName = "betting_lowhi";
                $where.= " and a.last_special_code = 28";
            } else if ( $last_special_code == "29" ) {
                $alramFlagName = "betting_aladin";
                $where.= " and a.last_special_code = 29";
            } else if ( $last_special_code == "30" ) {
                $alramFlagName = "betting_2dari";
                $where.= " and a.last_special_code = 30";
            } else if ( $last_special_code == "31" ) {
                $alramFlagName = "betting_3dari";
                $where.= " and a.last_special_code = 31";
            } else if ( $last_special_code == "32" ) {
                $alramFlagName = "betting_choice";
                $where.= " and a.last_special_code = 32";
            } else if ( $last_special_code == "33" ) {
                $alramFlagName = "betting_roulette";
                $where.= " and a.last_special_code = 33";
            } else if ( $last_special_code == "34" ) {
                $alramFlagName = "betting_pharaoh";
                $where.= " and a.last_special_code = 34";
            } else if ( $last_special_code == "fx" ) {
				$alramFlagName = "betting_fx";
				$where.= " and a.last_special_code in (35, 39, 40, 41, 42)";
			}

			//-> 알람 초기화.
			if ( $alramFlagName ) {
				$configModel = $this->getModel("ConfigModel");
				$configModel->modifyAlramFlag($alramFlagName,0);
				$configModel->modifyAlramFlag($alramFlagName."_big",0);
			}

			if($sel_result==="0") 			$where.= " and a.result=0";
			elseif(($sel_result==="1"))	$where.= " and a.result=1";
			elseif(($sel_result==="2"))	$where.= " and a.result=2";
			
			if($keyword!="")
			{
				if($selectKeyword=="uid")							$where.=" and c.uid like ('%".$keyword."%') ";
				else if($selectKeyword=="nick")				$where.=" and c.nick like ('%".$keyword."%') ";
				else if($selectKeyword=="betting_no")		$where.=" and a.betting_no like ('%".$keyword."%') ";
				else if($selectKeyword=="money_up")		$where.=" and a.betting_money > '".$keyword."' ";
				else if($selectKeyword=="money_down")		$where.=" and a.betting_money < '".$keyword."' ";
				else if($selectKeyword=="home")		$where.=" and d.home_team like '%".$keyword."%' ";
				else if($selectKeyword=="away")		$where.=" and d.away_team like '%".$keyword."%' ";
				else $where .= " and (c.uid like ('%".$keyword."%') or c.nick like ('%".$keyword."%') or a.betting_no like ('%".$keyword."%') or d.notice like '%".$keyword."%' or d.home_team like '%".$keyword."%' or d.away_team like '%".$keyword."%') ";
			}
		}

		if($begin_date=="" || $end_date=="")
		{
			$begin_date		= date("Y-m-d",strtotime ("-1 days"));
			$end_date		= date("Y-m-d");
		}
	
		$page_act = "perpage=".$perpage."&last_special_code=".$last_special_code."&sel_result=".$sel_result."&mode=".$mode."&active_bet=".$activeBet."&select_keyword=".$selectKeyword."&keyword=".$keyword."&show_detail=".$showDetail."&begin_date=".$begin_date."&end_date=".$end_date;
		
		$where.=" and a.is_account=1 ";
		
		$where.=" and date(a.regdate) >= '".$begin_date."' and date(a.regdate) <= '".$end_date."' ";
		
		$total 			= $gameListModel->getAdminBettingListTotal("", $where);
		$pageMaker 	= $this->displayPage($total, $perpage, $page_act);
		$list 			= $gameListModel->getAdminBettingList("", $where, $pageMaker->first, $pageMaker->listNum);
		
		$sumList = $cartModel->getTotalBetMoney();

		$head_sn = $this->auth->getSn();
		$isGhost = $loginModel->isGhostManger($head_sn);
		
		$this->view->assign("membervip",$membervip);
		$this->view->assign("show_detail",$showDetail);
		$this->view->assign("select_keyword",$selectKeyword);
		$this->view->assign("keyword",$keyword);
		$this->view->assign("last_special_code",$last_special_code);
		$this->view->assign("sel_result",$sel_result);
		$this->view->assign("active_bet",$activeBet);
		$this->view->assign("perpage",$perpage);
		//$this->view->assign("betting_no",$bettingNo);
		$this->view->assign("list",$list);
		$this->view->assign("sumList",$sumList);
		$this->view->assign("begin_date",$begin_date);
		$this->view->assign("end_date",$end_date);
		$this->view->assign("is_ghost", $isGhost);

		$this->display();
	}

	//▶ 베팅 목록 (다기준)
	public function betlist_multiAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/game/bet_list_multi.html");
		
		$model					= $this->getModel("GameModel");
		$cartModel				= $this->getModel("CartModel");
		$memberModel		= $this->getModel("MemberModel");
		$gameListModel 	= $this->getModel("GameListModel");
		
		$sel_result				= $this->request("sel_result");
		$mode 					= $this->request("mode");
		$activeBet				= $this->request("active_bet");
		$perpage				= $this->request("perpage");
		$selectKeyword			= $this->request("select_keyword");
		$keyword				= $this->request("keyword");
		$showDetail 			= $this->request("show_detail");
		$begin_date 			= $this->request("begin_date");
		$end_date 				= $this->request("end_date");
		
		if($activeBet=='') 		{$activeBet = 0;}
		if($perpage=='') 		{$perpage = 60;}
		if($showDetail=='')		{$showDetail = 0;}

		$where="";
		if($_SESSION["member"]["sn"] =="1001"){
			$membervip ="1";
		}else{
			$membervip ="0";
		}

		if($mode=="search")
		{
			$alramFlagName = "betting_sport_m";

			//-> 알람 초기화.
			if ( $alramFlagName ) {
				$configModel = $this->getModel("ConfigModel");
				$configModel->modifyAlramFlag($alramFlagName,0);
				$configModel->modifyAlramFlag($alramFlagName."_big",0);
			}

			if($sel_result==="0") 			$where.= " and a.result=0";
			elseif(($sel_result==="1"))	$where.= " and a.result=1";
			elseif(($sel_result==="2"))	$where.= " and a.result=2";
			
			if($keyword!="")
			{
				if($selectKeyword=="uid")							$where.=" and c.uid like('%".$keyword."%') ";
				else if($selectKeyword=="nick")				$where.=" and c.nick like('%".$keyword."%') ";
				else if($selectKeyword=="betting_no")		$where.=" and a.betting_no like('%".$keyword."%') ";
				else if($selectKeyword=="money_up")		$where.=" and a.betting_money > '".$keyword."' ";
				else if($selectKeyword=="money_down")		$where.=" and a.betting_money < '".$keyword."' ";
				else if($selectKeyword=="home")		$where.=" and d.home_team like '%".$keyword."%' ";
				else if($selectKeyword=="away")		$where.=" and d.away_team like '%".$keyword."%' ";
			}
		}

		if($begin_date=="" || $end_date=="")
		{
			$begin_date		= date("Y-m-d",strtotime ("-1 days"));
			$end_date		= date("Y-m-d");
		}
	
		$page_act = "perpage=".$perpage."&sel_result=".$sel_result."&mode=".$mode."&active_bet=".$activeBet."&select_keyword=".$selectKeyword."&keyword=".$keyword."&show_detail=".$showDetail."&begin_date=".$begin_date."&end_date=".$end_date;
		
		$where.=" and a.is_account=1 ";
		
		$where.=" and date(a.regdate) >= '".$begin_date."' and date(a.regdate) <= '".$end_date."' ";
		
		$total 			= $gameListModel->getAdminBettingListTotal("", $where, 2);
		$pageMaker 	= $this->displayPage($total, $perpage, $page_act);
		$list 			= $gameListModel->getAdminBettingList("", $where, $pageMaker->first, $pageMaker->listNum, 2);

		$sumList = $cartModel->getTotalBetMoney();
		
		$this->view->assign("membervip",$membervip);
		$this->view->assign("show_detail",$showDetail);
		$this->view->assign("select_keyword",$selectKeyword);
		$this->view->assign("keyword",$keyword);
		$this->view->assign("last_special_code",$last_special_code);
		$this->view->assign("sel_result",$sel_result);
		$this->view->assign("active_bet",$activeBet);
		$this->view->assign("perpage",$perpage);
		//$this->view->assign("betting_no",$bettingNo);
		$this->view->assign("list",$list);
		$this->view->assign("sumList",$sumList);
		$this->view->assign("begin_date",$begin_date);
		$this->view->assign("end_date",$end_date);

		$this->display();
	}

	//-> 오버배팅 체크를 위한.
	public function betOverCheckAction() {
		$this->commonDefine();
		
		if(!$this->auth->isLogin()) {
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/game/bet_list_over.html");
		$gameListModel 	= $this->getModel("GameListModel");

		$list = $gameListModel->getAdminBettingListOver($where);
		//echo count($list);

		$this->view->assign("list",$list);
		$this->display();
	}

	//▶ 베팅 취소 목록
	public function betcancellistAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/game/bet_cancel_list.html");
		
		$model 	= $this->getModel("GameModel");
		$cartModel = $this->getModel("CartModel");
		$memberModel = $this->getModel("MemberModel");
		$gameListModel 	= $this->getModel("GameListModel");
		$config_Model 	= $this->getModel("ConfigModel");
		
		$sel_result 		= $this->request("sel_result");
		$mode 					= $this->request("mode");
		$activeBet			= $this->request("active_bet");
		$perpage				= $this->request("perpage");
		$selectKeyword	= $this->request("select_keyword");
		$keyword				= $this->request("keyword");
		$showDetail 		= $this->request("show_detail");
		$bettingNo 			= $this->request("betting_no");
		$begin_date 			= $this->request("begin_date");
		$end_date 				= $this->request("end_date");
		
		//$config_Model->modifyAlramFlag("big_bet", "off");
		
		if($activeBet=='') 	{$activeBet = 0;}
		if($perpage=='') 		{$perpage = 30;}
		if($showDetail=='') {$showDetail = 1;}

		$where="";
		if($mode=="search")
		{
			if($sel_result==="0") 			$where.= " and a.result=0";
			elseif(($sel_result==="1"))	$where.= " and a.result=1";
			elseif(($sel_result==="2"))	$where.= " and a.result=2";
			
			if($keyword!="")
			{
				if($selectKeyword=="uid")							$where.=" and c.uid like('%".$keyword."%') ";
				else if($selectKeyword=="nick")				$where.=" and c.nick like('%".$keyword."%') ";
				else if($selectKeyword=="name")				$where.=" and c.name like('%".$keyword."%') ";
				else if($selectKeyword=="betting_no")	$where.=" and a.betting_no like('%".$keyword."%') ";
			}
		}
	
		if($begin_date=="" || $end_date=="")
		{
			$begin_date		= date("Y-m-d",strtotime ("-1 days"));
			$end_date		= date("Y-m-d");
		}
	
		$page_act = "perpage=".$perpage."&sel_result=".$sel_result."&mode=".$mode."&active_bet=".$activeBet."&select_keyword=".$selectKeyword."&keyword=".$keyword."&show_detail=".$showDetail."&begin_date=".$begin_date."&end_date=".$end_date;
		
		$where.=" and a.is_account=1 ";
		
		$where.=" and date(a.regdate) >= '".$begin_date."' and date(a.regdate) <= '".$end_date."' ";

		$total 			= $gameListModel->getAdminBettingCancelListTotal("", $where);
		$pageMaker 	= $this->displayPage($total, $perpage, $page_act);
		$list 			= $gameListModel->getAdminBettingCancelList("", $where, $pageMaker->first, $pageMaker->listNum);

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
		$this->view->assign("begin_date",$begin_date);
		$this->view->assign("end_date",$end_date);

		$this->display();
	}

	//▶ 베팅 취소 목록
	public function betcancellistMultiAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/game/bet_cancel_list_multi.html");
		
		$model 	= $this->getModel("GameModel");
		$cartModel = $this->getModel("CartModel");
		$memberModel = $this->getModel("MemberModel");
		$gameListModel 	= $this->getModel("GameListModel");
		$config_Model 	= $this->getModel("ConfigModel");
		
		$sel_result 		= $this->request("sel_result");
		$mode 					= $this->request("mode");
		$activeBet			= $this->request("active_bet");
		$perpage				= $this->request("perpage");
		$selectKeyword	= $this->request("select_keyword");
		$keyword				= $this->request("keyword");
		$showDetail 		= $this->request("show_detail");
		$bettingNo 			= $this->request("betting_no");
		$begin_date 			= $this->request("begin_date");
		$end_date 				= $this->request("end_date");
		
		//$config_Model->modifyAlramFlag("big_bet", "off");
		
		if($activeBet=='') 	{$activeBet = 0;}
		if($perpage=='') 		{$perpage = 30;}
		if($showDetail=='') {$showDetail = 1;}

		$where="";
		if($mode=="search")
		{
			if($sel_result==="0") 			$where.= " and a.result=0";
			elseif(($sel_result==="1"))	$where.= " and a.result=1";
			elseif(($sel_result==="2"))	$where.= " and a.result=2";
			
			if($keyword!="")
			{
				if($selectKeyword=="uid")							$where.=" and c.uid like('%".$keyword."%') ";
				else if($selectKeyword=="nick")				$where.=" and c.nick like('%".$keyword."%') ";
				else if($selectKeyword=="name")				$where.=" and c.name like('%".$keyword."%') ";
				else if($selectKeyword=="betting_no")	$where.=" and a.betting_no like('%".$keyword."%') ";
			}
		}
	
		if($begin_date=="" || $end_date=="")
		{
			$begin_date		= date("Y-m-d",strtotime ("-1 days"));
			$end_date		= date("Y-m-d");
		}
	
		$page_act = "perpage=".$perpage."&sel_result=".$sel_result."&mode=".$mode."&active_bet=".$activeBet."&select_keyword=".$selectKeyword."&keyword=".$keyword."&show_detail=".$showDetail."&begin_date=".$begin_date."&end_date=".$end_date;
		
		$where.=" and a.is_account=1 ";
		
		$where.=" and date(a.regdate) >= '".$begin_date."' and date(a.regdate) <= '".$end_date."' ";

		$total 			= $gameListModel->getAdminBettingCancelListTotal("", $where);
		$pageMaker 	= $this->displayPage($total, $perpage, $page_act);
		$list 			= $gameListModel->getAdminBettingCancelList("", $where, $pageMaker->first, $pageMaker->listNum);

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
		$this->view->assign("begin_date",$begin_date);
		$this->view->assign("end_date",$end_date);

		$this->display();
	}
	
	
	//▶ 베팅리스트-적특처리
	public function exceptionBetProcessAction()
	{
		$sn = $this->request("sn");
		$cartModel = $this->getModel("CartModel");
		
		$bettingNo = $cartModel->modifyExceptionBet($sn);
		if ( $bettingNo > 0 ) {
			$processModel = $this->getModel("ProcessModel");
			$processModel->bettingProcProcess($bettingNo);
		}
		
		$url = "/game/betlist";
		throw new Lemon_ScriptException("처리되었습니다.", "", "go", $url);
		exit;
	}

	//▶ 베팅리스트-수동처리팝업
	public function result_processAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/game/result_process.html");
		
		$sn = empty($this->request("sn")) ? 0 : $this->request("sn");
		$mode = empty($this->request("mode")) ? "" : $this->request("mode");
		$cartModel = $this->getModel("CartModel");
		$processModel = $this->getModel("ProcessModel");

		$betting_info = $cartModel->getBettingInfoBySn($sn);
		
		if($mode == "edit")
		{
			$result = empty($this->request("result")) ? 0 : $this->request("result");
			$bettingNo = $cartModel->changeBettingResult($sn, $result);
			if ( $bettingNo > 0 ) {
				$processModel->modifyResultMoneyProcess($bettingNo);
				$this->requestRemoveBettingInfo($sn);
			}
			throw new Lemon_ScriptException("", "" , "script", "alert('처리 되었습니다.'); opener.document.location.reload(); self.close();");
		}

		$this->view->assign("sn",$sn);
		$this->view->assign("betting_info",$betting_info);
		$this->display();
	}

	//▶ 베팅리스트-배팅조작팝업
	public function result_resettleAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/game/result_resettle.html");
		
		$sn = empty($this->request("sn")) ? 0 : $this->request("sn");
		$mode = empty($this->request("mode")) ? "" : $this->request("mode");
		$cartModel = $this->getModel("CartModel");
		$processModel = $this->getModel("ProcessModel");

		$betting_info = $cartModel->getBettingInfoBySn($sn);
		
		if($mode == "edit")
		{
			$betting_no = empty($this->request("betting_no")) ? 0 : $this->request("betting_no");
			$select_no = empty($this->request("select_no")) ? 0 : $this->request("select_no");
			$result = empty($this->request("result")) ? 0 : $this->request("result");
			$cart_info = $cartModel->getCartInfo($betting_no);
			if(count($cart_info) > 0) {
				if($cart_info["result"] > 0) {
					// 정산취소
					$processModel->cancel_bet_result_process($betting_no, $sn, $cart_info["member_sn"], $cart_info["last_special_code"]);
				} 
				$bettingNo = $cartModel->changeBettingResult($sn, $result, $select_no);
				if ( $bettingNo > 0 ) {
					$processModel->modifyResultMoneyProcess($bettingNo);
				}
				throw new Lemon_ScriptException("", "" , "script", "alert('처리 되었습니다.'); opener.document.location.reload(); self.close();");
			} else {
				throw new Lemon_ScriptException("", "" , "script", "alert('처리중 오류가 발행하였습니다.'); opener.document.location.reload(); self.close();");
			}
			
		}

		$this->view->assign("sn",$sn);
		$this->view->assign("betting_info",$betting_info);
		$this->display();
	}
 
 

	//▶ 베팅리스트-적특처리 (다기준)
	public function exceptionBetProcessMultiAction()
	{
		$sn = $this->request("sn");
		$cartModel = $this->getModel("CartModel");
		
		$bettingNo = $cartModel->modifyExceptionBet($sn);
		if ( $bettingNo > 0 ) {
			$processModel = $this->getModel("ProcessModel");
			$processModel->bettingProcProcess($bettingNo);
		}
		
		$url = "/game/betlist_multi";
		throw new Lemon_ScriptException("처리되었습니다.", "", "go", $url);
		exit;
	}
	
	//▶ 베팅 취소
	public function betcancelProcessAction()
	{
		$perpage					= $this->request("perpage");
		$select_keyword			= $this->request("select_keyword");
		$keyword					= $this->request("keyword");
		$page							= $this->request("page");
		$show_detail				= $this->request("show_detail");
		$result					= $this->request("result");
		$sel_result					= $this->request("sel_result");
		$mode							= $this->request("mode");	
		
		if(!strpos($_SESSION["quanxian"],"1002"))
		{
			throw new Lemon_ScriptException("해당 권한이 제한되었습니다");			
			exit();
		}

		$pModel  = $this->getModel("ProcessModel");
		
		$bettingNo 	= $this->request("betting_no");
		$oper		= $this->request("oper");
		$check_date = $this->request("check_date");

		if ( $result != 0 ) {
			throw new Lemon_ScriptException("경기 결과가 나온 이력은 취소가 불가능합니다.");
			exit();
		}

/*
		if (strtotime(date("Y-m-d H:i"))-strtotime($check_date)>0){
			throw new Lemon_ScriptException("시작된 경기가 포함된 배팅입니다.");			
			exit();
		}
*/

		if($oper=="race") 
		{
			$url = "/game/betlist?perpage=".$perpage."&select_keyword=".$select_keyword."&keyword=".$keyword."&page=".$page."&show_detail=".$show_detail."&sel_result=".$sel_result."&mode=search";
			//"&active_bet=".$activeBet.;
		}

		/* $res = $this->checkbettingCancel($bettingNo);

		if($res["status"] > 0) {
			throw new Lemon_ScriptException($res["msg"]);			
			exit();
		} */
		
		$pModel->bettingCancelProcess($bettingNo, '관리자');

		$this->requestRemoveBettingNo($bettingNo);

		$this->alertRedirect("취소 되었습니다", $url);
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
		$todayCancelCnt = $gameModel->getTodayBettingCancelCnt();
		
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
			return $res;
		}
		
		if($special < 5) {
			if(($nowTime - $bettingTime) > $cancelAfterTime * 60) {
				$res["status"] = 1; 
				$res["msg"] = "배팅후 {$cancelAfterTime}분이내에만 취소가 가능합니다.";
				return $res;
			} else if (($gameStartTime - $nowTime) < $cancelBeforeTime * 60) {
				$res["status"] = 2; 
				$res["msg"] = "경기시작 {$cancelBeforeTime}분전까지만 취소가 가능합니다.";
				return $res;
			}
		}

		return $res;

	}

	//▶ 베팅 취소 (다기준)
	public function betcancelProcessMultiAction()
	{
		$perpage					= $this->request("perpage");
		$select_keyword			= $this->request("select_keyword");
		$keyword					= $this->request("keyword");
		$page							= $this->request("page");
		$show_detail				= $this->request("show_detail");
		$result					= $this->request("result");
		$sel_result					= $this->request("sel_result");
		$mode							= $this->request("mode");	
		
		if(!strpos($_SESSION["quanxian"],"1002"))
		{
			throw new Lemon_ScriptException("해당 권한이 제한되었습니다");			
			exit();
		}
		$pModel  = $this->getModel("ProcessModel");
		
		$bettingNo 	= $this->request("betting_no");
		$oper		= $this->request("oper");
		$check_date = $this->request("check_date");

		if ( $result != 0 ) {
			throw new Lemon_ScriptException("경기 결과가 나온 이력은 취소가 불가능합니다.");
			exit();
		}

/*
		if (strtotime(date("Y-m-d H:i"))-strtotime($check_date)>0){
			throw new Lemon_ScriptException("시작된 경기가 포함된 배팅입니다.");			
			exit();
		}
*/

		if($oper=="race") 
		{
			$url = "/game/betlist_multi?perpage=".$perpage."&select_keyword=".$select_keyword."&keyword=".$keyword."&page=".$page."&show_detail=".$show_detail."&sel_result=".$sel_result."&mode=search";
			//"&active_bet=".$activeBet.;
		}
		
		$pModel->bettingCancelProcessMulti($bettingNo);
		
		$this->alertRedirect("삭제 되었습니다", $url);
	}
	
	//▶ 팝업 베팅 목록
	public function popup_bet_listAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/game/popup_bet_list.html");
		
		$model 	= $this->getModel("GameModel");
		$cartModel = $this->getModel("CartModel");
		$memberModel = $this->getModel("MemberModel");
		$gameListModel = $this->getModel("GameListModel");
		
		$subchildSn				= $this->request("sn");
		$selectNo				= $this->request("select_no");
		$sel_result 		= $this->request("sel_result");
		$mode 					= $this->request("mode");
		$activeBet			= $this->request("active_bet");
		$perpage				= $this->request("page_size");
		$selectKeyword	= $this->request("select_keyword");
		$keyword				= $this->request("keyword");
		$showDetail 		= $this->request("show_detail");
		$bettingNo 			= $this->request("betting_no");
		$begin_date 			= $this->request("begin_date");
		$end_date 				= $this->request("end_date");

		if($subchildSn=="")
			exit();
		
		if($activeBet=='') 	$activeBet = 0;
		if($perpage=='') 		$perpage = 30;
		if($showDetail=='') $showDetail = 0;

		$where="";
		if($mode=="search")
		{
			switch($sel_result)
			{
				case 0: $where = " and a.result='0'"; break;
				case 1: $where = " and a.result='1'"; break;
				case 2: $where = " and a.result='2'"; break;
				case 9: $where=""; break;
			}
			
			if($keyword!="")
			{
				if($selectKeyword=="uid")							$where.=" and e.uid like('%".$keyword."%') ";
				else if($selectKeyword=="nick")				$where.=" and e.nick like('%".$keyword."%') ";
				else if($selectKeyword=="betting_no")	$where.=" and a.betting_no like('%".$keyword."%') ";
				else if($selectKeyword=="money_up")		$where.=" and a.betting_money > '".$keyword."' ";
				else if($selectKeyword=="money_down")		$where.=" and a.betting_money < '".$keyword."' ";
			}
			$where.=" and date(a.regdate) >= '".$begin_date."' and date(a.regdate) <= '".$end_date."' ";
		}
		
		$page_act = "perpage=".$perpage."&sel_result=".$sel_result."&mode=".$mode."&active_bet=".$activeBet."&select_keyword=".$selectKeyword."&keyword=".$keyword."&show_detail=".$showDetail."&child_sn=".$childSn."&select_no=".$selectNo;
		
		$total 			= $gameListModel->getGameSnBettingListTotal($where, $activeBet, $subchildSn, $selectNo);
		$pageMaker 	= $this->displayPage($total, $perpage, $page_act);
		$list 			= $gameListModel->getGameSnBettingList($where, $pageMaker->first, $pageMaker->listNum, $activeBet, $subchildSn, $selectNo);
		
		$this->view->assign("sn",$subchildSn);
		$this->view->assign("select_no",$selectNo);
		$this->view->assign("show_detail",$showDetail);
		$this->view->assign("select_keyword",$selectKeyword);
		$this->view->assign("keyword",$keyword);
		$this->view->assign("sel_result",$sel_result);
		$this->view->assign("active_bet",$activeBet);
		$this->view->assign("perpage",$perpage);
		$this->view->assign("betting_no",$bettingNo);
		$this->view->assign("list",$list);
		//$this->view->assign("sumList",$sumList);

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
		$this->view->define("content","content/game/popup.bet_detail.html");
		
		$model 	= Lemon_Instance::getObject("GameModel", true);
		$cModel = Lemon_Instance::getObject("CartModel", true);
		
		$betting_no = $this->request("betting_no");
		$member_sn = $this->request("member_sn");
		
		$list = $cModel->getMemberBetDetailList($betting_no, $member_sn);
		
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
		$this->view->define("content","content/game/popup.game_detail.html");
		
		$model 	= Lemon_Instance::getObject("GameModel", true);
		$cModel 	= Lemon_Instance::getObject("CartModel", true);
		
		
		$child_sn = $this->request("child_sn");
		
		
		$rs = $cModel->getBetByChildSn($child_sn);
		
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
					}elseif($gameselect==2)
					{
						$away_bet_1=$away_bet_1+$money;
					}elseif($gameselect==3)
					{
						$draw_bet=$draw_bet_1+$money;
					}
				}elseif($game_type==2)
				{
					if($gameselect==1)
					{
						$home_bet_2=$home_bet_2+$money;
					}elseif($gameselect==2)
					{
						$away_bet_2=$away_bet_2+$money;
					}
				}elseif($game_type==4)
				{
					if($gameselect==1)
					{
						$home_bet_4=$home_bet_4+$money;
					}elseif($gameselect==2)
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
		$this->view->define("content","content/game/popup.game_detail_multi.html");
		
		$model 	= Lemon_Instance::getObject("GameModel", true);
		$cModel 	= Lemon_Instance::getObject("CartModel", true);
		
		
		$subchild_sn = $this->request("sn");
		
		
		$rs = $cModel->getBetByChildSnMulti($subchild_sn);
		
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
					}elseif($gameselect==2)
					{
						$away_bet_1=$away_bet_1+$money;
					}elseif($gameselect==3)
					{
						$draw_bet=$draw_bet_1+$money;
					}
				}elseif($game_type==2)
				{
					if($gameselect==1)
					{
						$home_bet_2=$home_bet_2+$money;
					}elseif($gameselect==2)
					{
						$away_bet_2=$away_bet_2+$money;
					}
				}elseif($game_type==4)
				{
					if($gameselect==1)
					{
						$home_bet_4=$home_bet_4+$money;
					}elseif($gameselect==2)
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
	
	//▶ 배당 수정
	function modifyrateAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/game/popup.modify_rate.html");
		$model = $this->getModel("GameModel");
		$marketModel = $this->getModel("MarketModel");
		
		$idx 	= $this->request("idx");		
		$gametype 	= $this->request("gametype");
		$mode 	= $this->request("mode");
		
		if($mode == "") {$mode = "add";}

		$item = $model->getChildRowMulti($idx);
		$childSn = $item["child_sn"];
		$sport_sn = $item["sport_id"];
		$leagueName = $model->getRow('name', $model->db_qz.'league', 'sn='.$item["league_sn"]);
		$item['league_name']=$leagueName['name'];	
		
		$rs = $model->getSubChildRowBySn($idx);
		if(count((array)$rs) > 0)
		{
			$home_rate = $rs['home_rate'];
			$draw_rate = $rs['draw_rate'];
			$away_rate = $rs['away_rate'];
			$home_line = $rs['home_line'];
			$home_name = $rs['home_name'];
		}
		
		$marketName = $marketModel->getMarketName($gametype, $sport_sn);
		
		$familyID = $marketModel->getMarketFamily($gametype);
		switch($familyID) {
			case 1:		// 승무패
				if($mode=="update") {$strMode="disabled";}
				$html="<td bgcolor='#ffffff' align='left'>";
				$html=$html."&nbsp;&nbsp;승<input type='text' name='home_rate' size='4' value='".$home_rate."'>";
				$html=$html."&nbsp;무<input type='text' name='draw_rate' size='4' value='".$draw_rate."'>";
				$html=$html."&nbsp;패<input type='text' name='away_rate' size='4' value='".$away_rate."'>";
				$html=$html."&nbsp;&nbsp;</td>" ;
				break;
			case 2:		// 승패
				if($mode=="update") {$strMode="disabled";}
				$html="<td bgcolor='#ffffff' align='left'>";
				$html=$html."&nbsp;&nbsp;승<input type='text' name='home_rate' size='4' value='".$home_rate."'>";
				$html=$html."&nbsp;패<input type='text' name='away_rate' size='4' value='".$away_rate."'>";
				$html=$html."&nbsp;&nbsp;</td>" ;
				break;
			case 7:		// 언더오버
				if($mode=="edit") {$strMode="disabled";}
				$html="<td bgcolor='#ffffff' align='left'>";
				$html=$html."&nbsp;&nbsp;오버<input type='text' name='home_rate' size='4' value='".$home_rate."'>";
				$html=$html."&nbsp;기준점<input type='text' name='draw_rate' size='4' value='".$home_line."' >";
				$html=$html."&nbsp;언더<input type='text' name='away_rate' size='4' value='".$away_rate."'>";
				$html=$html."&nbsp;&nbsp;</td>";
				break;
			case 8:		// 아시안핸디캡
				$home_line = explode(" ", $home_line);
				if($mode=="edit") {$strMode="disabled";}
				$html="<td bgcolor='#ffffff' align='left'>";
				$html=$html."&nbsp;&nbsp;홈배당<input type='text' name='home_rate' size='4' value='".$home_rate ."'>";
				$html=$html."&nbsp;홈핸디<input type='text' name='draw_rate' size='4' value='".$home_line[0]."' >";
				$html=$html."&nbsp;원정팀배당<input type='text' name='away_rate' size='4' value='".$away_rate ."'>";
				$html=$html."&nbsp;&nbsp;</td>";
				break;
			case 9:		// E스포츠 핸디캡
				if($mode=="edit") {$strMode="disabled";}
				$html="<td bgcolor='#ffffff' align='left'>";
				$html=$html."&nbsp;&nbsp;홈배당<input type='text' name='home_rate' size='4' value='".$home_rate ."'>";
				$html=$html."&nbsp;홈핸디<input type='text' name='draw_rate' size='4' value='".$home_line."' >";
				$html=$html."&nbsp;원정팀배당<input type='text' name='away_rate' size='4' value='".$away_rate ."'>";
				$html=$html."&nbsp;&nbsp;</td>";
				break;
			case 10:	// 홀짝
				if($mode=="edit") {$strMode="disabled";}
				$html="<td bgcolor='#ffffff' align='left'>";
				$html=$html."&nbsp;&nbsp;홀<input type='text' name='home_rate' size='4' value='".$home_rate."'>";
				$html=$html."&nbsp;짝<input type='text' name='away_rate' size='4' value='".$away_rate."'>";
				$html=$html."&nbsp;&nbsp;</td>";
				break;
			case 11:	// 정확한 스코어
				if($mode=="edit") {$strMode="disabled";}
				$html="<td bgcolor='#ffffff' align='left'>";
				$html=$html."&nbsp;&nbsp;배당<input type='text' name='home_rate' size='4' value='".$home_rate."'>";
				$html=$html."&nbsp;스코어<input type='text' name='draw_rate' size='4' value='".$home_name."'>";
				$html=$html."&nbsp;&nbsp;</td>";
				break;
				break;
			case 12:	// 더블찬스
				if($mode=="update") {$strMode="disabled";}
				$html="<td bgcolor='#ffffff' align='left'>";
				$html=$html."&nbsp;&nbsp;승무<input type='text' name='home_rate' size='4' value='".$home_rate."'>";
				$html=$html."&nbsp;승패<input type='text' name='draw_rate' size='4' value='".$draw_rate."'>";
				$html=$html."&nbsp;무패<input type='text' name='away_rate' size='4' value='".$away_rate."'>";
				$html=$html."&nbsp;&nbsp;</td>" ;
				break;
			case 47:	// 승무패 + 언더오버
				if($mode=="update") {$strMode="disabled";}
				$html="<td bgcolor='#ffffff' align='left'>";
				$html=$html."&nbsp;&nbsp;배당<input type='text' name='home_rate' size='4' value='".$home_rate."'>";
				$html=$html."&nbsp;기준점<input type='text' name='draw_rate' size='4' value='".$home_line."'>";
				$html=$html."&nbsp;&nbsp;</td>" ;
				break;
		}	
		
		$this->view->assign("idx",$idx);
		$this->view->assign("child_sn", $childSn);	
		$this->view->assign("mode",$mode);
		$this->view->assign("gametype",$gametype);
		$this->view->assign("familyID", $familyID);
		$this->view->assign("marketName", $marketName);
		$this->view->assign("sport_sn", $sport_sn);
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
		$this->view->define("content","content/game/popup.modify_rate_multi.html");
		$model = $this->getModel("GameModel");
		
		$idx 	= $this->request("idx");		
		$gametype 	= $this->request("gametype");
		$mode 	= $this->request("mode");
		
		if($mode == "") {$mode = "add";}

		$item = $model->getChildRowMulti($idx);
		if($item == null)
			return;

		$leagueName = $model->getRow('name', $model->db_qz.'league', 'sn='.$item["league_sn"]);
		$item['league_name']=$leagueName['name'];
		
		$rs = $model->getSubChildRowsMulti($idx);
		if( count((array)$rs) > 0 )
		{
			$home_rate = $rs[0]['home_rate'];
			$draw_rate = $rs[0]['draw_rate'];
			$away_rate = $rs[0]['away_rate'];
			$point = $rs[0]['point'];
		}
		
		$strMode	= "";
		$html 		= "";
		//$add		= "onkeyup='this.value=this.value.replace(/[^0-9.]/gi,\"\")'";
		$add = "";
		switch ($item['sport_name']) {
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
		$this->view->assign("item",$item);
		$this->view->assign("html",$html);
		$this->view->assign("sport_name", $item['sport_name']);
		$this->view->assign("strMode",$strMode);
		$this->view->assign("point",$point);
		
		
		$this->display();
	}
	
	//▶ 경기 배당수정 처리 
	function rateProcessAction()	
	{
		$model 		= $this->getModel("GameModel");
		$subchild_sn = $this->request("idx");	
		$child_sn = $this->request("child_sn");					
		$gametype	= $this->request("gametype");	
		$family_id = $this->request("family_id");
		$home_rate 		= $this->request("home_rate");
		$draw_rate 		= $this->request("draw_rate");
		$away_rate 		= $this->request("away_rate");
		$gameDate 		= $this->request("gameDate");
		$gameHour 		= $this->request("gameHour");		
		$gameTime 		= $this->request("gameTime");

		if ( strlen(trim($gameHour)) == 1 ) $gameHour = "0".$gameHour;
		if ( strlen(trim($gameTime)) == 1 ) $gameTime = "0".$gameTime;

		//-> 경기가 시작되었으면 업데이트 불가능.
		$db_item = $model->getChildRow($child_sn);		
		$db_gameStartTime = strtotime($db_item['gameDate']." ".$db_item['gameHour'].":".$db_item['gameTime'].":00");
		if ( $db_gameStartTime < time() ) {
			$url = $_SERVER['HTTP_REFERER'];
			throw new Lemon_ScriptException("경기가 시작되면 수정이 불가능합니다.", "", "go", $url);
			exit;
		}

		$home_line = "";
		$home_name = "";
		switch($family_id) {
			case 7:		// 언더오버
			case 8:		// 아시안핸디캡
			case 9:		// E스포츠 핸디캡
				$home_line = $draw_rate;
				break;
			case 11:	// 정확한 스코어
				$home_name = $draw_rate;
				break;
			case 47:	// 승무패 + 언더오버
				$home_line = $draw_rate;
				break;
		}	

		$model->modifyChildRate($subchild_sn, $gametype, $home_rate, $draw_rate, $away_rate, $home_line, $home_name);
		$model->modifyChildRate_Date($child_sn,$gameDate,$gameHour,$gameTime);
		
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script>alert('  수정되었습니다   ');opener.document.location.reload(); self.close();</script>";
	}

	//▶ 경기 배당수정 처리 (다기준)
	function rateProcessMultiAction()	
	{
		$model 		= $this->getModel("GameModel");
		$subchildIdx = $this->request("idx");				
		$gametype	= $this->request("gametype");	
		$home_rate 		= $this->request("home_rate");
		$draw_rate 		= $this->request("draw_rate");
		$away_rate 		= $this->request("away_rate");
		$gameDate 		= $this->request("gameDate");
		$gameHour 		= $this->request("gameHour");		
		$gameTime 		= $this->request("gameTime");

		if ( strlen(trim($gameHour)) == 1 ) $gameHour = "0".$gameHour;
		if ( strlen(trim($gameTime)) == 1 ) $gameTime = "0".$gameTime;

		//-> 경기가 시작되었으면 업데이트 불가능.
		$db_item = $model->getChildRowMulti($subchildIdx);		
		$db_gameStartTime = strtotime($db_item['gameDate']." ".$db_item['gameHour'].":".$db_item['gameTime'].":00");
		if ( $db_gameStartTime < time() ) {
			$url = $_SERVER['HTTP_REFERER'];
			throw new Lemon_ScriptException("경기가 시작되면 수정이 불가능합니다.", "", "go", $url);
			exit;
		}

		$model->modifySubChildRate($db_item['child_sn'], $subchildIdx, $db_item['sub_idx'], $gametype,$home_rate,$draw_rate,$away_rate);
		$model->modifyChildRateMulti_Date($subchildIdx,$gameDate,$gameHour,$gameTime);
		
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script>alert('  수정되었습니다   ');opener.document.location.reload(); self.close();</script>";
	}

    //▶ 게임 발매 수정
    function modifyStausProcessAction()
    {
        if(!$this->auth->isLogin())
        {
            $this->loginAction();
            exit;
        }

        //$this->view->define("content","content/game/popup.modify_status_result.html");
        $mode			= $this->request('mode');    //경기인텍스
        $idx 				= $this->request('idx');
        $play 			= $this->request("play");

        $model = $this->getModel("GameModel");
        $model->modifyChildStaus($idx, $play);

        echo "<table width=\"\" border=\"0\" cellspacing=\"1\" cellpadding=\"0\" style=\"margin-left:10px\">
				<tr height=\"30\"><td>변경되었습니다.
					<input type=\"button\" name=\"btnClose\" value=\"닫기\" onclick=\"opener.document.location.reload(); window.close()\"></td>
				</tr>
			</table>";
    }

	function marketListAction() {
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$this->view->define("content","content/game/market_list.html");
		
		$keyword = $this->request('keyword');

		$model 	= $this->getModel("GameModel");
		
		$list = $model->getMarketList($keyword);

		$this->view->assign("list", $list);
		$this->view->assign("keyword", $keyword);
		
		$this->display();
	}

	function saveMarketRateAction() {
		$url = "/game/marketList";

		$model 	= $this->getModel("GameModel");

		$arr = array();

		$sql = "UPDATE tb_markets SET ";
		foreach($_REQUEST as $key => $val) {
			$mid = substr($key, 6);
			$model->getUpdateMarketRate($mid, $val);
			$obj = (object)["nMarket" => $mid, "fRate" => $val];
			array_push($arr, $obj);
		}

		$strValue = json_encode($arr);
        //$strValue = urlencode($strValue);
		$this->requestChangeMarketRate($strValue);
		
		$this->alertRedirect("성공적으로  보관되었습니다.", $url);
	}
}
?>
