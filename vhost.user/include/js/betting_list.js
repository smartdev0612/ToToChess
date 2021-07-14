$j().ready(function(){
    $j("#btnConfirm").on("click", function() {
        betcancel_popup_close();
        var betting_no = $j("#betting_no").val();
        var type = $j("#type").val();
        var url = "";
        if(type == 1) {
            url = "/race/betCancelProcess";
        } else if (type == 2) {
            url = "/race/betlisthideProcess";
        }
    
        var data = {'betting_no': betting_no};
        $j.ajax({
            url : url,
            data : data,
            type : "post", 
            dataType : "text",
            success: function(res) {
                warning_popup(res);
                location.reload();
            },
            error: function(xhr,status,error) {
                var error = error;
            }
        });
    });
    
    $j("#btnCancel").on("click", function() {
        betcancel_popup_close();
    })    
});

function getBettingList(type, pc, page_index) {
    $j(".bt_off").removeClass("act");
    $j("#type").val(type);
    if(type == 1) {
        $j(".tab_sport").addClass("act");
        $j("#betType").text("스포츠");
    } else if(type == 2) {
        $j(".tab_live").addClass("act");
        $j("#betType").text("라이브");
    } else if(type == 3) {
        $j(".tab_minigame").addClass("act");
        $j("#betType").text("미니게임");
    }
    $j.ajax({
        url : "/race/getBettingList",
        type : "get",
        data: {
            type : type,
            pc: pc,
            page_index: page_index
        },
        success: function(res) {	
            //console.log(res);
            $j("#betting_list").html(res);
        }
    });
}

function goPage(pc, page_index) {
    $j(".page").removeClass("active");
    $j(".p_" + page_index).addClass("active");
    var type = $j("#type").val();
    getBettingList(type, pc, page_index);
}

$j(function(){ 
    var ww2 = window.innerWidth;
    if(ww2 <= 1200) {
        $j("#pc_betting_cart").empty();
    }else {
        $j("#mobile_betting_cart").empty();
    }
});
$j(window).resize(function() { 
    var ww2 = window.innerWidth;
    if(ww2 <= 1200) {
        $j("#pc_betting_cart").empty();
    }else {
        $j("#mobile_betting_cart").empty();
    }
});

var page = "1";
var mode = "betting";

function select_check_one(gid){
    var f = document.bettingList;
    for( var i = 0; i < f['chk'].length; i++){
        if( f['chk'][i].value == gid ) {
            f['chk'][i].checked=true;
            break;
        }
    }
}

function select_betting() {
    var f = document.bettingList;
    var tmpGid = "";

    for( var i = 0; i < f['chk'].length; i++)
    {
        if( f['chk'][i].checked == true ) tmpGid +=  f['chk'][i].value+",";
    }

    if( typeof(f['chk'].length) == "undefined" )
    {
        tmpGid += f['chk'].value+",";
    }

    if( tmpGid == "" )
    {
        warning_popup("배팅내역을 선택해주세요!");
        return false;
    }

    if (!confirm("해당경기를 게시판에 등록하시겠습니까?"))
        return;

    if( opener && opener.fwrite){
        opener.fwrite.wr_1.value = "["+tmpGid+"]";
        window.close();

    }else{

        document.form.bo_table.value = "z30";
        document.form.wr_1.value = "["+tmpGid+"]";

        document.form.action = "./write.php";
        document.form.submit();
    }
}

function select_delete(all_flag) {
    if(typeof(all_flag)=="undefined") all_flag=false;
    else all_flag=true;

    var f = document.bettingList;
    var tmpGid = "";

    var cnt = f['chk'].length;
    for( var i = 0; i < cnt; i++)
    {
        if( f['chk'][i].checked == true || all_flag ) tmpGid +=  f['chk'][i].value+",";
    }

    if( typeof(f['chk'].length) == "undefined"  )
    {
        if( f['chk'].checked == true || all_flag ) tmpGid =  f['chk'].value+",";
    }

    if( tmpGid == "" )
    {
        warning_popup("배팅내역을 선택해주세요!");
        return false;
    }

    if (!confirm("해당 배팅내역을 삭제하시겠습니까?"))
        return;

    req = create_request();
    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            if (req.status == 200) {
                var returntext = req.responseText;
                tmpstr = returntext.split("||");
                if( tmpstr[0] == "E0000") warning_popup("해당 배팅내역은 미정산내역이므로 삭제할 수 없습니다.");
                if( tmpstr[0] == "E0001") warning_popup("선택하신 내역중 미정산내역은 제외하고 "+tmpstr[1]+" 삭제됩니다.");
                if( tmpstr[0] == "S0001") warning_popup("선택하신 내역중 미정산인 경기를 제외하고 "+tmpstr[1]+" 삭제하였습니다.");
                location.href=g4_path+"/bbs/betting.php?mode="+mode+"&&page="+page;
            }
        }
    }

    req.open("POST", g4_path+'/bbs/betting_delete.php', true);
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    var params = '&gid='+tmpGid+'&mode='+mode+'&page='+page;

    req.send(params);
}

function delete_cart(gid, mode, page) {
    if (!confirm("해당 세트를 삭제하시겠습니까?"))
        return;

    window.location = "./betting_delete.php?gid="+gid+"&mode="+mode+"&page="+page;
}

function cancel_betting(gid,mode){
    document.location.href = 'betting_cancel.php?gid='+gid;
}

function cancel_bet(betting_no)
{
    betcancel_popup("정말 취소하시겠습니까?", betting_no, 1);
}

function hide_bet(betting_no)
{
    betcancel_popup("정말 삭제하시겠습니까?", betting_no, 2);
}

function hide_all_betting() {
    if(confirm("정말 모든 배팅내역을 삭제하시겠습니까?")) {
        document.location = "/race/hide_all_betting";
    }
}

function on_upload(bettings) {
    if ( !bettings ) {
        var bettings="";
        $("[name=upload_checkbox]").each( function(index) {
            if(this.checked) {
                var betting_no = this.value;
                bettings += betting_no;
                bettings += ";";
            }
        });
    }
    document.location.href="/board/write?bettings="+bettings;
}


function betcancel_popup(text, betting_no, type) {
    console.log(betting_no);
    $j("#betcancel_popup .pop_message").text(text);
    $j("#betcancel_popup").fadeIn();
    $j("#coverBG").fadeIn();
    $j("#betting_no").val(betting_no);
    $j("#type").val(type);
    // setTimeout(warning_popup_close, 1500);
}

function betcancel_popup_close() {
    $j("#betcancel_popup").fadeOut();
    $j("#coverBG").fadeOut();
}