<?
/*
* 세션에 들어있는 로긴 정보를 가져옴
*/

class Lemon_Auth 
{
	public $rSession = '';

	function __construct()
	{
		$this->rSession = $_SESSION;
		$noticeHtml = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
										<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">
											<head>
												<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
												<link rel=\"shortcut icon\" href=\"/img/favicon.ico\">
												<link rel=\"stylesheet\" type=\"text/css\" href=\"/new_css/index.css\"/>
												<link rel=\"stylesheet\" type=\"text/css\" href=\"/new_css/reset.css\"/>
												<title> 스포츠배팅 NO.1</title>
											</head>
											<body>
												서버 점검중입니다. 불편을 드려서 죄송합니다.
											</body>
										</html>";

		$ipCheckList = $this->matchIpAddress();
		//-> 사이트 전체 접근 확인. (블럭아이피 확인)
		if ( $ipCheckList["block"] > 0 ) {
			echo $noticeHtml;
			exit;
		}
		//-> 관리자 접근 가능 확인.
		if ( strlen($_SERVER["DOCUMENT_ROOT"]) != strlen(str_replace("vhost.manager","",$_SERVER["DOCUMENT_ROOT"])) ) {
			if ( strlen($_SERVER["SERVER_NAME"]) != strlen(str_replace("manager.","",$_SERVER["SERVER_NAME"])) ) {
				if ( $ipCheckList["in"] == 0 ) {
					echo $noticeHtml;
					exit;
				}
			}
		}
	}

	//-> 접근 아이피 확인. (2016-08-17)
	function matchIpAddress() {
		//-> 접근허용아이피, 전체(000.000.000.000) 또는 대역(000.000.000)
		//$inIpList = array("110.74.220","124.108.54","119.196.55","125.129.171","121.131.161","210.113.123","121.140.45","14.138.70","117.53.88","210.91.115","202.53.146","210.223.48","202.53.145");
        $inIpList = array("106.187.91.65", "45.32.52.206", "45.32.249.189", "5.79.102", "37.48.116");

		//-> 접근차단아이피, 전체(000.000.000.000) 또는 대역(000.000.000)
		$blockIpList = array("192.156.185");

		$returnVal = array("in" => 0, "block" => 0);
		if ( strlen(trim($_SERVER["HTTP_INCAP_CLIENT_IP"])) > 0 ) {
			$returnVal["in"] = $this->checkIpAddress($_SERVER["HTTP_INCAP_CLIENT_IP"],$inIpList);
			$returnVal["block"] = $this->checkIpAddress($_SERVER["HTTP_INCAP_CLIENT_IP"],$blockIpList);
		}
		if ( strlen(trim($_SERVER["HTTP_X_FORWARDED_FOR"])) > 0 ) {
			if ( $returnVal["in"] == 0 ) $returnVal["in"] = $this->checkIpAddress($_SERVER["HTTP_X_FORWARDED_FOR"],$inIpList);
			if ( $returnVal["block"] == 0 ) $returnVal["block"] = $this->checkIpAddress($_SERVER["HTTP_X_FORWARDED_FOR"],$blockIpList);
		}
		if ( strlen(trim($_SERVER["HTTP_X_REAL_IP"])) > 0 ) {
			if ( $returnVal["in"] == 0 ) $returnVal["in"] = $this->checkIpAddress($_SERVER["HTTP_X_REAL_IP"],$inIpList);
			if ( $returnVal["block"] == 0 ) $returnVal["block"] = $this->checkIpAddress($_SERVER["HTTP_X_REAL_IP"],$blockIpList);
		}
		if ( strlen(trim($_SERVER["REMOTE_ADDR"])) > 0 ) {
			if ( $returnVal["in"] == 0 ) $returnVal["in"] = $this->checkIpAddress($_SERVER["REMOTE_ADDR"],$inIpList);
			if ( $returnVal["block"] == 0 ) $returnVal["block"] = $this->checkIpAddress($_SERVER["REMOTE_ADDR"],$blockIpList);
		}

		//-> return : array("in"=>?,"block"=>?); 0 = 비매칭, 1 = 전체매칭, 2 = 대역매칭
		return $returnVal;
	}

	//-> 아이피 체크 (전체 및 대역)
	function checkIpAddress($ip, $ipList) {
		if ( getType(array_search($ip,$ipList)) == "integer" ) return 1;
		else if ( getType(array_search($this->cutIpAddress($ip),$ipList)) == "integer" ) return 2;
		else return 0;
	}

	//-> 아이피 대역 자르기
	function cutIpAddress($ip) {
		$ipTemp = explode(".", $ip);
		return $ipTemp[0].".".$ipTemp[1].".".$ipTemp[2];
	}

	function getSn()
	{
		return $this->rSession['member']["sn"];
	}
	
	function getName()
	{
		return $this->rSession['member']["name"];
	}
	
	function getId()
	{
		return $this->rSession['member']["id"];
	}
	
	function getLevel()
	{
		return $this->rSession['member']["level"];
	}
	
	function getState()
	{
		return $this->rSession['member']["state"];
	}

	function isLogin()
	{
		return ($this->rSession['member']["id"]!='')?true:false;
	}
	
	function getPartnerLevel()
	{
		return ($this->rSession['member']["parent_sn"]==0) ? 1:2;
	}
	
	public function isAdmin()
	{
		if($this->rSession['member']["level"]<=2)
			return true;
		else
			return false;
	}

	public function isSuper()
	{
		if($this->rSession['member']["level"]==1)
			return true;
		else
			return false;
	}	
	
	function getRate()
	{
		return $this->rSession['member']["rate"];
	}
}

?>