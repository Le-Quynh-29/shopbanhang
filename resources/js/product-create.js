(function($) {
    "use strict";

    var AppProductCreate = function AppProductCreate(element, options, cb) {
        var appProductCreate = this;
        this.element = element;
        this.$element = $(element);
        this.appUrl = _appUrl;
        this.token = _token;
        this.descriptionEditor = '';
        this.categoryTagify = _categoryTagify;
        this.validateUniqueNameURL = _validateUniqueNameURL;
        this.validateUniqueCodeURL = _validateUniqueCodeURL;
        this.autocompleteCategory = _autocompleteCategory;
        this.$element.on('click', 'a[aria-controls="product-detail"]', function (event) {
            event.preventDefault();
            toastr.info('Bạn cần tạo các thông tin cơ bản trước.');
        });
        this.$element.on('click', 'a[aria-controls="product-attachment"]', function (event) {
            event.preventDefault();
            toastr.info('Bạn cần tạo các thông tin cơ bản trước.');
        });
    };

    AppProductCreate.prototype = {
        _init: function _init() {
            this.ajaxSetup();
            this.initCDKEditor();
            this.initCategoryTagify();
            this.initUploadPreview();
            this.initValidateProductGeneral();
        },
        ajaxSetup: function ajaxSetup() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": _token
                }
            });
        },
        initCDKEditor: function () {
            var el = this;
            ClassicEditor.defaultConfig = {
                toolbar: {
                    items: [
                        'heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList'
                    ]
                }
            };
            ClassicEditor.create(document.querySelector('#description'), {}).then(function (editor) {
                el.descriptionEditor = editor;
            })["catch"](function (error) {
                console.error(error);
            });

            $('.description').removeClass('d-none');
        },
        initCategoryTagify: function () {
            var el = this;

            function tagTemplate(tagData) {
                return `
                    <tag
                        title="${tagData.value}"
                        contenteditable='false'
                        spellcheck='false'
                        tabIndex="-1"
                        class="tagify__tag ${tagData.class ? tagData.class : ""}"
                        ${this.getAttributes(tagData)}
                    >
                        <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
                        <div>
                            ${tagData.id ? ` <span class="badge badge-primary">#${tagData.id}</span> ` : ''} &nbsp;
                            <span class='tagify__tag-text ml-1'>${tagData.value}</span>
                        </div>
                    </tag>
                `
            }

            function suggestionItemTemplate(tagData) {
                return `
                    <div ${this.getAttributes(tagData)}
                        class='tagify__dropdown__item ${tagData.class ? tagData.class : ""}'
                        tabindex="0"
                        role="option"
                    >
                        ${tagData.id ? ` <span class="badge badge-primary">#${tagData.id}</span> ` : ''}
                        <span class="ml-1">${tagData.value}</span>
                    </div>
                `
            }

            $('input[name=category]').val(JSON.stringify(el.categoryTagify));
            var input = document.querySelector('input[name=category]'),
                tagify = new Tagify(input, {
                    tagTextProp: 'value',
                    enforceWhitelist: true,
                    skipInvalid: true,
                    autocomplete: true,
                    editTags: false,
                    originalInputValueFormat: valuesArr => JSON.stringify(valuesArr),
                    whitelist: el.categoryTagify,
                    templates: {
                        tag: tagTemplate,
                        dropdownItem: suggestionItemTemplate
                    },
                    dropdown: {
                        closeOnSelect: true,
                        enabled: 1,
                        maxItems: 0,
                        highlightFirst: true,
                        searchKeys: ['value']
                    },
                }), controller;

            // listen to any keystrokes which modify tagify's input
            tagify.on('input', onInput);

            function onInput(e) {
                var value = e.detail.value;
                // reset white list
                tagify.settings.whitelist.length = 0;
                controller && controller.abort();
                controller = new AbortController();

                // show loading animation and hide the suggestions dropdown
                tagify.loading(true);

                fetch(el.appUrl + '/ajax/category/autocomplete' + '?term=' + value, {signal: controller.signal})
                    .then(RES => RES.json())
                    .then((res) => {
                        tagify.loading(false);
                        if (res.status == 200) {
                            tagify.settings.whitelist = res.data;
                            tagify.dropdown.show.call(tagify, value);
                        }
                    })
                    .catch((error) => {
                        tagify.settings.whitelist.length = 0;
                        tagify.loading(false);
                        tagify.dropdown.hide();
                    })
            }
        },
        initUploadPreview: function initUploadPreview() {
            $(".image-preview-wrapper").uploadPreview();
        },
        initValidateProductGeneral: function () {
            var el = this;
            $.validator.addMethod("cdk_editor_required", function () {
                var length = el.descriptionEditor.getData().trim().length;
                return length > 0;
            }, "Mô tả không được để trống.");

            $("#form-product-create").validate({
                onfocusout: function (element, event) {
                    var $element = $(element);
                    if ($element.attr("id") == "code" || $element.attr("id") == "name") {
                        $element.val($.trim($element.val()));
                        $element.valid();
                    } else {
                        if ($element.val()) {
                            $element.valid();
                        }
                    }
                },
                onkeyup: false,
                onclick: false,
                ignore: [],
                rules: {
                    code: {
                        required: true,
                        maxlength: 30,
                        remote: {
                            url: el.validateUniqueCodeURL,
                            type: 'POST',
                            data: {
                                code: function() {
                                    return $('#code').val();
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
                    description: {
                        cdk_editor_required: true
                    },
                },
                messages: {
                    code: {
                        required: "Mã sản phẩm không được để trống.",
                        maxlength: "Mã sản phẩm không được nhiều hơn 30 ký tự.",
                        remote: "Mã sản phẩm đã tồn tại."
                    },
                    name: {
                        required: "Tên sản phẩm không được để trống.",
                        maxlength: "Tên sản phẩm không được nhiều hơn 30 ký tự.",
                        remote: "Tên sản phẩm đã tồn tại."
                    },
                },
                errorPlacement: function (error, element) {
                    if (element.attr("id") == "description") {
                        $("#cdk").append(error[0]);
                        $('.ck-reset').addClass('bs');
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                },
            });
        },
    };
    /* Execute main function */

    $.fn.appProductCreate = function(options, cb) {
        this.each(function() {
            var el = $(this);

            if (!el.data("appProductCreate")) {
                var appProductCreate = new AppProductCreate(el, options, cb);
                el.data("appProductCreate", AppProductCreate);

                appProductCreate._init();
            }
        });
        return this;
    };
})(jQuery);

$(document).ready(function() {
    $("body").appProductCreate();
});
