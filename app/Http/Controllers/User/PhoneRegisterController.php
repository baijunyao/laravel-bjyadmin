<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;

class PhoneRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user/phone_register/index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->except('_token');
        p($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_code(Request $request)
    {
        $phone=$request->except('_token');
        $code=rand(100000, 999999);
        // 配置信息
        $config=config('key.alidayu');
        $client = new Client(new App($config));
        $req    = new AlibabaAliqinFcSmsNumSend;
        //发送验证码
        $req->setRecNum($phone)
            ->setSmsParam([
                'code' => $code,
                'product'=> '注册验证'
            ])
            ->setSmsFreeSignName('注册验证')
            ->setSmsTemplateCode('SMS_9690875');
        $result = $client->execute($req);
        if (method_exists($result, 'result')) {
            echo '发送成功';
        }else{
            echo $result->sub_msg;
        }
    }



}
