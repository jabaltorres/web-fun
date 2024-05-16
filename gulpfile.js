const gulp = require("gulp"),
    sass = require("gulp-sass")(require('sass')),
    postcss = require("gulp-postcss"),
    autoprefixer = require("autoprefixer"),
    cssnano = require("cssnano"),
    log = require('fancy-log'),
    concat = require('gulp-concat'),
    rename = require('gulp-rename'),
    terser = require('gulp-terser'),
    jshint = require("gulp-jshint"),
    sourcemaps = require("gulp-sourcemaps"),
    imagemin = require('gulp-imagemin'),
    browserSync = require("browser-sync").create();

const { series, parallel } = require('gulp');

let paths = {
    styles: {
        src: "sass/**/*.scss",
        dest: "public/dist/css"
    },
    scripts: {
        src: [
            "js/vendor/jquery-3.2.1.min.js",
            "js/vendor/modernizr-3.5.0.min.js",
            "js/vendor/mustache-2.3.0.min.js",
            "js/vendor/bootstrap.js",
            "js/vendor/slick.min.js",
            "js/vendor/spin.min.js",
            "js/plugins.js",
            "js/bigFlipper.js",
            "js/hostInfo.js",
            "js/toolTips.js",
            "js/app.js",
        ],
        dest: "public/dist/scripts"
    },
    maps: {
        dest: "public/dist/maps"
    },
    images: {
        src: "public/images/*",
        dest: "public/images"
    }
};

function defaultTask(cb) {
    log('Gulp Running!');
    cb();
    watch();
}

function style() {
    return gulp
        .src(paths.styles.src)
        .pipe(sourcemaps.init())
        .pipe(sass().on("error", sass.logError))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(paths.styles.dest))
        .pipe(browserSync.stream());
}

function imageminify() {
    return gulp
        .src(paths.images.src)
        .pipe(imagemin([
            imagemin.gifsicle({interlaced: true}),
            imagemin.jpegtran({progressive: true}),
            imagemin.optipng({optimizationLevel: 5}),
            imagemin.svgo({
                plugins: [
                    {removeViewBox: true},
                    {cleanupIDs: false}
                ]
            })
        ]))
        .pipe(gulp.dest(paths.images.dest));
}

function lint() {
    return gulp
        .src(paths.scripts.src)
        .pipe(jshint("js/.jshintrc"))
        .pipe(jshint.reporter("jshint-stylish"));
}

function scripts() {
    return gulp
        .src(paths.scripts.src)
        .pipe(sourcemaps.init())
        .pipe(concat('app.js'))
        .pipe(gulp.dest(paths.scripts.dest))
        .pipe(rename('scripts.min.js'))
        .pipe(terser().on('error', function(e){
            console.log(e);
        }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(paths.scripts.dest))
        .pipe(browserSync.stream());
}

function watch() {
    browserSync.init({
        proxy: "https://web-fun.ddev.site/"
    });
    gulp.watch(paths.styles.src, style);
    gulp.watch(paths.scripts.src, series(lint, scripts));
}

exports.default = series(style, series(lint, scripts), watch);
exports.style = style;
exports.imageminify = imageminify;
exports.scripts = series(lint, scripts);
exports.watch = watch;
