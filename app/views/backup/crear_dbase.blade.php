@extends('layout.base_formularios')

@section('titulo')
    <h5>Agregar Nuevo Backup de la Base de Datos</h5>
@stop

@section('contenido')

<div>
        
    @if(isset($errors))
      @foreach ($errors->all() as $error)
          <div class="show_error">{{ $error }}</div>
      @endforeach
    @endif

    {{ Form::open(array('url' => 'backups/crear_dbase', 'class' => 'form-horizontal', 'role' => 'form')) }}
  
    <div class="form-group">
        {{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('nombre', Input::old('nombre') ? Input::old('nombre') : $nombre_dbase, array('class' => 'form-control texto_largo')) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ Form::submit('Confirmar', array('class' => 'btn btn-default')) }}
            {{ Form::button('Cancelar', array('class'=>'btn btn-default', 
                'onClick' => "location.href='/backups/index'")) }}
        </div>
    </div>

    {{ Form::close() }}

</div>    

@stop
