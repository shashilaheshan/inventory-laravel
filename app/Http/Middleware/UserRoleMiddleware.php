<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class UserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$guard = null)
    {
        if (Auth::user()->role =='staff') {

                return redirect('/home');
        }

        return $next($request);
    }
}
