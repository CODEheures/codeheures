//var elixir = require('laravel-elixir');
//
///*
// |--------------------------------------------------------------------------
// | Elixir Asset Management
// |--------------------------------------------------------------------------
// |
// | Elixir provides a clean, fluent API for defining some basic Gulp tasks
// | for your Laravel application. By default, we are compiling the Sass
// | file for our application, as well as publishing vendor resources.
// |
// */
//
//elixir(function(mix) {
//    mix.sass('app.scss');
//});

// Configuration
var $path = {
    'css': 'public/css/',
    'scss': 'resources/assets/sass/',
    'js': 'public/js/',
    'assetJs': 'resources/assets/js/'
};

// Require
var gulp = require('gulp');
var $ = require('gulp-load-plugins')();


// Tasks
gulp.task('sass', function () {
    gulp.src($path.scss+'*.scss')
        .pipe($.sass().on('error', console.error.bind(console, "SASS Error:")
        ))
        .pipe($.autoprefixer({
            cascade:true
        }))
        .pipe($.csso({
            restructure: true,
        }))
        .pipe($.rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest($path.css))
    //.pipe($.size())
});

// Tasks
gulp.task('minifyJS', function () {
    gulp.src($path.assetJs+'*.js')
        .pipe($.minify().on('error', console.error.bind(console, "SASS Error:")
        ))
        .pipe($.minify({
            ext:{
                min:'.min.js'
            },
            noSource: true,
        }))
        .pipe(gulp.dest($path.js))
    //.pipe($.size())
});

gulp.task('default', function(){
    gulp.watch($path.scss+'*.scss', ['sass'])
    gulp.watch($path.assetJs+'*.js', ['minifyJS'])
});
