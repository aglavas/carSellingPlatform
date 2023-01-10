<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class RedirectEnquiriesByRole
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
        $route = $request->route();

        $name = Route::currentRouteName();

        $routeParams = $route->parameters;

        $userType = $routeParams['userType'];

        $user = Auth::user();

        if ($userType === 'admin' && !$user->isAdmin()) {
            abort(404);
        }

        if ($user->isBuyerAndLogistics()) {

        } elseif ($user->isBuyer()) {
            if ($userType != 'buyer') {
                return redirect()->route($name, ['userType' => 'buyer', 'status' => ['in_progress']]);
            }
        } elseif ($user->isLogistics()) {
            if ($userType != 'seller') {
                return redirect()->route($name, ['userType' => 'seller', 'status' => ['in_progress']]);
            }
        }

        return $next($request);
    }
}
