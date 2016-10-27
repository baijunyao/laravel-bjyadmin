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
            return ajaxReturn(400, 'token_not_provided');
        }
        try {
            $user = $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) {
            return ajaxReturn($e->getStatusCode(), 'token_expired');
        } catch (JWTException $e) {
            return ajaxReturn($e->getStatusCode(), 'token_invalid');
        }
        if (! $user) {
            return ajaxReturn(404, 'user_not_found');
        }
        $this->events->fire('tymon.jwt.valid', $user);
        return $next($request);
    }
}
