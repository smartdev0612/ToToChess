<?php
$TPL_events_1=empty($TPL_VAR["events"])||!is_array($TPL_VAR["events"])?0:count($TPL_VAR["events"]);?>
<script language="javascript">
	
function check_this(form)
{
    if(form.chk_all.checked){form.chk_all.checked = form.chk_all.checked&0;}
}
function check_all(form)
{
    for(var i=0;i<form.elements.length;i++)
    {
        var e = form.elements[i];
        if((e.name !="chk_all") && (e.type=="checkbox"))
			e.checked = form.chk_all.checked;
    }
}

function onUpload()
	{
		var iCount=0;
		for (i=0;i<document.all.length;i++) 
		{
			if(document.all[i].name=="y_id[]")
			{
				if(document.all[i].checked==true)
				{
					iCount++;
				}
			}
			else if(document.all[i].name=="check_cancel[]")
			{
				if(document.all[i].checked==true)	{document.all[i].value="1";}
			}
		}
		if(iCount==0)
		{
			alert("선택된 경기가 없습니다.");
			return false;
		}
		else
		{
			falg=window.confirm("업로드 하시겠습니까?"); 
			if(falg)
			{
				document.form1.submit();
			}
		}
	}
</script>


<div id="wrap_pop">
	<div id="pop_title">
		<h1>Live(bwin) 실시간 게임업로드</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>
	
	<div class="wrap_search">
		&nbsp;&nbsp; [ 실시간 게임은 해외사이트에서 제공을 받습니다. 리그명은 반드시 해당 사이트의 리그명에 맞춰주세요.] <font color='red'>선택항목</font>을 <input type="button" value="경기올리기" onclick="onUpload()" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
	</div>
</div>

<form id="form1" name="form1" method="post" action="/LiveGame/upload">
	<input type="hidden" name="sort_field" value="<?php echo $TPL_VAR["sort_field"]?>">
	<table cellspacing="1" class="tableStyle_normal">
	<thead>
		<tr>
			<th scope="col" class="check"><input type="checkbox" name="chkAll" title="전체선택" onClick="selectAll()"/></th>
			<th>이벤트 ID</th>
			<th><a href='?sort_field=event_date'>시간</a></th>
			<th>리그 ID</th>
			<th><a href='?sort_field=league_name'>리그명(bwin)</a></th>
			<th>리그명</th>
			<th>홈팀</th>
			<th>원정팀</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_events_1){foreach($TPL_VAR["events"] as $TPL_V1){?>
		<tr>
			<td><input name="y_id[]" type="checkbox" id="y_id" value="<?php echo $TPL_V1["event_id"]?>"  onclick="javascript:chkRow(this);"/></td>
			<td><?php echo $TPL_V1["event_id"]?></td>
			<td><input type='hidden' name='event_date_<?php echo $TPL_V1["event_id"]?>' value='<?php echo $TPL_V1["event_date"]?>'><?php echo $TPL_V1["event_date"]?></td>
			<td><?php echo $TPL_V1["league_id"]?></td>
			<td><?php echo $TPL_V1["league_name"]?></td>
			<td><select name='league_sn_<?php echo $TPL_V1["event_id"]?>'><?php echo $TPL_VAR["options"]?></select>
			<td><input type='text' name='home_team_<?php echo $TPL_V1["event_id"]?>' value='<?php echo $TPL_V1["home_team"]?>'></td>
			<td><input type='text' name='away_team_<?php echo $TPL_V1["event_id"]?>' value='<?php echo $TPL_V1["away_team"]?>'></td>
		</tr>		
<?php }}?>
	</tbody>
	</table>
	
	<div id="pages">
			<?php echo $TPL_VAR["pagelist"]?>

	</div>
</form>

	<div id="wrap_btn">
		<a href="#" onclick="window.close()"><img src="/img/btn_close.gif" title="창닫기"></a>
	</div>
</div>

</body>
</html>