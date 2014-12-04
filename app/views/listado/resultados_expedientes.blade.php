{{ Form::open(array('url' => 'listados/exportar', 'class' => 'form-horizontal', 'role' => 'form')) }}

<div class="col-sm-10 col-sm-10-85-center">
  <b>Expedientes</b>
</div>
<div>
  {{ Form::submit('Exportar', array('class' => 'btn btn-default btn-default-azul')) }}
</div>
<br />

{{ Form::hidden('tipo_modulo', $datos->tipo_modulo, array('id' => 'tipo_modulo', 'class' => 'form-control')) }}

{{ Form::close() }}

<div class="CSSTableGenerator" >
  <table >
      <tr>
        <td> <b>Car&aacute;tula</b> </td>
        <td> <b>Nro. Expediente</b> </td>
        <td> <b>Juzgado</b> </td>
        <td> <b>Estado</b> </td>
      </tr>
      @foreach($datos as $dato)
      <tr>
        <td> {{ $dato->caratula }} </td>
        <td> {{ $dato->numero }} </td>
        <td> {{ $dato->juzgado }} </td>
        <td> {{ $dato->estado }} </td>
      </tr>
      @endforeach
  </table>
</div>
