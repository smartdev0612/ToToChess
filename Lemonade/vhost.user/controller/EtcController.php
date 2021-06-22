<?php 

class EtcController extends WebServiceController
{
	function companyAction()
	{
		$this->view->define("index","layout/layout.etc.html");
		$this->view->define(array("header"=>"header/header.html", "top" => "header/top.html", "footer" => "footer/footer.html"));
		$this->display();
	}
	
	function callAction()
	{
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		
		if($this->auth->getLevel()>2){
			throw new Lemon_ScriptException("접근 권한이 없습니다");
			exit;
		}
		
		$this->commonDefine();
		$this->view->define('content', 'content/etc_call.html');
		
		$eModel = Lemon_Instance::getObject("EtcModel", true);		
		$rs = $eModel->getCallCenter();		

		$this->view->assign('call', $rs['call'][0]);
		$this->view->assign('account', $rs['account'][0]);
		$this->view->assign('list', $rs);
		$this->display();
	}


	function callProcessAction(){
		$eModel = Lemon_Instance::getObject("EtcModel", true);

		$eModel->updateCallCenter();

		$rs = $eModel->getCallCenter();

		$string .= "var call = new Array(); \n" ;
		$string .= "var bank = new Array(); \n" ;

		for ($i=0; $i<count((array)$rs); $i++) {
			$call = $rs[$i]['call'] ;
			$bank = $rs[$i]['account'] ;
			
			if (empty($account ) ) { 
				$string .= "call[$i] = '$call' ;\n " ;
			}
			if (empty($account ) ) { 
				$string .= "bank[$i] = '$bank' ;\n " ;	
			}			
		}

		 

		$file =  $_SERVER['DOCUMENT_ROOT']. "/_compile/callCenter.js" ;
		file_put_contents($file, $string);
	
		$this->redirect("/etc/call");
	}

}

?>