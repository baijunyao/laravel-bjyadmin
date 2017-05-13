<?php

namespace App\Models;

class GithubContribution extends Base
{
    /**
     * 应该被转化为原生类型的属性
     *
     * @var array
     */
    protected $casts = [
        'content' => 'array',
    ];
}
