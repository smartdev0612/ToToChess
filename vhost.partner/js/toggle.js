/*------------------------------------------------
 *   js伸缩
 * -----------------------------------------------
 */
var $ ={
	style:function(node){
		return node.currentStyle || document.defaultView.getComputedStyle(node,null) || node.style;
	},
	height:function(node){
		return parseInt($.style(node).height) || parseInt(node.clientHeight);
	},
	id:function(node){
		return document.getElementById(node);
	}
}
function _toggle(node,speed){
	this.node = node;
	switch(speed){
		case "fast":
			this.speed = 10;
			break;
		case "normal":
			this.speed = 5;
			break;
		case "slow":
			this.speed = 2;
			break;
		default:
			this.speed =5;
	}
	this.run = 1;
	this.max_height = $.height(this.node);
	this.node.style.height = this.max_height;
	this.display = $.style(this.node).display;
	this.node.style.overflow = "hidden";
	if(this.max_height <=0 || this.display == "none"){
		this.flag = 1;
	}else{
		this.flag = -1;
	}
}
_toggle.prototype.up_down = function(){
	if(this.node.style.display == "none"){
		this.node.style.display = "block";
		this.node.style.height ="0px";
	}
	this.box_height = parseInt($.style(this.node).height);
	this.box_height -= this.speed * this.flag;
	if(this.box_height > this.max_height){
		window.clearInterval(this.t);
		this.box_height = this.max_height;
		this.run =1;
	}
	if(this.box_height <0){
		window.clearInterval(this.t);
		this.box_height = 0;
		this.node.style.display ="none";
		this.run =1;
	}
	this.node.style.height = this.box_height + "px";
}

_toggle.prototype.toggle = function(){
	var temp = this;
	if(this.run == 1){
		this.flag *= -1;
		this.run =0;
		this.t = window.setInterval(function(){temp.up_down();},10);
	}
}