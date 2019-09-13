<?php

namespace App\Http\Middleware;

use Closure;

class AjaxRequestOnly
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
        if (! $request->ajax()) {
            abort(403, 'Unauthorized Access!');
        }
        
        return $next($request);
    }
}
