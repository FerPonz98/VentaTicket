{{-- resources/views/auth/login.blade.php --}}
<x-guest-layout>
 
    <div class="w-full max-w-sm p-5 bg-white rounded-lg shadow-lg">
      <!-- Logo de la empresa -->
      <div class="flex justify-center mb-6">
        <img src="{{ asset('img/logo-empresa.jpg') }}" alt="Logotipo Empresa" class="h-20">
      </div>

      <!-- Cabecera -->
      <h2 class="text-center text-2xl font-bold text-gray-800 mb-1">Bienvenido</h2>
      <p class="text-center text-gray-600 mb-6">Inicia sesión con tu CI</p>

      <!-- Mensaje genérico (status) -->
      @if(session('status'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
          {{ session('status') }}
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- CI -->
        <div class="mb-4">
          <label for="ci_usuario" class="block text-sm font-medium text-gray-700">CI</label>
          <input
            id="ci_usuario"
            name="ci_usuario"
            type="text"
            required
            autofocus
            autocomplete="username"
            class="mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            value="{{ old('ci_usuario') }}"
          />
          @error('ci_usuario')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
          @error('email')
            {{-- our “cuenta inactiva” or other generic error --}}
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Contraseña -->
        <div class="mb-4">
          <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
          <input
            id="password"
            name="password"
            type="password"
            required
            autocomplete="current-password"
            class="mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
          />
          @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Recordarme + Olvidé contraseña -->
        <div class="flex items-center justify-between mb-6">
          <label class="inline-flex items-center">
            <input
              id="remember_me"
              name="remember"
              type="checkbox"
              class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
            />
            <span class="ml-2 text-sm text-gray-600">Recuérdame</span>
          </label>

          @if(Route::has('recover.form'))
            <a href="{{ route('recover.form') }}" class="text-sm text-indigo-600 hover:underline">
              ¿Olvidaste tu contraseña?
            </a>
          @endif
        </div>

        <!-- Botón Acceder -->
        <button
          type="submit"
          class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition"
        >
          Acceder
        </button>
      </form>
    </div>
  </div>
</x-guest-layout>
