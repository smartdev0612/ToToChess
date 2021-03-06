var g_home_team="";
var g_away_team="";
var g_live_sn = 0;
var g_min_betting_money=0;
var g_max_betting_money=0;
var g_max_prize_money=0;

function live_betting_initialize($live_sn, $home_team, $away_team, $min_betting_money, $max_betting_money, $max_prize_money)
{
	g_live_sn = $live_sn;
	g_home_team = $home_team;
	g_away_team = $away_team;
	
	g_min_betting_money=$min_betting_money;
	g_max_betting_money=$max_betting_money;
	g_max_prize_money=$max_prize_money;
}

function toogle($template_position)
{
	var splits = $template_position.split('_');
	var position = splits[1];
	
	$("input[name='template_position']:checkbox").each( function() {
		if($(this).val()==$template_position) 
		{
			if($(this).is(":checked")) 
			{
				$(this).prop("checked", false);
			}
			else 
			{
				$(this).prop("checked", true);
			}
		}
		else {
			$(this).prop("checked", false);
		}
	});
	
	toggle_css();
}

function toggle_css()
{
	$("input[name='template_position']:checkbox").each( function() {
		if($(this).is(":checked")) {
			var current_class = $(this).parent().attr('class');
			$(this).parent().attr('class', 'pick');
		}
		else {
			var current_class = $(this).parent().attr('class');
			if(current_class!='socre end')
				$(this).parent().attr('class', '');
		}
	});
	update_betting_slip();
}

function clear_betting_slip()
{
	$("input[name='template_position']:checkbox").each( function() {
		$(this).attr("checked", false);
	});
	 toggle_css();
}

function on_select_teamplate_position($template_position)
{
	if($template_position=='') {
		return;
	}
	
	var odd = $("#template_"+$template_position).text();
	if(odd=="1.00")
		return;

	toogle($template_position);
}

function update_betting_slip()
{
	var table 	= document.getElementById("tb_list");
	
	/*
	var tr_count = table.rows.length;
	for(var i=0; i<tr_count; ++i) {
		table.deleteRow(i);
	}
	*/
	var tr_count = table.rows.length;
	
	if(tr_count > 0)
	{
		var row0 = getObject("tb_row_1_"+g_live_sn);
		table.deleteRow(row0.rowIndex);
		
		var row1 = getObject("tb_row_2_"+g_live_sn);
		table.deleteRow(row1.rowIndex);
	}
	
	initialize_betting_slip();
	
	g_home_team = eval("home_team");
	g_away_team = eval("away_team");
			
	$("input[name='template_position']:checkbox").each( function() {
		if($(this).is(":checked")) {
			//2014.10.7 ?????????????????? ?????? ????????? ?????? ???????????? start //
			var tr0		= table.insertRow(table.rows.length);
			var tr1 	= table.insertRow(table.rows.length);

			tr0.id 		= "tb_row_1_"+g_live_sn;
			tr1.id 		= "tb_row_2_"+g_live_sn;

			var td00		= tr0.insertCell(0);
			var td10		= tr1.insertCell(0);
			
			//width ?????????	
			td00.style.width = '100%';
			td10.style.width = '100%';

			//align ?????????
			td00.style.textAlign = 'left';
			td10.style.textAlign = 'left';
			
			var item = $(this).val();
			var splits = item.split("_");
			var template = splits[0];
			var position = splits[1];
			var position_alias='';
			var team_name='';
			
			switch(position)
			{
				case '1': position_alias="???"; team_name=g_home_team; break;
				case 'X': position_alias="???"; team_name=g_home_team; break;
				case '2': position_alias="??????"; team_name=g_away_team; break;
				default : position_alias=position; team_name=g_home_team+" (vs) "+g_away_team; break;
			}
			
			var odd = $('#template_'+item).text();
			
			//td00.innerHTML = "<span class='name'>"+team_name+"<a href=javascript:clear_betting_slip();><img src='/img/betslip_btn_delete.gif'></a></span>";
			//td10.innerHTML = "<span class='pick'>"+parseFloat(odd).toFixed(3)+"</span><span class='rate'>"+position_alias+"</span>";
			//td2.innerHTML = "<span class='pick'>"+parseFloat(odd).toFixed(3)+"</span>&nbsp;<a href=javascript:clear_betting_slip();>&nbsp;<img src='/img/betslip_btn_delete.gif' align='absmiddle'></a></span>";

			td00.innerHTML = "<div class=\"betting_cart_list\">" +
												"<ul>" +
													"<li class=\"betting_cart_list_league\">"+team_name+"</li>" +
													"<li class=\"betting_cart_list_del\"><a href=\"javascript:clear_betting_slip();\"><img src=\"/new_images/cart_del_icon.png\" /></a></li>" +
													"<li class=\"betting_cart_list_odd\">"+parseFloat(odd).toFixed(3)+" ["+position_alias+"]</li>" +
												"</ul>" +
											"</div>";

			//2014.10.7 end//
			
			$('#sp_bet').text(parseFloat(odd).toFixed(3));
			
			
			var betting_money = document.frm_betting_slip.betting_money.value;
			betting_money = betting_money.replace(/,/gi,"");
			$('#sp_bet').text(parseFloat(odd).toFixed(3));
			
			document.frm_betting_slip.template.value=template;
			document.frm_betting_slip.position.value=position;
			document.frm_betting_slip.odd.value=odd;
			
			calculate_money();
		}
	});
}

function initialize_betting_slip()
{
	document.frm_betting_slip.template.value='';
	document.frm_betting_slip.position.value='';
	document.frm_betting_slip.odd.value='';
	
	$('#sp_bet').text('0.00');
	$('#sp_total').text('0');
}

function calculate_money()
{
	var betting_money = document.frm_betting_slip.betting_money.value;
	betting_money = betting_money.replace(/,/gi,"");
	var odd = $('#sp_bet').text();
	var total_profit = moneyFormat(Math.floor(betting_money*odd));
	
	$('#sp_total').text(total_profit);
}

function on_betting() 
{
	var betting_money = document.frm_betting_slip.betting_money.value;
	betting_money = betting_money.replace(/,/gi,"");
	
	var prize_money = $('#sp_total').text();
	prize_money = prize_money.replace(/,/gi,"");
	
	var odd = document.frm_betting_slip.odd.value;

	if(odd=="")
	{
		alert("????????? ????????? ??????????????????.");
		return;
	}

	if(isNaN(odd))
	{
		alert("????????? ????????? ??????????????????.");
		return;
	}
	if(isNaN(betting_money))
	{
		alert("???????????? ????????? ????????? ???????????? ????????????");
		return;
	}
/*	
	if (betting_money < 5000 || betting_money > 50000) 
	{
		alert("??????????????? ??????~?????? 5,000??? ~ 50,000??? ?????????.");
		return;
	}
*/
	if (betting_money < g_min_betting_money || betting_money > g_max_betting_money) 	
	{
		alert("???????????? "+MoneyFormat(g_min_betting_money)+"~"+MoneyFormat(g_max_betting_money)+"??? ???????????????.");
		return;
	}

	if (prize_money > g_max_prize_money) 
	{
		alert("?????????????????? "+MoneyFormat(g_max_prize_money)+" ??? ?????? ??? ????????????.");
		return;
	}

	frm_betting_slip.submit();
}

//-> ????????????
function liveMaxBetting() {
	document.frm_betting_slip.betting_money.value = MoneyFormat(g_max_betting_money);
	calculate_money();
}

//-> ????????? ????????? ?????????????????? ??????
function liveBettingMoneyPick(plusMoney) {
	document.frm_betting_slip.betting_money.value = MoneyFormat(plusMoney);
	calculate_money();
}