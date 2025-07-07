{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="es" class="h-full bg-gray-100">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','Mi Sistema')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="h-full flex">
  <aside class="w-64 bg-gray-800 text-gray-200 flex flex-col">
    <div class="p-6 flex items-center">
      
      <span class="ml-2 font-bold text-xl">Mi Sistema</span>
    </div>
    <nav class="flex-1 overflow-y-auto">
      <ul class="space-y-1 px-4">
        @auth
          @php
            $rol = Auth::user()->rol;
            // Tomar ruta activa de sesión o si no existe, la primera en BD
            $rutaId = session('ruta_actual_id') 
                     ?? \App\Models\Ruta::first()?->id;
          @endphp

          {{-- Dashboard: sólo Admin --}}
          @if(in_array($rol, ['admin']))
            <li><a href="{{ route('dashboard') }}" class="block px-3 py-3 rounded hover:bg-gray-700 text-xl">Dashboard</a></li>
          @endif

          {{-- Usuarios: sólo Admin y Supervisores --}}
          @if(in_array($rol, ['admin','supervisor gral','supervisor suc']))
            <li><a href="{{ route('users.index') }}" class="block px-3 py-3 rounded hover:bg-gray-700 text-xl">Usuarios</a></li>
          @endif

          {{-- Venta de Pasajes --}}
          @if(in_array($rol, ['admin','supervisor gral','supervisor suc','cajero','ventas qr','carga','encomienda']))
            <li><a href="{{ route('pasajes.index') }}" class="block px-3 py-3 rounded hover:bg-gray-700 text-xl">Venta de Pasajes</a></li>
          @endif

          {{-- Carga --}}
@if(in_array($rol, ['admin','supervisor gral','supervisor suc','cajero','ventas qr','carga']))
  <li>
    <a href="{{ route('carga.index') }}"
       class="block px-3 py-3 rounded hover:bg-gray-700 text-xl">
      Carga
    </a>
  </li>
@endif

{{-- Encomiendas --}}
@if(in_array($rol, ['admin','supervisor gral','supervisor suc','cajero','ventas qr','encomienda','carga']))
  <li>
    <a href="{{ route('encomiendas.index') }}"
       class="block px-3 py-3 rounded hover:bg-gray-700 text-xl">
      Encomiendas
    </a>
  </li>
@endif
{{-- Turnos --}}
@if(in_array($rol, ['admin','supervisor gral','supervisor suc','cajero','ventas qr','encomienda','carga']))
  <li>
    <a href="{{ route('turnos.index') }}" class="block px-3 py-3 rounded hover:bg-gray-700 text-xl">
      Turnos
    </a>
  </li>
@endif

          {{-- Kardex --}}
          @if(in_array($rol, ['chofer','ayudante']))
            <li><a href="{{ route('kardex.index') }}" class="block px-3 py-3 rounded hover:bg-gray-700 text-xl">Kardex</a></li>
          @endif

          @if(in_array($rol, ['admin','supervisor gral','supervisor suc']))
            {{-- Buses --}}
            <li><a href="{{ route('buses.index') }}" class="block px-3 py-3 rounded hover:bg-gray-700 text-xl">Buses</a></li>
            {{-- Rutas --}}
            <li><a href="{{ route('rutas.index') }}" class="block px-3 py-3 rounded hover:bg-gray-700 text-xl">Rutas</a></li>
            {{-- Viajes --}}
            <li><a href="{{ route('viajes.index') }}" class="block px-3 py-3 rounded hover:bg-gray-700 text-xl">Viajes</a></li>
            {{-- Choferes --}}
            <li><a href="{{ route('choferes.index') }}" class="block px-3 py-3 rounded hover:bg-gray-700 text-xl">Choferes</a></li>
          @endif
        @endauth
      </ul>
    </nav>

    <div class="p-4 border-t border-gray-700">
      <div class="flex items-center space-x-3">
        @if(Auth::user()->foto)
          <img src="{{ asset('storage/' . Auth::user()->foto) }}" class="h-8 w-8 rounded-full object-cover" alt="">
        @else
          <div class="h-8 w-8 bg-gray-600 rounded-full"></div>
        @endif
        <div class="flex flex-col">
          <span class="text-base font-medium text-white">{{ Auth::user()->nombre_usuario }}</span>
          <span class="text-sm text-gray-400">{{ ucfirst(Auth::user()->rol) }}</span>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-400 hover:underline">Salir</button>
          </form>
        </div>
      </div>
    </div>
  </aside>

  <div class="flex-1 flex flex-col overflow-hidden">
    <header class="bg-white shadow px-6 py-4">
      <h1 class="text-2xl font-semibold text-gray-800">@yield('title')</h1>
    </header>
    <main class="flex-1 overflow-auto p-6">
      @yield('content')
    </main>
  </div>
  
{{-- Logo flotante, solo si no es lobby --}}
@if (!request()->routeIs('lobby'))
    <img src="{{ asset('img/logo-empresa.jpg') }}"
         class="fixed top-0 right-4 h-16 w-auto z-50 opacity-80"
         alt="Logo">
@endif
</body>
</html>
