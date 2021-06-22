<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
</head>

<body>
<div class="wrap" id="members">

    <div id="route">
        <h5>관리자 시스템 > 회원 관리 > <b>현재접속자 목록</b></h5>
    </div>

    <h3>현재접속자 목록</h3>

    <form id="form1" name="form1" method="post" action="?act=delete_user">
        <table cellspacing="1" class="tableStyle_normal" summary="회원 접속기록">
            <legend class="blind">접속기록</legend>
            <thead>
            <tr>
                <th scope="col" style="width: 50px"></th>
                <th scope="col" class="id">아이디</td>
                <th scope="col">닉네임</td>
                <th scope="col">등급</td>
                <th scope="col">보유금액</td>
                <th scope="col">로그인 도메인</td>
            </tr>
            </thead>
            <tbody>
            <?php if($TPL_list_1){ $idx=1; foreach($TPL_VAR["list"] as $TPL_V1){?>
                <tr>
                    <td><?php echo $idx?></td>
                    <td>
                        <a href="javascript:open_window('/member/popup_detail?idx=<?php echo $TPL_V1["sn"]?>',1024,600)"><?php echo $TPL_V1["uid"]?></a>
                    </td>
                    <td><?php echo $TPL_V1["nick"]?></td>
                    <td><?php echo $TPL_VAR["levelList"][$TPL_V1["mem_lev"]]?></span></td>
                    <td><?php echo number_format($TPL_V1["g_money"],0)?></td>
                    <td><?php
                        $device = "PC";
                        if($TPL_V1["login_domain"] == "m.memopow.com")
                            $device = "모바일";
                        
                        echo $TPL_V1["login_domain"]." (".$device.")";
                        ?></td>
                </tr>
            <?php $idx++;}}?>
            </tbody>
        </table>
    </form>
</div>
</body>
</html>