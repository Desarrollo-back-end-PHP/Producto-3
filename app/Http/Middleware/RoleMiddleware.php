<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RolMiddleware
{
    public function handle(Request $request, Closure $next, $rol)
    {
        // ❗ si no hay usuario logueado
        if (!auth()->check()) {
            return redirect('/login');
        }

        // ❗ si el rol no coincide
        if (auth()->user()->rol !== $rol) {
            abort(403);
        }

        return $next($request);
    }
}