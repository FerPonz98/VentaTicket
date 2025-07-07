{{-- resources/views/cargas/pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Guía de Carga {{ $carga->nro_guia }}</title>
  <style>
    /** Ajuste para ancho de 8 cm **/
    @page { size: 8cm auto; margin: 0.3cm; }
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 8px;
      margin: 0;
      padding: 0;
    }
    .container {
      width: 100%;
      margin: 0;
      padding: 0;
    }
    h2 {
      font-size: 11px;
      margin: 2px 0;
    }
    p, ul {
      margin: 0;
      padding: 0;
    }
    ul {
      list-style: disc inside;
      margin: 2px 0 4px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 4px 0;
    }
    th, td {
      border: 1px solid #000;
      padding: 1px 2px;
      font-size: 7px;
      vertical-align: top;
      text-align: left;
      max-width: 60px;        
      word-break: break-word;  
    }
    .descripcion-col {
      max-width: 90px;
      word-break: break-word;
    }
    .header-row td {
      border: none;
      padding: 1px 0;
    }
    .footer {
      font-size: 6px;
      margin-top: 4px;
    }
    .footer p, .footer ul { margin-bottom: 1px; }
    .center {
      text-align: center;
    }
    .small {
      font-size: 8px;
    }
  </style>
</head>
<body>
    
<div class="center small">
    <strong>SERVICIO INTERPROVINCIAL DE BUSES</strong><br>
    <strong>Línea 102 TransGuarayos</strong><br>
    <em>Salidas diarias diurnas y nocturnas</em>
    <hr>

    <div class=" center small">
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

  {{-- === METADATOS DE LA CARGA === --}}
  <div class="container">
    <h2 style="text-align:center;">Guía de Carga</h2>
    <table style="width:100%; margin-bottom: 6px;">
      <tr>
        <td><strong>Nro Guía:</strong> {{ $carga->nro_guia }}</td>
        <td><strong>Estado:</strong> {{ ucfirst(str_replace('_',' ',$carga->estado)) }}</td>
        <td><strong>Origen:</strong> {{ $carga->origen }}</td>
        <td><strong>Destino:</strong> {{ $carga->destino }}</td>
      </tr>
      <tr>
        <td colspan="2"><strong>Remitente:</strong> {{ $carga->remitente_nombre }}</td>
        <td><strong>CI:</strong> {{ $carga->remitente_ci }}</td>
        <td><strong>Tel:</strong> {{ $carga->remitente_telefono }}</td>
      </tr>
      <tr>
        <td colspan="2"><strong>Cajero:</strong> {{ $carga->cajero?->nombre_usuario ?? '-' }}</td>
        <td><strong>Fecha:</strong> {{ $carga->created_at->format('d/m/Y') }}</td>
        <td><strong>Hora:</strong> {{ $carga->created_at->format('H:i') }}</td>
      </tr>
    </table>

    <h2>Detalle de Guía</h2>
    <table>
      <thead>
        <tr>
          <th style="width:8%">Nro</th>
          <th style="width:18%">Cant.</th>
          <th class="descripcion-col" style="width:38%">Descripción</th>
          <th style="width:18%">Peso (Kg)</th>
          <th style="width:18%">Costo (Bs)</th>
        </tr>
      </thead>
      <tbody>
        @foreach($carga->detalles as $i => $item)
          <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $item->cantidad }}</td>
            <td class="descripcion-col">{{ $item->descripcion }}</td>
            <td>{{ number_format($item->peso, 2) }}</td>
            <td>{{ number_format($item->costo, 2) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <hr>
    <p><strong>Mensaje de aviso (SERÁ ENVIADO DESPUÉS)</strong></p>
    <ul>
      <li>Envío de valores no declarados (Dinero, joyas, etc)</li>
      <li>Pérdida por mal embalaje</li>
      <li>Productos perecederos no recogidos a tiempo</li>
    </ul>
    <p>El cliente acepta Art. 52, 55, 56, 57 del Reglamento de Operaciones.</p>
  </div>
</body>
</html>
