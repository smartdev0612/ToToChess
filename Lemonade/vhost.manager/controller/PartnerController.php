<?php 


class PartnerController extends WebServiceController 
{
	//▶ 부본사 등록 팝업
	function top_popup_joinAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/partner/top_popup.join_list.html");
		
		$partnerModel = $this->getModel("PartnerModel");
		
		$act	= $this->request('act');
		
		if($act=="add")
		{
			$uid = $this->request('uid');
			$name = $this->request('name');
			$phone = $this->request('phone');
			$memo = $this->request('memo');
			$passwd = $this->request('passwd');
			$logo = $this->request('logo');

			$tex_type = $this->request('tex_type');	//-> 기준점
			$rec_one_folder_flag = $this->request('rec_one_folder_flag'); //-> 원폴더정산

			$tex_rate_sport = $this->request('tex_rate_sport')+0; //-> 스포츠 정산 비율
			$tex_rate_minigame = $this->request('tex_rate_minigame')+0; //-> 미니게임 정산 비율

			$partnerModel->addPartnerJoin($uid, $name, 9, $passwd, $phone, "", "", "", "", "", $tex_type, $tex_rate_sport, $tex_rate_minigame, $rec_one_folder_flag, $logo);
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
        $this->view->define("content","content/partner/partner_struct.html");

        $model 		= $this->getModel("PartnerModel");
        $eModel 	= $this->getModel("EtcModel");

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

        $list 			= $model->getPartnerList('', $beginDate, $endDate);

        $this->view->assign('list', $list);
        $this->view->assign('begin_date', $beginDate);
        $this->view->assign('end_date', $endDate);

        $this->display();
    }

    function saveRollingRateAjaxAction()
    {
        $this->req->xssClean();

        $rec_sn						= $this->req->request('rec_sn');
        $sport_rate			= $this->req->request('sport_rate');
        $mini_rate			= $this->req->request('mini_rate');

        $model 		= $this->getModel("PartnerModel");
        $model->modifyRecommendRate($rec_sn, $sport_rate, $mini_rate);
        echo json_encode(array("ret"=>"1"));
        exit();
    }

	//▶ 부본사 목록
	function list_topAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/partner/top_list.html");
		
		$model 		= $this->getModel("PartnerModel");
		$eModel 	= $this->getModel("EtcModel");

		$perpage = $this->request('perpage');
		$field = $this->request('field');
		$keyword = $this->request('keyword');
		$act = $this->request('act');
		$logo = $this->request('logo');

		if ( !$perpage ) $perpage = 100;

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
		
		$where = " and rec_lev = '9'";
		if ( $keyword != "" ) {
			$where .= " and {$field} like '%".$keyword."%'";
		}
		
		$rs = $eModel->getLevel();		
		
		$arr_mem_lev = array();
		for( $i=0; $i < count((array)$rs); ++$i )
		{
			$level = $rs[$i]['lev'];
			$levelName = $rs[$i]['lev_name'];
			$arr_mem_lev[ $level ] = $levelName;
		}

		$page_act = "perpage=".$perpage."&field=".$field."&keyword=".$keyword; 

		$total 			= $model->getRecommendTotal($where);
		$pageMaker 	= $this->displayPage($total, $perpage, $page_act);
		$list 			= $model->getRecommendListTop($where, $pageMaker->first, $pageMaker->listNum);		

		$this->view->assign('perpage', $perpage);
		$this->view->assign('arr_mem_lev', $arr_mem_lev);
		$this->view->assign('list', $list);
		$this->view->assign('logo', $logo);
		$this->view->assign('field', $field);
		$this->view->assign('keyword', $keyword);


		$this->display();
	}

	function texSettleAction()
    {
        $model 		= $this->getModel("TexModel");
        $model->texSettlment();
        echo "true";
    }

	//-> 부본사 정산목록
	function list_tex_topAction()
	{
		$this->commonDefine();

		if ( !$this->auth->isLogin() ) {
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/partner/top_list_tex.html");
		
		$model = $this->getModel("PartnerModel");
		$act = $this->request('act');
		$logo = $this->request('logo');
		$texDate = $this->request("texDate");
		$startDate = $this->request("startDate");
		$endDate = $this->request("endDate");

		if ( $startDate and $endDate ) {
			$texDate = "";
		} else {
			if ( !$texDate ) $texDate = date("Y-m-d",time()-86400);
			$startDate = "";
			$endDate = "";
		}
		$list = $model->getTexDataTop($texDate, $startDate, $endDate);

		$this->view->assign('texDate', $texDate);
		$this->view->assign('startDate', $startDate);
		$this->view->assign('endDate', $endDate);
		$this->view->assign('list', $list);
		$this->view->assign('logo', $logo);
		$this->view->assign('keyword', $keyword);
		
		$this->display();
	}

	//▶ 총판목록
	function listAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/partner/list.html");
		
		$model = $this->getModel("PartnerModel");
		$eModel = $this->getModel("EtcModel");

		$perpage = $this->request('perpage');
		$parent_id = $this->request('parent_id');
		$field = $this->request('field');
		$keyword = $this->request('keyword');
		$act = $this->request('act');
		$logo = $this->request('logo');

		if ( !$perpage ) $perpage = 200;
		
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

		$where = " and rec_lev = 1";
		if ( $keyword != "" ) {
			$where .= " and {$field} like '%".$keyword."%'";
		}
		if ( $parent_id != "" ) {
			$where .= " and rec_parent_id = '".$parent_id."'";
		}

		$rs = $eModel->getLevel();		
		
		$arr_mem_lev = array();
		for( $i=0; $i < count((array)$rs); ++$i )
		{
			$level = $rs[$i]['lev'];
			$levelName = $rs[$i]['lev_name'];
			$arr_mem_lev[ $level ] = $levelName;
		}

		$page_act = "perpage=".$perpage."&parent_id=".$parent_id."&field=".$field."&keyword=".$keyword;

		$total 			= $model->getRecommendTotal($where);
		$pageMaker 	= $this->displayPage($total, $perpage, $page_act);
		$list 			= $model->getRecommendList($where, $pageMaker->first, $pageMaker->listNum);		

		$topList = $model->getTopRecommendList();

		$this->view->assign('perpage', $perpage);
		$this->view->assign('topList', $topList);
		$this->view->assign('arr_mem_lev', $arr_mem_lev);
		$this->view->assign('list', $list);
		$this->view->assign('logo', $logo);
		$this->view->assign('parent_id', $parent_id);
		$this->view->assign('field', $field);
		$this->view->assign('keyword', $keyword);
		
		$this->display();
	}

	//-> 총판 출금신청 목록
	function exchange_listAction() {
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/partner/exchange_list.html");
		
		$model = $this->getModel("MoneyModel");
		$partnerModel = $this->getModel("PartnerModel");
	
		$perpage 	 	= $this->request('perpage');
		$keyword 	 	= $this->request('keyword');
		$startDate 	= $this->request('start_date');
		$endDate 		= $this->request('end_date');		
		$dateType	 	= $this->request('date_type');
		$procFlag  = $this->request('proc_flag');
		
		if ( !$perpage ) $perpage=30;
		
		// 출금신청내역 state = 2
		$where = " and state = 2";
			
		if ( $procFlag ) {
			$where=" and a.proc_flag='".$procFlag."'";
		}

		if ( $keyword ) {
			$field = $this->request("field");
			
			if ( $field == "id" ) {
				$where.=" and b.rec_id like('%".$keyword."%')";
			} else if ( $field == "name" ) {
				$where.=" and b.rec_name like('%".$keyword."%')";
			}
		}
		
		if ( $startDate ) {
			$where.= " and a.".$dateType.">='".$startDate." 00:00:00'";
		}
		if ( $endDate ) {
			$where.= " and a.".$dateType."<='".$endDate." 23:59:59'";
		}

		$page_act = "perpage=".$perpage."&keyword=".$keyword."&start_date=".$startDate."&end_date=".$endDate."&date_type=".$dateType."&proc_flag=".$procFlag;
		
		$total = $partnerModel->getRecExchangeLogTotal($where);
		$pageMaker = $this->displayPage($total, $perpage, $page_act);
		$list = $partnerModel->getRecExchangeLogList($where, $pageMaker->first, $pageMaker->listNum);
			
		$this->view->assign('keyword', $keyword);
		$this->view->assign('field', $field);
		$this->view->assign('start_date', $startDate);
		$this->view->assign('end_date', $endDate);
		$this->view->assign('date_type', $dateType);
		$this->view->assign('list', $list);
		$this->view->assign('proc_flag', $procFlag);
		
		$this->display();
	}

	//-> 출금신청 처리하기 (승인 및 취소)
	function exchange_popup_processAction() {
		$this->popupDefine();

		if ( !$this->auth->isLogin() ) {
			$this->redirect("/login");
			exit;
		}

		$partnerModel = $this->getModel("PartnerModel");

		$mode	= $this->request("mode");
		$log_sn = $this->request("log_sn");

		if ( $mode == "success" ) {
			$partnerModel->exchangeRecProcess($log_sn);
			throw new Lemon_ScriptException("","","script","alert('승인 되였습니다.');parent.location.reload();");
		} else if ( $mode == "cancel" ) {
			$partnerModel->exchangeRecCancelProcess($log_sn);
			throw new Lemon_ScriptException("","","script","alert('취소 되였습니다.');parent.location.reload();");
		}
	}	
	
	//-> 총판정산목록
	function list_texAction()
	{
		$this->commonDefine();

		$now = date("Y-m-d", strtotime("-1 days"));

		if ( !$this->auth->isLogin() ) {
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/partner/list_tex.html");
		
		$model = $this->getModel("PartnerModel");
        $texModel = $this->getModel("TexModel");
		$act = $this->request('act');
		$logo = $this->request('logo');
		$texDate = $this->request("texDate");
		$startDate = $this->request("startDate");
		$endDate = $this->request("endDate");

		if ( $startDate and $endDate ) {
			$texDate = "";
		} else {
			//if ( !$texDate ) $texDate = date("Y-m-d",time()-86400);
            if ( !$texDate ) $texDate = $now;
			$startDate = "";
			$endDate = "";
		}

        /*if ( $startDate and $endDate ) {
            $texDate = "";
        } else {
            if ( !$texDate ) $texDate = date("Y-m-d",time()-86400);
            $startDate = "";
            $endDate = "";
        }*/
        $list = $model->getTexData($texDate, $startDate, $endDate);

		if(is_array($list) && count((array)$list) == 0)
        {
            $list =  $texModel->getListTex();
        }


		$this->view->assign('texDate', $texDate);
		$this->view->assign('startDate', $startDate);
		$this->view->assign('endDate', $endDate);
		$this->view->assign('list', $list);
		$this->view->assign('logo', $logo);
		$this->view->assign('keyword', $keyword);
		
		$this->display();
	}

	//▶ 총판목록
	function list_recAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/partner/list.html");
		
		$model 		= $this->getModel("PartnerModel");
		$eModel 	= $this->getModel("EtcModel");
		$keyword 	= $this->request('keyword');
		$act 			= $this->request('act');
		$logo 			= $this->request('logo');
		
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
		
		if($keyword != "")
		{
			$where = " and rec_id ='".$keyword."'";
		}
		
		$rs = $eModel->getLevel();		
		
		$arr_mem_lev = array();
		for( $i=0; $i < count((array)$rs); ++$i )
		{
			$level = $rs[$i]['lev'];
			$levelName = $rs[$i]['lev_name'];
			$arr_mem_lev[ $level ] = $levelName;
		}
				
		$total 			= $model->getRecommendTotal($where);
		$pageMaker 	= $this->displayPage($total, 10);
		$list 			= $model->getRecommend_Lev2List($where, $pageMaker->first, $pageMaker->listNum);
		
		$this->view->assign('arr_mem_lev', $arr_mem_lev);
		$this->view->assign('list', $list);
		$this->view->assign('logo', $logo);
		$this->view->assign('keyword', $keyword);
		
		$this->display();
	}
	
	//▶ 상세정보
	function memberDetailsAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/partner/member_details.html");		
	
		$model = $this->getModel("PartnerModel");
		
		$idx 	= $this->request('idx');
		$act = $this->request('act');
		
		if($act=="add")
		{
			$rec_parent_id			= $this->request('topRecId');
			$memid 							= $this->request('memid');
			$urlidx 						= $this->request('urlidx');
			$pwd 								= $this->request('pwd');
			$memo 							= $this->request('memo');
			$rec_lev 						= $this->request('rec_lev');
            $rec_id 					= $this->request('rec_id');
			$rec_name 					= $this->request('rec_name');
			$rec_bankname 			= $this->request('rec_bankname');
			$rec_bankusername 	= $this->request('rec_bankusername');
			$rec_banknum 				= $this->request('rec_banknum');
			$rec_email 					= $this->request('rec_email');
			$rec_phone 					= $this->request('rec_phone');
			$tex_get_member_id	= $this->request('tex_get_member_id');

			$tex_type = $this->request('tex_type');	//-> 기준점
			$tex_rate_sport = $this->request('tex_rate_sport'); //-> 비율
			$tex_rate_minigame = $this->request('tex_rate_minigame'); //-> 비율
			$rec_one_folder_flag = $this->request('rec_one_folder_flag'); //-> 원폴더정산

			if ( strlen(trim($rec_parent_id)) > 0 ) {
				$tex_type = $this->request('top_rec_tex_type');	//-> 정산타입
				$rec_one_folder_flag = $this->request('top_rec_one_folder_flag'); //-> 원폴더정산
			}

			if( $pwd == "default" ) {
				$pwd="";
				$where="";
			} else {
				$pwd=md5($pwd);
				$where="rec_psw='".$pwd."',";
			}

			$model->modifyMemberDetails2($where, $memo, $rec_lev, $rec_id, $rec_name, $rec_bankname, $rec_bankusername, $rec_banknum, $rec_email, $rec_phone, $tex_type, $tex_rate_sport, $tex_rate_minigame, $rec_one_folder_flag, $urlidx, $tex_get_member_id, $rec_parent_id);
			echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' ><script>alert('수정 되였습니다.'); opener.location.reload(); window.close();</script>";			
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=/partner/memberDetails?idx=".$urlidx."'>";
			exit;
		}
		
		$topTopRecList = $model->getTopRecommendList();
		$list = $model->getMemberDetails($idx);

		$this->view->assign('topTopRecList', $topTopRecList);
		$this->view->assign('list', $list);
		
		$this->display();
	}

	//▶ 상세정보 (부본사)
	function memberDetailsTopAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/partner/top_member_details.html");		
	
		$model = $this->getModel("PartnerModel");
		
		$idx 	= $this->request('idx');
		$act = $this->request('act');
		
		if($act=="add")
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
			$tex_get_member_id	= $this->request('tex_get_member_id');

			$tex_type = $this->request('tex_type');	//-> 기준점
			$tex_rate_sport = $this->request('tex_rate_sport'); //-> 스포츠 정산 비율
			$tex_rate_minigame = $this->request('tex_rate_minigame'); //-> 미니게임 정산 비율
			$rec_one_folder_flag = $this->request('rec_one_folder_flag'); //-> 원폴더정산

			if( $pwd == "default" ) {
				$pwd="";
				$where="";
			} else {
				$pwd=md5($pwd);
				$where="rec_psw='".$pwd."',";
			}

			$model->modifyMemberDetails($where, $memo, $rec_lev, $rec_name, $rec_bankname, $rec_bankusername, $rec_banknum, $rec_email, $rec_phone, $tex_type, $tex_rate_sport, $tex_rate_minigame, $rec_one_folder_flag, $urlidx, $tex_get_member_id, "");

			//-> 하위 총판들 부본사 셋팅과 같게 업데이트. (정산방식, 단폴포함여부, 정산비율)
			$model->modifyPartnerAllChild($memid, $tex_type, $tex_rate_sport, $tex_rate_minigame, $rec_one_folder_flag);

			echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' ><script>alert('수정 되였습니다.'); opener.location.reload(); window.close();</script>";			
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=/partner/memberDetails?idx=".$urlidx."'>";
			exit;
		}
		
		$list = $model->getMemberDetails($idx);
		
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
		$this->view->define("content","content/partner/memo_add_acc.html");		
	
		$model 	= $this->getModel("PartnerModel");
		$mModel = $this->getModel("MemoModel");

		$toid=$this->request('toid');
		$reply_id = empty($this->request('reply_id')) ? 0 : $this->request('reply_id');
		$p_type = empty($this->request('p_type')) ? 0 : $this->request('p_type');
		$title=trim($this->request('title'));
		$time=trim($this->request('time'));
		$content=trim($this->request('content'));
		$content=htmlspecialchars($content);
		
		$act = $this->request('act');
		if(isset($act) && $act=="add")
		{
			$mModel->writePartnerMemo($toid, $title, $content, $p_type);
			$mModel->modifyMemoRead($reply_id);
			throw new Lemon_ScriptException("","","script","alert('성공적으로 발송되였습니다.'); opener.document.location.reload(); self.close();");
			exit;
		}
	
		if($toid != "")
		{
			$send = $this->request('toid');
		}
		else
		{
			throw new Lemon_ScriptException("잘못된 연결입니다!", "", "close");
			
			exit;
		}	
		
		$this->view->assign('send', $send);
		$this->view->assign('reply_id', $reply_id);
		$this->view->assign('p_type', $p_type);
		$this->display();
	}
	
	/*
	 * 파트너 신청
	 */
	function joinAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/partner/join_list.html");
		
		$model = $this->getModel("PartnerModel");
		
		$act	= $this->request('act');
		
		if($act == "delete_user")
		{
			$arrmemidx = $this->request('y_id');
			$str="";
			for($i=0; $i < count($arrmemidx);$i++)
			{
				$str=$str.$arrmemidx[$i].",";
			}
			$str=substr($str,0,strlen($str)-1);
						
			$model->delRecommendjoinList( $str );			
		}
		if($act == "delone")
		{
			$idx = $this->request('idx');
			$model->delRecommendjoin( $idx );						
		}
		if($act == "add")
		{
			$idx = $this->request('idx');
			$model->modifyRecommendjoin( $idx );			
		}
		
		$nname = $this->request('username');
		if(!empty($nname))
		{
			$where = " and rec_id like '%".$nname."%'";
		}
		
		$total = $model->getRecommendjoinTotal($where);
		$pageMaker = $this->displayPage($total, 10);
		$list = $model->getRecommendjoinList($where, $pageMaker->first, $pageMaker->listNum);
		
		$this->view->assign('list', $list);
			
		$this->display();
	}
	
	/*
	 * 파트너 공지
	 */
	function noticelistAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/partner/notice_list.html");
		
		$model 	= $this->getModel("PartnerModel");
		$bModel = $this->getModel("BoardModel");
		
		$act	= $this->request('act');
		
		if($act == "del")
		{
			$num = $this->request('num');
			$bModel->delBoard( $num );
		}
		
		$where = '';
		
		$total = $bModel->getBoardTotal($where,130);
		$pageMaker = $this->displayPage($total, 10);
		$list = $bModel->getBoardList($where, $pageMaker->first, $pageMaker->listNum,130);
		
		$this->view->assign('list', $list);
			
		$this->display();
	}
	
	/*
	* 파트너 공지쓰기
	*/ 
	function noticeaddAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/partner/notice_add.html");
		
		$model 	= $this->getModel("PartnerModel");
		$bModel = $this->getModel("BoardModel");
		
		$act	= $this->request('act');
		if($act == "add")
		{
			$writer = $this->request('name');
			$write_datetime = $this->request('time');
			$content = htmlspecialchars($this->request('content'));
			$subject =htmlspecialchars($this->request('title'));
			$view_code = 130; 
			
			if($subject!="" && $content!="" )
			{
				$bModel->addBoard($writer, $subject, $content, $write_datetime, $view_code );
				
				throw new Lemon_ScriptException("성공적으로 등록 되였습니다.", "", "go", "/partner/noticelist");				
				exit;
			}
		}
			
		$this->display();
	} 
	/*
	* 파트너 공지수정
	*/ 
	function noticeviewAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/partner/notice_view.html");
		
		$model 	= $this->getModel("PartnerModel");
		$bModel = $this->getModel("BoardModel");
		
		$idx 	= $this->request('idx');
		$act	= $this->request('act');
		
		if($act == "edit")
		{
			$write_datetime = $this->request('time');
			$content = htmlspecialchars($this->request('content'));
			$subject =htmlspecialchars($this->request('title'));
			
			$bModel->modifyBoard($idx, $subject, $content, $write_datetime);
			
			throw new Lemon_ScriptException("성공적으로 등록 되였습니다.", "", "go", "/partner/noticelist");
			exit;
		}
		
		$list = $bModel->getPartnerBoard( $idx );
		$this->view->assign('list', $list);
			
		$this->display();
	} 
	
	
	/*
	 * 파트너 쪽지
	 */ 
	function memolistAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/partner/memo_list.html");
		
		$model 	= $this->getModel("PartnerModel");
		$mModel = $this->getModel("MemoModel");
		
		$act	= $this->request('act');
		$p_type	= empty($this->request('p_type')) ? 0 : $this->request('p_type');
				
		if(isset($act)&&$act == "del")
		{
			$id = $this->request('id');
			$mModel->delMemoByMemberSn( $id );
		}		
		$where = " and toid = '운영팀' and kubun='1' and p_type = '" . $p_type . "'";
		$total = $mModel->getMemoTotal($where);
		$pageMaker = $this->displayPage($total, 10);
		$list = $mModel->getMemoList($where, $pageMaker->first, $pageMaker->listNum, " writeday desc ");
		
		$this->view->assign('list', $list);
		$this->view->assign('p_type', $p_type);
		
		$this->display();
	}
	 
	/*
	 *  파트너 쪽지쓰기
	 */ 
	function memoaddAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/partner/memo_add.html");
		
		$model 	= $this->getModel("PartnerModel");
		$mModel = $this->getModel("MemoModel");
		
		$act = $this->request('act');
		$p_type	= empty($this->request('p_type')) ? 0 : $this->request('p_type');

		$partnerList = $model->getPartnerIdList('', $p_type);

		if(isset($act) && $act=="add")
		{
			$title		= trim( $this->request('title') );
			$toid		= $this->request('toid');
			$time		= trim($this->request('time'));
			$content	= trim($this->request('content'));
			$content	= htmlspecialchars($content);
			
			$mModel->writePartnerMemo($toid, $title, $content, $p_type);
			
			throw new Lemon_ScriptException("성공적으로 등록 되였습니다.", "", "go", "/partner/memoadd?p_type={$p_type}");
			exit;
		}
		
		if($this->request('toid')!="")
		{
			$send = $this->request["toid"];
		}else{
			$send = "전체파트너";
		}
		
		$this->view->assign('send', $send);
		$this->view->assign('partnerList', $partnerList);
		$this->view->assign('p_type', $p_type);
	
		$this->display();
		
	} 
	
	/*
	 *   보낸 쪽지함
	 */ 
	function  memosendlistAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/partner/memo_sendlist.html");
		
		$model 	= $this->getModel("PartnerModel");
		$mModel = $this->getModel("MemoModel");
		
		$act = $this->request('act');
		$p_type	= empty($this->request('p_type')) ? 0 : $this->request('p_type');

		if(isset($act) && $act == "del")
		{
			$id = $this->request('id');
			$mModel->delMemoByMemberSn($id);
		}
		
		if(isset($act)&& $act == "alldel")
		{
			$arrmemidx = $this->request('y_id');
			for($i=0;$i<count($arrmemidx);$i++)
			{
				$str=$str.$arrmemidx[$i].",";
			}
			$str=substr($str,0,strlen($str)-1);
			$mModel->delMemoByMemberSn($str);
		}
		
		$where = "and fromid = '운영팀' and kubun='1' and p_type = '" . $p_type . "'";
		$total = $mModel->getMemoTotal($where);
		$pageMaker = $this->displayPage($total, 10);
		$list = $mModel->getMemoList($where, $pageMaker->first, $pageMaker->listNum, " writeday desc ");
		
		$this->view->assign('list', $list);
		$this->view->assign('p_type', $p_type);

		$this->display();
	}
	 
	
	function accountingAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/partner/accounting.html");
		
		$model = $this->getModel("PartnerModel");
		$act	= $this->request('act');		
		
		if(isset($act) && $act=="cancel")
		{
			$idx = $this->request('idx');
			$rs = $model->delAccounting( $idx );
			
			if(count((array)$rs) > 0)
			{
				throw new Lemon_ScriptException("삭제 되였습니다.", "", "go", "/partner/accounting");
				exit();
			}
		}
		
		if(isset($act) && $act == "renew")
		{
			$idx = $this->request("idx");
			
			$rs = $model->modifyAccounting( $idx );
			
			if(count((array)$rs) > 0)
			{
				throw new Lemon_ScriptException("성공적으로 처리되었습니다!", "", "go", "/partner/accounting");		
				exit();
			}
		}
		
		$list = $model->getAccounting();
		
		$this->view->assign('list', $list);
		
		$this->display();
	}
	
	function accounting_finAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/partner/accounting_fin.html");
		
		$model = $this->getModel("PartnerModel");
		$act	= $this->request('act');		
		
		$where = "";
		if(isset($act) && $act=="members_list")
		{
			$rec_id = $this->request('rec_id');
			if($rec_id!="")
			{
				$where = "and b.rec_id='".$rec_id."'";
			}
		}		
		
		$total 		= $model->getAccountingfinTotal($where);
		$pageMaker 	= $this->displayPage($total, 10);
		$list 		= $model->getAccountingfinList($where, $pageMaker->first, $pageMaker->listNum);
		
		$this->view->assign('list', $list);
		$this->display();
	}
	
	// ▶ 파트너 정산비율 수정 팝업
	function popup_rateAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		
		$model = $this->getModel("PartnerModel");
		
		$this->view->define("content","content/partner/popup.rate.html");
		
		$id 	= $this->request("id");
		$rate = $this->request("rate");
		
		if( $this->request("act")=="edit" ) 
		{
			
			if(preg_match('/^\d*$/',$rate))
			{
				$model->modifyRate($id,$rate);
				
				throw new Lemon_ScriptException("", "", "script", "alert('수정 되였습니다.');opener.document.location.reload(); self.close();");						
				exit;
			}
			else
			{
				throw new Lemon_ScriptException('정산비율은 숫자만 가능합니다!', '', 'back' );
				exit;			
			}
		}
		
		$this->view->assign('id', $id);
		$this->view->assign('rate', $rate);
		
		$this->display();
	}
	
	//▶ 총판등록 팝업
	function popup_joinAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/partner/popup.join_list.html");
		
		$partnerModel = $this->getModel("PartnerModel");
		
		$act	= $this->request('act');
		
		if($act=="add")
		{
			$topRecId = $this->request('topRecId');
			$uid = $this->request('uid');
			$name = $this->request('name');
			$phone = $this->request('phone');
			$memo = $this->request('memo');
			$passwd = $this->request('passwd');
			$logo = $this->request('logo');

			$tex_type = $this->request('tex_type');	//-> 정산타입
			$tex_rate_sport = $this->request('tex_rate_sport')+0; //-> 스포츠 정산비율
			$tex_rate_minigame = $this->request('tex_rate_minigame')+0; //-> 미니게임 정산비율
			$rec_one_folder_flag = $this->request('rec_one_folder_flag'); //-> 원폴더정산

			if ( strlen(trim($topRecId)) > 0 ) {
				$tex_type = $this->request('top_rec_tex_type');	//-> 정산타입
				$rec_one_folder_flag = $this->request('top_rec_one_folder_flag'); //-> 원폴더정산
			}

			$partnerModel->addPartnerJoin($uid, $name, 1, $passwd, $phone, "", "", "", "", "", $tex_type, $tex_rate_sport, $tex_rate_minigame, $rec_one_folder_flag, $topRecId, $logo);
			throw new Lemon_ScriptException("", "", "script", "alert('등록되었습니다.');opener.document.location.reload(); self.close();");						
			exit;
		}

		$topTopRecList = $partnerModel->getTopRecommendList();	
		$this->view->assign('topTopRecList', $topTopRecList);
		$this->display();
	}
	
	//▶ 총판등록시 ajax 확인
	function addCheckAjaxAction()
	{
		$uid = trim($this->req->request('uid'));
		
		$partnerModel = Lemon_Instance::getObject("PartnerModel",true);
		if($uid)
		{
			$rs = $partnerModel->getPartnerFieldById($uid, "rec_id");
			echo ($rs!="") ? 1 : 0;
		}
	}

	function comfirmTexAjaxAction()
    {

    }
}

?>