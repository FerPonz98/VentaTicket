<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RecoverPasswordController extends Controller
{
 
    public function showForm()
    {
        return view('auth.recover');
    }

    
    public function check(Request $request)
    {
        $request->validate([
            'ci_usuario' => 'required|string',
        ]);

        $user = User::where('ci_usuario', $request->ci_usuario)->first();

        if (! $user) {
            return back()->withErrors(['ci_usuario' => 'Usuario no encontrado.']);
        }

        return redirect()->route('recover.question', $user->ci_usuario);
    }

    public function showQuestion($ci_usuario)
    {
        $user = User::where('ci_usuario', $ci_usuario)->firstOrFail();
        $pregunta = $user->security_question; // nombre de la columna

        return view('auth.recover-question', [
            'user'     => $user,
            'pregunta' => $pregunta,
        ]);
    }

    public function validateAnswer(Request $request, $ci_usuario)
    {
        $request->validate([
            'security_answer' => 'required|string',
        ]);

        $user = User::where('ci_usuario', $ci_usuario)->firstOrFail();

        if (trim($request->security_answer) !== trim($user->security_answer)) {
            return back()->withErrors(['security_answer' => 'Respuesta incorrecta.']);
        }

        session()->put("recover_allowed_{$ci_usuario}", [
            'granted'    => true,
            'expires_at' => now()->addMinutes(5),
        ]);

        return view('auth.recover-reset', compact('user'));
    }

    public function updatePassword(Request $request, $ci_usuario)
    {
        $sessionKey  = "recover_allowed_{$ci_usuario}";
        $sessionData = session()->pull($sessionKey);

        if (
            ! $sessionData ||
            empty($sessionData['granted']) ||
            now()->gt($sessionData['expires_at'])
        ) {
            return redirect()->route('recover.form')
                             ->withErrors(['expired' => 'Tu sesión para cambiar contraseña ha expirado. Intenta de nuevo.']);
        }

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::where('ci_usuario', $ci_usuario)->firstOrFail();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')
                         ->with('status', 'Contraseña actualizada con éxito.');
    }
}
