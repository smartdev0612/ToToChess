/**
 * Created by lsky on 2016. 10. 27..
 * Mobile
 */
;(function (window) {

    'use strict';

    function Real20Controller(options, mobile) {
        this._options.frameOne = options.frameOne;

        this._options.frameTwo.one = options.frameTwo.one;
        this._options.frameTwo.two = options.frameTwo.two;
        this._options.frameTwo.three = options.frameTwo.three;
        this._options.frameTwo.four = options.frameTwo.four;
        this._options.frameTwo.status.frame = options.frameTwo.status.frame;
        this._options.frameTwo.status.type = options.frameTwo.status.type;
        this._options.frameTwo.status.allocation = options.frameTwo.status.allocation;

        this._options.frameThree.batting = options.frameThree.batting;
        this._options.frameThree.directInput = options.frameThree.directInput;
        this._options.frameThree.status.money1 = options.frameThree.status.money1;
        this._options.frameThree.status.money2 = options.frameThree.status.money2;

        this._options.battingSubmit = options.battingSubmit;

        this._options.mobile = mobile;

        this._init();
    }

    Real20Controller.prototype._options = {
        clickType: "click",
        frameOne: {
            layout: null,
            buttons: []
        },
        frameTwo: {
            one: [],
            two: [],
            three: [],
            four: [],
            status: {
                frame: null,
                type: null,
                value: [-1, -1, -1, -1],
                allocationvVlaue: [-1, -1, -1, -1]
            }
        },
        frameThree: {
            batting: null,
            directInput: null,
            status: {
                money1: null,
                money2: null
            }
        },
        battingSubmit: null,
        mobile: false,
        realStreamUrl: {
            desk: {
                full: "http://namu-888.com/live/live.html",
                big: "http://namu-888.com/live/live2.html"
            },
            mobile: {
                full: "http://www.titan-330.com/webplayer/mlive1.html",
                big: "http://www.titan-330.com/webplayer/mlive2.html"
            }
        }
    };

    Real20Controller.prototype._init = function () {
        this._frameOne_addEventListener();
        //this._frameOne_liveEnlargedScreen_module();

        this._frameTwo_oneBettingAddEventListener();
        this._frameTwo_twoBettingAddEventListener();
        this._frameTwo_threeBettingAddEventListener();
        this._frameTwo_fourBettingAddEventListener();

        this._frameThree_moneyAddEventListener();
        this._frameThree_moneyDirectInputAddEventListener();

        this._gameBatting_addEventListener();
    };

    Real20Controller.prototype._frameOne_addEventListener = function () {
        var self = this;

        if (this._options.frameOne.buttons.length != 4) {
            console.log("FrameOne: The number of registered object in the list does not match. Request confirmation.");
            return false;
        }

        var videohtml = '';
        videohtml = '<video id="real20_movie" controls autoplay muted loop playsinline src="#" style="width:100%; height:100%"></video>';
        $(this._options.frameOne.layout).html(videohtml);
        /*
         if (this._module_unctioniOS()) {
         videohtml = '<canvas id="theCanvas" style="width:100%; height:100%"></canvas>' +
         '<video id="real20_movie" controls autoplay muted loop playsinline src="#" style="display: none;"></video>';

         $(this._options.frameOne.layout).html(videohtml);

         var canvas = document.getElementById("theCanvas");
         var context = canvas.getContext("2d");
         var video = document.getElementById("real20_movie");
         drawVideo(context, video, canvas.width, canvas.height);
         } else {
         videohtml = '<video id="real20_movie" controls autoplay muted loop playsinline src="#" style="width:100%; height:100%"></video>';
         $(this._options.frameOne.layout).html(videohtml);
         }
         */
        /* ????????? ???????????? ?????? ????????? ?????? */
        if (this._options.frameOne.buttons[0].length == 1) {
            $(this._options.frameOne.buttons[0]).on(this._options.clickType, function (event) {
                event.preventDefault();

                self._frameOne_imageGameScreen_module();
            });
        } else {
            console.log("FrameOne: The index 0 object does not exist.");
        }

        /* LIVE ???????????? ?????? ????????? ?????? */
        if (this._options.frameOne.buttons[1].length == 1) {
            $(this._options.frameOne.buttons[1]).on(this._options.clickType, function (event) {
                event.preventDefault();

                self._frameOne_liveFullScreen_module();
            });
        } else {
            console.log("FrameOne: The index 1 object does not exist.");
        }

        /* LIVE ???????????? ?????? ????????? ?????? */
        if (this._options.frameOne.buttons[2].length == 1) {
            $(this._options.frameOne.buttons[2]).on(this._options.clickType, function (event) {
                event.preventDefault();

                self._frameOne_liveEnlargedScreen_module();
            });
        } else {
            console.log("FrameOne: The index 2 object does not exist.");
        }

        /* ??????20??? ???????????? ????????? ?????? */
        if (this._options.frameOne.buttons[3].length == 1) {
            var $overlay = $('#__overlayreadme');
            // $('#__overlayreadme').show().find('.__closebtn').one('click', function(e){
            $(this._options.frameOne.buttons[3]).on(this._options.clickType, function (event) {
                $overlay.show().find('.__closebtn').one('click', function(){
                    $overlay.hide();
                });
            });
        } else {
            console.log("FrameOne: The index 3 object does not exist.");
        }
    };

    Real20Controller.prototype._frameOne_imageGameScreen_module = function () {
        var video = document.getElementById("real20_movie");

        if ($(this._options.frameOne.layout).is(":visible")) {
            $(this._options.frameOne.layout).hide();
            if (this._module_unctioniOS()) {
                if (!video.paused) video.pause();
                $(this._options.frameOne.layout).find("#real20_movie").removeAttr("src");
            } else {
                $(this._options.frameOne.layout).find("#real20_movie").removeAttr("src");
            }
        }
    };

    Real20Controller.prototype._frameOne_liveFullScreen_module = function () {
        var streamingUrl = this._options.mobile ? this._options.realStreamUrl.mobile.full : this._options.realStreamUrl.desk.full;
        var self = this;

        var video = document.getElementById("real20_movie");

        video.pause();
        if (!$(this._options.frameOne.layout).is(":visible")) {
            $(self._options.frameOne.layout).find("#real20_movie").attr("src", "http://www.titan-330.com/webplayer/livestream1/live1.m3u8");
            video.load();
            $(self._options.frameOne.layout).show();
            video.play();
        } else {
            $(self._options.frameOne.layout).find("#real20_movie").attr("src", "http://www.titan-330.com/webplayer/livestream1/live1.m3u8");
            video.load();
            video.play();
        }

    };

    Real20Controller.prototype._frameOne_liveEnlargedScreen_module = function () {
        var streamingUrl = this._options.mobile ? this._options.realStreamUrl.mobile.big : this._options.realStreamUrl.desk.big;
        var self = this;

        var video = document.getElementById("real20_movie");

        video.pause();
        if (!$(this._options.frameOne.layout).is(":visible")) {
            $(self._options.frameOne.layout).find("#real20_movie").removeAttr("src").attr("src", "http://www.titan-330.com/webplayer/livestream2/live2.m3u8");
            video.load();
            $(self._options.frameOne.layout).show();
            video.play();
        } else {
            $(self._options.frameOne.layout).find("#real20_movie").removeAttr("src").attr("src", "http://www.titan-330.com/webplayer/livestream2/live2.m3u8");
            video.load();
            video.play();
        }
    };

    Real20Controller.prototype._frameOne_allRemoveEventListener = function () {
        this._module_removeEventListner(this._options.frameOne.buttons, this._options.clickType);
    };

    Real20Controller.prototype._frameTwo_oneBettingAddEventListener = function () {
        var self = this;

        $(this._options.frameTwo.one).on(this._options.clickType, function (event) {
            var currentIndex = $(self._options.frameTwo.one).index($(this));

            if ($(this).is(".active")) {
                $(this).removeClass("active");

                self._options.frameTwo.status.value[0] = -1;
                self._options.frameTwo.status.allocationvVlaue[0] = -1;
            } else {
				self._frameTwo_threeBettingReset();
                self._frameTwo_fourBettingReset();

                $.each(self._options.frameTwo.one, function (key, value) {
                    if (key == Number(currentIndex)) {
                        $(value).addClass('active');
                    } else {
                        $(value).removeClass('active');
                    }
                });

                self._options.frameTwo.status.value[0] = currentIndex;
                self._options.frameTwo.status.allocationvVlaue[0] = 1.95;
            }

            self._frameTwo_statusPanel();
        });
    };

    Real20Controller.prototype._frameTwo_oneBettingRemoveEventListener = function () {
        this._module_removeEventListner(this._options.frameTwo.one, this._options.clickType);
    };

    Real20Controller.prototype._frameTwo_oneBettingReset = function () {
        this._options.frameTwo.status.value[0] = -1;
        this._options.frameTwo.status.allocationvVlaue[0] = -1;

        this._options.frameTwo.one.removeClass("active");
    };

    Real20Controller.prototype._frameTwo_twoBettingAddEventListener = function () {
        var self = this;

        $(this._options.frameTwo.two).on(this._options.clickType, function (event) {
            var currentIndex = $(self._options.frameTwo.two).index($(this));

            if ($(this).is(".active")) {
                $(this).removeClass("active");

                self._options.frameTwo.status.value[1] = -1;
                self._options.frameTwo.status.allocationvVlaue[1] = -1;
            } else {
				self._frameTwo_threeBettingReset();
                self._frameTwo_fourBettingReset();

                $.each(self._options.frameTwo.two, function (key, value) {
                    if (key == Number(currentIndex)) {
                        $(value).addClass('active');
                    } else {
                        $(value).removeClass('active');
                    }
                });

                self._options.frameTwo.status.value[1] = currentIndex;
                self._options.frameTwo.status.allocationvVlaue[1] = 1.95;
            }

            self._frameTwo_statusPanel();
        });
    };

    Real20Controller.prototype._frameTwo_twoBettingRemoveEventListener = function () {
        this._module_removeEventListner(this._options.frameTwo.two, this._options.clickType);
    };

    Real20Controller.prototype._frameTwo_twoBettingReset = function () {
        this._options.frameTwo.status.value[1] = -1;
        this._options.frameTwo.status.allocationvVlaue[1] = -1;

        this._options.frameTwo.two.removeClass("active");
    };

    Real20Controller.prototype._frameTwo_threeBettingAddEventListener = function () {
        var self = this;

        $(this._options.frameTwo.three).on(this._options.clickType, function (event) {
            var currentIndex = $(self._options.frameTwo.three).index($(this));

            if ($(this).is(".active")) {
                $(this).removeClass("active");

                self._options.frameTwo.status.value[2] = -1;
                self._options.frameTwo.status.allocationvVlaue[2] = -1;
            } else {
                self._frameTwo_oneBettingReset();
                self._frameTwo_twoBettingReset();
                self._frameTwo_fourBettingReset();

                $.each(self._options.frameTwo.three, function (key, value) {
                    if (key == Number(currentIndex)) {
                        $(value).addClass('active');
                    } else {
                        $(value).removeClass('active');
                    }
                });

                self._options.frameTwo.status.value[2] = currentIndex;
                if (currentIndex == 1) {
                    self._options.frameTwo.status.allocationvVlaue[2] = 9.00;
                } else {
                    self._options.frameTwo.status.allocationvVlaue[2] = 1.95;
                }
            }

            self._frameTwo_statusPanel();
        });
    };

    Real20Controller.prototype._frameTwo_threeBettingRemoveEventListener = function () {
        this._module_removeEventListner(this._options.frameTwo.three, this._options.clickType);
    };

    Real20Controller.prototype._frameTwo_threeBettingReset = function () {
        this._options.frameTwo.status.value[2] = -1;
        this._options.frameTwo.status.allocationvVlaue[2] = -1;

        this._options.frameTwo.three.removeClass("active");
    };

    Real20Controller.prototype._frameTwo_fourBettingAddEventListener = function () {
        var self = this;

        $(this._options.frameTwo.four).on(this._options.clickType, function (event) {
            var currentIndex = $(self._options.frameTwo.four).index($(this));

            if ($(this).is(".active")) {
                $(this).removeClass("active");

                self._options.frameTwo.status.value[3] = -1;
                self._options.frameTwo.status.allocationvVlaue[3] = -1;
            } else {
                self._frameTwo_oneBettingReset();
                self._frameTwo_twoBettingReset();
                self._frameTwo_threeBettingReset();

                $.each(self._options.frameTwo.four, function (key, value) {
                    if (key == Number(currentIndex)) {
                        $(value).addClass('active');
                    } else {
                        $(value).removeClass('active');
                    }
                });

                self._options.frameTwo.status.value[3] = currentIndex;
                self._options.frameTwo.status.allocationvVlaue[3] = 8.50;
            }

            self._frameTwo_statusPanel();
        });
    };

    Real20Controller.prototype._frameTwo_fourBettingRemoveEventListener = function () {
        this._module_removeEventListner(this._options.frameTwo.four, this._options.clickType);
    };

    Real20Controller.prototype._frameTwo_fourBettingReset = function () {
        this._options.frameTwo.status.value[3] = -1;
        this._options.frameTwo.status.allocationvVlaue[3] = -1;

        this._options.frameTwo.four.removeClass("active");
    };

    Real20Controller.prototype._frameThree_moneyAddEventListener = function () {
        var self = this;

        $(this._options.frameThree.batting).on(this._options.clickType, function (event) {
            var currentMoney = Number(self._module_uncomma(self._options.frameThree.status.money1.val())),
                currentItem = $(this).data('item');

            //console.log(currentItem);
            if (self._module_isInt(currentItem)) {
                self._options.frameThree.status.money1.val(self._module_comma(currentMoney + Number(currentItem)));
                self._frameThree_statusFinalAmount();
            } else {
                switch (currentItem) {
                    case 'reset': {
                        self._options.frameThree.status.money1.val('0');
                        self._options.frameThree.status.money2.val('0');
                        self._options.frameThree.directInput.val('0');

                        break;
                    }
                    case 'all': {
                        self._options.frameThree.status.money1.val(self._module_comma(VarMoney));
                        self._frameTwo_statusPanel();

                        break;
                    }
                }
            }
        });
    };

    Real20Controller.prototype._frameThree_moneyDirectInputAddEventListener = function () {
        var self = this;

        $(this._options.frameThree.directInput).on('keyup', function (event) {
            if (!(event.keyCode == 8                                // backspace
                || event.keyCode == 46                              // delete
                || (event.keyCode >= 35 && event.keyCode <= 40)     // arrow keys/home/end
                || (event.keyCode >= 48 && event.keyCode <= 57)     // numbers on keyboard
                || (event.keyCode >= 96 && event.keyCode <= 105))   // number on keypad
            ) {
                event.preventDefault();
            }
            var keyVal = self._module_comma(self._module_uncomma($(this).val()));

            $(this).val(keyVal);

            self._options.frameThree.status.money1.val(keyVal);
            self._frameThree_statusFinalAmount();
        });
    };

    Real20Controller.prototype._frameTwo_statusPanel = function () {
        var title = ["1??????", "2??????", "3??????", "4??????", "????????????"],
            titleKey = -1,
            oneText = ["???", "???"],
            twoText = ["??????", "??????"],
            threeText = ["???", "???", "???"],
            status = [];


        if (this._options.frameTwo.status.value[0] != -1) status.push(oneText[this._options.frameTwo.status.value[0]]);
        if (this._options.frameTwo.status.value[1] != -1) status.push(twoText[this._options.frameTwo.status.value[1]]);
        if (this._options.frameTwo.status.value[2] != -1) status.push(threeText[this._options.frameTwo.status.value[2]]);
        if (this._options.frameTwo.status.value[3] != -1) status.push(Number(this._options.frameTwo.status.value[3] + 1));

        if (status.length == 1) {
            $(this._options.frameTwo.status.type).text('???????????????');
        } else if (status.length > 1) {
            $(this._options.frameTwo.status.type).text('???????????????');
        } else {
            $(this._options.frameTwo.status.type).text("??????");
        }

        $(this._options.frameTwo.status.frame).text(status.length == 0 ? '??????' : status);

        $(this._options.frameTwo.status.allocation).text(this._module_dividendRate(this._options.frameTwo.status.allocationvVlaue));

        this._frameThree_statusFinalAmount();
    };

    Real20Controller.prototype._frameThree_statusFinalAmount = function () {
        var dividendRate = this._module_dividendRate(this._options.frameTwo.status.allocationvVlaue);

        var currentMoney = Number(this._module_uncomma(this._options.frameThree.status.money1.val())),
            finalAmount = Number(currentMoney) * Number(dividendRate);

        if (currentMoney > 0)
            this._options.frameThree.status.money2.val(this._module_comma(finalAmount.toFixed(0)));
    };

    Real20Controller.prototype._gameBatting_addEventListener = function () {
        var self = this;

        $(this._options.battingSubmit).on(this._options.clickType, function (event) {
            var sendData = self._module_sendDataConfiguration();

            if (real20XMLHttpRequest._options.gameInfo.newlyStatus != 1) {
                alert('- ???????????? ??? ????????????.');
                return false;
            }

            if (sendData.btGameType.length == 0) {
                alert('- ????????? ???????????? ?????????.');
                return false;
            }

            if (sendData.btMoney == 0) {
                alert('- ????????? ???????????? ?????????.');
                return false;
            }

            self._gameBatting_gameCheckProcess(sendData);
			self._gameBatting_removeEventListener();
        });
    };

    Real20Controller.prototype._gameBatting_removeEventListener = function () {
        this._module_removeEventListner(this._options.battingSubmit, this._options.clickType);
    };

	Real20Controller.prototype._gameBatting_gameCheckProcess = function (sendData) {
        var self = null, url = null, request = null;

        try {
            self = this;
            url = '/RaceReal20/gameCheckProcess';
            request = this._module_ajaxHttp(true, false, url, 'POST', sendData, 'JSON');

            request.done(function (result) {
                if (result.result == 'ok') {
                    if (confirm("?????? ?????????????????????????")) {
                        self._gameBatting_raceBettingProcess(sendData);
                    }else{
						self._gameBatting_addEventListener();
					}
                } else {
                    alert('AJAX:' + result.error_msg);
                }
            });

            request.fail(function (jqXHR, textStatus) {
                console.log("Real20XMLHttpRequest lastRound Error, Request failed: " + textStatus);
            });
        } catch (exp) {
            console.log("Real20XMLHttpRequest getDate_init Error, " + exp.message);
        }
    };

    Real20Controller.prototype._gameBatting_raceBettingProcess = function (sendData) {
        var self = null, url = null, request = null;

        try {
            self = this;
            url = '/RaceReal20/raceBettingProcess';
            request = this._module_ajaxHttp(true, false, url, 'POST', sendData, 'JSON');

            request.done(function (result) {
                if (result.result == 'ok') {
                    alert('????????? ?????? ???????????????.');
                    window.location.reload(true);
                } else {
                    alert(result.error_msg);
                }
            });

            request.fail(function (jqXHR, textStatus) {
                console.log("Real20XMLHttpRequest lastRound Error, Request failed: " + textStatus);
            });
        } catch (exp) {
            console.log("Real20XMLHttpRequest getDate_init Error, " + exp.message);
        }
    };

	/*
    Real20Controller.prototype._gameBatting_gameCheckProcess = function (sendData) {
        var self = null, url = null, request = null;

        try {
            console.log(sendData);
            self = this;
            url = '/RaceReal20/gameCheckProcess';
            request = this._module_ajaxHttp(true, false, url, 'POST', sendData, 'JSON');

            request.done(function (result) {
                console.log(result);
                if (result.result == 'ok') {
                    if (confirm("?????? ?????????????????????????")) {
                        self._gameBatting_raceBettingProcess(sendData);
                    }
                } else {
                    alert('AJAX:' + result.error_msg);
                }
            });

            request.fail(function (jqXHR, textStatus) {
                console.log("Real20XMLHttpRequest lastRound Error, Request failed: " + textStatus);
            });
        } catch (exp) {
            console.log("Real20XMLHttpRequest getDate_init Error, " + exp.message);
        }
    };

    Real20Controller.prototype._gameBatting_raceBettingProcess = function (sendData) {
        var self = null, url = null, request = null;

        try {
            self = this;
            url = '/RaceReal20/raceBettingProcess';
            request = this._module_ajaxHttp(true, false, url, 'POST', sendData, 'JSON');

            request.done(function (result) {
                if (result.result == 'ok') {
                    alert('????????? ?????? ???????????????.');
                    window.location.reload(true);
                } else {
                    alert(result.error_msg);
                }
            });

            request.fail(function (jqXHR, textStatus) {
                console.log("Real20XMLHttpRequest lastRound Error, Request failed: " + textStatus);
            });
        } catch (exp) {
            console.log("Real20XMLHttpRequest getDate_init Error, " + exp.message);
        }
    };
	*/

    Real20Controller.prototype._module_removeEventListner = function (obj, event) {
        $.each(obj, function (key, value) {
            $(this).off(event);
        });
    };

    Real20Controller.prototype._module_dividendRate = function (obj) {
        var _return = 0;

        $.each(obj, function (key, value) {
            if (value != -1) {
                if (_return == 0) {
                    _return = value;
                } else {
                    _return = _return * value;
                }
            }
        });

        return _return.toFixed(2);
    };

    Real20Controller.prototype._module_comma = function (str) {
        str = String(str);
        return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
    };

    Real20Controller.prototype._module_uncomma = function (str) {
        str = String(str);
        return str.replace(/[^\d]+/g, '');
    };

    Real20Controller.prototype._module_isInt = function (value) {
        return !isNaN(value) && (function (x) {
                return (x | 0) === x;
            })(parseFloat(value))
    };

    Real20Controller.prototype._module_unctioniOS = function () {
        var isiOS = (navigator.userAgent.indexOf('iPhone') != -1) || (navigator.userAgent.indexOf('iPod') != -1) || (navigator.userAgent.indexOf('iPad') != -1)

        return isiOS;
        //var ua = navigator.userAgent;
        //var isiOS = /iPhone/i.test(ua) || /iPod/i.test(ua) || /iPad/i.test(ua)
    };

    Real20Controller.prototype._module_sendDataConfiguration = function () {
        var _retrun = {
            btGameTh: Number(real20XMLHttpRequest._options.gameInfo.newlyTurn),
            btMoney: Number(this._module_uncomma(this._options.frameThree.status.money1.val())),
            btGameType: []
        };

        if (this._options.frameTwo.status.value[0] != -1) {
            if (this._options.frameTwo.status.value[0] == 0) {
                _retrun.btGameType.push('g_odd');
            } else if (this._options.frameTwo.status.value[0] == 1) {
                _retrun.btGameType.push('g_even');
            }
        }
        if (this._options.frameTwo.status.value[1] != -1) {
            if (this._options.frameTwo.status.value[1] == 0) {
                _retrun.btGameType.push('g_over');
            } else if (this._options.frameTwo.status.value[1] == 1) {
                _retrun.btGameType.push('g_under');
            }
        }
        if (this._options.frameTwo.status.value[2] != -1) {
            if (this._options.frameTwo.status.value[2] == 0) {
                _retrun.btGameType.push('g_win-ri ');
            } else if (this._options.frameTwo.status.value[2] == 1) {
                _retrun.btGameType.push('g_win-n');
            } else if (this._options.frameTwo.status.value[2] == 2) {
                _retrun.btGameType.push('g_win-aul ');
            }
        }
        if (this._options.frameTwo.status.value[3] != -1) {
            _retrun.btGameType = ['g_t' + Number(Number(this._options.frameTwo.status.value[3]) + Number(1))];
        }

        return _retrun;
    };

    Real20Controller.prototype._module_ajaxHttp = function (async, cache, url, method, data, type) {
        return $.ajax({
            async: async,
            url: url,
            type: method,
            method: method,
            data: data,
            dataType: type,
            cache: cache,
            timeout: 20000, // sets timeout to 20 seconds
            beforeSend: function (xhr) {
                //xhr.setRequestHeader("ApiKey", "AmfyobvB2M91uIU8d6YOcw6nT4uGhl");
            }
        });
    };

    window.Real20Controller = Real20Controller;

})(window);