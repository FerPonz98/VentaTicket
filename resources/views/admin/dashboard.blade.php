@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto mt-8">
    <h2 class="text-3xl font-semibold text-gray-800">Bienvenido al Dashboard</h2>

    <!-- Botones de acción -->
    <div class="mt-8 space-y-4">
        <a href="{{ route('sucursales.create') }}" class="block w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-md shadow-md text-center">
            Crear Nueva Sucursal
        </a>

        <a href="{{ route('descuentos.create') }}" class="block w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-md shadow-md text-center">
            Crear Nuevo Descuento
        </a>
    </div>

    <!-- Sección de Sucursales -->
    <div class="mt-8">
        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Sucursales Registradas</h3>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <ul class="divide-y divide-gray-200">
                @forelse($sucursales as $sucursal)
                    <li class="px-6 py-4 hover:bg-gray-50">
                        <span class="text-gray-800 font-medium">{{ $sucursal->nombre }}</span>
                    </li>
                @empty
                    <li class="px-6 py-4 text-gray-500">No hay sucursales registradas.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="mt-8">
        <h3 class="text-2xl font-semibold text-gray-700 mb-4">Descuentos Registrados</h3>
        <div class="overflow-hidden bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 bg-gray-100">Código de Descuento</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 bg-gray-100">Valor</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 bg-gray-100">Tipo</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 bg-gray-100">Viaje</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 bg-gray-100">fecha de salida </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($descuentos as $descuento)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $descuento->codigo_descuento }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $descuento->valor_descuento }} 
                                @if($descuento->tipo_descuento == 'porcentaje') 
                                    %
                                @else 
                                    Bs 
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ ucfirst($descuento->tipo_descuento) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $descuento->viaje->ruta->origen }} - {{ $descuento->viaje->ruta->destino }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ \Carbon\Carbon::parse($descuento->viaje->fecha_salida)->format('d-m-Y') }}
                            </td>

                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
