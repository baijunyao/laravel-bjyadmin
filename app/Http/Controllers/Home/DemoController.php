<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DemoController extends Controller
{
    /**
     * 发送验证码
     */
    public function send_sms()
    {
        $phone = '手机号';
        $code = 125556;
        $result = sendSmsCode($phone, $code);
        p($result);
    }
}
