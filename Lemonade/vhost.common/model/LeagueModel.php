<?php

class LeagueModel extends Lemon_Model 
{
	//▶ 필드 데이터 
	function getLeagueSnByName($name)
	{
		$sql = "select sn from ".$this->db_qz."league where name = '".$name."'";
				
		$rs = $this->db->exeSql($sql);		
		
		return $rs[0];
	}

    function getLeagueDataByName($name)
    {
        $sql = "select * from ".$this->db_qz."league where name = '".$name."'";

        $rs = $this->db->exeSql($sql);

        return $rs[0];
    }
	
	//▶ 필드 데이터
	function getCategoryField($sn, $field, $addWhere='')
	{
		$where = "idx=".$sn;
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		$rs = $this->getRow($field, $this->db_qz.'sport_list', $where);
		
		return $rs[$field];
	}
	
	//▶ 필드 데이터
	function getCategoryRow($sn, $field, $addWhere='')
	{
		$where = "idx=".$sn;
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		return $this->getRow($field, $this->db_qz.'sport_list', $where);
	}
	
	//▶ 카테고리 목록
	function getCategoryList()
	{
		$sql = "select * 
				from ".$this->db_qz."sport_list order by priority asc";
				
		return $this->db->exeSql($sql);
	}
	
	function modifyCategory($categorySn, $name)
	{
		if($categorySn!="")
		{
			$sql = "update ".$this->db_qz."sport_list
							set name='".$name."'
							where idx=".$categorySn;
		}
		else
		{
			$sql = "insert into ".$this->db_qz."sport_list(name) values('".$name."')";
		}
		return $this->db->exeSql($sql);
	}
	
	function deleteCategory($categorySn)
	{
		$sql = "delete from ".$this->db_qz."sport_list where idx=".$categorySn;
		return $this->db->exeSql($sql);
	}
	
	//▶ 리그 목록
	function getList($addWhere='', $page, $page_size)
	{
		$where='';
		if($addWhere!='') {$where=" where ".$addWhere;}
		$sql = "select tb_league.*, tb_nation.name as nation_name  
				from ".$this->db_qz."league left join tb_nation on tb_league.nation_sn = tb_nation.sn ".$where." order by tb_league.kind, tb_league.name limit ".$page.",".$page_size."";
		
		return $this->db->exeSql($sql);
	}
	
	//▶ 필드 데이터
	function getLeagueField($sn, $field, $addWhere='')
	{
		$where = "sn=".$sn;
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		$rs = $this->getRow($field, $this->db_qz.'league', $where);
		
		return $rs[$field];
	}
	
	//▶ 리그 추가
	function add($lsports_league_sn = 0, $kind = "", $name = "", $name_en = "", $nation_sn = 0, $sport_sn = 0, $viewStyle = "", $linkUrl = "", $alias = "", $is_use = 0) {
		
		$sql = "insert into tb_league (lsports_league_sn, nation_sn, sport_sn, kind, name, name_en, alias_name, view_style, link_url, is_use) values ('".$lsports_league_sn."','".$nation_sn."','".$sport_sn."','".$kind."','".$name."','".$name_en."','".$alias."','".$viewStyle."','".$linkUrl."','".$is_use."')";

		$insert_sn = $this->db->exeSql($sql);

		return $insert_sn;
	}

    function add2($category, $league, $lg_img, $nationSn) {
        $sql = "insert into tb_league (kind, name, alias_name, lg_img, nation_sn) values ('".$category."','".$league."','".$league."','".$lg_img."','".$nationSn."')";
        return $this->db->exeSql($sql);
    }

	//▶ 리그 이미지 저장
	function updateLeagueImg($leagueSn, $leagueImage) {
		$sql = "update tb_league set lg_img = '{$leagueImage}' where sn = '{$leagueSn}'";
		return $this->db->exeSql($sql);
	}

	//▶ 리그 목록	
	function getListAll($where='')
	{
		if($where!='') $where = " where ".$where;
		$sql = "select * from ".$this->db_qz."league ".$where." order by name asc";
		
		return $this->db->exeSql($sql);
	}
	
	//▶ 메인 카테고리 목록
	public function getCategoryMenuList()
	{
		$sql = "select idx, name 
						from ".$this->db_qz."sport_list 
				order by priority";
		$rs = $this->db->exeSql($sql);
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$rs[$i]['image'] = $this->getCategoryImage($rs[$i]['idx']);
		}
		
		return $rs;
	}
	
	//▶ 리그 목록
	function getListBySn($sn="")
	{
		$sql = "select * from ".$this->db_qz."league";
		if($sn!="")	$sql.=" where sn=".$sn;
		
		
		$rs = $this->db->exeSql($sql);
				
		return $rs[0];
	}

	function getListByLsportsLeagueSn($lsports_league_sn = 0)
	{
		$sql = "select * from ".$this->db_qz."league";
		if($lsports_league_sn != "")	$sql.=" where lsports_league_sn=".$lsports_league_sn;
		
		
		$rs = $this->db->exeSql($sql);
				
		return $rs[0];
	}
	//▶ 리그 목록
	function getListByName($name)
	{
		$sql = "select * from ".$this->db_qz."league where name='".$name."'";
		
		return $this->db->exeSql($sql);
	}
	
	//▶ 리그 목록
	function getListByLikeName($name)
	{
		$sql = "select * from ".$this->db_qz."league where name like('%".$name."%')";
		
		return $this->db->exeSql($sql);
	}
	
	//▶ 리그 목록
	function getListByCategory($category/*종목명*/)
	{
		$where="";	
		if($category!="") 	{$where=" where kind='".$category."'";}
		
		$sql = "select * from ".$this->db_qz."league ".$where." order by name asc";
		
		return $this->db->exeSql($sql);
	}
	
	//▶ 리그 총합
	function getTotal($addWhere='')
	{
		$where='';
		if($addWhere!='') {$where=" where ".$addWhere;}
		$sql = "select count(*) as cnt 
				from ".$this->db_qz."league".$where;
				
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 리그 변경
	function modify($sn, $lsports_league_sn, $category, $name, $name_en, $viewStyle, $linkUrl, $alias = "", $is_use = 0, $nation_sn = 0, $sport_sn = 0) {
		$set = "";
		if ( $alias != "" ) $set = ", alias_name='".$alias."'";
		$set .= ", view_style='".$viewStyle."'";
		$set .= ", link_url='".$linkUrl."'";
		$set .= ", is_use='".$is_use."'";
		$set .= ", nation_sn='".$nation_sn."'";

		$sql = "select * from tb_league where sn = " . $sn;
		$rs = $this->db->exeSql($sql);
		$old_league_sn = 0;
		if(count((array)$rs) > 0) {
			$old_league_sn = $rs[0]['lsports_league_sn'];
		}

		$sql = "update tb_child set league_sn = '{$lsports_league_sn}', notice = '{$name}' where league_sn = '{$old_league_sn}'";
		$this->db->exeSql($sql);

		$sql = "update tb_team set League_Id = '{$lsports_league_sn}', League_Name_Kor = '{$name}' where League_Id = '{$old_league_sn}'";
		$this->db->exeSql($sql);
		
		$sql = "update tb_league set lsports_league_sn = '{$lsports_league_sn}', sport_sn = '{$sport_sn}', kind = '{$category}', name = '{$name}', name_en = '{$name_en}' ".$set." where sn = '{$sn}'";
		$this->db->exeSql($sql);
	}

	//-> ▶ 기존 종목명 변경
	function modify_league_kind($leagueSn, $before_kind, $kind) {
		$sql = "update ".$this->db_qz."child set sport_name='".$kind."' where league_sn = '".$leagueSn."' and sport_name='".$before_kind."'";
		return $this->db->exeSql($sql);
	}

	//▶ 리그 삭제
	function del($sn)
	{
		$sql = "delete from ".$this->db_qz."league where sn in(".$sn.")";
		return $this->db->exeSql($sql);
	}
	
	//▶ 리그 이미지 파일
	function getLeagueImage($sn)
	{
		$sql = "select lg_img from ".$this->db_qz."league where sn in(".$sn.")";
		return $this->db->exeSql($sql);
	}

	function getLeagueListByKind($kind) {
		$sql = "select * from ".$this->db_qz."league where kind = '".$kind."'";
		return $this->db->exeSql($sql);
	}
	
	//▶ 국가 목록
	function getNationList()
	{
		$sql = "select * from ".$this->db_qz."nation where  order by name asc"; 
		return $this->db->exeSql($sql);
	}
	
	//▶ 국가 목록
	function getNationByName($name)
	{
		$sql ="select * from ".$this->db_qz."nation where is_use = 1 and name like '%".$name."%'";
		return $this->db->exeSql($sql);
	}

	//▶ 국가 목록
	function getNationImage($sn)
	{
		$sql = "select img from ".$this->db_qz."nation where sn = '".$sn."'";
		$rs = $this->db->exeSql($sql);
		return $rs[0]['img'];
	}

	//▶ process functions /////////////////////////////////////////////////////////////////////////
	
	//▶ 리그 삭제
	function delProcess($sn, $uploadUri="", $tempUri="")
	{
		/* $conf = Lemon_Configure::readConfig('config');
		
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
		
		$rs = $this->getLeagueImage($sn);
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			if(file_exists($uploadUri.$rs[$i]["lg_img"]))
				unlink($uploadUri.$rs[$i]["lg_img"]);
				
			if(file_exists($tempUri.$rs[$i]["lg_img"]))
				unlink($tempUri.$rs[$i]["lg_img"]);
		} */
		
		$this->del($sn);
	}

	function deleteSelectedLeagues($league_sn = "") {
		$sql = "delete from ".$this->db_qz."league where sn in (" . $league_sn . ")";
		$this->db->exeSql($sql);
	}
	
	public function getCategoryImage($cate_idx)
	{
		$image="";
		switch($cate_idx)
		{
		case 1: $image = "/img/icon/icon_soccer.png"; break;
		case 2: $image = "/img/icon/icon_baseball.png"; break;
		case 3: $image = "/img/icon/icon_basketball.png"; break;
		case 4: $image = "/img/icon/icon_volleyball.png"; break;
		case 5: $image = "/img/icon/icon_hockey.png"; break;
		case 6: $image = "/img/icon/icon_esports.png"; break;
		case 7: $image = "/img/icon/icon_tennis.png"; break;
		case 8: $image = "/img/icon/icon_handball.png"; break;
		case 9: $image = "/img/icon/icon_rugby.png"; break;
		default:$image = "/img/icon/icon_hockey.png";
		}
		return $image;
	}
	
	function ajaxList($where='')
	{
		$array = $this->getListAll($where);
		echo(json_encode($array));
		return;
	}

    function changeLeagueStatus($league_sn, $status) {
        $sql = "update tb_league set is_use = {$status} where sn = '{$league_sn}'";
        return $this->db->exeSql($sql);
    }

	function getLeagueByLsportsSn($lsports_league_sn = 0) {
		$sql = "SELECT * FROM tb_league WHERE lsports_league_sn = " . $lsports_league_sn;
		$res = $this->db->exeSql($sql);
		if(count((array)$res) > 0) {
			return $res[0];
		}
		return [];
	}
}
?>