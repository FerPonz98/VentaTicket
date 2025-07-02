{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
<div class="container mx-auto mt-6">

  @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
      {{ session('success') }}
    </div>
  @endif

  {{-- Botón Registrar Usuario --}}
  <div class="w-full flex flex-row-reverse p-4 pb-8">
    <a href="{{ route('users.create') }}"
       class="bg-green-600 p-2 text-white text-sm font-normal rounded-lg shadow hover:bg-green-700 transition"
    >+ Registrar Usuario</a>
  </div>

  {{-- BOX A: Listado de Usuarios con búsqueda por CI --}}
  <div class="bg-white shadow-xl rounded-lg overflow-hidden p-6 mb-6 overflow-x-auto">
    <table class="min-w-full table-auto">
      <thead class="bg-white">
        <tr>
          <th colspan="9" class="text-2xl font-bold text-black text-left">
            <div class="flex justify-between items-center w-full">
              <h2>Administración de Usuarios</h2>
              <form method="GET" action="{{ route('users.index') }}" class="flex items-center space-x-2 w-full max-w-md">
                <input
                  type="text"
                  name="ci_usuario"
                  placeholder="Buscar por CI"
                  value="{{ request('ci_usuario') }}"
                  class="border w-full p-2 border-gray-300 text-sm text-white font-light rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 whitespace-pre"
                />
                <button
                  type="submit"
                  class="bg-indigo-600 p-2 text-white text-sm font-semibold rounded-lg shadow hover:bg-indigo-700 transition"
                >Buscar</button>
              </form>
            </div>
          </th>
        </tr>
        <tr>
          <th colspan="7" class="px-6 py-2 bg-white">

          </th>
        </tr>
        <tr class="text-left bg-gray-200 text-black uppercase text-sm leading-normal">
          <th class="px-6 py-3">Sucursal</th>
          <th class="px-6 py-3">CI</th>
          <th class="px-6 py-3">Nombre</th>
          <th class="px-6 py-3">Apellidos</th>
          <th class="px-6 py-3">Rol</th>
          <th class="px-6 py-3">Celular</th>
          <th class="px-6 py-3">Estado</th>
          <th class="px-6 py-3">Avatar</th>
          <th class="px-6 py-3">Acciones</th>
        </tr>
      </thead>

      <tbody class="text-gray-700 text-sm border border-gray-200">
        @forelse($usuarios->sortBy('sucursal') as $usuario)
          <tr class="border-b border-gray-200 hover:bg-gray-50 {{ $usuario->estado === 'bloqueado' ? 'bg-red-50' : '' }}">
            <td class="px-6 py-4 whitespace-nowrap">{{ $usuario->sucursal }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $usuario->ci_usuario }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $usuario->nombre_usuario }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $usuario->apellidos }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                {{ $usuario->rol === 'admin' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }}">
                {{ ucfirst($usuario->rol) }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $usuario->celular ?? '—' }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
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
            <td class="px-6 py-4 whitespace-nowrap space-x-2">
              <a href="{{ route('users.show', $usuario) }}" class="text-indigo-600 hover:underline">Ver</a>
              <a href="{{ route('users.edit', $usuario) }}" class="text-yellow-600 hover:underline">Editar</a>
              <form method="POST" action="{{ route('users.destroy', $usuario) }}" class="inline">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="9" class="px-6 py-4 text-center text-gray-500">
              No hay usuarios registrados.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- BOX A: Usuarios Recientemente Creados --}}
  <div class="bg-white shadow-xl rounded-lg overflow-hidden p-6 mb-6 overflow-x-auto">
    <table class="min-w-full table-auto">
      <thead class="bg-white">
        <tr>
          <th colspan="9" class="text-2xl font-bold text-black text-left">
            <h2>Usuarios Recientemente Creados</h2>
          </th>
        </tr>
        <tr>
          <th colspan="7" class="px-6 py-2 bg-white">

          </th>
        </tr>
        <tr class="text-left bg-gray-200 text-black uppercase text-sm leading-normal">
          <th class="px-6 py-3">Sucursal</th>
          <th class="px-6 py-3">CI</th>
          <th class="px-6 py-3">Nombre</th>
          <th class="px-6 py-3">Apellidos</th>
          <th class="px-6 py-3">Rol</th>
          <th class="px-6 py-3">Celular</th>
          <th class="px-6 py-3">Estado</th>
          <th class="px-6 py-3">Avatar</th>
          <th class="px-6 py-3">Acciones</th>
        </tr>
      </thead>
      <tbody class="text-gray-700 text-sm border border-gray-200">
        @forelse($usuarios->sortByDesc('created_at')->take(5) as $usuario)
          <tr class="border-b border-gray-200 hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap">{{ $usuario->sucursal }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $usuario->ci_usuario }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $usuario->nombre_usuario }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $usuario->apellidos }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                {{ $usuario->rol === 'admin' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }}">
                {{ ucfirst($usuario->rol) }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $usuario->celular ?? '—' }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
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
            <td class="px-6 py-4 whitespace-nowrap space-x-2">
              <a href="{{ route('users.show', $usuario) }}" class="text-indigo-600 hover:underline">Ver</a>
              <a href="{{ route('users.edit', $usuario) }}" class="text-yellow-600 hover:underline">Editar</a>
              <form method="POST" action="{{ route('users.destroy', $usuario) }}" class="inline">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="9" class="px-6 py-4 text-center text-gray-500">
              No hay usuarios recientes.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</div>
@endsection
