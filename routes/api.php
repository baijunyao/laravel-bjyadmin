<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::any('/test5', 'HomeController@test');

$api = app('Dingo\Api\Routing\Router');


//共有接口 不需要登录
$api->version('v1', function ($api) {

    // 用户相关
    $api->group(['namespace'=>'App\Http\Controllers\Api\V1\Jwt'], function ($api) {
        //注册
        $api->post('register', 'AuthenticateController@register');
        //登录
        $api->post('authenticate', 'AuthenticateController@authenticate');
        

    });
    $api->any('test', 'V1\Home\TestController@index')->middleware(['jwt.auth','jwt.refresh']);


});


//私有接口 必须登录
$api->version('v2', function ($api) {
    $api->group(['namespace'=>'App\Http\Controllers\Api'], function ($api) {
        $api->post('test', function () {
            echo 'v2';
        });
    });

});
