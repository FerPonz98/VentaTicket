{{-- resources/views/pasajes/disponibilidad.blade.php --}}
@extends('layouts.app')

@section('title', 'Disponibilidad de Pasajes')

@section('content')
<a href="{{ route('pasajes.index') }}" class="inline-block text-indigo-600 hover:text-indigo-800 underline mb-4">
  &larr; Volver al listado
</a>

<div class="container mx-auto mt-6 max-w-2xl">
  <h2 class="text-3xl font-bold mb-6 text-gray-900">Disponibilidad de Pasajes</h2>
  <div class="bg-white rounded-lg shadow p-6 space-y-6">
    <div class="space-y-4 text-sm">
      <h3 class="text-xl text-black font-semibold">Datos del Viaje</h3>
      <div>
        <p class="font-medium text-gray-700">Ruta</p>
        <p class="text-gray-900">{{ $viaje->ruta->origen }} → {{ $viaje->ruta->destino }}</p>
      </div>
      <div>
        <p class="font-medium text-gray-700">Fecha de salida</p>
        <p class="text-gray-900">{{ \Carbon\Carbon::parse($viaje->fecha_salida)->format('Y-m-d H:i') }}</p>
      </div>
      <div>
        <p class="font-medium text-gray-700">Precio por pasaje</p>
        <p class="text-gray-900">Bs. {{ number_format($viaje->precio, 2) }}</p>
      </div>
      <div>
        <p class="font-medium text-gray-700">Capacidad por piso</p>
        <p class="text-gray-900">Piso 1: {{ $viaje->bus->asientos_piso1 }} asientos</p>
        <p class="text-gray-900">Piso 2: {{ $viaje->bus->asientos_piso2 }} asientos</p>
      </div>
      <div>
        <p class="font-medium text-gray-700">Total / Vendidos / Disponibles</p>
        <div class="flex items-center space-x-2 text-xs">
          <span class="px-2 py-1 bg-gray-200 text-gray-800 rounded">Total: {{ $capacidad }}</span>
          <span class="px-2 py-1 bg-red-100 text-red-800 rounded">Vendidos: {{ $vendidos }}</span>
          <span class="px-2 py-1 bg-green-100 text-green-800 rounded">Disponibles: {{ $restantes }}</span>
        </div>
      </div>
      <div>
        <p class="font-medium text-gray-700">Conductor</p>
        <p class="text-gray-900">
          {{ $viaje->chofer?->nombre ?? $viaje->bus->chofer?->nombre ?? '-' }}
        </p>
      </div>
    </div>

    @php
        if (!function_exists('genLayout')) {
            function genLayout($count, $start = 1) {
                $rows = []; $full = intdiv($count, 4); $rem = $count % 4; $n = $start;
                for ($i = 0; $i < $full; $i++) {
                    $rows[] = [$n++, $n++, 'aisle', $n++, $n++];
                }
                if ($rem) {
                    $row = [];
                    for ($i = 0; $i < $rem; $i++) {
                        $row[] = (string) $n++;
                    }
                    for ($i = $rem; $i < 5; $i++) {
                        $row[] = 'empty';
                    }
                    $rows[] = $row;
                }
                return $rows;
            }
        }
        $asientosPiso1 = $viaje->bus->asientos_piso1;
        $asientosPiso2 = $viaje->bus->asientos_piso2;
        $layout1  = genLayout($asientosPiso1, 1);

        // Calcular el último número del piso 1
        $lastNumPiso1 = $asientosPiso1;
        if (count($layout1)) {
            $last = end($layout1);
            foreach ($last as $cell) {
                if (is_numeric($cell)) {
                    $lastNumPiso1 = (int)$cell;
                }
            }
        }

        $layout2  = $viaje->bus->tipo_de_bus === 'Doble piso'
                    ? genLayout($asientosPiso2, $lastNumPiso1 + 1)
                    : [];
        $ocupados = $viaje->pasajes->pluck('asiento')->map(fn($a) => (int) $a)->toArray();
    @endphp

    <div class="space-y-4">
      <h3 class="text-xl text-black font-semibold">Mapa de Asientos</h3>
      <div>
        <p class="font-medium text-gray-700 mb-1">Piso 1</p>
        @foreach($layout1 as $row)
          <div class="{{ count($row) === 5 ? 'grid grid-cols-5 gap-1 mb-1' : 'flex gap-1 mb-1' }}">
            @foreach($row as $cell)
              @if($cell === 'aisle')
                <div class="w-1"></div>
              @elseif($cell === 'empty')
                <div class="w-5 h-5"></div>
              @else
                <div class="seat {{ in_array((int)$cell, $ocupados) ? 'occupied' : 'available' }}">
                  {{ $cell }}
                </div>
              @endif
            @endforeach
          </div>
        @endforeach
      </div>

      @if(count($layout2))
        <div>
          <p class="font-medium text-gray-700 mb-1">Piso 2</p>
          @foreach($layout2 as $row)
            <div class="{{ count($row) === 5 ? 'grid grid-cols-5 gap-1 mb-1' : 'flex gap-1 mb-1' }}">
              @foreach($row as $cell)
                @if($cell === 'aisle')
                  <div class="w-1"></div>
                @elseif($cell === 'empty')
                  <div class="w-5 h-5"></div>
                @else
                  <div class="seat {{ in_array((int)$cell, $ocupados) ? 'occupied' : 'available' }}">
                    {{ $cell }}
                  </div>
                @endif
              @endforeach
            </div>
          @endforeach
        </div>
      @endif
    </div>

    <div class="flex space-x-4 pt-4">
      <a href="{{ route('pasajes.create', ['viaje_id' => $viaje->id]) }}"
         class="flex-1 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm text-center">
        Vender Pasaje
      </a>
      <form action="{{ route('viajes.cerrar', ['viaje' => $viaje->id]) }}" method="POST" class="flex-1">
        @csrf
        <input type="hidden" name="viaje_id" value="{{ $viaje->id }}">
        <button type="submit"
                class="w-full px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 text-sm">
          Plantilla
        </button>
      </form>
    </div>
  </div>
</div>

{{-- Debug temporal --}}
<pre>{{ var_export($viaje->conductor, true) }}</pre>
<pre>{{ var_export($viaje->bus->conductor ?? null, true) }}</pre>

<style>
  .seat {
    width: 2rem;
    height: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    font-weight: bold;
    border-radius: 0.25rem;
  }
  .seat.available { background: #4ade80; }
  .seat.occupied  { background: #ef4444; color: #fff; }
</style>
@endsection
