//字符串去空格函数
function CheckStr(strOriginal, strFind, strChange)
{
	var position, strOri_Length;
    position = strOriginal.indexOf(strFind);  
    
    while (position != -1)
    {
      strOriginal = strOriginal.replace(strFind, strChange);
      position    = strOriginal.indexOf(strFind);
    }
  
	strOri_Length = strOriginal.length;
    return strOri_Length;
}

// 숫자만 입력
function pressNumberCheck() 
{
	if(event.keyCode >= 48 && event.keyCode <= 57 )
	{ 	// 숫자만 입력가능.
		event.returnValue = true;
	}
	else
	{
		event.returnValue = false;
	}
}