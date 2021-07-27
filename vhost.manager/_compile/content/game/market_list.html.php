<?php
    $marketList=empty($TPL_VAR["list"]) ? [] : $TPL_VAR["list"];
?>
<script>document.title = '마켓목록';</script>
<script>
	function go_del(url)
	{
		if(confirm("정말 삭제하시겠습니까?"))
		{
			document.location = url;
		}
		else 
		{
			return;
		}
	}

    function searchMarkets() {
        document.searchForm.submit();
    }

    function saveMarketRate() {
        document.saveForm.submit();
    }
</script>

<div class="wrap">

	<h3>마켓 목록</h3>

	<div id="search2">
		<div class="wrap" style="width:100%;">
			<form action="/game/marketList" method="post" id="searchForm" name="searchForm" >
				<span>마켓검색</span>
				<!-- 키워드 검색 -->
				<input type="text" name="keyword" class="name" value="<?php echo $TPL_VAR["keyword"]?>" maxlength="20" onmouseover="this.focus()"/>
				
				<!-- 검색버튼 -->
				<input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" onclick="searchMarkets();" title="검색" />
            </form>
            <input type="button" value="보관" onclick="saveMarketRate();" class="Qishi_submit_a" style="float:right; margin-right:20px;" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
		</div>
        
	</div>

	<form id="saveForm" name="saveForm" method="post" action="/game/saveMarketRate">
        <table cellspacing="1" class="tableStyle_members add" summary="부본사 목록">
            <thead>
                <tr>
                    <th scope="col">아이디</th>
                    <th scope="col">마켓명</th>
                    <th scope="col">마켓명(영문)</th>
                    <th scope="col">환수율</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($marketList as $market) { ?>
                <tr>
                    <td style="text-align:center;"><?=$market["mid"]?></td>
                    <td style="text-align:center;">
                        <?
                            $pieces = explode("|", $market["mname_ko"]);
                            echo $pieces[0];
                        ?>
                    </td>
                    <td style="text-align:center;"><?=$market["mname_en"]?></td>
                    <td style="text-align:center;"><input type="text" id="fRate_<?=$market["mid"]?>" name="fRate_<?=$market["mid"]?>" value="<?=$market["fRate"]?>" style="text-align:right;"></td>
                </tr>
                <?php }
                ?>
                			
            </tbody>
        </table>
    </form>
	<div id="pages">
		<?php echo $TPL_VAR["pagelist"]?>
	</div>

	<div id="wrap_btn">
    </div>

</div>