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

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::post('/test', 'Api\V1\Jwt\AuthenticateController@register');

Route::get('/logout', function () {
    Auth::logout();
    echo '退出';
});

/**
 * 管理后台
 */
Route::group(['prefix'=>'admin', 'namespace'=>'Admin'], function () {
   Route::group(['prefix'=>'index'], function () {
      Route::get('index', 'IndexController@index');
   });
});