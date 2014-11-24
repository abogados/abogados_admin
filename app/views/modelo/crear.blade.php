@extends('layout.base_formularios')

@section('titulo')
    <h5>Agregar Nuevo Modelo</h5>
@stop

@section('contenido')

<div>
        
    @if(isset($errors))
      @foreach ($errors->all() as $error)
          <div class="show_error">{{ $error }}</div>
      @endforeach
    @endif

    {{ Form::open(array('url' => 'modelos/crear', 'class' => 'form-horizontal', 'role' => 'form')) }}

    <div class="form-group">
        {{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('nombre', Input::old('nombre'), array('class' => 'form-control texto_largo')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('tipo_proceso','Tipo de Proceso',array('id'=>'','class'=>'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::select('tipo_proceso',
                array(''=>'Seleccione...',
                    'Tipo 1'      => 'Tipo 1',
                    'Tipo 2'      => 'Tipo 2',
                    'Tipo 3'      => 'Tipo 3'
                    ), null, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('texto', 'Texto', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::textarea('texto', Input::old('texto'), 
                array('class' => 'form-control texto_largo', 'id' => 'texto', 'cols'=>'100','rows'=>'8')) }}
            <script type="text/javascript">
                CKEDITOR.replace( 'texto' );
            </script>
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
        <div class="col-sm-offset-2 col-sm-10">
            {{ Form::submit('Confirmar', array('class' => 'btn btn-default')) }}
            {{ Form::button('Cancelar', array('class'=>'btn btn-default', 
                'onClick' => "location.href='/modelos/index'")) }}
        </div>
    </div>

    {{ Form::close() }}

</div>    

@stop