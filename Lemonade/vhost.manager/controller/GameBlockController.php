<?php 


class GameBlockController extends WebServiceController
{
	//▶ 리그 목록
	function listAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/game_block/list.html");
		
		$model  	= $this->getModel("GameBlockModel");
		
		$act		 	= $this->request("act");
		
		$ph_path		 = "";
		$new_ph_path = "../vhost.user";
		
		if($act=="delete")
		{
			$idx = $this->request("idx");
			if($idx=="")
				throw new Lemon_ScriptException("","","script","history.back();");
			
			$model->delProcess($idx);
		}

        $category	= $this->request("category");
		$keyword = $this->request("username");

        $where = '1=1';
        if($category != "")	$where.= " and sport_name='".$category."'";
		if($keyword != "")	$where.= " and league_name like '%".$keyword."%'";

		$page_act= "username=".$keyword."&category=".$category;
		
		$total 			= $model->getTotal($where);
		$pageMaker 	= $this->displayPage($total, 10, $page_act);
		$list 			= $model->getList($where, $pageMaker->first, $pageMaker->listNum);
		
		$categoryList = $model->getCategoryList();
		
		$this->view->assign('category', $category);
		$this->view->assign('username', $keyword);
		$this->view->assign('category_list', $categoryList);
		$this->view->assign('list', $list);
		
		$this->display();
	}

	function gameListAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}

		$this->view->define("content","content/game_block/game_list.html");
		
		$model = $this->getModel("GameBlockModel");

		$leagueName = $this->request("leagueName");
		$teamName	= $this->request("teamName");


        $where = ' and 1=1';
        if($leagueName != "")	$where.= " AND notice LIKE '%" . $leagueName . "%'";
		if($teamName != "")	$where.= " AND (home_team LIKE '%" . $teamName . "%' OR away_team LIKE '%" . $teamName . "%')";

		$page_act= "leagueName=" . $leagueName . "&teamName=" . $teamName;

		$total 			= $model->getGameTotal($where);
		
		$pageMaker 	= $this->displayPage($total, 50, $page_act);
		
		$list 			= $model->getGameList($where, $pageMaker->first, $pageMaker->listNum);
		
		$this->view->assign('leagueName', $leagueName);
		$this->view->assign('teamName', $teamName);
		$this->view->assign('list', $list);
		
		$this->display();
		
	}

	//▶ 리그 추가
	function popup_addAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$leagueModel = $this->getModel('GameBlockModel');
		$categoryList = $leagueModel->getCategoryList();
		
		$this->view->define("content","content/game_block/popup.add.html");
		
		$this->view->assign('category_list',$categoryList);
		$this->display();
	}

	//▶ 리그 추가 처리
	function addProcessAction() {
		if ( !$this->auth->isLogin() ) {
			$this->redirect("/login");
			exit;
		}
		
		$leagueModel = $this->getModel('GameBlockModel');
		
		$category = $this->request('category');
		$league = $this->request('league_name');

        $leaguelist = $leagueModel->getListByName($league);
        if(count((array)$leaguelist) > 0)
            throw new Lemon_ScriptException("","","script","alert('이미 추가된 리그입니다.');opener.document.location.reload(); self.close();");

		$insertSn = $leagueModel->add($category, $league);
		throw new Lemon_ScriptException("","","script","alert('추가 되였습니다.');opener.document.location.reload(); self.close();");
	}

	//▶ 리그 편집
	function popup_editAction() {
		$this->popupDefine();
	
		if ( !$this->auth->isLogin() ) {
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/game_block/popup.edit.html");
			
		$leagueModel = $this->getModel("GameBlockModel");
		$leagueSn = $this->request("league_sn");
		$mode = trim($this->request("mode"));
				
		if ( $mode == "edit" ) {	
			$leagueSn = $this->request("league_sn");
			$before_kind = $this->request("before_kind");
			$kind = $this->request("league_kind");
			$name = $this->request("league_name");
            $leagueModel->modify($leagueSn, $kind, $name);

			throw new Lemon_ScriptException("","","script","alert('수정 되였습니다.');opener.document.location.reload(); self.close();");
		} else {
			$item = $leagueModel->getListBySn($leagueSn);
				
			$nationCode = $item['nation_sn'];
		}	

		$categoryList = $leagueModel->getCategoryList();
		
		$this->view->assign('category_list',$categoryList);
		$this->view->assign('league_sn', $leagueSn);
		$this->view->assign('item', $item);
		
		$this->display();
	}

	function ajaxLeagueListAction()
	{
		$category = $this->request("category");
		$leagueModel = $this->getModel("GameBlockModel");
		
		if($category!='')
			$where = "kind='".$category."'";
		$leagueModel->ajaxList($where);
	}

	function category_listAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/game_block/category_list.html");
		
		$act = $this->req->request("act");
		$leagueModel = $this->getModel("GameBlockModel");
		
		if($act=="modify")
		{
			$categorySn 	= $this->request("category_sn");
			$categoryName = $this->request("modify_name");
			$leagueModel->modifyCategory($categorySn, $categoryName);
		}
		else if($act=="delete")
		{
			$categorySn	= $this->request("category_sn");
			if($categorySn!="")
				$leagueModel->deleteCategory($categorySn);
		}
		
		$list = $leagueModel->getCategoryList();
		
		$this->view->assign('list', $list);
		
		$this->display();
	}

	function blockFixtureAction() {
		$childSn = empty($this->req->request("child_sn")) ? 0 : $this->req->request("child_sn");
		$blockModel = $this->getModel("GameBlockModel");
		$res = $blockModel->blockFixture($childSn);
		$this->requestGameBlock($childSn);
		echo $res;
	}

	function cancelBlockAction() {
		$childSn = empty($this->req->request("child_sn")) ? 0 : $this->req->request("child_sn");
		$blockModel = $this->getModel("GameBlockModel");
		$res = $blockModel->cancelBlock($childSn);
		$this->requestGameBlockCancel($childSn);
		echo $res;
	}
}

?>