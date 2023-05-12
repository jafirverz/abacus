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
    .js('resources/stisla-theme/js/app.js', 'public/stisla-theme/js')
    .js('resources/stisla-theme/js/custom.js', 'public/stisla-theme/js')
    .sass('resources/stisla-theme/css/app.scss', 'public/stisla-theme/css')
    .styles(['resources/stisla-theme/css/all.css', 'resources/stisla-theme/css/style.css', 'resources/stisla-theme/css/components.css', 'resources/stisla-theme/css/step.css'], 'public/stisla-theme/css/stisla.css')
    .version();
