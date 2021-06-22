<?

class Monaco {

	// static
	function diffdate($lastWriteDate)
	{
		$atime=date("Y-m-d H:i");
		$xtime=strtotime($atime) - strtotime($lastWriteDate);
		$xtime=$xtime/60;
		$xtime=round($xtime); 
		return $xtime;
	}
}

?>