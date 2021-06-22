/**
 * Created by lsky on 2016. 11. 6..
 */
/*! npm.im/iphone-inline-video */
var makeVideoPlayableInline = function () {
    "use strict";
    function e(e, r, n, i) {
        function t(n) {
            d = r(t, i), e(n - (a || n)), a = n
        }

        var d, a;
        return {
            start: function () {
                d || t(0)
            }, stop: function () {
                n(d), d = null, a = 0
            }
        }
    }

    function r(r) {
        return e(r, requestAnimationFrame, cancelAnimationFrame)
    }

    function n(e, r, n, i) {
        function t(r) {
            Boolean(e[n]) === Boolean(i) && r.stopImmediatePropagation(), delete e[n]
        }

        return e.addEventListener(r, t, !1), t
    }

    function i(e, r, n, i) {
        function t() {
            return n[r]
        }

        function d(e) {
            n[r] = e
        }

        i && d(e[r]), Object.defineProperty(e, r, {get: t, set: d})
    }

    function t(e, r, n) {
        n.addEventListener(r, function () {
            return e.dispatchEvent(new Event(r))
        })
    }

    function d(e, r) {
        Promise.resolve().then(function () {
            e.dispatchEvent(new Event(r))
        })
    }

    function a(e) {
        var r = new Audio;
        return t(e, "play", r), t(e, "playing", r), t(e, "pause", r), r.crossOrigin = e.crossOrigin, r.src = e.src || e.currentSrc || "data:", r
    }

    function o(e, r, n) {
        (m || 0) + 200 < Date.now() && (e[b] = !0, m = Date.now()), n || (e.currentTime = r), A[++k % 3] = 100 * r | 0
    }

    function u(e) {
        return e.driver.currentTime >= e.video.duration
    }

    function s(e) {
        var r = this;
        r.video.readyState >= r.video.HAVE_FUTURE_DATA ? (r.hasAudio || (r.driver.currentTime = r.video.currentTime + e * r.video.playbackRate / 1e3, r.video.loop && u(r) && (r.driver.currentTime = 0)), o(r.video, r.driver.currentTime)) : r.video.networkState !== r.video.NETWORK_IDLE || r.video.buffered.length || r.video.load(), r.video.ended && (delete r.video[b], r.video.pause(!0))
    }

    function c() {
        var e = this, r = e[h];
        return e.webkitDisplayingFullscreen ? void e[E]() : ("data:" !== r.driver.src && r.driver.src !== e.src && (o(e, 0, !0), r.driver.src = e.src), void(e.paused && (r.paused = !1, e.buffered.length || e.load(), r.driver.play(), r.updater.start(), r.hasAudio || (d(e, "play"), r.video.readyState >= r.video.HAVE_ENOUGH_DATA && d(e, "playing")))))
    }

    function v(e) {
        var r = this, n = r[h];
        n.driver.pause(), n.updater.stop(), r.webkitDisplayingFullscreen && r[T](), n.paused && !e || (n.paused = !0, n.hasAudio || d(r, "pause"), r.ended && (r[b] = !0, d(r, "ended")))
    }

    function p(e, n) {
        var i = e[h] = {};
        i.paused = !0, i.hasAudio = n, i.video = e, i.updater = r(s.bind(i)), n ? i.driver = a(e) : (e.addEventListener("canplay", function () {
            e.paused || d(e, "playing")
        }), i.driver = {
            src: e.src || e.currentSrc || "data:", muted: !0, paused: !0, pause: function () {
                i.driver.paused = !0
            }, play: function () {
                i.driver.paused = !1, u(i) && o(e, 0)
            }, get ended() {
                return u(i)
            }
        }), e.addEventListener("emptied", function () {
            var r = !i.driver.src || "data:" === i.driver.src;
            i.driver.src && i.driver.src !== e.src && (o(e, 0, !0), i.driver.src = e.src, r ? i.driver.play() : i.updater.stop())
        }, !1), e.addEventListener("webkitbeginfullscreen", function () {
            e.paused ? n && !i.driver.buffered.length && i.driver.load() : (e.pause(), e[E]())
        }), n && (e.addEventListener("webkitendfullscreen", function () {
            i.driver.currentTime = e.currentTime
        }), e.addEventListener("seeking", function () {
            A.indexOf(100 * e.currentTime | 0) < 0 && (i.driver.currentTime = e.currentTime)
        }))
    }

    function l(e) {
        var r = e[h];
        e[E] = e.play, e[T] = e.pause, e.play = c, e.pause = v, i(e, "paused", r.driver), i(e, "muted", r.driver, !0), i(e, "playbackRate", r.driver, !0), i(e, "ended", r.driver), i(e, "loop", r.driver, !0), n(e, "seeking"), n(e, "seeked"), n(e, "timeupdate", b, !1), n(e, "ended", b, !1)
    }

    function f(e, r, n) {
        void 0 === r && (r = !0), void 0 === n && (n = !0), n && !g || e[h] || (p(e, r), l(e), e.classList.add("IIV"), !r && e.autoplay && e.play(), /iPhone|iPod|iPad/.test(navigator.platform) || console.warn("iphone-inline-video is not guaranteed to work in emulated environments"))
    }

    var m, y = "undefined" == typeof Symbol ? function (e) {
        return "@" + (e || "@") + Math.random()
    } : Symbol, g = /iPhone|iPod/i.test(navigator.userAgent) && !matchMedia("(-webkit-video-playable-inline)").matches, h = y(), b = y(), E = y("nativeplay"), T = y("nativepause"), A = [], k = 0;
    return f.isWhitelisted = g, f
}();

var real20Controller, real20XMLHttpRequest;

(function () {

    var optionsController = {
        frameOne: {
            layout: $("div.__videostream"),
            buttons: [
                $("a#__screen_image"),
                $("a#__screen_full_live"),
                $("a#__screen_big_live"),
                $("a#__screen_game_readme")
            ]
        },
        frameTwo: {
            one: $("ul.game20_betting1").find("input.__gameone_1"),
            two: $("ul.game20_betting2").find("input.__gameone_2"),
            three: $("ul.game20_betting3").find("input.__gameone_3"),
            four: $("ul.game20_betting4").find("input"),
            status: {
                frame: $("ul.new20_betting3").find(".__game_status"),
                type: $("ul.new20_betting3").find(".__game_type"),
                allocation: $("ul.new20_betting3").find(".__game_allocation")
            }
        },
        frameThree: {
            batting: $('div.bet_btn_inner').find('.__game_battingmoney'),
            directInput: $('.bet_money_free').find('.__game_moneydirect'),
            status: {
                money1: $('div.bet_money').find('.__game_money1'),
                money2: $('div.bet_money').find('.__game_money2')
            }
        },
        battingSubmit: $('.btn_area').find('.__game_batting')
    };

    var optionsXmlHttp = {
        battingPanel: {
            alert: $('div#bettingShadow2')
        },
        graphPanel: {
            object: [
                $('table#graphTable1'),
                $('table#graphTable2')
            ]
        },
        imagePanel: {
            images: $('img.__screen_viewImage'),
            texts: [
                $('ul.__screen_viewOne'),
                $('img.__screen_viewTwo'),
                $('ul.__screen_viewThree')
            ]
        },
        resultPanel: $("div.game20_result").children("ul"),
        statusPanel: {
            object: $('div.__screen_statusPanel')
        }
    };

    if (serverCheckTimeFiltering()) {
        //alertPanel(1, '오전9시~오전10시까지는 리얼20장 점검입니다.<br/>감사합니다.');
        //console.log('ab');
    } else {
        real20Controller = new Real20Controller(optionsController, isMobile());
        real20XMLHttpRequest = new Real20XMLHttpRequest(optionsXmlHttp, isMobile());
    }

})
();

function isMobile() {
    var isMobile = false;
    if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0, 4))) isMobile = true;
    return isMobile;
}

function drawVideo(context, video, width, height) {
    context.drawImage(video, 0, 0, width, height);
    var delay = 100;
    setTimeout(drawVideo, delay, context, video, width, height);
}

function serverCheckTimeFiltering(a) {
    var b = null, c = null, d = null, e = null, f = null, g = !1;
    return b = new Date, c = new Date(b.getFullYear(), b.getMonth(), b.getDate(), 9, 0, 0).getTime(), d = new Date(b.getFullYear(), b.getMonth(), b.getDate(), 10, 0, 0).getTime(), e = serverCurrentTime.split(":"), 2 == e.length && (f = new Date(b.getFullYear(), b.getMonth(), b.getDate(), e[0], e[1], 0).getTime()), g = c <= f && d >= f
}

function alertPanel(status, text) {
    var $panel = $('div#bettingShadow3');

    switch (status) {
        case 0: {
            $panel.hide();
            break;
        }
        case 1: {
            $panel.show().children('span').html(text);
            break;
        }
        default: {
            break;
        }
    }
}