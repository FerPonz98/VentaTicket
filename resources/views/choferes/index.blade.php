{{-- resources/views/choferes/index.blade.php --}}
@extends('layouts.app')

@section('title','Choferes')

@section('content')
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">Listado de Choferes</h2>
    <a href="{{ route('choferes.create') }}"
       class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded">
      + Crear Chofer
    </a>
  </div>

  <div class="overflow-x-auto bg-white border border-gray-200 shadow-sm rounded-lg">
    <table class="min-w-full">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">N°</th>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Bus</th>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Chofer</th>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Licencia</th>
          <th class="px-6 py-3 text-left text-gray-700 uppercase text-sm">Venc. Licencia</th>
          <th class="px-6 py-3 text-center text-gray-700 uppercase text-sm">Acciones</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @forelse($choferes as $chofer)
          <tr class="hover:bg-gray-50">
            <td class="px-6 py-4 text-sm text-gray-900">{{ $chofer->numero }}</td>
            <td class="px-6 py-4 text-sm text-gray-900">{{ $chofer->bus_codigo }}</td>
            <td class="px-6 py-4 text-sm text-gray-900">{{ $chofer->nombre_chofer }}</td>
            <td class="px-6 py-4 text-sm text-gray-900">{{ $chofer->licencia }}</td>
            <td class="px-6 py-4 text-sm text-gray-900">{{ \Carbon\Carbon::parse($chofer->vencimiento_licencia)->format('d/m/Y') }}</td>
            <td class="px-6 py-4 text-sm font-medium text-center space-x-4">
              <a href="{{ route('choferes.show', $chofer) }}" class="text-green-600 hover:underline">Ver</a>
              <a href="{{ route('choferes.edit', $chofer) }}" class="text-blue-600 hover:underline">Editar</a>
              <form action="{{ route('choferes.destroy', $chofer) }}" method="POST" class="inline-block">
                @csrf @method('DELETE')
                <button type="submit" onclick="return confirm('¿Eliminar este chofer?')" class="text-red-600 hover:text-red-800">Eliminar</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="px-6 py-4 text-center text-gray-600">No hay choferes registrados.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
