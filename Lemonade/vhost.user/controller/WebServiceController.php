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
	public function commonDefine($type = '', $s_type = 0)
	{
		
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            if(strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ",") !== false)
            {
                header("Location:http://www.yahoo.com");
            }
        }

		// 오늘 경기정보 가져오기
        $this->passGameCount();

		//-> 페이지로딩시간 저장 (동접체크를 위해)
		if ( $this->auth->getSn() > 0 ) {
			$memberModel = Lemon_Instance::getObject("MemberModel", true);
			$memberModel->LoadingTimeSave($this->auth->getSn());
		}

		$ConfigModel=Lemon_Instance::getObject("ConfigModel", true);
		$rs = $ConfigModel->getAdminConfigRow();
		$ads = $rs['ad'];

		if($rs['maintain']==2)
		{
			session_destroy();
			$this->view->define("index","layout/layout.iframe.html");
			$this->view->define("index","content/maintain.html");
			$this->view->assign("maintain_ment", $rs['maintain_ment']);		
		}
		// xssClean
		$this->req->xssClean();
		
		// 권한
		$this->setAuthentication($auth);
		
		// 중복로그인 체크
		$this->doubleLoginCheck();
		
		//유저정보
		$this->displayMemberInfoBox($type);
		
		// 헤더/푸터
		$this->view->define("index","layout/layout.sub.html");
		
		if($type=="index") {
			$this->view->define(array("header"=>"header/header.html", "footer" => "footer/bottom.html", /*"top" => "header/top.html",*/ "right" => "right/right.html", "left" => "left/left_index.html"));
		} else if($type=="join") {
			$this->view->define(array("header"=>"header/header.html", "footer" => "footer/bottom.html", "left" => "left/left_index.html", "right" => "right/right.html"));
		} else if($type=="poker") {
			$this->view->define(array("header"=>"header/header.html", "footer" => "footer/bottom.html", /*"top" => "header/top.html",*/ "right" => "right/right_poker.html"));
		} else if($type=="slot") {
			$this->view->define(array("header"=>"header/header.html", "footer" => "footer/bottom.html", /*"top" => "header/top.html",*/ "right" => "right/right_slot.html"));
		} else if($type=="event") {
			$this->view->define(array("header"=>"header/header.html", "footer" => "footer/bottom.html", /*"top" => "header/top.html",*/ "left" => "left/left_index.html", "right" => "right/right_event.html"));
		} else if($type=="login") {
			$this->view->define(array("header"=>"header/header.html"));
		} else if($type=="virtualgame") {
			$this->view->define(array("header"=>"header/header.html", "footer" => "footer/bottom.html", "right" => "right/right_sports.html"));
		} else if($type=="casino") {
			$this->view->define(array("header"=>"header/header.html", "footer" => "footer/bottom.html", /*"top" => "header/top.html",*/ "right" => "right/right_poker.html"));
		} else if($type=="type") {
			$this->view->define(array("header"=>"header/header.html", "footer" => "footer/bottom.html", /*"top" => "header/top.html",*/ "left" => "left/left_index.html", "right" => "right/right.html"));
		} else if($type=="graph") {
			$this->view->define(array("header"=>"header/header.html", "footer" => "footer/bottom.html", /*"top" => "header/top.html",*/ "left" => "left/left_index.html", "right" => "right/right.html"));
		} else if($type=="winlose" or $type=="handi" or $type=="special") {
			//$this->view->define("index","layout/layout.sports.html");
			$this->view->define(array("header"=>"header/header.html", "footer" => "footer/bottom.html", /*"top" => "header/top.html",*/ "left" => "left/left.html", "right" => "right/right_sports.html"));
		} else if($type=="abroad") {
			//$this->view->define("index","layout/layout.sports.html");
			$this->view->define(array("header"=>"header/header.html", "footer" => "footer/bottom.html", /*"top" => "header/top.html",*/ "left" => "left/left.html", "right" => "right/right_sports.html"));
		}  else if($type=="live") {
			//$this->view->define("index","layout/layout.sports.html");
			$this->view->define(array("header"=>"header/header.html", "footer" => "footer/bottom.html", /*"top" => "header/top.html",*/ "left" => "left/left.html", "right" => "right/right_sports.html"));
		} else if($type=="ladder") {
			if($this->isMobile() == "pc") {
				$this->view->define(array("header"=>"header/header.html", "footer" => "footer/bottom_mini.html", /*"top" => "header/top.html",*/ "left" => "left/left_minigame.html", "right" => "right/right.html"));
			} else {
				$this->view->define(array("header"=>"header/header.html", "footer" => "footer/bottom_mini.html"));
			}
		} else if($type=="ladder_graph") {
			$this->view->define("index","layout/layout.sadari_graph.html");
			$this->view->define(array("content"=>"content/sadari_result_graph.html"));
		} else if($type=="ladder_graph_aladin" or $type=="ladder_graph_powersadari" or $type=="ladder_graph_kenosadari"
                  or $type == 'ladder_graph_2dari' or $type == 'ladder_graph_3dari') {
            $this->view->define("index","layout/layout.sadari_graph.html");
            $this->view->define(array("content"=>"content/result_graph.html"));
        } else if($type=="game20_graph") {
			$this->view->define("index","layout/layout.sadari_graph.html");
			$this->view->define(array("content"=>"content/game20_result_graph.html"));
		} else if($type=="ladder_result_powerball") {
			$this->view->define("index","layout/layout.sadari_graph.html");
			$this->view->define(array("content"=>"content/powerball_result.html"));
		} else if($type=="ladder_graph_fx") {
            $this->view->define("index","layout/layout.sadari_graph.html");
            $this->view->define(array("content"=>"content/fx_result_graph.html"));
        } else {
			$this->view->define(array("header"=>"header/header.html", "footer" => "footer/bottom.html", "right" => "right/right.html", "left" => "left/left.html"));
		}

		$this->layoutDefine($type);
		
		//모바일, pc 접속 구분
		$mobileArray = array("Android", "iPhone", "Apple", "BlackBerry", "Windows CE", "LG", "SAMSUNG", "MOT", "SonyEricsson");
		$userAgent = 'pc';
		
		foreach ($mobileArray as $key=> $value)
		{
			if(preg_match("/{$value}/", $_SERVER['HTTP_USER_AGENT'])) $userAgent = 'mobile';	
		}
		
		$configModel = $this->getModel("ConfigModel");
		$ad = $configModel->getAdminConfigField("ad");
		$jackpot = $configModel->getJackpot();
		
		$live_model = $this->getModel("LiveGameModel");
		$live_game_count = $live_model->getLiveGameCount();
		
		$conf = Lemon_Configure::readConfig('config');
		if($conf['site']!='')
		{
			$upload_url	 = $conf['site']['upload_url'];
		}
		
		$gameType = $this->req->request("game");
		$request_url = $_SERVER["REQUEST_URI"];

		$style_type = 0; // 10bet 디자인

		if($gameType == "abroad" || $gameType == "live" || strpos($request_url, '/betting_list') !== false)
			$style_type = 1; // bet38 디자인

		$checkAgent = $this->isMobile();

		$this->view->assign("ad", $ad);
		$this->view->assign('jackpot', $jackpot);
		$this->view->assign("user_agent", $userAgent);		
		$this->view->assign("UPLOAD_URL", $upload_url);
		$this->view->assign("live_game_count", $live_game_count);
		$this->view->assign("style_type",  $style_type);
		$this->view->assign('ads', $ads);
		$this->view->assign('checkAgent', $checkAgent);
	}
	
	/*
	* 팝업용 포함 파일들
	*/
	public function popupDefine($type='')
	{
		// 권한
		$this->setAuthentication($auth);
		
		// 중복로그인 체크
		$this->doubleLoginCheck();
		
		// 헤더/푸터
		$this->view->define("index","layout/layout.popup.html");
	}
	
	/*
	* 전체 틀 공통 포함 파일들
	*/
	public function iframeDefine($type, $auth)
	{
		if($auth==true)
		{
			// 권한
			$this->setAuthentication($auth);
			
			// 중복로그인 체크
			$this->doubleLoginCheck();
		}
		
		$this->view->define("index","layout/layout.iframe.html");
		$this->view->define(array("header"=>"header/header.iframe.html","footer"=>"footer/footer.iframe.html"));
		$this->layoutDefine($type);
	}
	
	function menuSetting($menu)
	{
		$this->view->assign('submenu', $menu);
	}

	/**
	 * 로그인 표시 처리
	 */
	public function setAuthentication($auth) 
	{
		$this->auth = Lemon_Instance::getObject("Lemon_Auth");
		
		$this->view->assign('sess_member_id', $this->auth->getId());
		$this->view->assign('sess_member_name', $this->auth->getName());
		$this->view->assign('sess_member_level', $this->auth->getLevel());
		$this->view->assign('sess_member_login', $this->auth->isLogin());
		$this->view->assign('sess_member_super', $this->auth->isSuper());
	}
	
	public function displayMemberInfoBox($type='')
	{
		$sn 			= $this->auth->getSn();
		$uid			= $this->auth->getId();
		$nick			= $this->auth->getName();
		
		if($sn!='' && $uid!='')
		{
			$mModel 		= $this->getModel("MemberModel");
			$memoModel 		= $this->getModel("MemoModel");
			$eModel			= $this->getModel("EtcModel");
			$gModel			= $this->getModel("GameModel");
			$cModel			= $this->getModel("ConfigModel");
			$cartModel 		= $this->getModel("CartModel");
			
			$totalBetCount 	= $cartModel->getMemberTotalBetCount($sn);
			$ingBetCount 		= $cartModel->getMemberIngBetCount($sn);
			$newMemoList		= $memoModel->getMemberNewMemoList($uid);
			$newMemoCount = 0;
			if(is_array($newMemoList))
				$newMemoCount   = count($newMemoList);//$memoModel->getMemberNewMemoTotal($uid);

			// if ( $newMemoCount > 0 and !strpos($_SERVER["REQUEST_URI"],"member/memolist") ) {
			// 	echo "<html><head><meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\" /><script>alert('잃지 않은 쪽지가 있습니다. 쪽지를 읽어주세요.');</script></head></html>";
			// 	$this->redirect("/member/memolist");
			// }

			$rs 						= $mModel->getMemberRow($sn);
			
			$cash						= $rs['g_money'];
			$mileage 				= $rs['point'];
			$level					= $rs['mem_lev'];
			$levelName			= $eModel->getLevelName($level);

            $rs                 = $cartModel->getBettingInfo($sn);
            $now_bet_count = 0;
            $bet_money = 0;
            $profit_money = 0;

            if(isset($rs["bet_count"]))
                $now_bet_count = $rs["bet_count"];

            if(isset($rs["bet_money"]))
                $bet_money = $rs["bet_money"];

            if(isset($rs["profit_money"]))
                $profit_money = $rs["profit_money"];

			$telegramID = $mModel->getTelegramID();

			$kakaoID = $mModel->getKakaoID();

			$betCancelCnt = $mModel->getBetCancelCnt($sn);

			$this->view->assign("nick", $nick);
			$this->view->assign("new_memo_list", $newMemoList);
			$this->view->assign("new_memo_count", $newMemoCount);
			$this->view->assign("levelName", $levelName);
			$this->view->assign("level", $level);
			$this->view->assign("cash", $cash);
			$this->view->assign("mileage", $mileage);
			$this->view->assign("totalBetCount", $totalBetCount);
			$this->view->assign("ingBetCount", $ingBetCount);
            $this->view->assign("bet_count", $now_bet_count);
            $this->view->assign("bet_money", $bet_money);
            $this->view->assign("profit_money", $profit_money);
			$this->view->assign("member_sn", $sn);
			$this->view->assign("telegramID", $telegramID);
			$this->view->assign("kakaoID", $kakaoID);
			$this->view->assign("betCancelCnt", $betCancelCnt);

            //***20150613
            $beginDate 	= Trim($this->req->request("begin_date"));
            $endDate 		= Trim($this->req->request("end_date"));
        
            $mModel = Lemon_Instance::getObject("MemberModel",true);
            $gameListModel = Lemon_Instance::getObject("GameListModel",true);
            $cModel = Lemon_Instance::getObject("CartModel",true);
            $sn = $this->auth->getSn();

            $queryBeginDate="";
            $queryEndDate="";
            if($beginDate!="" && $endDate!="")
            {
                $queryBeginDate = $beginDate." 00:00:00";
                $queryEndDate		= $endDate." 23:59:59";
            }

    //		$total= $gameListModel->getBettingListTotal($sn, -1,  0, $queryBeginDate, $queryEndDate); 	$state = -1; // 전체 배팅내역
            $total= $gameListModel->getBettingListTotal($sn,  0,  0, $queryBeginDate, $queryEndDate); 		$state = 0;	 // 게임진행중 배팅내역
            $page_act = "begin_date=".$beginDate."&end_date=".$endDate."&sort_type=".$sortType;

            $pageMaker = $this->displayPage($total, 10, $page_act);
            //$list = $gameListModel->getBettingList($sn, $pageMaker->first, $pageMaker->listNum, $chk_folder, $state, $queryBeginDate, $queryEndDate, 3);

            $this->view->assign("betting_list",  $list);
            //***20150613
		}
	}	
    
    public function passGameCount() {
		$gameListModel = Lemon_Instance::getObject("GameListModel",true);
        $infoGameCount = $gameListModel->getGameCount();
        $today_count = $gameListModel->getTodayGameCount();
		// $nations = $gameListModel->getTodayNations();
		// $todayGameInfo = [];
		// for($i = 0; $i < count($nations); $i++) {
		// 	$todayGameInfo[$i]['nation_sn'] = html_entity_decode($nations[$i]["sn"]);
		// 	$todayGameInfo[$i]['nation_name'] = html_entity_decode($nations[$i]["name"]);
		// 	$todayGameInfo[$i]['nation_cnt'] = $nations[$i]["cnt"];
		// 	$todayGameInfo[$i]['nation_img'] = html_entity_decode($nations[$i]["lg_img"]);
		// 	$todayGameInfo[$i]['sport_name'] = html_entity_decode($nations[$i]["sport_name"]);
		// 	$todayGameInfo[$i]['items'] = $gameListModel->getTodayLeagues($nations[$i]["sn"], $nations[$i]["sport_name"]);
		// }
        $this->view->assign("game_count_info",  $infoGameCount);
        $this->view->assign("today_count",  $today_count);
		// $this->view->assign("today_game_info",  $todayGameInfo);
    }
	/*
	 * 중복 로그인 체크 - 세션삭제
	 */
	public function doubleLoginCheck()
	{
		if($this->auth->isLogin())
		{
			$model = Lemon_Instance::getObject("MemberModel", true);
			$rs = $model->getById($this->auth->getId());
			
			if($rs['uniqid']!=$_SESSION['member']['uniqid'] || $rs['mem_status']=='S')
			{
				session_destroy();
				$this->redirect('/');
			}
			else 
			{ 
				
			}
		}
	}
	
	public function introAction()
	{
		$this->view->define("index","content/intro.html");
		
		$this->display();
	}
	
	public function loginAction()
	{
		$EtcModel=Lemon_Instance::getObject("EtcModel", true);
		$remoteIp = $_SERVER["HTTP_X_FORWARDED_FOR"];

		if(intVal($EtcModel->isKillIp($remoteIp))>=1)
		{
			session_destroy();
			header("Location:http://www.google.com");
			//exit;
		}

		//모바일페이지 포워딩
		$domain = $_SERVER['HTTP_HOST'];
		$conDomain = preg_match('/gadget.com/', $_SERVER['HTTP_HOST']);
		$case='';

		$ConfigModel=Lemon_Instance::getObject("ConfigModel", true);
		$rs = $ConfigModel->getAdminConfigRow();
		
		$this->view->assign("con_domain", $conDomain);
		
		if($rs['maintain']==2 && $_SERVER["REMOTE_ADDR"]!='121.132.114.18')
		{
			$this->view->define("index","content/maintain.html");
		}
		else
        {
            //$this->view->define("index","content/login.html");
			//$this->view->define("index","content/index.html");
			$this->redirect('/');
        }

		//-> 추천인코드 없이 가입.
		//$_SESSION['partnerSn'] = "0";
		//$this->view->assign('joinSkip', '1');

        $etcModel = $this->getModel("EtcModel");
        $popupList = $etcModel->getLoginPopup();
        $this->view->assign('popup_list', $popupList);

        $this->view->print_('index');
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

				/*		
		$image = $_FILES["picture"]['tmp_name'];
		$filesize = filesize($image);

		// 파일 확장자 체크
		$ext = strtolower(substr($_FILES["picture"]['name'],strrpos($_FILES["picture"]['name'],'.')+1));
		if($ext!='jpg' && $ext!='gif'){			
			throw new Lemon_ScriptException("Error : 업로드실패","업로드 할 수 없는 확장자입니다",'back');
			exit;
		}
		*/
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
	
	function displayPage($total, $pageNum=10, $act='')
	{
		$page 	 = !($this->request('page'))?'1':intval($this->request('page'));
		$perpage = !($this->request('perpage'))?$pageNum :intval($this->request('perpage'));
		$pageMaker 	= Lemon_Instance::getObject("Lemon_Page");
		$pageMaker->setListNum($pageNum);
		$pageMaker->setPageNum(10);
		$pageMaker->setPage($page, $total);
		$pagelist	= $pageMaker->pageList($act);
		
		$this->view->assign('total', $total);
		$this->view->assign('page', $page);
		$this->view->assign('perpage', $perpage);
		$this->view->assign('pagelist', $pagelist);
		
		return $pageMaker;
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
	
	function request0($param, $default)
	{
		return ($this->req->request($param))?$this->req->request($param):$default;
	}
	
	function echo0($strText)
	{
		echo $strText."<br>";
	}
	
	//모바일, pc 접속 구분	
	public function isMobile()
	{
		$mobileArray = array("Android", "iPhone", "BlackBerry", "Windows CE", "LG", "SAMSUNG", "MOT", "SonyEricsson");
		$userAgent = 'pc';
		
		foreach ($mobileArray as $key=> $value)
		{
			if(preg_match("/{$value}/", $_SERVER['HTTP_USER_AGENT'])) $userAgent = 'mobile';	
		}

		return $userAgent;
	}


	// 전화번호인증 curl
	function curl_send($checkCode = "", $sender = "", $receiver = "") {
		/****************** 인증정보 시작 ******************/
		$sms_url = "https://apis.aligo.in/send/"; // 전송요청 URL
		$sms['user_id'] = "show123123"; // SMS 아이디
		$sms['key'] = "zq412i09m5kqs8pmey2c8n4pzs5ctnmc";//인증키
		/****************** 인증정보 끝 ********************/

		/****************** 전송정보 설정시작 ****************/
		$_POST['msg'] = '고객님, 안녕하세요. 인증코드입니다. [' . $checkCode . ']'; // 메세지 내용 : euc-kr로 치환이 가능한 문자열만 사용하실 수 있습니다. (이모지 사용불가능)
		$_POST['receiver'] = $receiver; // 수신번호
		$_POST['destination'] = ''; // 수신인 %고객명% 치환
		$_POST['sender'] = $sender; // 발신번호
		$_POST['rdate'] = ''; // 예약일자 - 20161004 : 2016-10-04일기준
		$_POST['rtime'] = ''; // 예약시간 - 1930 : 오후 7시30분
		$_POST['testmode_yn'] = 'N'; // Y 인경우 실제문자 전송X , 자동취소(환불) 처리
		$_POST['subject'] = '폰번호 인증'; //  LMS, MMS 제목 (미입력시 본문중 44Byte 또는 엔터 구분자 첫라인)
		// $_POST['image'] = '/tmp/pic_57f358af08cf7_sms_.jpg'; // MMS 이미지 파일 위치 (저장된 경로)
		$_POST['msg_type'] = 'SMS'; //  SMS, LMS, MMS등 메세지 타입을 지정
		// ※ msg_type 미지정시 글자수/그림유무가 판단되어 자동변환됩니다. 단, 개행문자/특수문자등이 2Byte로 처리되어 SMS 가 LMS로 처리될 가능성이 존재하므로 반드시 msg_type을 지정하여 사용하시기 바랍니다.
		/****************** 전송정보 설정끝 ***************/

		$sms['msg'] = stripslashes($_POST['msg']);
		$sms['receiver'] = $_POST['receiver'];
		$sms['destination'] = $_POST['destination'];
		$sms['sender'] = $_POST['sender'];
		$sms['rdate'] = $_POST['rdate'];
		$sms['rtime'] = $_POST['rtime'];
		$sms['testmode_yn'] = empty($_POST['testmode_yn']) ? '' : $_POST['testmode_yn'];
		$sms['title'] = $_POST['subject'];
		$sms['msg_type'] = $_POST['msg_type'];

		/*****/
		$host_info = explode("/", $sms_url);
		$port = $host_info[0] == 'https:' ? 443 : 80;

		$oCurl = curl_init();
		curl_setopt($oCurl, CURLOPT_PORT, $port);
		curl_setopt($oCurl, CURLOPT_URL, $sms_url);
		curl_setopt($oCurl, CURLOPT_POST, 1);
		curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($oCurl, CURLOPT_POSTFIELDS, $sms);
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
		$ret = curl_exec($oCurl);
		curl_close($oCurl);

		$resArray = json_decode($ret); //결과배열

		return $resArray;
	}

}
?>