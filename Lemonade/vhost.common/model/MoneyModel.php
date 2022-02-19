<?php
/*
	Charge, Exchange, Logs
*/
class MoneyModel extends Lemon_Model
{
	//▶ 멤버의  환전한  총머니
	function getMemberExchangeMoney($memberSn)
	{
		$sql = "select sum(agree_amount) as total from ".$this->db_qz."exchange_log
					where state=1 and member_sn=".$memberSn;
					
		$rs	= $this->db->exeSql($sql);
		return $rs[0]['total'];
	}
	
	//▶ 멤버의  충전한 총머니
	function getMemberChargeMoney($memberSn)
	{
		$sql = "select sum(agree_amount) as total from ".$this->db_qz."charge_log
					where state=1 and member_sn=".$memberSn;
					
		$rs	= $this->db->exeSql($sql);
		return $rs[0]['total'];
	}
	
	function getExchangeList($state="", $readCheck="", $where="", $page=0, $page_size=0, $orderby="a.regdate desc")
	{
		if($state!="")	
			$where.= " and a.state=".$state;
			
		if($page_size > 0)
			$limit = " limit ".$page.",".$page_size;
/*
		$sql = "select a.sn, a.regdate, a.operdate, a.member_sn, a.amount, a.agree_amount, a.before_money, a.after_money, a.bank, a.bank_account, a.bank_owner, a.state, a.logo,
						(select count(*) from ".$this->db_qz."exchange_log where state=1 and member_sn=a.member_sn and DATE_FORMAT(regdate,'%Y-%m-%d')=DATE_FORMAT(now(),'%Y-%m-%d')) as todaycount,
						(select count(*) from ".$this->db_qz."exchange_log where state=1 and member_sn=a.member_sn) as totalcount,
						(select count(*) from ".$this->db_qz."people_bank where member_sn=b.sn) as bank_count,
						b.uid, b.nick, b.g_money, b.bank_member,
						ifnull(c.rec_id, '무소속') as recommendId
						from ".$this->db_qz."exchange_log a,".$this->db_qz."people b left outer join ".$this->db_qz."recommend c on b.recommend_sn=c.idx
						where a.member_sn=b.sn".$where."
						order by a.regdate desc ".$limit;
*/
		$sql = "select a.sn, a.regdate, a.operdate, a.member_sn, a.amount, a.agree_amount, a.before_money, a.after_money, a.bank, a.bank_account, a.bank_owner, a.state, a.logo,
						b.uid, b.nick, b.g_money, b.bank_member, b.mem_lev,
						ifnull(c.rec_id, '무소속') as recommendId
						from ".$this->db_qz."exchange_log a,".$this->db_qz."people b left outer join ".$this->db_qz."recommend c on b.recommend_sn=c.idx
						where a.member_sn=b.sn".$where."
						order by {$orderby} ".$limit;
		$rs = $this->db->exeSql($sql);
		
		if($readCheck!="")
		{
			if(is_array($rs) && count($rs) > 0) {
				for($i=0; $i<count($rs); ++$i)
				{
					$sql = "update ".$this->db_qz."exchange_log set is_read=1
									where sn=".$rs[$i]['sn'];
					$this->db->exeSql($sql);
				}
			}
		}

		return $rs;
	}
	
	//▶ 환전 총합-전체
	function getExchangeTotal($state="", $where="")
	{
		if($state!="") $where.= " and a.state=".$state;
		
		$sql = "select count(*) as cnt
						from ".$this->db_qz."exchange_log a,".$this->db_qz."people b left outer join ".$this->db_qz."recommend c on b.recommend_sn=c.idx
						where a.member_sn=b.sn ".$where;
				
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 환전 상태값
	function getExchangeState($sn)
	{
		$sql = "select state from ".$this->db_qz."exchange_log where sn=".$sn;
		$rs	= $this->db->exeSql($sql);
		return $rs[0]['state'];
	}
	
	//▶ 충전 상태값
	function getChargeState($sn)
	{
		$sql = "select state from ".$this->db_qz."charge_log where sn=".$sn;
		$rs	= $this->db->exeSql($sql);
		return $rs[0]['state'];
	}
	
	//▶ 금일 충전한 총머니
	function getTodayCharge($memberSn)
	{
		$sql = "select sum(amount) as total from ".$this->db_qz."charge_log
					where state=1 and member_sn=".$memberSn;
					
		$rs	= $this->db->exeSql($sql);
		return $rs[0]['total'];
	}
	
	//▶ 금일 충전한 총머니
	function getTodayTotalCharge($where='')
	{
		$sql = "select ifnull(sum(amount),0) as total from ".$this->db_qz."charge_log
					where state=1 and DATE_FORMAT(operdate,'%Y-%m-%d')=DATE_FORMAT(now(),'%Y-%m-%d')".$where;
					
		$rs	= $this->db->exeSql($sql);
		return $rs[0]['total'];
	}
	
	//▶ 금일 환전한 총머니
	function getTodayTotalExchange($where='')
	{
		$sql = "select ifnull(sum(amount),0) as total from ".$this->db_qz."exchange_log
					where state=1 and DATE_FORMAT(operdate,'%Y-%m-%d')=DATE_FORMAT(now(),'%Y-%m-%d')".$where;
					
		$rs	= $this->db->exeSql($sql);
		return $rs[0]['total'];
	}
	
	//▶ 충전 목록-전체
	function getChargeList($state="", $readCheck="", $where="", $page=0, $page_size=0)
	{
	    $logo = $this->logo;

		if($state!="")	
			$where.= " and a.state=".$state;
			
		if($page_size > 0)
			$limit = " limit ".$page.",".$page_size;
/*
		$sql = "select a.sn, a.regdate, a.operdate, a.member_sn, a.amount, a.agree_amount, a.before_money, a.after_money, a.bonus,a.bank_owner, a.state, a.logo,
							(select count(*) from ".$this->db_qz."charge_log where state=1 and member_sn=a.member_sn and DATE_FORMAT(regdate,'%Y-%m-%d')=DATE_FORMAT(now(),'%Y-%m-%d')) as todaycount,
							(select count(*) from ".$this->db_qz."charge_log where state=1 and member_sn=a.member_sn) as totalcount,
							(select lev_name from ".$this->db_qz."level_config where lev=(select mem_lev from ".$this->db_qz."people where sn=a.member_sn)) as mem_lev,
							b.uid, b.nick, b.g_money, b.bank_member, b.bank_name,
							ifnull(c.rec_id, '무소속') as recommendId
				from ".$this->db_qz."charge_log a,".$this->db_qz."people b left outer join ".$this->db_qz."recommend c on b.recommend_sn=c.idx
				where a.member_sn=b.sn".$where."
				order by a.regdate desc ".$limit;
*/
		$sql = "select a.sn, a.regdate, a.operdate, a.member_sn, a.amount, a.agree_amount, a.before_money, a.after_money, a.bonus,a.bank_owner, a.state, a.logo,
							(select lev_name from ".$this->db_qz."level_config where lev=(select mem_lev from ".$this->db_qz."people where sn=a.member_sn) and logo ='{$logo}') as mem_lev,
							b.uid, b.nick, b.g_money, b.bank_member, b.bank_name,
							ifnull(c.rec_id, '무소속') as recommendId
				from ".$this->db_qz."charge_log a,".$this->db_qz."people b left outer join ".$this->db_qz."recommend c on b.recommend_sn=c.idx
				where a.member_sn=b.sn".$where."
				order by a.regdate desc ".$limit;
		$rs = $this->db->exeSql($sql);
		
		if($readCheck!='')
		{
			for($i=0; $i<count((array)$rs); ++$i)
			{
				$sql = "update ".$this->db_qz."charge_log set is_read=1
								where sn=".$rs[$i]['sn'];
				$this->db->exeSql($sql);
			}
		}

		return $rs;
	}
	
	//▶ 충전 총합-전체
	function getChargeTotal($state="", $where="")
	{
		if($state!="") $where.= " and a.state=".$state;
		
		$sql = "select count(*) as cnt
				from ".$this->db_qz."charge_log a,".$this->db_qz."people b left outer join ".$this->db_qz."recommend c on b.recommend_sn=c.idx
				where a.member_sn=b.sn".$where;
					
		$rs = $this->db->exeSql($sql);
		
		return $rs[0]['cnt'];
	}

    function getChargeTotal2($beginDate, $endDate)
    {
        $sql = "select count(*) as mem_cnt, IFNULL(sum(amt),0) as amount, IFNULL(sum(cnt),0) as charge_cnt 
				from 	(select member_sn, sum(amount) as amt, count(*) as cnt  
						from tb_charge_log 
							left join tb_people on tb_charge_log.member_sn = tb_people.sn
						where state = 1
							and tb_people.mem_status != 'G'
							and operdate >= '{$beginDate}'
							and operdate <= '{$endDate}' 
						group by member_sn order by member_sn) a";

        $rs = $this->db->exeSql($sql);
        return $rs[0];
    }

    function getExchangeTotal2($beginDate, $endDate)
    {
        $sql = "select count(*) as mem_cnt, IFNULL(sum(amt),0) as amount, IFNULL(sum(cnt),0) as exchange_cnt 
				from (select member_sn, sum(amount) as amt, count(*) as cnt  
					from tb_exchange_log 
						left join tb_people on tb_exchange_log.member_sn = tb_people.sn	
					where state=1
						and tb_people.mem_status != 'G'
						and operdate >= '{$beginDate}'
						and operdate <= '{$endDate}' 
					group by member_sn order by member_sn) a";

        $rs = $this->db->exeSql($sql);
        return $rs[0];
    }

	//▶ 환전 목록-멤버
	function getMemberExchangeList($sn, $state="", $where="", $page=0, $page_size=0)
	{
		$where.= " and a.member_sn=".$sn;
		
		return $this->getExchangeList($state, "", $where, $page, $page_size);
	}
	
	//▶ 환전 총합-멤버
	function getMemberExchangeTotal($sn, $state="", $where="")
	{
		$where.= " and a.member_sn=".$sn;
		
		return $this->getExchangeTotal($state, $where);
	}
	
	//▶ 충전 목록-멤버
	function getMemberChargeList($sn, $state="", $where="", $page=0, $page_size=0)
	{
		$where.= " and a.member_sn=".$sn;
		
		return $this->getChargeList($state, "", $where, $page, $page_size);
	}
	
	//▶ 충전 총합-멤버
	function getMemberChargeTotal($sn, $state="", $where="")
	{
		$where.= " and a.member_sn=".$sn;
		
		return $this->getChargeTotal($state, $where);
	}
	
	//▶ 충전 데이터
	function getChargeRow($sn)
	{
		$sql = "select a.*, b.uid from ".$this->db_qz."charge_log a, ".$this->db_qz."people b where a.member_sn=b.sn and a.sn=".$sn;
		$rs = $this->db->exeSql($sql);
		return $rs[0];
	}
	
	//▶ 충전 데이터
	function getExchangeRow($sn)
	{
		$sql = "select a.*, b.uid from ".$this->db_qz."exchange_log a, ".$this->db_qz."people b where a.member_sn=b.sn and a.sn=".$sn;
		$rs = $this->db->exeSql($sql);
		return $rs[0];
	}
	
	//▶ 충전여부 확인
	function isCharged($sn)
	{
		$sql = "select state from ".$this->db_qz."charge_log where sn=".$sn;
		$rs = $this->db->exeSql($sql);				
		return $rs[0]['state'];
	}
	
	//▶ 머니로그 추가
	function addMoneyLog($memberSn, $amount, $before, $after, $state, $statusMessage, $memo="")
	{
		if($state==4)
		{
			$bettingNo=$statusMessage;
			$statusMessage = "당첨배당금[배팅번호:".$statusMessage."]";
			
			$sql = "insert into ".$this->db_qz."money_log(member_sn,amount,before_money,after_money,regdate,state, status_message, betting_no)
						values(".$memberSn.",".$amount.",".$before.",".$after.",now(),".$state.",'".$statusMessage."','".$bettingNo."')";
		}
		else if($state==5)
		{
			$bettingNo=$statusMessage;
			$statusMessage = "취소";
			
			$sql = "insert into ".$this->db_qz."money_log(member_sn,amount,before_money,after_money,regdate,state, status_message, betting_no)
						values(".$memberSn.",".$amount.",".$before.",".$after.",now(),".$state.",'".$statusMessage."','".$bettingNo."')";
		}
		else if($state==8)
		{
			$bettingNo=$statusMessage;
			$statusMessage = "경기재입력[배팅번호:".$statusMessage."]";
			
			$sql = "insert into ".$this->db_qz."money_log(member_sn,amount,before_money,after_money,regdate,state, status_message, betting_no)
						values(".$memberSn.",".$amount.",".$before.",".$after.",now(),".$state.",'".$statusMessage."','".$bettingNo."')";
		}
        else if($state==9)
        {
            $bettingNo=$statusMessage;
            $statusMessage = "경기재정산전_취소[배팅번호:".$statusMessage."]";

            $sql = "insert into ".$this->db_qz."money_log(member_sn,amount,before_money,after_money,regdate,state, status_message, betting_no)
						values(".$memberSn.",".$amount.",".$before.",".$after.",now(),".$state.",'".$statusMessage."','".$bettingNo."')";
        }
		else
		{
			$sql = "insert into ".$this->db_qz."money_log(member_sn,amount,before_money,after_money,regdate,state, status_message, log_memo)
							values(".$memberSn.",".$amount.",".$before.",".$after.",now(),".$state.",'".$statusMessage."','".$memo."')";
		}
				
		$this->db->exeSql($sql);
	}

	//▶ 마일리지 목록 총합
	function getMileageTotal($sn, $type)
	{
		$where="";
		if($type!='')
			$where=" and state=".$type;
			
		$sql = "select count(*) as cnt from ".$this->db_qz."mileage_log ";
		$sql.= "where member_sn='".$sn."'".$where;
		
		$rs = $this->db->exeSql($sql);	
		return $rs[0]['cnt'];
	}
	
	//▶ 마일리지 목록
	function getMileageList($sn, $page, $page_size, $type='')
	{
		$where="";
		if($type!='')
			$where=" and state=".$type;
			
		$sql = "select sn,member_sn,amount,state,status_message,regdate from ".$this->db_qz."mileage_log ";
		$sql.= "where member_sn='".$sn."'".$where." order by regdate desc limit ".$page.",".$page_size;
		
		return $this->db->exeSql($sql);	
	}
	
	//▶ 마일리지 목록 총합
	function getMileageLogTotal($where='', $memberSn='', $type='', $beginDate='', $endDate='')
	{
		$sql = "select count(*) as cnt 
						from ".$this->db_qz."mileage_log a,".$this->db_qz."people b
						where a.member_sn=b.sn and b.mem_status<>'G' ".$where;
		
		if($type!='') 		$sql.=" and a.state=".$type;
		if($memberSn!='') 	$sql.=" and a.member_sn=".$memberSn;
		if($beginDate!=''&& $endDate!='') $sql.=" and a.regdate between '".$beginDate." 00:00:00' and '".$endDate." 23:59:59'";  
		$rs = $this->db->exeSql($sql);	
		return $rs[0]['cnt'];
	}
	
	//▶ 마일리지 목록
	function getMileageLogList($where='', $memberSn='', $page=0, $page_size=0, $type='', $beginDate='', $endDate='')
	{
		$sql = "select a.regdate as log_regdate, a.*, b.*
						from ".$this->db_qz."mileage_log a,".$this->db_qz."people b
						where a.member_sn=b.sn and b.mem_status<>'G' ".$where;
		
		if($type!='') 		$sql.=" and a.state=".$type;
		if($memberSn!='') 	$sql.=" and a.member_sn=".$memberSn;
		if($beginDate!=''&& $endDate!='') $sql.=" and a.regdate between '".$beginDate." 00:00:00' and '".$endDate." 23:59:59'";
		$sql.=" order by a.regdate desc";  
		if($page_size>0) 	$sql.=" limit ".$page.",".$page_size;
		
		return $this->db->exeSql($sql);	
	}
	
	//▶ 머니내역 목록 총합
	function getMoneyLogTotal($where='', $memberSn='', $type='', $beginDate='', $endDate='')
	{
		$sql = "select count(*) as cnt 
						from ".$this->db_qz."money_log a, ".$this->db_qz."people b
						where a.member_sn=b.sn and b.mem_status<>'G' ".$where;
		
		if($type!='') 		$sql.=" and a.state=".$type;
		if($memberSn!='') $sql.=" and a.member_sn=".$memberSn;
		if($beginDate!=''&& $endDate!='') $sql.=" and a.regdate between '".$beginDate."' and '".$endDate."'";  
			
		$rs = $this->db->exeSql($sql);	
		return $rs[0]['cnt'];
	}

	//-> 머니충전 내역
	function getMoneyChargeLog($where='', $memberSn='', $page=0, $page_size=0, $type='', $beginDate='', $endDate='') {
		if($type!='') 		$where.=" and a.state=".$type;
		if($memberSn!='') $where.=" and a.member_sn=".$memberSn;
		$subParam="";
		if($beginDate!=''&& $endDate!='')
		{
			$where.=" and a.regdate between '".$beginDate." 00:00:00' and '".$endDate." 23:59:59'";
		}
		$where.=" order by a.operdate asc";  
		if($page_size>0) 	$where.=" limit ".$page.",".$page_size;
		$sql = "select a.*, b.*, c.rec_id from tb_charge_log a, tb_people b left outer join tb_recommend c on b.recommend_sn=c.Idx where a.member_sn=b.sn and b.mem_status<>'G' ".$where;
		return $this->db->exeSql($sql);
	}

	//-> 머니환전 내역
	function getMoneyExchangeLog($where='', $memberSn='', $page=0, $page_size=0, $type='', $beginDate='', $endDate='') {
		if($type!='') 		$where.=" and a.state=".$type;
		if($memberSn!='') $where.=" and a.member_sn=".$memberSn;
		$subParam="";
		if($beginDate!=''&& $endDate!='')
		{
			$where.=" and a.regdate between '".$beginDate." 00:00:00' and '".$endDate." 23:59:59'";
		}
		$where.=" order by a.operdate asc";  
		if($page_size>0) 	$where.=" limit ".$page.",".$page_size;
		$sql = "select a.*, b.*, c.rec_id from tb_exchange_log a, tb_people b left outer join tb_recommend c on b.recommend_sn=c.Idx where a.member_sn=b.sn and b.mem_status<>'G' ".$where;
		return $this->db->exeSql($sql);
	}
	
	//▶ 머니내역 목록
	function getMoneyLogList($where='', $memberSn='', $page=0, $page_size=0, $type='', $beginDate='', $endDate='')
	{
		if($type!='') 		$where.=" and a.state=".$type;
		if($memberSn!='') $where.=" and a.member_sn=".$memberSn;
		$subParam="";
		if($beginDate!=''&& $endDate!='')
		{
			$where.=" and a.regdate between '".$beginDate." 00:00:00' and '".$endDate." 23:59:59'";
			$subParam.=" and z.regdate between '".$beginDate." 00:00:00' and '".$endDate." 23:59:59'";
		}
		$where.=" order by a.regdate desc";  
		if($page_size>0) 	$where.=" limit ".$page.",".$page_size;

		$sql = "select (select count(*) from tb_charge_log z where z.member_sn=b.sn".$subParam.") as charge_cnt, a.regdate as log_regdate, a.*, b.*, c.rec_id, a.regdate as operdate
						from ".$this->db_qz."money_log a,".$this->db_qz."people b left outer join ".$this->db_qz."recommend c on b.recommend_sn=c.Idx
						where a.member_sn=b.sn and b.mem_status<>'G' ".$where;
		return $this->db->exeSql($sql);
	}
	
	function ajaxMileage2Cash($sn, $point) {
		$pModel = Lemon_Instance::getObject("ProcessModel",true);	
		$pModel->modifyMoneyProcess($sn, $point, '6', '포인트전환');
		$pModel->modifyMileageProcess($sn, -$point,'6','포인트전환');
		return true;
	}
	
	function ajaxCash2Mileage($sn, $amount)
	{
		$process_model = Lemon_Instance::getObject("ProcessModel",true);
		
		$sql = "select g_money from ".$this->db_qz."people where sn='".$sn."'";
		$rows = $this->db->exeSql($sql);
		
		if(count($rows)>0)
		{
			$money = $rows[0]['g_money'];
			
			if($money >= $amount)
			{
				$process_model->modifyMoneyProcess($sn, -$amount, '13', '마일리지전환');
				$rs = $process_model->modifyMileageProcess($sn, $amount, '13', '마일리지전환', 100);
				
				$sql = "select g_money, point from ".$this->db_qz."people where sn='".$sn."'";
				$rs = $this->db->exeSql($sql);
				
				echo(json_encode($rs[0]));
			}
		}
	}
	
	function modifyHide($type/*0=charge, 1=exchange*/, $sn)
	{
		if("charge"==$type)					{$table = $this->db_qz."charge_log";}
		else if("exchange"==$type)	{$table = $this->db_qz."exchange_log";}
		else							{return;}
		
		$sql = "update ".$table." set is_hidden=1 where sn=".$sn;
		return $this->db->exeSql($sql);	
	}
	
	function totalmemberMoney()
	{
		$sql = "select sum(g_money) as total_money from ".$this->db_qz."people where mem_status not in ('G','D','S')";
		$rs=$this->db->exeSql($sql);
		return $rs[0]["total_money"];
	}
	
	function totalmemberMileage()
	{
		$sql = "select sum(point) as total_point from ".$this->db_qz."people where mem_status not in ('G','D','S')";
		$rs=$this->db->exeSql($sql);
		return $rs[0]["total_point"];
	}

	//-> 금주의출금(환전) TOP10
	function getExchangeTop10() {
		$startDate = date("Y-m-d H:i:s",time()-(86400*7));
		$endDate = date("Y-m-d H:i:s",time());
		$sql = "select a.amount, a.regdate, b.uid, b.nick from tb_money_log a, tb_people b where a.member_sn = b.sn and a.regdate >= '{$startDate}' and a.regdate <= '{$endDate}' and a.state = 2 and a.status_message = '환전요청' and b.mem_status = 'N' order by a.amount asc limit 10";
		return $this->db->exeSql($sql);	
	}

	//-> 실시간 입/출금 최근 10개
	function getMoneyInOutTop10() {
		$sql = "select a.state, a.amount, a.regdate, b.uid, b.nick from tb_money_log a, tb_people b where a.member_sn = b.sn and (a.state = 1 or a.state = 2) and (a.status_message = '환전요청' or a.status_message = '충전') and b.mem_status = 'N' order by a.regdate desc limit 10";
		return $this->db->exeSql($sql);	
	}

	//-> 사다리 실시간 배팅금액
	function getSadariBettingMoney($gameDate, $gameTh, $selectNo) {
		$sql = "select a.game_code, sum(c.bet_money) as sum_money from tb_child a, tb_subchild b, tb_game_betting c where a.sn = b.child_sn and b.child_sn = c.sub_child_sn and a.special = 3 and a.game_th = '{$gameTh}' and a.gameDate = '{$gameDate}' and c.select_no = '{$selectNo}' group by a.game_code";
		return $this->db->exeSql($sql);	
	}

	//-> 달팽이 실시간 배팅금액
	function getRaceBettingMoney($gameDate, $gameTh, $selectNo) {
		$sql = "select a.game_code, sum(c.bet_money) as sum_money from tb_child a, tb_subchild b, tb_game_betting c where a.sn = b.child_sn and b.child_sn = c.sub_child_sn and a.special = 4 and a.game_th = '{$gameTh}' and a.gameDate = '{$gameDate}' and c.select_no = '{$selectNo}' group by a.game_code";
		return $this->db->exeSql($sql);	
	}
}
?>