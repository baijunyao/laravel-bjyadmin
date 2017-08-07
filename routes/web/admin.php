<?php

/**
 * 管理后台
 */
Route::group(['prefix'=>'admin', 'namespace'=>'Admin', 'middleware'=>'entrust.admin'], function () {
    //后台首页
    Route::group(['prefix'=>'index'], function () {
        Route::get('index','IndexController@index');
        Route::get('welcome','IndexController@welcome');
    });

    //菜单管理
    Route::group(['prefix'=>'admin_nav'], function () {
        Route::get('index' ,'AdminNavController@index');
        Route::post('store' ,'AdminNavController@store');
        Route::post('update' ,'AdminNavController@update');
        Route::get('destroy' ,'AdminNavController@destroy');
        Route::post('order' ,'AdminNavController@order');
    });

    //权限管理
    Route::group(['prefix'=>'permission'] ,function () {
        //权限
        Route::get('index' ,'PermissionController@index');
        Route::post('store' ,'PermissionController@store');
        Route::post('update' ,'PermissionController@update');
        Route::get('destroy' ,'PermissionController@destroy');
    });

    //角色管理
    Route::group(['prefix'=>'role'], function (){
        //角色
        Route::get('index' ,'RoleController@index');
        Route::post('store' ,'RoleController@store');
        Route::post('update' ,'RoleController@update');
        Route::get('destroy' ,'RoleController@destroy');
        //权限-角色
        Route::get('permission_role_show' ,'RoleController@permission_role_show');
        Route::post('permission_role_update' ,'RoleController@permission_role_update');
    });

    //用户-角色
    Route::group(['prefix'=>'role_user'], function (){
        //管理员列表
        Route::get('index' ,'RoleUserController@index');
        Route::get('create' ,'RoleUserController@create');
        Route::post('store' ,'RoleUserController@store');
        Route::get('edit' ,'RoleUserController@edit');
        Route::post('update' ,'RoleUserController@update');

        //添加用户到角色
        Route::get('search_user' ,'RoleUserController@search_user');
        Route::get('add_user_to_group' ,'RoleUserController@add_user_to_group');
        Route::get('delete_user_from_group' ,'RoleUserController@delete_user_from_group');

    });

    //文章管理
    Route::group(['prefix'=>'posts'], function () {
        Route::get('index', 'PostsController@index');
    });

    //用户管理
    Route::group(['prefix'=>'user'], function () {
        Route::get('index', 'UserController@index');
    });

});