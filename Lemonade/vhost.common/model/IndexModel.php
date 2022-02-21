<?php

class IndexModel extends Lemon_Model 
{
	function recent_member_list()
	{
		$sql = "select a.sn as member_sn, a.logo, uid, nick, rec_name, a.mem_ip, a.login_domain
						from ".$this->db_qz."people a, ".$this->db_qz."partner b 
						where a.recommend_sn=b.Idx and a.last_date >= date_add(sysdate(), INTERVAL -3 hour) limit 0, 30";
		$rows = $this->db->exeSql($sql);
		
		for($i=0; $i < count((array)$rows); ++$i)
		{
			$sql = "select count(*) as cnt from ".$this->db_qz."visit where member_id='".$rows[$i]['uid']."' and visit_date between date_add(sysdate(), INTERVAL -7 day) and sysdate()";
			$tmp_rows = $this->db->exeSql($sql);
			$rows[$i]['visit_count'] = $tmp_rows[0]['cnt'];
			
			$sql = "select sum(agree_amount) as total_charge from ".$this->db_qz."charge_log where member_sn='".$rows[$i]['member_sn']."' and regdate between date_add(sysdate(), INTERVAL -7 day) and sysdate()";
			$tmp_rows = $this->db->exeSql($sql);
			$rows[$i]['total_charge'] = $tmp_rows[0]['total_charge'];
			
			$sql = "select sum(agree_amount) as total_exchange from ".$this->db_qz."exchange_log where member_sn='".$rows[$i]['member_sn']."' and regdate between date_add(sysdate(), INTERVAL -7 day) and sysdate()";
			$tmp_rows = $this->db->exeSql($sql);
			$rows[$i]['total_exchange'] = $tmp_rows[0]['total_exchange'];
			
			$sql = "select sum(result_money) as total_prize from ".$this->db_qz."game_cart where member_sn='".$rows[$i]['member_sn']."' and regdate between date_add(sysdate(), INTERVAL -7 day) and sysdate()";
			$tmp_rows = $this->db->exeSql($sql);
			$rows[$i]['total_prize'] = $tmp_rows[0]['total_prize'];
		}
		
		return $rows;
	}
	
	function index_filter_member($userid, $min_prize, $max_prize)
	{
		if($userid!="")
		{
			$where = " and a.uid='".$userid."'";
		}
		
		//추후 추가예정
		if($min_prize!="")
		{
			
		}
		$sql = "select a.sn as member_sn, a.logo, uid, nick, rec_name, g_money, phone, point, mem_lev
						from ".$this->db_qz."people a, ".$this->db_qz."partner b 
						where a.recommend_sn=b.Idx".$where;

		$rows = $this->db->exeSql($sql);
		
		if( count((array)$rows) <=0)
			return;
		
		$sql = "select count(*) as cnt from ".$this->db_qz."visit where member_id='".$rows[0]['uid']."' and visit_date between date_add(sysdate(), INTERVAL -7 day) and sysdate()";
		$tmp_rows = $this->db->exeSql($sql);
		$rows[0]['visit_count'] = $tmp_rows[0]['cnt'];
		
		//입금
		$sql = "select sum(agree_amount) as total_charge from ".$this->db_qz."charge_log where member_sn='".$rows[0]['member_sn']."'";
		$tmp_rows = $this->db->exeSql($sql);
		$rows[0]['total_charge'] = $tmp_rows[0]['total_charge'];
		
		//입금 마일리지
		$sql = "select sum(amount) as total_charge_mileage from ".$this->db_qz."mileage_log where member_sn='".$rows[0]['member_sn']."' and state=1";
		$tmp_rows = $this->db->exeSql($sql);
		$rows[0]['total_charge_mileage'] = $tmp_rows[0]['total_charge_mileage'];
		
		//출금
		$sql = "select sum(agree_amount) as total_exchange from ".$this->db_qz."exchange_log where member_sn='".$rows[0]['member_sn']."'";
		$tmp_rows = $this->db->exeSql($sql);
		$rows[0]['total_exchange'] = $tmp_rows[0]['total_exchange'];
		
		//당첨금
		$sql = "select sum(result_money) as total_prize from ".$this->db_qz."game_cart where member_sn='".$rows[0]['member_sn']."' and result_money >0";
		$tmp_rows = $this->db->exeSql($sql);
		$rows[0]['total_prize'] = $tmp_rows[0]['total_prize'];
		
		//단폴더 당첨금
		$sql = "select sum(result_money) as total_single_prize from ".$this->db_qz."game_cart where member_sn='".$rows[0]['member_sn']."' and result_money > 0 and betting_cnt=1";
		$tmp_rows = $this->db->exeSql($sql);
		$rows[0]['total_single_prize'] = $tmp_rows[0]['total_single_prize'];
		
		//낙첨금
		$sql = "select sum(result_money) as failed_money from ".$this->db_qz."game_cart where member_sn='".$rows[0]['member_sn']."' and result=2";
		$tmp_rows = $this->db->exeSql($sql);
		$rows[0]['failed_money'] = $tmp_rows[0]['failed_money'];
		
		//단폴더 낙첨금
		$sql = "select sum(result_money) as total_single_failed_money from ".$this->db_qz."game_cart where member_sn='".$rows[0]['member_sn']."' and result=2 and betting_cnt=1";
		$tmp_rows = $this->db->exeSql($sql);
		$rows[0]['total_single_failed_money'] = $tmp_rows[0]['total_single_failed_money'];
		
		//총베팅액
		$sql = "select sum(betting_money) as total_betting_money from ".$this->db_qz."game_cart where member_sn='".$rows[0]['member_sn']."'";
		$tmp_rows = $this->db->exeSql($sql);
		$rows[0]['total_betting_money'] = $tmp_rows[0]['total_betting_money'];
		
		//낙첨마일리지
		$sql = "select sum(amount) as total_fail_mileage from ".$this->db_qz."mileage_log where member_sn='".$rows[0]['member_sn']."' and state=4";
		$tmp_rows = $this->db->exeSql($sql);
		$rows[0]['total_fail_mileage'] = $tmp_rows[0]['total_fail_mileage'];
		
		//관리자 수정금액
		$sql = "select sum(amount) as manager_update_money from ".$this->db_qz."money_log where member_sn='".$rows[0]['member_sn']."' and state=7";
		$tmp_rows = $this->db->exeSql($sql);
		$rows[0]['manager_update_money'] = $tmp_rows[0]['manager_update_money'];
		
		////////////////////////////////////////////////////////////////////////////
		//현재 베팅현황
		$sql = "select * from  ".$this->db_qz."game_cart a
						where a.member_sn=".$rows[0]['member_sn']." and a.result=0 order by a.regdate";
		$tmp_rows = $this->db->exeSql($sql);
		
		for($i=0; $i < count((array)$tmp_rows); ++$i)
		{
			$betting_no = $tmp_rows[$i]['betting_no'];
			$sql = "select * from ".$this->db_qz."game_betting where betting_no='".$betting_no."'";
			$detail_rows = $this->db->exeSql($sql);
			$tmp_rows[$i]['detail_rows'] = $detail_rows;
			$rows[0]['total_current_betting_money'] += $tmp_rows[$i]['betting_money'];
		}
		
		$rows[0]['current_betting_rows'] = $tmp_rows;
		
		//전체 베팅현황
		$sql = "select * from  ".$this->db_qz."game_cart a
						where a.member_sn=".$rows[0]['member_sn']." order by a.regdate desc limit 0, 10";
		$tmp_rows = $this->db->exeSql($sql);
		
		for($i=0; $i < count((array)$tmp_rows); ++$i)
		{
			$betting_no = $tmp_rows[$i]['betting_no'];
			$sql = "select * from ".$this->db_qz."game_betting where betting_no='".$betting_no."'";
			$detail_rows = $this->db->exeSql($sql);
			$tmp_rows[$i]['detail_rows'] = $detail_rows;
			$rows[0]['total_betting_money'] += $tmp_rows[$i]['betting_money'];
			$rows[0]['total_prize'] += $tmp_rows[$i]['result_money'];
		}
		
		$rows[0]['total_betting_rows'] = $tmp_rows;
		
		return $rows[0];
	}
}

?>