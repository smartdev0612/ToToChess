<?
/*
* 서비스 시작시 맨 처음 실행되는 클래스.
*/
global $t_path;
global $t_config;
global $t_message;
global $t_req;
global $t_auth;
$t_path = Lemon_Configure::readConfig('path');
$t_config = Lemon_Configure::readConfig('config');
$t_message = Lemon_Configure::readConfig('message');
$t_req = Lemon_Instance::getObject('Lemon_Request');
$t_auth = Lemon_Instance::getObject('Lemon_Auth');

class Lemon_Service 
{
	public $view = null;
	public $lemon = null;

	function __construct()
	{
		/*
		* 뷰처리를 담당하는 객체. 다른 뷰를 사용하려면 이곳에서 다른 뷰 객체를 생성한다.
		*/
		$this->view = new Template_();
		
		/*
		 * QA 를 위해 QA 팀과 임광빌딩을 제외한 다른곳의 접근은 차단한다
		 */
		/*
		if($pass===false){
			echo "<script>document.location='http://www.nate.com';</script>";
			exit;
		}
		*/
	}

	function run()
	{
		/*
		* 주소에서 baseurl 이후의 값을 controller 로 정하고 그 다음 '/' 이후를
		* 해당 controller 의 action 으로 잡는다.
		*/
		$this->lemon = new Lemon_Init($this->view);
		
		try 
		{
			$this->lemon->run();
		}
		catch(Lemon_ScriptException $e)
		{
			//echo "lemon->run() " ;
			echo $e;
			exit;
		}
		catch(Lemon_HtmlElemontion $e)
		{
			echo $e;
			exit;
		}
		
		/*
		* 해당 주소를 분석한 결과의 controller 의 action 메소드를 실행한다.
		*/
		if(is_object($this->lemon->controller))
		{
			try {
				$ref = new ReflectionClass($this->lemon->controller);
				if ($method = $ref->getMethod($this->lemon->action)) 
				{
					return $method->invoke($this->lemon->controller);
				}
			}
			/*
			* 해당하는 action 메소드가 없을 시 처리
			*/
			catch(ReflectionException $e)
			{
				throw new Lemon_HtmlException("Error","페이지를 찾을 수 없습니다");
			}
			/*
			* action 메소드에서 발생한 자바스크립관련 Exception 을 처리한다.
			*/
			catch(Lemon_ScriptException $e)
			{
				echo $e;
			}
			/*
			* action 메소드에서 발생한 HTML 처리 관련 Exception 을 처리한다.
			*/
			catch(Lemon_HtmlException $e){
				echo $e;
			}
			/*
			* action 메소드에서 발생한 위의 예외외의 모든 예외를 처리한다.
			*/
			catch(Exception $e){
				echo $e;
			}

			exit;
		}
		else 
		{
			//echo "> url : " . $this->lemon->url . "<br>";
			if(strpos($this->lemon->url,"?")!==false)
				$this->lemon->url = substr($this->lemon->url,0,strpos($this->lemon->url,"?"));

			if($this->lemon->url=="index.html" || $this->lemon->url=="index.htm" || $this->lemon->url=="index.php")
			{
				echo "<script>document.location='http://".$_SERVER['HTTP_HOST']."';</script>";
				exit;
			}

			$path = Lemon_Configure::readConfig('path');

			// 실제 파일이 존재하면 보여주고 없으면 notfound 로 이동
			if(is_file($path['www_root']."/".$this->lemon->url)===true)
				include $this->lemon->url;
			else
				echo "<script>document.location='/notfound';</script>";
		}
	}
}
?>