<?php
$TPL_partner_list_1=empty($TPL_VAR["partner_list"])||!is_array($TPL_VAR["partner_list"])?0:count($TPL_VAR["partner_list"]);
$TPL_levelList_1=empty($TPL_VAR["levelList"])||!is_array($TPL_VAR["levelList"])?0:count($TPL_VAR["levelList"]);
$TPL_joiners_1=empty($TPL_VAR["joiners"])||!is_array($TPL_VAR["joiners"])?0:count($TPL_VAR["joiners"]);
$TPL_memoList_1=empty($TPL_VAR["memoList"])||!is_array($TPL_VAR["memoList"])?0:count($TPL_VAR["memoList"]);?>

</head>
<body>

<div id="wrap_pop">
	<div id="pop_title">
		<h1>배팅 상세정보</h1>
		<p><img src="/img/btn_s_close.gif" onClick="window.close()" title="창닫기"></p>
	</div>

	<table cellspacing="1" class="tableStyle_normal" summary="배팅 내역">			
        <legend class="blind">배팅 내역</legend>
        <thead>
            <tr>
                <th width="4%">배팅번호</th>
                <th width="5%">닉네임</th>
                <th width="5%">배팅액</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($TPL_VAR["list"] as $item) {?>
            <tr>
                <td width="70"><?=$item["betting_no"]?></td>
                <td><?=$item["uid"]?></td>
                <td><?=$item["bet_money"]?></td>
            </tr>
            <?php }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>