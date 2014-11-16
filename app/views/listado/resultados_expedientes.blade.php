{{ Form::open(array('url' => 'listados/exportar', 'class' => 'form-horizontal', 'role' => 'form')) }}

<div style="text-align:center;">
  <b>Expedientes</p>
  {{ Form::submit('Exportar', array('class' => 'btn btn-default btn-default-azul')) }}
  
  {{ Form::hidden('tipo_modulo', $datos->tipo_modulo, array('id' => 'tipo_modulo', 'class' => 'form-control')) }}
</div>

{{ Form::close() }}

<div class="CSSTableGenerator" >
  <table >
      <tr>
        <td> <b>Nro. Expediente</b> </td>
        <td> <b>Juzgado</b> </td>
        <td> <b>Car&aacute;tula</b> </td>
        <td> <b>Fecha Inicio</b> </td>
        <td> <b>Cliente</b> </td>
        <td> <b>Estado</b> </td>
      </tr>
      @foreach($datos as $dato)
      <tr>
        <td> {{ $dato->numero }} </td>
        <td> {{ $dato->juzgado }} </td>
        <td> {{ $dato->caratula }} </td>
        <td> {{ $dato->fecha_inicio }} </td>
        <td> {{ $dato->nombre }} {{ $dato->apellido }} </td>
        <td> {{ $dato->estado }} </td>
      </tr>
      @endforeach
  </table>
</div>
