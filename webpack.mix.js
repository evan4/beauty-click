const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    mix.js('resources/js/home.js', 'public/js')
    .js("resources/js/admin.js", "public/js")
    .sass('resources/assets/sass/home.scss', 'public/css')
    .options({
            postCss: [
                require('postcss-import')
            ]
    })
    .sass('resources/assets/sass/app.scss', 'public/css')
    .options({
            postCss: [
                require('postcss-import'),
                require('tailwindcss')
            ]
    });