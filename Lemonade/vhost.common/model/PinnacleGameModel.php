<?php
class PinnacleGameModel extends Lemon_Model 
{
	function getGameList($where="")
	{
		$list = array();
		
		$sql = "select a.sn as game_sn, a.event_id, a.league_sn, a.home_team, a.away_team, a.start_time as start_time, a.home_score, a.away_score, a.state, a.sport,
					b.sn as detail_sn, b.template, b.home_rate, b.draw_rate, b.away_rate, b.paused, b.home_rate_variation, b.draw_rate_variation, b.away_rate_variation,
					c.name
					from tb_pinnacle_game a, tb_pinnacle_game_detail b, tb_league c 
					where a.league_sn=c.sn and a.sn=b.game_sn and a.state='PLAY' and start_time > sysdate() 
								and start_time <= date_add(sysdate(), INTERVAL 1 day) and b.update_time >= date_add(sysdate(), INTERVAL -1 minute)".$where."
						order by a.start_time asc, home_team, template, draw_rate";
		$rows = $this->db->exeSql($sql);
		
		//리그별 정렬
		for( $i=0; $i<count((array)$rows); ++$i)
		{
			$key = $rows[$i]['league_sn'];
			$key .= $rows[$i]['start_time'];
			$list[$key]['league_name']	= $rows[$i]['name'];
			$list[$key]['item'][] = $rows[$i];
		}

		return $list;	
	}
	
	function hide_betting($betting_sn)
	{
		$data['visible'] = 'N';
		$this->db->setUpdate($this->db_qz."pinnacle_betting", $data, "sn=".$betting_sn);
		return $this->db->exeSql();
	}
	
	function is_odds_same($detail_sn, $position, $odd)
	{
		$sql = "select home_rate, draw_rate, away_rate
						from tb_pinnacle_game_detail a, tb_pinnacle_game b
						where a.game_sn=b.sn and a.sn=".$detail_sn;
		$rows = $this->db->exeSql($sql);
		
		if(count((array)$rows)<=0)
			return 0;
		
		if($position=="1")
		{
			//if( number_format($rows[0]['home_rate'],2)==$odd)
			if( $rows[0]['home_rate']==$odd)
				return 1;	
		}
		else if($position=="X")
		{
			//if( number_format($rows[0]['draw_rate'],2)==$odd)
			if( $rows[0]['draw_rate']==$odd)
				return 1;
		}
		else if($position=="2")
		{
			//if( number_format($rows[0]['away_rate'],2)==$odd)
			if( $rows[0]['away_rate']==$odd)
				return 1;
		}
		
		return 0;
	}
	
	function last_betting_time($member_sn)
	{
		$sql = "select reg_time
						from tb_pinnacle_betting
						where member_sn=".$member_sn." order by reg_time desc limit 0,1";
		$rs = $this->db->exeSql($sql);
		return $rs[0]['reg_time'];
	}
	
	function pinnacle_betting($member_sn, $detail_sn, $betting_no, $odd, $betting_money, $betting_position)
	{
		$common_model = Lemon_Instance::getObject("CommonModel",true);
		
		$sql = "select a.sn, a.game_sn, a.home_rate, a.draw_rate, a.away_rate, a.state as detail_state, a.paused
						from tb_pinnacle_game_detail a, tb_pinnacle_game b
						where a.game_sn=b.sn and a.sn=".$detail_sn." and a.state='PLAY'";
		$rows = $this->db->exeSql($sql);
		
		if(count((array)$rows)<=0)
			return -1;
			
		if($rows[0]['paused']=='Y')
			return -2;
			
		$game_sn = $rows[0]['game_sn'];
		
		if($game_sn<=0 || $detail_sn<=0 || $betting_position==-1 || $betting_money<=0)
			return -3;
		
		$data['member_sn'] = $member_sn;
		$data['game_sn'] = $game_sn;
		$data['game_detail_sn'] = $detail_sn;
		$data['betting_no'] = $betting_no;
		$data['betting_money'] = $betting_money;
		$data['betting_position'] = $betting_position;
		$data['odd'] = $odd;
		$data['home_rate'] = $rows[0]['home_rate'];
		$data['draw_rate'] = $rows[0]['draw_rate'];
		$data['away_rate'] = $rows[0]['away_rate'];
		$data['ip'] = $common_model->getIp();
		$data['reg_time'] = 'SYSDATE()';
		$data['logo'] = $this->logo;
		
		$this->db->setInsert("tb_pinnacle_betting", $data);
		return $this->db->exeSql();
	}
	
	function admin_betting_list_total($where='')
	{
		$sql = "select count(*) as cnt from tb_pinnacle_betting a, tb_pinnacle_game b, tb_pinnacle_game_detail c, tb_league d, tb_member e
						where a.game_sn=b.sn and a.game_detail_sn=c.sn and b.league_sn=d.sn and a.member_sn=e.sn".$where;
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	function admin_betting_list($page, $page_size, $where='')
	{
		$sql = "select a.*,
						b.start_time, b.home_score, b.away_score, b.home_team, b.away_team,
						c.sn as detail_sn,
						e.sn as member_sn, e.nick, e.uid, e.logo as logo,
						f.alias as template_alias, f.period,
						d.name as league_name from tb_pinnacle_betting a, tb_pinnacle_game b, tb_pinnacle_game_detail c, tb_league d, tb_member e, tb_pinnacle_template f
						where a.game_sn=b.sn and a.game_detail_sn=c.sn and b.league_sn=d.sn and c.template=f.template
									and a.member_sn=e.sn and e.mem_status='N' ".$where." order by reg_time desc limit ".$page.",".$page_size;
		$rows = $this->db->exeSql($sql);
		
		return $rows;
	}
	
	function pinnacle_game_static()
	{
		$sql = "select sum(betting_money) as betting_money, sum(prize) as prize, count(*) as count from tb_pinnacle_betting";
		$rows = $this->db->exeSql($sql);
		
		return $rows[0];
	}
	
	function admin_pinnacle_game_list($page, $page_size, $where='')
	{
		$sql = "select a.sn as live_sn, a.event_id, a.league_sn, a.home_team, a.away_team, a.start_time, a.reg_time, a.state as game_state,
							a.home_score, a.away_score, a.sport,
							d.name as league_name
						from tb_pinnacle_game a, tb_league d
						where a.league_sn=d.sn".$where." order by start_time desc limit ".$page.",".$page_size;
		$rows = $this->db->exeSql($sql);
		
		for($row=0; $row<count((array)$rows); ++$row)
		{
			$rows[$row]['account_count']=0;
			
			$sql = "select b.sn as live_detail_sn, b.home_rate, b.draw_rate, b.away_rate, b.template, b.win_position, b.state as detail_state, b.paused,
							c.alias, c.period from tb_pinnacle_game_detail b, tb_pinnacle_template c 
						where b.template=c.template and b.game_sn=".$rows[$row]['live_sn'];
			$detail_rows = $this->db->exeSql($sql);
			
			for($i=0; $i<count((array)$detail_rows); ++$i)
			{
				$detail_sn = $detail_rows[$i]['live_detail_sn'];
				$detail_rows[$i]['total'] = $this->admin_position_betting_money($detail_sn);
				$totals = $detail_rows[$i]['total'];
				if(count((array)$totals)>0)
				{
					foreach($totals as $betting) {
						$rows[$row]['total_betting_money']+=$betting;
					}
				}

				switch($detail_rows[$i]['period'])
				{
					case 1: $detail_rows[$i]['score'] = $rows[$row]['first_score']; break;
					case 3: $detail_rows[$i]['score'] = $rows[$row]['second_score']; break;
					case 4: $detail_rows[$i]['score'] = $rows[$row]['score']; break;
				}
				
				//미정산 게임수
				if($rows[$row]['game_state']=='FIN' && $detail_rows[$i]['detail_state']=='FIN')
				{
					$rows[$row]['account_count']+=1;
				}
			}
			$rows[$row]['detail'] = $detail_rows;
			
			//수익
			$sql = "select ifnull(sum(prize),0) as prize from tb_live_betting
							where live_sn=".$rows[$row]['live_sn'];
			$prize_rows = $this->db->exeSql($sql);
			$rows[$row]['prize'] = $prize_rows[0]['prize'];
		}
		
		return $rows;
	}
	
	function admin_pinnacle_game_total($where='')
	{
		$sql = "select count(*) as cnt
						from tb_live_game a, tb_league d
						where a.league_sn=d.sn".$where;
		$rows = $this->db->exeSql($sql);
										
		return $rows[0]['cnt'];
	}
	
	function admin_position_betting_money($game_detail_sn)
	{
		$item = array();
		$sql = "select * from tb_pinnacle_game_detail where sn=".$game_detail_sn;
		$rows = $this->db->exeSql($sql);
		
		if(count((array)$rows)<=0)
			return;
			
		$item['1'] = $this->position_betting_money('1', $game_detail_sn);
		$item['X'] = $this->position_betting_money('X', $game_detail_sn);
		$item['2'] = $this->position_betting_money('2', $game_detail_sn);
			
		return $item;
	}
	
	function position_betting_money($position, $detail_sn)
	{
		$sql = "select ifnull(sum(a.betting_money),0) as total
						from tb_pinnacle_betting a, tb_member b
						where a.member_sn=b.sn 
									and b.mem_status='N'
									and a.game_detail_sn=".$detail_sn." and a.betting_position='".$position."'";
		$rs = $this->db->exeSql($sql);
		
		return $rs[0]['total'];
	}
	
	function admin_pinnacle_result_list_total($where="")
	{
		$sql = "select count(*) as cnt from
						tb_pinnacle_game a, tb_league c
							where a.league_sn=c.sn  and a.state='FIN' and a.state<>'ACC'".$where;
							
		$rows = $this->db->exeSql($sql);
							
		return $rows[0]['cnt'];
	}
	
	function admin_pinnacle_result_list($page, $page_size, $where="")
	{
		$sql = "select a.*, c.name from
						tb_pinnacle_game a, tb_league c
							where a.league_sn=c.sn  and a.state='FIN' and a.state<>'ACC'".$where."
							order by start_time limit ".$page.",".$page_size;
							
		$rows = $this->db->exeSql($sql);
							
		return $rows;
	}
	
	function getGame($game_sn)
	{
		$sql = "select * from tb_pinnacle_game where sn=".$game_sn;
		$rows = $this->db->exeSql($sql);
		return $rows[0];
	}
	
	function fin_game($game_sn, $home_score, $away_score, $is_cancel)
	{
		$data['home_score'] = $home_score;
		$data['away_score'] = $away_score;
		
		if($is_cancel==1)
		{
			$data['win']='CANCEL';
		}
		else
		{
			if( $home_score > $away_score)
				$data['win']='1';
			else if( $home_score < $away_score)
				$data['win']='2';
			else if( $home_score == $away_score)
				$data['win']='X';
		}
		$data['state']='ACC';
		
		$this->db->setUpdate("tb_pinnacle_game", $data, "sn=".$game_sn);
		$result = $this->db->exeSql();
		if($result <=0)
			return -1;
			
		// 서브 게임을 불러온다.
		$sql = "select * from tb_pinnacle_game_detail where game_sn=".$game_sn;
		$rows = $this->db->exeSql($sql);
		
		for($i=0; $i < count((array)$rows); ++$i)
		{
			unset($data);
			
			$detail_sn = $rows[$i]['sn'];
			$template = $rows[$i]['template'];
			$draw_rate = $rows[$i]['draw_rate'];
			
			if($is_cancel==1)
			{
				$data['win_position']='CANCEL';
			}
			else
			{
				if($template==1)
				{
					if( $home_score > $away_score)
						$data['win_position']='1';
					else if( $home_score < $away_score)
						$data['win_position']='2';
					else if( $home_score == $away_score)
						$data['win_position']='X';
				}
				else if($template==2)
				{					
					if( $home_score+$draw_rate > $away_score)
						$data['win_position']='1';
					else if( $home_score+$draw_rate < $away_score)
						$data['win_position']='2';
					else if( $home_score+$draw_rate == $away_score)
						$data['win_position']='X';
				}
				else if($template==4)
				{
					$sum = $home_score + $away_score;
					if($sum < $draw_rate)
						$data['win_position']='1';
					else if($sum > $draw_rate)
						$data['win_position']='2';
					else if($sum == $draw_rate)
						$data['win_position']='X';
				}
			}
			$data['state'] = 'ACC';
			
			$win_position = $data['win_position'];
			
			$this->db->setUpdate("tb_pinnacle_game_detail", $data, "sn=".$detail_sn);
			$result = $this->db->exeSql();
			unset($data);
			
			//베팅확인
			if($is_cancel==1)
			{
				$data['betting_result'] = 'CANCEL';
				$this->db->setUpdate("tb_pinnacle_betting", $data, "game_detail_sn=".$detail_sn);
				$result = $this->db->exeSql();
				$this->on_betting_cancel($detail_sn);
			}
			else
			{
				$this->on_account($detail_sn, $home_score, $away_score, $draw_rate);
			}
			unset($data);
		}
	}
	
	function on_account($detail_sn, $home_score, $away_score, $draw_rate)
	{
		$sql = "select * from tb_pinnacle_game_detail a, tb_pinnacle_betting b where a.sn=b.game_detail_sn and game_detail_sn=".$detail_sn;
		$rows = $this->db->exeSql($sql);
		
		
		for($i=0; $i < count((array)$rows); ++$i)
		{
			$win_rate=1;
			$rate_case = 0;
			
			$betting_sn = $rows[$i]['sn'];
			$template = $rows[$i]['template'];
			$betting_money = $rows[$i]['betting_money'];
			$betting_position = $rows[$i]['betting_position'];
			//승무패
			if($template==1)
			{
				if($rows[$i]['betting_position']=="1")
				{
					if($home_score > $away_score)
						$win_rate = $rows[$i]['odd'];
				}
				else if($rows[$i]['betting_position']=="X")
				{
					if($home_score == $away_score)
						$win_rate = $rows[$i]['odd'];
				}
				else if($rows[$i]['betting_position']=="2")
				{
					if($home_score < $away_score)
						$win_rate = $rows[$i]['odd'];
				}
			}
			//핸디캡
			else if($template==2)
			{
				if($rows[$i]['betting_position']=="1")
				{
					$rate_case = $home_score-$away_score+$draw_rate;
				}
				else if($rows[$i]['betting_position']=="2")
				{
					$rate_case = $away_score-$home_score-$draw_rate;
				}
				
				if($rate_case >= 0.5)
				{
					$win_rate *= $rows[$i]['odd'];
				}
				else if($rate_case==0.25)
				{
					$win_rate *= $win_rate*($rows[$i]['odd']+1)/2;
				}
				else if($rate_case==-0.25)
				{
					$win_rate *= $win_rate*1/2;
				}
			}
			//언오버
			else if($template==4)
			{
				if($rows[$i]['betting_position']=="1")
				{
					$rate_case = ($home_score+$away_score)-$draw_rate;
				}
				else if($rows[$i]['betting_position']=="2")
				{
					$rate_case = $draw_rate-($home_score+$away_score);
				}
				
				if($rate_case >= 0.5)
				{
					$win_rate *= $rows[$i]['odd'];
				}
				else if($rate_case==0.25)
				{
					$win_rate *= $win_rate*($rows[$i]['odd']+1)/2;
				}
				else if($rate_case==-0.25)
				{
					$win_rate *= $win_rate*1/2;
				}
			}
	
			if( $win_rate != 1)
			{
				$prize = bcmul($betting_money,$win_rate,0);
				$data['betting_result'] = 'WIN';
				$data['prize'] = $prize;
				$this->db->setUpdate("tb_pinnacle_betting", $data, "sn=".$betting_sn);
				$result = $this->db->exeSql();
				
				$this->on_betting_success($detail_sn);
			}
			else
			{
				unset($data);
				$data['betting_result'] = 'LOS';
				$this->db->setUpdate("tb_pinnacle_betting", $data, "sn=".$betting_sn);
				$result = $this->db->exeSql();
			}
		}
	}
	
	function on_betting_success($detail_sn)
	{
		$sql = "select * from tb_pinnacle_betting where game_detail_sn=".$detail_sn." and betting_result='WIN'";
		$rows = $this->db->exeSql($sql);
				
		for($i=0; $i<count((array)$rows); ++$i)
		{
			$prize = $rows[$i]['prize'];
			$process_model = Lemon_Instance::getObject("ProcessModel",true);
			$process_model->modifyMoneyProcess($rows[$i]['member_sn'], $prize, 4, $rows[$i]['betting_no']);
		}
	}
	
	function on_betting_cancel($detail_sn)
	{
		$sql = "select * from tb_pinnacle_betting where game_detail_sn=".$detail_sn." and betting_result='CANCEL'";
		$rows = $this->db->exeSql($sql);
				
		for($i=0; $i<count((array)$rows); ++$i)
		{
			$betting_sn = $rows[$i]['sn'];
			$odd = 1;
			$betting_money = $rows[$i]['betting_money'];
			$prize = bcmul($betting_money,$odd,0);
			
			$data['prize'] = $prize;
			$this->db->setUpdate("tb_pinnacle_betting", $data, "sn=".$betting_sn);
			
			$process_model = Lemon_Instance::getObject("ProcessModel",true);
			$process_model->modifyMoneyProcess($rows[$i]['member_sn'], $prize, 5, $rows[$i]['betting_no']);
		}
	}
	
	function on_betting_failed()
	{
	}
	
	function game_result_list($page, $page_size, $where='')
	{
		$sql = "select *
						from	 tb_pinnacle_game a, tb_pinnacle_game_detail b, tb_league c
						where a.sn=b.game_sn and a.league_sn=c.sn and a.state='ACC' ".$where." order by a.start_time desc limit ".$page.",".$page_size;
		$rows = $this->db->exeSql($sql);
		
		for($i=0; $i < count((array)$rows); ++$i)
		{
			$key = $rows[$i]['league_sn'];
			$key .= $rows[$i]['start_time'];
			
			$list[$key]['name'] = $rows[$i]['name'];
			$list[$key]['item'][]=$rows[$i];
		}
		
		return $list;
	}
	
	function game_result_list_total($where='')
	{
		$sql = "select count(*) as cnt
						from	 tb_pinnacle_game a, tb_pinnacle_game_detail b, tb_league c
						where a.sn=b.game_sn and a.league_sn=c.sn and a.state='ACC' ".$where;
		$rows = $this->db->exeSql($sql);
		
		return $rows[0]['cnt'];
	}
	
	function betting_list($member_sn, $page, $page_size, $where='')
	{
		$sql = "select a.*,
						b.sn as live_sn, b.start_time, b.home_score, b.away_score, b.home_team, b.away_team,
						c.sn as detail_sn, c.win_position, c.template,
						e.sn as member_sn, e.nick, e.uid, e.logo as logo,
						c.template as template, 
						d.lg_img as league_image, d.name as league_name from 
						tb_pinnacle_betting a, tb_pinnacle_game b, tb_pinnacle_game_detail c, tb_league d, tb_member e
						where a.game_sn=b.sn and a.game_detail_sn=c.sn and b.league_sn=d.sn
									and a.member_sn=e.sn and a.visible='Y' and
									e.sn=".$member_sn.$where." limit ".$page.",".$page_size;
									
		$rows = $this->db->exeSql($sql);	
		
		return $rows;
	}
	
	function betting_list_total($member_sn, $where='')
	{
		$sql = "select count(*) as cnt from 
						tb_pinnacle_betting a, tb_pinnacle_game b, tb_pinnacle_game_detail c, tb_league d, tb_member e
						where a.game_sn=b.sn and a.game_detail_sn=c.sn and b.league_sn=d.sn
									and a.member_sn=e.sn and a.visible='Y' and
									e.sn=".$member_sn.$where;
		$rs = $this->db->exeSql($sql);
		
		return $rs[0]['cnt'];	
	}
}
?>