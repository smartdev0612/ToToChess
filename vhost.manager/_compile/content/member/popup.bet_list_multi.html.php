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
    <div id="betting_2">
        <ul id="tab">
            <li><a href="/member/popup_bet?mem_sn=<?=$TPL_VAR["mem_sn"]?>" id="sport_1">스포츠 I</a></li>
            <li><a href="/member/popup_bet_multi?mem_sn=<?=$TPL_VAR["mem_sn"]?>" id="sport_2">스포츠 II</a></li>
        </ul>
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
$TPL_item_2=empty($TPL_V1["item"])||!is_array($TPL_V1["item"])?0:count($TPL_V1["item"]);?>
			<table cellspacing="1" class="tableStyle_normal">
				<tbody>
					<!--<tr id="t_<?php echo $TPL_V1["betting_no"]?>" onclick="on_click('d_<?php echo $TPL_V1["betting_no"]?>','t_<?php echo $TPL_V1["betting_no"]?>')">-->
					<tr id="t_<?php echo $TPL_V1["betting_no"]?>" >
						<td width="2%"><input name="y_id[]" type="checkbox" id="y_id" value="1"  onclick="javascript:chkRow(this);"/></td>
						<td onclick="toggle('d_<?php echo $TPL_V1["betting_no"]?>')" width="10%"><?php echo $TPL_V1["betting_no"]?></td>	
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
						<th>게임종류</th>
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
    <?php if($TPL_item_2){
        foreach($TPL_V1["item"] as $TPL_V2){
            $detail_name = "";
			$home_score = "";
			$away_score = "";
			$homeTeamNameAdd = "";
			$awayTeamNameAdd = "";
			switch ($TPL_V2['sport_name']) {
				case "축구":
					switch ($TPL_V2['game_type']) {
						case "1":
							$detail_name = "<span class='victory'>승패</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							break;
						case "2":
						case "11":
							$detail_name = "<span class='handicap'>핸디캡</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "3":
						case "12":
							$detail_name = "<span class='underover'>언더오버</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
						case "4":
							$detail_name = "<span class='victory'>승무패</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							break;
						case "5":
							$detail_name = "<span class='victory'>승무패(전반)</span>";
							$home_score = $TPL_V2['home_half_time_score'];
							$away_score = $TPL_V2['away_half_time_score'];
							break;
						case "6":
							$detail_name = "<span class='victory'>승무패(후반)</span>";
							$home_score = $TPL_V2['home_2nd_half_time_score'];
							$away_score = $TPL_V2['away_2nd_half_time_score'];
							break;
						case "7":
							$detail_name = "<span class='underover'>언더오버(전반)</span>";
							$home_score = $TPL_V2['home_half_time_score'];
							$away_score = $TPL_V2['away_half_time_score'];
							break;
						case "8":
							$detail_name = "<span class='underover'>언더오버(후반)</span>";
							$home_score = $TPL_V2['home_2nd_half_time_score'];
							$away_score = $TPL_V2['away_2nd_half_time_score'];
							break;
						case "9":
							$detail_name = "<span>득점홀짝</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>[홀]</span>";
							$awayTeamNameAdd = "<span style='color:red'>[짝]</span>&nbsp;";
							break;
						case "10":
							$detail_name = "<span>득점홀짝(전반)</span>";
							$home_score = $TPL_V2['home_half_time_score'];
							$away_score = $TPL_V2['away_half_time_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>[홀]</span>";
							$awayTeamNameAdd = "<span style='color:red'>[짝]</span>&nbsp;";
							break;
						case "13":
							$detail_name = "정확한 스코어 (" . $TPL_V2['point'] . ")";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];

							break;
					}
					break;
				case "농구":
					switch ($TPL_V2['game_type']) {
						case "1":
							$detail_name = "<span class='victory'>승패</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							break;
						case "2":
						case "16":
							$detail_name = "<span class='handicap'>핸디캡</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "3":
						case "17":
							$detail_name = "<span class='underover'>언더오버</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
						case "4":
							$detail_name = "<span class='victory'>승무패(1쿼터)</span>";
							$home_score = $TPL_V2['home_1_time_score'];
							$away_score = $TPL_V2['away_1_time_score'];
							break;
						case "5":
							$detail_name = "<span class='victory'>승무패(2쿼터)</span>";
							$home_score = $TPL_V2['home_2_time_score'];
							$away_score = $TPL_V2['away_2_time_score'];
							break;
						case "6":
							$detail_name = "<span class='victory'>승무패(3쿼터)</span>";
							$home_score = $TPL_V2['home_3_time_score'];
							$away_score = $TPL_V2['away_3_time_score'];
							break;
						case "7":
							$detail_name = "<span class='victory'>승무패(4쿼터)</span>";
							$home_score = $TPL_V2['home_4_time_score'];
							$away_score = $TPL_V2['away_4_time_score'];
							break;
						case "8":
							$detail_name = "<span class='handicap'>핸디캡(1쿼터)</span>";
							$home_score = $TPL_V2['home_1_time_score'];
							$away_score = $TPL_V2['away_1_time_score'];
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "9":
							$detail_name = "<span class='handicap'>핸디캡(2쿼터)</span>";
							$home_score = $TPL_V2['home_2_time_score'];
							$away_score = $TPL_V2['away_2_time_score'];
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "10":
							$detail_name = "<span class='handicap'>핸디캡(3쿼터)</span>";
							$home_score = $TPL_V2['home_3_time_score'];
							$away_score = $TPL_V2['away_3_time_score'];
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "11":
							$detail_name = "<span class='handicap'>핸디캡(4쿼터)</span>";
							$home_score = $TPL_V2['home_4_time_score'];
							$away_score = $TPL_V2['away_4_time_score'];
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "12":
							$detail_name = "<span class='underover'>언더오버(1쿼터)</span>";
							$home_score = $TPL_V2['home_1_time_score'];
							$away_score = $TPL_V2['away_1_time_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
						case "13":
							$detail_name = "<span class='underover'>언더오버(2쿼터)</span>";
							$home_score = $TPL_V2['home_2_time_score'];
							$away_score = $TPL_V2['away_2_time_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
						case "14":
							$detail_name = "<span class='underover'>언더오버(3쿼터)</span>";
							$home_score = $TPL_V2['home_3_time_score'];
							$away_score = $TPL_V2['away_3_time_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
						case "15":
							$detail_name = "<span class='underover'>언더오버(4쿼터)</span>";
							$home_score = $TPL_V2['home_4_time_score'];
							$away_score = $TPL_V2['away_4_time_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
					}
					break;
				case "배구":
					switch ($TPL_V2['game_type']) {
						case "1":
							$detail_name = "<span class='victory'>승패</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							break;
						case "2":
							$detail_name = "<span class='handicap'>핸디캡</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "3":
							$detail_name = "<span class='underover'>언더오버</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							break;
						case "4":
							$detail_name = "<span>홀짝</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>[홀]</span>";
							$awayTeamNameAdd = "<span style='color:red'>[짝]</span>&nbsp;";
							break;
						case "5":
							$detail_name = "<span>홀짝(1세트)</span>";
							$home_score = $TPL_V2['home_1_time_score'];
							$away_score = $TPL_V2['away_1_time_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>[홀]</span>";
							$awayTeamNameAdd = "<span style='color:red'>[짝]</span>&nbsp;";
							break;
						case "6":
							$detail_name = "정확한 스코어 (" . $TPL_V2['point'] . ")";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							break;
					}
					break;
				case "야구":
					switch ($TPL_V2['game_type']) {
						case "1":
							$detail_name = "<span class='victory'>승패</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							break;
						case "2":
						case "11":
							$detail_name = "<span class='handicap'>핸디캡</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "3":
						case "12":
							$detail_name = "<span class='underover'>언더오버</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
						case "4":
							$detail_name = "<span class='victory'>승무패(1이닝)</span>";
							$home_score = $TPL_V2['home_1_time_score'];
							$away_score = $TPL_V2['away_1_time_score'];
							break;
						case "5":
							$detail_name = "<span class='handicap'>핸디캡(3이닝)</span>";
							if($TPL_V2['home_1_time_score'] != null && $TPL_V2['home_2_time_score'] != null && $TPL_V2['home_3_time_score'] != null && $TPL_V2['away_1_time_score'] != null && $TPL_V2['away_2_time_score'] != null &&  $TPL_V2['away_3_time_score'] != null) {
								$home_score = intval($TPL_V2['home_1_time_score']) + intval($TPL_V2['home_2_time_score']) + intval($TPL_V2['home_3_time_score']);
								$away_score = intval($TPL_V2['away_1_time_score']) + intval($TPL_V2['away_2_time_score']) + intval($TPL_V2['away_3_time_score']);
							}
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "6":
							$detail_name = "<span class='handicap'>핸디캡(5이닝)</span>";
							if($TPL_V2['home_1_time_score'] != null && $TPL_V2['home_2_time_score'] != null && $TPL_V2['home_3_time_score'] != null && $TPL_V2['home_4_time_score'] != null && $TPL_V2['home_5_time_score'] != null 
								&& $TPL_V2['away_1_time_score'] != null && $TPL_V2['away_2_time_score'] != null &&  $TPL_V2['away_3_time_score'] != null && $TPL_V2['away_4_time_score'] != null &&  $TPL_V2['away_5_time_score'] != null) {
								$home_score = intval($TPL_V2['home_1_time_score']) + intval($TPL_V2['home_2_time_score']) + intval($TPL_V2['home_3_time_score']) + intval($TPL_V2['home_4_time_score']) + intval($TPL_V2['home_5_time_score']);
								$away_score = intval($TPL_V2['away_1_time_score']) + intval($TPL_V2['away_2_time_score']) + intval($TPL_V2['away_3_time_score']) + intval($TPL_V2['away_4_time_score']) + intval($TPL_V2['away_5_time_score']);
							}
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "7":
							$detail_name = "<span class='handicap'>핸디캡(7이닝)</span>";
							if($TPL_V2['home_1_time_score'] != null && $TPL_V2['home_2_time_score'] != null && $TPL_V2['home_3_time_score'] != null && $TPL_V2['home_4_time_score'] != null && $TPL_V2['home_5_time_score'] != null && $TPL_V2['home_6_time_score'] != null && $TPL_V2['home_7_time_score'] != null 
								&& $TPL_V2['away_1_time_score'] != null && $TPL_V2['away_2_time_score'] != null &&  $TPL_V2['away_3_time_score'] != null && $TPL_V2['away_4_time_score'] != null &&  $TPL_V2['away_5_time_score'] != null && $TPL_V2['away_6_time_score'] != null &&  $TPL_V2['away_7_time_score'] != null) {
								$home_score = intval($TPL_V2['home_1_time_score']) + intval($TPL_V2['home_2_time_score']) + intval($TPL_V2['home_3_time_score']) + intval($TPL_V2['home_4_time_score']) + intval($TPL_V2['home_5_time_score']) + intval($TPL_V2['home_6_time_score']) + intval($TPL_V2['home_7_time_score']);
								$away_score = intval($TPL_V2['away_1_time_score']) + intval($TPL_V2['away_2_time_score']) + intval($TPL_V2['away_3_time_score']) + intval($TPL_V2['away_4_time_score']) + intval($TPL_V2['away_5_time_score']) + intval($TPL_V2['away_6_time_score']) + intval($TPL_V2['away_7_time_score']);
							}
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "8":
							$detail_name = "<span class='underover'>언더오버(3이닝)</span>";
							if($TPL_V2['home_1_time_score'] != null && $TPL_V2['home_2_time_score'] != null && $TPL_V2['home_3_time_score'] != null && $TPL_V2['away_1_time_score'] != null && $TPL_V2['away_2_time_score'] != null &&  $TPL_V2['away_3_time_score'] != null) {
								$home_score = intval($TPL_V2['home_1_time_score']) + intval($TPL_V2['home_2_time_score']) + intval($TPL_V2['home_3_time_score']);
								$away_score = intval($TPL_V2['away_1_time_score']) + intval($TPL_V2['away_2_time_score']) + intval($TPL_V2['away_3_time_score']);
							}
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
						case "9":
							$detail_name = "<span class='underover'>언더오버(5이닝)</span>";
							if($TPL_V2['home_1_time_score'] != null && $TPL_V2['home_2_time_score'] != null && $TPL_V2['home_3_time_score'] != null && $TPL_V2['home_4_time_score'] != null && $TPL_V2['home_5_time_score'] != null 
								&& $TPL_V2['away_1_time_score'] != null && $TPL_V2['away_2_time_score'] != null &&  $TPL_V2['away_3_time_score'] != null && $TPL_V2['away_4_time_score'] != null &&  $TPL_V2['away_5_time_score'] != null) {
								$home_score = intval($TPL_V2['home_1_time_score']) + intval($TPL_V2['home_2_time_score']) + intval($TPL_V2['home_3_time_score']) + intval($TPL_V2['home_4_time_score']) + intval($TPL_V2['home_5_time_score']);
								$away_score = intval($TPL_V2['away_1_time_score']) + intval($TPL_V2['away_2_time_score']) + intval($TPL_V2['away_3_time_score']) + intval($TPL_V2['away_4_time_score']) + intval($TPL_V2['away_5_time_score']);
							}
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
						case "10":
							$detail_name = "<span class='underover'>언더오버(7이닝)</span>";
							if($TPL_V2['home_1_time_score'] != null && $TPL_V2['home_2_time_score'] != null && $TPL_V2['home_3_time_score'] != null && $TPL_V2['home_4_time_score'] != null && $TPL_V2['home_5_time_score'] != null && $TPL_V2['home_6_time_score'] != null && $TPL_V2['home_7_time_score'] != null 
								&& $TPL_V2['away_1_time_score'] != null && $TPL_V2['away_2_time_score'] != null &&  $TPL_V2['away_3_time_score'] != null && $TPL_V2['away_4_time_score'] != null &&  $TPL_V2['away_5_time_score'] != null && $TPL_V2['away_6_time_score'] != null &&  $TPL_V2['away_7_time_score'] != null) {
								$home_score = intval($TPL_V2['home_1_time_score']) + intval($TPL_V2['home_2_time_score']) + intval($TPL_V2['home_3_time_score']) + intval($TPL_V2['home_4_time_score']) + intval($TPL_V2['home_5_time_score']) + intval($TPL_V2['home_6_time_score']) + intval($TPL_V2['home_7_time_score']);
								$away_score = intval($TPL_V2['away_1_time_score']) + intval($TPL_V2['away_2_time_score']) + intval($TPL_V2['away_3_time_score']) + intval($TPL_V2['away_4_time_score']) + intval($TPL_V2['away_5_time_score']) + intval($TPL_V2['away_6_time_score']) + intval($TPL_V2['away_7_time_score']);
							}
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
					}
					break;
				case "아이스하키":
					switch ($TPL_V2['game_type']) {
						case "1":
							$detail_name = "<span class='victory'>승패</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							break;
						case "2":
							$detail_name = "<span class='handicap'>핸디캡</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "3":
							$detail_name = "<span class='underover'>언더오버</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
						case "4":
							$detail_name = "<span class='victory'>승무패</span>";
							$home_score = $TPL_V2['home_score'];
							$away_score = $TPL_V2['away_score'];
							break;
						case "5":
							$detail_name = "<span class='victory'>승패(1피리어드)</span>";
							$home_score = $TPL_V2['home_1_time_score'];
							$away_score = $TPL_V2['away_1_time_score'];
							break;
						case "6":
							$detail_name = "<span class='victory'>승무패(1피리어드)</span>";
							$home_score = $TPL_V2['home_1_time_score'];
							$away_score = $TPL_V2['away_1_time_score'];
							break;
						case "7":
							$detail_name = "<span class='handicap'>핸디캡(1피리어드)</span>";
							$home_score = $TPL_V2['home_1_time_score'];
							$away_score = $TPL_V2['away_1_time_score'];
							$homeTeamNameAdd = "&nbsp;<font color='#ad3f2f'>[H]</font>";
							$awayTeamNameAdd = "<font color='#ad3f2f'>[H]</font>&nbsp;";
							break;
						case "8":
							$detail_name = "<span class='underover'>언더오버(1피리어드)</span>";
							$home_score = $TPL_V2['home_1_time_score'];
							$away_score = $TPL_V2['away_1_time_score'];
							$homeTeamNameAdd = "&nbsp;<span style='color:blue'>▼</span>";
							$awayTeamNameAdd = "<span style='color:red'>▲</span>&nbsp;";
							break;
					}
					break;
			}
    ?>
						<tr>				
							<td>
<?php if($TPL_V2["special"]==0){?>
									[일반]
<?php }elseif($TPL_V2["special"]==1){?>
									[실시간]
<?php }/*elseif($TPL_V2["special"]==2){*/?><!--
									[실시간]
--><?php /*}*/?>
							</td>
							<td>
                            <?=$detail_name?>
							</td>
							<td><?php echo $TPL_V2["g_date"]?></td>
							<td><?php echo $TPL_V2["league_name"]?></td>
							<td <?php if($TPL_V2["select_no"]==1){?>bgcolor='#CEF279'<?php }?>><?php echo $TPL_V2["home_team"].$homeTeamNameAdd?></td>
							<td <?php if($TPL_V2["select_no"]==1){?>bgcolor='#CEF279'<?php }?>><?php echo $TPL_V2["home_rate"]?></td>
							<td <?php if($TPL_V2["select_no"]==3){?>bgcolor='#CEF279'<?php }?> align=center><?php echo $TPL_V2["draw_rate"]?></td>
							<td <?php if($TPL_V2["select_no"]==2){?>bgcolor='#CEF279'<?php }?>><?php echo $TPL_V2["away_rate"]?></td>
							<td <?php if($TPL_V2["select_no"]==2){?>bgcolor='#CEF279'<?php }?>><?php echo $awayTeamNameAdd.$TPL_V2["away_team"]?></td>
							<td><?php echo $TPL_V2["home_score"]?>:<?php echo $TPL_V2["away_score"]?></td>
							<td>
<?php if($TPL_V2["select_no"]==1){?>
									홈팀
<?php }elseif($TPL_V2["select_no"]==2){?>
									원정팀
<?php }else{?>
									무
<?php }?>	
							</td>
							<td>
<?php if($TPL_V2["win"]==1){?>[홈승]
<?php }elseif($TPL_V2["win"]==3){?>[무승부]
<?php }elseif($TPL_V2["win"]==2){?>[원정승]
<?php }elseif($TPL_V2["win"]==4){?>[취소]
<?php }?>
							</td>	
							<td>
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