{{ Form::open(array('url' => 'listados/exportar', 'class' => 'form-horizontal', 'role' => 'form')) }}

<div class="col-sm-10 col-sm-10-85-center">
  <b>Clientes</b>
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
        <td> <b>Apellido</b> </td>
        <td> <b>Nombre</b> </td>
        <td> <b>DNI</b> </td>
        <td> <b>Domicilio</b> </td>
        <td> <b>Localidad</b> </td>
        <td> <b>Tel&eacute;fono</b> </td>
        <td> <b>Celular</b> </td>
        <td> <b>E-mail</b> </td>
        
      </tr>
      @foreach($datos as $dato)
      <tr>
        <td> {{ $dato->apellido }} </td>
        <td> {{ $dato->nombre }} </td>
        <td> {{ $dato->dni }} </td>
        <td> {{ $dato->domicilio }} </td>
        <td> {{ $dato->localidad }} </td>
        <td> {{ $dato->telefono }} </td>
        <td> {{ $dato->celular }} </td>
        <td> {{ $dato->email }} </td>
        
      </tr>
      @endforeach
  </table>
</div>
