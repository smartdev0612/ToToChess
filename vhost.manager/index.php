<?
error_reporting(E_WARNING);

$vhost = "vhost.manager";
$docroot = $_SERVER['DOCUMENT_ROOT'];

spl_autoload_register(function($className)
{
	global $vhost, $docroot; 
	
	if(substr($className,0,6)=="Lemon_")
	{
		include_once $docroot."/../Lemonade/lemon/".$className.".php";
	}
	else if(strpos($className,"Controller"))
	{
		global $vhost;
		
		$dir = "";
		if(strpos($className, "_")!==false)
		{
			$sub = explode("_",$className);
			for($i=0;$i<count((array)$sub)-1;$i++)
			{
				$dir .= strtolower($sub[$i])."/";
			}
		}

		include_once $docroot."/../Lemonade/".$vhost."/controller/".$dir.$className.".php";
	}
	else if(strpos($className,"Model"))
	{
		include_once $docroot."/../Lemonade/vhost.common/model/".$className.".php";
	}
	else if($className=="Template_")
	{
		include_once $docroot."/../Lemonade/Template_/".$className.".class.php";
	}
	else
	{    
		include_once $docroot."/../Lemonade/".$vhost."/lib/".$className.".php";
	}
});

session_set_cookie_params( 0, "/", $_SERVER['HTTP_HOST']);
session_save_path("./session"); 
session_start();

$service = new Lemon_Service();

try
{
    return $service->run();	
}
catch(Lemon_ScriptException $e)
{
    echo $e;
    exit;   
}
catch(Lemon_HtmlException $e)
{
    echo $e;
    exit;   
}
?>
 