{{-- resources/views/buses/index.blade.php --}}
@extends('layouts.app')

@section('title','Buses')

@section('content')
  {{-- Botón Crear Bus --}}
  <div class="w-full flex flex-row-reverse p-4 pb-8">
    <a href="{{ route('buses.create') }}"
       class="bg-green-600 p-2 text-white text-sm font-normal rounded-lg shadow hover:bg-green-700 transition"
    >+ Crear Bus</a>
  </div>

  @if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-2 rounded">
      {{ session('success') }}
    </div>
  @endif

  {{-- BOX A: Administración de Buses --}}
  <div class="bg-white shadow-xl rounded-lg overflow-hidden p-6 mb-6 overflow-x-auto">
    <table class="min-w-full table-auto">
      <thead class="bg-white">
        <tr>
          <th colspan="9" class="text-2xl font-bold text-black text-left">
            <div class="flex justify-between items-center w-full">
              <h2>Administración de Buses</h2>
            </div>
          </th>
        </tr>
        <tr>
          <th colspan="7" class="px-6 py-2 bg-white">

          </th>
        </tr>
        <tr class="text-left bg-gray-200 text-black uppercase text-sm leading-normal">
          <th class="px-6 py-3">Código</th>
          <th class="px-6 py-3">Placa</th>
          <th class="px-6 py-3">Propietario</th>
          <th class="px-6 py-3">Tipo</th>
          <th class="px-6 py-3">Asientos 1º Piso</th>
          <th class="px-6 py-3">Asientos 2º Piso</th>
          <th class="px-6 py-3">Tipo Asiento</th>
          <th class="px-6 py-3">Chofer</th>
          <th class="px-6 py-3">Acciones</th>
        </tr>
      </thead>
      <tbody class="text-gray-700 text-sm border border-gray-200">
        @forelse($buses as $bus)
          <tr class="border-b border-gray-200 hover:bg-gray-50">
            <td class="px-6 py-4">{{ $bus->codigo }}</td>
            <td class="px-6 py-4">{{ $bus->placa }}</td>
            <td class="px-6 py-4">{{ $bus->propietario }}</td>
            <td class="px-6 py-4">{{ $bus->tipo_de_bus }}</td>
            <td class="px-6 py-4">{{ $bus->asientos_piso1 }}</td>
            <td class="px-6 py-4">{{ $bus->asientos_piso2 }}</td>
            <td class="px-6 py-4">{{ $bus->tipo_asiento }}</td>
            <td class="px-6 py-4">{{ optional($bus->chofer)->nombre_chofer ?? '—' }}</td>
            <td class="px-6 py-4 space-x-2">
              <a href="{{ route('buses.show', $bus) }}" class="text-indigo-600 hover:underline">Ver</a>
              <a href="{{ route('buses.edit', $bus) }}" class="text-yellow-600 hover:underline">Editar</a>
              <form action="{{ route('buses.destroy', $bus) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit"
                        onclick="return confirm('¿Eliminar este bus?')"
                        class="text-red-600 hover:underline">
                  Eliminar
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="9" class="px-6 py-4 text-center text-gray-500">
              No hay buses registrados.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>

    @if(method_exists($buses, 'links'))
      <div class="mt-4">
        {{ $buses->withQueryString()->links() }}
      </div>
    @endif
  </div>
@endsection
