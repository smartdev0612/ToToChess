<?
class Request
{
	var $cTranid;
	var $cTranpasswd;
	var $cTranphone;
	var $cTrancallback;
	var $cTrandate;
	var $cTranmsg;

	var $Server;
	var $Port;
	var $Timeout;
	var $Socket;
	var $sdpQuery;
	var $status;

	var $Domain;
	var $Settype;
	var $Cmdtype;

	var $ErrNo = 0;
	var $ErrMsg = "";
	var $ErrCodes = array(
		800 => "Connection server failed",
	 );

	function Request()
	{
		$this->ErrNo = 0;
		if (!$this->Connect()) {
			if ($this->ErrNo == 0) {
				$this->ErrNo = 800;
				$this->ErrMsg = $this->ErrCodes[$this->ErrNo];
			}
		}
	}
	function Connect()
	{
		$this->Server = 'sms.gabia.com';
		$this->Port = '5000';
		$this->Timeout = 5;
		if($this->Socket = fsockopen($this->Server, $this->Port, &$this->ErrNo, &$this->ErrMsg, $this->Timeout)) 
		{
			return true;
		}
		else
		{
			$data = sprintf("%s-%s", $this->Server, $this->Port);
			echo $data;
		}
		
		return false;
	}
	function Read()
	{
		$smsEndOfCommand = "\n";
		$smsResponse = "";
		$buffer = "";

		while (!feof($this->Socket)) {
			$buffer = fgets($this->Socket, 1024);

			if (strcmp($buffer, $smsEndOfCommand) == 0) {
				break;
			}
			$smsResponse = $smsResponse.$buffer;

		}
		return($smsResponse);
	}
	function Write()
	{
		$smsEndOfCommand = "\n";

		$this->sdpQuery = $this->sdpQuery.$smsEndOfCommand;
		fputs($this->Socket, $this->sdpQuery);

	}
	function ResetMethods()
	{

		unset($this->Server);
		unset($this->Port);
		unset($this->Timeout);
		unset($this->Socket);
		unset($this->sdpQuery);
		unset($this->Commandtype);
		unset($this->Domain);
		unset($this->Settype);
		unset($this->Cmdtype);
		unset($this->ErrNo);
		unset($this->ErrMsg);
		unset($this->ErrCodes);
	}
	

	function b_strlen($str){
       		$ret = 0; 
		
		for($i = 0; $i < strlen($str); $i++)
		{ 
			if(ord($str{$i}) > 127)
			{
				$ret++;
			}
			else
				$ret++;
		}

		return $ret;
	}

	function Submit()
	{
		$smsEndOfCommand = "\n";
		$smsStatus = "1";
		$sms_key = "GS";
		$Response;

		$this->ErrNo = 0;
		$this->status = $smsStatus;
		$this->smskey = $sms_key;

		if ($this->b_strlen($this->cTranid) > 20) 
		{
			return "701";
			exit;
		}
		if ($this->b_strlen($this->cTranpasswd) > 20) 
		{
			return "702";
			exit;
		}
		if ($this->b_strlen($this->cTranphone) > 15) 
		{
			return "703";
			exit;
		}
		if ($this->b_strlen($this->cTrancallback) > 15) 
		{
			return "704";
			exit;
		}
		if ($this->b_strlen($this->cTrandate) > 19) 
		{
			return "705";
			exit;
		}

		$msglen = $this->b_strlen($this->cTranmsg);

		if ($msglen > 80) 
		{
			return "706";
			exit;
		}

		$totallen = $this->b_strlen($this->cTranid) + $this->b_strlen($this->cTranpasswd) + $this->b_strlen($this->cTranphone) + $this->b_strlen($this->cTrancallback) + $this->b_strlen($this->status) + $this->b_strlen($this->cTrandate) + $msglen;

		if ($totallen > 170) {
			return "707";
			exit;
		}

		$parameters = "";

		$parameters = $this->smskey.",";
		$parameters .= $totallen.",";
		$parameters .= $this->cTranid.",";
		$parameters .= $this->cTranpasswd.",";
		$parameters .= $this->cTranphone.",";
		$parameters .= $this->cTrancallback.",";
		$parameters .= $this->status.",";
		$parameters .= $this->cTrandate.",";
		$parameters .= $this->cTranmsg;


		$this->sdpQuery = $parameters;
		$this->Write($this->sdpQuery);
		$Response = $this->read();
		$this->ResetMethods();
		return($Response);

	}
	function Destroy()
	{
		if ($this->Socket) 
		{
			fclose($this->Socket);
		}
	}
}

/*
class Response extends Request
{

	var $StatusCode;
	var $Data = array();
	var $Data_Info = array();
	var $Infomation = array();
	var $Count = 0;
	var $errNo = 0;
	var $errMsg = "";

	function Response($Socket)
	{
		$this->Socket = $Socket;
		$Response = $this->read();
//		$this->StatusCode = $Response;
		return $Response;
//		$this->ParseResponse($Response);

	}

	function ParseResponse($Response)
	{

//		$tmpData = explode(" ", $Response,2);


	    
		return true;
	}



}
*/
?>
