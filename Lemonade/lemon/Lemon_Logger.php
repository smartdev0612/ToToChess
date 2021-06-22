<?
/*
* 로거기능지원. 
* ㅡ. 파일로깅과 화면로깅지원. 
* ㅡ. 이메일 알람지원. 
* ㅡ. 로그파일 로테이트 지원, 로그파일 최대 크기 지정
*
* @author Minsik, Kang
* @version 2008-03-10 1.0
*
* Ez_Email.php 파일 필요로 함
*
* log.ini 설정 예
------------------------------------------------------------
[base]
output=file			; echo or file
level=fatal			; debug < info < warn < error < fetal

[file]
file_rotate_num=3	; file rotate
file_max=1000		; max log file size

[email]
alert=true			; true or false
alert_level=fatal	; only warn or error or fetal
receiver="aquazen@nate.com,aquazen@skcomms.co.kr"	; email list
sender_name="<EzApp Logger>"						; sender's name
sender_email="aquazen@nate.com"						; sender's email
subject="[ Logger Report ]"							; email subject
------------------------------------------------------------
*
*/
class Lemon_Logger {
	public $level = array("debug"=>0, "info"=>1, "warn"=>2, "error"=>3, "fatal"=>4);
	public static $logger = '';	// 로거 객체
	public $logConfig = '';		// 로그 설정정보
	public $currentLog = '';	// 현재 기록중인 로그파일
	public $log = '';			// 로그파일 정보 배열
	public $logFileCount = 0;	// 로그파일 개수
	public $logCount = 0;		// 로그에 기록할 데이터 개수
	public $logContents = '';	// 로그에 입력할 내용을 담을 배열
	public $logNext = false;	// 현재로그가 꽉 찼을 경우 다음로그에 쌓을지 여부
	public $fSize = 0;			// 최근 기록 로그파일의 파일 사이즈
	public $logDir = '';		// 디렉토리정보
	public $errorClass = '';
	public $errorMethod = '';

	public function __construct($_class='', $_method=''){
		global $vhost;
		
		// 로그 설정파일 읽기
		$this->logConfig = Lemon_Configure::readConfig('log');

		if($this->logConfig['base']['output']=='file'){
			$this->logDir = dirname(__file__).'/../'.$vhost.'/log';
			$this->fileRotate();
			if($this->logFileCount>0){
				$this->fSize = filesize($this->logDir."/".$this->currentLog);
			}
		}
	}

	public function getInstance($_class='', $_method=''){
		if(self::$logger=='')
			self::$logger = new Ez_Logger($_class, $_method);

		self::$logger->setLogPage($_class, $_method);
		return self::$logger;
	}

	public function fileRotate(){
		global $vhost;
		
		if ($handle = opendir($this->logDir)) {
			while (false !== ($file = readdir($handle))){
				if(strpos($file,$vhost.'.log.')!==false){
					$this->log['file'][$this->logFileCount] = $file;
					$this->log['date'][$this->logFileCount++] = date("Y-m-d H:i:s",filectime($this->logDir.'/'.$file));
				}
			}

			closedir($handle);
		}

		$n = count((array)$this->log['file']);
		if($n>1){
			for($i=0;$i<$n-1;$i++){
				$min = $i;
				
				for ($j=$i+1; $j < $n; $j++)
					if($this->log['date'][$j] > $this->log['date'][$min])  $min = $j;

				$temp = $this->log['file'][$min];
				$this->log['file'][$min] = $this->log['file'][$i];
				$this->log['file'][$i] = $temp;

				$temp = $this->log['date'][$min];
				$this->log['date'][$min] = $this->log['date'][$i];
				$this->log['date'][$i] = $temp;
			}

			$this->currentLog = $this->log['file'][0];

		}
		else {
			$this->currentLog = $vhost.".log.1";
		}
	}

	public function setLogPage($_class, $_method){
		$this->errorClass = $_class;
		$this->errorMethod = $_method;
		$this->logWrite(">>> class [ ".$_class." ], method [ ".$_method . " ]");
	}

	public function logWrite($msg){
		global $vhost;

		if($this->logConfig['base']['output']=='file'){
			$strTmp = $this->fileContents[$this->logCount] . $msg . "\n";

			if($this->logCount==0 && ($this->fSize+strlen($strTmp))>$this->logConfig['file']['file_max']){
				$this->logNext = true;
				$this->logCount++;
			}
			else if(strlen($strTmp)>$this->logConfig['file']['file_max'])
				$this->logCount++;

			$this->fileContents[$this->logCount] .= $msg."\n";

			//echo "logcount : " . $this->logCount . "<br>";
		}
		else if($this->logConfig['base']['output']=='echo'){
			echo $msg."<br>";
		}
	}

	public function debug($msg){
		if($this->level[$this->logConfig['base']['level']]>=0)
			$this->logWrite("[debug]\t[".date("H:i:s")."] : ".$msg);
	}

	public function info($msg){
		if($this->level[$this->logConfig['base']['level']]>=1)
			$this->logWrite("[info]\t[".date("H:i:s")."] : ".$msg);
	}

	public function warn($msg){
		if($this->level[$this->logConfig['base']['level']]>=2)
			$this->logWrite("[warn]\t[".date("H:i:s")."] : ".$msg);
		$this->errorMail($msg,2);
	}

	public function error($msg){
		if($this->level[$this->logConfig['base']['level']]>=3)
			$this->logWrite("[error]\t[".date("H:i:s")."] : ".$msg);
		$this->errorMail($msg,3);
	}

	public function fatal($msg){
		if($this->level[$this->logConfig['base']['level']]>=4)
			$this->logWrite("[fatal]\t[".date("H:i:s")."] : ".$msg);
		$this->errorMail($msg,4);
	}

	public function errorMail($msg, $level){
		$keys = array_keys($this->level);
		if(in_array($this->logConfig['email']['alert_level'],$keys)){
			if($this->logConfig['email']['alert']==true && $this->level[$this->logConfig['email']['alert_level']]<=$level){
				$message = "date : " . date("Y-m-d H:i:s")."<br>";
				$message .= ">>> class [".$this->errorClass."] , method [".$this->errorMethod."]<br>";
				$message .= ">>> message : " . $msg . "<br>";
				$email = new Ez_Email(trim($this->logConfig['email']['sender_email']),trim($this->logConfig['email']['sender_name']));
				
				$tmp = explode(",",$this->logConfig['email']['receiver']);
				for($i=0;$i<count((array)$tmp);$i++){
					echo "email : " . $tmp[$i] . "<br>";
					$email->setTo(trim($tmp[$i])); 
					$email->setContent($this->logConfig['email']['subject'], $message);
					$email->send();
				}
			}
		}
	}

	public function __destruct(){
		global $vhost;

		if($this->logConfig['base']['output']=='file'){
			$currentNum = intval(str_replace($vhost.".log.","",$this->currentLog));

			for($i=0,$j=$currentNum;$i<=$this->logCount;$i++){
				$logfile = $vhost.".log.".$currentNum;

				if($i==0)
					$mode = "a";
				else
					$mode = "w";

				$fp = fopen($this->logDir."/".$this->currentLog, $mode);
				fputs($fp,$this->fileContents[$i]);
				fclose($fp);

				if($currentNum+1>$this->logConfig['file']['file_rotate_num'])
					$this->currentLog = $vhost.".log.1";
				else
					$this->currentLog = $vhost.".log.".($currentNum+1);
			}
		}
	}
}
?>