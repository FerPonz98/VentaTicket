<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $ci = $request->query('ci_usuario');

        $usuarios = User::when($ci, function($q) use ($ci) {
                return $q->where('ci_usuario', 'like', "%{$ci}%");
            })
            ->orderBy('sucursal')
            ->get();

        $usuariosRecientes = User::orderByDesc('created_at')
                                  ->take(5)
                                  ->get();

        return view('admin.users.index', compact('usuarios', 'usuariosRecientes'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ci_usuario'        => 'required|unique:usuarios,ci_usuario',
            'nombre_usuario'    => 'required|string|max:100',
            'apellidos'         => 'required|string|max:100',
            'sexo'              => 'required|in:masculino,femenino',
            'fecha_nacimiento'  => 'required|date',
            'estado'            => 'required',
            'estado_civil'      => 'required',
            'lugar_residencia'  => 'required|string',
            'domicilio'         => 'required|string',
            'email'             => 'nullable|email|unique:usuarios,email',
            'celular'           => 'nullable|string|max:20',
            'referencias'       => 'nullable|string',
            'rol'               => 'required|string',
            'sucursal'          => 'required|string',
            'password'          => 'required|confirmed|min:6',
            'security_question' => 'required|string',
            'security_answer'   => 'required|string',
            'foto'              => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'documento_1'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'documento_2'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'documento_3'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'documento_4'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'documento_5'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'ci_usuario.unique' => 'Ya existe un usuario con ese CI.',
        ]);

        $sexo = $request->sexo === 'masculino' ? 'M' : 'F';

        $fotoPath = $request->hasFile('foto')
            ? $request->file('foto')->store('fotos', 'public')
            : null;

        $docs = [];
        for ($i = 1; $i <= 5; $i++) {
            $field     = "documento_{$i}";
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
            'sucursal'          => $request->sucursal,
            'password'          => bcrypt($request->password),
            'security_question' => $request->security_question,
            'security_answer'   => $request->security_answer,
            'foto'              => $fotoPath,
            'documento_1'       => $docs['documento_1'],
            'documento_2'       => $docs['documento_2'],
            'documento_3'       => $docs['documento_3'],
            'documento_4'       => $docs['documento_4'],
            'documento_5'       => $docs['documento_5'],
            'creado_en'         => now(),
        ]);

return redirect()->route('users.index')
                 ->with('success', 'Usuario actualizado correctamente.');

    }

    
    public function edit($ci_usuario)
    {
        $usuario = User::findOrFail($ci_usuario);
        return view('admin.users.edit', compact('usuario'));
    }

    public function update(Request $request, $ci_usuario)
    {
        $usuario = User::findOrFail($ci_usuario);

        $request->validate([
            'ci_usuario'        => "required|unique:usuarios,ci_usuario,{$usuario->ci_usuario},ci_usuario",
            'nombre_usuario'    => 'required|string|max:100',
            'apellidos'         => 'required|string|max:100',
            'sexo'              => 'required|in:masculino,femenino',
            'fecha_nacimiento'  => 'required|date',
            'estado'            => 'required',
            'estado_civil'      => 'required',
            'lugar_residencia'  => 'required|string',
            'domicilio'         => 'required|string',
            'email'             => "nullable|email|unique:usuarios,email,{$usuario->ci_usuario},ci_usuario",
            'celular'           => 'nullable|string|max:20',
            'referencias'       => 'nullable|string',
            'rol'               => 'required|string',
            'sucursal'          => 'required|string',
            'password'          => 'nullable|confirmed|min:6',
            'security_question' => 'required|string',
            'security_answer'   => 'required|string',
            'foto'              => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'documento_1'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'documento_2'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'documento_3'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'documento_4'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'documento_5'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $usuario->sexo = $request->sexo === 'masculino' ? 'M' : 'F';

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
            $field      = "documento_{$i}";
            $removeFlag = "remove_documento_{$i}";

            if ($request->boolean($removeFlag) && $usuario->$field) {
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

        $usuario->update([
           //'ci_usuario'        => $request->ci_usuario,
            'nombre_usuario'    => $request->nombre_usuario,
            'apellidos'         => $request->apellidos,
            'fecha_nacimiento'  => $request->fecha_nacimiento,
            'estado'            => $request->estado,
            'estado_civil'      => $request->estado_civil,
            'lugar_residencia'  => $request->lugar_residencia,
            'domicilio'         => $request->domicilio,
            'email'             => $request->email,
            'celular'           => $request->celular,
            'referencias'       => $request->referencias,
            'rol'               => $request->rol,
            'sucursal'          => $request->sucursal,
            'password'          => $request->filled('password')
                                     ? bcrypt($request->password)
                                     : $usuario->password,
            'security_question' => $request->security_question,
            'security_answer'   => $request->security_answer,
            'foto'              => $usuario->foto,
            'documento_1'       => $usuario->documento_1,
            'documento_2'       => $usuario->documento_2,
            'documento_3'       => $usuario->documento_3,
            'documento_4'       => $usuario->documento_4,
            'documento_5'       => $usuario->documento_5,
        ]);

        return redirect()->route('users.index')
                         ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuario)
    {
        if ($usuario->foto) {
            Storage::disk('public')->delete($usuario->foto);
        }
        for ($i = 1; $i <= 5; $i++) {
            $field = "documento_{$i}";
            if ($usuario->$field) {
                Storage::disk('public')->delete($usuario->$field);
            }
        }

        $usuario->delete();

        return redirect()->route('users.index')
                         ->with('success', 'Usuario eliminado correctamente.');
    }

    public function show(User $usuario)
    {
        return view('admin.users.show', compact('usuario'));
    }
}
