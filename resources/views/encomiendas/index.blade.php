{{-- resources/views/encomiendas/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Encomiendas')

@section('content')
<div class="container mx-auto space-y-6">

  <div class="w-full flex flex-row-reverse p-4">
    <a href="{{ route('encomiendas.create') }}"
       class="bg-green-600 p-2 text-white text-sm font-normal rounded-lg shadow hover:bg-green-700 transition">
      Nueva Encomienda
    </a>
  </div>

  {{-- Tabla Encomiendas --}}
  <div class="bg-white shadow-xl rounded-lg overflow-hidden p-6">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold text-black">Gestionar Encomiendas</h2>
      <form method="GET" action="{{ route('encomiendas.index') }}" class="flex items-center space-x-2 w-full max-w-md">
        <input
          name="encomienda_id"
          placeholder="Buscar por ID"
          value="{{ request('encomienda_id') }}"
          class="border w-full p-2 border-gray-300 text-sm placeholder-gray-500 font-light rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
        />
        <button
          type="submit"
          class="bg-indigo-600 p-2 text-white text-sm font-semibold rounded-lg shadow hover:bg-indigo-700 transition"
        >
          Buscar
        </button>
      </form>
    </div>

    <table class="min-w-full table-auto">
      <thead class="bg-gray-200 text-black uppercase text-sm leading-normal">
        <tr>
          <th class="px-6 py-3">ID</th>
          <th class="px-6 py-3 text-center">Bus</th>
          <th class="px-6 py-3">Remitente Nombre</th>
          <th class="px-6 py-3">Remitente CI</th>
          <th class="px-6 py-3">Remitente Teléfono</th>
          <th class="px-6 py-3">Consignatario Nombre</th>
          <th class="px-6 py-3">Consignatario CI</th>
          <th class="px-6 py-3">Consignatario Teléfono</th>
          <th class="px-6 py-3">Peso</th>
          <th class="px-6 py-3">Acciones</th>
        </tr>
      </thead>
      <tbody class="text-gray-700 text-sm border border-gray-200">
        @forelse($encomiendas as $item)
          <tr class="border-b border-gray-200 hover:bg-gray-50">
            <td class="px-6 py-4">{{ $item->id }}</td>
            <td class="px-6 py-4 text-center">{{ $item->viaje->bus->codigo }}</td>
            <td class="px-6 py-4">{{ $item->remitente_nombre }}</td>
            <td class="px-6 py-4">{{ $item->remitente_id }}</td>
            <td class="px-6 py-4">{{ $item->remitente_telefono }}</td>
            <td class="px-6 py-4">{{ $item->consignatario_nombre }}</td>
            <td class="px-6 py-4">{{ $item->consignatario_ci }}</td>
            <td class="px-6 py-4">{{ $item->consignatario_telefono }}</td>
            <td class="px-6 py-4">{{ $item->items->sum('peso') }} kg</td>
            <td class="px-6 py-4 space-x-2">
              <a href="{{ route('encomiendas.edit', $item) }}" class="text-yellow-600 hover:underline">Editar</a>
              <a href="{{ route('encomiendas.pdf', $item) }}"target="_blank"rel="noopener noreferrer"class="text-green-600 hover:underline">PDF</a>

              </form>
            </td>
          </tr>


          
        @empty
          <tr>
            <td colspan="10" class="px-6 py-4 text-center text-gray-500">No hay encomiendas registradas.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <div class="mt-4">
      {{ $encomiendas->withQueryString()->links() }}
    </div>
  </div>

</div>
@endsection
