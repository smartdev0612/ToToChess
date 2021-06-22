    <div id="warp">
        <div id="head">
            <div id="head_1">
                <ul>
                    <li class="head_1_l">
                        <a href="#"><img src="/images/menu.png" class="deploy-left-sidebar" width=37px; height=33px; style="padding-left:5px">
                        </a>
                    </li>
                    <li class="head_1_c">
						<a href="javascript:root();"><img src="/images/logo.png?v02" style="height:40px; margin-top:5px;"></a>
                    </li>
                    <li class="head_1_r">
                        <a href="#"><img src="/images/logout.png" class="deploy-right-sidebar" width=37px; height=33px; style="padding-right:5px">
                        </a>
                    </li>
                </ul>
            </div>
            <div style="width: 60px;left: 45px;position:  absolute;top: 18px;">
                <ul>
                    <li>
                        <a href="javascript:logout();" style="padding-left:5px">로그아웃</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="content">
            <div id="head_2">
				<div class="head_2_l">
					<span class="head_2_t_1"><?php echo $TPL_VAR["nick"]?></span>님&nbsp;&nbsp;쪽지:<a href="/member/memolist"><span class="head_2_t_2"><?php echo $TPL_VAR["new_memo_count"]?></span></a>통
				</div>
				<div class="head_2_r">
					보유금:<span class="head_2_t_3"><?php echo number_format($TPL_VAR["cash"],0)?></span>원&nbsp;&nbsp;<a href="javascript:void();" onClick="mileage2Cash();">포인트:<span id="member_mileage" class="head_2_t_4"><?php echo number_format($TPL_VAR["mileage"],0)?></span>P</a>
				</div>
            </div>
