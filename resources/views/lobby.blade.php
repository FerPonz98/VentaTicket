{{-- resources/views/lobby.blade.php --}}
@extends('layouts.app')

@section('title', 'Bienvenido')

@section('content')
  <div class="max-w-4xl mx-auto space-y-8">
    {{-- Tarjeta de bienvenida --}}
    <div class="bg-white p-8 rounded-2xl shadow-lg text-center">
      <img src="{{ asset('img/logo-empresa.jpg') }}" alt="Logo" class="mx-auto h-16 mb-4">
      <h1 class="text-4xl font-extrabold text-gray-800 mb-2">
        ¡Hola, {{ Auth::user()->nombre_usuario }}!
      </h1>
      <p class="text-gray-600">
        Bienvenido a tu panel de control. Aquí puedes acceder rápidamente a tus secciones permitidas.
      </p>
      @if(Auth::user()->rol === 'admin')
        <a href="{{ route('dashboard') }}"
           class="mt-6 inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition">
          Ir al Panel de Administración
        </a>
      @endif
    </div>

    {{-- Accesos rápidos --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      {{-- Venta de Pasajes --}}
      @can('view', App\Models\Pasaje::class)
        <a href="{{ route('pasajes.index') }}"
           class="block bg-gradient-to-br from-blue-400 to-blue-600 hover:from-blue-500 hover:to-blue-700 text-white rounded-xl shadow-md p-6 text-center transition">
          <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 17v-6h13v6M9 17l-2 2m0 0l-2-2m2 2V9a4 4 0 1 1 8 0v8"></path>
          </svg>
          <h3 class="text-xl font-semibold">Venta de Pasajes</h3>
        </a>
      @endcan

      {{-- Carga --}}
      @can('viewAny', App\Models\Carga::class)
        <a href="{{ route('carga.index') }}"
           class="block bg-gradient-to-br from-green-400 to-green-600 hover:from-green-500 hover:to-green-700 text-white rounded-xl shadow-md p-6 text-center transition">
          <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 7h2l.4 2M7 7h10l1 5H6l1-5zm0 0L5 4m14 3l1-3M16 13a4 4 0 1 0-8 0v4h8v-4z"></path>
          </svg>
          <h3 class="text-xl font-semibold">Carga</h3>
        </a>
      @endcan

      {{-- Encomiendas --}}
      @can('viewAny', App\Models\Encomienda::class)
        <a href="{{ route('encomiendas.index') }}"
           class="block bg-gradient-to-br from-yellow-400 to-yellow-600 hover:from-yellow-500 hover:to-yellow-700 text-white rounded-xl shadow-md p-6 text-center transition">
          <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 7h18M3 7l2-2m0 0l2 2m-2-2v12m0 0l2-2m-2 2l-2-2m16-8h-6m6 0l-2-2m0 0l-2 2m2-2v12m0 0l-2-2m2 2l2-2"></path>
          </svg>
          <h3 class="text-xl font-semibold">Encomiendas</h3>
        </a>
      @endcan
    </div>
  </div>
@endsection
