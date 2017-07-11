<?php

use App\User;
use Illuminate\Contracts\Console\Kernel;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class BrowserKitTestCase extends BaseTestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * header 头内容
     *
     * @var array
     */
    protected $headersArray = [];

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * api 登录
     *
     * @param int $userId
     */
    protected function apiLogin($userId = 91)
    {
        $user = User::find($userId);
        $token = JWTAuth::fromUser($user);
        JWTAuth::setToken($token);
        Auth::attempt(['name' => $user->name, 'password' => $user->password]);
        $this->setApiToken($token);
    }

    /**
     * 设置api的版本
     *
     * @param int $version
     */
    public function setApiVersion($version = 1)
    {
        $this->headersArray['Accept'] = 'application/vnd.internal.v' .$version. '+json';
    }

    /**
     * 设置token
     *
     * @param $token
     */
    public function setApiToken($token)
    {
        $this->headersArray['HTTP_Authorization'] = "Bearer $token";
    }

    /**
     * 封装一个便捷的api请求post方法
     *
     * @param $route
     * @param $data
     * @param $version
     * @param int $userId
     * @return $this
     */
    public function apiPostWithHeaders($route, $data, $version, $userId = 91)
    {
        $this->setApiVersion($version);
        $this->apiLogin($userId);
        $this->post($route, $data, $this->headersArray);
        return $this;
    }

    /**
     * web 登录
     *
     * @param int $userId
     * @return $this
     */
    public function webLogin($userId = 1)
    {
        $user = User::find($userId);
        $this->be($user);
        // 获取用户数据
        $userArray = $user->toArray();
        // 存储到session中
        if ($userArray['type'] === 1 || $userArray['type'] === 4) {
            // 顾问或者分总经理 session存储城市id和城市名
            $consultant = \App\Models\User::find($userArray['id'])->consultant;
            $city = $consultant->city;
            $userArray['city_id'] = $city->id;
            $userArray['city_name'] = $city->name;
        }
        $this->withSession(['user' => $userArray]);
        return $this;
    }

}
