{{-- resources/views/pasajes/pdf.blade.php --}}
<!DOCTYPE html>
<html><head><meta charset="utf-8">
@php
  $asiento = (int) $pasaje->asiento;
  $piso1 = (int) $pasaje->viaje->bus->asientos_piso1;
  $piso = $asiento <= $piso1 ? 1 : 2;
@endphp
  <style>
    @page { size: 80mm auto; margin: 0; }
    body {
      width: 80mm;
      margin: 0;
      padding: 4px;
      font-family: sans-serif;
      font-size: 11px;
      line-height: 1.3;
    }
    .center { text-align: center; }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 6px;
    }
    td {
      padding: 2px 0;
      vertical-align: top;
      font-size: 11px;
      max-width: 90px;         /* Ajusta el ancho máximo según tu diseño */
      word-break: break-word;  /* Permite salto de línea dentro de la celda */
      white-space: normal;     /* Permite saltos de línea automáticos */
    }
    hr { border: none; border-top: 1px dashed #000; margin: 6px 0; }
    .small { font-size: 9px; }
    .header-logo {
      width: 60px;
      height: auto;
      margin: 0 auto 4px;
      display: block;
    }
    .bold { font-weight: bold; }
  </style>
</head>
<body>

<div class="center small">
    <strong>SERVICIO INTERPROVINCIAL DE BUSES</strong><br>
    <strong>Línea 102 TransGuarayos</strong><br>
    <em>Salidas diarias diurnas y nocturnas</em>
    <hr>

    <div class="small">
      <strong>Teléf. Of. Bimodal:</strong>
      346-3993 · 364-8788 · 760-03616 · 766-80112<br>
      <strong>Teléf. Of. Guarayos:</strong>
      966-7087 · 750-25030 · 760-03656<br>
      <strong>Teléf. Of. Concepción:</strong>
      964-3314 · 760-76434<br>
      <strong>Teléf. Of. San Javier:</strong>
      770-48491<br>
      <strong>El Puente:</strong>
      776-70273<br>
      <strong>Yaguarú:</strong>
      760-09513<br>
      <strong>Urubichá:</strong>
      756-88947
    </div>
    <hr>

    <div class="small">
    <strong>A: <strong> 
      Ascención de Guarayos, San Pablo, Yaguarú, Urubichá,<br>
      San Ramón, San Javier, Concepción, Surucusí, El Puente, Yotaú
    </div>
    <hr>
  </div>

  {{-- === METADATOS DEL BOLETO === --}}
  <div class="center">
    <div class="bold">BOLETO #{{ $pasaje->id }}</div>
    <div class="small">{{ $pasaje->created_at->format('Y-m-d H:i') }}</div>
  </div>

  {{-- === DATOS PRINCIPALES === --}}
  <table style="width:100%; margin-bottom: 6px;">
  <tr>
    <td><strong>Viaje:</strong></td>
    <td>{{ $pasaje->viaje->ruta->origen }} a {{ $pasaje->destino }}</td>
  </tr>
  <tr>
    <td><strong>Asiento:</strong></td>
    <td>{{ $pasaje->asiento }} (Piso {{ $piso }})</td>
  </tr>
  <tr>
    <td><strong>Pasajero:</strong></td>
    <td>{{ $pasaje->nombre_completo }}</td>
  </tr>
  <tr>
    <td><strong>Tipo:</strong></td>
    <td>{{ ucfirst($pasaje->tipo_pasajero) }}</td>
  </tr>
  <tr>
    <td><strong>Fecha:</strong></td>
    <td>
      {{ \Carbon\Carbon::parse($pasaje->viaje->fecha_salida)->format('Y-m-d') }}
    </td>
  </tr>
  <tr>
    <td><strong>Hora:</strong></td>
    <td>
      {{ \Carbon\Carbon::parse($pasaje->viaje->fecha_salida)->format('H:i') }}
    </td>
  </tr>
  <tr>
    <td><strong>Pago:</strong></td>
    <td>{{ ucfirst($pasaje->forma_pago) }}</td>
  </tr>
  <tr>
    <td><strong>Precio:</strong></td>
    <td>Bs. {{ number_format($pasaje->precio,2) }}</td>
  </tr>
  <tr>
    <td><strong>Cajero:</strong></td>
    <td>{{ optional($pasaje->cajero)->nombre_usuario ?? $pasaje->cajero_id }}</td>
  </tr>
</table>

  <hr>

  {{-- === INSTRUCCIONES Y NOTAS === --}}
  <div class="bold small">
  Sr. PASAJERO,<br>
  1.- Presentarse en oficina 30 minutos antes de la salida del bus.<br>
2.- La línea se reserva el derecho de cambiar el bus en caso de necesidad.<br>
3.- En caso de cambio de horario o fecha de viaje, deberá hacerse<br>
con anticipación de 2 horas antes del horario de salida.<br>
4.- El equipaje de mano, prendas y otros objetos que se lleven<br>
dentro del bus, queda bajo única responsabilidad del pasajero.<br>
5.- Cada pasajero tiene derecho a 15 Kilos de equipaje o carga libre, debiendo pagar por el excedente.<br>
6.- Está totalmente prohibido llevar dentro<br>
del bus cualquier tipo de animales, materiales explosivos e inflamables<br> 
y otros que despidan malos olores, o escuchar artefactos con alto volumen.<br>
7.- No hay devolución de pasajes una vez retirado de oficina.<br>
8.- Al adquirir el pasaje, acepta todas las condiciones estipuladas en el presente.<br>
</div>

  <div class="center ">
    <em>¡Gracias por su preferencia!!!</em>
  </div>

</body>
</html>


