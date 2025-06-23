@extends('layouts.app')

@section('title','Bienvenido')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full text-center">
    <h1 class="text-3xl font-bold mb-4">Bienvenido a Venta de Pasajes</h1>
    <p class="text-gray-600 mb-6">Compra tus pasajes de forma rápida y sencilla.</p>
    <a href="{{ route('login') }}"
       class="inline-block px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition">
      Iniciar Sesión
    </a>
  </div>
</div>
@endsection
