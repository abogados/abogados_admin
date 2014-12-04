@extends('layout.base_formularios')

@section('titulo')
    <h4><b>Agregar Nuevo Modelo</b></h4>
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
        {{ Form::label('nombre', 'Nombre', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('nombre', Input::old('nombre'), array('class' => 'form-control texto_largo')) }}
        </div>
    
        {{ Form::label('tipo_proceso','Tipo de Proceso',array('id'=>'','class'=>'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::select('tipo_proceso',
                array(''=>'Seleccione...',
                    'Civil Común'       => 'Civil Común',
                    'Comercial Común'   => 'Comercial Común',
                    'Sucesiones'        => 'Sucesiones',
                    'Familia'           => 'Familia',
                    'Penal'             => 'Penal',
                    'Laboral'           => 'Laboral',
                    'Documento y Locaciones'    => 'Documento y Locaciones',
                    'Cobro y Apremio'           => 'Cobro y Apremio'
                    ), null, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('texto', 'Texto', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10  col-sm-10-85">
            {{ Form::textarea('texto', Input::old('texto'), 
                array('class' => 'form-control texto_largo', 'id' => 'texto', 'cols'=>'100','rows'=>'8')) }}
            <script type="text/javascript">
                CKEDITOR.replace( 'texto' );
            </script>
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10-30">
            {{ Form::submit('Confirmar', array('class' => 'btn btn-default')) }}
            {{ Form::button('Cancelar', array('class'=>'btn btn-default', 
                'onClick' => "location.href='/modelos/index'")) }}
        </div>
    </div>

    {{ Form::close() }}

</div>    

@stop
