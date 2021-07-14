<?php 


class BoardController extends WebServiceController 
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
		$this->view->define(array("content"=>"content/board_list.html"));

		if(!$this->auth->isLogin())
		{
			// $this->redirect("/login");
			$this->redirect("/");
			exit;
		}
		
		$bbsNo 		= $this->req->request('bbsNo');
		$selector = $this->req->request('selector');
		$keyword 	= $this->req->request('keyword');
		
		if($bbsNo=="") 
			$bbsNo=5;
			
		if( !$this->req->isNumberParameter($bbsNo))
		{
			throw new Lemon_ScriptException("잘못된 접근입니다.");
			exit;
		}
		
		//5:free bbs, 1:game bbs, 6:sport news, 2:notice, 7: event
		switch($bbsNo)
		{
			case 1:$titleImage="stitle_game.gif"; 	$pageName="BOARD<span class=\"board_mini_title\">게시판</span>"; break;
			case 2:$titleImage="stitle_notice.gif"; $pageName="NOTICE<span class=\"board_mini_title\">공지사항</span>"; break;
			case 5:$titleImage="stitle_free.gif"; 	$pageName="BOARD<span class=\"board_mini_title\">게시판</span>"; break;
			case 6:$titleImage="stitle_sports.gif"; $pageName="스포츠뉴스"; break;
            case 7:$titleImage="stitle_sports.gif"; $pageName="EVENT<span class=\"board_mini_title\">이벤트</span>"; break;
		}
	
		$boardModel = Lemon_Instance::getObject("BoardModel", true);
		$memberModel = Lemon_Instance::getObject("MemberModel", true);

		if($keyword!="")
		{
			if($selector=="title")				$where = " and title like('%".$keyword."%')";
			elseif($selector=="content")	$where = " and content like('%".$keyword."%')";
		}

		$page_act = "keyword=".$keyword."&selector=".$selector."&bbsNo=".$bbsNo;
		$total 			= $boardModel->getTotal($bbsNo, $where);
		$pageMaker 	= $this->displayPage($total,20, $page_act);

        $topList = array();
		if($bbsNo != 7 && $bbsNo != 8)
        {
            $topList = $boardModel->getNoticeList();
        }

		$list = $boardModel->getList($bbsNo, $pageMaker->first, $pageMaker->listNum, $where);
		
		if(count((array)$_SESSION['member']) > 0) {
			$level = $memberModel->getMemberField($this->auth->getSn(),'mem_lev');
		} else {
			$level = 0;
		}
		

		$this->view->assign('bbsNo', $bbsNo);
		$this->view->assign('selector', $selector);
		$this->view->assign('keyword', $keyword);
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
		$this->view->define(array("content"=>"content/board_view.html"));

		if(!$this->auth->isLogin())
		{
			//$this->redirect("/login");
			$this->redirect("/");
			exit;
		}
		
		$gameListModel = Lemon_Instance::getObject("GameListModel", true);
		$memberModel 	= $this->getModel("MemberModel");
		$memberInfo = $memberModel->getMemberRow($this->auth->getSn(),"nick");				

		$bbsNo = $this->req->request('bbsNo');
		$mode = $this->req->request('mode');
		$article = $this->req->request('Article_id');
		
		if($bbsNo=="") 
			$bbsNo=5;
			
		if( !$this->req->isNumberParameter($bbsNo) ||  !$this->req->isNumberParameter($article))
		{
			throw new Lemon_ScriptException("잘못된 접근입니다.");
			exit;
		}
			
		
		//1:monaco bbs, 5:game bbs, 6:sport news, 7:event
		switch($bbsNo)
		{
            case 1:$titleImage="stitle_game.gif"; 	$pageName="BOARD<span class=\"board_mini_title\">게시판</span>"; break;
            case 2:$titleImage="stitle_notice.gif"; $pageName="NOTICE<span class=\"board_mini_title\">공지사항</span>"; break;
            case 5:$titleImage="stitle_free.gif"; 	$pageName="게임분석 게시판"; break;
            case 6:$titleImage="stitle_sports.gif"; $pageName="스포츠뉴스"; break;
            case 7:$titleImage="stitle_sports.gif"; $pageName="EVENT<span class=\"board_mini_title\">이벤트</span>"; break;
		}
		
		
		$eModel = Lemon_Instance::getObject("EtcModel", true);
		$cModel = Lemon_Instance::getObject("ConfigModel", true);
		$model  = Lemon_Instance::getObject("BoardModel", true);
		
		if($mode=="comment")
		{
			$rs = $cModel->getAdminConfigRow('comment_content_len, comment_write_time');

			//글자 수 검사
			$reply = trim($this->req->request('reply'));
			if($reply=="")
			{
				throw new Lemon_ScriptException("내용을 입력해주세요.");				
				exit;
			}
			
			if($this->str_len($reply)>$rs['comment_content_len'])
			{
				$msg = $commentcontentlen." 글자를 초과할 수 없습니다.";
				throw new Lemon_ScriptException($msg);				
				exit;
			}
			$reply=str_replace(chr(13),"<br>",htmlspecialchars($reply, ENT_QUOTES));
			
			$mid = $this->req->request('mid');
			
			$lastTime = $model->getReplyLastTime($article, $mid);
			$xtime=$this->diffdate($lastTime);
			
			//댓글 시간 검사
			if($xtime<$rs['comment_write_time'])
			{
				$msg = $commentwritetime." 수분내에 중복 댓글을 달 수 없습니다.";
				throw new Lemon_ScriptException($msg);				
				
				exit;
			}
			
			//이벤트 횟수 검사
			if($bbsNo==7)
			{
				$nick = $this->auth->getName();
				$replyCount = $model->eventReplyEnable($article, $nick);
				
				if($replyCount > 0)
				{
					throw new Lemon_ScriptException("이미 이벤트에 참여하셨습니다.");
					exit;
				}
			}
			
			$rs = $model->addReply($article, $reply, $this->auth->getSn());
			if($rs=="auth_failed")
			{
				throw new Lemon_ScriptException('댓글 권한이 없습니다. 관리자에게 문의하십시요.','','go', $url);				
				exit;
			}
			else if($rs > 0)
			{
				$url = "/board/view?Article_id=".$article."&bbsNo=".$bbsNo;
				throw new Lemon_ScriptException('코멘트가 성공적으로 등록되었습니다.','','go', $url);				
				exit;
			}
			else
			{
				throw new Lemon_ScriptException('코멘트 등록에 실패하였습니다.');				
				exit;
			}
		}

		if($mode=="reply")
		{
			$comment = trim($this->req->request('comment'));
			$reid = $this->req->request("reid");
			$id	  = $this->req->request('id');
			
			$lastTime = $model->getReplyLastTime($article, $reid);
			$xtime=$this->diffdate($lastTime);
			
			if($xtime<1)
			{
				throw new Lemon_ScriptException('너무 빈번합니다. 잠시 뒤에 다시 시도하십시오.');								
				exit;
			}
			
			$rs = $model->modifyReply($comment, $reid, $this->auth->getId());
			
			if($rs>0)
			{
				$url = "/board/view?Article_id=".$id."&bbsNo=".$bbsNo;;
				throw new Lemon_ScriptException('코멘트가 성공적으로 수정되었습니다.', '', 'go', $url);
				exit;
			}
			else
			{
				throw new Lemon_ScriptException('코멘트 수정에 실패하였습니다.');				
				exit;
			}
		}
		elseif($mode=="del")
		{
			$id		= $this->request('id');
			$reid 	= $this->request('reid');
			
			$rs = $model->delReplyById($reid, $id);
			
			if($rs>0)
			{
				$url = "/board/view?Article_id=".$article."&bbsNo=".$bbsNo;;
				throw new Lemon_ScriptException('코멘트가 성공적으로 삭제되었습니다.', '', 'go', $url);
				exit;
			}
			else
			{
				throw new Lemon_ScriptException('코멘트 삭제 실패하였습니다.');				
				exit;
			}
		}
		
		elseif($mode=="hdel")
		{
			$rs = $model->hDel($this->auth->getName());

			if($rs>0)
			{
				$url = "/board/?bbsNo=".$bbsNo."&bbsNo=".$bbsNo;;
				throw new Lemon_ScriptException('게시글이 정상적으로 삭제되었습니다.', '', 'go', $url);				
				
				exit;
			}
			else
			{
				throw new Lemon_ScriptException('코멘트 삭제 실패하였습니다.');								
				exit;
			}
		}
		
		$model->modifyHit($article,0);
		$item = $model->getContent($article);
		
		if($item['betting_no']!=null && $item['betting_no']!='')
		{
			$betting = explode(";", $item['betting_no']);
			for( $i=0; $i<count((array)$betting); ++$i)
			{
				if( $betting[ $i]!="")
				{
					$bettingItems[ $i]['betting'] = $gameListModel->getBoardBettingItem_admin($betting[ $i]);
				}
			}
			
			//$bettingItem = $gameListModel->getBoardBettingItem($item['betting_no']);
		}
		else
        {
            $betting_temp = $item['betting_temp'];
            $betting_temp_m = $item['betting_temp_m'];
        }

		$replyList = $model->getReplyList($article);
		
		$memberModel = Lemon_Instance::getObject("MemberModel", true);
		//$level = $memberModel->getMemberField($this->auth->getSn(),'mem_lev');
		$level = $memberModel->getMemberField($article,'mem_lev');
		
		//print_r($replyList);

		
		$this->view->assign('bbsNo', $bbsNo);
		$this->view->assign('replyList', $replyList);
		$this->view->assign('article', $article);
		//$this->view->assign('level', $level);
		$this->view->assign('titleImage', $titleImage);
		$this->view->assign('pageName', $pageName);
		$this->view->assign('bettingItem', $bettingItems);
        $this->view->assign('betting_temp', $betting_temp);
        $this->view->assign('betting_temp_m', $betting_temp_m);
		$this->view->assign('item', $item);
		
		$this->display();
	}
	
	function writeAction()
	{
		$this->commonDefine('type');
		$this->view->define(array("content"=>"content/board_write.html"));
		
		if(!$this->auth->isLogin())
		{
			//$this->redirect("/login");
			$this->redirect("/");
			exit;
		}
		
		$model 					= $this->getModel("BoardModel");
		$commonModel 		= $this->getModel("CommonModel");
		$gameListModel 	= $this->getModel("GameListModel");
		$memberModel 	= $this->getModel("MemberModel");
		$memberInfo = $memberModel->getMemberRow($this->auth->getSn(),"nick");		
		
		$act			 = $this->req->request('act');
		$author		 = $this->req->request('author');	
		$title		 = $this->req->request('title');
		$content	 = $this->req->request('content');
		$sn				 = $this->req->request('sn');
		$bettings = $this->req->request('bettings');
		
		if( !$this->req->isNumberParameter($sn))
		{
			throw new Lemon_ScriptException("잘못된 접근입니다.");
			exit;
		}
	
		if($act=="writeok")
		{
			$content	=	str_replace(chr(13),"<br>", $content);
			$ip = $commonModel->getip();
			$rs = $model->addContent($author, $title, $content, $bettings, $ip  );
			
			if($rs=="auth_failed")
			{
				throw new Lemon_ScriptException('게시물 작성 권한이 없습니다. 관리자에게 문의해 주세요.','','go','/board/');					
				exit;
			}
			else if($rs > 0)
			{
				//-> 글쓰기 알람 업데이트.
				$configModel = $this->getModel("ConfigModel");
				$configModel->modifyAlramFlag("new_content",1);

				throw new Lemon_ScriptException('등록되었습니다.','','go','/board/');					
				exit;
			}
			else
			{
				throw new Lemon_ScriptException('등록에 실패하였습니다.');					
				exit;
			}	
		}
		else if($act=="edit")
		{
			$item = $model->getContent($sn);
			$sn = $item["id"];
			$author = $item["author"];
			$title = $item["title"];
			$content = $item["content"];
			$province = $item["province"];
			if( $province != 5 ) {
				throw new Lemon_ScriptException('게시물 수정 권한이 없습니다.','','go','/board/');				
				exit;
			}
		}
		else if($act=="editok")
		{
			$item = $model->getContent($sn);
			$province = $item["province"];
			$nick = $item["author"];

			if( $province != 5 or $memberInfo["nick"] != $nick ) {
				throw new Lemon_ScriptException('게시판 수정 권한이 없습니다.','','go','/board/');				
				exit;
			}

			$content	=	str_replace(chr(13),"<br>", $content);						
			$rs = $model->modifyContent($sn, $title, $content );
			if( $rs > 0 )
			{
				throw new Lemon_ScriptException('수정되었습니다.','','go','/board/');				
				exit;
			}
		}
	
		if($bettings!='')
		{
			$betting = explode(";", $bettings);
			for( $i=0; $i<count((array)$betting); ++$i)
			{
				if( $betting[ $i]!="" && $this->req->isNumberParameter($betting[ $i]))
				{
					$bettingItems[ $i]['betting'] = $gameListModel->getBoardBettingItem($betting[ $i]);
				}
			}
		}
		
		$this->view->assign('betting_item', $bettingItems);
		$this->view->assign('bettings', $bettings);
		$this->view->assign('sn', $sn);
		$this->view->assign('act', $act);
		$this->view->assign('author', $author);
		$this->view->assign('title', $title);
		$this->view->assign('content', $content);
				
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
}

?>