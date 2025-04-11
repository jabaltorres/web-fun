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
        main: ["public/assets/sass/**/*.scss", "!public/assets/sass/**/_*.scss"],
        watch: "public/assets/sass/**/*.scss",
        dest: "public/assets/css"
    },
    scripts: {
        src: [
            "public/assets/js/vendor/jquery-3.2.1.min.js",
            "public/assets/js/vendor/modernizr-3.5.0.min.js",
            "public/assets/js/vendor/bootstrap.js",
            "public/assets/js/plugins.js",
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
    console.log('Starting style task...');
    return gulp
        .src(paths.styles.main)
        .pipe(sourcemaps.init())
        .pipe(sass({
            precision: 8,
            includePaths: ['./node_modules/'],
            outputStyle: 'expanded',
            implementation: require('sass'),
            fiber: false,
            quietDeps: true
        }).on('error', function(err) {
            console.log('Sass Error:', err.message);
            this.emit('end');
        }))
        .pipe(postcss([
            autoprefixer(),
            cssnano({ 
                safe: true,
                preset: ['default', {
                    discardComments: {
                        removeAll: true
                    }
                }]
            })
        ]))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(paths.styles.dest))
        .pipe(browserSync.stream())
        .on('end', function() {
            console.log('Style task completed');
        });
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
            'public/**/*.php',
            'templates/**/*.php'
        ]
    });
    
    gulp.watch(paths.styles.watch, style);
    gulp.watch(paths.scripts.lint, gulp.series(lint, scripts));
    gulp.watch('public/**/*.php').on('change', browserSync.reload);
}

function clean(cb) {
    const fs = require('fs');
    const cssDir = paths.styles.dest;
    
    if (fs.existsSync(cssDir)) {
        fs.readdirSync(cssDir).forEach(file => {
            if (file.endsWith('.css') || file.endsWith('.css.map')) {
                fs.unlinkSync(`${cssDir}/${file}`);
                console.log(`Deleted: ${cssDir}/${file}`);
            }
        });
    }
    cb();
}

exports.style = style;
exports.clean = clean;
exports.imageminify = imageminify;
exports.scripts = gulp.series(lint, scripts);
exports.watch = watch;
exports.default = gulp.series(
    clean,
    gulp.parallel(style, gulp.series(lint, scripts)),
    watch
);
