<?php
$TPL_hours_1=empty($TPL_VAR["hours"])||!is_array($TPL_VAR["hours"])?0:count($TPL_VAR["hours"]);
$TPL_mins_1=empty($TPL_VAR["mins"])||!is_array($TPL_VAR["mins"])?0:count($TPL_VAR["mins"]);
$TPL_category_list_1=empty($TPL_VAR["category_list"])||!is_array($TPL_VAR["category_list"])?0:count($TPL_VAR["category_list"]);
$TPL_league_list_1=empty($TPL_VAR["league_list"])||!is_array($TPL_VAR["league_list"])?0:count($TPL_VAR["league_list"]);?>
<script>
function Edit_Ok()
{
	var frm = document.EditForm;
	if (frm.GameDate.value == "") 
	{
	   alert("경기일자를 선택하세요");
	   frm.GameDate.focus();
	   return;
	} 
	if (frm.gameHour.value == "") 
	{
	   alert("시간을 선택하세요");
	   frm.gameHour.focus();
	   return;
	} 
	if (frm.gameTime.value == "")
	{
	   alert("분을 선택하세요");
	   frm.gameTime.focus();
	   return;
	} 
	if (frm.category.value == "")
	{
	   alert("종목을 선택하세요");
	   frm.category.focus();
	   return;
	} 
	if (frm.strLeagueName.value == "")
	{
	   alert("리그를 선택하세요");
	   frm.strLeagueName.focus();
	   return;
	} 
	if (frm.HomeTeam.value == "")
	{
	   alert("홈팀명을 입력하세요");
	   frm.HomeTeam.focus();
	   return;
	} 
	if (frm.AwayTeam.value == "")
	{
	   alert("원정팀을 입력하세요");
	   frm.strLeagueName.focus();
	   return;
	} 
	if(document.getElementById("view")!=null)
	{
		if(document.getElementById("view").checked)
		{
			//if(document.getElementByNames("auto"))
			var radios=document.getElementsByName("auto");
			var strradiosvalue="";
			var falg=false;
			for(var mm=0;mm<radios.length;mm++)
			{
				if(radios[mm].checked)
				{
					falg=true;
					strradiosvalue=radios[mm].value;
					break;
				}
			}
			if(falg)
			{
				if(strradiosvalue==0)
				{
					if(frm.winPoint.value=="" || frm.winPoint2.value=="")
					{
						alert("입력하신 점수가 정확하지 않습니다. 다시입력하여 주세요");//没有给比分
						return;
					}
				}
			}
			else
			{
				alert("승리팀을 선택하여 주세요");
				return;
			}
		}
	}
	frm.submit();
}
</script>
</head>

<body>

<div id="wrap_pop">

<form action="/gameUpload/modifyProcess" method="post" name="EditForm">
	<input type="hidden" name="idx" value="<?php echo $TPL_VAR["idx"]?>">	
	<input type="hidden" name="mode" value="<?php echo $TPL_VAR["mode"]?>">
	<input type='hidden' name='result_state' value='<?php echo $TPL_VAR["result"]?>'/>

	<div id="pop_title">
		<h1>항목 등록 및 수정 -  [<?php echo $TPL_VAR["idx"]?>]</h1><p><a href="#"><img src="/img/btn_s_close.gif" onclick="self.close();"></a></p>
	</div>

	<table cellspacing="1" class="tableStyle_membersWrite">	
		<tr>
			<th>대분류</th>
			<td>
				<select name="special_type">
					<option value="0" <?php if($TPL_VAR["item"]["special"]==='0'){?> selected <?php }?>>일반</option>
					<option value="1" <?php if($TPL_VAR["item"]["special"]==='1'){?> selected <?php }?>>스페셜</option>
					<option value="2" <?php if($TPL_VAR["item"]["special"]==='2'){?> selected <?php }?>>실시간</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>게임종류</th>
			<td>
				<select name="game_type">
					<option value="1" <?php if($TPL_VAR["item"]["type"]==1){?> selected <?php }?>>승무패</option>
					<option value="2" <?php if($TPL_VAR["item"]["type"]==2){?> selected <?php }?>>핸디캡</option>
					<option value="4" <?php if($TPL_VAR["item"]["type"]==4){?> selected <?php }?>>언더오버</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>경기일시</th>
			<td>
				<input type="text" name="GameDate" size=10 value="<?php echo $TPL_VAR["item"]["gameDate"]?>" onclick='new Calendar().show(this);'  height="17" style="border:1px #97ADCE solid;">&nbsp;&nbsp;
				<select name="gameHour" >
					<option value=''>시간</option>
<?php if($TPL_hours_1){foreach($TPL_VAR["hours"] as $TPL_V1){?>
						<option value='<?php echo $TPL_V1?>' <?php if($TPL_V1==$TPL_VAR["item"]["gameHour"]){?> selected <?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
				</select>&nbsp;&nbsp;
				<select name="gameTime">
					<option value=''>분</option>
<?php if($TPL_mins_1){foreach($TPL_VAR["mins"] as $TPL_V1){?>
						<option value='<?php echo $TPL_V1?>' <?php if($TPL_V1==$TPL_VAR["item"]["gameTime"]){?> selected <?php }?>><?php echo $TPL_V1?></option>
<?php }}?>	
				</select>
			</td>
		</tr>
		<tr>
			<th>종목선택</th>
			<td>
				<select name="category">
					<option value=''>선택하세요</option>
<?php if($TPL_category_list_1){foreach($TPL_VAR["category_list"] as $TPL_V1){?>
						<option <?php if($TPL_V1["name"]==$TPL_VAR["item"]["sport_name"]){?>selected<?php }?> value='<?php echo $TPL_V1["name"]?>'><?php echo $TPL_V1["name"]?></option>
<?php }}?>
				</select>
				
			</td>
		</tr>
		<tr>
			<th>리그선택</th>
			<td>
				<select name="strLeagueName" style="width:70%">
					<option value=''>선택하세요</option>
<?php if($TPL_league_list_1){foreach($TPL_VAR["league_list"] as $TPL_V1){?>
						<option <?php if($TPL_V1["sn"]==$TPL_VAR["item"]["league_sn"]){?> selected <?php }?> value='<?php echo $TPL_V1["sn"]?>'><?php echo $TPL_V1["name"]?></option>
<?php }}?>
				</select>
			</td>
		</tr>
		<tr>
			<th>팀명</th>
			<td>
				<input type="text" name="HomeTeam" size=20 value="<?php echo $TPL_VAR["item"]["home_team"]?>" style="border:1px #97ADCE solid;">&nbsp;VS&nbsp;
				<input type="text" name="AwayTeam" size=20 value="<?php echo $TPL_VAR["item"]["away_team"]?>" style="border:1px #97ADCE solid;">
			</td>
		</tr>
		<!--
		<tr>
			<th>발매여부</th>
			<td>
				<input type="radio" name="play" class="radioMargin" value=0 <?php if($TPL_VAR["item"]["kubun"]==0){?> checked <?php }?>>발매가능&nbsp;
				<input type="radio" name="play" class="radioMargin" size=4 value=1 <?php if($TPL_VAR["item"]["kubun"]==1){?> checked <?php }?>><font color="red">발매중지</font>
			</td>
		</tr>
		-->
		<!--
		<tr>
			<th>공지사항</th>
			<td>
				<textarea name="notice" cols="50" rows="5"><?php echo $TPL_VAR["item"]["notice"]?></textarea>
			</td>
		</tr>
		-->
<?php if($TPL_VAR["result"]!=1){?>
		<tr>
			<td colspan="2"><input type="checkbox" name="view" id="view" value='1' onclick="javascript:ShowTr()"; class="radioMargin"> 게임결과를 수정하시려면 체크하세요 </td>
		</tr>
		<tr name="result" id="result" style="display:none";>
			<th>게임결과</td>
			<td>
				<p class="contentMargin">
					<b><?php echo $TPL_VAR["item"]["home_team"]?></b>
					<input type="text" name="winPoint" id="winPoint" size=2 value="<?php echo $TPL_VAR["item"]["home_score"]?>" style="border:1px #97ADCE solid;" onKeyUp="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))">&nbsp;VS&nbsp;<b><?php echo $TPL_VAR["item"]["away_team"]?></b>
					<input type="text" name="winPoint2" id="winPoint2" size=2 value="<?php echo $TPL_VAR["item"]["away_score"]?>" style="border:1px #97ADCE solid;" onKeyUp="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))">
				</p>
				<p class="contentMargin">
					자동<input type="hidden" name="bet_type" value="<?php echo trim($TPL_VAR["item"]["type"])?>" style="border:1px #97ADCE solid;">
					<input type="radio" name="auto" onclick="autoSelect(<?php echo trim($TPL_VAR["item"]["type"])?>, <?php echo $TPL_VAR["item"]["draw_rate"]?>)" value="0" class="radioMargin">
					<select name="winTeamauto" id="winTeamauto"  style="width:100px" >
					</select>
					수동<input type="radio" name="auto" value="1" class="radioMargin">
					<select name="winTeam" id="winTeam">
						<option value="">::선택::</option>
						<option value="Home">홈팀승</option>
						<option value="Away">원정팀승</option>
<?php if(trim($TPL_VAR["item"]["type"])!=2){?>
						<option value="Draw">무승부</option>
<?php }?>
						<option value="Cancel">경기취소</option>
					</select>
				</p>
			</td>
		</tr>
<?php }else{?>
		<tr>
			<th>게임결과</td>
			<td>
				<p class="contentMargin">
					<b><?php echo $TPL_VAR["item"]["home_team"]?></b>
					<input type="text" name="winPoint" id="winPoint" size=2 value="<?php echo $TPL_VAR["item"]["home_score"]?>" style="border:1px #97ADCE solid;" onKeyUp="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))">&nbsp;VS&nbsp;<b><?php echo $TPL_VAR["item"]["away_team"]?></b>
					<input type="text" name="winPoint2" id="winPoint2" size=2 value="<?php echo $TPL_VAR["item"]["away_score"]?>" style="border:1px #97ADCE solid;" onKeyUp="value=value.replace(/[^\d]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))">
				</p>
			</td>
		</tr>
<?php }?>
		<tr>
			<th>보임/숨김</th>
			<td>
				<select name="user_view_flag">
					<option value="0" <?php if($TPL_VAR["item"]["user_view_flag"]==='0'){?> selected <?php }?>>숨김</option>
					<option value="1" <?php if($TPL_VAR["item"]["user_view_flag"]==='1'){?> selected <?php }?>>보임</option>
				</select> ※ 유저 배팅리스트 숨김 기능.
			</td>
		</tr>
	</table>

	<div id="wrap_btn">
		<input type="button" value="  수 정  " onclick="Edit_Ok()"; class="Qishi_submit_a">
		<input type="button" value="  닫 기  " onclick="self.close()" class="Qishi_submit_a">
	</div>

	</form>


<script type="text/javascript" language="JavaScript">
<!--
function ShowTr() 
{ 
	if (document.all.result.style.display == '') {
    	document.all.result.style.display = 'none';
  	}
  	else
  	{ 
		document.all.result.style.display = '';
  	}
} 

function autoSelect(bet_type, draw_rate)
{
	var winPoint  =parseFloat(document.getElementById("winPoint").value);
	var winPoint2 =parseFloat(document.getElementById("winPoint2").value);
	
	if(isNaN(winPoint)|| isNaN(winPoint2))
	{
		alert("스코어입력!");
		return false
	}
	var obj=document.getElementById('winTeamauto');

	//승무패
	if(bet_type==1)
	{
		if(winPoint==winPoint2)
		{
			if(draw_rate=="1.00") obj.add(new Option('적특','Cancel',true,true));
			else 									obj.add(new Option('무승부','Draw',true,true));
		}
		else if (winPoint>winPoint2)	{obj.add(new Option('홈팀승','Home',true,true));}
		else													{obj.add(new Option('원정팀승','Away',true,true));}
	}
	
	// 핸디캡
	else if(bet_type==2)
	{
		if(winPoint+type_b>winPoint2)				{obj.add(new Option('홈팀승','Home',true,true));}
		else if (winPoint+type_b<winPoint2)	{obj.add(new Option('원정팀승','Away',true,true));}
		else																{obj.add(new Option('경기취소','Cancel',true,true));}
	}
	// 언더오버
	else
	{
		if(winPoint+winPoint2>type_b)		{obj.add(new Option('홈팀승','Home',true,true));}
		else if (winPoint+winPoint2<type_b)	{obj.add(new Option('원정팀승','Away',true,true));}
		else								{obj.add(new Option('경기취소','Cancel',true,true));}
	}
	
}
//-->
</script>

</body>
</html>