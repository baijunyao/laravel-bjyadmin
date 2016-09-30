var gulp        = require('gulp'),
    sass        = require('gulp-sass'),
    minifyCss   = require('gulp-minify-css'),
    browserSync = require('browser-sync').create(),
    reload      = browserSync.reload;


// 编译全部scss但不压缩
gulp.task('css', function(){
    gulp.src('resources/assets/sass/**/*.scss', { base: 'resources/assets/sass'})
        .pipe(sass())
        .pipe(gulp.dest('public/css'))
})

// 自动刷新
gulp.task('server', function() {
    browserSync.init({
        proxy: "lbjyadmin.com", // 指定代理url
        notify: false, // 刷新不弹出提示
        open: false, // 不自动打开浏览器
    });
    // 监听scss文件编译
    gulp.watch('resources/assets/sass/**/*.scss', ['css']);
    // 监听html文件变化后刷新页面
    gulp.watch("resources/**/*.php").on("change", reload);
    // 监听css文件变化后刷新页面
    gulp.watch("public/**/*.css").on("change", reload);
});

// 监听事件
gulp.task('default', ['server'])