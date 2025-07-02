@extends('layouts.app')

@section('title', 'Kardex')

@section('content')
@php
    $user = auth()->user();
    $chofer = $user->chofer;  // Relación con el modelo Chofer
@endphp

<div class="container mx-auto mt-6">
    @if(in_array($user->rol, ['chofer', 'ayudante']) && $chofer)
        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h2 class="text-2xl text-black font-semibold mb-4">Mis Datos de Chofer</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-800">
                <div><span class="font-medium">CI:</span> {{ $chofer->CI }}</div>
                <div><span class="font-medium">Nombre:</span> {{ $chofer->nombre_chofer }}</div>
                <div><span class="font-medium">Licencia:</span> {{ $chofer->licencia }}</div>
                <div><span class="font-medium">Venc. Licencia:</span> {{ $chofer->vencimiento_licencia->format('d/m/Y') }}</div>
            </div>
        </div>
    @endif

    
</div>
@endsection
