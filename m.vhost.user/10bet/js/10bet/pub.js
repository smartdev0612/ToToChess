// 시작

// 레프트 라이트 위치
function funcThisSize() {
	var windowWidth = $j( window ).width();
	var valueSize = (windowWidth - 2000) / 2;
	var gnbSize = (windowWidth - 1670) ;
	
	if (windowWidth > 2000){
		$j("#left_section").css({'left':valueSize});
		$j("#right_section").css({'right':valueSize});
	}
	else {
		$j("#left_section").css({'left':'0'});
		$j("#right_section").css({'right':'0'});
	}
	
	// gnb 좌우 버튼 클릭
	$j("#gnb_left").click(function() {
		$j("#gnb ul").css({'margin-left':gnbSize});
	});
	$j("#gnb_right").click(function() {
		$j("#gnb ul").css({'margin-left':0});
	});
	if (windowWidth > 1500){
		$j("#gnb ul").css({'margin-left':0});
	}
}

// 리사이즈
$j(function(){
	$j(window).resize( funcThisSize );
	funcThisSize();
});

// 스크롤 레프트 라이트 메뉴 고정
$j(window).scroll(function () {
	var scrollTop = $j(document).scrollTop();
	
	if (scrollTop > 20){
		$j("#left_section").addClass("on");
		$j("#right_section").addClass("on");
	}
	else {
		$j("#left_section").removeClass("on");
		$j("#right_section").removeClass("on");
	}
});

$j(document).ready(function(){
	//  컨텐츠 스크롤 영역
	$j(".left_box, .right_box").mCustomScrollbar({ 
		theme:"minimal"
	});
	
	// 모바일 레프트 메뉴 클릭
	$j("#mobile_menu_ico").click(function() {
		event.stopPropagation();
		$j("body").css({'overflow-y':'hidden'});
		$j(".mask").show();
		$j("#mobile_left_menu").css({'left':'0px'});
	});
	// 모바일 우측 유저 클릭
	$j("#user_menu_ico").click(function() {
		event.stopPropagation();
		$j("body").css({'overflow-y':'hidden'});
		$j(".mask").show();
		$j("#mobile_user_section").css({'right':'0px'});
	});
	// 모바일 베팅카트 클릭
	$j("#ico_betting_cart").click(function() {
		event.stopPropagation();
		$j("body").css({'overflow-y':'hidden'});
		$j(".mask").show();
		$j("#mobile_betting_cart").css({'right':'0px'});
	});	
	// 모바일 bottom 메뉴 클릭
	$j("#ico_bottom_menu").click(function() {
		event.stopPropagation();
		$j("body").css({'overflow-y':'hidden'});
		$j(".mask").show();
		$j("#mobile_bottom_menu").css({'right':'0px'});
	});
	
	// 메뉴 닫기
	$j(document).click(function(){
		$j("body").css({'overflow-y':'auto'});
		$j(".mask").hide();
		$j("#mobile_left_menu").css({'left':'-300px'});
		$j("#mobile_user_section").css({'right':'-280px'});
		$j("#mobile_betting_cart").css({'right':'-280px'});
		$j("#mobile_bottom_menu").css({'right':'-280px'});
	});
	
	// 모바일 메뉴 영역 클릭시
	$j("#mobile_left_menu, #mobile_user_section, #mobile_betting_cart, #mobile_bottom_menu").click(function() {
		event.stopPropagation();
	});
	
	// 스포츠 메뉴 여닫기
	$j(".sports_menu_list .menu01").click(function(){
		$j(".menu01").removeClass("on");
		$j(".menu02").removeClass("on");
		$j(".menu03").removeClass("on");
		$j(this).find(".open").toggle();
		$j(this).find(".close").toggle();
		$j(this).addClass("on");
		$j(this).parent().children(".menu_list02").toggle();
	});
	$j(".sports_menu_list .menu02").click(function(){
		$j(".menu01").removeClass("on");
		$j(".menu02").removeClass("on");
		$j(".menu03").removeClass("on");
		$j(this).find(".open").toggle();
		$j(this).find(".close").toggle();
		$j(this).addClass("on");
		$j(this).parent().children(".menu_list03").toggle();
	});
	$j(".sports_menu_list .menu03").click(function(){
		$j(".menu01").removeClass("on");
		$j(".menu02").removeClass("on");
		$j(".menu03").removeClass("on");
		$j(this).toggleClass("on");
	});
	
	// 스포츠 게임 리스트 열고 닫기
	$j(".sports_game .game_head").click(function(){
		$j(this).parent(".game_list").addClass("open");
		$j(this).parent().find(".button_close").click(function(){
			$j(this).parent().parent().parent().parent(".game_list").removeClass("open");
		});
	});
	
	// 경기결과 버튼 리스트 
	$j(".result_btn h3").click(function(){
		$j(this).toggleClass("on");
		$j(".result_btn ul").toggle();
	});
	
	// 라이브스포츠 푸시 버튼 
	$j(".livegame_head .pause").click(function(){
		$j(".livegame_head").find(".count_area").hide();
		$j(".livegame_head").find(".paused_area").show();
	});
	$j(".livegame_head .resume").click(function(){
		$j(".livegame_head").find(".count_area").show();
		$j(".livegame_head").find(".paused_area").hide();
	});
	
	// 라이브스포츠 리스트 디테일
	$j(".livegame_list .simple_box").click(function(){
		$j(this).hide();
		$j(this).parent().children(".detail_box").show();
	});
	$j(".detail_box .close_detail").click(function(){
		$j(this).parent(".detail_box").hide();
		$j(this).parent().parent().children(".simple_box").show();
	});
	
	// 오늘의 스포츠 열고 닫기
	$j(".today_sports .more_btn .more").click(function(){
		$j(this).hide();
		$j(".today_sports .more_btn .close").show();
		$j(".today_sports .more_list").show();
	});
	$j(".today_sports .more_btn .close").click(function(){
		$j(this).hide();
		$j(".today_sports .more_btn .more").show();
		$j(".today_sports .more_list").hide();
	});
	
	// 카지노_슬롯 메뉴 여닫기
/*	$j(".casino_slot_list .menu01").click(function(){
		$j(".menu01").removeClass("on");
		$j(".menu02").removeClass("on");
		$j(".menu03").removeClass("on");
		$j(this).find(".open").toggle();
		$j(this).find(".close").toggle();
		$j(this).addClass("on");
		$j(this).parent().children(".menu_list02").toggle();
	});
	$j(".casino_slot_list .menu02").click(function(){
		$j(".menu01").removeClass("on");
		$j(".menu02").removeClass("on");
		$j(".menu03").removeClass("on");
		$j(this).find(".open").toggle();
		$j(this).find(".close").toggle();
		$j(this).addClass("on");
		$j(this).parent().children(".menu_list03").toggle();
	});
	$j(".casino_slot_list .menu03").click(function(){
		$j(".menu01").removeClass("on");
		$j(".menu02").removeClass("on");
		$j(".menu03").removeClass("on");
		$j(this).toggleClass("on");
	});
*/	
	// 슬롯게임 게임사 보기
	$j(".slot_main .game_company").click(function() {
		$j(this).find("button").toggleClass("on");
		$j(this).find(".company_list").slideToggle(200);
	});
	
	// 머니 이동
	$j(".money_move .btn_area").click(function() {
		$j(this).find("button").toggleClass("on");
		$j(this).parent().find(".company_list").slideToggle(200);
	});
});
