( function( window ) {

    'use strict';



    function classReg( className ) {
        return new RegExp("(^|\\s+)" + className + "(\\s+|jq$)");
    }


    var hasClass, addClass, removeClass;

    if ( 'classList' in document.documentElement ) {
        hasClass = function( elem, c ) {
            return elem.classList.contains( c );
        };
        addClass = function( elem, c ) {
            elem.classList.add( c );
        };
        removeClass = function( elem, c ) {
            elem.classList.remove( c );
        };
    }
    else {
        hasClass = function( elem, c ) {
            return classReg( c ).test( elem.className );
        };
        addClass = function( elem, c ) {
            if ( !hasClass( elem, c ) ) {
                elem.className = elem.className + ' ' + c;
            }
        };
        removeClass = function( elem, c ) {
            elem.className = elem.className.replace( classReg( c ), ' ' );
        };
    }

    function toggleClass( elem, c ) {
        var fn = hasClass( elem, c ) ? removeClass : addClass;
        fn( elem, c );
    }

    var classie = {
        // full names
        hasClass: hasClass,
        addClass: addClass,
        removeClass: removeClass,
        toggleClass: toggleClass,
        // short names
        has: hasClass,
        add: addClass,
        remove: removeClass,
        toggle: toggleClass
    };

// transport
    if ( typeof define === 'function' && define.amd ) {
        // AMD
        define( classie );
    } else {
        // browser global
        window.classie = classie;
    }

})( window );



/* div 스크롤 버튼 제어를 위해 넣었음 */


/** Use buttons instead of the scrollbar.
 **
 ** This was inspired by Samich's answer on stackoverflow.com, here:
 ** http://stackoverflow.com/a/8329376/1378264
 **
 ** Similar plugins:
 ** http://logicbox.net/jquery/simplyscroll/
 ** https://github.com/mikecao/jquery-scrollable
 **
 ** Copyright (c) 2013 Philipp Zedler <philipp@neue-musik.com>
 ** Licensed under the MIT license
 **
 **/


(function (jq$) {

    "use strict";

    var defaults = {
            'up': undefined,
            'down': undefined,
            'velocity': 300, // Pixel per second
            'maxDuration': 2000 // Maximum duration for scrolling
        },
        upButton = '<div style="position: absolute; top: 0px; background-color: #fff; border: 1px solid #000; padding:5px; display: none;">Up</div>',
        downButton = '<div style="position: absolute; bottom: 0px; background-color: #fff; border: 1px solid #000; padding:5px; display: none;">Down</div>',
        ScrollableArea = function (jq$content, options) {
            this.jq$content = jq$content;
            this.jq$container = jq$content.parent();
            this.velocity = options.velocity;
            this.maxDuration = options.maxDuration;
            this.setButtons(options);
            this.wrapContent();
            this.setExtraHeight();
            this.jq$content.data('scroll-buttons-active', true);
            this.jq$content.data('scrollable-area', this);
        };
    ScrollableArea.prototype = {
        setExtraHeight: function () {
            var extraHeight = this.getContentHeight() - this.jq$container.height();
            this.extraHeight = extraHeight;
        },
        getContentHeight: function () {
            return this.jq$wrapper.prop('scrollHeight');
            /** TODO: Check if this works OK on firefox, see here:
             ** http://stackoverflow.com/a/15033226/1378264
             **/
        },
        getScrollUpDuration: function () {
            var scrollLength = this.jq$wrapper.prop('scrollTop');
            return this.getScrollDuration(scrollLength);
        },
        getScrollDownDuration: function () {
            var scrollLength = this.getContentHeight() - this.jq$wrapper.prop('scrollTop');
            return this.getScrollDuration(scrollLength);
        },
        getScrollDuration: function (scrollLength) {
            var scrollDuration = scrollLength / this.velocity * 1000;
            return Math.min(scrollDuration, this.maxDuration);
        },
        activateScrolling: function () {
            var thisScrollableArea = this;
            this.jq$down.hover(function () {
                thisScrollableArea.scrollDown();
            }, function () {
                thisScrollableArea.jq$wrapper.stop();
            });
            this.jq$up.hover(function () {
                thisScrollableArea.scrollUp();
            }, function () {
                thisScrollableArea.jq$wrapper.stop();
            });
            // TODO: This does not work yet.
            //this.activateScrollingForTouchscreens();
        },
        activateScrollingForTouchscreens: function () {
            var thisScrollableArea = this;
            this.jq$down.bind('touchstart', function () {
                thisScrollableArea.scrollDown();
            });
            this.jq$down.bind('touched', function () {
                thisScrollableArea.jq$wrapper.stop();
            });
            this.jq$up.bind('touchstart', function () {
                thisScrollableArea.scrollUp();
            });
            this.jq$up.bind('touched', function () {
                thisScrollableArea.jq$wrapper.stop();
            });
        },
        setButtons: function (options) {
            if (options.up === undefined) {
                this.jq$up = jq$(upButton);
                this.jq$container.append(this.jq$up);
            } else {
                this.jq$up = this.jq$container.find(options.up);
            }
            if (options.down === undefined) {
                this.jq$down = jq$(downButton);
                this.jq$container.append(this.jq$down);
            } else {
                this.jq$down = this.jq$container.find(options.down);
            }
        },
        displayButtons: function () {
            if (this.extraHeight > 0) {
                this.jq$down.fadeIn();
                this.jq$up.fadeIn();
            } else {
                this.jq$down.fadeOut();
                this.jq$up.fadeOut();
            }
        },
        scrollDown: function () {
            this.scrollTo(this.extraHeight, this.getScrollDownDuration());
        },
        scrollUp: function () {
            this.scrollTo(0, this.getScrollUpDuration());
        },
        scrollTo: function (position, duration) {
            this.jq$wrapper.animate({scrollTop: position}, duration);
        },
        wrapContent: function () {
            this.jq$content.wrap('<div class="scroll-buttons-wrapper" />');
            this.jq$wrapper = this.jq$content.parent();
            this.jq$container.css({overflow: 'hidden', position: 'relative' });
            this.jq$wrapper.css({
                height: this.jq$container.height(),
                width: this.jq$container.width() + 20,
                overflow: 'auto',
                position: 'absolute',
                top: 0,
                left: 0
            });
        },
        reload: function () {
            this.setExtraHeight();
            this.displayButtons();
        }
    };
    jq$.fn.scrollButtons = function (options) {
        if (options === 'reload') {
            if (jq$(this).data('scroll-buttons-active') === true) {
                jq$(this).data('scrollable-area').reload();
            }
        } else {
            var settings = jq$.extend({}, defaults, options),
                scrollableArea = new ScrollableArea(jq$(this), settings);
            scrollableArea.activateScrolling();
            scrollableArea.displayButtons();
        }
        return this;
    };
}(jQuery));


/* div 스크롤 버튼 제어를 위해 넣었음 */