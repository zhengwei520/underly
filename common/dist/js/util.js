(function (window, $) {

    var Util = window.Util = typeof window.Util === 'undefined' ? {} : window.Util;

    Util.changeURLArg = function (url, params, value) {
        var pattern = params + '=([^&]*)';
        var replaceText = params + '=' + value;
        if (url.match(pattern)) {
            var tmp = '/(' + params + '=)([^&]*)/gi';
            tmp = url.replace(eval(tmp), replaceText);
            return tmp;
        } else {
            if (url.match('[\?]')) {
                return url + '&' + replaceText;
            } else {
                return url + '?' + replaceText;
            }
        }
    };
    
})(window, jQuery);