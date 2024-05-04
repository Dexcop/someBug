<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('login')->with('error', 'You must be logged in to access that page.');
        } elseif (!Auth::user()->isAdmin) {
            return redirect('dashboard')->with('error', 'You are not authorized to access that page.');
        }


        return $next($request);
    }
}
