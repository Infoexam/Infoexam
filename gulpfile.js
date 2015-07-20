var elixir = require('laravel-elixir'),
    gulp = require('gulp'),
    htmlmin = require('gulp-htmlmin');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir.config.sourcemaps = false;

elixir(function(mix)
{
    mix
        .sass([
            '*'
        ], 'resources/assets/css/infoexam.css')
        .styles([
            '*'
        ], 'public/assets/css/main.css')
        .scripts([
            'jquery-2.1.4.min.js',
            'bootstrap.min.js',
            'bootstrap-switch.min.js',
            'jquery.pjax.js',
            'nprogress.js',
            'lightbox.min.js',
            'infoexam.js'
        ], 'public/assets/js/main.js');
});

gulp.task('compress', function() {
    var opts = {
        collapseWhitespace: true,
        conservativeCollapse: true,
        removeComments: true,
        removeCommentsFromCDATA: true,
        collapseBooleanAttributes: true,
        useShortDoctype: true,
        removeEmptyAttributes: true,
        removeScriptTypeAttributes: true,
        removeStyleLinkTypeAttributes: true,
        minifyJS: true,
        minifyCSS: true
    };

    return gulp.src('./storage/framework/views/**/*')
        .pipe(htmlmin(opts))
        .pipe(gulp.dest('./storage/framework/views/'));
});