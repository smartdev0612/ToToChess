
$j(document).ready(function(){
  var $doc           = $j(document);
  var $win           = $j(window);
  var $body          = $j('body');
  var position       = 0;
  var topMargin		 = 0;	// ����īƮ ����� ����
  var top            = $doc.scrollTop();
  var minTop		 = 117;	// ��ũ�� ������ ����īƮ ����Ⱑ ������� ��ġ
  var $layer         = $j('#floater');

  //���ڷ��ϸ�
  $win.scroll(function(){
	if( $j('#cart_fix').is(':checked')) return;

    //��ũ�� ���¿��� ��ܰ��� �Ÿ�
    top = $doc.scrollTop();
    if (top > minTop)
      yPosition = top+topMargin-minTop;
    else
      yPosition = topMargin;

	$j('#test').html('scrollTop='+top+',minTop='+minTop+',topMargin='+topMargin+',yPosition='+yPosition);
    //����ٴϱ� ����
   		$layer.animate({"top":yPosition }, {duration:1000, queue:false});

  });
});

