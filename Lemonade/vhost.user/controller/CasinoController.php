<?php 


class CasinoController extends WebServiceController 
{
	function layoutDefine($type='')
	{
		$this->view->define("index","layout/layout.sub_normal.html");
		$live_game_model = $this->getModel("LiveGameModel");		
		$gameList = $live_game_model->getLiveGameList($where);

		$this->view->assign("game_list",  $gameList);

	}
	
	function indexAction()
	{
		$this->commonDefine("");
		$this->view->define(array("content"=>"content/casino.html"));

		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$this->display();
	}
	
	function board_gameAction()
	{
		$this->commonDefine("");
		$this->view->define(array("content"=>"content/board_game.html"));

		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$this->display();
	}
	
	function pinnacleAction()
	{
		$this->commonDefine("");
		$this->view->define(array("content"=>"content/casino_pinnacle.html"));

		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$this->display();
	}

	
	function sboAction()
	{
		$this->commonDefine("");
		$this->view->define(array("content"=>"content/casino_sbo.html"));

		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$this->display();
	}
	
}

?>