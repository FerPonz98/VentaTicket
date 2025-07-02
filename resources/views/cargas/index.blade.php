{{-- resources/views/carga/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Cargas')

@section('content')
<div class="container mx-auto space-y-6">

  <div class="w-full flex flex-row-reverse p-4">
    <a href="{{ route('carga.create') }}"
       class="bg-green-600 p-2 text-white text-sm font-normal rounded-lg shadow hover:bg-green-700 transition">
      Nueva Carga
    </a>
  </div>

  {{-- Tabla Cargas --}}
  <div class="bg-white shadow-xl rounded-lg overflow-hidden p-6">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold text-black">Gestionar Cargas</h2>
      <form method="GET" action="{{ route('carga.index') }}" class="flex items-center space-x-2 w-full max-w-md">
        <input
          name="carga_id"
          placeholder="Buscar carga por ID"
          value="{{ request('carga_id') }}"
          class="border w-full p-2 border-gray-300 text-sm placeholder-gray-500 font-light rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
        />
        <button
          type="submit"
          class="bg-indigo-600 p-2 text-white text-sm font-semibold rounded-lg shadow hover:bg-indigo-700 transition">
          Buscar
        </button>
      </form>
    </div>

    <table class="min-w-full table-auto">
      <thead class="bg-gray-200 text-black uppercase text-sm leading-normal">
        <tr>
          <th class="px-6 py-3 text-center">ID</th>
          <th class="px-6 py-3 text-center">Nro Guía</th>
          <th class="px-6 py-3 text-center">Estado</th>
          <th class="px-6 py-3 text-center">Origen</th>
          <th class="px-6 py-3 text-center">Destino</th>
          <th class="px-6 py-3 text-center">Remitente</th>
          <th class="px-6 py-3 text-center">Peso Total</th>
          <th class="px-6 py-3 text-center">Acciones</th>
        </tr>
      </thead>
      <tbody class="text-gray-700 text-sm border border-gray-200">
        @forelse($cargas as $carga)
          <tr class="border-b border-gray-200 hover:bg-gray-50">
            <td class="px-6 py-4 text-center">{{ $carga->id }}</td>
            <td class="px-6 py-4 text-center">{{ $carga->nro_guia }}</td>
            <td class="px-6 py-4 text-center">{{ ucfirst($carga->estado) }}</td>
            <td class="px-6 py-4 text-center">{{ $carga->origen }}</td>
            <td class="px-6 py-4 text-center">{{ $carga->destino }}</td>
            <td class="px-6 py-4 text-center">{{ $carga->remitente_nombre }}</td>
            <td class="px-14 py-4 text-center">{{ $carga->detalles->sum('peso') }} kg</td>
            <td class="px-6 py-4 space-x-2 text-center">
              <a href="{{ route('carga.edit', $carga) }}" class="text-yellow-600 hover:underline">Editar</a>
              <a href="{{ route('carga.pdf', $carga) }}" target="_blank" class="text-green-600 hover:underline">PDF</a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" class="px-6 py-4 text-center text-gray-500">
              No hay cargas registradas.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <div class="mt-4">
      {{ $cargas->withQueryString()->links() }}
    </div>
  </div>

</div>
@endsection
