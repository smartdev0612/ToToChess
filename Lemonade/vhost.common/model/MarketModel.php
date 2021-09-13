<?php

class MarketModel extends Lemon_Model 
{
    function getMarketName($market_id  = 0, $sport_sn = 0) {
        $sql = "SELECT mname_ko FROM tb_markets WHERE tb_markets.mid = " . $market_id;
		$r = $this->db->exeSql($sql);

		$marketName = "";

		if(count((array)$r) > 0) {
            $strMarketName = $r[0]["mname_ko"];
            $nameArray = explode("|", $strMarketName);
            switch($sport_sn) {
                case 6046: // 축구
                    $marketName = $nameArray[0];
                    break;
                case 48242: // 농구
                    $marketName = $nameArray[1];
                    break;
                case 154914: // 야구
                    $marketName = $nameArray[2];
                    break;
                case 154830: // 배구
                    $marketName = $nameArray[3];
                    break;
                case 35232: // 아이스 하키
                    $marketName = $nameArray[4];
                    break;
                case 687890: // E스포츠
                    $marketName = $nameArray[5];
                    break;
                default:
                    $marketName = $nameArray[0];
                    break;
            }
        }
		return $marketName;
    }

    function getMarketFamily($market_id = 0) {
        $sql = "SELECT mfamily FROM tb_markets WHERE tb_markets.mid = " . $market_id;
		$r = $this->db->exeSql($sql);
        
		$family = 0;

		if(count((array)$r) > 0) {
            $family = $r[0]["mfamily"];
        }

        return $family;
    }
}

?>