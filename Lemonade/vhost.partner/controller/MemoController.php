<?php 

class MemoController extends WebServiceController 
{
	function popup_listAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		
		$this->view->define("content","content/memo/popup.list.html");
		
		$memoModel 	= $this->getModel("MemoModel");
		$act		= $this->request("act");
		
		if($act=="del")
		{
			$memoSn = $this->request("memo_sn");
			$memoModel->delMemberMemo($memoSn);
		}
		
		$partnerId	= $this->auth->getId();		
		$where 			= " and toid='".$partnerId."' and kubun='1' and isdelete='0' ";
		$orderby 		= " newreadnum asc,writeday desc ";
		
		$total	 		= $memoModel->getMemoTotal($where);
		$pageMaker 	= $this->displayPage($total, 10);
		$list 			= $memoModel->getMemoList($where, $pageMaker->first, $pageMaker->listNum, $orderby);
		
		$this->view->assign("list",$list);	
		
		$this->display();
	}
	
	function popup_sendlistAction()
	{
		$this->popupDefine();
	
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/memo/popup.sendlist.html");
		
		$memoModel = $this->getModel("MemoModel");
		
		$act	= $this->request("act");
		
		if($act=="del")
		{
			$id = $this->request("id");			
			$memoModel->delMemberMemo($id);
		}
		
		$id 				= $this->auth->getId();		
		$where 			= " and fromid='".$id."' and kubun='1' ";
		$orderby 		= " writeday desc ";
		
		$total	 		= $memoModel->getMemoTotal($where);
		$pageMaker 	= $this->displayPage($total, 10);
		$list 			= $memoModel->getMemoList($where, $pageMaker->first, $pageMaker->listNum, $orderby);
		
		$this->view->assign("list",$list);	
		
		$this->display();
		
	}
	
	function popup_writeAction()
	{
		$this->popupDefine();
		
		
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/memo/popup.write.html");
		
		$model = $this->getModel("MemoModel");		
		
		$partner_id = $this->auth->getId();		
		
		if($this->request("act") == "add")
		{
			$model->writeMemo($partner_id, "운영팀", htmlspecialchars($this->request("title")), htmlspecialchars($this->request("content")),1);
			throw new Lemon_ScriptException("발송 되였습니다.","","go","/memo/popup_list");
		}
		$this->display();
	}
	
	function popup_viewAction()
	{
		$this->popupDefine();
		
		
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/memo/popup.view.html");
		
		$model = $this->getModel("MemoModel");		
		
		$partner_id = $this->auth->getId();		
		
		$id = $this->request("id");
		if($this->request("act")=="del")
		{
			$model->moidifyMemberMemoDel($id);
			
			throw new Lemon_ScriptException("삭제 되였습니다.","","go","/memo/popup_list");
			exit;
			
		}		
		$list = $model->getMemberMemo($id);	
		
		if($list['newreadnum']==0)
		{
			$model->modifyMemoRead($id);	
		}
		
		$this->view->assign("list",$list);		
		$this->view->assign("id",$id);	
		
		$this->display();
	}
}

?>