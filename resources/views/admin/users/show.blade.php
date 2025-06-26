{{-- resources/views/admin/users/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detalle de Usuario')

@section('content')
<div class="container mx-auto p-7">

  <div class="mb-6">
    <a href="{{ route('users.index') }}"
       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
      ← Volver al listado
    </a>
  </div>

  <div class="bg-white shadow-lg rounded-lg overflow-hidden">

    {{-- Header --}}
    <div class="px-6 py-4 border-b">
      <h1 class="text-2xl font-semibold text-gray-800">
        Usuario: {{ $usuario->nombre_usuario }} {{ $usuario->apellidos }}
      </h1>
    </div>

    {{-- Grid: preview a la izquierda, datos a la derecha --}}
    <div class="px-6 py-8 grid grid-cols-1 md:grid-cols-2 gap-8">

      {{-- Columna izquierda: Preview rectangular --}}
      <div class="flex items-center justify-center">
        @if($usuario->foto)
          @php
            $url = asset('storage/'.$usuario->foto);
            $ext = strtolower(pathinfo($usuario->foto, PATHINFO_EXTENSION));
          @endphp

          @if(in_array($ext, ['jpg','jpeg','png']))
            {{-- Imagen rectangular --}}
            <img src="{{ $url }}"
                 alt="Perfil de {{ $usuario->nombre_usuario }}"
                 class="w-80 h-80 object-cover rounded-lg border"/>
          @else
            {{-- PDF preview --}}
            <div class="w-64 h-64 border rounded-lg overflow-hidden">
              <iframe src="{{ $url }}" class="w-full h-full"></iframe>
            </div>
          @endif
        @else
          {{-- Placeholder --}}
          <div class="w-64 h-64 bg-gray-100 flex items-center justify-center text-gray-400 rounded-lg">
            Sin foto
          </div>
        @endif
      </div>

      {{-- Columna derecha: Datos del usuario --}}
      <dl class="space-y-4 text-black">
        @php
          $fields = [
            'Estado'        => $usuario->Estado === 'activo' ? 'Activo' : 'Bloqueado',
            'CI'           => $usuario->ci_usuario,
            'Rol'          => ucfirst($usuario->rol),
            'Sucursal'    => ucfirst($usuario->sucursal),
            'Email'        => $usuario->email,
            'Sexo'         => $usuario->sexo === 'M' ? 'Masculino' : 'Femenino',
            'Nacimiento'   => $usuario->fecha_nacimiento,
            'Estado civil' => ucfirst($usuario->estado_civil),
            'Residencia'   => $usuario->lugar_residencia,
            'Domicilio'    => $usuario->domicilio,
            'Celular'      => $usuario->celular ?? '—',
            'Referencias'  => $usuario->referencias ?? '—',
          ];
        @endphp

        @foreach($fields as $label => $value)
          <div class="grid grid-cols-3 gap-4">
            <dt class="text-gray-600 font-medium">{{ $label }}:</dt>
            <dd class="col-span-2 text-gray-800">{{ $value }}</dd>
          </div>
        @endforeach
      </dl>

    </div>

    {{-- Documentos Adjuntos --}}
    <div class="px-6 pb-8">
      <h2 class="text-lg font-medium text-gray-700 mb-4">Documentos Adjuntos</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @for($i = 1; $i <= 5; $i++)
          @php
            $field = "documento_$i";
            $path  = $usuario->$field;
            $ext   = $path ? strtolower(pathinfo($path, PATHINFO_EXTENSION)) : null;
            $url   = $path ? asset('storage/'.$path) : null;
          @endphp

          <div class="bg-gray-50 p-4 rounded-lg border">
            <h3 class="font-medium text-gray-600 mb-2">Documento {{ $i }}</h3>

            @if($path)
              @if($ext === 'pdf')
                <div class="border rounded overflow-hidden mb-2">
                  <iframe src="{{ $url }}" class="w-full h-40"></iframe>
                </div>
                <a href="{{ $url }}" target="_blank"
                   class="inline-block mt-1 px-3 py-1 bg-gray-100 text-gray-800 rounded hover:bg-gray-200 transition">
                  📄 Ver PDF
                </a>
              @else
                <img src="{{ $url }}" alt="Doc {{ $i }}"
                     class="w-full h-40 object-cover rounded mb-2 border"/>
                <a href="{{ $url }}" target="_blank"
                   class="inline-block mt-1 px-3 py-1 bg-gray-100 text-gray-800 rounded hover:bg-gray-200 transition">
                  📥 Descargar imagen
                </a>
              @endif
            @else
              <p class="italic text-gray-500">No hay documento {{ $i }}.</p>
            @endif
          </div>
        @endfor
      </div>
    </div>

  </div>
</div>
@endsection