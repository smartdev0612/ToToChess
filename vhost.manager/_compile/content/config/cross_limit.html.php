<script>
    function go_del(url)
	{
		if(confirm("정말 삭제하시겠습니까?  "))
		{
				document.location = url;
		}
		else
		{
			return;
		}
	}

    function searchMarket() {
        var sport_id = $("#sport_id").val();
        var market_name = $("#market_name").val();
        console.log(sport_id);
        console.log(market_name);
        var data = { sport_id: sport_id, market_name: market_name};
        $.ajax({
            type: 'POST',
            url: "/config/getCrossMarkets",
            dataType : 'json',
            data: data,
            success: function(result) {
                if(result.length > 0) {
                    $("#tbody_markets").empty();
                    $.each(result, function(idx, e) {
                        var tr = "";
                        tr += "<tr><td>" + e.market_id + "</td>";
                        tr += "<td>" + e.name + "</td>";
                        var pieces = e.mname_ko.split("|");
                        switch(e.sport_id) {
                            case 6046:
                                tr += "<td>" + pieces[0] + "</td>";
                                break;
                            case 48242:
                                tr += "<td>" + pieces[1] + "</td>";
                                break;
                            case 154914:
                                tr += "<td>" + pieces[2] + "</td>";
                                break;
                            case 35232:
                                tr += "<td>" + pieces[4] + "</td>";
                                break;
                            case 154830:
                                tr += "<td>" + pieces[3] + "</td>";
                                break;
                            case 687890:
                                tr += "<td>" + pieces[5] + "</td>";
                                break;
                            default: 
                                tr += "<td>" + pieces[0] + "</td>";
                                break;
                        }
                        tr += "</tr>"
                        $("#tbody_markets").append(tr);
                    });
                } else {
                    alert("미안하지만 검색자료가 없습니다.");
                }
            },
            error: function(e) {
                console.log(e.responseText);
            }
        });
    }
</script>

<style>
    /* Style the tab */
    .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
    }

    /* Style the buttons that are used to open the tab content */
    .tab button { 
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
        background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent1 {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }

    .tabcontent2 {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }

    .tabcontent3 {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }

    .tabcontent4  {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }

    .tabcontent5 {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }

    .search-position {
        position: relative;
        top: 7px;
    }

</style>
<div class="wrap" style="width: 100%">

    <div id="route">
        <h5>관리자 시스템 > 미니게임 관리 > <b>스포츠 배팅제한설정</b></h5>
    </div>

    <h3>스포츠 배팅제한설정</h3>
    <div style="display: flex;">
        <div style="width:5%;"></div>
        <div  style="width:40%;">
            <label class="search-position">종목</label>
            <select  class="search-position" id="sport_id">
                <option value=""> 전체</option>
                <?
                foreach($TPL_VAR["sportlist"] as $sport) { ?>
                <option value="<?=$sport["sn"]?>"><?=$sport["name"]?></option>
                <? } ?>
            </select>
            <label  class="search-position">마켓명</label>
            <input  class="search-position" type="text" id="market_name" value="">
            <button type="button" onclick="searchMarket();" style="float:right; width:60px; height:30px;">검색</button>
            <table cellspacing="1" class="tableStyle_gameList" style="margin-top:22px;">
                <thead>
                    <tr>
                        <th>아이디</th>
                        <th>종목</th>
                        <th>마켓명</th>
                    </tr>
                </thead>
                <tbody id="tbody_markets">
                <?php
                foreach($TPL_VAR["list"] as $TPL_V) { ?>
                    <tr>
                        <td><?=$TPL_V["market_id"]?></td>
                        <td><?=$TPL_V["name"]?></td>
                        <td>
                            <?php 
                            $pieces = explode("|", $TPL_V["mname_ko"]);
                            switch($TPL_V["sport_id"]) {
                                case 6046: // 축구
                                    echo $pieces[0];
                                    break;
                                case 48242: // 농구
                                    echo $pieces[1];
                                    break;
                                case 154914: // 야구
                                    echo $pieces[2];
                                    break;
                                case 35232: // 아이스 하키
                                    echo $pieces[4];
                                    break;
                                case 154830: // 배구
                                    echo $pieces[3];
                                    break;
                                case 687890: // E스포츠
                                    echo $pieces[5];
                                    break;
                                default:
                                    echo $pieces[0];
                                    break;
                            }
                            ?>
                        </td>
                    </tr>
                <?php }
                ?>
                </tbody>
            </table>
        </div>
        <div style="width:5%;"></div>
        <div style="width:40%;">
            <button type="button" onclick="window.open('/config/popup_limit_edit','','scrollbars=yes,width=450,height=250,left=5,top=0');" style="float:right; width:60px; height:30px; margin-bottom:10px;">+ 추가</button>
            <table cellspacing="1" class="tableStyle_gameList">
                <thead>
                    <tr>
                        <th>타입</th>
                        <th>종목</th>
                        <th>배팅조합</th>
                        <th>처리</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if(count((array)$TPL_VAR["crossLimitList"]) == 0) { ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php } else { 
                    foreach($TPL_VAR["crossLimitList"] as $item) { ?>
                        <tr>
                            <td>
                                <?php
                                switch($item["type_id"]) {
                                    case 1:
                                        echo "국내형";
                                        break;
                                    case 2:
                                        echo "해외형";
                                        break;
                                    case 3:
                                        echo "라이브";
                                        break;
                                }
                                ?>
                            </td>
                            <td><?=$item["sport_name"]?></td>
                            <td><?=$item["cross_script"]?></td>
                            <td>
                                <button type="button" onclick="window.open('/config/popup_limit_edit?limit_id=<?=$item["limit_id"]?>','','scrollbars=yes,width=450,height=250,left=5,top=0');">수정</button>
                                <button type="button" onclick="go_del('/config/crosslimit?act=delete&limit_id=<?=$item["limit_id"]?>');">삭제</button>
                            </td>
                        </tr>
                <?php }
                }
                ?>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>