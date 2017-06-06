const { mix } = require('laravel-mix');

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

mix//.js('resources/assets/js/sw.js', 'public')
    .js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/fa-icons/font-awesome.scss', 'public/css')
    .sass('resources/assets/sass/ionicons/ionicons.scss', 'public/css')
    .combine([
        'resources/assets/css/animate.css',
        'resources/assets/css/cookiesconcent.min.css',
        'resources/assets/css/inputfumi.css',
        'resources/assets/css/introjs.css',
        'resources/assets/css/qtip2.css',
        'resources/assets/css/select2.css',
        'resources/assets/css/twentytwenty.css',
    ], 'public/css/vendor.css')
    .sass('resources/assets/sass/app/pdf.scss', 'public/css')
    .sass('resources/assets/sass/app/app.scss', 'public/css')
    .version();
