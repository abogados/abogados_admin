@extends('layout.base_formularios')

@section('titulo')
  <h4><b>Clientes</b></h4>
@stop

@section('botones_form')
  <div class="botones_form">
    {{ Form::button('Nuevo', array('class'=>'btn btn-default', 
            'onClick' => "location.href='/clientes/crear'")) }}
  </div>
  <br />
@stop

@section('contenido')

  <div>

    {{ Form::open(array('url' => 'clientes/buscar', 'class' => 'form-horizontal', 'role' => 'form')) }}

      @include('cliente.buscador')

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
              <td> <b>Apellido y Nombre</b> </td>
              <td> <b>DNI</b> </td>
              <td colspan="2"> <b>Operaci&oacute;n</b> </td>
            </tr>
            @foreach($datos as $dato)
            <tr>
              <td> {{ $dato->apellido }} {{ $dato->nombre }}</td>
              <td> {{ $dato->dni }} </td>
              <td> 
                {{ Form::button('Modif.', array('class'=>'btn btn-default btn-xs btn-default-azul', 
                  'onClick' => "location.href='/clientes/modificar/$dato->id'")) }}
              </td>
              <td>
                {{ Form::button('Elim.', array('class'=>'btn btn-default btn-xs btn-default-azul', 
                  'onClick' => "location.href='/clientes/eliminar/$dato->id'")) }}
              </td>
            </tr>
            @endforeach
        </table>
      </div>
      @endif
    </div>

  </div>

@stop
