<?php
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
</head>

<body>
<div id="wrap" id="members">
    <h1>회원 목록</h1>

    <table cellspacing="1" class="tableStyle_normal" summary="회원목록" style="width: 100%">
        <legend class="blind">회원목록</legend>
        <thead>
        <tr>
            <th scope="col" style="width: 50px">ID</th>
            <th scope="col" class="id">닉네임</td>
            <th scope="col">예금주</td>
            <th scope="col">보유금액</td>
            <th scope="col">입금</td>
            <th scope="col">출금</td>
            <th scope="col">배팅</td>
            <th scope="col">회원등급</th>
            <th scope="col">가입일</th>
            <th scope="col">최근접속일</th>
            <th scope="col">가입IP</th>
            <th scope="col">최근접속IP</th>
            <th scope="col">상태</th>
        </tr>
        </thead>
        <tbody>
        <?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
            <tr>
                <td><?php echo $TPL_V1["uid"]?></td>
                <td><?php echo $TPL_V1["nick"]?></td>
                <td><?php echo $TPL_V1["bank_member"]?></td>
                <td><?php echo number_format($TPL_V1["g_money"],0)?></td>
                <td><?php echo number_format($TPL_V1["charge_money"],0)?></td>
                <td><?php echo number_format($TPL_V1["exchange_money"],0)?></td>
                <td><?php echo number_format($TPL_V1["bet_money"],0)?></td>
                <td width="5%"><?php echo $TPL_VAR["arr_mem_lev"][$TPL_V1["mem_lev"]]?></td>
                <td><?php echo $TPL_V1["regdate"]?></td>
                <td><?php echo $TPL_V1["last_date"]?></td>
                <td><?php echo $TPL_V1["reg_ip"]?></td>
                <td><?php echo $TPL_V1["mem_ip"]?></td>
                <td>
                    <?php if($TPL_V1["mem_status"]=='N'){?>정상
                    <?php }elseif($TPL_V1["mem_status"]=='S'){?>정지
                    <?php }elseif($TPL_V1["mem_status"]=='B'){?>불량
                    <?php }elseif($TPL_V1["mem_status"]=='W'){?>신규
                    <?php }elseif($TPL_V1["mem_status"]=='G'){?>테스터
                    <?php }?>
                </td>
            </tr>
        <?php }}?>
        </tbody>
    </table>
</div>
</body>
</html>