<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
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
        if (!in_array($request->user()->role_id,\config('app.permissions')))
        {
            if (! $request->expectsJson()) {
                return \redirect()->route('home');
            }else {
                return response()->json('Unauthorized for this route');
            }
        }

        return $next($request);
    }
}
