<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>document.title = '★메인-파트너구조';</script>
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

	function apply(rec_sn, parent_sport_rate, parent_minigame_rate)
    {
        var sport_rate = parseInt($('#sport_rate_'+rec_sn).val());
        var mini_rate = parseInt($('#mini_rate_'+rec_sn).val());
        if(parent_sport_rate == 0 && parent_minigame_rate == 0)
        {

        } else {
            if(sport_rate > parent_sport_rate)
            {
                alert("스포츠낙첨비율을 "+parent_sport_rate+"%이하로 설정하세요.");
                $('#sport_rate_'+rec_sn).focus();
                return;
            }

            if(mini_rate > parent_minigame_rate)
            {
                alert("미니게임 롤링비율을 "+parent_minigame_rate+"%이하로 설정하세요.");
                $('#mini_rate_'+rec_sn).focus();
                return;
            }
        }

        var data = {rec_sn:rec_sn, sport_rate:sport_rate, mini_rate:mini_rate};

        $.ajax({
            url : "/partner/saveRollingRateAjax",
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
		<h5>★ 관리자시스템 > 메인 > <b>파트너 구조</b></h5>
	</div>

	<h3>파트너 구조</h3>

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
	<table cellspacing="1" class="tableStyle_members" summary="파트너 목록">
	<legend class="blind">파트너 목록</legend>
	<thead>
		<tr>
			<th scope="col">부본사</th>
            <th scope="col">총판</th>
			<th scope="col">이름</th>
			<th scope="col">회원수</th>
			<th scope="col">정산기준</th>
			<th scope="col" >정산비율</th>
            <th scope="col">입금금액</th>
            <th scope="col">출금금액</th>
            <th scope="col">입-출수익</th>
            <th scope="col">총배팅금(S/M)</th>
            <th scope="col">S낙첨적립금</th>
            <th scope="col">M롤링금</th>
            <th scope="col">S낙첨+M롤링</th>
			<th scope="col">상태</th>
			<th scope="col">처리</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){
$TPL_item_2=empty($TPL_V1["item"])||!is_array($TPL_V1["item"])?0:count($TPL_V1["item"]);?>
<?php
	if ( $TPL_V1["rec_tex_type"] == "Swin_Mbet" ) {
		$tex_type = "스낙+미롤";
	} else if ( $TPL_V1["rec_tex_type"] == "Sbet_Mlose" ) {
		$tex_type = "S배팅+M낙첨";
	} else if ( $TPL_V1["rec_tex_type"] == "in" ) {
		$tex_type = "입금";
	} else if ( $TPL_V1["rec_tex_type"] == "inout" ) {
		$tex_type = "입금-출금";
	} else if ( $TPL_V1["rec_tex_type"] == "betting" ) {
		$tex_type = "배팅금(미니게임제외)";
	} else if ( $TPL_V1["rec_tex_type"] == "betting_m" ) {
		$tex_type = "배팅금(미니게임포함)";
	} else if ( $TPL_V1["rec_tex_type"] == "fail" ) {
		$tex_type = "낙첨금(미니게임제외)";
	} else if ( $TPL_V1["rec_tex_type"] == "fail_m" ) {
		$tex_type = "낙첨금(미니게임포함)";
	}
?>
			<tr>
				<td>
                    <a href="javascript:open_window('/partner/memberDetailsTop?idx=<?php echo $TPL_V1["Idx"]?>',640,440)"><?php echo $TPL_V1["rec_id"]?></a>
                </td>
                <td>
                </td>
				<td onclick="toggle('d_<?php echo $TPL_V1["Idx"]?>')"><?php echo $TPL_V1["rec_name"]?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["Idx"]?>')"><?php echo $TPL_V1["member_count"]?></td>
				<!--<td onclick="toggle('d_<?php /*echo $TPL_V1["Idx"]*/?>')"><?php /*echo $TPL_V1["charge_count"]*/?></td>-->
                <td><?php echo $tex_type;?></td>
                <td>
                    <?php
                    $display_flag = "";
                    if($TPL_V1['rec_tex_type'] == 'Swin_Mbet' or $TPL_V1['rec_tex_type'] == 'Sbet_Mlose')
                    {
                        //echo $TPL_V1["rec_rate_sport"].'% /'. $TPL_V1["rec_rate_minigame"]."%";
                    } else {
                        //echo $TPL_V1["rec_rate_sport"].'%';
                        $display_flag = 'none';
                    }
                    ?>
                    <input type="text" id="sport_rate_<?php echo $TPL_V1["Idx"]?>" name="sport_rate_<?php echo $TPL_V1["Idx"]?>"
                           value="<?php echo $TPL_V1["rec_rate_sport"]?>" style="width: 30px;text-align: center;"> % <span style="display: <?php echo $display_flag;?>">/</span>
                    <input type="text" id="mini_rate_<?php echo $TPL_V1["Idx"]?>" name="mini_rate_<?php echo $TPL_V1["Idx"]?>"
                           value="<?php echo $TPL_V1["rec_rate_minigame"]?>" style="width: 30px;text-align: center;display: <?php echo $display_flag;?>"> <span style="display: <?php echo $display_flag;?>">%</span>
                </td>
				<td onclick="toggle('d_<?php echo $TPL_V1["Idx"]?>')"><?php echo number_format($TPL_V1["charge_sum"],0)?></td>
				<td onclick="toggle('d_<?php echo $TPL_V1["Idx"]?>')"><?php echo number_format($TPL_V1["exchange_sum"],0)?></td>
                <td><?php echo number_format($TPL_V1["charge_sum"] - $TPL_V1["exchange_sum"],0)?></td>
				<td>
                    <?php echo number_format($TPL_V1["total_betting_sport"],0)?> / <?php echo number_format($TPL_V1["total_betting_mini"],0)?>
				</td>
                <td>
                    <?php
                    if($TPL_V1['rec_tex_type'] == 'Swin_Mbet') {
                        echo number_format($TPL_V1["total_s_lose"], 0);
                    } else {
                        echo '0';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if($TPL_V1['rec_tex_type'] == 'Swin_Mbet') {
                        echo number_format($TPL_V1["total_m_rolling"], 0);
                    } else {
                        echo "0";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if($TPL_V1['rec_tex_type'] == 'Swin_Mbet') {
                        echo number_format($TPL_V1["total_s_lose"] + $TPL_V1["total_m_rolling"], 0);
                    } else {
                        echo "0";
                    }
                    ?>
                </td>
				<td>
<?php if($TPL_V1["status"]==0){?><font color='red'>정지</font>
<?php }elseif($TPL_V1["status"]==1){?>정상
<?php }elseif($TPL_V1["status"]==2){?>신청
<?php }?>
				</td>
				<td>
                    <input type="button" name="open" value="적용" onclick="apply('<?php echo $TPL_V1["Idx"]?>', 0, 0);return false;">
                    <?php if($TPL_V1["status"]==1){?>
                        <input type="button" name="open" value="차단" onclick="window.location.href='?act=stop&id=<?php echo $TPL_V1["rec_id"]?>&send=0'">
                    <?php }else{?>
                        <input type="button" name="open" value="허용" onclick="window.location.href='?act=stop&id=<?php echo $TPL_V1["rec_id"]?>&send=1'">
                    <?php }?>&nbsp;
                </td>
			</tr>			
			

<?php if($TPL_item_2){
    foreach($TPL_V1["item"] as $TPL_V2){
        if ( $TPL_V2["rec_tex_type"] == "Swin_Mbet" ) {
            $tex_type = "스낙+미롤";
        } else if ( $TPL_V2["rec_tex_type"] == "Sbet_Mlose" ) {
            $tex_type = "S배팅+M낙첨";
        } else if ( $TPL_V2["rec_tex_type"] == "in" ) {
            $tex_type = "입금";
        } else if ( $TPL_V2["rec_tex_type"] == "inout" ) {
            $tex_type = "입금-출금";
        } else if ( $TPL_V2["rec_tex_type"] == "betting" ) {
            $tex_type = "배팅금(미니게임제외)";
        } else if ( $TPL_V2["rec_tex_type"] == "betting_m" ) {
            $tex_type = "배팅금(미니게임포함)";
        } else if ( $TPL_V2["rec_tex_type"] == "fail" ) {
            $tex_type = "낙첨금(미니게임제외)";
        } else if ( $TPL_V2["rec_tex_type"] == "fail_m" ) {
            $tex_type = "낙첨금(미니게임포함)";
        }
    ?>
        <tr>
            <td>
            </td>
            <td>
                <a href="javascript:open_window('/partner/memberDetails?idx=<?php echo $TPL_V2["Idx"]?>',640,440)"><?php echo $TPL_V2["rec_id"]?></a>
            </td>
            <td onclick="toggle('d_<?php echo $TPL_V2["Idx"]?>')"><?php echo $TPL_V2["rec_name"]?></td>
            <td onclick="toggle('d_<?php echo $TPL_V2["Idx"]?>')"><?php echo $TPL_V2["member_count"]?></td>
            <!--<td onclick="toggle('d_<?php /*echo $TPL_V1["Idx"]*/?>')"><?php /*echo $TPL_V1["charge_count"]*/?></td>-->
            <td><?php echo $tex_type;?></td>
            <td>
                <?php
                $display_flag = "";
                if($TPL_V2['rec_tex_type'] == 'Swin_Mbet' or $TPL_V2['rec_tex_type'] == 'Sbet_Mlose')
                {
                    //echo $TPL_V1["rec_rate_sport"].'% /'. $TPL_V1["rec_rate_minigame"]."%";
                } else {
                    //echo $TPL_V1["rec_rate_sport"].'%';
                    $display_flag = 'none';
                }
                ?>
                <input type="text" id="sport_rate_<?php echo $TPL_V2["Idx"]?>" name="sport_rate_<?php echo $TPL_V2["Idx"]?>"
                       value="<?php echo $TPL_V2["rec_rate_sport"]?>" style="width: 30px;text-align: center;"> % <span style="display: <?php echo $display_flag;?>">/</span>
                <input type="text" id="mini_rate_<?php echo $TPL_V2["Idx"]?>" name="mini_rate_<?php echo $TPL_V2["Idx"]?>"
                       value="<?php echo $TPL_V2["rec_rate_minigame"]?>" style="width: 30px;text-align: center;display: <?php echo $display_flag;?>"> <span style="display: <?php echo $display_flag;?>">%</span>
            </td>
            <td onclick="toggle('d_<?php echo $TPL_V2["Idx"]?>')"><?php echo number_format($TPL_V2["charge_sum"],0)?></td>
            <td onclick="toggle('d_<?php echo $TPL_V2["Idx"]?>')"><?php echo number_format($TPL_V2["exchange_sum"],0)?></td>
            <td><?php echo number_format($TPL_V2["charge_sum"] - $TPL_V2["exchange_sum"],0)?></td>
            <td>
                <?php echo number_format($TPL_V2["total_betting_sport"],0)?> / <?php echo number_format($TPL_V2["total_betting_mini"],0)?>
            </td>
            <td>
                <?php
                    if($TPL_V2['rec_tex_type'] == 'Swin_Mbet') {
                        echo number_format($TPL_V2["total_s_lose"], 0);
                    } else {
                        echo '0';
                    }
                ?>
            </td>
            <td>
                <?php
                    if($TPL_V2['rec_tex_type'] == 'Swin_Mbet') {
                        echo number_format($TPL_V2["total_m_rolling"], 0);
                    } else {
                        echo "0";
                    }
                ?>
            </td>
            <td>
                <?php
                if($TPL_V2['rec_tex_type'] == 'Swin_Mbet') {
                    echo number_format($TPL_V2["total_s_lose"] + $TPL_V2["total_m_rolling"], 0);
                } else {
                    echo "0";
                }
                ?>
            </td>
            <td>
                <?php if($TPL_V2["status"]==0){?><font color='red'>정지</font>
                <?php }elseif($TPL_V2["status"]==1){?>정상
                <?php }elseif($TPL_V2["status"]==2){?>신청
                <?php }?>
            </td>
            <td>
                <input type="button" name="open" value="적용" onclick="apply('<?php echo $TPL_V2["Idx"]?>', <?php echo $TPL_V1["rec_rate_sport"]?>, <?php echo $TPL_V1["rec_rate_minigame"]?>);return false;">
                <?php if($TPL_V2["status"]==1){?>
                    <input type="button" name="open" value="차단" onclick="window.location.href='?act=stop&id=<?php echo $TPL_V2["rec_id"]?>&send=0'">
                <?php }else{?>
                    <input type="button" name="open" value="허용" onclick="window.location.href='?act=stop&id=<?php echo $TPL_V2["rec_id"]?>&send=1'">
                <?php }?>&nbsp;
            </td>
        </tr>
    <?php }}?>

<?php }}?>
	
	</tbody>
	</table>
</form>

</div>