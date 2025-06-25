@extends('layouts.app')

@section('title','Crear Ruta')

@section('content')
  {{-- Botón de volver al listado --}}
  <a href="{{ route('rutas.index') }}"
     class="inline-block text-indigo-600 hover:text-indigo-800 underline ">
    &larr; Volver al listado
  </a>

  <div class="mt-6 flex justify-center">
    <div class="w-full max-w-3xl bg-white p-6 rounded-lg shadow">
      <h2 class="text-2xl font-semibold text-gray-800 mb-6">Nueva Ruta</h2>

      @if($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-800 p-4 rounded">
          <ul class="list-disc list-inside">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('rutas.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
          <label class="block mb-1 text-gray-700">Origen</label>
          <input name="origen" value="{{ old('origen') }}" placeholder="p.ej. Santa Cruz"
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
                 required />
        </div>

        <div>
          <label class="block mb-1 text-gray-700">Destino</label>
          <input name="destino" value="{{ old('destino') }}" placeholder="p.ej. Cochabamba"
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
                 required />
        </div>

        <div>
          <label class="block mb-1 text-gray-700">Hora de salida (origen)</label>
          <input type="time" name="hora_salida_origen" value="{{ old('hora_salida_origen') }}"
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
                 required />
        </div>

        <h3 class="text-lg font-medium text-gray-700">Tarifas Generales</h3>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block mb-1 text-gray-700">Precio Base (Normal)</label>
            <input type="number" step="0.1" name="precio_base" value="{{ old('precio_base') }}"
                   class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
                   required />
          </div>
          <div>
            <label class="block mb-1 text-gray-700">Recargo Doble Piso A/C Semicama</label>
            <input type="number" step="0.1" name="recargo_doble_semicama" value="{{ old('recargo_doble_semicama') }}"
                   class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
                   required />
          </div>
          <div>
            <label class="block mb-1 text-gray-700">Recargo 1 Piso A/C Semicama</label>
            <input type="number" step="0.1" name="recargo_un_piso_semicama" value="{{ old('recargo_un_piso_semicama') }}"
                   class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
                   required />
          </div>
          <div>
            <label class="block mb-1 text-gray-700">Descuento 3ª Edad</label>
            <input type="number" step="0.1" name="descuento_3ra_edad" value="{{ old('descuento_3ra_edad') }}"
                   class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
                   required />
          </div>
          <div>
            <label class="block mb-1 text-gray-700">Precio Cortesía</label>
            <input type="number" step="0.1" name="precio_cortesia" value="{{ old('precio_cortesia') }}"
                   class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
                   required />
          </div>
          <div>
            <label class="block mb-1 text-gray-700">Precio Discapacidad</label>
            <input type="number" step="0.1" name="precio_discapacidad" value="{{ old('precio_discapacidad') }}"
                   class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
                   required />
          </div>
          <div>
            <label class="block mb-1 text-gray-700">Descuento 2</label>
            <input type="number" step="0.1" name="descuento2" value="{{ old('descuento2') }}"
                   class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
                   required />
          </div>
          <div>
            <label class="block mb-1 text-gray-700">Descuento 3</label>
            <input type="number" step="0.1" name="descuento3" value="{{ old('descuento3') }}"
                   class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
                   required />
          </div>
        </div>

        <h3 class="text-lg font-medium text-gray-700">Paradas Intermedias</h3>
        <div class="overflow-x-auto">
          <table class="w-full border-collapse">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-3 py-2 border text-gray-900">#</th>
                <th class="px-3 py-2 border text-gray-600">Parada</th>
                <th class="px-3 py-2 border text-gray-600">Hora</th>
                <th class="px-3 py-2 border text-gray-600">Precio Bs.</th>
                <th class="px-3 py-2 border text-gray-600">Acción</th>
              </tr>
            </thead>
            <tbody id="rows"></tbody>
          </table>
        </div>

        <button type="button" id="add-row"
                class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
          + Añadir parada
        </button>

        <div class="pt-6">
          <button type="submit"
                  class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 rounded">
            Guardar Ruta
          </button>
        </div>
      </form>
    </div>
  </div>

  <datalist id="stop-list">
    @foreach($stops as $s)
      <option value="{{ $s }}">
    @endforeach
  </datalist>

  <template id="row-template">
    <tr class="border-t hover:bg-gray-50">
      <td class="px-2 py-1 border text-center text-gray-900">
        <span class="row-index"></span>
        <input name="sequence[]" type="hidden" class="sequence-input">
      </td>
      <td class="px-2 py-1 border">
        <input name="stops[]" list="stop-list" placeholder="Parada"
               class="w-full bg-gray-50 border border-gray-300 rounded px-2 py-1 focus:ring-2 focus:ring-indigo-500 text-gray-900"
               required>
      </td>
      <td class="px-2 py-1 border">
        <input name="departure_time[]" type="time" value="00:00"
               class="w-24 bg-gray-50 border border-gray-300 rounded px-2 py-1 focus:ring-2 focus:ring-indigo-500 text-gray-900"
               required>
      </td>
      <td class="px-2 py-1 border">
        <input name="price[]" type="number" step="0.1" value="0.0"
               class="w-24 bg-gray-50 border border-gray-300 rounded px-2 py-1 focus:ring-2 focus:ring-indigo-500 text-gray-900"
               required>
      </td>
      <td class="px-2 py-1 border text-center">
        <button type="button"
                class="remove-row bg-red-500 hover:bg-red-600 text-white rounded px-2 py-1">–</button>
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

      // Filas iniciales
      addBtn.click();
      addBtn.click();
    });
  </script>
@endsection
