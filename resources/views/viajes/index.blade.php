{{-- resources/views/viajes/index.blade.php --}}

@extends('layouts.app')

@section('title','Viajes')

@section('content')
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">Listado de Viajes</h2>
    <a href="{{ route('viajes.create') }}"
       class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded">
      + Crear Viaje
    </a>
  </div>

  <div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-200 shadow-sm rounded-lg">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Bus</th>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Ruta</th>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Fecha de salida</th>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Precio (Bs)</th>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($viajes as $viaje)
          <tr class="border-t border-gray-200 hover:bg-gray-50">
            <td class="px-6 py-4 text-gray-800">{{ $viaje->bus->codigo }}</td>
            <td class="px-6 py-4 text-gray-800">{{ $viaje->ruta->origen }} → {{ $viaje->ruta->destino }}</td>
            <td class="px-6 py-4 text-gray-800">{{ \Carbon\Carbon::parse($viaje->fecha_salida)->format('Y-m-d H:i') }}</td>
            <td class="px-6 py-4 text-gray-800">{{ number_format($viaje->precio,2) }}</td>
            <td class="px-6 py-4 space-x-2">
               <a href="{{ route('viajes.show', $viaje) }}" class="text-green-600">Ver</a>
              <a href="{{ route('viajes.edit', $viaje) }}"
                 class="text-indigo-600 hover:text-indigo-800 font-medium">
                Editar
              </a>
              <form action="{{ route('viajes.destroy', $viaje) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit"
                        class="text-red-600 hover:text-red-800 font-medium">
                  Eliminar
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-6 py-4 text-center text-gray-600">
              No hay viajes registrados.

            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
