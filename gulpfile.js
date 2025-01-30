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

const paths = {
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
        lint: [
            "public/assets/js/**/*.js",
            "!public/assets/js/vendor/**",
            "!public/assets/js/main.js",
            "!public/assets/js/main.min.js",
            "!node_modules/**"
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
        .pipe(sass({
            precision: 8,
            includePaths: ['./node_modules/'],
            outputStyle: 'expanded',
            implementation: require('sass'),
            fiber: false,
            quietDeps: true,
            logger: {
                warn: function(message) {
                    if (!message.includes('Deprecation')) {
                        console.warn(message);
                    }
                }
            }
        }).on('error', function(err) {
            console.error(err.message);
            this.emit('end');
        }))
        .on('start', function() {
            console.log('Starting SASS compilation...');
        })
        .on('end', function() {
            console.log('SASS compilation complete');
        })
        .pipe(postcss([
            autoprefixer(),
            cssnano({ safe: true })
        ]))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(paths.styles.dest))
        .pipe(browserSync.reload({ stream: true }));
}

function imageminify() {
    return gulp
        .src(paths.images.src)
        .pipe(imagemin([
            imagemin.gifsicle({ interlaced: true }),
            imagemin.mozjpeg({ progressive: true }),
            imagemin.optipng({ optimizationLevel: 5 }),
            imagemin.svgo({
                plugins: [
                    { removeViewBox: false },
                    { cleanupIDs: false }
                ]
            })
        ]))
        .pipe(gulp.dest(paths.images.dest));
}

function lint() {
    return gulp
        .src(paths.scripts.lint)
        .pipe(jshint())
        .pipe(jshint.reporter("jshint-stylish"));
}

function scripts() {
    return gulp
        .src(paths.scripts.src)
        .pipe(sourcemaps.init())
        .pipe(concat('main.js'))
        .pipe(gulp.dest(paths.scripts.dest))
        .pipe(rename('main.min.js'))
        .pipe(terser())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(paths.scripts.dest))
        .pipe(browserSync.stream());
}

function watch() {
    browserSync.init({
        proxy: "https://web-fun.ddev.site/",
        notify: false,
        files: [
            paths.styles.dest + '/**/*.css',
            'public/**/*.html',
            'public/**/*.php'
        ]
    });
    
    gulp.watch(paths.styles.src, style);
    gulp.watch(paths.scripts.lint, gulp.series(lint, scripts));
}

exports.style = style;
exports.imageminify = imageminify;
exports.scripts = gulp.series(lint, scripts);
exports.watch = watch;
exports.default = gulp.series(
    gulp.parallel(style, gulp.series(lint, scripts)),
    watch
);
