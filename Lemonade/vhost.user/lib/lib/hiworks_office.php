<?php

	include_once("hiworks_rpccommon.php");
	include_once("xml_helper.php");
	if (PHP_VERSION>='5')
		include_once('domxml-php4-to-php5.php');

	define('HIWORKS_GROUP_SERVER','office.hiworks.co.kr');
	define('HIWORKS_XMLRPC_ENDPOINT','/api/open' );
	define('HIWORKS_XMLRPC_METHOD','hiworksoffice' );
	define("SUCCESS", "0000");

	class HiworksCall
	{
		var $rpc_server = false;
		var $rpc_endpoint = false;

		var $rpcconn = false;
		var $app_id = false;
		var $userid = false;
		var $domain = false;
		var $access_token = false;
		var $request_token = false;

		var $result_code = "";
		var $result_mesg = "";
		var $result_xml = "";
		var $result_charset = "utf-8";

		var $bEUCKR = false;

		var $xml_template = "<request>
<app-id>%s</app-id>
<userid>%s</userid>
<domain>%s</domain>
<access-token>%s</access-token>
<request-token>%s</request-token>
<charset>%s</charset>
<method>%s</method>
<params>%s</params>
</request>";

		function init( $app_id, $userid, $domain, $request_token, $bEUCKR = false, $request_server = ""  )
		{
			if( strstr( $domain , "." ) )
			{
				if( $request_server != "" )
					$this->rpc_server = $request_server;
				else
				{
					if ($domain == "gabia.com") $this->rpc_server = sprintf("inmail.%s", $domain);
					else
					{
						$this->rpc_server = "webmail.".$domain;
					}
				}

				$this->rpc_endpoint = HIWORKS_XMLRPC_ENDPOINT;
			}
			else
			{
				$this->rpc_server = HIWORKS_GROUP_SERVER;
				$this->rpc_endpoint = "/".$domain."/".HIWORKS_XMLRPC_ENDPOINT;
			}

			$this->app_id = $app_id;
			$this->userid = $userid;
			$this->domain = $domain;

			$nonce = $this->generateNonce();
			$this->request_token = $nonce.md5( $nonce.$request_token );

			$this->rpcconn = new HiworksXmlRpcCommon();
			$this->rpcconn->init( $this->rpc_server, $this->rpc_endpoint, HIWORKS_XMLRPC_METHOD );

			$this->bEUCKR = $bEUCKR;
		}

		function setAccessToken( $access_token )
		{
			$nonce = $this->generateNonce();
			$this->access_token = $nonce.md5( $nonce.$access_token['access-token'] );
		}

		function requestAccessToken()
		{
			if( !$this->call( "AUTH.requestAccessToken" ) )
			{
				echo "XML-RPC error";
				return false;
			}

			if( $this->getLastCode() == "0000" )
			{
				$access_token = $this->getValueFromXML( array('userId','domain','access-token','expiration-date') );

				$nonce = $this->generateNonce();
				$this->access_token = $nonce.md5( $nonce.$access_token['access-token'] );

				return $access_token;
			}

			printf("Code=[%s] Message=[%s]<br>\n",$this->getLastCode(), $this->getLastMesg() );

			return false;
		}

		// me2 에서 사용하는 함수 발췌함.
		protected static function generateNonce() {
        $nonce = '';
        for ($i = 0; $i < 8; ++$i) {
            $nonce .= dechex(rand(0, 15));
        }
        return $nonce;
    }

		function call( $methodName, $request_params = array() )
		{
			$this->result_code = "";
			$this->result_mesg = "";
			$this->result_xml = "";
			$this->result_charset = "";

			$params = "";
			foreach( $request_params as $k => $v )
			{
				$params .= sprintf("<%s>%s</%s>", $k, htmlspecialchars($v), $k );
			}

			$xml_str = sprintf( $this->xml_template, $this->app_id,$this->userid, $this->domain, $this->access_token, $this->request_token, $this->bEUCKR ? 'euc-kr' : 'utf-8',$methodName, $params );

			$result = $this->rpcconn->call( $xml_str );

			if( !$result ) return false;

			$sp = new SimpleParser();
			$sp->parse_xml( $result, $this->bEUCKR );

			$this->result_code = $sp->getValue("RESPONSE|CODE");
			$this->result_mesg = $sp->getValue("RESPONSE|MESG");
			$this->result_xml = $sp->getValue("RESPONSE|RESULT");

			$this->result_charset = $sp->getValue("RESPONSE|CHARSET");

			if( !in_array( $this->result_charset, array('utf-8','euc-kr' ) ) )
				$this->result_charset = "utf-8";

			return $result;
		}

		function getLastCode()
		{
			return $this->result_code;
		}

		function getLastMesg()
		{
			return $this->result_mesg;
		}

		function getResultCharset()
		{
			return $this->result_charset;
		}

		function getResultXML( $noWantCharsetCheck = false )
		{
			if( $this->bEUCKR && !$noWantCharsetCheck )
			{
				return "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n".base64_decode( $this->result_xml );
			}

			return base64_decode( $this->result_xml );
		}

		function getArrayByResultXML()
		{
			return xml2array( $this->getResultXML(), $this->bEUCKR );
		}

		function getValueFromXML( $key_array )
		{
			if( $this->bEUCKR )
			{
				$pre_result = getValueFromXML( iconv("euc-kr","utf-8",$this->getResultXML(true)), $key_array );

				foreach( $pre_result as $k => $v )
				{
					$pre_result[$k] = iconv("utf-8","euc-kr", $v );
				}

				return $pre_result;
			}
			else
			{
				return getValueFromXML( $this->getResultXML(true), $key_array );
			}
		}

		function getElementsFromXML( $key_name )
		{
			if( $this->bEUCKR )
				return getElementsFromXML( iconv("euc-kr","utf-8",$this->getResultXML(true)), $key_name );
			else
				return getElementsFromXML( $this->getResultXML(true), $key_name );
		}

		function getValueFromXMLObject( $xml_object, $key_array )
		{
			$pre_result = getValueFromXMLObject( $xml_object, $key_array );

			if( $this->bEUCKR )
			{
				foreach( $pre_result as $k => $v )
				{
					$pre_result[$k] = iconv("utf-8","euc-kr", $v );
				}
			}

			return $pre_result;
		}

	}

?>