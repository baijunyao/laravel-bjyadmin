<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/**
 * auth 登录注册退出
 */
Auth::routes();

/**
 * 登录成功后访问的页面
 */
Route::get('home', 'HomeController@index');

/**
 * get 方式的退出
 */
Route::get('logout', function () {
    Auth::logout();
    return redirect('/');
});



