@extends('layout.base_formularios')

@section('titulo')
    <h5>Agregar Nueva Tarea/Recordatorio</h5>
@stop

@section('contenido')

<div>
        
    @if(isset($errors))
      @foreach ($errors->all() as $error)
          <div class="show_error">{{ $error }}</div>
      @endforeach
    @endif

    {{ Form::open(array('url' => 'agendas/crear', 'class' => 'form-horizontal', 'role' => 'form')) }}

    <div class="form-group">
        {{ Form::label('descripcion', 'Descripci&oacute;n', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('descripcion', Input::old('descripcion'), array('class' => 'form-control texto_largo', 'size' => '70')) }}
        </div>

        {{ Form::label('tipo_evento','Tipo de Evento',array('id'=>'','class'=>'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::select('tipo_evento',
                array(''=>'Seleccione...',
                    'Tarea'         => 'Tarea',
                    'Recordatorio'  => 'Recordatorio'
                    ),'enabled', array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('fecha', 'Fecha', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('fecha', Input::old('fecha'), 
                array('type' => 'text', 'maxlength' => '10', 
                    'class' => 'form-control datepicker',
                    'placeholder' => 'Click aquí para seleccionar fecha.')) }}
        </div>

        {{ Form::label('fecha_alarma', 'Fecha Alarma', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('fecha_alarma', Input::old('fecha_alarma'), 
                array('type' => 'text', 'maxlength' => '10', 
                    'class' => 'form-control datepicker',
                    'placeholder' => 'Click aquí para seleccionar fecha.')) }}
        </div>
    </div>
        
    <div class="form-group">
        {{ Form::label('hora_alarma', 'Hora Alarma', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('hora_alarma', Input::old('hora_alarma'), 
                array('class' => 'form-control', 'size' => '10', 'maxlength' => '5', 'placeholder' => 'HH:mm (Ej. 23:35)')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('observaciones', 'Observaciones', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::textarea('observaciones', Input::old('observaciones'), 
                array('class' => 'form-control texto_largo', 'cols'=>'80','rows'=>'2')) }}
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-2">
            {{ Form::submit('Confirmar', array('class' => 'btn btn-default')) }}
            {{ Form::button('Cancelar', array('class'=>'btn btn-default', 
                'onClick' => "location.href='/agendas/index'")) }}
        </div>
    </div>

    {{ Form::close() }}

</div>    

<script type="text/javascript">
    validar_campos_form();
    mostrar_datepicker();
</script>

@stop
