<?php 

class FavoriteController extends WebServiceController 
{
	function listAction()
	{
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		
		$sn 		 = $this->auth->getSn();
		$model = $this->getModel("FavoriteModel");
	
		$model->ajaxList($sn);
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