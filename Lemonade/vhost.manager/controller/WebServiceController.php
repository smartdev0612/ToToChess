<?
/*
* WebService Controller
*/

class WebServiceController extends Lemon_Controller 
{
	var $auth  = "";
	
	public function notfound()
	{
		echo "not found";
	}

	public function display() 
	{
		$this->view->print_('index');
	}
	
	/*
	* 각 Controller별 Custom
	*/
	public function layoutDefine($type='')
	{
	}
	
	/*
	* 전체 틀 공통 포함 파일들
	*/
	public function commonDefine($type='')
	{
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            if(strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ",") !== false)
            {
                header("Location:http://www.yahoo.com");
            }
        }

		//제한 IP
		//$this->adminmemberchk();
		
		// 권한
		$this->setAuth($auth);
		
		// 중복로그인 체크
		$this->doubleLoginCheck();
		
		$moneyModel = $this->getModel("MoneyModel");
		$cartModel = $this->getModel("CartModel");
		$matgoModel = $this->getModel("MatgoModel");

		$logo = $this->request('logo');
        if($logo=='')
            $logo = $this->logo;

        $model = $this->getModel("ConfigModel");
        $miniSetting = $model->getMiniConfigRow("*", "", $logo);
		
		$todayChargeTotal = $moneyModel->getTodayTotalCharge();
		$todayExchangeTotal = $moneyModel->getTodayTotalExchange();
		$totalmemberMoney		= $moneyModel->totalmemberMoney();
		$totalmemberMileage	= $moneyModel->totalmemberMileage();
		
		
		$rsi = $cartModel->getTotalBetMoney('','','','', '', 0);
		$currentBetting = $rsi['total_betting'];
		
		$expected_prize = $cartModel->expected_prize();
		
		$this->view->assign('today_charge', $todayChargeTotal);
		$this->view->assign('today_exchange', $todayExchangeTotal);
		$this->view->assign('totalmemberMoney', $totalmemberMoney);
		$this->view->assign('totalmemberMileage', $totalmemberMileage);
		$this->view->assign('currentBetting', $currentBetting);
		$this->view->assign('expected_prize', $expected_prize);
		$this->view->assign('miniSetting', $miniSetting);
		
		// 헤더/푸터
		$this->view->define("index","layout/layout.html");

		//-> 관리자 시퀀스가 1000 이상이면 뷰모드관리자
		if ( $this->auth->getSn() > 1000 ) {
			$this->view->define(array("header"=>"header/header.html", "top" => "header/top.html", "footer" => "footer/footer.html", "left" =>"left/left_view.html", "right" => "right/right.html", "right_normal" => "right/right_normal.html"));
		} else {
			$this->view->define(array("header"=>"header/header.html", "top" => "header/top.html", "footer" => "footer/footer.html", "left" =>"left/left.html", "right" => "right/right.html", "right_normal" => "right/right_normal.html"));
		}
	}
	
	/*
	* 팝업용 포함 파일들
	*/
	public function popupDefine($type='')
	{
		// 권한
		$this->setAuth($auth);
		
		// 중복로그인 체크
		$this->doubleLoginCheck();

		// 헤더/푸터
		$this->view->define("index","layout/layout.popup.html");
		$this->view->define(array("header"=>"header/header.html"));
	}
	
	/*
	* 전체 틀 공통 포함 파일들
	*/
	public function iframeDefine()
	{
		// 권한
		$this->setAuth($auth);
			
		// 중복로그인 체크
		$this->doubleLoginCheck();
		
		$this->view->define('index', 'layout/layout.iframe.html');

		//-> 관리자 시퀀스가 1000 이상이면 뷰모드관리자
		if ( $this->auth->getSn() > 1000 ) {
			$this->view->define(array('header' => 'header/header.html', 'top' => 'header/top.html', 'footer' => 'footer/footer.html', 'left' =>'left/left_view.html'));
		} else {
			$this->view->define(array('header' => 'header/header.html', 'top' => 'header/top.html', 'footer' => 'footer/footer.html', 'left' =>'left/left.html'));
		}
		
		$this->view->assign('footer', 'footer/footer.html');
	}
	
	function menuSetting($menu)
	{
		$this->view->assign('submenu', $menu);
	}

	/**
	 * 로그인 표시 처리
	 */
	public function setAuth($auth) 
	{
		$this->auth = Lemon_Instance::getObject("Lemon_Auth");
		
		$this->view->assign('sess_member_id', $this->auth->getId());
		$this->view->assign('sess_member_name', $this->auth->getName());
		$this->view->assign('sess_member_level', $this->auth->getLevel());
		$this->view->assign('sess_member_login', $this->auth->isLogin());
		$this->view->assign('sess_member_super', $this->auth->isSuper());
	}
	
	/*
	 * 중복 로그인 체크 - 세션삭제
	 */
	public function doubleLoginCheck()
	{
		if($this->auth->isLogin()){
			$model = Lemon_Instance::getObject("MemberModel", true);
			$rs = $model->getById($this->auth->getId());
			
			if($rs['uniqid']!=$_SESSION['member']['uniqid'])
			{
				session_destroy();
				$this->redirect('/');
			}
		}
	}

	/*
	 * ajax 공통 헤더
	 */
	function setAjaxHeader()
	{
		header("Content-Type: text/html; charset=UTF-8");
		header("Cache-Control: no-cache");
		header("Pragma: no-cache");
	}

	/*
	** 파일 업로드 
	*/
	public function getFile($upfile, $dbfile, $fsize='' ) 
	{		
		if($_FILES[$upfile]["name"]!="") 
		{			
			$conf = Lemon_Configure::readConfig('path');

			$tmpfile = $conf[$upfile]."/". $dbfile ;
			if (file_exists($tmpfile)) 
			{
				@unlink ($tmpfile) ;
			}			
			$file_name = $upfile .'_'. time(). '_'. rand(1000,9999) ;

			$fu = new Lemon_FileUpload($_FILES[$upfile], $conf[$upfile]."/". $file_name  );
			// setFile($srcFile,$saveFile) ;
			$fu->setOverwrite();
			$fu->upload();

			return $file_name.".".$fu->getFileExt() ;
			//$update['filenm'] = $_FILES["filenm"]["name"] ;
			//$update['files'] = str_replace( $_SERVER['DOCUMENT_ROOT'], "", $fu->getSaveFile() ) ; // 
		}
		else 
		{
			return $dbfile ;
		}
	}
	
	/* 권한 체크 */
	function loginPermit($level=6) 
	{ 		
		if(!$this->auth->isLogin())
		{
			$this->redirect('/logout');
			exit;
		} 

		if ( $this->auth->getLevel() > $level ) 
		{
			throw new Lemon_ScriptException("w. 잘못된 접근입니다..");
			exit;
		}
	}
	
	/* model help function */
	function getModel($model)
	{
		return Lemon_Instance::getObject($model,true);
	}
	
	function request($param, $default='')
	{
		if($default!=''){
			return ($this->req->request($param))?$this->req->request($param):$default;
		}
		return $this->req->request($param);
	}
	
	function displayPage($total, $pageNum=10, $act='')
	{
		$page 	 = !($this->request('page'))?'1':intval($this->request('page'));
		$perpage = !($this->request('perpage'))?$pageNum :intval($this->request('perpage'));
		$pageMaker 	= Lemon_Instance::getObject("Lemon_Page");
		$pageMaker->setListNum($perpage);
		$pageMaker->setPageNum(10);
		$pageMaker->setPage($page, $total);
		$pagelist 	= $pageMaker->pageList($act);
	
		$this->view->assign('total', $total);
		$this->view->assign('perpage', $perpage);
		$this->view->assign('pagelist', $pagelist);
		$this->view->assign('page', $page);
		
		return $pageMaker;
	}
	
	function post($param)
	{
		return $this->req->post($param);
	}
	
	function request0($param, $default)
	{
		return ($this->req->request($param))?$this->req->request($param):$default;
	}
	
	function alertRedirect($message, $url)
	{
		$str = "<script language='javascript'>" ;
		$str = $str . "alert('" . $message . "');" ;
		$str = $str . "</script>";
		$str = $str . "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$url."'>";
		echo $str;
	}
	
	function alert0($str)
	{
		header("Content-Type: text/html; charset=UTF-8");
		echo "<script>alert('".$str."');</script>";
	}
	
	function echo0($strText)
	{
		echo $strText."<br>";
	}
	
	//관리자 IP 확인 후 실행
	function adminMemberChk()
	{
		$remoteIp = $_SERVER["HTTP_X_FORWARDED_FOR"];
		
		/*
		if($remoteIp!='49.159.22.146'  && $remoteIp!='110.4.80.218'  && $remoteIp!='180.210.38.105' && $remoteIp!='124.217.210.74' && $remoteIp!='103.225.152.251' && $remoteIp!='1.164.112.98' && $remoteIp!='110.4.81.107')
		{
			session_destroy();
			header("Location:http://www.google.com");
		}
		*/

	}
	
	public function loginAction()
	{
		$this->adminMemberChk();
		$this->view->define("index","login.html");
		$this->view->print_('index');
	}

	public function generateRandomSn() {
		$now = strtotime("now");
		$startDate = strtotime("2019-03-14 09:06:00");
		$range = $now - $startDate;
		$rand = rand(0, $range);
		$rand_number = $range + intval($rand / 10);
		return $rand_number;
	}

	// 환수율 적용
	public function requestChangeMarketRate($strValue) {
		$strUrl = "http://127.0.0.1:3001/api/admin?nCmd=1&strValue=$strValue";
		file_get_contents($strUrl);
	}

	// 게임등록
	public function requestGameUpload() {
		$strUrl = "http://127.0.0.1:3001/api/game?nCmd=1";
		file_get_contents($strUrl);
	}
	
	// 배팅정보 수정
	public function requestRemoveBettingInfo($sn) {
		$values = ["sn" => $sn];
		$strValue = json_encode($values);
		$strUrl = "http://127.0.0.1:3001/api/betting?nCmd=1&strValue=" . $strValue;
		file_get_contents($strUrl);
	}

	public function requestRemoveBettingNo($bettingNo) {
		$values = ["betting_no" => $bettingNo];
		$strValue = json_encode($values);
		$strUrl = "http://127.0.0.1:3001/api/betting?nCmd=2&strValue=" . $strValue;
		file_get_contents($strUrl);
	}

	// 팀 수정
	function updateServerTeam($teamSn = 0, $team_api_id = 0, $sport_sn, $nation_sn, $team_name, $team_name_en, $team_img) {
		$values = ["sn" => $teamSn, "api_sn" => $team_api_id, "name" => $team_name, "name_en" => $team_name_en, "team_img" => $team_img, "sport_sn" => $sport_sn, "nation_sn" => $nation_sn];
		$strValue = urlencode(json_encode($values));
		$strUrl = "http://127.0.0.1:3001/api/team?nCmd=1&strValue=$strValue";
		file_get_contents($strUrl);
	}

	function deleteServerTeam($sn = 0) {
		$values = ["sn" => $sn];
		$strValue = json_encode($values);
		$strUrl = "http://127.0.0.1:3001/api/team?nCmd=2&strValue=$strValue";
		file_get_contents($strUrl);
	}

	function deleteServerTeams($sn = "") {
		$values = ["sn" => $sn];
		$strValue = json_encode($values);
		$strUrl = "http://127.0.0.1:3001/api/team?nCmd=3&strValue=$strValue";
		file_get_contents($strUrl);
	}

	// 리그 수정
	function updateServerLeague($sn = 0, $lsports_league_sn = 0, $nation_sn = 0, $sport_sn = 0, $name = "", $name_en = "", $league_img = "", $is_use = 0) {
		$values = ["sn" => $sn, "lsports_league_sn" => $lsports_league_sn, "nation_sn" => $nation_sn, "sport_sn" => $sport_sn, "name" => $name, "name_en" => $name_en, "league_img" => $league_img, "is_use" => $is_use];
		$strValue = urlencode(json_encode($values));
		$strUrl = "http://127.0.0.1:3001/api/league?nCmd=1&strValue=$strValue";
		file_get_contents($strUrl);
	}

	function deleteServerLeague($sn = 0) {
		$values = ["sn" => $sn];
		$strValue = json_encode($values);
		$strUrl = "http://127.0.0.1:3001/api/league?nCmd=2&strValue=$strValue";
		file_get_contents($strUrl);
	}

	function deleteServerLeagues($sn = "") {
		$values = ["sn" => $sn];
		$strValue = json_encode($values);
		$strUrl = "http://127.0.0.1:3001/api/league?nCmd=3&strValue=$strValue";
		file_get_contents($strUrl);
	}


}
?>