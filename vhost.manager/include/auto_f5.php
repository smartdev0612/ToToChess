<?php
include_once("common.php");

$sql = "SELECT count(idx) as idx FROM ".$db_qz."money WHERE logo='".$logo."' and result = 0 and kubun=0 ";
$db->mysql=$sql;
$db->getresule();
If ($db->getrow()){
	 $chargingCnt = $db->row["idx"];	//新充值
}


$sql = "SELECT count(idx) as idx FROM ".$db_qz."money WHERE logo='".$logo."' and result = 0 and kubun=1";
$db->mysql=$sql;
$db->getresule();
If ($db->getrow()){
	$exchangeCnt = $db->row["idx"];	//新换钱
}

$sql = "SELECT count(ref) as ref FROM ".$db_qz."board WHERE logo='".$logo."' and hit < 3 ";
$db->mysql=$sql;
$db->getresule();
If ($db->getrow()){
	$board = $db->row["ref"];	//新文章
}

$sql = "SELECT count(idx) as idx FROM ".$db_qz."question WHERE logo='".$logo."' and result = '0' and reply='0' ";
//echo $sql."<br>";
$db->mysql=$sql;
$db->getresule();
If ($db->getrow()){
	$question =$db->row["idx"];	//新1：1问答
}

$sql = "SELECT count(idx) as idx FROM ".$db_qz."member WHERE logo='".$logo."' and  isStop = 'W' ";
$db->mysql=$sql;
$db->getresule();
If ($db->getrow()){
	$newmember = $db->row["idx"];	//新注册用户
}

$sql = "SELECT count(mem_idx) as idx  FROM ".$db_qz."memoboard WHERE logo='".$logo."' and newreadnum<>1 AND toid='운영팀'";
$db->mysql=$sql;
$db->getresule();
If ($db->getrow()){
	$newmemo = $db->row["idx"];	//查未读纸条数
}

$sql = "SELECT count(mem_idx) as idx FROM ".$db_qz."memoboard WHERE logo='".$logo."' and  toid='운영팀'";
$db->mysql=$sql;
$db->getresule();
If ($db->getrow()){
	$allmemo = $db->row["idx"];	//查总共纸条数
}

$sql = "SELECT count(id) as idx FROM ".$db_qz."sms WHERE  status=0 and logo='".$logo."'";
$db->mysql=$sql;
$db->getresule();
If ($db->getrow()){
	$smsnum = $db->row["idx"];	//查总共纸条数
}
$sql = "SELECT count(*) as idx FROM ".$db_qz."recommend WHERE  status=2 and logo='".$logo."'";
$db->mysql=$sql;
$db->getresule();
If ($db->getrow()){
	$recnum = $db->row["idx"];	//查申请partner的个数
}

$db->dbclose();
$str=array();
$str[]=$chargingCnt."@@@".$exchangeCnt."@@@".$board."@@@".$question."@@@".$newmember."@@@".$newmemo."@@@".$allmemo."@@@".$smsnum."@@@".$recnum;
echo $str[0];
//echo urlencode(join("###",$arry));
?>