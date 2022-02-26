<?php
/**
 * ProcessModel.php
 *--------------------------------------------------------------------
 *
 * working set - frequently updated process set
 *
 *--------------------------------------------------------------------
 * Copyright (C) 
 * http://www.monaco.com
 */
class ProcessModel extends Lemon_Model 
{
	public $memberModel	='';
	public $gameModel	='';
	public $cartModel	='';
	public $moneyModel	='';
	public $configModel	='';
	public $commonModel	='';
	public $boardModel	='';
	
	function __construct()
	{
		$this->memberModel 	= Lemon_Instance::getObject("MemberModel",true);
		$this->gameModel 	= Lemon_Instance::getObject("GameModel",true);
		$this->cartModel 	= Lemon_Instance::getObject("CartModel",true);
		$this->moneyModel  	= Lemon_Instance::getObject("MoneyModel",true);
		$this->configModel  = Lemon_Instance::getObject("ConfigModel",true);
		$this->commonModel  = Lemon_Instance::getObject("CommonModel",true);
		$this->partnerModel  = Lemon_Instance::getObject("PartnerModel",true);
		$this->levelConfigModel = Lemon_Instance::getObject("LevelConfigModel",true);
		$this->boardModel = Lemon_Instance::getObject("BoardModel",true);
	}
	
	/**
	*--------------------------------------------------------------------
 	*
 	* betting process
 	*
 	*--------------------------------------------------------------------
 	*/
 	
 	function bettingProcess($sn, $amount)
 	{
 		$this->modifyMoneyProcess($sn, -$amount, 3, '배팅');
 	}

    function bettingProcess2($sn, $amount, $betting_no)
    {
        $this->modifyMoneyProcess($sn, -$amount, 3, '배팅', $betting_no);
    }

	//▶ 취소
	function bettingCancelProcess($bettingNo, $cancel_id = "관리자")
	{
		//이미 취소했는지 여부 판단
		$sql = "select count(betting_no) as cnt from ".$this->db_qz."money_log where state=5 and betting_no='".$bettingNo."'";
		$rs = $this->db->exeSql($sql);
		if($rs[0]['cnt']>0)
			return;
						
		$sql = "select member_sn, parent_sn, betting_money, result_money, bonus, result from ".$this->db_qz."game_cart where betting_no='".$bettingNo."'";
		$rs = $this->db->exeSql($sql);
		
		$sn					= $rs[0]["member_sn"];
		$parentIdx	= $rs[0]["parent_sn"];
		$betMoney		= $rs[0]["betting_money"];
		$result			= $rs[0]["result"];
		
		if ( $result == 0 ) {
			$this->modifyMoneyProcess($sn, $betMoney, 5, $bettingNo);
			$this->cartModel->delCart($bettingNo, $cancel_id);
		}
    }

	//▶ 취소 (다기준)
	function bettingCancelProcessMulti($bettingNo)
	{
		//이미 취소했는지 여부 판단
		$sql = "select count(betting_no) as cnt from ".$this->db_qz."money_log where state=5 and betting_no='".$bettingNo."'";
		$rs = $this->db->exeSql($sql);
		if($rs[0]['cnt']>0)
			return;
						
		$sql = "select member_sn, parent_sn, betting_money, result_money, bonus, result from ".$this->db_qz."game_cart where betting_no='".$bettingNo."'";
		$rs = $this->db->exeSql($sql);
		
		$sn					= $rs[0]["member_sn"];
		$parentIdx	= $rs[0]["parent_sn"];
		$betMoney		= $rs[0]["betting_money"];
		$result			= $rs[0]["result"];
		
		if ( 0 == $result ) {
			$this->modifyMoneyProcess($sn, $betMoney, 5, $bettingNo);
			$this->cartModel->delCart($bettingNo);
		}
    }
    
    function bettingWinLoseProcess($bettingNo, $winlose) {
        $sql = "SELECT sn, member_sn, betting_no, select_no, select_rate, bet_money FROM tb_game_betting WHERE betting_no=".$bettingNo;
        $res = $this->db->exeSql($sql);
        for ( $i = 0 ; $i < count((array)$res) ; $i++ ) {
            $betSn = $res[$i]["sn"];
            $member_sn = $res[$i]["member_sn"];
            $betting_no = $res[$i]["betting_no"];
            $select = $res[$i]["select_no"];
            $select_rate	= $res[$i]["select_rate"];
            $betMoney = $res[$i]["bet_money"];

            //-> 파일로그와 DB의 배팅방향이 틀리면 tb_game_betting->checked에 둘다 로그방향을 저장하고 로그 기반으로 현재 배팅방향 업데이트.
            $sql = "select bet_date from tb_game_cart where betting_no = '{$betting_no}'";
            $cartInfo = $this->db->exeSql($sql);
            $bet_date = str_replace("-","",substr($cartInfo['bet_date'],0,10));

            $fileName = $bet_date."_".$member_sn.".log";
            $logFile = @fopen("/var/backup/_logs/user/".$fileName,"r");
            if ( $logFile ) {
                unset($bettingLogArray);
                while ( !feof($logFile) ) {
                    $bettingLog = fgets($logFile);
                    if ( strlen(trim($bettingLog)) > 0 ) $bettingLogArray[] = str_replace("'","\"",$bettingLog);
                }
                if ( count((array)$bettingLogArray) > 0 ) {
                    $bettingLogArrayJson = implode(",",$bettingLogArray);
                    $bettingLogArray = json_decode("{".$bettingLogArrayJson."}",true);
                }
                @fclose($logFile);

                $logBettingSelect = $bettingLogArray[$betting_no."_".$subChildSn];
                if ( $logBettingSelect > 0 and $logBettingSelect != $select ) {
                    $sql = "UPDATE tb_game_betting SET select_no = '{$logBettingSelect}', checked = '{$select}->{$logBettingSelect}' WHERE sn = '".$betSn."'";
                    $this->db->exeSql($sql);
                    $select = $logBettingSelect;
                }
            }
            //------------------------------------------------------------------------------------

            $winCode = $winlose;
            $result = $winlose;

            //-> 배팅내역에 결과 입력
            $sql = "UPDATE tb_game_betting SET result=".$result." WHERE sn=".$betSn;
            $this->db->exeSql($sql);

            if ( $winlose == 2 ) {
                $sql = "UPDATE tb_game_cart SET result = 2, operdate = now() WHERE betting_no ='".$bettingNo."'";
                $this->db->exeSql($sql);
            } else if ( $winlose == 1 ) {
                $winMoney = floor($select_rate * $betMoney);

                $sql = "UPDATE tb_game_cart SET result = 1, operdate = now(), result_money = '".$winMoney."' 
                                WHERE betting_no = '".$bettingNo."'";
                $this->db->exeSql($sql);

                $sql = "SELECT g_money FROM tb_people WHERE sn = '".$member_sn."'";
                $memberGmoneyInfo = $this->db->exeSql($sql)[0];	
                $before = $memberGmoneyInfo["g_money"];
            
                $sql = "UPDATE tb_people SET g_money = g_money + (".$winMoney.") where sn = '".$member_sn."'";
                $this->db->exeSql($sql);

                $sql = "SELECT g_money FROM tb_people WHERE sn = '".$member_sn."'";
                $memberGmoneyInfo = $this->db->exeSql($sql)[0];	
                $after = $memberGmoneyInfo["g_money"];

                if ( $state == 4 ) $statusMessage = "당첨배당금[배팅번호:".$bettingNo."]";
                else if ( $state == 5 ) $statusMessage = "취소";

                $sql = "INSERT INTO tb_money_log(member_sn, amount, before_money, after_money, regdate, state, status_message, betting_no)
                                values(".$member_sn.",".$winMoney.",".$before.",".$after.",now(),4,'".$statusMessage."','".$bettingNo."')";
                $this->db->exeSql($sql);
            }
        }
    }
	
	/**
	*--------------------------------------------------------------------
 	*
 	* game process
 	*
 	*--------------------------------------------------------------------
 	*/
 	//▶ 취소
 	function cancelGameProcess($childSn)
 	{
 		$rs = $this->gameModel->getSubChildRows($childSn, "*");
 		for($i=0; $i<count((array)$rs); ++$i)
 		{
 			$subSn 		= $rs[$i]['sn'];
 			$betType 	= $rs[$i]['betting_type'];
 			
 			//01. modify subchild
	 		$sql = "update ".$this->db_qz."subchild set win=4, result=1
		 					where sn=".$subSn;
		 					
		 	$this->db->exeSql($sql);
 		}
 	}
 	
	function resultPreviewProcessing($subChildSn, $game_result)
 	{
 		if($subChildSn == "")
 			return;
 		 		
		////////////////////////////////////////////////////////////////////////////////
		// modify total_betting                   
		$sql = "select 	sn, member_sn, betting_no, select_no, game_type, home_rate, draw_rate, away_rate
				from 	".$this->db_qz."game_betting 
				where 	sub_child_sn=".$subChildSn;
						
		$rs = $this->db->exeSql($sql);
	
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$betSn = $rs[$i]["sn"];
			$select = $rs[$i]["select_no"];

			if($game_result == 4)							{$result = 4;}
			else if($select == $game_result) 				{$result = 1;}
			else				  							{$result = 2;}

			$sql = "update	".$this->db_qz."game_betting 
					set 	result = " . $result . "
					where 	sn =".$betSn;
					
			$rs = $this->db->exeSql($sql);
			
			$data["bet_sn"]	= $betSn;
			$data["subchild_sn"] = $subChildSn;
			$data["win"] = $game_result;
			$data["result"]	= $result;
			$betData[] = $data;
		}
		
		return $this->accountListProcess($subChildSn, $betData);
	}

	//다기준
	function resultPreviewProcessingMulti($subchildSn, $homeScore, $awayScore, $gameCancel="", $betData)
 	{
 		if($subchildSn=="")
 			return;
 			
 		$sql = "select 			b.betting_type,
								b.draw_rate,
								b.sn as sub_child_sn
				from 			".$this->db_qz."child_m a,
								".$this->db_qz."subchild_m b
				where 			a.sn=b.child_sn
							and b.sn=".$subchildSn;
 									
 		$childRs = $this->db->exeSql($sql);
 		$gameType = $childRs[0]['betting_type'];
 		$drawRate = $childRs[0]['draw_rate'];
 		$subChildSn = $childRs[0]['sub_child_sn'];
 		
		////////////////////////////////////////////////////////////////////////////////
		//modify total_betting                   
		$sql = "select a.sn, a.member_sn, a.betting_no, a.select_no, a.game_type, a.home_rate, a.draw_rate, a.away_rate, c.sport_name
						from ".$this->db_qz."game_betting a, ".$this->db_qz."child_m b, ".$this->db_qz."subchild_m c 
						where a.sub_child_sn = c.sn and c.child_sn = b.sn and a.sub_child_sn=".$subChildSn;
						
		$rs = $this->db->exeSql($sql);
	
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$winTeam = '';
 			$winCode = '';
 		
			$betSn = $rs[$i]["sn"];
			$member_sn = $rs[$i]["member_sn"];
			$betting_no = $rs[$i]["betting_no"];
			$select = $rs[$i]["select_no"];
			$selectDrawRate	= $rs[$i]["draw_rate"];

			//-> 파일로그와 DB의 배팅방향이 틀리면 tb_game_betting->checked에 둘다 로그방향을 저장하고 로그 기반으로 현재 배팅방향 업데이트.
			$sql = "select bet_date, last_special_code from tb_game_cart where betting_no = '{$betting_no}'";
			$cartInfo = $this->db->exeSql($sql);
			$bet_date = str_replace("-","",substr($cartInfo[0]['bet_date'],0,10));
			$last_special_code = $cartInfo[0]['last_special_code'];

			$fileName = $bet_date."_".$member_sn.".log";
			$logFile = @fopen("/home/gadget/www_gadget_1.com/Lemonade/_logs/user/".$fileName,"r");
			if ( $logFile ) {
				unset($bettingLogArray);
				while ( !feof($logFile) ) {
					$bettingLog = fgets($logFile);
					if ( strlen(trim($bettingLog)) > 0 ) $bettingLogArray[] = str_replace("'","\"",$bettingLog);
				}
				if ( count((array)$bettingLogArray) > 0 ) {
					$bettingLogArrayJson = implode(",",$bettingLogArray);
					$bettingLogArray = json_decode("{".$bettingLogArrayJson."}",true);
				}
				@fclose($logFile);

				$logBettingSelect = $bettingLogArray[$betting_no."_".$subChildSn];
				if ( $logBettingSelect > 0 and $logBettingSelect != $select ) {
					$sql = "UPDATE tb_game_betting SET select_no = '{$logBettingSelect}', checked = '{$select}->{$logBettingSelect}' WHERE sn = '".$betSn."'";
					$this->db->exeSql($sql);
					$select = $logBettingSelect;
				}
			}
			//------------------------------------------------------------------------------------

			//핸디캡, 언더오버의 기준점 변경이 일어날 경우를 대비해, 배팅당시의 기준점으로 처리한다.			
			//강제취소의 경우 자기 자신의 배당을 하지 않고, 전체 적용한다.
			if($gameCancel=="1")
			{
				$winCode=4;
			}
			else
			{
				//관리자에 의해 적특처리를 했을 경우 적특으로 처리를 해줘야 한다.
				if(($rs[$i]["home_rate"]=="1.00" || $rs[$i]["home_rate"]=="1") && ($rs[$i]["draw_rate"]=="1.00" || $rs[$i]["draw_rate"]=="1") && ($rs[$i]["away_rate"]=="1.00" || $rs[$i]["away_rate"]=="1")) 
					$winCode = 4;
				else
				{
					switch ($rs[$i]["sport_name"]) {
						case "축구":
							switch($gameType) {
								case "1": // 승패
									if( $homeScore > $awayScore )						$winCode = 1;
									else if ( $homeScore < $awayScore )					$winCode = 2;
									break;
								case "2": // 핸디캡
									if(($homeScore+$selectDrawRate) > $awayScore)		$winCode = 1; // 홈승
									else if(($homeScore+$selectDrawRate) < $awayScore)	$winCode = 2; // 원정승
									else if(($homeScore+$selectDrawRate) == $awayScore)	$winCode = 4; // 적특
									break;
								case "3": // 언더오버
								case "7":
								case "8":
									if(($homeScore+$awayScore)==$selectDrawRate)        $winCode = 4;
									else
										$winCode = (($homeScore+$awayScore) > $selectDrawRate) ? 2 : 1;
									break;
								case "4": // 승무패
								case "5":
								case "6":
									if($homeScore==$awayScore)
									{
										if($drawRate=="1.00" and $last_special_code < 3) $winCode = 4;
										else 										     $winCode = 3; // 무승부
									} else if($homeScore > $awayScore)					{$winCode = 1;}
									else											    {$winCode = 2;}
									break;
								case "9": // 득점홀짝
								case "10":
									if(($homeScore+$awayScore) % 2 == 1) 				$winCode = 1;
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
								case "8":
								case "9":
								case "10":
								case "11":
									if(($homeScore+$selectDrawRate) > $awayScore)		$winCode = 1;
									else if(($homeScore+$selectDrawRate) < $awayScore)	$winCode = 2;
									else if(($homeScore+$selectDrawRate) == $awayScore)	$winCode = 4;
									break;
								case "3": // 언더오버
								case "12":
								case "13":
								case "14":
								case "15":
									if(($homeScore+$awayScore)==$selectDrawRate)        $winCode = 4;
									else
										$winCode = (($homeScore+$awayScore) > $selectDrawRate) ? 2 : 1;
									break;
								case "4": // 승무패
								case "5":
								case "6":
								case "7":
									if($homeScore==$awayScore)
									{
										if($drawRate=="1.00" and $last_special_code < 3) $winCode = 4;
										else 										     $winCode = 3;
									} else if($homeScore > $awayScore)					{$winCode = 1;}
									else											    {$winCode = 2;}
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
								case "5":
									if(($homeScore+$awayScore) % 2 == 1) 				$winCode = 1;
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
								case "5":
								case "6":
								case "7":
									if(($homeScore+$selectDrawRate) > $awayScore)		$winCode = 1;
									else if(($homeScore+$selectDrawRate) < $awayScore)	$winCode = 2;
									else if(($homeScore+$selectDrawRate) == $awayScore)	$winCode = 4;
									break;
								case "3": // 언더오버
								case "8":
								case "9":
								case "10":
									if(($homeScore+$awayScore)==$selectDrawRate)        $winCode = 4;
									else
										$winCode = (($homeScore+$awayScore) > $selectDrawRate) ? 2 : 1;
									break;
								case "4": // 승무패
									if($homeScore==$awayScore)
									{
										if($drawRate=="1.00" and $last_special_code < 3) $winCode = 4;
										else 										     $winCode = 3;
									} else if($homeScore > $awayScore)					{$winCode = 1;}
									else											    {$winCode = 2;}
									break;
							}
							break;
						case "하키":
							switch($gameType) {
								case "1": // 승패
								case "5":
									if( $homeScore > $awayScore )						$winCode = 1;
									else if ( $homeScore < $awayScore )					$winCode = 2;
									break;
								case "2": // 핸디캡
								case "7":
									if(($homeScore+$selectDrawRate) > $awayScore)		$winCode = 1;
									else if(($homeScore+$selectDrawRate) < $awayScore)	$winCode = 2;
									else if(($homeScore+$selectDrawRate) == $awayScore)	$winCode = 4;
									break;
								case "3": // 언더오버
								case "8":
									if(($homeScore+$awayScore)==$selectDrawRate)        $winCode = 4;
									else
										$winCode = (($homeScore+$awayScore) > $selectDrawRate) ? 2 : 1;
									break;
								case "4": // 승무패
								case "6":
									if($homeScore==$awayScore)
									{
										if($drawRate=="1.00" and $last_special_code < 3) $winCode = 4;
										else 										     $winCode = 3;
									} else if($homeScore > $awayScore)					{$winCode = 1;}
									else											    {$winCode = 2;}
									break;
							}
							break;	
					}
				}
			}
			if($winCode==4)							{$result=4;}
			else if($select==$winCode) 				{$result=1;}
			else				  					{$result=2;}
			
			$data["bet_sn"]			= $betSn;
			$data["subchild_sn"]		= $subchildSn;
			$data["home_score"] = $homeScore;
			$data["away_score"] = $awayScore;
			$data["win"]				= $winCode;
			$data["result"]			= $result;
			$betData[] = $data;
		 }

		 return $this->accountListProcessMulti($subchildSn, $betData);
	}

    //▶ [수정] - 결과에 따른 정보 갱신
    function resultGameProcessing($subChildSn, $game_result)
    {
        ////////////////////////////////////////////////////////////////////////////////
        //modify total_betting
        $sql = "select sn, member_sn, betting_no, betid, select_no, game_type, home_rate, draw_rate, away_rate
				from ".$this->db_qz."game_betting 
				where sub_child_sn = ".$subChildSn;
        $rs = $this->db->exeSql($sql);

        for($i=0; $i<count((array)$rs); ++$i)
        {
            $betSn = $rs[$i]["sn"];
            $select = $rs[$i]["select_no"];
			
			$sql = "update ".$this->db_qz."subchild set win = ".$game_result." where sn = ".$subChildSn;
			$this->db->exeSql($sql);

            if($game_result == 4)							{$result=4;}
            else if($select == $game_result) 				{$result=1;}
			else				  							{$result=2;}

            $sql = "update ".$this->db_qz."game_betting set result=".$result." where sn=".$betSn;
            $this->db->exeSql($sql);

			$this->requestRemoveBettingInfo($betSn);
        }

        $this->accountMoneyProcess($subChildSn);
    }

	public function requestRemoveBettingInfo($sn) {
		$values = ["sn" => $sn];
		$strValue = json_encode($values);
		$strUrl = "http://127.0.0.1:3001/api/betting?nCmd=1&strValue=" . $strValue;
		file_get_contents($strUrl);
	}

	//▶ [수정] - 결과에 따른 정보 갱신 (다기준)
    function resultGameProcessingMulti($subchildSn, $homeScore, $awayScore, $gameCancel="")
    {
        $sql = "select b.betting_type, a.special, b.draw_rate, b.sn as sub_child_sn from ".$this->db_qz."child_m a, ".$this->db_qz."subchild_m b where a.sn=b.child_sn and b.sn=".$subchildSn;
        $childRs = $this->db->exeSql($sql);
        $gameType = $childRs[0]['betting_type'];
        $specialCode = $childRs[0]['special'];
        $drawRate = $childRs[0]['draw_rate'];
        $subChildSn = $childRs[0]['sub_child_sn'];

        $winTeam = '';
        $winCode = '';

        // modify result flag
        ////////////////////////////////////////////////////////////////////////////////
        if($gameCancel=="1")
        {
            $homeScore = 0;
            $awayScore = 0;
            $winTeam = "Cancel";
        }
        else
        {
            if($gameType==1)
            {
                if($homeScore==$awayScore)
                {
                    if($drawRate=="1.00" and $specialCode < 3) $winTeam = 'Cancel';
                    else $winTeam = 'Draw';
                }
                else if($homeScore > $awayScore){$winTeam = 'Home';}
                else														{$winTeam = 'Away';}
            }
            else if($gameType==2)
            {
                if($homeScore+$drawRate > $awayScore) 			{$winTeam = 'Home';}
                else if($homeScore+$drawRate < $awayScore) 	{$winTeam = 'Away';}
                else																				{$winTeam = 'Cancel';}
            }
            else if($gameType==4)
            {
                if($homeScore+$awayScore < $drawRate) 			{$winTeam = 'Home';}
                else if($homeScore+$awayScore > $drawRate) 	{$winTeam = 'Away';}
                else																				{$winTeam = 'Cancel';}
            }
        }
        $set="";
        $where="";

        $set .=	"a.home_score=".$homeScore."," ;
        $set .=	"a.away_score=".$awayScore;

        if($gameType==1)
            $set.=" , a.win_team='".$winTeam."'";

        else if($gameType==2)
            $set.=" , a.handi_winner='".$winTeam."'";

        $where=" b.sn=".$subchildSn;

        $this->gameModel->modifyChildMulti($set, $where);

        if($winTeam=='Home') 		$winCode = 1;
        else if($winTeam=='Away') 	$winCode = 2;
        else if($winTeam=='Draw') 	$winCode = 3;
        else if($winTeam=='Cancel') $winCode = 4;

        $sql = "update ".$this->db_qz."subchild_m set win=".$winCode." where sn=".$subchildSn;
        $this->db->exeSql($sql);

        ////////////////////////////////////////////////////////////////////////////////
        //modify total_betting
        $sql = "select sn, member_sn, betting_no, select_no, game_type, home_rate, draw_rate, away_rate
						from ".$this->db_qz."game_betting 
						where sub_child_sn=".$subChildSn;
        $rs = $this->db->exeSql($sql);

        for($i=0; $i<count((array)$rs); ++$i)
        {
            $winTeam = '';
            $winCode = '';

            $betSn = $rs[$i]["sn"];
            $member_sn = $rs[$i]["member_sn"];
            $betting_no = $rs[$i]["betting_no"];
            $select = $rs[$i]["select_no"];
            $selectDrawRate	= $rs[$i]["draw_rate"];


            //-> 파일로그와 DB의 배팅방향이 틀리면 tb_game_betting->checked에 둘다 로그방향을 저장하고 로그 기반으로 현재 배팅방향 업데이트.
            $sql = "select bet_date, last_special_code from tb_game_cart where betting_no = '{$betting_no}'";
            $cartInfo = $this->db->exeSql($sql);
            $bet_date = str_replace("-","",substr($cartInfo[0]['bet_date'],0,10));
            $last_special_code = $cartInfo[0]['last_special_code'];

            $fileName = $bet_date."_".$member_sn.".log";
            $logFile = @fopen("/home/gadget/www_gadget_1.com/Lemonade/_logs/user/".$fileName,"r");
            if ( $logFile ) {
                unset($bettingLogArray);
                while ( !feof($logFile) ) {
                    $bettingLog = fgets($logFile);
                    if ( strlen(trim($bettingLog)) > 0 ) $bettingLogArray[] = str_replace("'","\"",$bettingLog);
                }
                if ( count((array)$bettingLogArray) > 0 ) {
                    $bettingLogArrayJson = implode(",",$bettingLogArray);
                    $bettingLogArray = json_decode("{".$bettingLogArrayJson."}",true);
                }
                @fclose($logFile);

                $logBettingSelect = $bettingLogArray[$betting_no."_".$subChildSn];
                if ( $logBettingSelect > 0 and $logBettingSelect != $select ) {
                    $sql = "UPDATE tb_game_betting SET select_no = '{$logBettingSelect}', checked = '{$select}->{$logBettingSelect}' WHERE sn = '".$betSn."'";
                    $this->db->exeSql($sql);
                    $select = $logBettingSelect;
                }
            }
            //------------------------------------------------------------------------------------


            //핸디캡, 언더오버의 기준점 변경이 일어날 경우를 대비해, 배팅당시의 기준점으로 처리한다.
            //강제취소의 경우 자기 자신의 배당을 하지 않고, 전체 적용한다.
            if($gameCancel=="1")
            {
                $winCode=4;
            }
            else
            {
                //관리자에 의해 적특처리를 했을 경우 적특으로 처리를 해줘야 한다.
                if($rs[$i]["home_rate"]=="1.00" && $rs[$i]["draw_rate"]=="1.00" && $rs[$i]["away_rate"]=="1.00")
                    $winCode = 4;
                else
                {
                    if($gameType==1) //승무패
                    {
                        if($homeScore==$awayScore)
                        {
                            if($drawRate=="1.00" and $last_special_code < 3) $winCode = 4;
                            else $winCode = 3;
                        }
                        else if($homeScore > $awayScore){$winCode = 1;}
                        else														{$winCode = 2;}
                    }
                    else if($gameType==2)
                    {
                        if(($homeScore+$selectDrawRate) > $awayScore)				$winCode = 1;
                        else if(($homeScore+$selectDrawRate) < $awayScore)	$winCode = 2;
                        else if(($homeScore+$selectDrawRate) == $awayScore)	$winCode = 4;
                    }
                    else if($gameType==3)
                    {
                        if(($homeScore+$awayScore)==$selectDrawRate) $winCode = 4;
                        else
                            $winCode = (($homeScore+$awayScore) > $selectDrawRate) ? 2:1;
                    }
                }
            }

            if($winCode==4)							{$result=4;}
            else if($select==$winCode) 	{$result=1;}
            else				  							{$result=2;}

            $sql = "update ".$this->db_qz."game_betting set result=".$result." where sn=".$betSn;
            $this->db->exeSql($sql);
        }

        $this->accountMoneyProcessMulti($subchildSn);
    }

    //▶ [배당지급] - 결과에 따른 돈 지급 (팝업정산)
    function accountMoneyProcess($subChildSn)
    {
        $rs = $this->gameModel->getSubChildRowBySn($subChildSn);
		$child_sn = $rs["child_sn"];

        $sql = "update ".$this->db_qz."subchild set result = 1 where sn = ".$subChildSn;
        $this->db->exeSql($sql);

		$sql = "select * from tb_subchild where result = 0 and child_sn = " . $child_sn;
		$childInfo = $this->db->exeSql($sql);
		if(count((array)$childInfo) == 0) {
			$sql = "update ".$this->db_qz."child set kubun = 1 where sn = ".$child_sn;
			$this->db->exeSql($sql);
		}

        $sql = "select 	b.betting_no, b.member_sn, d.last_special_code
				from 	tb_subchild a, tb_game_betting b, tb_child c, tb_game_cart d
				where 	a.sn=b.sub_child_sn and a.child_sn=c.sn and b.betting_no = d.betting_no and d.result=0 and a.sn=".$subChildSn;
        $rs = $this->db->exeSql($sql);

        for($i=0; $i<count((array)$rs); ++$i)
        {
            $bettingNo = $rs[$i]['betting_no'];
            $memberSn = $rs[$i]['member_sn'];
            $specialCode = $rs[$i]['last_special_code'];

            $sql = "select a.*, c.sport_name from tb_game_betting a, tb_subchild b, tb_child c where a.sub_child_sn = b.sn and b.child_sn = c.sn and a.betting_no='".$bettingNo."'";
            $rsi = $this->db->exeSql($sql);

            $winCount = $loseCount = $cancelCount = $ingGameCount = $bonusGameCount = 0;
            $winRate = 1;
            $winMoney = 0;
            $total = count((array)$rsi);	//-> 경기총폴더수

            for ( $j = 0 ; $j < count((array)$rsi) ; $j++ ) {
                $betMoney = $rsi[$j]['bet_money'];
                $sportName = $rsi[$j]['sport_name'];

                if ( $rsi[$j]['result'] == 0 ) {
                    ++$ingGameCount;
                } else if ( $rsi[$j]['result'] == 1 ) {
                    ++$winCount;
                    $winRate *= $rsi[$j]['select_rate'];
                    if ( strlen($sportName) != strlen(str_replace("보너스","",$sportName)) ) {
                        ++$bonusGameCount;
                    }
                } else if ( $rsi[$j]['result'] == 2 ) {
                    ++$loseCount;
                } else if ( $rsi[$j]['result'] == 4 ) {
                    ++$cancelCount;
                    $winRate *= 1;
                }
            }

            //모든게임종료
            if ( $ingGameCount == 0 ) {
                $sql = "select * from ".$this->db_qz."people where sn=".$memberSn;
                $rsi = $this->db->exeSql($sql);
                $logo = $rsi[0]['logo'];
                $mem_lev = $rsi[0]['mem_lev'];

                //모두 취소된 게임
                if ( $total == $cancelCount ) {
                    $winRate  = bcmul($winRate,1,2);
                    $winMoney = bcmul($betMoney,$winRate,0);

                    $sql = "update ".$this->db_qz."game_cart set result=4, operdate=now(), result_money='".$winMoney."' where logo='".$logo."' and betting_no = '".$bettingNo."'";
                    $rsi = $this->db->exeSql($sql);
                    if($rsi<=0) {
                        $sql = "insert into debug_detail_log(betting_no, total, win, lose, ing, cancel) values('".$bettingNo."',".$total.",".$winCount.",".$loseCount.",".$ingGameCount.",".$cancelCount.")";
                        $this->db->exeSql($sql);
                    }
                    $this->modifyMoneyProcess($memberSn, $winMoney, 5, $bettingNo);

				//낙첨
                } else if( $loseCount > 0 ) {
                    $sql = "update ".$this->db_qz."game_cart set result=2, operdate=now() where betting_no ='".$bettingNo."'";
                    $rsi = $this->db->exeSql($sql);
                    if($rsi<=0) {
                        $sql = "insert into debug_detail_log(betting_no, total, win, lose, ing, cancel) values('".$bettingNo."',".$total.",".$winCount.",".$loseCount.",".$ingGameCount.",".$cancelCount.")";
                        $this->db->exeSql($sql);
                    }

                    //미니게임은 지급하지 않는다.
                    if($specialCode < 5) {
                        //-> 낙첨 마일리지는 미니게임은 제외하고 스포츠 1폴더 이상부터 지급
                        if ( ($winCount + $loseCount - $bonusGameCount) > 1 ) {
                            //낙첨 마일리지
                            $this->modifyMileageProcess($memberSn, $betMoney, "4", $bettingNo);
                        }
                    }
				//당첨
                } else if( ($winCount+$cancelCount) >= $total ) {
                    $winRate  = bcmul($winRate,1,2);
                    $winMoney = bcmul($betMoney,$winRate,0);

                    $sql = "update ".$this->db_qz."game_cart set result=1, operdate=now(), result_money='".$winMoney."' where logo='".$logo."' and betting_no = '".$bettingNo."'";
                    $rsi = $this->db->exeSql($sql);
                    if($rsi<=0)
                    {
                        $sql = "insert into debug_detail_log(betting_no, total, win, lose, ing, cancel) 
								values ('".$bettingNo."',".$total.",".$winCount.",".$loseCount.",".$ingGameCount.",".$cancelCount.")";
                        $this->db->exeSql($sql);
                    }

                    $this->modifyMoneyProcess($memberSn, $winMoney, 4, $bettingNo);
                    /*
                                        //다폴더 보너스 계산
                                        if ( ($winCount - $bonusGameCount) > 2 ) {
                                            //-> 통합 다폴더 포인트 rate 가져오기.
                                            $folderCnt = $winCount - $bonusGameCount;
                                            $folderRate = $this->configModel->getPointConfigRow("folder_bouns".$folderCnt);
                                            $this->modifyMileageProcess($sn, $betMoney, "3", $bettingNo, $folderRate["folder_bouns".$folderCnt], $folderCnt);
                                        }
                    */
                }
                else
                {
                    $sql = "insert into debug_detail_log(betting_no, total, win, lose, ing, cancel, flag) 
							values('".$bettingNo."',".$total.",".$winCount.",".$loseCount.",".$ingGameCount.",".$cancelCount.",1)";
                    $this->db->exeSql($sql);
                }

                //-> 추천인 마일리지는 미니게임 제외, 스포츠 1폴더(이기거나 진거 합 2이상) 이상부터 지급
                if ( $specialCode < 5 ) {
                    if ( ($winCount + $loseCount - $bonusGameCount) > 1 ) {
                        //-> 추천인 마일리지
                        $this->recommendFailedGameMileage($memberSn, $betMoney, $bettingNo, $loseCount);
                    }
                }

            }
        }// end of for

        return 1;
    }

	//▶ [배당지급] - 결과에 따른 돈 지급 (팝업정산) (다기준)
    function accountMoneyProcessMulti($subchildSn)
    {
        $rs = $this->gameModel->getChildRowMulti($subchildSn, '*');

        $homeScore = $rs['home_score'];
        $awayScore = $rs['away_score'];
        $league_sn = $rs['league_sn']; //사다리게임만 체크를 위함

        if(is_null($homeScore)||is_null($awayScore))
            return -1;

        //이미 처리된게임인지 확인
        if($rs['kubun']==1)
            return 1;

        $sql = "update ".$this->db_qz."subchild_m set result=1, kubun=1 where sn=".$subchildSn;
        $this->db->exeSql($sql);

        $sql = "select b.betting_no, b.member_sn, d.last_special_code
						from 	tb_subchild_m a, tb_game_betting b, tb_child_m c, tb_game_cart d
						where a.sn=b.sub_child_sn and a.child_sn=c.sn and b.betting_no=d.betting_no and d.result=0 and b.sn=".$subchildSn;
        $rs = $this->db->exeSql($sql);

        for($i=0; $i<count((array)$rs); ++$i)
        {
            $bettingNo = $rs[$i]['betting_no'];
            $sn = $rs[$i]['member_sn'];
            $specialCode = $rs[$i]['last_special_code'];

            $sql = "select a.*, c.sport_name from tb_game_betting a, tb_subchild_m b, tb_child_m c where a.sub_child_sn = b.sn and b.child_sn = c.sn and a.betting_no='".$bettingNo."'";
            $rsi = $this->db->exeSql($sql);

            $winCount = $loseCount = $cancelCount = $ingGameCount = $bonusGameCount = 0;
            $winRate = 1;
            $winMoney = 0;
            $total = count((array)$rsi);	//-> 경기총폴더수

            for ( $j = 0 ; $j < count((array)$rsi) ; $j++ ) {
                $betMoney = $rsi[$j]['bet_money'];
                $sportName = $rsi[$j]['sport_name'];

                if ( $rsi[$j]['result'] == 0 ) {
                    ++$ingGameCount;
                } else if ( $rsi[$j]['result'] == 1 ) {
                    ++$winCount;
                    $winRate *= $rsi[$j]['select_rate'];
                    if ( strlen($sportName) != strlen(str_replace("보너스","",$sportName)) ) {
                        ++$bonusGameCount;
                    }
                } else if ( $rsi[$j]['result'] == 2 ) {
                    ++$loseCount;
                } else if ( $rsi[$j]['result'] == 4 ) {
                    ++$cancelCount;
                    $winRate *= 1;
                }
            }

            //모든게임종료
            if ( $ingGameCount == 0 ) {
                $memberSn = $rs[$i]['member_sn'];
                $sql = "select * from ".$this->db_qz."people where sn=".$memberSn;
                $rsi = $this->db->exeSql($sql);
                $logo = $rsi[0]['logo'];
                $mem_lev = $rsi[0]['mem_lev'];

                //모두 취소된 게임
                if ( $total == $cancelCount ) {
                    $winRate  = bcmul($winRate,1,2);
                    $winMoney = bcmul($betMoney,$winRate,0);

                    $sql = "update ".$this->db_qz."game_cart set result=4, operdate=now(), result_money='".$winMoney."' where logo='".$logo."' and betting_no = '".$bettingNo."'";
                    $rsi = $this->db->exeSql($sql);
                    if($rsi<=0) {
                        $sql = "insert into debug_detail_log(betting_no, total, win, lose, ing, cancel) values('".$bettingNo."',".$total.",".$winCount.",".$loseCount.",".$ingGameCount.",".$cancelCount.")";
                        $this->db->exeSql($sql);
                    }
                    $this->modifyMoneyProcess($memberSn, $winMoney, 5, $bettingNo);

                    //낙첨
                } else if( $loseCount > 0 ) {
                    $sql = "update ".$this->db_qz."game_cart set result=2, operdate=now() where betting_no ='".$bettingNo."'";
                    $rsi = $this->db->exeSql($sql);
                    if($rsi<=0) {
                        $sql = "insert into debug_detail_log(betting_no, total, win, lose, ing, cancel) values('".$bettingNo."',".$total.",".$winCount.",".$loseCount.",".$ingGameCount.",".$cancelCount.")";
                        $this->db->exeSql($sql);
                    }

                    //미니게임은 지급하지 않는다.
                    if($specialCode < 3) {
                        //-> 낙첨 마일리지는 미니게임은 제외하고 스포츠 1폴더 이상부터 지급
                        if ( ($winCount + $loseCount - $bonusGameCount) > 1 ) {
                            //낙첨 마일리지
                            $this->modifyMileageProcess($sn, $betMoney, "4", $bettingNo);
                        }
                    }
                    //당첨
                } else if( ($winCount+$cancelCount) >= $total ) {
                    $winRate  = bcmul($winRate,1,2);
                    $winMoney = bcmul($betMoney,$winRate,0);

                    $sql = "update ".$this->db_qz."game_cart set result=1, operdate=now(), result_money='".$winMoney."' where logo='".$logo."' and betting_no = '".$bettingNo."'";
                    $rsi = $this->db->exeSql($sql);
                    if($rsi<=0)
                    {
                        $sql = "insert into debug_detail_log(betting_no, total, win, lose, ing, cancel) 
										values('".$bettingNo."',".$total.",".$winCount.",".$loseCount.",".$ingGameCount.",".$cancelCount.")";
                        $this->db->exeSql($sql);
                    }

                    $this->modifyMoneyProcess($memberSn, $winMoney, 4, $bettingNo);
                    /*
                                        //다폴더 보너스 계산
                                        if ( ($winCount - $bonusGameCount) > 2 ) {
                                            //-> 통합 다폴더 포인트 rate 가져오기.
                                            $folderCnt = $winCount - $bonusGameCount;
                                            $folderRate = $this->configModel->getPointConfigRow("folder_bouns".$folderCnt);
                                            $this->modifyMileageProcess($sn, $betMoney, "3", $bettingNo, $folderRate["folder_bouns".$folderCnt], $folderCnt);
                                        }
                    */
                }
                else
                {
                    $sql = "insert into debug_detail_log(betting_no, total, win, lose, ing, cancel, flag) 
									values('".$bettingNo."',".$total.",".$winCount.",".$loseCount.",".$ingGameCount.",".$cancelCount.",1)";
                    $this->db->exeSql($sql);
                }

                //-> 추천인 마일리지는 미니게임 제외, 스포츠 1폴더(이기거나 진거 합 2이상) 이상부터 지급
                if ( $specialCode < 3 ) {
                    if ( ($winCount + $loseCount - $bonusGameCount) > 1 ) {
                        //-> 추천인 마일리지
                        $this->recommendFailedGameMileage($sn, $betMoney, $bettingNo, $loseCount);
                    }
                }

            }
        }// end of for

        return 1;
    }

 	//▶ [수정] - 이미 정산된 결과를 취소한다.
 	function cancel_resultGameProcessinging($childSn, $homeScore, $awayScore)
 	{
 	    // Money 정산전 상태로 복귀
        $this->cancel_accountMoneyProcessing($childSn);


 	    $sql = "select a.type, a.special, b.draw_rate, b.sn as sub_child_sn from ".$this->db_qz."child a, ".$this->db_qz."subchild b where a.sn=b.child_sn and a.sn=".$childSn;
 		$childRs = $this->db->exeSql($sql);
 		$gameType = $childRs[0]['type'];
 		$specialCode = $childRs[0]['special'];
 		$drawRate = $childRs[0]['draw_rate'];
 		$subChildSn = $childRs[0]['sub_child_sn'];
 		
 		$winTeam = '';
 		$winCode = '';


 		// modify result flag
 		////////////////////////////////////////////////////////////////////////////////
 		/*if($gameCancel=="1")
 		{
 			$homeScore = 0;
			$awayScore = 0;
			$winTeam = "Cancel";
 		}
 		else
 		{
	 		if($gameType==1)
			{
				if($homeScore==$awayScore)
				{
					if($drawRate=="1.00" and $specialCode < 3) $winTeam = 'Cancel';
					else $winTeam = 'Draw';
				}
				else if($homeScore > $awayScore){$winTeam = 'Home';}
				else														{$winTeam = 'Away';}
			}
			else if($gameType==2)
			{
				if($homeScore+$drawRate > $awayScore) 			{$winTeam = 'Home';}
				else if($homeScore+$drawRate < $awayScore) 	{$winTeam = 'Away';}
				else																				{$winTeam = 'Cancel';}
			}
			else if($gameType==4)
			{
				if($homeScore+$awayScore > $drawRate) 			{$winTeam = 'Home';}
				else if($homeScore+$awayScore < $drawRate) 	{$winTeam = 'Away';}
				else																				{$winTeam = 'Cancel';}
			}
		}
 		*/
		$set="";
		$where="";

        $set .=	"home_score=".$homeScore."," ;
        $set .=	"away_score=".$awayScore;

        $set.=",win_team=null";
        $set.=",handi_winner=null";
					
		$where=" sn=".$childSn;

		$this->gameModel->modifyChild($set, $where);

		/*if($winTeam=='Home') 				$winCode = 1;
		else if($winTeam=='Away') 	$winCode = 2;
		else if($winTeam=='Draw') 	$winCode = 3;
		else if($winTeam=='Cancel') $winCode = 4;*/

		$sql = "update ".$this->db_qz."subchild set win=null,result=null where child_sn=".$childSn;
		$this->db->exeSql($sql);
		
		////////////////////////////////////////////////////////////////////////////////
		//modify total_betting
		$sql = "select sn, member_sn, betting_no, select_no, game_type, home_rate, draw_rate, away_rate
						from ".$this->db_qz."game_betting 
						where sub_child_sn=".$subChildSn;
		$rs = $this->db->exeSql($sql);
	
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$winTeam = '';
 			$winCode = '';
 		
			$betSn = $rs[$i]["sn"];
			/*$member_sn = $rs[$i]["member_sn"];
			$betting_no = $rs[$i]["betting_no"];
			$select = $rs[$i]["select_no"];
			$selectDrawRate	= $rs[$i]["draw_rate"];


			//-> 파일로그와 DB의 배팅방향이 틀리면 tb_game_betting->checked에 둘다 로그방향을 저장하고 로그 기반으로 현재 배팅방향 업데이트.
			$sql = "select bet_date, last_special_code from tb_game_cart where betting_no = '{$betting_no}'";
			$cartInfo = $this->db->exeSql($sql);
			$bet_date = str_replace("-","",substr($cartInfo[0]['bet_date'],0,10));
			$last_special_code = $cartInfo[0]['last_special_code'];

			$fileName = $bet_date."_".$member_sn.".log";
			$logFile = @fopen("/home/gadget/www_gadget_1.com/Lemonade/_logs/user/".$fileName,"r");
			if ( $logFile ) {
				unset($bettingLogArray);
				while ( !feof($logFile) ) {
					$bettingLog = fgets($logFile);
					if ( strlen(trim($bettingLog)) > 0 ) $bettingLogArray[] = str_replace("'","\"",$bettingLog);
				}
				if ( count((array)$bettingLogArray) > 0 ) {
					$bettingLogArrayJson = implode(",",$bettingLogArray);
					$bettingLogArray = json_decode("{".$bettingLogArrayJson."}",true);
				}
				@fclose($logFile);

				$logBettingSelect = $bettingLogArray[$betting_no."_".$subChildSn];
				if ( $logBettingSelect > 0 and $logBettingSelect != $select ) {
					$sql = "UPDATE tb_game_betting SET select_no = '{$logBettingSelect}', checked = '{$select}->{$logBettingSelect}' WHERE sn = '".$betSn."'";
					$this->db->exeSql($sql);
					$select = $logBettingSelect;
				}
			}
			//------------------------------------------------------------------------------------


			//핸디캡, 언더오버의 기준점 변경이 일어날 경우를 대비해, 배팅당시의 기준점으로 처리한다.			
			//강제취소의 경우 자기 자신의 배당을 하지 않고, 전체 적용한다.
			if($gameCancel=="1")
			{
				$winCode=4;
			}
			else
			{
				//관리자에 의해 적특처리를 했을 경우 적특으로 처리를 해줘야 한다.
				if($rs[$i]["home_rate"]=="1.00" && $rs[$i]["draw_rate"]=="1.00" && $rs[$i]["away_rate"]=="1.00") 
					$winCode = 4;
				else
				{
					if($gameType==1) //승무패
					{
						if($homeScore==$awayScore)
						{
							if($drawRate=="1.00" and $last_special_code < 3) $winCode = 4;
							else $winCode = 3;
						}
						else if($homeScore > $awayScore){$winCode = 1;}
						else														{$winCode = 2;}
					}
					else if($gameType==2)
				 	{
				 		if(($homeScore+$selectDrawRate) > $awayScore)				$winCode = 1;
				 		else if(($homeScore+$selectDrawRate) < $awayScore)	$winCode = 2;
				 		else if(($homeScore+$selectDrawRate) == $awayScore)	$winCode = 4;
					}
					else if($gameType==4)
				 	{
				 		if(($homeScore+$awayScore)==$selectDrawRate) $winCode = 4;
				 		else
				 			$winCode = (($homeScore+$awayScore) > $selectDrawRate) ? 2:1;
					}
				}
			}
			
			if($winCode==4)							{$result=4;}
			else if($select==$winCode) 	{$result=1;}
			else				  							{$result=2;}*/
				
			$sql = "update ".$this->db_qz."game_betting set result=0 where sn=".$betSn;
			$this->db->exeSql($sql);
		 }
	}

	//▶ 해당 배팅번호에 이미 정산된 결과를 취소한다.
	function cancel_bet_result_process($bettingNo = "", $total_betting_sn = 0, $memberSn = 0, $specialCode = 0) {
		// Money 정산전 상태로 복귀
		$this->cancel_winMoneyProcess($bettingNo, $memberSn, $specialCode);

		//modify total_betting
		$sql = "update ".$this->db_qz."game_betting set result=0 where sn=".$total_betting_sn;
		$this->db->exeSql($sql);
	}

	function cancel_winMoneyProcess($bettingNo = "", $memberSn = 0, $specialCode = 0) {
		$sql = "select a.*, c.sport_name from tb_game_betting a, tb_subchild b, tb_child c where a.sub_child_sn = b.sn and b.child_sn = c.sn and a.betting_no='".$bettingNo."'";
		$rsi = $this->db->exeSql($sql);
		
		$winCount = $loseCount = $cancelCount = $ingGameCount = $bonusGameCount = 0;
		$winRate = 1;
		$winMoney = 0;
		$total = count((array)$rsi);	//-> 경기총폴더수

		for ( $j = 0 ; $j < count((array)$rsi) ; $j++ ) {
			$betMoney = $rsi[$j]['bet_money'];
			$sportName = $rsi[$j]['sport_name'];

			if ( $rsi[$j]['result'] == 0 ) {
				++$ingGameCount;
			} else if ( $rsi[$j]['result'] == 1 ) {
				++$winCount;
				$winRate *= $rsi[$j]['select_rate'];
				if ( strlen($sportName) != strlen(str_replace("보너스","",$sportName)) ) {
					++$bonusGameCount;
				}
			} else if ( $rsi[$j]['result'] == 2 ) {
				++$loseCount;
			} else if ( $rsi[$j]['result'] == 4 ) {
				++$cancelCount;
				$winRate *= 1;
			}
		}

		$winRate = round($winRate, 2);
		
		//모든게임종료
		if ( $ingGameCount == 0 )
		{
			$sql = "select logo from ".$this->db_qz."people where sn=".$memberSn;
			$rsi = $this->db->exeSql($sql);
			$logo = $rsi[0]['logo'];

			//모두 취소된 게임
			if ( $total == $cancelCount ) {
				$winRate  = bcmul($winRate, 1, 2);
				$winMoney = bcmul($betMoney, $winRate, 0);
				
				//$sql = "update ".$this->db_qz."game_cart set result=4, operdate=now(), result_money='".$winMoney."' where logo='".$logo."' and betting_no = '".$bettingNo."'";
				$sql = "update ".$this->db_qz."game_cart set result=0, operdate=now(), result_money=0 where logo='".$logo."' and betting_no = '".$bettingNo."'";
				$rsi = $this->db->exeSql($sql);
				/*if($rsi<=0) {
					$sql = "insert into debug_detail_log(betting_no, total, win, lose, ing, cancel) values('".$bettingNo."',".$total.",".$winCount.",".$loseCount.",".$ingGameCount.",".$cancelCount.")";
					$this->db->exeSql($sql);
				}
				$this->modifyMoneyProcess($memberSn, $winMoney, 5, $bettingNo);*/

				// 재정산전 취소
				$winMoney = -1 * $winMoney;

				$this->modifyMoneyProcess($memberSn, $winMoney, 9, $bettingNo);

			//낙첨
			} else if( $loseCount > 0 ) {
				$sql = "update ".$this->db_qz."game_cart set result=0, operdate=now() where betting_no ='".$bettingNo."'";
				$rsi = $this->db->exeSql($sql);
				
			}
			//else if( ($winCount+$cancelCount) >= $total )
			else if( $winCount > 0 )
			{
				$winRate  = bcmul($winRate, 1, 2);
				$winMoney = bcmul($betMoney, $winRate, 0);

				//$sql = "update ".$this->db_qz."game_cart set result=1, operdate=now(), result_money='".$winMoney."' where logo='".$logo."' and betting_no = '".$bettingNo."'";
				$sql = "update ".$this->db_qz."game_cart set result = 0, operdate = now(), result_money = 0 where logo='".$logo."' and betting_no = '".$bettingNo."'";
				$rsi = $this->db->exeSql($sql);
				if($rsi<=0)
				{
					$sql = "insert into debug_detail_log(betting_no, total, win, lose, ing, cancel) 
							values('".$bettingNo."',".$total.",".$winCount.",".$loseCount.",".$ingGameCount.",".$cancelCount.")";
					$this->db->exeSql($sql);
				}

				$winMoney = -1 * $winMoney;
				// 재정산전 취소
				$this->modifyMoneyProcess($memberSn, $winMoney, 9, $bettingNo);
				/*
					//다폴더 보너스 계산
					if ( ($winCount - $bonusGameCount) > 2 ) {
						//-> 통합 다폴더 포인트 rate 가져오기.
						$folderCnt = $winCount - $bonusGameCount;
						$folderRate = $this->configModel->getPointConfigRow("folder_bouns".$folderCnt);
						$this->modifyMileageProcess($sn, $betMoney, "3", $bettingNo, $folderRate["folder_bouns".$folderCnt], $folderCnt);
					}
				*/
			}
			else
			{
				/*$sql = "insert into debug_detail_log(betting_no, total, win, lose, ing, cancel, flag)
							values('".$bettingNo."',".$total.",".$winCount.",".$loseCount.",".$ingGameCount.",".$cancelCount.",1)";
				$this->db->exeSql($sql);*/
			}

			//-> 추천인 마일리지는 미니게임 제외, 스포츠 1폴더(이기거나 진거 합 2이상) 이상부터 지급
			if ( $specialCode < 5 ) {
				if ( ($winCount + $loseCount - $bonusGameCount) > 1 ) {
					//-> 추천인 마일리지
					$this->cancel_recommendFailedGameMileage($memberSn, $betMoney, $bettingNo, $loseCount);
				}
			}
		}
	}

	//▶ [수정] - 이미 정산된 결과를 취소한다. (다기준)
	function cancel_resultGameProcessingingMulti($subchildSn)
	{
		// Money 정산전 상태로 복귀
	    $this->cancel_accountMoneyProcessingMulti($subchildSn);

		$sql = "update ".$this->db_qz."subchild set win=null, result=null where sn=".$subchildSn;
		$this->db->exeSql($sql);
		
		////////////////////////////////////////////////////////////////////////////////
		//modify total_betting
		$sql = "select sn, member_sn, betting_no, select_no, game_type, home_rate, draw_rate, away_rate
						from ".$this->db_qz."game_betting 
						where sub_child_sn=".$subchildSn;
		$rs = $this->db->exeSql($sql);
	
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$betSn = $rs[$i]["sn"];
				
			$sql = "update ".$this->db_qz."game_betting set result=0 where sn=".$betSn;
			$this->db->exeSql($sql);
		}
   }
	
	//▶ [배당지급] - 결과에 따른 돈 지급 취소(팝업정산)
 	function cancel_accountMoneyProcessing($childSn)
 	{
 		$rs = $this->gameModel->getChildRow($childSn, '*');
 		
 		$homeScore = $rs['home_score'];
 		$awayScore = $rs['away_score'];
 		$league_sn = $rs['league_sn']; //사다리게임만 체크를 위함

 		if(is_null($homeScore)||is_null($awayScore))
 			return -1;
 			
 		//이미 처리된게임인지 확인
 		if($rs['kubun']==1)
        {
            $rs = $this->gameModel->getSubChildRow($childSn, "sn");
            $subChildSn = $rs['sn'];

            $sql = "select b.betting_no, b.member_sn, d.last_special_code
						from 	tb_subchild a, tb_game_betting b, tb_child c, tb_game_cart d
						where a.sn=b.sub_child_sn and a.child_sn=c.sn and b.betting_no=d.betting_no and d.result<>0 and a.child_sn=".$childSn;
            $rs = $this->db->exeSql($sql);

            for($i=0; $i<count((array)$rs); ++$i)
            {
                $bettingNo = $rs[$i]['betting_no'];
                $sn = $rs[$i]['member_sn'];
                $specialCode = $rs[$i]['last_special_code'];

                $sql = "select a.*, c.sport_name from tb_game_betting a, tb_subchild b, tb_child c where a.sub_child_sn = b.sn and b.child_sn = c.sn and a.betting_no='".$bettingNo."'";
                $rsi = $this->db->exeSql($sql);

                $winCount = $loseCount = $cancelCount = $ingGameCount = $bonusGameCount = 0;
                $winRate = 1;
                $winMoney = 0;
                $total = count((array)$rsi);	//-> 경기총폴더수

                for ( $j = 0 ; $j < count((array)$rsi) ; $j++ ) {
                    $betMoney = $rsi[$j]['bet_money'];
                    $sportName = $rsi[$j]['sport_name'];

                    if ( $rsi[$j]['result'] == 0 ) {
                        ++$ingGameCount;
                    } else if ( $rsi[$j]['result'] == 1 ) {
                        ++$winCount;
                        $winRate *= $rsi[$j]['select_rate'];
                        if ( strlen($sportName) != strlen(str_replace("보너스","",$sportName)) ) {
                            ++$bonusGameCount;
                        }
                    } else if ( $rsi[$j]['result'] == 2 ) {
                        ++$loseCount;
                    } else if ( $rsi[$j]['result'] == 4 ) {
                        ++$cancelCount;
                        $winRate *= 1;
                    }
                }

                //모든게임종료
                if ( $ingGameCount == 0 )
                {
                    $memberSn = $rs[$i]['member_sn'];
                    $sql = "select logo from ".$this->db_qz."people where sn=".$memberSn;
                    $rsi = $this->db->exeSql($sql);
                    $logo = $rsi[0]['logo'];

                    //모두 취소된 게임
                    if ( $total == $cancelCount ) {
                        $winRate  = bcmul($winRate,1,2);
                        $winMoney = bcmul($betMoney,$winRate,0);

                        //$sql = "update ".$this->db_qz."game_cart set result=4, operdate=now(), result_money='".$winMoney."' where logo='".$logo."' and betting_no = '".$bettingNo."'";
                        $sql = "update ".$this->db_qz."game_cart set result=0, operdate=now(), result_money=0 where logo='".$logo."' and betting_no = '".$bettingNo."'";
                        $rsi = $this->db->exeSql($sql);
                        /*if($rsi<=0) {
                            $sql = "insert into debug_detail_log(betting_no, total, win, lose, ing, cancel) values('".$bettingNo."',".$total.",".$winCount.",".$loseCount.",".$ingGameCount.",".$cancelCount.")";
                            $this->db->exeSql($sql);
                        }
                        $this->modifyMoneyProcess($memberSn, $winMoney, 5, $bettingNo);*/

                        //낙첨
                    } else if( $loseCount > 0 ) {
                        //$sql = "update ".$this->db_qz."game_cart set result=2, operdate=now() where betting_no ='".$bettingNo."'";
                        $sql = "update ".$this->db_qz."game_cart set result=0, operdate=now() where betting_no ='".$bettingNo."'";
                        $rsi = $this->db->exeSql($sql);
                        /*if($rsi<=0) {
                            $sql = "insert into debug_detail_log(betting_no, total, win, lose, ing, cancel) values('".$bettingNo."',".$total.",".$winCount.",".$loseCount.",".$ingGameCount.",".$cancelCount.")";
                            $this->db->exeSql($sql);
                        }

                        //미니게임은 지급하지 않는다.
                        if($specialCode < 3) {
                            //-> 낙첨 마일리지는 미니게임은 제외하고 스포츠 1폴더 이상부터 지급
                            if ( ($winCount + $loseCount - $bonusGameCount) > 1 ) {
                                //낙첨 마일리지
                                $this->modifyMileageProcess($sn, $betMoney, "4", $bettingNo);
                            }
                        }*/
                        //당첨
                    }
                    //else if( ($winCount+$cancelCount) >= $total )
                    else if( $winCount > 0 )
                    {
                        $winRate  = bcmul($winRate,1,2);
                        $winMoney = bcmul($betMoney,$winRate,0);

                        //$sql = "update ".$this->db_qz."game_cart set result=1, operdate=now(), result_money='".$winMoney."' where logo='".$logo."' and betting_no = '".$bettingNo."'";
                        $sql = "update ".$this->db_qz."game_cart set result=0, operdate=now(), result_money=0 where logo='".$logo."' and betting_no = '".$bettingNo."'";
                        $rsi = $this->db->exeSql($sql);
                        if($rsi<=0)
                        {
                            $sql = "insert into debug_detail_log(betting_no, total, win, lose, ing, cancel) 
										values('".$bettingNo."',".$total.",".$winCount.",".$loseCount.",".$ingGameCount.",".$cancelCount.")";
                            $this->db->exeSql($sql);
                        }

                        $winMoney = -1 * $winMoney;
                        // 재정산전 취소
                        $this->modifyMoneyProcess($memberSn, $winMoney, 9, $bettingNo);
                        /*
                                            //다폴더 보너스 계산
                                            if ( ($winCount - $bonusGameCount) > 2 ) {
                                                //-> 통합 다폴더 포인트 rate 가져오기.
                                                $folderCnt = $winCount - $bonusGameCount;
                                                $folderRate = $this->configModel->getPointConfigRow("folder_bouns".$folderCnt);
                                                $this->modifyMileageProcess($sn, $betMoney, "3", $bettingNo, $folderRate["folder_bouns".$folderCnt], $folderCnt);
                                            }
                        */
                    }
                    else
                    {
                        /*$sql = "insert into debug_detail_log(betting_no, total, win, lose, ing, cancel, flag)
									values('".$bettingNo."',".$total.",".$winCount.",".$loseCount.",".$ingGameCount.",".$cancelCount.",1)";
                        $this->db->exeSql($sql);*/
                    }

                    //-> 추천인 마일리지는 미니게임 제외, 스포츠 1폴더(이기거나 진거 합 2이상) 이상부터 지급
                    if ( $specialCode < 3 ) {
                        if ( ($winCount + $loseCount - $bonusGameCount) > 1 ) {
                            //-> 추천인 마일리지
                            $this->cancel_recommendFailedGameMileage($sn, $betMoney, $bettingNo, $loseCount);
                        }
                    }

                }
            }// end of for

            $sql = "update ".$this->db_qz."subchild set result=0 where sn=".$subChildSn;
            $this->db->exeSql($sql);

            $sql = "update ".$this->db_qz."child set kubun=0 where sn=".$childSn;
            $this->db->exeSql($sql);
        }

		return 1;
 	}

	//▶ [배당지급] - 결과에 따른 돈 지급 취소(팝업정산) (다기준)
 	function cancel_accountMoneyProcessingMulti($subchildSn)
 	{
 		$rs = $this->gameModel->getChildRowMulti($subchildSn, '*');
 		
 		$homeScore = $rs['home_score'];
 		$awayScore = $rs['away_score'];

 		if(is_null($homeScore) || is_null($awayScore))
 			return -1;
 			
 		//이미 처리된게임인지 확인
 		//if($rs['kubun']==1)
        //{
		$sql = "select 	b.betting_no, b.member_sn, d.last_special_code
				from 	tb_subchild a, tb_game_betting b, tb_child c, tb_game_cart d
				where 	a.sn = b.sub_child_sn and a.child_sn=c.sn and b.betting_no=d.betting_no and d.result <> 0 and a.sn = ".$subchildSn;
		$rs = $this->db->exeSql($sql);

		for($i=0; $i<count((array)$rs); ++$i)
		{
			$bettingNo = $rs[$i]['betting_no'];
			$sn = $rs[$i]['member_sn'];
			$specialCode = $rs[$i]['last_special_code'];

			$sql = "select a.*, c.sport_name from tb_game_betting a, tb_subchild b, tb_child c where a.sub_child_sn = b.sn and b.child_sn = c.sn and a.betting_no='".$bettingNo."'";
			$rsi = $this->db->exeSql($sql);
			
			$winCount = $loseCount = $cancelCount = $ingGameCount = $bonusGameCount = 0;
			$winRate = 1;
			$winMoney = 0;
			$total = count((array)$rsi);	//-> 경기총폴더수

			for ( $j = 0 ; $j < count((array)$rsi) ; $j++ ) {
				$betMoney = $rsi[$j]['bet_money'];
				$sportName = $rsi[$j]['sport_name'];

				if ( $rsi[$j]['result'] == 0 ) {
					++$ingGameCount;
				} else if ( $rsi[$j]['result'] == 1 ) {
					++$winCount;
					$winRate *= $rsi[$j]['select_rate'];
					if ( strlen($sportName) != strlen(str_replace("보너스","",$sportName)) ) {
						++$bonusGameCount;
					}
				} else if ( $rsi[$j]['result'] == 2 ) {
					++$loseCount;
				} else if ( $rsi[$j]['result'] == 4 ) {
					++$cancelCount;
					$winRate *= 1;
				}
			}

			$winRate = round($winRate, 2);
			
			//모든게임종료
			if ( $ingGameCount == 0 )
			{
				$memberSn = $rs[$i]['member_sn'];
				$sql = "select logo from ".$this->db_qz."people where sn=".$memberSn;
				$rsi = $this->db->exeSql($sql);
				$logo = $rsi[0]['logo'];

				//모두 취소된 게임
				if ( $total == $cancelCount ) {
					$winRate  = bcmul($winRate,1,2);
					$winMoney = bcmul($betMoney,$winRate,0);
					
					//$sql = "update ".$this->db_qz."game_cart set result=4, operdate=now(), result_money='".$winMoney."' where logo='".$logo."' and betting_no = '".$bettingNo."'";
					$sql = "update ".$this->db_qz."game_cart set result=0, operdate=now(), result_money=0 where logo='".$logo."' and betting_no = '".$bettingNo."'";
					$rsi = $this->db->exeSql($sql);
					/*if($rsi<=0) {
						$sql = "insert into debug_detail_log(betting_no, total, win, lose, ing, cancel) values('".$bettingNo."',".$total.",".$winCount.",".$loseCount.",".$ingGameCount.",".$cancelCount.")";
						$this->db->exeSql($sql);
					}
					$this->modifyMoneyProcess($memberSn, $winMoney, 5, $bettingNo);*/

					// 재정산전 취소
					$winMoney = -1 * $winMoney;

					$this->modifyMoneyProcess($memberSn, $winMoney, 9, $bettingNo);

				//낙첨
				} else if( $loseCount > 0 ) {
					$sql = "update ".$this->db_qz."game_cart set result=0, operdate=now() where betting_no ='".$bettingNo."'";
					$rsi = $this->db->exeSql($sql);
					
				}
				//else if( ($winCount+$cancelCount) >= $total )
				else if( $winCount > 0 )
				{
					$winRate  = bcmul($winRate,1,2);
					$winMoney = bcmul($betMoney,$winRate,0);

					//$sql = "update ".$this->db_qz."game_cart set result=1, operdate=now(), result_money='".$winMoney."' where logo='".$logo."' and betting_no = '".$bettingNo."'";
					$sql = "update ".$this->db_qz."game_cart set result = 0, operdate = now(), result_money = 0 where logo='".$logo."' and betting_no = '".$bettingNo."'";
					$rsi = $this->db->exeSql($sql);
					if($rsi<=0)
					{
						$sql = "insert into debug_detail_log(betting_no, total, win, lose, ing, cancel) 
									values('".$bettingNo."',".$total.",".$winCount.",".$loseCount.",".$ingGameCount.",".$cancelCount.")";
						$this->db->exeSql($sql);
					}

					$winMoney = -1 * $winMoney;
					// 재정산전 취소
					$this->modifyMoneyProcess($memberSn, $winMoney, 9, $bettingNo);
					/*
						//다폴더 보너스 계산
						if ( ($winCount - $bonusGameCount) > 2 ) {
							//-> 통합 다폴더 포인트 rate 가져오기.
							$folderCnt = $winCount - $bonusGameCount;
							$folderRate = $this->configModel->getPointConfigRow("folder_bouns".$folderCnt);
							$this->modifyMileageProcess($sn, $betMoney, "3", $bettingNo, $folderRate["folder_bouns".$folderCnt], $folderCnt);
						}
					*/
				}
				else
				{
					/*$sql = "insert into debug_detail_log(betting_no, total, win, lose, ing, cancel, flag)
								values('".$bettingNo."',".$total.",".$winCount.",".$loseCount.",".$ingGameCount.",".$cancelCount.",1)";
					$this->db->exeSql($sql);*/
				}

				//-> 추천인 마일리지는 미니게임 제외, 스포츠 1폴더(이기거나 진거 합 2이상) 이상부터 지급
				if ( $specialCode < 5 ) {
					if ( ($winCount + $loseCount - $bonusGameCount) > 1 ) {
						//-> 추천인 마일리지
						$this->cancel_recommendFailedGameMileage($sn, $betMoney, $bettingNo, $loseCount);
					}
				}
			}
		}// end of for

		$sql = "update ".$this->db_qz."subchild set win = 0, result=0 where sn=".$subchildSn;
		$this->db->exeSql($sql);

        //}

		return 1;
 	}

 	
 	//▶ 당첨된 회원의 목록
	function accountListProcess($subchildSn, $betData)
	{
		$sql = "select 	a.member_sn, a.betting_no, a.betting_money, a.betting_ip, b.result,
						e.uid, e.nick, a.bet_date,
						c.gameDate, c.gameHour, c.gameTime, c.home_team, c.away_team,
						d.home_rate, d.draw_rate, d.away_rate, d.win
				from 	".$this->db_qz."game_cart a
						,".$this->db_qz."game_betting b
						,".$this->db_qz."child c
						,".$this->db_qz."subchild d
						,".$this->db_qz."people e
				where 	a.betting_no=b.betting_no 
						and b.sub_child_sn=d.sn 
						and c.sn=d.child_sn
						and a.member_sn=e.sn
						and a.result = 0
						and d.sn=".$subchildSn;
						
		$rs = $this->db->exeSql($sql);

		for($i=0; $i<count((array)$rs); ++$i)
		{
			$bettingNo  = $rs[$i]['betting_no'];

			$sql = "select tb_temp.*, tb_markets.mname_ko, tb_markets.mid from (
							select 	a.sn as betSn, a.betting_no, a.member_sn, a.bet_money, a.result, a.preview_result, a.select_rate, a.select_no, a.score, a.live,
									concat(c.gameDate,' ',c.gameHour,':',c.gameTime) as game_date, c.notice as league_name, d.betting_type, 
									c.home_team, c.away_team, a.home_rate, a.draw_rate, a.away_rate, c.home_score, c.away_score, d.win, c.sport_id, c.sport_name 
							from 	".$this->db_qz."game_betting a
									, ".$this->db_qz."child c
									, ".$this->db_qz."subchild d
							where 	a.sub_child_sn=d.sn 
									and d.child_sn=c.sn 
									and a.betting_no='".$bettingNo."') as tb_temp left join tb_markets on tb_temp.betting_type = tb_markets.mid";

			$rsi = $this->db->exeSql($sql);
			
			$winCount = $loseCount = $cancelCount = $ingGameCount = 0;
			$winRate	  = 1;
			$winMoney	  = 0;
			$total	= count((array)$rsi);
			
			for($j=0; $j<count((array)$rsi); ++$j)
			{
				$memberSn	= $rsi[$j]['member_sn'];
				$betMoney = $rsi[$j]['bet_money'];
				$result = $rsi[$j]['result'];
				
				//다른곳에 처리를 해버렸을 경우
				if($result==0)
				{
					$betSn	= $rsi[$j]['betSn'];
					for($k=0; $k<count((array)$betData); ++$k)
					{
						if($betSn==$betData[$k]['bet_sn'])
						{
							$result = $betData[$k]['result'];
							$rsi[$j]['win'] 			= $betData[$k]['win'];
							$rsi[$j]['result'] 			= $betData[$k]['result'];
						}
					}
				}
				
				if($result==0)
				{
					++$ingGameCount;
					break;
				}
					
				else if($result==1)
				{
					++$winCount;
					$winRate *= $rsi[$j]['select_rate'];
				}
				else if($result==2)
				{
					++$loseCount;
					break;
				}
				else if($result==4)
				{
					++$cancelCount;
					$winRate *= 1;
				}
			}
			
			if($loseCount > 0 || $ingGameCount > 0) //낙첨
			{
			}
			//모든게임종료
			else if($ingGameCount==0)
			{
				//모두 취소된 게임
				if(($winCount+$cancelCount) >= $total) //당첨
				{
					$winRate  = bcmul($winRate,1,2);
					$winMoney = bcmul($betMoney,$winRate,0);
					
					$rs[$i]["result_rate"] 	= $winRate;
					$rs[$i]["result_money"] = $winMoney;
					$rs[$i]["bonus_rate"] 	= 0;
					
					//다폴더 계산
					if($winCount>2)
					{
						$rate = $this->levelConfigModel->getMemberFolderBounsRate($memberSn, $winCount);
						$rs[$i]["bonus_rate"] 	= $rate;
						$rs[$i]["bonus_money"] 	= ($rate*$winMoney/100);
					}
					
					$list[$bettingNo] = $rs[$i];
					$list[$bettingNo]["item"]=$rsi;
				}
			}
			else
			{
			}
		}// end of for
		
		$dataArray = array();
		$dataArray["list"]		= $list;
		$dataArray["betData"]	= $betData;
		
		return $dataArray;
 	}

	 //▶ 당첨된 회원의 목록
	function accountListProcessMulti($subchildSn, $betData)
	{
		$sql = "select 		a.member_sn, a.betting_no, a.betting_money, a.betting_ip, b.result,
							e.uid, e.nick, a.bet_date,
							d.betting_type, c.gameDate, c.gameHour, c.gameTime, c.home_team, c.away_team,
							d.home_rate, d.draw_rate, d.away_rate, d.win
				from 		".$this->db_qz."game_cart a
							,".$this->db_qz."game_betting b
							,".$this->db_qz."child_m c
							,".$this->db_qz."subchild_m d
							,".$this->db_qz."people e
				where 		a.betting_no=b.betting_no 
						and b.sub_child_sn=d.sn 
						and c.sn=d.child_sn
						and a.member_sn=e.sn
						and a.result = 0
						and d.sn=".$subchildSn;
						
		$rs = $this->db->exeSql($sql);
	
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$bettingNo  = $rs[$i]['betting_no'];

			$sql = "select 	a.sn as betSn, a.betting_no, a.member_sn, a.bet_money, a.result, a.preview_result, a.select_rate, a.select_no,
							d.betting_type, concat(c.gameDate,' ',c.gameHour,':',c.gameTime) as game_date, e.name as league_name, 
							c.home_team, c.away_team, a.home_rate, a.draw_rate, a.away_rate, c.home_score, c.away_score, d.win
					from 	".$this->db_qz."game_betting a
							, ".$this->db_qz."game_cart b
							, ".$this->db_qz."child_m c
							, ".$this->db_qz."subchild_m d
							, ".$this->db_qz."league e
					where 	a.betting_no=b.betting_no 
						and a.sub_child_sn=d.sn 
						and d.child_sn=c.sn 
						and c.league_sn=e.sn
						and a.betting_no='".$bettingNo."'";

			$rsi = $this->db->exeSql($sql);
			
			$winCount = $loseCount = $cancelCount = $ingGameCount = 0;
			$winRate	  = 1;
			$winMoney	  = 0;
			$total	= count((array)$rsi);
			
			for($j=0; $j<count((array)$rsi); ++$j)
			{
				$memberSn	= $rsi[$j]['member_sn'];
				$betMoney = $rsi[$j]['bet_money'];
				$result = $rsi[$j]['result'];
				
				//다른곳에 처리를 해버렸을 경우
				if($result==0)
				{
					$betSn	= $rsi[$j]['betSn'];
					for($k=0; $k<count((array)$betData); ++$k)
					{
						if($betSn==$betData[$k]['bet_sn'])
						{
							$result = $betData[$k]['result'];
							
							$rsi[$j]['home_score']	= $betData[$k]['home_score'];
							$rsi[$j]['away_score']	= $betData[$k]['away_score'];
							$rsi[$j]['win'] 				= $betData[$k]['win'];
							$rsi[$j]['result'] 			= $betData[$k]['result'];
						}
					}
				}
				
				if($result==0)
				{
					++$ingGameCount;
					break;
				}
					
				else if($result==1)
				{
					++$winCount;
					$winRate *= $rsi[$j]['select_rate'];
				}
				else if($result==2)
				{
					++$loseCount;
					break;
				}
				else if($result==4)
				{
					++$cancelCount;
					$winRate *= 1;
				}
			}
			
			if($loseCount > 0 || $ingGameCount > 0) //낙첨
			{
			}
			//모든게임종료
			else if($ingGameCount==0)
			{
				//모두 취소된 게임
				if(($winCount+$cancelCount) >= $total) //당첨
				{
					$winRate  = bcmul($winRate,1,2);
					$winMoney = bcmul($betMoney,$winRate,0);
					
					$rs[$i]["result_rate"] 	= $winRate;
					$rs[$i]["result_money"] = $winMoney;
					$rs[$i]["bonus_rate"] 	= 0;
					
					//다폴더 계산
					if($winCount>2)
					{
						$rate = $this->levelConfigModel->getMemberFolderBounsRate($memberSn, $winCount);
						$rs[$i]["bonus_rate"] 	= $rate;
						$rs[$i]["bonus_money"] 	= ($rate*$winMoney/100);
					}
					
					$list[$bettingNo] = $rs[$i];
					$list[$bettingNo]["item"]=$rsi;
				}
			}
			else
			{
			}
		}// end of for
		
		$dataArray = array();
		$dataArray["list"]		= $list;
		$dataArray["betData"]	= $betData;
		
		return $dataArray;
 	}
	
 	//▶ 당첨된 회원의 목록
	function resultWinListProcess($childSn)
	{
		//승리한 게임의 정보를 넣어준다.
 		$rs = $this->gameModel->getChildRow($childSn, '*');
 		$homeScore = $rs['home_score'];
 		$awayScore = $rs['away_score'];
 		
 		if(is_null($homeScore)||is_null($awayScore))
 			return -1;
 			
 		//이미 처리된게임인지 확인
 		$sql = "select kubun from ".$this->db_qz."child where sn=".$childSn;
 		$rs = $this->db->exeSql($sql);
 		
 		$list = array();
 		if($rs[0]['kubun']==1)
 			return $list;
 		
		$sql = "select 	a.member_sn, a.betting_no, a.betting_money, a.betting_ip, b.result,
										e.uid, e.nick, a.bet_date,
										c.type, c.gameDate, c.gameHour, c.gameTime, c.home_team, c.away_team,
										d.home_rate, d.draw_rate, d.away_rate, d.win
							from ".$this->db_qz."game_cart a
											,".$this->db_qz."game_betting b
											,".$this->db_qz."child c
											, ".$this->db_qz."subchild d
											, ".$this->db_qz."people e
							where a.betting_no=b.betting_no 
										and b.sub_child_sn=d.sn 
										and c.sn=d.child_sn
										and a.member_sn=e.sn
										and a.is_account=1
										and c.sn=".$childSn;
						
		$rs = $this->db->exeSql($sql);
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$bettingNo  = $rs[$i]['betting_no'];

			$sql = "select 	a.betting_no, a.member_sn, a.bet_money, a.result, a.select_rate, a.select_no,
											c.type, concat(c.gameDate,' ',c.gameHour,':',c.gameTime) as game_date, e.name as league_name, 
											c.home_team, c.away_team, d.home_rate, d.draw_rate, d.away_rate, c.home_score, c.away_score, d.win
							from ".$this->db_qz."game_betting a
											, ".$this->db_qz."game_cart b
											, ".$this->db_qz."child c
											, ".$this->db_qz."subchild d
											, ".$this->db_qz."league e
							where a.betting_no=b.betting_no 
										and a.sub_child_sn=d.sn 
										and d.child_sn=c.sn 
										and c.league_sn=e.sn
										and a.betting_no='".$bettingNo."'";
			$rsi = $this->db->exeSql($sql);
			
			$winCount = $loseCount = $cancelCount = $ingGameCount = 0;
			$winRate	  = 1;
			$winMoney	  = 0;
			$total	= count((array)$rsi);
			
			for($j=0; $j<count((array)$rsi); ++$j)
			{
				$memberSn	= $rsi[$j]['member_sn'];
				$betMoney = $rsi[$j]['bet_money'];
				
				if($rsi[$j]['result']==0)
				{
					++$ingGameCount;
					break;
				}
					
				else if($rsi[$j]['result']==1)
				{
					++$winCount;
					$winRate *= $rsi[$j]['select_rate'];
				}
				else if($rsi[$j]['result']==2)
				{
					++$loseCount;
					break;
				}
				else if($rsi[$j]['result']==4)
				{
					++$cancelCount;
					$winRate *= 1;
				}
			}
			
			if($loseCount > 0 || $ingGameCount > 0) //낙첨
			{
				//break;
			}
			//모든게임종료
			else if($ingGameCount==0)
			{
				//모두 취소된 게임
				if(($winCount+$cancelCount) >= $total) //당첨
				{
					$winRate  = bcmul($winRate,1,2);
					$winMoney = bcmul($betMoney,$winRate,0);
					
					$rs[$i]["result_rate"] 	= $winRate;
					$rs[$i]["result_money"] = $winMoney;
					$rs[$i]["bonus_rate"] 	= 0;
					//다폴더 계산
					if($winCount>2)
					{
						$rate = $this->levelConfigModel->getMemberFolderBounsRate($memberSn, $winCount);
						$rs[$i]["bonus_rate"] 	= $rate;
						$rs[$i]["bonus_money"] 	= ($rate*$winMoney/100);
					}
					
					$list[$bettingNo] = $rs[$i];
					$list[$bettingNo]["item"]=$rsi;
				}
			}
			else
			{
			}
		}// end of for
		
		return $list;
 	}
 	
 	//▶ [배당지급] - 결과에 따른 돈 지급
 	function resultMoneyProcess($childSn)
 	{
 		$rs = $this->gameModel->getChildRow($childSn, '*');
 		$homeScore = $rs['home_score'];
 		$awayScore = $rs['away_score'];
 		if(is_null($homeScore)||is_null($awayScore))
 			return -1;
 		
 		$sql = "update ".$this->db_qz."child set kubun=1 where sn=".$childSn;
 		$this->db->exeSql($sql);
 
		$sql = "select b.betting_no, b.member_sn, d.last_special_code
						from ".$this->db_qz."subchild a, ".$this->db_qz."game_betting b, ".$this->db_qz."child c, ".$this->db_qz."game_cart d
						where a.sn=b.sub_child_sn and a.child_sn=c.sn and b.betting_no=d.betting_no and d.result=0 and a.child_sn=".$childSn;
		$rs = $this->db->exeSql($sql);		
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$bettingNo = $rs[$i]['betting_no'];
			$sn = $rs[$i]['member_sn'];
			$specialCode = $rs[$i]['last_special_code'];
			
			$sql = "select a.*, c.sport_name from tb_game_betting a, tb_subchild b, tb_child c where a.sub_child_sn = b.sn and b.child_sn = c.sn and a.betting_no='".$bettingNo."'";
			$rsi = $this->db->exeSql($sql);
			
			$winCount = $loseCount = $cancelCount = $ingGameCount = $bonusGameCount = 0;
			$winRate = 1;
			$winMoney = 0;
			$total = count((array)$rsi);	//-> 경기총폴더수
			
			for ( $j = 0 ; $j < count((array)$rsi) ; $j++ ) {
				$betMoney = $rsi[$j]['bet_money'];
				$sportName = $rsi[$j]['sport_name'];

				if ( $rsi[$j]['result'] == 0 ) {
					++$ingGameCount;
				} else if ( $rsi[$j]['result'] == 1 ) {
					++$winCount;
					$winRate *= $rsi[$j]['select_rate'];
					if ( strlen($sportName) != strlen(str_replace("보너스","",$sportName)) ) {
						++$bonusGameCount;
					}
				} else if ( $rsi[$j]['result'] == 2 ) {
					++$loseCount;
				} else if ( $rsi[$j]['result'] == 4 ) {
					++$cancelCount;
					$winRate *= 1;
				}
			}
			
			//모든게임종료
			if ( $ingGameCount == 0 ) {
				$memberSn = $rs[$i]['member_sn'];
				$sql = "select logo from ".$this->db_qz."people where sn=".$memberSn;
				$rsi = $this->db->exeSql($sql);					
				$logo = $rsi[0]['logo'];
				
				//모두 취소된 게임
				if ( $total == $cancelCount ) {
					$winRate  = bcmul($winRate,1,2);
					$winMoney = bcmul($betMoney,$winRate,0);
						
					$sql = "update ".$this->db_qz."game_cart set result=4, operdate=now(), result_money='".$winMoney."' where logo='".$logo."' and betting_no = '".$bettingNo."'";
					$rsi = $this->db->exeSql($sql);
					$this->modifyMoneyProcess($memberSn, $winMoney, 5, $bettingNo);

				//낙첨
				} else if( $loseCount > 0 ) {
					$sql = "update ".$this->db_qz."game_cart set result=2 ,operdate=now() where betting_no =".$bettingNo;
					$rsi = $this->db->exeSql($sql);

					//미니게임은 지급하지 않는다.
					if ( $specialCode < 3 ) {
						//-> 낙첨 마일리지는 미니게임은 제외하고 스포츠 1폴더 이상부터 지급
						if ( ($winCount + $loseCount - $bonusGameCount) > 1 ) {
							//낙첨 마일리지
							$this->modifyMileageProcess($sn, $betMoney, "4", $bettingNo);
						}
					}

				//당첨
				} else if( ($winCount + $cancelCount) >= $total) {
					$winRate  = bcmul($winRate,1,2);
					$winMoney = bcmul($betMoney,$winRate,0);
						
					$sql = "update ".$this->db_qz."game_cart set result=1, operdate=now(), result_money='".$winMoney."' where logo='".$logo."' and betting_no = '".$bettingNo."'";
					$rsi = $this->db->exeSql($sql);						
					$this->modifyMoneyProcess($memberSn, $winMoney, 4, $bettingNo);

					//다폴더 보너스 계산
/*
					if ( ($winCount - $bonusGameCount) > 2 ) {
						//-> 통합 다폴더 포인트 rate 가져오기.
						$folderCnt = $winCount - $bonusGameCount;
						$folderRate = $this->configModel->getPointConfigRow("folder_bouns".$folderCnt);
						$this->modifyMileageProcess($sn, $betMoney, "3", $bettingNo, $folderRate["folder_bouns".$folderCnt], $folderCnt);
					}
*/
				}

				//-> 추천인 마일리지는 미니게임 제외, 스포츠 1폴더(이기거나 진거 합 2이상) 이상부터 지급
				if ( $specialCode < 3 ) {
					if ( ($winCount + $loseCount - $bonusGameCount) > 1 ) {
						//-> 추천인 낙첨 마일리지
						$this->recommendFailedGameMileage($sn, $betMoney, $bettingNo, $loseCount);
					}
				}

			}
			
		}// end of for
		return 1;
 	}
 	
 	//▶ [rollback]
 	function rollbackGameProcess($childSn)
 	{
 		// 01. 설정변경
 		//rollback child
 		$sql = "update ".$this->db_qz."child set home_score=null, away_score=null, win_team=null, handi_winner=null, kubun=0
 						where sn=".$childSn;
 		$this->db->exeSql($sql);

 		$sql = "select * from ".$this->db_qz."subchild where child_sn=".$childSn;
 		$rs = $this->db->exeSql($sql);
 		$subSn = $rs[0]['sn'];
 		
 		//cancel game
 		//01. rollback subchild 
		$sql = "update ".$this->db_qz."subchild set win=null,result=null
						where sn=".$subSn;
		$this->db->exeSql($sql);
		
		//02. rollback total_betting
		$sql = "update ".$this->db_qz."game_betting set result=0 where admin_cancel_flag=0 and sub_child_sn=".$subSn;
		$this->db->exeSql($sql);

		// 02. rollback money - 당첨금, 낙첨마일리지, 다폴더마일리지, 추천인 낙첨 마일리지
		$sql = "select b.betting_no, b.member_sn
						from ".$this->db_qz."subchild a, ".$this->db_qz."game_betting b, ".$this->db_qz."child c, ".$this->db_qz."game_cart d
						where a.sn=b.sub_child_sn and a.child_sn=c.sn and b.betting_no=d.betting_no and b.admin_cancel_flag=0 and d.result!=0 and a.child_sn=".$childSn;
		$rs = $this->db->exeSql($sql);			
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$bettingNo  = $rs[$i]['betting_no'];
			
			//rollback cart
			$sql = "update ".$this->db_qz."game_cart set result=0,operdate=now()
							where betting_no = '".$bettingNo."'" ;  
			$this->db->exeSql($sql);			
			
			$sql = "select * from ".$this->db_qz."money_log where state=4 and betting_no='".$bettingNo."'";
			$rsi = $this->db->exeSql($sql);		
	
			//당첨금
			for($j=0; $j<count((array)$rsi); ++$j)
			{
				$sn = $rsi[$j]['sn'];
				$memberSn = $rsi[$j]['member_sn'];
				$amount = $rsi[$j]['amount'];
					
				$sql = "update ".$this->db_qz."money_log set state=9 where sn=".$sn;
				$this->db->exeSql($sql);
				$this->modifyMoneyProcess($memberSn, -$amount, 8, $bettingNo);
			}
			
			//낙첨,다폴더 마일리지, 추천인 낙첨 마일리지
			$sql = "select * from ".$this->db_qz."mileage_log where (state=4 or state=3 or state=12) and betting_no='".$bettingNo."'";
			$rsi = $this->db->exeSql($sql);		
	
			for($j=0; $j<count((array)$rsi); ++$j)
			{
				$sn = $rsi[$j]['sn'];
				$memberSn = $rsi[$j]['member_sn'];
				$amount = $rsi[$j]['amount'];
				
				$sql = "update ".$this->db_qz."mileage_log set state=9 where sn=".$sn;
				$this->db->exeSql($sql);
				$this->modifyMileageProcess($memberSn, -$amount, "8", "경기재입력[배팅번호:".$bettingNo."]");
			}
		}
 	}

	 //▶ [rollback]
 	function rollbackMultiGameProcess($childSn, $sub_sn)
 	{
 		// 01. 설정변경
 		//rollback child
 		$sql = "update ".$this->db_qz."child_m set home_score=null, away_score=null, win_team=null, handi_winner=null, kubun=0
 						where sn=".$childSn;
 		$this->db->exeSql($sql);

 		$sql = "select * from ".$this->db_qz."subchild_m where sn=".$sub_sn;
 		$rs = $this->db->exeSql($sql);
 		$subSn = $rs[0]['sn'];
 		
 		//cancel game
 		//01. rollback subchild 
		$sql = "update ".$this->db_qz."subchild_m set win=null,result=null
						where sn=".$subSn;
		$this->db->exeSql($sql);
		
		//02. rollback total_betting
		$sql = "update ".$this->db_qz."game_betting set result=0 where admin_cancel_flag=0 and sub_child_sn=".$subSn;
		$this->db->exeSql($sql);

		// 02. rollback money - 당첨금, 낙첨마일리지, 다폴더마일리지, 추천인 낙첨 마일리지
		$sql = "select b.betting_no, b.member_sn
						from ".$this->db_qz."subchild_m a, ".$this->db_qz."game_betting b, ".$this->db_qz."child_m c, ".$this->db_qz."game_cart d
						where a.sn=b.sub_child_sn and a.child_sn=c.sn and b.betting_no=d.betting_no and b.admin_cancel_flag=0 and d.result!=0 and a.child_sn=".$childSn;
		$rs = $this->db->exeSql($sql);			
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$bettingNo  = $rs[$i]['betting_no'];
			
			//rollback cart
			$sql = "update ".$this->db_qz."game_cart set result=0,operdate=now()
							where betting_no = '".$bettingNo."'" ;  
			$this->db->exeSql($sql);			
			
			$sql = "select * from ".$this->db_qz."money_log where state=4 and betting_no='".$bettingNo."'";
			$rsi = $this->db->exeSql($sql);		
	
			//당첨금
			for($j=0; $j<count((array)$rsi); ++$j)
			{
				$sn = $rsi[$j]['sn'];
				$memberSn = $rsi[$j]['member_sn'];
				$amount = $rsi[$j]['amount'];
					
				$sql = "update ".$this->db_qz."money_log set state=9 where sn=".$sn;
				$this->db->exeSql($sql);
				$this->modifyMoneyProcess($memberSn, -$amount, 8, $bettingNo);
			}
			
			//낙첨,다폴더 마일리지, 추천인 낙첨 마일리지
			$sql = "select * from ".$this->db_qz."mileage_log where (state=4 or state=3 or state=12) and betting_no='".$bettingNo."'";
			$rsi = $this->db->exeSql($sql);		
	
			for($j=0; $j<count((array)$rsi); ++$j)
			{
				$sn = $rsi[$j]['sn'];
				$memberSn = $rsi[$j]['member_sn'];
				$amount = $rsi[$j]['amount'];
				
				$sql = "update ".$this->db_qz."mileage_log set state=9 where sn=".$sn;
				$this->db->exeSql($sql);
				$this->modifyMileageProcess($memberSn, -$amount, "8", "경기재입력[배팅번호:".$bettingNo."]");
			}
		}
 	}
	
	/**
	*--------------------------------------------------------------------
 	*
 	* member process
 	*
 	*--------------------------------------------------------------------
 	*/
	
	//▶ 회원 돈 정보 갱신
	function modifyMoneyProcess($sn, $amount, $status, $statusMessage, $memo='')
	{
        $mem_status = $this->memberModel->getMemberField($sn, "mem_status");


		//-> 당첨금 다중 처리 금지를 위해 로그 확인.
		if ( $status == 4 ) {			
			$sql = "select count(*) as cnt from tb_money_log where betting_no = '{$statusMessage}' and state = 4 and member_sn = '{$sn}'";
			$rs = $this->db->exeSql($sql);	
			if ( $rs[0]['cnt'] > 0 ) {
				return 1;
			}
		}

		if($status == 9)
        {
            $sql = "delete from tb_money_log where betting_no = '{$statusMessage}' and state = 4 and member_sn = '{$sn}'";
            $rs = $this->db->exeSql($sql);
        }

		$before = $this->memberModel->getMemberField($sn, "g_money");
		
		$add = "g_money = g_money +(".$amount.")";
		$sql = "update ".$this->db_qz."people set ".$add." where sn=".$sn;
		$this->db->exeSql($sql);
		
		$after 	= $this->memberModel->getMemberField($sn, "g_money");

        if($mem_status == 'N')
        {
			$loginModel	= Lemon_Instance::getObject("LoginModel", true);
			$isGhost = $loginModel->isGhostManger($_SESSION["member"]["sn"]);
			if($isGhost == 0 || $status == 4) {
				$this->moneyModel->addMoneyLog($sn, $amount, $before, $after, $status, $statusMessage, $memo);
			}
        }
	}

    function modifyPresenseCheckMileageProcess($sn, $status)
    {
        $mem_status = $this->memberModel->getMemberField($sn, "mem_status");

        $config = $this->configModel->getPointConfigRow("*");
        $amount = 0;

        switch($status) {
            case '0':
                $amount = $config['day_charge_bonus'];
                $statusMessage = "매일 출석체크포인트";
                break;
            case '1':
                $amount = $config['week_charge_bonus'];
                $statusMessage = "일주일 출석체크포인트";
                break;//$rate = 10; break;
            case '2':
                $amount = $config['month_charge_bonus'];
                $statusMessage = "한달 출석체크포인트";
                break;
            default :
                $amount = 0;
        }
        //다폴더

        $before = $this->memberModel->getMemberField($sn, "point");

        $add = "point = point +(".$amount.")";
        $sql = "update ".$this->db_qz."people set ".$add." where sn = ".$sn;
        $this->db->exeSql($sql);

        $after 	= $this->memberModel->getMemberField($sn, "point");

        if($mem_status == 'N')
        {
            $sql = "insert into ".$this->db_qz."mileage_log(member_sn, amount, before_mileage, after_mileage, regdate, state, status_message, rate, betting_no, log_memo) 
						values (".$sn.",".$amount.",".$before.",".$after.",now(),".$status.",'".$statusMessage."',0,'','')";

            return $this->db->exeSql($sql);
        }
    }

	//▶ 마일리지
	function modifyMileageProcess($sn, $amount, $status, $statusMessage, $rate=0, $winCount='', $memo='')
	{
		$mem_status 	= $this->memberModel->getMemberField($sn, "mem_status");

        $level = $this->memberModel->getMemberField($sn, 'mem_lev');
		$bettingNo='0';

		if($rate == '') $rate = 0;

		if($rate==0)
		{
			//1=충전, 2=추천인, 3=다폴더,4=낙첨,5=이벤트,7=관리자수정
			switch($status)
			{
                /* case '0':
                    $rate = $this->configModel->getLevelConfigField($level, 'lev_first_charge_mileage_rate');
                    break;
				case '1':
				    $rate = $this->configModel->getLevelConfigField($level, 'lev_charge_mileage_rate');
				    break;//$rate = 10; break;
				case '2': break;
				case '3': break; */
				case '4': 
					{
						// $rate = $this->configModel->getLevelConfigField($level, 'lev_bet_failed_mileage_rate');
						$bettingNo = $statusMessage;
						$statusMessage = "낙첨|게임번호[".$bettingNo."]";
					} 
					break; 
				case '5':
				case '6':
				case '7': 
				case '8': 
					$rate = 100; 
					break;
				default : $rate = 0;
			}
		} 
		//다폴더
		if($status=='3')
		{
			$bettingNo = $statusMessage;
			$statusMessage=sprintf("%d게임|다폴더[배팅번호:%s]", $winCount, $bettingNo);
		}
		//추천인 낙첨 마일리지
		if($status=='12')
		{
			$bettingNo = $statusMessage;
			$statusMessage = "추천인 ".$memo." 마일리지|게임번호[".$bettingNo."]";
		}
		
		if($rate<0) return 0;
		
		$amount = (int)($amount*$rate/100);
		
		$before = $this->memberModel->getMemberField($sn, "point");
		
		$add = "point = point +(".$amount.")";
		$sql = "update ".$this->db_qz."people set ".$add." where sn = ".$sn;
		$this->db->exeSql($sql);
		
		$after 	= $this->memberModel->getMemberField($sn, "point");

        if($mem_status == 'N')
        {
            $sql = "insert into ".$this->db_qz."mileage_log(member_sn, amount, before_mileage, after_mileage, regdate, state, status_message, rate, betting_no, log_memo) 
						values (".$sn.",".$amount.",".$before.",".$after.",now(),".$status.",'".$statusMessage."',".$rate.",'".$bettingNo."','".$memo."')";

            /*
            $sql = "insert into ".$this->db_qz."mileage_log(member_sn,amount,before_mileage,after_mileage,regdate,state,status_message,rate,betting_no)
                        values (".$sn.",".$amount.",".$before.",".$after.",now(),".$status.",'".$statusMessage."',".$rate.",'".$bettingNo."')";
            */

            return $this->db->exeSql($sql);
        }
	}
	
	//▶ 마일리지 회수
	function modifyMileageBackProcess($sn, $amount, $status, $bettingNo, $rate, $memo='') {
		//-> 낙첨 마일리지
		if ( $status == "4" ) {
			$statusMessage = "[회수] 낙첨|게임번호[".$bettingNo."]";
		}

		//-> 추천인 마일리지
		if ( $status == "12" ) {
			$statusMessage = "[회수] 추천인 ".$memo." 마일리지|게임번호[".$bettingNo."]";
		}

		$before = $this->memberModel->getMemberField($sn, "point");
		
		$sql = "update tb_people set point = point + (".$amount.") where sn = ".$sn;
		$this->db->exeSql($sql);
		
		$after 	= $this->memberModel->getMemberField($sn, "point");
		
		$sql = "insert into ".$this->db_qz."mileage_log(member_sn, amount, before_mileage, after_mileage, regdate, state, status_message, rate, betting_no, log_memo) 
						values (".$sn.",".$amount.",".$before.",".$after.",now(),".$status.",'".$statusMessage."',".$rate.",'".$bettingNo."','".$memo."')";		
		return $this->db->exeSql($sql);
	}

	/**
	*--------------------------------------------------------------------
 	*
 	* exchange process
 	*
 	*--------------------------------------------------------------------
 	*/
	
	//▶ 환전요청
	//▶ 환전 요청의 경우 사용자의 금액을 빼줘야 한다. 더이상 게임 진행 불가.
	function exchangeReqProcess($memberSn, $amount,$passwd='')
	{
		if($amount<=0) return -2;
		
		$rs = $this->memberModel->getMemberRow($memberSn,"g_money,exchange_pass");
		if($rs['g_money'] < $amount) return -3;
		
		if($passwd!='' && $passwd!=$rs['exchange_pass']) {return -1;} //-> 출금비번 확인 함. 20170525....
		
		$this->modifyMoneyProcess($memberSn, -$amount, '2','환전요청');

		// 복호화된 은행정보
		$strUserBankInfo = $this->memberModel->getPersonInfo($memberSn);
		$arrUserBankInfo = explode("|", $strUserBankInfo);
		
		$sql_bak = "insert into ".$this->db_qz."exchange_log_bak(member_sn,amount,bank,bank_account,bank_owner, regdate, state, is_read, is_hidden, logo)
				values(".$memberSn.",".$amount.",'".$arrUserBankInfo[1]."','".$arrUserBankInfo[2]."','".$arrUserBankInfo[3]."', now(), 0, 0, 0,'".$this->logo."')";
		$this->db->exeSql($sql_bak);

		$sql = "insert into ".$this->db_qz."exchange_log(member_sn,amount,bank,bank_account,bank_owner, regdate, state, is_read, is_hidden, logo)
				values(".$memberSn.",".$amount.",'".$arrUserBankInfo[1]."','".$arrUserBankInfo[2]."','".$arrUserBankInfo[3]."', now(), 0, 0, 0,'".$this->logo."')";
				
		return $this->db->exeSql($sql);
	}
	
	//▶ 환전요청 상태로 이동 
	function exchange_rollbackReqProcess($sn)
	{
		$sql = "update ".$this->db_qz."exchange_log set agree_amount=0, before_money=0, after_money=0, operdate=null, state=0
				where sn=".$sn;
				
		return $this->db->exeSql($sql);
	}
	
	//▶ 환전취소
	function exchangeCancelProcess($sn)
	{
        $state = $this->moneyModel->getExchangeState($sn);
		
		if($state=='' || $state==3) return -2;
		
		$rs = $this->moneyModel->getExchangeRow($sn);
		if($rs['sn']=='') 	return -1;
		
		$memberSn  	 = $rs['member_sn'];
		$amount		 = $rs['amount'];
		$agreeAmount = $rs['agree_amount'];
		
		if($state==1 || $state==3) { $amount = $agreeAmount;}
		
		$this->modifyMoneyProcess($memberSn, $amount, '2','환전취소');
		
		$sql = "UPDATE ".$this->db_qz."exchange_log
				SET	state = 2, operdate=now()	
				where sn=".$sn;
			
		$rs = $this->db->exeSql($sql);
		
		return ($rs>0)? 1:0;
	}
	
	//▶ 환전
	function exchangeProcess($sn)
	{	
		$rs = $this->moneyModel->getExchangeState($sn);
		//$state = $rs['state'];
		
		if($rs!=0) return -1;
		
		$rs = $this->moneyModel->getExchangeRow($sn);
		if($rs['sn']=='') 	return -1;
		
		$memberSn  	 = $rs['member_sn'];
		$amount		 = $rs['amount'];
	
		//환전신청시 이미 금액은 가감한다.
		$after = $before = $this->memberModel->getMemberField($memberSn, "g_money");
	
		$sql = "update ".$this->db_qz."exchange_log set agree_amount=".$amount.", before_money=".$before.", after_money=".$after.", operdate=now(), state=3
						where sn=".$sn;
				
		$rs = $this->db->exeSql($sql);
		
		//환전 처리와 승인을 동시에 하는걸로 바뀜. 이전대로 하려면 이 주석을 풀면 됨
		//return ($rs>0)? 1:0;
		return $this->exchangeConfirmProcess($sn);
	}
	
	//▶ 환전 최종승인
	function exchangeConfirmProcess($sn)
	{	
		$rs = $this->moneyModel->getExchangeRow($sn);
		$state = $rs['state'];
		
		if($state!=3) return -1;
		
		$sql = "update ".$this->db_qz."exchange_log set operdate=now(), state=1 where sn=".$sn;
		
		//추천인 마일리지
		//$this->recommendMileage($rs['member_sn'], -$rs['agree_amount']);
				
		$rs = $this->db->exeSql($sql);
		
		return ($rs>0)? 1:0;
	}
	
	
	/**
	*--------------------------------------------------------------------
 	*
 	* charge process
 	*
 	*--------------------------------------------------------------------
 	*/
	//▶ 충전요청 삭제
	function delchargeReq($sn)
	{
		$sql = "delete from ".$this->db_qz."charge_log
					where sn = ".$sn;
					
		return $this->db->exeSql($sql);
	}

	//▶ 승인되지 않은 충전요청이 있는지 확인
	function checkChargeConfirm($member_sn) {
		$sql = "select sn from ".$this->db_qz."charge_log where member_sn = " . $member_sn . " and state = 0";
		return $this->db->exeSql($sql);
	}
	
	//▶ 충전요청
	function chargeReqProcess($member_sn, $amount, $state = 0)
	{
		$charge_list = $this->getRows("*", $this->db_qz."charge_log", "member_sn=".$member_sn);
		
		$rs = $this->memberModel->getMemberRow($member_sn, "bank_name,bank_account,bank_member");
		
		if(count((array)$charge_list)==0)	
		{
			$sql = "insert into ".$this->db_qz."charge_log(member_sn,amount,bank,bank_account,bank_owner, regdate, state, is_read, is_hidden, logo)
							values(".$member_sn.",".$amount.",'".$rs['bank_name']."','".$rs['bank_account']."','".$rs['bank_member']."', now(), ".$state.", 0, 0, '".$this->logo."')";
			
			$sql_bak = "insert into ".$this->db_qz."charge_log_bak(member_sn,amount,bank,bank_account,bank_owner, regdate, state, is_read, is_hidden, logo)
							values(".$member_sn.",".$amount.",'".$rs['bank_name']."','".$rs['bank_account']."','".$rs['bank_member']."', now(), ".$state.", 0, 0, '".$this->logo."')";
		}
		else
		{
			$sql = "insert into ".$this->db_qz."charge_log(member_sn,amount,bank,bank_account,bank_owner, regdate, state, is_read, is_hidden, logo)
							values(".$member_sn.",".$amount.",'".$rs['bank_name']."','".$rs['bank_account']."','".$rs['bank_member']."', now(), ".$state.", 0, 0, '".$this->logo."')";
			
			$sql_bak = "insert into ".$this->db_qz."charge_log_bak(member_sn,amount,bank,bank_account,bank_owner, regdate, state, is_read, is_hidden, logo)
							values(".$member_sn.",".$amount.",'".$rs['bank_name']."','".$rs['bank_account']."','".$rs['bank_member']."', now(), ".$state.", 0, 0, '".$this->logo."')";
		}
		$this->db->exeSql($sql_bak);
				
		return $this->db->exeSql($sql);
	}

	function chargeReqProcess2($member_sn, $amount, $bank_owner)
	{
		$charge_list = $this->getRows("*", $this->db_qz."charge_log", "member_sn=".$member_sn);
		
		$rs = $this->memberModel->getMemberRow($member_sn, "bank_name,bank_account,bank_member");
		
		if(count((array)$charge_list)==0)
		{
			$sql = "insert into ".$this->db_qz."charge_log(member_sn,amount,bank,bank_account,bank_owner, regdate, state, is_read, is_hidden, logo)
							values(".$member_sn.",".$amount.",'".$rs['bank_name']."','".$rs['bank_account']."','".$bank_owner."', now(), 0, 0, 0, '".$this->logo."')";
			
			$sql_bak = "insert into ".$this->db_qz."charge_log_bak(member_sn,amount,bank,bank_account,bank_owner, regdate, state, is_read, is_hidden, logo)
							values(".$member_sn.",".$amount.",'".$rs['bank_name']."','".$rs['bank_account']."','".$rs['bank_member']."', now(), ".$state.", 0, 0, '".$this->logo."')";
		}
		else
		{
			$sql = "insert into ".$this->db_qz."charge_log(member_sn,amount,bank,bank_account,bank_owner, regdate, state, is_read, is_hidden, logo)
							values(".$member_sn.",".$amount.",'".$rs['bank_name']."','".$rs['bank_account']."','".$bank_owner."', now(), 0, 0, 0, '".$this->logo."')";
			
			$sql_bak = "insert into ".$this->db_qz."charge_log_bak(member_sn,amount,bank,bank_account,bank_owner, regdate, state, is_read, is_hidden, logo)
							values(".$member_sn.",".$amount.",'".$rs['bank_name']."','".$rs['bank_account']."','".$rs['bank_member']."', now(), ".$state.", 0, 0, '".$this->logo."')";
		}
		$this->db->exeSql($sql_bak);
				
		return $this->db->exeSql($sql);
	}
	
	//▶ 충전
	function chargeProcess($sn, $memberSn, $amount, $bonus=0)
	{
		$sql = "select count(*) from ".$this->db_qz."charge_log where sn=".$sn;
		$rs = $this->db->exeSql($sql);
		
		if(count((array)$rs)<=0) return -1;
		
		$sql = "select logo from ".$this->db_qz."people where sn=".$memberSn;
		$rs = $this->db->exeSql($sql);
		$logo = $rs[0]['logo'];
		
		$sql = "select count(*) as cnt from ".$this->db_qz."charge_log where date(now())=date(operdate) and state=1 and member_sn=".$memberSn;
		$rs = $this->db->exeSql($sql);

		//금일 첫 충전 마일리지
		if($rs[0]['cnt']<=0)	
		{
			$this->modifyMileageProcess($memberSn, $amount, '0', '충전', $bonus, '', '금일 첫충');
		} else {
            $this->modifyMileageProcess($memberSn, $amount, '1', '충전', $bonus, '', '충전 관리자 보너스');
        }

		//추천인 마일리지
		//$this->recommendMileage($memberSn, $amount);
	
		$before = $this->memberModel->getMemberField($memberSn, "g_money");
		$this->modifyMoneyProcess($memberSn, $amount, '1',"충전");
		$after 	= $this->memberModel->getMemberField($memberSn, "g_money");
		
		//관리자 보너스 지급 (보유머니->마일리지로 변경)
        /*if($bonus>0)
		{
            $this->modifyMileageProcess($memberSn, $bonus, '1', '충전', '', '', '충전 관리자 보너스');
			//$this->modifyMileageProcess($memberSn, $bonus, '8', '충전', '', '', '충전 관리자 보너스');
			//$this->modifyMoneyProcess($memberSn, $bonus, '7',"충전 관리자 보너스");
		}*/
		
		//충전 마일리지 적립
		$sql = "select count(*) as cnt from ".$this->db_qz."charge_log where date(regdate)=date(now()) and state=1";
		$rs = $this->db->exeSql($sql);

        $bonus = $bonus * $amount / 100;
		$sql = "update ".$this->db_qz."charge_log set agree_amount=".$amount.", before_money=".$before.", after_money=".$after.", bonus=".$bonus.",operdate=now(), state=1
				where sn=".$sn;
				
		$rs = $this->db->exeSql($sql);
		return ($rs>0)? 1:0;
	}
	
	//▶ 추천인 마일리지
	function recommendMileage($sn, $amount)
	{
		$uid = $this->memberModel->getMemberField($sn,'uid');
		
		//1차 추천인 마일리지
		
		$rs = $this->partnerModel->joinRecommendRate($sn, 1);
		$recommendSn = $rs['recommend_sn'];
		$rate = $rs['rate'];
		
		if($rate > 0)
		{
			$this->modifyMileageProcess($recommendSn, $amount, "2", $uid."|추천인|", $rate);
			
			/*
			//2차 추천인 검색
			$rs = $this->partnerModel->joinRecommendRate($sn, 2);
			$recommendSn = $rs['recommend_sn'];
			$rate = $rs['rate'];
			if($rate > 0)
			{
				$this->modifyMileageProcess($recommendSn, $amount, "2", $uid."|2차추천인|", $rate);
				
				//3차 추천인 검색
				$rs = $this->partnerModel->joinRecommendRate($sn, 3);
				$recommendSn = $rs['recommend_sn'];
				$rate = $rs['rate'];
				$this->modifyMileageProcess($recommendSn, $amount, "2", $uid."|3차추천인|", $rate);
			}
			*/
		}
	}
	
	//▶ 추천인 배팅 및 낙첨 마일리지
	function recommendFailedGameMileage($sn, $amount, $bettingNo, $loseCount)
	{
		//-> 1대, 2대 회원sn을 가져옴.
		$sql = "select recommend_sn, recommend2_sn from tb_join_recommend where member_sn = ".$sn;
		$recommendInfo = $this->db->exeSql($sql);
		$recommend_sn = $recommendInfo[0]["recommend_sn"];
		$recommend2_sn = $recommendInfo[0]["recommend2_sn"];

		//-> 1대 추천인 처리.
		if ( $recommend_sn > 0 ) {
			$sql = "SELECT uid, mem_lev FROM tb_people WHERE mem_status = 'N' and sn = '".$recommend_sn."'";
			$memberInfo = $this->db->exeSql($sql);
			if ( count((array)$memberInfo[0]) > 0 ) {
				$recommend_lev = $memberInfo[0]["mem_lev"];

				//-> 1대 레벨에 맞는 마일리지 지급타입과 지급율(%)을 가져온다.
				$sql = "SELECT lev_join_recommend_mileage_rate_type, lev_join_recommend_mileage_rate FROM tb_level_config WHERE lev = '".$recommend_lev."'";
				$configInfo = $this->db->exeSql($sql);
				$rateType = $configInfo[0]["lev_join_recommend_mileage_rate_type"];
				$rateInfo = explode(":",$configInfo[0]["lev_join_recommend_mileage_rate"]);
				$rate = $rateInfo[0];

				if ( $rate > 0 ) {
					//-> 지급타입이 lose(낙첨)이면 $loseCount가 1이상 되어야 지급.
					if ( $rateType == "lose" and $loseCount > 0 ) {
						$this->modifyMileageProcess($recommend_sn, $amount, "12", $bettingNo, $rate, '', "낙첨");
					} else if ( $rateType == "betting" ) {
					//-> 지급타입이 betting(배팅)이면 $loseCount와 상관없이 무작정 지급.
						$this->modifyMileageProcess($recommend_sn, $amount, "12", $bettingNo, $rate, '', "배팅");
					}
				}
			}			
		} //-> exit 1대 추천인 처리.

		//-> 2대 추천인 처리.
		if ( $recommend2_sn > 0 ) {
			$sql = "SELECT uid, mem_lev FROM tb_people WHERE mem_status = 'N' and sn = '".$recommend2_sn."'";
			$memberInfo2 = $this->db->exeSql($sql);
			if ( count((array)$memberInfo2[0]) > 0 ) {
				$recommend2_lev = $memberInfo2[0]["mem_lev"];

				//-> 2대 레벨에 맞는 마일리지 지급타입과 지급율(%)을 가져온다.
				$sql = "SELECT lev_join_recommend_mileage_rate_type, lev_join_recommend_mileage_rate FROM tb_level_config WHERE lev = '".$recommend2_lev."'";
				$configInfo = $this->db->exeSql($sql);
				$rateType = $configInfo[0]["lev_join_recommend_mileage_rate_type"];
				$rateInfo = explode(":",$configInfo[0]["lev_join_recommend_mileage_rate"]);
				$rate = $rateInfo[1];

				if ( $rate > 0 ) {
					//-> 지급타입이 lose(낙첨)이면 $loseCount가 1이상 되어야 지급.
					if ( $rateType == "lose" and $loseCount > 0 ) {
						$this->modifyMileageProcess($recommend2_sn, $amount, "12", $bettingNo, $rate, '', "낙첨");
					} else if ( $rateType == "betting" ) {
					//-> 지급타입이 betting(배팅)이면 $loseCount와 상관없이 무작정 지급.
						$this->modifyMileageProcess($recommend2_sn, $amount, "12", $bettingNo, $rate, '', "배팅");
					}
				}
			}
		} //-> exit 2대 추천인 처리.
	}

    //▶ 추천인 배팅 및 낙첨 마일리지
    function cancel_recommendFailedGameMileage($sn, $amount, $bettingNo, $loseCount)
    {
        $amount = -1 * $amount;

        //-> 1대, 2대 회원sn을 가져옴.
        $sql = "select recommend_sn, recommend2_sn from tb_join_recommend where member_sn = ".$sn;
        $recommendInfo = $this->db->exeSql($sql);
        $recommend_sn = $recommendInfo[0]["recommend_sn"];
        $recommend2_sn = $recommendInfo[0]["recommend2_sn"];

        //-> 1대 추천인 처리.
        if ( $recommend_sn > 0 ) {
            $sql = "SELECT uid, mem_lev FROM tb_people WHERE mem_status = 'N' and sn = '".$recommend_sn."'";
            $memberInfo = $this->db->exeSql($sql);
            if ( count((array)$memberInfo[0]) > 0 ) {
                $recommend_lev = $memberInfo[0]["mem_lev"];

                //-> 1대 레벨에 맞는 마일리지 지급타입과 지급율(%)을 가져온다.
                $sql = "SELECT lev_join_recommend_mileage_rate_type, lev_join_recommend_mileage_rate FROM tb_level_config WHERE lev = '".$recommend_lev."'";
                $configInfo = $this->db->exeSql($sql);
                $rateType = $configInfo[0]["lev_join_recommend_mileage_rate_type"];
                $rateInfo = explode(":",$configInfo[0]["lev_join_recommend_mileage_rate"]);
                $rate = $rateInfo[0];

                if ( $rate > 0 ) {
                    //-> 지급타입이 lose(낙첨)이면 $loseCount가 1이상 되어야 지급.
                    if ( $rateType == "lose" and $loseCount > 0 ) {
                        $this->modifyMileageProcess($recommend_sn, $amount, "12", $bettingNo, $rate, '', "낙첨");
                    } else if ( $rateType == "betting" ) {
                        //-> 지급타입이 betting(배팅)이면 $loseCount와 상관없이 무작정 지급.
                        $this->modifyMileageProcess($recommend_sn, $amount, "12", $bettingNo, $rate, '', "배팅");
                    }
                }
            }
        } //-> exit 1대 추천인 처리.

        //-> 2대 추천인 처리.
        if ( $recommend2_sn > 0 ) {
            $sql = "SELECT uid, mem_lev FROM tb_people WHERE mem_status = 'N' and sn = '".$recommend2_sn."'";
            $memberInfo2 = $this->db->exeSql($sql);
            if ( count((array)$memberInfo2[0]) > 0 ) {
                $recommend2_lev = $memberInfo2[0]["mem_lev"];

                //-> 2대 레벨에 맞는 마일리지 지급타입과 지급율(%)을 가져온다.
                $sql = "SELECT lev_join_recommend_mileage_rate_type, lev_join_recommend_mileage_rate FROM tb_level_config WHERE lev = '".$recommend2_lev."'";
                $configInfo = $this->db->exeSql($sql);
                $rateType = $configInfo[0]["lev_join_recommend_mileage_rate_type"];
                $rateInfo = explode(":",$configInfo[0]["lev_join_recommend_mileage_rate"]);
                $rate = $rateInfo[1];

                if ( $rate > 0 ) {
                    //-> 지급타입이 lose(낙첨)이면 $loseCount가 1이상 되어야 지급.
                    if ( $rateType == "lose" and $loseCount > 0 ) {
                        $this->modifyMileageProcess($recommend2_sn, $amount, "12", $bettingNo, $rate, '', "낙첨");
                    } else if ( $rateType == "betting" ) {
                        //-> 지급타입이 betting(배팅)이면 $loseCount와 상관없이 무작정 지급.
                        $this->modifyMileageProcess($recommend2_sn, $amount, "12", $bettingNo, $rate, '', "배팅");
                    }
                }
            }
        } //-> exit 2대 추천인 처리.
    }

	//-> 충전취소 (신청들어온 이력 취소)
	function chargeToCancel($sn) {
		$sql = "update tb_charge_log set state = 9 where sn = ".$sn;
		return $this->db->exeSql($sql);
	}

	//▶ 충전취소
	function chargeCancelProcess($sn)
	{
		$rs = $this->moneyModel->getChargeState($sn);
		if($rs!=1) return -1;
	
		$rs = $this->moneyModel->getChargeRow($sn);
		if($rs['sn']=='') return -1;
		if($rs['state']!=1) return -2;
		
		$memberSn 	= $rs['member_sn'];
		$amount		= $rs['agree_amount'];
	
		$before = $this->memberModel->getMemberField($memberSn, "g_money");
		$this->modifyMoneyProcess($memberSn, -$amount, '1',"충전취소");
		$after 	= $this->memberModel->getMemberField($memberSn, "g_money");
	
		$sql = "update ".$this->db_qz."charge_log 
				set agree_amount=0, before_money=".$after.", after_money=0, operdate=null, state=0
					where sn=".$sn;
				
		$rs = $this->db->exeSql($sql);
		
		return ($rs>0)? 1:0;
	}

	//-> 마지막 경기를 적특을 하게되면 해당 경기는 정산이 마무리가 안되서 기존 [경기기준]이 아닌 [배팅기준]으로 정산이 되는 프로세서.
	function bettingProcProcess($bettingNo) {
		$sql = "select * from tb_game_cart where betting_no = '{$bettingNo}'";
		$rs = $this->db->exeSql($sql);		
		$memberSn = $rs[0]['member_sn'];
		$specialCode = $rs[0]['last_special_code'];

		if ( !$bettingNo or !$memberSn ) return 0;
			
		$sql = "select a.*, c.sport_name from tb_game_betting a, tb_subchild b, tb_child c where a.sub_child_sn = b.sn and b.child_sn = c.sn and a.betting_no='".$bettingNo."'";
		$rsi = $this->db->exeSql($sql);
		
		$winCount = $loseCount = $cancelCount = $ingGameCount = $bonusGameCount = 0;
		$winRate = 1;
		$winMoney = 0;
		$total = count((array)$rsi);	//-> 경기총폴더수
			
		for ( $j = 0 ; $j < count((array)$rsi) ; $j++ ) {
			$betMoney = $rsi[$j]['bet_money'];
			$sportName = $rsi[$j]['sport_name'];

			if ( $rsi[$j]['result'] == 0 ) {
				++$ingGameCount;
			} else if ( $rsi[$j]['result'] == 1 ) {
				++$winCount;
				$winRate *= $rsi[$j]['select_rate'];
				if ( strlen($sportName) != strlen(str_replace("보너스","",$sportName)) ) {
					++$bonusGameCount;
				}
			} else if ( $rsi[$j]['result'] == 2 ) {
				++$loseCount;
			} else if ( $rsi[$j]['result'] == 4 ) {
				++$cancelCount;
				$winRate *= 1;
			}
		}
			
		//-> 모든게임종료 (최종정산시작)
		if ( $ingGameCount == 0 ) {
			//-> 낙첨
			if ( $loseCount > 0 ) {
				$sql = "update tb_game_cart set result = 2 ,operdate = now() where betting_no = '".$bettingNo."'";
				$rsi = $this->db->exeSql($sql);

				//-> 미니게임은 지급하지 않는다.
				if ( $specialCode < 5 ) {
					//-> 낙첨 마일리지는 미니게임은 제외하고 스포츠 1폴더 이상부터 지급
					if ( ($winCount + $loseCount - $bonusGameCount) > 1 ) {
						$this->modifyMileageProcess($memberSn, $betMoney, "4", $bettingNo);
					}
				}

			//-> 당첨
			} else if ( $winCount > 0 and ($winCount + $cancelCount) >= $total ) {
				$winRate  = bcmul($winRate,1,2);
				$winMoney = bcmul($betMoney,$winRate,0);
					
				$sql = "update tb_game_cart set result = 1, operdate = now(), result_money = '".$winMoney."' where betting_no = '".$bettingNo."'";
				$rsi = $this->db->exeSql($sql);						
				$this->modifyMoneyProcess($memberSn, $winMoney, 4, $bettingNo);
			}

			//-> 추천인 마일리지는 미니게임 제외, 스포츠 1폴더(이기거나 진거 합 2이상) 이상부터 지급
			if ( $specialCode < 3 ) {
				if ( ($winCount + $loseCount - $bonusGameCount) > 1 ) {
					//-> 추천인 낙첨 마일리지
					$this->recommendFailedGameMileage($memberSn, $betMoney, $bettingNo, $loseCount);
				}
			}
		} //-> if ( $ingGameCount == 0 ) {
		
		return 1;
	}

	//▶ [배당지급] - 결과에 따른 돈 지급
	function modifyResultMoneyProcess($bettingNo)
	{
		$sql = "SELECT a.*, c.sport_name FROM tb_game_betting a, tb_subchild b, tb_child c WHERE a.sub_child_sn = b.sn AND b.child_sn = c.sn AND a.betting_no='".$bettingNo."'";
		$rsi = $this->db->exeSql($sql);
		
		if(count((array)$rsi) > 0) {
			$memberSn = $rsi[0]['member_sn'];
			$specialCode = $rsi[0]['last_special_code'];
			$winCount = $loseCount = $cancelCount = $ingGameCount = $bonusGameCount = 0;
			$winRate = 1;
			$winMoney = 0;
			$total = count((array)$rsi);	//-> 경기총폴더수
			
			for ( $j = 0 ; $j < count((array)$rsi) ; $j++ ) {
				$betMoney = $rsi[$j]['bet_money'];
				$sportName = $rsi[$j]['sport_name'];

				if ( $rsi[$j]['result'] == 0 ) {
					++$ingGameCount;
				} else if ( $rsi[$j]['result'] == 1 ) {
					++$winCount;
					$winRate *= $rsi[$j]['select_rate'];
					if ( strlen($sportName) != strlen(str_replace("이벤트","",$sportName)) ) {
						++$bonusGameCount;
					}
				} else if ( $rsi[$j]['result'] == 2 ) {
					++$loseCount;
				} else if ( $rsi[$j]['result'] == 4 ) {
					++$cancelCount;
					$winRate *= 1;
				}
			}

			$winRate = round($winRate, 2);
			
			//모든게임종료
			if ( $ingGameCount == 0 ) {
				$sql = "select logo, uid, recommend_sn from ".$this->db_qz."people where sn=".$memberSn;
				$rsi = $this->db->exeSql($sql);					
				$logo = $rsi[0]['logo'];
				$strUserID = $rsi[0]['uid'];
				$recommend_sn = $rsi[0]['recommend_sn'];
					
				//모두 취소된 게임
				if ( $total == $cancelCount ) {
					$winRate  = bcmul($winRate,1,2);
					$winMoney = bcmul($betMoney,$winRate,0);
						
					$sql = "update ".$this->db_qz."game_cart set result=4, operdate=now(), result_money='".$winMoney."' where logo='".$logo."' and betting_no = '".$bettingNo."'";
					$rsi = $this->db->exeSql($sql);

					$nMode = 1;
					if ( $specialCode >= 5 ) {
						$nMode = 2;
					} 

					$sql = "INSERT INTO api_betting (strUserID, nStoreSn, nWinCash, nMode, strBetTime) VALUES ('".$strUserID."', '".$recommend_sn."', '".$winMoney."', '".$nMode."', NOW())";
					$this->db->exeSql($sql);	

					$this->modifyMoneyProcess($memberSn, $winMoney, 5, $bettingNo);

				//낙첨
				} else if( $loseCount > 0 ) {
					$sql = "update ".$this->db_qz."game_cart set result=2, operdate=now() where betting_no =".$bettingNo;
					$rsi = $this->db->exeSql($sql);

					//미니게임은 지급하지 않는다.
					if ( $specialCode < 5 ) {
						//-> 낙첨 마일리지는 미니게임은 제외하고 스포츠 1폴더 이상부터 지급
						if ( ($winCount + $loseCount - $bonusGameCount) > 1 ) {
							//낙첨 마일리지
							$this->modifyMileageProcess($memberSn, $betMoney, "4", $bettingNo);
						}
					}

				//당첨
				} else if( ($winCount + $cancelCount) >= $total) {
					$winRate  = bcmul($winRate, 1, 2);
					$winMoney = bcmul($betMoney, $winRate, 0);
						
					$sql = "update ".$this->db_qz."game_cart set result=1, operdate=now(), result_money='".$winMoney."' where logo='".$logo."' and betting_no = '".$bettingNo."'";
					$rsi = $this->db->exeSql($sql);	
					
					$nMode = 1;
					if ( $specialCode >= 5 ) {
						$nMode = 2;
					} 
					
					$sql = "INSERT INTO api_betting (strUserID, nStoreSn, nWinCash, nMode, strBetTime) VALUES ('".$strUserID."', '".$recommend_sn."', '".$winMoney."', '".$nMode."', NOW())";
					$this->db->exeSql($sql);	

					$this->modifyMoneyProcess($memberSn, $winMoney, 4, $bettingNo);

					//다폴더 보너스 계산
					/*
						if ( ($winCount - $bonusGameCount) > 2 ) {
							//-> 통합 다폴더 포인트 rate 가져오기.
							$folderCnt = $winCount - $bonusGameCount;
							$folderRate = $this->configModel->getPointConfigRow("folder_bouns".$folderCnt);
							$this->modifyMileageProcess($sn, $betMoney, "3", $bettingNo, $folderRate["folder_bouns".$folderCnt], $folderCnt);
						}
					*/
				}

				//-> 추천인 마일리지는 미니게임 제외, 스포츠 1폴더(이기거나 진거 합 2이상) 이상부터 지급
				if ( $specialCode < 5 ) {
					if ( ($winCount + $loseCount - $bonusGameCount) > 1 ) {
						//-> 추천인 낙첨 마일리지
						$this->recommendFailedGameMileage($memberSn, $betMoney, $bettingNo, $loseCount);
					}
				}

			} 
		}
	   	return 1;
	}
}
?>