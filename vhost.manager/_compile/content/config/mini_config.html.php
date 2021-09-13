<script>
    function confirmOk()
    {
        fm = document.frm;
        fm.action = "/config/miniconfigProcess";
        fm.submit();
        // if(fm.sadari_limit.value=="")
        // {
        //     alert("사다리 배팅마감시간을 입력해 주세요.");
        //     fm.sadari_limit.focus();
        // }
        // else if(fm.dari_limit.value=="")
        // {
        //     alert("다리다리 배팅마감시간을 입력해 주세요.");
        //     fm.dari_limit.focus();
        // }
        // else if(fm.power_limit.value=="")
        // {
        //     alert("파워볼 배팅마감시간을 입력해 주세요.");
        //     fm.power_limit.focus();
        // }
        // else if(fm.race_limit.value=="")
        // {
        //     alert("달팽이 배팅마감시간을 입력해 주세요.");
        //     fm.race_limit.focus();
        // }
        // else if(fm.powersadari_limit.value=="")
        // {
        //     alert("파워사다리 배팅마감시간을 입력해 주세요.");
        //     fm.powersadari_limit.focus();
        // }
        // else if(fm.kenosadari_limit.value=="")
        // {
        //     alert("키노사다리 배팅마감시간을 입력해 주세요.");
        //     fm.kenosadari_limit.focus();
        // }
        // else if(fm.dari2_limit.value=="")
        // {
        //     alert("이다리 배팅마감시간을 입력해 주세요.");
        //     fm.dari2_limit.focus();
        // }
        // else if(fm.dari3_limit.value=="")
        // {
        //     alert("삼다리 배팅마감시간을 입력하여 주세요.");
        //     fm.dari3_limit.focus();
        // }
        // else if(fm.choice.value=="")
        // {
        //     alert("초이스 배팅마감시간을 입력하여 주세요.");
        //     fm.choice.focus();
        // }
        // else if(fm.roulette.value=="")
        // {
        //     alert("룰렛 배팅마감시간을 입력하여 주세요.");
        //     fm.roulette.focus();
        // }
        // else if(fm.pharah_limit.value=="")
        // {
        //     alert("파라오 배팅마감시간을 입력하여 주세요.");
        //     fm.pharah_limit.focus();
        // }
        // else if(fm.crownbaccara_limit.value=="")
        // {
        //     alert("크라운바카라 배팅마감시간을 입력하여 주세요.");
        //     fm.crownbaccara_limit.focus();
        // }
        // else if(fm.crownodd_limit.value=="")
        // {
        //     alert("크라운홀짝 배팅마감시간을 입력하여 주세요.");
        //     fm.crownodd_limit.focus();
        // }
        // else if(fm.crownnine_limit.value=="")
        // {
        //     alert("크라운나인볼 배팅마감시간을 입력하여 주세요.");
        //     fm.crownnine_limit.focus();
        // }
        // else if(fm.fx_limit.value=="")
        // {
        //     alert("FX 배팅마감시간을 입력하여 주세요.");
        //     fm.fx_limit.focus();
        // }
        // else
        // {
        //     fm.action = "/config/miniconfigProcess";
        //     fm.submit();
        // }
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

<div class="wrap">

    <form  method="post" name="frm">
        <div id="route">
            <h5>관리자 시스템 > 미니게임 관리 > <b>미니게임 설정</b></h5>
        </div>

        <h3>미니게임 설정</h3>
        <div id="wrap_btn">
            <input type="button" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" value="저  장" onclick="confirmOk();"/>
        </div>

        <table cellspacing="1" class="tableStyle_membersWrite thBig" summary="미니게임 설정">
            <legend class="blind">미니게임 설정</legend>
            <?php if($TPL_VAR["list"]["sadari_use"]==1){?>
            <tr>
                <th width="20%">사다리</th>
                <td>
                    <input type="radio" name="sadari" value="1" <?php if($TPL_VAR["list"]["sadari"]==1){?> checked <?php }?>> 서비스&nbsp;
                    <input type="radio" name="sadari" value="0" <?php if($TPL_VAR["list"]["sadari"]==0){?> checked <?php }?>> 점검중

                    <span style="margin-left: 40px">배팅마감시간:</span> <input type="number" class="w60" name="sadari_limit" style="text-align: right" value="<?php echo $TPL_VAR["list"]["sadari_limit"]?>" size="10" />초
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["list"]["dari_use"]==1){?>
            <tr>
                <th width="20%">다리다리</th>
                <td>
                    <input type="radio" name="dari" value="1" <?php if($TPL_VAR["list"]["dari"]==1){?> checked <?php }?>> 서비스&nbsp;
                    <input type="radio" name="dari" value="0" <?php if($TPL_VAR["list"]["dari"]==0){?> checked <?php }?>> 점검중

                    <span style="margin-left: 40px">배팅마감시간:</span> <input type="number" class="w60" name="dari_limit" style="text-align: right" value="<?php echo $TPL_VAR["list"]["dari_limit"]?>" size="10" />초
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["list"]["power_use"]==1){?>
            <tr>
                <th width="20%">파워볼</th>
                <td>
                    <div style="display:flex;">
                        <input type="radio" name="power" value="1" <?php if($TPL_VAR["list"]["power"]==1){?> checked <?php }?>> 서비스&nbsp;
                        <input type="radio" name="power" value="0" <?php if($TPL_VAR["list"]["power"]==0){?> checked <?php }?>> 점검중

                        <span style="margin-left: 40px">배팅마감시간:</span> <input type="number" class="w60" name="power_limit" style="text-align: right" value="<?php echo $TPL_VAR["list"]["power_limit"]?>" size="10" />초
                        <div id="power_limit_div">
                            <span style="margin-left: 40px">점검시간:</span>
                            <input type="text" class="w60" name="power_limit_start" style="text-align: right" value="<?php echo $TPL_VAR["list"]["power_limit_start"]?>" size="10" /> ~ 
                            <input type="text" class="w60" name="power_limit_end" style="text-align: right" value="<?php echo $TPL_VAR["list"]["power_limit_end"]?>" size="10" />
                        </div>

                        <div style="margin-left: 40px">
                            <input type="radio" name="power_money_limit" value="1" <?php if($TPL_VAR["list"]["power_money_limit"]==1){?> checked <?php }?>> 회차별 한도
                            <input type="radio" name="power_money_limit" value="0" <?php if($TPL_VAR["list"]["power_money_limit"]==0){?> checked <?php }?>> 픽별 한도
                        </div>
                    </div>
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["list"]["race_use"]==1){?>
            <tr>
                <th width="20%">달팽이</th>
                <td>
                    <input type="radio" name="race" value="1" <?php if($TPL_VAR["list"]["race"]==1){?> checked <?php }?>> 서비스&nbsp;
                    <input type="radio" name="race" value="0" <?php if($TPL_VAR["list"]["race"]==0){?> checked <?php }?>> 점검중

                    <span style="margin-left: 40px">배팅마감시간:</span> <input type="number" class="w60" name="race_limit" style="text-align: right" value="<?php echo $TPL_VAR["list"]["race_limit"]?>" size="10" />초
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["list"]["powersadari_use"]==1){?>
            <tr>
                <th width="20%">파워사다리</th>
                <td>
                    <div style="display:flex;">
                        <input type="radio" name="powersadari" value="1" <?php if($TPL_VAR["list"]["powersadari"]==1){?> checked <?php }?>> 서비스&nbsp;
                        <input type="radio" name="powersadari" value="0" <?php if($TPL_VAR["list"]["powersadari"]==0){?> checked <?php }?>> 점검중

                        <span style="margin-left: 40px">배팅마감시간:</span> 
                        <input type="number" class="w60" name="powersadari_limit" style="text-align: right" value="<?php echo $TPL_VAR["list"]["powersadari_limit"]?>" size="10" />초
                        
                        <div id="powersadari_limit_div">
                            <span style="margin-left: 40px">점검시간:</span> 
                            <input type="text" class="w60" name="powersadari_limit_start" style="text-align: right" value="<?php echo $TPL_VAR["list"]["powersadari_limit_start"]?>" size="10" /> ~ 
                            <input type="text" class="w60" name="powersadari_limit_end" style="text-align: right" value="<?php echo $TPL_VAR["list"]["powersadari_limit_end"]?>" size="10" />
                        </div>

                        <div style="margin-left: 40px">
                            <input type="radio" name="powersadari_money_limit" value="1" <?php if($TPL_VAR["list"]["powersadari_money_limit"]==1){?> checked <?php }?>> 회차별 한도
                            <input type="radio" name="powersadari_money_limit" value="0" <?php if($TPL_VAR["list"]["powersadari_money_limit"]==0){?> checked <?php }?>> 픽별 한도
                        </div>
                    </div>
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["list"]["kenosadari_use"]==1){?>
            <tr>
                <th width="20%">키노사다리</th>
                <td>
                    <input type="radio" name="kenosadari" value="1" <?php if($TPL_VAR["list"]["kenosadari"]==1){?> checked <?php }?>> 서비스&nbsp;
                    <input type="radio" name="kenosadari" value="0" <?php if($TPL_VAR["list"]["kenosadari"]==0){?> checked <?php }?>> 점검중

                    <span style="margin-left: 40px">배팅마감시간:</span> <input type="number" class="w60" name="kenosadari_limit" style="text-align: right" value="<?php echo $TPL_VAR["list"]["kenosadari_limit"]?>" size="10" />초
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["list"]["dari2_use"]==1){?>
            <tr>
                <th width="20%">이다리</th>
                <td>
                    <input type="radio" name="dari2" value="1" <?php if($TPL_VAR["list"]["dari2"]==1){?> checked <?php }?>> 서비스&nbsp;
                    <input type="radio" name="dari2" value="0" <?php if($TPL_VAR["list"]["dari2"]==0){?> checked <?php }?>> 점검중

                    <span style="margin-left: 40px">배팅마감시간:</span> <input type="number" class="w60" name="dari2_limit" style="text-align: right" value="<?php echo $TPL_VAR["list"]["dari2_limit"]?>" size="10" />초
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["list"]["dari3_use"]==1){?>
            <tr>
                <th width="20%">삼다리</th>
                <td>
                    <input type="radio" name="dari3" value="1" <?php if($TPL_VAR["list"]["dari3"]==1){?> checked <?php }?>> 서비스&nbsp;
                    <input type="radio" name="dari3" value="0" <?php if($TPL_VAR["list"]["dari3"]==0){?> checked <?php }?>> 점검중

                    <span style="margin-left: 40px">배팅마감시간:</span> <input type="number" class="w60" name="dari3_limit" style="text-align: right" value="<?php echo $TPL_VAR["list"]["dari3_limit"]?>" size="10" />초
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["list"]["choice_use"]==1){?>
            <tr>
                <th width="20%">초이스</th>
                <td>
                    <input type="radio" name="choice" value="1" <?php if($TPL_VAR["list"]["choice"]==1){?> checked <?php }?>> 서비스&nbsp;
                    <input type="radio" name="choice" value="0" <?php if($TPL_VAR["list"]["choice"]==0){?> checked <?php }?>> 점검중

                    <span style="margin-left: 40px">배팅마감시간:</span> <input type="number" class="w60" name="choice_limit" style="text-align: right" value="<?php echo $TPL_VAR["list"]["choice_limit"]?>" size="10" />초
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["list"]["roulette_use"]==1){?>
            <tr>
                <th width="20%">룰렛</th>
                <td>
                    <input type="radio" name="roulette" value="1" <?php if($TPL_VAR["list"]["roulette"]==1){?> checked <?php }?>> 서비스&nbsp;
                    <input type="radio" name="roulette" value="0" <?php if($TPL_VAR["list"]["roulette"]==0){?> checked <?php }?>> 점검중

                    <span style="margin-left: 40px">배팅마감시간:</span> <input type="number" class="w60" name="roulette_limit" style="text-align: right" value="<?php echo $TPL_VAR["list"]["roulette_limit"]?>" size="10" />초
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["list"]["pharah_use"]==1){?>
            <tr>
                <th width="20%">파라오</th>
                <td>
                    <input type="radio" name="pharah" value="1" <?php if($TPL_VAR["list"]["pharah"]==1){?> checked <?php }?>> 서비스&nbsp;
                    <input type="radio" name="pharah" value="0" <?php if($TPL_VAR["list"]["pharah"]==0){?> checked <?php }?>> 점검중

                    <span style="margin-left: 40px">배팅마감시간:</span> <input type="number" class="w60" name="pharah_limit" style="text-align: right" value="<?php echo $TPL_VAR["list"]["pharah_limit"]?>" size="10" />초
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["list"]["crownbaccara_use"]==1){?>
            <tr>
                <th width="20%">크라운바카라</th>
                <td>
                    <input type="radio" name="crownbaccara" value="1" <?php if($TPL_VAR["list"]["crownbaccara"]==1){?> checked <?php }?>> 서비스&nbsp;
                    <input type="radio" name="crownbaccara" value="0" <?php if($TPL_VAR["list"]["crownbaccara"]==0){?> checked <?php }?>> 점검중

                    <span style="margin-left: 40px">배팅마감시간:</span> <input type="number" class="w60" name="crownbaccara_limit" style="text-align: right" value="<?php echo $TPL_VAR["list"]["crownbaccara_limit"]?>" size="10" />초
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["list"]["crownodd_use"]==1){?>
            <tr>
                <th width="20%">크라운홀짝</th>
                <td>
                    <input type="radio" name="crownodd" value="1" <?php if($TPL_VAR["list"]["crownodd"]==1){?> checked <?php }?>> 서비스&nbsp;
                    <input type="radio" name="crownodd" value="0" <?php if($TPL_VAR["list"]["crownodd"]==0){?> checked <?php }?>> 점검중

                    <span style="margin-left: 40px">배팅마감시간:</span> <input type="number" class="w60" name="crownodd_limit" style="text-align: right" value="<?php echo $TPL_VAR["list"]["crownodd_limit"]?>" size="10" />초
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["list"]["crownnine_use"]==1){?>
            <tr>
                <th width="20%">크라운나인볼</th>
                <td>
                    <input type="radio" name="crownnine" value="1" <?php if($TPL_VAR["list"]["crownnine"]==1){?> checked <?php }?>> 서비스&nbsp;
                    <input type="radio" name="crownnine" value="0" <?php if($TPL_VAR["list"]["crownnine"]==0){?> checked <?php }?>> 점검중

                    <span style="margin-left: 40px">배팅마감시간:</span> <input type="number" class="w60" name="crownnine_limit" style="text-align: right" value="<?php echo $TPL_VAR["list"]["crownnine_limit"]?>" size="10" />초
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["list"]["fx_use"]==1){?>
            <tr>
                <th width="20%">FX</th>
                <td>
                    <input type="radio" name="fx" value="1" <?php if($TPL_VAR["list"]["fx"]==1){?> checked <?php }?>> 서비스&nbsp;
                    <input type="radio" name="fx" value="0" <?php if($TPL_VAR["list"]["fx"]==0){?> checked <?php }?>> 점검중

                    <span style="margin-left: 40px">배팅마감시간:</span> <input type="number" class="w60" name="fx_limit" style="text-align: right" value="<?php echo $TPL_VAR["list"]["fx_limit"]?>" size="10" />초
                </td>
            </tr>
            <?php } ?>
        </table>

        <div id="wrap_btn">
            <input type="button" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" value="저  장" onclick="confirmOk();"/>
        </div>
    </form>

</div>