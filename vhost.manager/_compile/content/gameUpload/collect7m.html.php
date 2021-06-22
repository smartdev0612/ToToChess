<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
$TPL_searchList_1=empty($TPL_VAR["searchList"])||!is_array($TPL_VAR["searchList"])?0:count($TPL_VAR["searchList"]);?>
<script language="javascript">
	
function check_this(form)
{
    if(form.chk_all.checked){form.chk_all.checked = form.chk_all.checked&0;}
}
function check_all(form)
{
    for(var i=0;i<form.elements.length;i++)
    {
        var e = form.elements[i];
        if((e.name !="chk_all") && (e.type=="checkbox"))
			e.checked = form.chk_all.checked;
    }
}
function check_abcd()
{
	form_abcd.submit();
}
</script>


<div id="wrap_pop">
	<div id="pop_title">
		<h1>7m배당 업로드</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<div id="search">
		<div class="betList_option">
			<form name="form1" method="post" action="?mode=collect">
				<span>마지막 수집시간</span>
				<input type="text" style="width:170px" value="<?php echo $TPL_VAR["lastCollectTime"]?>" readonly>
				<span>[총개수]</span>
				<input type="text" style="width:50px" value="<?php echo $TPL_VAR["total"]?>" readonly>개&nbsp;&nbsp;
				<input type="submit" name="btnCollect" value="데이터수집">
			</form>
		</div>
	</div>

	<table cellspacing="1" class="tableStyle_normal" summary="게임 정보">
	<thead>
		<tr>
			<th>날짜순 정렬</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
		<tr>
			<td>
				<span style='border:0px solid #999999;padding:2px;'>
					<a href='?mode=search&strtime1=<?php echo $TPL_V1["game_date"]?>'><?php echo $TPL_V1["game_date"]?>(<?php echo $TPL_V1["week"]?>)</a>
				</span>&nbsp;&nbsp;
<?php if($TPL_V1["i"]%9==0){?>
					<br>
<?php }?>
			</td>
		</tr>		
<?php }}?>
	</tbody>
	</table>

	<form action="" method="get" name="form_abcd">
		<input type="hidden" name="mode" value="search">		
		<input type="hidden" name="strtime1" value="<?php echo $TPL_VAR["strTime1"]?>">
		배당수정(
		홈:<input style="width:30px" type="text" name="bianliang1" value="<?php echo $TPL_VAR["bianliang1"]?>"> /
		무:<input style="width:30px" type="text" name="bianliang2" value="<?php echo $TPL_VAR["bianliang2"]?>"> /
		원정<input style="width:30px" type="text" name="bianliang3" value="<?php echo $TPL_VAR["bianliang3"]?>">
		)
		<input type="button" name="sub" value="수정" onclick="check_abcd();">
	</form>

	<table border="0" cellpadding="0" cellspacing="0" class="tableStyle_collect7">
		<form name="form2" method="post" action="/gameUpload/upload7m">
<?php if($TPL_VAR["mode"]=="search"){?>
		<legend>
			<?php echo $TPL_VAR["strTime1"]?><?php echo $TPL_VAR["week"]?> 총 <b><?php echo count((array)$TPL_VAR["searchList"])?></b>개
		</legend>
		<tr>
			<td>		
				<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#E0E0E0">	
<?php if($TPL_searchList_1){foreach($TPL_VAR["searchList"] as $TPL_V1){?>
						<tr height="28" onmouseover="this.style.backgroundColor='#111111';" onmouseout="this.style.backgroundColor=''">
							<td bgcolor=<?php if($TPL_V1["i"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?> width="50" rowspan="3" align="center">
								<?php echo $TPL_V1["idx"]?><input type="hidden" name="game_num[]" value='<?php echo $TPL_V1["game_num"]?>'><input type="hidden" name="idx[]" value='<?php echo $TPL_V1["idx"]?>'>
							</td>
							<td bgcolor=<?php if($TPL_V1["i"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?> width="90" rowspan="3" align="center">
								<?php echo $TPL_V1["league_name"]?><input type="hidden" name="league_num[]" value='<?php echo $TPL_V1["league_num"]?>'><input type="hidden" name="league_name[]" value='<?php echo $TPL_V1["league_name"]?>'>
							</td>
							<td bgcolor=<?php if($TPL_V1["i"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?> width="150" rowspan="3"align="center">
								<?php echo $TPL_V1["game_date"]?>&nbsp;<?php echo $TPL_V1["game_hours"]?>:<?php echo $TPL_V1["game_minute"]?>:<?php echo $TPL_V1["game_second"]?><input type="hidden" name="game_date[]" value='<?php echo $TPL_V1["game_date"]?>'><input type="hidden" name="game_hours[]" value='<?php echo $TPL_V1["game_hours"]?>'><input type="hidden" name="game_minute[]" value='<?php echo $TPL_V1["game_minute"]?>'><input type="hidden" name="game_second[]" value='<?php echo $TPL_V1["game_second"]?>'>
							</td>
							<td bgcolor=<?php if($TPL_V1["i"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?> width="130" rowspan="3" align="center">
								<?php echo $TPL_V1["team1_name"]?><input type="hidden" name="team1_name[]" value="<?php echo $TPL_V1["team1_name"]?>">
							</td>
							<td bgcolor=<?php if($TPL_V1["i"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?> width="110" align="center">
								<span style="position:relative;top:-2px">[승]</span> 
								<input type="text" name="a_rate1[]" size="5" value="<?php echo sprintf("%01.2f",($TPL_V1["a_rate1"]+$TPL_VAR["bianliang1"]))?>" style="border:1px solid #999999">
							</td>
							<td bgcolor=<?php if($TPL_V1["i"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?> width="110" align="center">
								<span style="position:relative;top:-2px">[무]</span>
								<input type="text" name="a_rate2[]" size="5" value="<?php echo sprintf("%01.2f",($TPL_V1["a_rate2"]+$TPL_VAR["bianliang2"]))?>" style="border:1px solid #999999">
							</td>
							<td bgcolor=<?php if($TPL_V1["i"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?> width="110" align="center">
								<span style="position:relative;top:-2px">[패]</span>
								<input type="text" name="a_rate3[]" size="5" value="<?php echo sprintf("%01.2f",($TPL_V1["a_rate3"]+$TPL_VAR["bianliang3"]))?>" style="border:1px solid #999999">
							</td>
							<td bgcolor=<?php if($TPL_V1["i"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?> width="30" align="center">
								<input type="radio" name="radio_<?php echo $TPL_V1["idx"]?>" value="1" <?php if($TPL_V1["rate_flag"]!=0){?>""<?php }else{?>checked<?php }?>>
							</td>
							<td bgcolor=<?php if($TPL_V1["i"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?> width="130" rowspan="3" align="center">
								<?php echo $TPL_V1["team2_name"]?><input type="hidden" name="team2_name[]" value="<?php echo $TPL_V1["team2_name"]?>">
							</td>
							<td bgcolor=<?php if($TPL_V1["i"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?> width="30" rowspan="3" align="center">
								<input type="checkbox" name="chk_idx[]" value="<?php echo $TPL_V1["idx"]?>" onclick="check_this(this.form)" checked/>
							</td>
						</tr>
						<tr height="28" onmouseover="this.style.backgroundColor='#111111';" onmouseout="this.style.backgroundColor=''">
							<td rowspan="2" align="center"" bgcolor=<?php if($TPL_V1["i"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?>>
								<span style="position:relative;top:-2px">[승]</span>
								<input type="text" name="b_rate1[]" size="5" value="<?php echo sprintf("%01.2f",($TPL_V1["b_rate1"]+$TPL_VAR["bianliang1"]))?>" style="border:1px solid #999999">
							</td>
							<td rowspan="2" align="center" bgcolor=<?php if($TPL_V1["i"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?>>
								<span style="position:relative;top:-2px">[무]</span>
								<input type="text" name="b_rate2[]" size="5" value="<?php echo sprintf("%01.2f",($TPL_V1["b_rate2"]+$TPL_VAR["bianliang2"]))?>" style="border:1px solid #999999">
							</td>
							<td rowspan="2" align="center" bgcolor=<?php if($TPL_V1["i"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?>>
								<span style="position:relative;top:-2px">[패]</span>
								<input type="text" name="b_rate3[]" size="5" value="<?php echo sprintf("%01.2f",($TPL_V1["b_rate3"]+$TPL_VAR["bianliang3"]))?>" style="border:1px solid #999999">
							</td>
							<td rowspan="2" align="center" bgcolor=<?php if($TPL_V1["i"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?>>
								<input type="radio" name="radio_<?php echo $TPL_V1["idx"]?>" value="2" <?php if($TPL_V1["rate_flag"]!=0){?>checked<?php }else{?>""<?php }?>>
							</td>
						</tr>
						<tr height="0" onmouseover="this.style.backgroundColor='#111111';" onmouseout="this.style.backgroundColor=''"></tr>
<?php }}?>
				</table>

				<table width="960" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
					<tr height="50">
						<td style="padding-left:10px">
							<!--
							<select name="gametype" >
								<option value="1">승무패</option>
								<option value="2">핸디캡</option>
								<option value="4">언더오버</option>
								<option value="6">*스페셜 승무패</option>
								<option value="7">*스페셜 핸디캡</option>
								<option value="8">*스페셜 언더오버</option>
							</select>
							-->
							<input type="checkbox" name="gametype[]" value='0' class="radio"> 일반
							<input type="checkbox" name="gametype[]" value='2' class="radio"> 핸디캡
							<input type="checkbox" name="gametype[]" value='4'  class="radio"> 오버언더
							
							<!--<input type="checkbox" name="kubun" value="0"> 전체발매가능&nbsp;&nbsp;-->
							<input type="submit" name="submit" value="경기올리기">
						</td>
						<td width="200" align="right" style="padding-right:5px">
							선택해제<input type="checkbox" name="chk_all" onclick="check_all(this.form)" value="checkall" checked>
						</td>
					</tr>
				</table>
			</td>
		</tt>
<?php }?>
		</form>
	</table>

	<div id="wrap_btn">
		<a href="#" onclick="window.close()"><img src="/img/btn_close.gif" title="창닫기"></a>
	</div>
</div>

</body>
</html>