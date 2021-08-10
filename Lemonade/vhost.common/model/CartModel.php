<?php

class CartModel extends Lemon_Model 
{

	//▶ 베팅 목록 
	function getBetByChildSn($child_sn)
	{
		/*
		$sql = "select c.select_no, c.game_type, c.bet_money, a.home_team, a.away_team 
					from ".$this->db_qz."child a, ".$this->db_qz."subchild b left outer join ".$this->db_qz."total_betting c on b.sn=c.sub_child_sn left outer join ".$this->db_qz."total_cart d on c.betting_no=d.betting_no
					where logo='".$this->logo."' and d.kubun='Y' and a.sn =".$child_sn;
					*/
		$sql = "select c.select_no, c.game_type, c.bet_money, a.home_team, a.away_team 
		from ".
			$this->db_qz."child a, ".
			$this->db_qz."subchild b,".
			$this->db_qz."total_betting c,".
			$this->db_qz."total_cart d
		where a.sn=b.child_sn and b.sn=c.sub_child_sn and c.betting_no=d.betting_no and
			logo='".$this->logo."' and d.kubun='Y' and a.sn =".$child_sn;
		
		return $this->db->exeSql($sql);
	}
	
	//▶ 베팅 목록 (다기준) 
	function getBetByChildSnMulti($subchild_sn)
	{
		/*
		$sql = "select c.select_no, c.game_type, c.bet_money, a.home_team, a.away_team 
					from ".$this->db_qz."child a, ".$this->db_qz."subchild b left outer join ".$this->db_qz."total_betting c on b.sn=c.sub_child_sn left outer join ".$this->db_qz."total_cart d on c.betting_no=d.betting_no
					where logo='".$this->logo."' and d.kubun='Y' and a.sn =".$child_sn;
					*/
		$sql = "select c.select_no, c.game_type, c.bet_money, a.home_team, a.away_team 
				from ".
						$this->db_qz."child_m a, ".
						$this->db_qz."subchild_m b,".
						$this->db_qz."total_betting c,".
						$this->db_qz."total_cart d
				where 	a.sn=b.child_sn and b.sn=c.sub_child_sn and c.betting_no=d.betting_no and
						logo='".$this->logo."' and d.kubun='Y' and a.sn =".$subchild_sn;
		
		return $this->db->exeSql($sql);
	}
	
	function getMemberBetDetailList($betting_no, $member_sn)
	{		
		$sql = "select a.sn as total_betting_sn, a.sub_child_sn,a.select_no,a.select_rate,a.game_type,a.result,b.win_team,
						b.sn as child_sn, b.home_team,b.away_team,b.home_score,b.away_score,b.special,b.gameDate,b.gameHour,b.gameTime, 
						c.name as league_name,c.lg_img as league_image, d.win,a.home_rate,a.away_rate,a.draw_rate
						from ".$this->db_qz."total_betting a, ".$this->db_qz."child b, ".$this->db_qz."league c, ".$this->db_qz."subchild d, ".$this->db_qz."total_cart e 
						where a.betting_no='".$betting_no."' and a.sub_child_sn=d.sn and b.league_sn=c.sn and b.sn=d.child_sn and a.betting_no = e.betting_no and e.member_sn = ".$member_sn;
										
		$rs = $this->db->exeSql($sql);
		
		for($i = 0; $i < count((array)$rs); ++$i)
		{
			$gameDate = trim($rs[$i]['gameDate']);				
			$gameHour = trim($rs[$i]['gameHour']);
			$gameTime = trim($rs[$i]['gameTime']);
				
			$strDay = date('w',strtotime($gameDate));
			switch($strDay)
			{
			case 0: $Weekday_name = "(일)"; break;
			case 1: $Weekday_name = "(월)"; break;
			case 2: $Weekday_name = "(화)"; break;
			case 3: $Weekday_name = "(수)"; break;
			case 4: $Weekday_name = "(목)"; break;
			case 5: $Weekday_name = "(금)"; break;
			case 6: $Weekday_name = "(토)"; break;	
			}
			$g_date = substr($gameDate,5,2)."/".  substr($gameDate,8,2) . $Weekday_name ." ". $gameHour .":". $gameTime;	
			$rs[$i]['g_date'] = $g_date;
		}
	
		return $rs;
	}
	
	//▶ 카트 마지막 인덱스
	function getLastCartIndex()
	{
		$sql = "select max(sn) as last_sn from ".$this->db_qz."total_cart";
				
		$rs = $this->db->exeSql($sql);
		return $rs[0]['last_sn'];
	}	
	
	//▶ 배팅 총머니
	function getTotalBetMoney($partnertSn='',$childSn='',$memberSn='', $beginDate='', $endDate='', $result='', $logo='', $betting_cnt = 0)
	{
		if($logo!='') 
			$logo = " and logo='".$logo."'";
		
		$sql = "select 
							ifnull(sum(betting_money),0) as total_betting,	
							ifnull(sum(result_money),0) as total_result, 
							count(betting_money) as betting_count
						from ".$this->db_qz."total_cart
						where kubun='Y' and is_account=1".$logo;
						
		if($childSn!='')
		{
			$sql.=" and betting_no in 
							(select distinct(betting_no) from ".$this->db_qz."total_betting where sub_child_sn =
							(select sn from ".$this->db_qz."subchild where child_sn=".$childSn."))";
		}
		if($memberSn!='')	$sql.=" and member_sn=".$memberSn;
		if($beginDate!='' && $endDate!='')
		{
			$beginDate.= " 00:00:00";
			$endDate	.= " 23:59:59";
			$sql.=" and regdate between '".$beginDate."' and '".$endDate."'";
		}
		if($result===2) $sql.=" and result=2";
		else if($result===1) $sql.=" and result=1";
		else if($result===0) $sql.=" and result=0";
		if($partnertSn!='') $sql.=" and partner_sn=".$partnertSn;
		if($betting_cnt>0) $sql.=" and betting_cnt=".$betting_cnt;
		
		$rs = $this->db->exeSql($sql);
		return $rs[0];
	}
	
	function expected_prize($logo='')
	{
		if($logo!='') 
			$logo = " and logo='".$logo."'";
		else
			$logo = " and logo='".$this->logo."'";
		
		$sql = "select ifnull(sum(betting_money*result_rate),0) as expected_prize
						from ".$this->db_qz."total_cart
						where kubun='Y' and is_account=1 and result=0".$logo;
						
		$rows = $this->db->exeSql($sql);
		
		return $rows[0]['expected_prize'];
	}
	
	//▶ 롤링 배팅 총머니
	function getRollingTotalBetMoney($rollingSn='',$beginDate='', $endDate='', $result='')
	{
		$sql = "select 
							ifnull(sum(betting_money),0) as total_betting,	
							ifnull(sum(result_money),0) as total_result, 
							count(betting_money) as betting_count
						from ".$this->db_qz."total_cart
						where logo='".$this->logo."' and kubun='Y' and is_account=1";
						
		if($beginDate!='' && $endDate!='')
		{
			$beginDate.= " 00:00:00";
			$endDate	.= " 23:59:59";
			$sql.=" and regdate between '".$beginDate."' and '".$endDate."'";
		}
		if($result===2) $sql.=" and result=2";
		else if($result===1) 	$sql.=" and result=1";
		else if($result===0) 	$sql.=" and result=0";
		
		if($rollingSn!='') 	$sql.=" and rolling_sn=".$rollingSn;
						
		$rs = $this->db->exeSql($sql);
		
		return $rs[0];
	}
	
	//▶ 승,무,패 별 매팅 금액 - 낙첨 금액 제외
	function getTeamTotalBetMoney($childSn, $s_type = 0)
	{
		$item = array();
		if($s_type == 2) {
			//승 총배팅 금액
			$sql = "select 	ifnull(sum(a.betting_money),0) as total_betting, count(a.betting_money) as cnt
							from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild_m c,".$this->db_qz."child_m d
							where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn
							and c.kubun='Y' and d.sn=".$childSn." and b.select_no=1 
							and a.is_account=1";
							
			$rs = $this->db->exeSql($sql);
			$item['home_total_betting'] = $rs[0]['total_betting'];
			$item['home_count'] = $rs[0]['cnt'];
			
			//무 총배팅 금액
			$sql = "select 	ifnull(sum(a.betting_money),0) as total_betting, count(a.betting_money) as cnt
							from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild_m c,".$this->db_qz."child_m d
							where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn
							and c.kubun='Y' and d.sn=".$childSn." and b.select_no=3
							and a.is_account=1";
			$rs = $this->db->exeSql($sql);
			$item['draw_total_betting'] = $rs[0]['total_betting'];
			$item['draw_count'] = $rs[0]['cnt'];
		
			//패 총배팅 금액
			$sql = "select 	ifnull(sum(a.betting_money),0) as total_betting, count(a.betting_money) as cnt
							from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild_m c,".$this->db_qz."child_m d
							where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn
							and c.kubun='Y' and d.sn=".$childSn." and b.select_no=2
							and a.is_account=1";
			$rs = $this->db->exeSql($sql);
			$item['away_total_betting'] = $rs[0]['total_betting'];
			$item['away_count'] = $rs[0]['cnt'];
			
			//승 총배팅 금액 - 낙첨제외
			$sql = "select 	ifnull(sum(a.betting_money),0) as total_betting
							from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild_m c,".$this->db_qz."child_m d
							where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn
							and c.kubun='Y' and d.sn=".$childSn." and b.select_no=1 and a.result=0
							and a.is_account=1";
			$rs = $this->db->exeSql($sql);
			$item['active_home_total_betting'] = $rs[0]['total_betting'];
			
			//무 총배팅 금액
			$sql = "select 	ifnull(sum(a.betting_money),0) as total_betting
							from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild_m c,".$this->db_qz."child_m d
							where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn
							and c.kubun='Y' and d.sn=".$childSn." and b.select_no=3  and a.result=0
							and a.is_account=1";
			$rs = $this->db->exeSql($sql);
			$item['active_draw_total_betting'] = $rs[0]['total_betting'];
			
			//패 총배팅 금액
			$sql = "select 	ifnull(sum(a.betting_money),0) as total_betting
							from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild_m c,".$this->db_qz."child_m d
							where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn
							and c.kubun='Y' and d.sn=".$childSn." and b.select_no=2  and a.result=0
							and a.is_account=1";
			$rs = $this->db->exeSql($sql);
			$item['active_away_total_betting'] = $rs[0]['total_betting'];
		} else {
			//승 총배팅 금액
			$sql = "select 	ifnull(sum(a.betting_money),0) as total_betting, count(a.betting_money) as cnt
							from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild c,".$this->db_qz."child d
							where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn
							and a.kubun='Y' and d.sn=".$childSn." and b.select_no=1 
							and a.is_account=1";
							
			$rs = $this->db->exeSql($sql);
			$item['home_total_betting'] = $rs[0]['total_betting'];
			$item['home_count'] = $rs[0]['cnt'];
			
			//무 총배팅 금액
			$sql = "select 	ifnull(sum(a.betting_money),0) as total_betting, count(a.betting_money) as cnt
							from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild c,".$this->db_qz."child d
							where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn
							and a.kubun='Y' and d.sn=".$childSn." and b.select_no=3
							and a.is_account=1";
			$rs = $this->db->exeSql($sql);
			$item['draw_total_betting'] = $rs[0]['total_betting'];
			$item['draw_count'] = $rs[0]['cnt'];
		
			//패 총배팅 금액
			$sql = "select 	ifnull(sum(a.betting_money),0) as total_betting, count(a.betting_money) as cnt
							from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild c,".$this->db_qz."child d
							where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn
							and a.kubun='Y' and d.sn=".$childSn." and b.select_no=2
							and a.is_account=1";
			$rs = $this->db->exeSql($sql);
			$item['away_total_betting'] = $rs[0]['total_betting'];
			$item['away_count'] = $rs[0]['cnt'];
			
			//승 총배팅 금액 - 낙첨제외
			$sql = "select 	ifnull(sum(a.betting_money),0) as total_betting
							from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild c,".$this->db_qz."child d
							where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn
							and a.kubun='Y' and d.sn=".$childSn." and b.select_no=1 and a.result=0
							and a.is_account=1";
			$rs = $this->db->exeSql($sql);
			$item['active_home_total_betting'] = $rs[0]['total_betting'];
			
			//무 총배팅 금액
			$sql = "select 	ifnull(sum(a.betting_money),0) as total_betting
							from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild c,".$this->db_qz."child d
							where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn
							and a.kubun='Y' and d.sn=".$childSn." and b.select_no=3  and a.result=0
							and a.is_account=1";
			$rs = $this->db->exeSql($sql);
			$item['active_draw_total_betting'] = $rs[0]['total_betting'];
			
			//패 총배팅 금액
			$sql = "select 	ifnull(sum(a.betting_money),0) as total_betting
							from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild c,".$this->db_qz."child d
							where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn
							and a.kubun='Y' and d.sn=".$childSn." and b.select_no=2  and a.result=0
							and a.is_account=1";
			$rs = $this->db->exeSql($sql);
			$item['active_away_total_betting'] = $rs[0]['total_betting'];
		}
		
		
		return $item;
	}


    //▶ 승,무,패 별 매팅 금액 - 낙첨 금액 제외
    function getTeamTotalBetMoney2($childSn)
    {
        $item = array();

        //승 총배팅 금액
        $sql = "select 	ifnull(sum(a.betting_money),0) as total_betting, count(a.betting_money) as cnt
						from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild c,".$this->db_qz."child d
						where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn
						and a.kubun='Y' and d.sn=".$childSn." and b.select_no=1 
						and a.is_account=1";

        $rs = $this->db->exeSql($sql);
        $item['home_total_betting'] = $rs[0]['total_betting'];
        $item['home_count'] = $rs[0]['cnt'];

        //무 총배팅 금액
        $sql = "select 	ifnull(sum(a.betting_money),0) as total_betting, count(a.betting_money) as cnt
						from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild c,".$this->db_qz."child d
						where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn
						and a.kubun='Y' and d.sn=".$childSn." and b.select_no=3
						and a.is_account=1";
        $rs = $this->db->exeSql($sql);
        $item['draw_total_betting'] = $rs[0]['total_betting'];
        $item['draw_count'] = $rs[0]['cnt'];

        //패 총배팅 금액
        $sql = "select 	ifnull(sum(a.betting_money),0) as total_betting, count(a.betting_money) as cnt
						from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild c,".$this->db_qz."child d
						where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn
						and a.kubun='Y' and d.sn=".$childSn." and b.select_no=2
						and a.is_account=1";
        $rs = $this->db->exeSql($sql);
        $item['away_total_betting'] = $rs[0]['total_betting'];
        $item['away_count'] = $rs[0]['cnt'];

        //승 총배팅 금액 - 낙첨제외
        $sql = "select 	ifnull(sum(a.betting_money * a.result_rate),0) as total_betting, count(a.betting_money) as cnt
						from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild c,".$this->db_qz."child d
						where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn
						and a.kubun='Y' and d.sn=".$childSn." and b.select_no=1 
						and a.is_account=1";

        $rs = $this->db->exeSql($sql);
        $item['active_home_total_betting'] = $rs[0]['total_betting'];

        //무 총배팅 금액
        $sql = "select 	ifnull(sum(a.betting_money * a.result_rate),0) as total_betting, count(a.betting_money) as cnt
						from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild c,".$this->db_qz."child d
						where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn
						and a.kubun='Y' and d.sn=".$childSn." and b.select_no=3
						and a.is_account=1";
        $rs = $this->db->exeSql($sql);
        $item['active_draw_total_betting'] = $rs[0]['total_betting'];

        //패 총배팅 금액
        $sql = "select 	ifnull(sum(a.betting_money * a.result_rate),0) as total_betting, count(a.betting_money) as cnt
						from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild c,".$this->db_qz."child d
						where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn
						and a.kubun='Y' and d.sn=".$childSn." and b.select_no=2
						and a.is_account=1";
        $rs = $this->db->exeSql($sql);
        $item['active_away_total_betting'] = $rs[0]['total_betting'];


        return $item;
    }

	public function calcResultRate($betting_no)
	{
		$sql = "select select_rate, result
						from ".$this->db_qz."total_betting
						where betting_no='".$betting_no."'";
						
		$rs = $this->db->exeSql($sql);
		
		$result_rate = 1;
		for( $i=0; $i<count((array)$rs); ++$i)
		{
			if($rs[$i]['result']!=4)
			{
				$result_rate = $result_rate*$rs[$i]['select_rate'];		
			}
			else
				$result_rate *=1;
		}
		return bcmul($result_rate, 1, 2);
	}
	
	//▶ 멤버의 배팅목록 (원기준)
	public function getMemberBetList($memberSn, $page=0, $page_size=0, $beginDate='', $endDate='', $orderby='', $where='')
	{
		$mModel = Lemon_Instance::getObject("MemberModel",true);
		$pModel = Lemon_Instance::getObject("PartnerModel",true);		
	
		$sql = "select *
						from ".$this->db_qz."total_cart
						where member_sn ='".$memberSn."' and kubun ='Y' ".$where;
		
		//Date
		if($beginDate!="" && $endDate!="")
		{
			$sql.=" and (bet_date between '".$beginDate."' and '".$endDate."') ";
		}

		//order by, limit
		$sql.=  " order by betting_no desc";
		if($page_size > 0)
		{
			$sql.= " limit ".$page.",".$page_size;
		}
		$rs = $this->db->exeSql($sql);
		
		$itemList = array();	
		
		$addWhere = " sn = ".$memberSn;
		$rsm = $mModel->getMemberRows('*', $addWhere);
		
		$recommend_sn =  $rsm[0]['recommend_sn'];
		if( $recommend_sn != '' )
			$rec_name = $pModel->getPartnerField( $recommend_sn, 'rec_name');
					
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$bettingNo = $rs[$i]["betting_no"];
			$rs[$i]['result_rate'] = $this->calcResultRate($bettingNo);
			$event = $rs[$i]["event"];

			$sql = "SELECT 	tb_temp.*, tb_markets.mid, tb_markets.mname_ko, tb_markets.mfamily FROM (
							SELECT a.sub_child_sn,a.select_no,a.home_rate,a.away_rate,a.draw_rate,a.select_rate,a.game_type,a.result,a.live,a.score, 
									b.sn as child_sn, b.home_team,b.away_team,b.home_score,b.away_score,b.special,b.gameDate,b.gameHour,b.gameTime, 
									b.notice as league_name, b.league_img as league_image, b.sport_id, d.win, d.home_line, d.away_line, d.draw_line, d.home_name, d.away_name, d.draw_name
							FROM ".$this->db_qz."total_betting a, ".$this->db_qz."child b, ".$this->db_qz."subchild d 
							WHERE a.betting_no='".$bettingNo."' and a.sub_child_sn=d.sn and b.sn=d.child_sn ) AS tb_temp 
					LEFT JOIN tb_markets ON tb_temp.game_type = tb_markets.mid ";

			if($orderby!='') {$sql.=" order by ".$orderby;}
							
			$rsi = $this->db->exeSql($sql);
			
			$itemList[$bettingNo] = $rs[$i];
			$itemList[$bettingNo]['member'] = $rsm[0];
			$itemList[$bettingNo]['rec_name'] = $rec_name;	
			
			$index = 0;
			
			for($j=0; $j<count((array)$rsi); ++$j)
			{
				$itemList[$bettingNo]['win_money'] = (int)($rs[$i]['betting_money']*$rs[$i]['result_rate']);
				$itemList[$bettingNo]['folder_bonus']=0;
				
				$gameDate = trim($rsi[$j]['gameDate']);				
				$gameHour = trim($rsi[$j]['gameHour']);
				$gameTime = trim($rsi[$j]['gameTime']);
				
				$strDay = date('w',strtotime($gameDate));
				switch($strDay)
				{
					case 0: $Weekday_name = "(일)"; break;
					case 1: $Weekday_name = "(월)"; break;
					case 2: $Weekday_name = "(화)"; break;
					case 3: $Weekday_name = "(수)"; break;
					case 4: $Weekday_name = "(목)"; break;
					case 5: $Weekday_name = "(금)"; break;
					case 6: $Weekday_name = "(토)"; break;	
				}
				$g_date = substr($gameDate,5,2)."/".  substr($gameDate,8,2) . $Weekday_name ." ". $gameHour .":". $gameTime;	
				$rsi[$j]['g_date'] = $g_date;
				
				//폴더보너스 체크시 적용
				if($event==0)
				{	
					$cModel = Lemon_Instance::getObject("ConfigModel",true);
					
					$level	= $mModel->getMemberField($memberSn,'mem_lev');
					$field  = $cModel->getLevelConfigRow($level);
					$folderBonuses = explode(":", $field['lev_folder_bonus']);				
					
					$bonusRate=0;
					switch($rs[$i]['betting_cnt'])
					{
						case 3:  $bonusRate=$folderBonuses[0]; break;
						case 4:  $bonusRate=$folderBonuses[1]; break;
						case 5:  $bonusRate=$folderBonuses[2]; break;
						case 6:  $bonusRate=$folderBonuses[3]; break;
						case 7:  $bonusRate=$folderBonuses[4]; break;
						case 8:  $bonusRate=$folderBonuses[5]; break;
						case 9:  $bonusRate=$folderBonuses[6]; break;
						case 10: $bonusRate=$folderBonuses[7]; break;
					}
					
					$itemList[$bettingNo]['bonus_rate'] = $bonusRate;
					$itemList[$bettingNo]['folder_bonus'] = (int)($itemList[$bettingNo]['win_money']*$bonusRate/100);
				}
				else if($event==1)
				{	
					$cModel = Lemon_Instance::getObject("ConfigModel",true);
					
					$folderBonuses = $cModel->getEventConfigRow();
						
					$amount=0;
					switch($rs[$i]['betting_cnt'])
					{
						case 1:  $amount=$folderBonuses['bonus1']; break;
						case 2:  $amount=$folderBonuses['bonus2']; break;
						case 3:  $amount=$folderBonuses['bonus3']; break;
						case 4:  $amount=$folderBonuses['bonus4']; break;
						case 5:  $amount=$folderBonuses['bonus5']; break;
						case 6:  $amount=$folderBonuses['bonus6']; break;
						case 7:  $amount=$folderBonuses['bonus7']; break;
						case 8:  $amount=$folderBonuses['bonus8']; break;
						case 9:  $amount=$folderBonuses['bonus9']; break;
						case 10: $amount=$folderBonuses['bonus10']; break;
					}
					
					$itemList[$bettingNo]['folder_bonus'] = $amount;
				}
				
				$rsi[$j]['index'] = $index;
				$itemList[$bettingNo]['item'][] = $rsi[$j];
				++$index;
			//	$itemList[$bettingNo]['item'][] = $rsi[$j];
				
			} // end of 2nd for
		} // end of 1st for
				
		return $itemList;
	}

	//▶ 멤버의 배팅목록 (다기준)
	public function getMemberBetMultiList($memberSn, $page=0, $page_size=0, $beginDate='', $endDate='', $orderby='', $where='')
	{
		$mModel = Lemon_Instance::getObject("MemberModel",true);
		$pModel = Lemon_Instance::getObject("PartnerModel",true);		
	
		$sql = "select *
						from ".$this->db_qz."total_cart
						where member_sn ='".$memberSn."' and kubun ='Y' ".$where." and s_type=2";
		
		//Date
		if($beginDate!="" && $endDate!="")
		{
			$sql.=" and (bet_date between '".$beginDate."' and '".$endDate."') ";
		}

		//order by, limit
		$sql.=  " order by betting_no desc";
		if($page_size > 0)
		{
			$sql.= " limit ".$page.",".$page_size;
		}
		$rs = $this->db->exeSql($sql);
		
		$itemList = array();	
		
		$addWhere = " sn = ".$memberSn;
		$rsm = $mModel->getMemberRows('*', $addWhere);
		
		$recommend_sn =  $rsm[0]['recommend_sn'];
		if( $recommend_sn != '' )
			$rec_name = $pModel->getPartnerField( $recommend_sn, 'rec_name');
					
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$bettingNo = $rs[$i]["betting_no"];
			$rs[$i]['result_rate'] = $this->calcResultRate($bettingNo);
			$event = $rs[$i]["event"];

			$sql = "SELECT 	a.sub_child_sn,a.select_no,a.home_rate,a.away_rate,a.draw_rate,a.select_rate,a.game_type,a.result,b.sport_name,
							b.sn as child_sn, b.home_team,b.away_team,b.home_score,b.away_score,b.home_half_time_score,b.away_half_time_score,
							b.home_2nd_half_time_score,b.away_2nd_half_time_score,b.home_full_time_score,b.away_full_time_score,
							b.home_over_time_score,b.away_over_time_score,b.home_1_time_score,b.away_1_time_score,
							b.home_2_time_score,b.away_2_time_score,b.home_3_time_score,b.away_3_time_score,
							b.home_4_time_score,b.away_4_time_score,b.home_5_time_score,b.away_5_time_score,
							b.home_6_time_score,b.away_6_time_score,b.home_7_time_score,b.away_7_time_score,
							b.home_8_time_score,b.away_8_time_score,b.home_9_time_score,b.away_9_time_score,
							b.special,b.gameDate,b.gameHour,b.gameTime,c.name as league_name,c.lg_img as league_image, d.win
					FROM ".$this->db_qz."total_betting a, ".$this->db_qz."child_m b, ".$this->db_qz."league c, ".$this->db_qz."subchild_m d 
					WHERE a.betting_no='".$bettingNo."' and a.sub_child_sn=d.sn and b.league_sn=c.sn and b.sn=d.child_sn and a.s_type=2 ";

			if($orderby!='') {$sql.=" order by ".$orderby;}
							
			$rsi = $this->db->exeSql($sql);
			
			$itemList[$bettingNo] = $rs[$i];
			$itemList[$bettingNo]['member'] = $rsm[0];
			$itemList[$bettingNo]['rec_name'] = $rec_name;	
			
			$index = 0;
			
			for($j=0; $j<count((array)$rsi); ++$j)
			{
				$itemList[$bettingNo]['win_money'] = (int)($rs[$i]['betting_money']*$rs[$i]['result_rate']);
				$itemList[$bettingNo]['folder_bonus']=0;
				
				$gameDate = trim($rsi[$j]['gameDate']);				
				$gameHour = trim($rsi[$j]['gameHour']);
				$gameTime = trim($rsi[$j]['gameTime']);
				
				$strDay = date('w',strtotime($gameDate));
				switch($strDay)
				{
					case 0: $Weekday_name = "(일)"; break;
					case 1: $Weekday_name = "(월)"; break;
					case 2: $Weekday_name = "(화)"; break;
					case 3: $Weekday_name = "(수)"; break;
					case 4: $Weekday_name = "(목)"; break;
					case 5: $Weekday_name = "(금)"; break;
					case 6: $Weekday_name = "(토)"; break;	
				}
				$g_date = substr($gameDate,5,2)."/".  substr($gameDate,8,2) . $Weekday_name ." ". $gameHour .":". $gameTime;	
				$rsi[$j]['g_date'] = $g_date;
				
				//폴더보너스 체크시 적용
				if($event==0)
				{	
					$cModel = Lemon_Instance::getObject("ConfigModel",true);
					
					$level	= $mModel->getMemberField($memberSn,'mem_lev');
					$field  = $cModel->getLevelConfigRow($level);
					$folderBonuses = explode(":", $field['lev_folder_bonus']);				
					
					$bonusRate=0;
					switch($rs[$i]['betting_cnt'])
					{
						case 3:  $bonusRate=$folderBonuses[0]; break;
						case 4:  $bonusRate=$folderBonuses[1]; break;
						case 5:  $bonusRate=$folderBonuses[2]; break;
						case 6:  $bonusRate=$folderBonuses[3]; break;
						case 7:  $bonusRate=$folderBonuses[4]; break;
						case 8:  $bonusRate=$folderBonuses[5]; break;
						case 9:  $bonusRate=$folderBonuses[6]; break;
						case 10: $bonusRate=$folderBonuses[7]; break;
					}
					
					$itemList[$bettingNo]['bonus_rate'] = $bonusRate;
					$itemList[$bettingNo]['folder_bonus'] = (int)($itemList[$bettingNo]['win_money']*$bonusRate/100);
				}
				else if($event==1)
				{	
					$cModel = Lemon_Instance::getObject("ConfigModel",true);
					
					$folderBonuses = $cModel->getEventConfigRow();
						
					$amount=0;
					switch($rs[$i]['betting_cnt'])
					{
						case 1:  $amount=$folderBonuses['bonus1']; break;
						case 2:  $amount=$folderBonuses['bonus2']; break;
						case 3:  $amount=$folderBonuses['bonus3']; break;
						case 4:  $amount=$folderBonuses['bonus4']; break;
						case 5:  $amount=$folderBonuses['bonus5']; break;
						case 6:  $amount=$folderBonuses['bonus6']; break;
						case 7:  $amount=$folderBonuses['bonus7']; break;
						case 8:  $amount=$folderBonuses['bonus8']; break;
						case 9:  $amount=$folderBonuses['bonus9']; break;
						case 10: $amount=$folderBonuses['bonus10']; break;
					}
					
					$itemList[$bettingNo]['folder_bonus'] = $amount;
				}
				
				$rsi[$j]['index'] = $index;
				$itemList[$bettingNo]['item'][] = $rsi[$j];
				++$index;
			//	$itemList[$bettingNo]['item'][] = $rsi[$j];
				
			} // end of 2nd for
		} // end of 1st for
				
		return $itemList;
	}

	//-> 단일 카트 정보
	function getTotalCartInfo($member_sn, $betting_no)
	{
		$sql = "select * from ".$this->db_qz."total_cart where member_sn ='".$member_sn."' and betting_no ='".$betting_no."' and kubun ='Y'";
		$rs = $this->db->exeSql($sql);
		return $rs[0];
	}

	//-> 원기준 유저 배팅 카트 카운트 (관리자 호출, 유저가 삭제한것 포함)
	function getMemberTotalCartCnt($sn, $beginDate, $endDate, $where)
	{
		$sql = "select count(*) as cnt from ".$this->db_qz."total_cart where member_sn ='".$sn."' and kubun ='Y' ".$where;

		if($beginDate!="" && $endDate!="")
        {
            $sql.=" and (bet_date between '".$beginDate."' and '".$endDate."') ";
        }

		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}

	//-> 다기준 유저 배팅 카트 카운트 (관리자 호출, 유저가 삭제한것 포함)
	function getMemberTotalCartMultiCnt($sn, $beginDate, $endDate, $where)
	{
		$sql = "select count(*) as cnt from ".$this->db_qz."total_cart where member_sn ='".$sn."' and kubun ='Y' ".$where." and s_type=2";

		if($beginDate!="" && $endDate!="")
        {
            $sql.=" and (bet_date between '".$beginDate."' and '".$endDate."') ";
        }

		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}

	//▶ 유저가 베팅한 카트횟수
	function getMemberTotalCartCount($sn, $startDate="", $endDate="",$where="")
	{
		$sql = "select count(*) as cnt from ".$this->db_qz."total_cart
						where user_del<>'Y' and member_sn ='".$sn."' and kubun ='Y' ".$where;
	
		if( $startDate!="" && $endDate!="") 
		{
			$sql.= " and (bet_date between '".$startDate."' and '".$endDate."')";	
		}
		$rs = $this->db->exeSql($sql);

		return $rs[0]['cnt'];
	}
	
	//▶ 유저가 베팅한 베팅금액	
	function getMemberTotalBetMoney($sn, $beginDate="", $endDate="",$where="")
	{
		$sql = "select sum(betting_money) as bet_money 
							from ".$this->db_qz."total_cart
								where member_sn ='".$sn."' and kubun ='Y' ".$where;
								
		if( $beginDate!="" && $endDate!="") 
		{
			$sql.= " and (bet_date between '".$beginDate."' and '".$endDate."')";	
		}
		$rs = $this->db->exeSql($sql);
		
		return $rs[0]['bet_money'];				
	}
	
	//▶ 유저가 베팅한 베팅횟수
	function getMemberTotalBetCount($sn, $startDate="", $endDate="",$where="")
	{
		$cnt = 0;

		$sql = "select betting_no 
				from ".$this->db_qz."total_cart
					where user_del<>'Y' and member_sn ='".$sn."' and kubun ='Y' ".$where;
	
		if( $startDate!="" && $endDate!="") 
		{
			$sql.= " and (bet_date between '".$startDate."' and '".$endDate."')";	
		}
		$rs = $this->db->exeSql($sql);
		
		if(is_array($rs) && count((array)$rs) > 0) {
			for($i=0; $i<count((array)$rs); ++$i)
			{
				$bettingNo = $rs[$i]["betting_no"];
				
				$sql = "select count(*) as cnt
						from ".$this->db_qz."total_betting a, ".$this->db_qz."subchild b 
							where a.betting_no='".$bettingNo."' and a.sub_child_sn = b.sn";

				$rs_cnt = $this->db->exeSql($sql);
				
				$cnt += $rs_cnt[0]['cnt'];
			}
		}

		return $cnt;
	}
	
	//▶ 진행중인 베팅횟수
	function getMemberIngBetCount($sn, $startDate="", $endDate="")
	{
		$cnt = 0;
		
		$sql = "select betting_no 
				from ".$this->db_qz."total_cart
					where user_del<>'Y' and member_sn ='".$sn."' and kubun ='Y' ";
		
		if( $startDate != "" && $endDate != "" ) 
		{
			$sql.= " and (a.bet_date between '".$startDate."' and '".$endDate."')";	
		}
		$rs = $this->db->exeSql($sql);
		
		if(is_array($rs) && count((array)$rs) > 0) {
			for($i=0; $i<count((array)$rs); ++$i)
			{
				$bettingNo = $rs[$i]["betting_no"];
				
				$sql = "select count(*) as cnt
						from ".$this->db_qz."total_betting a, ".$this->db_qz."subchild b 
							where a.betting_no='".$bettingNo."' and a.sub_child_sn=b.sn and a.result=0";

				$rs_cnt = $this->db->exeSql($sql);
				
				$cnt += $rs_cnt[0]['cnt'];
			}
		}

		return $cnt;
	}

	function getBettingInfo($sn)
    {
        $sql = "select count(sn) as bet_count, sum(betting_money) as bet_money, sum(betting_money * result_rate) as profit_money
				from tb_total_cart
					where user_del<>'Y' and result = 0 and member_sn ='".$sn."'";

        $rs = $this->db->exeSql($sql);
        return $rs[0];
    }

	//▶ 끝난 베팅횟수
	function getMemberEndBetCount($sn, $startDate="", $endDate="")
	{	
		$cnt = 0;

		$sql = "select betting_no 
				from ".$this->db_qz."total_cart
					where user_del<>'Y' and member_sn ='".$sn."' and kubun ='Y' ";
	
		if( $startDate!="" && $endDate!="" )
		{
			$sql.= " and (a.bet_date between '".$startDate."' and '".$end_date."')";	
		}
		$rs = $this->db->exeSql($sql);
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$bettingNo = $rs[$i]["betting_no"];
			
			$sql = "select  count(*) as cnt
					from ".$this->db_qz."total_betting a , ".$this->db_qz."subchild b 
						where a.betting_no='".$bettingNo."' and a.sub_child_sn=b.sn and a.result>0";

			$rs_cnt = $this->db->exeSql($sql);			
			$cnt += $rs_cnt[0]['cnt'];
		}

		return $cnt;
		
	}
	
	//▶ 금일 이벤트 베팅횟수
	function getMemberTodayEventBetCount($memberSn)
	{
		$sql = "select count(*) as cnt
				from ".$this->db_qz."total_betting a,".$this->db_qz."child b,".$this->db_qz."total_cart c
					where a.sub_child_sn=b.sn and a.betting_no=c.betting_no
					and a.member_sn ='".$memberSn."' and b.event=1 and date(c.regdate)=date(now())";
	
		$rs = $this->db->exeSql($sql);
	
		return $rs[0]['cnt'];
		
	}
	
	//▶ 베팅 총합
	function getBettingListTotal($where="", $active=0, $gameSn="", $selectNo="")
	{
		if($active==1) 	$where = " and a.result!=2 ";
		if($gameSn!="")
		{
			$sql = "select sn from ".$this->db_qz."subchild where child_sn=".$gameSn;
			$rs = $this->db->exeSql($sql);
			$subSn = $rs[0]['sn'];
			
			$addWhere.= " and betting_no in(select distinct(betting_no) from ".$this->db_qz."total_betting where sub_child_sn=".$subSn;
			
			if($selectNo!="")
				$addWhere.= " and select_no=".$selectNo;
				
			$addWhere.= ")";
		}
		
		$sql = "select count(*) as cnt 
						from ".$this->db_qz."total_cart a inner join ".$this->db_qz."member b
						where a.member_sn=b.sn and a.logo='".$this->logo."' and a.kubun='Y' and a.is_account=1 ".$addWhere.$where;
		
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 베팅 목록
	function getBettingList($where, $page, $page_size, $active=0, $gameSn="", $selectNo="")
	{
		if($active==1)
			$where=" and a.result!=2 ";
			
		if($gameSn!="")
		{
			$sql = "select sn from ".$this->db_qz."subchild where child_sn=".$gameSn;
			$rs = $this->db->exeSql($sql);
			$subSn = $rs[0]['sn'];
			
			$addWhere.= " and betting_no in(select distinct(betting_no) from ".$this->db_qz."total_betting where sub_child_sn=".$subSn;
			
			if($selectNo!="")
				$addWhere.= " and select_no=".$selectNo;
				
			$addWhere.= ")";
		}
		
		if($page_size!=0)
			$limit = "limit ".$page.",".$page_size;
		
		$sql = "select 	a.member_sn, a.betting_no, a.betting_money, a.betting_ip, a.regDate,
										a.result_money, a.result_rate, a.result as aresult, a.betting_cnt, b.uid, b.nick, b.recommend_sn
						from ".$this->db_qz."total_cart a,".$this->db_qz."member b
						where		a.betting_no in(
										select betting_no from
										(select betting_no from ".$this->db_qz."total_cart where logo='".$this->logo."' and kubun='Y' ".$addWhere."order by betting_no desc ".$limit.") as t)
										and a.member_sn=b.sn and a.is_account=1".$where." order by a.regdate desc";
		
		$rs = $this->db->exeSql($sql);		
	
		$partnerModel = Lemon_Instance::getObject("PartnerModel",true);	
		for($i=0;$i<count((array)$rs); ++$i)
		{
			$member_sn = $rs[$i]['member_sn'];
			$betting_no =  $rs[$i]['betting_no'];
			$recommend_sn = $rs[$i]['recommend_sn'];
			
			$rsi = $this->getMemberBetDetailList($betting_no, $member_sn);			
		
			if($recommend_sn!="")
				$rec_id = $partnerModel->getPartnerField( $recommend_sn, 'rec_id');
				
			else $rec_id = "무소속";	
			
			$rs[$i]['win_count']=0;
			for($j=0; $j<count((array)$rsi); ++$j)
				if($rsi[$j]['result']==1) {$rs[$i]['win_count']+=1;}
			
			$rs[$i]['rec_id'] = $rec_id;
			$rs[$i]['item'] = $rsi;
		}

		return $rs;
	}
	
	//배팅내역 DB추출
	function getBet_Export()
	{
		$sql = "select a.member_sn,a.betting_no,a.betting_money,a.betting_ip, a.regDate,a.result_money,a.result_rate,a.result as aresult,a.betting_cnt,b.uid,b.nick,b.recommend_sn ";
		$sql.= " from ".$this->db_qz."total_cart a inner join ".$this->db_qz."member b ";
		$sql.= " where a.member_sn=b.sn and a.last_special_code < 3 and a.result = 0 and a.regdate between date_add(now(), interval -1 day) and now() order by a.regdate desc";
		
		$rs = $this->db->exeSql($sql);		
	
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$member_sn 		= $rs[$i]['member_sn'];
			$betting_no 	=  $rs[$i]['betting_no'];
			$recommend_sn = $rs[$i]['recommend_sn'];
			
			$rsi = $this->getMemberBetDetailList($betting_no, $member_sn);			
			
			$rs[$i]['item'] = $rsi;								
		}		
	
		return $rs;
	}

	//-> 적특처리 - 2015-12-25 개선 (배팅금은 돌려주고 배당금은 회수한다.)
	//-> 적특처리 - 2016-07-06 개선 (폴더수에 따라 마일리지 회수.)
	function modifyExceptionBet($total_betting_sn)
	{

		$sql = "select * from tb_total_betting where sn=".$total_betting_sn;
		$rs = $this->db->exeSql($sql);
		$sn = $rs[0]['member_sn'];
		$bettingNo = $rs[0]['betting_no'];
		$selectRate = $rs[0]['select_rate'];

		$sql = "select * from tb_total_cart where sn=".$total_betting_sn;
		$rs = $this->db->exeSql($sql);
		$specialCode = $rs[0]['last_special_code'];

		if ( $selectRate == "1.00") {
			return;
		}

		//-> 모든 배당 1.0으로 변경.
		$sql = "update tb_total_betting set home_rate = '1.00', draw_rate = '1.00', away_rate = '1.00', select_rate = '1.00', result = '4', admin_cancel_flag = '1' where sn=".$total_betting_sn;
		$this->db->exeSql($sql);		

		//-> 배당 1.0으로 변경으로 인해 cart에 총합 배당율을 빼준다 (나누기)
		$sql = "update tb_total_cart set result_rate=result_rate/".$selectRate." where betting_no='".$bettingNo."'";
		$this->db->exeSql($sql);

		//-> 해당 bettingNo에 모든 배팅 내역이 적특이라면 배팅금은 돌려주고 배당금이 있다면 회수한다.
		$sql = "select count(sn) as cnt from tb_total_betting where betting_no = '".$bettingNo."' and result != 4";
		$rs = $this->db->exeSql($sql);
		if ( !$rs[0]["cnt"] ) {
			//-> 모두 적특처리 됨. cart에 배팅금액, 배당금액 가져옴.
			$sql = "select member_sn, betting_money, result_money from tb_total_cart where betting_no = '".$bettingNo."' and result != 4";
			$rs = $this->db->exeSql($sql);
			$member_sn = $rs[0]['member_sn'];
			$betting_money = $rs[0]['betting_money'];
			$result_money = $rs[0]['result_money'];

			//-> cart 적특으로 처리.
			$sql = "update tb_total_cart set result_rate = '1.00', result_money = '0', result = '4' where betting_no = '".$bettingNo."'";
			$this->db->exeSql($sql);		

			//-> 회원 현재 보유머니
			$sql = "select g_money from tb_member where sn = '".$member_sn."'";
			$memInfo = $this->db->exeSql($sql);
			$beforeMoney = $memInfo[0]["g_money"];

			//-> 배팅금 될려줌.
			if ( $betting_money > 0 ) {
				$sql = "update tb_member set g_money = g_money + ".$betting_money." where sn = '".$member_sn."'";
				$this->db->exeSql($sql);

				//-> 머니로그 남기기.
				$afterMoney = $beforeMoney + $betting_money;
				$sql = "insert into tb_money_log(member_sn,amount,before_money,after_money,regdate,state, status_message, betting_no)
								values(".$member_sn.",".$betting_money.",".$beforeMoney.",".$afterMoney.",now(),5,'취소','".$bettingNo."')";
				$this->db->exeSql($sql);
				$beforeMoney = $afterMoney;
			}

			//-> 배당금이 있으면 회수함.
			if ( $result_money > 0 ) {
				$sql = "update tb_member set g_money = g_money - ".$result_money." where sn = '".$member_sn."'";
				$this->db->exeSql($sql);

				//-> 머니로그 남기기.
				$afterMoney = $beforeMoney - $result_money;
				$sql = "insert into tb_money_log(member_sn,amount,before_money,after_money,regdate,state, status_message, betting_no)
								values(".$member_sn.",".$betting_money.",".$beforeMoney.",".$afterMoney.",now(),5,'취소(배당금회수)','".$bettingNo."')";
				$this->db->exeSql($sql);		
			}			
		}

		$processModel = Lemon_Instance::getObject("processModel",true);

		//-> total_betting 정보를 가져와서 경기중/당첨/미당첨/취소/보너스 합계를 가져온다.
		$sql = "select a.*, c.sport_name, c.special from tb_total_betting a, tb_subchild_m b, tb_child_m c where a.sub_child_sn = b.sn and b.child_sn = c.sn and a.betting_no='".$bettingNo."'";
		$rsi = $this->db->exeSql($sql);

		$winCount = $loseCount = $cancelCount = $ingGameCount = $bonusGameCount = 0;	
		for ( $j = 0 ; $j < count((array)$rsi) ; $j++ ) {
			$betMoney = $rsi[$j]['bet_money'];
			$sportName = $rsi[$j]['sport_name'];

			if ( $rsi[$j]['result'] == 0 ) {
				++$ingGameCount;
			} else if ( $rsi[$j]['result'] == 1 ) {
				++$winCount;
				if ( strlen($sportName) != strlen(str_replace("보너스","",$sportName)) ) {
					++$bonusGameCount;
				}
			} else if ( $rsi[$j]['result'] == 2 ) {
				++$loseCount;
			} else if ( $rsi[$j]['result'] == 4 ) {
				++$cancelCount;
			}
		}

		//모든게임종료
		if ( $ingGameCount == 0 ) {
			$sportFolderCnt = $winCount + $loseCount - $bonusGameCount;

			//-> 낙첨카운트가 있거나 폴더수가 1개일 경우.
			if( $loseCount > 0 or $sportFolderCnt == 1 ) {
				//미니게임은 지급하지 않는다.
				if ( $specialCode < 5 ) {
					//-> 2폴 이상이 아니면 낙첨 마일리지가 지급됬는지 확인.
					if ( $sportFolderCnt < 2 ) {
						//-> 낙첨마일리지가 지급됬다면 회수.
						$sql = "select * from tb_mileage_log where amount > 0 and rollback_code = 0 and member_sn = '".$sn."' and state = 4 and betting_no = '".$bettingNo."'";
						$rs = $this->db->exeSql($sql);
						if ( count((array)$rs) ) {
							$mSn = $rs[0]["sn"];
							$amount = "-".$rs[0]["amount"];
							$rate = $rs[0]["rate"];
							$processModel->modifyMileageBackProcess($sn, $amount, 4, $bettingNo, $rate);

							$sql = "update tb_mileage_log set rollback_code = '1' where sn = '".$mSn."'";
							$this->db->exeSql($sql);
						}
					}
				}
			}

			//-> 2폴 이상이 아니면 추천인 마일리지가 지급됬는지 확인.
			if ( $specialCode < 3 ) {				
				if ( $sportFolderCnt < 2 ) {
					//-> 추천인 마일리지가 지급됬다면 회수.
					$sql = "select * from tb_mileage_log where amount > 0 and rollback_code = 0 and state = 12 and betting_no = '".$bettingNo."'";
					$rs = $this->db->exeSql($sql);
					if ( count((array)$rs) ) {
						for ( $i = 0 ; $i < count((array)$rs) ; $i++ ) {
							$mSn = $rs[$i]["sn"];
							$memSn = $rs[$i]["member_sn"];
							$amount = "-".$rs[$i]["amount"];
							$rate = $rs[$i]["rate"];
							$memo = $rs[$i]["log_memo"];
							$processModel->modifyMileageBackProcess($memSn, $amount, 12, $bettingNo, $rate, $memo);

							$sql = "update tb_mileage_log set rollback_code = '1' where sn = '".$mSn."'";
							$this->db->exeSql($sql);
						}
					}
				}
			}
		}

		return $bettingNo;
	}
	
	//▶ 베팅내역 상태변화
	function modifyViewState($memberSn, $bettingNo, $isHide=1)
	{
		if($isHide==1)
			$sql = "update ".$this->db_qz."total_cart set user_del='Y' where betting_no = '". $bettingNo ."'and member_sn=". $memberSn;
		else
			$sql = "update ".$this->db_qz."total_cart set user_del='N' where betting_no = '". $bettingNo ."'and member_sn=". $memberSn;

		return $this->db->exeSql($sql);
	}

	//▶ 취소된 베팅내역 상태변화
	function modifyCancelViewState($memberSn, $bettingNo, $isHide=1)
	{
		if($isHide==1)
			$sql = "update ".$this->db_qz."total_cart_cancel set user_del='Y' where betting_no = '". $bettingNo ."'and member_sn=". $memberSn;
		else
			$sql = "update ".$this->db_qz."total_cart_cancel set user_del='N' where betting_no = '". $bettingNo ."'and member_sn=". $memberSn;

		return $this->db->exeSql($sql);
	}

	//-> 유저 배팅내역 숨김	(선택형)
	function hide_betting($member_sn, $betting_list) {
		$sql = "update tb_total_cart set user_del = 'Y' where member_sn = '".$member_sn."' and betting_no = '".$betting_list."'";
		return $this->db->exeSql($sql);
	}

	//-> 유저 배팅내역 숨김	(전체)
	function hide_all_betting($member_sn)
	{
		$sql = "update ".$this->db_qz."total_cart set user_del='Y' where result <> 0 and member_sn=". $member_sn;
		return $this->db->exeSql($sql);
	}
	
	//▶ 베팅삭제
	function delCart($bettingNo, $cancel_id = "관리자")
	{
		$this->copyCartCancelToCart($bettingNo, $cancel_id);
		$sql = "delete from ".$this->db_qz."total_cart 
				where betting_no = '". $bettingNo ."'";
		$this->db->exeSql($sql);
		
		$sql = "delete from ".$this->db_qz."total_betting 
					where betting_no='". $bettingNo ."'";
		$this->db->exeSql($sql);
	}
	
	//▶ 취소배팅내역 복사
	function copyCartCancelToCart($bettingNo, $cancel_id = "관리자")
	{
		//취소배팅카트복사
		$sql = "INSERT INTO ".$this->db_qz."total_cart_cancel select * from ".$this->db_qz."total_cart where betting_no='".$bettingNo."'";
		$this->db->exeSql($sql);
		
		//취소시간, 취소한 유저 업데이트
		$sql = "update ".$this->db_qz."total_cart_cancel set operdate = now(), cancel_by = '" . $cancel_id . "' where betting_no = '".$bettingNo."'";
		$this->db->exeSql($sql);
		
		//취소배팅토탈복사
		$sql = "INSERT INTO ".$this->db_qz."total_betting_cancel select * from ".$this->db_qz."total_betting where betting_no='".$bettingNo."'";
		$this->db->exeSql($sql);

		// 해당 유저의 배팅취소개수 증가
		$sql = "select member_sn from ".$this->db_qz."total_cart where betting_no='".$bettingNo."'";
		$res = $this->db->exeSql($sql);
		$member_sn = 0;
		if(count((array)$res) > 0)
			$member_sn = $res[0]["member_sn"];

		if($cancel_id == "관리자") {
			$sql = "UPDATE tb_member SET bet_cancel_cnt = bet_cancel_cnt + 1 WHERE sn = " . $member_sn;
			$this->db->exeSql($sql);
		}

		// 취소한 경기들의 상태를 진행중에서 취소로 업데이트
		$sql = "UPDATE ".$this->db_qz."total_cart_cancel SET result = 4 WHERE betting_no='".$bettingNo."'";
		$this->db->exeSql($sql);

		$sql = "UPDATE ".$this->db_qz."total_betting_cancel SET result = 4 WHERE betting_no='".$bettingNo."'";
		$this->db->exeSql($sql);
	}
	
	//-> 게임중 낙첨 게임 카운트.
	function checkLoseGame($bettingNum = 0) {
		$sql = "select betting_no from ".$this->db_qz."total_betting where betting_no = '".$bettingNum."' and result = 2";
		$rows = $this->db->exeSql($sql);
		return $rows;
	}

	//▶ 보너스 배당 수정
	function modifyBonusRate($sn, $bonusRate, $bettingNo)
	{
		$sql = "update ".$this->db_qz."total_cart 
						set bouns_rate = '".$bonusRate."' 
						where member_sn='".$sn."' and betting_no='".$bettingNo."'";
					
		$this->db->exeSql($sql);
	}
	
	//-> 축벳 확인을 위해 같은게임에 같은 방향에 배팅한 이력이 있는지 확인.
	function checkCukBet($sn, $subChildSn, $selectedIdx, $betting_cnt = 0) {
		$sql = "select distinct(a.betting_no) from ".$this->db_qz."total_betting a, ".$this->db_qz."total_cart b where a.betting_no = b.betting_no and a.result = 0 and a.member_sn = '".$sn."' and a.sub_child_sn = '".$subChildSn."' and a.select_no = '".$selectedIdx."'";

		//-> 단폴더의 경우.
		if ( $betting_cnt == 1 ) {
			$sql = $sql." and b.betting_cnt = '1'";
		} else if ( $betting_cnt == 2 ) {
			$sql = $sql." and b.betting_cnt > '1'";
		}
		$rows = $this->db->exeSql($sql);
		return $rows;
	}

	//-> 축벳 확인을 위해 batting_sn의 select_rate를 가져온다. (계산은 컨트롤러에서)
	function checkCukBet_rate($sn, $betting_no) {
		$sql = "select select_rate, bet_money from ".$this->db_qz."total_betting where member_sn = '".$sn."' and betting_no = '".$betting_no."'";
		$rows = $this->db->exeSql($sql);
		return $rows;
	}

	//▶ 베팅
	function addBet($memberSn, $childSn, $subChildSn, $protoId, $selectedIdx, $rate1, $rate2, $rate3, $selectedRate, $gameType, $buy, $betting, $s_type = 0, $betid = 0)
	{
		//가라배팅 내역
		$result=0;
				
		// if($memberSn==0)
		// {
		// 	$sq="select win from ".$this->db_qz."subchild_m where sn=".$subChildSn;
		// 	$rs=$this->db->exeSql($sq);
		// 	$win=$rs[0]['win'];

		// 	if($win==4){$result='4';}
		// 	else if($win==$selectedIdx){$result='1';}
		// 	else {$result='2';}
		// }

		//-> 배당검증
		$sql = "select home_rate, draw_rate, away_rate from tb_subchild where sn = '{$subChildSn}'";
		$row = $this->db->exeSql($sql);
		if ( $row[0]["home_rate"] != $rate1 or $row[0]["draw_rate"] != $rate2 or $row[0]["away_rate"] != $rate3 ) {
			$rate1 = $row[0]["home_rate"];
			$rate2 = $row[0]["draw_rate"];
			$rate3 = $row[0]["away_rate"];
		}

		$sql = "insert into ".$this->db_qz."total_betting(sub_child_sn,member_sn,betting_no,select_no,home_rate,draw_rate,away_rate, select_rate,game_type,event,result,kubun,bet_money,s_type,betid)";
		$sql.= "values('". $subChildSn ."','". $memberSn."','". $protoId ."','". $selectedIdx ."',";
		if($betid == 0 && $s_type == 0) {
			$sql.= "'". $rate1 ."','". $rate2 ."','". $rate3 ."','". $selectedRate ."','". $gameType ."','0','1','". $buy ."','". $betting ."','". $s_type ."','". $betid ."')";
		} else {
			$sql.= "'". $rate1 ."','". $rate2 ."','". $rate3 ."','". $selectedRate ."','". $gameType ."','0','".$result."','". $buy ."','". $betting ."','". $s_type ."','". $betid ."')";
		}
		
		
		$this->db->exeSql($sql);

		$sql = "update ".$this->db_qz."subchild set bet_money=bet_money +".$betting." where sn=".$subChildSn;
		$this->db->exeSql($sql);
		
		//-> 상세 배팅로그 file
		$hDate = date("Y-m-d H:i:s",time());
		$fileName = "BTLOG_".date("Ymd",time()).".log";
		$logFile = @fopen("/home/gadget/www_gadget_1.com/Lemonade/_logs/betting/".$fileName,"a");
		if ( $logFile ) {
			if ( $selectedIdx == 1 ) $selectTeam = "home";
			else if ( $selectedIdx == 2 ) $selectTeam = "away";
			else if ( $selectedIdx == 3 ) $selectTeam = "draw";
			@fwrite($logFile, "BettingNo[{$protoId}]->MemberSn[{$memberSn}]->SubChildSn[{$subChildSn}]->SelctNo[{$selectTeam}]->HomeRate[{$rate1}]->DrawRate[{$rate2}]->AwayRate[{$rate3}]->Money[{$betting}]->Date[{$hDate}]\n");
			@fclose($logFile);
		}

		//-> 유저별 검증용 배팅로그 file
		$fileName = date("Ymd",time())."_{$memberSn}.log";
		$logFile = @fopen("/home/gadget/www_gadget_1.com/Lemonade/_logs/user/".$fileName,"a");
		if ( $logFile ) {
			@fwrite($logFile, "'{$protoId}_{$subChildSn}':'{$selectedIdx}'\n");
			@fclose($logFile);
		}
	}
	
	//▶ 카트
	function addCart($sn, $parentIdx, $bettingNo, $buy, $betCount, $dbCash, $betMoney, $resultRate, $partnerSn='', $rollingSn='', $accountEnable=1/*정산에 포함여부*/,$bet_date='', $lastSpecialCode=0, $s_type = 0)
	{
		$result=0;
		if($sn==0)
		{
			$sq="select result from ".$this->db_qz."total_betting where betting_no='".$bettingNo."'";
			
			$rs=$this->db->exeSql($sq);

			for($i=0; $i < count((array)$rs); $i++)
			{
				if($rs[$i]['result']=='2'){$result=2;break;}
				else {$result=1;}
			}
		}
		
		$commonModel = Lemon_Instance::getObject("CommonModel",true);
		
		if($bet_date=='')	$bet_date='now()';
		else 							$bet_date="'".$bet_date."'";
		
		if($partnerSn=="")	$partnerSn="0";
		if($rollingSn=="")	$rollingSn="0";
		
		$bettingIp = $commonModel->newGetIp();
		
		$sql = "insert into ".$this->db_qz."total_cart(member_sn, betting_no, parent_sn, regdate, operdate, kubun, result, betting_cnt, before_money, betting_money, result_rate,result_money,";
		$sql.= "partner_sn,rolling_sn,bouns_rate,user_del,bet_date,is_account,betting_ip,last_special_code,logo,s_type) values('".$sn."','". $bettingNo ."','".$parentIdx."',now(),now(),";
		$sql.=  "'". $buy ."','".$result."','". $betCount ."',".$dbCash.",'".$betMoney."','".$resultRate."',0,".$partnerSn.",".$rollingSn.",'0','N',".$bet_date.",".$accountEnable.",'".$bettingIp."','".$lastSpecialCode."','".$this->logo."','".$s_type."')";
		//echo $sql;exit;
		$this->db->exeSql($sql);
	}
	
	//->동일경기 배팅횟수제한 (단폴더+같은게임+같은 방향)
	function isLimitBetCnt($childSn, $selected, $memberSn) {
		$sql = "select count(*) as totcnt from ".$this->db_qz."child a, ".$this->db_qz."subchild b, ".$this->db_qz."total_betting c, ".$this->db_qz."total_cart d
					 where a.sn=b.child_sn and b.sn=c.sub_child_sn and c.betting_no=d.betting_no and a.sn='".$childSn."' and d.member_sn='".$memberSn."' and c.select_no=".$selected;
		$rs = $this->db->exeSql($sql);
		if($rs[0]['totcnt'] > 0)
			return 0;
		else return 1;
	}

	//-> 3가지 타입(사다리)중 같은회차 1개라도 배팅되었는지 체크
	function isLimitBet3GameUkCnt($childSn, $memberSn,$specialType)
	{
		$sql = "select gameDate, gameHour, gameTime from ".$this->db_qz."child where sn='".$childSn."'";
		$rs = $this->db->exeSql($sql);
		$gameDate = $rs[0]['gameDate'];
		$gameHour = $rs[0]['gameHour'];
		$gameTime = $rs[0]['gameTime'];

		$sql = "select count(*) as totcnt from ".$this->db_qz."child a, ".$this->db_qz."subchild b, ".$this->db_qz."total_betting c, ".$this->db_qz."total_cart d where 
						a.sn=b.child_sn and b.sn=c.sub_child_sn and c.betting_no=d.betting_no and a.special='".$specialType."' and 
						a.gameDate = '".$gameDate."' and a.gameHour = '".$gameHour."' and a.gameTime = '".$gameTime."' and d.member_sn='".$memberSn."'";
		$rs = $this->db->exeSql($sql);
		if($rs[0]['totcnt'] > 0)
			return 0;
		else return 1;
	}



	//-> 3가지 타입(사다리)중 같은회차같은 게임 1개라도 배팅되었는지 체크
	function isLimitBet3GameUkCnt2($childSn, $memberSn,$specialType,$LeagueSn)
	{
		$sql = "select gameDate, gameHour, gameTime from ".$this->db_qz."child where sn='".$childSn."'";
		$rs = $this->db->exeSql($sql);
		$gameDate = $rs[0]['gameDate'];
		$gameHour = $rs[0]['gameHour'];
		$gameTime = $rs[0]['gameTime'];

		$sql = "select count(*) as totcnt from ".$this->db_qz."child a, ".$this->db_qz."subchild b, ".$this->db_qz."total_betting c, ".$this->db_qz."total_cart d where 
						a.sn=b.child_sn and b.sn=c.sub_child_sn and c.betting_no=d.betting_no and a.special='".$specialType."' and 
						a.gameDate = '".$gameDate."' and a.gameHour = '".$gameHour."' and a.gameTime = '".$gameTime."' and d.member_sn='".$memberSn."'";
		$rs = $this->db->exeSql($sql);
		if($rs[0]['totcnt'] > 0)
			return 0;
		else return 1;
	}


	//-> 동일경기 배팅횟수제한 (단폴더, 같은게임만)
	function isLimitBetUkCnt($childSn, $memberSn) {
		$sql = "select count(*) as totcnt from ".$this->db_qz."child a, ".$this->db_qz."subchild b, ".$this->db_qz."total_betting c, ".$this->db_qz."total_cart d
					 where a.sn=b.child_sn and b.sn=c.sub_child_sn and c.betting_no=d.betting_no and a.sn='".$childSn."' and d.member_sn='".$memberSn."'";
		$rs = $this->db->exeSql($sql);
		if($rs[0]['totcnt'] > 0)
			return 0;
		else return 1;
	}

	//-> 사다리 배팅 폴더수 확인
	function getBettingFolder($childSn, $memberSn) {
		$sql = "select gameDate, gameHour, gameTime from ".$this->db_qz."child where sn='".$childSn."'";
		$rs = $this->db->exeSql($sql);
		$gameDate = $rs[0]['gameDate'];
		$gameHour = $rs[0]['gameHour'];
		$gameTime = $rs[0]['gameTime'];

		$sql = "select count(*) as totcnt from ".$this->db_qz."child a, ".$this->db_qz."subchild b, ".$this->db_qz."total_betting c where
						a.sn=b.child_sn and b.sn=c.sub_child_sn and a.special='3' and 
						a.gameDate = '".$gameDate."' and a.gameHour = '".$gameHour."' and a.gameTime = '".$gameTime."' and c.member_sn='".$memberSn."'";
		$rs = $this->db->exeSql($sql);
		return $rs[0]['totcnt']+0;
	}

	//-> 미니게임 배팅 카트수 확인
	function getCartFolder($childSn, $memberSn, $specialCode = 3) {
		$sql = "select gameDate, gameHour, gameTime from ".$this->db_qz."child where sn='".$childSn."'";
		$rs = $this->db->exeSql($sql);
		$gameDate = $rs[0]['gameDate'];
		$gameHour = $rs[0]['gameHour'];
		$gameTime = $rs[0]['gameTime'];

		$sql = "select d.sn from ".$this->db_qz."child a, ".$this->db_qz."subchild b, ".$this->db_qz."total_betting c, ".$this->db_qz."total_cart d where
						a.sn=b.child_sn and b.sn=c.sub_child_sn and c.betting_no = d.betting_no and a.special='".$specialCode."' and 
						a.gameDate = '".$gameDate."' and a.gameHour = '".$gameHour."' and a.gameTime = '".$gameTime."' and c.member_sn='".$memberSn."' group by d.betting_no";
		$rs = $this->db->exeSql($sql);
		return count((array)$rs)+0;
	}

    //-> 미니게임 동일배팅 카트수 확인
    function getCartFolder_withSelectNo($childSn, $memberSn, $selectTeam, $specialCode = 3) {
        $sql = "select gameDate, gameHour, gameTime from ".$this->db_qz."child where sn='".$childSn."'";
        $rs = $this->db->exeSql($sql);
        $gameDate = $rs[0]['gameDate'];
        $gameHour = $rs[0]['gameHour'];
        $gameTime = $rs[0]['gameTime'];

        /*$sql = "select d.sn from ".$this->db_qz."child a, ".$this->db_qz."subchild b, ".$this->db_qz."total_betting c, ".$this->db_qz."total_cart d where
						a.sn=b.child_sn and b.sn=c.sub_child_sn and c.betting_no = d.betting_no and a.special='".$specialCode."' and 
						a.gameDate = '".$gameDate."' and a.gameHour = '".$gameHour."' and a.gameTime = '".$gameTime."' and c.member_sn='".$memberSn."' and c.select_no=".$selectTeam." group by d.betting_no";*/
        $sql = "select d.sn from ".$this->db_qz."child a, ".$this->db_qz."subchild b, ".$this->db_qz."total_betting c, ".$this->db_qz."total_cart d where
						a.sn=b.child_sn and b.sn=c.sub_child_sn and c.betting_no = d.betting_no and a.special='".$specialCode."' and 
						a.gameDate = '".$gameDate."' and a.gameHour = '".$gameHour."' and a.gameTime = '".$gameTime."' and c.member_sn='".$memberSn."' group by d.betting_no";
        $rs = $this->db->exeSql($sql);
        return count((array)$rs)+0;
    }

	//-> 게임타입별 배팅 카트수 확인
	function getGameTypeToCart($memberSn, $gameDate, $gameTh, $specialCode, $gameCode) {
		$sql = "select count(*) as totcnt from tb_child a, tb_subchild b, tb_total_betting c, tb_total_cart d
					 where a.sn=b.child_sn and b.sn=c.sub_child_sn and c.betting_no=d.betting_no and a.special = '{$specialCode}' and a.gameDate='{$gameDate}' and a.game_th = '{$gameTh}' and d.member_sn='{$memberSn}' and a.game_code IN ({$gameCode})";
		$rs = $this->db->exeSql($sql);
		return $rs[0]['totcnt']+0;
	}
	
	function isRateChanged($childSn, $homeRate, $drawRate, $awayRate)
	{
		$sql = "select cast(b.home_rate as decimal(10,2)) as home_rate, cast(b.draw_rate as decimal(10,2)) as draw_rate, cast(b.away_rate as decimal(10,2)) as away_rate
						from ".$this->db_qz."child a, ".$this->db_qz."subchild b
						where a.sn=b.child_sn and a.sn=".$childSn;
						
		$rs = $this->db->exeSql($sql);
		
		if($rs[0]['home_rate']==$homeRate && $rs[0]['draw_rate']==$drawRate && $rs[0]['away_rate']==$awayRate)
		{
			return 0;
		}

		else 
		{
			return 1;
		}
	}
	
	function isBettingCancelEnable($bettingNo, $enalbeTime)
	{
		$sql = "select * from ".$this->db_qz."child a, ".$this->db_qz."subchild b
						where a.sn=b.child_sn and b.sn in (select sub_child_sn from ".$this->db_qz."total_betting where betting_no='".$bettingNo."')";
		$rs = $this->db->exeSql($sql);
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$gameTime 	= Trim($rs[$i]["gameDate"]) ." ".Trim($rs[$i]["gameHour"]).":". Trim($rs[$i]["gameTime"]);
			$remainTime = (strtotime($gameTime)-strtotime(date("Y-m-d H:i")))/60;
			
			if($remainTime < $enalbeTime)
			{
				return 0;
			}
		}
		return 1;
	}
	
	function topWinnersList()
	{
		$sql = "select b.uid, a.result_money, a.result_rate  from 
					".$this->db_qz."total_cart a, ".$this->db_qz."member b
					where 	a.member_sn=b.sn 
								and a.result_money>0
								and b.mem_status='N'
					order by a.operdate desc
					limit 0, 10";
					
		
		$rs = $this->db->exeSql($sql);
		for($i = 0; $i < count((array)$rs); ++$i)
		{
			$id = $rs[$i]["uid"];
			$len = strlen($id);
			$rs[$i]["uid"] = substr($id, 0, 3);
			$rs[$i]["uid"] = str_pad($rs[$i]["uid"], $len, '*', STR_PAD_RIGHT ); 
		}
		return $rs;
	}
	
	/* function getLiveGameMemberBettingListTotal($member_sn, $begin_date="", $end_date="")
	{
		$sql = "select count(*) as cnt from ".$this->db_qz."live_betting
						where member_sn=".$member_sn;
	
		if( $begin_date!="" && $end_date!="") 
		{
			$sql.= " and (reg_time between '".$begin_date."' and '".$end_date."')";	
		}
		$rows = $this->db->exeSql($sql);

		return $rows[0]['cnt'];
	}
	
	function getLiveGameMemberBettingList($member_sn, $page=0, $page_size=0, $begin_date='', $end_date='')
	{
		$sql = "select * from ".$this->db_qz."member a,  ".$this->db_qz."live_game b,  ".$this->db_qz."live_betting c, ".$this->db_qz."live_game_detail d, ".$this->db_qz."live_game_template e
						where a.sn=c.member_sn and b.sn=c.live_sn and d.sn=c.live_detail_sn and d.template=e.template and a.sn =".$member_sn;
	
		if( $begin_date!="" && $end_date!="") 
		{
			$sql.= " and (c.reg_time between '".$begin_date."' and '".$end_date."')";	
		}
		
		$sql.= " order by c.betting_no desc";
		if($page_size>0)
			$sql.= " limit ".$page.",".$page_size;
		
		$rows = $this->db->exeSql($sql);
		
		return $rows;
	} */

	function getLiveGameMemberBettingListTotal($member_sn, $begin_date="", $end_date="")
	{
		$sql = "select count(*) as cnt from ".$this->db_qz."live_betting
						where member_sn=".$member_sn;
	
		if( $begin_date!="" && $end_date!="") 
		{
			$sql.= " and (reg_time between '".$begin_date."' and '".$end_date."')";	
		}
		$rows = $this->db->exeSql($sql);

		return $rows[0]['cnt'];
	}
	
	function getLiveGameMemberBettingList($member_sn, $page=0, $page_size=0, $begin_date='', $end_date='')
	{
		$sql = "select * from ".$this->db_qz."member a,  ".$this->db_qz."live_game b,  ".$this->db_qz."live_betting c, ".$this->db_qz."live_game_detail d, ".$this->db_qz."live_game_template e
						where a.sn=c.member_sn and b.sn=c.live_sn and d.sn=c.live_detail_sn and d.template=e.template and a.sn =".$member_sn;
	
		if( $begin_date!="" && $end_date!="") 
		{
			$sql.= " and (c.reg_time between '".$begin_date."' and '".$end_date."')";	
		}
		
		$sql.= " order by c.betting_no desc";
		if($page_size>0)
			$sql.= " limit ".$page.",".$page_size;
		
		$rows = $this->db->exeSql($sql);
		
		return $rows;
	}

	function isRateChangedMulti($subchildSn, $homeRate, $drawRate, $awayRate)
	{
		$sql = "select cast(b.home_rate as decimal(10,2)) as home_rate, cast(b.draw_rate as decimal(10,2)) as draw_rate, cast(b.away_rate as decimal(10,2)) as away_rate
						from ".$this->db_qz."child a, ".$this->db_qz."subchild b
						where a.sn=b.child_sn and b.sn=".$subchildSn;
						
		$rs = $this->db->exeSql($sql);
		
		if($rs[0]['home_rate']==$homeRate && $rs[0]['draw_rate']==$drawRate && $rs[0]['away_rate']==$awayRate)
		{
			return 0;
		}

		else 
		{
			return 1;
		}
	}
}
?>