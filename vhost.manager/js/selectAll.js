// JavaScript Document
//复选
function selectAll(chk)
{
	
var chk = document.form1.chkAll.checked;
for (i=0;i<document.all.length;i++) {
if (document.all[i].name=="y_id[]") {
document.all[i].checked=chk;
chkRow(document.all[i]);
}}}


//复选后单元格变色
function chkRow(obj)
{
	var r = obj.parentElement.parentElement;
	if(obj.checked)
	{
		r.style.backgroundColor="";
	}
	else
	{
		if(r.rowIndex%2==1)
			r.style.backgroundColor="";
		else 
			r.style.backgroundColor="";
	}
}
