(function($) {
    "use strict";

    var AppModal = function AppModal(element, options, cb) {
        var appModal = this;
        this.element = element;
        this.$element = $(element);
        this.token = _token;
    };

    AppModal.prototype = {
        _init: function _init() {
            this.ajaxSetup();
            this.showModalCreate();
            this.showModalEdit();
        },
        ajaxSetup: function ajaxSetup() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": _token
                }
            });
        },
        showModalCreate: function () {
            $('.modal-create').on('click', function(e) {
                e.preventDefault();
                $("#modal-create input").filter(".form-control").val('');
                if ($("#modal-create input").hasClass("error")) {
                    $("#modal-create input").removeClass("error");
                    $("label.error").remove();
                }
                $("div.image-preview").removeAttr('style');
                $("label.hidden").removeAttr('style');

                $('#modal-create').modal('show');

                $('#modal-create').on('click', '.btn-modal-cancel', function () {
                    $('#modal-create').modal('hide');
                });

                $('#modal-create').on('click', '.close', function () {
                    $('#modal-create').modal('hide');
                });
            });
        },
        showModalEdit: function () {
            $('.modal-edit').on('click', function(e) {
                e.preventDefault();
                if ($("#modal-edit input").hasClass("error")) {
                    $("#modal-edit input").removeClass("error");
                    $("label.error").remove();
                }
                $('#modal-edit').modal('show');

                $('#modal-edit').on('click', '.btn-modal-cancel', function () {
                    $('#modal-edit').modal('hide');
                });

                $('#modal-edit').on('click', '.close', function () {
                    $('#modal-edit').modal('hide');
                });
            });
        }
    };
    /* Execute main function */

    $.fn.appModal = function(options, cb) {
        this.each(function() {
            var el = $(this);

            if (!el.data("appModal")) {
                var appModal = new AppModal(el, options, cb);
                el.data("appModal", AppModal);

                appModal._init();
            }
        });
        return this;
    };
})(jQuery);

$(document).ready(function() {
    $("body").appModal();
});
