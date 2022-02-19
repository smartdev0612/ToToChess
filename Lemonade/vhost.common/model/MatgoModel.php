<?php

class MatgoModel extends Lemon_Model 
{			
	function bettingTypeToStr($bettingType)
	{
		$str="";
		switch($bettingType)
		{
			case 5: $str="Call"; break;
			case 6: $str="Check"; break;
			case 7: $str="Fold"; break;
			case 8: $str="Raise"; break;
			case 9: $str="All-in"; break;
			case 10: $str="samll-blind"; break;
			case 11: $str="big-blind"; break;
			case 12: $str="post-blind"; break;
		}
		return $str;
	}
	
	function gameLogList($where="", $page="", $page_size="")
	{
		if($page_size!="")
			$limit = " limit ".$page.",".$page_size;
			
		$sql = "select *
						from 	tb_godoriresultlog
						where 1=1".$where."
						order by nLogTime desc".$limit;
									
		$rs = $this->db->exeSql($sql);

		return $rs;
	}
	
	function popupGameLogList($where="")
	{
		if($page_size!="")
			$limit = " limit ".$page.",".$page_size;
			
		$sql = "select 	a.*,
										b.*
						from 	".$this->db_qz."holdem_log_room a,
								 	".$this->db_qz."holdem_log_user b
						where a.room_no=b.room_no
									and a.start_time=b.start_time".$where."
						order by a.start_time desc".$limit;
									
		$rs = $this->db->exeSql($sql);

		$rgbTable = array("listA", "listB", "listC", "listD");
		$iColorIndex=0;
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$iRoomNo = $rs[$i]["room_no"];
			$iStartTime = $rs[$i]["start_time"];
			
			if($colorKey[$iRoomNo][$iStartTime]["bg_color"]=="")
			{
				if($iColorIndex >= count((array)$rgbTable))
					$iColorIndex=0;
					
				$colorKey[$iRoomNo][$iStartTime]["bg_color"]=$rgbTable[$iColorIndex++];
			}
			
			$rs[$i]["format_start_time"] = strftime("%Y-%m-%d %H:%M:%S", $rs[$i]["start_time"]);
			$rs[$i]["bg_color"] = $colorKey[$iRoomNo][$iStartTime]["bg_color"];
			
			// Betting Log Begin
			$log="";
			$preBettingLog = explode("&", $rs[$i]["pre_betting_log"]);
			for($j=0;$j<count((array)$preBettingLog); ++$j)
			{ 
				$array = explode(",", $preBettingLog[$j]);
				$turnSequence = $array[0];
				if($turnSequence=="") continue;
				$bettingType 	= $array[2];
				$bettingType = $this->bettingTypeToStr($bettingType);
				$bettingMoney	= $array[3];
				
				$log .= "turn:".$turnSequence.", type:".$bettingType.", money:".$bettingMoney."<br>";
				$rs[$i]["format_pre_betting_log"] = $log;
			}
			$log="";
			
			$preFlopBettingLog = explode("&", $rs[$i]["pre_flop_betting_log"]);
			for($j=0;$j<count((array)$preFlopBettingLog); ++$j)
			{ 
				$array = explode(",", $preFlopBettingLog[$j]);
				$turnSequence = $array[0];
				if($turnSequence=="") continue;
				$bettingType 	= $array[2];
				$bettingType = $this->bettingTypeToStr($bettingType);
				$bettingMoney	= $array[3];
				
				$log .= "turn:".$turnSequence.", type:".$bettingType.", money:".$bettingMoney."<br>";
				$rs[$i]["format_pre_flop_betting_log"] = $log;
			}
			$log="";
			
			$flopBettingLog = explode("&", $rs[$i]["flop_betting_log"]);
			for($j=0;$j<count((array)$flopBettingLog); ++$j)
			{ 
				$array = explode(",", $flopBettingLog[$j]);
				$turnSequence = $array[0];
				if($turnSequence=="") continue;
				$bettingType 	= $array[2];
				$bettingType = $this->bettingTypeToStr($bettingType);
				$bettingMoney	= $array[3];
				
				$log .= "turn:".$turnSequence.", type:".$bettingType.", money:".$bettingMoney."<br>";
				$rs[$i]["format_flop_betting_log"] = $log;
			}
			$log="";
			
			$turnBettingLog = explode("&", $rs[$i]["turn_betting_log"]);
			for($j=0;$j<count((array)$turnBettingLog); ++$j)
			{ 
				$array = explode(",", $turnBettingLog[$j]);
				$turnSequence = $array[0];
				if($turnSequence=="") continue;
				$bettingType 	= $array[2];
				$bettingType = $this->bettingTypeToStr($bettingType);
				$bettingMoney	= $array[3];
				
				$log .= "turn:".$turnSequence.", type:".$bettingType.", money:".$bettingMoney."<br>";
				$rs[$i]["format_turn_betting_log"] = $log;
			}
			$log="";
			
			$riverBettingLog = explode("&", $rs[$i]["river_betting_log"]);
			for($j=0;$j<count((array)$riverBettingLog); ++$j)
			{ 
				$array = explode(",", $riverBettingLog[$j]);
				$turnSequence = $array[0];
				if($turnSequence=="") continue;
				$bettingType 	= $array[2];
				$bettingType = $this->bettingTypeToStr($bettingType);
				$bettingMoney	= $array[3];
				
				$log .= "turn:".$turnSequence.", type:".$bettingType.", money:".$bettingMoney."<br>";
				$rs[$i]["format_river_betting_log"] = $log;
			}
			$log="";
			
			// Betting Log End
		}
		
		return $rs;
	}
	
	function gameLogListTotal($where="")
	{
		$sql = "select 	count(*) as cnt
						from 	tb_godoriresultlog
						where 1=1".$where;
									
		$rs = $this->db->exeSql($sql);
		return $rs[0]["cnt"];
	}
	
	function getLogStaticData($beginDate, $endDate)
	{
		if($beginDate=="" or $endDate=="")
			$beginDate = date("Y-m-d");
		
		$data = array();
		$unixTimeBegin 	= 	strtotime($beginDate." 00:00:00");
		$unixTimeEnd 		= 	strtotime($endDate." 23:59:59");
		$where = " and start_time between ".$unixTimeBegin." and ".$unixTimeEnd;
		
		$sql = "select sum(total_betting_money) as total_betting
						from holdem_log_user
						where start_time between ".$unixTimeBegin." and ".$unixTimeEnd;
		$rs = $this->db->exeSql($sql);				
		$data["total_betting"] = $rs[0]["total_betting"];
		
		$sql = "select count(*) as cnt
						from holdem_log_user
						where start_time between ".$unixTimeBegin." and ".$unixTimeEnd;
		$rs = $this->db->exeSql($sql);				
		$data["game_count"] = $rs[0]["cnt"];
		
		$sql = "select dealer_cost from game_setup";
		$rs = $this->db->exeSql($sql);				
		$dealerRate = $rs[0]["dealer_cost"];
		
		$data["commission"] = $dealerRate;
		
		$data["dealer_commission"] = $dealerRate*$data["total_betting"]/100;
		
		return $data;
	}
	
	function gameServerList()
	{
		$sql = "select *
						from game_servers";
						
		$rs = $this->db->exeSql($sql);
		return $rs;
	}
	
	//▶ 입출금 통계 
	function getAccountList($parentSn='', $partnerSn='', $beginDate='', $endDate='')
	{
		$list = array();

		$cartModel = Lemon_Instance::getObject("CartModel",true);
		
		if($beginDate!="" && $endDate!="")
		{
			$sql = "select datediff(date('".$endDate."'),date('".$beginDate."'))+1 as sumday";
			
			$rs = $this->db->exeSql($sql);
			$sumday = $rs[0]["sumday"];
			
			$item = array();
			for($i=$sumday; $i>0; --$i)
			{
				$interval = $i-1;
				$sql = "select date(date_sub(date('".$endDate."'),interval ".$interval." day)) as current";
				
				$rsi = $this->db->exeSql($sql);
				
				$item[$i]['current_date'] = $currentDate = $rsi[0]["current"];
				$item[$i]['current_date_name']	=$this->dateName($currentDate);
				
				// 관리자
				$sql = "select sum(amount) as manager_amount from tb_mileage_log a, tb_people b
								where a.member_sn=b.sn and a.state=14 and b.mem_status='G'
								and date(a.regdate)='".$item[$i]['current_date']."'";
								
				$rsi = $this->db->exeSql($sql);
				$item[$i]['manager_amount'] = $rsi[0]['manager_amount'];
				
				// 유저
				$sql = "select sum(amount) as user_amount from tb_mileage_log a, tb_people b
								where a.member_sn=b.sn and a.state=14 and b.mem_status='N'
								and date(a.regdate)='".$item[$i]['current_date']."'";
								
				$rsi = $this->db->exeSql($sql);
				$item[$i]['user_amount'] = $rsi[0]['user_amount'];
				
				$sql = "select sum(nPayMoney) as commission from tb_godoriresultlog
								where date(dtLogTime)='".$item[$i]['current_date']."'";
								
				$rsi = $this->db->exeSql($sql);
				$item[$i]['commission'] = $rsi[0]['commission'];
				
				
				$list[] = $item[$i];
			}
		}

		return $list;
	}
	
	function getUserCount()
	{
		$sql = "select count(*) as cnt from tb_godoriuser 
						where nServerID!=-1";
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
}
?>