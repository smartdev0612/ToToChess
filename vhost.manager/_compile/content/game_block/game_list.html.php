<?php
$TPL_category_list_1=empty($TPL_VAR["category_list"])||!is_array($TPL_VAR["category_list"])?0:count($TPL_VAR["category_list"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>
	function go_del(url)
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
	
	function blockFixture(child_sn) {
        $("#blockBtn_" + child_sn).prop('disabled', true);
        $("#cancelBtn_" + child_sn).prop('disabled', false);
        $.ajax({
            url: "/GameBlock/blockFixture",
            type: "GET",
            data: {
                "child_sn": child_sn
            },
            success: function(res){ 
				//alert(res);
                var json = JSON.parse(res);
				if(json.status == 0) {
					$("#blockBtn_" + child_sn).prop('disabled', false);
       				$("#cancelBtn_" + child_sn).prop('disabled', true);
				}
				alert(json.msg);
            }
        });
    }

    function cancelBlock(child_sn) {
        $("#blockBtn_" + child_sn).prop('disabled', false);
        $("#cancelBtn_" + child_sn).prop('disabled', true);
        $.ajax({
            url: "/GameBlock/cancelBlock",
            type: "GET",
            data: {
                "child_sn": child_sn
            },
            success: function(res){ 
                var json = JSON.parse(res);
                if(json.status == 0) {
                    $("#blockBtn_" + child_sn).prop('disabled', true);
                    $("#cancelBtn_" + child_sn).prop('disabled', false);
                }
                alert(json.msg);
            }
        });
    }
</script>
	
	<div id="route">
		<h5>관리자 시스템 - 경기차단관리</h5>
	</div>
	<h3>경기차단</h3>
	
	<div id="search">
        <div class="wrap_search">
            <form action="/gameBlock/gamelist" method="get" name="form" id="form">
                <div>
                    <!-- 리그 -->
                    <span class="icon">리그명</span>
                    <input name="leagueName" type="text" class="name" value="<?=$TPL_VAR["leagueName"]?>" maxlength="20" onmouseover="this.focus()"/>

                    <span class="icon">팀명</span>
                    <input name="teamName" type="text" class="name" value="<?=$TPL_VAR["teamName"]?>" maxlength="20" onmouseover="this.focus()"/>

                    <input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
                </div>
            </form>
        </div>
	</div>

	<form id="form" name="form" method="get" action="?">
		<input type="hidden" name="act" value="del">
		<table cellspacing="1" class="tableStyle_gameList">
			<legend class="blind">등록 경기 목록</legend>
			<thead>
			<tr>
                 <th>번호</th>
                 <th>종목</th>
                 <th>시작시간</th>
                 <th>리그명</th>
                 <th>홍팀</th>
                 <th>원정팀</th>
                 <th>처리</th>
			</tr>
			</thead>
			<tbody>
                <?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
					<tr>
						<td><?php echo $TPL_V1["sn"]?></td>
						<td><?php echo $TPL_V1["sport_name"]?></td>
                        <td><?php echo $TPL_V1["gameDate"] . " " . $TPL_V1["gameHour"] . ":" . $TPL_V1["gameTime"]?></td>
						<td><?php echo $TPL_V1["notice"]?></td>
                        <td><?php echo $TPL_V1["home_team"] ?></td>
                        <td><?php echo $TPL_V1["away_team"]?></td>
						<td>
                            <button type="button" id="blockBtn_<?=$TPL_V1['sn']?>" <?=($TPL_V1['block'] == 0) ? '' : 'disabled' ?> onclick=blockFixture(<?=$TPL_V1['sn']?>)>차단</button>
                            <button type="button" id="cancelBtn_<?=$TPL_V1['sn']?>" <?=($TPL_V1['block'] > 0) ? '' : 'disabled' ?> onclick=cancelBlock(<?=$TPL_V1['sn']?>)>취소</button>
						</td>
					 </tr>
                <?php }}?>
			</tbody>
		</table>
		<div id="pages">
			<?php echo $TPL_VAR["pagelist"]?>
		</div>
		<!--<div id="wrap_btn">
			<input type="button" name="open" value="삭  제" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="isChm()"/>
		</div>-->
	</form>