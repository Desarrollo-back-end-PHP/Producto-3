<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::check()) {

            $user = Auth::user();

            if ($user->rol == 'admin') {
                return redirect('/usuarios');
            } else {
                return redirect('/panel');
            }
        }

        return $next($request);
    }
}