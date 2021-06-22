(function(window, $, undefined) {

    var dist = {};

    dist.result = {};

    dist.set_dist = function(game) {

        $.ajax({
            type: "get",
            url: '/dist',
            dataType: "json",
            cache: true,
            success: function (res) {
                dist.result = res;
            }
        });
    };
    window.game_dist = dist;

}(window, jQuery));