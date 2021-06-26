<?php 

class CsController extends WebServiceController 
{
	function layoutDefine($type='')
	{
		//-> 중복로그인 체크 전체 페이지 적용
		if ( $this->auth->getSn() > 0 ) {
			$mModel = $this->getModel("MemberModel");
			$dbSessionId = $mModel->getMemberField($this->auth->getSn(), 'sessionid');
			if($dbSessionId!=session_id()) {
				if($this->auth->isLogin()) {
					session_destroy();
				}
				throw new Lemon_ScriptException("중복접속 되었습니다. 다시 로그인 해 주세요.", "", "go", "/");
				exit;
			}
		}

		$this->view->define("index","layout/layout.sports.html");

		$live_game_model = $this->getModel("LiveGameModel");		
		$gameList = $live_game_model->getLiveGameList($where);

		$this->view->assign("game_list",  $gameList);
	}

	function indexAction()
	{
		$this->commonDefine('type');

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->redirect("/");
			exit;
		}
		
		$bbsNo 	= 2;
		
		$titleImage="stitle_notice.gif"; $pageName="공지사항";
		
		$boardModel = $this->getModel("BoardModel");
		$memberModel = Lemon_Instance::getObject("MemberModel", true);

		$total = $boardModel->getTotal($bbsNo);
		$pageMaker 	= $this->displayPage($total,30);
		$list = $boardModel->getList($bbsNo, $pageMaker->first, $pageMaker->listNum);
		
		for($i=0; $i<count((array)$list); ++$i)
		{
			$var = (int)($this->diffdate($list[$i]['time']));
			if(($var/(60*24))<31) $list[$i]['new'] = true;
			else $list[$i]['new']=false;
		}
		
		$level = $memberModel->getMemberField($this->auth->getSn(),'mem_lev');
		
		//추천 게시목록
		//$topList = $boardModel->getTopList();
		
		$this->view->assign('bbsNo', $bbsNo);
		$this->view->assign('titleImage', $titleImage);
		$this->view->assign('pageName', $pageName);
		$this->view->assign('level', $level);
		$this->view->assign('list', $list);
		$this->view->assign('top_list', $topList);
		
		$this->display();
	}
	
	function viewAction()
	{
		$this->commonDefine('type');

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->redirect("/");
			exit;
		}
		
		$bbsNo 		= $this->req->request('bbsNo');
		$mode		= $this->req->request('mode');
		$article 	= $this->req->request('Article_id');
		
		$bbsNo=2;
		
		$titleImage="stitle_notice.gif"; 	$pageName="공지사항";

		$cModel = Lemon_Instance::getObject("ConfigModel", true);
		$eModel = Lemon_Instance::getObject("EtcModel", true);
		$model = Lemon_Instance::getObject("BoardModel", true);
		
		if($mode=="comment")
		{
			$rs = $cModel->getAdminConfigRow('comment_content_len, comment_write_time');

			//글자 수 검사
			$reply = trim($this->req->request('reply'));			
			if($this->str_len($reply)>$rs['comment_content_len'])
			{
				$msg = $commentcontentlen." 글자를 초과할 수 없습니다.";
				throw new Lemon_ScriptException($msg);												
				
				exit;
			}
			$reply=str_replace(chr(13),"<br>",htmlspecialchars($reply));
			
			$mid = $this->req->request('mid');
			
			$lastTime = $model->getReplyLastTime($article, $mid);
			$xtime=diffdate($lastTime);
			
			//댓글 시간 검사
			if($xtime<$rs['comment_write_time'])
			{
				$msg = $commentwritetime."분내에 중복댓글을 달 수 없습니다";
				throw new Lemon_ScriptException($msg);												
				
				exit;
			}
			
			$rs = $model->addReply($article, $reply);

			if($rs>0)
			{
				$url = "/board/view?Article_id=".$article;
				throw new Lemon_ScriptException("코멘트가 성공적으로 등록되었습니다.", "", "go", $url);																
				
				exit;
			}
			else
			{
				throw new Lemon_ScriptException("코멘트 등록에 실패하였습니다.");				
				exit;
			}
		}

		if(isset($mode) && $mode=="reply")
		{
			$comment = trim($this->req->request('comment'));
			$reid = $this->req->request("reid");
			$id	  = $this->req->request('id');
			
			$lastTime = $model->getReplyLastTime($article, $reid);
			$xtime=diffdate($lastTime);
			
			if($xtime<1)
			{
				throw new Lemon_ScriptException("너무 빈번합니다. 잠시 뒤에 다시 시도하십시오.");
				
				exit;
			}
			
			$rs = $model->modifyReply($comment, $reid, $this->auth->getId());
			
			if($rs>0)
			{
				$url = "/board/view?Article_id=".$id;
				throw new Lemon_ScriptException("코멘트가 성공적으로 수정되었습니다.", "", "go", $url);				
				
				exit;
			}else{
				throw new Lemon_ScriptException("코멘트 수정에 실패하였습니다.");
				exit;
			}
		}
		if(isset($mode) && $mode=="del")
		{
			$id		= $this->req->request('id');
			$reid 	= $this->req->request('reid');
			
			$rs = $model->delReplyById($reid, $id);
			
			if($rs>0)
			{
				$url = "/board/view?Article_id=".$id;
				throw new Lemon_ScriptException("코멘트가 성공적으로 삭제되었습니다.", "", "go", $url);								
				
				exit;
			}
			else
			{
				throw new Lemon_ScriptException("코멘트 삭제 실패하였습니다.");
				exit;
			}
		}
		
		if(isset($mode)&&$mode == "hdel")
		{
			$rs = $model->hDel($this->auth->getName());

			if($rs>0)
			{
				$url = "/board/?bbsNo=".$bbsNo;
				throw new Lemon_ScriptException("게시글이 정상적으로 삭제되었습니다.", "", "go", $url);
				exit;
			}
			else
			{
				throw new Lemon_ScriptException("코멘트 삭제 실패하였습니다.");
				exit;
			}
		}
		
		$model->modifyHit($article,0);
		$item = $model->getContent($article);
		
		$replyList = $model->getReplyList($article);
		
		$mModel = Lemon_Instance::getObject("MemberModel", true);
		$level = $mModel->getMemberField($this->auth->getSn(), 'mem_lev');

		$this->view->assign('bbsNo', $bbsNo);
		$this->view->assign('replyList', $replyList);
		$this->view->assign('article', $article);
		$this->view->assign('level', $level);
		$this->view->assign('titleImage', $titleImage);
		$this->view->assign('pageName', $pageName);
		$this->view->assign('item', $item);
		
		$this->display();
	}
	
	function ruleAction()
	{
		$this->commonDefine();
		$this->view->define(array("content"=>"content/rule.html"));

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->redirect("/");
			exit;
		}
		
		$boardModel = $this->getModel("BoardModel");
		$content = $boardModel->getSiteRuleRow(2, "content");
		
		$tab_index = $this->req->request("tab_index");
		if( $tab_index=="")
			$tab_index = 0;
		
		$this->view->assign('content', $content);
		$this->view->assign('tab_index', $tab_index);
		
		$this->display();
	}
	
	function guideAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->redirect("/");
			exit;
		}
		
		$boardModel = $this->getModel("BoardModel");
		$content = $boardModel->getSiteRuleRow(2, "content");
		
		$this->view->assign('content', $content);
		
		$this->display();
	}
	
	function termsAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->redirect("/");
			exit;
		}
		$this->display();
	}
	
	function handicapAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->redirect("/");
			exit;
		}
		$this->display();
	}
	
	function faqAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->redirect("/");
			exit;
		}
		$bModel = Lemon_Instance::getObject("BoardModel", true);
		
		$list = $bModel->getFaqList();
		
		$this->view->assign('list', $list);
		
		$this->display();
	}
	
	function questionAction()
	{
		$this->commonDefine('type');
		$this->view->define(array("content"=>"content/question.html"));

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->redirect("/");
			exit;
		}
		
		$this->display();
	}
	
	function cs_listAction()
	{
		$this->commonDefine('type');
		$this->view->define(array("content"=>"content/cs_list.html"));

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->redirect("/");
			exit;
		}
		
		$page = $this->req->request('page');
		if($page=="") $page=1;
		
		$uid  = $this->auth->getId();
		$act	= $this->request("act");
		
		$boardModel = Lemon_Instance::getObject("BoardModel", true);
		$cconfigModel = Lemon_Instance::getObject("ConfigModel", true);
		$memberModel = Lemon_Instance::getObject("MemberModel", true);

		$memberModel->updateCustomerAnswerFlag($uid);
		
		if($act=="add")
		{
			$title 	 = $this->request("title");
			$content = $this->request("content");
			$mxLen 	 = $cconfigModel->getAdminConfigField('quetion_content_len');
			
			if($content=="")
			{
				throw new Lemon_ScriptException("내용을 입력하여 주십시오.");
				exit;
			}
			if($this->str_len($content) > $mxLen)
			{
				$msg = "고객센터 - ".$mxLen." 글자를 초과할 수 없습니다.";
				throw new Lemon_ScriptException($msg);				
				exit;
			}

			$notCsCnt = $boardModel->getMemberNotCsTotal($uid);
			if ( $notCsCnt > 0 ) {
				throw new Lemon_ScriptException("앞선 문의의 관리자 답변을 기다리고 있습니다.\\n\\n답변을 받은 후 재문의 하여 주세요.", "", "go", "/cs/cs_list");
				exit;
			}

			if ( $content == "계좌 문의" ) {
				//-> 계좌문의시 오토 답변.
				//$rs = $boardModel->addMemberCsAutoReply($uid, $title, $content, "문의", $this->auth->getSn());

				$rs = $boardModel->addMemberCs($uid, $title, $content, "계좌문의", $this->auth->getSn());
			} else {
				$rs = $boardModel->addMemberCs($uid, $title, $content, "문의", $this->auth->getSn());
			}
			if($rs=="auth_failed")
			{
				throw new Lemon_ScriptException("게시물작성 권한이 없습니다. 관리자에게 문의해 주세요.", "", "go", "/cs/cs_list");
				exit;
			}
			else if($rs > 0)
			{
				throw new Lemon_ScriptException("등록되었습니다.", "", "go", "/cs/cs_list");
				exit;
			}
			else
			{
				throw new Lemon_ScriptException("문의등록에 실패하였습니다.");
				
				exit;
			}
		}
		elseif($act=="delete_all")
		{
			$memberId = $this->auth->getId();
			$rs = $boardModel->deleteMemberCsAll($memberId);
			if($rs>0)
			{
				throw new Lemon_ScriptException("삭제되었습니다.","","go","/cs/cs_list");					
			}
			else
			{
				throw new Lemon_ScriptException("문의삭제에 실패하였습니다.");					
				exit;
			}
		}
		elseif($act=="del")
		{
			$idx=$this->request("idx");
			$memberId=$this->auth->getId();

			$rs = $boardModel->deleteMemberCs($idx, $memberId);
			
			if($rs>0)
			{
				throw new Lemon_ScriptException("삭제되었습니다.","","go","/cs/cs_list");
			}
			else
			{
				throw new Lemon_ScriptException("문의삭제에 실패하였습니다.");					
				exit;
			}
		}
		//삭제상태
		$where=" and state='N'";
		
		$total = $boardModel->getMemberCsTotal($uid);
		$pageMaker 	= $this->displayPage($total,30);
		$pagelist = $pageMaker->pageList();		
		$list = $boardModel->getMemberCsList($uid, $pageMaker->first, $pageMaker->listNum, $where);
		
		//추천 게시목록
		//$topList = $boardModel->getTopList();
		
		$this->view->assign('list', $list);
		$this->view->assign('top_list', $topList);
		$this->display();
	}
	
	// help functions
	function diffdate($lastWriteDate)
	{
		$atime=date("Y-m-d H:i");
		$xtime=strtotime($atime) - strtotime($lastWriteDate);
		$xtime=$xtime/60;
		$xtime=round($xtime); 
		return $xtime;
	}
	
	function str_len($str) 
	{
		$i = 0;
		$count = 0;
		$len = strlen ($str);
		while ($i < $len) {
			$chr = ord ($str[$i]);
			$count++;
			$i++;
			if($i >= $len) break;
			if($chr & 0x80) {
				$chr <<= 1;
				while ($chr & 0x80) {
					$i++;
					$chr <<= 1;
				}
			}
		}
		return $count;
	}


	function gameAction()
	{
		$this->commonDefine();
		$this->view->define(array("content"=>"content/game.html"));

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->redirect("/");
			exit;
		}
		
		$conf = Lemon_Configure::readConfig('config');
		 if($conf['site']!='')
		 	$download_url = $conf['site']['upload_url']."/upload/kingdom_setup.zip";
		 	
		 $this->view->assign('download_url', $download_url);
		$this->display();
	}
	
}

?>