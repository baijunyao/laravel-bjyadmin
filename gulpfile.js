var elixir      = require('laravel-elixir'),
    gulp        = require('gulp'),
    sass        = require('gulp-sass'),
    minifyCss   = require('gulp-minify-css'),
    browserSync = require('browser-sync').create(),
    reload      = browserSync.reload;


new elixir.Task('bjyCss', function() {
    return gulp.src('resources/assets/sass/**/*.scss', { base: 'resources/assets/sass'})
        .pipe(sass())
        .pipe(gulp.dest('public/css'));
}).watch('resources/assets/sass/**/*.scss');

elixir(function(mix) {
    // 自动刷新
    mix.browserSync({
        proxy: "lbjyadmin.com", // 指定代理url
        notify: false, // 刷新不弹出提示
        open: false, // 不自动打开浏览器
    });
});





