<?php

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

$api = app('Dingo\Api\Routing\Router');

/**
 * v1版本专用接口
 */
$api->version('v1', function ($api) {
    /**
     * 共有接口 不需要登录
     */

    //home
    $api->group(['prefix'=>'home','namespace'=>'App\Http\Controllers\Api\V1\Home'], function ($api) {
        $api->group(['prefix'=>'test'], function ($api) {
            //测试版本号
            $api->get('version', 'TestController@version');
        });
    });

});


/**
 * v2版本专用接口
 */
$api->version('v2', function ($api) {
    /**
     * 共有接口 不需要登录
     */

    //home
    $api->group(['prefix'=>'home','namespace'=>'App\Http\Controllers\Api\V2\Home'], function ($api) {
        $api->group(['prefix'=>'test'], function ($api) {
            //测试版本号
            $api->get('version', 'TestController@version');
        });
    });

});

/**
 * 所有版本通用接口
 */
$api->version(['v1','v2'], function ($api) {
    /**
     * 不需要登录
     */

    // 用户相关
    $api->group(['prefix'=>'user','namespace'=>'App\Http\Controllers\Api\V1\User'], function ($api) {
        //auth 注册登录
        $api->group(['prefix'=>'auth'], function ($api) {
            //注册
            $api->post('register', 'AuthController@register');
            //登录
            $api->post('login', 'AuthController@login');
        });
    });


    /**
     * 私有接口 必须登录
     */

    //必须登录
    $api->group(['namespace'=>'App\Http\Controllers\Api\V1', 'middleware'=>['jwt.auth','jwt.refresh']], function ($api) {
        //home 模块下的路由
        $api->group(['prefix'=>'home','namespace'=>'Home'], function ($api) {

            //刷新token
            $api->get('test/refresh_token', 'TestController@refresh_token');

        });
    });

});