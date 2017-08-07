<?php

/**
 * 采集示例
 */
Route::group(['prefix' => 'query', 'namespace' => 'Query'], function () {
    // github
    Route::group(['prefix' => 'github'], function () {
        // 活跃度
        Route::get('contributions', 'GithubController@contributions');
        // 手动更新活跃度
        Route::get('updateContributions', 'GithubController@updateContributions');
    });
});
