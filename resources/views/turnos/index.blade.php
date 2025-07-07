@extends('layouts.app')

@section('title', 'Gestión de Turnos')

@section('content')
<div class="container mx-auto mt-8">
    {{-- Mensajes de éxito o error --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-4 flex flex-wrap gap-2">
        @php
            $rol = Auth::user()->rol;
        @endphp

        {{-- Botón para iniciar o cerrar turno --}}
        @if (in_array($rol, ['cajero', 'qr', 'encomienda', 'carga']))
            @if (is_null($turnoAbierto))
                <form method="POST" action="{{ route('turnos.open') }}">
                    @csrf
                    <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Iniciar Turno
                    </button>
                </form>
            @else
                <a href="{{ route('turnos.show', $turnoAbierto->id) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                    Cerrar Turno
                </a>
            @endif
        @endif

        {{-- Botones para ver ingresos y egresos --}}
        @if (in_array($rol, ['cajero', 'qr', 'encomienda', 'carga']))
            @if (!is_null($turnoAbierto))
                <a href="{{ route('turnos.ingresos', $turnoAbierto->id) }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Registrar Ingresos
                </a>
                <a href="{{ route('turnos.egresos', $turnoAbierto->id) }}"
                   class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Registrar Egresos
                </a>
            @endif
        @endif

        {{-- Botón para ver turnos por sucursal --}}
        @if (in_array($rol, ['admin', 'supervisor gral']))
            <form method="GET" action="{{ route('turnos.index') }}" class="mb-4 flex items-center gap-2">
                <label for="sucursal_id" class="font-semibold">Sucursal:</label>
                <select name="sucursal_id" id="sucursal_id" class="border rounded p-1">
                    <option value="">-- Todas --</option>
                    @foreach ($sucursales as $sucursal)
                        <option value="{{ $sucursal->nombre }}" {{ request('sucursal_id') == $sucursal->nombre ? 'selected' : '' }}>
                            {{ $sucursal->nombre }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                    Filtrar
                </button>
            </form>
        @elseif ($rol === 'Supervisor SUC')
            <a href="{{ route('turnos.index') }}"
               class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded">
                Ver Turnos de Mi Sucursal
            </a>
        @endif
    </div>

    {{-- Lista de turnos cerrados --}}
    <div class="mb-6">
        <h3 class="text-xl font-semibold text-gray-800">Últimos Turnos Cerrados</h3>
        <table class="min-w-full bg-white shadow-md rounded-lg mt-4">
            <thead>
                <tr>
                    <th class="py-2 px-4 text-left text-black">ID Turno</th>
                    <th class="py-2 px-4 text-left text-black">Tipo</th>
                    @if (in_array($rol, ['admin', 'supervisor gral']))
                        <th class="py-2 px-4 text-left text-black">Sucursal</th>
                    @endif
                    <th class="py-2 px-4 text-left text-black">Fecha Inicio</th>
                    <th class="py-2 px-4 text-left text-black">Fecha Fin</th>
                    <th class="py-2 px-4 text-left text-black">Saldo Inicial</th>
                    <th class="py-2 px-4 text-left text-black">Saldo Final</th>
                    <th class="py-2 px-4 text-left text-black">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($turnosCerrados as $turno)
                    <tr>
                        <td class="py-2 px-4 text-black">{{ $turno->id }}</td>
                        <td class="py-2 px-4 text-black">{{ ucfirst($turno->tipo) }}</td>
                        @if (in_array($rol, ['admin', 'supervisor gral']))
                            <td class="py-2 px-4 text-black">
                                {{ $turno->sucursal_id ?? 'Sin sucursal' }}
                            </td>
                        @endif
                        <td class="py-2 px-4 text-black">{{ $turno->fecha_inicio->format('d-m-Y H:i') }}</td>
                        <td class="py-2 px-4 text-black">{{ $turno->fecha_fin ? $turno->fecha_fin->format('d-m-Y H:i') : 'No disponible' }}</td>
                        <td class="py-2 px-4 text-black">Bs {{ number_format($turno->saldo_inicial, 2) }}</td>
                        <td class="py-2 px-4 text-black">Bs {{ number_format($turno->saldo_final, 2) }}</td>
                        <td class="py-2 px-4 text-black">
                            <a href="{{ route('turnos.show', $turno->id) }}"
                               class="text-blue-600 hover:text-blue-800">Ver Detalles</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
