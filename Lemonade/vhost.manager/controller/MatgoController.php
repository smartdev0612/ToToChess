<?php 

class MatgoController extends WebServiceController 
{
	function indexAction()
	{
		$this->game_logAction();
	}
	
	public function game_logAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/matgo/game_log.html");
		
		$keyword 		= $this->req->request("keyword");
		$beginDate 	= $this->req->request("begin_date");
		$endDate 		= $this->req->request("end_date");
		$perpage		= $this->req->request("perpage");
		$field			= $this->req->request("field");
		$roomNo			= $this->req->request("room_no");
		
		if($beginDate=="")	{
			$beginDate = date("Y-m-d");
		}
		if($endDate=="")	{
			$endDate = date("Y-m-d");
		}
		
		if($perpage=="") $perpage=100;
		if($beginDate!="" && $endDate!="")
		{
			$unixTimeBegin 	= 	strtotime($beginDate." 00:00:00");
			$unixTimeEnd 		= 	strtotime($endDate." 23:59:59");
			$where = " and nLogTime between ".$unixTimeBegin." and ".$unixTimeEnd;
		}
		if($keyword!="")
		{
			if($field=="userid")
				$where.=" and (szWinUserID like('".$keyword."%') or szLosUserID1 like('".$keyword."%'))";
		}
		if($roomNo!="")
			$where.= " and a.room_no=".$roomNo;
			
		$matgoModel = Lemon_Instance::getObject("MatgoModel", true);
		
		$page_act = "perpage=".$perpage."&keyword=".$keyword."&begin_date=".$beginDate."&end_date=".$endDate."&field=".$field."&room_no=".$roomNo;
		
		
		$total = $matgoModel->gameLogListTotal($where);
		$pageMaker = $this->displayPage($total, $perpage, 10, $page_act);
		$list = $matgoModel->gameLogList($where, $pageMaker->first, $pageMaker->listNum);
		
		//$staticData = $matgoModel->getLogStaticData($beginDate, $endDate);
		
		//$time = strtotime('2013-03-20 12:32:25');
		//echo strftime("%Y-%m-%d %H:%M:%S", $time);
		
		$this->view->assign('list', $list);
		$this->view->assign('keyword', $keyword);
		$this->view->assign('field', $field);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('room_no', $roomNo);
		$this->view->assign('perpage', $perpage);
		$this->view->assign('static_data', $staticData);
		
		$this->display();
	}
	
	public function popup_game_logAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/matgo/popup_game_log.html");
		
		$roomNo	= $this->req->request("room_no");
		$startTime = $this->req->request("start_time");
		
		if($roomNo!="")
			$where.= " and a.room_no=".$roomNo;
			
		if($startTime!="")
			$where.= " and a.start_time=".$startTime;
		
		$holdemModel = Lemon_Instance::getObject("HoldemModel", true);
		
		$list = $holdemModel->popupGameLogList($where);
		
		$this->view->assign('list', $list);
		$this->view->assign('room_no', $roomNo);
		$this->view->assign('start_time', $startTime);
		
		$this->display();
	}
	
	public function accountAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/matgo/account.html");
		
		$matgoModel = $this->getModel("MatgoModel");
		$partnerModel = $this->getModel("PartnerModel");
		
		$beginDate	= $this->request("begin_date");
		$endDate		= $this->request("end_date");
		$filterPartnerSn 	= $this->request('filter_partner_sn');
		
		//디폴트 날짜 = 1일부터 금일까지
		if($beginDate=='' or $endDate=='')
		{
			$beginDate 	= date("Y-m-")."01";
			$endDate 		= date("Y-m-d");
		}
		
		if($filterPartnerSn!="")
			$list = $partnerModel->getRecommendMoneyList($filterPartnerSn, $beginDate, $endDate);
		else
			$list = $matgoModel->getAccountList('', $filterPartnerSn, $beginDate, $endDate);
			
		$sumList = array();
		
		foreach($list as $key => $value)
		{
			$sumList['sum_commission'] 	+= $list[$key]['commission'];
			$sumList['sum_user_amount'] 	+= $list[$key]['user_amount'];
			$sumList['sum_manager_amount'] 	+= $list[$key]['manager_amount'];
		}
		
		$partnerList = $partnerModel->getPartnerIdList();
		
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('list', $list);
		$this->view->assign('sumList', $sumList);
		$this->view->assign('filter_partner_sn', $filterPartnerSn);
		$this->view->assign('partner_list', $partnerList);
		$this->display();
	}
}

?>