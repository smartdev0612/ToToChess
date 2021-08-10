<?php

class TeamModel extends Lemon_Model 
{
    //▶ 팀 이미지 저장
	function updateTeamImg($teamSn, $teamImage) {
		$sql = "update tb_team set Team_Img = '{$teamImage}' where Team_Id = '{$teamSn}'";
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
		if($sn!="")	$sql.=" where Team_Id=".$sn;
		
		
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
	
	//▶ 팀 추가
	function add($category = "", $league = "", $nationSn = 0) {
		$sql = "insert into tb_team (kind, name, alias_name, nation_sn) values ('".$category."','".$league."','".$league."','".$nationSn."')";
		$insert_sn = $this->db->exeSql($sql);
		
		$sql = "update tb_team set Team_Id = '{$insert_sn}' where sn = '{$insert_sn}'";
		$this->db->exeSql($sql);

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
	function modify($sn = 0, $name = "") {
		$sql = "update tb_team set Team_Name_Kor = '{$name}' where Team_Id = '{$sn}'";
		$this->db->exeSql($sql);

		$sql = "update tb_child set home_team = '{$name}' where home_team_id = '{$sn}'";
		$this->db->exeSql($sql);

		$sql = "update tb_child set away_team = '{$name}' where away_team_id = '{$sn}'";
		return $this->db->exeSql($sql);
	}

	//▶ 팀 삭제
	function del($sn)
	{
		$sql = "delete from ".$this->db_qz."team where Team_Id in(".$sn.")";
		return $this->db->exeSql($sql);
	}
	
	//▶ 팀 이미지 파일
	function getTeamImage($sn)
	{
		$sql = "select Team_Img from ".$this->db_qz."team where Team_Id in(".$sn.")";
		return $this->db->exeSql($sql);
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