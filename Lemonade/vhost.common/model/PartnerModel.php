<?php
// 용어구분
// recommend 	= 추천인
// partner		= 총판

class PartnerModel extends Lemon_Model
{
	//▶ 파트너의 정산비율 수정    
	function modifyRate($id,$rate)
	{
		$sql = "update ".$this->db_qz."recommend 
							set rec_rate='".$rate."' 
								where logo='".$this->logo."' and rec_id='".$id."'";
		return $this->db->exeSql($sql);																		
	}
	
	//▶ 파트너멤버  추가    
	function addPartnerJoin($id, $name, $level, $password, $phone, $e_mail, $bank_name, $bank_num, $bank_username, $parentSn="", $tex_type, $tex_rate_sport=0, $tex_rate_minigame=0, $rec_one_folder_flag, $topRecId, $logo="")
	{
		if ( !$logo ) $logo = $this->logo;
		if($parentSn=="") $parentSn = "0";
		$sql = "insert into ".$this->db_qz."recommend 
						(rec_id, rec_name, rec_lev, rec_psw, rec_phone, rec_email, rec_tex_type, rec_rate_sport, rec_rate_minigame, rec_one_folder_flag, rec_parent_id, reg_date, rec_bankname, rec_banknum, rec_bankusername, status, parent_sn, logo) 
						values ('".$id."','".$name."',".$level.",'".md5($password)."','".$phone."','".$e_mail."','".$tex_type."','".$tex_rate_sport."','".$tex_rate_minigame."','".$rec_one_folder_flag."','".$topRecId."',now(),'".$bank_name."','".$bank_num."','".$bank_username."','1',".$parentSn.",'".$logo."')";

		return $this->db->exeSql($sql);												
	}
	
	//▶ 추천등록된 횟수
	function getJoinRecommendCount($recommendSn)
	{
		$sql = "select count(*) as cnt
						from ".$this->db_qz."join_recommend 
						where recommend_sn='".$recommendSn."' and logo='".$this->logo."'";
					
		$rs = $this->db->exeSql($sql);
		
		return $rs[0]['cnt'];
	}
	
	//▶ 추천인 수입마일리지
	function getJoinRecommendBenefit($recommendSn)
	{
		$sql = "select sum(amount) as benefit from ".$this->db_qz."mileage_log where (state=2 or state=12) and status_message like('%추천인%') and 
						member_sn IN (select a.member_sn from ".$this->db_qz."join_recommend a, ".$this->db_qz."member b where a.member_sn=b.sn and a.recommend_sn=".$recommendSn.")";
		$rs = $this->db->exeSql($sql);
		return $rs[0]['benefit'];
	}
	
	//▶ 추천인 하위 데이터
	function getJoinRecommendSubList($recommendSn)
	{
		$sql = "select a.*, b.nick, b.uid, b.regdate from ".$this->db_qz."join_recommend a, ".$this->db_qz."member b
						where a.member_sn=b.sn and a.recommend_sn=".$recommendSn;
		$rs = $this->db->exeSql($sql);
		
		$item = array();
		if(is_array($rs) && count($rs) > 0) {
			for($i=0; $i<count($rs); ++$i)
			{
				$item[$i]['sn']		= $rs[$i]['member_sn'];
				$item[$i]['uid'] 	= $rs[$i]['uid'];
				$item[$i]['nick'] = $rs[$i]['nick'];
				$item[$i]['regdate'] = $rs[$i]['regdate'];
				
				$sql = "select sum(amount) as amount from ".$this->db_qz."mileage_log
								where (state=2 or state=12) and member_sn=".$item[$i]['sn']." and status_message like('%추천인%')";
				$rsi = $this->db->exeSql($sql);
				$item[$i]['benefit'] = $rsi[0]['amount'];
			}
		}
		return $item;
	}
	
	//▶ 파트너의 데이터 목록
	function getPartnerAdd()
	{
		$sql = "select partadd from ".$this->db_qz."admin 
						where logo='".$this->logo."'";
							
		$rs =  $this->db->exeSql($sql);					
		
		return $rs[0]['partadd'];
	}
	
	//▶ 필드 데이터
	function getPartnerBySn($sn)
	{
		$sql = "select * from ".$this->db_qz."recommend where Idx='".$sn."'";
		$rs =  $this->db->exeSql($sql);
		
		return $rs[0];
	}
	
	//▶ 필드 데이터
	function getPartnerById($uid)
	{
		$sql = "select * from ".$this->db_qz."recommend where rec_id='".$uid."'";
		$rs =  $this->db->exeSql($sql);
		
		return $rs[0];
	}
	
	//▶ 파트너의 계좌 수정  
	function modifyChangeBank($bankname,$banknum,$bankusername,$sn)
	{
		// $sql = "update ".$this->db_qz."recommend 
		// 					set rec_bankname='".$bankname."',rec_banknum='".$banknum."',rec_bankusername='".$bankusername."' 
		// 						where Idx='".$sn."'";
		$sql = "";
								
		return $this->db->exeSql($sql);						
	}
	
	//▶ 파트너의 패스워드 목록 
	function getPassword($sn)
	{
		$sql = "select rec_psw 
							from ".$this->db_qz."recommend 
								where Idx='".$sn."'";
		$rs = $this->db->exeSql($sql);						
		
		return $rs[0]['rec_psw']; 
	}
	
	//▶ 파트너의 패스워드 변졍 
	function modifyChangePassword($sn,$password)
	{
		$sql = "update ".$this->db_qz."recommend set rec_psw='".md5($password)."' 
						where Idx='".$sn."'";
								
		return $this->db->exeSql($sql);
	}
	
	//▶ 파트너의 멤버
	function getPartnerMember($partnerSn)
	{
		$sql = "select 
						(select count(*) from ".$this->db_qz."member b where a.idx=b.recommend_sn group by recommend_sn) as countmem,
						(select sum(g_money) from ".$this->db_qz."member b where a.idx=b.recommend_sn) as countmoney,
						(select count(*) from ".$this->db_qz."member b where a.idx=b.recommend_sn and b.regdate=date(now())) as countday 
							from ".$this->db_qz."recommend a where rec_id='".$partnerSn."'";

		$rs = $this->db->exeSql($sql); 		
		
		return $rs[0];				
	}

	//▶ 부본사 파트너의 멤버
	function getPartnerMemberTop($partnerId)
	{

//IN (select idx from tb_recommend where rec_parent_id = '".$partnerId."')
		$sql = "select 
						(select count(*) from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where rec_parent_id = '".$partnerId."')) as countmem,
						(select sum(g_money) from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where rec_parent_id = '".$partnerId."')) as countmoney,
						(select count(*) from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where rec_parent_id = '".$partnerId."') and regdate=date(now())) as countday 
							from ".$this->db_qz."recommend a where rec_id='".$partnerId."'";

		$rs = $this->db->exeSql($sql); 		
		
		return $rs[0];				
	}

	//▶ 파트너의 매장목록 
	function getPartnerInStoreList($partner_sn, $where="", $page=0, $page_size=0)
	{
		$sql = "select sn, uid, nick, g_money, regdate, mem_ip, reg_ip, last_date, mem_status, mem_lev, bank_member, (select rec_id from ".$this->db_qz."recommend where Idx=recommend_sn) as recommend_uid from ".$this->db_qz."member where is_store=1 and recommend_sn='".$partner_sn."' ".$where." order by regdate desc ";
		
		if($page_size!=0)	{$sql.= " limit ".$page.",".$page_size;}
		$rs = $this->db->exeSql($sql);
		
		for($i=0; $i < count((array)$rs); ++$i )
		{
			$member_sn = $rs[$i]['sn'];	
	
			//출금총액
			$sql = "select sum(agree_amount) as money, count(*) as cnt from ".$this->db_qz."exchange_log where state = 1 and member_sn=".$member_sn;
			$rsi	= $this->db->exeSql($sql);
			$rs[$i]['exchange_money'] = $rsi[0]['money']+0;
			$rs[$i]['exchange_cnt'] = $rsi[0]['cnt']+0;
			
			//입금총액
			$sql = "select sum(agree_amount) as money, count(*) as cnt from ".$this->db_qz."charge_log 
							where state = 1 and member_sn=".$member_sn;
			$rsi	= $this->db->exeSql($sql);
		
			$rs[$i]['charge_money'] = $rsi[0]['money']+0;
			$rs[$i]['charge_cnt'] = $rsi[0]['cnt']+0;

			//배팅총액
			$sql = "select count(*) as cnt, sum(betting_money) as money from ".$this->db_qz."game_cart
							where member_sn ='".$member_sn."' and kubun ='Y' ";
			$rsi = $this->db->exeSql($sql);
		
			$rs[$i]['bet_cnt'] = $rsi[0]['cnt']+0;
			$rs[$i]['bet_money'] = $rsi[0]['money']+0;
			
			//당첨금액
			$sql = "select sum(result_money) as win_money from ".$this->db_qz."game_cart
						 where member_sn ='".$member_sn."' and kubun ='Y' ";
			$rsi = $this->db->exeSql($sql);
			$rs[$i]['win_money'] = $rsi[0]['win_money']+0;
		}

		return $rs;
	}

	//▶ 파트너의 멤버목록 
	function getPartnerInMemberList($partner_sn, $where="", $page=0, $page_size=0)
	{
		$sql = "select sn, uid, nick, g_money, regdate, mem_ip, reg_ip, last_date, mem_status, mem_lev, bank_member, recommend_sn  from ".$this->db_qz."member  where is_store=0 and recommend_sn=".$partner_sn.$where;
		if($page_size!=0)	{$sql.= " limit ".$page.",".$page_size;}
		$rs = $this->db->exeSql($sql);
		if(is_array($rs) && count($rs) > 0) {
			for($i=0; $i < count($rs); ++$i )
			{
				$member_sn = $rs[$i]['sn'];	
		
				//출금총액
				$sql = "select sum(agree_amount) as money, count(*) as cnt from ".$this->db_qz."exchange_log where state = 1 and member_sn=".$member_sn;
				$rsi	= $this->db->exeSql($sql);
				$rs[$i]['exchange_money'] = $rsi[0]['money']+0;
				$rs[$i]['exchange_cnt'] = $rsi[0]['cnt']+0;
				
				//입금총액
				$sql = "select sum(agree_amount) as money, count(*) as cnt from ".$this->db_qz."charge_log 
								where state = 1 and member_sn=".$member_sn;
				$rsi	= $this->db->exeSql($sql);
			
				$rs[$i]['charge_money'] = $rsi[0]['money']+0;
				$rs[$i]['charge_cnt'] = $rsi[0]['cnt']+0;

				//배팅총액
				$sql = "select count(*) as cnt, sum(betting_money) as money from ".$this->db_qz."game_cart
								where member_sn ='".$member_sn."' and kubun ='Y' ";
				$rsi = $this->db->exeSql($sql);
			
				$rs[$i]['bet_cnt'] = $rsi[0]['cnt']+0;
				$rs[$i]['bet_money'] = $rsi[0]['money']+0;
				
				//당첨금액
				$sql = "select sum(result_money) as win_money from ".$this->db_qz."game_cart
							where member_sn ='".$member_sn."' and kubun ='Y' ";
				$rsi = $this->db->exeSql($sql);
				$rs[$i]['win_money'] = $rsi[0]['win_money']+0;
			}
		}

		return $rs;
	}

	//▶ 부본사 파트너의 매장목록 
	function getPartnerInStoreListTop($partner_id, $where="", $page=0, $page_size=0)
	{
		$sql = "select sn, uid, nick, g_money, regdate, mem_ip, reg_ip, last_date, mem_status, mem_lev, bank_member,
						(select rec_id from ".$this->db_qz."recommend where Idx=recommend_sn) as recommend_uid
						from ".$this->db_qz."member 
						where is_store=1 and recommend_sn IN (select idx from tb_recommend where rec_parent_id = '".$partner_id."') ".$where." order by regdate desc ";
		if($page_size!=0)	{$sql.= " limit ".$page.",".$page_size;}	
		$rs = $this->db->exeSql($sql);
		
		for($i=0; $i < count((array)$rs); ++$i )
		{
			$member_sn = $rs[$i]['sn'];	
	
			//출금총액
			$sql = "select sum(agree_amount) as money, count(*) as cnt from ".$this->db_qz."exchange_log where state = 1 and member_sn=".$member_sn;
			$rsi	= $this->db->exeSql($sql);
			$rs[$i]['exchange_money'] = $rsi[0]['money'];
			$rs[$i]['exchange_cnt'] = $rsi[0]['cnt'];
			
			//입금총액
			$sql = "select sum(agree_amount) as money, count(*) as cnt from ".$this->db_qz."charge_log 
							where state = 1 and member_sn=".$member_sn;
			$rsi	= $this->db->exeSql($sql);
		
			$rs[$i]['charge_money'] = $rsi[0]['money'];
			$rs[$i]['charge_cnt'] = $rsi[0]['cnt'];

			//배팅총액
			$sql = "select count(*) as cnt, sum(betting_money) as money from ".$this->db_qz."game_cart
							where member_sn ='".$member_sn."' and kubun ='Y' ";
			$rsi = $this->db->exeSql($sql);
		
			$rs[$i]['bet_cnt'] = $rsi[0]['cnt'];
			$rs[$i]['bet_money'] = $rsi[0]['money'];
			
			//당첨금액
			$sql = "select sum(result_money) as win_money from ".$this->db_qz."game_cart
						 where member_sn ='".$member_sn."' and kubun ='Y' ";
			$rsi = $this->db->exeSql($sql);
		
			$rs[$i]['win_money'] = $rsi[0]['win_money'];
		}

		return $rs;
	}

	//▶ 부본사 파트너의 멤버목록 
	function getPartnerInMemberListTop($partner_id, $where="", $page=0, $page_size=0)
	{
		$sql = "select sn, uid, nick, g_money, regdate, mem_ip, reg_ip, last_date, mem_status, mem_lev, bank_member, recommend_sn from ".$this->db_qz."member where is_store=0 and recommend_sn IN (select idx from tb_recommend where rec_parent_id = '".$partner_id."') ".$where." order by regdate desc ";
				
		if($page_size!=0)	{$sql.= " limit ".$page.",".$page_size;}	
		$rs = $this->db->exeSql($sql);
		
		for($i=0; $i < count((array)$rs); ++$i )
		{
			$member_sn = $rs[$i]['sn'];	
			$recommend_sn = $rs[$i]['recommend_sn'];
			//소속매자id
			$sql = "select rec_id from tb_recommend where Idx=".$recommend_sn;
			$rsi	= $this->db->exeSql($sql);
			$rs[$i]['recommend_uid'] = $rsi[0]['rec_id'];

			//출금총액
			$sql = "select sum(agree_amount) as money, count(*) as cnt from ".$this->db_qz."exchange_log where state = 1 and member_sn=".$member_sn;
			$rsi	= $this->db->exeSql($sql);
			$rs[$i]['exchange_money'] = $rsi[0]['money'];
			$rs[$i]['exchange_cnt'] = $rsi[0]['cnt'];
			
			//입금총액
			$sql = "select sum(agree_amount) as money, count(*) as cnt from ".$this->db_qz."charge_log 
							where state = 1 and member_sn=".$member_sn;
			$rsi	= $this->db->exeSql($sql);
		
			$rs[$i]['charge_money'] = $rsi[0]['money'];
			$rs[$i]['charge_cnt'] = $rsi[0]['cnt'];

			//배팅총액
			$sql = "select count(*) as cnt, sum(betting_money) as money from ".$this->db_qz."game_cart
							where member_sn ='".$member_sn."' and kubun ='Y' ";
			$rsi = $this->db->exeSql($sql);
		
			$rs[$i]['bet_cnt'] = $rsi[0]['cnt'];
			$rs[$i]['bet_money'] = $rsi[0]['money'];
			
			//당첨금액
			$sql = "select sum(result_money) as win_money from ".$this->db_qz."game_cart
						 where member_sn ='".$member_sn."' and kubun ='Y' ";
			$rsi = $this->db->exeSql($sql);
		
			$rs[$i]['win_money'] = $rsi[0]['win_money'];
		}

		return $rs;
	}
	
	//▶ 파트너의 매장수 
	function getPartnerInStoreTotal($partner_sn, $where)
	{
		$sql = "select count(*) as cnt from ".$this->db_qz."member 
						where is_store=1 and recommend_sn = '".$partner_sn."' ".$where;
					
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}

	//▶ 파트너의 멤버수 
	function getPartnerInMemberTotal($partner_sn, $where)
	{
		$sql = "select count(*) as cnt from ".$this->db_qz."member 
						where recommend_sn = ".$partner_sn." ".$where;
					
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}

	//-> 부본사 하위 총판수
	function getMyPartnerTotal($partner_id, $where)
	{
		$sql = "select count(*) as cnt from ".$this->db_qz."recommend where rec_parent_id = '".$partner_id."' ".$where;
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}

	//-> 부본사 하위 총판
	function getMyPartner($partner_id, $where="", $page=0, $page_size=0)
	{
		$sql = "select * from ".$this->db_qz."recommend where rec_parent_id = '".$partner_id."' ".$where;		
		if($page_size!=0)	
			$sql.= " limit ".$page.",".$page_size;
		$rs = $this->db->exeSql($sql);
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$rsi = $this->getPartnerInMemberList($rs[$i]['Idx']);

			//회원수
			$rs[$i]['member_count'] += count((array)$rsi);			

			for($j=0; $j<count((array)$rsi); ++$j)
			{
				//출금총액
				$rs[$i]['total_mem_money'] += $rsi[$j]['g_money'];
				//출금총액
				$rs[$i]['exchange_money'] += $rsi[$j]['exchange_money'];
				//입금총액
				$rs[$i]['charge_money'] += $rsi[$j]['charge_money'];
				//입금회원수
				$rs[$i]['charge_cnt'] += $rsi[$j]['charge_cnt'];
				//배팅총액
				$rs[$i]['bet_money'] += $rsi[$j]['bet_money'];
				//당첨총액
				$rs[$i]['win_money'] += $rsi[$j]['win_money'];
			}
			//-> 정산금
			$rs[$i]["tex_money"] = $this->getTotalTexMoney($rs[$i]['Idx']);
			$rs[$i]["item"] = $rsi;
		}
		return $rs;
	}

	//-> 총판 정산금 합계
	function getTotalTexMoney($recommendSn = 0, $startDate = "", $endDate = "") {
		if ( $startDate and $endDate ) {
			$where = " and regdate between '".$startDate." 00:00:00' and '".$endDate." 23:59:59'";
		}
		$sql = "select sum(get_tex_money) as tex_money from ".$this->db_qz."recommend_tex where rec_sn = '{$recommendSn}' {$where}";
		$rs = $this->db->exeSql($sql);
		return $rs[0]['tex_money'];
	}

	//▶ 부본사 하위 매장수 
	function getPartnerInStoreTotalTop($partner_id, $where)
	{
		$sql = "select count(*) as cnt from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where rec_parent_id = '".$partner_id."') ".$where;
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}

	//▶ 부본사 하위 멤버수 
	function getPartnerInMemberTotalTop($partner_id, $where)
	{
		$sql = "select count(*) as cnt from ".$this->db_qz."member where recommend_sn IN (select sn from ".$this->db_qz."member where is_store=0 and recommend_sn IN (select idx from tb_recommend where rec_parent_id = '".$partner_id."')) ".$where;
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}

	//▶ 롤링 목록
	function getRollingList($partnerSn, $where="", $page=0, $page_size=0)
	{
		$sql = "select * from ".$this->db_qz."recommend where parent_sn=".$partnerSn." ";
		
		if($where!="") 
			$sql.= $where;
			
		if($page_size!=0)	
			$sql.= " limit ".$page.",".$page_size;
						
		$rs = $this->db->exeSql($sql);
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$rsi = $this->getPartnerInMemberList($rs[$i]['Idx']);
			
			//회원수
			$rs[$i]['member_count'] += count((array)$rsi);
			
			for($j=0; $j<count((array)$rsi); ++$j)
			{
				//출금총액
				$rs[$i]['exchange_money'] += $rsi[$j]['exchange_money'];
				//입금총액
				$rs[$i]['charge_money'] += $rsi[$j]['charge_money'];
				//입금회원수
				$rs[$i]['charge_cnt'] += $rsi[$j]['charge_cnt'];
				//배팅총액
				$rs[$i]['bet_money'] += $rsi[$j]['bet_money'];
				//당첨총액
				$rs[$i]['win_money'] += $rsi[$j]['win_money'];
			}
		}
		return $rs;
	}
	
	//▶ 롤링 목록
	function getSelectorRollingList($parentSn)
	{
		$sql = "select * from ".$this->db_qz."recommend where status=1 and parent_sn=".$parentSn;
						
		return $this->db->exeSql($sql);
	}
	
	//▶ 롤링 목록
	function getRollingTotal($partnerSn, $where="")
	{
		$sql = "select count(*) as cnt from ".$this->db_qz."recommend where parent_sn=".$partnerSn." ";
		if($where!="")
			$sql.= $where;
						
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 총판 회원  목록
	function getRecommendMemberList($recommendLevel/*1=총판, 2=롤링*/, $recommendSn, $where="", $page=0, $page_size=0)
	{
		if($page_size!=0)
			$limit.= " limit ".$page.",".$page_size;
		
		if(1==$recommendLevel)
			$where.= " and recommend_sn='".$recommendSn."'" ;
		elseif(2==$recommendLevel)
			$where.= " and rolling_sn='".$recommendSn."'" ;

		$sql = "select sn, uid, nick, g_money, regdate, mem_ip, mem_status, mem_lev, bank_member,
								(select rec_id from ".$this->db_qz."recommend where Idx=recommend_sn) as recommend_uid,
								(select rec_id from ".$this->db_qz."recommend where Idx=rolling_sn) as rolling_uid
						from ".$this->db_qz."member  
						where logo='".$this->logo."'".$where." order by regdate desc ".$limit;
		
		$rs = $this->db->exeSql($sql);
		
		for($i=0; $i < count((array)$rs); ++$i )
		{
			$member_sn = $rs[$i]['sn'];	
	
			//출금총액
			$sql = "select sum(agree_amount) as money, count(*) as cnt from ".$this->db_qz."exchange_log where state = 1 and member_sn=".$member_sn;
			$rsi	= $this->db->exeSql($sql);
			$rs[$i]['exchange_money'] = $rsi[0]['money'];
			$rs[$i]['exchange_cnt'] = $rsi[0]['cnt'];
			
			//입금총액
			$sql = "select sum(agree_amount) as money, count(*) as cnt from ".$this->db_qz."charge_log 
							where state = 1 and member_sn=".$member_sn;
			$rsi	= $this->db->exeSql($sql);
		
			$rs[$i]['charge_money'] = $rsi[0]['money'];
			$rs[$i]['charge_cnt'] = $rsi[0]['cnt'];

			//배팅총액
			$sql = "select count(*) as cnt, sum(betting_money) as money from ".$this->db_qz."game_cart
							where logo='".$this->logo."' and member_sn ='".$member_sn."' and kubun ='Y' ";
			$rsi = $this->db->exeSql($sql);
		
			$rs[$i]['bet_cnt'] = $rsi[0]['cnt'];
			$rs[$i]['bet_money'] = $rsi[0]['money'];
			
			//당첨금액
			$sql = "select sum(result_money) as win_money from ".$this->db_qz."game_cart
							where logo='".$this->logo."' and member_sn ='".$member_sn."' and kubun ='Y' ";
			$rsi = $this->db->exeSql($sql);
		
			$rs[$i]['win_money'] = $rsi[0]['win_money'];
		}
	
		return $rs;
	}
	
	//▶ 총판 회원회원 총합
	function getRecommendMemberTotal($recommendLevel/*1=총판, 2=롤링*/, $recommendSn, $where="")
	{
		if(1==$recommendLevel)
			$where.= " and recommend_sn='".$recommendSn."'" ;
		elseif(2==$recommendLevel)
			$where.= " and rolling_sn='".$recommendSn."'" ;
			
		$sql = "select count(*) as cnt
						from ".$this->db_qz."member  
						where logo='".$this->logo."'".$where." order by regdate desc";
		
		$rs = $this->db->exeSql($sql);
		
		return $rs[0]['cnt'];
	}

	//▶ 총판입금 목록
	function getRecommendChargeList($recommendSn, $startDate="", $endDate="", $where="", $page=0, $page_size=0)
	{
		if($page_size > 0)
			$limit = " limit ".$page.",".$page_size;
		
		$sql = "select a.sn, a.regdate, a.operdate, a.member_sn, a.amount, a.agree_amount, a.before_money, a.after_money, a.bonus,a.bank_owner, a.state,
						(select rec_id from ".$this->db_qz."recommend where Idx=rolling_sn) as rolling_id,
						b.uid, b.nick, b.g_money, b.bank_member, ifnull(c.rec_id, '무소속') as recommend_id
						from ".$this->db_qz."charge_log a,".$this->db_qz."member b left outer join ".$this->db_qz."recommend c on b.recommend_sn=c.idx
						where a.member_sn=b.sn and b.recommend_sn='".$recommendSn."' and a.regdate between '".$startDate." 00:00:00' and '".$endDate." 23:59:59' ".$where."
						order by a.regdate desc ".$limit;
		return $this->db->exeSql($sql);
	}

	//-> 부본사 하부 회원 입금 합계
	function getRecommendChargeTotalTop($recommendId, $startDate="", $endDate="", $where="")
	{
		$sql = "select count(*) as cnt, sum(agree_amount) as sum_amount from tb_charge_log a, tb_member b where a.member_sn = b.sn and b.recommend_sn IN (select idx from tb_recommend where rec_parent_id = '".$recommendId."') and a.regdate between '".$startDate." 00:00:00' and '".$endDate." 23:59:59' ".$where;
		$rs = $this->db->exeSql($sql);
		return $rs[0];
	}

	//-> 부본사 하부 회원 입금 목록
	function getRecommendChargeListTop($recommendId, $startDate="", $endDate="", $where="", $page=0, $page_size=0)
	{
		if($page_size > 0)
			$limit = " limit ".$page.",".$page_size;
		
		$sql = "select a.sn, a.regdate, a.operdate, a.member_sn, a.amount, a.agree_amount, a.before_money, a.after_money, a.bonus,a.bank_owner, a.state,						
						b.uid, b.nick, b.g_money, b.bank_member, (select rec_id from tb_recommend where idx=b.recommend_sn) as recommend_id
						from ".$this->db_qz."charge_log a,".$this->db_qz."member b
						where a.member_sn=b.sn and b.recommend_sn IN (select idx from tb_recommend where rec_parent_id = '".$recommendId."') and a.regdate between '".$startDate." 00:00:00' and '".$endDate." 23:59:59' ".$where." order by a.regdate desc ".$limit;
		return $this->db->exeSql($sql);
	}

	//▶ 총판입금 총합
	function getRecommendChargeTotal($recommendSn, $startDate="", $endDate="", $where="")
	{		
		$sql = "select count(*) as cnt, sum(agree_amount) as sum_amount
						from ".$this->db_qz."charge_log a,".$this->db_qz."member b left outer join ".$this->db_qz."recommend c on b.recommend_sn=c.idx
						where a.member_sn=b.sn and b.recommend_sn='".$recommendSn."' and a.regdate between '".$startDate." 00:00:00' and '".$endDate." 23:59:59'";
		$rs = $this->db->exeSql($sql);
		return $rs[0];
	}
	
	//▶ 출금목록
	function getRecommendExchangeList($recommendSn, $startDate="", $endDate="", $where="", $page=0, $page_size=0)
	{
		if($page_size > 0)
			$limit = " limit ".$page.",".$page_size;
		
		$sql = "select a.sn, a.regdate, a.operdate, a.member_sn, a.amount, a.agree_amount, a.before_money, a.after_money, a.bank_owner, a.state,
						b.uid, b.nick, b.g_money, b.bank_member, ifnull(c.rec_id, '무소속') as recommend_id
						from ".$this->db_qz."exchange_log a,".$this->db_qz."member b left outer join ".$this->db_qz."recommend c on b.recommend_sn=c.idx
						where a.member_sn=b.sn and b.recommend_sn='".$recommendSn."' and a.regdate between '".$startDate." 00:00:00' and '".$endDate." 23:59:59' order by a.regdate desc ".$limit;						
		return $this->db->exeSql($sql);
	}

	//-> 부본사 하부 회원 출금 목록
	function getRecommendExchangeListTop($recommendId, $startDate="", $endDate="", $where="", $page=0, $page_size=0)
	{
		if($page_size > 0)
			$limit = " limit ".$page.",".$page_size;
		
		$sql = "select a.sn, a.regdate, a.operdate, a.member_sn, a.amount, a.agree_amount, a.before_money, a.after_money, a.bank_owner, a.state,						
						b.uid, b.nick, b.g_money, b.bank_member, (select rec_id from tb_recommend where idx=b.recommend_sn) as recommend_id
						from ".$this->db_qz."exchange_log a,".$this->db_qz."member b
						where a.member_sn=b.sn and b.recommend_sn IN (select idx from tb_recommend where rec_parent_id = '".$recommendId."') and a.regdate between '".$startDate." 00:00:00' and '".$endDate." 23:59:59' ".$where."
						order by a.regdate desc ".$limit;
		return $this->db->exeSql($sql);
	}

	function getRecommendExchangeTotal($recommendSn, $startDate="", $endDate="")
	{	
		$sql = "select count(*) as cnt, sum(agree_amount) as sum_amount
						from ".$this->db_qz."exchange_log a,".$this->db_qz."member b left outer join ".$this->db_qz."recommend c on b.recommend_sn=c.idx
						where a.member_sn=b.sn and b.recommend_sn='".$recommendSn."' and a.regdate between '".$startDate." 00:00:00' and '".$endDate." 23:59:59'";
		$rs = $this->db->exeSql($sql);		
		return $rs[0];
	}

	//-> 부본사 하위 회원 출금내역 합계
	function getRecommendExchangeTotalTop($recommendId, $startDate="", $endDate="", $where="")
	{
		$sql = "select count(*) as cnt, sum(agree_amount) as sum_amount from tb_exchange_log a, tb_member b where a.member_sn = b.sn and b.recommend_sn IN (select idx from tb_recommend where rec_parent_id = '".$recommendId."') and a.regdate between '".$startDate." 00:00:00' and '".$endDate." 23:59:59' ".$where;
		$rs = $this->db->exeSql($sql);	
		return $rs[0];
	}

	//▶ 파트너 소속 회원 총 보유금액
	function getTotalMemberMoney( $partnerSn='', $logo='') {
		$sql = "select sum(g_money) as total_g_money from ".$this->db_qz."member where recommend_sn='".$partnerSn."'";		
		$rs = $this->db->exeSql($sql);
		return $rs[0]['total_g_money'] + 0;
	}

	//-> partner. 총판 관리자가 정산금 데이터를 조회	
	function getTexDataPartner($recommendSn = 0, $startDate = "", $endDate = "") {
		$sql = "select * from ".$this->db_qz."recommend_tex
						where rec_sn = '".$recommendSn."' and regdate between '".$startDate." 00:00:00' and '".$endDate." 23:59:59' 
						order by regdate asc";
		return $this->db->exeSql($sql);
	}

	//-> partner. 부본사가 정산금 데이터를 조회	
	function getTexDataPartnerTop($recommendSn = 0, $startDate = "", $endDate = "") {
		$sql = "select 	regdate,
						DATE_FORMAT(regdate,'%Y-%m-%d') as regdates,
						sum(money_to_charge) as money_to_charge,
						sum(money_to_exchange) as money_to_exchange,
						sum(betting_to_ready) as betting_to_ready,
						sum(betting_to_win) as betting_to_win,
						sum(betting_to_lose) as betting_to_lose,
						sum(result_to_win) as result_to_win,
						sum(mileage_to_charge) as mileage_to_charge,
						sum(mileage_to_recomm_lose) as mileage_to_recomm_lose,
						sum(mileage_to_multi_folder) as mileage_to_multi_folder,
						sum(mileage_to_multi_folder_lose) as mileage_to_multi_folder_lose,
						sum(mileage_to_one_folder_lose) as mileage_to_one_folder_lose,
						sum(get_tex_money_top) as get_tex_money_top
				from ".$this->db_qz."recommend_tex
				where rec_sn_top = '".$recommendSn."' and regdate between '".$startDate." 00:00:00' and '".$endDate." 23:59:59' 
				group by regdates order by regdate asc";
		return $this->db->exeSql($sql);
	}

	//-> mg. 관리자가 정산금 관련해서 데이터를 조회	
	function getTexData($texDate = "", $startDate = "", $endDate = "") {
		if ( strlen($texDate) > 1 ) {
			$sql = "select
						b.rec_money,
						a.rec_sn,
						a.rec_id,
						a.save_rate_type,
						a.save_rate,
						a.save_one_folder_flag,
						sum(a.money_to_charge) as money_to_charge,
						sum(a.money_to_exchange) as money_to_exchange,
						sum(a.betting_to_ready) as betting_to_ready,
						sum(a.betting_to_win) as betting_to_win,
						sum(a.betting_to_win_mgame) as betting_to_win_mgame,
						sum(a.betting_to_lose) as betting_to_lose,
						sum(a.betting_to_lose_mgame) as betting_to_lose_mgame,
						sum(a.result_to_win) as result_to_win,
						sum(a.result_to_win_mgame) as result_to_win_mgame,
						sum(a.mileage_to_charge) as mileage_to_charge,
						sum(a.mileage_to_recomm_lose) as mileage_to_recomm_lose,
						sum(a.mileage_to_multi_folder) as mileage_to_multi_folder,
						sum(a.mileage_to_multi_folder_lose) as mileage_to_multi_folder_lose,
						sum(a.mileage_to_one_folder_lose) as mileage_to_one_folder_lose,
						sum(a.tex_money) as tex_money,
						sum(a.get_tex_money) as get_tex_money,
						sum(a.betting_to_ready) as betting_to_ready
					from ".$this->db_qz."recommend_tex a, ".$this->db_qz."recommend b
					where a.rec_sn = b.Idx and a.regdate between '".$texDate." 00:00:00' and '".$texDate." 23:59:59' 
					group by a.rec_sn order by a.rec_id asc";
			return $this->db->exeSql($sql);
		} else if ( strlen($startDate) > 1 && strlen($endDate) > 1 ) {
			$sql = "select
						b.rec_money,
						a.rec_sn,
						a.rec_id,
						a.save_rate_type,
						a.save_rate,
						a.save_one_folder_flag,
						sum(a.money_to_charge) as money_to_charge,
						sum(a.money_to_exchange) as money_to_exchange,
						sum(a.betting_to_ready) as betting_to_ready,
						sum(a.betting_to_win) as betting_to_win,
						sum(a.betting_to_win_mgame) as betting_to_win_mgame,
						sum(a.betting_to_lose) as betting_to_lose,
						sum(a.betting_to_lose_mgame) as betting_to_lose_mgame,
						sum(a.result_to_win) as result_to_win,
						sum(a.result_to_win_mgame) as result_to_win_mgame,
						sum(a.mileage_to_charge) as mileage_to_charge,
						sum(a.mileage_to_recomm_lose) as mileage_to_recomm_lose,
						sum(a.mileage_to_multi_folder) as mileage_to_multi_folder,
						sum(a.mileage_to_multi_folder_lose) as mileage_to_multi_folder_lose,
						sum(a.mileage_to_one_folder_lose) as mileage_to_one_folder_lose,
						sum(a.tex_money) as tex_money,
						sum(a.get_tex_money) as get_tex_money,
						sum(a.betting_to_ready) as betting_to_ready
					from ".$this->db_qz."recommend_tex a, ".$this->db_qz."recommend b
					where a.rec_sn = b.Idx and a.regdate between '".$startDate." 00:00:00' and '".$endDate." 23:59:59' 
					group by a.rec_sn order by a.rec_id asc";
			return $this->db->exeSql($sql);
		}
	}

	//-> mg. 관리자가 부본사 정산금 관련해서 데이터를 조회	
	function getTexDataTop($texDate = "", $startDate = "", $endDate = "") {
		if ( strlen($texDate) > 1 ) {
			$sql = "select
						b.rec_money,
						a.rec_sn_top,
						a.rec_id_top,
						a.save_one_folder_flag,
						a.save_rate_type,
						a.save_rate_top,
						sum(a.money_to_charge) as money_to_charge,
						sum(a.money_to_exchange) as money_to_exchange,
						sum(a.betting_to_ready) as betting_to_ready,
						sum(a.betting_to_win) as betting_to_win,
						sum(a.betting_to_win_mgame) as betting_to_win_mgame,
						sum(a.betting_to_lose) as betting_to_lose,
						sum(a.betting_to_lose_mgame) as betting_to_lose_mgame,
						sum(a.result_to_win) as result_to_win,
						sum(a.result_to_win_mgame) as result_to_win_mgame,
						sum(a.mileage_to_charge) as mileage_to_charge,
						sum(a.mileage_to_recomm_lose) as mileage_to_recomm_lose,
						sum(a.mileage_to_multi_folder) as mileage_to_multi_folder,
						sum(a.mileage_to_multi_folder_lose) as mileage_to_multi_folder_lose,
						sum(a.mileage_to_one_folder_lose) as mileage_to_one_folder_lose,
						sum(a.tex_money_top) as tex_money_top,
						sum(a.get_tex_money_top) as get_tex_money_top,
						a.texdate
					from tb_recommend_tex a LEFT JOIN tb_recommend b ON a.rec_sn_top = b.Idx
					where a.regdate between '".$texDate." 00:00:00' and '".$texDate." 23:59:59' group by a.rec_sn_top order by a.rec_id_top asc";

			return $this->db->exeSql($sql);
		} else if ( strlen($startDate) > 1 and strlen($endDate) > 1 ) {
			$sql = "select
						b.rec_money,
						a.rec_sn_top,
						a.rec_id_top,
						a.save_one_folder_flag,
						a.save_rate_type,
						a.save_rate_top,
						sum(a.money_to_charge) as money_to_charge,
						sum(a.money_to_exchange) as money_to_exchange,
						sum(a.betting_to_ready) as betting_to_ready,
						sum(a.betting_to_win) as betting_to_win,
						sum(a.betting_to_win_mgame) as betting_to_win_mgame,
						sum(a.betting_to_lose) as betting_to_lose,
						sum(a.betting_to_lose_mgame) as betting_to_lose_mgame,
						sum(a.result_to_win) as result_to_win,
						sum(a.result_to_win_mgame) as result_to_win_mgame,
						sum(a.mileage_to_charge) as mileage_to_charge,
						sum(a.mileage_to_recomm_lose) as mileage_to_recomm_lose,
						sum(a.mileage_to_multi_folder) as mileage_to_multi_folder,
						sum(a.mileage_to_multi_folder_lose) as mileage_to_multi_folder_lose,
						sum(a.mileage_to_one_folder_lose) as mileage_to_one_folder_lose,
						sum(a.tex_money_top) as tex_money_top,
						sum(a.get_tex_money_top) as get_tex_money_top,
						a.texdate
					from tb_recommend_tex a LEFT JOIN tb_recommend b ON a.rec_sn_top = b.Idx
					where a.regdate between '".$startDate." 00:00:00' and '".$endDate." 23:59:59' group by a.rec_sn_top order by a.rec_id_top asc";
			return $this->db->exeSql($sql);
		}
	}

	//-> 총판 보유머니 변경
	function modifyRecMoney($recommendSn, $rec_money) {
		$sql = "update ".$this->db_qz."recommend set rec_money='".$rec_money."' where Idx='".$recommendSn."'";
		return $this->db->exeSql($sql);
	}

	//-> 총판 머니 변동 로그
	function changeRecMoneyLog($recommendSn, $amount, $before_money, $after_money, $state, $status_message) {
		$hDate = date("Y-m-d H:i:s",time());
		$sql = "insert into ".$this->db_qz."recommend_money_log (rec_sn, amount, before_money, after_money, state, status_message, proc_flag, regdate) values (";
		$sql = $sql."'".$recommendSn."','".$amount."','".$before_money."','".$after_money."','".$state."','".$status_message."',0, '".$hDate."')";
		return $this->db->exeSql($sql);
	}

	//-> 총판 출금신청 합계
	function getRecExchangeLogTotal($where="") {	
		$sql = "select count(*) as cnt
						from ".$this->db_qz."recommend_money_log a, ".$this->db_qz."recommend b
						where a.rec_sn = b.Idx ".$where;
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}

	//-> 총판 출금신청 리스트
	function getRecExchangeLogList($where="", $page=0, $page_size=0) {		
		if($page_size > 0) $limit = " limit ".$page.",".$page_size;
			
		$sql = "select *, a.sn as log_sn
						from ".$this->db_qz."recommend_money_log a, ".$this->db_qz."recommend b
						where a.rec_sn = b.Idx ".$where." order by a.regdate desc ".$limit;						
		$rs = $this->db->exeSql($sql);

		//-> 읽음(알림) 업데이트
		if(is_array($rs) && count($rs) > 0) {
			for ( $i = 0 ; $i < count($rs) ; ++$i ) {
				$sql = "update ".$this->db_qz."recommend_money_log set is_read = 1 where sn=".$rs[$i]['sn'];
				$this->db->exeSql($sql);
			}
		}
		return $rs;
	}

	//-> 총판 출금신청 정보 (1건)
	function getRecExchangeLog($log_sn) {
		$sql = "select * from ".$this->db_qz."recommend_money_log where proc_flag = 0 and sn = '".$log_sn."'";
		return $this->db->exeSql($sql);
	}

	//-> 총판 출금신청 승인
	function exchangeRecProcess($log_sn) {
		$hDate = date("Y-m-d H:i:s",time());
		$sql = "update ".$this->db_qz."recommend_money_log set proc_flag = 1, procdate = '".$hDate."' where sn=".$log_sn;
		$this->db->exeSql($sql);
	}

	//-> 총판 출금신청 취소 (신청금 반환)
	function exchangeRecCancelProcess($log_sn) {
		// 로그 정보
		$sql = "select rec_sn, amount from ".$this->db_qz."recommend_money_log where proc_flag = 0 and sn = '".$log_sn."'";
		$rs = $this->db->exeSql($sql);
		$rec_sn = $rs[0]["rec_sn"];
		$amount = $rs[0]["amount"];
		
		if ( $rec_sn > 0 and $amount > 0 ) {
			// 총판 보유머니
			$sql = "select rec_money from ".$this->db_qz."recommend where Idx = '".$rec_sn."'";
			$rs = $this->db->exeSql($sql);
			$rec_money = $rs[0]["rec_money"];

			// 총판 머니 돌려주기
			$rec_money = $rec_money + $amount;
			$sql = "update ".$this->db_qz."recommend set rec_money = '".$rec_money."' where Idx = '".$rec_sn."'";
			if ( $rs = $this->db->exeSql($sql) ) {
				// 로그 업데이트
				$hDate = date("Y-m-d H:i:s",time());
				$sql = "update ".$this->db_qz."recommend_money_log set proc_flag = 3, procdate = '".$hDate."' where sn = '".$log_sn."'";
				$this->db->exeSql($sql);
			}
		}
	}

	//▶ 롤링 입출금 통계
	function getRecommendMoneyList($recommendSn, $beginDate, $endDate, $logo='')
	{
		$statModel = Lemon_Instance::getObject("StatModel",true);
	
		$list = array();
		$rs = $statModel->getMoneyList("", $recommendSn, $beginDate, $endDate, $logo);
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$list[$i]['current_date']		=  $rs[$i]['current_date'];
			$list[$i]['exchange']				+= $rs[$i]['exchange'];
			$list[$i]['count_exchange']	+= $rs[$i]['count_exchange'];
			$list[$i]['charge']					+= $rs[$i]['charge'];
			$list[$i]['count_charge']		+= $rs[$i]['count_charge'];
			$list[$i]['betting']				+= $rs[$i]['betting'];
			$list[$i]['win_money']			+= $rs[$i]['win_money'];
			$list[$i]['lose_money']			+= $rs[$i]['lose_money'];
			$list[$i]['benefit']				+= ($rs[$i]['charge']-$rs[$i]['exchange']);

			//-> 단폴더
			$list[$i]['betting_one']		+= $rs[$i]['betting_one'];
			$list[$i]['win_money_one'] += $rs[$i]['win_money_one'];
			$list[$i]['lose_money_one'] += $rs[$i]['lose_money_one'];
			$list[$i]['one_folder_charge']	+= $rs[$i]['one_folder_charge'];

			$list[$i]['admin_charge'] += $rs[$i]['admin_charge'];
			$list[$i]['admin_exchange'] += $rs[$i]['admin_exchange'];
			$list[$i]['admin_mileage_charge'] += $rs[$i]['admin_mileage_charge'];
			$list[$i]['admin_mileage_exchange'] += $rs[$i]['admin_mileage_exchange'];

			//-> 정산금회원에게 내림
			$list[$i]['admin_tex_charge'] += $rs[$i]['admin_tex_charge'];
		}

		return $list;
	}
	
	//▶ 롤링별 입출금 통계 
	function getRollingMoneyList($rollingSn, $beginDate='', $endDate='')
	{
		$statModel = Lemon_Instance::getObject("StatModel",true);
	
		$list = array();
		$rs = $statModel->getRollingMoneyList("", $rollingSn, $beginDate, $endDate);
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$list[$i]['current_date']		=  $rs[$i]['current_date'];
			$list[$i]['exchange']				+= $rs[$i]['exchange'];
			$list[$i]['count_exchange']	+= $rs[$i]['count_exchange'];
			$list[$i]['charge']					+= $rs[$i]['charge'];
			$list[$i]['count_charge']		+= $rs[$i]['count_charge'];
			$list[$i]['betting']				+= $rs[$i]['betting'];
			$list[$i]['win_money']			+= $rs[$i]['win_money'];
			$list[$i]['lose_money']			+= $rs[$i]['lose_money'];
			$list[$i]['benefit']				+= ($rs[$i]['charge']-$rs[$i]['exchange']);

			//-> 단폴더
			$list[$i]['betting_one']		+= $rs[$i]['betting_one'];
			$list[$i]['win_money_one'] += $rs[$i]['win_money_one'];
			$list[$i]['lose_money_one'] += $rs[$i]['lose_money_one'];
			$list[$i]['one_folder_charge'] += $rs[$i]['one_folder_charge'];

			$list[$i]['admin_charge'] += $rs[$i]['admin_charge'];
			$list[$i]['admin_exchange'] += $rs[$i]['admin_exchange'];
			$list[$i]['admin_mileage_charge'] += $rs[$i]['admin_mileage_charge'];
			$list[$i]['admin_mileage_exchange'] += $rs[$i]['admin_mileage_exchange'];
		}

		return $list;
	}
	
	//▶ 정산 신청 
	function addAccounting($partner_sn,$start_date,$end_date,$exchange_money,$charge_money,$rate,$optmoney,$bank_name,$bank_num,$bank_username)
	{
		$sql="insert into ".$this->db_qz."recommend_account(rec_idx,start_date,end_date,exchange_money,charge_money,rate,opt_money,reg_date,status,bank_name,bank_num,bank_username,logo) values";
		$sql=$sql."(".$partner_sn.",'".$start_date."','".$end_date."','".$exchange_money."','".$charge_money."','".$rate."','".$optmoney."',now(),0,'".$bank_name."','".$bank_num."','".$bank_username."','".$this->logo."')";
	
		$this->db->exeSql($sql);
	}
	
	//▶ 정산 신청할수 있는  파트너 목록 
	function getPartnerAccounting($partner_sn)
	{
		$array = array();
		
		$sql = "select *,(select rec_id from ".$this->db_qz."recommend where logo='".$this->logo."' 
			and idx=".$this->db_qz."recommend_account.rec_idx)as name from ".$this->db_qz."recommend_account 
			where  status=0 and logo='".$this->logo."' and rec_idx=".$partner_sn;
			
		$rs = $this->db->exeSql($sql);
		
		$array['size'] = count((array)$rs);
		
		if( count((array)$rs) > 0 )
		{
			$array['name'] = $rs[0]['name'];
			$array['start_date'] = $rs[0]['start_date'];
			$array['end_date'] = $rs[0]['end_date'];
			$array['exchange_money'] = $rs[0]['exchange_money'];
			$array['charge_money'] = $rs[0]['charge_money'];
			$array['rate'] = $rs[0]['rate'];
			$array['opt_money'] = $rs[0]['opt_money'];
			$array['bank_name'] = $rs[0]['bank_name'];
			$array['bank_num'] = $rs[0]['bank_num'];
			$array['bank_username'] =$rs[0]['bank_username'];					
			
		}
		else
		{
			$sql = "select max(date(reg_date)) as reg_date 
							from ".$this->db_qz."recommend_account 
								where logo='".$this->logo."' and  rec_idx=".$partner_sn;
			$rsi = $this->db->exeSql($sql);			
			$array['reg_date'] = $rsi[0]['reg_date'];			
			if( $array['reg_date'] == '' )
			{
				$array['reg_date'] = "2012-01-01";				
			}	
		
			$sql = "select date(now())='".$array['reg_date']."' as diff";
			$rsi = $this->db->exeSql($sql);			
			$array['stat'] = $rsi[0]['diff'];
		
			$sql = "select date(date_sub(now(),interval 1 day)) as objdate";
			$rsi = $this->db->exeSql($sql);		
			$array['objdate'] = $rsi[0]['objdate'];
		
			// 충전금액
		
			$sql = "select sum(agree_amount) as charge_money
							from ".$this->db_qz."charge_log 
								where date(regdate)>='".$array['reg_date']."' and date(regdate)<='".$array['objdate']."' and state=1 
									and member_sn in (select sn from ".$this->db_qz."member 
										where  logo='".$this->logo."' and recommend_sn=".$partner_sn.") ";								
			$rsi = $this->db->exeSql($sql);			
			
			if( count((array)$rsi) > 0 )
			{
				$array['charge_money'] = $rsi[0]["charge_money"];
			}
		
			// 환전금액
			$sql = "select sum(agree_amount) as exchange_money
							from ".$this->db_qz."exchange_log 
								where date(regdate)>='".$array['reg_date']."' and date(regdate)<='".$array['objdate']."' and state=1 
									and member_sn in (select sn from ".$this->db_qz."member 
										where  logo='".$this->logo."' and recommend_sn='".$partner_sn."') ";
			$rsi = $this->db->exeSql($sql);												
			if( count((array)$rsi) > 0 )
			{
				$array['exchange_money'] = $rsi[0]["exchange_money"];
			}
			
			$sql = "select rec_rate,rec_bankname,rec_banknum,rec_bankusername 
							from ".$this->db_qz."recommend 
								where logo='".$this->logo."' and  idx=".$partner_sn;
								
			$rsi = $this->db->exeSql($sql);										
			if( count((array)$rsi) > 0 )
			{
				$array['rate'] 				= $rsi[0]["rec_rate"];
				$array['bank_name'] 		= $rsi[0]["rec_bankname"];
				$array['bank_num'] 			= $rsi[0]["rec_banknum"];
				$array['bank_username'] = $rsi[0]["rec_bankusername"];
			}	
		}
		
		return $array;
	}
	
	//▶ 정산 데이터 목록 
	function getAccounting($where='') 
	{
		$sql = "select a.idx,a.rec_idx,date(a.start_date) as start_date,date(a.end_date) as end_date,
				a.exchange_money,a.charge_money,a.rate,a.opt_money,a.reg_date,
				a.bank_name,a.bank_num,a.bank_username,b.rec_id
				from ".$this->db_qz."recommend_account a,".$this->db_qz."recommend b 
					where a.rec_idx=b.idx and a.logo='".$this->logo."' and a.status=0".$where;
		
		return $this->db->exeSql($sql);
	}
	
	//▶ 필드 데이터
	function getPartnerIdList($logo='', $p_type = 0)
	{
		//-> 2014.12.18 곰탱수정
		if ( strlen($logo) > 0 ) $addQry = "logo='".$logo."' and ";

		$sql = "";
		if($p_type == 1) {
			$sql = "select * from ".$this->db_qz."recommend where ".$addQry." parent_sn = 0 and rec_lev = 9 order by rec_id asc";
		} else if ($p_type == 2) {
			$sql = "select * from ".$this->db_qz."recommend where ".$addQry." parent_sn = 0 and rec_lev = 1 order by rec_id asc";
		}
		
		return $this->db->exeSql($sql);
	}

	//▶ 필드 데이터
	function getPartnerSnList()
	{
		$sql = "select Idx from ".$this->db_qz."recommend 
						where logo='".$this->logo."' and parent_sn = 0 order by Idx";
		return $this->db->exeSql($sql);
	}
	
	//▶ 필드 데이터
	function getPartnerRow($sn, $addWhere='', $field="*")
	{
		$where = "Idx=".$sn;
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		return $this->getRow($field, $this->db_qz.'recommend', $where);
	}
	
	//▶ 필드 데이터
	function getPartnerField($sn, $field, $addWhere='')
	{
		//$where = "Idx=".$sn." and logo='".$this->logo."'";
		$where = "Idx=".$sn;
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		$rs = $this->getRow($field, $this->db_qz.'recommend', $where);
		return $rs[$field];
	}
	
	//▶ 필드 데이터
	function getPartnerFieldById($uid, $field, $addWhere='')
	{
		$where = "rec_id='".$uid."' and logo='".$this->logo."'";
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		$rs = $this->getRow($field, $this->db_qz.'recommend', $where);
		return $rs[$field];
	}
	
	function modifyRecommend($id, $status)
	{
		$sql = "update ".$this->db_qz."recommend 
						set status='".$status."' where rec_id='".$id."'";
								
		return $this->db->exeSql($sql);
	}
	
	function delRecommend($id)
	{
		$sql = "delete from ".$this->db_qz."recommend 
							where rec_id='".$id."'";
							
		return $this->db->exeSql($sql);
	}
	
	function getRecommendTotal($where)
	{
		$sql = "select count(*) as cnt
						from ".$this->db_qz."recommend 
							where status!=2 and parent_sn=0 ".$where;
							
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	function getRecommendList($where, $page, $page_size)
	{
		$sql = "select * from ".$this->db_qz."recommend 
						where status != 2 and parent_sn=0 ".$where." 
						order by reg_date limit ".$page.",".$page_size;
		$rs = $this->db->exeSql($sql);

		for($i=0; $i<count((array)$rs); ++$i)
		{
			$recommend_sn = $rs[$i]['Idx'];
			
			//회원수
			$sql = "select count(*) as cnt from ".$this->db_qz."member where recommend_sn=".$recommend_sn;
			$rsi = $this->db->exeSql($sql);
			$rs[$i]['member_count'] = $rsi[0]['cnt'];
			
			//매장입금금액
			$sql = "select count(distinct(member_sn)) as cnt, sum(agree_amount) as total_charge
							from ".$this->db_qz."charge_log 
							where member_sn in (select sn from ".$this->db_qz."member where recommend_sn=".$recommend_sn.") and agree_amount > 0";
				
			$rsi = $this->db->exeSql($sql);
			$rs[$i]['charge_count'] = $rsi[0]['cnt'];
			$rs[$i]['charge_sum'] = $rsi[0]['total_charge'];
			
			//회원입금금액	
			// $sql = "select count(distinct(member_sn)) as cnt, sum(agree_amount) as total_charge
			// 				from ".$this->db_qz."charge_log 
			// 				where member_sn in (select sn from ".$this->db_qz."member where recommend_sn in (select sn from ".$this->db_qz."member where recommend_sn=".$recommend_sn.")) and agree_amount > 0";
			
			// $rsi = $this->db->exeSql($sql);
			// $rs[$i]['charge_count'] = $rs[$i]['charge_count'] + $rsi[0]['cnt'];
			// $rs[$i]['charge_sum'] = $rs[$i]['charge_sum'] + $rsi[0]['total_charge'];
			
			//출금횟수,금액
			$sql = "select count(distinct(member_sn)) as cnt, sum(agree_amount) as total_exchange
						from ".$this->db_qz."exchange_log 
						where member_sn in (select sn from ".$this->db_qz."member where recommend_sn=".$recommend_sn.") and agree_amount > 0";
			$rsi = $this->db->exeSql($sql);
			
			$rs[$i]['exchange_count'] = $rsi[0]['cnt'];
			$rs[$i]['exchange_sum'] = $rsi[0]['total_exchange'];
			
			//회원출금횟수,금액
			// $sql = "select count(distinct(member_sn)) as cnt, sum(agree_amount) as total_exchange
			// 			from ".$this->db_qz."exchange_log 
			// 			where member_sn in (select sn from ".$this->db_qz."member where recommend_sn in (select sn from ".$this->db_qz."member where recommend_sn=".$recommend_sn.")) and agree_amount > 0";
			// $rsi = $this->db->exeSql($sql);
			
			// $rs[$i]['exchange_count'] = $rs[$i]['exchange_count'] + $rsi[0]['cnt'];
			// $rs[$i]['exchange_sum'] = $rs[$i]['exchange_sum'] + $rsi[0]['total_exchange'];

			//배팅금액, 당첨금액
/*
			$sql = "select sum(betting_money) as total_betting, sum(result_money) as total_result
						from ".$this->db_qz."game_cart
						where member_sn in (select sn from ".$this->db_qz."member where recommend_sn=".$recommend_sn.")";
*/
			//-> 위에 쿼리 튜닝
			$sql = "select sum(betting_money) as total_betting, sum(result_money) as total_result 
							from ".$this->db_qz."game_cart a, ".$this->db_qz."member b 
							where a.member_sn = b.sn and b.recommend_sn = ".$recommend_sn;
			//$rsi = $this->db->exeSql($sql);
			
			$rs[$i]['betting_sum'] = $rsi[0]['total_betting'];
			$rs[$i]['result_sum'] = $rsi[0]['total_result'];		
			
			$rsi = $this->getPartnerInMemberList($recommend_sn, "");
			$rs[$i]['item'] = $rsi;
		}
		return $rs;
	}

	//-> 모든 부본사
	function getTopRecommendList() {
		$sql = "select * from ".$this->db_qz."recommend where status = 1 and parent_sn = 0 and rec_lev = 9";			
		$rs = $this->db->exeSql($sql);
		return $rs;
	}

	function getPartnerList($parentId, $beginDate, $endDate)
	{
		$field = 'rec_id';
		$sql = "select * from ".$this->db_qz."recommend where status != 2 and parent_sn=0 and rec_parent_id='".$parentId."'";
		if($parentId == null || $parentId == '')
		{
			$field = 'rec_parent_id';
			$sql = "select * from ".$this->db_qz."recommend where status != 2 and parent_sn=0 and rec_lev=9";
		}

		$rs = $this->db->exeSql($sql);

		for($i=0; $i<count((array)$rs); ++$i)
		{
			$recommend_id = $rs[$i]['rec_id'];
			$recommend_sn = $rs[$i]['Idx'];

			//매장수
			$sql = "select count(*) as cnt from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where {$field} = '".$recommend_id."')";
			$rsi = $this->db->exeSql($sql);
			$rs[$i]['member_count'] = $rsi[0]['cnt'];

			//매장입금횟수,금액
			$sql = "select count(distinct(member_sn)) as cnt, sum(agree_amount) as total_charge
								from ".$this->db_qz."charge_log 
								where member_sn in (select sn from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where {$field} = '".$recommend_id."')) and agree_amount > 0";

			if($beginDate != '')
			{
				$sql.=" and operdate >= '".$beginDate." 00:00:00' ";
			}

			if($endDate != '')
			{
				$sql.=" and operdate <= '".$endDate." 23:59:59' ";
			}

			$rsi = $this->db->exeSql($sql);
			$rs[$i]['charge_count'] = $rsi[0]['cnt'];
			$rs[$i]['charge_sum'] = $rsi[0]['total_charge'];

			//매장출금횟수,금액
			$sql = "select count(distinct(member_sn)) as cnt, sum(agree_amount) as total_exchange
							from ".$this->db_qz."exchange_log 
							where member_sn in (select sn from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where {$field} = '".$recommend_id."')) and agree_amount > 0";

			if($beginDate != '')
			{
				$sql.=" and operdate >= '".$beginDate." 00:00:00' ";
			}

			if($endDate != '')
			{
				$sql.=" and operdate <= '".$endDate." 23:59:59' ";
			}

			$rsi = $this->db->exeSql($sql);
			$rs[$i]['exchange_count'] = $rsi[0]['cnt'];
			$rs[$i]['exchange_sum'] = $rsi[0]['total_exchange'];

			//배팅금액, 당첨금액 스포츠
			$sql = "select sum(betting_money) as total_betting, sum(result_money) as total_result
							from ".$this->db_qz."game_cart
							where member_sn in (select sn from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where {$field} = '".$recommend_id."')) and (last_special_code < 3 or last_special_code=50)";

			if($beginDate != '')
			{
				$sql.=" and bet_date >= '".$beginDate." 00:00:00' ";
			}

			if($endDate != '')
			{
				$sql.=" and bet_date <= '".$endDate." 23:59:59' ";
			}

			$rsi = $this->db->exeSql($sql);
			$rs[$i]['total_betting_sport'] = $rsi[0]['total_betting'];

			//배팅금액, 당첨금액 미니게임
			$sql = "select sum(betting_money) as total_betting, sum(result_money) as total_result
							from ".$this->db_qz."game_cart
							where member_sn in (select sn from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where {$field} = '".$recommend_id."')) and (last_special_code > 3 and last_special_code!=50)";

			if($beginDate != '')
			{
				$sql.=" and bet_date >= '".$beginDate." 00:00:00' ";
			}

			if($endDate != '')
			{
				$sql.=" and bet_date <= '".$endDate." 23:59:59' ";
			}

			$rsi = $this->db->exeSql($sql);
			$rs[$i]['total_betting_mini'] = $rsi[0]['total_betting'];

			// 스낙 + 미롤
			$sql = "select sum(betting_to_lose) as s_lose, sum(betting_to_win_mgame + betting_to_lose_mgame) as m_rolling from tb_recommend_tex ";
			if($parentId == null || $parentId == '')
			{
				$sql .=	" where rec_id_top = '".$recommend_id."'";
			} else {
				$sql .=	" where rec_id = '".$recommend_id."'";
			}

			if($beginDate != '')
			{
				$sql.=" and updatedate >= '".$beginDate." 00:00:00' ";
			}

			if($endDate != '')
			{
				$sql.=" and updatedate <= '".$endDate." 23:59:59' ";
			}

			$rsi = $this->db->exeSql($sql);

			$rs[$i]['total_s_lose'] = $rsi[0]['s_lose'];
			$rs[$i]['total_m_rolling'] = $rsi[0]['m_rolling'];

			if($parentId == null || $parentId == '')
			{
				$rsi = $this->getPartnerList($recommend_id,  $beginDate, $endDate);
				$rs[$i]['item'] = $rsi;
			}
		}
		return $rs;
	}

	function getPartnerList3($parentId, $beginDate, $endDate)
	{
		$field = 'rec_parent_id';
		$sql = "select * from ".$this->db_qz."recommend where status != 2 and parent_sn=0 and rec_lev=9 and rec_id='{$parentId}'";

		$rs = $this->db->exeSql($sql);

		for($i=0; $i<count((array)$rs); ++$i)
		{
			$recommend_id = $rs[$i]['rec_id'];
			$recommend_sn = $rs[$i]['Idx'];

			//매장수
			$sql = "select count(*) as cnt from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where {$field} = '".$recommend_id."')";
			$rsi = $this->db->exeSql($sql);
			$rs[$i]['member_count'] = $rsi[0]['cnt'];

			//매장입금횟수,금액
			$sql = "select count(distinct(member_sn)) as cnt, sum(agree_amount) as total_charge
								from ".$this->db_qz."charge_log 
								where member_sn in (select sn from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where {$field} = '".$recommend_id."')) and agree_amount > 0";

			if($beginDate != '')
			{
				$sql.=" and operdate >= '".$beginDate." 00:00:00' ";
			}

			if($endDate != '')
			{
				$sql.=" and operdate <= '".$endDate." 23:59:59' ";
			}

			$rsi = $this->db->exeSql($sql);
			$rs[$i]['charge_count'] = $rsi[0]['cnt'];
			$rs[$i]['charge_sum'] = $rsi[0]['total_charge'];

			//매장출금횟수,금액
			$sql = "select count(distinct(member_sn)) as cnt, sum(agree_amount) as total_exchange
							from ".$this->db_qz."exchange_log 
							where member_sn in (select sn from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where {$field} = '".$recommend_id."')) and agree_amount > 0";

			if($beginDate != '')
			{
				$sql.=" and operdate >= '".$beginDate." 00:00:00' ";
			}

			if($endDate != '')
			{
				$sql.=" and operdate <= '".$endDate." 23:59:59' ";
			}

			$rsi = $this->db->exeSql($sql);
			$rs[$i]['exchange_count'] = $rsi[0]['cnt'];
			$rs[$i]['exchange_sum'] = $rsi[0]['total_exchange'];

			//배팅금액, 당첨금액 스포츠
			$sql = "select sum(betting_money) as total_betting, sum(result_money) as total_result
							from ".$this->db_qz."game_cart
							where member_sn in (select sn from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where {$field} = '".$recommend_id."')) and (last_special_code < 3 or last_special_code=50)";

			if($beginDate != '')
			{
				$sql.=" and bet_date >= '".$beginDate." 00:00:00' ";
			}

			if($endDate != '')
			{
				$sql.=" and bet_date <= '".$endDate." 23:59:59' ";
			}

			$rsi = $this->db->exeSql($sql);
			$rs[$i]['total_betting_sport'] = $rsi[0]['total_betting'];

			//배팅금액, 당첨금액 미니게임
			$sql = "select sum(betting_money) as total_betting, sum(result_money) as total_result
							from ".$this->db_qz."game_cart
							where member_sn in (select sn from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where {$field} = '".$recommend_id."')) and (last_special_code > 3 and last_special_code!=50)";

			if($beginDate != '')
			{
				$sql.=" and bet_date >= '".$beginDate." 00:00:00' ";
			}

			if($endDate != '')
			{
				$sql.=" and bet_date <= '".$endDate." 23:59:59' ";
			}

			$rsi = $this->db->exeSql($sql);
			$rs[$i]['total_betting_mini'] = $rsi[0]['total_betting'];

			// 스낙 + 미롤
			$sql = "select sum(betting_to_lose) as s_lose, sum(betting_to_win_mgame + betting_to_lose_mgame) as m_rolling from tb_recommend_tex ";
			if($parentId == null || $parentId == '')
			{
				$sql .=	" where rec_id_top = '".$recommend_id."'";
			} else {
				$sql .=	" where rec_id = '".$recommend_id."'";
			}

			if($beginDate != '')
			{
				$sql.=" and updatedate >= '".$beginDate." 00:00:00' ";
			}

			if($endDate != '')
			{
				$sql.=" and updatedate <= '".$endDate." 23:59:59' ";
			}

			$rsi = $this->db->exeSql($sql);

			$rs[$i]['total_s_lose'] = $rsi[0]['s_lose'];
			$rs[$i]['total_m_rolling'] = $rsi[0]['m_rolling'];

			$rsi = $this->getPartnerList($recommend_id,  $beginDate, $endDate);
			$rs[$i]['item'] = $rsi;
		}
		return $rs;
	}

	function getPartnerList2($rec_id, $beginDate, $endDate)
	{
		$field = 'rec_id';
		$sql = "select * from ".$this->db_qz."recommend where status != 2 and parent_sn=0 and rec_id='".$rec_id."'";

		$rs = $this->db->exeSql($sql);

		for($i=0; $i<count((array)$rs); ++$i)
		{
			$recommend_id = $rs[$i]['rec_id'];
			$recommend_sn = $rs[$i]['Idx'];

			//매장수
			$sql = "select count(*) as cnt from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where {$field} = '".$recommend_id."')";
			$rsi = $this->db->exeSql($sql);
			$rs[$i]['member_count'] = $rsi[0]['cnt'];

			//매장입금횟수,금액
			$sql = "select count(distinct(member_sn)) as cnt, sum(agree_amount) as total_charge
								from ".$this->db_qz."charge_log 
								where member_sn in (select sn from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where {$field} = '".$recommend_id."')) and agree_amount > 0";

			if($beginDate != '')
			{
				$sql.=" and operdate >= '".$beginDate." 00:00:00' ";
			}

			if($endDate != '')
			{
				$sql.=" and operdate <= '".$endDate." 23:59:59' ";
			}

			$rsi = $this->db->exeSql($sql);
			$rs[$i]['charge_count'] = $rsi[0]['cnt'];
			$rs[$i]['charge_sum'] = $rsi[0]['total_charge'];

			//매장출금횟수,금액
			$sql = "select count(distinct(member_sn)) as cnt, sum(agree_amount) as total_exchange
							from ".$this->db_qz."exchange_log 
							where member_sn in (select sn from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where {$field} = '".$recommend_id."')) and agree_amount > 0";

			if($beginDate != '')
			{
				$sql.=" and operdate >= '".$beginDate." 00:00:00' ";
			}

			if($endDate != '')
			{
				$sql.=" and operdate <= '".$endDate." 23:59:59' ";
			}

			$rsi = $this->db->exeSql($sql);
			$rs[$i]['exchange_count'] = $rsi[0]['cnt'];
			$rs[$i]['exchange_sum'] = $rsi[0]['total_exchange'];

			//배팅금액, 당첨금액 스포츠
			$sql = "select sum(betting_money) as total_betting, sum(result_money) as total_result
							from ".$this->db_qz."game_cart
							where member_sn in (select sn from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where {$field} = '".$recommend_id."')) and (last_special_code < 3 or last_special_code=50)";

			if($beginDate != '')
			{
				$sql.=" and bet_date >= '".$beginDate." 00:00:00' ";
			}

			if($endDate != '')
			{
				$sql.=" and bet_date <= '".$endDate." 23:59:59' ";
			}

			$rsi = $this->db->exeSql($sql);
			$rs[$i]['total_betting_sport'] = $rsi[0]['total_betting'];

			//배팅금액, 당첨금액 미니게임
			$sql = "select sum(betting_money) as total_betting, sum(result_money) as total_result
							from ".$this->db_qz."game_cart
							where member_sn in (select sn from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where {$field} = '".$recommend_id."')) and (last_special_code > 3 and last_special_code!=50)";

			if($beginDate != '')
			{
				$sql.=" and bet_date >= '".$beginDate." 00:00:00' ";
			}

			if($endDate != '')
			{
				$sql.=" and bet_date <= '".$endDate." 23:59:59' ";
			}

			$rsi = $this->db->exeSql($sql);
			$rs[$i]['total_betting_mini'] = $rsi[0]['total_betting'];

			// 스낙 + 미롤
			$sql = "select sum(betting_to_lose) as s_lose, sum(betting_to_win_mgame + betting_to_lose_mgame) as m_rolling from tb_recommend_tex ";
			if($top_rec_id == null || $top_rec_id == '')
			{
				$sql .=	" where rec_id_top = '".$recommend_id."'";
			} else {
				$sql .=	" where rec_id = '".$recommend_id."'";
			}

			if($beginDate != '')
			{
				$sql.=" and updatedate >= '".$beginDate." 00:00:00' ";
			}

			if($endDate != '')
			{
				$sql.=" and updatedate <= '".$endDate." 23:59:59' ";
			}

			$rsi = $this->db->exeSql($sql);

			$rs[$i]['total_s_lose'] = $rsi[0]['s_lose'];
			$rs[$i]['total_m_rolling'] = $rsi[0]['m_rolling'];
		}
		return $rs;
	}

	//-> 부본사 리스트
	function getRecommendListTop($where, $page, $page_size)
	{
		$sql = "select * from ".$this->db_qz."recommend where status != 2 and parent_sn=0 ".$where." order by reg_date limit ".$page.",".$page_size;
		$rs = $this->db->exeSql($sql);

		for($i=0; $i<count((array)$rs); ++$i)
		{
			$recommend_id = $rs[$i]['rec_id'];
			$recommend_sn = $rs[$i]['Idx'];
			
			//매장수
			$sql = "select count(*) as cnt from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where rec_parent_id = '".$recommend_id."')";
			$rsi = $this->db->exeSql($sql);
			$rs[$i]['member_count'] = $rsi[0]['cnt'];
			
			//회원수
			// $sql = "select count(*) as cnt from ".$this->db_qz."member where recommend_sn IN ( SELECT sn from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where rec_parent_id = '".$recommend_id."'))";
			// $rsi = $this->db->exeSql($sql);
			// $rs[$i]['member_count'] = $rs[$i]['member_count'] + $rsi[0]['cnt'];

			//매장입금횟수,금액
			$sql = "select count(distinct(member_sn)) as cnt, sum(agree_amount) as total_charge
							from ".$this->db_qz."charge_log 
							where member_sn in (select sn from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where rec_parent_id = '".$recommend_id."')) and agree_amount > 0";

							
			$rsi = $this->db->exeSql($sql);
			$rs[$i]['charge_count'] = $rsi[0]['cnt'];
			$rs[$i]['charge_sum'] = $rsi[0]['total_charge'];
			
			//회원입금횟수,금액 (+매장)
			// $sql = "select count(distinct(member_sn)) as cnt, sum(agree_amount) as total_charge
			// 				from ".$this->db_qz."charge_log 
			// 				where member_sn in (select sn from ".$this->db_qz."member where recommend_sn IN ( SELECT sn from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where rec_parent_id = '".$recommend_id."'))) and agree_amount > 0";

			// $rsi = $this->db->exeSql($sql);
			// $rs[$i]['charge_count'] = $rs[$i]['charge_count'] + $rsi[0]['cnt'];
			// $rs[$i]['charge_sum'] = $rs[$i]['charge_sum'] + $rsi[0]['total_charge'];

			//매장출금횟수,금액
			$sql = "select count(distinct(member_sn)) as cnt, sum(agree_amount) as total_exchange
						from ".$this->db_qz."exchange_log 
						where member_sn in (select sn from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where rec_parent_id = '".$recommend_id."')) and agree_amount > 0";
			$rsi = $this->db->exeSql($sql);
			
			$rs[$i]['exchange_count'] = $rsi[0]['cnt'];
			$rs[$i]['exchange_sum'] = $rsi[0]['total_exchange'];

			//회원출금횟수,금액 (+매장)
			// $sql = "select count(distinct(member_sn)) as cnt, sum(agree_amount) as total_exchange
			// 			from ".$this->db_qz."exchange_log 
			// 			where member_sn in (select sn from ".$this->db_qz."member where recommend_sn IN ( SELECT sn from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where rec_parent_id = '".$recommend_id."'))) and agree_amount > 0";
			
			// $rsi = $this->db->exeSql($sql);
			// $rs[$i]['exchange_count'] = $rs[$i]['exchange_count'] + $rsi[0]['cnt'];
			// $rs[$i]['exchange_sum'] = $rs[$i]['exchange_sum'] + $rsi[0]['total_exchange'];
/*			
			//배팅금액, 당첨금액
			$sql = "select sum(betting_money) as total_betting, sum(result_money) as total_result
						from ".$this->db_qz."game_cart
						where member_sn in (select sn from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where rec_parent_id = '".$recommend_id."'))";
*/
			//-> 위에 쿼리 튜닝
			$sql = "select sum(betting_money) as total_betting, sum(result_money) as total_result 
							from ".$this->db_qz."game_cart a, ".$this->db_qz."member b
							where a.member_sn = b.sn and b.recommend_sn IN (select sn from ".$this->db_qz."member where recommend_sn IN (select idx from tb_recommend where rec_parent_id = '".$recommend_id."'))";
			//$rsi = $this->db->exeSql($sql);
			
			$rs[$i]['betting_sum'] = $rsi[0]['total_betting'];
			$rs[$i]['result_sum'] = $rsi[0]['total_result'];		
		
			$rsi = $this->getPartnerInMemberListTop($recommend_id, "");
			$rs[$i]['item'] = $rsi;
		}
		return $rs;
	}

	function getRecommend_Lev2List($where, $page, $page_size)
	{
		$sql = "select * from ".$this->db_qz."recommend 
						where status != 2 and parent_sn=0 ".$where." 
						order by reg_date limit ".$page.",".$page_size;
					
		$rs = $this->db->exeSql($sql);

		for($i=0; $i<count((array)$rs); ++$i)
		{
			$recommend_sn = $rs[$i]['Idx'];
			
			//회원수
			$sql = "select count(*) as cnt from ".$this->db_qz."member where recommend_sn=".$recommend_sn;
			$rsi = $this->db->exeSql($sql);
			$rs[$i]['member_count'] = $rsi[0]['cnt'];
			
			//입금횟수,금액
			$sql = "select count(distinct(member_sn)) as cnt, sum(agree_amount) as total_charge
							from ".$this->db_qz."charge_log 
							where member_sn in (select sn from ".$this->db_qz."member where recommend_sn=".$recommend_sn.") and agree_amount > 0";
					
			$rsi = $this->db->exeSql($sql);
			$rs[$i]['charge_count'] = $rsi[0]['cnt'];
			$rs[$i]['charge_sum'] = $rsi[0]['total_charge'];
			
			//출금횟수,금액
			$sql = "select count(distinct(member_sn)) as cnt, sum(agree_amount) as total_exchange
						from ".$this->db_qz."exchange_log 
						where member_sn in (select sn from ".$this->db_qz."member where recommend_sn=".$recommend_sn.") and agree_amount > 0";
			$rsi = $this->db->exeSql($sql);
			
			$rs[$i]['exchange_count'] = $rsi[0]['cnt'];
			$rs[$i]['exchange_sum'] = $rsi[0]['total_exchange'];
			
			/*
			//배팅금액, 당첨금액
			$sql = "select sum(betting_money) as total_betting, sum(result_money) as total_result
						from ".$this->db_qz."game_cart
						where member_sn in (select sn from ".$this->db_qz."member where recommend_sn=".$recommend_sn.")";
			$rsi = $this->db->exeSql($sql);
			
			$rs[$i]['betting_sum'] = $rsi[0]['total_betting'];
			$rs[$i]['result_sum'] = $rsi[0]['total_result'];
			*/
			
			
			//$rsi = $this->getPartnerInMemberList($recommend_sn, "");
			$rs[$i]['item'] = $rsi;
		}
		return $rs;
	}
	
	function modifyRecommendjoin($idx)
	{
		$sql = "update ".$this->db_qz."recommend 
							set status=1 where Idx=".$idx."";
								
		return $this->db->exeSql($sql);
	}

	function modifyRecommendRate($idx, $sport_rate, $mini_rate)
	{
		$sql = "update ".$this->db_qz."recommend 
							set rec_rate_sport={$sport_rate}, rec_rate_minigame={$mini_rate}  where Idx=".$idx."";

		return $this->db->exeSql($sql);
	}

	
	function delRecommendjoinList($idx)
	{
		$sql = "delete from ".$this->db_qz."recommend 
							where idx in(".$idx.")";
							
		return $this->db->exeSql($sql);
	}
	
	function delRecommendjoin($idx)
	{
		$sql = "delete from ".$this->db_qz."recommend 
							where idx=".$idx."";
							
		return $this->db->exeSql($sql);
	}

	function getRecommendjoinTotal($where)
	{
		$sql = "select count(*) as cnt
						from ".$this->db_qz."recommend 
							where logo='".$this->logo."' and status=2".$where;
							
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	function getRecommendjoinList($where, $page, $page_size)
	{
		$sql = "select * from ".$this->db_qz."recommend 
							where logo='".$this->logo."' and status=2 ".$where." order by reg_date desc limit ".$page.",".$page_size;
							
		$rs = $this->db->exeSql($sql);
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$beginIndex = 0;
			$length = 15;
			$string = $rs[i]['rec_email'];
			
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
    	
    	$rs[$i]['rec_email'] = $string;
		}	
			
		return $rs;
	}
	
	function delAccounting($idx)
	{
		$sql="delete from ".$this->db_qz."recommend_account 
						where logo='".$this->logo."' and  idx=".$idx;
		return $this->db->exeSql($sql);				
	}
	
	
	function modifyAccounting($idx)
	{
		$sql = "update ".$this->db_qz."recommend_account 
						set opt_date=now(), status=1 
						where logo='".$this->logo."' and  idx=".$idx;
		
		return $this->db->exeSql($sql);			
	}
	
	function getAccountingfinTotal($where)
	{		
		$sql = "select count(*) as cnt
							from ".$this->db_qz."recommend_account a,".$this->db_qz."recommend b 
									where a.rec_idx=b.idx and a.logo='".$this->logo."'".$where;
									
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];							
	}
	
	function getAccountingfinList($where='', $page, $page_size)
	{
		$sql = "select a.idx,a.rec_idx,date(a.start_date) as start_date,date(a.end_date) as end_date,a.exchange_money,
				a.charge_money,a.rate,a.opt_money,a.reg_date,a.bank_name,a.status,a.bank_num,a.bank_username,b.rec_id
				from ".$this->db_qz."recommend_account a,".$this->db_qz."recommend b 
								where a.rec_idx=b.idx and a.logo='".$this->logo."' and a.status=1 ".$where."limit ".$page.",".$page_size."";
								
		return $this->db->exeSql($sql);
	}
	
	function modifyMemberDetails($where, $memo, $rec_lev, $rec_name, $rec_bankname, $rec_bankusername, $rec_banknum, $rec_email, $rec_phone, $tex_type, $tex_rate_sport, $tex_rate_minigame, $rec_one_folder_flag, $idx, $tex_get_member_id, $rec_parent_id)
	{
		$sql = "update ".$this->db_qz."recommend 
						set ".$where." memo='".$memo."', rec_name='".$rec_name."',rec_bankname='".$rec_bankname."',rec_bankusername='".$rec_bankusername."',rec_banknum='".$rec_banknum."',
						rec_email='".$rec_email."',rec_phone='".$rec_phone."',rec_tex_type='".$tex_type."',rec_rate_sport='".$tex_rate_sport."',rec_rate_minigame='".$tex_rate_minigame."',rec_one_folder_flag='".$rec_one_folder_flag."' ,tex_get_member_id='".$tex_get_member_id."',rec_parent_id='".$rec_parent_id."' where idx='".$idx."'";
								
		return $this->db->exeSql($sql);
	}

    function modifyMemberDetails2($where, $memo, $rec_lev, $rec_id, $rec_name, $rec_bankname, $rec_bankusername, $rec_banknum, $rec_email, $rec_phone, $tex_type, $tex_rate_sport, $tex_rate_minigame, $rec_one_folder_flag, $idx, $tex_get_member_id, $rec_parent_id)
    {
        $sql = "update ".$this->db_qz."recommend 
						set ".$where." memo='".$memo."', rec_id='".$rec_id."', rec_name='".$rec_name."',rec_bankname='".$rec_bankname."',rec_bankusername='".$rec_bankusername."',rec_banknum='".$rec_banknum."',
						rec_email='".$rec_email."',rec_phone='".$rec_phone."',rec_tex_type='".$tex_type."',rec_rate_sport='".$tex_rate_sport."',rec_rate_minigame='".$tex_rate_minigame."',rec_one_folder_flag='".$rec_one_folder_flag."' ,tex_get_member_id='".$tex_get_member_id."',rec_parent_id='".$rec_parent_id."' where idx='".$idx."'";

        return $this->db->exeSql($sql);
    }

	//-> 부본사 정보 업데이트 (하위 총판들 부본사 셋팅과 같게 업데이트. (정산방식, 단폴포함여부, 정산비율))
	function modifyPartnerAllChild($top_rec_id, $tex_type, $tex_rate_sport, $tex_rate_minigame, $rec_one_folder_flag) {
		$sql = "update tb_recommend set rec_tex_type='{$tex_type}', rec_one_folder_flag='{$rec_one_folder_flag}' where rec_lev = 1 and rec_parent_id = '{$top_rec_id}'";
		$this->db->exeSql($sql);

		$sql = "update tb_recommend set rec_rate_sport='{$tex_rate_sport}' where rec_rate_sport > '{$tex_rate_sport}' and rec_lev = 1 and rec_parent_id = '{$top_rec_id}'";
		$this->db->exeSql($sql);

		$sql = "update tb_recommend set rec_rate_minigame='{$tex_rate_minigame}' where rec_rate_minigame > '{$tex_rate_minigame}' and rec_lev = 1 and rec_parent_id = '{$top_rec_id}'";
		$this->db->exeSql($sql);
	}

	function getMemberDetails($recommendSn)
	{
		$sql = "select * from ".$this->db_qz."recommend where idx=".$recommendSn;		
		$rs = $this->db->exeSql($sql); 
		
		$sql = "select count(*) as member_count
							from ".$this->db_qz."member 
								where recommend_sn=".$recommendSn;
		$rsi = $this->db->exeSql($sql); 
		
		$rs[0]['member_count'] = $rsi[0]['member_count'];
		
		
		//입금횟수,금액
		$sql = "select count(*) as cnt, sum(agree_amount) as total_charge
					from ".$this->db_qz."charge_log 
					where member_sn in (select sn from ".$this->db_qz."member where recommend_sn=".$recommendSn.")";
		$rsi = $this->db->exeSql($sql);
		$rs[0]['charge_count'] = $rsi[0]['cnt'];
		$rs[0]['charge_sum'] = $rsi[0]['total_charge'];
			
			//출금횟수,금액
		$sql = "select count(*) as cnt, sum(agree_amount) as total_exchange
					from ".$this->db_qz."exchange_log 
					where member_sn in (select sn from ".$this->db_qz."member where recommend_sn=".$recommendSn.")";
		$rsi = $this->db->exeSql($sql);
		$rs[0]['exchange_count'] = $rsi[0]['cnt'];
		$rs[0]['exchange_sum'] = $rsi[0]['total_exchange'];
		
		/*
		//충전회원수, 금액
		
		//환전금액
		$rs[0]['charge_member_sum'] = $rsi[0]["charge_member_sum"];
		
		$sql = "select sum(a.resamount) as summoney,a.kubun 
							from ".$this->db_qz."money a,".$this->db_qz."member b 
								where a.result=1 and a.mem_idx=b.sn and a.logo='".$this->logo."' and b.recommend_sn=".$recommendSn." group by a.kubun";	
		$rsi = $this->db->exeSql($sql);
		
		
		$rs[0]['sum_charge_money'] = 0;
		$rs[0]['sum_exchange_money'] = 0;
		
		if($rsi[0]["kubun"]==0) {$rs[0]['sum_charge_money'] = $rsi[0]["summoney"];}
		else					{$rs[0]['sum_exchange_money'] = $rsi[0]["conmoney"];}							
		*/
			
		return $rs[0];
	}
	
	function addRecommend($sn, $recommendSn=0)
	{
		$configModel  = Lemon_Instance::getObject("ConfigModel",true);
		
		$joinRecommendRate = $configModel->getLevelConfigField(1, 'lev_join_recommend_mileage_rate');
		$rates = explode(":",$joinRecommendRate);

		//-> 추천인(1대가 될)이 있다면 추천인에 1대 추천인을 가져와 가입 유저에 2대 추천인에 등록한다.
		if ( $recommendSn > 0 ) {			
			$sql = "select recommend_sn from tb_join_recommend where member_sn = '{$recommendSn}'";
			$rs = $this->db->exeSql($sql);
			$recommend2Sn = $rs[0]["recommend_sn"]+0;
		} else {
			$recommend2Sn = 0;
		}

		$sql = "insert into ".$this->db_qz."join_recommend(member_sn,recommend_sn,recommend2_sn,logo,step1_rate,step2_rate,step3_rate)
						values(".$sn.",".$recommendSn.",".$recommend2Sn.",'".$this->logo."',".$rates[0].",".$rates[1].",".$rates[2].")";
		return $this->db->exeSql($sql);
	}
	
	//▶ 추천인 마일리지 배당
	function joinRecommendRate($memberSn, $step=1)
	{
		$memberModel  = Lemon_Instance::getObject("MemberModel",true);
		$configModel  = Lemon_Instance::getObject("ConfigModel",true);
		
		$rate = 0;
		$sql = "select recommend_sn from ".$this->db_qz."join_recommend where member_sn=".$memberSn;
		$rs = $this->db->exeSql($sql);
		$recommendSn = $rs[0]['recommend_sn'];
		
		if($recommendSn!=''&&$recommendSn!=0)
		{
			$recommendLevel = $memberModel->getMemberField($recommendSn,'mem_lev');
			$recommend_status = $memberModel->getMemberField($recommendSn,'mem_status');
			
			$rs = $configModel->getLevelConfigField($recommendLevel, 'lev_join_recommend_mileage_rate');
		
			$array = explode(':', $rs);
			if($step==1) $rate=$array[0];
			else if($step==2) $rate=$array[1];
			else if($step==3) $rate=$array[2];
		}
		
		return array("recommend_sn" => $recommendSn, "rate" => $rate, "recommend_status" => $recommend_status);
	}
}
?>    