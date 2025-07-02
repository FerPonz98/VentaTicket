{{-- resources/views/pasajes/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Pasajes')

@section('content')
<div class="container mx-auto mt-6">

  {{-- Botón Nuevo Pasaje --}}
  <div class="w-full flex flex-row-reverse p-4 pb-8">
    <a href="{{ route('pasajes.create') }}"
       class="bg-green-600 p-2 text-white text-sm font-normal rounded-lg shadow hover:bg-green-700 transition"
    >+ Nuevo Pasaje</a>
  </div>

  @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded">
      {{ session('success') }}
    </div>
  @endif

  {{-- BOX A: Listado de Pasajes --}}
  <div class="bg-white shadow-xl rounded-lg overflow-hidden p-6 mb-6 overflow-x-auto">
    <table class="min-w-full table-auto">
      <thead class="bg-white">
        <tr>
          <th colspan="7" class="text-2xl font-bold text-black text-left">
            <div class="flex justify-between items-center w-full">
              <h2>Listado de Pasajes</h2>
              <form method="GET" action="{{ route('pasajes.index') }}" class="flex items-center space-x-2 w-full max-w-md">
                <input
                  type="date"
                  name="fecha"
                  value="{{ $fecha }}"
                  class="border w-full p-2 border-gray-300 text-sm font-light rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white"
                />
                <button
                  type="submit"
                  class="bg-indigo-600 p-1 text-white text-sm font-semibold rounded-lg shadow hover:bg-indigo-700 transition"
                >Filtrar por Fecha</button>
              </form>
            </div>
          </th>
        </tr>
        <tr>
          <th colspan="7" class="px-6 py-2 bg-white">

          </th>
        </tr>
        <tr class="text-left bg-gray-200 text-black uppercase text-sm leading-normal">
          <th class="px-6 py-3">Bus</th>
          <th class="px-6 py-3">Ruta</th>
          <th class="px-6 py-3">Fecha Salida</th>
          <th class="px-6 py-3">Precio (Bs)</th>
          <th class="px-6 py-3">Vendidos</th>
          <th class="px-6 py-3">Disponibles</th>
          <th class="px-6 py-3">Acción</th>
        </tr>
      </thead>
      <tbody class="text-gray-700 text-sm border border-gray-200">
        @if($viajesHoy->isNotEmpty())
          @foreach($viajesHoy as $viaje)
            @php
              $capacidad   = $viaje->bus->asientos_piso1 + $viaje->bus->asientos_piso2;
              $vendidos    = $viaje->pasajes->count();
              $disponibles = max(0, $capacidad - $vendidos);
            @endphp
            <tr class="border-b border-gray-200 hover:bg-gray-50">
              <td class="px-6 py-4">{{ $viaje->bus->codigo }}</td>
              <td class="px-6 py-4">{{ $viaje->ruta->origen }} → {{ $viaje->ruta->destino }}</td>
              <td class="px-6 py-4">{{ $viaje->fecha_salida->format('Y-m-d H:i') }}</td>
              <td class="px-6 py-4">{{ number_format($viaje->precio, 2) }}</td>
              <td class="px-6 py-4">{{ $vendidos }}</td>
              <td class="px-6 py-4">{{ $disponibles }}</td>
              <td class="px-6 py-4">
                <a href="{{ route('pasajes.disponibilidad', $viaje) }}"
                   class="px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700"
                >Ver</a>
              </td>
            </tr>
          @endforeach
        @else
          <tr>
            <td colspan="7" class="px-6 py-4 text-center text-gray-600">
              No se encontraron viajes para la fecha <strong>{{ $fecha }}</strong>.
            </td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>

  {{-- Tabla de Pasajes Recientes Vendidos --}}
  <div class="bg-white shadow-xl rounded-lg overflow-hidden p-6 mb-6 overflow-x-auto">
    <h3 class="text-xl font-bold text-black mb-4">Pasajes Recientes Vendidos</h3>
    <table class="min-w-full table-auto">
      <thead class="bg-gray-100">
        <tr class="text-left text-black uppercase text-sm leading-normal">
          <th class="px-4 py-2">Pasajero</th>
          <th class="px-4 py-2">Bus</th>
          <th class="px-4 py-2">Ruta</th>
          <th class="px-4 py-2">Fecha Venta</th>
          <th class="px-4 py-2">Precio (Bs)</th>
          <th class="px-4 py-2">Acción</th>
        </tr>
      </thead>
      <tbody class="text-gray-700 text-sm">
        @forelse($pasajesRecientes as $pasaje)
          <tr class="border-b border-gray-200 hover:bg-gray-50">
            <td class="px-4 py-2">{{ $pasaje->nombre_completo ?? '-' }}</td>
            <td class="px-4 py-2">{{ $pasaje->viaje->bus->codigo ?? '-' }}</td>
            <td class="px-4 py-2">
              {{ $pasaje->viaje->ruta->origen ?? '-' }} → {{ $pasaje->viaje->ruta->destino ?? '-' }}
            </td>
            <td class="px-4 py-2">{{ $pasaje->created_at->format('Y-m-d H:i') }}</td>
            <td class="px-4 py-2">{{ number_format($pasaje->precio, 2) }}</td>
            <td class="px-4 py-2">
              <a href="{{ route('pasajes.ticket', $pasaje) }}"
                 class="px-3 py-1 	bg-teal-600 text-white text-xs rounded hover:bg-indigo-700"
                 target="_blank">
                 PDF
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="px-4 py-2 text-center text-gray-600">
              No hay pasajes recientes vendidos.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
