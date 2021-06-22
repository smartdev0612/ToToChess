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
	
	function changeView_style()
	{
		
	}
</script>
	
	<div id="route">
		<h5>관리자 시스템 - 경기차단관리</h5>
	</div>
	<h3>경기차단</h3>
	
	<div id="search2">
		<form action="?" method="get" name="form2" id="form2">
		<div>
			<!-- 종목 -->
			<span>종목</span>
			<select name="category" onChange="submit();">
			<option value="">종목명</option>
<?php if($TPL_category_list_1){foreach($TPL_VAR["category_list"] as $TPL_V1){?>
				<option value=<?php echo $TPL_V1["name"]?> <?php if($TPL_VAR["category"]==$TPL_V1["name"]){?> selected<?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
			</select>
			
			<!-- 리그 -->
			<span class="icon">리그명</span>
			<input name="username" type="text" class="name" value="<?=$nname?>" maxlength="20" onmouseover="this.focus()"/>
			<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
		</div>
		</form>
	</div>

	<form id="form1" name="form1" method="get" action="?">
		<input type="hidden" name="act" value="del">
		<table cellspacing="1" class="tableStyle_normal add">
			<legend class="blind">등록 경기 목록</legend>
			<thead>
			<tr>
                 <th class="check"><input type="checkbox" name="chkAll" onClick="selectAll()"/></th>
                 <th>번호</th>
                 <th>종목</th>
                 <th>리그명</th>
                 <th>홍팀</th>
                <th>홍배당</th>
                 <th>기준배당</th>
                <th>원정배당</th>
                 <th>원정팀</th>
                 <th>처리</th>
			</tr>
			</thead>
			<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
					<tr>
						<td><input name="y_id[]" type="checkbox" id="y_id" value="<?php echo $TPL_V1["sn"]?>" onclick="javascript:chkRow(this);"/></td>
						<td><?php echo $TPL_V1["sn"]?></td>
						<td><?php echo $TPL_V1["sport_name"]?></td>
						<td><?php echo $TPL_V1["league_name"]?></td>
                        <td><?php echo $TPL_V1["home_team"] ?></td>
                        <td><?php echo $TPL_V1["home_rate"]?></td>
                        <td><?php echo $TPL_V1["draw_rate"]?></td>
                        <td><?php echo $TPL_V1["away_rate"]?></td>
                        <td><?php echo $TPL_V1["away_team"]?></td>
						<td>
							<a href="#" onclick="go_del('/gameBlock/list?act=delete&idx=<?php echo $TPL_V1["sn"]?>');" ><img src="/img/btn_s_del.gif" title="삭제"></a>
						</td>
					 </tr>
<?php }}?>
			</tbody>
		</table>
		<div id="pages2">
			<?php echo $TPL_VAR["pagelist"]?>

		</div>
		<!--<div id="wrap_btn">
			<input type="button" name="open" value="삭  제" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="isChm()"/>
		</div>-->
	</form>