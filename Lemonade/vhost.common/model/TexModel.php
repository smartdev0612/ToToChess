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
class TexModel extends Lemon_Model
{
	/**
	*--------------------------------------------------------------------
 	*
 	* betting process
 	*
 	*--------------------------------------------------------------------
 	*/
 	
 	function texSettlment()
 	{
        $beginDate = date("Y-m-d",time());
        $regdate = date("Y-m-d H:i:s",time());

        //$beginDate = "2016-06-02";
        //$regdate = "2016-06-02 05:00:00";

	      /* 처리 로직 : 총판 기준으로 정산 데이터를 가져와서 부본사와 총판의 정산율을 계산*/

        $sql = "SELECT * FROM tb_partner WHERE rec_lev = 1 and status != 2 ORDER BY idx asc";
        $recData = $this->db->exeSql($sql);
        $procCnt = 0;
        foreach($recData as $row){
            $recommendSn = $row["Idx"];
            $recommendId = $row["rec_id"];
            $tex_type = $row["rec_tex_type"];									//-> 총판 정산타입코드
            $rate_sport = $row["rec_rate_sport"];							//-> 총판 스포츠 정산 비율%
            $rate_minigame = $row["rec_rate_minigame"];				//-> 총판 미니게임 정산 비율%
            $one_folder_flag = $row["rec_one_folder_flag"];		//-> 총판 단폴더 정산 포함 여부
            $recommendId_top = $row["rec_parent_id"];					//-> 총판 부본사ID

            //-> 만약 총판이 부본사에 소속되어 있지 않다면 총판만 정산.
            if ( !trim($recommendId_top) ) {
                $recommendSn_top = 0;
                $recommendId_top = "";
                $tex_type_top = "";
                $rate_sport_top = 0;
                $rate_minigame_top = 0;
                $one_folder_flag_top = 0;
            } else {
                //-> 부본사 정산정보를 가져온다.
                $sql = "SELECT * FROM tb_partner WHERE rec_lev = 9 AND rec_id = '{$recommendId_top}'";
                $topRecData = $this->db->exeSql($sql);
                if ( !count($topRecData) ) continue;

                $recommendSn_top = $topRecData[0]["Idx"];
                $recommendId_top = $topRecData[0]["rec_id"];
                $tex_type_top = $topRecData[0]["rec_tex_type"];									//-> 부본사 정산타입코드
                $rate_sport_top = $topRecData[0]["rec_rate_sport"];							//-> 부본사 스포츠 정산 비율%
                $rate_minigame_top = $topRecData[0]["rec_rate_minigame"];				//-> 부본사 미니게임 정산 비율%
                $one_folder_flag_top = $topRecData[0]["rec_one_folder_flag"];		//-> 부본사 단폴더 정산 포함 여부
            }

            //-> 단폴 포함 여부.
            if ( $one_folder_flag == 0 ) {
                $add_where = " and betting_cnt > 1";	//-> 미포함
            } else {
                $add_where = "";	//-> 포함
            }

            $result = array();
            //-> 결과대기중 배팅합계
            $sql = "select ifnull(sum(betting_money),0) as total_betting_ready
						from tb_game_cart 
						where partner_sn = '".$recommendSn."' and kubun = 'Y' and is_account = 1 and result = 0 and 
									regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59'".$add_where;
            /*$sql = "select ifnull(sum(betting_money),0) as total_betting_ready
						from tb_game_cart 
						where partner_sn = '".$recommendSn."' and kubun = 'Y' and is_account = 1 and result = 0 
						and regdate > '".$beginDate."' ".$add_where;*/
            $res = $this->db->exeSql($sql);
            $total_betting_ready = $res[0]["total_betting_ready"];

            //-> 스포츠 당첨된 배팅합계 + 당첨된 금액(배당)
            $sql = "select ifnull(sum(betting_money),0) as total_betting_win, ifnull(sum(result_money),0) as total_result_win
						from tb_game_cart 
						where partner_sn = '".$recommendSn."' and kubun = 'Y' and is_account = 1 and result = 1 and last_special_code < 3 and
									regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59'".$add_where;
            /*$sql = "select ifnull(sum(betting_money),0) as total_betting_win, ifnull(sum(result_money),0) as total_result_win
						from tb_game_cart 
						where partner_sn = '".$recommendSn."' and kubun = 'Y' and is_account = 1 and result = 1 and last_special_code < 3 and
									regdate > '".$beginDate."' ".$add_where;*/

            $res = $this->db->exeSql($sql);
            $total_betting_win = $res[0]["total_betting_win"];
            $total_result_win = $res[0]["total_result_win"];

            //-> 스포츠 낙첨된 배팅합계
            $sql = "select ifnull(sum(betting_money),0) as total_betting_lose
						from tb_game_cart 
						where partner_sn = '".$recommendSn."' and kubun = 'Y' and is_account = 1 and result = 2 and last_special_code < 3 and
									regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59'".$add_where;
            /*$sql = "select ifnull(sum(betting_money),0) as total_betting_lose
						from tb_game_cart 
						where partner_sn = '".$recommendSn."' and kubun = 'Y' and is_account = 1 and result = 2 and last_special_code < 3 and
									regdate > '".$beginDate."'".$add_where;*/

            $res = $this->db->exeSql($sql);
            $total_betting_lose = $res[0]["total_betting_lose"];

            //-> 미니게임 당첨된 배팅합계 + 당첨된 금액(배당)
            $sql = "select ifnull(sum(betting_money),0) as total_betting_win, ifnull(sum(result_money),0) as total_result_win
						from tb_game_cart 
						where partner_sn = '".$recommendSn."' and kubun = 'Y' and is_account = 1 and result = 1 and last_special_code >= 3 and
									regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59'";
            /*$sql = "select ifnull(sum(betting_money),0) as total_betting_win, ifnull(sum(result_money),0) as total_result_win
						from tb_game_cart 
						where partner_sn = '".$recommendSn."' and kubun = 'Y' and is_account = 1 and result = 1 and last_special_code >= 3 and
									regdate > '".$beginDate."'";*/

            $res = $this->db->exeSql($sql);
            $total_betting_win_mgame = $res[0]["total_betting_win"];
            $total_result_win_mgame = $res[0]["total_result_win"];

            //-> 미니게임 낙첨된 배팅합계
            $sql = "select ifnull(sum(betting_money),0) as total_betting_lose
						from tb_game_cart 
						where partner_sn = '".$recommendSn."' and kubun = 'Y' and is_account = 1 and result = 2 and last_special_code >= 3 and
									regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59'";
            /*$sql = "select ifnull(sum(betting_money),0) as total_betting_lose
						from tb_game_cart 
						where partner_sn = '".$recommendSn."' and kubun = 'Y' and is_account = 1 and result = 2 and last_special_code >= 3 and
									regdate > '".$beginDate."'";*/

            $res = $this->db->exeSql($sql);
            $total_betting_lose_mgame = $res[0]["total_betting_lose"];

            //-> 입금 합계
            $sql = "select ifnull(sum(agree_amount),0) as total_charge
						from tb_charge_log 
						where state = 1 and member_sn in(select sn from tb_people where recommend_sn = '".$recommendSn."') and 
									regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59'";

            /*$sql = "select ifnull(sum(agree_amount),0) as total_charge
						from tb_charge_log 
						where state = 1 and member_sn in(select sn from tb_people where recommend_sn = '".$recommendSn."') and 
									regdate > '".$beginDate."'";*/

            $res = $this->db->exeSql($sql);
            $total_charge = $res[0]["total_charge"];

            //-> 출금 합계
            $sql = "select ifnull(sum(agree_amount),0) as total_exchange
						from tb_exchange_log 
						where state = 1 and member_sn in(select sn from tb_people where recommend_sn = '".$recommendSn."') and
									regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59'";
            /*$sql = "select ifnull(sum(agree_amount),0) as total_exchange
						from tb_exchange_log 
						where state = 1 and member_sn in(select sn from tb_people where recommend_sn = '".$recommendSn."') and
									regdate > '".$beginDate."'";*/

            $res = $this->db->exeSql($sql);
            $total_exchange = $res[0]["total_exchange"];

            //-> 충전(첫충) 포인트 합계
            $sql = "select ifnull(sum(amount),0) as total_mileage_charge
						from tb_mileage_log
						where state = 1 and amount > 0 and regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59' and 
									member_sn in(select sn from tb_people where mem_status != 'G') and 
									member_sn in(select sn from tb_people where recommend_sn = '".$recommendSn."')";

            /*$sql = "select ifnull(sum(amount),0) as total_mileage_charge
						from tb_mileage_log
						where state = 1 and amount > 0 and regdate > '".$beginDate."' and 
									member_sn in(select sn from tb_people where mem_status != 'G') and 
									member_sn in(select sn from tb_people where recommend_sn = '".$recommendSn."')";*/

            $res = $this->db->exeSql($sql);
            $total_mileage_charge = $res[0]["total_mileage_charge"];

            //-> 추천인 낙첨 포인트 합계
            $sql = "select ifnull(sum(amount),0) as total_mileage_recommend_lose
						from tb_mileage_log
						where state = 12 and amount > 0 and regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59' and 
									member_sn in(select sn from tb_people where mem_status != 'G') and 
									member_sn in(select sn from tb_people where recommend_sn = '".$recommendSn."')";

            /*$sql = "select ifnull(sum(amount),0) as total_mileage_recommend_lose
						from tb_mileage_log
						where state = 12 and amount > 0 and regdate > '".$beginDate."' and 
									member_sn in(select sn from tb_people where mem_status != 'G') and 
									member_sn in(select sn from tb_people where recommend_sn = '".$recommendSn."')";*/

            $res = $this->db->exeSql($sql);
            $total_mileage_recommend_lose = $res[0]["total_mileage_recommend_lose"];

            //-> 다폴더 포인트 합계
            $sql = "select ifnull(sum(amount),0) as total_mileage_multi_folder
						from tb_mileage_log
						where state = 3 and amount > 0 and regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59' and 
									member_sn in(select sn from tb_people where mem_status != 'G') and 
									member_sn in(select sn from tb_people where recommend_sn = '".$recommendSn."')";

            /*$sql = "select ifnull(sum(amount),0) as total_mileage_multi_folder
						from tb_mileage_log
						where state = 3 and amount > 0 and regdate > '".$beginDate."' and 
									member_sn in(select sn from tb_people where mem_status != 'G') and 
									member_sn in(select sn from tb_people where recommend_sn = '".$recommendSn."')";*/

            $res = $this->db->exeSql($sql);
            $total_mileage_multi_folder = $res[0]["total_mileage_multi_folder"];

            //-> 다폴더 낙첨 포인트 합계
            $sql = "select ifnull(sum(a.amount),0) as total_mileage_multi_folder_lose
						from tb_mileage_log a, tb_game_cart b 
						where a.state = 4 and a.amount > 0 and a.betting_no = b.betting_no and b.betting_cnt > 1 and 
									a.regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59' and 
									a.member_sn in(select sn from tb_people where mem_status != 'G') and 
									a.member_sn in(select sn from tb_people where recommend_sn = '".$recommendSn."')";
            /*$sql = "select ifnull(sum(a.amount),0) as total_mileage_multi_folder_lose
						from tb_mileage_log a, tb_game_cart b 
						where a.state = 4 and a.amount > 0 and a.betting_no = b.betting_no and b.betting_cnt > 1 and 
									a.regdate > '".$beginDate."' and 
									a.member_sn in(select sn from tb_people where mem_status != 'G') and 
									a.member_sn in(select sn from tb_people where recommend_sn = '".$recommendSn."')";*/

            $res = $this->db->exeSql($sql);
            $total_mileage_multi_folder_lose = $res[0]["total_mileage_multi_folder_lose"];

            //-> 단폴더 낙첨 포인트 합계
            $sql = "select ifnull(sum(a.amount),0) as total_mileage_one_folder_lose
						from tb_mileage_log a, tb_game_cart b 
						where a.state = 4 and a.amount > 0 and a.betting_no = b.betting_no and b.betting_cnt = 1 and 
									a.regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59' and 
									a.member_sn in(select sn from tb_people where mem_status != 'G') and 
									a.member_sn in(select sn from tb_people where recommend_sn = '".$recommendSn."')";
            /*$sql = "select ifnull(sum(a.amount),0) as total_mileage_one_folder_lose
						from tb_mileage_log a, tb_game_cart b 
						where a.state = 4 and a.amount > 0 and a.betting_no = b.betting_no and b.betting_cnt = 1 and 
									a.regdate > '".$beginDate."' and 
									a.member_sn in(select sn from tb_people where mem_status != 'G') and 
									a.member_sn in(select sn from tb_people where recommend_sn = '".$recommendSn."')";*/

            $res = $this->db->exeSql($sql);
            $total_mileage_one_folder_lose = $res[0]["total_mileage_one_folder_lose"];

            //-> 정산방식 + 수익율 + 정산금 계산 ----------
            // 배팅 = (배팅금 * 수익율) / 100
            // 낙첨 = ((미당첨배팅금 - 당첨배당금) * 수익율) / 100
            // 입출 = ((입금 - 출금) * 수익율) / 100

            if ( $tex_type_top == "in" or $tex_type == "in" ) {
                //-> 기본정산비율인 $rate_sport의 비율로 정산.
                $tex_type_name = "입금";
                $tex_money = ($total_charge * $rate_sport) / 100;					//-> 총판
                $tex_money_top = ($total_charge * $rate_sport_top) / 100;	//-> 부본사

            } else if ( $tex_type_top == "inout" or $tex_type == "inout" ) {
                //-> 기본정산비율인 $rate_sport의 비율로 정산.
                $tex_type_name = "입금-출금";
                $tex_money = (($total_charge - $total_exchange) * $rate_sport) / 100;					//-> 총판
                $tex_money_top = (($total_charge - $total_exchange) * $rate_sport_top) / 100;	//-> 부본사

            } else if ( $tex_type_top == "betting" or $tex_type == "betting" ) {
                //-> 기본정산비율인 $rate_sport의 비율로 정산.
                $tex_type_name = "배팅금(미니제외)";
                $tex_money = (($total_betting_win + $total_betting_lose) * $rate_sport) / 100;					//-> 총판
                $tex_money_top = (($total_betting_win + $total_betting_lose) * $rate_sport_top) / 100;	//-> 부본사

            } else if ( $tex_type_top == "betting_m" or $tex_type == "betting_m" ) {
                //-> 기본정산비율인 $rate_sport의 비율로 정산.
                $tex_type_name = "배팅금(미니포함)";

                //-> 스포츠 : 총배팅금 * 비율%
                $tex_money_s = (($total_betting_win + $total_betting_lose) * $rate_sport) / 100;
                $tex_money_top_s = (($total_betting_win + $total_betting_lose) * $rate_sport_top) / 100;

                //-> 미니게임 : 총배팅금 * 비율%
                $tex_money_m = (($total_betting_win_mgame + $total_betting_lose_mgame) * $rate_minigame) / 100;
                $tex_money_top_m = (($total_betting_win_mgame + $total_betting_lose_mgame) * $rate_minigame_top) / 100;

                //-> 합산
                $tex_money = $tex_money_s + $tex_money_m;
                $tex_money_top = $tex_money_top_s + $tex_money_top_m;

            } else if ( $tex_type_top == "fail" or $tex_type == "fail" ) {
                //-> 기본정산비율인 $rate_sport의 비율로 정산.
                $tex_type_name = "낙첨금(미니제외)";

                $sum_betting_money = $total_betting_win + $total_betting_lose;
                $tex_money = (($sum_betting_money - $total_result_win) * $rate_sport) / 100;					//-> 총판
                $tex_money_top = (($sum_betting_money - $total_result_win) * $rate_sport_top) / 100;	//-> 부본사

            } else if ( $tex_type_top == "fail_m" or $tex_type == "fail_m" ) {
                //-> 기본정산비율인 $rate_sport의 비율로 정산.
                $tex_type_name = "낙첨금(미니포함)";

                //-> 스포츠 : 낙첨금 * 비율%
                $tex_money_s = (($total_betting_win + $total_betting_lose - $total_result_win) * $rate_sport) / 100;
                $tex_money_top_s = (($total_betting_win + $total_betting_lose - $total_result_win) * $rate_sport_top) / 100;

                //-> 미니게임 : 낙첨금 * 비율%
                $tex_money_m = (($total_betting_win_mgame + $total_betting_lose_mgame - $total_result_win_mgame) * $rate_minigame) / 100;
                $tex_money_top_m = (($total_betting_win_mgame + $total_betting_lose_mgame - $total_result_win_mgame) * $rate_minigame_top) / 100;

                //-> 합산
                $tex_money = $tex_money_s + $tex_money_m;
                $tex_money_top = $tex_money_top_s + $tex_money_top_m;

            } else if ( $tex_type_top == "Swin_Mbet" or $tex_type == "Swin_Mbet" ) {
                //-> 스포츠낙첨은 $rate_sport로 미니게임롤링은 $rate_minigame로 정산.
                $tex_type_name = "스낙+미롤";

                //-> 스포츠 - 총배팅금 - 당첨금 * 비율%
                $tex_money_s = ((($total_betting_win + $total_betting_lose) - $total_result_win) * $rate_sport) / 100;
                $tex_money_top_s = ((($total_betting_win + $total_betting_lose) - $total_result_win) * $rate_sport_top) / 100;

                //-> 미니게임롤링 - 총배팅금 * 비율%
                $tex_money_m = (($total_betting_win_mgame + $total_betting_lose_mgame) * $rate_minigame) / 100;
                $tex_money_top_m = (($total_betting_win_mgame + $total_betting_lose_mgame) * $rate_minigame_top) / 100;

                //-> 합산
                $tex_money = $tex_money_s + $tex_money_m;
                $tex_money_top = $tex_money_top_s + $tex_money_top_m;

            } else if ( $tex_type_top == "Sbet_Mlose" or $tex_type == "Sbet_Mlose" ) {
                //-> 스포츠는 $rate_sport로 미니게임은 $rate_minigame로 정산.
                $tex_type_name = "S배팅+M낙첨";

                //-> 스포츠 : 총배팅금 * 비율%
                $tex_money_s = (($total_betting_win + $total_betting_lose) * $rate_sport) / 100;
                $tex_money_top_s = (($total_betting_win + $total_betting_lose) * $rate_sport_top) / 100;

                //-> 미니게임 : 총배팅금 - 당첨배당금 * 비율%
                $tex_money_m = (($total_betting_win_mgame + $total_betting_lose_mgame - $total_result_win_mgame) * $rate_minigame) / 100;
                $tex_money_top_m = (($total_betting_win_mgame + $total_betting_lose_mgame - $total_result_win_mgame) * $rate_minigame_top) / 100;

                //-> 합산
                $tex_money = $tex_money_s + $tex_money_m;
                $tex_money_top = $tex_money_top_s + $tex_money_top_m;

            } else {
                $tex_type_name = "미정산";
                $tex_money = 0;
                $tex_money_top = 0;
            }

            //-> 부본사정산금 - 총판정산금 = 부본사최종정산금
            if ( !trim($recommendId_top) ) {
                $tex_money_top = 0;
            } else {
                $tex_money_top = $tex_money_top - $tex_money;
            }

            $add_tex_rate = $rate_sport." | ".$rate_minigame;
            $add_tex_rate_top = $rate_sport_top." | ".$rate_minigame_top;

            //-> 이미 Insert 되었는지 확인, 있다면 Update
            $sql = "select idx, get_tex_money, get_tex_money_top from tb_partner_tex where rec_sn = '".$recommendSn."' and regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59'";
            //$sql = "select idx, get_tex_money, get_tex_money_top from tb_partner_tex where rec_sn = '".$recommendSn."' and regdate > '".$todayDate." 00:00:00' and '".$todayDate." 23:59:59'";

            $res = $this->db->exeSql($sql);
            $tex_log_idx = $res[0]["idx"];
            $get_tex_money = $res[0]["get_tex_money"];
            $get_tex_money_top = $res[0]["get_tex_money_top"];

            if ( $tex_log_idx > 0 )
            {
                //-> 정산 정보 Update
                $param = array(
                    'rec_sn_top' => $recommendSn_top,
                    'rec_id_top' => $recommendId_top,
                    'save_rate_type' => $tex_type_name,
                    'save_rate_top' => $add_tex_rate_top,
                    'save_rate' => $add_tex_rate,
                    'save_one_folder_flag' => $one_folder_flag,
                    'money_to_charge' => $total_charge,
                    'money_to_exchange' => $total_exchange,
                    'betting_to_ready' => $total_betting_ready,
                    'betting_to_win' => $total_betting_win,
                    'betting_to_win_mgame' => $total_betting_win_mgame,
                    'betting_to_lose' => $total_betting_lose,
                    'betting_to_lose_mgame' => $total_betting_lose_mgame,
                    'result_to_win' => $total_result_win,
                    'result_to_win_mgame' => $total_result_win_mgame,
                    'mileage_to_charge' => $total_mileage_charge,
                    'mileage_to_recomm_lose' => $total_mileage_recommend_lose,
                    'mileage_to_multi_folder' => $total_mileage_multi_folder,
                    'mileage_to_multi_folder_lose' => $total_mileage_multi_folder_lose,
                    'mileage_to_one_folder_lose' => $total_mileage_one_folder_lose,
                    'tex_money_top' => $tex_money_top,
                    'tex_money' => $tex_money,
                    'updatedate' => $regdate
                );
                $update_res = $this->db->setUpdate("tb_partner_tex", $param, "idx = '".$tex_log_idx."'");
                $update_res = $this->db->exeSql();
                if ( $update_res ) $procCnt++;
            } else {
                //-> 정산 정보 Insert
                $param = array(
                    'rec_sn_top' => $recommendSn_top,
                    'rec_sn' => $recommendSn,
                    'rec_id_top' => $recommendId_top,
                    'rec_id' => $recommendId,
                    'save_rate_type' => $tex_type_name,
                    'save_rate_top' => $add_tex_rate_top,
                    'save_rate' => $add_tex_rate,
                    'save_one_folder_flag' => $one_folder_flag,
                    'money_to_charge' => $total_charge,
                    'money_to_exchange' => $total_exchange,
                    'betting_to_ready' => $total_betting_ready,
                    'betting_to_win' => $total_betting_win,
                    'betting_to_win_mgame' => $total_betting_win_mgame,
                    'betting_to_lose' => $total_betting_lose,
                    'betting_to_lose_mgame' => $total_betting_lose_mgame,
                    'result_to_win' => $total_result_win,
                    'result_to_win_mgame' => $total_result_win_mgame,
                    'mileage_to_charge' => $total_mileage_charge,
                    'mileage_to_recomm_lose' => $total_mileage_recommend_lose,
                    'mileage_to_multi_folder' => $total_mileage_multi_folder,
                    'mileage_to_multi_folder_lose' => $total_mileage_multi_folder_lose,
                    'mileage_to_one_folder_lose' => $total_mileage_one_folder_lose,
                    'tex_money_top' => $tex_money_top,
                    'tex_money' => $tex_money,
                    'updatedate' => $regdate,
                    'regdate' => $regdate
                );
                $tex_log_idx = $this->db->setInsert("tb_partner_tex", $param);
                $tex_log_idx = $this->db->exeSql();
                if ( $tex_log_idx ) $procCnt++;
            }

            //-> 정산타입이 [입금-출금] 이면 결과대기 배팅금이 없어도 정산을 처리 한다.
            if ( $tex_type_name == "입금-출금" ) {
                $total_betting_ready = 0;
            }

            //-> 결과대기 배팅금이 없으면 부본사와 총판에 정산금을 내린다.
            if ( ($update_res == true or $tex_log_idx ) and $total_betting_ready == 0 and $get_tex_money == 0 and $get_tex_money_top == 0 and ($tex_money != 0 or $tex_money_top != 0) ) {
                //-> 현재 부본사 머니
                $sql = "select rec_money from tb_partner where Idx = '".$recommendSn_top."'";
                $res = $this->db->exeSql($sql);
                $before_money_top = $res[0]["rec_money"];
                $after_money_top = $res[0]["rec_money"] + $tex_money_top;

                //-> 부본사 머니 업데이트
                $sql = "update tb_partner set rec_money = '".$after_money_top."' where Idx = '".$recommendSn_top."'";
                if ( $res = $this->db->exeSql($sql) ) {
                    //-> 정산로그 [get_tex_money, texdate] Update
                    $sql = "update tb_partner_tex set get_tex_money_top = '".$tex_money_top."', texdate = '".$regdate."' where idx = '".$tex_log_idx."'";
                    $this->db->exeSql($sql);

                    //-> 총판 머니 로그 Insert
                    $param = array(
                        'rec_sn' => $recommendSn_top, 'amount' => $tex_money_top, 'before_money' => $before_money_top, 'after_money' => $after_money_top,
                        'state' => 9, 'status_message' => '부본사 정산금 입금', 'proc_flag' => 1, 'is_read' => 1, 'procdate' => $regdate, 'regdate' => $regdate
                    );
                    $this->db->setInsert("tb_partner_money_log", $param);
                    $this->db->exeSql();
                }

                //-> 현재 총판 머니
                $sql = "select rec_money from tb_partner where Idx = '".$recommendSn."'";
                $res = $this->db->exeSql($sql);
                $before_money = $res[0]["rec_money"];
                $after_money = $res[0]["rec_money"] + $tex_money;

                //-> 총판 머니 업데이트
                $sql = "update tb_partner set rec_money = '".$after_money."' where Idx = '".$recommendSn."'";
                if ( $res = $this->db->exeSql($sql) ) {
                    //-> 정산로그 [get_tex_money, texdate] Update
                    $sql = "update tb_partner_tex set get_tex_money = '".$tex_money."', texdate = '".$regdate."' where idx = '".$tex_log_idx."'";
                    $this->db->exeSql($sql);

                    //-> 총판 머니 로그 Insert
                    $param = array(
                        'rec_sn' => $recommendSn,
                        'amount' => $tex_money,
                        'before_money' => $before_money,
                        'after_money' => $after_money,
                        'state' => 1,
                        'status_message' => '총판 정산금 입금',
                        'proc_flag' => 1,
                        'is_read' => 1,
                        'procdate' => $regdate,
                        'regdate' => $regdate
                    );
                    $this->db->setInsert("tb_partner_money_log", $param);
                    $this->db->exeSql();
                }
            }

            unset($result);
        } //-> END foreach
 	}

    function getListTex()
    {
        $textDataList = array();
        $sort = array();

        $beginDate = date("Y-m-d",time());
        $regdate = date("Y-m-d H:i:s",time());


        /* 처리 로직 : 총판 기준으로 정산 데이터를 가져와서 부본사와 총판의 정산율을 계산*/

        $sql = "SELECT * FROM tb_partner WHERE rec_lev = 1 and status != 2 ORDER BY idx asc";

        $recData = $this->db->exeSql($sql);
        $procCnt = 0;
        foreach($recData as $row){
            $recommendSn = $row["Idx"];
            $recommendId = $row["rec_id"];
            $tex_type = $row["rec_tex_type"];									//-> 총판 정산타입코드
            $rate_sport = $row["rec_rate_sport"];							//-> 총판 스포츠 정산 비율%
            $rate_minigame = $row["rec_rate_minigame"];				//-> 총판 미니게임 정산 비율%
            $one_folder_flag = $row["rec_one_folder_flag"];		//-> 총판 단폴더 정산 포함 여부
            $recommendId_top = $row["rec_parent_id"];					//-> 총판 부본사ID

            //-> 만약 총판이 부본사에 소속되어 있지 않다면 총판만 정산.
            if ( !trim($recommendId_top) ) {
                $recommendSn_top = 0;
                $recommendId_top = "";
                $tex_type_top = "";
                $rate_sport_top = 0;
                $rate_minigame_top = 0;
                $one_folder_flag_top = 0;
            } else {
                //-> 부본사 정산정보를 가져온다.
                $sql = "SELECT * FROM tb_partner WHERE rec_lev = 9 AND rec_id = '{$recommendId_top}'";
                $topRecData = $this->db->exeSql($sql);
                if ( !count($topRecData) ) continue;

                $recommendSn_top = $topRecData[0]["Idx"];
                $recommendId_top = $topRecData[0]["rec_id"];
                $tex_type_top = $topRecData[0]["rec_tex_type"];									//-> 부본사 정산타입코드
                $rate_sport_top = $topRecData[0]["rec_rate_sport"];							//-> 부본사 스포츠 정산 비율%
                $rate_minigame_top = $topRecData[0]["rec_rate_minigame"];				//-> 부본사 미니게임 정산 비율%
                $one_folder_flag_top = $topRecData[0]["rec_one_folder_flag"];		//-> 부본사 단폴더 정산 포함 여부
            }

            //-> 단폴 포함 여부.
            if ( $one_folder_flag == 0 ) {
                $add_where = " and betting_cnt > 1";	//-> 미포함
            } else {
                $add_where = "";	//-> 포함
            }

            $result = array();
            //-> 결과대기중 배팅합계
            $sql = "select ifnull(sum(betting_money),0) as total_betting_ready
                    from tb_game_cart 
                    where partner_sn = '".$recommendSn."' and kubun = 'Y' and is_account = 1 and result = 0 and 
                    regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59'".$add_where;
           
            $res = $this->db->exeSql($sql);
            $total_betting_ready = $res[0]["total_betting_ready"];

            //-> 스포츠 당첨된 배팅합계 + 당첨된 금액(배당)
            $sql = "select ifnull(sum(betting_money),0) as total_betting_win, ifnull(sum(result_money),0) as total_result_win
                    from tb_game_cart 
                    where partner_sn = '".$recommendSn."' and kubun = 'Y' and is_account = 1 and result = 1 and last_special_code < 5 and
                    regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59'".$add_where;
            
            $res = $this->db->exeSql($sql);
            $total_betting_win = $res[0]["total_betting_win"];
            $total_result_win = $res[0]["total_result_win"];

            //-> 스포츠 낙첨된 배팅합계
            $sql = "select ifnull(sum(betting_money),0) as total_betting_lose
                    from tb_game_cart 
                    where partner_sn = '".$recommendSn."' and kubun = 'Y' and is_account = 1 and result = 2 and last_special_code < 5 and
                    regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59'".$add_where;
            
            $res = $this->db->exeSql($sql);
            $total_betting_lose = $res[0]["total_betting_lose"];

            //-> 미니게임 당첨된 배팅합계 + 당첨된 금액(배당)
            $sql = "select ifnull(sum(betting_money),0) as total_betting_win, ifnull(sum(result_money),0) as total_result_win
                    from tb_game_cart 
                    where partner_sn = '".$recommendSn."' and kubun = 'Y' and is_account = 1 and result = 1 and last_special_code >= 5 and
                    regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59'";
            
            $res = $this->db->exeSql($sql);
            $total_betting_win_mgame = $res[0]["total_betting_win"];
            $total_result_win_mgame = $res[0]["total_result_win"];

            //-> 미니게임 낙첨된 배팅합계
            $sql = "select ifnull(sum(betting_money),0) as total_betting_lose
                    from tb_game_cart 
                    where partner_sn = '".$recommendSn."' and kubun = 'Y' and is_account = 1 and result = 2 and last_special_code >= 5 and
                    regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59'";
            
            $res = $this->db->exeSql($sql);
            $total_betting_lose_mgame = $res[0]["total_betting_lose"];

            //-> 입금 합계
            $sql = "select ifnull(sum(agree_amount),0) as total_charge
                    from tb_charge_log 
                    where state = 1 and member_sn in(select sn from tb_people where recommend_sn = '".$recommendSn."') and 
                    regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59'";

            $res = $this->db->exeSql($sql);
            $total_charge = $res[0]["total_charge"];

            //-> 출금 합계
            $sql = "select ifnull(sum(agree_amount),0) as total_exchange
                    from tb_exchange_log 
                    where state = 1 and member_sn in(select sn from tb_people where recommend_sn = '".$recommendSn."') and
                    regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59'";
            
            $res = $this->db->exeSql($sql);
            $total_exchange = $res[0]["total_exchange"];

            //-> 충전(첫충) 포인트 합계
            $sql = "select ifnull(sum(amount),0) as total_mileage_charge
                    from tb_mileage_log
                    where state = 1 and amount > 0 and regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59' and 
                        member_sn in(select sn from tb_people where mem_status != 'G') and 
                        member_sn in(select sn from tb_people where recommend_sn = '".$recommendSn."')";

            $res = $this->db->exeSql($sql);
            $total_mileage_charge = $res[0]["total_mileage_charge"];

            //-> 추천인 낙첨 포인트 합계
            $sql = "select ifnull(sum(amount),0) as total_mileage_recommend_lose
                    from tb_mileage_log
                    where state = 12 and amount > 0 and regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59' and 
                        member_sn in(select sn from tb_people where mem_status != 'G') and 
                        member_sn in(select sn from tb_people where recommend_sn = '".$recommendSn."')";

            $res = $this->db->exeSql($sql);
            $total_mileage_recommend_lose = $res[0]["total_mileage_recommend_lose"];

            //-> 다폴더 포인트 합계
            $sql = "select ifnull(sum(amount),0) as total_mileage_multi_folder
                    from tb_mileage_log
                    where state = 3 and amount > 0 and regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59' and 
                        member_sn in(select sn from tb_people where mem_status != 'G') and 
                        member_sn in(select sn from tb_people where recommend_sn = '".$recommendSn."')";

            $res = $this->db->exeSql($sql);
            $total_mileage_multi_folder = $res[0]["total_mileage_multi_folder"];

            //-> 다폴더 낙첨 포인트 합계
            $sql = "select ifnull(sum(a.amount),0) as total_mileage_multi_folder_lose
                    from tb_mileage_log a, tb_game_cart b 
                    where a.state = 4 and a.amount > 0 and a.betting_no = b.betting_no and b.betting_cnt > 1 and 
                        a.regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59' and 
                        a.member_sn in(select sn from tb_people where mem_status != 'G') and 
                        a.member_sn in(select sn from tb_people where recommend_sn = '".$recommendSn."')";
            
            $res = $this->db->exeSql($sql);
            $total_mileage_multi_folder_lose = $res[0]["total_mileage_multi_folder_lose"];

            //-> 단폴더 낙첨 포인트 합계
            $sql = "select ifnull(sum(a.amount),0) as total_mileage_one_folder_lose
                    from tb_mileage_log a, tb_game_cart b 
                    where a.state = 4 and a.amount > 0 and a.betting_no = b.betting_no and b.betting_cnt = 1 and 
                        a.regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59' and 
                        a.member_sn in(select sn from tb_people where mem_status != 'G') and 
                        a.member_sn in(select sn from tb_people where recommend_sn = '".$recommendSn."')";
            
            $res = $this->db->exeSql($sql);
            $total_mileage_one_folder_lose = $res[0]["total_mileage_one_folder_lose"];

            //-> 정산방식 + 수익율 + 정산금 계산 ----------
            // 배팅 = (배팅금 * 수익율) / 100
            // 낙첨 = ((미당첨배팅금 - 당첨배당금) * 수익율) / 100
            // 입출 = ((입금 - 출금) * 수익율) / 100

            if ( $tex_type_top == "in" or $tex_type == "in" ) {
                //-> 기본정산비율인 $rate_sport의 비율로 정산.
                $tex_type_name = "입금";
                $tex_money = ($total_charge * $rate_sport) / 100;					//-> 총판
                $tex_money_top = ($total_charge * $rate_sport_top) / 100;	//-> 부본사

            } else if ( $tex_type_top == "inout" or $tex_type == "inout" ) {
                //-> 기본정산비율인 $rate_sport의 비율로 정산.
                $tex_type_name = "입금-출금";
                $tex_money = (($total_charge - $total_exchange) * $rate_sport) / 100;					//-> 총판
                $tex_money_top = (($total_charge - $total_exchange) * $rate_sport_top) / 100;	//-> 부본사

            } else if ( $tex_type_top == "betting" or $tex_type == "betting" ) {
                //-> 기본정산비율인 $rate_sport의 비율로 정산.
                $tex_type_name = "배팅금(미니제외)";
                $tex_money = (($total_betting_win + $total_betting_lose) * $rate_sport) / 100;					//-> 총판
                $tex_money_top = (($total_betting_win + $total_betting_lose) * $rate_sport_top) / 100;	//-> 부본사

            } else if ( $tex_type_top == "betting_m" or $tex_type == "betting_m" ) {
                //-> 기본정산비율인 $rate_sport의 비율로 정산.
                $tex_type_name = "배팅금(미니포함)";

                //-> 스포츠 : 총배팅금 * 비율%
                $tex_money_s = (($total_betting_win + $total_betting_lose) * $rate_sport) / 100;
                $tex_money_top_s = (($total_betting_win + $total_betting_lose) * $rate_sport_top) / 100;

                //-> 미니게임 : 총배팅금 * 비율%
                $tex_money_m = (($total_betting_win_mgame + $total_betting_lose_mgame) * $rate_minigame) / 100;
                $tex_money_top_m = (($total_betting_win_mgame + $total_betting_lose_mgame) * $rate_minigame_top) / 100;

                //-> 합산
                $tex_money = $tex_money_s + $tex_money_m;
                $tex_money_top = $tex_money_top_s + $tex_money_top_m;

            } else if ( $tex_type_top == "fail" or $tex_type == "fail" ) {
                //-> 기본정산비율인 $rate_sport의 비율로 정산.
                $tex_type_name = "낙첨금(미니제외)";

                $sum_betting_money = $total_betting_win + $total_betting_lose;
                $tex_money = (($sum_betting_money - $total_result_win) * $rate_sport) / 100;					//-> 총판
                $tex_money_top = (($sum_betting_money - $total_result_win) * $rate_sport_top) / 100;	//-> 부본사

            } else if ( $tex_type_top == "fail_m" or $tex_type == "fail_m" ) {
                //-> 기본정산비율인 $rate_sport의 비율로 정산.
                $tex_type_name = "낙첨금(미니포함)";

                //-> 스포츠 : 낙첨금 * 비율%
                $tex_money_s = (($total_betting_win + $total_betting_lose - $total_result_win) * $rate_sport) / 100;
                $tex_money_top_s = (($total_betting_win + $total_betting_lose - $total_result_win) * $rate_sport_top) / 100;

                //-> 미니게임 : 낙첨금 * 비율%
                $tex_money_m = (($total_betting_win_mgame + $total_betting_lose_mgame - $total_result_win_mgame) * $rate_minigame) / 100;
                $tex_money_top_m = (($total_betting_win_mgame + $total_betting_lose_mgame - $total_result_win_mgame) * $rate_minigame_top) / 100;

                //-> 합산
                $tex_money = $tex_money_s + $tex_money_m;
                $tex_money_top = $tex_money_top_s + $tex_money_top_m;

            } else if ( $tex_type_top == "Swin_Mbet" or $tex_type == "Swin_Mbet" ) {
                //-> 스포츠낙첨은 $rate_sport로 미니게임롤링은 $rate_minigame로 정산.
                $tex_type_name = "스낙+미롤";

                //-> 스포츠 - 총배팅금 - 당첨금 * 비율%
                $tex_money_s = ((($total_betting_win + $total_betting_lose) - $total_result_win) * $rate_sport) / 100;
                $tex_money_top_s = ((($total_betting_win + $total_betting_lose) - $total_result_win) * $rate_sport_top) / 100;

                //-> 미니게임롤링 - 총배팅금 * 비율%
                $tex_money_m = (($total_betting_win_mgame + $total_betting_lose_mgame) * $rate_minigame) / 100;
                $tex_money_top_m = (($total_betting_win_mgame + $total_betting_lose_mgame) * $rate_minigame_top) / 100;

                //-> 합산
                $tex_money = $tex_money_s + $tex_money_m;
                $tex_money_top = $tex_money_top_s + $tex_money_top_m;

            } else if ( $tex_type_top == "Sbet_Mlose" or $tex_type == "Sbet_Mlose" ) {
                //-> 스포츠는 $rate_sport로 미니게임은 $rate_minigame로 정산.
                $tex_type_name = "S배팅+M낙첨";

                //-> 스포츠 : 총배팅금 * 비율%
                $tex_money_s = (($total_betting_win + $total_betting_lose) * $rate_sport) / 100;
                $tex_money_top_s = (($total_betting_win + $total_betting_lose) * $rate_sport_top) / 100;

                //-> 미니게임 : 총배팅금 - 당첨배당금 * 비율%
                $tex_money_m = (($total_betting_win_mgame + $total_betting_lose_mgame - $total_result_win_mgame) * $rate_minigame) / 100;
                $tex_money_top_m = (($total_betting_win_mgame + $total_betting_lose_mgame - $total_result_win_mgame) * $rate_minigame_top) / 100;

                //-> 합산
                $tex_money = $tex_money_s + $tex_money_m;
                $tex_money_top = $tex_money_top_s + $tex_money_top_m;

            } else {
                $tex_type_name = "미정산";
                $tex_money = 0;
                $tex_money_top = 0;
            }

            //-> 부본사정산금 - 총판정산금 = 부본사최종정산금
            if ( !trim($recommendId_top) ) {
                $tex_money_top = 0;
            } else {
                $tex_money_top = $tex_money_top - $tex_money;
            }

            $add_tex_rate = $rate_sport." | ".$rate_minigame;
            $add_tex_rate_top = $rate_sport_top." | ".$rate_minigame_top;

            //-> 이미 Insert 되었는지 확인, 있다면 Update
            $sql = "select idx, get_tex_money, get_tex_money_top from tb_partner_tex where rec_sn = '".$recommendSn."' and regdate between '".$beginDate." 00:00:00' and '".$beginDate." 23:59:59'";
            //$sql = "select idx, get_tex_money, get_tex_money_top from tb_partner_tex where rec_sn = '".$recommendSn."' and regdate > '".$todayDate." 00:00:00' and '".$todayDate." 23:59:59'";
            $res = $this->db->exeSql($sql);
            $tex_log_idx = $res[0]["idx"];
            $get_tex_money = $res[0]["get_tex_money"];
            $get_tex_money_top = $res[0]["get_tex_money_top"];

            //-> 정산 정보 Update
            $texData = array(
                'rec_sn_top' => $recommendSn_top,
                'rec_sn' => $recommendSn,
                'rec_id_top' => $recommendId_top,
                'rec_id' => $recommendId,
                'save_rate_type' => $tex_type_name,
                'save_rate_top' => $add_tex_rate_top,
                'save_rate' => $add_tex_rate,
                'save_one_folder_flag' => $one_folder_flag,
                'money_to_charge' => $total_charge,
                'money_to_exchange' => $total_exchange,
                'betting_to_ready' => $total_betting_ready,
                'betting_to_win' => $total_betting_win,
                'betting_to_win_mgame' => $total_betting_win_mgame,
                'betting_to_lose' => $total_betting_lose,
                'betting_to_lose_mgame' => $total_betting_lose_mgame,
                'result_to_win' => $total_result_win,
                'result_to_win_mgame' => $total_result_win_mgame,
                'mileage_to_charge' => $total_mileage_charge,
                'mileage_to_recomm_lose' => $total_mileage_recommend_lose,
                'mileage_to_multi_folder' => $total_mileage_multi_folder,
                'mileage_to_multi_folder_lose' => $total_mileage_multi_folder_lose,
                'mileage_to_one_folder_lose' => $total_mileage_one_folder_lose,
                'tex_money_top' => $tex_money_top,
                'tex_money' => $tex_money,
                'updatedate' => $regdate
            );

            //-> 정산타입이 [입금-출금] 이면 결과대기 배팅금이 없어도 정산을 처리 한다.
            if ( $tex_type_name == "입금-출금" ) {
                $total_betting_ready = 0;
            }

            $sql = "select rec_money from tb_partner where rec_id = '".$recommendId."'";
            $res = $this->db->exeSql($sql);
            $texData["rec_money"] = $res[0]["rec_money"];

            //unset($result);
            $textDataList[] = $texData;
        } //-> END foreach

        foreach ((array) $textDataList as $key => $value) {
            $sort[$key] = $value['rec_id'];
        }

        array_multisort($sort, SORT_ASC, $textDataList);
        return $textDataList;
    }
}
?>