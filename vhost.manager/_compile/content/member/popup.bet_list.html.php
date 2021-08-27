<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script type="text/javascript">
		function on_click(t_id,x_id)
		{
			//alert(t_id);
			
			var d_id = new _toggle($.id(t_id));
			$.id(x_id).onclick=function()
			{
				d_id.toggle();
			}
			
		}
		
		
		function go_delete(url)
		{
			if(confirm("정말 삭제하시겠습니까?  "))
			{
				document.location = url;
			}
			else
			{
				return;
			}
		}
	
		function toggle(id)
		{
			$( "#"+id ).slideToggle(100);
		}	
	
	</script>
</head>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>배팅 내역</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>
	<div id="search">
		<div>
			<form action="?" method="get" >
			<input type="hidden" name="mem_sn" value="<?php echo $TPL_VAR["mem_sn"]?>">
			<input type="hidden" name="perpage" value="<?php echo $TPL_VAR["perpage"]?>">

            <span class="icon">날짜</span>&nbsp;
            <input name="begin_date" type="text" id="begin_date" class="date" value="<?php echo $TPL_VAR["begin_date"]?>" maxlength="20" onclick="new Calendar().show(this);"/>&nbsp;~
            <input name="end_date" type="text" id="end_date" class="date" value="<?php echo $TPL_VAR["end_date"]?>" maxlength="20" onclick="new Calendar().show(this);" />&nbsp;
            <select name="select_keyword" onChange="onKeywordChange(this.form)">
                <option value="" 	<?php if($TPL_VAR["select_keyword"]==''){?>  selected <?php }?>>전체</option>
                <option value="betting_no"<?php if($TPL_VAR["select_keyword"]=='betting_no'){?>  selected <?php }?>>배팅번호</option>
                <option value="money_up"<?php if($TPL_VAR["select_keyword"]=='money_up'){?>  selected <?php }?>>배팅금↑</option>
                <option value="money_down"<?php if($TPL_VAR["select_keyword"]=='money_down'){?>  selected <?php }?>>배팅금↓</option>
            </select>
            <input type="text" name="keyword" value=<?php echo $TPL_VAR["keyword"]?>>

			<!--<span class="icon">배팅 번호</span><input type="input" name="betting_no" value="<?php /*echo $TPL_VAR["betting_no"]*/?>">-->
			<input type="submit" value="검색" class="btnStyle3" />
			</form>
		</div>
	</div>

	<form id="form1" name="form1" method="post" action="?act=delete_user">
		<input type="hidden" name="mem_sn" value="<?php echo $TPL_VAR["mem_sn"]?>">
		<input type="hidden" name="perpage" value="<?php echo $TPL_VAR["perpage"]?>">
			
		<table cellspacing="1" class="tableStyle_normal" summary="배팅 내역">			
			<legend class="blind">배팅 내역</legend>
			<thead>
				<tr>
					<th width="2%"><input type="checkbox" name="chkAll" title="전체선택" onClick="selectAll()"/></th>
				  	<th width="10%">배팅번호</th>
					<th width="5%">유형</th>
					<th width="5%">아이디</th>
					<th width="5%">닉네임</th>
					<th width="5%">게임</th>
					<th width="8%">당시금액</th>
					<th width="5%">배팅금액</th>
					<th width="5%">배당율</th>
					<th width="5%">예상금액</th>
					<th width="5%">배당금액</th>
					<th width="12%">배팅시간</th>
					<th width="15%">처리시간</th>
					<th width="5%">보너스</th>
					<th width="5%">결과</th>
				</tr>
			</thead>
		</table>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){
	$isLive = $TPL_V1["item"][0]["live"];
	$TPL_item_2=empty($TPL_V1["item"])||!is_array($TPL_V1["item"])?0:count($TPL_V1["item"]);?>
			<table cellspacing="1" class="tableStyle_normal">
				<tbody>
					<!--<tr id="t_<?php echo $TPL_V1["betting_no"]?>" onclick="on_click('d_<?php echo $TPL_V1["betting_no"]?>','t_<?php echo $TPL_V1["betting_no"]?>')">-->
					<tr id="t_<?php echo $TPL_V1["betting_no"]?>" >
						<td width="2%"><input name="y_id[]" type="checkbox" id="y_id" value="1"  onclick="javascript:chkRow(this);"/></td>
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" width="10%"><?php echo $TPL_V1["betting_no"]?></td>
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"  width="5%">
							<?php 
							if($isLive > 0)
								echo "라이브";
							else if ( $isLive == 0 && $TPL_V1["last_special_code"] < 5)
								echo "스포츠";
							else if ( $TPL_V1["last_special_code"] == 7)
								echo "파워볼";
							else if ( $TPL_V1["last_special_code"] == 25)
								echo "파워사다리";
							?>
						</td>		
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')"  width="5%"><?php echo $TPL_V1["member"]["uid"]?></td>					
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" width="5%"><?php echo $TPL_V1["member"]["nick"]?></td>
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" width="5%"><?php echo $TPL_V1["betting_cnt"]?></td>
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" width="8%"><?php echo number_format($TPL_V1["before_money"],0)?></td>
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" width="5%"><?php echo number_format($TPL_V1["betting_money"],0)?></td>
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" width="5%"><?php echo number_format($TPL_V1["result_rate"],2)?></td>
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" width="5%"><?php echo number_format(($TPL_V1["betting_money"]*$TPL_V1["result_rate"]),0)?></td>
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" width="5%"><?php echo number_format($TPL_V1["result_money"],0)?></td>
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" width="12%"><?php echo $TPL_V1["regdate"]?></td>
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" width="15%"><?php echo $TPL_V1["operdate"]?></td>
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" width="5%"><?php echo $TPL_V1["bonus"]?></td>
						<td width="5%"><input type="button" value="취소"  class="btnStyle3" onClick="go_delete('/member/betcancelProcess?betting_no=<?php echo $TPL_V1["betting_no"]?>&oper=race')"></td>
						<!--
						<td width="5%">
<?php if($TPL_V1["aresult"]==0){?>
								<a href='javascript:void(0)' onclick="go_delete(/member/betcancelProcess?betting_no=<?php echo $TPL_V1["betting_no"]?>&oper='race')">
									<img src='/img/btn_s_cancel.gif' title='취소'>
								</a>
<?php }else{?>
								&nbsp;
<?php }?>
						</td>
						-->
						</tr>
				</tbody>
			</table>

			<!-- Click Event -->
			<table cellspacing="1" class="tableStyle_memo" id="d_<?php echo $TPL_V1["betting_no"]?>" style="display:none;width:90%;margin:0 auto;margin-top:5px;margin-bottom:5px">
				<thead>
					<tr>				  
						<th>게임타입</th>
						<th>경기시간</th>
						<th>리그</th>
						<th colspan="2">홈팀</th>
						<th>무</th>
						<th colspan="2">원정팀</th>
						<th>점수</th>
						<th>배팅</th>
						<th>결과</th>
						<th>상태</th>
					</tr>
				</thead>
				<tbody>
<?php if($TPL_item_2){foreach($TPL_V1["item"] as $TPL_V2){?>
						<tr>
							<td align="center">
							<?php
								$pieces = explode("|", $TPL_V2["mname_ko"]);
								switch($TPL_V2["sport_id"]) {
									case 6046: // 축구
										echo $pieces[0];
										break;
									case 48242: // 농구
										echo $pieces[1];
										break;
									case 154914: // 야구
										echo $pieces[2];
										break;
									case 154830: // 배구
										echo $pieces[3];
										break;
									case 35232: // 아이스 하키
										echo $pieces[4];
										break;
									case 687890: // E스포츠
										echo $pieces[5];
										break;
								}
							?>
							</td>
							<td align="center"><?php echo $TPL_V2["g_date"]?></td>
							<td align="center"><?php echo $TPL_V2["league_name"]?></td>
							<td align="center" <?php if($TPL_V2["select_no"]==1){?>bgcolor='#CEF279'<?php }?>><?php echo $TPL_V2["home_team"]?></td>
							<td align="center" <?php if($TPL_V2["select_no"]==1){?>bgcolor='#CEF279'<?php }?>><?php echo $TPL_V2["home_rate"]?></td>
							<td align="center" <?php if($TPL_V2["select_no"]==3){?>bgcolor='#CEF279'<?php }?> align=center>
							<?php 
								switch($TPL_V2["mfamily"]) {
									case 1:
										echo $TPL_V2["draw_rate"]; 
										break;
									case 2:
										echo "VS";
										break;
									case 7:
										echo $TPL_V2["home_line"];
										break;
									case 8:
									case 9:
										$home_line = explode(" ", $TPL_V2["home_line"]);
										echo $home_line[0];
										break;
									case 10:
										echo "VS";
										break;
									case 11:
										echo $TPL_V2["home_name"];
										break;
									case 12:
										echo $TPL_V2["draw_rate"];
										break;
									case 47:
										echo $TPL_V2["home_line"];
										break;
								}
								
							?>
							</td>
							<td align="center" <?php if($TPL_V2["select_no"]==2){?>bgcolor='#CEF279'<?php }?>><?php echo $TPL_V2["away_rate"]?></td>
							<td align="center" <?php if($TPL_V2["select_no"]==2){?>bgcolor='#CEF279'<?php }?>><?php echo $TPL_V2["away_team"]?></td>
							<td align="center">
								<?php 
									if($TPL_V2["live"] == 1)
										echo $TPL_V2["score"];
									else 
										echo $TPL_V2["home_score"] . "-" . $TPL_V2["away_score"];
								?>
							</td>
							<td align="center">
								<?php
									$selectedTeam = "";
									switch($TPL_V2["mfamily"]) {
										case 1:
										case 2:
											if($TPL_V2["select_no"] == "1")
												$selectedTeam = '홈팀';
											else if($TPL_V2["select_no"] == "2") 
												$selectedTeam = '원정팀';                       
											else if($TPL_V2["select_no"] == "3")                        
												$selectedTeam = '무승부'; 
											break;
										case 7:
											if($TPL_V2["select_no"] == "1") {
												$selectedTeam = '언더 <span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
											} else if($TPL_V2["select_no"] == "2") {
												$selectedTeam = '오버 <span class="txt_co6">(' . $TPL_V2["away_line"] . ')</span>'; 
											}
											break;
										case 8:
										case 9:
											if($TPL_V2["select_no"] == "1") {
												$home_line = explode(" ", $TPL_V2["home_line"]);
												$selectedTeam = $TPL_V2["home_team"] . '<span class="txt_co6">(' . $home_line[0] . ')</span>';
											} else if($TPL_V2["select_no"] == "2") {
												$away_line = explode(" ", $TPL_V2["away_line"]);
												$selectedTeam = $TPL_V2["away_team"] . '<span class="txt_co6">(' . $away_line[0] . ')</span>'; 
											}
											break;
										case 10:
											if($TPL_V2["select_no"] == "1")
												$selectedTeam = '홀수';
											else if($TPL_V2["select_no"] == "2") 
												$selectedTeam = '짝수'; 
											break;
										case 11:
											$selectedTeam = $TPL_V2["home_name"];
											break;
										case 12:
											if($TPL_V2["select_no"] == "1")
												$selectedTeam = '승무';
											else if($TPL_V2["select_no"] == "2") 
												$selectedTeam = '무패';                       
											else if($TPL_V2["select_no"] == "3")                        
												$selectedTeam = '승패'; 
											break;
										case 47:
											if($TPL_V2["home_name"] == "1 And Under")
												$selectedTeam = '홈승 & 언더' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
											else if($TPL_V2["home_name"] == "1 And Over") 
												$selectedTeam = '홈승 & 오버' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';                       
											else if($TPL_V2["home_name"] == "2 And Under")                        
												$selectedTeam = '원정승 & 언더' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>'; 
											else if($TPL_V2["home_name"] == "2 And Over")
												$selectedTeam = '원정승 & 오버' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
											else if($TPL_V2["home_name"] == "X And Under")
												$selectedTeam = '무 & 언더' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
											else if($TPL_V2["home_name"] == "X And Over")
												$selectedTeam = '무 & 오버' . '<span class="txt_co6">(' . $TPL_V2["home_line"] . ')</span>';
											break;
									}
									echo $selectedTeam;
								?>
							</td>
							<td align="center">
<?php if($TPL_V2["win"]==1){?>[홈승]
<?php }elseif($TPL_V2["win"]==3){?>[무승부]
<?php }elseif($TPL_V2["win"]==2){?>[원정승]
<?php }elseif($TPL_V2["win"]==4){?>[취소]
<?php }?>
							</td>	
							<td align="center">
<?php if($TPL_V2["result"]==0){?>
									<font color=#666666>진행중</font>
<?php }elseif($TPL_V2["result"]==1){?>
									<font color=red>적  중</font>
<?php }elseif($TPL_V2["result"]==2){?>
									<font color=blue>낙 첨</font>
<?php }elseif($TPL_V2["result"]==4){?>
									<font color=green>취 소</font>
<?php }?>
							</td>
						</tr>	
<?php }}?>
				</tbody>
				</table>
<?php }}?>
		</tbody>
	</table>
	
	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>
	
	</form>
	
</div>
</body>
</html>