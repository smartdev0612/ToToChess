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
		if($(this).val()==$template_position) {
			if($(this).is(":checked")) {
				$(this).attr("checked", false);
			}
			else {
				$(this).attr("checked", true);
			}
		}
		else {
			$(this).attr("checked", false);
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
	
	var tr_count = table.rows.length;
	for(var i=0; i<tr_count; ++i) {
		table.deleteRow(i);
	}
	
	initialize_betting_slip();
			
	$("input[name='template_position']:checkbox").each( function() {
		if($(this).is(":checked")) {
			var tr = table.insertRow(table.rows.length);
	
			tr.id 		= "tb_row_"+g_live_sn;
			var td0		= tr.insertCell(0);
			var td1		= tr.insertCell(1);
			var td2		= tr.insertCell(2);
			
			td0.style.width = '65%';
			td1.style.width = '15%';
			td1.style.textAlign = 'center';
			td2.style.width = '20%';
			td2.style.textAlign = 'right';
			
			var item = $(this).val();
			var splits = item.split("_");
			var template = splits[0];
			var position = splits[1];
			var position_alias='';
			var team_name='';
			
			switch(position)
			{
				case '1': position_alias="홈"; team_name=g_home_team; break;
				case 'X': position_alias="무"; break;
				case '2': position_alias="원정"; team_name=g_away_team; break;
				default : position_alias=position; team_name=g_home_team+" (vs) "+g_away_team; break;
			}
			
			var odd = $('#template_'+item).text();
			
			td0.innerHTML = team_name;
			td1.innerHTML = "<span class='pick'>"+position_alias+"</span>";
			td2.innerHTML = "<span class='rate'>"+parseFloat(odd).toFixed(2)+"<a href=javascript:clear_betting_slip();><img src='/img/game/betslip_btn_delete.gif' align='absmiddle'></a></span>";
			
			$('#sp_bet').text(parseFloat(odd).toFixed(2));
			
			var betting_money = document.frm_betting_slip.betting_money.value;
			betting_money = betting_money.replace(/,/gi,"");
			$('#sp_bet').text(parseFloat(odd).toFixed(2));
			
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
		alert("배팅할 경기를 선택하십시오.");
		return;
	}
	
	if(isNaN(odd))
	{
		alert("배팅할 경기를 선택하십시오.");
		return;
	}
	if(isNaN(betting_money))
	{
		alert("배팅하실 금액을 정확히 입력하여 주십시오");
		return;
	}
	
	if (betting_money<g_min_betting_money || betting_money>g_max_betting_money) 
	{
		alert("베팅액은 "+MoneyFormat(g_min_betting_money)+"~"+MoneyFormat(g_max_betting_money)+"원 사이입니다.");
		return;
	}
	
	if (prize_money>g_max_prize_money) 
	{
		alert("최대적중금은 "+MoneyFormat(g_max_prize_money)+" 를 넘을 수 없습니다.");
		return;
	}
	
	frm_betting_slip.submit();
}