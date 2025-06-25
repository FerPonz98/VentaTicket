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

  @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-2 rounded">
      {{ session('success') }}
    </div>
  @endif

  <div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2 text-left text-gray-700 uppercase text-sm">ID</th>
          <th class="px-4 py-2 text-left text-gray-700 uppercase text-sm">Origen</th>
          <th class="px-4 py-2 text-left text-gray-700 uppercase text-sm">Destino</th>
          <th class="px-4 py-2 text-left text-gray-700 uppercase text-sm">Hora Salida</th>
          <th class="px-4 py-2 text-left text-gray-700 uppercase text-sm">Precio Normal</th>
          <th class="px-4 py-2 text-left text-gray-700 uppercase text-sm">Doble Semicama</th>
          <th class="px-4 py-2 text-left text-gray-700 uppercase text-sm">1 Piso Semicama</th>
          <th class="px-4 py-2 text-left text-gray-700 uppercase text-sm">3ra Edad</th>
          <th class="px-4 py-2 text-left text-gray-700 uppercase text-sm">Cortesía</th>
          <th class="px-4 py-2 text-left text-gray-700 uppercase text-sm">Discapacidad</th>
          <th class="px-4 py-2 text-left text-gray-700 uppercase text-sm">Desc. 2</th>
          <th class="px-4 py-2 text-left text-gray-700 uppercase text-sm">Desc. 3</th>
          <th class="px-4 py-2 text-center text-gray-700 uppercase text-sm">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($rutas as $ruta)
          <tr class="border-t hover:bg-gray-50">
            <td class="px-4 py-2 text-gray-800">{{ $ruta->id }}</td>
            <td class="px-4 py-2 text-gray-800">{{ $ruta->origen }}</td>
            <td class="px-4 py-2 text-gray-800">{{ $ruta->destino }}</td>
            <td class="px-4 py-2 text-gray-800">{{ \Carbon\Carbon::parse($ruta->hora_salida)->format('H:i') }}</td>
            <td class="px-4 py-2 text-gray-800">{{ number_format($ruta->precio_bus_normal,2) }}</td>
            <td class="px-4 py-2 text-gray-800">{{ number_format($ruta->precio_bus_doble_semicama,2) }}</td>
            <td class="px-4 py-2 text-gray-800">{{ number_format($ruta->precio_bus_un_piso_semicama,2) }}</td>
            <td class="px-4 py-2 text-gray-800">{{ number_format($ruta->precio_3ra_edad,2) }}</td>
            <td class="px-4 py-2 text-gray-800">{{ number_format($ruta->precio_cortesia,2) }}</td>
            <td class="px-4 py-2 text-gray-800">{{ number_format($ruta->precio_discapacidad,2) }}</td>
            <td class="px-4 py-2 text-gray-800">{{ number_format($ruta->descuento2,2) }}</td>
            <td class="px-4 py-2 text-gray-800">{{ number_format($ruta->descuento3,2) }}</td>
            <td class="px-4 py-2 text-center space-x-2">
              <a href="{{ route('rutas.edit', $ruta) }}" class="text-indigo-600 hover:text-indigo-800">Editar</a>
              <form action="{{ route('rutas.destroy', $ruta) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('¿Eliminar esta ruta?')" class="text-red-600 hover:text-red-800">
                  Eliminar
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="13" class="px-4 py-4 text-center text-gray-600">No hay rutas registradas.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
