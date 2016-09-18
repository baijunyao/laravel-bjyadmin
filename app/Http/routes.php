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

//将控制器方法名统一改成小写  临时使用
Route::get('/strtolower' ,function () {
    $data=DB::table('admin_navs')->get();
    $data=dbObjectToArray($data);
    array_walk($data ,function (&$v) {
       $v['mca']=strtolower($v['mca']);
    });
    foreach ($data as $k => $v){
        $edit_data=[
            'mca'=>strtolower($v['mca'])
        ];
        DB::table('admin_navs')->where('id',$v['id'])->update($edit_data);
    }
});

//管理后台的路由
Route::group(['prefix'=>'admin','namespace'=>'Admin'] ,function () {
    //后台首页
    Route::get('/' ,'IndexController@index');

    //菜单管理
    Route::get('/nav/index' ,'NavController@index');
    Route::post('/nav/store' ,'NavController@store');
    Route::post('/nav/update' ,'NavController@update');
    Route::get('/nav/destroy/{id}' ,'NavController@destroy')->where('id', '[0-9]+');;
    Route::get('/nav/order' ,'NavController@order');

});



