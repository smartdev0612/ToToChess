getSlotGameList(6, "BBTECH");

function getSlotGameList(nCode = 0, companyName = ""){
    $j(".menu02").removeClass("on");
    $j(".slot_submenu_" + nCode).addClass("on");
    $j("#titleBtn").text(companyName);
	$j.ajax({
		url: '/getSlotGameList',
		type: 'GET',
       	data: {'nCode' : nCode},
		dataType: 'json',
		success: function(data) {
            console.log(data);
            $j(".game_list").empty();
            if(data.length > 0) {
                $j.each(data, function(key, item) {
                    var li = "";
                    li += `<li><div class="box01">
                                    <div class="img_area"><img src="${item.img}" alt="${item.nameKO}" /></div>
                                    <h3>${item.nameKO}<br/>${companyName}</h3>
                                    <div class="play" onClick=""><img src="/10bet/images/10bet/ico_play_01.png" alt="" /></div>
                                </div>
                            </li>`;
                    $j(".game_list").append(li);
                });
            }
		}
	});
}