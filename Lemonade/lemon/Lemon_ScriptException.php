<?
/*
* JavaScript 로 에러를 표시해주는 ScriptException
*/

class Lemon_ScriptException extends Exception
{
	var $message;
	var $comment;
	var $command;
	var $action;
	
	var $header = "<html>
<head>
	<meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\" />
</head>
<body>
	";
	var $footer = "</body></html>";

	/*
	*
	* @param $message 메시지 제목
	* @param $comment 메시지 내용
	* @param $command back | alert | close | go | script
	* @param $action command 가 'go', 'script' 일 경우 해당 url 혹은 스크립트 
	*/
	public function __construct($message='',$comment='',$command='back',$action='') {
		$this->message = $message;
		$this->comment = preg_replace("/[ ]+/"," ",preg_replace("/(\n|\t)+/"," ",$comment));
		$this->command = $command;
		$this->action = $action;
	}

	public function __toString() {
		switch($this->command){
			case 'back':
				$script = $this->header."<script>alert(\"".$this->message."\\n".$this->comment."\");history.back();</script>".$this->footer;
				break;
			case 'alert':
				$script =  $this->header."<script>alert(\"".$this->message."\\n".$this->comment."\")</script>".$this->footer;
				break;
			case 'close':
				$script =  $this->header."<script>alert(\"".$this->message."\\n".$this->comment."\");self.close();</script>".$this->footer;
				break;
			case 'go':
				if($this->message!='' || $this->comment!='')
					$script =  $this->header."<script>alert(\"".$this->message."\\n".$this->comment."\"); document.location=\"".$this->action."\"</script>".$this->footer;
				else 
					$script =  $this->header."<script>document.location=\"".$this->action."\"</script>".$this->footer;
				break;
			case 'script':
				$script = $this->header."<script>".$this->action."</script>".$this->footer;
				break;
		}

		return $script;
	}

}

?>