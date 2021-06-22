/*  

   사용법
   바코드를 그릴 페이지에 아래의 스타일 시트를 선언해주셔야 합니다.
  <style type="text/css">
  .space { background:#FFFFFF;float:left;margin:0;padding:0;cursor:default; }
  .bar { background:#000000;float:left;margin:0;padding:0;cursor:default; }
  .bartext { clear:both;font-family:Fixedsys,Arial;font-size:12px;cursor:default; }
  </style>
  바코드를 그릴 라인에서 아래와 같이 써줍니다.

  <script type="text/javascript">barcode("1234567890", 40);</script>
  <script type="text/javascript">barcode("i-swear.com", 40);</script>
*/
document.write("<style type='text/css'>");
document.write(".space { background:#FFFFFF;float:left;margin:0;padding:0;cursor:default; }");
document.write(".bar { background:#000000;float:left;margin:0;padding:0;cursor:default; }");
document.write(".bartext { clear:both;font-family:Fixedsys,Arial;font-size:12px;cursor:default; }");
document.write("</style>");
  var s;
  var b;
  var b_;
  var s_;
  var bar_ar = new Array();
  bar_ar["0"] = "1010011011010";
  bar_ar["1"] = "1101001010110";
  bar_ar["2"] = "1011001010110";
  bar_ar["3"] = "1101100101010";
  bar_ar["4"] = "1010011010110";
  bar_ar["5"] = "1101001101010";
  bar_ar["6"] = "1011001101010";
  bar_ar["7"] = "1010010110110";
  bar_ar["8"] = "1101001011010";
  bar_ar["9"] = "1011001011010";
  bar_ar["A"] = "1101010010110";
  bar_ar["B"] = "1011010010110";
  bar_ar["C"] = "1101101001010";
  bar_ar["D"] = "1010110010110";
  bar_ar["E"] = "1101011001010";
  bar_ar["F"] = "1011011001010";
  bar_ar["G"] = "1010100110110";
  bar_ar["H"] = "1101010011010";
  bar_ar["I"] = "1011010011010";
  bar_ar["J"] = "1010110011010";
  bar_ar["K"] = "1101010100110";
  bar_ar["L"] = "1011010100110";
  bar_ar["M"] = "1101101010010";
  bar_ar["N"] = "1010110100110";
  bar_ar["O"] = "1101011010010";
  bar_ar["P"] = "1011011010010";
  bar_ar["Q"] = "1010101100110";
  bar_ar["R"] = "1101010110010";
  bar_ar["S"] = "1011010110010";
  bar_ar["T"] = "1010110110010";
  bar_ar["U"] = "1100101010110";
  bar_ar["V"] = "1001101010110";
  bar_ar["W"] = "1100110101010";
  bar_ar["X"] = "1001011010110";
  bar_ar["Y"] = "1100101101010";
  bar_ar["Z"] = "1001101101010";
  bar_ar["*"] = "1001011011010";
  bar_ar["-"] = "1001010110110";
  bar_ar["."] = "1100101011010";
  bar_ar[" "] = "1001101011010";
  bar_ar["$"] = "1001001001010";
  bar_ar["/"] = "1001001010010";
  bar_ar["+"] = "1001010010010";
  bar_ar["%"] = "1010010010010";


  function barcode(str,height, barwidth, doublebarwidth, spacewidth, doublespacewidth, bgcolor,fontcolor) {
	if (barwidth && !spacewidth) spacewidth = barwidth;
	if (doublebarwidth && !doublespacewidth) doublespacewidth = doublebarwidth;
	if (!barwidth) barwidth = 1;
	if (!doublebarwidth) doublebarwidth = 2;
	if (!spacewidth) spacewidth = 1;
	if (!doublespacewidth) doublespacewidth = 2;
	if (!height) height = 100;
	if (!bgcolor) bgcolor = "#000000";
	else bgcolor = "#"+bgcolor;
	if (!fontcolor) fontcolor = "000000";
	else fontcolor = fontcolor;
	// s = space , b = bar 
	var data = "";
	var text_width = 0;
	if (barwidth == 0) return;
	if (!str) return;
	str = "*"+str+"*";
	var strlen = str.length;
	var txtchar = null;
	

	s = "<div style='width:"+spacewidth+"px;height:"+height+"px;background:#FFFFFF;float:left;margin:0;padding:0;cursor:default;'></div>";
	s_ = "<div style='width:"+doublespacewidth+"px;height:"+height+"px;background:#FFFFFF;float:left;margin:0;padding:0;cursor:default;'></div>";
	b = "<div style='width:"+barwidth+"px;height:"+height+"px;background:#000000;float:left;margin:0;padding:0;cursor:default;'></div>";
	b_ = "<div style='width:"+doublebarwidth+"px;height:"+height+"px;background:#000000;float:left;margin:0;padding:0;cursor:default;'></div>";
	data = "<div style='position:absolute;'>";
	for (var i=0; i<strlen; i++) {
		txtchar = str.substring(i,i+1).toUpperCase();
		data += bar_fun(txtchar);
		// space 몇개인지 찾는다.
		tmp = bar_ar[txtchar].match(/0/g);
		text_width += tmp.length * spacewidth;
		// Bar 몇개인지 찾는다.
		tmp = bar_ar[txtchar].match(/1/g);
		text_width += tmp.length * barwidth;
		// doublebar 몇개인지 찾는다.
		tmp = bar_ar[txtchar].match(/2/g);
		text_width += tmp.length * doublebarwidth;
		// doublespace 몇개인지 찾는다.
		tmp = bar_ar[txtchar].match(/3/g);
		text_width += tmp.length * doublespacewidth;
	}

	text_width -= 5;
	data += "<div class='bartext' style='width:"+text_width+"px;text-align:justify;text-justify:distribute-all-lines;font-size:11px;color:#"+fontcolor+"'>"+str.toUpperCase()+"</div>";
	data += "</div>";
	document.writeln(data);
  }

  function bar_fun(str) {
	var data = "";
	var prev_tmp = "";
	bar_ar[str] = bar_ar[str].replace(/[0]{2}/g, "3");	// 3 넓은 화이트 스페이스
	bar_ar[str] = bar_ar[str].replace(/[1]{2}/g, "2");	// 2 넓은 바

	for (var i=0; i<bar_ar[str].length; i++) {
	tmp = bar_ar[str].substring(i,i+1);
		if (tmp == "0") data += s; 
		else if (tmp == "1") data += b;
		else if (tmp == "2") data += b_;
		else data += s_;
	}
	// for
	return data;
  }