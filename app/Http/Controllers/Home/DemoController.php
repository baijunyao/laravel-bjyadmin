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

    /**
     * 发送验证码
     */
    public function send_email()
    {
        $email = '邮箱';
        $name = '帅白';
        $subject = '测试';
        $data = [
            'content'=>'邮件内容'
        ];
        $result = sendEmail($email, $name, $subject, $data);
        p($result);
    }


}
