{{-- resources/views/encomiendas/pdf.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Guía {{ $encomienda->guia_numero }}</title>
  <style>
    /** Ajuste para ancho de 8 cm **/
    @page { size: 8cm auto; margin: 0.3cm; }
    body {
      font-family: 'DejaVu Sans', sans-serif;
      font-size: 8px;
      margin: 0;
      padding: 0;
    }
    .justify {
  text-align: justify;
}
    .center { text-align: center; }
    .small { font-size: 7px; }
    hr { border: none; border-top: 1px solid #000; margin: 2px 0; }
    table { width: 100%; border-collapse: collapse; margin: 2px 0; }
    th, td {
      border: 1px solid #000;
      padding: 1px 2px;
      vertical-align: top;
      word-break: break-word;
      text-align: left;
    }
    .header-row td { border: none; padding: 0; }
    .label-cell { font-weight: bold; }
    .value-cell { }
    th.qty, td.qty { width: 10%; text-align: center; }
    th.desc, td.desc { width: 50%; }
    th.peso, td.peso { width: 20%; text-align: right; }
    th.cost, td.cost { width: 20%; text-align: right; }
    .footer { font-size: 6px; margin-top: 2px; }
    .footer ul { margin: 0; padding: 0 0 0 12px; list-style: disc; }
    .footer p, .footer ul li { margin: 1px 0; }
  </style>
</head>
<body>
  {{-- Encabezado de oficina y rutas --}}
  <div class="center small">
    <strong>SERVICIO INTERPROVINCIAL DE BUSES - Línea 102 TransGuarayos</strong><br>
    <em>Salidas diarias diurnas y nocturnas</em>
    <hr>
    <div>
      <strong>Bimodal:</strong> 346-3993 · 364-8788 · 760-03616 · 766-80112<br>
      <strong>Guarayos:</strong> 966-7087 · 750-25030 · 760-03656<br>
      <strong>Concepción:</strong> 964-3314 · 760-76434 · 770-48491<br>
      <strong>San Javier:</strong> 770-48491 · <strong>El Puente:</strong> 776-70273 · <strong>Yaguarú:</strong> 760-09513 · <strong>Urubichá:</strong> 756-88947
    </div>
    <hr>
    <div class="small center">A: Ascención de Guarayos, San Pablo, Yaguarú, Urubichá, San Ramón, San Javier, Concepción, Surucusí, El Puente, Yotaú</div>
    <hr>
  </div>

  {{-- Metadatos de la encomienda --}}
  <h2 style="text-align:center;">Guía de Encomienda</h2>
<table>
  <tr>
    <td><strong>Nro Guía:</strong> {{ $encomienda->guia_numero }}</td>
    <td><strong>Estado:</strong> {{ ucfirst(str_replace('_', ' ', $encomienda->estado)) }}</td>
    <td><strong>Origen:</strong> {{ $encomienda->viaje->ruta->origen }}</td>
    <td><strong>Destino:</strong> {{ $encomienda->viaje->ruta->destino }}</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Remitente:</strong> {{ $encomienda->remitente_nombre }}</td>
    <td><strong>CI:</strong> {{ $encomienda->remitente_id }}</td>
    <td><strong>Tel. Rmt.:</strong> {{ $encomienda->remitente_telefono }}</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Consignatario:</strong> {{ $encomienda->consignatario_nombre }}</td>
    <td><strong>CI:</strong> {{ $encomienda->consignatario_ci }}</td>
    <td><strong>Tel. Csg.:</strong> {{ $encomienda->consignatario_telefono }}</td>
  </tr>
  <tr>
    <td colspan="2"><strong>Cajero:</strong> {{ optional($encomienda->cajero)->name ?? optional($encomienda->cajero)->nombre }}</td>
    <td><strong>Fecha:</strong> {{ $encomienda->created_at->format('Y-m-d') }}</td>
    <td><strong>Hora:</strong> {{ $encomienda->created_at->format('H:i') }}</td>
  </tr>
</table>
<h2 style="text-align: center;">Detalle de Guía</h2>

{{-- Espacio antes de detalle de ítems --}}
  <div style="height:4px;"></div>

  {{-- Detalle de ítems --}}
  <table>
    <thead>
      <tr>
        <th class="qty">N°</th>
        <th class="qty">Cant.</th>
        <th class="desc">Descripción</th>
        <th class="peso">Peso (Kg)</th>
        <th class="cost">Costo (Bs)S</th>
      </tr>
    </thead>
    <tbody>
      @foreach($encomienda->items as $i => $item)
      <tr>
        <td class="qty">{{ $i+1 }}</td>
        <td class="qty">{{ $item->cantidad }}</td>
        <td class="desc">{{ $item->descripcion }}</td>
        <td class="peso">{{ number_format($item->peso,2) }}</td>
        <td class="cost">{{ number_format($item->costo,2) }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{-- Mensaje y condiciones --}}
  <div class="footer justify">
    <p><strong>Mensaje de aviso (SERÁ ENVIADO DESPUÉS)</strong></p>
    <ul>
      <li>Envio de valores no declarados (Dinero, joyas, etc)</li>
      <li>Pérdida por mal embalaje</li>
      <li>Productos perecederos no recogidos a tiempo</li>
    </ul>
    <p>El cliente acepta Art. 52, 55, 56 y 57 del Reglamento de Operaciones.</p>
  </div>
</body>
</html>
