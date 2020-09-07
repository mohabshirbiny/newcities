<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
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
        try {
            if (!$user = auth('api')->user()) {
                return response()->json(["status" => 0, "message" => 'User not found', "data" => (object) []], 401);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(["status" => 0, "message" => "Token is expired", "data" => (object) []], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(["status" => 0, "message" => "Token is invalid", "data" => (object) []], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(["status" => 0, "message" => "Token is absent", "data" => (object) []], $e->getStatusCode());
        }
        return $next($request);
    }
}
