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

mix.scripts([
    'resources/js/vue.js',
    'resources/js/axios.js',
    'resources/js/aos-min.js',
    'resources/js/app.js',
    'resources/js/modules/localidades.js',
    'resources/js/modules/productos.js',
], 'public/js/app.js').css('resources/css/aos-min.css', 'public/css/app.css');
