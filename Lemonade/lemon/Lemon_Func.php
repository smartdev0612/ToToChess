<?
/*
* 여러 필요한 메소드 모음 클래스
*/

class Lemon_Func {

	/*
	* 파일 사이즈등을 읽기 쉬운 Kbyte, Mbyte 로 변환
	*/
	public static function formatSize($val, $digits = 3, $mode = 'SI', $bB = 'B'){
        $si = array('', 'K', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y');
        $iec = array('', 'Ki', 'Mi', 'Gi', 'Ti', 'Pi', 'Ei', 'Zi', 'Yi');
        switch(strtoupper($mode)) {
            case 'SI' : $factor = 1000; $symbols = $si; break;
            case 'IEC' : $factor = 1024; $symbols = $iec; break;
            default : $factor = 1000; $symbols = $si; break;
        }
        switch($bB) {
            case 'b' : $val *= 8; break;
            default : $bB = 'B'; break;
        }
        for($i=0;$i<count((array)$symbols)-1 && $val>=$factor;$i++)
            $val /= $factor;
        $p = strpos($val, ".");
        if($p !== false && $p > $digits) $val = round($val);
        elseif($p !== false) $val = round($val, $digits-$p);
        return round($val, $digits) . " " . $symbols[$i] . $bB;
    }

	/*
	* 브라우저 종류를 알아냄
	*/
	public static function getBrowserKind()
	{
		$sAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
		
		if(strstr($sAgent, 'msie')){
			if(strstr($sAgent, "msie 6.0")){
				$sAgent = 'ie6';
			}elseif(strstr($gSbrver, "msie 7.0")){
				$sAgent = 'ie7';
			}else{
				$sAgent = 'ie';
			}
		}elseif(strstr($sAgent, 'konqueror') || strstr($sAgent, 'safari')){
			$sAgent = 'safari';
		}elseif(strstr($sAgent, 'firefox')){
			$sAgent = 'firefox';
		}elseif(strstr($sAgent, 'opera')){
			$sAgent = 'opera';
		}

		return $sAgent;
	}
}

?>
