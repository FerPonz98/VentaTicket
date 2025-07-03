<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <style>
    @page { size: 21.59cm 35.56cm; margin: 0.5cm; }
    body { margin:0; padding:0; font-family: Arial, sans-serif; -webkit-print-color-adjust: exact; }
    .header { position: relative; height: 4cm; text-align: center; }
    .header img { position: absolute; top: 0.5cm; width: 3cm; height: auto; }
    .header img.left { left: 0.5cm; }
    .header img.right { right: 0.5cm; }
    .header .title    { font-size: 24pt; color: #c0392b; margin-top: 0.5cm; }
    .header .subtitle { font-size: 18pt; color: #2980b9; }
    .header .tagline  { font-size: 10pt; color: #555; }

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
    .pasajeros-table thead th { background:#f0f0f0; }
    .footer { position: fixed; bottom:0.3cm; width:100%; text-align:center; font-size:8pt; color:#555; }
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
    <img src="{{ asset('images/bus_left.png') }}" class="left" />
    <img src="{{ asset('images/bus_right.png') }}" class="right"/>
    <div class="title">Servicio Interprovincial de Buses</div>
    <div class="subtitle">Línea 102 TransGuarayos</div>
    <div class="tagline">COMODIDAD Y PUNTUALIDAD ANTE TODO</div>
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

  <pre>

</pre>
</body>
</html>
