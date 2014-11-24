@extends('layout.base_formularios')

@section('titulo')
    <h5>Agregar Nuevo Expediente</h5>
@stop

@section('contenido')

<div>
        
    @if(isset($errors))
      @foreach ($errors->all() as $error)
          <div class="show_error">{{ $error }}</div>
      @endforeach
    @endif

    {{ Form::open(array('url' => 'expedientes/crear', 'class' => 'form-horizontal', 'role' => 'form')) }}

    <div class="form-group">
        {{ Form::label('numero', 'Nro. Expediente', array('class' => 'col-sm-2 col-sm-2-1 control-label')) }}
        <div class="col-sm-10 col-sm-10-1">
            {{ Form::text('numero', Input::old('numero'), array('class' => 'form-control texto_largo', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('caratula', 'Car&aacute;tula', array('class' => 'col-sm-2 col-sm-2-1 control-label')) }}
        <div class="col-sm-10 col-sm-10-1">
            {{ Form::text('caratula', Input::old('caratula'), array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('juzgado', 'Juzgado', array('class' => 'col-sm-2 col-sm-2-1 control-label')) }}
        <div class="col-sm-10 col-sm-10-1">
            {{ Form::text('juzgado', Input::old('juzgado'), array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('estado','Estado',array('id'=>'','class'=>'col-sm-2 col-sm-2-1 control-label')) }}
        <div class="col-sm-10 col-sm-10-1">
            {{ Form::select('estado',
                array(''=>'Seleccione...',
                    'Iniciado'      => 'Iniciado',
                    'En Proceso'    => 'En Proceso',
                    'Finalizado'    => 'Finalizado',
                    'Anulado'       => 'Anulado'
                    ), null, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('fecha_inicio', 'Fecha de Inicio', array('class' => 'col-sm-2 col-sm-2-1 control-label')) }}
        <div class="col-sm-10 col-sm-10-1">
            {{ Form::text('fecha_inicio', Input::old('fecha_inicio'), 
                array('type' => 'text', 'maxlength' => '10', 
                    'class' => 'form-control datepicker',
                    'placeholder' => 'Click aquí para seleccionar fecha.')) }}
            <script type="text/javascript">
                $(function(){
                   $('.datepicker').datepicker({
                      format: 'dd-mm-yyyy'
                    });
                });
            </script>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('fecha_presentacion', 'Fecha de Presentaci&oacute;n', array('class' => 'col-sm-2 col-sm-2-1 control-label')) }}
        <div class="col-sm-10 col-sm-10-1">
            {{ Form::text('fecha_presentacion', Input::old('fecha_presentacion'), 
                array('type' => 'text', 'maxlength' => '10', 
                    'class' => 'form-control datepicker',
                    'placeholder' => 'Click aquí para seleccionar fecha.')) }}
            <script type="text/javascript">
                $(function(){
                   $('.datepicker').datepicker({
                      format: 'dd-mm-yyyy'
                    });
                });
            </script>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('fecha_finalizacion', 'Fecha de Finalizaci&oacute;n', array('class' => 'col-sm-2 col-sm-2-1 control-label')) }}
        <div class="col-sm-10 col-sm-10-1">
            {{ Form::text('fecha_finalizacion', Input::old('fecha_finalizacion'), 
                array('type' => 'text', 'maxlength' => '10', 
                    'class' => 'form-control datepicker',
                    'placeholder' => 'Click aquí para seleccionar fecha.')) }}
            <script type="text/javascript">
                $(function(){
                   $('.datepicker').datepicker({
                      format: 'dd-mm-yyyy'
                    });
                });
            </script>
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('tipo_proceso', 'Tipo de Proceso', array('class' => 'col-sm-2 col-sm-2-1 control-label')) }}
        <div class="col-sm-10 col-sm-10-1">
            {{ Form::select('tipo_proceso',
                array(''    => 'Seleccione...',
                'Tipo 1'    => 'Tipo 1',
                'Tipo 2'    => 'Tipo 2'), null, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('cliente_id', 'Cliente', array('class' => 'col-sm-2 col-sm-2-1 control-label')) }}
        <div class="col-sm-10 col-sm-10-1">
            {{ Form::select('cliente_id',$clientes, null, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10 col-sm-10-1">
            {{ Form::submit('Confirmar', array('class' => 'btn btn-default')) }}
            {{ Form::button('Cancelar', array('class'=>'btn btn-default', 
                'onClick' => "location.href='/expedientes/index'")) }}
        </div>
    </div>

    {{ Form::close() }}

</div>    

@stop