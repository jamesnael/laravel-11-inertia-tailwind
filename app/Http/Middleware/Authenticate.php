<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            $route_name = substr(Route::currentRouteName(), 0, 12);
            
            if ($route_name == 'user.product') {
                return route('frontend.frontend-login');
            } else {
                return route('login');
            }
        }
    }
}
