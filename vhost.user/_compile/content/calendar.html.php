
<?php
    $is_enable_check = $TPL_VAR["is_enable_check"];
    $is_checked = $TPL_VAR["is_checked"];

    // get params
    $currMonth= date("m");
    $currYear = date("Y");
    $currDay = date("j");
    $startDate = strtotime($currYear . "-" . $currMonth . "-01 00:00:01");
    $startDay= date("N", $startDate);
    $monthName = date("M",$startDate );

    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date("m", $startDate), date( "Y", $startDate));
    $endDate = strtotime($currYear . "-" . $currMonth . "-" .  $daysInMonth ." 00:00:01");

    $endDay = date("N", $endDate);

    // php date sunday is zero
    if ($startDay> 6)
        $startDay = 7 -$startDay;

    $currElem = 0;
    $dayCounter = 0;
    $firstDayHasCome = false;
    $arrCal = array();
    for($i = 0; $i <= 5; $i ++) {
        for($j= 0; $j <= 6; $j++) {
            // decide what to show in the cell
            if($currElem < $startDay && !$firstDayHasCome)
                $arrCal[$i][$j] = "";
            else if ($currElem == $startDay && !$firstDayHasCome) {
                $firstDayHasCome= true;
                $arrCal[$i][$j] = ++$dayCounter;
            }
            else if ($firstDayHasCome) {
                if ($dayCounter < $daysInMonth)
                    $arrCal[$i][$j] = ++ $dayCounter;
                else
                    $arrCal[$i][$j] = "";
            }

            $currElem ++;
        }
    }
?>

    <div class="mask"></div>
	<div id="container">
	

<body>


<style type="text/css">
    ul, li {list-style:none outside;}
    A {text-decoration:none;}
    .attendance_table { border:1px solid #000; border-radius:5px;background-color: rgba(32,32,32,0.8); }
    .attendance_table td { border:1px solid #000; }
    .attendance_table th{ border-bottom:1px solid #31ed61;background-color: rgba(52,52,52,0.8); height:50px; border-left:1px solid #000;}

    /* date */

    #date_layer {text-align:left;}

    #date_layer #box {width:252px; height:55px; text-align:center; display:block;  background: linear-gradient( to left, #34fc67, #04b757 );
        box-shadow: 1px 1px 1px #fff inset; border-radius:100px; margin:20px auto;}
    #date_layer #box .top {width:40px; float:left;line-height:60px; text-align:center; }
    #date_layer #box .day {width:170px; float:left;}

    #date_layer .w {line-height:55px;  font-size:26px; font-weight:bold;  color:#000;  }
    #date_layer .title {color:#fff; font-size:12px;  padding:0 0 0 0;}
    #date_layer .title1 {color:#5b82c7; font-size:12px;  padding:0 0 0 0;}
    #date_layer .title2 {color:#d82900; font-size:12px;  padding:0 0 0 0; }

    #date_layer .sun1 {color:#ff0000; font-size:12px; float:left;}
    #date_layer .sat1 {color:#007eff; font-size:12px; float:left;}
    #date_layer .day1 {color:#fff; font-size:12px; float:left;}

    #date_layer .sun2 {font-weight:bold; line-height:20px; color:#d82900; font-size:12px; float:left;}
    #date_layer .sat2 {font-weight:bold; line-height:20px; color:#000fd8; font-size:12px; float:left;}
    #date_layer .day2 {font-weight:bold; line-height:20px; color:#FF9933; font-size:12px; float:left;}

    #date_layer .sun3 {color:#d82900; font-size:11px; }
    #date_layer .sat3 {color:#000fd8; font-size:11px; }
    #date_layer .day3 {color:#999999; font-size:11px; }

    #date_layer .dot {color:#000000; font-size:12px; }

    #date_layer .check {color:#126420; font-size:11px; }
    #date_layer .check2 {color:#999999; font-size:11px; }


    /* list */
    #list_layer .input {width:600px; height:22px; background-color:#f3f3f3; border:0px; padding:5px 2px 2px 2px; font-weight:bold; color:#333333;  font-size:12px;}

    #list_layer .msg {padding:6px 0 0 3px; float:left;}
    #list_layer .sub {padding:5px 0 0 3px; float:left;}
    #list_layer .submit {padding:3px 0 0 5px; float:left;}

    #list_layer #info li {line-height:18px; color:#898989;  font-size:11px;}

    #list_layer .title {font-weight:bold; color:#333333;  font-size:12px;}
    #list_layer .list {line-height:20px; color:#898989;  font-size:11px;}

    #list_layer .no {line-height:25px; font-size:12px; color:#898989;}

    #list_layer .bgcolor0 {background-color:#ffffff;}
    #list_layer .bgcolor1 {background-color:#f1f1f1;}
    #list_layer .bgcolor2 {background-color:#ffffff;}
    .warning_bg { text-align:center;width:100%; height:86px; position:relative; border:1px solid #000; background: linear-gradient( to bottom, #000000, #000000, #317440 ); border-radius:300px; margin:20px 0;}
    .warning_bg2 {  width:1000px; height:220px; position:relative; margin:0 auto; text-align:center;}
    .warning_txt1 { position:absolute; top:25px; left:55px;}
    .warning_txt2  { font-size:20px; color:#fff; text-align:center; line-height:88px; padding-left:150px;}
    .warning_txt2 .red_text { color:#ff0000;font-size:20px; font-weight:bold;}
    .warning_txt2 .gr_text { color:#28ee51;font-size:20px;font-weight:bold;}
</style>
<script type="text/javascript" src="/10bet/js/left.js?1610709439"></script>
<script type="text/javascript">
    $j(document).ready(function(){
        sendPacket(PACKET_SPORT_LIST, JSON.stringify(packet));
        
        <?php if($is_checked == 0) { ?>
            warning_popup("오늘 출석체크 하세요.");
        <?php } ?>
    });

    function moveMonth() {
        $j.ajax({
            type: 'POST',
            url: "calendarAjax.php?mov=",
            dataType : 'text',
            success: function(result) {
                if (result != null) {
                    $j('#calendarResualt').html(result);
                }
            },
            error: function(e) {
                warning_popup(e.responseText);
            }
        });
    };

    function chkDay(){
        $j.ajax({
            type: 'POST',
            url: "calendarAjax_proc",
            dataType : 'text',
            success: function(result) {
                console.log(result);
                result = result.trim();

                if (result == "OK") {
                    warning_popup('출석 체크 하셨습니다.');
                    location.reload();
                    //moveMonth();
                }else if (result == "ReOK") {
                    warning_popup('이미 출석 체크 하셨습니다.');
                    //moveMonth();
                }else if (result == "NoOK") {
                    warning_popup('출석 체크 실패하셨습니다.');
                    //moveMonth();
                }
            },
            error: function(e) {
                warning_popup(e.responseText);
            }
        });
    }
</script>
<div id="contents">
    <div class="board_box">
        <h2>출석부</h2>
        <div class="attend_box">
            <h3><img src="/10bet/images/10bet/title_attend_01.png" alt="출석부" /></h3>
            <div class="calendar-comment"><span>※ 당일 <span style="color:#d82900;">100,000</span> 원 이상 충전하셔야 출석체크가 가능합니다.</span></div>
            <div class="month">
                <?php echo $currYear.'년 '.$currMonth.'월'?>
            </div>
            <div class="attend_table">
                <table cellspacing="1" cellpadding="0">
                    <?php
                        $currElem = 0;
                        $dayCounter = 0;
                        $firstDayHasCome = false;

                        for($i = 0; $i <= 5; $i ++) {
                            echo "<tr>";
                            for($j= 0; $j <= 6; $j++) {
                                if($arrCal[$i][$j] == '')
                                {
                                    if($j == 0)
                                        echo ("<td align='center' valign='top' style=' border-top:1px solid #2c2d31;'><span class='sun3'></span>");
                                    else 
                                        echo ("<td align='center' valign='top' style='border-left:1px solid #2c2d31; border-top:1px solid #2c2d31;'><span class='day3'></span>");
                                } else {
                                    if($currDay == $arrCal[$i][$j])
                                    {
                                        echo ("<td align='center' valign='top' style='border-left:1px solid #2c2d31; border-top:1px solid #2c2d31; background-color: #00a2d8; opacity: 0.8;'>");
                                    } else {
                                        echo ("<td align='center' valign='top' style='border-left:1px solid #2c2d31; border-top:1px solid #2c2d31;'>");
                                    }
                                    echo ("<div style='padding:5px;'></div>");
                                    echo ("<div style='margin:10px;'>");
                                    if($currDay == $arrCal[$i][$j])
                                    {
                                        if($is_checked == 0)
                                        {
                                            if($is_enable_check == 0)
                                            {
                                                echo ("<a href=\"javascript:warning_popup('충전금액이 부족합니다.');\"><img src='/10bet/images/10bet/ico_attend_01.png'></a>");
                                            } else {
                                                echo ("<a href=\"javascript:chkDay();\"><img src='/10bet/images/10bet/ico_attend_01.png'></a>");
                                            }
                                        } else {
                                            echo ("<img src='/10bet/images/10bet/ico_attend_02.png'>");
                                        }
                                    } else {
                                        echo ("<img src='/10bet/images/10bet/ico_attend_01.png'>");
                                    }
                                    echo ('<span>'.$arrCal[$i][$j].'</span>');
                                    echo ('</div>');
                                }
                                echo ("</td>");
                            }
                            //echo("</div>\r\n");
                            echo "</tr>";
                        }

                    ?>
                </table>
            </div>
        </div>
    </div>
