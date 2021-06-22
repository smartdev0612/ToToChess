<?php /* Template_ 2.2.3 2013/10/24 07:04:02 D:\www_mos1\vhost.manager\_template\content\board\popup.betting.html */
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<title>배팅내역첨부</title>
<script>
	function select_all()
	{	
		var check_state = document.form1.check_all.checked;
		for (i=0;i<document.all.length;i++) 
		{
			if (document.all[i].name=="child_sn[]") 
			{
				document.all[i].checked = check_state;
			}
		}
	}	

	
	function on_submit()
	{
		if(confirm("입력하신 내용을 등록 하시겠습니까 ?"))
		{
			
			if( document.form1.gameDate.value == '' )
			{
				alert("구매일시를  입력하십시오.!");
				return;
			}
			if( document.form1.money.value == 0 )
			{
				alert("금액을 입력하십시오.!");
				return;
			}			
		
			document.form1.submit();
		}
		else 
		{
			return;
		}
	} 
</script>
</head>
<body style="margin-top:5px;">

	<form name="searchForm" method="post" action="?">
		<input type="hidden" name="perpage" value="<?php echo $TPL_VAR["perpage"]?>">
		<select name="special_type" style="margin-left:10px;">
			<option value="1" <?php if($TPL_VAR["special_type"]==1){?>  selected <?php }?>>일반</option>
            <option value="2" <?php if($TPL_VAR["special_type"]==2){?>  selected <?php }?>>실시간</option>
			<option value="4" <?php if($TPL_VAR["special_type"]==4){?>  selected <?php }?>>멀티</option>
			<option value="5" <?php if($TPL_VAR["special_type"]==5){?>  selected <?php }?>>사다리</option>
			<option value="6" <?php if($TPL_VAR["special_type"]==6){?>  selected <?php }?>>달팽이</option>
			<option value="7" <?php if($TPL_VAR["special_type"]==7){?> selected <?php }?>>파워볼</option>
		</select>
		<input type="submit" name="ok" value="검  색" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'"/>
	</form>


	<form id="form1" name="form1" method="post" action="?">
		<input type="hidden" name="act" value="add">
		<input type="hidden" name="perpage" value="<?php echo $TPL_VAR["perpage"]?>">
		&nbsp;&nbsp;구매일시:&nbsp; <input type="text" id="gameDate" name="gameDate" size="10" maxlength="10" onclick="new Calendar().show(this);"  readonly="readonly" style="border:1px #97ADCE solid;">
		&nbsp;<?php echo $TPL_VAR["gameHour"]?>시<?php echo $TPL_VAR["gameTime"]?>분<?php echo $TPL_VAR["gameSecond"]?>초
		&nbsp;&nbsp;배팅금액:&nbsp;	<input type="text" id="money" name="money" size=15 value="0" onkeyUp="javascript:this.value=FormatNumber(this.value);" style="text-align:right;">원			
		<input type="button" name="ok" value="등  록" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="on_submit()"/>


		<table cellspacing="1" class="tableStyle_gameList" style="padding:10px;">
			<thead>
	    		<tr>     
	      <!--	<th><input type="checkbox" name="check_all" onClick="select_all()"/> No</th>-->
	      	<th>No</th>
					<th>경기일시</th>
					<th>대분류</th>
					<th>종류</th>
					<th>종목</th>
					<th>리그</th>
					<th colspan="2">승(홈팀)</th>
					<th>무</th>
					<th colspan="2">패(원정팀)</th>
					<th>스코어</th>
					<th>이긴 팀</th>					
	    		</tr>	    		
	 		</thead>
	 		<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
	 				
	 				<tr>
	 					
	 					<!--<td><input type='checkbox' name='child_sn[]' id='child_sn[]' value='<?php echo $TPL_V1["child_sn"]?>'><font color='blue'> <?php echo $TPL_V1["child_sn"]?></font></td>-->
	 					<td><font color='blue'> <?php echo $TPL_V1["child_sn"]?></font></td>
	 					<td><?php echo sprintf("%s %s:%s",substr($TPL_V1["gameDate"],5),$TPL_V1["gameHour"],$TPL_V1["gameTime"])?></td>
						<td>
<?php if($TPL_V1["special"]==0){?>일반
<?php }elseif($TPL_V1["special"]==1){?>실시간
<?php }elseif($TPL_V1["special"]==2){?>멀티
<?php }elseif($TPL_V1["special"]==3){?>고액
<?php }elseif($TPL_V1["special"]==4){?>이벤트
<?php }?>
						</td>
						<td>
<?php if($TPL_V1["type"]==1){?><span class="victory">승무패</span>
<?php }elseif($TPL_V1["type"]==2){?><span class="handicap">핸디캡</span>
<?php }elseif($TPL_V1["type"]==4){?><span class="underover">언더오버</span>
<?php }?>
						</td>
						<td><?php echo $TPL_V1["sport_name"]?></td>
						<td><?php echo $TPL_V1["league_name"]?></td>
						<td <?php if($TPL_V1["win"]==1){?> style='background-color:#CEF279;'<?php }?>>
<?php if($TPL_V1["total_betting"]>0){?>
						  	<font color="blue">						  		
						  			<b><?php echo mb_strimwidth($TPL_V1["home_team"],0,20,"..","utf-8")?></b>
						  		</a>
						  	</font>
<?php }else{?>
						  	<?php echo mb_strimwidth($TPL_V1["home_team"],0,20,"..","utf-8")?>

							</a>
<?php }?>
						</td>
						<td <?php if($TPL_V1["win"]==1){?> style='background-color:#CEF279;'<?php }?>><input name="child_sn[<?php echo $TPL_V1["child_sn"]?>]" type="checkbox"  value="1" /><?php echo $TPL_V1["home_rate"]?></td>
						<td <?php if($TPL_V1["win"]==3){?> style='background-color:#CEF279;'<?php }?>><input name="child_sn[<?php echo $TPL_V1["child_sn"]?>]" type="checkbox"  value="3" /><?php echo $TPL_V1["draw_rate"]?></td>
						<td <?php if($TPL_V1["win"]==2){?> style='background-color:#CEF279;'<?php }?>><input name="child_sn[<?php echo $TPL_V1["child_sn"]?>]" type="checkbox"  value="2" /><?php echo $TPL_V1["away_rate"]?></td>
						<td <?php if($TPL_V1["win"]==2){?> style='background-color:#CEF279;'<?php }?>>
<?php if($TPL_V1["total_betting"]>0){?>
						  	<font color=blue>						  		
						  		<b><?php echo mb_strimwidth($TPL_V1["away_team"],0,20,"..","utf-8")?></b>
						  	</font>
<?php }else{?>						  	
						  	<?php echo mb_strimwidth($TPL_V1["away_team"],0,20,"..","utf-8")?>

								&nbsp;&nbsp;
<?php }?>
						</td>
						<td><?php echo $TPL_V1["home_score"]?>:<?php echo $TPL_V1["away_score"]?></td>
						<td>
<?php if($TPL_V1["win"]==1){?> 홈승
<?php }elseif($TPL_V1["win"]==2){?> 원정승
<?php }elseif($TPL_V1["win"]==3){?> 무승부
<?php }elseif($TPL_V1["win"]==4){?> 취소/적특
<?php }else{?> &nbsp;
<?php }?>
						</td>
	 				</tr>	
<?php }}?>
	 		</tbody>		
		</table>	
		<div id="pages">
			<?php echo $TPL_VAR["pagelist"]?>

		</div>
	</form>	
</body>
</html>