{{-- resources/views/choferes/show.blade.php --}}
@extends('layouts.app')

@section('title','Ver Chofer')

@section('content')
  <a href="{{ route('choferes.index') }}" class="inline-block text-indigo-600 hover:text-indigo-800 underline mb-4">
    &larr; Volver al listado
  </a>

  <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow space-y-4">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Detalles del Chofer</h2>

    <div>
      <label class="block text-gray-700 font-medium">N°:</label>
      <p class="mt-1 text-gray-900">{{ $chofer->numero }}</p>
    </div>
    <div>
      <label class="block text-gray-700 font-medium">Código de Bus:</label>
      <p class="mt-1 text-gray-900">{{ $chofer->bus_codigo }}</p>
    </div>
    <div>
      <label class="block text-gray-700 font-medium">Nombre del Chofer:</label>
      <p class="mt-1 text-gray-900">{{ $chofer->nombre_chofer }}</p>
    </div>
    <div>
      <label class="block text-gray-700 font-medium">CI:</label>
      <p class="mt-1 text-gray-900">{{ $chofer->ci }}</p>
    </div>
    <div>
      <label class="block text-gray-700 font-medium">Licencia:</label>
      <p class="mt-1 text-gray-900">{{ $chofer->licencia }}</p>
    </div>
    <div>
      <label class="block text-gray-700 font-medium">Vencimiento de Licencia:</label>
      <p class="mt-1 text-gray-900">{{ \Carbon\Carbon::parse($chofer->vencimiento_licencia)->format('d/m/Y') }}</p>
    </div>

    <div class="pt-4 flex gap-4">
      <a href="{{ route('choferes.edit', $chofer) }}" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 rounded text-center">
        Editar
      </a>
      <form action="{{ route('choferes.destroy', $chofer) }}" method="POST" class="flex-1">
        @csrf @method('DELETE')
        <button type="submit" onclick="return confirm('¿Eliminar este chofer?')"
                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 rounded">
          Eliminar
        </button>
      </form>
    </div>
  </div>
@endsection
