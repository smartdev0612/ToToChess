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

<div class="both"></div>
<div class="container">
    <div class="both"></div>
    <div id="wrapper">
        <div id="wrap">
            <!-- 해더 -->
            <div id="container">
                <!--<script type="text/javascript" src="event/jquery-1.11.0.min.js"></script>-->
                <script type="text/javascript">
                    <!--
                    $(document).ready(function(){
                        <?php if($is_checked == 0) { ?>
                            warning_popup("오늘 출석체크 하세요.");
                        <?php } ?>
                        /*$.ajax({
                            type: 'POST',
                            url: "calendarAjax.php?mov=",
                            dataType : 'text',
                            success: function(result) {
                                if (result != null) {
                                    $('#calendarResualt').html(result);
                                }
                            },
                            error: function(e) {
                                warning_popup(e.responseText);
                            }
                        });*/
                    });

                    function moveMonth() {
                        $.ajax({
                            type: 'POST',
                            url: "calendarAjax.php?mov=",
                            dataType : 'text',
                            success: function(result) {
                                if (result != null) {
                                    $('#calendarResualt').html(result);
                                }
                            },
                            error: function(e) {
                                warning_popup(e.responseText);
                            }
                        });
                    };
                    function chkDay(){
                        $.ajax({
                            type: 'POST',
                            url: "calendarAjax_proc",
                            dataType : 'text',
                            success: function(result) {
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
                    //-->
                </script>

                <div class="content_middle">
                    <div class="content_title" style="font-size: 20px; font-weight: bold;">
                        출석체크
                    </div>
                    <!-- 컨텐츠 영역-->
                    <div class="cont_section">
                        <div class="calendar">
                            <span style="font-size: 20px; font-weight: bold;"><?php echo $currYear.'년 '.$currMonth.'월'?></span>

                            <!-- 게시판 -->
                            <div class="calendar_list" id="calendarResualt" style="font-size: 15px; font-weight: bold;">
                                <table style="margin: 0 auto;">
                                    <thead>
                                    <tr>
                                        <th align="right">일<span></span></th>
                                        <th align="right">월<span></span></th>
                                        <th align="right">화<span></span></th>
                                        <th align="right">수<span></span></th>
                                        <th align="right">목<span></span></th>
                                        <th align="right">금<span></span></th>
                                        <th align="right">토<span></span></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $currElem = 0;
                                    $dayCounter = 0;
                                    $firstDayHasCome = false;
                                    //$lowerLeftCorner= "style=\"border-bottom-left-radius:18px;\"";
                                    //$lowerRightCorner= "style=\"border-bottom-right-radius:18px;\"";

                                    for($i = 0; $i <= 5; $i ++) {
                                        //echo("<div>\r\n");
                                        echo "<tr>";
                                        for($j= 0; $j <= 6; $j++) {

                                            echo ("<td>");
                                            if($arrCal[$i][$j] == '')
                                            {

                                            } else {
                                                echo ('<div class="calendar_total">');
                                                echo ('<font color="#ffffff" size="5px">'.$arrCal[$i][$j].'</font>');
                                                echo ('</div>');

                                                if($currDay == $arrCal[$i][$j])
                                                {
                                                    if($is_checked == 0)
                                                    {
                                                        if($is_enable_check == 0)
                                                        {
                                                            echo "<br><a href=\"javascript:warning_popup('충전금액이 부족합니다.');\"><img src=\"../images/dkhkwekhj.png\" style=\"width: 80%; height: 40px; line-height: 40px; margin-top: -40px;background-color: #fff; border-radius: 40px;\"></a>";
                                                        } else {
                                                            echo "<br><a href=\"javascript:chkDay();\"><img src=\"../images/dkhkwekhj.png\" style=\"width: 80%; height: 40px; line-height: 40px; margin-top: -40px;background-color: #fff; border-radius: 40px; \"></a>";
                                                        }
                                                    } else {
                                                        echo "<br><img src=\"../images/dkhkwekhj.png\" style=\"width: 80%; height: 40px; line-height: 40px; margin-top: -40px;background-color: #e45e5e; border-radius: 40px; \">";
                                                    }
                                                    
                                                }
                                            }

                                            echo ("</td>");
                                        }
                                        //echo("</div>\r\n");
                                        echo "</tr>";
                                    }

                                    ?>
                                    </tbody>
                                </table></div>
                        </div>
                    </div>
                </div>
                <!-- 전체 레이아웃 -->
            </div>
        </div>
<!--        <iframe name="HiddenFrm" src="/Blank.html" frameborder="0" width="0" height="0"></iframe>
        <iframe name="ProcFrm" src="/Blank.html" frameborder="0" width="0" height="0"></iframe>-->

    </div></div></div></body></html>