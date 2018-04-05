var webpack = require('webpack');

module.exports ={
	entry: {
		admin: './resources/assets/admin/js/admin.js',
		spa: './resources/assets/spa/js/spa.js',
		site: './resources/assets/site/js/site.js',
	},
	//externals: ['axios'],
	resolve: {
		alias: {
			vue: 'vue/dist/vue.js'
		}
	},
	output: {
		path: __dirname + '/public/build',
		filename: '[name].bundle.js',
		publicPath: '/build/'
	},
	plugins: [
		new webpack.ProvidePlugin({
			'window.$': 'jquery',
			'window.jQuery': 'jquery',
			'$': 'jquery',
			'jQuery': 'jquery'
		}),
	],
	module: {
		loaders: [
			{
				test: /\.js$/,
				exclude: /(node_modules|bowe_components)/,
				loader: 'babel-loader'
			},{
				test: /\.vue$/,
				loader: 'vue-loader'
			}
		]
	}
}