<?php 


class MemberController extends WebServiceController 
{
	//▶ 회원목록
	function listAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/member/list.html");
		
		$model 	= $this->getModel("PartnerModel");
		$eModel = $this->getModel("EtcModel");
		
		$sn 	= $this->auth->getSn();
		
		$field 		= $this->request("field");
		$keyword 	= trim($this->request("keyword"));
		
		if($keyword!="")
		{
			if($field=="uid")
			{
				$where=" and uid like '%".$keyword."%'";
			}
			else if($field=="nick")
			{
				$where=" and nick like '%".$keyword."%'";
			}
			else if($field=="bank_member")
			{
				$where=" and bank_member like '%".$keyword."%'";
			}
		}
		
		$rs = $eModel->getLevel();
		
		$arr_mem_lev = array();
		for( $i=0; $i < count((array)$rs); ++$i )
		{
			$level = $rs[$i]['lev'];
			$levelName = $rs[$i]['lev_name'];
			$arr_mem_lev[ $level ] = $levelName;
		}

		$total = $model->getPartnerInMemberTotal($sn, $where);
		$pageMaker = $this->displayPage($total, 10);
		$list = $model->getPartnerInMemberList($sn, $where, $pageMaker->first, $pageMaker->listNum);		
		
		$this->view->assign('arr_mem_lev', $arr_mem_lev);
		$this->view->assign("keyword",$keyword);
		$this->view->assign("field",$field);
		$this->view->assign("list",$list);
		
		$this->display();
	}
	
	//▶ 롤링회원목록
	function rolling_member_listAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/member/rolling_member_list.html");
		
		$model 		= $this->getModel("PartnerModel");
		$eModel 	= $this->getModel("EtcModel");
		$sn 			= $this->auth->getSn();
		$field 		= $this->request("field");
		$filterRollingSn = $this->request("filter_rolling_sn");
		
		$keyword = trim($this->request("keyword"));

		if($keyword!="")
		{
			if($field=="uid")
			{
				$where=" and uid like '%".$keyword."%'";
			}
			else if($field=="nick")
			{
				$where=" and nick like '%".$keyword."%'";
			}
			else if($field=="bank_member")
			{
				$where=" and bank_member like '%".$keyword."%'";
			}
		}
		
		if($filterRollingSn!="")
		{
			$total = $model->getRecommendMemberTotal(2, $filterRollingSn, $where);		
			$pageMaker = $this->displayPage($total, 10);
			$list = $model->getRecommendMemberList(2, $filterRollingSn, $where, $pageMaker->first, $pageMaker->listNum);		
		}
		else
		{
			$total = $model->getRecommendMemberTotal(1, $sn);
			$pageMaker = $this->displayPage($total, 10);
			$list = $model->getRecommendMemberList(1, $sn, $where, $pageMaker->first, $pageMaker->listNum);
		}
		
		$rs = $eModel->getLevel();
		$arr_mem_lev = array();
		
		for($i=0; $i<count((array)$rs); ++$i )
		{
			$level = $rs[$i]['lev'];
			$levelName = $rs[$i]['lev_name'];
			$arr_mem_lev[ $level ] = $levelName;
		}
		
		$selectRollingList = $model->getSelectorRollingList($sn);
		
		$this->view->assign('arr_mem_lev', $arr_mem_lev);
		$this->view->assign('select_rolling_list', $selectRollingList);
		$this->view->assign("keyword", $keyword);
		$this->view->assign("filter_rolling_sn", $filterRollingSn);
		$this->view->assign("field", $field);
		$this->view->assign("list", $list);
		
		$this->display();
	}
	
	//▶ 롤링 목록
	function rollinglistAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/member/rolling_list.html");
		
		$model = $this->getModel("PartnerModel");
		
		$sn				= $this->auth->getSn();
		$field 		= $this->request("field");
		$keyword 	= trim($this->request("keyword"));
		$act			= $this->request("act");
		
		if($keyword!="")
		{
			if($field=="uid")
			{
				$where=" and rec_id like '%".$keyword."%'";
			}
			else if($field=="name")
			{
				$where=" and rec_name like '%".$keyword."%'";
			}
			else if($field=="sn")
			{
				$where=" and Idx=".$keyword;
			}
		}
		
		if($act=="stop")
		{
			$partnerSn 	= $this->request('partner_sn');
			$state 			= $this->request('state');
			$model->modifyRecommend($partnerSn, $state);
		}
		if($act=="delete")
		{
			$partnerSn 	= $this->request('partner_sn');
			$rs = $model->delRecommend($partnerSn);
			if($rs > 0)
			{
				throw new Lemon_ScriptException("삭제 되였습니다.", "", "go", "/partner/list");
				exit;
			}
		}
		
		$page_act = "field=".$field."&keyword=".$keyword;
		
		$total 			= $model->getRollingTotal($sn, $where);		
		$pageMaker 	= $this->displayPage($total, 10, $page_act);
		$list 			= $model->getRollingList($sn, $where, $pageMaker->first, $pageMaker->listNum);		
				
		$this->view->assign("keyword", $keyword);
		$this->view->assign("field", $field);
		$this->view->assign("list",$list);
		
		$this->display();
	}
	
	//▶ 롤링 상세정보
	function rolling_detailAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/member/popup.rolling_detail.html");		
	
		$partnerModel = $this->getModel("PartnerModel");
		
		$rollingSn 	= $this->request('rolling_sn');
		$act 				= $this->request('act');
		
		if($act=="modify")
		{
			$memid 							= $this->request('memid');
			$urlidx 						= $this->request('urlidx');
			$pwd 								= $this->request('pwd');
			$memo 							= $this->request('memo');
			$rec_lev 						= $this->request('rec_lev');
			$rec_name 					= $this->request('rec_name');
			$rec_bankname 			= $this->request('rec_bankname');
			$rec_bankusername 	= $this->request('rec_bankusername');
			$rec_banknum 				= $this->request('rec_banknum');
			$rec_email 					= $this->request('rec_email');
			$rec_phone 					= $this->request('rec_phone');
			
			if( $pwd == "default" )
			{
				$pwd="";
				$where="";
			}
			else
			{
				$pwd=md5($pwd);
				$where="rec_psw='".$pwd."',";
			}
			$partnerModel->modifyMemberDetails($where, $memo, $rec_lev, $rec_name, $rec_bankname, $rec_bankusername, $rec_banknum, $rec_email, $rec_phone, $urlidx );
			throw new Lemon_ScriptException("", "", "script", "alert('수정 되었습니다.');opener.document.location.reload(); self.close();");
			exit;
		}
		
		$list = $partnerModel->getMemberDetails($rollingSn);
		
		$this->view->assign('list', $list);
		
		$this->display();
	}
	
	//▶ 파트너 메모추가
	function memoAdd_AccAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/member/memo_add_acc.html");		
	
		$model 	= $this->getModel("PartnerModel");
		$mModel = $this->getModel("MemoModel");
		
		$act = $this->request('act');
		if(isset($act) && $act=="add")
		{
			$title=trim($this->request('title'));
			$toid=$this->request('toid');
			$time=trim($this->request('time'));
			$content=trim($this->request('content'));
			$content=htmlspecialchars($content);
			
			$mModel->writePartnerMemo($toid, $title, $content);
			
			echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' ><script>alert('발송되었습니다.');window.close();</script>";
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=/partner/list'>";
			exit;
		}
	
		if($this->request('toid')!="")
		{
			$send = $this->request('toid');
		}
		else
		{
			throw new Lemon_ScriptException("잘못된 연결입니다!", "", "close");
			exit;
		}	
		
		$this->view->assign('send', $send);
		
		
		$this->display();
	}
	
	function popup_BetCategoryAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/member/popup.bet.category.html");
		
		$model = Lemon_Instance::getObject("CartModel",true);		
		
		$member_sn 	= $this->request("member_sn");
		$betting_no 	= $this->request("betting_no");
		$perpage		= $this->request("perpage");
		
		if($perpage=='') 		{$perpage = 10;}
		
		if($betting_no!="")
		{
			$where = " and betting_no='".$betting_no."'";
		}
		$page_act = "member_sn=".$member_sn."&betting_no=".$betting_no."&perpage=".$perpage;
		
		$total 		= $model->getMemberTotalCartCount($member_sn, '', '', $where);  // 전체 카트내역
		$pageMaker	= $this->displayPage($total, $perpage, $page_act);		
		$list = $model->getMemberBetList($member_sn, $pageMaker->first, $pageMaker->listNum, '', '', '', $where);
/*
echo "<pre>";
print_r($list);
echo "</pre>";
*/	
		$this->view->assign('perpage', $perpage);	
		$this->view->assign('member_sn', $member_sn);
		$this->view->assign('betting_no', $betting_no);
		$this->view->assign('list', $list);
		
		
		$this->display();
	}
	
	function popup_live_game_betting_listAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/member/popup_live_game_betting_list.html");
		
		$model = Lemon_Instance::getObject("CartModel",true);		
		
		$member_sn 	= $this->request("member_sn");
		$betting_no 	= $this->request("betting_no");
		$perpage		= $this->request("perpage");
		
		if($perpage=='') 		{$perpage = 10;}
		
		if($betting_no!="")
		{
			$where = " and betting_no='".$betting_no."'";
		}
		$page_act = "member_sn=".$member_sn."&betting_no=".$betting_no."&perpage=".$perpage;
		
		$total 		= $model->getLiveGameMemberBettingListTotal($member_sn, '', '', $where);  // 전체 카트내역
		$pageMaker	= $this->displayPage($total, $perpage, $page_act);		
		$list = $model->getLiveGameMemberBettingList($member_sn, $pageMaker->first, $pageMaker->listNum, '', '', '', $where);
		
		$this->view->assign('perpage', $perpage);	
		$this->view->assign('member_sn', $member_sn);
		$this->view->assign('betting_no', $betting_no);
		$this->view->assign('list', $list);
		
		
		$this->display();
	}
	
	//▶ 롤링 등록 팝업
	function popup_joinAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/member/popup.join_list.html");
		
		$partnerModel = $this->getModel("PartnerModel");
		
		$act	= $this->request('act');
		
		if($act=="add")
		{
			$sn			= $this->auth->getSn();
			$uid 		= $this->request('uid');
			$name 	= $this->request('name');
			$phone 	= $this->request('phone');
			$memo 	= $this->request('memo');
			$passwd	= $this->request('passwd');
			
			$partnerModel->addPartnerJoin($uid, $name, 2, $passwd, $phone, "", "", "", "", $sn);
			
			throw new Lemon_ScriptException("", "", "script", "alert('등록되었습니다.');opener.document.location.reload(); self.close();");						
			exit;
		}
		
		$this->display();
	}

	function partner_structAction()
    {
        $this->commonDefine();

        if(!$this->auth->isLogin())
        {
            $this->redirect("/login");
            exit;
        }
        $this->view->define("content","content/member/partner_struct.html");

        $model 		= $this->getModel("PartnerModel");

        $rec_id			= $this->auth->getId();
        $beginDate = $this->request('begin_date');
        $endDate = $this->request('end_date');

        $act = $this->request('act');

        if($beginDate=='' && $endDate=='')
        {
            $beginDate 	= date("Y-m-")."01";
            $endDate 		= date("Y-m-d", strtotime(' -1 day'));
        }

        if($act=="stop")
        {
            $id 		= $this->request('id');
            $status = $this->request('send');
            $model->modifyRecommend($id, $status);
        }
        if($act=="del")
        {
            $id 	= $this->request('id');
            $rs 	= $model->delRecommend($id);
            if( $rs > 0 )
            {
                throw new Lemon_ScriptException("삭제 되였습니다.", "", "go", "/partner/list");
                exit;
            }
        }

        $list 			= $model->getPartnerList2($rec_id, $beginDate, $endDate);

        $this->view->assign('list', $list);
        $this->view->assign('begin_date', $beginDate);
        $this->view->assign('end_date', $endDate);

        $this->display();
    }

    function popup_mem_listAction()
    {
        $this->popupDefine();

        if(!$this->auth->isLogin())
        {
            $this->redirect("/login");
            exit;
        }
        $this->view->define("content","content/member/popup.mem_list.html");

        $model 		= $this->getModel("PartnerModel");

        $rec_sn = $this->auth->getSn();
        //$rec_top_id = $this->request('rec_top_id');

        $list = array();

        if($rec_sn != null && $rec_sn != '')
        {
            $list = $model->getPartnerInMemberList($rec_sn);
        }

        $this->view->assign('list', $list);
        $this->display();
    }

    function popup_betAction()
    {
        $this->popupDefine();

        if(!$this->auth->isLogin())
        {
            $this->redirect("/login");
            exit;
        }
        $this->view->define("content","content/member/popup.bet_list.html");

        $model = $this->getModel("CartModel");

        $rec_sn = $this->auth->getSn();
        $is_sport = $this->request("is_sport");

        $betting_no 	= $this->request("betting_no");
        $selectKeyword		= $this->request("select_keyword");
        $keyword				= $this->request("keyword");
        $begin_date 			= $this->request("begin_date");
        $end_date 				= $this->request("end_date");
        $where = " ";
        if($betting_no!="")
        {
            $where = " and betting_no='".$betting_no."'";
        }

        if($keyword!="")
        {
            if($selectKeyword=="betting_no")		$where.=" and betting_no like('%".$keyword."%') ";
            else if($selectKeyword=="money_up")		$where.=" and betting_money > '".$keyword."' ";
            else if($selectKeyword=="money_down")		$where.=" and betting_money < '".$keyword."' ";
        }

        //$page_act = "mem_sn=".$mem_sn."&select_keyword=".$selectKeyword."&keyword=".$keyword."&begin_date=".$begin_date."&end_date=".$end_date;
        $page_act = "is_sport=".$is_sport."&select_keyword=".$selectKeyword."&keyword=".$keyword."&begin_date=".$begin_date."&end_date=".$end_date;

        $total = $model->getMemberTotalCartCntByPartner($rec_sn, '', $is_sport, $begin_date, $end_date, $where);  // 전체 카트내역
        $pageMaker	= $this->displayPage($total, 10, $page_act);
        $list = $model->getMemberBetListByPartner($rec_sn, '', $is_sport, $pageMaker->first, $pageMaker->listNum, $begin_date, $end_date, '', $where);


        $this->view->assign('betting_no', $betting_no);
        //$this->view->assign('rec_sn', $rec_sn);
        //$this->view->assign('rec_top_id', $rec_top_id);
        $this->view->assign('is_sport', $is_sport);
        $this->view->assign('list', $list);
        $this->view->assign("select_keyword",$selectKeyword);
        $this->view->assign("keyword",$keyword);
        $this->view->assign("begin_date",$begin_date);
        $this->view->assign("end_date",$end_date);
        $this->display();
    }
}

?>