<?php

class CommonModel extends Lemon_Model 
{
	function getIp()
	{
		$ip=false;
		if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
		{
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
		{
			$ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
			if ($ip) 
			{ 
				array_unshift($ips, $ip); 
				$ip = FALSE; 
			}
			for ($i = 0; $i < count((array)$ips); $i++) 
			{
				if (!preg_match("/^(10|172.16|192.168)./", $ips[$i])) 
				{
					$ip = $ips[$i];break;
				}
			}
		}
		
		if ( !trim($ip) ) $ip = $_SERVER["REMOTE_ADDR"];
		return ($ip ? $ip : $_SERVER['HTTP_X_FORWARDED_FOR']);
	}

	function newGetIp() {
		if ( strlen(trim($_SERVER["HTTP_INCAP_CLIENT_IP"])) > 0 and strlen(trim($_SERVER["HTTP_INCAP_CLIENT_IP"])) < 16 ) {
			$ip = $_SERVER["HTTP_INCAP_CLIENT_IP"];
		} else if ( strlen(trim($_SERVER["HTTP_X_FORWARDED_FOR"])) > 0 and strlen(trim($_SERVER["HTTP_X_FORWARDED_FOR"])) < 16 ) {
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} else if ( strlen(trim($_SERVER["HTTP_X_REAL_IP"])) > 0 and strlen(trim($_SERVER["HTTP_X_REAL_IP"])) < 16 ) {
			$ip = $_SERVER["HTTP_X_REAL_IP"];
		} else {
			$ip = $_SERVER["REMOTE_ADDR"];
		}
		return $ip;
	}

	function alertGo($text, $url)
	{
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><script language=javascript>alert('".$text."');window.location='".$url."';</script>";
	}
}

?>