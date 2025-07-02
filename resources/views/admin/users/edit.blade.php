{{-- resources/views/admin/users/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<div class="container mx-auto p-7">

  <div class="mb-6">
    <a href="{{ route('users.index') }}"
       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
      ← Volver al listado
    </a>
  </div>

  <div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-semibold mb-6 text-gray-900">
      Editar Usuario: {{ $usuario->ci_usuario }}
    </h2>

    <form action="{{ route('users.update', $usuario->ci_usuario) }}"
          method="POST"
          enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-900">
        {{-- CI --}}
        <div>
          <label class="block font-medium mb-1">CI</label>
          <input
            type="text"
            name="ci_usuario"
            value="{{ $usuario->ci_usuario }}"
            readonly
            class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2 text-gray-700"
          />
        </div>

        {{-- Nombre de usuario --}}
        <div>
          <label class="block font-medium mb-1">Nombre de Usuario</label>
          <input name="nombre_usuario"
                 value="{{ old('nombre_usuario', $usuario->nombre_usuario) }}"
                 class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2"/>
          @error('nombre_usuario') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Apellidos --}}
        <div>
          <label class="block font-medium mb-1">Apellidos</label>
          <input name="apellidos"
                 value="{{ old('apellidos', $usuario->apellidos) }}"
                 class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2"/>
          @error('apellidos') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Sexo --}}
        <div>
          <label class="block font-medium mb-1">Sexo</label>
          <select name="sexo" class="w-full bg-gray-100 border rounded px-3 py-2" required>
             
              <option value="masculino" {{ old('sexo', $usuario->sexo)=='masculino'?'selected':'' }}>Masculino</option>
              <option value="femenino"  {{ old('sexo', $usuario->sexo)=='femenino' ?'selected':'' }}>Femenino</option>
          </select>
          @error('sexo') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Fecha de Nacimiento --}}
        <div>
          <label class="block font-medium mb-1">Fecha de Nacimiento</label>
          <input type="date"
                 name="fecha_nacimiento"
                 value="{{ old('fecha_nacimiento', $usuario->fecha_nacimiento) }}"
                 class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2"/>
          @error('fecha_nacimiento') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Estado --}}
        <div>
          <label class="block font-medium mb-1">Estado</label>
          <select name="estado"
                  class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2">
            <option value="activo" {{ old('estado', $usuario->estado)=='activo' ? 'selected':'' }}>Activo</option>
            <option value="inactivo" {{ old('estado', $usuario->estado)=='inactivo' ? 'selected':'' }}>Inactivo</option>
          </select>
          @error('estado') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Estado Civil --}}
        <div>
          <label class="block font-medium mb-1">Estado Civil</label>
          <select name="estado_civil"
                  class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2">
            <option value="soltero"    {{ old('estado_civil',$usuario->estado_civil)=='soltero'    ? 'selected':'' }}>Soltero/a</option>
            <option value="casado"     {{ old('estado_civil',$usuario->estado_civil)=='casado'     ? 'selected':'' }}>Casado/a</option>
            <option value="viudo"      {{ old('estado_civil',$usuario->estado_civil)=='viudo'      ? 'selected':'' }}>Viudo/a</option>
            <option value="divorciado" {{ old('estado_civil',$usuario->estado_civil)=='divorciado'? 'selected':'' }}>Divorciado/a</option>
          </select>
          @error('estado_civil') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Lugar de Residencia --}}
        <div>
          <label class="block font-medium mb-1">Lugar de Residencia</label>
          <input name="lugar_residencia"
                 value="{{ old('lugar_residencia', $usuario->lugar_residencia) }}"
                 class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2"/>
          @error('lugar_residencia') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Domicilio --}}
        <div>
          <label class="block font-medium mb-1">Domicilio</label>
          <input name="domicilio"
                 value="{{ old('domicilio', $usuario->domicilio) }}"
                 class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2"/>
          @error('domicilio') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Email --}}
        <div>
          <label class="block font-medium mb-1">Email</label>
          <input type="email"
                 name="email"
                 value="{{ old('email', $usuario->email) }}"
                 class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2"/>
          @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Celular --}}
        <div>
          <label class="block font-medium mb-1">Celular</label>
          <input name="celular"
                 value="{{ old('celular', $usuario->celular) }}"
                 class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2"/>
          @error('celular') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Referencias --}}
        <div class="md:col-span-2">
          <label class="block font-medium mb-1">Referencias</label>
          <textarea name="referencias" rows="3"
                    class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2">{{ old('referencias', $usuario->referencias) }}</textarea>
          @error('referencias') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Rol --}}
        <div>
          <label class="block font-medium mb-1">Rol</label>
          <select name="rol"
                  class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2">
            <option value="">-- Seleccione --</option>
            @foreach([
              'admin' => 'Admin',
              'supervisor gral' => 'Supervisor Gral',
              'supervisor suc' => 'Supervisor SUC',
              'cajero' => 'Cajero',
              'ventas qr' => 'Ventas QR',
              'carga' => 'Carga',
              'encomienda' => 'Encomienda',
              'chofer' => 'Chofer',
              'ayudante' => 'Ayudante'
            ] as $key => $label)
              <option value="{{ $key }}" {{ old('rol',$usuario->rol)==$key?'selected':'' }}>
                {{ $label }}
              </option>
            @endforeach
          </select>
          @error('rol') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>
        {{-- Sucursal --}}
        <div>
          <label class="block font-medium mb-1">Sucursal</label>
          <input name="sucursal"
                 value="{{ old('sucursal', $usuario->sucursal) }}"
                 class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2"/>
          @error('sucursal') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Foto de Perfil --}}
        <div class="md:col-span-2">
          <label class="block font-medium mb-1">Foto de Perfil</label>
          @if($usuario->foto)
            <div class="flex items-center space-x-4 mb-2">
              <img src="{{ asset('storage/'.$usuario->foto) }}"
                   alt="Foto" class="w-32 h-32 object-cover rounded-full border">
              <label class="inline-flex items-center">
                <input type="checkbox"
                       name="remove_foto"
                       value="1"
                       class="form-checkbox mr-1">
                <span class="text-red-600">Eliminar</span>
              </label>
            </div>
          @endif
          <input type="file"
                 name="foto"
                 accept=".jpg,.jpeg,.png"
                 class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2"/>
          @error('foto') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Documentos 1–5 --}}
        @for($i=1; $i<=5; $i++)
          <div>
            <label class="block font-medium mb-1">Documento {{ $i }}</label>
            @if($usuario["documento_$i"])
              <div class="flex items-center justify-between mb-1">
                <a href="{{ asset('storage/'.$usuario["documento_$i"]) }}"
                   target="_blank"
                   class="text-blue-500 hover:underline">
                  Ver documento {{ $i }}
                </a>
                <label class="inline-flex items-center">
                  <input type="checkbox"
                         name="remove_documento_{{ $i }}"
                         value="1"
                         class="form-checkbox mr-1">
                  <span class="text-red-600">Eliminar</span>
                </label>
              </div>
            @endif
            <input type="file"
                   name="documento_{{ $i }}"
                   accept=".pdf,.jpg,.jpeg,.png"
                   class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2"/>
            @error("documento_$i") <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
          </div>
        @endfor

        {{-- Seguridad y Nueva Contraseña --}}
        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
          {{-- Pregunta de Seguridad --}}
          <div>
            <label class="block font-medium mb-1">Pregunta de Seguridad</label>
            <select name="security_question"
                    class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2">
              <option value="">-- Selecciona --</option>
              <option value="color"   {{ old('security_question',$usuario->security_question)=='color'   ? 'selected':'' }}>¿Color favorito?</option>
              <option value="mascota" {{ old('security_question',$usuario->security_question)=='mascota'? 'selected':'' }}>¿Mascota?</option>
              <option value="ciudad"  {{ old('security_question',$usuario->security_question)=='ciudad' ? 'selected':'' }}>¿Ciudad?</option>
              <option value="comida"  {{ old('security_question',$usuario->security_question)=='comida' ? 'selected':'' }}>¿Comida?</option>
            </select>
            @error('security_question') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
          </div>

          {{-- Respuesta Secreta --}}
          <div>
            <label class="block font-medium mb-1">Respuesta</label>
            <input name="security_answer"
                   value="{{ old('security_answer',$usuario->security_answer) }}"
                   class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2"/>
            @error('security_answer') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
          </div>

          {{-- Nueva Contraseña --}}
          <div class="md:col-span-2">
            <label class="block font-medium mb-1">Nueva Contraseña (opc.)</label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <input type="password" name="password" placeholder="Nueva contraseña"
                     class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2"/>
              <input type="password" name="password_confirmation" placeholder="Confirmar contraseña"
                     class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2"/>
            </div>
            @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
          </div>
        </div>
      </div>

      {{-- Botón actualizar --}}
      <div class="mt-6 text-right">
        <button type="submit"
                class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
          Actualizar Usuario
        </button>
      </div>
    </form>
  </div>
</div>
@endsection