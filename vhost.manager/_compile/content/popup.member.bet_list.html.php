<?php /* Template_ 2.2.3 2012/10/09 18:29:24 C:\APM_Setup\htdocs\www\vhost.manager\_template\content\popup.member.bet_list.html */
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
			if(confirm("정말 삭제하시겠습니까?  ")){open_window(url);}
			else {return;}
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
			<input type="hidden" name="memidx" value="<?php echo $TPL_VAR["mem_idx"]?>">
			<input type="hidden" name="perpage" value="<?php echo $TPL_VAR["perpage"]?>">
			<span class="icon">배팅 번호</span><input type="input" name="game_no" value="<?php echo $TPL_VAR["game_no"]?>"> 
			<input type="submit" value="검색" class="btnStyle3" />
			</form>
		</div>
	</div>

	<form id="form1" name="form1" method="post" action="?act=delete_user">
		<table cellspacing="1" class="tableStyle_normal" summary="배팅 내역">
			<legend class="blind">배팅 내역</legend>
			<thead>
				<tr>
					<th width="2%"><input type="checkbox" name="chkAll" title="전체선택" onClick="selectAll()"/></th>
				  	<th width="10%">배팅번호</th>
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
					 <th width="5%">처리</th>
				</tr>
			</thead>
		</table>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){
$TPL_item_2=empty($TPL_V1["item"])||!is_array($TPL_V1["item"])?0:count($TPL_V1["item"]);?>
			<table cellspacing="1" class="tableStyle_normal">
				<tbody>
					<tr id="t_<?php echo $TPL_V1["game_no"]?>" onclick="on_click('d_<?php echo $TPL_V1["game_no"]?>','t_<?php echo $TPL_V1["game_no"]?>')">
						<td width="2%"><input name="y_id[]" type="checkbox" id="y_id" value="1"  onclick="javascript:chkRow(this);"/></td>
						<td width="10%"><?php echo $TPL_V1["game_no"]?></td>	
						<td width="5%"><?php echo $TPL_V1["mem_id"]?></td>					
						<td width="5%"><?php echo $TPL_V1["nick"]?></td>
						<td width="5%"><?php echo $TPL_V1["betting_cnt"]?></td>
						<td width="8%"><?php echo number_format($TPL_V1["before_money"],0)?></td>
						<td width="5%"><?php echo number_format($TPL_V1["betting_money"],0)?></td>
						<td width="5%"><?php echo $TPL_V1["result_rate"]?></td>
						<td width="5%"><?php echo number_format(($TPL_V1["betting_money"]*$TPL_V1["result_rate"]),0)?></td>
						<td width="5%"><?php echo number_format($TPL_V1["result_money"],0)?></td>
						<td width="12%"><?php echo $TPL_V1["regdate"]?></td>
						<td width="15%"><?php echo $TPL_V1["operdate"]?></td>
						<td width="5%"><?php echo $TPL_V1["bonus"]?></td>
						<td width="5%">
<?php if($TPL_V1["result"]==1){?>
								<font color='red'>적 중</font>
<?php }elseif($TPL_V1["result"]==2){?>
								<font color='blue'>낙 첨</font>
<?php }else{?>
								진행중
<?php }?>
						</td>
						<td width="5%">
<?php if($TPL_V1["aresult"]==0){?>
								<a href='javascript:void(0)' onclick="go_delete(betdelete.php?intParentIdx=<?php echo $TPL_V1["intParentIdx"]?>&game_no=<?php echo $TPL_V1["game_no"]?>&oper='race')">
									<img src='/img/btn_s_cancel.gif' title='취소'>
								</a>
<?php }else{?>
								&nbsp;
<?php }?>
						</td>
						</tr>
				</tbody>
			</table>

			<!-- Click Event -->
			<table cellspacing="1" class="tableStyle_memo" id="d_<?php echo $TPL_V1["game_no"]?>" style="display:none;width:90%;margin:0 auto;margin-top:5px;margin-bottom:5px">
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
						<th>상태</th>
					</tr>
				</thead>
				<tbody>
<?php if($TPL_item_2){foreach($TPL_V1["item"] as $TPL_V2){?>
						<tr>				
							<td>
<?php if($TPL_V2["game_type"]==1){?>
									[승무패]
<?php }elseif($TPL_V2["game_type"]==2){?>
									[핸디캡]
<?php }elseif($TPL_V2["game_type"]==3){?>
									[홀짝]
<?php }elseif($TPL_V2["game_type"]==4){?>
									[언더오버]
<?php }?>
							</td>
							<td><?php echo $TPL_V2["date"]?></td>
							<td><?php echo $TPL_V2["name"]?></td>
							<td><?php echo $TPL_V2["strHomeTeamName"]?></td>
							<td><?php echo $TPL_V2["rate1"]?></td>
							<td><?php echo $TPL_V2["rate3"]?></td>
							<td><?php echo $TPL_V2["strAwayTeamName"]?></td>
							<td><?php echo $TPL_V2["rate2"]?></td>
							<td><?php echo $TPL_V2["intHomeTeamScore"]?>:<?php echo $TPL_V2["intAwayTeamScore"]?></td>
							<td>
<?php if($TPL_V2["gameselect"]==1){?>
									홈팀
<?php }elseif($TPL_V2["gameselect"]==2){?>
									원정팀
<?php }else{?>
									무
<?php }?>	
							</td>
							<td>
<?php if($TPL_V2["game_result"]==0){?>
									<font color=#666666>진행중</font>
<?php }elseif($TPL_V2["game_result"]==1){?>
									<font color=red>적  중</font>
<?php }elseif($TPL_V2["game_result"]==2){?>
									<font color=blue>낙 첨</font>
<?php }elseif($TPL_V2["game_result"]==4){?>
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
	</form>
	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>
</div>
</body>
</html>