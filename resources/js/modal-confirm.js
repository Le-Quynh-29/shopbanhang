(function ($) {
    'use strict';
    $('.modal-confirm').on('click', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');

        $('#modal-confirm').modal('show');

        $('#modal-confirm').on('click', '.btn-modal-save', function(e) {
            form.trigger('submit');
        });
    });
})(jQuery);
