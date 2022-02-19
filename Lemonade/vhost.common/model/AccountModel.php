<?php
/**
 * AccountModel
 *--------------------------------------------------------------------
 *
 * working set - account
 *
 *--------------------------------------------------------------------
 * Copyright (C) 
 * http://www.monaco.com
 */
 
 /**
 * Account
 *--------------------------------------------------------------------
 *
 * ������� = last(regDate) 00:00:00
 * ���긶�� = yesterday
 * ������ = today
 *--------------------------------------------------------------------
 * Copyright (C) ��
 * http://www.monaco.com
 */
 
class AccountModel extends Lemon_Model
{
	//�� ���� ���� ���, ��, RETURN 0�� ��� ������ �ʿ� ����
	function accountDate(&$beginDate, &$endDate)
	{
		$sql = "select max(date(reg_date)) as lastDate from ".$this->db_qz."site_account 
					where logo='".$this->logo."'";
		$rs = $this->db->exeSql($sql);
		$beginDate = $rs[0]['lastDate'];
		
		$sql = "select date(now())='".$beginDate."' as diff";
		$rs = $this->db->exeSql($sql);
		
		if($rs[0]['diff']!=0) return 0;
		
		if($beginDate==null || $beginDate=="")
		{
			$sql = "update ".$this->db_qz."site_account set reg_date=now()";
			$this->db->exeSql($sql);
			return 0;
		}
		
		$sql = "select date(date_sub(now(),interval 1 day)) as endDate";
		$rs = $this->db->exeSql($sql);
		$endDate = $rs[0]['endDate'];
		
		return 1;
	}
	
	//�� ����Ʈ ����
	function accountSite()
	{
		$beginDate	='';
		$endDate	='';
		$array		= array();
		
		$rs = $this->accountDate($beginDate, $endDate);
		
		if($rs!=1) return $array;
		
		$array['reg_date'] 	= $beginDate;
		$array['objdate'] 	= $endDate;
		
		$exchangeTotal 	= 0;
		$chargeTotal	= 0;
		$betTotal		= 0;
		$resultTotal	= 0;
		$partnerTotal	= 0;
		
		$exchangeTotal 	= $this->accountExchange($beginDate, $endDate);
		$chargeTotal 	= $this->accountCharge($beginDate, $endDate);
				
		$array["exchange_money"] 	= $exchangeTotal;
		$array["change_money"]		= $chargeTotal;
				
		$this->accountBet($beginDate, $endDate, $betTotal, $resultTotal);
		$array["acc_bet"]		 = $betTotal;
		$array["acc_bonus_money"]= $resultTotal;
				
		$this->accountPartner($beginDate, $endDate, $partnerTotal);
		$array["acc_partner"] = $partnerTotal;
		
		return $array;
	}
	
	function accountExchange($beginDate='', $endDate='', $addWhere='')
	{
		$where='';
		if($addWhere!='') $where=" and ".$addWhere;
		
		$sql = "select ifnull(sum(agree_amount),0) as total from ".$this->db_qz."exchange_log
				where state=1 and logo='".$this->logo."' and date(regdate)>='".$beginDate."' and date(regdate)<='".$endDate."'".$where;
		$rs = $this->db->exeSql($sql);
		return $rs[0]['total'];
	}
	
	function accountCharge($beginDate='', $endDate='', $addWhere='')
	{
		$where='';
		if($addWhere!='') $where=" and ".$addWhere;
		
		$sql = "select ifnull(sum(agree_amount),0) as total from ".$this->db_qz."charge_log
				where state=1 and logo='".$this->logo."' and date(regdate)>='".$beginDate."' and date(regdate)<='".$endDate."'".$where;
		$rs = $this->db->exeSql($sql);
		return $rs[0]['total'];
	}
	
	//�� ���� �ѸӴ�
	function accountBet($beginDate='', $endDate='', &$betTotal, &$resultTotal, $addWhere='')
	{
		$where='';
		if($addWhere!='') $where=" and ".$addWhere;
		
		$sql = "select ifnull(sum(betting_money),0) as betting_money, ifnull(sum(result_money),0) as result_money 
				from ".$this->db_qz."game_cart
					where logo='".$this->logo."' and date(regdate)>='".$beginDate."' and date(regdate)<='".$endDate."'";
				
		$rs = $this->db->exeSql($sql);
		
		$betTotal 		= 0;
		$resultTotal	= 0;
		
		if(count((array)$rs)>0)
		{
			if($rs[0]['kubun']==0) 	$betTotal	= $rs[0]['betting_money'];
			else					$resultTotal	= $rs[0]['result_money'];
		}
	}
	
	//�� ��Ʈ�� ����
	function accountPartner($beginDate, $endDate, &$partnerAccount)
	{
		$sql =	"select ifnull(sum(opt_money),0) as acc_partner 
				from ".$this->db_qz."recommend_account
					where logo='".$this->logo."' and status=1 and date(reg_date)>='".$beginDate."' and date(reg_date)<='".$endDate."'";

		$rs = $this->db->exeSql($sql);
		$partnerAccount = 0;
		if(count((array)$rs)>0)
			$partnerAccount = $rs[0]['acc_partner'];	
	}
	
	//�� ��õ�� ���� ������ ���ϸ��� ���
	function accountJoinPartnerMileage($sn)
	{
		$mModel = Lemon_Instance::getObject("MemberModel",true);
		
		$sql = "select * from ".$this->db_qz."join_recommend where member_sn=".$sn;
					
		$rs = $this->db->exeSql($sql);
		
		if(count((array)$rs)<=0) return $rs;
		
		$beginDate 	= date('Y-m-d')." 00:00:00";
		$endDate	= date('Y-m-d')." 23:59:59";
		
		$item = array();
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$exchangeMoney = 0;
			$chargeMoney   = 0;
			
			$rate = 0;
			
			if($i==0) 
			{
				$targetSn 	= $rs[$i]['depth1_sn'];
				$rate		= $rs[$i]['depth1_rate'];
			}
			else if($i==1)
			{
				$targetSn 	= $rs[$i]['depth2_sn'];
				$rate		= $rs[$i]['depth2_rate'];
			}
			else if($i==2)
			{
				$targetSn 	= $rs[$i]['depth3_sn'];
				$rate		= $rs[$i]['depth3_rate'];
			}
			
			$addWhere = " mem_idx=".$targetSn;
			
			$exchangeTotal 	= $this->accountExchange($beginDate, $endDate);
			$chargeTotal 	= $this->accountCharge($beginDate, $endDate);
			
			$exchangeMoney 	= $this->accountExchange($beginDate, $endDate, $addWhere);
			$chargeMoney 	= $this->accountCharge($beginDate, $endDate, $addWhere);
			
			if($i==0)
			{
				$item['depth1_id']	= $mModel->getMemberField($targetSn, 'uid');
				$benefit = ($exchangeMoney-$chargeMoney)*$rate/100;
				
				//ȭ������� 0���� ó����û
				if($benefit<=0) $benefit=0;
				$item['depth1_mileage'] = $benefit;
			}
			else if($i==1) 
			{
				$item['depth2_id']	= $mModel->getMemberField($targetSn, 'uid');
				$benefit = ($exchangeMoney-$chargeMoney)*$rate/100;
				if($benefit<=0) $benefit=0;
				$item['depth2_mileage'] = $benefit;
			}
			else if($i==2)
			{
				$item['depth3_id']	= $mModel->getMemberField($targetSn, 'uid');
				$benefit = ($exchangeMoney-$chargeMoney)*$rate/100;
				if($benefit<=0) $benefit=0;
				$item['depth3_mileage'] = $benefit;
			}
			
		}
		return $item;
	}
	
	//�� ����Ʈ ���� ����
	function getSiteAccountTotal()
	{
		$sql = "select count(*) as cnt
				from ".$this->db_qz."site_account";
				
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//�� ����Ʈ ���� �߰�
	function addSiteAccount($exchange_money, $change_money, $acc_bet, $acc_bonus_money, $acc_partner, $account_money, $reg_date, $objdate)
	{
		$sql = "insert into ".$this->db_qz."site_account(acc_exchange,acc_change,acc_bet,acc_bonus,acc_partner,acc_site,start_date,over_date,reg_date,logo)values(";
		$sql.= "".$exchange_money.",".$change_money.",".$acc_bet.",".$acc_bonus_money.",".$acc_partner.",".$account_money.",'".$reg_date."','".$objdate."',now(),'".$this->logo."')";

		return $this->db->exeSql($sql);
	}
	
	//�� ����Ʈ ���� ���
	function getSiteAccountList($page, $page_size)
	{
		$sql = "select acc_exchange,acc_change,acc_bet,acc_bonus,acc_partner,acc_site,date(start_date) as start_date,date(over_date) as over_date,date(reg_date) as reg_date";
		$sql.= " from ".$this->db_qz."site_account order by reg_date limit ".$page.",".$page_size;
		
		return $this->db->exeSql($sql);
	}
}
?>