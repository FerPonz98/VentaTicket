{{-- resources/views/buses/index.blade.php --}}
@extends('layouts.app')

@section('title','Listado de Buses')

@section('content')
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">Listado de Buses</h2>
    <a href="{{ route('buses.create') }}"
       class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded">
      + Crear Bus
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
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Código</th>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Placa</th>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Tipo</th>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Asientos 1º Piso</th>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Asientos 2º Piso</th>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Tipo Asiento</th>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Chofer</th>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($buses as $bus)
          <tr class="border-t hover:bg-gray-50">
            <td class="px-6 py-4 text-gray-800">{{ $bus->codigo }}</td>
            <td class="px-6 py-4 text-gray-800">{{ $bus->placa }}</td>
            <td class="px-6 py-4 text-gray-800">{{ $bus->tipo_de_bus }}</td>
            <td class="px-6 py-4 text-gray-800">{{ $bus->asientos_piso1 }}</td>
            <td class="px-6 py-4 text-gray-800">{{ $bus->asientos_piso2 }}</td>
            <td class="px-6 py-4 text-gray-800">{{ $bus->tipo_asiento }}</td>
            <td class="px-6 py-4 text-gray-800">{{ optional($bus->chofer)->nombre_chofer ?? '—' }}</td>
            <td class="px-6 py-4 space-x-2">
              <a href="{{ route('buses.show', $bus) }}"
                 class="text-green-600 hover:text-green-800 font-medium">Ver</a>
              <a href="{{ route('buses.edit', $bus) }}"
                 class="text-indigo-600 hover:text-indigo-800 font-medium">Editar</a>
              <form action="{{ route('buses.destroy', $bus) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit"
                        class="text-red-600 hover:text-red-800 font-medium"
                        onclick="return confirm('¿Eliminar este bus?')">
                  Eliminar
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" class="px-6 py-4 text-center text-gray-600">
              No hay buses registrados.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
