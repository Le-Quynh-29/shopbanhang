(function ($) {
    'use strict';
    var LaravelSort = function (element, options, cb) {
        this.element = element;
        this.$element = $(this.element);
    };

    LaravelSort.prototype = {
        _init: function () {
            this.excute();
        },
        excute: function () {
            var corderBy = this.element.data('field'),
                sortBy = typeof url('?sort_by') !== 'undefined' ? url('?sort_by') : 'asc',
                orderBy = typeof url('?order_by') !== 'undefined' ? url('?order_by') : '',
                worigin = window.location.origin,
                wpathname = window.location.pathname,
                wsearch = window.location.search;

            if (sortBy === 'asc') {
                sortBy = 'desc';
            }
            else if (sortBy === 'desc') {
                sortBy = 'asc';
            }

            var urlParams = new URLSearchParams(wsearch);
            urlParams.set('sort_by', sortBy);
            urlParams.set('order_by', corderBy);

            var href = worigin + wpathname + '?' + urlParams;
            this.element.attr('href', href);
            if (this.element.data('field') === orderBy) {
                this.element.addClass(sortBy);
            }
        }
    };
    /* Execute main function */
    $.fn.laravelSort = function (options, cb) {
        this.each(function () {
            var el = $(this);
            if (!el.data('laravelSort')) {
                var laravelSort = new LaravelSort(el, options, cb);
                el.data('laravelSort', laravelSort);
                laravelSort._init();
            }
        });
        return this;
    };
})(jQuery);
$(document).ready(function () {
    $('.laravel-sort').laravelSort();
});
