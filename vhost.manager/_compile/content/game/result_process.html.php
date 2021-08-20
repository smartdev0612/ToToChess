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
			<th>결과</th>
			<td>
				<select name="result">
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