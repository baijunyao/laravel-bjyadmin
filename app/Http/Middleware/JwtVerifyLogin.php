<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
class JwtVerifyLogin
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
        $token = JWTAuth::getToken();
        if (!$token) {
            return ajaxReturn('', 'token不存在', 401);
        }
        return $next($request);
    }
}
