{{ Form::open(array('url' => 'listados/exportar', 'class' => 'form-horizontal', 'role' => 'form')) }}

<div class="col-sm-10 col-sm-10-85-center">
  <b>Empleados</b>
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
        <td> <b>Legajo</b> </td>
        <td> <b>Apellido</b> </td>
        <td> <b>Nombre</b> </td>
        <td> <b>DNI</b> </td>
        <td> <b>Profesi&oacute;n</b> </td>
        <td> <b>Perfil</b> </td>
      </tr>
      @foreach($datos as $dato)
      <tr>
        <td> {{ $dato->legajo }}</td>
        <td> {{ $dato->apellido }} {{ $dato->nombre }} </td>
        <td> {{ $dato->dni }} </td>
        <td> {{ $dato->profesion }} </td>
        <td> {{ $dato->perfil }} </td>
      </tr>
      @endforeach
  </table>
</div>
