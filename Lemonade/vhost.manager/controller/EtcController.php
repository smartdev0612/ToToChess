<?php 

class EtcController extends WebServiceController
{
	//▶ sms
	function smsAction()
	{
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		
		$sModel = $this->getModel("SmsModel");
		$addWhere = ' and status=0 ';
		$sms = $sModel->getTotal($addWhere);
		
		echo($sms);
	}

	//▶ sms 목록
	function smslistAction()
	{
		$this->commonDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		
		$this->view->define("content","content/etc/sms_list.html");
		
		$eModel = $this->getModel("EtcModel");
		$sModel = $this->getModel("SmsModel");
		$act 	= $this->request('act');
		
		if(isset($act) && $act=="send")
		{
			include_once("/include/sms.php");
			
			$phone 	= $this->request("phone");
			$code	= $this->request("code");
			$id		= $this->request("id");
			
			$sModel->modifyStatus($id,'1');
			
			$msg = sms_send($phone,$code);
			
			throw new Lemon_ScriptException($msg,"","go","/etc/smslist");
			
			exit;
		}
		if(isset($act) && $act=="del")
		{
			$arrmemidx = $this->request("y_id");
			$str="";
			
			for($i=0;$i<count($arrmemidx);$i++)
			{
				$str=$str.$arrmemidx[$i].",";
			}
			$str=substr($str,0,strlen($str)-1);
			
			$sModel->del($str);

			throw new Lemon_ScriptException("","","go","/etc/smslist");
			exit;
		}
		if(isset($act) && $act=="block")
		{
			$ip		= $this->request("ip");
			
			$rs = $sModel->add($ip);
			
			if($rs>0)
			{
				throw new Lemon_ScriptException("ip 차단 되였습니다.","","go","/etc/smslist");
				exit;
			}
			else
			{
				throw new Lemon_ScriptException("실패 하였습니다.","","go","/etc/smslist");				
				exit;
			}
		}
		if(isset($act) && $act=="remove")
		{
			$ip		= $this->request("ip");
			
			$rs = $sModel->remove($ip);
			
			if($rs>0)
			{
				throw new Lemon_ScriptException("ip 해제 되였습니다.","","go","/etc/smslist");				
				exit;
			}
			else
			{
				throw new Lemon_ScriptException("실패 하였습니다.","","go","/etc/smslist");				
				exit;
			}
		}
		
		$page 	 = !($this->request('page'))?'1':intval($this->request('page'));
		$perpage = !($this->request('perpage'))?'10':intval($this->request('perpage'));
		$total	 = $sModel->getTotal();
		
		$pageMaker = Lemon_Instance::getObject("Lemon_Page");
		$pageMaker->setListNum($perpage);
		$pageMaker->setPageNum(10);
		$pageMaker->setPage($page, $total);
		$pagelist = $pageMaker->pageList();
	
		$smsList = $sModel->getList($pageMaker->first, $pageMaker->listNum);
		
		$this->view->assign('smsList', $smsList);
		$this->view->assign('pagelist', $pagelist);
		$this->display();
	}
	
	//▶ 주기적으로 갱신되는 TOP 의 내용
	function refreshAction()
	{
		$eModel = $this->getModel("EtcModel");
		echo $eModel->getRefresh();
	}
	
	//▶ ip 차단관리
	function killiplistAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/etc/ip_list.html");
		
		$eModel = $this->getModel("EtcModel");
		
		$act	= $this->request("act");
		if($act=="") $act="list";
		
		if(isset($act) && $act=="remove")
		{
			$ip = $this->request("ip");
			
			if($ip=="") exit;
			
			$rs = $eModel->revokeIp($ip);
			
			if($rs>0)
			{
				$this->alert0('ip 해제 되였습니다.');
				echo "<meta http-equiv='refresh' content='0; url=/etc/killiplist?act=list' >";
				exit;
			}
			else
			{
				$this->alert0('실패 하였습니다.');
				echo "<meta http-equiv='refresh' content='0; url=/etc/killiplist?act=list' >";
				exit;
			}
		}
		if(isset($act) && $act=="add_ip")
		{
			$ip  = $this->request("ip");
			$web = $this->request("web");
			
			if($ip=="" || $web=="")
			{
				$this->alert0('추가할 아이피를 선택해 주세요');
				echo "<meta http-equiv='refresh' content='0; url=/etc/killiplist?act=list' >";
				exit;
			}
			$rs = $eModel->killIp($ip, $web);
			
			if($rs>0)
			{
				$this->alert0('ip 봉쇄 되였습니다.');
				echo "<meta http-equiv='refresh' content='0; url=/etc/killiplist?act=list' >";
				exit;
			}
			else
			{
				$this->alert0('실패 하였습니다.');
				echo "<meta http-equiv='refresh' content='0; url=/etc/killiplist?act=list' >";
				exit;
			}
		}

		if(isset($act) && $act=="list")
		{
			$total 			= $eModel->killIpTotal();
			
			$pageMaker 	= $this->displayPage($total, 5);
			$list 			= $eModel->killIpList($pageMaker->first, $pageMaker->listNum);
			
			$this->view->assign('list', $list);
		}
		$this->display();
	}
	
	//▶ 관리자 암호변경
	function changepasswdAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/etc/change_passwd.html");
		$eModel = $this->getModel("EtcModel");
		
		$mode	= $this->request("mode");
		
		if($mode=="upup")
		{
			$psw1	= $this->request("psw1");
			$psw2	= $this->request("psw2");
			
			$rs = $eModel->getAdminPasswd($psw1);
	
			if(count((array)$rs)<=0)
			{
				echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><script>alert('현재 비밀번호 틀립니다. 정확한 비밀번호를 입력해 주시기 바랍니다.');window.close();</script>";
				exit;
				$db->dbclose();
			}
			else
			{
				$rs = $eModel->modifyAdminPasswd($psw2);
				
				if($rs<=0)
				{
					echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><script>alert('변경이 실패하였습니다. 관리원과 연락해 주시기 바랍니다.');window.close();</script>";
					exit;
				}
				else
				{
					echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><script>alert('변경이 완료 되었습니다.');window.close();</script>";
					exit;
				}
			}
		}
		$this->display();
	}
	
	//▶ 잭팟 초기화
	function clearjackpotAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/etc/clear_jackpot.html");
		$eModel = $this->getModel("EtcModel");
		
		$mode = $this->request("mode");
		
		if($mode=="clear")
		{
			$eModel->clearJackpot();
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><script>alert('clear jackpot is success.');window.close();</script>";
			exit;
		}
		$this->display();
	}
	
	function GameFinProcessAction()
	{
		$game_fin_model = $this->getModel("GameFinModel");
		$game_fin_model->finProcess();
		
		echo "true";
	}
}

?>