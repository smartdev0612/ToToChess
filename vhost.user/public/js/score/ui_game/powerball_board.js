var PowerBallBoard = function(ready_round, game_type) {

    var self = this;
    this.is_run = false;
    this.is_play_sound = false;
    this.ready_round = Number(ready_round);
    this.ajax_object = null;
    this.result = null;
    this.retry_count = 3;
    this.MAX_TURN = 288;
    this.getNewResult = false;
    this.getNewResultfetchError = false;
    this.$game_board = $("#game_board");
    this.$waiting_board = $("#waiting_board");
    this.$score_board = $("#score_board");
    this.$result_board = $("#result_board");
    this.$dist_graph = $("#dist_graph");
    //this.bgm_sound = new Audio('/public/sound/powerball_sound.mp3');
    this.bgm_sound = new Audio('/public/sound/game-prepare.mp3');
    this.card_sound = new Audio('/public/sound/speedkeno_card_sound.mp3');
    this.result_url = '/result';

    this.get_result = function() {
        self.ajax_object = $.ajax({
            type: "get",
            url: self.result_url,
            cache: false,
            dataType: "json",
            success: function(response) {
                if (self.ready_round == response.date_round) {
                    self.getNewResultfetchError = false;
                    self.getNewResult = true;
                    self.result = response;
                } else if (self.ready_round != response.date_round) {
                    self.getNewResultfetchError = true;
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                self.getNewResultfetchError = true;
            }
        });
    };

    this.play = function() {

        var cast_bx_idx = 0;
        var ani_move = setInterval(function() {
            cast_bx_idx++;
            if (cast_bx_idx > 7) cast_bx_idx = 0;
            self.$game_board.find('.bg_animation span').removeClass().addClass('ani' + cast_bx_idx);
        }, 100);

        self.$waiting_board.fadeOut(500);
        self.$score_board.fadeIn(1000);

        self.$score_board.find('.curr_round span')[0].innerText = ' (' + self.result.times + ')';

        var ball_idx = 0;
        var ball_type = 'n';
        var cast_lots = function() {

            if (self.is_sound() === true) self.card_sound.play();

            self.$score_board.find('.result_ball').append("<em class='" + ball_type + self.result.ball[ball_idx] + "'></em>");

            if (ball_idx == 4) {
                self.$game_board.find('.bg_animation').addClass('powerball');
                ball_type = 'p';
            }
            if (ball_idx == 5) {
                clearInterval(ani_move);
                self.animate_callback();
            }
            if (ball_idx < 5) {
                setTimeout(function() { cast_lots(); }, 1500);
            }
            ball_idx++;
        };
        setTimeout(function() { cast_lots(); }, 2000);
    };

    this.run = function() {
        if (self.getNewResultfetchError || self.result === null) {
            self.$waiting_board.addClass("msg").find(".tx").html("게임 추첨 결과를 집계중입니다.<br/>잠시만 기다려 주세요.");
            if (self.retry_count > 0) {
                self.retry_count--;
                setTimeout(function() {
                    self.run();
                }, 1000);
                return false;
            } else {
                // alert("회차정보 오류로 인하여 결과값을 가져 올 수 없습니다.");
                self.animate_callback(false)
                return false;
            }
        } else {
            self.play();
        }
    };

    /**
     * 결과에 따른 애니메이션 처리
     * @param status 결과/회차 정보 상테
     */
    this.animate_callback = function(status = true) {
        if (status) {
            self.$result_board.find('.round').html("이번 " + self.result.date_round + "회차");
            self.$result_board.find('.powerball').html("[" + self.result.ball[5] + "] [" + self.result.pow_ball_oe + "] [" + self.result.pow_ball_unover + "]");
            self.$result_board.find('.sum').html("[" + self.result.def_ball_sum + "] [" + self.result.def_ball_oe + "] [" + self.result.def_ball_unover + "] [" + self.result.def_ball_size + "] [" + self.result.def_ball_section + "]");
            self.$score_board.fadeOut(2000);
            self.$result_board.fadeIn(2000);
        }

        setTimeout(function() {
            self.$waiting_board.removeClass("msg").find(".tx").html('<span id="countdown_clock" class="countdown_clock">-분 --초 후</span>  <strong class="next_turn">' + (self.ready_round + 1) + '</strong>회차 추첨 시작');
            self.ready_round += 1;
            var nextTurn = self.result.date_round + 1 > self.MAX_TURN ? 1 : self.result.date_round + 1;
            self.$score_board.find('.curr_round strong')[0].innerText = nextTurn;
            self.$score_board.find('.curr_round span')[0].innerText = ' (' + self.ready_round + ')';
            self.$waiting_board.find('.next_turn')[0].innerText = nextTurn;
            self.gameReset();
            minigame_banner.getNewBanner();
        }, status ? 7000 : 0);

    };

    /**
     * 아이프레임인지 확인
     * @returns {boolean}
     */
    this.in_iframe = function() {
        try {
            return window.self !== window.top;
        } catch (e) {
            return true;
        }
    }

    this.is_sound = function() {
        return cookie.get(game_type) == "off" ? false : true;
    };

    this.switch_sound = function() {
        if (this.is_sound()) {
            cookie.set(game_type, "off", null);
            self.bgm_sound.muted = true;
        } else {
            cookie.set(game_type, "", null);
            self.bgm_sound.muted = false;
        }
        return this;
    };

    this.sound_func = function() {
        self.bgm_sound.play();
    };

    this.dist = function(res) {

        if ($.isEmptyObject(res) == true) return false;

        $.each(self.$dist_graph.find('.item'), function() {

            var $o = $(this),
                $tit = $o.find('dt'),
                $sect = $o.find('dl'),
                type = $o.attr('rel');

            if (type == 'b_sect') {

                $sect.removeClass();

                var big_val = Number(res[type][0]),
                    middle_val = Number(res[type][1]),
                    small_val = Number(res[type][2]),
                    max_val = Math.max.apply(null, res['b_sect']);

                if (max_val != 0) {
                    if (max_val == big_val) $sect.addClass('big_on');
                    if (max_val == middle_val) $sect.addClass('middle_on');
                    if (max_val == small_val) $sect.addClass('small_on');
                }

                $o.find('.big .tx').html(big_val + "%").next('.gauge').css('width', big_val + "%");
                $o.find('.middle .tx').html(middle_val + "%").next('.gauge').css('width', middle_val + "%");
                $o.find('.small .tx').html(small_val + "%").next('.gauge').css('width', small_val + "%");

            } else {

                $tit.removeClass();

                var left_val = res[type][0],
                    right_val = res[type][1];

                if (left_val > right_val) $tit.addClass('left_on');
                else if (left_val < right_val) $tit.addClass('right_on');

                $o.find('.left .tx').html(left_val + "%").next('.gauge').css('width', left_val + "%");
                $o.find('.right .tx').html(right_val + "%").next('.gauge').css('width', right_val + "%");
            }
        });
    };

    this.newResultRender = function() {
        $('.result_list').prepend(
            '<li>\
                <p class="round"><strong>' + self.result.date_round + ' </strong>(' + self.result.times + ')</p>\
                <p class="result_ball">\
                    <em class="n' + self.result.ball[0] + '">' + self.result.ball[0] + '</em>\
                    <em class="n' + self.result.ball[1] + '">' + self.result.ball[1] + '</em>\
                    <em class="n' + self.result.ball[2] + '">' + self.result.ball[2] + '</em>\
                    <em class="n' + self.result.ball[3] + '">' + self.result.ball[3] + '</em>\
                    <em class="n' + self.result.ball[4] + '">' + self.result.ball[4] + '</em>\
                    <em class="p' + self.result.ball[5] + '">' + self.result.ball[5] + '</em>\
                </p>\
            </li>')
        $('#recent_result .result_list li').eq(0).hide().fadeIn();
        getNewChatList();
        self.result = null;
    }

    this.gameReset = function() {
        self.$game_board.find('.bg_animation').removeClass('powerball');
        self.$game_board.find('.bg_animation > span').removeClass().addClass('ani0');
        self.$score_board.find('.result_ball').empty();
        self.$result_board.fadeOut(0);
        self.$waiting_board.fadeIn(0);
        self.is_run = false;
        self.getNewResult = false;
        self.getNewResultfetchError = false;
        self.newResultRender();
    }
};