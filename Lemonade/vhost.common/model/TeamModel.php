<?php

class TeamModel extends Lemon_Model 
{
    //▶ 팀 이미지 저장
	function updateTeamImg($teamSn, $teamImage) {
		$sql = "update tb_team set Team_Img = '{$teamImage}' where t_idx = '{$teamSn}'";
		return $this->db->exeSql($sql);
	}

	//▶ 팀 목록
	function getList($addWhere='', $page, $page_size)
	{
		$where = '';

		if($addWhere!='') 
        {
            $where .= $addWhere;
        }

        $sql = "SELECT
					tb_team.`t_idx`,
                    tb_team.`Team_Id`,
                    tb_team.Sport_Name,
                    tb_team.`Team_Name_Kor`,
					tb_team.`Team_Name`,
                    tb_team.Location_Name_Kor,
                    tb_team.Team_Img,
                    tb_team.League_Name_Kor
                FROM
                    tb_team
                WHERE tb_team.`Sport_Id` IN (SELECT tb_sports.sn FROM tb_sports WHERE tb_sports.use = 1) " . $where;

        $sql .= " ORDER BY tb_team.`Sport_Name` LIMIT " . $page . ", " . $page_size;
        
		return $this->db->exeSql($sql);
	}

    //▶ 팀 목록
	function getListBySn($sn="")
	{
		$sql = "select * from ".$this->db_qz."team";
		if($sn!="")	$sql.=" where t_idx=".$sn;
		
		
		$rs = $this->db->exeSql($sql);
				
		return $rs[0];
	}
	
	//▶ 필드 데이터
	function getTeamField($sn, $field, $addWhere='')
	{
		$where = "Team_Id=".$sn;
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		$rs = $this->getRow($field, $this->db_qz.'team', $where);
		
		return $rs[$field];
	}

	function getTeamName($team_id = 0) {
		$sql = "select Team_Name_Kor from tb_team where Team_Id = " . $team_id;
		$rs = $this->db->exeSql($sql);
		$team_name = "";
		if(count((array)$rs) > 0) {
			$team_name = $rs[0]["Team_Name_Kor"];
		}
		return $team_name;
	}
	
	//▶ 팀 추가
	function add($team_api_id, $kind, $sport_sn, $league, $league_name, $nation_sn, $nation_name, $team_name, $team_name_en) {
		$sql = "insert into tb_team (Sport_Name, Sport_Id, Location_Id, Location_Name_Kor, League_Id, League_Name_Kor, Team_Id, Team_Name, Team_Name_Kor) values ('".$kind."','".$sport_sn."','".$nation_sn."','".$nation_name."','".$league."','".$league_name."','".$team_api_id."','".$team_name_en."','".$team_name."')";
		$insert_sn = $this->db->exeSql($sql);
		
		return $insert_sn;
	}

	//▶ 팀 총합
	function getTotal($addWhere='')
	{
		$where='';
		if($addWhere!='') {$where .= $addWhere;}
		$sql = "select count(*) as cnt 
				from ".$this->db_qz."team where Team_Id > 0 ".$where;
				
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 팀 변경
	function modify($teamSn = 0, $team_api_id = 0, $kind = "", $sport_sn = 0, $league = 0, $league_name = "", $nation_sn = 0, $nation_name = "", $team_name = "", $team_name_en = "") {
		$sql = "UPDATE tb_team SET Sport_Name = '{$kind}', Sport_Id = '{$sport_sn}', League_Id = '{$league}', League_Name_Kor = '{$league_name}', Location_Id = '{$nation_sn}', Location_Name_Kor = '{$nation_name}', Team_Id = '{$team_api_id}', Team_Name_Kor = '{$team_name}', Team_Name = '{$team_name_en}' WHERE t_idx = '{$teamSn}'";
		$this->db->exeSql($sql);

		$sql = "UPDATE tb_child SET home_team = '{$team_name}' WHERE home_team_id = '{$team_api_id}'";
		$this->db->exeSql($sql);

		$sql = "UPDATE tb_child SET away_team = '{$team_name}' WHERE away_team_id = '{$team_api_id}'";
		$this->db->exeSql($sql);

		return $teamSn;
	}

	//▶ 팀 삭제
	function del($sn)
	{
		$sql = "delete from ".$this->db_qz."team where t_idx in(".$sn.")";
		return $this->db->exeSql($sql);
	}
	
	//▶ 팀 이미지 파일
	function getTeamImage($sn)
	{
		$sql = "select Team_Img from ".$this->db_qz."team where t_idx in(".$sn.")";
		return $this->db->exeSql($sql);
	}

	function deleteSelectedTeams($sn = "") {
		$sql = "delete from ".$this->db_qz."team where t_idx in (" . $sn . ")";
		$this->db->exeSql($sql);
	}

	//▶ 팀 삭제
	function delProcess($sn, $uploadUri="", $tempUri="")
	{
		$conf = Lemon_Configure::readConfig('config');
		
		if($uploadUri=="")
		{
			if($conf['site']!='')
				$uploadUri = $conf['site']['upload_url'];
		}
		if($tempUri=="")
		{
			if($conf['site']!='')
				$tempUri = $conf['site']['local_upload_url'];
		}
		
		$rs = $this->getTeamImage($sn);
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			if(file_exists($uploadUri.$rs[$i]["Team_Img"]))
				unlink($uploadUri.$rs[$i]["Team_Img"]);
				
			if(file_exists($tempUri.$rs[$i]["Team_Img"]))
				unlink($tempUri.$rs[$i]["Team_Img"]);
		}
		
		$this->del($sn);
	}
}
?>