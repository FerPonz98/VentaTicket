{{-- resources/views/turnos/index.blade.php --}}
@extends('layouts.app')
@section('title','Mis Turnos')
@section('content')
  <h1>Turnos</h1>
  <table>
    <thead>
      <tr><th>ID</th><th>Inicio</th><th>Fin</th><th>Total</th><th>Acciones</th></tr>
    </thead>
    <tbody>
      @foreach($turnos as $t)
      <tr>
        <td>{{ $t->id }}</td>
        <td>{{ $t->fecha_inicio }}</td>
        <td>{{ $t->fecha_fin ?? 'Abierto' }}</td>
        <td>{{ number_format($t->total_pagado,2) }} Bs</td>
        <td>
          @if(is_null($t->fecha_fin))
            <form action="{{ route('turnos.close',$t) }}" method="POST">
              @csrf
              <button type="submit">Cerrar turno</button>
            </form>
          @else
            —
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
@endsection
