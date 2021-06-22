<?php /* Template_ 2.2.3 2014/10/22 22:27:22 D:\www_ggo-337.com\vhost.user\_template\content\upload_betting.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="Generator" content="EditPlus">
	<link rel="stylesheet" type="text/css" href="/include/css/game.css"/>
	<link rel="stylesheet" type="text/css" href="/include/css/layout.css"/>
	<title><?php echo $TPL_VAR["SITE_TITLE"]?></title>
	<script type="text/javascript" src="/include/js/jquery-1.12.3.min.js"></script>
</head>

<script>
	function on_upload()
	{
		var bettings = document.getElementsByName('check_upload');
		var param = '';
		for( i=0; i<bettings.length; ++i)
		{
			if( bettings[i].checked==true)
			{
				param +=bettings[i].value;
				param +=';';
			}
		}

		if ( !param.length ) {
			alert('경기를 선택해주세요.');
			return;
		}

		window.opener.location.href = '/board/write?bettings='+param;
		self.close();
	}
</script>

<body style="margin:10px; background:#1d1d1d" id="bethistorypage">

<div id="wrap_body">
	<div id="subvisual" class="subvisual_bethistory">
		<h3><img src="/images/title_bethistory.gif"></h3>
	</div>

  <!-- 게시판 시작 -->
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_K1=>$TPL_V1){
$TPL_item_2=empty($TPL_V1["item"])||!is_array($TPL_V1["item"])?0:count($TPL_V1["item"]);?>
  <table width="100%" cellspacing="1" class="tablestyle_gamelist" id="bethistory">
	<thead>
		<tr>
			<th>경기시간</th>
			<th>타입</th>
			<th>리그</th>
			<th class="home">홈(승)</th>
			<th class="draw">VS(무)</th>
			<th class="away">원정(패)</th>
			<th>스코어</th>
			<th>결과</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_item_2){foreach($TPL_V1["item"] as $TPL_V2){?>
<?php if($TPL_V1["bet_enable"]==0){?>
	<tr class="gameend">
<?php }else{?>
	<tr>
<?php }?>
		<td class="date"><?php echo sprintf("%s/%s %s:%s",substr($TPL_V2["gameDate"],5,2),substr($TPL_V2["gameDate"],8,2),$TPL_V2["gameHour"],$TPL_V2["gameTime"])?></td>
		<td class="type">
<?php if($TPL_V2["special_type"]==1){?>스페셜<?php }?>
<?php if($TPL_V2["game_type"]==1){?>승무패
<?php }elseif($TPL_V2["game_type"]==2){?>핸디캡
<?php }elseif($TPL_V2["game_type"]==4){?>언더오버
<?php }?>
		  </td>
		<td class="league">
			<img src='<?php echo $TPL_V2["league_image"]?>'><span><?php echo $TPL_V2["league_name"]?></span>
		</td>
		  <td valign="top" <?php if($TPL_V2["win"]==1&&$TPL_V2["select_no"]==1){?>class="homewin"<?php }elseif($TPL_V2["win"]==1&&$TPL_V2["select_no"]!=1){?>class="homewin_nopick"<?php }elseif($TPL_V2["win"]!=1&&$TPL_V2["select_no"]==1){?>class="homepick"<?php }elseif($TPL_V2["win"]!=1&&$TPL_V2["select_no"]!==1){?>class="home"<?php }elseif($TPL_V2["select_no"]==1){?>class="homepick"<?php }?>>
			<div>
			<span class="name"><?php echo $TPL_V2["home_team"]?></span><span class="rate"><?php echo $TPL_V2["home_rate"]?></span><!--<img src="/images/game/icon_up.gif">-->
			</div>
		  </td>
		  <td valign="top" <?php if($TPL_V2["win"]==3&&$TPL_V2["select_no"]==3){?>class="drawwin"<?php }elseif($TPL_V2["win"]==3&&$TPL_V2["select_no"]!=3){?>class="drawwin_nopick"<?php }elseif($TPL_V2["win"]!=3&&$TPL_V2["select_no"]==3){?>class="drawpick"<?php }elseif($TPL_V2["win"]!=3&&$TPL_V2["select_no"]!==3){?>class="draw"<?php }elseif($TPL_V2["select_no"]==3){?>class="drawpick"<?php }?>>
<?php if(($TPL_V2["game_type"]==1&&($TPL_V2["draw_rate"]=="1.00"||$TPL_V2["draw_rate"]=="1"))||($TPL_V2["game_type"]==2&&$TPL_V2["draw_rate"]=="0")){?><b>VS</b>
<?php }else{?>						  
				  <span class="rate"><?php if($TPL_V2["game_type"]==1){?><?php echo number_format($TPL_V2["draw_rate"],2)?><?php }else{?><?php echo $TPL_V2["draw_rate"]?><?php }?></span>
<?php }?>
		  </td>
		  <td valign="top" <?php if($TPL_V2["win"]==2&&$TPL_V2["select_no"]==2){?>class="awaywin"<?php }elseif($TPL_V2["win"]==2&&$TPL_V2["select_no"]!=2){?>class="awaywin_nopick"<?php }elseif($TPL_V2["win"]!=2&&$TPL_V2["select_no"]==2){?>class="awaypick"<?php }elseif($TPL_V2["win"]!=2&&$TPL_V2["select_no"]!==2){?>class="away"<?php }elseif($TPL_V2["select_no"]==1){?>class="awaypick"<?php }?>>
			<div>
			<span class="name"><?php echo $TPL_V2["away_team"]?></span><span class="rate"><?php echo $TPL_V2["away_rate"]?></span><!--<img src="/images/game/icon_down.gif">-->
			</div>
		  </td>
		  <!--  style="border:1 solid #c4273f;" -->
		  
		  <td class="score"><?php if($TPL_V2["home_score"]==""){?><?php }else{?>[<?php echo $TPL_V2["home_score"]?>:<?php echo $TPL_V2["away_score"]?>]<?php }?></td>
		  <td class="result">
<?php if($TPL_V2["result"]==0){?>진행중
<?php }elseif($TPL_V2["result"]==1){?><span class="win">적중</span>
<?php }elseif($TPL_V2["result"]==2){?><span class="lose">미적중</span>
<?php }elseif($TPL_V2["result"]==4){?><span class="cancel">취소</span>
<?php }else{?>배팅중
<?php }?>
		  </td>
		</tr>
<?php }}?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="8">
					<input type="checkbox" name="check_upload" value="<?php echo $TPL_K1?>">
					<span>구매일시 :<b><?php echo $TPL_V1["bet_date"]?></b></span><span>선택경기 :<b><?php echo $TPL_V1["betting_cnt"]?></b></span><span>배팅금액 :<b><?php echo number_format($TPL_V1["betting_money"])?></b></span><span>배당률 :<b><?php echo $TPL_V1["result_rate"]?></b></span>
				</td>
			</tr>
			<tr>
				<td colspan="8" class="info">
					<span>당첨금 :<b><?php echo number_format($TPL_V1["win_money"])?>원</b> <!--(+<?php echo $TPL_V1["bonus_rate"]?>% <?php echo number_format($TPL_V1["folder_bonus"])?>포인트)--></span>
					<span>결과 :<b><?php if($TPL_V1["result"]==0){?>진행중<?php }elseif($TPL_V1["result"]==2){?><span class="lose">미적중</span><?php }elseif($TPL_V1["result"]==4){?><span class="cancel">취소</span><?php }else{?><span class="win">적중</span><?php }?></b></span>
					<p class="btn">
						<a onclick="on_upload()"><img src="/images/btn_bethistory_upbbs.gif"></a>
					</p>
				</td>
			</tr>
		</tfoot>
		</table>
<?php }}?>

		<div class="wrap_page">
			<?php echo $TPL_VAR["pagelist"]?>
		</div>
</div>