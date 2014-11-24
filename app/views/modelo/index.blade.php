@extends('layout.base_formularios')

@section('titulo')
  <h5>Modelos</h5>
@stop

@section('botones_form')
  <div class="botones_form">
    {{ Form::button('Nuevo', array('class'=>'btn btn-default', 
            'onClick' => "location.href='/modelos/crear'")) }}
  </div>
  <br />
@stop

@section('contenido')

  <div>

    {{ Form::open(array('url' => 'modelos/buscar', 'class' => 'form-horizontal', 'role' => 'form')) }}

      @include('modelo.buscador')

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
                <td> <b>Tipo Proceso</b> </td>
                <td> <b>Fecha Creaci&oacute;n</b> </td>
                <td colspan="2"> <b>Operaci&oacute;n</b> </td>
              </tr>
              @foreach($datos as $dato)
              <tr>
                <td> {{ $dato->nombre }} </td>
                <td> {{ $dato->tipo_proceso }} </td>
                <td> {{ $dato->creado_at }} </td>
                <td> 
                  {{ Form::button('Modif.', array('class'=>'btn btn-default btn-xs btn-default-azul', 
                    'onClick' => "location.href='/modelos/modificar/$dato->id'")) }}
                </td>
                <td>
                  {{ Form::button('Elim.', array('class'=>'btn btn-default btn-xs btn-default-azul', 
                    'onClick' => "location.href='/modelos/eliminar/$dato->id'")) }}
                 </td>
              </tr>
              @endforeach
          </table>
        </div>
      @endif
    </div>

  </div>
@stop
