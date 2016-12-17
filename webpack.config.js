/*!
 * webpack config - cms
 * xiewulong <xiewulong@vip.qq.com>
 * create: 2016/12/17
 * since: 0.0.1
 */
const PATH = require('path');
const FS = require('fs');
const BASE_PATH = __dirname;
const MIN = process.argv.indexOf('-p') >= 0 || process.argv.indexOf('--optimize-minimize') >= 0 ? '.min' : '';

let webpack = require('webpack');
let extractTextWebpackPlugin = require('extract-text-webpack-plugin');

module.exports = {

	entry: {
		'backend': PATH.join(BASE_PATH, 'js', 'backend'),
		'frontend': PATH.join(BASE_PATH, 'js', 'frontend'),
	},

	output: {
		path: PATH.join(BASE_PATH, 'dist', 'js'),
		filename: `[name]${MIN}.js`,
	},

	externals: {},

	module: {
		loaders: [
			{
				test: /\.scss$/,
				loader: extractTextWebpackPlugin.extract('style-loader', 'css!postcss!sass'),
			},
			{
				test: /\.js[x]?$/,
				loader: 'babel',
			},
			{
				test: /\.(gif|jpg|png)$/,
				loader: 'url-loader?limit=8192&name=../images/[name].[ext]',
			},
		],
	},

	postcss: [
		require('autoprefixer'),
	],

	plugins: [
		new extractTextWebpackPlugin(PATH.join('..', 'css', `[name]${MIN}.css`)),
	],

};
