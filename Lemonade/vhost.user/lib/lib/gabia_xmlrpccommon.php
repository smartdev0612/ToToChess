<?
include_once(dirname(__FILE__)."/xmlrpc.inc");

class XmlRpcCommon
{
	protected $rpc_server;
	protected $rpc_endpoint;
	protected $rpc_method;
	protected $rpc_error;

	function init( $s, $e, $m )
	{
		$this->rpc_server = $s;
		$this->rpc_endpoint = $e;
		$this->rpc_method = $m;

		$GLOBALS['xmlrpc_internalencoding']='UTF-8';
	}

	function call( $request_xml )
	{
		$m = new xmlrpcmsg($this->rpc_method, array(new xmlrpcval($request_xml, "string")));

		$c = new xmlrpc_client( $this->rpc_endpoint, $this->rpc_server, 80);
		$c->request_charset_encoding = "UTF-8";
		//$c->setDebug(TRUE);

		$r = $c->send($m);

		if (!$r->faultCode())
		{
			$v = $r->value();

			//print_r($v);

			$decode_v = php_xmlrpc_decode($v);

			//print_r($decode_v);

			return $decode_v;
		}
		else
		{
			$this->rpc_error = $c->errstr;
			return $c->errno;
		}
	}

	function getRpcError()
	{
		return $this->rpc_error;
	}
}
?>
