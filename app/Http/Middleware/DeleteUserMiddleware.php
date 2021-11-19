<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DeleteUserMiddleware
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
            abort(403, 'Permission Not Granted');
        }
        return $next($request);
    }
}
