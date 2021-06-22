/**
 * Created by lsky on 2016. 11. 6..
 */
(function () {

    'use strict';

    function Real20XMLHttpRequest(options, mobile) {
        this._options.battingPanel.alert = options.battingPanel.alert;

        this._options.graphPanel.object = options.graphPanel.object;

        this._options.imagePanel.images = options.imagePanel.images;
        this._options.imagePanel.texts = options.imagePanel.texts;

        this._options.resultPanel = options.resultPanel;

        this._options.statusPanel.object = options.statusPanel.object;

        this._init();
    }

    Real20XMLHttpRequest.prototype._options = {
        ajax: {
            url: 'http://www.titan-330.com/services.aspx',
            rowCount: 50,
            upDate: {
                startDelay: 2000,
                processDelay: 2000,
                object: null
            }
        },
        battingPanel: {
            alert: null
        },
        graphPanel: {
            object: [],
            LastNumber: -1
        },
        gameInfo: {
            newlyIndex: -1,
            newlyTurn: -1,
            newlyStatus: -1,
            unOverBen: 27.5,
            alarmSound: '/include/audio/end_sound.mp3'
        },
        imagePanel: {
            status: null,
            images: null,
            texts: []
        },
        mobile: false,
        resultPanel: null,
        statusPanel: {
            status: false,
            startTime: null,
            endTime: null,
            object: null,
            timeObject: null
        },
        serverTime: []
    };

    Real20XMLHttpRequest.prototype._init = function () {
        this._getData_serverDbTime();
        this._getDate_init();
    };

    Real20XMLHttpRequest.prototype._getDate_init = function () {
        var self = null, url = null, request = null;

        try {
            self = this;
            url = this._options.ajax.url + '?type=lately&count=' + this._options.ajax.rowCount;
            request = this._module_ajaxHttp(true, false, url, 'GET', {}, 'JSON');

            request.done(function (result) {
                if (result.status == "ok") {
                    self._init_panelConfiguration(result);

                    window.setTimeout(function () {
                        self._getData_upDate();
                    }, self._options.ajax.upDate.startDelay);
                } else {
                    console.log(result.message);
                }
            });

            request.fail(function (jqXHR, textStatus) {
                alertPanel(1, '서비스 이용해 불편을 드려서 죄송합니다.<br/>새로 고침 후 이 화면이 보일 경우 관리자에게 문의하여 주세요.');
                console.log("Real20XMLHttpRequest lastRound Error, Request failed: " + textStatus);
            });
        } catch (exp) {
            console.log("Real20XMLHttpRequest getDate_init Error, " + exp.message);
        }
    };

    Real20XMLHttpRequest.prototype._getData_upDate = function () {
        var self = null, url = null, request = null;

        try {
            self = this;
            url = this._options.ajax.url + '?type=lately&count=2';
            request = this._module_ajaxHttp(true, false, url, 'GET', {}, 'JSON');

            request.done(function (result) {
                if (result.status == "ok") {
                    self._init_upDatePanelConfiguration(result);
                } else {
                    console.log(result.message);
                }
            });

            request.fail(function (jqXHR, textStatus) {
                console.log("Real20XMLHttpRequest lastRound Error, Request failed: " + textStatus);
            });
        } catch (exp) {
            console.log("Real20XMLHttpRequest getData_upDate Error, " + exp.message);
        }
    };

    Real20XMLHttpRequest.prototype._getData_serverDbTime = function () {
        var self = null, url = null, request = null;

        try {
            self = this;
            url = this._options.ajax.url + '?type=dbtime';
            request = this._module_ajaxHttp(true, false, url, 'GET', {}, 'JSON');

            request.done(function (result) {
                if (result.status == "ok") {
                    self._options.serverTime[0] = result.data[0].SERV_TYPE1;
                    self._options.serverTime[1] = result.data[0].SERV_TYPE2;
                } else {
                    console.log(result.message);
                }
            });

            request.fail(function (jqXHR, textStatus) {
                console.log("Real20XMLHttpRequest lastRound Error, Request failed: " + textStatus);
            });

            window.setTimeout(function () {
                self._getData_serverDbTime();
            }, 1000);
        } catch (exp) {
            console.log("Real20XMLHttpRequest getData_serverDbTime Error, " + exp.message);
        }
    };

    Real20XMLHttpRequest.prototype._init_panelConfiguration = function (obj) {
        this._options.gameInfo.newlyIndex = obj.data[0].INDEX;
        this._options.gameInfo.newlyStatus = obj.data[0].STATUS;
        this._options.gameInfo.newlyTurn = this._analysis_degreeString(obj.data[0].DEGREE)[4];

        this._imagePanel_init(obj.data[0]);
        this._resultPanel_init(obj.data);
        this._statusPanel_init(obj.data[0]);
        this._graphPanel_init(0, obj.data);
    };

    Real20XMLHttpRequest.prototype._init_upDatePanelConfiguration = function (obj) {
        var self = null;
        var status = null;

        self = this;
        status = this._upDate_dataChangeCheck(obj.data[0]);

        if (status != 0) {
            this._imagePanel_init(obj.data[0]);
            this._resultPanel_upDateHtml(status, obj.data);
            this._statusPanel_init(obj.data[0]);
            this._graphPanel_init(1, obj.data[0]);
        }

        this._options.ajax.upDate.object = window.setTimeout(function () {
            self._getData_upDate();

            console.log('Updating data in progress ...');
        }, this._options.ajax.upDate.processDelay);
    };

    Real20XMLHttpRequest.prototype._upDate_dataChangeCheck = function (obj) {
        if (this._module_isEmpty(obj)) return -1;

        if (Number(this._options.gameInfo.newlyIndex) == Number(obj.INDEX)) {
            if (this._options.gameInfo.newlyStatus == obj.STATUS) {
                return 0;
            } else {
                this._options.gameInfo.newlyStatus = obj.STATUS;

                return 2;
            }
        } else {
            this._options.gameInfo.newlyIndex = obj.INDEX;
            this._options.gameInfo.newlyStatus = obj.STATUS;
            this._options.gameInfo.newlyTurn = this._analysis_degreeString(obj.DEGREE)[4];

            return 1;
        }
    };

    Real20XMLHttpRequest.prototype._imagePanel_init = function (obj) {
        if (obj.STATUS == 5) {
            var endAudio = new Audio(this._options.gameInfo.alarmSound);
            endAudio.play();

            this._imagePanel_showImage(obj);
        } else {
            this._imagePanel_hideImage();
        }
    };

    Real20XMLHttpRequest.prototype._imagePanel_showImage = function (obj) {
        var self = null;
        var resultImage = null, resultData = null, unOverImageSrc = null, unOverImageSrc = null;
        var tempClass = null;

        /*try { */
        if (this._module_isEmpty(this._options.imagePanel.images)) {
            console.log('Real20XMLHttpRequest imagePanel_UpdateHtml Error, image element does not exist.');
            return false;
        }

        if (this._module_isEmpty(this._options.imagePanel.texts)) {
            console.log('Real20XMLHttpRequest imagePanel_UpdateHtml Error, image element does not exist.');
            return false;
        }

        try {
            if (!this._options.imagePanel.status) {
                var $texts = this._options.imagePanel.texts,
                    $images = this._options.imagePanel.images;

                self = this;
                resultData = this._analysis_resultString(obj.RESULT);
                resultImage = this._imagePanel_imageSrcArray(obj.RESULT);
                unOverImageSrc = this._options.gameInfo.unOverBen < resultData[1] ? '/images/over_result.png' : '/images/under_result.png';

                if (resultImage.length == $images.length) {
                    $.each(resultImage, function (key, value) {
                        window.setTimeout(function () {
                            $images.eq(key).attr({'src': "/images/" + value + ".png", 'data-status': '1'});
                        }, key * 500);
                    });
                } else {
                    console.log('The number of image display elements does not match.');
                }

                if ($texts[0].length > 0) {
                    tempClass = resultData[0] == '홀' ? 'txt_hol' : 'txt_zack';

                    $texts[0].children('li').eq(0).removeClass('colorchange').addClass(tempClass).html(resultData[0] + '<small>/' + resultData[4] + '</small>');
                }
                if ($texts[1].length > 0) {
                    $texts[1].attr({'src': unOverImageSrc}).show();
                }
                if ($texts[2].length > 0) {
                    $texts[2].children('li').eq(0).text(resultData[3]);
                }

                switch (resultData[2]) {
                    case '리': {
                        if ($texts[0].children('li').eq(1).length > 0) {
                            $texts[0].children('li').eq(1).text('승').show();
                        }

                        break;
                    }
                    case '얼': {
                        if ($texts[2].children('li').eq(1).length > 0) {
                            $texts[2].children('li').eq(1).text('승').show();
                        }

                        break;
                    }
                    case '무': {
                        if ($texts[0].children('li').eq(1).length > 0 || this._options.imagePanel.texts[2].children('li').eq(1).length > 0) {
                            $texts[0].children('li').eq(1).text('무').show();
                            $texts[2].children('li').eq(1).text('무').show();
                        }

                        break;
                    }
                }

                this._options.imagePanel.status = true;
            }
        } catch (exp) {
            console.log("Real20XMLHttpRequest imagePanel_showImage Error, " + exp.message);
        }
    };

    Real20XMLHttpRequest.prototype._imagePanel_hideImage = function (obj) {
        var self = null;

        self = this;

        try {
            if (this._options.imagePanel.status == null || this._options.imagePanel.status) {
                var $texts = this._options.imagePanel.texts,
                    $images = this._options.imagePanel.images;

                $.each($images, function (key, value) {
                    window.setTimeout(function () {
                        $images.eq(key).attr({'src': "/images/00_back.png", 'data-status': '0'});
                    }, key * 500);
                });

                if ($texts[0].length > 0) {
                    /* tempClass = resultData[0] == '홀' ? 'txt_hol' : 'txt_zack'; */
                    $texts[0].children('li').eq(0).addClass('colorchange').removeClass('txt_hol').removeClass('txt_zack').text('?');
                    $texts[0].children('li').eq(1).hide();
                }

                if ($texts[1].length > 0) {
                    $texts[1].hide();
                }

                if ($texts[2].length > 0) {
                    $texts[2].children('li').eq(0).text('?');
                    $texts[2].children('li').eq(1).hide();
                }

                this._options.imagePanel.status = false;
            }
        } catch (exp) {
            console.log("Real20XMLHttpRequest imagePanel_hideImage Error, " + exp.message);
        }
    };

    Real20XMLHttpRequest.prototype._imagePanel_imageSrcArray = function (obj) {
        var _array = [], resultSplit = null;

        try {
            resultSplit = obj.split(",");

            /* 정상적인 데이터 값이 아닐 경우 */
            if (resultSplit.length != 11) return null;

            _array[0] = this._imagePanel_stringMerge(resultSplit[1], resultSplit[2]);
            _array[1] = this._imagePanel_stringMerge(resultSplit[3], resultSplit[4]);
            _array[2] = this._imagePanel_stringMerge(resultSplit[5], resultSplit[6]);
            _array[3] = this._imagePanel_stringMerge(resultSplit[7], resultSplit[8]);
            _array[4] = this._imagePanel_stringMerge(resultSplit[9], resultSplit[10]);

            return _array;
        } catch (exp) {
            console.log("Real20XMLHttpRequest imagePanel_imageSrcArray Error, " + exp.message);

            return _array;
        }
    };

    Real20XMLHttpRequest.prototype._imagePanel_stringMerge = function (a, b) {
        try {
            if (this._module_isEmpty(a) || this._module_isEmpty(b)) {
                console.log("Real20XMLHttpRequest stringMerge Error, " + a + ' / ' + b);
                return '';
            } else {
                if (a != '' || b != '') {
                    a = a.length == 1 ? '0' + a : a;
                    b = b.length == 1 ? '0' + b : b;

                    return a + '_' + b;
                } else {
                    console.log("Real20XMLHttpRequest stringMerge Error, " + a + ' / ' + b);
                }
            }
        } catch (exp) {
            console.log("Real20XMLHttpRequest imagePanel_stringMerge Error, " + exp.message);

            return '';
        }
    };

    Real20XMLHttpRequest.prototype._resultPanel_init = function (obj) {
        var self = null;

        try {
            if (this._module_isEmpty(this._options.resultPanel)) {
                console.log('Real20XMLHttpRequest resultPanel_init Error, result element does not exist.');
                return false;
            }

            self = this;

            this._resultPanel_reset();

            $.each(obj, function (key, value) {
                self._resultPanel_htmlConfiguration(value.STATUS, value);
            });
        } catch (exp) {
            console.log("Real20XMLHttpRequest resultPanel_init Error Error, " + exp.message);
        }
    };

    Real20XMLHttpRequest.prototype._resultPanel_reset = function (obj) {
        this._options.resultPanel.find('li').remove();
    };

    Real20XMLHttpRequest.prototype._resultPanel_htmlConfiguration = function (status, obj) {
        var degreeAnalysis = null, resultAnalysis = null, htmlString = null;

        try {
            if (this._module_isInt(status)) {
                degreeAnalysis = this._analysis_degreeString(obj.DEGREE);
                resultAnalysis = this._analysis_resultString(obj.RESULT);
                htmlString = (this._resultPanel_degreeHtmlString(degreeAnalysis) + this._resultPanel_resultHtmlString(status, resultAnalysis));

                $('<li/>')
                    .addClass('news-item')
                    .html(htmlString)
                    .attr({"data-index": obj.INDEX, 'data-status': status})
                    .appendTo(this._options.resultPanel);
            }
            else {
                console.log('Real20XMLHttpRequest resultPanel_htmlConfiguration Error, Can not be configured because it is not a normal status value during html configuration. [' + obj.INDEX + ']');
            }
        } catch (exp) {
            console.log("Real20XMLHttpRequest resultPanel_htmlConfiguration Error, " + exp.message);
        }
    };

    Real20XMLHttpRequest.prototype._resultPanel_upDateHtml = function (status, obj) {
        var $result = null, $resultLi = null;
        var degreeDate = null, resultData = null, htmlString = null;

        try {
            $result = this._options.resultPanel;
            $resultLi = $result.children('li');

            switch (status) {
                case 2: {
                    resultData = this._analysis_resultString(obj[0].RESULT);
                    htmlString = this._resultPanel_resultHtmlString(Number(obj[0].STATUS), resultData);

                    $resultLi.eq(0).attr({'data-status': obj[0].STATUS}).find('.result_data').remove();
                    $resultLi.eq(0).append(htmlString);

                    break;
                }
                case 1: {
                    resultData = this._analysis_resultString(obj[1].RESULT);
                    htmlString = this._resultPanel_resultHtmlString(Number(obj[1].STATUS), resultData);

                    $result.children('li').eq(0).attr({'data-status': obj[1].STATUS}).find('.result_data').remove();
                    $result.children('li').eq(0).append(htmlString);

                    degreeDate = this._analysis_degreeString(obj[0].DEGREE);
                    resultData = this._analysis_resultString(obj[0].RESULT);
                    htmlString = this._resultPanel_degreeHtmlString(degreeDate) + this._resultPanel_resultHtmlString(Number(obj[0].STATUS), resultData);

                    $('<li/>')
                        .addClass('news-item')
                        .html(htmlString)
                        .attr({"data-index": obj[0].INDEX, 'data-status': obj[0].STATUS})
                        .prependTo($result);

                    $resultLi.eq(Number($result.children('li').size() - 1)).remove();

                    //console.log()
                    break;
                }
                default: {
                    console.log('An error occurred while constructing the result.');
                    break;
                }
            }
        } catch (exp) {
            console.log("Real20XMLHttpRequest resultPanel_upDateHtml Error, " + exp.message);
        }
    };

    Real20XMLHttpRequest.prototype._resultPanel_degreeHtmlString = function (date) {
        var _return = '';

        try {
            _return = '<div class="result_date">';

            if (date == null) {
                _return += '?월 ?일 - ??';
            } else {
                _return += date[1] + '월' + date[2] + '일-' + date[4];
            }

            _return += '</div>';

            return _return;

        } catch (exp) {
            console.log("Real20XMLHttpRequest lastRound_htmlResultConfiguration Error, " + exp.message);

            return _return;
        }
    };

    Real20XMLHttpRequest.prototype._resultPanel_resultHtmlString = function (status, result) {
        var _return = '';

        try {
            switch (Number(status)) {
                case 1: {
                    /* 배팅 시작 */
                    _return += '<div class="result_data">';
                    _return += '    진 행 중';
                    _return += '</div>';

                    break;
                }
                case 2: {
                    /* 배팅 마감 */
                    _return += '<div class="result_data">';
                    _return += '    진 행 중(마감)';
                    _return += '</div>';

                    break;
                }
                case 3: {
                    /* 배팅 중지 */
                    _return += '<div class="result_data">';
                    _return += '    배팅 중지';
                    _return += '</div>';

                    break;
                }
                case 4: {
                    /* 배팅 재 시작 */
                    _return += '<div class="result_data">';
                    _return += '    배팅 재 시작';
                    _return += '</div>';

                    break;
                }
                case 5: {
                    /* 회차 완료 */
                    if (this._module_isEmpty(result)) {
                        _return += '<div class="result_data">';
                        _return += '    데이터 없음';
                        _return += '</div>';
                    } else {
                        var oneGameClass = this._resultPanel_oneGameCssClass(result[0]),
                            twoGame = this._options.gameInfo.unOverBen < result[1] ? 'over' : 'under',
                            threeGameClass = this._resultPanel_threeGameCssClass(result[2]);

                        _return += '<div class="result_data">';
                        _return += '    <div class="circle circle--one ' + oneGameClass + ' ' + threeGameClass[0] + '">';
                        _return += '        <p>' + result[0] + '<small>/' + result[4] + '</small></p>';
                        _return += '        <div>' + threeGameClass[1] + '</div>';
                        _return += '    </div>';
                        _return += '    <div class="circle circle--two ' + twoGame + '">';
                        _return += '        <p>' + result[1] + '</p>';
                        _return += '    </div>';
                        _return += '    <div class="circle circle--three ' + threeGameClass[2] + '">';
                        _return += '        <p>' + result[3] + '</p>';
                        _return += '        <div>' + threeGameClass[3] + '</div>';
                        _return += '    </div>';
                        _return += '</div>';
                    }

                    break;
                }
                case 6: {
                    /* 무효 게임 */
                    _return += '<div class="result_data">';
                    _return += '    무효 게임';
                    _return += '</div>';
                    break;
                }
                default: {
                    _return += '<div class="result_data">';
                    _return += '    알수 없음';
                    _return += '</div>';
                    break;
                }
            }

            return _return;
        } catch (exp) {
            console.log("Real20XMLHttpRequest resultPanel_resultHtmlString Error, " + exp.message);

            return _return;
        }
    };

    Real20XMLHttpRequest.prototype._resultPanel_oneGameCssClass = function (obj) {
        if (typeof obj === 'undefined' || obj == null || obj == "") return '';

        var _return = '';

        try {
            switch (obj) {
                case "짝": {
                    _return = "red";
                    break;
                }
                case "홀": {
                    _return = "blue";
                    break;
                }
            }

            return _return;
        } catch (exp) {
            console.log("Real20XMLHttpRequest oneGameCssClass Error, " + exp.message);

            return _return;
        }
    };

    Real20XMLHttpRequest.prototype._resultPanel_threeGameCssClass = function (obj) {
        if (typeof obj === 'undefined' || obj == null || obj == "") return [];

        var _return = [];

        try {
            switch (obj) {
                case "리": {
                    _return[0] = 'sure';
                    _return[1] = '승';
                    _return[2] = '';
                    _return[3] = '';

                    break;
                }
                case "얼": {
                    _return[0] = '';
                    _return[1] = '';
                    _return[2] = 'sure';
                    _return[3] = '승';

                    break;
                }
                case "무": {
                    _return[0] = 'sure';
                    _return[1] = '무';
                    _return[2] = 'sure';
                    _return[3] = '무';

                    break;
                }
            }

            return _return;
        } catch (exp) {
            console.log("Real20XMLHttpRequest threeGameCssClass Error, " + exp.message);

            return _return;
        }
    };

    Real20XMLHttpRequest.prototype._statusPanel_init = function (obj) {
        var startDate = null, endDate = null;

        /* 년 월 일 시간 분 초 70000 (70초) */
        startDate = this._statusPanel_converDbDate(obj.REG_TIME, '-');
        endDate = this._statusPanel_converDbDate(obj.LAST_TIME, '-');

        if (this._options.statusPanel.endTime == null || this._options.statusPanel.endTime != endDate.getTime()) {
            this._options.statusPanel.startTime = startDate.getTime();
            this._options.statusPanel.endTime = endDate.getTime();
        }

        if (Number(obj.STATUS) == 5) {
            this._battingPanel_alertShowHide(1, '지금은 베팅을 하실 수 없습니다.');
            this._statusPanel_statusMessage(1, obj);
        } else if (Number(obj.STATUS) == 3) {
            this._battingPanel_alertShowHide(1, '지금은 베팅을 하실 수 없습니다.');
            this._statusPanel_statusMessage(2, obj);
        } else if (Number(obj.STATUS) == 6) {
            this._battingPanel_alertShowHide(1, '지금은 베팅을 하실 수 없습니다.');
            this._statusPanel_statusMessage(2, obj);
        } else {
            this._statusPanel_battingProcessTime(startDate.getTime(), endDate.getTime(), obj);
        }
    };

    Real20XMLHttpRequest.prototype._statusPanel_battingProcessTime = function (startTime, endTime, obj) {
        var self = null;
        var htmlString = null;
        var days, hours, minutes, seconds;

        self = this;

        var serverTime = this._statusPanel_converDbDate(this._options.serverTime[1], '-');

        if (serverTime > endTime) {
            if (this._options.statusPanel.status) {
                if (this._options.statusPanel.timeObject != null) {
                    window.clearInterval(self._options.statusPanel.timeObject);
                    this._options.statusPanel.timeObject = null;
                }

                this._options.statusPanel.status = false;
            }

            self._battingPanel_alertShowHide(1, '지금은 베팅을 하실 수 없습니다.');
            self._statusPanel_statusMessage(4, obj);
        } else {
            if (!this._options.statusPanel.status) {
                if (this._options.statusPanel.timeObject != null) {
                    window.clearInterval(self._options.statusPanel.timeObject);
                    this._options.statusPanel.timeObject = null;
                }

                self._battingPanel_alertShowHide(0, null);
                self._statusPanel_statusMessage(3, obj);

                var strMinutes = null, strSeconds = null;

                this._options.statusPanel.timeObject = window.setInterval(function () {
                    /* var current_date = new Date().getTime(); */
                    var current_date = self._statusPanel_converDbDate(self._options.serverTime[1], '-').getTime();
                    var seconds_left = (endTime - current_date) / 1000;

                    if (seconds_left > 0) {

                        if (seconds_left <= 5) {
                            self._battingPanel_alertShowHide(1, '지금은 베팅을 하실 수 없습니다.');
                        }

                        /* days = parseInt(seconds_left / 86400); */
                        seconds_left = seconds_left % 86400;

                        /* hours = parseInt(seconds_left / 3600); */
                        seconds_left = seconds_left % 3600;

                        /* minutes = parseInt(seconds_left / 60); */
                        /* seconds = parseInt(seconds_left % 60); */

                        /* $(el).html(days + "d " + hours + "h " + minutes + "m " + seconds + "s "); */
                        /* strMinutes = minutes != 0 ? minutes + '분' : ''; */
                        strSeconds = seconds_left != 0 ? seconds_left + '초' : '';

                        $(self._options.statusPanel.object.find('#__countdownTimer')).html(strSeconds);
                    } else {
                        window.clearInterval(self._options.statusPanel.timeObject);
                        self._options.statusPanel.timeObject = null;

                        self._battingPanel_alertShowHide(1, '지금은 베팅을 하실 수 없습니다.');
                        self._statusPanel_statusMessage(4, obj);

                        self._options.statusPanel.status = false;
                    }
                }, 1000);

                this._options.statusPanel.status = true;
            }
        }
    };

    Real20XMLHttpRequest.prototype._statusPanel_statusMessage = function (status, obj) {
        var _return = null, degreeDate = null, resultData = null;

        degreeDate = this._analysis_degreeString(obj.DEGREE);

        switch (Number(status)) {
            case 1: {
                resultData = this._analysis_resultString(obj.RESULT);

                _return = '<h3>';
                _return += degreeDate[1] + '월 ' + degreeDate[2] + ' 일 - ' + ' <span class="aureolin">[' + Number(Number(degreeDate[4]) + 1) + ' 회차]</span> ';
                _return += '배팅이 잠시 후 시작합니다.';
                _return += '<br/>';
                _return += '<span class="size14 white"><span class="size14 chrome">[' + Number(degreeDate[4]) + ' 회차]</span> ';
                _return += '결과는 ';

                if (resultData[0] == '짝') {
                    _return += '<span class="size14 crimson">';
                } else if (resultData[0] == '홀') {
                    _return += '<span class="size14 blue">';
                }

                _return += '[ ' + resultData[0] + ' ]</span> 입니다.</span>';
                _return += '</h3>';

                break;
            }
            case 2: {
                _return = '<h3>';
                _return += degreeDate[1] + '월 ' + degreeDate[2] + ' 일 - ' + ' <span class="aureolin">[' + Number(degreeDate[4]) + ' 회차]</span> 중지! ';
                _return += ' 배팅남은 시간 : <span id="__countdownTimer"></span> ';
                _return += '<br/>운영상의 문제로 배팅이 잠시 중지되었습니다.';
                _return += '</h3>';

                break;
            }
            case 3: {
                _return = '<h3 class="no">';
                _return += degreeDate[1] + '월 ' + degreeDate[2] + '일 - ' + ' <span class="aureolin">[' + Number(degreeDate[4]) + ' 회차]</span> ';
                _return += ' 배팅남은 시간 : <span id="__countdownTimer" class="chrome"></span> ';
                _return += '</h3>';

                break;
            }
            case 4: {
                var endTime = this._statusPanel_converDbDate(obj.LAST_TIME, '-');

                _return = '<h3>';
                _return += degreeDate[1] + '월 ' + degreeDate[2] + '일 - ' + ' <span class="aureolin">[' + Number(degreeDate[4]) + ' 회차]</span>';
                _return += ' 결과오픈 <span class="blink">대기중</span> <span class="size14 cyan">(배팅종료 시간 : ' + this._module_timeFormat(endTime) + ')</span>';
                _return += '<br/><span class="size12 white">현재 20장 게임 배팅 중임으로 잠시 후 미니게임 결과 오픈, 미니게임 결과는 ';
                _return += '배팅 종료시간으로부터 약 <span class="size12  awesome">1분 후</span> 오픈</span>';
                _return += '</h3>';

                break;
            }
            default: {
                _return = "알수 없음";
            }
        }

        $(this._options.statusPanel.object).html(_return);
    };

    Real20XMLHttpRequest.prototype._statusPanel_converDbDate = function (obj, spl) {
        try {
            var objArray = obj.split(spl);

            return new Date(objArray[0], (objArray[1] - 1), objArray[2], objArray[3], objArray[4], objArray[5]);
        } catch (exp) {
            console.log("Real20XMLHttpRequest statusPanel_converDbDate Error, " + exp.message);
        }
    };

    Real20XMLHttpRequest.prototype._battingPanel_alertShowHide = function (status, msg) {
        if (Number(status) == 1) {
            $(this._options.battingPanel.alert).show().html(msg);
        } else {
            $(this._options.battingPanel.alert).hide();
        }
    };

    Real20XMLHttpRequest.prototype._graphPanel_init = function (status, obj) {
        var self = null, $tables = [];

        /*try { */
        if (this._module_isEmpty(this._options.graphPanel.object)) {
            console.log('Real20XMLHttpRequest graphPanel_init Error, graphPanel element does not exist.');
            return false;
        }

        self = this;

        $tables[0] = $(this._options.graphPanel.object[0]).children('thead').children('tr');
        $tables[1] = $(this._options.graphPanel.object[0]).children('tbody').children('tr');
        $tables[2] = $(this._options.graphPanel.object[1]).children('thead').children('tr');
        $tables[3] = $(this._options.graphPanel.object[1]).children('tbody').children('tr');

        switch (Number(status)) {
            case 0: {
                this._graphPanel_reset();

                $.each(obj, function (key, value) {
                    if (value.STATUS == 5) {
                        if (self._options.graphPanel.LastNumber == -1) self._options.graphPanel.LastNumber = obj.INDEX = value.INDEX;
                        self._graphPanel_htmlConfiguration(value, $tables);
                    }
                });
                break;
            }
            case 1: {
                if (!this._graphPanel_updaeFiltering(obj)) return false;

                self._graphPanel_upDateHtmlConfiguration(obj, $tables);

                break;
            }
        }
        /*
         } catch (exp) {
         console.log("Real20XMLHttpRequest resultPanel_init Error Error, " + exp.message);
         }
         */
    };

    Real20XMLHttpRequest.prototype._graphPanel_updaeFiltering = function (obj) {
        if (this._module_isEmpty(obj)) return false;

        if (obj.STATUS != 5) return false;

        if (this._options.graphPanel.LastNumber == obj.INDEX) return false;

        this._options.graphPanel.LastNumber = obj.INDEX;

        return true;
    };

    Real20XMLHttpRequest.prototype._graphPanel_htmlConfiguration = function (obj, el) {
        var degreeAnalysis = null, resultAnalysis = null, tableCss = [], htmlString = null;

        try {
            if (this._module_isEmpty(obj.DEGREE)) return false;
            if (this._module_isEmpty(obj.RESULT)) return false;

            degreeAnalysis = this._analysis_degreeString(obj.DEGREE);
            resultAnalysis = this._analysis_resultString(obj.RESULT);
            tableCss = this._graphPanel_htmlCssConfiguration(resultAnalysis);

            if (degreeAnalysis == null) return false;
            if (resultAnalysis == null) return false;

            var $table1Th = $(el[0]).children('th');
            var $table1Td = $(el[1]).children('td');

            if (Number(tableCss[0]) == Number($table1Th.eq(($table1Th.size() - 1)).attr('data-type'))) {
                htmlString = ' <div class="' + tableCss[2] + '">';
                htmlString += '     <span class="tx"><em class="num">' + degreeAnalysis[4] + '</em></span>';
                htmlString += '     <div class="' + tableCss[3] + '">' + resultAnalysis[2] + '</div>';
                htmlString += ' </div>';

                /*
                if ($table1Td.eq(($table1Th.size() - 1)).children('div').size() > 6) {
                    $table1Td.eq(($table1Th.size() - 1)).children('div').eq($table1Td.eq(($table1Th.size() - 1)).children('div') - 1).remove();
                }
                */

                $('<div/>')
                    .html(htmlString)
                    .attr({'valign': 'top'})
                    .appendTo($table1Td.eq(($table1Td.size() - 1)));

            } else {
                $('<th/>')
                    .addClass(tableCss[1])
                    .html(resultAnalysis[0])
                    .attr({'data-type': tableCss[0]})
                    .appendTo(el[0]);

                htmlString = ' <div class="' + tableCss[2] + '">';
                htmlString += '     <span class="tx"><em class="num">' + degreeAnalysis[4] + '</em></span>';
                htmlString += '     <div class="' + tableCss[3] + '">' + resultAnalysis[2] + '</div>';
                htmlString += ' </div>';

                $('<td/>')
                    .html(htmlString)
                    .attr({'valign': 'top'})
                    .appendTo(el[1]);
            }

            var $table2Th = $(el[2]).children('th');
            var $table2Td = $(el[3]).children('td');

            if (Number(tableCss[4]) == Number($table2Th.eq(($table2Th.size() - 1)).attr('data-type'))) {
                htmlString = ' <div class="' + tableCss[5] + '">';
                htmlString += '     <span class="tx"><em class="num">' + degreeAnalysis[4] + '</em></span>';
                htmlString += '     <div class="g_s_txt_l">' + resultAnalysis[3] + '</div>';
                htmlString += ' </div>';

                if ($table2Td.children('div').size() > 6) {
                    $table2Td.children('div').eq($table2Td.children('div') - 1).remove();
                }
                $('<div/>')
                    .html(htmlString)
                    .attr({'valign': 'top'})
                    .appendTo($table2Td.eq(($table2Td.size() - 1)));

            } else {
                $('<th/>')
                    .addClass(tableCss[1])
                    .html(this._options.gameInfo.unOverBen < resultAnalysis[1] ? '오' : '언')
                    .attr({'data-type': tableCss[4]})
                    .appendTo(el[2]);

                htmlString = ' <div class="' + tableCss[5] + '">';
                htmlString += '     <span class="tx"><em class="num">' + degreeAnalysis[4] + '</em></span>';
                htmlString += '     <div class="g_s_txt_l">' + resultAnalysis[3] + '</div>';
                htmlString += ' </div>';

                $('<td/>')
                    .html(htmlString)
                    .attr({'valign': 'top'})
                    .appendTo(el[3]);
            }

        } catch (exp) {
            console.log("Real20XMLHttpRequest resultPanel_htmlConfiguration Error, " + exp.message);
        }
    };

    Real20XMLHttpRequest.prototype._graphPanel_upDateHtmlConfiguration = function (obj, el) {
        var degreeAnalysis = null, resultAnalysis = null, tableCss = [], htmlString = null;

        try {
            degreeAnalysis = this._analysis_degreeString(obj.DEGREE);
            resultAnalysis = this._analysis_resultString(obj.RESULT);
            tableCss = this._graphPanel_htmlCssConfiguration(resultAnalysis);

            if (degreeAnalysis == null) return false;
            if (resultAnalysis == null) return false;

            var $table1Th = $(el[0]).children('th');
            var $table1Td = $(el[1]).children('td');

            if (Number(tableCss[0]) == Number($table1Th.eq(0).attr('data-type'))) {
                htmlString = ' <div class="' + tableCss[2] + '">';
                htmlString += '     <span class="tx"><em class="num">' + degreeAnalysis[4] + '</em></span>';
                htmlString += '     <div class="' + tableCss[3] + '">' + resultAnalysis[2] + '</div>';
                htmlString += ' </div>';

                if ($table1Td.children('div').size() > 7) {
                    $table1Td.children('div').eq($table1Td.children('div') - 1).remove();
                }
                $('<div/>')
                    .html(htmlString)
                    .attr({'valign': 'top'})
                    .prependTo($table1Td.eq(0));

            } else {
                $('<th/>')
                    .addClass(tableCss[1])
                    .html(resultAnalysis[0])
                    .attr({'data-type': tableCss[0]})
                    .prependTo(el[0]);

                htmlString = ' <div class="' + tableCss[2] + '">';
                htmlString += '     <span class="tx"><em class="num">' + degreeAnalysis[4] + '</em></span>';
                htmlString += '     <div class="' + tableCss[3] + '">' + resultAnalysis[2] + '</div>';
                htmlString += ' </div>';

                $('<td/>')
                    .html(htmlString)
                    .attr({'valign': 'top'})
                    .prependTo(el[1]);
            }

            var $table2Th = $(el[2]).children('th');
            var $table2Td = $(el[3]).children('td');

            if (Number(tableCss[4]) == Number($table2Th.eq(0).attr('data-type'))) {
                htmlString = ' <div class="' + tableCss[5] + '">';
                htmlString += '     <span class="tx"><em class="num">' + degreeAnalysis[4] + '</em></span>';
                htmlString += '     <div class="g_s_txt_l">' + resultAnalysis[3] + '</div>';
                htmlString += ' </div>';

                if ($table2Td.children('div').size() > 7) {
                    $table2Td.children('div').eq($table2Td.children('div') - 1).remove();
                }
                $('<div/>')
                    .html(htmlString)
                    .attr({'valign': 'top'})
                    .prependTo($table2Td.eq(0));

            } else {
                $('<th/>')
                    .addClass(tableCss[1])
                    .html(this._options.gameInfo.unOverBen < resultAnalysis[1] ? '오' : '언')
                    .attr({'data-type': tableCss[4]})
                    .prependTo(el[2]);

                htmlString = ' <div class="' + tableCss[5] + '">';
                htmlString += '     <span class="tx"><em class="num">' + degreeAnalysis[4] + '</em></span>';
                htmlString += '     <div class="g_s_txt_l">' + resultAnalysis[3] + '</div>';
                htmlString += ' </div>';

                $('<td/>')
                    .html(htmlString)
                    .attr({'valign': 'top'})
                    .prependTo(el[3]);
            }

        } catch (exp) {
            console.log("Real20XMLHttpRequest resultPanel_htmlConfiguration Error, " + exp.message);
        }
    };

    Real20XMLHttpRequest.prototype._graphPanel_htmlCssConfiguration = function (resultAnalysis) {
        var _return = [];

        if (resultAnalysis[0] == '짝') {
            _return[0] = 0;
            _return[1] = 'col_odd';
            _return[2] = 'circle_r';
        } else {
            _return[0] = 1;
            _return[1] = 'col_even';
            _return[2] = 'circle_b';
        }

        if (Number(resultAnalysis[2]) == '리') {
            _return[3] = 'b_s_txt_l';
        } else if (resultAnalysis[2] == '얼') {
            _return[3] = 'b_s_txt_r';
        } else {
            _return[3] = 'b_s_txt_l';
        }

        if (this._options.gameInfo.unOverBen < resultAnalysis[1]) {
            _return[4] = 0;
            _return[5] = 'circle_r';
        } else {
            _return[4] = 1;
            _return[5] = 'circle_b';
        }

        return _return;
    };

    Real20XMLHttpRequest.prototype._graphPanel_reset = function (obj) {
        $(this._options.graphPanel.object[0]).children('thead').children('tr').find('th').remove();
        $(this._options.graphPanel.object[0]).children('tbody').children('tr').find('td').remove();
        $(this._options.graphPanel.object[1]).children('thead').children('tr').find('th').remove();
        $(this._options.graphPanel.object[1]).children('tbody').children('tr').find('td').remove();
    };

    Real20XMLHttpRequest.prototype._analysis_degreeString = function (obj) {
        /* 년, 월, 일, 시간, 회차 */
        var _array = [];

        try {
            if (this._module_isEmpty(obj)) return null;

            if (obj.length < 8) return null;

            _array[0] = obj.substring(0, 2);
            _array[1] = obj.substring(2, 4);
            _array[2] = obj.substring(4, 6);
            _array[3] = obj.substring(6, 8);
            _array[4] = obj.substring(8, obj.length);

            return _array;
        } catch (exp) {
            console.log("Real20XMLHttpRequest analysis_degreeString Error, " + exp.message);

            return null;
        }
    };

    Real20XMLHttpRequest.prototype._analysis_resultInt = function (obj) {
        var _array = [], resultSplit = null;

        try {
            if (this._module_isEmpty(obj)) return null;

            resultSplit = obj.split(",");

            /* 정상적인 데이터 값이 아닐 경우 */
            if (resultSplit.length != 11) return null;

            /* one game -  true : 짝 , false : 홀 */
            if (this._module_oddFilter(Number(resultSplit[1]))) {
                _array[0] = 0;
            } else {
                _array[0] = 1;
            }

            /* two game - 0 : over , 1 : under
             var twoSum = Number(resultSplit[1]) + Number(resultSplit[3]) + Number(resultSplit[5]) + Number(resultSplit[7]) + Number(resultSplit[9]);
             this._options.default.unoverBen < twoSum ? _array[1] = 0 : _array[1] = 1;
             */
            _array[1] = Number(resultSplit[1]) + Number(resultSplit[3]) + Number(resultSplit[5]) + Number(resultSplit[7]) + Number(resultSplit[9]);

            /* three game - 1 : 승(리) , 2 : 승(얼) , 0 : 무 */
            if (Number(resultSplit[1]) > Number(resultSplit[9])) {
                _array[2] = 1;
            } else if (Number(resultSplit[1]) < Number(resultSplit[9])) {
                _array[2] = 2;
            } else if (Number(resultSplit[1]) == Number(resultSplit[9])) {
                _array[2] = 0;
            }
            /* four game -1,3 = 1 마지막 번호 1번 */
            _array[3] = Number(resultSplit[9]);

            /* 첫장 번호 */
            _array[4] = Number(resultSplit[1]);

            return _array;
        } catch (exp) {
            console.log("Real20XMLHttpRequest resultIntAnalysis Error, " + exp.message);

            return _array;
        }
    };

    Real20XMLHttpRequest.prototype._analysis_resultString = function (obj) {
        var _array = [], resultSplit = null;

        try {
            if (this._module_isEmpty(obj)) return null;

            resultSplit = obj.split(",");

            /* 정상적인 데이터 값이 아닐 경우 */
            if (resultSplit.length != 11) return null;

            /* one game -  true : 짝 , false : 홀 */
            if (this._module_oddFilter(Number(resultSplit[1]))) {
                _array[0] = '짝';
            } else {
                _array[0] = '홀';
            }

            /* two game - 0 : over , 1 : under */
            /* this._options.default.unoverBen < twoSum ? _array[1] = 0 : _array[1] = 1; */
            _array[1] = Number(resultSplit[1]) + Number(resultSplit[3]) + Number(resultSplit[5]) + Number(resultSplit[7]) + Number(resultSplit[9]);

            /* three game - 0 : 승(리) , 1 : 승(얼) , 2 : 무 */
            if (Number(resultSplit[1]) > Number(resultSplit[9])) {
                _array[2] = '리';
            } else if (Number(resultSplit[1]) < Number(resultSplit[9])) {
                _array[2] = '얼';
            } else if (Number(resultSplit[1]) == Number(resultSplit[9])) {
                _array[2] = '무';
            }

            /* four game 마지막장 번호  */
            _array[3] = Number(resultSplit[9]);

            /* 첫장 번호 */
            _array[4] = Number(resultSplit[1]);

            return _array;
        } catch (exp) {
            console.log("Real20XMLHttpRequest analysis_resultString Error, " + exp.message);

            return null;
        }
    };

    Real20XMLHttpRequest.prototype._module_isInt = function (value) {
        return !isNaN(value) && (function (x) {
                return (x | 0) === x;
            })(parseFloat(value))
    };

    Real20XMLHttpRequest.prototype._module_isJson = function (value) {
        try {
            JSON.parse(result);
            return true;
        } catch (e) {
            return false;
        }

    };

    Real20XMLHttpRequest.prototype._module_isEmpty = function (obj) {
        if (obj == "" || obj == null || obj == undefined || ( obj != null && typeof obj == "object" && !Object.keys(obj).length )) {
            return true
        } else {
            return false
        }
    };

    Real20XMLHttpRequest.prototype._module_oddFilter = function (obj) {
        var _return = null;

        try {
            if (obj % 2 == 0) {
                _return = true;
            } else if (obj % 2 == 1) {
                _return = false;
            }

            return _return;
        } catch (exp) {
            console.log("Real20XMLHttpRequest oddFilter Error, " + exp.message);

            return _return;
        }
    };

    Real20XMLHttpRequest.prototype._module_timeFormat = function (d) {
        var hours = format_two_digits(d.getHours());
        var minutes = format_two_digits(d.getMinutes());
        var seconds = format_two_digits(d.getSeconds());

        function format_two_digits(n) {
            return n < 10 ? '0' + n : n;
        }

        return hours + "시 " + minutes + "분 " + seconds + '초'
    };

    Real20XMLHttpRequest.prototype._module_ajaxHttp = function (async, cache, url, method, data, type) {
        return $.ajax({
            async: async,
            url: url,
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

    window.Real20XMLHttpRequest = Real20XMLHttpRequest;

})
(window);