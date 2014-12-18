<div>
  <div style="width:800px; padding:1px; border-style:solid; border-width:1px;">
    <table border="1" width="800px;" cellpadding="5" style="border:black;">
      <tr>
        <td rowspan="2" style="text-align:center;" width="500px">
          LawSie <br />
          CUIT: 30-28542875-8 - Av. Salta 345 - Tel: (0381) 4225912
        </td>
        <td>Fecha</td>
        <td>{{ $datos->creado_at }}</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3">
          @if($datos->expediente_id > 0)
            Expediente {{ $expediente->caratula }} - {{ $expediente->tipo_proceso }} - {{ $expediente->numero }} - {{ $expediente->juzgado }}
          @endif
        </td>
      </tr>
      <tr>
        <td colspan="2" style="text-align:center;font-weight:bold;">Detalle</td>
        <td style="text-align:center;font-weight:bold;">Monto</td>
      </tr>
      <tr>
        <td colspan="2">{{ $datos->tipo_operacion }}</td>
        <td style="text-align:right;">$ {{ $datos->monto }}</td>
      </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" style="text-align:right;font-weight:bold;">Total</td>
        <td style="text-align:right;">$ {{ $datos->monto }}</td>
      </tr>
    </table>
  </div>
</div>
