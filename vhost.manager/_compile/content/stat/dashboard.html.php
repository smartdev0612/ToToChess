
<script language="JavaScript">
    $(document).ready(function () {
        setTimeout(function(){
            refreshDashboard();
        },1000);
    });

    function refreshDashboard() {
        $.ajax({
            url : "/stat/refreshDashboard",
            type : "post",
            cache : false,
            async : false,
            timeout : 5000,
            scriptCharset : "utf-8",
            dataType : "json",
            success: function(res) {
                if ( typeof(res) == "object" ) {
                    refreshDashboardContent(res);
                }
            },
            error: function(xhr,status,error) {
                alert("처리중 오류가 발생 되었습니다. 관리자에게 문의해주세요.");
            }
        });

        // 업데이트 주기(5초)
        setTimeout(function(){
            refreshDashboard();
        },10000);
    }

    function refreshDashboardContent(data) {
        // 어드민 로그인 아이피
        $('#admin_login_ip').html(data['admin_login_ip']);
        // 접속자정보
        var visit_arra_size = data['current_user_list'] == null? 0 : data['current_user_list'].length;

        $('#visit_cnt').html(visit_arra_size);
        $("#tbl_visit_list").find("tr.visit_tr").remove();
        var html = '';
        if(visit_arra_size > 0)
        {
            var idx = 1;
            for ( var key in  data['current_user_list'] ) {
                var item = data['current_user_list'][key];

                html += "<tr class=\"visit_tr\">\n" +
                        "   <td>"+idx+"</td>\n" +
                        "   <td>"+item['uid']+"</td>\n" +
                        "   <td>"+item['mem_lev']+"</td>\n" +
                        "   <td>"+item['login_domain']+"</td>\n" +
                        "</tr>";
                idx++;
            }
        } else {
            html += "<tr class=\"visit_tr\">\n" +
                    "   <td colspan=\"4\">\n" +
                    "           접속한 회원이 없습니다.\n" +
                    "   </td>\n" +
                    "</tr>";
        }
        $("#tbl_visit_list tbody").append(html);

        // main_info
        for ( var key in  data['main_info'] ) {
            var item = data['main_info'][key];
            $('#'+key+'_charge_cnt').html(item['charge_info']['charge_cnt'] +"/"+ item['charge_info']['mem_cnt']);
            $('#'+key+'_exchange_cnt').html(item['exchange_info']['exchange_cnt'] +"/"+ item['exchange_info']['mem_cnt']);
            $('#'+key+'_profit').html(number_format(parseInt(item['charge_info']['amount']) - parseInt(item['exchange_info']['amount'])));
            $('#'+key+'_betting_cnt').html(item['betting_info']['bet_cnt'] +"/"+ item['betting_info']['mem_cnt']);
            $('#'+key+'_cancel_cnt').html(item['betting_cancel_info']['cancel_count']);
            $('#'+key+'_win_cnt').html(number_format(item['betting_info']['win_cnt']));
            $('#'+key+'_new_user').html(item['new_user_info']);
            $('#'+key+'_visit').html(item['visit_info']);
            $('#'+key+'_charge_amt').html(number_format(item['charge_info']['amount']));
            $('#'+key+'_exchange_amt').html(number_format(item['exchange_info']['amount']));
            $('#'+key+'_betting_amt').html(number_format(item['betting_info']['bet_money']));
            $('#'+key+'_cancel_amt').html(number_format(item['betting_cancel_info']['betting_money']));
            $('#'+key+'_win_amt').html(number_format(item['betting_info']['win_money']));
        }

        // sport betting info
        if(data['sport_betting_info']['multi'] == null || data['sport_betting_info']['multi'].length == 0)
        {
            $('#multi_bet_cnt').html('0');
            $('#multi_bet_amt').html('0');
        } else {
            $('#multi_bet_cnt').html(data['sport_betting_info']['multi']['bet_cnt']);
            $('#multi_bet_amt').html(number_format(data['sport_betting_info']['multi']['amt']));
        }

        if(data['sport_betting_info']['sports'] == null || data['sport_betting_info']['sports'].length == 0)
        {
            $('#sports_bet_cnt').html('0');
            $('#sports_bet_amt').html('0');
        } else {
            $('#sports_bet_cnt').html(data['sport_betting_info']['sports']['bet_cnt']);
            $('#sports_bet_amt').html(number_format(data['sport_betting_info']['sports']['amt']));
        }

        if(data['sport_betting_info']['real'] == null || data['sport_betting_info']['real'].length == 0)
        {
            $('#real_bet_cnt').html('0');
            $('#real_bet_amt').html('0');
        } else {
            $('#real_bet_cnt').html(data['sport_betting_info']['real']['bet_cnt']);
            $('#real_bet_amt').html(number_format(data['sport_betting_info']['real']['amt']));
        }

        if(data['sport_betting_info']['live'] == null || data['sport_betting_info']['live'].length == 0)
        {
            $('#live_bet_cnt').html('0');
            $('#live_bet_amt').html('0');
        } else {
            $('#live_bet_cnt').html(data['sport_betting_info']['live']['bet_cnt']);
            $('#live_bet_amt').html(number_format(data['sport_betting_info']['live']['amt']));
        }

        if(data['mini_betting_info'] != null && data['mini_betting_info'].length > 0)
        {
            for ( var key in  data['mini_betting_info'] ) {
                var item = data['mini_betting_info'][key];
                $('#'+item['special']+'_'+item['game_code']+'_'+item['select_no']+'_cnt').html(item['bet_cnt']);
                $('#'+item['special']+'_'+item['game_code']+'_'+item['select_no']+'_amt').html(number_format(item['bet_amt']));
            }
        }
    }

    function number_format(str) {
        str += "";
        var objRegExp = new RegExp('(-?[0-9]+)([0-9]{3})');
        while (objRegExp.test(str)) {
            str = str.replace(objRegExp, '$1,$2');
        }
        return str;
    }
</script>

<style>
    .dtable { display:table;width:100%;}
    .drow { display:table-row; width:100%;}
    .dcell { display:table-cell; border:0px solid gray;}
    .dtitle { color: white; background-color: #808d9c }
    #control_panel{ width:100%;}
    #left_nav { width:30%; /*padding: 1%;*/}
    #chart_container { width:70%; /*padding:1%;*/}
</style>

<div class="wrap">
	
	<input type="hidden" name="logo" value="<?php echo $TPL_VAR["list"]["logo"]?>">
    <div id="route">
        <h5>관리자 시스템 > 메인 > <b>실시간 상황판</b></h5>
    </div>

    <h3>실시간 상황판</h3>

    <div id='main_wrapper' class='dtable'>
        <div id='bottom_wrapper' class='drow'>
            <div id='left_nav' class='dcell'>
                <div id='main_wrapper' class='dtable'>
                    <div id='bottom_wrapper' class='drow'>
                        <div id='chart_container' class='dcell'>
                            <table cellspacing="1" class="tableStyle_normal" summary="관리자 접근아이피">
                                <thead>
                                    <tr>
                                        <td scope="col" colspan="2" style="color: white;background-color: #808d9c">관리자 접근아이피</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">번호</th>
                                        <th scope="col">아이피</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td id="admin_login_ip"><?php echo $TPL_VAR["admin_login_ip"]?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id='bottom_wrapper' class='drow' >
                        <div id='chart_container' class='dcell'>
                            <table id="tbl_visit_list" cellspacing="1" class="tableStyle_normal" summary="현재접속자" style="margin-top: 15px;">
                                <?php $TPL_list_1=empty($TPL_VAR["current_user_list"])||!is_array($TPL_VAR["current_user_list"])?0:count($TPL_VAR["current_user_list"]); ?>
                                <thead>
                                <tr>
                                    <td scope="col" colspan="4" style="color: white;background-color: #808d9c">현재접속자 총: <span id="visit_cnt"><?php echo $TPL_list_1?></span>명</td>
                                </tr>
                                <tr>
                                    <th scope="col">번호</th>
                                    <th scope="col">아이디</th>
                                    <th scope="col">레벨</th>
                                    <th scope="col">접속</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if($TPL_list_1){
                                    $idx = 1;
                                    foreach($TPL_VAR["current_user_list"] as $TPL_V1){
                                ?>
                                <tr class="visit_tr">
                                    <td><?php echo $idx ?></td>
                                    <td><?php echo $TPL_V1['uid'] ?></td>
                                    <td><?php echo $TPL_V1['mem_lev'] ?></td>
                                    <td><?php echo $TPL_V1['login_domain'] ?></td>
                                </tr>
                                <?php $idx++; }} else {?>
                                <tr class="visit_tr">
                                    <td colspan="4">
                                        접속한 회원이 없습니다.
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id='chart_container' class='dcell'>
                <table cellspacing="1" class="tableStyle_normal" summary="" style="margin-left: 5px;width: 100%">
                    <thead>
                        <tr>
                            <th scope="col" colspan="2">구분</th>
                            <th scope="col">충전수(충전자수)</th>
                            <th scope="col">환전수(환전자수)</th>
                            <th scope="col">입출손익</th>
                            <th scope="col">배팅횟수(배팅자수)</th>
                            <th scope="col">배팅취소</th>
                            <th scope="col">당첨</th>
                            <th scope="col">회원가입</th>
                            <th scope="col">방문자수</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($TPL_VAR['main_info'] as $key=>$TPL_V1) {?>
                        <tr>
                            <td rowspan="2">
                                <?php
                                if($key == 'today') echo "오늘";
                                else if($key == 'yesterday') echo "어제";
                                else if($key == 'month') echo "이달";
                                ?>
                            </td>
                            <td>건수</td>
                            <td id="<?php echo $key?>_charge_cnt"><?php echo $TPL_V1['charge_info']['charge_cnt']?>/<?php echo $TPL_V1['charge_info']['mem_cnt']?></td>
                            <td id="<?php echo $key?>_exchange_cnt"><?php echo $TPL_V1['exchange_info']['exchange_cnt']?>/<?php echo $TPL_V1['exchange_info']['mem_cnt']?></td>
                            <td id="<?php echo $key?>_profit" rowspan="2">
                                <?php echo number_format($TPL_V1['charge_info']['amount'] - $TPL_V1['exchange_info']['amount'] ,0)?>
                            </td>
                            <td id="<?php echo $key?>_betting_cnt"><?php echo $TPL_V1['betting_info']['bet_cnt']?>/<?php echo $TPL_V1['betting_info']['mem_cnt']?></td>
                            <td id="<?php echo $key?>_cancel_cnt"><?php echo $TPL_V1['betting_cancel_info']['cancel_count']?></td>
                            <td id="<?php echo $key?>_win_cnt"><?php echo number_format($TPL_V1['betting_info']['win_cnt'], 0)?></td>
                            <td id="<?php echo $key?>_new_user" rowspan="2"><?php echo $TPL_V1['new_user_info']?></td>
                            <td id="<?php echo $key?>_visit" rowspan="2"><?php echo $TPL_V1['visit_info']?></td>
                        </tr>
                        <tr>
                            <td>금액</td>
                            <td id="<?php echo $key?>_charge_amt"><?php echo number_format($TPL_V1['charge_info']['amount'] ,0)?></td>
                            <td id="<?php echo $key?>_exchange_amt"><?php echo number_format($TPL_V1['exchange_info']['amount'] ,0)?></td>
                            <td id="<?php echo $key?>_betting_amt"><?php echo number_format($TPL_V1['betting_info']['bet_money'], 0)?></td>
                            <td id="<?php echo $key?>_cancel_amt"><?php echo number_format($TPL_V1['betting_cancel_info']['betting_money'], 0)?></td>
                            <td id="<?php echo $key?>_win_amt"><?php echo number_format($TPL_V1['betting_info']['win_money'], 0)?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class='dtable'>
        <div id='control_panel_wrapper' class='drow'>
            <div id='control_panel' class='dcell'>
                <table cellspacing="1" class="tableStyle_normal" summary="" style="margin-top: 15px;width: 100%">
                    <thead>
                    <tr>
                        <th scope="col" colspan="2">구분</th>
                        <!-- <th scope="col">조합배팅</th> -->
                        <!--<th scope="col">승무패</th>
                        <th scope="col">핸디</th>
                        <th scope="col">언더오버</th>-->
                        <th scope="col">국내형 / 해외형</th>
                        <th scope="col">라이브</th>
                        <th scope="col">실시간</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td rowspan="2">스포츠</td>
                        <td>건수</td>
                        <!-- <td id="multi_bet_cnt"><?php echo count((array)$TPL_V1['sport_betting_info']['multi']) > 0 ? number_format($TPL_V1['sport_betting_info']['multi']['bet_cnt'], 0) : 0;?></td> -->
                        <td id="sports_bet_cnt"><?php echo count((array)$TPL_V1['sport_betting_info']['sports']) > 0 ? number_format($TPL_V1['sport_betting_info']['sports']['bet_cnt'], 0) : 0;?></td>
                        <td id="live_bet_cnt"><?php echo count((array)$TPL_V1['sport_betting_info']['live']) > 0 ? number_format($TPL_V1['sport_betting_info']['live']['bet_cnt'], 0) : 0;?></td>
                        <td id="real_bet_cnt"><?php echo count((array)$TPL_V1['sport_betting_info']['real']) > 0 ? number_format($TPL_V1['sport_betting_info']['real']['bet_cnt'], 0) : 0;?></td>
                        <!--<td></td>
                        <td></td>
                        <td></td>-->
                    </tr>
                    <tr>
                        <td>금액</td>
                        <!-- <td id="multi_bet_amt"><?php echo count((array)$TPL_V1['sport_betting_info']['multi']) > 0 ? number_format($TPL_V1['sport_betting_info']['multi']['amt'], 0) : 0;?></td> -->
                        <td id="sports_bet_amt"><?php echo count((array)$TPL_V1['sport_betting_info']['sports']) > 0 ? number_format($TPL_V1['sport_betting_info']['sports']['amt'], 0) : 0;?></td>
                        <td id="live_bet_amt"><?php echo count((array)$TPL_V1['sport_betting_info']['live']) > 0 ? number_format($TPL_V1['sport_betting_info']['live']['amt'], 0) : 0;?></td>
                        <td id="real_bet_amt"><?php echo count((array)$TPL_V1['sport_betting_info']['real']) > 0 ? number_format($TPL_V1['sport_betting_info']['real']['amt'], 0) : 0;?></td>
                        <!--<td></td>
                        <td></td>
                        <td></td>-->
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php 
    if($TPL_VAR["miniSetting"]["power_use"]==1){?>
    <div class='dtable'>
        <div id='control_panel_wrapper' class='drow'>
            <div id='control_panel' class='dcell'>
                <!-- <table cellspacing="1" class="tableStyle_normal" summary="" style="margin-top: 15px;width: 100%">
                    <thead>
                    <tr>
                        <th scope="col" colspan="2">게임</th>
                        <th scope="col" colspan="2">일반볼(1게임)</th>
                        <th scope="col" colspan="3">일반볼구간(3게임)</th>
                        <th scope="col" colspan="2">파워볼(2게임)</th>
                        <th scope="col" colspan="10">파워볼숫자(4게임)</th>
                        <th scope="col" colspan="4">파워볼구간(5게임)</th>
                        <th scope="col" colspan="4">파워볼 언오버(6게임)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="background-color: #faebd7;">
                        <td rowspan="3">파워볼</td>
                        <td></td>
                        <td>홀</td>
                        <td>짝</td>
                        <td>소</td>
                        <td>중</td>
                        <td>대</td>
                        <td>P홀</td>
                        <td>P짝</td>
                        <td>0</td>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td>5</td>
                        <td>6</td>
                        <td>7</td>
                        <td>8</td>
                        <td>9</td>
                        <td>A[0~2]</td>
                        <td>B[3~4]</td>
                        <td>C[5~6]</td>
                        <td>D[7~8]</td>
                        <td>P홀/언더</td>
                        <td>P홀/오버</td>
                        <td>P짝/언더</td>
                        <td>P짝/오버</td>
                    </tr>
                    <tr>
                        <td>건수</td>
                        <td id="7_p_n-oe_1_cnt">0</td>
                        <td id="7_p_n-oe_2_cnt">0</td>
                        <td id="7_p_n-bs_2_cnt">0</td>
                        <td id="7_p_n-bs_3_cnt">0</td>
                        <td id="7_p_n-bs_1_cnt">0</td>
                        <td id="7_p_p-oe_1_cnt">0</td>
                        <td id="7_p_p-oe_2_cnt">0</td>
                        <td id="7_p_01_1_cnt">0</td>
                        <td id="7_p_01_2_cnt">0</td>
                        <td id="7_p_23_1_cnt">0</td>
                        <td id="7_p_23_2_cnt">0</td>
                        <td id="7_p_45_1_cnt">0</td>
                        <td id="7_p_45_2_cnt">0</td>
                        <td id="7_p_67_1_cnt">0</td>
                        <td id="7_p_67_2_cnt">0</td>
                        <td id="7_p_89_1_cnt">0</td>
                        <td id="7_p_89_2_cnt">0</td>
                        <td id="7_p_0279_1_cnt">0</td>
                        <td id="7_p_3456_1_cnt">0</td>
                        <td id="7_p_3456_2_cnt">0</td>
                        <td id="7_p_0279_2_cnt">0</td>
                        <td id="7_p_oe-unover_1_cnt">0</td>
                        <td id="7_p_eo-unover_2_cnt">0</td>
                        <td id="7_p_eo-unover_1_cnt">0</td>
                        <td id="7_p_oe-unover_2_cnt">0</td>
                    </tr>
                    <tr>
                        <td>금액</td>
                        <td id="7_p_n-oe_1_amt">0</td>
                        <td id="7_p_n-oe_2_amt">0</td>
                        <td id="7_p_n-bs_2_amt">0</td>
                        <td id="7_p_n-bs_3_amt">0</td>
                        <td id="7_p_n-bs_1_amt">0</td>
                        <td id="7_p_p-oe_1_amt">0</td>
                        <td id="7_p_p-oe_2_amt">0</td>
                        <td id="7_p_01_1_amt">0</td>
                        <td id="7_p_01_2_amt">0</td>
                        <td id="7_p_23_1_amt">0</td>
                        <td id="7_p_23_2_amt">0</td>
                        <td id="7_p_45_1_amt">0</td>
                        <td id="7_p_45_2_amt">0</td>
                        <td id="7_p_67_1_amt">0</td>
                        <td id="7_p_67_2_amt">0</td>
                        <td id="7_p_89_1_amt">0</td>
                        <td id="7_p_89_2_amt">0</td>
                        <td id="7_p_0279_1_amt">0</td>
                        <td id="7_p_3456_1_amt">0</td>
                        <td id="7_p_3456_2_amt">0</td>
                        <td id="7_p_0279_2_amt">0</td>
                        <td id="7_p_oe-unover_1_amt">0</td>
                        <td id="7_p_eo-unover_2_amt">0</td>
                        <td id="7_p_eo-unover_1_amt">0</td>
                        <td id="7_p_oe-unover_2_amt">0</td>
                    </tr>
                    </tbody>
                </table> -->
                <table cellspacing="1" class="tableStyle_normal" summary="" style="margin-top: 15px;width: 100%">
                    <thead>
                    <tr>
                        <th scope="col" colspan="2">게임</th>
                        <th scope="col" colspan="2">일반볼</th>
                        <th scope="col" colspan="4">일반볼 조합</th>
                        <th scope="col" colspan="3">일반볼구간</th>
                        <th scope="col" colspan="2">파워볼</th>
                        <th scope="col" colspan="4">파워볼 조합</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="background-color: #faebd7;">
                        <td rowspan="3">파워볼</td>
                        <td></td>
                        <td>홀</td>
                        <td>짝</td>
                        <td>홀/언더</td>
                        <td>홀/오버</td>
                        <td>짝/언더</td>
                        <td>짝/오버</td>
                        <td>소</td>
                        <td>중</td>
                        <td>대</td>
                        <td>P홀</td>
                        <td>P짝</td>
                        <td>P홀/언더</td>
                        <td>P홀/오버</td>
                        <td>P짝/언더</td>
                        <td>P짝/오버</td>
                    </tr>
                    <tr>
                        <td>건수</td>
                        <td id="7_p_n-oe_1_cnt">0</td>
                        <td id="7_p_n-oe_2_cnt">0</td>
                        <td id="7_p_noe-unover_1_cnt">0</td>
                        <td id="7_p_neo-unover_2_cnt">0</td>
                        <td id="7_p_neo-unover_1_cnt">0</td>
                        <td id="7_p_noe-unover_2_cnt">0</td>
                        <td id="7_p_n-bs_2_cnt">0</td>
                        <td id="7_p_n-bs_3_cnt">0</td>
                        <td id="7_p_n-bs_1_cnt">0</td>
                        <td id="7_p_p-oe_1_cnt">0</td>
                        <td id="7_p_p-oe_2_cnt">0</td>
                        <td id="7_p_oe-unover_1_cnt">0</td>
                        <td id="7_p_eo-unover_2_cnt">0</td>
                        <td id="7_p_eo-unover_1_cnt">0</td>
                        <td id="7_p_oe-unover_2_cnt">0</td>
                    </tr>
                    <tr>
                        <td>금액</td>
                        <td id="7_p_n-oe_1_amt">0</td>
                        <td id="7_p_n-oe_2_amt">0</td>
                        <td id="7_p_noe-unover_1_amt">0</td>
                        <td id="7_p_neo-unover_2_amt">0</td>
                        <td id="7_p_neo-unover_1_amt">0</td>
                        <td id="7_p_noe-unover_2_amt">0</td>
                        <td id="7_p_n-bs_2_amt">0</td>
                        <td id="7_p_n-bs_3_amt">0</td>
                        <td id="7_p_n-bs_1_amt">0</td>
                        <td id="7_p_p-oe_1_amt">0</td>
                        <td id="7_p_p-oe_2_amt">0</td>
                        <td id="7_p_oe-unover_1_amt">0</td>
                        <td id="7_p_eo-unover_2_amt">0</td>
                        <td id="7_p_eo-unover_1_amt">0</td>
                        <td id="7_p_oe-unover_2_amt">0</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php } 
    if($TPL_VAR["miniSetting"]["fx_use"]==1){?>
    <div class='dtable'>
        <div id='control_panel_wrapper' class='drow'>
            <div id='control_panel' class='dcell'>
                <table cellspacing="1" class="tableStyle_normal" summary="" style="margin-top: 15px;width: 100%">
                    <thead>
                    <tr>
                        <th scope="col" colspan="2">게임</th>
                        <th scope="col" colspan="6">1분게임</th>
                        <th scope="col" colspan="6">2분게임</th>
                        <th scope="col" colspan="6">3분게임</th>
                        <th scope="col" colspan="6">4분게임</th>
                        <th scope="col" colspan="6">5분게임</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="background-color: #faebd7;">
                        <td rowspan="3">엔트리FX</td>
                        <td></td>
                        <td>홀</td>
                        <td>짝</td>
                        <td>언더</td>
                        <td>오버</td>
                        <td>매수</td>
                        <td>매도</td>
                        <td>홀</td>
                        <td>짝</td>
                        <td>언더</td>
                        <td>오버</td>
                        <td>매수</td>
                        <td>매도</td>
                        <td>홀</td>
                        <td>짝</td>
                        <td>언더</td>
                        <td>오버</td>
                        <td>매수</td>
                        <td>매도</td>
                        <td>홀</td>
                        <td>짝</td>
                        <td>언더</td>
                        <td>오버</td>
                        <td>매수</td>
                        <td>매도</td>
                        <td>홀</td>
                        <td>짝</td>
                        <td>언더</td>
                        <td>오버</td>
                        <td>매수</td>
                        <td>매도</td>
                    </tr>
                    <tr>
                        <td>건수</td>
                        <td id="35_fx_oe_1_cnt">0</td>
                        <td id="35_fx_oe_2_cnt">0</td>
                        <td id="35_fx_uo_1_cnt">0</td>
                        <td id="35_fx_uo_2_cnt">0</td>
                        <td id="35_fx_bs_1_cnt">0</td>
                        <td id="35_fx_bs_2_cnt">0</td>
                        <td id="39_fx_oe_1_cnt">0</td>
                        <td id="39_fx_oe_2_cnt">0</td>
                        <td id="39_fx_uo_1_cnt">0</td>
                        <td id="39_fx_uo_2_cnt">0</td>
                        <td id="39_fx_bs_1_cnt">0</td>
                        <td id="39_fx_bs_2_cnt">0</td>
                        <td id="40_fx_oe_1_cnt">0</td>
                        <td id="40_fx_oe_2_cnt">0</td>
                        <td id="40_fx_uo_1_cnt">0</td>
                        <td id="40_fx_uo_2_cnt">0</td>
                        <td id="40_fx_bs_1_cnt">0</td>
                        <td id="40_fx_bs_2_cnt">0</td>
                        <td id="41_fx_oe_1_cnt">0</td>
                        <td id="41_fx_oe_2_cnt">0</td>
                        <td id="41_fx_uo_1_cnt">0</td>
                        <td id="41_fx_uo_2_cnt">0</td>
                        <td id="41_fx_bs_1_cnt">0</td>
                        <td id="41_fx_bs_2_cnt">0</td>
                        <td id="42_fx_oe_1_cnt">0</td>
                        <td id="42_fx_oe_2_cnt">0</td>
                        <td id="42_fx_uo_1_cnt">0</td>
                        <td id="42_fx_uo_2_cnt">0</td>
                        <td id="42_fx_bs_1_cnt">0</td>
                        <td id="42_fx_bs_2_cnt">0</td>
                    </tr>
                    <tr>
                        <td>금액</td>
                        <td id="35_fx_oe_1_amt">0</td>
                        <td id="35_fx_oe_2_amt">0</td>
                        <td id="35_fx_uo_1_amt">0</td>
                        <td id="35_fx_uo_2_amt">0</td>
                        <td id="35_fx_bs_1_amt">0</td>
                        <td id="35_fx_bs_2_amt">0</td>
                        <td id="39_fx_oe_1_amt">0</td>
                        <td id="39_fx_oe_2_amt">0</td>
                        <td id="39_fx_uo_1_amt">0</td>
                        <td id="39_fx_uo_2_amt">0</td>
                        <td id="39_fx_bs_1_amt">0</td>
                        <td id="39_fx_bs_2_amt">0</td>
                        <td id="40_fx_oe_1_amt">0</td>
                        <td id="40_fx_oe_2_amt">0</td>
                        <td id="40_fx_uo_1_amt">0</td>
                        <td id="40_fx_uo_2_amt">0</td>
                        <td id="40_fx_bs_1_amt">0</td>
                        <td id="40_fx_bs_2_amt">0</td>
                        <td id="41_fx_oe_1_amt">0</td>
                        <td id="41_fx_oe_2_amt">0</td>
                        <td id="41_fx_uo_1_amt">0</td>
                        <td id="41_fx_uo_2_amt">0</td>
                        <td id="41_fx_bs_1_amt">0</td>
                        <td id="41_fx_bs_2_amt">0</td>
                        <td id="42_fx_oe_1_amt">0</td>
                        <td id="42_fx_oe_2_amt">0</td>
                        <td id="42_fx_uo_1_amt">0</td>
                        <td id="42_fx_uo_2_amt">0</td>
                        <td id="42_fx_bs_1_amt">0</td>
                        <td id="42_fx_bs_2_amt">0</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php } 
    if($TPL_VAR["miniSetting"]["powersadari_use"]==1 || $TPL_VAR["miniSetting"]["dari2_use"]==1) {?>
    <div class='dtable'>
        <div id='control_panel_wrapper' class='drow'>
            <div id='control_panel' class='dcell'>
                <table cellspacing="1" class="tableStyle_normal" summary="" style="margin-top: 15px;width: 100%">
                    <thead>
                    <tr>
                    <?php 
                    if($TPL_VAR["miniSetting"]["powersadari_use"]==1){?>
                        <th scope="col" colspan="2">게임</th>
                        <th scope="col" colspan="2">홀/짝</th>
                        <th scope="col" colspan="4">좌/우/3줄/4줄</th>
                        <th scope="col" colspan="4">3짝/3홀/4짝/4홀</th>
                    <?php } 
                    if($TPL_VAR["miniSetting"]["dari2_use"]==1){?>
                        <th scope="col" colspan="2">게임</th>
                        <th scope="col" colspan="2">홀/짝</th>
                        <th scope="col" colspan="4">좌/우/3줄/4줄</th>
                        <th scope="col" colspan="4">3짝/3홀/4짝/4홀</th>
                    <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="background-color: #faebd7;">
                    <?php 
                    if($TPL_VAR["miniSetting"]["powersadari_use"]==1){?>
                        <td rowspan="3">파워사다리</td>
                        <td></td>
                        <td>홀</td>
                        <td>짝</td>
                        <td>좌</td>
                        <td>우</td>
                        <td>3줄</td>
                        <td>4줄</td>
                        <td>3짝좌</td>
                        <td>4홀좌</td>
                        <td>3홀우</td>
                        <td>4짝우</td>
                    <?php } 
                    if($TPL_VAR["miniSetting"]["dari2_use"]==1){?>
                        <td rowspan="3">2다리</td>
                        <td></td>
                        <td>홀</td>
                        <td>짝</td>
                        <td>좌</td>
                        <td>우</td>
                        <td>3줄</td>
                        <td>4줄</td>
                        <td>3짝좌</td>
                        <td>4홀좌</td>
                        <td>3홀우</td>
                        <td>4짝우</td>
                    <?php } ?>
                    </tr>
                    <tr>
                    <?php 
                    if($TPL_VAR["miniSetting"]["powersadari_use"]==1){?>
                        <td>건수</td>
                        <td id="25_ps_oe_1_cnt">0</td>
                        <td id="25_ps_oe_2_cnt">0</td>
                        <td id="25_ps_lr_1_cnt">0</td>
                        <td id="25_ps_lr_2_cnt">0</td>
                        <td id="25_ps_34_1_cnt">0</td>
                        <td id="25_ps_34_2_cnt">0</td>
                        <td id="25_ps_e3o4l_1_cnt">0</td>
                        <td id="25_ps_e3o4l_2_cnt">0</td>
                        <td id="25_ps_o3e4r_1_cnt">0</td>
                        <td id="25_ps_o3e4r_2_cnt">0</td>
                    <?php } 
                    if($TPL_VAR["miniSetting"]["dari2_use"]==1){?>
                        <td>건수</td>
                        <td id="30_2d_oe_1_cnt">0</td>
                        <td id="30_2d_oe_2_cnt">0</td>
                        <td id="30_2d_lr_1_cnt">0</td>
                        <td id="30_2d_lr_2_cnt">0</td>
                        <td id="30_2d_34_1_cnt">0</td>
                        <td id="30_2d_34_2_cnt">0</td>
                        <td id="30_2d_e3o4l_1_cnt">0</td>
                        <td id="30_2d_e3o4l_2_cnt">0</td>
                        <td id="30_2d_o3e4r_1_cnt">0</td>
                        <td id="30_2d_o3e4r_2_cnt">0</td>
                    <?php } ?>
                    </tr>
                    <tr>
                    <?php 
                    if($TPL_VAR["miniSetting"]["powersadari_use"]==1){?>
                        <td>금액</td>
                        <td id="25_ps_oe_1_amt">0</td>
                        <td id="25_ps_oe_2_amt">0</td>
                        <td id="25_ps_lr_1_amt">0</td>
                        <td id="25_ps_lr_2_amt">0</td>
                        <td id="25_ps_34_1_amt">0</td>
                        <td id="25_ps_34_2_amt">0</td>
                        <td id="25_ps_e3o4l_1_amt">0</td>
                        <td id="25_ps_e3o4l_2_amt">0</td>
                        <td id="25_ps_o3e4r_1_amt">0</td>
                        <td id="25_ps_o3e4r_2_amt">0</td>
                    <?php } 
                    if($TPL_VAR["miniSetting"]["dari2_use"]==1){?>
                        <td>금액</td>
                        <td id="30_2d_oe_1_amt">0</td>
                        <td id="30_2d_oe_2_amt">0</td>
                        <td id="30_2d_lr_1_amt">0</td>
                        <td id="30_2d_lr_2_amt">0</td>
                        <td id="30_2d_34_1_amt">0</td>
                        <td id="30_2d_34_2_amt">0</td>
                        <td id="30_2d_e3o4l_1_amt">0</td>
                        <td id="30_2d_e3o4l_2_amt">0</td>
                        <td id="30_2d_o3e4r_1_amt">0</td>
                        <td id="30_2d_o3e4r_2_amt">0</td>
                    <?php } ?>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php }
    if($TPL_VAR["miniSetting"]["kenosadari_use"]==1 || $TPL_VAR["miniSetting"]["dari3_use"]==1){?>
    <div class='dtable'>
        <div id='control_panel_wrapper' class='drow'>
            <div id='control_panel' class='dcell'>
                <table cellspacing="1" class="tableStyle_normal" summary="" style="margin-top: 15px;width: 100%">
                    <thead>
                    <tr>
                    <?php 
                    if($TPL_VAR["miniSetting"]["kenosadari_use"]==1){?>
                        <th scope="col" colspan="2">게임</th>
                        <th scope="col" colspan="2">홀/짝</th>
                        <th scope="col" colspan="4">좌/우/3줄/4줄</th>
                        <th scope="col" colspan="4">3짝/3홀/4짝/4홀</th>
                    <?php } 
                    if($TPL_VAR["miniSetting"]["dari3_use"]==1){?>  
                        <th scope="col" colspan="2">게임</th>
                        <th scope="col" colspan="2">홀/짝</th>
                        <th scope="col" colspan="4">좌/우/3줄/4줄</th>
                        <th scope="col" colspan="4">3짝/3홀/4짝/4홀</th>
                    <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="background-color: #faebd7;">
                    <?php 
                    if($TPL_VAR["miniSetting"]["kenosadari_use"]==1){?>
                        <td rowspan="3">키노사다리</td>
                        <td></td>
                        <td>홀</td>
                        <td>짝</td>
                        <td>좌</td>
                        <td>우</td>
                        <td>3줄</td>
                        <td>4줄</td>
                        <td>3짝좌</td>
                        <td>4홀좌</td>
                        <td>3홀우</td>
                        <td>4짝우</td>
                    <?php } 
                    if($TPL_VAR["miniSetting"]["dari3_use"]==1){?>
                        <td rowspan="3">3다리</td>
                        <td></td>
                        <td>홀</td>
                        <td>짝</td>
                        <td>좌</td>
                        <td>우</td>
                        <td>3줄</td>
                        <td>4줄</td>
                        <td>3짝좌</td>
                        <td>4홀좌</td>
                        <td>3홀우</td>
                        <td>4짝우</td>
                    <?php } ?>
                    </tr>
                    <tr>
                    <?php 
                    if($TPL_VAR["miniSetting"]["kenosadari_use"]==1){?>
                        <td>건수</td>
                        <td id="24_ks_oe_1_cnt">0</td>
                        <td id="24_ks_oe_2_cnt">0</td>
                        <td id="24_ks_lr_1_cnt">0</td>
                        <td id="24_ks_lr_2_cnt">0</td>
                        <td id="24_ks_34_1_cnt">0</td>
                        <td id="24_ks_34_2_cnt">0</td>
                        <td id="24_ks_e3o4l_1_cnt">0</td>
                        <td id="24_ks_e3o4l_2_cnt">0</td>
                        <td id="24_ks_o3e4r_1_cnt">0</td>
                        <td id="24_ks_o3e4r_2_cnt">0</td>
                    <?php } 
                    if($TPL_VAR["miniSetting"]["dari3_use"]==1){?>
                        <td>건수</td>
                        <td id="31_3d_oe_1_cnt">0</td>
                        <td id="31_3d_oe_2_cnt">0</td>
                        <td id="31_3d_lr_1_cnt">0</td>
                        <td id="31_3d_lr_2_cnt">0</td>
                        <td id="31_3d_34_1_cnt">0</td>
                        <td id="31_3d_34_2_cnt">0</td>
                        <td id="31_3d_e3o4l_1_cnt">0</td>
                        <td id="31_3d_e3o4l_2_cnt">0</td>
                        <td id="31_3d_o3e4r_1_cnt">0</td>
                        <td id="31_3d_o3e4r_2_cnt">0</td>
                    <?php } ?>
                    </tr>
                    <tr>
                    <?php 
                    if($TPL_VAR["miniSetting"]["kenosadari_use"]==1){?>
                        <td>금액</td>
                        <td id="24_ks_oe_1_amt">0</td>
                        <td id="24_ks_oe_2_amt">0</td>
                        <td id="24_ks_lr_1_amt">0</td>
                        <td id="24_ks_lr_2_amt">0</td>
                        <td id="24_ks_34_1_amt">0</td>
                        <td id="24_ks_34_2_amt">0</td>
                        <td id="24_ks_e3o4l_1_amt">0</td>
                        <td id="24_ks_e3o4l_2_amt">0</td>
                        <td id="24_ks_o3e4r_1_amt">0</td>
                        <td id="24_ks_o3e4r_2_amt">0</td>
                    <?php } 
                    if($TPL_VAR["miniSetting"]["dari3_use"]==1){?>
                        <td>금액</td>
                        <td id="31_3d_oe_1_amt">0</td>
                        <td id="31_3d_oe_2_amt">0</td>
                        <td id="31_3d_lr_1_amt">0</td>
                        <td id="31_3d_lr_2_amt">0</td>
                        <td id="31_3d_34_1_amt">0</td>
                        <td id="31_3d_34_2_amt">0</td>
                        <td id="31_3d_e3o4l_1_amt">0</td>
                        <td id="31_3d_e3o4l_2_amt">0</td>
                        <td id="31_3d_o3e4r_1_amt">0</td>
                        <td id="31_3d_o3e4r_2_amt">0</td>
                    <?php } ?>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php } 
    if($TPL_VAR["miniSetting"]["choice_use"]==1 || $TPL_VAR["miniSetting"]["roulette_use"]==1 || $TPL_VAR["miniSetting"]["pharah_use"]==1){ ?>
    <div class='dtable'>
        <div id='control_panel_wrapper' class='drow'>
            <div id='control_panel' class='dcell'>
                <table cellspacing="1" class="tableStyle_normal" summary="" style="margin-top: 15px;width: 60%">
                    <thead>
                    <tr>
                    <?php 
                    if($TPL_VAR["miniSetting"]["choice_use"]==1){?>
                        <th scope="col" colspan="2">게임</th>
                        <th scope="col" colspan="2">블랙/화이트</th>
                    <?php } 
                    if($TPL_VAR["miniSetting"]["roulette_use"]==1){?>
                        <th scope="col" colspan="2">게임</th>
                        <th scope="col" colspan="2">Red/블랙</th>
                    <?php } 
                    if($TPL_VAR["miniSetting"]["pharah_use"]==1){?>
                        <th scope="col" colspan="2">게임</th>
                        <th scope="col" colspan="2">Heart/Spade</th>
                    <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="background-color: #faebd7;">
                    <?php 
                    if($TPL_VAR["miniSetting"]["choice_use"]==1){?>
                        <td rowspan="3">초이스</td>
                        <td></td>
                        <td>블랙</td>
                        <td>화이트</td>
                    <?php } 
                    if($TPL_VAR["miniSetting"]["roulette_use"]==1){?>
                        <td rowspan="3">룰렛</td>
                        <td></td>
                        <td>Red</td>
                        <td>블랙</td>
                    <?php } 
                    if($TPL_VAR["miniSetting"]["pharah_use"]==1){?>
                        <td rowspan="3">파라오</td>
                        <td></td>
                        <td>Heart</td>
                        <td>Spade</td>
                    <?php } ?>
                    </tr>
                    <tr>
                    <?php 
                    if($TPL_VAR["miniSetting"]["choice_use"]==1){?>
                        <td>건수</td>
                        <td id="32_choice_bw_1_cnt">0</td>
                        <td id="32_choice_bw_2_cnt">0</td>
                    <?php } 
                    if($TPL_VAR["miniSetting"]["roulette_use"]==1){?>
                        <td>건수</td>
                        <td id="33_roulette_rb_1_cnt">0</td>
                        <td id="33_roulette_rb_2_cnt">0</td>
                    <?php } 
                    if($TPL_VAR["miniSetting"]["pharah_use"]==1){?>
                        <td>건수</td>
                        <td id="34_pharaoh_hs_1_cnt">0</td>
                        <td id="34_pharaoh_hs_2_cnt">0</td>
                    <?php } ?>
                    </tr>
                    <tr>
                    <?php 
                    if($TPL_VAR["miniSetting"]["choice_use"]==1){?>
                        <td>금액</td>
                        <td id="32_choice_bw_1_amt">0</td>
                        <td id="32_choice_bw_2_amt">0</td>
                    <?php } 
                    if($TPL_VAR["miniSetting"]["roulette_use"]==1){?>
                        <td>금액</td>
                        <td id="33_roulette_rb_1_amt">0</td>
                        <td id="33_roulette_rb_2_amt">0</td>
                    <?php } 
                    if($TPL_VAR["miniSetting"]["pharah_use"]==1){?>
                        <td>금액</td>
                        <td id="34_pharaoh_hs_1_amt">0</td>
                        <td id="34_pharaoh_hs_2_amt">0</td>
                    <?php } ?>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php } ?>
</div>