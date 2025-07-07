@extends('layouts.app')

@section('title', 'Crear Descuento')

@section('content')
<a href="{{ route('admin.dashboard') }}" class="inline-block text-indigo-600 hover:text-indigo-800 underline mb-4">&larr; Volver </a>

<div class="container mx-auto mt-8">
    <h2 class="text-2xl font-semibold text-gray-800">Crear Descuento</h2>

    @if (session('success'))
        <div class="alert alert-success mt-4 bg-green-100 text-green-700 p-4 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('descuentos.store') }}" method="POST" class="mt-6">
        @csrf
        <div class="mb-4">
    <label for="viaje_id" class="block text-sm font-medium text-gray-700">Viaje</label>
    <select name="viaje_id" id="viaje_id" class="mt-1 block w-full px-4 py-2 bg-gray-700 text-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        <option value="">Seleccionar viaje</option>
        @foreach($viajes as $viaje)
            <option value="{{ $viaje->id }}" class="text-black bg-gray-200 hover:bg-indigo-200">
    {{ $viaje->ruta->origen }} - {{ $viaje->ruta->destino }} - {{ $viaje->fecha_salida }}
</option>
        @endforeach
    </select>
</div>


        <div class="mb-4">
            <label for="valor_descuento" class="block text-sm font-medium text-gray-700">Valor de Descuento</label>
            <input type="number" name="valor_descuento" id="valor_descuento" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        </div>

        <div class="mb-4">
            <label for="tipo_descuento" class="block text-sm font-medium text-gray-700">Tipo de Descuento</label>
            <select name="tipo_descuento" id="tipo_descuento" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                <option value="valor">Valor</option>
                <option value="porcentaje">Porcentaje</option>
            </select>
        </div>

        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md mt-4">
            Crear Descuento
        </button>
    </form>
</div>

<style>
    ::selection {
        background: #2563eb;
        color: #fff;
    }
    select option:checked, select option:focus {
        background: #2563eb !important;
        color: #fff !important;
    }
</style>
@endsection
