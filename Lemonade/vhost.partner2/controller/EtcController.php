<?php

class EtcController extends WebServiceController 
{
	//▶ 주기적으로 갱신되는 TOP 의 내용
	function refreshAction()
	{
		$eModel = $this->getModel("EtcModel");
		
		$id 	= $this->auth->getId();
		$eModel->getPartnerRefresh($id);
	}
	function popup_ChangePasswordAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/etc/popup.change.password.html");
		
		$model = $this->getModel("PartnerModel");
		
		$sn 	= $this->auth->getSn();
		
		if($this->request("act") == "change")
		{		
			$nowpass = trim($this->request("nowpass"));
			$newpass = trim($this->request("newpass"));
			$newpass2 = trim($this->request("newpass2"));
			
			if($newpass==$nowpass)
			{
				throw new Lemon_ScriptException("동일한 비밀번호 입니다.확인 하십시오!","","back");
				exit;	
			
			}
			
			$rec_psw = $model->getPassword($sn);		
			
			if($rec_psw!=md5($nowpass))
			{
				throw new Lemon_ScriptException("현재 비밀번호가 일치 하지않습니다.");
				exit;
				
				
			}
			
			$model->modifyChangePassword($sn, $newpass);
			
			session_start();
			session_unset();
			
			throw new Lemon_ScriptException("","","script","alert('변경되였습니다.');window.opener.top.location.href=window.opener.top.location.href;window.close();");
			
			exit;
		
		}
		
		$this->display();
	}
	
	function popup_ChangeBankAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/etc/popup.change.bank.html");
		
		$model = $this->getModel("PartnerModel");
		$sn 	= $this->auth->getSn();
		
		if( $this->request("act") == "change" )
		{
			if(!preg_match('/^\d*$/',$this->request("banknum")))
			{
				throw new Lemon_ScriptException("계좌번호는 숫자만 가능합니다.");				
				exit;
			}
			if(preg_match("/[ '.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$this->request("bankusername")))
			{
				throw new Lemon_ScriptException("특수문자를 사용할수 없습니다.");				
				exit;
			}
			
			$bankname 		= $this->request("bankname");
			$banknum 		= $this->request("banknum");
			$bankusername 	= $this->request("bankusername");
			
			$model->modifyChangeBank($bankname,$banknum,$bankusername,$sn);
			
			throw new Lemon_ScriptException("","","script","alert('변경 되였습니다.');opener.document.location.reload(); self.close();");
			
		}		
		
		$list = $model->getPartnerBySn($sn);
		
		$this->view->assign('list', $list);
		
		$this->display();
	}
	
	
	
	
}
?>