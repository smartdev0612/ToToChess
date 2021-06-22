let isHiddenTab = false;
let HiddenTabTimer = 4;
const minigame_banner = new MinigameAdBanner();
const handleVisibilityChange = function () {
    if (!document['hidden']) {
        isHiddenTab = false;
    } else {
        isHiddenTab = true;
    }
};

function game_execute() {

    var diff = game_clock.update(),
        timer = game_clock.get_timer(live_game_type),
        gauge_size = 264;

    if (diff != 0) {

        var countdown_seconds = game_clock.get_countdown_seconds(live_game_type),
            gauge = game_clock.get_gauge(live_game_type, countdown_seconds),
            timer_gauge = gauge * gauge_size / 100 - gauge_size;

        $("#clock").html(game_clock.now_clock(timer));
        $("#countdown_clock").html(game_clock.convert_countdown_clock(countdown_seconds) + ' 후');
        $("#timer_gauge").css("left", timer_gauge + "px");
        if (service_check) {

            if (countdown_seconds <= 0 && live_game_board.is_run === false) {
                live_game_board.is_run = true;
                setTimeout(function () {
                    location.reload()
                }, 3000);
            }

        } else {
            (function () {
                document.addEventListener('visibilitychange', handleVisibilityChange, false);
            })();

            HiddenTabTimer = isHiddenTab ? 7 : 4
            if (countdown_seconds < HiddenTabTimer && live_game_board.getNewResult === false) {
                live_game_board.get_result();
                minigame_banner.hide();
            }
            if (countdown_seconds <= 0 && live_game_board.is_run === false) {
                live_game_board.is_run = true;
                live_game_board.run();
            }
            if (countdown_seconds <= sound_effect_seconds && live_game_board.is_play_sound === false) {
                live_game_board.is_play_sound = true;
                if (live_game_board.is_sound() === false) {
                    live_game_board.bgm_sound.muted = true;
                }
                live_game_board.sound_func();
            }
            if (countdown_seconds > 298 && live_game_board.getNewResult === true && live_game_board.is_run === false) {
                live_game_board.is_run = true;
                live_game_board.run();
            }
        }
    }
    setTimeout(game_execute, 250);
}

function dist_execute() {

    var dist_type;
    if (live_game_type == 'powerkeno_ladder') {
        var round = game_clock.get_round(live_game_type);
        if (round % 2 == 0) dist_type = 'keno_ladder';
        else dist_type = 'power_ladder';
    } else {
        dist_type = live_game_type;
    }

    live_game_board.dist(game_dist.result[dist_type]);
    setTimeout(dist_execute, 3000);
}

$(function () {
    minigame_banner.getNewBanner();
    game_execute();
    dist_execute();

    $('#btn_sound').click(function () {
        $(this).toggleClass("on", live_game_board.switch_sound().is_sound());
    }).toggleClass("on", live_game_board.is_sound());

    $('#btn_tip').click(function () {
        var $ly_game_tip = $('#ly_game_tip');
        if ($ly_game_tip.is(':hidden')) {
            $(this).addClass('on');
            $ly_game_tip.show();
        } else {
            $(this).removeClass('on');
            $ly_game_tip.hide();
        }
    });

    $('#btn_share').click(function () {
        var $ly_share = $('#ly_share');
        if ($ly_share.is(':hidden')) {
            $(this).addClass('on');
            $ly_share.show();
        } else {
            $(this).removeClass('on');
            $ly_share.hide();
        }
    });

});