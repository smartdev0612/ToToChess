<!-- left 메뉴 -->
<div id="left_section">
    <div class="left_box">
        <div class="other_menu_list	box_type01">
            <!-- 메뉴 리스트	-->
            <ul class="mune_list01">
            <?php 
            if($TPL_VAR["miniSetting"]["power_use"]==1){?>
                <li>
                    <a href="/game_list?game=power">
                        <div class="menu01 <?= $TPL_VAR["game_type"] == 'power' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_powerball_01.png" alt="ico" /> 
                            파워볼									
                        </div>
                    </a>
                </li>
            <?php } 
            if($TPL_VAR["miniSetting"]["powersadari_use"]==1){?>
                <li>
                    <a href="/game_list?game=psadari">
                        <div class="menu01 <?= $TPL_VAR["game_type"] == 'psadari' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_powersadari_01.png" alt="ico" /> 
                            파워사다리									
                        </div>
                    </a>
                </li>
            <?php } 
            if($TPL_VAR["miniSetting"]["kenosadari_use"]==1){?>
                <li>
                    <a href="/game_list?game=kenosadari">
                        <div class="menu01 <?= $TPL_VAR["game_type"] == 'kenosadari' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_powersadari_01.png" alt="ico" /> 
                            키노사다리									
                        </div>
                    </a>
                </li>
            <?php } 
            if($TPL_VAR["miniSetting"]["fx_use"]==1){?>
                <li>
                    <a href="/game_list?game=fx&min=1">
                        <div class="menu01 <?= $TPL_VAR["min"] == '1' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_fx_01.png" alt="ico" /> 
                            FX1분									
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/game_list?game=fx&min=2">
                        <div class="menu01 <?= $TPL_VAR["min"] == '2' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_fx_01.png" alt="ico" /> 
                            FX2분									
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/game_list?game=fx&min=3">
                        <div class="menu01 <?= $TPL_VAR["min"] == '3' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_fx_01.png" alt="ico" /> 
                            FX3분									
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/game_list?game=fx&min=4">
                        <div class="menu01 <?= $TPL_VAR["min"] == '4' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_fx_01.png" alt="ico" /> 
                            FX4분									
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/game_list?game=fx&min=5">
                        <div class="menu01 <?= $TPL_VAR["min"] == '5' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_fx_01.png" alt="ico" /> 
                            FX5분									
                        </div>
                    </a>
                </li>
            <?php } 
            if($TPL_VAR["miniSetting"]["choice_use"]==1){?>                        
                <li>
                    <a href="/game_list?game=choice">
                        <div class="menu01 <?= $TPL_VAR["game_type"] == 'choice' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_sky_01.png" alt="ico" /> 
                            초이스									
                        </div>
                    </a>
                </li>
            <?php } 
            if($TPL_VAR["miniSetting"]["roulette_use"]==1){?>                        
                <li>
                    <a href="/game_list?game=roulette">
                        <div class="menu01 <?= $TPL_VAR["game_type"] == 'roulette' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_hand.png" alt="ico" /> 
                            룰렛									
                        </div>
                    </a>
                </li>
            <?php } 
            if($TPL_VAR["miniSetting"]["pharah_use"]==1){?>                        
                <li>
                    <a href="/game_list?game=pharaoh">
                        <div class="menu01 <?= $TPL_VAR["game_type"] == 'pharaoh' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_bubble.png" alt="ico" />
                            파라오									
                        </div>
                    </a>
                </li>
            <?php } 
            if($TPL_VAR["miniSetting"]["dari2_use"]==1){?>    
                <li>
                    <a href="/game_list?game=2dari">
                        <div class="menu01 <?= $TPL_VAR["game_type"] == '2dari' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_sky_01.png" alt="ico" /> 
                            이다리									
                        </div>
                    </a>
                </li>
            <?php } 
            if($TPL_VAR["miniSetting"]["dari3_use"]==1){?>                        
                <li>
                    <a href="/game_list?game=3dari">
                        <div class="menu01 <?= $TPL_VAR["game_type"] == '3dari' ? 'on' : ''; ?>">
                            <img src="/10bet/images/10bet/ico/ico_sky_01.png" alt="ico" /> 
                            삼다리									
                        </div>
                    </a>
                </li>
            <?php } ?>
            </ul>
        </div>
    </div>
</div>