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

if (! function_exists('dbObjectToArray')) {
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

if (! function_exists('ajaxReturn')) {
    /**
     * ajax返回数据 如果是200则$data是要返回的数据
     * 如果不是200 则$data 为错误的提示文字
     *
     * @param string $data 需要返回的数据
     * @param int $status_code
     * @return \Illuminate\Http\JsonResponse
     */
    function ajaxReturn($status_code = 200, $data = '')
    {
        //如果如果是错误 返回错误信息
        if ($status_code != 200 || is_string($data)) {
            //增加status_code
            $data = ['status_code' => $status_code, 'message' => $data,];
            return response()->json($data, $status_code);
        }
        //如果是对象 先转成数组
        if (is_object($data)) {
            $data = $data->toArray();
        }

        if (! function_exists('toString')) {
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
        }

        //判断是否有返回的数据
        if (is_array($data)) {
            //先把所有字段都转成字符串类型
            $data = toString($data);
        }
        return response()->json($data, $status_code);
    }
}

if (! function_exists('sendSms')) {
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

if (! function_exists('sendSmsCode')) {
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

if (! function_exists('sendEmail')) {
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

if (! function_exists('upload')) {
    /**
     * 上传文件函数
     *
     * @param $name             表单的name名
     * @param string $path      上传的路径 相对于public目录
     * @param bool $childPath   是否根据日期生成子目录
     * @return array            上传的状态
     */
    function upload($name, $path = 'uploads', $childPath = true){
        // 判断请求中是否包含name=file的上传文件
        if (!request()->hasFile($name)) {
            $data=[
                'status_code' => 501,
                'message' => '上传文件为空'
            ];
            return $data;
        }
        $file = request()->file($name);

        // 判断是否多文件上传
        if (!is_array($file)) {
            $file = [$file];
        }
        // 先去除两边空格
        $path = trim($path, '/');

        // 判断是否需要生成日期子目录
        $path = $childPath ? $path.'/'.date('Ymd') : $path;

        // 获取目录的绝对路径
        $publicPath = public_path($path.'/');

        // 如果目录不存在；先创建目录
        is_dir($publicPath) || mkdir($publicPath, 0755, true);

        // 上传成功的文件
        $success = [];

        // 循环上传
        foreach ($file as $k => $v) {
            //判断文件上传过程中是否出错
            if (! $v->isValid()) {
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
            if (!$v->move($publicPath, $newName)) {
                $data=[
                    'status_code' => 500,
                    'message' => '保存文件失败'
                ];
                return $data;
            } else {
                $success[] = [
                    'name' => $oldName,
                    'path' => '/'.$path.'/'.$newName
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

if (! function_exists('getUid')) {
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

if (! function_exists('saveToFile')) {
    /**
     * 将数组已json格式写入文件
     * @param  string $fileName 文件名
     * @param  array $data 数组
     */
    function saveToFile($fileName = 'test', $data = array())
    {
        $path = storage_path('tmp' . DIRECTORY_SEPARATOR);
        is_dir($path) || mkdir($path);
        $fileName = str_replace('.php', '', $fileName);
        $fileName = $path . $fileName . '_' . date('Y-m-d_H-i-s', time()) . '.php';
        file_put_contents($fileName, json_encode($data));
    }
}

if (! function_exists('export_excel')) {
    /**
     * 导出excel文件
     *
     * @param $data
     * @param string $file_name
     * @param string $ext
     *
     *  单个工作表 示例数组：
     *  $data = array(
     *      ['data1', 'data2'],
     *      ['data5', 'data6'],
     *      ['data3', 'data4']
     *  );
     *
     *  多个工作表 示例数组：
     *  $data = array(
     *      'Sheet1' => ['data1', 'data2'],
     *      'Sheet2' => ['data5', 'data6'],
     *      'Sheet3' => ['data3', 'data4']
     *  );
     *
     */
    function export_excel($data, $file_name = 'filename', $ext = 'xls')
    {
        foreach ($data as $k => $v) {
            // 如果是数组 直接返回
            if (is_array($v)) {
                continue;
            }
            // 如果是 stdClass 则转成数据
            if (in_array(get_class($v), ['stdClass'])) {
                $data[$k] = (array)$v;
            }
        }

        // 利用array_merge把键设置连续数组；为后续判断是否为关联数组做准备
        $data = array_merge($data);

        // 如果是索引数组 则直接创建单个工作表的excel
        if (array_values($data) === $data) {
            Excel::create($file_name, function($excel) use($data) {
                $excel->sheet('Sheet1', function($sheet) use($data)  {
                    $sheet->fromArray($data, null, 'A1', false, false);
                });
            })->export($ext);
        } else {
            // 如果是关联数组；则生成 名字为key的工作表sheet 的excel
            Excel::create($file_name, function($excel) use($data) {
                foreach ($data as $k => $v) {
                    $excel->sheet($k, function($sheet) use($v)  {
                        $sheet->fromArray($v, null, 'A1', false, false);
                    });
                }
            })->export($ext);
        }
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

if (! function_exists('cutStr')) {
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

if (! function_exists('reSubstr')) {
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

if ( !function_exists('getMonthDataByYear') ) {

    /**
     * 获取指定年份12个月每个月的英文名、天数、开始和结束日期
     *
     * @param int $year
     * @return array
     */
    function getMonthDataByYear($year = 2017)
    {
        $month = [];
        for ($i = 1; $i < 13; $i++) {
            // 组合字符串格式的日期
            $dateStr = $year.'-'.$i.'-1';
            // 把字符串日期转成时间戳
            $time = strtotime($dateStr);
            // 获取每个月的天数
            $days = date('t', $time);
            $month[] = [
                'month' => date('F', $time),
                'days' => $days,
                'start' => strtotime($year.'-'.$i.'-1 00:00:00'),
                'end' => strtotime($year.'-'.$i.'-'.$days.' 23:59:59')
            ];
        }
        return $month;
    }
}

if (! function_exists('flashMessage')){
    /**
     * 添加成功或者失败的提示
     *
     * @param string $message
     * @param bool $success
     */
    function flashMessage($message = '成功', $success = true)
    {
        $className = $success ? 'alert-success' : 'alert-danger';
        session()->flash('alert-message', $message);
        session()->flash('alert-class', $className);
    }
}

if (! function_exists('strReplaceLimit')) {
    /**
     * 对字符串执行指定次数替换
     * @param  Mixed $search   查找目标值
     * @param  Mixed $replace  替换值
     * @param  Mixed $subject  执行替换的字符串／数组
     * @param  Int   $limit    允许替换的次数，默认为 - 1，不限次数
     * @return Mixed
     */
    function strReplaceLimit($search, $replace, $subject, $limit=-1)
    {
        if(is_array($search)){
            foreach($search as $k=>$v){
                $search[$k] = '`'. preg_quote($search[$k], '`'). '`';
            }
        }else{
            $search = '`'. preg_quote($search, '`'). '`';
        }
        return preg_replace($search, $replace, $subject, $limit);
    }
}

if (! function_exists('reLogger')) {
    /**
     * 重写logger方法；可以指定文件
     *
     * @param null $message   消息名
     * @param array $context  内容
     * @param string $name    记录通道
     * @param null $filePath  文件路径
     */
    function reLogger($message = null, array $context = [], $name = 'test', $filePath = null)
    {
        if (is_null($filePath)) {
            logger($message, $context = []);
        } else {
            $log = new Logger($name);
            $log->pushHandler(
                new StreamHandler(
                    storage_path($filePath),
                    Logger::ERROR
                )
            );
            $log->addError($message, $context);
        }
    }
}

if (! function_exists('show_message')){
    /**
     * 添加成功或者失败的提示
     *
     * @param string $message
     * @param bool $success
     */
    function show_message($message = '成功', $success = true)
    {
        $alterClass = $success ? 'alert-success' : 'alert-error';
        session()->flash('alert-message', $message);
        session()->flash('alert-class', $alterClass);

    }
}