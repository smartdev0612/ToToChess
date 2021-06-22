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
		
		/*
		$url_source="<?xml version='1.0' encoding='UTF-8'?><ROOT><LiveEvents xmlns:msxsl='urn:schemas-microsoft-com:xslt'><E EventID='3540162' LeagueID='33774' N='Campeonato Cearense' RegID='33' RegN='Brazil' BookieTicker='' Score='' GameState='Not Started' GameBeginTimeStampGMT='' SportsTemplate='4' GameStoppedTimeStampGMT='' GameStopped='0' GameBeginTimeStampUTC='' GameStoppedTimeStampUTC='' BetRadarID=''><Games><G GameID='66408859' N='How many goals will be scored between 75:01 minutes and Full Time?' GameIsVisible='1' CP='9' Columns='2' Mainbet='0' GameTemplate='15550' UsePlayerNames='0'><R RID='224506811' RV='1' N='Over 1,5' O0='2.75' /><R RID='224506812' RV='1' N='Under 1,5' O0='1.40' /></G><G GameID='66408594' N='3-way - result' GameIsVisible='1' CP='9' Columns='3' Mainbet='1' GameTemplate='17' UsePlayerNames='1'><R RID='224505987' RV='1' N='1' O0='4.20' /><R RID='224505988' RV='1' N='X' O0='1.34' /><R RID='224505989' RV='1' N='2' O0='7.75' /></G><G GameID='66408595' N='2Way special (Stake returned if game ends in a draw within regular time)' GameIsVisible='1' CP='9' Columns='2' Mainbet='0' GameTemplate='12119' UsePlayerNames='1'><R RID='224505990' RV='1' N='1' O0='1.40' /><R RID='224505991' RV='1' N='2' O0='2.70' /></G><G GameID='66408598' N='Handicap 0:1' GameIsVisible='1' CP='9' Columns='3' Mainbet='0' GameTemplate='52' UsePlayerNames='1'><R RID='224505996' RV='1' N='1' O0='28.00' /><R RID='224505997' RV='1' N='X' O0='4.50' /><R RID='224505998' RV='1' N='2' O0='1.21' /></G><G GameID='66408599' N='Handicap 0:2' GameIsVisible='0' CP='9' Columns='3' Mainbet='0' GameTemplate='501' UsePlayerNames='1'><R RID='224505999' RV='1' N='1' O0='101.00' /><R RID='224506000' RV='1' N='X' O0='9.00' /><R RID='224506001' RV='1' N='2' O0='1.01' /></G><G GameID='66408607' N='Handicap 1:0' GameIsVisible='1' CP='9' Columns='3' Mainbet='0' GameTemplate='54' UsePlayerNames='1'><R RID='224506023' RV='1' N='1' O0='1.06' /><R RID='224506024' RV='1' N='X' O0='6.75' /><R RID='224506025' RV='1' N='2' O0='67.00' /></G><G GameID='66408620' N='Which team will score the 5th goal?' GameIsVisible='1' CP='9' Columns='3' Mainbet='0' GameTemplate='1347' UsePlayerNames='1'><R RID='224506062' RV='1' N='1' O0='4.00' /><R RID='224506063' RV='1' N='No 5th goal' O0='1.40' /><R RID='224506064' RV='1' N='2' O0='7.00' /></G><G GameID='66408632' N='How many goals will be scored?' GameIsVisible='1' CP='9' Columns='2' Mainbet='0' GameTemplate='1791' UsePlayerNames='0'><R RID='224506094' RV='1' N='Over 4,5' O0='2.75' /><R RID='224506095' RV='1' N='Under 4,5' O0='1.40' /></G><G GameID='66408633' N='How many goals will be scored?' GameIsVisible='1' CP='9' Columns='2' Mainbet='0' GameTemplate='859' UsePlayerNames='0'><R RID='224506096' RV='1' N='Over 5,5' O0='10.00' /><R RID='224506097' RV='1' N='Under 5,5' O0='1.02' /></G><G GameID='66408634' N='How many goals will be scored?' GameIsVisible='0' CP='9' Columns='2' Mainbet='0' GameTemplate='313' UsePlayerNames='0'><R RID='224506098' RV='1' N='Over 6,5' O0='34.00' /><R RID='224506099' RV='1' N='Under 6,5' O0='1.01' /></G><G GameID='66408658' N='Rest of the match ? Current score: 2:2' GameIsVisible='1' CP='2' Columns='3' Mainbet='0' GameTemplate='21079' UsePlayerNames='1'><R RID='224506165' RV='1' N='1' O0='4.20' /><R RID='224506166' RV='1' N='X' O0='1.34' /><R RID='224506167' RV='1' N='2' O0='7.75' /></G><G GameID='66408767' N='1X2 Result And Over/Under 2.5' GameIsVisible='0' CP='9' Columns='2' Mainbet='0' GameTemplate='20589' UsePlayerNames='0'><R RID='224506510' RV='1' N='Team 1 to win and over 2,5 combined goals scored in the game' O0='4.20' /><R RID='224506511' RV='1' N='Team 2 to win and over 2,5 combined goals scored in the game' O0='7.75' /><R RID='224506512' RV='0' N='Team 1 to win and under 2,5 combined goals scored in the game' O0='1.00' /><R RID='224506513' RV='0' N='Team 2 to win and under 2,5 combined goals scored in the game' O0='1.00' /><R RID='224506514' RV='1' N='Draw' O0='1.34' /></G><G GameID='66408768' N='1X2 Result And Over/Under 3.5' GameIsVisible='0' CP='9' Columns='2' Mainbet='0' GameTemplate='20592' UsePlayerNames='0'><R RID='224506515' RV='1' N='Team 1 to win and over 3,5 combined goals scored in the game' O0='4.20' /><R RID='224506516' RV='1' N='Team 2 to win and over 3,5 combined goals scored in the game' O0='7.75' /><R RID='224506517' RV='0' N='Team 1 to win and under 3,5 combined goals scored in the game' O0='1.00' /><R RID='224506518' RV='0' N='Team 2 to win and under 3,5 combined goals scored in the game' O0='1.00' /><R RID='224506519' RV='1' N='Draw' O0='1.34' /></G><G GameID='66408790' N='Double chance' GameIsVisible='1' CP='9' Columns='3' Mainbet='0' GameTemplate='3187' UsePlayerNames='1'><R RID='224506565' RV='1' N='1 and X' O0='1.06' /><R RID='224506566' RV='1' N='X and 2' O0='1.18' /><R RID='224506567' RV='1' N='1 and 2' O0='2.70' /></G><G GameID='66408798' N='Will the number of goals scored be odd or even? (No goal counts as even)' GameIsVisible='1' CP='9' Columns='2' Mainbet='0' GameTemplate='4665' UsePlayerNames='0'><R RID='224506612' RV='1' N='Even' O0='1.30' /><R RID='224506613' RV='1' N='Odd' O0='3.20' /></G><G GameID='66408800' N='How many goals will Team 1 score?' GameIsVisible='1' CP='9' Columns='2' Mainbet='0' GameTemplate='4726' UsePlayerNames='0'><R RID='224506616' RV='0' N='No goal' O0='1.00' /><R RID='224506617' RV='0' N='1' O0='1.00' /><R RID='224506618' RV='1' N='2' O0='1.19' /><R RID='224506619' RV='1' N='3 or more' O0='3.40' /></G><G GameID='66408804' N='How many goals will Team 2 score?' GameIsVisible='1' CP='9' Columns='2' Mainbet='0' GameTemplate='4727' UsePlayerNames='0'><R RID='224506626' RV='0' N='No goal' O0='1.00' /><R RID='224506627' RV='0' N='1' O0='1.00' /><R RID='224506628' RV='1' N='2' O0='1.07' /><R RID='224506629' RV='1' N='3 or more' O0='5.25' /></G><G GameID='66408808' N='How many goals will be scored?' GameIsVisible='1' CP='9' Columns='3' Mainbet='0' GameTemplate='2196' UsePlayerNames='0'><R RID='224506636' RV='0' N='No goal' O0='1.00' /><R RID='224506637' RV='0' N='Exactly 1 Goal ' O0='1.00' /><R RID='224506638' RV='0' N='Exactly 2 Goals' O0='1.00' /><R RID='224506639' RV='0' N='Exactly 3 Goals' O0='1.00' /><R RID='224506640' RV='1' N='Exactly 4 Goals' O0='1.40' /><R RID='224506641' RV='1' N='Exactly 5 Goals' O0='2.85' /><R RID='224506642' RV='1' N='Exactly 6 Goals' O0='9.25' /><R RID='224506643' RV='1' N='Exactly 7 Goals' O0='51.00' /><R RID='224506644' RV='1' N='8 or more Goals' O0='251.00' /></G><G GameID='66408809' N='Goal bet (regular time)' GameIsVisible='1' CP='9' Columns='2' Mainbet='0' GameTemplate='19193' UsePlayerNames='0'><R RID='224506645' RV='0' N='0-0' O0='1.00' /><R RID='224506646' RV='0' N='1-0' O0='1.00' /><R RID='224506647' RV='0' N='1-1' O0='1.00' /><R RID='224506648' RV='0' N='0-1' O0='1.00' /><R RID='224506649' RV='0' N='2-0' O0='1.00' /><R RID='224506650' RV='0' N='2-1' O0='1.00' /><R RID='224506651' RV='1' N='2-2' O0='1.40' /><R RID='224506652' RV='0' N='1-2' O0='1.00' /><R RID='224506653' RV='0' N='0-2' O0='1.00' /><R RID='224506654' RV='0' N='3-0' O0='1.00' /><R RID='224506655' RV='0' N='3-1' O0='1.00' /><R RID='224506656' RV='1' N='3-2' O0='3.90' /><R RID='224506657' RV='1' N='3-3' O0='11.50' /><R RID='224506658' RV='1' N='2-3' O0='6.25' /><R RID='224506659' RV='0' N='1-3' O0='1.00' /><R RID='224506660' RV='0' N='0-3' O0='1.00' /><R RID='224506661' RV='0' N='4-0' O0='1.00' /><R RID='224506662' RV='0' N='4-1' O0='1.00' /><R RID='224506663' RV='1' N='4-2' O0='12.00' /><R RID='224506664' RV='1' N='4-3' O0='101.00' /><R RID='224506665' RV='1' N='4-4' O0='251.00' /><R RID='224506666' RV='1' N='3-4' O0='201.00' /><R RID='224506667' RV='1' N='2-4' O0='41.00' /><R RID='224506668' RV='0' N='1-4' O0='1.00' /><R RID='224506669' RV='0' N='0-4' O0='1.00' /><R RID='224506670' RV='1' N='Any other score' O0='126.00' /></G><G GameID='66408810' N='Multiple Correct Score' GameIsVisible='1' CP='9' Columns='2' Mainbet='0' GameTemplate='20590' UsePlayerNames='0'><R RID='224506671' RV='0' N='1:0, 2:0 or 3:0' O0='1.00' /><R RID='224506672' RV='0' N='0:1, 0:2 or 0:3' O0='1.00' /><R RID='224506673' RV='0' N='4:0, 5:0 or 6:0' O0='1.00' /><R RID='224506674' RV='0' N='0:4, 0:5 or 0:6' O0='1.00' /><R RID='224506675' RV='0' N='2:1, 3:1 or 4:1' O0='1.00' /><R RID='224506676' RV='0' N='1:2, 1:3 or 1:4' O0='1.00' /><R RID='224506677' RV='1' N='3:2, 4:2, 4:3 or 5:1' O0='3.40' /><R RID='224506678' RV='1' N='2:3, 2:4, 3:4 or 1:5' O0='5.25' /><R RID='224506679' RV='1' N='Team 1 to win by any other Score' O0='81.00' /><R RID='224506680' RV='1' N='Team 2 to win by any other score' O0='251.00' /><R RID='224506681' RV='1' N='Draw' O0='1.34' /></G></Games><Messages /></E></LiveEvents><c01_l000><SCORESTAT V='5.0' kind='full' eid='3540162' sid='4' type='default' sbName='Soccer_SBNG'><SBNG_SoccerDblCounter id='PNLT' vis='1'><T1><C pid='1' v='0' /><C pid='3' v='0' /><C pid='253' v='0' /><C pid='254' v='0' /><C pid='255' v='0' /></T1><T2><C pid='1' v='0' /><C pid='3' v='0' /><C pid='253' v='0' /><C pid='254' v='0' /><C pid='255' v='0' /></T2></SBNG_SoccerDblCounter><SBNG_Timer id='TIMER' vis='1' v='45:00' ActionTS='2014-01-28T00:25:47' Running='1' ActionTSUtc='2014-01-28T00:25:47.3704336Z' /><SBNG_Messages id='MSGS' vis='1' refTime='2014-01-27T23:34:46.3404520Z'><M Type='255' Timer='80:43' pid='3' uid='5211003' team='02' scoreType='shot' goalTime='75toFT' ordinal='11'>Goal for Tiradentes CE (by shot) : 2-2</M><M Type='255' Timer='62:39' pid='3' uid='4125492' team='02' scoreType='shot' goalTime='60to75' ordinal='10'>Goal for Tiradentes CE (by shot) : 2-1</M><M Type='253' Timer='52:51' pid='3' uid='3539053' team='01' ordinal='9'>1st Yellow card to Icasa</M><M Type='1' Timer='45:00' pid='3' uid='3066699' ppid='2' ordinal='8'>2nd Half</M><M Type='1' Timer='47:32' pid='2' uid='2019043' ppid='1' ordinal='7'>Halftime</M><M Type='252' Timer='19:36' pid='1' uid='343199' team='02' ordinal='6'>3rd Corner to Tiradentes CE</M><M Type='255' Timer='19:15' pid='1' uid='322999' team='01' scoreType='shot' goalTime='15to30' ordinal='5'>Goal for Icasa (by shot) : 2-0</M><M Type='252' Timer='15:48' pid='1' uid='115531' team='01' ordinal='4'>2nd Corner to Icasa</M><M Type='255' Timer='01:25' pid='1' uid='84705' team='01' scoreType='shot' goalTime='0to15' ordinal='3'>Goal for Icasa (by shot) : 1-0</M><M Type='252' Timer='00:25' pid='1' uid='25708' team='01' ordinal='2'>1st Corner to Icasa</M><M Type='1' Timer='00:00' pid='1' uid='0' ppid='0' ordinal='1'>1st Half</M></SBNG_Messages><SBNG_Bookieticker id='BT' vis='1' v='' /><SBNG_Period id='PERIOD' vis='1' pid='3' ppid='2' /><SBNG_SoccerDblCounter id='FK' vis='0'><T1><C pid='1' v='0' /><C pid='3' v='0' /><C pid='253' v='0' /><C pid='254' v='0' /><C pid='255' v='0' /></T1><T2><C pid='1' v='0' /><C pid='3' v='0' /><C pid='253' v='0' /><C pid='254' v='0' /><C pid='255' v='0' /></T2></SBNG_SoccerDblCounter><SBNG_SoccerDblGoal id='G' vis='1'><T1><C pid='1' v='2' /><C pid='3' v='0' /><C pid='5' v='0' /><C pid='7' v='0' /><C pid='9' v='0' /><C pid='253' v='0' /><C pid='254' v='2' /><C pid='255' v='2' /></T1><T2><C pid='1' v='0' /><C pid='3' v='2' /><C pid='5' v='0' /><C pid='7' v='0' /><C pid='9' v='0' /><C pid='253' v='0' /><C pid='254' v='2' /><C pid='255' v='2' /></T2></SBNG_SoccerDblGoal><SBNG_SoccerDblSubstit id='SBST' vis='0'><T1><C pid='1' v='0' /><C pid='3' v='0' /><C pid='253' v='0' /><C pid='254' v='0' /><C pid='255' v='0' /></T1><T2><C pid='1' v='0' /><C pid='3' v='0' /><C pid='253' v='0' /><C pid='254' v='0' /><C pid='255' v='0' /></T2></SBNG_SoccerDblSubstit><SBNG_SoccerDblCounter id='RC' vis='1'><T1><C pid='1' v='0' /><C pid='3' v='0' /><C pid='253' v='0' /><C pid='254' v='0' /><C pid='255' v='0' /></T1><T2><C pid='1' v='0' /><C pid='3' v='0' /><C pid='253' v='0' /><C pid='254' v='0' /><C pid='255' v='0' /></T2></SBNG_SoccerDblCounter><SBNG_SoccerDblCounter id='OFSD' vis='0'><T1><C pid='1' v='0' /><C pid='3' v='0' /><C pid='253' v='0' /><C pid='254' v='0' /><C pid='255' v='0' /></T1><T2><C pid='1' v='0' /><C pid='3' v='0' /><C pid='253' v='0' /><C pid='254' v='0' /><C pid='255' v='0' /></T2></SBNG_SoccerDblCounter><SBNG_SoccerDblCounter id='YC' vis='1'><T1><C pid='1' v='0' /><C pid='3' v='1' /><C pid='253' v='0' /><C pid='254' v='1' /><C pid='255' v='1' /></T1><T2><C pid='1' v='0' /><C pid='3' v='0' /><C pid='253' v='0' /><C pid='254' v='0' /><C pid='255' v='0' /></T2></SBNG_SoccerDblCounter><SBNG_SoccerDblCounter id='GK' vis='0'><T1><C pid='1' v='0' /><C pid='3' v='0' /><C pid='253' v='0' /><C pid='254' v='0' /><C pid='255' v='0' /></T1><T2><C pid='1' v='0' /><C pid='3' v='0' /><C pid='253' v='0' /><C pid='254' v='0' /><C pid='255' v='0' /></T2></SBNG_SoccerDblCounter><SBNG_SoccerDblCounter id='CRN' vis='0'><T1><C pid='1' v='2' /><C pid='3' v='0' /><C pid='253' v='0' /><C pid='254' v='2' /><C pid='255' v='2' /></T1><T2><C pid='1' v='1' /><C pid='3' v='0' /><C pid='253' v='0' /><C pid='254' v='1' /><C pid='255' v='1' /></T2></SBNG_SoccerDblCounter><SBNG_SoccerDblCounter id='TI' vis='0'><T1><C pid='1' v='0' /><C pid='3' v='0' /><C pid='253' v='0' /><C pid='254' v='0' /><C pid='255' v='0' /></T1><T2><C pid='1' v='0' /><C pid='3' v='0' /><C pid='253' v='0' /><C pid='254' v='0' /><C pid='255' v='0' /></T2></SBNG_SoccerDblCounter><SBNG_SoccerPenaltiesControl id='PC' vis='1'><T1><P id='1' v='2' /><P id='2' v='2' /><P id='3' v='2' /><P id='4' v='2' /><P id='5' v='2' /></T1><T2><P id='1' v='2' /><P id='2' v='2' /><P id='3' v='2' /><P id='4' v='2' /><P id='5' v='2' /></T2></SBNG_SoccerPenaltiesControl><SBNG_DblPlayerInfo id='PLRINF' vis='1' ColorsAvailable='0'><SBNG_PlayerInfo id='01' vis='1' ShirtColor='0' ShortsColor='0' TeamName='Icasa' /><SBNG_PlayerInfo id='02' vis='1' ShirtColor='ffffff' ShortsColor='ffffff' TeamName='Tiradentes CE' /></SBNG_DblPlayerInfo></SCORESTAT></c01_l000><response sts='635264677740645338'/></ROOT>";
		*/
		
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
							$odd_name = $R->attributes()->N;
							if(strpos($odd_name, "Over")!==false) {
								$odd_name = "Over";
							} else if(strpos($odd_name, "Under")!==false) {
								$odd_name = "Under";
							}
							
							$odd = $odd_name.":".$R->attributes()->O0;
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
				//period (1=1st half, 2=half time, 3=2nd half)
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
				$score = $t1->attributes()->v;
			}
		}
		foreach($xml->c01_l000->SCORESTAT->SBNG_SoccerDblGoal->T2->C as $t2)
		{
			if($t2->attributes()->pid==255)
			{
				$score .= ":".$t2->attributes()->v;
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

				$event['period'] = $period;
				
				if(isset($score_seat->SBNG_SoccerDblGoal->T1->C))
				{
					$event['score'][0] = $score_seat->SBNG_SoccerDblGoal->T1->C->attributes()->v;
				}
				if(isset($score_seat->SBNG_SoccerDblGoal->T2->C))
				{
					$event['score'][1] = $score_seat->SBNG_SoccerDblGoal->T2->C->attributes()->v;
				}
				
				return $event;
			}
		}
		
		return $event;
	}
	
	function parseV2GetLiveEventsWithMainbets2()
	{
		$url = "http://en.live.bwin.com/V2GetLiveEventsWithMainbets.aspx?cts=635267801813506050&cs=75A900F7&label=1&n=1&lang=1&r=".mktime();
 		$url_source = $this->loadHtml($url);
 		
 		$xml = simplexml_load_string($url_source);
 		
 		$events = array();
 		
 		if(isset($xml->c02_l000->SCORESTAT) && count($xml->c02_l000->SCORESTAT)>0)
 		{
	 		foreach($xml->c02_l000->SCORESTAT as $score_seat)
			{
				if($score_seat->attributes()->sid=='4')
				{
					$event = array();
					
					//00:00 or 45:00
					$event['event_id'] = $score_seat->attributes()->eid;
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
	
					$event['period'] = $period;
					
					if(isset($score_seat->SBNG_SoccerDblGoal->T1->C))
					{
						$event['score'][0] = $score_seat->SBNG_SoccerDblGoal->T1->C->attributes()->v;
					}
					if(isset($score_seat->SBNG_SoccerDblGoal->T2->C))
					{
						$event['score'][1] = $score_seat->SBNG_SoccerDblGoal->T2->C->attributes()->v;
					}
					
					$events[] = $event;
				}
			}
		}
		
		return $events;
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
			
			//[풀타임] 승무패, [전반전] 승무패
			case 2488:
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
			case 4777:
			case 19193:
			{
				if($scores[0]>4 || $scores[1]>4)
					$win_position='Any other score';
				else
					$win_position=$scores[0]."-".$scores[1];
			}break;
			
			//홀짝
			case 4665:
			{
				$sum = $scores[0]+$scores[1];
				if($sum%2==0)
					$win_position = "Even";
				else 
					$win_position = "Odd";
			}break;
			
			//기준점 0.5 언오버
			case 7688:
			case 7233: {
				$stand = 0.5;
				$sum = $scores[0]+$scores[1];
				if($sum > $stand)
					$win_position = "Over";
				else 
					$win_position = "Under";
			}break;
			
			//기준점 1.5 언오버
			case 7689:
			case 1772: {
				$stand = 1.5;
				$sum = $scores[0]+$scores[1];
				if($sum > $stand)
					$win_position = "Over";
				else 
					$win_position = "Under";
			}break;
			
			//기준점 2.5 언오버
			case 7890:
			case 173: {
				$stand = 2.5;
				$sum = $scores[0]+$scores[1];
				if($sum > $stand)
					$win_position = "Over";
				else 
					$win_position = "Under";
			}break;
			
			//기준점 3.5 언오버
			case 7891:
			case 8933: {
				$stand = 3.5;
				$sum = $scores[0]+$scores[1];
				if($sum > $stand)
					$win_position = "Over";
				else 
					$win_position = "Under";
			}break;
			
			//기준점 4.5 언오버
			case 1791: {
				$stand = 4.5;
				$sum = $scores[0]+$scores[1];
				if($sum > $stand)
					$win_position = "Over";
				else 
					$win_position = "Under";
			}break;
			
			//기준점 5.5 언오버
			case 859: {
				$stand = 5.5;
				$sum = $scores[0]+$scores[1];
				if($sum > $stand)
					$win_position = "Over";
				else 
					$win_position = "Under";
			}break;
		}
		
		return $win_position;
	}
}
?>