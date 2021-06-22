const $chat_area = $("#chat_area");

getNewChatList = function() {
   $.get('/data/json/games/nchat_room_list.json', function(res) {
       let html = new EJS({element: 'chat-room-list'}).render({
           config: room_list_config,
           data: res
       });
       $chat_area.html(html);

       $("._tracking_room_buttons").find("a").click(function() {
            ga('send', 'event', 'livecast', 'click', '방채팅 ' + $(this).attr("value") + '위');
            return true;
        });
   });
};