<?php
/**
 * Created by PhpStorm.
 * User: shuaibai123
 * Date: 2016-9-7
 * Time: 16:49
 */
//阿里大于短信
use Flc\Alidayu\Client;
use Flc\Alidayu\App;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Auth;

//传递数据以易于阅读的样式格式化后输出
function p($data){
    // 定义样式
    $str='<pre style="display: block;padding: 9.5px;margin: 44px 0 0 0;font-size: 13px;line-height: 1.42857;color: #333;word-break: break-all;word-wrap: break-word;background-color: #F5F5F5;border: 1px solid #CCC;border-radius: 4px;">';
    // 如果是boolean或者null直接显示文字；否则print
    if (is_bool($data)) {
        $show_data=$data ? 'true' : 'false';
    }elseif (is_null($data)) {
        $show_data='null';
    }else{
        $show_data=print_r($data,true);
    }
    $str.=$show_data;
    $str.='</pre>';
    echo $str;
}

if (! function_exists('reEnv')) {
    /**
     * Gets the value of an environment variable by getenv() or $_ENV.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function reEnv($key, $default = null)
    {
        // try to read from $_ENV or $_SERVER
        if (isset($_ENV[$key])) {
            $value = $_ENV[$key];
        } elseif (isset($_SERVER[$key])) {
            $value = $_SERVER[$key];
        } else {
            return value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }

        if (strlen($value) > 1 && Str::startsWith($value, '"') && Str::endsWith($value, '"')) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}

/**
 * 将包含对象的数组转换为数组
 * @param $array 包含对象的二维数组
 * @return mixed 全部转换为数组
 */
function dbObjectToArray($array)
{
    array_walk($array,function(&$v){
        $v=get_object_vars($v);
    });
    return $array;
}

/**
 * ajax返回数据
 * @param $data  需要返回的数据
 * @param string $message 提示语句
 * @param int $status_code
 * @return \Illuminate\Http\JsonResponse
 */
function ajaxReturn($status_code=200, $message='成功', $data=null)
{
    /**
     * 将数组递归转字符串
     * @param  array $arr 需要转的数组
     * @return array       转换后的数组
     */
    function toString($arr){
        foreach ($arr as $k => $v) {
            if (is_array($v)) {
                $arr[$k]=toString($v);
            }else{
                $arr[$k]=strval($v);
            }
        }
        return $arr;
    }

    //增加status_code
    $all_data=array(
        'status_code'=>$status_code,
        'message'=>$message,
    );

    //判断是否有返回的数据
    if (is_array($data)) {
        //先把所有字段都转成字符串类型
        $data=toString($data);
        $all_data['data']=$data;
        // app 禁止使用和为了统一字段做的判断
        $reserved_words=array('id','title','description');
        foreach ($reserved_words as $k => $v) {
            if (array_key_exists($v, $data)) {
                echo 'app不允许使用【'.$v.'】这个键名 —— 此提示是helper.php 中的ajaxReturn函数返回的';
                die;
            }
        }
    }
    return response()->json($all_data, $status_code);
}

/**
 * 阿里大于发送短信
 *
 * @param $phone         发送的手机号
 * @param $content       发送的内容
 * @param $signName      签名
 * @param $templateCode  模板
 * @return array         发送状态
 */
function sendSms($phone, $content, $signName, $templateCode)
{
    // 配置信息
    $config=[
        'app_key'=>config('key.alidayu.app_key'),
        'app_secret'=>config('key.alidayu.app_secret')
    ];
    $client = new Client(new App($config));
    $req    = new AlibabaAliqinFcSmsNumSend;
    //发送验证码
    $req->setRecNum($phone)
        ->setSmsParam($content)
        ->setSmsFreeSignName($signName)
        ->setSmsTemplateCode($templateCode);
    $result = $client->execute($req);
    if (property_exists($result, 'result')) {
        $data=array(
            'status_code'=>200,
            'message'=>'验证码发送成功'
        );
    }else{
        $msg=$result->sub_msg;
        $data=array(
            'status_code'=>500,
            'message'=>$msg
        );
    }
    return $data;
}

/**
 * 阿里大于发送短信验证码
 *
 * @param $phone  发送的手机号
 * @param $code   验证码
 * @return array  发送状态
 */
function sendSmsCode($phone, $code)
{
    if (empty($phone)) {
        $data=array(
            'status_code'=>500,
            'message'=>'手机号不能为空'
        );
        return $data;
    }
    $signName=config('key.alidayu.sign_name');
    $projectName=config('key.alidayu.project_name');
    $templateCode=config('key.alidayu.template_code');
    $content=[
        'code' => $code,
        'product'=> $projectName
    ];
    return sendSms($phone, $content, $signName, $templateCode);
}

/**
 * 发送邮件函数
 *
 * @param $email            收件人邮箱  如果群发 则传入数组
 * @param $name             收件人名称
 * @param $subject          标题
 * @param $data             邮件模板中用的变量 示例：['name'=>'帅白','phone'=>'110']
 * @param string $template  邮件模板
 * @return array            发送状态
 */
function sendEmail($email, $name, $subject, $data, $template='emails.test')
{
    Mail::send($template, $data, function($message) use($email, $name, $subject) {
        //如果是数组；则群发邮件
        if (is_array($email)) {
            foreach ($email as $k => $v) {
                $message->to($v, $name)->subject($subject);
            }
        }else{
            $message->to($email, $name)->subject($subject);
        }
    });
    if (count(Mail::failures()) > 0) {
        $data=array(
            'status_code'=>500,
            'message'=>'邮件发送失败'
        );
    }else{
        $data=array(
            'status_code'=>200,
            'message'=>'邮件发送成功'
        );
    }
    return $data;
}

/**
 * 上传文件函数
 *
 * @param $file             表单的name名
 * @param string $path      上传的路径
 * @param bool $childPath   是否根据日期生成子目录
 * @return array            上传的状态
 */
function upload($file, $path='upload', $childPath=true){
    //判断请求中是否包含name=file的上传文件
    if(!request()->hasFile($file)){
        $data=[
            'status_code'=>500,
            'message'=>'上传文件为空'
        ];
        return $data;
    }
    $file = request()->file($file);
    //判断文件上传过程中是否出错
    if(!$file->isValid()){
        $data=[
            'status_code'=>500,
            'message'=>'文件上传出错'
        ];
        return $data;
    }
    //兼容性的处理路径的问题
    if ($childPath == true) {
        $path = './'.trim($path, './').'/'.date('Ymd').'/';
    }else{
        $path = './'.trim($path, './').'/';
    }
    if(!file_exists($path)){
        mkdir($path,0755,true);
    }
    //获取上传的文件名
    $oldName = $file->getClientOriginalName();
    //组合新的文件名
    $newName = uniqid().'.'.$file->getClientOriginalExtension();
    //上传失败
    if(!$file->move($path, $newName)){
        $data=[
            'status_code'=>500,
            'message'=>'保存文件失败'
        ];
        return $data;
    }
    //上传成功
    $data=[
        'status_code'=>200,
        'message'=>'上传成功',
        'data'=>[
            'old_name'=>$oldName,
            'new_name'=>$newName,
            'path'=>trim($path, '.')
        ]
    ];
    return $data;
}

/**
 * 返回登录的用户id
 *
 * @return mixed 用户id
 */
function getUid()
{
    return Auth::id();
}

