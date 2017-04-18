<?php

namespace MsgService\Http\Middleware;

use Closure;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->input('access_token') != config('msgser.access_token')) {
            return response()->json([
                'status' => 'no',
                'message' => 'access_token 错误'
            ], 401);
        }

        return $next($request);
    }
}
