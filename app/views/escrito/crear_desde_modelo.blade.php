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
                    ), null, array('class' => 'form-control', 'onchange' => 'tipo_proceso_onchange(this.value)')) }}
        </div>

        <div id="modelos_contenedor">
            {{ Form::label('modelo_id','Modelo',array('id'=>'','class'=>'col-sm-2 col-sm-2-10 control_form_label')) }}
            <div class="col-sm-10 col-sm-10-30">
                {{ Form::select('modelo_id',
                array(''=>'Seleccione...'), null, array('class' => 'form-control')) }}
            </div>
        </div>
    </div>

    <div id='codigos_contenedor'></div>

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

<script type="text/javascript">
// Select Tipo Proceso
function tipo_proceso_onchange(tipo_proceso){
    var tipo_proceso_input = tipo_proceso;

    $.ajax({
        url: '/escritos/buscar_modelos_listado',
        type: 'POST',
        data: {tipo_proceso: tipo_proceso_input},
        dataType: 'JSON',
        beforeSend: function() {
           $("#modelos_contenedor").html('Buscando Modelos...');
        },
        error: function() {
           $("#modelos_contenedor").html('<div> Ha surgido un error al intentar obtener los Modelos. </div>');
        },
        success: function(respuesta) {
           if (respuesta) {
              $("#modelos_contenedor").html(respuesta);
           } else {
              $("#modelos_contenedor").html('<div> No hay ningún Modelo para ese Tipo de Proceso. </div>');
           }
        }
     });
}

//Select Modelos
function modelo_id_onchange(modelo_id){
    //var info = new Array();
    var modelo_id_input     = modelo_id;
    var tipo_proceso_input  = $("#tipo_proceso").val();

    $.ajax({
        url: '/escritos/buscar_modelo_codigos',
        type: 'POST',
        data: {modelo_id:modelo_id_input, tipo_proceso:tipo_proceso_input},
        dataType: 'JSON',
        beforeSend: function() {
           $("#codigos_contenedor").html('Buscando Còdigos...');
        },
        error: function() {
           $("#codigos_contenedor").html('<div> Ha surgido un error al intentar obtener los Còdigos del Modelo. </div>');
        },
        success: function(respuesta) {
           if (respuesta) {
              $("#codigos_contenedor").html(respuesta);
           } else {
              $("#codigos_contenedor").html('<div> No hay ningún Còdigo disponible para ese Modelo. </div>');
           }
        }
     });
}

</script>

@stop
