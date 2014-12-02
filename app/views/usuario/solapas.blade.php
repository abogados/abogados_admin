@extends('layout.base_formularios')

@section('titulo')
    <h4><b>Agregar Nuevo Empleado</b></h4>
@stop

@section('contenido')

@if(isset($errors))
  @foreach ($errors->all() as $error)
      <div class="show_error">{{ $error }}</div>
  @endforeach
@endif

<div>

    <ul class="nav nav-tabs" role="tablist">
      <li class="active"><a href="#titular" role="tab" data-toggle="tab" style="color: #045FB4;">Titular</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">

      <div class="tab-pane active" id="titular">
      </div><!-- /#titular -->

    </div>    

</div>    

@stop
