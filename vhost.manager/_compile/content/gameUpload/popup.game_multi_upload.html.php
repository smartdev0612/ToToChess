<?php
$TPL_category_list_1=empty($TPL_VAR["category_list"])||!is_array($TPL_VAR["category_list"])?0:count($TPL_VAR["category_list"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);
$page = $TPL_VAR['page'];
?>

<script src="/js/jquery-1.7.1.min.js"></script>
<script>
    String.prototype.Trim = function() { return this.replace(/(^\s*)|(\s*$)/g, ""); }
    var rowIndex=1;
    var select_obj=0;
    var now_page = <?php echo $page?>;

    $(document).ready(function () {
        setTimeout(function(){
            refreshBetList();
        },10000);
    });

    function refreshBetList() {
        var param = {
            "page": now_page,
            "perpage": $('#perpage').val(),
            "state": $('input[name ="state"]').val(),
            "parsing_type": $('select[name ="search_parsing_type"]').val(),
            "special_type": $('select[name ="search_special_type"]').val(),
            "game_type": $('select[name ="search_game_type"]').val(),
            "categoryName": $('select[name ="search_categoryName"]').val(),
            "league_sn": $('select[name ="search_league_sn"]').val(),
            "begin_date":$('#begin_date').val(),
            "end_date":$('#end_date').val(),
            "filter_team_type":$('select[name ="filter_team_type"]').val(),
            "filter_team":$('select[name ="filter_team"]').val(),
            "sort":$('input[name ="sort"]').val()
        }

        $.ajax({
            url : "/gameUpload/refreshBetList",
            type : "post",
            cache : false,
            async : true,
            timeout : 5000,
            scriptCharset : "utf-8",
            data: param,
            dataType : "json",
            success: function(res) {
                if ( typeof(res) == "object" ) {
                    refreshBetResult(res['bet_list']);
                }
            },
            error: function(xhr,status,error) {
                alert("처리중 오류가 발생 되었습니다. 관리자에게 문의해주세요.");
            }
        });

        // 업데이트 주기(5초)
        setTimeout(function(){
            refreshBetList();
        },10000);
    }

    function refreshBetResult(betlist)
    {
        for ( var key in  betlist ) {
            var item = betlist[key];
            var home_total_betting = item['home_total_betting'];
            var draw_total_betting = item['draw_total_betting'];
            var away_total_betting = item['away_total_betting'];
            var total_betting = parseInt(home_total_betting) + parseInt(draw_total_betting) + parseInt(away_total_betting);

            $('#h_t_b_'+key).html(number_format(home_total_betting));
            $('#d_t_b_'+key).html(number_format(draw_total_betting));
            $('#a_t_b_'+key).html(number_format(away_total_betting));
            $('#t_t_b_'+key).html(number_format(total_betting));
        }
    }

    function number_format(str) {
        str += "";
        var objRegExp = new RegExp('(-?[0-9]+)([0-9]{3})');
        while (objRegExp.test(str)) {
            str = str.replace(objRegExp, '$1,$2');
        }
        return str;
    }

    function save()
    {
        var leagueObj = document.getElementsByName('league[]');
        var gameDateObj = document.getElementsByName('gameDate[]');
        var homeTeamObj = document.getElementsByName('HomeTeam[]');
        var awayTeamObj = document.getElementsByName('AwayTeam[]');
        var typeAObj = document.getElementsByName('type_a[]');
        var typeBObj = document.getElementsByName('type_b[]');
        var typeCObj = document.getElementsByName('type_c[]');

        if(leagueObj.length==0)
        {
            alert("경기정보가 없습니다");
            return false;
        }

        var gameCount = 0;
        for(var i=0;i<leagueObj.length;i++)
        {
            var league = leagueObj[i].value;
            var gameDate = gameDateObj[i].value;
            var homeTeam = homeTeamObj[i].value;
            var awayTeam = awayTeamObj[i].value;
            var homeRate = typeAObj[i].value;
            var drawRate = typeBObj[i].value;
            var awayRate = typeCObj[i].value;

            var paramAll = league+gameDate+homeTeam+awayTeam+homeRate+drawRate+awayRate;
            if(paramAll == '')
                continue;

            if(leagueObj[i].value=="")
            {
                alert("리그를 선택하세요");
                leagueObj[i].focus();
                leagueObj[i].style.backgroundColor = "#EFEFEF";
                return false;
                break;
            }

            if(gameDateObj[i].value=="")
            {
                alert("날자를 입력하세요");
                gameDateObj[i].focus();
                gameDateObj[i].style.backgroundColor = "#EFEFEF";
                return false;
                break;
            }

            if(homeTeamObj[i].value=="")
            {
                alert("홈팀이름을 입력하세요");
                homeTeamObj[i].focus();
                homeTeamObj[i].style.backgroundColor = "#EFEFEF";
                return false;
                break;
            }

            if(awayTeamObj[i].value==""){
                alert("원정팀이름을 입력하세요");
                awayTeamObj[i].focus();
                awayTeamObj[i].style.backgroundColor = "#EFEFEF";
                return false;
                break;
            }

            if(typeAObj[i].value==""){
                alert("승배당을 입력하세요");
                typeAObj[i].focus();
                typeAObj[i].style.backgroundColor = "#EFEFEF";
                return false;
                break;
            }

            if(typeBObj[i].value==""){
                alert("무배당을 입력하세요");
                typeBObj[i].focus();
                typeBObj[i].style.backgroundColor = "#EFEFEF";
                return false;
                break;
            }

            if(typeCObj[i].value==""){
                alert("패배당을 입력하세요");
                typeCObj[i].focus();
                typeCObj[i].style.backgroundColor = "#EFEFEF";
                return false;
                break;
            }
            gameCount++;
        }

        if(gameCount == 0)
        {
            alert("경기정보가 없습니다");
            return false;
        }
    }


    function listupLeague(obj)
    {
        if( obj==null)
            return;

        $.ajaxSetup({async:false});

        if(obj!=null)	var param={category:obj.value};
        else					var param={category:""};

        select_obj=obj;
        console.log(obj);
        console.log(param);

        $.post("/league/ajaxLeagueList?", param, onListupLeague, "json");
    }

    function onListupLeague(jsonText)
    {
        var innerHTML ="<option value=''>리그선택</option>";
        /*
          for(i=0; i<jsonText.length; ++i)
          {
              var data = jsonText[i];
              innerHTML += "<option value="+data.sn+">"+data.name+"</option>";
          }
          */

        var object = document.getElementsByName("kind[]")

        for(var i=0;i<object.length;i++)
        {
            if(object[i]==select_obj)
            {
                var game_type_object = document.getElementsByName("gametype[]");
                console.log(game_type_object);
                while(game_type_object[i].options.length > 0)
                    game_type_object[i].options.remove(0);

                var options = "";
                switch(select_obj.value) 
                {
                    case "축구":           //축구
                        game_type_object[i].add(new Option("지정안함", ""));
                        game_type_object[i].add(new Option("승패", "1"));
                        game_type_object[i].add(new Option("핸디캡", "2"));
                        game_type_object[i].add(new Option("언더오버", "3"));
                        game_type_object[i].add(new Option("승무패", "4"));
                        game_type_object[i].add(new Option("전반전 승무패", "5"));
                        game_type_object[i].add(new Option("후반전 승무패", "6"));
                        game_type_object[i].add(new Option("전반전 언더오버", "7"));
                        game_type_object[i].add(new Option("후반전 언더오버", "8"));
                        game_type_object[i].add(new Option("득점홀짝", "9"));
                        game_type_object[i].add(new Option("전반전 홀짝", "10"));
                        game_type_object[i].add(new Option("핸디캡 추가기준점", "11"));
                        game_type_object[i].add(new Option("언더오버 추가기준점", "12"));
                        game_type_object[i].add(new Option("정확한 스코어", "13"));
                        break;
                    case "농구":           //농구
                        game_type_object[i].add(new Option("지정안함", ""));
                        game_type_object[i].add(new Option("승패", "1"));
                        game_type_object[i].add(new Option("핸디캡", "2"));
                        game_type_object[i].add(new Option("언더오버", "3"));
                        game_type_object[i].add(new Option("1쿼터 승무패", "4"));
                        game_type_object[i].add(new Option("2쿼터 승무패", "5"));
                        game_type_object[i].add(new Option("3쿼터 승무패", "6"));
                        game_type_object[i].add(new Option("4쿼터 승무패", "7"));
                        game_type_object[i].add(new Option("1쿼터 핸디캡", "8"));
                        game_type_object[i].add(new Option("2쿼터 핸디캡", "9"));
                        game_type_object[i].add(new Option("3쿼터 핸디캡", "10"));
                        game_type_object[i].add(new Option("4쿼터 핸디캡", "11"));
                        game_type_object[i].add(new Option("1쿼터 언더오버", "12"));
                        game_type_object[i].add(new Option("2쿼터 언더오버", "13"));
                        game_type_object[i].add(new Option("3쿼터 언더오버", "14"));
                        game_type_object[i].add(new Option("4쿼터 언더오버", "15"));
                        game_type_object[i].add(new Option("핸디캡 추가기준점", "16"));
                        game_type_object[i].add(new Option("언더오버 추가기준점", "17"));
                        break;
                    case "배구":           //배구
                        game_type_object[i].add(new Option("지정안함", ""));
                        game_type_object[i].add(new Option("승패", "1"));
                        game_type_object[i].add(new Option("핸디캡", "2"));
                        game_type_object[i].add(new Option("언더오버", "3"));
                        game_type_object[i].add(new Option("홀짝", "4"));
                        game_type_object[i].add(new Option("1세트 홀짝", "5"));
                        game_type_object[i].add(new Option("정확한 스코어", "6"));
                        break;
                    case "야구":           //야구
                        game_type_object[i].add(new Option("지정안함", ""));
                        game_type_object[i].add(new Option("승패", "1"));
                        game_type_object[i].add(new Option("핸디캡", "2"));
                        game_type_object[i].add(new Option("언더오버", "3"));
                        game_type_object[i].add(new Option("1이닝 승무패", "4"));
                        game_type_object[i].add(new Option("3이닝 합계 핸디캡", "5"));
                        game_type_object[i].add(new Option("5이닝 합계 핸디캡", "6"));
                        game_type_object[i].add(new Option("7이닝 합계 핸디캡", "7"));
                        game_type_object[i].add(new Option("3이닝 합계 언더오버", "8"));
                        game_type_object[i].add(new Option("5이닝 합계 언더오버", "9"));
                        game_type_object[i].add(new Option("7이닝 합계 언더오버", "10"));
                        game_type_object[i].add(new Option("핸디캡 추가기준점", "11"));
                        game_type_object[i].add(new Option("언더오버 추가기준점", "12"));
                        break;
                    case "하키":           //하키
                        game_type_object[i].add(new Option("지정안함", ""));
                        game_type_object[i].add(new Option("승패", "1"));
                        game_type_object[i].add(new Option("핸디캡", "2"));
                        game_type_object[i].add(new Option("언더오버", "3"));
                        game_type_object[i].add(new Option("승무패", "4"));
                        game_type_object[i].add(new Option("1피리어드 승패", "5"));
                        game_type_object[i].add(new Option("1피리어드 승무패", "6"));
                        game_type_object[i].add(new Option("1피리어드 핸디캡", "7"));
                        game_type_object[i].add(new Option("1피리어드 언더오버", "8"));
                        break;
                    case "이벤트":           //보너스배당
                        game_type_object[i].add(new Option("승무패", "1"));
                        break;
                }

                var league_object = document.getElementsByName("league[]");

                while(league_object[i].options.length > 0)
                    league_object[i].options.remove(0);

                if(jsonText!=null)
                {
                    for(j=0; j<jsonText.length; ++j)
                    {
                        var data = jsonText[j];
                        league_object[i].add(new Option(data.name, data.sn));
                    }
                }
                break;
            }
        }

        return true;
    }

    function onCopy(obj, special_type_index, game_type_index)
    {
        var clickedRow =$(obj).parent().parent();
        var newRow = clickedRow.clone();

        // 종목
        var selected_value = $('#kind option:selected').val();
        newRow.find('#kind').val(selected_value);

        // 일반,스페셜,라이브배팅
        if( special_type_index==-1)
        {
            selected_value = $('#special_type option:selected').val();
            newRow.find('#special_type').val(selected_value);
        }
        else
        {
            selected_value = $('#special_type option:eq('+special_type_index+')').val();
            newRow.find('#special_type').val(selected_value);
        }
        // 승무패, 핸디캡, 언더오버
        if( game_type_index==-1)
        {
            selected_value = $('#game_type option:selected').val();
            newRow.find('#game_type').val(selected_value);
        }
        else
        {
            selected_value = $('#game_type option:eq('+game_type_index+')').val();
            newRow.find('#game_type').val(selected_value);
        }

        selected_value = $('#league option:selected').val();
        newRow.find('#league').val(selected_value);

        selected_value = $('#game_hour option:selected').val();
        newRow.find('#game_hour').val(selected_value);

        selected_value = $('#game_time option:selected').val();
        newRow.find('#game_time').val(selected_value);
        //select copy - end

        newRow.insertAfter(clickedRow);
        return newRow;
    }

    function onDeleteRow(obj)
    {
        var clickedRow =$(obj).parent().parent();
        clickedRow.remove();
    }

    function onCopyAll(obj)
    {
        //라이브 - 승무패, 핸디, 언더오버

        newRow = onCopy(obj, 2, 3);
        obj=newRow.find('#type_copy').context;

        newRow = onCopy(obj, 2, 2);
        obj=newRow.find('#type_copy').context;

        newRow = onCopy(obj, 2, 1);
        obj=newRow.find('#type_copy').context;

        //스페셜 - 승무패, 핸디, 언더오버
        newRow = onCopy(obj, 1, 3);
        obj=newRow.find('#type_copy').context;

        newRow = onCopy(obj, 1, 2);
        obj=newRow.find('#type_copy').context;

        newRow = onCopy(obj, 1, 1);
        obj=newRow.find('#type_copy').context;

        //일   반 - 핸디, 언더오버
        newRow = onCopy(obj, 0, 3);
        obj=newRow.find('#type_copy').context;

        newRow = onCopy(obj, 0, 2);
        obj=newRow.find('#type_copy').context;
    }

</script>
<script>
    function select_delete()
    {
        var subchild_sn="";
        var sn = document.getElementsByName("subchild_sn[]");

        for(i=0;i<sn.length;i++)
        {
            if(sn[i].checked==true)
            {
                if($('#state_'+sn[i].value).val()!=-1)
                {
                    alert("대기중인 게임만 삭제가능합니다.");
                    return;
                }
                subchild_sn += sn[i].value+"\,";
            }
        }
        if(subchild_sn.length>0)
        {
            if ( confirm("정말 삭제하시겠습니까?") ) {
                subchild_sn=subchild_sn.substring(0,(subchild_sn.length)-1);
                param="subchild_sn="+subchild_sn+"&act=delete_game&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&special_type=<?php echo $TPL_VAR["special_type"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>";
                document.location="/gameUpload/popup_gameMultiUpload?"+param;
            } else {
                return;
            }
        }
        else
        {
            alert("경기를 선택!");
            return;
        }
    }

    function select_modify_rate() {
        var subchild_sn="";
        var sn = document.getElementsByName("subchild_sn[]");
        for(i=0;i<sn.length;i++)
        {
            if(sn[i].checked==true)
            {
                if($('#state_'+sn[i].value).val()!=-1 && $('#state_'+sn[i].value).val()!=0)
                {
                    alert("완료된 게임은 배당변경이 불가합니다.");
                    return;
                }
                subchild_sn += sn[i].value+"\,";
            }
        }

        if(subchild_sn.length>0)
        {
            state = "rateUpdate";
            act = "modify_state";
            subchild_sn=subchild_sn.substring(0,(subchild_sn.length)-1);

            if ( confirm("선택한 경기를 [배당변경] 하시겠습니까?") ) {
                param="subchild_sn="+subchild_sn+"&new_state="+state+"&act="+act+"&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&special_type=<?php echo $TPL_VAR["special_type"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>";
                if ( state == "rateUpdate" ) {
                    document.location="/gameUpload/popup_gameMultiUpload?"+param+"&page="+<?php echo $TPL_VAR["page"]?>;
                } else {
                    document.location="/gameUpload/popup_gameMultiUpload?"+param;
                }
            } else {
                return;
            }
        }
        else
        {
            alert("배당을 변경하실 경기를 선택하세요.");
            return;
        }
    }

    function select_modify_state()
    {
        var subchild_sn="";
        var sn = document.getElementsByName("subchild_sn[]");

        state=$('#select_state').val();

        for(i=0;i<sn.length;i++)
        {
            if(sn[i].checked==true)
            {
                if(state != 2)
                {
                    if($('#state_'+sn[i].value).val()!=-1 && $('#state_'+sn[i].value).val()!=0)
                    {
                        alert("완료된 게임은 상태변경이 불가합니다.");
                        return;
                    }
                }

                subchild_sn += sn[i].value+"\,";
            }
        }

        if(subchild_sn.length>0)
        {
            subchild_sn=subchild_sn.substring(0,(subchild_sn.length)-1);
            if ( state == 0 ) alertTitle = "[발매]로";
            else if ( state == -1 ) alertTitle = "[대기]로";
            else if ( state == 1 ) alertTitle = "[마감]으로";
            else if ( state == 2 ) alertTitle = "[차단]으로";
            else alertTitle = "[배당]을";

            var act = "";
            if ( state == 1 ) act = "deadline_game";
            else act = "modify_state";

            if ( confirm("정말 "+alertTitle+" 변경하시겠습니까?") ) {
                if ( state == 1 ) {
                    if ( !confirm("---------------- 경 고 ------------------\n\n정말 [ 마 감 ]으로 변경하시겠습니까?") ) {
                        return;
                    }
                }
                param="subchild_sn="+subchild_sn+"&new_state="+state+"&act="+act+"&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&special_type=<?php echo $TPL_VAR["special_type"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>";
                if ( state == "rateUpdate" ) {
                    document.location="/gameUpload/popup_gameMultiUpload?"+param+"&page="+<?php echo $TPL_VAR["page"]?>;
                } else {
                    document.location="/gameUpload/popup_gameMultiUpload?"+param;
                }
            } else {
                return;
            }
        }
        else
        {
            alert("경기를 선택!");
            return;
        }
    }

    function select_all()
    {
        var check_state = document.form1.check_all.checked;
        for (i=0;i<document.all.length;i++)
        {
            if (document.all[i].name=="subchild_sn[]")
            {
                document.all[i].checked = check_state;
            }
            if (document.all[i].name=="subchild_sn_back[]")
            {
                document.all[i].checked = check_state;
            }
        }
    }

    function select_to(obj) {
        if ( $(obj).attr("checked") == "checked" ) {
            $(obj).parent("td").parent("tr").find("input[name^=subchild_sn]").prop("checked",true);
        } else {
            $(obj).parent("td").parent("tr").find("input[name^=subchild_sn]").prop("checked",false);
        }
    }

    function team_betting(url)
    {
        window.open(url,'','resizable=no width=520 height=210');

    }
    function team_betting2(url)
    {
        window.open(url,'','resizable=no width=520 height=240');
    }
    function onDelete(subchild_sn)
    {
        if(confirm("정말 삭제하시겠습니까?  "))
        {
            param="subchild_sn="+subchild_sn+"&act=delete_game&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&special_type=<?php echo $TPL_VAR["special_type"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>";
            document.location="/gameUpload/popup_gameMultiUpload?"+param;
        }
        else
        {
            return;
        }
    }

    function onApply(subchild_sn)
    {
        var gameDate = $('#game_date_'+subchild_sn).val();
        var gameHour = $('#game_hour_'+subchild_sn).val();
        var gameTime = $('#game_time_'+subchild_sn).val();
        var homeRate = $('#home_rate_'+subchild_sn).val();
        var drawRate = $('#draw_rate_'+subchild_sn).val();
        var awayRate = $('#away_rate_'+subchild_sn).val();
        var homeScore = $('#home_score_'+subchild_sn).val();
        var awayScore = $('#away_score_'+subchild_sn).val();


        if(confirm("적용하시겠습니까?"))
        {
            param="subchild_sn="+subchild_sn+"&act=apply&gameDate="+gameDate+"&gameHour="+gameHour+"&gameTime="+gameTime+"&homeRate="+homeRate+
                "&drawRate="+drawRate+"&awayRate="+awayRate+"&homeScore="+homeScore+"&awayScore="+awayScore;
            document.location="/gameUpload/gameUpdateProcess?"+param;
        }
        else
        {
            return;
        }
    }

    function onDeleteDB(subchild_sn)
    {
        if(confirm("정말 삭제하시겠습니까?  "))
        {
            param="subchild_sn="+subchild_sn+"&act=delete_game_db&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&special_type=<?php echo $TPL_VAR["special_type"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>";
            document.location="/gameUpload/popup_gameMultiUpload?"+param;
        }
        else
        {
            return;
        }
    }
    function go_rollback(url)
    {
        if(confirm("게임결과와 배당지급이 취소됩니다. 진행하시겠습니까?  "))
        {
            param="act=delete_game&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&special_type=<?php echo $TPL_VAR["special_type"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>&page=<?php echo $TPL_VAR["page"]?>";
            document.location = url+"&"+param;
        }
        else
        {
            return;
        }
    }

    function onCheckbox(frm)
    {
        if(frm.money_option.checked==true)
        {
            frm.money_option.value=1
        }
        else
            frm.money_option.value=0
        frm.submit();
    }

    function onStateChange(subchild_sn)
    {
        var state=$('#state_'+subchild_sn).val();

        if(state == 2)
        {
            onDeadLine(subchild_sn);
        } else {
            param="subchild_sn="+subchild_sn+"&new_state="+state+"&act=modify_state&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&special_type=<?php echo $TPL_VAR["special_type"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>";
            document.location="/gameUpload/popup_gameMultiUpload?"+param;
        }
    }

    function onDeadLine(subchild_sn)
    {
        if(confirm("게임시간을 변경 하시겠습니까?"))
        {
            param="subchild_sn="+subchild_sn+"&act=deadline_game&state=<?php echo $TPL_VAR["state"]?>&game_type=<?php echo $TPL_VAR["gameType"]?>&categoryName=<?php echo $TPL_VAR["categoryName"]?>&special_type=<?php echo $TPL_VAR["special_type"]?>&perpage=<?php echo $TPL_VAR["perpage"]?>&begin_date=<?php echo $TPL_VAR["begin_date"]?>&end_date=<?php echo $TPL_VAR["end_date"]?>&filter_team_type=<?php echo $TPL_VAR["filter_team_type"]?>&filter_team=<?php echo $TPL_VAR["filter_team"]?>&money_option=<?php echo $TPL_VAR["money_option"]?>&page=<?php echo $TPL_VAR["page"]?>";
            document.location="/gameUpload/popup_gameMultiUpload?"+param;
        }
        else
        {
            return;
        }
    }

    function sortByDate()
    {
        var sort = document.frmSrh.sort.value;
        if(sort == 'asc' || sort == '')
        {
            document.frmSrh.sort.value="desc";
        } else {
            document.frmSrh.sort.value="asc";
        }

        document.frmSrh.submit();
    }

</script>
</head>

<body onload="listupLeague(null);">

<div id="wrap_pop">
    <div id="betting_2">
        <ul id="tab">
            <li><a href="/gameUpload/popup_gameupload?state=0" id="sport_1">스포츠 I</a></li>
            <li><a href="/gameUpload/popup_gameMultiUpload?state=0" id="sport_2">스포츠 II</a></li>
        </ul>
    </div>
    <div id="pop_title">
        <h1>경기등록</h1><p><a href="#"><img src="/img/btn_s_close.gif" onclick="self.close();"></a></p>
    </div>

    <form name="form1" method="post" action="/gameUpload/gameMultiUploadProcess" onsubmit="return save()">
        <input type="hidden" name="pidx" value="<?php echo $TPL_VAR["pidx"]?>">
        <table id="table_list" cellspacing="1" class="tableStyle_normal">
            <thead>
            <tr>
                <th>종목</th>
                <th>배팅방식</th>
                <th>리그선택</th>
                <th>경기일시</th>
                <th>홈팀</th>
                <th>원정팀</th>
                <th>승배당</th>
                <th>무배당</th>
                <th>패배당</th>
                <th>관리</th>
            </tr>
            </thead>
            <tbody>
            <?php for($i=0; $i<10; $i++) {?>
                <tr>
                    <td>
                        <select name='kind[]' align='center' onChange="listupLeague(this);" id='kind'>
                            <option value=''>종목선택</option>
                            <?php if($TPL_category_list_1){foreach($TPL_VAR["category_list"] as $TPL_V1){?>
                                <option value="<?php echo $TPL_V1["name"]?>" <?php if($TPL_VAR["select_category"]==$TPL_V1["name"]){?> selected<?php }?>><?php echo $TPL_V1["name"]?></option>
                            <?php }}?>
                        </select>
                    </td>
                    <td>
                        <select name='gametype[]' align='center' id='game_type'>
                            <option value='0'>지정안함</option>
                        </select>
                    </td>
                    <td>
                        <select name="league[]" id='league'>
                        </select>
                    </td>
                    <td><input type="text" id="gameDate" name="gameDate[]" size="10" maxlength="10" onclick="new Calendar().show(this);"  readonly="readonly" style="border:1px #97ADCE solid;">&nbsp;<?php echo $TPL_VAR["gameHour"]?><?php echo $TPL_VAR["gameTime"]?></td>
                    <td><input type="text" id="HomeTeam" name="HomeTeam[]" size="11"></td>
                    <td><input type="text" id="AwayTeam" name="AwayTeam[]" size="11"></td>
                    <td><input type="text" id="type_a" name="type_a[]" size="5" onkeyup='this.value=this.value.replace(/[^0-9.]/gi,"")'></td>
                    <td><input type="text" id="type_b" name="type_b[]" size="5"></td>
                    <td><input type="text" id="type_c" name="type_c[]" size="5" onkeyup='this.value=this.value.replace(/[^0-9.]/gi,"")'></td>
                    <td>
                        <input name='del' type='button' id='del' value='삭제' class="btnStyle3" onClick="onDeleteRow(this);">
                        <input name='copy' type='button' id='copy' value='복사' class="btnStyle3" onClick="onCopy(this, -1, -1)">
                        <!--<input name='type_copy' type='button' id='type_copy' value='타입복사' onClick="onCopyAll(this);" class="btnStyle3">-->
                    </td>
                </tr>
            <?php }?>
            <tr class="gameAdd">
                <td colspan="11">
                    <input type="checkbox" name="kubun" value="0">&nbsp;&nbsp;발매&nbsp;&nbsp;
                    <p class="btn"><input name="submit" type="submit" value="경기올리기" class="Qishi_submit_a"></p>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>

<div id="search">
    <div class="wrap_search">
        <form name=frmSrh method=post action="/gameUpload/popup_gameMultiUpload">
            <input type="hidden" name="search" value="search">
            <input type="hidden" name="category_name" value="">
            <input type="hidden" name="sort" value="<?php echo $TPL_VAR["sort"]; ?>">

            <span>출력</span>
            <input name="perpage" type="text" id="perpage"  class="sortInput" onkeyup="if(event.keyCode !=37 && event.keyCode != 39) value=value.replace(/\D/g,'');" maxlength="3" size="5" value="<?php echo $TPL_VAR["perpage"]?>" onmouseover="this.focus()">

            <span>설정</span>
            <input type="radio" name="state" value=0 <?php if($TPL_VAR["state"]==0){?>checked<?php }?> class="radio" >전체
            <input type="radio" name="state" value=1 <?php if($TPL_VAR["state"]==1){?>checked<?php }?> class="radio">종료
            <input type="radio" name="state" value=20 <?php if($TPL_VAR["state"]==20){?>checked<?php }?> class="radio">발매(배팅가능)
            <input type="radio" name="state" value=21 <?php if($TPL_VAR["state"]==21){?>checked<?php }?> class="radio">발매(배팅마감)
            <input type="radio" name="state" value=3 <?php if($TPL_VAR["state"]==3){?>checked<?php }?> class="radio">대기
            <input type="checkbox" name="modifyFlag" <?php if($TPL_VAR["modifyFlag"]===0){?>checked<?php }?> > 경기수정
            &nbsp;
            <span class="icon">정렬</span>
            <select name="search_parsing_type">
                <option value="ALL" <?php if($TPL_VAR["parsing_type"]=="ALL"){?> selected <?php }?>>전체</option>
                <option value="A" <?php if($TPL_VAR["parsing_type"]=="A"){?> selected <?php }?>>경기A타입</option>
                <option value="S" <?php if($TPL_VAR["parsing_type"]=="S"){?> selected <?php }?>>경기S타입</option>
            </select>

            <select name="search_game_type">
                <option value="">종류</option>
                <option value="1" <?php if($TPL_VAR["gameType"]==1){?> selected <?php }?>>승패</option>
                <option value="2" <?php if($TPL_VAR["gameType"]==2){?> selected <?php }?>>핸디캡</option>
                <option value="3" <?php if($TPL_VAR["gameType"]==4){?> selected <?php }?>>언더오버</option>
            </select>

            <select name="search_categoryName" style="display: none">
                <option value="">종목</option>
                <?php if($TPL_categoryList_1){foreach($TPL_VAR["categoryList"] as $TPL_V1){?>
                    <option value="<?php echo $TPL_V1["name"]?>" <?php if($TPL_VAR["categoryName"]==$TPL_V1["name"]){?> selected <?php }?>><?php echo $TPL_V1["name"]?></option>
                <?php }}?>
            </select>
            <select name="search_league_sn" style="display: none">
                <option value="">리그</option>
                <?php
                if ( count($TPL_VAR["league_list"]) > 0 ) {
                    foreach ( $TPL_VAR["league_list"] as $leagueInfo ) {
                        if ( $TPL_VAR["league_sn"] == $leagueInfo['league_sn'] ) $selected = "selected";
                        else $selected = "";
                        if ( !trim($leagueInfo['alias_name']) ) $league_name = $leagueInfo['league_name'];
                        else $league_name = $leagueInfo['alias_name'];
                        echo "<option value=\"".$leagueInfo['league_sn']."\" {$selected}>".$league_name."</option>";
                    }
                }
                ?>
            </select>
            <!-- 기간 필터 -->
            <span class="icon">날짜</span><input name="begin_date" type="text" id="begin_date" class="date" value="<?php echo $TPL_VAR["begin_date"]?>" maxlength="20" onclick="new Calendar().show(this);"/>&nbsp;~
            <input name="end_date" type="text" id="end_date" class="date" value="<?php echo $TPL_VAR["end_date"]?>" maxlength="20" onclick="new Calendar().show(this);" />

            <!-- 팀검색, 리그검색 -->
            <select name="filter_team_type">
                <option value="home_team" <?php if($TPL_VAR["filter_team_type"]=="home_team"){?> selected<?php }?>>홈팀</option>
                <option value="away_team" <?php if($TPL_VAR["filter_team_type"]=="away_team"){?> selected<?php }?>>원정팀</option>
                <option value="league" 		<?php if($TPL_VAR["filter_team_type"]=="league"){?> selected<?php }?>>리그명</option>
            </select>
            <input type="text" size="10" name="filter_team" value="<?php echo $TPL_VAR["filter_team"]?>" class="name">
            <!-- 검색버튼 -->
            <input name="Submit4" type="image" src="/img/btn_search.gif" class="imgType" title="검색" />
            &nbsp;&nbsp;
            <!--<input type="checkbox" name="money_option" value="" <?php if($TPL_VAR["money_option"]==1){?>checked<?php }?> onClick="onCheckbox(this.form)" class="radio"><font color='red'>배팅금액 0↑</font>-->
            <span class="rightSort">
				<span>선택 항목을</span>
				<input type="button" value="배당수정" onclick="select_modify_rate();" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
				<select name="select_state" id="select_state">
					<option value=0  <?php if($TPL_VAR["select_state"]==0){?>  selected <?php }?>>발매</option>
<?php if($TPL_VAR["state"]!=21){?>
    <option value=-1 <?php if($TPL_VAR["select_state"]== -1){?> selected <?php }?>>대기</option>
<?php }?>
					<option value=1  <?php if($TPL_VAR["select_state"]==1){?>  selected <?php }?>>마감</option>
                    <option value=2  <?php if($TPL_VAR["select_state"]==2){?>  selected <?php }?>>차단</option>
				</select>
				<input type="button" value="선택상태변경" onclick="select_modify_state();" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
				<input type="button" value="선택삭제" onclick="select_delete();" class="Qishi_submit_a" onmouseover="this.className='Qishi_submit_b'" onmouseout="this.className='Qishi_submit_a'">
			</span>
        </form>
    </div>
</div>

<form id="form1" name="form1" method="post" action="?">
    <input type="hidden" name="act" value="delete">
    <table cellspacing="1" class="tableStyle_gameList">
        <legend class="blind">항목보기</legend>
        <thead>
        <tr>
            <th><input type="checkbox" name="check_all" onClick="select_all()"/> No</th>
            <th>경기타입</th>
            <th><a href="javascript:sortByDate()" style="color: white">경기일시</a></th>
            <th>종류</th>
            <th>종목</th>
            <th>리그</th>
            <th>매칭리그</th>
            <th colspan="2">승(홈팀)</th>
            <th>무</th>
            <th colspan="2">패(원정팀)</th>
            <th>스코어</th>
            <th>이긴 팀</th>
            <th>진행상태</th>
            <th>유저배당</th>
            <th>적용</th>
            <th>처리</th>
            <th>No</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ( $TPL_list_1 ) {
            foreach ( $TPL_VAR["list"] as $TPL_V1) {
                if ( $TPL_V1["user_view_flag"] == 0 ) $addTrStyle = "_notView";
                else $addTrStyle = "";
                ?>
                <?php if(is_null($TPL_V1["kubun"])){?>
                    <tr class="<?=$addTrStyle;?>">
                <?php }elseif($TPL_V1["kubun"]==0){?>
                    <?php
                    $gameDateTime = mktime($TPL_V1["gameHour"],$TPL_V1["gameTime"],0,substr($TPL_V1["gameDate"],5,2),substr($TPL_V1["gameDate"],8,2),substr($TPL_V1["gameDate"],0,4));
                    if ( $gameDateTime > time() ) {
                        ?>
                        <tr class="gameGoing<?=$addTrStyle;?>">
                    <? } else { ?>
                        <tr class="gameEnd<?=$addTrStyle;?>">
                    <? } ?>

                <?php }elseif($TPL_V1["kubun"]==1){?>
                    <tr class="gameFinished<?=$addTrStyle;?>">
                <?php }?>
                <td><input type='checkbox' name='subchild_sn[]' id='subchild_sn' value='<?php echo $TPL_V1["subchild_sn"]?>' onClick="select_to(this);"><font color='blue'> <?php echo $TPL_V1["subchild_sn"]?></font></td>
                <td>
                    <?php
                    if ( $TPL_V1["user_view_flag"] == 0 ) echo "<font style='color:red;'>".$TPL_V1["parsing_site"]."(숨김)</font>";
                    else echo "타입".$TPL_V1["parsing_site"];
                    ?>
                </td>
                <td>
                    <?php /*if($TPL_V1["update_game_date"]){*/?><!--<span style="color:red;"><?php /*}*/?><?php /*if($TPL_V1["update_enable"]==0){*/?><span style="border-bottom:1px solid red;"><?php /*}*/?>--><?php /*echo sprintf("%s %s:%s",substr($TPL_V1["gameDate"],5),$TPL_V1["gameHour"],$TPL_V1["gameTime"])*/?>
                            <input id="game_date_<?php echo $TPL_V1["subchild_sn"]?>" name="game_date_<?php echo $TPL_V1["subchild_sn"]?>" value="<?php echo $TPL_V1["gameDate"]?>" style="width: 75px">
                            <input id="game_hour_<?php echo $TPL_V1["subchild_sn"]?>" name="game_hour_<?php echo $TPL_V1["subchild_sn"]?>" value="<?php echo $TPL_V1["gameHour"]?>" style="width: 17px"> :
                            <input id="game_time_<?php echo $TPL_V1["subchild_sn"]?>" name="game_time_<?php echo $TPL_V1["subchild_sn"]?>" value="<?php echo $TPL_V1["gameTime"]?>" style="width: 17px">
                </td>
                <td>
                    <?php if($TPL_V1["type"]==1){?><span class="victory">승무패<?php if($TPL_V1["special"]==1){?>(실시간)<?php }/*elseif($TPL_V1["special"]==2){*/?><!--(실시간)--><?php /*}*/?></span>
                    <?php }elseif($TPL_V1["type"]==2){?><span class="handicap">핸디캡<?php if($TPL_V1["special"]==1){?>(실시간)<?php }/*elseif($TPL_V1["special"]==2){*/?><!--(실시간)--><?php /*}*/?></span>
                    <?php }elseif($TPL_V1["type"]==4){?><span class="underover">언더오버<?php if($TPL_V1["special"]==1){?>(실시간)<?php }/*elseif($TPL_V1["special"]==2){*/?><!--(실시간)--><?php /*}*/?></span>
                    <?php }?>
                </td>
                <td><?php echo $TPL_V1["sport_name"]?></td>
                <td><a onclick="window.open('/league/popup_edit?league_sn=<?php echo $TPL_V1["league_sn"];?>','','scrollbars=yes,width=600,height=400,left=5,top=0');" href="#"><?php echo $TPL_V1["league_name"]?></a></td>
                <td><?php echo $TPL_V1["alias_name"]?></td>
                <td colspan="2">
                    <table width="100%">
                        <tr>
                            <td>
                                <?php
                                if ( $TPL_V1["total_betting"] > 0 ) {
                                    echo "<font color=\"blue\"><b>".mb_strimwidth($TPL_V1["home_team"],0,20,"..","utf-8")."</b></font>";
                                } else {
                                    echo mb_strimwidth($TPL_V1["home_team"],0,20,"..","utf-8");
                                }
                                ?>
                            </td>
                            <td width="35">
                                <?php
                                //-> home 배당 출력
                                //echo $TPL_V1["home_rate"];
                                $rate = $TPL_V1["home_rate"];
                                $style = 'width:40px;text-align: center;';
                                if ( $TPL_V1["home_rate"] != $TPL_V1["new_home_rate"] and strlen($TPL_V1["new_home_rate"]) > 0 ) {
                                    //echo "<br><span style='color:red;font-size:11px;'>".$TPL_V1["new_home_rate"]."</span>";
                                    $style = 'color:red;font-size:11px;';
                                    $rate = $TPL_V1["new_home_rate"];
                                }
                                echo "<input id='home_rate_{$TPL_V1["subchild_sn"]}' name='home_rate_{$TPL_V1["subchild_sn"]}' value='{$rate}' style='{$style}'>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <a href="#" onclick="open_window('/game/popup_bet_list?subchild_sn=<?php echo $TPL_V1["subchild_sn"]?>&amp;select_no=1','1024','600')">
                                <span style="color:#3163C9;" id="h_t_b_<?php echo $TPL_V1["subchild_sn"]?>"><?=number_format($TPL_V1["home_total_betting"],0);?></span>
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table width="100%">
                        <tr>
                            <td>
                                <?php
                                //-> draw 배당 출력
                                /*if ( ($TPL_V1["type"] == 1 && $TPL_V1["draw_rate"] == '1.00') || ($TPL_V1["type"] == 1 && $TPL_V1["draw_rate"] == '1') ){
                                    echo "VS";
                                } else {
                                    echo $TPL_V1["draw_rate"];
                                }
                                if ( $TPL_V1["draw_rate"] != $TPL_V1["new_draw_rate"] and strlen($TPL_V1["new_draw_rate"]) > 0 ) {
                                    echo "<br><span style='color:red;font-size:11px;'>".$TPL_V1["new_draw_rate"]."</span>";
                                }*/

                                $style = 'width:40px;text-align: center;';
                                $rate = $TPL_V1["draw_rate"];

                                if ( $TPL_V1["draw_rate"] != $TPL_V1["new_draw_rate"] and strlen($TPL_V1["new_draw_rate"]) > 0 ) {
                                    //echo "<br><span style='color:red;font-size:11px;'>".$TPL_V1["new_home_rate"]."</span>";
                                    $style = 'color:red;font-size:11px;';
                                    $rate = $TPL_V1["new_draw_rate"];
                                }
                                echo "<input id='draw_rate_{$TPL_V1["subchild_sn"]}' name='draw_rate_{$TPL_V1["subchild_sn"]}' value='{$rate}' style='{$style}'>";

                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="#" onclick="open_window('/game/popup_bet_list?subchild_sn=<?php echo $TPL_V1["subchild_sn"]?>&amp;select_no=3','1024','600')">
                                <span style="color:#3163C9;" id="d_t_b_<?php echo $TPL_V1["subchild_sn"]?>"><?=number_format($TPL_V1["draw_total_betting"],0);?></span>
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
                <td colspan="2">
                    <table width="100%">
                        <tr>
                            <td width="35">
                                <?php
                                //-> away 배당 출력
                                /*echo $TPL_V1["away_rate"];
                                if ( $TPL_V1["away_rate"] != $TPL_V1["new_away_rate"] and strlen($TPL_V1["new_away_rate"]) > 0 ) {
                                    echo "<br><span style='color:red;font-size:11px;'>".$TPL_V1["new_away_rate"]."</span>";
                                }*/

                                $style = 'width:40px;text-align: center;';
                                $rate = $TPL_V1["away_rate"];

                                if ( $TPL_V1["away_rate"] != $TPL_V1["new_away_rate"] and strlen($TPL_V1["new_away_rate"]) > 0 ) {
                                    //echo "<br><span style='color:red;font-size:11px;'>".$TPL_V1["new_home_rate"]."</span>";
                                    $style = 'color:red;font-size:11px;';
                                    $rate = $TPL_V1["new_away_rate"];
                                }
                                echo "<input id='away_rate_{$TPL_V1["subchild_sn"]}' name='away_rate_{$TPL_V1["subchild_sn"]}' value='{$rate}' style='{$style}'>";
                                ?>
                            </td>
                            <td>
                                <?php
                                if ( $TPL_V1["total_betting"] > 0 ) {
                                    echo "<font color=\"blue\"><b>".mb_strimwidth($TPL_V1["away_team"],0,20,"..","utf-8")."</b></font>";
                                } else {
                                    echo mb_strimwidth($TPL_V1["away_team"],0,20,"..","utf-8")."&nbsp;&nbsp;";
                                }

                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <a href="#" onclick="open_window('/game/popup_bet_list?subchild_sn=<?php echo $TPL_V1["subchild_sn"]?>&amp;select_no=2','1024','600')">
                                <span style="color:#3163C9;" id="a_t_b_<?php echo $TPL_V1["subchild_sn"]?>"><?=number_format($TPL_V1["away_total_betting"],0);?></span>
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <?php
                    //echo $TPL_V1["home_score"].":". $TPL_V1["away_score"];
                    echo "<input id='home_score_{$TPL_V1["subchild_sn"]}' name='home_score_{$TPL_V1["subchild_sn"]}' value='{$TPL_V1["home_score"]}' style='width: 40px;text-align: center'> : ";
                    echo "<input id='away_score_{$TPL_V1["subchild_sn"]}' name='away_score_{$TPL_V1["subchild_sn"]}' value='{$TPL_V1["away_score"]}' style='width: 40px;text-align: center'>";
                    ?>
                </td>
                <td>
                    <?php if($TPL_V1["win"]==1){?> 홈승
                    <?php }elseif($TPL_V1["win"]==2){?> 원정승
                    <?php }elseif($TPL_V1["win"]==3){?> 무승부
                    <?php }elseif($TPL_V1["win"]==4){?> 취소/적특
                    <?php }else{?> &nbsp;
                    <?php }?>
                </td>

                <td>
                    <?php if($TPL_V1["kubun"]==1){?>
                        종료
                    <?php }else{?>
                        <select name="play" id="state_<?php echo $TPL_V1["subchild_sn"]?>" onChange="onStateChange(<?php echo $TPL_V1["subchild_sn"]?>);">
                            <?php
                            $gameDateTime = mktime($TPL_V1["gameHour"],$TPL_V1["gameTime"],0,substr($TPL_V1["gameDate"],5,2),substr($TPL_V1["gameDate"],8,2),substr($TPL_V1["gameDate"],0,4));
                            if ( $gameDateTime > time() ) {
                                ?>
                                <option value=0  <?php if($TPL_V1["kubun"]==0){?>  selected <?php }?>>발매</option>
                                <?php if ($TPL_V1["kubun"] != '' && $TPL_V1["kubun"] != null) {?>
                                <option value=2 >마감</option>
                                <?php }?>
                            <?php } else { ?>
                                <option value=2  <?php if($TPL_V1["kubun"]==0){?>  selected <?php }?>>마감</option>
                            <?php } ?>
                            <?php if($TPL_VAR["state"]!=21){?>
                                <option value=-1 <?php if($TPL_V1["kubun"]==''){?> selected <?php }?>>대기</option>
                            <?php }?>
                        </select>
                    <?php }?>
                </td>
                <td >
                    <a href="#" onclick="open_window('/game/popup_bet_list?subchild_sn=<?php echo $TPL_V1["subchild_sn"]?>&amp;','1024','600')" style="color: red">
                        <span id="t_t_b_<?php echo $TPL_V1["subchild_sn"]?>">
                    <?=number_format($TPL_V1["home_total_betting"]+$TPL_V1["draw_total_betting"]+$TPL_V1["away_total_betting"],0);?>
                        </span>
                    </a>
                </td>
                <td>
                    <!--<input type='button' class='btnStyle4' value="배당수정" onclick=open_window('/gameUpload/modifyrate?idx=<?php /*echo $TPL_V1["subchild_sn"]*/?>&gametype=<?php /*echo $TPL_V1["type"]*/?>&mode=edit','650','300')>-->
                <?php if($TPL_V1["kubun"]!=1){?>
                    <input type='button' class='btnStyle4' value="적용" onclick=onApply(<?php echo $TPL_V1["subchild_sn"]?>)>
                <?php } ?>
                </td>
                <td>
                    <?php /*if(($TPL_V1["special"]==1 or $TPL_V1["special"]==2)&&$TPL_V1["result"]!=1){*/?><!--
                        <input type="button" class="btnStyle3" value="마감" onclick="onDeadLine(<?php /*echo $TPL_V1["subchild_sn"]*/?>)";>&nbsp;
                    <?php /*}*/?>
                    <input type="button" class="btnStyle3" value="수정" onclick="window.open('/gameUpload/popup_modifyresult?mode=edit&idx=<?php /*echo $TPL_V1["subchild_sn"]*/?>&result=<?php /*echo $TPL_V1["result"]*/?>','','resizable=no width=650 height=400')";>&nbsp;-->
                    <?php if($TPL_V1["result"]!=1){?>
                        <input type="button" class="btnStyle3" value="삭제" onclick="onDelete(<?php echo $TPL_V1["subchild_sn"]?>)">
                        <input type="button" class="btnStyle3" value="완전삭제" onclick="onDeleteDB(<?php echo $TPL_V1["subchild_sn"]?>)">
                    <?php }else{?>
                        <input type='button' class="btnStyle3" value="결과취소" style="color:red" onclick="go_rollback('/gameUpload/popup_multi_cancel_resultProcess?idx=<?php echo $TPL_V1["subchild_sn"]?>&type=<?php echo $TPL_VAR["type"]?>')")>
                    <?php }?>
                </td>
                <td><input type='checkbox' name='subchild_sn_back[]' id='subchild_sn_back' value='<?php echo $TPL_V1["subchild_sn"]?>' onClick="select_to(this);"></td>
                </tr>
            <?php }}?>
        </tbody>
    </table>

    <div id="pages">
        <?php echo $TPL_VAR["pagelist"]?>

    </div>
</form>

</body>
</html>