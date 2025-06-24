@extends('layouts.app')

@section('title', 'Kardex')

@section('content')
<div class="container mx-auto mt-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Kardex</h1>
        <a href="{{ route('kardex.create') }}" class="btn btn-primary">➕ Nuevo Registro</a>
    </div>

    <table class="min-w-full bg-white border">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Producto</th>
                <th class="px-4 py-2 border">Cantidad</th>
                <th class="px-4 py-2 border">Fecha</th>
                <th class="px-4 py-2 border">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kardex as $registro)
                <tr>
                    <td class="px-4 py-2 border">{{ $registro->id }}</td>
                    <td class="px-4 py-2 border">{{ $registro->producto_nombre }}</td>
                    <td class="px-4 py-2 border">{{ $registro->cantidad }}</td>
                    <td class="px-4 py-2 border">{{ $registro->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-2 border space-x-2">
                        <a href="{{ route('kardex.show', $registro) }}" class="text-blue-600">Ver</a>
                        <a href="{{ route('kardex.edit', $registro) }}" class="text-yellow-600">Editar</a>
                        <form action="{{ route('kardex.destroy', $registro) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600">Borrar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-2 border text-center">No hay registros en el kardex.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
