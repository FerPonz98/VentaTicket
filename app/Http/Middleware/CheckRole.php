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
        // Si no está autenticado, redirigir a login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Si el rol del usuario NO está en la lista de roles permitidos
        if (!in_array($user->rol, $roles)) {
            abort(403); // Muestra errors/403.blade.php
        }

        return $next($request);
    }
}
