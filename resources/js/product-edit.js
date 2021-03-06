(function($) {
    "use strict";

    var AppProductEdit = function AppProductEdit(element, options, cb) {
        var appProductEdit = this;
        this.element = element;
        this.$element = $(element);
        this.appUrl = _appUrl;
        this.token = _token;
        this.product = _product;
        this.descriptionEditor = '';
        this.categoryTagify = _categoryTagify;
        this.productDetails = _productDetails;
        this.details = _details;
        this.validateUniqueNameURL = _validateUniqueNameURL;
        this.validateUniqueCodeURL = _validateUniqueCodeURL;
        this.autocompleteCategory = _autocompleteCategory;
        this.$element.on('click', 'a[aria-controls="product-general"]', function (event) {
            const url = new URL(window.location.href);
            url.searchParams.set('tab', 1);
            window.history.replaceState(null, null, url);
        });
        this.$element.on('click', 'a[aria-controls="product-detail"]', function (event) {
            const url = new URL(window.location.href);
            url.searchParams.set('tab', 2);
            window.history.replaceState(null, null, url);
        });
        this.$element.on('click', 'a[aria-controls="product-attachment"]', function (event) {
            const url = new URL(window.location.href);
            url.searchParams.set('tab', 3);
            window.history.replaceState(null, null, url);
        });
        this.element.on("click", ".btn-add-row-details", function () {
            appProductEdit.onClickAddRowDetails();
        });
        this.element.on("click", ".btn-add-row-info", function () {
            appProductEdit.onClickAddRowInfo();
        });
        this.element.on("click", ".btn-remove-row-details", function () {
            appProductEdit.onClickRemoveRowDetails($(this));
        });
        this.element.on("click", ".btn-remove-row-info", function () {
            appProductEdit.onClickRemoveRowInfo($(this));
        });
        this.element.on("click", "#submit-product-detail", function () {
            appProductEdit.onSubmit();
        });

    };

    AppProductEdit.prototype = {
        _init: function _init() {
            this.ajaxSetup();
            this.initCDKEditor();
            this.initCategoryTagify();
            this.initUploadPreview();
            this.onClickAddOneRow();
            this.initValidateProductGeneral();
            this.applyValidator();
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
            ClassicEditor.create(document.querySelector('#description'), {
                language: 'vi'
            }).then(function (editor) {
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
        formatPrice: function () {
            var $table = $( "#details-table" );
            var $input = $table.find( "input.price" );
            $input.on( "keyup", function( event ) {


                // When user select text in the document, also abort.
                var selection = window.getSelection().toString();
                if ( selection !== '' ) {
                    return;
                }

                // When the arrow keys are pressed, abort.
                if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
                    return;
                }


                var $this = $( this );

                // Get the value.
                var input = $this.val();

                var input = input.replace(/[\D\s\._\-]+/g, "");
                input = input ? parseInt( input, 10 ) : 0;

                $this.val( function() {
                    return ( input === 0 ) ? "" : input.toLocaleString( "en-US" );
                } );
            });
        },
        initValidateProductGeneral: function () {
            var el = this;
            $.validator.addMethod("cdk_editor_required", function () {
                var length = el.descriptionEditor.getData().trim().length;
                return length > 0;
            }, "M?? ta?? kh??ng ????????c ?????? tr????ng.");

            $("#form-product-update").validate({
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
                                id: function () {
                                    return el.product.id;
                                },
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
                                id: function () {
                                    return el.product.id;
                                },
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
                        required: "M?? s???n ph???m kh??ng ???????c ????? tr???ng.",
                        maxlength: "M?? s???n ph???m kh??ng ???????c nhi???u h??n 30 k?? t???.",
                        remote: "M?? s???n ph???m ???? t???n t???i."
                    },
                    name: {
                        required: "T??n s???n ph???m kh??ng ???????c ????? tr???ng.",
                        maxlength: "T??n s???n ph???m kh??ng ???????c nhi???u h??n 30 k?? t???.",
                        remote: "T??n s???n ph???m ???? t???n t???i."
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
        onClickAddOneRow: function () {
            $('#details-table #tbody').html('');
            var productDetails = this.productDetails;
            if (productDetails.length !== 0) {
                $.each(productDetails, function (index, value) {
                    var rowCount = $('#details-table tr').length;
                    var formatNumber = new Intl.NumberFormat('en-US', {style: 'decimal'}).format(value.price);
                    $('#details-table #tbody').append(
                        '<tr>' +
                        '<td><input class="form-control color"  name="color[' + rowCount + ']" data-id="' + rowCount + '" ' +
                        ' id="color_' + rowCount + '" type="text" value="'+ value.color +'"></td>' +
                        '<td><input class="form-control size"  name="size[' + rowCount + ']" id="size_' + rowCount + '" type="text"' +
                        ' value="'+ value.size +'"></td>' +
                        '<td><input class="form-control price"  name="price[' + rowCount + ']"  type="text" ' +
                        'value="'+ formatNumber +'"></td>' +
                        '<td><input class="form-control quantity"  name="quantity[' + rowCount + ']" type="text" value="'+ value.quantity +'"></td>' +
                        '<td>' +
                        '<div class="float-right" id="btn-remove' + rowCount + '" >' +
                        '<div class="text-primary btn-remove-row mt-2">' +
                        ' <i class="fas fa-trash fa-lg"></i>' +
                        '</div>' +
                        '</div>' +
                        '</td>' +
                        '</tr>');
                });
                $('#btn-remove1').remove();
            } else {
                var rowCount = $('#details-table tr').length;
                var row =
                    '<tr>' +
                    '<td><input class="form-control color"  name="color[' + rowCount + ']" data-id="' + rowCount + '" id="color_' + rowCount + '" type="text"></td>' +
                    '<td><input class="form-control size"  name="size[' + rowCount + ']" id="size_' + rowCount + '" type="text"></td>' +
                    '<td><input class="form-control price"  name="price[' + rowCount + ']"  type="text"></td>' +
                    '<td><input class="form-control quantity"  name="quantity[' + rowCount + ']" type="text"></td>' +
                    '<td >' +
                    '</td>' +
                    '</tr>';

                $('#details-table #tbody').append(row);
            }


            $('#information-table #tbody').html('');
            var details = JSON.parse(this.details);
            $.each(details, function (index, value) {
                var rowCountDetail = $('#information-table tr').length;
                $('#information-table #tbody').append(
                    '<tr>' +
                    '<td><input class="form-control title"  name="title[' + rowCountDetail + ']" data-id="' + rowCountDetail + '" ' +
                    ' id="title_' + rowCountDetail + '" type="text" value="'+ value.title +'"></td>' +
                    '<td><input class="form-control content-product"  name="content[' + rowCountDetail + ']" id="content_' + rowCountDetail + '" type="text"' +
                    ' value="'+ value.content +'"></td>' +
                    '<td class="text-center width-50">' +
                    '<div class="text-primary btn-remove-row-info">' +
                    ' <i class="fas fa-trash fa-lg"></i>' +
                    '</div>' +
                    '</td>' +
                    '</tr>');
            });
            this.formatPrice();
            this.applyValidator();
        },
        onClickAddRowDetails: function () {
            var rowCount = $('#details-table tr').length;
            var row =
                '<tr>' +
                '<td><input class="form-control color"  name="color[' + rowCount + ']" data-id="' + rowCount + '" id="color_' + rowCount + '" type="text"></td>' +
                '<td><input class="form-control size"  name="size[' + rowCount + ']" id="size_' + rowCount + '" type="text"></td>' +
                '<td><input class="form-control price"  name="price[' + rowCount + ']"  type="text"></td>' +
                '<td><input class="form-control quantity"  name="quantity[' + rowCount + ']" type="text"></td>' +
                '<td >' +
                '<div class="text-primary btn-remove-row-details">' +
                    ' <i class="fas fa-trash fa-lg"></i>' +
                '</div>' +
                '</td>' +
                '</tr>';

            $('#details-table #tbody').append(row);
            this.formatPrice();
            this.applyValidator();

        },
        onClickAddRowInfo: function () {
            var rowCountInfo = $('#information-table tr').length;
            var rowInfo =
                '<tr>' +
                '<td><input class="form-control title"  name="title[' + rowCountInfo + ']" id="title_' + rowCountInfo + '" type="text"></td>' +
                '<td><input class="form-control content-product"  name="content[' + rowCountInfo + ']" id="content_' + rowCountInfo + '" type="text"></td>' +
                '<td class="text-center width-50">' +
                '<div class="text-primary btn-remove-row-info">' +
                ' <i class="fas fa-trash fa-lg"></i>' +
                '</div>' +
                '</td>' +
                '</tr>';

            $('#information-table #tbody').append(rowInfo);
            this.applyValidator();
        },
        applyValidator: function () {
            $.validator.addMethod("unique", function (value, element) {
                let arr = [];
                $("input[name*='title']").each(function () {
                    var title = $(this).val();

                    if (title !== "" && $(element).attr('id') != $(this).attr('id')) {
                        arr.push($(this).val());
                    }
                });

                return arr.indexOf(value) === -1;
            }, 'Ti??u ????? ???? t???n t???i!');


            $.validator.addMethod(
                "regex",
                function(value, element, regexp) {
                    var re = new RegExp(regexp);
                    return this.optional(element) || re.test(value);
                },
                "Please check your input."
            );
            $("#form-create-detail").validate();

            $("input[name*='color']").each(function () {
                $(this).rules("add",
                    {
                        maxlength: 20,
                        messages: {
                            maxlength: "M??u ch??? ???????c nh???p t???i ??a 10 k?? t???.",
                        },
                    });
            });
            $("input[name*='size']").each(function () {
                $(this).rules("add",
                    {
                        required: true,
                        maxlength: 10,
                        messages: {
                            required: "K??ch c??? kh??ng ???????c ????? tr???ng.",
                            maxlength: "K??ch c??? ch??? ???????c nh???p t???i ??a 10 k?? t???."
                        },

                    });
            });
            $("input[name*='price']").each(function () {
                $(this).rules("add",
                    {
                        required: true,
                        maxlength: 8,
                        messages: {
                            required: "Gi?? kh??ng ???????c ????? tr???ng.",
                            maxlength: "Gi?? tr??? nh???p v??o qu?? l???n."
                        },

                    });
            });
            $("input[name*='quantity']").each(function () {
                $(this).rules("add",
                    {
                        required: true,
                        regex: /^-?\d*(\.\d+)?$/,
                        min: 0,
                        max: 1000000,
                        messages: {
                            required: "S??? l?????ng kh??ng ???????c ????? tr???ng.",
                            regex: "Gi?? tr??? nh???p v??o ph???i l?? s??? v?? l???n h??n 0",
                            min: "Gi?? tr??? nh???p v??o ph???i l?? s??? v?? l???n h??n 0",
                            max: "S??? l?????ng qu?? l???n, vui l??ng ki???m tra l???i.",
                        },

                    });
            });
            $("input[name*='title']").each(function () {
                $(this).rules("add",
                    {
                        required: true,
                        unique: true,
                        maxlength: 50,
                        messages: {
                            required: "Ti??u ????? kh??ng ???????c ????? tr???ng.",
                            maxlength: "Ti??u ????? ch??? ???????c nh???p t???i ??a 10 k?? t???.",
                        },
                    });
            });
            $("input[name*='content']").each(function () {
                $(this).rules("add",
                    {
                        required: true,
                        maxlength: 255,
                        messages: {
                            required: "N???i dung kh??ng ???????c ????? tr???ng.",
                            maxlength: "N???i dung ch??? ???????c nh???p t???i ??a 255 k?? t???.",
                        },
                    });
            });
        },
        onClickRemoveRowDetails: function (t) {
            var tr = t.closest('tr');
            tr.remove();
        },
        onClickRemoveRowInfo: function (t) {
            var tr = t.closest('tr');
            tr.remove();
        },
        getDetail: function () {
            var objDetail = $('#details-table #tbody tr').map(function (i) {
                var row = {};
                var color = $(this).find('.color').val();
                var size = $(this).find('.size').val();
                var price = $(this).find('.price').val();
                var quantity = $(this).find('.quantity').val();
                row['color'] = color;
                row['size'] = size;
                row['price'] = price;
                row['quantity'] = Number(quantity);
                return row;

            }).get();

            return objDetail;
        },
        getInfo: function () {
            var objInfo = $('#information-table #tbody tr').map(function (i) {
                var row = {};
                var title = $(this).find('.title').val();
                var content = $(this).find('.content-product').val();
                row['title'] = title;
                row['content'] = content;
                return row;

            }).get();

            return objInfo;
        },
        onSubmit: function () {
            var el = this;
            var listDetail = el.getDetail();
            var listInfo = el.getInfo();
            $('#details').val(JSON.stringify(listDetail));
            $('#info').val(JSON.stringify(listInfo));
            $('#form-create-detail').submit();
        },
    };
    /* Execute main function */

    $.fn.appProductEdit = function(options, cb) {
        this.each(function() {
            var el = $(this);

            if (!el.data("appProductEdit")) {
                var appProductEdit = new AppProductEdit(el, options, cb);
                el.data("appProductEdit", AppProductEdit);

                appProductEdit._init();
            }
        });
        return this;
    };
})(jQuery);

$(document).ready(function() {
    $("body").appProductEdit();
});
