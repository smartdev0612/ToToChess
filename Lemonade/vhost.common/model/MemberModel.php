<?php
class MemberModel extends Lemon_Model
{
	//-> 페이지로딩시간 저장(동접체크)
	function LoadingTimeSave($sn) {
		$hDate = date("Y-m-d H:i:s");
		$sql = "update tb_member set page_load_date = '{$hDate}' where sn = '{$sn}'";
		return $this->db->exeSql($sql);
	}

	//▶ 필드 데이터
	function getMemberField($sn, $field, $addWhere='')
	{
		$where = "sn=".$sn;
		
		if($addWhere!='') {
			$where .=' and '.$addWhere;
		}
		
		$rs = $this->getRow($field, $this->db_qz.'member', $where);
		
		return $rs[$field];
	}
	
	//▶ 필드 데이터
	function getMemberRow($sn, $field='*', $addWhere='')
	{
		$where = "sn=".$sn;
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		return $this->getRow($field, $this->db_qz.'member', $where);
	}
	
	//▶ 필드 데이터's
	function getMemberRows($field, $addWhere='')
	{
		$where = "1=1";
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		return $this->getRows($field, $this->db_qz.'member', $where);
	}
	
	//▶ 필드 데이터
	function getMemberRowById($uid, $field, $addWhere='')
	{
		$where = "uid='".$uid."'";
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		$rs = $this->getRow($field, $this->db_qz.'member', $where);
		return $rs[$field];
	}
	
	//▶ 필드 데이터
	function getMemberRowByNick($nick, $field, $addWhere='')
	{
		$where = "nick='".$nick."'";
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		$rs = $this->getRow($field, $this->db_qz.'member', $where);
		
		return $rs[$field];
	}
	
	//▶ 필드 데이터
	function getMemberRowByBankOwner($bankOwner, $field, $addWhere='')
	{
		$where = "bank_member='".$bankOwner."' and logo='".$this->logo."'";
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		$rs = $this->getRow($field, $this->db_qz.'member', $where);
		return $rs[$field];
	}
	
	//▶ 정보 by ID
	function getById($id)
	{
		return $this->getRow('*', $this->db_qz.'member', "uid='".$id."'");
	}
	
	//▶ 정보 by Sn
	function getBySn($sn)
	{
		return $this->getRow('*', $this->db_qz.'member', "sn='".$sn."' and logo='".$this->logo."'");
	}
	
	//▶ 정보 by Name
	function getByName($name)
	{
		return $this->getRow('*', $this->db_qz.'member', "nick='".$name."'");
	}

	//▶ 정보 by phone_num
	function getByPhone_num($phone_num)
	{
		return $this->getRow('*', $this->db_qz.'member', "phone='".$phone_num);
	}
	
	function getSn($uid)
	{
		$rs = $this->getRow('sn', $this->db_qz.'member', "uid='".$uid."'");
		return $rs['sn'];
	}
	
	//▶ 총합
	function getTotal($where, $joinRecommendNick='', $logo='')
	{
		if($logo!='') $logo = " and a.logo='".$logo."'";
		if($joinRecommendNick!='')
		{
			$where.= " and a.sn in (select member_sn from ".$this->db_qz."join_recommend where recommend_sn in (select sn from ".$this->db_qz."member where nick like('%".$joinRecommendNick."%')))";
		}
		
		$sql = "select count(*) as cnt from ".$this->db_qz."member a where 1=1 and a.is_store=0 ".$logo.$where;
		$rs = $this->db->exeSql($sql);
		
		return $rs[0]['cnt'];
	}
	
	//▶ 회원여부
	function isMember($id)
	{
		$sql = "select count(*) as cnt from ".$this->db_qz."member 
						where uid='".$id."'";
					
		$rs = $this->db->exeSql($sql);
		
		return ($rs[0]['cnt']>0);
	}
	
	//▶ 회원목록
	function getList($where, $page, $page_size, $orderby='', $joinRecommendNick='', $logo='')
	{
		if($logo!='') $logo = " and a.logo='".$logo."'";
		
		if($joinRecommendNick!='')
		{
			$where.= " and a.sn in (select member_sn from ".$this->db_qz."join_recommend where recommend_sn in (select sn from ".$this->db_qz."member where nick like('%".$joinRecommendNick."%')))";
		}
		if($orderby=='') $orderby=" order by a.regdate desc,a.mem_status desc,a.sn";
			
		$mModel 	= Lemon_Instance::getObject("MemoModel",true);
		$eModel 	= Lemon_Instance::getObject("EtcModel",true);
		$cModel 	= Lemon_Instance::getObject("CartModel",true);
		$msModel 	= Lemon_Instance::getObject("MoneyModel",true);

		// 기존의회원수익(benefit) 쿼리 : ifnull((select sum(amount) from ".$this->db_qz."charge_log where member_sn=a.sn and state=1), 0)-ifnull((select sum(amount) from ".$this->db_qz."exchange_log where member_sn=a.sn and state=1), 0)-ifnull(a.g_money, 0)-ifnull((select sum(betting_money) from ".$this->db_qz."game_cart where member_sn=a.sn), 0) as benefit,		
		$sql = "select a.*, b.Idx, b.rec_id, b.rec_name,
								(select sum(amount) from ".$this->db_qz."charge_log where member_sn=a.sn and state=1) as charge_sum,
								(select sum(amount) from ".$this->db_qz."exchange_log where member_sn=a.sn and state=1) as exchange_sum,
								(select sum(betting_money) from ".$this->db_qz."game_cart where member_sn=a.sn) as bet_total,
								ifnull((select sum(amount) from ".$this->db_qz."exchange_log where member_sn=a.sn and state=1), 0) - ifnull((select sum(amount) from ".$this->db_qz."charge_log where member_sn=a.sn and state=1), 0) as benefit,
								(select count(*) from ".$this->db_qz."visit where member_id=a.uid) as visit_count
						from ".$this->db_qz."member a LEFT OUTER JOIN ".$this->db_qz."recommend b on a.recommend_sn=b.idx 
						where a.is_store=0 and a.sn>0".$logo.$where.$orderby."
						limit ".$page.",".$page_size;
		//echo $sql;
		$rs = $this->db->exeSql($sql);
        if(is_array($rs) && count($rs) > 0) {
            for($i=0; $i<count($rs); ++$i)
            {
                $ip	= $rs[$i]['reg_ip'];
                $rs[$i]['country_code'] = $eModel->getNationByIp($ip);
                
                // 가입 추천인 정보
                $sql = "select sn, nick, bank_member from ".$this->db_qz."member
                                where sn=(select recommend_sn from ".$this->db_qz."join_recommend where member_sn=".$rs[$i]['sn'].")";
                $rsi = $this->db->exeSql($sql);
                $rs[$i]['join_recommend_sn'] = $rsi[0]['sn'];
                $rs[$i]['join_recommend_nick'] = $rsi[0]['nick'];
                $rs[$i]['join_recommend_bank_member'] = $rsi[0]['bank_member'];
                if(($i+1)%2==1){
                    $rs[$i]['bgColor']="#ffffcd";
                }
            }
        }
        //사위 매장정보
        if(is_array($rs) && count($rs) > 0) {
            for($i=0; $i<count($rs); ++$i)
            {
                // 가입 추천인 정보
                $sql = "select sn, uid, name from ".$this->db_qz."member
                                where is_store=1 and sn=".$rs[$i]['recommend_sn'];
                $rsi = $this->db->exeSql($sql);
                $rs[$i]['store_sn'] = $rsi[0]['sn'];
                $rs[$i]['store_uid'] = $rsi[0]['uid'];
                $rs[$i]['store_name'] = $rsi[0]['name'];
                if(($i+1)%2==1){
                    $rs[$i]['bgColor']="#ffffcd";
                }
            }
        }

		return $rs;
	}
	
	//▶ 매장목록
	function getAllStoreList1($where, $page, $page_size, $orderby='', $joinRecommendNick='', $logo='')
	{
		if($logo!='') $logo = " and a.logo='".$logo."'";
		
		if($joinRecommendNick!='')
		{
			$where.= " and a.sn in (select member_sn from ".$this->db_qz."join_recommend where recommend_sn in (select sn from ".$this->db_qz."member where nick like('%".$joinRecommendNick."%')))";
		}
		if($orderby=='') $orderby=" order by a.regdate desc,a.mem_status desc,a.sn";
			
		$mModel 	= Lemon_Instance::getObject("MemoModel",true);
		$eModel 	= Lemon_Instance::getObject("EtcModel",true);
		$cModel 	= Lemon_Instance::getObject("CartModel",true);
		$msModel 	= Lemon_Instance::getObject("MoneyModel",true);

		// 기존의회원수익(benefit) 쿼리 : ifnull((select sum(amount) from ".$this->db_qz."charge_log where member_sn=a.sn and state=1), 0)-ifnull((select sum(amount) from ".$this->db_qz."exchange_log where member_sn=a.sn and state=1), 0)-ifnull(a.g_money, 0)-ifnull((select sum(betting_money) from ".$this->db_qz."game_cart where member_sn=a.sn), 0) as benefit,		
		$sql = "select a.*, b.Idx, b.rec_id, b.rec_name,
                    (select sum(amount) from ".$this->db_qz."charge_log where member_sn=a.sn and state=1) as charge_sum,
                    (select sum(amount) from ".$this->db_qz."exchange_log where member_sn=a.sn and state=1) as exchange_sum,
                    (select sum(betting_money) from ".$this->db_qz."game_cart where member_sn=a.sn) as bet_total,
                    ifnull((select sum(amount) from ".$this->db_qz."charge_log where member_sn=a.sn and state=1), 0)-ifnull((select sum(amount) from ".$this->db_qz."exchange_log where member_sn=a.sn and state=1), 0) as benefit,
                    (select count(*) from ".$this->db_qz."visit where member_id=a.uid) as visit_count
                from ".$this->db_qz."member a LEFT OUTER JOIN ".$this->db_qz."recommend b on a.recommend_sn=b.idx 
                where a.sn>0".$logo.$where.$orderby."
                limit ".$page.",".$page_size;
		//echo $sql;
		$rs = $this->db->exeSql($sql);

		for($i=0; $i<count((array)$rs); ++$i)
		{
			$ip	= $rs[$i]['reg_ip'];
			$rs[$i]['country_code'] = $eModel->getNationByIp($ip);
            //매장과 회원의 입금금액 합
            $sql = "select sum(amount) as charge_sum from ".$this->db_qz."charge_log where member_sn in (select sn from tb_member where recommend_sn =".$rs[$i]['sn'].")";
            $rsi = $this->db->exeSql($sql);
            $rs[$i]['charge_sum'] = $rs[$i]['charge_sum']+$rsi[0]['charge_sum'];

            //매장과 회원의 출금금액 합
            $sql = "select sum(amount) as exchange_sum from ".$this->db_qz."exchange_log where member_sn in (select sn from tb_member where recommend_sn =".$rs[$i]['sn'].")";
            $rsi = $this->db->exeSql($sql);
            $rs[$i]['exchange_sum'] = $rs[$i]['exchange_sum']+$rsi[0]['exchange_sum'];


			// 가입 추천인 정보
			$sql = "select sn, nick, bank_member from ".$this->db_qz."member
							where sn=(select recommend_sn from ".$this->db_qz."join_recommend where member_sn=".$rs[$i]['sn'].")";
			$rsi = $this->db->exeSql($sql);
			$rs[$i]['join_recommend_sn'] = $rsi[0]['sn'];
			$rs[$i]['join_recommend_nick'] = $rsi[0]['nick'];
			$rs[$i]['join_recommend_bank_member'] = $rsi[0]['bank_member'];
			if(($i+1)%2==1){
				$rs[$i]['bgColor']="#ffffcd";
			}
		}
		
		return $rs;
	}

	//▶ 파티너 아이디
	function getPartnerList($id, $where="")
	{
		$sql = "select idx from tb_recommend where rec_id='".$id."' and logo='".$this->logo."'".$where;
		return $this->db->exeSql($sql);
	}

	//▶ 매장 아이디
	function getStoreList($id, $where="")
	{
		$sql = "select sn from tb_member where uid='".$id."'".$where;
		return $this->db->exeSql($sql);
	}

	//▶ 전체 매장
	function getAllStoreList()
	{
		$sql = "select sn, uid from tb_member where is_store=1";
		return $this->db->exeSql($sql);
	}

	//▶ 가입인증코드 확인 (회원ID, 계정상태=N, 상위 총판 있어야됨.)
	function getRecommendMember($id) {
		$sql = "select uid from tb_member where uid='{$id}' and mem_status = 'N' and is_recommender =1 and recommend_sn > 0";
		return $this->db->exeSql($sql);
	}

	// 유저정보 확인
    function getUserInfo($user_id, $user_name, $user_nick, $user_hp)
    {
        $sql = "select uid, upass, nick, name as user_name, phone  from tb_member where mem_status='N' and (uid ='{$user_id}' or name = '{$user_name}'" .
               " or nick='{$user_nick}' or phone ='{$user_hp}')";
        return $this->db->exeSql($sql);
    }

	//▶ 신규회원 레벨업
	function NewMember_LevelUp()
	{
		$sql = "select sn
				from ".$this->db_qz."member where logo='".$this->logo."'  and mem_status='W' ";
		$rs = $this->db->exeSql($sql);
		
		for( $i = 0; $i < count((array)$rs); ++$i )
		{
			$this->modifyStatus($rs[$i]['sn'], 'good');
		}
	}

	//▶ 상태설정
	function modifyStatus($sn, $flag)
	{
		if($flag=="stop")
		{
			$sql = "update ".$this->db_qz."member 
							set mem_status='S' where sn in(".$sn.")";
		}
		else if($flag=="good")
		{
			$sql = "update ".$this->db_qz."member 
							set mem_status='N' where sn in(".$sn.")";
		}
		else if($flag=="bad")
		{
			$sql = "update ".$this->db_qz."member 
							set mem_status='B' where sn in(".$sn.")";
		}
		else if($flag=="delete")
		{
			$sql = "update ".$this->db_qz."member 
							set mem_status='D' where sn in(".$sn.")";
		}
				
		return $this->db->exeSql($sql);
	}
	
	function modifyByParam($memberSn, $set)
	{
		//-> 해킹방지 bank 정보 업데이트 불가능.
		$set = str_replace("bank_","",$set);
		$sql = "update ".$this->db_qz."member set ".$set." where sn=".$memberSn;
		return $this->db->exeSql($sql);
	}

	//▶ 회원가입
	function joinAdd($uid, $pwd, $exchangePwd, $nick, $name, $phone, $freeMoney, $state, $joinerSn, $partnerSn, $bank_name, $bank_account, $bank_member, $ip, $logo='', $birthday='')
	{
		if ( !$logo ) $logo = $this->logo;
        $rollingSn = 0;
        $email = "";
		if($partnerSn > 0)
		{
			$levelModel 	= Lemon_Instance::getObject("LevelCodeModel",true);
			$partnerModel = Lemon_Instance::getObject("PartnerModel",true);
			$rs = $partnerModel->getPartnerRow($partnerSn);
			if(count((array)$rs) > 0)
			{
				if($rs[0]['rec_lev']==2)
				{
					$rollingSn = empty($rs[0]['Idx']) ? 0 : $rs[0]['Idx'];
					$rsi = $partnerModel->getPartnerRow($rs[0]['parent_sn']);
					if(count((array)$rsi) > 0)
					{
						$partnerSn = empty($rs[0]['Idx']) ? 0 : $rs[0]['Idx'];
					}
				}
			}
			
			$levelCode 	= $levelModel->makeMemberLevelCode($partnerSn);
		}
		
		$sql = "insert into ".$this->db_qz."member(uid,upass,birthday,exchange_pass,nick,name,recommend_sn,rolling_sn,level_code,
						phone,point,email,mem_status,last_date,bank_name,bank_account,bank_member,reg_ip,mem_ip,regdate,reg_domain, logo, is_recommender)
		 				values(";
		
		$sql.= "'".$uid."',";
		$sql.= "'".trim($pwd)."',";
		$sql.= "'".$birthday."',";
		$sql.= "'".$exchangePwd."',";
		$sql.= "'".$nick."',";
		$sql.= "'".$name."',";
		$sql.= "'".$partnerSn."',";
		$sql.= "'".$rollingSn."',";
		$sql.= "'".$levelCode."',";
		$sql.= "'".$phone."',";
		$sql.= "'".$freeMoney."',";
		$sql.= "'".$email."',";
		$sql.= "'".$state."',";
		$sql.= "now(),";
		$sql.= "'".$bank_name."',";
		$sql.= "'".$bank_account."',";		
		$sql.= "'".$name."',";
		$sql.= "'".$ip."',";
		$sql.= "'".$ip."',";
		$sql.= "now(),";
		$sql.= "'".$_SERVER['HTTP_HOST']."',";
        $sql.= "'".$logo."', 0)";
        $memberSn = $this->db->exeSql($sql);
		
		$sql = "insert into ".$this->db_qz."member_bk(uid,upass,birthday,exchange_pass,nick,name,recommend_sn,rolling_sn,level_code,
						phone,point,email,mem_status,last_date,bank_name,bank_account,bank_member,reg_ip,mem_ip,regdate,reg_domain, logo, is_recommender)
		 				values(";
		
		$sql.= "'".$uid."',";
		$sql.= "'".trim($pwd)."',";
		$sql.= "'".$birthday."',";
		$sql.= "'".$exchangePwd."',";
		$sql.= "'".$nick."',";
		$sql.= "'".$name."',";
		$sql.= "'".$partnerSn."',";
		$sql.= "'".$rollingSn."',";
		$sql.= "'".$levelCode."',";
		$sql.= "'".$phone."',";
		$sql.= "'".$freeMoney."',";
		$sql.= "'".$email."',";
		$sql.= "'".$state."',";
		$sql.= "now(),";
		$sql.= "'".$bank_name."',";
		$sql.= "'".$bank_account."',";		
		$sql.= "'".$name."',";
		$sql.= "'".$ip."',";
		$sql.= "'".$ip."',";
		$sql.= "now(),";
		$sql.= "'".$_SERVER['HTTP_HOST']."',";
        $sql.= "'".$logo."', 0)";
        $this->db->exeSql($sql);

	    if ( $memberSn <= 0 ) return 0;

		if ( $joinerSn > 0 ) {
			//추천인 등록
		  $partnerModel = Lemon_Instance::getObject("PartnerModel",true);
		  $rs = $partnerModel->addRecommend($memberSn, $joinerSn);
		}	      
	    return $memberSn;
	}

	//▶ 매장가입
	function join_storeAdd($uid, $pwd, $exchangePwd, $nick, $name, $phone, $freeMoney, $state, $joinerSn, $partnerSn, $bank_name, $bank_member, $bank_account, $ip, $logo='', $birthday='', $tex_type, $tex_rate_sport=0, $tex_rate_minigame=0, $rec_one_folder_flag)
	{
		if ( !$logo ) $logo = $this->logo;
		if($partnerSn!="")
		{
			$levelModel 	= Lemon_Instance::getObject("LevelCodeModel",true);
			$partnerModel 	= Lemon_Instance::getObject("PartnerModel",true);
			$rs 			= $partnerModel->getPartnerRow($partnerSn);
			if(count((array)$rs) > 0)
			{
				if($rs[0]['rec_lev']==2)
				{
					$rollingSn 	= $rs[0]['Idx'];
					$rsi 		= $partnerModel->getPartnerRow($rs[0]['parent_sn']);
					if(count((array)$rsi) > 0)
					{
						$partnerSn = $rsi[0]['Idx'];
					}
				}
			}
			
			$levelCode 	= $levelModel->makeMemberLevelCode($partnerSn);
		}
		
		$sql = "insert into ".$this->db_qz."member(uid,upass,birthday,exchange_pass,nick,name,recommend_sn,rolling_sn,level_code,
						phone,point,email,mem_status,last_date,bank_name,bank_account,bank_member,reg_ip,mem_ip,regdate,reg_domain, logo, is_recommender, is_store, rec_tex_type, rec_rate_sport, rec_rate_minigame, rec_one_folder_flag)
		 				values(";
		
		$sql.= "'".$uid."',";
		$sql.= "'".trim($pwd)."',";
		$sql.= "'".$birthday."',";
		$sql.= "'".$exchangePwd."',";
		$sql.= "'".$nick."',";
		$sql.= "'".$name."',";
		$sql.= "'".$partnerSn."',";
		$sql.= "'".$rollingSn."',";
		$sql.= "'".$levelCode."',";
		$sql.= "'".$phone."',";
		$sql.= "'".$freeMoney."',";
		$sql.= "'".$email."',";
		$sql.= "'".$state."',";
		$sql.= "now(),";
		$sql.= "'".$bank_name."',";
		$sql.= "'".$bank_account."',";		
		$sql.= "'".$bank_member."',";
		$sql.= "'".$ip."',";
		$sql.= "'".$ip."',";
		$sql.= "now(),";
		$sql.= "'".$_SERVER['HTTP_HOST']."',";
		$sql.= "'".$logo."', 1, 1,";
		$sql.= "'".$tex_type."', ";
		$sql.= $tex_rate_sport.",";
		$sql.= $tex_rate_minigame.",";
        $sql.= $rec_one_folder_flag.")"; 
        
		$memberSn = $this->db->exeSql($sql);
			
		if ( $memberSn <= 0 ) return 0;

		if ( $joinerSn > 0 ) {
			//추천인 등록
			$partnerModel = Lemon_Instance::getObject("PartnerModel",true);
			$rs = $partnerModel->addRecommend($memberSn, $joinerSn);
		}	      
		return $memberSn;
	}
	
	//▶ 회원정보, 추천인 포함
	function member($sn)
	{
		$mModel = Lemon_Instance::getObject("MoneyModel",true);
		$cModel = Lemon_Instance::getObject("CartModel",true);
		
		$sql = "select a.*,b.rec_id, 
						(select ifnull(sum(amount),0) from ".$this->db_qz."charge_log where member_sn=a.sn and state=1)-(select ifnull(sum(amount),0) from ".$this->db_qz."exchange_log 
						where member_sn=a.sn and state=1) as benefit
						from ".$this->db_qz."member a left outer join ".$this->db_qz."recommend b on a.recommend_sn=b.idx 
						where a.sn=".$sn;
		$rs = $this->db->exeSql($sql);
	
		$rs[0]['charge_cnt'] = $mModel->getMemberChargeTotal($rs[0]['sn'], "1");
		$rs[0]['exchange_cnt'] = $mModel->getMemberExchangeTotal($rs[0]['sn'], "1");
		$rs[0]['charge_money'] = $mModel->getMemberChargeMoney($rs[0]['sn'] );
		$rs[0]['exchange_money'] = $mModel->getMemberExchangeMoney($rs[0]['sn'] );
		$rs[0]['bet_money'] = $cModel->getMembeRTotalBetMoney($rs[0]['sn']);
		
		return $rs[0];
	}
	
	//▶ 정보수정
	function modify($where, $bank_name, $bank_account, $bank_member, $recommend_sn, $mem_lev, $email, $phone, $memo, $uid, $memberStatus,
                    $exchangePwd, $recommendSn='', $nick, $balance_flag, $is_recommender, $upbet_rate)
	{
		//뱅킹 정보 변경시 업데이트를 위해 데이터 변경을 확인한다.
		$rs = $this->getById($uid);
		if(Trim($rs['bank_name'])!=Trim($bank_name) ||
			 Trim($rs['bank_account'])!=Trim($bank_account) ||
			 Trim($rs['bank_member'])!=Trim($bank_member) )
		{
			$sql = "insert into ".$this->db_qz."member_bank(member_sn, bank_name, bank_account, bank_member, regdate, strIP, logo)
							values(".$rs['sn'].",'".$bank_name."','".$bank_account."','".$bank_member."', now(), '" . $_SESSION["member"]["ip"] . "', '".$this->logo."')";
			$this->db->exeSql($sql);
		}
		
		$set="";
		if($recommendSn!="")
		{
			$levelModel = Lemon_Instance::getObject("LevelCodeModel",true);
			$levelCode = $levelModel->makeMemberLevelCode($recommendSn);	
			$set.="recommend_sn='".$recommendSn."', level_code='".$levelCode."',";
		}

		if ( trim($recommend_sn) > 0 ) {
			$set .= "recommend_sn='".$recommend_sn."',";
		}

		//-> 해킹방지 bank 정보 업데이트 불가능.
		//$where = str_replace("bank_","",$where);
		// $sql = "update ".$this->db_qz."member 
        //         set ".$where.", nick='".$nick."', bank_name='".$bank_name."', bank_account='".$bank_account."', bank_member='".$bank_member."', phone='".$phone."', mem_lev='".$mem_lev."', 
        //         email='".$email."', ".$set." memo='".$memo."', mem_status='".$memberStatus."', exchange_pass='".$exchangePwd."', balance_flag=".$balance_flag.", is_recommender=".$is_recommender." , upbet_rate=".$upbet_rate." where uid='".$uid."'";
        $sql = "update ".$this->db_qz."member 
                set ".$where.", nick='".$nick."', phone='".$phone."', mem_lev='".$mem_lev."', 
                email='".$email."', ".$set." memo='".$memo."', mem_status='".$memberStatus."', balance_flag=".$balance_flag.", is_recommender=".$is_recommender." , upbet_rate=".$upbet_rate." where uid='".$uid."'";
		return $this->db->exeSql($sql);
    }
    
    //▶ 매장정보수정
	function modifyStore($where, $bank_name, $bank_account, $bank_member, $recommend_sn, $mem_lev, $email, $phone, $memo, $uid, $memberStatus,
        $exchangePwd, $nick, $balance_flag, $is_recommender, $upbet_rate, $tex_type, $tex_rate_sport, $tex_rate_minigame, $rec_one_folder_flag)
    {
        //뱅킹 정보 변경시 업데이트를 위해 데이터 변경을 확인한다.
        $rs = $this->getById($uid);
        if(Trim($rs['bank_name'])!=Trim($bank_name) || Trim($rs['bank_account'])!=Trim($bank_account) || Trim($rs['bank_member'])!=Trim($bank_member) )
        {
            $sql = "insert into ".$this->db_qz."member_bank(member_sn, bank_name, bank_account, bank_member, regdate, strIP, logo)
                        values(".$rs['sn'].",'".$bank_name."','".$bank_account."','".$bank_member."', now(), '".$_SESSION["member"]["ip"]."', '".$this->logo."')";
            $this->db->exeSql($sql);
        }

        $set="";
        if($recommend_sn!="")
        {
            $levelModel = Lemon_Instance::getObject("LevelCodeModel",true);
            $levelCode = $levelModel->makeMemberLevelCode($recommend_sn);	
            $set.="recommend_sn='".$recommend_sn."', level_code='".$levelCode."',";
        }

        if ( trim($recommend_sn) > 0 ) {
            $set .= "recommend_sn='".$recommend_sn."',";
        }
        
        //-> 해킹방지 bank 정보 업데이트 불가능.
        //$where = str_replace("bank_","",$where);
        // $sql = "update ".$this->db_qz."member 
        //     set ".$where.", nick='".$nick."', bank_name='".$bank_name."', bank_account='".$bank_account."', bank_member='".$bank_member."', phone='".$phone."', mem_lev='".$mem_lev."', 
        //     email='".$email."', ".$set." memo='".$memo."', mem_status='".$memberStatus."', exchange_pass='".$exchangePwd."', balance_flag=".$balance_flag.", is_recommender=".$is_recommender." , upbet_rate=".$upbet_rate.", 
        //     rec_tex_type='".$tex_type."', rec_rate_sport=".$tex_rate_sport.", rec_rate_minigame=".$tex_rate_minigame.", rec_one_folder_flag='".$rec_one_folder_flag."' where uid='".$uid."'";
        $sql = "update ".$this->db_qz."member 
                set ".$where.", nick='".$nick."', phone='".$phone."', mem_lev='".$mem_lev."', 
                email='".$email."', ".$set." memo='".$memo."', mem_status='".$memberStatus."', balance_flag=".$balance_flag.", is_recommender=".$is_recommender." , upbet_rate=".$upbet_rate.", 
                rec_tex_type='".$tex_type."', rec_rate_sport=".$tex_rate_sport.", rec_rate_minigame=".$tex_rate_minigame.", rec_one_folder_flag='".$rec_one_folder_flag."' where uid='".$uid."'";
        return $this->db->exeSql($sql);
    }	

	function modifyMember($sn)
	{	
		if ( $this->req->request('newpass') ) {
			$data['upass'] = $this->req->request('newpass');
		}
		if ( $this->req->request('phone1') ) {
			$data['phone'] = $this->req->request('phone1')."-".$this->req->request('phone2')."-".$this->req->request('phone3');
		}		
		$data['sms_safedomain'] = empty($this->req->request('sms_safedomain')) ? 0 : $this->req->request('sms_safedomain');
		$data['sms_event'] = empty($this->req->request('sms_event')) ? 0 : $this->req->request('sms_event');
		$data['sms_betting_ok'] = empty($this->req->request('sms_betting_ok')) ? 0 : $this->req->request('sms_betting_ok');
        $data['exchange_pass'] = empty($this->req->request('exchange_pass')) ? "" : $this->req->request('exchange_pass');
		
		$where = "sn=".$sn;

        $sql = "update ".$this->db_qz."member
                        set upass= '".$data['upass']."',
                        sms_safedomain= '".$data['sms_safedomain']."',
                        sms_event= '".$data['sms_event']."',
                        sms_betting_ok= '".$data['sms_betting_ok']."',
                        exchange_pass= '".$data['exchange_pass']."' 
                where   sn=".$sn;

		//$this->db->setUpdate($this->db_qz.'member', $data, $where);
		
		$this->db->exeSql($sql);
	}
	
	//▶ 회원 메모쓰기
	function writeNote($sn, $content)
	{
		$sql = "insert into ".$this->db_qz."member_note(member_sn,regdate,memo) values ";
		$sql.= "(".$sn.",now(),'".$content."')";
		return $this->db->exeSql($sql);
	}
	
	//▶ 회원 메모수정
	function modifyNote($noteSn, $content)
	{
		$sql = "update ".$this->db_qz."member_note
						set memo= '".$content."' where sn=".$noteSn;
				
		return $this->db->exeSql($sql);
	}
	
	//▶ 회원 메모보기
	function getNote($sn)
	{
		$sql = "select * 
				from ".$this->db_qz."member_note
					where sn='".$sn."'";
		$rs = $this->db->exeSql($sql);
		return $rs[0];
	}
	
	//▶ 관리자 메모삭제
	function delNote($sn)
	{
		$sql = "delete from ".$this->db_qz."member_note where sn = ".$sn;
		$this->db->exeSql($sql);
	}
	
	function getMember_Export()
	{
		$sql = "
			select *,
	 			(select rec_id from ".$this->db_qz."recommend where idx=recommend_sn) as recommend_id,
	 			(select sum(agree_amount) from ".$this->db_qz."charge_log where member_sn=a.sn) as tot_charge,
	 			(select sum(agree_amount) from ".$this->db_qz."exchange_log where member_sn=a.sn) as tot_exchange
			from ".$this->db_qz."member a order by regdate desc";
		
		$rs = $this->db->exeSql($sql);
		
		return $rs;
	}
	
	//▶ 필드 데이터
	function getMemberBankList($memberSn)
	{
	
		$sql = "select * from ".$this->db_qz."member_bank
						where member_sn=".$memberSn." and logo='".$this->logo."'";
		
		return $this->db->exeSql($sql);
	}
	
	//하루 배팅취소 횟수업데이트
	function setBet_cancel_cnt($sn, $bet_cancel_cnt)
	{
		$sql = "update ".$this->db_qz."member set bet_cancel_flag='".date('Y-m-d')."_".$bet_cancel_cnt."'	where sn=".$sn." and logo='".$this->logo."'";
		return $this->db->exeSql($sql);
	}

    // 해당 유저의 취소된 배팅개수 얻기
    function getBetCancelCnt($memberSn)
    {
        $sql = "SELECT bet_cancel_cnt FROM tb_member WHERE sn = " . $memberSn;
        $res = $this->db->exeSql($sql);
        $betCancelCnt = 0;
        if(count((array)$res) > 0) 
            $betCancelCnt = $res[0]["bet_cancel_cnt"];
        return $betCancelCnt;
    }

    // 해당 유저의 취소된 배팅개수 초기화
    function clearBetCancelCnt($memberSn)
    {
        $sql = "UPDATE tb_member SET bet_cancel_cnt = 0 WHERE sn = " . $memberSn;
        $res = $this->db->exeSql($sql);
        return $res;
    }
	
	//▶ 추천인 정보
	function getJoiner($member_sn)
	{
		$sql = "select recommend_sn
						from ".$this->db_qz."join_recommend
						where logo='".$this->logo."'  and member_sn=".$member_sn;
		$rs = $this->db->exeSql($sql);
		
		return $rs[0]['recommend_sn'];
	}
	
	//▶ 내가 추천한 유저의 정보
	function getJoiners($member_sn)
	{
		$sql = "select b.*
						from ".$this->db_qz."join_recommend a, ".$this->db_qz."member b
						where a.member_sn=b.sn and a.recommend_sn=".$member_sn;
		$rs = $this->db->exeSql($sql);
		
		return $rs;
	}
	
	// 미일리지
    function getMileageRate($mem_sn)
    {
        /*$sql ="select m.sn, lc.lev_join_recommend_mileage_rate as rate from tb_member m, tb_level_config lc ".
              " where m.mem_lev = lc.lev ".
              " and m.sn = ".$mem_sn;

        $rs = $this->db->exeSql($sql);
        $array = explode(':', $rs[0]['rate']);
        return $array[0];*/

        $sql ="select m.sn, m.rate from tb_member m ".
            " where m.sn = ".$mem_sn;

        $rs = $this->db->exeSql($sql);
        return $rs[0]['rate'];
    }


	//▶ 내가 추천한 유저의 정보
    function getJoiners2($member_sn)
    {
        $sql = "select b.*,
                       (select sum(amount) from ".$this->db_qz."charge_log where member_sn=b.sn and state=1) as charge_sum,
								(select sum(amount) from ".$this->db_qz."exchange_log where member_sn=b.sn and state=1) as exchange_sum,
								(select sum(betting_money) from ".$this->db_qz."game_cart where member_sn=b.sn) as bet_total,
								ifnull((select sum(amount) from ".$this->db_qz."charge_log where member_sn=b.sn and state=1), 0)-ifnull((select sum(amount) from ".$this->db_qz."exchange_log where member_sn=a.sn and state=1), 0) as benefit,
								(select count(*) from ".$this->db_qz."visit where member_id=b.uid) as visit_count 
						from ".$this->db_qz."join_recommend a, ".$this->db_qz."member b
						where a.member_sn=b.sn and a.recommend_sn=".$member_sn;
		
        $rs = $this->db->exeSql($sql);

        return $rs;
    }

	function getAllUsersforEachStore($recommend_sn) {
		$sql = "select b.*,
				(select sum(amount) from ".$this->db_qz."charge_log where member_sn=b.sn and state=1) as charge_sum,
                    (select sum(amount) from ".$this->db_qz."exchange_log where member_sn=b.sn and state=1) as exchange_sum,
                    (select sum(betting_money) from ".$this->db_qz."game_cart where member_sn=b.sn) as bet_total,
                    ifnull((select sum(amount) from ".$this->db_qz."charge_log where member_sn=b.sn and state=1), 0)-ifnull((select sum(amount) from ".$this->db_qz."exchange_log where member_sn=b.sn and state=1), 0) as benefit,
                    (select count(*) from ".$this->db_qz."visit where member_id=b.uid) as visit_count 
				from ".$this->db_qz."member b
				where b.is_store=0 and b.recommend_sn=".$recommend_sn;

		$rs = $this->db->exeSql($sql);
		return $rs;
	}

	//▶ 현재 게임중인지 판단, 베팅안됨
	function getServiceID($uid)
	{
		$sql = "select nServerID
						from ".$this->db_qz."godoriuser
						where szID='".$uid."'";
		$rs = $this->db->exeSql($sql);
		
		if(count($rs)<=0)
			return -1;
		
		return $rs[0]['nServerID'];
	}

	//▶ 총판아이디 확인
	function getPartnerInfo($id) {
		$sql = "select * from tb_recommend where rec_id='{$id}'";
		return $this->db->exeSql($sql);
	}

	//->총판id를 sn으로 바꾸기 위한 쿼리. #1
	function get_member_recommend() {
		$sql = "select a.sn as mem_sn, b.Idx as rec_sn from tb_member a, tb_recommend b where a.recommend_sn = b.rec_id and b.rec_lev = 1 and a.sn > 9";
		$rs = $this->db->exeSql($sql);
		return $rs;
	}
	//->총판id를 sn으로 바꾸기 위한 쿼리. #2
	function update_recid_to_recsn($mem_sn, $rec_sn) {
		$sql = "update tb_member set recommend_sn = '{$rec_sn}' where sn = '{$mem_sn}'";
		return $this->db->exeSql($sql);
	}

	function todayChargeAmount($member_sn, $today)
    {
        $sql = "select sum(amount) as charge_amt from tb_charge_log where member_sn={$member_sn} and operdate >='{$today} 00:00:00' and operdate <='{$today} 23:59:59'";
        $rs = $this->db->exeSql($sql);

        $charge_amt = $rs[0]['charge_amt'];
        return $charge_amt == null ? 0 : $charge_amt;
    }

    function todayPresenseCheck($member_sn, $today)
    {
        $sql = "select * from tb_presense_check where member_sn={$member_sn} and date ='{$today}'";
        $rs = $this->db->exeSql($sql);

        return $rs;
    }

    function getThisMonthPresence($member_sn = 0, $thisMonth = "") {
        $sql = "select date from tb_presense_check where member_sn = {$member_sn} and date like '{$thisMonth}%'";
        $rs = $this->db->exeSql($sql);
        return $rs;
    }

    function checkPresense($mem_sn) {
        $sql = "insert into tb_presense_check(member_sn,date) values ";
        $sql.= "(".$mem_sn.",now())";
        return $this->db->exeSql($sql);
    }

    function presenseCount($member_sn, $start, $end)
    {
        $sql = "select count(*) as cnt from tb_presense_check where member_sn={$member_sn} and date >='{$start}' and date <='{$end}'";
        $rs = $this->db->exeSql($sql);

        return $rs[0]['cnt'];
    }

    function getTotalList($kind, $keyword, $field)
    {
        $sql = "select ".$field." from tb_member where mem_status='N'";
        if($kind == 'mem_id')
        {
            $sql .= " and uid like '%".$keyword."%'";
        } else if($kind == 'nick') {
            $sql .= " and nick like '%".$keyword."%'";
        }

        $rs = $this->db->exeSql($sql);
        return $rs;
    }

    function getCheckList($kind, $keyword, $start, $end)
    {
        $sql = "select * from tb_presense_check p, tb_member m where m.sn=p.member_sn and date >='{$start}' and date <='{$end}'";
        if($kind == 'mem_id')
        {
            $sql .= " and m.uid like '%".$keyword."%'";
        } else if($kind == 'nick') {
            $sql .= " and m.nick like '%".$keyword."%'";
        }
        
        $rs = $this->db->exeSql($sql);
        $rlt = array();
        if(count((array)$rs) > 0) {
            foreach($rs as $key=>$data)
            {
                $rlt[$data['uid']][] = $data['date'];
            }
        }
        return $rlt;
    }

    function getCheckPointSum($member_sn, $start, $end, $keyword)
    {
        $sql = "select sum(amount) as sum from tb_mileage_log where member_sn={$member_sn} and regdate >='{$start} 00:00:00' and regdate <='{$end} 23:59:59' and status_message like '{$keyword}%'";
        $rs = $this->db->exeSql($sql);

        return $rs[0]['sum'] == null ? 0 : $rs[0]['sum'];
	}
	
	//매장의 모든 유저
	function getListUser($recommend_sn) {
		$sql = "Select * From tb_member WHERE recommend_sn = ".$recommend_sn;
		return $this->db->exeSql($sql);
	}

    //-> 총판 보유머니 변경
    function modifyRecMoney($sn, $rec_money) {
        $sql = "update ".$this->db_qz."member set rec_money='".$rec_money."' where sn='".$sn."'";
        return $this->db->exeSql($sql);
    }

    //-> 총판 머니 변동 로그
    function changeRecMoneyLog($recommendSn, $amount, $before_money, $after_money, $state, $status_message) {
        $hDate = date("Y-m-d H:i:s",time());
        $sql = "insert into ".$this->db_qz."store_money_log (rec_sn, amount, before_money, after_money, state, status_message, proc_flag, is_read, regdate) values (";
        $sql = $sql."'".$recommendSn."','".$amount."','".$before_money."','".$after_money."','".$state."','".$status_message."',0, 0, '".$hDate."')";
        return $this->db->exeSql($sql);
    }

	public function getSortieList()
    {
        $sql = "select sn, uid, nick from tb_member where sortie=1 order by uid asc";
        $rs = $this->db->exeSql($sql);
        return $rs;
    }

    public function getMemberRows2()
    {
        $sql = "select * from tb_member order by nick asc";

        $rs = $this->db->exeSql($sql);
        return $rs;
    }

    function modifyChangeBank($bankname,$banknum,$bankusername,$sn)
    {
        // $sql = "update ".$this->db_qz."member 
		// 		set bank_name='".$bankname."',bank_account='".$banknum."',bank_member='".$bankusername."' 
		// 			where sn='".$sn."'";
        $sql = "";

        return $this->db->exeSql($sql);
    }

    function getTotal2($where, $joinRecommendSn='', $logo='')
    {
        if($joinRecommendSn!='')
        {
            $where.= " and a.sn in (select member_sn from ".$this->db_qz."join_recommend where recommend_sn = ".$joinRecommendSn.")";
        }

        $sql = "select count(*) as cnt from ".$this->db_qz."member a where 1=1 ".$logo.$where;

        $rs = $this->db->exeSql($sql);
        return $rs[0]['cnt'];
    }

    function getPassword($sn)
    {
        $sql = "select upass 
							from ".$this->db_qz."member 
								where sn='".$sn."'";
        $rs = $this->db->exeSql($sql);

        return $rs[0]['upass'];
    }

    function modifyChangePassword($sn,$password)
    {
        $sql = "update ".$this->db_qz."member set upass='".$password."' 
						where sn='".$sn."'";

        return $this->db->exeSql($sql);
    }

    function getMileageAmt($mem_sn)
    {
        $beginDate = date("Y-m-d 00:00:00", time());
        /*$sql = "select sum(amount) amt from tb_mileage_log ".
                " where member_sn = ". $mem_sn.
                " and regdate > '".$beginDate."'";*/
        /*$sql = "select sum(amount) amt from tb_mileage_log ".
            " where member_sn = ". $mem_sn;*/

        $sql = "select point as amt from tb_member ".
            " where sn = ". $mem_sn;

        $rs = $this->db->exeSql($sql);
        $result = 0;
        if(isset($rs[0]['amt']))
            $result  = $rs[0]['amt'];

        return $result;
    }

    function getTodayMileageAmt($mem_sn)
    {
        $beginDate = date("Y-m-d 00:00:00", time());
        $sql = "select sum(amount) amt from tb_mileage_log ".
                " where member_sn = ". $mem_sn.
                " and state = 12 ".
                " and regdate > '".$beginDate."'";
        /*$sql = "select sum(amount) amt from tb_mileage_log ".
            " where member_sn = ". $mem_sn;*/

        /*$sql = "select point as amt from tb_member ".
            " where sn = ". $mem_sn;*/

        $rs = $this->db->exeSql($sql);
        $result = 0;
        if(isset($rs[0]['amt']))
            $result  = $rs[0]['amt'];

        return $result;
    }

    function getList2($where, $page, $page_size, $orderby='', $joinRecommendId='', $logo='')
    {
        if($logo!='') $logo = " and a.logo='".$logo."'";

        if($joinRecommendId!='')
        {
            $where.= " and a.recommend_sn =".$joinRecommendId;
        }
        if($orderby=='') $orderby=" order by a.regdate desc,a.mem_status desc,a.sn";

        $mModel 	= Lemon_Instance::getObject("MemoModel",true);
        $eModel 	= Lemon_Instance::getObject("EtcModel",true);
        $cModel 	= Lemon_Instance::getObject("CartModel",true);
        $msModel 	= Lemon_Instance::getObject("MoneyModel",true);

        // 기존의회원수익(benefit) 쿼리 : ifnull((select sum(amount) from ".$this->db_qz."charge_log where member_sn=a.sn and state=1), 0)-ifnull((select sum(amount) from ".$this->db_qz."exchange_log where member_sn=a.sn and state=1), 0)-ifnull(a.g_money, 0)-ifnull((select sum(betting_money) from ".$this->db_qz."game_cart where member_sn=a.sn), 0) as benefit,
        $sql = "select a.*,
                        (select sum(amount) from ".$this->db_qz."charge_log where member_sn=a.sn and state=1) as charge_sum,
                        (select sum(amount) from ".$this->db_qz."exchange_log where member_sn=a.sn and state=1) as exchange_sum,
                        (select sum(betting_money) from ".$this->db_qz."game_cart where member_sn=a.sn) as bet_total,
                        ifnull((select sum(amount) from ".$this->db_qz."charge_log where member_sn=a.sn and state=1), 0)-ifnull((select sum(amount) from ".$this->db_qz."exchange_log where member_sn=a.sn and state=1), 0) as benefit,
                        (select count(*) from ".$this->db_qz."visit where member_id=a.uid) as visit_count
                from ".$this->db_qz."member a  
                where a.is_store=0 and a.sn>0".$logo.$where.$orderby."
                limit ".$page.",".$page_size;
        
        $rs = $this->db->exeSql($sql);

        for($i=0; $i<count((array)$rs); ++$i)
        {
            $ip	= $rs[$i]['reg_ip'];
            $rs[$i]['country_code'] = $eModel->getNationByIp($ip);

            // 가입 추천인 정보
            $sql = "select sn, nick, bank_member from ".$this->db_qz."member
							where sn in (select recommend_sn from ".$this->db_qz."join_recommend where member_sn=".$rs[$i]['sn'].")";
            $rsi = $this->db->exeSql($sql);
            $rs[$i]['join_recommend_sn'] = $rsi[0]['sn'];
            $rs[$i]['join_recommend_nick'] = $rsi[0]['nick'];
            $rs[$i]['join_recommend_bank_member'] = $rsi[0]['bank_member'];
            if(($i+1)%2==1){
                $rs[$i]['bgColor']="#ffffcd";
            }
        }

        return $rs;
    }

    function getPartnerBySn($sn)
    {
        $sql = "select * from tb_recommend where Idx=".$sn;
        return $this->db->exeSql($sql);
    }

	function modifyRate($sn, $rate)
    {
        $sql = "update ".$this->db_qz."member 
							set rate=".$rate." where sn =".$sn;

        return $this->db->exeSql($sql);
    }

    function modifyRate2($sn, $rate, $rate2, $rate_inout)
    {
        $sql = "update ".$this->db_qz."member 
							set rate=".$rate.", rate2=".$rate2.", rate_inout=".$rate_inout." where sn =".$sn;

        return $this->db->exeSql($sql);
    }

    //▶ 회원가입
    function joinAdd2($uid, $pwd, $exchangePwd, $nick, $name, $phone, $freeMoney, $state,
                      $joinerSn, $partnerSn = 0, $bank_name, $bank_account, $bank_member,$mem_lev, $ip, $logo='', $birthday='')
    {
        $bank_account = str_replace('&', '', $bank_account);
        if ( !$logo ) $logo = $this->logo;
        if($partnerSn!="")
        {
            $levelModel 	= Lemon_Instance::getObject("LevelCodeModel",true);
            $partnerModel = Lemon_Instance::getObject("PartnerModel",true);
            $rs = $partnerModel->getPartnerRow($partnerSn);
            if(count((array)$rs) > 0)
            {
                if($rs[0]['rec_lev']==2)
                {
                    $rollingSn = empty($rs[0]['Idx']) ? 0 : $rs[0]['Idx'];
                    $rsi = $partnerModel->getPartnerRow($rs[0]['parent_sn']);
                    if(count((array)$rsi) > 0)
                    {
                        $partnerSn = empty($rsi[0]['Idx']) ? 0 : $rsi[0]['Idx'];
                    }
                }
            }

            $levelCode 	= $levelModel->makeMemberLevelCode($partnerSn);
        }

        $sql = "insert into ".$this->db_qz."member(uid,upass,birthday,exchange_pass,nick,name,recommend_sn,rolling_sn, mem_lev, level_code,
						phone,point,email,mem_status,last_date,bank_name,bank_account,bank_member,reg_ip,mem_ip,regdate,reg_domain, logo, is_recommender)
		 				values(";

        $sql.= "'".$uid."',";
        $sql.= "'".trim($pwd)."',";
        $sql.= "'".$birthday."',";
        $sql.= "'".$exchangePwd."',";
        $sql.= "'".$nick."',";
        $sql.= "'".$name."',";
        $sql.= intval($partnerSn).",";
        $sql.= intval($rollingSn).",";
        $sql.= $mem_lev.",";
        $sql.= "'".$levelCode."',";
        $sql.= "'".$phone."',";
        $sql.= "'".$freeMoney."',";
        $sql.= "'".$email."',";
        $sql.= "'".$state."',";
        $sql.= "now(),";
        $sql.= "'".$bank_name."',";
        $sql.= "'".$bank_account."',";
        $sql.= "'".$name."',";
        $sql.= "'".$ip."',";
        $sql.= "'".$ip."',";
        $sql.= "now(),";
        $sql.= "'".$_SERVER['HTTP_HOST']."',";
        $sql.= "'".$logo."', 0)";
        $memberSn = $this->db->exeSql($sql);

        if ( $memberSn <= 0 ) return 0;

        $sql = "insert into ".$this->db_qz."member_config(member_sn) values(".$memberSn.")";
        $this->db->exeSql($sql);

        $sql = "insert into ".$this->db_qz."member_odd(member_sn) values(".$memberSn.")";
        $this->db->exeSql($sql);

        if ( $joinerSn > 0 ) {
            //추천인 등록
            $partnerModel = Lemon_Instance::getObject("PartnerModel",true);
            $rs = $partnerModel->addRecommend($memberSn, $joinerSn);
        }

        $sql = "insert into ".$this->db_qz."member_bk(uid,upass,birthday,exchange_pass,nick,name,recommend_sn,rolling_sn, mem_lev, level_code,
						phone,point,email,mem_status,last_date,bank_name,bank_account,bank_member,reg_ip,mem_ip,regdate,reg_domain, logo, is_recommender)
		 				values(";

        $sql.= "'".$uid."',";
        $sql.= "'".trim($pwd)."',";
        $sql.= "'".$birthday."',";
        $sql.= "'".$exchangePwd."',";
        $sql.= "'".$nick."',";
        $sql.= "'".$name."',";
        $sql.= intval($partnerSn).",";
        $sql.= intval($rollingSn).",";
        $sql.= $mem_lev.",";
        $sql.= "'".$levelCode."',";
        $sql.= "'".$phone."',";
        $sql.= "'".$freeMoney."',";
        $sql.= "'".$email."',";
        $sql.= "'".$state."',";
        $sql.= "now(),";
        $sql.= "'".$bank_name."',";
        $sql.= "'".$bank_account."',";
        $sql.= "'".$name."',";
        $sql.= "'".$ip."',";
        $sql.= "'".$ip."',";
        $sql.= "now(),";
        $sql.= "'".$_SERVER['HTTP_HOST']."',";
        $sql.= "'".$logo."', 0)";
        $this->db->exeSql($sql);
        return $memberSn;
    }

    function joinAdd3($uid, $pwd, $exchangePwd, $nick, $name, $phone, $rate, $rate2, $freeMoney, $state, $joinerSn,
                      $partnerSn = 0, $bank_name, $bank_account, $bank_member, $ip, $is_store, $logo='', $birthday='')
    {
        if ( !$logo ) $logo = $this->logo;
        if($partnerSn!="")
        {
            $levelModel 	= Lemon_Instance::getObject("LevelCodeModel",true);
            $partnerModel = Lemon_Instance::getObject("PartnerModel",true);
            $rs = $partnerModel->getPartnerRow($partnerSn);
            if(count((array)$rs) > 0)
            {
                if($rs[0]['rec_lev']==2)
                {
                    $rollingSn = $rs[0]['Idx'];
                    $rsi = $partnerModel->getPartnerRow($rs[0]['parent_sn']);
                    if(count((array)$rsi) > 0)
                    {
                        $partnerSn = $rsi[0]['Idx'];
                    }
                }
            }

            $levelCode 	= $levelModel->makeMemberLevelCode($partnerSn);
        }

        $bank_account = str_replace('&', '', $bank_account);

        $sql = "insert into ".$this->db_qz."member(uid,upass,birthday,exchange_pass,nick,name,recommend_sn,rolling_sn,level_code,
						phone, rate, rate2, point,mem_status,last_date,bank_name,bank_account,bank_member,reg_ip,mem_ip,regdate,reg_domain, logo, is_recommender, is_store)
		 				values(";

        $sql.= "'".$uid."',";
        $sql.= "'".trim($pwd)."',";
        $sql.= "'".$birthday."',";
        $sql.= "'".$exchangePwd."',";
        $sql.= "'".$nick."',";
        $sql.= "'".$name."',";
        $sql.= "'".$partnerSn."',";
        $sql.= "'".$rollingSn."',";
        $sql.= "'".$levelCode."',";
        $sql.= "'".$phone."',";
        $sql.= $rate.",";
        $sql.= $rate2.",";
        $sql.= "'".$freeMoney."',";
        $sql.= "'".$state."',";
        $sql.= "now(),";
        $sql.= "'".$bank_name."',";
        $sql.= "'".$bank_account."',";
        $sql.= "'".$bank_member."',";
        $sql.= "'".$ip."',";
        $sql.= "'".$ip."',";
        $sql.= "now(),";
        $sql.= "'".$_SERVER['HTTP_HOST']."',";
        $sql.= "'".$logo."', 0, ".$is_store.")";
        $memberSn = $this->db->exeSql($sql);

        if ( $memberSn <= 0 ) return 0;

        $sql = "insert into ".$this->db_qz."member_config(member_sn) values(".$memberSn.")";
        $this->db->exeSql($sql);

        if($is_store === 1)
        {
            $sql = "insert into ".$this->db_qz."member_odd(member_sn) values(".$memberSn.")";
            $this->db->exeSql($sql);
        }

        if ( $joinerSn > 0 ) {
            //추천인 등록
            $partnerModel = Lemon_Instance::getObject("PartnerModel",true);
            $rs = $partnerModel->addRecommend($memberSn, $joinerSn);
        }

        $sql = "insert into ".$this->db_qz."member_bk(uid,upass,birthday,exchange_pass,nick,name,recommend_sn,rolling_sn,level_code,
						phone, rate, rate2, point,mem_status,last_date,bank_name,bank_account,bank_member,reg_ip,mem_ip,regdate,reg_domain, logo, is_recommender, is_store)
		 				values(";

        $sql.= "'".$uid."',";
        $sql.= "'".trim($pwd)."',";
        $sql.= "'".$birthday."',";
        $sql.= "'".$exchangePwd."',";
        $sql.= "'".$nick."',";
        $sql.= "'".$name."',";
        $sql.= "'".$partnerSn."',";
        $sql.= "'".$rollingSn."',";
        $sql.= "'".$levelCode."',";
        $sql.= "'".$phone."',";
        $sql.= $rate.",";
        $sql.= $rate2.",";
        $sql.= "'".$freeMoney."',";
        $sql.= "'".$state."',";
        $sql.= "now(),";
        $sql.= "'".$bank_name."',";
        $sql.= "'".$bank_account."',";
        $sql.= "'".$bank_member."',";
        $sql.= "'".$ip."',";
        $sql.= "'".$ip."',";
        $sql.= "now(),";
        $sql.= "'".$_SERVER['HTTP_HOST']."',";
        $sql.= "'".$logo."', 0, ".$is_store.")";
        $this->db->exeSql($sql);

        return $memberSn;
    }

    //▶ 정보수정
    function modifyBankInfo($where, $bank_name, $bank_account, $bank_member, $uid)
    {
        //뱅킹 정보 변경시 업데이트를 위해 데이터 변경을 확인한다.
        $bank_account = str_replace('&', '', $bank_account);

        $rs = $this->getById($uid);
        if(Trim($rs['bank_name'])!=Trim($bank_name) ||
            Trim($rs['bank_account'])!=Trim($bank_account) ||
            Trim($rs['bank_member'])!=Trim($bank_member) )
        {
            $sql = "insert into ".$this->db_qz."member_bank(member_sn, bank_name, bank_account, bank_member, regdate, strIP, logo)
							values(".$rs['sn'].",'".$bank_name."','".$bank_account."','".$bank_member."', now(), '".$_SESSION["member"]["ip"]."', '".$this->logo."')";
            $this->db->exeSql($sql);
        }

        // $sql = "update ".$this->db_qz."member 
		// 				set ".$where." bank_name='".$bank_name."', bank_account='".$bank_account."', bank_member='".$bank_member."' where uid='".$uid."'";
        $sql = "";
        return $this->db->exeSql($sql);
    }

    //▶ 정보수정
    function modifyBankMember($bank_member, $sn)
    {
        //뱅킹 정보 변경시 업데이트를 위해 데이터 변경을 확인한다.
        // $sql = "update ".$this->db_qz."member 
		// 				set bank_member='".$bank_member."' where sn=".$sn;
        $sql = "";
        return $this->db->exeSql($sql);
    }

    function modify2($where, $bank_name, $bank_account, $bank_member, $recommend_sn, $mem_lev, $email, $phone, $memo, $uid, $memberStatus,
                    $exchangePwd, $recommendSn='', $nick, $balance_flag, $is_adh, $powerball_flag, $wooriball_flag, $is_print)
    {
        //뱅킹 정보 변경시 업데이트를 위해 데이터 변경을 확인한다.
        $bank_account = str_replace('&', '', $bank_account);
        $rs = $this->getById($uid);
        if(Trim($rs['bank_name'])!=Trim($bank_name) ||
            Trim($rs['bank_account'])!=Trim($bank_account) ||
            Trim($rs['bank_member'])!=Trim($bank_member) )
        {
            $sql = "insert into ".$this->db_qz."member_bank(member_sn, bank_name, bank_account, bank_member, regdate, strIP, logo)
							values(".$rs['sn'].",'".$bank_name."','".$bank_account."','".$bank_member."', now(), '".$_SESSION["member"]["ip"]."', '".$this->logo."')";
            $this->db->exeSql($sql);
        }

        $set="";
        if($recommendSn!="")
        {
            $levelModel = Lemon_Instance::getObject("LevelCodeModel",true);
            $levelCode = $levelModel->makeMemberLevelCode($recommendSn);
            $set.="recommend_sn='".$recommendSn."', level_code='".$levelCode."',";
        }

        if ( trim($recommend_sn) > 0 ) {
            $set .= "recommend_sn='".$recommend_sn."',";
        }

        //-> 해킹방지 bank 정보 업데이트 불가능.
        //$where = str_replace("bank_","",$where);
        $sql = "update ".$this->db_qz."member 
						set ".$where.", nick='".$nick."', phone='".$phone."', mem_lev='".$mem_lev."', 
						email='".$email."', ".$set." memo='".$memo."', mem_status='".$memberStatus."', exchange_pass='".$exchangePwd.
                        "', balance_flag=".$balance_flag.", is_adh=".$is_adh.", powerball_flag=".$powerball_flag.", wooriball_flag=".$wooriball_flag.", is_print=".$is_print.
               " where uid='".$uid."'";
        return $this->db->exeSql($sql);
    }

    function modify3($where, $bank_name, $bank_account, $bank_member, $recommend_sn, $mem_lev, $email, $phone, $memo, $uid, $memberStatus,
                    $exchangePwd, $recommendSn='', $nick, $balance_flag, $powerball_flag, $wooriball_flag, $is_print, $rate, $rate2)
    {
        //뱅킹 정보 변경시 업데이트를 위해 데이터 변경을 확인한다.
        $bank_account = str_replace('&', '', $bank_account);
        $rs = $this->getById($uid);
        if(Trim($rs['bank_name'])!=Trim($bank_name) ||
            Trim($rs['bank_account'])!=Trim($bank_account) ||
            Trim($rs['bank_member'])!=Trim($bank_member) )
        {
            $sql = "insert into ".$this->db_qz."member_bank(member_sn, bank_name, bank_account, bank_member, regdate, strIP, logo)
							values(".$rs['sn'].",'".$bank_name."','".$bank_account."','".$bank_member."', now(), '".$_SESSION["member"]["ip"]."', '".$this->logo."')";
            $this->db->exeSql($sql);
        }

        $set="";
        if($recommendSn!="")
        {
            $levelModel = Lemon_Instance::getObject("LevelCodeModel",true);
            $levelCode = $levelModel->makeMemberLevelCode($recommendSn);
            $set.="recommend_sn='".$recommendSn."', level_code='".$levelCode."',";
        }

        if ( trim($recommend_sn) > 0 ) {
            $set .= "recommend_sn='".$recommend_sn."',";
        }

        //-> 해킹방지 bank 정보 업데이트 불가능.
        //$where = str_replace("bank_","",$where);
        $sql = "update ".$this->db_qz."member 
						set ".$where.", nick='".$nick."', phone='".$phone."', mem_lev='".$mem_lev."', 
						email='".$email."', ".$set." memo='".$memo."', mem_status='".$memberStatus."', exchange_pass='".$exchangePwd."', balance_flag=".$balance_flag.
            "    ,powerball_flag=".$powerball_flag.", wooriball_flag=".$wooriball_flag.", is_print=".$is_print.", rate=".$rate.", rate2=".$rate2.
            " where uid='".$uid."'";
        return $this->db->exeSql($sql);
    }

    function modify4($where, $bank_name, $bank_account, $bank_member, $recommend_sn, $mem_lev,
                     $email, $phone, $memo, $uid, $memberStatus, $exchangePwd, $recommendSn='',
                     $nick, $balance_flag, $powerball_flag, $wooriball_flag, $ball_flag,
                     $is_print, $rate, $rate2, $is_adh)
    {
        //뱅킹 정보 변경시 업데이트를 위해 데이터 변경을 확인한다.
        $bank_account = str_replace('&', '', $bank_account);
        $rs = $this->getById($uid);
        if(Trim($rs['bank_name'])!=Trim($bank_name) ||
            Trim($rs['bank_account'])!=Trim($bank_account) ||
            Trim($rs['bank_member'])!=Trim($bank_member) )
        {
            $sql = "insert into ".$this->db_qz."member_bank(member_sn, bank_name, bank_account, bank_member, regdate, strIP, logo)
							values(".$rs['sn'].",'".$bank_name."','".$bank_account."','".$bank_member."', now(), '".$_SESSION["member"]["ip"]."', '".$this->logo."')";
            $this->db->exeSql($sql);
        }

        $set="";
        if($recommendSn!="")
        {
            $levelModel = Lemon_Instance::getObject("LevelCodeModel",true);
            $levelCode = $levelModel->makeMemberLevelCode($recommendSn);
            $set.="recommend_sn='".$recommendSn."', level_code='".$levelCode."',";
        }

        if ( trim($recommend_sn) > 0 ) {
            $set .= "recommend_sn='".$recommend_sn."',";
        }

        //-> 해킹방지 bank 정보 업데이트 불가능.
        //$where = str_replace("bank_","",$where);
        $sql = "update ".$this->db_qz."member 
						set ".$where.", nick='".$nick."', phone='".$phone."', mem_lev='".$mem_lev."', 
						email='".$email."', ".$set." memo='".$memo."', mem_status='".$memberStatus."', exchange_pass='".$exchangePwd."', balance_flag=".$balance_flag.
            "    ,powerball_flag=".$powerball_flag.", wooriball_flag=".$wooriball_flag.", ball_flag=".$ball_flag.",is_print=".$is_print.", rate=".$rate.", rate2=".$rate2.", is_adh=".$is_adh.
            " where uid='".$uid."'";
        return $this->db->exeSql($sql);
    }

    function modify6($where, $bank_name, $bank_account, $bank_member, $recommend_sn, $mem_lev,
                     $email, $phone, $memo, $uid, $memberStatus, $exchangePwd, $recommendSn='',
                     $nick, $balance_flag, $powerball_flag, $wooriball_flag, $ball_flag,
                     $is_print, $rate, $rate2, $is_adh, $is_recommender, $upbet_rate, $is_mix, $sortie)
    {
        //뱅킹 정보 변경시 업데이트를 위해 데이터 변경을 확인한다.
        $bank_account = str_replace('&', '', $bank_account);
        $rs = $this->getById($uid);
        if(Trim($rs['bank_name'])!=Trim($bank_name) ||
            Trim($rs['bank_account'])!=Trim($bank_account) ||
            Trim($rs['bank_member'])!=Trim($bank_member) )
        {
            $sql = "insert into ".$this->db_qz."member_bank(member_sn, bank_name, bank_account, bank_member, regdate, strIP, logo)
							values(".$rs['sn'].",'".$bank_name."','".$bank_account."','".$bank_member."', now(), '".$_SESSION["member"]["ip"]."', '".$this->logo."')";
            $this->db->exeSql($sql);
        }

        $set="";
        if($recommendSn!="")
        {
            $levelModel = Lemon_Instance::getObject("LevelCodeModel",true);
            $levelCode = $levelModel->makeMemberLevelCode($recommendSn);
            $set.="recommend_sn='".$recommendSn."', level_code='".$levelCode."',";
        }

        if ( trim($recommend_sn) > 0 ) {
            $set .= "recommend_sn='".$recommend_sn."',";
        }

        //-> 해킹방지 bank 정보 업데이트 불가능.
        //$where = str_replace("bank_","",$where);
        $sql = "update ".$this->db_qz."member 
						set ".$where.", nick='".$nick."', phone='".$phone."', mem_lev='".$mem_lev."', 
						email='".$email."', ".$set." memo='".$memo."', mem_status='".$memberStatus."', exchange_pass='".$exchangePwd."', balance_flag=".$balance_flag.
            "    ,powerball_flag=".$powerball_flag.", wooriball_flag=".$wooriball_flag.", ball_flag=".$ball_flag.",is_print=".$is_print.", rate=".$rate.", rate2=".$rate2.", is_adh=".$is_adh.", is_recommender=".$is_recommender.
            "    ,upbet_rate=".$upbet_rate.", is_mix=".$is_mix.", sortie=".$sortie.
            " where uid='".$uid."'";
        return $this->db->exeSql($sql);
    }

    function modify5($where, $bank_name, $bank_account, $bank_member, $recommend_sn, $mem_lev, $email, $phone, $memo, $uid, $memberStatus,
                     $exchangePwd, $recommendSn='', $nick, $balance_flag, $is_print, $rate, $rate2)
    {
        //뱅킹 정보 변경시 업데이트를 위해 데이터 변경을 확인한다.
        $bank_account = str_replace('&', '', $bank_account);
        $rs = $this->getById($uid);
        if(Trim($rs['bank_name'])!=Trim($bank_name) ||
            Trim($rs['bank_account'])!=Trim($bank_account) ||
            Trim($rs['bank_member'])!=Trim($bank_member) )
        {
            $sql = "insert into ".$this->db_qz."member_bank(member_sn, bank_name, bank_account, bank_member, regdate, strIP, logo)
							values(".$rs['sn'].",'".$bank_name."','".$bank_account."','".$bank_member."', now(), '".$_SESSION["member"]["ip"]."', '".$this->logo."')";
            $this->db->exeSql($sql);
        }

        $set="";
        if($recommendSn!="")
        {
            $levelModel = Lemon_Instance::getObject("LevelCodeModel",true);
            $levelCode = $levelModel->makeMemberLevelCode($recommendSn);
            $set.="recommend_sn='".$recommendSn."', level_code='".$levelCode."',";
        }

        if ( trim($recommend_sn) > 0 ) {
            $set .= "recommend_sn='".$recommend_sn."',";
        }

        //-> 해킹방지 bank 정보 업데이트 불가능.
        //$where = str_replace("bank_","",$where);
        $sql = "update ".$this->db_qz."member 
						set ".$where.", nick='".$nick."', phone='".$phone."', mem_lev='".$mem_lev."', 
						email='".$email."', ".$set." memo='".$memo."', mem_status='".$memberStatus."', exchange_pass='".$exchangePwd."', balance_flag=".$balance_flag.
            "    , is_print=".$is_print.", rate=".$rate.", rate2=".$rate2.
            " where uid='".$uid."'";
        return $this->db->exeSql($sql);
    }

    function modifyMember2($sn)
    {
        if ( $this->req->request('u_name') ) {
            $data['name'] = $this->req->request('u_name');
        }
        if ( $this->req->request('newpass') ) {
            $data['upass'] = $this->req->request('newpass');
        }
        if ( $this->req->request('phone') ) {
            $data['phone'] = $this->req->request('phone');
        }

        $where = "sn=".$sn;
        $this->db->setUpdate($this->db_qz.'member', $data, $where);
        $this->db->exeSql();
    }

    function modifyMemberExchangePass($sn)
    {
        if ( $this->req->request('new_exchange_pass') ) {
            $data['exchange_pass'] = $this->req->request('new_exchange_pass');
        }

        $where = "sn=".$sn;

        $this->db->setUpdate($this->db_qz.'member', $data, $where);

        $this->db->exeSql();
    }

    function getJoinerRate($member_sn, $is_single)
    {
        $sql = "select m.rate, m.rate2 
                from tb_member m, tb_join_recommend r
                where m.sn = r.recommend_sn and r.member_sn=".$member_sn;
        $rs = $this->db->exeSql($sql);


        $result = 0;
        if($is_single == 1)
        {
            $result = $rs== null? 0 : $rs[0]['rate'];
        } else {
            $result = $rs== null? 0 : $rs[0]['rate2'];
        }

        return $result;
	}

    //▶ 온라인회원입금 총합
    function getOnlineMemberChargeTotal($storeSn, $startDate="", $endDate="", $where="")
    {
        $sql = "select count(*) as cnt, sum(agree_amount) as sum_amount
                    from ".$this->db_qz."charge_log a,".$this->db_qz."member b
                    where a.member_sn=b.sn and b.recommend_sn='".$storeSn."' and a.regdate between '".$startDate." 00:00:00' and '".$endDate." 23:59:59'".$where;
        $rs = $this->db->exeSql($sql);
        return $rs[0];
    }

    //▶ 온라인회원입금 목록
    function getOnlineMemberChargeList($storeSn, $startDate="", $endDate="", $where="", $page=0, $page_size=0)
    {
        if($page_size > 0)
            $limit = " limit ".$page.",".$page_size;

        $sql = "select a.sn, a.regdate, a.operdate, a.member_sn, a.amount, a.agree_amount, a.before_money, a.after_money, a.bonus,a.bank_owner, a.state, a.note,
						b.uid, b.nick, b.g_money, b.bank_member 
						from ".$this->db_qz."charge_log a,".$this->db_qz."member b
						where a.member_sn=b.sn and b.recommend_sn='".$storeSn."' and a.regdate between '".$startDate." 00:00:00' and '".$endDate." 23:59:59' ".$where."
                        order by a.regdate desc ".$limit;
        return $this->db->exeSql($sql);
    }

    function getOnlineMemberExchangeTotal($storeSn, $startDate="", $endDate="", $where)
    {
        $sql = "select count(*) as cnt, sum(agree_amount) as sum_amount
						from ".$this->db_qz."exchange_log a,".$this->db_qz."member b 
						where a.member_sn=b.sn and b.recommend_sn='".$storeSn."' and a.regdate between '".$startDate." 00:00:00' and '".$endDate." 23:59:59'".$where;
        $rs = $this->db->exeSql($sql);
        return $rs[0];
    }

    //▶ 온라인회원출금목록
    function getOnlineMemberExchangeList($storeSn, $startDate="", $endDate="", $where="", $page=0, $page_size=0)
    {
        if($page_size > 0)
            $limit = " limit ".$page.",".$page_size;

        $sql = "select a.sn, a.regdate, a.operdate, a.member_sn, a.amount, a.agree_amount, a.before_money, a.after_money, a.bank_owner, a.state,
						b.uid, b.nick, b.g_money, b.bank_member
						from ".$this->db_qz."exchange_log a,".$this->db_qz."member b 
                        where a.member_sn=b.sn and b.recommend_sn='".$storeSn."' and a.regdate between '".$startDate." 00:00:00' and '".$endDate." 23:59:59' ".$where." order by a.regdate desc ".$limit;
                        
        return $this->db->exeSql($sql);
    }

    function getParentRate($member_sn)
    {
        $sql = "select m.recommend_sn, r.*
                from tb_member m, tb_recommend r
                where m.sn=".$member_sn." and m.recommend_sn = r.Idx;";
        $rs = $this->db->exeSql($sql);
        return $rs[0];
    }

    function getStoreRate($member_sn)
    {
        $sql = "select m.rate, m.rate2
                from tb_member m, tb_join_recommend r
                where r.member_sn=".$member_sn." and m.sn = r.recommend_sn;";
        $rs = $this->db->exeSql($sql);
        return $rs[0];
    }


    function getStoreSn($member_sn)
    {
        $sql = "select m.sn
                from tb_member m, tb_join_recommend r
                where r.member_sn=".$member_sn." and m.sn = r.recommend_sn;";
        $rs = $this->db->exeSql($sql);
        return $rs[0]['sn'];
    }

    //▶ 미니게임 레벨 목록
    function getBetMoneyConfig($field, $keyword, $is_store)
    {
        $sql = "select m.sn, m.uid, m1.* 
                from tb_member m, tb_member_config m1
                where m.is_store={$is_store} and m.sn = m1.member_sn and mem_status in ('N', 'G', 'W')";

        if($field == "mem_id")
        {
            $sql .= " and m.uid like '%" . $keyword . "%'";
        }  elseif ($field == "nick") {
            $sql .= " and m.nick like '%" . $keyword . "%'";
        }

        $rs = $this->db->exeSql($sql);
        return $rs;
    }

    function getMemberOddConfig($field, $keyword, $is_store)
    {
        $sql = "select m.sn, m.uid, m1.* 
                from tb_member m, tb_member_odd m1
                where m.is_store={$is_store} and m.sn = m1.member_sn and mem_status in ('N', 'G', 'W')";

        if($field == "mem_id")
        {
            $sql .= " and m.uid like '%" . $keyword . "%'";
        }  elseif ($field == "nick") {
            $sql .= " and m.nick like '%" . $keyword . "%'";
        }

        $rs = $this->db->exeSql($sql);
        return $rs;
    }

    //▶ 미니게임 레벨 목록
    function getChildBetMoneyConfig($store_sn)
    {
        $sql = "select m.sn, m.uid, m1.* 
                from tb_member m, tb_member_config m1, tb_join_recommend a
                where m.is_store=0 and m.sn = m1.member_sn and a.member_sn = m.sn and a.recommend_sn=".$store_sn;
        $rs = $this->db->exeSql($sql);
        return $rs;
    }

    function getChildBetOddConfig($store_sn)
    {
        $sql = "select m.sn, m.uid, m1.* 
                from tb_member m, tb_member_odd m1, tb_join_recommend a
                where m.is_store=0 and m.sn = m1.member_sn and a.member_sn = m.sn and a.recommend_sn=".$store_sn;
        $rs = $this->db->exeSql($sql);
        return $rs;
    }

    function savePointConfigMiniGame($sn,$powerball_max, $p_odd,$p_even,$p_under,$p_over,
                                     $p_odd_under_max,$p_odd_over_max,
                                     $p_even_under_max,$p_even_over_max,
                                     $ball_max, $odd,$even,$under, $over,$odd_under,$odd_over,
                                     $even_under,$even_over, $large, $middle, $small,
                                     $odd_large, $odd_middle, $odd_small, $even_large, $even_middle, $even_small,
                                     $wooriball_max, $w_power_max, $w_ball_max,
                                     $w_pb_tie_max, $w_dragon_max, $w_dt_tie_max, $w_tiger_max)
    {
        $sql = "update tb_member_config set 
						powerball_max={$powerball_max}, p_odd_max = {$p_odd}, p_even_max = {$p_even}, p_under_max = {$p_under}, p_over_max = {$p_over},
						p_odd_under_max = {$p_odd_under_max}, p_odd_over_max = {$p_odd_over_max},
						p_even_under_max = {$p_even_under_max}, p_even_over_max = {$p_even_over_max}, 
						ball_max={$ball_max}, odd_max = {$odd}, even_max = {$even}, under_max = {$under},
						over_max = {$over}, odd_under = {$odd_under}, odd_over = {$odd_over},
						even_under = {$even_under}, even_over = {$even_over},
						large = {$large}, middle = {$middle}, small = {$small},
						odd_large = {$odd_large}, odd_middle = {$odd_middle}, odd_small = {$odd_small},
						even_large = {$even_large}, even_middle = {$even_middle}, even_small = {$even_small},
						wooriball_max = {$wooriball_max}, w_power_max = {$w_power_max}, w_ball_max = {$w_ball_max},
						w_pb_tie_max = {$w_pb_tie_max}, w_dragon_max = {$w_dragon_max}, w_dt_tie_max = {$w_dt_tie_max}, 
						w_tiger_max = {$w_tiger_max}
						where sn = {$sn}";
        return $this->db->exeSql($sql);
    }

    function saveMiniGameOdd($sn,$p_odd,$p_even,$p_under,$p_over, $p_odd_under,$p_odd_over,
                             $p_even_under,$p_even_over,
                             $odd,$even,$under, $over,$odd_under,$odd_over,
                                 $even_under,$even_over, $large, $middle, $small,
                                 $odd_large, $odd_middle, $odd_small, $even_large, $even_middle, $even_small,
                                 $w_power, $w_ball, $w_pb_tie, $w_dragon, $w_dt_tie, $w_tiger)
    {
        $sql = "update tb_member_odd set 
						p_odd = '{$p_odd}', p_even = '{$p_even}', p_under = '{$p_under}', p_over = '{$p_over}', 
						p_odd_under = '{$p_odd_under}', p_odd_over = '{$p_odd_over}',
						p_even_under = '{$p_even_under}', p_even_over = '{$p_even_over}',
						odd = '{$odd}', even = '{$even}', under = '{$under}',
						over = '{$over}', odd_under = '{$odd_under}', odd_over = '{$odd_over}',
						even_under = '{$even_under}', even_over = '{$even_over}',
						large = '{$large}', middle = '{$middle}', small = '{$small}',
						odd_large = '{$odd_large}', odd_middle = '{$odd_middle}', odd_small = '{$odd_small}',
						even_large = '{$even_large}', even_middle = '{$even_middle}', even_small = '{$even_small}',
						w_power = '{$w_power}', w_ball = '{$w_ball}',
						w_pb_tie = '{$w_pb_tie}', w_dragon = '{$w_dragon}', w_dt_tie = '{$w_dt_tie}', 
						w_tiger = '{$w_tiger}'
						where sn = {$sn}";
        return $this->db->exeSql($sql);
    }

    //▶ 멤버레벨 미니게임
    function getMemberConfig($member_sn) {
        $where = "member_sn = ".$member_sn;
        return $this->getRow("*", "tb_member_config", $where);
    }

    /*function getMembeOdd($member_sn) {
        $where = "member_sn = ".$member_sn;
        return $this->getRow("*", "tb_member_odd", $where);
    }*/
    /*function getMembeOdd($member_sn) {
        $sql = "select r3.rec_id, m.uid, ro.* from tb_member m, tb_recommend r1, tb_recommend r2, tb_recommend r3, tb_recommend_odd ro
            where m.sn = ".$member_sn." and m.recommend_sn = r1.Idx
            and r1.rec_parent_id = r2.rec_id
            and r2.rec_parent_id = r3.rec_id
            and r3.Idx = ro.rec_sn ";

        $rs = $this->db->exeSql($sql);

        return $rs[0];
    }*/

    function getMembeOdd($member_sn, $is_store) {
        $sql = "select * from tb_member_odd 
            where member_sn = ".$member_sn;

        if($is_store == 0)
        {
            $sql = "select o.* 
                from tb_join_recommend r, tb_member m, tb_member_odd o
                where r.member_sn=".$member_sn." 
                and r.recommend_sn=m.sn
                and m.sn=o.member_sn";
        }

        $rs = $this->db->exeSql($sql);

        return $rs[0];
    }

    function getTexDataTotal($store_sn, $startDate, $endDate) {
        $sql = "select count(*)  as cnt from (select a.rec_sn_top
						from ".$this->db_qz."recommend_tex a, ".$this->db_qz."member b
							where b.is_store=1 and a.rec_sn = b.sn and (get_tex_money > 0 or money_to_exchange > 0 or money_to_charge > 0) ";

        if($store_sn != null && $store_sn != '')
        {
            $sql .= "and b.sn = {$store_sn} ";
        }

        if($startDate != null && $startDate != '')
        {
            $sql .= "and a.regdate > '{$startDate} 00:00:00' ";
        }

        if($endDate != null && $endDate != '')
        {
            $sql .= "and a.regdate < '{$endDate} 23:59:59' ";
        }

        $sql .=" ) a";

        $rs = $this->db->exeSql($sql);
        return $rs[0]['cnt'];
    }

    function getTexDataList($rec_sn, $startDate, $endDate, $page, $page_size) {
        $sql = "select a.*, b.g_money as rec_money from ".$this->db_qz."recommend_tex a, ".$this->db_qz."member b
							where b.is_store=1 and a.rec_sn = b.sn and (get_tex_money > 0 or money_to_exchange > 0 or money_to_charge > 0) ";

        if($rec_sn != null && $rec_sn != '') {
            $sql .= " and b.sn = {$rec_sn} ";
        }

        if($startDate != null && $startDate != '')
        {
            $sql .= "and a.regdate > '{$startDate} 00:00:00' ";
        }

        if($endDate != null && $endDate != '')
        {
            $sql .= "and a.regdate < '{$endDate} 23:59:59' ";
        }

        $sql .= " order by a.regdate desc limit  ".$page.",".$page_size;
        return $this->db->exeSql($sql);
    }

    function getStoreChargeSum($storeSn, $startDate="", $endDate="", $where="")
    {
        $sql = "select count(*) as cnt, sum(agree_amount) as sum_amount
						from ".$this->db_qz."charge_log a,".$this->db_qz."member b, ".$this->db_qz."join_recommend c 
						where a.member_sn=b.sn and b.sn = c.member_sn";
        if($storeSn != '')
        {
            $sql.=" and c.recommend_sn='".$storeSn."' ";
        }

        if($startDate != '')
        {
            $sql .= " and a.regdate >= '".$startDate." 00:00:00'";
        }

        if($endDate != '')
        {
            $sql .= " and a.regdate <= '".$endDate." 23:59:59'";
        }

        $sql .= $where;
        $rs = $this->db->exeSql($sql);
        return $rs[0];
    }

    function getStoreExchangeSum($storeSn, $startDate="", $endDate="", $where)
    {
        $sql = "select count(*) as cnt, sum(agree_amount) as sum_amount
						from ".$this->db_qz."exchange_log a,".$this->db_qz."member b, ".$this->db_qz."join_recommend c
						where a.member_sn=b.sn and b.sn = c.member_sn ";
        if($storeSn != '')
        {
            $sql.=" and c.recommend_sn='".$storeSn."' ";
        }

        if($startDate != '')
        {
            $sql .= " and a.regdate >= '".$startDate." 00:00:00'";
        }

        if($endDate != '')
        {
            $sql .= " and a.regdate <= '".$endDate." 23:59:59'";
        }

        $sql .= $where;
        $rs = $this->db->exeSql($sql);
        return $rs[0];
    }

    function getTexDataListSum($rec_sn, $startDate, $endDate) {
        $sql = "select   	sum(a.money_to_charge) as money_to_charge,
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
							sum(a.tex_money2) as tex_money2,
							sum(a.get_tex_money2) as get_tex_money2
				from " . $this->db_qz . "recommend_tex a, " . $this->db_qz . "member b, ".$this->db_qz."join_recommend c
				where a.rec_sn = b.sn and b.sn=c.member_sn";

        if($rec_sn != null && $rec_sn != '') {
            $sql .= "	and b.sn = {$rec_sn} ";
        }

        if($startDate != null && $startDate != '')
        {
            $sql .= " and a.regdate > '{$startDate} 00:00:00' ";
        }

        if($endDate != null && $endDate != '')
        {
            $sql .= " and a.regdate < '{$endDate} 23:59:59' ";
        }

        $rs = $this->db->exeSql($sql);

        return $rs[0];
    }

    function getTexDataPartnerTotal($recommendSn = 0, $startDate = "", $endDate = "") {
        $sql = "select count(*) cnt, sum(money_to_charge) as money_to_charge, 
					   sum(money_to_exchange) as money_to_exchange,
					   sum(betting_to_win_mgame) as betting_to_win_mgame, 
					   sum(betting_to_lose_mgame) as betting_to_lose_mgame,
					   sum(result_to_win_mgame) as 	result_to_win_mgame,
					   sum(betting_to_ready) as 	betting_to_ready,
					   sum(get_tex_money) as get_tex_money,
					   sum(get_tex_money2) as get_tex_money2
				from ".$this->db_qz."recommend_tex
						where rec_sn = '".$recommendSn."' and  (betting_to_ready > 0 or money_to_charge > 0 or money_to_exchange > 0 or betting_to_win_mgame > 0 or betting_to_lose_mgame > 0) and regdate between '".$startDate." 00:00:00' and '".$endDate." 23:59:59'";
        $rs = $this->db->exeSql($sql);
        return $rs[0];
    }

    function getTexDataPartner3($recommendSn = 0, $startDate = "", $endDate = "", $page=0, $page_size=0) {
        if($page_size > 0)
            $limit = " limit ".$page.",".$page_size;

        $sql = "select * from ".$this->db_qz."recommend_tex
						where rec_sn = '".$recommendSn."' and  (betting_to_ready > 0 or money_to_charge > 0 or money_to_exchange > 0 or betting_to_win_mgame > 0 or betting_to_lose_mgame > 0) and regdate between '".$startDate." 00:00:00' and '".$endDate." 23:59:59' 
						order by regdate desc".$limit;
        return $this->db->exeSql($sql);
    }

    function getTexDataPartner4($recommendSn = 0, $startDate = "", $endDate = "", $page=0, $page_size=0) {
        $sql = "select regdate,
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
						where rec_sn_store = '".$recommendSn."' and regdate between '".$startDate." 00:00:00' and '".$endDate." 23:59:59' 
                        group by regdates order by regdate asc";
        
		return $this->db->exeSql($sql);
    }

    //-> mg. 관리자가 정산금 관련해서 데이터를 조회	
	function getTexData($texDate = "", $startDate = "", $endDate = "") {
		if ( strlen($texDate) > 1 ) {
			$sql = "select a.*, b.g_money, b.uid from ".$this->db_qz."recommend_tex a, ".$this->db_qz."member b
							where a.rec_sn_store = b.sn and a.regdate between '".$texDate." 00:00:00' and '".$texDate." 23:59:59' 
							order by a.rec_id_store asc";
			return $this->db->exeSql($sql);
		} else if ( strlen($startDate) > 1 and strlen($endDate) > 1 ) {
			$sql = "select
                                b.g_money,
                                b.uid,
								a.rec_sn_store,
								a.rec_id_store,
								a.save_rate_type,
								a.save_rate_store,
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
								sum(a.tex_money_store) as tex_money,
								sum(a.get_tex_money_store) as get_tex_money,
								sum(a.betting_to_ready) as betting_to_ready
							from ".$this->db_qz."recommend_tex a, ".$this->db_qz."member b
							where a.rec_sn_store = b.sn and a.regdate between '".$startDate." 00:00:00' and '".$endDate." 23:59:59' 
							group by a.rec_sn_store order by a.rec_id_store asc";
			return $this->db->exeSql($sql);
		}
	}

    function getPartnerList2($beginDate, $endDate)
    {
        $field = 'rec_parent_id';
        $sql = "select r2.rec_id as ttop_id, r1.rec_id as top_id, r1.Idx as top_sn from tb_recommend r1, tb_recommend r2 
                where r1.`status` != 2 and r1.rec_lev=1 and r1.rec_parent_id = r2.rec_id;";

        $rs = $this->db->exeSql($sql);

        for($i=0; $i<count((array)$rs); ++$i)
        {
            $recommend_id = $rs[$i]['top_id'];
            $recommend_sn = $rs[$i]['top_sn'];

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


            $rsi = $this->getRecommenderList($recommend_sn, '',  $beginDate, $endDate);
            $rs[$i]['item'] = $rsi;
        }
        return $rs;
    }

    function modifyRecommend($sn, $status)
    {
        $sql = "update ".$this->db_qz."member 
						set is_recommender=".$status." where sn=".$sn;

        return $this->db->exeSql($sql);
    }

    function modifyRecommendRate($mem_sn, $recommend_limit, $join_recommend_mileage_rate_type, $join_recommend_mileage_rate)
    {
        $sql = "update ".$this->db_qz."member 
							set recommend_limit={$recommend_limit}, join_recommend_mileage_rate_type='{$join_recommend_mileage_rate_type}', join_recommend_mileage_rate={$join_recommend_mileage_rate}   
				where sn=".$mem_sn;

        return $this->db->exeSql($sql);
    }

    function getRecommenderList($recommender_sn, $beginDate, $endDate)
    {
        $sql = "select p2.rec_id as ttop_id, p.rec_id as top_id, m.sn as mem_sn, m.uid, m.nick, m.mem_lev, m.is_recommender, l.lev_name, m.recommend_limit, m.join_recommend_mileage_rate_type, m.join_recommend_mileage_rate    
                from tb_member m, tb_level_config l, tb_recommend p, tb_recommend p2
                where m.sn in (select recommend_sn from tb_join_recommend group by recommend_sn) 
                and m.recommend_sn = p.Idx and p.rec_parent_id=p2.rec_id and m.mem_lev=l.lev order by m.uid;";

        if($recommender_sn != null && $recommender_sn != '')
        {
            $sql = "select p2.rec_id as ttop_id, p.rec_id as top_id, m.sn as mem_sn, m.uid, m.nick, m.mem_lev, m.is_recommender, l.lev_name, m.recommend_limit, m.join_recommend_mileage_rate_type, m.join_recommend_mileage_rate    
                from tb_member m, tb_level_config l, tb_recommend p, tb_recommend p2 
                where m.sn in (select member_sn from tb_join_recommend where recommend_sn={$recommender_sn})
                and m.recommend_sn = p.Idx and p.rec_parent_id=p2.rec_id and m.mem_lev=l.lev order by m.uid;";
        }

        $rs = $this->db->exeSql($sql);

        for($i=0; $i<count((array)$rs); ++$i)
        {
            $member_sn = $rs[$i]['mem_sn'];
            //배팅금액, 당첨금액 스포츠
            $sql = "select sum(betting_money) as total_betting, sum(result_money) as total_result
					from ".$this->db_qz."game_cart where member_sn = {$member_sn} and (last_special_code < 5 or last_special_code=50)";

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
                    from ".$this->db_qz."game_cart where member_sn = {$member_sn} and (last_special_code > 4 and last_special_code!=50) ";

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

            $sql = "select sum(amount) as join_mileage_amount from tb_mileage_log where member_sn = {$member_sn} and state = 12";
            if($beginDate != '')
            {
                $sql.=" and regdate >= '".$beginDate." 00:00:00' ";
            }

            if($endDate != '')
            {
                $sql.=" and regdate <= '".$endDate." 23:59:59' ";
            }
            $rsi = $this->db->exeSql($sql);
            $rs[$i]['join_mileage_amount'] = $rsi[0]['join_mileage_amount'] == null || $rsi[0]['join_mileage_amount'] == '' ? 0 : $rsi[0]['join_mileage_amount'] ;

            /*$array = explode(':', $rs[$i]['lev_join_recommend_mileage_rate']);

            $rs[$i]['lev_join_recommend_mileage_rate_1'] = $array[0];
            $rs[$i]['lev_join_recommend_mileage_rate_2'] = $array[1];
            $rs[$i]['lev_join_recommend_mileage_rate_3'] = $array[2];*/

            if($recommender_sn == null || $recommender_sn == '')
            {
                $rsi = $this->getRecommenderList($member_sn,  $beginDate, $endDate);
                $rs[$i]['item'] = $rsi;
            }
        }
        return $rs;
    }

    function getNewMemberCount($beginDate='', $endDate='')
    {
        $sql = "select count(sn) as member_count
                from tb_member 
                where (mem_status='N' or mem_status='W') and regdate > '$beginDate' and regdate < '$endDate}3'";

        $rs = $this->db->exeSql($sql);
        return $rs[0]['member_count'];
    }

    function getVisitCount($beginDate='', $endDate='')
    {
        $sql = "select count(idx) as visit_count
                from tb_visit 
                where visit_date > '$beginDate' and visit_date < '$endDate}3'";

        $rs = $this->db->exeSql($sql);
        return $rs[0]['visit_count'];
    }

    function getTelegramID() {
        $sql = "SELECT telegram_id from tb_telegram";
        $rs = $this->db->exeSql($sql);

        $telegramID = "";

        if(count((array)$rs) > 0)
            $telegramID = $rs[0]['telegram_id'];

        return $telegramID;
    }

    function insertTelegramID($telegram_id = "") {
        $sql = "SELECT id from tb_telegram";
        $rs = $this->db->exeSql($sql);

        if(count((array)$rs) > 0) {
            $sql = "UPDATE tb_telegram SET telegram_id = '" . $telegram_id . "' WHERE id = " . $rs[0]["id"];
        } else {
            $sql = "INSERT INTO tb_telegram (telegram_id) VALUES ('" . $telegram_id . "')";
        }
        
        $this->db->exeSql($sql);
    }

    function getKakaoID() {
        $sql = "SELECT kakao_id from tb_kakao";
        $rs = $this->db->exeSql($sql);

        $kakaoID = "";

        if(count((array)$rs) > 0)
            $kakaoID = $rs[0]['kakao_id'];

        return $kakaoID;
    }

    function insertKakaoID($kakao_id = "") {
        $sql = "SELECT id from tb_kakao";
        $rs = $this->db->exeSql($sql);

        if(count((array)$rs) > 0) {
            $sql = "UPDATE tb_kakao SET kakao_id = '" . $kakao_id . "' WHERE id = " . $rs[0]["id"];
        } else {
            $sql = "INSERT INTO tb_kakao (kakao_id) VALUES ('" . $kakao_id . "')";
        }
        
        $this->db->exeSql($sql);
    }

    // 고객센터 답변 알람개수 갱신
    function updateCustomerAnswerFlag($uid) {
        $sql = "UPDATE tb_member SET customer_answer_flag = 0 WHERE uid = '" . $uid . "'";
        $this->db->exeSql($sql);
    }

    function getUserBettingList($subChildSn = 0) {
        $sql = "SELECT
                    tb_game_betting.`betting_no`,
                    tb_game_betting.bet_money,
                    tb_member.`sn`,
                    tb_member.`uid`
                FROM
                    tb_game_betting
                    LEFT JOIN tb_member
                    ON tb_game_betting.member_sn = tb_member.sn
                WHERE tb_game_betting.`sub_child_sn` = " . $subChildSn;

        $rs = $this->db->exeSql($sql);

        return $rs;
    }

    function checkDuplicatedID($userid = "") {
        $sql = "SELECT uid FROM tb_member WHERE uid LIKE '" . $userid . "'";
        $rs = $this->db->exeSql($sql);
        $status = 1;
        if(count((array)$rs) > 0) {
            $status = 0;
        }
        return $status;
    }

    function checkDuplicatedNickName($nick = "") {
        $sql = "SELECT nick FROM tb_member WHERE nick LIKE '" . $nick . "'";
        $rs = $this->db->exeSql($sql);
        $status = 1;
        if(count((array)$rs) > 0) {
            $status = 0;
        }
        return $status;
    }

    function insertPhoneInfo($receiver = "", $verification_code = "") {
        $sql = "SELECT * FROM tb_sms WHERE phone LIKE '" . $receiver . "'";
        $rs = $this->db->exeSql($sql);

        if(count((array)$rs) == 0) {
            $sql = "INSERT INTO tb_sms (phone, code, time) VALUES ('" . $receiver . "', '" . $verification_code . "', NOW())";       
        } else {
            $sql = "UPDATE tb_sms SET code = '" . $verification_code . "', count = 0, status = 0 WHERE phone LIKE '" . $receiver . "'";
        }

        $rs = $this->db->exeSql($sql);

        return $rs;
    }

    function checkPhoneNumberUsed($phone_num = "") {
        $sql = "SELECT phone FROM tb_member WHERE phone LIKE '" . $phone_num . "'";
        $rs = $this->db->exeSql($sql);
        $loginUsed = 0;
        if(count((array)$rs) > 0) 
            $loginUsed = 1;
        else {
            $sql = "DELETE FROM tb_sms WHERE phone LIKE '" . $phone_num . "'";
            $this->db->exeSql($sql);
        }
            
        return $loginUsed;
    }

    function compareCheckCode($phone_num = "", $check_code = "") {
        $sql = "SELECT status FROM tb_sms WHERE phone LIKE '" . $phone_num . "' AND code LIKE '" . $check_code . "'";
        $rs = $this->db->exeSql($sql);

        $status = 0;
        if(count((array)$rs) > 0) {
            $sql = "UPDATE tb_sms SET status = 1 WHERE phone LIKE '" . $phone_num . "' AND code LIKE '" . $check_code . "'";
            $status = 1;
        } else {
            $sql = "UPDATE tb_sms SET count = count + 1 WHERE phone LIKE '" . $phone_num . "'";
            $status = 0;
        }

        $this->db->exeSql($sql);

        return $status;
    }

    function getCheckCnt($phone_num = "") {
        $sql = "SELECT tb_sms.`count` AS cnt FROM tb_sms WHERE phone LIKE '" . $phone_num . "'";
        $rs = $this->db->exeSql($sql);
        $count = 0;
        if(count((array)$rs) > 0) {
            $count = $rs[0]["cnt"];
        }
        return $count;
    }

    function checkPhoneNumberVerification($phone_num = "") {
        $sql = "SELECT status FROM tb_sms WHERE phone LIKE '" . $phone_num . "'";
        $rs = $this->db->exeSql($sql);
        $status = 0;
        if(count((array)$rs) > 0) {
            $status = $rs[0]["status"];
        }
        return $status;
    }
}
?>