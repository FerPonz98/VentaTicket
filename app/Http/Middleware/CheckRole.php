<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Maneja la petición entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed ...$roles  Roles permitidos
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Necesitas iniciar sesión.');
        }
        
        $user = Auth::user();

        if (!in_array($user->rol, $roles)) {
         
            return redirect()->route('lobby')->with('error', 'No tienes acceso a esta página.');
        }

        return $next($request);
    }
}

