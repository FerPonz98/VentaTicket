{{-- resources/views/pasajes/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Venta de Pasaje')

@section('content')
<a href="{{ route('pasajes.index') }}"
   class="inline-block text-indigo-600 hover:text-indigo-800 underline mb-4">
  &larr; Volver al listado
</a>

<div class="max-w-lg mx-auto bg-white shadow rounded p-6">
  <h2 class="text-2xl font-bold mb-4 text-gray-900">Venta de Pasaje</h2>

  {{-- 1) Selección de viaje --}}
  <form action="{{ route('pasajes.create') }}" method="GET" class="mb-6">
    <label class="block text-sm font-medium text-gray-700 mb-1">Viaje</label>
    <select name="viaje_id" onchange="this.form.submit()"
            class="w-full border-gray-300 rounded px-3 py-2">
      <option value="">-- Selecciona un viaje --</option>
      @foreach($viajes as $v)
        <option value="{{ $v->id }}"
          {{ ($viajeSeleccionado == $v->id) ? 'selected' : '' }}>
          {{ $v->ruta->origen }} → {{ $v->ruta->destino }}
          ({{ \Carbon\Carbon::parse($v->fecha_salida)->format('d-m-Y H:i') }})
        </option>
      @endforeach
    </select>
  </form>

  @if($viajeSeleccionado)
    @php
      $viaje       = $viajes->firstWhere('id', $viajeSeleccionado);
      $bus         = $viaje->bus;
      $p1          = $bus->asientos_piso1;
      $p2          = $bus->asientos_piso2;
      $ocupados_ct = count($ocupados);
      $capacidad   = $p1 + $p2;
      $disponible  = max(0, $capacidad - $ocupados_ct);

      $genLayout = function($count, $start = 1) {
        $rows = []; $full = intdiv($count,4); $rem = $count%4; $n=$start;
        for($i=0;$i<$full;$i++){
            $rows[] = [$n++,$n++,'aisle',$n++,$n++];
        }
        if($rem){
            $row=[];
            for($i=0;$i<$rem;$i++) $row[]=(string)$n++;
            for($i=$rem;$i<5;$i++) $row[]='empty';
            $rows[]=$row;
        }
        return $rows;
      };
      $layout1 = $genLayout($p1, 1);

      // Calcular el último número de asiento del piso 1
      $lastNumPiso1 = $p1;
      if (count($layout1)) {
          $last = end($layout1);
          foreach ($last as $cell) {
              if (is_numeric($cell)) {
                  $lastNumPiso1 = (int)$cell;
              }
          }
      }

      $layout2 = $bus->tipo_de_bus==='Doble piso' ? $genLayout($p2, $lastNumPiso1 + 1) : [];
    @endphp

    {{-- Si no queda ningún asiento, mostramos aviso --}}
    @if($disponible === 0)
      <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6">
        <p class="font-semibold">¡Sin espacios!</p>
        <p>Ya no quedan asientos libres para este viaje.</p>
      </div>
    @endif

    <form action="{{ route('pasajes.store') }}" method="POST" class="space-y-5">
      @csrf
      <input type="hidden" name="viaje_id" value="{{ $viajeSeleccionado }}">
      <input type="hidden" name="asiento" id="asientoSeleccionado" value="{{ old('asiento') }}">

      {{-- Origen / Destino --}}
      <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Origen</label>
          <input type="text" name="origen"
                 value="{{ $viaje->ruta->origen }}"
                 class="w-full border-gray-300 rounded px-3 py-2"
                 readonly>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Destino</label>
          <select name="destino"
                  class="w-full border-gray-300 rounded px-3 py-2"
                  required>
            @foreach($viaje->ruta->paradas ?? [] as $parada)
              <option value="{{ $parada['nombre'] ?? $parada }}"
                {{ old('destino') == ($parada['nombre'] ?? $parada) ? 'selected' : '' }}>
                {{ $parada['nombre'] ?? $parada }}
              </option>
            @endforeach
            <option value="{{ $viaje->ruta->destino }}"
              {{ old('destino')==$viaje->ruta->destino?'selected':'' }}>
              {{ $viaje->ruta->destino }} (Final)
            </option>
          </select>
          @error('destino')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
      </div>

      {{-- Hora de salida --}}
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Hora de Salida</label>
        <input type="text" value="{{ \Carbon\Carbon::parse($viaje->fecha_salida)->format('H:i') }}"
               class="w-32 border-gray-300 rounded px-3 py-2"
               readonly>
      </div>

      {{-- Plano de asientos --}}
      <div>
        <h3 class="font-semibold text-gray-800 mb-2">Piso 1</h3>
        @foreach($layout1 as $row)
          <div class="{{ count($row)===5?'grid grid-cols-5 gap-2 mb-2':'flex gap-2 mb-2' }}">
            @foreach($row as $cell)
              @if($cell==='aisle')
                <div class="w-4"></div>
              @elseif($cell==='empty')
                <div class="w-12 h-12"></div>
              @else
                <div
                  class="seat {{ in_array((int)$cell,$ocupados)?'occupied':'available' }}
                         {{ old('asiento')==$cell?'selected':'' }}"
                  data-seat="{{ $cell }}">
                  {{ $cell }}
                </div>
              @endif
            @endforeach
          </div>
        @endforeach
      </div>

      @if(count($layout2))
      <div>
        <h3 class="font-semibold text-gray-800 mt-4 mb-2">Piso 2</h3>
        @foreach($layout2 as $row)
          <div class="{{ count($row)===5?'grid grid-cols-5 gap-2 mb-2':'flex gap-2 mb-2' }}">
            @foreach($row as $cell)
              @if($cell==='aisle')
                <div class="w-4"></div>
              @elseif($cell==='empty')
                <div class="w-12 h-12"></div>
              @else
                <div
                  class="seat {{ in_array((int)$cell,$ocupados)?'occupied':'available' }}
                         {{ old('asiento')==$cell?'selected':'' }}"
                  data-seat="{{ $cell }}">
                  {{ $cell }}
                </div>
              @endif
            @endforeach
          </div>
        @endforeach
      </div>
      @endif

      @error('asiento')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror

      {{-- Datos pasajero --}}
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nombre completo</label>
        <input type="text" name="nombre_completo" required
               value="{{ old('nombre_completo') }}"
               class="w-full border-gray-300 rounded px-3 py-2"
               placeholder="Ej. Juan Pérez">
        @error('nombre_completo')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
      </div>
      {{-- CI del pasajero --}}
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1" for="ci_usuario">
          CI del pasajero
        </label>
        <input
          type="text"
          name="ci_usuario"
          id="ci_usuario"
          value="{{ old('ci_usuario') }}"
          required
          class="w-full border-gray-300 rounded px-3 py-2"
          placeholder="Ej. 12345678"
        >
        @error('ci_usuario')
          <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror
      </div>

      {{-- Edad del pasajero --}}
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1" for="edad">
          Edad
        </label>
        <input
          type="number"
          name="edad"
          id="edad"
          min="0"
          max="150"
          value="{{ old('edad') }}"
          required
          class="w-full border-gray-300 rounded px-3 py-2"
          placeholder="Ej. 34"
        >
        @error('edad')
          <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de pasajero</label>
        <select name="tipo_pasajero" required class="w-full border-gray-300 rounded px-3 py-2">
          <option value="">-- Selecciona tipo --</option>
          @foreach($tipos as $k=>$l)
            <option value="{{ $k }}" {{ old('tipo_pasajero')==$k?'selected':'' }}>
              {{ $l }}
            </option>
          @endforeach
        </select>
        @error('tipo_pasajero')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de viaje</label>
        <input type="text" name="fecha" readonly
               value="{{ \Carbon\Carbon::parse($viaje->fecha_salida)->format('Y-m-d') }}"
               class="w-full border-gray-300 rounded px-3 py-2 ">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Forma de pago</label>
        <select name="forma_pago" required class="w-full border-gray-300 rounded px-3 py-2">
          <option value="">-- Selecciona forma --</option>
          @foreach($formasPago as $k=>$l)
            <option value="{{ $k }}" {{ old('forma_pago')==$k?'selected':'' }}>
              {{ $l }}
            </option>
          @endforeach
        </select>
        @error('forma_pago')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
      </div>

     

      {{-- Botón: deshabilitado si no quedan asientos --}}
      <div>
        <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded
                       {{ $disponible===0?'opacity-50 cursor-not-allowed':'' }}"
                {{ $disponible===0?'disabled':'' }}>
          Vender Pasaje
        </button>
      </div>
    </form>
  @endif
</div>

{{-- Estilos JS para selección --}}
<style>
  .seat { width:50px; height:50px; display:flex; align-items:center; justify-content:center; font-weight:bold; cursor:pointer; border-radius:4px; }
  .seat.available { background:#4ade80; }
  .seat.occupied  { background:#ef4444; cursor:not-allowed; }
  .seat.selected  { background:#3b82f6; color:#fff; }
</style>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.seat.available').forEach(el => {
      el.addEventListener('click', () => {
        document.querySelectorAll('.seat.selected').forEach(s=>s.classList.remove('selected'));
        el.classList.add('selected');
        document.getElementById('asientoSeleccionado').value = el.dataset.seat;
      });
    });

    const edadInput = document.getElementById('edad');
    const tipoSelect = document.querySelector('select[name="tipo_pasajero"]');
    const descuentoDiv = document.createElement('div');
    descuentoDiv.innerHTML = `
      <label class="block text-sm font-medium text-gray-700 mb-1" for="codigo_descuento">
        Código de descuento
      </label>
      <input type="text" name="codigo_descuento" id="codigo_descuento"
             class="w-full border-gray-300 rounded px-3 py-2"
             placeholder="Ingrese código de descuento">
    `;

    function actualizarOpcionesTipo() {
      const edad = parseInt(edadInput.value, 10);
      Array.from(tipoSelect.options).forEach(opt => {
      
        if(opt.value === "cortesia" || opt.value === "desc" || opt.value === "") {
          opt.disabled = false;
          return;
        }
        if(opt.value === "menor") {
          opt.disabled = !(edad < 18);
          if(opt.disabled && tipoSelect.value === "menor") tipoSelect.value = "";
        }

        if(opt.value === "adulto") {
          opt.disabled = !(edad >= 18 && edad <= 60);
          if(opt.disabled && tipoSelect.value === "adulto") tipoSelect.value = "";
        }
   
        if(opt.value === "tercera_edad") {
          opt.disabled = !(edad > 60);
          if(opt.disabled && tipoSelect.value === "tercera_edad") tipoSelect.value = "";
        }
      });
      mostrarCampoDescuento();
    }

    function mostrarCampoDescuento() {
  
      if(tipoSelect.value === "desc") {
        if(!document.getElementById('codigo_descuento')) {
          tipoSelect.parentNode.appendChild(descuentoDiv);
        }
      } else {
        if(document.getElementById('codigo_descuento')) {
          descuentoDiv.remove();
        }
      }
    }

    edadInput.addEventListener('input', actualizarOpcionesTipo);
    tipoSelect.addEventListener('change', mostrarCampoDescuento);
    actualizarOpcionesTipo(); 
  });
</script>
@endsection
