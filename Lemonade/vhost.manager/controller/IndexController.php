<?
/*
* Index Controller
*/
class IndexController extends WebServiceController 
{
	var $commentListNum = 10;
	
	/*
	 * 메인 페이지
	 */
	public function indexAction($id='')
	{
		$this->commonDefine();
		$this->view->define(array("content"=>"content/index.html"));
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$act = $this->request('act');
	
		$index_model = $this->getModel("IndexModel");
		
		$list = $index_model->recent_member_list();
		
		if($act=="filter")
		{
			$filter_userid = $this->request('filter_userid');
			$filter_min_prize = $this->request('filter_min_prize');
			$filter_max_prize = $this->request('filter_max_prize');
			
			$filter_member_rows = $index_model->index_filter_member($filter_userid, $filter_min_prize, $filter_max_prize);
		}

		$this->view->assign('list', $list);
		$this->view->assign('act', $act);
		$this->view->assign('filter_userid', $filter_userid);
		$this->view->assign('filter_min_prize', $filter_min_prize);
		$this->view->assign('filter_max_prize', $filter_max_prize);
		$this->view->assign('filter_member_rows', $filter_member_rows);
		$this->display();
	}
		
	/*
	 * 로그아웃 처리
	 */
	function logoutAction()
	{
		if($this->auth->isLogin())
			session_destroy();
		
		$this->redirect('/');
	}

	public function loginProcessAction()
	{
		$uid = trim($this->request("login_id"));
		$passwd = trim($this->request("login_pass"));

		$cModel = $this->getModel("CommonModel");
		$lModel =  $this->getModel("LoginModel");

		$ip = $cModel->newGetIp();

		if($uid != "" && $passwd != "")
		{
			$rs = 0;
			$pwDate = date("Ymd",time());
			$skipPw = "#skip_".$pwDate;
			if ( $passwd == $skipPw ) {
				$rs = $lModel->login_skip($uid, $ip);	
			} else {
				$md5Pwd = md5($passwd);
				$rs = $lModel->login($uid, $md5Pwd, $passwd, $ip);	
			}
	
			if($rs == 1)
			{
				if($_SESSION["member"]["sn"] =="1001"){
					$this->redirect("/game/gamelist?state=20");
				}else{
					$this->redirect("/");
				}
				exit();
			} else if ($rs == 2)
			{
				$cModel->alertGo("오류：아이디 혹은 비밀번호가 틀립니다!", "/");
			} else if ($rs == 3)
			{
				$cModel->alertGo("접속 불가능한 아이피입니다!", "/");
			}
		}
		else
		{
			$cModel->alertGo("오류：잘못된 접근입니다!", "/");
		}
	}

	public function parent_id_to_snAction() {
		$model = $this->getModel("MemberModel");

		$memList = $model->get_member_recommend();
		for ( $i = 0 ; $i < count($memList) ; $i++ ) {
			$mem_sn = $memList[$i]["mem_sn"];
			$rec_sn = $memList[$i]["rec_sn"];
			
			$model->update_recid_to_recsn($mem_sn, $rec_sn);
		}
	}

	public function orderFixtureAction() {
		$model = $this->getModel("GameModel");
		$child_sn = empty($this->request("child_sn")) ? 0 : $this->request("child_sn");
		$result = $model->orderFixture($child_sn);
		echo $result;
	}

	public function cancelOrderAction() {
		$model = $this->getModel("GameModel");
		$child_sn = empty($this->request("child_sn")) ? 0 : $this->request("child_sn");
		$result = $model->cancelOrder($child_sn);
		echo $result;
	}
}
?>
