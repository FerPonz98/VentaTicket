{{-- resources/views/auth/login.blade.php --}}


<x-guest-layout>
    
    <div class="w-full max-w-sm p-5 bg-white rounded-lg shadow-lg">
      
      {{-- Logo de la empresa --}}
      <img
        src="{{ asset('img/logo-empresa.jpg') }}"
        alt="Logotipo Empresa"
        class="h-20 mx-auto mb-6"
      />

      {{-- Cabecera --}}
      <h2 class="text-center text-2xl font-bold text-gray-800 mb-1">Bienvenido</h2>
      <p class="text-center text-gray-600 mb-6">Inicia sesión con tu CI</p>

      <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- CI --}}
        <div class="mb-4">
          <label for="ci_usuario" class="block text-sm font-medium text-gray-700">CI</label>
          <input
            id="ci_usuario"
            name="ci_usuario"
            type="text"
            required
            autofocus
            autocomplete="username"
            class="mt-1 block w-full bg-white text-black border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            value="{{ old('ci_usuario') }}"
          />
          @error('ci_usuario')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Contraseña --}}
        <div class="mb-4">
          <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
          <input
            id="password"
            name="password"
            type="password"
            required
            autocomplete="current-password"
            class="mt-1 block w-full bg-white text-black border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
          />
          @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        {{-- Recordarme + Olvidé contraseña --}}
        <div class="flex items-center justify-between mb-6">
          <label class="inline-flex items-center">
            <input
              id="remember_me"
              name="remember"
              type="checkbox"
              class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
            />
            <span class="ml-2 text-sm text-gray-600">Recuérdame</span>
          </label>

          @if (Route::has('password.request'))
            <a
              href="{{ route('password.request') }}"
              class="text-sm text-indigo-600 hover:underline"
            >
              ¿Olvidaste tu contraseña?
            </a>
          @endif
        </div>

        {{-- Botón Acceder --}}
        <button
          type="submit"
          class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
        >
          Acceder
        </button>
      </form>
    </div>
  </div>
  
</x-guest-layout>
