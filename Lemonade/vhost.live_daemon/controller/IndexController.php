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

		$ip = $cModel->getIp();
		
		if($uid!="" && $passwd!="")
		{
			$md5Pwd = md5($passwd);
			$rs = $lModel->login($uid, $md5Pwd, $passwd, $ip);	
	
			if(true==$rs)
			{
				$this->redirect("/");
				exit();
			}
			else
			{
				$cModel->alertGo("오류：아이디 혹은 비밀번호가 틀립니다!", "/");
			}
		}
		else
		{
			$cModel->alertGo("오류：잘못된 접근입니다!", "/");
		}
	}
}
?>
