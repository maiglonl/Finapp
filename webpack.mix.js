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

mix.sass('resources/assets/admin/sass/admin.scss', 'public/css')
   .copy('node_modules/materialize-css/fonts/roboto/', 'public/fonts/roboto/');

mix.browserSync({
	host: 'localhost',
	proxy: 'http://127.0.0.1:8000'
});