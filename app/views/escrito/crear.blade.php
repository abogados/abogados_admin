@extends('layout.base_formularios')

@section('titulo')
    <h5>Agregar Nuevo Escrito</h5>
@stop

@section('contenido')

<div>
        
    @if(isset($errors))
      @foreach ($errors->all() as $error)
          <div class="show_error">{{ $error }}</div>
      @endforeach
    @endif

    {{ Form::open(array('url' => 'escritos/crear', 'class' => 'form-horizontal', 'role' => 'form')) }}

    <div class="form-group">
        {{ Form::label('titulo', 'T&iacute;tulo', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('titulo', Input::old('titulo'), array('class' => 'form-control texto_largo')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('expediente_id', 'Expediente', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::select('expediente_id',$expedientes, null, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('caratula', 'Car&aacute;tula', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('caratula', Input::old('caratula'), array('class' => 'form-control', 'readonly' => 'readonly')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('juzgado', 'Juzgado', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('juzgado', Input::old('juzgado'), array('class' => 'form-control', 'readonly' => 'readonly')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('tipo_proceso', 'Tipo de Proceso', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('tipo_proceso', Input::old('tipo_proceso'), array('class' => 'form-control', 'readonly' => 'readonly')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('descripcion', 'Descripci&oacute;n', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('descripcion', Input::old('descripcion'), array('class' => 'form-control', 'size' => '70')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('estado','Estado',array('id'=>'','class'=>'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::select('estado',
                array(''=>'Seleccione...',
                    'Activo'    => 'Activo',
                    'Inactivo'  => 'Inactivo'
                    ), null, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('cuerpo', 'Cuerpo', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::textarea('cuerpo', Input::old('cuerpo'), 
                array('class' => 'form-control texto_largo', 'id' => 'cuerpo', 'cols'=>'100','rows'=>'8')) }}
            <script type="text/javascript">
                CKEDITOR.replace( 'cuerpo' );
            </script>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ Form::submit('Confirmar', array('class' => 'btn btn-default')) }}
            {{ Form::button('Cancelar', array('class'=>'btn btn-default', 
                'onClick' => "location.href='/escritos/index'")) }}
        </div>
    </div>

    {{ Form::close() }}

</div>    

@stop
