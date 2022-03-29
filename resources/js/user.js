(function($) {
    "use strict";

    var AppUser = function AppUser(element, options, cb) {
        var appUser = this;
        this.element = element;
        this.$element = $(element);
        this.token = _token;
        this.element.on("change", "#search-by-keyword", function() {
            appUser.handleChangeByKeyWord();
        });
        this.element.on("click", ".modal-lock", function() {
            appUser.onClickModalLock($(this));
        });
    };

    AppUser.prototype = {
        _init: function _init() {
            this.ajaxSetup();
            this.init();
            this.handleChangeByKeyWord();
        },
        ajaxSetup: function ajaxSetup() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": _token
                }
            });
        },
        init: function () {
            $(".date").datepicker({
                language: 'vi',
                format: "dd/mm/yyyy",
                orientation: "bottom",
                clearBtn: true,
                todayHighlight: true
            }).on('change', function () {
                $('.datepicker').hide();
            });
        },
        handleChangeByKeyWord: function() {
            var searchBy = $("#search-by-keyword").val();
            if (searchBy === "username" || searchBy === "id") {
                $("#search-text").show();
                $("#search-text-active").hide();
                $("#search-text-active").val('');
                $("#search-text-active").prop("disabled", true);
                $("#search-text").prop("disabled", false);
            }

            if (searchBy === "active") {
                $("#search-text").hide();
                $("#search-text").val('');
                $("#search-text-active").show();
                $("#search-text-active").prop("disabled", false);
                $("#search-text").prop("disabled", true);
            }
        },
        onClickModalLock: function(t) {
            var form = t.closest('form');
            var active = t.data('active');
            var titleHeader = '';
            var titleBody = '';
            var titleSave = '';
            if (active == '0') {
                titleHeader = 'Xác nhận mở khóa người dùng';
                titleBody = 'Bạn có chắc chắn muốn mở khóa người dùng này không?';
                titleSave = 'Mở khóa'
            } else {
                titleHeader = 'Xác nhận vô hiệu hóa người dùng';
                titleBody = 'Bạn có chắc chắn muốn vô hiệu hóa người dùng này không?';
                titleSave = 'Vô hiệu hóa';
            }

            $('#modal-lock .modal-title').text(titleHeader);
            $('#modal-lock .body-title').text(titleBody);
            $('#modal-lock .btn-modal-save').text(titleSave);
            $('#modal-lock').modal('show');
            $('#modal-lock').on('click', '.btn-modal-save', function(e) {
                form.trigger('submit');
            });
        },
    };
    /* Execute main function */

    $.fn.appUser = function(options, cb) {
        this.each(function() {
            var el = $(this);

            if (!el.data("appUser")) {
                var appUser = new AppUser(el, options, cb);
                el.data("appUser", AppUser);

                appUser._init();
            }
        });
        return this;
    };
})(jQuery);

$(document).ready(function() {
    $("body").appUser();
});
