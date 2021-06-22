// cookie set
function setCookie( name, value, expirehours ) { 
	var todayDate = new Date(); 
	todayDate.setHours( todayDate.getHours() + expirehours ); 
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";" 
}

// cookie get
function getCookie(c_name){
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++) {
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		if (x==c_name){
			return unescape(y);
		}
	}
}

function addCommas(nStr) {
	if (nStr == null) {
		return 0;
	}

	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	var ret = x1 + x2;
	return ret;
}

function getNumberOnly(val) {
	val = new String(val);
	var regex = /[^0-9\.-]/g;
	val = val.replace(regex, '');
	// val=parseFloat(val);
	return val;
}

function numeric_func() {
	this.value = addCommas(getNumberOnly(this.value));
}

$(function() {
	// user-layer
	$('.numeric-only').bind("change paste keyup", numeric_func);
});

function twoBytesNum(n) {
	return n > 9 ? "" + n : "0" + n;
}

String.prototype.trim = function() {
	return this.replace(/(^\s*)|(\s*$)/gi, "");
}

function getTg(selector, idx) {
	return $(selector + ":eq(" + idx + ")");
}

function getTgVal(selector, idx) {
	return $(selector + ":eq(" + idx + ")").val();
}

function log(msg) {
	if (console == undefined || console == null) {
		return;
	}

	console.log(msg);
}

function viewport() {
	var e = window, a = 'inner';
	if (!('innerWidth' in window)) {
		a = 'client';
		e = document.documentElement || document.body;
	}
	return {
		width : e[a + 'Width'],
		height : e[a + 'Height']
	};
}

function getMaxScrollTop() {
	var documentHeight = $(document).outerHeight(true);
	var viewPortData = viewport();

	return documentHeight - viewPortData.height;
}

function toFloat(v){
	v = parseFloat(v);
	if (isNaN(v)) {
		return 0;
	}
	return v;
}

function toInt(v) {
	v = parseInt(v);
	if (isNaN(v)) {
		return 0;
	}
	return v;
}

function getDateStrByTime(t) {
	if (t == null || t == 0 || t == "") {
		return "-";
	}
	var dt = new Date();
	dt.setTime(t * 1000);
	return dt.format("mm/dd HH:MM");
}

function getDateStrByDay(t) {
	if (t == null || t == 0 || t == "") {
		return "-";
	}
	var dt = new Date();
	dt.setTime(t * 1000);
	return dt.format("mm/dd");
}

function getDateOnlyStrByTime(t) {
	if (t == null || t == 0 || t == "") {
		return "-";
	}
	var dt = new Date();
	dt.setTime(t * 1000);
	return dt.format("mm/dd");
}

function checkResult(data) {
	if (data != null && data.hasOwnProperty("result") && data.result == "000") {
		return true;
	}

	return false;
}

function alertResultMsg(data) {
	if (data != null && data.hasOwnProperty("result") && data.result == "9000") {
		location.href = data.redirect;
		alert(data.resultMsg);
		return;
	}
	if (data != null && data.hasOwnProperty("resultMsg")) {
		alert(data.resultMsg);
		return data.resultMsg;
	}

	if (data != null && data.hasOwnProperty("chkMsg")) {
		//console.log(data.chkMsg);
		$('#chkMsg').html(data.chkMsg);
		return;
	}

	alert("처리 도중 문제가 발생했습니다. 관리자에게 문의해주세요");
	return null;
}

function getItemInArray(fn, key, ls) {
	for (var i = 0; i < ls.length; i++) {
		if (ls[i][fn] == key) {
			return ls[i];
		}
	}
	return null;
}

function getNowTime() {
	var now = new Date();
	return Math.floor(now.getTime() / 1000);
}

function getTimeSet() {
	var now = new Date();
	var today = new Date(now);
	today.setHours(0);
	today.setMinutes(0);
	today.setSeconds(0);

	var prevday = new Date(today);
	prevday.setDate(today.getDate() - 1);

	var nextday = new Date(today);
	nextday.setDate(today.getDate() + 1);

	var nextday2 = new Date(today);
	nextday2.setDate(today.getDate() + 2);

	var prevWeek = new Date(today);
	prevWeek.setDate(today.getDate() - 6);

	var ret = {};
	ret.today = today;
	ret.prevday = prevday;
	ret.nextday = nextday;
	ret.nextday2 = nextday2;
	ret.prevWeek = prevWeek;

	ret.today_time = Math.floor(today.getTime() / 1000);
	ret.prevday_time = Math.floor(prevday.getTime() / 1000);
	ret.nextday_time = Math.floor(nextday.getTime() / 1000);
	ret.nextday2_time = Math.floor(nextday2.getTime() / 1000);
	ret.prevWeek_time = Math.floor(prevWeek.getTime() / 1000);

	return ret;
}

/*
var handleSidebarMinify = function() {
    $('[data-click=sidebar-minify]').click(function(e) {
        e.preventDefault();
        var sidebarClass = 'page-sidebar-minified';
        var targetContainer = '#page-container';
        $('#sidebar [data-scrollbar="true"]').css('margin-top','0');
        $('#sidebar [data-scrollbar="true"]').removeAttr('data-init');
        $('#sidebar [data-scrollbar=true]').stop();
        if ($(targetContainer).hasClass(sidebarClass)) {
            $(targetContainer).removeClass(sidebarClass);
            if ($(targetContainer).hasClass('page-sidebar-fixed')) {
                if ($('#sidebar .slimScrollDiv').length !== 0) {
                    $('#sidebar [data-scrollbar="true"]').slimScroll({destroy: true});
                    $('#sidebar [data-scrollbar="true"]').removeAttr('style');
                }
                generateSlimScroll($('#sidebar [data-scrollbar="true"]'));
                $('#sidebar [data-scrollbar=true]').trigger('mouseover');
            } else if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                if ($('#sidebar .slimScrollDiv').length !== 0) {
                    $('#sidebar [data-scrollbar="true"]').slimScroll({destroy: true});
                    $('#sidebar [data-scrollbar="true"]').removeAttr('style');
                }
                generateSlimScroll($('#sidebar [data-scrollbar="true"]'));
            }
        } else {
            $(targetContainer).addClass(sidebarClass);
            
            if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                if ($(targetContainer).hasClass('page-sidebar-fixed')) {
                    $('#sidebar [data-scrollbar="true"]').slimScroll({destroy: true});
                    $('#sidebar [data-scrollbar="true"]').removeAttr('style');
                }
                $('#sidebar [data-scrollbar=true]').trigger('mouseover');
            } else {
                $('#sidebar [data-scrollbar="true"]').css('margin-top','0');
                $('#sidebar [data-scrollbar="true"]').css('overflow', 'visible');
            }
        }
        $(window).trigger('resize');
    });
};


 // SIDEBAR - fixed or default
    $(document).on('change', '.theme-panel [name=sidebar-fixed]', function() {
        if ($(this).val() == 1) {
            if ($('.theme-panel [name=header-fixed]').val() == 2) {
                alert('Default Header with Fixed Sidebar option is not supported. Proceed with Fixed Header with Fixed Sidebar.');
                $('.theme-panel [name=header-fixed] option[value="1"]').prop('selected', true);
                $('#header').addClass('navbar-fixed-top');
                $('#page-container').addClass('page-header-fixed');
            }
            $('#page-container').addClass('page-sidebar-fixed');
            if (!$('#page-container').hasClass('page-sidebar-minified')) {
                generateSlimScroll($('.sidebar [data-scrollbar="true"]'));
            }
        } else {
            $('#page-container').removeClass('page-sidebar-fixed');
            if ($('.sidebar .slimScrollDiv').length !== 0) {
                if ($(window).width() <= 979) {
                    $('.sidebar').each(function() {
                        if (!($('#page-container').hasClass('page-with-two-sidebar') && $(this).hasClass('sidebar-right'))) {
                            $(this).find('.slimScrollBar').remove();
                            $(this).find('.slimScrollRail').remove();
                            $(this).find('[data-scrollbar="true"]').removeAttr('style');
                            var targetElement = $(this).find('[data-scrollbar="true"]').parent();
                            var targetHtml = $(targetElement).html();
                            $(targetElement).replaceWith(targetHtml);
                        }
                    });
                } else if ($(window).width() > 979) {
                    $('.sidebar [data-scrollbar="true"]').slimScroll({destroy: true});
                    $('.sidebar [data-scrollbar="true"]').removeAttr('style');
                }
            }
            if ($('#page-container .sidebar-bg').length === 0) {
                $('#page-container').append('<div class="sidebar-bg"></div>');
            }
        }
    });
*/

function getMemos(v) {	
	$('#modal_count').html('');
	$('#modal_close').removeClass('_hidden');
	$('#modal_footer').removeClass('_hidden');
	$('#modal_memo').html(v);	
	$('#modal_alert').modal({show: true,backdrop:'static'});
}