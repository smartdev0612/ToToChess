	$.fn.datepicker_kor = function() {
		this.datepicker({
			dateFormat: "yy-mm-dd",
			dayNamesMin: ["일", "월", "화", "수", "목", "금", "토"],
			monthNames: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
			monthNamesShort: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"]
		});
		return this;
	};
	
	$.fn.datepicker_kor_onselect = function() {
		this.datepicker({
			dateFormat: "yy-mm-dd",
			dayNamesMin: ["일", "월", "화", "수", "목", "금", "토"],
			monthNames: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
			monthNamesShort: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
			onSelect: updateLinked
		});
		return this;
	};