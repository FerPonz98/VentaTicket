{{-- resources/views/buses/show.blade.php --}}
@extends('layouts.app')

@section('title','Detalles del Bus')

@section('content')
  {{-- Volver al listado --}}
  <a href="{{ route('buses.index') }}"
     class="inline-flex items-center text-indigo-600 hover:text-indigo-800 mb-6">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
      <path fill-rule="evenodd" d="M12.293 16.293a1 1 0 010 1.414l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L8.414 10l5.293 5.293a1 1 0 010 1.414z" clip-rule="evenodd" />
    </svg>
    Volver al listado
  </a>

  <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
    <h2 class="text-3xl font-bold text-gray-900 mb-8">
      Detalles del Bus <span class="text-indigo-600">{{ $bus->codigo }}</span>
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
      <div class="space-y-2">
        <p class="text-sm font-medium text-gray-700">Placa</p>
        <p class="text-lg text-gray-900">{{ $bus->placa }}</p>
      </div>

      <div class="space-y-2">
        <p class="text-sm font-medium text-gray-700">Tipo de Bus</p>
        <p class="text-lg text-gray-900">{{ $bus->tipo_de_bus }}</p>
      </div>

      <div class="space-y-2">
        <p class="text-sm font-medium text-gray-700">Asientos Piso 1</p>
        <p class="text-lg text-gray-900">{{ $bus->asientos_piso1 }}</p>
      </div>

      <div class="space-y-2">
        <p class="text-sm font-medium text-gray-700">Asientos Piso 2</p>
        <p class="text-lg text-gray-900">{{ $bus->asientos_piso2 }}</p>
      </div>

      <div class="space-y-2 col-span-full">
        <p class="text-sm font-medium text-gray-700">Tipo de Asiento</p>
        <p class="text-lg text-gray-900">{{ $bus->tipo_asiento }}</p>
      </div>

      <div class="space-y-2 col-span-full">
        <p class="text-sm font-medium text-gray-700">Características</p>
        <p class="text-lg text-gray-900">
          @if($bus->aire_acondicionado)<span class="inline-block mr-2 px-2 py-1 bg-blue-100 text-blue-800 rounded-full">A/C</span>@endif
          @if($bus->tv)<span class="inline-block mr-2 px-2 py-1 bg-blue-100 text-blue-800 rounded-full">TV</span>@endif
          @if($bus->bano)<span class="inline-block mr-2 px-2 py-1 bg-blue-100 text-blue-800 rounded-full">Baño</span>@endif
          @if($bus->carga_telefono)<span class="inline-block mr-2 px-2 py-1 bg-blue-100 text-blue-800 rounded-full">Carga Teléfono</span>@endif
        </p>
      </div>

      <div class="space-y-2">
        <p class="text-sm font-medium text-gray-700">SOAT</p>
        <p class="text-lg text-gray-900">
          @if($bus->soat)
            <span class="font-semibold">{{ $bus->codigo_soat }}</span> —
            <span>{{ $bus->soat_vencimiento->format('d/m/Y') }}</span>
          @else
            <span class="text-gray-500">No Aplica</span>
          @endif
        </p>
      </div>

      <div class="space-y-2">
        <p class="text-sm font-medium text-gray-700">Revisión Técnica</p>
        <p class="text-lg text-gray-900">
          @if($bus->rev_tecnica)
            {{ $bus->rev_tecnica_vencimiento->format('d/m/Y') }}
          @else
            <span class="text-gray-500">No Aplica</span>
          @endif
        </p>
      </div>

      <div class="space-y-2">
        <p class="text-sm font-medium text-gray-700">Tarjeta de Operación</p>
        <p class="text-lg text-gray-900">
          {{ $bus->tarjeta_operacion_vencimiento
             ? $bus->tarjeta_operacion_vencimiento->format('d/m/Y')
             : '—' }}
        </p>
      </div>

      <div class="space-y-2">
        <p class="text-sm font-medium text-gray-700">Marca</p>
        <p class="text-lg text-gray-900">{{ $bus->marca }}</p>
      </div>

      <div class="space-y-2">
        <p class="text-sm font-medium text-gray-700">Modelo</p>
        <p class="text-lg text-gray-900">{{ $bus->modelo ?? '—' }}</p>
      </div>

      <div class="space-y-2">
        <p class="text-sm font-medium text-gray-700">Chofer</p>
        <p class="text-lg text-gray-900">{{ optional($bus->chofer)->nombre_chofer ?? '—' }}</p>
      </div>
    </div>
  </div>
@endsection
