<?php

namespace App\Http\Controllers\Api\V1\User;

use JWTAuth;
use App\Models\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\User\Store;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * 注册
     *
     * @param Store $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Store $request)
    {
        $postData=$request->all();
        $newUser = [
            'name' => $postData['name'],
            'email' => $postData['email'],
            'password' => bcrypt($postData['password'])
        ];
        $user = User::create($newUser);
        $token = JWTAuth::fromUser($user);//根据用户得到token
        $data=[
            'token'=> $token
        ];
        return ajaxReturn(200, '注册成功', $data);
    }

    /**
     * 登录
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        //获取邮箱和密码
        $credentials = $request->only('email', 'password');
        //判断邮箱是否注册
        $count = User::where('email', $credentials['email'])->count();
        if ($count == 0) {
            ajaxReturn(404, '邮箱不存在');
        }
        //创建token
        $token = JWTAuth::attempt($credentials);
        if (!$token) {
            ajaxReturn(404, '邮箱或密码错误');
        }

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = $token = JWTAuth::attempt($credentials)) {
                $data = [
                    'status_code'=>401,
                    'message'=>'邮箱或密码错误'
                ];
                return response()->json($data, 401);
            }
        } catch (JWTException $e) {
            $data = [
                'status_code'=>401,
                'message'=>'创建token失败'
            ];
            // something went wrong whilst attempting to encode the token
            return response()->json($data, 500);
        }
        //获取token
        $token = compact('token');
        $data = [
            'status_code'=>200,
            'message'=>'登录成功',
            'data'=>[
                'token'=>$token['token']
            ]
        ];
        return response()->json($data, 200);
    }


}
