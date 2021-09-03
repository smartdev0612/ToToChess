<?php

class GameModel extends Lemon_Model 
{
	//▶ 경기 상태 수정
	function modifyChildStaus($childSn, $state)
	{
		$sql = "select home_rate,away_rate from ".$this->db_qz."subchild 
							where child_sn in(".$childSn.")";
		$rs = $this->db->exeSql($sql);

		if(count((array)$rs) > 0)
		{
			$homeRate = $rs[0]["home_rate"];
			$drawRate = $rs[0]["away_rate"];
			if(is_null($homeRate)||$homeRate==""||is_null($drawRate)||$drawRate=="")
			{
				$msg = "배당입력을 하지 않은 게임이 존재합니다.먼저 배당을 입력하십시오";
				echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><script language='javascript'> alert('".$msg."'); opener.location.reload();self.close();</script>";

				exit();
			}
		}

		if($state==-1)
        {
            $sql = "update ".$this->db_qz."child set kubun = null where sn in (".$childSn.")";
        }
		else{
            $sql = "update ".$this->db_qz."child set kubun = '".$state."' where sn in (".$childSn.")";
        }

		$this->db->exeSql($sql);
	}

	//▶ 경기 상태 수정 (다기준)
	function modifyChildStausMulti($subchildSn, $state)
	{
		$sql = "select home_rate,away_rate from ".$this->db_qz."subchild_m 
							where sn in(".$subchildSn.")";
		$rs = $this->db->exeSql($sql);

		if(count((array)$rs) > 0)
		{
			$homeRate = $rs[0]["home_rate"];
			$drawRate = $rs[0]["away_rate"];
			if(is_null($homeRate)||$homeRate==""||is_null($drawRate)||$drawRate=="")
			{
				$msg = "배당입력을 하지 않은 게임이 존재합니다.먼저 배당을 입력하십시오";
				echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><script language='javascript'> alert('".$msg."'); opener.location.reload();self.close();</script>";

				exit();
			}
		}

		if($state==-1)
        {
            $sql = "UPDATE ".$this->db_qz."child_m a LEFT JOIN ".$this->db_qz."subchild_m b ON a.sn = b.child_sn SET b.kubun = null WHERE b.sn in (".$subchildSn.")";
        }
		else{
            $sql = "UPDATE ".$this->db_qz."child_m a LEFT JOIN ".$this->db_qz."subchild_m b ON a.sn = b.child_sn SET b.kubun = '".$state."' WHERE b.sn in (".$subchildSn.")";
        }

		$this->db->exeSql($sql);
	}


	function blockGame($childSn)
    {
        $sql = "select c.sport_name, c.home_team, c.away_team, l.name as league_name, s.home_rate, s.draw_rate, s.away_rate  from tb_child c, tb_subchild s, tb_league l 
							where c.league_sn=l.sn and s.child_sn= c.sn and c.sn in(".$childSn.")";
        $rs = $this->db->exeSql($sql);

        if(count((array)$rs) > 0)
        {
            foreach ( $rs as $key => $game )
            {
                $sql = "select count(*)  as cnt from tb_block_game
							where sport_name='".$game['sport_name']."' and home_team='".$game['home_team']."' and away_team='".$game['away_team']."' 
							and league_name='".$game['league_name']."' and home_rate='".$game['home_rate']."' and draw_rate='".$game['draw_rate']."'and away_rate='".$game['away_rate']."' ";
                $rs = $this->db->exeSql($sql);

                if($rs[0]['cnt'] == 0)
                {
                    $sql = "insert into ".$this->db_qz."block_game(sport_name,home_team,away_team,league_name, home_rate, draw_rate, away_rate)values";
                    $sql.= "('".$game['sport_name']."','".$game['home_team']."','".$game['away_team']."','".$game['league_name']."','".$game['home_rate']."','".$game['draw_rate']."','".$game['away_rate']."')";
                    $this->db->exeSql($sql);
                }
            }
        }
    }
	// 다기준
	function blockGameMulti($subchildSn)
    {
        $sql = "select c.sport_name, c.home_team, c.away_team, l.name as league_name, s.home_rate, s.draw_rate, s.away_rate  from tb_child_m c, tb_subchild_m s, tb_league l 
							where c.league_sn=l.sn and s.child_sn= c.sn and s.sn in(".$subchildSn.")";
        $rs = $this->db->exeSql($sql);

        if(count((array)$rs) > 0)
        {
            foreach ( $rs as $key => $game )
            {
                $sql = "select count(*)  as cnt from tb_block_game
							where sport_name='".$game['sport_name']."' and home_team='".$game['home_team']."' and away_team='".$game['away_team']."' 
							and league_name='".$game['league_name']."' and home_rate='".$game['home_rate']."' and draw_rate='".$game['draw_rate']."'and away_rate='".$game['away_rate']."' ";
                $rs = $this->db->exeSql($sql);

                if($rs[0]['cnt'] == 0)
                {
                    $sql = "insert into ".$this->db_qz."block_game(sport_name,home_team,away_team,league_name, home_rate, draw_rate, away_rate)values";
                    $sql.= "('".$game['sport_name']."','".$game['home_team']."','".$game['away_team']."','".$game['league_name']."','".$game['home_rate']."','".$game['draw_rate']."','".$game['away_rate']."')";
                    $this->db->exeSql($sql);
                }
            }
        }
    }

	//-> 기존배당에 NEW배당 업데이트 (홈,무,어웨이 모두)
	function modifyChildNewRate($childSn) {
		$sql = "update ".$this->db_qz."subchild set home_rate = if(new_home_rate is null,home_rate,new_home_rate), 
													draw_rate = if(new_draw_rate is null,draw_rate,new_draw_rate), 
													away_rate = if(new_away_rate is null,away_rate,new_away_rate) where update_enable = 1 and child_sn in(".$childSn.")";
		$this->db->exeSql($sql);
	}

	//-> 기존배당에 NEW배당 업데이트 (홈,무,어웨이 모두) (다기준)
	function modifyChildNewRateMulti($subchildSn) {
		$sql = "update ".$this->db_qz."subchild_m set home_rate = if(new_home_rate is null,home_rate,new_home_rate), 
													  draw_rate = if(new_draw_rate is null,draw_rate,new_draw_rate), 
													  away_rate = if(new_away_rate is null,away_rate,new_away_rate) where update_enable = 1 and sn in(".$subchildSn.")";
		$this->db->exeSql($sql);
	}

    function gameRateList($childSn, $new_home_rate, $new_away_rate)
    {
        $sql = "select c.sport_name, c.home_team, c.away_team, l.name as league_name, s.home_rate, s.draw_rate, s.away_rate  
              from tb_child c, tb_subchild s, tb_league l 
							where c.league_sn=l.sn and s.child_sn= c.sn and c.sn in(".$childSn.")";
        $rs = $this->db->exeSql($sql);

        if(count((array)$rs) > 0)
        {
            foreach ( $rs as $key => $game )
            {
                $sql = "select sn from tb_game_rate
							where sport_name='".$game['sport_name']."' and home_team='".$game['home_team']."' and away_team='".$game['away_team']."' 
							and league_name='".$game['league_name']."' and home_rate='".$game['home_rate']."' and draw_rate='".$game['draw_rate']."'and away_rate='".$game['away_rate']."' ";
                $rs = $this->db->exeSql($sql);

                if(count((array)$rs) == 0)
                {
                    $sql = "insert into ".$this->db_qz."game_rate(sport_name,home_team,away_team,league_name, home_rate, draw_rate, away_rate, new_home_rate, new_away_rate)values";
                    $sql.= "('".$game['sport_name']."','".$game['home_team']."','".$game['away_team']."','".$game['league_name'].
                             "','".$game['home_rate']."','".$game['draw_rate']."','".$game['away_rate']."','".$new_home_rate."','".$new_away_rate."')";
                    $this->db->exeSql($sql);
                } else {
                    $sql = "update ".$this->db_qz."game_rate set new_home_rate = ".$new_home_rate.", new_away_rate = ".$new_away_rate." 
			              where sn in(".$rs[0]['sn'].")";

                    $this->db->exeSql($sql);
                }
            }
        }
    }

    function modifyChildNewRate2($childSn, $new_home_rate, $new_away_rate) {
        $sql = "update ".$this->db_qz."subchild set home_rate = ".$new_home_rate.", away_rate = ".$new_away_rate." 
			    where child_sn in(".$childSn.")";
        $this->db->exeSql($sql);
    }

	function getGameInfo($leagueUid, $homeTeamName, $awayTeamName, $gameTypeCode, $gameSpecialCode)
    {
		$hDate = date("Y-m-d H:i:s",time());
        $sql = "SELECT *, a.sn as c_sn, b.sn as subc_sn FROM tb_child a, tb_subchild b
								WHERE a.sn = b.child_sn and a.league_sn = '".$leagueUid."' and a.home_team = '".$homeTeamName."' and a.away_team = '".$awayTeamName."' and 
											a.type = '".$gameTypeCode."' and a.special = '".$gameSpecialCode."' and a.parsing_site = 'S' and CONCAT(a.gameDate,' ',a.gameHour,':',a.gameTime,':00') > '".$hDate."'";

        return $this->db->exeSql($sql);
    }

	function getGameByBettingNo($betting_no) {
		$sql = "SELECT
					a.regdate,
					a.last_special_code,
					b.live,
					d.gameDate,
					d.gameHour,
					d.gameTime
				FROM
					tb_total_cart a
					INNER JOIN tb_total_betting b
					ON a.betting_no = b.betting_no
					LEFT JOIN tb_subchild c
					ON b.`sub_child_sn` = c.sn
					LEFT JOIN tb_child d
					ON c.child_sn = d.sn
				WHERE a.betting_no = '{$betting_no}'
				ORDER BY d.gameDate, d.gameHour, d.gameTime ";
		
		return $this->db->exeSql($sql);
	}

	//▶ 경기 결과 취소
	function cancelResultChild($child_sn, $s_type = 0)
	{
		$cModel  = Lemon_Instance::getObject("CommonModel",true);
		$pModel  = Lemon_Instance::getObject("ProcessModel",true);
		
		$array = array();
		
		if($s_type == 2)
		{
			$sql = "select * from ".$this->db_qz."child_m 
					where sn ='". $child_sn ."'";
		} else {
			$sql = "select * from ".$this->db_qz."child 
					where sn ='". $child_sn ."'";
		}
		
		$rs = $this->db->exeSql($sql);	
		if(count((array)$rs) > 0)
		{			
			$home_score = $rs[0]["home_score"];
			$away_score = $rs[0]["away_score"];
		}
		
		if (is_null($home_score) || is_null($away_score))
		{
			return -1;
		}
		else
		{
			$sub_sn = $this->getSubChildField($child_sn, "sn");
			if($s_type == 2) {
				$pModel->rollbackMultiGameProcess($child_sn, $sub_sn);
			} else {
				$pModel->rollbackGameProcess($child_sn);
			}
			
			return 1;
		}	
	} 
	
	//▶ 경기 배당수정
	function modifyChildRate($child_sn,$bettype,$home_rate,$draw_rate,$away_rate)
	{
		$array = array();
		$sql = "select child_sn from ".$this->db_qz."subchild_log 
							where child_sn=". $child_sn ." and betting_type=". $bettype;
		$rs = $this->db->exeSql($sql);									
		if( count((array)$rs) <= 0 )
		{
			$sql = "select home_rate,draw_rate,away_rate 
								from ".$this->db_qz."subchild 
									where child_sn=". $child_sn ." and betting_type=". $bettype;
			$rs = $this->db->exeSql($sql);					
			if( count((array)$rs) > 0 )
			{
				$array['home_rate'] = $rs[0]['home_rate'];
				$array['draw_rate'] = $rs[0]['draw_rate'];
				$array['away_rate'] = $rs[0]['away_rate'];
				
				$sql = "insert into ".$this->db_qz."subchild_log(child_sn,betting_type,home_rate,draw_rate,away_rate,regdate)
									values('".$child_sn."','".$bettype."','".$array['home_rate']."','".$array['draw_rate']."','".$array['away_rate']."',now())";
				$this->db->exeSql($sql);										
			}		
		}
		
		$sql = "insert into ".$this->db_qz."subchild_log(child_sn,betting_type,home_rate,draw_rate,away_rate,regdate)values";
		$sql.= "('".$child_sn."','".$bettype."','".$home_rate."','".$draw_rate."','".$away_rate."',now())";
		$this->db->exeSql($sql);	
		
		$sql = "update ".$this->db_qz."subchild SET "; 	
		$sql = $sql . "home_rate='".$home_rate."',"; 
		$sql = $sql . "draw_rate='".$draw_rate."',";
		$sql = $sql . "away_rate='".$away_rate."',";
		$sql = $sql . "update_enable='0'";
		$sql = $sql . " where child_sn=".$child_sn."";
		$sql = $sql . " and betting_type=".$bettype."";
		$this->db->exeSql($sql);

		//-> 배당변경 로그
		$hDate = date("Y-m-d H:i:s",time());
		$fileName = "RateModify_".date("Ymd",time()).".log";
		$logFile = @fopen("/home/gadget/www_gadget_1.com/Lemonade/_logs/system/".$fileName,"a");
		if ( $logFile ) {
			$ipInfo = "(".$_SERVER["HTTP_X_REAL_IP"].") (".$_SERVER["REMOTE_ADDR"].") (".$_SERVER["HTTP_INCAP_CLIENT_IP"].") (".$_SERVER["HTTP_X_FORWARDED_FOR"].")";
			@fwrite($logFile, "SUB_CHILD_SN[{$child_sn}] = HOME[{$home_rate}], DRAW[{$draw_rate}], AWAY[{$away_rate}], IPINFO[{$ipInfo}]\n");
			@fclose($logFile);
		}			
	}

	//▶ 경기 배당수정 (다기준)
	function modifySubChildRate($child_sn, $subchild_sn, $sub_idx, $bettype,$home_rate,$draw_rate,$away_rate)
	{
		$array = array();
		$sql = "select child_sn from ".$this->db_qz."subchild_m_log 
							where child_sn=". $child_sn ." and betting_type=". $bettype;
		$rs = $this->db->exeSql($sql);									
		if( count((array)$rs) <= 0 )
		{
			$sql = "select home_rate,draw_rate,away_rate 
								from ".$this->db_qz."subchild_m 
									where sn=". $subchild_sn ." and betting_type=". $bettype;
			$rs = $this->db->exeSql($sql);					
			if( count((array)$rs) > 0 )
			{
				$array['home_rate'] = $rs[0]['home_rate'];
				$array['draw_rate'] = $rs[0]['draw_rate'];
				$array['away_rate'] = $rs[0]['away_rate'];
				
				$sql = "insert into ".$this->db_qz."subchild_m_log(child_sn, betting_type, sub_idx, home_rate, draw_rate, away_rate, regdate)
									values('".$child_sn."','".$bettype."','".$sub_idx."','".$array['home_rate']."','".$array['draw_rate']."','".$array['away_rate']."',now())";
				$this->db->exeSql($sql);										
			}		
		}
		
		$sql = "insert into ".$this->db_qz."subchild_m_log(child_sn,betting_type, sub_idx, home_rate,draw_rate,away_rate,regdate)values";
		$sql.= "('".$child_sn."','".$bettype."','".$sub_idx."','".$home_rate."','".$draw_rate."','".$away_rate."',now())";
		$this->db->exeSql($sql);	
		
		$sql = "update ".$this->db_qz."subchild_m SET "; 	
		$sql = $sql . "home_rate='".$home_rate."',"; 
		$sql = $sql . "draw_rate='".$draw_rate."',";
		$sql = $sql . "away_rate='".$away_rate."',";
		$sql = $sql . "update_enable='0'";
		$sql = $sql . " where sn=".$subchild_sn;
		$this->db->exeSql($sql);

		//-> 배당변경 로그
		$hDate = date("Y-m-d H:i:s",time());
		$fileName = "RateModify_".date("Ymd",time()).".log";
		$logFile = @fopen("/home/gadget/www_gadget_o2_bet.com/Lemonade/_logs/system/".$fileName,"a");
		if ( $logFile ) {
			$ipInfo = "(".$_SERVER["HTTP_X_REAL_IP"].") (".$_SERVER["REMOTE_ADDR"].") (".$_SERVER["HTTP_INCAP_CLIENT_IP"].") (".$_SERVER["HTTP_X_FORWARDED_FOR"].")";
			@fwrite($logFile, "SUB_CHILD_SN[{$subchild_sn}] = HOME[{$home_rate}], DRAW[{$draw_rate}], AWAY[{$away_rate}], IPINFO[{$ipInfo}]\n");
			@fclose($logFile);
		}			
	}
	
	function modifyChildRate_Date($child_sn,$gameDate,$gameHour,$gameTime)
	{
		$sql = "update ".$this->db_qz."child SET "; 	
		$sql = $sql . "gameDate='".$gameDate."',"; 
		$sql = $sql . "gameHour='".$gameHour."',";
		$sql = $sql . "gameTime='".$gameTime."'";
		$sql = $sql . " where sn=".$child_sn."";
		$this->db->exeSql($sql);
		
		$sql = "update tb_child a, tb_subchild b set b.update_enable = '0' where a.sn = b.child_sn and a.sn = '{$child_sn}'";
		$this->db->exeSql($sql);
	}

	// 다기준
	function modifyChildRateMulti_Date($subchild_sn,$gameDate,$gameHour,$gameTime)
	{
		$sql = "UPDATE ".$this->db_qz."child_m a LEFT JOIN ".$this->db_qz."subchild_m b ON a.sn = b.child_sn SET "; 	
		$sql = $sql . "a.gameDate='".$gameDate."',"; 
		$sql = $sql . "a.gameHour='".$gameHour."',";
		$sql = $sql . "a.gameTime='".$gameTime."'";
		$sql = $sql . " where b.sn=".$subchild_sn."";
		$this->db->exeSql($sql);
		
		$sql = "update tb_child_m a, tb_subchild_m b set b.update_enable = '0' where a.sn = b.child_sn and b.sn = '{$subchild_sn}'";
		$this->db->exeSql($sql);
	}
	
	//▶ 서브차일드 삭제
	function delSubChild($sn)
	{
		$sql ="delete from ".$this->db_qz."subchild where child_sn = '".$sn."'";
						
		return $this->db->exeSql($sql);				
	}
	
	//▶ 차일드 삭제
	function delChild($sn)
	{
		$sql = "select * from ".$this->db_qz."child a, ".$this->db_qz."subchild b, ".$this->db_qz."total_betting c where a.sn=b.child_sn and b.sn=c.sub_child_sn and a.sn in (".$sn.")";
		$rs = $this->db->exeSql($sql);
		
		if(count((array)$rs)>0)
		{
			throw new Lemon_ScriptException("배팅내역이 있는 경기입니다. 다시한번 확인 하세요.");
			exit;
		}
		
		//-> 삭제하지 않고 뷰 숨김 처리로 변경.
		//$sql ="delete from ".$this->db_qz."Child where sn in (".$sn.")";
		$sql = "update ".$this->db_qz."child set view_flag = 0 where sn in (".$sn.")";
		$this->db->exeSql($sql);

		/* 뷰 숨김 처리 하기 때문에 subchild 삭제 할 필요 없음.
		$arr_sn	= explode(',',$sn);			
		for( $i=0; $i<count((array)$arr_sn); ++$i )
		{
			$sql ="delete from ".$this->db_qz."subchild where child_sn = (".$arr_sn[$i].")";		
			$this->db->exeSql($sql);	
		}
		*/
	}

	//▶ 서브차일드 삭제 (다기준)
	function delSubChildMulti($sn)
	{
		$sql = "select * from ".$this->db_qz."child_m a, ".$this->db_qz."subchild_m b, ".$this->db_qz."total_betting c where a.sn=b.child_sn and b.sn=c.sub_child_sn and b.sn in (".$sn.")";
		$rs = $this->db->exeSql($sql);
		
		if(count((array)$rs)>0)
		{
			throw new Lemon_ScriptException("배팅내역이 있는 경기입니다. 다시한번 확인 하세요.");
			exit;
		}
		
		//-> 삭제하지 않고 뷰 숨김 처리로 변경.
		//$sql ="delete from ".$this->db_qz."Child where sn in (".$sn.")";
		$sql = "update ".$this->db_qz."subchild_m set view_flag = 0, user_view_flag = 0 where sn in (".$sn.")";
		$this->db->exeSql($sql);

		/* 뷰 숨김 처리 하기 때문에 subchild 삭제 할 필요 없음.
		$arr_sn	= explode(',',$sn);			
		for( $i=0; $i<count((array)$arr_sn); ++$i )
		{
			$sql ="delete from ".$this->db_qz."subchild where child_sn = (".$arr_sn[$i].")";		
			$this->db->exeSql($sql);	
		}
		*/
	}

    function delChildDB($sn)
    {
        $sql = "select * from ".$this->db_qz."child a, ".$this->db_qz."subchild b, ".$this->db_qz."total_betting c where a.sn=b.child_sn and b.sn=c.sub_child_sn and a.sn in (".$sn.")";
        $rs = $this->db->exeSql($sql);

        if(count((array)$rs)>0)
        {
            throw new Lemon_ScriptException("배팅내역이 있는 경기입니다. 다시한번 확인 하세요.");
            exit;
        }

        //-> 삭제하지 않고 뷰 숨김 처리로 변경.
        $sql ="delete from ".$this->db_qz."child where sn in (".$sn.")";

        $arr_sn	= explode(',',$sn);
        for( $i=0; $i<count((array)$arr_sn); ++$i )
        {
            $sql ="delete from ".$this->db_qz."subchild where child_sn = (".$arr_sn[$i].")";
            $this->db->exeSql($sql);
        }
    }
	
	function delSubChildDB($sn)
    {
        $sql = "select * from ".$this->db_qz."child_m a, ".$this->db_qz."subchild_m b, ".$this->db_qz."total_betting c where a.sn=b.child_sn and b.sn=c.sub_child_sn and b.sn in (".$sn.")";
        $rs = $this->db->exeSql($sql);

        if(count((array)$rs)>0)
        {
            throw new Lemon_ScriptException("배팅내역이 있는 경기입니다. 다시한번 확인 하세요.");
            exit;
        }

        //-> tb_child_m, tb_subchild_m 에서 완전삭제.
		$sql = "select child_sn from ".$this->db_qz."subchild_m where sn=".$sn;
        $rs = $this->db->exeSql($sql);
		if(count((array)$rs) > 0)
			$child_sn = $rs[0]["child_sn"];
		else 
			$child_sn = 0;

		$sql ="delete from ".$this->db_qz."child_m where sn in (".$child_sn.")";
		$this->db->exeSql($sql);

        $sql ="delete from ".$this->db_qz."subchild_m where sn in (".$sn.")";
		$this->db->exeSql($sql);

    }
	
	//▶ 게임종류 변경
	function modifyGameType($childSn, $specialType, $gameType)
	{
		$gameModel 	= Lemon_Instance::getObject("GameModel",true);
		
		$where 	= " sn=".$childSn;
		$set  	= "type=".$gameType.",";
		$set 	 .= "special = " .$specialType;
		$gameModel->modifyChild($set, $where);
		
		$where 	= "";
		$set 		= "";
		$set 		= "betting_type = ".$gameType;
					
		$where = " child_sn=".$childSn;
		$gameModel->modifySubChild($set, $where);
		
		$sql = "select sn 
						from ".$this->db_qz."subchild
						where child_sn=".$childSn;
		$rs = $this->db->exeSql($sql);
		$subChildSn = $rs[0]["sn"];
		
		$sql = "update ".$this->db_qz."total_betting
						set game_type=".$gameType."
						where sub_child_sn=".$subChildSn;
		return $this->db->exeSql($sql);
	}

	//▶ 게임종류 변경 (다기준)
	function modifyGameTypeMulti($childSn, $subchild_sn, $specialType, $gameType)
	{
		$gameModel 	= Lemon_Instance::getObject("GameModel",true);
		
		$where 	= "";
		$set 		= "";
		$set 		= "betting_type = ".$gameType;
					
		$where = " sn=".$subchild_sn;
		$gameModel->modifySubChildMulti($set, $where);
		
		$sql = "select sn 
						from ".$this->db_qz."subchild_m
						where sn=".$subchild_sn;
		$rs = $this->db->exeSql($sql);
		$subChildSn = $rs[0]["sn"];
		
		$sql = "update ".$this->db_qz."total_betting
						set game_type=".$gameType."
						where sub_child_sn=".$subChildSn;
		return $this->db->exeSql($sql);
	}
	
	//▶ 서브차일드 수정
	function modifySubChild($addset, $addwhere)
	{
		$set = " set ".$addset;
		if($addwhere!=''){$where=" where ".$addwhere;}
		
		$sql = "update ".$this->db_qz."subchild ".$set.$where;

		//-> 서브차일드 수정 로그
		$hDate = date("Y-m-d H:i:s",time());
		$fileName = "subChildModify_".date("Ymd",time()).".log";
		$logFile = @fopen("C:\\xampp\\htdocs\\gadget\\www_gadget_o2_lsports.com\\Lemonade\\_logs\\system\\".$fileName,"a");
		if ( $logFile ) {
			@fwrite($logFile, $sql."\n\n");
			@fclose($logFile);
		}	

		return $this->db->exeSql($sql);
	}

	//▶ 서브차일드 수정 (다기준)
	function modifySubChildMulti($addset, $addwhere)
	{
		$set = " set ".$addset;
		if($addwhere!=''){$where=" where ".$addwhere;}
		
		$sql = "update ".$this->db_qz."subchild_m ".$set.$where;

		//-> 서브차일드 수정 로그
		$hDate = date("Y-m-d H:i:s",time());
		$fileName = "subChildModify_".date("Ymd",time()).".log";
		$logFile = @fopen("/home/gadget/www_gadget_1.com/Lemonade/_logs/system/".$fileName,"a");
		if ( $logFile ) {
			@fwrite($logFile, $sql."\n\n");
			@fclose($logFile);
		}	

		return $this->db->exeSql($sql);
	}

    //▶ 서브차일드 수정
    function modifyGameRateInfo($addset, $addwhere)
    {
        $set = " set ".$addset;
        if($addwhere!=''){$where=" where ".$addwhere;}

        $sql = "update ".$this->db_qz."game_rate ".$set.$where;

        return $this->db->exeSql($sql);
    }

    function deleteGameRateInfo($where)
    {
        $sql = "delete from ".$this->db_qz."game_rate where ".$where;
        return $this->db->exeSql($sql);
    }

    //-> 홈, 무, 어웨이 배당 가져오기.
	function getRateInfo($sn) {
		$sql = "select b.home_rate, b.draw_rate, b.away_rate from tb_child a, tb_subchild b where a.sn = b.child_sn and a.sn = '{$sn}'";
		return $this->db->exeSql($sql);
	}

	//▶ 서브차일드 목록
	function getSubChildRow($sn, $field='*', $addWhere='')
	{
		$where = " child_sn=".$sn;		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		return $this->getRow($field, $this->db_qz.'subchild', $where);
	}

	function getSubChildRowBySn($sn)
	{
		$sql = "select * from tb_subchild where sn = " . $sn;
		$rs = [];
		$rs = $this->db->exeSql($sql);
		if(count((array)$rs) > 0)
			return $rs[0];

		return $rs;
	}


	//▶ 서브차일드 목록 (다기준)
	function getSubChildRowMulti($sn, $field='*', $addWhere='')
	{
		$where = " sn=".$sn;		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		return $this->getRow($field, $this->db_qz.'subchild_m', $where);
	}
	
	//▶ 서브차일드 목록
	function getSubChildField($sn, $field, $addWhere='')
	{
		$where = " child_sn=".$sn;
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		$rs = $this->getRow($field, $this->db_qz.'subchild', $where);
		
		return $rs[$field];
	}
	
	//▶ 서브차일드 목록
	function getSubChildRows($sn, $field='*', $addWhere='')
	{
		$where = " child_sn=".$sn;
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		return $this->getRows($field, $this->db_qz.'subchild', $where);
	}

	//▶ 서브차일드 목록 (다기준)
	function getSubChildRowsMulti($sn, $field='*', $addWhere='')
	{
		$where = " sn=".$sn;
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		return $this->getRows($field, $this->db_qz.'subchild_m', $where);
	}
	
	//▶ 게임종류만 틀리고 동일한 게임 목록
	function getSameChild($gameDate, $gameHour, $gameTime, $leagueSn, $homeTeam, $awayTeam)
	{
		$sql = "select sn from ".$this->db_qz."child 
						where gameDate='".$gameDate."' and gameHour='".$gameHour."' and gameTime='".$gameTime."' and 
						league_sn=".$leagueSn." and home_team='".$homeTeam."' and away_team='".$awayTeam."'";
						
		return $this->db->exeSql($sql);
	}
	
	//▶ 경기 수정
	function modifyChild($addset,$addwhere='')
	{
		$set = " set ".$addset;
		$where = "";
		if($addwhere!='') {$where .=' where '.$addwhere;}		
	
		$sql = "update ".$this->db_qz."child ".$set.$where;
		return $this->db->exeSql($sql);
	}

	//▶ 경기 수정 (다기준)
	function modifyChildMulti($addset, $addwhere='')
	{
		$set = " set ".$addset;
		$where = "";
		if($addwhere!='') {$where .= ' where '.$addwhere;}		
	
		$sql = "update ".$this->db_qz."child_m a LEFT JOIN ".$this->db_qz."subchild_m b on a.sn = b.child_sn ".$set.$where;
		return $this->db->exeSql($sql);
	}
	
	//▶ 경기 추가
	function addChild($parentSn = 0, $category = "", $leagueSn = 0, $homeTeam = "", $awayTeam = "", $gameDate = "", $gameHour = "", $gameTime = "", $notice = "", $kubun = 0, $type = 0, $special = 0, $homeRate = 0.00, $drawRate = 0.00, $awayRate = 0.00, $is_specified_special='0', $league_img = "")
	{
		$sql = "insert into ".$this->db_qz."child("; 
		$sql = $sql ." parent_sn, sport_name, league_sn, home_team, away_team," ;
		if($category == "이벤트") {
			$sql = $sql ." gameDate, gameHour, gameTime, notice, kubun, type, special, league_img, is_specified_special, win_team)";
		} else {
			$sql = $sql ." gameDate, gameHour, gameTime, notice, kubun, type, special, league_img, is_specified_special)";
		}
		$sql = $sql . " values("  	;
		$sql = $sql . "'" . $parentSn . "','". $category ."',";
		$sql = $sql . "'" . $leagueSn . "',";
		$sql = $sql . "'" . $homeTeam . "',";
		$sql = $sql . "'" . $awayTeam . "',";
		$sql = $sql . "'" . $gameDate . "',";
		$sql = $sql . "'" . $gameHour . "',";
		$sql = $sql . "'" . $gameTime . "',";
		$sql = $sql . "'" . $notice . "',";
		// if($isUpload == 'null') $sql = $sql. "null,";
		// else $sql = $sql . "'".$isUpload. "',";
		$sql = $sql . "'" . $kubun . "',";	
		$sql = $sql . "'" . $type . "',";
		$sql = $sql . "'" . $special . "',";
		$sql = $sql . "'" . $league_img . "',";
		if($category == "이벤트") {
			$sql = $sql . "'" . $is_specified_special . "','Home')";
		} else {
			$sql = $sql . "'" . $is_specified_special . "')";
		}
		
		$childSn = $this->db->exeSql($sql);	
		
		if($childSn <= 0)
		{
			return 0;
		}
		
		if($category == "이벤트") {
			$sql = "insert into ".$this->db_qz."subchild(child_sn,betting_type,home_rate,draw_rate,away_rate,win)
					values('".$childSn."','".$type."','".floatval($homeRate)."','".floatval($drawRate)."','".floatval($awayRate)."','1')";
		} else {
			$sql = "insert into ".$this->db_qz."subchild(child_sn,betting_type,home_rate,draw_rate,away_rate)
					values('".$childSn."','".$type."','".floatval($homeRate)."','".floatval($drawRate)."','".floatval($awayRate)."')";
		}
				
		return $this->db->exeSql($sql);
	}

	//▶ 경기 추가
	function addChildMulti($parentSn = 0, $category = "", $leagueSn = 0, $homeTeam = "", $awayTeam = "",$gameDate = "",$gameHour = "",$gameTime = "", $notice = "", $isUpload = 0, $type = 0, $special = 0, $homeRate = 0.00, $drawRate = 0.00, $awayRate = 0.00, $is_specified_special='0')
	{
		$sql = "insert into ".$this->db_qz."child_m("; 
		$sql = $sql ." parent_sn, sport_name, league_sn, home_team, away_team," ;
		if($category == "이벤트") {
			$sql = $sql ." gameDate, gameHour, gameTime, notice, special, is_specified_special, win_team)";
		}  else {
			$sql = $sql ." gameDate, gameHour, gameTime, notice, special, is_specified_special)";
		}
		$sql = $sql . " values("  	;
		$sql = $sql . "'" . $parentSn . "','". $category ."',";
		$sql = $sql . "'" . $leagueSn . "',";
		$sql = $sql . "'" . $homeTeam . "',";
		$sql = $sql . "'" . $awayTeam . "',";
		$sql = $sql . "'" . $gameDate . "',";
		$sql = $sql . "'" . $gameHour . "',";
		$sql = $sql . "'" . $gameTime . "',";
		$sql = $sql . "'" . $notice . "',";
		$sql = $sql . "'" . $special . "',";
		if($category == "이벤트") {
			$sql = $sql . "'" . $is_specified_special . "','Home')";
		} else {
			$sql = $sql . "'" . $is_specified_special . "')";
		}
		
		$childSn = $this->db->exeSql($sql);	
		
		if($childSn <= 0)
		{
			return 0;
		}
		
		if($category == "이벤트") {
			$sql = "insert into ".$this->db_qz."subchild_m (child_sn, betting_type,  home_rate, draw_rate, away_rate, kubun, sub_idx, view_flag, user_view_flag, win )
					values('".$childSn."','".$type."','".$homeRate."','".$drawRate."','".$awayRate."','0', '1', '1', '1', '1')";
		} else {
			$sql = "insert into ".$this->db_qz."subchild_m (child_sn, betting_type, home_rate, draw_rate, away_rate, kubun, sub_idx, view_flag, user_view_flag )
					values('".$childSn."','".$type."','".$homeRate."','".$drawRate."','".$awayRate."','0', '1', '1', '1')";
		}
		echo $sql;
		exit;
				
		return $this->db->exeSql($sql);
	}

    function addChild_with_parsing_type($parentSn,$category,$leagueSn,$homeTeam,$awayTeam,$gameDate,$gameHour,$gameTime,$notice,$isUpload,$type,$special,$homeRate,$drawRate,$awayRate, $parsing_site_type, $is_specified_special='0')
    {
        $sql = "insert into ".$this->db_qz."child(";
        $sql = $sql ." parent_sn, sport_name, league_sn, home_team, away_team," ;
        $sql = $sql ." gameDate, gameHour, gameTime, notice, kubun, type, special, is_specified_special, parsing_site)";
        $sql = $sql . " values("  	;
        $sql = $sql . "'" . $parentSn . "','". $category ."',";
        $sql = $sql . "'" . $leagueSn . "',";
        $sql = $sql . "'" . $homeTeam . "',";
        $sql = $sql . "'" . $awayTeam . "',";
        $sql = $sql . "'" . $gameDate . "',";
        $sql = $sql . "'" . $gameHour . "',";
        $sql = $sql . "'" . $gameTime . "',";
        $sql = $sql . "'" . $notice . "',";
        if($isUpload == 'null') $sql = $sql. "null,";
        else $sql = $sql . "'".$isUpload. "',";

        $sql = $sql . "'" . $type . "',";
        $sql = $sql . "'" . $special . "',";
        $sql = $sql . "'" . $is_specified_special . "',";
        $sql = $sql . "'" . $parsing_site_type . "')";

        $childSn = $this->db->exeSql($sql);

        if($childSn <= 0)
        {
            return 0;
        }

        $sql = "insert into ".$this->db_qz."subchild(child_sn,betting_type,home_rate,draw_rate,away_rate)
				values('".$childSn."','".$type."','".$homeRate."','".$drawRate."','".$awayRate."')";

        return $this->db->exeSql($sql);
    }


    //▶ 게임 총합
    public function getGameRateListTotal( $category='', $leagueName, $homeTeam='', $awayTeam='')
    {
        $where = "1=1";

        if($category!='')
            $where.=" and a.sport_name='".$category."'";

        if($leagueName!='')
            $where.=" and a.league_name like('%".$leagueName."%')";

        if($homeTeam!='')
            $where.=" and a.home_team like('%".$homeTeam."%')";

        if($awayTeam!='')
            $where.=" and a.away_team like('%".$awayTeam."%')";

        $sql = "select count(*) as cnt
							from ".$this->db_qz."game_rate a
							where ".$where;

        $rs = $this->db->exeSql($sql);

        $returnData['cnt'] = $rs[0]['cnt'];
        return $returnData;
    }

    public function getGameRateList($page, $page_size, $category='', $leagueName, $homeTeam='', $awayTeam='')
    {
        $sort='asc';

        $where = " 1=1";

        if($category!='')
            $where.=" and a.sport_name='".$category."'";

        if($leagueName!='')
            $where.=" and a.league_name like('%".$leagueName."%')";

        if($homeTeam!='')
            $where.=" and a.home_team like('%".$homeTeam."%')";

        if($awayTeam!='')
            $where.=" and a.away_team like('%".$awayTeam."%')";


        if($page_size > 0)
            $limit = "limit ".$page.",".$page_size;

        $sql = "select *
				from ".$this->db_qz."game_rate a
				where ".$where."
				order by league_name, a.home_team, a.sn asc " .$limit;
        return $this->db->exeSql($sql);
    }

	//▶ 게임 총합
	public function getListTotal($state=''/*kubun*/, $category='', $gameType='', $specialType='', $beginDate='', $endDate='', $minBettingMoney='', $leagueSn='', $homeTeam='', $awayTeam='', $bettingEnable='', $parsingType='ALL', $modifyFlag='')
	{
		if ( $parsingType != "ALL" ) $where=" and a.parsing_site = '".$parsingType."'";
		
		if($state!='') 
		{
			if($state==1) 			{$where .= " and a.kubun = 1";$sort='desc';}
			else if($state==2) 	$where .= " and a.kubun = 0";
			else if($state==3) 	$where .= " and a.kubun is null";
			else if($state==4) 	$where .= " and (a.kubun is null || a.kubun = 0)";
		}
		
		if($category!='') 
			$where.=" and a.sport_name = '".$category."'";
		
		if($specialType!=="")	
		{
			$where.=" and a.special = ".$specialType;		
		}

		//-> 사다리 외 검색시 사다리는 제외.
		if ($specialType != 5) {
			$where.=" and a.special != 5";
		}
		//-> 달팽이 외 검색시 달팽이는 제외.
		if ($specialType != 6) {
			$where.=" and a.special != 6";
		}
		//-> 파워볼 외 검색시 파워볼은 제외.
		if ($specialType != 7) {
			$where.=" and a.special != 7";
		}
		//-> 다리다리 외 검색시 동전게임은 제외.
		if ($specialType != 8) {
			$where.=" and a.special != 8";
		}
		//-> 리얼20장 외 검색시 리얼20장 제외.
		if ($specialType != 9) {
			$where .= " and a.special != 9";
		}

		if($beginDate != '' && $endDate != '') 
			$where .= " and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) between '".$beginDate."' and '".$endDate." 23:59:59'";
			
		if($bettingEnable=='1')
		{
			$now = date("Y-m-d H:i:s");
			$where .= " and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) >= '".$now."'";
		}
		else if($bettingEnable=='-1')
		{
			$now = date("Y-m-d H:i:s");
			$where .= " and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) <= '".$now."'";
		}
			
		if($homeTeam!='') 
			$where .= " and a.home_team like ('%" . $homeTeam . "%')";
			
		if($awayTeam!='')
			$where .= " and a.away_team like ('%" . $awayTeam . "%')";

		if($modifyFlag === 0)
			$where .= " and b.update_enable = 0";
		
		$league_sql = "select a.league_sn, a.notice as league_name from tb_child a, tb_subchild b
					   where a.sn = b.child_sn and a.view_flag = '1' ".$where." group by a.league_sn order by a.notice asc";
		$league_rs = $this->db->exeSql($league_sql);

		if($leagueSn!='') 
		{
			if(!is_array($leagueSn))
			{
				$where.=" and a.league_sn=".$leagueSn;
			}
			else
			{
				$where.=" and a.league_sn in(";
				for($i=0; $i<count((array)$leagueSn); ++$i)
				{
					if($i==0)	$where.=$leagueSn[$i];
					else			$where.=",".$leagueSn[$i];
				}
				$where.=")";
			}
		}

		if($minBettingMoney!='')
			$where .=" and c.total_money >= ".$minBettingMoney;

		if($minBettingMoney!='')
		{	
			$sql = "select count(*) as cnt
					from ".$this->db_qz."child a, ".$this->db_qz."subchild b left outer join
					(select sum(betting_money) as total_money, sub_child_sn
						from ".$this->db_qz."total_cart c, ".$this->db_qz."total_betting d
						where c.betting_no = d.betting_no and c.is_account = 1 and logo='".$this->logo."'
						group by sub_child_sn) as c on b.sn=c.sub_child_sn
					where a.sn = b.child_sn and a.view_flag = '1' ".$where;
		} else {
			$sql = "select count(*) as cnt
					from ".$this->db_qz."child a, ".$this->db_qz."subchild b left outer join
					(select sum(betting_money) as total_money, sub_child_sn
						from ".$this->db_qz."total_cart c, ".$this->db_qz."total_betting d
						where c.betting_no = d.betting_no and c.is_account = 1 and logo='".$this->logo."'
						group by sub_child_sn) as c on b.sn = c.sub_child_sn
					where a.sn = b.child_sn and a.view_flag = '1' ".$where;
		}
		$rs = $this->db->exeSql($sql);
		
		$returnData['cnt'] = $rs[0]['cnt'];
		$returnData['league_list'] = $league_rs;
		return $returnData;
	}

	//▶ 게임 총합
	public function getManageListTotal($state=''/*kubun*/, $category='', $gameType='', $specialType='', $beginDate='', $endDate='', $minBettingMoney='', $leagueSn='', $homeTeam='', $awayTeam='', $bettingEnable='', $parsingType='ALL', $modifyFlag='')
	{
		if ( $parsingType != "ALL" ) $where=" and a.parsing_site = '".$parsingType."'";
		
		if($state!='') 
		{
			if($state==1) 			{$where .= " and a.kubun = 1";$sort='desc';}
			else if($state==2) 	$where .= " and a.kubun = 0";
			else if($state==3) 	$where .= " and a.kubun is null";
			else if($state==4) 	$where .= " and (a.kubun is null || a.kubun = 0)";
		}
		
		if($category!='') 
			$where.=" and a.sport_name = '".$category."'";
		
		if($specialType!=="")	
		{
			$where.=" and a.special = ".$specialType;		
		}

		//-> 사다리 외 검색시 사다리는 제외.
		if ($specialType != 5) {
			$where.=" and a.special != 5";
		}
		//-> 달팽이 외 검색시 달팽이는 제외.
		if ($specialType != 6) {
			$where.=" and a.special != 6";
		}
		//-> 파워볼 외 검색시 파워볼은 제외.
		if ($specialType != 7) {
			$where.=" and a.special != 7";
		}
		//-> 다리다리 외 검색시 동전게임은 제외.
		if ($specialType != 8) {
			$where.=" and a.special != 8";
		}
		//-> 리얼20장 외 검색시 리얼20장 제외.
		if ($specialType != 9) {
			$where .= " and a.special != 9";
		}

		if($beginDate != '' && $endDate != '') 
			$where .= " and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) between '".$beginDate."' and '".$endDate." 23:59:59'";
			
		if($bettingEnable=='1')
		{
			$now = date("Y-m-d H:i:s");
			$where .= " and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) >= '".$now."'";
		}
		else if($bettingEnable=='-1')
		{
			$now = date("Y-m-d H:i:s");
			$where .= " and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) <= '".$now."'";
		}
			
		if($homeTeam!='') 
			$where .= " and a.home_team like ('%" . $homeTeam . "%')";
			
		if($awayTeam!='')
			$where .= " and a.away_team like ('%" . $awayTeam . "%')";

		if($modifyFlag === 0)
			$where .= " and b.update_enable = 0";
		
		$league_sql = "select a.league_sn, a.notice as league_name from tb_child a, tb_subchild b
					   where a.sn = b.child_sn and a.view_flag = '1' ".$where." group by a.league_sn order by a.notice asc";
		$league_rs = $this->db->exeSql($league_sql);

		if($leagueSn!='') 
		{
			if(!is_array($leagueSn))
			{
				$where.=" and a.league_sn=".$leagueSn;
			}
			else
			{
				$where.=" and a.league_sn in(";
				for($i=0; $i<count((array)$leagueSn); ++$i)
				{
					if($i==0)	$where.=$leagueSn[$i];
					else			$where.=",".$leagueSn[$i];
				}
				$where.=")";
			}
		}

		if($minBettingMoney!='')
			$where .=" and c.total_money >= ".$minBettingMoney;

		if($minBettingMoney!='')
		{	
			$sql = "select count(*) as cnt
					from ".$this->db_qz."child a, ".$this->db_qz."subchild b inner join
					(select sum(betting_money) as total_money, sub_child_sn
						from ".$this->db_qz."total_cart c, ".$this->db_qz."total_betting d
						where c.betting_no = d.betting_no and c.is_account = 1 and logo='".$this->logo."'
						group by sub_child_sn) as c on b.sn=c.sub_child_sn
					where a.sn = b.child_sn and a.view_flag = '1' ".$where;
		} else {
			$sql = "select count(*) as cnt
					from ".$this->db_qz."child a, ".$this->db_qz."subchild b inner join
					(select sum(betting_money) as total_money, sub_child_sn
						from ".$this->db_qz."total_cart c, ".$this->db_qz."total_betting d
						where c.betting_no = d.betting_no and c.is_account = 1 and logo='".$this->logo."'
						group by sub_child_sn) as c on b.sn = c.sub_child_sn
					where a.sn = b.child_sn and a.view_flag = '1' ".$where;
		}
		$rs = $this->db->exeSql($sql);
		
		$returnData['cnt'] = $rs[0]['cnt'];
		$returnData['league_list'] = $league_rs;
		return $returnData;
	}

	//▶ 마감게임 총합
	public function getResultListTotal($state=''/*kubun*/, $category='', $gameType='', $specialType='', $beginDate='', $endDate='', $minBettingMoney='', $leagueSn='', $homeTeam='', $awayTeam='', $bettingEnable='', $parsingType='ALL', $modifyFlag='')
	{
		if ( $parsingType != "ALL" ) $where=" and a.parsing_site = '".$parsingType."'";
		
		if($state!='') 
		{
			if($state==1) 			{$where .= " and a.kubun=1";$sort='desc';}
			else if($state==2) 	$where .= " and a.kubun=0";
			else if($state==3) 	$where .= " and a.kubun is null";
			else if($state==4) 	$where .= " and (a.kubun is null || a.kubun=0)";
		}
		
		if($category!='') 
			$where.=" and a.sport_name='".$category."'";
		
		if($specialType!=="")	
		{
			switch($specialType)
			{
                case '1': $where.=" and a.special=0";  break;
                case '2': $where.=" and a.special=1";  break;
                case '4': $where.=" and a.special=2";  break;
                case '5': $where.=" and a.special=3";  break;
                case '6': $where.=" and a.special=4";  break;
                case '7': $where.=" and a.special=5";  break;
                case '8': $where.=" and a.special=6";  break;
                case '9': $where.=" and a.special=7";  break;
                /*case '22': $where.=" and a.special=22";  break;
                case '26': $where.=" and a.special=26";  break;
                case '27': $where.=" and a.special=27";  break;
                case '28': $where.=" and a.special=28";  break;
                case '29': $where.=" and a.special=29";  break;*/
		        default: $where.=" and a.special=".$specialType;  break;
			}			
		}

		//-> 사다리 외 검색시 사다리는 제외.
		if ($specialType != 5) {
			$where.=" and a.special != 5";
		}
		//-> 달팽이 외 검색시 달팽이는 제외.
		if ($specialType != 6) {
			$where.=" and a.special != 6";
		}
		//-> 파워볼 외 검색시 파워볼은 제외.
		if ($specialType != 7) {
			$where.=" and a.special != 7";
		}
		//-> 다리다리 외 검색시 동전게임은 제외.
		if ($specialType != 8) {
			$where.=" and a.special != 8";
		}
		//-> 리얼20장 외 검색시 리얼20장 제외.
		if ($specialType != 9) {
			$where.=" and a.special != 9";
		}

		if($beginDate!='' && $endDate!='') 
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) between '".$beginDate."' and '".$endDate." 23:59:59'";
			
		if($bettingEnable=='1')
		{
			$now = date("Y-m-d H:i:s");
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) >= '".$now."'";
		}
		else if($bettingEnable=='-1')
		{
			$now = date("Y-m-d H:i:s");
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) <= '".$now."'";
		}
			
		if($minBettingMoney!='')
			$where .=" and c.total_money >= ".$minBettingMoney;
			
		if($homeTeam!='') 
			$where.=" and a.home_team like('%".$homeTeam."%')";
			
		if($awayTeam!='')
			$where.=" and a.away_team like('%".$awayTeam."%')";

		if($modifyFlag===0)
			$where.=" and b.update_enable = 0";
		
		$where .= " and b.result = 0 ";

		$league_sql = "select a.league_sn, c.name as league_name, c.alias_name from tb_child a, tb_subchild b, tb_league c
					   where a.sn=b.child_sn and a.league_sn=c.lsports_league_sn and a.view_flag = '1' ".$where." group by a.league_sn order by c.name asc";
		$league_rs = $this->db->exeSql($league_sql);
		
		if($leagueSn!='') 
		{
			if(!is_array($leagueSn))
			{
				$where.=" and a.league_sn=".$leagueSn;
			}
			else
			{
				$where.=" and a.league_sn in(";
				for($i=0; $i<count((array)$leagueSn); ++$i)
				{
					if($i==0)	$where.=$leagueSn[$i];
					else			$where.=",".$leagueSn[$i];
				}
				$where.=")";
			}
		}

		if($minBettingMoney!='')
		{	
			$sql = "select count(*) as cnt
							from ".$this->db_qz."child a, ".$this->db_qz."league c, ".$this->db_qz."subchild b left outer join
							(select sum(betting_money) as total_money, sub_child_sn
								from ".$this->db_qz."total_cart c, ".$this->db_qz."total_betting d
								where c.betting_no=d.betting_no and c.is_account=1 and logo='".$this->logo."'
								group by sub_child_sn) as c on b.sn=c.sub_child_sn
							where a.sn=b.child_sn and a.league_sn=c.lsports_league_sn and a.view_flag = '1' ".$where;
		} else {
			$sql = "select count(*) as cnt
							from ".$this->db_qz."child a, ".$this->db_qz."subchild b, ".$this->db_qz."league c
							where a.view_flag = 1 and a.sn=b.child_sn and a.league_sn=c.lsports_league_sn and a.view_flag = '1' ".$where;
		}
		$rs = $this->db->exeSql($sql);
		
		$returnData['cnt'] = $rs[0]['cnt'];
		$returnData['league_list'] = $league_rs;
		return $returnData;
	}

	//▶ 게임 총합
	public function getMultiListTotal($state=''/*kubun*/, $category='', $gameType='', $beginDate='', $endDate='', $minBettingMoney='', $leagueSn='', $homeTeam='', $awayTeam='', $bettingEnable='', $parsingType='ALL', $modifyFlag='')
	{
		if ( $parsingType != "ALL" ) $where=" and a.parsing_site = '".$parsingType."'";
		
		if($state!='') 
		{
			if($state==1) 			{$where .= " and b.kubun=1";$sort='desc';}
			else if($state==2) 	$where .= " and b.kubun=0";
			else if($state==3) 	$where .= " and b.kubun is null";
			else if($state==4) 	$where .= " and (b.kubun is null || b.kubun=0)";
		}
		
		if($category!='') 
			$where.=" and a.sport_name='".$category."'";

		if ( $gameType != '' ) {
			$where.=" and b.betting_type='".$gameType."'";
		}
		

		if($beginDate!='' && $endDate!='') 
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) between '".$beginDate."' and '".$endDate." 23:59:59'";
			
		if($bettingEnable=='1')
		{
			$now = date("Y-m-d H:i:s");
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) >= '".$now."'";
		}
		else if($bettingEnable=='-1')
		{
			$now = date("Y-m-d H:i:s");
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) <= '".$now."'";
		}
			
		if($homeTeam!='') 
			$where.=" and a.home_team like('%".$homeTeam."%')";
			
		if($awayTeam!='')
			$where.=" and a.away_team like('%".$awayTeam."%')";

		if($modifyFlag===0)
			$where.=" and b.update_enable = 0";
		
		$league_sql = "select a.league_sn, c.name as league_name, c.alias_name from tb_child_m a, tb_subchild_m b, tb_league c
					   where a.sn=b.child_sn and a.league_sn=c.sn and b.view_flag = '1' ".$where." group by a.league_sn order by c.name asc";
		$league_rs = $this->db->exeSql($league_sql);
			
		if($minBettingMoney!='')
			$where .=" and c.total_money >= ".$minBettingMoney;
			
		if($leagueSn!='') 
		{
			if(!is_array($leagueSn))
			{
				$where.=" and a.league_sn=".$leagueSn;
			}
			else
			{
				$where.=" and a.league_sn in(";
				for($i=0; $i<count((array)$leagueSn); ++$i)
				{
					if($i==0)	$where.=$leagueSn[$i];
					else			$where.=",".$leagueSn[$i];
				}
				$where.=")";
			}
		}
		
		if($minBettingMoney!='')
		{	
			$sql = "select count(*) as cnt
							from ".$this->db_qz."child_m a, ".$this->db_qz."league c, ".$this->db_qz."subchild_m b left outer join
							(select sum(betting_money) as total_money, sub_child_sn
								from ".$this->db_qz."total_cart c, ".$this->db_qz."total_betting d
								where c.betting_no=d.betting_no and c.is_account=1 and logo='".$this->logo."'
								group by sub_child_sn) as c on b.sn=c.sub_child_sn
							where a.sn=b.child_sn and a.league_sn=c.sn and b.view_flag = '1' ".$where;
		} else {
			$sql = "select count(*) as cnt
							from ".$this->db_qz."child_m a, ".$this->db_qz."subchild_m b, ".$this->db_qz."league c
							where a.sn=b.child_sn and a.league_sn=c.sn and b.view_flag = '1' ".$where;
		}
		
		$rs = $this->db->exeSql($sql);
		
		$returnData['cnt'] = $rs[0]['cnt'];
		$returnData['league_list'] = $league_rs;
		return $returnData;
	}

	//▶ 앞으로 진행될 경기목록
	public function getFixtureListTotal($state=''/*kubun*/, $category='', $beginDate='', $endDate='', $leagueSn='', $homeTeam='', $awayTeam='', $bettingEnable='', $parsingType='ALL')
	{
		if ( $parsingType != "ALL" ) $where=" and a.parsing_site = '".$parsingType."'";
		
		if($category!='') 
			$where.=" and a.sport_name='".$category."'";

		$where.=" and a.special < 5 and a.kubun=0 and a.status < 3 ";

		if($beginDate!='' && $endDate!='') 
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) between '".$beginDate."' and '".$endDate." 23:59:59'";
			
		if($bettingEnable=='1')
		{
			$now = date("Y-m-d H:i:s");
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) >= '".$now."'";
		}
		else if($bettingEnable=='-1')
		{
			$now = date("Y-m-d H:i:s");
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) <= '".$now."'";
		}
			
		if($homeTeam!='') 
			$where.=" and a.home_team like('%".$homeTeam."%')";
			
		if($awayTeam!='')
			$where.=" and a.away_team like('%".$awayTeam."%')";

		$league_sql = "select a.league_sn, c.name as league_name, c.alias_name from tb_child a, tb_league c
					   where a.league_sn=c.lsports_league_sn and a.view_flag = '1' and c.is_use = 1 ".$where." group by a.league_sn order by c.name asc";
		$league_rs = $this->db->exeSql($league_sql);
		
		if($leagueSn!='') 
		{
			if(!is_array($leagueSn))
			{
				$where.=" and a.league_sn=".$leagueSn;
			}
			else
			{
				$where.=" and a.league_sn in(";
				for($i=0; $i<count((array)$leagueSn); ++$i)
				{
					if($i==0)	$where.=$leagueSn[$i];
					else			$where.=",".$leagueSn[$i];
				}
				$where.=")";
			}
		}

		$sql = "select count(*) as cnt
				from ".$this->db_qz."child a left join ".$this->db_qz."league b on a.league_sn = b.lsports_league_sn
				where 	a.view_flag = 1 
						and b.is_use = 1
						and (a.live = -1 or a.live = 1) ".$where;
		$rs = $this->db->exeSql($sql);
		
		$returnData['cnt'] = $rs[0]['cnt'];
		$returnData['league_list'] = $league_rs;
		return $returnData;
	}

    public function getListTotalofLive($state=''/*kubun*/, $category='', $gameType='', $specialType='', $beginDate='', $endDate='', $minBettingMoney='', $leagueSn='', $homeTeam='', $awayTeam='', $bettingEnable='', $parsingType='ALL', $modifyFlag='')
    {
        if ( $parsingType != "ALL" ) $where=" and a.parsing_site = '".$parsingType."'";

        if($state!='')
        {
            if($state==1) 			{$where .= " and a.kubun=1";$sort='desc';}
            else if($state==2) 	$where .= " and a.kubun=0";
            else if($state==3) 	$where .= " and a.kubun is null";
            else if($state==4) 	$where .= " and (a.kubun is null || a.kubun=0)";
        }

        if($category!='')
            $where.=" and a.sport_name='".$category."'";

        if ( $gameType == 24 ) {
            $where.=" and (a.type='2' or a.type='4')";
        } else if ( $gameType != '' ) {
            $where.=" and a.type='".$gameType."'";
        }

        if($specialType!=="")
        {
            $where.=" and a.special=".$specialType;
        } else {
            $where.=" and a.special in (2, 50)";
        }

        if($beginDate!='' && $endDate!='')
            $where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) between '".$beginDate."' and '".$endDate." 23:59:59'";

        if($bettingEnable=='1')
        {
            $now = date("Y-m-d H:i:s");
            $where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) >= '".$now."'";
        }
        else if($bettingEnable=='-1')
        {
            $now = date("Y-m-d H:i:s");
            $where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) <= '".$now."'";
        }

        if($minBettingMoney!='')
            $where .=" and c.total_money >= ".$minBettingMoney;

        if($homeTeam!='')
            $where.=" and a.home_team like('%".$homeTeam."%')";

        if($awayTeam!='')
            $where.=" and a.away_team like('%".$awayTeam."%')";

        if($modifyFlag===0)
            $where.=" and b.update_enable = 0";

        $league_sql = "select a.league_sn, c.name as league_name, c.alias_name from tb_child a, tb_subchild b, tb_league c
					   where a.sn=b.child_sn and a.league_sn=c.sn and a.view_flag = '1' ".$where." group by a.league_sn order by c.name asc";
        $league_rs = $this->db->exeSql($league_sql);

        if($leagueSn!='')
        {
            if(!is_array($leagueSn))
            {
                $where.=" and a.league_sn=".$leagueSn;
            }
            else
            {
                $where.=" and a.league_sn in(";
                for($i=0; $i<count((array)$leagueSn); ++$i)
                {
                    if($i==0)	$where.=$leagueSn[$i];
                    else			$where.=",".$leagueSn[$i];
                }
                $where.=")";
            }
        }

        if($minBettingMoney!='')
        {
            $sql = "select count(*) as cnt
							from ".$this->db_qz."child a, ".$this->db_qz."league c, ".$this->db_qz."subchild b left outer join
							(select sum(betting_money) as total_money, sub_child_sn
								from ".$this->db_qz."total_cart c, ".$this->db_qz."total_betting d
								where c.betting_no=d.betting_no and c.is_account=1 and logo='".$this->logo."'
								group by sub_child_sn) as c on b.sn=c.sub_child_sn
							where a.sn=b.child_sn and a.league_sn=c.sn and a.view_flag = '1' ".$where;
        } else {
            $sql = "select count(*) as cnt
							from ".$this->db_qz."child a, ".$this->db_qz."subchild b, ".$this->db_qz."league c
							where a.view_flag = 1 and a.sn=b.child_sn and a.league_sn=c.sn and a.view_flag = '1' ".$where;
        }
        $rs = $this->db->exeSql($sql);

        $returnData['cnt'] = $rs[0]['cnt'];
        $returnData['league_list'] = $league_rs;
        return $returnData;
    }

	public function getMultiListTotalofLive($state=''/*kubun*/, $category='', $gameType='', $specialType='', $beginDate='', $endDate='', $minBettingMoney='', $leagueSn='', $homeTeam='', $awayTeam='', $bettingEnable='', $parsingType='ALL', $modifyFlag='')
    {
        if ( $parsingType != "ALL" ) $where=" and a.parsing_site = '".$parsingType."'";

        if($state!='')
        {
            if($state==1) 			{$where .= " and b.kubun=1";$sort='desc';}
            else if($state==2) 	$where .= " and b.kubun=0";
            else if($state==3) 	$where .= " and b.kubun is null";
            else if($state==4) 	$where .= " and (b.kubun is null || b.kubun=0)";
        }

        if($category!='')
            $where.=" and a.sport_name='".$category."'";

		$where.=" and b.betting_type='".$gameType."'";

        if($specialType!=="")
        {
            $where.=" and a.special=".$specialType;
        } else {
            $where.=" and a.special in (2, 50)";
        }

        if($beginDate!='' && $endDate!='')
            $where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) between '".$beginDate."' and '".$endDate." 23:59:59'";

        if($bettingEnable=='1')
        {
            $now = date("Y-m-d H:i:s");
            $where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) >= '".$now."'";
        }
        else if($bettingEnable=='-1')
        {
            $now = date("Y-m-d H:i:s");
            $where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) <= '".$now."'";
        }

        if($minBettingMoney!='')
            $where .=" and c.total_money >= ".$minBettingMoney;

        if($homeTeam!='')
            $where.=" and a.home_team like('%".$homeTeam."%')";

        if($awayTeam!='')
            $where.=" and a.away_team like('%".$awayTeam."%')";

        if($modifyFlag===0)
            $where.=" and b.update_enable = 0";

        $league_sql = "select a.league_sn, c.name as league_name, c.alias_name from tb_child_m a, tb_subchild_m b, tb_league c
					   where a.sn=b.child_sn and a.league_sn=c.sn and b.view_flag = '1' ".$where." group by a.league_sn order by c.name asc";
        $league_rs = $this->db->exeSql($league_sql);

        if($leagueSn!='')
        {
            if(!is_array($leagueSn))
            {
                $where.=" and a.league_sn=".$leagueSn;
            }
            else
            {
                $where.=" and a.league_sn in(";
                for($i=0; $i<count((array)$leagueSn); ++$i)
                {
                    if($i==0)	$where.=$leagueSn[$i];
                    else			$where.=",".$leagueSn[$i];
                }
                $where.=")";
            }
        }

        if($minBettingMoney != '')
        {
            $sql = "select count(*) as cnt
							from ".$this->db_qz."child_m a, ".$this->db_qz."league c, ".$this->db_qz."subchild_m b left outer join
							(select sum(betting_money) as total_money, sub_child_sn
								from ".$this->db_qz."total_cart c, ".$this->db_qz."total_betting d
								where c.betting_no=d.betting_no and c.is_account=1 and logo='".$this->logo."'
								group by sub_child_sn) as c on b.sn=c.sub_child_sn
							where a.sn=b.child_sn and a.league_sn=c.sn and b.view_flag = '1' ".$where;
        } else {
            $sql = "select count(*) as cnt
							from ".$this->db_qz."child_m a, ".$this->db_qz."subchild_m b, ".$this->db_qz."league c
							where a.sn=b.child_sn and a.league_sn=c.sn and b.view_flag = '1' ".$where;
        }
        $rs = $this->db->exeSql($sql);

        $returnData['cnt'] = $rs[0]['cnt'];
        $returnData['league_list'] = $league_rs;
        return $returnData;
    }

    //▶ 게임 목록
	public function getList($page, $page_size, $state=''/*kubun*/, $category='', $gameType='', $specialType='', $beginDate='', $endDate='', $minBettingMoney='', $leagueSn='', $homeTeam='', $awayTeam='', $bettingEnable='', $parsingType='ALL', $modifyFlag='')
	{
		if ( $parsingType != "ALL" ) $where=" and a.parsing_site = '".$parsingType."'";
		$sort='asc';
		
		if($state!='') 
		{
			if($state==1) 			{$where .= " and a.kubun = 1"; $sort='desc';}
			else if($state==2) 	$where .= " and a.kubun = 0";
			else if($state==3) 	$where .= " and a.kubun is null";
			else if($state==4) 	$where .= " and (a.kubun is null || a.kubun = 0)";
		}
		
		if($category!='') 
			$where.=" and a.sport_name = '".$category."'";

		if($specialType!=="")	
		{
			$where.=" and a.special = ".$specialType;
		}

		//-> 사다리 외 검색시 사다리는 제외.
		if ($specialType != 5) {
			$where.=" and a.special != 5";
		}
		//-> 달팽이 외 검색시 달팽이는 제외.
		if ($specialType != 6) {
			$where.=" and a.special != 6";
		}
		//-> 파워볼 외 검색시 파워볼 제외.
		if ($specialType != 7) {
			$where.=" and a.special != 7";
		}
		//-> 다리다리 외 검색시 동전게임은 제외.
		if ($specialType != 8) {
			$where.=" and a.special != 8";
		}
		//-> 리얼20장 외 검색시 리얼20장은 제외.
		if ($specialType != 9) {
			$where.=" and a.special != 9";
		}

		if($beginDate!='' && $endDate!='') 
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) between '".$beginDate."' and '".$endDate." 23:59:59'";
			
		if($bettingEnable=='1')
		{
			$now = date("Y-m-d H:i:s");
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) >= '".$now."'";
		}
		else if($bettingEnable=='-1')
		{
			$now = date("Y-m-d H:i:s");
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) <= '".$now."'";
		}
			
		if($minBettingMoney!='')
			$where .=" and c.total_money >= ".$minBettingMoney;
			
		if($leagueSn!='') 
		{
			if(!is_array($leagueSn))
			{
				$where.=" and a.league_sn=".$leagueSn;
			}
			else
			{
				$where.=" and a.league_sn in(";
				for($i=0; $i<count((array)$leagueSn); ++$i)
				{
					if($i==0)	$where.=$leagueSn[$i];
					else			$where.=",".$leagueSn[$i];
				}
				$where.=")";
			}
		}
		if($homeTeam!='') 
			$where.=" and a.home_team like('%".$homeTeam."%')";
			
		if($awayTeam!='')
			$where.=" and a.away_team like('%".$awayTeam."%')";

		if($modifyFlag===0)
			$where.=" and b.update_enable = 0";

		if($page_size > 0)
			$limit = "limit ".$page.",".$page_size;

		if($minBettingMoney != '')
		{	
			$sql = "select tb_temp.*, tb_markets.mname_ko, tb_markets.mid, tb_markets.mfamily from (select a.sn as child_sn, a.parent_sn, a.sport_name, a.sport_id, a.home_team, a.away_team, a.home_score, a.away_score, a.league_sn,
							a.gameDate, a.gameHour, a.gameTime, a.notice as league_name, a.win_team,a.kubun, a.parsing_site, a.user_view_flag,
							a.type, a.special, a.bet_money, b.home_name, b.home_line,
							b.sn, b.betting_type, b.home_rate, b.draw_rate, b.away_rate, b.win, b.result, b.sub_home_score, b.sub_away_score, 
							b.update_enable, a.is_update_date, b.new_home_rate, b.new_draw_rate, b.new_away_rate
					from ".$this->db_qz."child a, ".$this->db_qz."subchild b left outer join
							(select sum(betting_money) as total_money, sub_child_sn
							from ".$this->db_qz."total_cart c, ".$this->db_qz."total_betting d
							where c.betting_no=d.betting_no and c.is_account=1 
							group by sub_child_sn) as c on b.sn=c.sub_child_sn
					where a.sn=b.child_sn and a.view_flag = '1' ".$where . " " . $limit .") as tb_temp left join tb_markets on tb_temp.betting_type = tb_markets.mid
					order by tb_temp.gameDate ".$sort.", tb_temp.gameHour ".$sort.", tb_temp.gameTime ".$sort.", tb_temp.league_name, tb_temp.home_team, tb_temp.special, tb_temp.sn asc ";
		} else {
			$sql = "select tb_temp.*, tb_markets.mname_ko, tb_markets.mid, tb_markets.mfamily from (select a.sn as child_sn, a.parent_sn, a.sport_name, a.sport_id, a.home_team, a.away_team, a.home_score, a.away_score, a.league_sn,
							a.gameDate, a.gameHour, a.gameTime, a.notice as league_name, a.win_team,a.kubun, a.parsing_site, a.user_view_flag,
							a.type, a.special, a.bet_money, b.home_name, b.home_line,
							b.sn, b.betting_type, b.home_rate, b.draw_rate, b.away_rate, b.win, b.result, b.sub_home_score, b.sub_away_score, 
							b.update_enable, a.is_update_date, b.new_home_rate, b.new_draw_rate, b.new_away_rate
					from ".$this->db_qz."child a, ".$this->db_qz."subchild b left outer join
							(select sum(betting_money) as total_money, sub_child_sn
							from ".$this->db_qz."total_cart c, ".$this->db_qz."total_betting d
							where c.betting_no=d.betting_no and c.is_account=1 
							group by sub_child_sn) as c on b.sn = c.sub_child_sn
					where a.sn=b.child_sn and a.view_flag = '1' ".$where." " .$limit.") as tb_temp left join tb_markets on tb_temp.betting_type = tb_markets.mid
					order by tb_temp.gameDate ".$sort.", tb_temp.gameHour ".$sort.", tb_temp.gameTime ".$sort.", tb_temp.league_name, tb_temp.home_team, tb_temp.special, tb_temp.sn asc";
		}
		
		return $this->db->exeSql($sql);
	}

	//▶ 게임 목록
	public function getManageList($page, $page_size, $state=''/*kubun*/, $category='', $gameType='', $specialType='', $beginDate='', $endDate='', $minBettingMoney='', $leagueSn='', $homeTeam='', $awayTeam='', $bettingEnable='', $parsingType='ALL', $modifyFlag='')
	{
		if ( $parsingType != "ALL" ) $where=" and a.parsing_site = '".$parsingType."'";
		$sort='asc';
		
		if($state!='') 
		{
			if($state==1) 			{$where .= " and a.kubun = 1"; $sort='desc';}
			else if($state==2) 	$where .= " and a.kubun = 0";
			else if($state==3) 	$where .= " and a.kubun is null";
			else if($state==4) 	$where .= " and (a.kubun is null || a.kubun = 0)";
		}
		
		if($category!='') 
			$where.=" and a.sport_name = '".$category."'";

		if($specialType!=="")	
		{
			$where.=" and a.special = ".$specialType;
		}

		//-> 사다리 외 검색시 사다리는 제외.
		if ($specialType != 5) {
			$where.=" and a.special != 5";
		}
		//-> 달팽이 외 검색시 달팽이는 제외.
		if ($specialType != 6) {
			$where.=" and a.special != 6";
		}
		//-> 파워볼 외 검색시 파워볼 제외.
		if ($specialType != 7) {
			$where.=" and a.special != 7";
		}
		//-> 다리다리 외 검색시 동전게임은 제외.
		if ($specialType != 8) {
			$where.=" and a.special != 8";
		}
		//-> 리얼20장 외 검색시 리얼20장은 제외.
		if ($specialType != 9) {
			$where.=" and a.special != 9";
		}

		if($beginDate!='' && $endDate!='') 
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) between '".$beginDate."' and '".$endDate." 23:59:59'";
			
		if($bettingEnable=='1')
		{
			$now = date("Y-m-d H:i:s");
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) >= '".$now."'";
		}
		else if($bettingEnable=='-1')
		{
			$now = date("Y-m-d H:i:s");
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) <= '".$now."'";
		}
			
		if($minBettingMoney!='')
			$where .=" and c.total_money >= ".$minBettingMoney;
			
		if($leagueSn!='') 
		{
			if(!is_array($leagueSn))
			{
				$where.=" and a.league_sn=".$leagueSn;
			}
			else
			{
				$where.=" and a.league_sn in(";
				for($i=0; $i<count((array)$leagueSn); ++$i)
				{
					if($i==0)	$where.=$leagueSn[$i];
					else			$where.=",".$leagueSn[$i];
				}
				$where.=")";
			}
		}
		if($homeTeam!='') 
			$where.=" and a.home_team like('%".$homeTeam."%')";
			
		if($awayTeam!='')
			$where.=" and a.away_team like('%".$awayTeam."%')";

		if($modifyFlag===0)
			$where.=" and b.update_enable = 0";

		if($page_size > 0)
			$limit = "limit ".$page.",".$page_size;

		if($minBettingMoney != '')
		{	
			$sql = "select tb_temp.*, tb_markets.mname_ko, tb_markets.mid, tb_markets.mfamily from (select a.sn as child_sn, a.parent_sn, a.sport_name, a.sport_id, a.home_team, a.away_team, a.home_score, a.away_score, a.league_sn,
							a.gameDate, a.gameHour, a.gameTime, a.notice as league_name, a.win_team,a.kubun, a.parsing_site, a.user_view_flag,
							a.type, a.special, a.bet_money, b.home_name, b.home_line,
							b.sn, b.betting_type, b.home_rate, b.draw_rate, b.away_rate, b.win, b.result, b.sub_home_score, b.sub_away_score, 
							b.update_enable, a.is_update_date, b.new_home_rate, b.new_draw_rate, b.new_away_rate
					from ".$this->db_qz."child a, ".$this->db_qz."subchild b inner join
							(select sum(betting_money) as total_money, sub_child_sn
							from ".$this->db_qz."total_cart c, ".$this->db_qz."total_betting d
							where c.betting_no=d.betting_no and c.is_account=1 
							group by sub_child_sn) as c on b.sn=c.sub_child_sn
					where a.sn=b.child_sn and a.view_flag = '1' ".$where . " " . $limit .") as tb_temp left join tb_markets on tb_temp.betting_type = tb_markets.mid
					order by tb_temp.gameDate ".$sort.", tb_temp.gameHour ".$sort.", tb_temp.gameTime ".$sort.", tb_temp.league_name, tb_temp.home_team, tb_temp.special, tb_temp.sn asc ";
		} else {
			$sql = "select tb_temp.*, tb_markets.mname_ko, tb_markets.mid, tb_markets.mfamily from (select a.sn as child_sn, a.parent_sn, a.sport_name, a.sport_id, a.home_team, a.away_team, a.home_score, a.away_score, a.league_sn,
							a.gameDate, a.gameHour, a.gameTime, a.notice as league_name, a.win_team,a.kubun, a.parsing_site, a.user_view_flag,
							a.type, a.special, a.bet_money, b.home_name, b.home_line,
							b.sn, b.betting_type, b.home_rate, b.draw_rate, b.away_rate, b.win, b.result, b.sub_home_score, b.sub_away_score, 
							b.update_enable, a.is_update_date, b.new_home_rate, b.new_draw_rate, b.new_away_rate
					from ".$this->db_qz."child a, ".$this->db_qz."subchild b inner join
							(select sum(betting_money) as total_money, sub_child_sn
							from ".$this->db_qz."total_cart c, ".$this->db_qz."total_betting d
							where c.betting_no=d.betting_no and c.is_account=1 
							group by sub_child_sn) as c on b.sn = c.sub_child_sn
					where a.sn=b.child_sn and a.view_flag = '1' ".$where." " .$limit.") as tb_temp left join tb_markets on tb_temp.betting_type = tb_markets.mid
					order by tb_temp.gameDate ".$sort.", tb_temp.gameHour ".$sort.", tb_temp.gameTime ".$sort.", tb_temp.league_name, tb_temp.home_team, tb_temp.special, tb_temp.sn asc";
		}
		
		return $this->db->exeSql($sql);
	}

	//▶ 게임 목록
	public function getResultList($page, $page_size, $state=''/*kubun*/, $category='', $gameType='', $specialType='', $beginDate='', $endDate='', $minBettingMoney='', $leagueSn='', $homeTeam='', $awayTeam='', $bettingEnable='', $parsingType='ALL', $modifyFlag='')
	{
		if ( $parsingType != "ALL" ) $where=" and a.parsing_site = '".$parsingType."'";
		$sort='asc';
		
		if($state!='') 
		{
			if($state==1) 			{$where .=" and a.kubun=1";$sort='desc';}
			else if($state==2) 	$where .=" and a.kubun=0";
			else if($state==3) 	$where .= " and a.kubun is null";
			else if($state==4) 	$where .= " and (a.kubun is null || a.kubun=0)";
		}
		
		if($category!='') 
			$where.=" and a.sport_name='".$category."'";

		if($specialType!=="")	
		{
			switch($specialType)
			{
                case '1': $where.=" and a.special < 4";  break;
                case '2': $where.=" and a.special < 4";  break;
                case '4': $where.=" and a.special=4";  break;
                case '5': $where.=" and a.special=5";  break;
                case '6': $where.=" and a.special=6";  break;
                case '7': $where.=" and a.special=7";  break;
                case '8': $where.=" and a.special=8";  break;
                case '9': $where.=" and a.special=9";  break;
                /*case '22': $where.=" and a.special=22";  break;
                case '26': $where.=" and a.special=26";  break;
                case '27': $where.=" and a.special=27";  break;
                case '28': $where.=" and a.special=28";  break;
                case '29': $where.=" and a.special=29";  break;*/
		        default:  $where.=" and a.special=".$specialType;  break;
			}
		}

		//-> 사다리 외 검색시 사다리는 제외.
		if ($specialType != 5) {
			$where.=" and a.special != 5";
		}
		//-> 달팽이 외 검색시 달팽이는 제외.
		if ($specialType != 6) {
			$where.=" and a.special != 6";
		}
		//-> 파워볼 외 검색시 파워볼 제외.
		if ($specialType != 7) {
			$where.=" and a.special != 7";
		}
		//-> 다리다리 외 검색시 동전게임은 제외.
		if ($specialType != 8) {
			$where.=" and a.special != 8";
		}
		//-> 리얼20장 외 검색시 리얼20장은 제외.
		if ($specialType != 9) {
			$where.=" and a.special != 9";
		}

		if($beginDate!='' && $endDate!='') 
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) between '".$beginDate."' and '".$endDate." 23:59:59'";
			
		if($bettingEnable=='1')
		{
			$now = date("Y-m-d H:i:s");
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) >= '".$now."'";
		}
		else if($bettingEnable=='-1')
		{
			$now = date("Y-m-d H:i:s");
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) <= '".$now."'";
		}
			
		if($minBettingMoney!='')
			$where .=" and c.total_money >= ".$minBettingMoney;
			
		if($leagueSn!='') 
		{
			if(!is_array($leagueSn))
			{
				$where.=" and a.league_sn=".$leagueSn;
			}
			else
			{
				$where.=" and a.league_sn in(";
				for($i=0; $i<count((array)$leagueSn); ++$i)
				{
					if($i==0)	$where.=$leagueSn[$i];
					else			$where.=",".$leagueSn[$i];
				}
				$where.=")";
			}
		}
		if($homeTeam!='') 
			$where.=" and a.home_team like('%".$homeTeam."%')";
			
		if($awayTeam!='')
			$where.=" and a.away_team like('%".$awayTeam."%')";

		if($modifyFlag===0)
			$where.=" and b.update_enable = 0";

		$where .= " and b.result = 0 ";
		
		if($page_size > 0)
			$limit = "limit ".$page.",".$page_size;

		if($minBettingMoney!='')
		{	
			$sql = "select tb_temp.*, tb_markets.mname_ko, tb_markets.mid, tb_markets.mfamily from (select a.sn as child_sn, a.parent_sn, a.sport_name, a.sport_id, a.home_team, a.away_team, a.home_score, a.away_score, a.league_sn,
							a.gameDate, a.gameHour, a.gameTime, a.notice as league_name, a.win_team,a.kubun, a.parsing_site, a.user_view_flag,
							a.type, a.special, a.bet_money, b.home_name, b.home_line, 
							b.sn, b.betting_type, b.home_rate, b.draw_rate, b.away_rate, b.win, b.result, b.sub_home_score, b.sub_away_score, 
							b.update_enable, a.is_update_date, b.new_home_rate, b.new_draw_rate, b.new_away_rate
					from ".$this->db_qz."child a, ".$this->db_qz."subchild b left outer join
							(select sum(betting_money) as total_money, sub_child_sn
							from ".$this->db_qz."total_cart c, ".$this->db_qz."total_betting d
							where c.betting_no=d.betting_no and c.is_account=1 
							group by sub_child_sn) as c on b.sn=c.sub_child_sn
					where a.sn=b.child_sn and a.view_flag = '1' ".$where."
					order by a.gameDate ".$sort.", a.gameHour ".$sort.", a.gameTime ".$sort.", league_name, a.home_team, a.special, a.sn asc " .$limit.") as tb_temp left join tb_markets on tb_temp.betting_type = tb_markets.mid" ;
		} else {
			$sql = "select tb_temp.*, tb_markets.mname_ko, tb_markets.mid, tb_markets.mfamily from (select a.sn as child_sn, a.parent_sn, a.sport_name, a.sport_id, a.home_team, a.away_team, a.home_score, a.away_score, a.league_sn,
							a.gameDate, a.gameHour, a.gameTime, a.notice as league_name, a.win_team,a.kubun, a.parsing_site, a.user_view_flag,
							a.type, a.special, a.bet_money, b.home_name, b.home_line,
							b.sn, b.betting_type, b.home_rate, b.draw_rate, b.away_rate, b.win, b.result, b.sub_home_score, b.sub_away_score, 
							b.update_enable, a.is_update_date, b.new_home_rate, b.new_draw_rate, b.new_away_rate
					from ".$this->db_qz."child a, ".$this->db_qz."subchild b 
					where a.sn=b.child_sn and a.view_flag = '1' ".$where."
					order by a.gameDate ".$sort.", a.gameHour ".$sort.", a.gameTime ".$sort.", league_name, a.home_team, a.special, a.sn asc " .$limit.") as tb_temp left join tb_markets on tb_temp.betting_type = tb_markets.mid";
		}
		// echo $sql;
		// exit;
		return $this->db->exeSql($sql);
	}

	//▶ 게임 목록
	public function getMultiList($page, $page_size, $state=''/*kubun*/, $category='', $gameType='', $beginDate='', $endDate='', $minBettingMoney='', $leagueSn='', $homeTeam='', $awayTeam='', $bettingEnable='', $parsingType='ALL', $modifyFlag='')
	{
		if ( $parsingType != "ALL" ) $where=" and a.parsing_site = '".$parsingType."'";
		$sort='asc';
		
		if($state!='') 
		{
			if($state==1) 			{$where .=" and b.kubun=1";$sort='desc';}
			else if($state==2) 	$where .=" and b.kubun=0";
			else if($state==3) 	$where .= " and b.kubun is null";
			else if($state==4) 	$where .= " and (b.kubun is null || b.kubun=0)";
		}
		
		if($category!='') 
			$where.=" and a.sport_name='".$category."'";

		if ( $gameType != '' ) {
			$where.=" and b.betting_type='".$gameType."'";
		}

		if($beginDate!='' && $endDate!='') 
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) between '".$beginDate."' and '".$endDate." 23:59:59'";
			
		if($bettingEnable=='1')
		{
			$now = date("Y-m-d H:i:s");
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) >= '".$now."'";
		}
		else if($bettingEnable=='-1')
		{
			$now = date("Y-m-d H:i:s");
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) <= '".$now."'";
		}
			
		if($minBettingMoney!='')
			$where .=" and c.total_money >= ".$minBettingMoney;
			
		if($leagueSn!='') 
		{
			if(!is_array($leagueSn))
			{
				$where.=" and a.league_sn=".$leagueSn;
			}
			else
			{
				$where.=" and a.league_sn in(";
				for($i=0; $i<count((array)$leagueSn); ++$i)
				{
					if($i==0)	$where.=$leagueSn[$i];
					else			$where.=",".$leagueSn[$i];
				}
				$where.=")";
			}
		}
		if($homeTeam!='') 
			$where.=" and a.home_team like('%".$homeTeam."%')";
			
		if($awayTeam!='')
			$where.=" and a.away_team like('%".$awayTeam."%')";

		if($modifyFlag===0)
			$where.=" and b.update_enable = 0";

		if($page_size > 0)
			$limit = "limit ".$page.",".$page_size;
		
		if($minBettingMoney!='')
		{	
			$sql = "select a.sn as child_sn, a.sport_name, a.home_team, a.away_team, a.home_score, a.away_score, a.league_sn,
								a.home_half_time_score, a.away_half_time_score, a.home_2nd_half_time_score, a.away_2nd_half_time_score, 
								a.home_full_time_score, a.away_full_time_score, a.home_over_time_score, a.away_over_time_score, 
								a.home_1_time_score, a.away_1_time_score, a.home_2_time_score, a.away_2_time_score, 
								a.home_3_time_score, a.away_3_time_score, a.home_4_time_score, a.away_4_time_score, 
								a.home_5_time_score, a.away_5_time_score, a.home_6_time_score, a.away_6_time_score, 
								a.home_7_time_score, a.away_7_time_score, a.home_8_time_score, a.away_8_time_score, a.home_9_time_score, a.away_9_time_score,
								a.gameDate, a.gameHour, a.gameTime, a.notice, a.win_team, b.kubun, a.parsing_site, b.user_view_flag,
								a.special, b.bet_money, c.name as league_name, c.alias_name, b.point,
								b.sn, b.child_sn, b.betting_type, b.home_rate, b.draw_rate, b.away_rate, b.win, b.result,
								b.update_enable, a.is_update_date, b.new_home_rate, b.new_draw_rate, b.new_away_rate
							from ".$this->db_qz."child_m a, ".$this->db_qz."league c, ".$this->db_qz."subchild_m b left outer join
								(select sum(betting_money) as total_money, sub_child_sn
								from ".$this->db_qz."total_cart c, ".$this->db_qz."total_betting d
								where c.betting_no=d.betting_no and c.is_account=1 
								group by sub_child_sn) as c on b.sn=c.sub_child_sn
							where a.sn=b.child_sn and a.league_sn=c.sn and b.view_flag = '1' ".$where."
							order by a.gameDate ".$sort.", a.gameHour ".$sort.", a.gameTime ".$sort.", league_name, a.home_team, a.special, b.betting_type, b.point, a.sn asc " .$limit;
		} else {
			$sql = "select a.sn as child_sn, a.sport_name, a.home_team, a.away_team, a.home_score, a.away_score, a.league_sn,
								a.home_half_time_score, a.away_half_time_score, a.home_2nd_half_time_score, a.away_2nd_half_time_score, 
								a.home_full_time_score, a.away_full_time_score, a.home_over_time_score, a.away_over_time_score, 
								a.home_1_time_score, a.away_1_time_score, a.home_2_time_score, a.away_2_time_score, 
								a.home_3_time_score, a.away_3_time_score, a.home_4_time_score, a.away_4_time_score, 
								a.home_5_time_score, a.away_5_time_score, a.home_6_time_score, a.away_6_time_score, 
								a.home_7_time_score, a.away_7_time_score, a.home_8_time_score, a.away_8_time_score, a.home_9_time_score, a.away_9_time_score,
								a.gameDate, a.gameHour, a.gameTime, a.notice, a.win_team, b.kubun, a.parsing_site, b.user_view_flag,
								a.special, b.bet_money, c.name as league_name, c.alias_name, b.point,
								b.sn, b.child_sn, b.betting_type, b.home_rate, b.draw_rate, b.away_rate, b.win, b.result,
								b.update_enable, a.is_update_date, b.new_home_rate, b.new_draw_rate, b.new_away_rate
							from ".$this->db_qz."child_m a, ".$this->db_qz."subchild_m b, ".$this->db_qz."league c
							where a.sn=b.child_sn and a.league_sn=c.sn and b.view_flag = '1' ".$where."
							order by a.gameDate ".$sort.", a.gameHour ".$sort.", a.gameTime ".$sort.", league_name, a.home_team, a.special, b.betting_type, b.point, a.sn asc " .$limit;
		}
		return $this->db->exeSql($sql);
	}

	//▶ 게임 목록
	public function getFixtureList($page, $page_size, $state=''/*kubun*/, $category='', $beginDate='', $endDate='', $leagueSn='', $homeTeam='', $awayTeam='', $bettingEnable='', $parsingType='ALL')
	{
		date_default_timezone_set("Asia/Seoul");

		if ( $parsingType != "ALL" ) $where=" and a.parsing_site = '".$parsingType."'";
		$sort='asc';
		
		if($state!='') 
		{
			if($state==1) 			{$where .=" and a.kubun=1";$sort='desc';}
			else if($state==2) 	$where .=" and a.kubun=0";
			else if($state==3) 	$where .= " and a.kubun is null";
			else if($state==4) 	$where .= " and (a.kubun is null || a.kubun=0)";
		}
		
		if($category!='') 
			$where.=" and a.sport_name='".$category."'";

		$where.=" and a.special < 5 and a.kubun = 0 and a.status = 1 ";

		if($beginDate !='' && $endDate !='') 
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) between '".$beginDate."' and '".$endDate." 23:59:59'";
			
		if($bettingEnable=='1')
		{
			$now = date("Y-m-d H:i:s");
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) >= '".$now."'";
		}
		else if($bettingEnable=='-1')
		{
			$now = date("Y-m-d H:i:s");
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) <= '".$now."'";
		}
			
		if($leagueSn!='') 
		{
			if(!is_array($leagueSn))
			{
				$where.=" and a.league_sn=".$leagueSn;
			}
			else
			{
				$where.=" and a.league_sn in(";
				for($i=0; $i<count((array)$leagueSn); ++$i)
				{
					if($i==0)	$where.=$leagueSn[$i];
					else			$where.=",".$leagueSn[$i];
				}
				$where.=")";
			}
		}
		if($homeTeam!='') 
			$where.=" and a.home_team like('%".$homeTeam."%')";
			
		if($awayTeam!='')
			$where.=" and a.away_team like('%".$awayTeam."%')";

		if($page_size > 0)
			$limit = "limit ".$page.",".$page_size;

		$sql = "select tbl_temp.* from (select  a.sn as child_sn, a.parent_sn, a.sport_name, a.home_team, a.away_team, a.home_score, a.away_score, a.league_sn,
						a.gameDate, a.gameHour, a.gameTime, a.notice as league_name, a.win_team,a.kubun, a.parsing_site, a.user_view_flag,
						a.type, a.special, a.bet_money, a.live
				from ".$this->db_qz."child a left join ".$this->db_qz."league b on a.league_sn = b.lsports_league_sn 
				where a.view_flag = '1' and (a.live = -1 or a.live = 1) and b.is_use = 1 ".$where."
				group by a.sn) tbl_temp
				order by tbl_temp.gameDate ".$sort.", tbl_temp.gameHour ".$sort.", tbl_temp.gameTime ".$sort.", tbl_temp.league_name, tbl_temp.home_team asc " .$limit;
		
		return $this->db->exeSql($sql);
	}

    public function getListofLive($page, $page_size, $state=''/*kubun*/, $category='', $gameType='', $specialType='', $beginDate='', $endDate='', $minBettingMoney='', $leagueSn='', $homeTeam='', $awayTeam='', $bettingEnable='', $parsingType='ALL', $modifyFlag='', $sort)
    {
        if ( $parsingType != "ALL" ) $where=" and a.parsing_site = '".$parsingType."'";
        //$sort='asc';

        if($state!='')
        {
            if($state==1) 			{$where .=" and a.kubun=1";$sort='desc';}
            else if($state==2) 	$where .=" and a.kubun=0";
            else if($state==3) 	$where .= " and a.kubun is null";
            else if($state==4) 	$where .= " and (a.kubun is null || a.kubun=0)";
        }

        if($category!='')
            $where.=" and a.sport_name='".$category."'";

        if ( $gameType == 24 ) {
            $where.=" and (a.type='2' or a.type='4')";
        } else if ( $gameType != '' ) {
            $where.=" and a.type='".$gameType."'";
        }

        if($specialType!=="")
        {
            $where.=" and a.special=".$specialType;
        } else {
            $where.=" and a.special in (2, 50)";
        }

        if($beginDate!='' && $endDate!='')
            $where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) between '".$beginDate."' and '".$endDate." 23:59:59'";

        if($bettingEnable=='1')
        {
            $now = date("Y-m-d H:i:s");
            $where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) >= '".$now."'";
        }
        else if($bettingEnable=='-1')
        {
            $now = date("Y-m-d H:i:s");
            $where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) <= '".$now."'";
        }

        if($minBettingMoney!='')
            $where .=" and c.total_money >= ".$minBettingMoney;

        if($leagueSn!='')
        {
            if(!is_array($leagueSn))
            {
                $where.=" and a.league_sn=".$leagueSn;
            }
            else
            {
                $where.=" and a.league_sn in(";
                for($i=0; $i<count((array)$leagueSn); ++$i)
                {
                    if($i==0)	$where.=$leagueSn[$i];
                    else			$where.=",".$leagueSn[$i];
                }
                $where.=")";
            }
        }
        if($homeTeam!='')
            $where.=" and a.home_team like('%".$homeTeam."%')";

        if($awayTeam!='')
            $where.=" and a.away_team like('%".$awayTeam."%')";

        if($modifyFlag===0)
            $where.=" and b.update_enable = 0";

        if($page_size > 0)
            $limit = "limit ".$page.",".$page_size;

        if($minBettingMoney!='')
        {
            $sql = "select a.sn as child_sn, a.parent_sn, a.sport_name, a.home_team, a.away_team, a.home_score, a.away_score, a.league_sn,
								a.gameDate, a.gameHour, a.gameTime, a.notice, a.win_team,a.kubun, a.parsing_site, a.user_view_flag,
								a.type, a.special, a.bet_money, c.name as league_name, c.alias_name,
								b.sn, b.child_sn, b.betting_type, b.home_rate, b.draw_rate, b.away_rate, b.win, b.result,
								b.update_enable, a.is_update_date, b.new_home_rate, b.new_draw_rate, b.new_away_rate
							from ".$this->db_qz."child a, ".$this->db_qz."league c, ".$this->db_qz."subchild b left outer join
							(select sum(betting_money) as total_money, sub_child_sn
								from ".$this->db_qz."total_cart c, ".$this->db_qz."total_betting d
								where c.betting_no=d.betting_no and c.is_account=1 
								group by sub_child_sn) as c on b.sn=c.sub_child_sn
							where a.sn=b.child_sn and a.league_sn=c.sn and a.view_flag = '1' ".$where."
							order by a.gameDate ".$sort.", a.gameHour ".$sort.", a.gameTime ".$sort.", league_name, a.home_team, a.special, a.type, a.sn asc " .$limit;
        } else {
            $sql = "select a.sn as child_sn, a.parent_sn, a.sport_name, a.home_team, a.away_team, a.home_score, a.away_score, a.league_sn,
								a.gameDate, a.gameHour, a.gameTime, a.notice, a.win_team,a.kubun, a.parsing_site, a.user_view_flag,
								a.type, a.special, a.bet_money, c.name as league_name, c.alias_name,
								b.sn, b.child_sn, b.betting_type, b.home_rate, b.draw_rate, b.away_rate, b.win, b.result,
								b.update_enable, a.is_update_date, b.new_home_rate, b.new_draw_rate, b.new_away_rate
							from ".$this->db_qz."child a, ".$this->db_qz."subchild b, ".$this->db_qz."league c
							where a.sn=b.child_sn and a.league_sn=c.sn and a.view_flag = '1' ".$where."
							order by a.gameDate ".$sort.", a.gameHour ".$sort.", a.gameTime ".$sort.", league_name, a.home_team, a.special, a.type, a.sn asc " .$limit;
        }
        return $this->db->exeSql($sql);
    }

	public function getMultiListofLive($page, $page_size, $state=''/*kubun*/, $category='', $gameType='', $specialType='', $beginDate='', $endDate='', $minBettingMoney='', $leagueSn='', $homeTeam='', $awayTeam='', $bettingEnable='', $parsingType='ALL', $modifyFlag='', $sort)
    {
        if ( $parsingType != "ALL" ) $where=" and a.parsing_site = '".$parsingType."'";
        //$sort='asc';

        if($state!='')
        {
            if($state==1) 			{$where .=" and b.kubun=1";$sort='desc';}
            else if($state==2) 	$where .=" and b.kubun=0";
            else if($state==3) 	$where .= " and b.kubun is null";
            else if($state==4) 	$where .= " and (b.kubun is null || b.kubun=0)";
        }

        if($category!='')
            $where.=" and a.sport_name='".$category."'";

		if ( $gameType != '' ) {
			$where.=" and b.betting_type='".$gameType."'";
		}
		

        if($specialType!=="")
        {
            $where.=" and a.special=".$specialType;
        } else {
            $where.=" and a.special in (2, 50)";
        }

        if($beginDate!='' && $endDate!='')
            $where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) between '".$beginDate."' and '".$endDate." 23:59:59'";

        if($bettingEnable=='1')
        {
            $now = date("Y-m-d H:i:s");
            $where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) >= '".$now."'";
        }
        else if($bettingEnable=='-1')
        {
            $now = date("Y-m-d H:i:s");
            $where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) <= '".$now."'";
        }

        if($minBettingMoney!='')
            $where .=" and c.total_money >= ".$minBettingMoney;

        if($leagueSn!='')
        {
            if(!is_array($leagueSn))
            {
                $where.=" and a.league_sn=".$leagueSn;
            }
            else
            {
                $where.=" and a.league_sn in(";
                for($i=0; $i<count((array)$leagueSn); ++$i)
                {
                    if($i==0)	$where.=$leagueSn[$i];
                    else			$where.=",".$leagueSn[$i];
                }
                $where.=")";
            }
        }
        if($homeTeam!='')
            $where.=" and a.home_team like('%".$homeTeam."%')";

        if($awayTeam!='')
            $where.=" and a.away_team like('%".$awayTeam."%')";

        if($modifyFlag===0)
            $where.=" and b.update_enable = 0";

        if($page_size > 0)
            $limit = "limit ".$page.",".$page_size;

        if($minBettingMoney!='')
        {
            $sql = "select a.sn as child_sn, a.sport_name, a.home_team, a.away_team, a.home_score, a.away_score, a.league_sn,
								a.gameDate, a.gameHour, a.gameTime, a.notice, a.win_team,b.kubun, a.parsing_site, b.user_view_flag,
								a.special, b.bet_money, c.name as league_name, c.alias_name,
								b.sn, b.child_sn, b.betting_type, b.home_rate, b.draw_rate, b.away_rate, b.win, b.result,
								b.update_enable, a.is_update_date, b.new_home_rate, b.new_draw_rate, b.new_away_rate
							from ".$this->db_qz."child_m a, ".$this->db_qz."league c, ".$this->db_qz."subchild_m b left outer join
							(select sum(betting_money) as total_money, sub_child_sn
								from ".$this->db_qz."total_cart c, ".$this->db_qz."total_betting d
								where c.betting_no=d.betting_no and c.is_account=1 
								group by sub_child_sn) as c on b.sn=c.sub_child_sn
							where a.sn=b.child_sn and a.league_sn=c.sn and b.view_flag = '1' ".$where."
							order by a.gameDate ".$sort.", a.gameHour ".$sort.", a.gameTime ".$sort.", league_name, a.home_team, a.special, b.betting_type, a.sn asc " .$limit;
        } else {
            $sql = "select a.sn as child_sn, a.sport_name, a.home_team, a.away_team, a.home_score, a.away_score, a.league_sn,
								a.gameDate, a.gameHour, a.gameTime, a.notice, a.win_team, b.kubun, a.parsing_site, b.user_view_flag,
								a.special, b.bet_money, c.name as league_name, c.alias_name,
								b.sn, b.child_sn, b.betting_type, b.home_rate, b.draw_rate, b.away_rate, b.win, b.result,
								b.update_enable, a.is_update_date, b.new_home_rate, b.new_draw_rate, b.new_away_rate
							from ".$this->db_qz."child_m a, ".$this->db_qz."subchild_m b, ".$this->db_qz."league c
							where a.sn=b.child_sn and a.league_sn=c.sn and b.view_flag = '1' ".$where."
							order by a.gameDate ".$sort.", a.gameHour ".$sort.", a.gameTime ".$sort.", league_name, a.home_team, a.special, b.betting_type, a.sn asc " .$limit;
        }
        return $this->db->exeSql($sql);
    }

    public function getList_simple($page, $page_size, $state=''/*kubun*/, $category='', $gameType='', $specialType='', $beginDate='', $endDate='', $minBettingMoney='', $leagueSn='', $homeTeam='', $awayTeam='', $bettingEnable='', $parsingType='ALL', $modifyFlag='')
    {
        if ( $parsingType != "ALL" ) $where=" and a.parsing_site = '".$parsingType."'";
        $sort='asc';

        if($state!='')
        {
            if($state==1) 			{$where .=" and a.kubun=1";$sort='desc';}
            else if($state==2) 	$where .=" and a.kubun=0";
            else if($state==3) 	$where .= " and a.kubun is null";
            else if($state==4) 	$where .= " and (a.kubun is null || a.kubun=0)";
        }

        if($category!='')
            $where.=" and a.sport_name='".$category."'";

        if ( $gameType == 24 ) {
            $where.=" and (a.type='2' or a.type='4')";
        } else if ( $gameType != '' ) {
            $where.=" and a.type='".$gameType."'";
        }

        if($specialType!=="")
        {
            switch($specialType)
            {
                case '1': $where.=" and a.special=0";  break;
                case '2': $where.=" and a.special=1";  break;
                case '4': $where.=" and a.special=2";  break;
                case '5': $where.=" and a.special=3";  break;
                case '6': $where.=" and a.special=4";  break;
                case '7': $where.=" and a.special=5";  break;
                case '8': $where.=" and a.special=6";  break;
                case '9': $where.=" and a.special=7";  break;
                case '22': $where.=" and a.special=22";  break;
                case '26': $where.=" and a.special=26";  break;
                case '27': $where.=" and a.special=27";  break;
                case '28': $where.=" and a.special=28";  break;
                case '29': $where.=" and a.special=29";  break;
            }
        }

        //-> 사다리 외 검색시 사다리는 제외.
        if ($specialType != 5) {
            $where.=" and a.special != 3";
        }
        //-> 달팽이 외 검색시 달팽이는 제외.
        if ($specialType != 6) {
            $where.=" and a.special != 4";
        }
        //-> 파워볼 외 검색시 파워볼 제외.
        if ($specialType != 7) {
            $where.=" and a.special != 5";
        }
        //-> 다리다리 외 검색시 동전게임은 제외.
        if ($specialType != 8) {
            $where.=" and a.special != 6";
        }
        //-> 리얼20장 외 검색시 리얼20장은 제외.
        if ($specialType != 9) {
            $where.=" and a.special != 9";
        }

        if($beginDate!='' && $endDate!='')
            $where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) between '".$beginDate."' and '".$endDate." 23:59:59'";

        if($bettingEnable=='1')
        {
            $now = date("Y-m-d H:i:s");
            $where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) >= '".$now."'";
        }
        else if($bettingEnable=='-1')
        {
            $now = date("Y-m-d H:i:s");
            $where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) <= '".$now."'";
        }

        if($minBettingMoney!='')
            $where .=" and c.total_money >= ".$minBettingMoney;

        if($leagueSn!='')
        {
            if(!is_array($leagueSn))
            {
                $where.=" and a.league_sn=".$leagueSn;
            }
            else
            {
                $where.=" and a.league_sn in(";
                for($i=0; $i<count((array)$leagueSn); ++$i)
                {
                    if($i==0)	$where.=$leagueSn[$i];
                    else			$where.=",".$leagueSn[$i];
                }
                $where.=")";
            }
        }
        if($homeTeam!='')
            $where.=" and a.home_team like('%".$homeTeam."%')";

        if($awayTeam!='')
            $where.=" and a.away_team like('%".$awayTeam."%')";

        if($modifyFlag===0)
            $where.=" and b.update_enable = 0";

        if($page_size > 0)
            $limit = "limit ".$page.",".$page_size;

        if($minBettingMoney!='')
        {
            $sql = "select a.sn as child_sn
							from ".$this->db_qz."child a, ".$this->db_qz."league c, ".$this->db_qz."subchild b left outer join
							(select sum(betting_money) as total_money, sub_child_sn
								from ".$this->db_qz."total_cart c, ".$this->db_qz."total_betting d
								where c.betting_no=d.betting_no and c.is_account=1 
								group by sub_child_sn) as c on b.sn=c.sub_child_sn
							where a.sn=b.child_sn and a.league_sn=c.sn and a.view_flag = '1' ".$where.$limit;
        } else {
            $sql = "select a.sn as child_sn
							from ".$this->db_qz."child a, ".$this->db_qz."subchild b, ".$this->db_qz."league c
							where a.sn=b.child_sn and a.league_sn=c.sn and a.view_flag = '1' ".$where.$limit;
        }
        return $this->db->exeSql($sql);
    }
	
	//▶ 최건경기순 경기목록
	public function getList_asc($page, $page_size, $state=''/*kubun*/, $category='', $gameType='', $specialType='', $beginDate='', $endDate='', $minBettingMoney='', $leagueSn='', $homeTeam='', $awayTeam='', $bettingEnable='', $selectType = '')
	{
		$where='';
		
		if($state!='') 
		{
			if($state==1) 			$where=" and a.kubun=1";
			else if($state==2) 	$where=" and a.kubun=0";
			else if($state==3) 	$where = " and a.kubun is null";
			else if($state==4) 	$where = " and (a.kubun is null || a.kubun=0)";
		}
		
		if($category!='') 
			$where.=" and a.sport_name='".$category."'";
		if($gameType!='')	
			$where.=" and a.type='".$gameType."'";
			
		if($specialType!=="")	
		{
			switch($specialType)
			{
			case '1': $where.=" and a.special=0";  break; 
			case '2': $where.=" and a.special=1";  break; 
			case '4': $where.=" and a.special=2";  break; 			
			}
		}
		if($beginDate!='' && $endDate!='') 
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) between '".$beginDate."' and '".$endDate." 23:59:59'";
			
		if($bettingEnable=='1')
		{
			$now = date("Y-m-d H:i:s");
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) >= '".$now."'";
		}
		else if($bettingEnable=='-1')
		{
			$now = date("Y-m-d H:i:s");
			$where.=" and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) <= '".$now."'";
		}
			
		if($minBettingMoney!='')
			$where .=" and c.total_money >= ".$minBettingMoney;
			
		if($leagueSn!='') 
		{
			if(!is_array($leagueSn))
			{
				$where.=" and a.league_sn=".$leagueSn;
			}
			else
			{
				$where.=" and a.league_sn in(";
				for($i=0; $i<count((array)$leagueSn); ++$i)
				{
					if($i==0)	$where.=$leagueSn[$i];
					else			$where.=",".$leagueSn[$i];
				}
				$where.=")";
			}
		}
		if($homeTeam!='') 
			$where.=" and a.home_team like('%".$homeTeam."%')";
			
		if($awayTeam!='')
			$where.=" and a.away_team like('%".$awayTeam."%')";
		
		if($page_size > 0)
			$limit = "limit ".$page.",".$page_size;
	
		if ( $selectType == 1 ) {
			$sql = "select a.sn as child_sn, a.parent_sn, a.sport_name, a.home_team, a.away_team, a.home_score, a.away_score,
								a.gameDate, a.gameHour, a.gameTime, a.notice, a.win_team,a.kubun,
								a.type, a.special, a.bet_money, (select name from ".$this->db_qz."league where sn=a.league_sn) as league_name,
								b.sn, b.child_sn, b.betting_type, b.home_rate, b.draw_rate, b.away_rate, b.win, b.result
							from ".$this->db_qz."child a, ".$this->db_qz."subchild b
							where a.sn=b.child_sn ".$where."
							order by a.gameDate desc, a.gameHour desc, a.gameTime desc, league_name, a.home_team, a.special, a.type, a.sn asc ".$limit;
		} else {
			$sql = "select a.sn as child_sn, a.parent_sn, a.sport_name, a.home_team, a.away_team, a.home_score, a.away_score,
								a.gameDate, a.gameHour, a.gameTime, a.notice, a.win_team,a.kubun,
								a.type, a.special, a.bet_money, (select name from ".$this->db_qz."league where sn=a.league_sn) as league_name,
								b.sn, b.child_sn, b.betting_type, b.home_rate, b.draw_rate, b.away_rate, b.win, b.result
							from ".$this->db_qz."child a, ".$this->db_qz."subchild b left outer join
							(select sum(betting_money) as total_money, sub_child_sn
								from ".$this->db_qz."total_cart c, ".$this->db_qz."total_betting d
								where c.betting_no=d.betting_no and c.is_account=1 and logo='".$this->logo."'
								group by sub_child_sn) as c on b.sn=c.sub_child_sn
							where a.sn=b.child_sn ".$where."
							order by a.gameDate desc, a.gameHour desc, a.gameTime desc, league_name, a.home_team, a.special, a.type, a.sn asc ".$limit;
		}
					

		return $this->db->exeSql($sql);
	}
	
	//▶ 한경기에대한 게임 목록	
	public function getListBychild_sn($child_sn)
	{
		$sql = "select a.sn as child_sn,a.parent_sn,a.sport_name,a.home_team,a.away_team,a.home_score,a.away_score,
						a.gameDate,a.gameHour,a.gameTime,a.notice,a.win_team,a.kubun,
						a.type,a.special,a.bet_money,(select name from ".$this->db_qz."league where sn=a.league_sn) as league_name,
						b.sn,b.child_sn,b.betting_type,b.home_rate,b.draw_rate,b.away_rate,b.win,b.result
						from ".$this->db_qz."child a,".$this->db_qz."subchild b
						where a.sn=b.child_sn and b.child_sn=".$child_sn;
						

		return $this->db->exeSql($sql);
	}
	
	//▶ TOP 5 게임 목록
	public function getTopList()
	{
		$cartModel 	= Lemon_Instance::getObject("CartModel",true);
		$beginDate	= date("Y-m-d",strtotime ("-1 days"))." 00:00:00";
		$endDate 		= date("Y-m-d",strtotime ("+1 days"))." 23:59:59";
		
		$sql = "select a.sn as child_sn, a.parent_sn, a.sport_name, a.league_sn, a.home_team, sum(d.betting_money) as total_money,
						a.home_score, a.away_team, a.away_score, a.win_team,a.handi_winner, a.gameDate, a.gameHour,
						a.type, a.gameTime, a.special, a.kubun, b.sn as subchild_sn, b.betting_type, b.home_rate, b.draw_rate, b.away_rate, c.betting_no,
						c.select_no, c.select_rate, c.game_type, c.event, c.result, d.result as bet_result, d.betting_money, d.is_account,
						(select name from ".$this->db_qz."league where sn=a.league_sn) as league_name
						from ".$this->db_qz."child a
							  inner join ".$this->db_qz."subchild b on a.sn=b.child_sn
							  inner join ".$this->db_qz."total_betting c on b.sn=c.sub_child_sn
							  inner join ".$this->db_qz."total_cart d on c.betting_no=d.betting_no 
						where is_account=1 and d.result=0 and c.result=0 and concat(a.gameDate,' ', a.gameHour,':', a.gameTime) between '".$beginDate."' and '".$endDate."' 
						group by child_sn, select_no order by total_money limit 0,5";
		$rs = $this->db->exeSql($sql);
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			if($rs[$i]['child_sn']!=null)
			{
				$item = $cartModel->getTeamTotalBetMoney($rs[$i]['child_sn']);
				
				$rs[$i]['home_total_betting'] = $item['home_total_betting'];
				$rs[$i]['active_home_total_betting'] = $item['active_home_total_betting'];
				$rs[$i]['home_count'] = $item['home_count'];
				
				$rs[$i]['draw_total_betting'] = $item['draw_total_betting'];
				$rs[$i]['active_draw_total_betting'] = $item['active_draw_total_betting'];
				$rs[$i]['draw_count'] = $item['draw_count'];
				
				$rs[$i]['away_total_betting'] = $item['away_total_betting'];
				$rs[$i]['active_away_total_betting'] = $item['active_away_total_betting'];
				$rs[$i]['away_count'] = $item['away_count'];
				
				$rs[$i]['total_betting'] = $item['home_total_betting']+$item['draw_total_betting']+$item['away_total_betting'];
				$rs[$i]['betting_count'] = $item['home_count']+$item['draw_count']+$item['away_count'];
				$arr[]=$rs[$i];
			}
		}
				
		return $arr;
	}
	
	function isGameExist($gameType, $specialType, $homeTeam, $awayTeam, $gameDate, $gameHour, $gameTime)
	{
		$sql = "select count(*) as cnt
						from ".$this->db_qz."child
						where 	home_team='".$homeTeam."'
							and away_team='".$awayTeam."'
							and gameDate='".$gameDate."'
							and gameHour='".$gameHour."'
							and gameTime='".$gameTime."'
							and type=".$gameType."
							and special=".$specialType;
		$rs = $this->db->exeSql($sql);
		if($rs[0]['cnt']>0) return 1;
		return 0;
	}

	// 다기준
	function isGameExistMulti($gameType, $specialType, $homeTeam, $awayTeam, $gameDate, $gameHour, $gameTime)
	{
		$sql = "select count(*) as cnt
				from ".$this->db_qz."child_m a, ".$this->db_qz."subchild_m b
				where 	a.home_team='".$homeTeam."'
					and a.away_team='".$awayTeam."'
					and a.gameDate='".$gameDate."'
					and a.gameHour='".$gameHour."'
					and a.gameTime='".$gameTime."'
					and b.betting_type=".$gameType;
		$rs = $this->db->exeSql($sql);
		if($rs[0]['cnt']>0) return 1;
		return 0;
	}
	
	//▶ 차일드 목록 (원기준)
	function getChildRow($sn, $field='*', $addWhere='')
	{
		$where = " sn=".$sn;
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		$item = $this->getRow($field, $this->db_qz.'child', $where);

		if(isset($item))
        {
            $item['home_team'] = strip_tags(html_entity_decode($item['home_team']));
            $item['away_team'] = strip_tags(html_entity_decode($item['away_team']));
        }

		return $item;
	}

	//▶ 차일드 목록 (다기준)
	function getChildRowMulti($sn, $field='*', $addWhere='')
	{
		$where = " and b.sn=".$sn;
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		$sql = "select a.*, b.*, b.sn as subchild_sn from ".$this->db_qz."child a, ".$this->db_qz."subchild b
				where a.sn = b.child_sn " . $where;

		$item = $this->db->exeSql($sql);

		if(count($item) > 0)
        {
            $item[0]['home_team'] = strip_tags(html_entity_decode($item[0]['home_team']));
            $item[0]['away_team'] = strip_tags(html_entity_decode($item[0]['away_team']));
        }

		return $item[0];
	}

	//▶ 차일드 목록
	function getChildField($sn, $field, $addWhere='')
	{
		$where = " sn=".$sn;
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		$rs = $this->getRow($field, $this->db_qz.'child', $where);
		
		return $rs[$field];
	}

	// 서브챠일드 아이디로부터 챠일드 아이디 얻기
	function getChildSn($subchildSn = 0)
	{
		$sql = "SELECT child_sn FROM tb_subchild WHERE sn = " . $subchildSn;
		$res = $this->db->exeSql($sql);
		$childSn = 0;

		if(count((array)$res) > 0)
			$childSn = $res[0]["child_sn"];

		return $childSn;
	}
	
	//▶ 차일드 목록
	function getChildRows($sn, $field='*', $addWhere='')
	{
		$where = " sn=".$sn;
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		return $this->getRows($field, $this->db_qz.'child', $where);
	}
	
	//▶ 차일드,서브차일드 목록
	function getChildJoinSubChild($childSn)
	{
		$sql = "select a.*, b.home_rate, b.draw_rate, b.away_rate, b.win from ".$this->db_qz."child a, ".$this->db_qz."subchild b
						where a.sn='".$childSn."'  and a.sn=b.child_sn";
		return $this->db->exeSql($sql);
	}

	//▶ 차일드,서브차일드 목록 (다기준)
	function getChildJoinSubChildMulti($subchildSn)
	{
		$sql = "select a.*, b.sn as subchild_sn, b.home_rate, b.draw_rate, b.away_rate, b.win, b.betting_type, b.view_flag, b.user_view_flag, b.kubun from ".$this->db_qz."child_m a, ".$this->db_qz."subchild_m b
						where b.sn='".$subchildSn."'  and a.sn=b.child_sn";
		return $this->db->exeSql($sql);
	}

	//▶ 경기 목록(회차)
	function getGameList($parentIdx, $addWhere='')
	{
		$where=" where parent_sn=".$parentIdx;
		if($addWhere!='') {$where.=" and ".$addWhere;}
		
		$sql = "select * 
				from ".$this->db_qz."child".$where;
				
		return $this->db->exeSql($sql);
	}
	
	//▶ 경기 추가
	function add7mGame($parentIdx, $game_num_temp, $league_num_temp, $leagueSn,
						$team1_name_temp, $team2_name_temp, $game_date_temp, $game_hours_temp, $game_minute_temp,
						$kubun, $type, $special, $gameType)
	{
		$sql = "insert into ".$this->db_qz."child (" ;
		$sql = $sql ." parent_sn,sport_name,league_sn,home_team,away_team," ;
		$sql = $sql ." gameDate, gameHour,gameTime,kubun,type,special,bet_money)" ;
		$sql = $sql . " values(";
		$sql = $sql . "'" . $parentIdx . "'," ;
		$sql = $sql . "'" . "축구" ."',"  ;
		$sql = $sql . "'" . $league_num_temp . "'," ;  // '리그고유번호
		$sql = $sql . "'" . $leagueSn . "'," ;    // '리그번호
		$sql = $sql . "'" . $team1_name_temp . "'," ;        //'홈팀이름
		$sql = $sql . "'" . $team2_name_temp . "'," ;        //'원정팀이름
		$sql = $sql . "'" . $game_date_temp . "'," ;   // '게임시간(날자)
		$sql = $sql . "'" . $game_hours_temp . "'," ;   //'게임시간(시)
		$sql = $sql . "'" . $game_minute_temp . "'," ;  // '게임시간(분)
		$sql = $sql . "'',".$kubun.",";
		$sql = $sql . "'" . $type . "',";
		$sql = $sql . "'" . $special . "'," ;
		$sql = $sql . "'0')";
		
		$childIdx = $this->db->exeSql($sql);
		
		$rate1_temp = 0;
		$rate2_temp = 0;
		$rate3_temp = 0;

		if($childIdx>0)
		{
			$sql = "insert into ".$this->db_qz."subchild (" ;
			$sql = $sql ." child_sn, betting_type, home_rate, draw_rate,away_rate)" ;
			$sql = $sql . " values("  ;	
			$sql = $sql . "'" . $childIdx . "','". $gameType ."',";	//'베팅타입
			$sql = $sql . "'" . $rate1_temp . "',";
			$sql = $sql . "'" . $rate2_temp . "',";
			$sql = $sql . "'" . $rate3_temp . "')";
			$this->db->exeSql($sql);
		}
	}
	
	function modifyGameTime($childSn)
	{
		$nowDate=date('Y-m-d');
		$nowHour=date('H');
		$nowTime=date('i');

		$sql = "update ".$this->db_qz."child set gameDate = '".$nowDate."', gameHour='".$nowHour."', gameTime='".$nowTime."' where sn in (".$childSn.")";
		$this->db->exeSql($sql);
	}

	function modifyGameTimeMulti($subchildSn)
	{
		$nowDate=date('Y-m-d');
		$nowHour=date('H');
		$nowTime=date('i');

		$sql = "UPDATE ".$this->db_qz."child_m a LEFT JOIN ".$this->db_qz."subchild_m b ON a.sn = b.child_sn SET a.gameDate = '".$nowDate."', a.gameHour='".$nowHour."', a.gameTime='".$nowTime."' where b.sn in (".$subchildSn.")";
		$this->db->exeSql($sql);
	}

	//-> 발매하지 않은 경기중 시간이 지난 게임은 view_flag = 0 처리 한다. (숨긴다)
	function hideTimeOverGame($s_type = 0) {
		$hDate = date("Y-m-d H:i:s",time());
		if($s_type == "2") {
			$sql = "update ".$this->db_qz."child_m a LEFT JOIN ".$this->db_qz."subchild_m b ON a.sn = b.child_sn SET b.view_flag = 0 where concat(a.gameDate,' ', a.gameHour,':', a.gameTime) < '".$hDate."' and b.kubun = 0";
		} else {
			$sql = "update ".$this->db_qz."child set view_flag = 0 where concat(gameDate,' ',gameHour,':',gameTime) < '".$hDate."' and kubun is null and special not in (2, 50)";
		}
		
		$this->db->exeSql($sql);
	}

	//-> childSn로 해당 리그정보 가져오기.
	function getLeagueInfo($childSn) {
		$sql = "select a.home_team, b.* from ".$this->db_qz."child a, ".$this->db_qz."league b where a.sn='".$childSn."' and a.league_sn=b.sn";
		return $this->db->exeSql($sql);
	}

	//-> 게임날짜, 게임코드, 게임회차로 경기 찾기.
	function getMinigameInfo($gameDate, $gameCode, $gameTh, $specialCode) {
		$sql = "select a.sn as child_sn, b.sn as subchild_sn, a.kubun, a.gameDate, a.gameHour, a.gameTime, a.parent_sn, b.home_rate, b.away_rate, b.draw_rate
						from tb_child a, tb_subchild b where a.sn = b.child_sn and a.special={$specialCode} and a.gameDate = '{$gameDate}' and a.game_code = '{$gameCode}' and a.game_th = '{$gameTh}'";
		return $this->db->exeSql($sql);
	}

	//-> 리얼20장미니게임 리그번호 가져오기.
	function getReal20LeagueSn() {
		$sql = "select sn from tb_league where name = '리얼20장미니게임' order by sn desc limit 1";
		$res = $this->db->exeSql($sql);
		return $res[0]["sn"];
	}

	//-> 20장미니게임 날짜+게임코드+회차 게임이 존재하는지
	function getReal20Check($gameDate, $gameCode, $gameTh) {
		$sql = "select sn from tb_child where gameDate = '{$gameDate}' and game_code = '{$gameCode}' and game_th = '{$gameTh}' and special = 9";
		$res = $this->db->exeSql($sql);
		return $res[0]["sn"];
	}

	//-> 20장미니게임 추가
	function insertReal20($leagueSn,$homeTeam,$awayTeam,$gameDate,$gameHour,$gameTime,$homeRate,$drawRate,$awayRate,$gameCode,$gameTh) {
		$sql = "insert into tb_child(sport_name, league_sn, home_team, away_team, gameDate, gameHour, gameTime, kubun, type, special, game_code, game_th) values (";
		$sql .= "'기타','{$leagueSn}','{$homeTeam}','{$awayTeam}','{$gameDate}','{$gameHour}','{$gameTime}','0','1','9','{$gameCode}','{$gameTh}');";
		$childSn = $this->db->exeSql($sql);	
		
		if ( $childSn <= 0 ) {
			return 0;
		}
		
		$sql = "insert into tb_subchild(child_sn, betting_type, home_rate, draw_rate, away_rate) values('{$childSn}','1','{$homeRate}','{$drawRate}','{$awayRate}')";				
		$subchildSn = $this->db->exeSql($sql);
		return $subchildSn;
	}

	function getPowerballTh()
	{
		$sql = "SELECT th FROM tb_powerball_result ORDER BY th DESC LIMIT 1";
		$res = $this->db->exeSql($sql);
		return $res[0]["th"] + 1;
	}

	//-> 미니게임 리그번호 가져오기. (공용)
	function getLeagueSn($gameName) {
        if ( $gameName == "sadari" ) $gameName = "네임드사다리";
        else if ( $gameName == "race" ) $gameName = "달팽이레이싱";
        else if ( $gameName == "powerball" ) $gameName = "파워볼";
        else if ( $gameName == "dari" ) $gameName = "네임드다리다리";
        else if ( $gameName == "powersadari" ) $gameName = "파워사다리";
        else if ( $gameName == "dograce" ) $gameName = "개경주";
        else if ( $gameName == "kenosadari" ) $gameName = "키노사다리";
        else if ( $gameName == "aladin" ) $gameName = "알라딘사다리";
        else if ( $gameName == "lowhi" ) $gameName = "로하이";
        else if ( $gameName == "mgmoddeven" ) $gameName = "CROWN홀짝";
        else if ( $gameName == "mgmbacara" ) $gameName = "CROWN바카라";
        else if ( $gameName == "vfootball" ) $gameName = "가상축구";
        else if ( $gameName == "powersadari1" ) $gameName = "파워사다리1";
        else if ( $gameName == "powersadari2" ) $gameName = "파워사다리2";
        else if ( $gameName == "kenosadari" ) $gameName = "키노사다리";
        else if ( $gameName == "2dari" ) $gameName = "2다리";
        else if ( $gameName == "3dari" ) $gameName = "3다리";
        else if ( $gameName == "choice" ) $gameName = "초이스";
        else if ( $gameName == "roulette" ) $gameName = "룰렛";
        else if ( $gameName == "nine" ) $gameName = "CROWN나인볼";
        else if ( $gameName == "pharaoh" ) $gameName = "파라오";
        else if ( $gameName == "fx1" ) $gameName = "FX1분";
        else if ( $gameName == "fx2" ) $gameName = "FX2분";
        else if ( $gameName == "fx3" ) $gameName = "FX3분";
        else if ( $gameName == "fx4" ) $gameName = "FX4분";
        else if ( $gameName == "fx5" ) $gameName = "FX5분";

		$sql = "select sn from tb_league where name = '{$gameName}' order by sn desc limit 1";
		$res = $this->db->exeSql($sql);
		return $res[0]["sn"];
	}

	//-> 미니게임 날짜+게임코드+회차 게임이 존재하는지 (공용)
	function getInCheck($gameName, $gameDate, $gameCode, $gameTh) {
		if ( $gameName == "sadari" ) $special = 5;
		else if ( $gameName == "race" ) $special = 6;
		else if ( $gameName == "powerball" ) $special = 7;
		else if ( $gameName == "dari" ) $special = 8;
        else if ( $gameName == "2dari" ) $special = 30;
        else if ( $gameName == "3dari" ) $special = 31;
        else if ( $gameName == "choice" ) $special = 32;
        else if ( $gameName == "roulette" ) $special = 33;
        else if ( $gameName == "nine" ) $special = 21;
        else if ( $gameName == "pharaoh" ) $special = 34;
        else if ( $gameName == "mgmbacara" ) $special = 26;
        else if ( $gameName == "mgmoddeven" ) $special = 27;
		else if ( $gameName == "powersadari" ) $special = 25;


		$sql = "select sn from tb_child where gameDate = '{$gameDate}' and game_code = '{$gameCode}' and game_th = '{$gameTh}' and special = '{$special}'";
		$res = $this->db->exeSql($sql);
		return $res[0]["sn"];
	}

	//-> 미니게임 추가 (공용)
	function insertMiniGame($leagueSn,$homeTeam,$awayTeam,$gameDate,$gameHour,$gameTime,$homeRate,$drawRate,$awayRate,$gameCode,$gameTh,$specialCode) {
		$sql = "insert into tb_child(sport_name, league_sn, home_team, away_team, gameDate, gameHour, gameTime, kubun, type, special, game_code, game_th) values (";
		$sql .= "'기타','{$leagueSn}','{$homeTeam}','{$awayTeam}','{$gameDate}','{$gameHour}','{$gameTime}','0','1','{$specialCode}','{$gameCode}','{$gameTh}');";
		$childSn = $this->db->exeSql($sql);			
		if ( $childSn <= 0 ) {
			return 0;
		}
		
		$sql = "insert into tb_subchild(child_sn, betting_type, home_rate, draw_rate, away_rate) values('{$childSn}','1','{$homeRate}','{$drawRate}','{$awayRate}')";				
		$subchildSn = $this->db->exeSql($sql);
		return $subchildSn;
	}

    function finishGame($league_sn)
    {
        $nowDate=date('Y-m-d');
        $nowHour=date('H');
        $nowTime=date('i');

        $sql = "update ".$this->db_qz."child set user_view_flag=0, gameDate = '".$nowDate."', gameHour='".$nowHour."', gameTime='".$nowTime."' 
                  where league_sn =".$league_sn." and  '".$nowDate."' <= gameDate ";
        $this->db->exeSql($sql);
    }

    function getRecentResult() {
        $sql = "select * from tbl_powerball order by round desc limit 288";
        return $this->db->exeSql($sql);
    }

    function getResult() {
        $sql = "select * from tbl_powerball order by round desc limit 1";
        return $this->db->exeSql($sql)[0];
    }
	
	//▶ 차일드 목록 (다기준)
	function getMultiChildRow($sn, $field='*', $addWhere='')
	{
		$where = " sn=".$sn;
		
		if($addWhere!='') {$where .=' and '.$addWhere;}
		
		$item = $this->getRow($field, $this->db_qz.'child', $where);

		if(isset($item))
        {
            $item['home_team'] = strip_tags(html_entity_decode($item['home_team']));
            $item['away_team'] = strip_tags(html_entity_decode($item['away_team']));
        }

		return $item;
	}

	//-> childSn로 해당 리그정보 가져오기.
	function getMultiLeagueInfo($childSn) {
		$sql = "select a.home_team, b.* from ".$this->db_qz."child a, ".$this->db_qz."league b where a.sn='".$childSn."' and a.league_sn=b.lsports_league_sn";
		return $this->db->exeSql($sql);
	}

	//-> 홈, 무, 어웨이 배당 가져오기.
	function getMultiRateInfo($sn) {
		$sql = "select b.home_rate, b.draw_rate, b.away_rate from tb_child a, tb_subchild b where a.sn = b.child_sn and a.sn = '{$sn}'";
		return $this->db->exeSql($sql);
	}
	
	// 해당 게임정보 가져오기 (다기준)
	function getGameDataMulti($subchildSn, $special) {
		$sql = "SELECT *, b.sn AS subchild_sn FROM tb_child a, tb_subchild b WHERE a.sn = b.child_sn AND b.sn = " . $subchildSn . " AND a.special = " . $special;
		$res = $this->db->exeSql($sql);
		return $res[0];
	}

	// 업데이트 라이브마당 
	function updateLiveField($child_sn = 0, $val = 0) {
		$sql = "UPDATE tb_child SET live = " . $val . " WHERE sn = " . $child_sn;
		$res = $this->db->exeSql($sql);
		return $res;
	}

	// 라이브경기 구독하기
	function orderFixture($child_sn) {
		$res = $this->updateLiveField($child_sn, -1);
		$this->updateOrderCnt(1);
		$result["msg"] = "라이브구독에 성공하였습니다.";
		$result["status"] = 1;
		if($res){
			$fixtureID = $this->getFixtureID($child_sn);
			$url = "http://175.125.95.163:3034/LSports/orderFixtures?" . $fixtureID;
			$resp = json_decode(file_get_contents($url));
			
			if(count($resp->Body->Ordered) == 0) {
				$this->updateLiveField($child_sn, 1);
				$this->updateOrderCnt(0);
				$result["msg"] = "해당 경기는 라이브배당을 제공하지 않습니다.";
				$result["status"] = 0;
			}
		}
		echo json_encode($result);
	}

	// 라이브경기 구독취소하기
	function cancelOrder($child_sn) {
		$res = $this->updateLiveField($child_sn, 1);
		$this->updateOrderCnt(0);
		$msg = "라이브구독을 취소하였습니다.";
		
		if($res){
			$fixtureID = $this->getFixtureID($child_sn);
			$url = "http://175.125.95.163:3034/LSports/cancelFixtures?" . $fixtureID;
			$resp = json_decode(file_get_contents($url));

			if(count($resp->Body->Cancelled) == 0) {
				$this->updateLiveField($child_sn, 1);
				$this->updateOrderCnt(1);
				$msg = "미안하지만 라이브구독취소에 실패하였습니다.";
			}
		}
		echo $msg;
	}

	function getFixtureID($child_sn) {
		$sql = "select tb_child.game_sn from tb_child where sn = " . $child_sn;
		$res = $this->db->exeSql($sql);
		$game_sn = 0;
		if(count((array)$res) > 0) {
			$game_sn = $res[0]["game_sn"];
		}
		return $game_sn;
	}

	function getMarketList($searchText) {
		$sql = "SELECT m.mid, m.mname_en, m.mname_ko, m.fRate FROM tb_markets m WHERE m.muse = 1";

		if($searchText != "") {
			$sql .= " and (m.mname_ko like '%" . $searchText . "%' or m.mname_en like '%" . $searchText . "%')";
		}
		
		return $this->db->exeSql($sql);
	}

	function getUpdateMarketRate($mid, $fRate) {
		$sql = "UPDATE tb_markets SET fRate = " . $fRate . " WHERE mid = " . $mid;
		$this->db->exeSql($sql);
	}

	function getMarketFamily() {
		$sql = "SELECT family_id, family_name FROM tb_market_family;";
		return $this->db->exeSql($sql);
	}

	function getCrossMarkets($sport_id = 0, $market_name = "") {
		$sql = "SELECT
					*
				FROM
					tb_cross_markets a
					LEFT JOIN tb_sports b
					ON a.sport_id = b.sn
					LEFT JOIN tb_markets c
					ON a.`market_id` = c.`mid`
				WHERE b.`use` = 1
					AND c.`muse` = 1 ";
					
		if($sport_id > 0)
			$sql .= " AND a.sport_id = " . $sport_id;

		if($market_name != "")
			$sql .= " AND c.mname_ko LIKE '%" . $market_name . "%'";

		$sql .= " ORDER BY b.nOrder,
					c.`mname_ko`;";

		return $this->db->exeSql($sql);
	}

	function getCrossLimitList() {
		$sql = "SELECT
					tb_cross_limit.*,
					tb_sports.`name` AS sport_name,
					tb_sports.nOrder
				FROM
					tb_cross_limit 
					LEFT JOIN tb_sports
					ON tb_cross_limit.sport_id = tb_sports.`sn`
				ORDER BY tb_cross_limit.type_id, tb_sports.nOrder, tb_cross_limit.cross_script;";
		return $this->db->exeSql($sql);
	}

	function getLimitScript($limit_id = 0) {
		$sql = "SELECT
					*
				FROM
					tb_cross_limit 
				WHERE	limit_id = " . $limit_id;

		$res = $this->db->exeSql($sql);

		$script = [];

		if(count((array)$res) > 0) {
			$script = $res[0];
		}

		return $script;
	}

	function getSportList() {
		$sql = "SELECT 
					tb_sports.*
				FROM 
					tb_sports
				WHERE 
					tb_sports.use = 1
				ORDER BY 
					tb_sports.nOrder;";

		$res = $this->db->exeSql($sql);

		return $res;
	}

	function saveCrossScript($limit_id = 0, $cross_script = "", $type_id = 0, $sport_id = 0) {
		if($limit_id == 0) {
			$sql = "INSERT INTO tb_cross_limit
							( 	
								type_id, 
								sport_id,
								cross_script
							)
							VALUES 
							(
								{$type_id},
								{$sport_id},
								'{$cross_script}'
							)";
		} else {
			$sql = "UPDATE 	tb_cross_limit
					SET		cross_script = '{$cross_script}',
							type_id = {$type_id},
							sport_id = {$sport_id}
					WHERE	limit_id = {$limit_id}";
		}
		$res = $this->db->exeSql($sql);
		return $res;
	}

	function deleteCrossScript($limit_id = 0) {
		$sql = "DELETE FROM tb_cross_limit WHERE limit_id = " . $limit_id;
		$res = $this->db->exeSql($sql);
		return $res;
	}

	function getTodayBettingCancelCnt($member_sn) {
		$sql = "SELECT COUNT(*) AS cancelCnt 
				FROM tb_total_cart_cancel 
				WHERE operdate BETWEEN CONCAT('" . date('Y-m-d') . "', ' 00:00:00') AND CONCAT('" . date('Y-m-d') . "', ' 23:59:59')
						AND member_sn = " . $member_sn;
		$res = $this->db->exeSql($sql);
		$cancelCnt = 0;
		if(count((array)$res) > 0)
			$cancelCnt = $res[0]["cancelCnt"];

		return $cancelCnt;
	}

	function existBettingResult($bettingNo) {
		$sql = "SELECT * FROM tb_total_betting WHERE betting_no = '" . $bettingNo . "'";
		$res = $this->db->exeSql($sql);
		$existResult = 0;
		if(count((array)$res) > 0) {
			foreach($res as $info) {
				if($info["result"] > 0) {
					$existResult = 1;
					break;
				}					
			}
		}
		return $existResult;
	}

	// 라이브구독개수 얻기
	function getLiveOrderCnt() {
		$sql = "SELECT orderCnt FROM tb_live_order";
		$res = $this->db->exeSql($sql);
		$cnt = 0;
		if(count((array)$res) > 0)
			$cnt = $res[0]["orderCnt"];
		
		return $cnt;
	}

	// 라이브구독개수 갱신
	function updateOrderCnt($flag = 0) {
		if($flag == 0) {
			$sql = "UPDATE tb_live_order SET orderCnt = orderCnt - 1";
		} else {
			$sql = "UPDATE tb_live_order SET orderCnt = orderCnt + 1";
		}
		$this->db->exeSql($sql);
	}

	function getFamilyID($market_id = 0) {
		$sql = "SELECT mfamily FROM tb_markets WHERE tb_markets.mid = " . $market_id;
		$family_id = 0;

		$r = $this->db->exeSql($sql);
		if(count((array)$r) > 0)
			$family_id = $r[0]["mfamily"];

		return $family_id;
	}
}
?>