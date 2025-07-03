@extends('layouts.app')

@section('title', 'Crear Encomienda')

@section('content')
  <a href="{{ route('encomiendas.index') }}"
     class="inline-block text-indigo-600 hover:text-indigo-800 underline mb-4">
    &larr; Volver al listado
  </a>
<div class="container mx-auto mt-8">
  <div class="bg-white shadow-lg rounded-lg p-6 overflow-x-auto">
    <h2 id="form_title" class="text-2xl font-bold text-black mb-4">
      Crear Encomienda
    </h2>

    @if($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <ul class="list-disc pl-5">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @php
      $paradasByViaje = $viajes->mapWithKeys(function($v) {
        // Si paradas ya es array (por cast), úsalo
        if (is_array($v->ruta->paradas)) {
          return [$v->id => array_map(
            fn($p) => is_array($p) ? ($p['nombre'] ?? '') : $p,
            $v->ruta->paradas
          )];
        }
        // Si paradas es colección, pluck
        if ($v->ruta->paradas instanceof \Illuminate\Support\Collection) {
          return [$v->id => $v->ruta->paradas->pluck('nombre')->toArray()];
        }
        // Si paradas es string JSON, decodifica
        if (is_string($v->ruta->paradas)) {
          $arr = json_decode($v->ruta->paradas, true) ?: [];
          return [$v->id => array_map(
            fn($p) => is_array($p) ? ($p['nombre'] ?? '') : $p,
            $arr
          )];
        }
        // Si es null u otro tipo, retorna array vacío
        return [$v->id => []];
      })->toArray();
    @endphp

    <form action="{{ route('encomiendas.store') }}" method="POST" class="space-y-6 text-black">
      @csrf
      <input type="hidden" name="cajero_id" value="{{ Auth::user()->ci_usuario }}">

      {{-- Guía / Estado --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-medium text-black">Nro de Guía</label>
          <input type="text" name="guia_numero" readonly
            value="E{{ now()->format('YmdHis') }}"
            class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black"/>
        </div>
        <div>
          <label class="block text-sm font-medium text-black">Estado</label>
          <select name="estado"
            class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black">
            <option value="por_pagar" {{ old('estado')=='por_pagar'?'selected':'' }}>Por Pagar</option>
            <option value="pagado"    {{ old('estado')=='pagado'   ?'selected':'' }}>Pagado</option>
          </select>
        </div>
      </div>

      {{-- Emitido por --}}
      <div>
        <label class="block text-sm font-medium text-black">Emitido por (Usuario)</label>
        <input type="text" readonly
          value="{{ Auth::user()->nombre_usuario }}"
          class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black"/>
      </div>

      {{-- Viaje / Origen / Destino --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-medium text-black">Bus / Viaje</label>
          <select id="viaje_select" name="viaje_id" required
            class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black">
            <option value="">-- Selecciona viaje --</option>
            @foreach($viajes as $v)
              @if(\Carbon\Carbon::parse($v->fecha_salida)->toDateString() >= now()->toDateString())
                <option value="{{ $v->id }}"
                  data-origen="{{ $v->ruta->origen }}"
                  data-salida="{{ \Carbon\Carbon::parse($v->fecha_salida)->format('H:i') }}">
                  {{ $v->ruta->origen }} → {{ $v->ruta->destino }}
                  ({{ $v->bus->codigo }}) {{ \Carbon\Carbon::parse($v->fecha_salida)->format('Y-m-d H:i') }}
                </option>
              @endif
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-black">Origen</label>
          <input type="text" id="origen_input" name="origen"
            value="{{ old('origen') }}" readonly
            class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black"/>
        </div>
        <div>
          <label class="block text-sm font-medium text-black">Destino (Parada)</label>
          <select id="destino_select" name="destino"
            class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black">
            <option value="">-- Selecciona parada --</option>
          </select>
        </div>
      </div>

      {{-- Fecha / Horarios --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-medium text-black">Fecha</label>
          <input type="date" name="fecha" required
            value="{{ old('fecha', now()->toDateString()) }}"
            class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black"/>
        </div>
        <div>
          <label class="block text-sm font-medium text-black">Horario</label>
          <input type="time" id="horario_input" name="horario" required
            value="{{ old('horario') }}"
            class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black"/>
        </div>
        <div>
          <label class="block text-sm font-medium text-black">Hora Recepción</label>
          <input type="time" id="hora_recepcion_input" name="hora_recepcion"
            value="{{ old('hora_recepcion') }}"
            class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black"/>
        </div>
      </div>

      {{-- Remitente --}}
      <div>
        <h3 class="text-lg font-semibold text-black">Remitente</h3>
        <label class="block text-sm text-black">Nombre</label>
        <input type="text" name="remitente_nombre" required
          value="{{ old('remitente_nombre') }}"
          class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black"/>
        <label class="block text-sm mt-2 text-black">CI</label>
        <input type="text" name="remitente_id" required
          value="{{ old('remitente_id') }}"
          class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black"/>
        <label class="block text-sm mt-2 text-black">Teléfono</label>
        <input type="text" name="remitente_telefono" required
          value="{{ old('remitente_telefono') }}"
          class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black"/>
      </div>

      {{-- Consignatario --}}
      <div id="consignatario_section">
        <h3 class="text-lg font-semibold text-black">Consignatario</h3>
        <label class="block text-sm text-black">Nombre</label>
        <input type="text" name="consignatario_nombre"
          value="{{ old('consignatario_nombre') }}"
          class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black"/>
        <label class="block text-sm mt-2 text-black">CI</label>
        <input type="text" name="consignatario_ci"
          value="{{ old('consignatario_ci') }}"
          class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black"/>
        <label class="block text-sm mt-2 text-black">Teléfono</label>
        <input type="text" name="consignatario_telefono"
          value="{{ old('consignatario_telefono') }}"
          class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black"/>
      </div>

      {{-- Detalle de Guía --}}
      <div>
        <h3 class="text-lg font-bold text-white bg-indigo-600 px-4 py-2 rounded mb-2">Detalle de Guía</h3>
        <div class="space-y-2 p-4 rounded-lg" id="detalle_carga">
          <div id="detalle_header" class="grid grid-cols-5 gap-2 font-bold text-sm">
            <div>#</div>
            <div>Cant.</div>
            <div>Descripción</div>
            <div>Peso (Kg)</div>
            <div class="cost-col">Costo (Bs)</div>
          </div>
          @foreach(old('items', [['cantidad'=>null,'descripcion'=>'','peso'=>null,'costo'=>null]]) as $i=>$it)
            <div class="grid gap-2 grid-cols-5 detalle_row">
              <div class="font-bold">{{ $i+1 }}</div>
              <input type="number" name="items[{{ $i }}][cantidad]" step="1"
                class="border rounded px-1 py-0.5 pl-2 bg-blue-50"
                value="{{ $it['cantidad'] }}"/>
              <input type="text" name="items[{{ $i }}][descripcion]"
                class="border rounded px-1 py-0.5 pl-2 bg-green-50"
                value="{{ $it['descripcion'] }}"/>
              <input type="number" name="items[{{ $i }}][peso]" step="0.01"
                class="border rounded px-1 py-0.5 pl-2 bg-yellow-50"
                value="{{ $it['peso'] }}"/>
              <input type="number" name="items[{{ $i }}][costo]" step="0.01"
                class="border rounded px-1 py-0.5 cost-col pl-2 bg-pink-50"
                value="{{ $it['costo'] }}"/>
            </div>
          @endforeach
          <button type="button" id="add_linea" class="mt-2 px-3 py-1 bg-indigo-600 text-white rounded">+ Línea</button>
          <button type="button" id="remove_linea" class="mt-2 px-3 py-1 bg-red-600 text-white rounded ml-2">- Línea</button>
        </div>
      </div>

      <button type="submit"
        class="w-full mt-6 bg-green-600 text-white py-2 rounded hover:bg-green-700">
        Guardar Encomienda
      </button>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const viajeSelect     = document.getElementById('viaje_select');
    const origenInput     = document.getElementById('origen_input');
    const destinoSelect   = document.getElementById('destino_select');
    const paradas         = {!! json_encode($paradasByViaje) !!};
    const horarioInput    = document.getElementById('horario_input');
    const recepcionInput  = document.getElementById('hora_recepcion_input');

    function pad(n){ return n<10?'0'+n:n; }

    viajeSelect.addEventListener('change', () => {
      const opt = viajeSelect.selectedOptions[0];
      const id  = viajeSelect.value;
      origenInput.value = id ? opt.dataset.origen : '';
      destinoSelect.innerHTML = '<option value="">-- Selecciona parada --</option>';
      if(id && paradas[id]) {
        paradas[id].forEach(p => {
          const o = document.createElement('option');
          o.value = p; o.textContent = p;
          destinoSelect.appendChild(o);
        });
    
        let destinoRaw = viajeSelect.selectedOptions[0].textContent.split('→').pop().trim();
        let destinoFinal = destinoRaw.split('(')[0].trim();
        if (!paradas[id].includes(destinoFinal)) {
          const o = document.createElement('option');
          o.value = destinoFinal; o.textContent = destinoFinal + ' (Final)';
          destinoSelect.appendChild(o);
        }
        destinoSelect.value = {!! json_encode(old('destino', '')) !!};
      }
      horarioInput.value = opt.dataset.salida || '';
      const now = new Date();
      recepcionInput.value = pad(now.getHours()) + ':' + pad(now.getMinutes());
    });

    viajeSelect.dispatchEvent(new Event('change'));

    const detalleContainer = document.getElementById('detalle_carga');
    const addBtn = document.getElementById('add_linea');
    const removeBtn = document.getElementById('remove_linea');

    addBtn.addEventListener('click', () => {
      const rows = detalleContainer.querySelectorAll('.detalle_row');
      const idx = rows.length;
      const div = document.createElement('div');
      div.className = 'grid gap-2 grid-cols-5 detalle_row';
      div.innerHTML = `
        <div class="font-bold">${idx + 1}</div>
        <input type="number" name="items[${idx}][cantidad]" step="1" class="border rounded px-1 py-0.5 pl-2 bg-blue-50"/>
        <input type="text"   name="items[${idx}][descripcion]" class="border rounded px-1 py-0.5 pl-2 bg-green-50"/>
        <input type="number" name="items[${idx}][peso]"       step="0.01" class="border rounded px-1 py-0.5 pl-2 bg-yellow-50"/>
        <input type="number" name="items[${idx}][costo]"      step="0.01" class="border rounded px-1 py-0.5 cost-col pl-2 bg-pink-50"/>
      `;
      detalleContainer.insertBefore(div, addBtn);
    });

    removeBtn.addEventListener('click', () => {
      const rows = detalleContainer.querySelectorAll('.detalle_row');
      if (rows.length > 1) { 
        rows[rows.length - 1].remove();
      }
    });

    window.addItem = function(){
      const cont = document.querySelector('.space-y-2.p-4');
      const idx  = cont.querySelectorAll('> div.grid').length;
      const html = `
        <div class="grid gap-2 grid-cols-5">
          <div class="font-bold">${idx+1}</div>
          <input type="number" name="items[${idx}][cantidad]" step="1" class="border rounded px-1 py-0.5 pl-2 bg-blue-50"/>
          <input type="text"   name="items[${idx}][descripcion]" class="border rounded px-1 py-0.5 pl-2 bg-green-50"/>
          <input type="number" name="items[${idx}][peso]"       step="0.01" class="border rounded px-1 py-0.5 pl-2 bg-yellow-50"/>
          <input type="number" name="items[${idx}][costo]"      step="0.01" class="border rounded px-1 py-0.5 cost-col pl-2 bg-pink-50"/>
        </div>`;
      cont.insertAdjacentHTML('beforeend', html);
    };
  });
</script>
@endsection
