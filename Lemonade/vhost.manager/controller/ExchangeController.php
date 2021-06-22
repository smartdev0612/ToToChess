<?php 


class ExchangeController extends WebServiceController 
{
	//▶ 출금 신청
	function listAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/exchange/list.html");
		
		$model 	= $this->getModel("MoneyModel");
		$partnerModel = $this->getModel("PartnerModel");
		$memberModel = $this->getModel("MemberModel");
		
		$perpage 	 = $this->request('perpage');
		$keyword 	 = $this->request('keyword');
		$beginDate = $this->request('begin_date');
		$endDate 	 = $this->request('end_date');		
		$dateType	 = $this->request('date_type');
		$filterPartnerSn  = $this->request('filter_partner_sn');
		$filter_logo 				= $this->request('filter_logo');
		
		if($perpage=='') $perpage = 30;
		
		if($filterPartnerSn!='') 
		{
			$levelCode = sprintf("%04d", $filterPartnerSn);
			$where=" and b.level_code like('".$levelCode."%')";
		}
		if($keyword!="")
		{
			$field = $this->request('field');
			
			if($field=="uid")
				$where.=" and b.uid like('%".$keyword."%')";
			else if($field=="nick")	
				$where.=" and b.nick like('%".$keyword."%')";
			else if($field=="bank_owner")
				$where.=" and a.bank_owner like('%".$keyword."%')";
		}
		
		if($beginDate!="")
			$where.= " and a.".$dateType.">='".$beginDate." 00:00:00'";
			
		if($endDate!="")
			$where.= " and a.".$dateType."<='".$endDate." 23:59:59'";
			
		if($filter_logo!="") {
			$where .= " and a.logo='".$filter_logo."'";
		}
		
		$page_act = "perpage=".$perpage."&keyword=".$keyword."&begin_date=".$beginDate."&end_date=".$endDate."&date_type=".$dateType."&filter_partner_sn=".$filterPartnerSn."&filter_logo=".$filter_logo;
		
		$where .= " and (a.state=0 or a.state=3) ";
		$total			= $model->getExchangeTotal($state, $where);
		$pageMaker	= $this->displayPage($total, $perpage, $page_act);
		$list 			= $model->getExchangeList($state, 1, $where, $pageMaker->first, $pageMaker->listNum);
		
		$partnerList = $partnerModel->getPartnerIdList();
		
		$this->view->assign('keyword', $keyword);
		$this->view->assign('search_type', $searchType);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('date_type', $dateType);
		$this->view->assign('filter_partner_sn', $filterPartnerSn);
		$this->view->assign('list', $list);
		$this->view->assign('filter_logo', $filter_logo);
		$this->view->assign('partner_list', $partnerList);
		
		$this->display();
	}
	
	//▶ 출금 완료
	function finlistAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/exchange/fin_list.html");
		
		$model 	= $this->getModel("MoneyModel");
		$partnerModel = $this->getModel("PartnerModel");
	
		$perpage 	 	= $this->request('perpage');
		$keyword 	 	= $this->request('keyword');
		$beginDate 	= $this->request('begin_date');
		$endDate 		= $this->request('end_date');		
		$dateType	 	= $this->request('date_type');
		$filterPartnerSn  = $this->request('filter_partner_sn');
		
		if($perpage=='') $perpage=30;
		
		$where = "";
		
		if($filterPartnerSn!='') 
		{
			$levelCode = sprintf("%04d", $filterPartnerSn);
			$where=" and b.level_code like('".$levelCode."%')";
		}
		
		if($keyword!="")
		{
			$field = $this->request("field");
			
			if($field=="uid")
				$where.=" and b.uid like('%".$keyword."%')";
			else if($field=="nick")
				$where.=" and b.nick like('%".$keyword."%')";
			else if($field=="bank_owner")
				$where.=" and a.bank_owner like('%".$keyword."%')";
		}
		
		if($beginDate!="") 
			$where.= " and a.".$dateType.">='".$beginDate." 00:00:00'";
		if($endDate!="")
			$where.= " and a.".$dateType."<='".$endDate." 23:59:59'";
		
		$page_act = "perpage=".$perpage."&keyword=".$keyword."&begin_date=".$beginDate."&end_date=".$endDate."&date_type=".$dateType."&filter_partner_sn=".$filterPartnerSn;
		
		$total			= $model->getExchangeTotal("1", $where);
		$pageMaker	= $this->displayPage($total, $perpage, $page_act);
		$list 			= $model->getExchangeList("1", 1, $where, $pageMaker->first, $pageMaker->listNum);
		
		$partnerList = $partnerModel->getPartnerIdList();
		
		$this->view->assign('keyword', $keyword);
		$this->view->assign('search_type', $searchType);
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('date_type', $dateType);
		$this->view->assign('filter_partner_sn', $filterPartnerSn);
		$this->view->assign('list', $list);
		$this->view->assign('partner_list', $partnerList);
		
		$this->display();
	}
	
	//▶ 출금 완료
	function finlist_editAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/exchange/fin_list_edit.html");
		
		$model 	= $this->getModel("MoneyModel");
		$partnerModel = $this->getModel("PartnerModel");
	
		$perpage 	 	= $this->request('perpage');
		$keyword 	 	= $this->request('keyword');
		$beginDate 	= $this->request('begin_date');
		$endDate 		= $this->request('end_date');		
		$dateType	 	= $this->request('date_type');
		$filterPartnerSn  = $this->request('filter_partner_sn');
		$filter_logo  = $this->request('filter_logo');
		$filter_state  = $this->request('filter_state');
		$orderby = $this->request('orderby');

		if($perpage=='') $perpage=100;
		if ( $orderby == "lev_up" ) {
			$orderbyStr = "b.mem_lev desc";
		} else if ( $orderby == "lev_down" ) {
			$orderbyStr = "b.mem_lev asc";
		} else {
			$orderbyStr = "a.regdate desc";
		}
		
		$where = "";
		
		if($filterPartnerSn!='') 
		{
			$levelCode = sprintf("%04d", $filterPartnerSn);
			$where=" and b.level_code like('".$levelCode."%')";
		}
		
		if($filter_logo!='') {$where=" and a.logo='".$filter_logo."'";}
		
		if($filter_state!='') {$where=" and a.state='".$filter_state."'";}
		
		if($keyword!="")
		{
			$field = $this->request("field");
			
			if($field=="uid")
				$where.=" and b.uid like('%".$keyword."%')";
			else if($field=="nick")
				$where.=" and b.nick like('%".$keyword."%')";
			else if($field=="bank_owner")
				$where.=" and a.bank_owner like('%".$keyword."%')";
		}

		if ( !$dateType ) $dateType = "regdate";
		if ( !$beginDate ) $beginDate = date("Y-m-d",time());
		if ( !$endDate ) $endDate = date("Y-m-d",time());

		if ( $beginDate != "" ) $where.= " and a.".$dateType.">='".$beginDate." 00:00:00'";
		if ( $endDate != "" ) $where.= " and a.".$dateType."<='".$endDate." 23:59:59'";
		
		$page_act = "perpage=".$perpage."&keyword=".$keyword."&begin_date=".$beginDate."&end_date=".$endDate."&date_type=".$dateType."&filter_partner_sn=".$filterPartnerSn."&filter_logo=".$filter_logo."&filter_state=".$filter_state."&orderby=".$orderby;
		
		$total			= $model->getExchangeTotal("", $where);
		$pageMaker	= $this->displayPage($total, $perpage, $page_act);
		$list 			= $model->getExchangeList("", 1, $where, $pageMaker->first, $pageMaker->listNum, $orderbyStr);
		
		$partnerList = $partnerModel->getPartnerIdList();
		
		$this->view->assign('orderby', $orderby);
		$this->view->assign('keyword', $keyword);
		$this->view->assign('search_type', $searchType);
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('date_type', $dateType);
		$this->view->assign('filter_partner_sn', $filterPartnerSn);
		$this->view->assign('list', $list);
		$this->view->assign('partner_list', $partnerList);
		$this->view->assign('filter_logo', $filter_logo);
		$this->view->assign('filter_state', $filter_state);
		
		$this->display();
	}
	
	//▶ 환전 대기->승인
	function popup_agreeAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/exchange/popup_agree.html");
		$model 	= $this->getModel("MoneyModel");
		$pModel = $this->getModel("ProcessModel");
		
		$mode 	= $this->request("mode");
		
		$member_sn		= $this->request("member_sn");
		$sn		= $this->request("sn");
		$amount	= $this->request("amount");
		
		if($mode=="edit")
		{
			$rs = $pModel->exchangeConfirmProcess($sn);
			if($rs<=0)
			{
				throw new Lemon_ScriptException("","","script","alert('이미 출금이 완료 되였습니다.');opener.document.location.reload(); self.close();");				
				exit;
			}
			throw new Lemon_ScriptException("","","script","alert('출금 신청이 완료 되였습니다');opener.document.location.reload(); self.close();");				
		}
		else if($mode="cancel")
		{
			$pModel->exchange_rollbackReqProcess($sn);
			throw new Lemon_ScriptException("","","script","alert('처리되었습니다');opener.document.location.reload(); self.close();");			
			exit;
		}
	
		
		$this->view->assign('sn', $sn);
		$this->view->assign('amount', $amount);
		
		$this->display();
	}
	
	//▶ 환전처리 팝업
	function popup_processAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/exchange/popup_process.html");
		$model 	= $this->getModel("MoneyModel");
		$mModel = $this->getModel("MemberModel");
		$pModel = $this->getModel("ProcessModel");

		$memberSn	= $this->request("memberSn");
		$amount 	= $this->request("amount");
		$mode 		= $this->request("mode");
		$sn 		= $this->request("sn");

		if($mode=="cancel")
		{
			$rs = $pModel->exchangeCancelProcess($sn);
						
			if($rs <=0 )
			{
				throw new Lemon_ScriptException("","","script","alert('이미 대기중으로 이전되였습니다.');opener.document.location.reload(); self.close();");
				exit;
			}

			throw new Lemon_ScriptException("","","script","alert('취소 되였습니다. '); opener.document.location.reload(); self.close();");
			
		}		
		else if($mode=="agree")
		{
			$rs = $pModel->exchangeProcess($sn);

			if($rs<=0)
			{
				throw new Lemon_ScriptException("","","script","alert('이미 대기중으로 이전되였습니다.');opener.document.location.reload(); self.close();");				
				exit;
			}
			
			throw new Lemon_ScriptException("","","script","alert('처리 되였습니다.');opener.document.location.reload(); self.close();");			
		}
		else
		{
			$mem_id = $mModel->getMemberField($memberSn, "uid");
		}
		
		
		$this->view->assign('memberSn', $memberSn);
		$this->view->assign('sn', $sn);
		$this->view->assign('mem_id', $mem_id);
		$this->view->assign('amount', $amount);

		$this->display();
	}	 
	
	function delprocessAction()
	{
		$processModel = $this->getModel("ProcessModel");
		$sn 		= $this->request("sn");
		
		$rs = $processModel->exchangeProcess($sn);
		
		
		throw new Lemon_ScriptException("처리 되였습니다","","go","/exchange/list");				
		
	}
	 
	
	//▶ 환전정보
	function popup_exchangeAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/exchange/popup.list.html");
		
		$model 	= $this->getModel("MoneyModel");
		
		$memberSn 	= $this->request('member_sn');
		$beginDate 	= $this->request('date_id');
		$endDate 		= $this->request('date_id1');		
		$dateType		= $this->request('seldate');
		$searchType = $this->request('search_type');
		$keyword		= $this->request('keyword');
		
		$where = "";
		if($keyword!="")
		{
			if($searchType=='uid')
				$where.=" and b.uid like('%".$keyword."%')";
			else if($searchType=="nick")
				$where.=" and b.nick like('%".$keyword."%')";
			else if($searchType=="bank_owner")
				$where.=" and a.bank_owner like('%".$keyword."%')";
			else if($searchType=="bank_account")
				$where.=" and a.bank_account like('%".$keyword."%')";
				// chltnwjd
			else if($searchType=="partner_id")
				$where.=" and a.bank_account like('%".$keyword."%')";
		}
		
		if($beginDate!="") 
			$where.= " and a.".$dateType.">='".$beginDate." 00:00:00'";
			
		if($endDate!="")
			$where.= " and a.".$dateType."<='".$endDate." 23:59:59'";
		
		$page_act = "field=".$searchType."&keyword=".$keyword."&member_sn=".$memberSn."&seldate=".$dateType."&date_id=".$beginDate."&date_id1=".$endDate;		
		$total			= $model->getMemberExchangeTotal($memberSn, $where);
		$pageMaker 	= $this->displayPage($total, 10, $page_act);
		$list 			= $model->getMemberExchangeList($memberSn, "", $where, $pageMaker->first, $pageMaker->listNum);
		
		$this->view->assign('id', $memberSn);
		$this->view->assign('field', $searchType);
		$this->view->assign('date_id1', $endDate);
		$this->view->assign('date_id', $beginDate);
		$this->view->assign('seldate', $dateType);
		$this->view->assign('list', $list);
		
		$this->display();
	}
}

?>