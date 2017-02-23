<?php

namespace SweetFace\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class LogoutInactiveUsers
{
    /**
     * Logs out inactive users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($user = Auth::guard($guard)->user() and ! $user->is_active) {
            Auth::guard($guard)->logout();

            return redirect(route('home'))
                ->with('message', 'Your account has been disabled, please connect again.');
        }

        return $next($request);
    }
}
