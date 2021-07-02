<script>
    function confirmOk()
    {
        fm = document.frm;
        fm.action = "/config/miniUseConfigProcess";
        fm.submit();
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
            <tr>
                <th width="20%">사다리</th>
                <td>
                    <input type="radio" name="sadari_use" value="1" <?php if($TPL_VAR["list"]["sadari_use"]==1){?> checked <?php }?>> 사용
                    <input type="radio" name="sadari_use" value="0" <?php if($TPL_VAR["list"]["sadari_use"]==0){?> checked <?php }?>> 미사용
                </td>
            </tr>
            <tr>
                <th width="20%">다리다리</th>
                <td>
                    <input type="radio" name="dari_use" value="1" <?php if($TPL_VAR["list"]["dari_use"]==1){?> checked <?php }?>> 사용
                    <input type="radio" name="dari_use" value="0" <?php if($TPL_VAR["list"]["dari_use"]==0){?> checked <?php }?>> 미사용
                </td>
            </tr>
            <tr>
                <th width="20%">파워볼</th>
                <td>
                    <input type="radio" name="power_use" value="1" <?php if($TPL_VAR["list"]["power_use"]==1){?> checked <?php }?>> 사용
                    <input type="radio" name="power_use" value="0" <?php if($TPL_VAR["list"]["power_use"]==0){?> checked <?php }?>> 미사용
                </td>
            </tr>
            <tr>
                <th width="20%">달팽이</th>
                <td>
                    <input type="radio" name="race_use" value="1" <?php if($TPL_VAR["list"]["race_use"]==1){?> checked <?php }?>> 사용
                    <input type="radio" name="race_use" value="0" <?php if($TPL_VAR["list"]["race_use"]==0){?> checked <?php }?>> 미사용
                </td>
            </tr>
            <tr>
                <th width="20%">파워사다리</th>
                <td>
                    <input type="radio" name="powersadari_use" value="1" <?php if($TPL_VAR["list"]["powersadari_use"]==1){?> checked <?php }?>> 사용
                    <input type="radio" name="powersadari_use" value="0" <?php if($TPL_VAR["list"]["powersadari_use"]==0){?> checked <?php }?>> 미사용
                </td>
            </tr>
            <tr>
                <th width="20%">키노사다리</th>
                <td>
                    <input type="radio" name="kenosadari_use" value="1" <?php if($TPL_VAR["list"]["kenosadari_use"]==1){?> checked <?php }?>> 사용
                    <input type="radio" name="kenosadari_use" value="0" <?php if($TPL_VAR["list"]["kenosadari_use"]==0){?> checked <?php }?>> 미사용
                </td>
            </tr>
            <tr>
                <th width="20%">이다리</th>
                <td>
                    <input type="radio" name="dari2_use" value="1" <?php if($TPL_VAR["list"]["dari2_use"]==1){?> checked <?php }?>> 사용
                    <input type="radio" name="dari2_use" value="0" <?php if($TPL_VAR["list"]["dari2_use"]==0){?> checked <?php }?>> 미사용
                </td>
            </tr>
            <tr>
                <th width="20%">삼다리</th>
                <td>
                    <input type="radio" name="dari3_use" value="1" <?php if($TPL_VAR["list"]["dari3_use"]==1){?> checked <?php }?>> 사용
                    <input type="radio" name="dari3_use" value="0" <?php if($TPL_VAR["list"]["dari3_use"]==0){?> checked <?php }?>> 미사용
                </td>
            </tr>
            <tr>
                <th width="20%">초이스</th>
                <td>
                    <input type="radio" name="choice_use" value="1" <?php if($TPL_VAR["list"]["choice_use"]==1){?> checked <?php }?>> 사용
                    <input type="radio" name="choice_use" value="0" <?php if($TPL_VAR["list"]["choice_use"]==0){?> checked <?php }?>> 미사용
                </td>
            </tr>
            <tr>
                <th width="20%">룰렛</th>
                <td>
                    <input type="radio" name="roulette_use" value="1" <?php if($TPL_VAR["list"]["roulette_use"]==1){?> checked <?php }?>> 사용
                    <input type="radio" name="roulette_use" value="0" <?php if($TPL_VAR["list"]["roulette_use"]==0){?> checked <?php }?>> 미사용
                </td>
            </tr>
            <tr>
                <th width="20%">파라오</th>
                <td>
                    <input type="radio" name="pharah_use" value="1" <?php if($TPL_VAR["list"]["pharah_use"]==1){?> checked <?php }?>> 사용
                    <input type="radio" name="pharah_use" value="0" <?php if($TPL_VAR["list"]["pharah_use"]==0){?> checked <?php }?>> 미사용
                </td>
            </tr>
            <tr>
                <th width="20%">크라운바카라</th>
                <td>
                    <input type="radio" name="crownbaccara_use" value="1" <?php if($TPL_VAR["list"]["crownbaccara_use"]==1){?> checked <?php }?>> 사용
                    <input type="radio" name="crownbaccara_use" value="0" <?php if($TPL_VAR["list"]["crownbaccara_use"]==0){?> checked <?php }?>> 미사용
                </td>
            </tr>
            <tr>
                <th width="20%">크라운홀짝</th>
                <td>
                    <input type="radio" name="crownodd_use" value="1" <?php if($TPL_VAR["list"]["crownodd_use"]==1){?> checked <?php }?>> 사용
                    <input type="radio" name="crownodd_use" value="0" <?php if($TPL_VAR["list"]["crownodd_use"]==0){?> checked <?php }?>> 미사용
                </td>
            </tr>
            <tr>
                <th width="20%">크라운나인볼</th>
                <td>
                    <input type="radio" name="crownnine_use" value="1" <?php if($TPL_VAR["list"]["crownnine_use"]==1){?> checked <?php }?>> 사용
                    <input type="radio" name="crownnine_use" value="0" <?php if($TPL_VAR["list"]["crownnine_use"]==0){?> checked <?php }?>> 미사용
                </td>
            </tr>
            <tr>
                <th width="20%">FX</th>
                <td>
                    <input type="radio" name="fx_use" value="1" <?php if($TPL_VAR["list"]["fx_use"]==1){?> checked <?php }?>> 사용
                    <input type="radio" name="fx_use" value="0" <?php if($TPL_VAR["list"]["fx_use"]==0){?> checked <?php }?>> 미사용
                </td>
            </tr>
        </table>

        <div id="wrap_btn">
            <input type="button" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" value="저  장" onclick="confirmOk();"/>
        </div>
    </form>

</div>