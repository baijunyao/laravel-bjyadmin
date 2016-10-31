<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
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
        //如果没有登录；直接返回登录页
        if (!Auth::check()) {
            return redirect('login');
        }
        //判断登录的用户是否有权限
        $path=$request->path();
        $hasRole=Auth::user()->can($path);
        if ($hasRole == false) {
           die('禁止访问');
        }
        return $next($request);
    }
}
