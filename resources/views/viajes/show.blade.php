{{-- resources/views/viajes/show.blade.php --}}
@extends('layouts.app')

@section('title','Detalle de Viaje')

@section('content')
  <a href="{{ route('viajes.index') }}"
     class="inline-block text-indigo-600 hover:text-indigo-800 underline mb-4">
    &larr; Volver al listado de viajes
  </a>

  <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Detalle de Viaje</h2>

    {{-- Información del Viaje --}}
    <div class="grid grid-cols-2 gap-4 mb-8">
      <div>
        <span class="font-medium text-gray-700">Bus:</span>
        <span class="text-gray-900">{{ $viaje->bus->codigo ?? '—' }}</span>
      </div>
      <div>
        <span class="font-medium text-gray-700">Ruta:</span>
        <span class="text-gray-900">{{ $viaje->ruta->origen }} &rarr; {{ $viaje->ruta->destino }}</span>
      </div>
      <div>
        <span class="font-medium text-gray-700">Fecha de Salida:</span>
        <span class="text-gray-900">{{ \Carbon\Carbon::parse($viaje->fecha_salida)->format('d/m/Y H:i') }}</span>
      </div>
  
    </div>

    {{-- Tarifas de la Ruta Asociada --}}
    @php $ruta = $viaje->ruta; @endphp
    <h3 class="text-lg font-medium text-black mb-4">Tarifas de la Ruta Asociada</h3>
    <div class="grid grid-cols-2 gap-4 mb-8">
      <div>
        <span class="font-medium text-gray-700">Precio Bus Normal:</span>
        <span class="text-gray-900">Bs {{ number_format($viaje->precio,2) }}</span>
      </div>
      <div>
        <span class="font-medium text-gray-700">Recargo Un Piso Semicama:</span>
        <span class="text-gray-900">Bs {{ number_format($ruta->recargo_bus_1piso_ac,2) }}</span>
      </div>
      <div>
        <span class="font-medium text-gray-700">Recargo Doble Semicama:</span>
        <span class="text-gray-900">Bs {{ number_format($ruta->recargo_bus_doble_piso,2) }}</span>
      </div>
      <div>
        <span class="font-medium text-gray-700">Recargo Semicama:</span>
        <span class="text-gray-900">Bs {{ number_format($ruta->recargo_semicama ?? 0,2) }}</span>
      </div>
      <div>
        <span class="font-medium text-gray-700">Descuento 3ra Edad:</span>
        <span class="text-gray-900">Bs {{ number_format($ruta->descuento_3ra_edad,2) }}</span>
      </div>
      <div>
        <span class="font-medium text-gray-700">Precio Cortesía:</span>
        <span class="text-gray-900">Bs {{ number_format($ruta->precio_cortesia,2) }}</span>
      </div>
      <div>
        <span class="font-medium text-gray-700">Descuento Discapacidad:</span>
        <span class="text-gray-900">Bs {{ number_format($ruta->descuento_discapacidad,2) }}</span>
      </div>
      <div>
        <span class="font-medium text-gray-700">Descuento 2:</span>
        <span class="text-gray-900">Bs {{ number_format($ruta->descuento_2 ?? 0,2) }}</span>
      </div>
      <div>
        <span class="font-medium text-gray-700">Descuento 3:</span>
        <span class="text-gray-900">Bs {{ number_format($ruta->descuento_3 ?? 0,2) }}</span>
      </div>
      <div>
        <span class="font-medium text-gray-700">Precio Encomienda:</span>
        <span class="text-gray-900">Bs {{ number_format($ruta->precio_encomienda,2) }}</span>
      </div>
      <div>
        <span class="font-medium text-gray-700">Precio Carga:</span>
        <span class="text-gray-900">Bs {{ number_format($ruta->precio_carga,2) }}</span>
      </div>
    </div>

    {{-- Paradas y Tarifas por Tramo --}}
    <h3 class="text-lg font-medium text-black mb-2">Paradas y Tarifas por Tramo</h3>
    @php $paradas = $ruta->paradas ?? []; @endphp
    @if(count($paradas))
      <div class="overflow-x-auto">
        <table class="w-full border-collapse border">
          <thead>
            <tr class="bg-gray-100">
              <th class="p-2 border text-center text-gray-900">#</th>
              <th class="p-2 border text-gray-700">Parada</th>
              <th class="p-2 border text-gray-700">Hora</th>
              <th class="p-2 border text-gray-700">Pasaje (Bs.)</th>
              <th class="p-2 border text-gray-700">Encomienda (Bs.)</th>
              <th class="p-2 border text-gray-700">Carga (Bs.)</th>
            </tr>
          </thead>
          <tbody class="bg-white">
            @foreach($paradas as $p)
              <tr class="border-t hover:bg-gray-50">
                <td class="p-2 border text-center text-gray-900">{{ $p['numero'] }}</td>
                <td class="p-2 border text-gray-900">{{ $p['nombre'] }}</span></td>
                <td class="p-2 border text-gray-900">
                  @if(!empty($p['hora']))
                    {{ \Carbon\Carbon::createFromFormat('H:i', $p['hora'])->format('H:i') }}
                  @else
                    —
                  @endif
                </td>
                <td class="p-2 border text-gray-900">{{ number_format($p['precio_pasaje'] ?? 0,2) }}</td>
                <td class="p-2 border text-gray-900">{{ number_format($p['precio_encomienda_parada'] ?? 0,2) }}</td>
                <td class="p-2 border text-gray-900">{{ number_format($p['precio_carga_parada'] ?? 0,2) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @else
      <p class="text-gray-600 italic">Esta ruta no tiene paradas configuradas.</p>
    @endif

  </div>
@endsection
