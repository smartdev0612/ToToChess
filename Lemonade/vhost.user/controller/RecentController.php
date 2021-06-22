<?php 

class RecentController extends WebServiceController 
{
	function listAction()
	{
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		
		$page  = $this->request('page');
		$page_size  = $this->request('page_size');
		$recentModel = $this->getModel("RecentModel");

		$recentModel->ajaxList($page, $page_size);
	}
	
	function addAction()
	{
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
	
		$sn 		= $this->auth->getSn();
		$cateIdx = $this->request('cateIdx');
		$nationIdx = $this->request('nationIdx');
		$leagueIdx = $this->request('leagueIdx');
		
		$model  = $this->getModel("FavoriteModel");
		$model->ajaxAdd($sn, $cateIdx, $nationIdx, $leagueIdx);
	}
	
	function delAction()
	{
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
	
		$sn 		= $this->auth->getSn();
		$idx 	= $this->request('idx');

		$model  = $this->getModel("FavoriteModel");
		$model->ajaxDel($idx);
	}
}

?> 