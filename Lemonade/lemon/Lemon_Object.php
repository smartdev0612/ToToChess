<?php

class Lemon_Object 
{	
	var $req;
	var $path;
	var $config;
	var $message;
	var $auth;
	
	function __construct()
	{
		echo "Lemon_Object<br>";
	}
	
	public function setRequest($req)
	{
		$this->req = $req;
		//echo "Lemon_Object setRequest var : " . $this->req->getParameter("var1");
	}
	
	public function setPath($path)
	{
		$this->path = $path;
	}

	public function setConfig($config)
	{
		$this->config = $config;
	}

	public function setMessage($msg)
	{
		$this->message = $msg;
	}
	
	public function setAuth($auth)
	{
		$this->auth = $auth;
	}
}