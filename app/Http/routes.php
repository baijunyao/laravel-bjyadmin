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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin' ,'Admin\IndexController@index');

Route::get('/admin/nav/index' ,'Admin\NavController@index');
Route::get('/admin/nav/store' ,'Admin\NavController@store');
Route::get('/admin/nav/update/{id}' ,'Admin\NavController@update');
Route::get('/admin/nav/destroy' ,'Admin\NavController@destroy');
Route::get('/admin/nav/order' ,'Admin\NavController@order');

