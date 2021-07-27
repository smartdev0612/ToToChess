	<div class="mask"></div>
	<div id="container">
        <form name="theFomf" method="post" onsubmit="return checkForm(this);">
            <input type="hidden" name="mode" value="process"/>
            <input type="hidden" name="to_site" id="to_site" value=""/>
            <input type="hidden" name="usablepoint" id="usablepoint" value="14768"/>

            <div id="contents">
                <div class="board_box">
                    <h2>포인트전환</h2>
                    
                    <!-- 포인트전환 -->
                    <div class="point_change">
                        <div class="my_point">
                            <div class="point01">
                                <span class="member_mileage"><?php echo number_format($TPL_VAR["mileage"],0)?></span> P
                            </div>
                        </div>
                        <!-- <div class="point_input">
                            <span class="head">전환금액</span>
                            <div class="input_box"><input type="text" name="amount" id="amount" placeholder="전환하실 포인트 선택" />
                                <div class="btn_area">
                                    <button type="button" onclick="addMoney(10000);">1만원</button>
                                    <button type="button" onclick="addMoney(30000);">3만원</button>
                                    <button type="button" onclick="addMoney(50000);">5만원</button>
                                    <button type="button" onclick="addMoney(100000);">10만원</button>
                                    <button type="button" onclick="addMoney(500000);">50만원</button>
                                    <button type="button" onclick="addMoney(1000000);">100만원</button>
                                    <button type="button" onclick="resetMoney();">정정하기</button>
                                    <button type="button" onclick="addMoney();">전액</button>
                                </div>
                            </div>
                        </div> -->
                        <div class="btn_change">
                            <button type="button" onclick="mileage2Cash();">포인트 전환</button>
                        </div>
                    </div>
                    
                    <h2>포인트 내역</h2>
                    
                    <div class="board_list">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <thead>
                                <tr>
                                    <th class="th-mini">포인트</th>
                                    <th class="th-mini">신청일</th>
                                    <th class="th-mini">내용</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
                                if ( $TPL_list_1 ) {
                                    foreach ( $TPL_VAR["list"] as $TPL_V1 ) {
                                        $date = explode(":", substr($TPL_V1["regdate"], 5));
                                        $regDate = $date[0] . ":" . $date[1];
                                ?>
                                    <tr height="51">
                                        <td class="th-mini"><?php echo number_format($TPL_V1["amount"])?> P</td>
                                        <td class="th-mini"><?php echo $regDate?></td>
                                        <td class="th-mini"><?php echo $TPL_V1["status_message"]?></td>
                                    </tr>
                                <?php
                                    }
                                }
                                ?>								
                            </tbody>
                        </table>
                        
                        <!-- page skip -->
                        <div class="page_skip">
                            <span class="num">&nbsp;
                                <?php echo $TPL_VAR["pagelist"]?>
                            </span>
                        </div>
                    </div>
                </div>
            </form>


