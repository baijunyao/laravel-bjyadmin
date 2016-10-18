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

$api = app('Dingo\Api\Routing\Router');


$api->version('v1', function ($api) {
    /**
     * 共有接口 不需要登录
     */
    // 用户相关
    $api->group(['namespace'=>'App\Http\Controllers\Api\V1\Jwt'], function ($api) {
        //注册
        $api->post('register', 'AuthenticateController@register');
        //登录
        $api->post('authenticate', 'AuthenticateController@authenticate');
    });

    //home
    $api->group(['namespace'=>'App\Http\Controllers\Api\V1\Home'], function ($api) {
        //测试
    });

    /**
     * 私有接口 必须登录
     */
    //必须登录
    $api->group(['namespace'=>'App\Http\Controllers\Api\V1', 'middleware'=>['jwt.auth','jwt.refresh']], function ($api) {
        $api->group(['namespace'=>'Home'] ,function ($api) {
            $api->any('test', 'TestController@index');
        });

    });




});
