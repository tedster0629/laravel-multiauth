<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AdminAuthenticate extends Middleware
{

    // Override the `authenticate` method from the `Authenticate` class.
    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate($request, array $guards)
    {
       if ($this->auth->guard('admin')->check()) {
           return $this->auth->shouldUse('admin');
         }
        $this->unauthenticated($request, ['admin']);
    }

    /**
     * Get the path the admin should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // exprectsJson(): Determine if the current request probably expects a JSON response.
        // It will return true or false.
        if (! $request->expectsJson()) {
            return route('admin.login');
        }
    }
}
