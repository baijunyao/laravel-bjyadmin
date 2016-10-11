<?php

namespace App\Http\Middleware;

use Closure;

use app\Library\Org\Auth;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //判断是否有权限
        $path=$request->path();
        $uid=getUid();
        $auth=new Auth();
        $result=$auth->check($path, $uid);
        //如果没有权限访问；则重定向到首页
        if(!$result){
            die('没有权限');
        }
        return $next($request);
    }
}
