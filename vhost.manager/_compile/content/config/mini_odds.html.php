<?php
$TPL_config_rows_1=empty($TPL_VAR["config_rows"])||!is_array($TPL_VAR["config_rows"])?0:count($TPL_VAR["config_rows"]);
?>
<script>
    function confirmOk()
    {
        fm = document.frm;
        fm.action = "/config/minioddsProcess";
        fm.submit();
        // if(fm.sadari_oe.value=="" || fm.sadari_line.value=="" ||
        //     fm.sadari_lr.value=="" || fm.sadari_oeline_lr.value=="")
        // {
        //     alert("사다리 배당을 입력해 주세요.");
        // }
        // else if(fm.dari_oe.value=="" || fm.dari_line.value=="" ||
        //     fm.dari_lr.value=="" || fm.dari_oeline_lr.value=="")
        // {
        //     alert("다리다리 배당을 입력해 주세요.");
        // }
        // else if(fm.pb_n_oe.value=="" || fm.pb_n_uo.value=="" || fm.pb_p_oe.value=="" || fm.pb_p_uo.value=="" ||
        //     fm.pb_n_bs_a.value=="" || fm.pb_n_bs_d.value=="" || fm.pb_n_bs_h.value=="" || fm.pb_p_n.value=="" ||
        //     fm.pb_p_02.value=="" || fm.pb_p_34.value=="" || fm.pb_p_56.value=="" || fm.pb_p_79.value=="" ||
        //     fm.pb_p_o_un.value=="" || fm.pb_p_e_un.value=="" || fm.pb_p_o_ov.value=="" || fm.pb_p_e_ov.value=="" ||
        //     fm.pb_n_o_un.value=="" || fm.pb_n_e_un.value=="" || fm.pb_n_o_ov.value=="" || fm.pb_n_e_ov.value=="")
        // {
        //     alert("파워볼 배당을 입력해 주세요.");
        // }
        // else if(fm.ps_oe.value=="" || fm.ps_lr.value=="" ||
        //     fm.ps_line.value=="" || fm.ps_oeline_lr.value=="")
        // {
        //     alert("파워사다리 배당을 입력해 주세요.");
        // }
        // else if(fm.ks_oe.value=="" || fm.ks_lr.value=="" ||
        //     fm.ks_line.value=="" || fm.ks_oeline_lr.value=="")
        // {
        //     alert("키노사다리 배당을 입력해 주세요.");
        // }
        // else if(fm.d2_oe.value=="" || fm.d2_lr.value=="" ||
        //     fm.d2_line.value=="" || fm.d2_oeline_lr.value=="")
        // {
        //     alert("이다리 배당을 입력해 주세요.");
        // }
        // else if(fm.d3_oe.value=="" || fm.d3_lr.value=="" ||
        //     fm.d3_line.value=="" || fm.d3_oeline_lr.value=="")
        // {
        //     alert("삼다리 배당을 입력해 주세요.");
        // }
        // else if(fm.choice_bw.value=="")
        // {
        //     alert("초이스 배당을 입력해 주세요.");
        // }
        // else if(fm.roulette_rb.value=="")
        // {
        //     alert("룰렛 배당을 입력해 주세요.");
        // }
        // else if(fm.pharaoh_hs.value=="")
        // {
        //     alert("파라오 배당을 입력해 주세요.");
        // }
        // else if(fm.nine_oe.value=="" || fm.nine_lr.value=="" || fm.nine_t.value=="")
        // {
        //     alert("크라운 나인볼 배당을 입력해 주세요.");
        // }
        // else if(fm.mb_player.value=="" || fm.mb_banker.value=="" || fm.mb_pp_pb.value=="" || fm.mb_t.value=="")
        // {
        //     alert("크라운 바카라 배당을 입력해 주세요.");
        // }
        // else if(fm.moe_oe.value=="" || fm.moe_uo.value=="" || fm.moe_br.value=="")
        // {
        //     alert("크라운 홀짝 배당을 입력해 주세요.");
        // }
        // else
        // {
        //     fm.action = "/config/minioddsProcess";
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

    function onChangeLevel(level)
    {
        location.href = "/config/miniodds?lev="+level;
    }
</script>

<div class="wrap">

    <form  method="post" name="frm">
        <div id="route">
            <h5>관리자 시스템 > 미니게임 관리 > <b>미니게임 배당설정</b></h5>
        </div>

        <h3>미니게임 배당설정</h3>
        <div id="wrap_btn">
            <input type="button" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" value="저  장" onclick="confirmOk();"/>
            <span>
                레벨
                <select style="width:70px" name="lev" onChange="onChangeLevel(this.value);">
                    <?php if($TPL_config_rows_1){foreach($TPL_VAR["config_rows"] as $TPL_V2){?>
                        <option value="<?php echo $TPL_V2["lev"]?>" <?php if($TPL_VAR["lev"]==$TPL_V2["lev"]){?>selected<?php }?>><?php echo $TPL_V2["lev_name"]?></option>
                    <?php }}?>
                </select>
            </span>
        </div>

        <table cellspacing="1" class="tableStyle_membersWrite" summary="미니게임 배당설정">
            <legend class="blind">미니게임 배당설정</legend>
            <?php if($TPL_VAR["minigameSetting"]["sadari_use"]==1){?>
            <tr>
                <th>사다리</th>
                <td>
                    <span style="margin-left: 20px">홀/짝:</span> <input type="text" class="w60" name="sadari_oe" style="text-align: right" value="<?php echo $TPL_VAR["list"]["sadari_oe"]?>" size="10" />
                    <span style="margin-left: 20px">좌/우:</span> <input type="text" class="w60" name="sadari_lr" style="text-align: right" value="<?php echo $TPL_VAR["list"]["sadari_lr"]?>" size="10" />
                    <span style="margin-left: 20px">3/4줄:</span> <input type="text" class="w60" name="sadari_line" style="text-align: right" value="<?php echo $TPL_VAR["list"]["sadari_line"]?>" size="10" />
                    <span style="margin-left: 20px">짝3/홀4/짝4/홀3:</span> <input type="text" class="w60" name="sadari_oeline_lr" style="text-align: right" value="<?php echo $TPL_VAR["list"]["sadari_oeline_lr"]?>" size="10" />
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["minigameSetting"]["dari_use"]==1){?>
            <tr>
                <th>다리다리</th>
                <td>
                    <span style="margin-left: 20px">홀/짝:</span> <input type="text" class="w60" name="dari_oe" style="text-align: right" value="<?php echo $TPL_VAR["list"]["dari_oe"]?>" size="10" />
                    <span style="margin-left: 20px">좌/우:</span> <input type="text" class="w60" name="dari_lr" style="text-align: right" value="<?php echo $TPL_VAR["list"]["dari_lr"]?>" size="10" />
                    <span style="margin-left: 20px">3/4줄:</span> <input type="text" class="w60" name="dari_line" style="text-align: right" value="<?php echo $TPL_VAR["list"]["dari_line"]?>" size="10" />
                    <span style="margin-left: 20px">짝3/홀4/짝4/홀3:</span> <input type="text" class="w60" name="dari_oeline_lr" style="text-align: right" value="<?php echo $TPL_VAR["list"]["dari_oeline_lr"]?>" size="10" />
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["minigameSetting"]["power_use"]==1){?>
            <tr>
                <th>파워볼</th>
                <td>
                    <div style="margin-top: 5px">
                        <span style="margin-left: 20px">일반볼 홀/짝:</span> <input type="text" class="w40" name="pb_n_oe" style="text-align: right" value="<?php echo $TPL_VAR["list"]["pb_n_oe"]?>" size="10" />
                        <span style="margin-left: 20px">일반볼 언/오:</span> <input type="text" class="w40" name="pb_n_uo" style="text-align: right" value="<?php echo $TPL_VAR["list"]["pb_n_uo"]?>" size="10" />
                    </div>
                    <div style="margin-top: 5px">
                        <span style="margin-left: 20px">일반볼 홀언더:</span> <input type="text" class="w40" name="pb_n_o_un" style="text-align: right" value="<?php echo $TPL_VAR["list"]["pb_n_o_un"]?>" size="10" />
                        <span style="margin-left: 20px">일반볼 짝언더:</span> <input type="text" class="w40" name="pb_n_e_un" style="text-align: right" value="<?php echo $TPL_VAR["list"]["pb_n_e_un"]?>" size="10" />
                        <span style="margin-left: 20px">일반볼 홀오버:</span> <input type="text" class="w40" name="pb_n_o_ov" style="text-align: right" value="<?php echo $TPL_VAR["list"]["pb_n_o_ov"]?>" size="10" />
                        <span style="margin-left: 20px">일반볼 짝오버:</span> <input type="text" class="w40" name="pb_n_e_ov" style="text-align: right" value="<?php echo $TPL_VAR["list"]["pb_n_e_ov"]?>" size="10" />
                    </div>
                    <!-- <div style="margin-top: 5px">
                        <span style="margin-left: 20px;margin-right: 17px;">일반볼 소:</span> <input type="text" class="w40" name="pb_n_bs_a" style="text-align: right" value="<?php echo $TPL_VAR["list"]["pb_n_bs_a"]?>" size="10" />
                        <span style="margin-left: 20px;margin-right: 17px;">일반볼 중:</span> <input type="text" class="w40" name="pb_n_bs_d" style="text-align: right" value="<?php echo $TPL_VAR["list"]["pb_n_bs_d"]?>" size="10" />
                        <span style="margin-left: 20px;margin-right: 17px;">일반볼 대:</span> <input type="text" class="w40" name="pb_n_bs_h" style="text-align: right" value="<?php echo $TPL_VAR["list"]["pb_n_bs_h"]?>" size="10" />
                    </div> -->
                    <div style="margin-top: 5px">
                        <span style="margin-left: 20px">파워볼 홀/짝:</span> <input type="text" class="w40" name="pb_p_oe" style="text-align: right" value="<?php echo $TPL_VAR["list"]["pb_p_oe"]?>" size="10" />
                        <span style="margin-left: 20px">파워볼 언/오:</span> <input type="text" class="w40" name="pb_p_uo" style="text-align: right" value="<?php echo $TPL_VAR["list"]["pb_p_uo"]?>" size="10" />
                    </div>
                    <!-- <div style="margin-top: 5px">
                        <span style="margin-left: 20px">파워볼 숫자:</span> <input type="text" class="w40" name="pb_p_n" style="text-align: right" value="<?php echo $TPL_VAR["list"]["pb_p_n"]?>" size="10" />
                    </div> 
                    <div style="margin-top: 5px">
                        <span style="margin-left: 20px">파워볼구간(0~2):</span> <input type="text" class="w40" name="pb_p_02" style="text-align: right" value="<?php echo $TPL_VAR["list"]["pb_p_02"]?>" size="10" />
                        <span style="margin-left: 20px">파워볼구간(3~4):</span> <input type="text" class="w40" name="pb_p_34" style="text-align: right" value="<?php echo $TPL_VAR["list"]["pb_p_34"]?>" size="10" />
                        <span style="margin-left: 20px">파워볼구간(5~6):</span> <input type="text" class="w40" name="pb_p_56" style="text-align: right" value="<?php echo $TPL_VAR["list"]["pb_p_56"]?>" size="10" />
                        <span style="margin-left: 20px">파워볼구간(7~9):</span> <input type="text" class="w40" name="pb_p_79" style="text-align: right" value="<?php echo $TPL_VAR["list"]["pb_p_79"]?>" size="10" />
                    </div> -->
                    <div style="margin-top: 5px">
                        <span style="margin-left: 20px">파워볼 홀언더:</span> <input type="text" class="w40" name="pb_p_o_un" style="text-align: right" value="<?php echo $TPL_VAR["list"]["pb_p_o_un"]?>" size="10" />
                        <span style="margin-left: 20px">파워볼 짝언더:</span> <input type="text" class="w40" name="pb_p_e_un" style="text-align: right" value="<?php echo $TPL_VAR["list"]["pb_p_e_un"]?>" size="10" />
                        <span style="margin-left: 20px">파워볼 홀오버:</span> <input type="text" class="w40" name="pb_p_o_ov" style="text-align: right" value="<?php echo $TPL_VAR["list"]["pb_p_o_ov"]?>" size="10" />
                        <span style="margin-left: 20px">파워볼 짝오버:</span> <input type="text" class="w40" name="pb_p_e_ov" style="text-align: right" value="<?php echo $TPL_VAR["list"]["pb_p_e_ov"]?>" size="10" />
                    </div>
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["minigameSetting"]["race_use"]==1){?>
            <tr>
                <th>달팽이</th>
                <td>
                    <span style="margin-left: 20px">1등 달팽이:</span> <input type="text" class="w40" name="race_1w" style="text-align: right" value="<?php echo $TPL_VAR["list"]["race_1w"]?>" size="10" />
                    <span style="margin-left: 20px">삼치기:</span> <input type="text" class="w40" name="race_1w2d3l" style="text-align: right" value="<?php echo $TPL_VAR["list"]["race_1w2d3l"]?>" size="10" />
                    <span style="margin-left: 20px">꼴등피하기:</span> <input type="text" class="w40" name="race_1w2w3l" style="text-align: right" value="<?php echo $TPL_VAR["list"]["race_1w2w3l"]?>" size="10" />
                    <span style="margin-left: 20px">달팽이순위:</span> <input type="text" class="w40" name="race_nde" style="text-align: right" value="<?php echo $TPL_VAR["list"]["race_nde"]?>" size="10" />
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["minigameSetting"]["powersadari_use"]==1){?>
            <tr>
                <th>파워사다리</th>
                <td>
                    <span style="margin-left: 20px">홀/짝:</span> <input type="text" class="w60" name="ps_oe" style="text-align: right" value="<?php echo $TPL_VAR["list"]["ps_oe"]?>" size="10" />
                    <span style="margin-left: 20px">좌/우:</span> <input type="text" class="w60" name="ps_lr" style="text-align: right" value="<?php echo $TPL_VAR["list"]["ps_lr"]?>" size="10" />
                    <span style="margin-left: 20px">3/4줄:</span> <input type="text" class="w60" name="ps_line" style="text-align: right" value="<?php echo $TPL_VAR["list"]["ps_line"]?>" size="10" />
                    <span style="margin-left: 20px">짝3/홀4/짝4/홀3:</span> <input type="text" class="w60" name="ps_oeline_lr" style="text-align: right" value="<?php echo $TPL_VAR["list"]["ps_oeline_lr"]?>" size="10" />
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["minigameSetting"]["kenosadari_use"]==1){?>
            <tr>
                <th>키노사다리</th>
                <td>
                    <span style="margin-left: 20px">홀/짝:</span> <input type="text" class="w60" name="ks_oe" style="text-align: right" value="<?php echo $TPL_VAR["list"]["ks_oe"]?>" size="10" />
                    <span style="margin-left: 20px">좌/우:</span> <input type="text" class="w60" name="ks_lr" style="text-align: right" value="<?php echo $TPL_VAR["list"]["ks_lr"]?>" size="10" />
                    <span style="margin-left: 20px">3/4줄:</span> <input type="text" class="w60" name="ks_line" style="text-align: right" value="<?php echo $TPL_VAR["list"]["ks_line"]?>" size="10" />
                    <span style="margin-left: 20px">짝3/홀4/짝4/홀3:</span> <input type="text" class="w60" name="ks_oeline_lr" style="text-align: right" value="<?php echo $TPL_VAR["list"]["ks_oeline_lr"]?>" size="10" />
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["minigameSetting"]["dari2_use"]==1){?>
            <tr>
                <th>이다리</th>
                <td>
                    <span style="margin-left: 20px">홀/짝:</span> <input type="text" class="w60" name="d2_oe" style="text-align: right" value="<?php echo $TPL_VAR["list"]["d2_oe"]?>" size="10" />
                    <span style="margin-left: 20px">좌/우:</span> <input type="text" class="w60" name="d2_lr" style="text-align: right" value="<?php echo $TPL_VAR["list"]["d2_lr"]?>" size="10" />
                    <span style="margin-left: 20px">3/4줄:</span> <input type="text" class="w60" name="d2_line" style="text-align: right" value="<?php echo $TPL_VAR["list"]["d2_line"]?>" size="10" />
                    <span style="margin-left: 20px">짝3/홀4/짝4/홀3:</span> <input type="text" class="w60" name="d2_oeline_lr" style="text-align: right" value="<?php echo $TPL_VAR["list"]["d2_oeline_lr"]?>" size="10" />
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["minigameSetting"]["dari3_use"]==1){?>
            <tr>
                <th>삼다리</th>
                <td>
                    <span style="margin-left: 20px">홀/짝:</span> <input type="text" class="w60" name="d3_oe" style="text-align: right" value="<?php echo $TPL_VAR["list"]["d3_oe"]?>" size="10" />
                    <span style="margin-left: 20px">좌/우:</span> <input type="text" class="w60" name="d3_lr" style="text-align: right" value="<?php echo $TPL_VAR["list"]["d3_lr"]?>" size="10" />
                    <span style="margin-left: 20px">3/4줄:</span> <input type="text" class="w60" name="d3_line" style="text-align: right" value="<?php echo $TPL_VAR["list"]["d3_line"]?>" size="10" />
                    <span style="margin-left: 20px">짝3/홀4/짝4/홀3:</span> <input type="text" class="w60" name="d3_oeline_lr" style="text-align: right" value="<?php echo $TPL_VAR["list"]["d3_oeline_lr"]?>" size="10" />
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["minigameSetting"]["choice_use"]==1){?>
            <tr>
                <th>초이스</th>
                <td>
                    <span style="margin-left: 20px">Black / White:</span> <input type="text" class="w60" name="choice_bw" style="text-align: right" value="<?php echo $TPL_VAR["list"]["choice_bw"]?>" size="10" />
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["minigameSetting"]["roulette_use"]==1){?>
            <tr>
                <th>룰렛</th>
                <td>
                    <span style="margin-left: 20px">Red / Blue:</span> <input type="text" class="w60" name="roulette_rb" style="text-align: right" value="<?php echo $TPL_VAR["list"]["roulette_rb"]?>" size="10" />
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["minigameSetting"]["pharah_use"]==1){?>
            <tr>
                <th>파라오</th>
                <td>
                    <span style="margin-left: 20px">Heart / Spade:</span> <input type="text" class="w60" name="pharaoh_hs" style="text-align: right" value="<?php echo $TPL_VAR["list"]["pharaoh_hs"]?>" size="10" />
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["minigameSetting"]["crownbaccara_use"]==1){?>
            <tr>
                <th>크라운바카라</th>
                <td>
                    <span style="margin-left: 20px">플레이어:</span> <input type="text" class="w60" name="mb_player" style="text-align: right" value="<?php echo $TPL_VAR["list"]["mb_player"]?>" size="10" />
                    <span style="margin-left: 20px">뱅커:</span> <input type="text" class="w60" name="mb_banker" style="text-align: right" value="<?php echo $TPL_VAR["list"]["mb_banker"]?>" size="10" />
                    <span style="margin-left: 20px">플레이어 페어/노페어:</span> <input type="text" class="w60" name="mb_pp_pb" style="text-align: right" value="<?php echo $TPL_VAR["list"]["mb_pp_pb"]?>" size="10" />
                    <span style="margin-left: 20px">타이:</span> <input type="text" class="w60" name="mb_t" style="text-align: right" value="<?php echo $TPL_VAR["list"]["mb_t"]?>" size="10" />
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["minigameSetting"]["crownodd_use"]==1){?>
            <tr>
                <th>크라운홀짝</th>
                <td>
                    <span style="margin-left: 20px">홀/짝:</span> <input type="text" class="w60" name="moe_oe" style="text-align: right" value="<?php echo $TPL_VAR["list"]["moe_oe"]?>" size="10" />
                    <span style="margin-left: 20px">언더/오보:</span> <input type="text" class="w60" name="moe_uo" style="text-align: right" value="<?php echo $TPL_VAR["list"]["moe_uo"]?>" size="10" />
                    <span style="margin-left: 20px">히든볼 Blue/Red:</span> <input type="text" class="w60" name="moe_br" style="text-align: right" value="<?php echo $TPL_VAR["list"]["moe_br"]?>" size="10" />
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["minigameSetting"]["crownnine_use"]==1){?>
            <tr>
                <th>크라운나인볼</th>
                <td>
                    <span style="margin-left: 20px">홀/짝:</span> <input type="text" class="w60" name="nine_oe" style="text-align: right" value="<?php echo $TPL_VAR["list"]["nine_oe"]?>" size="10" />
                    <span style="margin-left: 20px">좌/우:</span> <input type="text" class="w60" name="nine_lr" style="text-align: right" value="<?php echo $TPL_VAR["list"]["nine_lr"]?>" size="10" />
                    <span style="margin-left: 20px">타이/노타이:</span> <input type="text" class="w60" name="nine_t" style="text-align: right" value="<?php echo $TPL_VAR["list"]["nine_t"]?>" size="10" />
                </td>
            </tr>
            <?php } 
            if($TPL_VAR["minigameSetting"]["fx_use"]==1){?>
            <tr>
                <th>Fx</th>
                <td>
                    <span style="margin-left: 20px">매수/매도:</span> <input type="text" class="w60" name="fx_bs" style="text-align: right" value="<?php echo $TPL_VAR["list"]["fx_bs"]?>" size="10" />
                    <span style="margin-left: 20px">종가 홀짝:</span> <input type="text" class="w60" name="fx_uo" style="text-align: right" value="<?php echo $TPL_VAR["list"]["fx_uo"]?>" size="10" />
                    <span style="margin-left: 20px">종가 언오버:</span> <input type="text" class="w60" name="fx_oe" style="text-align: right" value="<?php echo $TPL_VAR["list"]["fx_oe"]?>" size="10" />
                </td>
            </tr>
            <?php } ?>
        </table>

        <div id="wrap_btn">
            <input type="button" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" value="저  장" onclick="confirmOk();"/>
        </div>
    </form>

</div>