const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
//************** SCRIPTS ******************
mix.copy('node_modules/@coreui/utils/dist/coreui-utils.js', 'public/js');
mix.copy('node_modules/@coreui/coreui/dist/js/coreui.bundle.min.js', 'public/js');
mix.copy('node_modules/@coreui/chartjs/dist/js/coreui-chartjs.bundle.js', 'public/js');
mix.copy('node_modules/@coreui/coreui-pro/dist/js/coreui.bundle.min.js', 'public/js/coreui-pro.bundle.min.js');
mix.copy('node_modules/toastr/build/toastr.min.js', 'public/js');
mix.copy('node_modules/js-url/url.min.js', 'public/js');
mix.copy('node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js', 'public/js');
mix.copy('node_modules/bootstrap-datepicker/dist/locales/bootstrap-datepicker.vi.min.js', 'public/js');
mix.copy('node_modules/select2/dist/js/select2.min.js', 'public/js');
mix.copy('node_modules/jquery-validation/dist/jquery.validate.min.js', 'public/js');
mix.copy('node_modules/chart.js/dist/Chart.min.js', 'public/js/chart.min.js');
mix.copy('node_modules/chartjs-plugin-labels/build/chartjs-plugin-labels.min.js', 'public/js');
mix.copy('node_modules/@yaireo/tagify/dist/tagify.min.js', 'public/js');
mix.copy('node_modules/@ckeditor/ckeditor5-build-classic/build/ckeditor.js', 'public/js');
mix.copy('node_modules/@ckeditor/ckeditor5-build-classic/build/translations/vi.js', 'public/js/ckeditor-vi.js');
mix.copy('node_modules/dropzone/dist/min/dropzone.min.js', 'public/js');

//************** CSS/SCSS ******************
mix.copy('node_modules/toastr/build/toastr.min.css', 'public/css');
mix.copy('node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css', 'public/css');
mix.copy('node_modules/jquery-datetimepicker/build/jquery.datetimepicker.min.css', 'public/css');
mix.copy('node_modules/select2/dist/css/select2.min.css', 'public/css');

//*************** BACKEND ******************
mix.js('resources/js/user.js', 'public/js');
mix.js('resources/js/modal-confirm.js', 'public/js');
mix.js('resources/js/laravel-sort.js', 'public/js');
mix.js('resources/js/popovers.js', 'public/js');
mix.js('resources/js/tooltips.js', 'public/js');
mix.js('resources/js/menu.js', 'public/js');
mix.js('resources/js/modal-create-edit.js', 'public/js');
mix.js('resources/js/upload-preview.js', 'public/js');

//*************** User ******************
mix.js('resources/js/user-create.js', 'public/js');
mix.js('resources/js/user-edit.js', 'public/js');

//*************** Category ******************
mix.js('resources/js/category.js', 'public/js');

//*************** Product ******************
mix.js('resources/js/product-create.js', 'public/js');
mix.js('resources/js/product-edit.js', 'public/js');

