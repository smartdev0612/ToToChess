<?php 


class AccountingfinController extends WebServiceController 
{
	//▶ 정산완료
	function listAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
	
		$this->view->define("content","content/accounting_fin/list.html");
		
		$model = $this->getModel("PartnerModel");
		
		$sn 	= $this->auth->getSn();
		
		$where = " and b.Idx='".$sn."'";
		$total 		= $model->getAccountingfinTotal($where);
		$pageMaker 	= $this->displayPage($total, 10);
		$list 		= $model->getAccountingfinList($where, $pageMaker->first, $pageMaker->listNum);
		
		$this->view->assign("list",$list);	
		
		$this->display();
	}
	
	
}

?>