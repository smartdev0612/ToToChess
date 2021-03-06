<?php
class BoardModel extends Lemon_Model
{
	//▶ 파트너 보드 by hiro
	function getPartnerBoardbyRegdate()
	{
		$sql = "select * from ".$this->db_qz."board 
							where logo='".$this->logo."' and  lev=130 order by regdate desc";
							
		$rs = $this->db->exeSql($sql);
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$rs[$i]['num'] = $i;
		}		
		return $rs;	
	}
	
	//잭팟 게시글 자동추가
	function addJackpotContent($author, $title, $content, $bettings, $ip)
	{
		$sql = "insert into ".$this->db_qz."content(province,title,imgnum,pic,author,top,content,ip,time,hit,betting_no,logo) 
						values ('9','".$title."','0','','".$author."','1','".$content."','".$ip."',now(),'0','".$bettings."','".$this->logo."')";
		return $this->db->exeSql($sql);	
	}
	//잭팟 게시글 취소
	function cancelJackpotContent($bettings)
	{
		$sql = "delete from ".$this->db_qz."content where province='9' and betting_no='".$bettings."'";
		return $this->db->exeSql($sql);	
	}
	
	//▶ 고객센터 총합
	function getCsTotal($where)
	{
		$sql = "select count(*) as cnt from ".$this->db_qz."question a, ".$this->db_qz."people b 
						where a.mem_id=b.uid and 1=1 ".$where." order by a.regdate desc";
					
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 고객센터 목록
	function getCsList($where, $page, $page_size)
	{
		$sql = "select a.*, b.nick, b.uid, b.bank_member, b.bank_name, b.mem_lev, b.regdate as joindate, (select lev_name from ".$this->db_qz."level_config where id=b.mem_lev) as lev_name,
						(select rec_id from ".$this->db_qz."partner where idx=b.recommend_sn) as rec_id from ".$this->db_qz."question a, ".$this->db_qz."people b 
						where a.mem_id=b.uid ".$where." 
						order by a.regdate desc limit ".$page.",".$page_size."";

		$rs = $this->db->exeSql($sql);

		for($i=0; $i<count((array)$rs); ++$i)
		{
			$sql = "update ".$this->db_qz."question set is_read=1 where idx=".$rs[$i]['idx'];
			$this->db->exeSql($sql);
			
			$memberModel = Lemon_Instance::getObject("MemberModel",true);
			$memId = $rs[$i]["mem_id"];
			$rs[$i]['mem_idx'] = $memberModel->getMemberRowById($memId, "sn");
		}
				
		return $rs;
	}
	
	//▶ 보드 총합
	function getTotal($bbsNo, $where='')
	{
		$sql = "select count(*) as cnt 
						from ".$this->db_qz."content
						where logo='".$this->logo."' and province='".$bbsNo."' ".$where;
					
		$rs = $this->db->exeSql($sql);
		
		return $rs[0]['cnt'];
	}
	
	//▶ 보드 목록
	function getList($bbsNo, $page, $page_size, $where="")
	{
		$sql = "select *
						from ".$this->db_qz."content
						where logo='".$this->logo."' and province='".$bbsNo."' ".$where.
						" order by top desc, time desc limit ".$page.",".$page_size ;

		$rs = $this->db->exeSql($sql);
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$sql = "select count(*) as cnt from ".$this->db_qz."content_reply where num='".$rs[$i]['id']."'";
			$rsi = $this->db->exeSql($sql);
			$rs[$i]['reply'] = $rsi[0]['cnt'];
			$sql = "select mem_lev from ".$this->db_qz."people where nick='".$rs[$i]['author']."'";
			$rsi = $this->db->exeSql($sql);
			if($rsi == null || count((array)$rsi)<=0) {
				if ( $rs[$i]['lvl'] > 0 ) $level = $rs[$i]['lvl'];
				else $level = 2;
			} else {
				$level = $rsi[0]['mem_lev'];
			}
			$rs[$i]['mem_lev']=$level;
			
			//게시물에 배팅내역이 있는지 유무 확인
			$isBetlist="Y";
			$betting_no=explode(';', $rs[$i]['betting_no']);

			foreach($betting_no as $value){
				$Betrow=$this->getRow("user_del", $this->db_qz."game_cart", "betting_no='".$value."'");
				
				$isBetlist=$Betrow['user_del'];
				
				if($isBetlist=='N'){
					break;
				}
			}

			if($isBetlist == null || $isBetlist == 'N')
            {
                if($rs[$i]['betting_temp'] != null && $rs[$i]['betting_temp'] != '')
                    $isBetlist = 'Y';
            }
			$rs[$i]['isBet_list']=$isBetlist;
		}
		
		return $rs;
	}
	
	//▶ 추천 보드 목록
	function getTopList()
	{
		$sql = "select * 
				from ".$this->db_qz."content 
					where logo='".$this->logo."' and province=2 and top=2
						order by top desc, time desc";
						
		$rs = $this->db->exeSql($sql);
		
		if(is_array($rs) && count($rs) > 0) {
			for($i=0; $i<count($rs); ++$i)
			{
				$sql = "select count(*) as cnt
						from ".$this->db_qz."content_reply 
							where num='".$rs[$i]['id']."'";
							
				$rsi = $this->db->exeSql($sql);
				$rs[$i]['reply'] = $rsi[0]['cnt'];
			}
		}
		return $rs;
	}
	
	//▶ 공지 목록
	function getNoticeList()
	{
		$sql = "select * 
				from ".$this->db_qz."content 
					where logo='".$this->logo."' and province=2 
						order by top desc,time desc limit 0, 20";
						
		return $this->db->exeSql($sql);
	}
	
	//▶ 자유게시판 목록
	function getFreeBoardList()
	{
		$sql = "select * 
				from ".$this->db_qz."content 
					where logo='".$this->logo."' and province=5 
						order by top desc,time desc limit 0, 10";
						
		return $this->db->exeSql($sql);
	}
	
	//▶ 보드 카테고리 수정
	function modifyBoardCategory($name, $en, $sn)
	{
		$sql = "update ".$this->db_qz."board_category 
				set name='".$name."',en='".$en."' 
					where logo='".$this->logo."' and  sn in (".$sn.")";
								
		return $this->db->exeSql($sql);																
	}
	
	//▶ 보드 카테고리 삭제
	function delBoardCategory($sn)
	{
		$sql = "delete from ".$this->db_qz."board_category 
				where logo='".$this->logo."' and sn in (".$sn.")";
							
		return $this->db->exeSql($sql);										
	} 
	
	//▶ 보드 카테고리 추가
	function addBoardCategory($name, $en)
	{
		$sql = "insert into ".$this->db_qz."board_category(name,en,logo) 
				values('".$name."','".$en."','".$this->logo."')";
							
		return $this->db->exeSql($sql);					
	}
	
	//▶ 보드 카테고리 목록
	function getBoardCategoryList($where="")
	{
		$sql = "select * 
						from ".$this->db_qz."board_category 
						where logo='".$this->logo."'".$where;
					
		return $this->db->exeSql($sql);
	}
	
	//▶ 게시글 추가
	function add($province, $title, $srcnum, $imgsrc, $author, $top, $content, $ip, $time, $hit,$betting_no='', $logo='', $lvl = 0)
	{
		if( $logo=='')
			$logo = $this->logo;
			
		$sql = "insert into ".$this->db_qz."content(province,title,imgnum,pic,author,top,content,ip,time,hit,betting_no,logo,lvl) 
				values ('".$province."','".$title."','".$srcnum."','".$imgsrc."','".$author."','".$top."','".$content."','".$ip."','".$time."','".$hit."','".$betting_no."','".$logo."','".$lvl."')";
							
		return $this->db->exeSql($sql);					
	}
	
	//▶ 게시글 수정
	function modify($province, $title, $srcnum, $imgsrc, $author, $top, $content, $ip, $time, $hit, $sn, $lvl = 0)
	{
		$sql = "update ".$this->db_qz."content 
				set province='".$province."',title='".$title."',imgnum='".$srcnum."',pic='".$imgsrc."',author='".$author."',top='".$top."',content='".$content."',ip='".$ip."',time='".$time."',hit='".$hit."',lvl='".$lvl."' 
					where id in (".$sn.")";
								
		return $this->db->exeSql($sql);								
	}
	
	//▶ 게시글 아이디 검색
	function getContentById($id)
	{
		$sql = "select imgnum,pic from ".$this->db_qz."content where id in (".$id.")";
		return $this->db->exeSql($sql);
	}
	
	//▶ 게시글
	function getContent($sn)
	{
		$sql = "select a.*, ifnull(b.mem_lev,2) as mem_lev from ".$this->db_qz."content a left outer join ".$this->db_qz."people b on a.author=b.nick
						where a.logo='".$this->logo."' and a.id=".$sn."";
					
		$rs = $this->db->exeSql($sql);
					
		return $rs[0];
	}

	//▶ 게시글 bbs 검색
	function getContentByBbsNo($id)
	{
		$sql = "select imgnum,pic 
				from ".$this->db_qz."content 
					where logo='".$this->logo."' and  province in (".$id.")";

		return $this->db->exeSql($sql);
	}

	//▶ 게시글 총합
	function getContentTotal($where, $province="")
	{
/*
		if($province!=2 && $province!=7 && $province!=9)
		{
			$sql = "select count(*) as cnt
							from ".$this->db_qz."content a,".$this->db_qz."board_category b,".$this->db_qz."people c
							where a.province=b.sn and a.author=c.nick ".$where;
		}
		//유저가 쓴 글이 아닐경우
		else
		{
			$sql = "select count(*) as cnt
							from ".$this->db_qz."content a,".$this->db_qz."board_category b
							where a.province=b.sn ".$where;
		}
*/
		if($province!=2 && $province!=7 && $province!=9) {
			$sql = "select count(*) as cnt from ".$this->db_qz."content a,".$this->db_qz."board_category b where a.province=b.sn ".$where;
		} else {
			$sql = "select count(*) as cnt from ".$this->db_qz."content a,".$this->db_qz."board_category b where a.province=b.sn and a.province = '".$province."' ".$where;
		}
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
		
	//▶ 게시글 목록
	function getContentList($arrId)
	{
		$sql = "select * from ".$this->db_qz."content
						where id in (".$arrId.")";
								
		return $this->db->exeSql($sql);
	}
	
	//▶ 게시글 목록
	function getContentListPage($where, $page, $page_size, $province='')
	{
/*
		if($province!=2 && $province!=7)
		{
			$sql = "select a.*, b.name as typename,
							c.uid, c.bank_member
							from ".$this->db_qz."content a,".$this->db_qz."board_category b,".$this->db_qz."people c
							where a.logo='".$this->logo."' and a.province=b.sn and a.author=c.nick ".$where."
							order by time desc limit ".$page.",".$page_size."";
		}
		//유저가 쓴 글이 아닐경우
		else
		{
			$sql = "select a.*, b.name as typename
							from ".$this->db_qz."content a,".$this->db_qz."board_category b
							where a.logo='".$this->logo."' and a.province=b.sn ".$where."
							order by time desc limit ".$page.",".$page_size."";
		}
*/
		if($province!=2 && $province!=7 && $province!=9) {
			$sql = "select a.*, b.name as typename, c.mem_status from tb_board_category b, tb_content a LEFT JOIN tb_people AS c ON c.nick = a.author
							where a.logo='".$this->logo."' and a.province=b.sn ".$where."
							order by time desc limit ".$page.",".$page_size."";
		} else {
			$sql = "select a.*, b.name as typename, c.mem_status from tb_board_category b, tb_content a LEFT JOIN tb_people AS c ON c.nick = a.author
							where a.province=b.sn and a.province = '".$province."' ".$where."
							order by time desc limit ".$page.",".$page_size."";
		}
		$rs = $this->db->exeSql($sql);
		//댓글
		if(is_array($rs) && count((array)$rs) > 0) {
			for($i=0; $i<count((array)$rs); ++$i)
			{
				$id  = $rs[$i]['id'];
				$sql = "select count(*) as cnt from ".$this->db_qz."content_reply where num='".$id."'";
						
				$rsi = $this->db->exeSql($sql);
				$rs[$i]['reply'] = $rsi[0]['cnt'];
				
				$author = $rs[$i]["author"];
			}
		}

		return $rs;
	}
	
	//▶ 게시글 삭제 아이디
	function delContentById($sn)
	{
		$sql = "delete from ".$this->db_qz."content where id in (".$sn.")";
		return $this->db->exeSql($sql);
	}
	
	//▶ 게시글 삭제 bbs no
	function delContentByBbsNo($bbs)
	{
		$sql = "delete from ".$this->db_qz."content 
						where province in (".$bbs.")";
					
		return $this->db->exeSql($sql);
	}
	
	//▶ 게시글 추가
	function addContent($author, $title, $content, $bettingNo, $ip)
	{
		//유저 검색(포인트 추가를 위함)
		$sql = "select sn from ".$this->db_qz."people
						where nick='".$author."' and logo='".$this->logo."'";
		$rs = $this->db->exeSql($sql);
		$memberSn = $rs[0]['sn'];
		
		if(count((array)$rs)<=0)
			return array();
			
		if($this->enableBoardWrite($memberSn, 1)==0)
				return "auth_failed";
						
		$memberLvl = $this->auth->getLevel();
		$sql = "insert into ".$this->db_qz."content(province,title,imgnum,pic,author,lvl,top,content,ip,time,hit,betting_no,logo) 
						values ('5','".$title."','0','','".$author."','".$memberLvl."','1','".$content."','".$ip."',now(),'0','".$bettingNo."','".$this->logo."')";
		$boardSn = $this->db->exeSql($sql);
		
		if($bettingNo=="" || $bettingNo==0)	{$message="게시물 작성"; $type=2;}
		else																{$message="배팅게시물 작성"; $type=3;}
		$point = $this->getBoardPoint($memberSn, $type, $boardSn);
		if($point > 0)
		{
			$processModel = Lemon_Instance::getObject("ProcessModel",true);
			//$sn, $amount, $status, $statusMessage, $rate=0, $winCount=''
			$processModel->modifyMileageProcess($memberSn, $point, 10, $message, 100);
		}
		
		return $boardSn;
		
	}
	
	//▶ 게시글 수정
	function modifyContent($sn, $title, $content )
	{
		$sql = "update ".$this->db_qz."content 
							set title='".$title."', content='".$content."' where logo='".$this->logo."' and id = ".$sn;
				
		return $this->db->exeSql($sql);
	}
	
	//▶ 게시글 수정
	function modifyRandomHit($sn)
	{
		$sql = "update ".$this->db_qz."content 
				set hit=hit+'".rand(0,5)."' where id=".$sn."";
				
		return $this->db->exeSql($sql);
	}
	
	function modifyTop($id, $top)
	{
		$sql = "update ".$this->db_qz."content 
				set top='".$top."' where id=".$id."";
				
		return $this->db->exeSql($sql);
	}
	
	//▶ 공지 총합
	function getBoardTotal($where='',$level=110)
	{
		$addwhere = " and lev = ".$level;
		$sql = "select count(*) as cnt
				from ".$this->db_qz."board 
					where logo='".$this->logo."'".$addwhere.$where;
					
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 공지 리스트
	function getBoardList($where='', $page, $page_size, $level=110)
	{
		$addwhere = " and lev = ".$level;
		
		$sql = "select * 
				from ".$this->db_qz."board 
					where logo='".$this->logo."'".$addwhere.$where." 
						order by regdate desc limit ".$page.",".$page_size."";
					
		$rs = $this->db->exeSql($sql);
		
		return $rs;
	}
	
	//▶ 공지 추가
	function addBoard($writer, $subject, $content, $write_datetime, $view_code )
	{
		$sql = "insert into ".$this->db_qz."board (name,nick,title,content,regdate,lev,step,owner,logo) values (";
		$sql = $sql."'".$writer."','".$writer."','".$subject."','".$content."','".$write_datetime. "','".$view_code."',";
		$sql = $sql." '0','2','".$this->logo."')";
			
		return $this->db->exeSql($sql);											
	}
	
	//▶ 파트너 공지 총합
	function getPartnerBoardTotal($where)
	{
		$sql = "select count(*) as cnt
				from ".$this->db_qz."board 
					where logo='".$this->logo."' and lev = 130 ".$where;
					
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 파트너 공지 리스트
	function getPartnerBoardList($where, $page, $page_size)
	{
		$sql = "select num,title,regdate from ".$this->db_qz."board 
							where logo='".$this->logo."' and lev=130 order by regdate desc limit ".$page.",".$page_size;
		$rs = $this->db->exeSql($sql);					
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$beginIndex = 0;
			$length = 30;
			$string = $rs[$i]['title'];
			
			$substr = substr( $string, $beginIndex, $length * 2 );
      		$multi_size = preg_match_all( '/[\\x80-\\xff]/', $substr, $multi_chars);

      	if($multi_size > 0)
        	$length = $length + intval( $multi_size / 3 ) - 1;

      	if(strlen( $string ) > $length)
      	{
        	$string = substr( $string, $beginIndex, $length );
        	$string = preg_replace( '/(([\\x80-\\xff]{3})*?)([\\x80-\\xff]{0,2})$/', '$1', $string );
        	$string .= '...';
      	}
      
		$rs[$i]['title'] = $string;  
			
		}					
		return $rs;
	}
	
	//▶ 파트너 공지
	function getPartnerBoard($sn)
	{
		$sql = "select  * from ".$this->db_qz."board 
							where logo='".$this->logo."' and num = '".$sn."' limit 0,1";
							
		$rs = $this->db->exeSql($sql);
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$nick = $rs[$i]['nick'];
			$content = $rs[$i]['content'];
			$content = str_replace("cafe","<font color=red>낚시글조심</font>",$content);
			$rs[$i]['content'] = $content;
			
			$sql = "select uid from ".$this->db_qz."people 
								where logo='".$this->logo."' and nick = '".$nick."'";
			$rsi = $this->db->exeSql($sql);					
			$mem_id = $rsi[0]['mem_id'];
			$rs[$i]['mem_id'] = $mem_id;
			
		}		
		return $rs;	
	}
	
	//▶ 공지 삭제
	function delBoard($idx)
	{
		$sql = "delete from ".$this->db_qz."board 
						where logo='".$this->logo."' and num in(".$idx.")";
		
		return $this->db->exeSql($sql);
	}
	
	//▶ 댓글 삭제
	function delReply($sn)
	{
		$sql = "delete  from ".$this->db_qz."content_reply where idx=".$sn."";
				
		return $this->db->exeSql($sql);
	}
	
	//▶ 관리자 댓글 수정
	function AdminmodifyReply($sn, $content)
	{
		$sql = "update ".$this->db_qz."content_reply set content='".$content."' where idx=".$sn;
					
		return $this->db->exeSql($sql);
	}
	
	//▶ 댓글 삭제
	function delReplyById($replySn, $uid)
	{
		//댓글 포인트 확인
		$sql = "select sn, member_sn, point from ".$this->db_qz."people_board_point
						where board_sn=".$replySn;
		$rs = $this->db->exeSql($sql);
		
		if(count((array)$rs)>0)
		{
			$sn 			= $rs[0]['sn'];
			$amount 	= $rs[0]['point'];
			$memberSn = $rs[0]['member_sn'];
			
			$processModel = Lemon_Instance::getObject("ProcessModel",true);
			$processModel->modifyMileageProcess($memberSn, -$amount, 11, "댓글 취소", 100);
			
			$sql = "delete from ".$this->db_qz."people_board_point
							where sn=".$sn;
			$this->db->exeSql($sql);
		}
		
		$sql = "delete from ".$this->db_qz."content_reply
						where idx=".$replySn." and mem_id='".$uid."'";
			
		return $this->db->exeSql($sql);
	}
	
	//▶ 댓글 목록
	function getReplyList($id)
	{
		$sql = "select * from tb_content_reply a left join tb_people b on a.mem_id = b.uid where a.num ='".$id."' order by a.idx";				
		return $this->db->exeSql($sql);
	}
	
	//▶ 회원 댓글 입력확인
	function eventReplyEnable($sn, $author)
	{
		$sql = "select count(*) as cnt from ".$this->db_qz."content_reply 
						where num ='".$sn."' and mem_nick='".$author."'";
						
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 댓글 입력
	function addReply($article, $content, $memberSn="")
	{
		$uid  = $this->req->request('mid');
		$nick = $this->req->request('mnk');
		
		if($memberSn!="")
		{
			if($this->enableBoardWrite($memberSn, 2)==0)
				return "auth_failed";
		}
		
		$sql = "insert into ".$this->db_qz."content_reply(num,mem_id,mem_nick,content,regdate)
						values ('".$article."','".$uid."','".$nick."','".$content."',now())";
		$replySn = $this->db->exeSql($sql);
		
		//유저 검색(활동포인트 추가를 위함)
		if($memberSn!="")
		{
			$sql = "select sn from ".$this->db_qz."people
							where sn='".$memberSn."' and logo='".$this->logo."'";
			$rs = $this->db->exeSql($sql);
			if(count((array)$rs)>0)
			{
				$sn = $rs[0]['sn'];
				$type = 1;
				$point = $this->getBoardPoint($sn, $type, $replySn);
				if($point > 0)
				{
					$processModel = Lemon_Instance::getObject("ProcessModel",true);
					$processModel->modifyMileageProcess($sn, $point, 10, "댓글작성", 100);
				}
			}
		}
		return $replySn;
	}
	
	//▶ 댓글 입력
	function adminReply($article, $author, $content)
	{
		$sql = "insert into ".$this->db_qz."content_reply(num,mem_id,mem_nick,content,regdate)
						values ('".$article."','관리자 리플','".$author."','".$content."',now())";
		$replySn = $this->db->exeSql($sql);
		
		//유저 검색(활동포인트 추가를 위함)
		if($memberSn!="")
		{
			$sql = "select sn from ".$this->db_qz."people
							where sn='".$memberSn."' and logo='".$this->logo."'";
			$rs = $this->db->exeSql($sql);
			if(count((array)$rs)>0)
			{
				$sn = $rs[0]['sn'];
				$type = 1;
				$point = $this->getBoardPoint($sn, $type, $replySn);
				if($point > 0)
				{
					$processModel = Lemon_Instance::getObject("ProcessModel",true);
					$processModel->modifyMileageProcess($sn, $point, 10, "댓글작성", 100);
				}
			}
		}
		return $replySn;
	}
	
	//▶ 글을 쓸수 있는지 권한을 검사
	function enableBoardWrite($memberSn, $type/*1=게시글, 2=댓글, 3=고객센터*/)
	{
		$sql = "select memo from ".$this->db_qz."people where sn='".$memberSn."' and logo='".$this->logo."'";
		$rs = $this->db->exeSql($sql);
		
		$enable = 1;
		if(count((array)$rs)>0)
		{
			$auth = $rs[0]['memo'];
			//게시글
			if($type==1) 			{$enable = $auth[0];}
			else if($type==2) {$enable = $auth[1];}
			else if($type==3) {$enable = $auth[2];}
		}
		else
			$enable = 0;
		return $enable;
	}
	
	function modifyHit($sn,$hit=1)
	{
		if($hit==0)	{$sql = "update ".$this->db_qz."content set hit=hit+1 where logo='".$this->logo."' and id=".$sn."";}
		else				{$sql = "update ".$this->db_qz."content set hit = ".$hit." where logo='".$this->logo."' and id=".$sn."";}
		
		return $this->db->exeSql($sql);
	}
	
	function hDel($author)
	{
		$boardSn = $this->req->request('hid');

		//게시글 포인트 확인
		$sql = "select sn, member_sn, point, type from ".$this->db_qz."people_board_point
						where board_sn=".$boardSn;
		$rs = $this->db->exeSql($sql);
		
		if(count((array)$rs)>0)
		{
			$sn 			= $rs[0]['sn'];
			$amount 	= $rs[0]['point'];
			$memberSn = $rs[0]['member_sn'];
			$type			= $rs[0]['type'];
			
			if($type==2)	{$message = "게시글 작성 취소";}
			else if($type==3)	{$message = "배팅게시글 작성 취소";}
			$processModel = Lemon_Instance::getObject("ProcessModel",true);
			$processModel->modifyMileageProcess($memberSn, -$amount, 11, $message, 100);
			
			$sql = "delete from ".$this->db_qz."people_board_point
							where sn=".$sn;
			$this->db->exeSql($sql);
		}
		
		$sql = "delete from ".$this->db_qz."content 
						where id=".$boardSn." and author='".$author."' and logo='".$this->logo."'";
		
		return $this->db->exeSql($sql);
	}
	
	function modifyReply($comment, $reid, $id)
	{
		$sql = "update ".$this->db_qz."content_reply 
				set content='".$comment."',regdate=now() 
					where idx=".$reid." and mem_id='".$id."'";
					
		return $this->db->exeSql($sql);
	}
	
	function getReplyLastTime($article, $id)
	{
		$mid = $this->req->request('mid');
		
		$sql = "select regdate 
				from ".$this->db_qz."content_reply 
					where num=".$article." and mem_id='".$id."' order by regdate desc limit 0,1";
		$rs = $this->db->exeSql($sql);
		return $rs[0]['regdate'];
	}
	
	function getQuestion($sn)
	{
	    $logo = $this->logo;
		$sql = "select a.regdate as question_regdate, a.*, b.*, (select lev_name from ".$this->db_qz."level_config where lev=b.mem_lev) as lev_name from ".$this->db_qz."question a, ".$this->db_qz."people b
							where a.mem_id=b.uid and idx = '".$sn."' and a.logo='{$logo}'";
		$rs = $this->db->exeSql($sql);

		for($i = 0; $i< count((array)$rs); ++$i )
		{
			$content = $rs[$i]['content'];
			$content = str_replace("cafe","<font color=red>낚시글조심</font>",$content);
			$rs[$i]['content']	= $content;
			
			$sql = "update ".$this->db_qz."question set is_read=1 where idx=".$rs[$i]['idx'];
			$this->db->exeSql($sql);
		}
		
		return $rs;
	}
	
	function getCsReply($sn)
	{
		$sql = "select * from ".$this->db_qz."question 
						where reply = '".$sn."'";
						
		$rs = $this->db->exeSql($sql);					
		for($i = 0; $i< count((array)$rs); ++$i )
		{
			$content = $rs[$i]['content'];
			$content = str_replace("cafe","<font color=red>낚시글조심</font>",$content);
			$rs[$i]['content']	= $content;
		}
		
		return $rs;
	}
	
	//▶ 고객센터 추가
	function addCs($sn, $comment)
	{
		$sql = "insert into  ".$this->db_qz."question (subject,content,mem_id,kubun,regdate,result,reply,chk,logo) 
							values ('','".$comment."','','',now(),0,'".$sn."',0,'".$this->logo."')";
		return $this->db->exeSql($sql);					
	}
	
	//▶ 댓글 고객센터 검색
	function getCsByReplySn($sn)
	{
		$sql = "select idx from ".$this->db_qz."question 
				where reply='".$sn."'";

		return $this->db->exeSql($sql);		
	}

	//▶ 고객센터 수정 (문의내용)
	function modifyCs($sn, $comment)
	{
		$sql = "update ".$this->db_qz."question 
				set content='".$comment."' where idx=".$sn;
		
		return $this->db->exeSql($sql);
	}

	//▶ 고객센터 수정 (답변내용)
	function modifyCsAnswer($sn, $comment)
	{
		$sql = "update ".$this->db_qz."question 
				set content='".$comment."' where reply=".$sn;
		
		return $this->db->exeSql($sql);
	}
	
	//▶ 고객센터 수정
	function modifyCsReply($sn,$status)	
	{
		
		$sql = "update ".$this->db_qz."question 
							set result = ".$status." 
								where idx ='".$sn."'";
		
		return $this->db->exeSql($sql);
	}
	
	//▶ 고객센터 삭제 (영구삭제로 변경)
	function deleteMemberCsAll($uid, $logo='')
	{
		if($logo!='') $logo = " and logo='".$logo."'";
		//$sql = "update ".$this->db_qz."question set state='D'	where mem_id='".$uid."' ".$logo;
		$sql = "delete from ".$this->db_qz."question where idx IN (".$uid.")";
		$rs = $this->db->exeSql($sql);
		return $rs;
	}

	function deleteMemberCs($id, $uid)
	{
		$sql = "update ".$this->db_qz."question set state='D'	where idx='".$id."' and mem_id='".$uid."' ";
		$rs = $this->db->exeSql($sql);
		return $rs;
	}
	
	function addMemberCs($uid, $subject, $content, $kubun, $memberSn="")
	{
		//유저 검색(포인트 추가를 위함)
		if($memberSn!="")
		{
			if($this->enableBoardWrite($memberSn, 3)==0)
					return "auth_failed";
		}
				
		$sql = "insert into ".$this->db_qz."question(subject,content,mem_id,kubun,regdate,result,reply, is_read, logo)						
						values('".$subject."','".$content."','".$uid."','".$kubun."',now(),'0','0',0, '".$this->logo."')";
					
		return $this->db->exeSql($sql);
	}
	
	function getMemberCsTotal($uid)
	{
		$sql = "select count(*) as cnt
				from ".$this->db_qz."question 
					where logo='".$this->logo."' and mem_id = '".$uid."' and reply = 0";
				
		$rs = $this->db->exeSql($sql);
		
		return $rs[0]['cnt'];
	}

	//-> 아직 처리되지 않은 문의 갯수.
	function getMemberNotCsTotal($uid) {
		$sql = "select count(*) as cnt from ".$this->db_qz."question where logo='".$this->logo."' and mem_id = '".$uid."' and result = 0 and state != 'D'";
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}

	function getMemberCsList($uid, $page, $page_size, $where="")
	{
		$sql = "select * 
				from ".$this->db_qz."question 
				where logo='".$this->logo."' and  mem_id = '".$uid."' and reply = 0".$where." order by result asc,regdate desc  limit ".$page.",".$page_size;
				
		$rs = $this->db->exeSql($sql);
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$idx = $rs[$i]['idx'];
			$sql = "select * from ".$this->db_qz."question where reply = '".$idx."'";
			$rsi = $this->db->exeSql($sql);
			$rs[$i]['reply'] = $rsi[0];
		}
		
		return $rs;
	}
	
	//▶ 게시판 메모 추가
	function addBoard_Memo($id, $name, $comment)
	{
		$sql = "insert into ".$this->db_qz."board_memo (num,mem_id,mem_nick,content,regdate,imo) VALUES (";
		$sql.= "'".$id."','".$name."','".$name."','".$comment."',now(),'4')";
		
		return $this->db->exeSql($sql);
	}
	
	//▶ 게시판 메모 삭제
	function delBoard_Memo($sn)
	{
		$sql = "delete from ".$this->db_qz."board_memo 
							where idx = '".$sn."'";
							
		return $this->db->exeSql($sql);
	}
	//▶ 게시판 메모 리스트
	function getBoard_Memo($num)	 
	{
		$sql = "select * from ".$this->db_qz."board_memo 
							where num ='".$num."' order by idx desc";
							
		return $this->db->exeSql($sql);
	}
	
	//▶ 게시판 내용수정
	function modifyBoard($id, $title, $content, $time, $hit)
	{
		$sql = "update ".$this->db_qz."board 
							set title='".$title."',content='".$content."',regdate='".$time."',hit='".$hit."' where num=".$id."";
							
		return $this->db->exeSql($sql);						
	}
	
	//▶ 게시판 내용목록 한개의 데이터
	function getBoardOne($sn)
	{
		$sql = "select  * from ".$this->db_qz."board 
							where num = '".$sn."' limit 0,1";
							
		$rs = $this->db->exeSql($sql);					
		for( $i = 0; $i < count((array)$rs); ++$i )
		{
			$content = str_replace("cafe","<font color=red>낚시글조심</font>",$rs[$i]['content']);
			$rs[$i]['content'] = $content;
		}		
		return $rs[0];
	}
	
	///////////////////////////////////////////////////////////////////////////
	//
	//▶ process functions 
	//
	///////////////////////////////////////////////////////////////////////////
	
	//▶ 메인화면에 노출되는 게시판 목록
	function getIndexBoardProcess($bbsNo)
	{
		$sql = "select id, title 
				from ".$this->db_qz."content 
					where logo='".$this->logo."' and province=".$bbsNo."
						order by top desc,time desc limit 0, 6";
		$rs = $this->db->exeSql($sql);

		$rows = array();
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$rows[] = array('board' => $rs[$i]);
			$loop = &$rows[$i]['item'];
			
			$sql = "select count(*) as cnt 
					from ".$this->db_qz."content_reply 
						where num='".$rs[$i]['id']."'";
			$rs_reply = $this->db->exeSql($sql);
						
			$loop[] = $rs_reply[0]['cnt'];
		}					
		return $rows;
	}
	
	function getFaqList()
	{
		$sql = "select * 
						from ".$this->db_qz."content where logo='".$this->logo."' and  province=4 order by time desc";
				
		return $this->db->exeSql($sql);
	}
	
	function getCsId($id)
	{
		$sql = "select idx 
						from ".$this->db_qz."question where logo='".$this->logo."' and reply='".$id."' ";
				
		$rs = $this->db->exeSql($sql);
		
		return $rs[0]['idx'];
	}
	
	function getBoardPoint($memberSn, $type, $boardSn)
	{
		$point_field = "";
		$point_limit = "";
		
		if($type==1)			
		{
			$point_field = "reply_point";
			$point_limit = "reply_limit";
		}
		elseif($type==2)	
		{
			$point_field="board_write_point";
			$point_limit="board_write_limit";
		}
		elseif($type==3)	
		{
			$point_field="betting_board_write_point";
			$point_limit="betting_board_write_limit";
		}
	
		$sql = "select ".$point_field." as point, ".$point_limit." as point_limit
						from ".$this->db_qz."point_config 
						where logo='".$this->logo."'";
		$rs = $this->db->exeSql($sql);
		
		$point = $rs[0]['point']; 
		$pointLimit = $rs[0]['point_limit']; 
		
		$today = date("Y-m-d");
		$sql = "select count(*) as cnt
						from ".$this->db_qz."people_board_point
						where member_sn=".$memberSn." and type=".$type."
						and regdate between '".$today." 00:00:00' and '".$today." 23:59:59'";
		$rs = $this->db->exeSql($sql);
		
		if($rs[0]['cnt'] >= $pointLimit)
		{
			return 0;
		}
		else
		{
			$sql = "insert into ".$this->db_qz."people_board_point(member_sn, regdate, type, point, board_sn, logo)
							values(".$memberSn.", now(), ".$type.",".$point.",".$boardSn.", '".$this->logo."')";
			$rs = $this->db->exeSql($sql);
		}
		return $point;
	}
	//▶ 사이트 규정 필드
	function getSiteRuleRow($type/*1=회원약관,2=배팅룰*/, $field="*")
	{
		$sql = "select ".$field." from ".$this->db_qz."site_rule where type=".$type." and logo='".$this->logo."'";
		$rs = $this->db->exeSql($sql);
		
		if($field!="*")
			return $rs[0][$field];
		return $rs[0];
	}
	
	//▶ 사이트 규정 수정
	function modifySiteRule($type, $ruleSn, $content)
	{
		if ($ruleSn == "") {
			$sql = "INSERT INTO ".$this->db_qz."site_rule (type, content, logo) VALUES ( ".$type.", '".$content."', '".$this->logo."' )";
		} else {
			$sql = "update ".$this->db_qz."site_rule set content='".$content."'
					where sn=".$ruleSn;
		}
						
		return $this->db->exeSql($sql);
	}

	//▶ 이용 규정
	function getGuide()
	{
		$sql = "select * from ".$this->db_qz."site_rule where type=2 and logo='".$this->logo."'";
		$rs = $this->db->exeSql($sql);
		if(count((array)$rs) > 0)
			return $rs[0];
		return [];
	}

	function getMemberIdByIdx($idx = 0) {
		$sql = "select mem_id from ".$this->db_qz."question where idx=".$idx;
		$mem_id = 0;
		$rs = $this->db->exeSql($sql);
		if(count((array)$rs) > 0) 
			$mem_id = $rs[0]["mem_id"];
			
		return $mem_id;
	}

	function modifyAnswerAlarmFlag($idx = 0) {
		$member_id = $this->getMemberIdByIdx($idx);
		$sql = "update ".$this->db_qz."people set customer_answer_flag= customer_answer_flag + 1 where uid = '" . $member_id . "'";
		$this->db->exeSql($sql);	
	}
}
?>