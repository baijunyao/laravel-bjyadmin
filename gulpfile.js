const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

var gulp        = require('gulp'),
    sass        = require('gulp-sass'),
    minifyCss   = require('gulp-minify-css'),
    plumber     = require('gulp-plumber'),
    uglify      = require('gulp-uglify');

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

// 增加监听scss
new elixir.Task('bjyCss', function() {
    return gulp.src('resources/assets/sass/**/*.scss', { base: 'resources/assets/sass'})
        .pipe(plumber())
        .pipe(sass())
        .pipe(gulp.dest('public/css'));
}).watch('resources/assets/sass/**/*.scss');

// 增加监听js
new elixir.Task('bjyJs', function() {
    return gulp.src('resources/assets/js/**/*.js', { base: 'resources/assets/js'})
        .pipe(gulp.dest('public/js'));
}).watch('resources/assets/js/**/*.js');


elixir(function(mix) {
    // 版本号控制
    mix.version(['css/**/*.css','js/**/*.js']);
    // 自动刷新
    mix.browserSync({
        proxy: "lbjyadmin.com:8000", // 指定代理url
        notify: false, // 刷新不弹出提示
        open: false, // 不自动打开浏览器
    });
});