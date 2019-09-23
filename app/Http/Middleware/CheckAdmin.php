<?php

namespace App\Http\Middleware;

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
        if ($request->user()->is_admin == 0) {
            return response()->json([
                'status'    =>  'failed',
                'message'   =>  'Can\'t access as non-admin'
            ]);
        }

        return $next($request);
    }
}
