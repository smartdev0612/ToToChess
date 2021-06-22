<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script type="text/javascript">
	function add_event(tr)
	{
		tr.onmouseover = function()
		{
			tr.className += ' hover';
		};
		tr.onmouseout = function()
		{
			tr.className = tr.className.replace(' hover', '');
		};
	}

	function stripe(table) 
	{
		var trs = table.getElementsByTagName("tr");
		for(var i=1; i<trs.length; i++)
		{
			var tr = trs[i];
			tr.className = i%2 != 0? 'odd' : 'even';
			add_event(tr);
		}
	}
	
	function dosubmit()
	{
		var ckip=f_check_IP();
		if(ckip==false)
		{
			alert('ip 격식이 틀립니다 확인하여 주십시오.');
			document.form1.ip.focus();
			return;
		}
		if(document.form1.ip.value=="")
		{
			alert('ip 를 입력하여 주십시오.');
			document.form1.ip.focus();
			return;
		}
		if(document.form1.web.value=="")
		{
			alert('봉쇄 원인을 입력하여 주십시오.');
			document.form1.web.focus();
			return;
		}
			form1.submit();
	}
		
	function f_check_IP()    
	{  
		var ip = document.getElementById('ip').value;
		var re=/^(\d+)\.(\d+)\.(\d+)\.(\d+)$/;
		if(re.test(ip))   
		{   
			if( RegExp.$1<256 && RegExp.$2<256 && RegExp.$3<256 && RegExp.$4<256) 
			return true;   
		}   
		return false;    
	}

	window.onload = function()
	{
		var tables = document.getElementsByTagName('table');
		for(var i=0; i<tables.length; i++){
			var table = tables[i];
			if(table.className == 'datagrid1' || table.className == 'datagrid2'
				|| table.className == 'datagrid3' || table.className == 'datagrid4'){
				stripe(tables[i]);
			}
		}
	}		
</script>


<div id="wrap_pop">
	<div id="pop_title">
		<h1>IP 차단 관리</h1>
		<p><img src="/img/btn_s_close.gif" onclick="window.close()" title="창닫기"></p>
	</div>

	<table cellspacing="1" class="tableStyle_normal" summary="IP 차단 관리">
	<legend class="blind">IP 차단 관리</legend>
	<thead>
		<tr>
			<th width="18%">IP</th>
			<th width="43%">원인</th>
			<th width="25%">시간</th>
			<th width="14%">상태</th>
		</tr>
	</thead>
	<tbody>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
			<tr>
				<td><?php echo $TPL_V1["SqlIn_IP"]?></td>
				<td><?php echo $TPL_V1["SqlIn_WEB"]?></td>
				<td align="center"><?php echo $TPL_V1["SqlIn_TIME"]?></td>
				<td align="center"><a href="?act=remove&ip=<?php echo $TPL_V1["SqlIn_IP"]?>">IP해제</a></td>
			</tr>
<?php }}?>
	</tbody>
	</table>

	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>

	</div>
	<!--
	<div id="wrap_btn">
		<button class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'" onclick="window.open('/etc/killiplist?act=add','add','width=590,height=200')">ip차단하기</button>	
	</div>
	-->
	<form action="?act=add_ip" method="post" name="form1">
		<table cellspacing="1" class="tableStyle_membersWrite" summary="IP 차단 관리">
		<legend class="blind">IP 차단 관리</legend>
			<tr>
				<th width="15%">IP</td>
				<td width="38%"><input type="text" size="20" name="ip" id="ip" class="wWhole""></td>
			 </tr>
			 <tr>
				 <th>원인</th>
				 <td><textarea name="web" cols="30" rows="5"></textarea></td>
			 </tr>
		</table>
		<div id="wrap_btn">
			<input type="button" value="ip차단하기" onclick="dosubmit();" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
		</div>
	</form>
</div>