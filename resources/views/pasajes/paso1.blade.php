@extends('layouts.app')

@section('title','Paso 1: Opciones de Viaje')

@section('content')
<div class="max-w-md mx-auto mt-8 space-y-6">
  <h2 class="text-2xl font-bold text-gray-800">
    @if($viaje)
      Opciones para Viaje #{{ $viaje->id }}
    @else
      Selecciona un viaje
    @endif
  </h2>

  {{-- Mensajes flash --}}
  @if(session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="bg-red-100 text-red-800 p-3 rounded">{{ session('error') }}</div>
  @endif

  @if($viaje)
    {{-- Si el viaje NO está cerrado, mostramos el botón para cerrarlo --}}
    @unless($viaje->cerrado)
      <form action="{{ route('viajes.cerrar', $viaje) }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="cerrado" value="1">
        <button type="submit"
                class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg font-semibold">
          Cerrar este viaje
        </button>
        {{-- Descargar plantilla --}}
        <a href="{{ route('viajes.plantilla', $viaje) }}"
           target="_blank"
           class="w-full block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold">
          Descargar plantilla de impresión
        </a>
      </form>
    @else
      {{-- Si el viaje ya está cerrado, mostramos botones de descarga y re-apertura --}}
      <div class="space-y-4">
        <div class="bg-yellow-100 text-yellow-800 p-3 rounded text-center">
          Este viaje ya está <strong>cerrado</strong>.
        </div>



        {{-- Reabrir viaje --}}
        <form action="{{ route('viajes.cerrar', $viaje) }}" method="POST">
          @csrf
          {{-- para reabrir, enviamos cerrado = false --}}
          <input type="hidden" name="_method" value="PATCH">
          <input type="hidden" name="cerrado" value="0">
          <button type="submit"
                  class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-semibold">
            Reabrir este viaje
          </button>
        </form>
      </div>
    @endunless
  @endif

  {{-- Siempre mostramos este --}}
  <a href="{{ route('pasajes.index') }}"
     class="w-full block text-center bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 rounded-lg font-semibold">
    Finalizar / Volver al listado de pasajes
  </a>
</div>
@endsection
