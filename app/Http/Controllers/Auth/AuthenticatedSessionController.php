<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
      
        $request->authenticate();
        $request->session()->regenerate();

        /** @var \App\Models\User $user */
        $user = Auth::user();

      
        if ($user->estado === 'inactivo') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withInput($request->only('ci_usuario'))
                ->withErrors(['ci_usuario' => 'Tu cuenta no está activa.']);
        }

      
        if ($user->rol !== 'admin' && $user->created_at->diffInDays(now()) > 80) {
            $user->estado = 'bloqueado';
            $user->save();

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withInput($request->only('ci_usuario'))
                ->withErrors(['ci_usuario' => 'Tu cuenta ha sido bloqueada tras 80 días de uso.']);
        }

   

        return match ($user->rol) {
            'admin'             => redirect()->intended('/admin'),
            'supervisor gral'   => redirect()->intended('/supervisor'),
            'supervisor suc'   => redirect()->intended('/supervisor suc'),
            'cajero'            => redirect()->intended('/cajero'),
            'chofer y ayudante' => redirect()->intended('/chofer'),
            default             => redirect()->intended('/lobby'),
        };
    }

    public function destroy(Request $request)
    {
        $user = $request->user();

        // Busca turno abierto del usuario
        $turno = \App\Models\Turno::de($user->ci_usuario, $user->sucursal, $user->rol)
            ->abierto()
            ->first();

        if ($turno) {
            $turno->update([
                'abierto' => false,
                'fecha_fin' => now(),
                'saldo_final' => $turno->saldo_inicial + $turno->movimientos()->sum('monto'),
            ]);
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
