@extends('layout.base_formularios')

@section('titulo')
  <h5>Empleados</h5>
@stop

@section('botones_form')
  <div class="botones_form">
    {{ Form::button('Nuevo', array('class'=>'btn btn-default', 
            'onClick' => "location.href='/usuarios/solapas'")) }}
  </div>
  <br />
@stop

@section('contenido')

  <div>

    {{ Form::open(array('url' => 'usuarios/buscar', 'class' => 'form-horizontal', 'role' => 'form')) }}

      @include('usuario.buscador')

    {{ Form::close() }}

    @if($errors->has())
      @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
      @endforeach
    @endif

    <div class="buscador_contenedor buscador_contenedor_grilla">
      @if(count($datos) == 0)
        <p>No se encontraron resultados.</p>
      @else
      <div class="CSSTableGenerator" >
        <table >
            <tr>
              <td> <b>Nombre y Apellido</b> </td>
              <td> <b>Perfil</b> </td>
              <td> <b>Estado</b> </td>
              <td> <b>Fecha Alta</b> </td>
              <td colspan="2"> <b>Operaci&oacute;n</b> </td>
            </tr>
            @foreach($datos as $dato)
            <tr>
              <td> {{ $dato->nombre }} {{ $dato->apellido }} </td>
              <td> {{ $dato->perfil }} </td>
              <td> {{ $dato->estado }} </td>
              <td> {{ $dato->creado_at }} </td>
              <td> 
                {{ Form::button('Mod.', array('class'=>'btn btn-default btn-xs btn-default-azul', 
                  'onClick' => "location.href='/usuarios/solapas_mod/$dato->id'")) }}
              </td>
              <td>
                {{ Form::button('Elim.', array('class'=>'btn btn-default btn-xs btn-default-azul', 
                  'onClick' => "location.href='/usuarios/eliminar/$dato->id'")) }}
              </td>
            </tr>
            @endforeach
        </table>
      </div>
      @endif
    </div>

  </div>

@stop
