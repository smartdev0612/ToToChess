<?
class Lemon_Controller extends Lemon_Object 
{	
	function __construct()
	{
		global $t_req, $t_config, $t_path, $t_message, $t_auth;
		
		parent::setRequest($t_req);
		parent::setConfig($t_config);
		parent::setPath($t_path);
		parent::setMessage($t_message);
		parent::setAuth($t_auth);

		if($_SERVER['REQUEST_URI'] != "/etc/refresh" && $_SERVER['REQUEST_URI'] != "/game/refreshBetList" && $_SERVER['REQUEST_URI'] != "/etc/GameFinProcess" && $_SERVER['REQUEST_URI'] != "/race/saveProcess") {
			$logModel=Lemon_Instance::getObject("LogModel", true);
			$logModel->insertURL($_SERVER['REQUEST_URI']);
		}
	}

	public $view = '';
	public $baseurl = '';
	public $documentRoot = '';
	public $templatePath = '';
	public $templateUrl = '';
	public $path = '';
	public $config = '';
	public $message = '';
	public $req = '';

	public function setView($view='')
	{
		$this->view = $view;
	}

	public function setBaseURL($url)
	{
		$this->baseurl = $url;
	}

	public function setDocumentRoot($path)
	{
		$this->documentRoot = $path;
	}

	public function setTemplatePath($path)
	{
		$this->templatePath = $path;
	}

	public function setTemplateUrl($url)
	{
		$this->templateUrl = $url;
	}

	public function redirect($url)
	{
		echo "<script>document.location = '".$this->baseurl.$url."';</script>";
	}

	public function redirect_url($url,$msg='',$target='document') 
	{
		$sMessage = '';
		if (!empty($msg)) $sMessage = "alert('$msg');";
		echo "<script type='text/javascript'>$sMessage $target.location.href = '".$url."';</script>";
	}
}

?>
