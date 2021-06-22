<?
//라이브러리
include dirname(__FILE__)."/lib/gabia_xmlrpccommon.php";
include dirname(__FILE__)."/lib/xml_helper.php";

class gabiaSmsApi extends XmlRpcCommon
{
	private $api_host = "sms.gabia.com";
	private $api_curl_url = "http://sms.gabia.com/assets/api_upload.php";
	private $user_id = "";
	private $user_pw = "";
	private $m_szResultXML = "";
	private $m_oResultDom = null;
	private $m_szResultCode = "";
	private $m_szResultMessage = "";
	private $m_szResult = "";

	private $m_nBefore = 0;
	private $m_nAfter = 0;
	private $success_cnt = 0;
	private $fail_list;

	public $md5_access_token = "";

	public static $RESULT_OK = "0000";
	public static $CALL_ERROR = -1;

	function __construct($id, $api_key, $pw="")
	{
		$this->sms_id = $id;
		$this->api_key = $api_key;
		$this->sms_pw = $pw;

		$nonce = $this->gen_nonce();
		$this->md5_access_token = $nonce.md5($nonce.$this->api_key);
	}

	function __destruct()
	{
		unset($this->m_szResultXML);
		unset($this->m_oResultDom);
	}

	/*
	 * nonce 생성
	 */
	function gen_nonce()
	{
		$nonce = '';
		for($i=0; $i<8; $i++)
		{
			$nonce .= dechex(rand(0, 15));
		}

		return $nonce;
	}

	public function getSmsCount()
	{
		$request_xml = <<<DOC_XML
<request>
<sms-id>{$this->sms_id}</sms-id>
<access-token>{$this->md5_access_token}</access-token>
<response-format>xml</response-format>
<method>SMS.getUserInfo</method>
<params>
</params>
</request>
DOC_XML;

		$nCount = 0;
		if ($this->xml_do($request_xml) == self::$RESULT_OK)
		{
			if (stripos($this->m_szResult, "<?xml") == 0)
			{
				$oCountXML = simplexml_load_string($this->m_szResult);

				if (isset($oCountXML->children()->sms_quantity))
					$nCount = $oCountXML->children()->sms_quantity;
			}
		}

		return $nCount;
	}

	public function get_result_xml($result)
	{
		$sp = new SimpleParser();
		$sp->parse_xml($result);

		$result_xml = $sp->getValue("RESPONSE|RESULT");

		return base64_decode($result_xml);
	}

	public function get_status_by_ref($refkey)
	{
		if(is_array($refkey))
		{
			$ref_keys = implode(",", $refkey);
		}else
		{
			$ref_keys = $refkey;
		}
		$request_xml = <<<DOC_XML
<request>
<sms-id>{$this->sms_id}</sms-id>
<access-token>{$this->md5_access_token}</access-token>
<response-format>xml</response-format>
<method>SMS.getStatusByRef</method>
<params>
	<ref_key>{$ref_keys}</ref_key>
</params>
</request>
DOC_XML;

		if ($this->xml_do($request_xml) == self::$RESULT_OK)
		{
			$r = array();
			$resultXML = simplexml_load_string($this->m_szResult);

			foreach($resultXML->children()->smsResult->entries->children() as $n)
			{
				if((string)$n[0] =="NODATA"){
					return array("CODE" => "NODATA", "MESG" =>"NODATA");
				}
				$szKey = (string)$n->children()->SMS_REFKEY;
				$szCode = (string)$n->children()->CODE;
				$szMesg = (string)$n->children()->MESG;

				$r = array("CODE" => $szCode, "MESG" => $szMesg);
			}
			return $r;
		}
		else false;
	}

	public function sms_send($phone, $callback, $msg, $refkey="", $reserve = "0")
	{
		$request_xml = <<<DOC_XML
<request>
<sms-id>{$this->sms_id}</sms-id>
<access-token>{$this->md5_access_token}</access-token>
<response-format>xml</response-format>
<method>SMS.send</method>
<params>
	<send_type>sms</send_type>
	<ref_key>{$refkey}</ref_key>
	<subject>{$title}</subject>
	<message>{$msg}</message>
	<callback>{$callback}</callback>
	<phone>{$phone}</phone>
	<reserve>{$reserve}</reserve>
</params>
</request>
DOC_XML;

		return $this->xml_do($request_xml);
	}

	public function lms_send($phone, $callback, $msg, $title="", $refkey="", $reserve = "0")
	{
		$request_xml = <<<DOC_XML
<request>
<sms-id>{$this->sms_id}</sms-id>
<access-token>{$this->md5_access_token}</access-token>
<response-format>xml</response-format>
<method>SMS.send</method>
<params>
		<send_type>lms</send_type>
		<ref_key>{$refkey}</ref_key>
		<subject>{$title}</subject>
		<message>{$msg}</message>
		<callback>{$callback}</callback>
		<phone>{$phone}</phone>
		<reserve>{$reserve}</reserve>
</params>
</request>
DOC_XML;

		return $this->xml_do($request_xml);
	}
	

	public function multi_sms_send($phone, $callback, $msg, $refkey, $reserve){
		if(!is_array($phone)){
			$this->m_szResultCode = "NOT ARRAY";
			$this->m_szResult = "NOT ARRAY";
			return ;
		}
		$multi_phonenum = $this->make_multi_num($phone);

		$request_xml = <<<DOC_XML
<request>
<sms-id>{$this->sms_id}</sms-id>
<access-token>{$this->md5_access_token}</access-token>
<response-format>xml</response-format>
<method>SMS.multi_send</method>
<params>
	<send_type>sms</send_type>
	<ref_key>{$refkey}</ref_key>
	<subject>{$title}</subject>
	<message>{$msg}</message>
	<callback>{$callback}</callback>
	<phone>{$multi_phonenum}</phone>
	<reserve>{$reserve}</reserve>
</params>
</request>
DOC_XML;

		return $this->xml_do($request_xml);
	}

	public function multi_lms_send($phone, $callback, $title="", $msg, $refkey="", $reserve = "0")
	{
		if(!is_array($phone)){
			$this->m_szResultCode = "NOT ARRAY";
			$this->m_szResult = "NOT ARRAY";
			return ;
		}
		$multi_phonenum = $this->make_multi_num($phone);

		$request_xml = <<<DOC_XML
<request>
<sms-id>{$this->sms_id}</sms-id>
<access-token>{$this->md5_access_token}</access-token>
<response-format>xml</response-format>
<method>SMS.multi_send</method>
<params>
		<send_type>lms</send_type>
		<ref_key>{$refkey}</ref_key>
		<subject>{$title}</subject>
		<message>{$msg}</message>
		<callback>{$callback}</callback>
		<phone>{$multi_phonenum}</phone>
		<reserve>{$reserve}</reserve>
</params>
</request>
DOC_XML;

		return $this->xml_do($request_xml);
	}

	public function make_multi_num($phone){
		$multi_phonenum = "";
		if(is_array($phone)){
			for($i=0; $i < count($phone);$i++){
				if($i+1 == count($phone))$multi_phonenum .= $phone[$i];
				else $multi_phonenum .= "$phone[$i],";
			}
		}
		return $multi_phonenum;
	}

	public function get_status_by_ref_all($ref_key){
		$request_xml = <<<DOC_XML
<request>
<sms-id>{$this->sms_id}</sms-id>
<access-token>{$this->md5_access_token}</access-token>
<response-format>xml</response-format>
<method>SMS.getStatusByRef_all</method>
<params>
	<ref_key>{$ref_key}</ref_key>
</params>
</request>
DOC_XML;

		if ($this->xml_do($request_xml) == self::$RESULT_OK)
		{
			$r = array();
			$resultXML = simplexml_load_string($this->m_szResult);
			$i = 0;
			foreach($resultXML->children()->smsResult->entries->children() as $n)
			{
				$szKey = (string)$n->children()->SMS_REFKEY;
				$szPhone = (string)$n->children()->PHONENUM;
				$szMesg = (string)$n->children()->MESG;

				$r[$i]["PHONE"] = $szPhone;
				$r[$i]["MESG"] = $szMesg;

				$i++;
			}
			if($r[0]["PHONE"] != null){
				return $r;
			}else{
				return false;
			}
			
		}
		else false;
	}
	/*
	 * XMLRPC 발송
	 * $xml_data : 발송정보의 XML 데이터
	 */
	private function xml_do($xml_data)
	{
		$this->init($this->api_host, "api", "gabiasms");
		$this->m_szResultXML = $this->call($xml_data);

		if ($this->m_szResultXML)
		{
			$this->m_oResultDom = simplexml_load_string($this->m_szResultXML);

			if (isset($this->m_oResultDom->children()->code))
				$this->m_szResultCode = $this->m_oResultDom->children()->code;

			if (isset($this->m_oResultDom->children()->code))
				$this->m_szResultMessage = $this->m_oResultDom->children()->mesg;

			if (isset($this->m_oResultDom->children()->result))
				$this->m_szResult = base64_decode($this->m_oResultDom->children()->result);

			$r = stripos($this->m_szResult, "<?xml");
			if ($r == 0 && $r !== FALSE)
			{
				$oCountXML = simplexml_load_string($this->m_szResult);

				if(isset($oCountXML->children()->BEFORE_SMS_QTY))
					$this->m_nBefore = $oCountXML->children()->BEFORE_SMS_QTY;

				if(isset($oCountXML->children()->AFTER_SMS_QTY))
					$this->m_nAfter = $oCountXML->children()->AFTER_SMS_QTY;

				if(isset($oCountXML->children()->SUCCESS_CNT))
					$this->success_cnt = $oCountXML->children()->SUCCESS_CNT;

				if(isset($oCountXML->children()->FAIL_LIST))
					$this->fail_list = $oCountXML->children()->FAIL_LIST;

				unset($oCountXML);
			}

			unset($this->m_oResultDom);
		}
		else
		{
			$this->m_szResultCode = $this->m_szResultXML;
			$this->m_szResult = $this->getRpcError();
		}

		return $this->m_szResultCode;
	}

	public function getResultCode()
	{
		return $this->m_szResultCode;
	}

	public function getResultMessage()
	{
		return $this->m_szResultMessage;
	}

	public function getBefore()
	{
		return $this->m_nBefore;
	}

	public function getAfter()
	{
		return $this->m_nAfter;
	}

	public function get_success_cnt()
	{
		return $this->success_cnt;
	}

	public function get_fail_list()
	{
		return $this->fail_list;
	}
}
?>
