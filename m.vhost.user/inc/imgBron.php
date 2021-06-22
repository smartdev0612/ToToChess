<?php 
/** * @Author: TonyLevid 
* @Copyright: http://TonyLevid.com/ 
* @Name: image Born Class 
* @Version: 0.0.1 
* 欢迎各位测试，如有BUG，请到网站留言 
* I'm pleased if you are willing to test my imgBorn class,if bug exists,you can leave a message. 
**/ 

class imgBorn{ 
/*验证码成员*/   
	
	/*是否中文*/   
	private $isCN;     
	/*保存其他条件*/    
	private $other;     
	/*其他条件默认状态*/    
	private $otherDef = array(             
		'bg'=>'#FFFF93',             
		'alpha'=>0,             
		'pxNum'=>50,             
		'pxColor'=>'#000000',             
		'lineNum'=>3,             
		'lineColor'=>'#000079',             
		'arcNum'=>1,             
		'arcColor'=>'#009393',             
		'isMath'=>0,             
		'myString'=>array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T'),             
		'stringNum'=>4,             
		'stringColor'=>'#000000',             
		'hasBorder'=>1,             
		'borderColor'=>'#000000'            
		);     
	/*图像资源标识符*/    
	private $img;     
	/*字体大小*/    
	private $fontsize;     
	/*字符起始位置坐标X*/    
	private $fontX;     
	/*字符起始位置坐标Y*/    
	private $fontY;     
	/*图片宽度，单位为px*/    
	private $imgW;     
	/*图片高度，单位为px*/    
	private $imgH;     
	/*ttf字体路径句柄*/   
	private $ttf;     
	/*SESSION的键名*/    
	private $sessName; 
	
/*缩略图成员*/    

	/*源图像宽度，单位为px*/    
	private $srcW;     
	/*源图像宽度，单位为px*/    
	private $srcH;     
	/*输出图像宽度，单位为px*/    
	private $outW;     
	/*输出图像高度，单位为px*/    
	private $outH;     
	/*是否高质量缩略图，默认开启*/    
	private $isHigh;     
	/*缩略图的百分数*/    
	private $percent;     
	/*源图像文件路径*/    
	private $srcImg;     
	/*缩略图资源标识符*/    
	private $thumb; 
/*水印成员*/    
	/*目标图像文件信息*/    
	private $dstInfo;     
	/*水印图像文件信息*/    
	private $wmInfo;     
	/*目标图像文件*/    
	private $dstImg;     
	/*水印图像文件*/    
	private $watermark;     
	/*水印图像文件在目标文件上的坐标信息*/    
	private $dstPosArr;     
	/*图像透明度*/    
	private $alpha;     
	/*文字水印*/    
	private $iStr;     
	/*ttf文件路径*/    
	private $ttfW;     
	/*字体大小*/    
	private $fontsizeW;     
	/*是否为中文*/    
	private $isCNW;     
	/*字体颜色*/    
	private $strColor;     
	/*字体透明度*/    
	private $strAlpha;   
	/*构造函数，开启session*/    
	function __construct()
	{         
		session_start();     
	}       
	
	/*公有方法，为生成验证码传递参数，输出图像     
	* @param $imgW(int型，必填)，填写图片的宽度，单位为px。     
	* @param $imgH(int型，必填)，填写图片的高度，单位为px。     
	* @param $fontsize(int型，必填)，填写字体的大小，单位为px。     
	* @param $fontX(int型，可选)，填写字符起始位置坐标X，默认为0。     
	* @param $fontY(int型，可选)，填写字符起始位置坐标Y，默认为0。（注：这里的坐标与数学中的有所不同，图像的左上角为(0,0)，字符的左下角为起始位置）     
	* @param $isCN(布尔型，可选)，填写0或1，分别代表打开中文和关闭中文，默认为关闭。     
	* @param $ttf(字符串型，可选)，填写ttf字体的路径，默认为null。     
	* @param $other(数组类型，可选)，填写一维数组，默认为公有成员$otherDef。     
	*     $other的格式：array(选项1=>值1,选项2=>值2)。选项无先后顺序，选项如下：     
	*       1.bg，背景图像颜色，填写16进制颜色代码，有#无#都可。如：'bg'=>'#FFFFFF'。     
	*       2.alpha，背景图像透明度，alpha的值为0到127，0代表完全不透明，127代表完全透明。如：'alpha'=>60。     
	*       3.pxNum，图像干扰点数，设置验证码图片中干扰点数数目。如：'pxNum'=>100。     
	*       4.pxColor，图像干扰点数颜色，填写16进制颜色代码，有#无#都可。如：'pxColor'=>'#FFFFFF'。     
	*       5.lineNum，图像干扰直线数，设置验证码图片中干扰直线数目。如：'lineNum'=>5。     
	*       6.lineColor，同上。     
	*       7.arcNum，图像干扰弧线数，设置验证码图片中干扰弧线数目。如：'arcNum'=>5。     
	*       8.arcColor，同上。     *       9.isMath，值为1或0，分别代表是否打开9*9的算术题功能。如：'isMath'=>0。     
	*       10.myString，随机字符库，以逗号分开，默认为0-9A-Z字符库。如：'myString'=>'赵,钱,孙,李,王'。     
	*       11.stringNum，验证字符个数。如：'stringNum'=>4。     
	*       12.stringColor，同上，如果isMath开启，数字颜色也采用此颜色。     
	*       13.hasBorder，值为1或0，分别代表图片是否有边框。如：'hasBorder'=>1。     
	*       14.borderColor，同上。     
	* @param $sessName(字符串型，可选)，填写SESSION的键名，默认为'strCheck'。     
	*/    
	function verify($imgW,$imgH,$fontsize,$fontX = 0,$fontY = 0,$isCN = null,$ttf = null,$other = null,$sessName = null)
	{         
		$this->imgW = $imgW;         
		$this->imgH = $imgH;         
		$this->fontsize = $fontsize;         
		$this->fontX = $fontX;         
		$this->fontY = $fontY;         
		$this->isCN = ($isCN) ? 1 : 0;         
		$this->ttf = ($ttf)&&(is_string($ttf)) ? $ttf : null;         
		$this->other = ($other)&&(is_array($other)) ? $other : $this->otherDef;         
		$this->sessName = ($sessName)&&(is_string($sessName)) ? $sessName : 'strCheck';         
		$this->vProcessing();      
	}       
	/*公有方法，为生成缩略图传递参数，输出图像     
	* @param $srcImg(字符串型，必填)，源图像文件路径。     
	* @param $outW(int型，相关联)，输出图像宽度，单位为px。     
	* @param $outH(int型，相关联)，输出图像宽度，单位为px。     
	* @param $isHigh(int型，可选)，是否输出高质量缩略图，默认开启。     
	* @param $percent(int型，相关联)，是否输出图像百分比，默认为关闭，0代表关闭状态。若开启，则$outW和$outH将失效。如：100，代表输出原大小。     
	*/    
	function thumbnail($srcImg,$outW,$outH,$isHigh = null,$percent = null)
	{         
		$imgInfo = getimagesize($srcImg);         
		$this->srcImg = $srcImg;         
		$this->outW = $outW;         
		$this->outH = $outH;         
		$this->isHigh = ($isHigh===0) ? 0 : 1;         
		$this->percent = ($percent)&&(is_int($percent)) ? $percent/100 : 0;         
		$this->srcW = $imgInfo[0];         
		$this->srcH = $imgInfo[1];         
		$this->tProcessing();     
	}       
	/*公有方法，为生成水印传递参数，输出图像     
	* @param $dstImg(字符串，必填)，目标图像文件路径。     
	* @param $watermark(字符串，相关联)，水印图像文件路径。     
	* @param $dstPosArr(数组，必填)，填写水印文件所在目标文件的坐标位置的一维数组，array(dst_x,dst_y)。     
	* @param $alpha(int型，可选)，值范围为0-100，分别代表完全透明和完全不透明，默认为100。     
	*          以下参数用来设置水印字符     
	* @param $iStr(字符串型，相关联)，填写水印字符串，以字符水印，默认关闭。若开启，则$watermark将失效。     
	* @param $ttfW(字符串型，可选)，填写ttf字体文件路径。     
	* @param $fontsizeW(int型，可选)，填写自己大小，单位为px。     
	* @param $isCNW(int型，可选)，是否打开中文，1为打开，0为关闭，默认关闭。     
	* @param $strColor(字符串型，可选)，填写16进制颜色代码，有#无#都可，默认为黑色。如'#000000'。     
	* @param $strAlpha(int型，可选)，值范围为0-127，分别代表完全不透明和完全透明，若此参数设置，$alpha将失效。     
	*/    
	function watermark($dstImg,$watermark,$dstPosArr,$alpha = null,$iStr = null,$ttfW = null,$fontsizeW = null,$isCNW = null,$strColor = null,$strAlpha = null)
	{         
		$this->dstInfo = $dstInfo = getimagesize($dstImg);         
		$this->wmInfo = $wmInfo = getimagesize($watermark);         
		$this->dstImg = $dstImg;         
		$this->watermark = $watermark;         
		$this->dstPosArr = $dstPosArr;         
		$this->alpha = (is_int($alpha)) ? $alpha : 100;         
		$this->iStr = ($iStr)&&(is_string($iStr)) ? $iStr : null;         
		$this->ttfW = (is_string($ttfW)) ? $ttfW : null;         
		$this->fontsizeW = (is_int($fontsizeW)) ? $fontsizeW : null;         
		$this->isCNW = ($isCNW) ? 1 : 0;         
		$this->strColor = (is_string($strColor)) ? $strColor : '#000000';         
		$this->strAlpha = (is_int($strAlpha)) ? $strAlpha : 0;         $this->wProcessing();     
	}       
	/*私有方法，返回RGB颜色数值一维数组     
	* @param $colorHex(字符串，必填)，填写16进制颜色代码     
	*/    
	private function HEX2RGB($colorHex)
	{         
		$colorHex = strstr($colorHex,'#') ? substr($colorHex,1) : $colorHex;         
		$decArr = array(hexdec(substr($colorHex,0,2)),hexdec(substr($colorHex,2,2)),hexdec(substr($colorHex,4,2)));         
		return $decArr;     
	}       
	/*私有方法，处理验证码*/    
	private function vProcessing()
	{         
		$otherKeys = array_keys($this->other);         
		$bg = in_array('bg',$otherKeys) ? $this->other['bg'] : $this->otherDef['bg'];         
		$alpha = in_array('alpha',$otherKeys) ? $this->other['alpha'] : $this->otherDef['alpha'];         
		$pxNum = in_array('pxNum',$otherKeys) ? $this->other['pxNum'] : $this->otherDef['pxNum'];         
		$pxColor= in_array('pxColor',$otherKeys) ? $this->other['pxColor'] : $this->otherDef['pxColor'];         
		$lineNum = in_array('lineNum',$otherKeys) ? $this->other['lineNum'] : $this->otherDef['lineNum'];         
		$lineColor = in_array('lineColor',$otherKeys) ? $this->other['lineColor'] : $this->otherDef['lineColor'];         
		$arcNum = in_array('arcNum',$otherKeys) ? $this->other['arcNum'] : $this->otherDef['arcNum'];         
		$arcColor = in_array('arcColor',$otherKeys) ? $this->other['arcColor'] : $this->otherDef['arcColor'];         
		$isMath = in_array('isMath',$otherKeys) ? $this->other['isMath'] : $this->otherDef['isMath'];         
		$myString = in_array('myString',$otherKeys) ? $this->other['myString'] : $this->otherDef['myString'];         
		$stringNum = in_array('stringNum',$otherKeys) ? $this->other['stringNum'] : $this->otherDef['stringNum'];         
		$stringColor = in_array('stringColor',$otherKeys) ? $this->other['stringColor'] : $this->otherDef['stringColor'];         
		$hasBorder = in_array('hasBorder',$otherKeys) ? $this->other['hasBorder'] : $this->otherDef['hasBorder'];         
		$borderColor = in_array('borderColor',$otherKeys) ? $this->other['borderColor'] : $this->otherDef['borderColor'];           
		$img = imagecreatetruecolor($this->imgW,$this->imgH);         
		
		/*设置背景*/        
		$bgArr = $this->HEX2RGB($bg);         
		if($alpha===0)
		{             
			$img = imagecreatetruecolor($this->imgW,$this->imgH);             
			$bg = imagecolorallocate($img,$bgArr[0],$bgArr[1],$bgArr[2]);             
			imagefilledrectangle($img,0,0,$this->imgW - 1,$this->imgH - 1,$bg);         
		}else
		{             
			$img = imagecreate($this->imgW,$this->imgH);             
			$bg = imagecolorallocatealpha($img,$bgArr[0],$bgArr[1],$bgArr[2],$alpha);         
		}         
		/*设置边框*/        
		$bcArr = $this->HEX2RGB($borderColor);         
		$borderColor = imagecolorallocate($img,$bcArr[0],$bcArr[1],$bcArr[2]);         
		($hasBorder===1) ? imagerectangle($img,0,0,$this->imgW - 1,$this->imgH - 1,$borderColor) : null;         
		/*设置干扰点*/        
		$pxArr = $this->HEX2RGB($pxColor);         
		$pxColor = imagecolorallocate($img,$pxArr[0],$pxArr[1],$pxArr[2]);         
		for($ip = 0; $ip < $pxNum; $ip++)
		{             
			imagesetpixel($img,mt_rand(0,$this->imgW),mt_rand(0,$this->imgH),$pxColor);         
		}         
		/*设置干扰线*/        
		$lineArr = $this->HEX2RGB($lineColor);         
		$lineColor = imagecolorallocate($img,$lineArr[0],$lineArr[1],$lineArr[2]);         
		for($il = 0;$il < $lineNum;$il++)
		{             
			imageline($img,(int)($this->imgW*0.05),mt_rand(0,$this->imgH),(int)($this->imgW*0.95),mt_rand(0,$this->imgH),$lineColor);         
		}         
		/*设置干扰弧线*/        
		$arcArr = $this->HEX2RGB($arcColor);         
		$arcColor = imagecolorallocate($img,$arcArr[0],$arcArr[1],$arcArr[2]);         
		for($ir = 0;$ir < $arcNum;$ir++){             
			imagearc($img,(int)($this->imgW*0.5),(int)($this->imgH*0.5),mt_rand(0,$this->imgW),mt_rand(0,$this->imgH),mt_rand(0,200),mt_rand(0,270),$arcColor);         
		}           
		$strColorArr = $this->HEX2RGB($stringColor);         
		$stringColor = imagecolorallocate($img,$strColorArr[0],$strColorArr[1],$strColorArr[2]);         
		/*9*9算术干扰图像*/          
		if($isMath===1){             
			$arr99 = range(0,9);             
			$arrPick = array_rand($arr99,2);             
			$imgStr99 = $arrPick[0] . 'x' . $arrPick[1];             
			imagestring($img,$this->fontsize,mt_rand(0,$this->imgW-30),(int)($this->imgH*0.5-19*0.5),$imgStr99,$stringColor);             
			$_SESSION[$this->sessName] = $arrPick[0]*$arrPick[1];         
		}else
		{         
			/*无中文验证*/            
			if($this->isCN === 0)
			{                 
				$myString = $this->otherDef['myString'];                 
				$imgStrNoCN = array_rand($myString,$stringNum);                 
				foreach($imgStrNoCN as $strValue)
				{                     
					$imgStrNoCNArr[] = $myString[$strValue];                 
				}                 
				$imgStrNoCN = implode('',$imgStrNoCNArr);                 
				if(isset($this->ttf)){                     
					imagettftext($img,$this->fontsize,0,$this->fontX,$this->fontY,$stringColor,$this->ttf,$imgStrNoCN);                 
				}else{                     
					imagestring($img,$this->fontsize,$this->fontX,$this->fontY,$imgStrNoCN,$stringColor);                 
				}                 
				$_SESSION[$this->sessName] = $imgStrNoCN;             
			} else
			{                
				/*中文验证*/ 
				if(!isset($this->ttf))
				{
					die('invalid argument:$ttf');
				}                 
				$myStringArr = explode(',',$myString);                 
				$imgStrCN = array_rand($myStringArr,$stringNum);                 
				foreach($imgStrCN as $strValueCN)
				{                     
					$imgStrCNArr[] = $myStringArr[$strValueCN];                 
				}                 
				$imgStrCN = implode('',$imgStrCNArr);                 
				imagettftext($img,$this->fontsize,0,$this->fontX,$this->fontY,$stringColor,$this->ttf,$imgStrCN);                 
				$_SESSION[$this->sessName] = $imgStrCN;             
			}         
		}         
		header('Content-type: image/png');         
		imagepng($img);         
		imagedestroy($img);     
	}       
	/*私有方法，处理缩略图*/    
	private function tProcessing()
	{         
		$imgInfo = getimagesize($this->srcImg);         
		$funNameC = 'imagecreatefrom' . substr($imgInfo['mime'],6);         
		$newW = $this->outW;         
		$newH = $this->outH;         
		$srcW = $this->srcW;         
		$srcH = $this->srcH;         
		$percent = $this->percent;         
		$thumb = imagecreatetruecolor($newW,$newH);         
		$source = $funNameC($this->srcImg);         
		if($this->percent===0)
		{             
			($this->isHigh===0) ? imagecopyresized($thumb,$source,0,0,0,0,$newW,$newH,$srcW,$srcH) :                 
											imagecopyresampled($thumb,$source,0,0,0,0,$newW,$newH,$srcW,$srcH);         
		}else{             
			$thumb = imagecreatetruecolor($srcW*$percent,$srcH*$percent);             
			($this->isHigh===0) ? imagecopyresized($thumb,$source,0,0,0,0,$srcW*$percent,$srcH*$percent,$srcW,$srcH) :							          
											imagecopyresampled($thumb,$source,0,0,0,0,$srcW*$percent,$srcH*$percent,$srcW,$srcH);         
		}         
		$funNameOut = str_replace('/','',$imgInfo['mime']);         
		header('Content-type: ' . $imgInfo['mime']);         
		$funNameOut($thumb);         
		imagedestroy($thumb);     
	}       
	/*私有方法，处理水印*/    
	private function wProcessing()
	{         
		$funNameCD = 'imagecreatefrom' . substr($this->dstInfo['mime'],6);         
		$funNameCW = 'imagecreatefrom' . substr($this->wmInfo['mime'],6);         
		$dstImg = $funNameCD($this->dstImg);         
		$watermark = $funNameCW($this->watermark);         
		$dst_x = $this->dstPosArr[0];         
		$dst_y = $this->dstPosArr[1];         
		$src_w = $this->wmInfo[0];         
		$src_h = $this->wmInfo[1];         
		$opacity = $this->alpha;         
		$funNameOut = str_replace('/','',$this->dstInfo['mime']);         
		if($this->iStr)
		{             
			$tcArr = $this->HEX2RGB($this->strColor);             
			$textColor = imagecolorallocatealpha($dstImg,$tcArr[0],$tcArr[1],$tcArr[2],$this->strAlpha);             
			if($this->isCNW===0)
			{                 
				imagestring($dstImg,$this->fontsizeW,$dst_x,$dst_y,$this->iStr,$textColor);             
			}else{                 
				imagettftext($dstImg,$this->fontsizeW,0,$dst_x,$dst_y,$textColor,$this->ttfW,$this->iStr);             
			}             
			header('Content-type: ' . $this->dstInfo['mime']);             
			$funNameOut($dstImg);             
			imagedestroy($dstImg);         
		}else{             
			imagecopymerge($dstImg,$watermark,$dst_x,$dst_y,0,0,$src_w,$src_h,$opacity);             
			header('Content-type: ' . $this->dstInfo['mime']);             
			$funNameOut($dstImg);             
			imagedestroy($dstImg);         
		}     
	} 
} 
?>