const gulp = require('gulp');
const elixir = require('laravel-elixir');
const webpack = require('webpack')
const WebpackDevServer = require('webpack-dev-server')
const webpackConfig = require('./webpack.config.js');
const webpackDevConfig = require('./webpack.dev.config.js');
const mergeWebpack = require('webpack-merge');
const env = require('gulp-env');
const stringifyObject = require('stringify-object');
const gulpFile = require('gulp-file');
const HOST = "localhost"

gulp.task('spa-config', () =>{
	env({
		file: '.env',
		type: 'ini'
	});
	let spaConfig = require('./spa.config');
	let string = stringifyObject(spaConfig);
	return gulpFile('config.js', `module.exports = ${string};`, { src: true })
		.pipe(gulp.dest('./resources/assets/spa/js'));
});

gulp.task('webpack-dev-server', () =>{
	let config = mergeWebpack(webpackConfig, webpackDevConfig);
	let inlineHot = [
		'webpack/hot/dev-server',
		`webpack-dev-server/client?http://${HOST}:8080`
	];

	for(let key of Object.keys(config.entry)){
		config.entry[key] = [config.entry[key]].concat(inlineHot);
	}

	new WebpackDevServer(webpack(config), {
		hot: true,
		proxy: { "*": `http://${HOST}:8000` },
		watchOptions: {
			poll: true,
			aggregateTimeout: 300
		},
		publicPath: config.output.publicPath,
		stats: { colors: true }
	}).listen(8080, HOST, () => {
		console.log("Bundling project...")
	});
})

elixir((mix) => {
	mix.sass('./resources/assets/admin/sass/admin.scss');
	mix.sass('./resources/assets/spa/sass/spa.scss');
	mix.sass('./resources/assets/site/sass/site.scss');
	mix.copy('./node_modules/materialize-css/fonts/roboto/', './public/fonts/roboto/');

	gulp.start('spa-config','webpack-dev-server');

	mix.browserSync({
		host: HOST,
		proxy: `http://${HOST}:8080`
	});
});
