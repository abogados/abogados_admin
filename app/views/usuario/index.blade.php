@extends('layout.base_formularios')

@section('titulo')
  <h4><b>Empleados</b></h4>
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
        <table>
            <tr>
              <td> <b>Legajo</b> </td>
              <td> <b>Apellido y Nombre</b> </td>
              <td> <b>DNI</b> </td>
              <td> <b>Profesi&oacute;n</b> </td>
              <td> <b>Perfil</b> </td>
              <td> <b>Grupo Familiar</b> </td>
              <td colspan="2"> <b>Operaci&oacute;n</b> </td>
            </tr>
            @foreach($datos as $dato)
            <tr>
              <td> {{ $dato->legajo }}</td>
              <td> {{ $dato->apellido }} {{ $dato->nombre }} </td>
              <td> {{ $dato->dni }} </td>
              <td> {{ $dato->profesion }} </td>
              <td> {{ $dato->perfil }} </td>
              <td> {{ $dato->total_grupo_familiar }} </td>
              <td> 
                {{ Form::button('Modif.', array('class'=>'btn btn-default btn-xs btn-default-azul', 
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
