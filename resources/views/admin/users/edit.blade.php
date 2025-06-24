{{-- resources/views/admin/users/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<div class="container mx-auto mt-6">
  <a href="{{ route('users.index') }}"
     class="inline-block mb-4 text-sm text-blue-600 hover:underline">
    ← Volver al listado
  </a>

  <div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-6 text-black">
      Editar Usuario: {{ $usuario->ci_usuario }}
    </h2>

    <form action="{{ route('users.update', $usuario->ci_usuario) }}"
          method="POST"
          enctype="multipart/form-data">
      @csrf
      @method('PATCH')

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-black">
        {{-- CI --}}
        <div>
          <label class="block font-semibold mb-1">CI</label>
          <input type="text" value="{{ $usuario->ci_usuario }}" readonly
                 class="w-full bg-gray-100 border rounded px-3 py-2 cursor-not-allowed"/>
        </div>

        {{-- Nombre --}}
        <div>
          <label class="block font-semibold mb-1">Nombre</label>
          <input name="nombre_usuario"
                 value="{{ old('nombre_usuario', $usuario->nombre_usuario) }}"
                 class="w-full bg-gray-100 border rounded px-3 py-2"/>
          @error('nombre_usuario') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Apellidos --}}
        <div>
          <label class="block font-semibold mb-1">Apellidos</label>
          <input name="apellidos"
                 value="{{ old('apellidos', $usuario->apellidos) }}"
                 class="w-full bg-gray-100 border rounded px-3 py-2"/>
          @error('apellidos') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Sexo --}}
        <div>
          <label class="block font-semibold mb-1">Sexo</label>
          <select name="sexo"
                  class="w-full bg-gray-100 border rounded px-3 py-2">
            <option value="masculino" {{ old('sexo',$usuario->sexo)=='M'?'selected':'' }}>Masculino</option>
            <option value="femenino"  {{ old('sexo',$usuario->sexo)=='F'?'selected':'' }}>Femenino</option>
          </select>
          @error('sexo') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Fecha de Nacimiento --}}
        <div>
          <label class="block font-semibold mb-1">Fecha de Nacimiento</label>
          <input type="date" name="fecha_nacimiento"
                 value="{{ old('fecha_nacimiento', $usuario->fecha_nacimiento) }}"
                 class="w-full bg-gray-100 border rounded px-3 py-2"/>
          @error('fecha_nacimiento') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Estado --}}
        <div>
          <label class="block font-semibold mb-1">Estado</label>
          <select name="estado"
                  class="w-full bg-gray-100 border rounded px-3 py-2">
            <option value="activo"    {{ old('estado',$usuario->estado)=='activo'?'selected':'' }}>Activo</option>
            <option value="bloqueado" {{ old('estado',$usuario->estado)=='bloqueado'?'selected':'' }}>Bloqueado</option>
          </select>
          @error('estado') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Estado Civil --}}
        <div>
          <label class="block font-semibold mb-1">Estado Civil</label>
          <select name="estado_civil"
                  class="w-full bg-gray-100 border rounded px-3 py-2">
            <option value="soltero" {{ old('estado_civil',$usuario->estado_civil)=='soltero'?'selected':'' }}>Soltero/a</option>
            <option value="casado"  {{ old('estado_civil',$usuario->estado_civil)=='casado'?'selected':'' }}>Casado/a</option>
            <option value="viudo"   {{ old('estado_civil',$usuario->estado_civil)=='viudo'?'selected':'' }}>Viudo/a</option>
          </select>
          @error('estado_civil') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Lugar de Residencia --}}
        <div>
          <label class="block font-semibold mb-1">Lugar de Residencia</label>
          <input name="lugar_residencia"
                 value="{{ old('lugar_residencia', $usuario->lugar_residencia) }}"
                 class="w-full bg-gray-100 border rounded px-3 py-2"/>
          @error('lugar_residencia') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Domicilio --}}
        <div>
          <label class="block font-semibold mb-1">Domicilio</label>
          <input name="domicilio"
                 value="{{ old('domicilio', $usuario->domicilio) }}"
                 class="w-full bg-gray-100 border rounded px-3 py-2"/>
          @error('domicilio') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Email --}}
        <div>
          <label class="block font-semibold mb-1">Email</label>
          <input type="email" name="email"
                 value="{{ old('email', $usuario->email) }}"
                 class="w-full bg-gray-100 border rounded px-3 py-2"/>
          @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Celular --}}
        <div>
          <label class="block font-semibold mb-1">Celular</label>
          <input name="celular"
                 value="{{ old('celular', $usuario->celular) }}"
                 class="w-full bg-gray-100 border rounded px-3 py-2"/>
          @error('celular') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Referencias --}}
        <div class="md:col-span-2">
          <label class="block font-semibold mb-1">Referencias</label>
          <textarea name="referencias" rows="3"
                    class="w-full bg-gray-100 border rounded px-3 py-2">{{ old('referencias', $usuario->referencias) }}</textarea>
          @error('referencias') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Rol --}}
        <div>
            <label class="block font-semibold mb-1">Rol</label>
            <select name="rol" class="w-full bg-gray-100 border rounded px-3 py-2 text-black">
                <option value="admin"             {{ old('rol', $usuario->rol)=='admin'             ? 'selected':'' }}>Admin</option>
                <option value="supervisor gral"   {{ old('rol', $usuario->rol)=='supervisor gral'   ? 'selected':'' }}>Supervisor Gral</option>
                <option value="supervisor suc"    {{ old('rol', $usuario->rol)=='supervisor suc'    ? 'selected':'' }}>Supervisor SUC</option>
                <option value="cajero"            {{ old('rol', $usuario->rol)=='cajero'            ? 'selected':'' }}>Cajero</option>
                <option value="chofer y ayudante" {{ old('rol', $usuario->rol)=='chofer y ayudante' ? 'selected':'' }}>Chofer y Ayudante</option>
                <option value="carga"             {{ old('rol', $usuario->rol)=='carga'             ? 'selected':'' }}>Carga</option>
                <option value="ventas qr"         {{ old('rol', $usuario->rol)=='ventas qr'         ? 'selected':'' }}>Ventas QR</option>
                <option value="encomienda"        {{ old('rol', $usuario->rol)=='encomienda'        ? 'selected':'' }}>Encomienda</option>
            </select>
            @error('rol') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- FOTO --}}
        <div class="md:col-span-2">
          <label class="block font-semibold mb-1">Foto</label>

          @if($usuario->foto)
            <div class="flex items-center justify-between mb-2">
              <a href="{{ asset('storage/'.$usuario->foto) }}"
                 target="_blank"
                 class="text-blue-600 hover:underline">
                Ver foto
              </a>
              <label class="inline-flex items-center">
                <input type="checkbox"
                       name="remove_foto"
                       value="1"
                       class="form-checkbox mr-1">
                <span class="text-red-600 font-medium">Eliminar</span>
              </label>
            </div>
            <img src="{{ asset('storage/'.$usuario->foto) }}"
                 alt="Foto de {{ $usuario->nombre_usuario }}"
                 class="w-64 h-64 object-cover rounded-lg border mb-4">
          @endif

          <input type="file"
                 name="foto"
                 accept=".jpg,.jpeg,.png,.pdf"
                 class="w-full bg-gray-100 border rounded px-3 py-2"/>
          @error('foto') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- DOCUMENTOS --}}
        @for($i=1; $i<=5; $i++)
          <div>
            <label class="block font-semibold mb-1">Documento {{ $i }}</label>

            @if($usuario["documento_$i"])
              <div class="flex items-center justify-between mb-2">
                <a href="{{ asset('storage/'.$usuario["documento_$i"]) }}"
                   target="_blank"
                   class="text-blue-600 hover:underline">
                  Ver documento {{ $i }}
                </a>
                <label class="inline-flex items-center">
                  <input type="checkbox"
                         name="remove_documento_{{ $i }}"
                         value="1"
                         class="form-checkbox mr-1">
                  <span class="text-red-600 font-medium">Eliminar</span>
                </label>
              </div>
            @endif

            <input type="file"
                   name="documento_{{ $i }}"
                   accept=".pdf,.jpg,.jpeg,.png"
                   class="w-full bg-gray-100 border rounded px-3 py-2"/>
            @error("documento_$i") <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
          </div>
        @endfor

        {{-- Pregunta de Seguridad --}}
        <div class="md:col-span-2">
          <label class="block font-semibold mb-1">Pregunta de Seguridad</label>
          <select name="security_question"
                  class="w-full bg-gray-100 border rounded px-3 py-2">
            <option value="">-- Selecciona una pregunta --</option>
            <option value="¿Color favorito?"       {{ old('security_question',$usuario->security_question)=='¿Color favorito?'?'selected':'' }}>¿Color favorito?</option>
            <option value="¿Nombre de tu mascota?" {{ old('security_question',$usuario->security_question)=='¿Nombre de tu mascota?'?'selected':'' }}>¿Nombre de tu mascota?</option>
            <option value="¿Ciudad de nacimiento?" {{ old('security_question',$usuario->security_question)=='¿Ciudad de nacimiento?'?'selected':'' }}>¿Ciudad de nacimiento?</option>
            <option value="¿Comida favorita?"      {{ old('security_question',$usuario->security_question)=='¿Comida favorita?'?'selected':'' }}>¿Comida favorita?</option>
          </select>
          @error('security_question') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Respuesta de Seguridad --}}
        <div>
          <label class="block font-semibold mb-1">Respuesta de Seguridad</label>
          <input name="security_answer"
                 value="{{ old('security_answer', $usuario->security_answer) }}"
                 class="w-full bg-gray-100 border rounded px-3 py-2"/>
          @error('security_answer') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Contraseña nueva --}}
        <div class="md:col-span-2">
          <label class="block font-semibold mb-1">Actualizar Contraseña (opcional)</label>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="password"
                   name="password"
                   placeholder="Nueva contraseña"
                   class="w-full bg-gray-100 border rounded px-3 py-2"/>
            <input type="password"
                   name="password_confirmation"
                   placeholder="Confirmar contraseña"
                   class="w-full bg-gray-100 border rounded px-3 py-2"/>
          </div>
          @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
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
