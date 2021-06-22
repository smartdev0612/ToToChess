/* 카트 스크롤 박스를 위한 스크립트 */
	jQuery(function(jq$) {
		jq$("#upClick").mousedown(function() {
			startScrolling(jq$("#scroll_box"), "-=150px", true);
		}).mouseup(function() {
			jq$('#scroll_box').stop()
		});
		jq$("#downClick").mousedown(function() {
			startScrolling(jq$("#scroll_box"), "+=150px", true);
		}).mouseup(function() {
			jq$('#scroll_box').stop();
		});
	});

	function startScrolling(obj, param, scrolling) { /* alert ('startscrolling '+param); */
		obj.animate({
			scrollTop: param
		}, "slow", function() {
				startScrolling(obj, param);
		});
	}
	function changeSize() {
		var width = parseInt(jq$("#Width").val());
		var height = parseInt(jq$("#Height").val());

		if(!width || isNaN(width)) {
		  width = 300;
		}
		if(!height || isNaN(height)) {
		  height = 305;
		}
		jq$("#scroll_box").width(width).height(height);

		// update perfect scrollbar
		Ps.update(document.getElementById('scroll_box'));
		}
		jq$(function() {
		Ps.initialize(document.getElementById('scroll_box'));
	});