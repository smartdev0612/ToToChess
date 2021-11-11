<html>
    <head>
        <script type="text/javascript" src="/BET38/js/jquery-1.12.1.min.js"></script>
    </head>
    <body style="margin:0px;">
        <div id="tracker_div_<?=$TPL_VAR['event_id']?>" align="center"></div>
        <script>
            !function(){var d="STATSCOREWidgetsEmbederScript";if(!window.document.getElementById(d)){window.STATSCOREWidgets={},window.STATSCOREWidgets.onLoadCallbacks=[],window.STATSCOREWidgets.onLoad=function(d){window.STATSCOREWidgets.onLoadCallbacks.push(d)};var n=window.document.createElement("script");n.src="https://wgt-s3-cdn.statscore.com/bundle/Embeder.js",n.async=!0,n.id=d,n.addEventListener("error",function(d){for(var n=0;n<window.STATSCOREWidgets.onLoadCallbacks.length;n++)window.STATSCOREWidgets.onLoadCallbacks[n](d)}),window.document.body.appendChild(n)}}();
        </script>
        <script>
            // Hook up when library is loaded and ready to use.
            // You can use this method as many times as necessary - if library
            // is already loaded provided callback will fire immediately
            STATSCOREWidgets.onLoad(err => {
                if (err) {
                    switch (err.type) {
                        case 'NetworkError':
                            // Handle network error here
                            break;

                        case 'BrowserNotSupported':
                            // Handle unsupported browser here
                            break;
                    }

                    return;
                }

                // Widget will be appended to this HTMLElement.
                //
                // If you are using framework then follow its documentation
                // on how to get DOM Element from your component.
                // Vue.js https://vuejs.org/v2/api/#ref
                // React https://en.reactjs.org/docs/refs-and-the-dom.html
                // Angular https://angular.io/api/core/ElementRef
                const element = document.getElementById('tracker_div_<?=$TPL_VAR['event_id']?>');

                // Configuration that you should receive from STATSCORE
                const configurationId = '6182a2b44bfe63ac218c1403';

                // Input data for widget type you want to embded
                const inputData = { eventId: 'm:<?=$TPL_VAR['event_id']?>', language: 'ko' };

                // Optional object with options.
                // You can check available options further in the docs.
                const options = { loader: { enabled: true, size: 60, color1: '#0097ec', color2: '#455c6b' } };

                const widget = new window.STATSCOREWidgets.WidgetGroup(element, configurationId, inputData, options);

                const someEventCallback = () => { /* .. do stuff */ };

                // You can listen for event using on and once methods
                widget.on('someEvent', someEventCallback);
                widget.once('someEvent', someEventCallback);

                // You can destroy listener by using and off method
                widget.off('someEvent', someEventCallback);

                // Available events to listen for
                widget.on('beforeInsert', () => { /* Triggers when data necessary to display widget is loaded and widget is ready to be inserted into document */ });
                widget.on('load', () => { /* Triggers when widget is loaded but not yet interactive */ });
                widget.on('mount', () => { /* Triggers when widget is loaded and interactive */ });
                widget.on('error', e => { 
                    var e = parent.document.getElementById('game_stat');
                    e.style.height = "100px"; 
                    $("#tracker_div_<?=$TPL_VAR['event_id']?>").html("<font color='#ef9d07'>등록된 라이브영상이 없습니다.</font>");
                    $("#tracker_div_<?=$TPL_VAR['event_id']?>").css("line-height","100px");
                });

                // Events emitted directly from widgets
                widget.on('participantClick', e => { /* Triggers on click participant name in widget when configuration allows it */ });
                // Callback param takes object which contain id and name
            });
        </script>
    </body>
</html>