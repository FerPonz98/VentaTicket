{{-- resources/views/buses/show.blade.php --}}
@extends('layouts.app')

@section('title','Detalles del Bus')

@section('content')
  <a href="{{ route('buses.index') }}"
     class="inline-flex items-center text-indigo-600 hover:text-indigo-800 mb-6">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
      <path fill-rule="evenodd" d="M12.293 16.293a1 1 0 010 1.414l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L8.414 10l5.293 5.293a1 1 0 010 1.414z" clip-rule="evenodd" />
    </svg>
    Volver al listado
  </a>
  @php
    // Función para generar filas de asientos
    function genLayout(int $count): array {
      $rows = [];
      $full = intdiv($count, 4);
      $rem  = $count % 4;
      $n = 1;
      for ($i = 0; $i < $full; $i++) {
        $rows[] = [ (string)$n++, (string)$n++, 'aisle', (string)$n++, (string)$n++ ];
      }
      if ($rem) {
        $row = [];
        for ($i = 0; $i < $rem; $i++) {
          $row[] = (string)$n++;
        }
        for ($i = $rem; $i < 5; $i++) {
          $row[] = 'empty';
        }
        $rows[] = $row;
      }
      return $rows;
    }

    // Carga automática o genera según modelo
    $layout1 = is_array($bus->layout_piso1) && count($bus->layout_piso1)
               ? $bus->layout_piso1
               : genLayout($bus->asientos_piso1);

    $has2 = $bus->tipo_de_bus === 'Doble piso';
    $layout2 = $has2
               ? (is_array($bus->layout_piso2) && count($bus->layout_piso2)
                  ? $bus->layout_piso2
                  : genLayout($bus->asientos_piso2))
               : [];
  @endphp


  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">
    {{-- Columna izquierda: Detalles --}}
    <div>
      <div class="bg-white p-8 rounded-2xl shadow-lg">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">
          Detalles del Bus <span class="text-indigo-600">{{ $bus->codigo }}</span>
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
          {{-- Propietario --}}
          <div class="space-y-2">
            <p class="text-sm font-medium text-gray-700">Propietario</p>
            <p class="text-lg text-gray-900">{{ $bus->propietario ?? '—' }}</p>
          </div>

          {{-- Placa --}}
          <div class="space-y-2">
            <p class="text-sm font-medium text-gray-700">Placa</p>
            <p class="text-lg text-gray-900">{{ $bus->placa }}</p>
          </div>

          {{-- Tipo de Bus --}}
          <div class="space-y-2">
            <p class="text-sm font-medium text-gray-700">Tipo de Bus</p>
            <p class="text-lg text-gray-900">{{ $bus->tipo_de_bus }}</p>
          </div>

          {{-- Tipo de Asiento (ahora segunda columna, misma fila que Tipo de Bus) --}}
          <div class="space-y-2">
            <p class="text-sm font-medium text-gray-700">Tipo de Asiento</p>
            <p class="text-lg text-gray-900">{{ $bus->tipo_asiento }}</p>
          </div>

          {{-- Asientos Piso 1 --}}
          <div class="space-y-2">
            <p class="text-sm font-medium text-gray-700">Asientos Piso 1</p>
            <p class="text-lg text-gray-900">{{ $bus->asientos_piso1 }}</p>
          </div>

          {{-- Asientos Piso 2 (misma fila que Piso 1) --}}
          <div class="space-y-2">
            <p class="text-sm font-medium text-gray-700">Asientos Piso 2</p>
            <p class="text-lg text-gray-900">{{ $bus->asientos_piso2 }}</p>
          </div>

          {{-- Características --}}
          <div class="space-y-2 col-span-full">
            <p class="text-sm font-medium text-gray-700">Características</p>
            <p class="text-lg text-gray-900">
              @if($bus->aire_acondicionado)<span class="inline-block mr-2 px-2 py-1 bg-blue-100 text-blue-800 rounded-full">A/C</span>@endif
              @if($bus->tv)<span class="inline-block mr-2 px-2 py-1 bg-blue-100 text-blue-800 rounded-full">TV</span>@endif
              @if($bus->bano)<span class="inline-block mr-2 px-2 py-1 bg-blue-100 text-blue-800 rounded-full">Baño</span>@endif
              @if($bus->carga_telefono)<span class="inline-block mr-2 px-2 py-1 bg-blue-100 text-blue-800 rounded-full">Carga Teléfono</span>@endif
              @if($bus->rev_tecnica)
              <span class="inline-block mr-2 px-2 py-1 bg-green-100 text-green-800 rounded-full">Rev. Técnica</span>
              @else
                <span class="inline-block mr-2 px-2 py-1 bg-red-100 text-red-800 rounded-full">Sin Rev. Técnica</span>
              @endif
              @if($bus->soat)
                <span class="inline-block mr-2 px-2 py-1 bg-green-100 text-green-800 rounded-full">SOAT</span>
              @else
                <span class="inline-block mr-2 px-2 py-1 bg-red-100 text-red-800 rounded-full">Sin SOAT</span>
              @endif
            </p>
          </div>

          {{-- SOAT --}}
          <div class="space-y-2">
            <p class="text-sm font-medium text-gray-700">SOAT</p>
            <p class="text-lg text-gray-900">
              @if($bus->soat)
                @if($bus->codigo_soat)
                  <span class="font-semibold">{{ $bus->codigo_soat }}</span>
                @else
                  <span class="text-red-600 font-semibold">¡Falta ingresar el código SOAT!</span>
                @endif
              @else
                <span class="text-gray-500">No Aplica</span>
              @endif
            </p>
          </div>

          {{-- SOAT anterior --}}
          <div class="space-y-2">
            <p class="text-sm font-medium text-gray-700">SOAT Anterior</p>
            <p class="text-lg text-gray-900">
              {{ $bus->soat_old ?? '—' }}
            </p>
          </div>

          {{-- Tarjeta de Operación --}}
          <div class="space-y-2">
            <p class="text-sm font-medium text-gray-700">Tarjeta de Operación</p>
            <p class="text-lg text-gray-900">
              {{ $bus->tarjeta_operacion_vencimiento
                 ? $bus->tarjeta_operacion_vencimiento->format('d/m/Y')
                 : '—' }}
            </p>
          </div>

          {{-- Marca --}}
          <div class="space-y-2">
            <p class="text-sm font-medium text-gray-700">Marca</p>
            <p class="text-lg text-gray-900">{{ $bus->marca }}</p>
          </div>

          {{-- Modelo --}}
          <div class="space-y-2">
            <p class="text-sm font-medium text-gray-700">Modelo</p>
            <p class="text-lg text-gray-900">{{ $bus->modelo ?? '—' }}</p>
          </div>

          {{-- Chofer Principal --}}
          <div class="space-y-2">
            <p class="text-sm font-medium text-gray-700">Chofer Principal</p>
            <p class="text-lg text-gray-900">{{ optional($bus->chofer)->nombre_chofer ?? '—' }}</p>
          </div>
          {{-- Chofer secundario --}}
          <div class="space-y-2">
            <p class="text-sm font-medium text-gray-700">Chofer secundario</p>
            <p class="text-lg text-gray-900">{{ optional($bus->chofer2)->nombre_chofer ?? '—' }}</p>
          </div>
        </div>
      </div>
    </div>

    {{-- Derecha: visualización de asientos --}}
    <div>
      <div class="bg-white p-6 rounded-2xl shadow-lg">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Asientos del Bus</h3>

        {{-- Piso 1 --}}
        <div class="mb-6">
          <h4 class="font-semibold text-gray-700 mb-2">Piso 1</h4>
          @foreach($layout1 as $row)
            <div class="{{ count($row) === 5 ? 'grid grid-cols-5 gap-2 mb-1' : 'flex gap-2 mb-1' }}">
              @foreach($row as $cell)
                @switch($cell)
                  @case('aisle')
                    <span class="inline-block w-8 h-8 bg-gray-200 rounded"></span>
                    @break
                  @case('entry')
                    <span class="inline-block w-8 h-8 border border-gray-400 rounded flex items-center justify-center text-black">&#8594;</span>
                    @break
                  @case('exit')
                    <span class="inline-block w-8 h-8 border border-gray-400 rounded flex items-center justify-center text-black">&#8592;</span>
                    @break
                  @case('empty')
                    <span class="inline-block w-8 h-8"></span>
                    @break
                  @default
                    <span class="inline-block w-8 h-8 border border-gray-400 rounded 
                                 flex items-center justify-center font-bold text-black
                                 {{ in_array((int)$cell, collect($bus->pasajes)->pluck('asiento')->map(fn($a)=>(int)$a)->toArray()) 
                                    ? 'bg-red-200 text-red-800' 
                                    : '' }}">
                      {{ $cell }}
                    </span>
                @endswitch
              @endforeach
            </div>
          @endforeach
        </div>

        @if($has2)
        {{-- Piso 2 --}}
        <div>
          <h4 class="font-semibold text-gray-700 mb-2">Piso 2</h4>
          @foreach($layout2 as $row)
            <div class="{{ count($row) === 5 ? 'grid grid-cols-5 gap-2 mb-1' : 'flex gap-2 mb-1' }}">
              @foreach($row as $cell)
                @switch($cell)
                  @case('aisle')
                    <span class="inline-block w-8 h-8 bg-gray-200 rounded"></span>
                    @break
                  @case('empty')
                    <span class="inline-block w-8 h-8"></span>
                    @break
                  @default
                    <span class="inline-block w-8 h-8 border border-gray-400 rounded 
                                 flex items-center justify-center font-bold text-black
                                 {{ in_array((int)$cell, collect($bus->pasajes)->pluck('asiento')->map(fn($a)=>(int)$a)->toArray()) 
                                    ? 'bg-red-200 text-red-800' 
                                    : '' }}">
                      {{ $cell }}
                    </span>
                @endswitch
              @endforeach
            </div>
          @endforeach
        </div>
        @endif

      </div>
    </div>
  </div>
@endsection