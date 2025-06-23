<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Responde la pregunta secreta para recuperar tu contraseña.
    </div>

    <form method="POST" action="{{ route('recover.answer.validate', $user->ci_usuario) }}">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Pregunta secreta:</label>
            <div class="mt-1 font-semibold text-gray-800">
                @if($user->security_question === 'color')
                    ¿Cuál es tu color favorito?
                @elseif($user->security_question === 'mascota')
                    ¿Cómo se llamaba tu primera mascota?
                @elseif($user->security_question === 'ciudad')
                    ¿Dónde naciste?
                @else
                    Pregunta no definida
                @endif
            </div>
        </div>

        <div class="mb-4">
            <label for="security_answer" class="block font-medium text-sm text-gray-700">
                Tu respuesta
            </label>
            <input id="security_answer" name="security_answer" type="text" required
               class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-2">
            @error('security_answer')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Validar respuesta
            </button>
        </div>
    </form>
</x-guest-layout>
