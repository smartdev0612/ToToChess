<?
/*
* Index Controller
*/
class LadderBallController extends WebServiceController 
{
	//▶ 파워볼 게임 자동 처리
	function indexAction() {
		$this->popupDefine('ladder');
		
		if(!$this->auth->isLogin()) {
			$this->loginAction();
			exit;
		}
		
		$this->view->define("content","content/ladder/auto_ball.html");
		$this->display();
	}
	
	function ladderBallListenerAction() {
		
		if(!$this->auth->isLogin()) {
			$this->loginAction();
			exit;
		}

		$game_model = $this->getModel("GameModel");
		$league_model = $this->getModel("LeagueModel");
		$process_model = $this->getModel("ProcessModel");
		$ladder_model = $this->getModel("LadderModel");
		
		//-> 결과는 스케쥴러에서 입력이 되고 아직 정산이 안된 파워볼을 모두 가져와서 정산처리.
		for ( $i = 0 ; $i < 5 ; $i++ ) {
			$selectGame = $game_model->getRow('*', "tb_child", "league_sn = 4000 and kubun = 0 and home_score IS NOT NULL and win_team IS NOT NULL");
			if ( is_array($selectGame) ) {
				$process_model->resultGameProcess($selectGame["sn"], $selectGame["home_score"], $selectGame["away_score"]);
			}

			$selectGame = $game_model->getRow('*', "tb_child", "league_sn = 4100 and kubun = 0 and home_score IS NOT NULL and win_team IS NOT NULL");
			if ( is_array($selectGame) ) {
				$process_model->resultGameProcess($selectGame["sn"], $selectGame["home_score"], $selectGame["away_score"]);
			}

			$selectGame = $game_model->getRow('*', "tb_child", "league_sn = 4200 and kubun = 0 and home_score IS NOT NULL and win_team IS NOT NULL");
			if ( is_array($selectGame) ) {
				$process_model->resultGameProcess($selectGame["sn"], $selectGame["home_score"], $selectGame["away_score"]);
			}

			if ( $selectGame["sn"] > 0 ) {
				$tempVal = explode("회차",$selectGame["home_team"]);
				$resultVal[] = array('gameNo'=>$tempVal[0]);
			}
		}

		echo json_encode($resultVal);
	}
}
?>
