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
        return view('home/test/index');
    }

    public function send_email(Request $request)
    {
        $data=$request->except('_token');
        $content=[
            'content'=>$data['content']
        ];
        sendEmail($data['email'], '测试', '测试', $content);
    }

    public function upload(Request $request)
    {
        $data=upload('file', 'upload/test');
        p($data);
    }


}
