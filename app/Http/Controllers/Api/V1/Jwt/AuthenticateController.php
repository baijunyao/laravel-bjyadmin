<?php

namespace App\Http\Controllers\Api\V1\Jwt;

use JWTAuth;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\User\Store;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateController extends Controller
{

    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                $data = [
                    'status_code'=>401,
                    'message'=>'无效的凭证'
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
        return ajaxReturn($data, '注册成功', 200);
    }
}
