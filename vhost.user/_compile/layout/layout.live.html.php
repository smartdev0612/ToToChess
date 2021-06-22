<?php @$this->print_("header",$TPL_SCP,1);?>
<?php @$this->print_("top",$TPL_SCP,1);?>
<div id="container">
<?php
	if ( strpos($_SERVER["REQUEST_URI"],"LiveGame/list") ) {
		$topBgImg = "style=\"background:url('/images/top_banner_live.jpg') center 0 repeat-x; width:100%; height:86px;\"";
	} else if ( strpos($_SERVER["REQUEST_URI"],"LiveGame/betting_list") ) {
		$topBgImg = "style=\"background:url('/images/top_banner_bet.jpg') center 0 repeat-x; width:100%; height:86px;\"";
	}
?>
	<div id="warp_sub" <?php echo $topBgImg;?>></div>
	<div id="con_1275">
	<?php @$this->print_("left",$TPL_SCP,1);?>
	<?php @$this->print_("content",$TPL_SCP,1);?>
	<?php @$this->print_("right",$TPL_SCP,1);?>
	</div>
</div> <!--// container 종료-->
<?php @$this->print_("footer",$TPL_SCP,1);?>