<?php

/**
 * 前台路由
 */
Route::group(['prefix'=>'home', 'namespace'=>'Home'], function () {
    /**
     * 首页
     */
    Route::group(['prefix'=>'index'], function () {
        // 首页
        Route::get('index', 'IndexController@index');
    });

    /**
     * 整合测试系列
     */
    Route::group(['prefix'=>'demo'], function () {
        //示例首页
        Route::get('index', 'DemoController@index');
        // 发送短信
        Route::get('sendSms', 'DemoController@sendSms');
        //发送邮件
        Route::get('sendEmail', 'DemoController@sendEmail');
        //显示验证码
        Route::get('showCaptcha', 'DemoController@showCaptcha');
        //检测的验证码是否正确
        Route::post('checkCaptcha', 'DemoController@checkCaptcha');
    });
    
});