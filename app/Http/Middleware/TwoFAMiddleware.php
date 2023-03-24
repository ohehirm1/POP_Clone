<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TwoFAMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // dd($request->user()->two_factor_confirmed_at);
        // if ($request->user()->two_factor_confirmed_at && ! session()->has('2fa-session'))
        // {
            // return redirect()->route('two-factor.login');
        // } else {
            return $next($request);
        // }
    }
}
