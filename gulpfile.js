'use strict';


const THEME_TEXT_DOMAIN = 'primera';


var packagejson    = require('./package.json');
var gulp           = require('gulp');
var babel          = require('gulp-babel');
var mqpacker       = require('css-mqpacker');
var concat         = require('gulp-concat');
var cssnano        = require('gulp-cssnano');
var imagemin       = require('gulp-imagemin');
var livereload     = require('gulp-livereload');
var postcss        = require('gulp-postcss');
var rename         = require('gulp-rename');
var replace        = require('gulp-replace');
var sass           = require('gulp-sass');
var sourcemaps     = require('gulp-sourcemaps');
var uglify         = require('gulp-uglify');
var wpPot          = require('gulp-wp-pot');
var pngquant       = require('imagemin-pngquant');
var lostGrid       = require('lost');
var cssnext        = require('postcss-cssnext');
var easings        = require('postcss-easings');
var propertyLookup = require('postcss-property-lookup');


/**
* Process CSS
*/
gulp.task( 'css', function() {

    var stream = gulp.src( './scss/style.scss' )
        .pipe( sourcemaps.init() )
        .pipe( replace( '{{version}}', packagejson.version ) )
        .pipe( sass({ outputStyle : 'expanded' }) )
        .pipe( postcss([
            cssnext(),
            propertyLookup(),
            lostGrid(),
            easings(),
            mqpacker()
        ]) )
        .pipe( cssnano({ zindex : false }) )
        .pipe( sourcemaps.write('./') )
        .pipe( gulp.dest('./') );

    return stream;

});


/**
* Process JS
*/
gulp.task( 'js', function() {

    var files = [
        './js/primera.js',
        './js/script.js'
    ];

    var stream = gulp.src( files )
        .pipe( sourcemaps.init() )
        .pipe( concat( 'script.js' ) )
        .pipe( babel() )
        .pipe( uglify() )
        .pipe( sourcemaps.write('./') )
        .pipe( gulp.dest('./') );

    return stream;

});


/**
* Minify Images
*/
gulp.task( 'imgmin', function () {

    var stream = gulp.src('./img/*')
        .pipe( imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant()]
        }) )
        .pipe( gulp.dest('./img') );

    return stream;

});


/**
* Create translation (POT) file.
*/
gulp.task( 'potfile', function () {

    var stream = gulp.src('**/*.php')
        .pipe( wpPot({
            domain: THEME_TEXT_DOMAIN
        }) )
        .pipe( gulp.dest('./languages/'+ THEME_TEXT_DOMAIN +'.pot') );

    return stream;

});


/**
* Gulp Watch
*/
gulp.task( 'watch', function() {

    // Watch CSS
    gulp.watch( './scss/**/*.scss', ['css'] );

    // Watch JS
    gulp.watch( './js/**/*.js', ['js'] );

    // Live Reload (Remember, you must activate the browser extension!)
    livereload.listen();
    gulp.watch([
            './**/*.php',
            './script.js',
            './style.css'
        ],
        function( path ) {
            livereload.changed( path );
        }
    );

});


/**
* Gulp Default
*/
gulp.task( 'default', ['css','js','imgmin','potfile'] );
