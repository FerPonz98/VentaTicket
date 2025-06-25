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

        $sexo = $request->sexo === 'masculino' ? 'M' : 'F';


        if ($request->boolean('remove_foto') && $usuario->foto) {
            Storage::disk('public')->delete($usuario->foto);
            $usuario->foto = null;
        }
  
        if ($request->hasFile('foto')) {
            if ($usuario->foto) {
                Storage::disk('public')->delete($usuario->foto);
            }
            $usuario->foto = $request->file('foto')->store('fotos', 'public');
        }

        for ($i = 1; $i <= 5; $i++) {
            $field      = "documento_$i";
            $removeName = "remove_documento_{$i}";

            if ($request->boolean($removeName) && $usuario->$field) {
                Storage::disk('public')->delete($usuario->$field);
                $usuario->$field = null;
            }
            if ($request->hasFile($field)) {
                if ($usuario->$field) {
                    Storage::disk('public')->delete($usuario->$field);
                }
                $usuario->$field = $request->file($field)->store('documentos', 'public');
            }
        }

        $usuario->nombre_usuario    = $request->nombre_usuario;
        $usuario->apellidos         = $request->apellidos;
        $usuario->sexo              = $sexo;
        $usuario->fecha_nacimiento  = $request->fecha_nacimiento;
        $usuario->estado            = $request->estado;
        $usuario->estado_civil      = $request->estado_civil;
        $usuario->lugar_residencia  = $request->lugar_residencia;
        $usuario->domicilio         = $request->domicilio;
        $usuario->email             = $request->email;
        $usuario->celular           = $request->celular;
        $usuario->referencias       = $request->referencias;
        $usuario->rol               = $request->rol;
        $usuario->security_question = $request->security_question;
        $usuario->security_answer   = $request->security_answer;

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
        if ($usuario->foto) {
            Storage::disk('public')->delete($usuario->foto);
        }
        for ($i = 1; $i <= 5; $i++) {
            $field = "documento_$i";
            if ($usuario->$field) {
                Storage::disk('public')->delete($usuario->$field);
            }
        }

        $usuario->delete();

        return redirect()->route('users.index')
                         ->with('success', 'Usuario eliminado.');
    }
}
