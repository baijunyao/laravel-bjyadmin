<?php

/**
 * 前台路由
 */
Route::group(['prefix'=>'home', 'namespace'=>'Home'], function () {
    /**
     * 整合测试系列
     */
    Route::group(['prefix'=>'demo'], function () {
        //示例首页
        Route::get('index', 'DemoController@index');
        // 发送短信
        Route::get('send_sms', 'DemoController@send_sms');
        //发送邮件
        Route::get('send_email', 'DemoController@send_email');
        //显示验证码
        Route::get('show_captcha', 'DemoController@show_captcha');
        //检测的验证码是否正确
        Route::post('check_captcha', 'DemoController@check_captcha');
    });
    
});