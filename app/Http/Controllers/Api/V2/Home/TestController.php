<?php

namespace App\Http\Controllers\Api\V2\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TestController extends Controller
{

    /**
     * 刷新token
     */
    public function refresh_token()
    {
        echo '刷新token';
    }

    /**
     * 测试版本
     */
    public function version()
    {
        echo '这是V2版本';
    }

}
