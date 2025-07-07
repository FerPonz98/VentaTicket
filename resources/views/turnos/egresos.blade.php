{{-- resources/views/turnos/egresos.blade.php --}}
@extends('layouts.app')

@section('title', 'Registrar Egresos')

@section('content')
<a href="{{ route('turnos.index') }}"
     class="inline-block text-indigo-600 hover:text-indigo-800 underline mb-4">
    &larr; Volver 
  </a>
<div class="container mx-auto mt-8">
    <h3 class="text-xl text-black font-semibold">Registrar Egresos para el Turno #{{ $turno->id }}</h3>

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

    {{-- Formulario para registrar egresos --}}
    <form action="{{ route('turnos.egresos.store', $turno->id) }}" method="POST">
        @csrf
        <input type="hidden" name="direccion" value="egreso">
        <div class="mb-4">
            <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción del Egreso</label>
            <input type="text" name="descripcion" id="descripcion" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label for="monto" class="block text-sm font-medium text-gray-700">Monto del Egreso</label>
            <input type="number" name="monto" id="monto" class="mt-1 block w-full p-2 border border-gray-300 rounded" required min="0">
        </div>

        <div class="mb-4">
    <label for="tipo_movimiento" class="block text-sm font-medium text-gray-700">Tipo de Egreso</label>
    <select name="tipo_movimiento" id="tipo_movimiento" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
        <option value="pago_recibo_qr">Recibo QR (Ventas Guarayos y Concepción)</option>
        <option value="recibo_gastos">Recibos Gastos</option>
        <option value="compra_materiales">Compra de Materiales</option>
        <option value="pago_pasaje_qr_oficina">Pago de Pasajes en Oficina</option>
        <option value="pago_pasajes_cortesias">Pago de Pasajes de Cortesía</option>
    </select>
</div>


        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
            Registrar Egreso
        </button>
    </form>
</div>
@endsection
