<?php

class LiveBwin
{
	public $broadCast = array();
	
	function __construct()
  	{
	}
	
	function loadHtml($url)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // https 접속시
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_URL, $url);
			
		$url_source = curl_exec($curl);
		curl_close($curl);
	
		return $url_source;
	}
  
	function parseV2GetEventData($liveSn, $eventId)
 	{
 		$url = "http://en.live.bwin.com/V2GetEventData.aspx?cs=75A900F4&n=1&cts=635261615016060882&diff=1&r=".mktime()."&lang=1&mbo=0&eid=".$eventId;
 		$url_source = $this->loadHtml($url);
 		
 		$xml = simplexml_load_string($url_source);
 		
		$games = array();
 		
 		$games['live_sn'] = $liveSn;
		$games['event_id'] = $eventId;
 		
 		foreach($xml->children() as $child)
 		{
 			if($child->getName()=="LiveEvents")
 			{
 				foreach($xml->LiveEvents->E->Games as $xml_game)
				{
					foreach($xml_game as $G)
					{
						$game = array();
						$game['template'] = $G->attributes()->GameTemplate;
						$game['template_name'] = $G->attributes()->N;
						$game['is_visible'] = $G->attributes()->GameIsVisible;
						
						foreach($G as $R) 
						{
							$odd = $R->attributes()->N.":".$R->attributes()->O0;
							$odds.=$odd.";";
						}
						$game['odds'] = $odds;
						$games['item'][] = $game;
						
						unset($game);
						$odds='';
					}
				}
 			}
 			else if($child->getName()=="c01_l000")
 			{
				$games['timer'] = $this->parseTimer($xml);
				$games['message'] = $this->pareseMessage($xml);
				$games['score'] = $this->parseScore($xml);
				$games['period'] = $this->parsePeriod($xml);
 			}
 			
 			else if($child->getName()=="response")
 			{
 				$response = $xml->response->attributes()->sts;
 				$games['sts']=$response;
 			}
 		}
 		
		return $games;	
	}
	
	function parseTimer($xml)
	{
		return $xml->c01_l000->SCORESTAT->SBNG_Timer->attributes()->v;
	}
	
	function pareseMessage($xml)
	{
		$messages = array();
		foreach($xml->c01_l000->SCORESTAT->SBNG_Messages->M as $M)
		{
			$messages[] = array($M->attributes()->Type, $M->attributes()->Timer, $M);
		}
		return $messages;
	}
	
	function parseScore($xml)
	{
		foreach($xml->c01_l000->SCORESTAT->SBNG_SoccerDblGoal->T1->C as $t1)
		{
			if($t1->attributes()->pid==255)
			{
				$score[0] = $t1->attributes()->v;
			}
		}
		foreach($xml->c01_l000->SCORESTAT->SBNG_SoccerDblGoal->T2->C as $t2)
		{
			if($t2->attributes()->pid==255)
			{
				$score[1] = $t2->attributes()->v;
			}
		}
		return $score;
	}
	
	//1=1st Half
	//2= Half Time
	//3=2nd Half
	function parsePeriod($xml)
	{
		return $xml->c01_l000->SCORESTAT->SBNG_Period->attributes()->pid;
	}
	
	function parseV2GetLiveEventsWithMainbets($event_id)
	{
		$url = "http://en.live.bwin.com/V2GetLiveEventsWithMainbets.aspx?cts=635267801813506050&cs=75A900F7&label=1&n=1&lang=1&r=".mktime();
 		$url_source = $this->loadHtml($url);
 		
 		$xml = simplexml_load_string($url_source);
 		
 		$event = array();
 		
 		foreach($xml->c02_l000->SCORESTAT as $score_seat)
		{
			$main_bets = array();
			if($score_seat->attributes()->eid==$event_id)
			{
				//00:00 or 45:00
				$std_time = $score_seat->SBNG_Timer->attributes()->v;
				$split_time = explode(":", $std_time);
				$sec_std_time = $split_time[0]*60+$split_time[1];
				
				//2014-02-01T07:37:55 
				//이시간은 $std_time을 의미한다.
				$action_ts = $score_seat->SBNG_Timer->attributes()->ActionTS;
				
				//utc -> time
				$n = sscanf($action_ts, "%d-%d-%dT%d:%d:%dZ", $year, $month, $day, $hour, $min, $sec);
				$time = mktime($hour, $min, $sec, $month, $day, $year)+60*60*9; //9시간
				
				$elasped_time = time()-$time+$sec_std_time;
				$elasped_min = (int)($elasped_time/60);
				$elasped_sec = (int)($elasped_time-($elasped_min*60));
				
				if($elasped_min<10) $elasped_min = "0".$elasped_min;
				if($elasped_sec<10) $elasped_sec = "0".$elasped_sec;
				
				$event['elasped'] = $elasped_min.":".$elasped_sec;
				$period = $score_seat->SBNG_Period->attributes()->pid;
				
				switch($period)
				{
					case 0: $period="시작대기"; break;
					case 1: $period="전반전"; break;
					case 2: $period="하프타임"; break;
					case 3: $period="후반전"; break;
				}
				$event['period'] = $period;
				
				$event['score'][0] = $score_seat->SBNG_SoccerDblGoal->T1->C->attributes()->v;
				$event['score'][1] = $score_seat->SBNG_SoccerDblGoal->T2->C->attributes()->v;
				
				return $event;
			}
		}
		
		return $event;
	}
	
	function calc_win_position($template, $score)
	{
		// '1' or 'X' or '2' or '4'
		$scores = explode(":", $score);
		$win_position = -1;
		switch($template)
		{
			//핸디캡(-1)
			case 52:
			{
				if($scores[0] > ($scores[1]+1))
					$win_position='1';
				else if($scores[0] == ($scores[1]+1))
					$win_position='X';
				else if($scores[0] < ($scores[1]+1))
					$win_position='2';
				else
					$win_position='-1';
			}break;
			
			//핸디캡(-2)
			case 501:
			{
				if($scores[0] > ($scores[1]+2))
					$win_position='1';
				else if($scores[0] == ($scores[1]+2))
					$win_position='X';
				else if($scores[0] < ($scores[1]+2))
					$win_position='2';
				else
					$win_position='-1';
			}break;
			
			//핸디캡(-3)
			case 635:
			{
				if($scores[0] > ($scores[1]+3))
					$win_position='1';
				else if($scores[0] == ($scores[1]+3))
					$win_position='X';
				else if($scores[0] < ($scores[1]+3))
					$win_position='2';
				else
					$win_position='-1';
			}break;
			
			//핸디캡(+1)
			case 54:
			{
				if($scores[0]+1 > ($scores[1]))
					$win_position='1';
				else if($scores[0]+1 == ($scores[1]))
					$win_position='X';
				else if($scores[0]+1 < ($scores[1]))
					$win_position='2';
				else
					$win_position='-1';
			}break;
			
			//승무패
			case 17:
			{
				if($scores[0] > $scores[1])
					$win_position='1';
				else if($scores[0] == $scores[1])
					$win_position='X';
				else if($scores[0] < $scores[1])
					$win_position='2';
				else
					$win_position='-1';
			}break;
			
			//스코어
			case 19193:
			{
				$win_position=$scores[0]."-".$scores[1];
			}break;
			
			//[풀타임] 홀짝
			case 4665:
			{
				$goal = $scores[0]+$scores[1];
				if($goal==0)
					$win_position='Even';
				else if($goal%2==0)
					$win_position='Even';
				else 
					$win_position='Odd';
			}break;
		}
		return $win_position;
	}
}
?>