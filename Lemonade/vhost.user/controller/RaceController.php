<?
/*
* Index Controller
*/
class RaceController extends WebServiceController 
{

	var $commentListNum = 10;
	
	function layoutDefine($type='')
	{
		//-> 중복로그인 체크 전체 페이지 적용
		if ( $this->auth->getSn() > 0 ) {
			$mModel = $this->getModel("MemberModel");
			$dbSessionId = $mModel->getMemberField($this->auth->getSn(), 'sessionid');
			if($dbSessionId!=session_id()) {
				if($this->auth->isLogin()) {
					session_destroy();
				}
				throw new Lemon_ScriptException("중복접속 되었습니다. 다시 로그인 해 주세요.", "", "go", "/");
				exit;
			}
		}

		$live_game_model = $this->getModel("LiveGameModel");		
		$gameList = $live_game_model->getLiveGameList($where);

		$this->view->assign("game_list",  $gameList);
		$this->view->define("index","layout/layout.sports.html");
	}
	
	public function indexAction($id='') {

	}

	public function betting_listAction()
	{
		$this->commonDefine('type');
		
		if($this->isMobile() == "pc") {
			$this->view->define(array("content"=>"content/betting_list.html"));
		} else {
			$this->view->define(array("content"=>"content/betting_list_m.html"));
		}
		//$specialCode = empty($this->req->request("special_code")) ? 0 : $this->req->request("special_code");
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}

		$specialCode = trim($this->req->request("special_code"));
		$game = trim($this->req->request("game"));
		$beginDate = trim($this->req->request("begin_date"));
		$endDate = trim($this->req->request("end_date"));
		$sortType = $this->req->request("sort_type");
		$type = empty($this->req->request("type")) ? 1 : $this->req->request("type");
		
		if ( !$beginDate ) $beginDate = date("Y-m-d",time());
		if ( !$endDate ) $endDate = date("Y-m-d",time());
	
		$mModel = Lemon_Instance::getObject("MemberModel",true);
		$gameListModel = Lemon_Instance::getObject("GameListModel",true);
		$cModel = Lemon_Instance::getObject("CartModel",true);
		$sn = $this->auth->getSn();

		// 유저의 배팅취소개수 초기화
		$mModel->clearBetCancelCnt($sn);
/*
		$queryBeginDate = "";
		$queryEndDate = "";
		if ( $beginDate != "" && $endDate != "" ) {
			$queryBeginDate = $beginDate." 00:00:00";
			$queryEndDate = $endDate." 23:59:59";
		}
*/
		if ( !$specialCode ) $specialCode = "all";
		//if($s_type != 0) $specialCode = $s_type;
		//if ( $game == "sadari" ) $specialCode = 3;
		//else if ( $game == "race" ) $specialCode = 4;
		//else if ( $game == "powerball" ) $specialCode = 5;

		switch( $sortType ) {
			case 0: 	$total= $gameListModel->getBettingListTotal($sn, -1,  0, $queryBeginDate, $queryEndDate, $specialCode); $state = -1; 	break; // 전체 배팅내역
			case 1: 	$total= $gameListModel->getBettingListTotal($sn,  0,  0, $queryBeginDate, $queryEndDate, $specialCode); $state = 0;		break; // 게임진행중 배팅내역
			case 2: 	$total= $gameListModel->getBettingListTotal($sn,  1,  0, $queryBeginDate, $queryEndDate, $specialCode); $state = 1; 	break; // 게임완료 배팅내역	
			case 10:	$total= $gameListModel->getBettingListTotal($sn,  10, 0, $queryBeginDate, $queryEndDate, $specialCode); $state = 10; 	break; // 당첨 배팅내역
			case 11:	$total= $gameListModel->getBettingListTotal($sn,  11, 0, $queryBeginDate, $queryEndDate, $specialCode); $state = 11; 	break; // 낙첨 배팅내역
		}

		$page_act = "game=".$game."&begin_date=".$beginDate."&end_date=".$endDate."&sort_type=".$sortType;

		$pageMaker = $this->displayPage($total, 20, $page_act);

		//$list = $gameListModel->getBettingList($sn, $pageMaker->first, $pageMaker->listNum, $chk_folder, $state, $queryBeginDate, $queryEndDate, $specialCode, 1);
		$list = $gameListModel->getUserBettingList($sn, $type, 0, 20);
		$listTotal = $gameListModel->getUserBettingListTotal($sn, $type);
		
		$this->view->assign("game", $game);
		$this->view->assign("begin_date", $beginDate);
		$this->view->assign("end_date", $endDate);
		$this->view->assign("sort_type", $sortType);
		$this->view->assign("specialCode", $specialCode);
		$this->view->assign("type", $type);
		$this->view->assign("list", $list);
		$this->view->assign("listTotal", $listTotal);
	
		$this->display();
	}

	public function getBettingListAction() {
		$type = empty($this->req->request("type")) ? 0 : $this->req->request("type");
		$pc = empty($this->req->request("pc")) ? 0 : $this->req->request("pc");
		$page_index = empty($this->req->request("page_index")) ? 0 : $this->req->request("page_index");
		$sn = $this->auth->getSn();
		$gameListModel = Lemon_Instance::getObject("GameListModel",true);
		$list = $gameListModel->getUserBettingList($sn, $type, $page_index, 20);
		$listTotal = $gameListModel->getUserBettingListTotal($sn, $type);

		$table = "";
		if($pc > 0) {
			if(count((array)$list) > 0) {
				foreach($list as $TPL_K1 => $TPL_V1) {
					$table .= '<table class="st10">
								<colgroup>
									<col style="width: 12%;">
									<col style="width: 22%;">
									<col style="width: 19%;">
									<col style="width: 11%;">
									<col style="width: 17%;">
									<col style="width: 6%;">
									<col style="width: 6%;">
									<col>
								</colgroup>
								<thead>
									<tr>
										<th scope="col">경기시간</th>
										<th scope="col">리그명</th>
										<th scope="col">홈팀 VS 원정팀</th>
										<th scope="col">타입</th>
										<th scope="col">베팅팀</th>
										<th scope="col">스코어</th>
										<th scope="col">배당</th>
										<th class="last" scope="col">상태</th>
									</tr>
								</thead>
								<tbody>';
					$enableBettingCancel = 0;  		
					if(count((array)$TPL_V1["item"]) > 0) {
						$battingJT = "0";
						foreach ( $TPL_V1["item"] as $TPL_V2 ) {
							if ( $TPL_V2["home_rate"] < 1.01 and $TPL_V2["draw_rate"] < 1.1 and $TPL_V2["away_rate"] < 1.1  ) {
								$TPL_V2["home_rate"] = $TPL_V2["game_home_rate"];
								$TPL_V2["draw_rate"] = $TPL_V2["game_draw_rate"];
								$TPL_V2["away_rate"] = $TPL_V2["game_away_rate"];
								$battingJT = "1";
							} else {
								$battingJT = "0";
							}
							$table .= '<tr data-game_id="1731940" data-fid="6967104" data-mid="1" data-gb_id="25322682" data-betid="20609690316967104">';
							$table .= '<td>' . $TPL_V2["gameDate"] . ' ' . $TPL_V2["gameHour"] . ' : ' . $TPL_V2["gameTime"] . '</td>';
							$table .= '<td class="txt_left st_padl5">';
							$table .= '<img src="/BET38/_icon/sport/S' . $TPL_V2["sport_id"] . '.png" width="23">&nbsp;';
							if($TPL_V2["league_image"] == "")
								$table .= '<img src="/BET38/_icon/etc.svg" width="23">&nbsp;';
							else 
								$table .= '<img src="' . $TPL_V2["league_image"] . '" width="23" >&nbsp;&nbsp;';
							$table .= '<span>' . $TPL_V2["league_name"] . '</span>'; 
							$table .= '</td>';
							$table .= '<td class="txt_left st_padl5">';
							$table .= '<div>';
							$table .= '<span class="txt_co6">홈팀</span> : ' . $TPL_V2["home_team"];
							$table .= '</div>';
							$table .= '<div class="padding-top-5"><span class="txt_co71">원팀</span> : ' . $TPL_V2["away_team"]  . '</td></div>';
							$pieces = explode("|", $TPL_V2["mname_ko"]);
							switch($TPL_V2["sport_id"]) {
								case 6046: // 축구
									$table .= '<td>' . $pieces[0] . '</td>';
									break;
								case 48242: // 농구
									$table .= '<td>' . $pieces[1] . '</td>';
									break;
								case 154914: // 야구
									$table .= '<td>' . $pieces[2] . '</td>';
									break;
								case 154830: // 배구
									$table .= '<td>' . $pieces[3] . '</td>';
									break;
								case 35232: // 아이스 하키
									$table .= '<td>' . $pieces[4] . '</td>';
									break;
								case 687890: // E스포츠
									$table .= '<td>' . $pieces[5] . '</td>';
									break;
								default:
									$table .= '<td>' . $pieces[0] . '</td>';
									break;
							}
							$table .= '<td class="txt_ac st_padl5">';
							switch($TPL_V2["mfamily"]) {
								case "1":
								case "2":
									if($TPL_V2["select_no"] == "1")
										$table .= '<span class="txt_co6">(홈)</span>  ' . $TPL_V2["home_team"];
									else if($TPL_V2["select_no"] == "2") 
										$table .= '<span class="txt_co6">(원)</span>  ' . $TPL_V2["away_team"];                       
									else if($TPL_V2["select_no"] == "3")                        
										$table .= '(무) 무승부'; 
									break;
								case "7":
									if($TPL_V2["select_no"] == "1") {
										$table .= '언더 <span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
									} else if($TPL_V2["select_no"] == "2") {
										$table .= '오버 <span class="txt_co6">(' . $TPL_V2["away_line"] . ')</span>'; 
									}
									break;
								case "8":
								case "9":
									if($TPL_V2["select_no"] == "1") {
										$home_line = explode(" ", $TPL_V2["home_line"]);
										$table .= $TPL_V2["home_team"] . '<span class="txt_co6">(' . $home_line[0] . ')</span>';
									} else if($TPL_V2["select_no"] == "2") {
										$away_line = explode(" ", $TPL_V2["away_line"]);
										$table .= $TPL_V2["away_team"] . '<span class="txt_co6">(' . $away_line[0] . ')</span>'; 
									}
									break;
								case "10":
									if($TPL_V2["select_no"] == "1")
										$table .= '홀수';
									else if($TPL_V2["select_no"] == "2") 
										$table .= '짝수'; 
									break;
								case "11":
									$table .= $TPL_V2["home_name"];
									break;
								case "12":
									if($TPL_V2["select_no"] == "1")
										$table .= '승무';
									else if($TPL_V2["select_no"] == "2") 
										$table .= '무패';                       
									else if($TPL_V2["select_no"] == "3")                        
										$table .= '승패'; 
									break;
								case "47":
									if($TPL_V2["home_name"] == "1 And Under")
										$table .= '홈승 & 언더' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
									else if($TPL_V2["home_name"] == "1 And Over") 
										$table .= '홈승 & 오버' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';                       
									else if($TPL_V2["home_name"] == "2 And Under")                        
										$table .= '원정승 & 언더' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>'; 
									else if($TPL_V2["home_name"] == "2 And Over")
										$table .= '원정승 & 오버' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
									else if($TPL_V2["home_name"] == "X And Under")
										$table .= '무 & 언더' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
									else if($TPL_V2["home_name"] == "X And Over")
										$table .= '무 & 오버' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
									break;
							}
										
							$table .= '</td>';
							if($type == 2) 
								$table .= '<td><span class="txt_co6">' . $TPL_V2["score"] . '</span></td>';
							else 
								$table .= '<td><span class="txt_co6">' . $TPL_V2["home_score"] . ':' . $TPL_V2["away_score"] . '</span></td>';
							$table .= '<td>' . $TPL_V2["select_rate"] . ' 배</td>';
							if($battingJT)
								$table .= '<td rowspan="1"><span class="bt_none5 bt_45_none">적특</span></td>';
							else if($TPL_V2["result"] == "1")
								$table .= '<td rowspan="1"><span class="bt_none6 bt_45_none">당첨</span></td>';
							else if($TPL_V2["result"] == "2")
								$table .= '<td rowspan="1"><span class="bt_none3 bt_45_none">낙첨</span></td>';
							else if($TPL_V2["result"] == "4")
								$table .= '<td rowspan="1"><span class="bt_none5 bt_45_none" style="color:#e44e4e !important;">취소</span></td>';
							else 
								$table .= '<td rowspan="1"><span class="bt_none1 bt_45_none">진행</span></td>';
							$table .= '</tr>';
							$table .= '<tr id="Fid2996007" class="st_hide_list"></tr>'; 
							
							if($TPL_V2["result"] > 0) 
								$enableBettingCancel = 1;
						} 
					}
					
					$table .= '</tbody>
							</table>
							<div class="st_b_result" data-oid="1605133">';
					$table .= '베팅접수시간 : <span class="txt_co3 st_padr10">' . $TPL_V1["bet_date"] . '</span>';
					$table .= '예상당첨금액 : <span class="txt_co3 st_padr10">(베팅 ' . $TPL_V1["betting_money"] . ' x 배당 ' . $TPL_V1["result_rate"] .') = ' . $TPL_V1["win_money"] . '</span>';
					$table .= '결과당첨금액 : <span class="txt_co3 st_padr10">' . $TPL_V1["result_money"] . '</span>';
					if($TPL_V1["result"] == "1") {
						$table .= "<span class='bt_100 bt_gray f_right txt_size st_mart5 st_marl5 pointer' onclick=hide_bet('" . $TPL_K1 . "')>베팅내역삭제</span>";
						$table .= '<span class="bt_45_none bt_none6 f_right st_mart5">당첨</span>';
					} else if($TPL_V1["result"] == "2") {
						$table .= "<span class='bt_100 bt_gray f_right txt_size st_mart5 st_marl5 pointer' onclick=hide_bet('" . $TPL_K1 . "')>베팅내역삭제</span>";
						$table .= '<span class="bt_45_none bt_none3 f_right st_mart5">낙첨</span>';
					} else if($TPL_V1["result"] == "4") {
						$table .= "<span class='bt_100 bt_gray f_right txt_size st_mart5 st_marl5 pointer' onclick=hide_bet('" . $TPL_K1 . "')>베팅내역삭제</span>";
						$table .= '<span class="bt_45_none bt_none5 f_right st_mart5" style="color:#e44e4e !important;">취소</span>';
					} else {
						if($type < 2 && $enableBettingCancel == 0)
							$table .= "<span class='bt_100 bt_gray f_right txt_size st_mart5 st_marl5 pointer' onclick=cancel_bet('" . $TPL_K1 . "')>베팅취소</span>";
						$table .= '<span class="bt_45_none bt_none1 f_right st_mart5">진행</span>';
					}
					$table .= '</td></div>';
				}
			}
		} else {
			foreach($list as $TPL_K1 => $TPL_V1) { 
				$table .= '<table class="st10">
								<colgroup>
									<col style="width:30%">
									<col style="width:30%">
									<col style="width:30%">
									<col style="width:10%">
								</colgroup>
								<thead>
									<tr>
										<th scope="col">리그/시간</th>
										<th scope="col">팀명/베팅항목</th>
										<th scope="col">타입/상태</th>
										<th scope="col" class="last">결과</th>
									</tr>
								</thead>
								<tbody>';

				$enableBettingCancel = 0; 
				if(count((array)$TPL_V1["item"]) > 0) {
					$battingJT = "0";
					foreach ( $TPL_V1["item"] as $TPL_V2 ) {
						if ( $TPL_V2["home_rate"] < 1.01 and $TPL_V2["draw_rate"] < 1.1 and $TPL_V2["away_rate"] < 1.1  ) {
							$TPL_V2["home_rate"] = $TPL_V2["game_home_rate"];
							$TPL_V2["draw_rate"] = $TPL_V2["game_draw_rate"];
							$TPL_V2["away_rate"] = $TPL_V2["game_away_rate"];
							$battingJT = "1";
						} else {
							$battingJT = "0";
						}
						$table .= '<tr><td>';
						$table .= '<img src="/BET38/_icon/sport/S' . $TPL_V2["sport_id"] . '.png" width="20">&nbsp;';
						if($TPL_V2["league_image"] == "")
							$table .= '<img src="/BET38/_icon/etc.svg" width="20">&nbsp;';
						else 
							$table .= '<img src="' . $TPL_V2["league_image"] . '" width="20">&nbsp;';
						$table .= $TPL_V2["league_name"];
						$table .= '</td>';
						$table .= '<td class="_left">';
						$table .= '<span class="txt_co6">홈팀</span> : ' . $TPL_V2["home_team"] . '<br>';
						$table .= '<span class="txt_co71">원팀</span> : ' . $TPL_V2["away_team"] . '</td>';			
						$pieces = explode("|", $TPL_V2["mname_ko"]);
						switch($TPL_V2["sport_id"]) {
							case 6046: // 축구
								$table .= '<td>' . $pieces[0] . '</td>';
								break;
							case 48242: // 농구
								$table .= '<td>' . $pieces[1] . '</td>';
								break;
							case 154914: // 야구
								$table .= '<td>' . $pieces[2] . '</td>';
								break;
							case 154830: // 배구
								$table .= '<td>' . $pieces[3] . '</td>';
								break;
							case 35232: // 아이스 하키
								$table .= '<td>' . $pieces[4] . '</td>';
								break;
							case 687890: // E스포츠
								$table .= '<td>' . $pieces[5] . '</td>';
								break;
							default:
								$table .= '<td>' . $pieces[0] . '</td>';
								break;
						}
						$table .= '<td class="td_de" rowspan="2">';
						if($battingJT)
							$table .= '<span class="bt_none5 bt_45_none txt_co23">적특</span>';
						else if($TPL_V2["result"] == "1")
							$table .= '<span class="bt_none6 bt_45_none txt_co23">당첨</span>';
						else if($TPL_V2["result"] == "2")
							$table .= '<span class="bt_none3 bt_45_none txt_co23">낙첨</span>';
						else if($TPL_V2["result"] == "4")
							$table .= '<span class="bt_none5 bt_45_none txt_co23" style="color:#e44e4e !important;">취소</span>';
						else 
							$table .= '<span class="bt_none1 bt_45_none txt_co23">진행</span>';
						$table .= '</td></tr>';
						
						$table .= '<tr>';
						$table .= '<td>' . $TPL_V2["gameDate"] . ' ' . $TPL_V2["gameHour"] . ' : ' . $TPL_V2["gameTime"] . '</td>';
						$table .= '<td class="_left">';		 
						switch($TPL_V2["mfamily"]) {
							case "1":
							case "2":
								if($TPL_V2["select_no"] == "1")
									$table .= '<span class="txt_co6">(홈)</span>  ' . $TPL_V2["home_team"];
								else if($TPL_V2["select_no"] == "2") 
									$table .= '<span class="txt_co6">(원)</span>  ' . $TPL_V2["away_team"];                       
								else if($TPL_V2["select_no"] == "3")                        
									$table .= '(무) 무승부'; 
								break;
							case "7":
								if($TPL_V2["select_no"] == "1") {
									$table .= '언더 <span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
								} else if($TPL_V2["select_no"] == "2") {
									$table .= '오버 <span class="txt_co6">(' . $TPL_V2["away_line"] . ')</span>'; 
								}
								break;
							case "8":
							case "9":
								if($TPL_V2["select_no"] == "1") {
									$home_line = explode(" ", $TPL_V2["home_line"]);
									$table .= $TPL_V2["home_team"] . '<span class="txt_co6">(' . $home_line[0] . ')</span>';
								} else if($TPL_V2["select_no"] == "2") {
									$away_line = explode(" ", $TPL_V2["away_line"]);
									$table .= $TPL_V2["away_team"] . '<span class="txt_co6">(' . $away_line[0] . ')</span>'; 
								}
								break;
							case "10":
								if($TPL_V2["select_no"] == "1")
									$table .= '홀수';
								else if($TPL_V2["select_no"] == "2") 
									$table .= '짝수'; 
								break;
							case "11":
								$table .= $TPL_V2["home_name"];
								break;
							case "12":
								if($TPL_V2["select_no"] == "1")
									$table .= '승무';
								else if($TPL_V2["select_no"] == "2") 
									$table .= '무패';                       
								else if($TPL_V2["select_no"] == "3")                        
									$table .= '승패'; 
								break;
							case "47":
								if($TPL_V2["home_name"] == "1 And Under")
									$table .= '홈승 & 언더' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
								else if($TPL_V2["home_name"] == "1 And Over") 
									$table .= '홈승 & 오버' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';                       
								else if($TPL_V2["home_name"] == "2 And Under")                        
									$table .= '원정승 & 언더' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>'; 
								else if($TPL_V2["home_name"] == "2 And Over")
									$table .= '원정승 & 오버' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
								else if($TPL_V2["home_name"] == "X And Under")
									$table .= '무 & 언더' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
								else if($TPL_V2["home_name"] == "X And Over")
									$table .= '무 & 오버' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
								break;
						}
						$table .= '</td>';
						if($type == 2) 
							$table .= '<td><span class="txt_co6">' . $TPL_V2["score"] . '</span></td>';
						else 
							$table .= '<td><span class="txt_co6">' . $TPL_V2["home_score"] . ':' . $TPL_V2["away_score"] . '</span></td>';
						$table .= '</tr>';
						$table .= '<tr id="Fid3628815" class="st_hide_list"></tr>';

						if($TPL_V2["result"] > 0) 
							$enableBettingCancel = 1;
					}
				}
				$table .= '</tbody>
						</table>
						<div class="betting_cart_btn4 clearfix"><ul>';
				$table .= '<li class="betting_cart_40 betting_cart_bgno">베팅시간 : <span class="txt_co6">' . substr($TPL_V1["bet_date"], 5) . '</span></li>';
				$table .= '<li class="betting_cart_40 betting_cart_bgno">베팅금 : <span class="txt_co6 st_marr15">' . $TPL_V1["betting_money"] . ' 원</span></li>';
				$table .= '<li class="betting_cart_40 betting_cart_bgno">배당률 : <span class="txt_co6">' . $TPL_V1["result_rate"] .'</span></li>';
				$table .= '<li class="betting_cart_40 betting_cart_bgno">예상당첨금 : <span class="txt_co3  st_marr15">' . $TPL_V1["win_money"] . ' 원</span></li>';
				$table .= '<li class="betting_cart_40 betting_cart_bgno">당첨금 : <span class="txt_co3">' . $TPL_V1["result_money"] . ' 원</span></li>';
				$table .= '<li class="betting_cart_40 betting_cart_bgno">상태 : ';

				if($TPL_V1["result"] == "1")
					$table .= '<span class="st_marl5 bt_none6 bt_45_none txt_none3">당첨</span>';
				else if($TPL_V1["result"] == "2")
					$table .= '<span class="st_marl5 bt_none3 bt_45_none txt_none3">낙첨</span>';
				else if($TPL_V1["result"] == "4")
					$table .= '<span class="st_marl5 bt_none5 bt_45_none txt_none3" style="color:#e44e4e !important;">취소</span>';
				else
					$table .= '<span class="st_marl5 bt_none1 bt_45_none txt_none3">진행</span>';
				
				$table .= '</li>';
				$table .= '<li class="betting_cart_20 betting_cart_bgno">';
				if($TPL_V1["result"] > 0)
					$table .= "<span class='st_marl5 bt_none5 bt_45_none txt_none3' onclick=hide_bet('" . $TPL_K1 . "')>내역삭제</span>";
				else {
					if($type < 2 && $enableBettingCancel == 0)
						$table .= "<span class='st_marl5 bt_none5 bt_45_none txt_none3' onclick=cancel_bet('" . $TPL_K1 . "')>배팅취소</span>";
				}
				$table .= '</li></ul>
						</div>';
			}
		}
		echo $table;
	}
	
	public function betting_list_sadariAction()
	{
		$this->commonDefine('betlist');
		$this->view->define(array("content"=>"content/betting_list_sadari.html"));
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}

		$beginDate 	= Trim($this->req->request("begin_date"));
		$endDate 		= Trim($this->req->request("end_date"));
		$sortType 	= $this->req->request("sort_type");
	
		$mModel = Lemon_Instance::getObject("MemberModel",true);
		$gameListModel = Lemon_Instance::getObject("GameListModel",true);
		$cModel = Lemon_Instance::getObject("CartModel",true);
		$sn = $this->auth->getSn();

		$queryBeginDate="";
		$queryEndDate="";
		if($beginDate!="" && $endDate!="")
		{
			$queryBeginDate = $beginDate." 00:00:00";
			$queryEndDate		= $endDate." 23:59:59";
		}
		switch($sortType)
		{
			case 0: 	$total= $gameListModel->getBettingListTotal($sn, -1,  0, $queryBeginDate, $queryEndDate); 	$state = -1; 	break; // 전체 배팅내역
			case 1: 	$total= $gameListModel->getBettingListTotal($sn,  0,  0, $queryBeginDate, $queryEndDate); 		$state = 0;		break; // 게임진행중 배팅내역
			case 2: 	$total= $gameListModel->getBettingListTotal($sn,  1,  0, $queryBeginDate, $queryEndDate); 		$state = 1; 	break; // 게임완료 배팅내역	
			case 10:	$total= $gameListModel->getBettingListTotal($sn,  10, 0, $queryBeginDate, $queryEndDate); 	$state = 10; 	break; // 당첨 배팅내역
			case 11:	$total= $gameListModel->getBettingListTotal($sn,  11, 0, $queryBeginDate, $queryEndDate); 	$state = 11; 	break; // 당첨 배팅내역
		}
		
		$page_act = "begin_date=".$beginDate."&end_date=".$endDate."&sort_type=".$sortType;


		$pageMaker = $this->displayPage($total, 10, $page_act);
		$list = $gameListModel->getBettingList($sn, $pageMaker->first, $pageMaker->listNum, $chk_folder, $state, $queryBeginDate, $queryEndDate, 4);

		$this->view->assign("begin_date", $beginDate);
		$this->view->assign("end_date", $endDate);
		$this->view->assign("sort_type", $sortType);
		$this->view->assign("list", $list);
	
		$this->display();
	}

	public function game_resultAction()
	{
		$this->commonDefine('type');
		$this->view->define(array("content"=>"content/game_result.html"));

		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$beginDate 	= Trim($this->request("begin_date"));
		$endDate 		= Trim($this->request("end_date"));
		$viewType 	= $this->request('view_type');
		$category 		= $this->request('sel_kind');
		$leagueSn			= $this->request('league_sn');
		$keyword			= $this->request('keyword');
		$field				= $this->request('field');		

		if($field=="")				$field="team";
		
		if ($beginDate!="") {$sBeginDate = $beginDate;}
		if ($endDate!="") 	{$sEndDate 	 = $endDate;}	

		$gameListModel 	= Lemon_Instance::getObject("GameListModel",true);
		$leagueModel 		= Lemon_Instance::getObject("LeagueModel",true);
		$boardModel 		= Lemon_Instance::getObject("BoardModel",true);

		// keyword where - begin
		$where=" and (a.kubun=1) ";
		if($keyword!="")
		{
			if($field=="team")
				$where.= " and (a.home_team like '%".$keyword."%' or a.away_team like'%".$keyword."%')";
		}

		if ( !$viewType or $viewType == "winlose") $where.= " and a.special = 0 and type = 1";
		else if ( $viewType == "handi") $where.= " and a.special = 0 and ( a.type = 2 or a.type = 4 )";
		else if ( $viewType == "special") $where.= " and a.special = 1";
		else if ( $viewType == "real") $where.= " and a.special = 2";
		else if ( $viewType == "live") $where.= " and a.special = 50";
		else if ( $viewType == "dari") $where.= " and a.special = 6";
		else if ( $viewType == "sadari") $where.= " and a.special = 3";
		else if ( $viewType == "race") $where.= " and a.special = 4";
		else if ( $viewType == "power") $where.= " and a.special = 5";
		else if ( $viewType == "nine") $where.= " and a.special = 21";
        else if ( $viewType == "vfootball") $where.= " and a.special = 22";
        else if ( $viewType == "kenosadari") $where.= " and a.special = 24";
        else if ( $viewType == "powersadari") $where.= " and a.special = 25";
        else if ( $viewType == "lowhi") $where.= " and a.special = 28";
        else if ( $viewType == "aladin") $where.= " and a.special = 29";
        else if ( $viewType == "mgmoddeven") $where.= " and a.special = 26";
        else if ( $viewType == "mgmbacara") $where.= " and a.special = 27";
        else if ( $viewType == "2dari") $where.= " and a.special = 30";
        else if ( $viewType == "3dari") $where.= " and a.special = 31";
        else if ( $viewType == "choice") $where.= " and a.special = 32";
        else if ( $viewType == "roulette") $where.= " and a.special = 33";
        else if ( $viewType == "pharaoh") $where.= " and a.special = 34";

		
		if($category!="")
			$where.=" and a.sport_name='".$category."'";
			
		if($leagueSn!="")
			$where.=" and a.league_sn=".$leagueSn;
			
		if($beginDate!="" && $endDate!="")
			$where.=" and (a.gameDate between '".$beginDate." 00:00:00' and '".$endDate."' 23:59:59) ";
		// keyword where - end
			
		$page_act = "begin_date=".$beginDate."&end_date=".$endDate."&sel_kind=".$category."&view_type=".$viewType."&mode=".$searchMode."&keyword=".$keyword."&field=".$field."&league_sn=".$leagueSn;
		$total			= $gameListModel->getResultGameListTotal($where);
		$pageMaker 	= $this->displayPage($total, 30, $page_act);
		$list 			= $gameListModel->getResultGameList($where, $pageMaker->first, $pageMaker->listNum);

		$categoryList = $leagueModel->getCategoryMenuList();
		
		$where="";
		if($category!="")
			$where = " kind='".$category."'";
		$leagueList = $leagueModel->getListAll($where);
		
		//추천 게시목록
		$topList = $boardModel->getTopList();

        $title = "";
		if ( $viewType == "winlose" ) {
            $title = "RESULT<span class=\"board_mini_title\">승무패</span>";
		} else if($viewType == "handi"){
            $title = "RESULT<span class=\"board_mini_title\">핸디캡</span>";
		} else if($viewType == "special"){
            $title = "RESULT<span class=\"board_mini_title\">스페셜</span>";
        } else if($viewType == "real"){
            $title = "RESULT<span class=\"board_mini_title\">실시간</span>";
        } else if($viewType == "live"){
			$title = "RESULT<span class=\"board_mini_title\">라이브</span>";
		} else if($viewType == "sadari"){
            $title = "RESULT<span class=\"board_mini_title\">사다리</span>";
        } else if($viewType == "dari"){
            $title = "RESULT<span class=\"board_mini_title\">다리다리</span>";
        } else if($viewType == "race"){
            $title = "RESULT<span class=\"board_mini_title\">달팽이</span>";
        } else if($viewType == "power"){
            $title = "RESULT<span class=\"board_mini_title\">파워볼</span>";
        } else if($viewType == "vfootball"){
            $title = "RESULT<span class=\"board_mini_title\">가상축구</span>";
        }

        $this->view->assign("title", $title);
		$this->view->assign('view_type', '8');		
		$this->view->assign("keyword", $keyword);
		$this->view->assign("league_sn", $leagueSn);
		$this->view->assign("field", $field);
		$this->view->assign("sel_kind", $category);
		$this->view->assign("view_type", $viewType);
		$this->view->assign("beginDate", $beginDate);
		$this->view->assign("endDate", $endDate);
		$this->view->assign("list", $list);	
		$this->view->assign('league_list', $leagueList);
		$this->view->assign("category_list",  $categoryList);

		$this->display();
	}
	
	function saveProcessAction()
	{
		$this->req->xssClean();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		
		$list = $this->request('betlist');
		$_SESSION['betlist'] = $list;
		echo $list;
	}
	
	//▶ 배팅취소
	public function cancelProcessAction()
	{
		$this->req->xssClean();
		
		if(!$this->auth->isLogin())
		{
			//$this->loginAction();
			//exit;
		}
		$sn = $this->auth->getSn();
		$bettingNo 		= Trim($this->request('betting_no'));
		$bettingTime 	= Trim($this->request('betting_time'));

		$sn = $this->auth->getSn();
		$bettingNo 		= Trim($this->request('betting_no'));
		$bettingTime 	= Trim($this->request('betting_time'));

		if(empty($bettingNo) || $bettingNo=='' || !$this->req->isNumberParameter($bettingNo))
		{
			throw new Lemon_ScriptException("잘못된 인자입니다");
			exit;
		}
		
		$configModel 	= $this->getModel("ConfigModel");
		$gameModel 		= $this->getModel("GameModel");
		$processModel 	= $this->getModel("ProcessModel");
		$cartModel 	= $this->getModel("CartModel");
		$memberModel 	= $this->getModel("MemberModel");
		
		//취소 가능여부 판단
		
		//배팅후 X분 이내
		$passingTime = (strtotime(date("Y-m-d H:i"))-strtotime($bettingTime))/60;
		$cancelEnableTime_After_betting = $configModel->getAdminConfigField('bettingcanceltime');
		$cancelEnable_cnt = $configModel->getAdminConfigField('bettingcancelcnt');
		
		if ($passingTime > $cancelEnableTime_After_betting)
		{
			throw new Lemon_ScriptException("배팅후 " . $cancelEnableTime_After_betting . "분 이내에만 취소가 가능합니다.");
			exit;
		}
		
		
		//게임시작전 X분 이내
		$cancelEnableTime = $configModel->getAdminConfigField('bettingcancelbeforetime');
	
		if($cartModel->isBettingCancelEnable($bettingNo, $cancelEnableTime)==0)
		{
			throw new Lemon_ScriptException("경기시작전 " . $cancelEnableTime . "분전에만 배팅취소가 가능합니다.");
			exit;
		}
/*
		//하루 배팅 취소 횟수 제한
		$bet_cancel=$processModel->getRow("bet_cancel_flag", "tb_people", "sn='".$sn."'");
	
		if(sizeof($bet_cancel) > 0)
		{
			$bet_cancel_arr=split('_', $bet_cancel["bet_cancel_flag"]);
			$bet_cancel_date=$bet_cancel_arr[0];
			$bet_cancel_cnt=$bet_cancel_arr[1];
		
			if(trim(substr(date('Y-m-d'), 0, 10))==trim($bet_cancel_date))
			{
				if(intVal($bet_cancel_cnt) >= intVal($cancelEnable_cnt))
				{
					throw new Lemon_ScriptException("하루 배팅 취소 횟수 ".$cancelEnable_cnt."회를 초과하셨습니다.", "", "back", "");
				}
				else
				{
					$bet_cancel_cnt=intVal($bet_cancel_cnt)+1;
					//$memberModel->setBet_cancel_cnt($sn, $bet_cancel_cnt);
				}
			}
			else
			{
				$memberModel->setBet_cancel_cnt($sn, '1');
			}
		}
		else
		{
			$memberModel->setBet_cancel_cnt($sn, '1');
		}
*/
		$processModel->bettingCancelProcess($bettingNo);
		throw new Lemon_ScriptException("취소되었습니다. 모든 금액은 환불처리되었습니다.");
	}
	
	//▶ 내역삭제
	public function betlisthideProcessAction()
	{
		$this->req->xssClean();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$sn = $this->auth->getSn();
		$bettingNo 	= Trim($this->request('betting_no'));
		
		if(empty($bettingNo) || $bettingNo=='' || !$this->req->isNumberParameter($bettingNo))
		{
			echo "잘못된 인자입니다";
			exit;
		}
		
		$cartModel 	= $this->getModel("CartModel");
		$rs = $cartModel->modifyViewState($sn, $bettingNo);
		if($rs > 0)
			echo "배팅내역이 삭제되었습니다.";
		else {
			$rs = $cartModel->modifyCancelViewState($sn, $bettingNo);
			if($rs > 0)
				echo "배팅내역이 삭제되었습니다.";
			else 
				echo "배팅내역 삭제에 실패하였습니다.";
		}
			
	}

	public function betCancelProcessAction() {
		$bettingNo 	= empty($this->request('betting_no')) ? 0 : $this->request('betting_no');
		$res = $this->checkbettingCancel($bettingNo);
		if($res["status"] > 0) {
			echo $res["msg"];
		} else {
			$uid = $this->auth->getId();
			$pModel  = $this->getModel("ProcessModel");
			$pModel->bettingCancelProcess($bettingNo, $uid);
			echo "배팅이 취소되였습니다.";
		}
		
	}

	
	public function checkbettingCancel($bettingNo) 
	{
		$configModel = $this->getModel("ConfigModel");
		$gameModel = $this->getModel("GameModel");

		$config = $configModel->getAdminConfig();
		$cancelAfterTime = $config["bettingcanceltime"];
		$cancelBeforeTime = $config["bettingcancelbeforetime"];
		$cancelCnt = $config["bettingcancelcnt"];

		$game_info = $gameModel->getGameByBettingNo($bettingNo);
		$gameStartTime = strtotime($game_info[0]["gameDate"] . " " . $game_info[0]["gameHour"] . ":" . $game_info[0]["gameTime"] . ":00");
		$bettingTime = strtotime($game_info[0]["regdate"]);
		$nowTime = time();
		$special = $game_info[0]["last_special_code"];
		$live = $game_info[0]["live"];

		$sn = $this->auth->getSn();
		$todayCancelCnt = $gameModel->getTodayBettingCancelCnt($sn);

		$existResult = $gameModel->existBettingResult($bettingNo);
		
		$res["status"] = 0;
		$res["msg"] = "";

		if($live == 1) {
			$res["status"] = 4; 
			$res["msg"] = "라이브배팅은 취소가 불가능합니다.";
			return $res;
		}
		
		if($todayCancelCnt >= $cancelCnt) {
			$res["status"] = 3; 
			$res["msg"] = "배팅취소는 하루 {$cancelCnt}번만 가능합니다.";
			//$res["msg"] = "미안하지만 하루 배팅취소회수를 초과하였습니다.";
			return $res;
		}
		
		if($special < 5) {
			if(($nowTime - $bettingTime) > $cancelAfterTime * 60) {
				$res["status"] = 1; 
				$res["msg"] = "배팅후 {$cancelAfterTime}분이내에만 취소가 가능합니다.";
				return $res;
			} 
			
			if (($gameStartTime - $nowTime) < $cancelBeforeTime * 60) {
				$res["status"] = 2; 
				$res["msg"] = "경기시작 {$cancelBeforeTime}분전까지만 취소가 가능합니다.";
				return $res;
			}
		}

		if($existResult > 0) {
			$res["status"] = 5; 
			$res["msg"] = "결과처리된 배팅은 취소가 불가능합니다.";
			return $res;
		}

		return $res;

	}


	public function hide_bettingAction() {
		$this->req->xssClean();
		
		if ( !$this->auth->isLogin() ) {
			$this->loginAction();
			exit;
		}
		$sn = $this->auth->getSn();

		$bettingList = $this->request("bettingList");
		if ( !$bettingList ) {
			echo "false";
			exit;
		}

		$cartModel = $this->getModel("CartModel");
		$bettingArr = explode("|",$bettingList);
		for ( $i = 0 ; $i < count($bettingArr) ; $i++ ) {
			if ( $bettingArr[$i] > 0 ) {
				$rs = $cartModel->hide_betting($sn, trim($bettingArr[$i]));
				if ( $rs ) $rsCnt++;
			}
		}
		if ( $rsCnt > 0 ) echo "true";
		else echo "false";
	}
	
	public function hide_all_bettingAction()
	{
		$this->req->xssClean();
		
		if(!$this->auth->isLogin())
		{
			$this->loginAction();
			exit;
		}
		$sn = $this->auth->getSn();
		
		$cartModel 	= $this->getModel("CartModel");
		$rs = $cartModel->hide_all_betting($sn);
		if($rs>0)
			throw new Lemon_ScriptException("배팅내역이 삭제되었습니다.");
		else
			throw new Lemon_ScriptException("배팅내역 삭제에 실패하였습니다.");
	}
	
	//▶ 배팅
	function IsValidBetting($betcontent)
	{
        $betArray = explode("#",$betcontent);
        $m_count = count($betArray);

        foreach ($betArray as $bet_detail)
		{
			if(strpos($bet_detail, '3폴더') === false)
			{
                if(strpos($bet_detail, '5폴더') === false)
				{
					continue;
				}
				else
				{
					if(count($betArray) < 7)
						return "5폴더 이상만 베팅 가능합니다.";
				}
			}
			else
			{
                if(count($betArray) < 5)
                    return "3폴더 이상만 베팅 가능합니다.";
			}
		}
        return true;
	}

	function bettingProcessAction() {
		$this->req->xssClean();
		
		date_default_timezone_set("Asia/Seoul");

		if ( !$this->auth->isLogin() ) {
			$this->loginAction();
			exit;
		}
		
		$sn = $this->auth->getSn();
		$uid = $this->auth->getId();
		
		$mModel = $this->getModel('MemberModel');
		$eModel = $this->getModel('EtcModel');
		$cModel = $this->getModel('ConfigModel');
		$gModel = $this->getModel('GameModel');
		$cartModel = $this->getModel('CartModel');
		$pModel = $this->getModel('ProcessModel');
		
		$boardModel = $this->getModel("BoardModel");
		
		$dbSessionId = $mModel->getMemberField($sn, 'sessionid');
		
		if ( $dbSessionId != session_id() ) {
			if ( $this->auth->isLogin() ) {
				session_destroy();
			}
			throw new Lemon_ScriptException("다시 로그인 하신후 배팅하여 주십시오.", "", "go", "/");
			exit;
		}
		
		$mode = Trim($this->request("mode"));
		$betting = $this->request("betMoney");
		$gametype = $this->request("gametype");
		$_gameType = $this->request("game_type"); 		//-> 페이지를 위한 gameType  1:승무패, 2:핸디캡
		$specialType = $this->request("special_type");
		$strgametype = $this->request("strgametype");
		$betcontent = $this->request("betcontent");
		$betcontent = str_replace(" ","",$betcontent);
		$betcontent = str_replace("<B>","",$betcontent);
		$betcontent = str_replace("</B>","",$betcontent);
		
		$betting_point = round($betting);

		$go_path = "/game_list?game=".$_gameType;

		$result = $this->IsValidBetting($betcontent);
		if($result !== true)
		{
			throw new Lemon_ScriptException($result, "", "back", "");
			exit();
		}

		//-> DB기준 최소 배팅금 확인. 2016.08.10
		$bettingMinMoney = $cModel->getLevelConfigRow($this->auth->getLevel(), "lev_min_money");
		if ( $betting < $bettingMinMoney["lev_min_money"] ) {
			throw new Lemon_ScriptException("최소 배팅금은 ".number_format($bettingMinMoney["lev_min_money"])."원 입니다.", "", "go", $go_path);
			exit();
		}

		$dbCash = $mModel->getMemberField($sn,'g_money');
		if ( is_null($dbCash) ) {
			$dbCash = 0;
		}
			
		if ( round($dbCash) < round($betting) or $betting < 0 ) {
			throw new Lemon_ScriptException("보유머니가 부족합니다.", "", "go", $go_path);
			exit();
		}
		
		if ( $mode == "betting" ) {
			$buy = "Y";
		} else if ( $mode == "cart" ) {
			$buy = "N";
		} else {
			throw new Lemon_ScriptException("잘못된 인자입니다.", "", "go", $go_path);
			exit();
		}

		$data = explode("#",$betcontent);
		
		$betting_cnt = count($data) - 1; //-> 배팅경기수
		if ( $betting_cnt < 0 ) {
			throw new Lemon_ScriptException("배팅처리가 되지 않았습니다. 다시 시도 하십시오.", "", "go", $go_path);
			exit();
		}

		//-> 게임번호
		$lastIdx = $cartModel->getLastCartIndex();
		
		$nowtime = date("Y-m-d H:i:s");
		$protoId = strtotime($nowtime) - strtotime("2000-01-01")+(9*60*60);
		$protoId = $protoId + $lastIdx;
		if ( $protoId == "" ) {
			throw new Lemon_ScriptException("구매번호를 확인하여 주십시요.");			
			exit();
		}
		$protoId = $sn.$protoId;
		$out_cnt = 0;
		
		//-> 선택한 경기마다 경기시작여부체크
		for ( $i = 0 ; $i < count($data)-1 ; ++$i ) {
			$game_spec = explode("||",$data[$i]);
			$subchildSn = $game_spec[0];
			$childSn = $gModel->getChildSn($subchildSn);	
			$selected = $game_spec[1];
			
			if ( $selected == 0 ) $selected = 1;
			else if ( $selected == 1 ) $selected = 3;
			else if ( $selected == 2 ) $selected = 2;
			
			$rs = $gModel->getChildRow($childSn, '*');	
			if ( count((array)$rs) > 0 ) {
				$gameEndTime = Trim($rs["gameDate"]) ." ". Trim($rs["gameHour"]) .":". Trim($rs["gameTime"]); //'경기시작시간
				$remainTime 	= (strtotime($gameEndTime)-strtotime($nowtime))/60;
				$parentIdx 	= $rs['parent_sn'];
			}
			// echo $start_date = date('Y-m-d H:i:s', time()) . "\n";
			// echo $gameEndTime . "\n";
			// exit;
			//-> 배팅마감 경기시작 30초전까지
			if ( time() >= (strtotime($gameEndTime)-30) ) {
				// echo "child_sn -> " . $childSn . "\n";
				// echo $start_date = date('Y-m-d H:i:s', time()) . "\n";
				// echo $start_date = date('Y-m-d H:i:s', (strtotime($gameEndTime)-30)) . "\n";
				$out_cnt += 1;
			}
			// exit;

			//-> 관리자에서 숨김처리한 게임 체크
			if ( $rs["user_view_flag"] == 0 ) {
				throw new Lemon_ScriptException("배팅이 중지된 게임이 있습니다.", "", "go", $go_path);
				exit();
			}

			//-> 스포츠가 맞는지 체크
			if ( $rs["special"] > 2 && $rs["special"] != 22) {
				throw new Lemon_ScriptException("경기 타입이 오류가 발생 되었습니다.", "", "go", $go_path);
				exit();
			}

			$model = $this->getModel("ConfigModel");
			$sport_setting = $model->getSportBettingSetting("*", "", '');

			//특이조건- 승무패의 '무'와 멀티의 언더오버 '언더'는 동시에 배팅불가
			$special_type = $rs["special"];
			$is_specified_special = $rs["is_specified_special"];
			$game_type = $rs["type"];
			$home_team = $rs["home_team"];
			$away_team = $rs["away_team"];
			$sport_name = $rs['sport_name'];
		}

		$sport_array = array("축구", "야구", "농구", "배구", "아이스 하키");
		$kind = '';
		if($_gameType == 'multi')
		{
			$kind = 'cross';
		} else if($_gameType == 'handi') {
			$kind = 'handi';
		} else if($_gameType == 'special') {
			$kind = 'special';
		} else if($_gameType == 'real') {
			$kind = 'real';
		} else if($_gameType == 'abroad') {
			$kind = 'abroad';
		}

		if( ($sport_setting[$kind.'_soccer_wl_over'] == 1 && strcmp($sport_name, '축구') === 0) ||
			($sport_setting[$kind.'_baseball_wl_over'] == 1 && strcmp($sport_name, '야구') === 0) ||
			($sport_setting[$kind.'_basketball_wl_over'] == 1 && strcmp($sport_name, '농구') === 0) ||
			($sport_setting[$kind.'_volleyball_wl_over'] == 1 && strcmp($sport_name, '배구') === 0) ||
			($sport_setting[$kind.'_hockey_wl_over'] == 1 && strcmp($sport_name, '아이스 하키') === 0) ||
			($sport_setting[$kind.'_etc_wl_over'] == 1 && in_array($sport_name, $sport_array) === FALSE)
		)
		{
			if($this->CheckRule_wl_over($data, $gModel) === false)
			{
				throw new Lemon_ScriptException("동일경기(".$sport_name.") [승패]+[오버] 조합은 배팅 불가능합니다.", "", "go", $go_path);
				exit();
			}
		}

		if( ($sport_setting[$kind.'_soccer_wl_under'] == 1 && strcmp($sport_name, '축구') === 0) ||
			($sport_setting[$kind.'_baseball_wl_under'] == 1 && strcmp($sport_name, '야구') === 0) ||
			($sport_setting[$kind.'_basketball_wl_under'] == 1 && strcmp($sport_name, '농구') === 0) ||
			($sport_setting[$kind.'_volleyball_wl_under'] == 1 && strcmp($sport_name, '배구') === 0) ||
			($sport_setting[$kind.'_hockey_wl_under'] == 1 && strcmp($sport_name, '아이스 하키') === 0) ||
			($sport_setting[$kind.'_etc_wl_under'] == 1 && in_array($sport_name, $sport_array) === FALSE)
		)
		{
			if($this->CheckRule_wl_under($data, $gModel) === false)
			{
				throw new Lemon_ScriptException("동일경기(".$sport_name.") [승패]+[언더] 조합은 배팅 불가능합니다.", "", "go", $go_path);
				exit();
			}
		}

		if( ($sport_setting[$kind.'_soccer_d_over'] == 1 && strcmp($sport_name, '축구') === 0) ||
			($sport_setting[$kind.'_baseball_d_over'] == 1 && strcmp($sport_name, '야구') === 0) ||
			($sport_setting[$kind.'_basketball_d_over'] == 1 && strcmp($sport_name, '농구') === 0) ||
			($sport_setting[$kind.'_volleyball_d_over'] == 1 && strcmp($sport_name, '배구') === 0) ||
			($sport_setting[$kind.'_hockey_d_over'] == 1 && strcmp($sport_name, '아이스 하키') === 0) ||
			($sport_setting[$kind.'_etc_d_over'] == 1 && in_array($sport_name, $sport_array) === FALSE)
		)
		{
			if($this->CheckRule_d_over($data, $gModel) === false)
			{
				throw new Lemon_ScriptException("동일경기(".$sport_name.") [무]+[오버] 조합은 배팅 불가능합니다.", "", "go", $go_path);
				exit();
			}
		}

		if( ($sport_setting[$kind.'_soccer_d_under'] == 1 && strcmp($sport_name, '축구') === 0) ||
			($sport_setting[$kind.'_baseball_d_under'] == 1 && strcmp($sport_name, '야구') === 0) ||
			($sport_setting[$kind.'_basketball_d_under'] == 1 && strcmp($sport_name, '농구') === 0) ||
			($sport_setting[$kind.'_volleyball_d_under'] == 1 && strcmp($sport_name, '배구') === 0) ||
			($sport_setting[$kind.'_hockey_d_under'] == 1 && strcmp($sport_name, '아이스 하키') === 0) ||
			($sport_setting[$kind.'_etc_d_under'] == 1 && in_array($sport_name, $sport_array) === FALSE)
		)
		{
			if($this->CheckRule_d_under($data, $gModel) === false)
			{
				throw new Lemon_ScriptException("동일경기(".$sport_name.") [무]+[언더] 조합은 배팅 불가능합니다.", "", "go", $go_path);
				exit();
			}
		}

		if( ($sport_setting[$kind.'_soccer_h_unov'] == 1 && strcmp($sport_name, '축구') === 0) ||
			($sport_setting[$kind.'_baseball_h_unov'] == 1 && strcmp($sport_name, '야구') === 0) ||
			($sport_setting[$kind.'_basketball_h_unov'] == 1 && strcmp($sport_name, '농구') === 0) ||
			($sport_setting[$kind.'_volleyball_h_unov'] == 1 && strcmp($sport_name, '배구') === 0) ||
			($sport_setting[$kind.'_hockey_h_unov'] == 1 && strcmp($sport_name, '아이스 하키') === 0) ||
			($sport_setting[$kind.'_etc_h_unov'] == 1 && in_array($sport_name, $sport_array) === FALSE)
		)
		{
			if($this->checkRule_handi_unov($data, $gModel) === false)
			{
				throw new Lemon_ScriptException("동일경기(".$sport_name.") [핸디]+[언더/오버] 조합은 배팅 불가능합니다.", "", "go", $go_path);
				exit();
			}
		}
		
		if ( $out_cnt > 0 ) {
			throw new Lemon_ScriptException("배팅마감시간이 초과된 경기가 포함되어 있어서 구매하지 못하였습니다.확인하여 주십시요.", "", "go", $go_path);
			exit();
		}
		
		//-> 배당변화 여부 판단 변화가 있을경우 메세지를 출력하며, 배팅을 취소해준다.
		for ( $i = 0 ; $i < count($data)-1 ; $i++ ) {
			$data_detail = explode("||",$data[$i]);
			
			$childSn 			= $data_detail[0];
			$selected 		= $data_detail[1];
			$rate1				= $data_detail[4];
			$rate2				= $data_detail[5];
			$rate3				= $data_detail[6];
			$selectedRate	= $data_detail[7];

			$isChanged = $cartModel->isRateChangedMulti($subchildSn, $rate1, $rate2, $rate3);
			
			// if ( $isChanged == 1 ) {
			// 	throw new Lemon_ScriptException("배당(기준점)이 변경된 경기입니다. 확인해주세요.", "", "go", $go_path);
			// 	exit();
			// }

			//-> 넘어온 선택배당율(selectedRate) 검증. 2016.08.10
			$errorRate = 0;
			if ( $selected == 0 ) {
				if ( $rate1 != $selectedRate ) $errorRate = 1;
			} else if ( $selected == 1 ) {
				if ( $rate2 != $selectedRate ) $errorRate = 1;
			} else if ( $selected == 2 ) {
				if ( $rate3 != $selectedRate ) $errorRate = 1;
			}

			if ( $errorRate == 1 ) {
				throw new Lemon_ScriptException("배당(기준점)에 오류가 발생되었습니다.", "", "go", $go_path);
				exit();
			}

			//-> 총 배당율 합계 계산. 2016.08.10
			if ( !$sumSelectRate ) $sumSelectRate = 1;
			$sumSelectRate = $sumSelectRate * $selectedRate;
		}
		//-> 총 배당율. 2016.08.10
		//$resultRate = round($sumSelectRate,2);
		// 2017.05.19
		$resultRate = bcmul($sumSelectRate,1, 2);

		if($resultRate > 100)
		{
			throw new Lemon_ScriptException("스포츠 배팅은 100배당 이상은 배팅이 불가능 합니다.", "", "go", $go_path);
			exit();
		}

		//-> 축벳 체크 (배팅한 게임 1개씩 가져와서 같은게임(childSn) 같은 방향(selected)에 배팅한 이력이 있는지 확인)
		$copy_bte_list = array(); //-> 중복 배팅 확인.
		$cukbet_no_list = array();
		$newCukbet_no_list = array();
		for ( $i = 0 ; $i < count($data)-1 ; $i++ ) {
			$data_detail = explode("||",$data[$i]);		
			$subChildSn = $data_detail[0];
			$childSn = $gModel->getChildSn($subChildSn);
			$selected = $data_detail[1];
			$homeTeamName = $data_detail[2];
			$awayTeamName = $data_detail[3];
			$rate1 = $data_detail[4];
			$rate2 = $data_detail[5];
			$rate3 = $data_detail[6];
			$selectedRate	= $data_detail[7];
			$gameType = $data_detail[8];
			$subChildSn = $data_detail[9];
			
			if ( $selected == 0 ) $selected = 1;
			else if( $selected == 1 ) $selected = 3;
			else if( $selected == 2 ) $selected = 2;

			if ( strlen(trim($homeTeamName)) == strlen(str_replace("보너스","",trim($homeTeamName))) )
			{
				//-> 같은게임(childSn) 같은 방향(selected)에 배팅한 betting_no를 모두 저장
				$cukbet_row = $cartModel->checkCukBet($sn, $subChildSn, $selected);
				for ( $j = 0 ; $j < count((array)$cukbet_row) ; $j++ ) {
					$cukbet_no_list[] = $cukbet_row[$j]["betting_no"];
					$copy_bte_list[$cukbet_row[$j]["betting_no"]]++;
				}
			}
		}
		//-> 축벳 체크 (중복 배팅값 삭제)
		$cukbet_no_list = array_unique($cukbet_no_list);

		//-> 배팅번호 게임중(다폴 등) 낙첨된 경기가 있으면 해당 배팅번호 제외.
		for ( $j = 0 ; $j < count((array)$cukbet_no_list) ; $j++ ) {
			$loseGameRow = $cartModel->checkLoseGame($cukbet_no_list[$j]);
			if ( !$loseGameRow or count($loseGameRow) == 0 ) {
				$newCukbet_no_list[] = $cukbet_no_list[$j];
			}
		}

		//-> 축벳 체크 (배당가져와서 총 배당금 측정)
		$total_ckbet_money = 0;
		for ( $i = 0 ; $i < count((array)$newCukbet_no_list) ; $i++ ) {
			$ckbet_rate = 1;
			$ckbet_money = 0;
			$betgame_row = $cartModel->checkCukBet_rate($sn, $newCukbet_no_list[$i]);
			for ( $j = 0 ; $j < count($betgame_row) ; $j++ ) {
				$ckbet_rate = $ckbet_rate * $betgame_row[$j]["select_rate"];
				$ckbet_money = $betgame_row[$j]["bet_money"];
			}
			
			//-> 축벳 체크된 총 배당금
			$total_ckbet_money = ($total_ckbet_money + ( $ckbet_money * $ckbet_rate));
		}
		//-> 현재 배팅한 게임에 배당금.
		$this_bedang_money = ($betting * $resultRate);

		$array_cukbet = $cModel->getLevelConfigRow($this->auth->getLevel(), "lev_max_money, lev_max_money_special, lev_max_money_single, lev_max_money_single_special, lev_max_bonus_cukbet, lev_max_bonus_cukbet_special");
		if ( $specialType == 0 ) $ckbet_max_money = $array_cukbet["lev_max_bonus_cukbet"] + 0;
		else $ckbet_max_money = $array_cukbet["lev_max_bonus_cukbet_special"] + 0;

		if ( $ckbet_max_money > 0 && $total_ckbet_money != 0) {
			//-> 현재 배당금 + 축벳 배당금이 축벳 제한 금액을 초과 할 경우.
			if ( ( $this_bedang_money + $total_ckbet_money ) > $ckbet_max_money ) {
				throw new Lemon_ScriptException("축배팅 제한상환가는 ".number_format($ckbet_max_money)."원입니다.<br>배팅금액을 조정해주세요.<br>[ 현재 배팅 배당금 : ".number_format($this_bedang_money)."원 ]<br>[ 보유 축뱃 배당금 : ".number_format($total_ckbet_money)."원 ]<br><br>합계 : ".number_format($this_bedang_money)." + ".number_format($total_ckbet_money)." = ".number_format($this_bedang_money+$total_ckbet_money)."원", "go", $go_path);
				exit();
			}
		}
		//if($rs["league_sn"] <> 4000 or $rs["league_sn"] <> 4100 or $rs["league_sn"] <> 4200){
		//-> 똑같은 배팅이 있나 확인.
		if($rs["league_sn"] <> 4000){
			if($rs["league_sn"] <> 4100){
				if($rs["league_sn"] <> 4200){
					$gameBetCnt = count($data)-1;
					foreach ( $copy_bte_list as $copyBetKey => $copyBetValue) {
						if ( $copyBetValue == $gameBetCnt ) {
							//-> 배팅이력과 DB에 배팅이력이 중첩되면 DB에 중첩된 게임의 카운트를 가져온다.
							//-> 현재 배팅수와 DB에 배팅수가 동일하면 똑같은 배팅으로 간주.
							$gameInfo = $cartModel->getTotalCartInfo($sn, $copyBetKey);
							if ( $gameBetCnt == $gameInfo["betting_cnt"] ) {
								throw new Lemon_ScriptException("동일경기 배팅은 중복배팅이 불가능합니다.", "", "back", "");
								exit();
							}
						}
					}
				}
			}
		}

		//-> 배팅 제한 체크.
		$cukbet_no_list = array();
		$newCukbet_no_list = array();
		for ( $i = 0 ; $i < count($data)-1 ; $i++ ) {
			$data_detail = explode("||",$data[$i]);		
			$childSn = $data_detail[0];
			$selected = $data_detail[1];
			$rate1 = $data_detail[4];
			$rate2 = $data_detail[5];
			$rate3 = $data_detail[6];
			$selectedRate	= $data_detail[7];
			$gameType = $data_detail[8];
			$subChildSn = $data_detail[9];
			
			if ( $selected == 0 ) $selected = 1;
			else if( $selected == 1 ) $selected = 3;
			else if( $selected == 2 ) $selected = 2;

			//-> 같은게임(childSn) 같은 방향(selected)에 배팅한 betting_no를 모두 저장
			if ( (count($data)-1) == 1 ) {
				$cukbet_row = $cartModel->checkCukBet($sn, $subChildSn, $selected, 1);
			} else {
				$cukbet_row = $cartModel->checkCukBet($sn, $subChildSn, $selected, 2);
			}
			for ( $j = 0 ; $j < count((array)$cukbet_row) ; $j++ ) {
				$cukbet_no_list[] = $cukbet_row[$j]["betting_no"];
			}
		}
		//-> 중복 삭제
		$cukbet_no_list = array_unique($cukbet_no_list);

		//-> 배팅번호 게임중(다폴 등) 낙첨된 경기가 있으면 해당 배팅번호 제외.
		for ( $j = 0 ; $j < count($cukbet_no_list) ; $j++ ) {
			$loseGameRow = $cartModel->checkLoseGame($cukbet_no_list[$j]);
			if ( !$loseGameRow or count($loseGameRow) == 0 ) {
				$newCukbet_no_list[] = $cukbet_no_list[$j];
			}
		}

		//-> 배팅금가져와서 총 배당금 측정)
		$total_ckbet_money = 0;
		for ( $i = 0 ; $i < count($newCukbet_no_list) ; $i++ ) {
			$betgame_row = $cartModel->checkCukBet_rate($sn, $newCukbet_no_list[$i]);
			$total_betting_money += $betgame_row[0]["bet_money"];
		}

		//' tb_betting 에 1게임씩 추가
		for($i=0;$i<count($data)-1;$i++)
		{
			$data_detail = explode("||",$data[$i]);
			
			$childSn 			= $data_detail[0];
			$selected 		= $data_detail[1];
			$rate1				= $data_detail[4];
			$rate2				= $data_detail[5];
			$rate3				= $data_detail[6];
			$selectedRate	= $data_detail[7];
			$gameType			= $data_detail[8];
			$subChildSn		= $data_detail[9];
			$special		= $data_detail[13]; 
			$betid		= $data_detail[14];
			
			if($selected==0)			$selected=1;
			elseif($selected==1)	$selected=3;
			elseif($selected==2)	$selected=2;

			//-> 종목명과 리그명을 가져온다.
			$leagueInfo = $gModel->getMultiLeagueInfo($childSn);
			$kind = $leagueInfo[0]['kind'];
			$leagueName = $leagueInfo[0]['name'];
			$_homeTeam = $leagueInfo[0]['home_team'];

			//-> 홈, 무, 어웨이 배당을 DB기준으로 가져온다. (POST값 안씀)
			$subChildInfo = $gModel->getMultiRateInfo($childSn);
			$rate1 = $subChildInfo[0]["home_rate"];
			$rate2 = $subChildInfo[0]["draw_rate"];
			$rate3 = $subChildInfo[0]["away_rate"];

			$rs = $cartModel->addBet($sn, $childSn, $subChildSn, $protoId, $selected, $rate1, $rate2, $rate3, $selectedRate, $gameType, $buy, $betting, $special, $betid);
		}

		//-> 마지막 $childSn을 가지고 special 코드를 가져온다. (정산부분 게임을 분류하기 위해)
		$lastChildGameInfo = $gModel->getMultiChildRow($childSn, '*');
		$lastSpecialCode = empty($lastChildGameInfo["special"]) ? 0 : $lastChildGameInfo["special"];

		$rs = $mModel->getMemberRow($sn);
		$recommendSn 	= $rs['recommend_sn'];
		$rollingSn		= $rs['rolling_sn'];
		$author = $rs['nick'];
		
		if($this->auth->getState()=="G") 	$accountEnable = 0;
		else								$accountEnable = 1;

		$cartModel->addCart($sn, $parentIdx, $protoId, $buy, $betting_cnt, $dbCash, $betting, $resultRate, $recommendSn, $rollingSn, $accountEnable, '', $lastSpecialCode, $specialType);
		
		$chkFolderOption = $cModel->getPointConfigField('chk_folder');
		
		if($chkFolderOption == "1")
		{
			$bouns_rate_percent=0;
			switch($betting_cnt)
			{
				Case 3: $bouns_rate_percent = $bouns_rate3; break;
				Case 4: $bouns_rate_percent = $bouns_rate4; break;
				Case 5: $bouns_rate_percent = $bouns_rate5; break;
				Case 6: $bouns_rate_percent = $bouns_rate6; break;
				Case 7: $bouns_rate_percent = $bouns_rate7; break;
				Case 8: $bouns_rate_percent = $bouns_rate8; break;
				Case 9: $bouns_rate_percent = $bouns_rate9; break;
				Case 10:$bouns_rate_percent = $bouns_rate10;break;
			}
			$cartModel->modifyBonusRate($sn, $bouns_rate_percent, $protoId);
		}
		
		//$pModel->bettingProcess($sn, $betting);
		$pModel->bettingProcess2($sn, $betting, $protoId);

		$path	= "/race/betting_list";
		$_SESSION["betlist"]="";		
		
		/*베팅수가 10개이상이고, 1만원이상인 경기는 자동으로 잭팟게시글을 남긴다.*/
		if($betting_cnt>=10 && $betting>=10000)
		{
			$commonModel 		= $this->getModel("CommonModel");
			$ip = $commonModel->getip();
			$title = $author.'님의 잭팟베팅^^';
			$boardModel->addJackpotContent($author, $title, "잭팟이벤트", $protoId, $ip);
		}

		if($specialType == 22)
		{
			//-> 배팅 알람 업데이트.
			if ( $betting >= 300000 ) {
				$cModel->modifyAlramFlag("betting_vfootball_big",1);
			} else {
				$cModel->modifyAlramFlag("betting_vfootball",1);
			}
		}
		else
		{
			//-> 배팅 알람 업데이트.
			if ( $betting >= 300000 ) {
				$cModel->modifyAlramFlag("betting_sport_big",1);
			} else {
				$cModel->modifyAlramFlag("betting_sport",1);
			}
		}
	

		throw new Lemon_ScriptException("배팅신청이 완료되었습니다.", "", "go", $path);

		exit();
	}
	
	function testAction()
	{
		$cartModel	= $this->getModel('CartModel');
		$childSn=41555;
		$rate1='1.85';
		$rate2='1';
		$rate3='1.75';
		$rs = $cartModel->isRateChanged($childSn, $rate1, $rate2, $rate3);
		echo $rs;
	}

	// 승패+오버
	function CheckRule_wl_over($data, $gModel)
	{
		for($i=0; $i<count((array)$data)-1; ++$i) {
			$game_spec = explode("||",$data[$i]);
			$childSn = $game_spec[0];
			$i_item = $gModel->getChildRow($childSn, '*');
			$i_item_checkbox_index = $game_spec[1];

			for ( $j = ($i+1) ; $j < count((array)$data)-1 ; $j++ ) {
				$game_spec = explode("||",$data[$j]);
				$childSn = $game_spec[0];
				$j_item = $gModel->getChildRow($childSn, '*');
				$j_item_checkbox_index = $game_spec[1];

				if ( $i_item['type'] == 1 && ($i_item_checkbox_index == 0 || $i_item_checkbox_index == 2)) {
					if ( strpos($i_item['home_team'], $j_item['home_team']) !== false && strpos($i_item['away_team'], $j_item['away_team']) !== false  &&
						$j_item['type'] == 4 && $j_item_checkbox_index == 2 ) {
						return false;
					}
				} else if ( $i_item['type'] == 4 && $i_item_checkbox_index == 2 && strpos($j_item['away_team'], $i_item['away_team']) !== false &&
					strpos($j_item['home_team'], $i_item['home_team']) !== false ) {
					if ($j_item['type'] == 1 &&  ($j_item_checkbox_index == 0 || $j_item_checkbox_index == 2)) {
						return false;
					}
				}
			} //-> end FOR J
		} //-> end FOR I
		return true;
	}

	// 승패+언더
	function CheckRule_wl_under($data, $gModel)
	{
		for($i=0; $i<count((array)$data)-1; ++$i) {
			$game_spec = explode("||",$data[$i]);
			$childSn = $game_spec[0];
			$i_item = $gModel->getChildRow($childSn, '*');
			$i_item_checkbox_index = $game_spec[1];

			for ( $j = ($i+1) ; $j < count((array)$data)-1 ; $j++ ) {
				$game_spec = explode("||",$data[$j]);
				$childSn = $game_spec[0];
				$j_item = $gModel->getChildRow($childSn, '*');
				$j_item_checkbox_index = $game_spec[1];

				if ( $i_item['type'] == 1 && ($i_item_checkbox_index == 0 || $i_item_checkbox_index == 2)) {
					if ( strpos($i_item['home_team'], $j_item['home_team']) !== false && strpos($i_item['away_team'], $j_item['away_team']) !== false  &&
						$j_item['type'] == 4 && $j_item_checkbox_index == 0 ) {
						return false;
					}
				} else if ( $i_item['type'] == 4 && $i_item_checkbox_index == 0 && strpos($j_item['away_team'], $i_item['away_team']) !== false &&
					strpos($j_item['home_team'], $i_item['home_team']) !== false ) {
					if ($j_item['type'] == 1 &&  ($j_item_checkbox_index == 0 || $j_item_checkbox_index == 2)) {
						return false;
					}
				}
			} //-> end FOR J
		} //-> end FOR I
		return true;
	}


	// 무 + 오버
	function CheckRule_d_over($data, $gModel)
	{
		for($i=0; $i<count((array)$data)-1; ++$i) {
			$game_spec = explode("||",$data[$i]);
			$childSn = $game_spec[0];
			$i_item = $gModel->getChildRow($childSn, '*');
			$i_item_checkbox_index = $game_spec[1];

			for ( $j = ($i+1) ; $j < count((array)$data)-1 ; $j++ ) {
				$game_spec = explode("||",$data[$j]);
				$childSn = $game_spec[0];
				$j_item = $gModel->getChildRow($childSn, '*');
				$j_item_checkbox_index = $game_spec[1];

				if ( $i_item['type'] == 1 && $i_item_checkbox_index == 1) {
					if ( strpos($i_item['home_team'], $j_item['home_team']) !== false && strpos($i_item['away_team'], $j_item['away_team']) !== false  &&
						$j_item['type'] == 4 && $j_item_checkbox_index == 2 ) {
						return false;
					}
				} else if ( $i_item['type'] == 4 && $i_item_checkbox_index == 2) {
					if ( strpos($j_item['away_team'], $i_item['away_team']) !== false &&
						 strpos($j_item['home_team'], $i_item['home_team']) !== false &&
						$j_item['type'] == 1 &&  $j_item_checkbox_index == 1) {
						return false;
					}
				}
			} //-> end FOR J
		} //-> end FOR I
		return true;
	}
	// 무+언더
	function CheckRule_d_under($data, $gModel)
	{
		for($i=0; $i<count((array)$data)-1; ++$i) {
			$game_spec = explode("||",$data[$i]);
			$childSn = $game_spec[0];
			$i_item = $gModel->getChildRow($childSn, '*');
			$i_item_checkbox_index = $game_spec[1];

			for ( $j = ($i+1) ; $j < count((array)$data)-1 ; $j++ ) {
				$game_spec = explode("||",$data[$j]);
				$childSn = $game_spec[0];
				$j_item = $gModel->getChildRow($childSn, '*');
				$j_item_checkbox_index = $game_spec[1];

				if ( $i_item['type'] == 1 && $i_item_checkbox_index == 1) {
					if ( strpos($i_item['home_team'], $j_item['home_team']) !== false && strpos($i_item['away_team'], $j_item['away_team']) !== false  &&
						$j_item['type'] == 4 && $j_item_checkbox_index == 0 ) {
						return false;
					}
				} else if ( $i_item['type'] == 4 && $i_item_checkbox_index == 0) {
					if ( strpos($j_item['away_team'], $i_item['away_team']) !== false &&
						strpos($j_item['home_team'], $i_item['home_team']) !== false &&
						$j_item['type'] == 1 &&  $j_item_checkbox_index == 1) {
						return false;
					}
				}
			} //-> end FOR J
		} //-> end FOR I
		return true;
	}

	// 핸디+언더/오버
	function checkRule_handi_unov($data, $gModel)
	{
		for($i=0; $i<count((array)$data)-1; ++$i) {
			$game_spec = explode("||",$data[$i]);
			$childSn = $game_spec[0];
			$i_item = $gModel->getChildRow($childSn, '*');
			$i_item_checkbox_index = $game_spec[1];

			for ( $j = ($i+1) ; $j < count((array)$data)-1 ; $j++ ) {
				$game_spec = explode("||",$data[$j]);
				$childSn = $game_spec[0];
				$j_item = $gModel->getChildRow($childSn, '*');
				$j_item_checkbox_index = $game_spec[1];

				if ( $i_item['type'] == 2) {
					if ( strpos($i_item['home_team'], $j_item['home_team']) !== false && strpos($i_item['away_team'], $j_item['away_team']) !== false  &&
						$j_item['type'] == 4) {
						return false;
					}
				} else if ( $i_item['type'] == 4) {
					if ( strpos($j_item['away_team'], $i_item['away_team']) !== false &&
						strpos($j_item['home_team'], $i_item['home_team']) !== false &&
						$j_item['type'] == 2) {
						return false;
					}
				}
			} //-> end FOR J
		} //-> end FOR I
		return true;
	}

	function CheckRule1($idx, $data, $gModel, $game_type, $home_team, $away_team)
	{
        for ( $i = 0 ; $i < count($data)-1 ; ++$i ) {
        	if($i === $idx) continue;

            $game_spec = explode("||",$data[$i]);
            $childSn = $game_spec[0];
            $item = $gModel->getChildRow($childSn, '*');

            $item_home_team = $this->filterGameName($item['home_team']);
            $item_away_team = $this->filterGameName($item['away_team']);
            $home_team = $this->filterGameName($home_team);
            $away_team = $this->filterGameName($away_team);

            if($game_type==1)
            {
                if($item_home_team==$home_team && $item_away_team==$away_team && $item['type']==2)
                {
                    return false;
                }
            }
            else if($game_type==2)
            {
                if($item_home_team==$home_team && $item_away_team==$away_team && $item['type']==1)
                {
                    return false;
                }
            }
        }

        return true;
	}


	//-> 축구의 경우 같은경기에서 승무패+언더오버 선택 불가.
    function checkRule2($idx, $data, $gModel, $game_type, $home_team, $away_team)
    {
        for ( $i = 0 ; $i < count($data)-1 ; ++$i ) {
            if($i === $idx) continue;

            $game_spec = explode("||",$data[$i]);
            $childSn = $game_spec[0];
            $item = $gModel->getChildRow($childSn, '*');

            $item_home_team = $this->filterGameName($item['home_team']);
            $item_away_team = $this->filterGameName($item['away_team']);
            $home_team = $this->filterGameName($home_team);
            $away_team = $this->filterGameName($away_team);

            if($game_type==1)
            {
                if($item_home_team==$home_team && $item_away_team==$away_team && $item['type']==4)
                {
                    return false;
                }
            }
            else if($game_type==4)
            {
                if($item_home_team==$home_team && $item_away_team==$away_team && $item['type']==1)
                {
                    return false;
                }
            }
        }

        return true;
    }

    //-> 축구의 경우 같은경기에서 핸디탭+언더오버 선택 불가.
    function checkRule3($idx, $data, $gModel, $game_type, $home_team, $away_team)
    {
        for ( $i = 0 ; $i < count($data)-1 ; ++$i ) {
            if($i === $idx) continue;

            $game_spec = explode("||",$data[$i]);
            $childSn = $game_spec[0];
            $item = $gModel->getChildRow($childSn, '*');

            $item_home_team = $this->filterGameName($item['home_team']);
            $item_away_team = $this->filterGameName($item['away_team']);
            $home_team = $this->filterGameName($home_team);
            $away_team = $this->filterGameName($away_team);

            if($game_type==2)
            {
                if($item_home_team==$home_team && $item_away_team==$away_team && $item['type']==4)
                {
                    return false;
                }
            }
            else if($game_type==4)
            {
                if($item_home_team==$home_team && $item_away_team==$away_team && $item['type']==2)
                {
                    return false;
                }
            }
        }

        return true;
    }
    /*
	승패-스페셜 조합

	승무패와는 조합이 가능.
	그외의 게임 타입과는 조합불가.
	*/
    function check_specified_special_rule($idx, $data, $gModel,  $is_specified_special, $game_type, $home_team, $away_team)
    {
        if($game_type!=1)
        {
            for($i=0; $i<count($data)-1;++$i)
			{
                $game_spec = explode("||",$data[$i]);
                $childSn = $game_spec[0];
                $item = $gModel->getChildRow($childSn, '*');

				if($item['is_specified_special']==1)
				{
					return false;
				}
			}
        }

        else if(1==$game_type && 1==$is_specified_special)
        {
            for($i=0; $i<count($data)-1;++$i)
			{
                $game_spec = explode("||",$data[$i]);
                $childSn = $game_spec[0];
                $item = $gModel->getChildRow($childSn, '*');

				if($item['type']!=1)
				{
					return false;
				}
			}
        }
        return true;
    }

    // 축구, 하키, 무 + (오버,언더)
	function checkRule_draw_unov($data, $gModel, $sports) {
		for($i=0; $i<count((array)$data)-1; ++$i)
		{
			$game_spec = explode("||",$data[$i]);
			$childSn = $game_spec[0];
			$i_item = $gModel->getChildRow($childSn, '*');
			$i_item_checkbox_index = $game_spec[1];

			for ( $j = ($i+1) ; $j < count((array)$data)-1 ; $j++ ) {
				$game_spec = explode("||",$data[$j]);
				$childSn = $game_spec[0];
				$j_item = $gModel->getChildRow($childSn, '*');
				$j_item_checkbox_index = $game_spec[1];

				if ( $i_item['type'] == 1 && $i_item_checkbox_index == 1 && $i_item['sport_name'] == $sports ) {
					if ( $i_item['home_team'] == $j_item['home_team'] && $i_item['away_team'] == $j_item['away_team'] && $j_item['type'] == 4
						&& ($j_item_checkbox_index == 0 || $j_item_checkbox_index == 2 ) && $j_item['sport_name'] == $sports ) {
						return false;
					}
				} else if ( $i_item['type'] == 4 && ($i_item_checkbox_index == 0 || $i_item_checkbox_index == 2 )&& $i_item['sport_name'] == $sports ) {
					if ( $i_item['home_team']  == $j_item['home_team'] && $i_item['away_team'] == $j_item['away_team'] && $j_item['type'] == 1 && $j_item_checkbox_index == 1 && $j_item['sport_name'] == $sports ) {
						return false;
					}
				}
			} //-> end FOR J
		} //-> end FOR I
		return true;
	}

	//-> 축구 -> 동일경기 [승무패-승]+[언더오버-오버]
    function checkRule_win_over($data, $gModel) {
        for($i=0; $i<count($data)-1; ++$i)
		{
            $game_spec = explode("||",$data[$i]);
            $childSn = $game_spec[0];
            $i_item = $gModel->getChildRow($childSn, '*');
			$i_item_checkbox_index = $game_spec[1];

            for ( $j = ($i+1) ; $j < count($data)-1 ; $j++ ) {
                $game_spec = explode("||",$data[$j]);
                $childSn = $game_spec[0];
                $j_item = $gModel->getChildRow($childSn, '*');
                $j_item_checkbox_index = $game_spec[1];

                if ( $i_item['type'] == 1 && $i_item_checkbox_index == 0 && $i_item['sport_name'] == "축구" ) {
                    if ( $i_item['home_team'] == $j_item['home_team'] && $i_item['away_team'] == $j_item['away_team'] && $j_item['type'] == 4
						&& $j_item_checkbox_index == 0 && $j_item['sport_name'] == "축구" ) {
                        return false;
                    }
                } else if ( $i_item['type'] == 4 && $i_item_checkbox_index == 0 && $i_item['sport_name'] == "축구" ) {
                    if ( $i_item['home_team']  == $j_item['home_team'] && $i_item['away_team'] == $j_item['away_team'] && $j_item['type'] == 1 && $j_item_checkbox_index == 0 && $j_item['sport_name'] == "축구" ) {
                        return false;
                    }
                }
            } //-> end FOR J
        } //-> end FOR I
        return true;
    }

	//-> 축구 -> 동일경기 [승무패-승]+[언더오버-언더]
    function checkRule_win_under($data, $gModel) {
        for($i=0; $i<count($data)-1; ++$i) {
            $game_spec = explode("||",$data[$i]);
            $childSn = $game_spec[0];
            $i_item = $gModel->getChildRow($childSn, '*');
            $i_item_checkbox_index = $game_spec[1];

            for ( $j = ($i+1) ; $j < count($data)-1 ; $j++ ) {
                $game_spec = explode("||",$data[$j]);
                $childSn = $game_spec[0];
                $j_item = $gModel->getChildRow($childSn, '*');
                $j_item_checkbox_index = $game_spec[1];

                if ( $i_item['type'] == 1 && $i_item_checkbox_index == 0 && $i_item['sport_name'] == "축구" ) {
                    if ( $i_item['home_team'] == $j_item['home_team'] && $i_item['away_team'] == $j_item['away_team'] &&
                        $j_item['type'] == 4 && $j_item_checkbox_index == 2 && $j_item['sport_name'] == "축구" ) {
                        return false;
                    }
                } else if ( $i_item['type'] == 4 && $i_item_checkbox_index == 2 && $i_item['sport_name'] == "축구" ) {
                    if ( $i_item['home_team'] == $j_item['home_team'] && $i_item['away_team'] == $j_item['away_team']  &&
                        $j_item['type'] == 1 && $j_item_checkbox_index == 0 && $j_item['sport_name'] == "축구" ) {
                        return false;
                    }
                }
            } //-> end FOR J
        } //-> end FOR I
        return true;
    }

	//-> 축구 -> 동일경기 [승무패-패]+[언더오버-언더]
    function checkRule_lose_under($data, $gModel) {
        for($i=0; $i<count($data)-1; ++$i) {
            $game_spec = explode("||",$data[$i]);
            $childSn = $game_spec[0];
            $i_item = $gModel->getChildRow($childSn, '*');
            $i_item_checkbox_index = $game_spec[1];

            for ( $j = ($i+1) ; $j < count($data)-1 ; $j++ ) {
                $game_spec = explode("||",$data[$j]);
                $childSn = $game_spec[0];
                $j_item = $gModel->getChildRow($childSn, '*');
                $j_item_checkbox_index = $game_spec[1];

                if ( $i_item['type'] == 1 && $i_item_checkbox_index == 2 && $i_item['sport_name'] == "축구" ) {
                    if ( $i_item['home_team'] == $j_item['home_team'] && $i_item['away_team'] == $j_item['away_team'] &&
                        $j_item['type'] == 4 && $j_item_checkbox_index == 2 && $j_item['sport_name'] == "축구" ) {
                        return false;
                    }
                } else if ( $i_item['type'] == 4 && $i_item_checkbox_index == 2 && $i_item['sport_name'] == "축구" ) {
                    if ( $i_item['home_team'] == $j_item['home_team'] && $i_item['away_team'] == $j_item['away_team'] &&
                        $j_item['type'] == 1 && $j_item_checkbox_index == 2 && $j_item['sport_name'] == "축구" ) {
                        return false;
                    }
                }
            } //-> end FOR J
        } //-> end FOR I
        return true;
    }

    //-> 축구 -> 동일경기 [승무패-패]+[언더오버-언더]
    function checkRule_lose_over($data, $gModel) {
        for($i=0; $i<count($data)-1; ++$i) {
            $game_spec = explode("||",$data[$i]);
            $childSn = $game_spec[0];
            $i_item = $gModel->getChildRow($childSn, '*');
            $i_item_checkbox_index = $game_spec[1];

            for ( $j = ($i+1) ; $j < count($data)-1 ; $j++ ) {
                $game_spec = explode("||",$data[$j]);
                $childSn = $game_spec[0];
                $j_item = $gModel->getChildRow($childSn, '*');
                $j_item_checkbox_index = $game_spec[1];

                if ( $i_item['type'] == 1 && $i_item_checkbox_index == 2 && $i_item['sport_name'] == "축구" ) {
                    if ( $i_item['home_team'] == $j_item['home_team'] && $i_item['away_team'] == $j_item['away_team'] &&
                        $j_item['type'] == 4 && $j_item_checkbox_index == 0 && $j_item['sport_name'] == "축구" ) {
                        return false;
                    }
                } else if ( $i_item['type'] == 4 && $i_item_checkbox_index == 0 && $i_item['sport_name'] == "축구" ) {
                    if ( $i_item['home_team'] == $j_item['home_team'] && $i_item['away_team'] == $j_item['away_team'] &&
                        $j_item['type'] == 1 && $j_item_checkbox_index == 2 && $j_item['sport_name'] == "축구" ) {
                        return false;
                    }
                }
            } //-> end FOR J
        } //-> end FOR I
        return true;
    }

    function checkRule_fb_win_under($data, $gModel) {
        for($i=0; $i<count($data)-1; ++$i) {
            $game_spec = explode("||",$data[$i]);
            $childSn = $game_spec[0];
            $i_item = $gModel->getChildRow($childSn, '*');
            $i_item_checkbox_index = $game_spec[1];

            for ( $j = ($i+1) ; $j < count($data)-1 ; $j++ ) {
                $game_spec = explode("||",$data[$j]);
                $childSn = $game_spec[0];
                $j_item = $gModel->getChildRow($childSn, '*');
                $j_item_checkbox_index = $game_spec[1];

                if ( $i_item['type'] == 1 && $i_item_checkbox_index == 0 && strpos($i_item['home_team'], "1이닝 득점") !== false ) {
                    if ( strpos($i_item['home_team'], $j_item['home_team']) !== false && strpos($i_item['away_team'], $j_item['away_team']) !== false  &&
                        $j_item['type'] == 4 && $j_item_checkbox_index == 2 ) {
                        return false;
                    }
                } else if ( $i_item['type'] == 4 && $i_item_checkbox_index == 2 && strpos($j_item['away_team'], $i_item['away_team']) !== false &&
                    strpos($j_item['home_team'], $i_item['home_team']) !== false ) {
                    if ( strpos($j_item['home_team'], "1이닝 득점") && $j_item['type'] == 1 && $j_item_checkbox_index == 0 ) {
                        return false;
                    }
                }
            } //-> end FOR J
        } //-> end FOR I
        return true;
    }

    function checkRule_fb_win_over($data, $gModel) {
        for($i=0; $i<count($data)-1; ++$i) {
            $game_spec = explode("||",$data[$i]);
            $childSn = $game_spec[0];
            $i_item = $gModel->getChildRow($childSn, '*');
            $i_item_checkbox_index = $game_spec[1];

            for ( $j = ($i+1) ; $j < count($data)-1 ; $j++ ) {
                $game_spec = explode("||",$data[$j]);
                $childSn = $game_spec[0];
                $j_item = $gModel->getChildRow($childSn, '*');
                $j_item_checkbox_index = $game_spec[1];

                if ( $i_item['type'] == 1 && $i_item_checkbox_index == 0 && strpos($i_item['home_team'], "1이닝 득점") !== false ) {
                    if ( strpos($i_item['home_team'], $j_item['home_team']) !== false && strpos($i_item['away_team'], $j_item['away_team']) !== false  &&
                        $j_item['type'] == 4 && $j_item_checkbox_index == 0 ) {
                        return false;
                    }
                } else if ( $i_item['type'] == 4 && $i_item_checkbox_index == 0 && strpos($j_item['away_team'], $i_item['away_team']) !== false &&
                    strpos($j_item['home_team'], $i_item['home_team']) !== false ) {
                    if ( strpos($j_item['home_team'], "1이닝 득점") && $j_item['type'] == 1 && $j_item_checkbox_index == 0 ) {
                        return false;
                    }
                }
            } //-> end FOR J
        } //-> end FOR I
        return true;
    }

    function filterGameName($leagueName)
	{
        $pos = strpos($leagueName,'[', 0);
		if($pos === false)
			return $leagueName;

		$result = substr($leagueName, 0, $pos);
		return trim($result);
	}
}
?>
