const mix = require('laravel-mix');

const Autoprefixer = require('autoprefixer');
const PostcssSortMediaQueries = require('postcss-sort-media-queries');

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
mix
.js('resources/js/app.js', 'public/assets/js')
.js('resources/js/admin.js', 'public/assets/js/admin')
.sass('resources/scss/styles.scss', 'public/assets/css/')
.sass('resources/scss/admin.scss', 'public/assets/css/admin/')
.copyDirectory('resources/fonts', 'public/assets/fonts')
.copyDirectory('resources/images', 'public/assets/images')
.autoload({
    jquery: ['$', 'window.jQuery', 'jQuery'],
})
.sourceMaps(true, 'source-map')
.options({
    processCssUrls: false, // Отключаем автоматическое обновление URL в CSS
    postCss: [
        // Добавляем префиксы в CSS
        new Autoprefixer(),
        // Сортируем медиа-запросы
        PostcssSortMediaQueries
    ],
})
// Live reload
.browserSync({
    proxy: 'http://185.86.76.104:83',
    files: [
        'public/assets/**/*',
        'resources/views/**/*'
    ]
}).version();
