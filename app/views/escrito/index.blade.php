@extends('layout.base_formularios')

@section('titulo')
  <h4><b>Escritos</b></h4>
@stop

@section('botones_form')
  <div class="botones_form">
    {{ Form::button('Nuevo', array('class'=>'btn btn-default',
            'onClick' => "location.href='/escritos/crear'")) }}
  </div>
  <br />
@stop

@section('contenido')

  <div>

    {{ Form::open(array('url' => 'escritos/buscar', 'class' => 'form-horizontal', 'role' => 'form')) }}

      @include('escrito.buscador')

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
              <td> <b>T&iacute;tulo</b> </td>
              <td> <b>Nro. Expediente</b> </td>
              <td> <b>Tipo Proceso</b> </td>
              <td> <b>Estado</b> </td>
              <td> <b>Fecha Creaci&oacute;n</b> </td>
              <td colspan="2"> <b>Operaci&oacute;n</b> </td>
            </tr>
            @foreach($datos as $dato)
            <tr>
              <td> {{ $dato->titulo }} </td>
              <td> {{ $dato->numero }} </td>
              <td> {{ $dato->tipo_proceso }} </td>
              <td> {{ $dato->estado }} </td>
              <td> {{ $dato->creado_at }} </td>
              <td> 
                {{ Form::button('Modif.', array('class'=>'btn btn-default btn-xs btn-default-azul', 
                  'onClick' => "location.href='/escritos/modificar/$dato->id'")) }}
              </td>
              <td>
                {{ Form::button('Elim.', array('class'=>'btn btn-default btn-xs btn-default-azul', 
                  'onClick' => "location.href='/escritos/eliminar/$dato->id'")) }}
               </td>
            </tr>
            @endforeach
        </table>
      </div>
      @endif
    </div>

  </div>
@stop
