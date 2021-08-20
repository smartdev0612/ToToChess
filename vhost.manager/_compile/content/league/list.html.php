<?php
$TPL_category_list_1=empty($TPL_VAR["category_list"])||!is_array($TPL_VAR["category_list"]) ? 0 : count($TPL_VAR["category_list"]);
$TPL_nation_list_1=empty($TPL_VAR["nation_list"])||!is_array($TPL_VAR["nation_list"]) ? 0 : count($TPL_VAR["nation_list"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"]) ? 0 : count($TPL_VAR["list"]);?>
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
		<h5>관리자 시스템 - 리그관리</h5>
	</div>
	<h3>리그관리</h3>

	<div id="search2" style="width:100%;">
		<form action="?" method="get" name="form2" id="form2">
		<div>
			<!-- 종목 -->
			<span>종목</span>
			<select name="category">
				<option value="">종목명</option>
<?php if($TPL_category_list_1){foreach($TPL_VAR["category_list"] as $TPL_V1){?>
				<option value="<?php echo $TPL_V1["name"]?>" <?php if($TPL_VAR["category"]==$TPL_V1["name"]){?> selected<?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
			</select>

			<!-- 국가 -->
			<span>국가</span>
			<select name="nation_sn">
				<option value="">국가명</option>
<?php if($TPL_nation_list_1){foreach($TPL_VAR["nation_list"] as $TPL_V1){?>
				<option value="<?php echo $TPL_V1["sn"]?>" <?php if($TPL_VAR["nation_sn"]==$TPL_V1["sn"]){?> selected<?php }?>><?php echo $TPL_V1["name"]?></option>
<?php }}?>
			</select>
			
			<!-- 리그 -->
			<span class="icon">리그명</span>
			<input name="league_name" type="text" class="name" value="<?=$TPL_VAR["league_name"]?>" maxlength="20" onmouseover="this.focus()"/>
			<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
		</div>
		</form>
	</div>

	<form id="form1" name="form1" method="get" action="?">
		<input type="hidden" name="act" value="del">
		<table cellspacing="1" class="tableStyle_normal">
			<legend class="blind">등록 리그 목록</legend>
			<thead>
			<tr>
				<th class="check"><input type="checkbox" name="chkAll" onClick="selectAll()"/></th>
				<th>번호</th>
				<th>리그이미지</th>
				<th>종목</th>
				<th>국가</th>
				<th>리그명(국문)</th>
				<th>리그명(영문)</th>
				<th>스타일</th>
				<th>매칭 리그명</th>
				<th>사용여부</th>
				<th>처리</th>
			</tr>
			</thead>
			<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
					<tr>
						<td><input name="y_id[]" type="checkbox" id="y_id" value="<?php echo $TPL_V1["lsports_league_sn"]?>" onclick="javascript:chkRow(this);"/></td>
						<td><?php echo $TPL_V1["lsports_league_sn"]?></td>
						<td title="<?php echo $TPL_V1["name"]?>"><img src="<?php echo $TPL_V1["lg_img"]?>" border="0" width="40" height="30"></td>
						<td><?php echo $TPL_V1["kind"]?></td>
						<td><?php echo $TPL_V1["nation_name"]?></td>
						<td><?php echo $TPL_V1["name"]?></td>
						<td><?php echo $TPL_V1["name_en"]?></td>
						<td>
<?php if($TPL_V1["view_style"]=='0'){?>초록색
<?php }elseif($TPL_V1["view_style"]=='1'){?>형광색
<?php }elseif($TPL_V1["view_style"]=='2'){?>하늘색
<?php }elseif($TPL_V1["view_style"]=='5'){?>TOP경기
<?php }elseif($TPL_V1["view_style"]=='10'){?>링크리그
<?php }else{?>일반<?php }?>
						</td>
						<td><?php echo $TPL_V1["alias_name"]?></td>
						<td>
							<?=$TPL_V1["is_use"] == 0 ? "미사용" : "사용"?>
						</td>
						<td>
							<a href="#" onclick="window.open('/league/popup_edit?league_sn=<?php echo $TPL_V1["lsports_league_sn"]?>','','scrollbars=yes,width=600,height=400,left=5,top=0');"><img src="/img/btn_s_modify.gif" title="수정"></a>
							<a href="#" onclick="go_del('/league/list?act=delete&idx=<?php echo $TPL_V1["lsports_league_sn"]?>');" ><img src="/img/btn_s_del.gif" title="삭제"></a>
						</td>
					 </tr>
<?php }}?>
			</tbody>
		</table>
		<div id="pages2">
			<?php echo $TPL_VAR["pagelist"]?>

		</div>
		<div id="wrap_btn">
			<input type="button" name="box" value="리그등록" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'"  onclick="window.open('/league/popup_add','','scrollbars=yes,width=600,height=400,left=5,top=0');">
			<input type="button" name="open" value="삭  제" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" onclick="isChm()"/>
		</div>
	</form>