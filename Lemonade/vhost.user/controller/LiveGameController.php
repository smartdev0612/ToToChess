<?php 

class LiveGameController extends WebServiceController 
{

	function layoutDefine($type='')
	{
		if($type=='type')
		{
			$this->view->define("index","layout/layout.sports.html");
			$this->view->define(array("header"=>"header/header.html", "top" => "header/top.html", "left" => "left/left.html", "content" => "content/live/board_list.html", "footer" => "footer/bottom.html"));
		}
		else
		{
			$this->view->define("index","layout/layout.sports.html");
		}
	}
	
	function detailAction()
	{
		$this->commonDefine('type');
		$this->view->define(array("content"=>"content/live/live_game_detail.html"));
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$event_id = $this->request('event_id');
		$level		= $this->auth->getLevel();
		
		if( !$this->req->isNumberParameter($event_id))
		{
			throw new Lemon_ScriptException("잘못된 접근입니다.");
			exit;
		}
		
		$etcModel = $this->getModel("EtcModel");
		$liveGameModel = $this->getModel("LiveGameModel");
		
		$games = $liveGameModel->getLiveGameDetail($event_id);
		
		$rs = $etcModel->getMemberLevRow($level, '*');
		$betMinMoney = $rs['lev_min_money'];
		$betMaxMoney = $rs['lev_max_money_single'];
		
		$this->displayRight();
		
		$this->view->define("template_main_bets", "content/live/template_main_bets.html");
		$this->view->define("template_goal_bets", "content/live/template_goal_bets.html");
		$this->view->define("right", "right/right_live.html");
		$this->view->assign("event_id",  $event_id);
		$this->view->assign("games",  $games);
		$this->view->assign("betMinMoney", $betMinMoney);
		$this->view->assign("betMaxMoney", $betMaxMoney);
		$this->display();
	}

	public function listAction()
	{
		$this->commonDefine('type');
		$this->view->define(array("content"=>"content/live/livegame.html"));
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}

		$event_id = $this->request('event_id');
		$live_game_model = $this->getModel("LiveGameModel");		
		$gameList = $live_game_model->getLiveGameList($where);
		
		if ( !$event_id ) {
			if ( count($gameList) > 0 ) {
				foreach ( $gameList as $key => $val ) {
					$event_id = $val["item"][0]["event_id"];
					break;
				}
			} else {			
				$event_id = $live_game_model->index_event_id();
			}
			if ( $event_id > 0 ) {
				$this->redirect("/LiveGame/list?event_id=".$event_id);
			}
		}

		if( !$this->req->isNumberParameter($event_id))
		{
			throw new Lemon_ScriptException("잘못된 접근입니다.");
			exit;
		}
	
		$games = $live_game_model->getLiveGameDetail($event_id);
		$this->displayRight();
		
		$this->view->define("template_main_bets", "content/live/template_main_bets.html");
		$this->view->define("template_goal_bets", "content/live/template_goal_bets.html");
		$this->view->define("template_list", "content/live/livegame_list.html");
		$this->view->assign("event_id",  $event_id);
		$this->view->assign("games",  $games);
		$this->view->define("right", "right/right_live.html");
		$this->view->assign("total_game",  $totalGame);
		$this->view->assign("game_list",  $gameList);
		
		$this->display();
	}
	
	function displayRight()
	{
		$sn 			= $this->auth->getSn();
		$uid			= $this->auth->getId();
		$level		= $this->auth->getLevel();
		
		$member_model = $this->getModel("MemberModel");
		$etc_model = $this->getModel("EtcModel");
		$config_model = $this->getModel("ConfigModel");
		
		$session_id = $member_model->getMemberField($sn, 'sessionid');		
		
		if($session_id!=session_id())
		{
			if($this->auth->isLogin())
			{
				session_destroy();
			}
			throw new Lemon_ScriptException("중복접속 되었습니다. 다시 로그인 해 주세요.", "", "go", "/");
			exit;
		}

		$rs = $etc_model->getMemberLevRow($level, '*');
		$min_betting_money = $rs['lev_min_money'];
		$max_betting_money = $rs['lev_max_money_single'];
		$max_prize_money = $rs['lev_max_bonus'];

		if ( $level == 1 ) $max_betting_money = 500000;
		else if ( $level == 2 ) $max_betting_money = 1000000;
		else if ( $level == 3 ) $max_betting_money = 1500000;
		else if ( $level == 4 ) $max_betting_money = 2000000;
		else if ( $level == 5 ) $max_betting_money = 2500000;
		else if ( $level == 6 ) $max_betting_money = 3000000;

		$this->view->assign("max_prize_money", $max_prize_money);
		$this->view->assign("min_betting_money", $min_betting_money);
		$this->view->assign("max_betting_money", $max_betting_money);

	}
	
	function live_game_listenerAction()
	{
		$event_id = $this->request('event_id');
		
		$liveGameModel = $this->getModel("LiveGameModel");
		$liveGameModel->live_event_listener_for_client($event_id);
	}
	
	function live_main_bets_listenerAction()
	{
		$event_id = $this->request('event_id');
		
		$liveGameModel = $this->getModel("LiveGameModel");
		$liveGameModel->live_event_main_bets_listener_for_client($event_id);
	}
	
	function live_list_main_bets_listenerAction()
	{
		$event_id = $this->request('event_id');
		
		$liveGameModel = $this->getModel("LiveGameModel");
		$liveGameModel->live_list_event_main_bets_listener();
	}
	
	//▶ 라이브 배팅
	function live_betting_processAction()
	{
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$sn = $this->auth->getSn();
		$userid = $this->auth->getId();
		
		$member_model = $this->getModel('MemberModel');
		$live_game_model	= $this->getModel('LiveGameModel');
		$cart_model = $this->getModel('CartModel');
		$process_model 	= $this->getModel('ProcessModel');
		
		$session_id = $member_model->getMemberField($sn, 'sessionid');
		
		if($session_id!=session_id())
		{
			if($this->auth->isLogin())
			{
				session_destroy();
			}
			throw new Lemon_ScriptException("다시 로그인 하신후 배팅하여 주십시오.", "", "go", "/");
			exit;
		}

		$db_money = $member_model->getMemberField($sn,'g_money');
		
		$event_id = $this->request("event_id");
		$template = $this->request("template");
		$betting_money = $this->request("betting_money");
		$betting_money = str_replace(",","",$betting_money);
		$odd = $this->request("odd");

		//'1', 'X', '2', '0-0'.....
		$position = $this->request("position");
		
		if(round($db_money)<round($betting_money) or $betting_money<0)
		{
			throw new Lemon_ScriptException("보유머니가 부족합니다.", "", "back", "");
			exit();
		}
		
		$etc_model = $this->getModel("EtcModel");
		$level = $this->auth->getLevel();
		$rows = $etc_model->getMemberLevRow($level, '*');
		$limit_min_betting = $rows['lev_min_money'];
		$limit_max_betting = $rows['lev_max_money_single'];
		
		if($betting_money < $limit_min_betting || $betting_money > $limit_max_betting)
		{
			throw new Lemon_ScriptException("베팅액은 ".$limit_min_betting."~".$limit_max_betting."원 사이입니다.", "", "back", "");
			exit();
		}
		
		$lastTime = $live_game_model->last_betting_time($sn);
		$xtime=$this->diff_second($lastTime);
			
		if($xtime<3)
		{
			throw new Lemon_ScriptException("너무 빈번합니다. 잠시 뒤에 다시 시도하십시오.", "", "back", "");
			exit;
		}
		
		//구매 번호 생성
		$last_sn = $cart_model->getLastCartIndex();
		
		$now_time = date("Y-m-d H:i:s");
		$betting_no = strtotime($now_time) - strtotime("2000-01-01")+(9*60*60);
		$betting_no = $betting_no + $last_sn;
		If($betting_no == "")
		{
			throw new Lemon_ScriptException("구매번호를 확인하여 주십시요.");
			exit();
		}
		$betting_no = $sn.$betting_no;
		
		//배당정보 확인
		if(0==$live_game_model->is_odds_same($event_id, $template, $position, $odd))
		{
			throw new Lemon_ScriptException("배당이 변경된 경기입니다. 확인해주세요", "", "back", "");
			exit();
		}

		//-> 같은게임 같은방향 배팅합계가 최대 배팅금액을 넘는지 확인. -----------------------------------------
		$getGameInfo = $live_game_model->get_live_game_info($event_id, $template);
		$game_live_sn = $getGameInfo[0]["live_sn"];
		$game_live_detail_sn = $getGameInfo[0]["sn"];

		$sync_betting_money = $live_game_model->get_sync_betting_money($sn, $game_live_sn, $game_live_detail_sn, $position);
		if ( ($sync_betting_money + $betting_money) > $limit_max_betting ) {
			throw new Lemon_ScriptException("단폴더 배팅제한 금액은 ".number_format($limit_max_betting)."원입니다 배팅금액을 조정해주세요.", "\\n[ 현재 배팅금 : ".number_format($betting_money)."원 ]\\n[ 누적 배팅금 : ".number_format($sync_betting_money)."원 ]", "go", "/LiveGame/list?event_id=".$event_id);
			exit();
		}
		//-------------------------------------------------------------------------------------------------------

		$rs = $live_game_model->live_betting($sn, $event_id, $template, $betting_no, $odd, $betting_money, $position);		
		if($rs > 0)
		{
			$process_model->bettingProcess($sn, $betting_money);
			//throw new Lemon_ScriptException("배팅신청이 완료되었습니다.", "", "go", "/LiveGame/list?event_id=".$event_id);
			throw new Lemon_ScriptException("배팅신청이 완료되었습니다.", "", "go", "/LiveGame/betting_list");
			exit();
		}
		else if($rs==-1)
		{
			throw new Lemon_ScriptException("존재하지 않은 게임입니다.", "", "go", "/LiveGame/list?event_id=".$event_id);
			exit();
		}
		else if($rs==-2)
		{
			throw new Lemon_ScriptException("일시 마감된 게임입니다.", "", "go", "/LiveGame/list?event_id=".$event_id);
			exit();
		}
		else if($rs==-3)
		{
			throw new Lemon_ScriptException("잠시 지연중입니다. 다시 시도해 주십시요.", "", "go", "/LiveGame/list?event_id=".$event_id);
			exit();
		}
	}
	
	/* 라이브 베팅 목록 */
	public function betting_listAction()
	{
		$this->commonDefine('type');
		$this->view->define(array("content"=>"content/live/betting_list.html"));
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}

		$begin_date 	= Trim($this->req->request("begin_date"));
		$end_date 		= Trim($this->req->request("end_date"));
		$filter = $this->req->request("filter");
		$act = $this->req->request("act");
	
		$liveGameModel = Lemon_Instance::getObject("LiveGameModel",true);
		$member_sn = $this->auth->getSn();
		
		if($act=="hide_betting") {
			$betting_sn = $this->req->request("betting_sn");
			$liveGameModel->hide_betting($betting_sn);
		}
		
		$where="";
		if($filter=="PLAY") {
			$where = " and a.betting_result='-1' ";
		}
		else if($filter=="WIN") {
			$where = " and a.betting_result='WIN' ";
		}
		else if($filter=="LOS") {
			$where = " and a.betting_result='LOS' ";
		}
		
		if($begin_date!="" && $end_date!="")
			$where.= " and a.reg_time between ".$begin_date." 00:00:00 and ".$end_date." 23:59:59";
		
		$page_act = "begin_date=".$begin_date."&end_date=".$end_date."&filter=".$filter;
		$total = $liveGameModel->betting_list_total($member_sn, $where);
		$pageMaker = $this->displayPage($total, 10, $page_act);
		$list = $liveGameModel->betting_list($member_sn, $pageMaker->first, $pageMaker->listNum, $where);
		
		$this->view->assign("begin_date", $begin_date);
		$this->view->assign("begin_date", $begin_date);
		$this->view->assign("filter", $filter);
		$this->view->assign("list", $list);
	
		$this->display();
	}
	
	public function game_resultAction()
	{
		$this->commonDefine('result');
		$this->view->define(array("content"=>"content/live/game_result.html"));
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$begin_date = Trim($this->request("begin_date"));
		$end_date = Trim($this->request("end_date"));
		$sport_name = $this->request('sport_name');
		$leagueSn = $this->request('league_sn');
		$keyword = $this->request('keyword');
		$field = $this->request('field');
	
		if($field=="")	$field="team";
		
		$liveGameModel = Lemon_Instance::getObject("LiveGameModel",true);
		$leagueModel = Lemon_Instance::getObject("LeagueModel",true);
	
		if($keyword!="")
		{
			if($field=="team")
				$where.= " and (b.home_team like '%".$keyword."%' or b.away_team like'%".$keyword."%')";
		}
		
		if($category!="")
			$where.=" and a.sport_name='".$category."'";
			
		if($leagueSn!="")
			$where.=" and b.league_sn=".$leagueSn;
			
		if($begin_date!="" && $end_date!="")
			$where.=" and (b.start_time between '".$begin_date." 00:00:00' and '".$end_date."' 23:59:59) ";
		// keyword where - end
			
		$page_act = "begin_date=".$begin_date."&end_date=".$end_date."&sport_name=".$sport_name."&mode=".$searchMode."&keyword=".$keyword."&field=".$field."&league_sn=".$leagueSn;
		$total			= $liveGameModel->game_result_list_total($where);
		$pageMaker 	= $this->displayPage($total, 30, $page_act);
		$list 			= $liveGameModel->game_result_list($pageMaker->first, $pageMaker->listNum, $where);
		
		$categoryList = $leagueModel->getCategoryMenuList();
		
		$where="";
		if($category!="")
			$where = " kind='".$category."'";
		$leagueList = $leagueModel->getListAll($where);
		
		$this->view->assign("keyword", $keyword);
		$this->view->assign("league_sn", $leagueSn);
		$this->view->assign("field", $field);
		$this->view->assign("sport_name", $sport_name);
		$this->view->assign("begin_date", $begin_date);
		$this->view->assign("end_date", $end_date);
		$this->view->assign("list", $list);	
		$this->view->assign('league_list', $leagueList);
		$this->view->assign("category_list",  $categoryList);

		$this->display();
	}
	
	function ajax_playing_live_gamesAction()
	{
		$event_id = $this->request('event_id');
		
		$liveGameModel = Lemon_Instance::getObject("LiveGameModel",true);
		$games = $liveGameModel->playing_live_games($event_id);
		
		echo(json_encode($games));
	}
	
	function diff_second($last_time)
	{
		$atime=date("Y-m-d H:i:s");
		$xtime=strtotime($atime) - strtotime($last_time);
		$xtime=round($xtime); 
		return $xtime;
	}
}

?> 