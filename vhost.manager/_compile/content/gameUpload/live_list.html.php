<?php
$TPL_categoryList_1=empty($TPL_VAR["categoryList"])||!is_array($TPL_VAR["categoryList"])?0:count($TPL_VAR["categoryList"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>
    function orderFixture(child_sn) {
        $("#orderBtn_" + child_sn).prop('disabled', true);
        $("#cancelBtn_" + child_sn).prop('disabled', false);
        $.ajax({
            url: "/orderFixture",
            type: "GET",
            data: {
                "child_sn": child_sn
            },
            success: function(res){ 
				//alert(res);
                var json = JSON.parse(res);
				if(json.status == 0) {
					$("#orderBtn_" + child_sn).prop('disabled', false);
       				$("#cancelBtn_" + child_sn).prop('disabled', true);
				} else {
					var cnt = parseInt($("#orderCnt").text()) + 1;
					$("#orderCnt").text(cnt);
				}
				alert(json.msg);
            }
        });
    }

    function cancelOrder(child_sn) {
        $("#orderBtn_" + child_sn).prop('disabled', false);
        $("#cancelBtn_" + child_sn).prop('disabled', true);
        $.ajax({
            url: "/cancelOrder",
            type: "GET",
            data: {
                "child_sn": child_sn
            },
            success: function(res){ 
				var cnt = parseInt($("#orderCnt").text()) - 1;
				$("#orderCnt").text(cnt);
                alert(res);
            }
        });
    }
</script>
</head>
	<div id="route">
		<h5>관리자 시스템 - 항목 보기</h5>
	</div>
	<h3>항목 보기</h3>
	<div id="search">
		<div class="wrap_search">
			<form name=frmSrh method=post action="/gameUpload/liveList"> 	
				<input type="hidden" name="category_name" value="">
				
				<span>출력</span>
				<input name="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" size="5" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()">

				&nbsp;
				<span class="icon">정렬</span>
				
				<select name="categoryName">
					<option value="">종목</option>
	<?php if($TPL_categoryList_1){foreach($TPL_VAR["categoryList"] as $TPL_V1){?>
						<option value="<?php echo $TPL_V1["name"]?>" <?php if($TPL_VAR["categoryName"]==$TPL_V1["name"]){?> selected <?php }?>><?php echo $TPL_V1["name"]?></option>
	<?php }}?>
				</select>
				<select name="league_sn">
					<option value="">리그</option>
		<?php 
			if ( count($TPL_VAR["league_list"]) > 0 ) {
				foreach ( $TPL_VAR["league_list"] as $leagueInfo ) {
					if ( $TPL_VAR["league_sn"] == $leagueInfo['league_sn'] ) $selected = "selected";
					else $selected = "";
					if ( !trim($leagueInfo['alias_name']) ) $league_name = $leagueInfo['league_name'];
					else $league_name = $leagueInfo['alias_name'];
					echo "<option value=\"".$leagueInfo['league_sn']."\" {$selected}>".$league_name."</option>";
				}
			}
		?>
				</select>
				<!-- 기간 필터 -->
				<span class="icon">날짜</span><input name="begin_date" type="text" id="begin_date" class="date" value="<?php echo $TPL_VAR["begin_date"]?>" maxlength="20" onclick="new Calendar().show(this);"/>&nbsp;~
				<input name="end_date" type="text" id="end_date" class="date" value="<?php echo $TPL_VAR["end_date"]?>" maxlength="20" onclick="new Calendar().show(this);" />
					
				<!-- 팀검색, 리그검색 -->
				<select name="filter_team_type">
					<option value="home_team" <?php if($TPL_VAR["filter_team_type"]=="home_team"){?> selected<?php }?>>홈팀</option>
					<option value="away_team" <?php if($TPL_VAR["filter_team_type"]=="away_team"){?> selected<?php }?>>원정팀</option>
				</select>
				<input type="text" size="10" name="filter_team" value="<?php echo $TPL_VAR["filter_team"]?>" class="name">
				<!-- 검색버튼 -->
				<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
				&nbsp;&nbsp;
				<span style="float:right; font-size:15px; margin-right:15px;">구독 : <label id="orderCnt"><?=$TPL_VAR["orderCnt"]?></label> 개</span>
			</form>
		</div>
	</div>
	
	<form id="form1" name="form1" method="post" action="?">
  	<input type="hidden" name="act" value="delete">
		<table cellspacing="1" class="tableStyle_gameList">
			<thead>
	    		<tr>     
	      	        <th> No </th>
					<th>경기일시</th>
					<th>종목</th>
					<th>리그</th>
					<th>매칭리그</th>
					<th colspan="2">승(홈팀)</th>
					<th>무</th>
					<th colspan="2">패(원정팀)</th>
                    <th>설정</th>
	    		</tr>
	 		</thead>
			<tbody>
    <?php 
        if ( $TPL_list_1 ) {
            foreach ( $TPL_VAR["list"] as $TPL_V1) {
                if ( $TPL_V1["user_view_flag"] == 0 ) $addTrStyle = "_notView";
                else $addTrStyle = "";
    ?>
                    <tr class="gameGoing<?=$addTrStyle;?>">
						<td><font color='blue'> <?php echo $TPL_V1["child_sn"]?></font></td>
						<td><?php echo sprintf("%s %s:%s",substr($TPL_V1["gameDate"],5),$TPL_V1["gameHour"],$TPL_V1["gameTime"])?></td>
						<td><?php echo $TPL_V1["sport_name"]?></td>
						<td><a onclick="window.open('/league/popup_edit?league_sn=<?php echo $TPL_V1["league_sn"];?>','','scrollbars=yes,width=600,height=400,left=5,top=0');" href="#"><?php echo $TPL_V1["league_name"]?></a></td>
						<td><?php echo $TPL_V1["league_name"]?></td>
						<td colspan="2">
                            <table width="100%">
                                <tr>
                                    <td>
                            <?php
                                if ( $TPL_V1["total_betting"] > 0 ) {
                                    echo "<font color=\"blue\"><b>".mb_strimwidth($TPL_V1["home_team"],0,20,"..","utf-8")."</b></font>";
                                } else {
                                    echo mb_strimwidth($TPL_V1["home_team"],0,20,"..","utf-8");
                                }
                            ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><span style="color:#3163C9;"><?=number_format($TPL_V1["home_total_betting"],0);?></span></td>
                                </tr>
                            </table>
						</td>
						<td>
                            <table width="100%">
                                <tr>
                                    <td>
                                        VS
                                    </td>
                                </tr>
                                <tr>
                                    <td><span style="color:#3163C9;"><?=number_format($TPL_V1["draw_total_betting"],0);?></span></td>
                                </tr>
                            </table>
						</td>
						<td colspan="2">
                            <table width="100%">
                                <tr>
                                    <td>
                            <?php
                                if ( $TPL_V1["total_betting"] > 0 ) {
                                    echo "<font color=\"blue\"><b>".mb_strimwidth($TPL_V1["away_team"],0,20,"..","utf-8")."</b></font>";
                                } else {
                                    echo mb_strimwidth($TPL_V1["away_team"],0,20,"..","utf-8")."&nbsp;&nbsp;";
                                }
                            ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><span style="color:#3163C9;"><?=number_format($TPL_V1["away_total_betting"],0);?></span></td>
                                </tr>
                            </table>
						</td>
                        <td>
                            <button type="button" id="orderBtn_<?=$TPL_V1['child_sn']?>" <?=($TPL_V1['live'] < 2) ? '' : 'disabled' ?> onclick=orderFixture(<?=$TPL_V1['child_sn']?>)>구독</button>
                            <button type="button" id="cancelBtn_<?=$TPL_V1['child_sn']?>" <?=($TPL_V1['live'] == 2) ? '' : 'disabled' ?> onclick=cancelOrder(<?=$TPL_V1['child_sn']?>)>취소</button>
                        </td>
					</tr>
<?php }}?>
			</tbody>
		</table>
 		
		<div id="pages">
			<?php echo $TPL_VAR["pagelist"]?>
		</div>
	</form>