/*!
 * gulp file
 * xiewulong <xiewulong@vip.qq.com>
 * create: 2016/9/18
 * since: 0.0.1
 */
'use strict';

const fs = require('fs');
const path = require('path');

const gulp = require('gulp');
const plugins = require('gulp-load-plugins')();

const scssSourcePath = path.join(__dirname, 'scss', '*.scss');
const scssDistPath = path.join(__dirname, 'dist', 'css');
const scssStyles = ['compact', 'compressed'];

let ns = 'cms';
let _ns = (name, parent = ns) => (parent ? parent + ':' : '') + name;

gulp.task(_ns('scss'), () => {
	scssStyles.forEach((style) => {
		gulp.src(scssSourcePath)
			.pipe(plugins.sourcemaps.init())
			.pipe(plugins.sass({outputStyle: style}).on('error', plugins.sass.logError))
			.pipe(plugins.rename((path) => {
				if(style == 'compressed') {
					path.basename += '.min';
				}
			}))
			.pipe(plugins.sourcemaps.write('.'))
			.pipe(gulp.dest(scssDistPath));
	});
});

gulp.task(_ns('auto'), () => {
	gulp.watch(scssSourcePath, [_ns('scss')]);
});

gulp.task('release', (gulp.tasks.release ? gulp.tasks.release.dep : []).concat([_ns('scss')]));
gulp.task('default', (gulp.tasks.default ? gulp.tasks.default.dep : []).concat([_ns('auto')]));
