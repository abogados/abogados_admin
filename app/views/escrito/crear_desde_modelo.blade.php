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

    {{ Form::open(array('url' => 'escritos/crear_desde_modelo', 'class' => 'form-horizontal', 'role' => 'form')) }}

    {{ Form::hidden('expediente_id', Session::get('expediente_id'), array('id' => 'expediente_id', 'class' => 'form-control')) }}

    <div class="form-group">
        <div id="tipos_procesos_contenedor">
          {{ Form::label('tipo_proceso','Tipo de Proceso',array('id'=>'','class'=>'col-sm-2 col-sm-2-10 control_form_label')) }}
          <div class="col-sm-10 col-sm-10-30">
              {{ Form::select('tipo_proceso',
                  array(''=>'Seleccione...'), null, array('class' => 'form-control', 'onchange' => 'tipo_proceso_onchange(this.value)')) }}
          </div>
        </div>

        <div id="modelos_contenedor">
            {{ Form::label('modelo_id','Modelo',array('id'=>'','class'=>'col-sm-2 col-sm-2-10 control_form_label')) }}
            <div class="col-sm-10 col-sm-10-30">
                {{ Form::select('modelo_id',
                array(''=>'Seleccione...'), null, array('class' => 'form-control')) }}
            </div>
        </div>
    </div>

    <div id='codigos_contenedor' class='codigos_contenedor'></div>

    <div id='escrito_generado' class='codigos_contenedor'></div>

    <div class="form-group">
        <div class="col-sm-offset-2">
            {{ Form::submit('Confirmar', array('class' => 'btn btn-default', 'id' => 'btnConfirmar')) }}
            {{ Form::button('Cancelar', array('class'=>'btn btn-default', 
                'onClick' => "location.href='/escritos/index/$exped_id'")) }}
        </div>
    </div>

    {{ Form::close() }}

</div>

{{ HTML::script('javascript/escritos.js')}}

<script type="text/javascript">

init();
tipos_procesos_cargar();

</script>

@stop
