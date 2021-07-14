<?php

class MemoModel extends Lemon_Model 
{
	//▶ 메모 삭제 
	function delMemberMemo($memoSn)
	{
		$sql = "delete from ".$this->db_qz."memoboard 
						where mem_idx='".$memoSn."'";	
		
		return $this->db->exeSql($sql);
	}
	
	//▶ 쪽지
	function getMemoList($where, $page, $page_size, $addOrderby='mem_idx desc')
	{
		$orderby="";
		
		if($addOrderby!='') {$orderby = " order by ".$addOrderby;}
		
		$sql = "select * from ".$this->db_qz."memoboard 
						where 1=1 ".$where.$orderby.
						" limit ".$page.",".$page_size;
	
		$rs = $this->db->exeSql($sql);
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$rs[$i]['idx'] = $i+1;
		}
		return $rs;
	}
	
	//▶ 총합
	function getMemoTotal($where='')
	{
		$sql = "select count(*) as cnt from ".$this->db_qz."memoboard 
						where 1=1 ".$where;
				
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 특정 발신인 쪽지
	// $where에는 and 가 삽입된채로 넘어와야 함.
	function getFromMemoTotal($fromid, $addWhere='')
	{
		$where = " and fromid='".$fromid."' ";
		if($addWhere!='') 	{$where = $where.' and '.$addWhere;}
		return $this->getMemoTotal($where);
	}
	
	function getFromMemoList($fromid, $addWhere='', $page, $page_size)
	{
		$where = " and fromid='".$fromid."' ";
		if($addWhere!='') 	{$where = $where.' and '.$addWhere;}		
	
		return $this->getMemoList($where, $page, $page_size, ' writeday desc ');
	}
	
	//▶ 쪽지 검색
	function getAdminMemoTotal($kewyword="", $field="uid")
	{
		if($kewyword!="")
		{
			if($field=="uid")								{$where = " and toid in (select uid from ".$this->db_qz."member where uid like('%".$kewyword."%'))";}
			else if($field=="nick")					{$where = " and toid in (select uid from ".$this->db_qz."member where nick like('%".$kewyword."%'))";}
			else if($field=="bank_member")	{$where = " and toid in (select uid from ".$this->db_qz."member where bank_member like('%".$kewyword."%'))";}
		}
		
		$sql = "select count(*) as cnt from ".$this->db_qz."memoboard
						where fromid='운영팀' and 1=1 ".$where;
	
		$rs = $this->db->exeSql($sql);
		
		return $rs[0]['cnt'];
	}
	
	//▶ 관리자 쪽지 목록
	function getAdminMemoList($kewyword="", $field="uid", $page, $page_size)
	{
		if($kewyword!="")
		{
			if($field=="uid")								{$where = " and a.toid in (select uid from ".$this->db_qz."member where uid like('%".$kewyword."%'))";}
			else if($field=="nick")					{$where = " and a.toid in (select uid from ".$this->db_qz."member where nick like('%".$kewyword."%'))";}
			else if($field=="bank_member")	{$where = " and a.toid in (select uid from ".$this->db_qz."member where bank_member like('%".$kewyword."%'))";}
		}
		$sql = "select a.*, b.nick, b.bank_member from ".$this->db_qz."memoboard a, ".$this->db_qz."member b
						where a.toid=b.uid and a.fromid='운영팀' and 1=1 ".$where."
						order by writeday desc
						limit ".$page.",".$page_size;
					
		return $this->db->exeSql($sql);
	}
	
	//▶ 특정 수신인 쪽지
	function getToMemoTotal($toid, $addWhere='')
	{
		$where = " and toid='".$toid."' ";
		
		if($addWhere!='') 	{$where = $where.' and '.$addWhere;}
		
		return $this->getMemoTotal($where, ' writeday desc ');
	}

	function getToMemoList($toid, $addWhere='', $page, $page_size)
	{
		$where = " and toid='".$toid."' ";
		
		if($addWhere!='') 	{$where= $where.' and '.$addWhere;}
		
		return $this->getMemoList($where, $page, $page_size);
	}
	
	function modifyMemoRead($sn)
	{
		$sql = "update ".$this->db_qz."memoboard set newreadnum='1' 
				where mem_idx='".$sn."'";
		
		return $this->db->exeSql($sql);						
	}
	
	function delMemo($sn)
	{
		$sql = "delete from ".$this->db_qz."memoboard 
						where mem_idx='".$sn."'";
		return $this->db->exeSql($sql);						
	}
	
	function moidifyMemberMemoDel($sn)
	{
		$sql = "update ".$this->db_qz."memoboard 
				set isdelete=1 
					where mem_idx=".$sn;
					
		return $this->db->exeSql($sql);
	}

	//▶ 사용자 총 메모수
	function getMemberMemoTotal($uid)
	{
		$where = " and toid='".$uid."' and newreadnum=0 and isdelete=0";
		return $this->getMemoTotal($where);
	}
	
	//▶ 유저 메모
	function getMemberMemo($sn)
	{
		$sql = "select * 
				from ".$this->db_qz."memoboard where mem_idx = '".$sn."' ";
						
		$rs = $this->db->exeSql($sql);
		return $rs[0];
	}
	
	//▶ 유저 메모 목록
	function getMemberMemoList($uid, $page, $page_size, $read=""/*1로 할 경우 리스업과 동시에 읽은것으로 처리*/)
	{
		$sql = "select * 
						from ".$this->db_qz."memoboard 
						where toid = '".$uid."' and isdelete=0 
						order by newreadnum asc, writeday desc  limit ".$page.",".$page_size; 
						
		$rs = $this->db->exeSql($sql);
		
		if($read==1)
		{
			for($i=0; $i<count((array)$rs); ++$i)
			{
				$sn = $rs[$i]['mem_idx'];
				$this->modifyMemoRead($sn);
			}
		}
		
		return $rs;
	}
	
	//▶ 읽지 않은 메모수
	function getMemberNewMemoTotal($uid)
	{
		$where = " and toid='".$uid."' and newreadnum=0 and isdelete=0";
		
		return $this->getMemoTotal($where);
	}
	
	//▶ 읽지 않은 메모 목록
	function getMemberNewMemoList($uid)
	{
		$total = $this->getMemberNewMemoTotal($uid);
		$where = " and toid='".$uid."' and newreadnum=0 and isdelete=0";
		
		return $this->getMemoList($where, 0, $total, " writeday desc ");
	}
	
	//▶ 쪽지
	function getMemberNote($sn)
	{
		$sql = "select regdate, memo, sn
						from ".$this->db_qz."member_note
						where member_sn='".$sn."' order by regdate desc";
							
		return $this->db->exeSql($sql);
	}
	
	//▶ 쓰기
	function writeMemo($fromid, $toid, $subject, $content, $kubun='0'/*kubun*/, $logo='', $p_type = 0)
	{
		if ( !$logo ) $logo = $this->logo;
		$sql = "insert into ".$this->db_qz."memoboard (fromid,toid,title,content,writeday,newreadnum,kubun,logo,p_type) 
						values ('".$fromid."','".$toid."','".$subject."','".$content."',now(),0,".$kubun.",'".$logo."','".$p_type."')";
		return $this->db->exeSql($sql);
	}
	
	//▶ 단체 쓰기
	function writeGroupMemo($where="", $subject, $content)
	{
		$sql = "select sn, uid from ".$this->db_qz."member 
						where (mem_status='N' or mem_status='W') ".$where."";
		$rs = $this->db->exeSql($sql);
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$toid = $rs[$i]["uid"];
			$this->writeMemo('운영팀', $toid, $subject, $content);
		}
		
		return $rs;
	}
	
	
	
	//▶ 파트너 메모쓰기
	function writePartnerMemo($toid, $title, $content, $p_type = 0)
	{
		$pModel = Lemon_Instance::getObject("PartnerModel",true);
		
		if($toid=="")
		{
			$rs = $pModel->getPartnerIdList('', $p_type);
			
			for($i = 0; $i < count((array)$rs); ++$i )
			{
				$toid = $rs[$i]['rec_id'];
				$this->writeMemo('운영팀', $toid, $title, $content, '1', '', $p_type);
			}
		}
		else
		{
			$this->writeMemo('운영팀', $toid, $title, $content, '1', '', $p_type);			
		}
	}
	
	//▶ 삭제 (영구삭제로 교체)
	function delMemoByMemberSn($sn)
	{
		//$sql = "update ".$this->db_qz."memoboard set isdelete='1' where mem_idx in(".$sn.")";
		$sql = "delete from tb_memoboard where mem_idx in(".$sn.")";
		return $this->db->exeSql($sql);
	}
	
	//▶ 쪽지 전체삭제
	function deleteAllMemo($memberId)
	{
		$sql = "update ".$this->db_qz."memoboard set isdelete='1' where toid='".$memberId."'";
		return $this->db->exeSql($sql);
	}

	//▶ 쪽지 전체읽음
	function readAllMemo($memberId)
	{
		$sql = "update ".$this->db_qz."memoboard set newreadnum='1' where toid='".$memberId."'";
		return $this->db->exeSql($sql);
	}
}

?>