@extends('layouts.app')

@section('title', 'Encomiendas')

@section('content')
<div class="container mx-auto mt-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Encomiendas</h1>
        <a href="{{ route('encomiendas.create') }}" class="btn btn-primary">➕ Nueva Encomienda</a>
    </div>

    <table class="min-w-full bg-white border">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Remitente</th>
                <th class="px-4 py-2 border">Destinatario</th>
                <th class="px-4 py-2 border">Peso</th>
                <th class="px-4 py-2 border">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($encomiendas as $item)
                <tr>
                    <td class="px-4 py-2 border">{{ $item->id }}</td>
                    <td class="px-4 py-2 border">{{ $item->remitente_nombre }}</td>
                    <td class="px-4 py-2 border">{{ $item->destinatario_nombre }}</td>
                    <td class="px-4 py-2 border">{{ $item->peso }} kg</td>
                    <td class="px-4 py-2 border space-x-2">
                        <a href="{{ route('encomiendas.show', $item) }}" class="text-blue-600">Ver</a>
                        <a href="{{ route('encomiendas.edit', $item) }}" class="text-yellow-600">Editar</a>
                        <form action="{{ route('encomiendas.destroy', $item) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600">Borrar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-2 border text-center">No hay encomiendas registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
