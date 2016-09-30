var elixir = require('laravel-elixir');
elixir(function(mix) {
    mix.sass('app.scss').browserSync({
        proxy: "lbjyadmin.com", // 指定代理url
        notify: false, // 刷新不弹出提示
        open: false, // 不自动打开浏览器
    });
});