@extends('layouts.app')

@section('title', 'Registrar Ingresos')

@section('content')
<a href="{{ route('turnos.index') }}"
     class="inline-block text-indigo-600 hover:text-indigo-800 underline mb-4">
    &larr; Volver 
  </a>
<div class="container mx-auto mt-8">
    <h3 class="text-xl font-semibold">Registrar Ingresos para el Turno #{{ $turno->id }}</h3>

    {{-- Mostrar errores --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario para registrar ingresos --}}
    <form action="{{ route('turnos.ingresos.store', $turno->id) }}" method="POST">
        @csrf
        <input type="hidden" name="direccion" value="ingreso">
        
        <div class="mb-4">
            <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción del Ingreso</label>
            <input type="text" name="descripcion" id="descripcion" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label for="monto" class="block text-sm font-medium text-gray-700">Monto del Ingreso</label>
            <input type="number" name="monto" id="monto" class="mt-1 block w-full p-2 border border-gray-300 rounded" required min="0">
        </div>

        <div class="mb-4">
            <label for="tipo_movimiento" class="block text-sm font-medium text-gray-700">Tipo de Ingreso</label>
            <select name="tipo_movimiento" id="tipo_movimiento" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                <option value="venta_efectivo">Venta Efectivo</option>
                <option value="venta_qr">Venta QR</option>
                <option value="pago_destino">Pago en Destino</option>
                <option value="cortesia">Cortesía</option>
                <option value="servicio_interno">Servicio Interno</option>
                <option value="descuento_salida">Descuento por Salida</option>
                <option value="recibo_salida_bus">Recibo de Salida Bus</option>
                <option value="recibo_fotocopias">Recibo de Fotocopias</option>
                <option value="aportes_buses">Aportes de Buses</option>
                <option value="deposito_efectivo">Depósito Efectivo</option>
                <option value="sobrantes_dia_anterior">Sobrantes Día Anterior</option>
                <option value="cobros">Cobros</option>
                <option value="multas">Multas</option>
                <option value="cobro_aportes">Cobro Aportes</option>
            </select>
        </div>

        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Registrar Ingreso
        </button>
    </form>
</div>
@endsection
