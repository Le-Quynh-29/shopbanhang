(function($) {
    "use strict";

    var AppCategory = function AppCategory(element, options, cb) {
        var appCategory = this;
        this.element = element;
        this.$element = $(element);
        this.token = _token;
        this.validateUniqueNameURL = _validateUniqueNameURL;
        this.$element.on('click', '.modal-edit', function (that) {
            appCategory.showModalEdit(that);
        });
        this.$element.on('click', '#submit-form-delete', function () {
            appCategory.deleteProduct();
        });
    };

    AppCategory.prototype = {
        _init: function _init() {
            this.ajaxSetup();
            this.initValidateCategoryGeneral();
            this.initUploadPreview();
            this.initValidateUpdateCategoryGeneral();
        },
        ajaxSetup: function ajaxSetup() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": _token
                }
            });
        },
        initUploadPreview: function initUploadPreview() {
            $(".image-preview-wrapper").uploadPreview();
        },
        showModalEdit: function(that) {
            $('#id-edit').val(that.currentTarget.attributes['data-id'].value);
            $('#name-edit').val(that.currentTarget.attributes['data-name'].value);
            var url = that.currentTarget.attributes['data-image'].value;
            $('#image-preview-edit').css(
                {
                    "background-image" : "url(" + url +")"
                }
            );
            $('#image-label-edit').css(
                {
                    "display" : "none"
                }
            );
        },
        initValidateCategoryGeneral: function() {
            var el = this;
            $("#form-create-category").validate({
                onfocusout: function (element, event) {
                    var $element = $(element);
                    if ($element.attr("id") == "name") {
                        $element.val($.trim($element.val()));
                        $element.valid();
                    }
                },
                onkeyup: false,
                onclick: false,
                rules: {
                    name: {
                        required: true,
                        maxlength: 255,
                        remote: {
                            url: el.validateUniqueNameURL,
                            type: 'POST',
                            data: {
                                name: function() {
                                    return $('#name').val();
                                }
                            },
                            dataType: 'json',
                            dataFilter: function(res) {
                                let result = JSON.parse(res);
                                let jsonStr = JSON.stringify(result.data);
                                return jsonStr;
                            }
                        }
                    },
                },
                messages: {
                    name: {
                        required: "Tên danh mục không được để trống.",
                        maxlength: "Tên danh mục không được nhiều hơn 255 ký tự.",
                        remote: "Tên danh mục đã tồn tại.",
                    },
                },
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        },
        initValidateUpdateCategoryGeneral: function() {
            var el = this;
            $("#form-update-category").validate({
                onfocusout: function (element, event) {
                    var $element = $(element);
                    if ($element.attr("id") == "name-edit") {
                        $element.val($.trim($element.val()));
                        $element.valid();
                    }
                },
                onkeyup: false,
                onclick: false,
                rules: {
                    name: {
                        required: true,
                        maxlength: 255,
                        remote: {
                            url: el.validateUniqueNameURL,
                            type: 'POST',
                            data: {
                                id: function() {
                                    return $('#id-edit').val();
                                },
                                name: function() {
                                    return $('#name-edit').val();
                                }
                            },
                            dataType: 'json',
                            dataFilter: function(res) {
                                let result = JSON.parse(res);
                                let jsonStr = JSON.stringify(result.data);
                                return jsonStr;
                            }
                        }
                    },
                },
                messages: {
                    name: {
                        required: "Tên danh mục không được để trống.",
                        maxlength: "Tên danh mục không được nhiều hơn 255 ký tự.",
                        remote: "Tên danh mục đã tồn tại.",
                    },
                },
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        },
        deleteProduct: function () {
            var product = $('.product');
            var array = [];
            for (var i = 0; i < product.length; i++){
                if (product[i].checked === true){
                    array.push(product[i].value);
                }
            }
            $('#product').val(array);
            console.log($('#product').val());
        }
    };
    /* Execute main function */

    $.fn.appCategory = function(options, cb) {
        this.each(function() {
            var el = $(this);

            if (!el.data("appCategory")) {
                var appCategory = new AppCategory(el, options, cb);
                el.data("appCategory", AppCategory);

                appCategory._init();
            }
        });
        return this;
    };
})(jQuery);

$(document).ready(function() {
    $("body").appCategory();
});
