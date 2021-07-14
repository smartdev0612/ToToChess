<?php 

class MemoController extends WebServiceController 
{
	//▶ 쪽지관리
	function listAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/memo/list.html");
		
		$mModel = $this->getModel("MemoModel");
		$model 	= $this->getModel("MemberModel");
		
		$act 			= $this->request('act');
		$perpage 	= $this->request('perpage');
		$field 		= $this->request('field');
		$keyword 	= $this->request('keyword');
	
		if($perpage=='') $perpage = 60;
			
		if($act=="del")
		{
			$arrmemidx = $this->request("y_id");
			$str="";
			for($i=0;$i<count($arrmemidx);$i++)
			{
				$str=$str.$arrmemidx[$i].",";
			}
			$str=substr($str,0,strlen($str)-1);
			
			$mModel->delMemoByMemberSn($str);
		}
		if($act=="onedel")
		{
			$idx = $this->request("idx");
			if($idx==""){throw new Lemon_ScriptException("","","script","history.back();");}
			$mModel->delMemoByMemberSn($idx);
		}

		if($keyword!="")
		{
			$fromId="";
			
			if($field=="uid")								{$fromId=$keyword;}
			else if($field=="nick")					{$fromId = $model->getMemberRowByNick($keyword,"uid");}
			else if($field=="bank_member")	{$fromId = $model->getMemberRowByBankOwner($keyword,"uid");}
			
			$where.=" fromid like '%".$fromId."%'";
		}
		
		$page_act 	= "act=".$act."&keyword=".$keyword."&perpage=".$perpage."&field=".$field;
		$total 			= $mModel->getToMemoTotal('운영팀', $where);
		$pageMaker 	= $this->displayPage($total, $perpage, $page_act);
		$list 			= $mModel->getToMemoList('운영팀', $where, $pageMaker->first, $pageMaker->listNum);
		
		$this->view->assign('total', $total);
		$this->view->assign('field', $field);
		$this->view->assign('keyword', $keyword);
		$this->view->assign('list', $list);
		
		$this->display();
	}
	//▶ 보낸  쪽지함
	function sendlistAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/memo/send_list.html");
		
		$mModel = $this->getModel("MemoModel");	
		$memberModel = $this->getModel("MemberModel");	
		
		$act = $this->request('act');
		$perpage 	= $this->request('perpage');
		$keyword 	= $this->request('keyword');
		$field 		= $this->request('field');

		if( $perpage=='') $perpage=60;
			
		if($act=="del")
		{
			$arrmemidx=$this->request('y_id');
			$str="";
			for($i=0;$i<count($arrmemidx);$i++)
			{
				$str=$str.$arrmemidx[$i].",";
			}
			$str=substr($str,0,strlen($str)-1);

			$mModel->delMemoByMemberSn($str);			
		}
		if($act=="onedel")
		{
			$idx = $this->request('idx');
			if($idx==""){throw new Lemon_ScriptException("","","script","history.back();");}
			
			$mModel->delMemoByMemberSn($idx);			
		}

		$page_act 	= "act=".$act."&keyword=".$keyword."&perpage=".$perpage."&field=".$field;
		$total 			= $mModel->getAdminMemoTotal($keyword, $field);
		$pageMaker 	= $this->displayPage($total, 60, $page_act);
		$list 			= $mModel->getAdminMemoList($keyword, $field, $pageMaker->first, $pageMaker->listNum);
		
		$this->view->assign('field', $field);
		$this->view->assign('total', $total);
		$this->view->assign('list', $list);
		$this->view->assign('keyword', $keyword);
		
		$this->display();
	}
	
	//▶ 개별 쪽지함
	function popup_memoAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/memo/popup.memo.html");
		
		$mModel = $this->getModel("MemoModel");
		$model 	= $this->getModel("MemberModel");
		
		$act 			= $this->request('act');

		if($act=="del")
		{
			$arrmemidx = $this->request("y_id");
			$str="";
			for($i=0;$i<count($arrmemidx);$i++)
			{
				$str=$str.$arrmemidx[$i].",";
			}
			$str=substr($str,0,strlen($str)-1);
			$mModel->delMemoByMemberSn($str);
		}
		else if($act=="onedel")
		{
			$idx = $this->request("idx");
			if($idx=="")	{throw new Lemon_ScriptException("","","script","history.back();");}
			
			$mModel->delMemoByMemberSn($idx);
		}
		$nname = $this->request("username");

		if(!is_null($nname) && $nname!="")
		{
			$where = " fromid like '%".$nname."%'";
		}
		
		$total 		= $mModel->getToMemoTotal('운영팀', $where);
		$pageMaker 	= $this->displayPage($total, 10);
		$list 		= $mModel->getToMemoList('운영팀', $where, $pageMaker->first, $pageMaker->listNum);
		
		$this->view->assign('total', $total);
		$this->view->assign('list', $list);
		$this->view->assign('nname', $nname);
		
		$this->display();
	}
	
	//▶ 관리자 쪽지 쓰기
	function popup_adminwriteAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/memo/popup.admin_write.html");
		
		$memoModel 		= $this->getModel("MemoModel");
		$configModel 	= $this->getModel("ConfigModel");
		$partnerModel = $this->getModel("PartnerModel");
		
		$act = $this->request('act');
		
		if($act=="send")
		{
			$sent						= 0;
			$filter_logo			= $this->request("filter_logo");
			$toid_level			= $this->request("toid_level");
			$toid_partner		= $this->request("toid_partner");
			$toid_domain		= $this->request("toid_domain");
			$subject				= htmlspecialchars($this->request("subject"));
			$content				= htmlspecialchars($this->request("content"));			
			

			$where="";
			
			if($filter_logo!="")
			{
				$where.=" and logo='".$filter_logo."'";
			}
			
			if($toid_level!="")
			{
				$where.=" and mem_lev=".$toid_level;
			}
			
			if($toid_partner!="")
			{
				$where.=" and recommend_sn=".$toid_partner;
			}
			
			if($toid_domain!="")
			{
				$where.=" and login_domain like'%".$toid_domain."'";
			}
			
			$sent = $memoModel->writeGroupMemo($where, $subject, $content);

			if(count((array)$sent) > 0)
				throw new Lemon_ScriptException("","","script","alert('쪽지 ".count((array)$sent)."건이 성공적으로 발송되었습니다.');self.close();");
		}
		
		$levelList 		= $configModel->getLevelConfigRows("lev,lev_name");
		$partnerList 	= $partnerModel->getPartnerIdList('', 2);
		$domainList 	= $configModel->getDomainList();
		
		$this->view->assign("level_list", $levelList);
		$this->view->assign("partner_list", $partnerList);
		$this->view->assign("domain_list", $domainList);
		$this->display();
	}
	
	
	
	
	//▶ 쪽지 쓰기
	function popup_writeAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/memo/popup.write.html");
		
		$model 	= $this->getModel("MemberModel");
		$mModel = $this->getModel("MemoModel");
		
		$act 		= $this->request('act');
		$userid	= $this->request("userid");
		$phone	= $this->request("phone");
		$logo		 = $this->request("logo");

		if($act=="send")
		{
			$toid	= $this->request("toid");
			$subject	= htmlspecialchars($this->request("subject"));
			$content	= htmlspecialchars($this->request("content"));
			$onlysms = $this->request("onlysms");
			$where	= "";
			
			$mModel->modifyMemoRead($sn);

			if($onlysms==1)
			{
				include_once("/include/sms.php");
				sms_send_msg($phone,$content);
				
				throw new Lemon_ScriptException("","","script","alert(성공적으로 발송되었습니다.');self.close();");				
			}
			else
			{
				$content = str_replace(chr(13),"<br>",htmlspecialchars($content));				
				$mModel->writeMemo('운영팀', $toid, $subject, $content, '0', $logo);
				
				throw new Lemon_ScriptException("","","script","alert('성공적으로 발송되었습니다.');self.close();");		
				exit;								
			}
		}
		$this->view->assign('userid', $userid);
		$this->view->assign('logo', $logo);
		
		$this->display();
	}
	
	//▶ 보낸쪽지함
	function popup_sendlistAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/memo/popup.send_list.html");
		
		$model 	= $this->getModel("MemberModel");
		$mModel = $this->getModel("MemoModel");
		
		$act 			= $this->request('act');

		if($act=="del")
		{
			$arrmemidx = $this->request("y_id");
			$str="";
			for($i=0;$i<count($arrmemidx);$i++)
			{
				$str=$str.$arrmemidx[$i].",";
			}
			$str=substr($str,0,strlen($str)-1);
			$mModel->delMemoByMemberSn($str);
		}
		else if($act=="onedel")
		{
			$idx = $this->request("idx");
			if($idx=="")	{throw new Lemon_ScriptException("","","script","history.back();");}
			
			$mModel->delMemoByMemberSn($idx);
		}
		
		$nname = $this->request("username");
		if(!is_null($nname) && $nname!="")
		{
			$where = " toid like '%".$nname."%'";
		}
		
		$page_act= "username=".$nname;
		$total		= $mModel->getFromMemoTotal('운영팀', $where);
		$pageMaker 	= $this->displayPage($total, 10, $page_act);
		$list 		= $mModel->getFromMemoList('운영팀', $where, $pageMaker->first, $pageMaker->listNum);
		
		$this->view->assign('nname', $nname);
		$this->view->assign('list', $list);
		$this->display();
	}
}

?>