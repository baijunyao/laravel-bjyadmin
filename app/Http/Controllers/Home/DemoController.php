<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DemoController extends Controller
{
    /**
     * demo首页
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('home/demo/index');
    }

    /**
     * 发送验证码
     */
    public function sendSms()
    {
        $phone = '手机号';
        $code = 125556;
        $result = sendSmsCode($phone, $code);
        p($result);
    }

    /**
     * 发送验证码
     */
    public function sendEmail()
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

    /**
     * 展示验证码
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCaptcha()
    {
        return view('home/demo/show_captcha');
    }

    /**
     * 检测验证码是否正确
     *
     * @param Request $request
     */
    public function checkCaptcha(Request $request)
    {
        $captcha = $request->input('captcha');
        $result = captcha_check($captcha);
        if ($result) {
            echo '验证码正确';
        }else{
            echo '验证码错误';
        }
    }

}
