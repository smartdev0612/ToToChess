<html>
    <head>
        <script type="text/javascript" src="/js/jquery-1.7.1.min.js"></script>
        <script>
            window.addEventListener ( 'statscore.livematchpro.tracker-1.resize', function () { 
            //console.log ( '이것은 tracker1 크기 조정 콜백입니다'); 
                var tra_height = $('#iframe-tracker-1').height();
                var e = parent.document.getElementById('game_stat');
                e.style.height = tra_height + "px"; 
            }); 
            window.addEventListener ( 'statscore.livematchpro.tracker-1.error', function () {
                var e = parent.document.getElementById('game_stat');
                e.style.height = "100px"; 
                $("#tracker_div").html("<font color='#ef9d07'>등록된 라이브영상이 없습니다.</font>");
                $("#tracker_div").css("line-height","100px");
            });
        </script>
    </head>
    <body>
        <div id="tracker_div" align="center">
            <section id="Tracker-1" class="STATSCORE__Tracker" data-event="4195325" data-lang="ko" data-config="2" data-zone="" data-use-mapped-id="1"></section>
        </div>
        <script rel="script" src="https://live.statscore.com/livescorepro/generator"></script>
    </body>
</html>