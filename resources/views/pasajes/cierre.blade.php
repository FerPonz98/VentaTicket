@extends('layouts.app')

@section('title','Cierre de Viaje')

@section('content')
<div class="max-w-md mx-auto mt-8 space-y-6">
  <h2 class="text-2xl font-bold text-gray-800">
    @if($viaje)
      Opciones para Viaje #{{ $viaje->id }}
    @else
      Selecciona un viaje
    @endif
  </h2>

  @if(session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="bg-red-100 text-red-800 p-3 rounded">{{ session('error') }}</div>
  @endif

  @if($viaje)
    <div class="bg-white p-4 rounded shadow space-y-2">
      <p><strong>Ruta:</strong> {{ $viaje->ruta->origen }} → {{ $viaje->ruta->destino }}</p>
      <p><strong>Bus:</strong> {{ $viaje->bus->placa }}</p>
      <p><strong>Salida:</strong> {{ $viaje->fecha_salida->format('Y-m-d H:i') }}</p>
      <p><strong>Pasajes vendidos:</strong> Bs {{ number_format($viaje->pasajes->sum('precio'),2) }}</p>
      <p><strong>Carga pagada:</strong> Bs {{ number_format($viaje->cargas->where('estado_pago','pagado')->sum('monto_total'),2) }}</p>
      <p><strong>Carga por pagar:</strong> Bs {{ number_format($viaje->cargas->where('estado_pago','por_pagar')->sum('monto_total'),2) }}</p>
      <p><strong>Encomienda pagada:</strong> Bs {{ number_format($viaje->encomiendas->where('estado_pago','pagado')->sum('total'),2) }}</p>
      <p><strong>Encomienda por pagar:</strong> Bs {{ number_format($viaje->encomiendas->where('estado_pago','por_pagar')->sum('total'),2) }}</p>
      @php
        $subtotal  = $viaje->pasajes->sum('precio')
                   + $viaje->cargas->sum('monto_total')
                   + $viaje->encomiendas->sum('total');
        $retenido  = $subtotal > 500 ? 200 : 0;
        $totalFinal = $subtotal - $retenido;
      @endphp
      <p><strong>Subtotal:</strong> Bs {{ number_format($subtotal,2) }}</p>
      <p><strong>Retención:</strong> Bs {{ number_format($retenido,2) }}</p>
      <p><strong>Total final:</strong> Bs {{ number_format($totalFinal,2) }}</p>
    </div>

    @unless($viaje->cerrado)
      <form action="{{ route('viajes.cerrar', $viaje) }}" method="POST" class="space-y-2">
        @csrf
        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg font-semibold">
          Cerrar este viaje
        </button>
      </form>
      <a href="{{ route('viajes.plantilla', $viaje) }}" target="_blank"
         class="w-full block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold">
        Abrir resumen en nueva pestaña
      </a>
    @else
      <div class="bg-yellow-100 text-yellow-800 p-3 rounded text-center">
        Este viaje ya está <strong>cerrado</strong>.
      </div>
      <form action="{{ route('viajes.cerrar', $viaje) }}" method="POST">
        @csrf
        <input type="hidden" name="_method" value="PATCH">
        <input type="hidden" name="cerrado" value="0">
        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-semibold">
          Reabrir este viaje
        </button>
      </form>
    @endunless
  @endif

  <a href="{{ route('pasajes.index') }}"
     class="w-full block text-center bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 rounded-lg font-semibold">
    Finalizar / Volver al listado de pasajes
  </a>
</div>
@endsection
