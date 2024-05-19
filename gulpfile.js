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
        src: "public/assets/sass/**/*.scss",
        dest: "public/assets/css"
    },
    scripts: {
        src: [
            "public/assets/js/vendor/jquery-3.2.1.min.js",
            "public/assets/js/vendor/modernizr-3.5.0.min.js",
            "public/assets/js/vendor/mustache-2.3.0.min.js",
            "public/assets/js/vendor/bootstrap.js",
            "public/assets/js/vendor/slick.min.js",
            "public/assets/js/vendor/spin.min.js",
            "public/assets/js/plugins.js",
            "public/assets/js/bigFlipper.js",
            "public/assets/js/hostInfo.js",
            "public/assets/js/toolTips.js",
            "public/assets/js/app.js",
        ],
        dest: "public/assets/js"
    },
    maps: {
        dest: "public/assets/maps"
    },
    images: {
        src: "public/assets/images/*",
        dest: "public/assets/images"
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
        .pipe(jshint("public/assets/js/.jshintrc"))
        .pipe(jshint.reporter("jshint-stylish"));
}

function scripts() {
    return gulp
        .src(paths.scripts.src)
        .pipe(sourcemaps.init())
        .pipe(concat('main.js'))
        .pipe(gulp.dest(paths.scripts.dest))
        .pipe(rename('main.min.js'))
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
