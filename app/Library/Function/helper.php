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
function dbObjectToArray($array){
    array_walk($array,function(&$v){
        $v=get_object_vars($v);
    });
    return $array;
}

/**
 * ajax返回数据
 * @param $data  需要返回的数据
 * @param string $error_message 提示语句
 * @param int $error_code
 * @return \Illuminate\Http\JsonResponse
 */
function ajaxReturn($data,$error_message='成功', $error_code=200){
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

    //增加error_code
    $all_data=array(
        'error_code'=>$error_code,
        'error_message'=>$error_message,
    );

    //判断是否有返回的数据
    if ($data!=='') {
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
    return response()->json($all_data);
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
function sendSms($phone, $content, $signName, $templateCode){
    // 配置信息
    $config=config('key.alidayu');
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
            'error_code'=>200,
        );
    }else{
        $msg=$result->sub_msg;
        $data=array(
            'error_code'=>500,
            'error_message'=>$msg
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
function sendSmsCode($phone, $code){
    if (empty($phone)) {
        $data=array(
            'error_code'=>500,
            'error_message'=>'手机号不能为空'
        );
        return $data;
    }
    $company_name=config('project.company_name');
    $project_name=config('project.project_name');
    $content=[
        'code' => $code,
        'product'=> $project_name
    ];
    return sendSms($phone, $content, $company_name, 'SMS_9690875');
}


