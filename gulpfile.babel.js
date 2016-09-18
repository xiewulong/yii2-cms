/*!
 * gulp file
 * xiewulong <xiewulong@vip.qq.com>
 * create: 2016/9/18
 * since: 0.0.1
 */
'use strict';

const scssSourcePath = __dirname + '/scss/*.scss';
const scssDistPath = __dirname + '/dist/css';

const ns = 'cms';
let _ns = name => ns + ':' + name;

const gulp = require('gulp');
const plugins = require('gulp-load-plugins')();

gulp.task(_ns('scss'), () => {
	gulp.src(scssSourcePath)
		.pipe(plugins.sourcemaps.init())
		.pipe(plugins.sass({outputStyle: 'compact'}).on('error', plugins.sass.logError))
		.pipe(plugins.sourcemaps.write('.'))
		.pipe(gulp.dest(scssDistPath));

	gulp.src(scssSourcePath)
		.pipe(plugins.sourcemaps.init())
		.pipe(plugins.sass({outputStyle: 'compressed'}).on('error', plugins.sass.logError))
		.pipe(plugins.rename((path) => {
			path.basename += '.min';
		}))
		.pipe(plugins.sourcemaps.write('.'))
		.pipe(gulp.dest(scssDistPath));
});

gulp.task(_ns('auto'), () => {
	gulp.watch(scssSourcePath, [_ns('scss')]);
});

gulp.task('release', (gulp.tasks.release ? gulp.tasks.release.dep : []).concat([_ns('scss')]));
gulp.task('default', (gulp.tasks.default ? gulp.tasks.default.dep : []).concat([_ns('auto')]));
