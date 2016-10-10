<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=['content'=>'内容123'];
        sendEmail(['junyao.bai@niuschools.com', 'b593026987@qq.com'], '帅白', '邮件标题', $data);
        die;
        return view('home/test/index');
    }

    public function send_email(Request $request)
    {
        $data=$request->except('_token');
        p($data);
    }

}
