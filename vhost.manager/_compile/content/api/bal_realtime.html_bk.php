<div class="wrap">
    <div id="route">
        <h5>사다리 밸런스 > <b>밸런스상황판</b></h5>
    </div>

    <h3>밸런스상황판</h3>

    <div id="search">
        <form>
            <div class="wrap">
                <span>발란스 아이디 : <font color="blue" id="balId">로딩중..</font></span> &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="hidden" id="balance_id">
                <!--<span>발란스 아이디 보유금  : <font color="blue" id="balMoney">0</font> 원</span>-->&nbsp;&nbsp;&nbsp;&nbsp;
                <!--<span>발란스 옵션 여부 : <font color="blue" id="balType">로딩중..</font></span>&nbsp;&nbsp;&nbsp;&nbsp;-->
                <!--<span>현재 진행회차  : <font color="blue" id="sadariTh">0</font> 회차</span>-->&nbsp;&nbsp;&nbsp;&nbsp;
                <!--<span>현재 진행회차 상부 배팅 상태 : <font color="blue" id="balStats">로딩중..</font></span>-->
            </div>
            <!--<div class="wrap_search">
                <span>총배팅금액 : <font id="total_sum_money">0</font>원</span> &nbsp;
                <span>총발란스금액 : <font id="total_balance_money">0</font>원</span>&nbsp;
                <span>총받치는금액 : <font id="total_hit_money">0</font>원</span>&nbsp;
                <span>총받친실패금액 : <font id="total_hit_lose_money">0</font>원</span> &nbsp;
                <span>총발란스이익금 : <font id="total_balance_win_money">0</font>원</span>&nbsp;
                <span>총받치는배당이익금 : <font id="total_hit_rate_money">0</font>원</span>&nbsp;
                <span>총받치는롤링이익금 : <font id="total_hit_rolling_money">0</font>원</span>
            </div>-->
        </form>
    </div>

    <table cellspacing="1" class="tableStyle_normal2" summary="현재 진행 회차" style="letter-spacing:-0.1em;">
        <legend class="blind">현재 진행 회차</legend>
        <tbody>
        <tr>
            <!--<th rowspan="6" style="width:80px;">사다리<br /><span id="sadariTh2"></span>회차<br /><font color="red">(<span id="balType2">받치기</span>)</font></th>-->
            <th rowspan="1" style="width:120px;">
                사다리 <span id="sadariTh2"></span>회차
                <br><span id="sadari_gameDate"></span>
            </th>
            <td style="padding-right: 5px;padding-left: 10px;background: paleturquoise;">홀 배팅 정보</td>
            <td class="betTd" align='right'><span id="sum_odd_cnt">0</span>건 / <span id="sum_odd">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 10px;background: paleturquoise;">짝 배팅 정보</td>
            <td class="betTd" align='right' style="padding-right: 30px;"><span id="sum_even_cnt">0</span>건 / <span id="sum_even">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 10px;background: paleturquoise;">3줄 배팅 정보</td>
            <td class="betTd" align='right'><span id="sum_3line_cnt">0</span>건 / <span id="sum_3line">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 10px;background: paleturquoise;">4줄 배팅 정보</td>
            <td class="betTd" align='right' style="padding-right: 30px;"><span id="sum_4line_cnt">0</span>건 / <span id="sum_4line">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 10px;background: paleturquoise;">좌 배팅 정보</td>
            <td class="betTd" align='right'><span id="sum_left_cnt">0</span>건 / <span id="sum_left">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 10px;background: paleturquoise;">우 배팅 정보</td>
            <td class="betTd" align='right'><span id="sum_right_cnt">0</span>건 / <span id="sum_right">0</span>원</td>
        </tr>

        <tr style="height: 60px">
            <!--<th rowspan="6" style="width:80px;">사다리<br /><span id="sadariTh2"></span>회차<br /><font color="red">(<span id="balType2">받치기</span>)</font></th>-->
            <th rowspan="1" style="width:120px;">

            </th>
            <td colspan="12">
                <input type="radio" id="sadari_odd" name="sadari_rd" value="sadari_odd">
                <label for="sadari_odd">홀</label>
                <input type="radio" id="sadari_even" name="sadari_rd" value="sadari_even">
                <label for="sadari_even">짝</label>
                &nbsp;&nbsp;
                <input type="radio" id="sadari_3line" name="sadari_rd" value="sadari_3line">
                <label for="sadari_3line">3줄</label>
                <input type="radio" id="sadari_4line" name="sadari_rd" value="sadari_4line">
                <label for="sadari_4line">4줄</label>
                &nbsp;&nbsp;
                <input type="radio" id="sadari_left" name="sadari_rd" value="sadari_left">
                <label for="sadari_left">좌</label>
                <input type="radio" id="sadari_right" name="sadari_rd" value="sadari_right">
                <label for="sadari_right">우</label>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label>베팅 금액</label>
                <input name="sadari_amt" type="text" id="sadari_amt" class="name" value="0" style="text-align: right;width: 80px" > * 10,000
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label>적중 금액</label>
                <input name="sadari_profit_amt" type="text" id="sadari_profit_amt" class="name" value="" style="text-align: right;width: 80px" readonly>

                <input type="button" id="sadari_bet" name="sadari_bet" class="Qishi_submit_a" value="베팅하기" onclick="sadariBet()">
            </td>
        </tr>


        <tr>
            <!--<th rowspan="6" style="width:80px;">사다리<br /><span id="sadariTh2"></span>회차<br /><font color="red">(<span id="balType2">받치기</span>)</font></th>-->
            <th rowspan="1" style="width:120px;">
                다리다리 <span id="dariTh"></span>회차
                <br><span id="dari_gameDate"></span>
            </th>
            <td style="padding-right: 5px;padding-left: 10px;background: paleturquoise;">홀 배팅 정보</td>
            <td class="betTd" align='right'><span id="dari_sum_odd_cnt">0</span>건 / <span id="dari_sum_odd">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 10px;background: paleturquoise;">짝 배팅 정보</td>
            <td class="betTd" align='right' style="padding-right: 30px;"><span id="dari_sum_even_cnt">0</span>건 / <span id="dari_sum_even">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 10px;background: paleturquoise;">3줄 배팅 정보</td>
            <td class="betTd" align='right'><span id="dari_sum_3line_cnt">0</span>건 / <span id="dari_sum_3line">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 10px;background: paleturquoise;">4줄 배팅 정보</td>
            <td class="betTd" align='right' style="padding-right: 30px;"><span id="dari_sum_4line_cnt">0</span>건 / <span id="dari_sum_4line">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 10px;background: paleturquoise;">좌 배팅 정보</td>
            <td class="betTd" align='right'><span id="dari_sum_left_cnt">0</span>건 / <span id="dari_sum_left">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 10px;background: paleturquoise;">우 배팅 정보</td>
            <td class="betTd" align='right'><span id="dari_sum_right_cnt">0</span>건 / <span id="dari_sum_right">0</span>원</td>
        </tr>

        <tr style="height: 60px">
            <!--<th rowspan="6" style="width:80px;">사다리<br /><span id="sadariTh2"></span>회차<br /><font color="red">(<span id="balType2">받치기</span>)</font></th>-->
            <th rowspan="1" style="width:120px;"></th>
            <td colspan="12">
                <input type="radio" id="dari_odd" name="dari_rd" value="dari_odd">
                <label for="dari_odd">홀</label>
                <input type="radio" id="dari_even" name="dari_rd" value="dari_even">
                <label for="dari_even">짝</label>
                &nbsp;&nbsp;
                <input type="radio" id="dari_3line" name="dari_rd" value="dari_3line">
                <label for="dari_3line">3줄</label>
                <input type="radio" id="dari_4line" name="dari_rd" value="dari_4line">
                <label for="dari_4line">4줄</label>
                &nbsp;&nbsp;
                <input type="radio" id="dari_left" name="dari_rd" value="dari_left">
                <label for="dari_left">좌</label>
                <input type="radio" id="dari_right" name="dari_rd" value="dari_right">
                <label for="dari_right">우</label>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label>베팅 금액</label>
                <input name="dari_amt" type="text" id="dari_amt" class="name" value="0" style="text-align: right;width: 80px" > * 10,000
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label>적중 금액</label>
                <input name="dari_profit_amt" type="text" id="dari_profit_amt" class="name" value="" style="text-align: right;width: 80px" readonly>

                <input type="button" id="dari_bet" name="dari_bet" class="Qishi_submit_a" value="베팅하기" onclick="dariBet()">
            </td>
        </tr>

        <tr>
            <!--<th rowspan="6" style="width:80px;">사다리<br /><span id="sadariTh2"></span>회차<br /><font color="red">(<span id="balType2">받치기</span>)</font></th>-->
            <th rowspan="1" style="width:120px;height: 30px">파워볼 <span id="powerTh"></span>회차</th>
            <td style="padding-right: 5px;padding-left: 10px;background: paleturquoise;">숫자합 홀 배팅 정보</td>
            <td class="betTd" align='right'><span id="pw_sum_odd_cnt">0</span>건 / <span id="pw_sum_odd">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 10px;background: paleturquoise;">숫자합 짝 배팅 정보</td>
            <td class="betTd" align='right' style="padding-right: 30px;"><span id="pw_sum_even_cnt">0</span>건 / <span id="pw_sum_even">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 10px;background: paleturquoise;">파워볼 홀 배팅 정보</td>
            <td class="betTd" align='right'><span id="pw_ball_sum_odd_cnt">0</span>건 / <span id="pw_ball_sum_odd">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 10px;background: paleturquoise;">파워볼 짝 배팅 정보</td>
            <td class="betTd" align='right' style="padding-right: 30px;"><span id="pw_ball_sum_even_cnt">0</span>건 / <span id="pw_ball_sum_even">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 10px;background: paleturquoise;">파워볼 언더 배팅 정보</td>
            <td class="betTd" align='right'><span id="pw_ball_under_cnt">0</span>건 / <span id="pw_ball_under">0</span>원</td>
            <td style="padding-right: 5px;padding-left: 10px;background: paleturquoise;">파워볼 오버 배팅 정보</td>
            <td class="betTd" align='right'><span id="pw_ball_over_cnt">0</span>건 / <span id="pw_ball_over">0</span>원</td>
        </tr>

        <tr style="height: 60px">
            <!--<th rowspan="6" style="width:80px;">사다리<br /><span id="sadariTh2"></span>회차<br /><font color="red">(<span id="balType2">받치기</span>)</font></th>-->
            <th rowspan="1" style="width:120px;">

            </th>
            <td colspan="12">
                <input type="radio" id="pb_sum_odd" name="power_rd" value="pb_sum_odd">
                <label for="pb_sum_odd">홀 (숫자합)</label>
                <input type="radio" id="pb_sum_even" name="power_rd" value="pb_sum_even">
                <label for="pb_sum_even">짝(숫자합)</label>
                &nbsp;&nbsp;
                <input type="radio" id="pb_ball_sum_odd" name="power_rd" value="pb_ball_sum_odd">
                <label for="pb_ball_sum_odd">홀 (파워볼)</label>
                <input type="radio" id="pb_ball_sum_even" name="power_rd" value="pb_ball_sum_even">
                <label for="pb_ball_sum_even">짝 (파워볼)</label>
                &nbsp;&nbsp;
                <input type="radio" id="pb_ball_under" name="power_rd" value="pb_ball_under">
                <label for="pb_ball_under">파워볼 언더</label>
                <input type="radio" id="pb_ball_over" name="power_rd" value="pb_ball_over">
                <label for="pb_ball_over">파워볼 오버</label>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label>베팅 금액</label>
                <input name="power_amt" type="text" id="power_amt" class="name" value="0" style="text-align: right;width: 80px" > * 10,000
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label>적중 금액</label>
                <input name="power_profit_amt" type="text" id="power_profit_amt" class="name" value="" style="text-align: right;width: 80px" readonly>

                <input type="button" id="power_bet" name="power_bet" class="Qishi_submit_a" value="베팅하기" onclick="powerballBet()">
            </td>
        </tr>
        </tbody>
    </table>
</div>


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
        $.ajax({
            url : "/api/get_realtime",
            type : "post", cache : false, async : false, timeout : 5000, scriptCharset : "utf-8", dataType : "json",
            success: function(res) {
                if ( typeof(res) == "object" ) {
                    var total_sum_money = 0;
                    var total_balance_money = 0;
                    var total_hit_money = 0;

                    $("#balId").html(res.bal_id);
                    $("#balance_id").val(res.bal_id);

                    //$("#balMoney").html(FormatNumber(res.top_money));
                    $("#sadariTh, #sadariTh2").html(res.sadari_gameTh);
                    $("#dariTh").html(res.dari_gameTh);
                    $("#powerTh").html(res.pw_gameTh);

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
                        $("#sadari_gameDate").html(res.sadari_gameDate);
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

                        $("#dari_gameDate").html(res.sadari_gameDate);
                        $("#dari_sum_odd").html(FormatNumber(res.dari_sum_odd));
                        $("#dari_sum_odd_cnt").html(res.dari_sum_odd_cnt);
                        $("#dari_sum_even").html(FormatNumber(res.dari_sum_even));
                        $("#dari_sum_even_cnt").html(res.dari_sum_even_cnt);
                        $("#dari_sum_left").html(FormatNumber(res.dari_sum_left));
                        $("#dari_sum_left_cnt").html(res.dari_sum_left_cnt);
                        $("#dari_sum_right").html(FormatNumber(res.dari_sum_right));
                        $("#dari_sum_right_cnt").html(res.dari_sum_right_cnt);
                        $("#dari_sum_3line").html(FormatNumber(res.dari_sum_3line));
                        $("#dari_sum_3line_cnt").html(res.dari_sum_3line_cnt);
                        $("#dari_sum_4line").html(FormatNumber(res.dari_sum_4line));
                        $("#dari_sum_4line_cnt").html(res.dari_sum_4line_cnt);

                        $("#pw_sum_odd").html(FormatNumber(res.pw_sum_odd));
                        $("#pw_sum_odd_cnt").html(res.pw_sum_odd_cnt);
                        $("#pw_sum_even").html(FormatNumber(res.pw_sum_even));
                        $("#pw_sum_even_cnt").html(res.pw_sum_even_cnt);
                        $("#pw_ball_sum_odd").html(FormatNumber(res.pw_ball_sum_odd));
                        $("#pw_ball_sum_odd_cnt").html(res.pw_ball_sum_odd_cnt);
                        $("#pw_ball_sum_even").html(FormatNumber(res.pw_ball_sum_even));
                        $("#pw_ball_sum_even_cnt").html(res.pw_ball_sum_even_cnt);
                        $("#pw_ball_over").html(FormatNumber(res.pw_ball_over));
                        $("#pw_ball_over_cnt").html(res.pw_ball_over_cnt);
                        $("#pw_ball_under").html(FormatNumber(res.pw_ball_under));
                        $("#pw_ball_under_cnt").html(res.pw_ball_under_cnt);
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

    $( "#sadari_amt" ).keyup(function() {
        var amt = $('#sadari_amt').val() * 10000;
        $('#sadari_profit_amt').val(amt * 1.95);
    });

    $( "#dari_amt" ).keyup(function() {
        var amt = $('#dari_amt').val() * 10000;
        $('#dari_profit_amt').val(amt * 1.95);
    });

    $( "#power_amt" ).keyup(function() {
        var amt = $('#power_amt').val() * 10000;
        $('#power_profit_amt').val(amt * 1.95);
    });

    function sadariBet()
    {
        var id = $("#balance_id").val();
        var date = $("#sadari_gameDate").html();
        var cnt =  $("#sadariTh2").html();
        var bet1 = '';
        var bet2 = '';
        var bet3 = '';
        var money1 = 0;
        var money2 = 0;
        var money3 = 0;
        var money = $("#sadari_amt").val() * 10000;
        var selection = $('input[name=sadari_rd]:checked').val()


        switch (selection)
        {
            case 'sadari_odd':
                bet1 = 'O';
                money1 = money;
                break;

            case 'sadari_even':
                bet1 = 'E';
                money1 = money;
                break;

            case 'sadari_3line':
                bet2 = '3';
                money2 = money;
                break;

            case 'sadari_4line':
                bet2 = '4';
                money2 = money;
                break;

            case 'sadari_left':
                bet3 = 'L';
                money3 = money;
                break;
            case 'sadari_right':
                bet3 = 'R';
                money3 = money;
                break;
        }

        var data = {id:id, date:date, cnt:cnt, bet1:bet1, bet2:bet2, bet3:bet3,
            money1:money1, money2:money2, money3:money3};

        if( confirm("정말 배팅하시겠습니까?") ) {
            $.ajax({
                url : "/api/sadariBet",
                data : data,
                scriptCharset : "utf-8",
                type : "post", cache : false, async : false, timeout : 5000, scriptCharset : "utf-8", dataType : "json",
                success: function(res) {
                    if ( typeof(res) == "object" ) {
                        if(res.ret == 1)
                        {
                            $("#sadari_amt").val('0');
                            $("#sadari_profit_amt").val('');
                            $("input:radio").attr("checked", false);

                            alert("배팅이 완료되었습니다.");
                        }
                        else
                        {
                            if(res.msg == "empty bet info")
                            {
                                alert("배팅을 선택해주세요.");
                            }
                            else if(res.msg == 'not exist game')
                            {
                                alert("지금은 베팅을 하실 수 없습니다.");
                            }
                            else
                            {
                                alert(res.msg );
                            }
                        }
                    }
                },
                error: function(xhr,status,error) {
                    alert("처리중 오류가 발생 되었습니다. 관리자에게 문의해주세요.");
                }
            });
        }
    }

    function dariBet()
    {
        var id = $("#balance_id").val();
        var date = $("#dari_gameDate").html();
        var cnt =  $("#dariTh").html();
        var bet1 = '';
        var bet2 = '';
        var bet3 = '';
        var money1 = 0;
        var money2 = 0;
        var money3 = 0;
        var money = $("#dari_amt").val() * 10000;
        var selection = $('input[name=dari_rd]:checked').val()


        switch (selection)
        {
            case 'dari_odd':
                bet1 = 'O';
                money1 = money;
                break;

            case 'dari_even':
                bet1 = 'E';
                money1 = money;
                break;

            case 'dari_3line':
                bet2 = '3';
                money2 = money;
                break;

            case 'dari_4line':
                bet2 = '4';
                money2 = money;
                break;

            case 'dari_left':
                bet3 = 'L';
                money3 = money;
                break;
            case 'dari_right':
                bet3 = 'R';
                money3 = money;
                break;
        }

        var data = {id:id, date:date, cnt:cnt, bet1:bet1, bet2:bet2, bet3:bet3,
            money1:money1, money2:money2, money3:money3};

        if( confirm("정말 배팅하시겠습니까?") ) {
            $.ajax({
                url : "/api/dariBet",
                data : data,
                scriptCharset : "utf-8",
                type : "post", cache : false, async : false, timeout : 5000, scriptCharset : "utf-8", dataType : "json",
                success: function(res) {
                    if ( typeof(res) == "object" ) {
                        if(res.ret == 1)
                        {
                            $("#dari_amt").val('0');
                            $("#dari_profit_amt").val('');
                            $("input:radio").attr("checked", false);

                            alert("배팅이 완료되었습니다.");
                        }
                        else
                        {
                            if(res.msg == "no betting info")
                            {
                                alert("배팅을 선택해주세요.");
                            }
                            else if(res.msg == 'not exist game or closed game')
                            {
                                alert("지금은 베팅을 하실 수 없습니다.");
                            }
                            else
                            {
                                alert(res.msg );
                            }
                        }
                    }
                },
                error: function(xhr,status,error) {
                    alert("처리중 오류가 발생 되었습니다. 관리자에게 문의해주세요.");
                }
            });
        }
    }

    function powerballBet()
    {
        var id = $("#balance_id").val();
        var cnt =  $("#powerTh").html();
        var bet1 = '';
        var bet2 = '';
        var bet3 = '';
        var money1 = 0;
        var money2 = 0;
        var money3 = 0;
        var money = $("#power_amt").val() * 10000;
        var selection = $('input[name=power_rd]:checked').val()


        switch (selection)
        {
            case 'pb_sum_odd':
                bet1 = 'O';
                money1 = money;
                break;

            case 'pb_sum_even':
                bet1 = 'E';
                money1 = money;
                break;

            case 'pb_ball_sum_odd':
                bet2 = 'X';
                money2 = money;
                break;

            case 'pb_ball_sum_even':
                bet2 = 'Z';
                money2 = money;
                break;

            case 'pb_ball_under':
                bet3 = 'D';
                money3 = money;
                break;
            case 'pb_ball_over':
                bet3 = 'U';
                money3 = money;
                break;
        }

        var data = {id:id, cnt:cnt, bet1:bet1, bet2:bet2, bet3:bet3,
            money1:money1, money2:money2, money3:money3};

        if( confirm("정말 배팅하시겠습니까?") ) {
            $.ajax({
                url : "/api/powerBet",
                data : data,
                scriptCharset : "utf-8",
                type : "post", cache : false, async : false, timeout : 5000, scriptCharset : "utf-8", dataType : "json",
                success: function(res) {
                    if ( typeof(res) == "object" ) {
                        if(res.ret == 1)
                        {
                            $("#power_amt").val('0');
                            $("#power_profit_amt").val('');
                            $("input:radio").attr("checked", false);

                            alert("배팅이 완료되었습니다.");
                        }
                        else
                        {
                            if(res.msg == "No Bet")
                            {
                                alert("배팅을 선택해주세요.");
                            }
                            else if(res.msg == 'game is not exist')
                            {
                                alert("지금은 베팅을 하실 수 없습니다.");
                            }
                            else
                            {
                                alert(res.msg );
                            }
                        }
                    }
                },
                error: function(xhr,status,error) {
                    alert("처리중 오류가 발생 되었습니다. 관리자에게 문의해주세요.");
                }
            });
        }
    }
</script>

<style>
    input[type=radio] {
        display:none;
    }

    input[type=radio] + label {
        display:inline-block;
        margin:-2px;
        padding: 4px 12px;
        margin-bottom: 0;
        font-size: 14px;
        line-height: 20px;
        color: #333;
        text-align: center;
        text-shadow: 0 1px 1px rgba(255,255,255,0.75);
        vertical-align: middle;
        cursor: pointer;
        background-color: #f5f5f5;
        background-image: -moz-linear-gradient(top,#fff,#e6e6e6);
        background-image: -webkit-gradient(linear,0 0,0 100%,from(#fff),to(#e6e6e6));
        background-image: -webkit-linear-gradient(top,#fff,#e6e6e6);
        background-image: -o-linear-gradient(top,#fff,#e6e6e6);
        background-image: linear-gradient(to bottom,#fff,#e6e6e6);
        background-repeat: repeat-x;
        border: 1px solid #ccc;
        border-color: #e6e6e6 #e6e6e6 #bfbfbf;
        border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);
        border-bottom-color: #b3b3b3;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff',endColorstr='#ffe6e6e6',GradientType=0);
        filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
        -webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);
        -moz-box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);
    }

    input[type=radio]:checked + label {
        background-image: none;
        outline: 0;
        -webkit-box-shadow: inset 0 2px 4px rgba(0,0,0,0.15),0 1px 2px rgba(0,0,0,0.05);
        -moz-box-shadow: inset 0 2px 4px rgba(0,0,0,0.15),0 1px 2px rgba(0,0,0,0.05);
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.15),0 1px 2px rgba(0,0,0,0.05);
        background-color:#e0e0e0;
    }
</style>