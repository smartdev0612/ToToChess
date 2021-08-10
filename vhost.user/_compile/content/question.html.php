
	<div class="mask"></div>
	<div id="container">
<script language="javascript">
    // 글자수 제한
    var char_min = parseInt(0); // 최소
    var char_max = parseInt(0); // 최대
</script>
<style>
    .board_write #geditor_content_geditor_html_source_div input {width:20px;height:20px;margin:0;}
    .board_write select#geditor_content_geditor_status {width:60px;height:20px;margin:0;color:#000;}
    .board_write input.option_chk {width:15px;height:15px;margin:0;}
    .board_write select.event_name {width:120px;height:20px;margin:0;color:#000;}
    .cs-content {
        width: 90%; 
        word-break:break-all; 
        border:1px #100e0f solid; 
        color:#333333; 
        margin: 0px 5% 0px 5% !important;
    }
    .td-margin {
        margin: 0px 5% 0px 5% !important;
    }
    .answer-content {
        width: 90%; 
        background: #2d2e35;
        box-shadow: rgb(0 0 0 / 35%) 0px 2px 3px, rgb(255 255 255 / 22%) 1px 1px 1px -2px inset;
        border-radius: 5px;
        border: 1px solid transparent;
        margin: 0px 5% 0px 5% !important;
        padding: 10px;
    }
</style>
<script type="text/javascript" src="/10bet/js/left.js?1611022477"></script>
		
<form name="fwrite" id="fwrite" method="post" onsubmit="return fwrite_check(this);" enctype="multipart/form-data" style="margin:0px;">
    <input type="hidden" name="act" value="add">
    <input type="hidden" name="site_code" value="site-a">	
    <div id="contents">
        <div class="board_box">
            <h2>고객센터</h2>
            <!-- 게시판 -->
            <div class="board_write">
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td colspan="2">
                        <?php 
                        if($TPL_VAR["idx"] > 0) { ?>
                            <p class="answer-content"><?=$TPL_VAR["question"][0]["subject"]?></p>
                        <?php } else { ?>
                            <input type="text" name=title id="title" placeholder="제목" value="" />
                        <?php 
                            }
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <p class="td-margin">문의:</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php 
                            if($TPL_VAR["idx"] > 0) { ?>
                                <p class="answer-content"><?=$TPL_VAR["question"][0]["content"]?></p>
                            <?php } else { ?>
                                <textarea id="content" name="content" class="cs-content" rows=15 itemname="내용"></textarea>
                            <?php 
                                }
                            ?>
                        </td>
                    </tr>
                    <?php 
                    if($TPL_VAR["idx"] > 0 && count($TPL_VAR["reply"]) > 0) {
                    ?>
                    <tr>
                        <td colspan="2"> 
                            <p class="td-margin">답변:</p> 
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <p class="answer-content"><?=nl2br(html_entity_decode($TPL_VAR["reply"][0]["content"]))?></p>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
                <div class="btn_center">
                    <?php 
                    if($TPL_VAR["idx"] == 0) {
                    ?>
                    <button type="submit" class="button_type01">문의등록</button>
                    <?php } ?>
                    <button type="button" class="button_type01" onClick="location.href='./cs_list'">목록보기</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script language="javascript">
    
    function clickNotice(v){
        var msg='';
        if( v ==1 ) {
            $j('#chk_event').attr('checked',false);
            if( $j('#chk_notice').is(':checked') ) {
                //msg = '[공지] ';
                document.fwrite.notice.value=1;
                document.fwrite.wr_8.value='';
            }else {
                document.fwrite.notice.value='';
                document.fwrite.wr_8.value='';
            }
        }
        else{
            $j('#chk_notice').attr('checked',false);
            if( $j('#chk_event').is(':checked') ) {
                //msg ='[이벤트] ';
                document.fwrite.notice.value=1;
                document.fwrite.wr_8.value='event';
            }else {
                document.fwrite.notice.value='';
                document.fwrite.wr_8.value='';
            }
        }

        var obj = document.fwrite.title;
        //obj.value = obj.value.replace('[공지]','');
        //obj.value = obj.value.replace('[이벤트]','');
        obj.value = msg +$j.trim(obj.value);
    }

    function setColor(val)
    {
        document.fwrite.wr_2.value = val;
    }
    function openBetting(){
        window.open('../bbs/betting.php?mode=betting&popup=1', 'gamelist', 'left=50, top=50, width=1284, height=500, scrollbars=1');
    }

    function html_auto_br(obj) {
        if (obj.checked) {
            result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
            if (result)
                obj.value = "html2";
            else
                obj.value = "html1";
        }
        else
            obj.value = "";
    }



    function sel_hour(id, value)
    {
        document.getElementById(""+id+"").value = value;
    }

    function sel_min(id, value)
    {
        document.getElementById(""+id+"").value = value;
    }


    function check_key() {
        var char_ASCII = event.keyCode;

        //숫자 -+ 없이 숫자만
        if ((char_ASCII >= 48 && char_ASCII <= 57 ) || (char_ASCII == 46) || (char_ASCII == 43) || (char_ASCII == 45))
        return 1;
        //영어
        else if ((char_ASCII>=65 && char_ASCII<=90) || (char_ASCII>=97 && char_ASCII<=122))
            return 2;
        //특수기호
        else if ((char_ASCII>=33 && char_ASCII<=47) || (char_ASCII>=58 && char_ASCII<=64)
        || (char_ASCII>=91 && char_ASCII<=96) || (char_ASCII>=123 && char_ASCII<=126))
            return 4;
        //한글
        else if ((char_ASCII >= 12592) || (char_ASCII <= 12687))
            return 3;
        else
            return 0;
    }

    //텍스트 박스에 숫자와 영문만 입력할수있도록

    function nonHangulSpecialKey() {
        if(check_key() != 5 && check_key() != 2) {
            event.returnValue = false;
            warning_popup("숫자나 영문자만 입력하세요!");
            return;
        }
    }

    //텍스트 박스에 숫자만 입력할수 있도록
    function numberKey() {
        if(check_key() != 1 ) {
            event.returnValue = false;
            warning_popup("숫자만 입력할 수 있습니다.");
            return;
        }
    }

    function hourKey(str) {
        if(Number(str.value) > 23){
            warning_popup('1 부터 23 이하만 입력할 수 있습니다.');
            str.value = "";
            str.focus();
            return;
        }else if (str.value.length == 1){
            str.value = "0" + str.value +"";
        }
    }
    function minKey(str) {
        if(Number(str.value) > 60){
            warning_popup('1 부터 59 이하만 입력할 수 있습니다.');
            str.value = "";
            str.focus();
            return;
        }else if (str.value.length == 1){
            str.value = "0" + str.value +"";
        }
    }

    function fwrite_check(f) {
        var s = "";
        if (s = word_filter_check(f.title.value)) {
            warning_popup("제목에 금지단어('"+s+"')가 포함되어있습니다");
            return false;
        }
        try{
            f.content.value = geditor_content.get_content();
        }catch(e){
        }
        if( f.title.value=='' ){
            warning_popup("제목은 필수입니다");
            //f.title.focus();
            return false;
        }
        if( f.content.value=='' ){
            warning_popup("내용은 필수입니다");
            f.content.focus();
            return false;
        }

        if (s = word_filter_check(f.content.value)) {
            warning_popup("내용에 금지단어('"+s+"')가 포함되어있습니다");
            return false;
        }

        if (typeof(f.wr_key) != "undefined") {
            if (hex_md5(f.wr_key.value) != md5_norobot_key) {
                warning_popup("자동등록방지용 빨간글자가 순서대로 입력되지 않았습니다.");
                f.wr_key.focus();
                return false;
            }
        }

        //document.getElementById('btn_submit').disabled = true;
        //document.getElementById('btn_list').disabled = true;

        f.action = './cs_list';    
        return true;
    }
    $j(function (){
        var wr_5 = "";
        $j('select[name="wr_5"]').val(wr_5);
        
        if (wr_5 != '' && $j('select[name="wr_5"] option:selected').val() == "") {
            $j('select[name="wr_5"]').append("<option value='' selected></option>");
        }
    });
</script>

<script language="JavaScript" src="/10bet/js/board.js"></script>
<script language='javascript'> var g4_cf_filter = ''; </script>
<script language='javascript' src='/10bet/js/filter.js'></script>