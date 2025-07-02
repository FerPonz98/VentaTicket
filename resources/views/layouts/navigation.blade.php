{{-- resources/views/layouts/navigation.blade.php --}}
<nav x-data="{ open: false, userMenuOpen: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16">
      {{-- Left: Logo + Links --}}
      <div class="flex">
        <div class="shrink-0 flex items-center">
          <a href="{{ route('dashboard') }}">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"/>
          </a>
        </div>
        <div class="hidden sm:-my-px sm:ml-10 sm:flex space-x-8">
          <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            Dashboard
          </x-nav-link>

          @auth
            @if(in_array(Auth::user()->rol, ['admin','supervisor gral','supervisor suc']))
              <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                Usuarios y Roles
              </x-nav-link>
            @endif

            @if(in_array(Auth::user()->rol, ['admin','supervisor gral','supervisor suc','cajero']))
              <x-nav-link :href="route('pasajes.index')" :active="request()->routeIs('pasajes.*')">
                Venta de Pasajes
              </x-nav-link>
            @endif

            @if(in_array(Auth::user()->rol, ['admin','supervisor gral','carga']))
              <x-nav-link :href="route('carga.index')" :active="request()->routeIs('carga.*')">
                Carga
              </x-nav-link>
            @endif

            @if(in_array(Auth::user()->rol, ['admin','supervisor gral','encomienda']))
              <x-nav-link :href="route('encomiendas.index')" :active="request()->routeIs('encomiendas.*')">
                Encomienda
              </x-nav-link>
            @endif

            @if(in_array(Auth::user()->rol, ['chofer','ayudante']))
              <x-nav-link :href="route('kardex.index')" :active="request()->routeIs('kardex.*')">
                Kardex
              </x-nav-link>
            @endif
          @endauth
        </div>
      </div>

      {{-- Right: User menu or auth links --}}
      <div class="hidden sm:flex sm:items-center sm:ml-6">
        @auth
          <div class="relative" x-data>
            <button @click="userMenuOpen = !userMenuOpen" class="flex items-center text-sm focus:outline-none">
              <span class="text-gray-800 dark:text-gray-200">{{ Auth::user()->nombre_usuario }}</span>
              <svg class="ml-1 h-4 w-4 fill-current text-gray-600 dark:text-gray-400" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0
                         111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                      clip-rule="evenodd" />
              </svg>
            </button>

            <div x-show="userMenuOpen" @click.away="userMenuOpen = false"
                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border rounded-md shadow-lg py-1 z-50">
              <a href="{{ route('profile.edit') }}"
                 class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                Perfil
              </a>

              <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                  Cerrar sesión
                </button>
              </form>
            </div>
          </div>
        @else
          <div class="space-x-4">
            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 hover:text-gray-900">
              Iniciar Sesión
            </a>
            <a href="{{ route('register') }}" class="text-sm text-gray-700 dark:text-gray-500 hover:text-gray-900">
              Registrarse
            </a>
          </div>
        @endauth
      </div>

      {{-- Mobile menu button --}}
      <div class="-mr-2 flex items-center sm:hidden">
        <button @click="open = ! open"
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500
                       hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900
                       focus:outline-none transition">
          <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path :class="{ 'hidden': open, 'inline-flex': !open }"
                  class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>
            <path :class="{ 'hidden': !open, 'inline-flex': open }"
                  class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
    </div>
  </div>

  {{-- Responsive navigation --}}
  <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
    <div class="pt-2 pb-3 space-y-1">
      <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        Dashboard
      </x-responsive-nav-link>
      @auth
        @if(in_array(Auth::user()->rol, ['admin','supervisor gral','supervisor suc']))
          <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
            Usuarios y Roles
          </x-responsive-nav-link>
        @endif
        @if(in_array(Auth::user()->rol, ['admin','supervisor gral','supervisor suc','cajero']))
          <x-responsive-nav-link :href="route('pasajes.index')" :active="request()->routeIs('pasajes.*')">
            Venta de Pasajes
          </x-responsive-nav-link>
        @endif
        @if(in_array(Auth::user()->rol, ['admin','supervisor gral','carga']))
          <x-responsive-nav-link :href="route('carga.index')" :active="request()->routeIs('carga.*')">
            Carga
          </x-responsive-nav-link>
        @endif
        @if(in_array(Auth::user()->rol, ['admin','supervisor gral','encomienda']))
          <x-responsive-nav-link :href="route('encomiendas.index')" :active="request()->routeIs('encomiendas.*')">
            Encomienda
          </x-responsive-nav-link>
        @endif
        @if(in_array(Auth::user()->rol, ['chofer','ayudante']))
          <x-responsive-nav-link :href="route('kardex.index')" :active="request()->routeIs('kardex.*')">
            Kardex
          </x-responsive-nav-link>
        @endif
      @endauth
    </div>

    {{-- Responsive User Menu --}}
    @auth
      <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
        <div class="px-4">
          <div class="font-medium text-base text-gray-800 dark:text-gray-200">
            {{ Auth::user()->nombre_usuario }}
          </div>
          <div class="font-medium text-sm text-gray-500">
            {{ Auth::user()->email }}
          </div>
        </div>
        <div class="mt-3 space-y-1">
          <a href="{{ route('profile.edit') }}"
             class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
            Perfil
          </a>
          <form method="POST" action="{{ url('/logout') }}">
            @csrf
            <button type="submit"
                    class="w-full text-left block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
              Cerrar sesión
            </button>
          </form>
        </div>
      </div>
    @else
      <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
        <div class="space-y-1 px-4">
          <a href="{{ route('login') }}"
             class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
            Iniciar Sesión
          </a>
          <a href="{{ route('register') }}"
             class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
            Registrarse
          </a>
        </div>
      </div>
    @endauth
  </div>
</nav>
