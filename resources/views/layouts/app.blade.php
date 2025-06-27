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
      <img src="{{ asset('img/logo-empresa.jpg') }}" class="h-8 w-auto" alt="Logo">
      <span class="ml-2 font-bold text-xl">Mi Sistema</span>
    </div>
    <nav class="flex-1 overflow-y-auto">
      <ul class="space-y-1 px-4">
        @auth
          @php $rol = Auth::user()->rol; @endphp

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
           @if(in_array($rol, ['admin','supervisor gral','supervisor suc','cajero','ventas qr','carga','encomienda']))
            <li><a href="{{ route('carga.index') }}" class="block px-3 py-3 rounded hover:bg-gray-700 text-xl">Carga</a></li>
          @endif

          {{-- Encomiendas --}}
           @if(in_array($rol, ['admin','supervisor gral','supervisor suc','cajero','ventas qr','carga','encomienda']))
            <li><a href="{{ route('encomiendas.index') }}" class="block px-3 py-3 rounded hover:bg-gray-700 text-xl">Encomiendas</a></li>
          @endif

          {{-- Kardex --}}
          @if($rol === 'chofer y ayudante')
            <li><a href="{{ route('kardex.index') }}" class="block px-3 py-3 rounded hover:bg-gray-700 text-xl">Kardex</a></li>
          @endif

          {{-- Menú Admin/Supervisor Gral con recursos complejos --}}
          @if(in_array($rol, ['admin','supervisor gral']))
            {{-- Buses --}}
            <li x-data="{ open: false }" class="group">
              <button @click="open = !open" class="w-full flex justify-between items-center px-3 py-3 rounded hover:bg-gray-700">
                <span>Buses</span>
                <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M5.23 7.21l4.25 4.25 4.25-4.25"/>
                </svg>
              </button>
              <ul x-show="open" class="mt-1 pl-6 space-y-1">
                <li><a href="{{ route('buses.index') }}" class="block px-2 py-2 rounded hover:bg-gray-700">Listar Buses</a></li>
                <li><a href="{{ route('buses.create') }}" class="block px-2 py-2 rounded hover:bg-gray-700">Crear Bus</a></li>
              </ul>
            </li>
            {{-- Rutas --}}
            <li x-data="{ open: false }" class="group">
              <button @click="open = !open" class="w-full flex justify-between items-center px-3 py-2 rounded hover:bg-gray-700">
                <span>Rutas </span>
                <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M5.23 7.21l4.25 4.25 4.25-4.25"/>
                </svg>
              </button>
              <ul x-show="open" class="mt-1 pl-6 space-y-1">
                <li><a href="{{ route('rutas.index') }}" class="block px-2 py-1 rounded hover:bg-gray-700">Listar Rutas</a></li>
                <li><a href="{{ route('rutas.create') }}" class="block px-2 py-1 rounded hover:bg-gray-700">Crear Ruta</a></li>
              </ul>
            </li>
            {{-- Viajes --}}
            <li x-data="{ open: false }" class="group">
              <button @click="open = !open" class="w-full flex justify-between items-center px-3 py-2 rounded hover:bg-gray-700">
                <span>Viajes</span>
                <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M5.23 7.21l4.25 4.25 4.25-4.25"/>
                </svg>
              </button>
              <ul x-show="open" class="mt-1 pl-6 space-y-1">
                <li><a href="{{ route('viajes.index') }}" class="block px-2 py-1 rounded hover:bg-gray-700">Listar Viajes</a></li>
                <li><a href="{{ route('viajes.create') }}" class="block px-2 py-1 rounded hover:bg-gray-700">Crear Viaje</a></li>
              </ul>
            </li>
            {{-- Choferes --}}
            <li x-data="{ open: false }" class="group">
              <button @click="open = !open" class="w-full flex justify-between items-center px-3 py-2 rounded hover:bg-gray-700">
                <span>Choferes</span>
                <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M5.23 7.21l4.25 4.25 4.25-4.25"/>
                </svg>
              </button>
              <ul x-show="open" class="mt-1 pl-6 space-y-1">
                <li><a href="{{ route('choferes.index') }}" class="block px-2 py-1 rounded hover:bg-gray-700">Listar Choferes</a></li>
                <li><a href="{{ route('choferes.create') }}" class="block px-2 py-1 rounded hover:bg-gray-700">Crear Chofer</a></li>
              </ul>
            </li>
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
</body>
</html>
