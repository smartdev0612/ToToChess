<?
/*
* Index Controller
*/
class LadderRaceController extends WebServiceController 
{
	//▶ 달팽이 게임 자동 처리
	function indexAction() {
		$this->popupDefine('ladder');
		
		if(!$this->auth->isLogin()) {
			$this->loginAction();
			exit;
		}
		
		$this->view->define("content","content/ladder/auto_race.html");
		$this->display();
	}
	
	function ladderRaceListenerAction() {
		
		if(!$this->auth->isLogin()) {
			$this->loginAction();
			exit;
		}

		$game_model = $this->getModel("GameModel");
		$league_model = $this->getModel("LeagueModel");
		$process_model = $this->getModel("ProcessModel");
		$ladder_model = $this->getModel("LadderModel");
		
		//오늘날짜
		$now_date = date("Y-m-d");
		$now_time = date("H:i");
		
		$now_hour	= date("H");
		$now_min	= date("i");

		//현재회차
		$now_cnt = floor(($now_hour*60+$now_min)/5);

		$is_game_made_288 = $game_model->getRow('*', $game_model->db_qz."child", "league_sn=2000 and gameDate='".$now_date."' and home_team like '288회차 [1등]'");
		//게임생성
		if(!count((array)$is_game_made_288)) {
			for($i=$now_cnt+1; $i <= 288; $i++) {
				$now_hour = floor($i*5/60);
				$now_minute = $i*5-$now_hour*60;
	
				if($now_hour<10)		{$now_hour = "0".$now_hour;}
				if($now_minute<10)	{$now_minute = "0".$now_minute;}
				
				$is_game_made = $game_model->getRow('*', $game_model->db_qz."child", "league_sn=2000 and gameDate='".$now_date."' and home_team like '".$i."회차 [1등]'");
				if(!count((array)$is_game_made)) {
					if ( $i == 288 ) {
						$now_hour = 23;
						$now_minute = 59;
					}
					$game_model->addChild($parentSn,'기타',2000,$i."회차 [1등]",$i."회차 [1등]",$now_date,$now_hour,$now_minute,'','0',1,4,2.9,2.9,2.9);
				}
			}
		}
/*
		$is_game_made_288 = $game_model->getRow('*', $game_model->db_qz."child", "league_sn=2001 and gameDate='".$now_date."' and home_team like '288회차 [2등]'");
		//게임생성
		if(!sizeof($is_game_made_288)) {
			for($i=$now_cnt+1; $i <= 288; $i++) {
				$now_hour = floor($i*5/60);
				$now_minute = $i*5-$now_hour*60;
				
				if($now_hour<10)		{$now_hour = "0".$now_hour;}
				if($now_minute<10)	{$now_minute = "0".$now_minute;}
				
				$is_game_made = $game_model->getRow('*', $game_model->db_qz."child", "league_sn=2001 and gameDate='".$now_date."' and home_team like '".$i."회차 [2등]'");
				if(!sizeof($is_game_made)) {
					if ( $i == 288 ) {
						$now_hour = 23;
						$now_minute = 59;
					}
					$game_model->addChild($parentSn,'기타',2001,$i."회차 [2등]",$i."회차 [2등]",$now_date,$now_hour,$now_minute,'','0',1,4,1.90,1.90,1.90);
				}
			}
		}
*/
		//-> 최근 결과 콜
		$ladder_data = $this->parseRaceResultAction();

		//-> 최근 288회 결과는 다음날 0시에 나오기 때문에 하루를 -1일 경기를 타겟 해준다.
		if ( $ladder_data["th"] == 288 and date("H",time()) == "00" ) {
			$now_date = date("Y-m-d",strtotime($now_date)-3600);
		}

		//-> 1등
		$edit_game = $game_model->getRow('*', $game_model->db_qz."child", "league_sn=2000 and gameDate='".$now_date."' and home_team='".$ladder_data["th"]."회차 [1등]'");
		if(count((array)$edit_game)!=0 && $edit_game['kubun'] != 1 && $edit_game['hume_score'] =='' && $edit_game['away_score'] =='') {
			if( $ladder_data["rank_1"] == 1 ) {
				$home_score = '1';
				$away_score = '0';
			} else if( $ladder_data["rank_1"] == 2 ) {
				$home_score = '1';
				$away_score = '1';
			} else if( $ladder_data["rank_1"] == 3 ) {
				$home_score = '0';
				$away_score = '1';
			}
			$process_model->resultGameProcess($edit_game["sn"], $home_score, $away_score);
		}
/*
		//-> 2등
		$edit_game = $game_model->getRow('*', $game_model->db_qz."child", "league_sn=2001 and gameDate='".$now_date."' and home_team='".$ladder_data["th"]."회차 [2등]'");
		if(sizeof($edit_game)!=0 && $edit_game['kubun'] != 1 && $edit_game['hume_score'] =='' && $edit_game['away_score'] =='') {
			if( $ladder_data["rank_2"] == 1 ) {
				$home_score = '1';
				$away_score = '0';
			} else if( $ladder_data["rank_2"] == 2 ) {
				$home_score = '1';
				$away_score = '1';
			} else if( $ladder_data["rank_2"] == 3 ) {
				$home_score = '0';
				$away_score = '1';
			}
			$process_model->resultGameProcess($edit_game["sn"], $home_score, $away_score);
		}
*/
		$mis_game_list = $ladder_model->misRaceGameList(date("Y-m-d"));
		echo json_encode($mis_game_list);
	}
	
	//-> 최근 달팽이 경기 결과
	function parseRaceResultAction()
	{
		$ladder_data = array();
		$url = "http://named.com/games/racing/pop/race_result.php";
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_UNRESTRICTED_AUTH, true );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false );

		$data = curl_exec($ch);
		$begin_pos = strpos($data, "<ul class=\"result_bd\">");
		if($begin_pos ===false) {
			return -1;
		}
		$end_pos = strpos($data, "</ul>", $begin_pos+1);		
		$data = substr($data, $begin_pos, $end_pos-$begin_pos);

		$begin_pos = strpos($data, "<li>");
		if($begin_pos ===false) {
			return -1;
		}
		$end_pos = strpos($data, "</li>", $begin_pos+1);		
		$data = substr($data, $begin_pos, $end_pos-$begin_pos);

		//-> 회차
		$thTemp = explode("class=\"num\">",$data);
		$thTemp = explode("</span",$thTemp[1]);
		$ladder_data["th"] = $thTemp[0];

		//-> 등수
		$rankTemp = explode("<em class=\"p",$data);
		$ladder_data["rank_1"] = $rankTemp[1][0];
		$ladder_data["rank_2"] = $rankTemp[2][0];
		$ladder_data["rank_3"] = $rankTemp[3][0];

		return $ladder_data;
	}

}
?>
