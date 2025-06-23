{{-- resources/views/dashboard.blade.php --}}

@extends('layouts.app')

@section('title', 'Dashboard')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Bienvenido, {{ Auth::user()->nombre_usuario }}!
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Mensaje de éxito --}}
            @if (session('success'))
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tarjeta de Resumen --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-2">Resumen</h3>
                    <p class="text-sm">Aquí puedes colocar estadísticas o accesos rápidos a las diferentes secciones del panel.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
