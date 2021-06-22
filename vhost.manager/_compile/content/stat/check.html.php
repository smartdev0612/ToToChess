<?php
$TPL_partner_list_1=empty($TPL_VAR["partner_list"])||!is_array($TPL_VAR["partner_list"])?0:count((array)$TPL_VAR["partner_list"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count((array)$TPL_VAR["list"]);?>
<script>document.title = '통계-출석통계';</script>
<script>
	function on_click()
	{
		data=document.getElementById("date_id").value;
		data1=document.getElementById("date_id1").value;
		if(data=="" || data1=="")
		{
			alert("시간을 선택하여 주십시오.");
			return false;
		}
		else if(data1<data)
		{
			alert("끝나는 날자가 시작하는 날자보다 작을수 없습니다.");
			return false;
		}
		document.getElementById("form2").submit();
	}
</script>

<div class="wrap">

	<div id="route">
		<h5>관리자 시스템 > 통계 > <b>출석 통계</b></h5>
	</div>

	<h3>출석 통계</h3>

	<div id="search2">
		<div>
			<form action="?" method="GET" name="form2" id="form2">
                <!-- 기간 검색 -->
				<span class="icon">날짜</span><input name="begin_date" type="text" id="begin_date" class="date" value="<?php echo $TPL_VAR["begin_date"]?>" maxlength="25" onclick="new Calendar().show(this);" > ~ 
				<input name="end_date" type="text" id="end_date" class="date" value="<?php echo $TPL_VAR["end_date"]?>" maxlength="25"  onclick="new Calendar().show(this);" >

                <select name="field">
                    <option value="mem_id" 	<?php if($TPL_VAR["field"]=="mem_id"){?>	selected <?php }?>>아이디</option>
                    <option value="nick"  	<?php if($TPL_VAR["field"]=="nick"){?>		selected <?php }?>>닉네임</option>
                </select>
                <input name="keyword" type="text" id="key" class="name" value="<?php echo $TPL_VAR["keyword"]?>" maxlength="20" onmouseover="this.focus()"/>

				<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
			</form>
		</div>
	</div>

	<form id="form1" name="form1" method="post" action="?act=delete_user">
	<table cellspacing="1" class="tableStyle_normal add" summary="입/출금 통계" style="width:1300px;">
	<legend class="blind">입/출금</legend>
	<thead>
		<tr style="height: 50px">
			<th scope="col">아이디</th>
            <th scope="col">닉네임</th>
            <?php
                foreach($TPL_VAR["list"]['date'] as $key=>$data)
                {
                    echo '<th scope="col">'.$data["current_date_msg"].'</th>';
                }
            ?>
            <th scope="col">포인트</br>(일)</th>
			<th scope="col">포인트</br>(주일)</th>
			<th scope="col">포인트</br>(월)</th>
            <th scope="col">합계</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"]['item'] as $k=>$TPL_V1){?>
			<tr>
				<td><?php echo $k?></td>
                <td><?php echo  $TPL_V1['nick']?></td>
                <?php
                foreach($TPL_VAR["list"]['date'] as $key=>$data)
                {
                    if($TPL_V1[$data["current_date"]] == 1)
                    {
                        echo '<td style="background: #a3d46e"></td>';
                    } else {
                        echo '<td></td>';
                    }
                }
                ?>
				<td> <?php echo $TPL_V1['d'];?> </td>
                <td> <?php echo $TPL_V1['w'];?> </td>
                <td> <?php echo $TPL_V1['m'];?> </td>
                <td> <?php echo $TPL_V1['d'] + $TPL_V1['w'] + $TPL_V1['m'];?> </td>
			 </tr>
<?php }}?>
	</tbody>
	</table>		 
	</form>	

</div>