function showDP()
{
    if(self.gfPop)
    {
        var dpFrom = document.getElementById("dpFrom");
        gfPop.fPopCalendar(dpFrom);
    }
    return false;
}

function showDPFrom()
{
    if(self.gfPop)
    {
        var dpFrom = document.getElementById("dpFrom");
        var dpTo = document.getElementById("dpTo");
        gfPop.fStartPop(dpFrom,dpTo);
    }
    return false;
}

function showDPTo()
{
    if(self.gfPop)
    {
        var dpFrom = document.getElementById("dpFrom");
        var dpTo = document.getElementById("dpTo");
        gfPop.fEndPop(dpFrom,dpTo);
    }
    return false;
}


function showDP(id)
{
    if(self.gfPop)
    {
        var dpFrom = document.getElementById("dpFrom");
        var dpTo = document.getElementById("dpTo");
        gfPop.fPopCalendar(dpFrom, dpTo);
    }
    return false;
}

function pickDate(d)
{
    var dpFrom = document.getElementById("dpFrom");
    dpFrom.value = d;
    document.getElementById("form1").submit();
    return false;
}

function submitDP()
{
    var dpFrom = document.getElementById("dpFrom");
    var dpTo = document.getElementById("dpTo");
    if (dpFrom.value == "")
        return false;
    if (dpTo && dpTo.value == "")
        return false;
    document.getElementById("form1").submit();
    return false;
}

function viewReport(hist)
{
    var mode = document.getElementById("mode");
    hist == "history" ? mode.value = "10" : mode.value = "0";
    var dpFrom = document.getElementById("dpFrom");
    var dpTo = document.getElementById("dpTo");
    dpFrom.value="";
    if (dpTo) dpTo.value==""
    document.getElementById("form1").submit();
}

function f_OnYearChange(v_value,v_fromID,v_toID)
{
    var v_ddlMonth = document.getElementById("ddlMonth");
    var v_str ="";
    var v_option = "<span><SELECT id=ddlMonth onchange=f_OnMonthChange(this.value,'"+v_fromID+"','"+v_toID+"')> ";
    //var v_isFirst = true;
    var v_selectedMonth
    if (v_value != null || v_value!="")
    {
        var v_dts = v_value.split(';');
        var v_dt;
       
        for(var i = 0; i<v_dts.length;i++)
        {
            v_str = v_dts[i];
            v_dt = v_str.split('#');
            if(i==0)
            {
                v_selectedMonth =  v_dt[1];
            }
            //v_option += "<OPTION value=" + v_dt[1] + (v_isFirst?' selected':'')+ " >" + v_dt[0] + "</OPTION>";           
            v_option += "<OPTION value=" + v_dt[1] + " >" + v_dt[0] + "</OPTION>";           
            v_isFirst = false;
        }
    }
    v_option += "</SELECT></span>";
    v_ddlMonth.parentNode.innerHTML = v_option;
    f_OnMonthChange(v_selectedMonth,v_fromID,v_toID);
}

function f_OnMonthChange(v_value,v_fromID,v_toID)
{
    var Date=[];
    if (v_value==null)
    {
        v_value = f_TodayStr();
    }
    var v_Date = v_value.split('|');
    if (self.gfPop) gfPop.setDateBoundary(v_Date[0],v_Date[1]);
    
    var v_from = document.getElementById(v_fromID);
    var v_to = document.getElementById(v_toID);

    v_from.value = v_Date[0];
    if(v_to)
    {
       //var tempDate = f_AddDeductDays(v_Date[0],3,'add');
       v_to.value = v_Date[1];
    }
}

function f_AddDeductDays(v_Date, v_NoOfDays, v_AddDeduct)
{
    var tempDate = null;
    if(v_AddDeduct.toLowerCase()=="add")
    {
        tempDate = new Date(new Date(v_Date).getTime() + (v_NoOfDays*24*60*60*1000));        
    }
    else
    {
        tempDate = new Date(new Date(v_Date).getTime() - (v_NoOfDays*24*60*60*1000));
    }
    var month = eval(tempDate.getMonth()+1);
    var day = eval(tempDate.getDate());    
    if(month<10)
    {
        month = '0' + month;
    }
    if(day<10)
    {
        day = '0' + day;
    }
    
    var endDate = month +'/'+day+'/'+ eval(tempDate.getFullYear());  
    return endDate;
}
function f_TodayStr() 
{
    var today=new Date()
    var lastday = lastDateInMonth(today.getMonth(),today.getYear())
    return (today.getMonth()+1)+"/"+today.getDate()+"/"+(today.getYear() + 1900)+"|"+
        (lastday.getMonth()+1)+"/"+lastday.getDate()+"/"+(lastday.getYear() + 1900)
}


function f_SetArchiveDropdowns(v_YearValue,v_MonthValue,v_fromID,v_toID)
{
    var v_ddlYear =document.getElementById("ddlYear");
    var v_ddlMonth =document.getElementById("ddlMonth");    
    f_SetDropdownIndex(v_ddlYear,v_YearValue);
    f_SetDropdownIndex(v_ddlMonth,v_MonthValue);
}
 
function f_SetDropdownIndex(v_control, v_val)
{
    v_control.selectedIndex=f_GetDropdownIndex(v_control,v_val);
}
function f_GetDropdownIndex(v_control, v_val) 
{
    for (i=0;i<v_control.options.length;i++) 
    {
        if (v_control.options[i].value == v_val) 
        {
            return i;
        }
    }
    return 0;
}