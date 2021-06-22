/*
 * @cookie wrapper
 * @author Tony Eom
 * @since 2015-11-09
 */
(function (root) {
    var cookie = {};
    /**
     * Setter
     * @param key
     * @param value
     * @param minutes
     * @param path
     */
    cookie.set = function (key, value, minutes, path) {
        var expires, cookie_path = '', d = new Date();
        if (minutes === undefined || minutes === null) {
            minutes = 60 * 24 * 7;
        }
        d.setTime(d.getTime() + (minutes * 60 * 1000));
        expires = 'expires=' + d.toUTCString();
        if (typeof path != "undefined") {
            cookie_path = 'path=' + path;
        }
        root.document.cookie = key + '=' + value + '; ' + expires + '; ' + cookie_path;
    };
    /**
     * Getter
     * @param key
     * @returns {*}
     */
    cookie.get = function (key) {
        var ca, name = key + '=', c;
        ca = root.document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1);
            if (c.indexOf(name) === 0) {
                return c.substring(name.length, c.length);
            }
        }
        return '';
    };
    /**
     * Clear
     */
    cookie.clear = function () {
        var cookies = root.document.cookie.split(';'),
            c, ep, n;
        for (var i = 0; i < cookies.length; i++) {
            c = cookies[i];
            ep = c.indexOf('=');
            n = ep > -1 ? c.substr(0, ep) : c;
            root.document.cookie = n + '=;expires=Thu, 01 Jan 1970 00:00:00 GMT';
        }
    };

    // export
    root.cookie = cookie;
}(window));
/* End of file cookie.js */
/* Location: /public/js/cookie.js */