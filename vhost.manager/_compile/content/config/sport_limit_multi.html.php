<script>
    /*$(document).ready(function() {
        openCity(event, 'cross');
    });*/
    function confirmOk(level)
    {
        //fm = document.getElementsByName("frm"+level);
        fm = document.frm1;
        if(level == 2)
            fm = document.frm2;
        else if(level == 3)
            fm = document.frm3;
        else if(level == 4)
            fm = document.frm4;
        else if(level == 5)
            fm = document.frm5;

        fm.action = "/config/sportlimitProcessMulti";
        fm.submit();
    }

    //숫자 와 소주점만 가능
    function onlyNumDecimalInput(){
        var code = window.event.keyCode;

        if ((code >= 48 && code <= 57) || (code >= 96 && code <= 105) || code == 110 || code == 190 ||
            code == 8 || code == 9 || code == 13 || code == 46){
            window.event.returnValue = true;
            return;
        }
        alert("숫자만 입력 가능 합니다!");
        window.event.returnValue = false;
    }
</script>

<style>
    /* Style the tab */
    .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
    }

    /* Style the buttons that are used to open the tab content */
    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
        background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent1 {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }

    .tabcontent2 {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }

    .tabcontent3 {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }

    .tabcontent4  {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }

    .tabcontent5 {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }

</style>
<script>
    function openCity(evt, kind, index, sport='') {
        // Declare all variables
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent"+index);
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(kind+index).style.display = "block";

        if(sport != null && sport !='')
        {
            document.getElementById(kind+index+'_'+sport).style.display = "block";
        }

        evt.currentTarget.className += " active";
    }
</script>

<div class="wrap" style="width: 1200px">

    <div id="route">
        <h5>관리자 시스템 > 미니게임 관리 > <b>스포츠 배팅제한설정</b></h5>
    </div>
    <h3>스포츠 배팅제한설정</h3>
    <div id="betting_2">
        <ul id="tab">
            <li><a href="/config/sportlimit" id="sport_1">스포츠 I</a></li>
            <li><a href="/config/sportlimitMulti" id="sport_2">스포츠 II</a></li>
        </ul>
    </div>
    <?php
    foreach($TPL_VAR["list"] as $TPL_V) {
        $level = $TPL_V["level"];
    ?>
    <form  method="post" name="frm<?=$level?>">
        <input type="hidden" name="level" id="leven" value="<?=$level?>">
        <div id="wrap_btn">
            <span style="background: url(../img/icon1.gif) left 50% no-repeat;padding: 0 0 2px 10px;">레벨 <?=$level?></span>
            <!--<input type="button" class="Qishi_submit_a" style="margin-left:30px" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" value="저  장" onclick="confirmOk();"/>-->
        </div>
        <!-- Tab links -->
        <div class="tab">
            <button type="button" class="tablinks" onclick="openCity(event, 'cross', '<?=$level?>', 'soccer')">크로스</button>
            <button type="button" class="tablinks" onclick="openCity(event, 'handi', '<?=$level?>', 'soccer')">핸디캡</button>
            <input type="button" class="Qishi_submit_a" style="margin-left:965px;margin-top: 10px" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" value="저  장" onclick="confirmOk(<?=$level?>);"/>
        </div>

        <!-- Tab content -->
        <div id="cross<?=$level?>" class="tabcontent<?=$level?>"  style="display: block;margin-bottom: 40px;">
            <div class="tab">
                <button type="button" class="tablinks" onclick="openCity(event, 'cross', '<?=$level?>', 'soccer')">축구</button>
                <button type="button" class="tablinks" onclick="openCity(event, 'cross', '<?=$level?>', 'baseball')">야구</button>
                <button type="button" class="tablinks" onclick="openCity(event, 'cross', '<?=$level?>', 'basketball')">농구</button>
                <button type="button" class="tablinks" onclick="openCity(event, 'cross', '<?=$level?>', 'volleyball')">배구</button>
                <button type="button" class="tablinks" onclick="openCity(event, 'cross', '<?=$level?>', 'hockey')">하키</button>
                <button type="button" class="tablinks" onclick="openCity(event, 'cross', '<?=$level?>', 'etc')">기타</button>
            </div>
            <div id="cross<?=$level?>_soccer" class="tabcontent<?=$level?>" style="display: block">
                <h3>크로스 (축구)</h3>
                <span style="margin-left: 40px">승패+오버:</span>
                <input type="radio" name="cross_soccer_wl_over" value="0" <?php if($TPL_V["cross_soccer_wl_over"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_soccer_wl_over" value="1" <?php if($TPL_V["cross_soccer_wl_over"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">승패+언더:</span>
                <input type="radio" name="cross_soccer_wl_under" value="0" <?php if($TPL_V["cross_soccer_wl_under"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_soccer_wl_under" value="1" <?php if($TPL_V["cross_soccer_wl_under"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">승패+핸디:</span>
                <input type="radio" name="cross_soccer_wl_h" value="0" <?php if($TPL_V["cross_soccer_wl_h"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_soccer_wl_h" value="1" <?php if($TPL_V["cross_soccer_wl_h"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">무+오버:</span>
                <input type="radio" name="cross_soccer_d_over" value="0" <?php if($TPL_V["cross_soccer_d_over"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_soccer_d_over" value="1" <?php if($TPL_V["cross_soccer_d_over"]==1){?> checked <?php }?>> Off
                
                <span style="margin-left: 40px">무+언더:</span>
                <input type="radio" name="cross_soccer_d_under" value="0" <?php if($TPL_V["cross_soccer_d_under"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_soccer_d_under" value="1" <?php if($TPL_V["cross_soccer_d_under"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">핸디+오버/언더:</span>
                <input type="radio" name="cross_soccer_h_unov" value="0" <?php if($TPL_V["cross_soccer_h_unov"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_soccer_h_unov" value="1" <?php if($TPL_V["cross_soccer_h_unov"]==1){?> checked <?php }?>> Off
                
            </div>
            <div id="cross<?=$level?>_baseball" class="tabcontent<?=$level?>">
                <h3>크로스 (야구)</h3>
                <span style="margin-left: 40px">승패+오버:</span>
                <input type="radio" name="cross_baseball_wl_over" value="0" <?php if($TPL_V["cross_baseball_wl_over"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_baseball_wl_over" value="1" <?php if($TPL_V["cross_baseball_wl_over"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">승패+언더:</span>
                <input type="radio" name="cross_baseball_wl_under" value="0" <?php if($TPL_V["cross_baseball_wl_under"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_baseball_wl_under" value="1" <?php if($TPL_V["cross_baseball_wl_under"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">승패+핸디:</span>
                <input type="radio" name="cross_baseball_wl_h" value="0" <?php if($TPL_V["cross_baseball_wl_h"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_baseball_wl_h" value="1" <?php if($TPL_V["cross_baseball_wl_h"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">핸디+오버/언더:</span>
                <input type="radio" name="cross_baseball_h_unov" value="0" <?php if($TPL_V["cross_baseball_h_unov"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_baseball_h_unov" value="1" <?php if($TPL_V["cross_baseball_h_unov"]==1){?> checked <?php }?>> Off
                
            </div>
            <div id="cross<?=$level?>_basketball" class="tabcontent<?=$level?>">
                <h3>크로스 (농구)</h3>
                <span style="margin-left: 40px">승패+오버:</span>
                <input type="radio" name="cross_basketball_wl_over" value="0" <?php if($TPL_V["cross_basketball_wl_over"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_basketball_wl_over" value="1" <?php if($TPL_V["cross_basketball_wl_over"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">승패+언더:</span>
                <input type="radio" name="cross_basketball_wl_under" value="0" <?php if($TPL_V["cross_basketball_wl_under"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_basketball_wl_under" value="1" <?php if($TPL_V["cross_basketball_wl_under"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">승패+핸디:</span>
                <input type="radio" name="cross_basketball_wl_h" value="0" <?php if($TPL_V["cross_basketball_wl_h"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_basketball_wl_h" value="1" <?php if($TPL_V["cross_basketball_wl_h"]==1){?> checked <?php }?>> Off
                

                <span style="margin-left: 40px">핸디+오버/언더:</span>
                <input type="radio" name="cross_basketball_h_unov" value="0" <?php if($TPL_V["cross_basketball_h_unov"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_basketball_h_unov" value="1" <?php if($TPL_V["cross_basketball_h_unov"]==1){?> checked <?php }?>> Off
                
            </div>
            <div id="cross<?=$level?>_volleyball" class="tabcontent<?=$level?>">
                <h3>크로스 (배구)</h3>
                <span style="margin-left: 40px">승패+오버:</span>
                <input type="radio" name="cross_volleyball_wl_over" value="0" <?php if($TPL_V["cross_volleyball_wl_over"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_volleyball_wl_over" value="1" <?php if($TPL_V["cross_volleyball_wl_over"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">승패+언더:</span>
                <input type="radio" name="cross_volleyball_wl_under" value="0" <?php if($TPL_V["cross_volleyball_wl_under"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_volleyball_wl_under" value="1" <?php if($TPL_V["cross_volleyball_wl_under"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">승패+핸디:</span>
                <input type="radio" name="cross_volleyball_wl_h" value="0" <?php if($TPL_V["cross_volleyball_wl_h"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_volleyball_wl_h" value="1" <?php if($TPL_V["cross_volleyball_wl_h"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">핸디+오버/언더:</span>
                <input type="radio" name="cross_volleyball_h_unov" value="0" <?php if($TPL_V["cross_volleyball_h_unov"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_volleyball_h_unov" value="1" <?php if($TPL_V["cross_volleyball_h_unov"]==1){?> checked <?php }?>> Off
                
            </div>
            <div id="cross<?=$level?>_hockey" class="tabcontent<?=$level?>">
                <h3>크로스 (하키)</h3>
                <span style="margin-left: 40px">승패+오버:</span>
                <input type="radio" name="cross_hockey_wl_over" value="0" <?php if($TPL_V["cross_hockey_wl_over"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_hockey_wl_over" value="1" <?php if($TPL_V["cross_hockey_wl_over"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">승패+언더:</span>
                <input type="radio" name="cross_hockey_wl_under" value="0" <?php if($TPL_V["cross_hockey_wl_under"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_hockey_wl_under" value="1" <?php if($TPL_V["cross_hockey_wl_under"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">승패+핸디:</span>
                <input type="radio" name="cross_hockey_wl_h" value="0" <?php if($TPL_V["cross_hockey_wl_h"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_hockey_wl_h" value="1" <?php if($TPL_V["cross_hockey_wl_h"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">핸디+오버/언더:</span>
                <input type="radio" name="cross_hockey_h_unov" value="0" <?php if($TPL_V["cross_hockey_h_unov"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_hockey_h_unov" value="1" <?php if($TPL_V["cross_hockey_h_unov"]==1){?> checked <?php }?>> Off
                
            </div>
            <div id="cross<?=$level?>_etc" class="tabcontent<?=$level?>">
                <h3>크로스 (기타)</h3>
                <span style="margin-left: 40px">승패+오버:</span>
                <input type="radio" name="cross_etc_wl_over" value="0" <?php if($TPL_V["cross_etc_wl_over"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_etc_wl_over" value="1" <?php if($TPL_V["cross_etc_wl_over"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">승패+언더:</span>
                <input type="radio" name="cross_etc_wl_under" value="0" <?php if($TPL_V["cross_etc_wl_under"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_etc_wl_under" value="1" <?php if($TPL_V["cross_etc_wl_under"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">승패+핸디:</span>
                <input type="radio" name="cross_etc_wl_h" value="0" <?php if($TPL_V["cross_etc_wl_h"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_etc_wl_h" value="1" <?php if($TPL_V["cross_etc_wl_h"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">핸디+오버/언더:</span>
                <input type="radio" name="cross_etc_h_unov" value="0" <?php if($TPL_V["cross_etc_h_unov"]==0){?> checked <?php }?>> On
                <input type="radio" name="cross_etc_h_unov" value="1" <?php if($TPL_V["cross_etc_h_unov"]==1){?> checked <?php }?>> Off
            </div>
        </div>

        <div id="handi<?=$level?>" class="tabcontent<?=$level?>" style="margin-bottom: 40px;">
            <div class="tab">
                <button type="button" class="tablinks" onclick="openCity(event, 'handi', '<?=$level?>', 'soccer')">축구</button>
                <button type="button" class="tablinks" onclick="openCity(event, 'handi', '<?=$level?>', 'baseball')">야구</button>
                <button type="button" class="tablinks" onclick="openCity(event, 'handi', '<?=$level?>', 'basketball')">농구</button>
                <button type="button" class="tablinks" onclick="openCity(event, 'handi', '<?=$level?>', 'volleyball')">배구</button>
                <button type="button" class="tablinks" onclick="openCity(event, 'handi', '<?=$level?>', 'hockey')">하키</button>
                <button type="button" class="tablinks" onclick="openCity(event, 'handi', '<?=$level?>', 'etc')">기타</button>
            </div>
            <div id="handi<?=$level?>_soccer" class="tabcontent<?=$level?>" style="display: block">
                <h3>핸디캡 (축구)</h3>
                <span style="margin-left: 40px">승패+오버:</span>
                <input type="radio" name="handi_soccer_wl_over" value="0" <?php if($TPL_V["handi_soccer_wl_over"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_soccer_wl_over" value="1" <?php if($TPL_V["handi_soccer_wl_over"]==1){?> checked <?php }?>> Off
                

                <span style="margin-left: 40px">승패+언더:</span>
                <input type="radio" name="handi_soccer_wl_under" value="0" <?php if($TPL_V["handi_soccer_wl_under"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_soccer_wl_under" value="1" <?php if($TPL_V["handi_soccer_wl_under"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">승패+핸디:</span>
                <input type="radio" name="handi_soccer_wl_h" value="0" <?php if($TPL_V["handi_soccer_wl_h"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_soccer_wl_h" value="1" <?php if($TPL_V["handi_soccer_wl_h"]==1){?> checked <?php }?>> Off
                

                <span style="margin-left: 40px">무+오버:</span>
                <input type="radio" name="handi_soccer_d_over" value="0" <?php if($TPL_V["handi_soccer_d_over"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_soccer_d_over" value="1" <?php if($TPL_V["handi_soccer_d_over"]==1){?> checked <?php }?>> Off
                

                <span style="margin-left: 40px">무+언더:</span>
                <input type="radio" name="handi_soccer_d_under" value="0" <?php if($TPL_V["handi_soccer_d_under"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_soccer_d_under" value="1" <?php if($TPL_V["handi_soccer_d_under"]==1){?> checked <?php }?>> Off
                

                <span style="margin-left: 40px">핸디+오버/언더:</span>
                <input type="radio" name="handi_soccer_h_unov" value="0" <?php if($TPL_V["handi_soccer_h_unov"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_soccer_h_unov" value="1" <?php if($TPL_V["handi_soccer_h_unov"]==1){?> checked <?php }?>> Off
                
            </div>
            <div id="handi<?=$level?>_baseball" class="tabcontent<?=$level?>">
                <h3>핸디캡 (야구)</h3>
                <span style="margin-left: 40px">승패+오버:</span>
                <input type="radio" name="handi_baseball_wl_over" value="0" <?php if($TPL_V["handi_baseball_wl_over"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_baseball_wl_over" value="1" <?php if($TPL_V["handi_baseball_wl_over"]==1){?> checked <?php }?>> Off
                

                <span style="margin-left: 40px">승패+언더:</span>
                <input type="radio" name="handi_baseball_wl_under" value="0" <?php if($TPL_V["handi_baseball_wl_under"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_baseball_wl_under" value="1" <?php if($TPL_V["handi_baseball_wl_under"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">승패+핸디:</span>
                <input type="radio" name="handi_baseball_wl_h" value="0" <?php if($TPL_V["handi_baseball_wl_h"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_baseball_wl_h" value="1" <?php if($TPL_V["handi_baseball_wl_h"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">핸디+오버/언더:</span>
                <input type="radio" name="handi_baseball_h_unov" value="0" <?php if($TPL_V["handi_baseball_h_unov"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_baseball_h_unov" value="1" <?php if($TPL_V["handi_baseball_h_unov"]==1){?> checked <?php }?>> Off
                
            </div>
            <div id="handi<?=$level?>_basketball" class="tabcontent<?=$level?>">
                <h3>핸디캡 (농구)</h3>
                <span style="margin-left: 40px">승패+오버:</span>
                <input type="radio" name="handi_basketball_wl_over" value="0" <?php if($TPL_V["handi_basketball_wl_over"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_basketball_wl_over" value="1" <?php if($TPL_V["handi_basketball_wl_over"]==1){?> checked <?php }?>> Off
                

                <span style="margin-left: 40px">승패+언더:</span>
                <input type="radio" name="handi_basketball_wl_under" value="0" <?php if($TPL_V["handi_basketball_wl_under"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_basketball_wl_under" value="1" <?php if($TPL_V["handi_basketball_wl_under"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">승패+핸디:</span>
                <input type="radio" name="handi_basketball_wl_h" value="0" <?php if($TPL_V["handi_basketball_wl_h"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_basketball_wl_h" value="1" <?php if($TPL_V["handi_basketball_wl_h"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">핸디+오버/언더:</span>
                <input type="radio" name="handi_basketball_h_unov" value="0" <?php if($TPL_V["handi_basketball_h_unov"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_basketball_h_unov" value="1" <?php if($TPL_V["handi_basketball_h_unov"]==1){?> checked <?php }?>> Off
                
            </div>
            <div id="handi<?=$level?>_volleyball" class="tabcontent<?=$level?>">
                <h3>핸디캡 (배구)</h3>
                <span style="margin-left: 40px">승패+오버:</span>
                <input type="radio" name="handi_volleyball_wl_over" value="0" <?php if($TPL_V["handi_volleyball_wl_over"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_volleyball_wl_over" value="1" <?php if($TPL_V["handi_volleyball_wl_over"]==1){?> checked <?php }?>> Off
                

                <span style="margin-left: 40px">승패+언더:</span>
                <input type="radio" name="handi_volleyball_wl_under" value="0" <?php if($TPL_V["handi_volleyball_wl_under"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_volleyball_wl_under" value="1" <?php if($TPL_V["handi_volleyball_wl_under"]==1){?> checked <?php }?>> Off
                
                <span style="margin-left: 40px">승패+핸디:</span>
                <input type="radio" name="handi_volleyball_wl_h" value="0" <?php if($TPL_V["handi_volleyball_wl_h"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_volleyball_wl_h" value="1" <?php if($TPL_V["handi_volleyball_wl_h"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">핸디+오버/언더:</span>
                <input type="radio" name="handi_volleyball_h_unov" value="0" <?php if($TPL_V["handi_volleyball_h_unov"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_volleyball_h_unov" value="1" <?php if($TPL_V["handi_volleyball_h_unov"]==1){?> checked <?php }?>> Off
                
            </div>
            <div id="handi<?=$level?>_hockey" class="tabcontent<?=$level?>">
                <h3>핸디캡 (하키)</h3>
                <span style="margin-left: 40px">승패+오버:</span>
                <input type="radio" name="handi_hockey_wl_over" value="0" <?php if($TPL_V["handi_hockey_wl_over"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_hockey_wl_over" value="1" <?php if($TPL_V["handi_hockey_wl_over"]==1){?> checked <?php }?>> Off
                

                <span style="margin-left: 40px">승패+언더:</span>
                <input type="radio" name="handi_hockey_wl_under" value="0" <?php if($TPL_V["handi_hockey_wl_under"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_hockey_wl_under" value="1" <?php if($TPL_V["handi_hockey_wl_under"]==1){?> checked <?php }?>> Off
                
                <span style="margin-left: 40px">승패+핸디:</span>
                <input type="radio" name="handi_hockey_wl_h" value="0" <?php if($TPL_V["handi_hockey_wl_h"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_hockey_wl_h" value="1" <?php if($TPL_V["handi_hockey_wl_h"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">핸디+오버/언더:</span>
                <input type="radio" name="handi_hockey_h_unov" value="0" <?php if($TPL_V["handi_hockey_h_unov"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_hockey_h_unov" value="1" <?php if($TPL_V["handi_hockey_h_unov"]==1){?> checked <?php }?>> Off
                
            </div>
            <div id="handi<?=$level?>_etc" class="tabcontent<?=$level?>">
                <h3>핸디캡 (기타)</h3>
                <span style="margin-left: 40px">승패+오버:</span>
                <input type="radio" name="handi_etc_wl_over" value="0" <?php if($TPL_V["handi_etc_wl_over"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_etc_wl_over" value="1" <?php if($TPL_V["handi_etc_wl_over"]==1){?> checked <?php }?>> Off
                

                <span style="margin-left: 40px">승패+언더:</span>
                <input type="radio" name="handi_etc_wl_under" value="0" <?php if($TPL_V["handi_etc_wl_under"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_etc_wl_under" value="1" <?php if($TPL_V["handi_etc_wl_under"]==1){?> checked <?php }?>> Off
                
                <span style="margin-left: 40px">승패+핸디:</span>
                <input type="radio" name="handi_etc_wl_h" value="0" <?php if($TPL_V["handi_etc_wl_h"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_etc_wl_h" value="1" <?php if($TPL_V["handi_etc_wl_h"]==1){?> checked <?php }?>> Off

                <span style="margin-left: 40px">핸디+오버/언더:</span>
                <input type="radio" name="handi_etc_h_unov" value="0" <?php if($TPL_V["handi_etc_h_unov"]==0){?> checked <?php }?>> On
                <input type="radio" name="handi_etc_h_unov" value="1" <?php if($TPL_V["handi_etc_h_unov"]==1){?> checked <?php }?>> Off
                
            </div>
        </div>

    </form>
    <?php }?>

</div>