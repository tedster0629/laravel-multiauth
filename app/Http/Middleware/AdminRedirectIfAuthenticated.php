<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminRedirectIfAuthenticated
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
            if (Auth::guard('admin')->check()) {
                return redirect()->route('dashboard');
            }
        // If there is not any session guard present in the request. please open the route.
        // if (Auth::guard($guard)->check()) returns true then it means the user is
        // authenticated with the some session guard, then $next($request) will not work.
        return $next($request);
    }
}
