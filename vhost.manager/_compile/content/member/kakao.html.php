<script>
    function confirmOk()
    {
        fm = document.frm;
        fm.action = "/member/saveKakao";
        fm.submit();
    }
</script>

<div class="wrap">

    <form  method="post" name="frm">
        
        <h3>카카오톡 설정</h3>
        <div id="wrap_btn">
            <input type="hidden" name="mode" value="save">
            <input type="button" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'"  onmouseout="this.className='Qishi_submit_a'" value="저  장" onclick="confirmOk();"/>
        </div>

        <table cellspacing="1" class="tableStyle_membersWrite thBig" summary="카카오톡 설정">
            <tr>
                <th width="20%">관리자 카카오톡</th>
                <td>
                    <span style="margin-left: 40px">아이디:</span> <input type="text" class="w60" name="kakaoID" style="text-align:left; width:100px;" value="<?php echo $TPL_VAR["kakaoID"]?>"/>
                </td>
            </tr>
        </table>
    </form>

</div>