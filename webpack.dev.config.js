var webpack = require('webpack');

module.exports ={
	devtool: 'source-map',
	resolve: {
		alias: {
			vue: 'vue/dist/vue.js'
		}
	},
	plugins: [
		new webpack.HotModuleReplacementPlugin()
	],
}