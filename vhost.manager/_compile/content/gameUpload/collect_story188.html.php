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
		<h1>story188배당 업로드</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<table border="0" cellpadding="0" cellspacing="0" class="tableStyle_collect7">
		<form name="form2" method="post" action="/gameUpload/uploadStory188">
        <legend>
             총 <b><?php echo count((array)$TPL_VAR["searchList"])?></b>개
        </legend>
		<tr>
			<td>		
				<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#E0E0E0">	
<?php if($TPL_searchList_1){
    foreach($TPL_VAR["searchList"] as $TPL_V1){?>
						<tr height="28" onmouseover="this.style.backgroundColor='#111111';" onmouseout="this.style.backgroundColor=''">
							<td bgcolor=<?php if($TPL_V1["idx"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?> width="50" align="center">
								<?php echo $TPL_V1["idx"]?><input type="hidden" name="game_num[]" value='<?php echo $TPL_V1["game_num"]?>'><input type="hidden" name="idx[]" value='<?php echo $TPL_V1["idx"]?>'>
							</td>
                            <td bgcolor=<?php if($TPL_V1["idx"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?> width="50" align="center">
                                <?php echo $TPL_V1["gametype_name"]?><input type="hidden" name="gametype[]" value='<?php echo $TPL_V1["gametype"]?>'>
                            </td>
                            <td bgcolor=<?php if($TPL_V1["idx"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?> width="90" align="center">
                            <?php echo $TPL_V1["category"]?><input type="hidden" name="category[]" value='<?php echo $TPL_V1["category"]?>'>
                            </td>
							<td bgcolor=<?php if($TPL_V1["idx"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?> width="90" align="center">
								<?php echo $TPL_V1["league_name"]?><input type="hidden" name="lg_img[]" value='<?php echo $TPL_V1["lg_img"]?>'><input type="hidden" name="league_name[]" value='<?php echo $TPL_V1["league_name"]?>'>
							</td>
							<td bgcolor=<?php if($TPL_V1["idx"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?> width="150" align="center">
								<?php echo $TPL_V1["game_date"]?>&nbsp;<?php echo $TPL_V1["game_hours"]?>:<?php echo $TPL_V1["game_minute"]?>:<?php echo $TPL_V1["game_second"]?><input type="hidden" name="game_date[]" value='<?php echo $TPL_V1["game_date"]?>'><input type="hidden" name="game_hours[]" value='<?php echo $TPL_V1["game_hours"]?>'><input type="hidden" name="game_minute[]" value='<?php echo $TPL_V1["game_minute"]?>'><input type="hidden" name="game_second[]" value='<?php echo $TPL_V1["game_second"]?>'>
							</td>
							<td bgcolor=<?php if($TPL_V1["idx"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?> width="130" align="center">
								<?php echo $TPL_V1["team1_name"]?><input type="hidden" name="team1_name[]" value="<?php echo $TPL_V1["team1_name"]?>">
							</td>
							<td bgcolor=<?php if($TPL_V1["idx"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?> width="110" align="center">
								<span style="position:relative;top:-2px">[승]</span> 
								<input type="text" name="a_rate1[]" size="5" value="<?php echo sprintf("%01.2f",($TPL_V1["a_rate1"]+$TPL_VAR["bianliang1"]))?>" style="border:1px solid #999999">
							</td>
							<td bgcolor=<?php if($TPL_V1["idx"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?> width="110" align="center">
								<span style="position:relative;top:-2px">[무]</span>
								<input type="text" name="a_rate2[]" size="5" value="<?php echo sprintf("%01.2f",($TPL_V1["a_rate2"]+$TPL_VAR["bianliang2"]))?>" style="border:1px solid #999999">
							</td>
							<td bgcolor=<?php if($TPL_V1["idx"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?> width="110" align="center">
								<span style="position:relative;top:-2px">[패]</span>
								<input type="text" name="a_rate3[]" size="5" value="<?php echo sprintf("%01.2f",($TPL_V1["a_rate3"]+$TPL_VAR["bianliang3"]))?>" style="border:1px solid #999999">
							</td>
							<td bgcolor=<?php if($TPL_V1["idx"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?> width="130" align="center">
								<?php echo $TPL_V1["team2_name"]?><input type="hidden" name="team2_name[]" value="<?php echo $TPL_V1["team2_name"]?>">
							</td>
							<td bgcolor=<?php if($TPL_V1["idx"]%2==0){?>'#ffffff' <?php }else{?> '#efefef' <?php }?> width="30" align="center">
								<input type="checkbox" name="chk_idx[]" value="<?php echo $TPL_V1["idx"]?>" onclick="check_this(this.form)" checked/>
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
							<!--<input type="checkbox" name="gametype[]" value='0' class="radio"> 일반
							<input type="checkbox" name="gametype[]" value='2' class="radio"> 핸디캡
							<input type="checkbox" name="gametype[]" value='4'  class="radio"> 오버언더-->
							
							<!--<input type="checkbox" name="kubun" value="0"> 전체발매가능&nbsp;&nbsp;-->
							<input type="submit" name="submit" value="경기올리기">
						</td>
						<td width="200" align="right" style="padding-right:5px">
							선택해제<input type="checkbox" name="chk_all" onclick="check_all(this.form)" value="checkall" checked>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		</form>
	</table>

	<div id="wrap_btn">
		<a href="#" onclick="window.close()"><img src="/img/btn_close.gif" title="창닫기"></a>
	</div>
</div>

</body>
</html>