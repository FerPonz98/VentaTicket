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

    // Redirección según rol
    $user = $request->user();
    return match($user->rol) {
      'admin'      => redirect()->intended('/admin'),
      'supervisor' => redirect()->intended('/supervisor'),
      'cajero'     => redirect()->intended('/cajero'),
      'chofer'     => redirect()->intended('/chofer'),
      'ayudante'   => redirect()->intended('/ayudante'),
      default      => redirect()->intended('/dashboard'),
    };
}


    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
