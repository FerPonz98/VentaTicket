@extends('layouts.app')

@section('title', 'Crear Sucursal')

@section('content')
<a href="{{ route('admin.dashboard') }}" class="inline-block text-indigo-600 hover:text-indigo-800 underline mb-4">&larr; Volver </a>
<div class="max-w-6xl mx-auto grid lg:grid-cols-2 gap-8"><div>


<div class="container mx-auto mt-8">
    <h2 class="text-2xl font-semibold text-gray-800">Crear Sucursal</h2>

    <form method="POST" action="{{ route('sucursales.store') }}" class="mt-4">
        @csrf
        <div class="mb-4">
            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre de la Sucursal</label>
            <input type="text" id="nombre" name="nombre" class="mt-1 block w-full" style="padding-left: 8px;" required placeholder="Ingrese el nombre de la sucursal">
        </div>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Crear Sucursal
        </button>
    </form>
</div>
@endsection
