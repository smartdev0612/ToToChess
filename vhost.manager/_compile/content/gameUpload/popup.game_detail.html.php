<?php /* Template_ 2.2.3 2012/11/30 16:30:50 D:\www_kd_20140905\vhost.manager\_template\content\gameUpload\popup.game_detail.html */?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>합계</title>
</head>

<body>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>게임 상세 정보</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<table cellspacing="1" class="tableStyle_normal" summary="게임 상세 정보">
	<legend class="gameDetail_name"><?php echo $TPL_VAR["home_team"]?><span>VS</span><?php echo $TPL_VAR["away_team"]?></legend>
	<thead>
		<tr>
			<th></th>
			<th>홈팀(승)</th>
			<th>무승부</th>
			<th>원정(패)</th>
			<th>합계</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th>승무패</th>
			<td><?php echo number_format($TPL_VAR["home_bet_1"],0)?></td>
			<td><?php echo number_format($TPL_VAR["draw_bet"],0)?></td>
			<td><?php echo number_format($TPL_VAR["away_bet_1"],0)?></td>
			<td><?php echo number_format($TPL_VAR["line_1"],0)?></td>
		</tr>
		<tr> 
			<th>핸디캡</th>
			<td><?php echo number_format($TPL_VAR["home_bet_2"],0)?></td>
			<td>-</td>
			<td><?php echo number_format($TPL_VAR["away_bet_2"],0)?></td>
			<td><?php echo number_format($TPL_VAR["line_2"],0)?></td>
		</tr>
		<tr> 
			<th>언더오버</th>
			<td><?php echo number_format($TPL_VAR["home_bet_4"],0)?></td>
			<td>-</td>
			<td><?php echo number_format($TPL_VAR["away_bet_4"],0)?></td>
			<td><?php echo number_format($TPL_VAR["line_4"],0)?></td>
		</tr>
	</tbody>
	<tfoot>
		<tr> 
			<td>합계</td>
			<td><?php echo number_format($TPL_VAR["t_bet_1"],0)?></td>
			<td><?php echo number_format($TPL_VAR["draw_bet"],0)?></td>
			<td><?php echo number_format($TPL_VAR["t_bet_2"],0)?></td>
			<td><?php echo number_format($TPL_VAR["total"],0)?></td>
		</tr>
	</tfoot>
</table>
</body>
</html>