<?php 


class ExchangeController extends WebServiceController 
{
	//▶ 출금목록
	function listAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/exchange/list.html");
		
		$model = $this->getModel("MoneyModel");
		$partnerModel = $this->getModel("PartnerModel");
		
		$field 			= $this->request("field");
		$filterRollingSn 	= $this->request("filter_rolling_sn");
		$beginDate = $this->request("beginDate");
		$endDate = $this->request("endDate");
		$keyword 		= trim($this->request("keyword"));
		$partnerSn 	= $this->auth->getSn();
		$partnerId 	= $this->auth->getId();

		//디폴트 날짜 = 1일부터 금일까지
		if( !$beginDate or !$endDate ) {
			$beginDate = date("Y-m-")."01";
			$endDate = date("Y-m-d");
		}

		if($keyword!="")
		{
			if($field=="uid")
			{
				$where=" and b.uid like '%".$keyword."%'";
			}
			else if($field=="nick")
			{
				$where=" and b.nick like '%".$keyword."%'";
			}
			else if($field=="bank_member")
			{
				$where=" and b.bank_member like '%".$keyword."%'";
			}
		}

		$page_act = "beginDate=".$beginDate."&endDate=".$endDate."&field=".$field."&keyword=".$keyword;
		$totalRes = $partnerModel->getRecommendExchangeTotalTop($partnerId, $beginDate, $endDate);
		$total = $totalRes["cnt"];
		$total_amount = $totalRes["sum_amount"];

		$pageMaker	= $this->displayPage($total, 100);
		$list 			= $partnerModel->getRecommendExchangeListTop($partnerId, $beginDate, $endDate, $where, $pageMaker->first, $pageMaker->listNum);	
		
		$this->view->assign("list",$list);
		$this->view->assign('beginDate', $beginDate);
		$this->view->assign('endDate', $endDate);
		$this->view->assign("field", $field);
		$this->view->assign("keyword", $keyword);
		$this->view->assign("total_amount", $total_amount);
		$this->view->assign("filter_rolling_sn", $filterRollingSn);
		$this->view->assign('select_rolling_list', $selectRollingList);
		
		$this->display();
	}
}

?>