{{-- resources/views/buses/edit.blade.php --}}
@extends('layouts.app')

@section('title','Editar Bus')

@section('content')
  <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Editar Bus</h2>

    <form action="{{ route('buses.update', $bus) }}" method="POST" class="space-y-6">
      @csrf @method('PATCH')

      <div>
        <label class="block mb-1 text-gray-700">Código</label>
        <input
          name="codigo"
          value="{{ old('codigo', $bus->codigo) }}"
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
        @error('codigo')
          <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="block mb-1 text-gray-700">Placa</label>
        <input
          name="placa"
          value="{{ old('placa', $bus->placa) }}"
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
        @error('placa')
          <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="block mb-1 text-gray-700">Capacidad</label>
        <input
          type="number" name="capacidad"
          value="{{ old('capacidad', $bus->capacidad) }}"
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
        @error('capacidad')
          <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="block mb-1 text-gray-700">Modelo</label>
        <input
          name="modelo"
          value="{{ old('modelo', $bus->modelo) }}"
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
        @error('modelo')
          <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
        @enderror
      </div>

      <div class="pt-4">
        <button
          type="submit"
          class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 rounded">
          Actualizar
        </button>
      </div>
    </form>
  </div>
@endsection
