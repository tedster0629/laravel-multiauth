<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedOld
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // If you authenticated with the `normal user` then the `SessionGuard` object 'name' will be `null`
        // and Auth::guard($guard)->check() will return TRUE
        // and invokes the line `redirect(RouteServiceProvider::HOME)`.
        $guards = empty($guards) ? [null] : $guards;

        // Remember Auth::guard('admin') will returns a `SessionGuard` object
        // which will use `check()` method to return boolean Is the Authenticated user is authenticated
        // with the `admin` guard session?
        foreach ($guards as $guard) {

            // At the time of "localhost/admin/login" route the $guard will be `admin` then
            // is_null('admin') will return false and we make this expression true. So redirection
            // to the dashboard will automatically happen.

            // But if guard session is admin & guard is null returns true then we make
            // this false and whole expression will not RUN

            // Thr expression will only run if there is explicitly guard value is present
            if (!is_null($guard) && Auth::guard('admin')->check()) {
                return redirect()->route('dashboard');
            }


            else if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }


        // If there is not any session guard present in the request. please open the route.
        // if (Auth::guard($guard)->check()) returns true then it means the user is
        // authenticated with the some session guard, then $next($request) will not work.
        return $next($request);
    }
}
