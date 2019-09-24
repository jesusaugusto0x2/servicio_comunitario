<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class CheckAdmin
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
        if (Auth::user()->is_admin == 1) {
            return $next($request);
        }

        return response()->json([
            'status'    =>  'failed',
            'message'   =>  'Can\'t access as non-admin'
        ]);
    }
}
