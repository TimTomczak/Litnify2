const mix = require('laravel-mix');
const workboxPlugin = require('workbox-webpack-plugin');
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
    'resources/css/toast-position.css',
],'public/css/custom.css');

mix.webpackConfig({
    plugins: [
        // new workboxPlugin.GenerateSW({
        //     maximumFileSizeToCacheInBytes: '10000000'
        // })
        new workboxPlugin.InjectManifest({
            swSrc: './resources/js/sw.js', // more control over the caching
            swDest: 'service-worker.js',
            maximumFileSizeToCacheInBytes: '10000000',
            // importsDirectory: 'service-worker' // have a dedicated folder for sw files
        })
    ],
    output: {
        publicPath: ''
    }
})
