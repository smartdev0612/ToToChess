<?php 


class ChargeController extends WebServiceController 
{
	//▶ 입금신청
	function listAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/charge/list.html");
		
		$model 	= $this->getModel("MoneyModel");
		$partnerModel = $this->getModel("PartnerModel");
		
		$act 			= $this->request('act');
		
		$perpage 					= $this->request('perpage');	
		$keyword 					= $this->request('keyword');
		$filterPartnerSn  = $this->request('filter_partner_sn');
		$beginDate  			= $this->request('begin_date');
		$endDate 					= $this->request('end_date');
		$dateType  				= $this->request('date_type');
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
			
			if($field=="uid")				{$where.=" and b.uid like('%".$keyword."%')";}
			else if($field=="nick")	{$where.=" and b.nick like('%".$keyword."%')";}
			else if($field=="bank_owner")	{$where.=" and a.bank_owner like('%".$keyword."%')";}
		}
		
		if($beginDate!="") {
			$where.= " and a.".$dateType.">='".$beginDate." 00:00:00'";
		}
		
		if($endDate!="")	 {
			$where.= " and a.".$dateType."<='".$endDate." 23:59:59'";
		}
		
		if($filter_logo!="") {
			$where .= " and a.logo='".$filter_logo."'";
		}
		
		$page_act = "perpage=".$perpage."&keyword=".$keyword."&begin_date=".$beginDate."&end_date=".$endDate."&field=".$field."&act=".$act."&date_type=".$dateType."&filter_partner_sn=".$filterPartnerSn."&filter_logo=".$filter_logo;

		$total 			= $model->getChargeTotal("0", $where);
		$pageMaker	= $this->displayPage($total, $perpage, $page_act);
		$list 			= $model->getChargeList("0", 1, $where, $pageMaker->first, $pageMaker->listNum);
		
		$partnerList = $partnerModel->getPartnerIdList();
		
		$this->view->assign('keyword', $keyword);
		$this->view->assign('field', $field);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('date_type', $dateType);
		$this->view->assign('filter_partner_sn', $filterPartnerSn);
		$this->view->assign('filter_logo', $filter_logo);
		$this->view->assign('list', $list);
		$this->view->assign('partner_list', $partnerList);
		
		$this->display();
	}

	//▶ 입금완료 리스트
	function finlistAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/charge/fin_list.html");
		
		$keyword 					= $this->request('keyword');
		$perpage 					= $this->request('perpage');
		$filterPartnerSn  = $this->request('filter_partner_sn');
		$beginDate  			= $this->request("begin_date");
		$endDate 					= $this->request("end_date");
		$dateType  				= $this->request('date_type');
		
		$model = $this->getModel("MoneyModel");
		$partnerModel = $this->getModel("PartnerModel");
		
		if($perpage=='') $perpage = 30;		
			
		$where = "";
		
		if($filterPartnerSn!='') 
		{
			$levelCode = sprintf("%04d", $filterPartnerSn);
			$where=" and b.level_code like('".$levelCode."%')";
		}
		
		if($keyword!="")
		{
			$field = $this->request("field");
			
			if($field=="uid")							{$where.=" and b.uid like('%".$keyword."%')";}
			else if($field=="nick")				{$where.=" and b.nick like('%".$keyword."%')";}
			else if($field=="bank_owner")	{$where.=" and a.bank_owner like('%".$keyword."%')";}
		}

		$page_act = "perpage=".$perpage."&keyword=".$keyword."&begin_date=".$beginDate."&end_date=".$endDate."&field=".$field."&act=".$act."&date_type=".$dateType."&filter_partner_sn=".$filterPartnerSn;
		
		if($beginDate!="") {$where.= " and a.".$dateType.">='".$beginDate." 00:00:00'";}
		if($endDate!="")	 {$where.= " and a.".$dateType."<='".$endDate." 23:59:59'";}
		
		$total 				= $model->getChargeTotal("1", $where);
		$pageMaker		= $this->displayPage($total, $perpage, $page_act);
		$list 				= $model->getChargeList("1", "", $where, $pageMaker->first, $pageMaker->listNum);
		$partnerList = $partnerModel->getPartnerIdList();
		
		$this->view->assign('keyword', $keyword);
		$this->view->assign('field', $field);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('date_type', $dateType);
		$this->view->assign('filter_partner_sn', $filterPartnerSn);
		$this->view->assign('list', $list);
		$this->view->assign('partner_list', $partnerList);
		
		$this->display();
	}
	
	//▶ 입금완료 리스트
	function finlist_editAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/charge/fin_list_edit.html");
		
		$keyword 					= $this->request('keyword');
		$perpage 					= $this->request('perpage');
		$filterPartnerSn  = $this->request('filter_partner_sn');
		$beginDate  			= $this->request("begin_date");
		$endDate 					= $this->request("end_date");
		$dateType  				= $this->request('date_type');
		$filter_logo  = $this->request('filter_logo');
		$filter_state  = $this->request('filter_state');
		
		$model = $this->getModel("MoneyModel");
		$partnerModel = $this->getModel("PartnerModel");
		
		if($perpage=='') $perpage = 100;
			
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
			
			if($field=="uid")							{$where.=" and b.uid like('%".$keyword."%')";}
			else if($field=="nick")				{$where.=" and b.nick like('%".$keyword."%')";}
			else if($field=="bank_owner")	{$where.=" and a.bank_owner like('%".$keyword."%')";}
		}

		$page_act = "perpage=".$perpage."&keyword=".$keyword."&begin_date=".$beginDate."&end_date=".$endDate."&field=".$field."&act=".$act."&date_type=".$dateType."&filter_partner_sn=".$filterPartnerSn."&filter_logo=".$filter_logo."&filter_state=".$filter_state;

		if ( !$dateType ) $dateType = "regdate";
		if ( !$beginDate ) $beginDate = date("Y-m-d",time());
		if ( !$endDate ) $endDate = date("Y-m-d",time());

		if ( $beginDate != "" ) $where.= " and a.".$dateType.">='".$beginDate." 00:00:00'";
		if ( $endDate != "" ) $where.= " and a.".$dateType."<='".$endDate." 23:59:59'";
		
		$total 				= $model->getChargeTotal("", $where);
		$pageMaker		= $this->displayPage($total, $perpage, $page_act);
		$list 				= $model->getChargeList("", "", $where, $pageMaker->first, $pageMaker->listNum);
		$partnerList = $partnerModel->getPartnerIdList($filter_logo);

		$this->view->assign('keyword', $keyword);
		$this->view->assign('field', $field);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('date_type', $dateType);
		$this->view->assign('filter_partner_sn', $filterPartnerSn);
		$this->view->assign('list', $list);
		$this->view->assign('partner_list', $partnerList);
		$this->view->assign('filter_logo', $filter_logo);
		$this->view->assign('filter_state', $filter_state);
		
		$this->display();
	}
	
	//▶ 입금승인
	function agreeAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/charge/agree.html");
		
		$model 	= $this->getModel("MoneyModel");
		$mModel = $this->getModel("MemberModel");
		$pModel = $this->getModel("ProcessModel");
        $configModel = $this->getModel("ConfigModel");

		$mode		= $this->request("mode");
		$chargeSn	= $this->request("charge_sn");		
		$bonus 		= $this->request("bonus");
		
		$rs = $model->getChargeRow($chargeSn);
		$amount 	= $rs['amount'];
		$memberSn 	= $rs['member_sn'];
		$uid		= $mModel->getMemberField($memberSn, 'uid');
		$bonus = str_replace(",","",$bonus);
		//$maxBonus = ($amount*20)/100;
		//$maxBonus = $amount * 5;
        $maxBonus = 500;

		$lev_charge_mileage = $configModel->getLevChargeMilage($memberSn);
		//-> 최초 충전		
		$charge_list = $model->getRows("*", $model->db_qz."charge_log", "member_sn=".$memberSn);

		//-> 금일 충전 합계
		$to_day = date("Y-m-d",time());
		$to_day_charge = $model->getRows("sum(amount) as sum_amount", $model->db_qz."charge_log", "state = 1 and regdate >= '{$to_day} 00:00:00' and regdate <= '{$to_day} 23:59:59' and member_sn=".$memberSn);
		$to_day_charge = $to_day_charge[0]["sum_amount"]+0;

		//-> 금일 환전 합계
		$to_day = date("Y-m-d",time());
		$to_day_exchange = $model->getRows("count(sn) as sum_cnt", $model->db_qz."exchange_log", "state = 1 and regdate >= '{$to_day} 00:00:00' and regdate <= '{$to_day} 23:59:59' and member_sn=".$memberSn);
		$to_day_exchange = $to_day_exchange[0]["sum_cnt"]+0;

		//-> 전날 충전 합계
		$prv_day = date("Y-m-d",time()-86400);
		$prv_day_charge = $model->getRows("sum(amount) as sum_amount", $model->db_qz."charge_log", "state = 1 and regdate >= '{$prv_day} 00:00:00' and regdate <= '{$prv_day} 23:59:59' and member_sn=".$memberSn);
		$prv_day_charge = $prv_day_charge[0]["sum_amount"]+0;

		if($mode=="process")
		{
			$agreeAmount = $this->request("amount");
			$amount = str_replace(",","",$agreeAmount);

			if($bonus>$maxBonus)
			{
				//throw new Lemon_ScriptException("","","script","alert('충전 금액의 20%이상 보너스를 지급할 수 없습니다.');opener.document.location.reload(); self.close();");
				throw new Lemon_ScriptException("","","script","alert('충전 금액의 500%이상 보너스를 지급할 수 없습니다.');opener.document.location.reload(); self.close();");
				exit;
			}

			if($model->isCharged($chargeSn))
			{
				throw new Lemon_ScriptException("","","script","alert('이미 충전 되였습니다.');opener.document.location.reload(); self.close();");
				exit;
			}
			$pModel->chargeProcess($chargeSn, $memberSn, $amount, $bonus);

			// 관리자 입금 승인 로그
			$pModel->insertChargeAgreeLog($chargeSn, $_SESSION["member"]["sn"], $_SESSION["member"]["ip"]);
			
			throw new Lemon_ScriptException("","","script","alert('처리 되였습니다.');opener.document.location.reload(); self.close();");
			exit;
		}

        $charge_mileage = $lev_charge_mileage[0]['lev_charge_mileage_rate'];
		if($to_day_charge == 0)
        {
            $charge_mileage = $lev_charge_mileage[0]['lev_first_charge_mileage_rate'];
        }

        $this->view->assign('charge_mileage', $charge_mileage);
        $this->view->assign('chargeSn', $chargeSn);
		$this->view->assign('uid', $uid);
		$this->view->assign('amount', $amount);
		$this->view->assign('maxBonus', $maxBonus);
		$this->view->assign('first_charge', count((array)$charge_list));
		$this->view->assign('to_day_charge', $to_day_charge);
		$this->view->assign('to_day_exchange', $to_day_exchange);
		$this->view->assign('prv_day_charge', $prv_day_charge);
		$this->display();
	}
	
	//▶ 입금 신청 삭제
	function delProcessAction()
	{
		$model = $this->getModel("ProcessModel");
		
		$sn	= $this->request("sn");
		$rs = $model->delchargeReq($sn);
		if($rs<=0)
		{
			throw new Lemon_ScriptException("이미 취소 되었습니다","","go","/charge/finlist_edit");						
			exit;
		}
		throw new Lemon_ScriptException("처리 되였습니다.","","go","/charge/finlist_edit");				
	}

	//-> 입금 신청 내역 취소 (데이터는 삭제 안함)
	function chargeToCancelAction() {
		$model = $this->getModel("ProcessModel");
		$sn	= $this->request("sn");
		$rs = $model->chargeToCancel($sn);
		if ( $rs <= 0 ) {
			throw new Lemon_ScriptException("이미 취소 되었습니다","","go","/charge/finlist_edit");						
			exit;
		}
		throw new Lemon_ScriptException("처리 되였습니다.","","go","/charge/finlist_edit");				
	}

	//▶ 취소
	function cancelProcessAction()
	{
		$pModel = $this->getModel("ProcessModel");
		
		$sn	= $this->request("sn");
		$rs = $pModel->chargeCancelProcess($sn);
		if($rs<=0)
		{
			throw new Lemon_ScriptException("","","script","alert('이미 취소 되었습니다.');opener.document.location.reload(); self.close();");			
			exit;
		}
		throw new Lemon_ScriptException("","","script","alert('처리 되였습니다.');opener.document.location.reload(); self.close();");
	}
	
	//▶ 충전정보
	function popup_chargeAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/charge/popup.list.html");
		
		$model 	= $this->getModel("MoneyModel");
		$mModel = $this->getModel("MemberModel");
		
		$uid = $this->request('mem_id');
		$sn = $mModel->getSn($uid);
		
		// chltnwjd
		if($uid!="")
		{
			$field = $this->request('field');
		}
	
		$seldate = $this->request('seldate');
		$date_id = $this->request('date_id');
		$date_id1 = $this->request('date_id1');
		
		if($date_id!="")	{$where.= " and a.".$seldate.">='".$date_id." 00:00:00'";}
		if($date_id1!="")	{$where.= " and a.".$seldate."<='".$date_id1." 23:59:59'";}
		
		$page_act = "field=".$field."&mem_id=".$uid."&seldate=".$seldate."&date_id=".$date_id."&date_id1=".$date_id1;
		$total		= $model->getMemberChargeTotal($sn, "", $where);		
		$pageMaker 	= $this->displayPage($total, 10, $page_act);
		$list 		= $model->getMemberChargeList($sn, "", $where, $pageMaker->first, $pageMaker->listNum);
		
		$this->view->assign('uid', $uid);
		$this->view->assign('field', $field);
		$this->view->assign('date_id1', $date_id1);
		$this->view->assign('date_id', $date_id);
		$this->view->assign('seldate', $seldate);
		$this->view->assign('list', $list);
		
		$this->display();
	}
}

?>