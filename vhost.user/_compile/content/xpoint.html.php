
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
                            <span class="head">마이포인트</span>
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
                                    <th>신청일</th>
                                    <th>금액</th>
                                    <th>내용</th>
                                    <th>완료일</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="4">내역이 없습니다.</td>
                                </tr>								
                            </tbody>
                        </table>
                        
                        <!-- page skip -->
                        <div class="page_skip"></div>
                    </div>
                </div>
            </form>

