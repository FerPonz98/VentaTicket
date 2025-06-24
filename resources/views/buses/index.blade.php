@extends('layouts.app')

@section('title','Buses')

@section('content')
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">Listado de Buses</h2>
    <a href="{{ route('buses.create') }}"
       class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded">
      + Crear Bus
    </a>
  </div>

  <div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-gray-200 shadow-sm rounded-lg">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Código</th>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Placa</th>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Capacidad</th>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Modelo</th>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse($buses as $bus)
          <tr class="border-t border-gray-200 hover:bg-gray-50">
            <td class="px-6 py-4 text-gray-800">{{ $bus->codigo }}</td>
            <td class="px-6 py-4 text-gray-800">{{ $bus->placa }}</td>
            <td class="px-6 py-4 text-gray-800">{{ $bus->capacidad }}</td>
            <td class="px-6 py-4 text-gray-800">{{ $bus->modelo ?? '—' }}</td>
            <td class="px-6 py-4 space-x-2">
              <a href="{{ route('buses.edit', $bus) }}"
                 class="text-indigo-600 hover:text-indigo-800 font-medium">Editar</a>
              <form action="{{ route('buses.destroy', $bus) }}" method="POST" class="inline">
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
              No hay buses registrados. 
              <a href="{{ route('buses.create') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                Crea uno ahora
              </a>.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
