{{-- resources/views/choferes/index.blade.php --}}
@extends('layouts.app')
@section('title','Choferes')
@section('content')
  {{-- Botón Crear Chofer --}}
  <div class="w-full flex flex-row-reverse p-4 pb-8">
    <a href="{{ route('choferes.create') }}"
       class="bg-green-600 p-2 text-white text-sm font-normal rounded-lg shadow hover:bg-green-700 transition"
    >+ Crear Chofer</a>
  </div>

  {{-- BOX A: Listado de Choferes --}}
  <div class="bg-white shadow-xl rounded-lg overflow-hidden p-6 mb-6">
    <table class="min-w-full table-auto">
      <thead class="bg-white">
        <tr>
          <th colspan="7" class="text-2xl font-bold text-black text-left">
            <div class="flex justify-between items-center w-full">
              <h2>Administración de Choferes</h2>
            </div>
          </th>
        </tr>
        <tr>
          <th colspan="7" class="px-6 py-2 bg-white">

          </th>
        </tr>
        <tr class="text-left bg-gray-200 text-black uppercase text-sm leading-normal">
          <th class="px-6 py-3">N°</th>
          <th class="px-6 py-3">Bus</th>
          <th class="px-6 py-3">Chofer</th>
          <th class="px-6 py-3">CI</th> 
          <th class="px-6 py-3">Licencia</th>
          <th class="px-6 py-3">Venc. Licencia</th>
          <th class="px-6 py-3">Acciones</th>
        </tr>
      </thead>
      <tbody class="text-gray-700 text-sm border border-gray-200">
        @forelse($choferes as $chofer)
          <tr class="border-b border-gray-200 hover:bg-gray-50">
            <td class="px-6 py-4">{{ $chofer->numero }}</td>
            <td class="px-6 py-4">{{ $chofer->bus_codigo }}</td>
            <td class="px-6 py-4">{{ $chofer->nombre_chofer }}</td>
            <td class="px-6 py-4">{{ $chofer->CI }}</td> 
            <td class="px-6 py-4">{{ $chofer->licencia }}</td>
            <td class="px-6 py-4">
              {{ \Carbon\Carbon::parse($chofer->vencimiento_licencia)->format('d/m/Y') }}
            </td>
            <td class="px-6 py-4 space-x-4">
              <a href="{{ route('choferes.show', $chofer) }}" class="text-indigo-600 hover:underline">Ver</a>
              <a href="{{ route('choferes.edit', $chofer) }}" class="text-yellow-600 hover:underline">Editar</a>
              @if($chofer->CI != Auth::user()->ci_usuario)
                <form action="{{ route('choferes.destroy', $chofer) }}" method="POST" class="inline">
                  @csrf @method('DELETE')
                  <button type="submit" onclick="return confirm('¿Eliminar este chofer?')" class="text-red-600 hover:underline">Eliminar</button>
                </form>
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
              No hay choferes registrados.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>

    {{-- Si tus choferes están paginados --}}
    @if(method_exists($choferes, 'links'))
      <div class="mt-4">
        {{ $choferes->withQueryString()->links() }}
      </div>
    @endif
  </div>
@endsection
