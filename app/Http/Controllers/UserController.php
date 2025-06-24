<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('admin.users.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ci_usuario'       => 'required|unique:usuarios,ci_usuario',
            'nombre_usuario'   => 'required|string|max:100',
            'apellidos'        => 'required|string|max:100',
            'sexo'             => 'required|in:masculino,femenino',
            'fecha_nacimiento' => 'required|date',
            'estado'           => 'required',
            'estado_civil'     => 'required',
            'lugar_residencia' => 'required|string',
            'domicilio'        => 'required|string',
            'email'            => 'required|email|unique:usuarios,email',
            'celular'          => 'nullable|string|max:20',
            'referencias'      => 'nullable|string',
            'rol'              => 'required|string',
            'password'         => 'required|confirmed|min:6',
            'security_question'=> 'required|string',
            'security_answer'  => 'required|string',
            'foto'             => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'documento_1'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'documento_2'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'documento_3'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'documento_4'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'documento_5'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Mapeo de sexo a 'M' o 'F'
        $sexo = $request->sexo === 'masculino' ? 'M' : 'F';

        // Almacenamiento de archivos
        $foto = $request->hasFile('foto') 
            ? $request->file('foto')->store('fotos', 'public') 
            : null;

        $docs = [];
        for ($i = 1; $i <= 5; $i++) {
            $field = "documento_$i";
            $docs[$field] = $request->hasFile($field)
                ? $request->file($field)->store('documentos', 'public')
                : null;
        }

        User::create([
            'ci_usuario'        => $request->ci_usuario,
            'nombre_usuario'    => $request->nombre_usuario,
            'apellidos'         => $request->apellidos,
            'sexo'              => $sexo,
            'fecha_nacimiento'  => $request->fecha_nacimiento,
            'estado'            => $request->estado,
            'estado_civil'      => $request->estado_civil,
            'lugar_residencia'  => $request->lugar_residencia,
            'domicilio'         => $request->domicilio,
            'email'             => $request->email,
            'celular'           => $request->celular,
            'referencias'       => $request->referencias,
            'rol'               => $request->rol,
            'password'          => bcrypt($request->password),
            'security_question' => $request->security_question,
            'security_answer'   => $request->security_answer,
            'foto'              => $foto,
            'documento_1'       => $docs['documento_1'],
            'documento_2'       => $docs['documento_2'],
            'documento_3'       => $docs['documento_3'],
            'documento_4'       => $docs['documento_4'],
            'documento_5'       => $docs['documento_5'],
            'creado_en'         => now(),
        ]);

        return redirect()->route('users.index')
                         ->with('success', 'Usuario creado correctamente.');
    }

    public function show($ci_usuario)
    {
        $usuario = User::findOrFail($ci_usuario);
        return view('admin.users.show', compact('usuario'));
    }

    public function edit($ci_usuario)
    {
        $usuario = User::findOrFail($ci_usuario);
        return view('admin.users.edit', compact('usuario'));
    }

    public function update(Request $request, $ci_usuario)
    {
        $request->validate([
            'nombre_usuario'   => 'required|string|max:100',
            'apellidos'        => 'required|string|max:100',
            'sexo'             => 'required|in:masculino,femenino',
            'fecha_nacimiento' => 'required|date',
            'estado'           => 'required',
            'estado_civil'     => 'required',
            'lugar_residencia' => 'required|string',
            'domicilio'        => 'required|string',
            'email'            => 'required|email|unique:usuarios,email,' 
                                   . $ci_usuario . ',ci_usuario',
            'celular'          => 'nullable|string|max:20',
            'referencias'      => 'nullable|string',
            'rol'              => 'required|string',
            'password'         => 'nullable|confirmed|min:6',
            'security_question'=> 'required|string',
            'security_answer'  => 'required|string',
            'foto'             => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'documento_1'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'documento_2'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'documento_3'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'documento_4'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'documento_5'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $usuario = User::findOrFail($ci_usuario);

        // Mapeo de sexo
        $sexo = $request->sexo === 'masculino' ? 'M' : 'F';

        $usuario->update([
            'nombre_usuario'    => $request->nombre_usuario,
            'apellidos'         => $request->apellidos,
            'sexo'              => $sexo,
            'fecha_nacimiento'  => $request->fecha_nacimiento,
            'estado'            => $request->estado,
            'estado_civil'      => $request->estado_civil,
            'lugar_residencia'  => $request->lugar_residencia,
            'domicilio'         => $request->domicilio,
            'email'             => $request->email,
            'celular'           => $request->celular,
            'referencias'       => $request->referencias,
            'rol'               => $request->rol,
            'security_question' => $request->security_question,
            'security_answer'   => $request->security_answer,
        ]);

        // Foto
        if ($request->hasFile('foto')) {
            $usuario->foto = $request->file('foto')->store('fotos', 'public');
        }
        // Documentos
        for ($i = 1; $i <= 5; $i++) {
            $field = "documento_$i";
            if ($request->hasFile($field)) {
                $usuario->$field = $request->file($field)->store('documentos', 'public');
            }
        }
        // Contraseña
        if ($request->filled('password')) {
            $usuario->password = bcrypt($request->password);
        }

        $usuario->save();

        return redirect()->route('users.index')
                         ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($ci_usuario)
    {
        $usuario = User::findOrFail($ci_usuario);
        $usuario->delete();

        return redirect()->route('users.index')
                         ->with('success', 'Usuario eliminado.');
    }
}
