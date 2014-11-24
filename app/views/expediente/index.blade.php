@extends('layout.base_formularios')

@section('titulo')
  <h5>Expedientes</h5>
@stop

@section('botones_form')
  <div class="botones_form">
    {{ Form::button('Nuevo', array('class'=>'btn btn-default', 
            'onClick' => "location.href='/expedientes/crear'")) }}
  </div>
  <br />
@stop

@section('contenido')

  <div>

    {{ Form::open(array('url' => 'expedientes/buscar', 'class' => 'form-horizontal', 'role' => 'form')) }}

      @include('expediente.buscador')

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
              <td> <b>Nro. Expediente</b> </td>
              <td> <b>Juzgado</b> </td>
              <td> <b>Car&aacute;tula</b> </td>
              <td> <b>Estado</b> </td>
              <td> <b>Escritos</b> </td>
              <td> <b>Pagos</b> </td>
              <td colspan="2"> <b>Operaci&oacute;n</b> </td>
            </tr>
            @foreach($datos as $dato)
            <tr>
              <td> {{ $dato->numero }} </td>
              <td> {{ $dato->juzgado }} </td>
              <td> {{ $dato->caratula }} </td>
              <td> {{ $dato->estado }} </td>
              <td> 
                {{ Form::button('Esc.', array('class'=>'btn btn-default btn-xs btn-default-azul', 
                  'onClick' => "")) }}
              </td>
              <td> 
                {{ Form::button('Pag.', array('class'=>'btn btn-default btn-xs btn-default-azul', 
                  'onClick' => "")) }}
              </td>            
              <td> 
                {{ Form::button('Modif.', array('class'=>'btn btn-default btn-xs btn-default-azul', 
                  'onClick' => "location.href='/expedientes/modificar/$dato->id'")) }}
              </td>
              <td>
                {{ Form::button('Elim.', array('class'=>'btn btn-default btn-xs btn-default-azul',
                  'data-confirm' => '¿Está seguro que desea Eliminar el registro?', 
                  'onClick' => "location.href='/expedientes/eliminar/$dato->id'")) }}
               </td>
            </tr>
            @endforeach
        </table>
      </div>
      @endif
    </div>

  </div>

@stop
