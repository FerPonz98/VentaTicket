{{-- resources/views/rutas/edit.blade.php --}}
@extends('layouts.app')

@section('title','Editar Ruta')

@section('content')
  <a href="{{ route('rutas.index') }}"
     class="inline-block text-indigo-600 hover:text-indigo-800 underline mb-4">
    &larr; Volver al listado
  </a>

  <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Editar Ruta</h2>

    @if($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded mb-6">
        <ul class="list-disc list-inside">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('rutas.update', $ruta) }}" method="POST" class="space-y-6">
      @csrf @method('PATCH')

      {{-- Origen y Destino --}}
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label for="origen" class="block mb-1 text-gray-700 font-medium">Origen*</label>
          <input id="origen" name="origen" type="text" value="{{ old('origen', $ruta->origen) }}" required
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-gray-900 focus:ring-2 focus:ring-indigo-500">
          @error('origen')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
        <div>
          <label for="destino" class="block mb-1 text-gray-700 font-medium">Destino*</label>
          <input id="destino" name="destino" type="text" value="{{ old('destino', $ruta->destino) }}" required
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-gray-900 focus:ring-2 focus:ring-indigo-500">
          @error('destino')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
      </div>



      {{-- Tarifas Generales --}}
      <div class="grid grid-cols-2 gap-4">
        @foreach([
          ['label'=>'Precio Bus Normal','name'=>'precio_bus_normal'],
          ['label'=>'Recargo Un Piso Semicama','name'=>'recargo_bus_1piso_ac'],
          ['label'=>'Recargo Doble Semicama','name'=>'recargo_bus_doble_piso'],
          ['label'=>'Recargo Semicama','name'=>'recargo_semicama'],
          ['label'=>'Descuento 3ra Edad','name'=>'descuento_3ra_edad'],
          ['label'=>'Precio Cortesía','name'=>'precio_cortesia'],
          ['label'=>'Descuento Discapacidad','name'=>'descuento_discapacidad'],
          ['label'=>'Descuento 2','name'=>'descuento_2'],
          ['label'=>'Descuento 3','name'=>'descuento_3'],
        ] as $field)
          <div>
            <label class="block mb-1 text-gray-700 font-medium">{{ $field['label'] }}*</label>
            <input name="{{ $field['name'] }}" type="number" step="0.01" min="0"
                   value="{{ old($field['name'], $ruta->{$field['name']} ?? 0) }}" required
                   class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-gray-900 focus:ring-2 focus:ring-indigo-500">
            @error($field['name'])<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
          </div>
        @endforeach
      </div>

      {{-- Precios Encomienda/Carga Ruta --}}
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block mb-1 text-gray-700 font-medium">Precio Encomienda (Bs.)*</label>
          <input name="precio_encomienda" type="number" step="0.01" min="0"
                 value="{{ old('precio_encomienda', $ruta->precio_encomienda) }}" required
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-gray-900 focus:ring-2 focus:ring-indigo-500">
          @error('precio_encomienda')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block mb-1 text-gray-700 font-medium">Precio Carga (Bs.)*</label>
          <input name="precio_carga" type="number" step="0.01" min="0"
                 value="{{ old('precio_carga', $ruta->precio_carga) }}" required
                 class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 text-gray-900 focus:ring-2 focus:ring-indigo-500">
          @error('precio_carga')<p class="mt-1 text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
      </div>

      {{-- Paradas Dinámicas --}}
      <div>
        <h3 class="text-lg font-medium text-gray-700 mb-2">Paradas de Tramo</h3>
        <div class="overflow-x-auto">
          <table class="w-full border-collapse border">
            <thead>
              <tr class="bg-gray-100">
                <th class="p-2 border text-gray-900">#</th>
                <th class="p-2 border text-gray-700">Parada</th>
                <th class="p-2 border text-gray-700">Pasaje (Bs.)</th>
                <th class="p-2 border text-gray-700">Encomienda (Bs.)</th>
                <th class="p-2 border text-gray-700">Carga (Bs.)</th>
                <th class="p-2 border text-center text-gray-600">Acción</th>
              </tr>
            </thead>
            <tbody id="rows">
              @php $paradas = old('paradas', $ruta->paradas ?? []); @endphp
              @foreach($paradas as $i => $p)
                <tr class="border-t">
                  <td class="p-2 text-center text-gray-900"><span class="row-index"></span></td>
                  <td class="p-2">
                    <input name="paradas[{{ $i }}][nombre]" type="text" required
                           value="{{ $p['nombre'] }}"
                           class="w-full bg-gray-50 border border-gray-300 rounded px-2 py-1 text-gray-900">
                  </td>
                  <td class="p-2">
                    <input name="paradas[{{ $i }}][precio_pasaje]" type="number" step="0.01" min="0" required
                           value="{{ $p['precio_pasaje'] ?? $p['precio'] ?? '' }}"
                           class="w-full bg-gray-50 border border-gray-300 rounded px-2 py-1 text-gray-900">
                  </td>
                  <td class="p-2">
                    <input name="paradas[{{ $i }}][precio_encomienda_parada]" type="number" step="0.01" min="0" required
                           value="{{ $p['precio_encomienda_parada'] ?? '' }}"
                           class="w-full bg-gray-50 border border-gray-300 rounded px-2 py-1 text-gray-900">
                  </td>
                  <td class="p-2">
                    <input name="paradas[{{ $i }}][precio_carga_parada]" type="number" step="0.01" min="0" required
                           value="{{ $p['precio_carga_parada'] ?? '' }}"
                           class="w-full bg-gray-50 border border-gray-300 rounded px-2 py-1 text-gray-900">
                  </td>
                  <td class="p-2 text-center">
                    <button type="button" class="remove-row px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">&minus;</button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <button type="button" id="add-row" class="mt-2 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
          + Añadir parada
        </button>
      </div>

      <div>
        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 rounded">
          Guardar cambios
        </button>
      </div>
    </form>
  </div>

  <template id="row-template">
    <tr class="border-t">
      <td class="p-2 text-center text-gray-900"><span class="row-index"></span></td>
      <td class="p-2"><input name="paradas[0][nombre]" type="text" required class="w-full bg-gray-50 border border-gray-300 rounded px-2 py-1 text-gray-900"></td>

      <td class="p-2"><input name="paradas[0][precio_pasaje]" type="number" step="0.01" min="0" required class="w-full bg-gray-50 border border-gray-300 rounded px-2 py-1 text-gray-900"></td>
      <td class="p-2"><input name="paradas[0][precio_encomienda_parada]" type="number" step="0.01" min="0" required class="w-full bg-gray-50 border border-gray-300 rounded px-2 py-1 text-gray-900"></td>
      <td class="p-2"><input name="paradas[0][precio_carga_parada]" type="number" step="0.01" min="0" required class="w-full bg-gray-50 border border-gray-300 rounded px-2 py-1 text-gray-900"></td>
      <td class="p-2 text-center"><button type="button" class="remove-row px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">&minus;</button></td>
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
            const match = input.name.match(/paradas\[(\d+)\]\[([^\]]+)\]/);
            if (match) input.name = `paradas[${i}][${match[2]}]`;
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

      rows.querySelectorAll('.remove-row').forEach(btn => btn.addEventListener('click', e => {
        e.target.closest('tr').remove(); updateIndexes();
      }));

      updateIndexes();
    });
  </script>
@endsection
