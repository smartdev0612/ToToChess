<?
/*
* Index Controller
*/
class LiveGameController extends WebServiceController 
{
	public function collectAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/live/collect_live.html");
		
		$liveGameModel = $this->getModel("LiveGameModel");
		$events = $liveGameModel->today_live_games();
				
		$leagueModel = $this->getModel("LeagueModel");
		$leagues = $leagueModel->getListByCategory('축구');
		foreach($leagues as $league)
		{
			$options .= "<option value='".$league['sn']."'>".$league['name']."</option>";
		}
		
		$this->view->assign("sort_field",$sort_field);
		$this->view->assign("options",$options);
		$this->view->assign("leagues",$leagues);
		$this->view->assign("events",$events);
		$this->display();
	}
	
	public function uploadAction()
	{
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$event_ids = $this->request("y_id");
		
		$liveGameModel = $this->getModel("LiveGameModel");
		foreach($event_ids as $id)
		{
			$event_id = $id;
			$league_sn = $this->request('league_sn_'.$id);
			$start_time = $this->request('event_date_'.$id);
			$home_team = $this->request('home_team_'.$id);
			$away_team = $this->request('away_team_'.$id);
		
			$liveGameModel->insert_live_game($event_id, $league_sn, $home_team, $away_team, $start_time);	
		}
		throw new Lemon_ScriptException("등록되었습니다.", "", "go", "/LiveGame/collect");
		exit;
	}
	
	public function live_game_listenerAction()
	{
		$liveGameModel = $this->getModel("LiveGameModel");
		$liveGameModel->live_event_listener();
	}
	
	function live_main_bets_listenerAction()
	{	
		$liveGameModel = $this->getModel("LiveGameModel");
		$liveGameModel->live_event_main_bets_listener2();
	}
	
	public function game_listAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/live/game_list.html");
		
		$liveGameModel = $this->getModel("LiveGameModel");
		$model 	= $this->getModel("GameModel");
		$cModel = $this->getModel("CartModel");
		$leagueModel = $this->getModel("LeagueModel");
		
		$act = $this->request("act");
		$state = $this->request("state");
		$search = $this->request("search");
		$perpage = $this->request("perpage");
		$specialType = $this->request("special_type");
		$categoryName = $this->request("categoryName");
		$gameType = $this->request("game_type");
		
		$beginDate  		= $this->request('begin_date');
		$endDate 				= $this->request('end_date');
		$filterTeam			= $this->request('filter_team');
		$filterTeamType	= $this->request('filter_team_type');
		$filterBettingTotal	= $this->request('filter_betting_total');
		
		
		if($act=='deadline_game')
		{
			$childSn = $this->request('child_sn'); //경기인텍스
			$model->modifyGameTime($childSn);
		}
		
		if($perpage=='') $perpage=50;

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
		
		$page_act = "perpage=".$perpage."&state=".$state."&search=".$search."&special_type=".$specialType."&categoryName=".$categoryName."&game_type=".$gameType."&begin_date=".$beginDate."&end_date=".$endDate."&filter_team_type=".$filterTeamType."&filter_betting_total=".$filterBettingTotal;
		
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
		
		$total = $liveGameModel->getAdminLiveGameTotal();
		$pageMaker 	= $this->displayPage($total, $perpage, $page_act);
		$list = $liveGameModel->getAdminLiveGameList();
		
		for($i=0; $i<count((array)$list); ++$i)
		{
			$item = $liveGameModel->getTeamTotalBetMoney($list[$i]['live_detail_sn']);
			
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
}
?>
