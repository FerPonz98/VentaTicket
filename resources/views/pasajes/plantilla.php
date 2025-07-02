{{-- resources/views/pasajes/plantilla.blade.php --}}
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Planilla de Viaje #{{ $viaje->id }}</title>
  <style>
    body { font-family: sans-serif; font-size: 12px; margin: 0; padding: 0; }
    .page { width: 210mm; height: 297mm; padding: 15mm; }
    h1, h2, h3 { margin: 0; padding: 0; }
    .header, .footer { text-align: center; margin-bottom: 10px; }
    .section { margin-bottom: 12px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #333; padding: 4px; text-align: left; }
    th { background: #eee; }
    .no-border td { border: none; }
    .right { text-align: right; }
  </style>
</head>
<body>
  <div class="page">
    <div class="header">
      <h1>Planilla de Viaje</h1>
      <h2>Línea 102 TransGuarayos</h2>
      <small>Salidas diarias diurnas y nocturnas</small>
    </div>

    {{-- Datos generales --}}
    <div class="section">
      <table class="no-border">
        <tr>
          <td><strong>Cód. Salida:</strong> {{ $viaje->id }}</td>
          <td><strong>Bus:</strong> {{ $viaje->bus->codigo }}</td>
          <td><strong>Chofer:</strong> {{ optional($viaje->bus->chofer)->nombre_chofer ?? '–' }}</td>
        </tr>
        <tr>
          <td><strong>Origen:</strong> {{ $viaje->ruta->origen }}</td>
          <td><strong>Destino:</strong> {{ $viaje->ruta->destino }}</td>
          <td><strong>Hora Salida:</strong> {{ $viaje->fecha_salida->format('H:i') }}</td>
        </tr>
      </table>
    </div>

    {{-- Resúmenes de montos --}}
    <div class="section">
      <h3>Resumen de Ventas</h3>
      <table>
        <tr>
          <th>Planilla</th>
          <td class="right">Bs. {{ number_format($totalPasajes = $viaje->pasajes->sum('precio'),2) }}</td>
        </tr>
        <tr>
          <th>Encomienda (pagadas)</th>
          <td class="right">Bs. {{ number_format($totalEncomienda = $viaje->pasajes->sum('monto_encomienda_pagada'),2) }}</td>
        </tr>
        <tr>
          <th>Carga (pagada)</th>
          <td class="right">Bs. {{ number_format($totalCarga = $viaje->pasajes->sum('monto_carga_pagada'),2) }}</td>
        </tr>
        <tr>
          <th>Carga x Pagar</th>
          <td class="right">Bs. {{ number_format($totalCargaXPagar = $viaje->pasajes->sum('monto_carga_xpagar'),2) }}</td>
        </tr>
        <tr>
          <th>Encom. x Pagar</th>
          <td class="right">Bs. {{ number_format($totalEncomiendaXPagar = $viaje->pasajes->sum('monto_encomienda_xpagar'),2) }}</td>
        </tr>
        <tr>
          <th>Sub total</th>
          <td class="right">
            Bs. {{ number_format(
              $totalPasajes
              + $totalEncomienda
              + $totalCarga
              + $totalCargaXPagar
              + $totalEncomiendaXPagar
            ,2) }}
          </td>
        </tr>
        <tr>
          <th>Salida (%)</th>
          <td class="right">{{ number_format(($totalPasajes / $viaje->precio) * 100 ?? 0, 1) }} %</td>
        </tr>
        <tr>
          <th>Observación</th>
          <td>
            @if(($totalPasajes + $totalEncomienda + $totalCarga) > 500)
              Cobrar Bs. 200 adicional
            @else
              —
            @endif
          </td>
        </tr>
      </table>
    </div>

    {{-- Tabla de pasajeros --}}
    <div class="section">
      <h3>Listado de Pasajeros</h3>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Asiento</th>
            <th>Nombre Completo</th>
            <th>CI</th>
            <th>Edad</th>
          </tr>
        </thead>
        <tbody>
          @foreach($viaje->pasajes as $i => $p)
            <tr>
              <td>{{ $i+1 }}</td>
              <td>{{ $p->asiento }}</td>
              <td>{{ $p->nombre_completo }}</td>
              <td>{{ $p->ci_pasajero ?? '–' }}</td>
              <td>{{ $p->edad_pasajero ?? '–' }}</td>
            </tr>
          @endforeach
          @for($j = $viaje->pasajes->count(); $j < 25; $j++)
            {{-- Rellenar hasta 25 filas --}}
            <tr>
              <td>{{ $j+1 }}</td>
              <td>&nbsp;</td><td></td><td></td><td></td>
            </tr>
          @endfor
        </tbody>
      </table>
    </div>

    <div class="footer">
      <small>Impreso: {{ now()->format('Y-m-d H:i') }}</small>
    </div>
  </div>
</body>
</html>
