<?php
	$graphData = str_replace('\\','',$TPL_VAR['graphData']);
	$graphData = str_replace('{"resultVal":"','',$graphData);
	$graphData = str_replace('"}"}','"}',$graphData);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="shortcut icon" href="/images/favicon.ico">
	<link rel="stylesheet" type="text/css" href="/include/css/game.css"/>
	<link rel="stylesheet" type="text/css" href="/include/css/layout.css"/>
	<script type="text/javascript" src="/include/js/jquery-1.12.3.min.js"></script>
</head>
<body style="overflow-y: hidden">
<div class="ladder_wrap">
	<div class="ladder_chart_inner">
		<table id="graphTable" summary="최근 회차별 홀/짝 통계">
			<thead>
				<tr>
					<th class="col_even">짝</th>
					<th class="col_odd">홀</th>
					<th class="col_even">짝</th>
					<th class="col_odd">홀</th>
				</tr>
			</thead>
			<tbody>
				<tr style="height:288px;">
					<td valign="top"><div class="even evensecond"><span class="tx"><em class="num">150</em></span></div></td>
					<td valign="top"><div class="odd oddfirst"><span class="tx"><em class="num">151</em></span></div></td>
					<td valign="top"><div class="even evenfirst"><span class="tx"><em class="num">152</em></span></div><div class="even evenfirst"><span class="tx"><em class="num">153</em></span></div></td>
					<td valign="top"><div class="odd oddsecond"><span class="tx"><em class="num">154</em></span></div></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	var sadariResultData = <?php echo $graphData;?>;

	$(document).ready(function() {
		data_init();
	});

	function data_init() {
		$('.ladder_chart_inner table thead tr').html('');
		$('.ladder_chart_inner table tbody tr').html('');
		var oddeven = '';
		var td_num = -1;
		for ( var i = sadariResultData.length-1 ; i >= 0  ; i-- ) {
			var st = sadariResultData[i];
			var shead = '';
			var sbody = '';

			if ( typeof(st['hj']) == "undefined" ) hj = st['result'];
			else hj = st['hj'];

			if ( hj != oddeven ) {
				oddeven = hj;
				td_num++;
				if ( hj == "odd" || st['result'] == "odd" ) shead = "<th class='col_odd'>홀</th>";
				else shead = "<th class='col_even'>짝</th>";

				$('.ladder_chart_inner table thead tr').append(shead);
				sbody = "<td valign='top'></td>";
				$('.ladder_chart_inner table tbody tr').append(sbody);
			}
			if ( hj == "odd" ) {
				body_class = "odd odd";
				if ( st['line'] == 3 ) body_class = body_class + "second";
				else body_class = body_class + "first";
			} else {
				body_class = "even even";
				if ( st['line'] == 3 ) body_class = body_class + "first";
				else body_class = body_class + "second";
			}

			sbody = "<div class='"+body_class+"'><span class='tx'><em class='num'>"+st['th']+"</em></span></div>";
			$('.ladder_chart_inner table tbody tr td:eq('+td_num+')').append(sbody);
		}
		
		$(this).scrollLeft($("#graphTable").width());
	}
</script>
<body>
</html>