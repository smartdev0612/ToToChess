$(function(){
    $("._tracking_buttons").find("a").click(function() {
        ga('send', 'event', 'livecast', 'click', $(this).attr("title"));
        return true;
    });
    $("._tracking_room_buttons").find("a").click(function() {
        ga('send', 'event', 'livecast', 'click', '방채팅 ' + $(this).attr("value") + '위');
        return true;
    });
});
