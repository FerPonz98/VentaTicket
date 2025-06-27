{{-- resources/views/rutas/create.blade.php --}}
@extends('layouts.app')

@section('title','Crear Ruta')

@section('content')
  <a href="{{ route('rutas.index') }}"
     class="inline-block text-indigo-600 hover:text-indigo-800 underline mb-4">
    &larr; Volver al listado
  </a>

  <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold text-black mb-6">Nueva Ruta</h2>

    @if($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded mb-6">
        <ul class="list-disc list-inside">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('rutas.store') }}" method="POST" class="space-y-6">
      @csrf

      {{-- Origen y Destino --}}
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label for="origen" class="block mb-1 text-black font-medium">Origen*</label>
          <input id="origen" name="origen" type="text" value="{{ old('origen') }}" required
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-black">
          @error('origen')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
        <div>
          <label for="destino" class="block mb-1 text-black font-medium">Destino*</label>
          <input id="destino" name="destino" type="text" value="{{ old('destino') }}" required
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-black">
          @error('destino')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
      </div>


      {{-- Tarifas y Recargos --}}
      <div class="grid grid-cols-2 gap-4">
        <!-- Precio Bus Normal -->
        <div>
          <label class="block mb-1 text-black font-medium">Precio Bus Normal*</label>
          <input name="precio_bus_normal" type="number" step="0.01" min="0" value="{{ old('precio_bus_normal',0) }}" required
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-black">
          @error('precio_bus_normal')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
        <!-- Recargo Un Piso Semicama -->
        <div>
          <label class="block mb-1 text-black font-medium">Recargo Un Piso Semicama*</label>
          <input name="recargo_bus_1piso_ac" type="number" step="0.01" min="0" value="{{ old('recargo_bus_1piso_ac',0) }}" required
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-black">
          @error('recargo_bus_1piso_ac')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
        <!-- Recargo Doble Semicama -->
        <div>
          <label class="block mb-1 text-black font-medium">Recargo Doble Semicama*</label>
          <input name="recargo_bus_doble_piso" type="number" step="0.01" min="0" value="{{ old('recargo_bus_doble_piso',0) }}" required
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-black">
          @error('recargo_bus_doble_piso')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
        <!-- Descuento 3ra Edad -->
        <div>
          <label class="block mb-1 text-black font-medium">Descuento 3ra Edad*</label>
          <input name="descuento_3ra_edad" type="number" step="0.01" min="0" value="{{ old('descuento_3ra_edad',0) }}" required
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-black">
          @error('descuento_3ra_edad')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
        <!-- Precio Cortesía -->
        <div>
          <label class="block mb-1 text-black font-medium">Precio Cortesía*</label>
          <input name="precio_cortesia" type="number" step="0.01" min="0" value="{{ old('precio_cortesia',0) }}" required
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-black">
          @error('precio_cortesia')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
        <!-- Descuento Discapacidad -->
        <div>
          <label class="block mb-1 text-black font-medium">Descuento Discapacidad*</label>
          <input name="descuento_discapacidad" type="number" step="0.01" min="0" value="{{ old('descuento_discapacidad',0) }}" required
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-black">
          @error('descuento_discapacidad')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
        <!-- Descuento 2 -->
        <div>
          <label class="block mb-1 text-black font-medium">Descuento 2</label>
          <input name="descuento_2" type="number" step="0.01" min="0" value="{{ old('descuento_2',0) }}"
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-black">
          @error('descuento_2')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
        <!-- Descuento 3 -->
        <div>
          <label class="block mb-1 text-black font-medium">Descuento 3</label>
          <input name="descuento_3" type="number" step="0.01" min="0" value="{{ old('descuento_3',0) }}"
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-black">
          @error('descuento_3')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
      </div>

      {{-- Precio de Encomienda y Carga --}}
<div class="grid grid-cols-2 gap-4">
  <div>
    <label class="block mb-1 text-black font-medium">Precio Encomienda (Bs.)*</label>
    <input name="precio_encomienda" type="number" step="0.01" min="0"
           value="{{ old('precio_encomienda',0) }}" required
           class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-black">
    @error('precio_encomienda')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
  </div>
  <div>
    <label class="block mb-1 text-black font-medium">Precio Carga (Bs.)*</label>
    <input name="precio_carga" type="number" step="0.01" min="0"
           value="{{ old('precio_carga',0) }}" required
           class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-black">
    @error('precio_carga')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
  </div>
</div>

   {{-- Paradas Dinámicas --}}
      <div>
        <h3 class="text-lg font-medium text-black mb-2">Paradas y Precios de Tramo</h3>
        <div class="overflow-x-auto">
          <table class="w-full border-collapse border">
            <thead>
              <tr class="bg-gray-100">
                <th class="p-2 border text-gray-900">#</th>
                <th class="p-2 border text-gray-600">Parada</th>
                <th class="p-2 border text-gray-600">Precio Pasaje</th>
                <th class="p-2 border text-gray-600">Encomienda (Bs.)</th>
                <th class="p-2 border text-gray-600">Carga (Bs.)</th>
                <th class="p-2 border text-center text-gray-600">Acción</th>
              </tr>
            </thead>
            <tbody id="rows"></tbody>
          </table>
        </div>
        <button type="button" id="add-row" class="mt-2 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
          + Añadir parada
        </button>
      </div>

      <div>
        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 rounded">
          Crear Ruta
        </button>
      </div>
    </form>
  </div>

  <template id="row-template">
    <tr class="border-t">
      <td class="p-2 text-center text-gray-900 row-index">1</td>
      <td class="p-2"><input type="text" name="paradas[0][nombre]" required class="w-full bg-gray-50 border border-gray-300 rounded px-2 py-1 text-black"></td>
      <td class="p-2"><input type="number" name="paradas[0][precio_pasaje]" step="0.01" min="0" required class="w-full bg-gray-50 border border-gray-300 rounded px-2 py-1 text-black"></td>
      <td class="p-2"><input type="number" name="paradas[0][precio_encomienda_parada]" step="0.01" min="0" required class="w-full bg-gray-50 border border-gray-300 rounded px-2 py-1 text-black"></td>
      <td class="p-2"><input type="number" name="paradas[0][precio_carga_parada]" step="0.01" min="0" required class="w-full bg-gray-50 border border-gray-300 rounded px-2 py-1 text-black"></td>
      <td class="p-2 text-center"><button type="button" class="remove-row px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">Eliminar</button></td>
    </tr>
  </template>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const addBtn = document.getElementById('add-row');
      const rows   = document.getElementById('rows');
      const tpl    = document.getElementById('row-template').content;

      function updateIndexes() {
        rows.querySelectorAll('tr').forEach((tr, i) => {
          tr.querySelector('.row-index').textContent = i + 1;
          tr.querySelectorAll('input').forEach(input => {
            const field = input.getAttribute('name').match(/paradas\[(\d+)\]\[([a-z_]+)\]/)[2];
            input.setAttribute('name', `paradas[${i}][${field}]`);
          });
        });
      }

      addBtn.addEventListener('click', () => {
        const clone = document.importNode(tpl, true);
        clone.querySelector('.remove-row').addEventListener('click', e => {
          e.target.closest('tr').remove();
          updateIndexes();
        });
        rows.appendChild(clone);
        updateIndexes();
      });
      addBtn.click();
    });
  </script>
@endsection
