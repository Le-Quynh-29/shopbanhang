const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);

mix.copy('node_modules/toastr/build/toastr.min.js', 'public/js');
mix.copy('node_modules/js-url/url.min.js', 'public/js');
mix.copy('node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js', 'public/js');
mix.copy('node_modules/bootstrap-datepicker/dist/locales/bootstrap-datepicker.vi.min.js', 'public/js');
mix.copy('node_modules/select2/dist/js/select2.min.js', 'public/js');
mix.copy('node_modules/jquery-validation/dist/jquery.validate.js', 'public/js');
mix.copy('node_modules/chart.js/dist/Chart.min.js', 'public/js/chart.min.js');
