<?php
class LiveGameModel extends Lemon_Model 
{
	function getLiveGameList()
	{
		$sql = "select a.*, b.name as league_name, b.lg_img as league_image 
						from "
						.$this->db_qz."live_game a, "
						.$this->db_qz."league b
						where a.league_sn=b.sn and state!='FIN' order by a.start_time asc ";
		$rs = $this->db->exeSql($sql);
		
		$leagueGameList = array();
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$league_sn = $rs[$i]['league_sn'];
			$key = $league_sn;
			$leagueGameList[$key]['league_image'] = $rs[$i]['league_image'];
			$leagueGameList[$key]['league_name'] = $rs[$i]['league_name'];
			$leagueGameList[$key]['item'][] = $rs[$i];
		}
		
		return $leagueGameList;
	}
	
	function getLiveGameCount()
	{
		$sql = "select count(*) as cnt from ".$this->db_qz."live_game a, ".$this->db_qz."league b
						where a.league_sn=b.sn and state!='FIN'";
		$rows = $this->db->exeSql($sql);
		return $rows[0]['cnt'];
	}
	
	function getLiveGameDetail($event_id)
	{
		if( $event_id=="")
			return;
			
		$sql = "select a.sn as live_sn, a.home_team, a.away_team,
							b.name as league_name, b.lg_img as league_image 
						from tb_live_game a, tb_league b
						where a.league_sn=b.sn and a.event_id=".$event_id." and a.state<>'FIN' ";
		$rs = $this->db->exeSql($sql);
		
		$games = array();
		
		if(count((array)$rs)>0)
		{
			$live_sn = $rs[0]['live_sn'];
			$home_team = $rs[0]['home_team'];
			$away_team = $rs[0]['away_team'];
			
			$games['live_sn'] = $live_sn;
			$games['home_team'] = $home_team;
			$games['away_team'] = $away_team;
			$games['league_name'] = $rs[0]['league_name'];
			$games['league_image'] = $rs[0]['league_image'];
	
			$sql = "select a.*, b.alias as alias from tb_live_game_detail a, tb_live_game_template b
							where a.template=b.template and a.live_sn=".$live_sn."
								and a.state='PLAY' and b.is_enable=1";
			$rs = $this->db->exeSql($sql);
			
			for($i=0; $i<count((array)$rs); ++$i)
			{
				$odds = $rs[$i]['odds'];
				$last_odds = $rs[$i]['last_odds'];
				
				$split_odds = $this->split_odds($odds);
				$this->diff_odds($split_odds, $last_odds);
				
				$rs[$i]['token_odds'] = $split_odds;
			}
			$games['item'] = $rs;
			
			$sql = "select * from tb_live_game_broadcast
							where live_sn=".$live_sn." order by sn desc";
			$rs = $this->db->exeSql($sql);
			$games['broadcast'] = $rs;
		}
	
		return $games;
	}
	
	function split_odds($odds)
	{
		$rs = array();
		$tokens = explode(";", $odds);
		$index = 0;
		
		foreach($tokens as $item) {
			$token = explode(":", $item);
			$rs[$index][0] = $token[0];
			$rs[$index][1] = $token[1];
			++$index;
		}
		return $rs;
	}
	
	function diff_odds(&$odds, $last)
	{
		$last_odds = $this->split_odds($last);
		
		for($i=0; $i<count((array)$odds); ++$i)
		{
			if($odds[$i]==$last_odds[$i]) {
				$odds[$i][2]=0;
			}
			else if($odds[$i]>$last_odds[$i]) {
				$odds[$i][2]=-1;
			}
			else if($odds[$i]<$last_odds[$i]) {
				$odds[$i][2]=1;
			}
		}
	}
	
	function insert_live_game($event_id, $league_sn, $home_team, $away_team, $start_time)
	{
		$data['event_id'] = $event_id;
		$data['league_sn'] = $league_sn;
		$data['home_team'] = $home_team;
		$data['away_team'] = $away_team;
		$data['start_time'] = $start_time;
		$data['reg_time'] = 'SYSDATE()';
		
		$this->db->setInsert($this->db_qz.'live_game', $data);
		$live_sn = $this->db->exeSql();
		
		return $live_sn;
	}
	
	function insert_live_detail($live_sn, $template, $template_name, $odds)
	{
		$data['live_sn'] = $live_sn;
		$data['template'] = $template;
		$data['template_name'] = $template_name;
		$data['odds'] = $odds;
		$data['last_odds'] = $odds;
		
		$this->db->setInsert($this->db_qz.'live_game_detail', $data);
		$rs = $this->db->exeSql();
		
		return $rs;
	}
	
	function update_live_detail($live_sn, $template, $odds, $is_visible)
	{
		$sql = "select odds from tb_live_game_detail
						where live_sn=".$live_sn." and template=".$template;
		$rs = $this->db->exeSql($sql);
		$last_odds = $rs[0]['odds'];
						
		$data['odds'] = $odds;
		$data['last_odds'] = $last_odds;
		$data['is_visible'] = $is_visible;
		$this->db->setUpdate($this->db_qz.'live_game_detail', $data, 'live_sn='.$live_sn.' and template='.$template);
		$rs = $this->db->exeSql();

		return $rs;
	}
	
	function insert_today_live_games($day, $event_id, $event_date, $league_name, $home_team, $away_team, $league_id)
	{
		$data['day'] = $day;
		$data['event_id'] = $event_id;
		$data['event_date'] = $event_date;
		$data['league_name'] = mysql_real_escape_string($league_name);
		$data['home_team'] = mysql_real_escape_string($home_team);
		$data['away_team'] = mysql_real_escape_string($away_team);
		$data['league_id'] = $league_id;
		
		$this->db->setInsert($this->db_qz.'today_live_games', $data);
		$rs = $this->db->exeSql();
		
		return $rs;
	}
	
	function reload_today_live_games()
	{
		$sql = "delete from tb_today_live_games";
		return $this->db->exeSql($sql);
	}
	
	function live_event_listener_for_client($event_id)
	{
		if($event_id=='')
		{
			echo '';
			return;
		}
		
		if( !$this->req->isNumberParameter($event_id))
		{
			echo "";
			return;
		}
			
		$games = $this->getLiveGameDetail($event_id);
		
		echo(json_encode($games));
	}
	
	function live_event_listener()
	{
		$this->update_access_time('event_data_access_timer');
		
		$sql = "select a.*, b.name, b.lg_img from tb_live_game a, tb_league b
						where a.league_sn=b.sn and a.state<>'FIN' and now() >= a.start_time";
						
		$rs = $this->db->exeSql($sql);
		
		if(count((array)$rs)>0)
		{
			foreach($rs as $item)
			{
				$live_sn = $item['sn'];
				$event_id = $item['event_id'];
				
				$liveBwin = new LiveBwin();
				$games = $liveBwin->parseV2GetEventData($live_sn, $event_id);
				
				if(count((array)$games['message'])>0)
				{
					$sql = "select timer from tb_live_game_broadcast
									where live_sn=".$live_sn;
					$rsi = $this->db->exeSql($sql);
					
					$timers = array();
					for($i=0; $i<count((array)$rsi); ++$i) {
						$timers[] = $rsi[$i]['timer'];	
					}
					
					if(count((array)$games['message'])!=count((array)$timers))
					{
						foreach($games['message'] as $message)
						{
							$data['live_sn'] = $live_sn;
							$data['type'] = $message[0];
							$data['timer'] = $message[1];
							$data['content'] = $message[2];
							$data['reg_time'] = 'SYSDATE()';
							
							if( !in_array($message[1], $timers))
							{
								$this->db->setInsert($this->db_qz."live_game_broadcast", $data);
								$this->db->exeSql();
								
								if($message[2]=="Finished" && $message[0]==1)
								{
									$period=4;
									$this->on_state($games['event_id'], $period, $games['score']);
								}
								else if($message[0]=='255')
								{
									$data2['is_visible'] = 0;
									$this->db->setUpdate($this->db_qz.'live_game_detail', $data2, 'live_sn='.$live_sn);
									$this->db->exeSql();
								}
							}
						}
					}
				}
				
				if(count((array)$games['item'])>0)
				{
					foreach($games['item'] as $game)
					{
						if($this->is_game_template_exist($live_sn, $game['template'])) 
						{
							$this->update_live_detail($live_sn, $game['template'], $game['odds'], $game['is_visible']);
						}
						else 
						{
							$this->insert_live_detail($live_sn, $game['template'], $game['template_name'], $game['odds']);
						}
					}
				}
				
				$this->live_event_template_off($event_id, $games['item']);
			} // end of for
		}
	}
	
	//핸디일 경우 특정 득점차가 나면, template 가 자동으로 사라진다.
	//이걸 구분할수 있는 방법은, 게임리스트와 데이터베이스와 게임을 비교하여 없을 경우, 자동으로 
	//is_visible을 0으로 셋팅한다.
	function live_event_template_off($event_id, $games)
	{
		$sql = "select a.template as template from "
						.$this->db_qz."live_game_detail a, "
						.$this->db_qz."live_game b
						where a.live_sn=b.sn and 
									a.is_visible=1 and
									b.event_id=".$event_id;
		$rows = $this->db->exeSql($sql);
		
		$templates = array();
		$xml_templates = array();
		if(count((array)$rows)>0 && count((array)$games)>0) {
			foreach($rows as $row) {
				$templates[] = $row['template'];
			}
			foreach($games as $game) {
				$xml_templates[] = $game['template'];		
			}
			$diff_templates = array_diff($templates, $xml_templates);
			
			if(count((array)$diff_templates)>0) {
				foreach($diff_templates as $template) {
					$data['is_visible'] = 0;
					$this->db->setUpdate($this->db_qz.'live_game_detail', $data, 'template='.$template);
					$this->db->exeSql();
					
					unset($data);
					
					//log
					$data['event_id'] = $event_id;
					$data['template'] = $template;
					$data['reg_time'] = 'SYSDATE()';
					
					$this->db->setInsert($this->db_qz."live_log_off", $data);
					$this->db->exeSql();
					
					unset($data);
				}
			}
		}
	}
	
	function live_event_main_bets_listener_for_client($event_id)
	{
		$liveBwin = new LiveBwin();
		$event = $liveBwin->parseV2GetLiveEventsWithMainbets($event_id);

		echo(json_encode($event));
	}
	
	function live_event_main_bets_listener()
	{
		$this->update_access_time('main_bets_access_timer');
		
		$sql = "select event_id from tb_live_game where state<>'FIN'";
		$rows = $this->db->exeSql($sql);
						
		$liveBwin = new LiveBwin();
		
		if(count((array)$rows)>0)
		{
			foreach($rows as $row)
			{
				$event_id = $row['event_id'];
				$event = $liveBwin->parseV2GetLiveEventsWithMainbets($event_id);
				
				$data['current_score'] = $event['score'][0].":".$event['score'][1];
				$this->db->setUpdate($this->db_qz.'live_game', $data, 'event_id='.$event_id);
				$this->db->exeSql();
				
				$this->on_state($event_id, $event['period'], $event['score'][0].":".$event['score'][1]);
			}
		}
	}
	
	function live_event_main_bets_listener2()
	{
		$this->update_access_time('main_bets_access_timer');
		
		$sql = "select event_id, state from tb_live_game where state<>'FIN'";
		$rows = $this->db->exeSql($sql);
		
		$event_ids = array();
		$playing_event_ids = array();
		
		if(count((array)$rows)>0) {
			foreach($rows as $row) {
				$event_ids[] = $row['event_id'];
				if($row['state']!='READY') {
					$playing_event_ids[] = $row['event_id'];
				}
			}
			
			$liveBwin = new LiveBwin();
			$events = $liveBwin->parseV2GetLiveEventsWithMainbets2();
			
			$main_bets_event_ids = array();
			
			if(count((array)$events)>0) {
				foreach($events as $event) {
					$main_bets_event_ids[] = $event['event_id'];
				}
			}
			
			if(count((array)$events)>0) {
				//현재는 Finished 패킷을 받으면, 종료를 처리한다.
				//하지만 가끔 이 패킷이 날라오지 않는 경우가 발생하여, 방식을 변경
				//main-bets-list에서 게임이 사라지면 종료된걸로 판단할수 있다.
				$diff_events = array_diff($playing_event_ids, $main_bets_event_ids);
				if(count((array)$diff_events)>0) {
					foreach($diff_events as $diff_event) {
						$sql = "select current_score from tb_live_game where event_id=".$diff_event;
						$score_rows = $this->db->exeSql($sql);
						if(count((array)$score_rows)>0) {
							$period=4;
							$this->on_state($diff_event, $period, $score_rows[0]['current_score']);
						}
						
						//$sql = "insert into tb_live_log(event_id, reg_time) values(".$diff_event.", SYSDATE())";
						//$this->db->exeSql($sql);
					}
				}
				
				foreach($events as $event) {
					$event_id = $event['event_id'];
					if( in_array($event_id, $event_ids)) {
						$data['current_score'] = $event['score'][0].":".$event['score'][1];
						$this->db->setUpdate($this->db_qz.'live_game', $data, 'event_id='.$event_id);
						$this->db->exeSql();
						
						$this->on_state($event_id, $event['period'], $event['score'][0].":".$event['score'][1]);
					}
				}
			}
		}
	}
	
	function live_list_event_main_bets_listener()
	{
		$list = array();
		$sql = "select sn, state, event_id, current_score from tb_live_game
						where state<>'FIN' and now()>=start_time";
		$rows = $this->db->exeSql($sql);
		
		$liveBwin = new LiveBwin();
		
		if(count((array)$rows)>0)
		{
			foreach($rows as $row)
			{
				$event_id = $row['event_id'];
				$live_sn = $row['sn'];
				
				$score = $row['current_score'];
				$scores = explode(":", $score);
				
				$event['event_id'] = $event_id;
				$event['state'] = $row['state'];
				$event['score'] = $scores[0].' : '.$scores[1];
				
				$sql = "select count(*) as cnt from tb_live_game_detail a, tb_live_game_template b
								where a.template=b.template and a.live_sn=".$live_sn." and b.is_enable=1";
				$rs = $this->db->exeSql($sql);
				$event['template_cnt'] = $rs[0]['cnt'];
				
				$list[] = $event;
			}
		}

		echo(json_encode($list));
	}
	
	function is_game_template_exist($live_sn, $template)
	{
		$sql = "select count(*) as cnt from tb_live_game_detail
						where  live_sn=".$live_sn." and template=".$template;
						
		$rs = $this->db->exeSql($sql);
		
		return ($rs[0]['cnt']>0);
	}
	
	function total_today_live_games()
	{
		$sql = "select count(*) as cnt from ".$this->db_qz."today_live_games
						where day=date_format(curdate( ), '%Y-%m-%d')";
						
		$rs = $this->db->exeSql($sql);
		
		//데이터가 없다면 기록
		if($rs[0]['cnt']<=0)
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // https 접속시
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_URL, "https://betting.api.bwin.com/V2/CalendarFeed.svc/?x-bwin-accessId=NDU2ZWU0MzYtNmZlMS00ZWM0LTgwYTUtNDRlMjJkOTk4OTkw&ipCountryId=410&lang=en&userCountryId=410&dayCount=1");
			
			$url_source = curl_exec($ch);
			curl_close($ch);
	
			$xml = simplexml_load_string($url_source);
			
			foreach($xml->Sport as $xml_sport)
			{
				if($xml_sport->attributes()->id!=4)
					continue;
				
				foreach($xml_sport as $xml_league)
				{
					$league_name = $xml_league->attributes()->regionName.','.$xml_league->attributes()->name;
					$league_id = $xml_league->attributes()->id;
					
					foreach($xml_league as $xml_event)
					{
						$event_id = $xml_event->attributes()->id;
						
						//2014-01-26T11:30:00Z
						$date = $xml_event->attributes()->date;
						$n = sscanf($date, "%d-%d-%dT%d:%d:%dZ", $year, $month, $day, $hour, $min, $sec);
						$time = mktime($hour, $min, $sec, $month, $day, $year)+60*60*9; //9시간을 더해준다.
						$event_date = date('Y-m-d H:i',$time);
						
						$team = $xml_event->attributes()->name;
						$teams = explode("-", $team);
						$home_team = trim($teams[0]);
						$away_team = trim($teams[1]);
						
						$this->insert_today_live_games(date('Y-m-d'), $event_id, $event_date, $league_name, $home_team, $away_team, $league_id);
					}
				}
			}
		}
		
		$sql = "select count(*) as cnt from ".$this->db_qz."today_live_games
						where day=date_format(curdate( ), '%Y-%m-%d') order by event_date asc";
						
		$rs = $this->db->exeSql($sql);

		return $rs[0]['cnt'];
	}
	
	function today_live_games($page, $page_size)
	{
		$sql = "select count(*) as cnt from tb_today_live_games
						where day=date_format(curdate( ), '%Y-%m-%d')";
						
		$rs = $this->db->exeSql($sql);
		
		//데이터가 없다면 기록
		if($rs[0]['cnt']<=0)
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // https 접속시
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_URL, "https://betting.api.bwin.com/V2/CalendarFeed.svc/?x-bwin-accessId=NDU2ZWU0MzYtNmZlMS00ZWM0LTgwYTUtNDRlMjJkOTk4OTkw&ipCountryId=410&lang=en&userCountryId=410&dayCount=1");
			
			$url_source = curl_exec($ch);
			curl_close($ch);
	
			$xml = simplexml_load_string($url_source);
			
			foreach($xml->Sport as $xml_sport)
			{
				if($xml_sport->attributes()->id!=4)
					continue;
				
				foreach($xml_sport as $xml_league)
				{
					$league_name = $xml_league->attributes()->regionName.','.$xml_league->attributes()->name;
					$league_id = $xml_league->attributes()->id;
					
					foreach($xml_league as $xml_event)
					{
						$event_id = $xml_event->attributes()->id;
						
						//2014-01-26T11:30:00Z
						$date = $xml_event->attributes()->date;
						$n = sscanf($date, "%d-%d-%dT%d:%d:%dZ", $year, $month, $day, $hour, $min, $sec);
						$time = mktime($hour, $min, $sec, $month, $day, $year)+60*60*9; //9시간을 더해준다.
						$event_date = date('Y-m-d H:i',$time);
						
						$team = $xml_event->attributes()->name;
						$teams = explode("-", $team);
						$home_team = trim($teams[0]);
						$away_team = trim($teams[1]);
						
						$this->insert_today_live_games(date('Y-m-d'), $event_id, $event_date, $league_name, $home_team, $away_team, $league_id);
					}
				}
			}
		}
		
		$sql = "select * from tb_today_live_games
						where day=date_format(curdate( ), '%Y-%m-%d') order by event_date asc limit ".$page.", ".$page_size;
						
		$rs = $this->db->exeSql($sql);

		return $rs;
	}
	
	//▶ 게임 목록
	function admin_live_game_list($page, $page_size, $where='')
	{
		$sql = "select a.sn as live_sn, a.event_id, a.league_sn, a.home_team, a.away_team, a.start_time, a.reg_time, a.state as game_state,
							a.first_score, a.second_score, a.score, a.sport_name,
							d.name as league_name
						from "
						.$this->db_qz."live_game a, "
						.$this->db_qz."league d
						where a.league_sn=d.sn".$where." order by start_time desc limit ".$page.",".$page_size;
		$rows = $this->db->exeSql($sql);
		
		for($row=0; $row<count((array)$rows); ++$row)
		{
			$rows[$row]['account_count']=0;
			
			$sql = "select b.sn as live_detail_sn, b.odds, b.template, b.is_visible, b.win_position, b.state as detail_state, b.paused,
							c.alias, c.period from "
						.$this->db_qz."live_game_detail b, "
						.$this->db_qz."live_game_template c 
						where b.template=c.template and c.is_enable=1 and b.live_sn=".$rows[$row]['live_sn'];
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
	
	function admin_live_game_total($where='')
	{
		$sql = "select count(*) as cnt
						from "
						.$this->db_qz."live_game a, "
						.$this->db_qz."league d
						where a.league_sn=d.sn".$where;
		$rows = $this->db->exeSql($sql);
										
		return $rows[0]['cnt'];
	}
	
	function admin_live_game_detail($detail_sn)
	{
		$sql = "select a.*, b.alias from "
						.$this->db_qz."live_game_detail a, "
						.$this->db_qz."live_game_template b 
						where a.template=b.template and a.sn=".$detail_sn;
		$rows = $this->db->exeSql($sql);
		
		return $rows[0];
	}
	
	function admin_betting_list($page, $page_size, $where='')
	{
		$sql = "select a.*,
						b.start_time, b.score, b.home_team, b.away_team, b.first_score, b.second_score,
						c.sn as detail_sn,
						e.sn as member_sn, e.nick, e.uid, e.logo as logo,
						f.alias as template_alias, f.period,
						d.name as league_name from "
						.$this->db_qz."live_betting a, "
						.$this->db_qz."live_game b, "
						.$this->db_qz."live_game_detail c, "
						.$this->db_qz."league d, "
						.$this->db_qz."member e, "
						.$this->db_qz."live_game_template f
						where a.live_sn=b.sn and a.live_detail_sn=c.sn and b.league_sn=d.sn and c.template=f.template
									and a.member_sn=e.sn and e.mem_status='N' ".$where." order by reg_time desc limit ".$page.",".$page_size;
		$rows = $this->db->exeSql($sql);
		
		for($i=0; $i<count((array)$rows); ++$i)
		{
			$period = $rows[$i]['period'];
			switch($period)
			{
				case 1: $rows[$i]['view_score'] = $rows[$i]['first_score']; break;
				case 3: $rows[$i]['view_score'] = $rows[$i]['second_score']; break;
				case 4: $rows[$i]['view_score'] = $rows[$i]['score']; break;
			}
		}
		return $rows;
	}

	function admin_betting_list_total($where='')
	{
		$sql = "select count(*) as cnt from "
						.$this->db_qz."live_betting a, "
						.$this->db_qz."live_game b, "
						.$this->db_qz."live_game_detail c, "
						.$this->db_qz."league d, "
						.$this->db_qz."member e
						where a.live_sn=b.sn and a.live_detail_sn=c.sn and b.league_sn=d.sn and a.member_sn=e.sn".$where;
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}

	function admin_position_betting_money($live_detail_sn)
	{
		$item = array();
		$sql = "select * from tb_live_game_detail where sn=".$live_detail_sn;
		$rs = $this->db->exeSql($sql);
		
		if(count((array)$rs)<=0)
			return;
		
		$odds = $this->split_odds($rs[0]['odds']);
		
		foreach($odds as $odd) {
			$betting_position = $odd[0];
			if($betting_position=="Any other score")
				$betting_position="Any";
			if($betting_position!='')
			{
				$item[$betting_position] = $this->position_betting_money($betting_position, $live_detail_sn);
			}
		}

		return $item;
	}
	
	function position_betting_money($position, $detail_sn)
	{
		$sql = "select ifnull(sum(a.betting_money),0) as total
						from tb_live_betting a, tb_member b
						where a.member_sn=b.sn 
									and b.mem_status='N'
									and a.live_detail_sn=".$detail_sn." and a.betting_position='".$position."'";
		$rs = $this->db->exeSql($sql);
		
		return $rs[0]['total'];
	}
	
	function template_betting_money($detail_sn)
	{
		$sql = "select ifnull(sum(a.betting_money),0) as total
						from tb_live_betting a, tb_member b
						where a.member_sn=b.sn 
									and b.mem_status='N'
									and a.live_detail_sn=".$detail_sn;
		$rs = $this->db->exeSql($sql);
		
		return $rs[0]['total'];
	}
	
	function on_state($event_id, $period, $score)
	{
		$sql = "select state from tb_live_game where event_id=".$event_id;
		$rs = $this->db->exeSql($sql);
		
		$state = $rs[0]['state'];
		
		if($period==1)
		{
			if($state=='READY')
			{
				$this->update_state($event_id, "FH");
			}
		}
		else if($period==2)
		{
			if($state=='FH')
			{
				$this->update_state($event_id, "HT");
				$this->on_finish_live_game($event_id, $period, $score);
			}
		}
		else if($period==3)
		{
			if($state=='HT')
			{
				$this->update_state($event_id, "SH");
			}
		}
		else if($period==4)
		{
			if($state=='SH')
			{
				$this->update_state($event_id, "FIN");
				$this->on_finish_live_game($event_id, $period, $score);
			}
		}
	}
	
	function update_state($event_id, $state)
	{
		$data['state'] = $state;
		
		$this->db->setUpdate($this->db_qz.'live_game', $data, 'event_id='.$event_id);
		$this->db->exeSql();
	}
	
	function on_finish_live_game($event_id, $period, $score)
	{
		$sql = "select state, first_score from tb_live_game where event_id=".$event_id;
		$rs = $this->db->exeSql($sql);
			
		$liveBwin = new LiveBwin();
		
		//HT
		if($period==4)
		{
			$first_scores = explode(":", $rs[0]['first_score']);
			$fin_scores = explode(":", $score);
			$second_score = sprintf("%d:%d", $fin_scores[0]-$first_scores[0], $fin_scores[1]-$first_scores[1]);
			
			$data['score']=trim($score);
			$data['second_score']=$second_score;
			
			$this->db->setUpdate($this->db_qz.'live_game', $data, 'event_id='.$event_id);
			$this->db->exeSql();
			
			$this->finish_live_game($event_id, 3, $data['second_score']);
			$this->finish_live_game($event_id, 4, $data['score']);
		}
		//2= Half Time ( Ft Fin )
		else if($period==2)
		{
			$data['first_score']=$score;
			$this->db->setUpdate($this->db_qz.'live_game', $data, 'event_id='.$event_id);
			$rs = $this->db->exeSql();
			
			$this->finish_live_game($event_id, 1, $score);
		}
	}
	
	function finish_live_game($event_id, $period, $score)
	{
		$sql = "select a.sn as live_detail_sn, a.template
						from tb_live_game_detail a, tb_live_game b, tb_live_game_template c
						where a.live_sn=b.sn and a.template=c.template
						and b.event_id=".$event_id." and c.period=".$period." and a.state='PLAY' ";
		$rows = $this->db->exeSql($sql);
	
		if(count((array)$rows)>0)
		{
			$liveBwin = new LiveBwin();
			
			foreach($rows as $row)
			{
				$win_position = $liveBwin->calc_win_position($row['template'], $score);
				$data['win_position'] = $win_position;
				$total_betting_money = $this->template_betting_money($row['live_detail_sn']);
				if($total_betting_money<=0) {
					$data['state']='ACC';
				} else {
					$data['state']='FIN';
				}
				$this->db->setUpdate($this->db_qz.'live_game_detail', $data, 'sn='.$row['live_detail_sn']);
				$this->db->exeSql();
			}
		}
	}
	
	//비정상적인 게임 종료일 경우 수동 마감
	function manual_finish_live_game($live_sn, $period/*2=전반전마감, 4=후반,전체마감*/, $score)
	{
		$sql = "select event_id, state, first_score from tb_live_game where sn=".$live_sn;
		$rows = $this->db->exeSql($sql);
		
		if(count((array)$rows)<=0)
			return -1;
			
		$event_id = $rows[0]['event_id'];
		
		$this->on_finish_live_game($event_id, $period, $score);
		
		if($period==4) {
			$this->update_state($event_id, "FIN");
		}
	}

	//-> 같은게임 같은 방향의 총 배팅머니 합계
	function get_sync_betting_money($member_sn, $live_sn, $live_detail_sn, $betting_position) {
		$sql = "select sum(betting_money) as bet_sum_money from tb_live_betting where 
						member_sn = '".$member_sn."' and live_sn = '".$live_sn."' and live_detail_sn = '".$live_detail_sn."' and betting_position = '".$betting_position."'";
		$rs = $this->db->exeSql($sql);
		return $rs[0]["bet_sum_money"]+0;
	}

	//-> 게임정보 추출
	function get_live_game_info($event_id, $template) {
		$sql = "select a.sn, a.live_sn, a.odds, a.state as detail_state, a.paused
						from "
						.$this->db_qz."live_game_detail a, "
						.$this->db_qz."live_game b
						where a.live_sn=b.sn and b.event_id=".$event_id." and a.template=".$template." and a.is_visible=1";
		$rs = $this->db->exeSql($sql);
		return $rs;
	}
	
	function live_betting($member_sn, $event_id, $template, $betting_no, $odd, $betting_money, $betting_position)
	{
		$sql = "select * from tb_live_daemon_state";
		$rs = $this->db->exeSql($sql);
		$last_access_time = $rs[0]['event_data_access_timer'];
		$diff_second = $this->date_diff($last_access_time);
		if($diff_second >= 30) {
			return -3;
		}
		
		$common_model = Lemon_Instance::getObject("CommonModel",true);
		
		$sql = "select a.sn, a.live_sn, a.odds, a.state as detail_state, a.paused
						from "
						.$this->db_qz."live_game_detail a, "
						.$this->db_qz."live_game b
						where a.live_sn=b.sn and b.event_id=".$event_id." and a.template=".$template." and a.is_visible=1";
		$rs = $this->db->exeSql($sql);
		
		if(count((array)$rs)<=0)
			return -1;
			
		if($rs[0]['paused']=='Y')
			return -2;
			
		$live_sn = $rs[0]['live_sn'];
		$live_detail_sn = $rs[0]['sn'];
		
		if($live_sn<=0 || $live_detail_sn<=0 || $betting_position==-1 || $betting_money<=0)
			return -3;
		
		$data['member_sn'] = $member_sn;
		$data['live_sn'] = $live_sn;
		$data['live_detail_sn'] = $live_detail_sn;
		$data['betting_no'] = $betting_no;
		$data['betting_money'] = $betting_money;
		$data['betting_position'] = $betting_position;
		$data['odd'] = $odd;
		$data['odds'] = $rs[0]['odds'];
		$data['ip'] = $common_model->getIp();
		$data['reg_time'] = 'SYSDATE()';
		$data['logo'] = $this->logo;
		
		$this->db->setInsert($this->db_qz."live_betting", $data);
		return $this->db->exeSql();
	}
	
	function is_odds_same($event_id, $template, $position, $odd)
	{
		$sql = "select a.odds 
						from tb_live_game_detail a, tb_live_game b
						where a.live_sn=b.sn and b.event_id=".$event_id." and a.template=".$template;
		$rs = $this->db->exeSql($sql);
		
		if(count((array)$rs)<=0)
			return 0;
		
		$odds = $rs[0]['odds'];
		$splits = explode(";", $odds);
		
		foreach($splits as $item)
		{
			$split_odds = explode(":", $item);
			if($split_odds[0]==$position)
			{
				//-> 배당 체크 수정 (배당이 높아 약간 줄임)
				if(round(($split_odds[1]*0.95),2) > 1 ) {
					$split_odds[1] = round(($split_odds[1]*0.95),2);
				}
				if($split_odds[1]==$odd)
					return 1;
				else
					return 0;
			}
		}
		
		return 0;
	}
	
	//적특처리
	function betting_exception($betting_sn)
	{
		$sql = "select * from tb_live_betting 
						where sn=".$betting_sn;
		$rows = $this->db->exeSql($sql);
		if(count((array)$rows)<=0)
			return -1;
		
		$member_sn = $rows[0]['member_sn'];
		$betting_money = $rows[0]['betting_money'];
		$betting_no = $rows[0]['betting_no'];

		$data['betting_result'] = 'CANCEL';
		$this->db->setUpdate($this->db_qz."live_betting", $data, "sn=".$betting_sn);
		$rows = $this->db->exeSql();
		
		$process_model = Lemon_Instance::getObject("ProcessModel",true);
		$process_model->modifyMoneyProcess($member_sn, $betting_money, 5, $betting_no);
		
		return $rows;
	}
	
	/*
	적특은 바로 처리(돈지급)를 해준다는 가정하에 코딩 state='CANCEL'
	*/
	function account_game($detail_sn)
	{
		$sql = "select * from tb_live_game_detail where sn=".$detail_sn;
		$rows = $this->db->exeSql($sql);	
		
		if($rows[0]['state']!='FIN')	return -1;
		
		$win_position = $rows[0]['win_position'];
		if($win_position=='-1')
			return -2;
		
		$sql = "select * from tb_live_betting
						where live_detail_sn=".$detail_sn." and betting_position='".$win_position."' and betting_result='-1'";
		$rows = $this->db->exeSql($sql);
		
		$data['betting_result'] = 'LOS';
		$this->db->setUpdate($this->db_qz."live_betting", $data, "live_detail_sn=".$detail_sn." and betting_result='-1' and betting_position<>'".$win_position."'");
		$this->db->exeSql();
		
		if(count((array)$rows) >0)
		{
			foreach($rows as $row)
			{
				$betting_money = $row['betting_money'];
				$odd = bcmul($row['odd'],1,2);
				$prize = bcmul($betting_money,$odd,0);
				$data['betting_result'] = 'WIN';
				$data['prize'] = $prize;
				$this->db->setUpdate($this->db_qz."live_betting", $data, "sn=".$row['sn']);
				$this->db->exeSql();
				
				$this->on_betting_success($row['member_sn'], $prize, $row['betting_no']);
			}
		}
		
		unset($data);
		$data['state'] = 'ACC';
		$this->db->setUpdate($this->db_qz."live_game_detail", $data, "sn=".$detail_sn);
		return $this->db->exeSql();
	}
	
	function ajax_account_game($detail_sn)
	{
		$sql = "select * from tb_live_game_detail where sn=".$detail_sn;
		$rows = $this->db->exeSql($sql);	
		
		$json = array();
		if($rows[0]['state']!='FIN') {
			$json['result'] = -1;
			return $json;
		}
		
		$win_position = $rows[0]['win_position'];
		if($win_position=='-1') {
			$json['result'] = -2;
			return $json;
		}
		
		$sql = "select * from tb_live_betting
						where live_detail_sn=".$detail_sn." and betting_position='".$win_position."' and betting_result='-1'";
		$rows = $this->db->exeSql($sql);
		
		$data['betting_result'] = 'LOS';
		$this->db->setUpdate($this->db_qz."live_betting", $data, "live_detail_sn=".$detail_sn." and betting_result='-1' and betting_position<>'".$win_position."'");
		$this->db->exeSql();
		
		if(count((array)$rows) >0)
		{
			foreach($rows as $row)
			{
				$betting_money = $row['betting_money'];
				$odd = bcmul($row['odd'],1,2);
				$prize = bcmul($betting_money,$odd,0);
				$data['betting_result'] = 'WIN';
				$data['prize'] = $prize;
				$this->db->setUpdate($this->db_qz."live_betting", $data, "sn=".$row['sn']);
				$this->db->exeSql();
				
				$this->on_betting_success($row['member_sn'], $prize, $row['betting_no']);
			}
		}
		
		unset($data);
		$data['state'] = 'ACC';
		$this->db->setUpdate($this->db_qz."live_game_detail", $data, "sn=".$detail_sn);
		$this->db->exeSql();
		
		$json = $this->admin_live_game_detail($detail_sn);
		$json['result'] = 1;
		
		return $json;
	}
	
	function on_betting_success($member_sn, $prize, $betting_no)
	{
		$process_model = Lemon_Instance::getObject("ProcessModel",true);
		$process_model->modifyMoneyProcess($member_sn, $prize, 4, $betting_no);
	}
	
	function on_betting_failed($member_sn, $betting_money, $betting_no)
	{
		$process_model = Lemon_Instance::getObject("ProcessModel",true);
		
		//낙첨 마일리지
		$process_model->modifyMileageProcess($member_sn, $betting_money, "4", $betting_no);
				
		//추천인 낙첨 마일리지
		$process_model->recommendFailedGameMileage($member_sn,$betting_money,$betting_no);
	}
	
	function on_betting_cancel_success($member_sn, $prize, $betting_no)
	{
		$process_model = Lemon_Instance::getObject("ProcessModel",true);
		$process_model->modifyMoneyProcess($member_sn, -$prize, 8, $betting_no);
	}
	
	function on_betting_cancel_failed($member_sn, $betting_money, $betting_no)
	{
		$process_model = Lemon_Instance::getObject("ProcessModel",true);
		
		//낙첨 마일리지
		$process_model->modifyMileageProcess($member_sn, $betting_money, "4", $betting_no);
				
		//추천인 낙첨 마일리지
		$process_model->recommendFailedGameMileage($member_sn,$betting_money,$betting_no);
				
		/*
		//잭팟 적립
		$jackpot_rate = $this->configModel->getJackpotRate();
		$jackpot = $betMoney/100*$jackpot_rate;
		if( $jackpot>0)
			$this->configModel->modifygiveJackpot($jackpot);
		*/
	}
	
	function account_cancel_game($detail_sn)
	{
		$sql = "select * from tb_live_game_detail where sn=".$detail_sn;
		$rows = $this->db->exeSql($sql);	
		
		if($rows[0]['state']!='ACC')	return -1;
		
		$sql = "select * from tb_live_betting
						where live_detail_sn=".$detail_sn." and betting_result<>'CANCEL'";
		$rows = $this->db->exeSql($sql);
		
		if(count((array)$rows)>0)
		{
			foreach($rows as $row)
			{
				$betting_result = $row['betting_result'];
	
				if($betting_result=='WIN')
					$this->on_betting_cancel_success($row['member_sn'], $row['prize'], $row['betting_no']);
				
				unset($data);
				$data['prize'] = 0;
				$data['betting_result']='-1';
				$this->db->setUpdate($this->db_qz."live_betting", $data, "sn=".$row['sn']);
				$this->db->exeSql();
			}
		}
	
		unset($data);
		$data['betting_result'] = '-1';
		$this->db->setUpdate($this->db_qz."live_betting", $data, "live_detail_sn=".$detail_sn." and betting_result<>'CANCEL'");
		$this->db->exeSql();
		
		unset($data);
		$data['state'] = 'FIN';
		$this->db->setUpdate($this->db_qz."live_game_detail", $data, "sn=".$detail_sn);
		return $rows = $this->db->exeSql();
	}
	
	function ajax_account_cancel_game($detail_sn)
	{
		$sql = "select * from tb_live_game_detail where sn=".$detail_sn;
		$rows = $this->db->exeSql($sql);	
		
		$json = array();
		
		if($rows[0]['state']!='ACC') {
			$json['result'] = -1;
			return $json;
		}
		
		$sql = "select * from tb_live_betting
						where live_detail_sn=".$detail_sn." and betting_result<>'CANCEL'";
		$rows = $this->db->exeSql($sql);
		
		if(count((array)$rows)>0)
		{
			foreach($rows as $row)
			{
				$betting_result = $row['betting_result'];
	
				if($betting_result=='WIN')
					$this->on_betting_cancel_success($row['member_sn'], $row['prize'], $row['betting_no']);
				
				unset($data);
				$data['prize'] = 0;
				$data['betting_result']='-1';
				$this->db->setUpdate($this->db_qz."live_betting", $data, "sn=".$row['sn']);
				$this->db->exeSql();
			}
		}
	
		unset($data);
		$data['betting_result'] = '-1';
		$this->db->setUpdate($this->db_qz."live_betting", $data, "live_detail_sn=".$detail_sn." and betting_result<>'CANCEL'");
		$this->db->exeSql();
		
		unset($data);
		$data['state'] = 'FIN';
		$this->db->setUpdate($this->db_qz."live_game_detail", $data, "sn=".$detail_sn);
		$rows = $this->db->exeSql();
		
		$json = $this->admin_live_game_detail($detail_sn);
		$json['result'] = 1;
		
		return $json;
	}
	
	function betting_list($member_sn, $page, $page_size, $where='')
	{
		$sql = "select a.*,
						b.sn as live_sn, b.start_time, b.score, b.home_team, b.away_team,
						c.sn as detail_sn, c.win_position,
						e.sn as member_sn, e.nick, e.uid, e.logo as logo,
						f.alias as template_alias, c.template as template, 
						d.lg_img as league_image, d.name as league_name from "
						.$this->db_qz."live_betting a, "
						.$this->db_qz."live_game b, "
						.$this->db_qz."live_game_detail c, "
						.$this->db_qz."league d, "
						.$this->db_qz."member e, "
						.$this->db_qz."live_game_template f
						where a.live_sn=b.sn and a.live_detail_sn=c.sn and b.league_sn=d.sn and c.template=f.template
									and a.member_sn=e.sn and a.visible='Y' and
									e.sn=".$member_sn.$where." order by a.reg_time desc limit ".$page.",".$page_size;
									
		$rows = $this->db->exeSql($sql);	
		
		return $rows;
	}
	
	function betting_list_total($member_sn, $where='')
	{
		$sql = "select count(*) as cnt from "
						.$this->db_qz."live_betting a, "
						.$this->db_qz."live_game b, "
						.$this->db_qz."live_game_detail c, "
						.$this->db_qz."league d, "
						.$this->db_qz."member e, "
						.$this->db_qz."live_game_template f
						where a.live_sn=b.sn and a.live_detail_sn=c.sn and b.league_sn=d.sn and c.template=f.template
									and a.member_sn=e.sn and a.visible='Y' and
									e.sn=".$member_sn.$where;
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];	
	}
	
	function hide_betting($betting_sn)
	{
		$data['visible'] = 'N';
		$this->db->setUpdate($this->db_qz."live_betting", $data, "sn=".$betting_sn);
		return $this->db->exeSql();
	}
	
	function game_result_list($page, $page_size, $where='')
	{
		$sql = "select a.*,
								b.home_team, b.away_team, b.start_time, b.first_score, b.second_score, b.score,
								c.alias as template_alias, c.template, c.period,
								d.name as league_name, d.lg_img as league_image
						from	"
						.$this->db_qz."live_game_detail a, "
						.$this->db_qz."live_game b, "
						.$this->db_qz."live_game_template c, "
						.$this->db_qz."league d 
						where a.live_sn=b.sn and b.league_sn=d.sn and a.template=c.template 
									and c.is_enable=1 and a.state='ACC' ".$where." order by b.start_time desc limit ".$page.",".$page_size;
		$rows = $this->db->exeSql($sql);
		
		for($i=0; $i<count((array)$rows); ++$i)
		{
			$odds = $rows[$i]['odds'];
			$split_odds = $this->split_odds($odds);
			
			$rows[$i]['token_odds'] = $split_odds;
			$rows[$i]['odd_count'] = count(explode(';', $odds))-1;
			
			$period = $rows[$i]['period'];
			
			switch($period) {
				case 1: $score='[전반전] '.$rows[$i]['first_score']; break;
				case 3: $score='[후반전] '.$rows[$i]['second_score']; break;
				case 4: $score='[풀타임] '.$rows[$i]['score']; break;
			}
			$rows[$i]['score'] = $score;
		}
		
		return $rows;
	}
	
	function game_result_list_total($where='')
	{
		$sql = "select count(*) as cnt 
						from	"
						.$this->db_qz."live_game_detail a, "
						.$this->db_qz."live_game b, "
						.$this->db_qz."live_game_template c, "
						.$this->db_qz."league d 
						where a.live_sn=b.sn and b.league_sn=d.sn and a.template=c.template 
									and c.is_enable=1 and a.state='ACC' ".$where;
		$rows = $this->db->exeSql($sql);
		
		return $rows[0]['cnt'];
	}
	
	function update_live_detail_state($detail_sn, $state)
	{
		$data['state'] = $state;
		$this->db->setUpdate($this->db_qz."live_game_detail", $data, "sn=".$detail_sn);
		return $this->db->exeSql();
	}
	
	function update_pause_state($detail_sn, $state)
	{
		$data['paused'] = $state;
		$this->db->setUpdate($this->db_qz."live_game_detail", $data, "sn=".$detail_sn);
		return $this->db->exeSql();
	}
	
	function update_access_time($field)
	{
		$data[$field] = "SYSDATE()";
		$this->db->setUpdate($this->db_qz."live_daemon_state", $data, "1=1");
		return $this->db->exeSql();
	}
	
	function delete_live_game($live_sn)
	{
		$sql = "delete from tb_live_game
						where sn=".$live_sn." and state='READY' ";
		return $this->db->exeSql($sql);
	}
	
	function daemon_state()
	{
		$sql = "select * from tb_live_daemon_state";
		$rows = $this->db->exeSql($sql);
		return $rows[0];
	}
	
	function live_game($live_sn)
	{
		$sql = "select * from tb_live_game where sn=".$live_sn;
		$rows = $this->db->exeSql($sql);
		$row = $rows[0];
		
		$first_score = $row['first_score'];
		$second_score = $row['second_score'];
		
		if($first_score!='-1') {
			$token = explode(":", $first_score);	
			$row['first_score_0'] = $token[0];
			$row['first_score_1'] = $token[1];
		}
		
		return $row;
	}
	
	function live_game_broadcast($live_sn, $type='')
	{
		if($type!='') {
			$where = " and type=".$type;
		}
		$sql = "select * from tb_live_game_broadcast
							where live_sn=".$live_sn.$where." order by sn desc";
		$rows = $this->db->exeSql($sql);
		return $rows;
	}
	
	function last_betting_time($member_sn)
	{
		$sql = "select reg_time
						from tb_live_betting
						where member_sn=".$member_sn." order by reg_time desc limit 0,1";
		$rs = $this->db->exeSql($sql);
		return $rs[0]['reg_time'];
	}
	
	function betting_position_detail($detail_sn, $betting_position)
	{
		$sql = "select a.sn as betting_sn, a.betting_no, a.member_sn, a.odd, a.betting_result, a.prize, a.reg_time, a.ip, a.betting_money, 
								b.uid, b.nick from tb_live_betting a, tb_member b
						where a.member_sn=b.sn and
									live_detail_sn=".$detail_sn." and betting_position='".$betting_position."'";
		$rows = $this->db->exeSql($sql);
		
		return $rows;
	}
	
	function playing_live_games($event_id)
	{
		$sql = "select * from tb_live_game
						where (state<>'READY' and state<>'FIN') ";// and event_id<>".$event_id;
		$rows = $this->db->exeSql($sql);
		
		return $rows;
	}
	
	function live_game_static()
	{
		$sql = "select sum(betting_money) as betting_money, sum(prize) as prize, count(*) as count from tb_live_betting";
		$rows = $this->db->exeSql($sql);
		
		return $rows[0];
	}
	
	function date_diff($date)
	{
		$now=date("Y-m-d H:i");
		$diff =strtotime($now) - strtotime($date);
		return $diff;
	}
	
	function index_event_id()
	{
		$sql = "select event_id from tb_live_game order by start_time";
		$rows = $this->db->exeSql($sql);
		
		return $rows[0]['event_id'];
	}
}
?>