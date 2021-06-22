<?
/*
* xss 공격 무효화
*/

class Lemon_XSSCleaner 
{
	function run($sData)
	{
		// 위험한 태그 전체 삭제
		$sData = preg_replace('/<([ \t\r\n]*)(script|applet|iframe|layer|xml)(.*)?>(.*)?<\/(\\2)>/i','',$sData);

		// close tag가 없는 경우를 대비
		$sData = preg_replace('/<([ \t\r\n]*)(xss|meta|iframe|link|script)([^>]*)?>?/i', '', $sData);

		// 태그별 조사
		$sData = preg_replace_callback('/<([^>]+)>/', array(&$this,'_checkTag'), $sData);

		return $sData;
	}

	function _checkTag($Matches)
	{
		$sAppend = '';
		$sCareAttr = '';

		// 탭,엔터 제거
		$Matches = preg_replace('/[\t\r\n]/', '', $Matches[1]);
		
		// 태그와 속성으로 분리
		if (preg_match('/([?\w]+)(.*)/', $Matches, $TagMatches))
		{
			$sTag = $TagMatches[1];
			$sAttr = trim($TagMatches[2]);
		}

		// 속성이 없을 경우
		if ($sAttr=="") return "<$Matches>";

		// 태그 첫 문자
		$sTagHead = $sTag[0];

		// 소문자 태그명
		$sLowTag = strtolower($sTag);

		if ($sTagHead=='?') 
		{
			$sTag = $sTag.'_';
		}
		else if (preg_match('/[a-z]/i',$sTagHead))
		{
			// decimal & hex 디코딩
			$sAttr = preg_replace_callback('/&#(0000)?([0-9][0-9]?[0-9]?);?/i', array(&$this,'_dec2str'), $sAttr);
			$sAttr = preg_replace_callback('/&#x([0-9a-z][0-9a-z]);?/i', array(&$this,'_hex2str'), $sAttr);

			// 속성내 주석 제거
			$sAttr = preg_replace('/\/\*(.*)\*\//i', '', $sAttr);

			// on이벤트 변경
			$sAttr = preg_replace('/([\" ])(on)([a-z]+)/i', '\1_\2\3', $sAttr);

			// src,href 속성 보호를 위한 처리
			if (
				(($sLowTag=='img' || $sLowTag=='embed') &&
					preg_match('/src[ ]*=[ ]*[\'|"]?([^ \'"]+)[\'|"]?/i', $sAttr, $CareMatches)) ||
				($sLowTag=='a' &&
					preg_match('/href[ ]*=[ ]*[\'|"]?([^ ]+)/i', $sAttr, $CareMatches))
				)
			{
				$sCareAttr = $CareMatches[0];

				// 보호하기 위한 속성을 기존 속성에서 제거
				$sAttr = str_replace($sCareAttr, '', $sAttr);

				// javascript 막기
				$sCareAttr = ' '.preg_replace('/(ipt:)/i', '_\1', $sCareAttr);				
			}

			// 위험한 속성 변경
			$sAttr = preg_replace('/(document|ipt:|cookie|expression|behaviour|eval|mocha:|xss:|x-scriptlet|allowscriptaccess|invokeurls|svg\+xml)/i', '_\1', $sAttr);

			// object에 AllowScriptAcess 추가
			if ($sLowTag=='object')
			{
				$sAppend = '<param name="allowScriptAccess" value="never" />';
			}
		}

		if ($sAttr)
		{
			$sAttr = ' '.trim($sAttr);
		}

		return "<$sTag$sCareAttr$sAttr>$sAppend";
	}

	function _dec2str($Matches)
	{
		return chr($Matches[2]);
	}

	function _hex2str($Matches)
	{
		return chr(hexdec($Matches[1]));
	}
}
?>