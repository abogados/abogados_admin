@extends('layout.base_formularios')

@section('titulo')
  <h5>Listados</h5>
@stop

@section('botones_form')
  <br />
@stop

@section('contenido')

  <div>

    {{ Form::open(array('url' => 'listados/buscar', 'class' => 'form-horizontal', 'role' => 'form')) }}

      @include('listado.buscador')

    {{ Form::close() }}

    @if($errors->has())
      @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
      @endforeach
    @endif

    <div class="buscador_contenedor buscador_contenedor_grilla">
      @if(count($datos) === 0)
        <p>Seleccione un Tipo de M&oacute;dulo para generar el Listado.</p>
      @else
        
        @if($datos->tipo_modulo === 'Empleados')
          @include('listado.resultados_usuarios')
        @endif

        @if($datos->tipo_modulo === 'Clientes')
          @include('listado.resultados_clientes')
        @endif

        @if($datos->tipo_modulo === 'Expedientes')
          @include('listado.resultados_expedientes')
        @endif

      @endif
    </div>

  </div>
@stop
