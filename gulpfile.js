const gulp = require('gulp');
const sass = require('gulp-sass');
const concat = require('gulp-concat');
const debug = require('gulp-debug');
const rename = require('gulp-rename');
const del = require('del');
const minifyCss = require('gulp-clean-css');
const terser = require("gulp-terser");

var buildDir = 'public/assets';
var assetsDir = 'resources/assets';

var scssWatchFiles = [
	assetsDir + '/sass/**/*.scss'
];

var files = {
	scss: [
		assetsDir + '/sass/app.scss',
	],
	js: [
		assetsDir + '/js/*.js',
		assetsDir + '/js/**/*.js',
	]
};

var vendorFiles = {
	js: [
		'node_modules/jquery/dist/jquery.js',
		'node_modules/bootstrap/dist/js/bootstrap.js',
		'node_modules/parsleyjs/dist/parsley.js',
		'node_modules/parsleyjs/dist/i18n/pt-br.js',
		'node_modules/bootbox/bootbox.min.js',
		'node_modules/jquery-mask-plugin/dist/jquery.mask.js',
		'node_modules/moment/moment.js',
		'node_modules/moment/locale/pt-br.js',
		'node_modules/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.js',
		'node_modules/@fancyapps/fancybox/dist/jquery.fancybox.js',
		'node_modules/croppie/croppie.js',
		'node_modules/select2/dist/js/select2.js',
		'node_modules/select2/dist/js/i18n/pt-BR.js',
		'node_modules/superfish/dist/js/superfish.js',
		'node_modules/select2/dist/js/select2.min.js',
	],
	css: [
		'node_modules/bootstrap/dist/css/bootstrap.css',
		'node_modules/@fortawesome/fontawesome-free/css/all.css',
		'node_modules/animate.css/animate.css',
		'node_modules/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.css',
		'node_modules/@fancyapps/fancybox/dist/jquery.fancybox.css',
		'node_modules/croppie/croppie.css',
		'node_modules/select2/dist/css/select2.css',
		'node_modules/superfish/dist/css/superfish.css',
	]
};

// Concatena os arquivos sass, converte e comprime em css
function sass2Css(files, outputName, env = 'dev') {

	var sassConfig = {
        outputStyle: env == 'prod' ? 'compressed' : 'expanded'
    };

	return gulp.src(files)
    .pipe(debug({ title: 'css-debug' }))
    .pipe(concat(outputName + '.scss'))
    .pipe(sass(sassConfig).on('error', sass.logError))
    .pipe(rename(outputName + '.min.css'))
    .pipe(gulp.dest(buildDir + '/css'));
}

// Concatena e mimifica os arquivos css se estiver em produção
function css(files, outputName, env = 'dev') {

	// Obtém o objeto com as chamadas.
	var obj = gulp.src(files)
    .pipe(debug({ title: 'css-debug' }))
    .pipe(concat(outputName + '.css'))
    .pipe(rename(outputName + '.min.css'));

	// Caso seja produção, minifica o css.
	if (env == 'prod') {
		obj.pipe(minifyCss({ compatibility: 'ie8' }));
	}

	return obj.pipe(gulp.dest(buildDir + '/css'));
}

// Concatena os arquivos js e comprime em js
function js2Mimify(files, outputName , env = 'dev') {

	var obj = gulp.src(files)
    .pipe(debug({ title: "js-debug" }))
    .pipe(concat(outputName + ".js"));

    var gulpTerserOptions = {
        output: { comments: false }
    };

    if (env == "prod") {
        obj = obj.pipe(terser(gulpTerserOptions));
    }

    return obj.pipe(rename(outputName + ".min.js"))
	.pipe(gulp.dest(buildDir + "/js"));
}

// Limpa o diretório de build
function cleanBuild() {
	return del([buildDir]);
}

// Copia as imagens da aplicação
function images() {

	return gulp.src("images/**/*", { cwd : assetsDir })
 	.pipe(gulp.dest("public/assets/images"));
}

// Copia as fontes de aplicação
function fonts() {

    return gulp.src("fonts/**/*", { cwd : assetsDir })
    .pipe(gulp.dest("public/assets/fonts"));
}

// ---------------------------------------------------------------------------------------------------
// Tasks para CSS/SCSS

function scssTask(files, name, mode) {
    return sass2Css(files, name, mode);
}

function cssTask(files, name, mode) {
    return css(files, name, mode);
}

function cssDev() {
    return scssTask(files.scss, 'app');
}

function cssProd() {
    return scssTask(files.scss, 'styles', 'prod');
}

function vendorCssDev() {
	return cssTask(vendorFiles.css, 'vendor');
}

function vendorCssProd() {
	return cssTask(vendorFiles.css, 'vendor', 'prod');
}

// ---------------------------------------------------------------------------------------------------
// Tasks para JS

function jsTask(files, name, mode) {
    return js2Mimify(files, name, mode);
}

function jsDev() {
    return jsTask(files.js, 'scripts');
}

function jsProd() {
    return jsTask(files.js, 'scripts', 'prod');
}

function vendorJsDev() {
	return jsTask(vendorFiles.js, 'vendor');
}

function vendorJsProd() {
	return jsTask(vendorFiles.js, 'vendor', 'prod');
}

// ---------------------------------------------------------------------------------------------------
// Tasks avulsas

/**
 * Monitora a alteração e realiza a publicação dos arquivos
 * @returns
 */
function watch() {

    // Atualizar arquivos SCSS
    gulp.watch(scssWatchFiles, cssDev);

    // Atualizar arquivos JS
    gulp.watch(files.js, jsDev);
}

gulp.task('clean', gulp.series(cleanBuild));

gulp.task('build', gulp.series(
    cleanBuild,
    cssProd, jsProd,
    vendorCssProd, vendorJsProd,
    images,
    fonts,
));

gulp.task('default', gulp.series(
    cleanBuild,
    cssDev, jsDev,
    vendorCssDev, vendorJsDev,
    images,
    fonts
));

gulp.task('watch', gulp.series('default', watch));
