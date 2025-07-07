{{-- resources/views/admin/users/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Registrar Nuevo Usuario')

@section('content')

<div class="container mx-auto p-7">

  <div class="mb-6">
    <a href="{{ route('users.index') }}"
       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
      ← Volver al listado
    </a>
  </div>

  <div class="bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-6 text-black">
      Registrar Nuevo Usuario
    </h2>

    @if($errors->any())
      <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-800 rounded">
        <p class="font-semibold">Por favor corrige los siguientes errores:</p>
        <ul class="list-disc list-inside mt-2">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-black">
        {{-- CI Usuario --}}
        <div>
          <label class="block font-semibold mb-1">CI Usuario</label>
          <input type="text" name="ci_usuario" value="{{ old('ci_usuario') }}"
                 class="w-full bg-gray-100 border rounded px-3 py-2" required>
          @error('ci_usuario') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Nombre de Usuario --}}
        <div>
          <label class="block font-semibold mb-1">Nombre de Usuario</label>
          <input type="text" name="nombre_usuario" value="{{ old('nombre_usuario') }}"
                 class="w-full bg-gray-100 border rounded px-3 py-2" required>
          @error('nombre_usuario') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Apellidos --}}
        <div>
          <label class="block font-semibold mb-1">Apellidos</label>
          <input type="text" name="apellidos" value="{{ old('apellidos') }}"
                 class="w-full bg-gray-100 border rounded px-3 py-2" required>
          @error('apellidos') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Sexo --}}
        <div>
          <label class="block font-semibold mb-1">Sexo</label>
          <select name="sexo" class="w-full bg-gray-100 border rounded px-3 py-2" required>
            <option value="">-- Seleccione --</option>
            <option value="masculino" {{ old('sexo')=='masculino'?'selected':'' }}>Masculino</option>
            <option value="femenino"  {{ old('sexo')=='femenino' ?'selected':'' }}>Femenino</option>
          </select>
          @error('sexo') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Fecha de Nacimiento --}}
        <div>
          <label class="block font-semibold mb-1">Fecha de Nacimiento</label>
          <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"
                 class="w-full bg-gray-100 border rounded px-3 py-2" required>
          @error('fecha_nacimiento') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Estado --}}
        <div>
          <label class="block font-semibold mb-1">Estado</label>
          <select name="estado" class="w-full bg-gray-100 border rounded px-3 py-2" required>
            <option value="activo"   {{ old('estado')=='activo'   ?'selected':'' }}>Activo</option>
            <option value="inactivo" {{ old('estado')=='inactivo' ?'selected':'' }}>Inactivo</option>
          </select>
          @error('estado') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Estado Civil --}}
        <div>
          <label class="block font-semibold mb-1">Estado Civil</label>
          <select name="estado_civil" class="w-full bg-gray-100 border rounded px-3 py-2" required>
            <option value="soltero"    {{ old('estado_civil')=='soltero'    ?'selected':'' }}>Soltero/a</option>
            <option value="casado"     {{ old('estado_civil')=='casado'     ?'selected':'' }}>Casado/a</option>
            <option value="viudo"      {{ old('estado_civil')=='viudo'      ?'selected':'' }}>Viudo/a</option>
            <option value="divorciado" {{ old('estado_civil')=='divorciado' ?'selected':'' }}>Divorciado/a</option>
          </select>
          @error('estado_civil') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Lugar de Residencia --}}
        <div>
          <label class="block font-semibold mb-1">Lugar de Residencia</label>
          <input type="text" name="lugar_residencia" value="{{ old('lugar_residencia') }}"
                 class="w-full bg-gray-100 border rounded px-3 py-2" required>
          @error('lugar_residencia') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Domicilio --}}
        <div>
          <label class="block font-semibold mb-1">Domicilio</label>
          <input type="text" name="domicilio" value="{{ old('domicilio') }}"
                 class="w-full bg-gray-100 border rounded px-3 py-2" required>
          @error('domicilio') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Correo Electrónico --}}
        <div>
          <label class="block font-semibold mb-1">Correo Electrónico</label>
          <input type="email" name="email" value="{{ old('email') }}"
                 class="w-full bg-gray-100 border rounded px-3 py-2" >
          @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Celular --}}
        <div>
          <label class="block font-semibold mb-1">Celular</label>
          <input type="text" name="celular" value="{{ old('celular') }}"
                 class="w-full bg-gray-100 border rounded px-3 py-2">
          @error('celular') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Referencias --}}
        <div class="md:col-span-2">
          <label class="block font-semibold mb-1">Referencias</label>
          <textarea name="referencias" rows="3"
                    class="w-full bg-gray-100 border rounded px-3 py-2">{{ old('referencias') }}</textarea>
          @error('referencias') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Rol --}}
        <div>
          <label class="block font-semibold mb-1">Rol</label>
          <select name="rol" class="w-full bg-gray-100 border rounded px-3 py-2" required>
            <option value="">-- Seleccione --</option>
            <option value="supervisor gral" {{ old('rol')=='supervisor gral' ?'selected':'' }}>Supervisor Gral</option>
            <option value="supervisor suc"  {{ old('rol')=='supervisor suc'  ?'selected':'' }}>Supervisor SUC</option>
            <option value="cajero"          {{ old('rol')=='cajero'          ?'selected':'' }}>Cajero</option>
            <option value="ventas qr"       {{ old('rol')=='ventas qr'       ?'selected':'' }}>Ventas QR</option>
            <option value="carga"           {{ old('rol')=='carga'           ?'selected':'' }}>Carga</option>
            <option value="encomienda"      {{ old('rol')=='encomienda'      ?'selected':'' }}>Encomienda</option>
            <option value="chofer"          {{ old('rol')=='chofer'          ?'selected':'' }}>Chofer</option>
            <option value="ayudante"        {{ old('rol')=='ayudante'        ?'selected':'' }}>Ayudante</option>
            @if(Auth::user()->rol === 'admin')
              <option value="admin" {{ old('rol')=='admin' ?'selected':'' }}>Admin</option>
            @endif
          </select>
          @error('rol') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Sucursal --}}
        <div>
          <label class="block font-semibold mb-1">Sucursal</label>
          <select name="sucursal" class="w-full bg-gray-100 border rounded px-3 py-2" required>
            <option value="">-- Seleccione --</option>
            @foreach($sucursales as $sucursal)
              <option value="{{ $sucursal->nombre }}" {{ old('sucursal') == $sucursal->nombre ? 'selected' : '' }}>
                {{ $sucursal->nombre }}
              </option>
            @endforeach
          </select>
          @error('sucursal') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Contraseña --}}
        <div>
          <label class="block font-semibold mb-1">Contraseña</label>
          <input type="password" name="password"
                 class="w-full bg-gray-100 border rounded px-3 py-2" required>
          @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Confirmar Contraseña --}}
        <div>
          <label class="block font-semibold mb-1">Confirmar Contraseña</label>
          <input type="password" name="password_confirmation"
                 class="w-full bg-gray-100 border rounded px-3 py-2" required>
        </div>

        {{-- Pregunta de Seguridad --}}
        <div>
          <label class="block font-semibold mb-1">Pregunta de Seguridad</label>
          <select name="security_question"
                  class="w-full bg-gray-100 border rounded px-3 py-2" required>
            <option value="">-- Seleccione --</option>
            <option value="color"    {{ old('security_question')=='color'    ?'selected':'' }}>¿Cuál es tu color favorito?</option>
            <option value="mascota"  {{ old('security_question')=='mascota'  ?'selected':'' }}>¿Cómo se llamaba tu primera mascota?</option>
            <option value="ciudad"   {{ old('security_question')=='ciudad'   ?'selected':'' }}>¿Dónde naciste?</option>
            <option value="comida"   {{ old('security_question')=='comida'   ?'selected':'' }}>¿Cuál es tu comida favorita?</option>
          </select>
          @error('security_question') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Respuesta de Seguridad --}}
        <div>
          <label class="block font-semibold mb-1">Respuesta de Seguridad</label>
          <input type="text" name="security_answer" value="{{ old('security_answer') }}"
                 class="w-full bg-gray-100 border rounded px-3 py-2" required>
          @error('security_answer') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Fotografía --}}
        <div>
          <label class="block font-semibold mb-1">Fotografía (jpg, png o pdf)</label>
          <input type="file" name="foto" accept=".jpg,.jpeg,.png,.pdf"
                 class="w-full bg-gray-100 border rounded px-3 py-2">
          @error('foto') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Documentos 1–5 --}}
        @for($i=1; $i<=5; $i++)
          <div>
            <label class="block font-semibold mb-1">Documento {{ $i }} (jpg, png o pdf)</label>
            <input type="file" name="documento_{{ $i }}" accept=".jpg,.jpeg,.png,.pdf"
                   class="w-full bg-gray-100 border rounded px-3 py-2">
            @error("documento_$i") <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
          </div>
        @endfor

      </div>

      <div class="mt-6 text-right">
        <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
          Registrar Usuario
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
