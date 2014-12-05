@extends('layout.base_formularios')

@section('titulo')
    <h4><b>Agregar Nuevo Escrito</b></h4>
@stop

@section('contenido')

<div>
        
    @if(isset($errors))
      @foreach ($errors->all() as $error)
          <div class="show_error">{{ $error }}</div>
      @endforeach
    @endif

    @if(Session::has('expediente_id'))

    <div>
        <h5><b>Expediente:</b></h5>
        <h5>Car&aacute;tula: <b>{{ $expediente_datos->caratula }}</b></h5>
        <h5>Tipo de Proceso: <b>{{ $expediente_datos->tipo_proceso }}</b></h5>
        <h5>N&uacute;mero: <b>{{ $expediente_datos->numero==''?'-':$expediente_datos->numero }}</b></h5>
        <h5>Juzgado: <b>{{ $expediente_datos->juzgado==''?'-':$expediente_datos->juzgado }}</b></h5>
    </div>

    @endif

    {{ Form::open(array('url' => 'escritos/crear', 'class' => 'form-horizontal', 'role' => 'form')) }}

    {{ Form::hidden('expediente_id', Session::get('expediente_id'), array('id' => 'expediente_id', 'class' => 'form-control')) }}

    <div class="form-group">
        {{ Form::label('titulo', 'T&iacute;tulo', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-30">
            {{ Form::text('titulo', Input::old('titulo'), array('class' => 'form-control texto_largo')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('cuerpo', 'Cuerpo', array('class' => 'col-sm-2 col-sm-2-10 control_form_label')) }}
        <div class="col-sm-10 col-sm-10-85">
            {{ Form::textarea('cuerpo', Input::old('cuerpo'), 
                array('class' => 'form-control texto_largo', 'id' => 'cuerpo', 'cols'=>'300','rows'=>'8')) }}
            <script type="text/javascript">
                CKEDITOR.replace( 'cuerpo' );
            </script>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2">
            {{ Form::submit('Confirmar', array('class' => 'btn btn-default')) }}
            {{ Form::button('Cancelar', array('class'=>'btn btn-default', 
                'onClick' => "location.href='/escritos/index/$exped_id'")) }}
        </div>
    </div>

    {{ Form::close() }}

</div>    

@stop
