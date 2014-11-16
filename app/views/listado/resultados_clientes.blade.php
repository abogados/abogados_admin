{{ Form::open(array('url' => 'listados/exportar', 'class' => 'form-horizontal', 'role' => 'form')) }}

<div style="text-align:center;">
  <b>Clientes</p>
  {{ Form::submit('Exportar', array('class' => 'btn btn-default btn-default-azul')) }}
  
  {{ Form::hidden('tipo_modulo', $datos->tipo_modulo, array('id' => 'tipo_modulo', 'class' => 'form-control')) }}
</div>

{{ Form::close() }}

<div class="CSSTableGenerator" >
  <table >
      <tr>
        <td> <b>Nombre y Apellido</b> </td>
        <td> <b>DNI</b> </td>
        <td> <b>Estado</b> </td>
        <td> <b>Fecha Alta</b> </td>
      </tr>
      @foreach($datos as $dato)
      <tr>
        <td> {{ $dato->nombre }} {{ $dato->apellido }} </td>
        <td> {{ $dato->dni }} </td>
        <td> {{ $dato->estado }} </td>
        <td> {{ $dato->creado_at }} </td>
      </tr>
      @endforeach
  </table>
</div>
