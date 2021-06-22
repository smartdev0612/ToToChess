<?php 


class AccountingController extends WebServiceController 
{
	//▶ 정산신청
	function listAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		
		$this->view->define("content","content/accounting/list.html");
		
		//	header("Content-Type:text/html;charset=UTF-8");
			
		$model = $this->getModel("PartnerModel");
		
		if($this->request("act")== "change" )
		{
			$partner_sn = $this->request("partner_sn");
			$start_date = $this->request("start_date");
			$end_date = $this->request("end_date");
			$exchange_money = $this->request("exchange_money");
			$charge_money = $this->request("charge_money");
			$rate = $this->request("rate");
			$optmoney = $this->request("optmoney");
			$bank_name = $this->request("bank_name");
			$bank_num = $this->request("bank_num");
			$bank_username = $this->request("bank_username");
			
			
		//	echo "start_date: ".$start_date."<br/>";
		//	echo "end_date: ".$end_date."<br/>";
		
		//	echo "bank_name: ".$bank_name."<br/>";
		//	echo "bank_num: ".$bank_num."<br/>";
		//	echo "bank_username: ".$bank_username."<br/>";
						
			$model->addAccounting($partner_sn,$start_date,$end_date,$exchange_money,$charge_money,$rate,$optmoney,$bank_name,$bank_num,$bank_username);
			
			throw new Lemon_ScriptException("정산 신청이 접수되였습니다!","","go","/Accounting/list");
			exit;					
		}		
		
		$sn 	= $this->auth->getSn();
		$partner_id = $this->auth->getId();
		$partner_name = $this->auth->getName();
		
		if( !empty($sn) )
		{
			$list = $model->getPartnerAccounting($sn);
		}	
		
	//	print_r($list);
		$this->view->assign("partner_id",$partner_id);	
		$this->view->assign("partner_name",$partner_name);	
		
		$this->view->assign("sn",$sn);			
		$this->view->assign("list",$list);	
		
		$this->display();
	}
	
	
}

?>