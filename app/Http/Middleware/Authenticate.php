<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

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
            if ($request->getPathInfo() == "/wishlist/es") {
                return route('login', ['lang' => 'es']);
            } else {
                return route('login', ['lang' => 'en']);
            }
        }
    }
}
