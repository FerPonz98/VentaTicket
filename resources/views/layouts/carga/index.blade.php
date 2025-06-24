@extends('layouts.app')

@section('title', 'Carga')

@section('content')
<div class="container mx-auto mt-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Carga</h1>
        <a href="{{ route('carga.create') }}" class="btn btn-primary">➕ Nueva Carga</a>
    </div>

    <table class="min-w-full bg-white border">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Descripción</th>
                <th class="px-4 py-2 border">Peso</th>
                <th class="px-4 py-2 border">Costo</th>
                <th class="px-4 py-2 border">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cargas as $carga)
                <tr>
                    <td class="px-4 py-2 border">{{ $carga->id }}</td>
                    <td class="px-4 py-2 border">{{ $carga->descripcion }}</td>
                    <td class="px-4 py-2 border">{{ $carga->peso }} kg</td>
                    <td class="px-4 py-2 border">{{ $carga->costo }} Bs.</td>
                    <td class="px-4 py-2 border space-x-2">
                        <a href="{{ route('carga.show', $carga) }}" class="text-blue-600">Ver</a>
                        <a href="{{ route('carga.edit', $carga) }}" class="text-yellow-600">Editar</a>
                        <form action="{{ route('carga.destroy', $carga) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600">Borrar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-2 border text-center">No hay cargas registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
