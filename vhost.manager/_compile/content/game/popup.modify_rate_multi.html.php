<?php /* Template_ 2.2.3 2014/01/10 15:03:06 D:\www_one-23.com\vhost.manager\_template\content\game\popup.modify_rate.html */?>
</head>

<?php if($TPL_VAR["bettype"]==4){?>
<script>
	function Edit_Ok()
	{
		var frm = document.EditForm;
		
		if(frm.home_rate.value>=10 || frm.away_rate.value>=10)
		{
			if(confirm('배당이 10 을 초과 하였습니다. \n\n "확인" 클릭시 올림    "취소"클릭시 취소됩니다. ')) {}
			else{return;}
		}
		if (frm.home_rate.value > 19) 
		{
		   alert("승자 배당률을 입력하세요");
		   frm.home_rate.focus();
		   return;
		} 
		if (frm.draw_rate.value < 0.9 ) 
		{
		   alert("입력값에 이상이 있습니다.");
		   frm.draw_rate.focus();
		   return;
		} 
		if (frm.away_rate.value > 19 )
		{
		   alert("패자 배당률을 입력하세요");
		   frm.away_rate.focus();
		   return;
		}
		frm.submit();
	}
</script>
<?php }else{?>
<script>
	function Edit_Ok(){
		var frm = document.EditForm;
		if(frm.home_rate.value>=10 || frm.away_rate.value>=10)
		{
			if(confirm('배당이 10 을 초과 하였습니다. \n\n "확인" 클릭시 올림    "취소"클릭시 취소됩니다. ')){}
			else{return;}
		}
		if (frm.home_rate.value > 19) 
		{
		   alert("승자배당 확인 ");
		   frm.home_rate.focus();
		   return;
		} 
		if (frm.away_rate.value > 19 )
		{
		   alert("패자 배당률을 입력하세요");
		   frm.away_rate.focus();
		   return;
		} 
	
		frm.submit();
	}
</script>
<?php }?>

<body>

<div id="wrap_pop">

<form action="/game/rateProcessMulti" method="post" name="EditForm">
	<input type="hidden" name="idx" value="<?php echo $TPL_VAR["idx"]?>">	
	<input type="hidden" name="mode" value="<?php echo $TPL_VAR["mode"]?>">
	<input type="hidden" name="gametype" value="<?php echo $TPL_VAR["gametype"]?>">
	
	<div id="pop_title">
		<h1>
            <font size="2" color="red">
                <?php 
                    $detail_name = "";
                    switch ($TPL_VAR['sport_name']) {
                        case "축구":
                            switch ($TPL_VAR['gametype']) {
                                case "1":
                                    $detail_name = "승패";
                                    break;
                                case "2":
                                case "11":
                                    $detail_name = "핸디캡";
                                    break;
                                case "3":
                                case "12":
                                    $detail_name = "언더오버";
                                    break;
                                case "4":
                                    $detail_name = "승무패";
                                    break;
                                case "5":
                                    $detail_name = "승무패(전반)";
                                    break;
                                case "6":
                                    $detail_name = "승무패(후반)";
                                    break;
                                case "7":
                                    $detail_name = "언더오버(전반)";
                                    break;
                                case "8":
                                    $detail_name = "언더오버(후반)";
                                    break;
                                case "9":
                                    $detail_name = "득점홀짝";
                                    break;
                                case "10":
                                    $detail_name = "득점홀짝(전반)";
                                    break;
                                case "13":
                                    $detail_name = "정확한 스코어 (" . $TPL_VAR['point'] . ")";
                                    break;
                            }
                            break;
                        case "농구":
                            switch ($TPL_VAR['gametype']) {
                                case "1":
                                    $detail_name = "승패";
                                    break;
                                case "2":
                                case "16":
                                    $detail_name = "핸디캡";
                                    break;
                                case "3":
                                case "17":
                                    $detail_name = "언더오버";
                                    break;
                                case "4":
                                    $detail_name = "승무패(1쿼터)";
                                    break;
                                case "5":
                                    $detail_name = "승무패(2쿼터)";
                                    break;
                                case "6":
                                    $detail_name = "승무패(3쿼터)";
                                    break;
                                case "7":
                                    $detail_name = "승무패(4쿼터)";
                                    break;
                                case "8":
                                    $detail_name = "핸디캡(1쿼터)";
                                    break;
                                case "9":
                                    $detail_name = "핸디캡(2쿼터)";
                                    break;
                                case "10":
                                    $detail_name = "핸디캡(3쿼터)";
                                    break;
                                case "11":
                                    $detail_name = "핸디캡(4쿼터)";
                                    break;
                                case "12":
                                    $detail_name = "언더오버(1쿼터)";
                                    break;
                                case "13":
                                    $detail_name = "언더오버(2쿼터)";
                                    break;
                                case "14":
                                    $detail_name = "언더오버(3쿼터)";
                                    break;
                                case "15":
                                    $detail_name = "언더오버(4쿼터)";
                                    break;
                            }
                            break;
                        case "배구":
                            switch ($TPL_VAR['gametype']) {
                                case "1":
                                    $detail_name = "승패";
                                    break;
                                case "2":
                                    $detail_name = "핸디캡";
                                    break;
                                case "3":
                                    $detail_name = "언더오버";
                                    break;
                                case "4":
                                    $detail_name = "홀짝";
                                    break;
                                case "5":
                                    $detail_name = "홀짝(1세트)";
                                    break;
                                case "6":
                                    $detail_name = "정확한 스코어 (" . $TPL_VAR['point'] . ")";
                                    break;
                            }
                            break;
                        case "야구":
                            switch ($TPL_VAR['gametype']) {
                                case "1":
                                    $detail_name = "승패";
                                    break;
                                case "2":
                                case "11":
                                    $detail_name = "핸디캡";
                                    break;
                                case "3":
                                case "12":
                                    $detail_name = "언더오버";
                                    break;
                                case "4":
                                    $detail_name = "승무패(1이닝)";
                                    break;
                                case "5":
                                    $detail_name = "핸디캡(3이닝)";
                                    break;
                                case "6":
                                    $detail_name = "핸디캡(5이닝)";
                                    break;
                                case "7":
                                    $detail_name = "핸디캡(7이닝)";
                                    break;
                                case "8":
                                    $detail_name = "언더오버(3이닝)";
                                    break;
                                case "9":
                                    $detail_name = "언더오버(5이닝)";
                                    break;
                                case "10":
                                    $detail_name = "언더오버(7이닝)";
                                    break;
                            }
                            break;
                        case "아이스하키":
                            switch ($TPL_VAR['gametype']) {
                                case "1":
                                    $detail_name = "승패";
                                    break;
                                case "2":
                                    $detail_name = "핸디캡";
                                    break;
                                case "3":
                                    $detail_name = "언더오버";
                                    break;
                                case "4":
                                    $detail_name = "승무패";
                                    break;
                                case "5":
                                    $detail_name = "승패(1피리어드)";
                                    break;
                                case "6":
                                    $detail_name = "승무패(1피리어드)";
                                    break;
                                case "7":
                                    $detail_name = "핸디캡(1피리어드)";
                                    break;
                                case "8":
                                    $detail_name = "언더오버(1피리어드)";
                                    break;
                            }
                            break;
                    }
                    echo $detail_name;
                ?>
            </font> 
            배당 수정
        </h1>
        <p><a href="#"><img src="/img/btn_s_close.gif" onclick="self.close();"></a></p>
	</div>

	<table cellspacing="1" class="tableStyle_modifyRate">
		<tr>
			<th>경기시간</th>
			<td>
				<input name="gameDate" type="text" id="begin_date" class="date" value="<?php echo $TPL_VAR["item"]["gameDate"]?>" size='8' maxlength="20" onclick="new Calendar().show(this);"/>
				<input type='text' size=4 name='gameHour' value='<?php echo $TPL_VAR["item"]["gameHour"]?>'/>
				<input type='text' size=4 name='gameTime' value='<?php echo $TPL_VAR["item"]["gameTime"]?>'/>
			</td>
		</tr>
		<tr>
			<th>리그명</th>
			<td>&nbsp;&nbsp;<?php echo $TPL_VAR["item"]["league_name"]?></td>
		</tr>
		<tr>
			<th>팀명</th>
			<td>&nbsp;&nbsp;<?php echo $TPL_VAR["item"]["home_team"]?> <font color='red'>VS</font> <?php echo $TPL_VAR["item"]["away_team"]?></td>
		</tr>
		<tr>
			<th>
            <?php 
                $detail_name = "";
                switch ($TPL_VAR['sport_name']) {
                    case "축구":
                        switch ($TPL_VAR['gametype']) {
                            case "1":
                                $detail_name = "승패";
                                break;
                            case "2":
                            case "11":
                                $detail_name = "핸디캡";
                                break;
                            case "3":
                            case "12":
                                $detail_name = "언더오버";
                                break;
                            case "4":
                                $detail_name = "승무패";
                                break;
                            case "5":
                                $detail_name = "승무패(전반)";
                                break;
                            case "6":
                                $detail_name = "승무패(후반)";
                                break;
                            case "7":
                                $detail_name = "언더오버(전반)";
                                break;
                            case "8":
                                $detail_name = "언더오버(후반)";
                                break;
                            case "9":
                                $detail_name = "득점홀짝";
                                break;
                            case "10":
                                $detail_name = "득점홀짝(전반)";
                                break;
                            case "13":
                                $detail_name = "정확한 스코어";
                                break;
                        }
                        break;
                    case "농구":
                        switch ($TPL_VAR['gametype']) {
                            case "1":
                                $detail_name = "승패";
                                break;
                            case "2":
                            case "16":
                                $detail_name = "핸디캡";
                                break;
                            case "3":
                            case "17":
                                $detail_name = "언더오버";
                                break;
                            case "4":
                                $detail_name = "승무패(1쿼터)";
                                break;
                            case "5":
                                $detail_name = "승무패(2쿼터)";
                                break;
                            case "6":
                                $detail_name = "승무패(3쿼터)";
                                break;
                            case "7":
                                $detail_name = "승무패(4쿼터)";
                                break;
                            case "8":
                                $detail_name = "핸디캡(1쿼터)";
                                break;
                            case "9":
                                $detail_name = "핸디캡(2쿼터)";
                                break;
                            case "10":
                                $detail_name = "핸디캡(3쿼터)";
                                break;
                            case "11":
                                $detail_name = "핸디캡(4쿼터)";
                                break;
                            case "12":
                                $detail_name = "언더오버(1쿼터)";
                                break;
                            case "13":
                                $detail_name = "언더오버(2쿼터)";
                                break;
                            case "14":
                                $detail_name = "언더오버(3쿼터)";
                                break;
                            case "15":
                                $detail_name = "언더오버(4쿼터)";
                                break;
                        }
                        break;
                    case "배구":
                        switch ($TPL_VAR['gametype']) {
                            case "1":
                                $detail_name = "승패";
                                break;
                            case "2":
                                $detail_name = "핸디캡";
                                break;
                            case "3":
                                $detail_name = "언더오버";
                                break;
                            case "4":
                                $detail_name = "홀짝";
                                break;
                            case "5":
                                $detail_name = "홀짝(1세트)";
                                break;
                            case "6":
                                $detail_name = "정확한 스코어";
                                break;
                        }
                        break;
                    case "야구":
                        switch ($TPL_VAR['gametype']) {
                            case "1":
                                $detail_name = "승패";
                                break;
                            case "2":
                            case "11":
                                $detail_name = "핸디캡";
                                break;
                            case "3":
                            case "12":
                                $detail_name = "언더오버";
                                break;
                            case "4":
                                $detail_name = "승무패(1이닝)";
                                break;
                            case "5":
                                $detail_name = "핸디캡(3이닝)";
                                break;
                            case "6":
                                $detail_name = "핸디캡(5이닝)";
                                break;
                            case "7":
                                $detail_name = "핸디캡(7이닝)";
                                break;
                            case "8":
                                $detail_name = "언더오버(3이닝)";
                                break;
                            case "9":
                                $detail_name = "언더오버(5이닝)";
                                break;
                            case "10":
                                $detail_name = "언더오버(7이닝)";
                                break;
                        }
                        break;
                    case "아이스하키":
                        switch ($TPL_VAR['gametype']) {
                            case "1":
                                $detail_name = "승패";
                                break;
                            case "2":
                                $detail_name = "핸디캡";
                                break;
                            case "3":
                                $detail_name = "언더오버";
                                break;
                            case "4":
                                $detail_name = "승무패";
                                break;
                            case "5":
                                $detail_name = "승패(1피리어드)";
                                break;
                            case "6":
                                $detail_name = "승무패(1피리어드)";
                                break;
                            case "7":
                                $detail_name = "핸디캡(1피리어드)";
                                break;
                            case "8":
                                $detail_name = "언더오버(1피리어드)";
                                break;
                        }
                        break;
                }
                echo $detail_name;
                ?>
            </th>
			<?php echo $TPL_VAR["html"]?>

		</tr>
	</table>

	<div id="wrap_btn">
		<input type="button" value="등록하기" onclick="Edit_Ok()" class="Qishi_submit_a">
		<input type="button" value="  닫 기  " onclick="self.close()" class="Qishi_submit_a">		
	</div>
	
</form>

<script type="text/javascript" language="JavaScript">
function ShowTr() 
{ 
	if(document.all.result.style.display == '') {document.all.result.style.display = 'none';}
	else										{document.all.result.style.display = '';}
}
</script>

</div>
</body>
</html>