<!DOCTYPE html>
<html lang="es" class="h-full bg-gray-100">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','Mi App')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="h-full flex">
  <aside class="w-64 bg-gray-800 text-gray-200 flex flex-col">
    <div class="p-6 flex items-center">
      <img src="{{ asset('img/logo-empresa.jpg') }}" alt="Logo Empresa" class="h-8 w-auto"/>
      <span class="ml-2 font-bold text-lg">Mi Sistema</span>
    </div>
    <nav class="flex-1 overflow-y-auto">
      <ul class="space-y-1 px-4">
        <li><a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-700">Dashboard</a></li>
        @auth
          @if(in_array(Auth::user()->rol, ['admin','supervisor gral','supervisor suc']))
            <li><a href="{{ route('users.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700">Usuarios</a></li>
          @endif
          @if(in_array(Auth::user()->rol, ['admin','supervisor gral','supervisor suc','cajero']))
            <li><a href="{{ route('pasajes.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700">Pasajes</a></li>
          @endif
          @if(in_array(Auth::user()->rol, ['admin','supervisor gral','carga']))
            <li><a href="{{ route('carga.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700">Carga</a></li>
          @endif
          @if(in_array(Auth::user()->rol, ['admin','supervisor gral','encomienda']))
            <li><a href="{{ route('encomiendas.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700">Encomiendas</a></li>
          @endif
          @if(Auth::user()->rol === 'chofer y ayudante')
            <li><a href="{{ route('kardex.index') }}" class="block px-3 py-2 rounded hover:bg-gray-700">Kardex</a></li>
          @endif
          @if(in_array(Auth::user()->rol, ['admin','supervisor gral']))
            <li x-data="{ open: false }" class="group">
              <button @click="open = !open" class="w-full flex justify-between items-center px-3 py-2 rounded hover:bg-gray-700">
                <span>Buses</span>
                <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M5.23 7.21l4.25 4.25 4.25-4.25"/>
                </svg>
              </button>
              <ul x-show="open" class="mt-1 pl-6 space-y-1">
                <li><a href="{{ route('buses.index') }}" class="block px-2 py-1 rounded hover:bg-gray-700">Listar Buses</a></li>
                <li><a href="{{ route('buses.create') }}" class="block px-2 py-1 rounded hover:bg-gray-700">Crear Bus</a></li>
              </ul>
            </li>
            <li x-data="{ open: false }" class="group">
              <button @click="open = !open" class="w-full flex justify-between items-center px-3 py-2 rounded hover:bg-gray-700">
                <span>Rutas</span>
                <svg :class="{ 'rotate-180': open }" class="h-4 w-4 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M5.23 7.21l4.25 4.25 4.25-4.25"/>
                </svg>
              </button>
              <ul x-show="open" class="mt-1 pl-6 space-y-1">
                <li><a href="{{ route('rutas.index') }}" class="block px-2 py-1 rounded hover:bg-gray-700">Listar Rutas</a></li>
                <li><a href="{{ route('rutas.create') }}" class="block px-2 py-1 rounded hover:bg-gray-700">Crear Ruta</a></li>
              </ul>
            </li>
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
          <img src="{{ asset('storage/' . Auth::user()->foto) }}"
               alt="Avatar de {{ Auth::user()->nombre_usuario }}"
               class="h-8 w-8 rounded-full object-cover"/>
        @else
          <div class="h-8 w-8 bg-gray-600 rounded-full"></div>
        @endif
        <div class="flex flex-col">
          <span class="text-sm font-medium text-white">{{ Auth::user()->nombre_usuario }}</span>
          <span class="text-xs text-gray-400">{{ ucfirst(Auth::user()->rol) }}</span>
          <form method="POST" action="{{ route('logout') }}" class="mt-1">
            @csrf
            <button type="submit" class="text-xs text-gray-400 hover:underline">Salir</button>
          </form>
        </div>
      </div>
    </div>
  </aside>
  <div class="flex-1 flex flex-col overflow-hidden">
    <header class="bg-white shadow px-6 py-4 flex items-center justify-between">
      <h1 class="text-2xl font-semibold text-gray-800">@yield('title')</h1>
      @yield('breadcrumbs')
    </header>
    <main class="flex-1 overflow-auto p-6">
      @yield('content')
    </main>
  </div>
</body>
</html>
