<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectByRole
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
        if ((Route::current()->getName() == 'nova.login') || (Route::current()->getName() == 'nova.logout')) {
            return $next($request);
        }

        $user = Auth::user();

        if ($user->hasRole(['Administrator', 'Uploader'])) {
            return $next($request);
        }

        $redirectPath = route('start');

        return redirect($redirectPath);
    }
}
