<?php 

class StatController extends WebServiceController 
{

	//▶ 로그인 내역
	function adminlogAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/stat/admin_log.html");
		
		$model 	= $this->getModel("StatModel");
		$lModel 	= $this->getModel("LoginModel");
		
		$perpage = $this->request("perpage");
		$beginDate = $this->request("begin_date");
		$endDate = $this->request("end_date");
		
		if($perpage=='')		$perpage=10;
		if($beginDate!="") 	{$where = "and  login_date >='".$beginDate."'";}
		if($endDate!="")
		{
			if($where==""){$where="and login_date <='".$endDate."'";}
			$where=$where." and login_date <='".$endDate."'";
		}
	
		$page_act = "begin_date=".$beginDate."&end_date=".$endDate."&keyword=".$keyword."&perpage=".$perpage;
		$total 			= $lModel->getAdminLoginTotal($where);
		$pageMaker 	= $this->displayPage($total, 10, $page_act);
		$list 			= $lModel->getAdminLogList($where, $pageMaker->first, $pageMaker->listNum);
		
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('list', $list);
		$this->display();
	}

	//▶ 수익 통계
	function texAction()
	{
		$this->commonDefine();

		if ( !$this->auth->isLogin() ) {
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/stat/tex.html");
		
		$model = $this->getModel("PartnerModel");
		$eModel = $this->getModel("EtcModel");
		$field = $this->request('field');
		$keyword = $this->request('keyword');
		$act = $this->request('act');
		$logo = $this->request('logo');
		$startDate = $this->request("startDate");
		$endDate = $this->request("endDate");

		//-> 디폴트 날짜 = 1일부터 금일까지
		if ( $startDate == '' or $endDate == '' ) {
			$startDate = date("Y-m-")."01";
			$endDate = date("Y-m-d");
		}

		if($field != "" and $keyword != "") {
			$where = " and {$field} = '{$keyword}'";
		}

		$page_act = "field=".$field."&keyword=".$keyword."&startDate=".$startDate."&endDate=".$endDate;

		$total = $model->getRecommendTotal($where);
		$pageMaker = $this->displayPage($total, 10, $page_act);
		$list = $model->getRecommendList($where, $pageMaker->first, $pageMaker->listNum);

		for ( $i = 0 ; $i < count((array)$list) ; $i++ ) {
			$res_tex_log = $model->getRecommendTex($list[$i]["Idx"], $startDate, $list[$i]["rec_one_folder_flag"], $list[$i]["rec_rate"], $list[$i]["rec_rate_fail"], $list[$i]["rec_rate_inout"]);

			$res_money_log = $model->getRecommendMoneyList($list[$i]["Idx"], $startDate, $endDate, $this->logo);

			$money_log_temp = array();
			for ( $j = 0 ; $j < count((array)$res_money_log) ; $j++ ) {
				$money_log_temp["end_lose_money"] += $res_money_log[$j]['lose_money'] - $res_money_log[$j]['win_money'];
				$money_log_temp["end_lose_money_one"] += $res_money_log[$j]['lose_money_one'] - $res_money_log[$j]['win_money_one'];

				$money_log_temp["exchange"] += ($res_money_log[$j]["exchange"]+$res_money_log[$j]["admin_exchange"]);
				$money_log_temp["charge"] += ($res_money_log[$j]["charge"]+$res_money_log[$j]["admin_charge"]);
				$money_log_temp["betting"] += $res_money_log[$j]["betting"];
				$money_log_temp["win_money"] += $res_money_log[$j]["win_money"];
				$money_log_temp["lose_money"] += $res_money_log[$j]["lose_money"];
				$money_log_temp["end_mileage_charge"] += ($res_money_log[$j]["admin_mileage_charge"]+$res_money_log[$j]["admin_mileage_exchange"]);

				//-> 단폴더
				$money_log_temp["betting_one"] += $res_money_log[$j]["betting_one"];
				$money_log_temp["one_folder_charge"] += $res_money_log[$j]["one_folder_charge"];
			}

			$money_log_temp["end_inout"] = $money_log_temp["charge"] - $money_log_temp["exchange"];
			$money_log_temp["benefit"] = $money_log_temp["charge"] - $money_log_temp["exchange"] - $money_log_temp["end_mileage_charge"];
			$list[$i]["money_log"] = $money_log_temp;

			unset($money_log_temp);
		}

		$this->view->assign('startDate', $startDate);
		$this->view->assign('endDate', $endDate);
		$this->view->assign('list', $list);
		$this->view->assign('logo', $logo);
		$this->view->assign('keyword', $keyword);
		
		$this->display();
	}

	//▶ 사이트 정산
	function siteaccountAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/stat/site_accounting.html");
		
		$model 	= $this->getModel("StatModel");
		$mModel = $this->getModel("MoneyModel");
		$aModel = $this->getModel("AccountModel");
		
		$act = $this->request('act');
		
		if(isset($act)&&$act=="account")
		{
			$exchange_money	 = $this->request("exchange_money");
			$change_money	 = $this->request("change_money");
			$acc_bet		 = $this->request("acc_bet");
			$acc_bonus_money = $this->request("acc_bonus_money");
			$acc_partner	 = $this->request("acc_partner");
			$account_money	 = $this->request("account_money");
			$beginDate		 = $this->request("reg_date");
			$endDate		 = $this->request("objdate");
			
			$rs = $aModel->addSiteAccount($exchange_money, $change_money, $acc_bet, $acc_bonus_money, $acc_partner, $account_money, $beginDate, $endDate);
				
			if($rs>0) { throw new Lemon_ScriptException("정산 신청이 접수되였습니다!","","go","/stat/siteaccount"); }
			else { throw new Lemon_ScriptException("정산 신청이 실패하였습니다!","","go","/stat/siteaccount"); }
			exit;
		}
		
		$accountList = $aModel->accountSite();
		
		$total = $aModel->getSiteAccountTotal();
		$pageMaker = $this->displayPage($total, 10);
		$list = $aModel->getSiteAccountList($pageMaker->first, $pageMaker->listNum);
		
		$this->view->assign('list', $list);
		$this->view->assign('lastList', $accountList);
		$this->display();
	}

	//▶ 사이트 현황
	function siteAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/stat/site.html");
		
		$statModel = $this->getModel("StatModel");
		$partnerModel = $this->getModel("PartnerModel");
		
		$beginDate	= $this->request("begin_date");
		$endDate		= $this->request("end_date");
		$filterPartnerSn 	= $this->request('filter_partner_sn');
		$filter_logo 				= $this->request('filter_logo');
		
		//디폴트 날짜 = 1일부터 금일까지
		if($beginDate=='' or $endDate=='')
		{
			$beginDate 	= date("Y-m-")."01";
			$endDate 		= date("Y-m-d");
		}

		$list = $statModel->getMemberStatic('', $filterPartnerSn, $beginDate, $endDate, $filter_logo);
		
		$sumList = array();
		
		foreach($list as $key => $value)
		{
			$sumList['total_member_count'] 							+= $list[$key]['member_count'];
			$sumList['total_charge_member_count'] 			+= $list[$key]['charge_member_count'];
			$sumList['total_visit_member_count'] 				+= $list[$key]['visit_member_count'];
			$sumList['total_betting_member_count'] 			+= $list[$key]['betting_member_count'];
			$sumList['total_sum_betting']								+= $list[$key]['sum_betting'];
			$sumList['total_bet_count']									+= $list[$key]['bet_count'];
			$sumList['total_ing_game']									+= $list[$key]['ing_game'];
			$sumList['total_fin_game']									+= $list[$key]['fin_game'];
			$sumList['total_charge_count']							+= $list[$key]['charge_count'];
			$sumList['total_sum_charge']								+= $list[$key]['sum_charge'];
			$sumList['total_exchange_count']						+= $list[$key]['exchange_count'];
			$sumList['total_sum_exchange']							+= $list[$key]['sum_exchange'];
		}
		
		$partnerList = $partnerModel->getPartnerIdList($filter_logo);
		
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('list', $list);
		$this->view->assign('sumList', $sumList);
		$this->view->assign('filter_logo', $filter_logo);
		$this->view->assign('filter_partner_sn', $filterPartnerSn);
		$this->view->assign('partner_list', $partnerList);
		$this->display();
	}
	
	//▶ 입/출금 통계
	function moneyAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/stat/money.html");
		
		$statModel = $this->getModel("StatModel");
		$partnerModel = $this->getModel("PartnerModel");
		
		$beginDate	= $this->request("begin_date");
		$endDate		= $this->request("end_date");
		$filterPartnerSn 	= $this->request('filter_partner_sn');
		$filter_logo 				= $this->request('filter_logo');
		
		//디폴트 날짜 = 1일부터 금일까지
		if($beginDate=='' or $endDate=='')
		{
			$beginDate 	= date("Y-m-")."01";
			$endDate 		= date("Y-m-d");
		}
		
		if($filterPartnerSn!="")
			$list = $partnerModel->getRecommendMoneyList($filterPartnerSn, $beginDate, $endDate, $filter_logo);
		else
			$list = $statModel->getMoneyList('', $filterPartnerSn, $beginDate, $endDate, $filter_logo);
			
		$sumList = array();
		
		foreach($list as $key => $value)
		{
			$sumList['sum_betting'] 							+= $list[$key]['betting'];
			$sumList['sum_win_money']							+= $list[$key]['win_money'];
			$sumList['sum_lose_money']						+= $list[$key]['lose_money'];
			//$sumList['sum_betting_benefit']				+= $list[$key]['betting_benefit'];
			$sumList['sum_betting_ready_money']		+= $list[$key]['betting_ready_money'];
			$sumList['sum_exchange']							+= $list[$key]['exchange'];
			$sumList['sum_charge']								+= $list[$key]['charge'];
			$sumList['sum_benefit']								+= $list[$key]['benefit'];
			$sumList['sum_admin_charge']					+= $list[$key]['admin_charge'];
			$sumList['sum_admin_exchange']				+= $list[$key]['admin_exchange'];
			$sumList['sum_admin_mileage_charge']	+= $list[$key]['admin_mileage_charge'];
			$sumList['sum_admin_mileage_exchange']+= $list[$key]['admin_mileage_exchange'];

			//-> 정산금회원에게 내림(합계)
			$sumList['sum_admin_tex_charge']	+= $list[$key]['admin_tex_charge'];
		}
		
		$partnerList = $partnerModel->getPartnerIdList($filter_logo);
		
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('list', $list);
		$this->view->assign('sumList', $sumList);
		$this->view->assign('filter_partner_sn', $filterPartnerSn);
		$this->view->assign('filter_logo', $filter_logo);
		$this->view->assign('partner_list', $partnerList);
		$this->display();
	}

    function checkAction()
    {
        $this->commonDefine();

        if(!$this->auth->isLogin())
        {
            $this->redirect("/login");
            exit;
        }
        $this->view->define("content","content/stat/check.html");

        $statModel = $this->getModel("StatModel");

        $beginDate	= $this->request("begin_date");
        $endDate = $this->request("end_date");
        $field 	= $this->request('field');
        $keyword = $this->request('keyword');

        //디폴트 날짜 = 1일부터 금일까지
        if($beginDate=='' or $endDate=='')
        {
            $beginDate 	= date("Y-m-")."01";
            $endDate 		= date("Y-m-d");
        }

        $list = $statModel->getCheckList($field, $keyword, $beginDate, $endDate);

        $this->view->assign('begin_date', $beginDate);
        $this->view->assign('end_date', $endDate);
        $this->view->assign('field', $field);
        $this->view->assign('keyword', $keyword);
        $this->view->assign('list', $list);
        $this->display();
    }

    //▶ 팝업 입/출금 통계
	function popup_moneyAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/stat/popup_money.html");
		
		$statModel = $this->getModel("StatModel");
		$partnerModel = $this->getModel("PartnerModel");
		
		$date	= $this->request("date");
		if($date=="") exit;
		
		$beginDate	= $date;
		$endDate		= $date;
		$filterPartnerSn 	= $this->request('filter_partner_sn');
		
		if($filterPartnerSn!="")
			$list = $partnerModel->getRecommendMoneyList($filterPartnerSn, $beginDate, $endDate);
		else
			$list = $statModel->getMoneyList('', $filterPartnerSn, $beginDate, $endDate);
			
		$sumList = array();
		
		foreach($list as $key => $value)
		{
			$sumList['sum_betting'] 							+= $list[$key]['betting'];
			$sumList['sum_win_money']							+= $list[$key]['win_money'];
			$sumList['sum_lose_money']						+= $list[$key]['lose_money'];
			$sumList['sum_betting_benefit']				+= $list[$key]['betting_benefit'];
			$sumList['sum_betting_ready_money']		+= $list[$key]['betting_ready_money'];
			$sumList['sum_exchange']							+= $list[$key]['exchange'];
			$sumList['sum_charge']								+= $list[$key]['charge'];
			$sumList['sum_benefit']								+= $list[$key]['benefit'];
			$sumList['sum_admin_charge']					+= $list[$key]['admin_charge'];
			$sumList['sum_admin_exchange']				+= $list[$key]['admin_exchange'];
			$sumList['sum_admin_mileage_charge']	+= $list[$key]['admin_mileage_charge'];
			$sumList['sum_admin_mileage_exchange']+= $list[$key]['admin_mileage_exchange'];
		}
		
		$partnerList = $partnerModel->getPartnerIdList();
		
		$this->view->assign('date', $date);
		$this->view->assign('list', $list);
		$this->view->assign('sumList', $sumList);
		$this->view->assign('filter_partner_sn', $filterPartnerSn);
		$this->view->assign('partner_list', $partnerList);
		$this->display();
	}
	
	//▶ 베팅 통계
	function betAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/stat/bet.html");
		
		$model = $this->getModel("StatModel");
		$league_model	= $this->getModel("LeagueModel");
		
		$filter_logo 				= $this->request('filter_logo');
		$filter_category		= $this->request("filter_category");
		$filter_league			= $this->request("filter_league");
		$begin_date			= $this->request("begin_date");
		$end_date				= $this->request("end_date");
		
		if($begin_date=="")		{$begin_date=date("Y-m")."-01";}
		if($end_date=="")			{$end_date=date("Y-m-d");}
		
		if($filter_category == "soccer_live")
		{
			$rs = $model->getLiveBetList($filter_logo, $filter_league, $begin_date, $end_date);
		}
		else
		{
			$rs = $model->getBetList($filter_logo, $filter_category, $filter_league, $begin_date, $end_date);
		}
	
		$list = array();
		$totalList = array();
		$j = 0;
		$list[$j]['regdate'] = $begin_date;
		$list[$j]['date_name']	=$model->dateName($list[$j]['regdate']);

		for($i=0; $i<count((array)$rs); ++$i)
		{
			//축구실시간을 위한 편집
			switch($rs[$i]["result"])
			{
				case "-1"				: $rs[$i]["result"] = '0'; break;
				case "WIN"			: $rs[$i]["result"] = '1'; break;
				case "LOS"			: $rs[$i]["result"] = '2'; break;
				case "DRAW"		: $rs[$i]["result"] = '4'; break;
				case "CANCEL"	: $rs[$i]["result"] = '4'; break;
			}
			
			
			if($list[$j]['regdate'] != $rs[$i]["regdate"])
			{
				$j++;
				$list[$j]['regdate'] = $rs[$i]["regdate"];
				$list[$j]['date_name']	=$model->dateName($list[$j]['regdate']);
				$list[$j][$rs[$i]["result"]]['bet_money']		= $rs[$i]["total_betting_money"];
				$list[$j][$rs[$i]["result"]]['bet_cnt']				= $rs[$i]["total_betting_cnt"];
				$list[$j][$rs[$i]["result"]]['win_money']		= $rs[$i]["total_win_money"];
				$list[$j][$rs[$i]["result"]]['win_cnt']				= $rs[$i]["total_win_cnt"];
				$list[$j]['total_bet_money']							+= $rs[$i]["total_betting_money"];
				$list[$j]['total_bet_cnt']								+= $rs[$i]["total_betting_cnt"];
			}
			else
			{
				$list[$j][$rs[$i]["result"]]['bet_money']		= $rs[$i]["total_betting_money"];
				$list[$j][$rs[$i]["result"]]['bet_cnt']				= $rs[$i]["total_betting_cnt"];
				$list[$j][$rs[$i]["result"]]['win_money']		= $rs[$i]["total_win_money"];
				$list[$j][$rs[$i]["result"]]['win_cnt']				= $rs[$i]["total_win_cnt"];
				$list[$j]['total_bet_money']							+= $rs[$i]["total_betting_money"];
				$list[$j]['total_bet_cnt']								+= $rs[$i]["total_betting_cnt"];
			}
			
			$totalList["total_bet_money"] += $rs[$i]["total_betting_money"];
			$totalList["total_bet_cnt"] += $rs[$i]["total_betting_cnt"];
			
			if($rs[$i]["result"]=='0')
			{
				$totalList["total_bet_money_0"] 	+= $rs[$i]["total_betting_money"];
				$totalList["total_bet_cnt_0"]		+= $rs[$i]["total_betting_cnt"];
			}
			if($rs[$i]["result"]=='1')
			{
				$totalList["total_win_money_1"] 	+= $rs[$i]["total_win_money"];
				$totalList["total_win_cnt_1"]		+= $rs[$i]["total_win_cnt"];
			}
			if($rs[$i]["result"]=='4')
			{
				$totalList["total_win_money_1"] 	+= $rs[$i]["total_betting_money"];
				$totalList["total_win_money_4"] 	+= $rs[$i]["total_betting_money"];
				$totalList["total_win_cnt_4"]		+= $rs[$i]["total_win_cnt"];
			}
		}

		$totalList["total_win_money"] = $totalList["total_bet_money"]-$totalList["total_win_money_1"]-$totalList["total_win_money_4"];
		


		$league_list = $league_model->getListAll();

		$this->view->assign('filter_logo', $filter_logo);
		$this->view->assign('filter_category', $filter_category);
		$this->view->assign('filter_league', $filter_league);
		$this->view->assign('league_list', $league_list);
		$this->view->assign('begin_date', $begin_date);
		$this->view->assign('end_date', $end_date);
		$this->view->assign('list', $list);
		$this->view->assign('totalList', $totalList);
		$this->display();
	}

    //▶ 베팅 상세 통계
    function bet_pop_detailAction()
    {
        $this->popupDefine();

        if(!$this->auth->isLogin())
        {
            $this->redirect("/login");
            exit;
        }
        $this->view->define("content","content/stat/popup.bet_detail.html");

        $model = $this->getModel("StatModel");
        $memModel = $this->getModel("MemberModel");


        $date = $this->request('date');
        $member_id = $this->request('member_id');

        if(!isset($member_id))
        {
            $member_id = '';
        }

        $rs = $model->getBetDetailList($date, $member_id);

        $list = array();
        $totalList = array();
        $total_bet_count = 0;
        $total_win_count = 0;
        $total_win_amt = 0;
        $total_bet_amt = 0;

        for($i=0; $i<count((array)$rs); ++$i)
        {
            $mem_id = $rs[$i]["uid"];
            $result = $rs[$i]["result"];
            /*$special = $rs[$i]["special"];      // 사다리, 다리, 달팽이, 파워볼
            $game_type = $rs[$i]["game_type"];  // 승무패, 핸디캡, 오버언더*/

            if(array_key_exists($mem_id, $list) === FALSE )
            {
                $list[$mem_id] = array("sn"=>$rs[$i]["member_sn"], "count"=>0, "success"=>0, "bet_amount"=>0, "get_amount"=>0);
            }

            if(array_key_exists($mem_id, $totalList) === FALSE )
            {
                $totalList[$mem_id] = array(
                    "S"=>array("count"=>0, "amt"=>0),
                    "D" =>array("count"=>0, "amt"=>0),
                    "P" =>array("count"=>0, "amt"=>0),
                    "B" =>array("count"=>0, "amt"=>0),
                    "G" =>array("count"=>0, "amt"=>0),
                    /*"1" =>array("count"=>0, "amt"=>0),
                    "2" =>array("count"=>0, "amt"=>0),
                    "4" =>array("count"=>0, "amt"=>0),*/
                );
            }

            $list[$mem_id]["count"]++;
            $list[$mem_id]["bet_amount"]+=$rs[$i]["betting_money"];
            $total_bet_count++;
            $total_bet_amt += $rs[$i]["betting_money"];

            if($result == "1")
            {
                $total_win_count++;
                $list[$mem_id]["success"]++;
                $list[$mem_id]["get_amount"]+= ($rs[$i]["betting_money"] * $rs[$i]["result_rate"]);
                $total_win_amt += ($rs[$i]["betting_money"] * $rs[$i]["result_rate"]);
            }

            if($result == "4")
            {
                $list[$mem_id]["get_amount"] += $rs[$i]["betting_money"];
                $total_win_amt += $rs[$i]["betting_money"];
            }

            if($rs[$i]["betting_cnt"] > 1) // 스포츠게임
            {
                $totalList[$mem_id]["G"]["count"]++;
                $totalList[$mem_id]["G"]["count"]+=$rs[$i]["betting_money"] * $rs[$i]["select_rate"];
            } else {
                $d_rs = $model->checkGameSpecialCode($rs[$i]["betting_no"]);
                if(isset($d_rs))
                {
                    $special = $d_rs[0]["special"];
                    if($special == "5") { // 사다리
                        $totalList[$mem_id]["S"]["count"]++;
                        $totalList[$mem_id]["S"]["count"]+=$rs[$i]["betting_money"] * $rs[$i]["result_rate"];
                    } else if($special == "6") { // 달팽이
                        $totalList[$mem_id]["P"]["count"]++;
                        $totalList[$mem_id]["P"]["count"]+=$rs[$i]["betting_money"] * $rs[$i]["result_rate"];
                    } else if($special == "7") { // 파워볼
                        $totalList[$mem_id]["B"]["count"]++;
                        $totalList[$mem_id]["B"]["count"]+=$rs[$i]["betting_money"] * $rs[$i]["result_rate"];
                    } else if($special == "8") { // 다리다리
                        $totalList[$mem_id]["D"]["count"]++;
                        $totalList[$mem_id]["D"]["count"]+=$rs[$i]["betting_money"] * $rs[$i]["result_rate"];
                    } else {
                        $totalList[$mem_id]["G"]["count"]++;
                        $totalList[$mem_id]["G"]["count"]+=$rs[$i]["betting_money"] * $rs[$i]["select_rate"];
                    }
                }
            }
            /*if($special == "5") { // 사다리
                $totalList[$mem_id]["S"]["count"]++;
                $totalList[$mem_id]["S"]["count"]+=$rs[$i]["betting_money"] * $rs[$i]["result_rate"];
            } else if($special == "6") { // 달팽이
                $totalList[$mem_id]["P"]["count"]++;
                $totalList[$mem_id]["P"]["count"]+=$rs[$i]["betting_money"] * $rs[$i]["result_rate"];
            } else if($special == "7") { // 파워볼
                $totalList[$mem_id]["B"]["count"]++;
                $totalList[$mem_id]["B"]["count"]+=$rs[$i]["betting_money"] * $rs[$i]["result_rate"];
            } else if($special == "8") { // 다리다리
                $totalList[$mem_id]["D"]["count"]++;
                $totalList[$mem_id]["D"]["count"]+=$rs[$i]["betting_money"] * $rs[$i]["result_rate"];
            } else {
                if($game_type == "1")
                {
                    $totalList[$mem_id]["1"]["count"]++;
                    $totalList[$mem_id]["1"]["count"]+=$rs[$i]["betting_money"] * $rs[$i]["select_rate"];
                } else if($game_type == "2") {
                    $totalList[$mem_id]["2"]["count"]++;
                    $totalList[$mem_id]["2"]["count"]+=$rs[$i]["betting_money"] * $rs[$i]["select_rate"];
                } else if($game_type == "4") {
                    $totalList[$mem_id]["4"]["count"]++;
                    $totalList[$mem_id]["4"]["count"]+=$rs[$i]["betting_money"] * $rs[$i]["select_rate"];
                }
            }*/
        }


        //$mem_list = $memModel->getMemberRows("uid");

        $this->view->assign('total_bet_count', $total_bet_count);
        $this->view->assign('total_win_count', $total_win_count);
        $this->view->assign('total_win_amt', $total_win_amt);
        $this->view->assign('total_bet_amt', $total_bet_amt);
        $this->view->assign('member_id', $member_id);
        $this->view->assign('date', $date);
        $this->view->assign('list', $list);
        $this->view->assign('totalList', $totalList);
        $this->display();
    }

	//▶ 팝업 머니내역
	function new_popup_moneyloglistAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/stat/popup.money_list.html");
		
		$model 	= $this->getModel("MoneyModel");

		$filterState 	= $this->request('filter_state');
		$beginDate = $endDate = $this->request('date');
		$filter_partner_sn =$this->request('filter_partner_sn');
		$flag =$this->request('flag');

		if($filter_partner_sn!='')	{$where.=" and b.recommend_sn='".$filter_partner_sn."'";}
		$where.=" and a.state=1";

		if ( $filterState == 1 ) {
			$list = $model->getMoneyChargeLog($where, '', '', '', $type, $beginDate, $endDate);
		} else {
			$list = $model->getMoneyExchangeLog($where, '', '', '', $type, $beginDate, $endDate);
		}

		$this->view->assign('date', $endDate);
		$this->view->assign('filter_state', $filterState);
		$this->view->assign('filter_partner_sn', $filter_partner_sn);
		$this->view->assign('list', $list);
		$this->view->assign('flag', $flag);
		
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
		$this->view->define("content","content/stat/popup.money_list.html");
		
		$model 	= $this->getModel("MoneyModel");

		$filterState 	= $this->request('filter_state');
		$beginDate = $endDate = $this->request('date');
		$filter_partner_sn =$this->request('filter_partner_sn');
		$flag =$this->request('flag');
		
		if ( $flag == 0 ) $where .= " and amount > 0";
		else $where .= " and amount < 0";

		if($filterState!='') {
			if ( $filterState == 2 ) {
				$where.=" and a.state=".$filterState." and a.status_message != '환전취소'";
			} else {
				$where.=" and a.state=".$filterState;
			}
		}
		if($filter_partner_sn!='')	{$where.=" and b.recommend_sn='".$filter_partner_sn."'";}
	
		$list = $model->getMoneyLogList($where, '', '', '', $type, $beginDate, $endDate);
		
		$this->view->assign('date', $endDate);
		$this->view->assign('filter_state', $filterState);
		$this->view->assign('filter_partner_sn', $filter_partner_sn);
		$this->view->assign('list', $list);
		$this->view->assign('flag', $flag);
		
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
		$this->view->define("content","content/stat/popup.mileage_list.html");
		
		$model 	= $this->getModel("MoneyModel");
		
		$filterState 	= $this->request('filter_state');
		$beginDate = $endDate = $this->request('date');
		$filter_partner_sn =$this->request('filter_partner_sn');
		$flag =$this->request('flag');
		
		if($filterState!='')			{$where.=" and a.state=".$filterState;}
		if($filter_partner_sn!='')	{$where.=" and b.recommend_sn='".$filter_partner_sn."'";}
	
		$list 			= $model->getMileageLogList($where, '', '', '', $type, $beginDate, $endDate);
		
		$this->view->assign('date', $endDate);
		$this->view->assign('filter_state', $filterState);
		$this->view->assign('filter_partner_sn', $filter_partner_sn);
		$this->view->assign('list', $list);
		$this->view->assign('flag', $flag);
		
		$this->display();
	}

    function member_settleAction()
    {
        $this->commonDefine();

        if(!$this->auth->isLogin())
        {
            $this->redirect("/login");
            exit;
        }
            $this->view->define("content","content/stat/member_settle.html");

        $perpage 					= $this->request('perpage');
        $beginDate  			= $this->request("begin_date");
        $endDate 					= $this->request("end_date");
        $field  = $this->request('field');
        $keyword 					= $this->request('keyword');

        $model = $this->getModel("StatModel");

        if($perpage=='') $perpage = 50;

        $where_mem = "";
        $where_date = "";
        $is_recommender = 0;

        if($keyword!="")
        {
            $field = $this->request("field");

            if($field=="uid")							{$where_mem.=" and uid like('%".$keyword."%')";}
            else if($field=="nick")				{$where_mem.=" and nick like('%".$keyword."%')";}
        }

        $page_act = "perpage=".$perpage."&keyword=".$keyword."&begin_date=".$beginDate."&end_date=".$endDate."&field=".$field;

        if ( !$beginDate ) $beginDate 	= date("Y-m-")."01";
        if ( !$endDate ) $endDate = date("Y-m-d",time());

        if ( $beginDate != "" ) $where_date.= " and c.operdate>='".$beginDate." 00:00:00'";
        if ( $endDate != "" ) $where_date.= " and c.operdate<='".$endDate." 23:59:59'";

        $total 				= $model->getSettleTotal($where_mem, $where_date, $is_recommender);
        $pageMaker		= $this->displayPage($total, $perpage, $page_act);
        $list 				= $model->getSettleList($where_mem, $where_date, $is_recommender, $pageMaker->first, $pageMaker->listNum);

        $this->view->assign('keyword', $keyword);
        $this->view->assign('field', $field);
        $this->view->assign('end_date', $endDate);
        $this->view->assign('begin_date', $beginDate);
        $this->view->assign('list', $list);

        $this->display();
    }

    function recommend_settleAction()
    {
        $this->commonDefine();

        if(!$this->auth->isLogin())
        {
            $this->redirect("/login");
            exit;
        }
        $this->view->define("content","content/stat/recommend_settle.html");

        $perpage 					= $this->request('perpage');
        $beginDate  			= $this->request("begin_date");
        $endDate 					= $this->request("end_date");
        $field  = $this->request('field');
        $keyword 					= $this->request('keyword');

        $model = $this->getModel("StatModel");

        if($perpage=='') $perpage = 50;

        $where_mem = "";
        $where_date = "";
        $is_recommender = 1;

        if($keyword!="")
        {
            $field = $this->request("field");

            if($field=="uid")							{$where_mem.=" and uid like('%".$keyword."%')";}
            else if($field=="nick")				{$where_mem.=" and nick like('%".$keyword."%')";}
        }

        $page_act = "perpage=".$perpage."&keyword=".$keyword."&begin_date=".$beginDate."&end_date=".$endDate."&field=".$field;

        if ( !$beginDate ) $beginDate 	= date("Y-m-")."01";
        if ( !$endDate ) $endDate = date("Y-m-d",time());

        if ( $beginDate != "" ) $where_date.= " and c.operdate>='".$beginDate." 00:00:00'";
        if ( $endDate != "" ) $where_date.= " and c.operdate<='".$endDate." 23:59:59'";

        $total 				= $model->getSettleTotal($where_mem, $where_date, $is_recommender);
        $pageMaker		= $this->displayPage($total, $perpage, $page_act);
        $list 				= $model->getSettleList($where_mem, $where_date, $is_recommender, $pageMaker->first, $pageMaker->listNum);

        $this->view->assign('keyword', $keyword);
        $this->view->assign('field', $field);
        $this->view->assign('end_date', $endDate);
        $this->view->assign('begin_date', $beginDate);
        $this->view->assign('list', $list);

        $this->display();
    }

    function dashboardAction () {
        $this->commonDefine();

        if(!$this->auth->isLogin())
        {
            $this->redirect("/login");
            exit;
        }
        $this->view->define("content","content/stat/dashboard.html");

        $model 	= $this->getModel("StatModel");
        $lModel 	= $this->getModel("LoginModel");
        $moneyModel 	= $this->getModel("MoneyModel");
        $gameListModel 	= $this->getModel("GameListModel");
        $memberModel 	= $this->getModel("MemberModel");

        $admin_sn = $this->auth->getSn();
        $admin_id = $this->auth->getId();

        // 관리자 로그인내역
        $where = " and admin_id='".$admin_id."'";
        $list 			= $lModel->getAdminLogList($where, 1, 1);
        $admin_login_ip = $list[0]['login_ip'];
        
        // 현재접속자수
        $current_user_list = $lModel->getSimultaneousList();

        $main_info = array();
        // 어제
        $beginDate = date("Y-m-d",strtotime("-1 days"))." 00:00:00";
        $endDate = date("Y-m-d",strtotime("-1 days"))."  23:59:59";

        $charge_info = $moneyModel->getChargeTotal2($beginDate, $endDate);
        $exchange_info = $moneyModel->getExchangeTotal2($beginDate, $endDate);
        $betting_info = $gameListModel->bettingListTotal2($beginDate, $endDate);
        $betting_cancel_info = $gameListModel->bettingCancelListTotal2($beginDate, $endDate);
        $new_user_info = $memberModel->getNewMemberCount($beginDate, $endDate);
        $visit_info = $memberModel->getVisitCount($beginDate, $endDate);

        $yesterday_info = array(
            'charge_info'=>$charge_info,
            'exchange_info'=>$exchange_info,
            'betting_info'=>$betting_info,
            'betting_cancel_info'=>$betting_cancel_info,
            'new_user_info'=>$new_user_info,
            'visit_info'=>$visit_info
        );

        // 이달
        $beginDate = date("Y-m",time())."-01 00:00:00";
        $endDate = date("Y-m-d",time())." 23:59:59";

        $charge_info = $moneyModel->getChargeTotal2($beginDate, $endDate);
        $exchange_info = $moneyModel->getExchangeTotal2($beginDate, $endDate);
        $betting_info = $gameListModel->bettingListTotal2($beginDate, $endDate);
        $betting_cancel_info = $gameListModel->bettingCancelListTotal2($beginDate, $endDate);
        $new_user_info = $memberModel->getNewMemberCount($beginDate, $endDate);
        $visit_info = $memberModel->getVisitCount($beginDate, $endDate);

        $month_info = array(
            'charge_info'=>$charge_info,
            'exchange_info'=>$exchange_info,
            'betting_info'=>$betting_info,
            'betting_cancel_info'=>$betting_cancel_info,
            'new_user_info'=>$new_user_info,
            'visit_info'=>$visit_info
        );

        // 오늘
        $beginDate = date("Y-m-d",time())." 00:00:00";
        $endDate = date("Y-m-d",time())." 23:59:59";

        // 충전수(충전자수)
        $charge_info = $moneyModel->getChargeTotal2($beginDate, $endDate);
        $exchange_info = $moneyModel->getExchangeTotal2($beginDate, $endDate);
        $betting_info = $gameListModel->bettingListTotal2($beginDate, $endDate);
        $betting_cancel_info = $gameListModel->bettingCancelListTotal2($beginDate, $endDate);
        $new_user_info = $memberModel->getNewMemberCount($beginDate, $endDate);
        $visit_info = $memberModel->getVisitCount($beginDate, $endDate);

        $today_info = array(
            'charge_info'=>$charge_info,
            'exchange_info'=>$exchange_info,
            'betting_info'=>$betting_info,
            'betting_cancel_info'=>$betting_cancel_info,
            'new_user_info'=>$new_user_info,
            'visit_info'=>$visit_info
        );

        $main_info = array(
            'today'=>$today_info,
            'yesterday'=>$yesterday_info,
            'month'=>$month_info
        );

        // 스포츠 배팅정보
        $sport_betting_info = array('multi'=>array(), 'special'=>array(), 'real'=>array(), 'live'=>array());
        $sport_betting_array = $gameListModel->bettingListOfSport($beginDate, $endDate);
        if($sport_betting_array != null)
        {
            foreach($sport_betting_array as $betting_info) {
                if($betting_info['special'] == 0)
                {
                    $sport_betting_info['multi'] = $betting_info;
                } else if($betting_info['special'] == 1) {
                    $sport_betting_info['special'] = $betting_info;
                } else if($betting_info['special'] == 2) {
                    $sport_betting_info['real'] = $betting_info;
                } else if($betting_info['special'] == 50) {
                    $sport_betting_info['live'] = $betting_info;
                }
            }
        }

        // 미니게임배팅정보
        $mini_betting_info = array();
        $mini_betting_array = $gameListModel->bettingListOfMini($beginDate, $endDate);
        if($mini_betting_array != null)
        {
            foreach($mini_betting_array as $betting_info) {
                $mini_betting_info[$betting_info['game_code']][$betting_info['select_no']] = $betting_info;
            }
        }

        $this->view->assign("admin_login_ip",  $admin_login_ip);
        $this->view->assign("current_user_list", $current_user_list);
        $this->view->assign("main_info",  $main_info);
        $this->view->assign("sport_betting_info",  $sport_betting_info);
        $this->view->assign("mini_betting_info",  $mini_betting_info);

        $this->display();
    }

    function refreshDashboardAction () {
        $this->commonDefine();

        if(!$this->auth->isLogin())
        {
            $this->redirect("/login");
            exit;
        }
        $model 	= $this->getModel("StatModel");
        $lModel 	= $this->getModel("LoginModel");
        $moneyModel 	= $this->getModel("MoneyModel");
        $gameListModel 	= $this->getModel("GameListModel");
        $memberModel 	= $this->getModel("MemberModel");

        $admin_sn = $this->auth->getSn();
        $admin_id = $this->auth->getId();

        // 관리자 로그인내역
        $where = " and admin_id='".$admin_id."'";
        $list 			= $lModel->getAdminLogList($where, 1, 1);
        $admin_login_ip = $list[0]['login_ip'];

        // 현재접속자수
        $current_user_list = $lModel->getSimultaneousList();

        $main_info = array();
        // 어제
        $beginDate = date("Y-m-d",strtotime("-1 days"))." 00:00:00";
        $endDate = date("Y-m-d",strtotime("-1 days"))."  23:59:59";

        $charge_info = $moneyModel->getChargeTotal2($beginDate, $endDate);
        $exchange_info = $moneyModel->getExchangeTotal2($beginDate, $endDate);
        $betting_info = $gameListModel->bettingListTotal2($beginDate, $endDate);
        $betting_cancel_info = $gameListModel->bettingCancelListTotal2($beginDate, $endDate);
        $new_user_info = $memberModel->getNewMemberCount($beginDate, $endDate);
        $visit_info = $memberModel->getVisitCount($beginDate, $endDate);

        $yesterday_info = array(
            'charge_info'=>$charge_info,
            'exchange_info'=>$exchange_info,
            'betting_info'=>$betting_info,
            'betting_cancel_info'=>$betting_cancel_info,
            'new_user_info'=>$new_user_info,
            'visit_info'=>$visit_info
        );

        // 이달
        $beginDate = date("Y-m",time())."-01 00:00:00";
        $endDate = date("Y-m-d",time())." 23:59:59";

        $charge_info = $moneyModel->getChargeTotal2($beginDate, $endDate);
        $exchange_info = $moneyModel->getExchangeTotal2($beginDate, $endDate);
        $betting_info = $gameListModel->bettingListTotal2($beginDate, $endDate);
        $betting_cancel_info = $gameListModel->bettingCancelListTotal2($beginDate, $endDate);
        $new_user_info = $memberModel->getNewMemberCount($beginDate, $endDate);
        $visit_info = $memberModel->getVisitCount($beginDate, $endDate);

        $month_info = array(
            'charge_info'=>$charge_info,
            'exchange_info'=>$exchange_info,
            'betting_info'=>$betting_info,
            'betting_cancel_info'=>$betting_cancel_info,
            'new_user_info'=>$new_user_info,
            'visit_info'=>$visit_info
        );

        // 오늘
        $beginDate = date("Y-m-d",time())." 00:00:00";
        $endDate = date("Y-m-d",time())." 23:59:59";

        // 충전수(충전자수)
        $charge_info = $moneyModel->getChargeTotal2($beginDate, $endDate);
        $exchange_info = $moneyModel->getExchangeTotal2($beginDate, $endDate);
        $betting_info = $gameListModel->bettingListTotal2($beginDate, $endDate);
        $betting_cancel_info = $gameListModel->bettingCancelListTotal2($beginDate, $endDate);
        $new_user_info = $memberModel->getNewMemberCount($beginDate, $endDate);
        $visit_info = $memberModel->getVisitCount($beginDate, $endDate);

        $today_info = array(
            'charge_info'=>$charge_info,
            'exchange_info'=>$exchange_info,
            'betting_info'=>$betting_info,
            'betting_cancel_info'=>$betting_cancel_info,
            'new_user_info'=>$new_user_info,
            'visit_info'=>$visit_info
        );

        $main_info = array(
            'today'=>$today_info,
            'yesterday'=>$yesterday_info,
            'month'=>$month_info
        );

        // 스포츠 배팅정보
        $sport_betting_info = array('multi'=>array(), 'special'=>array(), 'real'=>array(), 'live'=>array());
        $sport_betting_array = $gameListModel->bettingListOfSport($beginDate, $endDate);
        if($sport_betting_array != null)
        {
            foreach($sport_betting_array as $betting_info) {
                if($betting_info['special'] == 0)
                {
                    $sport_betting_info['multi'] = $betting_info;
                } else if($betting_info['special'] == 1) {
                    $sport_betting_info['special'] = $betting_info;
                } else if($betting_info['special'] == 2) {
                    $sport_betting_info['real'] = $betting_info;
                } else if($betting_info['special'] == 50) {
                    $sport_betting_info['live'] = $betting_info;
                }
            }
        }

        // 미니게임배팅정보
        $mini_betting_info = array();
        $mini_betting_array = $gameListModel->bettingListOfMini($beginDate, $endDate);
        /*if($mini_betting_array != null)
        {
            foreach($mini_betting_array as $betting_info) {
                $mini_betting_info[$betting_info['game_code']][$betting_info['select_no']] = $betting_info;
            }
        }*/

        $this->view->assign("admin_login_ip",  $admin_login_ip);
        $this->view->assign("current_user_list", $current_user_list);
        $this->view->assign("main_info",  $main_info);
        $this->view->assign("sport_betting_info",  $sport_betting_info);
        //$this->view->assign("mini_betting_info",  $mini_betting_info);

        $result = array(
            'admin_login_ip'=>$admin_login_ip,
            'current_user_list'=>$current_user_list,
            'main_info'=>$main_info,
            'sport_betting_info'=>$sport_betting_info,
            'mini_betting_info'=>$mini_betting_array
        );

        echo json_encode($result);
    }
}

?>