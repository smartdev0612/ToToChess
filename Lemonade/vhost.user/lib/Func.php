<?

class Func {

	public function getRatioSize($sizeW,$sizeH,$maxW,$maxH){
		if($sizeW>$maxW && $sizeH>$maxH){
			if(round($sizeW/$maxW,1)>round($sizeH/$maxH,1)){
				$return['width'] = $maxW;
				$return['height'] = round(($sizeH*$maxW)/$sizeW);
			}
			else {
				$return['width'] = round(($sizeW*$maxH)/$sizeH);
				$return['height'] = $maxH;
			}
		}
		else if($sizeW>$maxW || $sizeH>$maxH){
			if($sizeW>$maxW){
				$return['width'] = $maxW;
				$return['height'] = round(($sizeH*$maxW)/$sizeW);
			}
			else if($sizeH>$maxH){
				$return['width'] = round(($sizeW*$maxH)/$sizeH);
				$return['height'] = $maxH;
			}
		}
		else if($sizeW<=$maxW && $sizeH<=$maxH){
			$return['width'] = $sizeW;
			$return['height'] = $sizeW;
		}

		return $return;
	}

	/**
	 * 한글 자르기
	 *
	 * @param unknown_type $strSrc
	 * @param unknown_type $start
	 * @param unknown_type $end
	 * @return unknown
	 */
	public function ksubstr($strSrc, $start, $end = ""){
		$check1 = strlen($strSrc);
		if($start < 0)
		$start = strlen($strSrc) + $start;

		if($this->IsHangul($strSrc, $start)==1)
		++$start;

		if(!strlen($end))
			return substr($strSrc, $start);
		else {
			if ($end < 0) {
				$pos = $end + strlen($strSrc) -1;

				if($this->IsHangul($strSrc, $pos)==0)
					--$end;
			} else {
				$pos = $end + $start -1;

				if($this->IsHangul($strSrc, $pos)==0)
					--$end;
			}
		}
		if ($check1 > $end) {
			$suffix = "..";
		}
		return substr($strSrc, $start, $end).$suffix;
	}

	public function IsHangul($strSrc, $pos){
		$isHangul = 1;

		for($i=0 ; $i<=$pos ; ++$i)
		{
		if(ord($strSrc[$i]) > 127)
		++$isHangul;
		else
		$isHangul = -1;
		}

		return $isHangul%2;
	}

	/**
	 * stripslashes
	 * @param $str
	 * @return stripslashes string
	 */
	public function stripSlashes($str) {
		return stripslashes($str);
	}

	// &nbsp; 제거. 공백여러개는 공백한개로
	function stripNBSP($str){
		$str = str_replace("&nbsp;"," ",$str);
		$str = preg_replace("/　[　]+/"," ",$str);
		return $this->stripSpace($str);
	}

	// 공백문자 여러개 제거
	function stripSpace($str){
		return preg_replace("/[ ]+/"," ",$str);
	}

	// 원하는 태그 외의 나머지 태그 모두 제거
	function stripHtmlTag($str,$allow='',$allowTableMaxWidth=''){
		$tags = array("!doctype","html", "head", "body", "title", "h1", "h2", "h3", "h4", "h5", "p", "br", "pre", "font", "hr", "img", "map", "ul", "ol", "menu", "dir", "dl", "center", "blockquote", "strong", "b", "em", "embed", "i", "kbd", "code", "tt", "body", "dfn", "cite", "samp", "var", "sub", "sup", "basepoint", "blink", "u", "a", "address", "table", "tr", "td", "nobr", "wbr", "form", "textarea", "input", "frameset", "noframes", "frame", "img", "div", "tbody", "span", "link", "script", "tont", "object", "param", "area", "iframe", "meta", "script", "style", "!embed", "li", "select", "marquee");

		// 주석 제거
		$str = preg_replace("/<!--[\w\W]*-->/U","",$str);

		// 스크립트 제거
		$str = preg_replace("/<script [\w\W]+<\/script>/iU","",$str);

		// ㅡ. xml 부분제거
		// ㅡ. table width 값 100%로 강제 치환
		// ㅡ. table 안 img width 값이 $allowTableMaxWidth 보다 크면 $allowTableMaxWidth 으로 강제 치환
		$str = preg_replace("/<\?xml[\w\W]*\?>/iU","",$str);
		preg_match_all("/(<table [^\>]*)(width=[\'\"]{0,1}[0-9\%]+[\'\"]{0,1})([^\>]*>)/",$str,$match);
		for($i=0;$i<count((array)$match[0]);$i++){
        	$str = str_replace($match[0][$i],$match[1][$i]." width='100%' ".$match[3][$i],$str);
		}
		preg_match_all("/(<img [^\>]*)(width=[\'\"]{0,1}([0-9]+)[\'\"]{0,1})([^\>]*>)/",$str,$match);
		for($i=0;$i<count((array)$match[0]);$i++){
		        if($match[3][$i]>$allowTableMaxWidth){
		                $str = str_replace($match[0][$i],$match[1][$i]." width='".$allowTableMaxWidth."' ".$match[4][$i],$str);
		        }
		}

		if(preg_match_all("/<[\/]*([^>]*)[\/]*>/",$str,$match)){
			for($i=0;$i<count((array)$match[1]);$i++){
				// 매치된 태그에 대해 공백 구분으로 나눈다 ex. font color='red'
				$tmp = explode(" ",$match[1][$i]);
				if(in_array(strtolower($tmp[0]),$tags)){		// 태그어인지 검사
					if($allow!=""){
						if(!in_array(strtolower($tmp[0]),$allow)){	// 허용태그에 포함안된 태그이면 제거
							$str = preg_replace("/<[\/]*".$tmp[0]."[^>]*[\/]*>/i","",$str);
						}
					}
					else {
						$str = preg_replace("/<[\/]*".$tmp[0]."[^>]*[\/]*>/i","",$str);
					}
				}
			}
		}

		// 자바 스크립트 제거
		$str = preg_replace("/function[\w\W]*{[\w\W]*}/","",$str);
		$str = preg_replace("/(body|td) \{[\w\W]*\}/Ui","",$str);

		return trim($this->stripNBSP($str));
	}

	function encrypt($str) {
		$str = '$~*x_-%+' . $str . '|*&y#$z';
		$str = md5($str);
		return $str;
	}
	
	// 현재 주가 지금 월의 몇번째 주인지 확인
	function getWeek(){
		$firstDayNo = date("w", mktime(0,0,0, date("n"),1,date("Y")));
		$fWeekLast = 6 - $firstDayNo + 1;
		
		$lastDay = date("t");

		// 마지막 날짜에서 첫주 마지막일을 뺀다
		$v1 = $lastDay - $fWeekLast;
		$v2 = ceil($v1/7);
		
		// 전체 주 수
		$totalWeek = $v2 + 1;

		// 오늘날짜
		$cday = date("j");
		
		// 오늘날짜에서 첫주 마지막일을 뺀다
		$remain = $cday - $fWeekLast;
		
		// 음수면 첫주
		if($remain<=0){
			$rs['week'] = "1";
			$rs['first'] = 1;
			$rs['last'] = $fWeekLast;
		}
		else {
			// 아니면 7로 나눈 값을 올림하여 +1 한다
			$rs['week'] = ceil($remain/7) + 1;
			$rs['first_day'] = ($fWeekLast+1) + 7*($rs['week']-2);
			$rs['last_day'] = ($fWeekLast) + 7*($rs['week']-1);
			
			if($rs['last']>$lastDay)
				$rs['last'] = $lastDay;
		}
		
		$rs['year'] = date("Y");
		$rs['month'] = date("n");
		$rs['first_date'] = date("Y-m")."-".str_pad($rs['first_day'],2,'0',STR_PAD_LEFT);
		$rs['last_date'] = date("Y-m")."-".str_pad($rs['last_day'],2,'0',STR_PAD_LEFT);
		
		
		return $rs;
	}
	
	function strcut_utf8($str, $len, $checkmb = false, $tail = '') {
		/**
		 * UTF-8 Format
		 * 0xxxxxxx = ASCII, 110xxxxx 10xxxxxx or 1110xxxx 10xxxxxx 10xxxxxx
		 * latin, greek, cyrillic, coptic, armenian, hebrew, arab characters consist of 2bytes
		 * BMP(Basic Mulitilingual Plane) including Hangul, Japanese consist of 3bytes
		 **/
		preg_match_all('/[\xE0-\xFF][\x80-\xFF]{2}|./', $str, $match); // target for BMP

		$m = $match[0];
		$slen = strlen($str); // length of source string
		$tlen = strlen($tail); // length of tail string
		$mlen = count($m); // length of matched characters

		if ($slen <= $len) return $str;
		if (!$checkmb && $mlen <= $len) return $str;

		$ret = array();
		$count = 0;
		for ($i = 0; $i < $len; $i++) {
			$count += ($checkmb && strlen($m[$i]) > 1) ? 2 : 1;
			if ($count + $tlen > $len) break;
			$ret[] = $m[$i];
		}
		return join('', $ret).$tail;
	}
	
	static function getLevelname($level){
		switch($level){
			case 1: $levelName='슈퍼본사'; break;
			case 2: $levelName='총본사'; break;
			case 3: $levelName='본사'; break;
			case 4: $levelName='부본사'; break;
			case 5: $levelName='총판'; break;
			case 6: $levelName='매장'; break;
		}
		
		return $levelName;
	}
	
	static function my_json_encode($data) {
		switch (gettype($data)) {
			case 'boolean':
				return $data?'true':'false';
			case 'integer':
			case 'double':
				return $data;
			case 'string':
				return '"'.strtr($data, array('\\'=>'\\\\','"'=>'\\"')).'"';
			case 'array':
				$rel = false; // relative array?
				$key = array_keys($data);
				foreach ($key as $v) {
					if (!is_int($v)) {
						$rel = true;
						break;
					}
				}
	
				$arr = array();
				foreach ($data as $k=>$v) {
					$arr[] = ($rel?'"'.strtr($k, array('\\'=>'\\\\','"'=>'\\"')).'":':'').Func::my_json_encode($v);
				}
	
				return $rel?'{'.join(',', $arr).'}':'['.join(',', $arr).']';
			default:
				return '""';
		}
	}
}

?>