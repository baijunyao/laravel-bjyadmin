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
        $uid=session('user.id');
        $auth=new Auth();
        $result=$auth->check($path,$uid);
        var_dump($result);die;
        if(!$result){
            $this->error('您没有权限访问');
        }
        return $next($request);
    }
}
