<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- CI Usuario -->
        <div>
            <x-input-label for="ci_usuario" :value="__('CI Usuario')" />
            <x-text-input id="ci_usuario" class="block mt-1 w-full"
                type="text"
                name="ci_usuario"
                :value="old('ci_usuario')"
                required autofocus autocomplete="ci_usuario" />
            <x-input-error :messages="$errors->get('ci_usuario')" class="mt-2" />
        </div>

        <!-- Nombre de Usuario -->
        <div class="mt-4">
            <x-input-label for="nombre_usuario" :value="__('Nombre de Usuario')" />
            <x-text-input id="nombre_usuario" class="block mt-1 w-full"
                type="text"
                name="nombre_usuario"
                :value="old('nombre_usuario')"
                required autocomplete="nombre_usuario" />
            <x-input-error :messages="$errors->get('nombre_usuario')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input id="email" class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Contraseña -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmar Contraseña -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Pregunta Secreta -->
        <div class="mt-4">
            <x-input-label for="security_question" :value="__('Pregunta Secreta')" />
            <x-text-input id="security_question" class="block mt-1 w-full"
                type="text"
                name="security_question"
                :value="old('security_question')"
                required />
            <x-input-error :messages="$errors->get('security_question')" class="mt-2" />
        </div>

        <!-- Respuesta Secreta -->
        <div class="mt-4">
            <x-input-label for="security_answer" :value="__('Respuesta Secreta')" />
            <x-text-input id="security_answer" class="block mt-1 w-full"
                type="password"
                name="security_answer"
                required />
            <x-input-error :messages="$errors->get('security_answer')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
               href="{{ route('login') }}">
                {{ __('¿Ya estás registrado?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Registrar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
