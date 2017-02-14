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

if ( !function_exists('p') ) {
    // 传递数据以易于阅读的样式格式化后输出
    function p($data, $to_array = true)
    {
        // 定义样式
        $str = '<pre style="display: block;padding: 9.5px;margin: 44px 0 0 0;font-size: 13px;line-height: 1.42857;color: #333;word-break: break-all;word-wrap: break-word;background-color: #F5F5F5;border: 1px solid #CCC;border-radius: 4px;">';
        // 如果是 boolean 或者 null 直接显示文字；否则 print
        if (is_bool($data)) {
            $show_data = $data ? 'true' : 'false';
        } elseif (is_null($data)) {
            $show_data = 'null';
        } elseif (in_array(get_parent_class($data), ['Illuminate\Support\Collection', 'App\Models\Base']) && $to_array) {
            $data_array = $data->toArray();
            $show_data = '这是被转成数组的对象:<br>'.print_r($data_array, true);
        } else {
            $show_data = print_r($data, true);
        }
        $str .= $show_data;
        $str .= '</pre>';
        echo $str;
    }
}

if ( !function_exists('reEnv') ) {
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

if ( !function_exists('dbObjectToArray') ) {
    /**
     * 将包含对象的数组转换为数组
     * @param $array 包含对象的二维数组
     * @return mixed 全部转换为数组
     */
    function dbObjectToArray($array)
    {
        array_walk($array, function (&$v) {
            $v = get_object_vars($v);
        });
        return $array;
    }
}

if ( !function_exists('ajaxReturn') ) {
    /**
     * ajax返回数据
     *
     * @param string $data 需要返回的数据
     * @param int $status_code
     * @return \Illuminate\Http\JsonResponse
     */
    function ajaxReturn($status_code = 200, $data = '')
    {
        //如果如果是错误 返回错误信息
        if ($status_code != 200) {
            //增加status_code
            $data = ['status_code' => $status_code, 'message' => $data,];
            return response()->json($data, $status_code);
        }
        //如果是对象 先转成数组
        if (is_object($data)) {
            $data = $data->toArray();
        }
        /**
         * 将数组递归转字符串
         * @param  array $arr 需要转的数组
         * @return array       转换后的数组
         */
        function toString($arr)
        {
            // app 禁止使用和为了统一字段做的判断
            $reserved_words = array('id', 'title', 'description');
            foreach ($arr as $k => $v) {
                //如果是对象先转数组
                if (is_object($v)) {
                    $v = $v->toArray();
                }
                //如果是数组；则递归转字符串
                if (is_array($v)) {
                    $arr[$k] = toString($v);
                } else {
                    //判断是否有移动端禁止使用的字段
                    in_array($k, $reserved_words, true) && die('app不允许使用【' . $k . '】这个键名 —— 此提示是helper.php 中的ajaxReturn函数返回的');
                    //转成字符串类型
                    $arr[$k] = strval($v);
                }
            }
            return $arr;
        }

        //判断是否有返回的数据
        if (is_array($data)) {
            //先把所有字段都转成字符串类型
            $data = toString($data);
        }
        return response()->json($data, $status_code);
    }
}

if ( !function_exists('sendSms') ) {
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
        $config = ['app_key' => config('key.alidayu.app_key'), 'app_secret' => config('key.alidayu.app_secret')];
        $client = new Client(new App($config));
        $req = new AlibabaAliqinFcSmsNumSend;
        //发送验证码
        $req->setRecNum($phone)->setSmsParam($content)->setSmsFreeSignName($signName)->setSmsTemplateCode($templateCode);
        $result = $client->execute($req);
        if (property_exists($result, 'result')) {
            $data = array('status_code' => 200, 'message' => '验证码发送成功');
        } else {
            $msg = $result->sub_msg;
            $data = array('status_code' => 500, 'message' => $msg);
        }
        return $data;
    }
}

if ( !function_exists('sendSmsCode') ) {
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
            $data = array('status_code' => 500, 'message' => '手机号不能为空');
            return $data;
        }
        $signName = config('key.alidayu.sign_name');
        $projectName = config('key.alidayu.project_name');
        $templateCode = config('key.alidayu.template_code');
        $content = ['code' => $code, 'product' => $projectName];
        return sendSms($phone, $content, $signName, $templateCode);
    }
}

if ( !function_exists('sendEmail') ) {
    /**
     * 发送邮件函数
     *
     * @param $email            收件人邮箱  如果群发 则传入数组
     * @param $name             收件人名称
     * @param $subject          标题
     * @param $data             邮件模板中用的变量 示例：['name'=>'帅白','phone'=>'110']
     * @param string $template 邮件模板
     * @return array            发送状态
     */
    function sendEmail($email, $name, $subject, $data, $template = 'emails.test')
    {
        Mail::send($template, $data, function ($message) use ($email, $name, $subject) {
            //如果是数组；则群发邮件
            if (is_array($email)) {
                foreach ($email as $k => $v) {
                    $message->to($v, $name)->subject($subject);
                }
            } else {
                $message->to($email, $name)->subject($subject);
            }
        });
        if (count(Mail::failures()) > 0) {
            $data = array('status_code' => 500, 'message' => '邮件发送失败');
        } else {
            $data = array('status_code' => 200, 'message' => '邮件发送成功');
        }
        return $data;
    }
}

if ( !function_exists('upload') ) {
    /**
     * 上传文件函数
     *
     * @param $file             表单的name名
     * @param string $path      上传的路径
     * @param bool $childPath   是否根据日期生成子目录
     * @return array            上传的状态
     */
    function upload($file, $path = 'uploads', $childPath = true){
        // 判断请求中是否包含name=file的上传文件
        if (!request()->hasFile($file)) {
            $data=[
                'status_code' => 500,
                'message' => '上传文件为空'
            ];
            return $data;
        }
        $file = request()->file($file);
        // 判断是否多文件上传
        if (!is_array($file)) {
            $file = [$file];
        }

        // 兼容性的处理路径的问题
        if ($childPath == true) {
            $path = './'.trim($path, './').'/'.date('Ymd').'/';
        } else {
            $path = './'.trim($path, './').'/';
        }

        // 如果目录不存在；先创建目录
        if (!file_exists($path)) {
            mkdir($path,0755,true);
        }
        // 上传成功的文件
        $success = [];

        // 循环上传
        foreach ($file as $k => $v) {
            //判断文件上传过程中是否出错
            if (!$v->isValid()) {
                $data=[
                    'status_code' => 500,
                    'message' => '文件上传出错'
                ];
                return $data;
            }
            // 获取上传的文件名
            $oldName = $v->getClientOriginalName();
            // 组合新的文件名
            $newName = uniqid().'.'.$v->getClientOriginalExtension();
            // 判断上传是否失败
            if (!$v->move($path, $newName)) {
                $data=[
                    'status_code' => 500,
                    'message' => '保存文件失败'
                ];
                return $data;
            } else {
                $success[] = [
                    'name' => $oldName,
                    'path' => trim($path, '.').$newName
                ];
            }
        }

        //上传成功
        $data=[
            'status_code' => 200,
            'message' => '上传成功',
            'data' => $success
        ];
        return $data;
    }
}

if ( !function_exists('getUid') ) {
    /**
     * 返回登录的用户id
     *
     * @return mixed 用户id
     */
    function getUid()
    {
        return Auth::id();
    }
}

if ( !function_exists('save_to_file') ) {
    /**
     * 将数组已json格式写入文件
     * @param  string $file_name 文件名
     * @param  array $data 数组
     */
    function save_to_file($file_name = 'test', $data = array())
    {
        is_dir('./Temp/') || mkdir('./Temp/');
        $file_name = str_replace('.php', '', $file_name);
        $file_name = './Temp/' . $file_name . '_' . date('Y-m-d_H-i-s', time()) . '.php';
        file_put_contents($file_name, json_encode($data));
    }
}

if (! function_exists('exportExcel')) {
    /**
     * 导出excel文件
     *
     * @param $data
     * @param string $file_name
     * @param string $ext
     *
     *   示例数组：
     *  $data = array(
     *      array('data1', 'data2'),
     *      array('data5', 'data6'),
     *      array('data3', 'data4')
     *  );
     *
     */
    function exportExcel($data, $file_name = 'filename', $ext = 'xls')
    {
        Excel::create($file_name, function($excel) use($data) {
            // Our first sheet
            $excel->sheet('Sheet1', function($sheet) use($data)  {
                $sheet->fromArray($data, null, 'A1', false, false);
            });
        })->export($ext);
    }
}

if (! function_exists('reUrl')) {
    /**
     * 生成带get请求参数的url
     *
     * @param null $path
     * @param array $parameters
     * @param null $secure
     * @return string
     */
    function reUrl($path = null, $parameters = [], $secure = null)
    {
        $url = url($path, [], $secure) . '?' . http_build_query($parameters);
        return $url;
    }
}

if (!function_exists('cutStr')) {
    /**
     * 按符号截取字符串的指定部分
     * @param string $str 需要截取的字符串
     * @param string $sign 需要截取的符号
     * @param int $number 如是正数以0为起点从左向右截  负数则从右向左截
     * @return string 返回截取的内容
     */
    /*  示例
        $str='123/456/789';
        cut_str($str,'/',0);  返回 123
        cut_str($str,'/',-1);  返回 789
        cut_str($str,'/',-2);  返回 456
        具体参考 http://www.baijunyao.com/article/18
    */
    function cutStr($str, $sign, $number){
        $array = explode($sign, $str);
        $length = count($array);
        if($number < 0){
            $newArray = array_reverse($array);
            $absNumber = abs($number);
            if($absNumber > $length){
                return false;
            }else{
                return $newArray[$absNumber-1];
            }
        }else{
            if($number >= $length){
                return false;
            }else{
                return $array[$number];
            }
        }
    }
}

if ( !function_exists('reSubstr') ) {
    /**
     * 字符串截取，支持中文和其他编码
     *
     * @param string  $str 需要转换的字符串
     * @param integer $start 开始位置
     * @param string  $length 截取长度
     * @param boolean $suffix 截断显示字符
     * @param string  $charset 编码格式
     * @return string
     */
    function reSubstr($str, $start = 0, $length, $suffix = true, $charset = "utf-8") {
        $slice = mb_substr($str, $start, $length, $charset);
        $omit = mb_strlen($str) >= $length ? '...' : '';
        return $suffix ? $slice.$omit : $slice;
    }
}