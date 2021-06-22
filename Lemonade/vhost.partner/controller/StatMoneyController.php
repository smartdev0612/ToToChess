<?php

class StatMoneyController extends WebServiceController 
{
	//▶ 입출금통계
	function listAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/statmoney/list.html");
			
		$partnerModel = $this->getModel("PartnerModel");
		
		$act = $this->request("act");
		$tex_exchange_money = $this->request("tex_exchange_money");
		$beginDate = $this->request("date");
		$endDate = $this->request("date1");
		$partnerSn = $this->auth->getSn();
		
		//디폴트 날짜 = 1일부터 금일까지
		if( !$beginDate or !$endDate ) {
			$beginDate = date("Y-m-")."01";
			$endDate = date("Y-m-d",time()-86400);
		}

		$parentInfo = $partnerModel->getPartnerRow($partnerSn);		

		//-> 출금신청
		if ( $act == "tex_exchange" ) {
			//-> 보유금액 확인.
			if ( $tex_exchange_money <= $parentInfo["rec_money"] ) {
				if ( $parentInfo["rec_money"] < 1 ) {
					$script	= "alert('출금 가능 금액이 아닙니다.'); document.location='/statMoney/list';";
					throw new Lemon_ScriptException("","","script",$script);
					exit();
				}
				$after_money = $parentInfo["rec_money"] - $tex_exchange_money;

				//-> 보유머니 빼기
				$partnerModel->modifyRecMoney($partnerSn, $after_money);

				//-> 출금신청 로그 쌓기
				$partnerModel->changeRecMoneyLog($partnerSn, $tex_exchange_money, $parentInfo["rec_money"], $after_money, 2, "총판 정산금 출금신청");

				$script	= "alert('출금신청이 완료 되었습니다.'); document.location='/statMoney/list';";
				throw new Lemon_ScriptException("","","script",$script);
				exit();
			}
		}


		$list = $partnerModel->getTexDataPartner($partnerSn, $beginDate, $endDate);


		$this->view->assign('parentInfo', $parentInfo);
		$this->view->assign('date', $beginDate);
		$this->view->assign('date1', $endDate);
		$this->view->assign('list', $list);		
		$this->display();
	}
}
?>