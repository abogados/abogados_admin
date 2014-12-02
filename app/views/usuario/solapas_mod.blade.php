@extends('layout.base_formularios')

@section('titulo')
    <h4><b>Modificar Empleado</b></h4>
@stop

@section('contenido')

@if(isset($errors))
  @foreach ($errors->all() as $error)
      <div class="show_error">{{ $error }}</div>
  @endforeach
@endif

<div>
    {{ Form::hidden('usuario_id', $usuario->id, array('id' => 'usuario_id', 'class' => 'form-control')) }} 

    <ul class="nav nav-tabs" role="tablist">
      <li class="active"><a href="#titular" role="tab" data-toggle="tab">Titular</a></li>
      <li><a href="#grupo_familiar" role="tab" data-toggle="tab">Grupo Familiar</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">

      <div class="tab-pane active" id="titular">
      </div><!-- /#titular -->

      <div class="tab-pane" id="grupo_familiar">
      </div><!-- /#grupo_familiar -->

    </div>

</div>    

@stop
