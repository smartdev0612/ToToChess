<?
/*
* Index Controller
*/
class PinnacleGameController extends WebServiceController 
{
	public function game_listAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/pinnacle/game_list.html");
		
		$pinnacleGameModel = $this->getModel("PinnacleGameModel");
		
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
		
		$total = $pinnacleGameModel->admin_pinnacle_game_total($where);
		$pageMaker 	= $this->displayPage($total, $perpage, $page_act);
		$list = $pinnacleGameModel->admin_pinnacle_game_list($pageMaker->first, $pageMaker->listNum, $where);
		
		$static = array();
		if(count($list)>0) {
			foreach($list as $item)
			{
				$static['total_betting_money'] +=$item['total_betting_money'];
				$static['total_prize'] +=$item['prize'];
			}
		}
	
		$this->view->assign('begin_date', $begin_date);
		$this->view->assign('end_date', $end_date);
		$this->view->assign('keyword', $keyword);
		$this->view->assign('filter_type', $filter_type);
		$this->view->assign("filter_state",$filter_state);
		$this->view->assign("list",$list);
		$this->view->assign("static",$static);
		$this->view->assign("page_act",$page_act);

		$this->display();
	}
	
	//게임정산
	public function game_fin_processAction()
	{
		$pinnacle_model = Lemon_Instance::getObject("PinnacleGameModel",true);
		
		$game_sn_list 	= $this->request("y_id");
		$home_score_list	= $this->request("home_score");
		$away_score_list	= $this->request("away_score");
		$cancel_list		= $this->request("check_cancel");
		$template_list			= $this->request("game_types");
		$draw_odd_list 	= $this->request("draw_rate");
		$page_act 	= $this->request("page_act");
		
		//checkbox의 경우 체크된 항목만 넘어오지만 "text"와 그외의 속성들은 모든 배열값들이 넘어온다.
		//그래서 Key값을 배열이름으로 사용하여 해당되는 내용만 전송하게 한다.
		for($i=0;$i<count((array)$game_sn_list);++$i)
		{
			$is_cancel	 = $cancel_list[$i];
			$game_sn 	 = $game_sn_list[$i];

			$home_score = $home_score_list[$game_sn];
			$away_score = $away_score_list[$game_sn];
	
			$game_row = $pinnacle_model->getGame($game_sn);
			if($game_row['win']!="-1")
			{
				throw new Lemon_ScriptException("이미 처리된 게임이 포함되어 있습니다.");
				exit;
			}
			
			if($is_cancel==0 && ($home_score=="" || $away_score==""))
			{
				throw new Lemon_ScriptException("스코어가 등록되지 않아 중지합니다.");
				exit;
			}
			
			$pinnacle_model->fin_game($game_sn, $home_score, $away_score, $is_cancel);
		}
		
		throw new Lemon_ScriptException("처리되었습니다.","","go","/PinnacleGame/result_list?".$page_act);
	}
	
	public function betting_listAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/pinnacle/betting_list.html");
		
		$model 	= $this->getModel("GameModel");
		$memberModel = $this->getModel("MemberModel");
		$pinnacleGameModel 	= $this->getModel("PinnacleGameModel");
		
		$act = $this->request("act");
		$filter_betting_result = $this->request("filter_betting_result");
		$perpage = $this->request("perpage");
		$selectKeyword	= $this->request("select_keyword");
		$keyword = $this->request("keyword");
		$showDetail = $this->request("show_detail");
		$bettingNo = $this->request("betting_no");
		
		if($perpage=='') $perpage = 30;
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
		
		$total = $pinnacleGameModel->admin_betting_list_total($where);
		$pageMaker = $this->displayPage($total, $perpage, $page_act);
		$list = $pinnacleGameModel->admin_betting_list($pageMaker->first, $pageMaker->listNum, $where);

		$sumList = $pinnacleGameModel->pinnacle_game_static();
		
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
	
	public function result_listAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/pinnacle/result_list.html");
		
		$model 				= $this->getModel("GameModel");
		
		$pinnacle_model = $this->getModel("PinnacleGameModel");
		
		$cartModel 		= $this->getModel("CartModel");
		$processModel = $this->getModel("ProcessModel");
		$leagueModel 	= $this->getModel("LeagueModel");
		
		$act  				= $this->request("act");
		$perpage			= $this->request("perpage");
		$gameType			= $this->request("game_type");
		$categoryName	= $this->request("categoryName");
		$beginDate  	= $this->request('begin_date');
		$endDate 			= $this->request('end_date');
		$filterTeam		= $this->request('filter_team');
		$filterTeamType	= $this->request('filter_team_type');
		
		$currentPage	= !($this->request('page'))?'1':intval($this->request('page'));
		
		if($perpage=='') $perpage = 30;
		
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
		$page_act= "filter_team=".$filterTeam."&game_type=".$gameType."&categoryName=".$categoryName."&perpage=".$perpage."&begin_date=".$beginDate."&end_date=".$endDate."&filter_team_type=".$filterTeamType."&filter_betting_total=".$filterBettingTotal;
		
		// action
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
					$set.= "away_rate = '".$awayRate."'";
					
					$where = " child_sn=".$childSn;
					$model->modifySubChild($set, $where);
				}
			}
		}
		
		//게임정산
		else if($act=="modify_result")
		{
			$arrayChildSn 	= $this->request("y_id");
			$arrayHomeScore	= $this->request("home_score");
			$arrayAwayScore	= $this->request("away_score");
			$arrayCancel		= $this->request("check_cancel");
			$arrayType			= $this->request("game_types");
			$arrayDrawRate 	= $this->request("draw_rate");
			
			//checkbox의 경우 체크된 항목만 넘어오지만 "text"와 그외의 속성들은 모든 배열값들이 넘어온다.
			//그래서 Key값을 배열이름으로 사용하여 해당되는 내용만 전송하게 한다.
			for($i=0;$i<count((array)$arrayChildSn);++$i)
			{
				$isCancel	 = $arrayCancel[$i];
				$childSn 	 = $arrayChildSn[$i];
				$homeScore = $arrayHomeScore[$childSn];
				$awayScore = $arrayAwayScore[$childSn];
				
				$childRs = $model->getChildRow($childSn, '*');
				if($childRs['kubun']==1)
				{
					throw new Lemon_ScriptException("이미 처리된 게임이 포함되어 있습니다.");
					exit;
				}
				
				if($isCancel==0 && ($homeScore=="" || $awayScore==""))
				{
					throw new Lemon_ScriptException("스코어가 등록되지 않아 중지합니다.");
					exit;
				}
			}
			
			$data 				= array();
			$betData 			= array();
			
			for($i=0;$i<count((array)$arrayChildSn);++$i)
			{
				$isCancel	 = $arrayCancel[$i];
				$childSn 	 = $arrayChildSn[$i];
				$homeScore = $arrayHomeScore[$childSn];
				$awayScore = $arrayAwayScore[$childSn];
				
				$dataArray = $processModel->resultPreviewProcessing($childSn, $homeScore, $awayScore, $isCancel, $betData);
				
				$list_temp 		= $dataArray["list"];
				$betData_temp = $dataArray["betData"];
				
				if(count((array)$list_temp)>0)
				{
					if(count((array)$data)<=0)
						$data = $list_temp;
					else
						$data = array_merge($data, $list_temp);
				}
					
				if(count((array)$betData)<=0)
					$betData = $betData_temp;
				else
					$betData = array_merge($betData, $betData_temp);
					
				$gameSnList[] = array("child_sn" => $childSn, "home_score" => $homeScore, "away_score" => $awayScore, "is_cancel" => $isCancel);

			}// end of for
		}
		
		$categoryName = $this->request("categoryName");
		$gameType 		= $this->request("game_type");

		$total 				= $pinnacle_model->admin_pinnacle_result_list_total();
		$pageMaker 		= $this->displayPage($total, $perpage, $page_act);
		$list 				= $pinnacle_model->admin_pinnacle_result_list($pageMaker->first, $pageMaker->listNum);
		$categoryList = $leagueModel->getCategoryList();
		
		$paramPage_act = "?page=".$currentPage."&".$page_act;
		
		$this->view->assign("special_type", $specialType);
		$this->view->assign("gameType", $gameType);
		$this->view->assign("categoryName", $categoryName);
		$this->view->assign("categoryList", $categoryList);
		$this->view->assign("state", $state);
		$this->view->assign("list", $list);
		$this->view->assign("param_page_act", $paramPage_act);
		$this->view->assign("page_act",$page_act);
		
		if($act=="modify_result")
		{
			$this->view->assign("account_param", urlencode(serialize($data)));
			$this->view->assign("game_sn_list", urlencode(serialize($gameSnList)));
		}
		
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('filter_team', $filterTeam);
		$this->view->assign('filter_team_type', $filterTeamType);
		
		$this->display();
	}
}
?>
