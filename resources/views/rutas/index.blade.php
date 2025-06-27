{{-- resources/views/rutas/index.blade.php --}}
@extends('layouts.app')

@section('title','Administrar Rutas, Paradas y Tramos')

@section('content')
  {{-- RUTAS --}}
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">Rutas</h2>
    <a href="{{ route('rutas.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded">
      + Nueva Ruta
    </a>
  </div>

  <div class="overflow-x-auto bg-white rounded-lg shadow mb-12">
    <table class="min-w-full">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-4 py-2 text-gray-700 text-left">ID</th>
          <th class="px-4 py-2 text-gray-700 text-left">Origen</th>
          <th class="px-4 py-2 text-gray-700 text-left">Destino</th>
          <th class="px-4 py-2 text-gray-700 text-left">Paradas</th>
          <th class="px-4 py-2 text-gray-700 text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($rutas as $ruta)
          <tr class="border-t hover:bg-gray-50 align-top">
            <td class="px-4 py-2 text-gray-900">{{ $ruta->id }}</td>
            <td class="px-4 py-2 text-gray-900">{{ $ruta->origen }}</td>
            <td class="px-4 py-2 text-gray-900">{{ $ruta->destino }}</td>

            {{-- Listado de paradas --}}
            <td class="px-4 py-2 text-gray-900">
              @php $paradas = $ruta->paradas ?? []; @endphp

              @if(count($paradas))
                <ul class="list-disc ml-4 space-y-1">
                  @foreach($paradas as $p)
                    <li>
                      <strong>{{ $p['numero'] }}.</strong> {{ $p['nombre'] }}
                      — Bs {{ number_format($p['precio_pasaje']?? 0, 2) }}
                      @isset($p['precio_encomienda_parada'])
                        | Encomienda: Bs {{ number_format($p['precio_encomienda_parada'] ?? 0, 2) }}
                      @endisset
                      @isset($p['precio_carga_parada'])
                        | Carga: Bs {{ number_format($p['precio_carga_parada'] ?? 0, 2) }}
                      @endisset
                      @if(!empty($p['hora']))
                        | Hora: {{ \Carbon\Carbon::createFromFormat('H:i', $p['hora'])->format('H:i') }}
                      @endif
                    </li>
                  @endforeach
                </ul>
              @else
                <span class="text-gray-500">Sin paradas</span>
              @endif
            </td>

            <td class="px-4 py-2 text-center space-x-2">
              <a href="{{ route('rutas.show', $ruta) }}" class="text-green-600">Ver</a>
              <a href="{{ route('rutas.edit', $ruta) }}" class="text-blue-600">Editar</a>
              <form action="{{ route('rutas.destroy', $ruta) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button onclick="return confirm('¿Eliminar esta ruta?')" class="text-red-600">Borrar</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-4 py-4 text-center text-gray-600">No hay rutas.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
