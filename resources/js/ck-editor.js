(function($) {
    "use strict";
    var el = this;
    ClassicEditor.create(document.querySelector('#content'), {
        removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed']
    }).then(function (editor) {
        el.contentEditor = editor;
    })["catch"](function (error) {
        console.error(error);
    });
})(jQuery);
