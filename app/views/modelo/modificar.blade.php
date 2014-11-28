@extends('layout.base_formularios')

@section('titulo')
    <h5>Modificar Modelo</h5>
@stop

@section('contenido')

<div>

    @if(isset($errors))
      @foreach ($errors->all() as $error)
          <div class="show_error">{{ $error }}</div>
      @endforeach
    @endif

    {{ Form::open(array('url' => 'modelos/modificar/'.$modelo->id, 'class' => 'form-horizontal', 'role' => 'form')) }}

    <div class="form-group">
        {{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('nombre', Input::old('nombre') ? Input::old('nombre') : $modelo->nombre, array('class' => 'form-control texto_largo')) }}
        </div>
    
        {{ Form::label('tipo_proceso','Tipo de Proceso',array('id'=>'','class'=>'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::select('tipo_proceso',
                array(''=>'Seleccione...',
                    'Tipo 1'      => 'Tipo 1',
                    'Tipo 2'      => 'Tipo 2',
                    'Tipo 3'      => 'Tipo 3'
                    ), $modelo->tipo_proceso, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('estado','Estado',array('id'=>'','class'=>'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::select('estado',
                array(''=>'Seleccione...',
                    'Activo'    => 'Activo',
                    'Inactivo'  => 'Inactivo'
                    ), $modelo->estado, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('texto', 'Texto', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-85">
            {{ Form::textarea('texto', Input::old('texto') ? Input::old('texto') : $modelo->texto, 
                array('class' => 'form-control texto_largo', 'id' => 'texto', 'cols'=>'100','rows'=>'8')) }}
            <script type="text/javascript">
                CKEDITOR.replace( 'texto');
            </script>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2">
            {{ Form::submit('Modificar', array('class' => 'btn btn-default')) }}
            {{ Form::button('Cancelar', array('class'=>'btn btn-default', 
                'onClick' => "location.href='/modelos/index'")) }}
        </div>
    </div>

    {{ Form::close() }}

</div>

@stop
