<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'type' => 1])) {
            return redirect(RouteServiceProvider::HOME);
        } else {
            $message = 'testtetset';
            return redirect('/');
        }

        return $next($request);
    }
}
