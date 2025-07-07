<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Ingresa tu número de CI para recuperar tu contraseña.
    </div>

    <form method="POST" action="{{ route('recover.check') }}">
        @csrf

        <div>
            
            <label for="ci_usuario" class="block font-medium text-sm text-gray-700">
                CI del usuario
            </label>
            <input id="ci_usuario" name="ci_usuario" type="text" required autofocus
                autocomplete="off"
                class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-2">

            @error('ci_usuario')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex justify-end mt-4">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Ver pregunta secreta
            </button>
        </div>
    </form>
</x-guest-layout>
