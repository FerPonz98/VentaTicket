<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'ci_usuario'        => ['required', 'string', 'max:20', 'unique:usuarios,ci_usuario'],
            'nombre_usuario'    => ['required', 'string', 'max:50', 'unique:usuarios,nombre_usuario'],
            'email'             => ['required', 'string', 'email', 'max:100', 'unique:usuarios,email'],
            'password'          => ['required', 'confirmed', Rules\Password::defaults()],
            'security_question'  => ['required', 'string', 'max:255'],
            'security_answer'=> ['required', 'string', 'max:255'],
        ]);
        $user = User::create([
            'ci_usuario'        => $request->ci_usuario,
            'nombre_usuario'    => $request->nombre_usuario,
            'email'             => $request->email,
            'contrasena'        => Hash::make($request->password),
            'rol'               => 'cajero', 
            'security_question'  => $request->pregunta_secreta,
            'security_answer' => Hash::make($request->respuesta_secreta),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
