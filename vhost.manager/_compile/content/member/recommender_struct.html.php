<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>document.title = '★메인-추천인구조';</script>
<script>
	function go_del(url)
	{
		if(confirm("정말 삭제하시겠습니까?"))
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

	function apply(mem_sn)
    {
        var recommend_limit = parseInt($('#recommend_limit_'+mem_sn).val());
        var join_recommend_mileage_rate_type = $('#join_recommend_mileage_rate_type_'+mem_sn).val();
        var join_recommend_mileage_rate = $('#join_recommend_mileage_rate_'+mem_sn).val();


        var data = {mem_sn:mem_sn,
            recommend_limit:recommend_limit,
            join_recommend_mileage_rate_type:join_recommend_mileage_rate_type,
            join_recommend_mileage_rate:join_recommend_mileage_rate
        };

        $.ajax({
            url : "/member/saveJoinRecommendRateAjax",
            data : data,
            scriptCharset : "utf-8",
            type : "post", cache : false, async : false, timeout : 5000, scriptCharset : "utf-8", dataType : "json",
            success: function(res) {
                if ( typeof(res) == "object" ) {
                    if(res.ret == 1)
                    {
                        alert("적용 되었습니다.");
                    }
                    else
                    {
                        alert("적용 실패하였습니다.");
                    }
                }
            },
            error: function(xhr,status,error) {
                alert("처리중 오류가 발생 되었습니다. 관리자에게 문의해주세요.");
            }
        });
    }
</script>

<div class="wrap">

	<div id="route">
		<h5>★ 관리자시스템 > 메인 > <b>추천인 구조</b></h5>
	</div>

	<h3>추천인 구조</h3>

	<div id="search">
		<div class="wrap" style="float:right;">
			<form action="?" method="post" name="searchForm" id="searchForm">
                <div>
                    <span class="icon2">날짜</span>
                    <input name="begin_date" type="text" id="begin_date" class="date" value="<?php echo $TPL_VAR["begin_date"]?>" maxlength="20" onclick="new Calendar().show(this);"/>&nbsp;~
                    <input name="end_date" type="text" id="end_date" class="date" value="<?php echo $TPL_VAR["end_date"]?>" maxlength="20" onclick="new Calendar().show(this);" />

                    <!-- 검색버튼 -->
                    <input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
                </div>
            </form>
		</div>
	</div>

	<form id="form1" name="form1" method="post" action="?act=delete_user">
	<table cellspacing="1" class="tableStyle_members" summary="추천인 목록">
	<legend class="blind">추천인 목록</legend>
	<thead>
		<tr>
			<th scope="col">부본사</th>
            <th scope="col">총판</th>
            <th scope="col">추천인</th>
            <th scope="col">추천받은자</th>
            <th scope="col">추천코드</th>
			<th scope="col">이름</th>
			<th scope="col">레벨</th>
			<th scope="col">추천제한(명)</th>
            <th scope="col">총배팅금(S/M)</th>
            <th scope="col">추천인적립 방식</th>
            <th scope="col">추천인적립 비율</th>
            <th scope="col">추천인적립 금액</th>
            <th scope="col">적용</th>
			<th scope="col">처리</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){
$TPL_item_2=empty($TPL_V1["item"])||!is_array($TPL_V1["item"])?0:count($TPL_V1["item"]);?>
			<tr style="background: #ffe4c4;">
				<td>
                    <?php echo $TPL_V1["ttop_id"]?>
                </td>
                <td>
                    <?php echo $TPL_V1["top_id"]?>
                </td>
                <td>
                    <a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V1["mem_sn"]?>',1024,600)"><?php echo $TPL_V1["uid"]?></a>
                </td>
                <td>
                </td>
                <td>
                    <?php echo $TPL_V1["uid"]?>
                </td>
                <td>
                    <?php echo $TPL_V1["nick"]?>
                </td>
                <td>
                    <?php echo $TPL_V1["lev_name"]?>
                </td>
                <td>
                    <input type="text" id="recommend_limit_<?php echo $TPL_V1["mem_sn"]?>" name="recommend_limit_<?php echo $TPL_V1["mem_sn"]?>"
                           value="<?php echo $TPL_V1["recommend_limit"]?>" style="width: 50px;text-align: center;">
                </td>
				<td>
                    <?php echo number_format($TPL_V1["total_betting_sport"],0)?> / <?php echo number_format($TPL_V1["total_betting_mini"],0)?>
				</td>
                <td>
                    <select id="join_recommend_mileage_rate_type_<?php echo $TPL_V1["mem_sn"]?>" name="join_recommend_mileage_rate_type_<?php echo $TPL_V1["mem_sn"]?>" style="width:95px;">
                        <option value="lose" <?php if($TPL_V1["join_recommend_mileage_rate_type"]=="lose") echo "selected";?>>낙첨금</option>
                        <option value="betting" <?php if($TPL_V1["join_recommend_mileage_rate_type"]=="betting") echo "selected";?>>배팅금</option>
                    </select>
                </td>
                <td>
                    <input type="text" id="join_recommend_mileage_rate_<?php echo $TPL_V1["mem_sn"]?>" name="join_recommend_mileage_rate_<?php echo $TPL_V1["mem_sn"]?>"
                           value="<?php echo $TPL_V1["join_recommend_mileage_rate"]?>" style="width: 50px;text-align: center;">%
                </td>
                <td>
                    <?php echo number_format($TPL_V1["join_mileage_amount"],0)?>
                </td>
				<td>
                    <input type="button" name="open" value="적용" onclick="apply('<?php echo $TPL_V1["mem_sn"]?>', 0, 0);return false;">
                </td>
                <td>
                    <?php if($TPL_V1["is_recommender"]==1){?>
                        <input type="button" name="open" value="비허용" onclick="window.location.href='?act=stop&sn=<?php echo $TPL_V1["mem_sn"]?>&send=0'">
                    <?php }else{?>
                        <input type="button" name="open" value="허용" onclick="window.location.href='?act=stop&sn=<?php echo $TPL_V1["mem_sn"]?>&send=1'">
                    <?php }?>&nbsp;
                </td>
			</tr>			
			

<?php if($TPL_item_2){ foreach($TPL_V1["item"] as $TPL_V2){ ?>
        <tr>
            <td>
                <?php echo $TPL_V2["ttop_id"]?>
            </td>
            <td>
                <?php echo $TPL_V2["top_id"]?>
            </td>
            <td>

            </td>
            <td>
                <a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V2["mem_sn"]?>',1024,600)"><?php echo $TPL_V2["uid"]?></a>
            </td>
            <td>
                <?php echo $TPL_V2["uid"]?>
            </td>
            <td>
                <?php echo $TPL_V2["nick"]?>
            </td>
            <td>
                <?php echo $TPL_V2["lev_name"]?>
            </td>
            <td>
                <input type="text" id="recommend_limit_<?php echo $TPL_V2["mem_sn"]?>" name="recommend_limit_<?php echo $TPL_V2["mem_sn"]?>"
                       value="<?php echo $TPL_V2["recommend_limit"]?>" style="width: 50px;text-align: center;">
            </td>
            <td>
                <?php echo number_format($TPL_V2["total_betting_sport"],0)?> / <?php echo number_format($TPL_V2["total_betting_mini"],0)?>
            </td>
            <td>
                <select id="join_recommend_mileage_rate_type_<?php echo $TPL_V2["mem_sn"]?>" name="join_recommend_mileage_rate_type_<?php echo $TPL_V2["mem_sn"]?>" style="width:95px;">
                    <option value="lose" <?php if($TPL_V2["join_recommend_mileage_rate_type"]=="lose") echo "selected";?>>낙첨금</option>
                    <option value="betting" <?php if($TPL_V2["join_recommend_mileage_rate_type"]=="betting") echo "selected";?>>배팅금</option>
                </select>
            </td>
            <td>
                <input type="text" id="join_recommend_mileage_rate_<?php echo $TPL_V2["mem_sn"]?>" name="join_recommend_mileage_rate_<?php echo $TPL_V2["mem_sn"]?>"
                       value="<?php echo $TPL_V2["join_recommend_mileage_rate"]?>" style="width: 50px;text-align: center;">%
            </td>
            <td>
                <?php echo number_format($TPL_V2["join_mileage_amount"],0)?>
            </td>
            <td>
                <input type="button" name="open" value="적용" onclick="apply('<?php echo $TPL_V2["mem_sn"]?>', 0, 0);return false;">
            </td>
            <td>
                <?php if($TPL_V2["is_recommender"]==1){?>
                    <input type="button" name="open" value="비허용" onclick="window.location.href='?act=stop&sn=<?php echo $TPL_V2["mem_sn"]?>&send=0'">
                <?php }else{?>
                    <input type="button" name="open" value="허용" onclick="window.location.href='?act=stop&sn=<?php echo $TPL_V2["mem_sn"]?>&send=1'">
                <?php }?>&nbsp;
            </td>
        </tr>
    <?php }}?>

<?php }}?>
	
	</tbody>
	</table>
</form>

</div>