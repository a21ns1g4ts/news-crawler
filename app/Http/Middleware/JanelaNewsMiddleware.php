<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class JanelaNewsMiddleware
 * @package App\Http\Middleware
 */
class JanelaNewsMiddleware
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
        if ($request->header('JanelaNewsKey') !== env('APP_KEY', NULL)){
            return response()->json('Sem autorização para acessar recursos do servidor', 401);
        }
        return $next($request);
    }
}
