<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EditUserInfoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->id == $request->id)
        {
            return $next($request);
        }
        abort(403, 'Permission Not Granted');
    }
}
