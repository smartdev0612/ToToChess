<script>
	function confirmOk()
	{
		fm = document.frm;
    if(fm.mem_join.value=="")
    {
			alert("회원가입시 지급포인트 금액 입력해 주세요.");
			fm.mem_join.focus();	
		}
		else if (fm.folder_bouns3.value=="") 
		{
			alert("3폴더 값을 입력해 주세요.");
			fm.folder_bouns3.value = "0"
			fm.folder_bouns3.focus();
		
		}
		else if (fm.folder_bouns4.value=="")
		{
			alert("4폴더 값을 입력해 주세요.");
			fm.folder_bouns4.value = "0"
			fm.folder_bouns4.focus();
		
		}
		else if (fm.folder_bouns5.value=="") 
		{
			alert("5폴더 값을 입력해 주세요.");
			fm.folder_bouns5.value = "0"
			fm.folder_bouns5.focus();
		
		}
		else if (fm.folder_bouns6.value=="") 
		{
			alert("6폴더 값을 입력해 주세요.");
			fm.folder_bouns6.value = "0"
			fm.folder_bouns6.focus();
		
		}
		else if (fm.folder_bouns7.value=="")
		{
			alert("7폴더 값을 입력해 주세요.");
			fm.folder_bouns7.value = "0"
			fm.folder_bouns7.focus();
		
		}
		else if (fm.folder_bouns8.value=="")
		{
			alert("8폴더 값을 입력해 주세요.");
			fm.folder_bouns8.value = "0"
			fm.folder_bouns8.focus();
		}
		else if (fm.folder_bouns9.value=="") 
		{
			alert("9폴더 값을 입력해 주세요.");
			fm.folder_bouns9.value = "0"
			fm.folder_bouns9.focus();
		}
		else if (fm.folder_bouns10.value=="")
		{
			alert("10폴더 값을 입력해 주세요.");
			fm.folder_bouns10.value = "0"
			fm.folder_bouns10.focus();
		}
		else if (fm.reply_point.value=="")
		{
			alert("댓글 포인트를 입력해 주세요.");
			fm.reply_point.focus();
		}
		else if (fm.reply_limit.value=="")
		{
			alert("댓글 제한 횟수를 입력해 주세요.");
			fm.reply_limit.focus();
		}
		
		else if (fm.betting_board_write_point.value=="")
		{
			alert("배팅게시물 작성 포인트를 입력해 주세요.");
			fm.betting_board_write_point.focus();
		}
		else if (fm.betting_board_write_limit.value=="")
		{
			alert("배팅게시물 작성 제한 횟수를 입력해 주세요.");
			fm.betting_board_write_limit.focus();
		}
		
		else if (fm.board_write_point.value=="")
		{
			alert("게시물 작성 포인트를 입력해 주세요.");
			fm.board_write_point.focus();
		}
		else if (fm.board_write_limit.value=="")
		{
			alert("게시물 작성 제한 횟수를 입력해 주세요.");
			fm.board_write_limit.focus();
		}
        else if (fm.check_money.value=="")
        {
            alert("출석체크를 위한 충전금액을 입력해 주세요.");
            fm.check_money.focus();
        }
        else if (fm.day_charge_bonus.value=="")
        {
            alert("당일출석체크포인트 입력해 주세요.");
            fm.day_charge_bonus.focus();
        }
        else if (fm.week_charge_bonus.value=="")
        {
            alert("일주일출석체크포인트 입력해 주세요.");
            fm.week_charge_bonus.focus();
        }
        else if (fm.month_charge_bonus.value=="")
        {
            alert("한달출석체크포인트 입력해 주세요.");
            fm.month_charge_bonus.focus();
        }
		else
		{
			fm.action = "/config/pointSaveProcess";
			fm.submit();	
		}
	}
</script>

<div class="wrap">

	<div id="route">
		<h5>관리자 시스템 > 시스템 관리 > <b>포인트 설정</b></h5>
	</div>

	<h3>포인트 설정</h3>

	<form  method="post"  name="frm">	
		<table cellspacing="1" class="tableStyle_membersWrite" summary="포인트 설정">
			<legend class="blind">포인트 설정</legend>
			<tr>
				<th>잭팟금/배당(낙첨)</th>
				<td><input type="text" class="w120" name="jackpot_sum_money" onKeyUp="value=value.replace(/[^\d]/g,'')" value="<?php echo $TPL_VAR["item"]["jackpot_sum_money"]?>" size="10" />&nbsp;&nbsp;&nbsp; <input type="text" class="w60" name="jackpot_give_rate" value="<?php echo $TPL_VAR["item"]["jackpot_give_rate"]?>" />%</td>
			</tr>
			<tr>
				<th>회원가입시</th>
				<td><input type="text" class="w120" name="mem_join"  size="10" value="<?php echo $TPL_VAR["item"]["mem_join"]?>" onKeyUp="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData
			('text',clipboardData.getData('text').replace(/[^\d]/g,''))" /><span class="infoCopy">회원가입 축하금</span></td>
			</tr	>
			<!--
			<tr>
				<th>추천인 지급</th>
				<td><input type="text" class="w120" name="mem_joiner"  size="10" value="<?php echo $TPL_VAR["item"]["mem_joiner"]?>" onKeyUp="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData
			('text',clipboardData.getData('text').replace(/[^\d]/g,''))" /> <!--<input type="checkbox"><span class="infoCopy">추천인 기입자도 포인트 지급</span></td>
			</tr>
			-->
			<tr>
				<th>폴더보너스
<?php if($TPL_VAR["item"]["chk_folder"]==1){?>
						<input type="checkbox" name="chk_folder" value="1" checked >
<?php }else{?>
						<input type="checkbox" name="chk_folder" value="1" >
<?php }?>	
				</th>
				<td>
					3폴더 :<input type="text" class="w20" name="folder_bouns3" size="2" value="<?php echo $TPL_VAR["item"]["folder_bouns3"]?>" maxlength="2" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;" />%
					4폴더 :<input type="text" class="w20" name="folder_bouns4" size="2" value="<?php echo $TPL_VAR["item"]["folder_bouns4"]?>" maxlength="2" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;" />%
					5폴더 :<input type="text" class="w20" name="folder_bouns5" size="2" value="<?php echo $TPL_VAR["item"]["folder_bouns5"]?>" maxlength="2" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;" />%
					6폴더 :<input type="text" class="w20" name="folder_bouns6" size="2" value="<?php echo $TPL_VAR["item"]["folder_bouns6"]?>" maxlength="2" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;" />%
					7폴더 :<input type="text" class="w20" name="folder_bouns7" size="2" value="<?php echo $TPL_VAR["item"]["folder_bouns7"]?>" maxlength="2" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;" />%
					8폴더 :<input type="text" class="w20" name="folder_bouns8" size="2" value="<?php echo $TPL_VAR["item"]["folder_bouns8"]?>" maxlength="2" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;" />%
					9폴더 :<input type="text" class="w20" name="folder_bouns9" size="2" value="<?php echo $TPL_VAR["item"]["folder_bouns9"]?>" maxlength="2" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;" />%
					10폴더 :<input type="text" class="w20" name="folder_bouns10" size="2" value="<?php echo $TPL_VAR["item"]["folder_bouns10"]?>" maxlength="2" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;" />%
				</td>
			</tr> 
			<!--
			<tr>
				<th> 가입 추천인 배당</th>
				<td> 
					1차 추천인 : <input type="text" class="w20" name="join_1st_rate" value="<?php echo $TPL_VAR["item"]["join_recommend_1st_rate"]?>" maxlength="2" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;" />(%)
					2차 추천인 : <input type="text" class="w20" name="join_2nd_rate" value="<?php echo $TPL_VAR["item"]["join_recommend_2nd_rate"]?>" maxlength="2" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;" />(%)
					3차 추천인 : <input type="text" class="w20" name="join_3rd_rate" value="<?php echo $TPL_VAR["item"]["join_recommend_3rd_rate"]?>" maxlength="2" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;" />(%)
				</td>
			</tr>
			-->
			
			<tr>
				<th> 댓글 작성</th>
				<td> 
					<input type="text" name="reply_point" size="3" value="<?php echo $TPL_VAR["item"]["reply_point"]?>" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"> 포인트 적립 &nbsp;&nbsp;&nbsp; 
					1일 <input type="text" name="reply_limit" size="3" value="<?php echo $TPL_VAR["item"]["reply_limit"]?>" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"> 회 제한
				</td>
			</tr>
			
			<tr>
				<th> 게시글 작성</th>
				<td> 
					<input type="text" name="board_write_point" size="3" value="<?php echo $TPL_VAR["item"]["board_write_point"]?>" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"> 포인트 적립 &nbsp;&nbsp;&nbsp; 
					1일 <input type="text" name="board_write_limit" size="3" value="<?php echo $TPL_VAR["item"]["board_write_limit"]?>" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"> 회 제한
				</td>
			</tr>
			
			<tr>
				<th> 배팅첨부게시글 작성</th>
				<td> 
					<input type="text" name="betting_board_write_point" size="3" value="<?php echo $TPL_VAR["item"]["betting_board_write_point"]?>" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"> 포인트 적립 &nbsp;&nbsp;&nbsp; 
					1일 <input type="text" name="betting_board_write_limit" size="3" value="<?php echo $TPL_VAR["item"]["betting_board_write_limit"]?>" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"> 회 제한
				</td>
			</tr>
            <tr>
                <th> 출석체크</th>
                <td>
                    출석체크를 위한 충전금액:<input type="text" name="check_money" size="3" value="<?php echo $TPL_VAR["item"]["check_money"]?>" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"> 원,
                    일출석체크<input type="text" name="day_charge_bonus" size="3" value="<?php echo $TPL_VAR["item"]["day_charge_bonus"]?>" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"> 포인트,
                    주출석체크<input type="text" name="week_charge_bonus" size="3" value="<?php echo $TPL_VAR["item"]["week_charge_bonus"]?>" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"> 포인트,
                    월출석체크<input type="text" name="month_charge_bonus" size="3" value="<?php echo $TPL_VAR["item"]["month_charge_bonus"]?>" onkeypress="javascript:pressNumberCheck();" style="IME-MODE: disabled;"> 포인트
                </td>
            </tr>
		</table>

		<div id="wrap_btn">
			<input type="button" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'" value="저  장" onclick="confirmOk();"/>
		</div>
	</form>
</div>