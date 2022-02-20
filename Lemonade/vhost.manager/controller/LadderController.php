<?
/*
* Index Controller
*/
class LadderController extends WebServiceController 
{
	//▶ 사다리 게임 자동 처리
	function indexAction()
	{
		$this->popupDefine('ladder');
		
		//$this->ladderListenerAction();
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$this->view->define("content","content/ladder/auto.html");
		$this->display();
	}
	
	function ladderListenerAction()
	{
		$this->popupDefine('ladder');

		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
				
		$game_model					= $this->getModel("GameModel");
		$league_model 				= $this->getModel("LeagueModel");
		$process_model				= $this->getModel("ProcessModel");
		$ladder_model				= $this->getModel("LadderModel");
		
		//오늘날짜
		$now_date = date("Y-m-d");
		$now_time = date("H:i");
		
		$now_hour	= date("H");
		$now_min	= date("i");
		
		//현재회차
		$now_cnt = floor(($now_hour*60+$now_min)/5);		
		$is_game_made_288 = $game_model->getRow('*', $game_model->db_qz."child", "league_sn=571 and gameDate='".$now_date."' and home_team like '%288%'");

		//게임생성
		if(!count((array)$is_game_made_288))
		{
			for($i=$now_cnt+1; $i <= 288; $i++)
			{
				$now_hour = floor($i*5/60);
				$now_minute = $i*5-$now_hour*60;
				
				if($now_hour<10)		{$now_hour = "0".$now_hour;}
				if($now_minute<10)	{$now_minute = "0".$now_minute;}
				
				$is_game_made = $game_model->getRow('*', $game_model->db_qz."child", "league_sn=571 and gameDate='".$now_date."' and home_team like '".$i."회차%'");
				if(!count((array)$is_game_made))
				{
					if ( $i == 288 ) {
						$now_hour = 23;
						$now_minute = 59;
					}
					$game_model->addChild($parentSn,'기타',571,$i."회차 [홀]",$i."회차 [짝]",$now_date,$now_hour,$now_minute,'','0',1,3,1.92,1,1.92);
					$game_model->addChild($parentSn,'기타',603,$i."회차 [좌]",$i."회차 [우]",$now_date,$now_hour,$now_minute,'','0',1,3,1.95,1,1.95);
					$game_model->addChild($parentSn,'기타',604,$i."회차 [3줄]",$i."회차 [4줄]",$now_date,$now_hour,$now_minute,'','0',1,3,1.95,1,1.95);
				}
			}
		}

		//-> 최근 결과 콜
		$ladder_data = $this->parseLadder2Action();

		//-> 최근 288회 결과는 다음날 0시에 나오기 때문에 하루를 -1일 경기를 타겟 해준다.
		if ( $ladder_data["th"] == 288 and date("H",time()) == "00" ) {
			$now_date = date("Y-m-d",strtotime($now_date)-3600);
		}

		//-> 홀/짝
		$edit_game = $game_model->getRow('*', $game_model->db_qz."child", "league_sn=571 and gameDate='".$now_date."' and home_team='".$ladder_data["th"]."회차 [홀]'");
		if(count((array)$edit_game)!=0 && $edit_game['kubun'] != 1 && $edit_game['hume_score'] =='' && $edit_game['away_score'] =='') {
			if(strstr($ladder_data["result"], "odd")) {
				$home_score = '1';
				$away_score = '0';
			} else {
				$home_score = '0';
				$away_score = '1';
			}
			$process_model->resultGameProcessing($edit_game["sn"], $home_score, $away_score);
		}

		//-> 좌/우
		$edit_game = $game_model->getRow('*', $game_model->db_qz."child", "league_sn=603 and gameDate='".$now_date."' and home_team='".$ladder_data["th"]."회차 [좌]'");
		if(count((array)$edit_game)!=0 && $edit_game['kubun'] != 1 && $edit_game['hume_score'] =='' && $edit_game['away_score'] =='') {
			if(strstr($ladder_data["start"], "left")) {
				$home_score = '1';
				$away_score = '0';
			} else {
				$home_score = '0';
				$away_score = '1';
			}
			$process_model->resultGameProcessing($edit_game["sn"], $home_score, $away_score);
		}

		//-> 3줄/4줄
		$edit_game = $game_model->getRow('*', $game_model->db_qz."child", "league_sn=604 and gameDate='".$now_date."' and home_team='".$ladder_data["th"]."회차 [3줄]'");
		if(count((array)$edit_game)!=0 && $edit_game['kubun'] != 1 && $edit_game['hume_score'] =='' && $edit_game['away_score'] =='') {
			if(strstr($ladder_data["line"], "3")) {
				$home_score = '1';
				$away_score = '0';
			} else {
				$home_score = '0';
				$away_score = '1';
			}
			$process_model->resultGameProcessing($edit_game["sn"], $home_score, $away_score);
		}

		$mis_game_list = $ladder_model->misGameList(date("Y-m-d"));
		echo json_encode($mis_game_list);
	}
	
	function parseLadder2Action()
	{
		$ladder_data = array();
		$url = "http://named.com/game/ladder/v2_index.php";

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

		$begin_pos = strpos($data, "<div class=\"game_result\">");
		if($begin_pos ===false) {
			return -1;
		}
		$end_pos = strpos($data, "</div>", $begin_pos+1);
		
		$div_html = substr($data, $begin_pos, $end_pos-$begin_pos);
		
		//대기게임
		$pos = $begin_pos+1;
		$li_begin = strpos($data, "<li", $pos+1);
		$li_end = strpos($data, "</li", $pos+1);
		$li_html = substr($data, $li_begin, $li_end-$li_begin);
		
		//최근게임
		$pos = $li_end+1;
		$li_begin = strpos($data, "<li", $pos+1);
		$li_end = strpos($data, "</li", $pos+1);
		$li_html = substr($data, $li_begin, $li_end-$li_begin);
		$pos = $li_begin+1;
		
		//class로 결과 판단
		$class_begin = strpos($li_html, "prev")+5;
		$class_end = strpos($li_html, "\"", $class_begin+1);
		$class = substr($li_html, $class_begin, $class_end-$class_begin);
		
		//$ladder_data["th"] = $th[0][1];
		
		$splits = explode(" ", $class);
		
		if($splits[0]=="row_even")
		{
			$ladder_data["result"] = "even";
			
			if($splits[1]=="row_even_first")
			{
				$ladder_data["line"] = "3";
				$ladder_data["start"] = "left";
			}
			else if($splits[1]=="row_even_second")
			{
				$ladder_data["line"] = "4";
				$ladder_data["start"] = "right";
			}
		}
		else if($splits[0]=="row_odd")
		{
			$ladder_data["result"] = "odd";
			if($splits[1]=="row_odd_first")
			{
				$ladder_data["line"] = "4";
				$ladder_data["start"] = "left";
			}
			else if($splits[1]=="row_odd_second")
			{
				$ladder_data["line"] = "3";
				$ladder_data["start"] = "right";
			}
		}
		
		//회차 구하기
		$th_begin = strpos($li_html, "-")+1;
		$th_end = strpos($li_html, "<", $th_begin);
		$th = substr($li_html, $th_begin, $th_end-$th_begin);
		
		$ladder_data["th"] = $th;
		return $ladder_data;
	}
}
?>
