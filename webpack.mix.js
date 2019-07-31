const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

if (mix.inProduction()) {
    mix.version();
}

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/scss/app.scss', 'public/css')
    .sourceMaps()
    .browserSync({
        proxy: 'http://webdeveloper-task.test',
        open: false
    });
