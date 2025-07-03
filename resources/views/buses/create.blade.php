@extends('layouts.app')

@section('title','Crear Bus')

@section('content')
<a href="{{ route('buses.index') }}" class="inline-block text-indigo-600 hover:text-indigo-800 underline mb-4">&larr; Volver al listado</a>
<div class="max-w-6xl mx-auto grid lg:grid-cols-2 gap-8">
  <div>
    <div class="bg-gray-50 p-6 rounded-lg shadow space-y-6">
      
          {{-- Mostrar errores de validación --}}
    @if($errors->any())
      <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded mb-6">
        <ul class="list-disc list-inside">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('buses.store') }}" method="POST" class="space-y-6">
      @csrf
      <div>
       <h2 class="text-2xl font-bold mb-6 text-black">
      Nuevo Bus
        </h2>
        <label for="codigo" class="block mb-1 text-gray-700 font-medium">Código*</label>
        <input
          id="codigo"
          name="codigo"
          type="text"
          value="{{ old('codigo') }}"
          placeholder="p.ej. B123"
          required
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
      </div>
      {{-- Placa --}}
      <div>
        <label for="placa" class="block mb-1 text-gray-700 font-medium">Placa*</label>
        <input
          id="placa"
          name="placa"
          type="text"
          value="{{ old('placa') }}"
          placeholder="p.ej. B123"
          required
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
      </div>
      {{-- Tipo de bus --}}
      <div>
        <label for="tipo_de_bus" class="block mb-1 text-gray-700 font-medium">Tipo de Bus*</label>
        <select
          id="tipo_de_bus"
          name="tipo_de_bus"
          required
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
        >
          <option value="">-- Seleccione --</option>
          <option value="Un piso" {{ old('tipo_de_bus')=='Un piso' ? 'selected' : '' }}>Un piso</option>
          <option value="Doble piso" {{ old('tipo_de_bus')=='Doble piso' ? 'selected' : '' }}>Doble piso</option>
        </select>
      </div>

      {{-- Asientos Piso 1 --}}
      <div>
        <label for="asientos_piso1" class="block mb-1 text-gray-700 font-medium">Asientos Piso 1*</label>
        <input
          id="asientos_piso1"
          name="asientos_piso1"
          type="number"
          min="1"
          value="{{ old('asientos_piso1') }}"
          placeholder="Número de asientos piso 1"
          required
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
      </div>

      {{-- Asientos Piso 2 (solo para Doble piso) --}}
      <div id="asientos_piso2_div">
        <label for="asientos_piso2" class="block mb-1 text-gray-700 font-medium">Asientos Piso 2*</label>
        <input
          id="asientos_piso2"
          name="asientos_piso2"
          type="number"
          min="0"
          value="{{ old('asientos_piso2', 0) }}"
          placeholder="Número de asientos piso 2"
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
      </div>

      {{-- Tipo de Asiento --}}
      <div>
        <label for="tipo_asiento" class="block mb-1 text-gray-700 font-medium">Tipo de Asiento*</label>
        <select
          id="tipo_asiento"
          name="tipo_asiento"
          required
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
        >
          <option value="">-- Seleccione --</option>
          <option value="Normal" {{ old('tipo_asiento')=='Normal' ? 'selected' : '' }}>Normal</option>
          <option value="Semicama" {{ old('tipo_asiento')=='Semicama' ? 'selected' : '' }}>Semicama</option>
          <option value="Leito/Semicama" {{ old('tipo_asiento')=='Leito/Semicama' ? 'selected' : '' }}>Leito/Semicama</option>
        </select>
      </div>

      {{-- Características y Vencimientos --}}
      <div class="grid grid-cols-2 gap-4">
        <label class="inline-flex items-center">
          <input type="checkbox" name="aire_acondicionado" value="1" {{ old('aire_acondicionado') ? 'checked' : '' }} class="form-checkbox mr-2" />
          <span class="text-gray-700">A/C</span>
        </label>
        <label class="inline-flex items-center">
          <input type="checkbox" name="tv" value="1" {{ old('tv') ? 'checked' : '' }} class="form-checkbox mr-2" />
          <span class="text-gray-700">TV</span>
        </label>
        <label class="inline-flex items-center">
          <input type="checkbox" name="bano" value="1" {{ old('bano') ? 'checked' : '' }} class="form-checkbox mr-2" />
          <span class="text-gray-700">Baño</span>
        </label>
        <label class="inline-flex items-center">
          <input type="checkbox" name="carga_telefono" value="1" {{ old('carga_telefono') ? 'checked' : '' }} class="form-checkbox mr-2" />
          <span class="text-gray-700">Carga de Teléfono</span>
        </label>
        <label class="inline-flex items-center">
          <input type="checkbox" name="rev_tecnica" value="1" {{ old('rev_tecnica') ? 'checked' : '' }} class="form-checkbox mr-2" />
          <span class="text-gray-700">Revisión Técnica</span>
        </label>
        <label class="inline-flex items-center">
          <input type="checkbox" name="soat" value="1" {{ old('soat') ? 'checked' : '' }} class="form-checkbox mr-2" />
          <span class="text-gray-700">SOAT</span>
        </label>
      </div>
  
      {{-- Vencimientos --}}
      <div class="sm:col-span-2">
        <label for="tarjeta_operacion_vencimiento" class="block mb-1 text-gray-700 font-medium">Venc. Tarjeta Operación</label>
        <input
          type="date"
          id="tarjeta_operacion_vencimiento"
          name="tarjeta_operacion_vencimiento"
          value="{{ old('tarjeta_operacion_vencimiento') }}"
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
        @error('tarjeta_operacion_vencimiento')
          <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
        @enderror
      </div>  
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Marca --}}
        <div>
          <label for="marca" class="block mb-1 text-gray-700 font-medium">Marca*</label>
          <input
            id="marca"
            name="marca"
            type="text"
            value="{{ old('marca') }}"
            placeholder="p.ej. Mercedes"
            required
            class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
          />
        </div>

        {{-- Modelo --}}
        <div>
          <label for="modelo" class="block mb-1 text-gray-700 font-medium">Modelo</label>
          <input
            id="modelo"
            name="modelo"
            type="text"
            value="{{ old('modelo') }}"
            placeholder="p.ej. Sprinter 2020"
            class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
          />
        </div>
      </div>
      {{-- Codigo Soat --}}
      <div>
        <label for="codigo_soat" class="block mb-1 text-gray-700 font-medium">Código SOAT</label>
        <input
          id="codigo_soat"
          name="codigo_soat"
          type="text"
          value="{{ old('codigo_soat') }}"
          placeholder="p.ej. ABC123"
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
      </div>
      {{-- Propietario --}}
      <div>
        <label for="propietario" class="block mb-1 text-gray-700 font-medium">Propietario</label>
        <input
          id="propietario"
          name="propietario"
          type="text"
          value="{{ old('propietario') }}"
          placeholder="p.ej. Juan Pérez"
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
        />
      </div>

      {{-- Chofer Principal --}}
      <div>
        <label for="chofer_id" class="block mb-1 text-gray-700 font-medium">Chofer Principal*</label>
        <select
          id="chofer_id"
          name="chofer_id"
          required
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
        >
          <option value="">-- Seleccione Chofer --</option>
          @foreach($choferes as $chofer)
            <option value="{{ $chofer->CI }}" {{ old('chofer_id') == $chofer->CI ? 'selected' : '' }}>
              {{ $chofer->nombre_chofer }}
            </option>
          @endforeach
        </select>
      </div>
      {{-- Chofer secundario (opcional) --}}
      <div>
        <label for="chofer2_id" class="block mb-1 text-gray-700 font-medium">Chofer Secundario (opcional)</label>
        <select
          id="chofer2_id"
          name="chofer2_id"
          class="w-full bg-gray-50 border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-gray-900"
        >
          <option value="">-- Seleccione Chofer --</option>
          @foreach($choferes as $chofer)
            @if(old('chofer_id') != $chofer->CI)
              <option value="{{ $chofer->CI }}" {{ old('chofer2_id') == $chofer->CI ? 'selected' : '' }}>
                {{ $chofer->nombre_chofer }}
              </option>
            @endif
          @endforeach
        </select>
      </div>

      {{-- Botones --}}
      <div class="pt-4 flex gap-4">
        <a href="{{ route('buses.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 rounded text-center">
          Cancelar
        </a>
        <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-2 rounded">
          Crear
        </button>
      </div>
      <input type="hidden" id="layout1" name="layout_piso1" value='@json(old("layout_piso1", []))'>
      <input type="hidden" id="layout2" name="layout_piso2" value='@json(old("layout_piso2", []))'>
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
  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const primary = document.getElementById('chofer_id');
    const secondary = document.getElementById('chofer2_id');

    function syncSecondary() {
      const selected = primary.value;
      Array.from(secondary.options).forEach(opt => {
        opt.disabled = (opt.value === selected && opt.value !== "");
      });
      if (secondary.value === selected) {
        secondary.value = '';
      }
    }

    primary.addEventListener('change', syncSecondary);
    syncSecondary();
  });
</script>
    </div>
  

    {{-- Columna derecha: herramienta de diseño de asientos --}}
<div>
  <div class="bg-white p-6 rounded-lg shadow space-y-8">
    <h3 class="text-lg text-black font-semibold mb-2">Herramienta de diseño de asientos</h3>
    
{{-- Leyenda de símbolos --}}
<div class="flex items-center gap-4 mb-4">
<div class="flex items-center gap-1">
    <span class="cell aisle" style="width:24px; height:24px; background:#ffffff; border:1px solid #ccc; display:inline-flex; align-items:center; justify-content:center;"></span>
    <span class="text-sm text-black">Asiento</span>
  </div>
<div class="flex items-center gap-1">
    <span class="cell aisle" style="width:24px; height:24px; background:#f0f0f0; border:1px solid #ccc; display:inline-flex; align-items:center; justify-content:center;"></span>
    <span class="text-sm text-black">Pasillo</span>
  </div>
  <div class="flex items-center gap-1">
    <span class="cell entry" style="width:24px; height:24px; border:1px solid #ccc; display:inline-flex; align-items:center; justify-content:center;"></span>
    <span class="text-sm text-black">Entrada</span>
  </div>
  <div class="flex items-center gap-1">
    <span class="cell exit" style="width:24px; height:24px; border:1px solid #ccc; display:inline-flex; align-items:center; justify-content:center;"></span>
    <span class="text-sm text-black">Salida</span>
  </div>

</div>

<style>
  .cell            { width:50px; height:50px; border:1px solid #ccc; display:flex; align-items:center; justify-content:center; cursor:pointer; position:relative; }
.cell.aisle      { background:#f0f0f0; }
.cell.entry::after { content:'→'; position:absolute; font-size:18px; color: #111; }
.cell.exit::after  { content:'←'; position:absolute; font-size:18px; color: #111; }
.cell.empty      { background:transparent; border:none; }
.row             { display:flex; gap:8px; }
.full            { display:grid; grid-template-columns:repeat(5,50px); gap:8px; }
.selected        { background:#3b82f6; color:#fff; }
.cell.seat {
  color: #111 !important;
}
</style>
    <div class="flex gap-4 mb-4">
      <label class="inline-flex text-black items-center">
        <input type="radio" name="mode" value="seat" checked class="mr-2"> Asiento
      </label>
      <label class="inline-flex text-black items-center">
        <input type="radio" name="mode" value="aisle" class="mr-2"> Pasillo
      </label>
      <label class="inline-flex text-black items-center">
        <input type="radio" name="mode" value="entry" class="mr-2"> Entrada
      </label>
      <label class="inline-flex text-black items-center">
        <input type="radio" name="mode" value="exit" class="mr-2"> Salida
      </label>

    </div>

    <div>
      <h4 class="font-medium text-black mb-1">Piso 1</h4>
      <div id="grid1" class="space-y-2 mb-2"></div>
      <div class="flex gap-2">
        <button id="add1" type="button" class="bg-blue-500 text-white px-3 py-1 rounded">+</button>
        <button id="sub1" type="button" class="bg-red-500 text-white px-3 py-1 rounded">-</button>
      </div>
    </div>

    <div id="piso2-block" style="display:none; margin-top:1rem;">
      <h4 class="font-medium text-black mb-1">Piso 2</h4>
      <div id="grid2" class="space-y-2 mb-2"></div>
      <div class="flex gap-2">
        <button id="add2" type="button" class="bg-blue-500 text-white px-3 py-1 rounded">+</button>
        <button id="sub2" type="button" class="bg-red-500 text-white px-3 py-1 rounded">-</button>
      </div>
    </div>
  </div>
</div>


<script>
 
  function genLayout(cnt, start = 1) {
  const rows = [];
  let n = start;

  const fullRows = Math.floor(cnt / 4);
  const rem = cnt % 4;

  if (cnt > 0 && cnt % 5 === 0) {
    const filasNormales = Math.floor((cnt - 5) / 4);
    for (let i = 0; i < filasNormales; i++) {
      rows.push([String(n++), String(n++), 'aisle', String(n++), String(n++)]);
    }
    const filaFinal = [];
    for (let i = 0; i < 5; i++) filaFinal.push(String(n++));
    rows.push(filaFinal);
  } else {
    for (let i = 0; i < fullRows; i++) {
      rows.push([String(n++), String(n++), 'aisle', String(n++), String(n++)]);
    }
    if (rem) {
      const row = [];
      if (rem <= 2) {
        for (let i = 0; i < rem; i++) row.push(String(n++));
        for (let i = rem; i < 5; i++) row.push('empty');
      } else {
        row.push(String(n++));
        row.push(String(n++));
        row.push('aisle');
        for (let i = 2; i < rem; i++) row.push(String(n++));
        for (let i = rem + 1; i < 5; i++) row.push('empty');
      }
      rows.push(row);
    }
  }
  return rows;
}

  function syncCount(gridId, inputEl) {
    const cells = document.querySelectorAll(`#${gridId} .cell`);
    const count = Array.from(cells).filter(c => /^\d+$/.test(c.dataset.type)).length;
    inputEl.value = count;
  }
  function renumerarAsientos(gridId) {
  const grid = document.getElementById(gridId);
  let num = 1;
  Array.from(grid.querySelectorAll('.cell.seat')).forEach(cell => {
    cell.innerText = num;
    cell.dataset.type = String(num);
    num++;
  });
}
  function render(piso, layout, gridId) {
    const grid = document.getElementById(gridId);
    grid.innerHTML = '';
    layout.forEach(row => {
      const container = document.createElement('div');
      container.className = row.length === 5 ? 'full' : 'row';
      row.forEach(cell => {
        const el = document.createElement('div');
        el.className = 'cell ' + (['aisle','empty'].includes(cell) ? cell : 'seat');
        el.innerText = /^\d+$/.test(cell) ? cell : '';
        el.dataset.type = cell;
        el.addEventListener('click', () => {
  if (cell === 'empty') return;
  const mode = document.querySelector('input[name="mode"]:checked').value;

  if (mode === 'seat') {
    const nuevo = prompt('Número de asiento:');
    if (!nuevo || !/^\d+$/.test(nuevo)) return;

    const todos = Array.from(document.querySelectorAll('.cell'))
      .filter(c => c !== el && c.dataset.type === 'seat')
      .map(c => c.innerText);
    if (todos.includes(nuevo)) {
      alert('Ese número de asiento ya está en uso.');
      return;
    }
    el.innerText    = nuevo;
    el.dataset.type = nuevo;
    el.className    = 'cell seat selected';
  } else {
    el.dataset.type = mode;
    el.innerText    = '';
    el.className    = 'cell ' + mode;
    renumerarAsientos(gridId);
  }

  save(piso, gridId);
  if (gridId === 'grid1') {
    syncCount('grid1', document.getElementById('asientos_piso1'));
  } else {
    syncCount('grid2', document.getElementById('asientos_piso2'));
  }
});

        container.appendChild(el);
      });
      grid.appendChild(container);
    });
  }

  function save(piso, gridId) {
    const rows = Array.from(document.getElementById(gridId).children)
      .map(r => Array.from(r.children).map(c => c.dataset.type));
    document.getElementById('layout' + piso).value = JSON.stringify(rows);
  }

  document.addEventListener('DOMContentLoaded', () => {
    const tipo   = document.getElementById('tipo_de_bus'),
          p1     = document.getElementById('asientos_piso1'),
          p2     = document.getElementById('asientos_piso2'),
          div2   = document.getElementById('asientos_piso2_div'),
          block2 = document.getElementById('piso2-block'),
          add1   = document.getElementById('add1'),
          add2   = document.getElementById('add2'),
          sub1   = document.getElementById('sub1'),
          sub2   = document.getElementById('sub2'),
          layout1= document.getElementById('layout1'),
          layout2= document.getElementById('layout2');

    function updateAll() {
      div2.style.display   = tipo.value === 'Doble piso' ? 'block' : 'none';
      block2.style.display = tipo.value === 'Doble piso' ? 'block' : 'none';

      const cnt1 = parseInt(p1.value) || 0,
            cnt2 = parseInt(p2.value) || 0,
            l1   = JSON.parse(layout1.value) || [],
            l2   = JSON.parse(layout2.value) || [];

      render(1, l1.length ? l1 : genLayout(cnt1), 'grid1');

      // Calcular el último número de asiento del piso 1
      let lastNumPiso1 = 0;
      const layoutPiso1 = l1.length ? l1 : genLayout(cnt1);
      layoutPiso1.forEach(row => {
        row.forEach(cell => {
          if (/^\d+$/.test(cell)) {
            lastNumPiso1 = Math.max(lastNumPiso1, parseInt(cell));
          }
        });
      });

      if (tipo.value === 'Doble piso') {
        render(2, l2.length ? l2 : genLayout(cnt2, lastNumPiso1 + 1), 'grid2');
      }
    }

    [tipo, p1, p2].forEach(el => el.addEventListener('input', updateAll));
    add1.addEventListener('click', () => { p1.value++; updateAll(); });
    add2.addEventListener('click', () => { p2.value++; updateAll(); });
    sub1.addEventListener('click', () => { if (p1.value > 1) { p1.value--; updateAll(); } });
    sub2.addEventListener('click', () => { if (p2.value > 0) { p2.value--; updateAll(); } });

    updateAll();
  });
</script>
@endsection
