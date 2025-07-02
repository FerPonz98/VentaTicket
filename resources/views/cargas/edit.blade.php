{{-- resources/views/cargas/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Editar Carga')

@section('content')
  <a href="{{ route('carga.index') }}" class="inline-block text-indigo-600 hover:text-indigo-800 underline mb-4">
    &larr; Volver al listado de Cargas
  </a>

  <div class="container mx-auto mt-8">
    <div class="bg-white shadow-lg rounded-lg p-6 overflow-x-auto">
      <h2 class="text-2xl font-bold text-black mb-4">Editar Carga</h2>

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
        // Preparar datos de viajes: paradas, destino y horario
        $viajesData = $viajes->mapWithKeys(function($viaje) {
            $decoded = is_array($viaje->ruta->paradas)
                ? $viaje->ruta->paradas
                : (json_decode($viaje->ruta->paradas, true) ?: []);
            $paradas = array_map(function($p) {
                return is_array($p) && isset($p['nombre']) ? $p['nombre'] : $p;
            }, $decoded);
            return [$viaje->id => [
                'paradas' => $paradas,
                'destino' => $viaje->ruta->destino,
                'salida'  => $viaje->fecha_salida->format('H:i'),
            ]];
        })->toArray();
      @endphp

      <form action="{{ route('carga.update', $carga) }}" method="POST" class="space-y-6 text-black">
        @csrf
        @method('PUT')
        <input type="hidden" name="cajero_id" value="{{ Auth::user()->ci_usuario }}">

        {{-- Cabecera de la guía --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-medium text-black">Nro de Guía de Carga</label>
            <input type="text" name="nro_guia" readonly
                   value="{{ old('nro_guia', $carga->nro_guia) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black"/>
          </div>
          <div>
            <label class="block text-sm font-medium text-black">Estado</label>
            <select name="estado" required class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black">
              <option value="por pagar" {{ old('estado', $carga->estado)=='por pagar' ? 'selected' : '' }}>Por Pagar</option>
              <option value="pagado"    {{ old('estado', $carga->estado)=='pagado'    ? 'selected' : '' }}>Pagado</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-black">Emitido por (Cajero)</label>
            <input type="text" readonly value="{{ Auth::user()->nombre_usuario }}"
                   class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black"/>
          </div>
        </div>

        {{-- Selección de Viaje, Origen y Destino --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-medium text-black">Bus / Viaje</label>
            <select id="viaje_select" name="viaje_id" required
                    class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black">
              <option value="">-- Selecciona viaje --</option>
              @foreach($viajes as $viaje)
                <option value="{{ $viaje->id }}"
                        data-origen="{{ $viaje->ruta->origen }}"
                        {{ old('viaje_id', $carga->viaje_id)==$viaje->id ? 'selected' : '' }}>
                  {{ $viaje->ruta->origen }} → {{ $viaje->ruta->destino }} ({{ $viaje->bus->codigo }}) {{ $viaje->fecha_salida->format('Y-m-d H:i') }}
                </option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-black">Origen</label>
            <input type="text" id="origen_input" name="origen" readonly required
                   value="{{ old('origen', $carga->origen) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black"/>
          </div>
          <div>
            <label class="block text-sm font-medium text-black">Destino (Parada)</label>
            <select id="destino_select" name="destino" required
                    class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black">
              <option value="">-- Selecciona parada --</option>
            </select>
          </div>
        </div>

        {{-- Fecha, Horario y Recepción --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-sm font-medium text-black">Fecha</label>
            <input type="date" name="fecha" required
                   value="{{ old('fecha', optional($carga->fecha)->toDateString()) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black"
                   readonly />
          </div>
          <div>
            <label class="block text-sm font-medium text-black">Horario Salida</label>
            <input type="time" id="horario_input" name="horario" readonly required
                   value="{{ old('horario', $carga->horario) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black"/>
          </div>
          <div>
            <label class="block text-sm font-medium text-black">Hora Recepción</label>
            <input type="time" id="hora_recepcion_input" name="hora_recepcion"
                   value="{{ old('hora_recepcion', $carga->hora_recepcion) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black"/>
          </div>
        </div>

        {{-- Datos del Remitente --}}
        <div>
          <h3 class="text-lg font-semibold text-black">Remitente</h3>
          <label class="block text-sm text-black">Nombre</label>
          <input type="text" name="remitente_nombre" required
                 value="{{ old('remitente_nombre', $carga->remitente_nombre) }}"
                 class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black"/>
          <label class="block text-sm mt-2 text-black">CI</label>
          <input type="text" name="remitente_ci" required
                 value="{{ old('remitente_ci', $carga->remitente_ci) }}"
                 class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black"/>
          <label class="block text-sm mt-2 text-black">Teléfono</label>
          <input type="text" name="remitente_telefono" required
                 value="{{ old('remitente_telefono', $carga->remitente_telefono) }}"
                 class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 text-black"/>
        </div>

        {{-- Detalle de Carga --}}
        <div>
          <h3 class="text-lg font-bold text-white bg-indigo-600 px-4 py-2 rounded mb-2">Detalle de Carga</h3>
          <div class="space-y-2 p-4 rounded-lg" id="detalle_carga">
            <div class="grid grid-cols-5 gap-2 font-bold text-sm" id="detalle_header">
              <div>#</div>
              <div>Cant.</div>
              <div>Descripción</div>
              <div>Peso (Kg)</div>
              <div>Costo (Bs)</div>
            </div>
            @php $oldDetalles = old('detalles', $carga->detalles->map->only(['cantidad','descripcion','peso','costo'])->toArray()); @endphp
            @foreach($oldDetalles as $i => $it)
              <div class="grid gap-2 grid-cols-5 detalle_row">
                <div class="font-bold">{{ $i+1 }}</div>
                <input type="number" name="detalles[{{ $i }}][cantidad]" step="1" required class="border rounded px-1 py-0.5 pl-2 bg-blue-50" value="{{ $it['cantidad'] }}"/>
                <input type="text" name="detalles[{{ $i }}][descripcion]" required class="border rounded px-1 py-0.5 pl-2 bg-green-50" value="{{ $it['descripcion'] }}"/>
                <input type="number" name="detalles[{{ $i }}][peso]" step="0.01" required class="border rounded px-1 py-0.5 pl-2 bg-yellow-50" value="{{ $it['peso'] }}"/>
                <input type="number" name="detalles[{{ $i }}][costo]" step="0.01" required class="border rounded px-1 py-0.5 pl-2 bg-red-50" value="{{ $it['costo'] ?? '' }}"/>
              </div>
            @endforeach
            <button type="button" id="add_linea" class="mt-2 px-3 py-1 bg-indigo-600 text-white rounded">+ Línea</button>
            <button type="button" id="remove_linea" class="mt-2 px-3 py-1 bg-red-600 text-white rounded ml-2">- Línea</button>
          </div>
        </div>

        <button type="submit" class="w-full mt-6 bg-green-600 text-white py-2 rounded hover:bg-green">Actualizar Carga</button>


      </form>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const viajes = @json($viajesData);
      const viajeSelect = document.getElementById('viaje_select');
      const origenInput = document.getElementById('origen_input');
      const destinoSelect = document.getElementById('destino_select');
      const horarioInput = document.getElementById('horario_input');
      const fechaInput = document.querySelector('input[name="fecha"]');
      const horaRecepcionInput = document.getElementById('hora_recepcion_input');

      function updateViaje() {
        const id = viajeSelect.value;
        const data = viajes[id] || { paradas: [], destino: '', salida: '', fecha: '' };
        origenInput.value = id ? document.querySelector(`#viaje_select option[value="${id}"]`).dataset.origen : '';
        horarioInput.value = data.salida || '';
        @foreach($viajes as $viaje)
          if (id == '{{ $viaje->id }}') {
            fechaInput.value = '{{ $viaje->fecha_salida->toDateString() }}';
          }
        @endforeach

        destinoSelect.innerHTML = '<option value="">-- Selecciona parada --</option>';
        data.paradas.forEach(p => {
          const opt = document.createElement('option'); opt.value = p; opt.textContent = p;
          destinoSelect.appendChild(opt);
        });
        if (data.destino && !data.paradas.includes(data.destino)) {
          const opt = document.createElement('option'); opt.value = data.destino; opt.textContent = data.destino + ' (Final)';
          destinoSelect.appendChild(opt);
        }
        destinoSelect.value = '{{ old("destino", $carga->destino) }}';
      }

      function setHoraRecepcionActual() {
        const now = new Date();
        const hh = String(now.getHours()).padStart(2, '0');
        const mm = String(now.getMinutes()).padStart(2, '0');
        horaRecepcionInput.value = `${hh}:${mm}`;
      }

      viajeSelect.addEventListener('change', updateViaje);
      updateViaje();
      setHoraRecepcionActual();

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
          <input type="number" name="detalles[${idx}][cantidad]" step="1" required class="border rounded px-1 py-0.5 pl-2 bg-blue-50"/>
          <input type="text" name="detalles[${idx}][descripcion]" required class="border rounded px-1 py-0.5 pl-2 bg-green-50"/>
          <input type="number" name="detalles[${idx}][peso]" step="0.01" required class="border rounded px-1 py-0.5 pl-2 bg-yellow-50"/>
          <input type="number" name="detalles[${idx}][costo]" step="0.01" required class="border rounded px-1 py-0.5 pl-2 bg-red-50"/>
        `;
        
        detalleContainer.insertBefore(div, addBtn);
      });

      removeBtn.addEventListener('click', () => {
        const rows = detalleContainer.querySelectorAll('.detalle_row');
        if (rows.length > 1) {
          rows[rows.length - 1].remove();
        }
      });
    });
  </script>
@endsection
