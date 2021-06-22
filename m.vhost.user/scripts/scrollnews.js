(function($){
$.fn.extend({
	Scroll:function(opt,callback){
			if(!opt) var opt={};
			var toint=function (str){
				if(str=='auto'||str.length<=0){
					str=0;
				}else{
					str=parseInt(str);
				}
				return str;
			}
			var _btnUp = $(opt.up);
			var _btnDown = $(opt.down);
			var timerID;
			var _this=this.eq(0).find("ul:first");
			var lineH=_this.find("li:first").width(), 
				line=opt.line?parseInt(opt.line,10):parseInt(this.width()/lineH,10), 
				speed=opt.speed?parseInt(opt.speed,10):500; 
				timer=opt.timer;

			if(line==0) line=1;
			var upHeight=0-line*lineH;
			

			_this.parent().css({overflow:'hidden'});
			var getWidth=function (){
				var _curli=_this.find("li:first");
				upHeight=0-_curli.height()-toint(_curli.css('margin-top'))-toint(_curli.css('margin-bottom'));
				return upHeight;
			}
			var scrollUp=function(){
				_btnUp.unbind("click",scrollUp);
				_this.animate({
						marginTop:getWidth()
				},speed,function(){
						for(i=1;i<=line;i++){
								_this.find("li:first").appendTo(_this);
						}
						_this.css({marginTop:0});
						_btnUp.bind("click",scrollUp);
				});
				return false;
			}
			var scrollDown=function(){
				_btnDown.unbind("click",scrollDown);
				for(i=1;i<=line;i++){
						_this.find("li:last").show().prependTo(_this);
				}
				_this.css({marginTop:getWidth()});
				_this.animate({
						marginTop:0
				},speed,function(){
						_btnDown.bind("click",scrollDown);
				});
				return false;
			}
			var autoPlay = function(){
					if(timer)timerID = window.setInterval(scrollUp,timer);
					return false;
			};
			var autoStop = function(){
					if(timer)window.clearInterval(timerID);
					return false;
			};
			//_this.parent().hover(autoStop,autoPlay).mouseout();
			_btnUp.css("cursor","pointer").click( scrollUp );
			_btnDown.css("cursor","pointer").click( scrollDown );
			if(timer)timerID = window.setInterval(scrollUp,timer);
	}
})
})(jQuery);