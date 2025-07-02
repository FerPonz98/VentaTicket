{{-- resources/views/viajes/index.blade.php --}}
@extends('layouts.app')

@section('title','Viajes')

@section('content')
<div class="container mx-auto mt-6">

  {{-- Botón Crear Viaje afuera del box --}}
  <div class="w-full flex justify-end mb-2">
    <a href="{{ route('viajes.create') }}"
       class="bg-green-600 p-2 text-white text-sm rounded-lg shadow hover:bg-green-700 transition"
    >+ Crear Viaje</a>
  </div>

  <div class="bg-white shadow-xl rounded-lg overflow-hidden p-6 mb-5 overflow-x-auto">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold text-gray-800 ">Administración de Viajes</h2>
      {{-- Filtros --}}
    <form method="GET" action="{{ route('viajes.index') }}" class="flex flex-wrap gap-4 mb">
      <div>
        <label for="ruta_id" class="block text-gray-700 font-semibold mb-1 uppercase text-sm">Ruta</label>
        <select name="ruta_id" id="ruta_id" class="border rounded p-2 w-full">
          <option value="">Todas</option>
          @foreach($rutas as $r)
            <option value="{{ $r->id }}" {{ request('ruta_id') == $r->id ? 'selected' : '' }}>
              {{ $r->origen }} → {{ $r->destino }}
            </option>
          @endforeach
        </select>
      </div>

      <div>
        <label for="fecha" class="block text-gray-700 font-semibold mb-1 uppercase text-sm">Fecha</label>
        <input type="date" name="fecha" id="fecha"
               value="{{ request('fecha') }}"
               class="border rounded p-2" />
      </div>

      <div class="flex items-end space-x-2">
        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition">
          Buscar
        </button>
        <a href="{{ route('viajes.index') }}"
           class="bg-gray-300 text-gray-800 px-4 py-2 rounded shadow hover:bg-gray-400 transition">
          Limpiar
        </a>
      </div>
    </form>
    </div>


    {{-- Tabla --}}
    <table class="min-w-full table-auto">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-6 py-3 text-left text-gray-800 font-semibold uppercase">Bus</th>
          <th class="px-6 py-3 text-center text-gray-800 font-semibold uppercase">Ruta</th>
          <th class="px-6 py-3 text-center text-gray-800 font-semibold uppercase">Fecha de salida</th>
          <th class="px-6 py-3 text-center text-gray-800 font-semibold uppercase">Precio (Bs)</th>
          <th class="px-6 py-3 text-center text-gray-800 font-semibold uppercase">Acciones</th>
        </tr>
      </thead>
      <tbody class="text-gray-700 text-sm">
        @forelse($viajes as $viaje)
          <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
            <td class="px-6 py-4">{{ $viaje->bus->codigo }}</td>
            <td class="px-6 py-4 text-center">
              {{ $viaje->ruta->origen }} → {{ $viaje->ruta->destino }}
            </td>
            <td class="px-6 py-4 text-center">
              {{ \Carbon\Carbon::parse($viaje->fecha_salida)->format('Y-m-d H:i') }}
            </td>
            <td class="px-6 py-4 text-center">
              {{ number_format($viaje->precio,2) }}
            </td>
            <td class="px-6 py-4 text-center space-x-2">
              <a href="{{ route('viajes.show',  $viaje) }}" class="text-indigo-600 hover:underline">Ver</a>
              <a href="{{ route('viajes.edit',  $viaje) }}" class="text-yellow-600 hover:underline">Editar</a>
              <form action="{{ route('viajes.destroy', $viaje) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit"
                        onclick="return confirm('¿Eliminar este viaje?')"
                        class="text-red-600 hover:underline">
                  Eliminar
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr class="bg-white">
            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
              No hay viajes registrados.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>

    {{-- Paginación --}}
    @if(method_exists($viajes, 'links'))
      <div class="mt-4">
        {{ $viajes->withQueryString()->links() }}
      </div>
    @endif

  </div>
</div>
@endsection
