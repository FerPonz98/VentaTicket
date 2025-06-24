{{-- resources/views/rutas/create.blade.php --}}
@extends('layouts.app')

@section('title','Crear Ruta')

@section('content')
  <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Nueva Ruta</h2>

    <form action="{{ route('rutas.store') }}" method="POST" class="space-y-6">
      @csrf

      <div>
        <label class="block mb-1 text-gray-700">Origen</label>
        <input
          name="origen"
          value="{{ old('origen') }}"
          placeholder="p.ej. Santa Cruz"
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
        @error('origen')
          <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="block mb-1 text-gray-700">Destino</label>
        <input
          name="destino"
          value="{{ old('destino') }}"
          placeholder="p.ej. Cochabamba"
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
        @error('destino')
          <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="block mb-1 text-gray-700">Hora de salida</label>
        <input
          type="time"
          name="hora_salida"
          value="{{ old('hora_salida') }}"
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
        @error('hora_salida')
          <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="block mb-1 text-gray-700">Precio bus normal (Bs)</label>
        <input
          type="number" step="0.01"
          name="precio_bus_normal"
          value="{{ old('precio_bus_normal') }}"
          placeholder="p.ej. 25.00"
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
        @error('precio_bus_normal')
          <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="block mb-1 text-gray-700">Recargo semicama (Bs)</label>
        <input
          type="number" step="0.01"
          name="recargo_semicama"
          value="{{ old('recargo_semicama') }}"
          placeholder="p.ej. 5.00"
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
        @error('recargo_semicama')
          <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="block mb-1 text-gray-700">Descuento 3ª edad (Bs)</label>
        <input
          type="number" step="0.01"
          name="descuento_3ra_edad"
          value="{{ old('descuento_3ra_edad') }}"
          placeholder="p.ej. 10.00"
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
        @error('descuento_3ra_edad')
          <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
        @enderror
      </div>

      <div class="pt-4">
        <button
          type="submit"
          class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 rounded">
          Guardar
        </button>
      </div>
    </form>
  </div>
@endsection
