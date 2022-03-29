(function ($) {
    'use strict';

    var AppMenu = function AppMenu(element, options, cb) {
        var appMenu = this;
        this.element = element;
        this.$element = $(element);
        this.appUrl = _appUrl;
        this.token = _token;
    };

    AppMenu.prototype = {
        _init: function _init() {
            this.ajaxSetup();
            this.init();
        },
        ajaxSetup: function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': _token
                }
            });
        },
        init: function() {
            $(document).ready(function(){
                setTimeout(() => {
                    var menuId = $('.c-sidebar-nav-link.c-active').data('id');
                    
                    if (menuId != '' && menuId != undefined) {
                        window.localStorage.setItem('menu-selected', menuId);
                    } else {
                        var menuIdStorage = window.localStorage.getItem('menu-selected');
                        $('.c-sidebar-nav-link').removeClass('c-active');
                        $('.c-sidebar-nav-link[data-id="'+menuIdStorage+'"]').addClass('c-active');
                    }
                }, 400);
            });
        }
    };
    
    /* Execute main function */
    $.fn.appMenu = function (options, cb) {
        this.each(function () {
            var el = $(this);
            if (!el.data('appMenu')) {
                var appMenu = new AppMenu(el, options, cb);
                el.data('appMenu', AppMenu);
                appMenu._init();
            }
        });
        return this;
    };
})(jQuery);

$(document).ready(function () {
    $('body').appMenu();
});