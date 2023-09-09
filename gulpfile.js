const gulp       = require("gulp"),
    sass         = require("gulp-sass"),
    postcss      = require("gulp-postcss"),
    autoprefixer = require("autoprefixer"),
    cssnano      = require("cssnano"),
    log          = require('fancy-log'),
    concat       = require('gulp-concat'),
    rename       = require('gulp-rename'),
    terser       = require('gulp-terser');
    jshint       = require("gulp-jshint"),
    sourcemaps   = require("gulp-sourcemaps"),
    imagemin     = require('gulp-imagemin'),
    browserSync  = require("browser-sync").create();


const { series, parallel } = require('gulp');


let paths = {
    styles: {
        // By using styles/**/*.sass we're telling gulp to check all folders for any sass file
        src: "sass/**/*.scss",
        // Compiled files will end up in whichever folder it's found in (partials are not compiled)
        dest: "css"
    },
    scripts:{
        // src: "js/**/*.js",
        src: [
            "js/vendor/jquery-3.2.1.min.js",
            "js/vendor/modernizr-3.5.0.min.js",
            "js/vendor/mustache-2.3.0.min.js",
            "js/vendor/bootstrap.js",
            "js/vendor/slick.min.js",
            "js/vendor/spin.min.js",
            "js/plugins.js",
            "js/app.js",
        ],
        dest: "dist/scripts"
    },
    maps:{
        dest: "dist/maps"
    },
    images:{
        src: "public/images/*",
        dest: "public/images"
    }

    // Easily add additional paths
    // ,php: {
    //  src: '/**/*.php',
    //  dest: '...'
    // }
};


/**
 * @task defaultTask
 * Compile files from scss src, run postcss, write sourcemap, send to dest, and refresh browser
 */
function defaultTask(cb) {
    // place code for your default task here
    log('Gulp Running!');
    cb();
    watch(); // Setting gulp's default task to watch
}


/**
 * @task style
 * Compile files from scss src, run postcss, write sourcemap, send to dest, and refresh browser
 */
function style() {
    return (
        gulp
            .src(paths.styles.src)
            .pipe(sourcemaps.init())
            .pipe(sass())
            .on("error", sass.logError)
            .pipe(postcss([autoprefixer(), cssnano()]))
            .pipe(sourcemaps.write(paths.maps.dest))
            .pipe(gulp.dest(paths.styles.dest))
            // Add browsersync stream pipe after compilation
            .pipe(browserSync.stream())
    );
}


/**
 * @task minify
 * Minify PNG, JPEG, GIF and SVG images with imagemin
 */
function imageminify() {
    return (
        gulp
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
            .pipe(gulp.dest(paths.images.dest))
    );
}


/**
 * @task lint
 * Detects errors and potential problems in JavaScript code
 */
function lint() {
    return (
        gulp.src(paths.scripts.src)
            .pipe(jshint("js/.jshintrc"))
            .pipe(jshint.reporter("jshint-stylish"))
    );

}


/**
 * @task scripts
 * Concatenate, minify, and send scripts
 * `scripts` depends on `lint`
 */
function scripts() {
    return (
        gulp.src(paths.scripts.src)
            .pipe(sourcemaps.init())
            .pipe(concat('app.js'))
            .pipe(gulp.dest(paths.scripts.dest))
            .pipe(rename('scripts.min.js'))
            .pipe(terser().on('error', function(e){
                console.log(e);
            }))
            .pipe(sourcemaps.write(paths.maps.dest))
            .pipe(gulp. dest(paths.scripts.dest))
            .pipe(browserSync.stream())
            .on('end', function(){ log('Scripts Done!'); })
    );
}


// Add browsersync initialization at the start of the watch task
// We don't have to expose the reload function
// It's currently only useful in other functions
function watch() {
    browserSync.init({
        // proxy: "adaptive.dev.dd:8083"
        proxy: "http://web-fun.test/"
    });
    gulp.watch(paths.styles.src, style);
    gulp.watch(paths.scripts.src, series(lint, scripts));
    // We should tell gulp which files to watch to trigger the reload
    // This can be html or whatever you're using to develop your website
    // Note -- you can obviously add the path to the Paths object
    // gulp.watch("path/to/html/*.html", reload);
    log('Watch function completed');
}


/**
 * Default test task, running just `gulp` will
 * watch Sass files, compile changes, update sourcemaps, send compiled CSS files to their dest and launch/refresh Browsersync.
 * watch JS files, lint and report errors, concantinate, minify, report errors (again), update sourcemaps, send compiled JS files to their dest and launch/refresh Browsersync.
 */
exports.default = defaultTask;

// Function are exported to be public and can be run with the `gulp` command.
exports.watch = watch;
exports.imageminify = imageminify;
exports.scripts = series(lint, scripts);