{{-- resources/views/rutas/create.blade.php --}}
@extends('layouts.app')

@section('title','Crear Ruta')

@section('content')
  <a href="{{ route('rutas.index') }}"
     class="inline-block text-indigo-600 hover:text-indigo-800 underline mb-4">
    &larr; Volver al listado
  </a>

  <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Nueva Ruta</h2>

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

      <div>
        <label for="hora_salida" class="block mb-1 text-gray-700 font-medium">
          Hora de Salida (Origen)*
        </label>
        <input
          id="hora_salida"
          name="hora_salida"
          type="time"
          value="{{ old('hora_salida') }}"
          required
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500"
        />
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block mb-1 text-gray-700 font-medium">Precio Normal*</label>
          <input name="precio_base" type="number" step="0.01" value="{{ old('precio_base',0) }}"
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500" required>
        </div>
        <div>
          <label class="block mb-1 text-gray-700 font-medium">Recargo Doble Piso*</label>
          <input name="recargo_doble_semicama" type="number" step="0.01" value="{{ old('recargo_doble_semicama',0) }}"
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500" required>
        </div>
        <div>
          <label class="block mb-1 text-gray-700 font-medium">Recargo 1 Piso*</label>
          <input name="recargo_un_piso_semicama" type="number" step="0.01" value="{{ old('recargo_un_piso_semicama',0) }}"
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500" required>
        </div>
        <div>
          <label class="block mb-1 text-gray-700 font-medium">Descuento 3ª Edad*</label>
          <input name="descuento_3ra_edad" type="number" step="0.01" value="{{ old('descuento_3ra_edad',0) }}"
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500" required>
        </div>
        <div>
          <label class="block mb-1 text-gray-700 font-medium">Cortesía*</label>
          <input name="precio_cortesia" type="number" step="0.01" value="{{ old('precio_cortesia',0) }}"
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500" required>
        </div>
        <div>
          <label class="block mb-1 text-gray-700 font-medium">Discapacidad*</label>
          <input name="precio_discapacidad" type="number" step="0.01" value="{{ old('precio_discapacidad',0) }}"
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500" required>
        </div>
        <div>
          <label class="block mb-1 text-gray-700 font-medium">Descuento 2*</label>
          <input name="descuento2" type="number" step="0.01" value="{{ old('descuento2',0) }}"
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500" required>
        </div>
        <div>
          <label class="block mb-1 text-gray-700 font-medium">Descuento 3*</label>
          <input name="descuento3" type="number" step="0.01" value="{{ old('descuento3',0) }}"
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500" required>
        </div>
      </div>

      <div>
        <h3 class="text-lg font-medium text-gray-700 mb-2">Paradas y Precios</h3>
        <div class="overflow-x-auto">
          <table class="w-full border-collapse border">
            <thead>
              <tr class="bg-gray-100">
                <th class="p-2 border text-gray-900">#</th>
                <th class="p-2 border text-gray-600">Parada</th>
                <th class="p-2 border text-gray-600">Hora</th>
                <th class="p-2 border text-gray-600">Precio Bs.</th>
                <th class="p-2 border text-gray-600 text-center">Acción</th>
              </tr>
            </thead>
            <tbody id="rows"></tbody>
          </table>
        </div>
        <button
          type="button"
          id="add-row"
          class="mt-2 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
        >
          + Añadir parada
        </button>
      </div>

      <div>
        <button
          type="submit"
          class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 rounded"
        >
          Crear Ruta
        </button>
      </div>
    </form>
  </div>

  <datalist id="stop-list">
    @foreach($stops as $stop)
      <option value="{{ $stop }}"></option>
    @endforeach
  </datalist>

  <template id="row-template">
    <tr>
      <td class="p-2 border text-center text-gray-900">
        <span class="row-index"></span>
        <input name="sequence[]" type="hidden" class="sequence-input">
      </td>
      <td class="p-2 border">
        <input
          name="stops[]"
          list="stop-list"
          placeholder="Escribe o elige parada"
          class="w-full p-1 border rounded"
        >
      </td>
      <td class="p-2 border">
        <input
          name="departure_time[]"
          type="time"
          value="00:00"
          class="w-24 p-1 border rounded"
        >
      </td>
      <td class="p-2 border">
        <input
          name="price[]"
          type="number"
          step="0.01"
          value="0.00"
          class="w-20 p-1 border rounded"
        >
      </td>
      <td class="p-2 border text-center">
        <button
          type="button"
          class="remove-row px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600"
        >–</button>
      </td>
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
          tr.querySelector('.sequence-input').value = i + 1;
        });
      }

      addBtn.addEventListener('click', () => {
        const clone = document.importNode(tpl, true);
        clone.querySelector('.remove-row')
             .addEventListener('click', e => {
               e.target.closest('tr').remove();
               updateIndexes();
             });
        rows.appendChild(clone);
        updateIndexes();
      });

      addBtn.click();
      addBtn.click();
    });
  </script>
@endsection
