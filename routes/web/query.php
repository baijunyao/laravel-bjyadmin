<?php

/**
 * 采集示例
 */
Route::group(['prefix' => 'query', 'namespace' => 'Query'], function () {
    // github
    Route::group(['prefix' => 'github'], function () {
        // 提交记录
        Route::get('contributions', 'GithubController@contributions');
    });
});
