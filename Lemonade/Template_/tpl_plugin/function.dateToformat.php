<?php

/* TEMPLATE PLUGIN FUNCTION EXAMPLE */

function dateToformat($date){
	return substr($date, 5, 2) . "월 " . substr($date, 8, 2) . "일";
}
?>