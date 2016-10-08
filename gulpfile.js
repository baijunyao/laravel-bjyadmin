var elixir      = require('laravel-elixir'),
    gulp        = require('gulp'),
    sass        = require('gulp-sass'),
    minifyCss   = require('gulp-minify-css'),
    uglify      = require('gulp-uglify'),
    browserSync = require('browser-sync').create(),
    reload      = browserSync.reload;

// 增加监听scss
new elixir.Task('bjyCss', function() {
    return gulp.src('resources/assets/sass/**/*.scss', { base: 'resources/assets/sass'})
        .pipe(sass())
        .pipe(gulp.dest('public/css'));
}).watch('resources/assets/sass/**/*.scss');

// 增加监听js
new elixir.Task('bjyJs', function() {
    return gulp.src('resources/assets/js/**/*.js', { base: 'resources/assets/js'})
        .pipe(uglify())
        .pipe(gulp.dest('public/js'));
}).watch('resources/assets/js/**/*.js');

elixir(function(mix) {
    // mix.version(['css/**/*.css','js/**/*.js']);
    // // 自动刷新
    // mix.browserSync({
    //     proxy: "lbjyadmin.com", // 指定代理url
    //     notify: false, // 刷新不弹出提示
    //     open: false, // 不自动打开浏览器
    // });
});





