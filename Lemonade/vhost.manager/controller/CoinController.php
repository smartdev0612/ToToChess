<?
/*
* Index Controller
*/
class CoinController extends WebServiceController 
{
	//▶ 사다리 게임 자동 처리
	function indexAction()
	{
		$this->popupDefine('coin');
		
		//$this->ladderListenerAction();
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$this->view->define("content","content/Coin/auto.html");
		$this->display();
	}
	
	function coinListenerAction()
	{
		$this->popupDefine('coin');

		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}

				
		$game_model					= $this->getModel("GameModel");
		$league_model 				= $this->getModel("LeagueModel");
		$process_model				= $this->getModel("ProcessModel");
		$ladder_model				= $this->getModel("CoinModel");
		
		//오늘날짜
		$now_date = date("Y-m-d");
		$now_time = date("H:i");
		
		$now_hour	= date("H");
		$now_min	= date("i");
		
		//현재회차
		$now_cnt = floor(($now_hour*60+$now_min)/5);	
		
		$is_game_made_288 = $game_model->getRow('*', $game_model->db_qz."child", "league_sn=4446 and gameDate='".$now_date."' and home_team like '%288%'");

		//게임생성
		if(!count((array)$is_game_made_288))
		{
			for($i=$now_cnt+1; $i <= 288; $i++)
			{
				$now_hour = floor($i*5/60);
				$now_minute = $i*5-$now_hour*60;
				
				if($now_hour<10)		{$now_hour = "0".$now_hour;}
				if($now_minute<10)	{$now_minute = "0".$now_minute;}
				
				$is_game_made = $game_model->getRow('*', $game_model->db_qz."child", "league_sn=4446 and gameDate='".$now_date."' and home_team like '".$i."회차%'");
				if(!count((array)$is_game_made))
				{
					if ( $i == 288 ) {
						$now_hour = 23;
						$now_minute = 59;
					}
					$game_model->addChild($parentSn,'기타',4446,$i."회차 [금]",$i."회차 [은]",$now_date,$now_hour,$now_minute,'','0',1,6,1.95,1,1.95);
					$game_model->addChild($parentSn,'기타',4448,$i."회차 [좌]",$i."회차 [우]",$now_date,$now_hour,$now_minute,'','0',1,6,1.95,1,1.95);
					$game_model->addChild($parentSn,'기타',4447,$i."회차 [앞]",$i."회차 [뒤]",$now_date,$now_hour,$now_minute,'','0',1,6,1.95,1,1.95);
				}
			}
		}

		//-> 최근 결과 콜
		$ladder_data = $this->parseLadder2Action();

		
		//-> 최근 288회 결과는 다음날 0시에 나오기 때문에 하루를 -1일 경기를 타겟 해준다.
		if ( $ladder_data["gamenum"] == 288 and date("H",time()) == "00" ) {
			$now_date = date("Y-m-d",strtotime($now_date)-3600);
		}

		//-> 금/은
		$edit_game = $game_model->getRow('*', $game_model->db_qz."child", "league_sn=4446 and gameDate='".$now_date."' and home_team='".$ladder_data["gamenum"]."회차 [금]'");
		if(count((array)$edit_game)!=0 && $edit_game['kubun'] != 1 && $edit_game['hume_score'] =='' && $edit_game['away_score'] =='') {
			if(strstr($ladder_data["gameresult2"], "금")) {
				$home_score = '1';
				$away_score = '0';
			} else {
				$home_score = '0';
				$away_score = '1';
			}
			$process_model->resultGameProcessing($edit_game["sn"], $home_score, $away_score);
		}

		//-> 좌/우
		$edit_game = $game_model->getRow('*', $game_model->db_qz."child", "league_sn=4448 and gameDate='".$now_date."' and home_team='".$ladder_data["gamenum"]."회차 [좌]'");
		if(count((array)$edit_game)!=0 && $edit_game['kubun'] != 1 && $edit_game['hume_score'] =='' && $edit_game['away_score'] =='') {
			if(strstr($ladder_data["gameresult1"], "좌")) {
				$home_score = '1';
				$away_score = '0';
			} else {
				$home_score = '0';
				$away_score = '1';
			}
			$process_model->resultGameProcessing($edit_game["sn"], $home_score, $away_score);
		}

		//-> 앞/뒤
		$edit_game = $game_model->getRow('*', $game_model->db_qz."child", "league_sn=4447 and gameDate='".$now_date."' and home_team='".$ladder_data["gamenum"]."회차 [앞]'");
		if(count((array)$edit_game)!=0 && $edit_game['kubun'] != 1 && $edit_game['hume_score'] =='' && $edit_game['away_score'] =='') {
			if(strstr($ladder_data["gameresult3"], "앞")) {
				$home_score = '1';
				$away_score = '0';
			} else {
				$home_score = '0';
				$away_score = '1';
			}
			$process_model->resultGameProcessing($edit_game["sn"], $home_score, $away_score);
		}

		$mis_game_list = $ladder_model->misGameList2(date("Y-m-d"));
		echo json_encode($mis_game_list);
	}
	
	function parseLadder2Action()
	{
		$ladder_data = array();
		$url = "http://scoregame.co.kr/coin/analysis-day.php";
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, true );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false );
		$data = curl_exec($ch);
		curl_close($ch);
		
		$datelist= explode("class=\"new",$data);
		$datelist2 = explode("</tr>",$datelist[1]);
		
		
		
		
		
			
			$numtemp  = explode("-</span>",$datelist2[0]);
			$numtemp2 = explode("<span>회",$numtemp[1]);
			$ladder_data["gamenum"]  = $numtemp2[0];
			
			$game1temp  = explode("<strong></td>",$numtemp2[1]);
			
			
			$game1temp1 = str_replace("</span></td>","",$game1temp[0]);
			$game1temp1 = str_replace("<td><strong class=\"red\">","",$game1temp1);
			$ladder_data["gameresult1"]  = Trim($game1temp1);
			
			if(strpos($datelist2[0], "icon-type1.png")){

				$ladder_data["gameresult2"] = "금";
			}else{
				$ladder_data["gameresult2"] = "은";
			}


			if(strpos($datelist2[0], "icon-result1.png")){

				$ladder_data["gameresult3"] = "앞";
			}else{
				$ladder_data["gameresult3"] = "뒤";
			}

			return $ladder_data;
	
	}
}
?>
