<?php

class GameListModel extends Lemon_Model 
{
	/**
	 * GameListModel
	 *--------------------------------------------------------------------
	 *
	 * 게임 목록을 얻어 올때 사용되는 함수,
	 * _function 은 기본함수이며, 이 함수를 가지고 파생을 시켜,
	 * 중복을 피한다.
	 *
	 *--------------------------------------------------------------------
	 * Copyright (C) 
	 */

	//-> 파워볼 결과 목록
	public function getPowerResultList($rowCnt) {
		$sql = "select * from tb_powerball_result order by th desc limit {$rowCnt}";
		return $this->db->exeSql($sql);
	}

	//-> 사다리 마지막 결과 회차.
	public function getSadariLastTh() {
		$sql = "select th from tb_sadari_result order by sn desc limit 1";
		$res = $this->db->exeSql($sql);
		return $res[0]["th"];
	}

	//-> 사다리 그래프 데이터.
	public function getSadariResult() {
		$sql = "select * from tb_sadari_result order by sn desc limit 288";
		return $this->db->exeSql($sql);
	}

    //-> 알라딘 사다리 그래프 데이터.
    public function getAladinResult() {
        $sql = "select resultVal from main_parsing_mubayo2_lsports._result_minigame where gameName = 'aladin' order by sn desc limit 480";
        return $this->db->exeSql($sql);
    }

	//-> 다리다리 마지막 결과 회차.
	public function getDariLastTh() {
		$sql = "select th from tb_daridari_result order by sn desc limit 1";
		$res = $this->db->exeSql($sql);
		return $res[0]["th"];
	}

	//-> 다리다리 그래프 데이터.
	public function getDariResult() {
		$sql = "select * from tb_daridari_result order by sn desc limit 288";
		return $this->db->exeSql($sql);
	}

    //-> 파워사다리 그래프 데이터.
    public function getPowerSadariResult() {
        $sql = "select resultVal from main_parsing_mubayo2_lsports._result_minigame where gameName = 'powersadari' order by sn desc limit 288";
        return $this->db->exeSql($sql);
    }

    //-> 키노사다리 그래프 데이터.
    public function getKenoSadariResult() {
        $sql = "select resultVal from main_parsing_mubayo2_lsports._result_minigame where gameName = 'kenosadari' order by sn desc limit 288";
        return $this->db->exeSql($sql);
    }

    //-> 2다리 그래프 데이터.
    public function get2DariResult() {
        $sql = "select resultVal from main_parsing_mubayo2_lsports._result_minigame where gameName = '2dari' order by sn desc limit 720";
        return $this->db->exeSql($sql);
    }

    //-> 3다리 그래프 데이터.
    public function get3DariResult() {
        $sql = "select resultVal from main_parsing_mubayo2_lsports._result_minigame where gameName = '3dari' order by sn desc limit 488";
        return $this->db->exeSql($sql);
    }

	//▶ 원기준게임목록
 	public function _gameList($where="", $orderby="", $page=0, $page_size=0)
	{
		$sql = "select a.sn as child_sn,a.sport_name,a.league_sn,a.home_team,a.home_score,a.away_team,a.away_score, a.game_code,
						a.win_team,a.handi_winner,a.gameDate,a.gameHour,a.gameTime,a.notice, a.kubun,a.type, a.special, a.is_specified_special,
						b.sn as league_sn, b.lg_img as league_image,b.name as league_name, b.nation_sn, b.alias_name, b.view_style, b.link_url,
						c.sn as sub_child_sn,c.betting_type,c.home_rate,c.draw_rate,c.away_rate, c.result as sub_child_result, c.win, 
						c.home_betid, c.away_betid, c.draw_betid, c.home_line, c.away_line, c.draw_line, c.home_name, c.away_name, c.draw_name, c.base_line, m.mid, m.mname_ko
				from ".$this->db_qz."child  a,".$this->db_qz."league b,".$this->db_qz."subchild c, ".$this->db_qz."markets m 
				where a.view_flag = 1 and a.league_sn = b.lsports_league_sn and a.sn = c.child_sn and c.betting_type = m.mid ".$where;
		
		if($orderby!='')
			$sql.= " order by ".$orderby;
			
		if($page_size!=0)
			$sql.= " limit ".$page.",".$page_size;
		// echo $sql;
		// exit;
		return (array)$this->db->exeSql($sql);
	}

	//▶ 국내형게임목록
	public function _classicGameList($where="", $orderby="", $page=0, $page_size=0)
	{
		$sql = "SELECT
					tb_subchild.*,
					tb_child.`gameDate`,
					tb_child.`gameHour`,
					tb_child.`gameTime`,
					tb_child.`home_team`,
					tb_child.away_team,
					tb_child.`sport_id`,
					tb_child.sport_name,
					tb_child.notice,
					tb_child.special,
					tb_child.`league_sn`,
					tb_child.league_img
				FROM
					tb_subchild
					LEFT JOIN tb_child
					ON tb_subchild.child_sn = tb_child.sn
				WHERE tb_child.sn IN
					(SELECT
						child_sn
					FROM
					(SELECT
						tb_child.sn AS child_sn
					FROM
						tb_child
					WHERE CONCAT(tb_child.gameDate, ' ', tb_child.gameHour, ':', tb_child.gameTime, ':00') > '" . date("Y-m-d H:i:s", time() + 1800) . "' 
						AND (tb_child.special = 1 OR tb_child.special = 2) AND tb_child.status = 1 
						AND tb_child.user_view_flag = 1 AND tb_child.kubun = 0 AND tb_child.sport_name != '이벤트' 
				" . $where . " 
					ORDER BY tb_child.`gameDate`,
						tb_child.`gameHour`,
						tb_child.`gameTime`
					LIMIT 40 OFFSET " . 40 * $page_size . ") tbl)
					AND tb_subchild.betting_type in (1,2,3,28,52,226,342,866) 
					AND tb_subchild.status = 1
					AND tb_subchild.live = 0  
				ORDER BY tb_child.`gameDate`,
						tb_child.`gameHour`,
						tb_child.`gameTime`,
						tb_child.notice,
						tb_child.home_team,
						tb_subchild.betting_type,
						tb_subchild.home_line,
						tb_subchild.home_name ";
		// $sql = "select a.sn as child_sn,a.sport_name,a.league_sn,a.home_team,a.home_score,a.away_team,a.away_score, a.game_code,
		// 				a.win_team,a.handi_winner,a.gameDate,a.gameHour,a.gameTime,a.notice, a.kubun,a.type, a.special, a.is_specified_special,
		// 				b.sn as league_sn, b.lg_img as league_image,b.name as league_name, b.nation_sn, b.alias_name, b.view_style, b.link_url,
		// 				c.sn as sub_child_sn,c.betting_type,c.home_rate,c.draw_rate,c.away_rate, c.result as sub_child_result, c.win, 
		// 				c.home_betid, c.away_betid, c.draw_betid, c.home_line, c.away_line, c.draw_line, c.home_name, c.away_name, c.draw_name, c.base_line, m.mid, m.mname_ko
		// 		from ".$this->db_qz."child  a,".$this->db_qz."league b,".$this->db_qz."subchild c, ".$this->db_qz."markets m 
		// 		where a.view_flag = 1 and a.league_sn = b.sn and a.sn = c.child_sn and c.betting_type = m.mid ".$where;
		
		// if($orderby!='')
		// 	$sql.= " order by ".$orderby;
			
		// //if($page_size!=0)
		// $sql.= " LIMIT ".$page." OFFSET ". $page * $page_size;
		// echo $sql;
		// exit;
		return (array)$this->db->exeSql($sql);
	}

	//▶ 다기준게임목록
	public function _gameMultiList($where="", $orderby="", $page = 100, $page_size=0)
	{
		$sql = "SELECT  a.sn as child_sn, a.game_sn, a.sport_name, a.league_sn, a.home_team, IFNULL(a.home_score, 0) as home_score, a.away_team, IFNULL(a.away_score, 0) as away_score, 
						a.gameDate, a.gameHour, a.gameTime, a.notice, a.special, a.is_specified_special,
						b.sn as league_sn, IFNULL(b.lg_img, '') as league_image, b.name as league_name, b.nation_sn, b.alias_name, b.view_style, b.link_url, b.kind
				FROM ".$this->db_qz."child a,".$this->db_qz."league b WHERE a.league_sn = b.sn AND b.kind != '이벤트' ".$where;
				
		if($orderby!='')
			$sql.= " ORDER BY ".$orderby;
			
		$sql.= " LIMIT ".$page." OFFSET ". $page * $page_size;
		// echo $sql;
		// exit;

		$res = $this->db->exeSql($sql);
		
		return (array)$res;
	}

	public function _excuteQuery($strQuery)
	{
		$res = $this->db->exeSql($strQuery);
		return (array)$res;
	}

	public function _gameLiveList($where="", $orderby="", $page = 100, $page_size=0)
	{
		$sql = "SELECT  a.sn as child_sn, a.game_sn, a.sport_name, a.league_sn, a.home_team, IFNULL(a.home_score, 0) as home_score, a.away_team, IFNULL(a.away_score, 0) as away_score, 
						a.gameDate, a.gameHour, a.gameTime, a.notice, a.special, a.is_specified_special, a.game_time, 
						b.sn as league_sn, IFNULL(b.lg_img, '') as league_image, b.name as league_name, b.nation_sn, b.alias_name, b.view_style, b.link_url, b.kind
				FROM ".$this->db_qz."child a,".$this->db_qz."league b WHERE a.league_sn = b.lsports_league_sn AND b.kind != '이벤트' ".$where;
				
		if($orderby!='')
			$sql.= " ORDER BY ".$orderby;
			
		$sql.= " LIMIT ".$page." OFFSET ". $page * $page_size;
		// echo $sql;
		// exit;

		$res = $this->db->exeSql($sql);
		
		return (array)$res;
	}


	// 다기준 Bonus 목록 얻어오기 (페이지 로딩)
	public function getMultiBonusList($special) {
		$sql = "SELECT 
					a.sn,
					a.child_sn,
					a.home_rate,
					a.away_rate,
					a.draw_rate,
					a.betting_type,
					a.home_betid,
					b.sport_name,
					b.league_sn,
					b.home_team,
					b.away_team,
					b.gameDate, 
					b.gameHour,
					b.gameTime 
				FROM
					tb_subchild a 
					INNER JOIN 
					(SELECT 
						sn,
						sport_name,
						league_sn,
						home_team,
						away_team,
						gameDate,
						gameHour,
						gameTime 
					FROM
						tb_child
					WHERE sport_name = '이벤트' and special = " . $special . ") AS b 
					ON a.child_sn = b.sn 
				ORDER BY b.home_team ";
		
		// echo $sql;
		// exit;

		$res = $this->db->exeSql($sql);
		
		return $res;
	}

	// 다기준 Bonus의 Child 목록 얻어오기 (Ajax)
	public function getMultiBonusListAjax() {
		$sql = "SELECT  a.sn as child_sn, a.game_sn, a.sport_name, a.league_sn, a.home_team, a.home_score, a.away_team,a.away_score, 
						a.gameDate, a.gameHour, a.gameTime, a.notice, a.special, a.is_specified_special,
						b.sn as league_sn, b.lg_img as league_image, b.name as league_name, b.nation_sn, b.alias_name, b.view_style, b.link_url, b.kind
				FROM ".$this->db_qz."child_m a,".$this->db_qz."league b WHERE a.league_sn = b.sn AND b.kind = '이벤트' ORDER BY a.home_team";
		
		// echo $sql;
		// exit;

		$res = $this->db->exeSql($sql);
		
		return $res;
	}

	//▶ 다기준 한개 게임정보
	public function getMultiGameItem($child_sn = 0, $betting_type = 0, $live = 0)
	{
		$sql = "SELECT
					a.sn AS child_sn,
					a.game_sn,
					a.sport_name,
					a.league_sn,
					a.home_team,
					a.home_score,
					a.away_team,
					a.away_score,
					a.gameDate,
					a.gameHour,
					a.gameTime,
					a.notice,
					a.special,
					a.is_specified_special,
					a.league_img AS league_image,
					a.notice AS league_name,
					c.sn,
					c.betting_type,
					c.home_rate,
					c.draw_rate,
					c.away_rate,
					c.home_betid,
					c.away_betid,
					c.draw_betid,
					c.home_line,
					c.away_line,
					c.draw_line,
					c.home_name,
					c.away_name,
					c.draw_name
				FROM
					tb_child a INNER JOIN tb_subchild c ON a.sn = c.child_sn
				WHERE  a.sn = " . $child_sn . "
					AND c.status = 1
					AND c.betting_type != " . $betting_type . "
					AND c.live = " . $live . "
				ORDER BY a.gameDate ASC,
					a.gameHour ASC,
					a.gameTime ASC,
					a.home_team ASC,
					c.betting_type ASC,
					c.home_line ASC,
					c.home_name ASC ";
		
		$res = $this->db->exeSql($sql);
		
		return $res;
	}

	public function getLiveGameItem($child_sn = 0, $betting_type = 0)
	{
		$sql = "SELECT
					a.sn AS child_sn,
					a.game_sn,
					a.sport_name,
					a.league_sn,
					a.home_team,
					a.home_score,
					a.away_team,
					a.away_score,
					a.gameDate,
					a.gameHour,
					a.gameTime,
					a.notice,
					a.special,
					a.is_specified_special,
					a.league_img AS league_image,
					a.notice AS league_name,
					c.sn,
					c.betting_type,
					c.home_rate,
					c.draw_rate,
					c.away_rate,
					c.home_betid,
					c.away_betid,
					c.draw_betid,
					c.home_line,
					c.away_line,
					c.draw_line,
					c.home_name,
					c.away_name,
					c.draw_name
				FROM
					tb_child a INNER JOIN tb_subchild c ON a.sn = c.child_sn
				WHERE  a.sn = " . $child_sn . "
					AND c.betting_type != " . $betting_type . "
				ORDER BY a.gameDate ASC,
					a.gameHour ASC,
					a.gameTime ASC,
					a.home_team ASC,
					c.betting_type ASC,
					c.home_line ASC,
					c.home_name ASC ";

		$res = $this->db->exeSql($sql);
		
		return $res;
	}


	//▶ 다기준게임목록 개수
	public function _gameMultiListTotal($where="")
	{
		$sql = "SELECT  COUNT(*) as cnt
				FROM ".$this->db_qz."child a,".$this->db_qz."league b WHERE a.league_sn = b.sn ".$where;
		
		$res = $this->db->exeSql($sql);
		
		if(count($res) > 0)
			return $res[0]['cnt'];
		
		return 0;
	}


	//▶ 매 경기에 있는 다기준 항목의 개수 얻어오기
	public function getChildrenCount($where="")
	{
		$sql = "SELECT COUNT(*) as cnt
				FROM ".$this->db_qz."child_m a INNER JOIN ".$this->db_qz."subchild_m b
				ON	 a.sn = b.child_sn
				WHERE b.view_flag = 1 ".$where;
		
		//echo $sql . "<br>";
		//exit;
		$res = $this->db->exeSql($sql);
		
		if(count($res) > 0) 
			return $res[0]['cnt'];
		
		return 0;
	}

	//-> 다기준 매 경기에 있는 home_rate, away_rate, draw_rate, count 얻어오기
	public function getSubChildInfo($child_sn) 
	{
		$sql = "SELECT tb_temp.*, tb_markets.`mname_ko` 
				FROM (SELECT  a.sn, 
					a.betting_type, 
					a.home_rate, 
					a.draw_rate, 
					a.away_rate, 
					a.home_betid, 
					a.away_betid, 
					a.draw_betid, 
					a.home_line, 
					a.away_line, 
					a.draw_line, 
					a.home_name, 
					a.away_name, 
					a.draw_name, 
					(SELECT COUNT(temp.betting_type)-1 FROM (SELECT betting_type FROM tb_subchild WHERE child_sn = " . $child_sn . " GROUP BY betting_type) temp) AS cnt 
				FROM tb_subchild a 
				WHERE a.child_sn = " . $child_sn . " AND a.status = 1 ) AS tb_temp 
				INNER JOIN tb_markets ON tb_temp.betting_type = tb_markets.mid 
				WHERE tb_markets.mname_ko LIKE '%승%' AND  tb_markets.mid != 427
				LIMIT 1";
		// $sql = "SELECT  a.sn, a.betting_type, a.home_rate, a.draw_rate, a.away_rate, a.home_betid, a.away_betid, a.draw_betid, a.home_line, a.away_line, a.draw_line, 
		// 				a.home_name, a.away_name, a.draw_name, m.mname_ko, (SELECT COUNT(temp.betting_type)-1 FROM (SELECT betting_type FROM tb_subchild WHERE child_sn = " . $child_sn . " GROUP BY betting_type) temp) AS cnt 
		// 		FROM tb_subchild a LEFT JOIN tb_markets m ON a.betting_type = m.mid
		// 		WHERE a.child_sn = " . $child_sn . " AND m.mname_ko LIKE '%승%' AND a.status = 1 AND  m.mid != 427
		// 		ORDER BY m.mname_ko ASC
		// 		LIMIT 1;";
		// echo $sql;
		// exit;
		$res = $this->db->exeSql($sql);
		
		if(count((array)$res) > 0) 
			return $res[0];
		
		return [];
	}

	// 원기준 Prematch
    public function _getLeagueGameList()
    {
        $sql = "select a.sport_name,a.home_team,a.away_team, 
			           a.gameDate,a.gameHour,a.gameTime, b.name as league_name, b.lg_img
                from ".$this->db_qz."child a,".$this->db_qz."league b
                where a.view_flag = 1 
                and a.league_sn=b.sn 
                and a.user_view_flag=1
                and a.kubun=0
				and a.home_team not like '%보너스%'
                and concat(a.gameDate,' ',a.gameHour, ':', a.gameTime, ':00') > NOW()
                group by league_name
                order by a.gameDate asc, a.gameHour asc, a.gameTime asc, a.home_team limit 4";

        return $this->db->exeSql($sql);
    }

	// 다기준 Prematch
	public function _getLeagueGameListMulti()
    {
        $sql = "select a.sport_name, a.home_team, a.away_team, 
			           a.gameDate, a.gameHour, a.gameTime, b.name as league_name, b.lg_img
                from ".$this->db_qz."child a,".$this->db_qz."league b 
                where a.league_sn=b.sn 
                and concat(a.gameDate,' ',a.gameHour, ':', a.gameTime, ':00') > NOW()
                group by league_name
                order by a.gameDate asc, a.gameHour asc, a.gameTime asc, a.home_team asc limit 4 offset 4";

        return $this->db->exeSql($sql);
    }

    public function _getCatagoryGame($kind, $date)
    {
        $sql = "select a.sport_name,a.home_team,a.away_team, 
			           a.gameDate,a.gameHour,a.gameTime, b.name as league_name, 
			           c.home_rate,c.draw_rate,c.away_rate 
                from ".$this->db_qz."child  a,".$this->db_qz."league b,".$this->db_qz."subchild c
                where a.view_flag = 1 
                and a.league_sn=b.sn 
                and a.sn=c.child_sn
                and a.sport_name = '".$kind."' 
                and a.user_view_flag=1 
                and a.gameDate >= '".$date."' 
                and a.kubun=0  
                and concat(a.gameDate,' ',a.gameHour, ':', a.gameTime, ':00') > NOW()
                order by a.gameDate asc, a.gameHour asc, a.gameTime asc, a.home_team, a.type asc limit 1";

        return $this->db->exeSql($sql);
    }

    public function _getCatagoryGame_last($kind)
    {
        $sql = "select a.sport_name,a.home_team,a.away_team, 
			           a.gameDate,a.gameHour,a.gameTime, b.name as league_name, 
			           c.home_rate,c.draw_rate,c.away_rate 
                from ".$this->db_qz."child  a,".$this->db_qz."league b,".$this->db_qz."subchild c
                where a.view_flag = 1 
                and a.league_sn=b.sn 
                and a.sn=c.child_sn
                and a.sport_name = '".$kind."' 
                and a.user_view_flag=1
                order by a.gameDate desc, a.gameHour desc, a.gameTime desc, a.home_team, a.type desc limit 1";

        return $this->db->exeSql($sql);
    }

	public function _gameResult()
    {
        $sql = "select * from tb_child
                where (home_score is not null or home_score != '')
                and game_sn is not null
                and sport_name != '가상축구'
                group by home_team
                order by sn desc
                limit 10";
        return $this->db->exeSql($sql);
    }
    public function _gameList2($where="", $orderby="", $groupby ="", $page=0, $page_size=0)
    {
        $sql = "select a.sn as child_sn,a.sport_name,a.league_sn,a.home_team,a.home_score,a.away_team,a.away_score, a.game_code,
								a.win_team,a.handi_winner,a.gameDate,a.gameHour,a.gameTime,a.notice, a.kubun,a.type, a.special, a.is_specified_special,
								b.sn as league_sn, b.lg_img as league_image,b.name as league_name, b.nation_sn, b.alias_name, b.view_style, b.link_url,
								c.sn as sub_child_sn,c.betting_type,c.home_rate,c.draw_rate,c.away_rate, c.result as sub_child_result, c.win
						from ".$this->db_qz."child  a,".$this->db_qz."league b,".$this->db_qz."subchild c
						where a.view_flag = 1 and a.league_sn=b.sn and a.sn=c.child_sn ".$where;

        if($orderby!='')
            $sql.= " group by ".$groupby;

        if($orderby!='')
            $sql.= " order by ".$orderby;

        if($page_size!=0)
            $sql.= " limit ".$page.",".$page_size;

        return $this->db->exeSql($sql);
    }

	public function _gameListTotal($where="")
	{
		$sql = "select count(*) as cnt
						from ".$this->db_qz."child  a,".$this->db_qz."league b,".$this->db_qz."subchild c
						where a.view_flag = 1 and a.league_sn=b.sn and a.sn=c.child_sn ".$where;

		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 게임목록 총합_gameList
	public function Total($where="")
	{
		$sql = "select count(*) as cnt
							from ".$this->db_qz."child  a,".$this->db_qz."league b,".$this->db_qz."subchild c,".$this->db_qz."nation d
						where a.view_flag = 1 and a.league_sn=b.sn and a.sn=c.child_sn and b.nation_sn=d.sn ".$where;
		
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 기준점 변경에 따른 재계산
	//return value 1=홈팀승,2=원정승,3=무승부,4=취소
	function calcResult($gameType, $selectDrawRate, $homeScore, $awayScore)
	{
		if($gameType==2) // 핸디캡
	 	{
	 		if(($homeScore+$selectDrawRate) > $awayScore)				$winCode = 1;
	 		else if(($homeScore+$selectDrawRate) < $awayScore)		$winCode = 2;
	 		else if(($homeScore+$selectDrawRate) == $awayScore)	$winCode = 4;
		}
		else if($gameType==4) // 언더오버
	 	{
	 		if(($homeScore+$awayScore)==$selectDrawRate) $winCode = 4;
	 		else
	 			$winCode = (($homeScore+$awayScore) > $selectDrawRate) ? 1:2;
		}
		return $winCode;
	}

	//▶ 기준점 변경에 따른 재계산
	//return value 1=홈팀승,2=원정승,3=무승부,4=취소
	function calcResultMulti($sport_name, $gameType, $point, $selectDrawRate, $homeScore, $awayScore, $home_half_time_score, $away_half_time_score,
							$home_2nd_half_time_score, $away_2nd_half_time_score, $home_full_time_score, $away_full_time_score,
							$home_over_time_score, $away_over_time_score, $home_1_time_score, $away_1_time_score,
							$home_2_time_score, $away_2_time_score, $home_3_time_score, $away_3_time_score,
							$home_4_time_score, $away_4_time_score, $home_5_time_score, $away_5_time_score, $home_6_time_score, $away_6_time_score,
							$home_7_time_score, $away_7_time_score, $home_8_time_score, $away_8_time_score, $home_9_time_score, $away_9_time_score)
	{
		switch ($sport_name) {
			case "축구":
				switch($gameType) {
					case "1": // 승패
						if( $homeScore > $awayScore )						$winCode = 1;
						else if ( $homeScore < $awayScore )					$winCode = 2;
						break;
					case "2": // 핸디캡
					case "11":
						if(($homeScore+$selectDrawRate) > $awayScore)		    $winCode = 1; // 홈승
						else if(($homeScore+$selectDrawRate) < $awayScore)	$winCode = 2; // 원정승
						else if(($homeScore+$selectDrawRate) == $awayScore)	$winCode = 4; // 적특
						break;
					case "3": // 언더오버
					case "12":
						if(($homeScore+$awayScore) == $selectDrawRate)        $winCode = 4;
						else
							$winCode = (($homeScore+$awayScore) > $selectDrawRate) ? 2 : 1;
						break;
					case "4": // 승무패
						if($homeScore == $awayScore)
						{
							if($selectDrawRate=="1.00") $winCode = 4;
							else 										     $winCode = 3; // 무승부
						} else if($homeScore > $awayScore)					{$winCode = 1;}
						else											    {$winCode = 2;}
						break;
					case "5": // 전반전 승무패
						if($home_half_time_score == $away_half_time_score)
						{
							if($selectDrawRate=="1.00")                        $winCode = 4;
							else 										                            $winCode = 3; // 무승부
						} else if($home_half_time_score > $away_half_time_score)					{$winCode = 1;}
						else											                            {$winCode = 2;}
						break;
					case "6": // 후반전 승무패
						if($home_2nd_half_time_score == $away_2nd_half_time_score)
						{
							if($selectDrawRate=="1.00")                                $winCode = 4;
						else 										                                        $winCode = 3; // 무승부
						} else if($home_2nd_half_time_score > $away_2nd_half_time_score)					{$winCode = 1;}
						else											                                    {$winCode = 2;}
						break;
					case "7": // 전반전 언더오버
						if(($home_half_time_score + $away_half_time_score) == $selectDrawRate)                    $winCode = 4;
						else
							$winCode = (($home_half_time_score + $away_half_time_score) > $selectDrawRate) ? 2 : 1;
						break;
					case "8": // 후반전 언더오버
						if(($home_2nd_half_time_score + $away_2nd_half_time_score) == $selectDrawRate)        $winCode = 4;
						else
							$winCode = (($home_2nd_half_time_score + $away_2nd_half_time_score) > $selectDrawRate) ? 2 : 1;
						break;
					case "9": // 득점홀짝
						if(($homeScore + $awayScore) % 2 == 1) 				                        $winCode = 1;
						else 												                        $winCode = 2;
						break;
					case "10": // 전반전 홀짝
						if(($home_half_time_score + $away_half_time_score) % 2 == 1) 				$winCode = 1;
						else 												                        $winCode = 2;
						break;
					case "13": // 정확한 스코어
						$result_point = $homeScore . "-" . $awayScore;
						if( $result_point == $point )                       $winCode = 1;
						else 												$winCode = 2;
						break;
				}
				break;
			case "농구":
				switch($gameType) {
					case "1": // 승패
						if( $homeScore > $awayScore )						$winCode = 1;
						else if ( $homeScore < $awayScore )					$winCode = 2;
						break;
					case "2": // 핸디캡
					case "16":
						if(($homeScore+$selectDrawRate) > $awayScore)		$winCode = 1;
						else if(($homeScore+$selectDrawRate) < $awayScore)	$winCode = 2;
						else if(($homeScore+$selectDrawRate) == $awayScore)	$winCode = 4;
						break;
					case "3": // 언더오버
					case "17":
						if(($homeScore+$awayScore)==$selectDrawRate)        $winCode = 4;
						else
							$winCode = (($homeScore+$awayScore) > $selectDrawRate) ? 2 : 1;
						break;
					case "4": // 1쿼터 승무패
						if($home_1_time_score == $away_1_time_score)
						{
							if($selectDrawRate=="1.00") $winCode = 4;
							else 										     $winCode = 3;
						} else if($home_1_time_score > $away_1_time_score)					{$winCode = 1;}
						else											    {$winCode = 2;}
						break;
					case "5": // 2쿼터 승무패 
						if($home_2_time_score == $away_2_time_score)
						{
							if($selectDrawRate=="1.00") $winCode = 4;
							else 										     $winCode = 3;
						} else if($home_2_time_score > $away_2_time_score)					{$winCode = 1;}
						else											    {$winCode = 2;}
						break;
					case "6": // 3쿼터 승무패
						if($home_3_time_score == $away_3_time_score)
						{
							if($selectDrawRate=="1.00") $winCode = 4;
							else 										     $winCode = 3;
						} else if($home_3_time_score > $away_3_time_score)					{$winCode = 1;}
						else											    {$winCode = 2;}
						break;
					case "7": // 4쿼터 승무패
						if($home_4_time_score == $away_4_time_score)
						{
							if($selectDrawRate=="1.00") $winCode = 4;
							else 										     $winCode = 3;
						} else if($home_4_time_score > $away_4_time_score)					{$winCode = 1;}
						else											    {$winCode = 2;}
						break;
					case "8": // 1쿼터 핸디캡
						if(($home_1_time_score+$selectDrawRate) > $away_1_time_score)		$winCode = 1;
						else if(($home_1_time_score+$selectDrawRate) < $away_1_time_score)	$winCode = 2;
						else if(($home_1_time_score+$selectDrawRate) == $away_1_time_score)	$winCode = 4;
						break;
					case "9": // 2쿼터 핸디캡
						if(($home_2_time_score+$selectDrawRate) > $away_2_time_score)		$winCode = 1;
						else if(($home_2_time_score+$selectDrawRate) < $away_2_time_score)	$winCode = 2;
						else if(($home_2_time_score+$selectDrawRate) == $away_2_time_score)	$winCode = 4;
						break;
					case "10": // 3쿼터 핸디캡
						if(($home_3_time_score+$selectDrawRate) > $away_3_time_score)		$winCode = 1;
						else if(($home_3_time_score+$selectDrawRate) < $away_3_time_score)	$winCode = 2;
						else if(($home_3_time_score+$selectDrawRate) == $away_3_time_score)	$winCode = 4;
						break;
					case "11": // 4쿼터 핸디캡
						if(($home_4_time_score+$selectDrawRate) > $away_4_time_score)		$winCode = 1;
						else if(($home_4_time_score+$selectDrawRate) < $away_4_time_score)	$winCode = 2;
						else if(($home_4_time_score+$selectDrawRate) == $away_4_time_score)	$winCode = 4;
						break;
					case "12": // 1쿼터 언더오버
						if(($home_1_time_score+$away_1_time_score)==$selectDrawRate)        $winCode = 4;
						else
							$winCode = (($home_1_time_score+$away_1_time_score) > $selectDrawRate) ? 2 : 1;
						break;
					case "13": // 2쿼터 언더오버
						if(($home_2_time_score+$away_2_time_score)==$selectDrawRate)        $winCode = 4;
						else
							$winCode = (($home_2_time_score+$away_2_time_score) > $selectDrawRate) ? 2 : 1;
						break;
					case "14": // 3쿼터 언더오버
						if(($home_3_time_score+$away_3_time_score)==$selectDrawRate)        $winCode = 4;
						else
							$winCode = (($home_3_time_score+$away_3_time_score) > $selectDrawRate) ? 2 : 1;
						break;
					case "15": // 4쿼터 언더오버
						if(($home_4_time_score+$away_4_time_score)==$selectDrawRate)        $winCode = 4;
						else
							$winCode = (($home_4_time_score+$away_4_time_score) > $selectDrawRate) ? 2 : 1;
						break;
				}
				break;
			case "배구":
				switch($gameType) {
					case "1": // 승패
						if( $homeScore > $awayScore )						$winCode = 1;
						else if ( $homeScore < $awayScore )					$winCode = 2;
						break;
					case "2": // 핸디캡
						if(($homeScore+$selectDrawRate) > $awayScore)		$winCode = 1;
						else if(($homeScore+$selectDrawRate) < $awayScore)	$winCode = 2;
						else if(($homeScore+$selectDrawRate) == $awayScore)	$winCode = 4;
						break;
					case "3": // 언더오버
						if(($homeScore+$awayScore)==$selectDrawRate)        $winCode = 4;
						else
							$winCode = (($homeScore+$awayScore) > $selectDrawRate) ? 2 : 1;
						break;
					case "4": // 홀짝
						if(($homeScore+$awayScore) % 2 == 1) 				$winCode = 1;
						else 												$winCode = 2;
						break;
					case "5": // 1세트 홀짝
						if(($home_1_time_score+$away_1_time_score) % 2 == 1) 				$winCode = 1;
						else 												$winCode = 2;
						break;
					case "6": // 정확한 스코어
						$result_point = $homeScore . "-" . $awayScore;
						if( $result_point == $point )                       $winCode = 1;
						else 												$winCode = 2;
						break;
				}
				break;
			case "야구":
				switch($gameType) {
					case "1": // 승패
						if( $homeScore > $awayScore )						$winCode = 1;
						else if ( $homeScore < $awayScore )					$winCode = 2;
						break;
					case "2": // 핸디캡
					case "11":
						if(($homeScore+$selectDrawRate) > $awayScore)		$winCode = 1;
						else if(($homeScore+$selectDrawRate) < $awayScore)	$winCode = 2;
						else if(($homeScore+$selectDrawRate) == $awayScore)	$winCode = 4;
						break;
					case "3": // 언더오버
					case "12":
						if(($homeScore+$awayScore)==$selectDrawRate)        $winCode = 4;
						else
							$winCode = (($homeScore+$awayScore) > $selectDrawRate) ? 2 : 1;
						break;
					case "4": // 1이닝 승무패
						if($homeScore==$awayScore)
						{
							if($selectDrawRate=="1.00") $winCode = 4;
							else 										     $winCode = 3;
						} else if($homeScore > $awayScore)					{$winCode = 1;}
						else											    {$winCode = 2;}
						break;
					case "5": // 3이닝 합계 핸디캡 
						if ( ($home_1_time_score + $home_2_time_score + $home_3_time_score + $selectDrawRate) > ($away_1_time_score + $away_2_time_score + $away_3_time_score) ) {
							$winCode = 1;
						} else if( ($home_1_time_score + $home_2_time_score + $home_3_time_score + $selectDrawRate) < ($away_1_time_score + $away_2_time_score + $away_3_time_score) ) {
							$winCode = 2;
						} else {
							$winCode = 4;
						}
						break;
					case "6": // 5이닝 합계 핸디캡
						if ( ($home_1_time_score + $home_2_time_score + $home_3_time_score + $home_4_time_score + $home_5_time_score + $selectDrawRate) > ($away_1_time_score + $away_2_time_score + $away_3_time_score + $away_4_time_score + $away_5_time_score) ) {
							$winCode = 1;
						} else if( ($home_1_time_score + $home_2_time_score + $home_3_time_score + $home_4_time_score + $home_5_time_score + $selectDrawRate) < ($away_1_time_score + $away_2_time_score + $away_3_time_score + $away_4_time_score + $away_5_time_score) ) {
							$winCode = 2;
						} else {
							$winCode = 4;
						}
						break;
					case "7": // 7이닝 합계 핸디캡
						if ( ($home_1_time_score + $home_2_time_score + $home_3_time_score + $home_4_time_score + $home_5_time_score + $home_6_time_score + $home_7_time_score + $selectDrawRate) > ($away_1_time_score + $away_2_time_score + $away_3_time_score + $away_4_time_score + $away_5_time_score + $away_6_time_score + $away_7_time_score) ) {
							$winCode = 1;
						} else if( ($home_1_time_score + $home_2_time_score + $home_3_time_score + $home_4_time_score + $home_5_time_score + $home_6_time_score + $home_7_time_score + $selectDrawRate) < ($away_1_time_score + $away_2_time_score + $away_3_time_score + $away_4_time_score + $away_5_time_score + $away_6_time_score + $away_7_time_score) ) {
							$winCode = 2;
						} else {
							$winCode = 4;
						}
						break;
					case "8": // 3이닝 합계 언더오버
						if ( ($home_1_time_score + $home_2_time_score + $home_3_time_score + $away_1_time_score + $away_2_time_score + $away_3_time_score) < $selectDrawRate ) {
							$winCode = 1;
						} else if( ($home_1_time_score + $home_2_time_score + $home_3_time_score + $away_1_time_score + $away_2_time_score + $away_3_time_score) > $selectDrawRate ) {
							$winCode = 2;
						} else {
							$winCode = 4;
						}
						break;
					case "9": // 5이닝 합계 언더오버
						if ( ($home_1_time_score + $home_2_time_score + $home_3_time_score + $home_4_time_score + $home_5_time_score + $away_1_time_score + $away_2_time_score + $away_3_time_score + $away_4_time_score + $away_5_time_score) < $selectDrawRate ) {
							$winCode = 1;
						} else if( ($home_1_time_score + $home_2_time_score + $home_3_time_score + $home_4_time_score + $home_5_time_score + $away_1_time_score + $away_2_time_score + $away_3_time_score + $away_4_time_score + $away_5_time_score) > $selectDrawRate ) {
							$winCode = 2;
						} else {
							$winCode = 4;
						}
						break;
					case "10": // 7이닝 합계 언더오버
						if ( ($home_1_time_score + $home_2_time_score + $home_3_time_score + $home_4_time_score + $home_5_time_score + $home_6_time_score + $home_7_time_score + $away_1_time_score + $away_2_time_score + $away_3_time_score + $away_4_time_score + $away_5_time_score + $away_6_time_score + $away_7_time_score) < $selectDrawRate ) {
							$winCode = 1;
						} else if( ($home_1_time_score + $home_2_time_score + $home_3_time_score + $home_4_time_score + $home_5_time_score + $home_6_time_score + $home_7_time_score + $away_1_time_score + $away_2_time_score + $away_3_time_score + $away_4_time_score + $away_5_time_score + $away_6_time_score + $away_7_time_score) > $selectDrawRate ) {
							$winCode = 2;
						} else {
							$winCode = 4;
						}
						break;
				}
				break;
			case "아이스하키":
				switch($gameType) {
					case "1": // 승패
						if( $homeScore > $awayScore )						$winCode = 1;
						else if ( $homeScore < $awayScore )					$winCode = 2;
						break;
					case "2": // 핸디캡
						if(($homeScore+$selectDrawRate) > $awayScore)		$winCode = 1;
						else if(($homeScore+$selectDrawRate) < $awayScore)	$winCode = 2;
						else if(($homeScore+$selectDrawRate) == $awayScore)	$winCode = 4;
						break;
					case "3": // 언더오버
						if(($homeScore+$awayScore)==$selectDrawRate)        $winCode = 4;
						else
							$winCode = (($homeScore+$awayScore) > $selectDrawRate) ? 2 : 1;
						break;
					case "4": // 승무패
						if($homeScore==$awayScore)
						{
							if($selectDrawRate=="1.00") $winCode = 4;
							else 										     $winCode = 3;
						} else if($homeScore > $awayScore)					{$winCode = 1;}
						else											    {$winCode = 2;}
						break;
					case "5": // 1피리어드 승패
						if( $home_1_time_score > $away_1_time_score )						$winCode = 1;
						else if ( $home_1_time_score < $away_1_time_score )					$winCode = 2;
						break;
					case "6": // 1피리어드 승무패
						if($home_1_time_score == $away_1_time_score)
						{
							if($selectDrawRate=="1.00") $winCode = 4;
							else 										     $winCode = 3;
						} else if($home_1_time_score > $away_1_time_score)					{$winCode = 1;}
						else											    {$winCode = 2;}
						break;
					case "7": // 1피리어드 핸디캡
						if(($home_1_time_score + $selectDrawRate) > $away_1_time_score)		$winCode = 1;
						else if(($home_1_time_score + $selectDrawRate) < $away_1_time_score)	$winCode = 2;
						else if(($home_1_time_score + $selectDrawRate) == $away_1_time_score)	$winCode = 4;
						break;
					case "8": // 1피리어드 언더오버
						if(($home_1_time_score + $away_1_time_score) == $selectDrawRate)        $winCode = 4;
						else
							$winCode = (($home_1_time_score + $away_1_time_score) > $selectDrawRate) ? 2 : 1;
						break;
				}
				break;	
		}
		
		return $winCode;
	}
	
	//▶ 배팅목록
	public function _bettingList($memberSn='', $page=0, $page_size=0, $state=-1, $event=0, $beginDate='', $endDate='', $orderby='', $bettingNo='', $specialFlag='')
	{
		$sql = "select a.betting_no,a.regdate,a.betting_cnt,a.result_rate,a.betting_money,a.result, a.bet_date,
				d.sn as child_sn, a.result_money 
				from ".$this->db_qz."game_cart a,".$this->db_qz."game_betting b,".$this->db_qz."subchild c,".$this->db_qz."child d
				where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn 
				and a.logo='".$this->logo."' and a.user_del<>'Y' and a.kubun ='Y'";

		//where			
		if($beginDate!="" && $endDate!="") 	{$sql.=" and (a.bet_date between '".$beginDate."' and '".$endDate."') ";}
		if($memberSn!='')		{$sql.=" and a.member_sn=".$memberSn;}

		if ( $specialFlag != "all" ) {
			$sql.=" and d.special = '{$specialFlag}' ";
		}

		//진행중, 종료
		if($state==0)				{$sql.=" and a.result=0 ";}
		else if($state==1)	{$sql.=" and a.result>0 ";}
		else if($state==10)	{$sql.=" and a.result=1 ";}
		else if($state==11)	{$sql.=" and a.result=2 ";}

		if($bettingNo!='')	{$sql.=" and a.betting_no='".$bettingNo."'";}

		$sql.= " group by a.betting_no ";

		//order by, limit
		$sql.=  " order by a.regdate desc";
		if($page_size > 0)	
		{
			$sql.= " limit ".($page * $page_size).",".$page_size;
		}
		// echo $type;
		// exit;
		//excute
		$rs = $this->db->exeSql($sql);

		$itemList = array();
		if(is_array($rs) && count($rs) > 0) {
			for($i=0; $i<count($rs); ++$i)
			{
				$bettingNo = $rs[$i]["betting_no"];

				$sql = "SELECT tb_temp.*, tb_markets.mname_ko FROM (select a.sub_child_sn,a.select_no,a.home_rate,a.away_rate,a.draw_rate,a.select_rate,a.game_type,a.result, a.member_sn,
								b.sn as child_sn, b.home_team,b.away_team,b.home_score,b.away_score,b.special,b.gameDate,b.gameHour,b.gameTime, b.game_code, b.game_th, b.sport_name,
								b.notice as league_name, b.league_img as league_image, d.win, d.home_rate as game_home_rate, d.away_rate as game_away_rate, 
								d.draw_rate as game_draw_rate, e.operdate, d.home_line, d.away_line, d.draw_line, d.home_name, d.away_name, d.draw_name
								from ".$this->db_qz."game_betting a, ".$this->db_qz."child b, ".$this->db_qz."subchild d, ".$this->db_qz."game_cart e
								where a.betting_no=e.betting_no and a.betting_no='".$bettingNo."' and a.sub_child_sn=d.sn and b.sn=d.child_sn ";

				if($orderby!='') {$sql.=" order by ".$orderby;}

				$sql .= " ) AS tb_temp LEFT JOIN tb_markets ON tb_temp.game_type = tb_markets.mid";

				$rsi = $this->db->exeSql($sql);
				
				$itemList[$bettingNo] = $rs[$i];
				$itemList[$bettingNo]['cancel_enable'] = 1;
				

				for($j=0; $j<count((array)$rsi); ++$j)
				{
					$rsi[$j]["home_team"] = html_entity_decode($rsi[$j]["home_team"]);
					$rsi[$j]["away_team"] = html_entity_decode($rsi[$j]["away_team"]);

					//적특으로 인한 result_rate, select_rate를 변경해 준다.
					if($rsi[$j]['result']==4)
					{
						$rate = $rsi[$j]['select_rate'];
						// 2017.05.19
						//$rate = round($rs[$i]['result_rate']/$rate,2);
						$rate = bcmul($rs[$i]['result_rate']/$rate,1,2);
						
						$rs[$i]['result_rate'] = $rate;
						$rsi[$j]['select_rate']=1;
						
						$itemList[$bettingNo]['result_rate'] = $rate;
					} 
					else if($rsi[$j]['game_type']!=1 && $rsi[$j]['result']!=0)
					{
						//$rsi[$j]['win'] = $this->calcResult($rsi[$j]['game_type'], $rsi[$j]['draw_rate'], $rsi[$j]['home_score'], $rsi[$j]['away_score']);
					}
					
					$itemList[$bettingNo]['win_money'] = (int)($rs[$i]['betting_money']*$rs[$i]['result_rate']);
					$itemList[$bettingNo]['folder_bonus']=0;
					
					if($itemList[$bettingNo]['cancel_enable']==1 && $rsi[$j]['result']!=0)
					{
						$itemList[$bettingNo]['cancel_enable'] = 0;
					}
					
					// 가라배팅 경기결과값
					if($rsi[$j]['member_sn']=='0')
					{
						/*
						if($rsi[$j]['win']=='1')
						{
							if($rsi[$j]['select_no']=='1'){$rsi[$j]['result']='1';}
							else {$rsi[$j]['result']='2';$result_flag="2";}
						}
						else if($rsi[$j]['win']=='2')
						{
							if($rsi[$j]['select_no']=='2'){$rsi[$j]['result']='1';}
							else {$rsi[$j]['result']='2';$result_flag="2";}
						}
						else if($rsi[$j]['win']=='3')
						{
							if($rsi[$j]['select_no']=='3'){$rsi[$j]['result']='1';}
							else {$rsi[$j]['result']='2';$result_flag="2";}
						}
						else if($rsi[$j]['win']=='4'){$rsi[$j]['result']='4';}
						*/
						$itemList[$bettingNo]['result_money']=$itemList[$bettingNo]['win_money'];

					}
					
					//폴더보너스 체크시 적용
					if($event==0)
					{	
						$cModel = Lemon_Instance::getObject("ConfigModel",true);
						$mModel = Lemon_Instance::getObject("MemberModel",true);
							
						$level	= $mModel->getMemberField($this->auth->getSn(),'mem_lev');
						$field  = $cModel->getLevelConfigRow($level,"lev_folder_bonus");					
					
						$folderBonuses = explode(":", $field['lev_folder_bonus']);				
						$bonusRate=0;
						switch($rs[$i]['betting_cnt'])
						{
							case 3:  $bonusRate=$folderBonuses[0]; break;
							case 4:  $bonusRate=$folderBonuses[1]; break;
							case 5:  $bonusRate=$folderBonuses[2]; break;
							case 6:  $bonusRate=$folderBonuses[3]; break;
							case 7:  $bonusRate=$folderBonuses[4]; break;
							case 8:  $bonusRate=$folderBonuses[5]; break;
							case 9:  $bonusRate=$folderBonuses[6]; break;
							case 10: $bonusRate=$folderBonuses[7]; break;
						}
						
						$itemList[$bettingNo]['bonus_rate'] = $bonusRate;
						$itemList[$bettingNo]['folder_bonus'] = (int)($itemList[$bettingNo]['win_money']*$bonusRate/100);
					}
					else if($event==1)
					{	
						$cModel = Lemon_Instance::getObject("ConfigModel",true);
						
						$folderBonuses = $cModel->getEventConfigRow();
							
						$amount=0;
						switch($rs[$i]['betting_cnt'])
						{
							case 1:  $amount=$folderBonuses['bonus1']; break;
							case 2:  $amount=$folderBonuses['bonus2']; break;
							case 3:  $amount=$folderBonuses['bonus3']; break;
							case 4:  $amount=$folderBonuses['bonus4']; break;
							case 5:  $amount=$folderBonuses['bonus5']; break;
							case 6:  $amount=$folderBonuses['bonus6']; break;
							case 7:  $amount=$folderBonuses['bonus7']; break;
							case 8:  $amount=$folderBonuses['bonus8']; break;
							case 9:  $amount=$folderBonuses['bonus9']; break;
							case 10: $amount=$folderBonuses['bonus10']; break;
						}
						$itemList[$bettingNo]['bonus_rate'] = 0;	
						$itemList[$bettingNo]['folder_bonus'] = $amount;
					}
					
					$itemList[$bettingNo]['item'][] = $rsi[$j];
				} // end of 2nd for
			}
		}
		return $itemList;
	}

	public function getUserBettingList($member_sn = 0, $type = 0, $page_index, $page_size) {
		$sql = "SELECT 	cart.betting_no
						,cart.regdate
						,cart.betting_cnt
						,cart.result_rate
						,cart.betting_money
						,cart.result
						,cart.bet_date
						,cart.result_money
				FROM 	tb_game_cart cart
						LEFT JOIN tb_game_betting bet
						ON cart.betting_no = bet.betting_no
				WHERE 	cart.logo = 'gadget'
					AND cart.user_del <> 'Y'
					AND cart.kubun = 'Y'
					AND cart.member_sn = {$member_sn}";
		if($type == 1) 
			$sql .= " AND bet.live = 0 AND (bet.betid != '' OR bet.betid = 'bonus') ";
		else if($type == 2)
			$sql .= " AND bet.live = 1 ";
		else if($type == 3)
			$sql .= " AND bet.betid = '' ";

		$sql .= " GROUP BY cart.betting_no
				UNION
				SELECT 	cart1.betting_no
						,cart1.regdate
						,cart1.betting_cnt
						,cart1.result_rate
						,cart1.betting_money
						,cart1.result
						,cart1.bet_date
						,cart1.result_money 
				FROM 	tb_game_cart_cancel cart1
						LEFT JOIN tb_game_betting_cancel bet1
						ON cart1.betting_no = bet1.betting_no
				WHERE 	cart1.logo = 'gadget'
						AND cart1.user_del <> 'Y'
						AND cart1.kubun = 'Y'
						AND cart1.member_sn = {$member_sn}";
		
		if($type == 1) 
			$sql .= " AND bet1.live = 0 AND (bet1.betid != '' OR bet1.betid = 'bonus') ";
		else if($type == 2)
			$sql .= " AND bet1.live = 1 ";
		else if($type == 3)
			$sql .= " AND bet1.betid = '' ";

		$sql .= " 	GROUP BY cart1.betting_no
					ORDER BY regdate DESC
					LIMIT " . $page_size . " OFFSET " . $page_index * $page_size;
		
		$rs = $this->db->exeSql($sql);
		
		$itemList = array();
		if(is_array($rs) && count($rs) > 0) {
			for($i=0; $i<count($rs); ++$i)
			{
				$bettingNo = $rs[$i]["betting_no"];
				
				$sql = "SELECT tb_temp.*, tb_markets.mname_ko, tb_markets.mfamily FROM (select a.sub_child_sn,a.select_no,a.home_rate,a.away_rate,a.draw_rate,a.select_rate,a.game_type,a.result, a.member_sn, a.score, a.live, 
								b.sn as child_sn, b.home_team,b.away_team,b.home_score,b.away_score,b.special,b.gameDate,b.gameHour,b.gameTime, b.game_code, b.game_th, b.sport_name,
								IFNULL(b.sport_id, 0) as sport_id, b.notice as league_name, IFNULL(b.league_img, '') as league_image, d.win, d.home_rate as game_home_rate, d.away_rate as game_away_rate, 
								d.draw_rate as game_draw_rate, e.operdate, d.home_line, d.away_line, d.draw_line, d.home_name, d.away_name, d.draw_name
								from ".$this->db_qz."game_betting a, ".$this->db_qz."child b, ".$this->db_qz."subchild d, ".$this->db_qz."game_cart e
								where a.betting_no=e.betting_no and a.betting_no='".$bettingNo."' and a.sub_child_sn=d.sn and b.sn=d.child_sn) AS tb_temp LEFT JOIN tb_markets ON tb_temp.game_type = tb_markets.mid ";

				$rsi = $this->db->exeSql($sql);

				if(count((array)$rsi) == 0) {
					$sql = "SELECT tb_temp.*, tb_markets.mname_ko, tb_markets.mfamily FROM (select a.sub_child_sn,a.select_no,a.home_rate,a.away_rate,a.draw_rate,a.select_rate,a.game_type,a.result, a.member_sn, a.score, a.live, 
								b.sn as child_sn, b.home_team,b.away_team,b.home_score,b.away_score,b.special,b.gameDate,b.gameHour,b.gameTime, b.game_code, b.game_th, b.sport_name,
								IFNULL(b.sport_id, 0) as sport_id, b.notice as league_name, IFNULL(b.league_img, '') as league_image, d.win, d.home_rate as game_home_rate, d.away_rate as game_away_rate, 
								d.draw_rate as game_draw_rate, e.operdate, d.home_line, d.away_line, d.draw_line, d.home_name, d.away_name, d.draw_name
								from ".$this->db_qz."game_betting_cancel a, ".$this->db_qz."child b, ".$this->db_qz."subchild d, ".$this->db_qz."game_cart_cancel e
								where a.betting_no=e.betting_no and a.betting_no='".$bettingNo."' and a.sub_child_sn=d.sn and b.sn=d.child_sn) AS tb_temp LEFT JOIN tb_markets ON tb_temp.game_type = tb_markets.mid ";
					$rsi = $this->db->exeSql($sql);
				}
				
				$itemList[$bettingNo] = $rs[$i];
				$itemList[$bettingNo]['cancel_enable'] = 1;
				

				for($j=0; $j<count((array)$rsi); ++$j)
				{
					$rsi[$j]["home_team"] = html_entity_decode($rsi[$j]["home_team"]);
					$rsi[$j]["away_team"] = html_entity_decode($rsi[$j]["away_team"]);

					//적특으로 인한 result_rate, select_rate를 변경해 준다.
					if($rsi[$j]['result']==4)
					{
						$rate = $rsi[$j]['select_rate'];
						// 2017.05.19
						//$rate = round($rs[$i]['result_rate']/$rate,2);
						$rate = bcmul($rs[$i]['result_rate']/$rate,1,2);
						
						$rs[$i]['result_rate'] = $rate;
						$rsi[$j]['select_rate']=1;
						
						$itemList[$bettingNo]['result_rate'] = $rate;
					}
					
					$itemList[$bettingNo]['win_money'] = (int)($rs[$i]['betting_money']*$rs[$i]['result_rate']);
					$itemList[$bettingNo]['folder_bonus']=0;
					
					if($itemList[$bettingNo]['cancel_enable']==1 && $rsi[$j]['result']!=0)
					{
						$itemList[$bettingNo]['cancel_enable'] = 0;
					}
					
					$itemList[$bettingNo]['item'][] = $rsi[$j];
				} // end of 2nd for
			}
		}

		return $itemList;
	}

	public function getUserBettingListTotal($member_sn = 0, $type = 0) {
		$sql = "SELECT 	cart.betting_no
						,cart.regdate
						,cart.betting_cnt
						,cart.result_rate
						,cart.betting_money
						,cart.result
						,cart.bet_date
						,cart.result_money
				FROM 	tb_game_cart cart
						LEFT JOIN tb_game_betting bet
						ON cart.betting_no = bet.betting_no
				WHERE 	cart.logo = 'gadget'
					AND cart.user_del <> 'Y'
					AND cart.kubun = 'Y'
					AND cart.member_sn = {$member_sn}";
		if($type == 1) 
			$sql .= " AND bet.live = 0 AND (bet.betid != '' OR bet.betid = 'bonus') ";
		else if($type == 2)
			$sql .= " AND bet.live = 1 ";
		else if($type == 3)
			$sql .= " AND bet.betid = '' ";

		$sql .= " GROUP BY cart.betting_no
				UNION
				SELECT 	cart1.betting_no
						,cart1.regdate
						,cart1.betting_cnt
						,cart1.result_rate
						,cart1.betting_money
						,cart1.result
						,cart1.bet_date
						,cart1.result_money 
				FROM 	tb_game_cart_cancel cart1
						LEFT JOIN tb_game_betting_cancel bet1
						ON cart1.betting_no = bet1.betting_no
				WHERE 	cart1.logo = 'gadget'
						AND cart1.user_del <> 'Y'
						AND cart1.kubun = 'Y'
						AND cart1.member_sn = {$member_sn}";
		
		if($type == 1) 
			$sql .= " AND bet1.live = 0 AND (bet1.betid != '' OR bet1.betid = 'bonus') ";
		else if($type == 2)
			$sql .= " AND bet1.live = 1 ";
		else if($type == 3)
			$sql .= " AND bet1.betid = '' ";

		$sql .= " 	GROUP BY cart1.betting_no
					ORDER BY regdate DESC";
		
		$rs = $this->db->exeSql($sql);

		return count((array)$rs);
	}
	
	//▶ 관리자 배팅목록
	public function _bettingList_admin($memberSn='', $page=0, $page_size=0, $state=-1, $event=0, $beginDate='', $endDate='', $orderby='', $bettingNo='')
	{
		$sql = "select a.betting_no,a.regdate,a.betting_cnt,a.result_rate,a.betting_money,a.result, a.bet_date,
						d.sn as child_sn
						from ".$this->db_qz."game_cart a,".$this->db_qz."game_betting b,".$this->db_qz."subchild c,".$this->db_qz."child d
						where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn 
						and a.logo='".$this->logo."' and a.kubun ='Y'";
		
		//where			
		if($beginDate!="" && $endDate!="") 	{$sql.=" and (a.bet_date between '".$beginDate."' and '".$endDate."') ";}
		if($memberSn!='')		{$sql.=" and a.member_sn=".$memberSn;}
		
		if($event==0)				{$sql.=" and d.special!=4 ";}
		else if($event==1)	{$sql.=" and d.special==4 ";}

		//진행중, 종료
		if($state==0)				{$sql.=" and a.result=0 ";}
		else if($state==1)	{$sql.=" and a.result>0 ";}
		else if($state==10)	{$sql.=" and a.result=1 ";}
		else if($state==11)	{$sql.=" and a.result=2 ";}
		
		if ( trim($bettingNo) != '' ) {
			$bettingArr = explode(";",$bettingNo);
			if ( gettype($bettingArr) == "array" ) {
				$bettingArr = array_values(array_filter(array_map('trim',$bettingArr)));
				if ( count($bettingArr) == 1 ) {
					$sql .= " and a.betting_no='".$bettingArr[0]."'";
				} else {
					$bettingInList = implode(",",$bettingArr);
					$sql .= " and a.betting_no IN (".$bettingInList.")";
				}
			} else {
				$sql .= " and a.betting_no='".$bettingNo."'";
			}
		}
		
		$sql.= " group by a.betting_no ";

		//order by, limit
		$sql.=  " order by a.betting_no desc";
		if($page_size > 0)	{$sql.= " limit ".$page.",".$page_size;}
	
		//excute
		$rs = $this->db->exeSql($sql);
		
		$itemList = array();
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$bettingNo = $rs[$i]["betting_no"];

			$sql = "select a.sub_child_sn,a.select_no,a.home_rate,a.away_rate,a.draw_rate,a.select_rate,a.game_type,a.result, a.member_sn,
							b.sn as child_sn, b.home_team,b.away_team,b.home_score,b.away_score,b.special,b.gameDate,b.gameHour,b.gameTime, 
							c.name as league_name,c.lg_img as league_image, d.win
							from ".$this->db_qz."game_betting a, ".$this->db_qz."child b, ".$this->db_qz."league c, ".$this->db_qz."subchild d 
							where a.betting_no='".$bettingNo."' and a.sub_child_sn=d.sn and b.league_sn=c.sn and b.sn=d.child_sn";

			if($orderby!='') {$sql.=" order by ".$orderby;}
							
			$rsi = $this->db->exeSql($sql);
			
			$itemList[$bettingNo] = $rs[$i];
			$itemList[$bettingNo]['cancel_enable'] = 1;
			
		
			for($j=0; $j<count((array)$rsi); ++$j)
			{
				//적특으로 인한 result_rate, select_rate를 변경해 준다.
				if($rsi[$j]['result']==4)
				{
					$rate = $rsi[$j]['select_rate'];
					// 2017.05.19
					//$rate = round($rs[$i]['result_rate']/$rate,2);
                    $rate = bcmul($rs[$i]['result_rate']/$rate,1,2);

					$rs[$i]['result_rate'] = $rate;
					$rsi[$j]['select_rate']=1;
					
					$itemList[$bettingNo]['result_rate'] = $rate;
				} 
				else if($rsi[$j]['game_type']!=1 && $rsi[$j]['result']!=0)
				{
					$rsi[$j]['win'] = $this->calcResult($rsi[$j]['game_type'], $rsi[$j]['draw_rate'], $rsi[$j]['home_score'], $rsi[$j]['away_score']);
				}
				
				$itemList[$bettingNo]['win_money'] = (int)($rs[$i]['betting_money']*$rs[$i]['result_rate']);
				$itemList[$bettingNo]['folder_bonus']=0;
				
				if($itemList[$bettingNo]['cancel_enable']==1 && $rsi[$j]['result']!=0)
				{
					$itemList[$bettingNo]['cancel_enable'] = 0;
				}
				
				// 가라배팅 경기결과값
				if($rsi[$j]['member_sn']=='0')
				{
					/*
					if($rsi[$j]['win']=='1')
					{
						if($rsi[$j]['select_no']=='1'){$rsi[$j]['result']='1';}
						else {$rsi[$j]['result']='2';$result_flag="2";}
					}
					else if($rsi[$j]['win']=='2')
					{
						if($rsi[$j]['select_no']=='2'){$rsi[$j]['result']='1';}
						else {$rsi[$j]['result']='2';$result_flag="2";}
					}
					else if($rsi[$j]['win']=='3')
					{
						if($rsi[$j]['select_no']=='3'){$rsi[$j]['result']='1';}
						else {$rsi[$j]['result']='2';$result_flag="2";}
					}
					else if($rsi[$j]['win']=='4'){$rsi[$j]['result']='4';}
					*/
					$itemList[$bettingNo]['result_money']=$itemList[$bettingNo]['win_money'];

				}
				
				//폴더보너스 체크시 적용
				if($event==0)
				{	
					$cModel = Lemon_Instance::getObject("ConfigModel",true);
					$mModel = Lemon_Instance::getObject("MemberModel",true);
						
					$level	= $mModel->getMemberField($this->auth->getSn(),'mem_lev');
					$field  = $cModel->getLevelConfigRow($level,"lev_folder_bonus");					
				
					$folderBonuses = explode(":", $field['lev_folder_bonus']);				
					$bonusRate=0;
					switch($rs[$i]['betting_cnt'])
					{
						case 3:  $bonusRate=$folderBonuses[0]; break;
						case 4:  $bonusRate=$folderBonuses[1]; break;
						case 5:  $bonusRate=$folderBonuses[2]; break;
						case 6:  $bonusRate=$folderBonuses[3]; break;
						case 7:  $bonusRate=$folderBonuses[4]; break;
						case 8:  $bonusRate=$folderBonuses[5]; break;
						case 9:  $bonusRate=$folderBonuses[6]; break;
						case 10: $bonusRate=$folderBonuses[7]; break;
					}
					
					$itemList[$bettingNo]['bonus_rate'] = $bonusRate;
					$itemList[$bettingNo]['folder_bonus'] = (int)($itemList[$bettingNo]['win_money']*$bonusRate/100);
				}
				else if($event==1)
				{	
					$cModel = Lemon_Instance::getObject("ConfigModel",true);
					
					$folderBonuses = $cModel->getEventConfigRow();
						
					$amount=0;
					switch($rs[$i]['betting_cnt'])
					{
						case 1:  $amount=$folderBonuses['bonus1']; break;
						case 2:  $amount=$folderBonuses['bonus2']; break;
						case 3:  $amount=$folderBonuses['bonus3']; break;
						case 4:  $amount=$folderBonuses['bonus4']; break;
						case 5:  $amount=$folderBonuses['bonus5']; break;
						case 6:  $amount=$folderBonuses['bonus6']; break;
						case 7:  $amount=$folderBonuses['bonus7']; break;
						case 8:  $amount=$folderBonuses['bonus8']; break;
						case 9:  $amount=$folderBonuses['bonus9']; break;
						case 10: $amount=$folderBonuses['bonus10']; break;
					}
					$itemList[$bettingNo]['bonus_rate'] = 0;	
					$itemList[$bettingNo]['folder_bonus'] = $amount;
				}
				
				$itemList[$bettingNo]['item'][] = $rsi[$j];
			} // end of 2nd for
		}
		
		return $itemList;
	}
	
	//▶ 배팅목록 총합
	public function _bettingListTotal($memberSn, $state=-1, $event=0, $beginDate='', $endDate='', $specialFlag='')
	{
		$sql = "select count(distinct(a.betting_no)) as cnt
						from ".$this->db_qz."game_cart a,".$this->db_qz."game_betting b,".$this->db_qz."subchild c,".$this->db_qz."child d
						where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn 
						and a.logo='".$this->logo."' and a.user_del<>'Y' and a.member_sn=".$memberSn." and a.kubun ='Y' ";
		
		//where			
		if($beginDate!="" && $endDate!="") 	{$sql.=" and (a.bet_date between '".$beginDate."' and '".$endDate."') ";}

		if ( $specialFlag != "all" ) {
			$sql.=" and d.special = '{$specialFlag}' ";
		}

		//진행중, 종료
		if($state==0)						{$sql.=" and a.result=0 ";}
		else if($state==1)			{$sql.=" and a.result>0 ";}
		else if($state==10)			{$sql.=" and a.result=1 ";}
		else if($state==11)			{$sql.=" and a.result=2 ";}
		
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 게임결과 목록
	public function _resultList($where="", $page, $page_size)
	{
		//$rs = $this->_gameList($specialType, $gameType, $category, $leagueSn, $nationSn, 0, $page, $page_size, 'a.gameDate desc, a.gameHour desc, a.gameTime, a.league_sn', $searchTeam,$beginDate,$endDate);
		$rs = $this->_gameList($where, 'a.gameDate desc, a.gameHour desc, a.gameTime desc, a.league_sn',$page, $page_size);

		if(is_array($rs) && count($rs)<=0) return array();
		
		$itemList = array();
		if(is_array($rs) && count($rs) > 0) {
			for($i=0; $i<count($rs); ++$i)
			{
				$rs[$i]["home_team"] = html_entity_decode($rs[$i]["home_team"]);
				$rs[$i]["away_team"] = html_entity_decode($rs[$i]["away_team"]);

				if($rs[$i]['handi_winner']=="Home") 		{$win_handi = 1;}
				else if($rs[$i]['handi_winner']=="Away")	{$win_handi = 2;}
				
				if($rs[$i]['betting_type']==2)
				{
					if($win_handi == 1) 		{$rs[$i]['result_title'] = "승";}
					else if($win_handi ==2) {$rs[$i]['result_title'] = "패";}
				}
				if($rs[$i]['betting_type']==4)
				{
					if ($rs[$i]['win'] == 2) {$rs[$i]['result_title']="패";}
				}
				
				//리그별 정렬
				$key = $rs[$i]['league_sn'];
				$key.= $rs[$i]['gameTime'];
				$itemList[$key]['league_image'] = $rs[$i]['league_image'];
				$itemList[$key]['league_name'] 	= $rs[$i]['league_name'];
				$itemList[$key]['item'][] = $rs[$i];
			}
		}
		
		return $itemList;
	}
	
	public function getGameList($where="", $specialType="")
	{
		$live_list = array();
		
		$sql = "select * from ".$this->db_qz."live_game where state<>'FIN' ";
		$live_rows = $this->db->exeSql($sql);
		if(count($live_rows)>0) {
			foreach($live_rows as $live_game) {
				$live_list[] = $live_game['home_team'];
			}
		}
		
		$orderby = "a.gameDate asc, a.gameHour asc, a.gameTime asc, b.name asc, a.home_team asc, m.mname_ko asc";
		$where .= " and a.kubun=0 ";

		if ( $specialType == 7 or $specialType == 8 or $specialType == 5 or $specialType == 6 ) {
			$limitStart = 0;
			$limitEnd = 30;
		}

		$rs = $this->_gameList($where, $orderby, $limitStart, $limitEnd);

		if(is_array($rs) && count($rs)<=0) return array();
		
		//게임 배팅가능 여부 플래그 설정
		$configModel = Lemon_Instance::getObject("ConfigModel",true);
		if(is_array($rs) && count((array)$rs) > 0) {
			for($i=0; $i<count((array)$rs); ++$i)
			{
				$enable_betting_count = 0;
				$disable_betting_count = 0;
				$notice_betting_count = 0;

				$rs[$i]["home_team"] = html_entity_decode($rs[$i]["home_team"]);
				$rs[$i]["away_team"] = html_entity_decode($rs[$i]["away_team"]);

				//시간마감
				$gameTime 	= Trim($rs[$i]["gameDate"])." ".Trim($rs[$i]["gameHour"]) .":".Trim($rs[$i]["gameTime"]);
				$remainTime = (strtotime($gameTime)-strtotime(date("Y-m-d H:i:s")))/60;
				$configTime = $configModel->getAdminConfigField('bettingendtime');
				$configTime = 0.5;
				
				//가장 상단에 올릴 게임 구분
				if($rs[$i]['view_style'] != '5')
				{
					if($remainTime < $configTime)
					{
						$rs[$i]['bet_enable']=0;
						++$disable_betting_count;
					}
					else
					{
						$rs[$i]['bet_enable']=1;
						++$enable_betting_count;
					}
				}
				else
				{
					$rs[$i]['bet_enable']=5;
					++$notice_betting_count;
				}
					
				$strDay = date('w',strtotime($gameTime));
				switch($strDay)
				{
					case 0: $week = "[일]";break;
					case 1: $week = "[월]";break;
					case 2: $week = "[화]";break;
					case 3: $week = "[수]";break;
					case 4: $week = "[목]";break;
					case 5: $week = "[금]";break;
					case 6: $week = "[토]";break;	
				}
				$rs[$i]['week'] = $week;

				//관리자 결과 입력
				if(1==$rs[$i]['bet_enable'])
				{
					$result = $rs[$i]['sub_child_result'];
					if($result==1 || $result==4)
					{
						$rs[$i]['bet_enable']=0;
						++$disable_betting_count;
						--$enable_betting_count;
					}
					else
					{
						$rs[$i]['bet_enable']=1;
					}
				}

				
				//라이브 게임 여부 판단
				if( in_array($rs[$i]['home_team'], $live_list)) {
					$rs[$i]['is_live'] = 1;
					$sql = "select event_id from ".$this->db_qz."live_game where home_team='".$rs[$i]['home_team']."'";
					$rows = $this->db->exeSql($sql);
					$rs[$i]['event_id'] = $rows[0]['event_id'];
				} else {
					$rs[$i]['is_live'] = 0;
				}
				
				//리그별 정렬
				$key = $rs[$i]['alias_name'];
				$key.= $gameTime;
				$leagueGameList[$key]['league_image'] = $rs[$i]['league_image'];
				$leagueGameList[$key]['league_name'] 	= $rs[$i]['league_name'];
				$leagueGameList[$key]['view_style'] 	= $rs[$i]['view_style'];
				$leagueGameList[$key]['alias_name'] 	= $rs[$i]['alias_name'];
				$leagueGameList[$key]['link_url'] 	= $rs[$i]['link_url'];
				$leagueGameList[$key]['item'][] = $rs[$i];
				$leagueGameList[$key]['enable_betting_count'] = $enable_betting_count;
				$leagueGameList[$key]['disable_betting_count'] = $disable_betting_count;
				$leagueGameList[$key]['notice_betting_count'] = $notice_betting_count;
			}
		}

		return $leagueGameList;
	}

	public function getClassicGameList($where = "", $perpage = 100, $page_index = 0) {
		// $orderby = "a.gameDate asc, a.gameHour asc, a.gameTime asc, b.name asc, a.home_team asc, m.mname_ko asc";
		// $where .= " and a.kubun=0 ";

		$rs = $this->_classicGameList($where, "", $perpage, $page_index);

		if(is_array($rs) && count($rs)<=0) return array();
		
		//게임 배팅가능 여부 플래그 설정
		$configModel = Lemon_Instance::getObject("ConfigModel",true);
		if(is_array($rs) && count((array)$rs) > 0) {
			for($i=0; $i<count((array)$rs); ++$i)
			{
				$enable_betting_count = 0;
				$disable_betting_count = 0;
				$notice_betting_count = 0;

				$rs[$i]["home_team"] = html_entity_decode($rs[$i]["home_team"]);
				$rs[$i]["away_team"] = html_entity_decode($rs[$i]["away_team"]);

				//시간마감
				$gameTime 	= Trim($rs[$i]["gameDate"])." ".Trim($rs[$i]["gameHour"]) .":".Trim($rs[$i]["gameTime"]);
				$remainTime = (strtotime($gameTime)-strtotime(date("Y-m-d H:i:s")))/60;
				$configTime = $configModel->getAdminConfigField('bettingendtime');
				$configTime = 0.5;
				
				//가장 상단에 올릴 게임 구분
				if($rs[$i]['view_style'] != '5')
				{
					if($remainTime < $configTime)
					{
						$rs[$i]['bet_enable']=0;
						++$disable_betting_count;
					}
					else
					{
						$rs[$i]['bet_enable']=1;
						++$enable_betting_count;
					}
				}
				else
				{
					$rs[$i]['bet_enable']=5;
					++$notice_betting_count;
				}
					
				$strDay = date('w',strtotime($gameTime));
				switch($strDay)
				{
					case 0: $week = "[일]";break;
					case 1: $week = "[월]";break;
					case 2: $week = "[화]";break;
					case 3: $week = "[수]";break;
					case 4: $week = "[목]";break;
					case 5: $week = "[금]";break;
					case 6: $week = "[토]";break;	
				}
				$rs[$i]['week'] = $week;

				//관리자 결과 입력
				if(1==$rs[$i]['bet_enable'])
				{
					$result = $rs[$i]['sub_child_result'];
					if($result==1 || $result==4)
					{
						$rs[$i]['bet_enable']=0;
						++$disable_betting_count;
						--$enable_betting_count;
					}
					else
					{
						$rs[$i]['bet_enable']=1;
					}
				}

				
				//라이브 게임 여부 판단
				// if( in_array($rs[$i]['home_team'], $live_list)) {
				// 	$rs[$i]['is_live'] = 1;
				// 	$sql = "select event_id from ".$this->db_qz."live_game where home_team='".$rs[$i]['home_team']."'";
				// 	$rows = $this->db->exeSql($sql);
				// 	$rs[$i]['event_id'] = $rows[0]['event_id'];
				// } else {
				// 	$rs[$i]['is_live'] = 0;
				// }
				
				//리그별 정렬
				$key = $rs[$i]['notice'];
				$key.= $gameTime;
				$leagueGameList[$key]['league_image'] = $rs[$i]['league_img'];
				$leagueGameList[$key]['league_name'] 	= $rs[$i]['notice'];
				$leagueGameList[$key]['view_style'] 	= $rs[$i]['view_style'];
				$leagueGameList[$key]['alias_name'] 	= $rs[$i]['alias_name'];
				$leagueGameList[$key]['link_url'] 	= $rs[$i]['link_url'];
				$leagueGameList[$key]['item'][] = $rs[$i];
				$leagueGameList[$key]['enable_betting_count'] = $enable_betting_count;
				$leagueGameList[$key]['disable_betting_count'] = $disable_betting_count;
				$leagueGameList[$key]['notice_betting_count'] = $notice_betting_count;
			}
		}

		return $leagueGameList;
	}

	// 다기준 경기목록 가져오기
	public function getMultiGameList($where = "", $perpage = 100, $page_index = 0)
	{
		$orderby = " a.gameDate ASC, a.gameHour ASC, a.gameTime ASC, b.name ASC";

		$rs = $this->_gameMultiList($where, $orderby, $perpage, $page_index);

		if(is_array($rs) && count($rs)<=0) return array();

		// 게임 배팅가능 배렬
		// if(is_array($rs) && count((array)$rs) > 0) {
		// 	for($i=0; $i<count((array)$rs); ++$i)
		// 	{
		// 		$where = " and a.sn = " . $rs[$i]["child_sn"];
		// 		$count = $this->getChildrenCount($where);
		// 		$rs[$i]["count"] = $count;
		// 		$subchild_info = $this->getSubChildInfo($rs[$i]["child_sn"]);
		// 		if(count($subchild_info) > 0) {
		// 			$rs[$i]["sub_child_sn"] = $subchild_info["sn"];
		// 			$rs[$i]["betting_type"] = $subchild_info["betting_type"];
		// 			$rs[$i]["home_rate"] = $subchild_info["home_rate"];
		// 			$rs[$i]["draw_rate"] = $subchild_info["draw_rate"];
		// 			$rs[$i]["away_rate"] = $subchild_info["away_rate"];
		// 		}
		// 	}
		// }
		
		return $rs;

		// //게임 배팅가능 여부 플래그 설정
		// $configModel = Lemon_Instance::getObject("ConfigModel",true);
		// if(is_array($rs) && count((array)$rs) > 0) {
		// 	for($i=0; $i<count((array)$rs); ++$i)
		// 	{
		// 		$enable_betting_count = 0;
		// 		$disable_betting_count = 0;
		// 		$notice_betting_count = 0;

		// 		$rs[$i]["home_team"] = html_entity_decode($rs[$i]["home_team"]);
		// 		$rs[$i]["away_team"] = html_entity_decode($rs[$i]["away_team"]);

		// 		//시간마감
		// 		$gameTime 	= Trim($rs[$i]["gameDate"])." ".Trim($rs[$i]["gameHour"]) .":".Trim($rs[$i]["gameTime"]);
		// 		$remainTime = (strtotime($gameTime)-strtotime(date("Y-m-d H:i:s")))/60;
		// 		$configTime = $configModel->getAdminConfigField('bettingendtime');
		// 		$configTime = 0.5;
				
		// 		//가장 상단에 올릴 게임 구분
		// 		if($rs[$i]['view_style'] != '5')
		// 		{
		// 			if($remainTime < $configTime)
		// 			{
		// 				$rs[$i]['bet_enable']=0;
		// 				++$disable_betting_count;
		// 			}
		// 			else
		// 			{
		// 				$rs[$i]['bet_enable']=1;
		// 				++$enable_betting_count;
		// 			}
		// 		}
		// 		else
		// 		{
		// 			$rs[$i]['bet_enable']=5;
		// 			++$notice_betting_count;
		// 		}
					
		// 		// $strDay = date('w',strtotime($gameTime));
		// 		// switch($strDay)
		// 		// {
		// 		// 	case 0: $week = "[일]";break;
		// 		// 	case 1: $week = "[월]";break;
		// 		// 	case 2: $week = "[화]";break;
		// 		// 	case 3: $week = "[수]";break;
		// 		// 	case 4: $week = "[목]";break;
		// 		// 	case 5: $week = "[금]";break;
		// 		// 	case 6: $week = "[토]";break;	
		// 		// }
		// 		// $rs[$i]['week'] = $week;

		// 		//관리자 결과 입력
		// 		if(1==$rs[$i]['bet_enable'])
		// 		{
		// 			$result = $rs[$i]['sub_child_result'];
		// 			if($result==1 || $result==4)
		// 			{
		// 				$rs[$i]['bet_enable']=0;
		// 				++$disable_betting_count;
		// 				--$enable_betting_count;
		// 			}
		// 			else
		// 			{
		// 				$rs[$i]['bet_enable']=1;
		// 			}
		// 		}

		// 		//리그별 정렬
		// 		$key = $rs[$i]['alias_name'];
		// 		$key.= $gameTime;
		// 		$leagueGameList[$key]['league_image'] = $rs[$i]['league_image'];
		// 		$leagueGameList[$key]['league_name'] 	= $rs[$i]['league_name'];
		// 		$leagueGameList[$key]['view_style'] 	= $rs[$i]['view_style'];
		// 		$leagueGameList[$key]['alias_name'] 	= $rs[$i]['alias_name'];
		// 		$leagueGameList[$key]['link_url'] 	= $rs[$i]['link_url'];
		// 		$leagueGameList[$key]['item'][] = $rs[$i];
		// 		$leagueGameList[$key]['enable_betting_count'] = $enable_betting_count;
		// 		$leagueGameList[$key]['disable_betting_count'] = $disable_betting_count;
		// 		$leagueGameList[$key]['notice_betting_count'] = $notice_betting_count;
		// 	}
		// }

		//return $leagueGameList;
	}

	public function getLiveGameList($where = "", $perpage = 100, $page_index = 0)
	{
		$orderby = " a.gameDate ASC, a.gameHour ASC, a.gameTime ASC, a.home_team ASC ";

		$rs = $this->_gameLiveList($where, $orderby, $perpage, $page_index);

		if(is_array($rs) && count($rs)<=0) return array();
		
		return $rs;
	}

	// 다기준 경기목록 가져오기
	public function getMultiGameDetailList($where = "", $perpage = 50, $page_index = 0)
	{
		$orderby = " ORDER BY a.gameDate ASC, a.gameHour ASC, a.gameTime ASC, a.home_team ASC ";

		$sql = "SELECT  a.sn as child_sn 
				FROM ".$this->db_qz."child_m a,".$this->db_qz."league b WHERE a.league_sn = b.sn " . $where;

		$sql .= $orderby;	
		$sql.= " LIMIT ".$perpage." OFFSET ". $perpage * $page_index;
		
		$res = $this->db->exeSql($sql);

		if(is_array($res) && count($res)<=0) return array();

		$detail = array();

		foreach($res as $item) {
			$count = $this->getSubChildCount($item["child_sn"]);
			array_push($detail["count"], $count);
		}

		return $detail;
	}

	// 다기준 매 경기에 따르는 subchild 개수 얻어오기
	public function getSubChildCount($child_sn) {
		$sql = "SELECT 	COUNT(*) AS cnt
	  			FROM	tb_subchild_m a
	  			WHERE 	a.view_flag = 1 AND a.child_sn = " . $child_sn;

		$res = $this->db->exeSql($sql);

		if(count($res) > 0) {
			return $res[0]['cnt'];
		}

		return 0;
	}

	// 다기준 경기목록 총개수 
	public function getMultiGameListCount($where) {
		$count = $this->_gameMultiListTotal($where);
		return $count;
	}

    public function getNewGameList($where="")
    {
        $live_list = array();

        $sql = "select * from ".$this->db_qz."live_game where state<>'FIN' ";
        $live_rows = $this->db->exeSql($sql);
        if(count($live_rows)>0) {
            foreach($live_rows as $live_game) {
                $live_list[] = $live_game['home_team'];
            }
        }

        $orderby = "a.gameDate asc, a.gameHour asc, a.gameTime asc, a.home_team, a.type asc";
        $groupby = "home_team, away_team";
        $where .= " and a.kubun=0 ";

        $rs = $this->_gameList2($where, $orderby, $groupby);

        if(count((array)$rs)<=0) return array();

        //게임 배팅가능 여부 플래그 설정
        $configModel = Lemon_Instance::getObject("ConfigModel",true);

        for($i=0; $i<count((array)$rs); ++$i)
        {
            $enable_betting_count = 0;
            $disable_betting_count = 0;
            $notice_betting_count = 0;

            $rs[$i]["home_team"] = html_entity_decode($rs[$i]["home_team"]);
            $rs[$i]["away_team"] = html_entity_decode($rs[$i]["away_team"]);

            //시간마감
            $gameTime 	= Trim($rs[$i]["gameDate"])." ".Trim($rs[$i]["gameHour"]) .":".Trim($rs[$i]["gameTime"]);
            $remainTime = (strtotime($gameTime)-strtotime(date("Y-m-d H:i:s")))/60;
            $configTime = $configModel->getAdminConfigField('bettingendtime');
            $configTime = 0.5;

            //가장 상단에 올릴 게임 구분
            if($rs[$i]['view_style'] != '5')
            {
                if($remainTime < $configTime)
                {
                    $rs[$i]['bet_enable']=0;
                    ++$disable_betting_count;
                }
                else
                {
                    $rs[$i]['bet_enable']=1;
                    ++$enable_betting_count;
                }
            }
            else
            {
                $rs[$i]['bet_enable']=5;
                ++$notice_betting_count;
            }

            $strDay = date('w',strtotime($gameTime));
            switch($strDay)
            {
                case 0: $week = "[일]";break;
                case 1: $week = "[월]";break;
                case 2: $week = "[화]";break;
                case 3: $week = "[수]";break;
                case 4: $week = "[목]";break;
                case 5: $week = "[금]";break;
                case 6: $week = "[토]";break;
            }
            $rs[$i]['week'] = $week;

            //관리자 결과 입력
            if(1==$rs[$i]['bet_enable'])
            {
                $result = $rs[$i]['sub_child_result'];
                if($result==1 || $result==4)
                {
                    $rs[$i]['bet_enable']=0;
                    ++$disable_betting_count;
                    --$enable_betting_count;
                }
                else
                {
                    $rs[$i]['bet_enable']=1;
                }
            }


            //라이브 게임 여부 판단
            if( in_array($rs[$i]['home_team'], $live_list)) {
                $rs[$i]['is_live'] = 1;
                $sql = "select event_id from ".$this->db_qz."live_game where home_team='".$rs[$i]['home_team']."'";
                $rows = $this->db->exeSql($sql);
                $rs[$i]['event_id'] = $rows[0]['event_id'];
            } else {
                $rs[$i]['is_live'] = 0;
            }

            //리그별 정렬
            $key = $rs[$i]['alias_name'];
            $key.= $gameTime;
            $leagueGameList[$key]['league_image'] = $rs[$i]['league_image'];
            $leagueGameList[$key]['league_name'] 	= $rs[$i]['league_name'];
            $leagueGameList[$key]['view_style'] 	= $rs[$i]['view_style'];
            $leagueGameList[$key]['alias_name'] 	= $rs[$i]['alias_name'];
            $leagueGameList[$key]['link_url'] 	= $rs[$i]['link_url'];
            $leagueGameList[$key]['item'][] = $rs[$i];
            $leagueGameList[$key]['enable_betting_count'] = $enable_betting_count;
            $leagueGameList[$key]['disable_betting_count'] = $disable_betting_count;
            $leagueGameList[$key]['notice_betting_count'] = $notice_betting_count;
        }

        return $leagueGameList;
    }

	public function getKeywordGameList($specialType='',$gameType='')
	{
		$sql = "select b.alias_name as alias_name, b.sn as league_sn
						from ".$this->db_qz."child  a,".$this->db_qz."league b,".$this->db_qz."subchild c
						where a.kubun=0 and a.league_sn=b.sn and a.sn=c.child_sn and b.alias_name != ''";
				
		switch($specialType)
		{
			case '0': 
				$sql.= " and a.special=0 and a.type=1"; 
			break;
			case '1': 
				$sql.= " and a.special=0 and (a.type=2 or a.type=4)"; 
			break;
			case '2': $sql.= " and a.special=1"; break;
			case '3': $sql.= " and a.special=3"; break;
			case '4': $sql.= " and a.special=4"; break;
			case '5': $sql.= " and a.special=5"; break;
		}
		$sql.=" group by b.alias_name order by b.alias_name asc";

		return $this->db->exeSql($sql);
	}
	
	//▶ 게임복사에 사용되는 목록
	public function getCopyGameList($category='', $league='', $homeTeam='', $awayTeam='', $beginDate="", $endDate="")
	{
		$sql = "select 	a.*, 
										b.*,
										c.name as league_name
						from ".$this->db_qz."child a, "
									.$this->db_qz."subchild b, "
									.$this->db_qz."league c
						where a.sn=b.child_sn 
									and a.league_sn=c.sn 
									and a.kubun is null 
									and a.type=1 
									and a.special=0";
						
		if($category!='') $sql.= " and a.sport_name='".$category."'";
		if($league!='') 	$sql.= " and c.name like('%".$league."%')";
		if($homeTeam!='') $sql.= " and a.home_team like('%".$homeTeam."%')";
		if($awayTeam!='') $sql.= " and a.away_team like('%".$awayTeam."%')";
		if($beginDate!='') 		$sql.= " and a.gameDate between '".$beginDate."' and '".$endDate."'";

		return $this->db->exeSql($sql);
	}

    public function getResultUpdatedBettingList($where, $orderby, $limit, $s_type = 0)
    {
		if($s_type == 2) {
			$sql = "select	a.betting_no, a.result as cart_result, a.result_money, b.sn as betting_sn, b.result as child_result, d.home_score, d.away_score, e.win
							from ".$this->db_qz."game_cart a,".$this->db_qz."game_betting b, tb_child_m d, tb_subchild_m e
							where a.is_update_result=1 and a.betting_no=b.betting_no and b.sub_child_sn = e.sn and e.child_sn = d.sn ".$where;
		} else {
			$sql = "select	a.betting_no, a.result as cart_result, a.result_money, b.sn as betting_sn, b.result as child_result, d.home_score, d.away_score, e.win
							from ".$this->db_qz."game_cart a,".$this->db_qz."game_betting b, tb_child d, tb_subchild e
							where a.is_update_result=1 and a.betting_no=b.betting_no and b.sub_child_sn = e.sn and e.child_sn = d.sn
							and a.kubun ='Y' ".$where;
		}
        

        $rs = $this->db->exeSql($sql);

        $sql = "update tb_game_cart set is_update_result = 0 where is_update_result=1";
        $this->db->exeSql($sql);

        return $rs;
    }

    public function getNewBettingList($memberSn="", $where, $orderby)
    {
        $sql = "select	a.betting_no, a.regdate, a.operdate, a.betting_cnt, a.result_rate, a.bet_date, a.logo,
										a.before_money, a.betting_money, a.result, a.result_money, a.member_sn, a.betting_ip
						from ".$this->db_qz."game_cart a,".$this->db_qz."game_betting b, ".$this->db_qz."member c, tb_child d, tb_subchild e
						where a.is_new=1 and a.result != 4 and	a.betting_no=b.betting_no and a.member_sn=c.sn and b.sub_child_sn = e.sn and e.child_sn = d.sn
										and a.kubun ='Y' ".$where." 
						group by a.betting_no ".$orderby;
        $rs = $this->db->exeSql($sql);
        $list = array();

        $sql = "update tb_game_cart set is_new = 0 where is_new=1";
        $this->db->exeSql($sql);

        //배팅번호로 그룹화
        for($i=0; $i<count((array)$rs); ++$i)
        {
            $bettingSn = $rs[$i]["betting_no"];

            $sql = "select a.*, p.nb_list_sum, p.pb, p.nb_list from 
                        (select a.sn as total_betting_sn, a.sub_child_sn, a.select_no, a.home_rate, a.away_rate, a.draw_rate, a.select_rate, a.game_type, a.result,
							b.sn as child_sn, b.home_team, b.away_team, b.home_score, b.away_score, b.special, b.gameDate, b.gameHour, b.gameTime,
							c.name as league_name, c.lg_img as league_image, c.alias_name,
							d.win, d.home_rate as game_home_rate, d.away_rate as game_away_rate, d.draw_rate as game_draw_rate, b.game_code, b.game_th
							from ".$this->db_qz."game_betting a, ".$this->db_qz."child b, ".$this->db_qz."league c, ".$this->db_qz."subchild d 
							where a.betting_no='".$bettingSn."' and a.sub_child_sn=d.sn and b.league_sn=c.sn and b.sn=d.child_sn order by gameDate, gameHour, gameTime) a left join tb_powerball_result p on a.game_th = p.th";

            $rsi = $this->db->exeSql($sql);
            $list[$bettingSn] = $rs[$i];
            $list[$bettingSn]['win_count']=0;

            for($j=0; $j<count((array)$rsi); ++$j)
            {
                if($rsi[$j]["result"]==1)
                    $list[$bettingSn]['win_count']+=1;
                if($rsi[$j]["result"]==2)
                    $list[$bettingSn]['lose_count']+=1;

                $list[$bettingSn]['win_money'] = (int)($rs[$i]['betting_money']*$rs[$i]['result_rate']);
                $list[$bettingSn]['folder_bonus']=0;

                if($memberSn=="")
                    $memberSn = $rs[$i]['member_sn'];

                //폴더보너스 체크시 적용
                $levelConfigModel = Lemon_Instance::getObject("LevelConfigModel",true);

                $bonusRate = $levelConfigModel->getMemberFolderBounsRate($memberSn, $rs[$i]['betting_cnt']);
                $list[$bettingSn]['bonus_rate'] = $bonusRate;
                $list[$bettingSn]['folder_bonus'] = (int)($list[$bettingSn]['win_money']*$bonusRate/100);
                $list[$bettingSn]["item"][] = $rsi[$j];
            } // end of 2nd for

            if ( preg_match("/(a.result=0 )/i",$where,$match) != 0 ) {
                if ( $list[$bettingSn]['lose_count'] > 0 ) unset($list[$bettingSn]);
            }
        }

        $memberModel 	= Lemon_Instance::getObject("MemberModel",true);
        $partnerModel = Lemon_Instance::getObject("PartnerModel",true);

        foreach($list as $key => $item)
        {
            $rsi = $memberModel->getMemberRow($list[$key]["member_sn"]);
            $list[$key]['member'] = $rsi;

            $recommend_sn =  $rsi['recommend_sn'];
            if($recommend_sn!="")
                $partnerId = $partnerModel->getPartnerField($recommend_sn,"rec_id");

            $list[$key]['partner_id'] = $partnerId;
        }

        return $list;
    }

	//▶ 배팅목록
	public function getMemberBettingList($memberSn="", $where="", $page=0, $page_size=0, $orderby="", $s_type = 0)
	{
		if($page_size > 0)
			$limit = " limit ".$page.", ".$page_size;
			
		if($memberSn!="")
			$where.= " and a.member_sn=".$memberSn;

		// if($s_type == 2) {
		// 	$where.= " and a.s_type = 2 ";
		// } else {
		// 	$where.= " and a.s_type = 0 ";
		// }
			
			
		if($orderby=="")
			$orderby = " order by a.betting_no desc ";
		
		$sql = "select	a.betting_no, a.regdate, a.operdate, a.betting_cnt, a.result_rate, a.bet_date, a.logo,
							a.before_money, a.betting_money, a.result, a.result_money, a.member_sn, a.betting_ip, d.special
				from ".$this->db_qz."game_cart a,".$this->db_qz."game_betting b, ".$this->db_qz."member c, tb_child d, tb_subchild e
				where 	a.betting_no=b.betting_no and a.member_sn=c.sn and b.sub_child_sn = e.sn and e.child_sn = d.sn
							and a.kubun ='Y' ".$where." 
				group by a.betting_no ".$orderby.$limit;
		
		$rs = $this->db->exeSql($sql);
		$list = array();
		
		//배팅번호로 그룹화
		if(is_array($rs) && count((array)$rs) > 0) {
			for($i=0; $i<count((array)$rs); ++$i)
			{
				$bettingSn = $rs[$i]["betting_no"];
				if($rs[$i]["special"] < 5 || $rs[$i]["special"] == 22 || $rs[$i]["special"] == 50) {
					$sql = "SELECT 	tb_temp.*, tb_markets.mid, tb_markets.mname_ko, tb_markets.mfamily FROM (
									SELECT 	a.sn as total_betting_sn, a.sub_child_sn, a.select_no, a.home_rate, a.away_rate, a.draw_rate, a.select_rate, a.game_type, a.result, a.score, a.live, 
											b.sn as child_sn, b.home_team, b.away_team, b.home_score, b.away_score, b.special, b.gameDate, b.gameHour, b.gameTime, b.sport_name, b.sport_id, 
											b.notice as league_name, IFNULL(b.league_img, '') as league_image, d.home_line, d.away_line, d.draw_line, d.home_name, d.away_name, d.draw_name,
											d.win, d.home_rate as game_home_rate, d.away_rate as game_away_rate, d.draw_rate as game_draw_rate, e.nTotalBetMoney 
									FROM 	tb_game_betting a
											INNER JOIN tb_subchild d ON a.`sub_child_sn`= d.`sn`
											LEFT JOIN tb_child b ON d.child_sn = b.sn
											LEFT JOIN (SELECT SUM(bet_money) AS nTotalBetMoney, sub_child_sn FROM tb_game_betting GROUP BY sub_child_sn) e ON d.sn = e.sub_child_sn
									WHERE	a.betting_no='".$bettingSn."'  
									ORDER BY gameDate, gameHour, gameTime) AS tb_temp 
							LEFT JOIN tb_markets ON tb_temp.game_type = tb_markets.mid ";
				} else {
					$sql = "SELECT 	tb_temp.*, tb_markets.mid, tb_markets.mname_ko, tb_markets.mfamily FROM (
									SELECT 	a.sn as total_betting_sn, a.sub_child_sn, a.select_no, a.home_rate, a.away_rate, a.draw_rate, a.select_rate, a.game_type, a.result, a.score, a.live, 
											b.sn as child_sn, b.home_team, b.away_team, b.home_score, b.away_score, b.special, b.gameDate, b.gameHour, b.gameTime, b.sport_id,
											b.notice as league_name, IFNULL(b.league_img, '') as league_image, 
											d.win, d.home_rate as game_home_rate, d.away_rate as game_away_rate, d.draw_rate as game_draw_rate, e.nTotalBetMoney
									FROM 	tb_game_betting a
											INNER JOIN tb_subchild d ON a.`sub_child_sn`= d.`sn`
											LEFT JOIN tb_child b ON d.child_sn = b.sn
											LEFT JOIN (SELECT SUM(bet_money) AS nTotalBetMoney, sub_child_sn FROM tb_game_betting GROUP BY sub_child_sn) e ON d.sn = e.sub_child_sn
									WHERE	a.betting_no='".$bettingSn."' 
									ORDER BY gameDate, gameHour, gameTime) AS tb_temp 
							LEFT JOIN tb_markets ON tb_temp.game_type = tb_markets.mid ";
				}
				
				$rsi = $this->db->exeSql($sql);
				$list[$bettingSn] = $rs[$i];			
				$list[$bettingSn]['win_count']=0;
				
				for($j=0; $j<count((array)$rsi); ++$j)
				{
					if($rsi[$j]["result"]==1)
						$list[$bettingSn]['win_count']+=1;
					if($rsi[$j]["result"]==2)
						$list[$bettingSn]['lose_count']+=1;
						
					$list[$bettingSn]['win_money'] = (int)($rs[$i]['betting_money']*$rs[$i]['result_rate']);
					$list[$bettingSn]['folder_bonus']=0;
					
					if($memberSn=="")
						$memberSn = $rs[$i]['member_sn'];
					
					//폴더보너스 체크시 적용
					$levelConfigModel = Lemon_Instance::getObject("LevelConfigModel",true);
					
					$bonusRate = $levelConfigModel->getMemberFolderBounsRate($memberSn, $rs[$i]['betting_cnt']);
					$list[$bettingSn]['bonus_rate'] = $bonusRate;
					$list[$bettingSn]['folder_bonus'] = (int)($list[$bettingSn]['win_money']*$bonusRate/100);
					$list[$bettingSn]["item"][] = $rsi[$j];
				} // end of 2nd for

				if ( preg_match("/(a.result=0 )/i",$where,$match) != 0 ) {
					if ( $list[$bettingSn]['lose_count'] > 0 ) unset($list[$bettingSn]);
				}
			}
		}
		
		return $list;
	}
	
	public function getMemberBettingListTotal($memberSn, $where="")
	{
		if($memberSn!="")
			$where.= " and a.member_sn=".$memberSn;
		
		$sql = "select distinct(a.betting_no) from ".$this->db_qz."game_cart a,".$this->db_qz."game_betting b, ".$this->db_qz."member c, tb_child d, tb_subchild e
				where a.betting_no=b.betting_no and a.member_sn=c.sn and b.sub_child_sn = e.sn and e.child_sn = d.sn and a.kubun ='Y' ".$where;
		
		$rs = $this->db->exeSql($sql);
		$list = array();

		if ( preg_match("/(a.result=0 )/i",$where,$match) != 0 ) {
			if(is_array($rs) && count((array)$rs) > 0) {
				for ( $i = 0 ; $i < count((array)$rs) ; $i++ ) {
					$bettingSn = $rs[$i]["betting_no"];

					$sql = "select * from tb_game_betting where betting_no='".$bettingSn."'";
					$rsi = $this->db->exeSql($sql);
					$list[$bettingSn] = $rs[$i];			
					
					for ( $j = 0 ; $j < count((array)$rsi) ; $j++ ) {
						if ( $rsi[$j]["result"] == 2 ) $list[$bettingSn]['lose_count'] += 1;
					}
					
					if ( $list[$bettingSn]['lose_count'] > 0 ) unset($list[$bettingSn]);
				}
			}
			return count($list);
		} else {
			if(is_array($rs))
				return count($rs);
			else 
				return 0;
		}
	}
	
	//관리자 배팅현황 - 유저(추가: 유저정보)
	public function getAdminMemberBettingList($memberSn, $where="", $page=0, $page_size=0, $orderby="")
	{
		$memberModel 	= Lemon_Instance::getObject("MemberModel",true);
		
		$rs = $this->getMemberBettingList($memberSn, $where, $page, $page_size, $orderby);
		
		foreach($rs as $bettingSn => $item)
		{
			$rsi = $memberModel->getMemberRow($memberSn);
			$rs[$bettingSn]['member'] = $rsi;
		}
		
		return $rs;
	}
	
	//관리자 배팅현황 - 유저
	public function getAdminMemberBettingListTotal($memberSn, $where="")
	{
		return $this->getMemberBettingListTotal($memberSn, $where);
	}
	
	//파트너 배팅현황 - 유저
	public function getPartnerBettingList($partnerSn, $where="", $page=0, $page_size=0)
	{
		$memberModel 	= Lemon_Instance::getObject("MemberModel",true);
		
		$where.= " and a.partner_sn=".$partnerSn;
		
		$rs = $this->getMemberBettingList("", $where, $page, $page_size);
		
		foreach($rs as $bettingSn => $item)
		{
			$rsi = $memberModel->getMemberRow($rs[$bettingSn]["member_sn"]);
			$rs[$bettingSn]['member'] = $rsi;
		}
		return $rs;
	}
	
	//파트너 배팅현황 - 유저
	public function getPartnerBettingListTotal($partnerSn, $where="") 
	{
		$where.= " and a.partner_sn=".$partnerSn;
		return $this->getMemberBettingListTotal("", $where);
	}
	
	//관리자 배팅현황 
	public function getAdminBettingList($childSn="", $where="", $page=0, $page_size=0, $s_type = 0)
	{
		$memberModel 	= Lemon_Instance::getObject("MemberModel",true);
		$partnerModel = Lemon_Instance::getObject("PartnerModel",true);
		
		if($childSn!="") {
			$where.=" and b.sub_child_sn = (select sn from ".$this->db_qz."subchild where child_sn=".$childSn.")";
		}
			

		$orderby = " order by a.regdate desc ";
		$rs = $this->getMemberBettingList("", $where, $page, $page_size, $orderby, $s_type);
	
		foreach($rs as $bettingSn => $item)
		{
			$rsi = $memberModel->getMemberRow($rs[$bettingSn]["member_sn"]);
			$rs[$bettingSn]['member'] = $rsi;
			
			$recommend_sn =  $rsi['recommend_sn'];
			if($recommend_sn!="")
				$partnerId = $partnerModel->getPartnerField($recommend_sn,"rec_id");
				
			$rs[$bettingSn]['partner_id'] = $partnerId;
		}

		return $rs;
	}

	//-> 오버배팅 체크를 위한.
	public function getAdminBettingListOver($where="")
	{
		$memberModel 	= Lemon_Instance::getObject("MemberModel",true);
		$partnerModel = Lemon_Instance::getObject("PartnerModel",true);

		$begin_date = date("Y-m-d H:i:s",time()-10800);
		$end_date = date("Y-m-d H:i:s",time());
		$where.=" and a.is_account = 1 and a.regdate >= '".$begin_date."' and a.regdate <= '".$end_date."' ";

		if($childSn!="")
			$where.=" and b.sub_child_sn = (select sn from ".$this->db_qz."subchild where child_sn=".$childSn.")";

		$orderby = " order by a.regdate desc ";
		$rs = $this->getMemberBettingList("", $where, $page, $page_size, $orderby);
		
		foreach($rs as $bettingSn => $item)
		{
			//-> 카트 배팅 타임스템프값
			$betting_no = $item['betting_no'];
			$betting_time = strtotime($item['regdate']);

			$overBetCnt = 0;
			for ( $i = 0 ; $i < count($rs[$bettingSn]["item"]) ; $i++ ) {
				$gameStart_ymd = $rs[$bettingSn]["item"][$i]["gameDate"];
				$gameStart_h = $rs[$bettingSn]["item"][$i]["gameHour"];
				$gameStart_i = $rs[$bettingSn]["item"][$i]["gameTime"];

				//-> 게임시작시간 타임스템프값
				$game_start_time = strtotime($gameStart_ymd." ".$gameStart_h.":".$gameStart_i.":00");
				if ( $betting_time >= $game_start_time ) {
					//-> 오버배팅이면 회원/총판정보 가져옴.
					$rsi = $memberModel->getMemberRow($rs[$bettingSn]["member_sn"]);
					$rs[$bettingSn]['member'] = $rsi;
					
					$recommend_sn = $rsi['recommend_sn'];
					if($recommend_sn!="")
						$partnerId = $partnerModel->getPartnerField($recommend_sn,"rec_id");						
					$rs[$bettingSn]['partner_id'] = $partnerId;

					$overBetCnt++;
				}
			}

			if ( $overBetCnt == 0 ) {
				unset($rs[$bettingSn]);
			}
		}
		return $rs;
	}

	//관리자 배팅취소현황 
	public function getAdminBettingCancelList($childSn="", $where="", $page=0, $page_size=0)
	{
		$memberModel 	= Lemon_Instance::getObject("MemberModel",true);
		$partnerModel = Lemon_Instance::getObject("PartnerModel",true);
		
		if($childSn!="")
			$where.=" and b.sub_child_sn = (select sn from ".$this->db_qz."subchild where child_sn=".$childSn.")";

		$orderby = " order by a.regdate desc ";
		//$rs = $this->getMemberBettingList("", $where, $page, $page_size, $orderby);
		
		if($page_size > 0)
			$limit = " limit ".$page.", ".$page_size;
			
		$sql = "select	a.betting_no, a.regdate, a.operdate, a.betting_cnt, a.result_rate, a.bet_date, a.logo,
						a.before_money, a.betting_money, a.result, a.result_money, a.member_sn, a.betting_ip, a.cancel_by
				from ".$this->db_qz."game_cart_cancel a,".$this->db_qz."game_betting_cancel b, ".$this->db_qz."member c
				where 	a.betting_no=b.betting_no and a.member_sn=c.sn
								and a.kubun ='Y' ".$where." 
				group by a.betting_no ".$orderby.$limit;
		$rs = $this->db->exeSql($sql);

		$list = array();
		
		//배팅번호로 그룹화
		if(is_array($rs) && count((array)$rs) > 0) {
			for($i=0; $i<count((array)$rs); ++$i)
			{
				$bettingSn = $rs[$i]["betting_no"];

				$sql = "SELECT 	tb_temp.*, tb_markets.mid, tb_markets.mname_ko, tb_markets.mfamily FROM (
								SELECT a.sn as total_betting_sn, a.sub_child_sn, a.select_no, a.home_rate, a.away_rate, a.draw_rate, a.select_rate, a.game_type, a.result, a.score, a.live, 
										b.sn as child_sn, b.home_team, b.away_team, b.home_score, b.away_score, b.special, b.gameDate, b.gameHour, b.gameTime, b.sport_id, 
										b.notice as league_name, IFNULL(b.league_img, '') as league_image, d.home_line, d.away_line, d.draw_line, d.home_name, d.away_name, d.draw_name, d.win
								FROM ".$this->db_qz."game_betting_cancel a, ".$this->db_qz."child b, ".$this->db_qz."subchild d 
								WHERE a.betting_no='".$bettingSn."' and a.sub_child_sn=d.sn and b.sn=d.child_sn order by gameDate, gameHour, gameTime ) AS tb_temp 
						LEFT JOIN tb_markets ON tb_temp.game_type = tb_markets.mid ";

				$rsi = $this->db->exeSql($sql);
				
				$list[$bettingSn] = $rs[$i];			
				$list[$bettingSn]['win_count']=0;
				
				for($j=0; $j<count((array)$rsi); ++$j)
				{
					if($rsi[$j]["result"]==1)
						$list[$bettingSn]['win_count']+=1;
						
					$list[$bettingSn]['win_money'] = (int)($rs[$i]['betting_money']*$rs[$i]['result_rate']);
					$list[$bettingSn]['folder_bonus']=0;
					$memberSn = $rs[$i]['member_sn'];
					
					//폴더보너스 체크시 적용
					$levelConfigModel = Lemon_Instance::getObject("LevelConfigModel",true);
					
					$bonusRate = $levelConfigModel->getMemberFolderBounsRate($memberSn, $rs[$i]['betting_cnt']);
					$list[$bettingSn]['bonus_rate'] = $bonusRate;
					$list[$bettingSn]['folder_bonus'] = (int)($list[$bettingSn]['win_money']*$bonusRate/100);
					$list[$bettingSn]["item"][] = $rsi[$j];
				} // end of 2nd for
			}
		}

		foreach($list as $bettingSn => $item)
		{
			$rsi = $memberModel->getMemberRow($list[$bettingSn]["member_sn"]);
			$list[$bettingSn]['member'] = $rsi;
			
			$recommend_sn =  $rsi['recommend_sn'];
			if($recommend_sn!="")
				$partnerId = $partnerModel->getPartnerField($recommend_sn,"rec_id");
				
			$list[$bettingSn]['partner_id'] = $partnerId;
		}

		return $list;
	}
	
	
	//관리자 배팅현황
	public function getAdminBettingListTotal($childSn = "", $where = "") 
	{
		if($childSn!="") {
			$where.=" and b.sub_child_sn = (select sn from ".$this->db_qz."subchild where child_sn=".$childSn.")";
		}

		$rs = $this->getMemberBettingListTotal("", $where);
		return $rs;
	}
	
	//관리자 배팅취소현황
	public function getAdminBettingCancelListTotal($childSn="", $where="") 
	{
		$sql = "select count(distinct(a.betting_no)) as cnt
							from ".$this->db_qz."game_cart_cancel a,".$this->db_qz."game_betting_cancel b, ".$this->db_qz."member c
						where a.betting_no=b.betting_no and a.member_sn=c.sn
									and a.kubun ='Y' ".$where;
		
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 지정된 게임의 배팅 총합
	function getGameSnBettingListTotal($where="", $active=0, $gameSn="", $selectNo="")
	{
		if($active==1)
			$where.=" and a.result!=2 ";
			
		if($selectNo!="")
			$where.= " and b.select_no=".$selectNo;
		
		$sql = "select 	count(*) as cnt
				from "	.$this->db_qz."game_cart a,"
						.$this->db_qz."game_betting b,"
						.$this->db_qz."member e
				where	a.betting_no=b.betting_no
						and a.member_sn=e.sn
						and a.is_account=1 and a.kubun='Y'
						and b.sub_child_sn=".$gameSn.$where;
		
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 지정된 게임의 배팅 목록
	function getGameSnBettingList($where, $page, $page_size, $active=0, $gameSn="", $selectNo="")
	{
		if($active==1)
			$where.=" and a.result!=2 ";
			
		if($selectNo!="")
			$where.= " and b.select_no=".$selectNo;
		
		if($page_size!=0)
			$limit = "limit ".$page.",".$page_size;
		
		$sql = "select 	a.member_sn, a.betting_no, a.betting_money, a.betting_ip, a.regDate,
						a.result_money, a.result_rate, a.result as aresult, a.betting_cnt, 
						e.uid, e.nick, e.recommend_sn
				from "	.$this->db_qz."game_cart a,"
						.$this->db_qz."game_betting b,"
						.$this->db_qz."member e
				where	a.betting_no=b.betting_no
						and a.member_sn=e.sn
						and a.is_account=1 and a.kubun='Y'
						and b.sub_child_sn=".$gameSn.$where."
				order by a.betting_no desc ".$limit;
		
		$rs = $this->db->exeSql($sql);		
	
		$partnerModel = Lemon_Instance::getObject("PartnerModel",true);	
		for($i=0;$i<count((array)$rs); ++$i)
		{
			$member_sn = $rs[$i]['member_sn'];
			$betting_no =  $rs[$i]['betting_no'];
			$recommend_sn = $rs[$i]['recommend_sn'];
			
			$rsi = $this->getMemberBetDetailList($betting_no, $member_sn);			
		
			if($recommend_sn!="")
				$rec_id = $partnerModel->getPartnerField( $recommend_sn, 'rec_id');
				
			else $rec_id = "무소속";	
			
			$rs[$i]['win_count']=0;
			for($j=0; $j<count((array)$rsi); ++$j)
				if($rsi[$j]['result']==1) {$rs[$i]['win_count']+=1;}
			
			$rs[$i]['rec_id'] = $rec_id;
			$rs[$i]['item'] = $rsi;
		}

		return $rs;
	}
	
	function getMemberBetDetailList($betting_no, $member_sn)
	{		
		$sql = "select tb_temp.*, tb_markets.mname_ko, tb_markets.mfamily from 
					(select a.sn as total_betting_sn, a.sub_child_sn,a.select_no,a.select_rate,a.game_type,a.result,b.win_team,b.sport_id,
						b.sn as child_sn, b.home_team,b.away_team,b.home_score,b.away_score,b.special,b.gameDate,b.gameHour,b.gameTime, 
						b.notice AS league_name, d.win,a.home_rate,a.away_rate,a.draw_rate, d.home_line, d.home_name
				from ".$this->db_qz."game_betting a, ".$this->db_qz."child b, ".$this->db_qz."subchild d  
				where a.betting_no='".$betting_no."' and a.sub_child_sn=d.sn and b.sn=d.child_sn and a.member_sn = ".$member_sn.") AS tb_temp INNER JOIN tb_markets on tb_temp.game_type = tb_markets.mid ";
										
		$rs = $this->db->exeSql($sql);
		
		for($i = 0; $i < count((array)$rs); ++$i)
		{
			$gameDate = trim($rs[$i]['gameDate']);				
			$gameHour = trim($rs[$i]['gameHour']);
			$gameTime = trim($rs[$i]['gameTime']);
				
			$strDay = date('w',strtotime($gameDate));
			switch($strDay)
			{
			case 0: $Weekday_name = "(일)"; break;
			case 1: $Weekday_name = "(월)"; break;
			case 2: $Weekday_name = "(화)"; break;
			case 3: $Weekday_name = "(수)"; break;
			case 4: $Weekday_name = "(목)"; break;
			case 5: $Weekday_name = "(금)"; break;
			case 6: $Weekday_name = "(토)"; break;	
			}
			$g_date = substr($gameDate,5,2)."/".  substr($gameDate,8,2) . $Weekday_name ." ". $gameHour .":". $gameTime;	
			$rs[$i]['g_date'] = $g_date;
		}
	
		return $rs;
	}
	
	//▶ 배팅목록
	/*
		@param
			[$finish] -1=전체,0=ing, 1=finish
	*/
	public function getBettingList($memberSn, $page, $page_size, $chkFolder, $finish=-1,  $beginDate="", $endDate="", $specialFlag = 0) 
	{
		return $this->_bettingList($memberSn, $page, $page_size, $finish, -1, $beginDate, $endDate, 'b.gameDate desc, b.gameHour desc, b.gameTime desc', '', $specialFlag);
	}
	
	public function getBoardBettingItem($bettingNo)
	{
		return $this->_bettingList('', 0, 0,-1,-1,'', '', '', $bettingNo);
	}
	
	public function getBoardBettingItem_admin($bettingNo)
	{
		return $this->_bettingList_admin('', 0, 0,-1,-1,'', '', '', $bettingNo);
	}
	
	public function getBettingListTotal($memberSn, $finish=-1, $event=0, $beginDate='', $endDate='', $specialFlag='')
	{
		return $this->_bettingListTotal($memberSn, $finish, $event, $beginDate, $endDate, $specialFlag);
	}
	
	//▶ 게임결과 - 배당지급된 게임된 리스트
	public function getResultGameList($where="", $page, $page_size)
	{
		return $this->_resultList($where, $page, $page_size);
	}

	//▶ 게임결과 총합
	public function getResultGameListTotal($where="")
	{
		return $this->_gameListTotal($where);
	}

	// 오늘의 경기 개수 가져오기
	public function getGameCount() {
		date_default_timezone_set("Asia/Seoul");
		$sql = "select COUNT(a.sn) AS nCnt, a.sport_name from ".$this->db_qz."child  a
				where a.view_flag = 1 and a.status = 1 and CONCAT(a.gameDate, ' ', a.gameHour, ':', a.gameTime, ':00') > '" . date("Y-m-d H:i:s", time() + 1800) . "' group by a.sport_name";
        return $this->db->exeSql($sql);                         
    }

    public function getTodayGameCount() {
		date_default_timezone_set("Asia/Seoul");
		$sql = "select COUNT(a.sn) AS nCnt from ".$this->db_qz."child  a
				where a.view_flag = 1 and a.status = 1 and CONCAT(a.gameDate, ' ', a.gameHour, ':', a.gameTime, ':00') > '" . date("Y-m-d H:i:s", time() + 1800) . "'";
        return $this->db->exeSql($sql)[0]["nCnt"];
    }

	public function getTodayNations() {
		date_default_timezone_set("Asia/Seoul");
		$sql = "SELECT 
					c.sn,
					c.name,
					COUNT(c.sn) AS cnt,
					c.img AS lg_img,
					a.sport_name
				FROM
					tb_child a 
					INNER JOIN tb_league b 
					ON a.league_sn = b.`lsports_league_sn` 
					INNER JOIN tb_nation c 
					ON b.nation_sn = c.sn 
				WHERE CONCAT(a.gameDate, ' ', a.gameHour, ':', a.gameTime, ':00') > '" . date("Y-m-d H:i:s", time() + 1800) . "' AND a.view_flag = 1 AND a.status = 1 AND a.special < 4
				GROUP BY c.sn, c.name, a.sport_id";
		// echo $sql;
		// exit;
		return (array)$this->db->exeSql($sql);
	}

	public function getTodayLeagues($nation_sn = 0, $sport_name = "") {	
		date_default_timezone_set("Asia/Seoul");
		$sql = "SELECT
					b.lsports_league_sn AS league_sn, 
					b.name AS league_name,
					COUNT(b.`lsports_league_sn`) AS league_cnt
				FROM
					tb_child a 
					INNER JOIN tb_league b 
					ON a.league_sn = b.lsports_league_sn 
					INNER JOIN tb_nation n 
					ON b.nation_sn = n.sn 
				WHERE n.sn = '" . $nation_sn . "' 
					AND a.sport_name = '" . $sport_name . "' 
					AND CONCAT(a.gameDate, ' ', a.gameHour, ':', a.gameTime, ':00') > '" . date("Y-m-d H:i:s", time() + 1800) . "' 
					AND a.view_flag = 1 AND a.status = 1 AND a.special < 4
				GROUP BY b.`lsports_league_sn`";
		return $this->db->exeSql($sql);
	}

    public function bettingListTotal2($beginDate='', $endDate='')
    {
        $sql = "select count(*) mem_cnt, IFNULL(sum(bet_count),0) as bet_cnt, IFNULL(sum(betting_money),0) as bet_money, 
	                   ifnull(sum(win_cnt),0) as win_cnt, IFNULL(sum(win_money),0) as win_money  
                from (
						select member_sn, count(betting_no) as bet_count, sum(betting_money) as betting_money, sum(IF(result=1, 1, 0)) as win_cnt, sum(result_money) as win_money
						from tb_game_cart 
						where bet_date >= '{$beginDate}' and bet_date <= '{$endDate}' and is_account = 1
						group by member_sn
					) a;";

        $rs = $this->db->exeSql($sql);
        return $rs[0];
    }

    public function bettingCancelListTotal2($beginDate='', $endDate='')
    {
        $sql = "select count(tb_game_cart_cancel.sn) as cancel_count, IFNULL(sum(betting_money),0) as betting_money
                from tb_game_cart_cancel
                where operdate >= '$beginDate' and operdate <= '{$endDate}' and is_account = 1";

        $rs = $this->db->exeSql($sql);
        return $rs[0];
    }

    public function bettingListOfSport($beginDate='', $endDate='')
    {
        $sql = "SELECT
					tb_game_cart.last_special_code AS special,
					COUNT(tb_game_cart.sn) AS bet_cnt,
					IFNULL(
					SUM(tb_game_cart.betting_money),
					0
					) AS amt,
					tb_temp.live
				FROM
					tb_game_cart
					LEFT JOIN (SELECT betting_no, live FROM tb_game_betting GROUP BY betting_no) AS tb_temp
					ON tb_game_cart.betting_no = tb_temp.betting_no
				WHERE tb_game_cart.bet_date >= '{$beginDate}'
					AND tb_game_cart.bet_date <= '{$endDate}'
					AND (
					tb_game_cart.last_special_code < 5
					OR tb_game_cart.last_special_code = 50
					)
					AND tb_game_cart.is_account = 1
				GROUP BY tb_temp.live";

        $rs = $this->db->exeSql($sql);
        return $rs;
    }

    public function bettingListOfMini($beginDate='', $endDate='')
    {
        $sql = "select sum(c.betting_money) as bet_amt, count(c.sn) as bet_cnt, b.select_no, ch.special, ch.game_code
                from tb_game_cart c, tb_game_betting b, tb_subchild s, tb_child ch
                where c.last_special_code > 2 and c.last_special_code != 50
						and c.bet_date >= '{$beginDate}' and c.bet_date <= '{$endDate}'
						and c.is_account = 1 
						and c.betting_no = b.betting_no
						and b.sub_child_sn = s.sn
						and s.child_sn = ch.sn
                GROUP BY ch.game_code, b.select_no
                order by game_code, b.select_no";

        $rs = $this->db->exeSql($sql);
        return $rs;
    }

	public function getMinigameResult($member_sn, $special_type, $today) {
		$sql = "SELECT
					a.betting_no,
					a.result,
					a.bet_money,
					a.select_rate
				FROM
					tb_game_betting a
					LEFT JOIN tb_subchild b
					ON a.`sub_child_sn` = b.sn
					LEFT JOIN tb_child c
					ON b.child_sn = c.sn
				WHERE a.`member_sn` = {$member_sn}
					AND c.special = {$special_type}
					AND c.gameDate = '{$today}'";

		$rs = $this->db->exeSql($sql);
		return $rs;
	}
}
?>