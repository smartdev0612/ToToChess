<?php 

class PinnacleGameController extends WebServiceController 
{

	function layoutDefine($type='')
	{
		$live_game_model = $this->getModel("LiveGameModel");		
		$gameList = $live_game_model->getLiveGameList($where);

		$this->view->assign("game_list",  $gameList);

		if($type=='type')
		{
			$this->view->define("index","layout/layout.type.index.html");
			$this->view->define(array("content" => "content/live/board_list.html", "casino" => "right/casino.html"));
		}
		else
		{
			$this->view->define("index","layout/layout.sub.html");
		}
	}
	
	public function listAction()
	{
		$this->commonDefine('type');
		$this->view->define(array("content"=>"content/pinnacle/game_list.html"));
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$filter_template = $this->request("filter_template");
		$filter_field = $this->request("filter_field");
		$keyword = $this->request("keyword");
		
		if($filter_template=="")
			$filter_template=1;
		
		if($filter_template!="" && $filter_template!="all")
			$where .= " and b.template=".$filter_template;
		
		if($keyword!="")
		{
			if($filter_field=="team")
				$where .= " and (a.home_team like('%".$keyword."%') or a.away_team like('%".$keyword."%'))";
			else if($filter_field=="league")
				$where .= " and c.name like('%".$keyword."%')";
		}

		$pinnacleGameModel = $this->getModel("PinnacleGameModel");		
		$etcModel = $this->getModel("EtcModel");
		$gameList = $pinnacleGameModel->getGameList($where);
		
		$this->displayRight();
		
		$this->view->define("right", "right/right_pinnacle.html");
		$this->view->assign("total_game",  $totalGame);
		$this->view->assign("game_list",  $gameList);
		$this->view->assign("filter_template",  $filter_template);
		$this->view->assign("filter_field",  $filter_field);
		$this->view->assign("keyword",  $keyword);
		$this->display();
	}
	
	function pinnacle_game_listenerAction()
	{
		$filter_template = $this->request("filter_template");
		$filter_field = $this->request("filter_field");
		$keyword = $this->request("keyword");
		
		if($filter_template!="")
			$where .= " and b.template=".$filter_template;
		
		if($keyword!="")
		{
			if($filter_field=="team")
				$where .= " and (a.home_team like('%".$keyword."%') or a.away_team like('%".$keyword."%'))";
			else if($filter_field=="league")
				$where .= " and c.name like('%".$keyword."%')";
		}
		
		$pinnacleGameModel = $this->getModel("PinnacleGameModel");
		$list = $pinnacleGameModel->getGameList($where);
		echo(json_encode($list));
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
		$min_betting_money	= $rs['lev_min_money'];
		$max_betting_money	= $rs['lev_max_money'];
		$max_prize_money	= $rs['lev_max_bonus'];
		
		$this->view->assign("max_prize_money", $max_prize_money);
		$this->view->assign("min_betting_money", $min_betting_money);
		$this->view->assign("max_betting_money", $max_betting_money);
	}
	
	function pinnacle_betting_processAction()
	{
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$sn = $this->auth->getSn();
		$userid = $this->auth->getId();
		
		$member_model = $this->getModel('MemberModel');
		$pinnacle_game_model	= $this->getModel('PinnacleGameModel');
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
		
		$detail_sn = $this->request("detail_sn");
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
		$limit_max_betting = $rows['lev_max_money'];
		
		if($betting_money < $limit_min_betting || $betting_money > $limit_max_betting)
		{
			throw new Lemon_ScriptException("베팅액은 ".$limit_min_betting."~".$limit_max_betting."원 사이입니다.", "", "back", "");
			exit();
		}
		
		$lastTime = $pinnacle_game_model->last_betting_time($sn);
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
		if(0==$pinnacle_game_model->is_odds_same($detail_sn, $position, $odd))
		{
			throw new Lemon_ScriptException("배당이 변경된 경기입니다. 확인해주세요", "", "back", "");
			exit();
		}
		
		$rs = $pinnacle_game_model->pinnacle_betting($sn, $detail_sn, $betting_no, $odd, $betting_money, $position);
		
		if($rs > 0)
		{
			$process_model->bettingProcess($sn, $betting_money);
			throw new Lemon_ScriptException("배팅신청이 완료되었습니다.", "", "go", "/PinnacleGame/list");
			exit();
		}
		else if($rs==-1)
		{
			throw new Lemon_ScriptException("존재하지 않은 게임입니다.", "", "go", "/PinnacleGame/list");
			exit();
		}
		else if($rs==-2)
		{
			throw new Lemon_ScriptException("일시 마감된 게임입니다.", "", "go", "/PinnacleGame/list");
			exit();
		}
		else if($rs==-3)
		{
			throw new Lemon_ScriptException("잠시 지연중입니다. 다시 시도해 주십시요.", "", "go", "/PinnacleGame/list");
			exit();
		}
	}
	
	/* 라이브 베팅 목록 */
	public function betting_listAction()
	{
		$this->commonDefine();
		$this->view->define(array("content"=>"content/pinnacle/betting_list.html"));
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}

		$begin_date 	= Trim($this->req->request("begin_date"));
		$end_date 		= Trim($this->req->request("end_date"));
		$filter = $this->req->request("filter");
		$act = $this->req->request("act");
	
		$pinnacle_model = Lemon_Instance::getObject("PinnacleGameModel",true);
		$member_sn = $this->auth->getSn();
		
		if($act=="hide_betting") {
			$betting_sn = $this->req->request("betting_sn");
			$pinnacle_model->hide_betting($betting_sn);
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
		$total = $pinnacle_model->betting_list_total($member_sn, $where);
		$pageMaker = $this->displayPage($total, 10, $page_act);
		$list = $pinnacle_model->betting_list($member_sn, $pageMaker->first, $pageMaker->listNum, $where);
		
		$this->view->assign("begin_date", $begin_date);
		$this->view->assign("begin_date", $begin_date);
		$this->view->assign("filter", $filter);
		$this->view->assign("list", $list);
	
		$this->display();
	}
	
	public function game_resultAction()
	{
		$this->commonDefine();
		$this->view->define(array("content"=>"content/pinnacle/game_result.html"));
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$filter_template = $this->request("filter_template");
		$filter_field = $this->request("filter_field");
		$keyword = $this->request("keyword");
		
		if($filter_template!="")
			$where .= " and b.template=".$filter_template;
		
		if($keyword!="")
		{
			if($filter_field=="team")
				$where .= " and (a.home_team like('%".$keyword."%') or a.away_team like('%".$keyword."%'))";
			else if($filter_field=="league")
				$where .= " and c.name like('%".$keyword."%')";
		}
		
		$pinnacle_model = Lemon_Instance::getObject("PinnacleGameModel",true);
		$leagueModel = Lemon_Instance::getObject("LeagueModel",true);
	
		if($keyword!="")
		{
			if($field=="team")
				$where.= " and (b.home_team like '%".$keyword."%' or b.away_team like'%".$keyword."%')";
		}
		
			
		$page_act = "begin_date=".$begin_date."&end_date=".$end_date."&sport_name=".$sport_name."&mode=".$searchMode."&keyword=".$keyword."&field=".$field."&league_sn=".$leagueSn;
		$total			= $pinnacle_model->game_result_list_total($where);
		$pageMaker 	= $this->displayPage($total, 30, $page_act);
		$list 			= $pinnacle_model->game_result_list($pageMaker->first, $pageMaker->listNum, $where);
		
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

	function diff_second($last_time)
	{
		$atime=date("Y-m-d H:i:s");
		$xtime=strtotime($atime) - strtotime($last_time);
		$xtime=round($xtime); 
		return $xtime;
	}
}

?> 