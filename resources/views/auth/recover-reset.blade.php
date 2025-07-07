<x-guest-layout>
    <div class="mb-4 text-sm text-gray-700">
        Ingresa tu nueva contraseña.
    </div>

    <form method="POST" action="{{ route('recover.reset.submit', $user->ci_usuario) }}">
        @csrf

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">
                Nueva contraseña
            </label>
            <input id="password" name="password" type="password" required
                   autocomplete="new-password"
                   class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
            @error('password')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                Confirmar contraseña
            </label>
            <input id="password_confirmation" name="password_confirmation" type="password" required
                   autocomplete="new-password"
                   class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Guardar nueva contraseña
            </button>
        </div>
    </form>
</x-guest-layout>
