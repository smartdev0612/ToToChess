(function($) {

    $.fn.extend({

        addTemporaryClass: function(className, duration) {
            var elements = this;
            setTimeout(function() {
                elements.removeClass(className);
            }, duration);

            return this.each(function() {
                $(this).addClass(className);
            });
        }
    });

})(jQuery);
var arBetInfo = new Array;
var arBonus = new Array;
var nBetMax = 0;
var nBetMin = 0;
var nPrizeMax = 0;
var nPrizeMin = 0;
var nFolderMin = 0;
var nFolderMax = 0;
var nRoundNum = "";
var nBetLimitMax = 0;
var nSingleMax = 0;
var nAxis = 0;
var nCrossBet = 0;
var bBetting = false;


var app = angular.module('app', ['angularMoment', 'ui.bootstrap', 'angularSpinner']);


app.config(['usSpinnerConfigProvider', '$httpProvider', function(usSpinnerConfigProvider, $httpProvider) {
    usSpinnerConfigProvider.setDefaults({ color: '#fff' });

    $httpProvider.interceptors.push('HttpInterceptor');
}]);

app.factory('HttpInterceptor', ['$q', 'usSpinnerService', function($q, usSpinnerService) {
    return {
        'request': function(config) {
            usSpinnerService.spin('spinner-1');
            return config || $q.when(config);
        },
        'requestError': function(rejection) {
            usSpinnerService.stop('spinner-1');
            return $q.reject(rejection);
        },
        'response': function(response) {
            usSpinnerService.stop('spinner-1');
            return response || $q.when(response);
        },
        'responseError': function(rejection) {
            usSpinnerService.stop('spinner-1');
            return $q.reject(rejection);
        }
    };
}]);



app.controller('SportsController', ['$scope', '$http', 'usSpinnerService', 'orderByFilter',
    function($scope, $http, usSpinnerService, orderBy) {
        var connection = $.hubConnection();
        var proxy = connection.createHubProxy('sportsHub');
        var hub = $.connection.sportsHub;

        $scope.searchText = "";
        $scope.Details = {};
        $scope.DetailsLoading = {};
        $scope.DetailsActive = {};
        $scope.CategoryActive = {};
        $scope.RegionActive = {};
        $scope.OSC_IDX = -1;
        $scope.SearchOSC_IDX = -1;
        $scope.OSC_NAME = "오늘의 경기";
        $scope.OSC_IMAGE = "";
        $scope.TodayActive = false;
        $scope.TodayCategoryActive = {};
        $scope.arBetInfo = new Array;
        $scope.lqCrossCfg = {};

        $scope.fnCartDel = function(nOSD_IDX) {
            if (nOSD_IDX !== "") {

                $('li[OSD_IDX="' + nOSD_IDX + '"]').attr('onoff', 'off').removeClass('active');
                $('div[OSD_IDX="' + nOSD_IDX + '"]').attr('onoff', 'off').removeClass('active');

                $scope.arBetInfo = $.grep($scope.arBetInfo,
                    function(betInfo) {
                        return betInfo['OSD_IDX'] !== nOSD_IDX;
                    });
                fnCartCalc();
            }
        }

        $(document).on("click",
            ".box_basic2",
            function() {

                fnCartAct($(this));

            });

        $(document).on({
                focus: function() {
                    $(this).val(parseFloat($(this).val().onlyNum()));
                },
                blur: function() {
                    if ($(this).val() === '') $(this).val(0);
                    $(this).val(parseFloat($(this).val().onlyNum()).toFixed(0).toMoney());
                },
                keypress: function() {
                    if (event.which && (event.which > 47 && event.which < 58 || event.which === 8)) {

                    } else {
                        event.preventDefault();
                    }
                    fnCartCalc();
                },
                keyup: function() {
                    if (event.which && (event.which > 47 && event.which < 58 || event.which === 8)) {

                    } else {
                        event.preventDefault();
                    }
                    fnCartCalc();
                }
            },
            "#bet_price");
        $(document).on("click",
            ".money",
            function() {
                if (parseInt($(this).attr('money')) > 0) {
                    var nMoney = parseInt($(this).attr('money'));
                    $('#bet_price').val((parseInt($('#bet_price').val().onlyNum()) + nMoney).toString().toMoney());
                    fnCartCalc();
                }
            });
        $(document).on("click",
            "#btnReset",
            function() {
                $('#bet_price').val(0);
                fnCartCalc();
            });

        $(document).on("click",
            "#btnHalf",
            function() {
                var totalDisCal = 1;
                var nUserMoney = 0;
                proxy.invoke('getUserMoney').done(function(rslt) {
                    if (parseInt(rslt) > 0) {
                        nUserMoney = parseInt(rslt);

                        $.each($scope.arBetInfo, function(idx, betInfo) {
                            totalDisCal = totalDisCal * parseFloat(betInfo['OSD_DIS']);
                        });

                        totalDisCal = parseFloat(totalDisCal).toFixed(2);

                        var nBonusDis = 1;


                        for (var i = 1; i < $scope.arBetInfo.length + 1; i++) {
                            if (arBonus[i] != null) {
                                nBonusDis = parseFloat(arBonus[i]);
                            }
                        }


                        totalDisCal = parseFloat(totalDisCal * nBonusDis).toFixed(2);

                        var nPrice = parseFloat((nUserMoney) / totalDisCal);

                        if (nPrice !== parseInt(nUserMoney / 2)) {
                            nPrice = parseInt(nUserMoney / 2);
                        }

                        if (nPrice < nPrizeMax && (parseFloat((nPrizeMax) / totalDisCal) < parseInt(nUserMoney / 2))) {
                            nPrice = parseFloat((nPrizeMax) / totalDisCal);
                        }

                        if (nPrice > nBetMax) {
                            nPrice = nBetMax;
                        }


                        $('#bet_price').val(parseInt(nPrice).toFixed(0).toString().toMoney());

                        fnCartCalc();

                    } else {
                        fnAlertSmall('보유중인 캐쉬가 0원 입니다.');
                    }
                });


            });

        $(document).on("click",
            "#btnMax",
            function() {
                var totalDisCal = 1;
                var nUserMoney = 0;
                proxy.invoke('getUserMoney').done(function(rslt) {
                    if (parseInt(rslt) > 0) {
                        nUserMoney = parseInt(rslt);

                        $.each($scope.arBetInfo, function(idx, betInfo) {
                            totalDisCal = totalDisCal * parseFloat(betInfo['OSD_DIS']);
                        });

                        totalDisCal = parseFloat(totalDisCal).toFixed(2);

                        var nBonusDis = 1;


                        for (var i = 1; i < $scope.arBetInfo.length + 1; i++) {
                            if (arBonus[i] != null) {
                                nBonusDis = parseFloat(arBonus[i]);
                            }
                        }


                        totalDisCal = parseFloat(totalDisCal * nBonusDis).toFixed(2);

                        var totalPrizeCal = parseFloat(nPrizeMax).toFixed(0);

                        var nPrice = parseFloat((totalPrizeCal) / totalDisCal);

                        if (parseInt(nPrice) > parseInt(nBetMax)) {
                            nPrice = nBetMax;
                        }

                        $('#bet_price').val(parseInt(nPrice).toFixed(0).toString().toMoney());

                        fnCartCalc();

                    } else {
                        fnAlertSmall('보유중인 캐쉬가 0원 입니다.');
                    }
                });


            });

        $(document).on("click",
            "#btnBet",
            function(event) {
                event.preventDefault();
                event.stopPropagation();

                if (bBetting) {
                    fnAlertSmall('현재 배팅 진행중입니다. 동일 현상 발생시 새로고침을 진행하여 주세요.');
                    return;
                }

                var $this = $(this);
                $this.button('loading');
                bBetting = true;

                var nBetPrice = parseInt($('#bet_price').val().onlyNum());
                var strGameType = "스포츠";

                if ($scope.arBetInfo.length === 0) {
                    fnAlertSmall('배팅할 항목을 선택해주세요.');
                    $this.button('reset');
                    bBetting = false;
                    return;
                }

                if (nBetPrice === 0) {
                    fnAlertSmall("배팅금이 0원 입니다.");
                    $this.button('reset');
                    bBetting = false;
                    return;
                }

                var nOSD_IDX = 0;

                $.each($scope.arBetInfo, function(idx, betInfo) {
                    nOSD_IDX = betInfo['OSD_IDX'];

                    if (nOSD_IDX === 0) {
                        fnAlertSmall('배팅할 항목을 선택해주세요.');
                        $this.button('reset');
                        bBetting = false;
                        return;
                    }
                });

                proxy.invoke('getUserMoney').done(function(rslt) {
                    if (parseInt(rslt) > 0) {

                        if (parseInt(rslt) < nBetPrice) {
                            fnAlertSmall('회원님의 보유머니가 부족하여 배팅이 불가능합니다.');
                            $('#bet_price').focus();
                            $this.button('reset');
                            bBetting = false;
                            return false;
                        }

                        var totalDisCal = 1;
                        var totalPrizeCal = nBetPrice;

                        $.each($scope.arBetInfo, function(idx, betInfo) {
                            totalDisCal = totalDisCal * parseFloat(betInfo['dis']);
                        });

                        if (nBetMin > 0 && parseInt(nBetMin) > parseInt(totalPrizeCal)) {
                            fnAlertSmall('회원님의 등급에 따라 제한되는 최소 배팅액을 확인해주세요.');
                            $('#bet_price').focus();
                            $this.button('reset');
                            bBetting = false;
                            return false;
                        }

                        if (nBetMax > 0 && parseInt(nBetMax) < parseInt(totalPrizeCal)) {
                            fnAlertSmall('회원님의 등급에 따라 제한되는 최대 배팅액을 확인해주세요.');
                            $('#bet_price').focus();
                            $this.button('reset');
                            bBetting = false;
                            return false;
                        }

                        if (nPrizeMax < (totalDisCal * totalPrizeCal)) {
                            fnAlertSmall('회원님의 등급에 따라 제한되는 최대 배당액을 확인해주세요.');
                            $this.button('reset');
                            bBetting = false;
                            return false;
                        }

                        fnConfirmSmall('배팅', '선택하신 내용으로 배팅금액 : ' + nBetPrice.toString().toMoney() + '원<br />배팅진행 하시겠습니까?',
                            function(rslt2) {
                                if (rslt2) {
                                    if ($scope.arBetInfo.length === 0) {
                                        fnAlertSmall('배팅할 항목을 선택해주세요.');
                                        $this.button('reset');
                                        bBetting = false;
                                        return;
                                    }

                                    fnBet(proxy, $scope.arBetInfo, nBetPrice, nBid, strGameType);
                                } else {
                                    $this.button('reset');
                                    bBetting = false;
                                }
                            }
                        );
                    } else {
                        fnAlertSmall('보유중인 캐쉬가 0원 입니다.');
                        $this.button('reset');
                        bBetting = false;
                    }
                });

            });

        function fnBet(proxy, arBetInfo, nBetPrice, nBid, strGameType) {
            var $btn = $('#btnBet');

            proxy.invoke('clsBet', arBetInfo, nBetPrice, nBid).done(function(rslt) {
                if (rslt === "Success") {
                    fnConfirmSmall('배팅완료',
                        '배팅이 완료되었습니다. <br />배팅내역에서 확인하시겠습니까?',
                        function(conf) {
                            if (conf) {
                                location.href = '/Bet';
                            } else {
                                fnCartDefault();
                                $btn.button('reset');
                                bBetting = false;
                            }
                        });



                } else if (rslt === "User") {
                    fnAlertSmall('로그인중인 회원정보가 없습니다.');
                    location.href = "/";
                } else if (rslt === "Error") {
                    fnAlertSmall('배팅도중 오류가 발생하였습니다.<br />관리자에게 문의하여 주세요.');

                    $btn.button('reset');
                    bBetting = false;
                } else {
                    fnBetCheck(strGameType, rslt, proxy, arBetInfo, nBetPrice, nBid);
                }

            });
        }

        function fnCartDefault() {
            $scope.arBetInfo = new Array;
            $('li[onoff="on"]').attr('onoff', 'off').removeClass('active');
            $('div[onoff="on"]').attr('onoff', 'off').removeClass('active');
            $('#total_dis').text("0.00");
            $('#total_bonus_dis_view').text("0.00");
            $('#total_dis_view').text("0.00");
            $('#total_prize_view').text(0);
            $('#bet_price').val(0);
            $scope.$apply();
        }

        function fnBetCheck(strGameType, rslt, proxy, arBetInfo, nBetPrice, nBid) {
            var utils = {};
            // Could create a utility function to do this
            utils.inArray = function(searchFor, property) {
                var retVal = -1;
                var self = this;
                for (var index = 0; index < self.length; index++) {
                    var item = self[index];
                    if (item.hasOwnProperty(property)) {
                        if (item[property].toLowerCase() === searchFor.toLowerCase()) {
                            retVal = index;
                            return retVal;
                        }
                    }
                };
                return retVal;
            };

            if (rslt.indexOf("Limit") > -1) {
                var arTemp = rslt.split('/');
                fnAlertSmall(arTemp[1] + "경기가 배팅제한금액 초과로 배팅이 불가능합니다.");
                $('#btnBet').button('reset');
                bBetting = false;
                return;
            }

            if (rslt.indexOf("Fail7") > -1) {
                var arTemp = rslt.split('/');

                var arInfo = arTemp[1].split('#');

                var strInfo = "";

                $.each(arInfo,
                    function(index, gameVal) {
                        if (strInfo !== "") {
                            strInfo += "<br /><br />";
                        }

                        var gameTmp = gameVal.split('|');

                        var nIdx = gameTmp[0];
                        var nDis = gameTmp[1];

                        var betInfo = arBetInfo.filter(function(item) { return item.OSD_IDX === nIdx });

                        strInfo += "경기정보 : " +
                            betInfo[0].TeamInfo +
                            "<br />배팅타입 : " +
                            betInfo[0].bType +
                            "<br/>변경배당 : " +
                            betInfo[0].OSD_DIS +
                            " => <font style='color:yellow'>" +
                            nDis +
                            "</font>";
                    });

                fnConfirmSmall("배팅-배당변경", "배팅하신 경기에 변경된 배당이 존재합니다. <br /> 변경된 배당으로 진행하시겠습니까?<br /><br />" + strInfo,
                    function(rslt) {
                        if (rslt) {
                            $.each(arInfo,
                                function(index, gameVal) {
                                    var gameTmp = gameVal.split('|');

                                    var nIdx = gameTmp[0];
                                    var nDis = gameTmp[1];

                                    var betInfo = arBetInfo.filter(function(item) { return item.OSD_IDX === nIdx });

                                    betInfo[0].OSD_DIS = nDis;
                                });


                            return fnBet(proxy, arBetInfo, nBetPrice, nBid, strGameType);
                        } else {
                            $('#btnBet').button('reset');
                            bBetting = false;
                            return;
                        }
                    });

            }

            switch (rslt) {

                case "Folder0":
                    fnAlertSmall("회원님의 등급은 단폴더 배팅이 불가능합니다.<br />등급을 확인하시고, 다시 배팅해주시기 바랍니다.");
                    $('#btnBet').button('reset');
                    bBetting = false;
                    return;
                case "Folder1":
                    fnAlertSmall("회원님의 등급은 최소 " + nFolderMin + "폴더 이상 조합만 배팅 가능합니다.");
                    $('#btnBet').button('reset');
                    bBetting = false;
                    return;
                case "Folder2":
                    fnAlertSmall("회원님의 단폴더 베팅 최고한도액은 " + nSingleMax.toString().toMoney() + "원 입니다.");
                    $('#btnBet').button('reset');
                    bBetting = false;
                    return;
                case "Folder3":
                    fnAlertSmall("회원님의 등급은 최대 " + nFolderMax + "폴더를 초과하여 배팅 할 수 없습니다. <br />등급을 확인하시고, 다시 배팅해주시기 바랍니다.");
                    $('#btnBet').button('reset');
                    bBetting = false;
                    return;

                case "Fail1":
                    fnAlertSmall("선택한 경기는 없는 경기입니다. 관리자에게 문의해주세요.");
                    $('#btnBet').button('reset');
                    bBetting = false;
                    return;

                case "Fail2":
                    fnAlertSmall("이미 종료된 경기가 포함되어 배팅이 취소되었습니다.");
                    $('#btnBet').button('reset');
                    bBetting = false;
                    return;

                case "Fail3":
                    fnAlertSmall("조합이 불가능한 경기의 배팅항목을 조합하였습니다. 다시 확인하시고 배팅하여 주시기 바랍니다.");
                    $('#btnBet').button('reset');
                    bBetting = false;
                    return;

                case "Fail4":
                    fnAlertSmall("회원님의 등급은 " + nBetLimitMax + "배 초과 배팅은 불가능합니다.");
                    $('#btnBet').button('reset');
                    bBetting = false;
                    return;

                case "Fail5":
                    fnAlertSmall("경기가 취소되었거나, 조기마감된 경기가 포함되어 배팅이 취소되었습니다.");
                    $('#btnBet').button('reset');
                    bBetting = false;
                    return;

                case "Fail6":
                    fnAlertSmall("배팅금이 0원 입니다.");
                    $('#btnBet').button('reset');
                    bBetting = false;
                    return;

                case "Fail8":
                    fnConfirmSmall("배팅", "동일한 배팅내역이 존재합니다. 배팅내역에서 확인하시겠습니까?",
                        function(rslt) {
                            if (rslt) {
                                location.href = '/Bet';
                            }
                        });
                    $('#btnBet').button('reset');
                    bBetting = false;
                    return;

                case "UserMoney":
                    fnAlertSmall("회원님의 보유머니가 부족하여 배팅이 불가능합니다.");
                    $('#btnBet').button('reset');
                    bBetting = false;
                    return;

                case "Shaft0":
                    fnAlertSmall("축배팅 최대 배당액은 " + nAxis.toString().toMoney() + "원입니다.<br />축배팅 최대 배당금을 확인하신 후 다시 배팅하시기 바랍니다.");
                    $('#btnBet').button('reset');
                    bBetting = false;
                    return;

                case "Shaft1":
                    fnAlertSmall("축배팅 최대 배팅액은 " + nCrossBet.toString().toMoney() + "원입니다.<br />축배팅 최대 배팅금을 확인하신 후 다시 배팅하시기 바랍니다.");
                    $('#btnBet').button('reset');
                    bBetting = false;
                    return;

                case "Over0":
                    fnAlertSmall(strGameType + " 최소 배팅액은 " + nBetMin.toString().toMoney() + "원입니다.<br />배팅액을 확인하신 후 다시 배팅하시기 바랍니다.");
                    $('#btnBet').button('reset');
                    bBetting = false;
                    return;

                case "Over1":
                    fnAlertSmall(strGameType + " 최대 배팅액은 " + nBetMax.toString().toMoney() + "원입니다.<br />배팅액을 확인하신 후 다시 배팅하시기 바랍니다.");
                    $('#btnBet').button('reset');
                    bBetting = false;
                    return;

                case "Over2":
                    fnAlertSmall(strGameType + " 최소 당첨액은 " + nPrizeMin.toString().toMoney() + "원입니다.<br />당첨액을 확인하신 후 다시 배팅하시기 바랍니다.");
                    $('#btnBet').button('reset');
                    bBetting = false;
                    return;

                case "Over3":
                    fnAlertSmall(strGameType + " 최대 당첨액은 " + nPrizeMax.toString().toMoney() + "원입니다.<br />당첨액을 확인하신 후 다시 배팅하시기 바랍니다.");
                    $('#btnBet').button('reset');
                    bBetting = false;
                    return;

                case "Empty":
                    fnAlertSmall("배팅할 항목을 선택하여주세요.");
                    $('#btnBet').button('reset');
                    bBetting = false;
                    return;
            }
        }

        function fnCartAgain() {
            $.each($scope.arBetInfo, function(idx, betInfo) {
                $('li[OSD_IDX="' + betInfo['OSD_IDX'] + '"]').attr('onoff', 'on').addClass('active');
                $('div[OSD_IDX="' + betInfo['OSD_IDX'] + '"]').attr('onoff', 'on').addClass('active');
            });
        }

        function fnCartAct(obj) {
            $scope.$apply(function() {
                //크로스 체크 수정 범위

                var bCross = false;

                if ($scope.lqCrossCfg[obj.attr('OSC_IDX')] !== undefined) {
                    if ($scope.lqCrossCfg[obj.attr('OSC_IDX')][obj.attr('OSBT_IDX')] !== undefined) {
                        bCross = true;
                    }
                }

                if (bCross) {
                    $.each($scope.arBetInfo,
                        function(i, el) {

                            //같은경기의 같은 배팅타입이면 1개만 선택하게 이전 카트에서 삭제
                            if (this.OS_IDX === obj.attr('OS_IDX') && this.OSBT_IDX === obj.attr('OSBT_IDX')) {
                                $scope.arBetInfo.splice(i, 1);
                            }

                        });

                    //이전에 액티브 되어있던 같은경기의 같은 배팅타입삭제
                    $('li[OS_IDX="' + obj.attr('OS_IDX') + '"][OSD_IDX!="' + obj.attr('OSD_IDX') + '"][OSBT_IDX="' + obj.attr('OSBT_IDX') + '"][onoff="on"]').attr('onoff', 'off').removeClass('active');
                    $('div[OS_IDX="' + obj.attr('OS_IDX') + '"][OSD_IDX!="' + obj.attr('OSD_IDX') + '"][OSBT_IDX="' + obj.attr('OSBT_IDX') + '"][onoff="on"]').attr('onoff', 'off').removeClass('active');


                    //크로스 체크 로직 
                    //(1. 클릭한 객체 경기의 크로스가 불가능한 배팅타입들을 카트에서 삭제)
                    if ($scope.lqCrossCfg[obj.attr('OSC_IDX')] !== undefined) {
                        if ($scope.lqCrossCfg[obj.attr('OSC_IDX')][obj.attr('OSBT_IDX')] !== undefined) {
                            var tmpCross = $scope.lqCrossCfg[obj.attr('OSC_IDX')][obj.attr('OSBT_IDX')];


                            var findCross = function(nCrossIdx) {
                                return $.grep(tmpCross,
                                    function(item) {
                                        return item.OSBT_CROSS_IDX === nCrossIdx;
                                    });
                            }

                            var nBetCount = $scope.arBetInfo.length;

                            while (nBetCount--) {
                                var tmpBetInfo = $scope.arBetInfo[nBetCount];

                                if (tmpBetInfo.OS_IDX === obj.attr('OS_IDX')) {
                                    if (findCross(parseInt(tmpBetInfo.OSBT_IDX)).length === 0) {
                                        $('li[OS_IDX="' + obj.attr('OS_IDX') + '"][OSD_IDX="' + tmpBetInfo.OSD_IDX + '"][OSBT_IDX="' + tmpBetInfo.OSBT_IDX + '"][onoff="on"]').attr('onoff', 'off').removeClass('active');
                                        $('div[OS_IDX="' + obj.attr('OS_IDX') + '"][OSD_IDX="' + tmpBetInfo.OSD_IDX + '"][OSBT_IDX="' + tmpBetInfo.OSBT_IDX + '"][onoff="on"]').attr('onoff', 'off').removeClass('active');

                                        $scope.arBetInfo.splice(nBetCount, 1);
                                    }
                                }
                            }

                        }
                    }

                } else {
                    $scope.arBetInfo = $.grep($scope.arBetInfo,
                        function(betInfo) {
                            return betInfo['OS_IDX'] !== obj.attr('OS_IDX');
                        });
                    $('li[OS_IDX="' + obj.attr('OS_IDX') + '"][OSD_IDX!="' + obj.attr('OSD_IDX') + '"][onoff="on"]').attr('onoff', 'off').removeClass('active');
                    $('div[OS_IDX="' + obj.attr('OS_IDX') + '"][OSD_IDX!="' + obj.attr('OSD_IDX') + '"][onoff="on"]').attr('onoff', 'off').removeClass('active');
                }

                /*
                if (obj.attr('Cross') === "Y") {
                    $.each($scope.arBetInfo,
                        function (i, el) {
                            if (this.OS_IDX === obj.attr('OS_IDX') && this.OSBT_IDX === obj.attr('OSBT_IDX')) {
                                $scope.arBetInfo.splice(i, 1);
                            }

                            if (this.OS_IDX === obj.attr('OS_IDX') && this.Cross !== obj.attr('Cross')) {
                                $scope.arBetInfo.splice(i, 1);
                            }
                        });

                    $('li[OS_IDX="' + obj.attr('OS_IDX') + '"][OSD_IDX!="' + obj.attr('OSD_IDX') + '"][OSBT_IDX="' + obj.attr('OSBT_IDX') + '"][onoff="on"]').attr('onoff', 'off').removeClass('active');
                    $('div[OS_IDX="' + obj.attr('OS_IDX') + '"][OSD_IDX!="' + obj.attr('OSD_IDX') + '"][OSBT_IDX="' + obj.attr('OSBT_IDX') + '"][onoff="on"]').attr('onoff', 'off').removeClass('active');
                    $('li[OS_IDX="' + obj.attr('OS_IDX') + '"][OSD_IDX!="' + obj.attr('OSD_IDX') + '"][Cross!="' + obj.attr('Cross') + '"][onoff="on"]').attr('onoff', 'off').removeClass('active');
                    $('div[OS_IDX="' + obj.attr('OS_IDX') + '"][OSD_IDX!="' + obj.attr('OSD_IDX') + '"][Cross!="' + obj.attr('Cross') + '"][onoff="on"]').attr('onoff', 'off').removeClass('active');
                } else {
                    $scope.arBetInfo = $.grep($scope.arBetInfo,
                        function (betInfo) {
                            return betInfo['OS_IDX'] !== obj.attr('OS_IDX');
                        });
                    $('li[OS_IDX="' + obj.attr('OS_IDX') + '"][OSD_IDX!="' + obj.attr('OSD_IDX') + '"][onoff="on"]').attr('onoff', 'off').removeClass('active');
                    $('div[OS_IDX="' + obj.attr('OS_IDX') + '"][OSD_IDX!="' + obj.attr('OSD_IDX') + '"][onoff="on"]').attr('onoff', 'off').removeClass('active');
                }
                */

                var strTeamInfo = "[" + obj.parent().parent().attr('CAT') + "] " + obj.parent().parent().attr('Home') + " VS " + obj.parent().parent().attr('Away');




                if (obj.attr('onoff') === "on") {
                    obj.attr('onoff', 'off');
                    $('li[OSD_IDX="' + obj.attr('OSD_IDX') + '"]').attr('onoff', 'off').removeClass('active');
                    $('div[OSD_IDX="' + obj.attr('OSD_IDX') + '"]').attr('onoff', 'off').removeClass('active');

                    $scope.arBetInfo = $.grep($scope.arBetInfo,
                        function(betInfo) {
                            return betInfo['OSD_IDX'] !== obj.attr('OSD_IDX');
                        });

                } else if (obj.attr('onoff') === "off") {
                    obj.attr('onoff', 'off');
                    $('li[OSD_IDX="' + obj.attr('OSD_IDX') + '"]').attr('onoff', 'on').addClass('active');
                    $('div[OSD_IDX="' + obj.attr('OSD_IDX') + '"]').attr('onoff', 'on').addClass('active');

                    $scope.arBetInfo.push({
                        TeamInfo: strTeamInfo,
                        OSC_IDX: obj.attr('OSC_IDX'),
                        OS_IDX: obj.attr('OS_IDX'),
                        Cross: obj.attr('Cross'),
                        OSD_IDX: obj.attr('OSD_IDX'),
                        OSBT_IDX: obj.attr('OSBT_IDX'),
                        OSD_DIS: obj.attr('OSD_DIS'),
                        bType: obj.attr('bType'),
                        Bet: obj.attr('Bet')
                    });

                }
                fnCartCalc();

            });
        }

        function fnCartCalc() {
            var totalDisCal = 1;
            var totalPrizeCal = parseFloat($('#bet_price').val().onlyNum()).toFixed(0);

            $.each($scope.arBetInfo, function(idx, betInfo) {
                totalDisCal = totalDisCal * parseFloat(betInfo['OSD_DIS']);
            });

            totalDisCal = parseFloat(totalDisCal).toFixed(2);

            var nBonusDis = 0;

            for (var i = 1; i < $scope.arBetInfo.length + 1; i++) {
                if (arBonus[i] != null) {
                    nBonusDis = parseFloat(arBonus[i]);
                }
            }

            var nRsltBonus = 0;

            if (nBonusDis === 0) {
                nRsltBonus = 1;
            } else {
                nRsltBonus = nBonusDis;
            }


            var nTotal = 1;

            nTotal = parseFloat(totalDisCal * nRsltBonus).toFixed(2);

            $('#total_dis').text(nTotal);
            $('#total_bonus_dis_view').text(nBonusDis.toFixed(2));
            $('#total_dis_view').text(totalDisCal.toString().toMoney());
            $('#total_prize_view').text(parseFloat(totalPrizeCal * nTotal).toFixed(0).toString().toMoney());
        }




        $scope.clsTodayCategory = function() {
            if ($scope.TodayActive === true) {
                $scope.TodayActive = false;
            } else {
                $scope.TodayActive = true;
                $scope.OSC_IDX = -1;
                $scope.OSC_NAME = "오늘의 경기";
                $scope.OSC_IMAGE = "";
                $scope.Games = null;

                $http({
                    method: "POST",
                    url: "/Sports/ClsTodayCategory",
                    dataType: 'json',
                    data: { 'nBID': nBid },
                    headers: { "Content-Type": "application/json" }
                }).then(function(rslt) {
                    if (rslt.data != null) {
                        $scope.TodayCategory = rslt.data;
                        clsTodayGame();
                    }
                }, function(error) {
                    console.log(error);
                });
            }

        }

        $scope.clsTodayCategoryTop = function() {
            $scope.SearchOSC_IDX = -1;
            $scope.OSC_IDX = -1;
            $scope.OSC_NAME = "오늘의 경기";
            $scope.OSC_IMAGE = "";
            $scope.Games = null;

            $http({
                method: "POST",
                url: "/Sports/ClsTodayCategory",
                dataType: 'json',
                data: { 'nBID': nBid },
                headers: { "Content-Type": "application/json" }
            }).then(function(rslt) {
                if (rslt.data != null) {
                    $scope.TodayCategory = rslt.data;
                    clsTodayGame();
                }
            }, function(error) {
                console.log(error);
            });

            fnTodayShow();
        }

        $scope.clsTodayLeagues = function(nIdx, nOSC_IDX) {
            if ($scope.TodayCategoryActive[nIdx] === true) {
                $scope.TodayCategoryActive[nIdx] = false;
            } else {
                $scope.TodayCategoryActive[nIdx] = true;
                $scope.Games = null;

                $http({
                    method: "POST",
                    url: "/Sports/ClsTodayLeagues",
                    dataType: 'json',
                    data: { 'nBID': nBid, 'nOSC_IDX': nOSC_IDX },
                    headers: { "Content-Type": "application/json" }
                }).then(function(rslt) {
                    if (rslt.data != null) {
                        $scope.TodayCategory[nIdx].Leagues = rslt.data;
                        $scope.TodayLeague = rslt.data;
                        clsTodayCategoryGame(nBid, nOSC_IDX);
                    }
                }, function(error) {
                    console.log(error);
                });
            }
        }
        $scope.clsTodayLeagueGame = function(nOSC_IDX, nOSL_IDX) {
            $scope.Details = {};
            $scope.DetailsLoading = {};
            $scope.DetailsActive = {};
            $scope.SearchOSL_IDX = nOSL_IDX;
            $scope.Games = null;

            $http({
                method: "POST",
                url: "/Sports/ClsTodayLeagueGame",
                dataType: 'json',
                data: { 'nBID': nBid, 'nOSC_IDX': nOSC_IDX, 'nOSL_IDX': nOSL_IDX },
                headers: { "Content-Type": "application/json" }
            }).then(function(rslt) {
                if (rslt.data != null) {
                    var lqGames = rslt.data;
                    $scope.Games = lqGames;
                    fnCartAgain();

                }
            }, function(error) {
                console.log(error);
            });
        }

        $scope.clsTodayLeaguesTop = function(nIdx, nOSC_IDX) {
            $scope.SearchOSC_IDX = nOSC_IDX;
            $scope.Games = null;

            $http({
                method: "POST",
                url: "/Sports/ClsTodayLeagues",
                dataType: 'json',
                data: { 'nBID': nBid, 'nOSC_IDX': nOSC_IDX },
                headers: { "Content-Type": "application/json" }
            }).then(function(rslt) {
                if (rslt.data != null) {
                    $scope.TodayLeague = rslt.data;
                    clsTodayCategoryGame(nBid, nOSC_IDX);
                }
            }, function(error) {
                console.log(error);
            });

        }

        function clsTodayCategoryGame(nBid, nOSC_IDX) {
            $http({
                method: "POST",
                url: "/Sports/ClsTodayCategoryGame",
                dataType: 'json',
                data: { 'nBID': nBid, 'nOSC_IDX': nOSC_IDX },
                headers: { "Content-Type": "application/json" }
            }).then(function(rslt) {
                if (rslt.data != null) {
                    var lqGames = rslt.data;
                    $scope.Games = lqGames;

                    fnCartAgain();
                }
            }, function(error) {
                console.log(error);
            });
        }

        $scope.clsTodayLeagueGameTop = function(nOSL_IDX) {
            $scope.Details = {};
            $scope.DetailsLoading = {};
            $scope.DetailsActive = {};
            $scope.SearchOSL_IDX = nOSL_IDX;
            $scope.Games = null;

            $http({
                method: "POST",
                url: "/Sports/ClsTodayLeagueGame",
                dataType: 'json',
                data: { 'nBID': nBid, 'nOSC_IDX': $scope.SearchOSC_IDX, 'nOSL_IDX': nOSL_IDX },
                headers: { "Content-Type": "application/json" }
            }).then(function(rslt) {
                if (rslt.data != null) {
                    var lqGames = rslt.data;
                    $scope.Games = lqGames;
                    fnCartAgain();

                }
            }, function(error) {
                console.log(error);
            });
        }

        $scope.clsSubCategory = function(nIdx, nOSC_IDX, strOSC_NAME, strOSC_IMAGE) {
            if ($scope.Category != null) {
                if ($scope.CategoryActive[nOSC_IDX] === true) {
                    $scope.CategoryActive[nOSC_IDX] = false;
                } else {
                    $scope.CategoryActive[nOSC_IDX] = true;

                    $http({
                        method: "POST",
                        url: "/Sports/ClsSubCategory",
                        dataType: 'json',
                        data: { 'nBID': nBid, 'nIDX': nOSC_IDX },
                        headers: { "Content-Type": "application/json" }
                    }).then(function(rslt) {
                        if (rslt.data != null) {
                            $scope.Category[nIdx].SubCategory = rslt.data;
                            $scope.SearchCategoryIdx = nIdx;
                            $scope.Details = {};
                            $scope.DetailsLoading = {};
                            $scope.DetailsActive = {};
                            $scope.RegionActive = {};
                            $scope.OSC_IDX = nOSC_IDX;
                            $scope.OSC_NAME = strOSC_NAME;
                            $scope.OSC_IMAGE = strOSC_IMAGE;
                            $scope.Games = null;

                            clsCategoryGame(nBid, nOSC_IDX);

                        }
                    }, function(error) {
                        console.log(error);
                    });

                }

            }

        }
        $scope.clsChildCategory = function(nParentIdx, nIdx, nOSC_IDX, nOSR_IDX, strOSC_NAME, strOSC_IMAGE) {

            if ($scope.RegionActive[nParentIdx + "_" + nIdx] === true) {
                $scope.RegionActive[nParentIdx + "_" + nIdx] = false;
            } else {
                $scope.RegionActive[nParentIdx + "_" + nIdx] = true;
                $http({
                    method: "POST",
                    url: "/Sports/ClsChildCategory",
                    dataType: 'json',
                    data: { 'nBID': nBid, 'nOSC_IDX': nOSC_IDX, 'nOSR_IDX': nOSR_IDX },
                    headers: { "Content-Type": "application/json" }
                }).then(function(rslt) {
                    if (rslt.data != null) {
                        var result = rslt.data;

                        $scope.Category[nParentIdx].SubCategory[nIdx].Leagues = result;
                        $scope.Details = {};
                        $scope.DetailsLoading = {};
                        $scope.DetailsActive = {};
                        $scope.OSC_NAME = strOSC_NAME;
                        $scope.OSC_IMAGE = strOSC_IMAGE;
                        $scope.Games = null;

                        clsRegionGame(nBid, nOSC_IDX, nOSR_IDX);
                    }
                }, function(error) {
                    console.log(error);
                });

            }
        }

        $scope.clsLeagueGame = function(nOSC_IDX, nOSR_IDX, nOSL_IDX, strOSC_NAME, strOSC_IMAGE) {
            $scope.Details = {};
            $scope.DetailsLoading = {};
            $scope.DetailsActive = {};
            $scope.SearchOSL_IDX = nOSL_IDX;
            $scope.OSC_NAME = strOSC_NAME;
            $scope.OSC_IMAGE = strOSC_IMAGE;
            $scope.Games = null;

            $http({
                method: "POST",
                url: "/Sports/ClsLeagueGame",
                dataType: 'json',
                data: { 'nBID': nBid, 'nOSC_IDX': nOSC_IDX, 'nOSR_IDX': nOSR_IDX, 'nOSL_IDX': nOSL_IDX },
                headers: { "Content-Type": "application/json" }
            }).then(function(rslt) {
                if (rslt.data != null) {
                    var lqGames = rslt.data;
                    $scope.Games = lqGames;
                    fnCartAgain();
                }
            }, function(error) {
                console.log(error);
            });

        }

        $scope.clsSubCategoryTop = function(nIdx, nOSC_IDX, strOSC_NAME, strOSC_IMAGE) {
            if ($scope.Category != null) {

                $http({
                    method: "POST",
                    url: "/Sports/ClsSubCategory",
                    dataType: 'json',
                    data: { 'nBID': nBid, 'nIDX': nOSC_IDX },
                    headers: { "Content-Type": "application/json" }
                }).then(function(rslt) {
                    if (rslt.data != null) {
                        $scope.RegionActive = {};
                        $scope.Region = rslt.data;
                        $scope.SearchCategoryIdx = nIdx;
                        $scope.SearchOSC_IDX = nOSC_IDX;
                        $scope.SearchOSC_NAME = strOSC_NAME;
                        $scope.SearchOSC_IMAGE = strOSC_IMAGE;
                        $scope.OSC_IDX = nOSC_IDX;
                        $scope.OSC_NAME = strOSC_NAME;
                        $scope.OSC_IMAGE = strOSC_IMAGE;
                        $scope.Games = null;

                        clsCategoryGame(nBid, nOSC_IDX);

                    }
                }, function(error) {
                    console.log(error);
                });

                fnTodayHide();
            }
        }

        function clsCategoryGame(nBid, nOSC_IDX) {
            $http({
                method: "POST",
                url: "/Sports/ClsCategoryGame",
                dataType: 'json',
                data: { 'nBID': nBid, 'nOSC_IDX': nOSC_IDX },
                headers: { "Content-Type": "application/json" }
            }).then(function(rslt) {
                if (rslt.data != null) {
                    var lqGames = rslt.data;
                    $scope.Games = lqGames;

                    fnCartAgain();
                }
            }, function(error) {
                console.log(error);
            });

        }

        function clsRegionGame(nBid, nOSC_IDX, nOSR_IDX) {
            $http({
                method: "POST",
                url: "/Sports/ClsRegionGame",
                dataType: 'json',
                data: { 'nBID': nBid, 'nOSC_IDX': nOSC_IDX, 'nOSR_IDX': nOSR_IDX },
                headers: { "Content-Type": "application/json" }
            }).then(function(rslt) {
                if (rslt.data != null) {
                    var lqGames = rslt.data;
                    $scope.Games = lqGames;
                    fnCartAgain();
                }
            }, function(error) {
                console.log(error);
            });
        }

        $scope.clsChildCategoryTop = function(nOSR_IDX) {
            $http({
                method: "POST",
                url: "/Sports/ClsChildCategory",
                dataType: 'json',
                data: { 'nBID': nBid, 'nOSC_IDX': $scope.SearchOSC_IDX, 'nOSR_IDX': nOSR_IDX },
                headers: { "Content-Type": "application/json" }
            }).then(function(rslt) {
                if (rslt.data != null) {
                    var result = rslt.data;

                    $scope.League = result;
                    $scope.Details = {};
                    $scope.DetailsLoading = {};
                    $scope.DetailsActive = {};
                    $scope.SearchOSR_IDX = nOSR_IDX;
                    $scope.OSC_IDX = $scope.SearchOSC_IDX;
                    $scope.OSC_NAME = $scope.SearchOSC_NAME;
                    $scope.OSC_IMAGE = $scope.SearchOSC_IMAGE;
                    $scope.Games = null;

                    clsRegionGame(nBid, $scope.SearchOSC_IDX, nOSR_IDX);
                }
            }, function(error) {
                console.log(error);
            });

        }

        $scope.clsLeagueGameTop = function(nOSL_IDX) {

            $scope.Details = {};
            $scope.DetailsLoading = {};
            $scope.DetailsActive = {};
            $scope.SearchOSL_IDX = nOSL_IDX;
            $scope.OSC_IDX = $scope.SearchOSC_IDX;
            $scope.OSC_NAME = $scope.SearchOSC_NAME;
            $scope.OSC_IMAGE = $scope.SearchOSC_IMAGE;
            $scope.Games = null;

            $http({
                method: "POST",
                url: "/Sports/ClsLeagueGame",
                dataType: 'json',
                data: { 'nBID': nBid, 'nOSC_IDX': $scope.SearchOSC_IDX, 'nOSR_IDX': $scope.SearchOSR_IDX, 'nOSL_IDX': nOSL_IDX },
                headers: { "Content-Type": "application/json" }
            }).then(function(rslt) {
                if (rslt.data != null) {
                    var lqGames = rslt.data;
                    $scope.Games = lqGames;
                    fnCartAgain();
                }
            }, function(error) {
                console.log(error);
            });

        }



        $scope.fnDetail = function(nOSC_IDX, nOS_IDX, nOSBT_IDX, dblHandi, strHandiYn, nCount) {
            if (nCount > 0) {
                if ($scope.DetailsActive[nOS_IDX] === true) {
                    $scope.DetailsActive[nOS_IDX] = false;
                } else {
                    $scope.DetailsLoading[nOS_IDX] = true;
                    $scope.DetailsActive[nOS_IDX] = true;

                    $http({
                        method: "POST",
                        url: "/Sports/ClsGameDetail",
                        dataType: 'json',
                        data: { 'nBID': nBid, 'nOSC_IDX': nOSC_IDX, 'nOS_IDX': nOS_IDX, 'nBT_IDX': nOSBT_IDX, 'dblHandi': dblHandi, 'strHandiYn': strHandiYn },
                        headers: { "Content-Type": "application/json" }
                    }).then(function(rslt) {
                        if (rslt.data != null) {
                            var result = rslt.data;
                            $scope.Details[nOS_IDX] = result;
                            $scope.DetailsLoading[nOS_IDX] = false;
                            fnCartAgain();

                            $('.typeTd').each(function(index) {
                                $(this).height($(this).parent().outerHeight() - 19);
                            });
                        }
                    }, function(error) {
                        console.log(error);
                    });
                }
            }


        }

        $scope.sortBy = function(strType) {
            if (strType === "League") {
                $scope.Games = orderBy($scope.Games, ['-OSL_MAIN', 'OSL_IDX', 'OS_START_DATE'], false);
            } else if (strType === "Time") {
                $scope.Games = orderBy($scope.Games, ['-OSL_MAIN', 'OS_START_DATE', 'OSL_NAME_KR', 'OSL_NAME_EN']);
            } else if (strType === "Popular") {
                $scope.Games = orderBy($scope.Games, ['-OSD_BET_MONEY', '-OSL_MAIN', 'OS_START_DATE', 'OSL_NAME_KR', 'OSL_NAME_EN']);
            }

        }
        $scope.greaterThan = function(prop, val) {
            return function(item) {
                return item[prop] > val;
            }
        }

        $scope.fnSearch = function() {
            if ($scope.searchText !== "") {
                $scope.Details = {};
                $scope.DetailsLoading = {};
                $scope.DetailsActive = {};

                $scope.Games = null;

                $http({
                    method: "POST",
                    url: "/Sports/ClsSearchGame",
                    dataType: 'json',
                    data: {
                        'nBid': nBid,
                        'strSearch': $scope.searchText
                    },
                    headers: { "Content-Type": "application/json" }
                }).then(function(rslt) {
                    if (rslt.data != null) {
                        var lqGame = rslt.data;
                        $scope.Games = lqGame;
                        fnCartAgain();
                    }
                }, function(error) {
                    console.log(error);
                });
            } else {
                fnAlertSmall("검색할 내용을 입력하여 주세요.");
            }

        }

        $scope.layoutDone = function() {
            setTimeout(function() {
                $('.typeTd').each(function(index) {
                    $(this).height($(this).parent().outerHeight() - 19);
                });
            }, 0);
        }


        function clsSportsInfo() {
            $http({
                method: "POST",
                url: "/Sports/ClsSportsInfo",
                dataType: 'json',
                data: {},
                headers: { "Content-Type": "application/json" }
            }).then(function(rslt) {

                if (rslt.data != null) {
                    var gameInfo = rslt.data;

                    $scope.GameInfo = gameInfo;

                    nBetMax = gameInfo.OulSportsBetMax;
                    nBetMin = gameInfo.OulSportsBetMin;
                    nPrizeMax = gameInfo.OulSportsWinMax;
                    nPrizeMin = gameInfo.OulSportsWinMin;
                    nFolderMin = gameInfo.OulSportsFolderMin;
                    nFolderMax = gameInfo.OulSportsFolderMax;
                    nSingleMax = gameInfo.OulSingleMax;
                    nBetLimitMax = gameInfo.OulSportsBetLimit;
                    nAxis = gameInfo.OulSportsAxis;
                    nCrossBet = gameInfo.OulCrossBetMax;

                    arBonus = gameInfo.DcBonus;
                }



            }, function(error) {
                console.log(error);
            });


        }

        function clsCategory() {
            $http({
                method: "POST",
                url: "/Sports/ClsCategory",
                dataType: 'json',
                data: { 'nBid': nBid },
                headers: { "Content-Type": "application/json" }
            }).then(function(rslt) {

                if (rslt.data != null) {
                    var nTodayCount = rslt.data.nTodayCount;
                    var lqCategory = rslt.data.lqCategory;

                    $scope.TodayCount = nTodayCount;
                    $scope.Category = lqCategory;
                }


            }, function(error) {
                console.log(error);
            });
        }

        function clsTdCategory() {
            $http({
                method: "POST",
                url: "/Sports/ClsTdCategory",
                dataType: 'json',
                data: { 'nBid': nBid },
                headers: { "Content-Type": "application/json" }
            }).then(function(rslt) {
                if (rslt.data != null) {
                    var lqCategory = rslt.data;
                    $scope.TodayCategory = lqCategory;
                }


            }, function(error) {
                console.log(error);
            });
        }

        function clsTodayGame() {
            $http({
                method: "POST",
                url: "/Sports/ClsTodayGame",
                dataType: 'json',
                data: { 'nBid': nBid },
                headers: { "Content-Type": "application/json" }
            }).then(function(rslt) {
                if (rslt.data != null) {
                    var lqGame = rslt.data;



                    $scope.Games = lqGame;


                    fnCartScrolling();
                    fnCartAgain();
                }


            }, function(error) {
                console.log(error);
            });
        }

        function clsCrossSet() {
            $http({
                method: "POST",
                url: "/Sports/ClsCrossSet",
                dataType: 'json',
                data: { 'nBid': nBid },
                headers: { "Content-Type": "application/json" }
            }).then(function(rslt) {
                if (rslt.data != null) {
                    $.each(rslt.data, function(i, v) {
                        $scope.lqCrossCfg[v.OSC_IDX] = new Array;
                    });
                    $.each(rslt.data, function(i, v) {
                        $scope.lqCrossCfg[v.OSC_IDX][v.OSBT_IDX] = new Array;
                    });
                    $.each(rslt.data,
                        function(i, v) {
                            $scope.lqCrossCfg[v.OSC_IDX][v.OSBT_IDX].push({
                                OSBT_CROSS_IDX: v.OSBT_CROSS_IDX,
                                OSBT_BONUS: v.OSBT_BONUS
                            });
                        });
                }


            }, function(error) {
                console.log(error);
            });
        }


        clsSportsInfo();
        clsCategory();
        clsTdCategory();
        clsTodayGame();
        clsCrossSet();


        connection.start().done(function() {

        });
    }
]);


app.filter("getLeague", ['$sce',
    function($sce) {
        return function(strTmp) {
            return $sce.trustAsHtml(strTmp);
        }
    }
]);

app.filter("getBetName",
    function() {
        return function(strTmp, strHandiYn, strHandi) {
            var strRslt = strTmp.toLowerCase();
            var strRsltHandi = "";
            if (strHandiYn === "Y") {
                if (strRslt === "over" || strRslt === "under" || strRslt === "home" || strRslt === "home/over" || strRslt === "draw/over" || strRslt === "away/over" || strRslt === "home/under" || strRslt === "draw/under" || strRslt === "away/under") {
                    strRsltHandi = "(" + strHandi.toFixed(1) + ")";
                } else if (strRslt === "away") {
                    strRsltHandi = "(" + (-1 * strHandi).toFixed(1) + ")";
                }
            }

            strRslt = strRslt.replace("home/over", "홈승+오버");
            strRslt = strRslt.replace("draw/over", "무+오버");
            strRslt = strRslt.replace("away/over", "원정승+오버");
            strRslt = strRslt.replace("home/under", "홈승+언더");
            strRslt = strRslt.replace("draw/under", "무+언더");
            strRslt = strRslt.replace("away/under", "원정승+언더");
            strRslt = strRslt.replace("home", "홈");
            strRslt = strRslt.replace("draw", "무");
            strRslt = strRslt.replace("away", "원정");
            strRslt = strRslt.replace("over", "오버");
            strRslt = strRslt.replace("under", "언더");
            strRslt = strRslt.replace("odd", "홀");
            strRslt = strRslt.replace("even", "짝");
            strRslt = strRslt.replace("1/1", "홈/홈");
            strRslt = strRslt.replace("1/2", "홈/원정");
            strRslt = strRslt.replace("x/1", "무/홈");
            strRslt = strRslt.replace("x/2", "무/원정");
            strRslt = strRslt.replace("2/1", "원정/홈");
            strRslt = strRslt.replace("2/2", "원정/원정");
            strRslt = strRslt.replace("/yes", "/예");
            strRslt = strRslt.replace("/no", "/아니오");
            strRslt = strRslt.replace("no goal", "무득점");
            strRslt = strRslt.replace("1st half", "전반전");
            strRslt = strRslt.replace("2nd half", "후반전");
            strRslt = strRslt.replace("1st period", "1페리어드");
            strRslt = strRslt.replace("2nd period", "2페리어드");
            strRslt = strRslt.replace("3rd period", "3페리어드");
            strRslt = strRslt.replace("more 3", "3골 이상");
            strRslt = strRslt.replace("more 4", "4골 이상");
            strRslt = strRslt.replace("more 7", "7골 이상");
            strRslt = strRslt.replace("more 6", "6골 이상");
            strRslt = strRslt.replace("more 5", "5골 이상");

            if (strRslt === "yes") {
                strRslt = "예";
            } else if (strRslt === "no") {
                strRslt = "아니오";
            }

            if (strRsltHandi !== "") {
                strRslt += strRsltHandi;
            }

            return strRslt;
        }
    });

app.filter("getBetTeamName",
    function() {
        return function(strTeamName, strTmp, strHandiYn, strHandi) {
            var strRslt = strTmp.toLowerCase();
            var strRsltHandi = "";
            if (strHandiYn === "Y") {
                if (strRslt === "over") {
                    strRsltHandi = " - 오버 (" + strHandi.toFixed(1) + ")";
                } else if (strRslt === "under") {
                    strRsltHandi = " - 언더 (" + strHandi.toFixed(1) + ")";
                } else if (strRslt === "home") {
                    strRsltHandi = "(" + strHandi.toFixed(1) + ")";
                } else if (strRslt === "away") {
                    strRsltHandi = "(" + (-1 * strHandi).toFixed(1) + ")";
                }
            }

            strRslt = strTeamName;

            if (strRsltHandi !== "") {
                strRslt += strRsltHandi;
            }

            return strRslt;
        }
    });

app.filter("getBetTeamNameMobile",
    function() {
        return function(strTeamName, strTmp, strHandiYn, strHandi) {
            var strRslt = strTmp.toLowerCase();
            var strRsltHandi = "";
            if (strHandiYn === "Y") {
                if (strRslt === "over") {
                    strRsltHandi = " - 오버";
                } else if (strRslt === "under") {
                    strRsltHandi = " - 언더";
                }
            }

            strRslt = strTeamName;

            if (strRsltHandi !== "") {
                strRslt += strRsltHandi;
            }

            return strRslt;
        }
    });
app.filter("getBetCountTR",
    function() {
        return function(strCate, strBetIdx, strBetCount) {

            var nRslt = strBetCount;

            if (strCate == 1 && strBetIdx == 22621) {
                nRslt = 6;
            }

            return nRslt;
        }
    });

app.directive('myEnter', function() {
    return function(scope, element, attrs) {
        element.bind("keydown keypress", function(event) {
            if (event.which === 13) {
                scope.$apply(function() {
                    scope.$eval(attrs.myEnter);
                });

                event.preventDefault();
            }
        });
    };
});

app.directive('repeatDone', function() {
    return function(scope, element, attrs) {
        if (scope.$last) { // all are rendered
            scope.$eval(attrs.repeatDone);
        }
    }
});

function fnTodayHide() {
    $("#laToday").hide();
    $("#laTodayLeague").hide();
    $("#laRegion").show();
    $("#laLeague").show();

    $('#divRegion').html("<div style='display: table-cell; vertical-align: middle'>국가선택</div>");
    $('#divToday').html("<div style='display: table-cell; vertical-align: middle'>종목선택</div>");
    $('#divLeague').html("<div style='display: table-cell; vertical-align: middle'>리그선택</div>");
}

function fnTodayShow() {
    $("#laToday").show();
    $("#laTodayLeague").show();
    $("#laRegion").hide();
    $("#laLeague").hide();

    $('#divRegion').html("<div style='display: table-cell; vertical-align: middle'>국가선택</div>");
    $('#divToday').html("<div style='display: table-cell; vertical-align: middle'>종목선택</div>");
    $('#divLeague').html("<div style='display: table-cell; vertical-align: middle'>리그선택</div>");
}

function fnFrameResize() {
    var wth = $(window).width();

    if (wth > 1500) {
        $('.container').css('width', '');
        $('.body-content').removeClass('ct1200');
        $('.body-content').css('width', '1500px');
        $('.sports_main').css('width', '60%');
        $('.sports_main').show();
        $('.sports_mobile').hide();
        $('.sports_cart').css('width', '20%');
        $('.search_main').css('width', '80%');
        $('.sports_cart').removeClass('sports_cart_pd0');
        $('.barNotice').removeClass('br0');
        $('.navbar-title').hide();
        $('#leftWrap').show();
    } else if (wth > 1200 && wth < 1501) {
        $('.container').css('width', '');
        $('.body-content').addClass('ct1200');
        $('.body-content').css('width', '1170px');
        $('.sports_main').css('width', '70%');
        $('.sports_main').show();
        $('.sports_mobile').hide();
        $('.sports_cart').css('width', '30%');
        $('.search_main').css('width', '100%');
        $('.sports_cart').removeClass('sports_cart_pd0');
        $('.barNotice').removeClass('br0');
        $('.navbar-title').hide();
        $('#leftWrap').hide();
    } else if (wth > 977 && wth < 1201) {
        $('.container').css('width', '970px');
        $('.body-content').css('width', '970px');
        $('.body-content').addClass('ct1200');
        $('.sports_main').css('width', '92%');
        $('.sports_main').show();
        $('.sports_mobile').hide();
        $('.sports_cart').css('width', '8%');
        $('.search_main').css('width', '100%');
        $('.sports_cart').removeClass('sports_cart_pd0');
        $('.barNotice').removeClass('br0');
        $('.navbar-title').hide();
        $('.cartIcon').show();
        $('#leftWrap').hide();
    } else if (wth > 768 && wth < 978) {

        $('.container').css('width', '100%');
        $('.body-content').addClass('ct1200');
        $('.body-content').css('width', '100%');
        $('.sports_main').css('width', '100%');
        $('.sports_main').show();
        $('.sports_mobile').hide();
        $('.sports_cart').css('width', '100%');
        $('.search_main').css('width', '100%');
        $('.barNotice').addClass('br0');
        $('.navbar-title').show();
        $('.cartIcon').hide();
        $('#cartWrap').css('margin-top', '5px');
        $('#leftWrap').hide();
    } else if (wth < 769) {
        $('.container').css('width', '100%');
        $('.body-content').addClass('ct1200');
        $('.body-content').css('width', '100%');
        $('.sports_main').css('width', '100%');
        $('.sports_main').hide();
        $('.sports_mobile').show();
        $('.sports_cart').css('width', '100%');
        $('.search_main').css('width', '100%');
        $('.barNotice').addClass('br0');
        $('.navbar-title').show();
        $('.cartIcon').hide();
        $('#cartWrap').css('margin-top', '5px');
        $('#leftWrap').hide();
    }
}
$(window).resize(function() {
    fnFrameResize();
});

function fnCartScrolling() {

    var cart = $('#cartWrap');
    var wth = $(window).width();

    if (wth > 976) {
        var marginGap = 220;
        var offTop = parseInt($(window).scrollTop());

        if ($('#chkCart').prop('checked') === false) {

            if (parseInt(cart.height()) < parseInt($('.sports_main').height())) {
                if ((parseInt(cart.height()) + offTop) - marginGap < parseInt($('.sports_main').height())) {

                    if (offTop > marginGap) {
                        cart.stop().animate({ marginTop: (offTop - marginGap) + 'px' }, 100);
                    } else {
                        cart.stop().animate({ marginTop: '0px' }, 100);
                    }
                } else {
                    cart.stop();
                }
            } else {

                cart.stop().animate({ marginTop: '0px' }, 100);
            }

        }
    } else {
        cart.css('margin-top', '5px');
        var offTop = parseInt($(window).scrollTop());
        var tTop = 157 - offTop;
        if (tTop < 0) {
            tTop = 0;
        }
        $('.navbar-title').css('top', tTop + 'px');
    }


}
$(document).ready(function() {
    var wth = $(window).width();

    if (wth > 1500) {
        $('.body-content').css('width', '1500px');
    } else if (wth < 1501) {
        $('.body-content').css('width', '99%');
    }

    fnFrameResize();

    $("#ddCategory").on("show.bs.dropdown hide.bs.dropdown", function() {
        $("#btnCategory").children().toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
    });
    $("#divCategory").click(function(e) {
        e.stopPropagation();
        $("#btnCategory").dropdown('toggle');
    });

    $("#ddRegion").on("show.bs.dropdown hide.bs.dropdown", function() {
        $("#btnRegion").children().toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
    });
    $("#divRegion").click(function(e) {
        e.stopPropagation();
        $("#btnRegion").dropdown('toggle');
    });

    $("#ddLeague").on("show.bs.dropdown hide.bs.dropdown", function() {
        $("#btnLeague").children().toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
    });
    $("#divLeague").click(function(e) {
        e.stopPropagation();
        $("#btnLeague").dropdown('toggle');
    });

    $("#ddToday").on("show.bs.dropdown hide.bs.dropdown", function() {
        $("#btnToday").children().toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
    });
    $("#divToday").click(function(e) {
        e.stopPropagation();
        $("#btnToday").dropdown('toggle');
    });

    $("#ddTodayLeague").on("show.bs.dropdown hide.bs.dropdown", function() {
        $("#btnTodayLeague").children().toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
    });
    $("#divTodayLeague").click(function(e) {
        e.stopPropagation();
        $("#btnTodayLeague").dropdown('toggle');
    });
    $(window).scroll(function() { fnCartScrolling(); });

    fnCartScrolling();

    $(".titleToggle").click(function() {
        $(window).scrollTop(0);
        $(".animenu__toggle").trigger("click");
    });

    $(".searchToggle").click(function() {
        var position = $("#laCategory").offset();
        var sc = $(this).attr('sc');
        var scYN = $(this).attr('scYN');

        if (scYN === "Y") {
            $(window).scrollTop(parseInt(sc));
            $(this).attr('sc', '0');
            $(this).attr('scYN', 'N');
        } else {
            $(this).attr('sc', $(window).scrollTop());
            $(this).attr('scYN', 'Y');
            $(window).scrollTop(position.top - 50);
        }
    });

    $("#toggleCart").click(function() {
        var position = $("#pcCart").offset();
        var sc = $(this).attr('sc');
        var scYN = $(this).attr('scYN');

        if (scYN === "Y") {
            $(window).scrollTop(parseInt(sc));
            $(this).attr('sc', '0');
            $(this).attr('scYN', 'N');
        } else {
            $(this).attr('sc', $(window).scrollTop());
            $(this).attr('scYN', 'Y');
            $(window).scrollTop(position.top);
        }
    });


});

$(document).on("click",
    "#ulCategory li",
    function() {
        $('#divCategory').html($(this).html());
    });

$(document).on("click",
    "#ulRegion li",
    function() {
        $('#divRegion').html($(this).html());
        $('#divLeague').html("<div style='display: table-cell; vertical-align: middle'>리그선택</div>");
    });

$(document).on("click",
    "#ulLeague li",
    function() {
        $('#divLeague').html($(this).html());
    });

$(document).on("click",
    "#ulToday li",
    function() {
        $('#divToday').html($(this).html());
        $('#divTodayLeague').html("<div style='display: table-cell; vertical-align: middle'>리그선택</div>");
    });

$(document).on("click",
    "#ulTodayLeague li",
    function() {
        $('#divTodayLeague').html($(this).html());
    });