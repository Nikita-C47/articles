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

// Собираем скрипты приложения
mix.js('resources/js/app.js', 'public/js')
    // Собираем стили
   .sass('resources/sass/app.scss', 'public/css')
    // Добавляем FA
    .styles([
        'public/css/app.css',
        'node_modules/@fortawesome/fontawesome-free/css/all.min.css',
    ], 'public/css/app.css')
    // Копируем изображения
    .copyDirectory('resources/img', 'public/img')
    // Копируем иконки
    .copyDirectory('resources/webicons', 'public')
    // Копируем папку шрифтов FA
    .copyDirectory('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts');
