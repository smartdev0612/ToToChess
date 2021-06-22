var chkInterval =null;
var leftInterval =null;
var miniTimeout =null;
var countTimeout =null;
var pagingInterval =null;
var liveCntIntervalId =null;


// page loading
function chkLoading(game_t, cpage) {
	getCookies = document.cookie;
	$.ajax({
		url: "/_ajax/topPage.php",
		type: "POST",
		dataType: "html",
		success: function(datas){ $('#topPage').html(datas); }
	});
	
	if (game_t!='1' && game_t!='2') {
		$.ajax({
			url: "/_ajax/leftPage.php",
			type: "POST",
			data: { "game_t":game_t},
			dataType: "html",
			success: function(datas){ $('#leftPage').html(datas); }
		});
	}
	
	$.ajax({
		url: "/_ajax/rightPage.php",
		type: "POST",
		data: { "game_t":game_t},
		dataType: "html",
		success: function(datas){ $('#rightPage').html(datas); }
	});

	//alert(game_t);
	
	//if (cpage!='betcart') {
		$.ajax({
			url: "/_ajax/footPage.php",
			type: "POST",
			data: {"game_t":game_t},
			dataType: "html",
			success: function(datas){ $('#footPage').html(datas); }
		});
	//}


	if((/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || pc_chk=='M')) {
		$.ajax({
			url: "/_ajax/cartPage.php",
			type: "POST",
			data: { "game_t":game_t},
			dataType: "html",
			success: function(datas){ $('#cartPage').html(datas); }
		});
	}
}

// success: function(datas){ $('#cartPage').hide().html(datas).fadeIn(1000); }

// center page loading
function chkLink(pageis) {

	if(chkInterval == null){}else{clearInterval(chkInterval);chkInterval=null;}
	if(leftInterval == null){}else{clearInterval(leftInterval);leftInterval=null;}
	if(miniTimeout == null){}else{clearTimeout(miniTimeout);miniTimeout=null;}
	if(countTimeout == null){}else{clearTimeout(countTimeout);countTimeout=null;}
	/*
	var gamecode = ''; gamecode = getCookie("gamecodeck");
	if(gamecode == "livesports" || gamecode == "minigame" || gamecode == "livegame"){
		if(livegamesetinterval == null){}else{clearInterval(livegamesetinterval);livegamesetinterval=null;}
	}
	*/
	//$('#loader').modal({show: true,backdrop:'static'});
	$('#loader').fadeIn('slow');
	var targetUrl = pageis.replace('#','');
	var pages = targetUrl.split('/');
	
	var pg = 'pc';
	var cpage = '';

	var stp1 = pages[0];
	var stp2 = pages[1].split('?');
	if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || pc_chk=='M') {
		pg = 'mo';
		cpage=stp2[0];
	} 
	var chkPage = '/'+pg+'/'+pages[0]+'/';	
	//alert(cpage);
	

	// left Cookie

	

	//var carts='';
	if (stp1!='sports')			{ game_t='';  }
	else if (stp2[0]=='sports')	{ game_t='1'; } 
	else if (stp2[0]=='sports2')	{ game_t='1'; } 
	else if (stp2[0]=='cross')		{ game_t='2'; } 
	else if (stp2[0]=='realtime')	{ game_t='4'; } 
	else if (stp2[0]=='sadari')	{ game_t='5'; } 
	else if (stp2[0]=='daridari')	{ game_t='6'; } 
	else if (stp2[0]=='snail')		{ game_t='7'; } 
	else if (stp2[0]=='powerball')	{ game_t='8'; } 
	else if (stp2[0]=='pasadari')	{ game_t='9'; } 
	else if (stp2[0]=='kysadari')	{ game_t='10'; } 
	else if (stp2[0]=='vittual_soccer')	{ game_t='11'; } 
	else if (stp2[0]=='vittual_dog')	{ game_t='12'; } 
	else if (stp2[0]=='mgm_baccarat')	{ game_t='17'; } 
	else if (stp2[0]=='lotus')			{ game_t='18'; } 
	else if (stp2[0]=='lotus_baccarat')	{ game_t='19'; } 
	else if (stp2[0]=='lotus_baccarat2'){ game_t='20'; } 
	else if (stp2[0]=='lotus_roulette')	{ game_t='21'; } 
	else if (stp2[0]=='lotus_dice')		{ game_t='22'; } 
	//alert(game_t);

	setCookie("gameCookie",game_t,24);

	var targetUrl = targetUrl.replace(pages[0]+'/',chkPage);
	
	
	var targetUrl_check = targetUrl.split('?');
	if(targetUrl_check[1]){
		var targetUrl = targetUrl.replace('?','.php?');
	}else{
		var targetUrl = targetUrl+'.php';
	}	
	
	// 모바일 베팅카트일때
	if (targetUrl_check[0]=='/mo/member/betcart') {
		setCookie("rePage",getCookie("pageChk"),24);
	} 	
	setCookie("pageChk",pageis,24);
	
	if(chkInterval == null){}else{clearInterval(chkInterval);chkInterval=null;}
	if(leftInterval == null){}else{clearInterval(leftInterval);leftInterval=null;}
	if(miniTimeout == null){}else{clearTimeout(miniTimeout);miniTimeout=null;}
	if(countTimeout == null){}else{clearTimeout(countTimeout);countTimeout=null;}
	

	// page move
    $.ajax({
        type: 'POST',
        url: targetUrl,	//with the page number as a parameter
		async: false,
		cache: false,
        dataType: 'html',	//expect html to be returned
        success: function(datas) {
			/*
			if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
				$('#modal-sidemenu').modal('hide');
				$('#modal-betpan').modal('hide');
			}
			*/
			//console.log(targetUrl+' / '+targetUrl_check[0]);
			// center page

		   setTimeout(function(){
				 $('#centerPage').html(datas);
				 chkLoading(game_t, cpage);

			}, 200);

		  
			// cart del chk
			/*
            $('html, body').animate({
                scrollTop: $("body").offset().top
            }, 20);
			*/
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#centerPage').html('<center>no Page</center>');
        }
    });
	
}

// page move
function chkMove(pageis) {

	if(chkInterval == null){}else{clearInterval(chkInterval);chkInterval=null;}
	if(leftInterval == null){}else{clearInterval(leftInterval);leftInterval=null;}
	if(miniTimeout == null){}else{clearTimeout(miniTimeout);miniTimeout=null;}
	if(countTimeout == null){}else{clearTimeout(countTimeout);countTimeout=null;}
	
	var targetUrl = pageis.replace('#','');
	var pages = targetUrl.split('/');
	
	var pg = 'pc';
	var cpage = '';

	var stp1 = pages[0];
	var stp2 = pages[1].split('?');
	if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || pc_chk=='M') {
		pg = 'mo';
		cpage=stp2[0];
	} 
	var chkPage = '/'+pg+'/'+pages[0]+'/';	
	

	var targetUrl = targetUrl.replace(pages[0]+'/',chkPage);
	//setCookie("pagecodeck",pageis,24);
	
	var targetUrl_check = targetUrl.split('?');
	if(targetUrl_check[1]){
		var targetUrl = targetUrl.replace('?','.php?');
	}else{
		var targetUrl = targetUrl+'.php';
	}

	//alert(targetUrl)

	location.href=targetUrl;
	
}

// login
function loginChk(v) {
	if (v=="1") {
		var mb_id=Aes.Ctr.encrypt($("#user_id").val(),enc,256);
		var mb_password=Aes.Ctr.encrypt($("#user_pwd").val(),enc,256);
	} else {
		var mb_id=Aes.Ctr.encrypt($("#user_id2").val(),enc,256);
		var mb_password=Aes.Ctr.encrypt($("#user_pwd2").val(),enc,256);

	}
	/*
	alert(enc)
	alert(mb_id)
	alert(mb_password)
	*/	
	if(mb_id && mb_password){
		$.ajax({
			url: "/login/login.act.php",
			data: {
				"mb_id":mb_id,
				"mb_password":mb_password,
				"enc":enc,
				"pc_chk":pc_chk
			},
			type: "POST",
			dataType: "text",
			success: function(datas){
				if (datas){					
					var value = datas.split('|');
					var chkOk = encodeURI(value[0]);
					var chkMemo = value[1];
					if(chkOk=='ok'){
						getMemos(chkMemo);
						location.href="/";
					}else{
						getMemos(chkMemo);
					}
				}
			}
		});
	}else{
		getMemos('정상적인 경로가 아닙니다.');
	}
}

// logout
function logoutChk() {
	$.ajax({
		url: "/login/logout.php",
		type: "POST",
		success: function(datas){
			$('html, body').animate({
                scrollTop: $("body").offset().top
            }, 20);
			location.href="/";
		}
	});
}

// code check
function codeChk() {

	var code=Aes.Ctr.encrypt($("#code").val(),enc,256);

	$.ajax({
		url: "/_ajax/chk_code.act.php",
		data: {
			"mode":"code",
			"code":code,
			"enc":enc
		},
		type: "POST",
		success: function(datas){

			$('html, body').animate({
				scrollTop: $("body").offset().top
			}, 20);

			var value = datas.split('|');
			var chkOk = encodeURI(value[0]);
			var chkMemo = value[1];
			if(chkOk=='ok'){				
				chkLink('#member/join02');
			}else{
				getMemos(chkMemo);
			}

			
			//location.href="./index.test.php";
		} 
	});
}

// select box value
function getSelectedValue(tg) {
	var ret = $($(tg).find("option:selected")).val();
	if (ret == null) {
		ret = "";
	}
	return ret;
}

// QNA
function qnaChk(v) {
	var wr_subject=$("#wr_subject").val();
	var wr_content=$("#wr_content").val();
	var order=$("#order").val();
	$.ajax({
		url: "/_ajax/chk_qna.act.php",
		data: {
			"wr_subject":wr_subject
			,"wr_content":wr_content
			,"order":order
		},
		type: "POST",
		dataType: "text",
		success: function(datas){
			if (datas){					
				var value = datas.split('|');
				var chkOk = encodeURI(value[0]);
				var chkMemo = value[1];
				if(chkOk=='ok'){
					//getMemos('로그인 되었습니다.');
					chkLink('#bbs/qna');
				} else if (chkOk=='login'){
					getMemos(chkMemo);
					chkLink('#bbs/qna');
				} else {
					getMemos(chkMemo);
				}
			}
		}
	});
}

// Board
function boardChk(v) {
	var wr_subject=$("#wr_subject").val();
	var wr_content=$("#wr_content").val();
	var order=$("#order").val();
	$.ajax({
		url: "/_ajax/chk_board.act.php",
		data: {
			"wr_subject":wr_subject
			,"wr_content":wr_content
			,"order":order
		},
		type: "POST",
		dataType: "text",
		success: function(datas){
			if (datas){					
				var value = datas.split('|');
				var chkOk = encodeURI(value[0]);
				var chkMemo = value[1];
				if(chkOk=='ok'){
					chkLink('#bbs/board');
				} else if (chkOk=='login'){
					getMemos(chkMemo);
					chkLink('#bbs/board');
				} else {
					getMemos(chkMemo);
				}
			}
		}
	});
}

// Board comment
function chkComment(id,chks) {
	var chkId1 = chks+'_'+id; 
	var chkId2 = 'UL_'+chks+'_'+id; 
	var wr_content=$("#"+chkId1).val();
	$.ajax({
		url: "/_ajax/chk_board.act.php",
		data: {
			"w":"c"
			,"wr_content":wr_content
			,"wr_id":id
		},
		type: "POST",
		dataType: "html",
		success: function(datas){
			if (datas){					
				var value = datas.split('|');
				var chkOk = encodeURI(value[0]);
				var chkMemo = value[1];
				if(chkOk=='ok'){
					$("#"+chkId1).val('');
					$('#'+chkId2).append(chkMemo);
				} else if (chkOk=='login'){
					getMemos(chkMemo);
					chkLink('#bbs/board');
				} else {
					getMemos(chkMemo);
				}
			}
		}
	});
}

function chkComDel(id) {
	$.ajax({
		url: "/_ajax/chk_board.act.php",
		data: {
			"w":"cx"
			,"comment_id":id
		},
		type: "POST",
		dataType: "html",
		success: function(datas){
			if (datas){					
				var value = datas.split('|');
				var chkOk = encodeURI(value[0]);
				var chkMemo = value[1];
				if(chkOk=='ok'){
					
					$('.cDel'+id).hide();
				} else if (chkOk=='login'){
					getMemos(chkMemo);
					chkLink('#bbs/board');
				} else {
					getMemos(chkMemo);
				}
			}
		}
	});
}

// exchange point
var pUrl ='/_ajax/chk_point.act.php';
function bt_exchange_point(v) {

	$.ajax({
		url: pUrl,
		data: {
			"mode":"chk",
			"page":v
		},
		type: "POST",
		dataType: "text",
		success: function(datas){
			if (datas){					
				var value = datas.split('|');
				var chkOk = encodeURI(value[0]);
				var chkMemo = value[1];
				if(chkOk=='ok'){
					getMemos(chkMemo);
					chkLink('#money/point');
				} else if (chkOk=='login'){
					getMemos(chkMemo);
					chkLink('#money/point');
				} else {
					getMemos(chkMemo);
				}
			}
		}
	});
}



// ---------------------
// no member qna STR
// ---------------------
function popOpen() {
	$("#popup_wrap").css("display", "block");
}

function popClose() {
	$("#popup_wrap").css("display", "none");
}

function qna_submit() {

var qna_name = $('#qna_name').val();
var qna_tel = $('#qna_tel').val();
var qna_contents = $('#qna_contents').val();


 var chkMemo = "";
 var names = "";
 var tels = "";
 var contents = "";
	$.ajax({
		url: "/_ajax/chk_filter.php",
		type: "POST",
		data: {
			"qna_name": qna_name
			,"qna_tel": qna_tel
			,"qna_contents": qna_contents
		},
		dataType: "json",
		async: false,
		cache: false,
		success: function(res, textStatus) {				
			names = res.names;
			tels = res.tels;
			contents = res.contents;
		}
	});

	
	if (!qna_name) {
		getMemos(chkMemo);
		return false;
	}
	if (!qna_tel) {
		getMemos(chkMemo);
		return false;
	}
	if (!qna_contents) {
		getMemos(chkMemo);
		return false;
	}


	if (names) {
	   chkMemo = "이름에 금지단어('"+names+"')가 포함되어있습니다.";
		getMemos(chkMemo);
		return false;
	}

	 if (tels) {
	   chkMemo = "연락처에 금지단어('"+tels+"')가 포함되어있습니다.";
		getMemos(chkMemo);
		return false;
	}

	if (contents) {
	   chkMemo = "내용에 금지단어('"+contents+"')가 포함되어있습니다.";
		getMemos(chkMemo);
		return false;
	}

	$.ajax({
		url: "/_ajax/chk_nomember.act.php",
		type: "POST",
		data: {
			"mode": "add"
			,"name": qna_name
			,"tel": qna_tel
			,"contents": qna_contents
		},
		dataType: "json",
		async: false,
		cache: false,
		success: function(res, textStatus) {	
			if (res.result == 'Y') {
				$('#qna_name').val('');
				$('#qna_tel').val('');
				$('#qna_contents').val('');
				$("#popup_wrap").css("display", "none");
				getMemos(res.resultMsg);
			} else {
				getMemos(res.resultMsg);
				return false;
			}
		} 
	});
	
}
// ---------------------
// no member qna END
// ---------------------

// ---------------------
// bet STR
// ---------------------

// bet load
function ajaxLoadBet(src, gameT, gubun) {
	$.ajax({
		url: "/_ajax/"+src,
		type: "POST",
		dataType: "html",
		cache : false,
		data: {
			"mode":"mini"
			,"game_t":gameT
			,"gubun":gubun
		},
		success: function(datas){ 
			$('#mini_game').html(datas);
		}
	});
}

// 전체삭제
function allCancel() {
	$(".on").removeClass("on");
	$("#betList").html('');
	$('#betMoney').val(addCommas(minBetMoney));
	$('#totalBaedang').html('0');
	$('#baedangMoney').html('0');
	$('#sCnt').html('0');

	$.ajax({
		url: "/_ajax/inc_sports_slip.php",
		type: "POST",
		dataType: "json",
		data: {
			"mode":"allDel"
		},
		success: function(res){ 
			if (res.error){
				alert(res.error)
				return false;
			}			
		}
	});
}


function cartNone() {
	$(".on").removeClass("on");
	$("#betList").html('');
	$('#betMoney').val(addCommas(minBetMoney));
	$('#totalBaedang').html('0');
	$('#baedangMoney').html('0');
	$('#sCnt').html('0');
}
// ---------------------
// bet END
// ---------------------

// layer popup
function chkPOPS(id,gubun) {
	var ck_name='hd_pops_'+id;
	var exp_time=12;
	if (gubun=='1')	{
        $("#"+ck_name).css("display", "none");
        setCookie(ck_name, 1, exp_time, '');
	} else {
		$("#"+ck_name).css("display", "none");
	}
}


// 타이샨 Casino
function chkCasino(v){
	$.ajax({
		type: 'POST',
		url: "/_ajax/chk_casino.php",
		dataType:"json",
		async : false,
		success: function(res) {
			if (res.error) {
				getMemos(res.error);
				return;
			}	
			if (v=='M') {
				window.open(res.src, "_blank");  
			} else {
				$("#casino_mask").show();
				$("#casino_view").show();
				$(".casino_layer .close").css("top","40px");
				$("#casinoUrl").attr("src", res.src);
			}
		},
		error: function(e) {
			alert(e.responseText);
		}
	});
}

// 마이크로밍 Casino
function chkMG(v){
	$.ajax({
		type: 'POST',
		url: "/v1/token.php",
		dataType:"json",
		async : false,
		success: function(res) {
			if (res.error) {
				getMemos(res.error);
				return;
			}	
			if (v=='M') {
				window.open(res.src, "_blank");  
			} else {
				$("#casino_mask").show();
				$("#casino_view").show();
				$(".casino_layer .close").css("top","40px");
				$("#casinoUrl").attr("src", res.src);
			}
		},
		error: function(e) {
			alert(e.responseText);
		}
	});
}

function chkCasinoClose(){
	$("#casino_mask").hide();
	$("#casino_view").hide();
}

function getSportsLink(str) {
	var urls='';
	if  (getCookie("gameCookie")=='2') urls='#sports/cross?'+str;
	else  urls='#sports/sports?'+str;
	chkLink(urls);
}

// search
function chkSearch() {
	var kywd = $.trim($('#kyd').val());
	var rekyd = kywd.replace(/[^(ㄱ-힣a-zA-Z)]/gi, '');
	$('#kyd').val(rekyd);

	if (!rekyd) {
		getMemos('검색어를 입력해주세요');
	} else {
		chkLink('#sports/sports?kywd='+rekyd);
	}
}

//  Cgame
function chkCgame(v){
	$.ajax({
		type: 'POST',
		url: "/_ajax/chk_cgame.php",
		dataType:"json",
		data:{"gm":v},
		async : false,
		success: function(res) {
			if (res.error) {
				getMemos(res.error);
				return;
			}	
			window.open(res.src, "blank");
		},
		error: function(e) {
			alert(e.responseText);
		}
	});
}

//  Cgame
function chkCgameL(v){
	$.ajax({
		type: 'POST',
		url: "/_ajax/chk_cgame.php",
		dataType:"json",
		data:{"gm":v},
		async : false,
		success: function(res) {
			if (res.error) {
				getMemos(res.error);
				return;
			}
			$("#casino_mask").show();
				$("#casino_view").show();
				$(".casino_layer .close").css("top","40px");
				$("#casinoUrl").attr("src", res.src);
			//window.open(res.src, "blank");
		},
		error: function(e) {
			alert(e.responseText);
		}
	});
}

//  Cgame
function openCgameL(v, mode){
	$.ajax({
		type: 'POST',
		url: "/_ajax/chk_getcasino.php",
		dataType:"json",
		data:{"gm":v},
		async : false,
		success: function(res) {
			if (res.error) {
				getMemos(res.error);
				return;
			}
			/*
			if (mode=='1') {
				$("#casino_mask").show();
				$("#casino_view").show();
				$(".casino_layer .close").css("top","40px");
				$("#casinoUrl").attr("src", res.src);
			} else {
				window.open(res.src, "blank");
			}
			*/

			window.open(res.src, "blank");
		},
		error: function(e) {
			alert(e.responseText);
		}
	});
}