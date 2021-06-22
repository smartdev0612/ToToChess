<!DOCTYPE html>
<html>
<head>
	<title>Powerball</title>
	<link rel="stylesheet" type="text/css" href="css/flex.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="/public/js/jquery-1.11.3.min.js" type="text/javascript"></script>
</head>
<body style="transform: scale(0.68); margin-left: -185px;">
	<div class="w90 h100 marginAuto flexCol jstCntntCenter body-container">
		<div class="flexRow w100 h30 jstCntntSB">
			<div>
				<!-- <a class="top-button marLR5x" href="http://nextgames.co.kr/" target="new">바로가기</a> -->
				<!-- <button class="top-button marLR5x">퍼가기</button> -->
			</div>
			<div class="color-white">
				<div class="logo-img"><img src="img/logo.png"></div>
				<div class="logo-tagline"><h3>5분 단위로 288회차 까지 실황 중계</h3></div>
			</div>
			<div>
				<!-- <button class="top-button marLR5x">게임설명</button>
				<button class="top-button marLR5x">소리켜기</button> -->
			</div>
		</div>
		<div class="flexRow w100 jstCntntSB Threebox-Bg">
			<div class="w30 posR">
				<div class="w100 posA flexCol alignCenter L-box">
					<div class="flexRow w65 jstCntntCenter"><h2></h2></div>
					<div class="flexRow w65 jstCntntCenter"><p style="font-size: 17px; line-height: 2.5">블록체인기반 5분 파워볼게임<br>전세계 수십만대 이상의 컴퓨터중 1대가 블록을 생성하므로 어떤 헤쉬값과 고유값을가진 블록이 생성될지 아무도 예측할수 없기때문에 절대 조작이 불가능한 게임 입니다.</p></div>
				</div>
			</div>
			<div class="w40 posR">
                <div id="running_result">
                </div>
				<div class="w100 posA flexRow jstCntntCenter box3">
					<div class="flexRow w80 jstCntntCenter"><h2 id="remainTime"></h2></div>
				</div>
				<div class="w60 posA flexRow box4">
					<div class="flexRow w40 jstCntntCenter green-bar" id="currentBar" style="width: 0px"></div>
				</div>
				<div class="w100 posA flexRow jstCntntCenter box5">
					<div class="flexRow w80 jstCntntCenter"><h4 id="curTime"></h4></div>
				</div>
				<div class="w100 posA flexRow jstCntntCenter box6">
					<div class="flexRow w80 jstCntntCenter"><a href="http://www.msgames.co.kr" target="wnd">www.msgames.co.kr</a></div>
				</div>
			</div>
			<div class="w30 posR">
                <div  id="current_result">
                </div>
				<div class="w70 posA S-box-2 marL57x">
				<div class="w95 flexCol " id="recent_result">
				</div>
				</div>
			</div>
		</div>
    </div>
    <script>
        var oldGameTh;
        var animate = true;
        function getResult() {
            $.get('/recent_result', function(res) {
                res = JSON.parse(res);
                window.latestRound = res[0].round;
                var htmlCode = '';
                for(var i = 0; i < res.length; i++) {
                    var strNOEColor = "blue";
                    if(res[i].strNOE == "짝") {
                        strNOEColor = "red";
                    }

                    var strNUOColor = "blue";
                    if(res[i].strNUO == "오버") {
                        strNUOColor = "red";
                    }

                    var strBMSColor = "blue";
                    if(res[i].strBMS == "소") {
                        strBMSColor = "green";
                    } else if(res[i].strBMS == "대") {
                        strBMSColor = "red";
                    }

                    var strPOEColor = "blue";
                    if(res[i].strPOE == "짝") {
                        strPOEColor = "red";
                    }

                    var strPUOColor = "blue";
                    if(res[i].strPUO == "오버") {
                        strPUOColor = "red";
                    }

                    
                    htmlCode += `<div class="flexcol w100 jstCntntCenter S-box-bottom ball-bg">
                                    <div><h2>` + res[i].date_round + ` 회차</h2></div>
                                    <div class="flexRow w100 jstCntntSE">
                                        <div class="ball-` + strPOEColor + ` ball-bg"><h1>` + res[i].strPOE + `</h1></div>
                                        <div class="ball-` + strPUOColor + ` ball-bg"><h1>` + res[i].strPUO + `</h1></div>
                                        <div class="ball-` + strBMSColor + ` ball-bg"><h1>` + res[i].strBMS + `</h1></div>
                                        <div class="ball-` + strNOEColor + ` ball-bg"><h1>` + res[i].strNOE + `</h1></div>
                                        <div class="ball-` + strNUOColor + ` ball-bg"><h1>` + res[i].strNUO + `</h1></div>
                                    </div>
                                    <div><h2>` + res[i].ball_1 + `,` + res[i].ball_2 + `,` + res[i].ball_3 + `,` + res[i].ball_4 + `,` + res[i].ball_5 + `,` + res[i].powerball + `</h2></div>
                                </div>`;
                }
                document.getElementById('recent_result').innerHTML = htmlCode;

                var strNOEColor = "blue";
                if(res[0].strNOE == "짝") {
                    strNOEColor = "red";
                }

                var strNUOColor = "blue";
                if(res[0].strNUO == "오버") {
                    strNUOColor = "red";
                }

                var strBMSColor = "blue";
                if(res[0].strBMS == "소") {
                    strBMSColor = "green";
                } else if(res[0].strBMS == "대") {
                    strBMSColor = "red";
                }

                var strPOEColor = "blue";
                if(res[0].strPOE == "짝") {
                    strPOEColor = "red";
                }

                var strPUOColor = "blue";
                if(res[0].strPUO == "오버") {
                    strPUOColor = "red";
                }
                
                htmlCode = `<div class="w100 posA flexRow jstCntntCenter S-box0">
                                <div class="flexRow w80 jstCntntCenter"><h2>` + res[0].date_round + ` 회차</h2></div>
                            </div>
                            <div class="w100 posA flexRow jstCntntCenter S-box1">
                                <div class="flexRow w70 jstCntntSB marL5x">
                                    <div class="ball-` + strPOEColor + ` ball-bg"><h1>` + res[0].strPOE + `</h1></div>
                                        <div class="ball-` + strPUOColor + ` ball-bg"><h1>` + res[0].strPUO + `</h1></div>
                                        <div class="ball-` + strBMSColor + ` ball-bg"><h1>` + res[0].strBMS + `</h1></div>
                                        <div class="ball-` + strNOEColor + ` ball-bg"><h1>` + res[0].strNOE + `</h1></div>
                                        <div class="ball-` + strNUOColor + ` ball-bg"><h1>` + res[0].strNUO + `</h1></div>
                                    </div>
                                </div>
                            </div>`;
                document.getElementById('current_result').innerHTML = htmlCode;

                htmlCode = `<div class="w100 posA flexRow jstCntntCenter box1">
                                <div class="flexRow w80 jstCntntCenter"><h2>` + res[0].date_round + ` 회차</h2></div>
                            </div>
                            <div class="w100 posA flexRow jstCntntCenter box2">
                                <div class="flexRow w80 jstCntntSB">
                                    <div class="ball-green ball-bg"><h1>` + res[0].ball_1 + `</h1></div>
                                        <div class="ball-red ball-bg"><h1>` + res[0].ball_2 + `</h1></div>
                                        <div class="ball-blue ball-bg"><h1>` + res[0].ball_3 + `</h1></div>
                                        <div class="ball-red ball-bg"><h1>` + res[0].ball_4 + `</h1></div>
                                        <div class="ball-yellow ball-bg"><h1>` + res[0].ball_5 + `</h1></div>
                                        <div class="ball-black ball-bg"><h1>` + res[0].powerball + `</h1></div>
                                    </div>
                                </div>
                            </div>`;
                document.getElementById('running_result').innerHTML = htmlCode;
            });
        }
        $(function() {
            getResult();
            setInterval(() => {
                $.get('/get_time', function(res) {
                    res = JSON.parse(res);

                    if(oldGameTh > 0 && (oldGameTh < res.gameTh || (oldGameTh == 288 && res.gameTh == 1))) {
                        getResult();
                    }

                    if(res.remain_time > 10) {
                        animate = true;
                    } else if(animate) {
                        animate = false;
                        var nRunRound = res.gameTh + 1;
                        if(nRunRound == 289) {
                            nRunRound = 1;
                        }
                        
                        htmlCode = `<div class="w100 posA flexRow jstCntntCenter box1">
                                        <div class="flexRow w80 jstCntntCenter"><h2>` + nRunRound + ` 회차</h2></div>
                                    </div>
                                    <div class="w100 posA flexRow jstCntntCenter box2">
                                        <div class="flexRow w80 jstCntntSB">
                                            <div><img src="img/ball.gif"></div>
                                            <div><img src="img/ballp.gif"></div>
                                            <div><img src="img/ball.gif"></div>
                                            <div><img src="img/ballp.gif"></div>
                                            <div><img src="img/ball.gif"></div>
                                            <div><img src="img/ballp.gif"></div>
                                        </div>
                                    </div>`;
                        document.getElementById('running_result').innerHTML = htmlCode;
                    }

                    document.getElementById('curTime').innerHTML = res.time;

                    var nCurRound = res.gameTh + 1;
                    if(nCurRound == 289) {
                        nCurRound = 1;
                    }
                    document.getElementById('remainTime').innerHTML = Math.floor(res.remain_time / 60) + `분 ` + (res.remain_time % 60) + `초 후, ` + nCurRound + `회차 추첨`;

                    document.getElementById('currentBar').style.width = Math.floor(res.remain_time / 3) + "%";

                    oldGameTh = res.gameTh;
                });
            }, 1000);
        });
    </script>
</body>
</html>