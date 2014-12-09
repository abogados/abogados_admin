<div>
  <div style="width:800px;">
    <div style="text-align:justify;margin:40px 0px 0px 50px;">
      Expediente Nro.: {{ $expediente->nro }}<br />
      Carátula: {{ $expediente->caratula }}<br />
      Tipo de Proceso: {{ $expediente->tipo_proceso }}<br />
      Juzgado: {{ $expediente->juzgado }}<br />
    </div>
    <div style="text-align:justify;margin:40px 0px 0px 50px;">{{ $datos->cuerpo }}</div>
    <div style="text-align:right;margin:60px 0px 0px 0px;font-size:16px;">Firma:.................................</div>
  </div>
</div>
