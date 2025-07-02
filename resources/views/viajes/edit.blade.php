{{-- resources/views/viajes/edit.blade.php --}}
@extends('layouts.app')

@section('title','Editar Viaje')

@section('content')
  <a href="{{ route('viajes.index') }}"
     class="inline-block text-indigo-600 hover:text-indigo-800 underline mb-4">
    &larr; Volver al listado
  </a>
  <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Editar Viaje</h2>

    <form action="{{ route('viajes.update', $viaje) }}" method="POST" class="space-y-6">
      @csrf @method('PATCH')

      <div>
        <label class="block mb-1 text-gray-700">Bus</label>
        <select name="bus_id"
                class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900">
          <option value="">Selecciona un bus</option>
          @foreach($buses as $id => $codigo)
            <option value="{{ $id }}" {{ old('bus_id', $viaje->bus_id) == $id ? 'selected' : '' }}>
              {{ $codigo }}
            </option>
          @endforeach
        </select>
        @error('bus_id') <p class="mt-1 text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block mb-1 text-gray-700">Ruta</label>
        <select name="ruta_id"
                class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900">
          <option value="">Selecciona una ruta</option>
          @foreach($rutas as $id => $label)
            <option value="{{ $id }}" {{ old('ruta_id', $viaje->ruta_id) == $id ? 'selected' : '' }}>
              {{ $label }}
            </option>
          @endforeach
        </select>
        @error('ruta_id') <p class="mt-1 text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block mb-1 text-gray-700">Fecha de salida</label>
        <input type="datetime-local" name="fecha_salida"
               value="{{ old('fecha_salida', \Carbon\Carbon::parse($viaje->fecha_salida)->format('Y-m-d\TH:i')) }}"
               class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900">
        @error('fecha_salida') <p class="mt-1 text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block mb-1 text-gray-700">Precio (Bs)</label>
        <input type="number" step="0.01" name="precio"
               value="{{ old('precio', $viaje->precio) }}"
               class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900">
        @error('precio') <p class="mt-1 text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div class="pt-4">
        <button type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 rounded">
          Actualizar
        </button>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const precios = @json($precios);
      const rutaSelect = document.querySelector('select[name="ruta_id"]');
      const precioInput = document.querySelector('input[name="precio"]');

      rutaSelect.addEventListener('change', function() {
        const rutaId = this.value;
        if (precios[rutaId]) {
          precioInput.value = precios[rutaId];
        } else {
          precioInput.value = '';
        }
      });
    });
  </script>
@endsection
