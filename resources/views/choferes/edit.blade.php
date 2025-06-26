{{-- resources/views/buses/edit.blade.php --}}
@extends('layouts.app')

@section('title','Editar Bus')

@section('content')
  {{-- Volver al listado --}}
  <a href="{{ route('buses.index') }}"
     class="inline-block text-indigo-600 hover:text-indigo-800 underline mb-4">
    &larr; Volver al listado
  </a>

  <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Editar Bus</h2>

    <form action="{{ route('buses.update', $bus) }}" method="POST" class="space-y-6">
      @csrf
      @method('PATCH') {{-- clave para que Laravel reconozca PATCH --}}

      {{-- Código --}}
      <div>
        <label for="codigo" class="block mb-1 text-gray-700 font-medium">Código*</label>
        <input
          id="codigo"
          name="codigo"
          type="text"
          value="{{ old('codigo', $bus->codigo) }}"
          required
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500"
        />
        @error('codigo')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
      </div>

      {{-- Placa --}}
      <div>
        <label for="placa" class="block mb-1 text-gray-700 font-medium">Placa*</label>
        <input
          id="placa"
          name="placa"
          type="text"
          value="{{ old('placa', $bus->placa) }}"
          required
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500"
        />
        @error('placa')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
      </div>

      {{-- Tipo de Bus --}}
      <div>
        <label for="tipo_de_bus" class="block mb-1 text-gray-700 font-medium">Tipo de Bus*</label>
        <select id="tipo_de_bus" name="tipo_de_bus" required
                class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500">
          <option value="">-- Seleccione --</option>
          <option value="Un piso"    {{ old('tipo_de_bus', $bus->tipo_de_bus)=='Un piso'    ? 'selected':'' }}>Un piso</option>
          <option value="Doble piso" {{ old('tipo_de_bus', $bus->tipo_de_bus)=='Doble piso' ? 'selected':'' }}>Doble piso</option>
        </select>
        @error('tipo_de_bus')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
      </div>

      {{-- Asientos Piso 1 --}}
      <div>
        <label for="asientos_piso1" class="block mb-1 text-gray-700 font-medium">Asientos Piso 1*</label>
        <input
          id="asientos_piso1"
          name="asientos_piso1"
          type="number"
          min="1"
          value="{{ old('asientos_piso1', $bus->asientos_piso1) }}"
          required
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500"
        />
        @error('asientos_piso1')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
      </div>

      {{-- Asientos Piso 2 --}}
      <div id="asientos_piso2_div">
        <label for="asientos_piso2" class="block mb-1 text-gray-700 font-medium">Asientos Piso 2*</label>
        <input
          id="asientos_piso2"
          name="asientos_piso2"
          type="number"
          min="0"
          value="{{ old('asientos_piso2', $bus->asientos_piso2) }}"
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500"
        />
        @error('asientos_piso2')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
      </div>

      {{-- Tipo de Asiento --}}
      <div>
        <label for="tipo_asiento" class="block mb-1 text-gray-700 font-medium">Tipo de Asiento*</label>
        <select id="tipo_asiento" name="tipo_asiento" required
                class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500">
          <option value="">-- Seleccione --</option>
          <option value="Normal"         {{ old('tipo_asiento', $bus->tipo_asiento)=='Normal'         ? 'selected':'' }}>Normal</option>
          <option value="Semicama"       {{ old('tipo_asiento', $bus->tipo_asiento)=='Semicama'       ? 'selected':'' }}>Semicama</option>
          <option value="Leito/Semicama" {{ old('tipo_asiento', $bus->tipo_asiento)=='Leito/Semicama' ? 'selected':'' }}>Leito/Semicama</option>
        </select>
        @error('tipo_asiento')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
      </div>

      {{-- Chofer --}}
      <div>
        <label for="chofer_id" class="block mb-1 text-gray-700 font-medium">Chofer*</label>
        <select id="chofer_id" name="chofer_id" required
                class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500">
          <option value="">-- Seleccione --</option>
          @foreach($choferes as $chofer)
            <option value="{{ $chofer->id }}"
              {{ old('chofer_id', $bus->chofer_id) == $chofer->id ? 'selected' : '' }}>
              {{ $chofer->fullname }}
            </option>
          @endforeach
        </select>
        @error('chofer_id')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
      </div>

      {{-- Botones --}}
      <div class="pt-4 flex gap-4">
        <a href="{{ route('buses.index') }}"
           class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 rounded text-center">
          Cancelar
        </a>
        <button type="submit"
                class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 rounded">
          Actualizar
        </button>
      </div>
    </form>
  </div>

  {{-- Script para mostrar/ocultar asientos piso 2 --}}
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const tipo = document.getElementById('tipo_de_bus');
      const piso2 = document.getElementById('asientos_piso2_div');
      const toggle = () => piso2.style.display = (tipo.value==='Doble piso'? 'block':'none');
      tipo.addEventListener('change', toggle);
      toggle();
    });
  </script>
@endsection