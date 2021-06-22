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
		$leagueModel = $this->getModel("LeagueModel");
		
		$perpage		= 60;
		$total 			= $liveGameModel->total_today_live_games();
		$page_act		= "perpage=".$perpage;
		$pageMaker 	= $this->displayPage($total, $perpage, $page_act);
		
		$events 		= $liveGameModel->today_live_games($pageMaker->first, $pageMaker->listNum);
		
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
		
		$perpage = $this->request("perpage");
		$filter_state = $this->request("filter_state");
		$begin_date = $this->request('begin_date');
		$end_date = $this->request('end_date');
		$keyword = Trim($this->request('keyword'));
		$filter_type	= $this->request('filter_type');
		
		if($perpage=='') 
			$perpage=30;
			
		if($begin_date=="" || $end_date=="")
		{
			$begin_date 	= date("Y-m-d");
			$end_date		= date("Y-m-d",strtotime ("+1 days"));
		}

		if($keyword!='')
		{
			if($filter_type=='league')
				$where = " and d.name like('%".$keyword."%')";
			else if($filter_type=='filter_home_team')
				$where = " and a.home_team like('%".$keyword."%')";
			else if($filter_type=='filter_away_team')
				$where = " and a.away_team like('%".$keyword."%')";
		}
		
		$where.=" and a.start_time between '".$begin_date." 00:00:00' and '".$end_date." 23:59:59'";
	
		$page_act = "perpage=".$perpage."&filter_state=".$filter_state."&begin_date=".$begin_date."&end_date=".$end_date."&filter_type=".$filter_type."&keyword=".$keyword;
		
		$total = $liveGameModel->admin_live_game_total($where);
		$pageMaker 	= $this->displayPage($total, $perpage, $page_act);
		$list = $liveGameModel->admin_live_game_list($pageMaker->first, $pageMaker->listNum, $where);
		
		//print_r($list);
		
		$static = array();
		if(count($list)>0) {
			foreach($list as $item)
			{
				$static['total_betting_money'] +=$item['total_betting_money'];
				$static['total_prize'] +=$item['prize'];
			}
		}
		
		$daemon_state = $liveGameModel->daemon_state();
	
		$this->view->assign('begin_date', $begin_date);
		$this->view->assign('end_date', $end_date);
		$this->view->assign('keyword', $keyword);
		$this->view->assign('filter_type', $filter_type);
		$this->view->assign("filter_state",$filter_state);
		$this->view->assign("daemon_state",  $daemon_state);
		$this->view->assign("list",$list);
		$this->view->assign("static",$static);

		$this->display();
	}
	
	public function betting_listAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/live/betting_list.html");
		
		$model 	= $this->getModel("GameModel");
		$memberModel = $this->getModel("MemberModel");
		$liveGameModel 	= $this->getModel("LiveGameModel");
		
		$act = $this->request("act");
		$filter_betting_result = $this->request("filter_betting_result");
		$perpage = $this->request("perpage");
		$selectKeyword	= $this->request("select_keyword");
		$keyword = $this->request("keyword");
		$showDetail = $this->request("show_detail");
		$bettingNo = $this->request("betting_no");
		
		if($perpage=='') $perpage = 60;
		if($showDetail=='') $showDetail = 0;

		$where="";
		if($act=="search")
		{
			if($filter_betting_result=="WIN") 		$where.= " and a.betting_result='WIN'";
			else if($filter_betting_result=="LOS")	$where.= " and a.betting_result='LOS'";
			else if($filter_betting_result==="-1")	$where.= " and a.betting_result='-1'";
			
			if($keyword!="")
			{
				if($selectKeyword=="uid")							$where.=" and e.uid like('%".$keyword."%') ";
				else if($selectKeyword=="nick")				$where.=" and e.nick like('%".$keyword."%') ";
				else if($selectKeyword=="betting_no")	$where.=" and a.betting_no like('%".$keyword."%') ";
			}
		}
	
		$page_act = "perpage=".$perpage."&filter_betting_result=".$filter_betting_result."&act=".$act."&select_keyword=".$selectKeyword."&keyword=".$keyword."&show_detail=".$showDetail;
		
		$total = $liveGameModel->admin_betting_list_total($where);
		$pageMaker = $this->displayPage($total, $perpage, $page_act);
		$list = $liveGameModel->admin_betting_list($pageMaker->first, $pageMaker->listNum, $where);

		$sumList = $liveGameModel->live_game_static();
		
		$this->view->assign("show_detail",$showDetail);
		$this->view->assign("select_keyword",$selectKeyword);
		$this->view->assign("keyword",$keyword);
		$this->view->assign("filter_betting_result",$filter_betting_result);
		$this->view->assign("perpage",$perpage);
		$this->view->assign("betting_no",$bettingNo);
		$this->view->assign("list",$list);
		$this->view->assign("sumList",$sumList);

		$this->display();
	}
	
	function account_processAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$act = $this->request("act");
		$detail_sn = $this->request("detail_sn");
		
		//filter values
		
		
		$liveGameModel = $this->getModel("LiveGameModel");
		
		if($act=="account")
		{
			$rs = $liveGameModel->account_game($detail_sn);
			
			if($rs >0)
				throw new Lemon_ScriptException("정산되었습니다.","","go","/LiveGame/game_list");
			else if($rs==-1)
				throw new Lemon_ScriptException("이미 처리된 게임입니다.","","go","/LiveGame/game_list");
			else if($rs==-2)
				throw new Lemon_ScriptException("이미 처리된 게임입니다.","","go","/LiveGame/game_list");
			exit;
		}
		else if($act=="account_cancel")
		{
			$rs = $liveGameModel->account_cancel_game($detail_sn);
			if($rs >0)
				throw new Lemon_ScriptException("정산취소 되었습니다.","","go","/LiveGame/game_list");
			else if($rs==-1)
				throw new Lemon_ScriptException("상태값 오류입니다. STATE!=ACC","","go","/LiveGame/game_list");
			else if($rs==-2)
				throw new Lemon_ScriptException("상태값 변경 실패입니다.","","go","/LiveGame/game_list");
			else
				throw new Lemon_ScriptException("알수 없는 오류입니다.","","go","/LiveGame/game_list");
		}
		else if($act=="pause")
		{
			$rs = $liveGameModel->update_pause_state($detail_sn, 'Y');
			if($rs>0)
				throw new Lemon_ScriptException("변경되었습니다.","","go","/LiveGame/game_list");
			else
				throw new Lemon_ScriptException("변경사항이 없거나 실패하였습니다.","","go","/LiveGame/game_list");
		}
		else if($act=="unpause")
		{
			$rs = $liveGameModel->update_pause_state($detail_sn, 'N');
			if($rs>0)
				throw new Lemon_ScriptException("변경되었습니다.","","go","/LiveGame/game_list");
			else
				throw new Lemon_ScriptException("변경사항이 없거나 실패하였습니다.","","go","/LiveGame/game_list");
		}
		else if($act=="delete_live_game")
		{
			$live_sn = $this->request("live_sn");
			$rs = $liveGameModel->delete_live_game($live_sn);
			if($rs>0)
				throw new Lemon_ScriptException("삭제되었습니다.","","go","/LiveGame/game_list");
			else
				throw new Lemon_ScriptException("변경사항이 없거나 실패하였습니다.","","go","/LiveGame/game_list");
		}
	}
	
	function ajax_account_processAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$act = $this->request("act");
		$detail_sn = $this->request("detail_sn");
		
		//filter values
		
		
		$liveGameModel = $this->getModel("LiveGameModel");
		
		if($act=="account")
		{
			$json = $liveGameModel->ajax_account_game($detail_sn);
			echo(json_encode($json));
			exit;
		}
		else if($act=="account_cancel")
		{
			$json = $liveGameModel->ajax_account_cancel_game($detail_sn);
			echo(json_encode($json));
			exit;
		}
		else if($act=="pause")
		{
			$rs = $liveGameModel->update_pause_state($detail_sn, 'Y');
			if($rs>0)
				throw new Lemon_ScriptException("변경되었습니다.","","go","/LiveGame/game_list");
			else
				throw new Lemon_ScriptException("변경사항이 없거나 실패하였습니다.","","go","/LiveGame/game_list");
		}
		else if($act=="unpause")
		{
			$rs = $liveGameModel->update_pause_state($detail_sn, 'N');
			if($rs>0)
				throw new Lemon_ScriptException("변경되었습니다.","","go","/LiveGame/game_list");
			else
				throw new Lemon_ScriptException("변경사항이 없거나 실패하였습니다.","","go","/LiveGame/game_list");
		}
		else if($act=="delete_live_game")
		{
			$live_sn = $this->request("live_sn");
			$rs = $liveGameModel->delete_live_game($live_sn);
			if($rs>0)
				throw new Lemon_ScriptException("삭제되었습니다.","","go","/LiveGame/game_list");
			else
				throw new Lemon_ScriptException("변경사항이 없거나 실패하였습니다.","","go","/LiveGame/game_list");
		}
	}
	
	function betting_exceptionAction()
	{
		$betting_sn = $this->request("betting_sn");
		
		$liveGameModel = $this->getModel("LiveGameModel");		
		$rs = $liveGameModel->betting_exception($betting_sn);
		
		if($rs>0)
			throw new Lemon_ScriptException("변경되었습니다.","","go","/LiveGame/betting_list");
		else
			throw new Lemon_ScriptException("변경사항이 없거나 실패하였습니다.","","go","/LiveGame/betting_list");
	}
	
	function popup_manual_finAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/live/popup_manual_fin.html");
		
		$live_sn = $this->request("live_sn");
		
		$liveGameModel = $this->getModel("LiveGameModel");		
		$rs = $liveGameModel->live_game($live_sn);
		$broadcasts = $liveGameModel->live_game_broadcast($live_sn, 255);
				
		$this->view->assign("list",$rs);
		$this->view->assign("live_sn",$live_sn);
		$this->view->assign("broadcasts",$broadcasts);
	
		$this->display();
	}
	
	function manual_finProcessAction()
	{
		$live_sn = $this->request("live_sn");
		$period = $this->request("period");
		
		$score='';
		if($period==2) {
			
			$home_score = $this->request("first_home_score");
			$away_score = $this->request("first_away_score");
			$score = sprintf("%d:%d", $home_score, $away_score);
		}
		else if($period==4) {
			$home_score = $this->request("second_home_score");
			$away_score = $this->request("second_away_score");
			$score = sprintf("%d:%d", $home_score, $away_score);
		}
		else
			exit;
		
		$liveGameModel = $this->getModel("LiveGameModel");		
		$rs = $liveGameModel->manual_finish_live_game($live_sn, $period, $score);
		
		throw new Lemon_ScriptException("마감되었습니다.","","go","/LiveGame/popup_manual_fin?live_sn=".$live_sn);
	}
	
	function reload_today_gameAction()
	{
		$liveGameModel = $this->getModel("LiveGameModel");
		$liveGameModel->reload_today_live_games();
		throw new Lemon_ScriptException("초기화 되었습니다.","","go","/LiveGame/game_list");
	}
	
	function live_game_list_listener()
	{
	}
	
	public function popup_betting_listAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/live/popup_betting_list.html");
		
		$detail_sn = $this->request("detail_sn");
		$betting_position = $this->request("betting_position");
		
		$liveGameModel = $this->getModel("LiveGameModel");
		$list = $liveGameModel->betting_position_detail($detail_sn, $betting_position);
		
		$this->view->assign("detail_sn",$detail_sn);
		$this->view->assign("betting_position",$betting_position);
		$this->view->assign("list",$list);

		$this->display();
	}
	
	function popup_betting_exceptionAction()
	{
		$betting_sn = $this->request("betting_sn");
		$detail_sn = $this->request("detail_sn");
		$betting_position = $this->request("betting_position");
		
		$liveGameModel = $this->getModel("LiveGameModel");		
		$rs = $liveGameModel->betting_exception($betting_sn);
		
		if($rs>0)
			throw new Lemon_ScriptException("변경되었습니다.","","go","/LiveGame/popup_betting_list?detail_sn=".$detail_sn."&betting_position=".$betting_position);
		else
			throw new Lemon_ScriptException("변경사항이 없거나 실패하였습니다.","","go","/LiveGame/popup_betting_list?detail_sn=".$detail_sn."&betting_position=".$betting_position);
	}
}
?>
