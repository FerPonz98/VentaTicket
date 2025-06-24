@extends('layouts.app')

@section('content')
<div class="container" style="text-align: center; padding: 40px;">
    <h1 style="font-size: 72px; color: #e74c3c;">403</h1>
    <h2>Acceso Denegado</h2>
    <p>No tienes permisos para acceder a esta sección.</p>
    <a href="{{ route('dashboard') }}">Volver al inicio</a>
</div>
@endsection
