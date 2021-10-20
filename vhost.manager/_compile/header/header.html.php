<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>관리자 시스템</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="keywords" content="">
		<meta http-equiv="imagetoolbar" content="no">
		<meta name="robots" content="noindex, nofollow" />
		<meta name="googlebot" content="noindex, nofollow" />
		<link rel="shortcut icon" href="/img/favicon.ico">

		<link href="/css/default.css?v=<?php echo time();?>" rel="stylesheet" type="text/css" />

		<script src="/js/selectAll.js"></script>
		<script src="/js/js.js?v=<?=time();?>"></script>
		<script src="/js/is_show.js"></script>
		<script src="/js/lendar.js?v=<?=time();?>"></script>
		<script src="/js/common.js"></script>
		<script src="/js/jBeep.min.js" type="text/javascript"></script>
		<script src="/js/jquery-1.7.1.min.js"></script>
		
		<script language="javascript">
			function refreshSms() {
				var oBao=null;
				if(window.ActiveXObject) {
					oBao = new ActiveXObject("Microsoft.XMLHTTP");
				} else if(window.XMLHttpRequest) {
					oBao = new XMLHttpRequest();
				}

				oBao.open("POST","/etc/sms",false); 
				oBao.send(); 
				var rs = unescape(oBao.responseText);
			
				if ( rs > 0 ) {
					$("#ve").html("<div style='display:none;'><embed src='/voice/regcode.mp3' loop=false hidden='true' volume='100'></embed></div>");
				}
				$("#top_sms").html("<a href='/etc/smslist'>인증문자:("+rs+")건</a>");
			}
			
			function refreshContent() { 
				var oBao=null;
				if ( window.ActiveXObject ) {
					oBao = new ActiveXObject("Microsoft.XMLHTTP");
				} else if ( window.XMLHttpRequest ) {
					oBao = new XMLHttpRequest();
				}
			
				oBao.open("POST","/etc/refresh",false); 
				oBao.send(); 

				var strResult = unescape(oBao.responseText); 

				if ( strResult.length > 20 ) { 
					arrTmp = strResult.split("||");
					join_cnt = arrTmp[0];
					question_cnt = arrTmp[1];
					question_sn = arrTmp[2];
					recExchange_cnt = arrTmp[3];
					exchange_cnt = arrTmp[4];
					charge_cnt = arrTmp[5];
					content_cnt = arrTmp[6];
					newGame_cnt = arrTmp[7];
					newRate_cnt = arrTmp[8];
					newDate_cnt = arrTmp[9];
					newResult_cnt = arrTmp[10];
					sportBet_cnt = arrTmp[11];
					sportBet_m_cnt = arrTmp[51];
					liveBet_cnt = arrTmp[53];
					sadariBet_cnt = arrTmp[12];
					dariBet_cnt = arrTmp[13];
					raceBet_cnt = arrTmp[14];
					powerBet_cnt = arrTmp[15];
                    lowhiBet_cnt = arrTmp[16];
                    aladinBet_cnt = arrTmp[17];
                    mgmoddevenBet_cnt = arrTmp[18];
                    mgmbacaraBet_cnt = arrTmp[19];
					sportBetBig_cnt = arrTmp[20];
					sportBetBig_m_cnt = arrTmp[52];
					liveBetBig_cnt = arrTmp[54];
					sadariBetBig_cnt = arrTmp[21];
					dariBetBig_cnt = arrTmp[22];
					raceBetBig_cnt = arrTmp[23];
					powerBetBig_cnt = arrTmp[24];
                    lowhiBetBig_cnt = arrTmp[25];
                    aladinBetBig_cnt = arrTmp[26];
                    mgmoddevenBetBig_cnt = arrTmp[27];
                    mgmbacaraBetBig_cnt = arrTmp[28];
                    kenosadariBet_cnt = arrTmp[29];
                    kenosadariBetBig_cnt = arrTmp[30];
                    powersadariBet_cnt = arrTmp[31];
                    powersadariBetBig_cnt = arrTmp[32];
                    vfootballBet_cnt = arrTmp[33];
                    vfootballBetBig_cnt = arrTmp[34];
                    nineBet_cnt = arrTmp[35];
                    nineBetBig_cnt=arrTmp[36];
                    twodariBet_cnt=arrTmp[37];
                    twodariBetBig_cnt=arrTmp[38];
                    threedariBet_cnt=arrTmp[39];
                    threedariBetBig_cnt=arrTmp[40];
                    choiceBet_cnt=arrTmp[41];
                    choiceBetBig_cnt=arrTmp[42];
                    rouletteBet_cnt=arrTmp[43];
                    rouletteBetBig_cnt=arrTmp[44];
                    pharaohBet_cnt=arrTmp[45];
                    pharaohBetBig_cnt=arrTmp[46];
                    fxBet_cnt=arrTmp[47];
                    fxBetBig_cnt=arrTmp[48];

					connect_cnt = arrTmp[49];
                    login_fail_cnt = arrTmp[50];
                    total_user = arrTmp[51];
					partner_memo_cnt = arrTmp[55];
					agent_memo_cnt = arrTmp[56];
					realtimeBet_cnt = arrTmp[57];
                    realtimeBetBig_cnt = arrTmp[58];
				} else {
					return false;
				}

				// 현재 페지 경로
				var pathname = window.location.pathname;

				//-> 현재접속자수
				if ( connect_cnt > 0 ) {
					$("#connect_cnt").html("<font color='yellow' style='font-size:14px;'>"+connect_cnt+"</font>");
				} else {
					$("#connect_cnt").html("<font style='font-size:14px;'>"+connect_cnt+"</font>");
				}
                // 로그인 실패
                if(login_fail_cnt > 0)
                {
                    $("#login_fail").html("<font color='yellow' style='font-size:14px;'>"+login_fail_cnt+"</font>");
                } else {
                    $("#login_fail").html("<font style='font-size:14px;'>"+login_fail_cnt+"</font>");
                }

				//-> 입금신청
				if ( charge_cnt > 0 ) {
					if(pathname.indexOf("/charge/finlist_edit") == -1) {
						try { jBeep('/voice/in.mp3'); } catch(e) {};
					}
					$("#top_richer").html("<a href='/charge/finlist_edit'><font color='yellow' style='font-size:14px;'>입금신청["+charge_cnt+"]</font></a>");
				} else {
					$("#top_richer").html("<a href='/charge/finlist_edit'>입금신청[0]</a>");
				}

				//-> 출금신청
				if ( exchange_cnt > 0 ) {
					if(pathname.indexOf("/exchange/finlist_edit") == -1) {
						try { jBeep('/voice/out.mp3'); } catch(e) {};
					}
					$("#top_Withdrawal").html("<a href='/exchange/finlist_edit'><font color='yellow' style='font-size:14px;'>출금신청["+exchange_cnt+"]</font></a>");
				} else {
					$("#top_Withdrawal").html("<a href='/exchange/finlist_edit'>출금신청[0]</a>");
				}

				//-> 고객센터
				if ( question_cnt > 0 ) {
					if(pathname.indexOf("/board/questionview") == -1 || pathname.indexOf("/board/questionlist") == -1) {
						try { jBeep('/voice/center.mp3'); } catch(e) {};
					}
					$("#top_question").html("<a href='/board/questionview?idx="+question_sn+"'><font color='yellow' style='font-size:14px;'>고객센터["+question_cnt+"]</font></a>");
				} else {
					$("#top_question").html("<a href='/board/questionlist'>고객센터[0]</a>");
				}

				//-> 총판쪽지
				if ( partner_memo_cnt > 0 ) {
					if(pathname.indexOf("/partner/memolist") == -1) {
						try { jBeep('/voice/center.mp3'); } catch(e) {};
					}
					$("#top_partner").html("<a href='/partner/memolist?p_type=2'><font color='yellow' style='font-size:14px;'>총판쪽지["+partner_memo_cnt+"]</font></a>");
				} else {
					$("#top_partner").html("<a href='/partner/memolist?p_type=2'>총판쪽지[0]</a>");
				}

				//-> 부본사쪽지
				if ( agent_memo_cnt > 0 ) {
					if(pathname.indexOf("/partner/memolist") == -1) {
						try { jBeep('/voice/center.mp3'); } catch(e) {};
					}
					$("#top_agent").html("<a href='/partner/memolist?p_type=1'><font color='yellow' style='font-size:14px;'>부본사쪽지["+agent_memo_cnt+"]</font></a>");
				} else {
					$("#top_agent").html("<a href='/partner/memolist?p_type=1'>부본사쪽지[0]</a>");
				}
				
				//-> 회원가입
				if ( join_cnt > 0 ) {
					if(pathname.indexOf("/member/list") == -1) {
						try { jBeep('/voice/newmember.mp3'); } catch(e) {};
					}
					$("#top_newmember").html("<a href='/member/list?act=levelup'><font color='yellow' style='font-size:14px;'>회원가입["+join_cnt+"]</font></a>");
				} else {
					$("#top_newmember").html("<a href='/member/list?act=levelup'>회원가입[0]</a>");
				}

				//-> 총판출금
				if ( recExchange_cnt > 0 ) {
					if(pathname.indexOf("/partner/exchange_list") == -1) {
						try { jBeep('/voice/out.mp3'); } catch(e) {};
					}
					$("#top_rec_money_out").html("<a href='/partner/exchange_list'><font color='yellow' style='font-size:14px;'>총판출금["+recExchange_cnt+"]</font></a>");
				} else {
					$("#top_rec_money_out").html("<a href='/partner/exchange_list'>총판출금[0]</a>");
				}

				//-> 게시판
				if ( content_cnt > 0 ) {
					if(pathname.indexOf("/board/list") == -1) {
						try { jBeep('/voice/content.mp3'); } catch(e) {};
					}
					$("#top_contents").html("<a href='/board/list?province=5'><font color='yellow' style='font-size:14px;'>게시판["+content_cnt+"]</font></a>");
				} else {
					$("#top_contents").html("<a href='/board/list?province=5'>게시판[0]</a>");
				}

				//-> 파싱 = 등록/배당/일시/결과
				if( newGame_cnt > 0 ) {
					$("span[id=in_games]").html("<font color='yellow' style='font-size:14px;'>등록["+newGame_cnt+"]</font>");
				} else {
					$("span[id=in_games]").html("등록[0]");
				}
				if( newRate_cnt > 0 ) {
					$("span[id=in_rates]").html("<font color='yellow' style='font-size:14px;'>배당["+newRate_cnt+"]</font>");
				} else {
					$("span[id=in_rates]").html("배당[0]");
				}
				if( newDate_cnt > 0 ) {
					$("span[id=in_dates]").html("<font color='yellow' style='font-size:14px;'>일시["+newDate_cnt+"]</font>");
				} else {
					$("span[id=in_dates]").html("일시[0]");
				}
				if( newResult_cnt > 0 ) {
					$("span[id=in_results]").html("<font color='yellow' style='font-size:14px;'>결과["+newResult_cnt+"]</font>");
				} else {
					$("span[id=in_results]").html("결과[0]");
				}
				//if( newGame_cnt > 0 || newRate_cnt > 0 || newDate_cnt > 0 || newResult_cnt > 0 ) {
				//if( newGame_cnt > 0 || newRate_cnt > 0 || newDate_cnt > 0) {
                if( newRate_cnt > 0 || newDate_cnt > 0) {
					try { jBeep('/voice/tcall.mp3'); } catch(e) {};
				}
				//modified in 20170522
				else if ( newResult_cnt > 0 )
				{
					//try { jBeep('/voice/result.mp3'); } catch(e) {};
				}

				//-> 배팅 = 스포츠/사다리/다리/달팽이/파워볼
				if( sportBet_cnt > 0 || sportBetBig_cnt > 0 ) {
					if ( sportBetBig_cnt > 0 ) vColor = "#FFBB00";
					else vColor = "yellow";
					$("span[id=bet_sport]").html("<font color='"+vColor+"' style='font-size:14px;'>스포츠 ["+(Number(sportBet_cnt)+Number(sportBetBig_cnt))+"]</font>");
				} else {
					$("span[id=bet_sport]").html("스포츠 [0]");
				}

				//-> 배팅 = 스포츠/사다리/다리/달팽이/파워볼
				if( realtimeBet_cnt > 0 || realtimeBetBig_cnt > 0 ) {
					if ( realtimeBetBig_cnt > 0 ) vColor = "#FFBB00";
					else vColor = "yellow";
					$("span[id=bet_realtime]").html("<font color='"+vColor+"' style='font-size:14px;'>실시간 ["+(Number(realtimeBet_cnt)+Number(realtimeBetBig_cnt))+"]</font>");
				} else {
					$("span[id=bet_realtime]").html("실시간 [0]");
				}
 
				// -> 배팅 = 라이브
				if( liveBet_cnt > 0 || liveBetBig_cnt > 0 ) {
					if ( liveBet_cnt > 0 ) vColor = "#FFBB00";
					else vColor = "yellow";
					$("span[id=bet_live]").html("<font color='"+vColor+"' style='font-size:14px;'>라이브 ["+(Number(liveBet_cnt)+Number(liveBetBig_cnt))+"]</font>");
				} else {
					$("span[id=bet_live]").html("라이브 [0]");
				}

                if( vfootballBet_cnt > 0 || vfootballBetBig_cnt > 0 ) {
                    if ( vfootballBetBig_cnt > 0 ) vColor = "#FFBB00";
                    else vColor = "yellow";
                    $("span[id=bet_vfootball]").html("<font color='"+vColor+"' style='font-size:14px;'>가상축구["+(Number(vfootballBet_cnt)+Number(vfootballBetBig_cnt))+"]</font>");
                } else {
                    $("span[id=bet_vfootball]").html("가상축구[0]");
                }

				if( sadariBet_cnt > 0 || sadariBetBig_cnt > 0 ) {
					if ( sadariBetBig_cnt > 0 ) vColor = "#FFBB00";
					else vColor = "yellow";
					$("span[id=bet_sadari]").html("<font color='"+vColor+"' style='font-size:14px;'>사다리["+(Number(sadariBet_cnt)+Number(sadariBetBig_cnt))+"]</font>");
				} else {
					$("span[id=bet_sadari]").html("사다리[0]");
				}
				if( dariBet_cnt > 0 || dariBetBig_cnt > 0 ) {
					if ( dariBetBig_cnt > 0 ) vColor = "#FFBB00";
					else vColor = "yellow";
					$("span[id=bet_dari]").html("<font color='"+vColor+"' style='font-size:14px;'>다리다리["+(Number(dariBet_cnt)+Number(dariBetBig_cnt))+"]</font>");
				} else {
					$("span[id=bet_dari]").html("다리다리[0]");
				}
				if( raceBet_cnt > 0 || raceBetBig_cnt > 0 ) {
					if ( raceBetBig_cnt > 0 ) vColor = "#FFBB00";
					else vColor = "yellow";
					$("span[id=bet_rece]").html("<font color='"+vColor+"' style='font-size:14px;'>달팽이["+(Number(raceBet_cnt)+Number(raceBetBig_cnt))+"]</font>");
				} else {
					$("span[id=bet_rece]").html("달팽이[0]");
				}
				if( powerBet_cnt > 0 || powerBetBig_cnt > 0 ) {
					if ( powerBetBig_cnt > 0 ) vColor = "#FFBB00";
					else vColor = "yellow";
					$("span[id=bet_power]").html("<font color='"+vColor+"' style='font-size:14px;'>파워볼["+(Number(powerBet_cnt)+Number(powerBetBig_cnt))+"]</font>");
				} else {
					$("span[id=bet_power]").html("파워볼[0]");
				}

				if( lowhiBet_cnt > 0 || lowhiBetBig_cnt > 0 ) {
					if ( lowhiBetBig_cnt > 0 ) vColor = "#FFBB00";
					else vColor = "yellow";
					$("span[id=bet_lowhi]").html("<font color='"+vColor+"' style='font-size:14px;'>로하이["+(Number(lowhiBet_cnt)+Number(lowhiBetBig_cnt))+"]</font>");
				} else {
					$("span[id=bet_lowhi]").html("로하이[0]");
				}

                if( aladinBet_cnt > 0 || aladinBetBig_cnt > 0 ) {
                    if ( aladinBetBig_cnt > 0 ) vColor = "#FFBB00";
                    else vColor = "yellow";
                    $("span[id=bet_aladin]").html("<font color='"+vColor+"' style='font-size:14px;'>알라딘["+(Number(aladinBet_cnt)+Number(aladinBetBig_cnt))+"]</font>");
                } else {
                    $("span[id=bet_aladin]").html("알라딘[0]");
                }

                if( mgmoddevenBet_cnt > 0 || mgmoddevenBetBig_cnt > 0 ) {
                    if ( mgmoddevenBetBig_cnt > 0 ) vColor = "#FFBB00";
                    else vColor = "yellow";
                    $("span[id=bet_mgmoddeven]").html("<font color='"+vColor+"' style='font-size:14px;'>MGM홀짝["+(Number(mgmoddevenBet_cnt)+Number(mgmoddevenBetBig_cnt))+"]</font>");
                } else {
                    $("span[id=bet_mgmoddeven]").html("MGM홀짝[0]");
                }

                if( mgmbacaraBet_cnt > 0 || mgmbacaraBetBig_cnt > 0 ) {
                    if ( mgmbacaraBetBig_cnt > 0 ) vColor = "#FFBB00";
                    else vColor = "yellow";
                    $("span[id=bet_mgmbacara]").html("<font color='"+vColor+"' style='font-size:14px;'>MGM바카라["+(Number(mgmbacaraBet_cnt)+Number(mgmbacaraBetBig_cnt))+"]</font>");
                } else {
                    $("span[id=bet_mgmbacara]").html("MGM바카라[0]");
                }

                if( kenosadariBet_cnt > 0 || kenosadariBetBig_cnt > 0 ) {
                    if ( kenosadariBetBig_cnt > 0 ) vColor = "#FFBB00";
                    else vColor = "yellow";
                    $("span[id=bet_kenosadari]").html("<font color='"+vColor+"' style='font-size:14px;'>키노사다리["+(Number(kenosadariBet_cnt)+Number(kenosadariBetBig_cnt))+"]</font>");
                } else {
                    $("span[id=bet_kenosadari]").html("키노사다리[0]");
                }

                if( powersadariBet_cnt > 0 || powersadariBetBig_cnt > 0 ) {
                    if ( powersadariBetBig_cnt > 0 ) vColor = "#FFBB00";
                    else vColor = "yellow";
                    $("span[id=bet_powersadari]").html("<font color='"+vColor+"' style='font-size:14px;'>파워사다리["+(Number(powersadariBet_cnt)+Number(powersadariBetBig_cnt))+"]</font>");
                } else {
                    $("span[id=bet_powersadari]").html("파워사다리[0]");
                }

                if( nineBet_cnt > 0 || nineBetBig_cnt > 0 ) {
                    if ( nineBetBig_cnt > 0 ) vColor = "#FFBB00";
                    else vColor = "yellow";
                    $("span[id=bet_nine]").html("<font color='"+vColor+"' style='font-size:14px;'>나인["+(Number(nineBet_cnt)+Number(nineBetBig_cnt))+"]</font>");
                } else {
                    $("span[id=bet_nine]").html("나인[0]");
                }

                if( twodariBet_cnt > 0 || twodariBetBig_cnt > 0 ) {
                    if ( twodariBetBig_cnt > 0 ) vColor = "#FFBB00";
                    else vColor = "yellow";
                    $("span[id=bet_2dari]").html("<font color='"+vColor+"' style='font-size:14px;'>이다리["+(Number(twodariBet_cnt)+Number(twodariBetBig_cnt))+"]</font>");
                } else {
                    $("span[id=bet_2dari]").html("이다리[0]");
                }

                if( threedariBet_cnt > 0 || threedariBetBig_cnt > 0 ) {
                    if ( threedariBetBig_cnt > 0 ) vColor = "#FFBB00";
                    else vColor = "yellow";
                    $("span[id=bet_3dari]").html("<font color='"+vColor+"' style='font-size:14px;'>삼다리["+(Number(threedariBet_cnt)+Number(threedariBetBig_cnt))+"]</font>");
                } else {
                    $("span[id=bet_3dari]").html("삼다리[0]");
                }

                if( choiceBet_cnt > 0 || choiceBetBig_cnt > 0 ) {
                    if ( choiceBetBig_cnt > 0 ) vColor = "#FFBB00";
                    else vColor = "yellow";
                    $("span[id=bet_choice]").html("<font color='"+vColor+"' style='font-size:14px;'>초이스["+(Number(choiceBet_cnt)+Number(choiceBetBig_cnt))+"]</font>");
                } else {
                    $("span[id=bet_choice]").html("초이스[0]");
                }

                if( rouletteBet_cnt > 0 || rouletteBetBig_cnt > 0 ) {
                    if ( rouletteBetBig_cnt > 0 ) vColor = "#FFBB00";
                    else vColor = "yellow";
                    $("span[id=bet_roulette]").html("<font color='"+vColor+"' style='font-size:14px;'>룰렛["+(Number(rouletteBet_cnt)+Number(rouletteBetBig_cnt))+"]</font>");
                } else {
                    $("span[id=bet_roulette]").html("룰렛[0]");
                }

                if( pharaohBet_cnt > 0 || pharaohBetBig_cnt > 0 ) {
                    if ( pharaohBetBig_cnt > 0 ) vColor = "#FFBB00";
                    else vColor = "yellow";
                    $("span[id=bet_pharaoh]").html("<font color='"+vColor+"' style='font-size:14px;'>파라오["+(Number(pharaohBet_cnt)+Number(pharaohBetBig_cnt))+"]</font>");
                } else {
                    $("span[id=bet_pharaoh]").html("파라오[0]");
                }

                if( fxBet_cnt > 0 || fxBetBig_cnt > 0 ) {
                    if ( fxBetBig_cnt > 0 ) vColor = "#FFBB00";
                    else vColor = "yellow";
                    $("span[id=bet_fx]").html("<font color='"+vColor+"' style='font-size:14px;'>FX게임["+(Number(fxBet_cnt)+Number(fxBetBig_cnt))+"]</font>");
                } else {
                    $("span[id=bet_fx]").html("FX게임[0]");
                }

				if( sportBetBig_cnt > 0|| realtimeBetBig_cnt > 0 || liveBetBig_cnt > 0 || vfootballBetBig_cnt > 0) {
					try { jBeep('/voice/s_betting_big.mp3'); } catch(e) {};
				} else if ( sadariBetBig_cnt > 0 || dariBetBig_cnt > 0 || raceBetBig_cnt > 0 || powerBetBig_cnt > 0 ||
                    lowhiBetBig_cnt > 0 || aladinBetBig_cnt > 0 || mgmoddevenBetBig_cnt > 0 || mgmbacaraBetBig_cnt > 0 || nineBetBig_cnt > 0 ||
                    twodariBetBig_cnt > 0 || threedariBetBig_cnt > 0 || choiceBetBig_cnt > 0 || rouletteBetBig_cnt > 0 || pharaohBetBig_cnt > 0 || fxBetBig_cnt > 0) {
					try { jBeep('/voice/m_betting_big.mp3'); } catch(e) {};
				} else if( sportBet_cnt > 0 || realtimeBet_cnt > 0 || liveBet_cnt > 0 || vfootballBet_cnt > 0) {
					try { jBeep('/voice/s_betting.mp3'); } catch(e) {};
				} else if ( sadariBet_cnt > 0 || dariBet_cnt > 0 || raceBet_cnt > 0 || powerBet_cnt > 0 || lowhiBet_cnt > 0 ||
                    aladinBet_cnt > 0 || mgmoddevenBet_cnt > 0 || mgmbacaraBet_cnt > 0 || nineBet_cnt > 0 ||
                    twodariBet_cnt > 0 || threedariBet_cnt > 0 || choiceBet_cnt > 0 || rouletteBet_cnt > 0 || pharaohBet_cnt > 0 || fxBet_cnt > 0) {
					try { jBeep('/voice/m_betting.mp3'); } catch(e) {};
				}
			}
			
			function GameFinTimer() {
				var oBao=null;
				if(window.ActiveXObject) {
					oBao = new ActiveXObject("Microsoft.XMLHTTP");
				} else if(window.XMLHttpRequest) {
					oBao = new XMLHttpRequest();
				}

				oBao.open("POST","/etc/GameFinProcess",false); 
				oBao.send(); 

				var strResult = unescape(oBao.responseText); 
			}

			function beginTimer() { 
<?php if ( $_SESSION['member']['sn'] < 1000 ) { ?>
				timer = window.setInterval("refreshContent()",5000);
				timer = window.setInterval("GameFinTimer()",6000*3);
<?php }?>
			}
		</script>
	</head>