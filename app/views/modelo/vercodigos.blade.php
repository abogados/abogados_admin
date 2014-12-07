@extends('layout.base_formularios')

@section('titulo')
  <h4><b>Códigos para los Modelos</b></h4>
@stop

@section('botones_form')
  <div class="botones_form">

  </div>
  <br />
@stop

@section('contenido')

  <div>

    {{ Form::open(array('url' => 'modelos/buscarcodigos', 'class' => 'form-horizontal', 'role' => 'form')) }}

      @include('modelo.buscadorcodigos')

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
                <td> <b>C&oacute;digo</b> </td>
              </tr>
              @foreach($datos as $dato)
              <tr>
                <td> {{ $dato->descripcion }} </td>
                <td> {{ $dato->codigo }} </td>
              </tr>
              @endforeach
          </table>
        </div>
      @endif
    </div>

  </div>
@stop
