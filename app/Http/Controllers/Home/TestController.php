<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\AuthRule;
use Illuminate\Support\Facades\Validator;

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

    public function captcha(Request $request)
    {
        if ($request->getMethod() == 'POST')
        {
            $rules = ['captcha' => 'required|captcha'];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                echo '<p style="color: #ff0000;">失败!</p>';
            }
            else
            {
                echo '<p style="color: #00ff30;">成功 :)</p>';
            }
        }

        $form = '<form method="post" action="">';
        $form .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';
        $form .= '<p>' . captcha_img() . '</p>';
        $form .= '<p><input type="text" name="captcha"></p>';
        $form .= '<p><button type="submit" name="check">Check</button></p>';
        $form .= '</form>';
        return $form;
    }

}
