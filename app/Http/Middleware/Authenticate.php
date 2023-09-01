<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        // dd($request->url());
        $request->session()->put('previous_urlforseo', $request->fullUrl());
        $redirectTo = 'login';
        if (strpos($request->url(), 'privacy-policy') !== false) {
            $redirectTo = 'privacy-policy';
        }
        if (strpos($request->url(), 'faqs') !== false) {
            $redirectTo = 'faqs';
        }
        if (strpos($request->url(), 'terms-of-use') !== false) {
            $redirectTo = 'terms-of-use';
        }
        if (strpos($request->url(), 'about-us') !== false) {
            $redirectTo = 'about-us';
        }
        if (strpos($request->url(), 'standalonepage') !== false) {
            $redirectTo = 'standalonepage';
        }
        if (strpos($request->url(), 'safelogin') !== false || strpos($request->url(), 'admin') !== false) {
            $redirectTo = 'admin_login';
        }
        if (! $request->expectsJson()) {
            return route($redirectTo);
        }
    }
}
