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
        $path=$request->path();
        $hasRole=Auth::user()->can($path);
        if ($hasRole == false) {
            die('禁止访问');
        }
        return $next($request);
    }
}
