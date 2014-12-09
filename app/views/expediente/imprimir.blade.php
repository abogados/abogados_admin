<div>
  <div style="width:800px;height:1000px;border-style:solid;border-width:1px;">
    <div style="width:600px;height:900px;border-style:solid;border-width:2px;margin:50px 0px 0px 80px;">
      <div style="text-align:center;margin:170px 0px 0px 0px;font-size:48px;">Expediente Nro {{ $datos->numero }}</div>
      <div style="text-align:center;margin:40px 0px 0px 0px;font-size:20px;">Carátula</div>
      <div style="text-align:center;margin:40px 0px 0px 0px;font-size:32px;">{{ $datos->caratula }}</div>
      <div style="text-align:center;margin:40px 0px 0px 0px;font-size:20px;">Juzgado</div>
      <div style="text-align:center;margin:40px 0px 0px 0px;font-size:32px;">{{ $datos->juzgado }}</div>
      <div style="text-align:center;margin:40px 0px 0px 0px;font-size:20px;">Tipo de Proceso</div>
      <div style="text-align:center;margin:40px 0px 0px 0px;font-size:32px;">{{ $datos->tipo_proceso }}</div>
      <div style="text-align:center;margin:40px 0px 0px 0px;font-size:20px;">Cliente</div>
      <div style="text-align:center;margin:40px 0px 0px 0px;font-size:32px;">{{ $cliente->apellido }} {{ $cliente->nombre }}</div>
    </div>
  </div>
</div>
