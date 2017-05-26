const gulp = require('gulp');
const elixir = require('laravel-elixir');
const webpack = require('webpack')
const WebpackDevServer = require('webpack-dev-server')
const webpackConfig = require('./webpack.config.js');
const webpackDevConfig = require('./webpack.dev.config.js');
const mergeWebpack = require('webpack-merge');

// require('laravel-elixir-vue-2');
// require('laravel-elixir-webpack-official');

/*
Elixir.webpack.config.module.loaders = [];
Elixir.webpack.mergeConfig(webpackConfig);
Elixir.webpack.mergeConfig(webpackDevConfig);
*/
gulp.task('webpack-dev-server', () =>{
	let config = mergeWebpack(webpackConfig, webpackDevConfig);
	let inlineHot = [
		'webpack/hot/dev-server',
		'webpack-dev-server/client?http://127.0.0.1:8080'
	];

	config.entry.admin = [config.entry.admin].concat(inlineHot);
	config.entry.spa = [config.entry.spa].concat(inlineHot);

	new WebpackDevServer(webpack(config), {
		hot: true,
		proxy: { "*": 'http://127.0.0.1:8000' },
		watchOptions: {
			poll: true,
			aggregateTimeout: 300
		},
		publicPath: config.output.publicPath,
		stats: { colors: true }
	}).listen(8080, "localhost", () => {
		console.log("Bundling project...")
	});
})

elixir((mix) => {
	mix.sass('./resources/assets/admin/sass/admin.scss');
	mix.sass('./resources/assets/spa/sass/spa.scss');
	mix.copy('./node_modules/materialize-css/fonts/roboto/', './public/fonts/roboto/');

	gulp.start('webpack-dev-server');

	mix.browserSync({
		host: 'localhost',
		proxy: 'http://127.0.0.1:8080'
	});
});
