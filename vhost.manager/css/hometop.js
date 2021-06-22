function f_AutoGetData() { 
    //if (parent.autoRef==1)
    //{
        var v_hometoprefresh = document.getElementById("HomeTopRefresh");
        if(v_hometoprefresh == null){
            return false;
        }
        v_hometoprefresh.submit();
    //} 
    //parent.autoRef = 1;
    setTimeout("f_AutoGetData()",60000);
}

function f_UpdateData(totChild, usedCredit, serverTime) {
    try 
    {
	    var cnt = top.window.topRefreshCount;
	    if (! cnt || cnt > 100000) top.window.topRefreshCount = 1;
	    else top.window.topRefreshCount = cnt + 1;
        
        var v_totchild = document.getElementById("TotChild");
        var v_usedcredit = document.getElementById("UsedCredit");
        var v_time = document.getElementById("ServerTime");
        if(v_totchild == null || v_usedcredit == null || v_time == null){
            return false;
        }
        var v_prevTotChild = v_totchild.innerHTML;
        v_totchild.innerHTML = totChild;
        v_usedcredit.innerHTML = usedCredit;
        v_time.innerHTML = serverTime;
        var v_rightframe = parent.document.getElementById("RightFrame");
        if(v_rightframe == null){
            return false;
        }
        var v_balFrameUsedCredit = null;
        var v_balanceframe = v_rightframe.contentWindow.document.getElementById("BalanceFrame");
        if(v_balanceframe == null){
            v_balFrameUsedCredit = v_rightframe.contentWindow.document.getElementById("UsedCredit");
        }
        else{
            v_balFrameUsedCredit = v_balanceframe.contentWindow.document.getElementById("UsedCredit");
        }
        if(v_balFrameUsedCredit == null){
            return false;
        }
        if(v_prevTotChild != totChild){
            parent.RightFrame.location.reload();
            return false;
        }
        v_balFrameUsedCredit.innerHTML = usedCredit;
    }
    catch(err)
    {
        return false;
    }
}

function LangChange(LangID)
{
    var v_hlangid = document.getElementById("hLangID");
    var v_fhometop = document.getElementById("fHomeTop");
    if(v_hlangid == null || v_fhometop == null){
        return false;
    }
    v_hlangid.value = LangID; 
    v_fhometop.submit();
}

function setFont(fontType)
{
    document.getElementById("hdFont").value = fontType;
    document.getElementById("HomeTopRefresh").submit();		
    document.getElementById("hdFont").value = '';
}

function SwitchLogin(obj)
{
    if(obj){
        var uid = obj[obj.selectedIndex].value;
        document.getElementById("hToCustID").value = uid;
        document.getElementById("fHomeTop").submit();
    }
}

function initSelection() {
    document.getElementById("gotSelection").innerHTML = document.getElementById("selectContent").innerHTML;
    document.getElementById("selectContent").innerHTML = "";
}

function setSelection(index) {
    var langSelection = document.getElementById("select");
    langSelection.selectedIndex = index;
}

function f_OpenHelp(link, title) {
    var wHandler = window.open(link, title);
    if (wHandler) wHandler.focus();
}