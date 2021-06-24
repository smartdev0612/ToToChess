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
				from ".$this->db_qz."sport_list order by name asc";
				
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
		$sql = "select * 
						from ".$this->db_qz."league".$where." order by kind, name limit ".$page.",".$page_size."";
				
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
	function add($category = "", $league = "", $nationSn = 0) {
		$sql = "insert into tb_league (kind, name, alias_name, nation_sn) values ('".$category."','".$league."','".$league."','".$nationSn."')";
		$insert_sn = $this->db->exeSql($sql);
		
		$sql = "update tb_league set lsports_league_sn = '{$insert_sn}' where sn = '{$insert_sn}'";
		$this->db->exeSql($sql);

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
	function modify($sn, $category, $name, $viewStyle, $linkUrl, $alias = "") {
		$set = "";
		if ( $alias != "" ) $set = ", alias_name='".$alias."'";
		$set .= ", view_style='".$viewStyle."'";
		$set .= ", link_url='".$linkUrl."'";
		
		$sql = "update tb_league set kind = '{$category}', name = '{$name}' ".$set." where sn = '{$sn}'";
		return $this->db->exeSql($sql);
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
	
	//▶ 국가 목록
	function getNationList()
	{
		$sql = "select * from ".$this->db_qz."nation order by name asc"; 
		return $this->db->exeSql($sql);
	}
	
	//▶ 국가 목록
	function getNationByName($name)
	{
		$sql ="select * from ".$this->db_qz."nation where name like '%".$name."%'";
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
		
		$rs = $this->getLeagueImage($sn);
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			if(file_exists($uploadUri.$rs[$i]["lg_img"]))
				unlink($uploadUri.$rs[$i]["lg_img"]);
				
			if(file_exists($tempUri.$rs[$i]["lg_img"]))
				unlink($tempUri.$rs[$i]["lg_img"]);
		}
		
		$this->del($sn);
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
}
?>