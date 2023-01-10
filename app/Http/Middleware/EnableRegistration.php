<?php

namespace App\Http\Middleware;

use Closure;

class EnableRegistration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (config('carmarket.enable_registration')) {
            return $next($request);
        }

        abort(404);
    }
}
