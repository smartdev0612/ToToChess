<div class="wrap">
    <div id="route">
        <h5>파워볼 밸런스 > <b>밸런스상황판</b></h5>
    </div>

    <h3>파워볼 밸런스상황판</h3>

    <div id="search">
        <form>
            <div class="wrap">
                <span>발란스 아이디 : <font color="blue" id="balId">로딩중..</font></span> &nbsp;&nbsp;&nbsp;&nbsp;
                <!--<span>발란스 아이디 보유금  : <font color="blue" id="balMoney">0</font> 원</span>&nbsp;&nbsp;&nbsp;&nbsp;-->
                <span>발란스 옵션 여부 : <font color="blue" id="balType">로딩중..</font></span>&nbsp;&nbsp;&nbsp;&nbsp;
                <span>현재 진행회차  : <font color="blue" id="sadariTh">0</font> 회차</span>&nbsp;&nbsp;&nbsp;&nbsp;
                <span>현재 진행회차 상부 배팅 상태 : <font color="blue" id="balStats">로딩중..</font></span>
            </div>
            <div class="wrap_search">
                <span>총배팅금액 : <font id="total_sum_money">0</font>원</span> &nbsp;
                <span>총발란스금액 : <font id="total_balance_money">0</font>원</span>&nbsp;
                <span>총받치는금액 : <font id="total_hit_money">0</font>원</span>&nbsp;
                <span>총받친실패금액 : <font id="total_hit_lose_money">0</font>원</span> &nbsp;
                <span>총발란스이익금 : <font id="total_balance_win_money">0</font>원</span>&nbsp;
                <span>총받치는배당이익금 : <font id="total_hit_rate_money">0</font>원</span>&nbsp;
                <!--<span>총받치는롤링이익금 : <font id="total_hit_rolling_money">0</font>원</span>-->
            </div>
        </form>
    </div>

    <table cellspacing="1" class="tableStyle_normal2" summary="현재 진행 회차" style="letter-spacing:-0.1em;">
        <legend class="blind">현재 진행 회차</legend>
        <tbody>
        <tr>
            <th rowspan="6" style="width:80px;">파워볼<br /><span id="sadariTh2"></span>회차<br /><font color="red">(<span id="balType2">받치기</span>)</font></th>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">숫자합 홀 배팅 정보</td>
            <td class="betTd" align='right'><span id="sum_odd_cnt">0</span>건 / <span id="sum_odd">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">숫자합 짝 배팅 정보</td>
            <td class="betTd" align='right'><span id="sum_even_cnt">0</span>건 / <span id="sum_even">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">파워볼 홀 배팅 정보</td>
            <td class="betTd" align='right'><span id="sum_3line_cnt">0</span>건 / <span id="sum_3line">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">파워볼 짝 배팅 정보</td>
            <td class="betTd" align='right'><span id="sum_4line_cnt">0</span>건 / <span id="sum_4line">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">파워볼 언더 배팅 정보</td>
            <td class="betTd" align='right'><span id="sum_left_cnt">0</span>건 / <span id="sum_left">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">파워볼 오버 배팅 정보</td>
            <td class="betTd" align='right'><span id="sum_right_cnt">0</span>건 / <span id="sum_right">0</span>원</td>
        </tr>
        <tr>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">숫자합 홀 발란스 금액</td>
            <td class="betTd" align='right'><span id="odd_bal_money">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">숫자합 짝 발란스 금액</td>
            <td class="betTd" align='right'><span id="even_bal_money">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">파워볼 홀 발란스 금액</td>
            <td class="betTd" align='right'><span id="line3_bal_money">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">파워볼 짝 발란스 금액</td>
            <td class="betTd" align='right'><span id="line4_bal_money">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">파워볼 언더 발란스 금액</td>
            <td class="betTd" align='right'><span id="left_bal_money">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">파워볼 오버 발란스 금액</td>
            <td class="betTd" align='right'><span id="right_bal_money">0</span>원</td>
        </tr>
        <tr>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">숫자합 홀 받치는 금액</td>
            <td class="betTd" align='right'><span id="odd_hit_money">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">숫자합 짝 받치는 금액</td>
            <td class="betTd" align='right'><span id="even_hit_money">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">파워볼 홀 받치는 금액</td>
            <td class="betTd" align='right'><span id="line3_hit_money">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">파워볼 짝 받치는 금액</td>
            <td class="betTd" align='right'><span id="line4_hit_money">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">파워볼 언더 받치는 금액</td>
            <td class="betTd" align='right'><span id="left_hit_money">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">파워볼 오버 받치는 금액</td>
            <td class="betTd" align='right'><span id="right_hit_money">0</span>원</td>
        </tr>
        <tr>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">숫자합 홀 발란스 이익</td>
            <td class="betTd" align='right'><span id="odd_bal_win">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">숫자합 짝 발란스 이익</td>
            <td class="betTd" align='right'><span id="even_bal_win">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">파워볼 홀 발란스 이익</td>
            <td class="betTd" align='right'><span id="line3_bal_win">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">파워볼 짝 발란스 이익</td>
            <td class="betTd" align='right'><span id="line4_bal_win">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">파워볼 언더 발란스 이익</td>
            <td class="betTd" align='right'><span id="left_bal_win">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">파워볼 오버 발란스 이익</td>
            <td class="betTd" align='right'><span id="right_bal_win">0</span>원</td>
        </tr>
        <tr>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">숫자합 홀 받친 배당 이익</td>
            <td class="betTd" align='right'><span id="odd_hit_win">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">숫자합 짝 받친 배당 이익</td>
            <td class="betTd" align='right'><span id="even_hit_win">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">파워볼 홀 받친 배당 이익</td>
            <td class="betTd" align='right'><span id="line3_hit_win">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">파워볼 짝 받친 배당 이익</td>
            <td class="betTd" align='right'><span id="line4_hit_win">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">파워볼 언더 받친 배당 이익</td>
            <td class="betTd" align='right'><span id="left_hit_win">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 15px;background: paleturquoise;">파워볼 오버 받친 배당 이익</td>
            <td class="betTd" align='right'><span id="right_hit_win">0</span>원</td>
        </tr>
        <!--<tr>
            <td>홀 받친 롤링 이익</td>
            <td class="betTd" align='right'><span id="odd_hit_roll">0</span>원</td>
            <td>짝 받친 롤링 이익</td>
            <td class="betTd" align='right'><span id="even_hit_roll">0</span>원</td>
            <td>3줄 받친 롤링 이익</td>
            <td class="betTd" align='right'><span id="line3_hit_roll">0</span>원</td>
            <td>4줄 받친 롤링 이익</td>
            <td class="betTd" align='right'><span id="line4_hit_roll">0</span>원</td>
            <td>좌 받친 롤링 이익</td>
            <td class="betTd" align='right'><span id="left_hit_roll">0</span>원</td>
            <td>우 받친 롤링 이익</td>
            <td class="betTd" align='right'><span id="right_hit_roll">0</span>원</td>
        </tr>-->
        <tr>
            <td colspan="13" align="center" style="height:55px; background:#D5D5D5;"><b><span id="top_betting_time" style='font-size:26px;'>로딩중...</span></b></td>
        </tr>
        <tr>
            <th rowspan="6" style="height:70px;">상부<br/>배팅현황</th>
            <td align='center'>숫자합 홀 배팅 상태</td>
            <td class="betTd" align='center'><b><span id="odd_state" style="font-size:18px;">대기</span></b></td>
            <td align='center'>숫자합 짝 배팅 상태</td>
            <td class="betTd" align='center'><b><span id="even_state" style="font-size:18px;">대기</span></b></td>
            <td align='center'>파워볼 홀 배팅 상태</td>
            <td class="betTd" align='center'><b><span id="line3_state" style="font-size:18px;">대기</span></b></td>
            <td align='center'>파워볼 짝 배팅 상태</td>
            <td class="betTd" align='center'><b><span id="line4_state" style="font-size:18px;">대기</span></b></td>
            <td align='center'>파워볼 언더 배팅 상태</td>
            <td class="betTd" align='center'><b><span id="left_state" style="font-size:18px;">대기</span></b></td>
            <td align='center'>파워볼 오버 배팅 상태</td>
            <td class="betTd" align='center'><b><span id="right_state" style="font-size:18px;">대기</span></b></td>
        </tr>
        <tr>
            <td align='center'>숫자합 홀 배팅금</td>
            <td class="betTd" align='center'><span id="odd_hit_roll_top">0</span>원</td>
            <td align='center'>숫자합 짝 배팅금</td>
            <td class="betTd" align='center'><span id="even_hit_roll_top">0</span>원</td>
            <td align='center'>파워볼 홀 배팅금</td>
            <td class="betTd" align='center'><span id="line3_hit_roll_top">0</span>원</td>
            <td align='center'>파워볼 짝 배팅금</td>
            <td class="betTd" align='center'><span id="line4_hit_roll_top">0</span>원</td>
            <td align='center'>파워볼 언더 배팅금</td>
            <td class="betTd" align='center'><span id="left_hit_roll_top">0</span>원</td>
            <td align='center'>파워볼 오버 배팅금</td>
            <td class="betTd" align='center'><span id="right_hit_roll_top">0</span>원</td>
        </tr>
        </tbody>
    </table>
</div>
<br>
※ 실시간 상황판 갱신 주기는 5초 입니다.<br><br>
:: 실패시 출력되는 코드 설명 ::<br>
&nbsp;&nbsp;실패(#2) = 배팅금액 부족. (상부 배팅 아이디의 보유머니를 충전)<br>
&nbsp;&nbsp;실패(#3) = 배팅 게임코드 오류. (상부 관리자에게 문의)<br>
&nbsp;&nbsp;실패(#4) = 게임 생성 오류. (상부 관리자에게 문의)<br>
&nbsp;&nbsp;실패(#5) = 구매 번호 오류. (상부 관리자에게 문의)<br>
&nbsp;&nbsp;실패(#9) = 배팅 전송 오류. (밸런스옵션 확인 및 상부 관리자에게 문의)<br>

<script>
    $(document).ready(function() {
        setTimeout(function(){
            balanceLoad();
        },500);
    });

    //-> 방부 배팅현황 출력
    function viewTopBettingState(type, money, flag) {
        if ( flag == 0 ) {
            $("#"+type+"_state").html("<font color='blue' style='font-size:18px;'>-</font>");
        } else if ( flag == 1 ) {
            $("#"+type+"_state").html("<font color='blue' style='font-size:18px;'>성공</font>");
            $("#"+type+"_hit_roll_top").html(FormatNumber(money));
        } else {
            $("#"+type+"_state").html("<font color='red' style='font-size:18px;'>실패 (#"+flag+")</font>");
            $("#"+type+"_hit_roll_top").html(FormatNumber(money));
        }
    }

    function balanceLoad() {
        var type ='power';
        var data = {type:type};
        $.ajax({
            url : "/api/get_realtime",
            data : data,
            type : "post", cache : false, async : false, timeout : 5000, scriptCharset : "utf-8", dataType : "json",
            success: function(res) {
                if ( typeof(res) == "object" ) {
                    var total_sum_money = 0;
                    var total_balance_money = 0;
                    var total_hit_money = 0;

                    $("#balId").html(res.bal_id);
                    //$("#balMoney").html(FormatNumber(res.top_money));
                    $("#sadariTh, #sadariTh2").html(res.sadari_gameTh);

                    if ( res.bal_type == "all" ) res.bal_type = "전체";
                    else res.bal_type = "받치기";
                    $("#balType, #balType2").html(res.bal_type);


                    /*if ( res.top_result != "ok" ) {
                        $("#top_betting_time").html("<font style='font-size:26px;' color='red'>알림 : "+res.top_error_msg+"</font>");
                    } else if ( res.bal_useFlag == 2 ) {
                        $("#top_betting_time").html("<font style='font-size:26px;' color='red'>알림 : 밸런스옵션에 [발란스 배팅]이 [중지]로 되어 있습니다.</font>");
                    }
                    else */
                    {
                        //-> 각 항목별 배팅 정보
                        $("#sum_odd").html(FormatNumber(res.sum_odd));
                        $("#sum_odd_cnt").html(res.sum_odd_cnt);
                        $("#sum_even").html(FormatNumber(res.sum_even));
                        $("#sum_even_cnt").html(res.sum_even_cnt);
                        $("#sum_left").html(FormatNumber(res.sum_left));
                        $("#sum_left_cnt").html(res.sum_left_cnt);
                        $("#sum_right").html(FormatNumber(res.sum_right));
                        $("#sum_right_cnt").html(res.sum_right_cnt);
                        $("#sum_3line").html(FormatNumber(res.sum_3line));
                        $("#sum_3line_cnt").html(res.sum_3line_cnt);
                        $("#sum_4line").html(FormatNumber(res.sum_4line));
                        $("#sum_4line_cnt").html(res.sum_4line_cnt);

                        //-> 홀/짝 발란스, 받치는 금액
                        var balData = balance_money(res.sum_odd, res.sum_even);
                        var hitData = hit_money(res.sum_odd, res.sum_even);
                        var odd_bal_money = balData['homeMoney'];
                        var even_bal_money = balData['awayMoney'];
                        var odd_hit_money = hitData['homeMoney'];
                        var even_hit_money = hitData['awayMoney'];
                        $("#odd_bal_money").html(FormatNumber(odd_bal_money));
                        $("#even_bal_money").html(FormatNumber(even_bal_money));
                        $("#odd_hit_money").html(FormatNumber(odd_hit_money));
                        $("#even_hit_money").html(FormatNumber(even_hit_money));

                        //-> 좌/우 발란스, 받치는 금액
                        var balData = balance_money(res.sum_left, res.sum_right);
                        var hitData = hit_money(res.sum_left, res.sum_right);
                        var left_bal_money = balData['homeMoney'];
                        var right_bal_money = balData['awayMoney'];
                        var left_hit_money = hitData['homeMoney'];
                        var right_hit_money = hitData['awayMoney'];
                        $("#left_bal_money").html(FormatNumber(left_bal_money));
                        $("#right_bal_money").html(FormatNumber(right_bal_money));
                        $("#left_hit_money").html(FormatNumber(left_hit_money));
                        $("#right_hit_money").html(FormatNumber(right_hit_money));

                        //-> 3줄/4줄 발란스, 받치는 금액
                        var balData = balance_money(res.sum_3line, res.sum_4line);
                        var hitData = hit_money(res.sum_3line, res.sum_4line);
                        var line3_bal_money = balData['homeMoney'];
                        var line4_bal_money = balData['awayMoney'];
                        var line3_hit_money = hitData['homeMoney'];
                        var line4_hit_money = hitData['awayMoney'];
                        $("#line3_bal_money").html(FormatNumber(line3_bal_money));
                        $("#line4_bal_money").html(FormatNumber(line4_bal_money));
                        $("#line3_hit_money").html(FormatNumber(line3_hit_money));
                        $("#line4_hit_money").html(FormatNumber(line4_hit_money));

                        //-> 발란스 배당 이익
                        var odd_win_bal_money = parseInt(((odd_bal_money + even_bal_money) - (odd_bal_money * res.power_rate)) / 2);
                        var even_win_bal_money = parseInt(((odd_bal_money + even_bal_money) - (even_bal_money * res.power_rate)) / 2);
                        var left_win_bal_money = parseInt(((left_bal_money + right_bal_money) - (left_bal_money * res.power_rate)) / 2);
                        var right_win_bal_money = parseInt(((left_bal_money + right_bal_money) - (right_bal_money * res.power_rate)) / 2);
                        var line3_win_bal_money = parseInt(((line3_bal_money + line4_bal_money) - (line3_bal_money * res.power_rate)) / 2);
                        var line4_win_bal_money = parseInt(((line3_bal_money + line4_bal_money) - (line4_bal_money * res.power_rate)) / 2);
                        $("#odd_bal_win").html(FormatNumber(odd_win_bal_money));
                        $("#even_bal_win").html(FormatNumber(even_win_bal_money));
                        $("#left_bal_win").html(FormatNumber(left_win_bal_money));
                        $("#right_bal_win").html(FormatNumber(right_win_bal_money));
                        $("#line3_bal_win").html(FormatNumber(line3_win_bal_money));
                        $("#line4_bal_win").html(FormatNumber(line4_win_bal_money));

                        //-> 받친금액 배당 이익
                        var odd_win_hit_money = parseInt((odd_hit_money * res.top_power_rate) - (odd_hit_money * res.power_rate));
                        var even_win_hit_money = parseInt((even_hit_money * res.top_power_rate) - (even_hit_money * res.power_rate));
                        var left_win_hit_money = parseInt((left_hit_money * res.top_power_rate) - (left_hit_money * res.power_rate));
                        var right_win_hit_money = parseInt((right_hit_money * res.top_power_rate) - (right_hit_money * res.power_rate));
                        var line3_win_hit_money = parseInt((line3_hit_money * res.top_power_rate) - (line3_hit_money * res.power_rate));
                        var line4_win_hit_money = parseInt((line4_hit_money * res.top_power_rate) - (line4_hit_money * res.power_rate));
                        $("#odd_hit_win").html(FormatNumber(odd_win_hit_money));
                        $("#even_hit_win").html(FormatNumber(even_win_hit_money));
                        $("#left_hit_win").html(FormatNumber(left_win_hit_money));
                        $("#right_hit_win").html(FormatNumber(right_win_hit_money));
                        $("#line3_hit_win").html(FormatNumber(line3_win_hit_money));
                        $("#line4_hit_win").html(FormatNumber(line4_win_hit_money));

                        //-> 받친금액 롤링 이익
                        /*var odd_win_roll_money = parseInt(odd_hit_money * (res.top_parent_per / 100));
                        var even_win_roll_money = parseInt(even_hit_money * (res.top_parent_per / 100));
                        var left_win_roll_money = parseInt(left_hit_money * (res.top_parent_per / 100));
                        var right_win_roll_money = parseInt(right_hit_money * (res.top_parent_per / 100));d
                        var line3_win_roll_money = parseInt(line3_hit_money * (res.top_parent_per / 100));
                        var line4_win_roll_money = parseInt(line4_hit_money * (res.top_parent_per / 100));
                        $("#odd_hit_roll").html(FormatNumber(odd_win_roll_money));
                        $("#even_hit_roll").html(FormatNumber(even_win_roll_money));
                        $("#left_hit_roll").html(FormatNumber(left_win_roll_money));
                        $("#right_hit_roll").html(FormatNumber(right_win_roll_money));
                        $("#line3_hit_roll").html(FormatNumber(line3_win_roll_money));
                        $("#line4_hit_roll").html(FormatNumber(line4_win_roll_money));*/

                        //-> 총배팅금액
                        var total_sum_money = Number(res.sum_odd) + Number(res.sum_even) + Number(res.sum_3line) + Number(res.sum_4line) + Number(res.sum_left) + Number(res.sum_right);
                        $("#total_sum_money").html(FormatNumber(total_sum_money));
                        //-> 총발란스금액
                        var total_balance_money = odd_bal_money + even_bal_money + left_bal_money + right_bal_money + line3_bal_money + line4_bal_money;
                        $("#total_balance_money").html(FormatNumber(total_balance_money));
                        //-> 총받치는금액
                        var total_hit_money = odd_hit_money + even_hit_money + left_hit_money + right_hit_money + line3_hit_money + line4_hit_money;
                        $("#total_hit_money").html(FormatNumber(total_hit_money));
                        //-> 총받친실패금액
                        var total_hit_lose_money = 0;
                        $("#total_hit_lose_money").html(FormatNumber(total_hit_lose_money));
                        //-> 총발란스이익금
                        var total_balance_win_money = odd_win_bal_money + even_win_bal_money + left_win_bal_money + right_win_bal_money + line3_win_bal_money + line4_win_bal_money;
                        $("#total_balance_win_money").html(FormatNumber(total_balance_win_money));
                        //-> 총받치는배당이익금
                        var total_hit_rate_money = odd_win_hit_money + even_win_hit_money + left_win_hit_money + right_win_hit_money + line3_win_hit_money + line4_win_hit_money;
                        $("#total_hit_rate_moneyy").html(FormatNumber(total_hit_rate_money));
                        //-> 총받치는롤링이익금
                        /*var total_hit_rolling_money = odd_win_roll_money + even_win_roll_money + left_win_roll_money + right_win_roll_money + line3_win_roll_money + line4_win_roll_money;
                        $("#total_hit_rolling_money").html(FormatNumber(total_hit_rolling_money));*/

                        //-> 현황 상태
                        if ( total_hit_money > 0 ) {
                            if ( res.sadari_limitSec > 90 ) {
                                var betLimit = res.sadari_limitSec - 90;
                                $("#top_betting_time").html("<font style='font-size:26px;'>"+betLimit+"초 후 "+res.sadari_gameTh+"회차 상부 배팅 시작</font>");
                                $("#balStats").html("배팅 대기중");
                            } else if ( res.sadari_limitSec <= 90 && res.sadari_limitSec >= 60 && typeof(res.balData) != "object" ) {
                                var betLimit = res.sadari_limitSec - 60;
                                $("#top_betting_time").html("<font style='font-size:26px;'>상부 배팅 중... [배팅시도 남은시간 : "+betLimit+"초]</font>");
                                $("#balStats").html("상부 배팅 중");
                            } else if ( res.sadari_limitSec < 60 && typeof(res.balData) != "object" ) {
                                $("#top_betting_time").html("<font color='red' style='font-size:26px;'>"+res.sadari_gameTh+"회차 상부 배팅 실패! [다음회차 남은시간 : "+res.sadari_limitSec+"초]</font>");
                                $("#balStats").html("<font color='red'>상부 배팅 실패</font>");
                                $("#odd_state,#even_state,#left_state,#right_state,#line3_state,#line4_state").html("<font color='red' style='font-size:18px;'>실패 (#9)</font>");
                                try { jBeep('/voice/balance.mp3'); } catch(e) {};
                            } else if ( typeof(res.balData) == "object" ) {
                                $("#top_betting_time").html("<font color='blue' style='font-size:26px;'>"+res.sadari_gameTh+"회차 상부 배팅 완료! [다음회차 남은시간 : "+res.sadari_limitSec+"초]</font>");
                                $("#balStats").html("상부 배팅 성공");

                                //-> 발란스 배팅 데이터 출력 (배팅상태 및 배팅금)
                                viewTopBettingState("odd", res.balData["odd_betting"], res.balData["odd_flag"]);
                                viewTopBettingState("even", res.balData["even_betting"], res.balData["even_flag"]);
                                viewTopBettingState("left", res.balData["left_betting"], res.balData["left_flag"]);
                                viewTopBettingState("right", res.balData["right_betting"], res.balData["right_flag"]);
                                viewTopBettingState("line3", res.balData["line3_betting"], res.balData["line3_flag"]);
                                viewTopBettingState("line4", res.balData["line4_betting"], res.balData["line4_flag"]);
                                if ( res.balData["odd_flag"] > 1 || res.balData["even_flag"] > 1 || res.balData["left_flag"] > 1 || res.balData["right_flag"] > 1 || res.balData["line3_flag"] > 1 || res.balData["line4_flag"] > 1 ) {
                                    try { jBeep('/voice/balance.mp3'); } catch(e) {};
                                }
                            }
                        } else {
                            var betLimit = res.sadari_limitSec - 90;
                            if ( betLimit <= 0 ) {
                                $("#top_betting_time").html("<font style='font-size:26px;'>배팅 마감! [다음회차 남은시간 : "+res.sadari_limitSec+"초]</font>");
                            } else {
                                $("#top_betting_time").html("<font style='font-size:26px;'>배팅 대기중... [배팅 남은시간 : "+betLimit+"초]</font>");
                            }
                            $("#balStats").html("대기중");
                            $("#odd_state,#even_state,#left_state,#right_state,#line3_state,#line4_state").html("대기");
                            $("#odd_hit_roll_top,#even_hit_roll_top,#left_hit_roll_top,#right_hit_roll_top,#line3_hit_roll_top,#line4_hit_roll_top").html("0");
                        }
                    }

                    setTimeout(function(){
                        balanceLoad();
                    },5000);
                }
            },
            error: function(xhr,status,error) {
                alert("처리중 오류가 발생 되었습니다. 관리자에게 문의해주세요.");
            }
        });
    }

    $(document).ready(function() {
    });

    function balance_money(homeMoney, awayMoney) {
        var returnVal = new Array();

        if ( homeMoney > awayMoney ) {
            endHomeMoney = homeMoney - (homeMoney - awayMoney);
            endAwayMoney = awayMoney;
        }	else if ( homeMoney < awayMoney ) {
            endHomeMoney = homeMoney;
            endAwayMoney = awayMoney - (awayMoney - homeMoney);
        } else {
            endHomeMoney = homeMoney;
            endAwayMoney = awayMoney;
        }

        returnVal['homeMoney'] = endHomeMoney;
        returnVal['awayMoney'] = endAwayMoney;
        return returnVal;
    }

    function hit_money(homeMoney, awayMoney) {
        var returnVal = new Array();

        if ( homeMoney > awayMoney ) {
            endHomeMoney = homeMoney - awayMoney;
            endAwayMoney = 0;
        }	else if ( homeMoney < awayMoney ) {
            endHomeMoney = 0;
            endAwayMoney = awayMoney - homeMoney;
        } else {
            endHomeMoney = 0;
            endAwayMoney = 0;
        }

        returnVal['homeMoney'] = endHomeMoney;
        returnVal['awayMoney'] = endAwayMoney;
        return returnVal;
    }
</script>