{{-- resources/views/choferes/create.blade.php --}}
@extends('layouts.app')

@section('title','Crear Chofer')

@section('content')
  {{-- Link de volver al listado --}}
  <a href="{{ route('choferes.index') }}" class="inline-block text-indigo-600 hover:text-indigo-800 underline mb-4">&larr; Volver al listado</a>

  <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Nuevo Chofer</h2>

    <form action="{{ route('choferes.store') }}" method="POST" class="space-y-6">
      @csrf

      {{-- Número --}}
      <div>
        <label class="block mb-1 text-gray-700 font-medium" for="numero">N°*</label>
        <input
          id="numero"
          type="number"
          name="numero"
          value="{{ old('numero') }}"
          placeholder="1"
          required
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
        @error('numero')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
      </div>

      {{-- Código de Bus --}}
      <div>
        <label class="block mb-1 text-gray-700 font-medium" for="bus_codigo">Código de Bus*</label>
        <input
          id="bus_codigo"
          type="text"
          name="bus_codigo"
          value="{{ old('bus_codigo') }}"
          placeholder="p.ej. L21"
          required
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
        @error('bus_codigo')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
      </div>

      {{-- Nombre del Chofer --}}
      <div>
        <label class="block mb-1 text-gray-700 font-medium" for="nombre_chofer">Nombre del Chofer*</label>
        <input
          id="nombre_chofer"
          type="text"
          name="nombre_chofer"
          value="{{ old('nombre_chofer') }}"
          placeholder="Nombre completo"
          required
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
        @error('nombre_chofer')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
      </div>

      {{-- Número de Licencia --}}
      <div>
        <label class="block mb-1 text-gray-700 font-medium" for="licencia">Número de Licencia*</label>
        <input
          id="licencia"
          type="text"
          name="licencia"
          value="{{ old('licencia') }}"
          placeholder="Ej. 4512794"
          required
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
        @error('licencia')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
      </div>

      {{-- Vencimiento de Licencia --}}
      <div>
        <label class="block mb-1 text-gray-700 font-medium" for="vencimiento_licencia">Vencimiento de Licencia*</label>
        <input
          id="vencimiento_licencia"
          type="date"
          name="vencimiento_licencia"
          value="{{ old('vencimiento_licencia') }}"
          required
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
        @error('vencimiento_licencia')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
      </div>

      {{-- Botones --}}
      <div class="pt-4 flex gap-4">
        <a href="{{ route('choferes.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 rounded text-center">Cancelar</a>
        <button
          type="submit"
          class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-2 rounded">
          Crear
        </button>
      </div>
    </form>
  </div>
@endsection
