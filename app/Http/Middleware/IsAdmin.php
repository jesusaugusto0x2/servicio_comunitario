<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
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
        if ($request->user()->is_admin == false) {
            return $next($request);
        }

        return response()->json([
            'status'    =>  'failed',
            'message'   =>  'Must be an admin instance to proceed'
        ]);
    }
}
