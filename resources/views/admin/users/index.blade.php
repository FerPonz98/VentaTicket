{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Usuarios y Roles')

@section('content')
<div class="container mx-auto mt-6">
  <h2 class="text-3xl font-bold mb-4 text-gray-800">Listado de Usuarios</h2>

  @if (session('success'))
    <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded">
      {{ session('success') }}
    </div>
  @endif

  <a href="{{ route('users.create') }}"
     class="inline-block mb-6 px-5 py-2 bg-blue-600 text-white font-medium rounded shadow hover:bg-blue-700 transition">
    + Registrar Usuario
  </a>

  @php
    // Ordenamos por sucursal
    $usuariosOrdenados = $usuarios->sortBy('sucursal');
  @endphp

  <div class="overflow-x-auto bg-white shadow rounded-lg">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sucursal</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">CI</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Apellidos</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rol</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Celular</th>
          <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
          //<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto</th>
          <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Acciones</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        @forelse($usuariosOrdenados as $usuario)
          <tr class="hover:bg-gray-50 {{ $usuario->estado === 'bloqueado' ? 'bg-red-50' : '' }}">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $usuario->sucursal }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $usuario->ci_usuario }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $usuario->nombre_usuario }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $usuario->apellidos }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                {{ $usuario->rol === 'admin' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }}">
                {{ ucfirst($usuario->rol) }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $usuario->celular ?? '—' }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
              @if($usuario->estado === 'activo')
                <span class="text-green-600 font-medium">Activo</span>
              @else
                <span class="text-red-600 font-medium">Bloqueado</span>
              @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              @if($usuario->foto)
                <img src="{{ asset('storage/'.$usuario->foto) }}" alt="Avatar" class="h-8 w-8 rounded-full object-cover">
              @else
                <div class="h-8 w-8 bg-gray-200 rounded-full"></div>
              @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
              <a href="{{ route('users.show', $usuario) }}" class="text-green-600 hover:text-green-800">Ver</a>
              <a href="{{ route('users.edit', $usuario) }}" class="text-blue-600 hover:text-blue-800">Editar</a>
              <form method="POST" action="{{ route('users.destroy', $usuario) }}" class="inline">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800">Eliminar</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="9" class="px-6 py-4 text-center text-gray-600">
              No hay usuarios registrados.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
