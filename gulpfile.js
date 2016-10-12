const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss')
        .webpack('app.js');
    mix.browserSync({
        proxy: "lbjyadmin.com:8000", // 指定代理url
        notify: false, // 刷新不弹出提示
        open: false, // 不自动打开浏览器
    });
});