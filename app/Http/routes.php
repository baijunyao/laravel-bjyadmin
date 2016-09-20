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

//前台首页
Route::get('/', function () {
    return view('welcome');
});

//后台首页
Route::get('/admin','Admin\IndexController@index');

//后台路由
Route::group(['prefix'=>'admin','namespace'=>'Admin'], function () {
    //菜单管理
    Route::group(['prefix'=>'admin_nav'] ,function () {
        //菜单管理
        Route::get('/index' ,'AdminNavController@index');
        Route::post('/store' ,'AdminNavController@store');
        Route::post('/update' ,'AdminNavController@update');
        Route::get('/destroy/{id}' ,'AdminNavController@destroy')->where('id', '[0-9]+');
        Route::post('/order' ,'AdminNavController@order');
    });

    //权限管理
    Route::group(['prefix'=>'rule'] ,function () {
        //权限
        Route::get('/index' ,'RuleController@index');
        Route::post('/store' ,'RuleController@store');
        Route::post('/update' ,'RuleController@update');
        Route::get('/destroy/{id}' ,'RuleController@destroy')->where('id', '[0-9]+');

        //用户组
        Route::get('/group' ,'RuleController@group');
        Route::post('/store_group' ,'RuleController@store_group');
        Route::post('/update_group' ,'RuleController@update_group');
        Route::get('/destroy_group/{id}' ,'RuleController@destroy_group')->where('id', '[0-9]+');

        //权限-用户组
        Route::get('/rule_group' ,'RuleController@rule_group');

        //用户-用户组
        Route::post('/check_user' ,'RuleController@check_user');
        Route::post('/add_user_to_group' ,'RuleController@add_user_to_group');
        Route::post('/delete_user_from_group' ,'RuleController@delete_user_from_group');

        //管理员
        Route::post('/admin_user_list' ,'RuleController@admin_user_list');
        Route::post('/add_admin' ,'RuleController@add_admin');
        Route::post('/edit_admin' ,'RuleController@edit_admin');



    });

});



