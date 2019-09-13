<?php

namespace App\Http\Middleware;

use Closure;

class Splitter
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
        list($username, $domain) = explode('@', $request->email);
        $this->domain = $domain;
        $request->merge(['username' => $username]);

        if (config('pcrs.loginDomain') === $domain) {
            $request->merge(['domain' => $domain]);
        }

        return $next($request);
    }
}
