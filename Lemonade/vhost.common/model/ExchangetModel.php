<?php

class ExchangetModel extends Lemon_Model
{
	/**
	 * GameListModel
	 *--------------------------------------------------------------------
	 *
	 * 게임 목록을 얻어 올때 사용되는 함수,
	 * _function 은 기본함수이며, 이 함수를 가지고 파생을 시켜,
	 * 중복을 피한다.
	 *
	 *--------------------------------------------------------------------
	 * Copyright (C) 
	 */

	//-> 파워볼 결과 목록
	public function getSaleInfoRow($betting_no) {
		$sql = "select * from tb_total_cart where betting_no={$betting_no}";
		$rs = $this->db->exeSql($sql);
		return $rs[0];
	}

    public function purchaseProcessImpl($betting_no, $purchaser_sn, $seller_sn, $sale_price)
    {
        $sql = "UPDATE tb_total_cart SET member_sn = ".$purchaser_sn.", sale_time=now()";
        $sql .= " WHERE betting_no = ".$betting_no."";
        $this->db->exeSql($sql);

        $sql = "UPDATE tb_total_betting SET member_sn = ".$purchaser_sn;
        $sql .= " WHERE betting_no = ".$betting_no."";
        $this->db->exeSql($sql);

        $sql = "UPDATE tb_member SET g_money = g_money -".$sale_price;
        $sql .= " WHERE sn = ".$purchaser_sn."";
        $this->db->exeSql($sql);

        $sql = "UPDATE tb_member SET g_money = g_money +".$sale_price;
        $sql .= " WHERE sn = ".$seller_sn."";
        $this->db->exeSql($sql);
    }

    public function saleProcessImpl($betting_no, $purchaser_sn, $seller_sn, $sale_price)
    {
        $sql = "UPDATE tb_total_cart SET seller_id = ".$seller_sn.", sale_reg_time=now(), sale_price=".$sale_price;
        $sql .= " WHERE betting_no = ".$betting_no."";
        $this->db->exeSql($sql);
    }

    public function cancelSaleProcessImpl($betting_no, $purchaser_sn, $seller_sn, $sale_price)
    {
        $sql = "UPDATE tb_total_cart SET sale_reg_time=null, sale_price=null, seller_id=null ";
        $sql .= " WHERE betting_no = ".$betting_no."";
        $this->db->exeSql($sql);
    }

	//▶ 게임목록
 	public function _gameList($where="", $orderby="", $page=0, $page_size=0)
	{
		$sql = "select a.sn as child_sn,a.sport_name,a.league_sn,a.home_team,a.home_score,a.away_team,a.away_score, a.game_code,
								a.win_team,a.handi_winner,a.gameDate,a.gameHour,a.gameTime,a.notice, a.kubun,a.type, a.special, a.is_specified_special,
								b.sn as league_sn, b.lg_img as league_image,b.name as league_name, b.nation_sn, b.alias_name, b.view_style, b.link_url,
								c.sn as sub_child_sn,c.betting_type,c.home_rate,c.draw_rate,c.away_rate, c.result as sub_child_result, c.win
						from ".$this->db_qz."child  a,".$this->db_qz."league b,".$this->db_qz."subchild c
						where a.view_flag = 1 and a.league_sn=b.sn and a.sn=c.child_sn ".$where;

		if($orderby!='')
			$sql.= " order by ".$orderby;
			
		if($page_size!=0)
			$sql.= " limit ".$page.",".$page_size;

		return $this->db->exeSql($sql);
	}

    public function _gameResult()
    {
        $sql = "select * from tb_child
                where (home_score is not null or home_score != '')
                and game_sn is not null
                and sport_name != '가상축구'
                group by home_team
                order by sn desc
                limit 10";
        return $this->db->exeSql($sql);
    }
    public function _gameList2($where="", $orderby="", $groupby ="", $page=0, $page_size=0)
    {
        $sql = "select a.sn as child_sn,a.sport_name,a.league_sn,a.home_team,a.home_score,a.away_team,a.away_score, a.game_code,
								a.win_team,a.handi_winner,a.gameDate,a.gameHour,a.gameTime,a.notice, a.kubun,a.type, a.special, a.is_specified_special,
								b.sn as league_sn, b.lg_img as league_image,b.name as league_name, b.nation_sn, b.alias_name, b.view_style, b.link_url,
								c.sn as sub_child_sn,c.betting_type,c.home_rate,c.draw_rate,c.away_rate, c.result as sub_child_result, c.win
						from ".$this->db_qz."child  a,".$this->db_qz."league b,".$this->db_qz."subchild c
						where a.view_flag = 1 and a.league_sn=b.sn and a.sn=c.child_sn ".$where;

        if($orderby!='')
            $sql.= " group by ".$groupby;

        if($orderby!='')
            $sql.= " order by ".$orderby;

        if($page_size!=0)
            $sql.= " limit ".$page.",".$page_size;

        return $this->db->exeSql($sql);
    }

	public function _gameListTotal($where="")
	{
		$sql = "select count(*) as cnt
						from ".$this->db_qz."child  a,".$this->db_qz."league b,".$this->db_qz."subchild c
						where a.view_flag = 1 and a.league_sn=b.sn and a.sn=c.child_sn ".$where;

		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 게임목록 총합_gameList
	public function Total($where="")
	{
		$sql = "select count(*) as cnt
							from ".$this->db_qz."child  a,".$this->db_qz."league b,".$this->db_qz."subchild c,".$this->db_qz."nation d
						where a.view_flag = 1 and a.league_sn=b.sn and a.sn=c.child_sn and b.nation_sn=d.sn ".$where;
		
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}
	
	//▶ 배팅목록
	public function _bettingList($memberSn='', $page=0, $page_size=0, $state=-1, $event=0, $beginDate='', $endDate='', $orderby='', $bettingNo='', $specialFlag='')
	{
		$sql = "select a.betting_no,a.regdate,a.betting_cnt,a.result_rate,a.betting_money,a.result, a.bet_date, 
                        a.seller_id, a.sale_price, a.sale_reg_time, a.sale_time, d.sn as child_sn
						from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild c,".$this->db_qz."child d
						where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn 
						and a.logo='".$this->logo."' and a.user_del<>'Y' and a.kubun ='Y'
						and (a.seller_id is null or  a.seller_id ='' and a.sale_time is null) and a.result=0 ";

		//where			
		//if($beginDate!="" && $endDate!="") 	{$sql.=" and (a.bet_date between '".$beginDate."' and '".$endDate."') ";}
        $sql.='and concat(gameDate," ", gameHour, ":", gameTime, ":00") > now()';
		if($memberSn!='')		{$sql.=" and a.member_sn=".$memberSn;}

		if ( $specialFlag != "all" ) {
			if ( $specialFlag > 0 ) {$sql.=" and d.special=".$specialFlag;}
		}

		//진행중, 종료
		if($state==0)				{$sql.=" and a.result=0 ";}
		else if($state==1)	{$sql.=" and a.result>0 ";}
		else if($state==10)	{$sql.=" and a.result=1 ";}
		else if($state==11)	{$sql.=" and a.result=2 ";}
		
		if($bettingNo!='')	{$sql.=" and a.betting_no='".$bettingNo."'";}
		
		$sql.= " group by a.betting_no ";

		//order by, limit
		$sql.=  " order by a.betting_no desc";
		if($page_size > 0)	{$sql.= " limit ".$page.",".$page_size;}

		//excute
		$rs = $this->db->exeSql($sql);

		$itemList = array();
		
		for($i=0; $i<count((array)$rs); ++$i)
		{
			$bettingNo = $rs[$i]["betting_no"];


			$sql = "select a.sub_child_sn,a.select_no,a.home_rate,a.away_rate,a.draw_rate,a.select_rate,a.game_type,a.result, a.member_sn,
							b.sn as child_sn, b.home_team,b.away_team,b.home_score,b.away_score,b.special,b.gameDate,b.gameHour,b.gameTime, b.game_code, b.game_th,
							c.name as league_name,c.lg_img as league_image, c.alias_name, d.win, d.home_rate as game_home_rate, d.away_rate as game_away_rate, d.draw_rate as game_draw_rate, e.operdate
							from ".$this->db_qz."total_betting a, ".$this->db_qz."child b, ".$this->db_qz."league c, ".$this->db_qz."subchild d, ".$this->db_qz."total_cart e
							where a.betting_no=e.betting_no and a.betting_no='".$bettingNo."' and a.sub_child_sn=d.sn and b.league_sn=c.sn and b.sn=d.child_sn";

			if($orderby!='') {$sql.=" order by ".$orderby;}
			$rsi = $this->db->exeSql($sql);
			
			$itemList[$bettingNo] = $rs[$i];
			$itemList[$bettingNo]['cancel_enable'] = 1;
            $itemList[$bettingNo]['starttime'] = $rsi[0]['gameDate']." ".$rsi[0]['gameHour'].":".$rsi[0]['gameTime'].":00";
            $st_time = new DateTime($itemList[$bettingNo]['starttime']);
            $itemList[$bettingNo]['st_time'] = $st_time->getTimestamp();
		
			for($j=0; $j<count((array)$rsi); ++$j)
			{
			    $rsi[$j]["home_team"] = html_entity_decode($rsi[$j]["home_team"]);
                $rsi[$j]["away_team"] = html_entity_decode($rsi[$j]["away_team"]);

				//적특으로 인한 result_rate, select_rate를 변경해 준다.
				if($rsi[$j]['result']==4)
				{
					$rate = $rsi[$j]['select_rate'];
					// 2017.05.19
					//$rate = round($rs[$i]['result_rate']/$rate,2);
                    $rate = bcmul($rs[$i]['result_rate']/$rate,1,2);
					
					$rs[$i]['result_rate'] = $rate;
					$rsi[$j]['select_rate']=1;
					
					$itemList[$bettingNo]['result_rate'] = $rate;
				} 
				else if($rsi[$j]['game_type']!=1 && $rsi[$j]['result']!=0)
				{
					$rsi[$j]['win'] = $this->calcResult($rsi[$j]['game_type'], $rsi[$j]['draw_rate'], $rsi[$j]['home_score'], $rsi[$j]['away_score']);
				}
				
				$itemList[$bettingNo]['win_money'] = (int)($rs[$i]['betting_money']*$rs[$i]['result_rate']);
				$itemList[$bettingNo]['folder_bonus']=0;

                if ( strlen(trim($rsi[$j]["home_team"] )) == strlen(str_replace("보너스","",trim($rsi[$j]["home_team"] ))) )
                {
                    if($itemList[$bettingNo]['cancel_enable']==1 && $rsi[$j]['result']!=0)
                    {
                        $itemList[$bettingNo]['cancel_enable'] = 0;
                    }
                }
				
				// 가라배팅 경기결과값
				if($rsi[$j]['member_sn']=='0')
				{
					/*
					if($rsi[$j]['win']=='1')
					{
						if($rsi[$j]['select_no']=='1'){$rsi[$j]['result']='1';}
						else {$rsi[$j]['result']='2';$result_flag="2";}
					}
					else if($rsi[$j]['win']=='2')
					{
						if($rsi[$j]['select_no']=='2'){$rsi[$j]['result']='1';}
						else {$rsi[$j]['result']='2';$result_flag="2";}
					}
					else if($rsi[$j]['win']=='3')
					{
						if($rsi[$j]['select_no']=='3'){$rsi[$j]['result']='1';}
						else {$rsi[$j]['result']='2';$result_flag="2";}
					}
					else if($rsi[$j]['win']=='4'){$rsi[$j]['result']='4';}
					*/
					$itemList[$bettingNo]['result_money']=$itemList[$bettingNo]['win_money'];

				}
				
				//폴더보너스 체크시 적용
				if($event==0)
				{	
					$cModel = Lemon_Instance::getObject("ConfigModel",true);
					$mModel = Lemon_Instance::getObject("MemberModel",true);
						
					$level	= $mModel->getMemberField($this->auth->getSn(),'mem_lev');
					$field  = $cModel->getLevelConfigRow($level,"lev_folder_bonus");					
				
					$folderBonuses = explode(":", $field['lev_folder_bonus']);				
					$bonusRate=0;
					switch($rs[$i]['betting_cnt'])
					{
						case 3:  $bonusRate=$folderBonuses[0]; break;
						case 4:  $bonusRate=$folderBonuses[1]; break;
						case 5:  $bonusRate=$folderBonuses[2]; break;
						case 6:  $bonusRate=$folderBonuses[3]; break;
						case 7:  $bonusRate=$folderBonuses[4]; break;
						case 8:  $bonusRate=$folderBonuses[5]; break;
						case 9:  $bonusRate=$folderBonuses[6]; break;
						case 10: $bonusRate=$folderBonuses[7]; break;
					}
					
					$itemList[$bettingNo]['bonus_rate'] = $bonusRate;
					$itemList[$bettingNo]['folder_bonus'] = (int)($itemList[$bettingNo]['win_money']*$bonusRate/100);
				}
				else if($event==1)
				{	
					$cModel = Lemon_Instance::getObject("ConfigModel",true);
					
					$folderBonuses = $cModel->getEventConfigRow();
						
					$amount=0;
					switch($rs[$i]['betting_cnt'])
					{
						case 1:  $amount=$folderBonuses['bonus1']; break;
						case 2:  $amount=$folderBonuses['bonus2']; break;
						case 3:  $amount=$folderBonuses['bonus3']; break;
						case 4:  $amount=$folderBonuses['bonus4']; break;
						case 5:  $amount=$folderBonuses['bonus5']; break;
						case 6:  $amount=$folderBonuses['bonus6']; break;
						case 7:  $amount=$folderBonuses['bonus7']; break;
						case 8:  $amount=$folderBonuses['bonus8']; break;
						case 9:  $amount=$folderBonuses['bonus9']; break;
						case 10: $amount=$folderBonuses['bonus10']; break;
					}
					$itemList[$bettingNo]['bonus_rate'] = 0;	
					$itemList[$bettingNo]['folder_bonus'] = $amount;
				}
				
				$itemList[$bettingNo]['item'][] = $rsi[$j];
			} // end of 2nd for
		}
		
		return $itemList;
	}
	
	//▶ 배팅목록 총합
	public function _bettingListTotal($memberSn, $state=-1, $event=0, $beginDate='', $endDate='', $specialFlag='')
	{
		$sql = "select count(distinct(a.betting_no)) as cnt
						from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild c,".$this->db_qz."child d
						where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn 
						and a.logo='".$this->logo."' and a.user_del<>'Y' and a.member_Sn=".$memberSn." and a.kubun ='Y' 
						and (a.seller_id is null or a.seller_id ='' and a.sale_time is null) and a.result=0";
		
		//where			
		if($beginDate!="" && $endDate!="") 	{$sql.=" and (a.bet_date between '".$beginDate."' and '".$endDate."') ";}

		if ( $specialFlag != "all" ) {
			if ( !$specialFlag ) {
				$sql.=" and d.special = '{$specialFlag}' ";
			}
		}

		//진행중, 종료
		if($state==0)						{$sql.=" and a.result=0 ";}
		else if($state==1)			{$sql.=" and a.result>0 ";}
		else if($state==10)			{$sql.=" and a.result=1 ";}
		else if($state==11)			{$sql.=" and a.result=2 ";}
		
		$rs = $this->db->exeSql($sql);
		return $rs[0]['cnt'];
	}

    public function _saleList($memberSn='', $page=0, $page_size=0, $state=-1, $event=0, $beginDate='', $endDate='', $orderby='', $bettingNo='', $specialFlag='')
    {
        $sql = "select a.betting_no,a.regdate,a.betting_cnt,a.result_rate,a.betting_money,a.result, a.bet_date, 
                        a.seller_id, a.sale_price, a.sale_reg_time, a.sale_time, d.sn as child_sn
						from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild c,".$this->db_qz."child d
						where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn 
						and a.logo='".$this->logo."' and a.user_del<>'Y' and a.kubun ='Y'
						and a.member_sn=a.seller_id and a.result=0 ";

        //where
        //if($beginDate!="" && $endDate!="") 	{$sql.=" and (a.bet_date between '".$beginDate."' and '".$endDate."') ";}
        $sql.='and concat(gameDate," ", gameHour, ":", gameTime, ":00") > now()';
        if($memberSn!='')		{$sql.=" and a.seller_id=".$memberSn;}

        if ( $specialFlag != "all" ) {
            if ( $specialFlag > 0 ) {$sql.=" and d.special=".$specialFlag;}
        }

        //진행중, 종료
        if($state==0)				{$sql.=" and a.result=0 ";}
        else if($state==1)	{$sql.=" and a.result>0 ";}
        else if($state==10)	{$sql.=" and a.result=1 ";}
        else if($state==11)	{$sql.=" and a.result=2 ";}

        if($bettingNo!='')	{$sql.=" and a.betting_no='".$bettingNo."'";}

        $sql.= " group by a.betting_no ";

        //order by, limit
        $sql.=  " order by a.betting_no desc";
        if($page_size > 0)	{$sql.= " limit ".$page.",".$page_size;}

        //excute
        $rs = $this->db->exeSql($sql);

        $itemList = array();

        for($i=0; $i<count((array)$rs); ++$i)
        {
            $bettingNo = $rs[$i]["betting_no"];


            $sql = "select a.sub_child_sn,a.select_no,a.home_rate,a.away_rate,a.draw_rate,a.select_rate,a.game_type,a.result, a.member_sn,
							b.sn as child_sn, b.home_team,b.away_team,b.home_score,b.away_score,b.special,b.gameDate,b.gameHour,b.gameTime, b.game_code, b.game_th,
							c.name as league_name,c.lg_img as league_image, c.alias_name, d.win, d.home_rate as game_home_rate, d.away_rate as game_away_rate, d.draw_rate as game_draw_rate, e.operdate
							from ".$this->db_qz."total_betting a, ".$this->db_qz."child b, ".$this->db_qz."league c, ".$this->db_qz."subchild d, ".$this->db_qz."total_cart e
							where a.betting_no=e.betting_no and a.betting_no='".$bettingNo."' and a.sub_child_sn=d.sn and b.league_sn=c.sn and b.sn=d.child_sn";

            if($orderby!='') {$sql.=" order by ".$orderby;}
            $rsi = $this->db->exeSql($sql);

            $itemList[$bettingNo] = $rs[$i];
            $itemList[$bettingNo]['cancel_enable'] = 1;
            $itemList[$bettingNo]['starttime'] = $rsi[0]['gameDate']." ".$rsi[0]['gameHour'].":".$rsi[0]['gameTime'].":00";
            $st_time = new DateTime($itemList[$bettingNo]['starttime']);
            $itemList[$bettingNo]['st_time'] = $st_time->getTimestamp();

            for($j=0; $j<count((array)$rsi); ++$j)
            {
                $rsi[$j]["home_team"] = html_entity_decode($rsi[$j]["home_team"]);
                $rsi[$j]["away_team"] = html_entity_decode($rsi[$j]["away_team"]);

                //적특으로 인한 result_rate, select_rate를 변경해 준다.
                if($rsi[$j]['result']==4)
                {
                    $rate = $rsi[$j]['select_rate'];
                    // 2017.05.19
                    //$rate = round($rs[$i]['result_rate']/$rate,2);
                    $rate = bcmul($rs[$i]['result_rate']/$rate,1,2);

                    $rs[$i]['result_rate'] = $rate;
                    $rsi[$j]['select_rate']=1;

                    $itemList[$bettingNo]['result_rate'] = $rate;
                }
                else if($rsi[$j]['game_type']!=1 && $rsi[$j]['result']!=0)
                {
                    $rsi[$j]['win'] = $this->calcResult($rsi[$j]['game_type'], $rsi[$j]['draw_rate'], $rsi[$j]['home_score'], $rsi[$j]['away_score']);
                }

                $itemList[$bettingNo]['win_money'] = (int)($rs[$i]['betting_money']*$rs[$i]['result_rate']);
                $itemList[$bettingNo]['folder_bonus']=0;

                if ( strlen(trim($rsi[$j]["home_team"] )) == strlen(str_replace("보너스","",trim($rsi[$j]["home_team"] ))) )
                {
                    if($itemList[$bettingNo]['cancel_enable']==1 && $rsi[$j]['result']!=0)
                    {
                        $itemList[$bettingNo]['cancel_enable'] = 0;
                    }
                }

                // 가라배팅 경기결과값
                if($rsi[$j]['member_sn']=='0')
                {
                    /*
                    if($rsi[$j]['win']=='1')
                    {
                        if($rsi[$j]['select_no']=='1'){$rsi[$j]['result']='1';}
                        else {$rsi[$j]['result']='2';$result_flag="2";}
                    }
                    else if($rsi[$j]['win']=='2')
                    {
                        if($rsi[$j]['select_no']=='2'){$rsi[$j]['result']='1';}
                        else {$rsi[$j]['result']='2';$result_flag="2";}
                    }
                    else if($rsi[$j]['win']=='3')
                    {
                        if($rsi[$j]['select_no']=='3'){$rsi[$j]['result']='1';}
                        else {$rsi[$j]['result']='2';$result_flag="2";}
                    }
                    else if($rsi[$j]['win']=='4'){$rsi[$j]['result']='4';}
                    */
                    $itemList[$bettingNo]['result_money']=$itemList[$bettingNo]['win_money'];

                }

                //폴더보너스 체크시 적용
                if($event==0)
                {
                    $cModel = Lemon_Instance::getObject("ConfigModel",true);
                    $mModel = Lemon_Instance::getObject("MemberModel",true);

                    $level	= $mModel->getMemberField($this->auth->getSn(),'mem_lev');
                    $field  = $cModel->getLevelConfigRow($level,"lev_folder_bonus");

                    $folderBonuses = explode(":", $field['lev_folder_bonus']);
                    $bonusRate=0;
                    switch($rs[$i]['betting_cnt'])
                    {
                        case 3:  $bonusRate=$folderBonuses[0]; break;
                        case 4:  $bonusRate=$folderBonuses[1]; break;
                        case 5:  $bonusRate=$folderBonuses[2]; break;
                        case 6:  $bonusRate=$folderBonuses[3]; break;
                        case 7:  $bonusRate=$folderBonuses[4]; break;
                        case 8:  $bonusRate=$folderBonuses[5]; break;
                        case 9:  $bonusRate=$folderBonuses[6]; break;
                        case 10: $bonusRate=$folderBonuses[7]; break;
                    }

                    $itemList[$bettingNo]['bonus_rate'] = $bonusRate;
                    $itemList[$bettingNo]['folder_bonus'] = (int)($itemList[$bettingNo]['win_money']*$bonusRate/100);
                }
                else if($event==1)
                {
                    $cModel = Lemon_Instance::getObject("ConfigModel",true);

                    $folderBonuses = $cModel->getEventConfigRow();

                    $amount=0;
                    switch($rs[$i]['betting_cnt'])
                    {
                        case 1:  $amount=$folderBonuses['bonus1']; break;
                        case 2:  $amount=$folderBonuses['bonus2']; break;
                        case 3:  $amount=$folderBonuses['bonus3']; break;
                        case 4:  $amount=$folderBonuses['bonus4']; break;
                        case 5:  $amount=$folderBonuses['bonus5']; break;
                        case 6:  $amount=$folderBonuses['bonus6']; break;
                        case 7:  $amount=$folderBonuses['bonus7']; break;
                        case 8:  $amount=$folderBonuses['bonus8']; break;
                        case 9:  $amount=$folderBonuses['bonus9']; break;
                        case 10: $amount=$folderBonuses['bonus10']; break;
                    }
                    $itemList[$bettingNo]['bonus_rate'] = 0;
                    $itemList[$bettingNo]['folder_bonus'] = $amount;
                }

                $itemList[$bettingNo]['item'][] = $rsi[$j];
            } // end of 2nd for
        }

        return $itemList;
    }

    //▶ 배팅목록 총합
    public function _saleListTotal($memberSn, $state=-1, $event=0, $beginDate='', $endDate='', $specialFlag='')
    {
        $sql = "select count(distinct(a.betting_no)) as cnt
						from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild c,".$this->db_qz."child d
						where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn 
						and a.logo='".$this->logo."' and a.user_del<>'Y' and a.seller_id=".$memberSn." and a.kubun ='Y' 
						and a.member_sn=a.seller_id and a.result=0 ";

        //where
        if($beginDate!="" && $endDate!="") 	{$sql.=" and (a.bet_date between '".$beginDate."' and '".$endDate."') ";}

        if ( $specialFlag != "all" ) {
            if ( !$specialFlag ) {
                $sql.=" and d.special = '{$specialFlag}' ";
            }
        }

        //진행중, 종료
        if($state==0)						{$sql.=" and a.result=0 ";}
        else if($state==1)			{$sql.=" and a.result>0 ";}
        else if($state==10)			{$sql.=" and a.result=1 ";}
        else if($state==11)			{$sql.=" and a.result=2 ";}

        $rs = $this->db->exeSql($sql);
        return $rs[0]['cnt'];
    }

    public function _itemList($memberSn='', $page=0, $page_size=0, $state=-1, $event=0, $beginDate='', $endDate='', $orderby='', $bettingNo='', $specialFlag='')
    {
        $sql = "select a.betting_no,a.regdate,a.betting_cnt,a.result_rate,a.betting_money,a.result, a.bet_date, 
                        a.seller_id, a.sale_price, a.sale_reg_time, a.sale_time, d.sn as child_sn
						from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild c,".$this->db_qz."child d
						where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn 
						and a.logo='".$this->logo."' and a.user_del<>'Y' and a.kubun ='Y'
						and (a.seller_id is not null and  a.seller_id !='' and a.sale_time is null) and a.result=0 ";

        //where
        //if($beginDate!="" && $endDate!="") 	{$sql.=" and (a.bet_date between '".$beginDate."' and '".$endDate."') ";}
        $sql.='and concat(gameDate," ", gameHour, ":", gameTime, ":00") > now()';
        if($memberSn!='')		{$sql.=" and a.seller_id!=".$memberSn;}

        if ( $specialFlag != "all" ) {
            if ( $specialFlag > 0 ) {$sql.=" and d.special=".$specialFlag;}
        }

        //진행중, 종료
        if($state==0)				{$sql.=" and a.result=0 ";}
        else if($state==1)	{$sql.=" and a.result>0 ";}
        else if($state==10)	{$sql.=" and a.result=1 ";}
        else if($state==11)	{$sql.=" and a.result=2 ";}

        if($bettingNo!='')	{$sql.=" and a.betting_no='".$bettingNo."'";}

        $sql.= " group by a.betting_no ";

        //order by, limit
        $sql.=  " order by a.betting_no desc";
        if($page_size > 0)	{$sql.= " limit ".$page.",".$page_size;}

        //excute
        $rs = $this->db->exeSql($sql);

        $itemList = array();

        for($i=0; $i<count((array)$rs); ++$i)
        {
            $bettingNo = $rs[$i]["betting_no"];


            $sql = "select a.sub_child_sn,a.select_no,a.home_rate,a.away_rate,a.draw_rate,a.select_rate,a.game_type,a.result, a.member_sn,
							b.sn as child_sn, b.home_team,b.away_team,b.home_score,b.away_score,b.special,b.gameDate,b.gameHour,b.gameTime, b.game_code, b.game_th,
							c.name as league_name,c.lg_img as league_image, c.alias_name, d.win, d.home_rate as game_home_rate, d.away_rate as game_away_rate, d.draw_rate as game_draw_rate, e.operdate
							from ".$this->db_qz."total_betting a, ".$this->db_qz."child b, ".$this->db_qz."league c, ".$this->db_qz."subchild d, ".$this->db_qz."total_cart e
							where a.betting_no=e.betting_no and a.betting_no='".$bettingNo."' and a.sub_child_sn=d.sn and b.league_sn=c.sn and b.sn=d.child_sn";

            if($orderby!='') {$sql.=" order by ".$orderby;}
            $rsi = $this->db->exeSql($sql);

            $itemList[$bettingNo] = $rs[$i];
            $itemList[$bettingNo]['cancel_enable'] = 1;
            $itemList[$bettingNo]['starttime'] = $rsi[0]['gameDate']." ".$rsi[0]['gameHour'].":".$rsi[0]['gameTime'].":00";
            $st_time = new DateTime($itemList[$bettingNo]['starttime']);
            $itemList[$bettingNo]['st_time'] = $st_time->getTimestamp();

            for($j=0; $j<count((array)$rsi); ++$j)
            {
                $rsi[$j]["home_team"] = html_entity_decode($rsi[$j]["home_team"]);
                $rsi[$j]["away_team"] = html_entity_decode($rsi[$j]["away_team"]);

                //적특으로 인한 result_rate, select_rate를 변경해 준다.
                if($rsi[$j]['result']==4)
                {
                    $rate = $rsi[$j]['select_rate'];
                    // 2017.05.19
                    //$rate = round($rs[$i]['result_rate']/$rate,2);
                    $rate = bcmul($rs[$i]['result_rate']/$rate,1,2);

                    $rs[$i]['result_rate'] = $rate;
                    $rsi[$j]['select_rate']=1;

                    $itemList[$bettingNo]['result_rate'] = $rate;
                }
                else if($rsi[$j]['game_type']!=1 && $rsi[$j]['result']!=0)
                {
                    $rsi[$j]['win'] = $this->calcResult($rsi[$j]['game_type'], $rsi[$j]['draw_rate'], $rsi[$j]['home_score'], $rsi[$j]['away_score']);
                }

                $itemList[$bettingNo]['win_money'] = (int)($rs[$i]['betting_money']*$rs[$i]['result_rate']);
                $itemList[$bettingNo]['folder_bonus']=0;

                if ( strlen(trim($rsi[$j]["home_team"] )) == strlen(str_replace("보너스","",trim($rsi[$j]["home_team"] ))) )
                {
                    if($itemList[$bettingNo]['cancel_enable']==1 && $rsi[$j]['result']!=0)
                    {
                        $itemList[$bettingNo]['cancel_enable'] = 0;
                    }
                }

                // 가라배팅 경기결과값
                if($rsi[$j]['member_sn']=='0')
                {
                    /*
                    if($rsi[$j]['win']=='1')
                    {
                        if($rsi[$j]['select_no']=='1'){$rsi[$j]['result']='1';}
                        else {$rsi[$j]['result']='2';$result_flag="2";}
                    }
                    else if($rsi[$j]['win']=='2')
                    {
                        if($rsi[$j]['select_no']=='2'){$rsi[$j]['result']='1';}
                        else {$rsi[$j]['result']='2';$result_flag="2";}
                    }
                    else if($rsi[$j]['win']=='3')
                    {
                        if($rsi[$j]['select_no']=='3'){$rsi[$j]['result']='1';}
                        else {$rsi[$j]['result']='2';$result_flag="2";}
                    }
                    else if($rsi[$j]['win']=='4'){$rsi[$j]['result']='4';}
                    */
                    $itemList[$bettingNo]['result_money']=$itemList[$bettingNo]['win_money'];

                }

                //폴더보너스 체크시 적용
                if($event==0)
                {
                    $cModel = Lemon_Instance::getObject("ConfigModel",true);
                    $mModel = Lemon_Instance::getObject("MemberModel",true);

                    $level	= $mModel->getMemberField($this->auth->getSn(),'mem_lev');
                    $field  = $cModel->getLevelConfigRow($level,"lev_folder_bonus");

                    $folderBonuses = explode(":", $field['lev_folder_bonus']);
                    $bonusRate=0;
                    switch($rs[$i]['betting_cnt'])
                    {
                        case 3:  $bonusRate=$folderBonuses[0]; break;
                        case 4:  $bonusRate=$folderBonuses[1]; break;
                        case 5:  $bonusRate=$folderBonuses[2]; break;
                        case 6:  $bonusRate=$folderBonuses[3]; break;
                        case 7:  $bonusRate=$folderBonuses[4]; break;
                        case 8:  $bonusRate=$folderBonuses[5]; break;
                        case 9:  $bonusRate=$folderBonuses[6]; break;
                        case 10: $bonusRate=$folderBonuses[7]; break;
                    }

                    $itemList[$bettingNo]['bonus_rate'] = $bonusRate;
                    $itemList[$bettingNo]['folder_bonus'] = (int)($itemList[$bettingNo]['win_money']*$bonusRate/100);
                }
                else if($event==1)
                {
                    $cModel = Lemon_Instance::getObject("ConfigModel",true);

                    $folderBonuses = $cModel->getEventConfigRow();

                    $amount=0;
                    switch($rs[$i]['betting_cnt'])
                    {
                        case 1:  $amount=$folderBonuses['bonus1']; break;
                        case 2:  $amount=$folderBonuses['bonus2']; break;
                        case 3:  $amount=$folderBonuses['bonus3']; break;
                        case 4:  $amount=$folderBonuses['bonus4']; break;
                        case 5:  $amount=$folderBonuses['bonus5']; break;
                        case 6:  $amount=$folderBonuses['bonus6']; break;
                        case 7:  $amount=$folderBonuses['bonus7']; break;
                        case 8:  $amount=$folderBonuses['bonus8']; break;
                        case 9:  $amount=$folderBonuses['bonus9']; break;
                        case 10: $amount=$folderBonuses['bonus10']; break;
                    }
                    $itemList[$bettingNo]['bonus_rate'] = 0;
                    $itemList[$bettingNo]['folder_bonus'] = $amount;
                }

                $itemList[$bettingNo]['item'][] = $rsi[$j];
            } // end of 2nd for
        }

        return $itemList;
    }

    //▶ 배팅목록 총합
    public function _itemListTotal($memberSn, $state=-1, $event=0, $beginDate='', $endDate='', $specialFlag='')
    {
        $sql = "select count(distinct(a.betting_no)) as cnt
						from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild c,".$this->db_qz."child d
						where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn 
						and a.logo='".$this->logo."' and a.user_del<>'Y' and a.seller_id!=".$memberSn." and a.kubun ='Y' 
						and (a.seller_id is not null and a.seller_id !='' and a.sale_time is null) and a.result=0";

        //where
        if($beginDate!="" && $endDate!="") 	{$sql.=" and (a.bet_date between '".$beginDate."' and '".$endDate."') ";}

        if ( $specialFlag != "all" ) {
            if ( !$specialFlag ) {
                $sql.=" and d.special = '{$specialFlag}' ";
            }
        }

        //진행중, 종료
        if($state==0)						{$sql.=" and a.result=0 ";}
        else if($state==1)			{$sql.=" and a.result>0 ";}
        else if($state==10)			{$sql.=" and a.result=1 ";}
        else if($state==11)			{$sql.=" and a.result=2 ";}

        $rs = $this->db->exeSql($sql);
        return $rs[0]['cnt'];
    }

    public function _purchaseListTotal($memberSn, $state=-1, $event=0, $beginDate='', $endDate='', $specialFlag='')
    {
        $sql = "select count(distinct(a.betting_no)) as cnt
						from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild c,".$this->db_qz."child d
						where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn 
						and a.logo='".$this->logo."' and a.user_del<>'Y' and a.member_sn=".$memberSn." and a.kubun ='Y' 
						and (a.seller_id is not null and a.seller_id !='' and a.sale_time is not null) and a.result=0";

        //where
        if($beginDate!="" && $endDate!="") 	{$sql.=" and (a.bet_date between '".$beginDate."' and '".$endDate."') ";}

        if ( $specialFlag != "all" ) {
            if ( !$specialFlag ) {
                $sql.=" and d.special = '{$specialFlag}' ";
            }
        }

        //진행중, 종료
        if($state==0)						{$sql.=" and a.result=0 ";}
        else if($state==1)			{$sql.=" and a.result>0 ";}
        else if($state==10)			{$sql.=" and a.result=1 ";}
        else if($state==11)			{$sql.=" and a.result=2 ";}

        $rs = $this->db->exeSql($sql);
        return $rs[0]['cnt'];
    }

    public function _purchaseList($memberSn='', $page=0, $page_size=0, $state=-1, $event=0, $beginDate='', $endDate='', $orderby='', $bettingNo='', $specialFlag='')
    {
        $sql = "select a.betting_no,a.regdate,a.betting_cnt,a.result_rate,a.betting_money,a.result, a.bet_date, 
                        a.seller_id, a.sale_price, a.sale_reg_time, a.sale_time, d.sn as child_sn
						from ".$this->db_qz."total_cart a,".$this->db_qz."total_betting b,".$this->db_qz."subchild c,".$this->db_qz."child d
						where a.betting_no=b.betting_no and b.sub_child_sn=c.sn and c.child_sn=d.sn 
						and a.logo='".$this->logo."' and a.user_del<>'Y' and a.kubun ='Y'
						and (a.seller_id is not null and  a.seller_id !='' and a.sale_time is not null) and a.result=0 ";

        //where
        //if($beginDate!="" && $endDate!="") 	{$sql.=" and (a.bet_date between '".$beginDate."' and '".$endDate."') ";}
        $sql.='and concat(gameDate," ", gameHour, ":", gameTime, ":00") > now()';
        if($memberSn!='')		{$sql.=" and a.member_sn=".$memberSn;}

        if ( $specialFlag != "all" ) {
            if ( $specialFlag > 0 ) {$sql.=" and d.special=".$specialFlag;}
        }

        //진행중, 종료
        if($state==0)				{$sql.=" and a.result=0 ";}
        else if($state==1)	{$sql.=" and a.result>0 ";}
        else if($state==10)	{$sql.=" and a.result=1 ";}
        else if($state==11)	{$sql.=" and a.result=2 ";}

        if($bettingNo!='')	{$sql.=" and a.betting_no='".$bettingNo."'";}

        $sql.= " group by a.betting_no ";

        //order by, limit
        $sql.=  " order by a.betting_no desc";
        if($page_size > 0)	{$sql.= " limit ".$page.",".$page_size;}

        //excute
        $rs = $this->db->exeSql($sql);

        $itemList = array();

        for($i=0; $i<count((array)$rs); ++$i)
        {
            $bettingNo = $rs[$i]["betting_no"];


            $sql = "select a.sub_child_sn,a.select_no,a.home_rate,a.away_rate,a.draw_rate,a.select_rate,a.game_type,a.result, a.member_sn,
							b.sn as child_sn, b.home_team,b.away_team,b.home_score,b.away_score,b.special,b.gameDate,b.gameHour,b.gameTime, b.game_code, b.game_th,
							c.name as league_name,c.lg_img as league_image, c.alias_name, d.win, d.home_rate as game_home_rate, d.away_rate as game_away_rate, d.draw_rate as game_draw_rate, e.operdate
							from ".$this->db_qz."total_betting a, ".$this->db_qz."child b, ".$this->db_qz."league c, ".$this->db_qz."subchild d, ".$this->db_qz."total_cart e
							where a.betting_no=e.betting_no and a.betting_no='".$bettingNo."' and a.sub_child_sn=d.sn and b.league_sn=c.sn and b.sn=d.child_sn";

            if($orderby!='') {$sql.=" order by ".$orderby;}
            $rsi = $this->db->exeSql($sql);

            $itemList[$bettingNo] = $rs[$i];
            $itemList[$bettingNo]['cancel_enable'] = 1;
            $itemList[$bettingNo]['starttime'] = $rsi[0]['gameDate']." ".$rsi[0]['gameHour'].":".$rsi[0]['gameTime'].":00";
            $st_time = new DateTime($itemList[$bettingNo]['starttime']);
            $itemList[$bettingNo]['st_time'] = $st_time->getTimestamp();

            for($j=0; $j<count((array)$rsi); ++$j)
            {
                $rsi[$j]["home_team"] = html_entity_decode($rsi[$j]["home_team"]);
                $rsi[$j]["away_team"] = html_entity_decode($rsi[$j]["away_team"]);

                //적특으로 인한 result_rate, select_rate를 변경해 준다.
                if($rsi[$j]['result']==4)
                {
                    $rate = $rsi[$j]['select_rate'];
                    // 2017.05.19
                    //$rate = round($rs[$i]['result_rate']/$rate,2);
                    $rate = bcmul($rs[$i]['result_rate']/$rate,1,2);

                    $rs[$i]['result_rate'] = $rate;
                    $rsi[$j]['select_rate']=1;

                    $itemList[$bettingNo]['result_rate'] = $rate;
                }
                else if($rsi[$j]['game_type']!=1 && $rsi[$j]['result']!=0)
                {
                    $rsi[$j]['win'] = $this->calcResult($rsi[$j]['game_type'], $rsi[$j]['draw_rate'], $rsi[$j]['home_score'], $rsi[$j]['away_score']);
                }

                $itemList[$bettingNo]['win_money'] = (int)($rs[$i]['betting_money']*$rs[$i]['result_rate']);
                $itemList[$bettingNo]['folder_bonus']=0;

                if ( strlen(trim($rsi[$j]["home_team"] )) == strlen(str_replace("보너스","",trim($rsi[$j]["home_team"] ))) )
                {
                    if($itemList[$bettingNo]['cancel_enable']==1 && $rsi[$j]['result']!=0)
                    {
                        $itemList[$bettingNo]['cancel_enable'] = 0;
                    }
                }

                // 가라배팅 경기결과값
                if($rsi[$j]['member_sn']=='0')
                {
                    /*
                    if($rsi[$j]['win']=='1')
                    {
                        if($rsi[$j]['select_no']=='1'){$rsi[$j]['result']='1';}
                        else {$rsi[$j]['result']='2';$result_flag="2";}
                    }
                    else if($rsi[$j]['win']=='2')
                    {
                        if($rsi[$j]['select_no']=='2'){$rsi[$j]['result']='1';}
                        else {$rsi[$j]['result']='2';$result_flag="2";}
                    }
                    else if($rsi[$j]['win']=='3')
                    {
                        if($rsi[$j]['select_no']=='3'){$rsi[$j]['result']='1';}
                        else {$rsi[$j]['result']='2';$result_flag="2";}
                    }
                    else if($rsi[$j]['win']=='4'){$rsi[$j]['result']='4';}
                    */
                    $itemList[$bettingNo]['result_money']=$itemList[$bettingNo]['win_money'];

                }

                //폴더보너스 체크시 적용
                if($event==0)
                {
                    $cModel = Lemon_Instance::getObject("ConfigModel",true);
                    $mModel = Lemon_Instance::getObject("MemberModel",true);

                    $level	= $mModel->getMemberField($this->auth->getSn(),'mem_lev');
                    $field  = $cModel->getLevelConfigRow($level,"lev_folder_bonus");

                    $folderBonuses = explode(":", $field['lev_folder_bonus']);
                    $bonusRate=0;
                    switch($rs[$i]['betting_cnt'])
                    {
                        case 3:  $bonusRate=$folderBonuses[0]; break;
                        case 4:  $bonusRate=$folderBonuses[1]; break;
                        case 5:  $bonusRate=$folderBonuses[2]; break;
                        case 6:  $bonusRate=$folderBonuses[3]; break;
                        case 7:  $bonusRate=$folderBonuses[4]; break;
                        case 8:  $bonusRate=$folderBonuses[5]; break;
                        case 9:  $bonusRate=$folderBonuses[6]; break;
                        case 10: $bonusRate=$folderBonuses[7]; break;
                    }

                    $itemList[$bettingNo]['bonus_rate'] = $bonusRate;
                    $itemList[$bettingNo]['folder_bonus'] = (int)($itemList[$bettingNo]['win_money']*$bonusRate/100);
                }
                else if($event==1)
                {
                    $cModel = Lemon_Instance::getObject("ConfigModel",true);

                    $folderBonuses = $cModel->getEventConfigRow();

                    $amount=0;
                    switch($rs[$i]['betting_cnt'])
                    {
                        case 1:  $amount=$folderBonuses['bonus1']; break;
                        case 2:  $amount=$folderBonuses['bonus2']; break;
                        case 3:  $amount=$folderBonuses['bonus3']; break;
                        case 4:  $amount=$folderBonuses['bonus4']; break;
                        case 5:  $amount=$folderBonuses['bonus5']; break;
                        case 6:  $amount=$folderBonuses['bonus6']; break;
                        case 7:  $amount=$folderBonuses['bonus7']; break;
                        case 8:  $amount=$folderBonuses['bonus8']; break;
                        case 9:  $amount=$folderBonuses['bonus9']; break;
                        case 10: $amount=$folderBonuses['bonus10']; break;
                    }
                    $itemList[$bettingNo]['bonus_rate'] = 0;
                    $itemList[$bettingNo]['folder_bonus'] = $amount;
                }

                $itemList[$bettingNo]['item'][] = $rsi[$j];
            } // end of 2nd for
        }

        return $itemList;
    }
	//▶ 배팅목록
	/*
		@param
			[$finish] -1=전체,0=ing, 1=finish
	*/
	public function getBettingList($memberSn, $page, $page_size, $chkFolder, $finish=-1,  $beginDate="", $endDate="", $specialFlag = 0) 
	{
		return $this->_bettingList($memberSn, $page, $page_size, $finish, -1, $beginDate, $endDate, 'b.gameDate desc, b.gameHour desc, b.gameTime desc', '', $specialFlag);
	}

	public function getBettingListTotal($memberSn, $finish=-1, $event=0, $beginDate='', $endDate='', $specialFlag='')
	{
		return $this->_bettingListTotal($memberSn, $finish, $event, $beginDate, $endDate, $specialFlag);
	}

    public function getItemList($memberSn, $page, $page_size, $chkFolder, $finish=-1,  $beginDate="", $endDate="", $specialFlag = 0)
    {
        return $this->_itemList($memberSn, $page, $page_size, $finish, -1, $beginDate, $endDate, 'b.gameDate desc, b.gameHour desc, b.gameTime desc', '', $specialFlag);
    }

    public function getItemListTotal($memberSn, $finish=-1, $event=0, $beginDate='', $endDate='', $specialFlag='')
    {
        return $this->_itemListTotal($memberSn, $finish, $event, $beginDate, $endDate, $specialFlag);
    }

    public function getPurchaseList($memberSn, $page, $page_size, $chkFolder, $finish=-1,  $beginDate="", $endDate="", $specialFlag = 0)
    {
        return $this->_purchaseList($memberSn, $page, $page_size, $finish, -1, $beginDate, $endDate, 'b.gameDate desc, b.gameHour desc, b.gameTime desc', '', $specialFlag);
    }

    public function getPurchaseListTotal($memberSn, $finish=-1, $event=0, $beginDate='', $endDate='', $specialFlag='')
    {
        return $this->_purchaseListTotal($memberSn, $finish, $event, $beginDate, $endDate, $specialFlag);
    }

    public function getSaleList($memberSn, $page, $page_size, $chkFolder, $finish=-1,  $beginDate="", $endDate="", $specialFlag = 0)
    {
        return $this->_saleList($memberSn, $page, $page_size, $finish, -1, $beginDate, $endDate, 'b.gameDate desc, b.gameHour desc, b.gameTime desc', '', $specialFlag);
    }

    public function getSaleListTotal($memberSn, $finish=-1, $event=0, $beginDate='', $endDate='', $specialFlag='')
    {
        return $this->_saleListTotal($memberSn, $finish, $event, $beginDate, $endDate, $specialFlag);
    }

}
?>