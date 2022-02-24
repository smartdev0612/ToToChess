<script language="JavaScript">
    function This_Check()
    {
        var f = document.resultProcess;
        f.submit();
    }
</script>
</head>
<div id="wrap_pop">

	<div id="pop_title">
		<h1>배팅 수동처리</h1><p><a href="#"><img src="/img/btn_s_close.gif" onclick="self.close();"></a></p>
	</div>

<form name="resultProcess" method="post" action="?mode=edit" enctype="multipart/form-data"> 
	<input type="hidden" name="sn" value="<?php echo $TPL_VAR["sn"]?>">
	<table cellspacing="1" class="tableStyle_membersWrite">
		<tr>
            <th>배팅번호</th>
			<td>
				<?=$TPL_VAR["betting_info"]["betting_no"]?>
			</td>
		</tr>
		<? if ($TPL_VAR["is_ghost"] > 0) { ?>
		<tr>
			<th>배팅방향</th>
			<td>
                <input type="radio" name="select_no" value="1" <?php if($TPL_VAR["betting_info"]["select_no"]==1){?> checked <?php }?>> 홈
                <input type="radio" name="select_no" value="3" <?php if($TPL_VAR["betting_info"]["select_no"]==3){?> checked <?php }?>> 무
                <input type="radio" name="select_no" value="2" <?php if($TPL_VAR["betting_info"]["select_no"]==2){?> checked <?php }?>> 원정
			</td>
		</tr>
		<? } ?>
		<tr>
			<th>결과</th>
			<td>
				<select name="result">
					<? if ($TPL_VAR["is_ghost"] > 0) { ?>
					<option value="0" <?=$TPL_VAR["betting_info"]["result"] == 0 ? "selected" : ""?>>배팅중</option>
					<? } ?>
                    <option value="1" <?=$TPL_VAR["betting_info"]["result"] == 1 ? "selected" : ""?>>당첨</option>
                    <option value="2" <?=$TPL_VAR["betting_info"]["result"] == 2 ? "selected" : ""?>>낙첨</option>
                    <option value="4" <?=$TPL_VAR["betting_info"]["result"] == 4 ? "selected" : ""?>>적특</option>
				</select>
			</td>
		</tr>
	</table>
	<div id="wrap_btn">
		<input type="button" value="적  용" onclick="This_Check()" class="btnStyle1">&nbsp;
        <input type="button" value=" 닫  기 " onclick="self.close();" class="btnStyle2">
	</div>

</form>

</div>