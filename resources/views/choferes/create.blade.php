{{-- resources/views/choferes/create.blade.php --}}
@extends('layouts.app')

@section('title','Crear Chofer')

@section('content')
  <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Nuevo Chofer</h2>

    <form action="{{ route('choferes.store') }}" method="POST" class="space-y-6">
      @csrf

      <div>
        <label class="block mb-1 text-gray-700">Bus</label>
        <select name="bus_id"
                class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900">
          <option value="">Selecciona un bus</option>
          @foreach($buses as $id => $codigo)
            <option value="{{ $id }}" {{ old('bus_id') == $id ? 'selected' : '' }}>
              {{ $codigo }}
            </option>
          @endforeach
        </select>
        @error('bus_id') <p class="mt-1 text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block mb-1 text-gray-700">Nombre Chofer</label>
        <input
          name="nombre_chofer"
          value="{{ old('nombre_chofer') }}"
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
        @error('nombre_chofer') <p class="mt-1 text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block mb-1 text-gray-700">Licencia</label>
        <input
          name="licencia"
          value="{{ old('licencia') }}"
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
        @error('licencia') <p class="mt-1 text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block mb-1 text-gray-700">Vencimiento Licencia</label>
        <input type="date" name="vencimiento_licencia"
               value="{{ old('vencimiento_licencia') }}"
               class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
        @error('vencimiento_licencia') <p class="mt-1 text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block mb-1 text-gray-700">Nombre Ayudante</label>
        <input
          name="nombre_ayudante"
          value="{{ old('nombre_ayudante') }}"
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
        @error('nombre_ayudante') <p class="mt-1 text-red-600 text-sm">{{ $message }}</p> @enderror
      </div>

      <div class="pt-4">
        <button type="submit"
                class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 rounded">
          Guardar
        </button>
      </div>
    </form>
  </div>
@endsection
