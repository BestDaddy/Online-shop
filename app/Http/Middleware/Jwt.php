<?php


namespace App\Http\Middleware;


use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class Jwt extends BaseMiddleware
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
        JWTAuth::parseToken()->authenticate();

        return $next($request);
    }

    protected function response($status, $message, $code)
    {
        return response()->json(['status' => $status, 'message' => $message], $code);
    }
}
