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


//共有接口
$api->version('v1', function ($api) {
    $api->group(['namespace'=>'App\Http\Controllers\Api'], function ($api) {
        $api->get('test', 'V1\Home\TestController@index')->middleware('jwt.auth');
        $api->any('authenticate', 'V1\Jwt\AuthenticateController@authenticate');
    });
});


//私有接口
$api->version('v2', function ($api) {
    $api->group(['namespace'=>'App\Http\Controllers\Api'], function ($api) {
        $api->post('test', 'V1\Home\TestController@test');
    });
});

$api->version('v1', ['protected' => true], function ($api) {
    $api->get('test2', function () {
       echo 2222;
    });
});