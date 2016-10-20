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

use App\Models\Role;

Route::get('/', function () {
    return view('welcome');
});

Route::get('rbac', function () {
    //$owner = new Role();
    //$owner->name = 'owner';
    //$owner->display_name = 'Project Owner';
    //$owner->description = 'User is the owner of a given project';
    //$owner->save();

    $admin = new Role();
    $admin->name = 'admin';
    $admin->display_name = 'User Administrator';
    $admin->description = 'User is allowed to manage and edit other users';
    $admin->save();


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