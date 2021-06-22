<?php 


class LogController extends WebServiceController 
{
	//▶ 머니내역
	function moneyloglistAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/log/money_list.html");
		
		$model 	= $this->getModel("MoneyModel");
		$partnerModel = $this->getModel("PartnerModel");
		
		$type				= $this->request('type');
		$perpage 		= $this->request('perpage');
		$keyword 		= $this->request('keyword');
		$beginDate  = $this->request('begin_date');
		$endDate 		= $this->request('end_date');
		$filterState 	= $this->request('filter_state');
		$filterPartnerSn 	= $this->request('filter_partner_sn');
		
		if($perpage=='') $perpage = 30;
		
		if($filterPartnerSn!='') 
		{
			$levelCode = sprintf("%04d", $filterPartnerSn);
			$where=" and b.level_code like('".$levelCode."%')";
		}
		
		if($filterState!='')			{$where.=" and a.state=".$filterState;}
		if($keyword!="")
		{
			$field = $this->request('field');
			if($field=="uid")							{$where.=" and b.uid like('%".$keyword."%')";}
			else if($field=="nick")				{$where.=" and b.nick like('%".$keyword."%')";}
			else if($field=="bank_owner") {$where.=" and b.bank_member like('%".$keyword."%')";}
		}
	
		$page_act = "type=".$type."&perpage=".$perpage."&keyword=".$keyword."&begin_date=".$beginDate."&end_date=".$endDate."&field=".$field."&filter_partner_sn=".$filterPartnerSn."&filter_state=".$filterState;
		
		$total 			= $model->getMoneyLogTotal($where, '', $type, $beginDate, $endDate);
		$pageMaker	= $this->displayPage($total, $perpage, $page_act);
		$list 			= $model->getMoneyLogList($where, '', $pageMaker->first, $pageMaker->listNum, $type, $beginDate, $endDate);
		
		$partnerList = $partnerModel->getPartnerIdList();
		
		$this->view->assign('keyword', $keyword);
		$this->view->assign('field', $field);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('filter_state', $filterState);
		$this->view->assign('filter_partner_sn', $filterPartnerSn);
		$this->view->assign('list', $list);
		$this->view->assign('partner_list', $partnerList);
		
		$this->display();
	}
	
	//▶ 마일리지내역
	function mileageloglistAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/log/mileage_list.html");
		
		$model 	= $this->getModel("MoneyModel");
		$partnerModel = $this->getModel("PartnerModel");
		
		$type				= $this->request('type');
		$perpage 		= $this->request('perpage');
		$keyword 		= $this->request('keyword');
		$beginDate  = $this->request('begin_date');
		$endDate 		= $this->request('end_date');
		$filterState 	= $this->request('filter_state');
		$filterPartnerSn 	= $this->request('filter_partner_sn');
		
		if($perpage=='') $perpage = 30;
		
		if($filterPartnerSn!='') 
		{
			$levelCode = sprintf("%04d", $filterPartnerSn);
			$where=" and b.level_code like('".$levelCode."%')";
		}
		
		if($filterState!='')			{$where.=" and a.state=".$filterState;}
		if($keyword!="")
		{
			$field = $this->request('field');
			if($field=="uid")							{$where.=" and b.uid like('%".$keyword."%')";}
			else if($field=="nick")				{$where.=" and b.nick like('%".$keyword."%')";}
			else if($field=="bank_owner") {$where.=" and b.bank_member like('%".$keyword."%')";}
		}

		$page_act = "type=".$type."&perpage=".$perpage."&keyword=".$keyword."&begin_date=".$beginDate."&end_date=".$endDate."&field=".$field."&filter_partner_sn=".$filterPartnerSn;
		
		$total 			= $model->getMileageLogTotal($where, '', $type, $beginDate, $endDate);
		$pageMaker	= $this->displayPage($total, $perpage, $page_act);
		$list 			= $model->getMileageLogList($where, '', $pageMaker->first, $pageMaker->listNum, $type, $beginDate, $endDate);
		$partnerList = $partnerModel->getPartnerIdList();
		
		$this->view->assign('keyword', $keyword);
		$this->view->assign('field', $field);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('filter_state', $filterState);
		$this->view->assign('filter_partner_sn', $filterPartnerSn);
		$this->view->assign('list', $list);
		$this->view->assign('partner_list', $partnerList);
		
		$this->display();
	}
	
		//▶ 팝업 머니내역
	function popup_moneyloglistAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/log/popup.money_list.html");
		
		$model 	= $this->getModel("MoneyModel");
		
		$uid				= $this->request('uid');
		$type				= $this->request('type');
		$perpage 		= $this->request('perpage');
		$beginDate  = $this->request('begin_date');
		$endDate 		= $this->request('end_date');
		$filterState 	= $this->request('filter_state');
		
		if($perpage=='') $perpage = 10;
		
		if($uid!="")	{$where.=" and b.uid='".$uid."'";}
		if($filterState!='')			{$where.=" and a.state=".$filterState;}
	
		$page_act = "type=".$type."&perpage=".$perpage."&begin_date=".$beginDate."&end_date=".$endDate."&uid=".$uid;
		
		$total 			= $model->getMoneyLogTotal($where, '', $type, $beginDate, $endDate);
		$pageMaker	= $this->displayPage($total, $perpage, $page_act);
		$list 			= $model->getMoneyLogList($where, '', $pageMaker->first, $pageMaker->listNum, $type, $beginDate, $endDate);
		
		$this->view->assign('uid', $uid);
		$this->view->assign('keyword', $keyword);
		$this->view->assign('field', $field);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('filter_state', $filterState);
		$this->view->assign('list', $list);
		
		$this->display();
	}
	
	//▶ 팝업 마일리지내역
	function popup_mileageloglistAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/log/popup.mileage_list.html");
		
		$model 	= $this->getModel("MoneyModel");
		
		$uid				= $this->request('uid');
		$type				= $this->request('type');
		$perpage 		= $this->request('perpage');
		$beginDate  = $this->request('begin_date');
		$endDate 		= $this->request('end_date');
		$filterState 	= $this->request('filter_state');
		
		if($perpage=='') $perpage = 10;
		
		if($uid!="")	{$where.=" and b.uid='".$uid."'";}
		if($filterState!='')			{$where.=" and a.state=".$filterState;}
	
		$page_act = "type=".$type."&perpage=".$perpage."&begin_date=".$beginDate."&end_date=".$endDate."&uid=".$uid;
		
		$total 			= $model->getMileageLogTotal($where, '', $type, $beginDate, $endDate);
		$pageMaker	= $this->displayPage($total, $perpage, $page_act);
		$list 			= $model->getMileageLogList($where, '', $pageMaker->first, $pageMaker->listNum, $type, $beginDate, $endDate);
		
		$this->view->assign('uid', $uid);
		$this->view->assign('keyword', $keyword);
		$this->view->assign('field', $field);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('filter_state', $filterState);
		$this->view->assign('list', $list);
		
		$this->display();
	}
}

?>