<?php

namespace App\Http\Middleware;

use Closure;

use \Tymon\JWTAuth\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class GetUserFromToken extends BaseMiddleware
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
        if (! $token = $this->auth->setRequest($request)->getToken()) {
            return ajaxReturn(400, '未提供token');
        }
        try {
            $user = $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) {
            return ajaxReturn($e->getStatusCode(), 'token过期');
        } catch (JWTException $e) {
            return ajaxReturn($e->getStatusCode(), 'token无效');
        }
        if (! $user) {
            return ajaxReturn(404, '未找到用户');
        }
        $this->events->fire('tymon.jwt.valid', $user);
        return $next($request);
    }
}
