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
    .sass('resources/sass/app.scss', 'public/css')
    .copy('node_modules/font-awesome/fonts', 'public/fonts');
mix.js('resources/js/app_documentReady.js', 'public/js')

mix.styles([
    'node_modules/daterangepicker/daterangepicker.css',
    'resources/css/body-wrapper.css',
],'public/css/app_.css');


