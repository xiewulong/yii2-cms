/*!
 * gulp file
 * xiewulong <xiewulong@vip.qq.com>
 * create: 2016/9/18
 * since: 0.0.1
 */
const fs = require('fs');
const path = require('path');

const gulp = require('gulp');
const plugins = require('gulp-load-plugins')();

const basePath = __dirname;
const config = {
	css: {
		src: path.join(basePath, 'scss', '*.scss'),
		dist: path.join(basePath, 'dist', 'css'),
		outputStyles: ['compact', 'compressed'],
	},
	js: {
		src: path.join(basePath, 'js'),
		dist: path.join(basePath, 'dist', 'js'),
		concat: {
			'backend.js': [
				'user.js',
				'form.js',
			],
			'frontend.js': [
				'carousel.js',
				'captcha.js',
			],
		},
	},
};

let ns = 'cms';
let _ns = (name, parent = ns) => (parent ? parent + ':' : '') + name;

gulp.task(_ns('scss'), function() {
	config.css.outputStyles.forEach((style) => {
		gulp.src(config.css.src)
			.pipe(plugins.sourcemaps.init())
			.pipe(plugins.sass({outputStyle: style}).on('error', plugins.sass.logError))
			.pipe(plugins.rename(function(path) {
				if(style == 'compressed') {
					path.basename += '.min';
				}
			}))
			.pipe(plugins.sourcemaps.write('.'))
			.pipe(gulp.dest(config.css.dist));
	});
});

let jsTasks = [];
let jsWatchConfigs = [];
for(let distName of Object.keys(config.js.concat)) {
	let jsTask = _ns('babel:concat:' + distName);
	let globs = [];
	config.js.concat[distName].forEach((file) => {
		globs.push(path.join(config.js.src, file));
	});
	gulp.task(jsTask, function() {
		gulp.src(globs)
			.pipe(plugins.sourcemaps.init())
			.pipe(plugins.babel())
			.pipe(plugins.concat(distName))
			.pipe(plugins.sourcemaps.write('.'))
			.pipe(gulp.dest(config.js.dist));
		gulp.src(globs)
			.pipe(plugins.sourcemaps.init())
			.pipe(plugins.babel())
			.pipe(plugins.concat(distName))
			.pipe(plugins.uglify())
			.pipe(plugins.rename(function(path) {
				path.basename += '.min';
			}))
			.pipe(plugins.sourcemaps.write('.'))
			.pipe(gulp.dest(config.js.dist));
	});
	jsTasks.push(jsTask);
	jsWatchConfigs.push({
		glob: globs,
		tasks: [jsTask],
	});
}

gulp.task(_ns('watch'), function() {
	gulp.watch(config.css.src, [_ns('scss')]);
	jsWatchConfigs.forEach(({glob, tasks}) => {
		gulp.watch(glob, tasks);
	});
});

gulp.task('release', (gulp.tasks.release ? gulp.tasks.release.dep : []).concat([_ns('scss')], jsTasks));
gulp.task('default', (gulp.tasks.default ? gulp.tasks.default.dep : []).concat([_ns('watch')]));
