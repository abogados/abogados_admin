@extends('layout.base_formularios')

@section('titulo')
  <h5>Agenda</h5>
@stop

@section('botones_form')
  <div class="botones_form">
    {{ Form::button('Nuevo', array('class'=>'btn btn-default', 
            'onClick' => "location.href='/agendas/crear'")) }}
  </div>
  <br />
@stop

@section('contenido')

  <div>

    {{ Form::open(array('url' => 'agendas/buscar', 'class' => 'form-horizontal', 'role' => 'form')) }}

      @include('agenda.buscador')

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
              <td> <b>Descripci&oacute;n</b> </td>
              <td> <b>Tipo</b> </td>
              <td> <b>Fecha</b> </td>
              <td> <b>Estado</b> </td>
              <td colspan="2"> <b>Operaci&oacute;n</b> </td>
            </tr>
            @foreach($datos as $dato)
            <tr>
              <td> {{ $dato->descripcion }} </td>
              <td> {{ $dato->tipo_evento }} </td>
              <td> {{ $dato->fecha }} </td>
              <td> {{ $dato->estado }} </td>
              <td> 
                {{ Form::button('Modif.', array('class'=>'btn btn-default btn-xs btn-default-azul', 
                  'onClick' => "location.href='/agendas/modificar/$dato->id'")) }}
              </td>
              <td>
                {{ Form::button('Elim.', array('class'=>'btn btn-default btn-xs btn-default-azul', 
                  'onClick' => "location.href='/agendas/eliminar/$dato->id'")) }}
               </td>
            </tr>
            @endforeach
        </table>
      </div>
      @endif
    </div>  

  </div>

@stop
