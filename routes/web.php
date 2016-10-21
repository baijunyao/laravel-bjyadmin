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

Route::get('test', function () {

});


/**
 * auth 登录注册退出
 */
Auth::routes();

/**
 * 管理后台
 */
Route::group(['prefix'=>'admin', 'namespace'=>'Admin', 'middleware'=>'entrust.admin'], function () {
    //后台首页
    Route::group(['prefix'=>'index'], function () {
        Route::get('/index','IndexController@index');
        Route::get('/welcome','IndexController@welcome');
    });

    //菜单管理
    Route::group(['prefix'=>'admin_nav'], function () {
        Route::get('/index' ,'AdminNavController@index');
        Route::post('/store' ,'AdminNavController@store');
        Route::post('/update' ,'AdminNavController@update');
        Route::get('/destroy' ,'AdminNavController@destroy');
        Route::post('/order' ,'AdminNavController@order');
    });

    //权限管理
    Route::group(['prefix'=>'auth_rule'] ,function () {
        //权限
        Route::get('/index' ,'AuthRuleController@index');
        Route::post('/store' ,'AuthRuleController@store');
        Route::post('/update' ,'AuthRuleController@update');
        Route::get('/destroy' ,'AuthRuleController@destroy');
    });

    //用户组管理
    Route::group(['prefix'=>'auth_group'], function (){
        //用户组
        Route::get('/index' ,'AuthGroupController@index');
        Route::post('/store' ,'AuthGroupController@store');
        Route::post('/update' ,'AuthGroupController@update');
        Route::get('/destroy' ,'AuthGroupController@destroy');
        //权限-用户组
        Route::get('/rule_group_show' ,'AuthGroupController@rule_group_show');
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
        Route::get('/search_user' ,'AuthGroupAccessController@search_user');
        Route::get('/add_user_to_group' ,'AuthGroupAccessController@add_user_to_group');
        Route::get('/delete_user_from_group' ,'AuthGroupAccessController@delete_user_from_group');

    });

    //文章管理
    Route::group(['prefix'=>'posts'], function () {
        Route::get('index', 'PostsController@index');
    });

});
