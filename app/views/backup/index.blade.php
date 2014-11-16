@extends('layout.base_formularios')

@section('titulo')
  <h5>Backups</h5>
@stop

@section('botones_form')
  <div class="botones_form">
    {{ Form::button('Nuevo DBase', array('class'=>'btn btn-default', 
            'onClick' => "location.href='/backups/crear_dbase'")) }}
  </div>
  <br />
@stop

@section('contenido')

  <div>

    {{ Form::open(array('url' => 'backups/buscar', 'class' => 'form-horizontal', 'role' => 'form')) }}

      @include('backup.buscador')

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
              <td> <b>Nombre</b> </td>
              <td> <b>Tipo</b> </td>
              <td> <b>Fecha Creaci&oacute;n</b> </td>
              <td> <b>Operaci&oacute;n</b> </td>
            </tr>
            @foreach($datos as $dato)
            <tr>
              <td>  {{ $dato->nombre }} </td>
              <td>  {{ $dato->tipo }} </td>
              <td>  {{ $dato->creado_at }} </td>
              <td> 
                {{ Form::button('Descargar', array('class'=>'btn btn-default btn-xs btn-default-azul', 
                  'onClick' => "location.href='/backups/$dato->nombre'")) }}
              </td>
            </tr>
            @endforeach
        </table>
      </div>
      @endif
    </div>

  </div>
@stop
