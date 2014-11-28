{{ Form::open(array('url' => 'listados/exportar', 'class' => 'form-horizontal', 'role' => 'form')) }}

<div class="col-sm-10 col-sm-10-85-center">
  <b>Empleados</b>
</div>
<div>
  {{ Form::submit('Exportar', array('class' => 'btn btn-default btn-default-azul')) }}
</div>

{{ Form::hidden('tipo_modulo', $datos->tipo_modulo, array('id' => 'tipo_modulo', 'class' => 'form-control')) }}

{{ Form::close() }}

<div class="CSSTableGenerator" >
  <table >
      <tr>
        <td> <b>Nombre y Apellido</b> </td>
        <td> <b>Perfil</b> </td>
        <td> <b>Estado</b> </td>
        <td> <b>Fecha Alta</b> </td>
      </tr>
      @foreach($datos as $dato)
      <tr>
        <td> {{ $dato->nombre }} {{ $dato->apellido }} </td>
        <td> {{ $dato->perfil }} </td>
        <td> {{ $dato->estado }} </td>
        <td> {{ $dato->creado_at }} </td>
      </tr>
      @endforeach
  </table>
</div>
