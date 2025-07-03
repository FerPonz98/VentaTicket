{{-- resources/views/pasajes/confirmar.blade.php --}}
@extends('layouts.app')

@section('title','Confirmar Venta')

@section('content')
<a href="{{ route('pasajes.create') }}"
   class="inline-block text-indigo-600 hover:text-indigo-800 underline mb-4">
  &larr; Volver 
</a>
<div class="max-w-6xl mx-auto">

  <h2 class="text-3xl font-bold mb-6 text-gray-800">Confirmar Venta de Pasaje</h2>

  @if(empty($datos['asiento']))
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
      <p class="font-semibold">¡Atención!</p>
      <p>Debes seleccionar un asiento antes de continuar.</p>
      <a href="{{ route('pasajes.create', ['viaje_id' => $viaje->id]) }}"
         class="mt-3 inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
        Seleccionar Asiento
      </a>
    </div>
  @else
    <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
      <table class="w-full">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-3 text-left text-gray-600">Asiento</th>
            <th class="px-4 py-3 text-left text-gray-600">CI</th>
            <th class="px-4 py-3 text-left text-gray-600">Edad</th>
            <th class="px-4 py-3 text-left text-gray-600">Nombre</th>
            <th class="px-4 py-3 text-left text-gray-600">Tipo</th>
            <th class="px-4 py-3 text-left text-gray-600">Origen</th>
            <th class="px-4 py-3 text-left text-gray-600">Destino</th>
            <th class="px-4 py-3 text-left text-gray-600">Fecha</th>
            <th class="px-4 py-3 text-left text-gray-600">Pago</th>
            <th class="px-4 py-3 text-left text-gray-600">Precio</th>
          </tr>
        </thead>
        <tbody>
          @php
            $paradas = $viaje->ruta->paradas;
            $precioBase = $viaje->precio; // Valor por defecto

            // Busca el precio de la parada seleccionada
            if (!empty($datos['destino']) && is_array($paradas)) {
                foreach ($paradas as $parada) {
                    if (isset($parada['nombre']) && $parada['nombre'] === $datos['destino']) {
                        $precioBase = $parada['precio_pasaje'];
                        break;
                    }
                }
            }

            // Aplica descuentos según el tipo de pasajero
            switch($datos['tipo_pasajero']) {
                case 'tercera_edad':
                    $precio = max(0, $precioBase - $viaje->ruta->descuento_3ra_edad);
                    break;
                case 'menor':
                    $precio = max(0, $precioBase * 0.5);
                    break;
                case 'cortesia':
                    $precio = $viaje->ruta->precio_cortesia;
                    break;
                case 'desc':
                    $precio = max(0, $precioBase - $viaje->ruta->descuento_2);
                    break;
                case 'discapacidad':
                    $precio = isset($viaje->ruta->descuento_discapacidad)
                        ? max(0, $precioBase - $viaje->ruta->descuento_discapacidad)
                        : $precioBase;
                    break;
                default:
                    $precio = $precioBase;
            }
          @endphp
          <tr class="border-t">
            <td class="px-4 py-3 text-gray-800">{{ $datos['asiento'] }}</td>
            <td class="px-4 py-3 text-gray-800">{{ $datos['ci_usuario'] }}</td>
            <td class="px-4 py-3 text-gray-800">{{ $datos['edad'] }}</td>
            <td class="px-4 py-3 text-gray-800">{{ $datos['nombre_completo'] }}</td>
            <td class="px-4 py-3 text-gray-800">{{ ucfirst($datos['tipo_pasajero']) }}</td>
            <td class="px-4 py-3 text-gray-800">{{ $viaje->ruta->origen }}</td>
            <td class="px-4 py-3 text-gray-800">{{ $datos['destino'] }}</td>
            <td class="px-4 py-3 text-gray-800">
              {{ \Carbon\Carbon::parse($viaje->fecha_salida)->format('Y-m-d H:i') }}
            </td>
            <td class="px-4 py-3 text-gray-800">{{ ucfirst($datos['forma_pago']) }}</td>
            <td class="px-4 py-3 text-gray-800">Bs {{ number_format($precio,2) }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="flex flex-col items-center gap-4 mt-6">
      <button
        type="button"
        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg shadow"
        onclick="window.open('{{ route('pasajes.finalizar') }}', '_blank');">
        Generar PDF e Imprimir
      </button>
      <a href="{{ route('pasajes.index') }}"
         class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-6 py-3 rounded-lg shadow text-center">
        &larr; Volver al listado de pasajes
      </a>
    </div>
  @endif

</div>
@endsection
