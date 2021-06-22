<?php
class CollectModel extends Lemon_Model
{
	//▶ 수집 삭제
	function del()
	{
		$sql = "delete from ".$this->db_qz."collect";
		$this->db->exeSql($sql);
		
		$sql = "truncate table ".$this->db_qz."collect";
		return $this->db->exeSql($sql);
	}
	
	function add($gameDate, $arrContent, $rate1, $rate2, $rate3)
	{
		$sql = "insert into ".$this->db_qz."collect(game_num,game_date,game_hours,game_minute,game_second,league_num,league_name,team1_num,team2_num,team1_name,team2_name,";
		$sql.= "a_rate1,a_rate2,a_rate3,b_rate1,b_rate2,b_rate3,data1,collect_date)values('".Trim($arrContent[0])."',DATE_FORMAT('".$gameDate."','%Y-%m-%d'),";
		$sql.= " DATE_FORMAT('".$gameDate."','%H'),DATE_FORMAT('".$gameDate."','%i'),DATE_FORMAT('".$gameDate."','%s'),'".Trim($arrContent[2])."','".Trim($arrContent[3])."',";
		$sql.= " '".Trim($arrContent[4])."','".Trim($arrContent[5])."','".Trim($arrContent[6]).$strHomeName."','".Trim($arrContent[7])."','".Trim($arrContent[8])."','".Trim($arrContent[9])."',";
		$sql.= " '".Trim($arrContent[10])."','".$rate1."','".$rate2."','".$rate3."','".Trim($arrContent[14])."',now())";

		return $this->db->exeSql($sql);
	}

    function add2($game)
    {
        $sql = "insert into ".$this->db_qz."collect(game_date,game_hours,game_minute,game_second,league_name, lg_img, team1_name,team2_name,";
        $sql.= "a_rate1,a_rate2,a_rate3,b_rate1,b_rate2,b_rate3, collect_date)values('".$game["game_date"]."','" . $game["game_hours"]."',";
        $sql .= "'". $game["game_minute"] ."','00', '" . $game['league_name'] . "','".$game['lg_img']."','".$game['team1_name']."','";
        $sql .= $game['team2_name']."','".$game['a_rate1']."','".$game['a_rate2']."','".$game['a_rate3']."','0','0','0', now())";

        return $this->db->exeSql($sql);
    }

	function getList($where='', $groupby='')
	{
		$sql = "select * 
				from ".$this->db_qz."collect ";
				
		if($where!='') 	$sql.=" where ".$where;
		if($groupby!='')$sql.=" group by ".$groupby;
				
		$rs = $this->db->exeSql($sql);
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$rs[$i]["i"] = $i;
			$strDay = date('w',strtotime($rs[$i]["game_date"]));
			$rs[$i]["rate_flag"]=$rs[$i]["b_rate1"]*$rs[$i]["b_rate1"]*$rs[$i]["b_rate1"];
			switch($strDay)
			{
				case '0': $rs[$i]["week"]="일"; break;
				case '1': $rs[$i]["week"]="월"; break;
				case '2': $rs[$i]["week"]="화"; break;
				case '3': $rs[$i]["week"]="수"; break;
				case '4': $rs[$i]["week"]="목"; break;
				case '5': $rs[$i]["week"]="금"; break;
				case '6': $rs[$i]["week"]="토"; break;
			}
		}
		return $rs;
	}
	
	function getLastDate()
	{
		$sql = "select collect_date 
				from ".$this->db_qz."collect";
				
		return $this->db->exeSql($sql);
	}
	
	//▶ 필드 데이터
	function getCollectRow($field, $addWhere='')
	{
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		$rs = $this->getRow($field, $this->db_qz.'collect', $where);
		return $rs[$field];
	}
	
	//▶ 필드 데이터's
	function getCollectRows($field, $addWhere='')
	{
		if($addWhere!='') {$where .=' and '.$addWhere;}
		return $this->getRows($field, $this->db_qz.'collect', $where);
	}
}
?>