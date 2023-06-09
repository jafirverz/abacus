<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAdmin
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = 'admin')
	{
	    if (!Auth::guard($guard)->check()) {
	        return redirect('safelogin/login');
        }
        elseif(Auth::user()->status == 2)
        {
            Auth::logout();
            return redirect('safelogin/login')->with('error', 'Account is inactive, please contact administrator');
        }

	    return $next($request);
	}
}
