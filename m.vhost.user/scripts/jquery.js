/* 슬라이드 메뉴 */

$(document).ready(function() {
	//로딩시 첫 단계
	$('#menu_off').hide();
	$('#menu_on').show();
	$('#wrap_menu').hide();
	$('#slip_off').hide();
	$('#slip_on').show();
	$('#wrap_betslip').hide();
	//상태 확인용
	var menu_flag = false;
	var slip_flag = false;
	$('#menu_on').bind('click', function(e) {
		$('#wrap_menu').show();
		$('#menu_off').show();
		$('#menu_on').hide();
		if (slip_flag==true){
			$('#wrap_betslip').hide();
		}
		e.preventDefault;
		menu_flag = true;
	});
	$('#menu_off').bind('click', function(e) {
		$('#wrap_menu').hide();
		$('#menu_off').hide();
		$('#menu_on').show();
		if (slip_flag==true){
			$('#wrap_betslip').show();
		}
		e.preventDefault;
		menu_flag = false;
	});
	$('#slip_on').bind('click', function(e) {
		$('#wrap_betslip').show();
		$('#slip_off').show();
		$('#slip_on').hide();
		if (menu_flag==true){
			$('#wrap_menu').hide();
		}
		e.preventDefault;
		slip_flag = true;
	});
	$('#slip_off').bind('click', function(e) {
		$('#wrap_betslip').hide();
		$('#slip_off').hide();
		$('#slip_on').show();
		if (menu_flag==true){
			$('#wrap_menu').show();
		}
		e.preventDefault;
		slip_flag = false;
	});

	$('#mmenu a').bind('click', function() {
		$(this).addClass('on');
	});
});