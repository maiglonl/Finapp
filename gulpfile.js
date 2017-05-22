const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');
require('laravel-elixir-webpack-official');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir((mix) => {
	mix.sass('./resources/assets/admin/sass/admin.scss');

	mix.copy('./node_modules/materialize-css/fonts/roboto/', './public/fonts/roboto/');

	mix.browserSync({
		host: 'localhost',
		proxy: 'http://127.0.0.1:8000'
	});
});
