<?php

class MemberController extends WebServiceController 
{
	function layoutDefine($type='')
	{
		//-> 중복로그인 체크 전체 페이지 적용
		if ( $this->auth->getSn() > 0 ) {
			$mModel = $this->getModel("MemberModel");
			$dbSessionId = $mModel->getMemberField($this->auth->getSn(), 'sessionid');
			if($dbSessionId!=session_id()) {
				if($this->auth->isLogin()) {
					session_destroy();
				}
				throw new Lemon_ScriptException("중복접속 되었습니다. 다시 로그인 해 주세요.", "", "go", "/");
				exit;
			}
		}

		$this->view->define("index","layout/layout.sports.html");

		$live_game_model = $this->getModel("LiveGameModel");		
		$gameList = $live_game_model->getLiveGameList($where);

		$this->view->assign("game_list",  $gameList);

		if($type=='member')
		{
			$this->view->define(array("content" => "content/charge.html", "quick" => "right/quick.html"));
		}
		else if($type=='join')
		{
			//$this->view->define("index","layout/layout.join.html");
			$this->view->define(array("content" => "content/join.html"));
		}	
	}
	
	function indexAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->redirect("/");
			exit;
		}
		
		$model = Lemon_Instance::getObject("MemberModel", true);
		
		$mode = $this->req->request('mode');
		$sn = $this->auth->getSn();
	
		if($mode=="modify")
		{
			$pass=$this->req->request('pass');
			$sms_safedomain	= 0;
			$sms_event			= 0;
			$sms_betting_ok	= 0;

			$dbPasswd = $model->getMemberField($sn,'upass');
			
			if(md5($pass)!=$dbPasswd)
			{
				throw new Lemon_ScriptException('비밀번호가 틀립니다.확인 하십시오.');				
			
				exit;
			}
			if($this->req->request('newpass')!="")
			{
				$newpass=$this->req->request('newpass');
				if($newpass!=$pass)
				{
					throw new Lemon_ScriptException('비밀번호 확인이 틀립니다.확인 하십시오.');								
					exit;
				}
			}
			$model->modifyMember($sn);
			
			throw new Lemon_ScriptException('수정 되였습니다.','','go','/member/');
			exit;
		}
		
		$rs = $model->getBySn($sn);
		
		$this->view->assign('member', $rs);
		
		$this->display();
	}
	
	//▶ 메모 목록
	function memolistAction()
	{
		$this->commonDefine('type');
		$this->view->define(array("content"=>"content/memo_list.html"));
	
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$memoModel = Lemon_Instance::getObject("MemoModel", true);
		$mode 	= $this->request('mode');
		
		$uid = $this->auth->getId();
		if($mode=="del")
		{
			$id = $this->req->request('id');	
			$rs = $memoModel->delMemoByMemberSn($id);			
			if($rs>0)
			{
				throw new Lemon_ScriptException("삭제 되였습니다",'','go','/member/memolist');				
				exit;
			}
			else
			{
				throw new Lemon_ScriptException("오류가 있습니다.");				
				exit;
			}
		}
		elseif($mode=="delete_all")
		{
			$rs = $memoModel->deleteAllMemo($uid);
			if($rs>0)
			{
				throw new Lemon_ScriptException("삭제 되였습니다",'','go','/member/memolist');				
				exit;
			}
			else
			{
				throw new Lemon_ScriptException("오류가 있습니다.");				
				exit;
			}
		}
			
		$total 			= $memoModel->getMemberMemoTotal($uid);
		$pageMaker 	= $this->displayPage($total,30);
		$list 			= $memoModel->getMemberMemoList($uid, $pageMaker->first, $pageMaker->listNum);

		$this->view->assign('list', $list);
		$this->display();
	}
	
	function readMemoCheckAction()
	{
		$idx = $this->req->request('idx');
		
		if( !$this->req->isNumberParameter($idx))
		{
			throw new Lemon_ScriptException("잘못된 접근입니다.");
			exit;
		}
		
		$memoModel = Lemon_Instance::getObject("MemoModel", true);
		$memoModel->modifyMemoRead($idx);
	}
	
	function readMemoAllAction() {
		$uid = $this->auth->getId();
		$memoModel = Lemon_Instance::getObject("MemoModel", true);
		$memoModel->readAllMemo($uid);
	}

	//▶ 보낸 메모함
	function memosendlistAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$mModel = Lemon_Instance::getObject("MemoModel", true);
		$mode 	= $this->req->request('mode');
		
		$uid = $this->auth->getId();
		
		if(isset($mode) && $mode=="del")
		{
			$id = $this->req->request('id');	
			
			$rs = $mModel->delMemoByMemberSn($id);			
			if($rs>0)
			{
				throw new Lemon_ScriptException("삭제되었습니다",'','go','/member/memosendlist');				
				exit;
			}
			else
			{
				throw new Lemon_ScriptException("오류가 있습니다.");				
				exit;
			}
			
		}
	
		$where = " isdelete=0 ";
		$total 		= $mModel->getFromMemoTotal($uid, $where);
		$pageMaker 	= $this->displayPage($total, 30);
		$list 		= $mModel->getFromMemoList($uid, $where, $pageMaker->first, $pageMaker->listNum);
	
		$this->view->assign('list', $list);
		
		$this->display();
	}
	
	//▶ 계좌 메모 
	function sendAccountMemoProcessAction()
	{
		$memoModel 		= $this->getModel("MemoModel");
		$configModel 	= $this->getModel("ConfigModel");
		
		$toid = $this->auth->getId();
		$level = $this->auth->getLevel();
		$item = $configModel->getLevelConfigRow($level);
		$subject = "계좌 정보입니다.";
		$content = "[".$item['lev_bank']."] ".$item['lev_bank_account']." 예금주: ".$item['lev_bank_owner'];
		$memoModel->writeMemo('운영팀', $toid, $subject, $content);
		
		throw new Lemon_ScriptException("쪽지가 발송되었습니다.", "", "go", "/member/charge");
	}
	
	//▶ 쪽지 쓰기
	function memowriteAction()
	{
		$this->commonDefine('memowrite');
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$mModel = Lemon_Instance::getObject("MemoModel", true);
		$cModel = Lemon_Instance::getObject("ConfigModel", true);
		$mode 	= $this->req->request('mode');
		
		$uid = $this->auth->getId();
		
		if(isset($mode) && $mode=="send")
		{
			$maxContentLen 	= $cModel->getAdminConfigField('memo_content_len');
			$maxTitleLen 	= $cModel->getAdminConfigField('memo_title_len');
			
			$title		= trim($this->request("title"));
			$content	= trim($this->request("content"));
			$toid		= trim($this->request("toid"));
			
			if(mb_strlen($content,'utf-8') > $maxContentLen)
			{
				$msg = "쪽지글 - ".$maxContentLen."자를 초과할 수 없습니다.";
				throw new Lemon_ScriptException($msg);
				
				exit;
			}
			
			$content=htmlspecialchars($content);
			
			$rs = $mModel->writeMemo($uid, $toid, $title, $content);
			
			if($rs>0)
			{
				throw new Lemon_ScriptException("쪽지가 발송되었습니다.", "", "go", "/member/memosendlist");
				
				exit;
			}
			else
			{
				throw new Lemon_ScriptException("쪽지 발송에 실패하였습니다.");				
				exit;
			}
		}
		
		$this->display();
	}
	
	function memoviewAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$model = Lemon_Instance::getObject("MemoModel", true);
		
		$article = $this->req->request('article');
		
		if( !$this->req->isNumberParameter($article))
		{
			throw new Lemon_ScriptException("잘못된 접근입니다.");
			exit;
		}
		
		$model->modifyMemoRead($article);
		$item = $model->getMemberMemo($article);	
		
		$this->view->assign('item', $item);
		
		$this->display();
	}
	
	function index_memo_checkProcessAction()
	{
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$memoModel = Lemon_Instance::getObject("MemoModel", true);
		$memoSn = $this->req->request('memo_sn');
		
		if( !$this->req->isNumberParameter($memoSn))
		{
			throw new Lemon_ScriptException("잘못된 접근입니다.");
			exit;
		}
		
		$memoModel->modifyMemoRead($memoSn);
		
		echo "<script>history.back();</script>";
		
		//throw new Lemon_ScriptException("두번의 비밀번호가 틀립니다.","","back");
		
		$this->display();
	}

	function mileageAction()
	{
		$this->commonDefine('join');
		$this->view->define(array("content"=>"content/mileage.html"));
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$type 	= $this->req->request('type');
		$sn 	= $this->auth->getSn();
		
		if( !$this->req->isNumberParameter($type))
		{
			throw new Lemon_ScriptException("잘못된 접근입니다.");
			exit;
		}

		$model 	= Lemon_Instance::getObject("MemberModel", true);
		$mModel = Lemon_Instance::getObject("MoneyModel", true);
		
		$mileage = $model->getMemberField($sn,'point');
		
		$page_act = "type=$type";
		$total 			= $mModel->getMileageTotal($sn, $type);
		$pageMaker 	= $this->displayPage($total, 30, $page_act);
		$list 			= $mModel->getMileageList($sn, $pageMaker->first, $pageMaker->listNum, $type);	

		$this->view->assign('mileage', $mileage);
		$this->view->assign('list', $list);
		
		$this->display();
	}
	
	function mileagelistAction()
	{
		$this->commonDefine('type');
	
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$type 	= $this->req->request('type');
		$begin_date 	= $this->req->request('begin_date');
		$end_date 	= $this->req->request('end_date');
		
		if( !$this->req->isNumberParameter($type))
		{
			throw new Lemon_ScriptException("잘못된 접근입니다.");
			exit;
		}
		
		$sn 	= $this->auth->getSn();

		$model 	= Lemon_Instance::getObject("MemberModel", true);
		$mModel = Lemon_Instance::getObject("MoneyModel", true);
		
		$mileage = $model->getMemberField($sn,'point');
		
		$page_act = "type=$type&begin_date=".$begin_date."&end_date=".$end_date;;
		$total 			= $mModel->getMileageTotal($sn, $type, $begin_date, $end_date);
		$pageMaker 	= $this->displayPage($total, 30, $page_act);
		$list 			= $mModel->getMileageList($sn, $pageMaker->first, $pageMaker->listNum, $type, $begin_date, $end_date);	

		$this->view->define(array("content"=>"content/mileage_list.html"));
		$this->view->assign('begin_date', $begin_date);
		$this->view->assign('end_date', $end_date);
		$this->view->assign('mileage', $mileage);
		$this->view->assign('list', $list);
		
		$this->display();
	}

	function chargeAction()
	{
		$this->commonDefine('type');		
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$level	= $this->auth->getLevel();
		$sn 		= $this->auth->getSn();
		
		$configModel 	= $this->getModel("ConfigModel");
		$memberModel 	= $this->getModel("MemberModel");
		
		$rs = $configModel->getLevelConfigRow($level);
		$minCharge = $rs['lev_bank_min_charge'];
		
		$cash  	= $memberModel->getMemberField($sn, 'g_money');
		$rs 		= $memberModel->getMemberRow($sn, 'g_money, bank_member');

		$this->view->define(array("content"=>"content/charge.html"));
		$this->view->assign('min_charge', $minCharge);
		$this->view->assign('cash', $cash);
		$this->view->assign('member', $rs);

        $memberModel 	= Lemon_Instance::getObject("MemberModel", true);
        $moneyModel = Lemon_Instance::getObject("MoneyModel", true);

        $page 			= !($this->request('page'))?'1':intval($this->req->request('page'));
        $beginDate 	= $this->request('begin_date');
        $endDate 		= $this->request('end_date');
        $sortType 	= $this->request("sort_type");
        $chargeSn 	= $this->request("charge_sn");

        if( !$this->req->isNumberParameter($chargeSn))
        {
            throw new Lemon_ScriptException("잘못된 접근입니다.");
            exit;
        }

        if($beginDate!="" && $endDate!="")
        {
            $where=" and a.regdate between '".$beginDate." 00:00:00' and '".$endDate." 23:59:59'";
        }

        //완료
        if($sortType == 1) {$where = $where." and a.state = 0";}
        //처리중
        else if($sortType == 2 ){$where = $where." and a.state = 1";}

        if($chargeSn!="")
        {
            $rs = $moneyModel->modifyHide("charge", $chargeSn);
            if($rs > 0)
            {
                throw new Lemon_ScriptException("삭제 되였습니다");
            }
            else
            {
                throw new Lemon_ScriptException("오류가 있습니다.");
            }
        }

        $where.=" and is_hidden=0 ";
        $total = $moneyModel->getMemberChargeTotal($this->auth->getSn(), "", $where);

        $pageMaker = Lemon_Instance::getObject("Lemon_Page");
        $pageMaker->setListNum(10);
        $pageMaker->setPageNum(10);
        $pageMaker->setPage($page, $total);
        $pagelist = $pageMaker->pageList("&begin_date=".$beginDate."&end_date=".$endDate."&sorttype=".$sortType);

        $list  = $moneyModel->getMemberChargeList($this->auth->getSn(), "", $where, $pageMaker->first, $pageMaker->listNum);
        $cash  = $memberModel->getMemberField($this->auth->getSn(), 'g_money');

        $this->view->assign('sort_type', $sortType);
        $this->view->assign('cash', $cash);
        $this->view->assign('begin_date', $beginDate);
        $this->view->assign('end_date', $endDate);
        $this->view->assign('list', $list);
        $this->view->assign('pagelist', $pagelist);

		$this->display();
	}

    function chargelistAction()
    {
        $this->commonDefine('type');
        $this->view->define(array("content"=>"content/charge_list.html"));

        $this->req->xssClean();
        if ( !$this->auth->isLogin() ) {
            $this->loginAction();
            exit;
        }

        $memberModel 	= Lemon_Instance::getObject("MemberModel", true);
        $moneyModel = Lemon_Instance::getObject("MoneyModel", true);

        $page 			= !($this->request('page'))?'1':intval($this->req->request('page'));
        $beginDate 	= $this->request('begin_date');
        $endDate 		= $this->request('end_date');
        $sortType 	= $this->request("sort_type");
        $chargeSn 	= $this->request("charge_sn");

        if( !$this->req->isNumberParameter($chargeSn))
        {
            throw new Lemon_ScriptException("잘못된 접근입니다.");
            exit;
        }

        if($beginDate!="" && $endDate!="")
        {
            $where=" and a.regdate between '".$beginDate." 00:00:00' and '".$endDate." 23:59:59'";
        }

        //완료
        if($sortType == 1) {$where = $where." and a.state = 0";}
        //처리중
        else if($sortType == 2 ){$where = $where." and a.state = 1";}

        if($chargeSn!="")
        {
            $rs = $moneyModel->modifyHide("charge", $chargeSn);
            if($rs > 0)
            {
                throw new Lemon_ScriptException("삭제 되였습니다");
            }
            else
            {
                throw new Lemon_ScriptException("오류가 있습니다.");
            }
        }

        $where.=" and is_hidden=0 ";
        $total = $moneyModel->getMemberChargeTotal($this->auth->getSn(), "", $where);

        $pageMaker = Lemon_Instance::getObject("Lemon_Page");
        $pageMaker->setListNum(10);
        $pageMaker->setPageNum(10);
        $pageMaker->setPage($page, $total);
        $pagelist = $pageMaker->pageList("mode=".$mode."&begin_date=".$beginDate."&end_date=".$endDate."&sorttype=".$sortType);

        $list  = $moneyModel->getMemberChargeList($this->auth->getSn(), "", $where, $pageMaker->first, $pageMaker->listNum);
        $cash  = $memberModel->getMemberField($this->auth->getSn(), 'g_money');

        $this->view->assign('sort_type', $sortType);
        $this->view->assign('cash', $cash);
        $this->view->assign('begin_date', $beginDate);
        $this->view->assign('end_date', $endDate);
        $this->view->assign('list', $list);
        $this->view->assign('pagelist', $pagelist);

        $this->display();
    }

	function chargeProcessAction()
	{
		$model 	= Lemon_Instance::getObject("MemberModel",true);
		$pModel = Lemon_Instance::getObject("ProcessModel",true);
		
		$amount = $this->req->post('money');
		$amount	= str_replace(",","",$amount);
		
		if($amount<10000)
		{
			$this->redirect("/member/charge");
			exit;
		}
		if("G"==$model->getMemberField($this->auth->getSn(), 'mem_status'))
		{
			throw new Lemon_ScriptException("테스트 회원은 충전이 불가합니다.");
			$this->redirect("/member/charge");
			exit;
		}

		$rs = $pModel->chargeReqProcess($this->auth->getSn(), $amount);
	
		if($rs>0)
		{
			throw new Lemon_ScriptException("충전신청이 완료되었습니다.");				
			
			$this->redirect("/member/charge");
			exit;
		}
		else
		{
			throw new Lemon_ScriptException("충전신청이 취소되었습니다.");				
			exit;
		}
	}
	
	function charge_howtoAction()
	{
		$this->commonDefine();
		$this->view->define(array("content"=>"content/charge_howto.html"));
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$this->display();
	}
	
	
	function exchangelistAction()
	{
		$this->commonDefine('type');
		$this->view->define(array("content"=>"content/exchange_list.html"));
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$memberModel 	= Lemon_Instance::getObject("MemberModel", true);
		$moneyModel = Lemon_Instance::getObject("MoneyModel", true);
		
		$page 			= !($this->req->request('page'))?'1':intval($this->req->request('page'));
		$beginDate 	= $this->request('begin_date');
		$endDate 		= $this->request('end_date');
		$sortType 	= $this->request("sort_type");
		$exchangeSn = $this->request("exchange_sn");
		
		if( !$this->req->isNumberParameter($exchangeSn))
		{
			throw new Lemon_ScriptException("잘못된 접근입니다.");
			exit;
		}
		
		if($beginDate!="" && $endDate!="")
				$where=" and a.regdate between '".$beginDate." 00:00:00' and '".$endDate." 23:59:59'";
		
		//완료
		if($sortType=="1") 
			$where = $where." and a.state=1";
		//처리중
		else if($sortType==="0" )
			$where = $where." and a.state=0";
			
		if($exchangeSn!="")
		{
			$rs = $moneyModel->modifyHide("exchange", $exchangeSn);
			if($rs > 0)
			{
				throw new Lemon_ScriptException("삭제 되였습니다");
			}
			else
			{
				throw new Lemon_ScriptException("오류가 있습니다.");
			}
		}
		
		$where.=" and is_hidden=0 ";
		$total = $moneyModel->getMemberExchangeTotal($this->auth->getSn(), "", $where);
		$pageMaker = Lemon_Instance::getObject("Lemon_Page");
		$pageMaker->setListNum(10);
		$pageMaker->setPageNum(10);
		$pageMaker->setPage($page, $total);
		$pagelist = $pageMaker->pageList("mode=".$mode."&begin_date=".$beginDate."&end_date=".$endDate."&sort_type=".$sortType);
		$list 		= $moneyModel->getMemberExchangeList($this->auth->getSn(), "", $where, $pageMaker->first, $pageMaker->listNum);
		
		$cash  	= $memberModel->getMemberField($this->auth->getSn(),'g_money');
		
		$this->view->assign('sort_type', $sortType);
		$this->view->assign('cash', $cash);
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('list', $list);
		$this->view->assign('pagelist', $pagelist);
		
		$this->display();
	}
	
	function exchangeAction()
	{
		$this->commonDefine('type');
	
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}

		$configModel 	= $this->getModel("ConfigModel");
		$memberModel 	= $this->getModel("MemberModel");
		
		$level	= $this->auth->getLevel();
		$rs = $configModel->getLevelConfigRow($level);
		$minExchangeMoney = $rs['lev_bank_min_exchange'];
		
		$sn = $this->auth->getSn();
		$cash = $memberModel->getMemberField($sn,'g_money');
		$rs = $memberModel->getMemberRow($sn, 'g_money, bank_name, bank_account, bank_member, phone');

		$this->view->define(array("content"=>"content/exchange.html"));
		$this->view->assign('exchange_name', $this->auth->getName());
		$this->view->assign('min_exchange', $minExchangeMoney);
		$this->view->assign('cash', $cash);
		$this->view->assign('member', $rs);

        $memberModel 	= Lemon_Instance::getObject("MemberModel", true);
        $moneyModel = Lemon_Instance::getObject("MoneyModel", true);

        $page 			= !($this->req->request('page'))?'1':intval($this->req->request('page'));
        $beginDate 	= $this->request('begin_date');
        $endDate 		= $this->request('end_date');
        $sortType 	= $this->request("sort_type");
        $exchangeSn = $this->request("exchange_sn");

        if( !$this->req->isNumberParameter($exchangeSn))
        {
            throw new Lemon_ScriptException("잘못된 접근입니다.");
            exit;
        }

        if($beginDate!="" && $endDate!="")
            $where=" and a.regdate between '".$beginDate." 00:00:00' and '".$endDate." 23:59:59'";

        //완료
        if($sortType=="1")
            $where = $where." and a.state=1";
        //처리중
        else if($sortType==="0" )
            $where = $where." and a.state=0";

        if($exchangeSn!="")
        {
            $rs = $moneyModel->modifyHide("exchange", $exchangeSn);
            if($rs > 0)
            {
                throw new Lemon_ScriptException("삭제 되였습니다");
            }
            else
            {
                throw new Lemon_ScriptException("오류가 있습니다.");
            }
        }

        $where.=" and is_hidden=0 ";
        $total = $moneyModel->getMemberExchangeTotal($this->auth->getSn(), "", $where);
        $pageMaker = Lemon_Instance::getObject("Lemon_Page");
        $pageMaker->setListNum(10);
        $pageMaker->setPageNum(10);
        $pageMaker->setPage($page, $total);
        $pagelist = $pageMaker->pageList("mode=".$mode."&begin_date=".$beginDate."&end_date=".$endDate."&sort_type=".$sortType);
        $list 		= $moneyModel->getMemberExchangeList($this->auth->getSn(), "", $where, $pageMaker->first, $pageMaker->listNum);

        $cash  	= $memberModel->getMemberField($this->auth->getSn(),'g_money');

        $this->view->assign('sort_type', $sortType);
        $this->view->assign('cash', $cash);
        $this->view->assign('begin_date', $beginDate);
        $this->view->assign('end_date', $endDate);
        $this->view->assign('list', $list);
        $this->view->assign('pagelist', $pagelist);

		$this->display();
	}
	
	function exchangeProcessAction()
	{
		$this->req->xssClean();
		
		$model 	= Lemon_Instance::getObject("MemberModel",true);
		$mModel = Lemon_Instance::getObject("MoneyModel",true);
		$pModel = Lemon_Instance::getObject("ProcessModel",true);
		
		$amount = $this->req->post('amount');
		$amount	= str_replace(",","",$amount);
		$exchangePass = $this->req->post('exchange_pass');

		//-> 출금비번은 받지 않아서 DB에 값을 가져온다.20170525....
		$db_exchangePass = $model->getMemberField($this->auth->getSn(), "exchange_pass");
	
		$uid = $this->auth->getId();

		if($amount==0)
		{
			$this->redirect("/member/exchange");
			exit;
		}

        if($exchangePass=='')
        {
            throw new Lemon_ScriptException("출금 비밀번호를 입력하세요.");
            $this->redirect("/member/exchange");
            exit;
        }

		if("G"==$model->getMemberField($this->auth->getSn(), 'mem_status'))
		{
			throw new Lemon_ScriptException("테스트 회원은 환전이 불가합니다.");
			$this->redirect("/member/exchange");
			exit;
		}
		
		$rs = $pModel->exchangeReqProcess($this->auth->getSn(), $amount, $exchangePass);		
		if($rs>0)
		{
			throw new Lemon_ScriptException("환전신청이 완료되었습니다.");
			$this->redirect("/member/exchange");
			exit;
		}
		else if($rs==-1)
		{
			throw new Lemon_ScriptException("출금 비밀번호가 틀렸습니다."); //-> $pModel->exchangeReqProcess 출금비번확인 뺐음.
			exit;
		}
		else if($rs==-2)
		{
			throw new Lemon_ScriptException("신청 금액에 문제가 있습니다. 관리자에게 연락하십시오.");
			exit;
		}
		else if($rs==-3)
		{
			throw new Lemon_ScriptException("소유하신 금액 이상을 요청하셨습니다. 관리자에게 연락하십시오.");
			exit;
		}
	}
	
	function exchange_howtoAction()
	{
		$this->commonDefine();
		$this->view->define(array("content"=>"content/exchange_howto.html"));
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$this->display();
	}
	
	function addAction()
	{
        $loginModel = Lemon_Instance::getObject("LoginModel",true);

        if ( strlen(trim($_SERVER["HTTP_INCAP_CLIENT_IP"])) > 0 and strlen(trim($_SERVER["HTTP_INCAP_CLIENT_IP"])) < 16 ) {
            $remoteip = $_SERVER["HTTP_INCAP_CLIENT_IP"];
        } else if ( strlen(trim($_SERVER["HTTP_X_FORWARDED_FOR"])) > 0 and strlen(trim($_SERVER["HTTP_X_FORWARDED_FOR"])) < 16 ) {
            $remoteip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if ( strlen(trim($_SERVER["HTTP_X_REAL_IP"])) > 0 and strlen(trim($_SERVER["HTTP_X_REAL_IP"])) < 16 ) {
            $remoteip = $_SERVER["HTTP_X_REAL_IP"];
        } else {
            $remoteip = $_SERVER["REMOTE_ADDR"];
        }

        if ( $loginModel->isValidIP($remoteip) === false )
        {
            throw new Lemon_ScriptException("접근금지 아이피입니다. 관리자에게 문의 하십시요.");
        }

		if ( !$_SESSION['partnerSn'] and !$_SESSION['recommendUid'] ) {
			throw new Lemon_ScriptException("Pin-Code정보가 필요합니다.");		
			exit;
		}

		//$this->iframeDefine('add',false);
		$this->commonDefine('type');
		$this->view->define(array("content"=>"content/join.html"));

		$_SESSION["recode"] = mt_rand(0,10000);

		$cModel = Lemon_Instance::getObject("ConfigModel",true);
		$site_info = $cModel->getAdminConfig();

		$this->view->assign('member_join_chu', $site_info["member_join_chu"]);
		$this->view->assign('partnerSn', $_SESSION["partnerSn"]);
		$this->view->assign('recommendUid', $_SESSION["recommendUid"]);
		$this->display();
	}
	
	//-> 포인트 전환.
	function toCashProcessAction() {
		$this->req->xssClean();
		
		if ( !$this->auth->isLogin() ) {
			$this->loginAction();
			exit;
		}

		//$exPoint = $this->req->post('point');
		
		$sn = $this->auth->getSn();
		$userid = $this->auth->getId();
		
		$memberModel 	= $this->getModel('MemberModel');
		$moneyModel = $this->getModel('MoneyModel');

		$userPoint = $memberModel->getMemberRow($sn, "point");
		$userPoint = $userPoint["point"];
		
		if ( $userPoint > 0 ) {
			$moneyModel->ajaxMileage2Cash($sn, $userPoint);
			echo(json_encode(array("result"=>"ok")));
		} else {
			echo(json_encode(array("result"=>"error")));
		}
	}
	
	function toMileageProcessAction()
	{
		$this->req->xssClean();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$amount = $this->req->post('amount');
		$sn = $this->auth->getSn();
		
		$moneyModel = $this->getModel('MoneyModel');
		$moneyModel->ajaxCash2Mileage($sn, $amount);
	}
	
	function addProcessAction() {
		$ajaxResult = array();
		$ajaxResult["result"]	= "error";

        if ( strlen(trim($_SERVER["HTTP_INCAP_CLIENT_IP"])) > 0 and strlen(trim($_SERVER["HTTP_INCAP_CLIENT_IP"])) < 16 ) {
            $remoteip = $_SERVER["HTTP_INCAP_CLIENT_IP"];
        } else if ( strlen(trim($_SERVER["HTTP_X_FORWARDED_FOR"])) > 0 and strlen(trim($_SERVER["HTTP_X_FORWARDED_FOR"])) < 16 ) {
            $remoteip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if ( strlen(trim($_SERVER["HTTP_X_REAL_IP"])) > 0 and strlen(trim($_SERVER["HTTP_X_REAL_IP"])) < 16 ) {
            $remoteip = $_SERVER["HTTP_X_REAL_IP"];
        } else {
            $remoteip = $_SERVER["REMOTE_ADDR"];
        }

		$this->req->xssClean();

		$uid	 									= trim($this->req->post("uid"));
		$upass 									= trim($this->req->post("upass"));
		$birthday								= trim($this->req->post("birth"));
		$confirm_upass					= trim($this->req->post("confirm_upass"));
		$nick 	 								= trim($this->req->post("nick"));
		$phone 		 							= trim($this->req->post("phone"));
		$bank_name 	 						= Trim($this->req->post("bank_name"));
		$bank_account 					= Trim($this->req->post("bank_account"));
		$bank_member 						= Trim($this->req->post("bank_member"));
		$exchange_pass 					= trim($this->req->post("exchange_pass"));
		$confirm_exchange_pass	= trim($this->req->post("confirm_exchange_pass"));
		$partnerSn							= Trim($this->req->post("partnerSn"));
		$recommendUid						= Trim($this->req->post("recommendUid"));
		$recode									= Trim($this->req->post("recode"));
		$ip 										= $remoteip;

		$model   			= Lemon_Instance::getObject("MemberModel",true);
		$eModel  			= Lemon_Instance::getObject("EtcModel",true);
		$cModel  			= Lemon_Instance::getObject("ConfigModel",true);
		$memoModel 		= Lemon_Instance::getObject("MemoModel",true);
		$pModel 			= Lemon_Instance::getObject("PartnerModel",true);
		$configModel 	= Lemon_Instance::getObject("ConfigModel",true);

		$rs = $model->getById($uid);
		if ( count((array)$rs) > 0 ) {
			echo json_encode(array("error_msg"=>$uid."는 이미 가입된 아이디 입니다. 다시한번 확인 부탁 드립니다."));
			exit;
		}

		if ( isset($recode) ) {
			if ( $recode != $_SESSION["recode"] ) {
				echo json_encode(array("error_msg"=>"중복된 등록입니다."));
				exit;
			}
		}

		if ( $uid == "" || $upass == "" || $nick == "" || $phone == "" || $bank_name == "" || $bank_account == "" || $bank_member == "" ) {
			echo json_encode(array("error_msg"=>"정보입력을 확인해 주세요."));
			exit;
		}

		if ( $upass != $confirm_upass ) {
			echo json_encode(array("error_msg"=>"비밀번호 확인이 틀립니다."));
			exit;
		}

		$dbRegdate = $model->getMemberRowById($uid,'regdate');
		$xtime = $this->diffdate($dbRegdate);
		if ( $xtime < 3 ) {
			echo json_encode(array("error_msg"=>"회원가입이 너무 빈번합니다.잠시뒤에 다시 시도하여주십시오."));
			exit;
		}

		if( strlen(trim($recommendUid)) > 0 ) {
			$rs = $model->getById($recommendUid);
			if ( count((array)$rs) > 0 ) {
				$recommendCount = $pModel->getJoinRecommendCount($rs['sn']);
				$recommendLevel = $rs['mem_lev'];
				$joinRecommendSn = $rs['sn'];
				$partnerSn = $rs['recommend_sn'];

				//->추천인 수 제한
				$item = $configModel->getLevelConfigRow($recommendLevel);
				if ( $recommendCount >= $item['lev_recommend_limit'] ) {
					echo json_encode(array("error_msg"=>"추천인이 더이상 추천을 받을 수 없습니다."));
					exit;
				}
			} else {
				echo json_encode(array("error_msg"=>"추천인을 다시한번 확인 해 주세요"));
				exit;
			}
		} else {
			$joinRecommendSn = 0;
		}

		if ( !trim($joinRecommendSn) and !trim($partnerSn) ) {
			echo json_encode(array("error_msg"=>"추천인이 없거나 인증코드에 오류가 있습니다."));
			exit;
		}

		$freeMoney = $cModel->getJoinFreeMoney();	  

		$rs = $model->joinAdd($uid, $upass, $exchange_pass, $nick, $bank_member, $phone, $freeMoney, "W", $joinRecommendSn, $partnerSn, $bank_name, $bank_account, $bank_member, $ip, "", $birthday);
		if ( $rs > 0 ) {
			$configModel->modifyAlramFlag("new_member", 1);
			$welcomeMemoTitle 	= addslashes($cModel->getAdminConfigField('wel_memo_title'));
			$welcomeMemoContent = addslashes($cModel->getAdminConfigField('wel_memo_content'));
			
			$memoModel->writeMemo('운영팀', $uid, $welcomeMemoTitle, $welcomeMemoContent);

			unset($_SESSION["reg_code"]);
			unset($_SESSION["reg_ck"]);
			unset($_SESSION["reg_phone"]);
			unset($_SESSION["phone_num"]);
			unset($_SESSION["confirm_sms"]);
			unset($_SESSION["partnerSn"]);

			echo json_encode(array("result"=>"ok"));	
			exit();
		} else {
			echo json_encode(array("error_msg"=>"회원가입에 실패하였습니다.관리자 한테 연락하십시오."));
			exit;
		}	
	}

	function upload_bettingAction()
	{
		$this->req->xssClean();
		
		$this->view->define("index","content/upload_betting.html");
		$this->view->define("header","content/header/header.html");

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->redirect("/");
			exit;
		}
		
		$cartModel = $this->getModel("CartModel");
		$gameListModel = $this->getModel("GameListModel");
		
		$cart = $this->request('cart');
		
		if( $cart == 'add' )
		{
			$betting_no	= $this->request('betting_no');
			
			$url = "/board/write?cart=add&betting_no=".$betting_no;
			throw new Lemon_ScriptException("","","script","alert('처리 되였습니다.');window.opener.top.location.href='".$url."'; window.close();");
			
			echo "betting_no: ".$betting_no;
			
			exit;
		}
		$sn = $this->auth->getSn();
		
		$where.=" and member_sn=".$sn." ";
		
		$list = $gameListModel->getBettingList($sn, 0, 0, $chk_folder);
		
		$this->view->assign("list",$list);
		$this->display();	
	}
	
	function addCheckAjaxAction()
	{
		$id						= trim($this->req->request('uid'));
		$nickname			= trim($this->req->request('nick'));
		$parent				= trim($this->req->request('parent'));
		$chuid				= trim($this->req->request('chuid'));
		$phone_num		= trim($this->req->request('phone_num'));
		
		$model = Lemon_Instance::getObject("MemberModel",true);
		if ( $id ) {
			$ukIdCnt = 0;

			//-> 아이디 중복체크 (총판아이디도 확인)
			$topRs = $model->getPartnerInfo($id);
			if ( count((array)$topRs) > 0 ) $ukIdCnt++;

			$rs = $model->getById($id);
			if ( count((array)$rs) > 0 ) $ukIdCnt++;

			if ( $ukIdCnt > 0 ) {
				echo "true";
			} else {
				echo "false";
			}
		}
		
		if ( $nickname ) {
			$rs = $model->getByName($nickname);
			if ( count((array)$rs) > 0 ) {
				echo "true";
			} else {
				echo "false";
			}
		}
			
		if ( $phone_num ) {
			$this->sendPhoneConfirmMsg($phone_num);
		
			/*전화번호 중복을 확인 하는 경우
			$rs = $model->getByPhone_num($phone_num);
			if ( count((array)$rs) > 0 ) {
				echo "true";
			} else {
				$this->sendPhoneConfirmMsg($phone_num);
			}
			*/
		}

		if ( $parent ) {
			$partnerModel = Lemon_Instance::getObject("PartnerModel", true);
			$recommendInfo = $partnerModel->getPartnerById($parent, '*');
			if ( $recommendInfo["rec_lev"] == 1 and $recommendInfo["status"] == 1 ) {
				echo "true";
			} else {
				echo "false";
			}
		}
		
		//-> 추천인 체크
		if ( $chuid ) {
			$partnerModel = Lemon_Instance::getObject("PartnerModel",true);
			$configModel = Lemon_Instance::getObject("ConfigModel",true);
			$rs = $model->getById($chuid);
			if ( count((array)$rs) > 0 ) {
				$recommendCount = $partnerModel->getJoinRecommendCount($rs['sn']);
				$recommendLevel = $rs['mem_lev'];
				$item = $configModel->getLevelConfigRow($recommendLevel);
				
				//-> 추천인 수 제한
				if ( $recommendCount >= $item['lev_recommend_limit'] ) {
					echo "false";
				} else {
					//-> 추천인 상태 일반상태(N)이 아니면 추천인 등록 불가
					if ( $rs['mem_status'] != "N" ) {
						echo "false";
					} else {
						echo "true";
					}
				}
			} else {
				echo "false";
			}
		}
	}
	
	//휴대폰 인증문자 보네기
	function sendPhoneConfirmMsg($phone_num)
	{
		$api = new gabiaSmsApi('kingdomkkd', '07069c7f5e62a76dc427caa8ae5e421d');
		
		$callback	=	'1004';
		$msg			= rand(100000, 999999);
		
		$result = $api->sms_send($phone_num, $callback, $msg, '', '');
		
		if($result==gabiaSmsApi::$RESULT_OK)
		{
			$_SESSION["confirm_sms"]=$msg;
			return "false";
		}
		else	return "true";
		
		/*
		$gsmsSocket = new Request();
		
		$tran_id				= "kingdomkkd";
		$tran_passwd		= "kingdom1234";
		$tran_phone			= $phone_num;
		$tran_callback	= "1004";
		$tran_date			= 0;
		$tran_msg				= rand(100000, 999999);

		$gsmsSocket->cTranid = $tran_id;
		$gsmsSocket->cTranpasswd = $tran_passwd;
		$gsmsSocket->cTranphone = $tran_phone;

		$gsmsSocket->cTrancallback = $tran_callback;
		$gsmsSocket->cTrandate = $tran_date;
		$gsmsSocket->cTranmsg = $tran_msg;

		$Response = $gsmsSocket->Submit();

		$gsmsSocket->Destroy();
		
		unset($gsmsSocket);
		
		if($Response==0){
			$_SESSION["confirm_sms"]=$tran_msg;
			return "false";
		}
		else	return "true";
		
    unset($Response);
    */
	}
	
	function findPopupAction()
	{
		$this->iframeDefine('findPopup', false);
		
		$mode = $this->req->request('mode');
		if(isset($mode) && $mode=="add")
		{
			$title 		= $this->req->request("title");
			$kubun 		= $this->req->request("kubun");
			$content 	= $this->req->request("question");
			$remoteip 	= $_SERVER["HTTP_X_FORWARDED_FOR"];
			
			if($content=="")
			{
				throw new Lemon_ScriptException("내용을 입력하여 주십시오.");
				exit;
			}
			$bModel = Lemon_Instance::getObject("BoardModel", true);
			$rs = $bModel->addMemberCs($remoteip, $content); //아이디찾기에서는 아이피를 나머지 uid를 넣는다.
			
			if($rs>0)
			{
				throw new Lemon_ScriptException("등록 되었습니다.","","close");
				exit;
			}
		}
				
		$this->display();
	}
	
	// pincode confirm
	function pincodePopupAction()
	{
		$this->iframeDefine('pincodePopup', false);

		unset($_SESSION['partnerSn']);
		unset($_SESSION['recommendUid']);

		$pincode = $this->req->request('pin');
		if($pincode!="")
		{
			$mModel = Lemon_Instance::getObject("MemberModel", true);
			
			//-> 추천인이 총판인지 확인
			$where=" and rec_lev = 1 and status <> '0'";
			$rs = $mModel->getPartnerList($pincode, $where);
			if ( count((array)$rs) > 0 ) {
				$_SESSION['partnerSn'] = $rs[0]['idx'];
				echo "true";
			} else {
				//-> 추천인 회원인지 확인
				$rs = $mModel->getRecommendMember($pincode);
				if ( count((array)$rs) > 0 ) {
					$_SESSION['recommendUid'] = $rs[0]['uid'];
					echo "true";
				} else {
					echo "false";
				}
			}
		} else {
			$this->display();
		}
	}

    // pincode confirm
    function userInfoPopupAction()
    {
        $this->iframeDefine('pincodePopup', false);

        unset($_SESSION['partnerSn']);
        unset($_SESSION['recommendUid']);

        $usr_id = $this->req->request('usr_id');
        $usr_name = $this->req->request('usr_name');
        $usr_nick = $this->req->request('usr_nick');
        $usr_hp = $this->req->request('usr_hp');

        $mModel = Lemon_Instance::getObject("MemberModel", true);

        //-> 추천인이 총판인지 확인
        $where=" and mem_status='N'";
        $rs = $mModel->getUserInfo($usr_id, $usr_name, $usr_nick, $usr_hp);
        if ( count((array)$rs) > 0 ) {
            $m_count = 0;

            if($usr_id == $rs[0]['uid'])
                $m_count++;

            if($usr_name == $rs[0]['user_name'])
                $m_count++;

            if($usr_nick == $rs[0]['nick'])
                $m_count++;

            if($usr_hp == $rs[0]['phone'])
                $m_count++;

            if($m_count > 1)
                echo "아이디: {$usr_id} 비번: {$rs[0]['upass']}";
            else
                echo "false";
        } else {
            echo "false";
        }
    }
	
	// help functions
	function diffdate($lastWriteDate)
	{
		$atime=date("Y-m-d H:i");
		$xtime=strtotime($atime) - strtotime($lastWriteDate);
		$xtime=$xtime/60;
		$xtime=round($xtime); 
		return $xtime;
	}

	function memberAction()
	{
		$this->commonDefine('type');
		$this->view->define(array("content"=>"content/member.html"));
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}

		$model = Lemon_Instance::getObject("MemberModel", true);
		
		$mode = $this->req->request('mode');
		$sn = $this->auth->getSn();
	
		$uphone = explode("-",$model->getMemberField($sn,'phone'));
		$exchange_pass = $model->getMemberField($sn,'exchange_pass');
		$bank_name = $model->getMemberField($sn,'bank_name');
		$bank_account = $model->getMemberField($sn,'bank_account');
		$bank_member = $model->getMemberField($sn,'bank_member');
		$phone = $model->getMemberField($sn,'phone');

		if($mode=="modify")
		{
			$pass=$this->req->request('pass');
			$sms_safedomain	= 0;
			$sms_event			= 0;
			$sms_betting_ok	= 0;

			$dbPasswd = $model->getMemberField($sn,'upass');

			if( $pass != $dbPasswd )
			{
				throw new Lemon_ScriptException('현재 비밀번호가 틀립니다.확인 하십시오.');
				exit;
			}

			$model->modifyMember($sn);			
			throw new Lemon_ScriptException('수정 되였습니다.','','go','/member/member');
			exit;
		}

		$this->view->assign('uphone', $uphone);
		$this->view->assign('exchange_pass', $exchange_pass);
		$this->view->assign('bank_name', $bank_name);
		$this->view->assign('bank_account', $bank_account);
		$this->view->assign('bank_member', $bank_member);
		$this->view->assign('phone', $phone);
		$this->display();
	}
	

	// 추천인
	function recommendAction()
	{
		$this->commonDefine('type');
		$this->view->define(array("content"=>"content/member_recommend.html"));
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$partnerModel = Lemon_Instance::getObject("PartnerModel", true);
		$configModel 	= Lemon_Instance::getObject("ConfigModel", true);
		
		$item = array();
		$level 	= $this->auth->getLevel();
		$item['sn'] 	= $this->auth->getSn();
		$item['uid'] 	= $this->auth->getId();
		$item['nick']	= $this->auth->getName();
		$rs = $configModel->getLevelConfigField($level, 'lev_join_recommend_mileage_rate');
		$item['rate']	= $rs[0];
		$item['sub_count'] = $partnerModel->getJoinRecommendCount($this->auth->getSn());
		$item['benefit'] = $partnerModel->getJoinRecommendBenefit($this->auth->getSn());		
		$subItem = $partnerModel->getJoinRecommendSubList($this->auth->getSn());
		
		$this->view->assign('item', $item);
		$this->view->assign('sub_item', $subItem);
		$this->display();
	}

	// 추천인 (하위회원보기)
	function recommend_listAction()
	{
		$this->commonDefine('type');
		$this->view->define(array("content"=>"content/member_recommend_list.html"));
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$partnerModel = Lemon_Instance::getObject("PartnerModel", true);
		$configModel 	= Lemon_Instance::getObject("ConfigModel", true);
		
		$item = array();
		$level 	= $this->auth->getLevel();
		$item['sn'] 	= $this->auth->getSn();
		$item['uid'] 	= $this->auth->getId();
		$item['nick']	= $this->auth->getName();
		$rs = $configModel->getLevelConfigField($level, 'lev_join_recommend_mileage_rate');
		$item['rate']	= $rs[0];
		$item['sub_count'] = $partnerModel->getJoinRecommendCount($this->auth->getSn());
		$item['benefit'] = $partnerModel->getJoinRecommendBenefit($this->auth->getSn());		
		$subItem = $partnerModel->getJoinRecommendSubList($this->auth->getSn());
		
		$this->view->assign('item', $item);
		$this->view->assign('sub_item', $subItem);
		$this->display();
	}

	//-> 포인트전환
	function point_transformAction() {
		$this->commonDefine('type');
	
		if ( !$this->auth->isLogin() ) {
			$this->loginAction();
			exit;
		}

		$configModel 	= $this->getModel("ConfigModel");
		$memberModel 	= $this->getModel("MemberModel");
		
		//$level	= $this->auth->getLevel();
		//$rs = $configModel->getLevelConfigRow($level);
		//$minExchangeMoney = $rs['lev_bank_min_exchange'];
		
		$sn = $this->auth->getSn();

		//$cash = $memberModel->getMemberField($sn,'g_money');
		//$rs = $memberModel->getMemberRow($sn, 'g_money, bank_name, bank_account, bank_member, phone');

		$this->view->define(array("content"=>"content/point_trans.html"));
/*
		$this->view->assign('exchange_name', $this->auth->getName());
		$this->view->assign('min_exchange', $minExchangeMoney);
		$this->view->assign('cash', $cash);
		$this->view->assign('member', $rs);
*/
		$this->display();
	}

	//-> 금주의출금 TOP (json)
	function exchangeTop10Action() {
		//$moneyModel = $this->getModel("MoneyModel");
		//$list = $moneyModel->getExchangeTop10();
		//echo json_encode($list);
	}

	//-> 실시간 입/출금 현황
	function moneyInOutTop10Action() {
		//$moneyModel = $this->getModel("MoneyModel");
		//$list = $moneyModel->getMoneyInOutTop10();
		//echo json_encode($list);
	}

	//-> 사다리 실시간 배팅금액
	function sadariBettingMoneyAction() {
		$gameDate = trim($this->req->post("gameDate"));
		$gameTh = trim($this->req->post("gameTh"));

		$returnArr = array("home_s_oe" => 0, "away_s_oe" => 0, "home_s_lr" => 0, "away_s_lr" => 0, "home_s_34" => 0, "away_s_34" => 0, 
												"home_s_e3o4l" => 0, "away_s_e3o4l" => 0, "home_s_o3e4r" => 0,"away_s_o3e4r" => 0);

		$moneyModel = $this->getModel("MoneyModel");
		$list_home = $moneyModel->getSadariBettingMoney($gameDate, $gameTh, 1); //-> 홈배팅
		for ( $i = 0 ; $i < count($list_home) ; $i++ ) {
			$returnArr["home_".$list_home[$i]["game_code"]] = $list_home[$i]["sum_money"];
		}

		$list_away = $moneyModel->getSadariBettingMoney($gameDate, $gameTh, 2); //-> 어웨이배팅
		for ( $i = 0 ; $i < count($list_away) ; $i++ ) {
			$returnArr["away_".$list_away[$i]["game_code"]] = $list_away[$i]["sum_money"];
		}

		echo json_encode($returnArr);
	}

	//-> 달팽이 실시간 배팅금액
	function raceBettingMoneyAction() {
		$gameDate = trim($this->req->post("gameDate"));
		$gameTh = trim($this->req->post("gameTh"));

		//-> 1등, 삼치기, 꼴등피하기.
		$returnArr = array("home_r_1w" => 0, "draw_r_1w" => 0, "away_r_1w" => 0, 
												"home_r_1w2d3l" => 0, "draw_r_1w2d3l" => 0, "away_r_1w2d3l" => 0, 
												"home_r_1w2w3l" => 0, "draw_r_1w2w3l" => 0, "away_r_1w2w3l" => 0);

		$moneyModel = $this->getModel("MoneyModel");
		$list_home = $moneyModel->getRaceBettingMoney($gameDate, $gameTh, 1); //-> 홈배팅
		for ( $i = 0 ; $i < count($list_home) ; $i++ ) {
			$returnArr["home_".$list_home[$i]["game_code"]] = $list_home[$i]["sum_money"];
		}

		$list_draw = $moneyModel->getRaceBettingMoney($gameDate, $gameTh, 3); //-> 무배팅
		for ( $i = 0 ; $i < count($list_draw) ; $i++ ) {
			$returnArr["draw_".$list_draw[$i]["game_code"]] = $list_draw[$i]["sum_money"];
		}

		$list_away = $moneyModel->getRaceBettingMoney($gameDate, $gameTh, 2); //-> 어웨이배팅
		for ( $i = 0 ; $i < count($list_away) ; $i++ ) {
			$returnArr["away_".$list_away[$i]["game_code"]] = $list_away[$i]["sum_money"];
		}

		echo json_encode($returnArr);
	}

	function getUserInfoAction() {
		$sn = $this->auth->getSn();
		$uid = $this->auth->getId();

		$rs = [];
		if($sn != "") {
			$mModel = $this->getModel("MemberModel");
			$memoModel = $this->getModel("MemoModel");

			$newMemoList = $memoModel->getMemberNewMemoList($uid);
			$newMemoCount = 0;
			if(is_array($newMemoList))
				$newMemoCount = count($newMemoList);

			$rs["member"] = $mModel->getMemberRow($sn);
			$rs["memo"] = $newMemoCount;
		}

		echo json_encode($rs);
	}

	// 중복아이디 체크
	function checkDuplicatedIDAction() {
		$userid = empty($this->req->post('userid')) ? "" : $this->req->post('userid');
		$mModel = $this->getModel("MemberModel");
		$res = $mModel->checkDuplicatedID($userid);
		echo $res;
	}

	// 중복닉네임 체크
	function checkDuplicatedNickNameAction() {
		$nick = empty($this->req->post('nick')) ? "" : $this->req->post('nick');
		$mModel = $this->getModel("MemberModel");
		$res = $mModel->checkDuplicatedNickName($nick);
		echo $res;
	}

	// ▶ 승인되지 않은 충전요청이 있는지 확인
	function checkConfirmRequestAction() {
		$pModel = Lemon_Instance::getObject("ProcessModel",true);
		$rs = $pModel->checkChargeConfirm($this->auth->getSn());
		$status = 0; // 충전요청이 다 처리됨
		if(count((array)$rs) > 0)
			$status = 1; // 처리되지 않은 충전요청이 있음
		echo $status;
	}

	// 전화번호인증
	function phoneNumCheckAjaxAction() {
		$receiver = empty($this->req->post('phone_num')) ? "" : $this->req->post('phone_num');
				
		$verification_code = random_int(100000, 999999);

		$msg = $this->submitPhoneNumber($receiver, $verification_code);

		echo json_encode($msg);
	}

	function countSubmitCodeAjaxAction() {
		$phone_num = empty($this->req->post('phone_num')) ? "" : $this->req->post('phone_num');
		
		$mModel = $this->getModel("MemberModel");
		$count = $mModel->getCheckCnt($phone_num);

		echo $count;
	}

	function checkCodeAjaxAction() {
		$check_code = empty($this->req->post('check_code')) ? "" : $this->req->post('check_code');
		$phone_num = empty($this->req->post('phone_num')) ? "" : $this->req->post('phone_num');
		
		$mModel = $this->getModel("MemberModel");
		$status = $mModel->compareCheckCode($phone_num, $check_code);
		echo $status;
	}

	function checkPhoneNumberVerificationAction() {
		$phone_num = empty($this->req->post('phone_num')) ? "" : $this->req->post('phone_num');
		
		$mModel = $this->getModel("MemberModel");
		$status = $mModel->checkPhoneNumberVerification($phone_num);
		echo $status;
	}

	function submitPhoneNumber($receiver = "", $verification_code = "") {
		$mModel = $this->getModel("MemberModel");
		$cntUsed = $mModel->checkPhoneNumberUsed($receiver);
		if($cntUsed > 0) {
			$msg["status"] = 2;
			$msg["code"] = "";
		} else {
			$mModel->insertPhoneInfo($receiver, $verification_code);

			$sender = "01051294371";
			
			$res = $this->curl_send($verification_code, $sender, $receiver);
			
			$msg["status"] = $res->result_code;
			$msg["code"] = $verification_code;
		}

		return $msg;
	}

}
?>