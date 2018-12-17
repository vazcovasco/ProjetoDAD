/*jshint esversion: 6 */
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

mix.js('resources/js/vue.js', 'public/js')
<<<<<<< HEAD
   .sass('resources/sass/app.scss', 'public/css');
=======
   .sass('resources/sass/app.scss', 'public/css');
>>>>>>> 9106d4c70c4f89c0699b7bc63bb80d40119ae780
