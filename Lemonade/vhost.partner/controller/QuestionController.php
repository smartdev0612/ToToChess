<?php 


class QuestionController extends WebServiceController 
{
	//▶ 목록
	function listAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/question/list.html");
		
		$model = $this->getModel("BoardModel");
		
		$id 	= $this->auth->getId();
		
		$where = " and a.kubun='partner' and a.mem_id='".$id."' ";
		$total 		= $model->getCsTotal($where);
		$pageMaker 	= $this->displayPage($total, 10);
		$list 			= $model->getCsList($where, $pageMaker->first, $pageMaker->listNum);
		
		for( $i=0; $i < count((array)$list); ++$i)
		{
			$list[$i]['num'] = $i;
			$rsi = $model->getCsReply( $list[$i]['idx'] );
			$list[$i]['sub_content'] = $rsi[0]['content'];
			$list[$i]['sub_size'] = count((array)$rsi);
		}
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
		
		$model = $this->getModel("BoardModel");
		
		$this->view->define("content","content/question/popup.write.html");
		
		$id 	= $this->auth->getId();
		
		if($this->request("act")=="add")
		{
			$title = htmlspecialchars($this->request("title"));
			$content = htmlspecialchars($this->request("content"));
			
			$model->addMemberCs($id, $title, $content, 'partner');
			throw new Lemon_ScriptException("","","script","alert('등록되였습니다.빠른 시간내로 회답하여 드리겠습니다.');opener.document.location.reload(); self.close();");
		}
		$this->display();
		
	}
	
}

?>