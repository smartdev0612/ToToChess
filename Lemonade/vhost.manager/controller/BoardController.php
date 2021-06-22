<?php 


class BoardController extends WebServiceController 
{
	//▶ 게시판 목록
	function listAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/board/list.html");
		
		$model = $this->getModel("BoardModel");
		$cModel = $this->getModel("CommonModel");

		//-> 알람 초기화.
		$configModel = $this->getModel("ConfigModel");
		$configModel->modifyAlramFlag("new_content",0);

		$act 			= $this->request('act');
		$field 		= $this->request('field');
		$keyword 	= $this->request('keyword');
		$subject 	= $this->request("subject");
		$province	= $this->request("province");
		$beginDate= $this->request("begin_date");
		$endDate= $this->request("end_date");
		
		if($beginDate=="" || $endDate=="")
		{
			$beginDate 	= date("Y-m-d",strtotime ("-7 days"));
			$endDate		= date("Y-m-d");
		}
		
		$pageact="act=".$act."&field=".$field."&keyword=".$keyword."&subject=".$subject."&province=".$province."&begin_date=".$beginDate."&end_date=".$endDate;
		// 삭제
		if($act=='del')
		{
			$id = $this->request('id');
			
			$rs = $model->getContentById($id);
			for($i=0; $i<count((array)$rs); ++$i)
			{
				$imgnum = $rs[$i]["imgnum"];
				$pic	= $rs[$i]["pic"];
				if($imgnum!=0 &&  $pic!="")
				{
					$arr=explode("|",$pic);
					for($j=0;$j<count($arr);$j++)
					{
						$temp= $_SERVER[ 'DOCUMENT_ROOT'].$arr[$i];
						if(file_exists($temp))
						{
							unlink($temp);
						}
					}
				}
			}
			$model->delContentById($id);
		}
		
		// 모두 삭제
		if($act=='alldel')
		{
			
			$rsi = $this->request("y_id");
			
			$sum_id;
			for($i=0;$i<count($rsi);$i++)
			{
				$sum_id.= $rsi[$i].",";
			}
			
			$sum_id = substr($sum_id,0,strlen($sum_id)-1);
			  	
			 $rs = $model->getContentById($sum_id);
			 for($i=0; $i<count((array)$rs); ++$i)
			{
				$imgnum = $rs[$i]["imgnum"];
				$pic	= $rs[$i]["pic"];
				if($imgnum!=0 &&  $pic!="")
				{
					$arr=explode("|",$pic);
					for($j=0;$j<count($arr);$j++)
					{
						$temp= $_SERVER[ 'DOCUMENT_ROOT'].$arr[$i];
						if(file_exists($temp))
						{
							unlink($temp);
						}
					}
				}
			}
			$model->delContentById($sum_id);		
		}

		// 정지
		if($act=='istop')
		{
			$rtop 	= $this->request('top');
			$id		= $this->request('id');
			
			if($rtop=="1") 	{$top="2";}
			if($rtop=="2")	{$top="1";}
			
			$model->modifyTop($id, $top);
		}
		
		// 클릭
		elseif($act=='click')
		{
			$rsi = $this->request("y_id");
			$sum_id;
			$go	= "/board/list?province=".$province;
			
			for($i=0; $i< count((array)$rsi);$i++)
			{
				$model->modifyRandomHit($rsi[$i]);
			}

			throw new Lemon_ScriptException("","","go",$go);
		  exit;
		}
	
		if($province=="") $province = 5;
		
		if($beginDate!='' && $endDate!='' && $province != 2 && $province != 7)
			$where.=" and time between '".$beginDate."' and '".$endDate." 23:59:59'";

		if($subject!="")	{$where.=" and a.title like '%".$subject."%'";}
		if($province!="")	{$where.=" and a.province=".$province;}
		
		if($keyword!="")
		{
			if($field=="author")						{$where.=" and a.author like('%".$keyword."%')";}
			else if($field=="title")				{$where.=" and a.title like('%".$keyword."%')";}
			else if($field=="content")			{$where.=" and a.content like('%".$keyword."%')";}
		}
		
		$total = $model->getContentTotal($where, $province);

		$pageMaker 	= $this->displayPage($total, 30, $pageact);
		$list = $model->getContentListPage($where, $pageMaker->first, $pageMaker->listNum, $province);
		
		$this->view->assign('province', $province);
		$this->view->assign('total', $total);
		$this->view->assign('subject', $subject);
		$this->view->assign('type', $type);
		$this->view->assign('field', $field);
		$this->view->assign('keyword', $keyword);
		$this->view->assign('list', $list);
		$this->view->assign('begin_date', $beginDate);
		$this->view->assign('end_date', $endDate);
		
		$this->display();
	}
	
	/*
	 * 게시판 설정
	 */
	function configAction()
	{
		$this->commonDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/board/config.html");
		
		$model = $this->getModel("BoardModel");
		
		$mode 	= $this->request("mode");
		$idx 	= $this->request("idx");
		
		if($mode == "del") 
		{
			$model->delBoard($idx);
		}
		
		if($mode=="alldel")
		{
			$arrmemidx = $this->request("y_id");
			$str="";
			for($i=0;$i<count($arrmemidx);$i++)
			{
				$str=$str.$arrmemidx[$i].",";
			}
			
			$str=substr($str,0,strlen($str)-1);
			
			$model->delBoard($str);
		}
		
		$title = $this->request("title");
		if(!is_null($title) && $title!="")
		{
			$where=" and title like '%".$title."%'";
		}
		
		$total = $model->getBoardTotal($where);
		$pageMaker = $this->displayPage($total, 10);
		$list = $model->getBoardList($where, $pageMaker->first, $pageMaker->listNum);

		$this->view->assign('total', $total);
		$this->view->assign('title', $title);
		$this->view->assign('list', $list);
		
		$this->display();
	}
	
	/*
	 * 게시물 쓰기
	 */
	function writeAction()
	{
		$this->commonDefine();
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		
		$this->view->define("content","content/board/write.html");
		
		$model 	= $this->getModel("BoardModel");
		$memberModel = $this->getModel("MemberModel");
		$gModel = $this->getModel("GameModel");
		$gameListModel = $this->getModel("GameListModel");
		
		$act = $this->request('act');
		
		if($act == "delete_comment")
		{
			$sn = $this->request('sn');
			$id = $this->request('id'); 
			
			$rs = $model->delReply($sn);
			
			if($rs>0)
			{
				$url = "/board/write?id=".$id;
				throw new Lemon_ScriptException('코멘트가 삭제되었습니다.', '', 'go', $url);
				exit;
			}
			else
			{
				$url = "/board/write?id=".$id;
				throw new Lemon_ScriptException('코멘트가 삭제에 실패 하였습니다..', '', 'go', $url);				
				
				exit;
			}
	  }
	  
	  if($act == "modify_comment")
		{
			$sn 			= $this->request('sn');
			$content 	= $this->request('content');
			$id 			= $this->request('id');
			
			$rs = $model->AdminmodifyReply($sn, $content);
			
			if($rs>0)
			{
				$url = "/board/write?id=".$id;
				throw new Lemon_ScriptException('코멘트가 수정되었습니다.', '', 'go', $url);
				exit;
			}
			else
			{
				$url = "/board/write?id=".$id;
				throw new Lemon_ScriptException('코멘트가 수정에 실패 하였습니다.', '', 'go', $url);				
				
				exit;
			}
	  }
	  	
		if($act=="reply")
		{
			$id 					= $this->request('replyid');
		  $replyAuthor 	= $this->request('reply_author');
		  $comment 			= $this->request('comment');		  
		 	
		  $rs = $model->adminReply($id, $replyAuthor, $comment);
		  		
			if($rs > 0)
			{
				$url = "/board/write?id=".$id;
				throw new Lemon_ScriptException('코멘트가 등록되었습니다.', '', 'go', $url);								
			
				exit;
			 }
			 else
			 {
			 	$url = "/board/write?id=".$id;
				throw new Lemon_ScriptException('코멘트 등록에 실패하였습니다.', '', 'go', $url);	
				exit;
			 }
		}
		
		// 배팅첨부내역
		$array_game = array();
		
		$cart = $this->request('cart');
		if( $cart == 'add' )
		{
			
			$child_sn = $this->request('child_sn');
			$bet_date =  $this->request('bet_date');
			$bet_money =  $this->request('bet_money');
			
			$rs = explode(',', $child_sn);
			for( $i = 0; $i < count((array)$rs); ++$i )
			{
				$rsi = explode(':', $rs[$i]);
				$rs_child_sn = $rsi[0];
				$rs_select_no = $rsi[1];			
				
				$list = $gModel->getListBychild_sn($rs_child_sn);	
				$list[0]['select_no']	= $rs_select_no;		
				$array_game[$i] = $list[0];				
			}					
		}
	  //
	  
	  	
		$id = $this->request('id');	
		 
		if(!empty($id))
		{
			$rs = $model->getContentList($id);
			$list = $rs[0];
			$this->view->assign('list', $list);
			
			if($list['betting_no']!=null && $list['betting_no']!='')
			{
				$bettingItem = $gameListModel->getBoardBettingItem_admin($list['betting_no']);
				
				$this->view->assign('bettingItem', $bettingItem);
			//	print_r($bettingItem);
			}
		
				
		 	$replyList = $model->getReplyList($id);	 	
		 	
		 	$this->view->assign('replyList', $replyList);
		 } 
		 else
		 {
		 	$nowTime = date("Y-m-d H:i:s");
		 }
		  	
		 $muneList  	= $model->getBoardCategoryList();
		 $nickList		= $memberModel->getMemberRows("nick, mem_lev", "mem_status='G' ");		 

		 $conf = Lemon_Configure::readConfig('config');
		 if($conf['site']!='')
		 	$UPLOAD_URL = $conf['site']['upload_url']."/upload/images/";
			
		$this->view->assign('array_game', $array_game);	
		$this->view->assign('bet_date', $bet_date);
		$this->view->assign('bet_money', $bet_money);	
			
		$this->view->assign('nowTime', $nowTime);
		$this->view->assign('UPLOAD_URL', $UPLOAD_URL);
		$this->view->assign('id', $id);	
		$this->view->assign('muneList', $muneList);
		$this->view->assign('nickList', $nickList);		
		$this->display();	
	}
	
	//▶ 배팅규정 쓰기
	function site_rule_editAction()
	{
		$this->commonDefine();
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		
		$this->view->define("content","content/board/site_rule_edit.html");
		
		$boardModel = $this->getModel("BoardModel");

		$act 	= $this->request('act');
		$type	= $this->request('type');
		
		if($type=="")	$type=1;
		
		if($type==1) 			$pageTitle = "회원약관";
		elseif($type==2) 	$pageTitle = "배팅규정";
		
		if($act=="modify")
		{
			$ruleSn 	= $this->request('rule_sn');
			$content	= $this->request('content');
			
			$rs = $boardModel->modifySiteRule($type, $ruleSn, $content);
			
			if($rs>0)
				throw new Lemon_ScriptException("수정되었습니다.");
			else
				throw new Lemon_ScriptException("오류입니다.");
	    }

		$item = $boardModel->getSiteRuleRow($type);
		
		$this->view->assign('item', $item);		
		$this->view->assign('page_title', $pageTitle);
		$this->view->assign('type', $type);
		$this->display();	
	}
	
	/*
	 * 고객센터
	 */
	function questionlistAction()
	{
		$this->commonDefine();
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		
		$this->view->define("content","content/board/question_list.html");
		
		$model = $this->getModel("BoardModel");
		
		$mode 		= $this->request('mode');
		$idx  		= $this->request("idx");
		$field 		= $this->request('field');
		$keyword 	= $this->request('keyword');
		$perpage 	= $this->request('perpage');
		$filter_logo	= $this->request('filter_logo');
		
		$pageact="mode=".$mode."&idx=".$idx."&field=".$field."&keyword=".$keyword."&perpage=".$perpage."&filter_logo=".$filter_logo;
	
		if($perpage=='') $perpage=30;
		if($mode == "del") {$model->deleteMemberCsAll($idx, $filter_logo);}
		
		if($mode=="alldel")
		{
			$arrmemidx = $this->request("y_id");
			$str="";
			for($i=0;$i<count($arrmemidx);$i++)
			{
				$str=$str.$arrmemidx[$i].",";
			}
			$str=substr($str,0,strlen($str)-1);
			
			$model->deleteMemberCsAll($str, $filter_logo);
		}
		
		if($keyword!="")
		{
			if($field=="uid")								{$where.=" and b.uid like('%".$keyword."%')";}
			else if($field=="nick")					{$where.=" and b.nick like('%".$keyword."%')";}
			else if($field=="bank_member")	{$where.=" and b.bank_member like('%".$keyword."%')";}
		}
		if($filter_logo!='')
			$where .= " and a.logo='".$filter_logo."'";
			
		$where.= " and reply=0 ".$addwhere;
		
		$total 		= $model->getCsTotal($where);
		$pageMaker 	= $this->displayPage($total, $perpage, $pageact);
		$list 			= $model->getCsList($where, $pageMaker->first, $pageMaker->listNum);
		
		$this->view->assign('field', $field);
		$this->view->assign('keyword', $keyword);
		$this->view->assign('list', $list);
		$this->view->assign('perpage', $perpage);
		$this->view->assign('filter_logo', $filter_logo);
		$this->display();	
	}
	
	/*
	 * 고객센터뷰
	 */
	function questionviewAction()
	{
		$this->commonDefine();
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		
		$this->view->define("content","content/board/question_view.html");
		
		$model 	= $this->getModel("BoardModel");
		$cModel 	= $this->getModel("ConfigModel");
		
		$idx 			= $this->request('idx');
		$mode		= $this->request('mode');
		$comment 	= $this->request('comment');
		
		if($mode == "add")
		{
			$upcontent = $this->request('upcontent');
			if($upcontent==1)
			{				
				$qidx = $this->request('qidx');
				$comment = htmlspecialchars($comment, ENT_QUOTES);	
				
				$rs = $model->modifyCs($qidx, $comment);
				if( $rs > 0 )
				{
					throw new Lemon_ScriptException('저장 되였습니다.', '', 'go', '/board/questionlist');
					exit;
				}
			}
			else
			{
				$rs = $model->getCsByReplySn( $idx );
				$comment = htmlspecialchars($comment, ENT_QUOTES);
				if( $rs > 0 )
				{
					$rs = $model->modifyCsAnswer($idx, $comment);
					throw new Lemon_ScriptException('답변이 수정 되였습니다.','','go','/board/questionlist');
				} else {
					$model->addCs($idx, $comment);
					$model->modifyCsReply($idx,1);
					throw new Lemon_ScriptException('답변이 저장 되였습니다.','','go','/board/questionlist');
				}				
			}
		}
		
		$list 		= $model->getQuestion($idx);
		$relist 	= $model->getCsReply($idx);
		$admin 	= $cModel->getAdminConfigRows("*", '', $list[0]['logo']);

		$this->view->assign('list', $list);
		$this->view->assign('relist', $relist[0]);
		$this->view->assign('admin', $admin[0]);		
		
		
		$this->display();	
	}
	/*
	 * bbs 리스트
	 */
	function bbsAction()
	{
		$this->commonDefine();
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		
		$this->view->define("content","content/board/bbs.html");
		
		$model = $this->getModel("BoardModel");		
		
		$mode = $this->request('mode');
		$idx = $this->request('idx');
	//	$perpage = $this->post("perpage");
		if( $perpage == '' )
			$perpage = 10;
			
		if($mode == "del") 
		{
			$model->delBoard( $idx );			
		}
		if($mode=="alldel")
		{
			$arrmemidx = $this->request('y_id');
			$str="";
			for($i=0;$i<count($arrmemidx);$i++)
			{
				$str=$str.$arrmemidx[$i].",";
			}
			$str=substr($str,0,strlen($str)-1);
			
			$model->delBoard( $str );						
		}
		
		$title=$this->request('title');
		if(!empty($title))
		{
			$where = " and title like '%".$title."%'";			
		}
		
		$total = $model->getBoardTotal($where);
		$pageMaker = $this->displayPage($total, $perpage);
		$list = $model->getBoardList($where, $pageMaker->first, $pageMaker->listNum);
		
		
		$this->view->assign('list', $list);
		$this->view->assign('total', $total);
		
		$this->display();	
	} 
	
	/*
	 * bbs 뷰
	 */
	function bbsviewAction()
	{
		$this->commonDefine();
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		
		$this->view->define("content","content/board/bbs_view.html");
		
		$model = $this->getModel("BoardModel");		
		$memberModel = $this->getModel("MemberModel");
		
		$sn				= $this->request('idx');
		$mode			= $this->request('mode');
		$comment	= $this->request('comment');
		$id				= $this->request('id');
		$name 		= $this->request('name');
		
		if($mode == "add")
		{			
			$comment = htmlspecialchars($comment, ENT_QUOTES);	
			
			$rs = $model->addBoard_Memo($id, $name, $comment);
			
			$url = "/board/bbsview?idx=".$id;
			throw new Lemon_ScriptException('등록 되였습니다.','','go',$url);			
			
			exit;			
		}
		
		if($mode == "edit")
		{
			
			$title 		= trim($this->request('title'));
			$title 		= htmlspecialchars($title, ENT_QUOTES);
			$time 		= $this->request('time');
			$hit 			= $this->request('hit');
			$content 	= htmlspecialchars($content, ENT_QUOTES);
			
			$model->modifyBoard($id, $title, $content, $time, $hit);
			
			$url = "/board/bbsview?idx=".$id;
			throw new Lemon_ScriptException('수정 되였습니다.','','go',$url);				
		
			exit;
		}
		
		if($mode == "del")
		{
			$delidx = $this->request('delidx');
			$urlidx = $this->request('urlidx');
			$model->delBoard_Memo( $delidx );
			
			$url = "/board/bbs_view?idx=".$urlidx;
			throw new Lemon_ScriptException('','','go',$url);							
			
			exit;
		}
		
		
		$list = $model->getBoardOne($sn);
		$m_list = $memberModel->getMemberRows("mem_id", " nick ='".$list['nick']."' ");
		$admin = $memberModel->getMemberRows("nick", " mem_lev = '99' ");
		
		$memolist = $model->getBoard_Memo($list['num']);
		
		$mem_id = $m_list[0]['mem_id'];
		
		$this->view->assign('mem_id', $mem_id);	
		
		foreach($list as $key=>$value)			
			$this->view->assign( $key, $value);	
		
		$this->view->assign('memolist', $memolist);					
		$this->view->assign('sn', $sn); 
		$this->view->assign('admin', $admin);
	
		$this->display();	
		
	}
	
	/*
	 * 분류관리
	 */
	function typeAction()
	{
		$this->commonDefine();
		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		
		$this->view->define("content","content/board/type.html");
		
		$model = $this->getModel("BoardModel");		
		
		$ok 		= $this->request('ok');
		$name 	= $this->request('name');
		$en 		= $this->request('en');
		$del 		= $this->request('del');
		$id 		= $this->request('id');
		$up 		=	$this->request('up');
		
		
		if(isset($ok) && $ok=='yes')
		{
			if(empty($name)){
				throw new Lemon_ScriptException('분류명을 입력하십시오!');
	   		exit;
			}
			if(empty($en)){
				throw new Lemon_ScriptException('영문명을 입력하십시오!');
	 			exit;
			}
			$rs = $model->addBoardCategory($name,$en);
			if( $rs > 0 )
			{
				throw new Lemon_ScriptException("분류가 성공적으로 등록되었습니다.", "", "go", "?");
   		}
		}
		
		if($del == "ok")
		{
			$rs = $model->getContentByBbsNo($id);
			for($i=0; $i<count((array)$rs); ++$i)
			{
				$imgnum = $rs[$i]["imgnum"];
				$pic	= $rs[$i]["pic"];
				if($imgnum!=0 &&  $pic!="")
				{
					$arr=explode("|",$pic);
					for($j=0;$j<count($arr);$j++)
					{
						$temp= $_SERVER[ 'DOCUMENT_ROOT'].$arr[$i];
						if(file_exists($temp))
						{
							unlink($temp);
						}
					}
				}
			}
			
			$model->delContentByBbsNo($id);
			$model->delBoardCategory($id);
		  
		  throw new Lemon_ScriptException("삭제되었습니다.", "", "go", "?");		  
		  
		}
		
				
		if ($up =="ok")
		{
			$rs = $model->modifyBoardCategory($name, $en, $id);
			if( $rs > 0 )
			{
				throw new Lemon_ScriptException("수정되었습니다.", "", "go", "?");
			}
		}
		
		$where = "";
		if(!empty($id)) 
		{
			$where = " and id in (".$id.")";
			$poplist = $model->getBoardCategoryList($where);
			
			$this->view->assign('poplist', $poplist);
		}
		$list = $model->getBoardCategoryList();
		
		
		$this->view->assign('list', $list);
		$this->view->assign('id', $id);
		
		$this->display();	
	}
	
 /*
	 * write process
	 */
	 
	public function writeProcessAction()
	{
		$model = $this->getModel("BoardModel");	
		$memberModel = $this->getModel("MemberModel");	
		$commonModel = $this->getModel("CommonModel");	
		$gModel	= $this->getModel('GameModel');
		$cartModel	= $this->getModel('CartModel');
		
		
		$sn 			= $this->request('id');
		$province = $this->request('province');
		$title 		= $this->request('title');
		$author 	= $this->request('author');
		$lvl			= $this->request('lvl');
		$content 	= $this->request('content');
		$imgsrc 	= $this->request('imgsrc');
		$hit 			= $this->request('hit');
		$time 		= $this->request('time');
		$top			= $this->request('top');
		$logo 		= $this->request('logo');
		
		if($logo=='')
			$logo=$this->logo;
		
		$ip = $commonModel->getIp();
		$content = str_replace($config_upload_url,"", $content);
		$imgsrc = str_replace($config_upload_url,"",$imgsrc);
		
		if($imgsrc!="0")
		{
			$arr = explode("|",$imgsrc);
			$srcnum = count($arr);
		}
		else
		{
			$srcnum = "0";
			$imgsrc = "";
		}		
		
		if( empty($hit) )
		{
			$hit=0;
		}
		
		
		$cart = $this->request('cart');
		if( $cart == 'add' )
		{
			$admin_sn = $this->auth->getSn();
			
			$bet_date			= $this->request('bet_date');
			$bet_money			= $this->request('bet_money');
			$arr_child_sn			= $this->request('child_sn');
			
			if(is_null($arr_child_sn) || $arr_child_sn == '' )
			{
				throw new Lemon_ScriptException("경기를 선택하여 주십시오.!");			
				exit;
			}
			
			//'게임번호
			$lastIdx = $cartModel->getLastCartIndex();
		
			$nowtime = date("Y-m-d H:i:s");
			$protoId = strtotime($nowtime) - strtotime("2000-01-01")+(9*60*60);
			$protoId = $protoId + $lastIdx;
			If($protoId == "")
			{
				throw new Lemon_ScriptException("구매번호를 확인하여 주십시요.");			
				exit();
			}
			$protoId = $admin_sn.$protoId;
			$buy = 'Y';
			$betting_cnt = count($arr_child_sn);
			$dbCash = 0;
			
			$result_rate = 1;
			$recommendSn = 0;
			
			
			foreach($arr_child_sn as $key=>$value)
			{
				$child_sn = $key;
				$selected = $value;
				
				$list = $gModel->getListBychild_sn($child_sn);	
				$home_rate = $list[0]['home_rate'];
				$draw_rate = $list[0]['draw_rate'];
				$away_rate = $list[0]['away_rate'];
				$gameType = $list[0]['type'];
				
				if($selected==1) $selectedRate=$home_rate;
				else if($selected==2) $selectedRate=$away_rate;
				else if($selected==3) $selectedRate=$draw_rate; 
				
				$result_rate	 *= $selectedRate;
				
				$subChildSn = $gModel->getSubChildField($child_sn, "sn");
				$rs = $cartModel->addBet(0, $child_sn, $subChildSn, $protoId, $selected, $home_rate, $draw_rate, $away_rate, $selectedRate, $gameType, $buy, $bet_money);
			}
			
			//$result_rate = $result_rate / $betting_cnt;
			$result_rate = round($result_rate*100)/100;
			$accountEnable = 0;
			$cartModel->addCart(0, 0, $protoId, $buy, $betting_cnt, $dbCash, $bet_money, $result_rate, $recommendSn, '', $accountEnable, $bet_date);
		}
		
		if( empty($sn) )
		{
			$rs = $memberModel->getByName($author);
			if( $rs["mem_status"] == "N" ) {
				throw new Lemon_ScriptException("유저가 사용중인 닉네임 입니다.");
				exit;
			}
			$rs = $model->add($province, $title, $srcnum, $imgsrc, $author, $top, $content, $ip, $time, $hit, $protoId, $logo, $lvl);
		}
		else
		{
			$rs = $model->modify($province, $title, $srcnum, $imgsrc, $author, $top, $content, $ip, $time, $hit, $sn, $lvl);
		}
		
		if( $rs > 0 )
		{
			 throw new Lemon_ScriptException("등록 되였습니다!", "", "go", "/board/list?province=".$province);
		}
		else
		{
			throw new Lemon_ScriptException("등록에 실패 하였습니다.");			
			exit;
		}
	} 
	
	function popup_updatehitAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/board/popup.update_hit.html");
		
		$model = $this->getModel("BoardModel");	
		
		$id = $this->request("id");
		$hit = $this->request("hit");
		$mode = $this->request("mode");
		
		if($mode=="edit")
		{
			$model->modifyHit($id, $hit);
			
			throw new Lemon_ScriptException("","","script","alert('변경완료 되었습니다.');window.opener.location.reload();window.close();");			
			exit();
		}
	
		$this->view->assign('id', $id);
		$this->view->assign('hit', $hit);
		
		$this->display();	
	}
	
	function popup_bettingAction()
	{
		$this->popupDefine();

		if(!$this->auth->isLogin())
		{
			$this->redirect("/login");
			exit;
		}
		$this->view->define("content","content/board/popup.betting.html");
	
		$model 	= $this->getModel("GameModel");
		$specialType = $this->request("special_type");
		if ( !$specialType ) $specialType = 1;
		
		$act = $this->request("act");		
		if( $act == 'add')
		{
			$arr_child_sn = $this->request("child_sn");
			
			if(is_null($arr_child_sn) || $arr_child_sn == '' )
			{
				throw new Lemon_ScriptException("경기를 선택하여 주십시오.!");			
				exit;
			}

			$gameDate		= $this->request("gameDate");
			$gameHour		= $this->request("gameHour");
			$gameTime		= $this->request("gameTime");
			$gameSecond		= $this->request("gameSecond");
			$perpage		= $this->request("perpage");
		
			$money 		= $this->request("money");
			$money 	= str_replace(",","",$money);
			$date = $gameDate." ".$gameHour.":".$gameTime.":".$gameSecond;
			
			$child_sn = '';
			
			foreach($arr_child_sn as $key=>$value)
			{
				$child_sn .= $key.":".$value.",";
			}
			
			$child_sn = substr($child_sn, 0, strlen($child_sn)-1);
			
			$url = "/board/write?cart=add&child_sn=".$child_sn."&bet_date=".$date."&bet_money=".$money;
			throw new Lemon_ScriptException("","","script","alert('처리 되였습니다.');window.opener.top.location.href='".$url."'; window.close();");
		//	throw new Lemon_ScriptException("","","script","alert('처리 되였습니다.');window.opener.top.location.href='/board/write'; window.close();");
			
			echo $date."<br/>";
			echo $money."<br/>";
			echo $upload_selectteam."<br/>";
			exit;
		}
		
		$state = 1; // 종료된 게임
		
		$endDate	= date('Y-m-d');
		$beginDate	= date('Y-m-d', strtotime('-2 days'));
		
		if($perpage=='')$perpage 	= 100;

		$page_act = "perpage=".$perpage."&state=".$state."&search=".$search."&special_type=".$specialType."&categoryName=".$categoryName."&game_type=".$gameType."&begin_date=".$beginDate."&end_date=".$endDate."&filter_team_type=".$filterTeamType."&filter_betting_total=".$filterBettingTotal."&money_option=".$moneyOption;

		$total_info = $model->getListTotal($state, $categoryName, $gameType, $specialType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam);
		$total = $total_info["cnt"];

		$pageMaker 	= $this->displayPage($total, 10, $page_act);
		$list 			= $model->getList_asc($pageMaker->first, $pageMaker->listNum, $state, $categoryName, $gameType, $specialType, $beginDate, $endDate, $minBettingMoney, $leagueSn, $homeTeam, $awayTeam, '', 1);

		$gameHour = "<select name='gameHour'>";
		for($i=0;$i<24;$i++)
		{
			$j=$i;
			if($j<10)
			{
				$j="0".$j;
			}
			$gameHour=$gameHour."<option value='".$j."'>".$j."</option>";
		}
		$gameHour = $gameHour . "</select>";		
		
		$gameTime = "<select name='gameTime'>";
		for($i=0;$i<60;$i++)
		{
			$j=$i;
			if($j<10)
			{
				$j="0".$j;
			}
			$gameTime=$gameTime."<option value='".$j."'>".$j."</option>";
		}
		$gameTime = $gameTime . "</select>";
		
		$gameSecond = "<select name='gameSecond'>";
		for($i=0;$i<60;$i++)
		{
			$j=$i;
			if($j<10)
			{
				$j="0".$j;
			}
			$gameSecond=$gameSecond."<option value='".$j."'>".$j."</option>";
		}
		$gameSecond = $gameSecond . "</select>";
		
		$this->view->assign('special_type', $specialType);	
		$this->view->assign('list', $list);	
		$this->view->assign("gameHour", $gameHour);
		$this->view->assign("gameTime", $gameTime);		
		$this->view->assign("gameSecond", $gameSecond);		
		$this->view->assign("perpage", $perpage);		
		
		$this->display();	
	}
	
	function addCheckAjaxAction()
	{
		$nickname	= trim($this->req->request('author'));
		
		$model = Lemon_Instance::getObject("MemberModel",true);
		
		if($nickname)
		{
			$rs = $model->getByName($nickname);
			if(count((array)$rs)>0) 	{echo "true";}
			else 				{echo "false";}
		}
	}
	
	/*
	 * help functions
	 */
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
	
	//▶ 엑셀 업로드
	function popup_reply_exceluploadAction()
	{
		$this->popupDefine();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$this->view->define("content","content/board/popup.reply_excel_upload.html");
		
		$Membermodel = Lemon_Instance::getObject("MemberModel",true);
		$Boardmodel = Lemon_Instance::getObject("BoardModel",true);
		
		$mode = $this->request("mode");
		$id 	= $this->request("id");

		if($mode=="execl_collect")
		{
			include_once("include/excel_reader.php");
			
			$replyarray = array();
			
			$conf = Lemon_Configure::readConfig('config');
			if($conf['site']!='')
			{
				$upload_dir	 = $conf['site']['local_upload_url']."/upload/reply/";
			}
		
			$tmp_name = $_FILES["fileUpload"]["tmp_name"]; // 임시파일명
		 	$name = $_FILES["fileUpload"]["name"];  // 파일명
		 	
		 	$upload_file = $upload_dir.$name;
		 	
 			if( move_uploaded_file($tmp_name, $upload_file) )
 			{
 				echo "sucess"."<br/>";
 			}
 			else
 			{
 				throw new Lemon_ScriptException("파일업로드가 실패하였습니다.");			
 				exit;
 			}
  
			
			$handle = new Spreadsheet_Excel_Reader();		
			$handle->setOutputEncoding('utf-8');
			
			$handle->read($upload_file);
	
			echo "sheet: ".count((array)$handle->sheets)."<br/>";
			$cnt=0;
			for( $k=0; $k < count((array)$handle->sheets); ++$k )
			{ 
				for($i=1; $i <= $handle->sheets[$k]['numRows']; $i++)
				{
					$nick='';
					$comment='';
					for ($j=1; $j<=$handle->sheets[$k]['numCols']; $j++)
					{
						switch( $j )
						{
							case 1: $nick = $handle->sheets[$k]['cells'][$i][$j]; break; // 닉네임
							case 2: $comment = $handle->sheets[$k]['cells'][$i][$j]; break; // 내용
						}
					}		

					$nick 				= trim($nick);
					$comment 			= trim($comment);
					if($nick)
					{
						$replyarray[$cnt]['nick']=$nick;
						$rs = $Membermodel->getByName($nick);
						if(count((array)$rs)>0)
						{
							$replyarray[$cnt]['comment']="<font color='red'>회원닉네임과 중복</font>";
						}
						else
						{
							$replyarray[$cnt]['comment']=$comment;
							$Boardmodel->adminReply($id, $nick, $comment);
						}
					}
					$cnt++;
				}
			}
		}
		$this->view->assign("replyarray", $replyarray);
		$this->view->assign("id", $id);
		$this->display();
	}
}

?>