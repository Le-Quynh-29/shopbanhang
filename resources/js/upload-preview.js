/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************************!*\
  !*** ./resources/js/backend/upload-preview.js ***!
  \************************************************/
(function ($) {
  'use strict';

  var UploadPreview = function UploadPreview(element, options, cb) {
    this.element = element;
    this.$element = $(this.element);
    this.inputField = this.$element.find(".image-input");
    this.previewBox = this.$element.find(".image-preview");
    this.labelField = this.$element.find(".image-label");
    this.labelDefault = "Chọn";
    this.labelSelected = "Chọn";
    this.noLabel = false;
    this.settings = {
      successCallback: null,
      maxImageSize: 5 * 1024 * 1024
    };
    this.options = options;
  };

  UploadPreview.prototype = {
    _init: function _init() {
      this.settings = $.extend(this.settings, this.options);
      this.process();
    },
    process: function process() {
      var el = this;

      if (window.File && window.FileList && window.FileReader) {
        if (typeof $(this.inputField) !== 'undefined' && $(this.inputField) !== null) {
          $(this.inputField).change(function () {
            var files = this.files;

            if (files.length > 0) {
              var file = files[0];
              var reader = new FileReader();
              reader.addEventListener("load", function (event) {
                var loadedFile = event.target;

                if (file.size > el.settings.maxImageSize) {
                  alert('File size too much');
                  return;
                }

                if (file.type.match('image')) {
                  $(el.previewBox).css("background-image", "url(" + loadedFile.result + ")");
                  $(el.previewBox).css("background-size", "cover");
                  $(el.previewBox).css("background-position", "center center");
                  $(el.labelField).css("display", "none");
                } else {
                  console.log("This file type is not supported yet.");
                  return;
                }
              });

              if (el.noLabel === false) {
                $(el.labelField).html(el.labelSelected);
              }

              reader.readAsDataURL(file);

              if (el.settings.successCallback) {
                el.settings.successCallback();
              }
            } else {
              if (el.noLabel === false) {
                $(el.labelField).html(el.labelDefault);
              }

              $(el.previewBox).css("background-image", "none");
            }
          });
        }
      } else {
        alert("Trình duyệt của bạn không hỗ trợ chức năng xem trước ảnh.");
        return false;
      }
    }
  };
  /* Execute main function */

  $.fn.uploadPreview = function (options, cb) {
    this.each(function () {
      var el = $(this);

      if (!el.data('uploadPreview')) {
        var uploadPreview = new UploadPreview(el, options, cb);
        el.data('uploadPreview', uploadPreview);

        uploadPreview._init();
      }
    });
    return this;
  };
})(jQuery);
/******/ })()
;