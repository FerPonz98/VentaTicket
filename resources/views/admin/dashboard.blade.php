{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-4">
    <h1>Panel de Administración</h1>
    <p>Bienvenido, {{ auth()->user()->nombre_usuario }}!</p>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Resumen</h5>
            <p class="card-text">Aquí puedes mostrar datos importantes, estadísticas o enlaces rápidos.</p>
        </div>
    </div>
</div>
@endsection
