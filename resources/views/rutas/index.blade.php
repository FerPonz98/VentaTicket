{{-- resources/views/rutas/index.blade.php --}}
@extends('layouts.app')

@section('title','Administrar Rutas')

@section('content')
  {{-- Botón Nueva Ruta --}}
  <div class="w-full flex flex-row-reverse p-4 pb-8">
    <a href="{{ route('rutas.create') }}"
       class="bg-green-600 p-2 text-white text-sm font-normal rounded-lg shadow hover:bg-green-700 transition"
    >+ Nueva Ruta</a>
  </div>

  {{-- BOX A: Rutas --}}
  <div class="bg-white shadow-xl rounded-lg overflow-hidden p-6 mb-6">
    <table class="min-w-full table-auto">
      <thead class="bg-white">
        <tr>
          <th colspan="5" class="text-2xl font-bold text-black text-left">
            <div class="flex justify-between items-center w-full">
              <h2>Rutas</h2>
            </div>
          </th>
        </tr>
        <tr>
          <th colspan="7" class="px-6 py-2 bg-white">

          </th>
        </tr>
        <tr class="text-left bg-gray-200 text-black uppercase text-sm leading-normal">
          <th class="px-6 py-3">ID</th>
          <th class="px-6 py-3">Origen</th>
          <th class="px-6 py-3">Destino</th>
          <th class="px-6 py-3">Paradas</th>
          <th class="px-6 py-3">Acciones</th>
        </tr>
      </thead>
      <tbody class="text-gray-700 text-sm border border-gray-200">
        @forelse($rutas as $ruta)
          <tr class="border-b border-gray-200 hover:bg-gray-50">
            <td class="px-6 py-4">{{ $ruta->id }}</td>
            <td class="px-6 py-4">{{ $ruta->origen }}</td>
            <td class="px-6 py-4">{{ $ruta->destino }}</td>
            <td class="px-6 py-4">
              @php $paradas = $ruta->paradas ?? []; @endphp
              @if(count($paradas))
                <ul class="list-disc ml-4 space-y-1">
                  @foreach($paradas as $p)
                    <li class="text-gray-900">
                      <strong>{{ $p['numero'] }}.</strong> {{ $p['nombre'] }}
                      — Bs {{ number_format($p['precio_pasaje'] ?? 0, 2) }}
                      @isset($p['precio_encomienda_parada']) | Encomienda: Bs {{ number_format($p['precio_encomienda_parada'], 2) }} @endisset
                      @isset($p['precio_carga_parada']) | Carga: Bs {{ number_format($p['precio_carga_parada'], 2) }} @endisset
                      @if(!empty($p['hora'])) | Hora: {{ \Carbon\Carbon::createFromFormat('H:i', $p['hora'])->format('H:i') }} @endif
                    </li>
                  @endforeach
                </ul>
              @else
                <span class="text-gray-500">Sin paradas</span>
              @endif
            </td>
            <td class="px-6 py-4 space-x-2">
              <a href="{{ route('rutas.show', $ruta) }}" class="text-indigo-600 hover:underline">Ver</a>
              <a href="{{ route('rutas.edit', $ruta) }}" class="text-yellow-600 hover:underline">Editar</a>
              <form action="{{ route('rutas.destroy', $ruta) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button onclick="return confirm('¿Eliminar esta ruta?')" class="text-red-600 hover:underline">Borrar</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay rutas.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    @if(method_exists($rutas, 'links'))
      <div class="mt-4">
        {{ $rutas->withQueryString()->links() }}
      </div>
    @endif
  </div>
@endsection
