<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <style>
    @page { size: 21.59cm 35.56cm; margin: 0.5cm; }
    body { margin:0; padding:0; font-family: Arial, sans-serif; -webkit-print-color-adjust: exact; }
    .header { position: relative; height: 4.3cm; text-align: center; }
    .header img { position: absolute; top: 0.2cm; height: auto; }
    .header img.left { left: 0.8cm; width: 4cm; }
    .header img.right { right: 0.8cm;  width: 4cm;}
    .header img.center {
    width: 5cm;
    height: auto;
    left: 50%;
    top: 0.8cm;
    transform: translateX(-50%);
    position: absolute;
}
    .header .title    { font-size: 28pt; color: #c0392b; margin-top: 0.5cm; }
    .header .servicio {
    color: #c0392b;
    font-size: 16pt;
    font-weight: bold;
}
.header .comodidad {
    font-size:11pt;
    color:#c0392b;
    font-weight:bold;
    margin-top:2.7cm; 
}

    .fields { width:100%; font-size:9pt; border-collapse: collapse; margin:0.3cm 0; page-break-inside: avoid; }
    .fields td { padding:0.1cm 0.3cm; vertical-align: top; }
    .fields td.label { font-weight:bold; width:3cm; }
    .fields td.value { border-bottom:1px dotted #aaa; padding-bottom:0.1cm; }
    .fields td.right.label, .fields td.right.value { text-align:right; }

    .totals { width:100%; font-size:9pt; border-collapse: collapse; margin:0.3cm 0; page-break-inside: avoid; }
    .totals td, .totals th { padding:0.2cm; border-bottom:1px solid #ddd; }
    .totals .right { text-align:right; }

    .seat-map { padding:0.3cm; box-sizing:border-box; page-break-inside: avoid; }
    .seat-map table { width:100%; border-collapse: collapse; }
    .seat-map td { width:1.2cm; height:1cm; border:1px solid #333; text-align:center; font-size:8pt; }
    .seat-map .aisle { border:none; width:0.5cm; }
    .seat-map .empty { border:none; }
    .seat-map td.sold { color:green; }
    .seat-map td.nosold { color:red; }
    .seat-map .label { font-size:9pt; font-weight:bold; }
    .entrance { position:relative; margin-top:0.2cm; font-size:10pt; font-weight:bold; }

    .pasajeros-table { width:100%; font-size:8pt; border-collapse: collapse; margin-top:0.5cm; }
    .pasajeros-table th, .pasajeros-table td { border:1px solid #ddd; padding:0.2cm; }
    .pasajeros-table td, .pasajeros-table th {
    max-width: 3.5cm;
    word-break: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: pre-line;
}
    .pasajeros-table td:nth-child(5), .pasajeros-table th:nth-child(5) { 
    max-width: 3cm;
}
    .pasajeros-table thead th { background:#f0f0f0; }
    .footer { position: fixed; bottom:0.3cm; width:100%; text-align:center; font-size:8pt; color:#555; }
    .estrellas {
    color: #c0392b;
    font-size: 15pt;
    font-family: DejaVu Sans, sans-serif;
}
  </style>
</head>
<body>
  
@php
    function genLayout($count, $start = 1) {
      $rows = []; $full = intdiv($count,4); $rem = $count % 4; $n = $start;
      for($i=0;$i<$full;$i++){ $rows[] = [$n++,$n++,'aisle',$n++,$n++]; }
      if($rem){ $row=[]; for($i=0;$i<$rem;$i++) $row[]=(string)$n++; while(count($row)<5) $row[]='empty'; $rows[]=$row; }
      return $rows;
    }
    $layout1 = genLayout($viaje->bus->asientos_piso1, 1);

    // Calcular el último número de asiento del piso 1
    $lastNumPiso1 = $viaje->bus->asientos_piso1;
    if (count($layout1)) {
        $last = end($layout1);
        foreach ($last as $cell) {
            if (is_numeric($cell)) {
                $lastNumPiso1 = (int)$cell;
            }
        }
    }

    $layout2 = $viaje->bus->tipo_de_bus === 'Doble piso'
        ? genLayout($viaje->bus->asientos_piso2, $lastNumPiso1 + 1)
        : [];
    $ocupados = $viaje->pasajes->pluck('asiento')->map(fn($a)=>(int)$a)->toArray();
@endphp

  <div class="header">
    <div class="servicio">Servicio Interprovincial de Buses</div>
    <img src="{{ public_path('build/img/logo-empresa.jpg') }}" class="center" />
    <img src="{{ public_path('build/img/bus_derecha.png') }}" class="right"/>
    <img src="{{ public_path('build/img/bus_izq.png') }}" class="left"/>
    <div class="comodidad">COMODIDAD Y PUNTUALIDAD ANTE TODO</div>
    <div class="estrellas">&#9733; &#9733; &#9733; &#9733; &#9733;</div>
  </div>

  <table class="fields">
    <tr>
      <td class="label">Bus:</td><td class="value">{{ $viaje->bus->placa }}</td>
      <td class="label right">Planilla:</td><td class="value right">{{ $viaje->id }}</td>
    </tr>
    <tr>
      <td class="label">Hrs. Salida:</td>
      <td class="value">{{ \Carbon\Carbon::parse($viaje->fecha_salida)->format('H:i') }}</td>
      <td class="label right">Manifiesto:</td>
      <td class="value right">__________</td>
    </tr>
    <tr>
      <td class="label">Día/Fecha:</td>
      <td class="value">{{ \Carbon\Carbon::parse($viaje->fecha_salida)->format('Y-m-d') }}</td>
      <td class="label right">Carga Pagada:</td>
      <td class="value right">Bs {{ number_format($totalCargasPagadas,2) }}</td>
    </tr>
    <tr>
      <td class="label">Destino:</td><td class="value">{{ $viaje->ruta->destino }}</td>
      <td class="label right">Carga x Pagar:</td><td class="value right">Bs {{ number_format($totalCargasXpagar,2) }}</td>
    </tr>
    <tr>
      <td class="label">Conductor:</td>
      <td class="value">
{{ $viaje->bus->chofer?->nombre_chofer ?? '-' }}
      </td>
      <td class="label right">Sub-Total:</td><td class="value right">Bs {{ number_format($subtotal,2) }}</td>
    </tr>
    <tr>
      <td class="label">Licencia N°:</td><td class="value">{{ $conductorLicense }}</td>
      <td class="label right">Salida (o) %:</td><td class="value right">@if($retenido) Bs {{ $retenido }} @else Bs 0 @endif</td>
    </tr>
    <tr>
      <td class="label">Placa N°:</td><td class="value">{{ $viaje->bus->placa }}</td>
      <td class="label right">Total:</td><td class="value right">Bs {{ number_format($totalFinal,2) }}</td>
    </tr>
    <tr>
      <td class="label">Ayudante:</td><td class="value">{{ $viaje->ayudante?->nombre ?? '0' }}</td>
      <td class="label right">&nbsp;</td><td class="value right">&nbsp;</td>
    </tr>
  </table>

  <table class="totals">
    <tr><td>Pasajes vendidos</td><td class="right">Bs {{ number_format($totalPasajes,2) }}</td></tr>
    <tr><td>Encom. pagadas</td><td class="right">Bs {{ number_format($totalEncomPagadas,2) }}</td></tr>
    <tr><td>Carga pagada</td><td class="right">Bs {{ number_format($totalCargasPagadas,2) }}</td></tr>
    <tr><td>Carga x pagar</td><td class="right">Bs {{ number_format($totalCargasXpagar,2) }}</td></tr>
    <tr><td>Encom. x pagar</td><td class="right">Bs {{ number_format($totalEncomXpagar,2) }}</td></tr>
    <tr><th>Subtotal</th><th class="right">Bs {{ number_format($subtotal,2) }}</th></tr>
    <tr><th>Retención</th><th class="right">Bs {{ number_format($retenido,2) }}</th></tr>
    <tr><th>Total final</th><th class="right">Bs {{ number_format($totalFinal,2) }}</th></tr>
  </table>

  <div class="seat-map">
    <table>
      <tr><td colspan="5" class="label">Piso 1</td></tr>
      @foreach($layout1 as $row)
      <tr>
        @foreach($row as $cell)
          @if($cell === 'aisle')
            <td class="aisle"></td>
          @elseif($cell === 'empty')
            <td class="empty"></td>
          @else
            @php $num=(int)$cell; @endphp
            <td class="{{ in_array($num,$ocupados)?'sold':'nosold' }}">{{ $num }}</td>
          @endif
        @endforeach
      </tr>
      @endforeach
      @if(count($layout2))
      <tr><td colspan="5" class="label" style="padding-top:0.3cm;">Piso 2</td></tr>
      @foreach($layout2 as $row)
      <tr>
        @foreach($row as $cell)
          @if($cell==='aisle') <td class="aisle"></td>
          @elseif($cell==='empty') <td class="empty"></td>
          @else
            @php $num=(int)$cell; @endphp
            <td class="{{ in_array($num,$ocupados)?'sold':'nosold' }}">{{ $num }}</td>
          @endif
        @endforeach
      </tr>
      @endforeach
      @endif
    </table>
  </div>

  <h3>Tabla de Pasajeros</h3>
  <table class="pasajeros-table">
    <thead>
      <tr>
        <th>NR</th><th>Asiento</th><th>Nombre Completo</th><th>CI</th><th>Edad</th>
      </tr>
    </thead>
    <tbody>
      @foreach($viaje->pasajes as $i => $p)
        <tr>
          <td>{{ $i+1 }}</td>
          <td>{{ $p->asiento }}</td>
          <td>{{ $p->nombre_completo }}</td>
          <td>{{ $p->ci_usuario }}</td>
          <td>{{ $p->edad }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

{{-- Tabla de Encomiendas --}}
<h3>Tabla de Encomiendas</h3>
<table class="pasajeros-table">
    <thead>
        <tr>
            <th>N° Guía</th>
            <th>Remitente</th>
            <th>Destinatario</th>
            <th>Destino</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Costo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($viaje->encomiendas ?? [] as $e)
            @php
                $item = $e->items->first();
            @endphp
            <tr>
                <td>{{ $e->guia_numero ?? '-' }}</td>
                <td>{{ $e->remitente_nombre ?? '-' }}</td>
                <td>{{ $e->consignatario_nombre ?? '-' }}</td>
                <td>{{ $e->destino ?? '-' }}</td>
                <td>{{ $item->descripcion ?? '-' }}</td>
                <td>{{ $e->estado ?? '-' }}</td>
                <td>Bs {{ number_format($e->costo ?? 0, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{-- Tabla de Cargas --}}
<h3>Tabla de Cargas</h3>
<table class="pasajeros-table">
    <thead>
        <tr>
            <th>N° Guía</th>
            <th>Remitente</th>
            <th>Destino</th>
            <th>Estado</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($viaje->cargas ?? [] as $c)
            <tr>
                <td>{{ $c->nro_guia }}</td>
                <td>{{ $c->remitente_nombre }}</td>
                <td>{{ $c->destino }}</td>
                <td>{{ $c->estado }}</td>
                <td>Bs {{ number_format($c->detalles->sum('costo'), 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
  <pre>

</pre>
</body>
</html>
