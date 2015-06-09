var elixir = require('laravel-elixir');

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

elixir(function(mix)
{
    mix
        .sass([
            '*'
        ], 'public/assets/css/temp')
        .styles([
            '*'
        ], 'public/assets/css/temp/all.css')
        .stylesIn('public/assets/css/temp', 'public/assets/css/main.css')
        .scripts([
            'jquery-2.1.4.min.js',
            'bootstrap.min.js',
            'bootstrap-switch.min.js',
            'jquery.pjax.js',
            'nprogress.js',
            'lightbox.min.js'
        ], 'public/assets/js/main.js');
});