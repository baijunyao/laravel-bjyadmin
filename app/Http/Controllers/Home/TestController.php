<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\AuthRule;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home/test/index');
    }

    /**
     * 发送邮件
     *
     * @param Request $request
     */
    public function send_email(Request $request)
    {
        $data=$request->except('_token');
        $content=[
            'content'=>$data['content']
        ];
        sendEmail($data['email'], '测试', '测试', $content);
    }

    /**
     * 上传文件
     *
     * @param Request $request
     */
    public function upload(Request $request)
    {
        $data=upload('file', 'upload/test');
        p($data);
    }

    public function page()
    {
        $data=AuthRule::where('id','>',0)->paginate(3);
        $assign=[
            'posts'=>$data,
        ];
        return view('home/test/page', $assign);
    }



}
