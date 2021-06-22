(function(window, $, undefined) {

    let module = {},
        diff = 0,
        d = '',
        baseTime,
        config = {
            power_ladder  : {diffSec: 0, returnMinute: 5, countDownDiff: (1000 * 60 * 2) + (1000 * 5)},
            powerball     : {diffSec: 0, returnMinute: 5, countDownDiff: (1000 * 60 * 2) + (1000 * 5)},
            keno_ladder   : {diffSec: 0, returnMinute: 5, countDownDiff: 1000 * 5},
            speedkeno     : {diffSec: 0, returnMinute: 5, countDownDiff: 1000 * 5},
            dari          : {diffSec: -10, returnMinute: 3, countDownDiff: 0},
            racing        : {diffSec: -10, returnMinute: 5, countDownDiff: 0},
            ladder        : {diffSec: -10, returnMinute: 5, countDownDiff: 0},
            new_racing    : {diffSec: 0, returnMinute: 3, countDownDiff: 0},
            fx_game_1    : {diffSec: 0, returnMinute: 1, countDownDiff: 0},
            fx_game_2    : {diffSec: 0, returnMinute: 2, countDownDiff: 0},
            fx_game_3    : {diffSec: 0, returnMinute: 3, countDownDiff: 0},
            fx_game_4    : {diffSec: 0, returnMinute: 4, countDownDiff: 0},
            fx_game_5    : {diffSec: 0, returnMinute: 5, countDownDiff: 0},

            fx_ladder_1    : {diffSec: 0, returnMinute: 1, countDownDiff: -1000 * 5},
            fx_ladder_2    : {diffSec: 0, returnMinute: 2, countDownDiff: -1000 * 5},
            fx_ladder_3    : {diffSec: 0, returnMinute: 3, countDownDiff: -1000 * 5},
            fx_ladder_4    : {diffSec: 0, returnMinute: 4, countDownDiff: -1000 * 5},
            fx_ladder_5    : {diffSec: 0, returnMinute: 5, countDownDiff: -1000 * 5},
        },

        breakTimes = [
            {
                fx_ladder_1: ['00:00:00', '23:59:59'],
                fx_ladder_2: ['00:00:00', '23:59:59'],
                fx_ladder_3: ['00:00:00', '23:59:59'],
                fx_ladder_4: ['00:00:00', '23:59:59'],
                fx_ladder_5: ['00:00:00', '23:59:59'],
                fx_game_1: ['00:00:00', '23:59:59'],
                fx_game_2: ['00:00:00', '23:59:59'],
                fx_game_3: ['00:00:00', '23:59:59'],
                fx_game_4: ['00:00:00', '23:59:59'],
                fx_game_5: ['00:00:00', '23:59:59']
            },
            {
                fx_ladder_1: ['00:00:00', '07:20:01'],
                fx_ladder_2: ['00:00:00', '07:20:01'],
                fx_ladder_3: ['00:00:00', '07:21:01'],
                fx_ladder_4: ['00:00:00', '07:20:01'],
                fx_ladder_5: ['00:00:00', '07:20:01'],
                fx_game_1: ['00:00:00', '07:20:01'],
                fx_game_2: ['00:00:00', '07:20:01'],
                fx_game_3: ['00:00:00', '07:21:01'],
                fx_game_4: ['00:00:00', '07:20:01'],
                fx_game_5: ['00:00:00', '07:20:01']
            },
            {
                fx_ladder_1: ['06:20:05', '07:20:01'],
                fx_ladder_2: ['06:20:05', '07:20:01'],
                fx_ladder_3: ['06:21:05', '07:21:01'],
                fx_ladder_4: ['06:20:05', '07:20:01'],
                fx_ladder_5: ['06:20:05', '07:20:01'],
                fx_game_1: ['06:20:05', '07:20:01'],
                fx_game_2: ['06:20:05', '07:20:01'],
                fx_game_3: ['06:21:05', '07:21:01'],
                fx_game_4: ['06:20:05', '07:20:01'],
                fx_game_5: ['06:20:05', '07:20:01']
            },
            {
                fx_ladder_1: ['06:20:05', '07:20:01'],
                fx_ladder_2: ['06:20:05', '07:20:01'],
                fx_ladder_3: ['06:21:05', '07:21:01'],
                fx_ladder_4: ['06:20:05', '07:20:01'],
                fx_ladder_5: ['06:20:05', '07:20:01'],
                fx_game_1: ['06:20:05', '07:20:01'],
                fx_game_2: ['06:20:05', '07:20:01'],
                fx_game_3: ['06:21:05', '07:21:01'],
                fx_game_4: ['06:20:05', '07:20:01'],
                fx_game_5: ['06:20:05', '07:20:01']
            },
            {
                fx_ladder_1: ['06:20:05', '07:20:01'],
                fx_ladder_2: ['06:20:05', '07:20:01'],
                fx_ladder_3: ['06:21:05', '07:21:01'],
                fx_ladder_4: ['06:20:05', '07:20:01'],
                fx_ladder_5: ['06:20:05', '07:20:01'],
                fx_game_1: ['06:20:05', '07:20:01'],
                fx_game_2: ['06:20:05', '07:20:01'],
                fx_game_3: ['06:21:05', '07:21:01'],
                fx_game_4: ['06:20:05', '07:20:01'],
                fx_game_5: ['06:20:05', '07:20:01']
            },
            {
                fx_ladder_1: ['06:20:05', '07:20:01'],
                fx_ladder_2: ['06:20:05', '07:20:01'],
                fx_ladder_3: ['06:21:05', '07:21:01'],
                fx_ladder_4: ['06:20:05', '07:20:01'],
                fx_ladder_5: ['06:20:05', '07:20:01'],
                fx_game_1: ['06:20:05', '07:20:01'],
                fx_game_2: ['06:20:05', '07:20:01'],
                fx_game_3: ['06:21:05', '07:21:01'],
                fx_game_4: ['06:20:05', '07:20:01'],
                fx_game_5: ['06:20:05', '07:20:01']
            },
            {
                fx_ladder_1: ['05:00:05', '23:59:59'],
                fx_ladder_2: ['05:00:05', '23:59:59'],
                fx_ladder_3: ['05:00:05', '23:59:59'],
                fx_ladder_4: ['05:00:05', '23:59:59'],
                fx_ladder_5: ['05:00:05', '23:59:59'],
                fx_game_1: ['05:00:05', '23:59:59'],
                fx_game_2: ['05:00:05', '23:59:59'],
                fx_game_3: ['05:00:05', '23:59:59'],
                fx_game_4: ['05:00:05', '23:59:59'],
                fx_game_5: ['05:00:05', '23:59:59']
            }
            ]

    let get_powerkeno_round_type = function() {

        let round_type,
            ii = d.getMinutes(),
            ss = d.getSeconds(),
            curr_seconds = ((ii * 60) + ss + 5) % 300;

        if (curr_seconds <= 180 && curr_seconds !== 0){
            round_type = 'power_ladder';
        } else {
            round_type = 'keno_ladder';
        }
        return round_type;
    };

    let countdown = {
        seconds : function(game){
            let returnMinute = config[game].returnMinute,
                countDownDiff = config[game].countDownDiff,
                pass_seconds = (baseTime + (config[game].diffSec * 1000) + countDownDiff) % (60 * returnMinute * 1000),
                countdown_seconds = Math.ceil(((60 * returnMinute * 1000) - pass_seconds) / 1000);

            countdown_seconds = (countdown_seconds >= (60 * returnMinute)) ? 0 : countdown_seconds;
            return countdown_seconds;
        },
        basic : function(game){
            return countdown.seconds(game);

        },
        powerkeno : function(){
            let game = get_powerkeno_round_type();
            return countdown.seconds(game);
        }
    };

    let gauge = {
        basic : function(game, seconds){
            let returnMinute = config[game].returnMinute;
            return seconds / (returnMinute * 60) * 100;
        },
        powerkeno : function(game, seconds){
            let returnMinute = 0,
                round_type = get_powerkeno_round_type();
            switch (round_type) {
                case 'power_ladder' : returnMinute = 3; break;
                case 'keno_ladder'  : returnMinute = 2; break;
            }
            return seconds / (returnMinute * 60) * 100;
        }
    };

    let date_round = {

        basic : function(game){
            let returnMinute = config[game].returnMinute,
                countDownDiff = config[game].countDownDiff,
                round = Number(((d.getHours() * 3600) + (d.getMinutes() * 60) + d.getSeconds() + (countDownDiff/1000)) / (60 * returnMinute));
            round = Math.floor(round) + 1;
            return round;
        },
        powerkeno : function(){

            let curr_seconds = Number((d.getHours() * 3600) + (d.getMinutes() * 60) + d.getSeconds() + 5),
                round = Math.floor(curr_seconds  / 300) * 2,
                remain_seconds = curr_seconds % 300;

            if (remain_seconds <= 180 && remain_seconds !== 0){
                round = round + 1;
            } else {
                round = round + 2;
            }
            return round;
        },
        fx_game : function(min) {
            const number_of_day = d.getDay();
            if(number_of_day === 0 ) {
                return false;
            }
            const start_5 = (3600 * 5);
            const start_6_20 = (3600 * 6) + 20;
            const end_7_20 = (3600 * 7) + 20;
            let hh = parseInt(d.getHours());
            const ii = parseInt(d.getMinutes());
            const remain = parseInt(min) - Math.round(ii % parseInt(min));
            let minute =  ii + remain + min;
            if(minute > 59) {
                minute = minute % 60;
                hh++;
                if(hh > 23) {
                    hh = 0;
                }
            }
            const compare_minute = hh * 3600 + minute;
            if(start_6_20 < compare_minute && end_7_20 > compare_minute) {
                return false;
            } else if(number_of_day === 6 && start_5 < compare_minute) {
                return false;
            } else if(number_of_day === 1 && end_7_20 > compare_minute) {
                return false;
            }
            hh = hh.toString().length >= 2 ? hh : '0' + hh;
            minute = minute.toString().length >= 2 ? minute : '0' + minute;
            return hh + ':' + minute;
        }
    };

    module.update = function() {

        d = new Date();
        baseTime = d.getTime() + diff;
        d.setTime(baseTime);

        return diff;
    };

    module.get_timer = function(game){

        let d2 = d;
        if (typeof game !== "undefined") {

            if (game === "powerkeno_ladder") {
                game = get_powerkeno_round_type();
            }

            let time = d.getTime() + (config[game].diffSec * 1000);


            d2.setTime(time);
        }

        let yyyy = d2.getFullYear();
        let mm   = d2.getMonth() + 1;
        let dd   = d2.getDate();
        let hh   = d2.getHours();
        let ii   = d2.getMinutes();
        let ss   = d2.getSeconds();

        mm = (mm<10) ? "0" + mm : mm;
        dd = (dd<10) ? "0" + dd : dd;
        hh = (hh<10) ? "0" + hh : hh;
        ii = (ii<10) ? "0" + ii : ii;
        ss = (ss<10) ? "0" + ss : ss;

        return {
            date: d2,
            yyyy: yyyy,
            mm: mm,
            dd: dd,
            hh: hh,
            ii: ii,
            ss: ss
        };
    };

    module.get_countdown_seconds = function(game){
        switch (game) {
            case 'powerkeno_ladder' :
                return countdown.powerkeno();
                break;
            default:
                return countdown.basic(game);
                break;
        }
    };

    module.get_gauge = function(game, seconds){
        switch (game) {
            case 'powerkeno_ladder' :
                return gauge.powerkeno(game, seconds);
                break;
            default:
                return gauge.basic(game, seconds);
                break;
        }
    };

    module.get_round = function(game){
        if(game.substr(0,2) === 'fx') {
            return date_round.fx_game(parseInt(game.substr(game.length -1)));
        } else if(game === 'powerkeno_ladder') {
            return date_round.powerkeno();
        } else {
            return date_round.basic(game);
        }
    };

    module.now_clock = function(t){
        return t.yyyy + "." + t.mm + "." + t.dd + " " + t.hh + ":" + t.ii + ":" + t.ss;
    };

    module.convert_countdown_clock = function(seconds){

        let ii = Math.floor(seconds / 60),
            ss = Math.floor(seconds % 60);

        return ii + "분 " + ss + "초";
    };

    module.set_diff = function(str) {
        diff = new Date(str).getTime() - new Date().getTime();
    };

    module.sync_clock = function() {
        $.ajax({
            type: "get",
            url: "/sync_clock",
            dataType: "json",
            cache: false,
            success: function (res, textStatus, request) {
                let response_time = new Date(request.getResponseHeader("Date")).getTime();
                module.set_diff(response_time);
            },
            complete: function() {
                setTimeout(function(){
                    module.sync_clock();
                }, 10000);
            }
        });
    };

    module.isRunningTime = function(t, game) {
        const date = t.yyyy + '/'  + t.mm + '/' + t.dd;
        const now = new Date();
        const day = now.getDay();

        const todayBreakTimeStart = new Date(date + ' ' + breakTimes[day][game][0]);
        const todayBreakTimeEnd = new Date(date + ' ' + breakTimes[day][game][1]);


        return !(todayBreakTimeStart.getTime() <= now.getTime() && todayBreakTimeEnd.getTime() >= now.getTime());
    }

    window.game_clock = module;

}(window, jQuery));
