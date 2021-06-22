
$j(document).ready(function(){
  var $doc           = $j(document);
  var $win           = $j(window);
  var $body          = $j('body');
  var position       = 0;
  var topMargin		 = 0;	// 배팅카트 꼭대기 마진
  var top            = $doc.scrollTop();
  var minTop		 = 117;	// 스크롤 내려서 배팅카트 꼭대기가 사라지는 위치
  var $layer         = $j('#floater');

  //스코롤하면
  $win.scroll(function(){
	if( $j('#cart_fix').is(':checked')) return;

    //스크롤 상태에서 상단과의 거리
    top = $doc.scrollTop();
    if (top > minTop)
      yPosition = top+topMargin-minTop;
    else
      yPosition = topMargin;

	$j('#test').html('scrollTop='+top+',minTop='+minTop+',topMargin='+topMargin+',yPosition='+yPosition);
    //따라다니기 적용
   		$layer.animate({"top":yPosition }, {duration:1000, queue:false});

  });
});

