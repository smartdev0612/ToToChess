<?php

class GameBlockModel extends Lemon_Model
{
	//▶ 필드 데이터 
	function getLeagueSnByName($name)
	{
		$sql = "select sn from ".$this->db_qz."block_game where name = '".$name."'";
				
		$rs = $this->db->exeSql($sql);		
		
		return $rs[0];
	}

    function getLeagueDataByName($name)
    {
        $sql = "select * from ".$this->db_qz."block_game where name = '".$name."'";

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
						from ".$this->db_qz."block_game".$where." order by sn limit ".$page.",".$page_size."";
				
		return $this->db->exeSql($sql);
	}
	
	//▶ 필드 데이터
	function getLeagueField($sn, $field, $addWhere='')
	{
		$where = "sn=".$sn;
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		$rs = $this->getRow($field, $this->db_qz.'block_game', $where);
		
		return $rs[$field];
	}
	
	//▶ 리그 추가
	function add($category, $league) {
		$sql = "insert into tb_league_block (kind, name) values ('".$category."','".$league."')";
		return $this->db->exeSql($sql);
	}

	//▶ 리그 이미지 저장
	function updateLeagueImg($leagueSn, $leagueImage) {
		$sql = "update tb_league_block set lg_img = '{$leagueImage}' where sn = '{$leagueSn}'";
		return $this->db->exeSql($sql);
	}

	//▶ 리그 목록	
	function getListAll($where='')
	{
		if($where!='') $where = " where ".$where;
		$sql = "select * from ".$this->db_qz."block_game ".$where." order by name asc";
		
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
		$sql = "select * from ".$this->db_qz."block_game";
		if($sn!="")	$sql.=" where sn=".$sn;
		
		
		$rs = $this->db->exeSql($sql);
				
		return $rs[0];
	}
	//▶ 리그 목록
	function getListByName($name)
	{
		$sql = "select * from ".$this->db_qz."block_game where name='".$name."'";
		
		return $this->db->exeSql($sql);
	}
	
	//▶ 리그 목록
	function getListByLikeName($name)
	{
		$sql = "select * from ".$this->db_qz."block_game where name like('%".$name."%')";
		
		return $this->db->exeSql($sql);
	}
	
	//▶ 리그 목록
	function getListByCategory($category/*종목명*/)
	{
		$where="";	
		if($category!="") 	{$where=" where kind='".$category."'";}
		
		$sql = "select * from ".$this->db_qz."block_game ".$where." order by name asc";
		
		return $this->db->exeSql($sql);
	}
	
	//▶ 리그 총합
	function getTotal($addWhere='')
	{
		$where='';
		if($addWhere!='') {$where=" where ".$addWhere;}
		$sql = "select count(*) as cnt 
				from ".$this->db_qz."block_game".$where;
				
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 리그 변경
	function modify($sn, $category, $name) {
		$sql = "update tb_league_block set kind = '{$category}', name = '{$name}' where sn = '{$sn}'";
		return $this->db->exeSql($sql);
	}

	//▶ 리그 삭제
	function del($sn)
	{
		$sql = "delete from ".$this->db_qz."block_game where sn in(".$sn.")";
		return $this->db->exeSql($sql);
	}
	
	//▶ 리그 삭제
	function delProcess($sn, $uploadUri="", $tempUri="")
	{
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

	//▶ 경기 총합
	function getGameTotal($where)
	{
		$sql = "SELECT count(*) as cnt 
				FROM ".$this->db_qz."child 
				WHERE CONCAT(gameDate, ' ', gameHour, ':', gameTime, ':00') > '" . date("Y-m-d H:i:s", time() + 1800) . "' 
						AND sport_id > 0 " . $where;
				
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}

	//▶ 경기리스트
	function getGameList($where, $page, $page_size)
	{
		$sql = "SELECT *
				FROM  ".$this->db_qz."child
				WHERE  CONCAT(gameDate, ' ', gameHour, ':', gameTime, ':00') > '" . date("Y-m-d H:i:s", time() + 1800) . "' 
						AND sport_id > 0 " . $where . "
				ORDER BY gameDate, gameHour, gameTime LIMIT " . $page . ", " . $page_size;
				
		$rs = $this->db->exeSql($sql);
		return $rs;
	}

	function updateBlockField($child_sn, $flag) {
		$sql = "UPDATE tb_child SET `block` = " . $flag . " WHERE sn = " . $child_sn;
		$rs = $this->db->exeSql($sql);
		return $rs;
	}

	//▶ 경기차단
	function blockFixture($childSn) {
		$res["msg"] = "경기차단에 실패하였습니다.";
		$res["status"] = 0;
		$rs = $this->updateBlockField($childSn, 1);
		if($rs) {
			$res["msg"] = "경기차단에 성공하였습니다.";
			$res["status"] = 1;
		}
		return json_encode($res);
	}

	//▶ 경기차단 취소
	function cancelBlock($childSn) {
		$res["msg"] = "경기차단을 취소하지 못하였습니다.";
		$res["status"] = 0;
		$rs = $this->updateBlockField($childSn, 0);
		if($rs) {
			$res["msg"] = "경기를 활성화하였습니다.";
			$res["status"] = 1;
		}
		return json_encode($res);
	}
}
?>