<?
/*
* Index Controller
*/
class IndexController extends WebServiceController 
{
	var $commentListNum = 10;
	
	//▶ 인덱스
	public function indexAction($id='')
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$this->view->define("content","content/content.index.html");
		
		$model = $this->getModel("PartnerModel");
		$bmodel = $this->getModel("BoardModel");
		
		$id 	= $this->auth->getId();		
		$rate = $this->auth->getRate();		
		$lev 	= $this->auth->getLevel();
		$sn 	= $this->auth->getSn();

		$rs 				=	$model->getPartnerMemberTop($id);
		$list 			= $bmodel->getPartnerBoardbyRegdate();
		$partadd 		= $model->getPartnerAdd();
		
		$countmem 	= $rs["countmem"];
		$countmoney = $rs["countmoney"];
		$countday 	= $rs["countday"];
		
		$this->view->assign("id",$id);	
		$this->view->assign("rate",$rate);	
		$this->view->assign("lev",$lev);	
		$this->view->assign("sn",$sn);	
		$this->view->assign("partadd",$partadd);	
		
		$this->view->assign("countmem",$countmem);	
		$this->view->assign("countmoney",$countmoney);	
		$this->view->assign("countday",$countday);	
		$this->view->assign("list",$list);	
		
		$this->display();
	}
		
	//▶ 로그인
	public function loginAction()
	{
		$this->view->define("index","login.html");
		$this->view->print_('index');
	}

	//▶ 로그아웃
	function logoutAction()
	{
		if($this->auth->isLogin())
			session_destroy();
		
		$this->redirect('/');
	}

	public function loginProcessAction()
	{
		$id = trim($this->request("username"));
		$passwd = trim($this->request("pass"));

		$model =  $this->getModel("LoginModel");
		$commonModel = $this->getModel("CommonModel");
		$ip = $commonModel->getIp();
		
		if($id!="" && $passwd!="")
		{
			$md5Pwd=md5($passwd);
			$rs = $model->Partner_login($id, $md5Pwd, 9);	
			
			if( $rs == 2 )
			{
				throw new Lemon_ScriptException("파트너 신청 상태입니다.관리자 접수 통과후 접속가능합니다.","","back","/");
				exit;
			}
			else if( $rs == -1 )
			{
				throw new Lemon_ScriptException("아이디 패스워드를 확인해 주세요.","","back","/");
				exit;
			}
			else if( $rs == 0 )
			{
				throw new Lemon_ScriptException("정지 상태입니다. 관리자 한테 연락하십시오.","","back","/");
				exit;
			}
			else if( $rs == 1 )
			{
				throw new Lemon_ScriptException("","", "go","/");				
				exit();
			}				
		}
		else
		{
			throw new Lemon_ScriptException("오류：잘못된 접근입니다.","","back","/");
			exit;
		}
	}
	
	function joinProcessAction()
	{
		$id 			= trim($this->request("regname"));
		$password 			= trim($this->request("password"));
		$password2 			= trim($this->request("password2"));
		$e_mail 				= trim($this->request("e_mail"));
		$name 				= trim($this->request("n_name"));
		$handphone 			= trim($this->request("handphone"));
		$bank_name 			= $this->request("bank_name");
		$bank_num 			= trim($this->request("bank_num"));
		$bank_username 	= trim($this->request("bank_username"));
	
		$model =  $this->getModel("PartnerModel");
		$cModel = $this->getModel("CommonModel");
		
		if($id==""){
			throw new Lemon_ScriptException("파트너 아이디를 입력하여 주십시오!","","back");
			exit;			
		}
		if(preg_match("/[ '.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$id)){
			throw new Lemon_ScriptException("파트너아이디에 특수문자를 사용할수없습니다!","","back");
			exit;						
		}
		if($password==""){
			throw new Lemon_ScriptException("비밀번호를 입력하여 주십시오!","","back");
			exit;
		}
		if($password2==""){
			throw new Lemon_ScriptException("비밀번호재확인을 하여 주십시오!","","back");
			exit;
		}
		if($password!=$password2){
			throw new Lemon_ScriptException("두번의 비밀번호가 틀립니다.","","back");
			exit;
		}
		if(!preg_match('/^\d*$/',$handphone)){
			throw new Lemon_ScriptException("핸드폰 번호는 숫자만 가능합니다!","","back");
			exit;			
		}
		if(!preg_match('/^\d*$/',$bank_num)){
			throw new Lemon_ScriptException("은행계좌번호는 숫자만 가능합니다.","","back");
			exit;			
		}
				
		$rs = $model->addPartnerJoin($id, $name, 2, $password, $handphone, $e_mail, $bank_name, $bank_num, $bank_username);
		if( count((array)$rs) > 0 )
		{
			throw new Lemon_ScriptException("파트너 신청이 완료 되였습니다.관리자 검토후 정식파트너로 전환하여드립니다.기다려 주십시오......","","go","/");
		//	echo "<script>alert('파트너 신청이 완료 되였습니다.관리자 검토후 정식파트너로 전환하여드립니다.기다려 주십시오......');</script>";
		//	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=/'>";
		}
	}
}
?>
