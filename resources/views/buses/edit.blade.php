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
      @csrf @method('PATCH')

      {{-- Código del bus --}}
      <div>
        <label for="codigo" class="block mb-1 text-gray-700 font-medium">Código*</label>
        <input
          id="codigo"
          name="codigo"
          type="text"
          value="{{ old('codigo', $bus->codigo) }}"
          required
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900"
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
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
        @error('placa')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
      </div>

      {{-- Tipo de Bus --}}
      <div>
        <label for="tipo_de_bus" class="block mb-1 text-gray-700 font-medium">Tipo de Bus*</label>
        <select id="tipo_de_bus" name="tipo_de_bus" required class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900">
          <option value="Un piso" {{ old('tipo_de_bus', $bus->tipo_de_bus)=='Un piso' ? 'selected':'' }}>Un piso</option>
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
          type="number" min="1"
          value="{{ old('asientos_piso1', $bus->asientos_piso1) }}"
          required
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
        @error('asientos_piso1')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
      </div>

      {{-- Asientos Piso 2 --}}
      <div id="asientos_piso2_div">
        <label for="asientos_piso2" class="block mb-1 text-gray-700 font-medium">Asientos Piso 2*</label>
        <input
          id="asientos_piso2"
          name="asientos_piso2"
          type="number" min="0"
          value="{{ old('asientos_piso2', $bus->asientos_piso2) }}"
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
        @error('asientos_piso2')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
      </div>

      {{-- Tipo de Asiento --}}
      <div>
        <label for="tipo_asiento" class="block mb-1 text-gray-700 font-medium">Tipo de Asiento*</label>
        <select id="tipo_asiento" name="tipo_asiento" required class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900">
          <option value="Normal" {{ old('tipo_asiento', $bus->tipo_asiento)=='Normal' ? 'selected':'' }}>Normal</option>
          <option value="Semicama" {{ old('tipo_asiento', $bus->tipo_asiento)=='Semicama' ? 'selected':'' }}>Semicama</option>
          <option value="Leito/Semicama" {{ old('tipo_asiento', $bus->tipo_asiento)=='Leito/Semicama' ? 'selected':'' }}>Leito/Semicama</option>
        </select>
        @error('tipo_asiento')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
      </div>

      {{-- Características --}}
      <div class="grid grid-cols-2 gap-4">
        <label class="inline-flex items-center">
          <input type="checkbox" name="aire_acondicionado" value="1" {{ old('aire_acondicionado', $bus->aire_acondicionado)?'checked':'' }} class="form-checkbox mr-2" />
          <span class="text-gray-700">A/C</span>
        </label>
        <label class="inline-flex items-center">
          <input type="checkbox" name="tv" value="1" {{ old('tv', $bus->tv)?'checked':'' }} class="form-checkbox mr-2" />
          <span class="text-gray-700">TV</span>
        </label>
        <label class="inline-flex items-center">
          <input type="checkbox" name="bano" value="1" {{ old('bano', $bus->bano)?'checked':'' }} class="form-checkbox mr-2" />
          <span class="text-gray-700">Baño</span>
        </label>
        <label class="inline-flex items-center">
          <input type="checkbox" name="carga_telefono" value="1" {{ old('carga_telefono', $bus->carga_telefono)?'checked':'' }} class="form-checkbox mr-2" />
          <span class="text-gray-700">Carga Teléfono</span>
        </label>
      </div>

      {{-- Vencimientos --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="soat_vencimiento" class="block mb-1 text-gray-700 font-medium">Vencimiento SOAT</label>
          <input id="soat_vencimiento" name="soat_vencimiento" type="date" value="{{ old('soat_vencimiento', $bus->soat_vencimiento?->format('Y-m-d')) }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900" />
          @error('soat_vencimiento')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>

        <div>
          <label for="rev_tecnica_vencimiento" class="block mb-1 text-gray-700 font-medium">Venc. Revisión Técnica</label>
          <input id="rev_tecnica_vencimiento" name="rev_tecnica_vencimiento" type="date" value="{{ old('rev_tecnica_vencimiento', $bus->rev_tecnica_vencimiento?->format('Y-m-d')) }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900" />
          @error('rev_tecnica_vencimiento')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="sm:col-span-2">
          <label for="tarjeta_operacion_vencimiento" class="block mb-1 text-gray-700 font-medium">Venc. Tarjeta Operación</label>
          <input id="tarjeta_operacion_vencimiento" name="tarjeta_operacion_vencimiento" type="date" value="{{ old('tarjeta_operacion_vencimiento', $bus->tarjeta_operacion_vencimiento?->format('Y-m-d')) }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900" />
          @error('tarjeta_operacion_vencimiento')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
      </div>

      {{-- Marca / Modelo --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label for="marca" class="block mb-1 text-gray-700 font-medium">Marca*</label>
          <input id="marca" name="marca" type="text" value="{{ old('marca', $bus->marca) }}" required class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900" />
          @error('marca')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>

        <div>
          <label for="modelo" class="block mb-1 text-gray-700 font-medium">Modelo</label>
          <input id="modelo" name="modelo" type="text" value="{{ old('modelo', $bus->modelo) }}" class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900" />
          @error('modelo')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
      </div>

      {{-- Chofer --}}
      <div>
        <label for="chofer_id" class="block mb-1 text-gray-700 font-medium">Chofer*</label>
        <select id="chofer_id" name="chofer_id" required class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900">
          @foreach($choferes as $c)
            <option value="{{ $c->id }}" {{ old('chofer_id', $bus->chofer_id)==$c->id?'selected':'' }}>{{ $c->nombre_chofer }}</option>
          @endforeach
        </select>
        @error('chofer_id')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
      </div>

      {{-- Botones --}}
      <div class="pt-4 flex gap-4">
        <a href="{{ route('buses.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 rounded text-center">
          Cancelar
        </a>
        <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 rounded">
          Actualizar
        </button>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const tipoSelect = document.getElementById('tipo_de_bus');
      const asientos2Div = document.getElementById('asientos_piso2_div');

      function toggleAsientos2() {
        asientos2Div.style.display = tipoSelect.value === 'Doble piso' ? 'block' : 'none';
      }

      tipoSelect.addEventListener('change', toggleAsientos2);
      toggleAsientos2();
    });
  </script>
@endsection
