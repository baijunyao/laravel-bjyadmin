<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Auth;
//前台首页
Route::get('/', 'Home\IndexController@index');

//后台首页
Route::get('/admin','Admin\IndexController@index');

//后台路由
Route::group(['prefix'=>'admin', 'namespace'=>'Admin', 'middleware'=>'adminAuth'], function () {
    //菜单管理
    Route::group(['prefix'=>'admin_nav'], function () {
        Route::get('/index' ,'AdminNavController@index');
        Route::post('/store' ,'AdminNavController@store');
        Route::post('/update' ,'AdminNavController@update');
        Route::get('/destroy/{id}' ,'AdminNavController@destroy')->where('id', '[0-9]+');
        Route::post('/order' ,'AdminNavController@order');
    });

    //权限管理
    Route::group(['prefix'=>'auth_rule'] ,function () {
        //权限
        Route::get('/index' ,'AuthRuleController@index');
        Route::post('/store' ,'AuthRuleController@store');
        Route::post('/update' ,'AuthRuleController@update');
        Route::get('/destroy/{id}' ,'AuthRuleController@destroy')->where('id', '[0-9]+');
    });

    //用户组管理
    Route::group(['prefix'=>'auth_group'], function (){
        //用户组
        Route::get('/index' ,'AuthGroupController@index');
        Route::post('/store' ,'AuthGroupController@store');
        Route::post('/update' ,'AuthGroupController@update');
        Route::get('/destroy/{id}' ,'AuthGroupController@destroy')->where('id', '[0-9]+');
        //权限-用户组
        Route::get('/rule_group_show/{id}' ,'AuthGroupController@rule_group_show')->where('id', '[0-9]+');
        Route::post('/rule_group_update' ,'AuthGroupController@rule_group_update');
    });

    //用户-用户组
    Route::group(['prefix'=>'auth_group_access'], function (){
        //管理员列表
        Route::get('/index' ,'AuthGroupAccessController@index');
        Route::get('/create' ,'AuthGroupAccessController@create');
        Route::post('/store' ,'AuthGroupAccessController@store');
        Route::get('/edit/{uid}' ,'AuthGroupAccessController@edit');
        Route::post('/update' ,'AuthGroupAccessController@update');

        //添加用户到用户组
        Route::get('/search_user/{group_id}' ,'AuthGroupAccessController@search_user')->where('group_id', '[0-9]+');
        Route::get('/add_user_to_group/{uid}/{group_id}' ,'AuthGroupAccessController@add_user_to_group')->where(['uid'=>'[0-9]+', 'group_id'=>'[0-9]']);
        Route::get('/delete_user_from_group/{uid}/{group_id}' ,'AuthGroupAccessController@delete_user_from_group')->where(['uid'=>'[0-9]+', 'group_id'=>'[0-9]']);

    });
});


// 注册
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

//注册成功后跳转的页面
Route::get('profile','UserController@profile');

// 登录
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// 发送密码重置链接路由
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// 密码重置路由
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

//手机注册
Route::group(['prefix'=>'user/phone_register', 'namespace'=>'User'], function () {
    Route::get('index', 'PhoneRegisterController@index');
    Route::post('store', 'PhoneRegisterController@store');
    //发送验证码
    Route::post('get_code', 'PhoneRegisterController@get_code');
});