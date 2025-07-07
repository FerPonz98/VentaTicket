@extends('layouts.app')

@section('title', 'Detalles del Turno')

@section('content')
<div class="container mx-auto mt-8">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-4">
        <h2 class="text-2xl font-semibold text-gray-800">Turno #{{ $turno->id }}</h2>
        <p class="text-gray-600">Tipo: {{ ucfirst($turno->tipo) }}</p>
        <p class="text-gray-600">Fecha de inicio: {{ $turno->fecha_inicio->format('d-m-Y H:i') }}</p>
        <p class="text-gray-600">Fecha de cierre: {{ $turno->fecha_fin ? $turno->fecha_fin->format('d-m-Y H:i') : 'No disponible' }}</p>
        <p class="text-gray-600">Saldo Inicial: Bs {{ number_format($turno->saldo_inicial, 2) }}</p>

        {{-- Calculamos el saldo final automáticamente --}}
        @php
            $sucursal = $turno->sucursal_id;
            $totalIngresos = $turno->movimientos
                ->where('sucursal_origen', $sucursal)
                ->where('direccion', 'ingreso')
                ->where(function($mov) { return empty($mov->pago_en_destino); })
                ->sum('monto');
            $totalEgresos = $turno->movimientos
                ->where('sucursal_origen', $sucursal)
                ->where('direccion', 'egreso')
                ->where(function($mov) { return empty($mov->pago_en_destino); })
                ->sum('monto');
            $saldoFinal = $turno->saldo_inicial + $totalIngresos - $totalEgresos;
        @endphp
        <p class="text-gray-600">Saldo Final: Bs {{ number_format($saldoFinal, 2) }}</p>
    </div>

    <div class="mb-6">
        <h3 class="text-xl font-semibold text-gray-800">Movimientos</h3>
        <table class="min-w-full bg-white shadow-md rounded-lg mt-4">
            <thead>
                <tr>
                    <th class="py-2 px-4 text-left text-black">ID Movimiento</th>
                    <th class="py-2 px-4 text-left text-black">Tipo</th>
                    <th class="py-2 px-4 text-left text-black">Descripción</th>
                    <th class="py-2 px-4 text-left text-black">Ingreso/Egreso</th>
                    <th class="py-2 px-4 text-left text-black">Monto</th>
                    <th class="py-2 px-4 text-left text-black">Fecha</th>
                    <th class="py-2 px-4 text-left text-black">Pago en destino</th> 
                </tr>
            </thead>
            <tbody>
                @foreach ($turno->movimientos as $movimiento)
                    <tr>
                        <td class="py-2 px-4 text-black">{{ $movimiento->id }}</td>
                        <td class="py-2 px-4 text-black">{{ ucfirst($movimiento->tipo_movimiento) }}</td>
                        <td class="py-2 px-4 text-black">{{ $movimiento->descripcion }}</td>
                        <td class="py-2 px-4 text-black">
                            @if($movimiento->monto > 0)
                                Ingreso
                            @else
                                Egreso
                            @endif
                        </td>
                        <td class="py-2 px-4 text-black">Bs {{ number_format($movimiento->monto, 2) }}</td>
                        <td class="py-2 px-4 text-black">{{ $movimiento->created_at->format('d-m-Y H:i') }}</td>
                        <td class="py-2 px-4 text-black">
                            @if(empty($movimiento->pago_en_destino))
                                Pagado
                            @elseif($movimiento->pago_en_destino)
                                Pagar en destino
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mb-4">
        @if($turno->abierto)
            <form method="POST" action="{{ route('turnos.close', $turno->id) }}">
                @csrf
                <label for="saldo_final" class="block text-sm font-medium text-gray-700">Saldo Final</label>
                <input type="number" name="saldo_final" id="saldo_final" value="{{ $saldoFinal }}" class="mt-1 block w-full" readonly>
                <button type="submit" class="mt-4 bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Cerrar Turno
                </button>
            </form>
        @else
            <p class="text-green-600">El turno ya está cerrado.</p>
        @endif
    </div>

    <div class="mt-4">
        <a href="{{ route('turnos.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Volver a los turnos
        </a>
    </div>
</div>
@endsection
