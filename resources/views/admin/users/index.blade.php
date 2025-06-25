{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Usuarios y Roles')

@section('content')
<div class="container mx-auto mt-6">
    <h2 class="text-2xl font-bold mb-4 text-black">Listado de Usuarios</h2>

    @if (session('success'))
        <div class="mb-4 p-2 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('users.create') }}"
       class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
         Registrar nuevo usuario
    </a>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border text-black">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border text-black">CI</th>
                    <th class="px-4 py-2 border text-black">Nombre</th>
                    <th class="px-4 py-2 border text-black">Apellidos</th>
                    <th class="px-4 py-2 border text-black">Rol</th>
                    <th class="px-4 py-2 border text-black">Email</th>
                    <th class="px-4 py-2 border text-black">Foto</th>
                    <th class="px-4 py-2 border text-black">Estado</th>
                    <th class="px-4 py-2 border text-black">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $usuario)
                    <tr class="@if($usuario->estado == 'bloqueado') bg-red-50 @endif">
                        <td class="px-4 py-2 border text-black">{{ $usuario->ci_usuario }}</td>
                        <td class="px-4 py-2 border text-black">{{ $usuario->nombre_usuario }}</td>
                        <td class="px-4 py-2 border text-black">{{ $usuario->apellidos }}</td>
                        <td class="px-4 py-2 border text-black">{{ $usuario->rol }}</td>
                        <td class="px-4 py-2 border text-black">{{ $usuario->email }}</td>
                        <td class="px-4 py-2 border text-black">
                            @if($usuario->foto)
                                <img src="{{ asset('storage/'.$usuario->foto) }}" width="50" alt="">
                            @else
                                No tiene
                            @endif
                        </td>
                        <td class="px-4 py-2 border text-black">{{ ucfirst($usuario->estado) }}</td>
                        <td class="px-4 py-2 border space-x-2">
                            <a href="{{ route('users.show', $usuario) }}" class="text-green-600 hover:underline">Ver</a>
                            <a href="{{ route('users.edit', $usuario) }}" class="text-blue-600 hover:underline">Editar</a>
                            <form method="POST" action="{{ route('users.destroy', $usuario) }}" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-2 text-center text-black">No hay usuarios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
