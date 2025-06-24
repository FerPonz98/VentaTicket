{{-- resources/views/rutas/index.blade.php --}}

@extends('layouts.app')

@section('title','Rutas')

@section('content')
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">Listado de Rutas</h2>
    <a href="{{ route('rutas.create') }}"
       class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded">
      + Crear Ruta
    </a>
  </div>

  <div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-200 shadow-sm rounded-lg">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Origen</th>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Destino</th>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Hora</th>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Precio (Bs)</th>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($rutas as $ruta)
          <tr class="border-t border-gray-200 hover:bg-gray-50">
            <td class="px-6 py-4 text-gray-800">{{ $ruta->origen }}</td>
            <td class="px-6 py-4 text-gray-800">{{ $ruta->destino }}</td>
            <td class="px-6 py-4 text-gray-800">{{ $ruta->hora_salida }}</td>
            <td class="px-6 py-4 text-gray-800">{{ number_format($ruta->precio_bus_normal, 2) }}</td>
            <td class="px-6 py-4 space-x-2">
              <a href="{{ route('rutas.edit', $ruta) }}"
                 class="text-indigo-600 hover:text-indigo-800 font-medium">
                Editar
              </a>
              <form action="{{ route('rutas.destroy', $ruta) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
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
              No hay rutas registradas. 
              <a href="{{ route('rutas.create') }}"
                 class="text-indigo-600 hover:text-indigo-800 font-medium">
                Crea una ahora
              </a>.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
