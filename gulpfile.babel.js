/*!
 * gulp file
 * xiewulong <xiewulong@vip.qq.com>
 * create: 2016/9/18
 * since: 0.0.1
 */
const PATH = require('path');

const GULP = require('gulp');
const PLUGINS = require('gulp-load-plugins')();

const BASE_PATH = __dirname;
const CONFIG = {
	css: {
		src: PATH.join(BASE_PATH, 'scss', '**', '*.scss'),
		dist: PATH.join(BASE_PATH, 'dist', 'css'),
		outputStyles: ['compact', 'compressed'],
	},
	js: {
		src: PATH.join(BASE_PATH, 'js'),
		dist: PATH.join(BASE_PATH, 'dist', 'js'),
		concat: {
			'backend.js': {
				header: {
					author: 'xiewulong',
					email: 'xiewulong@vip.qq.com',
					create: '2016/8/8',
					since: '0.0.1',
				},
				deps: [
					'backend.user.js',
					'backend.form.js',
				],
			},
			'frontend.js': {
				header: {
					author: 'xiewulong',
					email: 'xiewulong@vip.qq.com',
					create: '2016/8/8',
					since: '0.0.1',
				},
				deps: [
					'frontend.carousel.js',
					'frontend.captcha.js',
				],
			},
		},
	},
};

let ns = 'cms';
let _ns = (name, parent = ns) => (parent ? parent + ':' : '') + name;

GULP.task(_ns('scss'), function() {
	CONFIG.css.outputStyles.forEach((style) => {
		GULP.src(CONFIG.css.src)
			.pipe(PLUGINS.sourcemaps.init())
			.pipe(PLUGINS.sass({outputStyle: style}).on('error', PLUGINS.sass.logError))
			.pipe(PLUGINS.rename(function(path) {
				if(style == 'compressed') {
					path.basename += '.min';
				}
			}))
			.pipe(PLUGINS.sourcemaps.write('.'))
			.pipe(GULP.dest(CONFIG.css.dist));
	});
});

let jsTasks = [];
let jsWatchConfigs = [];
for(let distName of Object.keys(CONFIG.js.concat)) {
	let concatConfig = CONFIG.js.concat[distName];
	let jsTask = _ns('babel:concat:' + distName);
	let globs = [];
	concatConfig.deps.forEach((file) => {
		globs.push(PATH.join(CONFIG.js.src, file));
	});
	GULP.task(jsTask, function() {
		GULP.src(globs)
			.pipe(PLUGINS.sourcemaps.init())
			.pipe(PLUGINS.concat(distName))
			.pipe(PLUGINS.babel())
			.pipe(PLUGINS.header([
				'/*!',
				' * ' + distName.replace('.js', ''),
				' * ' + concatConfig.header.author + ' <' + concatConfig.header.email + '>',
				' * create: ' + concatConfig.header.create,
				' * since: ' + concatConfig.header.since,
				' */',
			].join('\n') + '\n'))
			.pipe(PLUGINS.sourcemaps.write('.'))
			.pipe(GULP.dest(CONFIG.js.dist));
		GULP.src(globs)
			.pipe(PLUGINS.sourcemaps.init())
			.pipe(PLUGINS.concat(distName))
			.pipe(PLUGINS.babel())
			.pipe(PLUGINS.uglify())
			.pipe(PLUGINS.header([
				'/*!',
				' * ' + distName.replace('.js', ' minify'),
				' * ' + concatConfig.header.author + ' <' + concatConfig.header.email + '>',
				' * create: ' + concatConfig.header.create,
				' * since: ' + concatConfig.header.since,
				' */',
			].join('\n') + '\n'))
			.pipe(PLUGINS.rename(function(path) {
				path.basename += '.min';
			}))
			.pipe(PLUGINS.sourcemaps.write('.'))
			.pipe(GULP.dest(CONFIG.js.dist));
	});
	jsTasks.push(jsTask);
	jsWatchConfigs.push({
		glob: globs,
		tasks: [jsTask],
	});
}

GULP.task(_ns('watch'), function() {
	GULP.watch(CONFIG.css.src, [_ns('scss')]);
	jsWatchConfigs.forEach(({glob, tasks}) => {
		GULP.watch(glob, tasks);
	});
});

GULP.task('release', (GULP.tasks.release ? GULP.tasks.release.dep : []).concat([_ns('scss')], jsTasks));
GULP.task('default', (GULP.tasks.default ? GULP.tasks.default.dep : []).concat([_ns('watch')]));
