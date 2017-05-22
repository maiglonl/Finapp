var webpack = require('webpack');

module.exports ={
	entry: {
		admin: 'resources/assets/admin/js/admin.js'
	},
	resolve: {
		alias: {
			vue: 'vue/dist/vue.js'
		}
	},
	output: {
		path: __dirname + '/public/build',
		filename: '[name].bundle.js',
		publicPath: '/dist/'
	},
	plugins: [
		new webpack.ProvidePlugin({
			'window.$': 'jquery',
			'window.jQuery': 'jquery'
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